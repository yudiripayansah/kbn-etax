<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Golongan_pajak_kini_mdl extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
		    
		$this->kode_cabang = $this->session->userdata('kd_cabang');

    }

    function get_gol_pajak_kini()
	{
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	.= " and upper(uraian) like '%".strtoupper($q)."%' ";
		}

		if(isset($_POST['_searchTahun']) && $_POST['_searchTahun'] != ""){
			$tahun = $_POST['_searchTahun'];
			$where	.= " and tahun = ".$tahun;
		}
		
		
		$queryExec = "SELECT						
						   a.GOL_PAJAK_KINI_ID,  
						   a.URAIAN , 
						   a.JUMLAH, 
						   a.BULAN,
						   a.TAHUN,
						   a.KODE_AKUN,
						   a.SPT,
						   a.JUMLAH_KOMERSIL,
						   a.KOREKSI_FISKAL,
						   b.DESCRIPTION  
					FROM   SIMTAX_GOLONGAN_PAJAK_KINI a
					LEFT JOIN SIMTAX_MASTER_COA b ON b.SEGMENT_VALUE = a.kode_akun
                    WHERE 1=1 ".$where."  order by GOL_PAJAK_KINI_ID ASC";	
        //print_r($queryExec);         
		$queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_GOLONGAN_PAJAK_KINI where 1=1 ".$where."  order by 1 desc";								
		
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
							'gol_pajak_kini_id'	=> $row['GOL_PAJAK_KINI_ID'], 
							'uraian'			=> $row['URAIAN'],
							'jumlah'			=> number_format($row['JUMLAH'],6,".",","),
							'bulan'	            => $row['BULAN'],
							'tahun'				=> $row['TAHUN'],
							'kode_akun'			=> $row['KODE_AKUN'],
							'spt'				=> $row['SPT'],
							'description'		=> $row['DESCRIPTION'],
							'jumlah_komersil'	=> $row['JUMLAH_KOMERSIL'],
							'koreksi_fiskal'	=> $row['KOREKSI_FISKAL']
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

	function check_duplicate_gol_pajakkini($uraian, $tahun, $bulan){

		$sql = "SELECT count(*) TOTAL from simtax_golongan_pajak_kini
						where uraian is not null and uraian = '".$uraian."'
						and tahun is not null and tahun = '".$tahun."'
						and bulan is not null and bulan = '".$bulan."'"
						;
		$query	= $this->db->query($sql);
		$total	= $query->row()->TOTAL;

		return $total;

	}

	function action_save_golongan_pajakkini()
	{
		$gol_pajak_kini_id	= $this->input->post('edit_gol_pajak_kini_id');
		$uraian				= $this->input->post('edit_uraian');
		$jumlah				= $this->input->post('edit_jumlah');
		$bulan		        = $this->input->post('edit_bulan');
		$tahun				= $this->input->post('edit_tahun');
		$kode_akun			= $this->input->post('inpAccount');
		$spt				= $this->input->post('edit_kode_spt');
		$jml_komersil		= $this->input->post('edit_jumlah_komersil');
		$koreksi_fiskal		= $this->input->post('edit_koreksi_fiskal');
		
		//flag
		$isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

		if ($isNewRecord=="1") {
		$sql	="insert into SIMTAX_GOLONGAN_PAJAK_KINI
				  ( GOL_PAJAK_KINI_ID,
                    URAIAN,
					JUMLAH,
					BULAN,
					TAHUN,
					KODE_AKUN,
					SPT,
					JUMLAH_KOMERSIL,
					KOREKSI_FISKAL
				  ) values (
                    SIMTAX_GOLONGAN_PAJAK_KINI_S.NEXTVAL, 
					'".$uraian."', 
					'".$jumlah."', 
					'".$bulan."', 
					'".$tahun."',
					'".$kode_akun."',
					'".$spt."',
					'".$jml_komersil."',
					'".$koreksi_fiskal."'
				  )"
					 ;	
			
		} else {
			$sql	="Update SIMTAX_GOLONGAN_PAJAK_KINI
						 set URAIAN='".$uraian."', 
                             JUMLAH='".$jumlah."',
							 BULAN='".$bulan."', 
							 TAHUN='".$tahun."',
							 KODE_AKUN='".$kode_akun."',
							 SPT='".$spt."',
							 JUMLAH_KOMERSIL='".$jml_komersil."',
							 KOREKSI_FISKAL='".$koreksi_fiskal."'
					   where GOL_PAJAK_KINI_ID ='".$gol_pajak_kini_id."'"
						 ;	
		}

		$query	= $this->db->query($sql);
		
		if ($query){

			if ($isNewRecord == "1") {
				simtax_update_history("SIMTAX_GOLONGAN_PAJAK_KINI", "CREATE", "GOL_PAJAK_KINI_ID");
			}
			else{
				$params = array(
									"GOL_PAJAK_KINI_ID"       => $gol_pajak_kini_id
								);
				simtax_update_history("SIMTAX_GOLONGAN_PAJAK_KINI", "UPDATE", $params);
			}

			return true;
		} else {
			return false;
		}
	}

	function action_delete()
	{
		$gol_pajak_kini_id			= $this->input->post('id');
		
		$sql	="delete from SIMTAX_GOLONGAN_PAJAK_KINI 
		                where GOL_PAJAK_KINI_ID = ".$gol_pajak_kini_id;	
						  
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}	
	}


}

?>