<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Beban_tantiem_mdl extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
		    
		$this->kode_cabang = $this->session->userdata('kd_cabang');

    }

    function get_beban_tantiem()
	{
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	.= " and upper(nama) like '%".strtoupper($q)."%' ";
		}

		if(isset($_POST['_searchDivisi']) && $_POST['_searchDivisi'] != ""){
			$kode_divisi = $_POST['_searchDivisi'];
			$where	.= " and upper(divisi) like '%".strtoupper($kode_divisi)."%'";
		}
		
		
		$queryExec = "SELECT						
						   BEBAN_TANTIEM_ID,  
						   NAMA , 
						   HARI, 
						   JUMLAH_TANTIEM,
						   PAJAK,
						   JUMLAH_DITERIMA ,
						   TAHUN,
						   DIVISI      
					FROM   SIMTAX_BEBAN_TANTIEM
                    WHERE 1=1 ".$where."  order by BEBAN_TANTIEM_ID desc";	
                  
		$queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_BEBAN_TANTIEM where 1=1 ".$where."  order by 1 desc";								
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		//start row count				
		$selectCount	= $this->db->query($queryCount);
		$row        	= $selectCount->row();       	
		$rowCount  	= $row->JML; 					  
		//end get row count

		$query = $this->db->query($sql);		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
							'no'				=> $row['RNUM'],				
							'beban_tantiem_id'	=> $row['BEBAN_TANTIEM_ID'], 
							'nama'				=> $row['NAMA'],
							'hari'				=> $row['HARI'],
							'jumlah_tantiem'	=> number_format($row['JUMLAH_TANTIEM'],2,".",","),
							'pajak'				=> number_format($row['PAJAK'],2,".",","),
							'jumlah_diterima'	=> number_format($row['JUMLAH_DITERIMA'],2,".",","),
							'tahun'			    => $row['TAHUN'],		   
							'divisi'			=> $row['DIVISI']

						  );
			}
			
			$query->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}		
		return $result;		
	}

	function check_duplicate_bbn_tantiem($nama, $tahun, $divisi){

		$sql = "SELECT count(*) TOTAL from simtax_beban_tantiem
						where nama is not null and nama = '".$nama."'
						and tahun is not null and tahun = '".$tahun."'
						and divisi is not null and divisi = '".$divisi."'"
						;
		$query	= $this->db->query($sql);
		$total	= $query->row()->TOTAL;

		return $total;

	}

	function action_save_bebantantiem()
	{
		$beban_tantiem_id	= $this->input->post('edit_beban_tantiem_id');
		$nama				= $this->input->post('edit_nama');
		$hari				= $this->input->post('edit_hari');
		$jumlah_tantiem		= $this->input->post('edit_jumlah_tantiem');
		$pajak				= $this->input->post('edit_pajak');
		$tahun				= $this->input->post('edit_tahun');
		$divisi				= $this->input->post('edit_divisi');
		
		//flag
		$isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

		if ($isNewRecord=="1") {
		$sql	="insert into SIMTAX_BEBAN_TANTIEM
				  ( BEBAN_TANTIEM_ID,
					NAMA,
					HARI,
					JUMLAH_TANTIEM,
					PAJAK,
					TAHUN,
					DIVISI
				  ) values (
 				    SIMTAX_BEBAN_TANTIEM_S.NEXTVAL, 
					'".$nama."', 
					'".$hari."', 
					'".$jumlah_tantiem."', 
					'".$pajak."', 
					'".$tahun."', 
					'".$divisi."'
				  )"
					 ;	
			
		} else {
			$sql	="Update SIMTAX_BEBAN_TANTIEM
						 set NAMA='".$nama."', 
						     HARI='".$hari."',
							 JUMLAH_TANTIEM='".$jumlah_tantiem."', 
							 PAJAK='".$pajak."', 
							 TAHUN='".$tahun."', 
							 DIVISI='".$divisi."'
					   where BEBAN_TANTIEM_ID ='".$beban_tantiem_id."'"
						 ;	
		}
		
		
		$query	= $this->db->query($sql);
		
		if ($query){

			if ($isNewRecord == "1") {
				simtax_update_history("SIMTAX_BEBAN_TANTIEM", "CREATE", "BEBAN_TANTIEM_ID");
			}
			else{
				$params = array(
									"BEBAN_TANTIEM_ID"       => $beban_tantiem_id
								);
				simtax_update_history("SIMTAX_BEBAN_TANTIEM", "UPDATE", $params);
			}

			return true;
		} else {
			return false;
		}
	}

	function action_delete()
	{
		$beban_tantiem_id			= $this->input->post('id');
		
		$sql	="delete from SIMTAX_BEBAN_TANTIEM 
		                where BEBAN_TANTIEM_ID = ".$beban_tantiem_id;	
						  
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}	
	}

	function get_cfg_tantiem()
	{
		$where ="";
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		if($q) {
			$where	= " and  nama like '%$q%' ";
		}
		
		$queryExec = "SELECT						
						   CONFIG_TANTIEM_ID,  
						   NAMA     
					FROM   SIMTAX_CONFIG_TANTIEM
					WHERE 1=1 ".$where;	
		$queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_CONFIG_TANTIEM where 1=1 ".$where;								
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		//start row count				
		$selectCount	= $this->db->query($queryCount);
		$row        	= $selectCount->row();       	
		$rowCount  	= $row->JML; 					  
		//end get row count
					
		$query = $this->db->query($sql);		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
							'no'		=> $row['RNUM'],				
							'config_tantiem_id'	=> $row['CONFIG_TANTIEM_ID'], 
							'nama'		=> $row['NAMA']
						  );
			}
			
			$query->free_result();
			
			$result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
			$result['recordsTotal']		= $rowCount;
			$result['recordsFiltered'] 	= $rowCount;
			
		} else {
			$result['data'] 			= "";
			$result['draw']				= "";
			$result['recordsTotal']		= 0;
			$result['recordsFiltered'] 	= 0;
		}		
		return $result;		
	}

	function check_duplic_config_tantiem($nama){

		$sql = "SELECT count(*) TOTAL from simtax_config_tantiem
						where nama is not null
						and nama = '".$nama."'";				
		$query	= $this->db->query($sql);
		$total	= $query->row()->TOTAL;

		return $total;

	}

	function action_save_config_tantiem()
	{
		$config_tantiem_id			= $this->input->post('edit_tantiem_id');
		$nama			= strtoupper($this->input->post('edit_nama'));

		//flag
		$isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

		if ($isNewRecord=="1") {
		$sql	="insert into SIMTAX_CONFIG_TANTIEM
				  ( CONFIG_TANTIEM_ID,
					NAMA
				  ) values (
 				    SIMTAX_CONFIG_TANTIEM_SEQ.NEXTVAL, 
					'".$nama."'
				  )"
					 ;	
			
		} else {
			$sql	="Update SIMTAX_CONFIG_TANTIEM
						 set NAMA='".$nama."'
					   where CONFIG_TANTIEM_ID ='".$config_tantiem_id."'"
						 ;	
		}
		
		$query	= $this->db->query($sql);
		
		if ($query){

			if ($isNewRecord == "1") {
				simtax_update_history("SIMTAX_CONFIG_TANTIEM", "CREATE", "CONFIG_TANTIEM_ID");
			}
			else{
				$params = array(
									"CONFIG_TANTIEM_ID"       => $config_tantiem_id
								);
				simtax_update_history("SIMTAX_CONFIG_TANTIEM", "UPDATE", $params);
			}

			return true;
		} else {
			return false;
		}
	}

	function action_delete_config_tantiem()
	{
		$tantiem_id			= $this->input->post('id');
		
		$sql	="delete from SIMTAX_CONFIG_TANTIEM
		                where CONFIG_TANTIEM_ID = ".$tantiem_id;	
		  
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}	
	}

	function get_all(){
		
    	$this->db->select('*');
		$this->db->from('SIMTAX_CONFIG_TANTIEM'); 
		//$this->db->where('AKTIF', 'Y');
		$query = $this->db->get();

		return $query->result_array();
	}

	function get_master_config_tantiem()
	{
		$queryExec	        = "Select nama from simtax_config_tantiem order by nama";
		$query 		        = $this->db->query($queryExec);
		$result['query']	= $query;
		return $result;		
	}


}

?>