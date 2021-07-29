<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_mdl extends CI_Model {

	function get_all($kode_cabang, $start, $length, $draw, $keywords=""){

		$where	= "";
		if($keywords) {
			$q = strtoupper($keywords);
			$where = " AND (
						UPPER(SBID.NAMA_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.MASA_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.TAHUN_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.KETERANGAN) LIKE '%".$q."%'
						OR UPPER(SKC.NAMA_CABANG) LIKE '%".$q."%'
						) ";
		}

		$mainQuery = "SELECT SBID.*, SKC.NAMA_CABANG
							FROM SIMTAX_BUKTI_ID_BILLING SBID
							LEFT JOIN SIMTAX_KODE_CABANG SKC ON SBID.KODE_CABANG = SKC.KODE_CABANG
							where SBID.KODE_CABANG = '".$kode_cabang."'
							".$where." ORDER BY ID DESC";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$mainQuery."
						) a 
						WHERE rownum <= ".$start." + ".$length."
					)
					WHERE rnum > ".$start;

		$query = $this->db->query($sql);

		return $query->result();
	}

	function get_total($kode_cabang, $keywords = ""){

		$where	= "";
		if($keywords) {
			$q = strtoupper($keywords);
			$where = " AND (
						UPPER(SBID.NAMA_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.MASA_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.TAHUN_PAJAK) LIKE '%".$q."%'
						OR UPPER(SBID.KETERANGAN) LIKE '%".$q."%'
						OR UPPER(SKC.NAMA_CABANG) LIKE '%".$q."%'
						) ";
		}

		$mainQuery = "SELECT SBID.*, SKC.NAMA_CABANG
							FROM SIMTAX_BUKTI_ID_BILLING SBID
							LEFT JOIN SIMTAX_KODE_CABANG SKC ON SBID.KODE_CABANG = SKC.KODE_CABANG
							where SBID.KODE_CABANG = '".$kode_cabang."'
							".$where." ORDER BY ID DESC";

		$query = $this->db->query($mainQuery);
		return $query->num_rows();
	}

	function get_by_id($id){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_BUKTI_ID_BILLING'); 
		$this->db->where('ID', $id);
		$query = $this->db->get();

		return $query->row();
	}

	function get_last_id(){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_BUKTI_ID_BILLING'); 
		$this->db->order_by('ID', 'desc');
		$query = $this->db->get();

		return $query->row()->ID;
	}

	function add($data){

		$insert = $this->db->insert("SIMTAX_BUKTI_ID_BILLING", $data);
		simtax_update_history("SIMTAX_BUKTI_ID_BILLING", "CREATE");

		return true;
	}

	function update($data, $id){

		$this->db->where('ID', $id);
		$update = $this->db->update("SIMTAX_BUKTI_ID_BILLING", $data);
		simtax_update_history("SIMTAX_BUKTI_ID_BILLING", "UPDATE", $id);

		return true;
	}

	function delete($id){

		$this->db->where('ID', $id);
		$this->db->delete('SIMTAX_BUKTI_ID_BILLING');

		return true;
	}

}

/* End of file Billing_mdl.php */
/* Location: ./application/models/Billing_mdl.php */