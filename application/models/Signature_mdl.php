<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signature_mdl extends CI_Model {

	function get_all($kode_cabang, $start, $length, $draw, $keywords=""){

		$where	= "";
		if($keywords) {
			$q = strtoupper($keywords);
			$where	= " AND (upper(DOCUMENT_TYPE) like '%".$q."%'
								OR upper(NAMA_WP_PEMOTONG) like '%".$q."%'
								OR upper(NPWP_PEMOTONG) like '%".$q."%'
								OR upper(ALAMAT_WP_PEMOTONG) like '%".$q."%'
								OR upper(NAMA_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(JABATAN_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(TTD_CAP_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(NAMA_KPP) like '%".$q."%'
								OR upper(FILE_PENUGASAN) like '%".$q."%'
								OR upper(NAMA_PAJAK) like '%".$q."%'
								OR upper(URL_PENUGASAN) like '%".$q."%'
								OR upper(URL_TANDA_TANGAN) like '%".$q."%'
								OR upper(NAMA_CABANG) like '%".$q."%')";
		}

		$mainQuery = "SELECT SPP.*, SKC.NAMA_CABANG
							FROM SIMTAX_PEMOTONG_PAJAK SPP
							LEFT JOIN SIMTAX_KODE_CABANG SKC ON SPP.KODE_CABANG = SKC.KODE_CABANG
							WHERE SPP.KODE_CABANG = '".$kode_cabang."'
							 ".$where."
							ORDER BY ID DESC";

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
			$where	= " AND (upper(DOCUMENT_TYPE) like '%".$q."%'
								OR upper(NAMA_WP_PEMOTONG) like '%".$q."%'
								OR upper(NPWP_PEMOTONG) like '%".$q."%'
								OR upper(ALAMAT_WP_PEMOTONG) like '%".$q."%'
								OR upper(NAMA_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(JABATAN_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(TTD_CAP_PETUGAS_PENANDATANGAN) like '%".$q."%'
								OR upper(NAMA_KPP) like '%".$q."%'
								OR upper(FILE_PENUGASAN) like '%".$q."%'
								OR upper(NAMA_PAJAK) like '%".$q."%'
								OR upper(URL_PENUGASAN) like '%".$q."%'
								OR upper(URL_TANDA_TANGAN) like '%".$q."%'
								OR upper(NAMA_CABANG) like '%".$q."%')";
		}

		$mainQuery = "SELECT SPP.*, SKC.NAMA_CABANG
							FROM SIMTAX_PEMOTONG_PAJAK SPP
							LEFT JOIN SIMTAX_KODE_CABANG SKC ON SPP.KODE_CABANG = SKC.KODE_CABANG
							WHERE SPP.KODE_CABANG = '".$kode_cabang."'
							 ".$where."
							ORDER BY ID DESC";

		$query = $this->db->query($mainQuery);
		return $query->num_rows();
	}
	
	function get_by_id($id){
    	$this->db->select('*');
		$this->db->from('SIMTAX_PEMOTONG_PAJAK'); 
		$this->db->where('ID', $id); 
		$query = $this->db->get();

		return $query->row();    		
	}

	function get_last_id(){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_PEMOTONG_PAJAK'); 
		$this->db->order_by('ID', 'desc');
		$query = $this->db->get();

		return $query->row()->ID;
	}

	function add($data, $start_date="", $end_date=""){

		if($start_date !=""){
			$this->db->set('START_EFFECTIVE_DATE',"TO_DATE('".$start_date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($end_date !=""){
			$this->db->set('END_EFFECTIVE_DATE',"TO_DATE('".$end_date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}

		$insert = $this->db->insert("SIMTAX_PEMOTONG_PAJAK", $data);
		simtax_update_history("SIMTAX_PEMOTONG_PAJAK", "CREATE");

		return true;
	}

	function update($id, $data, $start_date="", $end_date=""){

		if($start_date !=""){
			$this->db->set('START_EFFECTIVE_DATE',"TO_DATE('".$start_date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($end_date !=""){
			$this->db->set('END_EFFECTIVE_DATE',"TO_DATE('".$end_date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}


		$this->db->where('ID', $id);
		$update = $this->db->update("SIMTAX_PEMOTONG_PAJAK", $data);
		simtax_update_history("SIMTAX_PEMOTONG_PAJAK", "UPDATE", $id);

		return true;
	}

	function delete($id){

		$this->db->where('ID', $id);
		$this->db->delete('SIMTAX_PEMOTONG_PAJAK');

		return true;
	}

}

/* End of file Signature_mdl.php */
/* Location: ./application/models/Signature_mdl.php */