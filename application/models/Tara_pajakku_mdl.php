<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Tara_pajakku_mdl extends CI_Model {
	
		
    public function __construct()
    {
        parent::__construct();
        $this->kode_cabang = $this->session->userdata('kd_cabang');
    }
	
    function get_master_pajak()
	{
		$queryExec	        = "Select distinct kelompok_pajak from simtax_master_jns_pajak order by kelompok_pajak";
		$query 		        = $this->db->query($queryExec);
		$result['query']	= $query;
		return $result;		
	}

    function get_log_tara()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;

		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$kode_cabang   = $this->input->post('_searchCabang');
		$nama_pajak    = $this->input->post('_searchPajak');
		$bulan_pajak   = $this->input->post('_searchBulan');
		$tahun_pajak   = $this->input->post('_searchTahun');
		$pembetulan_ke = $this->input->post('_searchPembetulan');
		$jenis_pajak   = $this->input->post('_searchJenisPajak');
		
		$where	= "";
		if($q) {
			$where	.= " and upper(jenis_pajak) like '%".strtoupper($q)."%' ";
		}

		if($kode_cabang != ""){
			$whereCabang	= " and a.kode_cabang = '".$kode_cabang."'";
		}
		if($nama_pajak != ""){
			$wherePajak	= " and a.pajak = '".$nama_pajak."'";
		}
		if($jenis_pajak != ""){
			$whereBulan	= " and a.jenis_pajak = ".$bulan_pajak;
		}
		if($bulan_pajak != ""){
			$whereBulan	= " and a.bulan_pajak = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and a.tahun_pajak = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and a.pembetulan = ".$pembetulan_ke;
		}
		
		$queryExec	= "Select a.id_log, a.pajak_header_id, a.pajak, a.jenis_pajak, a.bulan_pajak, a.tahun_pajak, TO_CHAR(a.tanggal_kirim, 'DD-MON-YYYY HH24:MI:SS') as tanggal_kirim, 
						a.status_upload_csv, a.encode_file, a.origin_file, a.status_import_csv,file_id,
						a.created_by, a.created_date, a.last_modified_by, a.last_modified_date, a.log_id_import, a.wp_id,
						a.modul, a.status_log_import, a.description_log_import, a.delimiter, a.total, a.jumlah_error_import,
						a.user_send_simtax, a.is_creditable, a.pembetulan, a.kode_cabang, b.nama_cabang, a.jumlah_sukses_import
						from simtax_tara_log a
						left join simtax_kode_cabang b
						on a.kode_cabang = b.kode_cabang
						where 1=1
                        ".$where."
						".$whereCabang.$wherePajak.$whereBulan.$whereTahun.$wherePembetulan.
						" order by TO_CHAR(a.tanggal_kirim, 'MM-DD-YYYY HH24:MI:SS') desc";		
		
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
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;			
	}

	function insertLog($insert_log)
	{
		$cabang = $this->kode_cabang;    
		$user = $this->session->userdata('identity');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pajak = $this->input->post('pajak');
		$date = date('Y-m-d H:i:s');
		$jenispajak = $this->input->post('jenisPajak');
		$pajak_header_id = $insert_log["PAJAK_HEADER_ID"];
		$pajak = $pajak;
		$jenispajak = $jenispajak;
		$bulan = $bulan;
		$tahun = $tahun;
		$status_upload_csv =  $insert_log["STATUS_UPLOAD_CSV"];
		$encode_file =  $insert_log["ENCODE_FILE"];
		$origin_file =  $insert_log["ORIGIN_FILE"];
		$status_import_csv =  $insert_log["STATUS_IMPORT_CSV"];
		$file_id =  $insert_log["FILE_ID"];
		$created_by =  $insert_log["CREATED_BY"];
		$created_date =  $insert_log["CREATED_DATE"];
		if($created_date != ""){
			$created_date = date( "Y-m-d h:i:s", strtotime($created_date));
			$created_date = "TO_DATE('".$created_date."','yyyy-mm-dd hh24:mi:ss')";
		} else {
			$created_date = "TO_DATE(TO_CHAR(SYSDATE, 'YYYY-MM-DD HH24:MI:SS'),'yyyy-mm-dd hh24:mi:ss')";
		}
		$last_modified_by =  $insert_log["LAST_MODIFIED_BY"];
		$last_modified_date = $insert_log["LAST_MODIFIED_DATE"];
		if($last_modified_date != ""){
			$last_modified_date = date( "Y-m-d h:i:s", strtotime($last_modified_date));
			$last_modified_date = "TO_DATE('".$last_modified_date."','yyyy-mm-dd hh24:mi:ss')";
		} else {
			$last_modified_date = "TO_DATE(TO_CHAR(SYSDATE, 'YYYY-MM-DD HH24:MI:SS'),'yyyy-mm-dd hh24:mi:ss')";
		}
		$log_id_import =  $insert_log["LOG_ID_IMPORT"];
		$wpID =  $insert_log["WP_ID"];
		$modul =  $insert_log["MODUL"];
		$status_log_import =  $insert_log["STATUS_LOG_IMPORT"];
		$description_log_import =  $insert_log["DESCRIPTION_LOG_IMPORT"];
		$delimiter =  $insert_log["DELIMITED"];
		$total =  $insert_log["TOTAL"];
		$error =  $insert_log["ERROR"];
		$is_creditable =  $insert_log["IS_CREDITABLE"];
		$pembetulan =  $insert_log["PEMBETULAN"];
		$kode_cabang =  $insert_log["KODE_CABANG"];
		$jumlah_sukses_import =  $insert_log["JML_SUKSES_IMPORT"];
   
		if (!empty($insert_log)) {
				$sql1 = "Insert into SIMTAX_TARA_LOG (PAJAK_HEADER_ID,PAJAK,JENIS_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,TANGGAL_KIRIM,STATUS_UPLOAD_CSV,ENCODE_FILE,ORIGIN_FILE,
				STATUS_IMPORT_CSV,FILE_ID,CREATED_BY,CREATED_DATE,LAST_MODIFIED_BY,LAST_MODIFIED_DATE,LOG_ID_IMPORT,WP_ID,MODUL,STATUS_LOG_IMPORT,
				DESCRIPTION_LOG_IMPORT,DELIMITER,TOTAL,JUMLAH_ERROR_IMPORT,USER_SEND_SIMTAX,IS_CREDITABLE, PEMBETULAN, KODE_CABANG, JUMLAH_SUKSES_IMPORT) 
						 values ('" . $pajak_header_id . "','" . $pajak . "','" . $jenispajak . "',".$bulan.",".$tahun.",sysdate,'".$status_upload_csv."','" . $encode_file . "',
						 		'".$origin_file."','".$status_import_csv."',".$file_id.",'".$created_by."',".$created_date.",'".$last_modified_by."',".$last_modified_date.",
								 ".$log_id_import.",".$wpID .",'".$modul."','".$status_log_import."','".$description_log_import."','".$delimiter."',".$total.",
								 ".$error.",'".$user."','".$is_creditable."','".$pembetulan."','".$kode_cabang."',".$jumlah_sukses_import.")";				 					 
			$query = $this->db->query($sql1);
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
  }

  function get_csv_tara($pajak_header_id="", $kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $jenis_dokumen, $creditable="", $groupByInvoiceNUm=false)
	{

		if($pajak_header_id != ""){
			$where = " WHERE SPL.PAJAK_HEADER_ID = ".$pajak_header_id;
		}
		else{
			$whereCabang = "";
			if($kode_cabang != ""){
				$whereCabang = " AND SPH.KODE_CABANG = '".$kode_cabang."'";
			}
			$where = " WHERE SPH.NAMA_PAJAK = '".$nama_pajak."'
								AND SPH.BULAN_PAJAK = '".$bulan_pajak."'
								AND SPH.TAHUN_PAJAK = '".$tahun_pajak."'
								".$whereCabang."
								AND SPH.PEMBETULAN_KE = '".$pembetulan_ke."'";
		}

		$whereStatus = " AND UPPER(SPH.STATUS) NOT IN ('DRAFT', 'REJECT SUPERVISOR')";

		if($jenis_dokumen == "dokumen_lain"){
			$whereJenisDokumen = " AND SPL.DL_FS = '".$jenis_dokumen."'";
		}
		else{
			$whereJenisDokumen = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = '".$jenis_dokumen."')";
		}

		if($creditable == "creditable"){
			$whereCreditable = " AND SPL.IS_CREDITABLE = '1'";
		}
		elseif($creditable == "not_creditable"){
			$whereCreditable = " AND SPL.IS_CREDITABLE = '0'";
		}
		else{
			$whereCreditable = "";
		}
		
		$jumlah_potongnya = " abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN";

		if($nama_pajak == "PPN MASUKAN"){

			$mainQuery	= "SELECT distinct pajak_line_id xxxx,  SPL.*,
							NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
							SKC.NAMA_CABANG, 
							NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
							NVL(SMS.NPWP,SPL.NPWP) NPWP1,
							NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
							abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN
						        FROM SIMTAX_PAJAK_LINES SPL 
						  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
						          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
						   LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
						          ON SMS.VENDOR_ID = SPL.VENDOR_ID
						         AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
						          ON SPH.PERIOD_ID = SMP.PERIOD_ID
					      INNER JOIN SIMTAX_KODE_CABANG SKC
					              ON SPH.KODE_CABANG = SKC.KODE_CABANG
							".$where."
							".$whereStatus."
							AND IS_CHEKLIST = '1'
							".$whereJenisDokumen."
							".$whereCreditable."
							ORDER BY SPL.INVOICE_NUM DESC";
		}
		else{

			$nvl_wp  = "nvl(spl.nama_wp, smpel.customer_name) vendor_name,
						nvl(spl.npwp, smpel.npwp) npwp1,
						nvl(spl.alamat_wp, smpel.address_line1) address_line1,";

			if($jenis_dokumen == "dokumen_lain"){
				$conDokLain = " no_dokumen_lain";
			}
			else{
				$conDokLain = " no_faktur_pajak";
			}

	        $mainQuery    = "SELECT * from  
	                        (select spl.*,
			                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
			                        skc.nama_cabang,
			                        ".$nvl_wp."
					               ROW_NUMBER() OVER (PARTITION BY ".$conDokLain." ORDER BY 1) AS rn,
					               sum(abs(jumlah_potong)) over (partition by ".$conDokLain.") as jumlah_potong_ppn
					        from   simtax_pajak_lines  spl
					        inner join simtax_pajak_headers sph
		                              on spl.pajak_header_id = sph.pajak_header_id
		                       left join simtax_master_pelanggan smpel
									on smpel.customer_id      = spl.customer_id
									and smpel.organization_id = spl.organization_id
									and spl.vendor_site_id    = smpel.customer_site_id
		                      inner join simtax_master_period smp 
		                              on sph.period_id = smp.period_id
		                      inner join simtax_kode_cabang skc
		                              on sph.kode_cabang = skc.kode_cabang
							".$where."
							".$whereStatus."
							and spl.is_cheklist = '1'
							".$whereJenisDokumen."
							".$whereCreditable."
					        order BY spl.invoice_num DESC)
							WHERE  rn =1";
		}
		$query = $this->db->query($mainQuery);
		return $query;

	}

	function get_cabang_in_header_tara($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke){

		$andCab = "";
		if($kode_cabang != ""){
			$andCab = " AND KODE_CABANG = '".$kode_cabang."'";
		}

		$sql = "SELECT DISTINCT kode_cabang FROM SIMTAX_PAJAK_HEADERS
						where nama_pajak = '".$nama_pajak."'
						AND bulan_pajak = '".$bulan_pajak."'
						AND tahun_pajak = '".$tahun_pajak."'
						AND pembetulan_ke = '".$pembetulan_ke."'".$andCab;

		$query = $this->db->query($sql);

		return $query->result();
	}

	function get_pajak_header_id_tara($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke=""){

    	$this->db->select('PAJAK_HEADER_ID, PERIOD_ID');
		$this->db->from('SIMTAX_PAJAK_HEADERS');
		if($kode_cabang != ""){
			$this->db->where('KODE_CABANG', $kode_cabang);
		}
		if($pembetulan_ke != ""){
			$this->db->where('PEMBETULAN_KE', $pembetulan_ke);
		}
		$this->db->where('NAMA_PAJAK', $nama_pajak);
		$this->db->where('BULAN_PAJAK', $bulan_pajak);
		$this->db->where('TAHUN_PAJAK', $tahun_pajak);

		$query = $this->db->get();

		if($kode_cabang != ""){
			return $query->row();
		}
		else{
			return $query->result_array();
		}
	}

	function action_refresh_tara($username,$password,$rme,$base_url,$params){

		$url = $base_url.'api/v1/sign-in';
		$params_string = json_encode($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($params_string),
				'User-Agent: Mozilla/5.0')                                                                       
		);   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		$request = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if($httpCode === 200)
		{
			
			$result = json_decode($request, true);
			$token_type = "Bearer ";
			$utoken = $result['id_token'];
			$urlwp = $base_url."api/v1/wps-mine"; 
			
			//GET WP
			$api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
			$data_wp = json_decode($api_response, true);
			$id_wp = "";
			$description_log = "";
			foreach($data_wp as $row_wp){
					$wp_id = $row_wp['id'];
			}
			
			$sql = "SELECT * FROM SIMTAX_TARA_LOG
			WHERE STATUS_LOG_IMPORT NOT IN ('Selesai') AND FILE_ID NOT IN (0)";
			$query = $this->db->query($sql);
			
			if (count($query->result_array())>0){
				foreach($query->result_array() as $row)	{
					$id_import_dm = $row['FILE_ID'];
					//Log Import
					$urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm; 
								
					//GET Log Import
					$api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
					$datalog = json_decode($api_response, true);
					$description_log = $datalog['description'];
						
					 //detil log import
					 $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm."/download"; 
					 $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
					 $jsondatalog = json_decode($dtldatalog, true);
					 $expl_datalog = explode(';', $dtldatalog);
					 
					 $i=23;
					 $cnt_arr = count($expl_datalog);
					 $no=1;
					 $desc_log = "";
					 $txt_log = "";
					 $longtext = "";
					 /*
					 for ($i = 1; ; $i++) {
							 if ($i > ($cnt_arr-1)) {
									 break;
							 }
							 if (strpos($expl_datalog[$i], '=====>') !== false) {
									 $desc_log = substr($expl_datalog[$i], strpos($expl_datalog[$i], "[") + 1); 
									 $txt_log = $no.".".$desc_log;
									 $longtext .= substr($txt_log, 0, strpos($txt_log, "]"))." ";
									 $no++;
							 }
					 }
					 $description_log = $longtext;
					
					 if($jsondatalog['status'] == 400){
							 $description_log = 'Status:'.$jsondatalog['status'].' '.$jsondatalog['path'].' '.$jsondatalog['message'];
					 }
					 */
			 //end
	
					$idlog = "";
					if(!empty($datalog)){
							$sql = "update simtax_tara_log set STATUS_LOG_IMPORT ='".$datalog['status']."',
							 DELIMITER = '".$datalog['delimiter']."',
							TOTAL = ".$datalog['total'].", JUMLAH_ERROR_IMPORT = ".$datalog['error'].", JUMLAH_SUKSES_IMPORT = ".$datalog['count']."
							where WP_ID = ".$datalog['wpId']." and FILE_ID = ".$id_import_dm
							;
							
							$query = $this->db->query($sql);
							if (!$query){
								echo '2';
								curl_close($ch);
							}
					}
					//End Import Log
	
				}
				echo '1';
				curl_close($ch);
			} else {
				echo '1';
				curl_close($ch);
			}
			
		} else {
			echo '3';
			curl_close($ch);
		}
		
	}

	function getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlwp); 
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);                                                                                                                                     
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Authorization" => $token_type . $utoken,
                        "Host" => $base_url,
                ));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $result = curl_exec($ch);
                
                if(!$result){die("Connection Failure");}
                curl_close($ch);

                return $result; 
        }

		function get_master_cabang()
		{
			$cabang				= $this->kode_cabang;
			$where				= "";
			if ($cabang!='000'){
				$where	.=" and kode_cabang='".$cabang."' ";
			}
			$queryExec	        = "Select * from simtax_kode_cabang where 1=1 ".$where." and upper(aktif)='Y' order by kode_cabang";
			$query 		        = $this->db->query($queryExec);
			$result['query']	= $query;
			return $result;		
		}	

	//config tara
	function get_cfg_tara()
	{
		$where ="";
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		if($q) {
			$where	= " and parameter like '%$q%' ";
		}
		
		$queryExec = "SELECT						
						   CONFIG_TARA_ID,  
						   PARAMETER,
						   VALUE     
					FROM   SIMTAX_CONFIG_TARA
					WHERE 1=1 ".$where;	
		$queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_CONFIG_TARA where 1=1 ".$where;								
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		//start row count				
		$selectCount	= $this->db->query($queryCount);
		$row        	= $selectCount->row();       	
		$rowCount  	= $row->JML; 					  
		//end get row count
					
		$query = $this->db->query($sql);		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
							'no'				=> $row['RNUM'],				
							'config_tara_id'	=> $row['CONFIG_TARA_ID'], 
							'parameter'			=> $row['PARAMETER'],
							'value'				=> $row['VALUE']
						  );
			}
			
			$query->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}		
		return $result;		
	}

	function check_duplic_config_tara($param){

		$sql = "select count(*) TOTAL from simtax_config_tara
						where parameter is not null
						and parameter = '".strtoupper($param)."'";				
		$query	= $this->db->query($sql);
		$total	= $query->row()->TOTAL;

		return $total;

	}

	function action_save_config_tara()
	{
		$config_tara_id		= $this->input->post('edit_tara_id');
		$param				= strtoupper($this->input->post('edit_parameter'));
		$value				= $this->input->post('edit_value');

		//flag
		$isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

		if ($isNewRecord=="1") {
		$sql	="insert into SIMTAX_CONFIG_TARA
				  ( CONFIG_TARA_ID,
				   PARAMETER,
					VALUE
				  ) values (
 				    SIMTAX_CONFIG_TARA_SEQ.NEXTVAL, 
					'".$param."'
					,'".$value."'
				  )"
					 ;	
			
		} else {
			$sql	="Update SIMTAX_CONFIG_TARA
						 set PARAMETER='".$param."'
						 , VALUE='".$value."'
					   where CONFIG_TARA_ID ='".$config_tara_id."'"
						 ;	
		}
		
		$query	= $this->db->query($sql);
		
		if ($query){

			if ($isNewRecord == "1") {
				simtax_update_history("SIMTAX_CONFIG_TARA", "CREATE", "CONFIG_TARA_ID");
			}
			else{
				$params = array(
									"CONFIG_TARA_ID"       => $config_tara_id
								);
				simtax_update_history("SIMTAX_CONFIG_TARA", "UPDATE", $params);
			}

			return true;
		} else {
			return false;
		}
	}

	function action_delete_config_tara()
	{
		$tara_id	= $this->input->post('id');
		
		$sql	="delete from SIMTAX_CONFIG_TARA
		                where CONFIG_TARA_ID = ".$tara_id;	
		  
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}	
	}
	//end config tara
	
}