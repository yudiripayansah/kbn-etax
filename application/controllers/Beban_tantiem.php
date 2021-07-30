<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beban_tantiem extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
                {
                        redirect('dashboard', 'refresh');
                }

		$this->load->model('cabang_mdl');
		$this->load->model('Pph_mdl');
        $this->load->model('Pph_badan_mdl');
        $this->load->model('Beban_tantiem_mdl');
    }

    function load_beban_tantiem()
	{
      	$result	= $this->Beban_tantiem_mdl->get_beban_tantiem();
		echo json_encode($result);
	}
	
	function save_bebantantiem()
	{
		
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('edit_nama', 'NAMA', 'required');
			$this->form_validation->set_rules('edit_tahun', 'TAHUN', 'required');
			$this->form_validation->set_rules('edit_divisi', 'DIVISI', 'required');

			if ($this->form_validation->run() === TRUE)
			{	
				$nama= $this->input->post('edit_nama');
				$tahun= $this->input->post('edit_tahun');
				$divisi= $this->input->post('edit_divisi');
				$isNewRecord= $this->input->post('isNewRecord');

				$check_duplicate_btantiem = $this->Beban_tantiem_mdl->check_duplicate_bbn_tantiem($nama, $tahun, $divisi);

				
					if($check_duplicate_btantiem > 0){
						if($isNewRecord > 0){
							echo '2';
							die();
						} else {
							$data	= $this->Beban_tantiem_mdl->action_save_bebantantiem();
							if($data){
								echo '1';
							} else {
								echo '0';
							}
						}
					}
					else{
						$data	= $this->Beban_tantiem_mdl->action_save_bebantantiem();
						if($data){
							echo '1';
						} else {
							echo '0';
						}
					}
				
			}else
			{
				echo validation_errors();
			}
		}
	}

	function delete_bt() 
	{
			$data	= $this->Beban_tantiem_mdl->action_delete();
			if($data){
				echo '1';
			} else {
				echo '1';
			}
			
	}

	//Config Tantiem
	function config_tantiem()
	{
		$this->template->set('title', 'Config Tantiem');
		$data['subtitle']	= "Config Tantiem";
		$data['activepage'] = "master_data";
		$this->template->load('template', 'beban_tantiem/config_tantiem',$data);
	}	


	function load_config_tantiem()
	{
		$result	= $this->Beban_tantiem_mdl->get_cfg_tantiem();	
		echo json_encode($result);
	}

	function save_config_tantiem()
	{
		
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('edit_nama', 'NAMA', 'required');

			if ($this->form_validation->run() === TRUE)
			{	
				$nama = $this->input->post('edit_nama');
				$isnewrecord = $this->input->post('isNewRecord');

				$check_duplicate_tahun = $this->Beban_tantiem_mdl->check_duplic_config_tantiem($nama);
				
				if($check_duplicate_tahun > 0){
					echo '3';
					die();
				}
				else{

						$data	= $this->Beban_tantiem_mdl->action_save_config_tantiem($nama);
						if($data){
							echo '1';
						} else {
							echo '0';
						}
					
				}
			}else
			{
				echo validation_errors();
			}
		}
	}

	function delete_config_tantiem() 
	{
			$data	= $this->Beban_tantiem_mdl->action_delete_config_tantiem();
			if($data){
				echo '1';
			} else {
				echo '1';
			}
			
	}

	function load_combo_tantiem()
	{
      	$hasil	= $this->Beban_tantiem_mdl->get_master_config_tantiem();
		$query 		= $hasil['query'];			
			$result ="<option value=''>-- Pilih Nama --</option>";
			foreach($query->result_array() as $row)	{
				$result .= "<option value='".$row['NAMA']."' data-name='".$row['NAMA']."' >".$row['NAMA']."</option>";
			}		
		echo $result;
		$query->free_result();

    }	

	//End Config Tantiem

    
}   