<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Sync_data_ebs_mdl extends CI_Model {
	
  public function __construct() {
    parent::__construct();
  }

	function get_download_trx() {
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		$perusahaan		= $this->input->post('scrPerusahaan');
				
		$DBEBS = $this->load->database('devnew',TRUE);

		if ($jenis_trx === 'PPH21DTL') {
			$sql = "
				select nama_cabang
				from simtax_kode_cabang
				where kode_cabang = '".$kode_cabang."'";
				$qReq    	= $this->db->query($sql);
				$vrow  		= $qReq->row();
				if($vrow)
				{
					if($vrow->NAMA_CABANG != ''){
						$kode_cabang  = strtoupper($vrow->NAMA_CABANG); 
					}
				}
		}
		
		if($jenis_trx != "GLJE"){
			$PARAMETER_1 = $bulan;
			$PARAMETER_2 = $tahun;
			$PARAMETER_3 = $kode_cabang;
			$PARAMETER_4 = $perusahaan;
			$PARAMETER_5 = $jenis_trx;
		} else {
			$sqlledger   = "select * from SIMTAX_MASTER_LEDGER where ledger_id = 2022";
			$queryledger = $this->db->query($sqlledger);
			
			foreach($queryledger->result_array() as $rowledger)	{
				$kode_perusahaan	= $rowledger['LEDGER_ID'];
			}
			$PARAMETER_1 = $bulan;
			$PARAMETER_2 = $tahun;
			$PARAMETER_3 = $kode_cabang;
			$PARAMETER_4 = $kode_perusahaan;
			$PARAMETER_5 = $jenis_trx;
		}
		
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
			return false;
		}
		else {			

			//pph21dtl ubah kembali kode cabang menjadi kode
			if ($jenis_trx === 'PPH21DTL') {
				$kode_cabang	= $this->input->post('srcKodeCabang');; 
			}

			//data lama dianggap tidak valid 
			$sql2	="update simtax_getdata_history
					   set REPLACE_BY_CONC_REQ_ID = '".$results."'
						 , IMPORT_TO_SIMTAX_FLAG = 'Y' 
					 where parameter1 = '".$bulan."'
					   and parameter2 = '".$tahun."'
					   and parameter3 = '".$kode_cabang."'
					   and parameter4 = '".$perusahaan."'
					   and parameter5 = '".$jenis_trx."'
					   and IMPORT_TO_SIMTAX_FLAG = 'N'
					";   			
			$query2	= $this->db->query($sql2);	

			//insert new data
			$sql2	="insert into SIMTAX_GETDATA_HISTORY
					  (GETDATA_ID,CONCURRENT_REQUEST_ID,REQUESTED_DATE,PARAMETER1,PARAMETER2,
					   PARAMETER3,PARAMETER4,PARAMETER5,IMPORT_TO_SIMTAX_DATE,IMPORT_TO_SIMTAX_FLAG)
					  values
					  (SIMTAX_GETDATA_HISTORY_S.nextval,".$results.",sysdate,'".$bulan."','".$tahun."',
					  '".$kode_cabang."','".$perusahaan."','".$jenis_trx."',null, 'N')
					  ";
			
			$query2	= $this->db->query($sql2);			

			return true;
		}
	}

	function get_download_trx_fa($bulan) {
		$bulanfrom		= $this->input->post('srcBulanfrom');
		$bulanto		= $this->input->post('srcBulanto');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		$perusahaan		= $this->input->post('scrPerusahaan');
		
		$DBEBS = $this->load->database('devnew',TRUE);
		
		$PARAMETER_1 = $bulan;
		$PARAMETER_2 = $tahun;
		$PARAMETER_3 = $kode_cabang;
		$PARAMETER_4 = $perusahaan;
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
			return false;
		}
		else {			
			
			//data lama dianggap tidak valid 
			$sql2	="update simtax_getdata_history
					   set REPLACE_BY_CONC_REQ_ID = '".$results."'
						 , IMPORT_TO_SIMTAX_FLAG = 'Y' 
					 where parameter1 = '".$bulan."'
					   and parameter2 = '".$tahun."'
					   and parameter3 = '".$kode_cabang."'
					   and parameter4 = '".$perusahaan."'
					   and parameter5 = '".$jenis_trx."'
					   and IMPORT_TO_SIMTAX_FLAG = 'N'
					";   			
			$query2	= $this->db->query($sql2);	

			//insert new data
			$sql2	="insert into SIMTAX_GETDATA_HISTORY
					  (GETDATA_ID,CONCURRENT_REQUEST_ID,REQUESTED_DATE,PARAMETER1,PARAMETER2,
					   PARAMETER3,PARAMETER4,PARAMETER5,IMPORT_TO_SIMTAX_DATE,IMPORT_TO_SIMTAX_FLAG)
					  values
					  (SIMTAX_GETDATA_HISTORY_S.nextval,".$results.",sysdate,'".$bulan."','".$tahun."',
					  '".$kode_cabang."','".$perusahaan."','".$jenis_trx."',null, 'N')
					  ";
			
			$query2	= $this->db->query($sql2);			

			return true;
		}
		
	}
	
	function get_download_ref() {
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$jenis_trx		= $this->input->post('scrJenis');
				
		$DBEBS = $this->load->database('devnew',TRUE);
		
		$PARAMETER_1 = $bulan;
		$PARAMETER_2 = $tahun;
		$PARAMETER_3 = "";
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
			return false;
		}
		else {			
			//data lama dianggap tidak valid 
			$sql2	="update simtax_getdata_history
					   set REPLACE_BY_CONC_REQ_ID = '".$results."'
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
					   PARAMETER3,PARAMETER4,PARAMETER5,IMPORT_TO_SIMTAX_DATE,IMPORT_TO_SIMTAX_FLAG)
					  values
					  (SIMTAX_GETDATA_HISTORY_S.nextval,".$results.",sysdate,'".$bulan."','".$tahun."',
					  NULL,NULL,'".$jenis_trx."',NULL, 'N')
					  ";
			
			$query2	= $this->db->query($sql2);			

			return true;
		}
	}

	function get_download_tb() {
		set_time_limit(0);
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcAkun');
		$jenis_trx		= "TRIBAL";
		$perusahaan		= $this->input->post('srcLedger');
				
		$DBEBS = $this->load->database('devnew',TRUE);
		if ($kode_cabang != "TBGLBAL"){
			$PARAMETER_1 = $bulan;
			$PARAMETER_2 = $tahun;
			$PARAMETER_3 = $kode_cabang;
			$PARAMETER_4 = $perusahaan;
			$PARAMETER_5 = $jenis_trx;
		} else {
			$PARAMETER_1 = $bulan;
			$PARAMETER_2 = $tahun;
			$PARAMETER_3 = "";
			$PARAMETER_4 = $perusahaan;
			$PARAMETER_5 = "TBGLBAL";
		}
		
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
			return false;
		}
		else {			
			//data lama dianggap tidak valid 
			$sql2	="update simtax_getdata_history
					   set REPLACE_BY_CONC_REQ_ID = '".$results."'
						 , IMPORT_TO_SIMTAX_FLAG = 'Y' 
					 where parameter1 = '".$bulan."'
					   and parameter2 = '".$tahun."'
					   and parameter3 = '".$kode_cabang."'
					   and parameter4 = '".$perusahaan."'
					   and parameter5 = '".$jenis_trx."'
					   and IMPORT_TO_SIMTAX_FLAG = 'N'
					";   			
			$query2	= $this->db->query($sql2);	

			//insert new data
			$sql2	="insert into SIMTAX_GETDATA_HISTORY
					  (GETDATA_ID,CONCURRENT_REQUEST_ID,REQUESTED_DATE,PARAMETER1,PARAMETER2,
					   PARAMETER3,PARAMETER4,PARAMETER5,IMPORT_TO_SIMTAX_DATE,IMPORT_TO_SIMTAX_FLAG)
					  values
					  (SIMTAX_GETDATA_HISTORY_S.nextval,".$results.",sysdate,'".$bulan."','".$tahun."',
					  '".$kode_cabang."','".$perusahaan."','".$jenis_trx."',null, 'N')
					  ";
			
			$query2	= $this->db->query($sql2);			

			return true;
		}
	}	

  function do_process_trx($file_path,$ConcReqId,$jenis_trx='') {		
		$row = 0;
		$handle = fopen($file_path, "r");
		$user_name = $this->session->userdata('identity');		
		$dataCsv  = array();
		$vPeriod = "";

		if($jenis_trx === 'GLJE'){
				$bulan				= $this->input->post('srcBulan');
				$tahun				= $this->input->post('srcTahun');	
				$kode_cabang		= $this->input->post('srcKodeCabang');
				$kode_perusahaan	= "";

				$sqlledger   = "select * from SIMTAX_MASTER_LEDGER where ledger_id = 2022";
				$queryledger = $this->db->query($sqlledger);
				
				foreach($queryledger->result_array() as $rowledger)	{
					$kode_perusahaan	= $rowledger['LEDGER_ID'];
				}
				$ledger		= $kode_perusahaan;
				$sqlDel	="	
				delete from simtax_detail_jurnal_transaksi
					where tahun_buku = ".$tahun."
						and bulan_buku = ".$bulan."
						and ledger_id = '".$ledger."'
						and kode_cabang = '".$kode_cabang."'";	
				$this->db->query($sqlDel);
		}

		while (($data = fgetcsv($handle, 1000, ";","'","\\")) !== FALSE) {

			if($row >= 0){						
        if ($jenis_trx != 'FAFISKAL' && $jenis_trx != 'APBONUS' && $jenis_trx != 'SPPD' && $jenis_trx != 'GLJE') {

			//pph2326 get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPH2326')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPH2326

			//PPH15 get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPH15')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPH15

			//PPH22 get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPH22')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPH22

			//PPH22 get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPH4_2')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPH4_2

			//PPNWAPU get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPNWAPU')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPNWAPU

			//PPNMASUK get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPNMASUK')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPNMASUK

			//PPNKELUAR get npwp dan alamat dari master supplier
			if($jenis_trx === 'PPNKELUAR')
			{
				if ($data[16] != '')
				{
					$sql = "
					select npwp, address_line1
					from simtax_master_supplier
					where vendor_id = ".$data[16];
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->ADDRESS_LINE1 != ''){
							$data[25]  = $vrow->ADDRESS_LINE1; 
						}
						if($vrow->NPWP != ''){
							$data[26]  = $vrow->NPWP; 
						}
					}	
				}
			}
			// end PPNKELUAR

          $sql	="insert into SIMTAX_STAGING_PAJAK 
              (STAGING_PAJAK_ID
              ,OU_NAME
              ,ORGANIZATION_ID
              ,INVOICE_NUM
              ,INVOICE_ID
              ,INVOICE_LINE_NUM
              ,INVOICE_ACCOUNTING_DATE
              ,NO_FAKTUR_PAJAK
              ,TANGGAL_FAKTUR_PAJAK
              ,KODE_PAJAK
              ,KODE_COMPANY
              ,KODE_CABANG
              ,AKUN_PAJAK
              ,AMOUNT_PAJAK
              ,DESCRIPTION
              ,INVOICE_DISTRIBUTION_ID
              ,AMOUNT_DPP
              ,VENDOR_ID
              ,DPP_AMOUNT_EDI
              ,AWT_FLAG
              ,NAMA_PAJAK
              ,TAX_RATE
              ,SOURCE_DATA
              ,PROCESS_FLAG
              ,ERROR_MESSAGE
              ,NAMA_WP
              ,ALAMAT_WP
              ,NPWP
              ,DPP_BASE_AMOUNT
              ,TAX_BASE_AMOUNT
              ,INVOICE_CURRENCY_CODE
              ,INVOICE_RATE
              ,TAX_CCID
              ,SEGMENT4
              ,SEGMENT4_DESC
              ,CUSTOMER_TRX_ID
              ,TRX_NUMBER
              ,CUST_TRX_LINE_GL_DIST_ID
              ,PARTY_ID
              ,PERSON_ID
              ,NO_BUKTI_POTONG
              ,TIPE_21
              ,TGL_BUKTI_POTONG
              ,BULAN_PAJAK
              ,TAHUN_PAJAK
              ,MASA_PAJAK
              ,NPWP_PEMOTONG
              ,NAMA_PEMOTONG
              ,WPLUARNEGERI
              ,KODE_NEGARA
              ,VENDOR_SITE_ID
              ,SALDO_AWAL
              ,MUTASI_DEBIT
              ,MUTASI_CREDIT
              ,REQUEST_ID
              ,CREATION_DATE
              ,CREATED_BY
              ) 
              VALUES
              (simtax_staging_pajak_s.nextval,
              '".$data[0]."',
              '".$data[1]."',
              '".$data[2]."',
              '".$data[3]."',
              '".$data[4]."',
              ".$data[5].",
              '".$data[6]."',
              ".$data[7].",
              '".$data[8]."',
              '".$data[9]."',
              '".$data[10]."',
              '".$data[11]."',
              '".$data[12]."',
              '".$data[13]."',
              '".$data[14]."',
              '".$data[15]."',
              '".$data[16]."',
              '".$data[17]."',
              '".$data[18]."',
              '".$data[19]."',
              '".$data[20]."',	
              '".$data[21]."',
              '".$data[22]."',
              '".$data[23]."',
              '".$data[24]."',
              '".$data[25]."',
              '".$data[26]."',
              '".(isset($data[27])?$data[27]:'')."',
              '".(isset($data[28])?$data[28]:'')."',
              '".(isset($data[29])?$data[29]:'')."',
              '".(isset($data[30])?$data[30]:'')."',	
              '".(isset($data[31])?$data[31]:'')."',
              '".(isset($data[32])?$data[32]:'')."',
              '".(isset($data[33])?$data[33]:'')."',
              '".(isset($data[34])?$data[34]:'')."',
              '".(isset($data[35])?$data[35]:'')."',
              '".(isset($data[36])?$data[36]:'')."',
              '".(isset($data[37])?$data[37]:'')."',
              '".(isset($data[38])?$data[38]:'')."',
              '".(isset($data[39])?$data[39]:'')."',
              '".(isset($data[40])?$data[40]:'')."',
              ".(isset($data[41])?$data[41]:'').",
              '".(isset($data[42])?$data[42]:'')."',
              '".(isset($data[43])?$data[43]:'')."',
              '".(isset($data[44])?$data[44]:'')."',
              '".(isset($data[45])?$data[45]:'')."',
              '".(isset($data[46])?$data[46]:'')."',
              '".(isset($data[47])?$data[47]:'')."',
              '".(isset($data[48])?$data[48]:'')."',
              '".(isset($data[49])?$data[49]:'')."',
              '".(isset($data[50])?$data[50]:'')."',
              '".(isset($data[51])?$data[51]:'')."',
              '".(isset($data[52])?$data[52]:'')."',
              '".$ConcReqId."',
              SYSDATE,
              '".$user_name."'
              )";
        } else {
			if ($jenis_trx === 'FAFISKAL') 
			{
				
				if ($data[0] == 'Harta Tidak Berwujud') {
					$data[0] = 'T';
				} else 
				if ($data[0] == 'Harta Berwujud Bukan Bangungan') {
					$data[0] = 'N';
				} else  {
					$data[0] = 'B';
				}
				$sql = "
					select kode_cabang
					from simtax_kode_cabang
					where nama_cabang = '".$data[1]."'";
				$data[1] = $this->db->query($sql)->row()->KODE_CABANG;	
				
				$exp = explode('-',$data[21]);
				$masa = $exp[0];
				switch ($exp[0]) {
					case 'JAN' : 
					$bulan = 1;
					break;
					case 'FEB' : 
					$bulan = 2;
					break;
					case 'MAR' : 
					$bulan = 3;
					break;
					case 'APR' : 
					$bulan = 4;
					break;
					case 'MAY' : 
					$bulan = 5;
					break;
					case 'JUN' : 
					$bulan = 6;
					break;
					case 'JUL' : 
					$bulan = 7;
					break;
					case 'AUG' : 
					$bulan = 8;
					break;
					case 'SEP' : 
					$bulan = 9;
					break;
					case 'OCT' : 
					$bulan = 10;
					break;
					case 'NOV' : 
					$bulan = 11;
					break;
					case 'DEC' : 
					$bulan = 12;
					break;
					default :
					$bulan = 1;
					break;
				}
				$dt = DateTime::createFromFormat('y', $exp[1]);
				$tahun = $dt->format('Y');

				//cek existing period by Bulan, masa, tahun, nama pasal, pembetulan ke
				$sqlperiod = "select nvl(max(period_id),0) vperiod_id
				from simtax_master_period
			   	where upper(nama_pajak) = 'FIXED ASSET'
				 and bulan_pajak = ".$bulan."
				 and tahun_pajak = ".$tahun."
				 and kode_cabang = '".$data[1]."'
				 and pembetulan_ke = 0";

				$qPeriod    = $this->db->query($sqlperiod);	
				$rowPeriod  = $qPeriod->row();
				$vPeriod  	= $rowPeriod->VPERIOD_ID; 
				
				//insert when period 0
				if ($vPeriod > 0){
				} else {
					$sqlIns = "insert into simtax_master_period(PERIOD_ID
					,PEMBETULAN_KE
					,NAMA_PAJAK
					,MASA_PAJAK
					,BULAN_PAJAK
					,TAHUN_PAJAK
					,STATUS
					,KODE_CABANG)
			 		values(simtax_master_period_s.nextval
					, 0
					,'FIXED ASSET'
					,'".$masa."'
					,".$bulan."
					,".$tahun."
					,'Open'
					,'".$data[1]."'
					)";
					$qIns 	= $this->db->query($sqlIns);
					if($qIns){
						$sqlperiod = "select nvl(max(period_id),0) vperiod_id
							from simtax_master_period
							where upper(nama_pajak) = 'FIXED ASSET'
							and bulan_pajak = ".$bulan."
							and tahun_pajak = ".$tahun."
							and kode_cabang = '".$data[1]."'
							and pembetulan_ke = 0";

							$qPeriod    = $this->db->query($sqlperiod);	
							$rowPeriod  = $qPeriod->row();
							$vPeriod  	= $rowPeriod->VPERIOD_ID; 
					}
		
				}

				$sqlperiod = "select nvl(max(pajak_header_id),0) vpjk_header_id
							from simtax_pajak_headers
							where NAMA_PAJAK = 'FIXED ASSET'
							and MASA_PAJAK = '".$masa."'
							and BULAN_PAJAK = ".$bulan."
							and TAHUN_PAJAK = ".$tahun."
							and KODE_CABANG = '".$data[1]."'
							and STATUS = 'DRAFT'";

							$qPjkhdr    	= $this->db->query($sqlperiod);	
							$rpjkHeader  	= $qPjkhdr->row();
							$vPjkHeaderId  	= $rpjkHeader->VPJK_HEADER_ID; 
							
				if ($vPjkHeaderId > 0){
					//do nothing
				} else {
					//delete old data before insert new header
					/*
					$sqldel ="delete from simtax_pajak_headers
					where NAMA_PAJAK = 'FIXED ASSET'
						and MASA_PAJAK = '".$masa."'
						and BULAN_PAJAK = ".$bulan."
						and TAHUN_PAJAK = ".$tahun."
						and KODE_CABANG = '".$data[1]."'
						and STATUS = 'DRAFT'";
					$qDel 	= $this->db->query($sqldel);
					*/
					//insert pajak header
						$sqlInspHeader = "insert into simtax_pajak_headers
						(PAJAK_HEADER_ID
						,CREATED_BY
						,CREATION_DATE
						,USER_NAME
						,NAMA_PAJAK
						,MASA_PAJAK
						,BULAN_PAJAK
						,TAHUN_PAJAK
						,KODE_CABANG
						,STATUS
						,PERIOD_ID
						) values
						(
						SIMTAX_PAJAK_HEADER_S.NEXTVAL
						,'".$user_name."'
						,sysdate
						,'".$user_name."'
						,'FIXED ASSET'
						,'".$masa."'
						,".$bulan."
						,".$tahun."
						,'".$data[1]."'
						,'DRAFT'
						,".$vPeriod."
						)";
						$qInsHeader = $this->db->query($sqlInspHeader);	
						$sqlperiod = "select nvl(max(pajak_header_id),0) vpjk_header_id
							from simtax_pajak_headers
							where NAMA_PAJAK = 'FIXED ASSET'
							and MASA_PAJAK = '".$masa."'
							and BULAN_PAJAK = ".$bulan."
							and TAHUN_PAJAK = ".$tahun."
							and KODE_CABANG = '".$data[1]."'
							and STATUS = 'DRAFT'";

							$qPjkhdr    	= $this->db->query($sqlperiod);	
							$rpjkHeader  	= $qPjkhdr->row();
							$vPjkHeaderId  	= $rpjkHeader->VPJK_HEADER_ID; 
				}

				$sql	="MERGE INTO simtax_rekon_fixed_asset srfa
							  USING (SELECT '".$data[0]."' as KELOMPOK_FIXED_ASSET,
											'".$data[1]."' as KODE_CABANG,
											'".$data[2]."' as JENIS_AKTIVA,
											'".$data[3]."' as ASSET_NO,
											'".str_replace("'", "", $data[4])."' as NAMA_AKTIVA,
											'".$data[5]."' as KETERANGAN,
											'".$data[6]."' as TANGGAL_BELI,
											'".$data[7]."' as HARGA_PEROLEHAN,
											'".$data[8]."' as KELOMPOK_AKTIVA,
											'".$data[9]."' as JENIS_USAHA,
											'".$data[10]."' as JENIS_HARTA,
											'".$data[11]."' as STATUS_PEMBEBANAN,
											'".$data[12]."' as TANGGAL_JUAL,
											'".$data[13]."' as HARGA_JUAL,
											'".$data[14]."' as PH_FISKAL,
											'".$data[15]."' as AKUMULASI_PENYUSUTAN,
											'".$data[16]."' as NSBF,
											'".$data[17]."' as PENYUSUTAN_FISKAL,
											'".$data[18]."' as PEMBEBANAN,
											'".$data[19]."' as AKUMULASI_PENYUSUTAN_FISKAL,
											'".$data[20]."' as NILAI_SISA_BUKU_FISKAL,
											'".$bulan."' as BULAN_PAJAK,
											'".$tahun."' as TAHUN_PAJAK,
											'".$masa."' as MASA_PAJAK,
											0 as PEMBETULAN_KE,
											1 as IS_CHECKLIST, 
											".$vPjkHeaderId." as PAJAK_HEADER_ID
									 FROM dual) b
							  ON (srfa.ASSET_NO = b.ASSET_NO 
							      and srfa.KODE_CABANG = b.KODE_CABANG
								  and srfa.BULAN_PAJAK = b.BULAN_PAJAK
								  and srfa.TAHUN_PAJAK = b.TAHUN_PAJAK
								  )
							  WHEN MATCHED THEN
								UPDATE SET
									 KELOMPOK_FIXED_ASSET       = b.KELOMPOK_FIXED_ASSET
									,JENIS_AKTIVA         		= b.JENIS_AKTIVA
									,NAMA_AKTIVA        		= b.NAMA_AKTIVA
									,KETERANGAN	                = b.KETERANGAN
									,TANGGAL_BELI	        	= b.TANGGAL_BELI
									,HARGA_PEROLEHAN   			= b.HARGA_PEROLEHAN
									,JENIS_USAHA	    		= b.JENIS_USAHA
									,JENIS_HARTA	        	= b.JENIS_HARTA
									,STATUS_PEMBEBANAN	        = b.STATUS_PEMBEBANAN
									,TANGGAL_JUAL	        	= b.TANGGAL_JUAL
									,HARGA_JUAL	                = b.HARGA_JUAL
									,PH_FISKAL	            	= b.PH_FISKAL
									,AKUMULASI_PENYUSUTAN	    = b.AKUMULASI_PENYUSUTAN
									,NSBF	                	= b.NSBF	
									,PENYUSUTAN_FISKAL	        = b.PENYUSUTAN_FISKAL
									,PEMBEBANAN	                = b.PEMBEBANAN
									,AKUMULASI_PENYUSUTAN_FISKAL	= b.AKUMULASI_PENYUSUTAN_FISKAL
									,NILAI_SISA_BUKU_FISKAL	    = b.NILAI_SISA_BUKU_FISKAL			
							  WHEN NOT MATCHED THEN
								INSERT (
										KELOMPOK_FIXED_ASSET
										,KODE_CABANG
										,JENIS_AKTIVA
										,ASSET_NO
										,NAMA_AKTIVA
										,KETERANGAN
										,TANGGAL_BELI
										,HARGA_PEROLEHAN
										,KELOMPOK_AKTIVA
										,JENIS_USAHA
										,JENIS_HARTA
										,STATUS_PEMBEBANAN
										,TANGGAL_JUAL
										,HARGA_JUAL
										,PH_FISKAL
										,AKUMULASI_PENYUSUTAN
										,NSBF
										,PENYUSUTAN_FISKAL
										,PEMBEBANAN
										,AKUMULASI_PENYUSUTAN_FISKAL
										,NILAI_SISA_BUKU_FISKAL
										,BULAN_PAJAK
										,TAHUN_PAJAK
										,MASA_PAJAK
										,PEMBETULAN_KE
										,IS_CHECKLIST
										,PAJAK_HEADER_ID
										)
								VALUES (
										b.KELOMPOK_FIXED_ASSET,
										b.KODE_CABANG,
										b.JENIS_AKTIVA,
										b.ASSET_NO,
										b.NAMA_AKTIVA,
										b.KETERANGAN,
										b.TANGGAL_BELI,
										b.HARGA_PEROLEHAN,
										b.KELOMPOK_AKTIVA,
										b.JENIS_USAHA,
										b.JENIS_HARTA,
										b.STATUS_PEMBEBANAN,
										b.TANGGAL_JUAL,
										b.HARGA_JUAL,
										b.PH_FISKAL,
										b.AKUMULASI_PENYUSUTAN,
										b.NSBF,
										b.PENYUSUTAN_FISKAL,
										b.PEMBEBANAN,
										b.AKUMULASI_PENYUSUTAN_FISKAL,
										b.NILAI_SISA_BUKU_FISKAL,
										b.BULAN_PAJAK,
										b.TAHUN_PAJAK,
										b.MASA_PAJAK,
										b.PEMBETULAN_KE,
										b.IS_CHECKLIST, 
										b.PAJAK_HEADER_ID
										)";
										
			} 
			
			if ($jenis_trx === 'APBONUS') 
			{ 
				
				$sql	=" 
					select count(*) cnt_periodyear
				     from simtax_beban_bonus
					 where  period_year = ".$data[0]."
					 and cabang = '".$data[1]."'
					 and invoice_num = '".$data[3]."'
					 and is_proses_ulang = 'N'
				";

				$qReqthn    = $this->db->query($sql);
				$rowbns        = $qReqthn->row();
				$VThn  		= $rowbns->CNT_PERIODYEAR;  
   	
				if($VThn > 0){
					$sql = "select period_year from simtax_beban_bonus where period_year= ".$data[0];
				} else {
					$sql = "
					insert into simtax_beban_bonus (
					PERIOD_YEAR
					,CABANG
					,JENIS_BONUS
					,INVOICE_NUM
					,INVOICE_AMOUNT
					,IS_PROSES_ULANG
					)
					values 
					(
					".$data[0]."
					,'".$data[1]."'
					,'".$data[2]."'
					,'".$data[3]."'
					,".$data[4].",
					'N'
					)";
				}
				
			}

			if ($jenis_trx === 'SPPD') 
			{ 
				if ($data[0] != '')
				{
					$sql = "
					select kode_cabang
					from simtax_kode_cabang
					where nama_cabang = '".$data[0]."'";
					$qReq    	= $this->db->query($sql);
					$vrow  		= $qReq->row();
					if($vrow)
					{
						if($vrow->KODE_CABANG != ''){
							$data[0]  = $vrow->KODE_CABANG; 
						}
					}	
				}

				
				$sql	=" 
					select count(*) cnt_sppd
				     from simtax_sppd
					 where  kode_cabang = '".$data[0]."'
					 and org_id = '".$data[1]."'
					 and kode_puspel = '".$data[2]."'
					 and kode_akun = '".$data[4]."'
					 and period_year = ".$data[6]."	
				";

				$qReqsppd    = $this->db->query($sql);
				$rowsppd        = $qReqsppd->row();
				$Vsppd  		= $rowsppd->CNT_SPPD;  
   	
				if($Vsppd > 0){
					$sql = "update simtax_sppd set
										KODE_CABANG         = '".$data[0]."'
										,ORG_ID         	= '".$data[1]."'
										,KODE_PUSPEL        = '".$data[2]."'
										,DESKRIPSI_PUSPEL	= '".$data[3]."'
										,KODE_AKUN	        = '".$data[4]."'
										,DESKRIPSI_AKUN   	= '".$data[5]."'
										,PERIOD_YEAR	    = ".$data[6]."
										,UANG_SAKU	    	= ".$data[7]."
										
							where kode_cabang = '".$data[0]."'
							and org_id 		= '".$data[1]."'
							and kode_puspel = '".$data[2]."'	
							and kode_akun 	= '".$data[4]."'	
							and period_year = ".$data[6]."	
					";

				} else {
					
						$sql = "
						insert into simtax_sppd (
						KODE_CABANG
						,ORG_ID
						,KODE_PUSPEL
						,DESKRIPSI_PUSPEL
						,KODE_AKUN
						,DESKRIPSI_AKUN
						,PERIOD_YEAR
						,UANG_SAKU
						)
						values 
						(
						'".$data[0]."'
						,'".$data[1]."'
						,'".$data[2]."'
						,'".$data[3]."'
						,'".$data[4]."'
						,'".$data[5]."'
						,".$data[6]."
						,".$data[7]."
						)";
					
				}

			}

			if ($jenis_trx === 'GLJE') 
			{ 
				$sql = " insert into simtax_detail_jurnal_transaksi (
					LEDGER_ID, 
					PERIOD_NAME, 
					USER_JE_SOURCE_NAME, 
					DOCNUMBER, 
					NOMOR_FAKTUR, 
					BULAN_BUKU, 
					TAHUN_BUKU, 
					TANGGALPOSTING, 
					DESCJENISTRANSAKSI, 
					LINENO, 
					ACCOUNT, 
					DESCACCOUNT, 
					AMOUNT, 
					SUBLEDGER, 
					CODESUBLEDGER, 
					DESCSUBLEDGER, 
					DESCRIPTIONHEADER, 
					REFERENCELINE, 
					PROFITCENTER, 
					PROFITCENTERDESC, 
					COSTCENTER, 
					COSTCENTERDESC, 
					PONUMBER, 
					TANGGALPO, 
					KODE_CABANG,
					NOMORINVOICE,
					TANGGALINVOICE,
					STATUSDOKUMEN,
					INVOICE_ID
					)
					values 
					(
					'".$data[0]."',
					'".$data[1]."',
					'".$data[2]."',
					'".$data[3]."',
					'".$data[4]."',
					".$data[5].",
					".$data[6].",
					'".$data[7]."',
					'".$data[8]."',
					".$data[9].",
					'".$data[10]."', 
					'".$data[11]."', 
					".$data[12].",
					'".$data[13]."',  
					'".$data[14]."', 
					'".str_replace("'", "", $data[15])."', 
					'".$data[16]."', 
					'".str_replace("'", "", $data[17])."', 
					'".$data[18]."', 
					'".$data[19]."', 
					'".$data[20]."', 
					'".$data[21]."', 
					'".$data[22]."', 
					'".$data[23]."', 
					'".$data[24]."',
					'".$data[25]."',
					'".$data[26]."',
					'DRAFT',
					 ".$data[27]."
					)";
			}
        }
      try {
        $query 		= $this->db->query($sql);	
      } catch (Exception $ex) {
          return false;
      }
    }
			$row++;
		}
		return true;
  }	

  function do_process_ref($file_path,$jenis_trx) {
		$row = 0;
		$handle = fopen($file_path, "r");
		
		$dataCsv  = array();
		
		if ($jenis_trx == "CUSTOMER") 
		{
			
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){
							 
					if ($data[0] != '')
					{
						$sql = "
						select customer_id,customer_site_id,organization_id
						from simtax_master_pelanggan
						where customer_id = ".$data[0]."
						and customer_site_id = ".$data[6]."
						and organization_id = ".$data[16]
						;
						$qReq    	= $this->db->query($sql);
						$vrow  		= $qReq->row();
						if($vrow !== NULL)
						{
							if($vrow->CUSTOMER_ID != ''){
							} else {	
								$sqlins ="
								insert 
								into
								simtax_master_pelanggan
								(
								 CUSTOMER_ID
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
								)
								VALUES (
								 ".$data[0].",
								'".$data[1]."',
								'".$data[2]."',
								'".$data[3]."',
								'".$data[4]."',
								'".$data[5]."',
								 ".$data[6].",
								'".$data[7]."',
								'".$data[8]."',
								'".$data[9]."',
								'".$data[10]."',
								'".$data[11]."',
								'".$data[12]."',
								'".$data[13]."',
								'".$data[14]."',
								'".$data[15]."',
								'".$data[16]."'
								)";

								$query 	= $this->db->query($sqlins);	
								if (!$query) {
									return false;
								}
							}
						} else {
							$sqlins ="
								insert 
								into
								simtax_master_pelanggan
								(
								 CUSTOMER_ID
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
								)
								VALUES (
								 ".$data[0].",
								'".$data[1]."',
								'".$data[2]."',
								'".$data[3]."',
								'".$data[4]."',
								'".$data[5]."',
								 ".$data[6].",
								'".$data[7]."',
								'".$data[8]."',
								'".$data[9]."',
								'".$data[10]."',
								'".$data[11]."',
								'".$data[12]."',
								'".$data[13]."',
								'".$data[14]."',
								'".$data[15]."',
								'".$data[16]."'
								)";

								$query 	= $this->db->query($sqlins);	
								if (!$query) {
									return false;
								}
						}	
					} else {
						$sqlins ="
								insert 
								into
								simtax_master_pelanggan
								(
								 CUSTOMER_ID
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
								)
								VALUES (
								 ".$data[0].",
								'".$data[1]."',
								'".$data[2]."',
								'".$data[3]."',
								'".$data[4]."',
								'".$data[5]."',
								 ".$data[6].",
								'".$data[7]."',
								'".$data[8]."',
								'".$data[9]."',
								'".$data[10]."',
								'".$data[11]."',
								'".$data[12]."',
								'".$data[13]."',
								'".$data[14]."',
								'".$data[15]."',
								'".$data[16]."'
								)";

								$query 	= $this->db->query($sqlins);	
								if (!$query) {
									return false;
								}
					}
					/*
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
											'".$data[16]."' as ORGANIZATION_ID
									 FROM dual) b
							  ON (smp.CUSTOMER_ID = b.CUSTOMER_ID 
							      and smp.CUSTOMER_SITE_ID = b.CUSTOMER_SITE_ID
								  and smp.ORGANIZATION_ID = b.ORGANIZATION_ID)
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
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}
					*/
				}

				$row++;
			}
		}
		
		if ($jenis_trx == "SUPPLIER") 
		{
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){

					if ($data[0] != '')
					{
						$sql = "
						select vendor_id,vendor_site_id,organization_id
						from simtax_master_supplier
						where vendor_id = ".$data[0]."
						and vendor_site_id = ".$data[6]."
						and organization_id = ".$data[17]
						;
						$qReq    	= $this->db->query($sql);
						$vrow  		= $qReq->row();
						
						if($vrow !== NULL)
						{
							if($vrow->VENDOR_ID != ''){
							} else {	
								$sqlinsvend ="
										insert 
										into
										simtax_master_supplier
										(VENDOR_ID
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
								VALUES (
										 ".$data[0].",
										'".$data[1]."',
										'".$data[2]."',
										'".$data[3]."',
										'".$data[4]."',
										'".$data[5]."',
										 ".$data[6].",
										'".$data[7]."',
										'".$data[8]."',
										'".$data[9]."',
										'".$data[10]."',
										'".$data[11]."',
										'".$data[12]."',
										'".$data[13]."',
										'".$data[14]."',
										'".$data[15]."',
										'".$data[16]."',
										 ".$data[17]."
										)";
								
								$queryvend 	= $this->db->query($sqlinsvend);	
								if (!$queryvend) {
									return false;
								}
							}
						} else {
							$sqlinsvend ="
										insert 
										into
										simtax_master_supplier
										(VENDOR_ID
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
								VALUES (
										 ".$data[0].",
										'".$data[1]."',
										'".$data[2]."',
										'".$data[3]."',
										'".$data[4]."',
										'".$data[5]."',
										 ".$data[6].",
										'".$data[7]."',
										'".$data[8]."',
										'".$data[9]."',
										'".$data[10]."',
										'".$data[11]."',
										'".$data[12]."',
										'".$data[13]."',
										'".$data[14]."',
										'".$data[15]."',
										'".$data[16]."',
										 ".$data[17]."
										)";
								
								$queryvend 	= $this->db->query($sqlinsvend);	
								if (!$queryvend) {
									return false;
								}
						}
					} else {
						$sqlinsvend ="
										insert 
										into
										simtax_master_supplier
										(VENDOR_ID
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
								VALUES (
										 ".$data[0].",
										'".$data[1]."',
										'".$data[2]."',
										'".$data[3]."',
										'".$data[4]."',
										'".$data[5]."',
										 ".$data[6].",
										'".$data[7]."',
										'".$data[8]."',
										'".$data[9]."',
										'".$data[10]."',
										'".$data[11]."',
										'".$data[12]."',
										'".$data[13]."',
										'".$data[14]."',
										'".$data[15]."',
										'".$data[16]."',
										 ".$data[17]."
										)";
								
								$queryvend 	= $this->db->query($sqlinsvend);	
								if (!$queryvend) {
									return false;
								}
					}

					/*		 
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
					*/
				}

				$row++;
			}			
		}	

		if ($jenis_trx == "MSTPPH") {
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){
							 
					$sql	="MERGE INTO simtax_master_pph smp
							  USING (SELECT '".$data[0]."' as OPERATING_UNIT,
											'".$data[1]."' as TAX_CODE,
											'".$data[2]."' as DESCRIPTION,
											'".$data[3]."' as TAX_RATE,
											'".$data[4]."' as ENABLED,
											'".$data[5]."' as VENDOR_NAME,
											'".$data[6]."' as VENDOR_NUMBER,
											'".$data[7]."' as VENDOR_SITE_CODE,
											'".$data[8]."' as KODE_PAJAK,
											'".$data[9]."' as JENIS_4_AYAT_2,
											'".$data[10]."' as KODE_PAJAK_SPPD,
											'".$data[11]."' as JENIS_23,
											'".$data[12]."' as AKUN_PAJAK,
											'".$data[13]."' as GL_ACCOUNT,
											'".$data[14]."' as COMPANY,
											'".$data[15]."' as BRANCH,
											'".$data[16]."' as ACCOUNT,
											'".$data[17]."' as KAP_KJS
									 FROM dual) b
							  ON (smp.TAX_CODE = b.TAX_CODE and smp.TAX_CODE = b.TAX_CODE)
							  WHEN MATCHED THEN
								UPDATE SET
									OPERATING_UNIT  = b.OPERATING_UNIT,
									DESCRIPTION     = b.DESCRIPTION,
									TAX_RATE        = b.TAX_RATE,
									ENABLED         = b.ENABLED,
									VENDOR_NAME     = b.VENDOR_NAME,
									VENDOR_NUMBER   = b.VENDOR_NUMBER,
									VENDOR_SITE_CODE = b.VENDOR_SITE_CODE,
									KODE_PAJAK      = b.KODE_PAJAK,
									JENIS_4_AYAT_2  = b.JENIS_4_AYAT_2,
									KODE_PAJAK_SPPD = b.KODE_PAJAK_SPPD,
									JENIS_23        = b.JENIS_23,
									AKUN_PAJAK      = b.AKUN_PAJAK,
									GL_ACCOUNT      = b.GL_ACCOUNT,
									COMPANY         = b.COMPANY,
									BRANCH          = b.BRANCH,
									ACCOUNT         = b.ACCOUNT,
									KAP_KJS         = b.KAP_KJS
							  WHEN NOT MATCHED THEN
								INSERT (OPERATING_UNIT,
										TAX_CODE,
										DESCRIPTION,
										TAX_RATE,
										ENABLED,
										VENDOR_NAME,
										VENDOR_NUMBER,
										VENDOR_SITE_CODE,
										KODE_PAJAK,
										JENIS_4_AYAT_2,
										KODE_PAJAK_SPPD,
										JENIS_23,
										AKUN_PAJAK,
										GL_ACCOUNT,
										COMPANY,
										BRANCH,
										ACCOUNT,
										KAP_KJS
										)
								VALUES (b.OPERATING_UNIT,
										b.TAX_CODE,
										b.DESCRIPTION,
										b.TAX_RATE,
										b.ENABLED,
										b.VENDOR_NAME,
										b.VENDOR_NUMBER,
										b.VENDOR_SITE_CODE,
										b.KODE_PAJAK,
										b.JENIS_4_AYAT_2,
										b.KODE_PAJAK_SPPD,
										b.JENIS_23,
										b.AKUN_PAJAK,
										b.GL_ACCOUNT,
										b.COMPANY,
										b.BRANCH,
										b.ACCOUNT,
										b.KAP_KJS
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}

				}

				$row++;
			}
		}	

		if ($jenis_trx == "MSTGCC") {

			ini_set('memory_limit', '1024M');

			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){
							 
					$sql	="MERGE INTO gl_code_combinations gcc
							  USING (SELECT '".$data[0]."' as CODE_COMBINATION_ID,
											".$data[1]." as LAST_UPDATE_DATE,
											'".$data[2]."' as LAST_UPDATED_BY,
											'".$data[3]."' as CHART_OF_ACCOUNTS_ID,
											'".$data[4]."' as DETAIL_POSTING_ALLOWED_FLAG,
											'".$data[5]."' as DETAIL_BUDGETING_ALLOWED_FLAG,
											'".$data[6]."' as ACCOUNT_TYPE,
											'".$data[7]."' as ENABLED_FLAG,
											'".$data[8]."' as SUMMARY_FLAG,
											'".$data[9]."' as SEGMENT1,
											'".$data[10]."' as SEGMENT2,
											'".$data[11]."' as SEGMENT3,
											'".$data[12]."' as SEGMENT4,
											'".$data[13]."' as SEGMENT5,
											'".$data[14]."' as SEGMENT6,
											'".$data[15]."' as SEGMENT7,
											'".$data[16]."' as SEGMENT8,
											'".$data[17]."' as SEGMENT9,
											'".$data[18]."' as DESCRIPTION,
											'".$data[19]."' as TEMPLATE_ID,
											'".$data[20]."' as ALLOCATION_CREATE_FLAG,
											".$data[21]." as START_DATE_ACTIVE,
											".$data[22]." as END_DATE_ACTIVE,
											'".$data[23]."' as ATTRIBUTE1,
											'".$data[24]."' as ATTRIBUTE2,
											'".$data[25]."' as ATTRIBUTE3,
											'".$data[26]."' as ATTRIBUTE4,
											'".$data[27]."' as ATTRIBUTE5,
											'".$data[28]."' as ATTRIBUTE6,
											'".$data[29]."' as ATTRIBUTE7,
											'".$data[30]."' as ATTRIBUTE8,
											'".$data[31]."' as ATTRIBUTE9
									 FROM dual) b
							  ON (gcc.CODE_COMBINATION_ID = b.CODE_COMBINATION_ID)
							  WHEN MATCHED THEN
								UPDATE SET 
											LAST_UPDATE_DATE = b.LAST_UPDATE_DATE,
											LAST_UPDATED_BY = b.LAST_UPDATED_BY,
											CHART_OF_ACCOUNTS_ID = b.CHART_OF_ACCOUNTS_ID,
											DETAIL_POSTING_ALLOWED_FLAG = b.DETAIL_POSTING_ALLOWED_FLAG,
											DETAIL_BUDGETING_ALLOWED_FLAG = b.DETAIL_BUDGETING_ALLOWED_FLAG,
											ACCOUNT_TYPE = b.ACCOUNT_TYPE,
											ENABLED_FLAG = b.ENABLED_FLAG,
											SUMMARY_FLAG = b.SUMMARY_FLAG,
											SEGMENT1 = b.SEGMENT1,
											SEGMENT2 = b.SEGMENT2,
											SEGMENT3 = b.SEGMENT3,
											SEGMENT4 = b.SEGMENT4,
											SEGMENT5 = b.SEGMENT5,
											SEGMENT6 = b.SEGMENT6,
											SEGMENT7 = b.SEGMENT7,
											SEGMENT8 = b.SEGMENT8,
											SEGMENT9 = b.SEGMENT9,
											DESCRIPTION = b.DESCRIPTION,
											TEMPLATE_ID = b.TEMPLATE_ID,
											ALLOCATION_CREATE_FLAG = b.ALLOCATION_CREATE_FLAG,
											START_DATE_ACTIVE = b.START_DATE_ACTIVE,
											END_DATE_ACTIVE = b.END_DATE_ACTIVE,
											ATTRIBUTE1 = b.ATTRIBUTE1,
											ATTRIBUTE2 = b.ATTRIBUTE2,
											ATTRIBUTE3 = b.ATTRIBUTE3,
											ATTRIBUTE4 = b.ATTRIBUTE4,
											ATTRIBUTE5 = b.ATTRIBUTE5,
											ATTRIBUTE6 = b.ATTRIBUTE6,
											ATTRIBUTE7 = b.ATTRIBUTE7,
											ATTRIBUTE8 = b.ATTRIBUTE8,
											ATTRIBUTE9 = b.ATTRIBUTE9
							  WHEN NOT MATCHED THEN
								INSERT (CODE_COMBINATION_ID,
										LAST_UPDATE_DATE,
										LAST_UPDATED_BY,
										CHART_OF_ACCOUNTS_ID,
										DETAIL_POSTING_ALLOWED_FLAG,
										DETAIL_BUDGETING_ALLOWED_FLAG,
										ACCOUNT_TYPE,
										ENABLED_FLAG,
										SUMMARY_FLAG,
										SEGMENT1,
										SEGMENT2,
										SEGMENT3,
										SEGMENT4,
										SEGMENT5,
										SEGMENT6,
										SEGMENT7,
										SEGMENT8,
										SEGMENT9,
										DESCRIPTION,
										TEMPLATE_ID,
										ALLOCATION_CREATE_FLAG,
										START_DATE_ACTIVE,
										END_DATE_ACTIVE,
										ATTRIBUTE1,
										ATTRIBUTE2,
										ATTRIBUTE3,
										ATTRIBUTE4,
										ATTRIBUTE5,
										ATTRIBUTE6,
										ATTRIBUTE7,
										ATTRIBUTE8,
										ATTRIBUTE9
										)
								VALUES (b.CODE_COMBINATION_ID,
										b.LAST_UPDATE_DATE,
										b.LAST_UPDATED_BY,
										b.CHART_OF_ACCOUNTS_ID,
										b.DETAIL_POSTING_ALLOWED_FLAG,
										b.DETAIL_BUDGETING_ALLOWED_FLAG,
										b.ACCOUNT_TYPE,
										b.ENABLED_FLAG,
										b.SUMMARY_FLAG,
										b.SEGMENT1,
										b.SEGMENT2,
										b.SEGMENT3,
										b.SEGMENT4,
										b.SEGMENT5,
										b.SEGMENT6,
										b.SEGMENT7,
										b.SEGMENT8,
										b.SEGMENT9,
										b.DESCRIPTION,
										b.TEMPLATE_ID,
										b.ALLOCATION_CREATE_FLAG,
										b.START_DATE_ACTIVE,
										b.END_DATE_ACTIVE,
										b.ATTRIBUTE1,
										b.ATTRIBUTE2,
										b.ATTRIBUTE3,
										b.ATTRIBUTE4,
										b.ATTRIBUTE5,
										b.ATTRIBUTE6,
										b.ATTRIBUTE7,
										b.ATTRIBUTE8,
										b.ATTRIBUTE9
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}

				}

				$row++;
			}
		}
		

		if ($jenis_trx == "1721A1") {
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){

					$address = utf8_encode($data[6]);
					$address = str_replace(' ',' ',$address);
					$address = str_replace('\'','',$address);
					$address = str_replace('"','',$address);
					$address = str_replace('`','',$address);

					$employee_name = utf8_encode($data[8]);
					$employee_name = str_replace(' ',' ',$employee_name);
					$employee_name = str_replace('\'','',$employee_name);
					$employee_name = str_replace('"','',$employee_name);
					$employee_name = str_replace('`','',$employee_name);

					$npwp_pemotong = utf8_encode($data[34]);
					$npwp_pemotong = str_replace(' ',' ',$npwp_pemotong);
					$npwp_pemotong = str_replace('\'','',$npwp_pemotong);
					$npwp_pemotong = str_replace('"','',$npwp_pemotong);
					$npwp_pemotong = str_replace('`','',$npwp_pemotong);
					
					$sql	="MERGE INTO SIMTAX_PPH21_1721_A1 a
							  USING (SELECT ".$data[0]." as YY,
											'".$data[1]."' as NO_BUKTI,
											".$data[2]." as MASA_AWAL,
											".$data[3]." as MASA_AKHIR,
											'".$data[4]."' as NPWP,
											'".$data[5]."' as NIK,
											'".$address."' as ADDRESS,
											'".$data[7]."' as SEX,
											'".$employee_name."' as EMPLOYEE_NAME,
											'".$data[9]."' as STATUS_PTKP,
											".$data[10]." as DEPENDENT,
											'".$data[11]."' as JOB_NAME,
											'".$data[12]."' as WP_LUAR_NEGERI,
											'".$data[13]."' as KODE_NEGARA,
											".$data[14]." as A1R1,
											".$data[15]." as A1R2,
											".$data[16]." as A1R3,
											".$data[17]." as A1R4,
											".$data[18]." as A1R5,
											".$data[19]." as A1R6,
											".$data[20]." as BONUS,
											".$data[21]." as TOTAL_BRUTO,
											".$data[22]." as BIAYA_JABATAN,
											".$data[23]." as IURAN_PENSIUN,
											".$data[24]." as JUMLAH_PENGURANG,
											".$data[25]." as JUMLAH_PENGHASILAN_NETTO,
											".$data[26]." as JUMLAH_PENGHASILAN_SEBELUMNYA,
											".$data[27]." as JMLH_PNGHSLAN_NETTO_DISTHNKAN,
											".$data[28]." as PTKP,
											".$data[29]." as PKP,
											".$data[30]." as A1R17,
											".$data[31]." as A1R18,
											".$data[32]." as A1R19,
											".$data[33]." as A1R20,
											'".$npwp_pemotong."' as NPWP_PEMOTONG
									 FROM dual) b
							  ON (a.NO_BUKTI = b.NO_BUKTI and a.NPWP = b.NPWP)
							  WHEN MATCHED THEN
								UPDATE SET
									TAHUN              = b.YY,
									--NO_BUKTI           = b.NO_BUKTI,
									MASA_AWAL          = b.MASA_AWAL,
									MASA_AKHIR         = b.MASA_AKHIR,
									--NPWP               = b.NPWP,
									NIK                = b.NIK,
									ADDRESS            = b.ADDRESS,
									SEX                = b.SEX,
									EMPLOYEE_NAME      = b.EMPLOYEE_NAME,
									STATUS_PTKP        = b.STATUS_PTKP,
									DEPENDENT          = b.DEPENDENT,
									JOB_NAME           = b.JOB_NAME,
									WP_LUAR_NEGERI     = b.WP_LUAR_NEGERI,
									KODE_NEGARA        = b.KODE_NEGARA,
									A1R1               = b.A1R1,
									A1R2               = b.A1R2,
									A1R3               = b.A1R3,
									A1R4               = b.A1R4,
									A1R5               = b.A1R5,
									A1R6               = b.A1R6,
									BONUS              = b.BONUS,
									TOTAL_BRUTO        = b.TOTAL_BRUTO,
									BIAYA_JABATAN      = b.BIAYA_JABATAN,
									IURAN_PENSIUN      = b.IURAN_PENSIUN,
									JUMLAH_PENGURANG   = b.JUMLAH_PENGURANG,
									JUMLAH_PENGHASILAN_NETTO = b.JUMLAH_PENGHASILAN_NETTO,
									JUMLAH_PENGHASILAN_SEBELUMNYA = b.JUMLAH_PENGHASILAN_SEBELUMNYA,
									JMLH_PNGHSLAN_DISTHNKAN = b.JMLH_PNGHSLAN_NETTO_DISTHNKAN,
									PTKP              = b.PTKP,
									PKP               = b.PKP,
									A1R17             = b.A1R17,
									A1R18             = b.A1R18,
									A1R19             = b.A1R19,
									A1R20             = b.A1R20,
									NPWP_PEMOTONG     = b.NPWP_PEMOTONG
							  WHEN NOT MATCHED THEN
								INSERT (TAHUN, 
										NO_BUKTI,
										MASA_AWAL,
										MASA_AKHIR,
										NPWP,
										NIK,
										ADDRESS,
										SEX,
										EMPLOYEE_NAME,
										STATUS_PTKP,
										DEPENDENT,
										JOB_NAME,
										WP_LUAR_NEGERI,
										KODE_NEGARA,
										A1R1,
										A1R2,
										A1R3,
										A1R4,
										A1R5,
										A1R6,
										BONUS,
										TOTAL_BRUTO,
										BIAYA_JABATAN,
										IURAN_PENSIUN,
										JUMLAH_PENGURANG,
										JUMLAH_PENGHASILAN_NETTO,
										JUMLAH_PENGHASILAN_SEBELUMNYA,
										JMLH_PNGHSLAN_DISTHNKAN,
										PTKP,
										PKP,
										A1R17,
										A1R18,
										A1R19,
										A1R20,
										NPWP_PEMOTONG
										)
								VALUES (b.YY,
										b.NO_BUKTI,
										b.MASA_AWAL,
										b.MASA_AKHIR,
										b.NPWP,
										b.NIK,
										b.ADDRESS,
										b.SEX,
										b.EMPLOYEE_NAME,
										b.STATUS_PTKP,
										b.DEPENDENT,
										b.JOB_NAME,
										b.WP_LUAR_NEGERI,
										b.KODE_NEGARA,
										b.A1R1,
										b.A1R2,
										b.A1R3,
										b.A1R4,
										b.A1R5,
										b.A1R6,
										b.BONUS,
										b.TOTAL_BRUTO,
										b.BIAYA_JABATAN,
										b.IURAN_PENSIUN,
										b.JUMLAH_PENGURANG,
										b.JUMLAH_PENGHASILAN_NETTO,
										b.JUMLAH_PENGHASILAN_SEBELUMNYA,
										b.JMLH_PNGHSLAN_NETTO_DISTHNKAN,
										b.PTKP,
										b.PKP,
										b.A1R17,
										b.A1R18,
										b.A1R19,
										b.A1R20,
										b.NPWP_PEMOTONG
										)";
						 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}

				}

				$row++;
			}
		}
		
		if ($jenis_trx == "FLEX") {
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){
					
					if ($data[0] == "FVS") {
						$sql	="MERGE INTO FND_FLEX_VALUE_SETS FFVS
								  USING (SELECT '".$data[1]."' as FLEX_VALUE_SET_ID,
												'".$data[2]."' as FLEX_VALUE_SET_NAME,
												".$data[3]." as LAST_UPDATE_DATE,
												'".$data[4]."' as LAST_UPDATED_BY,
												".$data[5]." as CREATION_DATE,
												'".$data[6]."' as CREATED_BY,
												'".$data[7]."' as LAST_UPDATE_LOGIN,
												'".$data[8]."' as VALIDATION_TYPE,
												'".$data[9]."' as PROTECTED_FLAG,
												'".$data[10]."' as SECURITY_ENABLED_FLAG,
												'".$data[11]."' as LONGLIST_FLAG,
												'".$data[12]."' as FORMAT_TYPE,
												'".$data[13]."' as MAXIMUM_SIZE,
												'".$data[14]."' as ALPHANUMERIC_ALLOWED_FLAG,
												'".$data[15]."' as UPPERCASE_ONLY_FLAG,
												'".$data[16]."' as NUMERIC_MODE_ENABLED_FLAG,
												'".$data[17]."' as DESCRIPTION,
												'".$data[18]."' as DEPENDANT_DEFAULT_VALUE,
												'".$data[19]."' as DEPENDANT_DEFAULT_MEANING,
												'".$data[20]."' as PARENT_FLEX_VALUE_SET_ID,
												'".$data[21]."' as MINIMUM_VALUE,
												'".$data[22]."' as MAXIMUM_VALUE,
												'".$data[23]."' as NUMBER_PRECISION
										 FROM dual) b
								  ON (FFVS.FLEX_VALUE_SET_ID = b.FLEX_VALUE_SET_ID and ffvs.FLEX_VALUE_SET_NAME = b.FLEX_VALUE_SET_NAME)
								  WHEN MATCHED THEN
									UPDATE SET 
												LAST_UPDATE_DATE = b.LAST_UPDATE_DATE,
												LAST_UPDATED_BY = b.LAST_UPDATED_BY,
												CREATION_DATE = b.CREATION_DATE,
												CREATED_BY = b.CREATED_BY,
												LAST_UPDATE_LOGIN = b.LAST_UPDATE_LOGIN,
												VALIDATION_TYPE = b.VALIDATION_TYPE,
												PROTECTED_FLAG = b.PROTECTED_FLAG,
												SECURITY_ENABLED_FLAG = b.SECURITY_ENABLED_FLAG,
												LONGLIST_FLAG = b.LONGLIST_FLAG,
												FORMAT_TYPE = b.FORMAT_TYPE,
												MAXIMUM_SIZE = b.MAXIMUM_SIZE,
												ALPHANUMERIC_ALLOWED_FLAG = b.ALPHANUMERIC_ALLOWED_FLAG,
												UPPERCASE_ONLY_FLAG = b.UPPERCASE_ONLY_FLAG,
												NUMERIC_MODE_ENABLED_FLAG = b.NUMERIC_MODE_ENABLED_FLAG,
												DESCRIPTION = b.DESCRIPTION,
												DEPENDANT_DEFAULT_VALUE = b.DEPENDANT_DEFAULT_VALUE,
												DEPENDANT_DEFAULT_MEANING = b.DEPENDANT_DEFAULT_MEANING,
												PARENT_FLEX_VALUE_SET_ID = b.PARENT_FLEX_VALUE_SET_ID,
												MINIMUM_VALUE = b.MINIMUM_VALUE,
												MAXIMUM_VALUE = b.MAXIMUM_VALUE,
												NUMBER_PRECISION = b.NUMBER_PRECISION
								  WHEN NOT MATCHED THEN
									INSERT (FLEX_VALUE_SET_ID,
											FLEX_VALUE_SET_NAME,
											LAST_UPDATE_DATE,
											LAST_UPDATED_BY,
											CREATION_DATE,
											CREATED_BY,
											LAST_UPDATE_LOGIN,
											VALIDATION_TYPE,
											PROTECTED_FLAG,
											SECURITY_ENABLED_FLAG,
											LONGLIST_FLAG,
											FORMAT_TYPE,
											MAXIMUM_SIZE,
											ALPHANUMERIC_ALLOWED_FLAG,
											UPPERCASE_ONLY_FLAG,
											NUMERIC_MODE_ENABLED_FLAG,
											DESCRIPTION,
											DEPENDANT_DEFAULT_VALUE,
											DEPENDANT_DEFAULT_MEANING,
											PARENT_FLEX_VALUE_SET_ID,
											MINIMUM_VALUE,
											MAXIMUM_VALUE,
											NUMBER_PRECISION
											)
									VALUES (b.FLEX_VALUE_SET_ID,
											b.FLEX_VALUE_SET_NAME,
											b.LAST_UPDATE_DATE,
											b.LAST_UPDATED_BY,
											b.CREATION_DATE,
											b.CREATED_BY,
											b.LAST_UPDATE_LOGIN,
											b.VALIDATION_TYPE,
											b.PROTECTED_FLAG,
											b.SECURITY_ENABLED_FLAG,
											b.LONGLIST_FLAG,
											b.FORMAT_TYPE,
											b.MAXIMUM_SIZE,
											b.ALPHANUMERIC_ALLOWED_FLAG,
											b.UPPERCASE_ONLY_FLAG,
											b.NUMERIC_MODE_ENABLED_FLAG,
											b.DESCRIPTION,
											b.DEPENDANT_DEFAULT_VALUE,
											b.DEPENDANT_DEFAULT_MEANING,
											b.PARENT_FLEX_VALUE_SET_ID,
											b.MINIMUM_VALUE,
											b.MAXIMUM_VALUE,
											b.NUMBER_PRECISION
											)";
								 
						$query 		= $this->db->query($sql);	
						if (!$query) {
							return false;
						}						
					}
					
					if ($data[0] == "FFV") {
						$sql	="MERGE INTO FND_FLEX_VALUES FFV
								  USING (SELECT '".$data[1]."' as FLEX_VALUE_SET_ID,
												'".$data[2]."' as FLEX_VALUE_ID,
												'".$data[3]."' as FLEX_VALUE,
												".$data[4]." as LAST_UPDATE_DATE,
												'".$data[5]."' as LAST_UPDATED_BY,
												".$data[6]." as CREATION_DATE,
												'".$data[7]."' as CREATED_BY,
												'".$data[8]."' as ENABLED_FLAG,
												'".$data[9]."' as SUMMARY_FLAG,
												'".$data[10]."' as COMPILED_VALUE_ATTRIBUTES
										 FROM dual) b
								  ON (FFV.FLEX_VALUE_SET_ID = b.FLEX_VALUE_SET_ID and FFV.FLEX_VALUE_ID = b.FLEX_VALUE_ID)
								  WHEN MATCHED THEN
									UPDATE SET  FLEX_VALUE = b.FLEX_VALUE,
												LAST_UPDATE_DATE = b.LAST_UPDATE_DATE,
												LAST_UPDATED_BY = b.LAST_UPDATED_BY,
												CREATION_DATE = b.CREATION_DATE,
												CREATED_BY = b.CREATED_BY,
												ENABLED_FLAG = b.ENABLED_FLAG,
												SUMMARY_FLAG = b.SUMMARY_FLAG,
												COMPILED_VALUE_ATTRIBUTES = b.COMPILED_VALUE_ATTRIBUTES
								  WHEN NOT MATCHED THEN
									INSERT (FLEX_VALUE_SET_ID,
											FLEX_VALUE_ID,
											FLEX_VALUE,
											LAST_UPDATE_DATE,
											LAST_UPDATED_BY,
											CREATION_DATE,
											CREATED_BY,
											ENABLED_FLAG,
											SUMMARY_FLAG,
											COMPILED_VALUE_ATTRIBUTES
											)
									VALUES (b.FLEX_VALUE_SET_ID,
											b.FLEX_VALUE_ID,
											b.FLEX_VALUE,
											b.LAST_UPDATE_DATE,
											b.LAST_UPDATED_BY,
											b.CREATION_DATE,
											b.CREATED_BY,
											b.ENABLED_FLAG,
											b.SUMMARY_FLAG,
											b.COMPILED_VALUE_ATTRIBUTES
											)";
								 
						$query 		= $this->db->query($sql);	
						if (!$query) {
							return false;
						}						
					}						

					if ($data[0] == "FVT") {
						$sql	="MERGE INTO FND_FLEX_VALUES_TL FFVT
								  USING (SELECT '".$data[1]."' as FLEX_VALUE_ID,
												'".$data[2]."' as LANGUAGE,
												".$data[3]." as LAST_UPDATE_DATE,
												'".$data[4]."' as LAST_UPDATED_BY,
												".$data[5]." as CREATION_DATE,
												'".$data[6]."' as CREATED_BY,
												'".$data[7]."' as DESCRIPTION,
												'".$data[8]."' as FLEX_VALUE_MEANING
										 FROM dual) b
								  ON (FFVT.FLEX_VALUE_ID = b.FLEX_VALUE_ID)
								  WHEN MATCHED THEN
									UPDATE SET  LANGUAGE = b.LANGUAGE,
												LAST_UPDATE_DATE = b.LAST_UPDATE_DATE,
												LAST_UPDATED_BY = b.LAST_UPDATED_BY,
												CREATION_DATE = b.CREATION_DATE,
												CREATED_BY = b.CREATED_BY,
												DESCRIPTION = b.DESCRIPTION,
												FLEX_VALUE_MEANING = b.FLEX_VALUE_MEANING
								  WHEN NOT MATCHED THEN
									INSERT (FLEX_VALUE_ID,
											LANGUAGE,
											LAST_UPDATE_DATE,
											LAST_UPDATED_BY,
											CREATION_DATE,
											CREATED_BY,
											DESCRIPTION,
											FLEX_VALUE_MEANING
											)
									VALUES (b.FLEX_VALUE_ID,
											b.LANGUAGE,
											b.LAST_UPDATE_DATE,
											b.LAST_UPDATED_BY,
											b.CREATION_DATE,
											b.CREATED_BY,
											b.DESCRIPTION,
											b.FLEX_VALUE_MEANING
											)";
						$query 		= $this->db->query($sql);	
						if (!$query) {
							
							return false;
						}						
					}
					
				}

				$row++;
			}
		}

		if ($jenis_trx == "ACCPPH21") {
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {

				if($row >= 0){
							 
					$sql	="MERGE INTO SIMTAX_PPH21_DTL SPD
							  USING (SELECT  '".$data[1]."' as NIK,
											 '".$data[0]."' as NAMA,
											 ".$data[2]." as EFFECTIVE_DATE,
											 '".$data[3]."' as KELAS_JABATAN,
											 '".$data[4]."' as JOB,
											 '".$data[5]."' as POSISI,
											 '".$data[6]."' as KATEGORI_POSISI,
											 '".$data[7]."' as ENTITY,
											 '".$data[8]."' as PAYROLL_NAME,
											 '".$data[9]."' as LOKASI,
											 ".$data[10]." as TANGGAL_LAHIR,
											 '".$data[11]."' as USIA,
											 '".$data[12]."' as PENDIDIKAN_TERAKHIR,
											 '".$data[13]."' as GOLONGAN,
											 '".$data[14]."' as MASA_KERJA,
											 '".$data[15]."' as SALARY,
											 '".$data[16]."' as TAKE_HOME_PAY,
											 '".$data[17]."' as ELEMENT_NAME,
											 '".$data[18]."' as CLASSIFICATION_NAME,
											 '".$data[19]."' as SEGMENT1,
											 '".$data[20]."' as SEGMENT2,
											 '".$data[21]."' as SEGMENT3,
											 '".$data[22]."' as SEGMENT4,
											 '".$data[23]."' as SEGMENT5,
											 '".$data[24]."' as SEGMENT6,
											 '".$data[25]."' as SEGMENT7,
											 '".$data[26]."' as SEGMENT8,
											 '".$data[27]."' as SEGMENT9,
											 '".$data[28]."' as COSTED_VALUE
									 FROM dual) b
							  ON (spd.NIK = b.NIK
									AND spd.NAMA = b.NAMA
									AND spd.EFFECTIVE_DATE = b.EFFECTIVE_DATE
									AND spd.KELAS_JABATAN = b.KELAS_JABATAN
									AND spd.JOB = b.JOB
									AND spd.POSISI = b.POSISI
									AND spd.KATEGORI_POSISI = b.KATEGORI_POSISI
									AND spd.ENTITY = b.ENTITY
									AND spd.PAYROLL_NAME = b.PAYROLL_NAME
									AND spd.LOKASI = b.LOKASI
									AND spd.TANGGAL_LAHIR = b.TANGGAL_LAHIR
									AND spd.USIA = b.USIA
									AND spd.PENDIDIKAN_TERAKHIR = b.PENDIDIKAN_TERAKHIR
									AND spd.GOLONGAN = b.GOLONGAN
									AND spd.MASA_KERJA = b.MASA_KERJA
									--AND spd.SALARY = b.SALARY
									AND spd.TAKE_HOME_PAY = b.TAKE_HOME_PAY
									AND spd.ELEMENT_NAME = b.ELEMENT_NAME
									AND spd.CLASSIFICATION_NAME = b.CLASSIFICATION_NAME
									AND spd.SEGMENT1 = b.SEGMENT1
									AND spd.SEGMENT2 = b.SEGMENT2
									AND spd.SEGMENT3 = b.SEGMENT3
									AND spd.SEGMENT4 = b.SEGMENT4
									AND spd.SEGMENT5 = b.SEGMENT5
									AND spd.SEGMENT6 = b.SEGMENT6
									AND spd.SEGMENT7 = b.SEGMENT7
									AND spd.SEGMENT8 = b.SEGMENT8
									AND spd.SEGMENT9 = b.SEGMENT9
								)
							  WHEN MATCHED THEN
								UPDATE SET 
										COSTED_VALUE = b.COSTED_VALUE
							  WHEN NOT MATCHED THEN
								INSERT (NIK,
										NAMA,
										EFFECTIVE_DATE,
										KELAS_JABATAN,
										JOB,
										POSISI,
										KATEGORI_POSISI,
										ENTITY,
										PAYROLL_NAME,
										LOKASI,
										TANGGAL_LAHIR,
										USIA,
										PENDIDIKAN_TERAKHIR,
										GOLONGAN,
										MASA_KERJA,
										SALARY,
										TAKE_HOME_PAY,
										ELEMENT_NAME,
										CLASSIFICATION_NAME,
										SEGMENT1,
										SEGMENT2,
										SEGMENT3,
										SEGMENT4,
										SEGMENT5,
										SEGMENT6,
										SEGMENT7,
										SEGMENT8,
										SEGMENT9,
										COSTED_VALUE
										)
								VALUES (b.NIK,
										b.NAMA,
										b.EFFECTIVE_DATE,
										b.KELAS_JABATAN,
										b.JOB,
										b.POSISI,
										b.KATEGORI_POSISI,
										b.ENTITY,
										b.PAYROLL_NAME,
										b.LOKASI,
										b.TANGGAL_LAHIR,
										b.USIA,
										b.PENDIDIKAN_TERAKHIR,
										b.GOLONGAN,
										b.MASA_KERJA,
										b.SALARY,
										b.TAKE_HOME_PAY,
										b.ELEMENT_NAME,
										b.CLASSIFICATION_NAME,
										b.SEGMENT1,
										b.SEGMENT2,
										b.SEGMENT3,
										b.SEGMENT4,
										b.SEGMENT5,
										b.SEGMENT6,
										b.SEGMENT7,
										b.SEGMENT8,
										b.SEGMENT9,
										b.COSTED_VALUE
										)";
							 
					$query 		= $this->db->query($sql);	
					if (!$query) {
						return false;
					}

				}

				$row++;
			}
		}
		
		if ($jenis_trx == "PPH21DTL") {
			$kode_cabang	= $this->input->post('srcKodeCabang');
			$wherecoaexpense = "";
			while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {
				if($data[10] != ""){
					$wherecoaexpense = "AND SEPP.COA_EXPENSE = b.COA_EXPENSE ";
				} else {
					$wherecoaexpense = "AND SEPP.COA_EXPENSE IS NULL";
				}
				if($row >= 0){
							 
					$sql	="MERGE INTO SIMTAX_EQUAL_PPH21 SEPP
							  USING (SELECT  '01' as COMPANY_CODE,
											 '".$kode_cabang."' as BRANCH_CODE,
											  ".$data[0]." as ASSIGNMENT_ACTION_ID,
											 '".$data[1]."' as NIPP,
											 '".$data[2]."' as NAMA,
											  ".$data[3]." as RUN_RESULT_ID,
											 '".$data[4]."' as PAYROLL_NAME,
											  ".$data[5]." as TAHUN,
											  ".$data[6]." as BULAN,
											  ".$data[7]." as TAKE_HOME_PAY,
											 '".$data[8]."' as CLASSIFICATION,
											 '".$data[9]."' as ELEMENT,
											 '".$data[10]."' as COA_EXPENSE,
											 '".$data[11]."' as COSTED_VALUE
									 FROM dual) b
							  ON (
									SEPP.COMPANY_CODE = b.COMPANY_CODE
									AND SEPP.BRANCH_CODE = b.BRANCH_CODE
									AND SEPP.ASSIGNMENT_ACTION_ID = b.ASSIGNMENT_ACTION_ID
									AND SEPP.NIPP = b.NIPP
									AND SEPP.NAMA = b.NAMA
									AND SEPP.RUN_RESULT_ID = b.RUN_RESULT_ID
									AND SEPP.PAYROLL_NAME = b.PAYROLL_NAME
									AND SEPP.TAHUN = b.TAHUN
									AND SEPP.BULAN = b.BULAN
									".$wherecoaexpense."
								)
							  WHEN MATCHED THEN
								UPDATE SET 
										TAKE_HOME_PAY = b.TAKE_HOME_PAY,
										COSTED_VALUE = b.COSTED_VALUE
							  WHEN NOT MATCHED THEN
								INSERT (COMPANY_CODE,
										BRANCH_CODE,
										ASSIGNMENT_ACTION_ID,
										NIPP,
										NAMA,
										RUN_RESULT_ID,
										PAYROLL_NAME,
										TAHUN,
										BULAN,
										TAKE_HOME_PAY,
										CLASSIFICATION,
										ELEMENT,
										COA_EXPENSE,
										COSTED_VALUE
										)
								VALUES (b.COMPANY_CODE,
										b.BRANCH_CODE,
										b.ASSIGNMENT_ACTION_ID,
										b.NIPP,
										b.NAMA,
										b.RUN_RESULT_ID,
										b.PAYROLL_NAME,
										b.TAHUN,
										b.BULAN,
										b.TAKE_HOME_PAY,
										b.CLASSIFICATION,
										b.ELEMENT,
										b.COA_EXPENSE,
										b.COSTED_VALUE
										)";
					//var_dump($sql);die();		 
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

  function do_process_tb($file_path,$ConcReqId) {
		
		$row = 0;
		$handle = fopen($file_path, "r");
		
		$dataCsv  = array();
		while (($data = fgetcsv($handle, 1000, ";","'","\\")) !== FALSE) {

			if($row >= 0){
						 
				$sql	="insert into simtax_rincian_bl_pph_badan 
						(BEBAN_LAIN_ID
						,TAHUN_PAJAK
						,BULAN_PAJAK
						,MASA_PAJAK
						,DEBIT
						,CREDIT
						,KODE_AKUN
						,AKUN_DESCRIPTION
						,CHECKLIST
						,CODE_COMPANY
						,LEDGER_ID
						,CREATION_DATE
						,CREATED_BY
						,UPDATE_DATE
						,UPDATE_BY
						,TGL_BUKTI
						,NOMOR_BUKTI
						,URAIAN
						,KODE_CABANG
						,REQUEST_ID
						,KODE_JASA
						,JASA_DESCRIPTION
						,BEGIN_BALANCE
						) 
						 VALUES
						 (RINCIAN_BL_PPH_BADAN_S.nextval,
						 '".$data[0]."',
						 '".$data[1]."',
						 '".$data[2]."',
						 '".$data[3]."',
						 '".$data[4]."',
						 ".$data[5].",
						 '".$data[6]."',
						 0,
						 ".$data[7].",
						 '".$data[8]."',
						 sysdate,
						 'ADMIN',
						 NULL,
						 NULL,
						 '".$data[13]."',						 
						 '".$data[14]."',
						 '".$data[15]."',
						 '".$data[9]."',
						 '".$ConcReqId."',
						 '".$data[10]."',						 
						 '".$data[11]."',						 
						 '".$data[12]."'
						 )";
						 
				$query 		= $this->db->query($sql);	
				if (!$query) {
					return false;
				}

			}

			$row++;
		}
		
		return true;
		
  }

	function do_process_tb_kk($file_path,$ConcReqId) {
			
		$row = 0;
		$handle = fopen($file_path, "r");
		
		$dataCsv  = array();
		while (($data = fgetcsv($handle, 1000, ";","'","\\")) !== FALSE) {

			if($row >= 0){
						
				$sql	="insert into gl_balances 
						(LEDGER_ID
						,CODE_COMBINATION_ID
						,CURRENCY_CODE
						,PERIOD_NAME
						,ACTUAL_FLAG
						,PERIOD_TYPE
						,PERIOD_YEAR
						,PERIOD_NUM
						,PERIOD_NET_DR
						,PERIOD_NET_CR
						,BEGIN_BALANCE_DR
						,BEGIN_BALANCE_CR
						,SEGMENT1
						,SEGMENT2
						,SEGMENT3
						,SEGMENT4
						,SEGMENT5
						,SEGMENT6
						,SEGMENT7
						,SEGMENT8
						,SEGMENT9
						) 
						VALUES
						(
						".$data[0].",
						".$data[1].",
						'".$data[2]."',
						'".$data[3]."',
						'".$data[4]."',
						'".$data[5]."',
						".$data[6].",
						".$data[7].",
						".$data[8].",
						".$data[9].",
						".$data[10].",
						".$data[11].",						 
						'".$data[12]."',
						'".$data[13]."',						 
						'".$data[14]."',
						'".$data[15]."',
						'".$data[16]."',
						'".$data[17]."',
						'".$data[18]."',						 
						'".$data[19]."',
						'".$data[20]."'
						)";	
				$query 		= $this->db->query($sql);	
				if (!$query) {
					return false;
				}

			}

			$row++;
		}
		
		return true;
		
	}
	
	function do_import_trx($bulan,$tahun,$ConcReqId,$jenis_trx) {
		
		$PARAMETER_1 = $bulan;
		$PARAMETER_2 = $tahun;
		$PARAMETER_3 = "";
		$PARAMETER_4 = $ConcReqId;
		$PARAMETER_5 = $this->session->userdata('identity');
		$OUT_CODE    = "";
		$OUT_MESSAGE = "";
		
		$arr_jenis_trx = array("PPNMASUK", "PPNWAPU", "PPNKELUAR");
		
		if ($jenis_trx=="PPH21") {
			$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertStagingToBaseTablePPH21(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4,:PARAMETER_5, :OUT_CODE,:OUT_MESSAGE); end;');
		} elseif (in_array($jenis_trx, $arr_jenis_trx)) {
			if ($jenis_trx=="PPNMASUK") {
				$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertStagingToBaseTablePPNMsk(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4,:PARAMETER_5, :OUT_CODE,:OUT_MESSAGE); end;');			
			}
			/*add by badar*/
			elseif ($jenis_trx=="PPNWAPU") {
				$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertStagingToBaseTablePPNMsk(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4,:PARAMETER_5, :OUT_CODE,:OUT_MESSAGE); end;');
			}
			/*add by badar*/
			else {
				$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertStagingToBaseTablePPN(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4,:PARAMETER_5, :OUT_CODE,:OUT_MESSAGE); end;');
			}
		} else {
			$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertStagingToBaseTable(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4,:PARAMETER_5, :OUT_CODE,:OUT_MESSAGE); end;');
		}
		
		oci_bind_by_name($stid, ':PARAMETER_1',  $PARAMETER_1,200);
		oci_bind_by_name($stid, ':PARAMETER_2',  $PARAMETER_2,200);
		oci_bind_by_name($stid, ':PARAMETER_3',  $PARAMETER_3,200);
		oci_bind_by_name($stid, ':PARAMETER_4',  $PARAMETER_4,200);
		oci_bind_by_name($stid, ':PARAMETER_5',  $PARAMETER_5,200);
		oci_bind_by_name($stid, ':OUT_CODE',  $OUT_MESSAGE ,100, SQLT_CHR);
		oci_bind_by_name($stid, ':OUT_MESSAGE',  $OUT_MESSAGE ,100, SQLT_CHR);

		if(oci_execute($stid)){
		  $results = $OUT_CODE;
		}
		
		oci_free_statement($stid);
		//oci_close($DBEBS->conn_id);

		if ($results==2) {
			return false;
		}
		else {			
			return true;
		}
	}	
	
	function get_history() {
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		if($q) {
			$where	= " and (upper(skc.NAMA_CABANG) like '%".strtoupper($q)."%' or upper(CONCURRENT_REQUEST_ID) like '%".strtoupper($q)."%' or  upper(PARAMETER5) like '%".strtoupper($q)."%') ";
		}

		$kode_cabang = $this->session->userdata('kd_cabang');
		$whereCabang = "";
		if($kode_cabang != '000'){
			$whereCabang = " and SKC.kode_cabang = '".$kode_cabang."'";
		}

		$queryExec	= "select CONCURRENT_REQUEST_ID 
							 , to_char(REQUESTED_DATE,'DD-MON-YYYY HH24:MI:SS') REQUESTED_DATE 
							 , case PARAMETER1
                                    when '1' then 'JAN'
                                    when '2' then 'FEB'
                                    when '3' then 'MAR'
                                    when '4' then 'APR'
                                    when '5' then 'MAY'
                                    when '6' then 'JUN'
                                    when '7' then 'JUL'
                                    when '8' then 'AUG'
                                    when '9' then 'SEP'
                                    when '10' then 'OCT'
                                    when '11' then 'NOV'
                                    when '12' then 'DEC'
                                end BULAN
							 , PARAMETER2 TAHUN
							 , PARAMETER3 KODE_CABANG
							 , PARAMETER5 TIPE_DOKUMEN
							 , IMPORT_TO_SIMTAX_FLAG
							 , IMPORT_TO_SIMTAX_DATE
							 , REPLACE_BY_CONC_REQ_ID
							 , skc.NAMA_CABANG
							 , case
								when IMPORT_TO_SIMTAX_FLAG = 'Y' and REPLACE_BY_CONC_REQ_ID IS NULL then
									'Sudah diproses'
								when IMPORT_TO_SIMTAX_FLAG = 'Y' and REPLACE_BY_CONC_REQ_ID IS NOT NULL then
									'Tidak jadi diproses. digantikan oleh Request ID : ' || REPLACE_BY_CONC_REQ_ID
								when IMPORT_TO_SIMTAX_FLAG = 'N' then
									'Belum diproses'            
							   end STATUS_IMPORT  
						 from simtax_getdata_history sgh
							, simtax_kode_cabang skc
						where sgh.PARAMETER3 = skc.KODE_CABANG (+)
					   ".$where."
					   ".$whereCabang."
						order by CONCURRENT_REQUEST_ID desc ";		
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}	
		
}