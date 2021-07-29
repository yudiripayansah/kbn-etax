<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_mdl extends CI_Model {

	function get_all($start, $length, $keywords, $jenis_pajak){
		$where	= "";
		if($keywords) { 
			$where	= " WHERE upper(VENDOR_NAME) like '%".strtoupper($keywords)."%' or upper(ADDRESS_LINE1) like '%".strtoupper($keywords)."%' or  NPWP like '%".strtoupper($keywords)."%' ";
		}

		if($jenis_pajak == "PPN MASUKAN"){
			$queryExec	= "SELECT VENDOR_ID, VENDOR_NAME, ADDRESS_LINE1, NPWP FROM SIMTAX_MASTER_SUPPLIER ".$where." ORDER BY VENDOR_ID";

		}else{
			$queryExec	= "SELECT CUSTOMER_ID VENDOR_ID, CUSTOMER_NAME VENDOR_NAME, ADDRESS_LINE1, NPWP FROM SIMTAX_MASTER_PELANGGAN ".$where." ORDER BY CUSTOMER_ID";
		}
	
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <= ".$start." + ".$length."
					)
					WHERE rnum > ".$start;
		
		$sql2		= $queryExec;  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows();
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		return $result;	
	}

}

/* End of file Supplier_mdl.php */
/* Location: ./application/models/Supplier_mdl.php */