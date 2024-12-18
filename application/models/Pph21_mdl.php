<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Pph21_mdl extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		}

		$this->load->model('Master_mdl');
		$this->load->model('Pph21_mdl');

		$this->kode_cabang = $this->session->userdata('kd_cabang');

	}

	public function tgl_db($date)
	{
		$part = explode("-", $date);
		$newDate = $part[2] . "-" . $part[1] . "-" . $part[0];
		return $newDate;
	}

	function get_pajak_header_id($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak)
	{
		//print_r($kode_cabang."-".$nama_pajak."-".$bulan_pajak."-".$tahun_pajak); exit();
		$this->db->select('*');
		$this->db->from('SIMTAX_PAJAK_HEADERS');
		$this->db->where('KODE_CABANG', $kode_cabang);
		$this->db->where('NAMA_PAJAK', $nama_pajak);
		$this->db->where('BULAN_PAJAK', $bulan_pajak);
		$this->db->where('TAHUN_PAJAK', $tahun_pajak);
		$this->db->limit(1);
		$query = $this->db->get();
		//print_r($query->row()->PAJAK_HEADER_ID."-aa"); exit();
		return $query->row()->PAJAK_HEADER_ID;
	}

	public function get_header_id_rekap($pajak, $tahun, $cabang)
	{
		$sql3 = "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and tahun_pajak='" . $tahun . "' and upper(nama_pajak)='" . strtoupper($pajak) . "' ";

		$query3 = $this->db->query($sql3);
		$row = $query3->row();
		$header = $row->PAJAK_HEADER_ID;
		if ($query3) {
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	public function get_header_id($pajak = "", $bulan = "", $tahun = "", $pembetulan = "")
	{
		$cabang = $this->kode_cabang;
		$where_p = "";

		//if ($pembetulan){
		$where_p = " and pembetulan_ke=" . $pembetulan;
		//}
		$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $bulan . " and tahun_pajak='" . $tahun . "' and nama_pajak='PPH PSL 21'" . $where_p;
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

	public function get_header_id_cabang($cabang = "", $nama = "", $bulan = "", $tahun = "", $pembetulan = "")
	{
		//$cabang		=  $this->kode_cabang;
		$where_p = "";

		//if ($pembetulan){
		$where_p = " and pembetulan_ke=" . $pembetulan;
		//}
		$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $bulan . " and tahun_pajak='" . $tahun . "' and nama_pajak='PPH PSL 21'" . $where_p;
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

	public function get_header_id_max($cabang, $pajak, $bulan, $tahun)
	{
		//$cabang	=  $this->kode_cabang;
		$sql3 = "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $bulan . " and tahun_pajak='" . $tahun . "' and upper(nama_pajak)='" . strtoupper($pajak) . "' ";
		$query3 = $this->db->query($sql3);
		$row = $query3->row();
		$header = $row->PAJAK_HEADER_ID;
		if ($query3) {
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	public function getMonth($bul)
	{
		$shortMonthArr = array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$date = $shortMonthArr[$bul];
		return $date;
	}


	function action_save()
	{
		$tipe = $this->input->post('tipe_21');
		$namawp = $this->input->post('namawp');
		$npwp = $this->input->post('npwp');
		$alamat = $this->input->post('alamat');

		$sql = "Update SIMTAX_PAJAK_LINES set NAMA_WP='" . $namawp . "', NPWP='" . $npwp . "', ALAMAT_WP='" . $alamat . "'
					where TIPE_21 ='" . $tipe . "'";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

	}

	function get_approv()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and a.bulan_pajak = '" . $_POST['_searchBulan'] . "' and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select DISTINCT a.*
						,a.nama_wp full_name
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1 
						,a.alamat_wp address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					--	inner join SIMTAX_MASTER_karyawan c
					--	on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where a.kode_cabang='" . $cabang . "' and a.tipe_21= 'BULANAN' and (upper(b.status) in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		//print_r($queryExec."-aa");exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

//========================================= FINAL ==========================
	function get_approv_final()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and a.bulan_pajak = '" . $_POST['_searchBulan'] . "' and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "'  ";

		$queryExec = "select DISTINCT a.*
						, a.nama_wp full_name
					--	,a.npwp npwp1
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1 
						, a.alamat_wp address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					--	inner join SIMTAX_MASTER_karyawan c
					--	on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where a.kode_cabang='" . $cabang . "' and a.tipe_21= 'BULANAN FINAL' and (upper(b.status) in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

//========================================= NON FINAL ======================
	function get_approv_nonfinal()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select DISTINCT a.*
						, a.nama_wp full_name
						, abs(a.jumlah_potong) jumlah_potong_21
						--,a.npwp npwp1
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1 
						, a.alamat_wp address_line1
						, nvl(a.dpp,a.new_dpp) dpp1
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					--	inner join SIMTAX_MASTER_karyawan c
					--	on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where b.kode_cabang='" . $cabang . "' and a.tipe_21= 'BULANAN NON FINAL' and (upper(b.status) in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		//print_r($queryExec."-aa");exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

//==========================================================================
	function action_save_approv()
	{
		$cabang = $this->kode_cabang;
		$user = $this->session->userdata('identity');
		$pasal = $this->input->post('pasal');
		$masa = $this->input->post('masa');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$st = $this->input->post('st');
		$ket = $this->input->post('ket');
		$date = date("Y-m-d H:i:s");
		$header = $this->get_header_id($pasal, $masa, $tahun, $pembetulan);

		if ($st == 1) {
			$status = "APPROVAL SUPERVISOR";
		} else {
			$status = "REJECT SUPERVISOR";
		}

		if ($header) {
			$sql = "Update SIMTAX_PAJAK_HEADERS set TGL_APPROVE_SUP=sysdate, USER_NAME = '" . $user . "',
					  status='" . $status . "'
					  where PAJAK_HEADER_ID='" . $header . "' and KODE_CABANG='" . $cabang . "'";
			$query = $this->db->query($sql);

			$sql2 = "Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME, CATATAN) 
					 values (" . $header . ",'" . $pasal . "',sysdate,'" . $status . "','" . $user . "','" . $ket . "')";
			$query2 = $this->db->query($sql2);

			$sql4 = " Update SIMTAX_MASTER_COUNTER set counter=1
						  where upper(nama_counter)='BUKTI POTONG' and KODE_CABANG='" . $cabang . "' and bulan='" . $masa . "'
						  and tahun='" . $tahun . "' and upper(nama_pajak)='PPH PSL 21' ";
			$query4 = $this->db->query($sql4);


			if ($query && $query2) {
				if ($st == 1) { //khusus PPH
					$sql3 = "
					DECLARE
						l_OutMessage varchar2(250);
					begin
						simtax_pajak_utility_pkg.genNoBuktiPotongPPH21(pBulan => '" . $masa . "'
											 ,pTahun 	=> '" . $tahun . "'
											 ,pNamaPajak  => 'PPH PSL 21'
											 ,pKodeCabang => '" . $cabang . "'
											 ,pOutCode => l_OutMessage);
						dbms_output.put_line(l_OutMessage);
					end;";

					$query3 = $this->db->query($sql3);
					if ($query3) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}

			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function action_cek_row_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$addAkun = $this->input->post('fAddAkun');
		$addBulan = $this->input->post('fAddBulan');
		$addTahun = $this->input->post('fAddTahun');
		$pembetulan = $this->input->post('fAddPembetulan');


		$where2 = " and a.bulan_pajak = '" . $addBulan . "' and a.tahun_pajak = '" . $addTahun . "' and upper(b.nama_pajak) = '" . strtoupper($addAkun) . "' and b.pembetulan_ke = '" . $pembetulan . "' ";

		$sql3 = "select nvl(a.kode_pajak new_kode_pajak,a.kode_pajak) kode_pajak
						, a.is_cheklist
						, a.nama_wp vendor_name
						, a.npwp npwp1
						, a.alamat_wp address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					--	left join SIMTAX_MASTER_SUPPLIER c
					--	on c.VENDOR_ID=a.VENDOR_ID 
					--	and c.ORGANIZATION_ID=a.ORGANIZATION_ID
					--	and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.kode_cabang='" . $cabang . "' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						" . $where2 . "						
						order by a.invoice_num, a.invoice_line_num DESC";

		$query3 = $this->db->query($sql3);
		if ($query3) {
			return $query3;
		} else {
			return false;
		}
	}

	//=============== CEK ALL
	function action_get_selectAll()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST='" . $vcheck . "'
				 where PAJAK_LINE_ID in  (" . $id_lines . ") and 
				 KODE_CABANG='" . $cabang . "' and TIPE_21='BULANAN'";

		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

	}


	//=============== CEK ALL BULANAN
	function action_get_selectAll_final()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST='" . $vcheck . "'
				 where PAJAK_LINE_ID in  (" . $id_lines . ") and KODE_CABANG='" . $cabang . "' and TIPE_21='BULANAN FINAL'";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

	}

	//=============== CEK ALL NON FINAL
	function action_get_selectAll_nonfinal()
	{
		$cabang = $this->kode_cabang;
		$id_lines = $this->input->post('id_lines');
		$vcheck = $this->input->post('vcheck');
		$tipe = $this->input->post('tipe');

		$sql = "UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST='" . $vcheck . "'
				 where PAJAK_LINE_ID in  (" . $id_lines . ") and KODE_CABANG='" . $cabang . "' and TIPE_21='BULANAN NON FINAL'";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

	}

	// ===================================================================================
	function action_get_start()
	{
		$cabang = $this->kode_cabang;
		$pasal = $this->input->post('pasal');
		$masa = $this->input->post('masa');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$tipe = $this->input->post('tipe');
		$st = $this->input->post('st');
		$ket = $this->input->post('ket');

		$sql3 = "Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id
				 inner join simtax_pajak_lines c
				 on a.pajak_header_id=c.pajak_header_id
				 where a.kode_cabang='" . $cabang . "' 
				 and a.bulan_pajak=" . $masa . " 
				 and a.tahun_pajak='" . $tahun . "' 
				 and upper(a.nama_pajak)='PPH PSL 21' 
				 and a.pembetulan_ke=" . $pembetulan;

		$query3 = $this->db->query($sql3);
		if ($query3) {
			return $query3;
		} else {
			return false;
		}
	}


	function get_download()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.tipe_21) like '%" . strtoupper($q) . "%' or upper(a.nama_wp ) like '%" . strtoupper($q) . "%' or upper(a.dpp ) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong ) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select DISTINCT a.*
					  ,a.nama_wp full_name
					  ,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1
					  ,a.alamat_wp address_line1
					  ,nvl(a.dpp,a.new_dpp) dpp1
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					--	inner join SIMTAX_MASTER_karyawan c
					--	on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where b.nama_pajak='PPH PSL 21' and b.kode_cabang='" . $cabang . "' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') 
						and a.IS_CHEKLIST='1' 
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		// print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function get_bukti_potong()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(c.NAMA_WP) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and a.bulan_pajak = '" . $_POST['_searchBulan'] . "' and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and a.akun_pajak = '" . $_POST['_searchPph'] . "' ";

		$queryExec = "select a.*, c.vendor_name, c.npwp npwp1, c.address_line1,b.pembetulan 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID
						where b.status='DRAFT' and a.kode_cabang='" . $cabang . "' and c.organization_id= 82 and b.bulan_pajak = a.bulan_pajak
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";    //where nnti di ganti rejected

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function action_save_bukti_potong()
	{
		$idPajakHeader = $this->input->post('idPajakHeader');
		$idPajakLines = $this->input->post('idPajakLines');
		$id = $this->input->post('idwp');
		$isNewRecord = $this->input->post('isNewRecord');
		$namawp = $this->input->post('namawp');
		$kodepajak = $this->input->post('kodepajak');
		$npwp = $this->input->post('npwp');
		$dpp = $this->input->post('dpp');
		$alamat = $this->input->post('alamat');
		$tarif = $this->input->post('tarif');
		$jumlahpotong = $this->input->post('jumlahpotong');
		$invoicenumber = $this->input->post('invoicenumber');
		$nofakturpajak = $this->input->post('nofakturpajak');
		$tanggalfakturpajak = ($this->input->post('tanggalfakturpajak')) ? $this->tgl_db($this->input->post('tanggalfakturpajak')) : '';
		$newkodepajak = $this->input->post('newkodepajak');
		$newtarif = $this->input->post('newtarif');
		$newdpp = str_replace(',', '', $this->input->post('newdpp'));
		$newjumlahpotong = str_replace(',', '', $this->input->post('newjumlahpotong'));
		$nobupot = $this->input->post('nobupot');
		$glaccount = $this->input->post('glaccount');
		/* $fAkun				= $this->input->post('fAkun');
		$fNamaAkun			= $this->input->post('fNamaAkun');
		$fBulan				= $this->input->post('fBulan');
		$fTahun				= $this->input->post('fTahun');

		$addAkun			= $this->input->post('fAddAkun');
		$addNamaAkun		= $this->input->post('fAddNamaAkun');
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun'); */

		$pembetulan = $this->input->post('pembetulan');

		$masa_pajak = $this->getMonth($addBulan);
		$date = date("Y-m-d H:i:s");

		if ($isNewRecord) {
			$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang ='" . $cabang . "' and BULAN_PAJAK=" . $addBulan . " and tahun_pajak='" . $addTahun . "' and upper(nama_pajak)='PPH PSL 21' "; //nanti wherenya di gnti akun pajak
			$query3 = $this->db->query($sql3);
			$row = $query3->row();
			$header = $row->PAJAK_HEADER_ID;
			$query3->free_result();

			if ($query3) {
				$sql = "insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,KODE_PAJAK,NPWP,NAMA_WP,ALAMAT_WP,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,NEW_KODE_PAJAK,NEW_DPP,NEW_TARIF,NEW_JUMLAH_POTONG,KODE_CABANG,USER_NAME,CREATION_DATE,NAMA_PAJAK,VENDOR_ID,NO_BUKTI_POTONG,GL_ACCOUNT,AKUN_PAJAK) 
				VALUES
				('" . $header . "','" . $masa_pajak . "','" . $addBulan . "','" . $addTahun . "','" . $kodepajak . "','" . $npwp . "','" . $namawp . "','" . $alamat . "','" . $dpp . "','" . $tarif . "','" . $jumlahpotong . "','" . $invoicenumber . "','" . $nofakturpajak . "',TO_DATE('" . $tanggalfakturpajak . "','yyyy-mm-dd hh24:mi:ss'),'" . $newkodepajak . "','" . $newdpp . "','" . $newtarif . "','" . $newjumlahpotong . "','000','ADMIN',TO_DATE('" . $date . "','yyyy-mm-dd hh24:mi:ss'),'" . $addNamaAkun . "','" . $id . "','" . $nobupot . "','" . $glaccount . "','" . $addAkun . "')";
			}
			$uHeader = $header;
			$uAkun = $addAkun;
			$uBulan = $addBulan;
			$uTahun = $addTahun;

		} else {
			$sql = "Update SIMTAX_PAJAK_LINES set NEW_KODE_PAJAK='" . $newkodepajak . "', NEW_DPP='" . $newdpp . "', NEW_TARIF='" . $newtarif . "', NEW_JUMLAH_POTONG='" . $newjumlahpotong . "', LAST_UPDATE_DATE=TO_DATE('" . $date . "','yyyy-mm-dd hh24:mi:ss'), USER_NAME='ADMIN'
			  where PAJAK_LINE_ID ='" . $idPajakLines . "' and KODE_CABANG='" . $cabang . "' and BULAN_PAJAK=" . $fBulan . " and TAHUN_PAJAK='" . $fTahun . "' and AKUN_PAJAK='" . $fAkun . "' ";
			$uHeader = $idPajakHeader;
			$uAkun = $fAkun;
			$uBulan = $fBulan;
			$uTahun = $fTahun;
		}
		$query = $this->db->query($sql);
		if ($query) {
			$sql = "Update SIMTAX_PAJAK_HEADERS set PEMBETULAN='" . $pembetulan . "'
			where PAJAK_HEADER_ID ='" . $uHeader . "' and KODE_CABANG='" . $cabang . "' and BULAN_PAJAK=" . $uBulan . " and TAHUN_PAJAK='" . $uTahun . "' and upper(NAMA_PAJAK)='PPH PSL 21' "; //nnti where ny diganti akun_pajak
			$query2 = $this->db->query($sql);
			if ($query2) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	function action_delete_bukti_potong()
	{
		$idPajakLines = $this->input->post('idPajakLines');
		$fAkun = $this->input->post('fAkun');
		$fBulan = $this->input->post('fBulan');
		$fTahun = $this->input->post('fTahun');
		$date = date('Y-m-d H:i:s');

		$sql = "DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='" . $idPajakLines . "' and KODE_CABANG='" . $cabang . "' and BULAN_PAJAK=" . $fBulan . " and tahun_pajak='" . $fTahun . "' and akun_pajak='" . $fAkun . "' ";
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

		$where2 = " and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and a.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' and a.kode_cabang = '" . $_POST['_searchCabang'] . "' ";

		$queryExec = "select a.* from simtax_master_period a
					   inner join simtax_pajak_headers b
					   on a.period_id=b.period_id
					   where 1=1
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

	function action_cek_closing()
	{
		$status = $this->input->post('status');
		$date = date('Y-m-d H:i:s');

		$sql = "Select * from SIMTAX_MASTER_PERIOD 
				  where KODE_CABANG='" . $cabang . "' and BULAN_PAJAK='" . $bulan . "' and TAHUN_PAJAK='" . $tahun . "' and upper(NAMA_PAJAK)='PPH PSL 21' AND upper(STATUS)='OPEN' ";
		$query = $this->db->query($sql);
		$cek = $query->num_rows();
		if ($query) {
			return $cek;
		} else {
			return false;
		}
	}

	//CURENCY COMPILASI//
	function get_currency_kompilasi($bulan, $tahun, $pajak, $pembetulan, $cabang)
	{

		$where = "";
		if ($cabang || $cabang != "") {
			$where = " and sph.kode_cabang = '" . $cabang . "' ";
		}

		$queryExec = "select  sph.kode_cabang
							  , skc.nama_cabang 
							  , sum(nvl(sph.saldo_awal,0)) saldo_awal
							  , sum(nvl(sph.mutasi_debit,0)) mutasi_debit
							  , sum(nvl(sph.mutasi_kredit,0	)) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						inner join simtax_kode_cabang skc
							on sph.kode_cabang = skc.kode_cabang
						  where sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = '" . strtoupper($pajak) . "'						 
						  and sph.pembetulan_ke=" . $pembetulan . "
						  --and upper(smp.status) ='CLOSE'
						  and sph.status in ('CLOSE','APPROVAL SUPERVISOR')
						  " . $where . "
						  group by sph.kode_cabang, skc.nama_cabang
						  order by sph.kode_cabang
						  ";
		//print_r($queryExec); exit();
		$query = $this->db->query($queryExec);
		$rowCount = $query->num_rows();
		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;

	}


	//======================= RINGKASAN REKON

	function get_currency1($bulan, $tahun, $pajak, $pembetulan, $step) //dipakai all (master)
	{
		$cabang = $this->kode_cabang;
		if ($step == "REKONSILIASI") {
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step == "APPROV") {
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step == "DOWNLOAD") {
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($step == "VIEW") {
			$where = "";
		}
		$queryExec = "select  nvl(sph.saldo_awal,0)	saldo_awal
							  , nvl(sph.mutasi_debit,0) mutasi_debit
							  , nvl(sph.mutasi_kredit,0	) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						  where sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = '" . strtoupper($pajak) . "'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $pembetulan . $where;

		$query = $this->db->query($queryExec);
		$rowCount = $query->num_rows();
		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;

	}

	function get_summary_rekonsiliasiAll($bulan, $tahun, $pajak, $pembetulan)
	{
		$cabang = $this->kode_cabang;
		$queryExec = "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
						--	 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						--  and spl.vendor_id=sms.vendor_id(+)
						--  and spl.organization_id=sms.organization_id(+)
						--  and spl.vendor_site_id=sms.vendor_site_id(+)
						--  and spl.tipe_21 in ('BULANAN','BULANAN NON FINAL')  
						  and sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $pembetulan . "
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'						 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";
		//print_r($queryExec); exit();
		$query1 = $this->db->query($queryExec);
		$result['queryExec'] = $query1;
		return $result;
	}


	function get_summary_rekonsiliasiAll1($bulan, $tahun, $pajak, $pembetulan, $step)
	{
		$cabang = $this->kode_cabang;

		if ($step == "REKONSILIASI") {
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step == "APPROV") {
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step == "DOWNLOAD") {
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) ";
		} else if ($step == "VIEW") {
			$where = "";
		}

		$queryExec = "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
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
						 -- and spl.tipe_21 in ('BULANAN','BULANAN NON FINAL')
						  and sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) ='PPH PSL 21'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $pembetulan . "
						  " . $where . "						  					 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";
		//print_r($queryExec); exit();
		$query1 = $this->db->query($queryExec);
		$result['queryExec'] = $query1;
		return $result;
	}


	/*Awal Detail Rekonsiliasi================================================================================*/
	function get_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$tipe = $_POST['_searchTipe'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);

		$where = "";
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		if ($tipe == "REKONSILIASI") {
			$where .= " and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "APPROV") {
			$where .= "  and (b.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "DOWNLOAD") {
			$where .= "  and (b.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "VIEW") {
			$where .= "";
		}

		if ($q) {
			$where .= " and (upper(a.npwp) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}

		$queryExec = "Select nvl(a.new_dpp, a.dpp) dpp
						, nvl(a.new_jumlah_potong, a.jumlah_potong) jumlah_potong	
						, a.nama_wp nama_wp
						,rpad (nvl (a.npwp,'0'),15,'0' )npwp1
						--, a.npwp npwp1
						, a.alamat_wp address_line1
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.invoice_num
						, a.invoice_line_num
						, 'Tidak Dilaporkan' keterangan
						, '1' urut
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						--left join SIMTAX_MASTER_SUPPLIER c
						--on c.VENDOR_ID=a.VENDOR_ID 
						--and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						--and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='" . $cabang . "' 						
						AND a.is_cheklist =0
						" . $where;

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();

		$queryExec .= " order by URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function get_total_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$tipe = $_POST['_searchTipe'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);

		$where = "";
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		if ($tipe == "REKONSILIASI") {
			$where .= " and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "APPROV") {
			$where .= "  and (b.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "DOWNLOAD") {
			$where .= "  and (b.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe == "VIEW") {
			$where .= "";
		}

		$queryExec = "SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(a.NEW_JUMLAH_POTONG, a.JUMLAH_POTONG)),0) JUMLAH_POTONG	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						--left join SIMTAX_MASTER_SUPPLIER c
						--on c.VENDOR_ID=a.VENDOR_ID 
						--and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						--and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='" . $cabang . "' 						
						AND a.is_cheklist =0
						" . $where;
		$queryExec .= " ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG ";

		$query = $this->db->query($queryExec);
		return $query;
	}

	/*Akhir Detail Rekonsiliasi================================================================================*/

	//============================================
	function action_save_saldo_awal()
	{
		$cabang = $this->kode_cabang;
		$user = $this->session->userdata('identity');
		$pajak = $this->input->post('pajak');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$saldo = $this->input->post('vsal');
		$mutasiD = $this->input->post('vmtsd');
		$mutasiK = $this->input->post('vmtsk');
		$tipe = $this->input->post('tipe');
		$header = $this->get_header_id($pajak, $bulan, $tahun, $pembetulan);

		if ($header) {
			$sql = "Update simtax_pajak_headers set saldo_awal='" . $saldo . "', mutasi_debit='" . $mutasiD . "', mutasi_kredit='" . $mutasiK . "', last_update_date=sysdate, user_name='" . $user . "'
			  where pajak_header_id ='" . $header . "' and kode_cabang='" . $cabang . "' ";
			$query = $this->db->query($sql);
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/*========================================BULANAN =========================================*/
	function get_rekonsiliasi_bulanan()
	{
		$cabang = $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.no_faktur_pajak) like '%" . strtoupper($q) . "%' or upper(a.invoice_num) like '%" . strtoupper($q) . "%'  or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";
		//$where2	= " ";

		$queryExec = "select DISTINCT a.*, 
					--	c.full_name,
						a.nama_wp full_name,
					rpad (nvl (a.npwp,'0'),15,'0' )npwp1,
					--rpad (nvl (a.npwp_pemotong,'0'),15,'0' )npwp_pemotong,
						a.alamat_wp address_line1,
						b.pembetulan_ke as pembetulan
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						--left join SIMTAX_MASTER_KARYAWAN c
						--on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where b.KODE_CABANG='" . $cabang . "' and a.tipe_21= 'BULANAN' 
						and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		//print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		//print_r($sql2); exit();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	/*=======================================BULANAN FINAL======================================*/
	function get_rekonsiliasi_bulanan_final()
	{
		$cabang = $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.no_faktur_pajak) like '%" . strtoupper($q) . "%' or upper(a.invoice_num) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";
		//$where2	= " ";

		$queryExec = "select DISTINCT a.*, 
					--	c.full_name,
						a.nama_wp full_name,
					rpad (nvl (a.npwp,'0'),15,'0' )npwp1,
						a.alamat_wp address_line1,
						b.pembetulan_ke as pembetulan
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						--left join SIMTAX_MASTER_KARYAWAN c
						--on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where  a.KODE_CABANG='" . $cabang . "' and a.tipe_21= 'BULANAN FINAL' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		//print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		//print_r($sql2); exit();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	/*========================BULANAN NON FINAL===========================================================*/
	function get_rekonsiliasi_bulanan_non_final()
	{
		$cabang = $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.invoice_num) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%' or upper(a.dpp) like '%" . strtoupper($q) . "%' or upper(a.jumlah_potong) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";
		//$where2	= " ";

		$queryExec = "select DISTINCT a.*, 
					--	c.full_name,
						abs(a.jumlah_potong) jumlah_potong_21,
						a.nama_wp full_name,
						rpad (nvl (a.npwp,'0'),15,'0' )npwp1,
						a.alamat_wp address_line1,
						b.pembetulan_ke as pembetulan
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						--left join SIMTAX_MASTER_KARYAWAN c
						--on c.person_id=a.person_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						where  a.KODE_CABANG='" . $cabang . "' and a.tipe_21= 'BULANAN NON FINAL' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		//print_r($queryExec); exit();
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function get_summary_rekonsiliasi($bulan, $tahun, $pajak, $pembetulan, $cabang)
	{

		$queryExec = "select 
							   spl.IS_CHEKLIST
							, case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							,  sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							, smp.STATUS
						from   simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = " . $_POST['_searchBulan'] . "
						  and sph.tahun_pajak = " . $_POST['_searchTahun'] . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						 -- and spl.tipe_21 in ('BULANAN','BULANAN NON FINAL')
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $_POST['_searchPembetulan'] . "
					  --  and upper(smp.status) ='OPEN'
						  and spl.is_cheklist =1
						  and sph.status = 'APPROVAL SUPERVISOR'		  					 
							group by        
							   spl.is_cheklist, smp.STATUS ";
		// echo $queryExec."\n";
		$query1 = $this->db->query($queryExec);
		$result['queryExec'] = $query1;
		return $result;
	}


	function get_detail_summary_kompilasi()
	{
		ini_set('memory_limit', '-1');
		$cabang = $_POST['_searchCabang'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		if ($q) {
			$where .= " and (upper(a.npwp) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}

		if ($cabang || $cabang != "") {
			$where .= " and b.kode_cabang='" . $cabang . "' ";
		}

		$queryExec = " Select d.kode_cabang
                        , d.nama_cabang
                        , nvl(a.new_dpp, a.dpp) dpp
                        , nvl(a.new_jumlah_potong, a.jumlah_potong) jumlah_potong    
                        , a.nama_wp vendor_name
                        ,rpad (nvl (a.npwp,'0'),15,'0' )npwp1
                        , a.alamat_wp address_line1
                        , a.no_faktur_pajak
                        , a.tanggal_faktur_pajak
                        , a.invoice_num
                        , a.invoice_line_num
                        , 'Tidak Dilaporkan' keterangan
                        , '1' urut
                        from SIMTAX_PAJAK_LINES a 
                        inner join SIMTAX_PAJAK_HEADERS b                        
                            on a.pajak_header_id=b.pajak_header_id
                        inner join SIMTAX_MASTER_PERIOD d
                            on b.PERIOD_ID=d.PERIOD_ID
                        inner join simtax_kode_cabang d
                            on b.kode_cabang=d.kode_cabang
                      --  left join SIMTAX_MASTER_SUPPLIER c
                       --     on c.VENDOR_ID=a.VENDOR_ID 
                      --  and c.ORGANIZATION_ID=a.ORGANIZATION_ID
                      --  and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
                        where a.is_cheklist =0
                        --and upper(d.status) ='CLOSE'
                        and b.status IN ('CLOSE','APPROVAL SUPERVISOR')
						" . $where;

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();

		$queryExec .= " order by d.kode_cabang, a.invoice_num, a.invoice_line_num desc";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function get_detail_summary_kompilasi_cabang()
	{
		ini_set('memory_limit', '-1');
		$cabang = $_POST['_searchCabang'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		if ($q) {
			$where .= " and (upper(d.nama_cabang) like '%" . strtoupper($q) . "%') ";
		}

		if ($cabang || $cabang != "") {
			$where .= " and b.kode_cabang='" . $cabang . "' ";
		}

		$queryExec = "Select d.kode_cabang
						, d.nama_cabang
						, sum(nvl(a.new_jumlah_potong, a.jumlah_potong)) jumlah_potong	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join simtax_kode_cabang d
							on b.kode_cabang=d.kode_cabang
						--left join SIMTAX_MASTER_SUPPLIER c
						--	on c.VENDOR_ID=a.VENDOR_ID 
						--and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						--and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						--and upper(d.status) ='CLOSE'
                        and b.status IN ('CLOSE','APPROVAL SUPERVISOR')
						" . $where . "
						group by d.kode_cabang, d.nama_cabang ";

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();

		$queryExec .= " order by d.kode_cabang ";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	/*   function get_summary_rekonsiliasi($st)
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
							,  sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							, smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  and upper(spl.tipe_21) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
						  ".$where."
						group by
							   spl.IS_CHEKLIST, smp.STATUS ";
		//print_r($queryExec); exit();

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
	} */

	function get_total_detail_summary_kompilasi()
	{
		ini_set('memory_limit', '-1');
		$cabang = $_POST['_searchCabang'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);

		$where = "";
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		if ($cabang || $cabang != "") {
			$where .= " and b.kode_cabang='" . $cabang . "' ";
		}

		$queryExec = "SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(a.NEW_JUMLAH_POTONG, a.JUMLAH_POTONG)),0) JUMLAH_POTONG	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						--left join SIMTAX_MASTER_SUPPLIER c
						--on c.VENDOR_ID=a.VENDOR_ID 
						--and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						--and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						and b.status in ('CLOSE', 'APPROVAL SUPERVISOR')
						--and upper(d.status) ='CLOSE'
						" . $where;
		$queryExec .= " ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG ";

		$query = $this->db->query($queryExec);
		return $query;
	}


	function get_total_bayar()
	{
		ini_set('memory_limit', '-1');
		$cabang = $_POST['_searchCabang'];
		$tgl_akhir = $this->Master_mdl->getEndMonth($_POST['_searchTahun'], $_POST['_searchBulan']);

		$where = "";
		if ($cabang || $cabang != "") {
			$where .= " and sph.kode_cabang = '" . $cabang . "' ";
		}

		/* $queryExec	= "SELECT DISTINCT * FROM (
                        SELECT 'Dilaporkan' KETERANGAN
                        ,SUM(a.DPP) JUMLAH_BAYAR
                        from SIMTAX_PAJAK_LINES a
                        inner join SIMTAX_PAJAK_HEADERS b
                        on a.pajak_header_id=b.pajak_header_id
                        inner join SIMTAX_MASTER_PERIOD d
                        on b.PERIOD_ID=d.PERIOD_ID
                        where a.is_cheklist =1
						--and upper(d.status) ='CLOSE'
						".$where;
			$queryExec	.=" )
							GROUP BY KETERANGAN, JUMLAH_BAYAR ";  */

		$queryExec = "select 
							   spl.IS_CHEKLIST
							, case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							,  sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							, smp.STATUS
						from   simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = " . $_POST['_searchBulan'] . "
						  and sph.tahun_pajak = " . $_POST['_searchTahun'] . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  --and spl.tipe_21 in ('BULANAN','BULANAN NON FINAL')						  
						  and sph.pembetulan_ke=" . $_POST['_searchPembetulan'] . "
					  --  and upper(smp.status) ='OPEN'
					  	  and sph.status in ('CLOSE', 'APPROVAL SUPERVISOR')
						  " . $where . "
						  and spl.is_cheklist =1			  					 
							group by        
							   spl.is_cheklist, smp.STATUS ";

		//print_r($queryExec); exit();
		$query = $this->db->query($queryExec);

		return $query;
	}


	function action_tot_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$tipe = $this->input->post('tipe');

		$sql3 = "select 
						sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  and upper(spl.tipe_21) = '" . strtoupper($tipe) . "'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $pembetulan . "
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
					group by        
						smp.STATUS ";

		$query3 = $this->db->query($sql3);

		if ($query3) {
			return $query3;
		} else {
			return false;
		}

	}

	/*===========================================================================================*/


	function get_master_kode_pajak()
	{
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(tax_code) like '%" . strtoupper($q) . "%' or upper(tax_rate) like '%" . strtoupper($q) . "%' or upper(description) like '%" . strtoupper($q) . "%') ";
		}

		$queryExec = "select * from simtax_master_pph where upper(kode_pajak)='PPH PSL 21' " . $where . " order by tax_code";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function action_save_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$user = $this->session->userdata('identity');
		$idPajakHeader = $this->input->post('idPajakHeader');
		$idPajakLines = $this->input->post('idPajakLines');
		$id = $this->input->post('idwp');
		$isNewRecord = $this->input->post('isNewRecord');
		$namawp = $this->input->post('namawp');
		$kodepajak = $this->input->post('kodepajak');
		$npwp = $this->input->post('npwp');
		$dpp = $this->input->post('dpp');
		$alamat = $this->input->post('alamat');
		$tarif = $this->input->post('tarif');
		$jumlahpotong = $this->input->post('jumlahpotong');
		$invoicenumber = $this->input->post('invoicenumber');
		$nofakturpajak = $this->input->post('nofakturpajak');
		$tanggalfakturpajak = ($this->input->post('tanggalfakturpajak')) ? $this->tgl_db($this->input->post('tanggalfakturpajak')) : '';
		$newkodepajak = $this->input->post('newkodepajak');
		$newtarif = $this->input->post('newtarif');
		$newdpp = str_replace(',', '', $this->input->post('newdpp'));
		$newjumlahpotong = str_replace(',', '', $this->input->post('newjumlahpotong'));
		$nobupot = $this->input->post('nobupot');
		$glaccount = $this->input->post('glaccount');
		$fAkun = $this->input->post('fAkun');
		$fNamaAkun = $this->input->post('fNamaAkun');
		$fBulan = $this->input->post('fBulan');
		$fTahun = $this->input->post('fTahun');
		$addAkun = $this->input->post('fAddAkun');
		$addNamaAkun = $this->input->post('fAddNamaAkun');
		$addBulan = $this->input->post('fAddBulan');
		$addTahun = $this->input->post('fAddTahun');

		$masa_pajak = $this->getMonth($addBulan);
		$date = date("Y-m-d H:i:s");

		if ($isNewRecord) {

			$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $addBulan . " and tahun_pajak='" . $addTahun . "' and upper(nama_pajak)='" . $addAkun . "' ";
			$query3 = $this->db->query($sql3);
			$row = $query3->row();
			$header = $row->PAJAK_HEADER_ID;
			$query3->free_result();

			if ($query3) {
				$sql = "insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,KODE_PAJAK,NPWP,NAMA_WP,ALAMAT_WP,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,NEW_KODE_PAJAK,NEW_DPP,NEW_TARIF,NEW_JUMLAH_POTONG,KODE_CABANG,USER_NAME,CREATION_DATE,NAMA_PAJAK,VENDOR_ID,NO_BUKTI_POTONG,GL_ACCOUNT) 
				VALUES
				('" . $header . "','" . $masa_pajak . "','" . $addBulan . "','" . $addTahun . "','" . $kodepajak . "','" . $npwp . "','" . $namawp . "','" . $alamat . "','" . $dpp . "','" . $tarif . "','" . $jumlahpotong . "','" . $invoicenumber . "','" . $nofakturpajak . "',TO_DATE('" . $tanggalfakturpajak . "','yyyy-mm-dd hh24:mi:ss'),'" . $newkodepajak . "','" . $newdpp . "','" . $newtarif . "','" . $newjumlahpotong . "','" . $cabang . "','" . $user . "',TO_DATE('" . $date . "','yyyy-mm-dd hh24:mi:ss'),'" . $addAkun . "','" . $id . "','" . $nobupot . "','" . $glaccount . "')";
			}
		} else {
			$sql = "Update SIMTAX_PAJAK_LINES set NEW_KODE_PAJAK='" . $newkodepajak . "'
						, NEW_DPP='" . $newdpp . "'
						, NEW_TARIF='" . $newtarif . "'
						, ALAMAT_WP='" . $alamat . "'
						, NPWP='" . $npwp . "'
						, NEW_JUMLAH_POTONG='" . $newjumlahpotong . "'
						, LAST_UPDATE_DATE=sysdate
						, USER_NAME='" . $user . "'
			         where PAJAK_LINE_ID ='" . $idPajakLines . "' 
					 and KODE_CABANG='" . $cabang . "' ";
		}
		//print_r($sql); end();
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}

	}

	function action_delete_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$idPajakLines = $this->input->post('idPajakLines');
		$fAkun = $this->input->post('fAkun');
		$fBulan = $this->input->post('fBulan');
		$fTahun = $this->input->post('fTahun');
		$date = date('Y-m-d H:i:s');

		$sql = "DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='" . $idPajakLines . "' and KODE_CABANG='" . $cabang . "'";
		$query = $this->db->query($sql);
		if ($query) {
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
		$addNamaAkun = $this->input->post('fAddNamaAkun');
		$addBulan = $this->input->post('fAddBulan');
		$addTahun = $this->input->post('fAddTahun');
		$addType = $this->input->post('fAddType');
		$pembetulan = $this->input->post('fAddPembetulan');
		$date = date('Y-m-d H:i:s');
		$header = $this->get_header_id($addAkun, $addBulan, $addTahun, $pembetulan);

		if ($header) {
			$sql = "UPDATE SIMTAX_PAJAK_HEADERS set STATUS='SUBMIT', TGL_SUBMIT_SUP=sysdate , USER_NAME = '" . $user . "'
					 where PAJAK_HEADER_ID ='" . $header . "' and KODE_CABANG='" . $cabang . "'";
			//print_r($sql); exit();
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

	function action_check_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$idPajakLines = $this->input->post('line_id');
		$ischeck = $this->input->post('ischeck');

		$sql = "UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST=" . $ischeck . " where PAJAK_LINE_ID ='" . $idPajakLines . "' and KODE_CABANG='" . $cabang . "' ";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}


	function add_csv($data, $row, $tipe = "", $tgl = "")
	{

		if ($data['MASA_PAJAK'] != 'MASA_PAJAK') {
			if (isset($tipe)) {
				$this->db->set('TGL_BUKTI_POTONG', "to_date('" . $tgl . "','yyyy-mm-dd hh24:mi:ss')", false);
			}

			if ($data['PAJAK_LINE_ID']) {
				$user = $this->session->userdata('identity');
				$this->db->where('PAJAK_LINE_ID', $data['PAJAK_LINE_ID']);
				$this->db->set('LAST_UPDATE_DATE', "to_date('" . date('Y-m-d H:i:s') . "', 'YYYY-MM-DD HH24:MI:SS')", false);
				$this->db->set('LAST_UPDATE_BY', $user);
				$affectedRows = $this->db->update("SIMTAX_PAJAK_LINES", $data);
			} else {
				$affectedRows = $this->db->insert("SIMTAX_PAJAK_LINES", $data);
			}

			if ($affectedRows) {
				return true;
			} else {
				return false;
			}
		}


	}


	function get_format_csv()
	{
		ini_set('memory_limit', '-1');

		$cabang = $this->kode_cabang;
		$pajak = ($_REQUEST['tax']) ? strtoupper($_REQUEST['tax']) : "";
		$bulan = $_REQUEST['month'];
		$tahun = $_REQUEST['year'];
		$pembetulan = ($_REQUEST['ke']) ? $_REQUEST['ke'] : "0";
		$tipe = ($_REQUEST['tipe']) ? $_REQUEST['tipe'] : "";

		$where = " and b.bulan_pajak = '" . $bulan . "' and a.tahun_pajak = '" . $tahun . "' and upper(b.nama_pajak) = '" . $pajak . "' and a.pembetulan_ke = '" . $pembetulan . "'";

		$sql = "select 
					DISTINCT a.*,replace(a.nama_wp,',',' ') FULL_name,
					rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1, 
					a.alamat_wp address_line1 
				from SIMTAX_PAJAK_LINES a 
				inner join SIMTAX_PAJAK_HEADERS b                        
					on a.pajak_header_id=b.pajak_header_id
				inner join SIMTAX_MASTER_PERIOD d
					on b.PERIOD_ID=d.PERIOD_ID  		
				where 
					upper(a.nama_pajak) = 'PPH PSL 21' 
					and  a.tipe_21='" . $tipe . "'
					and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
					and upper(d.STATUS) ='OPEN'
					" . $where . "
				order by a.pajak_line_id DESC";
	
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}

	}

	function get_format_csv1()
	{
		$cabang = $this->kode_cabang;
		$pajak = ($_REQUEST['tax']) ? strtoupper($_REQUEST['tax']) : "";
		$bulan = $_REQUEST['month'];
		$tahun = $_REQUEST['year'];
		//$pembetulan	= $_REQUEST['ke'];
		$tipe = ($_REQUEST['tipe']) ? $_REQUEST['tipe'] : "";

		$where = " and a.bulan_pajak = '" . $bulan . "' and a.tahun_pajak = '" . $tahun . "' and upper(b.nama_pajak) = '" . $pajak . "'  ";
		$sql = "select DISTINCT a.*,replace(a.nama_wp,',',' ') FULL_name
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1
					--	replace(replace(a.npwp,'.',''),'-','') npwp1
						, a.alamat_wp address_line1 
                        from SIMTAX_PAJAK_LINES a 
                        inner join SIMTAX_PAJAK_HEADERS b                        
                        on a.pajak_header_id=b.pajak_header_id
                        inner join SIMTAX_MASTER_PERIOD d
                        on b.PERIOD_ID=d.PERIOD_ID
                    --    left join SIMTAX_MASTER_KARYAWAN c
                    --    on  c.PERSON_ID=a.PERSON_ID  		
						where a.nama_pajak = 'PPH PSL 21' 
					--	and  a.tipe_21='" . $tipe . "' 
					--	and a.kode_cabang='" . $cabang . "'
				and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						and upper(d.STATUS) ='OPEN'
						" . $where . "
						order by a.pajak_line_id DESC";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}

	}


	function get_format_csv2($pajak_header_id, $tipe)
	{

		$sql = "SELECT DISTINCT a.*
				,replace(a.nama_wp,',','')full_name
				,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1
				,abs(a.jumlah_potong) jumlah_potong_21
		--	,replace(replace(a.npwp_pemotong,'.',''),'-','') npwp_pemotong 
				,a.alamat_wp address_line1, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong1
                        from SIMTAX_PAJAK_LINES a 
                        inner join SIMTAX_PAJAK_HEADERS b                        
                        on a.pajak_header_id=b.pajak_header_id
                        inner join SIMTAX_MASTER_PERIOD d
                        on b.PERIOD_ID=d.PERIOD_ID
						where a.pajak_header_id = " . $pajak_header_id . "
						and  a.tipe_21 = '" . $tipe . "' 
						and a.is_cheklist='1'
						and b.status = 'APPROVAL SUPERVISOR'
						and upper(d.STATUS) ='OPEN'
						order by a.pajak_line_id DESC";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}

	}

//=================================================== PEMBETULAN ===================================
	function get_pembetulan()
	{
		//$cabang			 =  $this->kode_cabang;
		$wherePajak = "";
		$whereBulan = "";
		$whereTahun = "";
		$wherePembetulan = "";
		$whereCabang = "";

		if ($this->input->post('_searchPph')) {
			$wherePajak = " and sph.nama_pajak='" . $this->input->post('_searchPph') . "'";
		}
		if ($this->input->post('_searchBulan')) {
			$whereBulan = " and sph.bulan_pajak='" . $this->input->post('_searchBulan') . "'";
		}
		if ($this->input->post('_searchTahun')) {
			$whereTahun = " and sph.tahun_pajak='" . $this->input->post('_searchTahun') . "'";
		}
		if ($this->input->post('_searchPembetulan')) {
			$wherePembetulan = " and sph.pembetulan_ke='" . $this->input->post('_searchPembetulan') . "'";
		}
		if ($this->input->post('_searchCabang')) {
			$whereCabang = " and sph.kode_cabang='" . $this->input->post('_searchCabang') . "'";
		}

		$queryExec = "Select distinct sph.*, smp.status status_period, skc.nama_cabang from simtax_pajak_headers sph
                        inner join simtax_master_period smp
                        on sph.period_id = smp.period_id
                        inner join simtax_kode_cabang skc
                        on sph.kode_cabang=skc.kode_cabang
                        where 1 = 1
                        and sph.nama_pajak='PPH PSL 21' 
                        and sph.pembetulan_ke >0
						" . $wherePajak . $whereBulan . $whereTahun . $wherePembetulan . $whereCabang . "
						order by sph.tahun_pajak, sph.bulan_pajak ";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function action_save_pembetulan()
	{
		//$cabang		= $this->kode_cabang;
		$cabang = $this->input->post('fCabang');
		$user = $this->session->userdata('identity');
		$pasal = "PPH PSL 21";
		$masa = $this->input->post('fbulan');
		$tahun = $this->input->post('ftahun');
		$pembetulan = $this->input->post('fpembetulanKe') - 1;
		$date = date("Y-m-d H:i:s");

		$sql3 = "SELECT STATUS from SIMTAX_MASTER_PERIOD WHERE kode_cabang='" . $cabang . "' and BULAN_PAJAK=" . $masa . " and tahun_pajak='" . $tahun . "' and upper(nama_pajak)='" . strtoupper($pasal) . "' AND PEMBETULAN_KE=" . $pembetulan;

		$query3 = $this->db->query($sql3);
		$rowCount = $query3->num_rows();
		if ($rowCount > 0) {
			$row = $query3->row();
			$status = $row->STATUS;

			if ($status == "Close" || $status == "CLOSE") {
				$header = $this->get_header_id_max($cabang, $pasal, $masa, $tahun);
				//print_r($header."-aa"); exit();
				//call package
				//add by Derry
				if ($header) {
					$PARAMETER_1 = $header;
					$OUT_MESSAGE = "";

					$stid = oci_parse($this->db->conn_id, 'BEGIN :OUT_MESSAGE := SIMTAX_PAJAK_UTILITY_PKG.createPembetulan(:PARAMETER_1); end;');

					oci_bind_by_name($stid, ':PARAMETER_1', $PARAMETER_1, 200);
					oci_bind_by_name($stid, ':OUT_MESSAGE', $OUT_MESSAGE, 100, SQLT_CHR);

					if (oci_execute($stid)) {
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

			} else if ($status == "Open" || $status == "OPEN") {
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
		$cabang = $this->kode_cabang;
		$idPajakHeader = $this->input->post('header_id');
		$pajak = $this->input->post('pajak');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan_ke = $this->input->post('pembetulan_ke');
		$date = date('Y-m-d H:i:s');

		$sql = "DELETE FROM SIMTAX_PAJAK_HEADERS where PAJAK_HEADER_ID ='" . $idPajakHeader . "' and KODE_CABANG='" . $cabang . "'";
		$query = $this->db->query($sql);
		if ($query) {
			$sql1 = "DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_HEADER_ID ='" . $idPajakHeader . "' and KODE_CABANG='" . $cabang . "'";
			$query1 = $this->db->query($sql1);
			if ($query1) {
				$sql2 = "DELETE FROM SIMTAX_MASTER_PERIOD where BULAN_PAJAK ='" . $bulan . "' and TAHUN_PAJAK ='" . $tahun . "' and upper(NAMA_PAJAK) ='" . strtoupper($pajak) . "' and PEMBETULAN_KE ='" . $pembetulan_ke . "' and KODE_CABANG='" . $cabang . "'";
				$query2 = $this->db->query($sql2);

				$sql3 = "DELETE FROM SIMTAX_ACTION_HISTORY where PAJAK_HEADER_ID ='" . $idPajakHeader . "'";
				$query3 = $this->db->query($sql3);
				if ($query2 && $query3) {
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

	function get_master_pajak()
	{
		$queryExec = "Select jenis_pajak, display from simtax_master_jns_pajak where jenis_pajak in ('PPH PSL 21 BULANAN','PPH PSL 21 BULANAN FINAL', 'PPH PSL 21 BULANAN NON FINAL') order by jenis_pajak";
		$query = $this->db->query($queryExec);
		$result['query'] = $query;
		return $result;
	}

	//============================== VIEW STATUS =================================

	function get_view()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		$wherePajak = "";
		$whereBulan = "";
		$whereTahun = "";
		$wherePembetulan = "";
		if ($this->input->post('_searchPph')) {
			$wherePajak = " and sph.nama_pajak='PPH PSL 21'";
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
						  where sph.kode_cabang='" . $cabang . "' and sph.nama_pajak like '%PPH PSL 21%'
						 -- and sph.status = 'APPROVED BY PUSAT' 
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


	/* select sph.NAMA_PAJAK
, sph.PAJAK_HEADER_ID
, sph.MASA_PAJAK
, sph.BULAN_PAJAK
, sph.TAHUN_PAJAK
, sph.CREATION_DATE
, sah.USER_NAME
, sph.STATUS
, sph.TGL_SUBMIT_SUP
, sph.TGL_APPROVE_SUP
, sph.TGL_APPROVE_PUSAT
, sph.PEMBETULAN_KE
, sph.KODE_CABANG
, (select sum(spl.JUMLAH_POTONG)
    from simtax_pajak_lines spl
	where spl.pajak_header_id = sph.pajak_header_id
    and spl.IS_CHEKLIST = 1) ttl_jml_potong
     from simtax_pajak_headers sph
      inner join  simtax_action_history sah  on sah.pajak_header_id=sph.pajak_header_id
     where sph.kode_cabang='000'
     and sph.nama_pajak like '%PPH PSL 21%'
ORDER BY sph.creation_date desc */


	function get_rekonsiliasi_detail()
	{
		$cabang = $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}
		$where2 = " and a.bulan_pajak = '" . $_POST['_searchBulan'] . "' and a.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select DISTINCT a.*
						, a.nama_wp vendor_name
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1
					--	, a.npwp npwp1
						, a.alamat_wp address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					--	left join SIMTAX_MASTER_SUPPLIER c
					--	on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
						where a.kode_cabang='" . $cabang . "'
						" . $where2 . $where . "
						order by a.pajak_line_id DESC";
		//print_r ($queryExec); end();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function get_detail_summary_rekonsiliasi($st)
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		if ($st == 1) {
			$where = " and spl.IS_CHEKLIST=1";
		} else if ($st == 0) {
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where = "";
		}

		$queryExec = "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							 , smp.STATUS
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = " . $_POST['_searchBulan'] . "
						  and sph.tahun_pajak = " . $_POST['_searchTahun'] . "
						  and upper(sph.nama_pajak) = '" . strtoupper($_POST['_searchPph']) . "'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $_POST['_searchPembetulan'] . "						  
						  " . $where . "
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function action_detail_tot_rekonsiliasi()
	{
		$cabang = $this->kode_cabang;
		$pajak = $this->input->post('pajak');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');

		$sql3 = "select 
						sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							 , smp.status 
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl, simtax_master_period smp
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = '" . strtoupper($pajak) . "'
						  and sph.kode_cabang = '" . $cabang . "'
						  and sph.pembetulan_ke=" . $pembetulan . "
					group by        
						smp.STATUS ";

		$query3 = $this->db->query($sql3);

		if ($query3) {
			return $query3;
		} else {
			return false;
		}

	}

	function get_history()
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;

		$queryExec = "Select sah.ACTION_CODE
						, to_char(sah.ACTION_DATE,'DD-MON-YYYY HH24:MI:SS') ACTION_DATE
						, sah.user_name
						, sah.catatan
						, sph.bulan_pajak , sph.masa_pajak, sph.tahun_pajak from simtax_action_history sah
						inner join simtax_pajak_headers sph
						on sah.pajak_header_id=sph.pajak_header_id 
						where sph.kode_cabang='" . $cabang . "'
						  and sph.bulan_pajak = " . $_POST['_searchBulan'] . "
						  and sph.tahun_pajak = " . $_POST['_searchTahun'] . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  and sph.pembetulan_ke=" . $_POST['_searchPembetulan'] . "	
						order by action_date desc";

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

	/* function get_history()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;

		$queryExec	="Select sah.*, sph.bulan_pajak , sph.masa_pajak, sph.tahun_pajak from simtax_action_history sah
						inner join simtax_pajak_headers sph
						on sah.pajak_header_id=sph.pajak_header_id
						where sph.kode_cabang='".$cabang."'
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
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
	} */


	// ======================== KOMPILASI ==========================
	function get_kompilasi()
	{
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		//$whereCabang	= "";
		if ($q) {
			$where .= " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}
		if ($_POST['_searchCabang']) {
			$where .= " and b.kode_cabang='" . $_POST['_searchCabang'] . "' ";
		}
		$where .= " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select a.*, a.tipe_21 tipe, a.nama_wp vendor_name
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1 
						,a.alamat_wp saddress_line1
						,e.kode_cabang cabang_master ,e.nama_cabang 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
					--	left join SIMTAX_MASTER_SUPPLIER c
					--	on a.VENDOR_ID=c.VENDOR_ID 
					--	and a.ORGANIZATION_ID=c.ORGANIZATION_ID			
						where a.tipe_21 ='BULANAN'
					 	and b.status in ('CLOSE', 'APPROVAL SUPERVISOR')
						--and upper(d.STATUS) ='CLOSE'
						and a.is_cheklist = '1'
						" . $where . "
						order by a.tipe_21 DESC";
		//print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function get_kompilasi1()
	{
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		$whereCabang = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}
		if ($_POST['_searchCabang']) {
			$whereCabang = " and b.kode_cabang='" . $_POST['_searchCabang'] . "' ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select a.*
						, a.tipe_21 tipe
						, a.nama_wp vendor_name
						, rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1 
						, a.alamat_wp saddress_line1
						, e.kode_cabang cabang_master 
						, e.nama_cabang 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
					--	left join SIMTAX_MASTER_SUPPLIER c
					--	on a.VENDOR_ID=c.VENDOR_ID 
					--	and a.ORGANIZATION_ID=c.ORGANIZATION_ID			
						where a.tipe_21 ='BULANAN FINAL'
					-- and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) 
					 	and b.status in ('CLOSE','APPROVAL SUPERVISOR')
						--and upper(d.STATUS) ='CLOSE'
						and a.is_cheklist = '1'
						" . $whereCabang . $where2 . $where . "
						order by a.tipe_21 DESC";
		//print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function get_kompilasi2()
	{
		ini_set('memory_limit', '-1');
		$q = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
		$where = "";
		$whereCabang = "";
		if ($q) {
			$where = " and (upper(a.NO_FAKTUR_PAJAK) like '%" . strtoupper($q) . "%' or upper(a.nama_wp) like '%" . strtoupper($q) . "%') ";
		}
		if ($_POST['_searchCabang']) {
			$whereCabang = " and b.kode_cabang='" . $_POST['_searchCabang'] . "' ";
		}
		$where2 = " and b.bulan_pajak = '" . $_POST['_searchBulan'] . "' and b.tahun_pajak = '" . $_POST['_searchTahun'] . "' and upper(b.nama_pajak) = 'PPH PSL 21' and b.pembetulan_ke = '" . $_POST['_searchPembetulan'] . "' ";

		$queryExec = "select a.*, a.tipe_21 tipe, a.nama_wp vendor_name
						,rpad(replace(replace(a.npwp,'.',''),'-',''),15,'0') npwp1
						,abs(a.jumlah_potong) jumlah_potong_21 
						, a.alamat_wp saddress_line1
						, e.kode_cabang cabang_master ,e.nama_cabang 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
					--	left join SIMTAX_MASTER_SUPPLIER c
					--	on a.VENDOR_ID=c.VENDOR_ID 
					--	and a.ORGANIZATION_ID=c.ORGANIZATION_ID			
						where a.tipe_21 ='BULANAN NON FINAL'
					-- and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) 
					 	and b.status in ('CLOSE','APPROVAL SUPERVISOR')
						--and upper(d.STATUS) ='CLOSE' 
						and a.is_cheklist = '1'
						" . $whereCabang . $where2 . $where . "
						order by a.tipe_21 DESC";
		//print_r($queryExec); exit();
		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}


	function get_summary_kompilasi($st)
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;
		if ($st == 1) {
			$where = " and spl.IS_CHEKLIST=1";
		} else if ($st == 0) {
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where = "";
		}

		$whereCabang = "";
		if ($_POST['_searchCabang']) {
			$whereCabang = " and sph.kode_cabang='" . $_POST['_searchCabang'] . "' ";
		}

		$queryExec = "select 
							   spl.IS_CHEKLIST
							 , case when spl.IS_CHEKLIST = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
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
						  and sph.bulan_pajak = " . $_POST['_searchBulan'] . "
						  and sph.tahun_pajak = " . $_POST['_searchTahun'] . "
						  and upper(sph.nama_pajak) = 'PPH PSL 21'
						  " . $whereCabang . "
						  and sph.pembetulan_ke=" . $_POST['_searchPembetulan'] . "
						  --and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and sph.status in ('CLOSE','APPROVAL SUPERVISOR')
						  --and upper(smp.status) ='CLOSE'
						  " . $where . "
						group by        
							   skc.kode_cabang, skc.nama_cabang, spl.IS_CHEKLIST, smp.STATUS 
						order by skc.kode_cabang";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $_POST['start'] . "+" . $_POST['length'] . "
					)
					WHERE rnum >" . $_POST['start'] . "";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;
	}

	function action_tot_kompilasi($st)
	{
		$pajak = $this->input->post('pajak');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');
		$cabang = $this->input->post('cabang');

		if ($st == 1) {
			$where = " and spl.IS_CHEKLIST=1";
		} else if ($st == 0) {
			$where = " and spl.IS_CHEKLIST=0";
		} else {
			$where = "";
		}

		$whereCabang = "";
		if ($cabang) {
			$whereCabang = " and sph.kode_cabang='" . $cabang . "' ";
		}
		$sql3 = "select spl.IS_CHEKLIST
							 , sum(nvl(spl.NEW_JUMLAH_POTONG,spl.jumlah_potong)) jml_potong
							 , smp.status
							-- , skc.kode_cabang
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							-- , simtax_kode_cabang skc
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						 -- and sph.kode_cabang = skc.kode_cabang
						  and sph.bulan_pajak = " . $bulan . "
						  and sph.tahun_pajak = " . $tahun . "
						  and upper(sph.nama_pajak) = '" . strtoupper($pajak) . "'
						  " . $whereCabang . $where . "
						  and sph.pembetulan_ke=" . $pembetulan . "
						 -- and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='CLOSE'
					group by        
						spl.IS_CHEKLIST, smp.status";

		$query3 = $this->db->query($sql3);

		if ($query3) {
			return $query3;
		} else {
			return false;
		}

	}


	//ADDED BY MIKE  2018
	//QUERY GET PPH 23 DATA
	//----------------------------------------------------------------------------
	function get_spt($bulan, $tahun, $pph, $nf = FALSE, $debug = FALSE)
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;

		$where2 = " and b.bulan_pajak = '" . $bulan . "' and b.tahun_pajak = '" . $tahun . "' and upper(a.nama_pajak) = 'PPH PSL 21' ";

		if ($debug) {
			$queryExec = "Select DISTINCT a.*
								, a.nama_wp vendor_name
								,case when a.npwp='0'  then '00.000.000-0.000.000'
                        when substr(a.npwp,1,2)='00'  then '00.000.000-0.000.000'
                        when length(a.npwp)=15 then substr(a.npwp,1,2)||'.'||substr(a.npwp,3,3)||'.'||substr(a.npwp,6,3)||'-'||substr(a.npwp,9,1)||'.'||substr(a.npwp,10,3)||'.'||substr(a.npwp,13,3)
                                when npwp is null then '00.000.000-0.000.000'
                            else
                                npwp
                            end npwp1
								,a.alamat_wp address_line1
								,case when length(e.NPWP_PEMOTONG)=15 then substr(e.NPWP_PEMOTONG,1,2)||'.'||substr(e.NPWP_PEMOTONG,3,3)||'.'||substr(e.NPWP_PEMOTONG,6,3)||'-'||substr(e.NPWP_PEMOTONG,9,1)||'.'||substr(e.NPWP_PEMOTONG,10,3)||'.'||substr(e.NPWP_PEMOTONG,13,3) else e.NPWP_PEMOTONG   end npwppp
								,e.NAMA_WP_PEMOTONG as namapp
								,e.NAMA_PETUGAS_PENANDATANGAN
								,e.URL_TANDA_TANGAN
								,e.JABATAN_PETUGAS_PENANDATANGAN
								,b.TGL_APPROVE_SUP
						  from SIMTAX_PAJAK_LINES a
								inner join SIMTAX_PAJAK_HEADERS b
								on a.pajak_header_id=b.pajak_header_id
								inner join SIMTAX_MASTER_PERIOD d
								on b.PERIOD_ID=d.PERIOD_ID
								left join SIMTAX_PEMOTONG_PAJAK e
								on a.kode_cabang = e.KODE_CABANG 
                                AND e.nama_pajak = 'PPH PSL 21'
                                and e.document_type = 'Bukti Potong'
                                and e.START_EFFECTIVE_DATE < b.TGL_APPROVE_SUP
								where a.kode_cabang='" . $cabang . "'
								--AND e.nama_pajak = 'PPH PSL 21'
								and a.tipe_21='BULANAN FINAL'
								and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR') 
								and a.IS_CHEKLIST='1'
								" . $where2 . "
								order by a.pajak_line_id DESC";

		} else {
			$queryExec = "Select DISTINCT a.*
								, a.nama_wp vendor_name
								,case when a.npwp='0'  then '00.000.000-0.000.000'
                        when substr(a.npwp,1,2)='00'  then '00.000.000-0.000.000'
                        when length(a.npwp)=15 then substr(a.npwp,1,2)||'.'||substr(a.npwp,3,3)||'.'||substr(a.npwp,6,3)||'-'||substr(a.npwp,9,1)||'.'||substr(a.npwp,10,3)||'.'||substr(a.npwp,13,3)
                                when npwp is null then '00.000.000-0.000.000'
                            else
                                npwp
                            end npwp1
							--	,rpad (nvl (a.npwp,'0'),15,'0' )npwp1
								,a.alamat_wp address_line1
								,case when length(e.NPWP_PEMOTONG)=15 then substr(e.NPWP_PEMOTONG,1,2)||'.'||substr(e.NPWP_PEMOTONG,3,3)||'.'||substr(e.NPWP_PEMOTONG,6,3)||'-'||substr(e.NPWP_PEMOTONG,9,1)||'.'||substr(e.NPWP_PEMOTONG,10,3)||'.'||substr(e.NPWP_PEMOTONG,13,3) else e.NPWP_PEMOTONG   end npwppp
								,e.NAMA_WP_PEMOTONG as namapp
								,e.NAMA_PETUGAS_PENANDATANGAN
								,e.URL_TANDA_TANGAN
								,e.JABATAN_PETUGAS_PENANDATANGAN
								,b.TGL_APPROVE_SUP
						  from SIMTAX_PAJAK_LINES a
								inner join SIMTAX_PAJAK_HEADERS b
								on a.pajak_header_id=b.pajak_header_id
								inner join SIMTAX_MASTER_PERIOD d
								on b.PERIOD_ID=d.PERIOD_ID
								left join SIMTAX_PEMOTONG_PAJAK e
								on a.kode_cabang = e.KODE_CABANG 
                                AND e.nama_pajak = 'PPH PSL 21'
                                and e.document_type = 'Bukti Potong'
                                and e.START_EFFECTIVE_DATE < b.TGL_APPROVE_SUP
								where a.kode_cabang='" . $cabang . "'
								--AND e.nama_pajak = 'PPH PSL 21'
								and a.tipe_21='BULANAN NON FINAL'
								and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR') 
								and a.IS_CHEKLIST='1'
								" . $where2 . "
								order by a.pajak_line_id DESC";
		}

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.*
						FROM(
							" . $queryExec . "
						) a
					)";
		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		//print_r($sql); exit();
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_1721($tahun, $npwpPemotong)
	{
		ini_set('memory_limit', '-1');
		$cabang = $this->kode_cabang;

		$queryExec = "select
						substr(p21.no_bukti,5,2) no_1,
						substr(p21.no_bukti,8,2) no_2,
						substr(p21.no_bukti,11,7) no_3,
						substr(p21.NPWP,1,9) npwp_1,
						substr(p21.NPWP,10,3) npwp_2,
						substr(p21.NPWP,13,3) npwp_3,
						SUBSTR (p21.ADDRESS, 1, 26) ALAMAT_1,
       					SUBSTR (p21.ADDRESS, 27, 26) ALAMAT_2,
       					CASE WHEN sex = ('M') THEN 'X' ELSE 'X' END JK,
						p21.* from simtax_pph21_1721_a1 p21 
						where p21.tahun = " . $tahun . " and substr(p21.NPWP_PEMOTONG,-6,3) = '" . $npwpPemotong . "' ";

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.*
						FROM(
							" . $queryExec . "
						) a
					)";
		$sql2 = $queryExec;

		/*print_r($sql2); die();*/

		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_ntpn($tahun_pajak, $jenis_pajak, $whereCabang, $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');

		$where = "";
		if ($keywords) {
			//$q     = strtoupper($keywords);
			$where .= " and (upper(BANK) like '%" . strtoupper($keywords) . "%' or NTPN like '%" . $keywords . "%') ";
		}

		$queryExec = " SELECT * FROM SIMTAX_NTPN WHERE TAHUN = '" . $tahun_pajak . "' AND JENIS_PAJAK = '" . $jenis_pajak . "' AND KODE_CABANG in (" . $whereCabang . ") " . $where . " ";

		$sql2 = $queryExec;
		$query2 = $this->db->query($sql2);
		$rowCount = $query2->num_rows();

		$sql = "SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							" . $queryExec . "
						) a 
						WHERE rownum <=" . $start . "+" . $length . "
					)
					WHERE rnum >" . $start . "";


		$query = $this->db->query($sql);
		$result['query'] = $query;
		$result['jmlRow'] = $rowCount;
		return $result;

	}

	function check_ntpn($id, $bulan, $tahun, $pembetulan, $jenis_pajak, $kode_cabang, $ntpn)
	{
		$andID = "";
		if ($id != "") {
			$andID = " AND ID != " . $id;
		}

		$sql = "SELECT COUNT(*) TOTAL FROM SIMTAX_NTPN WHERE BULAN = '" . $bulan . "' AND TAHUN = '" . $tahun . "' AND PEMBETULAN = '" . $pembetulan . "' AND JENIS_PAJAK = '" . $jenis_pajak . "' AND KODE_CABANG = '" . $kode_cabang . "' AND NTPN = '" . $ntpn . "'" . $andID;

		$query = $this->db->query($sql);

		$rowCount = $query->row()->TOTAL;

		return $rowCount;

	}

	function update_ntpn($id, $data, $tanggal_setor, $tanggal_lapor)
	{

		$date = date("Y-m-d H:i:s");

		if ($tanggal_setor != "") {
			$this->db->set('TANGGAL_SETOR', "TO_DATE('" . $tanggal_setor . "', 'SYYYY-MM-DD HH24:MI:SS')", false);
		}
		if ($tanggal_lapor != "") {
			$this->db->set('TANGGAL_LAPOR', "TO_DATE('" . $tanggal_lapor . "', 'SYYYY-MM-DD HH24:MI:SS')", false);
		}
		$this->db->where('ID', $id);

		$update = $this->db->update("SIMTAX_NTPN", $data);

		if ($update) {
			//simtax_update_history("SIMTAX_NTPN","UPDATE", $id);
			return true;
		} else {
			return false;
		}
	}

	function add_ntpn($data, $tanggal_setor, $tanggal_lapor)
	{

		$date = date("Y-m-d H:i:s");

		if ($tanggal_setor != "") {
			$this->db->set('TANGGAL_SETOR', "TO_DATE('" . $tanggal_setor . "', 'SYYYY-MM-DD HH24:MI:SS')", false);
		}
		if ($tanggal_lapor != "") {
			$this->db->set('TANGGAL_LAPOR', "TO_DATE('" . $tanggal_lapor . "', 'SYYYY-MM-DD HH24:MI:SS')", false);
		}

		$insert = $this->db->insert("SIMTAX_NTPN", $data);

		if ($insert) {
			simtax_update_history("SIMTAX_NTPN", "CREATE");
			return true;
		} else {
			return false;
		}
	}

	function delete_ntpn($id)
	{

		$sql = "DELETE FROM SIMTAX_NTPN
					WHERE ID = '" . $id . "'";

		$query = $this->db->query($sql);

		if ($query) {
			return true;
		}
	}
//=============================================================///


}
