<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Pph_badan_mdl extends CI_Model {
	
  public function __construct() {
      parent::__construct();
  }

	function get_closing() {
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		if($q) {
			$where	.= " and ( upper(pajak) like '%".strtoupper($q)."%' or upper(status) like '%".strtoupper($q)."%' or tahun like '%".strtoupper($q)."%' ) ";
		}		
		$queryExec	= "Select * from simtax_master_period_pph_badan where 1=1 ".$where;		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		
		$queryExec .= " order by tahun desc, bulan desc, pajak asc";
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";	
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}	
	
	function action_save_period() {
		$cabang	= $this->session->userdata('kd_cabang');
		$user	= $this->session->userdata('identity');		
		$pajak	= $this->input->post('jenisPajak');
		$bulan	= $this->input->post('bulan');
		$tahun	= $this->input->post('tahun');				
		
		if($bulan<10){
			$bulan = '0'.$bulan;
		}
		
		$sqlc	="Select pajak from SIMTAX_MASTER_PERIOD_PPH_BADAN 
				  where pajak = '".$pajak."' and bulan='".$bulan."' and tahun='".$tahun."'";
		$queryc	= $this->db->query($sqlc);
		$count	= $queryc->num_rows();
		if ($count>0){
			return 2;
		} else {	
			$sql	="insert into SIMTAX_MASTER_PERIOD_PPH_BADAN (BULAN,TAHUN,PAJAK,STATUS,CREATION_DATE,USERNAME) 
			VALUES
			('".$bulan."','".$tahun."','".$pajak."','OPEN',sysdate,'".$user."')";
			$query	= $this->db->query($sql);		
			if ($query){
				return 1;
			} else {
				return false;
			}	
		}		
	}
	
	function action_save_closing() {
		$status	= $this->input->post('status');
		$nama	= $this->input->post('nama');		
		$bulan	= $this->input->post('bulan');		
		$tahun	= $this->input->post('tahun');	
				
		$sql	="Update SIMTAX_MASTER_PERIOD_PPH_BADAN set STATUS='".strtoupper($status)."'
				  where pajak = '".$nama."' and bulan='".$bulan."' and tahun='".$tahun."'";

		$params = array(
							"PAJAK" => $nama,
							"BULAN" => $bulan,
							"TAHUN" => $tahun
						 );

		$query	= $this->db->query($sql);		
		if ($query){
			simtax_update_history("SIMTAX_MASTER_PERIOD_PPH_BADAN", "UPDATE", $params);
			return true;
		} else {
			return false;
		}		
	}

	function do_save_bupot_ph_lain() {
		$PARAMETER_1 = "";
	
		$stid = oci_parse($this->db->conn_id, 'BEGIN SIMTAX_PAJAK_UTILITY_PKG.insertBupotLainKeBaseTable(:PARAMETER_1); end;');

		oci_bind_by_name($stid, ':PARAMETER_1',  $PARAMETER_1,200);

		if(oci_execute($stid)){
		  return true;
		}
		
		oci_free_statement($stid);
	}	
	
	
	function get_url_doc() {
		//$kode_cabang = '010';
		$kode_cabang = $this->session->userdata('kd_cabang');
		
		$queryExec	= "select * 
      from simtax_url_cloud_doc 
      where 1=1 
        and upper(nama_pajak) = upper('".$_POST['_searchNama']."') 
        and bulan_pajak = '".$_POST['_searchBulan']."'
        and tahun_pajak = '".$_POST['_searchTahun']."'
        and pembetulan_ke = '".$_POST['_searchKe']."'
        and kode_cabang = '".$kode_cabang."'
      order by TAHUN_PAJAK";		
		
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

	function get_laba_rugi() {
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		if($q) {
			$where	= " and (upper(KODE_JASA) like '%".strtoupper($q)."%' or upper(TAHUN_PAJAK) like '%".strtoupper($q)."%' or  upper(DESCRIPTION) like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "select slpb.*, (nvl(slpb.balance,0) - nvl(slpb.positif,0) - nvl(slpb.negatif,0)) SPT, (slpb.kode_jasa || ' ' || slpb.description) URAIAN from SIMTAX_LABARUGI_PPH_BADAN slpb where 1=1 
					   ".$where."
						order by KODE_AKUN, KODE_JASA";		
		
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
	
	function get_beban_lain()
	{	
		//$kode_cabang = $this->session->userdata('kd_cabang');
		$queryExec	= "select kode_akun
							 , akun_description
							 , sum(nvl(debit,0)) jml_uraian
							 , sum(case nvl(CHECKLIST,'0')
							   when '0' then debit
							   else 0
							   end) DEDUCTIBLE 
							 , sum(case nvl(CHECKLIST,'0')
							   when '1' then debit
							   else 0
							   end) NON_DEDUCTIBLE
						 from SIMTAX_RINCIAN_BL_PPH_BADAN
						where tahun_pajak = '".$_POST['_searchTahun']."'
						  and bulan_pajak = '".$_POST['_searchBulan']."'
						  and kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
														   '80108061', '89199999', '80106999', '80108999')
						";
		
		if ($_POST['_searchCabang'] != "all")
		{
			$queryExec	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}
			$queryExec .= "group by tahun_pajak, kode_akun, akun_description
							order by kode_akun";

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
	
	function get_fiskal()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$kode_cabang = $this->session->userdata('kd_cabang');	
		$where	= " ";
		$wherecbg  = " and kode_cabang = '".$kode_cabang."' ";  
		if($q) {
			$where	= " and (upper(KODE_AKUN) like '%".strtoupper($q)."%' or upper(TAHUN_PAJAK) like '%".strtoupper($q)."%' or  upper(AKUN_DESCRIPTION) like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "select sbpb.* 
							 , case sbpb.bulan_pajak
								when 1 then  'JAN' 
								when 2 then  'FEB'
								when 3 then  'MAR'
								when 4 then  'APR'
								when 5 then  'MAY'
								when 6 then  'JUN'
								when 7 then  'JUL'
								when 8 then  'AUG'
								when 9 then  'SEP'
								when 10 then  'OCT'
								when 11 then  'NOV'
								when 12 then  'DEC'
							   end DISP_BULAN
						  from SIMTAX_FISKAL_PPH_BADAN sbpb where 1=1 and kode_akun like '8%'
						and tahun_pajak = '".$_POST['_searchTahun']."'
						and bulan_pajak = nvl('".$_POST['_searchBulan']."',bulan_pajak)
					   ".$where."
					   ".$wherecbg."
						order by KODE_AKUN, KODE_JASA";		
		
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

	function get_fiskal_pend()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$kode_cabang = $this->session->userdata('kd_cabang');

		$where	= " ";
		$wherecbg  = " and kode_cabang = '".$kode_cabang."' ";
		if($q) {
			$where	= " and (upper(KODE_AKUN) like '%".strtoupper($q)."%' or upper(TAHUN_PAJAK) like '%".strtoupper($q)."%' or  upper(AKUN_DESCRIPTION) like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "select sbpb.* 
							 , case sbpb.bulan_pajak
								when 1 then  'JAN' 
								when 2 then  'FEB'
								when 3 then  'MAR'
								when 4 then  'APR'
								when 5 then  'MAY'
								when 6 then  'JUN'
								when 7 then  'JUL'
								when 8 then  'AUG'
								when 9 then  'SEP'
								when 10 then  'OCT'
								when 11 then  'NOV'
								when 12 then  'DEC'
							   end DISP_BULAN
						  from SIMTAX_FISKAL_PPH_BADAN sbpb where 1=1 and kode_akun like '7%'
						   and tahun_pajak = '".$_POST['_searchTahun']."'
						   and bulan_pajak = nvl('".$_POST['_searchBulan']."',bulan_pajak)
					   ".$where."
					   ".$wherecbg."
						order by KODE_AKUN, KODE_JASA";		
		
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
	
	function get_rincian_bl()
	{
		//$kode_cabang = $this->session->userdata('kd_cabang');
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		if($q) {
			$where	= " and (upper(KODE_AKUN) like '%".strtoupper($q)."%' or upper(URAIAN) like '%".strtoupper($q)."%' or  AKUN_DESCRIPTION like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "select BEBAN_LAIN_ID, CHECKLIST, KODE_AKUN, AKUN_DESCRIPTION, DEBIT, URAIAN 
						 from SIMTAX_RINCIAN_BL_PPH_BADAN
						where kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
														   '80108061', '89199999', '80106999', '80108999')
						and debit is not null
						and tahun_pajak = '".$_POST['_searchTahun']."'
						and bulan_pajak = '".$_POST['_searchBulan']."'
						and kode_akun = '".$_POST['_searchAkun']."'
						and ledger_id = '".$_POST['_searchLedger']."'"; 
		if ($_POST['_searchCabang'] != "all")
		{
			$queryExec	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}
						

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		/* old row count
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);	
		$rowCount	= $query2->num_rows() ;
		*/
		
		//start row count
		$queryCount = "select count(1) JML 
						 from SIMTAX_RINCIAN_BL_PPH_BADAN
						where kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
														   '80108061', '89199999', '80106999', '80108999')
						and debit is not null
						and tahun_pajak = '".$_POST['_searchTahun']."'
						and bulan_pajak = '".$_POST['_searchBulan']."'
						and kode_akun = '".$_POST['_searchAkun']."'
						and ledger_id = '".$_POST['_searchLedger']."'";
		if ($_POST['_searchCabang'] != "all")
		{
			$queryCount	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}				
						
		$selectCount	= $this->db->query($queryCount);
		$row        	= $selectCount->row();       	
		$rowCount  		= $row->JML; 
		//end get row count				
		
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}

	function get_ttl_rincian_bl()
	{
		$bulan		= $this->input->post('bulan');
		$tahun		= $this->input->post('tahun');
		$akun		= $this->input->post('akun');
		$ledger		= $this->input->post('ledger');
		
		$kode_cabang = $this->session->userdata('kd_cabang');
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		if($q) {
			$where	= " and (upper(NOMOR_BUKTI) like '%".strtoupper($q)."%' or upper(URAIAN) like '%".strtoupper($q)."%' or  TGL_BUKTI like '%".strtoupper($q)."%') ";
		}
			
		//start row count
		/*
		$queryCount = "select count(1) JML
		                    , trim(to_char(sum(debit),'999,999,999,999,999,999.99'))  SUM_DEBIT
							, trim(to_char(sum(credit),'999,999,999,999,999,999.99'))  SUM_CREDIT
						 from SIMTAX_RINCIAN_BL_PPH_BADAN srbp where 1=1
						  and tahun_pajak = '".$tahun."'
						  and bulan_pajak = '".$bulan."'
						  and kode_akun = '".$akun."'
						  and ledger_id = '".$ledger."'
						  and kode_cabang = '".$kode_cabang."'
					   ".$where;
		*/	
$queryCount = "select count(1) JML
							, trim(to_char(sum(debit),'999,999,999,999,999,999.99'))  SUM_DEBIT
							, trim(to_char(sum(credit),'999,999,999,999,999,999.99'))  SUM_CREDIT
						 from SIMTAX_RINCIAN_BL_PPH_BADAN srbp where 1=1
						  and beban_lain_id in (select max(BEBAN_LAIN_ID) BEBAN_LAIN_ID							
												 from SIMTAX_RINCIAN_BL_PPH_BADAN srbp where 1=1
												and tahun_pajak = '".$tahun."'
												and bulan_pajak = '".$bulan."'
												and kode_akun = '".$akun."'
												and ledger_id = '".$ledger."'
												and kode_cabang = '".$kode_cabang."'
											   ".$where."
											   group by
													TAHUN_PAJAK,
													BULAN_PAJAK,
													MASA_PAJAK,
													DEBIT,
													CREDIT,
													KODE_AKUN,
													AKUN_DESCRIPTION,
													CHECKLIST,
													CODE_COMPANY,
													LEDGER_ID,
													CREATION_DATE,
													CREATED_BY,
													UPDATE_DATE,
													UPDATE_BY,
													TGL_BUKTI,
													NOMOR_BUKTI,
													URAIAN,
													KODE_CABANG,
													REQUEST_ID)";		
						
		$selectCount	= $this->db->query($queryCount);
		$row        	= $selectCount->row();       	
		$rowCount  		= $row->JML; 
		$sumDebit  		= $row->SUM_DEBIT;
		$sumCredit 		= $row->SUM_CREDIT;		
		//end get row count				
		
		$result['sumDebit']			= $sumDebit;
		$result['sumCredit']		= $sumCredit;		
		return $result;		
	}	
	
    function get_tbl_bupot_ph_lain() {     
        $query = $this->db->query('select * from SIMTAX_UBUPOT_PH_LAIN_STG');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
	
	function action_delete_stg()
	{
		$sql	="DELETE FROM SIMTAX_UBUPOT_PH_LAIN_STG";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}			
	}
	
	function add($data){

		$sql	="insert into SIMTAX_UBUPOT_PH_LAIN_STG 
				 (BUKTI_POTONG_ID
				 ,NAMA_PAJAK
				 ,MASA_PAJAK
				 ,TAHUN_PAJAK
				 ,NO_BUKTI_POTONG
				 ,TGL_BUKTI_POTONG
				 ,NAMA_WP
				 ,NPWP
				 ,ALAMAT_WP
				 ,KODE_PAJAK
				 ,DPP
				 ,TARIF
				 ,JUMLAH_POTONG
				 ,NAMA_FILE
				 ,PEMBETULAN_KE
				 ,CARA_PEMBAYARAN
				 ,JENIS_PENGHASILAN
				 ,KODE_MAP
				 ,NTPP
				 ,JUMLAH_PEMBAYARAN
				 ,TANGGAL_SETOR
				 ,KODE_CABANG) 
				 VALUES
				 (simtax_ubupot_ph_lain_s.nextval,
				 '".$data['NAMA_PAJAK']."',
				 '".$data['MASA_PAJAK']."',
				 '".$data['TAHUN_PAJAK']."',
				 '".$data['NO_BUKTI_POTONG']."',
				 '".$data['TGL_BUKTI_POTONG']."',
				 '".$data['NAMA_WP']."',
				 '".$data['NPWP']."',
				 '".$data['ALAMAT_WP']."',
				 '".$data['KODE_PAJAK']."',
				 '".$data['DPP']."',
				 '".$data['TARIF']."',
				 '".$data['JUMLAH_POTONG']."',
				 '".$data['NAMA_FILE']."',
				 '".$data['PEMBETULAN_KE']."',
				 '".$data['CARA_PEMBAYARAN']."',
				 '".$data['JENIS_PENGHASILAN']."',
				 '".$data['KODE_MAP']."',
				 '".$data['NTPP']."',
				 '".$data['JUMLAH_PEMBAYARAN']."',
				 '".$data['TANGGAL_SETOR']."',
				 '".$data['KODE_CABANG']."'
				 )";
		
		$query 		= $this->db->query($sql);	
		if($query) {
			return true;
		} else {
			return false;
		}
		//return true;
	}

	function cek_tahun($pjk,$bln="",$thn="",$cab="",$ket="")
	{
		$where = "";
		if($pjk){
			$where = " and nama_pajak='".$pjk."' ";
		}		
		
		if($bln && $bln!=0){
			$where	.= " and masa_pajak=".$bln." ";
		}
		
		if($thn){
			$where	.= " and tahun_pajak=".$thn." ";
		}
		
		if(isset($cab) && $cab){
			$where	.= " and kode_cabang='".$cab."' ";
		}		
		
		if($ket=="FINAL"){
			$table = "SIMTAX_UBUPOT_PH_LAIN";
		} else {
			$table = "SIMTAX_UBUPOT_PH_LAIN_STG";
		}
		
		$sql	="Select tahun_pajak from ".$table." where 1=1 ".$where." and rownum=1";
		$query 		= $this->db->query($sql);
		if ($query->num_rows()>0){
			return 1; //ada
		} else {
			return 0; //tdk ada
		}
	}	
	
	function get_bupot_lain()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
		$cabang	= $this->session->userdata('kd_cabang');
		$where	= " ";
		if($q) {
			$where	= " and (upper(a.NO_BUKTI_POTONG) like '%".strtoupper($q)."%' or a.NPWP like '%".$q."%') ";
		}
		
		$queryExec	= "Select a.*, b.NAMA_CABANG from simtax_ubupot_ph_lain_stg a
						inner join SIMTAX_KODE_CABANG b
						on a.KODE_CABANG=b.KODE_CABANG
						 where 1=1 and a.kode_cabang='".$cabang."'
						 ".$where;		
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		
		$queryExec .=" order by a.nama_pajak, a.BUKTI_POTONG_ID ";
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";		
		
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}
	
	function get_bupot_lain_final()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		
		if(isset($_POST['_searchPph']) && $_POST['_searchPph']){
			$where	.= " and a.nama_pajak='".$_POST['_searchPph']."'";
		}
		
		if($_POST['_searchbulan']){
			$where	.= " and a.masa_pajak=".$_POST['_searchbulan']." ";
		}
		
		if($_POST['_searchTahun']){
			$where	.= " and a.tahun_pajak=".$_POST['_searchTahun']." ";
		}
		
		if(isset($_POST['_searchCabang']) && $_POST['_searchCabang']){
			$where	.= " and a.kode_cabang=".$_POST['_searchCabang']." ";
		}
		
		if($q) {
			$where	.= " and (upper(a.NO_BUKTI_POTONG) like '%".strtoupper($q)."%' or a.NPWP like '%".$q."%') ";
		}
				
		$queryExec	= "select a.*, b.nama_cabang from simtax_ubupot_ph_lain a 
					   inner join simtax_kode_cabang b 
					   on a.kode_cabang=b.kode_cabang
					   where 1=1 
					   ".$where;		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows() ;
		
		$queryExec	.= " order by a.nama_pajak, a.BUKTI_POTONG_ID";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}	
	
	function get_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->session->userdata('kd_cabang');
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$where		= "";
		
		if(isset($_POST['_searchPph']) && $_POST['_searchPph']){
			$where	.= " and nama_pajak='".$_POST['_searchPph']."'";
		}		
		
		if($_POST['_searchbulan']){
			$where	.= " and masa_pajak=".$_POST['_searchbulan']." ";
		}
		
		if($_POST['_searchTahun']){
			$where	.= " and tahun_pajak=".$_POST['_searchTahun']." ";
		}
		
		if(isset($_POST['_searchCabang']) && $_POST['_searchCabang']){
			$where	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}		
		
		if($q) {
			$where	.= " and (upper(NO_BUKTI_POTONG) like '%".strtoupper($q)."%' or NPWP like '%".$q."%' ) ";
		}	
		
		$queryExec	= "select nama_pajak, sum(jumlah_potong) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";					
			
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by nama_pajak"; 			
			
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
		$cabang	    =  $this->session->userdata('kd_cabang');		
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		
		$where	= "";	
		
		if(isset($_POST['_searchPph']) && $_POST['_searchPph']){
			$where	.= " and nama_pajak='".$_POST['_searchPph']."'";
		}		
		
		if($_POST['_searchbulan']){
			$where	.= " and masa_pajak=".$_POST['_searchbulan']." ";
		}
		
		if($_POST['_searchTahun']){
			$where	.= " and tahun_pajak=".$_POST['_searchTahun']." ";
		}
		
		if(isset($_POST['_searchCabang']) && $_POST['_searchCabang']){
			$where	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}		
		
		if($q) {
			$where	.= " and (upper(NO_BUKTI_POTONG) like '%".strtoupper($q)."%' or NPWP like '%".$q."%') ";
		}	
				
		$queryExec	= "select nvl(sum(jumlah_potong),0) total 
						from simtax_ubupot_ph_lain where 1=1 
						".$where;			
		$query 		= $this->db->query($queryExec);			
		return $query;		
	}
	
	function get_format_csv()
	{
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
        $cab	   	= $_REQUEST['cab'];
		$where		= " ";
		
		if($pajak){
			$where	.= " and nama_pajak='".$pajak."'";
		}
		
		if($bulan && $bulan!=0){
			$where	.= " and masa_pajak=".$bulan." ";
		}
		
		if($tahun){
			$where	.= " and tahun_pajak=".$tahun." ";
		}
		
		if(isset($cab) && $cab){
			$where	.= " and kode_cabang='".$cab."' ";
		}		
		
		$sql	= "select BUKTI_POTONG_ID
					,nama_pajak
					,masa_pajak
					,tahun_pajak
					,no_bukti_potong
					,to_char(tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong 
					,nama_wp
					,npwp
					,alamat_wp
					,kode_pajak
					,dpp
					,tarif
					,jumlah_potong
					,nama_file
					,pembetulan_ke
					,cara_pembayaran
					,jenis_penghasilan
					,kode_map
					,ntpp
					,jumlah_pembayaran
					,tanggal_setor
					,kode_cabang
				   from simtax_ubupot_ph_lain where 1=1 
					   ".$where."
						order by BUKTI_POTONG_ID";	
				
		$query = $this->db->query($sql);
		if ($query){
			return $query;
		} else {
			return false;
		}
		
	}
	
	
	function get_lov_nama_pajak()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " Where upper(NAMA_PAJAK) like '%".strtoupper($q)."%'";
		}		
	
		$queryExec	= "select distinct NAMA_PAJAK from simtax_master_period order by NAMA_PAJAK";
		
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

	function get_lov_account()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(ffvt.DESCRIPTION) like '%".strtoupper($q)."%' or ffv.FLEX_VALUE like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " select ffv.FLEX_VALUE, ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'".$where;
		
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
	
	function get_lov_acc_delapan()
	{
		//get usedAkun
		//$isNewRecord        = $this->input->post('usedAkun');
		//$_POST['_usedAkun']
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(ffvt.DESCRIPTION) like '%".strtoupper($q)."%' or ffv.FLEX_VALUE like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " select ffv.FLEX_VALUE, ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ffv.flex_value not IN
								  ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
								   '80108061', '89199999', '80106999', '80108999')
						  AND ffv.flex_value like '".$_POST['_usedAkun']."%'".$where;
		
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

	function get_lov_acc_delapan2()
	{
		//get usedAkun
		//$isNewRecord        = $this->input->post('usedAkun');
		//$_POST['_usedAkun']
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(coa_desc) like '%".strtoupper($q)."%' or coa like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " select coa FLEX_VALUE, coa_desc DESCRIPTION, sum(nvl(begin_balance_dr,0) - nvl(begin_balance_cr,0)) komersial, period_num, period_year 
						from simtax_tb_v
						where coa not in 
										('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
										   '80108061', '89199999', '80106999', '80108999')
								  and coa like '".$_POST['_usedAkun']."%' 
								  and period_num = '".$_POST['_usedBulan']."' 
								  and period_year = '".$_POST['_usedTahun']."'
									".$where."
									group by coa, coa_desc, period_num, period_year
									order by coa asc";
		
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

	function get_lov_kode_jasa()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(ffvt.DESCRIPTION) like '%".strtoupper($q)."%' or ffv.FLEX_VALUE like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " select ffv.FLEX_VALUE, ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_PUSAT_PELAYANAN'".$where;
		
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
	
	function get_lov_account_beban()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(ffvt.DESCRIPTION) like '%".strtoupper($q)."%' or ffv.FLEX_VALUE like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " SELECT ffv.flex_value, ffvt.description
						  FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt, fnd_flex_value_sets ffvs
						 WHERE ffv.flex_value_id = ffvt.flex_value_id
						   AND ffvs.flex_value_set_id = ffv.flex_value_set_id
						   AND ffvs.flex_value_set_name = 'PI2_ACCOUNT'
						   AND ffv.flex_value IN
								  ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
								   '80108061', '89199999', '80106999', '80108999')".$where;
		
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

	function get_lov_account_beban_tujdel()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { 
			$where	= " and (upper(ffvt.DESCRIPTION) like '%".strtoupper($q)."%' or ffv.FLEX_VALUE like'%".strtoupper($q)."%')";
		}		
	
		$queryExec	= " select ffv.FLEX_VALUE, ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ((ffv.FLEX_VALUE) like '7%' or (ffv.FLEX_VALUE) like '8%')".$where;
		
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
	
	function do_save_url_doc()
	{
		$isNewRecord        = $this->input->post('isNewRecord'); //flag insert(1) atau update(null atau 0)	
		$nama_pajak			= $this->input->post('inpnamapajak');
		//$masa_pajak			= '';
		$tahun_pajak		= $this->input->post('inpTahun');
		$pembetulan_ke		= $this->input->post('inpPembetulanKe');
		$nama_doc			= $this->input->post('inpFile');
		$url_doc			= $this->input->post('inpURL');
		$bulan_pajak		= $this->input->post('inpMasa');
		$UrlDocId			= $this->input->post('UrlDocId');

		$shortMonthArr = array("", "JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC");
		$masa_pajak = $shortMonthArr[$this->input->post('inpMasa')];
				
		$kode_cabang 	= $this->session->userdata('kd_cabang');
		$user_name 		= $this->session->userdata('identity');
			
		if ($isNewRecord) {		
			$sql	="insert into simtax_url_cloud_doc 
					 (URL_DOC_ID
					 ,USER_NAME_CREATED
					 ,CREATION_DATE
					 ,NAMA_PAJAK
					 ,MASA_PAJAK
					 ,TAHUN_PAJAK
					 ,PEMBETULAN_KE
					 ,NAMA_DOC
					 ,URL_DOC
					 ,KODE_CABANG
					 ,BULAN_PAJAK) 
					 VALUES
					 (simtax_url_cloud_doc_s.nextval,
					 '".$user_name."',
					 sysdate,
					 '".$nama_pajak."',
					 '".$masa_pajak."',
					 '".$tahun_pajak."',
					 '".$pembetulan_ke."',
					 '".$nama_doc."',
					 trim('".$url_doc."'),
					 '".$kode_cabang."',
					 '".$bulan_pajak."')";
		} else {
			$sql	="update simtax_url_cloud_doc 
						 set NAMA_PAJAK = '".$nama_pajak."',
							 MASA_PAJAK = '".$masa_pajak."',
							 TAHUN_PAJAK = '".$tahun_pajak."',
							 PEMBETULAN_KE = '".$pembetulan_ke."',
							 NAMA_DOC = '".$nama_doc."',
							 BULAN_PAJAK = '".$bulan_pajak."',
							 UPDATE_DATE = sysdate,
							 USER_NAME_UPDATE = '".$user_name."',
							 URL_DOC = trim('".$url_doc."')
					   where URL_DOC_ID = '".$UrlDocId."'	
					 ";
		}
		
		$query	= $this->db->query($sql);	
		
		if ($query){
			/*if ($isNewRecord) {
				simtax_update_history("SIMTAX_URL_CLOUD_DOC", "CREATE", "URL_DOC_ID");
			}
			else{
				simtax_update_history("SIMTAX_URL_CLOUD_DOC", "UPDATE", $UrlDocId);
			}*/
			return true;
		} else {
			return false;
		}
		
	}
	
	function do_save_beban_lain()
	{
		$isNewRecord        = $this->input->post('isNewRecord'); //flag insert(1) atau update(null atau 0)	
		$inpAccount        	= $this->input->post('inpAccount'); 
		$inpDescription		= $this->input->post('inpDescription');
		$inpAmount			= $this->input->post('inpAmount');
		$inpIsDeductible	= $this->input->post('inpIsDeductible');
		$inpDeductible		= $this->input->post('inpDeductible');
		$inpNonDeductible	= $this->input->post('inpNonDeductible');
		$inpTahun			= $this->input->post('inpTahun');
		$DocId				= $this->input->post('DocId');
		
				
		//$kode_cabang 	= $this->session->userdata('kd_cabang');
		$user_name 		= $this->session->userdata('identity');
			
		if ($isNewRecord) {		
			$sql	="insert into SIMTAX_BEBANLAIN_PPH_BADAN 
					 (BEBAN_LAIN_ID
					 ,KODE_AKUN
					 ,AKUN_DESCRIPTION
					 ,AMOUNT
					 ,KOREKSI_DEDUCTIBLE
					 ,KOREKSI_NONDEDUCTIBLE
					 ,IS_DEDUCTIBLE
					 ,CREATION_DATE
					 ,TAHUN_PAJAK
					 ,CREATED_BY) 
					 VALUES
					 (SIMTAX_BEBANLAIN_PPH_BADAN_S.nextval,
					 '".$inpAccount."',
					 '".$inpDescription."',
					 '".$inpAmount."',
					 '".$inpDeductible."',
					 '".$inpNonDeductible."',
					 '".$inpIsDeductible."',
					 sysdate,
					 '".$inpTahun."',
					 '".$user_name."')";
		} else {
			$sql	="update SIMTAX_BEBANLAIN_PPH_BADAN 
						 set KODE_AKUN = '".$inpAccount."',
							 AKUN_DESCRIPTION = '".$inpDescription."',
							 AMOUNT = '".$inpAmount."',
							 KOREKSI_DEDUCTIBLE = '".$inpDeductible."',
							 KOREKSI_NONDEDUCTIBLE = '".$inpNonDeductible."',
							 IS_DEDUCTIBLE = '".$inpIsDeductible."',
							 TAHUN_PAJAK = '".$inpTahun."',							 
							 UPDATE_DATE = sysdate,
							 UPDATE_BY = '".$user_name."'
					   where BEBAN_LAIN_ID = '".$DocId."'	
					 ";
		}
		
		$query	= $this->db->query($sql);	
		
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	

	function do_save_fiskal()
	{
		$isNewRecord        = $this->input->post('isNewRecord'); //flag insert(1) atau update(null atau 0)	
		$inpAccount        	= $this->input->post('inpAccount'); 
		$inpDescription		= $this->input->post('inpDescription');
		$inpKodeJasa        = $this->input->post('inpKodeJasa'); 
		$inpDescriptionKodejasa		= $this->input->post('inpDescriptionKodejasa');
		$inpCheckList		= $this->input->post('inpCheckList');
		$inpPositif			= $this->input->post('inpPositif');
		$inpNegatif			= $this->input->post('inpNegatif');
		$inpTahun			= $this->input->post('inpTahun');
		$inpBulan			= $this->input->post('inpBulan');
		$nKomersial			= $this->input->post('nilaiKomersial');
		$nFiskal			= $this->input->post('nilaiFiskal');
		$DocId				= $this->input->post('DocId');
		
				
		//$kode_cabang 	= $this->session->userdata('kd_cabang');
		$user_name 		= $this->session->userdata('identity');
			
		if ($isNewRecord) {		
			$sql	="insert into SIMTAX_FISKAL_PPH_BADAN
					 (KOREKSI_FISKAL_ID
					 ,KODE_AKUN
					 ,AKUN_DESCRIPTION
					 ,KODE_JASA
					 ,KODE_JASA_DESCRIPTION
					 ,AMOUNT_POSITIF
					 ,AMOUNT_NEGATIF
					 ,CHECKLIST
					 ,CREATION_DATE
					 ,TAHUN_PAJAK
					 ,BULAN_PAJAK
					 ,CREATED_BY) 
					 VALUES
					 (SIMTAX_FISKAL_PPH_BADAN_S.nextval,
					 '".$inpAccount."',
					 '".$inpDescription."',
					 '".$inpKodeJasa."',
					 '".$inpDescriptionKodejasa."',
					 '".$inpPositif."',
					 '".$inpNegatif."',
					 '".$inpCheckList."',
					 sysdate,
					 '".$inpTahun."',
					 '".$inpBulan."',
					 '".$user_name."')";
		} else {
			$sql	="update SIMTAX_FISKAL_PPH_BADAN 
						 set KODE_AKUN = '".$inpAccount."',
							 AKUN_DESCRIPTION = '".$inpDescription."',
							 KODE_JASA = '".$inpKodeJasa."',
							 KODE_JASA_DESCRIPTION = '".$inpDescriptionKodejasa."',
							 AMOUNT_POSITIF = '".$inpPositif."',
							 AMOUNT_NEGATIF = '".$inpNegatif."',
							 CHECKLIST = '".$inpCheckList."',
							 TAHUN_PAJAK = '".$inpTahun."',							 
							 BULAN_PAJAK = '".$inpBulan."',
							 NILAI_KOMERSIAL = '".$nKomersial."',
							 NILAI_FISKAL = '".$nFiskal."',							 
							 UPDATE_DATE = sysdate,
							 UPDATE_BY = '".$user_name."'
					   where KOREKSI_FISKAL_ID = '".$DocId."'	
					 ";
		}
		$query	= $this->db->query($sql);	
		
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	
	
	function do_save_debit_credit()
	{
		$inpDebit   = $this->input->post('inpDebit'); //flag insert(1) atau update(null atau 0)	
		$inpCredit  = $this->input->post('inpCredit'); 
		$beban_id	= $this->input->post('beban_id');

		$user_name 		= $this->session->userdata('identity');
			

			$sql	="update simtax_rincian_bl_pph_badan 
						 set DEBIT = '".$inpDebit."',
							 CREDIT = '".$inpCredit."',						 
							 UPDATE_DATE = sysdate,
							 UPDATE_BY = '".$user_name."'
					   where BEBAN_LAIN_ID = '".$beban_id."'	
					 ";
		
		$query	= $this->db->query($sql);	
		
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	
	
	function do_delete_url_doc()
	{
		$UrlDocId   = $this->input->post('UrlDocId');
		
		$sql	="DELETE FROM simtax_url_cloud_doc where URL_DOC_ID ='".$UrlDocId."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	
	
	function do_delete_beban_lain()
	{
		$DocId   = $this->input->post('DocId');
		
		$sql	="DELETE FROM SIMTAX_BEBANLAIN_PPH_BADAN where BEBAN_LAIN_ID ='".$DocId."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	

	function do_delete_fiskal()
	{
		$DocId   = $this->input->post('DocId');
		
		$sql	="DELETE FROM SIMTAX_FISKAL_PPH_BADAN where KOREKSI_FISKAL_ID ='".$DocId."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	
	
	function set_rincian_bl()
	{
		$idPajakLines  	= $this->input->post('line_id');
		$ischeck	   	= $this->input->post('ischeck');
		
		$sql	="UPDATE simtax_rincian_bl_pph_badan
					 set CHECKLIST='".$ischeck."',
					     UPDATE_DATE = sysdate
				   where BEBAN_LAIN_ID ='".$idPajakLines."'"; 
				     
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}		
	}

	function action_save_pph_badan()
	{
		$cabang				= $this->session->userdata('kd_cabang');
		$user				= $this->session->userdata('identity');
		$id 				= $this->input->post('idbupot');
		$nobupot        	= $this->input->post('nobupot');
		$jnspenghasilan	   	= $this->input->post('jnspenghasilan');
		$objpemotong	  	= str_replace(',','',$this->input->post('objpemotong'));
		$pphdipotong	  	= str_replace(',','',$this->input->post('pphdipotong'));
		$npwp	            = $this->input->post('npwp');
		$tglpemotong		= $this->input->post('tglpemotong');
		$alamat	            = $this->input->post('alamat');
		$kdmap	    		= $this->input->post('kdmap');
		$ntpp	    		= $this->input->post('ntpp');
		$jumlah	    		= str_replace(',','',$this->input->post('jumlah'));
		$tglsetor	    	= $this->input->post('tglsetor');
		$jpph	    		= $this->input->post('jpph');
		$cbayar	    		= $this->input->post('cbayar');
		$npemotong	    	= $this->input->post('npemotong');
		
		//$masa_pajak			= $this->getMonth($addBulan);
		$date				= date("Y-m-d H:i:s");
				
			  $sql	="Update simtax_ubupot_ph_lain set NAMA_PAJAK='".$jpph."',CARA_PEMBAYARAN='".$cbayar."',NO_BUKTI_POTONG='".$nobupot."',JENIS_PENGHASILAN='".$jnspenghasilan."', DPP='".$objpemotong."', JUMLAH_POTONG='".$pphdipotong."', NPWP='".$npwp."', TGL_BUKTI_POTONG=TO_DATE('".$tglpemotong."','dd-mm-yyyy hh24:mi:ss'),ALAMAT_WP='".$alamat."',KODE_MAP='".$kdmap."',NTPP='".$ntpp."',JUMLAH_PEMBAYARAN='".$jumlah."',TANGGAL_SETOR=TO_DATE('".$tglsetor."','dd-mm-yyyy hh24:mi:ss'),NAMA_WP='".$npemotong."'
			  where BUKTI_POTONG_ID ='".$id."'";
		//return $sql;
		$query	= $this->db->query($sql);		
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}

	function action_delete_pph_badan()
	{
		$id 				= $this->input->post('idbupot');
		
		$sql	="DELETE FROM simtax_ubupot_ph_lain where BUKTI_POTONG_ID ='".$id."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}	
	
	function get_rekening7($bulan="",$tahun="")
	{
		$queryExec_tujuh	= " select srbpb_grp.*
								 , sfpb_grp.AMOUNT_POSITIF
								 , sfpb_grp.AMOUNT_NEGATIF
								 , nvl(srbpb_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(srbpb_grp.kode_akun,srbpb_grp.kode_jasa,'".$tahun."',srbpb_grp.bulan_pajak) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 --, abs(sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) jml_uraian
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '0' then srbpb.debit
										   else 0
										   end) DEDUCTIBLE 
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '1' then srbpb.debit
										   else 0
										   end) NON_DEDUCTIBLE
                                         , srbpb.kode_jasa
                                         , srbpb.jasa_description  
										 , decode('".$bulan."','',0,srbpb.bulan_pajak) bulan_pajak
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak = '".$tahun."'
									  and decode('".$bulan."','',0,srbpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
									  and kode_akun like '7%'
									  and kode_akun not like '791%'
									  and kode_jasa is not null
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, srbpb.kode_jasa, srbpb.jasa_description, decode('".$bulan."','',0,srbpb.bulan_pajak)) srbpb_grp
								 , (select kode_akun,kode_jasa,kode_jasa_description
                                         , sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
                                         , decode('".$bulan."','',0,sfpb.bulan_pajak) bulan_pajak
                                      from SIMTAX_FISKAL_PPH_BADAN sfpb
                                     where sfpb.tahun_pajak = '".$tahun."'
                                       and kode_akun like '7%'
									   and kode_akun not like '791%'
                                       and decode('".$bulan."','',0,sfpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
                                       and kode_jasa is not null
                                  group by kode_akun,kode_jasa,kode_jasa_description, tahun_pajak, decode('".$bulan."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							  and srbpb_grp.kode_jasa = sfpb_grp.kode_jasa (+)
							  and srbpb_grp.bulan_pajak = sfpb_grp.bulan_pajak (+)
							order by srbpb_grp.kode_akun, srbpb_grp.kode_jasa
							";								
			
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}
	
	function get_parent_rekening7($akun)
	{
		$sql_parent = " select ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ffv.FLEX_VALUE like '".$akun."'||'%000'";
		
		$qParent     	= $this->db->query($sql_parent);
		return $qParent;
		
	}
	
	function get_parent_rekening7_2($akun)
	{
		$sql_parent = " select ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ffv.FLEX_VALUE like '".substr($akun,0,3)."'||'%000'";
						  
		$qParent     	= $this->db->query($sql_parent);		
		
		return $qParent;
	}
	
	function get_rekening8($bulan,$tahun)
	{
	$queryExec	= " select srbpb_grp.*
								 , nvl(nvl(NON_DEDUCTIBLE,sfpb_grp.AMOUNT_POSITIF),0) AMOUNT_POSITIF
								 , sfpb_grp.AMOUNT_NEGATIF
								 , nvl(srbpb_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBal(srbpb_grp.kode_akun,'".$tahun."',srbpb_grp.bulan_pajak) - nvl(NON_DEDUCTIBLE,nvl(sfpb_grp.AMOUNT_POSITIF,0)) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 --, abs(sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) jml_uraian
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '0' then srbpb.debit
										   else NULL
										   end) DEDUCTIBLE 
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '1' then srbpb.debit
										   else NULL
										   end) NON_DEDUCTIBLE,
										   decode('".$bulan."','',0,srbpb.bulan_pajak) bulan_pajak
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak = '".$tahun."'
									  and decode('".$bulan."','',0,srbpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
									  and kode_akun like '8%'
									  and kode_akun not like '891%'
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, decode('".$bulan."','',0,srbpb.bulan_pajak)) srbpb_grp
								 , (select kode_akun, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak, decode('".$bulan."','',0, sfpb.bulan_pajak) bulan_pajak
									  from SIMTAX_FISKAL_PPH_BADAN sfpb
									 where sfpb.tahun_pajak = '".$tahun."'
									   and kode_akun like '8%'
									   and kode_akun not like '891%'
									   and bulan_pajak is not null
									   and decode('".$bulan."','',0,sfpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
								 group by kode_akun,tahun_pajak, decode('".$bulan."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							  and srbpb_grp.bulan_pajak = sfpb_grp.bulan_pajak (+)
							order by srbpb_grp.kode_akun
							";								
			$query 		= $this->db->query($queryExec);
			return $query;
	}	

	function get_rekening791($bulan,$tahun)
	{
		$queryExec	= " select srbpb_grp.*
								 , nvl(nvl(NON_DEDUCTIBLE,sfpb_grp.AMOUNT_POSITIF),0) AMOUNT_POSITIF
								 , sfpb_grp.AMOUNT_NEGATIF
								 , nvl(srbpb_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBal(srbpb_grp.kode_akun,'".$tahun."',srbpb_grp.bulan_pajak) - nvl(NON_DEDUCTIBLE,nvl(sfpb_grp.AMOUNT_POSITIF,0)) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 --, abs(sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) jml_uraian
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '0' then srbpb.debit
										   else NULL
										   end) DEDUCTIBLE 
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '1' then srbpb.debit
										   else NULL
										   end) NON_DEDUCTIBLE,
										   decode('".$bulan."','',0,srbpb.bulan_pajak) bulan_pajak
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak = '".$tahun."'
									  and decode('".$bulan."','',0,srbpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
									  and kode_akun like '791%'
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, decode('".$bulan."','',0,srbpb.bulan_pajak)) srbpb_grp
								 , (select kode_akun, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak, decode('".$bulan."','',0, sfpb.bulan_pajak) bulan_pajak
									  from SIMTAX_FISKAL_PPH_BADAN sfpb
									 where sfpb.tahun_pajak = '".$tahun."'
									   and kode_akun like '791%'
									   and bulan_pajak is not null
									   and decode('".$bulan."','',0,sfpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
								 group by kode_akun,tahun_pajak, decode('".$bulan."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							  and srbpb_grp.bulan_pajak = sfpb_grp.bulan_pajak (+)
							order by srbpb_grp.kode_akun
							";		
			$query 		= $this->db->query($queryExec);
			return $query;
	}	
	
	function get_rekening891($bulan,$tahun)
	{
		$queryExec	= " select srbpb_grp.*
								 , nvl(nvl(NON_DEDUCTIBLE,sfpb_grp.AMOUNT_POSITIF),0) AMOUNT_POSITIF
								 , sfpb_grp.AMOUNT_NEGATIF
								 , nvl(srbpb_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBal(srbpb_grp.kode_akun,'".$tahun."',srbpb_grp.bulan_pajak) - nvl(NON_DEDUCTIBLE,nvl(sfpb_grp.AMOUNT_POSITIF,0)) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 --, abs(sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) jml_uraian
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '0' then srbpb.debit
										   else NULL
										   end) DEDUCTIBLE 
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '1' then srbpb.debit
										   else NULL
										   end) NON_DEDUCTIBLE,
										   decode('".$bulan."','',0,srbpb.bulan_pajak) bulan_pajak
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak = '".$tahun."'
									  and decode('".$bulan."','',0,srbpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
									  and kode_akun like '891%'
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, decode('".$bulan."','',0,srbpb.bulan_pajak)) srbpb_grp
								 , (select kode_akun, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak, decode('".$bulan."','',0, sfpb.bulan_pajak) bulan_pajak
									  from SIMTAX_FISKAL_PPH_BADAN sfpb
									 where sfpb.tahun_pajak = '".$tahun."'
									   and kode_akun like '891%'
									   and bulan_pajak is not null
									   and decode('".$bulan."','',0,sfpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
								 group by kode_akun,tahun_pajak, decode('".$bulan."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							  and srbpb_grp.bulan_pajak = sfpb_grp.bulan_pajak (+)
							order by srbpb_grp.kode_akun
							";			
			$query 		= $this->db->query($queryExec);
			return $query;
	}	
	
	function get_pph_badan($bulan,$tahun,$pajak)
	{
		
		$where = " and nama_pajak='".$pajak."' and tahun_pajak=".$tahun;
				if ($bulan) {
					$where .= " and masa_pajak='".$bulan."' ";
				}
		
		$sql_22 = " select nama_pajak, nvl(sum(jumlah_potong),0) jumlah 
						from simtax_ubupot_ph_lain where 1=1 
						".$where."
						group by nama_pajak ";
		$q   	= $this->db->query($sql_22);
		return $q;
		
	}
	
	function action_get_period()
	{
		$tahun		= $this->input->post('tahun');					
		$queryExec	= "Select NAMA_PAJAK, TAHUN_PAJAK from SIMTAX_UBUPOT_PH_LAIN 					
					   where tahun_pajak ='".$tahun."' ";
		//return $queryExec;
		$query = $this->db->query($queryExec);   
		if($query){			
			return true;
		} else {
			return false;
		}		
	}

	function get_bupot_lain_report()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= " ";
		
		$tahun = "";
		$bulan = "";

		if($_POST['_searchbulan']){
			//$where	.= " and a.masa_pajak=".$_POST['_searchbulan']." ";
			$bulan = $_POST['_searchbulan'];
			$bulan = str_pad($bulan,2,"0",STR_PAD_LEFT);
			$wbln = "and masa_pajak= '".$bulan."'";
		} else {
			$wbln ="";
		}
		
		if($_POST['_searchTahun']){
			//$where	.= " and a.tahun_pajak=".$_POST['_searchTahun']." ";
			$tahun = $_POST['_searchTahun'];
		}
		
		if(isset($_POST['_searchCabang']) && $_POST['_searchCabang']){
			$where	.= " and a.kode_cabang=".$_POST['_searchCabang']." ";
		}
		
		if($q) {
			$where	.= " and a.nama_cabang like '%".$q."%' ";
		}
				
		$queryExec	= "select nama_cabang,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a1
			 left join simtax_kode_cabang z
			  on z.kode_cabang = a1.kode_cabang
			  where z.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a1.nama_pajak = '22'
		) as pph22,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a2
			 left join simtax_kode_cabang y
			  on y.kode_cabang = a2.kode_cabang
			  where y.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a2.nama_pajak = '23'
		) as pph23,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a3
			 left join simtax_kode_cabang x
			  on x.kode_cabang = a3.kode_cabang
			  where x.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a3.nama_pajak = '25'
		) as pph25
		from simtax_kode_cabang a
		where aktif ='Y'
		".$where;	

		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);		
		$rowCount	= $query2->num_rows();
		
		//$queryExec	.= " order by a.nama_pajak, a.BUKTI_POTONG_ID";
		
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;		
	}	

	function get_total_report_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->session->userdata('kd_cabang');		
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		
		$where	= "";	
			
		
		if($_POST['_searchbulan']){
			$where	.= " and masa_pajak=".$_POST['_searchbulan']." ";
		}
		
		if($_POST['_searchTahun']){
			$where	.= " and tahun_pajak=".$_POST['_searchTahun']." ";
		}
		
		if(isset($_POST['_searchCabang']) && $_POST['_searchCabang']){
			$where	.= " and kode_cabang='".$_POST['_searchCabang']."' ";
		}		
		
				
		$queryExec	= "select nvl(sum(pph22),0) totalpph22, nvl(sum(pph23),0) totalpph23,  nvl(sum(pph25),0) totalpph25
						from
						(
								select a.kode_cabang, a.masa_pajak, a.tahun_pajak,
								(
									select nvl(sum(jumlah_potong),0)
									from simtax_ubupot_ph_lain z
									where z.bukti_potong_id = a.bukti_potong_id
									and nama_pajak = '22'
								) as pph22,
								(
								select nvl(sum(jumlah_potong),0) 
									from simtax_ubupot_ph_lain x
									where x.bukti_potong_id = a.bukti_potong_id
									and nama_pajak = '23'
								) as pph23,
								(
									select nvl(sum(jumlah_potong),0)
									from simtax_ubupot_ph_lain y
									where y.bukti_potong_id = a.bukti_potong_id
									and nama_pajak = '25'
								) as pph25
								from simtax_ubupot_ph_lain a
						)
						where 1=1
						".$where;			
		$query 		= $this->db->query($queryExec);			
		return $query;		
	}

	function cek_ledger_excel($ledger,$bln="",$thn="",$cab="",$akun="")
	{
		$where = "";
		if($ledger){
			$where = " and ledger_id='".$ledger."' ";
		}	
		
		if($akun){
			$where = " and kode_akun='".$akun."' ";
		}
		
		if($bln && $bln!=0){
			$where	.= " and bulan_pajak=".$bln." ";
		}
		
		if($thn){
			$where	.= " and tahun_pajak=".$thn." ";
		}
		
		if((isset($cab) && $cab) && $cab != "all"){
			$where	.= " and kode_cabang='".$cab."' ";
		}		
		
		$sql	="Select ledger_id from SIMTAX_RINCIAN_BL_PPH_BADAN where 1=1 ".$where." and rownum=1";
		$query 		= $this->db->query($sql);
		if ($query->num_rows()>0){
			return 1; //ada
		} else {
			return 0; //tdk ada
		}
	}

	function get_data_bl_excel()
	{
		$ledger   	= ($_REQUEST['ledger'])? strtoupper($_REQUEST['ledger']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
		$cab	   	= $_REQUEST['cab'];
		$akun	   	= $_REQUEST['akun'];
		$where		= " ";
		
		if($ledger){
			$where	.= " and ledger_id='".$ledger."'";
		}

		if($akun){
			$where	.= " and kode_akun='".$akun."'";
		}
		
		if($bulan && $bulan!=0){
			$where	.= " and bulan_pajak=".$bulan." ";
		}
		
		if($tahun){
			$where	.= " and tahun_pajak=".$tahun." ";
		}
		
		if((isset($cab) && $cab) && $cab != "all"){
			$where	.= " and kode_cabang='".$cab."' ";
		}		
		
		$sql	= "select kode_akun, akun_description
					, uraian
					, nomor_bukti
					, tgl_bukti
					, debit jml_uraian
					, case  when CHECKLIST = '0' then debit else 0 end as DEDUCTIBLE
					, case  when CHECKLIST = '1' then debit else 0 end as NON_DEDUCTIBLE 
					from SIMTAX_RINCIAN_BL_PPH_BADAN
					where 1=1 and debit is not null
					and kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
					'80108061', '89199999', '80106999', '80108999') 
					   ".$where."
					   order by kode_akun ";	
						//kode_akun in ('80102191', '80105999', '80106999', '80107999', '80108041', '80108061', 
						//'80108999', '89199999', '80107107', '80108999') 					
		$query = $this->db->query($sql);
		if ($query){
			return $query;
		} else {
			return false;
		}
		
	}

	function cek_tahun_report_bupot($bln="",$thn="",$cab="")
	{
		$where = "";		
		
		if($bln && $bln!=0){
			$where	.= " and masa_pajak=".$bln." ";
		}
		
		if($thn){
			$where	.= " and tahun_pajak=".$thn." ";
		}
		
		if(isset($cab) && $cab){
			$where	.= " and kode_cabang='".$cab."' ";
		}		

		$table = "SIMTAX_UBUPOT_PH_LAIN";

		
		$sql	="Select tahun_pajak from ".$table." where 1=1 ".$where." and rownum=1";
		$query 		= $this->db->query($sql);
		if ($query->num_rows()>0){
			return 1; //ada
		} else {
			return 0; //tdk ada
		}
	}
	
	
	function get_report_bupot_excel()
	{
		$tahun = "";
		$bulan = "";
	
        //$bulan   	= $_REQUEST['month'];
        //$tahun   	= $_REQUEST['year'];
        //$cab	   	= $_REQUEST['cab'];
		$where		= " ";

		if($_REQUEST['month']){
			//$where	.= " and a.masa_pajak=".$_POST['_searchbulan']." ";
			$bulan = $_REQUEST['month'];
			$bulan = str_pad($bulan,2,"0",STR_PAD_LEFT);
			$wbln = "and masa_pajak= '".$bulan."'";
		} else {
			$wbln ="";
		}
		
		if($_REQUEST['year']){
			//$where	.= " and a.tahun_pajak=".$_POST['_searchTahun']." ";
			$tahun = $_REQUEST['year'];
		}
		
		if($_REQUEST['cab']){
			$where	.= " and a.kode_cabang=".$_REQUEST['cab']." ";
		}	
		
		$sql	= "select nama_cabang,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a1
			 left join simtax_kode_cabang z
			  on z.kode_cabang = a1.kode_cabang
			  where z.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a1.nama_pajak = '22'
		) as pph22,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a2
			 left join simtax_kode_cabang y
			  on y.kode_cabang = a2.kode_cabang
			  where y.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a2.nama_pajak = '23'
		) as pph23,
		(
			select nvl(sum(jumlah_potong),0) 
			 from simtax_ubupot_ph_lain a3
			 left join simtax_kode_cabang x
			  on x.kode_cabang = a3.kode_cabang
			  where x.kode_cabang = a.kode_cabang
			  and tahun_pajak= '".$tahun."'
			  ".$wbln."
			  and a3.nama_pajak = '25'
		) as pph25
		from simtax_kode_cabang a
		where aktif ='Y'
					   ".$where."
						order by kode_cabang";	
		$query = $this->db->query($sql);
		if ($query){
			return $query;
		} else {
			return false;
		}
		
	}

	//Cek apakah sudah di generate
	function is_process_kf_tb78()
	{
		$tahun   = $this->input->post('inpTahun');
		$bulan   = $this->input->post('inpBulan');
		$query = $this->db->query("select * from simtax_fiskal_pph_badan
		where tahun_pajak = ".$tahun."
		and bulan_pajak = ".$bulan);
		$rescnt = $query->num_rows();
		if ($rescnt > 0){
			return true;
			
		} else {
			return false;
			
		}
	}
	//End Cek

	//proses data tb ke simtax fiskal akun 78
	function do_process_kf_tb78()
	{
		$tahun   = $this->input->post('inpTahun');
		$bulan   = $this->input->post('inpBulan');
		$user_name 		= $this->session->userdata('identity');
		$cabang	= $this->session->userdata('kd_cabang');
		
		$this->db->trans_begin();

		$this->db->query("insert into simtax_fiskal_pph_badan (kode_akun,akun_description,nilai_komersial,tahun_pajak,bulan_pajak,creation_date,created_by,kode_cabang)
		select coa, coa_desc, nilaikomersial, period_year, period_num, sysdate, created_by, kode_cabang
		from (
		select distinct coa,coa_desc,
		(
		select distinct abs(nvl(sum(nvl(a.begin_balance_dr,0) - nvl(a.begin_balance_cr,0)),0) + nvl(sum(nvl(a.period_net_dr,0) - nvl(a.period_net_cr,0)),0))
		from simtax_tb_v a
		where a.coa = z.coa
		and period_num = ".$bulan."
		and period_year = ".$tahun."
		) nilaikomersial,
		period_year,
		period_num,
		sysdate,
		'".$user_name."' as created_by,
		'".$cabang."' as kode_cabang
		from simtax_tb_v z
		where coa 
		like '7%'
		and period_num = ".$bulan."
		and period_year = ".$tahun."
		and branch_code = ".$cabang."
		) where nilaikomersial <> 0");

		$this->db->query("insert into simtax_fiskal_pph_badan (kode_akun,akun_description,nilai_komersial,tahun_pajak,bulan_pajak,creation_date,created_by,kode_cabang)
		select coa, coa_desc, nilaikomersial, period_year, period_num, sysdate, created_by, kode_cabang
		from (
		select distinct coa,coa_desc,
		(
		select distinct abs(nvl(sum(nvl(a.begin_balance_dr,0) - nvl(a.begin_balance_cr,0)),0) + nvl(sum(nvl(a.period_net_dr,0) - nvl(a.period_net_cr,0)),0)) 
		from simtax_tb_v a
		where a.coa = z.coa
		and period_num = ".$bulan."
		and period_year = ".$tahun."
		) nilaikomersial,
		period_year,
		period_num,
		sysdate,
		'".$user_name."' as created_by,
		'".$cabang."' as kode_cabang
		from simtax_tb_v z
		where coa 
		like '8%'
		and period_num = ".$bulan."
		and period_year = ".$tahun."
		and branch_code = ".$cabang."
		) where nilaikomersial <> 0");

		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
				return true;
		}

	}

	// end proses tb ke simtax fiskal akun 78
	
}