<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signature extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->model('signature_mdl', 'signature');
		$this->load->model('cabang_mdl', 'cabang');
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}

	}

	public function index()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("admin/signature", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		if($permission === false)
		{
			redirect('dashboard');
		}
		else{

			$this->data['template_page'] = "administrator/signature";
			$this->data['title']         = 'Penanda Tangan';
			$this->data['subtitle']      = "Penanda Tangan";
			$this->data['activepage']    = "administrator";
			
			$this->data['users']         = $this->ion_auth->users()->result_array();
			$this->data['list_cabang']   = $this->cabang->get_all();
			
			$group_pajak                 = get_daftar_pajak();
			$this->data['jenis_pajak']   = $group_pajak;

			$this->template->load('template', $this->data['template_page'], $this->data);

		}
	}

	public function get_signature(){

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("admin/signature", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;

		if($permission === true)
		{

			$start    = ($this->input->post('start')) ? $this->input->post('start') : 0;
			$length   = ($this->input->post('length')) ? $this->input->post('length') : 10;
			$draw     = ($this->input->post('draw')) ? $this->input->post('draw') : 0;
			$keywords = (isset($_POST['search'])) ? $_POST['search']['value'] : '';

			$kode_cabang = $this->session->userdata('kd_cabang');
			
			$this->data['signature'] = $this->signature->get_all($kode_cabang, $start, $length, $draw, $keywords);
			$total_signature         = $this->signature->get_total($kode_cabang, $keywords);

			foreach($this->data['signature'] as $value) {

				$row[] = array(
							'no'                   => $value->RNUM,
							'id'                   => $value->ID,
							'document_type'        => $value->DOCUMENT_TYPE,
							'nama_pemotong'        => $value->NAMA_WP_PEMOTONG,
							'npwp_pemotong'        => $value->NPWP_PEMOTONG,
							'npwp_petugas'         => $value->NPWP_PETUGAS,
							'alamat_pemotong'      => $value->ALAMAT_WP_PEMOTONG,
							'nama_petugas'         => $value->NAMA_PETUGAS_PENANDATANGAN,
							'jabatan_petugas'      => $value->JABATAN_PETUGAS_PENANDATANGAN,
							'ttd_cap_petugas'      => $value->TTD_CAP_PETUGAS_PENANDATANGAN,
							'start_effective_date' => date("d-m-Y", strtotime($value->START_EFFECTIVE_DATE)),
							'end_effective_date'   => ($value->END_EFFECTIVE_DATE != NULL) ? date("d-m-Y", strtotime($value->END_EFFECTIVE_DATE)) : '',
							'url_tanda_tangan'     => $value->URL_TANDA_TANGAN,
							'url_penugasan'        => $value->URL_PENUGASAN,
							'file_penugasan'       => $value->FILE_PENUGASAN,
							'nama_pajak'       	   => $value->NAMA_PAJAK,
							'nama_kpp'       	   => $value->NAMA_KPP,
							'link_cap'             => ($value->TTD_CAP_PETUGAS_PENANDATANGAN) ? '<a href='.base_url().'uploads/signature/cap_tandatangan/'.$value->TTD_CAP_PETUGAS_PENANDATANGAN.' class="link_file_billing" target="_blank" style="color:red">View File</a>' : '',
							'link_file'             => ($value->FILE_PENUGASAN) ? '<a href='.base_url().'uploads/signature/file_penugasan/'.$value->FILE_PENUGASAN.' class="link_file_billing" target="_blank" style="color:red">View File</a>' : '',

						);
			}

			$result['data']            = ($total_signature > 0) ? $row : "";
			$result['draw']            = ($total_signature > 0) ? $draw : "";
			$result['recordsTotal']    = ($total_signature > 0) ? $total_signature : 0;
			$result['recordsFiltered'] = ($total_signature > 0) ? $total_signature : 0;

		}

		echo json_encode($result);

	}

	public function save_signature($id = NULL){

		$this->form_validation->set_rules('nama_pemotong', 'Nama Pemotong', 'required');
		$this->form_validation->set_rules('npwp_pemotong', 'NPWP Pemotong', 'required');
		$this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');
		$this->form_validation->set_rules('jabatan_petugas', 'Jabatan Petugas', 'required');
		$this->form_validation->set_rules('tgl_aktif', 'Tanggal Aktif', 'required');
		$this->form_validation->set_rules('tgl_inaktif', 'Tanggal Inaktif', 'required');
		$this->form_validation->set_rules('inputNamaKPP', 'Nama Kantor Pelayanan Pajak', 'required');
		$this->form_validation->set_rules('inputNamaPajak', 'Nama Pajak', 'required');

		if ($this->form_validation->run() === TRUE)
		{
			$kode_cabang     = $this->session->userdata('kd_cabang');
			$tahun_pajak     = $this->input->post('tahun_pajak');
			$keterangan      = $this->input->post('keterangan');
			
			$nama_pemotong   = $this->input->post('nama_pemotong');
			$npwp_pemotong   = $this->input->post('npwp_pemotong');
			$nama_petugas    = $this->input->post('nama_petugas');
			$jabatan_petugas = $this->input->post('jabatan_petugas');
			$alamat_pemotong = $this->input->post('alamat_pemotong');
			
			$nama_kpp        = $this->input->post('inputNamaKPP');
			$nama_pajak      = $this->input->post('inputNamaPajak');
			$document_type   = $this->input->post('document_type');
			$npwp_petugas    = $this->input->post('npwp_petugas');
			$file_name_cap   = $this->input->post('file_cap');
			$url_tanda_tangan  = "";
			$file_name_tugas = $this->input->post('file_cap');
			$url_penugasan   = "";
			
			$date      = date("Y-m-d h:i:s", time());
			$timestamp = strtotime($date);
			$encrypted = md5($timestamp);

			if($id == NULL){
				if (empty($_FILES['cap_tandatangan']['name'])){
					echo 'Pilih File Cap Tanda Tangan';
					die();
				}
				if (empty($_FILES['file_penugasan']['name'])){
					echo 'Pilih File Penugasan';
					die();
				}
			}
			if(isset($_FILES['cap_tandatangan'])){
				if($_FILES['cap_tandatangan']['name'] != ""){
					$path             = $_FILES['cap_tandatangan']['name'];
					$ext              = pathinfo($path, PATHINFO_EXTENSION);
					$file_name_cap    = $encrypted.".".$ext;
					$url_tanda_tangan = "uploads/signature/cap_tandatangan/".$file_name_cap;
				}
			}
			if(isset($_FILES['file_penugasan'])){
				if($_FILES['file_penugasan']['name'] != ""){
					$path            = $_FILES['file_penugasan']['name'];
					$ext             = pathinfo($path, PATHINFO_EXTENSION);				
					$file_name_tugas = $encrypted.".".$ext;
					$url_penugasan   = "uploads/signature/file_penugasan/".$file_name_tugas;
				}
			}

			$data = array(
				'NAMA_WP_PEMOTONG'              => $nama_pemotong,
				'NPWP_PEMOTONG'                 => $npwp_pemotong,
				'ALAMAT_WP_PEMOTONG'            => $alamat_pemotong,
				'NAMA_PETUGAS_PENANDATANGAN'    => $nama_petugas,
				'JABATAN_PETUGAS_PENANDATANGAN' => $jabatan_petugas,
				'KODE_CABANG'                   => $kode_cabang,
				'NAMA_KPP'                      => $nama_kpp,
				'NAMA_PAJAK'                    => $nama_pajak,
				'DOCUMENT_TYPE'                 => $document_type,
				'NPWP_PETUGAS'                 	=> $npwp_petugas
				);

			$tgl_aktif   = date("Y-m-d H:i:s", strtotime(str_replace("/","-", $this->input->post('tgl_aktif'))));
			$tgl_inaktif = date("Y-m-d H:i:s", strtotime(str_replace("/","-", $this->input->post('tgl_inaktif'))));

			if($id != NULL){

				if ($this->signature->update($id, $data, $tgl_aktif, $tgl_inaktif)) {

					if(isset($_FILES['cap_tandatangan'])){
						if($_FILES['cap_tandatangan']['name'] != ""){
							$file_name_capDelete   = $this->signature->get_by_id($id)->TTD_CAP_PETUGAS_PENANDATANGAN;
							if (file_exists(FCPATH."./uploads/signature/cap_tandatangan/".$file_name_capDelete)){
								unlink("./uploads/signature/cap_tandatangan/".$file_name_capDelete);
							}
						}
					}
					if(isset($_FILES['file_penugasan']['name'])){
						if($_FILES['file_penugasan']['name'] != ""){
							$file_name_tugasDelete = $this->signature->get_by_id($id)->FILE_PENUGASAN;
							if (file_exists(FCPATH."./uploads/signature/file_penugasan/".$file_name_tugasDelete)){
								unlink("./uploads/signature/file_penugasan/".$file_name_tugasDelete);
							}
						}
					}

					$updated = true;					
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '0';

					$this->load->library('upload', $config);			
					
					foreach ($_FILES as $fieldname => $fileObject)
					{
        				if($fieldname == "cap_tandatangan"){
        					$data = array(
								'TTD_CAP_PETUGAS_PENANDATANGAN' => $file_name_cap,
								'URL_TANDA_TANGAN'              => $url_tanda_tangan
							);
							$config['file_name']   = $file_name_cap;
							$config['upload_path'] = './uploads/signature/cap_tandatangan/';
        				}
        				else{
        					$data = array(
								'FILE_PENUGASAN' => $file_name_tugas,
								'URL_PENUGASAN'  => $url_penugasan
							);
        					$config['file_name'] = $file_name_tugas;
							$config['upload_path'] = './uploads/signature/file_penugasan/';
        				}
					    if (!empty($fileObject['name']))
					    {
					        $this->upload->initialize($config);
					        if (file_exists(FCPATH.$config['upload_path'].$config['file_name'])){
								unlink($config['upload_path'].$config['file_name']);
							}
					        if (!$this->upload->do_upload($fieldname))
					        {
					            $errors = $this->upload->display_errors();
					            flashMsg($errors);
					        }
					        else
					        {
					        	if ($this->signature->update($id, $data)) {
									$updated = true;
								}
								else{
									$updated = false;
								}
					        }
					    }
					}
					if($updated == true){
						echo '1';
					}
					else{
						echo '0';
					}
				}
				else{
					echo '0';
				}
			}
			else{
				if ($this->signature->add($data, $tgl_aktif, $tgl_inaktif)) {

					$last_id = $this->signature->get_last_id();
					$updated = true;
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '0';

					$this->load->library('upload', $config);

					foreach ($_FILES as $fieldname => $fileObject)
					{
        				if($fieldname == "cap_tandatangan"){
        					$data = array(
								'TTD_CAP_PETUGAS_PENANDATANGAN' => $file_name_cap,
								'URL_TANDA_TANGAN'              => $url_tanda_tangan
							);
							$config['file_name']   = $file_name_cap;
							$config['upload_path'] = './uploads/signature/cap_tandatangan/';
        				}
        				else{
        					$data = array(
								'FILE_PENUGASAN' => $file_name_tugas,
								'URL_PENUGASAN'  => $url_penugasan
							);
        					$config['file_name'] = $file_name_tugas;
							$config['upload_path'] = './uploads/signature/file_penugasan/';
        				}
					    if (!empty($fileObject['name']))
					    {
					        $this->upload->initialize($config);
					        if (file_exists(FCPATH.$config['upload_path'].$config['file_name'])){
								unlink($config['upload_path'].$config['file_name']);
							}
					        if (!$this->upload->do_upload($fieldname))
					        {
					            $errors = $this->upload->display_errors();
					            flashMsg($errors);
					        }
					        else
					        {
					        	if ($this->signature->update($last_id, $data)) {
									$updated = true;
								}
								else{
									$updated = false;
								}
					        }
					    }
					}
					if(isset($_FILES['cap_tandatangan']['name']) || isset($_FILES['file_penugasan']['name']) && $updated == true){
						echo '1';
					}
					else{
						echo '0';
					}
				}
				else{
					echo '0';
				}
			}
		}
		else{
			echo validation_errors();
		}
		
	}

	public function delete_signature($id = NULL){

		$id = (int)$id;
		$this->form_validation->set_rules('id', 'No id Selected', 'required|alpha_numeric');
		
		$file_name_cap   = $this->signature->get_by_id($id)->TTD_CAP_PETUGAS_PENANDATANGAN;
		$file_name_tugas = $this->signature->get_by_id($id)->FILE_PENUGASAN;

		if ($this->form_validation->run() === TRUE)
		{
			if($this->signature->delete($id)){
				if (file_exists(FCPATH."./uploads/signature/cap_tandatangan/".$file_name_cap)){
					unlink("./uploads/signature/cap_tandatangan/".$file_name_cap);
				}
				if (file_exists(FCPATH."./uploads/signature/file_penugasan/".$file_name_tugas)){
					unlink("./uploads/signature/file_penugasan/".$file_name_tugas);
				}
				echo '1';
			}
			else {
				echo '0';
			}
		}
	}

	private function _upload3($field_name, $file_name, $ext){
        //file upload destination
        $upload_path = './uploads/signature/';
        $config['upload_path'] = $upload_path;
        //allowed file types. * means all types
        $config['allowed_types'] = 'jpeg|jpg|png|pdf';
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
			
			if (file_exists(FCPATH.$upload_path."/".$file_name.".".$ext)){
				unlink($upload_path."/".$file_name.".".$ext);
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
                	return $image_data['file_name'];
                }

            }
        }

        return false;
	}



	private function _upload($field_name, $folder_name, $file_name, $allowed_types){
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

			if (file_exists(FCPATH.$upload_path.$folder_name."/".$file_name)){
				unlink($upload_path.$folder_name."/".$file_name);
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

/* End of file Signature.php */
/* Location: ./application/controllers/signature.php */