<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixed_asset_mdl extends CI_Model {
  public function __construct()  {
    parent::__construct();		    

    $this->kode_cabang = $this->session->userdata('kd_cabang');
  }

  public function tgl_db($date)	{
		$part = explode("-",$date);
		$newDate = $part[2]."-".$part[1]."-".$part[0];
		return $newDate;
  }
  
  //B = Bangunan, N = Non Bangunan, T = tak berwujud
  public function get_daftar($KELOMPOK_FIXED_ASSET="") {
    ini_set('memory_limit', '-1');
    $kode_cabang = $this->kode_cabang;
    $q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
    $bulanfrom = ($_REQUEST['_searchBulanfrom'])? $_REQUEST['_searchBulanfrom']:"";
	$bulanto = ($_REQUEST['_searchBulanto'])? $_REQUEST['_searchBulanto']:"";
    $tahun = ($_REQUEST['_searchTahun'])? $_REQUEST['_searchTahun']:"";
    $start = ($_REQUEST['start'])? $_REQUEST['start']:"0";
    $length = ($_REQUEST['length'])? $_REQUEST['length']:"10";
    $sqlExec = "select a.ASSET_NO,a.NAMA_AKTIVA,a.KETERANGAN,a.TANGGAL_BELI,a.HARGA_PEROLEHAN,
      KELOMPOK_AKTIVA,KELOMPOK_FIXED_ASSET,JENIS_USAHA,STATUS_PEMBEBANAN,TANGGAL_JUAL,
      a.HARGA_JUAL,a.PH_FISKAL,a.AKUMULASI_PENYUSUTAN_FISKAL,a.NILAI_SISA_BUKU_FISKAL,
      a.PENYUSUTAN_FISKAL,a.PEMBEBANAN,a.AKUMULASI_PENYUSUTAN,
      a.NSBF,a.JENIS_AKTIVA,a.JENIS_HARTA,a.IS_CHECKLIST,a.KODE_CABANG,a.REKON_FIXED_ASSET_ID,
      a.MASA_PAJAK, a.TAHUN_PAJAK, b.STATUS
      from SIMTAX_REKON_FIXED_ASSET a
      left join SIMTAX_PAJAK_HEADERS b
      on b.pajak_header_id = a.pajak_header_id
      where 1=1 ";
    $sqlsum = "select nvl(sum(HARGA_PEROLEHAN),0) as HARGA_PEROLEHAN
      from SIMTAX_REKON_FIXED_ASSET 
      where IS_CHECKLIST = 1 ";
    if ($KELOMPOK_FIXED_ASSET != '') {
      $sqlExec .= " AND a.KELOMPOK_FIXED_ASSET = '".$KELOMPOK_FIXED_ASSET."'";
      $sqlsum .= " AND KELOMPOK_FIXED_ASSET = '".$KELOMPOK_FIXED_ASSET."'";
    }
    if ($kode_cabang != '') {
      $sqlExec .= " AND a.KODE_CABANG = '".$kode_cabang."'";
      $sqlsum .= " AND KODE_CABANG = '".$kode_cabang."'";
    }
    if ($bulanfrom != '') {
      $sqlExec .= " AND a.BULAN_PAJAK between '".$bulanfrom."' and '".$bulanto."'";
      $sqlsum .= " AND BULAN_PAJAK  between '".$bulanfrom."' and '".$bulanto."'";
    }
    if ($tahun != '') {
      $sqlExec .= " AND a.TAHUN_PAJAK = '".$tahun."'";
      $sqlsum .= " AND TAHUN_PAJAK = '".$tahun."'";
    }
    if ($q != '') {
      $sqlExec .= " and (NAMA_AKTIVA like '%".$q."%' OR JENIS_AKTIVA like '%".$q."%') ";
      $sqlsum .= " and (NAMA_AKTIVA like '%".$q."%' OR JENIS_AKTIVA like '%".$q."%') ";
    }
    $query = $this->db->query($sqlExec);
    $querysum = $this->db->query($sqlsum);
    $rowCount = $query->num_rows();
    $result['query'] = $query;
    $result['querysum'] = $querysum;
    $sql		="SELECT * FROM (
      SELECT rownum rnum, a.* 
      FROM(
        ".$sqlExec."
      ) a 
      WHERE rownum <=".$start."+".$length."
    )
    WHERE rnum >".$start."";
    $query = $this->db->query($sql);
    $result['query'] = $query;
    $result['rowCount'] = $rowCount;
    return $result;
  }

  //B = Bangunan, N = Non Bangunan, T = tak berwujud
  public function get_format_csv($KELOMPOK_FIXED_ASSET="") {
    ini_set('memory_limit', '-1');
    $kode_cabang = $this->kode_cabang;
    $bulanfrom = ($_REQUEST['bulanfrom'])? $_REQUEST['bulanfrom']:"";
	$bulanto = ($_REQUEST['bulanto'])? $_REQUEST['bulanto']:"";
    $tahun = ($_REQUEST['tahun'])? $_REQUEST['tahun']:"";
    $sqlExec = "select ASSET_NO,NAMA_AKTIVA,KETERANGAN,TANGGAL_BELI,HARGA_PEROLEHAN,
      KELOMPOK_AKTIVA,KELOMPOK_FIXED_ASSET,JENIS_USAHA,STATUS_PEMBEBANAN,TANGGAL_JUAL,
      HARGA_JUAL,PH_FISKAL,AKUMULASI_PENYUSUTAN_FISKAL,NILAI_SISA_BUKU_FISKAL,
      PENYUSUTAN_FISKAL,PEMBEBANAN,AKUMULASI_PENYUSUTAN,
      NSBF,JENIS_AKTIVA,JENIS_HARTA,IS_CHECKLIST,KODE_CABANG,ASSET_NO,REKON_FIXED_ASSET_ID,PAJAK_HEADER_ID,
	  BULAN_PAJAK, TAHUN_PAJAK
      from SIMTAX_REKON_FIXED_ASSET 
      where ";
    if ($KELOMPOK_FIXED_ASSET != '') {
      $sqlExec .= " KELOMPOK_FIXED_ASSET = '".$KELOMPOK_FIXED_ASSET."'";
    }
    if ($kode_cabang != '') {
      $sqlExec .= " AND KODE_CABANG = '".$kode_cabang."'";
    }
    if ($bulanfrom != '') {
      $sqlExec .= " AND BULAN_PAJAK between '".$bulanfrom."' and '".$bulanto."'";
    }
    if ($tahun != '') {
      $sqlExec .= " AND TAHUN_PAJAK = '".$tahun."'";
    }
    $query = $this->db->query($sqlExec);
    return $query;
  }

  public function save_rekonsiliasi() {
    $isNewRecord = $this->input->post('isNewRecord');
    $ASSET_NO = $this->input->post('ASSET_NO');
    $KELOMPOK_FIXED_ASSET = $this->input->post('KELOMPOK_FIXED_ASSET');
    $JENIS_AKTIVA = $this->input->post('JENIS_AKTIVA');
    $NAMA_AKTIVA = $this->input->post('NAMA_AKTIVA');
    $TANGGAL_BELI = ($this->input->post('TANGGAL_BELI'))?$this->tgl_db($this->input->post('TANGGAL_BELI')):'';
    if ($TANGGAL_BELI != ""){
      $TANGGAL_BELI = strtoupper(date("d-M-y", strtotime($TANGGAL_BELI)));
    }
    $KETERANGAN = $this->input->post('KETERANGAN');
    $HARGA_PEROLEHAN = intval(str_replace( ',','',$this->input->post('HARGA_PEROLEHAN')));
    $KELOMPOK_AKTIVA = $this->input->post('KELOMPOK_AKTIVA');
    $JENIS_HARTA = $this->input->post('JENIS_HARTA');
    $JENIS_USAHA = $this->input->post('JENIS_USAHA');
    $STATUS_PEMBEBANAN = $this->input->post('STATUS_PEMBEBANAN');
    $TANGGAL_JUAL = ($this->input->post('TANGGAL_JUAL'))?$this->tgl_db($this->input->post('TANGGAL_JUAL')):'';
    $HARGA_JUAL = intval(str_replace( ',','',$this->input->post('HARGA_JUAL')));
    $PH_FISKAL = intval(str_replace( ',','',$this->input->post('PH_FISKAL')));
    $AKUMULASI_PENYUSUTAN_FISKAL = intval(str_replace( ',','',$this->input->post('AKUMULASI_PENYUSUTAN_FISKAL')));
    $NILAI_SISA_BUKU_FISKAL = intval(str_replace( ',','',$this->input->post('NILAI_SISA_BUKU_FISKAL')));
    $PENYUSUTAN_FISKAL = intval(str_replace( ',','',$this->input->post('PENYUSUTAN_FISKAL')));
    $PEMBEBANAN = intval(str_replace( ',','',$this->input->post('PEMBEBANAN')));
    $AKUMULASI_PENYUSUTAN = intval(str_replace( ',','',$this->input->post('AKUMULASI_PENYUSUTAN')));
    $NSBF = intval(str_replace( ',','',$this->input->post('NSBF')));
    $REKON_FIXED_ASSET_ID = $this->input->post('REKON_FIXED_ASSET_ID');

    if ($isNewRecord == 1) {
      $sql = "insert into SIMTAX_REKON_FIXED_ASSET (JENIS_AKTIVA,NAMA_AKTIVA,KETERANGAN,TANGGAL_BELI,HARGA_PEROLEHAN,KELOMPOK_AKTIVA,
        KELOMPOK_FIXED_ASSET,JENIS_USAHA,STATUS_PEMBEBANAN,TANGGAL_JUAL,HARGA_JUAL,PH_FISKAL,AKUMULASI_PENYUSUTAN_FISKAL,
        NILAI_SISA_BUKU_FISKAL,PENYUSUTAN_FISKAL,PEMBEBANAN,AKUMULASI_PENYUSUTAN,NSBF) 
        values (?,?,?,?,?,?,
        ?,?,?,?,?,?,?,
        ?,?,?,?,?)";
      $query = $this->db->query($sql,array($JENIS_AKTIVA,$NAMA_AKTIVA,$KETERANGAN,$TANGGAL_BELI,$HARGA_PEROLEHAN,$KELOMPOK_AKTIVA,
      $KELOMPOK_FIXED_ASSET,$JENIS_USAHA,$STATUS_PEMBEBANAN,$TANGGAL_JUAL,$HARGA_JUAL,$PH_FISKAL,$AKUMULASI_PENYUSUTAN_FISKAL,
      $NILAI_SISA_BUKU_FISKAL,$PENYUSUTAN_FISKAL,$PEMBEBANAN,$AKUMULASI_PENYUSUTAN,$NSBF));
    } else {
      $sql = "update SIMTAX_REKON_FIXED_ASSET 
        set JENIS_AKTIVA = ?, NAMA_AKTIVA = ?, KETERANGAN = ?, TANGGAL_BELI = ?, HARGA_PEROLEHAN = ?, KELOMPOK_AKTIVA = ?,
        KELOMPOK_FIXED_ASSET = ?, JENIS_USAHA = ?, STATUS_PEMBEBANAN = ?, TANGGAL_JUAL = ?, HARGA_JUAL = ?, PH_FISKAL = ?,
        AKUMULASI_PENYUSUTAN_FISKAL = ?, NILAI_SISA_BUKU_FISKAL = ?, PENYUSUTAN_FISKAL = ?, PEMBEBANAN = ?, AKUMULASI_PENYUSUTAN = ?,
        NSBF = ? 
        where ASSET_NO = ? AND REKON_FIXED_ASSET_ID = ?";
      $query = $this->db->query($sql,array($JENIS_AKTIVA,$NAMA_AKTIVA,$KETERANGAN,$TANGGAL_BELI,$HARGA_PEROLEHAN,$KELOMPOK_AKTIVA,
        $KELOMPOK_FIXED_ASSET,$JENIS_USAHA,$STATUS_PEMBEBANAN,$TANGGAL_JUAL,$HARGA_JUAL,$PH_FISKAL,$AKUMULASI_PENYUSUTAN_FISKAL,
        $NILAI_SISA_BUKU_FISKAL,$PENYUSUTAN_FISKAL,$PEMBEBANAN,$AKUMULASI_PENYUSUTAN,$NSBF,$ASSET_NO, $REKON_FIXED_ASSET_ID
      ));  
    }
    if ($query){
			return 1;
		} else {
			return false;
		}
  }

  //kel_asset_1 = Bangunan(B), kel_asset_2 = Non Bangunan(N), kel_asset_3 = tak berwujud(T)
	function get_summ_fa_bnbtb($KEL_ASSET_1="",$KEL_ASSET_2="",$KEL_ASSET_3="")
	{
		ini_set('memory_limit', '-1');
    	$kode_cabang = $this->kode_cabang;
		$bulanfrom = ($_REQUEST['_searchBulanfrom'])? $_REQUEST['_searchBulanfrom']:"";
		$bulanto = ($_REQUEST['_searchBulanto'])? $_REQUEST['_searchBulanto']:"";
		$tahun = ($_REQUEST['_searchTahun'])? $_REQUEST['_searchTahun']:"";
		
		$sqlkelasset1 = "";
		$sqlkelasset2 = "";
		$sqlkelasset3 = "";
		$wcab = "";
		$wbln = "";
		$wthn = "";
		$wcabs = "";
		$wblns = "";
		$wthns = "";
		if ($KEL_ASSET_1 != '' ) {
		  	$sqlkelasset1 .= " AND KELOMPOK_FIXED_ASSET = '".$KEL_ASSET_1."'";
		}
		if ($KEL_ASSET_2 != '' ) {
			$sqlkelasset2 .= " AND KELOMPOK_FIXED_ASSET = '".$KEL_ASSET_2."'";
		}
		if ($KEL_ASSET_3 != '' ) {
			$sqlkelasset3 .= " AND KELOMPOK_FIXED_ASSET = '".$KEL_ASSET_3."'";
		}

		if ($kode_cabang != '') {
			$wcab .= " AND KODE_CABANG = '".$kode_cabang."'";
			$wcabs .= " AND a.KODE_CABANG = '".$kode_cabang."'";
		}
		if ($bulanfrom != '') {
			$wbln .= " AND BULAN_PAJAK between '".$bulanfrom."' and '".$bulanto."'";
			$wblns .= " AND a.BULAN_PAJAK between '".$bulanfrom."' and '".$bulanto."'";
		}
		if ($tahun != '') {
			$wthn .= " AND TAHUN_PAJAK = '".$tahun."'";
			$wthns .= " AND a.TAHUN_PAJAK = '".$tahun."'";
		}
		
		$sqlsum = "select 
					(
					 select nvl(sum(HARGA_PEROLEHAN),0) 
						  from SIMTAX_REKON_FIXED_ASSET 
						  where IS_CHECKLIST = 1
              ".$sqlkelasset1."
              ".$wcab."
              ".$wbln."
              ".$wthn."
					) as SUMM_HP_B,
					(
					 select nvl(sum(HARGA_PEROLEHAN),0) 
						  from SIMTAX_REKON_FIXED_ASSET 
						  where IS_CHECKLIST = 1
              ".$sqlkelasset2."
              ".$wcab."
              ".$wbln."
              ".$wthn."
					) as SUMM_HP_N,
					(
					 select nvl(sum(HARGA_PEROLEHAN),0) 
						  from SIMTAX_REKON_FIXED_ASSET 
						  where IS_CHECKLIST = 1
              ".$sqlkelasset3."
              ".$wcab."
              ".$wbln."
              ".$wthn."
          ) as SUMM_HP_T,
          (
            select count(b.status)
            from simtax_rekon_fixed_asset a
            left join simtax_pajak_headers b
            on a.pajak_header_id = b.pajak_header_id
            where a.IS_CHECKLIST = 1 and b.STATUS = 'SUBMIT'
              ".$wcabs."
              ".$wblns."
              ".$wthns."
         ) CNT_SUBMIT,
		 (
            select distinct b.status
            from simtax_rekon_fixed_asset a
            left join simtax_pajak_headers b
            on a.pajak_header_id = b.pajak_header_id
            where a.IS_CHECKLIST = 1 
			and b.status is not null
              ".$wcabs."
              ".$wblns."
              ".$wthns."
         ) STATUS_REKON
          from dual ";
		 
		$query 		= $this->db->query($sqlsum);			
		return $query;		
  }
  
  function action_delete_rekon()
	{
		$rekon_fa_id		= $this->input->post('rekon_fixed_asset_id');
		
		$sql	="delete from SIMTAX_REKON_FIXED_ASSET
                    where REKON_FIXED_ASSET_ID = ".$rekon_fa_id;	               
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}	
  }
  
  function action_submit_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;    //sesuaikan  kondisi dengan get_header_id
		$user = $this->session->userdata('identity');
		$addAkun = $this->input->post('fAddAkun');
		$addBulan = $this->input->post('fAddBulan');
		$addBulanto = $this->input->post('fAddBulanto');
		$addTahun = $this->input->post('fAddTahun');
		$pembetulan = $this->input->post('fAddPembetulan');
		$date = date('Y-m-d H:i:s');
    	$header = $this->get_header_id($addAkun, $addBulan, $addBulanto, $addTahun, $pembetulan);
   
		if ($header) {
			$sql = "UPDATE SIMTAX_PAJAK_HEADERS set STATUS='SUBMIT', TGL_SUBMIT_SUP=sysdate , USER_NAME = '" . $user . "'
					 where PAJAK_HEADER_ID ='" . $header . "' and KODE_CABANG='" . $cabang . "'";
			$query = $this->db->query($sql);
			if ($query) {
				$sql2 = "Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (" . $header . ",'" . $addAkun . "',sysdate,'SUBMIT','" . $user . "')";
				$query2 = $this->db->query($sql2);
				if ($query2) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
  }

  function action_reject_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;    //sesuaikan  kondisi dengan get_header_id
		$user = $this->session->userdata('identity');
		$addAkun = $this->input->post('fAddAkun');
		$addBulan = $this->input->post('fAddBulan');
		$addBulanto = $this->input->post('fAddBulanto');
		$addTahun = $this->input->post('fAddTahun');
		$pembetulan = $this->input->post('fAddPembetulan');
		$date = date('Y-m-d H:i:s');
    	$header = $this->get_header_id($addAkun, $addBulan, $addBulanto, $addTahun, $pembetulan);
   
		if ($header) {
			$sql = "UPDATE SIMTAX_PAJAK_HEADERS set STATUS='DRAFT', TGL_SUBMIT_SUP=sysdate , USER_NAME = '" . $user . "'
					 where PAJAK_HEADER_ID ='" . $header . "' and KODE_CABANG='" . $cabang . "'";
			$query = $this->db->query($sql);
			if ($query) {
				$sql2 = "Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (" . $header . ",'" . $addAkun . "',sysdate,'REJECT','" . $user . "')";
				$query2 = $this->db->query($sql2);
				if ($query2) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
  }
  
  public function get_header_id($pajak = "", $bulan = "",  $bulanto = "", $tahun = "", $pembetulan = "")
	{
		$cabang = $this->kode_cabang;
		$where_p = "";
		//if ($pembetulan){
		$where_p = " and pembetulan_ke=" . $pembetulan;
		//}
		$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK between " . $bulan . " and " . $bulanto . " and tahun_pajak='" . $tahun . "' and nama_pajak='FIXED ASSET'" . $where_p;
		//print_r($sql3); exit();
		$query3 = $this->db->query($sql3);
		$row = $query3->row();
		$header = $row->PAJAK_HEADER_ID;
		if ($query3 && $header) {
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
  }
  
  function action_check_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$vAssetNo = $this->input->post('line_id');
		$ischeck = $this->input->post('ischeck');
		$sql = "UPDATE SIMTAX_REKON_FIXED_ASSET set IS_CHECKLIST=" . $ischeck . " where ASSET_NO ='" . $vAssetNo . "' and KODE_CABANG='" . $cabang . "' ";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}
  }
  
  //=============== BANGUNAN
	function action_get_selectAll_b()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_REKON_FIXED_ASSET set IS_CHECKLIST='" . $vcheck . "'
         where ASSET_NO in  (" . $id_lines . ") and KODE_CABANG='" . $cabang . "' and KELOMPOK_FIXED_ASSET='B'";
    $query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

  }
  
  //=============== NON BANGUNAN
	function action_get_selectAll_final()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_REKON_FIXED_ASSET set IS_CHECKLIST='" . $vcheck . "'
         where ASSET_NO in  (" . $id_lines . ") and KODE_CABANG='" . $cabang . "' and KELOMPOK_FIXED_ASSET='N'";
    $query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

  }

  //=============== TETAP
	function action_get_selectAll_nonfinal()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_REKON_FIXED_ASSET set IS_CHECKLIST='" . $vcheck . "'
         where ASSET_NO in  (" . $id_lines . ") and KODE_CABANG='" . $cabang . "' and KELOMPOK_FIXED_ASSET='T'";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

  }
  
  function get_closing()
	{
		//$cabang	=  $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and upper(a.STATUS) like '%" . strtoupper($q) . "%' ";
		}

		$where2 = " and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'FIXED ASSET' and a.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' and a.kode_cabang = '" . $_POST['_searchCabang'] . "' ";

		$queryExec = "select a.* from simtax_master_period a
					   inner join simtax_pajak_headers b
					   on a.period_id=b.period_id
					   where 1=1 and a.STATUS in ('Open', 'Close')
					   " . $where2 . $where . "
						order by a.tahun_pajak, a.bulan_pajak desc";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

    //var_dump($queryExec);die();
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
  }
  
  function action_save_closing()
	{
		//$cabang	    = $this->kode_cabang;
		$cabang = $this->input->post('cabang');
		$user = $this->session->userdata('identity');
		$status = $this->input->post('status');
		$nama = $this->input->post('nama');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$date = date('Y-m-d H:i:s');
    $header = $this->get_header_id_cabang($cabang, $nama, $bulan, $tahun, $pembetulan);
  
		if ($header && $status == "Open") {
			$sql = "Update SIMTAX_MASTER_PERIOD set STATUS='Close'
					  where KODE_CABANG='" . $cabang . "' and BULAN_PAJAK=" . $bulan . " and TAHUN_PAJAK='" . $tahun . "' and upper(NAMA_PAJAK)='" . strtoupper($nama) . "' ";

      $query = $this->db->query($sql);

			$sql4 = "Update SIMTAX_PAJAK_HEADERS set STATUS='CLOSE'
					  where PAJAK_HEADER_ID=" . $header;
			$query4 = $this->db->query($sql4);

      
			if ($query && $query4) {
				$sql2 = "Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (" . $header . ",'" . strtoupper($nama) . "',sysdate,'Close','" . $user . "')";
				$query2 = $this->db->query($sql2);
				if ($query2) {
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

  }
  
  function action_get_start()
	{
		$cabang = $this->kode_cabang;
		$masa = $this->input->post('masa');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$tipe = $this->input->post('tipe');
		$st = $this->input->post('st');
		$ket = $this->input->post('ket');

		$sql3 = "Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id
				 inner join simtax_rekon_fixed_asset c
				 on a.pajak_header_id=c.pajak_header_id
				 where a.kode_cabang='".$cabang."' 
				 and a.bulan_pajak=" . $masa . " 
				 and a.tahun_pajak='" . $tahun . "' 
				 and upper(a.nama_pajak)='FIXED ASSET' 
				 and a.pembetulan_ke=" . $pembetulan;

		$query3 = $this->db->query($sql3);
		if ($query3) {
			return $query3;
		} else {
			return false;
		}
  }
  
  public function get_header_id_cabang($cabang = "", $nama = "", $bulan = "", $tahun = "", $pembetulan = "")
	{
		//$cabang		=  $this->kode_cabang;
		$where_p = "";

		//if ($pembetulan){
		$where_p = " and pembetulan_ke=" . $pembetulan;
		//}
		$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $bulan . " and tahun_pajak='" . $tahun . "' and nama_pajak='FIXED ASSET'" . $where_p;
		$query3 = $this->db->query($sql3);
		$row = $query3->row();
		$header = $row->PAJAK_HEADER_ID;
		if ($query3 && $header) {
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
  }
  
  function get_view()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$wherePajak = "";
		$whereBulan = "";
		$whereTahun = "";
		$wherePembetulan = "";
		if ($this->input->post('_searchPpn')) {
			$wherePajak = " and sph.nama_pajak='FIXED ASSET'";
		}
		if ($this->input->post('_searchBulan')) {
			$whereBulan = " and sph.bulan_pajak='" . $this->input->post('_searchBulan') . "'";
		}
		if ($this->input->post('_searchTahun')) {
			$whereTahun = " and sph.tahun_pajak='" . $this->input->post('_searchTahun') . "'";
		}
		if ($this->input->post('_searchPembetulan') != "") {
			$wherePembetulan = " and sph.pembetulan_ke='" . $this->input->post('_searchPembetulan') . "'";
		}

		$queryExec = "select sph.NAMA_PAJAK
							 , sph.PAJAK_HEADER_ID 
							 , sph.MASA_PAJAK
							 , sph.BULAN_PAJAK
							 , sph.TAHUN_PAJAK
							 , to_char(sph.CREATION_DATE, 'DD-MON-YYYY HH:MI:SS') CREATION_DATE
							 , sph.USER_NAME
							 , sph.STATUS
							 , to_char(sph.TGL_SUBMIT_SUP, 'DD-MON-YYYY HH:MI:SS') TGL_SUBMIT_SUP
							 , to_char(sph.TGL_APPROVE_SUP, 'DD-MON-YYYY HH:MI:SS') TGL_APPROVE_SUP
							 , to_char(sph.TGL_APPROVE_PUSAT, 'DD-MON-YYY HH:MI:SS') TGL_APPROVE_PUSAT
							 , sph.PEMBETULAN_KE
							 , sph.KODE_CABANG
							 , (select sum(spl.JUMLAH_POTONG)
								from simtax_pajak_lines spl
								where spl.pajak_header_id = sph.pajak_header_id
								and spl.IS_CHEKLIST = 1) ttl_jml_potong
						  from simtax_pajak_headers sph 
						  where sph.kode_cabang='" . $cabang . "' and sph.nama_pajak like '%FIXED ASSET%'
						  " . $wherePajak . $whereBulan . $whereTahun . $wherePembetulan . "
						  ORDER BY sph.creation_date desc";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		//print_r($sql2);exit();
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

}

/* End of file Fixed_asset_mdl.php */
/* Location: ./application/models/Fixed_asset_mdl.php */