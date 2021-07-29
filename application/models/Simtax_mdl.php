<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simtax_mdl extends CI_Model {

	function get_max_header_id(){

		$this->db->select_max("PAJAK_HEADER_ID", 'MAX');
		$query = $this->db->get("SIMTAX_PAJAK_HEADERS");
		$pajak_header_id = $query->row()->MAX;

		return $pajak_header_id;

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

	function update_history($table, $params){

		$last_update_by = $this->session->userdata('identity');
		$whereCondition = "";

		if(is_array($params)){
			$arrKeys = array_keys($params);
			for ($i=0; $i < count($params); $i++) {
				$keys = $arrKeys[$i];
				if($i == 0){
					$whereAnd = " WHERE ";
				}
				else{
					$whereAnd = " AND ";
				}
				$whereCondition .= $whereAnd.$keys." = '".$params[$keys]."'";
			}
		}
		else{
			$whereCondition = "WHERE ID = ".$params;
		}

		$query_update   = "UPDATE ".$table." SET LAST_UPDATE_DATE = SYSDATE,
												 LAST_UPDATE_BY   = '".$last_update_by."'
												 ".$whereCondition;

		if($this->db->query($query_update)){
			return true;
		}
	}

	function create_history($table, $params=""){

		$created_by     = $this->session->userdata('identity');
		$whereCondition = "";
		
		if($params != ""){
			if(is_array($params)){
				$arrKeys = array_keys($params);
				for ($i=0; $i < count($params); $i++) {
					$keys = $arrKeys[$i];
					if($i == 0){
						$whereAnd = " WHERE ";
					}
					else{
						$whereAnd = " AND ";
					}
					$whereCondition .= $whereAnd.$keys." = '".$params[$keys]."'";
				}
			}
			else{
				$this->db->select_max($params, 'MAX');
				$query = $this->db->get($table);
				$id    = $query->row()->MAX;

				$whereCondition = "WHERE ".$params." = ".$id;
			}
		}
		else{
			$this->db->select_max('ID', 'MAX');
			$query = $this->db->get($table);
			$id    = $query->row()->MAX;

			$whereCondition = "WHERE ID = ".$id;
		}
		$query_update   = "UPDATE ".$table." SET CREATION_DATE = SYSDATE,
												 CREATED_BY   = '".$created_by."'
												 ".$whereCondition;
		if($this->db->query($query_update)){
			return true;
		}
	}

	function get_data_header($pajak_header_id){

    	$this->db->select('*');
		$this->db->from('SIMTAX_PAJAK_HEADERS');
		$this->db->where('PAJAK_HEADER_ID', $pajak_header_id);

		$query = $this->db->get();

		return $query->row();
		
	}

	function update_status($pajak_header_id, $status){

		$action_by  = $this->session->userdata('identity');
		$nama_pajak = $this->get_data_header($pajak_header_id);

		if($status == "SUBMIT"){
			$added = ", TGL_SUBMIT_SUP = SYSDATE, ";
		}
		elseif($status == ""){
			$added = ", TGL_SUBMIT_SUP = SYSDATE";
		}
		elseif($status == 3){
			$added = ", TGL_SUBMIT_SUP = SYSDATE";
		}
		else{
			$added = ", TGL_SUBMIT_SUP = SYSDATE";
		}
				
		$sql = "UPDATE SIMTAX_PAJAK_HEADERS
						SET STATUS = '".$status."',
						USER_NAME  = '".$action_by."'
						".$added."
						WHERE PAJAK_HEADER_ID = '".$pajak_header_id."'";

		$query	= $this->db->query($sql);
		
		$sql2	= "INSERT INTO SIMTAX_ACTION_HISTORY
					(PAJAK_HEADER_ID, JENIS_PAJAK, ACTION_DATE, ACTION_CODE, USER_NAME)
					VALUES (".$pajak_header_id.", '".$nama_pajak."' , SYSDATE, 'SUBMIT', '".$action_by."')";
		$query2	= $this->db->query($sql2);

		if ($query && $query2){
			return true;
		} else {
			return false;
		}
	}

	
}

/* End of file Simtax_mdl.php */
/* Location: ./application/models/Simtax_mdl.php */