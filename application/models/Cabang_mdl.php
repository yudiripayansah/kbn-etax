<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang_mdl extends CI_Model {

	function get_all(){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_KODE_CABANG'); 
		$this->db->where('AKTIF', 'Y');
		$query = $this->db->get();

		return $query->result_array();
	}
	
	function get_by_id($kode_cabang){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_KODE_CABANG'); 
		$this->db->where('KODE_CABANG', $kode_cabang);
		$query = $this->db->get();

		return $query->row();
	}

	function get_og_id($kode_cabang){

		$sql   = "SELECT organization_id from simtax_kode_cabang where kode_cabang = '".$kode_cabang."'";

		$query = $this->db->query($sql);

		return $query->row()->ORGANIZATION_ID;
	}

}

/* End of file Cabang_mdl.php */
/* Location: ./application/models/Cabang_mdl.php */