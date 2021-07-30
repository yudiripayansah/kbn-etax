<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pph_badan extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
      redirect('dashboard', 'refresh');
    }

		$this->load->model('cabang_mdl');
		$this->load->model('Pph_mdl');
		$this->load->model('Pph_badan_mdl');
		$this->load->model('Beban_tantiem_mdl');
		$this->load->model('Golongan_pajak_kini_mdl');
	}

	function upd_view_bupot_lain() {
	  if($this->ion_auth->is_admin()){
      $permission = true;
    }
    else if(in_array("ppn_badan/upd_bupot_ph", $this->session->userdata['menu_url'])){
      $permission = true;
    }
    else {
      $permission = false;
    }

    if($permission === false) {
      redirect('dashboard');
    } else {
		$this->template->set('title', 'View Bukti Potong Pihak Lain');
		$data['subtitle']	= "View Bukti Potong Pihak Lain";
		$data['error'] = "";
		$this->template->load('template', 'pph_badan/upd_bupot_ph/index_view',$data);		
	}}
	
	function show_rincian_bl() {
		$this->template->set('title', 'PPh Badan');
		$data['subtitle']	= "Rincian Beban Lain";
		$data['error'] = "";
		$this->template->load('template', 'pph_badan/rincian_beban_lain',$data);		
	}	
	
	function show_kertas_kerja() {
		$this->template->set('title', 'PPh Badan');
		$data['subtitle']	= "Cetak Kertas Kerja";
		$data['error'] = "";
		$this->template->load('template', 'pph_badan/kertas_kerja',$data);		
	}	
	
	function show_kk_pajak_kini() {
		$this->template->set('title', 'PPh Badan');
		$data['subtitle']	= "Cetak Kertas Kerja Perhitungan Pajak Kini";
		$data['error'] = "";
		$this->template->load('template', 'pph_badan/kk_pajak_kini',$data);		
	}
	
	function upd_bupot_lain() {
		$this->template->set('title', 'Upload Bukti Potong Pihak Lain');
		$data['subtitle']	= "Upload Bukti Potong Pihak Lain";
		$data['error'] = "";
		$this->template->load('template', 'pph_badan/upd_bupot',$data);		
	}

	function load_bupot_lain() {		
    $hasil		= $this->Pph_badan_mdl->get_bupot_lain();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
        $ii++;
        $result['data'][] = array(
          'no'				=> $row['RNUM'],
          'bukti_potong_id'	=> $row['BUKTI_POTONG_ID'],
          'nama_pajak'		=> $row['NAMA_PAJAK'],
          'masa_pajak'		=> $row['MASA_PAJAK'],
          'tahun_pajak'		=> $row['TAHUN_PAJAK'],
          'no_bukti_potong'	=> $row['NO_BUKTI_POTONG'],
          'tgl_bukti_potong'	=> $row['TGL_BUKTI_POTONG'],
          'nama_wp'			=> $row['NAMA_WP'],
          'npwp'				=> $row['NPWP'],
          'alamat_wp'			=> $row['ALAMAT_WP'],
          'kode_pajak'		=> $row['KODE_PAJAK'],
          'dpp'				=> number_format($row['DPP']),
          'tarif'				=> $row['TARIF'],
          'jumlah_potong'		=> number_format($row['JUMLAH_POTONG']),
          'pembetulan_ke'		=> $row['PEMBETULAN_KE'],
          'nama_file'			=> $row['NAMA_FILE'],
          'cara_pembayaran'	=> $row['CARA_PEMBAYARAN'],
          'jenis_penghasilan'	=> $row['JENIS_PENGHASILAN'],
          'kode_map'			=> $row['KODE_MAP'],
          'ntpp'				=> $row['NTPP'],
          'jumlah_pembayaran'	=> $row['JUMLAH_PEMBAYARAN'],
          'error_message'		=> $row['ERROR_MESSAGE'],
          'tanggal_setor'		=> $row['TANGGAL_SETOR'],
          'nama_cabang'		=> $row['NAMA_CABANG']
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
	
	function load_bupot_lain_final() {
    $hasil		= $this->Pph_badan_mdl->get_bupot_lain_final();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
        $ii++;

        $result['data'][] = array(
          'no'				=> $row['RNUM'],
          'bukti_potong_id'	=> $row['BUKTI_POTONG_ID'],
          'nama_pajak'		=> $row['NAMA_PAJAK'],
          'masa_pajak'		=> $row['MASA_PAJAK'],
          'tahun_pajak'		=> $row['TAHUN_PAJAK'],
          'no_bukti_potong'	=> $row['NO_BUKTI_POTONG'],
          'tgl_bukti_potong'	=> $row['TGL_BUKTI_POTONG'],
          'nama_wp'			=> $row['NAMA_WP'],
          'npwp'				=> $row['NPWP'],
          'alamat_wp'			=> $row['ALAMAT_WP'],
          'kode_pajak'		=> $row['KODE_PAJAK'],
          'dpp'				=> number_format($row['DPP']),
          'tarif'				=> $row['TARIF'],
          'jumlah_potong'		=> number_format($row['JUMLAH_POTONG']),
          'pembetulan_ke'		=> $row['PEMBETULAN_KE'],
          'nama_file'			=> $row['NAMA_FILE'],
          'cara_pembayaran'	=> $row['CARA_PEMBAYARAN'],
          'jenis_penghasilan'	=> $row['JENIS_PENGHASILAN'],
          'kode_map'			=> $row['KODE_MAP'],
          'ntpp'				=> $row['NTPP'],
          'jumlah_pembayaran'	=> $row['JUMLAH_PEMBAYARAN'],
          'tanggal_setor'		=> $row['TANGGAL_SETOR'],
          'nama_cabang'		=> $row['NAMA_CABANG']
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
	
  function upload_csv() {
    //$data['addressbook'] = $this->Pph_badan_mdl->get_tbl_bupot_ph_lain();
    $data['error'] = '';    //initialize image upload error array to empty

    $config['upload_path'] = './uploads/pph_badan/csv';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = '100000';

    $this->load->library('upload', $config);

    // If upload failed, display error
    if (!$this->upload->do_upload()) {
      $data['error'] = $this->upload->display_errors();
      redirect(base_url().'Pph_badan/upd_bupot_lain',$data);
    } else {
      $file_data = $this->upload->data();
      $file_path =  './uploads/pph_badan/csv/'.$file_data['file_name'];
      if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
        @set_time_limit(300);
      }

      $row = 1;
      $handle = fopen($file_path, "r");
      
      $dataCsv  = array();
      while (($data = fgetcsv($handle, 1000, ";",'"')) !== FALSE) {

        if($row > 1){
          $dataCsv = array(
            'BUKTI_POTONG_ID'  	=> $row,
            'NAMA_PAJAK'    	=> $data[0],				//Jenis PPh yang dipotong	= NAMA_PAJAK
            'CARA_PEMBAYARAN'  	=> $data[1],				//Cara pembayaran	
            'NO_BUKTI_POTONG'   => $data[2],				//Nomor bukti potong/pungut	= NO_BUKTI_POTONG
            'JENIS_PENGHASILAN' => $data[3],				//Jenis penghasilan	 
            'DPP'  				=> $data[4],				//Objek pemotongan/ pemungutan = DPP	 
            'JUMLAH_POTONG'     => $data[5],				//PPh yang dipotong/ dipungut = JUMLAH_POTONG
            'TGL_BUKTI_POTONG'  => $data[6],				//Tgl bukti potong/pungut	= TGL_BUKTI_POTONG
            'NPWP'             	=> $data[7],				//NPWP pemotong/ pemungut	= NPWP
            'NAMA_WP'    		=> $data[8],				//Nama pemotong/ pemungut	= NAMA_WP
            'ALAMAT_WP'         => $data[9],				//Alamat pemotong/ pemungut = ALAMAT_WP	
            'KODE_MAP'          => $data[10],				//Kode MAP/ 
            'NTPP'         		=> $data[11],				//NTPP	
            'JUMLAH_PEMBAYARAN' => $data[12],				//Jumlah pembayaran	
            'TANGGAL_SETOR'     => $data[13],				//Tanggal setor
            'MASA_PAJAK'        => '',
            'KODE_PAJAK'        => '',
            'TAHUN_PAJAK'       => '',
            'TARIF' 			=> '',
            'PEMBETULAN_KE'     => '',
            'NAMA_FILE'			=> $file_data['file_name']
          );

          $this->Pph_badan_mdl->add($dataCsv);
        }

        $row++;
      }

      $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
      redirect(base_url().'Pph_badan/upd_bupot_lain');
    }
  } 
	
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
		
	function import_CSV() {
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
      @set_time_limit(0);
		}
		
		if (!empty($_FILES['file_csv']['name'])){
			$path 	= $_FILES['file_csv']['name'];
			$ext  	= pathinfo($path, PATHINFO_EXTENSION);
			$cabang	= $this->session->userdata('kd_cabang');
			$pajak 	= str_replace(" ","_",$this->input->post('uplPph'));
			$file_name = "fileCSV_".$pajak."_".$cabang;	
			error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			if ($ext=='csv'){
				if($upl = $this->_upload('file_csv', 'pph_badan/csv/', $file_name, 'csv', $ext)){					
					$row      = 1;
					$handle   = fopen("./uploads/pph_badan/csv/".$file_name.".".$ext, "r");								
					$dataCsv  = array();
					$delete	  = $this->Pph_badan_mdl->action_delete_stg();
					if ($delete){
						while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {																	
							if($row > 1){	
									$tgl	= explode("/",$data[6]);								
									//Cek data sdh ada/tidak
									/* if ($row==2){
										$cek	= $this->Pph_badan_mdl->cek_tahun($data[0],$tgl[2],"");
										if ($cek){
											$result['st'] = 4;
											$result['tahun'] = $tgl[2];
											echo json_encode($result);
											die();
										}
									} */
									$dataCsv = array(
										'BUKTI_POTONG_ID'  	=> $row,
										'NAMA_PAJAK'    	=> ($data[0])?$data[0]:"",				//Jenis PPh yang dipotong	= NAMA_PAJAK
										'CARA_PEMBAYARAN'  	=> ($data[1])?$data[1]:"",				//Cara pembayaran	
										'NO_BUKTI_POTONG'   => ($data[2])?$data[2]:"",				//Nomor bukti potong/pungut	= NO_BUKTI_POTONG
										'JENIS_PENGHASILAN' => ($data[3])?$data[3]:"",				//Jenis penghasilan	 
										'DPP'  				=> ($data[4])?$data[4]:"",				//Objek pemotongan/ pemungutan = DPP	 
										'JUMLAH_POTONG'     => ($data[5])?$data[5]:"",				//PPh yang dipotong/ dipungut = JUMLAH_POTONG
										'TGL_BUKTI_POTONG'  => ($data[6])?$data[6]:"",				//Tgl bukti potong/pungut	= TGL_BUKTI_POTONG
										'NPWP'             	=> ($data[7])?$data[7]:"",				//NPWP pemotong/ pemungut	= NPWP
										'NAMA_WP'    		=> ($data[8])?$data[8]:"",				//Nama pemotong/ pemungut	= NAMA_WP
										'ALAMAT_WP'         => ($data[9])?$data[9]:"",				//Alamat pemotong/ pemungut = ALAMAT_WP	
										'KODE_MAP'          => ($data[10])?$data[10]:"",				//Kode MAP/ 
										'NTPP'         		=> ($data[11])?$data[11]:"",				//NTPP	
										'JUMLAH_PEMBAYARAN' => ($data[12])?$data[12]:"",				//Jumlah pembayaran	
										'TANGGAL_SETOR'     => ($data[13])?$data[13]:"",				//Tanggal setor
										'MASA_PAJAK'        => ($tgl[1])?$tgl[1]:"",
										'KODE_PAJAK'        => '',
										'TAHUN_PAJAK'       => ($tgl[2])?$tgl[2]:"",
										'TARIF' 			=> '',
										'PEMBETULAN_KE'     => '',
										'NAMA_FILE'			=> $file_name,
										'KODE_CABANG'		=> $cabang
									);

								$hasil	= $this->Pph_badan_mdl->add($dataCsv);
								if ($hasil){
									$result['st'] =1;
								} else {
									$result['st'] = 0;
									echo json_encode($result);
									die();
								}								
							} 
							$row++;
						}
					}
					else{
						$result['st'] = 5;

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
	
	function save_bupot_ph_lain() {
		$data	= $this->Pph_badan_mdl->do_save_bupot_ph_lain();
		if($data){			
			echo '1';
		} else {			
			echo '0';
		}
	}
	
	function load_detail_summary() {
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph_badan/upd_bupot_lain", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;

		if($permission === true) {			
			$hasil    = $this->Pph_badan_mdl->get_detail_summary();
			$rowCount = $hasil['jmlRow'] ;
			$query    = $hasil['query'];
			$totselisih	= 0;
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	{
          $ii++;							
          $result['data'][] = array(									
            'no'				        => $row['RNUM'],
            'nama_pajak'	        	=> $row['NAMA_PAJAK'],
            'jumlah'					=> number_format($row['JUMLAH'],2,'.',',')									
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
		}
		
		echo json_encode($result);
		$query->free_result();
  }
	 
	function load_total_detail_summary() {

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph_badan/upd_bupot_lain", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
				
		if($permission === true) {
			$hasil    = $this->Pph_badan_mdl->get_total_detail_summary();			
			foreach($hasil->result_array() as $row)	{						
					$result['total'] = $row['TOTAL'];
				}
		}
		echo json_encode($result);
		$hasil->free_result();
    }
	
	function cek_data_csv() {
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
    $bulan   	= $_REQUEST['month'];
    $tahun   	= $_REQUEST['year'];
    $cabang   	= $_REQUEST['cab'];
		$cek	= $this->Pph_badan_mdl->cek_tahun($pajak,$bulan,$tahun,$cabang,"FINAL");
		if ($cek){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function export_format_csv() {
    $this->load->helper('csv_helper');
		$pajak   	= ($_REQUEST['tax'])? $_REQUEST['tax']:"";
		$bulan   	= ($_REQUEST['month'])? $_REQUEST['month']:"";
    $tahun   	= ($_REQUEST['year'])? $_REQUEST['year']:"";
    $cab	   	= ($_REQUEST['cab'])? $_REQUEST['cab']:"";
		$nmcabang	= "";
		if($cab){
			$nmcabang = $this->cabang_mdl->get_by_id($cab)->NAMA_CABANG;
		}
		
    $export_arr = array();
    $data       = $this->Pph_badan_mdl->get_format_csv();
		$title 		= array("Jenis PPh yang dipotong", "Cara pembayaran", "Nomor bukti potong/pungut","Jenis penghasilan",
		"Objek pemotongan/ pemungutan", "PPh yang dipotong/ dipungut","Tgl bukti potong/pungut","NPWP pemotong/ pemungut",
		"Nama pemotong/ pemungut","Alamat pemotong/ pemungut","Kode MAP/ iuran pembayaran","NTPP","Jumlah pembayaran","Tanggal setor");
        array_push($export_arr, $title);		
		if (!empty($data)) {         
			foreach($data->result_array() as $row)	{							
				array_push($export_arr, array($row['NAMA_PAJAK'], $row['CARA_PEMBAYARAN'], $row['NO_BUKTI_POTONG'], $row['JENIS_PENGHASILAN'], $row['DPP'], $row['JUMLAH_POTONG'], $row['TGL_BUKTI_POTONG'], $row['NPWP'], 
				$row['NAMA_WP'], $row['ALAMAT_WP'], $row['KODE_MAP'], $row['NTPP'], $row['JUMLAH_PEMBAYARAN'], $row['TANGGAL_SETOR']));
			}
        }
     // convert_to_csv($export_arr,'PPh Badan '.$pajak.' '.$tahun.'.csv', ';');
      convert_to_csv_PPH21($export_arr,'PPh Badan '.$pajak.' '.$bulan.' '.$tahun.' '.$nmcabang.'.csv', ';');
    }
	
	function cetak_excel() {
		set_time_limit(0);
		$pajak   	= ($_REQUEST['tax'])? $_REQUEST['tax']:"";
		$bulan   	= ($_REQUEST['month'])? $_REQUEST['month']:"";		
    $tahun   	= ($_REQUEST['year'])? $_REQUEST['year']:"";
    $cab	   	= ($_REQUEST['cab'])? $_REQUEST['cab']:"";
		$nmbulan	= "";
		$nmcabang	= "";
		$nmpajak	= "";
		if($bulan){
			$nmbulan  = $this->Pph_mdl->getMonth($_REQUEST['month']);
		}
		if($cab){
			$nmcabang = $this->cabang_mdl->get_by_id($cab)->NAMA_CABANG;
		}
		
		if($pajak){
			$nmpajak = "PPh PASAL ".$pajak;
		} 		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Cetak Kertas Kerja")
								->setSubject("Cetakan")
								->setDescription("Cetak KK Setahun")
								->setKeywords("KK");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$center_bold_border = array(
		        'font' => array('bold' => true,
								'size' => 14), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$center_nobold_noborder = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);	
		
		$center_no_bold_border_kika = array(
		        'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);			
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$rata_kanan = array(
		     'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  )
		);	
		
		$border_bawah_kanan_kiri = array(
		    'borders' => array(
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($border_kika_nobold_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "REKAP PAJAK DIBAYAR DIMUKA ".$nmpajak." ".$nmbulan." ".$tahun." ".strtoupper($nmcabang)); 
		$excel->getActiveSheet()->mergeCells('B2:P4');	
		$excel->getActiveSheet()->getStyle('B2:P4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "No");
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "Jenis PPh yang dipotong");
		$excel->getActiveSheet()->getStyle('C5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('D5', "Cara pembayaran"); 
		$excel->getActiveSheet()->getStyle('D5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('E5', "Nomor bukti potong/pungut");
		$excel->getActiveSheet()->getStyle('E5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F5', "Jenis penghasilan");
		$excel->getActiveSheet()->getStyle('F5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Objek pemotongan/ pemungutan");
		$excel->getActiveSheet()->getStyle('G5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H5', "PPh yang dipotong/ dipungut");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I5', "Tgl bukti potong/pungut");		
		$excel->getActiveSheet()->getStyle('I5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('J5', "NPWP pemotong/ pemungut");		
		$excel->getActiveSheet()->getStyle('J5')->applyFromArray($center_no_bold_border);	
		
		$excel->setActiveSheetIndex(0)->setCellValue('K5', "Nama pemotong/ pemungut");		
		$excel->getActiveSheet()->getStyle('K5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('L5', "Alamat pemotong/ pemungut");		
		$excel->getActiveSheet()->getStyle('L5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('M5', "Kode MAP/ iuran pembayaran");		
		$excel->getActiveSheet()->getStyle('M5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('N5', "NTPP");		
		$excel->getActiveSheet()->getStyle('N5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('O5', "Jumlah pembayaran");		
		$excel->getActiveSheet()->getStyle('O5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('P5', "Tanggal setor");		
		$excel->getActiveSheet()->getStyle('P5')->applyFromArray($center_no_bold_border);		
		
		
		
		// end header

		//get detail 7	
			$no 	= 1;
			$numrow = 6; 			
			$data       = $this->Pph_badan_mdl->get_format_csv();			
			foreach($data->result_array() as $row)	{				
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $no);	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['NAMA_PAJAK']);	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['CARA_PEMBAYARAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['NO_BUKTI_POTONG']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['JENIS_PENGHASILAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['DPP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUMLAH_POTONG']);	
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['TGL_BUKTI_POTONG']);	
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row['NPWP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row['NAMA_WP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row['ALAMAT_WP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row['KODE_MAP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row['NTPP']);	
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $row['JUMLAH_PEMBAYARAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $row['TANGGAL_SETOR']);	
									
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_no_bold_border_kika);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);		
									
				
				$excel->getActiveSheet()->getStyle('G'.$numrow.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');	
				
				$no++;
				$numrow++; 			
			}
			$numrowBawah = $numrow -1;
			$excel->getActiveSheet()->getStyle('B'.$numrowBawah.':P'.$numrowBawah)->applyFromArray($border_bawah_kanan_kiri);
				
				
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(4); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(35); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(45); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(25); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom A
	
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("CETAK KK");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="PPh Badan '.$pajak." ".$nmbulan.' '.$tahun.' '.$nmcabang.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	
	function adj_laba_rugi()
	{
		$this->template->set('title', 'Adjust Laba / Rugi');
		$data['subtitle']	= "REKAPITULASI RINCIAN BEBAN LAIN GABUNGAN";
		$data['nama_cabang'] = $this->cabang_mdl->get_by_id($this->session->userdata('kd_cabang'));
		$this->template->load('template', 'pph_badan/adj_laba_rugi/index',$data);
	}
	
	function koreksi_fiskal()
	{
		$this->template->set('title', 'PPh BADAN');
		$data['subtitle']	= "BUKU BANTU KOREKSI FISKAL";
		$data['nama_cabang'] = $this->cabang_mdl->get_by_id($this->session->userdata('kd_cabang'));
		$this->template->load('template', 'pph_badan/koreksi_fiskal',$data);
	}	

	function load_laba_rugi()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_laba_rugi();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'kode_akun'		=> $row['KODE_AKUN'],
								'kode_jasa'		=> $row['KODE_JASA'],
								'description'	=> $row['DESCRIPTION'],
								'balance'		=> $row['BALANCE'],
								'positif'		=> $row['POSITIF'],
								'negatif'		=> $row['NEGATIF'],
								'keterangan'	=> $row['KETERANGAN'],
								'tahun_pajak'	=> $row['TAHUN_PAJAK'],
								'uraian'		=> $row['URAIAN'],
								'spt'		=> $row['SPT']
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

	function load_beban_lain()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_beban_lain();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'kode_akun'			=> $row['KODE_AKUN'],
								'akun_desc'			=> $row['AKUN_DESCRIPTION'],
								'jml_uraian'		=> number_format($row['JML_URAIAN']),
								'deductible'		=> number_format($row['DEDUCTIBLE']),
								'nondeductible'		=> number_format($row['NON_DEDUCTIBLE'])
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
	
	function load_fiskal()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_fiskal();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'kode_akun'			=> $row['KODE_AKUN'],
								'kode_jasa'			=> $row['KODE_JASA'],
								'akun_desc'			=> $row['AKUN_DESCRIPTION'],
								'kode_jasa_desc'	=> $row['KODE_JASA_DESCRIPTION'],
								'amount'			=> $row['AMOUNT'],
								'nilai_fiskal'		=> $row['NILAI_FISKAL'],
								'nilai_komersial'	=> $row['NILAI_KOMERSIAL'],
								'amount_positif'	=> $row['AMOUNT_POSITIF'],
								'amount_negatif'	=> $row['AMOUNT_NEGATIF'],
								'keterangan'		=> $row['KETERANGAN'],
								'tahun_pajak'		=> $row['TAHUN_PAJAK'],
								'bulan_pajak'		=> $row['BULAN_PAJAK'],
								'disp_bulan'		=> $row['DISP_BULAN'],
								'checklist'			=> $row['CHECKLIST'],
								'koreksi_fiskal_id'	=> $row['KOREKSI_FISKAL_ID']
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

	function load_fiskal_pend()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_fiskal_pend();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];

		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'kode_akun'			=> $row['KODE_AKUN'],
								'kode_jasa'			=> $row['KODE_JASA'],
								'akun_desc'			=> $row['AKUN_DESCRIPTION'],
								'kode_jasa_desc'	=> $row['KODE_JASA_DESCRIPTION'],
								'amount'			=> $row['AMOUNT'],
								'nilai_fiskal'			=> $row['NILAI_FISKAL'],
								'nilai_komersial'			=> $row['NILAI_KOMERSIAL'],
								'amount_positif'	=> $row['AMOUNT_POSITIF'],
								'amount_negatif'	=> $row['AMOUNT_NEGATIF'],
								'keterangan'		=> $row['KETERANGAN'],
								'tahun_pajak'		=> $row['TAHUN_PAJAK'],
								'bulan_pajak'		=> $row['BULAN_PAJAK'],
								'disp_bulan'		=> $row['DISP_BULAN'],
								'checklist'			=> $row['CHECKLIST'],
								'koreksi_fiskal_id'	=> $row['KOREKSI_FISKAL_ID']
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
	
	function load_total_rincian_bl()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_ttl_rincian_bl();
		$sumDebit	= $hasil['sumDebit'] ;
		$sumCredit 	= $hasil['sumCredit'];	
		
		$result['sumDebit']  = $sumDebit;
		$result['sumCredit'] = $sumCredit;
		$result['isSuccess'] = 1;
		
		echo json_encode($result);
	}
	
	function load_rincian_bl()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_rincian_bl();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];

		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$checked	= ($row['CHECKLIST']==1)?"checked":"";
					$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
									<input id='checkbox".$row['RNUM']."' class='checklist' type='checkbox' ".$checked." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['BEBAN_LAIN_ID']."'>
									<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
								</div>";					

					$result['data'][] = array(
								'no'				=> $row['RNUM'],								
								'debit'				=> number_format($row['DEBIT']),
								'kode_akun'			=> $row['KODE_AKUN'],
								'akun_desc'			=> $row['AKUN_DESCRIPTION'],
								'checklist'			=> $checkbox, 
								'desc_beban'		=> $row['URAIAN']								
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
	
	function check_rincian_bl()
	{
		$data	= $this->Pph_badan_mdl->set_rincian_bl();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}	
	
	function adj_biaya_lain()
	{
		$this->template->set('title', 'Adjust Biaya Lain');
		$data['subtitle']	= "Adjust Biaya Lain";
		$this->template->load('template', 'pph_badan/adj_biaya_lain/index',$data);
	}	

	function adj_sisa_obligasi()
	{
		$this->template->set('title', 'Adjust Sisa Obligasi');
		$data['subtitle']	= "Adjust Sisa Obligasi";
		$this->template->load('template', 'pph_badan/adj_sisa_obligasi/index',$data);
	}

	function approval_supervisor()
	{
		$this->template->set('title', 'Approval Supervisor');
		$data['subtitle']	= "Approval Supervisor";
		$this->template->load('template', 'pph_badan/approval_supervisor/index',$data);
	}

	function archive_link()
	{
		/*$this->template->set('title', 'Archive Link');
		$data['subtitle']	= "Arsip Pelaporan Pajak";
		$data['nama_cabang'] = $this->cabang_mdl->get_by_id($this->session->userdata('kd_cabang'));
		
		$this->template->load('template', 'administrator/archive_link',$data);*/

		$this->template->set('title', 'Archive Link');
		$data['subtitle']   = "Arsip Pelaporan Pajak";
		
		$data['stand_alone'] = true;
		$group_pajak         = get_daftar_pajak("PPHBADAN"); // PPH, PPH21, PPNMASA, PPNWAPU
		
		$list_pajak          = array();
	
		foreach ($group_pajak as $key => $value) {
			$list_pajak[] = $value->JENIS_PAJAK;
		}

		$data['nama_pajak']  = $list_pajak;
		
		$this->template->load('template', 'administrator/archive_link',$data);
	}

	function archive_link2()
	{
		/*$this->template->set('title', 'Archive Link');
		$data['subtitle']	= "Arsip Pelaporan Pajak";
		$data['nama_cabang'] = $this->cabang_mdl->get_by_id($this->session->userdata('kd_cabang'));
		
		$this->template->load('template', 'administrator/archive_link',$data);*/

		$this->template->set('title', 'Archive Link');
		$data['subtitle']   = "Arsip Pelaporan Pajak";
		
		//$data['stand_alone'] = true;
		$group_pajak         = get_daftar_pajak(); // PPH, PPH21, PPNMASA, PPNWAPU
		
		$list_pajak          = array();
	
		foreach ($group_pajak as $key => $value) {
			$list_pajak[] = $value->JENIS_PAJAK;
		}

		$data['nama_pajak']  = $list_pajak;
		
		$this->template->load('template', 'administrator/archive_link',$data);
	}

	function load_url_doc()
	{
		
      	$hasil		= $this->Pph_badan_mdl->get_url_doc();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					$st ="<a href='".$row['URL_DOC']."' class='link_datatables' target='_blank'>".$row['NAMA_DOC']."</a>";

					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'nama_pajak'	=> $row['NAMA_PAJAK'],
								'masa_pajak'	=> $row['MASA_PAJAK'],
								'tahun_pajak'	=> $row['TAHUN_PAJAK'],
								'kode_cabang'	=> $row['KODE_CABANG'],
								'nama_doc'		=> $row['NAMA_DOC'],
								'url_doc_id'	=> $row['URL_DOC_ID'],
								'url_doc_ori'	=> $row['URL_DOC'],
								'bulan_pajak'	=> $row['BULAN_PAJAK'],
								'pembetulan_ke'	=> $row['PEMBETULAN_KE'],
								'url_doc'		=> $st
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

    function save_url_doc()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('inpnamapajak', 'Nama Pajak', 'required');
			$this->form_validation->set_rules('inpFile', 'Nama File', 'required');
			$this->form_validation->set_rules('inpURL', 'URL File', 'required');
			
			if ($this->form_validation->run() === TRUE)
			{
					$data	= $this->Pph_badan_mdl->do_save_url_doc();
					if($data){			
						echo '1';
					} else {			
						echo '0';
					}
			}
			else
			{
				echo validation_errors();
			}		
		}	
	}	
	
    function save_beban_lain()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('inpAccount', 'Account', 'required');
			$this->form_validation->set_rules('inpAmount', 'Amount', 'required');
			//$this->form_validation->set_rules('inpURL', 'URL File', 'required');
			
			if ($this->form_validation->run() === TRUE)
			{
					$data	= $this->Pph_badan_mdl->do_save_beban_lain();
					if($data){			
						echo '1';
					} else {			
						echo '0';
					}
			}
			else
			{
				echo validation_errors();
			}		
		}	
	}	

    function save_fiskal()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('inpAccount', 'Account', 'required');
			$this->form_validation->set_rules('inpBulan', 'Tahun', 'required');
			$this->form_validation->set_rules('inpTahun', 'Bulan', 'required');
			
			if ($this->form_validation->run() === TRUE)
			{
					$data	= $this->Pph_badan_mdl->do_save_fiskal();
					if($data){			
						echo '1';
					} else {			
						echo '0';
					}
			}
			else
			{
				echo validation_errors();
			}		
		}	
	}	

    function save_debit_credit()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('inpDebit', 'DEBIT', 'required');
			$this->form_validation->set_rules('inpCredit', 'CREDIT', 'required');
			//$this->form_validation->set_rules('inpURL', 'URL File', 'required');
			
			if ($this->form_validation->run() === TRUE)
			{
					$data	= $this->Pph_badan_mdl->do_save_debit_credit();
					if($data){			
						echo '1';
					} else {			
						echo '0';
					}
			}
			else
			{
				echo validation_errors();
			}		
		}	
	}	
	
	
	function delete_url_doc()
	{
		$data	= $this->Pph_badan_mdl->do_delete_url_doc();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}	

	function delete_beban_lain()
	{
		$data	= $this->Pph_badan_mdl->do_delete_beban_lain();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}	

	function delete_fiskal()
	{
		$data	= $this->Pph_badan_mdl->do_delete_fiskal();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}	
	
    function load_lov_nama_pajak()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_nama_pajak();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;

					if($row['NAMA_PAJAK'] == "PPN MASUKAN"){
						$namepajake = "SSP PPN Masa";
					}
					elseif($row['NAMA_PAJAK'] == "PPN KELUARAN"){
						$namepajake = "SPT PPN Masa";
					}
					else{
						$namepajake = $row['NAMA_PAJAK'];
					}

					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'nama_pajak'		=> $namepajake
								);
			}

			$last_no = $row['RNUM']+1;

			$new_pajak0 = array('no' => $last_no++, 'nama_pajak' => "PPH BADAN");
			$new_pajak1 = array('no' => $last_no++, 'nama_pajak' => "BPE PPN");
			$new_pajak2 = array('no' => $last_no++, 'nama_pajak' => "CSV Kompilasi PPN Lapor");
			$new_pajak3 = array('no' => $last_no++, 'nama_pajak' => "Lampiran Lain");

			array_push($result['data'], $new_pajak0);
			array_push($result['data'], $new_pajak1);
			array_push($result['data'], $new_pajak2);
			array_push($result['data'], $new_pajak3);
			
			$query->free_result();
			
			$result['draw']                = $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
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

    function load_lov_account()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_account();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION']								
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

    function load_lov_acc_delapan()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_acc_delapan();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION']								
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
	
	function load_lov_acc_delapan2()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_acc_delapan2();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION'],
								'komersial'		=> $row['KOMERSIAL'],
								'periodnum'		=> $row['PERIOD_NUM'],
								'periodyear'	=> $row['PERIOD_YEAR']								
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

    function load_lov_kode_jasa()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_kode_jasa();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION']								
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
	
    function load_lov_account_beban()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_account_beban();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION']								
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

    function load_lov_acc_beban_tujdel()
	{
      	$hasil	= $this->Pph_badan_mdl->get_lov_account_beban_tujdel();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'akun'			=> $row['FLEX_VALUE'],
								'akun_desc'		=> $row['DESCRIPTION']								
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
	
	function show_closing()
	{
		$this->template->set('title', 'PPh Badan');
		$data['subtitle']	= "Closing";
		$this->template->load('template', 'pph_badan/closing',$data);
	}	

	function load_closing()
	{
		$hasil		= $this->Pph_badan_mdl->get_closing();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					if (strtoupper($row['STATUS'])=="OPEN") {
						$st ="<span class='label label-success'>".$row['STATUS']."</span>";
					} else {
						$st ="<span class='label label-danger'>".$row['STATUS']."</span>";
					}
					if(substr($row['BULAN'],0,1)=='0'){
						$bln = substr($row['BULAN'],-1);
					} else {
						$bln = $row['BULAN'];
					}
					
					$nmbln	= get_masa_pajak($bln);
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'nama_pajak'	=> $row['PAJAK'],
								'nama_bulan'	=> strtoupper($nmbln),								
								'tahun_pajak'	=> $row['TAHUN'],
								'params'		=> $row['STATUS'],
								'status' 		=> $st,
								'bulan' 		=> $row['BULAN']
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

	function save_period()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->Pph_badan_mdl->action_save_period();
			if($data){			
				echo $data;
			} else {			
				echo '0';
			}
		} else {
			echo '0';
		}
	}	

	function save_closing()
	{
		
		$data	= $this->Pph_badan_mdl->action_save_closing();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
		
	}
	
	function pembetulan()
	{
		$this->template->set('title', 'Pembetulan PPh Badan');
		$data['subtitle']	= "Pembetulan PPh Badan";
		$this->template->load('template', 'pph_badan/pembetulan/index',$data);
	}	

	function summary()
	{
		$this->template->set('title', 'Summary PPh Badan');
		$data['subtitle']	= "Summary PPh Badan";
		$this->template->load('template', 'pph_badan/summary/index',$data);
	}
	
	function cetak_kertas_kerja()
	{
		set_time_limit(0);
		$tahun 		= $_REQUEST['tahun'];
		$bulan 		= $_REQUEST['bulan'];
		$date	    = date("Y-m-d H:i:s");
		$jdlbln		= "";
		
		if ($bulan){
			$jdlbln ="BULAN ".$this->Pph_mdl->getMonth($bulan);
		}
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Cetak Kertas Kerja")
								->setSubject("Cetakan")
								->setDescription("Cetak KK Setahun")
								->setKeywords("KK");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$center_bold_border = array(
		        'font' => array('bold' => true,
								'size' => 14), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$center_nobold_noborder = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);	
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);			
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$rata_kanan = array(
		     'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  )
		);	
		
		$border_bawah_kanan_kiri = array(
		    'borders' => array(
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "KERTAS KERJA PERHITUNGAN PAJAK PENGHASILAN BADAN ".$jdlbln." TAHUN ".$tahun); 
		$excel->getActiveSheet()->mergeCells('B1:I4');	
		$excel->getActiveSheet()->getStyle('B1:I4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "NO.");
		$excel->getActiveSheet()->mergeCells('B5:B7');	
		$excel->getActiveSheet()->getStyle('B5:B7')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "U R A I A N");
		$excel->getActiveSheet()->mergeCells('C5:D7');	
		$excel->getActiveSheet()->getStyle('C5:D7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('E6', "LABA RUGI AUDITED"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E7', "INDUK");
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($center_nobold_noborder);
		$excel->getActiveSheet()->getStyle('E7')->applyFromArray($center_nobold_noborder);

		$excel->setActiveSheetIndex(0)->setCellValue('F5', "KOREKSI");
		$excel->setActiveSheetIndex(0)->setCellValue('F7', "POSITIF");
		$excel->setActiveSheetIndex(0)->setCellValue('G7', "NEGATIF");
		$excel->getActiveSheet()->mergeCells('F5:G6');
		$excel->getActiveSheet()->getStyle('F5:G6')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('F7')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('G7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H5', "SPT PPh TAHUN ".$tahun);
		$excel->getActiveSheet()->mergeCells('H5:H7');	
		$excel->getActiveSheet()->getStyle('H5:H7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I5', "KETERANGAN");
		$excel->getActiveSheet()->mergeCells('I5:I7');	
		$excel->getActiveSheet()->getStyle('I5:I7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('B8', "1");
		$excel->setActiveSheetIndex(0)->setCellValue('C8', "2");
		$excel->getActiveSheet()->mergeCells('C8:D8');
		$excel->setActiveSheetIndex(0)->setCellValue('E8', "3");
		$excel->setActiveSheetIndex(0)->setCellValue('F8', "4");
		$excel->setActiveSheetIndex(0)->setCellValue('G8', "5");
		$excel->setActiveSheetIndex(0)->setCellValue('H8', "6");
		$excel->setActiveSheetIndex(0)->setCellValue('I8', "7");
		$excel->getActiveSheet()->getStyle('B8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('C8:D8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('E8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('F8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('G8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('H8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('I8')->applyFromArray($center_no_bold_border);
		
		// end header

		//get detail 7				
						
			$query		= $this->Pph_badan_mdl->get_rekening7($bulan,$tahun);
			//$no = 1; // Untuk penomoran tabel, di awal set dengan 1
			$numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 4
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
						
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						//kembalikan summary ke 0
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {					
						$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_JASA']." ".$row['JASA_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
			
				$numrow++; // Tambah 1 setiap kali looping					
			}		

		//end get detail 7
		
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$numrow++;
		
		//get detail 8			
			$sum_uraian     = 0;
			$sum_posistif   = 0;			
			$sum_negatif    = 0;
			$sum_spt        = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name    = "";
			$isRowPertama   = "Y";
			
			$nilKomersilU	= 0;			
			$nilKomersilP	= 0;			
			$nilKomersilN	= 0;			
			$nilKomersilS	= 0;
			
			$amortisasiKomersilU	= 0;			
			$amortisasiKomersilP	= 0;			
			$amortisasiKomersilN	= 0;			
			$amortisasiKomersilS	= 0;	
			
			$query		= $this->Pph_badan_mdl->get_rekening8($bulan,$tahun);
			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama=="Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}
						
						//Penyisihan Piutang
						if (substr($prev_kode_akun,0,5)==80104){ //krna jumlah di bwah rek 80104
							$nilKomersilU = $sum_uraian;
							$nilKomersilP = $sum_posistif;
							$nilKomersilN = $sum_negatif;
							$nilKomersilS = $sum_spt;
						}
						
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);						
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}				
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {						
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 
					
				if(substr($row['KODE_AKUN'],0,6)=='801046' || substr($row['KODE_AKUN'],0,6)=='801048'){
					$amortisasiKomersilU	+= $row['JML_URAIAN'];			
					$amortisasiKomersilP	+= $row['AMOUNT_POSITIF'];		
					$amortisasiKomersilN	+= $row['AMOUNT_NEGATIF'];			
					$amortisasiKomersilS	+= $row['SPT'];
				}
			}		

		//end get detail 8

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
			$numrow++;
		
						
		//get detail 791 pendapatan usaha lain				
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			
			$query		= $this->Pph_badan_mdl->get_rekening791($bulan,$tahun);
			foreach($query->result_array() as $row)	{				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {					
					if ($numrow > 9) {						
						if ($isRowPertama == "Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
										
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);//sini
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++;				
			}		


		$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
					
		$numrow++;
		//end get detail 791	
		
		//get detail 891 beban usaha lain			
			
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			$query		= $this->Pph_badan_mdl->get_rekening891($bulan,$tahun);	
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama == "Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}

						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						//kembalikan summary ke 0
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);	
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
											
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);	
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; // Tambah 1 setiap kali looping					
			}		

		$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
					
		$numrow++;
		//end get detail 891		

		//start hardcode
		$nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  )
		);	

		$center_bold_border_kika = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);		
		
		for ($x = 0; $x <= 51; $x++) {

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_bold_border_kika);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
		
			//asset
			if ($x==1) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KOREKSI POSITIF BEBAN FINAL");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}				
			if ($x==2) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1. Aset/bangunan disewa IKT");
			if ($x==3) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2. Aset/bangunan disewa JICT");
			if ($x==4) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3. Aset KSO Koja");
			if ($x==5) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "4. Aset  Cab Tanjung Priok");
			if ($x==6) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "5. Aset Cab Pontianak");
			if ($x==7) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "6. Aset Cabang Jambi");
			if ($x==8) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "7. Beban Bersama");
			if ($x==10) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "JUMLAH KOREKSI POSITIF BEBAN FINAL");

			//Beda Waktu
			if ($x==12) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "BEDA WAKTU");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);	
			}				
			if ($x==14) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan piutang dan PYMAD");				
			}
			if ($x==15){
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Versi komersil");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $nilKomersilU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $nilKomersilP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $nilKomersilN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $nilKomersilS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);			
			}
			if ($x==16) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Versi fiskal");
			
			if ($x==18) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyusutan aktiva tetap");							
			}
			if ($x==19) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Penyusutan komersil");
			if ($x==20) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Penyusutan fiskal");	
			if ($x==21) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Koreksi KAP");	

			if ($x==23) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Amortisasi  aktiva tidak berwujud");
			}
			if ($x==24) {
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Amortisasi komersil");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $amortisasiKomersilU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $amortisasiKomersilP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $amortisasiKomersilN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $amortisasiKomersilS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
			}			
			if ($x==25) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Amortisasi fiskal");	
			
			if ($x==27) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "4");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan  Imbalan Kerja");
			}	
			
			if ($x==28) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Beban");	
			if ($x==29) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Realisasi");	

			if ($x==31) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "5");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan  Imbalan Kesehatan");
			}
			if ($x==32) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Beban");	
			if ($x==33) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Realisasi");				
			if ($x==34) {
				$tot_beda_waktuU =  $nilKomersilU + $amortisasiKomersilU ;
				$tot_beda_waktuP =  $nilKomersilP + $amortisasiKomersilP ;
				$tot_beda_waktuN =  $nilKomersilN + $amortisasiKomersilN ;
				$tot_beda_waktuS =  $nilKomersilS + $amortisasiKomersilS ;
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH KOREKSI NEGATIF BEDA WAKTU");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tot_beda_waktuU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $tot_beda_waktuP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $tot_beda_waktuN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $tot_beda_waktuS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
				
					
			}					

			//laba kena pajak
			if ($x==36) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "VIII.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "LABA KENA PAJAK DESEMBER ".$tahun);	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			
			//pph terutang
			if ($x==38) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "IX.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "PPH TERUTANG ".$tahun);	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			if ($x==39) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Beban Pajak Kini");	
			if ($x==40) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Tarif  25%");	
			if ($x==41) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH PPH TERUTANG");			

			//KREDIT PAJAK
			if ($x==43) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "X.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KREDIT PAJAK");	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			if ($x==44) { 
				/* $where = " and nama_pajak='22' and tahun_pajak=".$tahun;
				if ($bulan) {
					$where .= " and masa_pajak='".$bulan."' ";
				} */
				/* $sql_22 = " select nama_pajak, nvl(sum(jumlah_potong),0) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";
						$q22    	= $this->db->query($sql_22); */
						
						$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'22');	
						$qrow22  	= $q22->row(); 	
						$jml_data22	= $q22->num_rows();
						
						if($jml_data22>0){
							$jum22  	= $qrow22->JUMLAH;
						} else {
							$jum22 		= 0;
						}
				
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 22");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $jum22);	
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);			
			}
			if ($x==45) {
				/* $where = " and nama_pajak='23' and tahun_pajak=".$tahun;
				if ($bulan) {
					$where .= " and masa_pajak='".$bulan."' ";
				}
				$sql_22 = " select nama_pajak, nvl(sum(jumlah_potong),0) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";					
						$q22    	= $this->db->query($sql_22); */
						
						$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'23');	
						$qrow22  	= $q22->row(); 	
						$jml_data22	= $q22->num_rows();
						
						if($jml_data22>0){
							$jum23  	= $qrow22->JUMLAH;
						} else {
							$jum23 		= 0;
						}
						
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 23");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $jum23);	
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			}
			if ($x==46) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 25");	
			}
			if ($x==48) {
				$tot_kredit_pajak = $jum22 + $jum23;
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH KREDIT PAJAK");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tot_kredit_pajak);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '');	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '');	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
				
			}
			if ($x==49) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "XI.");
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KURANG (LEBIH) BAYAR PAJAK PENGHASILAN");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
						
			$numrow++;
		} 		
		
		//end hardcode
		
		$numrowStart = 10;
		$excel->getActiveSheet()->getStyle('E'.$numrowStart.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		// $excel->getActiveSheet()->getStyle('H'.$numrowStart.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('E'.$numrowStart.':H'.$numrow)->applyFromArray($rata_kanan);
		
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('C'.$numrow.':D'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		
		//total
		/*
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH DISETOR");

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		*/		
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(2); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(40); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom A
	
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("CETAK KK");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="KERTAS KERJA '.$bulan.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}
	
	function cetak_kertas_kerja_pdf()
	{
		set_time_limit(0);
		$tahun 		= $_REQUEST['tahun'];
		$bulan 		= $_REQUEST['bulan'];
		$jdlbln		= "";
		
		if ($bulan){
			$jdlbln ="BULAN ".$this->Pph_mdl->getMonth($bulan);
		}
		
		ob_start();

			
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path')); 
		//$this->load->library('fpdf');		
		//$pdf = new PDF_HTML();
		require('fpdf.php');
		
		
		
			/* // Page footer
			function Footer()
			{
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			} */
		
		
		$pdf = new fpdf();
		$pdf->AliasNbPages();
		$pdf->SetFont('Arial','B',6);		
		$pdf->AddPage();		
		
	    $pdf->Cell(0,0,'PT. PELABUHAN INDONESIA II (PERSERO)',0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,0,"KERTAS KERJA PERHITUNGAN PAJAK PENGHASILAN BADAN ".$jdlbln." TAHUN ".$tahun,0,1,'C');
		$pdf->Ln(10);
		
		$header = array('NO', 'URAIAN', 'LABA RUGI AUDITED','KOREKSI','SPT PPh TAHUN '.$tahun,'KETERANGAN');	

							
		//header
		// Column widths
		
		$w = array(10,3, 50, 25, 25,25, 25, 32);
		// Header
		$pdf->Cell($w[0],5,$header[0],'TL',0,'C');
		$pdf->Cell($w[1] + $w[2],5,$header[1],'TL',0,'C');
		$pdf->Cell($w[3],5,$header[2],'TL',0,'C');
		$pdf->Cell($w[4] + $w[5],5,$header[3],'TL',0,'C');
		$pdf->Cell($w[6],5,$header[4],'TL',0,'C');
		$pdf->Cell($w[7],5,$header[5],'TLR',1,'C');
		//$pdf->Ln();
		
		$pdf->Cell($w[0],5,'','L',0,'C');
		$pdf->Cell($w[1]+$w[2],5,'','L',0,'C');
		$pdf->Cell($w[3],5,'INDUK','TL',0,'C');
		$pdf->Cell($w[4],5,'POSITIF','TL',0,'C');
		$pdf->Cell($w[5],5,'NEGATIF','TL',0,'C');
		$pdf->Cell($w[6],5,'','L',0,'C');
		$pdf->Cell($w[7],5,'','LR',1,'C');
		//$pdf->Ln();
		
		$pdf->Cell($w[0],5, '1','TL',0,'C');
		$pdf->Cell($w[1]+$w[2],5, '2','TL',0,'C');
		$pdf->Cell($w[3],5, '3','TL',0,'C');
		$pdf->Cell($w[4],5, '4','TL',0,'C');
		$pdf->Cell($w[5],5, '5','TL',0,'C');
		$pdf->Cell($w[6],5, '6','TL',0,'C');
		$pdf->Cell($w[7],5, '7','TLR',1,'C');
		//$pdf->Ln();		
		//get detail
			$hValue	= 5;
			$numrow = 9; 
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			
			$query		= $this->Pph_badan_mdl->get_rekening7($bulan,$tahun);			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {			
						
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
						$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();

						$numrow++;							
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_JASA']." ".$row['JASA_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();			
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
			
				$numrow++; 				
			}		
			
			$pdf->SetFont('Arial','B');
			$pdf->Cell($w[0],$hValue, '','TL',0,'C');
			$pdf->Cell($w[1],$hValue, '','TL',0,'C');
			$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
			$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
			//$pdf->Ln();
						
			//Rekening 8
			$sum_uraian     = 0;
			$sum_posistif   = 0;			
			$sum_negatif    = 0;
			$sum_spt        = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name    = "";
			$isRowPertama   = "Y";
			
			$nilKomersilU	= 0;			
			$nilKomersilP	= 0;			
			$nilKomersilN	= 0;			
			$nilKomersilS	= 0;
			
			$amortisasiKomersilU	= 0;			
			$amortisasiKomersilP	= 0;			
			$amortisasiKomersilN	= 0;			
			$amortisasiKomersilS	= 0;	
			
			$query		= $this->Pph_badan_mdl->get_rekening8($bulan,$tahun);
			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama=="Y") {						
							
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						} else {				
							
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();

						}
						
						//Penyisihan Piutang
						if (substr($prev_kode_akun,0,5)==80104){ //krna jumlah di bwah rek 80104
							$nilKomersilU = $sum_uraian;
							$nilKomersilP = $sum_posistif;
							$nilKomersilN = $sum_negatif;
							$nilKomersilS = $sum_spt;
						}
									
						
						$numrow++;						
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
								
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {						
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}	

					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}				
						
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();							
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 
					
				if(substr($row['KODE_AKUN'],0,6)=='801046' || substr($row['KODE_AKUN'],0,6)=='801048'){
					$amortisasiKomersilU	+= $row['JML_URAIAN'];			
					$amortisasiKomersilP	+= $row['AMOUNT_POSITIF'];		
					$amortisasiKomersilN	+= $row['AMOUNT_NEGATIF'];			
					$amortisasiKomersilS	+= $row['SPT'];
				}
			}		

			$pdf->SetFont('Arial','B');
			$pdf->Cell($w[0],$hValue, '','TL',0,'C');
			$pdf->Cell($w[1],$hValue, '','TL',0,'C');
			$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
			$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
			//$pdf->Ln();
									
			$numrow++;						
		//end get detail 8

		//get detail 791 pendapatan usaha lain				
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			
			$query		= $this->Pph_badan_mdl->get_rekening791($bulan,$tahun);
			foreach($query->result_array() as $row)	{				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {					
					if ($numrow > 9) {						
						if ($isRowPertama == "Y") {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
							
						} else {
													
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						}
											
						$numrow++;
							
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
										
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);//sini
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();											
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++;				
			}			

		$pdf->SetFont('Arial','B');
		$pdf->Cell($w[0],$hValue, '','TL',0,'C');
		$pdf->Cell($w[1],$hValue, '','TL',0,'C');
		$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
		$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
					
		$numrow++;
		//end get detail 791		
		
		//get detail 891 beban usaha lain			
			
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			$query		= $this->Pph_badan_mdl->get_rekening891($bulan,$tahun);	
			foreach($query->result_array() as $row)	{
				
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama == "Y") {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						} else {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
							
						}
												
						$numrow++;
							
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);	
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);	
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();							
												
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 			
			}		

		$pdf->SetFont('Arial','B');
		$pdf->Cell($w[0],$hValue, '','TL',0,'C');
		$pdf->Cell($w[1],$hValue, '','TL',0,'C');
		$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
		$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
					
		$numrow++;
		//end get detail 891
		
		$pdf->SetFont('','');
		$pdf->Cell($w[0],$hValue, '','TL',0,'L');
		$pdf->Cell($w[1],$hValue, '','TL',0,'L');
		$pdf->Cell($w[2],$hValue, '','T',0,'L');
		$pdf->Cell($w[3],$hValue,'','TL',0,'R');
		$pdf->Cell($w[4],$hValue,'','TL',0,'R');
		$pdf->Cell($w[5],$hValue,'','TL',0,'R');
		$pdf->Cell($w[6],$hValue, '','TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
		 for ($x = 0; $x <= 51; $x++) {		
			//asset
			if ($x==1) {				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KOREKSI POSITIF BEBAN FINAL','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				//$pdf->Ln();				
			}				
			if ($x==2) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '1. Aset/bangunan disewa IKT','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();	
			}
		 	if ($x==3) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '2. Aset/bangunan disewa JICT','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==4) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '3. Aset KSO Koja','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==5) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '4. Aset  Cab Tanjung Priok','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}			
			if ($x==6) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '5. Aset Cab Pontianak','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==7) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '6. Aset Cabang Jambi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==8) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '7. Beban Bersama','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==10) {
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KOREKSI POSITIF BEBAN FINAL','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
		
			//Beda Waktu
			if ($x==12) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'BEDA WAKTU','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				//$pdf->Ln();
				
			}				
			if ($x==14) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '1','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan piutang dan PYMAD','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==15){
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Versi komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==16) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Versi fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			
			if ($x==18) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '2','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyusutan aktiva tetap','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
			}
			if ($x==19) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Penyusutan komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==20) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Penyusutan fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}	
			if ($x==21) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Koreksi KAP','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}

			if ($x==23) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '3','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Amortisasi  aktiva tidak berwujud','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
			}
			if ($x==24) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Amortisasi komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();		
			}			
			if ($x==25) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Amortisasi fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}	
			
			if ($x==27) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '4','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan  Imbalan Kerja','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}	
			
			if ($x==28) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Beban','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==29) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Realisasi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}

			if ($x==31) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '5','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan  Imbalan Kesehatan','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==32) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Beban','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}
			if ($x==33) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Realisasi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}				
			if ($x==34) {
				$tot_beda_waktuU =  $nilKomersilU + $amortisasiKomersilU ;
				$tot_beda_waktuP =  $nilKomersilP + $amortisasiKomersilP ;
				$tot_beda_waktuN =  $nilKomersilN + $amortisasiKomersilN ;
				$tot_beda_waktuS =  $nilKomersilS + $amortisasiKomersilS ;
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KOREKSI NEGATIF BEDA WAKTU','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}						

			//laba kena pajak
			if ($x==36) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'VIII.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'LABA KENA PAJAK DESEMBER '.$tahun,'TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			
			//pph terutang
			if ($x==38) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'IX.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'PPH TERUTANG '.$tahun,'TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			if ($x==39) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Beban Pajak Kini','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
								
			}
			if ($x==40) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Tarif  25%','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
			}
			if ($x==41) {
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH PPH TERUTANG','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
			}
			//KREDIT PAJAK
			if ($x==43) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'X.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KREDIT PAJAK','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			if ($x==44) { 				
				$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'22');	
				$qrow22  	= $q22->row(); 	
				$jml_data22	= $q22->num_rows();
				
				if($jml_data22>0){
					$jum22  	= $qrow22->JUMLAH;
				} else {
					$jum22 		= 0;
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '1','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 22','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($jum22,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');				
			}
			if ($x==45) {				
				$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'23');	
				$qrow22  	= $q22->row(); 	
				$jml_data22	= $q22->num_rows();
				
				if($jml_data22>0){
					$jum23  	= $qrow22->JUMLAH;
				} else {
					$jum23 		= 0;
				}
						
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '2','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 23','T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($jum23,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');				
			}
			if ($x==46) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '3','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 25','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
			}
			if ($x==48) {
				$tot_kredit_pajak = $jum22 + $jum23;
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KREDIT PAJAK','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($tot_kredit_pajak,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}
			if ($x==49) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'XI.','TLB',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KURANG (LEBIH) BAYAR PAJAK PENGHASILAN','TLB',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TLB',0,'C');
				$pdf->Cell($w[1],$hValue, '','TLB',0,'C');
				$pdf->Cell($w[2],$hValue, '','TB',0,'L');
				$pdf->Cell($w[3],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[4],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[5],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[6],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLRB',1,'L');
				
			}
						
			$numrow++;
		}
		 
		//penanda tangan	
		/* $pdf->Ln(8);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'Jakarta',0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'DVP PAJAK',0,0,'C');
		$pdf->Ln(20);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'asa',0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'NIPP. ',0,0,'C'); */
		//end tanda tangan
				
		$pdf->Output();		
		ob_end_flush(); 
		//echo $this->fpdf->Output('hello_world.pdf','D');// Name of PDF file		
	}

	
	function save_pph_badan()
	{
		$data	= $this->Pph_badan_mdl->action_save_pph_badan();
		if($data){			
			echo '1';
		} else {			
			echo '0';
		}
	}

	function delete_pph_badan()
	{
		$data	= $this->Pph_badan_mdl->action_delete_pph_badan();
		if($data){			
			echo '1';
		} else {			
			echo '0';
		}
	}
		
	function get_period()
	{

		$report 	= "PDF";
		$query		= $this->Pph_badan_mdl->action_get_period();

		echo $query;
		die();	
		$rowCount	= $query->num_rows();
		
		if ($rowCount>0){					
			$report = "EXCEL";			
		} 
		echo json_encode($report);
		$query->free_result();
	}

	function cetak_kartu_kerja_xls()
	{
		/*set_time_limit(0);
		$tahun 		= $_REQUEST['tahun'];
		$bulan 		= $_REQUEST['bulan'];
		$date	    = date("Y-m-d H:i:s");
		$jdlbln		= "";
		*/
		$jeniskk 	= $_REQUEST['jeniskk'];
		$nmjeniskk 	= $_REQUEST['nmjeniskk'];
		$tahun 		= $_REQUEST['tahun'];
		$bulan		= $_REQUEST['bulan'];
		$masa		= $_REQUEST['namabulan'];
		$cabang		= $_REQUEST['kd_cabang'];

		if ($jeniskk=="Perhitungan Pajak Kini"){
			$this->cetak_kk_pajak_kini_xls($jeniskk,$nmjeniskk,$tahun,$bulan,$masa,$cabang);
		} else if ($jeniskk == "PPH PSL 22"){
			$this->cetak_equal_pph23_26_xls($jeniskk,$nmjeniskk,$tahun,$bulan,$masa,$cabang);
		} else if($jeniskk=="PPH PSL 4 AYAT 2"){
			$this->cetak_equal_pph4_ayat2_xls($jeniskk,$nmjeniskk,$tahun,$bulan,$masa,$cabang);
		} 	
	}

	function cetak_kk_pajak_kini_xls($jeniskk,$nmjeniskk,$tahun,$bulan,$masa,$cabang)
	{
		if ($bulan){
			$jdlbln ="BULAN ".$this->Pph_mdl->getMonth($bulan);
		}
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Cetak Kertas Kerja")
								->setSubject("Cetakan")
								->setDescription("Cetak KK Setahun")
								->setKeywords("KK");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$center_bold_border = array(
		        'font' => array('bold' => true,
								'size' => 14), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$center_nobold_noborder = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);	
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);			
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$rata_kanan = array(
		     'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  )
		);	
		
		$border_bawah_kanan_kiri = array(
		    'borders' => array(
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "KERTAS KERJA PERHITUNGAN PAJAK PENGHASILAN BADAN ".$jdlbln." TAHUN ".$tahun); 
		$excel->getActiveSheet()->mergeCells('B1:I4');	
		$excel->getActiveSheet()->getStyle('B1:I4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "NO.");
		$excel->getActiveSheet()->mergeCells('B5:B7');	
		$excel->getActiveSheet()->getStyle('B5:B7')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "U R A I A N");
		$excel->getActiveSheet()->mergeCells('C5:D7');	
		$excel->getActiveSheet()->getStyle('C5:D7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('E6', "LABA RUGI AUDITED"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E7', "INDUK");
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($center_nobold_noborder);
		$excel->getActiveSheet()->getStyle('E7')->applyFromArray($center_nobold_noborder);

		$excel->setActiveSheetIndex(0)->setCellValue('F5', "KOREKSI");
		$excel->setActiveSheetIndex(0)->setCellValue('F7', "POSITIF");
		$excel->setActiveSheetIndex(0)->setCellValue('G7', "NEGATIF");
		$excel->getActiveSheet()->mergeCells('F5:G6');
		$excel->getActiveSheet()->getStyle('F5:G6')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('F7')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('G7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H5', "SPT PPh TAHUN ".$tahun);
		$excel->getActiveSheet()->mergeCells('H5:H7');	
		$excel->getActiveSheet()->getStyle('H5:H7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I5', "KETERANGAN");
		$excel->getActiveSheet()->mergeCells('I5:I7');	
		$excel->getActiveSheet()->getStyle('I5:I7')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('B8', "1");
		$excel->setActiveSheetIndex(0)->setCellValue('C8', "2");
		$excel->getActiveSheet()->mergeCells('C8:D8');
		$excel->setActiveSheetIndex(0)->setCellValue('E8', "3");
		$excel->setActiveSheetIndex(0)->setCellValue('F8', "4");
		$excel->setActiveSheetIndex(0)->setCellValue('G8', "5");
		$excel->setActiveSheetIndex(0)->setCellValue('H8', "6");
		$excel->setActiveSheetIndex(0)->setCellValue('I8', "7");
		$excel->getActiveSheet()->getStyle('B8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('C8:D8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('E8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('F8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('G8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('H8')->applyFromArray($center_no_bold_border);
		$excel->getActiveSheet()->getStyle('I8')->applyFromArray($center_no_bold_border);
		
		// end header

		//get detail 7				
						
			$query		= $this->Pph_badan_mdl->get_rekening7($bulan,$tahun);
			//$no = 1; // Untuk penomoran tabel, di awal set dengan 1
			$numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 4
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
						
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						//kembalikan summary ke 0
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {					
						$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_JASA']." ".$row['JASA_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
			
				$numrow++; // Tambah 1 setiap kali looping					
			}		

		//end get detail 7
		
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$numrow++;
		
		//get detail 8			
			$sum_uraian     = 0;
			$sum_posistif   = 0;			
			$sum_negatif    = 0;
			$sum_spt        = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name    = "";
			$isRowPertama   = "Y";
			
			$nilKomersilU	= 0;			
			$nilKomersilP	= 0;			
			$nilKomersilN	= 0;			
			$nilKomersilS	= 0;
			
			$amortisasiKomersilU	= 0;			
			$amortisasiKomersilP	= 0;			
			$amortisasiKomersilN	= 0;			
			$amortisasiKomersilS	= 0;	
			
			$query		= $this->Pph_badan_mdl->get_rekening8($bulan,$tahun);
			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama=="Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}
						
						//Penyisihan Piutang
						if (substr($prev_kode_akun,0,5)==80104){ //krna jumlah di bwah rek 80104
							$nilKomersilU = $sum_uraian;
							$nilKomersilP = $sum_posistif;
							$nilKomersilN = $sum_negatif;
							$nilKomersilS = $sum_spt;
						}
						
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);						
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}				
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {						
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 
					
				if(substr($row['KODE_AKUN'],0,6)=='801046' || substr($row['KODE_AKUN'],0,6)=='801048'){
					$amortisasiKomersilU	+= $row['JML_URAIAN'];			
					$amortisasiKomersilP	+= $row['AMOUNT_POSITIF'];		
					$amortisasiKomersilN	+= $row['AMOUNT_NEGATIF'];			
					$amortisasiKomersilS	+= $row['SPT'];
				}
			}		

		//end get detail 8

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
			$numrow++;
		
						
		//get detail 791 pendapatan usaha lain				
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			
			$query		= $this->Pph_badan_mdl->get_rekening791($bulan,$tahun);
			foreach($query->result_array() as $row)	{				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {					
					if ($numrow > 9) {						
						if ($isRowPertama == "Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
										
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);//sini
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++;				
			}		


		$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
					
		$numrow++;
		//end get detail 791	
		
		//get detail 891 beban usaha lain			
			
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			$query		= $this->Pph_badan_mdl->get_rekening891($bulan,$tahun);	
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama == "Y") {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						} else {
							$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
							$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
							$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
							$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
							$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	
						}

						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
						
						$numrow++;
							
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "");	
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "");	
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
						
						//kembalikan summary ke 0
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);	
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
											
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);	
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, substr($curr_kode_akun,0,3));
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $parent_name);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);					
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['AMOUNT_NEGATIF']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['SPT']);	
						
						
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);								
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; // Tambah 1 setiap kali looping					
			}		

		$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH ".$parent_name." =");	
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_uraian);	
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $sum_posistif);	
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_negatif);	
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_spt);	

		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($borderfull_bold_rata_kiri);
					
		$numrow++;
		//end get detail 891		

		//start hardcode
		$nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  )
		);	

		$center_bold_border_kika = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);		
		
		for ($x = 0; $x <= 51; $x++) {

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_bold_border_kika);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
		
			//asset
			if ($x==1) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KOREKSI POSITIF BEBAN FINAL");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}				
			if ($x==2) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1. Aset/bangunan disewa IKT");
			if ($x==3) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2. Aset/bangunan disewa JICT");
			if ($x==4) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3. Aset KSO Koja");
			if ($x==5) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "4. Aset  Cab Tanjung Priok");
			if ($x==6) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "5. Aset Cab Pontianak");
			if ($x==7) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "6. Aset Cabang Jambi");
			if ($x==8) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "7. Beban Bersama");
			if ($x==10) $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "JUMLAH KOREKSI POSITIF BEBAN FINAL");

			//Beda Waktu
			if ($x==12) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "BEDA WAKTU");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);	
			}				
			if ($x==14) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan piutang dan PYMAD");				
			}
			if ($x==15){
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Versi komersil");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $nilKomersilU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $nilKomersilP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $nilKomersilN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $nilKomersilS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);			
			}
			if ($x==16) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Versi fiskal");
			
			if ($x==18) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyusutan aktiva tetap");							
			}
			if ($x==19) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Penyusutan komersil");
			if ($x==20) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Penyusutan fiskal");	
			if ($x==21) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Koreksi KAP");	

			if ($x==23) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Amortisasi  aktiva tidak berwujud");
			}
			if ($x==24) {
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Amortisasi komersil");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $amortisasiKomersilU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $amortisasiKomersilP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $amortisasiKomersilN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $amortisasiKomersilS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
			}			
			if ($x==25) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Amortisasi fiskal");	
			
			if ($x==27) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "4");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan  Imbalan Kerja");
			}	
			
			if ($x==28) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Beban");	
			if ($x==29) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Realisasi");	

			if ($x==31) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "5");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Penyisihan  Imbalan Kesehatan");
			}
			if ($x==32) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Beban");	
			if ($x==33) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "- Realisasi");				
			if ($x==34) {
				$tot_beda_waktuU =  $nilKomersilU + $amortisasiKomersilU ;
				$tot_beda_waktuP =  $nilKomersilP + $amortisasiKomersilP ;
				$tot_beda_waktuN =  $nilKomersilN + $amortisasiKomersilN ;
				$tot_beda_waktuS =  $nilKomersilS + $amortisasiKomersilS ;
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH KOREKSI NEGATIF BEDA WAKTU");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tot_beda_waktuU);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $tot_beda_waktuP);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $tot_beda_waktuN);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $tot_beda_waktuS);	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
				
					
			}					

			//laba kena pajak
			if ($x==36) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "VIII.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "LABA KENA PAJAK DESEMBER ".$tahun);	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			
			//pph terutang
			if ($x==38) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "IX.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "PPH TERUTANG ".$tahun);	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			if ($x==39) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Beban Pajak Kini");	
			if ($x==40) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "Tarif  25%");	
			if ($x==41) $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH PPH TERUTANG");			

			//KREDIT PAJAK
			if ($x==43) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "X.");	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KREDIT PAJAK");	
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
			if ($x==44) { 
				/* $where = " and nama_pajak='22' and tahun_pajak=".$tahun;
				if ($bulan) {
					$where .= " and masa_pajak='".$bulan."' ";
				} */
				/* $sql_22 = " select nama_pajak, nvl(sum(jumlah_potong),0) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";
						$q22    	= $this->db->query($sql_22); */
						
						$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'22');	
						$qrow22  	= $q22->row(); 	
						$jml_data22	= $q22->num_rows();
						
						if($jml_data22>0){
							$jum22  	= $qrow22->JUMLAH;
						} else {
							$jum22 		= 0;
						}
				
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "1.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 22");	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $jum22);	
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);			
			}
			if ($x==45) {
				/* $where = " and nama_pajak='23' and tahun_pajak=".$tahun;
				if ($bulan) {
					$where .= " and masa_pajak='".$bulan."' ";
				}
				$sql_22 = " select nama_pajak, nvl(sum(jumlah_potong),0) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";					
						$q22    	= $this->db->query($sql_22); */
						
						$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'23');	
						$qrow22  	= $q22->row(); 	
						$jml_data22	= $q22->num_rows();
						
						if($jml_data22>0){
							$jum23  	= $qrow22->JUMLAH;
						} else {
							$jum23 		= 0;
						}
						
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "2.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 23");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $jum23);	
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
			}
			if ($x==46) {
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "3.");	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "PPh pasal 25");	
			}
			if ($x==48) {
				$tot_kredit_pajak = $jum22 + $jum23;
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "JUMLAH KREDIT PAJAK");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tot_kredit_pajak);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '');	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '');	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');	
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_bold_rata_kanan);	
				
			}
			if ($x==49) {
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "XI.");
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "KURANG (LEBIH) BAYAR PAJAK PENGHASILAN");
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($parent_col);
			}
						
			$numrow++;
		} 		
		
		//end hardcode
		
		$numrowStart = 10;
		$excel->getActiveSheet()->getStyle('E'.$numrowStart.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		// $excel->getActiveSheet()->getStyle('H'.$numrowStart.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('E'.$numrowStart.':H'.$numrow)->applyFromArray($rata_kanan);
		
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('C'.$numrow.':D'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_bawah_kanan_kiri);
		
		//total
		/*
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH DISETOR");

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		*/		
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(2); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(40); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom A
	
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("CETAK KK");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="KERTAS KERJA '.$bulan.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function cetak_kk_pajak_kini_pdf()
	{
		set_time_limit(0);
		$tahun 		= $_REQUEST['tahun'];
		$bulan 		= $_REQUEST['bulan'];
		$jdlbln		= "";
		
		if ($bulan){
			$jdlbln ="BULAN ".$this->Pph_mdl->getMonth($bulan);
		}
		
		ob_start();

			
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path')); 
		//$this->load->library('fpdf');		
		//$pdf = new PDF_HTML();
		require('fpdf.php');
		
		
		
			/* // Page footer
			function Footer()
			{
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			} */
		
		
		$pdf = new fpdf();
		$pdf->AliasNbPages();
		$pdf->SetFont('Arial','B',6);		
		$pdf->AddPage();		
		
	    $pdf->Cell(0,0,'PT. PELABUHAN INDONESIA II (PERSERO)',0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,0,"KERTAS KERJA PERHITUNGAN PAJAK PENGHASILAN BADAN ".$jdlbln." TAHUN ".$tahun,0,1,'C');
		$pdf->Ln(10);
		
		$header = array('NO', 'URAIAN', 'LABA RUGI AUDITED','KOREKSI','SPT PPh TAHUN '.$tahun,'KETERANGAN');	

							
		//header
		// Column widths
		
		$w = array(10,3, 50, 25, 25,25, 25, 32);
		// Header
		$pdf->Cell($w[0],5,$header[0],'TL',0,'C');
		$pdf->Cell($w[1] + $w[2],5,$header[1],'TL',0,'C');
		$pdf->Cell($w[3],5,$header[2],'TL',0,'C');
		$pdf->Cell($w[4] + $w[5],5,$header[3],'TL',0,'C');
		$pdf->Cell($w[6],5,$header[4],'TL',0,'C');
		$pdf->Cell($w[7],5,$header[5],'TLR',1,'C');
		//$pdf->Ln();
		
		$pdf->Cell($w[0],5,'','L',0,'C');
		$pdf->Cell($w[1]+$w[2],5,'','L',0,'C');
		$pdf->Cell($w[3],5,'INDUK','TL',0,'C');
		$pdf->Cell($w[4],5,'POSITIF','TL',0,'C');
		$pdf->Cell($w[5],5,'NEGATIF','TL',0,'C');
		$pdf->Cell($w[6],5,'','L',0,'C');
		$pdf->Cell($w[7],5,'','LR',1,'C');
		//$pdf->Ln();
		
		$pdf->Cell($w[0],5, '1','TL',0,'C');
		$pdf->Cell($w[1]+$w[2],5, '2','TL',0,'C');
		$pdf->Cell($w[3],5, '3','TL',0,'C');
		$pdf->Cell($w[4],5, '4','TL',0,'C');
		$pdf->Cell($w[5],5, '5','TL',0,'C');
		$pdf->Cell($w[6],5, '6','TL',0,'C');
		$pdf->Cell($w[7],5, '7','TLR',1,'C');
		//$pdf->Ln();		
		//get detail
			$hValue	= 5;
			$numrow = 9; 
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			
			$query		= $this->Pph_badan_mdl->get_rekening7($bulan,$tahun);			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {			
						
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
						$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();

						$numrow++;							
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent     	= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_JASA']." ".$row['JASA_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();			
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
			
				$numrow++; 				
			}		
			
			$pdf->SetFont('Arial','B');
			$pdf->Cell($w[0],$hValue, '','TL',0,'C');
			$pdf->Cell($w[1],$hValue, '','TL',0,'C');
			$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
			$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
			//$pdf->Ln();
						
			//Rekening 8
			$sum_uraian     = 0;
			$sum_posistif   = 0;			
			$sum_negatif    = 0;
			$sum_spt        = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name    = "";
			$isRowPertama   = "Y";
			
			$nilKomersilU	= 0;			
			$nilKomersilP	= 0;			
			$nilKomersilN	= 0;			
			$nilKomersilS	= 0;
			
			$amortisasiKomersilU	= 0;			
			$amortisasiKomersilP	= 0;			
			$amortisasiKomersilN	= 0;			
			$amortisasiKomersilS	= 0;	
			
			$query		= $this->Pph_badan_mdl->get_rekening8($bulan,$tahun);
			
			foreach($query->result_array() as $row)	{
				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,5);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama=="Y") {						
							
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						} else {				
							
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();

						}
						
						//Penyisihan Piutang
						if (substr($prev_kode_akun,0,5)==80104){ //krna jumlah di bwah rek 80104
							$nilKomersilU = $sum_uraian;
							$nilKomersilP = $sum_posistif;
							$nilKomersilN = $sum_negatif;
							$nilKomersilS = $sum_spt;
						}
									
						
						$numrow++;						
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
								
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {						
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}	

					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}				
						
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();							
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 
					
				if(substr($row['KODE_AKUN'],0,6)=='801046' || substr($row['KODE_AKUN'],0,6)=='801048'){
					$amortisasiKomersilU	+= $row['JML_URAIAN'];			
					$amortisasiKomersilP	+= $row['AMOUNT_POSITIF'];		
					$amortisasiKomersilN	+= $row['AMOUNT_NEGATIF'];			
					$amortisasiKomersilS	+= $row['SPT'];
				}
			}		

			$pdf->SetFont('Arial','B');
			$pdf->Cell($w[0],$hValue, '','TL',0,'C');
			$pdf->Cell($w[1],$hValue, '','TL',0,'C');
			$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
			$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
			$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
			//$pdf->Ln();
									
			$numrow++;						
		//end get detail 8

		//get detail 791 pendapatan usaha lain				
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			
			$query		= $this->Pph_badan_mdl->get_rekening791($bulan,$tahun);
			foreach($query->result_array() as $row)	{				
				//cari parent akun
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {					
					if ($numrow > 9) {						
						if ($isRowPertama == "Y") {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
							
						} else {
													
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						}
											
						$numrow++;
							
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
										
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);//sini
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();											
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++;				
			}			

		$pdf->SetFont('Arial','B');
		$pdf->Cell($w[0],$hValue, '','TL',0,'C');
		$pdf->Cell($w[1],$hValue, '','TL',0,'C');
		$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
		$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
					
		$numrow++;
		//end get detail 791		
		
		//get detail 891 beban usaha lain			
			
			$sum_uraian = 0;
			$sum_posistif = 0;			
			$sum_negatif = 0;
			$sum_spt = 0;		
			$prev_kode_akun = "";
			$curr_kode_akun = "";
			$parent_name = "";
			$isRowPertama = "Y";
			$query		= $this->Pph_badan_mdl->get_rekening891($bulan,$tahun);	
			foreach($query->result_array() as $row)	{
				
				$curr_kode_akun = substr($row['KODE_AKUN'],0,3);
				if ($prev_kode_akun != $curr_kode_akun) {
					
					if ($numrow > 9) {
						if ($isRowPertama == "Y") {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, '','T',0,'L');
							$pdf->Cell($w[3],$hValue, '','TL',0,'R');
							$pdf->Cell($w[4],$hValue, '','TL',0,'R');
							$pdf->Cell($w[5],$hValue, '','TL',0,'R');
							$pdf->Cell($w[6],$hValue, '','TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
						} else {
														
							$pdf->SetFont('Arial','B');
							$pdf->Cell($w[0],$hValue, '','TL',0,'C');
							$pdf->Cell($w[1],$hValue, '','TL',0,'C');
							$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
							$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
							$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
							//$pdf->Ln();
							
						}
												
						$numrow++;
							
						$pdf->SetFont('Arial','B');
						$pdf->Cell($w[0],$hValue, '','TL',0,'C');
						$pdf->Cell($w[1],$hValue, '','TL',0,'C');
						$pdf->Cell($w[2],$hValue, '','T',0,'L');
						$pdf->Cell($w[3],$hValue, '','TL',0,'R');
						$pdf->Cell($w[4],$hValue, '','TL',0,'R');
						$pdf->Cell($w[5],$hValue, '','TL',0,'R');
						$pdf->Cell($w[6],$hValue, '','TL',0,'R');
						$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
						//$pdf->Ln();
						
						$sum_uraian = 0;
						$sum_posistif = 0;			
						$sum_negatif = 0;
						$sum_spt = 0;		
							
						$numrow++;	

					}
					
					$qParent		= $this->Pph_badan_mdl->get_parent_rekening7($curr_kode_akun);	
					$qrow          	= $qParent->row(); 
					$jml_data		= $qParent->num_rows();
					
					if ($jml_data > 0) {
					  $parent_name  	= $qrow->DESCRIPTION; 					
					} else {
						$qParent		= $this->Pph_badan_mdl->get_parent_rekening7_2($curr_kode_akun);	
						$qrow          	= $qParent->row(); 
						$jml_data		= $qParent->num_rows();
						
						if ($jml_data > 0) {
							$parent_name  	= $qrow->DESCRIPTION; 					
						} else {
							$parent_name  	= "";
						}
					
					}
										
					$pdf->SetFont('Arial','B');
					$pdf->Cell($w[0],$hValue, substr($curr_kode_akun,0,3),'TL',0,'L');
					$pdf->Cell($w[1] + $w[2],$hValue, $parent_name,'TL',0,'L');
					$pdf->Cell($w[3],$hValue, '','TL',0,'L');
					$pdf->Cell($w[4],$hValue, '','TL',0,'L');
					$pdf->Cell($w[5],$hValue, '','TL',0,'L');
					$pdf->Cell($w[6],$hValue, '','TL',0,'L');
					$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
					//$pdf->Ln();
					$prev_kode_akun = $curr_kode_akun;
					$numrow++;					
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, $row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'],'T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['JML_URAIAN'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_POSITIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['AMOUNT_NEGATIF'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($row['SPT'],2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();							
												
			
				$sum_uraian 	= $sum_uraian + $row['JML_URAIAN'];
				$sum_posistif 	= $sum_posistif + $row['AMOUNT_POSITIF'];			
				$sum_negatif 	= $sum_negatif + $row['AMOUNT_NEGATIF'];
				$sum_spt 		= $sum_spt + $row['SPT'];		
				
				$isRowPertama = "N";
				$numrow++; 			
			}		

		$pdf->SetFont('Arial','B');
		$pdf->Cell($w[0],$hValue, '','TL',0,'C');
		$pdf->Cell($w[1],$hValue, '','TL',0,'C');
		$pdf->Cell($w[2],$hValue, 'JUMLAH '.$parent_name.' =','T',0,'L');
		$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_uraian,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[4],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_posistif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[5],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_negatif,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[6],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($sum_spt,2,'.',',')),'TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
					
		$numrow++;
		//end get detail 891
		
		$pdf->SetFont('','');
		$pdf->Cell($w[0],$hValue, '','TL',0,'L');
		$pdf->Cell($w[1],$hValue, '','TL',0,'L');
		$pdf->Cell($w[2],$hValue, '','T',0,'L');
		$pdf->Cell($w[3],$hValue,'','TL',0,'R');
		$pdf->Cell($w[4],$hValue,'','TL',0,'R');
		$pdf->Cell($w[5],$hValue,'','TL',0,'R');
		$pdf->Cell($w[6],$hValue, '','TL',0,'R');
		$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
		//$pdf->Ln();
		 for ($x = 0; $x <= 51; $x++) {		
			//asset
			if ($x==1) {				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KOREKSI POSITIF BEBAN FINAL','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				//$pdf->Ln();				
			}				
			if ($x==2) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '1. Aset/bangunan disewa IKT','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();	
			}
		 	if ($x==3) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '2. Aset/bangunan disewa JICT','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==4) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '3. Aset KSO Koja','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==5) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '4. Aset  Cab Tanjung Priok','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}			
			if ($x==6) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '5. Aset Cab Pontianak','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==7) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '6. Aset Cabang Jambi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==8) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '7. Beban Bersama','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==10) {
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KOREKSI POSITIF BEBAN FINAL','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
		
			//Beda Waktu
			if ($x==12) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'BEDA WAKTU','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				//$pdf->Ln();
				
			}				
			if ($x==14) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '1','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan piutang dan PYMAD','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==15){
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Versi komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($nilKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==16) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Versi fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			
			if ($x==18) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '2','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyusutan aktiva tetap','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
			}
			if ($x==19) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Penyusutan komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==20) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Penyusutan fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}	
			if ($x==21) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Koreksi KAP','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}

			if ($x==23) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '3','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Amortisasi  aktiva tidak berwujud','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
			}
			if ($x==24) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Amortisasi komersil','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();		
			}			
			if ($x==25) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Amortisasi fiskal','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}	
			
			if ($x==27) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '4','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan  Imbalan Kerja','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}	
			
			if ($x==28) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Beban','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}
			if ($x==29) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Realisasi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				//$pdf->Ln();	
			}

			if ($x==31) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '5','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Penyisihan  Imbalan Kesehatan','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				//$pdf->Ln();
			}
			if ($x==32) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Beban','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}
			if ($x==33) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, '- Realisasi','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}				
			if ($x==34) {
				$tot_beda_waktuU =  $nilKomersilU + $amortisasiKomersilU ;
				$tot_beda_waktuP =  $nilKomersilP + $amortisasiKomersilP ;
				$tot_beda_waktuN =  $nilKomersilN + $amortisasiKomersilN ;
				$tot_beda_waktuS =  $nilKomersilS + $amortisasiKomersilS ;
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KOREKSI NEGATIF BEDA WAKTU','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilU,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilP,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[5],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilN,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[6],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($amortisasiKomersilS,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}						

			//laba kena pajak
			if ($x==36) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
				
				
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'VIII.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'LABA KENA PAJAK DESEMBER '.$tahun,'TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			
			//pph terutang
			if ($x==38) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'IX.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'PPH TERUTANG '.$tahun,'TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			if ($x==39) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Beban Pajak Kini','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
								
			}
			if ($x==40) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'Tarif  25%','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
			}
			if ($x==41) {
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH PPH TERUTANG','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
			}
			//KREDIT PAJAK
			if ($x==43) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'X.','TL',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KREDIT PAJAK','TL',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
			}
			if ($x==44) { 				
				$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'22');	
				$qrow22  	= $q22->row(); 	
				$jml_data22	= $q22->num_rows();
				
				if($jml_data22>0){
					$jum22  	= $qrow22->JUMLAH;
				} else {
					$jum22 		= 0;
				}
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '1','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 22','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($jum22,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');				
			}
			if ($x==45) {				
				$q22		= $this->Pph_badan_mdl->get_pph_badan($bulan,$tahun,'23');	
				$qrow22  	= $q22->row(); 	
				$jml_data22	= $q22->num_rows();
				
				if($jml_data22>0){
					$jum23  	= $qrow22->JUMLAH;
				} else {
					$jum23 		= 0;
				}
						
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '2','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 23','T',0,'L');
				$pdf->Cell($w[3],$hValue, preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($jum23,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');				
			}
			if ($x==46) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'L');
				$pdf->Cell($w[1],$hValue, '3','TL',0,'L');
				$pdf->Cell($w[2],$hValue, 'PPh pasal 25','T',0,'L');
				$pdf->Cell($w[3],$hValue,'','TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
			}
			if ($x==48) {
				$tot_kredit_pajak = $jum22 + $jum23;
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, 'JUMLAH KREDIT PAJAK','T',0,'L');
				$pdf->Cell($w[3],$hValue,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($tot_kredit_pajak,2,'.',',')),'TL',0,'R');
				$pdf->Cell($w[4],$hValue,'','TL',0,'R');
				$pdf->Cell($w[5],$hValue,'','TL',0,'R');
				$pdf->Cell($w[6],$hValue,'','TL',0,'R');
				$pdf->Cell($w[7],$hValue,'','TLR',1,'L');
				
			}
			if ($x==49) {
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TL',0,'C');
				$pdf->Cell($w[1],$hValue, '','TL',0,'C');
				$pdf->Cell($w[2],$hValue, '','T',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'R');
				$pdf->Cell($w[4],$hValue, '','TL',0,'R');
				$pdf->Cell($w[5],$hValue, '','TL',0,'R');
				$pdf->Cell($w[6],$hValue, '','TL',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');
								
				$pdf->SetFont('Arial','B');
				$pdf->Cell($w[0],$hValue, 'XI.','TLB',0,'L');
				$pdf->Cell($w[1] + $w[2],$hValue, 'KURANG (LEBIH) BAYAR PAJAK PENGHASILAN','TLB',0,'L');
				$pdf->Cell($w[3],$hValue, '','TL',0,'L');
				$pdf->Cell($w[4],$hValue, '','TL',0,'L');
				$pdf->Cell($w[5],$hValue, '','TL',0,'L');
				$pdf->Cell($w[6],$hValue, '','TL',0,'L');
				$pdf->Cell($w[7],$hValue, '','TLR',1,'L');					
				
				$pdf->SetFont('','');
				$pdf->Cell($w[0],$hValue, '','TLB',0,'C');
				$pdf->Cell($w[1],$hValue, '','TLB',0,'C');
				$pdf->Cell($w[2],$hValue, '','TB',0,'L');
				$pdf->Cell($w[3],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[4],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[5],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[6],$hValue, '','TLB',0,'R');
				$pdf->Cell($w[7],$hValue, '','TLRB',1,'L');
				
			}
						
			$numrow++;
		}
		 
		//penanda tangan	
		/* $pdf->Ln(8);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'Jakarta',0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'DVP PAJAK',0,0,'C');
		$pdf->Ln(20);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'asa',0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(130);
		$pdf->Cell(30,10, 'NIPP. ',0,0,'C'); */
		//end tanda tangan
				
		$pdf->Output();		
		ob_end_flush(); 
		//echo $this->fpdf->Output('hello_world.pdf','D');// Name of PDF file		
	}

	function beban_tantiem()
	{
		$this->template->set('title', 'Beban Tantiem');
		$data['subtitle']	= "Beban Tantiem";
		$data['error'] = "";
		$this->template->load('template', 'beban_tantiem/beban_tantiem',$data);
	}

	function load_beban_tantiem()
	{
    	$result	= $this->Beban_tantiem_mdl->get_beban_tantiem();
		echo json_encode($result);
	}
	
	function golongan_pajak_kini()
	{
		$this->template->set('title', 'Golongan Pajak Kini');
		$data['subtitle']	= "Golongan Pajak Kini";
		$data['error'] = "";
		$this->template->load('template', 'golongan_pajak_kini/show_gol_pajak_kini',$data);
	}

	function load_golongan_pajak_kini()
	{
    	$result	= $this->Golongan_pajak_kini_mdl->get_gol_pajak_kini();
		echo json_encode($result);
	}

	function load_bupot_report() {
		$hasil		= $this->Pph_badan_mdl->get_bupot_lain_report();
			$rowCount	= $hasil['jmlRow'] ;
			$query 		= $hasil['query'];		
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	
				{
					$ii++;
			
					$result['data'][] = array(
					'no'				=> $row['RNUM'],
					'nama_cabang'		=> $row['NAMA_CABANG'],
					'pph23'		=> number_format($row['PPH23'],2,".",","),
					'pph22'		=> number_format($row['PPH22'],2,".",","),
					'pph25'		=> number_format($row['PPH25'],2,".",",")
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
	  
	  function load_bupot_report_summary() {

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph_badan/upd_bupot_lain", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
				
		if($permission === true) {
			$hasil    = $this->Pph_badan_mdl->get_total_report_summary();			
			foreach($hasil->result_array() as $row)	{						
					$result['total22'] = $row['TOTALPPH22'];
					$result['total23'] = $row['TOTALPPH23'];
					$result['total25'] = $row['TOTALPPH25'];
				}
		}
		echo json_encode($result);
		$hasil->free_result();
	}
	
	function cek_data_bl_excel() {
		$ledger   	= ($_REQUEST['ledger'])? strtoupper($_REQUEST['ledger']):"";
		$bulan   	= $_REQUEST['month'];
		$tahun   	= $_REQUEST['year'];
		$cabang   	= $_REQUEST['cab'];
		$akun   	= $_REQUEST['akun'];
		$cek	= $this->Pph_badan_mdl->cek_ledger_excel($ledger,$bulan,$tahun,$cabang,$akun);
		if ($cek){
			echo '1';
		} else {
			echo '0';
		}
	}

	function eksport_bl_excel() {
		set_time_limit(0);
		$ledger   	= ($_REQUEST['ledger'])? $_REQUEST['ledger']:"";
		$bulan   	= ($_REQUEST['month'])? $_REQUEST['month']:"";		
		$tahun   	= ($_REQUEST['year'])? $_REQUEST['year']:"";
		$cab	   	= ($_REQUEST['cab'])? $_REQUEST['cab']:"";
		$akun	   	= ($_REQUEST['akun'])? $_REQUEST['akun']:"";
		$nmbulan	= "";
		$nmcabang	= "";
		$nmpajak	= "";
		if($bulan){
			$nmbulan  = $this->Pph_mdl->getMonth($_REQUEST['month']);
		}
		if($cab && $cab != "all"){
			$nmcabang = $this->cabang_mdl->get_by_id($cab)->NAMA_CABANG;
		} else {
			$nmcabang ="Semua Cabang";
		}
		
		if($ledger){
			$nmledger = "LEDGER ".$ledger;
		} 		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Export Rincian Biaya Lain")
								->setSubject("Cetakan")
								->setDescription("Export Rincian Biaya Lain Setahun")
								->setKeywords("BL");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$center_bold_border = array(
		        'font' => array('bold' => true,
								'size' => 14), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$center_nobold_noborder = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);	
		
		$center_no_bold_border_kika = array(
		        'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);			
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$rata_kanan = array(
		     'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  )
		);	
		
		$border_bawah_kanan_kiri = array(
		    'borders' => array(
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "DAFTAR RINCIAN BEBAN");
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($border_kika_nobold_rata_kiri);
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->getActiveSheet()->getStyle('B2')->applyFromArray($border_kika_nobold_rata_kiri);
		$excel->setActiveSheetIndex(0)->setCellValue('B3', strtoupper($nmcabang));
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($border_kika_nobold_rata_kiri);
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE ".$nmbulan." ".$tahun);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($border_kika_nobold_rata_kiri);
		
		//$excel->setActiveSheetIndex(0)->setCellValue('B2', "DAFTAR RINCIAN BEBAN ".$nmbulan." ".$tahun." ".strtoupper($nmcabang)); 
		//$excel->getActiveSheet()->mergeCells('B2:I4');	
		//$excel->getActiveSheet()->getStyle('B2:I4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B6', "No");
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C6', "JENIS BEBAN");
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('D6', "NOMOR BUKTI"); 
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "TGL. BUKTI");
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "URAIAN");
		$excel->getActiveSheet()->getStyle('F6')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('G6', "JUMLAH");
		$excel->getActiveSheet()->getStyle('G6')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H6', "DE");
		$excel->getActiveSheet()->getStyle('H6')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I6', "NDE");		
		$excel->getActiveSheet()->getStyle('I6')->applyFromArray($center_no_bold_border);	
		
		// end header

		//get detail 8	
			$no 	= 1;
			$numrow = 7; 			
			$data       = $this->Pph_badan_mdl->get_data_bl_excel();			
			foreach($data->result_array() as $row)	{				
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $no);	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION']);	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['NOMOR_BUKTI']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['TGL_BUKTI']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['JML_URAIAN']);	
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['DEDUCTIBLE']);	
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['NON_DEDUCTIBLE']);		
									
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_no_bold_border_kika);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($center_no_bold_border_kika);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($center_no_bold_border_kika);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($center_no_bold_border_kika);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);					
				
				$excel->getActiveSheet()->getStyle('G'.$numrow.':H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');	
				$excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');		
				$no++;
				$numrow++; 			
			}
			//$numrowBawah = $numrow -1;
			$numrowBawah = $numrow;
			$sumnumrow = $numrowBawah -1;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrowBawah, "TOTAL");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowBawah, "=SUM(G7:G".$sumnumrow.")");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrowBawah, "=SUM(H7:H".$sumnumrow.")");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrowBawah, "=SUM(I7:I".$sumnumrow.")");
			$excel->getActiveSheet()->getStyle('G'.$numrowBawah.':H'.$numrowBawah)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrowBawah)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');		
			//$excel->getActiveSheet()->getStyle('B'.$numrowBawah.':I'.$numrowBawah)->applyFromArray($border_bawah_kanan_kiri);
				
				
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(35); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(50); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom A
	
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("EKSPORT DAFTAR RINCIAN");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="DAFTAR RINCIAN '.$ledger." ".$nmbulan.' '.$tahun.' '.$nmcabang.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function cek_report_bl_excel() 
	{
		$bulan   	= $_REQUEST['month'];
		$tahun   	= $_REQUEST['year'];
		$cabang   	= $_REQUEST['cab'];
			$cek	= $this->Pph_badan_mdl->cek_tahun_report_bupot($bulan,$tahun,$cabang);
			if ($cek){
				echo '1';
			} else {
				echo '0';
			}
	}

	function export_report_bl_excel() {
		set_time_limit(0);
		$bulan   	= ($_REQUEST['month'])? $_REQUEST['month']:"";		
		$tahun   	= ($_REQUEST['year'])? $_REQUEST['year']:"";
		$cab	   	= ($_REQUEST['cab'])? $_REQUEST['cab']:"";
		$nmbulan	= "";
		$nmcabang	= "";
		if($bulan){
			$nmbulan  = $this->Pph_mdl->getMonth($_REQUEST['month']);
		}
		if($cab){
			$nmcabang = $this->cabang_mdl->get_by_id($cab)->NAMA_CABANG;
		}
			
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Report Bukti Potong")
								->setSubject("Report")
								->setDescription("Report Bukti Potong")
								->setKeywords("BUPOT");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$center_bold_border = array(
		        'font' => array('bold' => true,
								'size' => 14), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$center_nobold_noborder = array(
		        'font' => array('bold' => true, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);	
		
		$center_no_bold_border_kika = array(
		        'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);			
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		$border_kika_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	

		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi ditengah secara horizontal (center)
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$rata_kanan = array(
		     'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi ditengah secara horizontal (center)
		  )
		);	
		
		$border_bawah_kanan_kiri = array(
		    'borders' => array(
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($border_kika_nobold_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Kredit Pajak PPh Badan ".$nmbulan." ".$tahun." ".strtoupper($nmcabang)); 
		$excel->getActiveSheet()->mergeCells('B2:F4');	
		$excel->getActiveSheet()->getStyle('B2:F4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B6', "No");
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C6', "Cabang");
		$excel->getActiveSheet()->getStyle('C6')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('D6', "PDD PASAL 23 Jml. Bukti Potong"); 
		$excel->getActiveSheet()->getStyle('D6')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "PDD PASAL 22 Jml. Bukti Potong");
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "PDD PASAL 25 Jml. Bukti Potong");
		$excel->getActiveSheet()->getStyle('F6')->applyFromArray($center_no_bold_border);	
		
		
		// end header

		//get detail 7	
		$no 	= 1;
			$numrow = 7; 			
			$data       = $this->Pph_badan_mdl->get_report_bupot_excel();
			foreach($data->result_array() as $row)	{				
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $no);	
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['NAMA_CABANG']);	
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['PPH23']);	
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['PPH22']);	
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['PPH25']);		
									
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_no_bold_border_kika);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($border_kika_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($border_kika_nobold_rata_kanan);											
				
				$excel->getActiveSheet()->getStyle('D'.$numrow.':E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');	
				$excel->getActiveSheet()->getStyle('F'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');	
				$no++;
				$numrow++; 			
			}
			//$numrowBawah = $numrow -1;
			$numrowBawah = $numrow;
			$sumnumrow = $numrowBawah -1;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrowBawah, "TOTAL");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrowBawah, "=SUM(D7:D".$sumnumrow.")");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowBawah, "=SUM(E7:E".$sumnumrow.")");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowBawah, "=SUM(F7:F".$sumnumrow.")");
			//$excel->getActiveSheet()->getStyle('B'.$numrowBawah.':P'.$numrowBawah)->applyFromArray($border_bawah_kanan_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrowBawah.':E'.$numrowBawah)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('F'.$numrowBawah)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');		
			

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(4); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom A	
	
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi PORTRAIT
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("REPORT BUPOT");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Kredit Pajak PPh Badan '.$nmbulan.' '.$tahun.' '.$nmcabang.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	//proses data tb akun 7 dan 8
	function process_data_kf_tb78()
	{
		$is_proses = $this->Pph_badan_mdl->is_process_kf_tb78();
		if($is_proses){
			echo '4';
		} else {
			$data	= $this->Pph_badan_mdl->do_process_kf_tb78();
			if($data){
				echo '1';
			} else {
				echo '0';
			}
		}
		
	}
	//end proses
	
}
