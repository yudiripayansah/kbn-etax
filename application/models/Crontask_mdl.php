<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Crontask_mdl extends CI_Model {
	
  public function __construct() {
    parent::__construct();
  }
	
	function get_download_ref($ref) {
		$jenis_trx = $ref;
		$scheduler = $this->db->from('SIMTAX_LAST_PROCESS')->where('TRANSACTION_MODUL', 'SCHEDULER_'.$ref)->get()->row();

		if(!empty($scheduler)){
			$paramdate = $scheduler->DATE_PROCESS;
			$date_ref   = date("Y-m-d",strtotime($paramdate));
			$tanggal = date("d",strtotime($date_ref));
			$tanggal = ltrim($tanggal, "0"); 
			$bulan = date("m",strtotime($date_ref));
			$bulan = ltrim($bulan, "0"); 
			$tahun = date("Y",strtotime($date_ref));
		} else {
			$error = $this->db->error();
			$this->db->set('STATUS', $error, FALSE);
			$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$ref);
			$this->db->update('SIMTAX_LAST_PROCESS');
			return false;
		}

		$DBEBS = $this->load->database('devnew',TRUE);
		
		$PARAMETER_1 = $bulan;
		$PARAMETER_2 = $tahun;
		$PARAMETER_3 = $tanggal;
		$PARAMETER_4 = "";
		$PARAMETER_5 = $jenis_trx;
		
		$OUT_MESSAGE = "";
		$stid = oci_parse($DBEBS->conn_id, 'BEGIN :OUT_MESSAGE := SIMTAX_PAJAK_UTILITY_PKG.getPPh23(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3, :PARAMETER_4,:PARAMETER_5); end;');

		oci_bind_by_name($stid, ':PARAMETER_1',  $PARAMETER_1,200);
		oci_bind_by_name($stid, ':PARAMETER_2',  $PARAMETER_2,200);
		oci_bind_by_name($stid, ':PARAMETER_3',  $PARAMETER_3,200);
		oci_bind_by_name($stid, ':PARAMETER_4',  $PARAMETER_4,200);
		oci_bind_by_name($stid, ':PARAMETER_5',  $PARAMETER_5,200);
		oci_bind_by_name($stid, ':OUT_MESSAGE',  $OUT_MESSAGE ,100, SQLT_CHR);

		if(oci_execute($stid)){
		  $results = $OUT_MESSAGE;
		}
		
		oci_free_statement($stid);
		oci_close($DBEBS->conn_id);

		if ($results==0) {
			$error = $this->db->error();
			$this->db->set('STATUS', $error, FALSE);
			$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$ref);
			$this->db->update('SIMTAX_LAST_PROCESS');
			return false;
		}
		else {			
			//data lama dianggap tidak valid 
			$sql2	="update simtax_getdata_history
					   set REPLACE_BY_CONC_REQ_ID = '".$results."', LAST_UPDATE_DATE = sysdate, LAST_UPDATE_BY = 'cron'
						 , IMPORT_TO_SIMTAX_FLAG = 'Y' 
					 where parameter1 = '".$bulan."'
					   and parameter2 = '".$tahun."'
					   and parameter5 = '".$jenis_trx."'
					   and IMPORT_TO_SIMTAX_FLAG = 'N'
					";   			
			$query2	= $this->db->query($sql2);	

			//insert new data
			$sql2	="insert into SIMTAX_GETDATA_HISTORY
					  (GETDATA_ID,CONCURRENT_REQUEST_ID,REQUESTED_DATE,PARAMETER1,PARAMETER2,
					   PARAMETER3,PARAMETER4,PARAMETER5,IMPORT_TO_SIMTAX_DATE,IMPORT_TO_SIMTAX_FLAG,CREATION_DATE,CREATED_BY)
					  values
					  (SIMTAX_GETDATA_HISTORY_S.nextval,".$results.",sysdate,'".$bulan."','".$tahun."',
					  NULL,NULL,'".$jenis_trx."',NULL, 'N',sysdate,'cron')
					  ";
			
			$query2	= $this->db->query($sql2);			

			return true;
		}
		
	}

  function do_process_ref($file_path,$jenis_trx) {
	    $this->load->helper('djp_helper');
		$row = 0;
		$handle = fopen($file_path, "r");
		
		$dataCsv  = array();

		if ($jenis_trx == "CUSTOMER") 
		{
			$userdjp = get_value_param("USERNAME_DJP");
			$passdjp = get_value_param("PASSWORD_DJP");
			$token = djp_get_token($userdjp, $passdjp);
			
			if(empty($token)){
				return false;
			}

			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){

					$npwp = preg_replace('/[^0-9]/', '', $data[4]);
					$check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $data[4])->count_all_results();
					$latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
					$npwp_djp = null;
					$kswp_djp = null;
					$type = '';	

					if ($check_npwp < 1) {
						$isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $data[4])->limit(1)->get()->row();
						$type = $jenis_trx;
						$npwp_djp = djp_check_npwp($token->message, $npwp);
						$kswp_djp = djp_check_kswp($token->message, $npwp);
						$dataWp = $npwp_djp->message->datawp;
						$status_kswp = '-';
						if ($kswp_djp->status == 200) {
							$status_kswp = $kswp_djp->message->status;
						}
						$rowData = array(
							'ID' => ($latest_npwp->ID+1),
							'NPWP' => ($dataWp->NPWP && is_numeric($dataWp->NPWP)) ? $dataWp->NPWP : '-',
							'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
							'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
							'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
							'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
							'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
							'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
							'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
							'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
							'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
							'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
							'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
							'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
							'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
							'STATUS_KSWP' => $status_kswp,
							'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
							'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
							'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
							'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
							'USER_TYPE' => $type,
							'NPWP_SIMTAX' => $data[4],
							'LAST_UPDATE' => date('Y-m-d H:i:s'),
							'NAMA_SIMTAX' => $data[1],
							'ALAMAT_SIMTAX' => $data[9],
						);
						$doInsert = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
					} else {
						$isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $data[4])->limit(1)->get()->row();
						$type = 'CUSTOMER';

						$npwp_simtax = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $data[4])->get()->row();
						$npwp_djp = djp_check_npwp($token->message, $npwp);
						$kswp_djp = djp_check_kswp($token->message, $npwp);
						$dataWp = $npwp_djp->message->datawp;
						$status_kswp = '-';
						if ($kswp_djp->status == 200) {
							$status_kswp = $kswp_djp->message->status;
						}
						$rowData = array(
							'NPWP' => ($dataWp->NPWP && is_numeric($dataWp->NPWP)) ? $dataWp->NPWP : '-',
							'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
							'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
							'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
							'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
							'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
							'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
							'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
							'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
							'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
							'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
							'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
							'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
							'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
							'STATUS_KSWP' => $status_kswp,
							'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
							'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
							'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
							'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
							'USER_TYPE' => $type,
							'NPWP_SIMTAX' => $data[4],
							'LAST_UPDATE' => date('Y-m-d H:i:s'),
							'NAMA_SIMTAX' => $data[1],
							'ALAMAT_SIMTAX' => $data[9],
						);
						$doUpdate = $this->db->where('ID', $npwp_simtax->ID)->update('SIMTAX_MASTER_NPWP', $rowData);
					}
					
					$sql	="MERGE INTO simtax_master_pelanggan smp
							  USING (SELECT '".$data[0]."' as CUSTOMER_ID,
											'".$data[1]."' as CUSTOMER_NAME,
											'".$data[2]."' as ALIAS_CUSTOMER,
											'".$data[3]."' as CUSTOMER_NUMBER,
											'".$data[4]."' as NPWP,
											'".$data[5]."' as OPERATING_UNIT,
											'".$data[6]."' as CUSTOMER_SITE_ID,
											'".$data[7]."' as CUSTOMER_SITE_NUMBER,
											'".$data[8]."' as CUSTOMER_SITE_NAME,
											'".$data[9]."' as ADDRESS_LINE1,
											'".$data[10]."' as ADDRESS_LINE2,
											'".$data[11]."' as ADDRESS_LINE3,
											'".$data[12]."' as CITY,
											'".$data[13]."' as PROVINCE,
											'".$data[14]."' as COUNTRY,
											'".$data[15]."' as ZIP,
											'".$data[16]."' as ORGANIZATION_ID,
											'".$data[17]."' as CUST_ACCT_SITE_ID
									 FROM dual) b
							  ON (smp.CUSTOMER_ID = b.CUSTOMER_ID 
							      and smp.CUSTOMER_SITE_ID = b.CUSTOMER_SITE_ID
								  and smp.ORGANIZATION_ID = b.ORGANIZATION_ID
								  and smp.CUST_ACCT_SITE_ID = b.CUST_ACCT_SITE_ID)
							  WHEN MATCHED THEN
								UPDATE SET
									 CUSTOMER_NAME          = b.CUSTOMER_NAME
									,ALIAS_CUSTOMER         = b.ALIAS_CUSTOMER
									,CUSTOMER_NUMBER        = b.CUSTOMER_NUMBER
									,NPWP	                = b.NPWP
									,OPERATING_UNIT	        = b.OPERATING_UNIT
									,CUSTOMER_SITE_NUMBER   = b.CUSTOMER_SITE_NUMBER
									,CUSTOMER_SITE_NAME	    = b.CUSTOMER_SITE_NAME
									,ADDRESS_LINE1	        = b.ADDRESS_LINE1
									,ADDRESS_LINE2	        = b.ADDRESS_LINE2
									,ADDRESS_LINE3	        = b.ADDRESS_LINE3
									,CITY	                = b.CITY
									,PROVINCE	            = b.PROVINCE
									,COUNTRY	            = b.COUNTRY
									,ZIP	                = b.ZIP								
							  WHEN NOT MATCHED THEN
								INSERT (CUSTOMER_ID
										,CUSTOMER_NAME
										,ALIAS_CUSTOMER
										,CUSTOMER_NUMBER
										,NPWP
										,OPERATING_UNIT
										,CUSTOMER_SITE_ID
										,CUSTOMER_SITE_NUMBER
										,CUSTOMER_SITE_NAME
										,ADDRESS_LINE1
										,ADDRESS_LINE2
										,ADDRESS_LINE3
										,CITY
										,PROVINCE
										,COUNTRY
										,ZIP
										,ORGANIZATION_ID
										,CUST_ACCT_SITE_ID
										)
								VALUES (b.CUSTOMER_ID
										,b.CUSTOMER_NAME
										,b.ALIAS_CUSTOMER
										,b.CUSTOMER_NUMBER
										,b.NPWP
										,b.OPERATING_UNIT
										,b.CUSTOMER_SITE_ID
										,b.CUSTOMER_SITE_NUMBER
										,b.CUSTOMER_SITE_NAME
										,b.ADDRESS_LINE1
										,b.ADDRESS_LINE2
										,b.ADDRESS_LINE3
										,b.CITY
										,b.PROVINCE
										,b.COUNTRY
										,b.ZIP
										,b.ORGANIZATION_ID
										,b.CUST_ACCT_SITE_ID
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}
				}
				$row++;
			}
		}
		
		if ($jenis_trx == "SUPPLIER") 
		{
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){	 

					$npwp = preg_replace('/[^0-9]/', '', $data[4]);
					$check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $data[4])->count_all_results();
					$latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
					$npwp_djp = null;
					$kswp_djp = null;
					$type = '';	

					if ($check_npwp < 1) {
						$isCustomer = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $data[4])->limit(1)->get()->row();
						$type = $jenis_trx;
						$npwp_djp = djp_check_npwp($token->message, $npwp);
						$kswp_djp = djp_check_kswp($token->message, $npwp);
						$dataWp = $npwp_djp->message->datawp;
						$status_kswp = '-';
						if ($kswp_djp->status == 200) {
							$status_kswp = $kswp_djp->message->status;
						}
						$rowData = array(
							'ID' => ($latest_npwp->ID+1),
							'NPWP' => ($dataWp->NPWP && is_numeric($dataWp->NPWP)) ? $dataWp->NPWP : '-',
							'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
							'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
							'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
							'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
							'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
							'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
							'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
							'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
							'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
							'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
							'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
							'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
							'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
							'STATUS_KSWP' => $status_kswp,
							'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
							'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
							'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
							'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
							'USER_TYPE' => $type,
							'NPWP_SIMTAX' => $data[4],
							'LAST_UPDATE' => date('Y-m-d H:i:s'),
						);
						$doInsert = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
					} else {
						$isCustomer = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $data[4])->limit(1)->get()->row();
						$type = $jenis_trx;

						$npwp_simtax = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $data[4])->get()->row();
						$npwp_djp = djp_check_npwp($token->message, $npwp);
						$kswp_djp = djp_check_kswp($token->message, $npwp);
						$dataWp = $npwp_djp->message->datawp;
						$status_kswp = '-';
						if ($kswp_djp->status == 200) {
							$status_kswp = $kswp_djp->message->status;
						}
						$rowData = array(
							'NPWP' => ($dataWp->NPWP && is_numeric($dataWp->NPWP)) ? $dataWp->NPWP : '-',
							'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
							'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
							'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
							'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
							'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
							'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
							'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
							'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
							'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
							'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
							'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
							'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
							'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
							'STATUS_KSWP' => $status_kswp,
							'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
							'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
							'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
							'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
							'USER_TYPE' => $type,
							'NPWP_SIMTAX' => $data[4],
							'LAST_UPDATE' => date('Y-m-d H:i:s'),
						);
						$doUpdate = $this->db->where('ID', $npwp_simtax->ID)->update('SIMTAX_MASTER_NPWP', $rowData);
					}

					$sql	="MERGE INTO simtax_master_supplier sms
							  USING (SELECT '".$data[0]."' as VENDOR_ID,
											'".$data[1]."' as VENDOR_NAME,
											'".$data[2]."' as VENDOR_NUMBER,
											'".$data[3]."' as VENDOR_TYPE_LOOKUP_CODE,
											'".$data[4]."' as NPWP,
											'".$data[5]."' as OPERATING_UNIT,
											'".$data[6]."' as VENDOR_SITE_ID,
											'".$data[7]."' as VENDOR_SITE_CODE,
											'".$data[8]."' as ADDRESS_LINE1,
											'".$data[9]."' as ADDRESS_LINE2,
											'".$data[10]."' as ADDRESS_LINE3,
											'".$data[11]."' as CITY,
											'".$data[12]."' as PROVINCE,
											'".$data[13]."' as COUNTRY,
											'".$data[14]."' as ZIP,
											'".$data[15]."' as AREA_CODE,
											'".$data[16]."' as PHONE,
											'".$data[17]."' as ORGANIZATION_ID
									 FROM dual) b
							  ON (sms.VENDOR_ID = b.VENDOR_ID 
							  and sms.VENDOR_SITE_ID = b.VENDOR_SITE_ID
							  and sms.ORGANIZATION_ID = b.ORGANIZATION_ID)
							  WHEN MATCHED THEN
								UPDATE SET
									VENDOR_NAME         = b.VENDOR_NAME,
									VENDOR_NUMBER       = b.VENDOR_NUMBER,
									VENDOR_TYPE_LOOKUP_CODE = b.VENDOR_TYPE_LOOKUP_CODE,
									NPWP                = b.NPWP,
									OPERATING_UNIT      = b.OPERATING_UNIT,
									VENDOR_SITE_CODE    = b.VENDOR_SITE_CODE,
									ADDRESS_LINE1       = b.ADDRESS_LINE1,
									ADDRESS_LINE2       = b.ADDRESS_LINE2,
									ADDRESS_LINE3       = b.ADDRESS_LINE3,
									CITY                = b.CITY,
									PROVINCE            = b.PROVINCE,
									COUNTRY             = b.COUNTRY,
									ZIP                 = b.ZIP,
									AREA_CODE           = b.AREA_CODE,
									PHONE               = b.PHONE
							  WHEN NOT MATCHED THEN
								INSERT (VENDOR_ID
										,VENDOR_NAME
										,VENDOR_NUMBER
										,VENDOR_TYPE_LOOKUP_CODE
										,NPWP
										,OPERATING_UNIT
										,VENDOR_SITE_ID
										,VENDOR_SITE_CODE
										,ADDRESS_LINE1
										,ADDRESS_LINE2
										,ADDRESS_LINE3
										,CITY
										,PROVINCE
										,COUNTRY
										,ZIP
										,AREA_CODE
										,PHONE
										,ORGANIZATION_ID
										)
								VALUES (b.VENDOR_ID
										,b.VENDOR_NAME
										,b.VENDOR_NUMBER
										,b.VENDOR_TYPE_LOOKUP_CODE
										,b.NPWP
										,b.OPERATING_UNIT
										,b.VENDOR_SITE_ID
										,b.VENDOR_SITE_CODE
										,b.ADDRESS_LINE1
										,b.ADDRESS_LINE2
										,b.ADDRESS_LINE3
										,b.CITY
										,b.PROVINCE
										,b.COUNTRY
										,b.ZIP
										,b.AREA_CODE
										,b.PHONE
										,b.ORGANIZATION_ID
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}

				}

				$row++;
			}			
		}			
		
		return true;
  }

	function update_last_process($trxmodul,$date_ref){

		$this->db->set('DATE_PROCESS',"TO_DATE('".$date_ref."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		$this->db->where('TRANSACTION_MODUL', $trxmodul);		
		$update = $this->db->update("SIMTAX_LAST_PROCESS");

		if($update){
			return true;
		} else {
			return false;
		}
	}
		
}