<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync_data_ebs extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
      redirect('dashboard', 'refresh');
    }

		$this->load->model('cabang_mdl');
		$this->load->model('Sync_data_ebs_mdl');
	}
	
	function show_page() {
		$this->template->set('title', 'Download Data EBS');
		$data['subtitle']   = "Download Data";
		$data['activepage'] = "administrator";
		
		$this->template->load('template', 'administrator/download_data_ebs',$data);
	}
	
	function download_ref() {		
		$data	= $this->Sync_data_ebs_mdl->get_download_ref();
		
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}

	function download_trx() {
		//validasi utk cek tidak boleh download kl ada data yg masih sudah pernah disubmit
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		
		$sql	="  select count(1) ADA_DATA 
					  from simtax_pajak_headers
					 where NAMA_PAJAK = decode('".$jenis_trx."'
                            ,'PPH4_2', 'PPH PSL 4 AYAT 2'
                            ,'PPH15', 'PPH PSL 15'
							,'PPH21', 'PPH PSL 21'
                            ,'PPH22', 'PPH PSL 22'
                            ,'PPH23', 'PPH PSL 23'
                            ,'PPH26', 'PPH PSL 26'
							,'PPH2326', 'PPH PSL 23 DAN 26'
                            ,'PPNKELUAR', 'PPN KELUARAN'
                            ,'PPNMASUK', 'PPN MASUKAN'
                            ,'PPNWAPU', 'PPN WAPU'
							,'APBONUS','AP BONUS'
                            )
					   and BULAN_PAJAK = '".$bulan."'
					   and TAHUN_PAJAK = '".$tahun."'
					   and KODE_CABANG = '".$kode_cabang."'
					   and STATUS not in ('DRAFT')
					  ";		

		$qReqID     = $this->db->query($sql);
		$row        = $qReqID->row();       	
		$isAdaData  = $row->ADA_DATA;
		
		if($jenis_trx == 'GLJE'){
			$sql	="  select count(1) ADA_DATA 
					  from simtax_detail_jurnal_transaksi
					 where BULAN_BUKU = '".$bulan."'
					   and TAHUN_BUKU = '".$tahun."'
					   and KODE_CABANG = '".$kode_cabang."'
					   and STATUSDOKUMEN not in ('DRAFT')
					  ";		

			$qReqID     = $this->db->query($sql);
			$row        = $qReqID->row();       	
			$isAdaData  = $row->ADA_DATA;
			if($isAdaData > 0){
				$isAdaData = 1;
			}
		}

		// end validasi
		set_time_limit(0);
		
		if ($isAdaData == 1) {
			echo '2';	
		} else {
			$data	= $this->Sync_data_ebs_mdl->get_download_trx();
			
			if($data){
				echo '1';
			} else {
				echo '0';
			}
		}
	}

	function download_trx_fa() {
		//validasi utk cek tidak boleh download kl ada data yg masih sudah pernah disubmit
		$bulanfrom		= $this->input->post('srcBulanfrom');
		$bulanto		= $this->input->post('srcBulanto');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		$lanjut = '';

		for ($bulan = $bulanfrom; $bulan <= $bulanto; $bulan++) {
		
				$sql	="  select count(1) ADA_DATA 
							from simtax_pajak_headers
							where NAMA_PAJAK = decode('".$jenis_trx."'
									,'FAFISKAL','FIXED ASSET'
									)
							and BULAN_PAJAK = '".$bulan."'
							and TAHUN_PAJAK = '".$tahun."'
							and KODE_CABANG = '".$kode_cabang."'
							and STATUS not in ('DRAFT')
							";		

				$qReqID     = $this->db->query($sql);
				$row        = $qReqID->row();       	
				$isAdaData  = $row->ADA_DATA; 

				// end validasi
				set_time_limit(0);
				
				if ($isAdaData == 1) {
					echo '2';
					break;	
				} else {
					$data	= $this->Sync_data_ebs_mdl->get_download_trx_fa($bulan);
					
					if($data){
						//echo '1';
						$lanjut = '1';
					} else {
						echo '0';
						break;
					}
				}
		}

		if($lanjut === '1'){
			echo '1';
		}
	}
	
	function download_tb() {		
		set_time_limit(0);
		$data	= $this->Sync_data_ebs_mdl->get_download_tb();
		
		if($data){
			echo '1';
		} else {
			echo '0';
		}		
	}	

	function process_trx() {
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		$perusahaan		= $this->input->post('scrPerusahaan');
		
		$sql	=" select CONCURRENT_REQUEST_ID 
				     from simtax_getdata_history
				    where IMPORT_TO_SIMTAX_FLAG = 'N'
					  and parameter1 = '".$bulan."'
				      and parameter2 = '".$tahun."'
				      and parameter3 = '".$kode_cabang."'
				      and parameter4 = '".$perusahaan."'
				      and parameter5 = '".$jenis_trx."'
            ";

		$qReqID     = $this->db->query($sql);
		$row        = $qReqID->row();       	
		$ConcReqId  = $row->CONCURRENT_REQUEST_ID; 					  
		
		$file_path  =  "./download/ebs/unprocess/o".$ConcReqId.".csv";
		$moved_path =  "./download/ebs/process/o".$ConcReqId.".csv";
		
		set_time_limit(0);		
		
		if (file_exists($file_path)) {		
			if ($jenis_trx == "ACCPPH21" or $jenis_trx == "PPH21DTL") {
				$data	= $this->Sync_data_ebs_mdl->do_process_ref($file_path,$jenis_trx);
				if($data){

					$sql	="update simtax_getdata_history
								 set IMPORT_TO_SIMTAX_FLAG = 'Y'
							   where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
							  ";
					$this->db->query($sql);		
						
					rename($file_path, $moved_path);
					echo '1'; 
				} else {
					echo '0'; //file to staging failed
				}	
				
			} else {
				$data	= $this->Sync_data_ebs_mdl->do_process_trx($file_path,$ConcReqId,$jenis_trx);
				if ($jenis_trx != 'FAFISKAL' && $jenis_trx != 'APBONUS' && $jenis_trx != 'SPPD' && $jenis_trx != 'GLJE') 
				{          
					if($data){
						$data2	= $this->Sync_data_ebs_mdl->do_import_trx($bulan,$tahun,$ConcReqId,$jenis_trx);
						if ($data2) {

						$pajak_header_id = $this->simtax->get_max_header_id();
						$param = array("PAJAK_HEADER_ID" => $pajak_header_id);

						// simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);

						rename($file_path, $moved_path);
						echo '1'; //all success

						} else {
						echo '3'; //staging to base table failed
						}
						
					} else {
						echo '0'; //file to staging failed
					}
				} else {
					if (!$data) {
						echo '3';
					} else {
						if ($jenis_trx == "FAFISKAL" || $jenis_trx == "APBONUS" || $jenis_trx == "SPPD" || $jenis_trx == "GLJE"){
							$sql	="update simtax_getdata_history
								 		set IMPORT_TO_SIMTAX_FLAG = 'Y'
							   			where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
							  ";
							$this->db->query($sql);	
						}
						rename($file_path, $moved_path); 
						echo '1';
					}
				}
			}			
		} else {
			echo '2'; // file not found
		}
	}	

	function process_trx_fa() {
		$bulanfrom		= $this->input->post('srcBulanfrom');
		$bulanto		= $this->input->post('srcBulanto');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcKodeCabang');
		$jenis_trx		= $this->input->post('scrJenis');
		$perusahaan		= $this->input->post('scrPerusahaan');

		$lanjut = '';

		for ($vbulan = $bulanfrom; $vbulan <= $bulanto; $vbulan++) {
		
			$sql	=" select CONCURRENT_REQUEST_ID 
				     from simtax_getdata_history
				    where IMPORT_TO_SIMTAX_FLAG = 'N'
					  and parameter1 = '".$vbulan."'
				      and parameter2 = '".$tahun."'
				      and parameter3 = '".$kode_cabang."'
				      and parameter4 = '".$perusahaan."'
				      and parameter5 = '".$jenis_trx."'
            ";
			
			$qReqID     = $this->db->query($sql);
			$row        = $qReqID->row();   
			
			if ($row)
				{

					$ConcReqId  = $row->CONCURRENT_REQUEST_ID;

					$file_path  =  "./download/ebs/unprocess/o".$ConcReqId.".csv";
					$moved_path =  "./download/ebs/process/o".$ConcReqId.".csv";
					
					set_time_limit(0);		
					
					if (file_exists($file_path)) {		
						
						$data	= $this->Sync_data_ebs_mdl->do_process_trx($file_path,$ConcReqId,$jenis_trx);
						if (!$data) {
							echo '3';
							break;
						} else {
							$sql	="update simtax_getdata_history
										set IMPORT_TO_SIMTAX_FLAG = 'Y'
										where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
								";
							$this->db->query($sql);	
							rename($file_path, $moved_path); 
							//echo '1';
							$lanjut = '1';
						}
						
					} else {
						echo '2'; // file not found
						break;
					}

				} else {
					echo '2'; // file not found
					break;
				}
		}

		if($lanjut === '1'){
			echo '1';
		}
	
	}	
	
	function process_ref() {
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$jenis_trx		= $this->input->post('scrJenis');
		
		$sql	=" select CONCURRENT_REQUEST_ID 
				     from simtax_getdata_history
				    where IMPORT_TO_SIMTAX_FLAG = 'N'
					  and parameter1 = '".$bulan."'
				      and parameter2 = '".$tahun."'
				      and parameter5 = '".$jenis_trx."'
					  ";
		
		$qReqID     = $this->db->query($sql);
		$row        = $qReqID->row();       	
		$ConcReqId  = $row->CONCURRENT_REQUEST_ID; 					  
		
		$file_path  =  "./download/ebs/unprocess/o".$ConcReqId.".csv";
		$moved_path =  "./download/ebs/process/o".$ConcReqId.".csv";
		
		if (file_exists($file_path)) {
			$data	= $this->Sync_data_ebs_mdl->do_process_ref($file_path,$jenis_trx);
			if($data){
				$sql	="update simtax_getdata_history
							 set IMPORT_TO_SIMTAX_FLAG = 'Y'
						   where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
						  ";
				$this->db->query($sql);		
					
				rename($file_path, $moved_path);
				echo '1'; 
			} else {
				echo '0'; //file to staging failed
			}			
		} else {
			echo '2'; // file not found
		}
	}	
	
	function process_tb() {
		$bulan			= $this->input->post('srcBulan');
		$tahun			= $this->input->post('srcTahun');	
		$kode_cabang	= $this->input->post('srcAkun');
		$ledger			= $this->input->post('srcLedger');
		
		if ($kode_cabang != "TBGLBAL"){
			$sql	=" select CONCURRENT_REQUEST_ID
						from simtax_getdata_history
						where IMPORT_TO_SIMTAX_FLAG = 'N'
						and parameter1 = '".$bulan."'
						and parameter2 = '".$tahun."'
						and parameter3 = '".$kode_cabang."'
						and parameter4 = '".$ledger."'
						and parameter5 = 'TRIBAL'
						";
			
			$qReqID     = $this->db->query($sql);
			$row        = $qReqID->row();  
			$ConcReqId  = $row->CONCURRENT_REQUEST_ID; 		
			$sqlDel	="	
					delete from simtax_rincian_bl_pph_badan
						where tahun_pajak = '".$tahun."'
							and bulan_pajak = '".$bulan."'
							--and kode_cabang = '".$kode_cabang."'
							and substr(KODE_AKUN,1,1) = '".$kode_cabang."'
							and ledger_id = '".$ledger."'
							and request_id not in ('".$ConcReqId."')";
			$this->db->query($sqlDel);				
		} else {
			$sql	=" select CONCURRENT_REQUEST_ID
						from simtax_getdata_history
						where IMPORT_TO_SIMTAX_FLAG = 'N'
						and parameter1 = '".$bulan."'
						and parameter2 = '".$tahun."'
						and parameter3 = 'TBGLBAL'
						and parameter4 = '".$ledger."'
						and parameter5 = 'TRIBAL'
						";
			
			$qReqID     = $this->db->query($sql);
			$row        = $qReqID->row();  
			$ConcReqId  = $row->CONCURRENT_REQUEST_ID; 		
			$sqlDel	="	
					delete from gl_balances
						where period_year = '".$tahun."'
							and period_num = '".$bulan."'
							and ledger_id = '".$ledger."'";
			$this->db->query($sqlDel);	
		}
		
		$file_path  =  "./download/ebs/unprocess/o".$ConcReqId.".csv";
		$moved_path =  "./download/ebs/process/o".$ConcReqId.".csv";
		$split_path  =  "./download/ebs/unprocess/o";
		
		if (file_exists($file_path)) {
			//disini lakukan split
			$csv = array();
			$row = 0;
			$handle = fopen($file_path, "r");
			$batchsize = 5000;
			$rowcsv = 1;
			if ($kode_cabang != "TBGLBAL"){
					while (($data = fgetcsv($handle, 1000, ";","'","\\")) !== FALSE) {
						if ($row % $batchsize == 0):
						$split_file_name = $split_path.$ConcReqId."$row.csv";
						$file = fopen($split_file_name,"w");
									$csv[$rowcsv]= $split_file_name;
									$rowcsv++;
						endif;	

						$kolom 	=   "'".$data[0]."';'".
						$data[1]."';'".
						$data[2]."';'".
						$data[3]."';'".
						$data[4]."';'".
						$data[5]."';'".
						$data[6]."';'".
						$data[7]."';'".
						$data[8]."';'".
						$data[9]."';'".
						$data[10]."';'".
						$data[11]."';'".
						$data[12]."';'".
						$data[13]."';'".
						$data[14]."';'".
						$data[15]."'";

						$json = "$kolom";
						fwrite($file,$json.PHP_EOL);
						$row++; 						
					}
					//end split

					//proses sesuai batchnya			
					set_time_limit(0);
					for ($x = 1; $x <= count($csv); $x++) {
						$data	= $this->Sync_data_ebs_mdl->do_process_tb($csv[$x],$ConcReqId);
						if ($data) {
							continue;
						}
					}
					//end proses batchnya
			} else {
				while (($data = fgetcsv($handle, 1000, ";","'","\\")) !== FALSE) {
					if ($row % $batchsize == 0):
					$split_file_name = $split_path.$ConcReqId."$row.csv";
					$file = fopen($split_file_name,"w");
								$csv[$rowcsv]= $split_file_name;
								$rowcsv++;
					endif;	

					$kolom 	=   "'".$data[0]."';'".
					$data[1]."';'".
					$data[2]."';'".
					$data[3]."';'".
					$data[4]."';'".
					$data[5]."';'".
					$data[6]."';'".
					$data[7]."';'".
					$data[8]."';'".
					$data[9]."';'".
					$data[10]."';'".
					$data[11]."';'".
					$data[12]."';'".
					$data[13]."';'".
					$data[14]."';'".
					$data[15]."';'".
					$data[16]."';'".
					$data[17]."';'".
					$data[18]."';'".
					$data[19]."';'".
					$data[20]."'";

					$json = "$kolom";
					fwrite($file,$json.PHP_EOL);
					$row++; 						
				}
				//end split

				//proses sesuai batchnya			
				set_time_limit(0);
				for ($x = 1; $x <= count($csv); $x++) {
					$data	= $this->Sync_data_ebs_mdl->do_process_tb_kk($csv[$x],$ConcReqId);
					if ($data) {
						continue;
					}
				}
				//end proses batchnya
			}

			if($data){
				$sql	="update simtax_getdata_history
							 set IMPORT_TO_SIMTAX_FLAG = 'Y'
						   where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
						  ";
				$this->db->query($sql);		
					
				rename($file_path, $moved_path);
				echo '1'; 
			} else {
				echo '0'; 
			}									
		} else {
			echo '2'; // file not found
		}
	}	
	
	function load_history() {		
    $hasil		= $this->Sync_data_ebs_mdl->get_history();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
        $ii++;
        $result['data'][] = array(
          'req_id'        => $row['CONCURRENT_REQUEST_ID'],
          'req_date'      => $row['REQUESTED_DATE'],
          'bulan'         => $row['BULAN'],
          'tahun'         => $row['TAHUN'],
          'kode_cabang'   => $row['KODE_CABANG'],
          'tipe_doc'      => $row['TIPE_DOKUMEN'],
          'import_flag'   => $row['IMPORT_TO_SIMTAX_FLAG'],
          'import_date'   => $row['IMPORT_TO_SIMTAX_DATE'],
          'rep_req_id'    => $row['REPLACE_BY_CONC_REQ_ID'],
          'nama_cabang'   => $row['NAMA_CABANG'],
          'status_import' => $row['STATUS_IMPORT']
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
		echo json_encode($result);
  }	
}