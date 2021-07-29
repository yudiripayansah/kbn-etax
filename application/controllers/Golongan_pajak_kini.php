<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan_pajak_kini extends CI_Controller {

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
        $this->load->model('Golongan_pajak_kini_mdl');
    }

	function save_golongan_pajakkini()
	{
		
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('edit_uraian', 'URAIAN', 'required');
			$this->form_validation->set_rules('edit_tahun', 'BULAN', 'required');
			$this->form_validation->set_rules('edit_tahun', 'TAHUN', 'required');

			if ($this->form_validation->run() === TRUE)
			{	
				$uraian= $this->input->post('edit_uraian');
				$jumlah= $this->input->post('edit_jumlah');
				$bulan= $this->input->post('edit_bulan');
				$tahun= $this->input->post('edit_tahun');
				$isNewRecord= $this->input->post('isNewRecord');

				$check_duplicate_golpjkkini = $this->Golongan_pajak_kini_mdl->check_duplicate_gol_pajakkini($uraian, $tahun, $bulan);

					if($check_duplicate_golpjkkini > 0){
						if($isNewRecord > 0){
							echo '2';
							die();
						} else {
							$data	= $this->Golongan_pajak_kini_mdl->action_save_golongan_pajakkini();
							if($data){
								echo '1';
							} else {
								echo '0';
							}
						}
					}
					else{
						$data	= $this->Golongan_pajak_kini_mdl->action_save_golongan_pajakkini();
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
			$data	= $this->Golongan_pajak_kini_mdl->action_delete();
			if($data){
				echo '1';
			} else {
				echo '1';
			}
			
		}

    
}   