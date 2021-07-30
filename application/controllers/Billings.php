<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->load->helper('date_helper');
		
		$this->load->model('billing_mdl', 'billing');
		$this->load->model('cabang_mdl', 'cabang');
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}
/*		else if (!$this->ion_auth->is_admin())
		{
			if(!in_array("billings", $this->session->userdata['menu_url']))
			{
				redirect('dashboard');
			}
		}*/

	}

	public function index()
	{
		
		$this->data['template_page'] = "administrator/billing";
		$this->data['title']         = 'ID Billing';
		$this->data['subtitle']      = "Daftar Bukti ID BIlling";
		$this->data['activepage']    = "billing";
		
		$group_pajak                 = get_daftar_pajak();
		
		$newgroupPajak               = array();

		foreach ($group_pajak as $key => $value) {
			if($value->KELOMPOK_PAJAK == "PPH" || $value->KELOMPOK_PAJAK == "PPH21"){
				$newgroupPajak[] = "PPh";
			}
			else{
				$newgroupPajak[] = str_replace("PPH","PPh",$value->JENIS_PAJAK);
			}
		}

		$uniques = array_unique($newgroupPajak);
		$this->data['jenis_pajak']   = $uniques;

		$this->data['list_cabang']   = $this->cabang->get_all();


		$this->template->load('template', $this->data['template_page'], $this->data);
		
	}

	public function get_billing2(){

		$start    = ($this->input->post('start')) ? $this->input->post('start') : 0;
		$length   = ($this->input->post('length')) ? $this->input->post('length') : 10;
		$draw     = ($this->input->post('draw')) ? $this->input->post('draw') : 0;
		$keywords = (isset($_POST['search'])) ? $_POST['search']['value'] : '';

		
		$this->data['billing'] = $this->billing->get_all($start, $length, $draw, $keywords);
		$total_billing         = $this->billing->get_total( $keywords);

		foreach($this->data['billing'] as $value) {
			if($value->NAMA_PAJAK == "PPN MASUKAN"){
				$nama_pajak = "PPN IMPOR";
			}
			elseif($value->NAMA_PAJAK == "PPN KELUARAN"){
				$nama_pajak = "PPN MASA";
			}
			else{
				$nama_pajak = $value->NAMA_PAJAK;
			}
			$row[] = array(
						'no'            => $value->RNUM,
						'id'            => $value->ID,
						'nama_pajak'    => $nama_pajak,
						'masa_pajak'    => $value->MASA_PAJAK,
						'bulan_pajak'   => $value->BULAN_PAJAK,
						'pembetulan_ke' => $value->PEMBETULAN_KE,
						'tahun_pajak'   => $value->TAHUN_PAJAK,
						'file_name'     => ($value->FILE_NAME) ? '<a href="uploads/billing/'.$value->FILE_NAME.'" class="link_file_billing" target="_blank">'.$value->FILE_NAME.'</a>' : '',
						'kode_cabang'   => $value->KODE_CABANG,
						'nama_cabang'   => get_nama_cabang($value->KODE_CABANG),
						'keterangan'    => $value->KETERANGAN
					);
		}

		$result['data']            = ($total_billing > 0) ? $row : "";
		$result['draw']            = ($total_billing > 0) ? $draw : "";
		$result['recordsTotal']    = ($total_billing > 0) ? $total_billing : 0;
		$result['recordsFiltered'] = ($total_billing > 0) ? $total_billing : 0;

		echo json_encode($result);

	}

	public function get_billing(){

		// if($this->ion_auth->is_admin()){
			$permission = true;
		// }
		// else if(in_array("admin/billings", $this->session->userdata['menu_url'])){
		// 	$permission = true;
		// }
		// else{
		// 	$permission = false;
		// }

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
			
			$this->data['billing'] = $this->billing->get_all($kode_cabang, $start, $length, $draw, $keywords);
			$total_billing         = $this->billing->get_total($kode_cabang,  $keywords);

			foreach($this->data['billing'] as $value) {
				if($value->NAMA_PAJAK == "PPN MASUKAN"){
					$nama_pajak = "PPN IMPOR";
				}
				elseif($value->NAMA_PAJAK == "PPN KELUARAN"){
					$nama_pajak = "PPN MASA";
				}
				else{
					$nama_pajak = $value->NAMA_PAJAK;
				}

				$row[] = array(
							'no'            => $value->RNUM,
							'id'            => $value->ID,
							'nama_pajak'    => $nama_pajak,
							'masa_pajak'    => $value->MASA_PAJAK,
							'bulan_pajak'   => $value->BULAN_PAJAK,
							'pembetulan_ke' => $value->PEMBETULAN_KE,
							'tahun_pajak'   => $value->TAHUN_PAJAK,
							'file_name'     => ($value->FILE_NAME) ? '<a href="uploads/billing/'.$value->FILE_NAME.'" class="link_file_billing" target="_blank" style="color:red">View File</a>' : '',
							'kode_cabang'   => $value->KODE_CABANG,
							'nama_cabang'   => get_nama_cabang($value->KODE_CABANG),
							'keterangan'    => $value->KETERANGAN
						);
			}

			$result['data']            = ($total_billing > 0) ? $row : "";
			$result['draw']            = ($total_billing > 0) ? $draw : "";
			$result['recordsTotal']    = ($total_billing > 0) ? $total_billing : 0;
			$result['recordsFiltered'] = ($total_billing > 0) ? $total_billing : 0;

		}

		echo json_encode($result);

	}

	public function save_billing($id = NULL){

		$this->form_validation->set_rules('nama_pajak', 'Nama Pajak', 'required');
		$this->form_validation->set_rules('masa_pajak', 'Masa Pajak', 'required');
		$this->form_validation->set_rules('tahun_pajak', 'Tahun Pajak', 'required');

		if ($this->form_validation->run() === TRUE)
		{

			$nama_pajak  = $this->input->post('nama_pajak');
			$kode_cabang = $this->session->userdata('kd_cabang');
			$masa_pajak  = get_masa_pajak($this->input->post('masa_pajak'));
			$bulan_pajak = $this->input->post('masa_pajak');
			$tahun_pajak = $this->input->post('tahun_pajak');
			$keterangan  = $this->input->post('keterangan');

			$date      = date("Y-m-d h:i:s", time());
			$timestamp = strtotime($date);
			$encrypted = md5($timestamp);

			if($id == NULL){
				if (empty($_FILES['data_billing']['name'])){
					echo 'Pilih File';
					die();
				}
			}
			if(isset($_FILES['data_billing'])){
				if($_FILES['data_billing']['name'] != ""){
					$path      = $_FILES['data_billing']['name'];
					$ext       = pathinfo($path, PATHINFO_EXTENSION);
					$file_name = $encrypted.".".$ext;
				}
			}
			$data = array(
				'NAMA_PAJAK'  => $nama_pajak,
				'KODE_CABANG' => $kode_cabang,
				'MASA_PAJAK'  => strtoupper($masa_pajak),
				'BULAN_PAJAK' => $bulan_pajak,
				'TAHUN_PAJAK' => $tahun_pajak,
				'KETERANGAN'  => $keterangan
				);

			if($id != NULL){

				if ($this->billing->update($data, $id)) {

					if(!empty($_FILES['data_billing']['name'])){

						if($_FILES['data_billing']['name'] != ""){
							$file_name_billingDelete   = $this->billing->get_by_id($id)->FILE_NAME;
							if (file_exists(FCPATH."./uploads/billing/".$file_name_billingDelete)){
								unlink("./uploads/billing/".$file_name_billingDelete);
							}
						}
						if($upl = $this->_upload('data_billing', 'billing/', $file_name, 'pdf')){

							$data = array(
								'FILE_NAME'   => $file_name
							);

							if ($this->billing->update($data, $id)) {
								echo '1';
							}
							else {
								echo 'Gagal';
							}
						}
						else{
							echo 'Gagal Upload';
						}
					}
					else{
						echo '1';
					}
				}
				else{
					echo 'Gagal';
				}
			}
			else{

				if ($this->billing->add($data)) {

					if($upl = $this->_upload('data_billing', 'billing/', $file_name, 'pdf')){

						$data = array(
							'FILE_NAME'   => $file_name
						);
						$lastId = $this->billing->get_last_id();

						if ($this->billing->update($data, $lastId)) {
							echo '1';
						}
						else {
							echo 'Gagal';
						}
					}
					else{
						echo 'Gagal Uploads';
					}

				}
				else{
					echo 'Gagal';
				}

			}

		}
		else{

			echo validation_errors();

		}
		
	}

	public function delete_billing($id = NULL){

		$id = (int)$id;
		$this->form_validation->set_rules('id', 'No id Selected', 'required|alpha_numeric');

		$file_name = $this->billing->get_by_id($id)->FILE_NAME;

		if ($this->form_validation->run() === TRUE)
		{
			if($this->billing->delete($id)){
				if (file_exists(FCPATH."./uploads/billing/".$file_name)){
					unlink("./uploads/billing/".$file_name);
				}
				echo '1';
			}
			else {
				echo 'Gagal';
			}
		}

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

/* End of file Billings.php */
/* Location: ./application/controllers/Billings.php */