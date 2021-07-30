<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fixed_asset extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		if (!$this->ion_auth->logged_in()) {
			redirect('dashboard', 'refresh');
		}

		$this->load->model('Fixed_asset_mdl');
		$this->kode_cabang = $this->session->userdata('kd_cabang');		
	}	
	
	public function tgl_db($date) {
		$part = explode("/",$date);
		$newDate = $part[2]."-".$part[1]."-".$part[0];
		return $newDate;
	}
	
	function show_rekonsiliasi() {
		$this->template->set('title', 'Fixed Asset');
		$data['subtitle']	= "Fixed Asset ";			
    $data['activepage'] = "fixed_asset";
		$this->template->load('template', 'fixed_asset/rekonsiliasi',$data);
  }
  
  function load_rekonsiliasi() {
    $KELOMPOK_ASSET = $this->input->post('_kelompokasset');
    $hasil		= $this->Fixed_asset_mdl->get_daftar($KELOMPOK_ASSET);
		$rowCount	= $hasil['rowCount'] ;
		$datas 		= $hasil['query'];	
		
		if ($rowCount>0){
			$ii	=	0;
			foreach($datas->result_array() as $row)	{
				$ii++;
				$checked	= ($row['IS_CHECKLIST']==1)?"checked":"";
				$vdisabled	= ($row['STATUS']=='CLOSE' or $row['STATUS']=='SUBMIT')?"disabled":"";
				$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
						<input id='checkbox-bulanan".$row['RNUM']."' class='checklist bulanan' type='checkbox' ".$checked." ".$vdisabled." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['ASSET_NO']."'>
						<label for='checkbox-bulanan".$row['RNUM']."'>&nbsp;</label>
					</div>";
				$vDatetglbeli = "";	
				if ($row['TANGGAL_BELI'] != ""){
					$vDatetglbeli = date("Y-m-d", strtotime($row['TANGGAL_BELI']));
				}
				$vDatetgljual = "";	
				if ($row['TANGGAL_JUAL'] != ""){
					$vDatetgljual = date("Y-m-d", strtotime($row['TANGGAL_JUAL']));	
				}	
				
				$result['data'][] = array(      
				'checkbox'			        		=> $checkbox,
				'no'				        		=> $row['RNUM'],
				'ASSET_NO'							=> $row['ASSET_NO'],
				'JENIS_AKTIVA'						=> $row['JENIS_AKTIVA'],
				'NAMA_AKTIVA'				       	=> $row['NAMA_AKTIVA'],
				'KETERANGAN'	        			=> $row['KETERANGAN'],
				'TANGGAL_BELI'			    		=> $vDatetglbeli,
				'HARGA_PEROLEHAN'					=> number_format($row['HARGA_PEROLEHAN'],2,'.',','),
				'KELOMPOK_AKTIVA'			        => $row['KELOMPOK_AKTIVA'],
				'JENIS_HARTA'						=> $row['JENIS_HARTA'],
				'JENIS_USAHA' 		        		=> $row['JENIS_USAHA'],
				'STATUS_PEMBEBANAN' 	            => $row['STATUS_PEMBEBANAN'],
				'TANGGAL_JUAL' 	            		=> $vDatetgljual,
				'HARGA_JUAL' 	                    => number_format($row['HARGA_JUAL'],2,'.',','),
				'PH_FISKAL' 	                    => number_format($row['PH_FISKAL'],2,'.',','),
				'AKUMULASI_PENYUSUTAN_FISKAL' 		=> number_format($row['AKUMULASI_PENYUSUTAN_FISKAL'],2,'.',','),
				'NILAI_SISA_BUKU_FISKAL' 		    => number_format($row['NILAI_SISA_BUKU_FISKAL'],2,'.',','),
				'PENYUSUTAN_FISKAL' 		    	=> number_format($row['PENYUSUTAN_FISKAL'],2,'.',','),
				'PEMBEBANAN' 		    			=> number_format($row['PEMBEBANAN'],2,'.',','),
				'AKUMULASI_PENYUSUTAN' 		    	=> number_format($row['AKUMULASI_PENYUSUTAN'],2,'.',','),
				'NSBF' 		    					=> number_format($row['NSBF'],2,'.',','),
				'KODE_CABANG'						=> $row['KODE_CABANG'],
				'KELOMPOK_FIXED_ASSET' 				=> $row['KELOMPOK_FIXED_ASSET'],
				'IS_CHECKLIST'						=> $row['IS_CHECKLIST'],
				'REKON_FIXED_ASSET_ID'				=> $row['REKON_FIXED_ASSET_ID'],
				'MASA_PAJAK'						=> $row['MASA_PAJAK'],
				'TAHUN_PAJAK'						=> $row['TAHUN_PAJAK']
				);
			}
			
      $datas->free_result();

      $datas = $hasil['querysum'];
      foreach($datas->result_array() as $row)	{
        $result['harga_perolehan'] = $row['HARGA_PEROLEHAN'];
      }
      $datas->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}
		//print_r($result);exit();	
		echo json_encode($result);
  }	

  function check_rekonsiliasi() {
		$data	= $this->Fixed_asset_mdl->action_check_rekonsiliasi();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
  }
  
  function show_closing() {
		$this->template->set('title', 'Fixed Asset');
		$data['subtitle']	= "Closing Fixed Asset";
		$data['activepage'] = "fixed_asset";
		$this->template->load('template', 'fixed_asset/closing',$data);
  }
  
  function show_view() {
		$this->template->set('title', 'Fixed Asset');
		$data['subtitle']	= "View Status Fixed Asset";
		$data['activepage'] = "fixed_asset";
		$this->template->load('template', 'fixed_asset/view',$data);
  }
  
  function archive_link() {
		$this->template->set('title', 'Archive Link');
		$data['subtitle']   = "Archive Link";
		$data['activepage'] = "fixed_asset";
		
		$data['stand_alone'] = true;
		$group_pajak         = get_daftar_pajak("FA");
		
		$list_pajak          = array();
	
		foreach ($group_pajak as $key => $value) {
			$list_pajak[] = $value->JENIS_PAJAK;
		}

		$data['nama_pajak']  = $list_pajak;
		
		$this->template->load('template', 'administrator/archive_link',$data);
  }
  
  function export_format_csv() {
    $this->load->helper('csv_helper');
    $bulanfrom = ($_REQUEST['bulanfrom'])? $_REQUEST['bulanfrom']:"";
	$bulanto = ($_REQUEST['bulanto'])? $_REQUEST['bulanto']:"";
    $tahun = ($_REQUEST['tahun'])? $_REQUEST['tahun']:"";
    $jenisasset = ($_REQUEST['jenisasset'])? $_REQUEST['jenisasset']:"";
    $data       = $this->Fixed_asset_mdl->get_format_csv($jenisasset);
    $export_arr = array();
    $title 		= array("Jenis Aktiva","Nama Aktiva","Keterangan","Tanggal Beli","Harga Perolehan","Kelompok Aktiva","Jenis Harta",
	  "Jenis Usaha","Kode Cabang","Kelompok Fixed Asset", 
	  "Status Pembebanan","Tanggal Jual","Harga Jual","PH Fiskal","Akumulasi Penyusutan Fiskal",
      "Nilai Sisa buku Fiskal","Penyusutan Fiskal","Pembebanan","Akumulasi Penyusutan","NSBF","Nomor Asset","Rekon Fixed Asset ID","Pajak Header ID",
	  "Bulan Pajak","Tahun Pajak");
    array_push($export_arr, $title);
    if (!empty($data)) {         
			foreach($data->result_array() as $row)	{
				$sqlhdr =" 
				select nama_cabang
					from simtax_kode_cabang
					where aktif = 'Y' 
					and kode_cabang = '".$row['KODE_CABANG']."'
				";

				$qReq   		= $this->db->query($sqlhdr);
				$vrows  		= $qReq->row();
				$vnamacbg  	= $vrows->NAMA_CABANG;							
				array_push($export_arr, array($row['JENIS_AKTIVA'], str_replace(',','.',$row['NAMA_AKTIVA']), $row['KETERANGAN'], $row['TANGGAL_BELI'], $row['HARGA_PEROLEHAN'], $row['KELOMPOK_AKTIVA'], $row['JENIS_HARTA'], $row['JENIS_USAHA'],
				$vnamacbg, $row['KELOMPOK_FIXED_ASSET'],
				$row['STATUS_PEMBEBANAN'], $row['TANGGAL_JUAL'], $row['HARGA_JUAL'], $row['PH_FISKAL'], $row['AKUMULASI_PENYUSUTAN_FISKAL'], $row['NILAI_SISA_BUKU_FISKAL'],
				$row['PENYUSUTAN_FISKAL'], $row['PEMBEBANAN'], $row['AKUMULASI_PENYUSUTAN'], $row['NSBF'],$row['ASSET_NO'],$row['REKON_FIXED_ASSET_ID'],$row['PAJAK_HEADER_ID'],
				$row['BULAN_PAJAK'],$row['TAHUN_PAJAK']));
			}
    }
    convert_to_csv_PPH21($export_arr,'Fixed Asset '.$bulanfrom.'-'.$bulanto.' '.$tahun.' '.$jenisasset.'.csv', ';');
  }

  function save_rekonsiliasi() {
    if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("fixed_asset/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true) {
      $data	= $this->Fixed_asset_mdl->save_rekonsiliasi();
			if($data){			
				echo $data;
			} else {			
				echo '0';
			}
		} else {
			echo '0';
    }
  }

  	function load_sum_bnt() {
		$KEL_ASSET1 = $this->input->post('_kelasset1');
		$KEL_ASSET2 = $this->input->post('_kelasset2');
		$KEL_ASSET3 = $this->input->post('_kelasset3');
		$hasil    = $this->Fixed_asset_mdl->get_summ_fa_bnbtb($KEL_ASSET1,$KEL_ASSET2,$KEL_ASSET3);			
		foreach($hasil->result_array() as $row)	{						
			$result['sumfab'] = $row['SUMM_HP_B'];
			$result['sumfanb'] = $row['SUMM_HP_N'];
			$result['sumfatb'] = $row['SUMM_HP_T'];
			$result['cntsubmit'] = $row['CNT_SUBMIT'];
			$result['status_rekon'] = $row['STATUS_REKON'];
		}

		echo json_encode($result);
		$hasil->free_result();
	}

	function delete_rekon() 
   	{
		$data	= $this->Fixed_asset_mdl->action_delete_rekon();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
		
	}

	function delete_rekon_nb() 
   	{
		$data	= $this->Fixed_asset_mdl->action_delete_rekon();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
		
	}

	function delete_rekon_tb() 
   	{
		$data	= $this->Fixed_asset_mdl->action_delete_rekon();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
		
	}

	function submit_rekonsiliasi()
	{
		$data = $this->Fixed_asset_mdl->action_submit_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function reject_rekonsiliasi()
	{
		$data = $this->Fixed_asset_mdl->action_reject_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function get_selectAll_b()
	{
		$data = $this->Fixed_asset_mdl->action_get_selectAll_b();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function get_selectAll_final()
	{
		$data = $this->Fixed_asset_mdl->action_get_selectAll_final();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function get_selectAll_nonfinal()
	{
		$data = $this->Fixed_asset_mdl->action_get_selectAll_nonfinal();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function load_rekonsiliasi_nb() {
		$KELOMPOK_ASSET = $this->input->post('_kelompokasset');
    	$hasil		= $this->Fixed_asset_mdl->get_daftar($KELOMPOK_ASSET);
		$rowCount	= $hasil['rowCount'] ;
		$datas 		= $hasil['query'];	
		
		if ($rowCount>0){
			$ii	=	0;
			foreach($datas->result_array() as $row)	{
				$ii++;
				$checked	= ($row['IS_CHECKLIST']==1)?"checked":"";
				$vdisabled	= ($row['STATUS']=='CLOSE' or $row['STATUS']=='SUBMIT')?"disabled":"";
				$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
						<input id='checkbox-final".$row['RNUM']."' class='checklist final' type='checkbox' ".$checked." ".$vdisabled." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['ASSET_NO']."'>
						<label for='checkbox-final".$row['RNUM']."'>&nbsp;</label>
					</div>";
				$vDatetglbeli = "";	
				if ($row['TANGGAL_BELI'] != ""){
					$vDatetglbeli = date("Y-m-d", strtotime($row['TANGGAL_BELI']));
				}
				$vDatetgljual = "";	
				if ($row['TANGGAL_JUAL'] != ""){
					$vDatetgljual = date("Y-m-d", strtotime($row['TANGGAL_JUAL']));	
				}	
				
				$result['data'][] = array(      
				'checkbox'			        		=> $checkbox,
				'no'				        		=> $row['RNUM'],
				'ASSET_NO'							=> $row['ASSET_NO'],
				'JENIS_AKTIVA'						=> $row['JENIS_AKTIVA'],
				'NAMA_AKTIVA'				       	=> $row['NAMA_AKTIVA'],
				'KETERANGAN'	        			=> $row['KETERANGAN'],
				'TANGGAL_BELI'			    		=> $vDatetglbeli,
				'HARGA_PEROLEHAN'					=> number_format($row['HARGA_PEROLEHAN'],2,'.',','),
				'KELOMPOK_AKTIVA'			        => $row['KELOMPOK_AKTIVA'],
				'JENIS_HARTA'						=> $row['JENIS_HARTA'],
				'JENIS_USAHA' 		        		=> $row['JENIS_USAHA'],
				'STATUS_PEMBEBANAN' 	            => $row['STATUS_PEMBEBANAN'],
				'TANGGAL_JUAL' 	            		=> $vDatetgljual,
				'HARGA_JUAL' 	                    => number_format($row['HARGA_JUAL'],2,'.',','),
				'PH_FISKAL' 	                    => number_format($row['PH_FISKAL'],2,'.',','),
				'AKUMULASI_PENYUSUTAN_FISKAL' 		=> number_format($row['AKUMULASI_PENYUSUTAN_FISKAL'],2,'.',','),
				'NILAI_SISA_BUKU_FISKAL' 		    => number_format($row['NILAI_SISA_BUKU_FISKAL'],2,'.',','),
				'PENYUSUTAN_FISKAL' 		    	=> number_format($row['PENYUSUTAN_FISKAL'],2,'.',','),
				'PEMBEBANAN' 		    			=> number_format($row['PEMBEBANAN'],2,'.',','),
				'AKUMULASI_PENYUSUTAN' 		    	=> number_format($row['AKUMULASI_PENYUSUTAN'],2,'.',','),
				'NSBF' 		    					=> number_format($row['NSBF'],2,'.',','),
				'KODE_CABANG'						=> $row['KODE_CABANG'],
				'KELOMPOK_FIXED_ASSET' 				=> $row['KELOMPOK_FIXED_ASSET'],
				'IS_CHECKLIST'						=> $row['IS_CHECKLIST'],
				'REKON_FIXED_ASSET_ID'				=> $row['REKON_FIXED_ASSET_ID'],
				'MASA_PAJAK'						=> $row['MASA_PAJAK'],
				'TAHUN_PAJAK'						=> $row['TAHUN_PAJAK']
				);
			}
			
      $datas->free_result();

      $datas = $hasil['querysum'];
      foreach($datas->result_array() as $row)	{
        $result['harga_perolehan'] = $row['HARGA_PEROLEHAN'];
      }
      $datas->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}
		//print_r($result);exit();	
		echo json_encode($result);
	  }	

	  function load_rekonsiliasi_tb() {
		$KELOMPOK_ASSET = $this->input->post('_kelompokasset');
    	$hasil		= $this->Fixed_asset_mdl->get_daftar($KELOMPOK_ASSET);
		$rowCount	= $hasil['rowCount'] ;
		$datas 		= $hasil['query'];	
		
		if ($rowCount>0){
			$ii	=	0;
			foreach($datas->result_array() as $row)	{
				$ii++;
				$checked	= ($row['IS_CHECKLIST']==1)?"checked":"";
				$vdisabled	= ($row['STATUS']=='CLOSE' or $row['STATUS']=='SUBMIT')?"disabled":"";
				$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
						<input id='checkbox-nonfinal".$row['RNUM']."' class='checklist nonfinal' type='checkbox' ".$checked." ".$vdisabled." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['ASSET_NO']."'>
						<label for='checkbox-nonfinal".$row['RNUM']."'>&nbsp;</label>
					</div>";
				$vDatetglbeli = "";	
				if ($row['TANGGAL_BELI'] != ""){
					$vDatetglbeli = date("Y-m-d", strtotime($row['TANGGAL_BELI']));
				}
				$vDatetgljual = "";	
				if ($row['TANGGAL_JUAL'] != ""){
					$vDatetgljual = date("Y-m-d", strtotime($row['TANGGAL_JUAL']));	
				}	
				
				$result['data'][] = array(      
				'checkbox'			        		=> $checkbox,
				'no'				        		=> $row['RNUM'],
				'ASSET_NO'							=> $row['ASSET_NO'],
				'JENIS_AKTIVA'						=> $row['JENIS_AKTIVA'],
				'NAMA_AKTIVA'				       	=> $row['NAMA_AKTIVA'],
				'KETERANGAN'	        			=> $row['KETERANGAN'],
				'TANGGAL_BELI'			    		=> $vDatetglbeli,
				'HARGA_PEROLEHAN'					=> number_format($row['HARGA_PEROLEHAN'],2,'.',','),
				'KELOMPOK_AKTIVA'			        => $row['KELOMPOK_AKTIVA'],
				'JENIS_HARTA'						=> $row['JENIS_HARTA'],
				'JENIS_USAHA' 		        		=> $row['JENIS_USAHA'],
				'STATUS_PEMBEBANAN' 	            => $row['STATUS_PEMBEBANAN'],
				'TANGGAL_JUAL' 	            		=> $vDatetgljual,
				'HARGA_JUAL' 	                    => number_format($row['HARGA_JUAL'],2,'.',','),
				'PH_FISKAL' 	                    => number_format($row['PH_FISKAL'],2,'.',','),
				'AKUMULASI_PENYUSUTAN_FISKAL' 		=> number_format($row['AKUMULASI_PENYUSUTAN_FISKAL'],2,'.',','),
				'NILAI_SISA_BUKU_FISKAL' 		    => number_format($row['NILAI_SISA_BUKU_FISKAL'],2,'.',','),
				'PENYUSUTAN_FISKAL' 		    	=> number_format($row['PENYUSUTAN_FISKAL'],2,'.',','),
				'PEMBEBANAN' 		    			=> number_format($row['PEMBEBANAN'],2,'.',','),
				'AKUMULASI_PENYUSUTAN' 		    	=> number_format($row['AKUMULASI_PENYUSUTAN'],2,'.',','),
				'NSBF' 		    					=> number_format($row['NSBF'],2,'.',','),
				'KODE_CABANG'						=> $row['KODE_CABANG'],
				'KELOMPOK_FIXED_ASSET' 				=> $row['KELOMPOK_FIXED_ASSET'],
				'IS_CHECKLIST'						=> $row['IS_CHECKLIST'],
				'REKON_FIXED_ASSET_ID'				=> $row['REKON_FIXED_ASSET_ID'],
				'MASA_PAJAK'						=> $row['MASA_PAJAK'],
				'TAHUN_PAJAK'						=> $row['TAHUN_PAJAK']
				);
			}
			
      $datas->free_result();

      $datas = $hasil['querysum'];
      foreach($datas->result_array() as $row)	{
        $result['harga_perolehan'] = $row['HARGA_PEROLEHAN'];
      }
      $datas->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}
		//print_r($result);exit();	
		echo json_encode($result);
	  }
	  
	  function load_closing()
	{
		$hasil = $this->Fixed_asset_mdl->get_closing();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				if ($row['STATUS'] == "Open") {
					$st = "<span class='label label-success'>" . $row['STATUS'] . "</span>";
				} else {
					$st = "<span class='label label-danger'>" . $row['STATUS'] . "</span>";
				}
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'cabang' => $row['KODE_CABANG'],
					'params' => $row['STATUS'],
					'status' => $st
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}

	function save_closing()
	{
		$data = $this->Fixed_asset_mdl->action_save_closing();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function get_start()
	{
		$data = $this->fixed_asset_mdl->action_get_start();
		if ($data) {
			if ($data->num_rows() > 0) {
				$row = $data->row();
				$result['status'] = strtoupper($row->STATUS);
				$result['status_period'] = strtoupper($row->STATUS_PERIOD);
				//$result['keterangan'] 	 = $row->KETERANGAN;
			} else {
				$result['status'] = "-------------";
				$result['status_period'] = " ----------";
				//$result['keterangan'] 	 = "";
			}
			$result['isSuccess'] = 1;
		} else {
			$result['isSuccess'] = 0;
		}
		echo json_encode($result);
		$data->free_result();
	}

	function load_view()
	{
		$hasil = $this->Fixed_asset_mdl->get_view();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'creation_date' => $row['CREATION_DATE'],
					'user_name' => $row['USER_NAME'],
					'status' => $row['STATUS'],
					'tgl_submit_sup' => $row['TGL_SUBMIT_SUP'],
					'tgl_approve_sup' => $row['TGL_APPROVE_SUP'],
					'tgl_approve_pusat' => $row['TGL_APPROVE_PUSAT'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'ttl_jml_potong' => number_format($row['TTL_JML_POTONG'], 2, '.', ',')
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}

	//import
	function import_CSV() {
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
			   @set_time_limit(0);
		 }
		 //$og_id          = $this->cabang_mdl->get_og_id($this->kode_cabang);
		 if (!empty($_FILES['file_csv']['name'])){
			 $path 	= $_FILES['file_csv']['name'];
			 $ext  	= pathinfo($path, PATHINFO_EXTENSION);
			 $file_name = "Fixed_Asset";	
			 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			 if ($ext=='csv'){
				 if($upl = $this->_upload('file_csv', 'fixed_asset/csv/', $file_name, 'csv', $ext)){					
					 $row      = 1;
					 $handle   = fopen("./uploads/fixed_asset/csv/".$file_name.".".$ext, "r");								
					 $dataCsv  = array();
					 
					 while (($data = fgetcsv($handle, 0, ";","'","\\")) !== FALSE) {
					   if($row > 1){

						   if ($data[21] != '')
						   {

							   $sqlcnt =" 
							   select count(*) cnt_fa
								   from simtax_rekon_fixed_asset
								   where rekon_fixed_asset_id = ".$data[21]."
							   ";
							   $qReq   	= $this->db->query($sqlcnt);
							   $vrows  	= $qReq->row();
							   $vcntasset  	= $vrows->CNT_FA;

							   $sqlhdr =" 
								select kode_cabang
									from simtax_kode_cabang
									where aktif = 'Y' 
									and nama_cabang = '".$data[8]."'
								";

								$qReq   		= $this->db->query($sqlhdr);
								$vrows  		= $qReq->row();
								$vkodecbg  	= $vrows->KODE_CABANG;
								if ($vkodecbg != ''){
									$vkodecbg = $vkodecbg;
								} else {
									$vkodecbg = 'NULL';
								}
							   
							   if ($vcntasset > 0) {
								   if($data[12] != ''){$data[12] = $data[12];} else {$data[12] = 'NULL';}
								   if($data[13] != ''){$data[13] = $data[13];} else {$data[13] = 'NULL';}
								   if($data[14] != ''){$data[14] = $data[14];} else {$data[14] = 'NULL';}
								   if($data[15] != ''){$data[15] = $data[15];} else {$data[15] = 'NULL';}
								   if($data[16] != ''){$data[16] = $data[16];} else {$data[16] = 'NULL';}
								   if($data[17] != ''){$data[17] = $data[17];} else {$data[17] = 'NULL';}
								   if($data[18] != ''){$data[18] = $data[18];} else {$data[18] = 'NULL';}
								   if($data[19] != ''){$data[19] = $data[19];} else {$data[19] = 'NULL';}
								   if($data[20] != ''){$data[20] = $data[20];} else {$data[20] = 'NULL';}
								   $sql = "update SIMTAX_REKON_FIXED_ASSET 
										   SET
											   JENIS_AKTIVA         		= '".trim($data[0],'"')."',
											   NAMA_AKTIVA       			= '".trim($data[1],'"')."',
											   KETERANGAN 					= '".trim($data[2],'"')."',
											   TANGGAL_BELI         		= '".trim($data[3],'"')."',
											   HARGA_PEROLEHAN      		= ".trim($data[4],'"').",
											   KELOMPOK_AKTIVA    			= '".trim($data[5],'"')."',
											   JENIS_HARTA       			= '".trim($data[6],'"')."',
											   JENIS_USAHA       			= '".trim($data[7],'"')."',
											   KODE_CABANG       			= '".trim($vkodecbg,'"')."',
											   KELOMPOK_FIXED_ASSET       	= '".trim($data[9],'"')."',
											   STATUS_PEMBEBANAN    		= '".trim($data[10],'"')."',
											   TANGGAL_JUAL         		= '".trim($data[11],'"')."',
											   HARGA_JUAL           		= ".trim($data[12],'"').",
											   PH_FISKAL            		= ".trim($data[13],'"').",
											   AKUMULASI_PENYUSUTAN_FISKAL  = ".trim($data[14],'"').",
											   NILAI_SISA_BUKU_FISKAL       = ".trim($data[15],'"').",
											   PENYUSUTAN_FISKAL            = ".trim($data[16],'"').",
											   PEMBEBANAN     				= ".trim($data[17],'"').",
											   AKUMULASI_PENYUSUTAN     	= ".trim($data[18],'"').",
											   NSBF     					= ".trim($data[19],'"').",
											   ASSET_NO     				= ".trim($data[20],'"')."
										   WHERE REKON_FIXED_ASSET_ID = ".$data[21];
										 
							   } else {

								if($data[12] != ''){$data[12] = $data[12];} else {$data[12] = 'NULL';}
								if($data[13] != ''){$data[13] = $data[13];} else {$data[13] = 'NULL';}
								if($data[14] != ''){$data[14] = $data[14];} else {$data[14] = 'NULL';}
								if($data[15] != ''){$data[15] = $data[15];} else {$data[15] = 'NULL';}
								if($data[16] != ''){$data[16] = $data[16];} else {$data[16] = 'NULL';}
								if($data[17] != ''){$data[17] = $data[17];} else {$data[17] = 'NULL';}
								if($data[18] != ''){$data[18] = $data[18];} else {$data[18] = 'NULL';}
								if($data[19] != ''){$data[19] = $data[19];} else {$data[19] = 'NULL';}
								if($data[20] != ''){$data[20] = $data[20];} else {$data[20] = 'NULL';}
								$sqlhdr =" 
								select pajak_header_id
									from simtax_pajak_headers
									where nama_pajak = 'FIXED ASSET' 
									and bulan_pajak = '".$data[23]."' and tahun_pajak = '".$data[24]."'
								";

								$qReq   		= $this->db->query($sqlhdr);
								$vrows  		= $qReq->row();
								$vpajakhdrid  	= $vrows->PAJAK_HEADER_ID;

								$sqlhdr =" 
								select kode_cabang
									from simtax_kode_cabang
									where aktif = 'Y' 
									and nama_cabang = '".$data[8]."'
								";

								$qReq   		= $this->db->query($sqlhdr);
								$vrows  		= $qReq->row();
								$vkodecbg  	= $vrows->KODE_CABANG;
								if ($vkodecbg != ''){
									$vkodecbg = $vkodecbg;
								} else {
									$vkodecbg = 'NULL';
								}
								
								$sql = "insert 
										   INTO SIMTAX_REKON_FIXED_ASSET 
										   (REKON_FIXED_ASSET_ID
										   ,JENIS_AKTIVA
										   ,NAMA_AKTIVA
										   ,KETERANGAN
										   ,TANGGAL_BELI
										   ,HARGA_PEROLEHAN
										   ,KELOMPOK_AKTIVA
										   ,JENIS_HARTA
										   ,JENIS_USAHA
										   ,KODE_CABANG
										   ,KELOMPOK_FIXED_ASSET
										   ,STATUS_PEMBEBANAN
										   ,TANGGAL_JUAL
										   ,HARGA_JUAL
										   ,PH_FISKAL
										   ,AKUMULASI_PENYUSUTAN_FISKAL
										   ,NILAI_SISA_BUKU_FISKAL
										   ,PENYUSUTAN_FISKAL
										   ,PEMBEBANAN
										   ,AKUMULASI_PENYUSUTAN
										   ,NSBF
										   ,ASSET_NO
										   ,BULAN_PAJAK
										   ,TAHUN_PAJAK
										   ,PAJAK_HEADER_ID
										   )
										   VALUES (
										   SIMTAX_REKON_FIXED_ASSET_SEQ.NEXTVAL
										   ,'".trim($data[0],'"')."'
										   ,'".trim($data[1],'"')."'
										   ,'".trim($data[2],'"')."'
										   ,'".trim($data[3],'"')."'
										   ,".trim($data[4],'"')."
										   ,'".trim($data[5],'"')."'
										   ,'".trim($data[6],'"')."'
										   ,'".trim($data[7],'"')."'
										   ,'".trim($vkodecbg,'"')."'
										   ,'".trim($data[9],'"')."'
										   ,'".trim($data[10],'"')."'
										   ,'".trim($data[11],'"')."'
										   ,".trim($data[12],'"')."
										   ,".trim($data[13],'"')."
										   ,".trim($data[14],'"')."
										   ,".trim($data[15],'"')."
										   ,".trim($data[16],'"')."
										   ,".trim($data[17],'"')."
										   ,".trim($data[18],'"')."
										   ,".trim($data[19],'"')."
										   ,".trim($data[20],'"')."
										   ,".trim($data[23],'"')."
										   ,".trim($data[24],'"')."
										   ,".$vpajakhdrid."
										   )
								   ";
							   }
						   } else {

								if($data[12] != ''){$data[12] = $data[12];} else {$data[12] = 'NULL';}
								if($data[13] != ''){$data[13] = $data[13];} else {$data[13] = 'NULL';}
								if($data[14] != ''){$data[14] = $data[14];} else {$data[14] = 'NULL';}
								if($data[15] != ''){$data[15] = $data[15];} else {$data[15] = 'NULL';}
								if($data[16] != ''){$data[16] = $data[16];} else {$data[16] = 'NULL';}
								if($data[17] != ''){$data[17] = $data[17];} else {$data[17] = 'NULL';}
								if($data[18] != ''){$data[18] = $data[18];} else {$data[18] = 'NULL';}
								if($data[19] != ''){$data[19] = $data[19];} else {$data[19] = 'NULL';}
								if($data[20] != ''){$data[20] = $data[20];} else {$data[20] = 'NULL';}
								$sqlhdr =" 
								select pajak_header_id
									from simtax_pajak_headers
									where nama_pajak = 'FIXED ASSET' 
									and bulan_pajak = '".$data[23]."' and tahun_pajak = '".$data[24]."'
								";

								$qReq   		= $this->db->query($sqlhdr);
								$vrows  		= $qReq->row();
								$vpajakhdrid  	= $vrows->PAJAK_HEADER_ID;

								$sqlhdr =" 
								select kode_cabang
									from simtax_kode_cabang
									where aktif = 'Y' 
									and nama_cabang = '".$data[8]."'
								";

								$qReq   		= $this->db->query($sqlhdr);
								$vrows  		= $qReq->row();
								$vkodecbg  	= $vrows->KODE_CABANG;
								if ($vkodecbg != ''){
									$vkodecbg = $vkodecbg;
								} else {
									$vkodecbg = 'NULL';
								}
								
								$sql = "insert 
										   INTO SIMTAX_REKON_FIXED_ASSET 
										   (REKON_FIXED_ASSET_ID
										   ,JENIS_AKTIVA
										   ,NAMA_AKTIVA
										   ,KETERANGAN
										   ,TANGGAL_BELI
										   ,HARGA_PEROLEHAN
										   ,KELOMPOK_AKTIVA
										   ,JENIS_HARTA
										   ,JENIS_USAHA
										   ,KODE_CABANG
										   ,KELOMPOK_FIXED_ASSET
										   ,STATUS_PEMBEBANAN
										   ,TANGGAL_JUAL
										   ,HARGA_JUAL
										   ,PH_FISKAL
										   ,AKUMULASI_PENYUSUTAN_FISKAL
										   ,NILAI_SISA_BUKU_FISKAL
										   ,PENYUSUTAN_FISKAL
										   ,PEMBEBANAN
										   ,AKUMULASI_PENYUSUTAN
										   ,NSBF
										   ,ASSET_NO
										   ,BULAN_PAJAK
										   ,TAHUN_PAJAK
										   ,PAJAK_HEADER_ID
										   )
										   VALUES (
										   SIMTAX_REKON_FIXED_ASSET_SEQ.NEXTVAL
										   ,'".trim($data[0],'"')."'
										   ,'".trim($data[1],'"')."'
										   ,'".trim($data[2],'"')."'
										   ,'".trim($data[3],'"')."'
										   ,".trim($data[4],'"')."
										   ,'".trim($data[5],'"')."'
										   ,'".trim($data[6],'"')."'
										   ,'".trim($data[7],'"')."'
										   ,'".trim($vkodecbg,'"')."'
										   ,'".trim($data[9],'"')."'
										   ,'".trim($data[10],'"')."'
										   ,'".trim($data[11],'"')."'
										   ,".trim($data[12],'"')."
										   ,".trim($data[13],'"')."
										   ,".trim($data[14],'"')."
										   ,".trim($data[15],'"')."
										   ,".trim($data[16],'"')."
										   ,".trim($data[17],'"')."
										   ,".trim($data[18],'"')."
										   ,".trim($data[19],'"')."
										   ,".trim($data[20],'"')."
										   ,".trim($data[23],'"')."
										   ,".trim($data[24],'"')."
										   ,".$vpajakhdrid."
										   )
								   ";
						   }	
							
						   
						   $query 	= $this->db->query($sql);	
						
						   if ($query) {
								$result['st'] = 1;
						   } else {
							   $result['st'] =0;
							   echo json_encode($result);
							   die();
						   }
					   }
	   
					   $row++;
				   }	
				 }
				 else{
						 $result['st'] = 6;
				 }
			 } else {
				 $result['st'] = 3;
			 }
		 } else {
			 $result['st']	= 2 ;
		 }		
		 
		 echo json_encode($result);
	}	

	// end import

	private function _upload($field_name, $folder_name, $file_name, $allowed_types, $ext){
		//file upload destination
		$upload_path = './uploads/';
		$config['upload_path'] = $upload_path.$folder_name;
		//allowed file types. * means all types
		$config['allowed_types'] = $allowed_types;
		//allowed max file size. 0 means unlimited file size
		$config['max_size'] = '0';
		//max file name size
		$config['max_filename'] = '355';
		//whether file name should be encrypted or not
		$config['encrypt_name'] = FALSE;
		$config['file_name'] = $file_name;
		//store image info once uploaded
		$image_data = array();
		//check for errors
		$is_file_error = FALSE;
		//check if file was selected for upload
		if (!$_FILES) {
			$is_file_error = TRUE;
		}
		//if file was selected then proceed to upload
		if (!$is_file_error) {
				if (file_exists(FCPATH.$upload_path.$folder_name."/".$file_name.".".$ext)){
					unlink($upload_path.$folder_name."/".$file_name.".".$ext);		
				} 			
				//load the preferences
				$this->load->library('upload', $config);
				//check file successfully uploaded. 'image_name' is the name of the input
				if (!$this->upload->do_upload($field_name)) {
					//if file upload failed then catch the errors
					$is_file_error = TRUE;
				} else {
					//store the file info
					$image_data = $this->upload->data();
					if($image_data){
						return true;
					}
					
				}
		}
		return false;
		}
		
}