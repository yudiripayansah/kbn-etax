<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Ppn_masa_mdl extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Master_mdl');
		    
    }

	/* General */

	function get_period_by_id($period_id){
		
		$this->db->select('PERIOD_ID, STATUS');
		$this->db->from('SIMTAX_MASTER_PERIOD');
		$this->db->where('PERIOD_ID', $period_id);
		$query = $this->db->get();
		
		return $query->row();
	}

	function get_pajak_header_id($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke=""){

    	$this->db->select('PAJAK_HEADER_ID, PERIOD_ID');
		$this->db->from('SIMTAX_PAJAK_HEADERS');
		if($kode_cabang != ""){
			$this->db->where('KODE_CABANG', $kode_cabang);
		}
		if($pembetulan_ke != ""){
			$this->db->where('PEMBETULAN_KE', $pembetulan_ke);
		}
		$this->db->where('NAMA_PAJAK', $nama_pajak);
		$this->db->where('BULAN_PAJAK', $bulan_pajak);
		$this->db->where('TAHUN_PAJAK', $tahun_pajak);

		$query = $this->db->get();

		if($kode_cabang != ""){
			return $query->row();
		}
		else{
			return $query->result_array();
		}
	}

	function get_data_header($pajak_header_id){

    	$this->db->select('*');
		$this->db->from('SIMTAX_PAJAK_HEADERS');
		$this->db->where('PAJAK_HEADER_ID', $pajak_header_id);

		$query = $this->db->get();

		return $query->row();
		
	}

	function get_header_id_max($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak){

		$sql 	= "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID
					FROM SIMTAX_PAJAK_HEADERS
								WHERE KODE_CABANG = '".$kode_cabang."'
								AND BULAN_PAJAK   = '".$bulan_pajak."'
								AND tahun_pajak   = '".$tahun_pajak."'
								AND NAMA_PAJAK    = '".$nama_pajak."'";

		$query  = $this->db->query($sql);
		$row    = $query->row();
		$header = $row->PAJAK_HEADER_ID;

		if ($query){
			return $header;
		} else {
			return false;
		}
		$query->free_result();
	}

	function get_pajak_lines($pajak_header_id){

		$mainQuery	= "SELECT DISTINCT SPL.PAJAK_LINE_ID XXX, SPL.*, 
						NVL(NVL(SMS.VENDOR_NAME,SMPEL.CUSTOMER_NAME),SPL.NAMA_WP) VENDOR_NAME,
						-- NVL(NVL(SPL.NAMA_WP,SMPEL.CUSTOMER_NAME),SMS.VENDOR_NAME) VENDOR_NAME,
						NVL(NVL(SMS.NPWP,SMPEL.NPWP),SPL.NPWP) NPWP1,
						-- NVL(NVL(SPL.NPWP,SMPEL.NPWP),SMS.NPWP) NPWP1,
						NVL(NVL(SMS.ADDRESS_LINE1,SMPEL.ADDRESS_LINE1),SPL.ALAMAT_WP)ADDRESS_LINE1
						-- NVL(NVL(SPL.ALAMAT_WP,SMPEL.ADDRESS_LINE1),SMS.ADDRESS_LINE1)ADDRESS_LINE1
						FROM SIMTAX_PAJAK_LINES SPL 
						INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					   LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
					          ON SMS.VENDOR_ID = SPL.VENDOR_ID
					         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
                             AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
					   LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
					          ON SMPEL.CUSTOMER_ID = SPL.CUSTOMER_ID
					         AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                             AND SPL.vendor_site_id = SMPEL.customer_site_id
						INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
						WHERE SPL.PAJAK_HEADER_ID = '".$pajak_header_id."'
						AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR'))
						AND UPPER(SMP.STATUS) = 'OPEN'
						AND SPL.IS_CHEKLIST = '1'
						ORDER BY SPL.INVOICE_NUM DESC";

		$query = $this->db->query($mainQuery);

		return $query->result();
	}

	function save_z_percent($bulan_pajak, $tahun_pajak, $terutang_ppn, $tidak_terutang, $terutang_tidak_terutang, $z_percent){

		$tahun_pajak2 = $tahun_pajak+1;

		if($bulan_pajak <= 2){
			$case ="";
		}
		else{
			$case = " or (case
                                            when tahun = ".$tahun_pajak." and bulan >= 3 then 1
                                            when tahun = ".$tahun_pajak2." and bulan <= 2 then 1
                                            else 0 end = 1)";
		}

		$get_all_greater = "SELECT id, bulan, tahun from simtax_z_percent
                                where  ( tahun = ".$tahun_pajak." and bulan = ".$bulan_pajak.")
                                ".$case."
                                order by tahun, bulan";
		                      
		$query    = $this->db->query($get_all_greater);

		$all_greater = $query->result_array();
		$arrId = array();
		foreach ($all_greater as $key => $value) {

			$arrId[] = $value['ID'];
		}

    $all_id = implode(",", $arrId);
    if ($all_id != '') {
      $sql = "UPDATE SIMTAX_Z_PERCENT SET NILAI = ".$z_percent.",
                        TERUTANG_PPN = ".$terutang_ppn.",
                        TIDAK_TERUTANG = ".$tidak_terutang.",
                        TIDAK_TERUTANG2 = ".$terutang_tidak_terutang."
                        where ID in (".$all_id.") ";
	
      $upd = $this->db->query($sql);

      if($upd){
        foreach ($arrId as $key => $value) {
          $param = $value;
          simtax_update_history("SIMTAX_Z_PERCENT", "UPDATE", $param);
        }
        return true;
      }
    } else {
      return false;
    }		
	}

	function update_line($id, $data){

		$this->db->where('PAJAK_LINE_ID', $id);

		$update = $this->db->update("SIMTAX_PAJAK_LINES", $data);

		if($update){
			$param = array("PAJAK_LINE_ID" => $id);
			simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $param);
			return true;
		}
		else{
			return false;
		}
	}

	function get_pajak_lines_by_id($id){

    	$this->db->select('*');
		$this->db->from('SIMTAX_PAJAK_LINES'); 
		$this->db->where('PAJAK_LINE_ID', $id);

		$query = $this->db->get();

		return $query->row();
	}
	

	function get_master_wp($kode_cabang, $nama_pajak)
	{
		$q           = (isset($_POST['search']['value']))?$_POST['search']['value']:'';
		$where       = "";
		$whereSearch = "";
		$keywords    = strtoupper($q);
		$og_id       = get_og_id($kode_cabang);
		$where       = " where organization_id = '".$og_id."'";

		if($nama_pajak == "PPN MASUKAN"){

			if($keywords) { 
				$whereSearch = " and upper(vendor_name) like '%".$keywords."%' or upper(address_line1) like '%".$keywords."%' or  npwp like '%".$keywords."%' ";
			}

			$queryExec	= "SELECT vendor_id, organization_id, vendor_site_id, vendor_name, npwp, address_line1
							from simtax_master_supplier ".$where.$whereSearch." order by vendor_id DESC";
			
			$sql		="SELECT * FROM (
							SELECT rownum rnum, a.* 
							FROM(
								".$queryExec."
							) a 
							WHERE rownum <=".$_POST['start']."+".$_POST['length']."
						)
						WHERE rnum >".$_POST['start']."";

		}
		else{

			if($keywords) { 
				$whereSearch = " and upper(customer_name) like '%".$keywords."%' or upper(address_line1) like '%".$keywords."%' or  npwp like '%".$keywords."%' ";
			}

			$queryExec	= "SELECT customer_id, organization_id, customer_site_id, customer_name, npwp, address_line1
							from simtax_master_pelanggan ".$where.$whereSearch." order by customer_id DESC";
			
			$sql		="SELECT * FROM (
							SELECT rownum rnum, a.* 
							FROM(
								".$queryExec."
							) a 
							WHERE rownum <=".$_POST['start']."+".$_POST['length']."
						)
						WHERE rnum >".$_POST['start']."";

		}
		
		$sql2		= $queryExec;	  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows() ;
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}

	function get_cabang_in_header($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke){

		$andCab = "";
		if($kode_cabang != ""){
			$andCab = " AND KODE_CABANG = '".$kode_cabang."'";
		}

		$sql = "SELECT DISTINCT kode_cabang FROM SIMTAX_PAJAK_HEADERS
						where nama_pajak = '".$nama_pajak."'
						AND bulan_pajak = '".$bulan_pajak."'
						AND tahun_pajak = '".$tahun_pajak."'
						AND pembetulan_ke = '".$pembetulan_ke."'".$andCab;

		$query = $this->db->query($sql);

		return $query->result();
	}


	/* Rekonsiliasi */
	function get_rekonsiliasi($pajak_header_id, $nama_pajak, $category="", $where_condition=true, $start, $length, $keywords, $orderby)
	{
		ini_set('memory_limit', '-1');
		$where         = "";
		$whereCategory = "";

		if($category == "dokumen_lain"){
			$whereCategory = " AND SPL.DL_FS = '".$category."'";
		}
		else{
			$whereCategory = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = '".$category."')";
		}

		$where_conditionString = "";

		if($where_condition == true){
			$where_conditionString = " AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')
										AND UPPER(SMP.STATUS) = 'OPEN' ";
		}

		if($orderby){
			$order = " ORDER BY SPL.".$orderby[0]." ".$orderby[1];
		}else{
			$order = " ORDER BY SPL.INVOICE_NUM DESC";
		}

		if($nama_pajak == "PPN MASUKAN"){
			$jml_ppn = " SPL.JUMLAH_POTONG * -1 JUMLAH_POTONG_PPN";
			$nvl_wp  = "NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMS.NPWP,SPL.NPWP) NPWP1,
						NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
						SPL.VENDOR_ID VENDOR_ID1,";
			$q_wp    = "OR UPPER(SMS.VENDOR_NAME)";
			$alias   = "SMS";
			$join    = "LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
							ON SMS.VENDOR_ID        = SPL.VENDOR_ID
							AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SMS.VENDOR_SITE_ID  = SPL.VENDOR_SITE_ID";
		}
		else{
			$jml_ppn = " SPL.JUMLAH_POTONG JUMLAH_POTONG_PPN";
			$nvl_wp  = "NVL(SPL.NAMA_WP, SMPEL.CUSTOMER_NAME) VENDOR_NAME,
						NVL(SPL.NPWP, SMPEL.NPWP) NPWP1,
						NVL(SPL.ALAMAT_WP, SMPEL.ADDRESS_LINE1) ADDRESS_LINE1,
						SPL.CUSTOMER_ID VENDOR_ID1,";
			/*$nvl_wp  = "NVL(SMPEL.CUSTOMER_NAME, SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMPEL.NPWP, SPL.NPWP) NPWP1,
						NVL(SMPEL.ADDRESS_LINE1, SPL.ALAMAT_WP) ADDRESS_LINE1,
						SPL.CUSTOMER_ID VENDOR_ID1,";*/
			$q_wp    = "OR UPPER(SMPEL.CUSTOMER_NAME)";
			$alias   = "SMPEL";
			$join    = "LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
							ON SMPEL.CUSTOMER_ID      = SPL.CUSTOMER_ID
							AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SPL.vendor_site_id    = SMPEL.customer_site_id";

		}

		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND (
						UPPER(SPL.NO_FAKTUR_PAJAK) LIKE '%".$q."%'
						OR UPPER(SPL.NO_DOKUMEN_LAIN) LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_NUM) LIKE '%".$q."%'
						".$q_wp." LIKE '%".$q."%'
						OR UPPER(".$alias.".NPWP) LIKE '%".$q."%'
						OR UPPER(".$alias.".ADDRESS_LINE1) LIKE '%".$q."%'
						OR UPPER(SPL.NAMA_WP) LIKE '%".$q."%'
						OR UPPER(SPL.NPWP) LIKE '%".$q."%'
						OR UPPER(SPL.ALAMAT_WP) LIKE '%".$q."%'
						OR UPPER(SPL.AKUN_PAJAK) LIKE '%".$q."%'
						OR SPL.JUMLAH_POTONG LIKE '%".$q."%'
						OR SPL.DPP LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_CURRENCY_CODE) LIKE '%".$q."%'
						) ";

			if (strpos($q, '/') !== false) {
			    $explode = explode("/", $q);
			    $last    = end($explode);
			    if (count($explode) == 3 && $last != ""){
					$where = "AND (trunc(SPL.TANGGAL_FAKTUR_PAJAK) = TO_DATE('".$q."','dd/mm/yy')
								OR trunc(SPL.TANGGAL_DOKUMEN_LAIN) = TO_DATE('".$q."','dd/mm/yy'))";
			    }
			}
		}

		$mainQuery	=  "SELECT distinct pajak_line_id xxxx, spl.pajak_header_id, spl.pajak_line_id, spl.organization_id, spl.vendor_site_id, spl.is_cheklist, spl.is_pmk, spl.akun_pajak, spl.masa_pajak, spl.tahun_pajak, spl.dl_fs, spl.no_dokumen_lain_ganti, spl.no_dokumen_lain, spl.no_faktur_pajak, spl.invoice_num, spl.invoice_currency_code, spl.dpp, spl.jumlah_ppnbm, spl.keterangan, spl.fapr, spl.is_creditable, spl.id_keterangan_tambahan, spl.fg_uang_muka, spl.uang_muka_dpp, spl.uang_muka_ppn, spl.uang_muka_ppnbm, spl.referensi, spl.faktur_asal, spl.tanggal_faktur_asal, spl.dpp_asal, spl.ppn_asal, spl.ntpn, spl.keterangan_gl,spl.tanggal_dokumen_lain, spl.tanggal_faktur_pajak, spl.tanggal_approval, spl.fg_pengganti, spl.kd_jenis_transaksi, spl.jenis_transaksi, spl.jenis_dokumen,
						NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
						".$nvl_wp."						
						".$jml_ppn."
					        FROM SIMTAX_PAJAK_LINES SPL 
					  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
					  		ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
					          ON SPH.PERIOD_ID = SMP.PERIOD_ID
					    ".$join."
					 WHERE SPL.PAJAK_HEADER_ID = $pajak_header_id
						".$where_conditionString.$whereCategory.$where.$order;

		$sql		= "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;
		
		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
	}


	function action_cek_row_rekonsiliasi($pajak_header_id, $category="")
	{
		
		ini_set('memory_limit', '-1');

		if($category == "dokumen_lain"){
			$whereCategory = " AND SPL.DL_FS = '".$category."'";
		}
		else{
			$whereCategory = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = '".$category."')";
		}

		$data_header   = $this->get_data_header($pajak_header_id);
		$nama_pajak    = ($data_header) ? $data_header->NAMA_PAJAK : "";

		if($nama_pajak == "PPN MASUKAN"){
			$nvl_wp  = "NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,";
			$alias   = "SMS";
			$join    = "LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
							ON SMS.VENDOR_ID        = SPL.VENDOR_ID
							AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SMS.VENDOR_SITE_ID  = SPL.VENDOR_SITE_ID";
		}
		else{
			$nvl_wp  = "NVL(SMPEL.CUSTOMER_NAME,SPL.NAMA_WP) VENDOR_NAME,";
			$alias   = "SMPEL";
			$join    = "LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
							ON SMPEL.CUSTOMER_ID      = SPL.CUSTOMER_ID
							AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SPL.vendor_site_id    = SMPEL.customer_site_id";

		}

		$mainQuery	= "SELECT SPL.IS_CHEKLIST, SPL.DL_FS, SPL.KD_JENIS_TRANSAKSI, SPL.NO_DOKUMEN_LAIN, SPL.NO_FAKTUR_PAJAK,
						spl.akun_pajak, spl.dpp,
						".$nvl_wp."
						NVL(".$alias.".NPWP,SPL.NPWP) NPWP1
					        FROM SIMTAX_PAJAK_LINES SPL
					  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
					          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					         ".$join."
					  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
					          ON SPH.PERIOD_ID = SMP.PERIOD_ID
					 WHERE SPL.PAJAK_HEADER_ID = '".$pajak_header_id."'
					 ".$whereCategory."
					 ORDER BY INVOICE_NUM DESC";

		$query = $this->db->query($mainQuery);
		if($query){			
			return $query;
		} else {
			return false;
		}		
	}

	function get_total_rekonsiliasi($pajak_header_id, $category)
	{

		if($category == "Rekonsiliasi"){
			$whereCategory = " AND SPH.STATUS IN ('DRAFT', 'REJECT SUPERVISOR')";
		} else if($category == "approval_cabang"){
			$whereCategory = " AND SPH.STATUS IN ('SUBMIT', 'REJECT BY PUSAT')";
		} else if($category == "approval_pusat"){
			$whereCategory = " AND UPPER(SPH.STATUS) = 'APPROVAL SUPERVISOR'";
		} else {
			$whereCategory = "";
		}

		$sql	= "SELECT sum(SPL.JUMLAH_POTONG)*-1 jml_potong, SMP.STATUS
						FROM SIMTAX_PAJAK_LINES SPL 
						INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
						INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
						WHERE SPL.PAJAK_HEADER_ID = $pajak_header_id
						".$whereCategory."
						AND UPPER(SMP.STATUS) = 'OPEN'
						GROUP BY SMP.STATUS";
			
		$query = $this->db->query($sql);

		if($query){
			return $query;
		} else {
			return false;
		}
		
	}

	function get_rincian($kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke)
	{

		if($bulan_pajak == "1"){
			$tahun_pajak2 = $tahun_pajak-1;
			$bulan_pajak2 = 12;
		}
		else{
			$tahun_pajak2 = $tahun_pajak;
			$bulan_pajak2 = $bulan_pajak-1;
		}

		$get_z_percent = $this->get_z_percent($tahun_pajak, $bulan_pajak);
		$row_z         = $get_z_percent['query']->row_array();
		$z_percent     = $row_z['NILAI'];

		/*$z_percent   = 95.08;

		if($tahun_pajak == "2019" && $bulan_pajak >= 3){
			$z_percent = 98.49;
		}*/

		if($kode_cabang != ""){
		
		$mainQuery	= "SELECT  SPH.KODE_CABANG, abs(PMK78) pmk78 , KOMPENSASI_PPN,
								(SELECT SPH2.KOMPENSASI_PPN FROM SIMTAX_PAJAK_HEADERS SPH2
									WHERE SPH2.NAMA_PAJAK = SPH.NAMA_PAJAK
									AND SPH2.KODE_CABANG  = SPH.KODE_CABANG
									AND SPH2.BULAN_PAJAK  = ".$bulan_pajak2."
									AND SPH2.TAHUN_PAJAK  = ".$tahun_pajak2."
									) KOMPENSASI_SEBELUMNYA,
								(
									SELECT
									SUM(JUMLAH_POTONG*-1)
									FROM SIMTAX_PAJAK_LINES SPL
									WHERE NAMA_PAJAK = 'PPN MASUKAN'
									AND KODE_CABANG = SPH.KODE_CABANG
									AND BULAN_PAJAK = ".$bulan_pajak."
									AND TAHUN_PAJAK = ".$tahun_pajak."
									AND PEMBETULAN_KE = ".$pembetulan_ke."
									AND IS_CHEKLIST = '1'
									and ((spl.kd_jenis_transaksi IN (1,2,3,4,5,6,9,11,12) and spl.dl_fs = 'dokumen_lain') OR (spl.kd_jenis_transaksi IN (1,2,3,4,5,6,9) and (spl.dl_fs is null or spl.dl_fs = 'faktur_standar') and spl.is_creditable = '1'))
								) PPN_MASUKAN, 
								(
									SELECT
									sum(JUMLAH_POTONG)
									FROM SIMTAX_PAJAK_LINES SPL
									WHERE NAMA_PAJAK = 'PPN KELUARAN'
									AND KODE_CABANG = SPH.KODE_CABANG
									AND BULAN_PAJAK = ".$bulan_pajak."
									AND TAHUN_PAJAK = ".$tahun_pajak."
									AND PEMBETULAN_KE = ".$pembetulan_ke."
									AND IS_CHEKLIST = '1'
									AND spl.kd_jenis_transaksi IN (1,4,6,9)
								) PPN_KELUARAN
						FROM SIMTAX_PAJAK_HEADERS SPH
						INNER JOIN SIMTAX_KODE_CABANG SKC ON SPH.KODE_CABANG = SKC.KODE_CABANG
						WHERE SPH.NAMA_PAJAK IN ('PPN KELUARAN','PPN MASUKAN')
						AND SPH.BULAN_PAJAK = ".$bulan_pajak."
						AND SPH.TAHUN_PAJAK = ".$tahun_pajak."
						AND SPH.PEMBETULAN_KE = ".$pembetulan_ke."
						AND SPH.KODE_CABANG = '".$kode_cabang."'";

		}
		else{
			$mainQuery	= " SELECT skc.kode_cabang
								 , case skc.nama_cabang
									when 'Kantor Pusat' then skc.nama_cabang
								   else 'Cabang ' || skc.nama_cabang
								   end nama_cabang								 
								 , ppn_header.bulan_pajak
								 , ppn_header.tahun_pajak
								 , ppn_keluaran.jumlah_potong PPN_KELUARAN
								 , ppn_masukan.jumlah_potong PPN_MASUKAN
								 , pmk.jumlah_potong PMK78
								 , nvl(ppn_keluaran.jumlah_potong,0) - (nvl(ppn_masukan.jumlah_potong,0) - nvl(pmk.jumlah_potong,0)) KURANG_LEBIH
							  from simtax_kode_cabang skc
							, (select 
								   skc.NAMA_CABANG
								 , sphh.KODE_CABANG
								 , sphh.TAHUN_PAJAK
								 , sphh.BULAN_PAJAK
								 , sphh.MASA_PAJAK
							  from simtax_pajak_headers sphh
								 , simtax_pajak_lines splh
								 , simtax_kode_cabang skc
							 where sphh.nama_pajak in ('PPN KELUARAN','PPN MASUKAN')
							   and sphh.PAJAK_HEADER_ID = splh.PAJAK_HEADER_ID
							   and nvl(splh.IS_CHEKLIST,0) = 1
							   and skc.KODE_CABANG = sphh.KODE_CABANG
							   and sphh.tahun_pajak = '".$tahun_pajak."'
							   and sphh.bulan_pajak = '".$bulan_pajak."'
							   and sphh.pembetulan_ke = '".$pembetulan_ke."'
							group by skc.NAMA_CABANG, sphh.KODE_CABANG, sphh.TAHUN_PAJAK, sphh.BULAN_PAJAK, sphh.MASA_PAJAK) ppn_header
							,(select skc.NAMA_CABANG
								 , sphm.KODE_CABANG
								 , sphm.TAHUN_PAJAK
								 , sphm.BULAN_PAJAK
								 , sphm.MASA_PAJAK
								 , sum(nvl(splm.JUMLAH_POTONG,0)) JUMLAH_POTONG
							  from simtax_pajak_headers sphm
								 , simtax_pajak_lines splm
								 , simtax_kode_cabang skc
							 where sphm.nama_pajak = 'PPN KELUARAN'
							   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
							   and nvl(splm.IS_CHEKLIST,0) = 1
							   and skc.KODE_CABANG = sphm.KODE_CABANG
							   and sphm.tahun_pajak = '".$tahun_pajak."'
							   and sphm.bulan_pajak = '".$bulan_pajak."'
							   and sphm.pembetulan_ke = '".$pembetulan_ke."'
							   and splm.kd_jenis_transaksi IN (1,4,6,9)
							group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) ppn_keluaran
							,(select skc.NAMA_CABANG
								 , sphm.KODE_CABANG
								 , sphm.TAHUN_PAJAK
								 , sphm.BULAN_PAJAK
								 , sphm.MASA_PAJAK
								 , sum(nvl(splm.JUMLAH_POTONG*-1,0)) JUMLAH_POTONG
							  from simtax_pajak_headers sphm
								 , simtax_pajak_lines splm
								 , simtax_kode_cabang skc
							 where sphm.nama_pajak = 'PPN MASUKAN'
							   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
							   and nvl(splm.IS_CHEKLIST,0) = 1
							   and skc.KODE_CABANG = sphm.KODE_CABANG
							   and sphm.tahun_pajak = '".$tahun_pajak."'
							   and sphm.bulan_pajak = '".$bulan_pajak."'
							   and sphm.pembetulan_ke = '".$pembetulan_ke."'
							   and ((splm.kd_jenis_transaksi IN (1,2,3,4,5,6,9,11,12) and splm.dl_fs = 'dokumen_lain') OR (splm.kd_jenis_transaksi IN (1,2,3,4,5,6,9) and (splm.dl_fs is null or splm.dl_fs = 'faktur_standar') and splm.is_creditable = '1'))
							group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) ppn_masukan
							,(select skc.NAMA_CABANG
								 , sphm.KODE_CABANG
								 , sphm.TAHUN_PAJAK
								 , sphm.BULAN_PAJAK
								 , sphm.MASA_PAJAK
								 , SUM (NVL (splm.JUMLAH_POTONG * -1, 0)) * (".$z_percent." / 100) - SUM (NVL (splm.JUMLAH_POTONG * -1, 0))
                                  JUMLAH_POTONG
							  from simtax_pajak_headers sphm
								 , simtax_pajak_lines splm
								 , simtax_kode_cabang skc
							 where sphm.nama_pajak = 'PPN MASUKAN'
							   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
							   and nvl(splm.IS_CHEKLIST,0) = 1
							   and skc.KODE_CABANG = sphm.KODE_CABANG
							   and sphm.tahun_pajak = '".$tahun_pajak."'
							   and sphm.bulan_pajak = '".$bulan_pajak."'
							   and sphm.pembetulan_ke = '".$pembetulan_ke."'
							   and splm.is_pmk = '1'
							group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) pmk
							where 1=1
							and skc.KODE_CABANG = ppn_header.kode_cabang (+)
							and ppn_header.nama_cabang = ppn_keluaran.nama_cabang (+)
							and ppn_header.kode_cabang = ppn_keluaran.kode_cabang (+)
							and ppn_header.tahun_pajak = ppn_keluaran.tahun_pajak (+)
							and ppn_header.bulan_pajak = ppn_keluaran.bulan_pajak (+)
							and ppn_header.masa_pajak  = ppn_keluaran.masa_pajak (+)
							and ppn_header.nama_cabang = ppn_masukan.nama_cabang (+)
							and ppn_header.kode_cabang = ppn_masukan.kode_cabang (+)
							and ppn_header.tahun_pajak = ppn_masukan.tahun_pajak (+)
							and ppn_header.bulan_pajak = ppn_masukan.bulan_pajak (+)
							and ppn_header.masa_pajak  = ppn_masukan.masa_pajak (+)
							and ppn_header.nama_cabang = pmk.nama_cabang (+)
							and ppn_header.kode_cabang = pmk.kode_cabang (+)
							and ppn_header.tahun_pajak = pmk.tahun_pajak (+)
							and ppn_header.bulan_pajak = pmk.bulan_pajak (+)
							and ppn_header.masa_pajak  = pmk.masa_pajak (+)
							and skc.KODE_CABANG in ('000','010','020','030','040','050',
							'060','070','080','090','100','110','120')
							order by skc.kode_cabang
							";
		}
		
		$query               = $this->db->query($mainQuery);
		$result['queryExec'] = $query;
		$rowCount            = $query->num_rows();
		
		$result['jmlRow']    = $rowCount;	

		return $result;
	}

	function get_total_rincian($bulan_pajak, $tahun_pajak, $pembetulan_ke)
	{

		$get_z_percent = $this->get_z_percent($tahun_pajak, $bulan_pajak);
		$row_z         = $get_z_percent['query']->row_array();
		$z_percent     = $row_z['NILAI'];

		/*$z_percent   = 95.08;

		if($tahun_pajak == "2019" && $bulan_pajak >= 3){
			$z_percent = 98.49;
		}*/

		$mainQuery	= " SELECT SUM(ppn_keluaran.jumlah_potong) PPN_KELUARAN,
							SUM(ppn_masukan.jumlah_potong) PPN_MASUKAN,
							SUM(pmk.jumlah_potong) PMK78,
							SUM( nvl(ppn_keluaran.jumlah_potong,0) - (nvl(ppn_masukan.jumlah_potong,0) - nvl(pmk.jumlah_potong,0) ) ) KURANG_LEBIH
						  from simtax_kode_cabang skc
						, (select 
							   skc.NAMA_CABANG
							 , sphh.KODE_CABANG
							 , sphh.TAHUN_PAJAK
							 , sphh.BULAN_PAJAK
							 , sphh.MASA_PAJAK
						  from simtax_pajak_headers sphh
							 , simtax_pajak_lines splh
							 , simtax_kode_cabang skc
						 where sphh.nama_pajak in ('PPN KELUARAN','PPN MASUKAN')
						   and sphh.PAJAK_HEADER_ID = splh.PAJAK_HEADER_ID
						   and nvl(splh.IS_CHEKLIST,0) = 1
						   and skc.KODE_CABANG = sphh.KODE_CABANG
						   and sphh.tahun_pajak = ".$tahun_pajak."
						   and sphh.bulan_pajak = ".$bulan_pajak."
						   and sphh.pembetulan_ke = ".$pembetulan_ke."
						group by skc.NAMA_CABANG, sphh.KODE_CABANG, sphh.TAHUN_PAJAK, sphh.BULAN_PAJAK, sphh.MASA_PAJAK) ppn_header
						,(select skc.NAMA_CABANG
							 , sphm.KODE_CABANG
							 , sphm.TAHUN_PAJAK
							 , sphm.BULAN_PAJAK
							 , sphm.MASA_PAJAK
							 , sum(nvl(splm.JUMLAH_POTONG,0)) JUMLAH_POTONG
						  from simtax_pajak_headers sphm
							 , simtax_pajak_lines splm
							 , simtax_kode_cabang skc
						 where sphm.nama_pajak = 'PPN KELUARAN'
						   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
						   and nvl(splm.IS_CHEKLIST,0) = 1
						   and skc.KODE_CABANG = sphm.KODE_CABANG
						   and sphm.tahun_pajak = ".$tahun_pajak."
						   and sphm.bulan_pajak = ".$bulan_pajak." 
						   and sphm.pembetulan_ke = ".$pembetulan_ke."
						   and splm.kd_jenis_transaksi IN (1,4,6,9)
						group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) ppn_keluaran,
						(select skc.NAMA_CABANG
							 , sphm.KODE_CABANG
							 , sphm.TAHUN_PAJAK
							 , sphm.BULAN_PAJAK
							 , sphm.MASA_PAJAK
							 , sum(nvl(splm.JUMLAH_POTONG*-1,0)) JUMLAH_POTONG
						  from simtax_pajak_headers sphm
							 , simtax_pajak_lines splm
							 , simtax_kode_cabang skc
						 where sphm.nama_pajak = 'PPN MASUKAN'
						   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
						   and nvl(splm.IS_CHEKLIST,0) = 1
						   and skc.KODE_CABANG = sphm.KODE_CABANG
						   and sphm.tahun_pajak = ".$tahun_pajak."
						   and sphm.bulan_pajak = ".$bulan_pajak."
						   and sphm.pembetulan_ke = ".$pembetulan_ke."
						   and ((splm.kd_jenis_transaksi IN (1,2,3,4,5,6,9,11,12) and splm.dl_fs = 'dokumen_lain') OR (splm.kd_jenis_transaksi IN (1,2,3,4,5,6,9) and (splm.dl_fs is null or splm.dl_fs = 'faktur_standar') and splm.is_creditable = '1'))
						group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) ppn_masukan,
						(select skc.NAMA_CABANG
							 , sphm.KODE_CABANG
							 , sphm.TAHUN_PAJAK
							 , sphm.BULAN_PAJAK
							 , sphm.MASA_PAJAK
							 --, SUM (NVL (JUMLAH_POTONG * -1, 0)) * (".$z_percent." / 100) - SUM (NVL (JUMLAH_POTONG * -1, 0)) JUMLAH_POTONG
                             , ceil(abs(SUM (NVL (JUMLAH_POTONG * -1, 0)) * (".$z_percent." / 100) - SUM (NVL (JUMLAH_POTONG * -1, 0)))) JUMLAH_POTONG
						  from simtax_pajak_headers sphm
							 , simtax_pajak_lines splm
							 , simtax_kode_cabang skc
						 where sphm.nama_pajak = 'PPN MASUKAN'
						   and sphm.PAJAK_HEADER_ID = splm.PAJAK_HEADER_ID
						   and nvl(splm.IS_CHEKLIST,0) = 1
						   and skc.KODE_CABANG = sphm.KODE_CABANG
						   and sphm.tahun_pajak = ".$tahun_pajak."
						   and sphm.bulan_pajak = ".$bulan_pajak."
						   and sphm.pembetulan_ke = ".$pembetulan_ke."
						   and splm.is_pmk = '1'
						group by skc.NAMA_CABANG, sphm.KODE_CABANG, sphm.TAHUN_PAJAK, sphm.BULAN_PAJAK, sphm.MASA_PAJAK) pmk
						where 1=1
						and skc.KODE_CABANG = ppn_header.kode_cabang (+)
						and ppn_header.nama_cabang = ppn_keluaran.nama_cabang (+)
						and ppn_header.kode_cabang = ppn_keluaran.kode_cabang (+)
						and ppn_header.tahun_pajak = ppn_keluaran.tahun_pajak (+)
						and ppn_header.bulan_pajak = ppn_keluaran.bulan_pajak (+)
						and ppn_header.masa_pajak  = ppn_keluaran.masa_pajak (+)
						and ppn_header.nama_cabang = ppn_masukan.nama_cabang (+)
						and ppn_header.kode_cabang = ppn_masukan.kode_cabang (+)
						and ppn_header.tahun_pajak = ppn_masukan.tahun_pajak (+)
						and ppn_header.bulan_pajak = ppn_masukan.bulan_pajak (+)
						and ppn_header.masa_pajak  = ppn_masukan.masa_pajak (+)
						and ppn_header.nama_cabang = pmk.nama_cabang (+)
						and ppn_header.kode_cabang = pmk.kode_cabang (+)
						and ppn_header.tahun_pajak = pmk.tahun_pajak (+)
						and ppn_header.bulan_pajak = pmk.bulan_pajak (+)
						and ppn_header.masa_pajak  = pmk.masa_pajak (+)
						and skc.KODE_CABANG in ('000','010','020','030','040','050',
						'060','070','080','090','100','110','120')
						order by skc.kode_cabang";

		$query = $this->db->query($mainQuery);

		return $query;

	}

	function update_tahunan($data, $bulan_pajak, $tahun_pajak, $pembetulan_ke){

		$this->db->where('BULAN_PAJAK', $bulan_pajak);
		$this->db->where('TAHUN_PAJAK', $tahun_pajak);
		$this->db->where('PEMBETULAN_KE', $pembetulan_ke);
		
		$update = $this->db->update("SIMTAX_PMK_PPNMASA", $data);

		if($update){

			$param = array("BULAN_PAJAK" => $bulan_pajak, "TAHUN_PAJAK" => $bulan_pajak, "PEMBETULAN_KE" => $bulan_pajak);
			simtax_update_history("SIMTAX_PMK_PPNMASA", "UPDATE", $param);
			return true;
		}
		else{
			return false;
		}

	}

	function get_pmk_tahunan($bulan_pajak, $tahun_pajak, $pembetulan_ke){

		$mainQuery	= "SELECT * FROM SIMTAX_PMK_PPNMASA WHERE BULAN_PAJAK = '".$bulan_pajak."' AND TAHUN_PAJAK = '".$tahun_pajak."' AND PEMBETULAN_KE = '".$pembetulan_ke."'";
		$query 		= $this->db->query($mainQuery);
		return $query;

	}
	
	/*Awal Detail Rekonsiliasi================================================================================*/
	function get_detail_summary($pajak_header_id, $category, $pmk=false, $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');

		$data_header   = $this->get_data_header($pajak_header_id);

		$kode_cabang   = ($data_header) ? $data_header->KODE_CABANG : "";
		$nama_pajak    = ($data_header) ? $data_header->NAMA_PAJAK : "";
		$bulan_pajak   = ($data_header) ? $data_header->BULAN_PAJAK : "";
		$tahun_pajak   = ($data_header) ? $data_header->TAHUN_PAJAK : "";
		$pembetulan_ke = ($data_header) ? $data_header->PEMBETULAN_KE : "";

		$tgl_akhir	= $this->Master_mdl->getEndMonth($tahun_pajak,$bulan_pajak);

		$where = "";
		if($keywords) {
			$q     = strtoupper($keywords);
			$where	.= " AND (upper(SMS.NPWP) like '%".$q."%' OR upper(SMS.VENDOR_NAME) LIKE '%".$q."%') ";
		}
		$where	.= " AND SPH.BULAN_PAJAK = '".$bulan_pajak."' AND SPH.TAHUN_PAJAK = '".$tahun_pajak."' AND SPH.PEMBETULAN_KE = '".$pembetulan_ke."' ";
		
		if($category == "Rekonsiliasi"){
			$where .=" AND (UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')) ";
		}

		if($nama_pajak == "PPN MASUKAN"){
			$kaliPPN = -1;
		}
		else{
			$kaliPPN = 1;
		}

		if($pmk){
			$newWhere = " AND SPL.IS_PMK = '1'";
		}
		else{
			$newWhere = " AND SPL.IS_CHEKLIST = '0'";
		}
		

         if($pmk){
         	$queryExec	= " SELECT SPL.PAJAK_LINE_ID,
         						NVL(NVL(SMS.VENDOR_NAME,SMPEL.CUSTOMER_NAME),SPL.NAMA_WP) VENDOR_NAME,
         						-- NVL(NVL(SPL.NAMA_WP,SMPEL.CUSTOMER_NAME),SMS.VENDOR_NAME) VENDOR_NAME,
								NVL(SPL.URAIAN_PEKERJAAN, SPL.INVOICE_NUM) URAIAN_PEKERJAAN,
								NVL(NVL(SPL.NO_FAKTUR_PAJAK,''), NVL(SPL.NO_DOKUMEN_LAIN,'')) NO_FAKTUR,
								NVL(NVL(SPL.TANGGAL_FAKTUR_PAJAK,''), NVL(SPL.TANGGAL_DOKUMEN_LAIN,'')) TGL_FAKTUR,
								SPL.DPP, NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0) JUMLAH_POTONG, SPL.Z_PERCENT, SPH.MASA_PAJAK, SPH.TAHUN_PAJAK, SPH.KODE_CABANG
				                            FROM SIMTAX_PAJAK_LINES SPL 
				                      INNER JOIN SIMTAX_PAJAK_HEADERS SPH
				                              ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
				                      INNER JOIN SIMTAX_MASTER_PERIOD SMP 
				                              ON SPH.PERIOD_ID = SMP.PERIOD_ID
		                              LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
									          ON SMS.VENDOR_ID = SPL.VENDOR_ID
									         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
									        AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
									   LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
									          ON SMPEL.CUSTOMER_ID = SPL.CUSTOMER_ID
									         AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                             				AND SPL.vendor_site_id = SMPEL.customer_site_id
				                     WHERE SPL.PAJAK_HEADER_ID = '".$pajak_header_id."'".$newWhere.$where."
				                     	ORDER BY INVOICE_ACCOUNTING_DATE DESC";
		}
		else{

			$queryExec	= " SELECT SPL.PAJAK_LINE_ID,
							  NVL(SPL.NEW_DPP, SPL.DPP) DPP
							, NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0) JUMLAH_POTONG
							, NVL(NVL(SPL.NAMA_WP,SMPEL.CUSTOMER_NAME),SMS.VENDOR_NAME) VENDOR_NAME
							, NVL(NVL(SPL.NPWP,SMPEL.NPWP),SMS.NPWP) NPWP1
							, NVL(NVL(SPL.ALAMAT_WP,SMPEL.ADDRESS_LINE1),SMS.ADDRESS_LINE1)ADDRESS_LINE1
							, SPL.NO_FAKTUR_PAJAK
							, SPL.NO_DOKUMEN_LAIN
							, SPL.TANGGAL_FAKTUR_PAJAK
							, SPL.TANGGAL_DOKUMEN_LAIN
							, SPL.INVOICE_NUM
							, SPL.INVOICE_LINE_NUM
							,CASE WHEN SPL.KETERANGAN_TDK_DILAPORKAN IS NOT NULL THEN SPL.KETERANGAN_TDK_DILAPORKAN
								   ELSE 'Tidak Dilaporkan' END KETERANGAN
							--, 'Tidak Dilaporkan' KETERANGAN
							, '1' urut
	                        FROM SIMTAX_PAJAK_LINES SPL 
	                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
	                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
	                        LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
						          ON SMS.VENDOR_ID = SPL.VENDOR_ID
						         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						        AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						   LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
						          ON SMPEL.CUSTOMER_ID = SPL.CUSTOMER_ID
						         AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                 				AND SPL.vendor_site_id = SMPEL.customer_site_id
	                        WHERE UPPER(SMP.STATUS) = 'OPEN'
	                        AND SPL.NAMA_PAJAK = '".$nama_pajak."'
	                        AND SPH.KODE_CABANG ='".$kode_cabang."'
	                        ".$newWhere.$where." ORDER BY URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC";
		}

		$sql2		= $queryExec;  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows();

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$start."+".$length."
					)
					WHERE rnum >".$start."";
		
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		return $result;
	}

	function get_ntpn($bulan_pajak, $tahun_pajak, $pembetulan_ke, $start, $length, $keywords){
		ini_set('memory_limit', '-1');

		$where = "";
		if($keywords) {
			$q     = strtoupper($keywords);
			$where	.= " ";
		}
     	$queryExec	= " SELECT * FROM SIMTAX_NTPN WHERE BULAN = '".$bulan_pajak."' AND TAHUN = '".$tahun_pajak."' AND PEMBETULAN = '".$pembetulan_ke."'  AND JENIS_PAJAK is null";
		$sql2		= $queryExec;  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows();

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$start."+".$length."
					)
					WHERE rnum >".$start."";
		
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		return $result;

	}
	
	function get_total_detail_summary($pajak_header_id, $category)
	{
		ini_set('memory_limit', '-1');

		$data_header   = $this->get_data_header($pajak_header_id);

		$kode_cabang   = ($data_header) ? $data_header->KODE_CABANG : "";
		$nama_pajak    = ($data_header) ? $data_header->NAMA_PAJAK : "";
		$bulan_pajak   = ($data_header) ? $data_header->BULAN_PAJAK : "";
		$tahun_pajak   = ($data_header) ? $data_header->TAHUN_PAJAK : "";
		$pembetulan_ke = ($data_header) ? $data_header->PEMBETULAN_KE : "";

		$tgl_akhir	= $this->Master_mdl->getEndMonth($tahun_pajak,$bulan_pajak);
	
		$where	= " and SPH.bulan_pajak = '".$bulan_pajak."' and SPH.tahun_pajak = '".$tahun_pajak."' and SPH.pembetulan_ke = '".$pembetulan_ke."' ";
		
		if($category == "Rekonsiliasi"){
			$where .=" AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR') ";
		}

		if($nama_pajak == "PPN MASUKAN"){
			$kaliPPN = -1;
		}
		else{
			$kaliPPN = 1;
		}
		
		$queryExec	= " SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN
						, SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = '".$nama_pajak."'
                        AND SPH.KODE_CABANG ='".$kode_cabang."'
						AND SPL.IS_CHEKLIST = 0
                        ".$where;
						
		$queryExec	.= " UNION ALL
						SELECT 'Tanggal 26 - 31 Bulan ini' KETERANGAN
						, SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = '".$nama_pajak."'
                        AND SPH.KODE_CABANG ='".$kode_cabang."'
						AND SPL.INVOICE_ACCOUNTING_DATE BETWEEN TO_DATE ('".$tahun_pajak."/".$bulan_pajak."/26', 'yyyy/mm/dd') 
							AND TO_DATE ('".$tahun_pajak."/".$bulan_pajak."/".$tgl_akhir."', 'yyyy/mm/dd')
                        ".$where;
						
		$queryExec	.= " UNION ALL
						SELECT 'Import CSV' KETERANGAN
						, SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) JUMLAH_POTONG
                        FROM SIMTAX_PAJAK_LINES SPL 
                        INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SMP.PERIOD_ID = SPH.PERIOD_ID
                        AND UPPER(SMP.STATUS) = 'OPEN'
                        AND SPL.NAMA_PAJAK = '".$nama_pajak."'
                        AND SPH.KODE_CABANG ='".$kode_cabang."'
						AND upper(SPL.SOURCE_DATA) ='CSV'
                        ".$where;
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG ";
		
		$query 		= $this->db->query($queryExec);
		return $query;
	}
	
	function get_total_pmk($pajak_header_id)
	{
		ini_set('memory_limit', '-1');

		$data_header   = $this->get_data_header($pajak_header_id);

		$kode_cabang   = ($data_header) ? $data_header->KODE_CABANG : "";
		$nama_pajak    = ($data_header) ? $data_header->NAMA_PAJAK : "";
		$bulan_pajak   = ($data_header) ? $data_header->BULAN_PAJAK : "";
		$tahun_pajak   = ($data_header) ? $data_header->TAHUN_PAJAK : "";
		$pembetulan_ke = ($data_header) ? $data_header->PEMBETULAN_KE : "";
		
		if($nama_pajak == "PPN MASUKAN"){
			$kaliPPN = -1;
		}
		else{
			$kaliPPN = 1;
		}

		$get_z_percent = $this->get_z_percent($tahun_pajak, $bulan_pajak);
		$row_z         = $get_z_percent['query']->row_array();
		$z_percent     = $row_z['NILAI'];

		/*$z_percent   = 95.08;

		if($tahun_pajak == "2019" && $bulan_pajak >= 3){
			$z_percent = 98.49;
		}*/

		$queryExec	= "SELECT SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) JUMLAH_POTONG,
							SUM(NVL(SPL.DPP,0)) DPP,
							SUM(NVL(Replace(SPL.Z_PERCENT, '%', ''), ".$z_percent."))/100 Z_PERCENT,
							SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) * (".$z_percent."/100) SPT_MASA,
							SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) * (".$z_percent."/100) - SUM(NVL(SPL.JUMLAH_POTONG*".$kaliPPN.",0)) KOREKSI_PM
	                            FROM SIMTAX_PAJAK_LINES SPL 
	                      INNER JOIN SIMTAX_PAJAK_HEADERS SPH
	                              ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
	                      INNER JOIN SIMTAX_MASTER_PERIOD SMP 
	                              ON SPH.PERIOD_ID = SMP.PERIOD_ID
	                               WHERE SPL.PAJAK_HEADER_ID = '".$pajak_header_id."' AND SPL.IS_PMK = '1' AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR') 
	                     	ORDER BY INVOICE_ACCOUNTING_DATE DESC";
		
		$query = $this->db->query($queryExec);
		return  $query->row();
	}

	function get_pmk_78($pajak_header_id, $inarray = false){

		$where = " WHERE PAJAK_HEADER_ID  = '".$pajak_header_id."'";
		if($inarray){
			$where = " WHERE PAJAK_HEADER_ID IN ('".implode("','", $pajak_header_id)."')";
		}

		$sql = "SELECT SUM(PMK78)
				FROM SIMTAX_PAJAK_HEADERS ".$where;

		$query = $this->db->query($sql);

		return $query->result();
		
	}
	
	function get_currency($pajak_header_id, $category="Rekonsiliasi")
	{

		if($category == "Rekonsiliasi"){
			$whereCategory = " AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')";
		}
		else if($category == "approval_cabang"){
			$whereCategory = " AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT')";
		}
		else if($category == "approval_pusat"){
			$whereCategory = " AND UPPER(SPH.STATUS) = 'APPROVAL SUPERVISOR'";
		}
		else if($category == "download_cetak"){
			$whereCategory = " AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT', 'APPROVAL SUPERVISOR')";
		}
		else if($category == "download_cetak_comp"){
			$whereCategory = " AND UPPER(SPH.STATUS) = 'APPROVED BY PUSAT'";
		}
		else{
			$whereCategory = " ";
		}

		if(is_array($pajak_header_id)){
			$where = " WHERE PAJAK_HEADER_ID IN ('".implode("','", $pajak_header_id)."')";
		}
		else{
			$where = " WHERE PAJAK_HEADER_ID  = '".$pajak_header_id."'";
		}

		$queryExec	= "SELECT SUM(NVL(SPH.SALDO_AWAL,0)) SALDO_AWAL
						  , SUM(NVL(SPH.MUTASI_DEBIT,0)) MUTASI_DEBIT
						  , SUM(NVL(SPH.MUTASI_KREDIT,0	)) MUTASI_KREDIT
						  , SUM(NVL(SPH.PMK78,0)) PMK78
					FROM SIMTAX_PAJAK_HEADERS SPH
					INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
					".$where.$whereCategory." AND UPPER(SMP.STATUS) = 'OPEN'";

		$query	 	= $this->db->query($queryExec);
		$rowCount	= $query->num_rows();
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		
		return $result;
	}

	function get_total_summary($pajak_header_id, $nama_pajak, $isChecklist, $category="", $start, $length)
	{
		ini_set('memory_limit', '-1');

		if($isChecklist == 1){
			$where = " AND SPL.IS_CHEKLIST = 1";
		} else if($isChecklist == 0){
			$where = " AND SPL.IS_CHEKLIST = 0";
		} else {
			$where ="";
		}
			$whereCategory = "";

		if($category == "Rekonsiliasi"){
			$whereCategory = " AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')";
		}
		else if($category == "approval_cabang"){
			$whereCategory = " AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT')";
		}
		else if($category == "approval_pusat"){
			$whereCategory = " AND UPPER(SPH.STATUS) = 'APPROVAL SUPERVISOR'";
		}
		else{
			$whereCategory = "";
		}

		if($nama_pajak == "PPN MASUKAN"){
			$conDibayarkan = " AND ( SUBSTRB(SPL.NO_DOKUMEN_LAIN,0,2) IN ('01','02','03','04','05','06','09')
								OR SUBSTRB(SPL.NO_FAKTUR_PAJAK,0,2) IN ('01','02','03','04','05','06','09'))";
			$kaliPPN       = "-1";
		}
		else{

			$conDibayarkan = " AND ( SUBSTRB(SPL.NO_DOKUMEN_LAIN,0,2) IN ('01','04','06','09')
									OR SUBSTRB(SPL.NO_FAKTUR_PAJAK,0,2) IN ('01','04','06','09'))";
			$kaliPPN       = "1";
		}
			
		$mainQuery	= "SELECT SPL.IS_CHEKLIST,
							CASE WHEN SPL.IS_CHEKLIST = 1 THEN 'Dilaporkan'
							   ELSE 'Tidak Dilaporkan' END pengelompokan,
							sum(SPL.JUMLAH_POTONG*".$kaliPPN.") jml_potong, SMP.STATUS
						FROM SIMTAX_PAJAK_LINES SPL 
						INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
						INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
						WHERE SPL.PAJAK_HEADER_ID = $pajak_header_id
						".$whereCategory."
						".$conDibayarkan."
						AND UPPER(SMP.STATUS) = 'OPEN'
						".$where."
						GROUP BY SPL.IS_CHEKLIST, SMP.STATUS";

		$sql		= "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
	}

	function add_ntpn($data, $tanggal_setor, $tanggal_lapor){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_setor != ""){
			$this->db->set('TANGGAL_SETOR',"TO_DATE('".$tanggal_setor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_lapor != ""){
			$this->db->set('TANGGAL_LAPOR',"TO_DATE('".$tanggal_lapor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		$insert = $this->db->insert("SIMTAX_NTPN", $data);

		if($insert){
			simtax_update_history("SIMTAX_NTPN", "CREATE");
			return true;
		}
		else{
			return false;
		}
	}

	function check_ntpn($id, $bulan, $tahun, $pembetulan, $ntpn){
		$andID = "";
		if($id !=""){
			$andID = " AND ID != ".$id;
		}

		$sql   = "SELECT * FROM SIMTAX_NTPN WHERE BULAN = '".$bulan."' AND TAHUN = '".$tahun."' AND PEMBETULAN = '".$pembetulan."' AND jenis_pajak is null AND NTPN = '".$ntpn."'".$andID;
		
		$query    = $this->db->query($sql);
		
		$rowCount = $query->num_rows();

		return $rowCount;

	}

	function update_ntpn($id, $data, $tanggal_setor, $tanggal_lapor){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_setor != ""){
			$this->db->set('TANGGAL_SETOR',"TO_DATE('".$tanggal_setor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_lapor != ""){
			$this->db->set('TANGGAL_LAPOR',"TO_DATE('".$tanggal_lapor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		$this->db->where('ID', $id);
		
		$update = $this->db->update("SIMTAX_NTPN", $data);

		if($update){
			simtax_update_history("SIMTAX_NTPN", "UPDATE", $id);
			return true;
		}
		else{
			return false;
		}
	}

	function delete_ntpn($id){

		$sql = "DELETE FROM SIMTAX_NTPN
					WHERE ID = '".$id."'";

		$query	= $this->db->query($sql);

		if($query){
			return true;
		}
	}

	function update_rekonsiliasi($id, $data, $tanggal_dokumen_lain="", $tanggal_faktur_pajak="", $tanggal_approval="", $tanggal_faktur_asal=""){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_dokumen_lain != ""){
			$this->db->set('TANGGAL_DOKUMEN_LAIN',"TO_DATE('".$tanggal_dokumen_lain."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_faktur_pajak != ""){
			$this->db->set('TANGGAL_FAKTUR_PAJAK',"TO_DATE('".$tanggal_faktur_pajak."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_approval != ""){
			$this->db->set('TANGGAL_APPROVAL',"TO_DATE('".$tanggal_approval."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_faktur_asal != ""){
			$this->db->set('TANGGAL_FAKTUR_ASAL',"TO_DATE('".$tanggal_faktur_asal."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		$this->db->set('LAST_UPDATE_DATE',"TO_DATE('".$date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		$this->db->where('PAJAK_LINE_ID', $id);
		
		$update = $this->db->update("SIMTAX_PAJAK_LINES", $data);

		if($update){
			$param = array("PAJAK_LINE_ID", $id);
			// simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $param);
			return true;
		}
		else{
			return false;
		}
	}

	function add_rekonsiliasi($data, $tanggal_dokumen_lain="", $tanggal_faktur_pajak="", $tanggal_approval="", $tanggal_faktur_asal=""){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_dokumen_lain != ""){
			$this->db->set('TANGGAL_DOKUMEN_LAIN',"TO_DATE('".$tanggal_dokumen_lain."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_faktur_pajak != ""){
			$this->db->set('TANGGAL_FAKTUR_PAJAK',"TO_DATE('".$tanggal_faktur_pajak."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_approval != ""){
			$this->db->set('TANGGAL_APPROVAL',"TO_DATE('".$tanggal_approval."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_faktur_asal != ""){
			$this->db->set('TANGGAL_FAKTUR_ASAL',"TO_DATE('".$tanggal_faktur_asal."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		$this->db->set('CREATION_DATE',"TO_DATE('".$date."', 'SYYYY-MM-DD HH24:MI:SS')",false);

		if($data['JSON_KELUARAN'] != ""){

			$encode = json_encode($data['JSON_KELUARAN']);

			if(strlen($encode) > 4000){
				$json1 = substr($encode, 0, 4000);
				$json2 = substr($encode, 4000);
				if(strlen($json2) > 4000){
					$json2s = substr($json2, 0, 4000);
					$json3  = substr($json2, 4000);
					$json2  = $json2s;
				}
				else{
					$json2 = $json2;
					$json3 = "";
				}
			}
			else{
				$json1 = $encode;
				$json2 = "";
				$json3 = "";
			}
			
			$data['JSON_KELUARAN']  = $json1;
			$data['JSON_KELUARAN1'] = $json2;
			$data['JSON_KELUARAN2'] = $json3;
		}

		$insert = $this->db->insert("SIMTAX_PAJAK_LINES", $data);

		if($insert){

			simtax_update_history("SIMTAX_PAJAK_LINES", "CREATE", "PAJAK_LINE_ID");

			return true;
		}
		else{
			return false;
		}
	}

	function update_saldo($pajak_header_id, $data)
	{
		$date   = date("Y-m-d H:i:s");

		$this->db->set('LAST_UPDATE_DATE',"TO_DATE('".$date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		$this->db->where('PAJAK_HEADER_ID', $pajak_header_id);
		
		$update = $this->db->update("SIMTAX_PAJAK_HEADERS", $data);

		if($update){
			$param = array("PAJAK_HEADER_ID", $pajak_header_id);
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);
			return true;
		}
		else{
			return false;
		}
	}

	function action_get_selectAll()
	{
		$id_lines = $this->input->post('id_lines');
		$vcheck   = $this->input->post('vcheck');
		
		$sql	= "UPDATE SIMTAX_PAJAK_LINES SET IS_CHEKLIST= '".$vcheck."'
					WHERE PAJAK_LINE_ID in  (".$id_lines.")";

		$query	= $this->db->query($sql);
		if ($query){

			$id_lines   = str_replace(' ', '', $id_lines);
			$explode_id = explode(",", $id_lines);
			foreach ($explode_id as $key => $value) {
				$id = $value;
				$param = array("PAJAK_LINE_ID" => $id);
				simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $param);
				unset($param);
			}

			return true;
		} else {
			return false;
		}
				
	}
	
	function submit_rekonsiliasi($pajak_header_id, $nama_pajak, $username)
	{
				
		$sql = "UPDATE SIMTAX_PAJAK_HEADERS
						SET TGL_SUBMIT_SUP    = SYSDATE, 
						USER_NAME             = '".$username."',
						STATUS                = 'SUBMIT'
						WHERE PAJAK_HEADER_ID = '".$pajak_header_id."'";

		$query	= $this->db->query($sql);
		
		$sql2	= "INSERT INTO SIMTAX_ACTION_HISTORY
					(PAJAK_HEADER_ID, JENIS_PAJAK, ACTION_DATE, ACTION_CODE, USER_NAME)
					VALUES (".$pajak_header_id.", '".$nama_pajak."' , SYSDATE, 'SUBMIT', '".$username."')";
		$query2	= $this->db->query($sql2);

		if ($query && $query2){
			$params = array("PAJAK_HEADER_ID" => $pajak_header_id);
			$params2 = array("PAJAK_HEADER_ID" => $pajak_header_id, "ACTION_CODE" => 'SUBMIT');
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
			simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);
			return true;
		} else {
			return false;
		}
		
	}


	/* Closing */

	function get_closing($kode_cabang, $tahun_pajak, $pembetulan_ke, $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');
		$where  = "";
		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND (UPPER(SMP.MASA_PAJAK) LIKE '%".$q."%' OR SMP.TAHUN_PAJAK LIKE '%".$q."%') ";
		}

		if($kode_cabang == "all"){
			$whereCabang = "";
		}
		else{
			$whereCabang = " AND SMP.KODE_CABANG   = '".$kode_cabang."'";
		}

		$mainQuery	= "SELECT SMP.*
						FROM SIMTAX_MASTER_PERIOD SMP 
						INNER JOIN SIMTAX_PAJAK_HEADERS SPH ON SMP.PERIOD_ID = SPH.PERIOD_ID
						WHERE SMP.NAMA_PAJAK IN ('PPN MASUKAN', 'PPN KELUARAN')
						AND SMP.TAHUN_PAJAK = '".$tahun_pajak."'
						AND SMP.PEMBETULAN_KE = '".$pembetulan_ke."'
						AND SPH.STATUS NOT IN('DRAFT','SUBMIT', 'APPROVAL SUPERVISOR')
						".$whereCabang."
						".$where."
						ORDER BY SMP.BULAN_PAJAK DESC, SMP.KODE_CABANG";

		$sql        = "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
	}


	function action_save_closing($pajak_header_id, $period_id, $nama_pajak, $status, $username)
	{
			
		if($status == "Open"){

			$sql	= "UPDATE SIMTAX_MASTER_PERIOD SET STATUS = 'Close'
					  WHERE PERIOD_ID = ".$period_id;
			$query	= $this->db->query($sql);
						
			$sql2	= "UPDATE SIMTAX_PAJAK_HEADERS SET STATUS = 'CLOSE',
						USER_NAME        = '".$username."',
						LAST_UPDATE_DATE = SYSDATE
					  WHERE PAJAK_HEADER_ID = ".$pajak_header_id;
			$query2	= $this->db->query($sql2);
			
			if ($query && $query2){
				$sql3	="INSERT INTO SIMTAX_ACTION_HISTORY
								(PAJAK_HEADER_ID, JENIS_PAJAK, ACTION_DATE, ACTION_CODE, USER_NAME)
							VALUES (".$pajak_header_id.", '".strtoupper($nama_pajak)."', SYSDATE, 'Close', '".$username."')";
				$query3	= $this->db->query($sql3);

				if($query3){
					$params1 = array("PERIOD_ID" => $period_id);
					$params2 = array("PAJAK_HEADER_ID" => $pajak_header_id);
					$params3 = array("PAJAK_HEADER_ID" => $pajak_header_id, "ACTION_CODE" => 'Close');
					simtax_update_history("SIMTAX_MASTER_PERIOD", "UPDATE", $params1);
					simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params2);
					simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params3);
					return true;
				} else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
		
	}


	function get_status($kode_cabang="", $nama_pajak="", $bulan_pajak="", $tahun_pajak="", $pembetulan_ke="", $start, $length){

		ini_set('memory_limit', '-1');
		$whereCabang     = "";
		$wherePajak      = "";
		$whereBulan      = "";
		$whereTahun      = "";
		$wherePembetulan = "";

		if($kode_cabang != ""){
			$whereCabang	= " AND SPH.KODE_CABANG = '".$kode_cabang."'";
		}
		if($nama_pajak != ""){
			$wherePajak	= " AND SPH.NAMA_PAJAK = '".$nama_pajak."'";
		}
		if($bulan_pajak != ""){
			$whereBulan	= " AND SPH.BULAN_PAJAK = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " AND SPH.TAHUN_PAJAK = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " AND SPH.PEMBETULAN_KE = ".$pembetulan_ke;
		}

		if($nama_pajak == "PPN MASUKAN"){
			$conDibayarkan  = "AND (SUBSTRB(SPL.NO_DOKUMEN_LAIN,0,2) IN ('01','02','03','04','05','06','09') OR (SUBSTRB(SPL.NO_FAKTUR_PAJAK,0,2) IN ('01','02','03','04','05','06','09') AND SPL.IS_CREDITABLE = '1') OR (SPL.DL_FS = 'dokumen_lain' AND SPL.KD_JENIS_TRANSAKSI IN ('11','12')))";
			$kaliPPN = -1;
		}
		else{
			$conDibayarkan  = "  AND (SUBSTRB(SPL.NO_FAKTUR_PAJAK,0,2) IN ('01','04','06','09') OR SUBSTRB(SPL.NO_DOKUMEN_LAIN,0,2) IN ('01','04','06','09') OR SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))";

			$kaliPPN = 1;
		}
			
		$mainQuery	= "SELECT SPH.NAMA_PAJAK, SPH.PAJAK_HEADER_ID, SPH.MASA_PAJAK,
								SPH.PEMBETULAN_KE, SPH.KODE_CABANG,
								SPH.BULAN_PAJAK, SPH.TAHUN_PAJAK, SPH.USER_NAME, SPH.STATUS,
								TO_CHAR(SPH.CREATION_DATE,'DD-MON-YYYY HH24:MI:SS') CREATION_DATE,
								TO_CHAR(SPH.TGL_SUBMIT_SUP,'DD-MON-YYYY HH24:MI:SS') TGL_SUBMIT_SUP,
								TO_CHAR(SPH.TGL_APPROVE_SUP,'DD-MON-YYYY HH24:MI:SS') TGL_APPROVE_SUP,
								TO_CHAR(SPH.TGL_APPROVE_PUSAT,'DD-MON-YYYY HH24:MI:SS') TGL_APPROVE_PUSAT,
								(SELECT SUM(SPL.JUMLAH_POTONG*".$kaliPPN.")
								  FROM SIMTAX_PAJAK_LINES SPL
								 WHERE SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
								 	".$conDibayarkan."
								   AND SPL.IS_CHEKLIST = 1) TTL_JML_POTONG
						  FROM SIMTAX_PAJAK_HEADERS SPH 
						  WHERE NAMA_PAJAK IN ('PPN MASUKAN', 'PPN KELUARAN')
						 ".$whereCabang.$wherePajak.$whereBulan.$whereTahun.$wherePembetulan."
						  ORDER BY SPH.CREATION_DATE DESC";

		$sql        = "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
	}

	function jumlah_ppn($pajak_header_id, $nama_pajak, $type="", $status=""){

		ini_set('memory_limit', '-1');

		if($nama_pajak == "PPN MASUKAN"){
			$kodeNya         = "1,2,3,4,5,6,9,11,12";
			$kaliPPN         = "-1";
			$conTdkKreditkan = " AND SPL.IS_CREDITABLE = '0'";
			$conDibayarkan   = " AND ((spl.kd_jenis_transaksi IN (".$kodeNya.") and spl.dl_fs = 'dokumen_lain') OR (spl.kd_jenis_transaksi IN (".$kodeNya.") and (dl_fs is null or spl.dl_fs = 'faktur_standar') AND SPL.IS_CREDITABLE = '1'))" ;
		}
		else{
			$kodeNya         = "1,4,6,9";
			$kaliPPN         = "1";
			$conTdkKreditkan = "";
			$conDibayarkan   = " AND spl.kd_jenis_transaksi IN (".$kodeNya.")";
		}

		switch ($type) {
			case 'total_faktur':
					$conPPN  = " AND (SPL.DL_FS = 'faktur_standar' OR SPL.DL_FS IS NULL)";
				break;
			case 'total_doklain':
					$conPPN  = " AND SPL.DL_FS = 'dokumen_lain'";
				break;
			case 'di_kreditkan':
					$conPPN  = $conDibayarkan;
				break;
			case 'tidak_di_kreditkan':
					$conPPN  = $conTdkKreditkan;
				break;
			case 'dipungut_sendiri':
					$conPPN  = $conDibayarkan;
				break;
			case 'dipungut_oleh_pemungut':
					$conPPN  = " AND spl.kd_jenis_transaksi IN (2,3)";
				break;
			case 'tidak_pungut':
					$conPPN  = " AND spl.kd_jenis_transaksi = 7";
				break;
			case 'dibebaskan':
					$conPPN  = " AND spl.kd_jenis_transaksi = 8";
				break;
			case 'ppn_impor':
					$conPPN  = " and spl.dl_fs = 'dokumen_lain' and spl.kd_jenis_transaksi in (11,12)";
				break;
			case 'pmk':
					$conPPN  = " and spl.is_pmk = 1";
				break;
			default:
					$conPPN = $conDibayarkan;
				break;
		}

		if(is_array($pajak_header_id)){
			$data_header   = $this->get_data_header($pajak_header_id[0]);
			$where = " WHERE SPL.PAJAK_HEADER_ID IN ('".implode("','", $pajak_header_id)."')";
		}else{
			$data_header   = $this->get_data_header($pajak_header_id);
			$where = " WHERE SPL.PAJAK_HEADER_ID  = '".$pajak_header_id."'";
		}

		if($status == "rekonsiliasi"){
			$whereStatus = " AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')";
		} else if($status == "download_cetak"){
			$whereStatus = " AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT', 'APPROVAL SUPERVISOR', 'APPROVED BY PUSAT')";
		} else if($status == "download_cetak_comp"){
			$whereStatus = " AND UPPER(SPH.STATUS) = 'APPROVED BY PUSAT' ";
		} else {
			$whereStatus = "";
		}

		$bulan_pajak   = ($data_header) ? $data_header->BULAN_PAJAK : "";
		$tahun_pajak   = ($data_header) ? $data_header->TAHUN_PAJAK : "";

		$get_z_percent = $this->get_z_percent($tahun_pajak, $bulan_pajak);
		$row_z         = $get_z_percent['query']->row_array();
		$z_percent     = $row_z['NILAI'];

		$mainQuery	= "SELECT SUM(SPL.JUMLAH_POTONG*".$kaliPPN.") JUMLAH_POTONG, SUM(NVL(SPL.JUMLAH_POTONG*-1,0)) * (".$z_percent."/100) KOREKSI_PM
								  FROM SIMTAX_PAJAK_LINES SPL
								  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
								  	ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
								  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
									ON SPH.PERIOD_ID = SMP.PERIOD_ID
								 ".$where."
								 ".$whereStatus."
								 AND SPL.IS_CHEKLIST = '1' ".$conPPN;

    try {
      $query            = $this->db->query($mainQuery);
      $rowCount         = $query->num_rows();
      
      $result['query']  = $query;
      $result['jmlRow'] = $rowCount;
      return $result;
    }
    catch (Exception $ex) {
      return null;
    }


	}

	function insert_z_percent($tahun, $terutang_ppn, $tidak_terutang_ppn){

		$terutang_ppn       = simtax_trim($terutang_ppn);
		$tidak_terutang_ppn = simtax_trim($tidak_terutang_ppn);

		$mainQuery   = "SELECT COUNT(*) TOTAL from SIMTAX_Z_PERCENT where TAHUN = '".$tahun."'";
		$query_tahun = $this->db->query($mainQuery);
		$check_tahun = $query_tahun->row()->TOTAL;

		if($check_tahun > 0){
			$sql = "UPDATE SIMTAX_Z_PERCENT SET TERUTANG_PPN =  ".$terutang_ppn.", TIDAK_TERUTANG = ".$tidak_terutang_ppn."
							where TAHUN = '".$tahun."'";
		}
		else{
			$sql = "INSERT INTO SIMTAX_Z_PERCENT (TAHUN, TERUTANG_PPN, TIDAK_TERUTANG) VALUES (".$tahun.",".$terutang_ppn.",".$tidak_terutang_ppn.")";
		}

		$query = $this->db->query($sql);

		if($query){
			return true;
		}

	}

	function get_z_percent($tahun, $bulan){
		
		$mainQuery        = "SELECT * from simtax_z_percent where tahun = '".$tahun."' and bulan = '".$bulan."'";
		$query            = $this->db->query($mainQuery);
		$rowCount         = $query->num_rows();
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;
		
		return $result;
	}

	function get_z_percent_all($tahun="", $start, $length){
		
		ini_set('memory_limit', '-1');

		$where = "";

		if($tahun != ""){
			$where = " WHERE TAHUN = '".$tahun."'";
		}
		
		$mainQuery        = "SELECT * from simtax_z_percent ".$where." order by tahun asc, bulan asc";

		$sql2		= $mainQuery;  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows();

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$mainQuery."
						) a 
						WHERE rownum <=".$start."+".$length."
					)
					WHERE rnum >".$start."";
		
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;

		return $result;
	}

	function delete_efaktur_lines($pajak_header_id){

		$sql = "DELETE FROM SIMTAX_PAJAK_LINES
					WHERE PAJAK_HEADER_ID = '".$pajak_header_id."' AND E_FAKTUR = 'keluaran'";

		$query	= $this->db->query($sql);

		if($query){
			return true;
		}
	}

	function delete_pajak_lines($pajak_line_id){

		$sql = "DELETE FROM SIMTAX_PAJAK_LINES
					WHERE PAJAK_LINE_ID = '".$pajak_line_id."'";

		$query	= $this->db->query($sql);

		if($query){
			return true;
		}
	}

	function get_history($pajak_header_id, $start, $length){

		ini_set('memory_limit', '-1');

		$mainQuery	= "SELECT SAH.*, SPH.BULAN_PAJAK, SPH.MASA_PAJAK, SPH.TAHUN_PAJAK
						FROM SIMTAX_ACTION_HISTORY SAH
						INNER JOIN SIMTAX_PAJAK_HEADERS SPH
						ON SAH.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID 
						WHERE SPH.PAJAK_HEADER_ID = $pajak_header_id
						ORDER BY ACTION_DATE DESC";

		$sql        = "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
	}

	/* Approval */

	function get_approval($pajak_header_id="", $kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category="", $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');
		$where = "";

		if($nama_pajak == "PPN MASUKAN"){
			$q_wp    = "OR UPPER(SMS.VENDOR_NAME)";
			$alias   = "SMS";
		}
		else{
			$q_wp    = "OR UPPER(SMPEL.CUSTOMER_NAME)";
			$alias   = "SMPEL";
		}

		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND (
						UPPER(SPL.NO_FAKTUR_PAJAK) LIKE '%".$q."%'
						OR UPPER(SPL.NO_DOKUMEN_LAIN) LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_NUM) LIKE '%".$q."%'
						".$q_wp." LIKE '%".$q."%'
						OR UPPER(".$alias.".NPWP) LIKE '%".$q."%'
						OR UPPER(".$alias.".ADDRESS_LINE1) LIKE '%".$q."%'
						OR UPPER(SPL.NAMA_WP) LIKE '%".$q."%'
						OR UPPER(SPL.NPWP) LIKE '%".$q."%'
						OR UPPER(SPL.ALAMAT_WP) LIKE '%".$q."%'
						OR UPPER(SPL.AKUN_PAJAK) LIKE '%".$q."%'
						OR SPL.JUMLAH_POTONG LIKE '%".$q."%'
						OR SPL.DPP LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_CURRENCY_CODE) LIKE '%".$q."%'
						) ";

			if (strpos($q, '/') !== false) {
			    $explode = explode("/", $q);
			    $last    = end($explode);
			    if (count($explode) == 3 && $last != ""){
					$where = "AND (trunc(SPL.TANGGAL_FAKTUR_PAJAK) = TO_DATE('".$q."','dd/mm/yy')
								OR trunc(SPL.TANGGAL_DOKUMEN_LAIN) = TO_DATE('".$q."','dd/mm/yy'))";
			    }
			}
		}

		if($pajak_header_id != ""){
			$whereApprove = " WHERE SPL.PAJAK_HEADER_ID = ".$pajak_header_id."
								AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT')";
		}
		else{
			if($kode_cabang == "all"){
				$whereCabang = "";
			}
			else{
				$whereCabang = " AND SPH.KODE_CABANG = '".$kode_cabang."'";
			}
			$whereApprove = " WHERE SPH.NAMA_PAJAK = '".$nama_pajak."'
								AND SPH.BULAN_PAJAK = ".$bulan_pajak."
								".$whereCabang."
								AND SPH.TAHUN_PAJAK = ".$tahun_pajak."
								AND SPH.PEMBETULAN_KE = ".$pembetulan_ke."
								AND UPPER(SPH.STATUS) IN ('APPROVAL SUPERVISOR','APPROVED BY PUSAT')";
		}

		if($category == "dokumen_lain"){
			$whereCategory = " AND SPL.DL_FS = '".$category."'";
		}
		else{
			$whereCategory = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = 'faktur_standar')";
		}

		if($nama_pajak == "PPN MASUKAN"){

		$mainQuery	= "SELECT distinct pajak_line_id xxxx,  SPL.*,
						NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
						SKC.NAMA_CABANG,
						NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMS.NPWP,SPL.NPWP) NPWP1,
						NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
						abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN, spl.dpp jumlah_dpp
					        FROM SIMTAX_PAJAK_LINES SPL 
					  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
					          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					   LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
					          ON SMS.VENDOR_ID = SPL.VENDOR_ID
					         AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
					         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
					  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
					          ON SPH.PERIOD_ID = SMP.PERIOD_ID
				      INNER JOIN SIMTAX_KODE_CABANG SKC
				              ON SPH.KODE_CABANG = SKC.KODE_CABANG
						".$whereApprove."
						AND UPPER(SMP.STATUS) = 'OPEN'
						AND IS_CHEKLIST = '1'
						".$whereCategory."
						".$where."
						ORDER BY SPL.INVOICE_NUM DESC";
		}
		else{
			if($category == "dokumen_lain"){
				$conDokLain = " no_dokumen_lain";
			}
			else{
				$conDokLain = " no_faktur_pajak";
			}

			$nvl_wp  = "nvl(spl.nama_wp, smpel.customer_name) vendor_name,
						nvl(spl.npwp, smpel.npwp) npwp1,
						nvl(spl.alamat_wp, smpel.address_line1) address_line1,";
		/*	$nvl_wp  = "nvl(smpel.customer_name, spl.nama_wp) vendor_name,
						nvl(smpel.npwp, spl.npwp) npwp1,
						nvl(smpel.address_line1, spl.alamat_wp) address_line1,";*/

        $mainQuery    = "SELECT * from  
                        (select spl.*,
		                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
		                        skc.nama_cabang,
								".$nvl_wp."
				               ROW_NUMBER() OVER (PARTITION BY ".$conDokLain." ORDER BY 1) AS rn,
				               sum(abs(jumlah_potong)) over (partition by ".$conDokLain.") as jumlah_potong_ppn,
				               sum(abs(dpp)) over (partition by ".$conDokLain.") as jumlah_dpp
				        from   simtax_pajak_lines  spl
				        inner join simtax_pajak_headers sph
	                              on spl.pajak_header_id = sph.pajak_header_id
	                       left join simtax_master_pelanggan smpel
								on smpel.customer_id      = spl.customer_id
								and smpel.organization_id = spl.organization_id
								and spl.vendor_site_id    = smpel.customer_site_id
	                      inner join simtax_master_period smp
	                              on sph.period_id = smp.period_id
	                      inner join simtax_kode_cabang skc
	                              on sph.kode_cabang = skc.kode_cabang
						".$whereApprove."
						AND UPPER(SMP.STATUS) = 'OPEN'
						AND IS_CHEKLIST = '1'
						".$whereCategory."
						".$where."
				        order BY spl.invoice_num DESC)
						WHERE  rn =1";
		}

		$sql		= "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
		
	}
	
	function save_approval($pajak_header_id="", $nama_pajak, $st, $keterangan, $username, $approval_category)
	{

		if($approval_category == "pusat"){
			$fieldTgl = "TGL_APPROVE_PUSAT";
			if($st == 1){
				$status	="APPROVED BY PUSAT";
				$cat	="APPROVE";
			} else {
				$status	="REJECT BY PUSAT";
				$cat	="REJECT";
			}
		}
		else{
			$fieldTgl = "TGL_APPROVE_SUP";
			if($st == 1){
				$status   = "APPROVAL SUPERVISOR";
				$cat      = "APPROVE";
			} else {
				$status   = "REJECT SUPERVISOR";
				$cat      = "REJECT";
			}
		}
			
		$sql = "UPDATE SIMTAX_PAJAK_HEADERS
					SET ".$fieldTgl." = SYSDATE, 
					USER_NAME           = '".$username."',
					STATUS              = '".$status."',
					LAST_UPDATE_DATE = SYSDATE
					WHERE PAJAK_HEADER_ID = '".$pajak_header_id."'";

		$query	= $this->db->query($sql);

		$sql2	= "INSERT INTO SIMTAX_ACTION_HISTORY
					(PAJAK_HEADER_ID, JENIS_PAJAK, ACTION_DATE, ACTION_CODE, CATATAN, USER_NAME)
					VALUES (".$pajak_header_id.", '".$nama_pajak."' , SYSDATE, '".$cat."', '".$keterangan."', '".$username."')";

		$query2	= $this->db->query($sql2);

		if ($query && $query2){

			$params = array("PAJAK_HEADER_ID" => $pajak_header_id);
			$params2 = array("PAJAK_HEADER_ID" => $pajak_header_id, "ACTION_CODE" => $status, "CATATAN" => $keterangan);
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $params);
			simtax_update_history("SIMTAX_ACTION_HISTORY", "CREATE", $params2);

			return true;
		} else {
			return false;
		}

	}

	function action_get_start($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke)
	{

		if($kode_cabang != ""){
			$whereCabang = " AND SPH.KODE_CABANG= '".$kode_cabang."'";
		}
		else{
			$whereCabang = "";
		}
		
		$sql3 = "SELECT SPH.PAJAK_HEADER_ID, SPH.STATUS, SPH.KETERANGAN, SMP.STATUS STATUS_PERIOD
				 FROM SIMTAX_PAJAK_HEADERS SPH
				 INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID 
				 WHERE SPH.NAMA_PAJAK = '".$nama_pajak."'
				 AND SPH.BULAN_PAJAK = ".$bulan_pajak."
				 AND SPH.TAHUN_PAJAK = ".$tahun_pajak."
				 AND SPH.PEMBETULAN_KE = ".$pembetulan_ke.
				 $whereCabang;

		$query = $this->db->query($sql3);
		
		if($query){			
			return $query;
		} else {
			return false;
		}		
	}


	/* Pembetulan */
	
	function get_pembetulan($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');
		$where = "";
		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND UPPER(SKC.NAMA_CABANG) LIKE '%".$q."%' ";
		}

		if($kode_cabang == "all"){
			$whereCabang = "";
		}
		else{
			$whereCabang = " AND SPH.KODE_CABANG = '".$kode_cabang."'";
		}

		$mainQuery	= "SELECT SPH.*, SMP.STATUS STATUS_PERIOD, SKC.NAMA_CABANG
						FROM SIMTAX_PAJAK_HEADERS SPH
						INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
						INNER JOIN SIMTAX_KODE_CABANG SKC ON SPH.KODE_CABANG = SKC.KODE_CABANG
						WHERE SPH.NAMA_PAJAK = '".$nama_pajak."'
						".$whereCabang."
						AND SPH.BULAN_PAJAk = '".$bulan_pajak."'
						AND SPH.TAHUN_PAJAK = '".$tahun_pajak."'
						AND SPH.PEMBETULAN_KE ='".$pembetulan_ke."'
						AND SPH.PEMBETULAN_KE > 0
						ORDER BY SPH.TAHUN_PAJAK, SPH.BULAN_PAJAK";

		$sql		= "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
		
	}

	function action_save_pembetulan($header_id_max){

		$PARAMETER_1 = $header_id_max;
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
			return true;
		}
	
	}
	
	function action_delete_pembetulan()
	{
		$cabang			= $this->session->userdata('kd_cabang');
		$idPajakHeader  = $this->input->post('header_id');
		$pajak			= $this->input->post('pajak');
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
				$sql2	="DELETE FROM SIMTAX_MASTER_PERIOD where BULAN_PAJAK ='".$bulan."' and TAHUN_PAJAK ='".$tahun."' and upper(NAMA_PAJAK) ='".strtoupper($pajak)."' and PEMBETULAN_KE ='".$pembetulan_ke."' and KODE_CABANG='".$cabang."'";
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


	/* Download */

	function get_download($pajak_header_id="", $kode_cabang="",  $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category, $start, $length, $keywords, $categorys)
	{
		ini_set('memory_limit', '-1');
		$where = "";

		if($nama_pajak == "PPN MASUKAN"){
			$q_wp    = "OR UPPER(SMS.VENDOR_NAME)";
			$alias   = "SMS";
		}
		else{
			$q_wp    = "OR UPPER(SMPEL.CUSTOMER_NAME)";
			$alias   = "SMPEL";
		}

		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND (
						UPPER(SPL.NO_FAKTUR_PAJAK) LIKE '%".$q."%'
						OR UPPER(SPL.NO_DOKUMEN_LAIN) LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_NUM) LIKE '%".$q."%'
						".$q_wp." LIKE '%".$q."%'
						OR UPPER(".$alias.".NPWP) LIKE '%".$q."%'
						OR UPPER(".$alias.".ADDRESS_LINE1) LIKE '%".$q."%'
						OR UPPER(SPL.NAMA_WP) LIKE '%".$q."%'
						OR UPPER(SPL.NPWP) LIKE '%".$q."%'
						OR UPPER(SPL.ALAMAT_WP) LIKE '%".$q."%'
						OR UPPER(SPL.AKUN_PAJAK) LIKE '%".$q."%'
						OR SPL.JUMLAH_POTONG LIKE '%".$q."%'
						OR SPL.DPP LIKE '%".$q."%'
						OR UPPER(SPL.INVOICE_CURRENCY_CODE) LIKE '%".$q."%'
						) ";

			if (strpos($q, '/') !== false) {
			    $explode = explode("/", $q);
			    $last    = end($explode);
			    if (count($explode) == 3 && $last != ""){
					$where = "AND (trunc(SPL.TANGGAL_FAKTUR_PAJAK) = TO_DATE('".$q."','dd/mm/yy')
								OR trunc(SPL.TANGGAL_DOKUMEN_LAIN) = TO_DATE('".$q."','dd/mm/yy'))";
			    }
			}
		}

		if($pajak_header_id != ""){

			$whereDownload = " where spl.pajak_header_id = ".$pajak_header_id;

		}
		else{

			$whereDownload = " Where sph.nama_pajak = '".$nama_pajak."'
								and sph.bulan_pajak = ".$bulan_pajak."
								and sph.tahun_pajak = ".$tahun_pajak."
								and sph.pembetulan_ke  = ".$pembetulan_ke;
								
			if($kode_cabang != ""){
				$whereDownload .= " and sph.kode_cabang = ".$kode_cabang;
			}
		}

		if($category == "dokumen_lain"){
			$whereCategory = " and spl.dl_fs = '".$category."'";
		}
		else{
			$whereCategory = " and (spl.dl_fs is null or spl.dl_fs = 'faktur_standar')";
		}

		if ($categorys == "download"){
			$status_dw = " AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT', 'APPROVAL SUPERVISOR', 'APPROVED BY PUSAT') ";
		} else{
			$status_dw = "AND UPPER(SPH.STATUS) = 'APPROVED BY PUSAT' ";
		}

		if($nama_pajak == "PPN MASUKAN"){

		$mainQuery	= "SELECT distinct pajak_line_id xxxx,  SPL.*,
						NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
						SKC.NAMA_CABANG, 
						NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMS.NPWP,SPL.NPWP) NPWP1,
						NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
						abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN, spl.dpp JUMLAH_DPP
					        FROM SIMTAX_PAJAK_LINES SPL 
					  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
					          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					   LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
					          ON SMS.VENDOR_ID = SPL.VENDOR_ID
					         AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
					         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
					  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
					          ON SPH.PERIOD_ID = SMP.PERIOD_ID
				      INNER JOIN SIMTAX_KODE_CABANG SKC
				              ON SPH.KODE_CABANG = SKC.KODE_CABANG
						".$whereDownload."
						--AND UPPER(SPH.STATUS) IN ('SUBMIT', 'REJECT BY PUSAT', 'APPROVAL SUPERVISOR', 'APPROVED BY PUSAT')
						".$status_dw."
						AND IS_CHEKLIST = '1'
						".$whereCategory."
						".$where."
						ORDER BY SPL.INVOICE_NUM DESC";
		}
		else{


		$nvl_wp  = "nvl(spl.nama_wp, smpel.customer_name) vendor_name,
					nvl(spl.npwp, smpel.npwp) npwp1,
					nvl(spl.alamat_wp, smpel.address_line1) address_line1,";
	/*	$nvl_wp  = "nvl(smpel.customer_name, spl.nama_wp) vendor_name,
					nvl(smpel.npwp, spl.npwp) npwp1,
					nvl(smpel.address_line1, spl.alamat_wp) address_line1,";*/

		if($category == "dokumen_lain"){
			$conDokLain = " no_dokumen_lain";
		}
		else{
			$conDokLain = " no_faktur_pajak";
		}

        $mainQuery    = "SELECT * from  
                        (select distinct spl.pajak_line_id xxx, spl.*,
		                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
		                        skc.nama_cabang,
		                        ".$nvl_wp."
				               ROW_NUMBER() OVER (PARTITION BY ".$conDokLain." ORDER BY 1) AS rn,
				               sum(abs(jumlah_potong)) over (partition by ".$conDokLain.") as jumlah_potong_ppn,
				               sum(abs(dpp)) over (partition by ".$conDokLain.") as jumlah_dpp
				        from   simtax_pajak_lines  spl
				        inner join simtax_pajak_headers sph
	                              on spl.pajak_header_id = sph.pajak_header_id
	                       left join simtax_master_pelanggan smpel
								on smpel.customer_id      = spl.customer_id
								and smpel.organization_id = spl.organization_id
								and spl.vendor_site_id    = smpel.customer_site_id
	                      inner join simtax_master_period smp 
	                              on sph.period_id = smp.period_id
	                      inner join simtax_kode_cabang skc
	                              on sph.kode_cabang = skc.kode_cabang
						".$whereDownload."
						--and upper(sph.status) NOT IN ('DRAFT', 'REJECT SUPERVISOR', 'CLOSE')
						".$status_dw."
						and spl.is_cheklist = '1'
						".$whereCategory."
						".$where."
				        order BY spl.invoice_num DESC)
						WHERE  rn =1";
		}
	
		$sql		= "SELECT * FROM (
						SELECT rownum rnum, a.* FROM ( ".$mainQuery." ) a 
						WHERE rownum <= ".$start." + ".$length." ) WHERE rnum > ".$start;

		$queryCount       = $this->db->query($mainQuery);
		$rowCount         = $queryCount->num_rows();
		$query            = $this->db->query($sql);
		
		$result['query']  = $query;
		$result['jmlRow'] = $rowCount;

		return $result;
		
	}

	function get_data_csv($pajak_header_id, $nama_pajak, $category, $dilaporkan)
	{

		if($category == "dokumen_lain"){
			$whereCategory = " AND SPL.DL_FS = '".$category."'";
		}
		else{
			$whereCategory = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = '".$category."')";
		}

		if($dilaporkan == "pmk"){
			$whereCategory .= " AND SPL.IS_PMK = 1 AND SPL.IS_CHEKLIST = 1";
		}
		elseif($dilaporkan == "tidak_dilaporkan"){
			$whereCategory .= " AND SPL.IS_CHEKLIST = 0";
		}
		else{
			$whereCategory .= " AND SPL.IS_CHEKLIST = 1";
		}

		if($nama_pajak == "PPN MASUKAN"){
			$jml_ppn = " SPL.JUMLAH_POTONG * -1 JUMLAH_POTONG_PPN";
			$nvl_wp  = "NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMS.NPWP,SPL.NPWP) NPWP1,
						NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,";
			$alias   = "SMS";
			$join    = "LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
							ON SMS.VENDOR_ID        = SPL.VENDOR_ID
							AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SMS.VENDOR_SITE_ID  = SPL.VENDOR_SITE_ID";
		}
		else{
			$jml_ppn = " SPL.JUMLAH_POTONG JUMLAH_POTONG_PPN";
			$nvl_wp  = "NVL(SPL.NAMA_WP, SMPEL.CUSTOMER_NAME) VENDOR_NAME,
						NVL(SPL.NPWP, SMPEL.NPWP) NPWP1,
						NVL(SPL.ALAMAT_WP, SMPEL.ADDRESS_LINE1) ADDRESS_LINE1,";
			/*$nvl_wp  = "NVL(SMPEL.CUSTOMER_NAME, SPL.NAMA_WP) VENDOR_NAME,
						NVL(SMPEL.NPWP, SPL.NPWP) NPWP1,
						NVL(SMPEL.ADDRESS_LINE1, SPL.ALAMAT_WP) ADDRESS_LINE1,";*/
			$alias   = "SMPEL";
			$join    = "LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL
							ON SMPEL.CUSTOMER_ID      = SPL.CUSTOMER_ID
							AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
							AND SPL.vendor_site_id    = SMPEL.customer_site_id";
		}

		if($dilaporkan == "summary"){

			if($category == "dokumen_lain"){
				$conDokLain = " no_dokumen_lain";
			}
			else{
				$conDokLain = " no_faktur_pajak";
			}

			$nvl_wp  = "nvl(spl.nama_wp, smpel.customer_name) vendor_name,
						nvl(spl.npwp, smpel.npwp) npwp1,
						nvl(spl.alamat_wp, smpel.address_line1) address_line1,";
		/*	$nvl_wp  = "nvl(smpel.customer_name, spl.nama_wp) vendor_name,
						nvl(smpel.npwp, spl.npwp) npwp1,
						nvl(smpel.address_line1, spl.alamat_wp) address_line1,";*/

	        $sql    = "SELECT * from  
	                        (select spl.*,
			                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
			                        skc.nama_cabang,
			                        ".$nvl_wp."
					               ROW_NUMBER() OVER (PARTITION BY ".$conDokLain." ORDER BY 1) AS rn,
					               sum(abs(jumlah_potong)) over (partition by ".$conDokLain.") as jumlah_potong_ppn
					        from   simtax_pajak_lines  spl
					        inner join simtax_pajak_headers sph
		                              on spl.pajak_header_id = sph.pajak_header_id
		                       left join simtax_master_pelanggan smpel
									on smpel.customer_id      = spl.customer_id
									and smpel.organization_id = spl.organization_id
									and spl.vendor_site_id    = smpel.customer_site_id
		                      inner join simtax_master_period smp 
		                              on sph.period_id = smp.period_id
		                      inner join simtax_kode_cabang skc
		                              on sph.kode_cabang = skc.kode_cabang
							WHERE SPH.PAJAK_HEADER_ID = $pajak_header_id
							AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')
							AND UPPER(SMP.STATUS) = 'OPEN'
							".$whereCategory."
					        order BY spl.invoice_num DESC)
							WHERE  rn =1";
		}
		else{

			$sql = "SELECT distinct pajak_line_id xxxx,  SPL.*,
						NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
						".$nvl_wp."
						".$jml_ppn."
					        FROM SIMTAX_PAJAK_LINES SPL 
					  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
					          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					    ".$join."
					  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
					          ON SPH.PERIOD_ID = SMP.PERIOD_ID
						WHERE SPH.PAJAK_HEADER_ID = $pajak_header_id
						AND UPPER(SPH.STATUS) IN ('DRAFT', 'REJECT SUPERVISOR')
						AND UPPER(SMP.STATUS) = 'OPEN'
						".$whereCategory."
						ORDER BY SPL.INVOICE_NUM DESC";

		}

		$query = $this->db->query($sql);
		return $query;

	}

	function get_csv($pajak_header_id="", $kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $jenis_dokumen, $creditable="", $groupByInvoiceNUm=false)
	{

		if($pajak_header_id != ""){
			$where = " WHERE SPL.PAJAK_HEADER_ID = ".$pajak_header_id;
		}
		else{
			$whereCabang = "";
			if($kode_cabang != ""){
				$whereCabang = " AND SPH.KODE_CABANG = '".$kode_cabang."'";
			}
			$where = " WHERE SPH.NAMA_PAJAK = '".$nama_pajak."'
								AND SPH.BULAN_PAJAK = '".$bulan_pajak."'
								AND SPH.TAHUN_PAJAK = '".$tahun_pajak."'
								".$whereCabang."
								AND SPH.PEMBETULAN_KE = '".$pembetulan_ke."'";
		}

		// if($category_download == "kompilasi"){
		// 	$whereStatus = " --AND UPPER(SPH.STATUS) NOT IN ('DRAFT', 'REJECT SUPERVISOR')";
		// }
		// else{
			$whereStatus = " AND UPPER(SPH.STATUS) NOT IN ('DRAFT', 'REJECT SUPERVISOR')";
		// }

		if($jenis_dokumen == "dokumen_lain"){
			$whereJenisDokumen = " AND SPL.DL_FS = '".$jenis_dokumen."'";
		}
		else{
			$whereJenisDokumen = " AND (SPL.DL_FS IS NULL OR SPL.DL_FS = '".$jenis_dokumen."')";
		}

		if($creditable == "creditable"){
			$whereCreditable = " AND SPL.IS_CREDITABLE = '1'";
		}
		elseif($creditable == "not_creditable"){
			$whereCreditable = " AND SPL.IS_CREDITABLE = '0'";
		}
		else{
			$whereCreditable = "";
		}
		
		$jumlah_potongnya = " abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN";

		if($nama_pajak == "PPN MASUKAN"){

			$mainQuery	= "SELECT distinct pajak_line_id xxxx,  SPL.*,
							NVL(NVL(SUBSTRB(SPL.NO_FAKTUR_PAJAK,3,1),''), NVL(SUBSTRB(SPL.NO_DOKUMEN_LAIN,3,1),'')) FG_PENGGANTI_NEW,
							SKC.NAMA_CABANG, 
							NVL(SMS.VENDOR_NAME,SPL.NAMA_WP) VENDOR_NAME,
							NVL(SMS.NPWP,SPL.NPWP) NPWP1,
							NVL(SMS.ADDRESS_LINE1,SPL.ALAMAT_WP) ADDRESS_LINE1,
							abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN
						        FROM SIMTAX_PAJAK_LINES SPL 
						  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
						          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
						   LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS
						          ON SMS.VENDOR_ID = SPL.VENDOR_ID
						         AND SMS.ORGANIZATION_ID = SPL.ORGANIZATION_ID
						         AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
						  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
						          ON SPH.PERIOD_ID = SMP.PERIOD_ID
					      INNER JOIN SIMTAX_KODE_CABANG SKC
					              ON SPH.KODE_CABANG = SKC.KODE_CABANG
							".$where."
							".$whereStatus."
							AND IS_CHEKLIST = '1'
							".$whereJenisDokumen."
							".$whereCreditable."
							ORDER BY SPL.INVOICE_NUM DESC";
		}
		else{

			$nvl_wp  = "nvl(spl.nama_wp, smpel.customer_name) vendor_name,
						nvl(spl.npwp, smpel.npwp) npwp1,
						nvl(spl.alamat_wp, smpel.address_line1) address_line1,";
		/*	$nvl_wp  = "nvl(smpel.customer_name, spl.nama_wp) vendor_name,
						nvl(smpel.npwp, spl.npwp) npwp1,
						nvl(smpel.address_line1, spl.alamat_wp) address_line1,";*/

			if($jenis_dokumen == "dokumen_lain"){
				$conDokLain = " no_dokumen_lain";
			}
			else{
				$conDokLain = " no_faktur_pajak";
			}

	        $mainQuery    = "SELECT * from  
	                        (select spl.*,
			                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
			                        skc.nama_cabang,
			                        ".$nvl_wp."
					               ROW_NUMBER() OVER (PARTITION BY ".$conDokLain." ORDER BY 1) AS rn,
					               sum(abs(jumlah_potong)) over (partition by ".$conDokLain.") as jumlah_potong_ppn
					        from   simtax_pajak_lines  spl
					        inner join simtax_pajak_headers sph
		                              on spl.pajak_header_id = sph.pajak_header_id
		                       left join simtax_master_pelanggan smpel
									on smpel.customer_id      = spl.customer_id
									and smpel.organization_id = spl.organization_id
									and spl.vendor_site_id    = smpel.customer_site_id
		                      inner join simtax_master_period smp 
		                              on sph.period_id = smp.period_id
		                      inner join simtax_kode_cabang skc
		                              on sph.kode_cabang = skc.kode_cabang
							".$where."
							".$whereStatus."
							and spl.is_cheklist = '1'
							".$whereJenisDokumen."
							".$whereCreditable."
					        order BY spl.invoice_num DESC)
							WHERE  rn =1";
		}

		$query = $this->db->query($mainQuery);
		return $query;

	}

	function check_duplicate_faktur_doklain($pajak_header_id, $nama_pajak, $category=""){

		if($nama_pajak == "PPN MASUKAN"){
			$fieldAdded = "";
		}
		else{
			$fieldAdded = ", akun_pajak, dpp, jumlah_potong, pst_pelayanan_desc";
		}

		if($category == "dokumen_lain"){

			$sql = "SELECT  * FROM    (
			        SELECT t.no_dokumen_lain, ROW_NUMBER() OVER (PARTITION BY no_dokumen_lain".$fieldAdded."
				        ORDER BY invoice_accounting_date desc) AS rn
				        FROM    simtax_pajak_lines t
				        where t.pajak_header_id = '".$pajak_header_id."'
			                    and t.IS_CHEKLIST = '1' and t.dl_fs = 'dokumen_lain'
			        ) WHERE rn > 1";
		}
		else{
			$sql = "SELECT  * FROM    (
				        SELECT t.no_faktur_pajak, ROW_NUMBER() OVER (PARTITION BY no_faktur_pajak".$fieldAdded."
					        ORDER BY invoice_accounting_date desc) AS rn
					        FROM    simtax_pajak_lines t
					        where t.pajak_header_id = '".$pajak_header_id."'
			                    and IS_CHEKLIST = '1' and (dl_fs is null or dl_fs = 'faktur_standar')
				        ) WHERE rn > 1";
		}
		
		$query              = $this->db->query($sql);
		$rowCount           = $query->num_rows();
		
		$result['num_rows'] = $rowCount;
		$result['query']    = $query;

		return $result;
		
	}

	function get_by_duplicate_invoice($pajak_header_id){

		if(is_array($pajak_header_id)){
			$implode = 0;

			if($pajak_header_id > 0){
				$implode = implode(",", $pajak_header_id);
			}
			$where = "where SPL.pajak_header_id in (".$implode.")";
		}
		else{
			$where = "where SPL.pajak_header_id = '".$pajak_header_id."'";
		}

		$sql = "SELECT invoice_num, sum(abs(SPL.JUMLAH_POTONG)) JUMLAH_POTONG_PPN, sum(DPP) JUMLAH_DPP, COUNT(*) TOTAL
				FROM SIMTAX_PAJAK_LINES SPL 
				  INNER JOIN SIMTAX_PAJAK_HEADERS SPH
				          ON SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
				  INNER JOIN SIMTAX_MASTER_PERIOD SMP 
				          ON SPH.PERIOD_ID = SMP.PERIOD_ID
				         			".$where."
									and dl_fs             = 'dokumen_lain'
									AND SPL.IS_CHEKLIST   = 1
									group by invoice_num
									having count (invoice_num) > 1
							order BY invoice_num DESC";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
		
	}

}