<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Ppn_wapu_mdl extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$this->load->model('Master_mdl');
		$this->load->model('Ppn_wapu_mdl');

		$this->kode_cabang = $this->session->userdata('kd_cabang');
		    
    }

	function get_pajak_header_id($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan){

    	$this->db->select('*');
		$this->db->from('SIMTAX_PAJAK_HEADERS'); 
		$this->db->where('KODE_CABANG', $kode_cabang);
		$this->db->where('NAMA_PAJAK', $nama_pajak);
		$this->db->where('BULAN_PAJAK', $bulan_pajak);
		$this->db->where('TAHUN_PAJAK', $tahun_pajak);
		$this->db->where('PEMBETULAN_KE', $pembetulan);

		$query = $this->db->get();

		return $query->row();
	}

    public function tgl_db($date)
	{
		$part = explode("/",$date);
		$newDate = $part[2]."/".$part[1]."/".$part[0];
		return $newDate;
	}

	public function getMonth($bul)
	{
		$shortMonthArr 	= array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$date			= $shortMonthArr[$bul];
		return $date;
	}

	public function get_header_id($bulan="",$tahun="", $pembetulan=""){
		/*$cabang		=  $this->kode_cabang;
		$where_p 	= "";

		//if ($pembetulan){
			$where_p =" and pembetulan_ke=".$pembetulan;
		//}
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU'".$where_p ; 
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();*/
		
		$cabang		=  $this->kode_cabang;
		$where_p 	= "";
		if ($pembetulan){
			$where_p =" and pembetulan_ke=".$pembetulan;
		}
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU'".$where_p ; 
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	public function get_header_id_closing($cabang="",$bulan="",$tahun="", $pembetulan=""){
		/*$cabang		=  $this->kode_cabang;
		$where_p 	= "";

		//if ($pembetulan){
			$where_p =" and pembetulan_ke=".$pembetulan;
		//}
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU'".$where_p ; 
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();*/
		
		//$cabang		=  $this->kode_cabang;
		$where_p 	= "";
		if ($pembetulan){
			$where_p =" and pembetulan_ke=".$pembetulan;
		}
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU'".$where_p ; 
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	public function get_header_id_pusat($bulan="",$tahun="", $pembetulan="", $cabang=""){
		
		//$cabang		=  $this->kode_cabang;
		$where_p 	= "";
		if ($pembetulan){
			$where_p =" and pembetulan_ke=".$pembetulan;
		}
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU'".$where_p ; 
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	public function get_header_id_max($cabang,$masa,$tahun){
		//$cabang	=  $this->kode_cabang;
		$sql3 	= "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK='".$masa."' and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU' " ; 
		//print_r($sql3); die();
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}
	
	function get_rekonsiliasi()
	{
		$cabang	=  $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(spl.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(spl.NAMA_WP) like '%".strtoupper($q)."%' or upper(spl.INVOICE_NUM) like '%".strtoupper($q)."%' or upper(spl.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(spl.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(spl.DPP) like '%".strtoupper($q)."%' or upper(spl.NPWP) like '%".strtoupper($q)."%' or upper(spl.JUMLAH_POTONG) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		$queryExec	= " 
						SELECT DISTINCT SPL.*, 
						CASE
                        WHEN SPL.OU_NAME <>'KP0' and SUBSTR(SPL.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(SPL.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
                        ,abs(spl.dpp) jml_dpp
						--SMS.VENDOR_NAME, SMS.NPWP NPWP1, 
						--SMS.ADDRESS_LINE1,
						,NVL(SMS.VENDOR_NAME, SPL.NAMA_WP) VENDOR_NAME
                        ,NVL(SMS.NPWP,SPL.NPWP) NPWP1
                        ,NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(SPL.NO_FAKTUR_PAJAK,5,3) AS KD_CAB, SUBSTR(SPL.NO_FAKTUR_PAJAK,9,2) AS DGT_THN
						,SPH.PEMBETULAN_KE AS PEMBETULAN
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        --AND SPL.IS_CHEKLIST = '1'
                        AND SPH.KODE_CABANG ='".$cabang."' 
                        ".$where2.$where."
						order by SPL.INVOICE_NUM, SPL.INVOICE_LINE_NUM DESC";	
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	/*Awal Detail Rekonsiliasi================================================================================*/
	function get_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->kode_cabang;
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$tipe	    = $_POST['_searchTipe'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
		
		$where	= "";
		if($q) {
			$where	.= " and (upper(SMS.NPWP) like '%".strtoupper($q)."%' or upper(SMS.VENDOR_NAME) like '%".strtoupper($q)."%') ";
		}
		$where	.= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($tipe=="REKONSILIASI"){
			$where .=" AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')) ";
		} else if ($tipe=="APPROV"){
			$where .= "  and (SPH.status in ('SUBMIT','APPROVED BY PUSAT','REJECT BY PUSAT')) ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (SPH.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}
		
		$queryExec	= " SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tidak Dilaporkan' KETERANGAN
						, '1' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.IS_CHEKLIST =0
                        ".$where;						
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, '2' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;*/					
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Import CSV' KETERANGAN
						, '3' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;*/		
						
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC"; 			
			//print_r($queryExec); exit();
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	/*Awal Detail Rekonsiliasi================================================================================*/
	function get_detail_summary_pusat()
	{
		ini_set('memory_limit', '-1');
		//$cabang	    =  $this->kode_cabang;
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$tipe	    = $_POST['_searchTipe'] ;
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
		
		$where	= "";
		if($q) {
			$where	.= " and (upper(SMS.NPWP) like '%".strtoupper($q)."%' or upper(SMS.VENDOR_NAME) like '%".strtoupper($q)."%') ";
		}
		$where	.= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' and SPL.kode_cabang = '".$_POST['_searchCabang']."' ";
		
		if($tipe=="REKONSILIASI"){
			$where .=" AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR','REJECT BY PUSAT')) ";
		} else if ($tipe=="APPROV"){
			$where .= "  and (SPH.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT')) ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (SPH.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}
		
		$queryExec	= " SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tidak Dilaporkan' KETERANGAN
						, '1' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.IS_CHEKLIST =0
                        ".$where;						
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, '2' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;*/					
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Import CSV' KETERANGAN
						, '3' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;*/		
						
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC"; 			
			//print_r($queryExec); exit();
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function get_detail_summary_kompilasi()
	{
		ini_set('memory_limit', '-1');
		//$cabang	    =  $this->kode_cabang;
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		//$tipe	    = $_POST['_searchTipe'] ;
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
		
		$where	= "";
		$where .= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and upper(SPH.nama_pajak) = '".$_POST['_searchPph']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($q) {
			$where .= " and (upper(SMS.npwp) like '%".strtoupper($q)."%' or upper(SMS.vendor_name) like '%".strtoupper($q)."%') ";
		}
		
		if($cabang || $cabang !="") {
			$where .= " and SPH.kode_cabang='".$cabang."' ";
		}
		
		$queryExec	= " SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						, SKC.NAMA_CABANG
						, SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tidak Dilaporkan' KETERANGAN
						, '1' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_KODE_CABANG SKC ON SPH.KODE_CABANG = SKC.KODE_CABANG                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND SPH.STATUS IN ('APPROVED BY PUSAT')
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        --AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.IS_CHEKLIST =0
                        ".$where;						
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						, SKC.NAMA_CABANG
						, SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, '2' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_KODE_CABANG SKC ON SPH.KODE_CABANG = SKC.KODE_CABANG                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        --AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;*/					
						
		/*$queryExec	.= " UNION ALL
						SELECT 
						  NVL(SPL.NEW_DPP, SPL.DPP) DPP
						, NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG) JUMLAH_POTONG
						, SKC.NAMA_CABANG
						,SMS.VENDOR_NAME
						, SMS.NPWP NPWP1
						, SMS.ADDRESS_LINE1
						, SPL.NO_FAKTUR_PAJAK
						, SPL.TANGGAL_FAKTUR_PAJAK
						, SPL.INVOICE_NUM
						, SPL.INVOICE_LINE_NUM
						, 'Import CSV' KETERANGAN
						, '3' urut
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_KODE_CABANG SKC ON SPH.KODE_CABANG = SKC.KODE_CABANG                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        --AND SPH.KODE_CABANG ='".$cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;*/		
						
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC"; 			
			//print_r($queryExec); exit();
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	function get_total_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->kode_cabang;		
		$tipe	    = $_POST['_searchTipe'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
		$where	= "";
		/* if($q) {
			$where	.= " and (upper(SMS.NPWP) like '%".strtoupper($q)."%' or upper(SMS.VENDOR_NAME) like '%".strtoupper($q)."%') ";
		} */
		$where	.= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($tipe=="REKONSILIASI"){
			$where .=" AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')) ";
		}
		else if ($tipe=="APPROV"){
			$where .= "  and (SPH.status in ('SUBMIT','APPROVED BY PUSAT','REJECT BY PUSAT')) ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (SPH.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}
		
		$queryExec	= " SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG						
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.IS_CHEKLIST =0
                        ".$where;					
						
		$queryExec	.= " UNION ALL
						SELECT 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;
						
		$queryExec	.= " UNION ALL
						SELECT 'Import CSV' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 		
		
		$query 		= $this->db->query($queryExec);			
		return $query;			
	}
	
	/*Akhir Detail Rekonsiliasi================================================================================*/
	
	function get_total_detail_summary_pusat()
	{
		ini_set('memory_limit', '-1');
		//$cabang	    =  $this->kode_cabang;		
		$tipe	    = $_POST['_searchTipe'] ;
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
		$where	= "";
		/* if($q) {
			$where	.= " and (upper(SMS.NPWP) like '%".strtoupper($q)."%' or upper(SMS.VENDOR_NAME) like '%".strtoupper($q)."%') ";
		} */
		$where	.= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($tipe=="REKONSILIASI"){
			$where .=" AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR','REJECT BY PUSAT')) ";
		}
		else if ($tipe=="APPROV"){
			$where .= "  and (SPH.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT')) ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (SPH.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}
		
		$queryExec	= " SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG						
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.IS_CHEKLIST =0
                        ".$where;					
						
		$queryExec	.= " UNION ALL
						SELECT 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;
						
		$queryExec	.= " UNION ALL
						SELECT 'Import CSV' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        AND SPH.KODE_CABANG ='".$cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 		
		
		$query 		= $this->db->query($queryExec);			
		return $query;			
	}

	function get_total_detail_summary_kompilasi($bulan, $tahun, $pajak, $pembetulan,$cabang)
	{
		ini_set('memory_limit', '-1');
		$tgl_akhir	= $this->Master_mdl->getEndMonth($tahun,$bulan);
		$where	= "";
		$where .= " and SPH.bulan_pajak = '".$bulan."' and SPH.tahun_pajak = '".$tahun."' and SPH.pembetulan_ke = '".$pembetulan."' ";
		$where .= " and SPH.kode_cabang='".$cabang."' ";
		
		$queryExec	= " SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
						AND SPL.IS_CHEKLIST =1
                        ".$where;					
						
		$queryExec	.= " UNION ALL
						SELECT 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$_POST['_searchTahun']."/".$_POST['_searchBulan']."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;
						
		$queryExec	.= " UNION ALL
						SELECT 'Import CSV' KETERANGAN
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 	
							/* print_r($queryExec);
							die();	 */
		
		$query 		= $this->db->query($queryExec);
		$result['queryExec']	= $query;			
		return $result;		
	}

	function get_detail_summary_kompilasi_cabang()
	{
		ini_set('memory_limit', '-1');	
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);		
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($q) {
			$where .= " and (upper(d.nama_cabang) like '%".strtoupper($q)."%') ";
		}
		
		if($cabang || $cabang !="") {
			$where .= " and b.kode_cabang='".$cabang."' ";
		}
		
		$queryExec	= "Select d.kode_cabang
						, d.nama_cabang
						, sum(nvl(a.new_jumlah_potong, a.jumlah_potong)) jumlah_potong	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join simtax_kode_cabang d
							on b.kode_cabang=d.kode_cabang
						left join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						--and upper(d.status) ='CLOSE'
						".$where."
						group by d.kode_cabang, d.nama_cabang ";						
			
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by d.kode_cabang "; 			
			
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function get_koreksi()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(c.NAMA_WP) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and a.bulan_pajak = '".$_POST['_searchBulan']."' and a.tahun_pajak = '".$_POST['_searchTahun']."' and a.akun_pajak = '".$_POST['_searchPph']."' ";
			
		$queryExec	= "select a.*, c.vendor_name, c.npwp npwp1, c.address_line1,b.pembetulan 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID
						where b.status='DRAFT' and a.kode_cabang='".$cabang."'
						".$where2.$where."
						order by a.pajak_line_id DESC";	//where nnti di ganti rejected
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;				
	}

	function get_approv()
	{
		/*$kode_cabang = '010';
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(NO_BUKTI_POTONG) like '%".strtoupper($q)."%' or upper(NAMA_WP) like '%".strtoupper($q)."%' or  upper(NPWP) like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "		
					select spl.* 
					  from simtax_pajak_lines spl
						 , simtax_pajak_headers sph
					 where sph.pajak_header_id = spl.pajak_header_id
					   and sph.kode_cabang='".$kode_cabang."' 
					   and sph.BULAN_PAJAK=".$_POST['_searchBulan']."
					   and sph.tahun_pajak='".$_POST['_searchTahun']."'
					   and sph.status = 'SUBMIT'
					   and upper(sph.nama_pajak)='PPN WAPU'".$where." order by VENDOR_ID";		
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query = $this->db->query($sql);		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;*/

		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= "and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(a.NAMA_WP) like '%".strtoupper($q)."%'or upper(a.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(a.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(a.DPP) like '%".strtoupper($q)."%' or upper(a.NPWP) like '%".strtoupper($q)."%' or upper(a.JUMLAH_POTONG) like '%".strtoupper($q)."%')";
		}
		$where2	= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and b.nama_pajak = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		/*$queryExec	= "
						Select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID       
                        where b.kode_cabang='".$cabang."' and (upper(b.status) in ('SUBMIT','APPROVAL SUPERVISOR','REJECT BY PUSAT')) 
                        and upper(d.STATUS) ='OPEN'
                        and a.nama_pajak = 'PPN WAPU'
                        and a.is_cheklist = 1
                        ".$where2.$where."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC";*/

			$queryExec	= "SELECT * from  
                        (Select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID       
                        where b.kode_cabang='".$cabang."' and (upper(b.status) in ('SUBMIT','REJECT BY PUSAT')) 
                        and upper(d.STATUS) ='OPEN'
                        and a.nama_pajak = 'PPN WAPU'
                        and a.is_cheklist = 1
                        ".$where2.$where."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";


						/*Select DISTINCT a.*, c.vendor_name, c.npwp npwp1, c.address_line1 
                        from SIMTAX_PAJAK_LINES a 
                        inner join SIMTAX_PAJAK_HEADERS b                        
                        on a.pajak_header_id=b.pajak_header_id
                        inner join SIMTAX_MASTER_PERIOD d
                        on b.PERIOD_ID=d.PERIOD_ID
                        inner join SIMTAX_MASTER_SUPPLIER c
                        on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID        
                        where b.kode_cabang='".$cabang."' and (upper(b.status) in ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR')) 
                        and upper(d.STATUS) ='OPEN'
                        and a.nama_pajak = 'PPN WAPU'
                        and a.is_cheklist = 1
                        ".$where2.$where."
						order by a.pajak_line_id DESC";*/	
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}

	function action_save_rekonsiliasi()
	{
		$cabang				= $this->kode_cabang;
		$user				= $this->session->userdata('identity');
		//$idPajakHeader      = $this->input->post('idPajakHeader');
		$idPajakLines       = $this->input->post('idPajakLines');
		$id		            = $this->input->post('idwp');
		$isNewRecord        = $this->input->post('isNewRecord');
		$namawp	            = $this->input->post('namawp');
		$kodepajak	        = $this->input->post('kodepajak');
		$npwp	            = $this->input->post('npwp');
		$dpp	            = $this->input->post('dpp');
		$alamat	            = $this->input->post('alamat');
		$tarif	            = $this->input->post('tarif');
		$jumlahpotong	    = $this->input->post('jumlahpotong');
		$invoicenumber	    = $this->input->post('invoicenumber');
		$nofakturpajak	    = $this->input->post('nofakturpajak');
		$digitthn	    	= $this->input->post('digitthn');
		$jlhppn	    		= str_replace(',','',$this->input->post('jlhppn'));
		$jlhppnbm	    	= str_replace(',','',$this->input->post('jlhpbm'));		
		$tanggalfakturpajak	= ($this->input->post('tanggalfakturpajak'))?$this->tgl_db($this->input->post('tanggalfakturpajak')):'';
		$tglsetorppn		= ($this->input->post('tglsetorppn'))?$this->tgl_db($this->input->post('tglsetorppn')):'';
		$tglsetorppnbm		= ($this->input->post('tglsetorppnbm'))?$this->tgl_db($this->input->post('tglsetorppnbm')):'';
		$tgltagih			= ($this->input->post('tgltagih'))?$this->tgl_db($this->input->post('tgltagih')):'';
		$newkodepajak	    = $this->input->post('newkodepajak');
		$newtarif	        = $this->input->post('newtarif');
		$newdpp	            = str_replace(',','',$this->input->post('newdpp'));
		$newjumlahpotong	= str_replace(',','',$this->input->post('newjumlahpotong'));
		$nobupot			= $this->input->post('nobupot');
		$glaccount			= $this->input->post('glaccount');
		$fAkun				= $this->input->post('fAkun');
		$fNamaAkun			= $this->input->post('fNamaAkun');
		$fBulan				= $this->input->post('fBulan');
		$fTahun				= $this->input->post('fTahun');
		
		$addAkun			= $this->input->post('fAddAkun');
		$addNamaAkun		= $this->input->post('fAddNamaAkun');
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		$organization_id	= $this->input->post('organization_id');
		$vendor_site_id		= $this->input->post('vendor_site_id');
		$kdlampiran			= $this->input->post('kdlampiran');
		$kdtransaksi		= $this->input->post('kdtransaksi');
		$kdstatus			= $this->input->post('kdstatus');
		$kddokumen			= $this->input->post('kddokumen');
		$pembetulan_ke		= $this->input->post('fAddPembetulan');
		$matauang			= $this->input->post('matauang');
		
		$masa_pajak			= $this->getMonth($addBulan);
		$date				= date("Y-m-d H:i:s");
		
		if($isNewRecord){		
			
			$header	= $this->get_header_id($addBulan,$addTahun,$pembetulan_ke);
			
			if($header) {
				$sql	="insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,KODE_PAJAK,NPWP,NAMA_WP,ALAMAT_WP,DPP,TARIF,INVOICE_NUM,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,NEW_KODE_PAJAK,NEW_DPP,NEW_TARIF,NEW_JUMLAH_POTONG,KODE_CABANG,USER_NAME,CREATION_DATE,NAMA_PAJAK,VENDOR_ID,NO_BUKTI_POTONG,GL_ACCOUNT,ORGANIZATION_ID,DIGIT_TAHUN,TGL_SETOR_SSP,TGL_SETOR_PPNBM,TGL_TAGIH,JUMLAH_POTONG,JUMLAH_PPNBM, KODE_LAMPIRAN, KODE_TRANSAKSI, KODE_STATUS, KODE_DOKUMEN, VENDOR_SITE_ID, INVOICE_CURRENCY_CODE) 
				VALUES
				('".$header."','".$masa_pajak."','".$addBulan."','".$addTahun."','".$kodepajak."','".$npwp."','".$namawp."','".$alamat."','".$dpp."','".$tarif."','".$invoicenumber."','".$nofakturpajak."',TO_DATE('".$tanggalfakturpajak."','yyyy-mm-dd hh24:mi:ss'),'".$newkodepajak."','".$newdpp."','".$newtarif."','".$newjumlahpotong."','".$cabang."','".$user."',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'PPN WAPU','".$id."','".$nobupot."','".$glaccount."','".$organization_id."','".$digitthn."',TO_DATE('".$tglsetorppn."','yyyy-mm-dd hh24:mi:ss'),TO_DATE('".$tglsetorppnbm."','yyyy-mm-dd hh24:mi:ss'),TO_DATE('".$tgltagih."','yyyy-mm-dd hh24:mi:ss'),'".$jlhppn."','".$jlhppnbm."','".$kdlampiran."','".$kdtransaksi."','".$kdstatus."','".$kddokumen."','".$vendor_site_id."','".$matauang."')";
			}
		} else {			
			  $sql	="Update SIMTAX_PAJAK_LINES set VENDOR_ID='".$id."',VENDOR_SITE_ID='".$vendor_site_id."', ORGANIZATION_ID='".$organization_id."', LAST_UPDATE_DATE=TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'), USER_NAME='".$user."', NO_FAKTUR_PAJAK='".$nofakturpajak."',DIGIT_TAHUN='".$digitthn."',TANGGAL_FAKTUR_PAJAK=TO_DATE('".$tanggalfakturpajak."','yyyy-mm-dd hh24:mi:ss'),TGL_SETOR_SSP=TO_DATE('".$tglsetorppn."','yyyy-mm-dd hh24:mi:ss'),TGL_SETOR_PPNBM=TO_DATE('".$tglsetorppnbm."','yyyy-mm-dd hh24:mi:ss'),TGL_TAGIH=TO_DATE('".$tgltagih."','yyyy-mm-dd hh24:mi:ss'),JUMLAH_PPN='".$jlhppn."',JUMLAH_PPNBM='".$jlhppnbm."',KODE_TRANSAKSI='".$kdtransaksi."',KODE_DOKUMEN='".$kddokumen."',KODE_LAMPIRAN='".$kdlampiran."',KODE_STATUS='".$kdstatus."',INVOICE_CURRENCY_CODE='".$matauang."',DPP='".$dpp."',JUMLAH_POTONG='".$jlhppn."'
			  where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."' ";
		}
		//return $sql;
		$query	= $this->db->query($sql);		
		if ($query){
			if($isNewRecord){
				simtax_update_history("SIMTAX_PAJAK_LINES", "CREATE", "PAJAK_LINE_ID");
			}
			else{
				$params = array("PAJAK_LINE_ID" => $idPajakLines);
				simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $params);
			}
			return true;
		} else {
			return false;
		}
		
	}

	function action_delete_rekonsiliasi()
	{
		$idPajakLines   = $this->input->post('idPajakLines');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='".$idPajakLines."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}

	function action_save_koreksi()
	{
		$id		        = $this->input->post('idbuktipotong');
		$namawp	        = $this->input->post('namawp');
		$npwp	        = $this->input->post('npwp');
		$alamat	        = $this->input->post('alamat');
		$kodepajak	    = $this->input->post('kodepajak');
		$dpp	        = $this->input->post('dpp');
		$tarif	        = $this->input->post('tarif');
		$jumlahpotong	= $this->input->post('jumlahpotong');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="Update SIMTAX_PAJAK_LINES set NAMA_WP='".$namawp."', ALAMAT_WP='".$alamat."', NPWP='".$npwp."',
				  NEW_KODE_PAJAK='".$kodepajak."', NEW_DPP='".$dpp."', NEW_TARIF='".$tarif."', NEW_JUMLAH_POTONG='".$jumlahpotong."'
				  where PAJAK_LINE_ID ='".$id."' and KODE_CABANG='000' and BULAN_PAJAK=2 and tahun_pajak='2017' and upper(nama_pajak)='PPH PSL 23' ";
		$query	= $this->db->query($sql);		
		if ($query){
			simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", "PAJAK_LINE_ID");
			return true;
		} else {
			return false;
		}
		
	}

	function action_delete_koreksi()
	{
		$id		        = $this->input->post('idbuktipotong');		
		$date			= date('Y-m-d H:i:s');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='".$id."' and KODE_CABANG='000' and BULAN_PAJAK=2 and tahun_pajak='2017' and upper(nama_pajak)='PPH PSL 23' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}

	function action_save_approv()
	{
		$cabang	=  $this->kode_cabang;
		$user	= $this->session->userdata('identity');
		//$pasal	= $this->input->post('pasal');
		$masa	= $this->input->post('masa');
		$tahun	= $this->input->post('tahun');
		$st		= $this->input->post('st');
		$ket	= $this->input->post('ket');
		$pembetulan	= $this->input->post('pembetulan'); 		
		$date	= date("Y-m-d H:i:s");
		$header	= $this->get_header_id($masa,$tahun,$pembetulan);
		
		if($st==1){
			$status	="APPROVAL SUPERVISOR";			
		} else {
			$status	="REJECT SUPERVISOR";		
		}		
       	
		if ($header){
			$sql	="Update SIMTAX_PAJAK_HEADERS set TGL_APPROVE_SUP=TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'), 
					  status='".$status."', USER_NAME = '".$user."'
					  where PAJAK_HEADER_ID='".$header."' and KODE_CABANG='".$cabang."'";		
			$query	= $this->db->query($sql);
			
			$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME, CATATAN) 
					 values (".$header.",'PPN WAPU',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'".$status."','".$user."','".$ket."')";
			$query2	= $this->db->query($sql2);			
			if ($query && $query2){
				$params = array("PAJAK_HEADER_ID" => $header);
				$params2 = array("PAJAK_HEADER_ID" => $header, "ACTION_CODE" => $status, "CATATAN" => $ket);
				simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
				simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);
				return true;
			} else {
				return false;
			}		
		}
		
	}

	function action_get_start()
	{
		$cabang	=  $this->kode_cabang;
		//$pasal	= $this->input->post('pasal');
		$masa	= $this->input->post('masa');
		$tahun	= $this->input->post('tahun');
		$st		= $this->input->post('st');
		$ket	= $this->input->post('ket');
		$pembetulan	= $this->input->post('pembetulan'); 		
		$date	= date("Y-m-d H:i:s");		
		
		$sql3 = "Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id
				 inner join simtax_pajak_lines c
				 on a.pajak_header_id=c.pajak_header_id
				 where a.kode_cabang='".$cabang."' and a.bulan_pajak=".$masa." and a.tahun_pajak='".$tahun."' and upper(a.nama_pajak)='PPN WAPU' and a.pembetulan_ke=".$pembetulan ;

		$query3 = $this->db->query($sql3);   
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}

	function action_get_start_pusat()
	{
		//$cabang	=  $this->kode_cabang;
		//$pasal	= $this->input->post('pasal');
		$masa	= $this->input->post('masa');
		$cabang	= $this->input->post('cabang');
		$tahun	= $this->input->post('tahun');
		$st		= $this->input->post('st');
		$ket	= $this->input->post('ket');
		$pembetulan	= $this->input->post('pembetulan'); 		
		$date	= date("Y-m-d H:i:s");		
		
		$sql3 = "Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id
				 inner join simtax_pajak_lines c
				 on a.pajak_header_id=c.pajak_header_id
				 where a.kode_cabang='".$cabang."' and a.bulan_pajak=".$masa." and a.tahun_pajak='".$tahun."' and upper(a.nama_pajak)='PPN WAPU' and a.pembetulan_ke=".$pembetulan ;

				 /*Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id 
				 where a.kode_cabang='".$cabang."' and a.bulan_pajak=".$masa." and a.tahun_pajak='".$tahun."' and upper(a.nama_pajak)='PPN WAPU' and a.pembetulan_ke=".$pembetulan ;*/
		$query3 = $this->db->query($sql3);   
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}

	function get_closing()
	{
		//$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(a.MASA_PAJAK) like '%".strtoupper($q)."%' or upper(a.TAHUN_PAJAK) like '%".strtoupper($q)."%' or  upper(a.STATUS) like '%".strtoupper($q)."%') ";
		}
		
		$where2	= " and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' and b.kode_cabang = '".$_POST['_searchCabang']."' ";
		
		$queryExec	= "select a.* from simtax_master_period a
					   inner join simtax_pajak_headers b
					   on a.period_id=b.period_id
					   where b.nama_pajak = 'PPN WAPU'
					   ".$where2.$where."
					   and b.status in ('APPROVED BY PUSAT', 'CLOSE')
						order by a.tahun_pajak, a.bulan_pajak desc";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}

	function action_save_closing()
	{
		//$cabang	= $this->kode_cabang;
		$cabang	= $this->input->post('cabang');
		$user	= $this->session->userdata('identity');
		$status	= $this->input->post('status');
		//$nama	= $this->input->post('nama');
		$bulan	= $this->input->post('bulan');
		$tahun	= $this->input->post('tahun');
		$date	= date('Y-m-d H:i:s');
		$pembetulan	= $this->input->post('pembetulan');		
		$header	= $this->get_header_id_closing($cabang,$bulan,$tahun,$pembetulan);

		$sqlCek		="Select pajak_header_id, status from simtax_pajak_headers where pajak_header_id=".$header;
		$queryCek	= $this->db->query($sqlCek);
		$row		= $queryCek->row();
		$statusHeader 	= $row->STATUS;
		
	if (strtoupper($statusHeader)=="APPROVED BY PUSAT") {
		if($header && $status=="Open"){
			$sql	="Update SIMTAX_MASTER_PERIOD set STATUS='Close'
					  where KODE_CABANG='".$cabang."' and BULAN_PAJAK=".$bulan." and TAHUN_PAJAK='".$tahun."' and upper(NAMA_PAJAK)='PPN WAPU' ";
			$query	= $this->db->query($sql);
			
			$sql4	="Update SIMTAX_PAJAK_HEADERS set STATUS='CLOSE'
					  where PAJAK_HEADER_ID=".$header;

			$query4	= $this->db->query($sql4);
			
			if ($query && $query4){
				$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (".$header.",'PPN WAPU',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'Close','".$user."')";
				$query2	= $this->db->query($sql2);
				if($query2){
					$params = array("PAJAK_HEADER_ID" => $header, "ACTION_CODE" => 'Close');
					simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params);
					return true;
				} else {
					return false;
				}			
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
			return false;
		}
		
	}

	function get_download()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(a.nama_wp) like '%".strtoupper($q)."%' or upper(a.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(a.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(a.DPP) like '%".strtoupper($q)."%' or upper(a.NPWP) like '%".strtoupper($q)."%' or upper(a.JUMLAH_POTONG) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		/*$queryExec	= "
						Select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN
						from SIMTAX_PAJAK_LINES a 
						INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        and c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID	
						where a.kode_cabang='".$cabang."' and upper(b.status) in ('APPROVAL SUPERVISOR','APPROVED BY PUSAT','REJECT BY PUSAT') and a.IS_CHEKLIST='1' 
						".$where2.$where."
						order by a.INVOICE_NUM, INVOICE_LINE_NUM DESC";*/

			$queryExec	= "SELECT * from  
                        (select  DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						from SIMTAX_PAJAK_LINES a 
						INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        and c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID         
						where a.kode_cabang='".$cabang."' and upper(b.status) in ('APPROVAL SUPERVISOR','APPROVED BY PUSAT','REJECT BY PUSAT') and a.IS_CHEKLIST='1' 
						".$where2.$where."
				        order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";


		/*Select DISTINCT a.*, c.vendor_name, c.npwp npwp1, c.address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						where a.kode_cabang='".$cabang."' and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR') and a.IS_CHEKLIST='1' 
						".$where2.$where."
						order by a.pajak_line_id DESC";*/	
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}

	function get_format_csv()
	{
		$cabang	= $this->kode_cabang;
		$pajak  = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  = $_REQUEST['month'];
        $tahun  = $_REQUEST['year'];
        $pembetulan  = $_REQUEST['ke'];		
		
			
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' ";		
		$sql = "
						SELECT * FROM (SELECT DISTINCT a.*
						,CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
                        , CASE
                        WHEN a.KODE_DOKUMEN = 1 THEN substr(a.no_faktur_pajak,12,19)
                        END AS BAYAR
                        , SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB
						, SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN
						--,c.VENDOR_NAME, c.NPWP NPWP1, c.ADDRESS_LINE1
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						, substr(a.no_faktur_pajak,12,19)no_faktur
						,b.PEMBETULAN_KE AS PEMBETULAN,
						ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn 
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        and c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID
                        AND (UPPER(b.STATUS) NOT IN ('DRAFT','REJECT SUPERVISOR'))
                        --AND UPPER(d.STATUS) = 'OPEN'
                        AND b.NAMA_PAJAK = 'PPN WAPU'
                        AND b.KODE_CABANG ='".$cabang."'
                        AND a.IS_CHEKLIST = '1' 
                        ".$where2."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";
						
		$query = $this->db->query($sql);
		return $query;
	}

	function get_master()
	{
		$q           = (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where       = "";
		$whereSearch = "";
		if($q) { 
			$whereSearch = " and upper(VENDOR_NAME) like '%".strtoupper($q)."%' or upper(ADDRESS_LINE1) like '%".strtoupper($q)."%' or  NPWP like '%".strtoupper($q)."%' ";
		}

		$og_id = get_og_id($this->kode_cabang);

		$where = " where organization_id = '".$og_id."'";
	
		$queryExec	= "select * from simtax_master_supplier ".$where.$whereSearch." order by VENDOR_ID";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}

	function get_master_kode_pajak()
	{
		$jnspajak	= rawurldecode($this->uri->segment(3));
		$q			= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where		= "";
		if($q) { 
			$where	= " and (upper(tax_code) like '%".strtoupper($q)."%' or upper(tax_rate) like '%".strtoupper($q)."%' or upper(description) like '%".strtoupper($q)."%') ";
		}		
	
		$queryExec	= "Select * from simtax_master_pph ".$where." order by tax_code";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}
	
	function do_submit_to_apprv()
	{	
		$user_name = 'ADMIN';
		
		$sql	="UPDATE simtax_pajak_headers
				   set TGL_SUBMIT_SUP = sysdate
				     , STATUS = 'SUBMIT'  
				 where pajak_header_id = ".$_POST['p_pajak_header_id'];
		$query	= $this->db->query($sql);

		
		if ($query){
			$sql2	="INSERT into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
					 values (".$_POST['p_pajak_header_id'].",'PPN WAPU',sysdate,'SUBMIT','".$user_name."')";
	
			$query2	= $this->db->query($sql2);

			$params = array("PAJAK_HEADER_ID" => $_POST['p_pajak_header_id']);
			$params2 = array("PAJAK_HEADER_ID" => $_POST['p_pajak_header_id'], "ACTION_CODE" => 'SUBMIT');

			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
			simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);

			return true;
		} else {
			return false;
		}			
	}

	function action_submit_rekonsiliasi()
	{
		$cabang				= $this->kode_cabang;
		$user				= $this->session->userdata('identity');
		//$addAkun			= $this->input->post('fAddAkun');
		$addNamaAkun		= $this->input->post('fAddNamaAkun');
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		$pembetulan			= $this->input->post('fAddPembetulan');
		$date				= date('Y-m-d H:i:s');
		$header				= $this->get_header_id($addBulan,$addTahun,$pembetulan);			
		
		if($header) {
			$sql	="UPDATE SIMTAX_PAJAK_HEADERS set STATUS='SUBMIT', TGL_SUBMIT_SUP = sysdate, USER_NAME = '".$user."' where PAJAK_HEADER_ID ='".$header."' and KODE_CABANG='".$cabang."'";
			$query	= $this->db->query($sql);	
			if ($query){	
				$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (".$header.",'PPN WAPU',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'SUBMIT','".$user."')";
				$query2	= $this->db->query($sql2);
				if($query2){
					$params = array("PAJAK_HEADER_ID" => $header);
					$params2 = array("PAJAK_HEADER_ID" => $header, "ACTION_CODE" => 'SUBMIT');
					simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
					simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);
					return true;
				} else {
					return false;
				}			
			} else {
				return false;
			}
		}		
	}

	function action_check_rekonsiliasi()
	{
		$cabang			= $this->kode_cabang;
		$idPajakLines  	= $this->input->post('line_id');
		$ischeck	   	= $this->input->post('ischeck');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST=".$ischeck." where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."'";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}		
	}

	/*function add_csv($data)
	{
		$dpp 	= (!$data['dpp'] || $data['dpp']=='' )?0:$data['dpp'];
		$tarif 	= (!$data['tarif'] || $data['tarif']=='' )?0:$data['tarif'];
		
		if ($data['id_lines']!="PAJAK_LINE_ID") {		
			$sql	= "update ".'"'."SIMTAX_PAJAK_LINES".'"'." set 
						NAMA_WP='".$data['nama']."', NPWP='".$data['npwp']."', ALAMAT_WP='".$data['alamat']."',
						NEW_KODE_PAJAK='".$data['kode_pajak']."', NEW_DPP='".$dpp."', NEW_TARIF='".$tarif."'
						where PAJAK_LINE_ID='".$data['id_lines']."' ";	
			$query = $this->db->query($sql);
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}*/

	function add_csv($kode_lampiran, $kode_transaksi, $kode_status, $kode_dokumen, $digit_tahun, $no_faktur_pajak, $tgl_faktur, $tgl_tagih, $tgl_setor_ppn, $tgl_setor_ppnbm, $pajak_header_id, $id_lines, $npwp, $nama_wp, $jumlah_potong, $dpp, $invoice_num)
	{
		//$header	= $this->get_header_id($addBulan,$addTahun,$pembetulan_ke);
		$date			= date('Y-m-d H:i:s');
		
		$sql	="UPDATE SIMTAX_PAJAK_LINES set KODE_LAMPIRAN = '".$kode_lampiran."', KODE_TRANSAKSI = '".$kode_transaksi."', KODE_STATUS = '".$kode_status."', KODE_DOKUMEN = '".$kode_dokumen."', DIGIT_TAHUN = '".$digit_tahun."', NO_FAKTUR_PAJAK = '".$no_faktur_pajak."', TANGGAL_FAKTUR_PAJAK = TO_DATE('".$tgl_faktur."','yyyy-mm-dd hh24:mi:ss'), TGL_TAGIH = TO_DATE('".$tgl_tagih."','yyyy-mm-dd hh24:mi:ss'), TGL_SETOR_SSP = TO_DATE('".$tgl_setor_ppn."','yyyy-mm-dd hh24:mi:ss'), TGL_SETOR_PPNBM = TO_DATE('".$tgl_setor_ppnbm."','yyyy-mm-dd hh24:mi:ss'),NPWP = '".$npwp."',NAMA_WP = '".$nama_wp."' , JUMLAH_POTONG = '".$jumlah_potong."', DPP = '".$dpp."', INVOICE_NUM = '".$invoice_num."' , LAST_UPDATE_DATE = sysdate where PAJAK_LINE_ID = '".$id_lines."' ";

		/*insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID, KODE_LAMPIRAN, KODE_TRANSAKSI, KODE_STATUS, KODE_DOKUMEN, NPWP, NAMA_WP, DIGIT_TAHUN, NO_FAKTUR_PAJAK, TANGGAL_FAKTUR_PAJAK, TGL_TAGIH, TGL_SETOR_PPN, TGL_SETOR_PPNBM, JUMLAH_POTONG, JUMLAH_PPNBM, MASA_PAJAK, TAHUN_PAJAK, KODE_CABANG) 
				VALUES
				('".$pajak_header_id."', '".$kode_lampiran."', '".$kode_transaksi."', '".$kode_status."', '".$kode_dokumen."', '".$npwp."', '".$nama_wp."', '".$digit_tahun."', '".$no_faktur_pajak."', TO_DATE('".$tgl_faktur."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_tagih."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_setor_ppn."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_setor_ppnbm."','yyyy-mm-dd hh24:mi:ss'), '".$jumlah_potong."', '".$jumlah_ppnbm."', '".$bulan_pajak."', '".$tahun_pajak."', '".$kode_cabang."')";*/
		//return $sql; die();
		//print_r($sql); die();
		$query	= $this->db->query($sql);	
		if ($query){
			$params = array("PAJAK_LINE_ID" => $id_lines);
			simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $params);
			return true;
		} else {
			return false;
		}
	}

	function tambah_csv($kode_lampiran, $kode_transaksi, $kode_status, $kode_dokumen, $npwp, $nama_wp, $digit_tahun, $no_faktur_pajak, $tgl_faktur, $tgl_tagih, $tgl_setor_ppn, $tgl_setor_ppnbm, $pajak_header_id, $jumlah_potong, $jumlah_ppnbm, $masa_pajak, $tahun_pajak, $kode_cabang, $bulan, $invoice_num, $invoice_currency_code, $dpp, $invoice_accounting_date)
	{
		//$header	= $this->get_header_id($addBulan,$addTahun,$pembetulan_ke);
		$date			= date('Y-m-d H:i:s');
		
		$sql	="insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID, KODE_LAMPIRAN, KODE_TRANSAKSI, KODE_STATUS, KODE_DOKUMEN, NPWP, NAMA_WP, DIGIT_TAHUN, NO_FAKTUR_PAJAK, TANGGAL_FAKTUR_PAJAK, TGL_TAGIH, TGL_SETOR_SSP, TGL_SETOR_PPNBM, JUMLAH_POTONG, JUMLAH_PPNBM, MASA_PAJAK, TAHUN_PAJAK, KODE_CABANG, INVOICE_NUM, INVOICE_CURRENCY_CODE, DPP, NAMA_PAJAK, SOURCE_DATA, BULAN_PAJAK, INVOICE_ACCOUNTING_DATE) 
				VALUES
				('".$pajak_header_id."', '".$kode_lampiran."', '".$kode_transaksi."', '".$kode_status."', '".$kode_dokumen."', '".$npwp."', '".$nama_wp."', '".$digit_tahun."', '".$no_faktur_pajak."', TO_DATE('".$tgl_faktur."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_tagih."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_setor_ppn."','yyyy-mm-dd hh24:mi:ss'), TO_DATE('".$tgl_setor_ppnbm."','yyyy-mm-dd hh24:mi:ss'), '".$jumlah_potong."', '".$jumlah_ppnbm."', '".$masa_pajak."', '".$tahun_pajak."', '".$kode_cabang."', '".$invoice_num."', '".$invoice_currency_code."', '".$dpp."', 'PPN WAPU', 'CSV', '".$bulan."', TO_DATE('".$invoice_accounting_date."','yyyy-mm-dd hh24:mi:ss'))";
		//return $sql; die();
		//print_r($sql); die();
		$query	= $this->db->query($sql);	
		if ($query){
			simtax_update_history("SIMTAX_PAJAK_LINES", "CREATE", "PAJAK_LINE_ID");
			return true;
		} else {
			return false;
		}
	}

	function get_pembetulan()
	{		
		//$cabang			 =  $this->kode_cabang;
		$wherePajak 	 = "";
		$whereBulan 	 = "";
		$whereTahun 	 = "";
		$wherePembetulan = "";
		$whereCabang	 = "";
		
		if ($this->input->post('_searchPph')){
			$wherePajak	= " and sph.nama_pajak='".$this->input->post('_searchPph')."'";
		}
		if ($this->input->post('_searchBulan')){
			$whereBulan	= " and sph.bulan_pajak='".$this->input->post('_searchBulan')."'";
		}
		if ($this->input->post('_searchTahun')){
			$whereTahun	= " and sph.tahun_pajak='".$this->input->post('_searchTahun')."'";
		}
		if ($this->input->post('_searchPembetulan')){
			$wherePembetulan	= " and sph.pembetulan_ke='".$this->input->post('_searchPembetulan')."'";
		}
		if ($this->input->post('_searchCabang')){
			$whereCabang	= " and sph.kode_cabang='".$this->input->post('_searchCabang')."'";
		}
		
		$queryExec	= "Select sph.*, smp.status status_period, skc.nama_cabang from simtax_pajak_headers sph
						inner join simtax_master_period smp
						on sph.period_id = smp.period_id
						inner join simtax_kode_cabang skc
						on sph.kode_cabang=skc.kode_cabang
						where 1=1
						--and sph.pembetulan_ke >0
						--and sph.status = 'APPROVED BY PUSAT'
						".$wherePajak.$whereBulan.$whereTahun.$wherePembetulan.$whereCabang."
						order by sph.tahun_pajak, sph.bulan_pajak ";

						//print_r($queryExec); die();		
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}

	function action_save_pembetulan()
	{
		//$cabang		=  $this->kode_cabang;
		$cabang	    = $this->input->post('fCabang');
		$user		= $this->session->userdata('identity');
		//$pasal	    = $this->input->post('fjenisPajak');
		$masa	    = $this->input->post('fbulan');
		$tahun	    = $this->input->post('ftahun');				
		$pembetulan	= $this->input->post('fpembetulanKe')-1;					
		$date	= date("Y-m-d H:i:s");		
		
		$sql3 = "SELECT STATUS from SIMTAX_MASTER_PERIOD WHERE kode_cabang='".$cabang."' and BULAN_PAJAK='".$masa."' and tahun_pajak='".$tahun."' and upper(nama_pajak)='PPN WAPU' AND PEMBETULAN_KE= '".$pembetulan."' " ; 
		
		$query3 = $this->db->query($sql3);
		$rowCount	= $query3->num_rows() ;
		if ($rowCount>0){
			$row	= $query3->row();
			$status = $row->STATUS;			
			if($status=="Close" || $status=="CLOSE"){
				$header	= $this->get_header_id_max($cabang,$masa,$tahun);
				//call package
				//add by Derry
				if($header){
					$PARAMETER_1 = $header;
					$OUT_MESSAGE = "";
					
					$stid = oci_parse($this->db->conn_id, 'BEGIN :OUT_MESSAGE := SIMTAX_PAJAK_UTILITY_PKG.createPembetulan(:PARAMETER_1); end;');

					oci_bind_by_name($stid, ':PARAMETER_1',  $PARAMETER_1,200);
					oci_bind_by_name($stid, ':OUT_MESSAGE',  $OUT_MESSAGE ,100, SQLT_CHR);

					if(oci_execute($stid)){
					  $results = $OUT_MESSAGE;
					}
					
					oci_free_statement($stid);
					
					if ($results == -1) {
						return false;
					} else {
						return $status;
					}
				} else {
					return false;
				}
				//end add derry				
				
			} else if($status=="Open" || $status=="OPEN") {
				return $status;
			} else {
				return false;
			}
			
		} else {
			return "3";
		}	
	}

	function action_delete_pembetulan()
	{
		$cabang			=  $this->kode_cabang;
		$idPajakHeader  = $this->input->post('header_id');
		//$pajak			= $this->input->post('pajak');
		$bulan			= $this->input->post('bulan');
		$tahun			= $this->input->post('tahun');
		$pembetulan_ke	= $this->input->post('pembetulan_ke');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_HEADERS where PAJAK_HEADER_ID ='".$idPajakHeader."' and KODE_CABANG='".$cabang."'";
		$query	= $this->db->query($sql);
		if ($query){
			$sql1	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_HEADER_ID ='".$idPajakHeader."' and KODE_CABANG='".$cabang."'";
			$query1	= $this->db->query($sql1);
			if ($query1){
				$sql2	="DELETE FROM SIMTAX_MASTER_PERIOD where BULAN_PAJAK ='".$bulan."' and TAHUN_PAJAK ='".$tahun."' and upper(NAMA_PAJAK) ='PPN WAPU' and PEMBETULAN_KE ='".$pembetulan_ke."' and KODE_CABANG='".$cabang."'";
				$query2	= $this->db->query($sql2);
				
				$sql3	="DELETE FROM SIMTAX_ACTION_HISTORY where PAJAK_HEADER_ID ='".$idPajakHeader."'";
				$query3	= $this->db->query($sql3);
				if ($query2 && $query3){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		
		return true;
	}

	function get_view()
	{
		ini_set('memory_limit', '-1');
		$cabang			 =  $this->kode_cabang;
		$wherePajak 	 = "";
		$whereBulan 	 = "";
		$whereTahun 	 = "";
		$wherePembetulan = "";		
		if ($this->input->post('_searchPph')){
			$wherePajak	= " and sph.nama_pajak='".$this->input->post('_searchPph')."'";
		}
		if ($this->input->post('_searchBulan')){
			$whereBulan	= " and sph.bulan_pajak='".$this->input->post('_searchBulan')."'";
		}
		if ($this->input->post('_searchTahun')){
			$whereTahun	= " and sph.tahun_pajak='".$this->input->post('_searchTahun')."'";
		}
		if ($this->input->post('_searchPembetulan')){
			$wherePembetulan	= " and sph.pembetulan_ke='".$this->input->post('_searchPembetulan')."'";
		}		
				
			$queryExec	= "select sph.NAMA_PAJAK
							 , sph.PAJAK_HEADER_ID 
							 , sph.MASA_PAJAK
							 , sph.BULAN_PAJAK
							 , sph.TAHUN_PAJAK
							 , to_char(sph.CREATION_DATE, 'DD-MON-YYYY HH:MI:SS') CREATION_DATE
							 , sph.USER_NAME
							 , sph.STATUS
							 , to_char(sph.TGL_SUBMIT_SUP, 'DD-MON-YYYY HH:MI:SS') TGL_SUBMIT_SUP
							 , to_char(sph.TGL_APPROVE_SUP, 'DD-MON-YYYY HH:MI:SS') TGL_APPROVE_SUP
							 , to_char(sph.TGL_APPROVE_PUSAT, 'DD-MON-YYYY HH:MI:SS') TGL_APPROVE_PUSAT
							 , sph.PEMBETULAN_KE
							 , sph.KODE_CABANG
							 , (select sum(spl.JUMLAH_POTONG)
								  from simtax_pajak_lines spl
								 where spl.pajak_header_id = sph.pajak_header_id
								   and spl.IS_CHEKLIST = 1) ttl_jml_potong
						  from simtax_pajak_headers sph 
						  where sph.kode_cabang='".$cabang."' and sph.nama_pajak like '%PPN WAPU%'
						  --and sph.status = 'APPROVED BY PUSAT' 
						  ".$wherePajak.$whereBulan.$whereTahun.$wherePembetulan."
						  ORDER BY sph.creation_date desc";
			
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}

	function get_rekonsiliasi_detail()
	{
		$cabang	=  $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(c.vendor_name) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		$queryExec	= "
						SELECT DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
                        ,abs(a.dpp) jml_dpp
						--c.VENDOR_NAME, c.NPWP NPWP1, c.ADDRESS_LINE1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID		
						where a.kode_cabang='".$cabang."'
						".$where2.$where."
						order by a.INVOICE_NUM, INVOICE_LINE_NUM DESC";


						/*select DISTINCT a.*, c.vendor_name, c.npwp npwp1, c.address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
						where a.kode_cabang='".$cabang."'
						".$where2.$where."
						order by a.pajak_line_id DESC";*/	
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}

	function action_tot_rekonsiliasi()
	{
		$cabang		  = $this->kode_cabang;
		$pajak        = $this->input->post('pajak');
		$bulan		  = $this->input->post('bulan');
		$tahun        = $this->input->post('tahun');
		$pembetulan   = $this->input->post('pembetulan');		
		$date		  = date("Y-m-d H:i:s");	
		
		$sql3	= "select 
						sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = 'PPN WAPU'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY PUSAT'))
					group by        
						smp.STATUS ";

		/*select 
						sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.status 
							 FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
                        group by        
						smp.STATUS ";*/




						/*from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
					group by        
						smp.STATUS ";*/
			
		$query3 = $this->db->query($sql3);               		
		
		if($query3){			
			return $query3;
		} else {
			return false;
		}
		
	}

	function get_summary_rekonsiliasi($st)
	{
		ini_set('memory_limit', '-1');		
		$cabang	=  $this->kode_cabang;
		if($st==1){
			$where = " and spl.IS_CHEKLIST=1";
		} else if($st==0){
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where ="";
		}
		
		$queryExec	= "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY PUSAT'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."' 
                        ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/			
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function get_history()
	{
		ini_set('memory_limit', '-1');		
		$cabang	=  $this->kode_cabang;		
		
	/* 	$queryExec	= "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.NEW_JUMLAH_POTONG),abs(spl.jumlah_potong))) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."	
						group by        
							   spl.IS_CHEKLIST, smp.STATUS "; */
							   
		$queryExec	="Select sah.*, sph.bulan_pajak , sph.masa_pajak, sph.tahun_pajak from simtax_action_history sah
						inner join simtax_pajak_headers sph
						on sah.pajak_header_id=sph.pajak_header_id 
						where sph.kode_cabang='".$cabang."'
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."	
						order by action_date desc";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function action_detail_tot_rekonsiliasi()
	{
		$cabang		  = $this->kode_cabang;
		$pajak        = $this->input->post('pajak');
		$bulan		  = $this->input->post('bulan');
		$tahun        = $this->input->post('tahun');
		$pembetulan   = $this->input->post('pembetulan');		
				
		$sql3	= "select 
						sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
					group by        
						smp.STATUS ";

		/*select 
						sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.status 
							 FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
                        group by        
						smp.STATUS ";*/


		/*select 
						sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
					group by        
						smp.STATUS ";*/
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);               		
		
		if($query3){			
			return $query3;
		} else {
			return false;
		}
		
	}

	function get_detail_summary_rekonsiliasi($st)
	{
		ini_set('memory_limit', '-1');		
		$cabang	=  $this->kode_cabang;
		if($st==1){
			$where = " and spl.IS_CHEKLIST=1";
		} else if($st==0){
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where ="";
		}
		
		$queryExec	= "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."						  
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."' 
                        ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."						  
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/		
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function get_kompilasi()
	{
		ini_set('memory_limit', '-1');
		$q				= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where			= "";
		$whereCabang	= "";
		if($q) {
			$where	= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(a.nama_wp) like '%".strtoupper($q)."%' or upper(a.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(a.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(a.DPP) like '%".strtoupper($q)."%' or upper(a.NPWP) like '%".strtoupper($q)."%' or upper(a.JUMLAH_POTONG) like '%".strtoupper($q)."%') ";
		}
		if($_POST['_searchCabang']){
			$whereCabang =" and a.kode_cabang='".$_POST['_searchCabang']."' ";
		}
		$where2	= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		/*$queryExec	= "select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,e.kode_cabang cabang_master ,e.nama_cabang,
						SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
							AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID			
						where upper(b.STATUS) ='APPROVED BY PUSAT'
						--and a.is_cheklist = '1'
						".$whereCabang.$where2.$where."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC";*/

			$queryExec	= "SELECT * from  
                        (select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,e.kode_cabang cabang_master ,e.nama_cabang,
						SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
							AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID			
						where upper(b.STATUS) ='APPROVED BY PUSAT'
						and a.is_cheklist = '1'
						".$whereCabang.$where2.$where."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";	
						
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}

	function add_kompilasi_csv($data)
	{
		$dpp 		= (!$data['dpp'] || $data['dpp']=='' )?0:$data['dpp'];
		$tarif 		= (!$data['tarif'] || $data['tarif']=='' )?0:$data['tarif'];
		$jml_potong	= (!$data['jumlah_potong'] || $data['jumlah_potong']=='' )?0:$data['jumlah_potong'];
			
		if ($data['bulan']!="BULAN PAJAK") {
			$masa_pajak	= $this->getMonth($data['bulan']);
			$sql	= "insert into SIMTAX_PAJAK_LINES
							(PAJAK_HEADER_ID, BULAN_PAJAK,TAHUN_PAJAK, NAMA_PAJAK,NAMA_WP,NPWP,ALAMAT_WP,KODE_PAJAK,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_BUKTI_POTONG,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,GL_ACCOUNT,KODE_CABANG,PEMBETULAN_KE,MASA_PAJAK)
						values
							(".$data['header_id'].",".$data['bulan'].",".$data['tahun'].",'".$data['pajak']."','".$data['nama']."','".$data['npwp']."','".$data['alamat']."','".$data['kode_pajak']."','".$data['dpp']."','".$data['tarif']."','".$data['jumlah_potong']."','".$data['invoice_number']."','".$data['no_bukti_potong']."','".$data['no_faktur']."',"."TO_DATE('".$data['tgl_faktur']."','yyyy-mm-dd hh24:mi:ss')".",'".$data['akun_beban']."','070','".$data['pembetulan']."','".$masa_pajak."')";
			$query = $this->db->query($sql);
			if ($query){
				simtax_update_history("SIMTAX_PAJAK_LINES", "CREATE", "PAJAK_LINE_ID");
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}		
	}

	function get_summary_kompilasi($st)
	{
		ini_set('memory_limit', '-1');		
		$cabang	=  $this->kode_cabang;
		if($st==1){
			$where = " and spl.IS_CHEKLIST=1";
		} else if($st==0){
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where ="";
		}
		
		$whereCabang	= "";
		if($_POST['_searchCabang']){
			$whereCabang =" and sph.kode_cabang='".$_POST['_searchCabang']."' ";
		}
		
		$queryExec	= "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.STATUS
							 , skc.kode_cabang
							 , skc.nama_cabang
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_kode_cabang skc
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.kode_cabang = skc.kode_cabang
						  and sph.kode_cabang in ('000','010') 
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  ".$whereCabang."
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  --and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  --and upper(smp.status) ='CLOSE'
						  ".$where."
						group by        
							   skc.kode_cabang, skc.nama_cabang, spl.IS_CHEKLIST, smp.STATUS 
						order by skc.kode_cabang";

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
							 , skc.kode_cabang
							 , skc.nama_cabang
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_kode_cabang skc
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.kode_cabang = skc.kode_cabang
						  and sph.kode_cabang in ('000','010','070') 
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  ".$whereCabang."
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  --and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by        
							   skc.kode_cabang, skc.nama_cabang, spl.IS_CHEKLIST, smp.STATUS 
						order by skc.kode_cabang";*/			
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function action_tot_kompilasi($st)
	{
		$pajak        = $this->input->post('pajak');
		$bulan		  = $this->input->post('bulan');
		$tahun        = $this->input->post('tahun');
		$pembetulan   = $this->input->post('pembetulan');		
		$cabang   	  = $this->input->post('cabang');		
		
		if($st==1){
			$where = " and spl.IS_CHEKLIST=1";
		} else if($st==0){
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where ="";
		}
		
		$whereCabang	= "";
		if($cabang){
			$whereCabang =" and sph.kode_cabang='".$cabang."' ";
		}								
			$sql3	= "select spl.IS_CHEKLIST
							 , sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.status
							-- , skc.kode_cabang
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							-- , simtax_kode_cabang skc
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						 -- and sph.kode_cabang = skc.kode_cabang
						  and sph.kode_cabang in ('000','010') 
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  ".$whereCabang.$where."
						  and sph.pembetulan_ke=".$pembetulan."
						 -- and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
					group by        
						spl.IS_CHEKLIST, smp.status";
			
		$query3 = $this->db->query($sql3);               		
		
		if($query3){			
			return $query3;
		} else {
			return false;
		}
		
	}

	function get_ntpn()
	{
		$cabang	=  $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(spl.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(spl.NAMA_WP) like '%".strtoupper($q)."%' or upper(spl.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(spl.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(spl.DPP) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and SPH.bulan_pajak = '".$_POST['_searchBulan']."' and SPH.tahun_pajak = '".$_POST['_searchTahun']."' and SPH.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		/*$queryExec	= "
						SELECT DISTINCT SPL.*
						--SMS.VENDOR_NAME, SMS.NPWP NPWP1, SMS.ADDRESS_LINE1
						,NVL(SMS.VENDOR_NAME, SPL.NAMA_WP) VENDOR_NAME
                        ,NVL(SMS.NPWP,SPL.NPWP) NPWP1
                        ,NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND SPH.STATUS = 'APPROVED BY PUSAT'
                        --AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
                        AND SPL.IS_CHEKLIST = '1' 
                        ".$where2.$where."
						order by SPL.INVOICE_NUM, SPL.INVOICE_LINE_NUM DESC";*/

			$queryExec	= "SELECT * from  
                        (SELECT DISTINCT SPL.*
						--SMS.VENDOR_NAME, SMS.NPWP NPWP1, SMS.ADDRESS_LINE1
						,NVL(SMS.VENDOR_NAME, SPL.NAMA_WP) VENDOR_NAME
                        ,NVL(SMS.NPWP,SPL.NPWP) NPWP1
                        ,NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
						FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND SPH.STATUS = 'APPROVED BY PUSAT'
                        --AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
                        AND SPL.IS_CHEKLIST = '1' 
                        ".$where2.$where."
						order by SPL.INVOICE_NUM, SPL.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function add_csv_nominatif($tglsetorssp,$ntpn,$no_faktur,$pajak_header_id)
	{
		
		$date			= date('Y-m-d H:i:s');
		
		$vset="";
		if ($tglsetorssp){
			$vset = ",TGL_SETOR_SSP=TO_DATE('".$tglsetorssp."','yyyy-mm-dd hh24:mi:ss') ";
		}
		$sql	="UPDATE SIMTAX_PAJAK_LINES set NTPN='".$ntpn."', LAST_UPDATE_DATE = sysdate
		".$vset." where NO_FAKTUR_PAJAK ='".$no_faktur."' AND PAJAK_HEADER_ID = '".$pajak_header_id."' ";
		//return $sql;
		//print_r($sql); die();
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
	}

	function get_summary_approv($st)
	{
		ini_set('memory_limit', '-1');		
		$cabang	=  $this->kode_cabang;
		if($st==1){
			$where = " and spl.IS_CHEKLIST=1";
		} else if($st==0){
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where ="";
		}
		
		$queryExec	= "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."' 
                        ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/

		/*select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  and (sph.status in ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";*/			
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}

	function action_tot_approv()
	{
		$cabang		  = $this->kode_cabang;
		$pajak        = $this->input->post('pajak');
		$bulan		  = $this->input->post('bulan');
		$tahun        = $this->input->post('tahun');
		$pembetulan   = $this->input->post('pembetulan');		
		$date		  = date("Y-m-d H:i:s");	
		
		$sql3	= "select 
						sum(nvl(spl.JUMLAH_POTONG, spl.JUMLAH_POTONG)) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR'))
						  and upper(smp.status) ='OPEN'
					group by        
						smp.STATUS ";

		/*select 
						sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.status 
							 FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND (UPPER(SPH.STATUS) IN ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR'))
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'
                        AND SPH.KODE_CABANG ='".$cabang."'
                        group by        
						smp.STATUS ";*/

		/*select 
						sum(nvl(abs(spl.JUMLAH_PPN),abs(spl.JUMLAH_PPN))) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR'))
						  and upper(smp.status) ='OPEN'
					group by        
						smp.STATUS ";*/
			
		$query3 = $this->db->query($sql3);               		
		
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}

	function get_format_csv_compilasi()
	{
		//$cabang	= $this->kode_cabang;
		$pajak  = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  = $_REQUEST['month'];
        $tahun  = $_REQUEST['year'];
        $cabang  = $_REQUEST['pil'];
        $pembetulan  = $_REQUEST['ke'];
        $whereC = "";		
		
			
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' ";
		if($cabang || $cabang =""){
			$whereC = "and a.kode_cabang = '".$cabang."'";
		}		
		/*$sql = "SELECT  * from (select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
                        ,c.npwp npwp1, c.address_line1
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,e.kode_cabang cabang_master ,e.nama_cabang,
						SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						substr(a.no_faktur_pajak,12,19)no_faktur,
						b.PEMBETULAN_KE AS PEMBETULAN,
						ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (dpp) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
							AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID			
						where upper(b.STATUS) ='APPROVED BY PUSAT'
						and a.is_cheklist = '1'
						".$where2.$whereC."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";*/


		$sql = "SELECT * from  
                        (select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,e.kode_cabang cabang_master ,e.nama_cabang,
						SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						SUBSTR(a.NO_FAKTUR_PAJAK,12,19)no_faktur,
						b.PEMBETULAN_KE AS PEMBETULAN,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
							AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID			
						where upper(b.STATUS) ='APPROVED BY PUSAT'
						and a.is_cheklist = '1'
						".$where2.$whereC."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";

						//print_r($sql); die();

		/*SELECT DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK,
						c.VENDOR_NAME, c.NPWP NPWP1, c.ADDRESS_LINE1,
						SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB, SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						substr(a.no_faktur_pajak,12,19)no_faktur 
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID
                        AND (UPPER(b.STATUS) IN ('SUBMIT SUPPLIER'))
                        AND UPPER(d.STATUS) = 'OPEN'
                        AND a.NAMA_PAJAK = 'PPN WAPU'
                        AND b.KODE_CABANG IN ('000','010')
                        --AND a.IS_CHEKLIST = '1'
                        ".$where2."
						order by a.PAJAK_LINE_ID DESC";*/
						
		$query = $this->db->query($sql);
		return $query;
	}

	function get_format_ntpn_compilasi()
	{
		//$cabang	= $this->kode_cabang;
		$pajak  = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  = $_REQUEST['month'];
        $tahun  = $_REQUEST['year'];
        $cabang = $_REQUEST['pil'];
        $pembetulan = $_REQUEST['ke'];

        $whereC = "";		
		
			
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and a.pembetulan_ke = '".$pembetulan."' ";
		if($cabang || $cabang = "")	{
			$whereC = "and b.KODE_CABANG = '".$cabang."'";
		}
		$sql = "SELECT * FROM (SELECT DISTINCT a.*
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1,
                        ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (dpp) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn 
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        and c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID
                        AND UPPER(d.STATUS) = 'OPEN'
                        AND a.NAMA_PAJAK = 'PPN WAPU'
                        AND a.IS_CHEKLIST = '1'
                        AND a.NTPN IS NOT NULL
                        AND a.TGL_SETOR_SSP IS NOT NULL
                        AND b.STATUS = 'APPROVED BY PUSAT'
                        ".$where2.$whereC."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";
						
		$query = $this->db->query($sql);
		return $query;
	}

	function get_format_csv_rekon()
	{
		$cabang		= $this->kode_cabang;
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
        $pembetulan	= $_REQUEST['ke'];		
		
		$where	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' and a.is_cheklist=1 ";		
						
		$sql = "SELECT DISTINCT a.*, 
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
                        ,abs(a.dpp) jml_dpp
						--,c.VENDOR_NAME, c.NPWP NPWP1, 
						--c.ADDRESS_LINE1
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,substr(a.no_faktur_pajak,12,19)no_faktur 
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB, SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN
						,b.PEMBETULAN_KE AS PEMBETULAN
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID
                        AND (UPPER(b.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR','REJECT BY PUSAT'))
                        AND UPPER(d.STATUS) = 'OPEN'
                        AND a.NAMA_PAJAK = 'PPN WAPU'
                        AND b.KODE_CABANG ='".$cabang."' 
                        ".$where."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC";

		/*select DISTINCT a.*
						,CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						, a.PAJAK_LINE_ID
						, SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB
						, SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN
						, a.nama_pajak
						, a.invoice_num
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.no_bukti_potong
						, a.gl_account
						, a.kode_pajak
						, nvl(a.jumlah_potong,a.jumlah_potong) jumlah_potong
						, c.vendor_name
						, c.npwp npwp1
						, c.address_line1
						, substr(a.no_faktur_pajak,12,19)no_faktur						
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
							and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
							--and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID			
						where a.kode_cabang='".$cabang."' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT ADMIN')) and upper(d.STATUS) ='OPEN'
						".$where."
						order by a.tanggal_faktur_pajak ASC";*/
						
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			return $query;
		} else {
			return false;
		}
		
	}

	function get_format_csv_compdata()
	{
		//$cabang		= $this->kode_cabang;
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
        $pembetulan	= $_REQUEST['ke'];
        $cabang		= $_REQUEST['pil'];

        $whereC 	= "";
		
		$where	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' and a.is_cheklist=1 ";
		if($cabang || $cabang = "")	{
			$whereC = "and b.kode_cabang = '".$cabang."'";
		}	
						
		$sql = "select DISTINCT a.PAJAK_LINE_ID
						, a.nama_pajak
						, a.invoice_num
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.no_bukti_potong
						, a.gl_account
						, a.kode_pajak
						, nvl(a.jumlah_potong,a.jumlah_potong) jumlah_potong
						, c.vendor_name
						, c.npwp npwp1
						, c.address_line1
						, a.invoice_line_num						
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
							and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
							and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID			
						where
						--a.kode_cabang='".$cabang."'
						b.status = 'APPROVED BY PUSAT'
						--and upper(d.STATUS) ='OPEN'
						and a.is_cheklist = '1'
						--and b.kode_cabang in ('000','010')
						".$where.$whereC."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC";

						//print_r($sql); die();
						
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			return $query;
		} else {
			return false;
		}
		
	}

	function get_approv_pusat()
	{

		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		$whereCabang	= "";
		if($q) {
			$where	= "and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(a.NAMA_WP) like '%".strtoupper($q)."%' or upper(a.INVOICE_ACCOUNTING_DATE) like '%".strtoupper($q)."%' or upper(a.INVOICE_CURRENCY_CODE) like '%".strtoupper($q)."%' or upper(a.DPP) like '%".strtoupper($q)."%' or upper(a.NPWP) like '%".strtoupper($q)."%' or upper(a.JUMLAH_POTONG) like '%".strtoupper($q)."%')";
		}
		if($_POST['_searchCabang']){
			$whereCabang =" and a.kode_cabang='".$_POST['_searchCabang']."' ";
		}
		$where2	= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and b.nama_pajak = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		/*$queryExec	= "
						Select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID       
                        where (upper(b.status) in ('APPROVAL SUPERVISOR','APPROVED BY PUSAT')) 
                        and upper(d.STATUS) ='OPEN'
                        and a.nama_pajak = 'PPN WAPU'
                        and a.is_cheklist = 1
                        ".$whereCabang.$where2.$where."
						order by a.INVOICE_NUM, INVOICE_LINE_NUM DESC";*/

			$queryExec	= "SELECT * from  
                        (Select DISTINCT a.*,
						CASE
                        WHEN a.OU_NAME <>'KP0' and SUBSTR(a.NO_FAKTUR_PAJAK,1,3) <> '031' THEN  '1'
                        ELSE
                         CASE
                             WHEN SUBSTR(a.NO_FAKTUR_PAJAK,1,3)  = '031'
                              THEN  '5' ELSE  '3'
                            END
                        END AS KD_DOK
						--c.vendor_name, c.npwp npwp1, c.address_line1,
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
						,SUBSTR(a.NO_FAKTUR_PAJAK,5,3) AS KD_CAB,
						SUBSTR(a.NO_FAKTUR_PAJAK,9,2) AS DGT_THN,
						b.PEMBETULAN_KE AS PEMBETULAN,
				               ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (abs(dpp)) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
						FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        --and SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
						AND c.VENDOR_SITE_ID = a.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID       
                        where (upper(b.status) in ('APPROVAL SUPERVISOR','APPROVED BY PUSAT')) 
                        and upper(d.STATUS) ='OPEN'
                        and a.nama_pajak = 'PPN WAPU'
                        and a.is_cheklist = 1
                        ".$whereCabang.$where2.$where."
						order by a.INVOICE_NUM, INVOICE_LINE_NUM DESC)
						WHERE  rn =1";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}

	function action_save_approv_pusat()
	{
		//$cabang	=  $this->kode_cabang;
		$user	= $this->session->userdata('identity');
		//$pasal	= $this->input->post('pasal');
		$masa	= $this->input->post('masa');
		$cabang	= $this->input->post('cabang');
		$tahun	= $this->input->post('tahun');
		$st		= $this->input->post('st');
		$ket	= $this->input->post('ket');
		$pembetulan	= $this->input->post('pembetulan'); 		
		$date	= date("Y-m-d H:i:s");
		$header	= $this->get_header_id_pusat($masa,$tahun,$pembetulan,$cabang);
		
		if($st==1){
			$status	="APPROVED BY PUSAT";			
		} else {
			$status	="REJECT BY PUSAT";		
		}		
       	
		if ($header){
			$sql	="Update SIMTAX_PAJAK_HEADERS set TGL_APPROVE_PUSAT=TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'), 
					  status='".$status."', USER_NAME = '".$user."'
					  where PAJAK_HEADER_ID='".$header."' and KODE_CABANG='".$cabang."'";		
			$query	= $this->db->query($sql);
			
			$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME, CATATAN) 
					 values (".$header.",'PPN WAPU',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'".$status."','".$user."','".$ket."')";
			$query2	= $this->db->query($sql2);			
			if ($query && $query2){

				$params = array("PAJAK_HEADER_ID" => $header);
				$params2 = array("PAJAK_HEADER_ID" => $header, "ACTION_CODE" => $status, "CATATAN" => $ket);
				simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
				simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);
				return true;
			} else {
				return false;
			}		
		}
		
	}

	function action_get_selectAll()
	{
		$cabang				= $this->kode_cabang;		
		$id_lines			= $this->input->post('id_lines');
		$vcheck				= $this->input->post('vcheck');	
		
		$sql	="UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST='".$vcheck."'
				 where PAJAK_LINE_ID in  (".$id_lines.") and KODE_CABANG='".$cabang."'";
		
		$query	= $this->db->query($sql);	
		if ($query){				
			return true;				
		} else {
			return false;
		}
				
	}

	function action_cek_row_rekonsiliasi()
	{
		$cabang	    = $this->kode_cabang;
		$addAkun			= $this->input->post('fAddAkun');		
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		$pembetulan			= $this->input->post('fAddPembetulan');
		
		
		$where2	= " and a.bulan_pajak = '".$addBulan."' and a.tahun_pajak = '".$addTahun."' and upper(b.nama_pajak) = '".strtoupper($addAkun)."' and b.pembetulan_ke = '".$pembetulan."' ";	
						
		$sql3 = "select a.tanggal_faktur_pajak
                        , a.is_cheklist
                        , a.kode_transaksi
                        , a.no_faktur_pajak
                        , nvl(c.vendor_name,a.nama_wp) vendor_name
                        , nvl(c.NPWP,a.NPWP) NPWP1
                        , c.address_line1				
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						".$where2."						
						order by a.invoice_num, a.invoice_line_num DESC";
		
		$query3 = $this->db->query($sql3);   
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}

	function get_format_csv_nominatif()
	{
		$cabang	= $this->kode_cabang;
		$pajak  = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  = $_REQUEST['month'];
        $tahun  = $_REQUEST['year'];
        $pembetulan  = $_REQUEST['ke'];		
		
			
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' ";		
		$sql = "SELECT * FROM (SELECT DISTINCT a.* 
						--c.VENDOR_NAME, c.NPWP NPWP1, c.ADDRESS_LINE1
						,NVL(c.VENDOR_NAME, a.NAMA_WP) VENDOR_NAME
                        ,NVL(c.NPWP,a.NPWP) NPWP1
                        ,NVL(c.ADDRESS_LINE1,a.ALAMAT_WP) ADDRESS_LINE1
                        ,ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak ORDER BY 1) AS rn,
				               sum(jumlah_potong) over (partition by no_faktur_pajak) as jumlah_potong_ppn
				               ,SUM (dpp) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_dpp_ppn
			                   ,SUM (jumlah_ppnbm) OVER (PARTITION BY no_faktur_pajak)
			                   AS jumlah_ppnbm_ppn
                        FROM SIMTAX_PAJAK_LINES a 
                        INNER JOIN SIMTAX_PAJAK_HEADERS b ON a.PAJAK_HEADER_ID = b.PAJAK_HEADER_ID
                        --INNER JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                        --AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						left outer JOIN SIMTAX_MASTER_SUPPLIER c ON c.VENDOR_ID = a.VENDOR_ID
                        and c.VENDOR_SITE_ID = a.VENDOR_SITE_ID
						AND c.ORGANIZATION_ID = a.ORGANIZATION_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD d ON d.PERIOD_ID = b.PERIOD_ID
                        --AND (UPPER(b.STATUS) IN ('SUBMIT SUPPLIER','APPROVAL SUPERVISOR'))
                        --AND UPPER(d.STATUS) = 'OPEN'
                        AND a.NAMA_PAJAK = 'PPN WAPU'
                        AND b.KODE_CABANG = '".$cabang."'
                        AND a.IS_CHEKLIST = '1'
                        ".$where2."
						order by a.INVOICE_NUM, a.INVOICE_LINE_NUM DESC)
						WHERE  rn =1";
						
		$query = $this->db->query($sql);
		return $query;
	}

	function get_summary_rekonsiliasiAll1($bulan, $tahun, $pajak, $pembetulan, $step)
	{
		$cabang	=  $this->kode_cabang;
		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT','REJECT BY PUSAT')) ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		}
		else if ($step=="VIEW"){
			$where = "";
		} 
		
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  ".$where."
						  and upper(smp.status) ='OPEN'						 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";			
		$query1 	= $this->db->query($queryExec);		
		$result['queryExec']	= $query1;		
		return $result;			
	}

	function get_summary_rekonsiliasiAll1_pusat($bulan, $tahun, $pajak, $pembetulan, $pilihCabang, $step)
	{
		//$cabang	=  $this->kode_cabang;
		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT')) ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} 
		
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$pilihCabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  ".$where."
						  and upper(smp.status) ='OPEN'						 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";			
		$query1 	= $this->db->query($queryExec);		
		$result['queryExec']	= $query1;		
		return $result;			
	}

	function action_save_saldo_awal()
	{
		$cabang				    = $this->kode_cabang;
		$user				    = $this->session->userdata('identity');				
		$pajak		            = $this->input->post('pajak');
		$bulan                  = $this->input->post('bulan');
		$tahun	                = $this->input->post('tahun');
		$pembetulan	            = $this->input->post('pembetulan');
		$saldo                  = $this->input->post('vsal');
		$mutasiD	            = $this->input->post('vmtsd');
		$mutasiK	            = $this->input->post('vmtsk');
		$header					= $this->get_header_id($bulan,$tahun,$pembetulan);		
		
		if ($header){
			  $sql	="Update simtax_pajak_headers set saldo_awal='".$saldo."', mutasi_debit='".$mutasiD."', mutasi_kredit='".$mutasiK."', last_update_date=sysdate, user_name='".$user."'
			  where pajak_header_id ='".$header."' and kode_cabang='".$cabang."' ";	
				
			$query	= $this->db->query($sql);		
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function cek_format_csv_nominatif()
	{
		$cabang		= $this->kode_cabang;
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
        $pembetulan	= $_REQUEST['ke'];		
		
		$where	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' and a.is_cheklist=1 ";		
						
		$sql = "select DISTINCT a.PAJAK_LINE_ID
						, a.nama_pajak
						, a.invoice_num
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.no_bukti_potong
						, a.gl_account
						, a.kode_pajak
						, nvl(a.jumlah_potong,a.jumlah_potong) jumlah_potong
						, c.vendor_name
						, c.npwp npwp1
						, c.address_line1						
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						left outer join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
							and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
							and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID			
						where a.kode_cabang='".$cabang."'
						and b.status = 'APPROVED BY PUSAT'
						--and upper(d.STATUS) ='OPEN'
						and a.is_cheklist = '1'
						".$where."
						order by a.INVOICE_NUM DESC";
						
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			return $query;
		} else {
			return false;
		}
		
	}

	function get_currency1($bulan, $tahun, $pajak, $pembetulan, $step) //dipakai all (master)
	{
		$cabang	=  $this->kode_cabang;		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVED BY PUSAT','REJECT BY PUSAT')) ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		}
		else if ($step=="VIEW"){
			$where = "";
		} 
		$queryExec	= "select  nvl(sph.saldo_awal,0)	saldo_awal
							  , nvl(sph.mutasi_debit,0) mutasi_debit
							  , nvl(sph.mutasi_kredit,0	) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						  where sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  ".$where."
						  and upper(smp.status) ='OPEN'
						";			
			$query	 	= $this->db->query($queryExec);			
			$rowCount	= $query->num_rows() ;		
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}

	function get_currency1_pusat($bulan, $tahun, $pajak, $pembetulan,$pilihCabang, $step) //dipakai all (master)
	{
		//$cabang	=  $this->kode_cabang;		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT')) ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} 
		$queryExec	= "select  nvl(sph.saldo_awal,0)	saldo_awal
							  , nvl(sph.mutasi_debit,0) mutasi_debit
							  , nvl(sph.mutasi_kredit,0	) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						  where sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$pilihCabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  ".$where."
						  and upper(smp.status) ='OPEN'
						";			
			$query	 	= $this->db->query($queryExec);			
			$rowCount	= $query->num_rows() ;		
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}

	function get_summary_wapu($tahun_pajak,$bulan_pajak,$pembetulan_ke,$pilihCabang)
	{
		$queryExec	= "select skc.kode_cabang
                             , case skc.nama_cabang
                                when 'Kantor Pusat' then skc.nama_cabang
                               else 'Cabang ' || skc.nama_cabang
                               end nama_cabang     
                             , pajak.disp_ppn 
                             , pajak.ppn
                             , pajak.disp_spt
                             , pajak.spt
                             , pajak.selisih
                             , pajak.disp_selisih
                             from simtax_kode_cabang skc 
                        ,(    select rownum rnum
                             , sph.kode_cabang
                             , (select trim(to_char(sum(jumlah_potong),'999,999,999,999,999,999,999')) ttl from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1) DISP_PPN
                             , (select sum(jumlah_potong) from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1) PPN        
                             , (select trim(to_char(sum(jumlah_potong),'999,999,999,999,999,999,999')) ttl from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1 
                                and to_char(TANGGAL_FAKTUR_PAJAK,'MON-YYYY') = sph.MASA_PAJAK || '-' || sph.TAHUN_PAJAK) DISP_SPT  
                             , (select sum(jumlah_potong) ttl from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1 
                                and to_char(TANGGAL_FAKTUR_PAJAK,'MON-YYYY') = sph.MASA_PAJAK || '-' || sph.TAHUN_PAJAK) SPT 
                             , nvl((select sum(jumlah_potong) ttl from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1 
                                and to_char(TANGGAL_FAKTUR_PAJAK,'MON-YYYY') = sph.MASA_PAJAK || '-' || sph.TAHUN_PAJAK),0)
                                - 
                                nvl((select sum(jumlah_potong) from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1),0) SELISIH       
                             , trim(to_char(nvl((select sum(jumlah_potong) ttl from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1 
                                and to_char(TANGGAL_FAKTUR_PAJAK,'MON-YYYY') = sph.MASA_PAJAK || '-' || sph.TAHUN_PAJAK),0)
                                - 
                                nvl((select sum(jumlah_potong) from simtax_pajak_lines
                                where pajak_header_id = sph.pajak_header_id
                                and nvl(IS_CHEKLIST,0) = 1),0),'999,999,999,999,999,999,999')) DISP_SELISIH
                        from simtax_pajak_headers sph
                        where nama_pajak = 'PPN WAPU'
                        and tahun_pajak = ".$tahun_pajak."
						and bulan_pajak = ".$bulan_pajak."
						and pembetulan_ke = ".$pembetulan_ke."
                        and status not in  ('DRAFT','SUBMIT','REJECT SUPERVISOR','REJECT BY PUSAT')) pajak
                        where skc.KODE_CABANG = pajak.kode_cabang (+)
                        and skc.kode_cabang in ('000','010','020','030','040','050','060','070','080','090','100','110','120')
                        union all
                                                     select '991', '' ,null,null,null,null,null,null from dual
                                                     union all
                                                     select '992', '' ,null,null,null,null,null,null from dual
                                                     union all
                                                     select '993', '' ,null,null,null,null,null,null from dual
                                                    order by 1
						";		
		
		$query 		= $this->db->query($queryExec);
		
		$result['query']			= $query;
		return $result;		
	}

	function get_currency_kompilasi($bulan, $tahun, $pajak, $pembetulan, $pilihCabang) 
	{
		/* $cabang	=  $this->kode_cabang;		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="VIEW"){
			$where = "";
		}  */
		$where = "";
		if ($pilihCabang || $pilihCabang !=""){
			$where = " and sph.kode_cabang = '".$pilihCabang."' ";
		}
		
		$queryExec	= "select  sph.kode_cabang
							  , skc.nama_cabang 
							  , sum(nvl(sph.saldo_awal,0)) saldo_awal
							  , sum(nvl(sph.mutasi_debit,0)) mutasi_debit
							  , sum(nvl(sph.mutasi_kredit,0	)) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						inner join simtax_kode_cabang skc
							on sph.kode_cabang = skc.kode_cabang
						  where sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'						 
						  and sph.pembetulan_ke=".$pembetulan."
						  --and upper(smp.status) ='CLOSE'
						  and sph.status ='APPROVED BY PUSAT'
						  ".$where."
						  group by sph.kode_cabang, skc.nama_cabang
						  order by sph.kode_cabang
						  ";	
			//print_r($queryExec); exit();
			$query	 	= $this->db->query($queryExec);			
			$rowCount	= $query->num_rows() ;		
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}

	function get_summary_rekonsiliasi_kompilasi($bulan, $tahun, $pajak, $pembetulan, $pilihCabang)
	{
		//$cabang	=  $this->kode_cabang;
		
		/*if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR','APPROVED BY PUSAT')) ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN','REJECT BY PUSAT')) ";
		} */
		
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$pilihCabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and upper(smp.status) ='OPEN'						 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";			
		$query1 	= $this->db->query($queryExec);		
		$result['queryExec']	= $query1;		
		return $result;			
	}

	function get_total_detail()
	{
		ini_set('memory_limit', '-1');			
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
			
		$where	= "";		
		$where .= " and sph.bulan_pajak = '".$_POST['_searchBulan']."' and sph.tahun_pajak = '".$_POST['_searchTahun']."' and upper(sph.nama_pajak) = '".$_POST['_searchPph']."' and sph.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($cabang || $cabang!=""){
			$where .= " and sph.kode_cabang='".$cabang."' ";
		} 
				
		$queryExec	= "SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(SPL.NEW_JUMLAH_POTONG, SPL.JUMLAH_POTONG)),0) JUMLAH_POTONG						
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID                        
						left outer JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID                       
						AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID --add by Derry 10-Apr-2018
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID                      
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = 'PPN WAPU'                       
                        --AND SPH.KODE_CABANG in ('000','010')
						AND SPL.IS_CHEKLIST = 1
						AND SPH.STATUS = 'APPROVED BY PUSAT'
						".$where;						
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 		
		
		$query 		= $this->db->query($queryExec);			
		return $query;			
	}

	function check_duplicate_faktur($pajak_header_id){

		$sql = "SELECT CASE
				            WHEN SPL.KODE_DOKUMEN = 1 THEN SUBSTR (SPL.no_faktur_pajak, 12, 19)
				         END
				            AS BAYAR,
				         SUBSTR (SPL.no_faktur_pajak, 12, 19) no_faktur,
				         no_faktur_pajak,
				         INVOICE_NUM,
				         SUM (ABS (SPL.JUMLAH_POTONG)) JUMLAH_POTONG_PPN,
				         SUM (DPP) JUMLAH_DPP,
				         SUM (JUMLAH_PPNBM) JUMLAH_PPNBM_PPN
				    FROM SIMTAX_PAJAK_LINES SPL
				         INNER JOIN SIMTAX_PAJAK_HEADERS SPH
				            ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
				         INNER JOIN SIMTAX_MASTER_PERIOD SMP
				            ON SPH.PERIOD_ID = SMP.PERIOD_ID
				         LEFT OUTER JOIN SIMTAX_MASTER_SUPPLIER SMS
				            ON     SMS.VENDOR_ID = SPL.VENDOR_ID
				               AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
				               AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
				   WHERE SPL.pajak_header_id = '".$pajak_header_id."' 
				   AND SPL.IS_CHEKLIST = 1
				GROUP BY SPL.KODE_DOKUMEN, spl.no_faktur_pajak, spl.INVOICE_NUM
				  HAVING COUNT (no_faktur_pajak) > 1
				ORDER BY SPL.INVOICE_NUM DESC";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;

	}	
	
}