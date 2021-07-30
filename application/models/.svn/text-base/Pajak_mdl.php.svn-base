<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pajak_mdl extends CI_Model {

	
    public function __construct()
    {
        parent::__construct();
		    
    }

	function get_daftar_pajak($kelompok_pajak = ""){

		$and = "";

		if($kelompok_pajak != ""){
			$and = " and kelompok_pajak = '".$kelompok_pajak."'";
		}

		$queryString = "SELECT kelompok_pajak, jns_pajak jenis_pajak from
						(select kelompok_pajak
						     , case kelompok_pajak 
						       when 'PPH21' then 'PPH PSL 21'
						       else jenis_pajak
						       end jns_pajak
						  from SIMTAX_MASTER_JNS_PAJAK
						 where nvl(AKTIF,'N') = 'Y' ".$and."
						group by kelompok_pajak, jenis_pajak)
						group by kelompok_pajak, jns_pajak
						order by kelompok_pajak";
		$query = $this->db->query($queryString);		

		return $query->result();

	}

	function get_daftar_pajak_detail($kelompok_pajak = ""){
		
		$this->db->select('*');
		$this->db->from('SIMTAX_MASTER_JNS_PAJAK');

		if($kelompok_pajak != ""){
			$this->db->where('KELOMPOK_PAJAK', $kelompok_pajak);
		}

		$this->db->where('AKTIF', "Y");

		$this->db->order_by('KELOMPOK_PAJAK');
		$query = $this->db->get();

		return $query->result();

	}
	

}

/* End of file Pajak_mdl.php */
/* Location: ./application/models/Pajak_mdl.php */