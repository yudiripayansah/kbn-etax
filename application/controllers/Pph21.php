<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pph21 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('dashboard', 'refresh');
		}

		$this->load->model('Pph21_mdl');
		$this->load->model('Master_mdl');
		$this->load->model('Cabang_mdl');
		$this->kode_cabang = $this->session->userdata('kd_cabang');

	}

	public function tgl_db($date)
	{
		$part = explode("/", $date);
		$newDate = $part[2] . "-" . $part[1] . "-" . $part[0];
		return $newDate;
	}

	function show_rekonsiliasi()
	{
		$this->template->set('title', 'Rekonsiliasi');
		$data['subtitle'] = "Rekonsiliasi ";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/rekonsiliasi', $data);
	}

	function show_approv()
	{
		$this->template->set('title', 'Approv');
		$data['subtitle'] = "Approv PPh";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/approv', $data);
	}

	function load_approv()
	{
		$hasil = $this->Pph21_mdl->get_approv();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID']

				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	//==============================================FINAL ==============================
	function load_approv_final()
	{
		$hasil = $this->Pph21_mdl->get_approv_final();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID']

				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	//==============================================NON FINAL ===========================

	function load_approv_nonfinal()
	{
		$hasil = $this->Pph21_mdl->get_approv_nonfinal();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP1'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG_21'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID']

				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	//=======================================================================================

	function cek_row_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_cek_row_rekonsiliasi();
		$result['st'] = 0;
		if ($data) {
			$ii = 0;
			$records = "";
			foreach ($data->result_array() as $row) {
				$ii++;
				if ($row['IS_CHEKLIST'] == 1) {
					if (!$row['KODE_PAJAK'] || $row['KODE_PAJAK'] == "" || !$row['VENDOR_NAME'] || $row['VENDOR_NAME'] == "" || !$row['NPWP1'] || $row['NPWP1'] == "" || !$row['ADDRESS_LINE1'] || $row['ADDRESS_LINE1'] == "") {
						$records .= $ii . ", ";
						$result['st'] = 1;
					}
				}
				$result['data'] = "Nomor " . $records . " Kolom Nama WP / NPWP / Alamat / Kode Pajak Masih Kosong!";
			}
		}
		echo json_encode($result);
		$data->free_result();
	}


	//=========================== CEK ALL
	function get_selectAll_bulanan()
	{
		$data = $this->Pph21_mdl->action_get_selectAll();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}


	function get_selectAll_final()
	{
		$data = $this->Pph21_mdl->action_get_selectAll_final();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function get_selectAll_nonfinal()
	{
		$data = $this->Pph21_mdl->action_get_selectAll_nonfinal();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function save_approv()
	{
		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_rekonsiliasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}

		if ($permission === true) {
			$data = $this->Pph21_mdl->action_save_approv();
			$hsl = 0;
			if ($data) {
				$hsl = 1;
			} else {
				$hsl = 0;
			}
		} else {
			$hsl = 0;
		}
		echo $hsl;
	}


	/* function save_approv()
	{
		$data	= $this->Pph21_mdl->action_save_approv();
		$hsl	= 0;
		if($data){
			$hsl= 1;
		} else {
			$hsl= 0;
		}
		echo $hsl;
	} */


	function get_start()
	{
		$data = $this->Pph21_mdl->action_get_start();
		if ($data) {
			if ($data->num_rows() > 0) {
				$row = $data->row();
				$result['status'] = strtoupper($row->STATUS);
				$result['status_period'] = strtoupper($row->STATUS_PERIOD);
				//$result['keterangan'] 	 = $row->KETERANGAN;
			} else {
				$result['status'] = "-------------";
				$result['status_period'] = " ----------";
				//$result['keterangan'] 	 = "";
			}
			$result['isSuccess'] = 1;
		} else {
			$result['isSuccess'] = 0;
		}
		echo json_encode($result);
		$data->free_result();
	}

	function show_download()
	{
		$this->template->set('title', 'Download & Cetak');
		$data['subtitle'] = "Download & Cetak Pph";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/download', $data);
	}

	function load_download()
	{
		$hasil = $this->Pph21_mdl->get_download();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					//'tipe_21'				    => $row['TIPE_21'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP1'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID']

				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	//========================== download CSV

	//=======================================


	function show_bukti_potong()
	{
		$this->template->set('title', 'Koreksi');
		$data['subtitle'] = "Koreksi Bukti Potong";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/bukti_potong', $data);
	}

	function load_bukti_potong()
	{
		$hasil = $this->Pph21_mdl->get_bukti_potong();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['VENDOR_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ALAMAT_WP'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'pembetulan' => $row['PEMBETULAN']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}

	function save_bukti_potong()
	{
		$data = $this->Pph21_mdl->action_save_bukti_potong();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function delete_bukti_potong()
	{
		$data = $this->Pph21_mdl->action_delete_bukti_potong();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}


	function show_closing()
	{
		$this->template->set('title', 'Closing PPh 21');
		$data['subtitle'] = "Closing";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/closing', $data);
	}

	function load_closing()
	{
		$hasil = $this->Pph21_mdl->get_closing();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				if ($row['STATUS'] == "Open") {
					$st = "<span class='label label-success'>" . $row['STATUS'] . "</span>";
				} else {
					$st = "<span class='label label-danger'>" . $row['STATUS'] . "</span>";
				}
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'cabang' => $row['KODE_CABANG'],
					'params' => $row['STATUS'],
					'status' => $st
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}

	function save_saldo_awal()
	{
		$data = $this->Pph21_mdl->action_save_saldo_awal();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}


	function save_closing()
	{
		$data = $this->Pph21_mdl->action_save_closing();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function cek_closing()
	{
		$data = $this->Pph21_mdl->action_cek_closing();
		//print_r($data."-asa");exit();
		if ($data > 0) {
			echo '1'; //open
		} else {
			echo '0';
		}
	}


	/*Awal Detail Rekonsiliasi================================================================================*/
	function load_detail_summary()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_rekonsiliasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}

		$result['data'] = "";
		$result['draw'] = "";
		$result['recordsTotal'] = 0;
		$result['recordsFiltered'] = 0;

		if ($permission === true) {

			$hasil = $this->Pph21_mdl->get_detail_summary();
			$rowCount = $hasil['jmlRow'];
			$query = $hasil['query'];
			$totselisih = 0;
			if ($rowCount > 0) {
				$ii = 0;
				foreach ($query->result_array() as $row) {
					$ii++;
					$totselisih = $totselisih + $row['JUMLAH_POTONG'];
					$result['data'][] = array(
						'no' => $row['RNUM'],
						'nama_wp' => $row['NAMA_WP'],
						'npwp1' => $row['NPWP1'],
						'alamat_wp' => $row['ADDRESS_LINE1'],
						'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
						'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
						'dpp' => number_format($row['DPP'], 2, '.', ','),
						'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
						'keterangan' => $row['KETERANGAN'],
						'totselisih' => number_format($totselisih, 2, '.', ',')
					);
				}

				$query->free_result();

				$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
				$result['recordsTotal'] = $rowCount;
				$result['recordsFiltered'] = $rowCount;

			} else {
				$result['data'] = "";
				$result['draw'] = "";
				$result['recordsTotal'] = 0;
				$result['recordsFiltered'] = 0;
			}
		}

		echo json_encode($result);
		$query->free_result();
	}

	function load_total_detail_summary()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_rekonsiliasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}
		$ii = 0;
		$result['jml_tidak_dilaporkan'] = 0;
		$result['jml_tgl_akhir'] = 0;
		$result['jml_import_csv'] = 0;
		$result['total'] = 0;
		if ($permission === true) {
			$hasil = $this->Pph21_mdl->get_total_detail_summary();
			foreach ($hasil->result_array() as $row) {
				$ii++;
				$result['total'] = $result['total'] + $row['JUMLAH_POTONG'];

				if ($row['KETERANGAN'] == 'Tidak Dilaporkan') {
					$result['jml_tidak_dilaporkan'] = $row['JUMLAH_POTONG'];
				}
				if ($row['KETERANGAN'] == 'Tanggal 26 - 31 Bulan ini') {
					$result['jml_tgl_akhir'] = $row['JUMLAH_POTONG'];
				}
				if ($row['KETERANGAN'] == 'Import CSV') {
					$result['jml_import_csv'] = $row['JUMLAH_POTONG'];
				}
			}
		}
		echo json_encode($result);
		$hasil->free_result();
	}

	/*Akhir Detail Rekonsiliasi================================================================================*/

	function load_summary_rekonsiliasiAll1()
	{
		$bulan = $_POST['_searchBulan'];
		$tahun = $_POST['_searchTahun'];
		$pajak = 'PPH PSL 21';
		$pembetulan = $_POST['_searchPembetulan'];
		$step = $_POST['_step'];

		$hasil_currency = $this->Pph21_mdl->get_currency1($bulan, $tahun, $pajak, $pembetulan, $step);
		$rowCount = $hasil_currency['jmlRow'];
		$queryC = $hasil_currency['query'];
		$ii = 0;

		if ($rowCount > 0) {
			foreach ($queryC->result_array() as $rowC) {
				$dibayarkan = 0;
				$tidakDibayarkan = 0;
				$ii++;
				$hasil = $this->Pph21_mdl->get_summary_rekonsiliasiAll1($bulan, $tahun, $pajak, $pembetulan, $step);
				$query1 = $hasil['queryExec'];

				foreach ($query1->result_array() as $row) {
					if ($row['PENGELOMPOKAN'] == "Dilaporkan") {
						$dibayarkan = $row['JML_POTONG'];
					} else {
						$tidakDibayarkan = $row['JML_POTONG'];
					}
				}

				$saldoAkhir = $rowC['SALDO_AWAL'] + ($rowC['MUTASI_DEBIT'] - $rowC['MUTASI_KREDIT']);
				$selisih = $saldoAkhir - $dibayarkan;

				if ($step == "REKONSILIASI") {
					$result['data'][] = array(
						'no' => $ii,
						'saldo_awal' => '<input type="text" class="form-control input-sm text-right" id="saldoAwal" name="saldoAwal" placeholder="Saldo Awal" value="' . number_format($rowC['SALDO_AWAL'], 2, '.', ',') . '">',

						'mutasi_debet' => '<input type="text" class="form-control input-sm text-right" id="mutasiDebet" name="mutasiDebet" placeholder="Mutasi Debet" value="' . number_format($rowC['MUTASI_DEBIT'], 2, '.', ',') . '">',

						'mutasi_kredit' => '<input type="text" class="form-control input-sm text-right" id="mutasiKredit" name="mutasiKredit" placeholder="Mutasi Kredit" value="' . number_format($rowC['MUTASI_KREDIT'], 2, '.', ',') . '">',

						'saldo_akhir' => '<input type="text" class="form-control input-sm text-right" id="saldoAkhir" name="saldoAkhir" placeholder="Saldo Akhir" disabled value="' . number_format($saldoAkhir, 2, '.', ',') . '">',

						'jumlah_dibayarkan' => '<input type="text" class="form-control input-sm text-right" id="jmlDibayarkan" name="jmlDibayarkan" placeholder="Jumlah DIbayarkan" disabled value="' . number_format($dibayarkan, 2, '.', ',') . '">',

						'tidak_dilaporkan' => '<input type="text" class="form-control input-sm text-right" id="tidakDilaporkan" name="tidakDilaporkan" placeholder="Tidak DIlaporkan" disabled value="' . number_format($tidakDibayarkan, 2, '.', ',') . '">',

						'selisih' => '<input type="text" class="form-control input-sm text-right" id="selisih" name="selisih" placeholder="Selisih" disabled value="' . number_format($selisih, 2, '.', ',') . '">',
					);
				} else {
					$result['data'][] = array(
						'no' => $ii,
						'saldo_awal' => number_format($rowC['SALDO_AWAL'], 2, '.', ','),

						'mutasi_debet' => number_format($rowC['MUTASI_DEBIT'], 2, '.', ','),

						'mutasi_kredit' => number_format($rowC['MUTASI_KREDIT'], 2, '.', ','),

						'saldo_akhir' => number_format($saldoAkhir, 2, '.', ','),

						'jumlah_dibayarkan' => number_format($dibayarkan, 2, '.', ','),

						'tidak_dilaporkan' => number_format($tidakDibayarkan, 2, '.', ','),

						'selisih' => number_format($selisih, 2, '.', ','),
					);
				}

			}

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;
		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}

		echo json_encode($result);
	}

	// ========== RINGKASAN REKON NON FINAL
	function load_summary_rekonsiliasiAll()
	{
		$bulan = $_POST['_searchBulan'];
		$tahun = $_POST['_searchTahun'];
		$pajak = 'PPH PSL 21';
		$pembetulan = $_POST['_searchPembetulan'];

		$hasil_currency = $this->Pph21_mdl->get_currency($bulan, $tahun, $pajak, $pembetulan);
		$rowCount = $hasil_currency['jmlRow'];
		$queryC = $hasil_currency['query'];
		$ii = 0;

		if ($rowCount > 0) {
			foreach ($queryC->result_array() as $rowC) {
				$dibayarkan = 0;
				$tidakDibayarkan = 0;
				$ii++;
				$hasil = $this->Pph21_mdl->get_summary_rekonsiliasiAll($bulan, $tahun, $pajak, $pembetulan);
				$query1 = $hasil['queryExec'];

				foreach ($query1->result_array() as $row) {
					if ($row['PENGELOMPOKAN'] == "Dilaporkan") {
						$dibayarkan = $row['JML_POTONG'];
					} else {
						$tidakDibayarkan = $row['JML_POTONG'];
					}
				}

				$saldoAkhir = $rowC['SALDO_AWAL'] + ($rowC['MUTASI_DEBIT'] - $rowC['MUTASI_KREDIT']);
				$selisih = $saldoAkhir - $dibayarkan;

				$result['data'][] = array(
					'no' => $ii,
					'saldo_awal' => '<input type="text" class="form-control input-sm text-right" id="saldoAwal" name="saldoAwal" placeholder="Saldo Awal" value="' . number_format($rowC['SALDO_AWAL'], 2, '.', ',') . '">',

					'mutasi_debet' => '<input type="text" class="form-control input-sm text-right" id="mutasiDebet" name="mutasiDebet" placeholder="Mutasi Debet" value="' . number_format($rowC['MUTASI_DEBIT'], 2, '.', ',') . '">',

					'mutasi_kredit' => '<input type="text" class="form-control input-sm text-right" id="mutasiKredit" name="mutasiKredit" placeholder="Mutasi Kredit" value="' . number_format($rowC['MUTASI_KREDIT'], 2, '.', ',') . '">',

					'saldo_akhir' => '<input type="text" class="form-control input-sm text-right" id="saldoAkhir" name="saldoAkhir" placeholder="Saldo Akhir" value="' . number_format($saldoAkhir, 2, '.', ',') . '">',

					'jumlah_dibayarkan' => '<input type="text" class="form-control input-sm text-right" id="jmlDibayarkan" name="jmlDibayarkan" placeholder="Jumlah DIbayarkan" value="' . number_format($dibayarkan, 2, '.', ',') . '">',

					'selisih' => '<input type="text" class="form-control input-sm text-right" id="selisih" name="selisih" placeholder="Selisih" value="' . number_format($selisih, 2, '.', ',') . '">',

					'tidak_dilaporkan' => '<input type="text" class="form-control input-sm text-right" id="tidakDilaporkan" name="tidakDilaporkan" placeholder="Tidak DIlaporkan" value="' . number_format($tidakDibayarkan, 2, '.', ',') . '">'
				);

			}

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;
		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}


		echo json_encode($result);
	}


	/*======================================BULANAN==========================*/
	function load_rekonsiliasi_bulanan()
	{
		$hasil = $this->Pph21_mdl->get_rekonsiliasi_bulanan();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];

		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox-bulanan" . $row['RNUM'] . "' class='checklist bulanan' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox-bulanan" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan' => $row['PEMBETULAN'],  //pembetulan
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'nik' => $row['NIK'],
					'dpp_base_amount' => $row['DPP_BASE_AMOUNT'],
					'tanpa_npwp' => $row['TANPA_NPWP'],
					'is_cheklist' => $row['IS_CHEKLIST']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	/*======================================BULANAN FINAL============================*/
	function load_rekonsiliasi_bulanan_final()
	{
		$hasil = $this->Pph21_mdl->get_rekonsiliasi_bulanan_final();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];

		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox-final" . $row['RNUM'] . "' class='checklist final' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox-final" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan' => $row['PEMBETULAN'],  //pembetulan
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'is_cheklist' => $row['IS_CHEKLIST']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}


	/*====================BULANAN NON FINAL==================================*/
	function load_rekonsiliasi_bulanan_non_final()
	{
		$hasil = $this->Pph21_mdl->get_rekonsiliasi_bulanan_non_final();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];

		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox-nonfinal" . $row['RNUM'] . "' class='checklist nonfinal' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox-nonfinal" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['FULL_NAME'],
					'npwp' => $row['NPWP'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG_21'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tgl_bukti_potong' => $row['TGL_BUKTI_POTONG'],
					'pembetulan' => $row['PEMBETULAN'],  //pembetulan
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'npwp_pemotong' => $row['NPWP_PEMOTONG'],
					'nama_pemotong' => $row['NAMA_PEMOTONG'],
					'wpluarnegeri' => $row['WPLUARNEGERI'],
					'kode_negara' => $row['KODE_NEGARA'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'is_cheklist' => $row['IS_CHEKLIST']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_summary_rekonsiliasi1()
	{
		$hasil = $this->Pph21_mdl->get_summary_rekonsiliasi(1);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-success'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_summary_rekonsiliasi0()
	{
		$hasil = $this->Pph21_mdl->get_summary_rekonsiliasi(0);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-danger'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_tot_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_tot_rekonsiliasi();
		if ($data) {
			if ($data->num_rows() > 0) {
				$row = $data->row();
				$result['total'] = number_format($row->JML_POTONG, 2, '.', ',');
			} else {
				$result['total'] = number_format(0, 2, '.', ',');
			}
			$result['isSuccess'] = 1;
		} else {
			$result['isSuccess'] = 0;
		}
		echo json_encode($result);
		$data->free_result();
	}

	/*================================================================*/
	/* function add_pph()
	{
		$this->template->set('title', 'Tambah PPh 21');
		$data['subtitle']	= "Tambah PPh 21";
		$this->template->load('template', 'pph21/rekonsiliasi/form',$data);
	}  */

	/* function load_master_wp()
	{
      	$hasil	= $this->Pph21_mdl->get_master_wp();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'vendor_id'			=> $row['PERSON_ID'],
								'nama_wp'			=> $row['FULL_NAME'],
								'alamat_wp'			=> $row['ADDRESS_LINE1'],
								'npwp' 				=> $row['NPWP']
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
		echo json_encode($result);

	} */

	function load_master_kode_pajak()
	{
		$hasil = $this->Pph21_mdl->get_master_kode_pajak();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'tax_code' => $row['TAX_CODE'],
					'tipe_21' => $row['TIPE_21'],
					'tax_rate' => $row['TAX_RATE'],
					'description' => $row['DESCRIPTION']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}


	function save_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_save_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function delete_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_delete_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function check_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_check_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function submit_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_submit_rekonsiliasi();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	//forrmat field CSV
	function export_format_csv()
	{

		$tipe = str_replace("%20", " ", $_REQUEST['tipe']);

		$this->load->helper('csv_helper');
		$pajak = ($_REQUEST['tax']) ? $_REQUEST['tax'] : "";
		$date = date("Y-m-d H:i:s");

		$export_arr = array();

		if ($tipe == "BULANAN") {
			$title = array("ID;Masa Pajak;Tahun Pajak;Pembetulan;NPWP;Nama;Kode Pajak;Jumlah Bruto;Jumlah Pph;Kode Negara");
			//$title = array("ID,Masa Pajak,Tahun Pajak,Pembetulan,NPWP,Nama,Kode Pajak,Jumlah Bruto,Jumlah Pph,Kode Negara");
		} else if ($tipe == "BULANAN FINAL") {
			$title = array("ID;Masa Pajak;Tahun Pajak;Pembetulan;Nomor Bukti Potong;NPWP;NIK;Nama;Alamat;Kode Pajak;Jumlah Bruto;Tarif;Jumlah PPh;NPWP Pemotong;Nama Pemotong;Tanggal Bukti Potong");
			//$title = array("ID,Masa Pajak,Tahun Pajak,Pembetulan,Nomor Bukti Potong,NPWP,NIK,Nama,Alamat,Kode Pajak,Jumlah Bruto,Tarif,Jumlah PPh,NPWP Pemotong,Nama Pemotong,Tanggal Bukti Potong");
		} else {
			$title = array("ID;Masa Pajak;Tahun Pajak;Pembetulan;Akun;Nomor Invoice;Nomor Bukti Potong;NPWP;NIK;Nama;Alamat;WP Luar Negeri;Kode Negara;Kode Pajak;Jumlah Bruto;Jumlah DPP;Tanpa NPWP;Tarif;Jumlah PPh;NPWP Pemotong;Nama Pemotong;Tanggal Bukti Potong");
			//$title = array("ID","Masa Pajak","Tahun Pajak","Pembetulan","Nomor Bukti Potong","NPWP","NIK","Nama","Alamat","WP Luar Negeri","Kode Negara","Kode Pajak","Jumlah Bruto","Jumlah DPP","Tanpa NPWP","Tarif","Jumlah PPh","NPWP Pemotong","Nama Pemotong","Tanggal Bukti Potong");
			//$title = array("ID,Masa Pajak,Tahun Pajak,Pembetulan,Nomor Bukti Potong,NPWP,NIK;Nama,Alamat,WP Luar Negeri,Kode Negara,Kode Pajak,Jumlah Bruto,Jumlah DPP,Tanpa NPWP,Tarif,Jumlah PPh,NPWP Pemotong,Nama Pemotong,Tanggal Bukti Potong");
		}

		array_push($export_arr, $title);

		$data = $this->Pph21_mdl->get_format_csv($pajak, $tipe);

		if (!empty($data)) {
			foreach ($data->result_array() as $row) {

				if ($tipe == "BULANAN") {

					array_push($export_arr,
						array(
							$row['PAJAK_LINE_ID'],
							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['NPWP1'],
							$row['FULL_NAME'],
							//$row['NAMA_WP'],
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['JUMLAH_POTONG'],
							$row['KODE_NEGARA'],
							//$row['KODE_CABANG'],

						)
					);
				} else if ($tipe == "BULANAN FINAL") {

					array_push($export_arr,
						array(
							$row['PAJAK_LINE_ID'],
							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['NO_BUKTI_POTONG'],
							$row['NPWP1'],
							$row['NIK'],
							$row['NAMA_WP'],
							$row['ALAMAT_WP'],
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['TARIF'],
							$row['JUMLAH_POTONG'],
							$row['NPWP_PEMOTONG'],
							$row['NAMA_PEMOTONG'],
							$row['TGL_BUKTI_POTONG'],

						)
					);
				} else {

					array_push($export_arr,
						array(

							$row['PAJAK_LINE_ID'],
							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['AKUN_PAJAK'],
							$row['INVOICE_NUM'],
							$row['NO_BUKTI_POTONG'],
							$row['NPWP1'],
							$row['NIK'],
							$row['NAMA_WP'],
							str_replace(',','',$row['ALAMAT_WP']),
							"N",
							"",
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['DPP'],
							($row['NPWP1']) ? "N" : "Y",
							$row['TARIF'],
							$row['JUMLAH_POTONG'],
							$row['NPWP_PEMOTONG'],
							$row['NAMA_PEMOTONG'],
							$row['TGL_BUKTI_POTONG']

						)
					);
				}

			}
		}

		convert_to_csv($export_arr, 'Upload CSV ' . $_REQUEST['tax'] . ' ' . $_REQUEST['tipe'] . ' ' . $date . '.csv', ';');
		
	}


	//=============================== DOWNLOAD DATA CSV================

	function export_format_csv1($pajak_header_id, $tipenya)
	{

		$tipe = str_replace("%20", " ", $tipenya);

		$this->load->helper('csv_helper');
		$date = date("Y-m-d H:i:s");
		$export_arr = array();
		$data = $this->Pph21_mdl->get_format_csv2($pajak_header_id, $tipe);

		if ($tipe == "BULANAN") {

			$title = array("Masa Pajak", "Tahun Pajak", "Pembetulan", "NPWP", "Nama", "Kode Pajak", "Jumlah Bruto", "Jumlah PPh", "Kode Negara");

		} else if ($tipe == "BULANAN FINAL") {

			$title = array("Masa Pajak", "Tahun Pajak", "Pembetulan", "Nomor Bukti Potong", "NPWP", "NIK", "Nama", "Alamat", "Kode Pajak", "Jumlah Bruto", "Tarif", "Jumlah PPh", "NPWP Pemotong", "Nama Pemotong", "Tanggal Bukti Potong");

		} else {

			$title = array(
				"Masa Pajak",
				"Tahun Pajak",
				"Pembetulan",
				"Nomor Bukti Potong",
				"NPWP",
				"NIK",
				"Nama",
				"Alamat",
				"WP Luar Negeri",
				"Kode Negara",
				"Kode Pajak",
				"Jumlah Bruto",
				"Jumlah DPP",
				"Tanpa NPWP",
				"Tarif",
				"Jumlah PPh",
				"NPWP Pemotong",
				"Nama Pemotong",
				"Tanggal Bukti Potong"
			);

		}
		array_push($export_arr, $title);


		if (!empty($data)) {
			foreach ($data->result_array() as $row) {

				if ($tipe == "BULANAN") {

					array_push($export_arr,
						array(
							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['NPWP1'],
							$row['FULL_NAME'],
							//$row['NAMA_WP'],
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['JUMLAH_POTONG'],
							$row['KODE_NEGARA'],
							//$row['KODE_CABANG'],

						)
					);
				} else if ($tipe == "BULANAN FINAL") {

					array_push($export_arr,
						array(

							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['NO_BUKTI_POTONG'],
							$row['NPWP1'],
							$row['NIK'],
							$row['NAMA_WP'],
							$row['ALAMAT_WP'],
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['TARIF'],
							$row['JUMLAH_POTONG'],
							$row['NPWP_PEMOTONG'],
							$row['NAMA_PEMOTONG'],
							$row['TGL_BUKTI_POTONG1'],

						)
					);
				} else {

					array_push($export_arr,
						array(

							$row['BULAN_PAJAK'],
							$row['TAHUN_PAJAK'],
							$row['PEMBETULAN_KE'],
							$row['NO_BUKTI_POTONG'],
							$row['NPWP1'],
							$row['NIK'],
							$row['NAMA_WP'],
							$row['ALAMAT_WP'],
							"N",
							"",
							$row['KODE_PAJAK'],
							$row['DPP'],
							$row['DPP'],
							($row['NPWP1']) ? "N" : "Y",
							$row['TARIF'],
							$row['JUMLAH_POTONG_21'],
							$row['NPWP_PEMOTONG'],
							$row['NAMA_PEMOTONG'],
							$row['TGL_BUKTI_POTONG1']

						)
					);
				}

			}
		}

		/*	echo json_encode($export_arr);
	die();*/

		//convert_to_csv($export_arr, 'CSV_PPH_PSL_21_'.$tipe.'_'.$date.'.csv', ';');
		convert_to_csv_PPH21($export_arr, 'CSV_PPH_PSL_21_' . $tipe . '_' . $date . '.csv', ';');
	}


	//=======================================================================================//
	function cek_data_csv()
	{

		$data = $this->Pph21_mdl->get_format_csv();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	private function _upload($field_name, $folder_name, $file_name, $allowed_types, $ext)
	{
		//file upload destination
		$upload_path = './uploads/';
		$config['upload_path'] = $upload_path . $folder_name;
		//allowed file types. * means all types
		$config['allowed_types'] = $allowed_types;
		//allowed max file size. 0 means unlimited file size
		$config['max_size'] = '0';
		//max file name size
		$config['max_filename'] = '355';
		//whether file name should be encrypted or not
		$config['encrypt_name'] = FALSE;
		$config['file_name'] = $file_name;
		//store image info once uploaded
		$image_data = array();
		//check for errors
		$is_file_error = FALSE;
		//check if file was selected for upload
		if (!$_FILES) {
			$is_file_error = TRUE;
		}
		//if file was selected then proceed to upload
		if (!$is_file_error) {

			if (file_exists(FCPATH . $upload_path . $folder_name . "/" . $file_name . "." . $ext)) {
				unlink($upload_path . $folder_name . "/" . $file_name . "." . $ext);

			}
			//load the preferences
			$this->load->library('upload', $config);
			//check file successfully uploaded. 'image_name' is the name of the input
			if (!$this->upload->do_upload($field_name)) {
				//if file upload failed then catch the errors
				$is_file_error = TRUE;
			} else {
				//store the file info
				$image_data = $this->upload->data();

				if ($image_data) {
					return true;
				}

			}
		}

		return false;
	}

	//IMPORT FILE CSV //
	function import_CSV()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
			@set_time_limit(300);
		}

		if (!empty($_FILES['file_csv']['name'])) {
			$path = $_FILES['file_csv']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$pajak = str_replace(" ", "_", $this->input->post('uplPph'));
			$file_name = "fileCSV_" . $pajak;

			$kode_cabang = $this->session->userdata('kd_cabang');
			$nama_pajak = $this->input->post('uplPph');
			$bulan_pajak = $this->input->post('import_bulan_pajak');
			$tahun_pajak = $this->input->post('import_tahun_pajak');
			$tipe = $this->input->post('import_tipe');

			$pajak_header_id = $this->Pph21_mdl->get_pajak_header_id($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak);

			$st = 0;
			if ($ext == 'csv') {

				if ($upl = $this->_upload('file_csv', 'importCsv/pph21/', $file_name, 'csv', $ext)) {

					$handle = fopen("./uploads/importCsv/pph21/" . $file_name . "." . $ext, "r");
					//print_r($tipe); exit();
					$dataCsv = array();
					$row = 0;
					$totalData = 0;
					$masaPajakSalah = false;
					while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

						if ($row > 0) {

							$masa_pajak = $data[1];

							if ($tipe == "BULANAN") {

								$tanggalNya = "";
								$dataCsv[] = array(
									'PAJAK_HEADER_ID' => $pajak_header_id,
									'PAJAK_LINE_ID' => $data[0],
									'BULAN_PAJAK' => $bulan_pajak,
									'NAMA_PAJAK' => $nama_pajak, //tambahan baru nama pajak
									'MASA_PAJAK' => $this->Pph21_mdl->getMonth($data[1]),
									'TAHUN_PAJAK' => $data[2],
									'PEMBETULAN_KE' => $data[3],
									'NPWP' => $data[4],
									'NAMA_WP' => $data[5],
									'KODE_PAJAK' => $data[6],
									'DPP' => $data[7],
									'JUMLAH_POTONG' => $data[8],
									'KODE_NEGARA' => $data[9],
									'KODE_CABANG' => $kode_cabang,
									'TIPE_21' => $tipe
								);

							} else if ($tipe == "BULANAN FINAL") {

								$dataCsv[] = array(
									'PAJAK_HEADER_ID' => $pajak_header_id,
									'PAJAK_LINE_ID' => $data[0],
									'BULAN_PAJAK' => $bulan_pajak,
									'NAMA_PAJAK' => $nama_pajak,
									'MASA_PAJAK' => $this->Pph21_mdl->getMonth($data[1]),
									'TAHUN_PAJAK' => $data[2],
									'PEMBETULAN_KE' => $data[3],
									'NO_BUKTI_POTONG' => $data[4],
									'NPWP' => $data[5],
									'NIK' => $data[6],
									'NAMA_WP' => $data[7],
									'ALAMAT_WP' => $data[8],
									'KODE_PAJAK' => $data[9],
									'DPP' => $data[10],
									'TARIF' => $data[11],
									'JUMLAH_POTONG' => $data[12],
									'NPWP_PEMOTONG' => $data[13],
									'NAMA_PEMOTONG' => $data[14],
									// 'TGL_BUKTI_POTONG'=> $data[15],
									//'TGL_BUKTI_POTONG'=> "TO_DATE('".$data[15]."','yyyy-mm-dd hh24:mi:ss')",
									'KODE_CABANG' => $kode_cabang,
									'TIPE_21' => $tipe
								);
								$tanggalNya = ($data[15] != "") ? $this->tgl_db($data[15]) : "";

								//"TO_DATE('".$data['tgl_faktur']."','yyyy-mm-dd hh24:mi:ss')"
							} else {
								$tanggalNya = ($data[19] != "") ? $this->tgl_db($data[19]) : "";

								$dataCsv[] = array(
									'PAJAK_HEADER_ID' => $pajak_header_id,
									'PAJAK_LINE_ID' => $data[0],
									'BULAN_PAJAK' => $bulan_pajak,
									'NAMA_PAJAK' => $nama_pajak,
									'MASA_PAJAK' => $this->Pph21_mdl->getMonth($data[1]),
									'TAHUN_PAJAK' => $data[2],
									'PEMBETULAN_KE' => $data[3],
									'NO_BUKTI_POTONG' => $data[4],
									'NPWP' => $data[5],
									'NIK' => $data[6],
									'NAMA_WP' => $data[7],
									'ALAMAT_WP' => $data[8],
									'WPLUARNEGERI' => $data[9],
									'KODE_NEGARA' => $data[10],
									'KODE_PAJAK' => $data[11],
									'DPP' => $data[12],
									'DPP_BASE_AMOUNT' => $data[13],
									'TANPA_NPWP' => $data[14],
									'TARIF' => $data[15],
									'JUMLAH_POTONG' => $data[16],
									'NPWP_PEMOTONG' => $data[17],
									'NAMA_PEMOTONG' => $data[18],
									//'TGL_BUKTI_POTONG'=> $data[19],
									'KODE_CABANG' => $kode_cabang,
									'TIPE_21' => $tipe
								);

							}

							if ($masa_pajak != $bulan_pajak) {
								$masaPajakSalah = true;
							}
							$totalData++;
						}
						$row++;
					}

					if ($masaPajakSalah == false) {
						for ($i = 0; $i < $totalData; $i++) {

							$hasil = $this->Pph21_mdl->add_csv($dataCsv[$i], $tipe, $tanggalNya);
							if ($hasil) {
								$st = 1;
							} else {
								$st = 0;
							}
						}
					} else {
						$st = 4;
					}
					//print_r($dataCsv); exit();

				}
			} else {
				$st = 3;
			}
		} else {
			$st = 2;
		}

		echo $st;
	}


	// ====  URL DOKUMEN, QUERY DARI BADAR  ==== //
	function input_url_doc()
	{

		$this->template->set('title', 'Archive Link');
		$data['subtitle'] = "Archive Link";
		$data['activepage'] = "pph_21";

		$data['stand_alone'] = true;
		$group_pajak = get_daftar_pajak("PPH21");

		$list_pajak = array();

		foreach ($group_pajak as $key => $value) {
			$list_pajak[] = $value->JENIS_PAJAK;
		}

		$data['nama_pajak'] = $list_pajak;

		$this->template->load('template', 'administrator/archive_link', $data);

	}


	function show_pembetulan()
	{
		$this->template->set('title', 'Pembetulan');
		$data['subtitle'] = "Pembetulan";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/pembetulan', $data);
	}

//========================================PEMBETULAN ==========================
	function load_pembetulan()
	{
		$hasil = $this->Pph21_mdl->get_pembetulan();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'status_period' => $row['STATUS_PERIOD'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_cabang' => $row['NAMA_CABANG']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}


	function save_pembetulan()
	{
		$data = $this->Pph21_mdl->action_save_pembetulan();
		if ($data && ($data == "Close" || $data == "CLOSE")) {
			echo '1';
		} else if ($data && ($data == "Open" || $data == "OPEN")) {
			echo '2';
		} else if ($data && $data == "3") {
			echo '3';
		} else {
			echo "0";
		}
	}

	function delete_pembetulan()
	{
		$data = $this->Pph21_mdl->action_delete_pembetulan();
		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}

	//===== REKAP PPH ====//
	function show_rekap_pph()
	{
		$this->template->set('title', 'Rekap Setahun');
		$data['subtitle'] = "Rekap Setahun";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/rekap', $data);
	}

	// function cetak_report_pph_thn_xls()
	// {

	// 	$tahun 		= $_REQUEST['tahun'];
	// 	$pajak 		= $_REQUEST['pajak'];
	// 	$cabang 	= $_REQUEST['kd_cabang'];

	// 	if ($cabang != 'all'){
	// 		$kd_cabang = $cabang;
	// 	} else{
	// 		$kd_cabang = '';
	// 	}


	// 	$date	    = date("Y-m-d H:i:s");

	// 	include APPPATH.'third_party/PHPExcel.php';

	// 	// Panggil class PHPExcel nya
	// 	$excel = new PHPExcel();

	// 	// Settingan awal fil excel
	// 	$excel->getProperties()	->setCreator('SIMTAX')
	// 							->setLastModifiedBy('SIMTAX')
	// 							->setTitle("Cetak SPT Setahun")
	// 							->setSubject("Cetakan")
	// 							->setDescription("Cetak SPT Setahun")
	// 							->setKeywords("PPH");

	// 	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	// 	$style_col = array(
	// 	        'font' => array('bold' => true), // Set font nya jadi bold
	// 	   'alignment' => array(
	// 	  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	// 	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	// 	  ),
	// 		'borders' => array(
	// 			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	// 		  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	// 		 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	// 		   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	// 	  )
	// 	);

	// 	// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	// 	$style_row = array(
	// 	   'alignment' => array(
	// 	 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	// 	  ),
	// 	  'borders' => array(
	// 		  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	// 	    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	// 	   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	// 		 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	// 	  )
	// 	);

	// 	$style_row_jud = array(
	// 			'font' => array('bold' => true),
	// 	   'alignment' => array(
	// 	 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	// 	  ),
	// 	  'borders' => array(
	// 		  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	// 	    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	// 	   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	// 		 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	// 	  )
	// 	);

	// 	$style_row_no = array(
	// 	   'alignment' => array(
	// 	 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara vertical (middle)
	// 	  ),
	// 	  'borders' => array(
	// 		  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	// 	    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	// 	   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	// 		 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	// 	  )
	// 	);

	// 	$style_row_jumlah= array(
	// 			'font' => array('bold' => true)
	// 	);

	// 	//buat header cetakan
	// 	//logo IPC
	// 	$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PELABUHAN INDONESIA II (Persero)"); // Set kolom A1 dengan tulisan "DATA SISWA"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('A3', "REKAP SPT KOMPILASI ".strtoupper($pajak)); // Set kolom A1 dengan tulisan "DATA SISWA"
	// 	$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_row_jumlah);


	// 	// Buat header tabel nya pada baris ke 3
	// 	$excel->setActiveSheetIndex(0)->setCellValue('A5', "No."); // Set kolom A3 dengan tulisan "NO"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('B5', "Cabang/Unit"); // Set kolom B3 dengan tulisan "NIS"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('C5', "Januari"); // Set kolom C3 dengan tulisan "NAMA"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('D5', "Februari"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('E5', "Maret"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('F5', "April"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('G5', "Mei"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('H5', "Juni"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('I5', "Juli"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('J5', "Agustus"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('K5', "September"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('L5', "Oktober"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('M5', "November"); // Set kolom E3 dengan tulisan "ALAMAT"
	// 	$excel->setActiveSheetIndex(0)->setCellValue('N5', "Desember"); // Set kolom E3 dengan tulisan "ALAMAT"

	// 	$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_row_jud);
	// 	$excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_row_jud);


	// 	//get detail

	// 	if($pajak=="PPH PSL 21 BULANAN"){
	// 		$table = "SIMTAX_RPT_SPT_PPH21_BLN_T_V";
	// 	} elseif ($pajak=="PPH PSL 21 BULANAN FINAL") {
	// 		$table = "SIMTAX_RPT_SPT_PPH21_FINAL_T_V";
	// 	} else {
	// 		$table = "SIMTAX_RPT_SPT_PPH21_NFNL_T_V";
	// 	}

	// 	if ($kd_cabang ==""){
	// 		$whereCabang = "'000','010','020','030','040','050', '060','070','080','090','100','110','120'";
	// 	} else{
	// 		$whereCabang = "'".$kd_cabang."'";
	// 	}

	// 	//get detail

	// 		$queryExec	= "select skc.KODE_CABANG, skc.NAMA_CABANG, januari, februari, maret, april, mei, juni, juli, agustus, september, oktober, november, desember from simtax_kode_cabang skc
	// 							,(select rownum, wapu.* from (select kode_cabang, nama_cabang, nvl (pph,0) pph, bulan_pajak from ".$table."
	// 											where tahun_pajak = '".$tahun."' and upper(nama_pajak)='PPH PSL 21'
	// 											and pembetulan_ke = 0)
	// 											pivot (
	// 											max(pph)
	// 											for bulan_pajak in (1 as Januari,2 as Februari,3 as Maret,4 April,5 Mei,6 Juni,7 Juli,8 Agustus,9 September,10 Oktober,11 November,12 Desember)
	// 											) wapu
	// 							) rpt
	// 							where skc.kode_cabang = rpt.kode_cabang (+)
	// 							  and skc.kode_cabang in (".$whereCabang.")
	// 							order by skc.kode_cabang";
	// 	/* 	$queryExec	= " select rownum, wapu.* from (select kode_cabang, nama_cabang, pph, bulan_pajak from simtax_rpt_spt_pph_tahunan_v
	// 						where tahun_pajak = '".$tahun."' and upper(nama_pajak)='".strtoupper($pajak)."'
	// 						and pembetulan_ke = 0)
	// 						pivot (
	// 						max(pph)
	// 						for bulan_pajak in (1 as Januari,2 as Februari,3 as Maret,4 April,5 Mei,6 Juni,7 Juli,8 Agustus,9 September,10 Oktober,11 November,12 Desember)
	// 						) wapu
	// 						order by kode_cabang
	// 						"; */
	// 		//print_r ($queryExec ); exit();
	// 		$query 		= $this->db->query($queryExec);

	// 		//$no = 1; // Untuk penomoran tabel, di awal set dengan 1
	// 		$numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
	// 		$ttl_jan = 0;
	// 		$ttl_feb = 0;
	// 		$ttl_mar = 0;
	// 		$ttl_apr = 0;
	// 		$ttl_mei = 0;
	// 		$ttl_jun = 0;
	// 		$ttl_jul = 0;
	// 		$ttl_aug = 0;
	// 		$ttl_sep = 0;
	// 		$ttl_okt = 0;
	// 		$ttl_nov = 0;
	// 		$ttl_des = 0;
	// 		$i=0;
	// 		foreach($query->result_array() as $row)	{
	// 			$i++;
	// 			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['NAMA_CABANG']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['JANUARI']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['FEBRUARI']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['MARET']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['APRIL']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['MEI']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUNI']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['JULI']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row['AGUSTUS']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row['SEPTEMBER']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row['OKTOBER']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row['NOVEMBER']);
	// 			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row['DESEMBER']);

	// 			$excel->getActiveSheet()->getStyle('C'.$numrow.':N'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

	// 			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_no);
	// 			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
	// 			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);

	// 			$ttl_jan = $ttl_jan + $row['JANUARI'];
	// 			$ttl_feb = $ttl_feb + $row['FEBRUARI'];
	// 			$ttl_mar = $ttl_mar + $row['MARET'];
	// 			$ttl_apr = $ttl_apr + $row['APRIL'];
	// 			$ttl_mei = $ttl_mei + $row['MEI'];
	// 			$ttl_jun = $ttl_jun + $row['JUNI'];
	// 			$ttl_jul = $ttl_jul + $row['JULI'];
	// 			$ttl_aug = $ttl_aug + $row['AGUSTUS'];
	// 			$ttl_sep = $ttl_sep + $row['SEPTEMBER'];
	// 			$ttl_okt = $ttl_okt + $row['OKTOBER'];
	// 			$ttl_nov = $ttl_nov + $row['NOVEMBER'];
	// 			$ttl_des = $ttl_des + $row['DESEMBER'];

	// 			//$no++; // Tambah 1 setiap kali looping
	// 			$numrow++; // Tambah 1 setiap kali looping
	// 		}

	// 	//end get detail
	// 	//total
	// 	$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH DISETOR");
	// 	$excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $ttl_jan);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $ttl_feb);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $ttl_mar);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $ttl_apr);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $ttl_mei);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $ttl_jun);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $ttl_jul);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $ttl_aug);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $ttl_sep);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $ttl_okt);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $ttl_nov);
	// 	$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $ttl_des);

	// 	$excel->getActiveSheet()->getStyle('C'.$numrow.':N'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

	// 	$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
	// 	$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);

	// 	//setahun
	// 	$numrow = $numrow += 1; //$numrow++;
	// 	$ttl_all = $ttl_jan + $ttl_feb + $ttl_mar + $ttl_apr + $ttl_mei + $ttl_jun + $ttl_jul + $ttl_aug + $ttl_sep + $ttl_okt + $ttl_nov + $ttl_des;
	// 	$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "JUMLAH SETAHUN");
	// 	$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $ttl_all );
	// 	$excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row_jumlah);

	// 	$excel->getActiveSheet()->getStyle('C'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');


	// 	// Set width kolom
	// 	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
	// 	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
	// 	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
	// 	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
	// 	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom E
	// 	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20); // Set width kolom E


	// 	// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	// 	$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

	// 	// Set orientasi kertas jadi LANDSCAPE
	// 	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	// 	// Set judul file excel nya
	// 	$excel->getActiveSheet(0)->setTitle(strtoupper($pajak));
	// 	$excel->setActiveSheetIndex(0);

	// 	// Proses file excel
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 	header('Content-Disposition: attachment; filename="Rekap SPT Tahunan '.strtoupper($pajak).' Tahun '.$tahun.'.xls"'); // Set nama file excel nya
	// 	header('Cache-Control: max-age=0');
	// 	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	// 	$write->save('php://output');

	// }

	function cetak_report_pph_thn_xls3()
	{

		$tahun = $_REQUEST['tahun'];
		$pajak = $_REQUEST['pajak'];
		$subpajak = $_REQUEST['subpajak'];
		$cabang = $_REQUEST['kd_cabang'];
		$jud = "";
		//$header     = $this->Pph21_mdl->get_header_id_rekap($pajak, $tahun, $cabang);

		/*echo $header;
		die();*/

		if ($cabang != 'all') {
			$kd_cabang = $cabang;
		} else {
			$kd_cabang = '';
		}

		$date = date("Y-m-d H:i:s");

		include APPPATH . 'third_party/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();

		// Settingan awal fil excel
		$excel->getProperties()->setCreator('SIMTAX')
			->setLastModifiedBy('SIMTAX')
			->setTitle("Cetak SPT Setahun")
			->setSubject("Cetakan")
			->setDescription("Cetak SPT Setahun")
			->setKeywords("PPH");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);


		$style_row_head = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara horizontal (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_row_jud = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_bold = array(
			'font' => array('bold' => true)
		);

		$style_row_no = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$table = " simtax_rpt_spt_pph_tahunan_v ";
		$judul = $pajak;
		if ($subpajak == 'PPH23') {
			$table = " simtax_rpt_spt_pph23_tahunan_v ";
			$judul = "PPH PSL 23";
		} else if ($subpajak == 'PPH26') {
			$table = " simtax_rpt_spt_pph26_tahunan_v ";
			$judul = "PPH PSL 26";
		}

		//buat header cetakan
		//logo IPC
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PELABUHAN INDONESIA II (Persero)"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "REKAP SPT KOMPILASI " . strtoupper($judul) . " Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"


		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "No."); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Cabang/Unit"); // Set kolom B3 dengan tulisan "NIS"

		$excel->setActiveSheetIndex(0)->setCellValue('C5', "Januari"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D5', "Januari"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('E5', "Januari"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('F5', "Januari"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('C6', "SPT"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Februari"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Februari"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('I5', "Februari"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('J5', "Februari"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('G6', "SPT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('H6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('I6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('J6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('K5', "Maret"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('L5', "Maret"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('M5', "Maret"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('N5', "Maret"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('K6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('L6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('M6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('N6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('O5', "April"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('P5', "April"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Q5', "April"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('R5', "April"); // Set kolom

		$excel->setActiveSheetIndex(0)->setCellValue('O6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('P6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Q6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('R6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('S5', "Mei"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('T5', "Mei"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('U5', "Mei"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('V5', "Mei"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('S6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('T6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('U6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('V6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('W5', "Juni"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('X5', "Juni"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Y5', "Juni"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Z5', "Juni"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('W6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('X6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Y6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('Z6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AA5', "Juli"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AB5', "Juli"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AC5', "Juli"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AD5', "Juli"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('AA6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AB6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AC6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AD6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AE5', "Agustus"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AF5', "Agustus"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AG5', "Agustus"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AH5', "Agustus"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('AE6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AF6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AG6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AH6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AI5', "September"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AJ5', "September"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AK5', "September"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AL5', "September"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('AI6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AJ6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AK6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AL6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AM5', "Oktober"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AN5', "Oktober"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AO5', "Oktober"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AP5', "Oktober"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('AM6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AN6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AO6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AP6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AQ5', "November"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AR5', "November"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AS5', "November"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AT5', "November"); // Set kolom E3

		$excel->setActiveSheetIndex(0)->setCellValue('AQ6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AR6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AS6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AT6', "Tanggal Lapor"); // Set kolom E3


		$excel->setActiveSheetIndex(0)->setCellValue('AU5', "Desember"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AV5', "Desember"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AW5', "Desember"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AX5', "Desember"); // Set kolom E3 dengan tulisan "ALAMAT"

		$excel->setActiveSheetIndex(0)->setCellValue('AU6', "SPT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AV6', "Tanggal Setor"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AW6', "NTPN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('AX6', "Tanggal Lapor"); // Set kolom E3 dengan tulisan "ALAMAT"

		$excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('A5:A6'); // nomor
		$excel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('B5:B6'); // cabang
		$excel->getActiveSheet()->getStyle('C5:C6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('D5:D6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('E5:E6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('F5:F6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('C5:F5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('C5:F5');    //januari
		$excel->getActiveSheet()->getStyle('G5:G6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('H5:H6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('I5:I6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('J5:J6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('G5:J5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('G5:J5');    // feburari
		$excel->getActiveSheet()->getStyle('K5:K6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('L5:L6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('M5:M6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('N5:N6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('K5:N5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('K5:N5');    // maret
		$excel->getActiveSheet()->getStyle('O5:O6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('P5:P6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('Q5:Q6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('R5:R6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('O5:R5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('O5:R5'); // april
		$excel->getActiveSheet()->getStyle('S5:S6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('T5:T6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('U5:U6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('V5:V6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('S5:V5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('S5:V5'); // mei
		$excel->getActiveSheet()->getStyle('W5:W6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('X5:X6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('Y5:Y6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('Z5:Z6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('W5:Z5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('W5:Z5');    // juni
		$excel->getActiveSheet()->getStyle('AA5:AA6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AB5:AB6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AC5:AC6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AD5:AD6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AA5:AD5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AA5:AD5'); // juli
		$excel->getActiveSheet()->getStyle('AE5:AE6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AF5:AF6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AG5:AG6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AH5:AH6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AE5:AH5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AE5:AH5'); // agustus
		$excel->getActiveSheet()->getStyle('AI5:AI6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AJ5:AJ6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AK5:AK6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AL5:AL6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AI5:AL5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AI5:AL5'); // september
		$excel->getActiveSheet()->getStyle('AM5:AM6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AN5:AN6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AO5:AO6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AP5:AP6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AM5:AP5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AM5:AP5'); // oktober
		$excel->getActiveSheet()->getStyle('AQ5:AQ6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AR5:AR6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AS5:AS6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AT5:AT6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AQ5:AT5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AQ5:AT5'); // november
		$excel->getActiveSheet()->getStyle('AU5:AU6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AV5:AV6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AW5:AW6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AX5:AX6')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->getStyle('AU5:AX5')->applyFromArray($style_row_head);
		$excel->getActiveSheet()->mergeCells('AU5:AX5'); // desember
		//get detail

		if ($pajak == "PPH PSL 21 BULANAN") {
			$table = "SIMTAX_RPT_SPT_PPH21_BLN_T_V";
		} elseif ($pajak == "PPH PSL 21 BULANAN FINAL") {
			$table = "SIMTAX_RPT_SPT_PPH21_FINAL_T_V";
		} else {
			$table = "SIMTAX_RPT_SPT_PPH21_NFNL_T_V";
		}

		if ($kd_cabang == "") {
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else {
			$whereCabang = "'" . $kd_cabang . "'";
		}
		$queryExec = "SELECT skc.KODE_CABANG,
		skc.NAMA_CABANG,
		januari,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 1
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.januari is not null)
		tanggal_setor_januari,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 1
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.januari is not null)
		ntpn_januari,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 1
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.januari is not null)
		tanggal_lapor_januari,
		februari,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 2
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.februari is not null)
		tanggal_setor_februari,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 2
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.februari is not null)
		ntpn_februari,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 2
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.februari is not null)
		tanggal_lapor_februari,
		maret,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 3
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.maret is not null)
		tanggal_setor_maret,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 3
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.maret is not null)
		ntpn_maret,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 3
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.maret is not null)
		tanggal_lapor_maret,
		april,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 4
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.april is not null)
		tanggal_setor_april,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 4
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.april is not null)
		ntpn_april,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 4
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.april is not null)
		tanggal_lapor_april,
		mei,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 5
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.mei is not null)
		tanggal_setor_mei,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 5
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.mei is not null)
		ntpn_mei,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 5
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.mei is not null)
		tanggal_lapor_mei,
		juni,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 6
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juni is not null)
		tanggal_setor_juni,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 6
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juni is not null)
		ntpn_juni,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 6
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juni is not null)
		tanggal_lapor_juni,
		juli,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 7
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juli is not null)
		tanggal_setor_juli,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 7
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juli is not null)
		ntpn_juli,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 7
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.juli is not null)
		tanggal_lapor_juli,
		agustus,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 8
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.agustus is not null)
		tanggal_setor_agustus,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 8
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.agustus is not null)
		ntpn_agustus,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 8
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.agustus is not null)
		tanggal_lapor_agustus,
		september,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 9
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.september is not null)
		tanggal_setor_september,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 9
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.september is not null)
		ntpn_september,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 9
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.september is not null)
		tanggal_lapor_september,
		oktober,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 10
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.oktober is not null)
		tanggal_setor_oktober,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 10
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.oktober is not null)
		ntpn_oktober,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 10
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.oktober is not null)
		tanggal_lapor_oktober,
		november,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 11
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.november is not null)
		tanggal_setor_november,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 11
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.november is not null)
		ntpn_november,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 11
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.november is not null)
		tanggal_lapor_november,
		desember,
		(SELECT tanggal_setor
		FROM SIMTAX_NTPN
		WHERE     bulan = 12
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.desember is not null)
		tanggal_setor_desember,
		(SELECT ntpn
		FROM SIMTAX_NTPN
		WHERE     bulan = 12
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.desember is not null)
		ntpn_desember,
		(SELECT tanggal_lapor
		FROM SIMTAX_NTPN
		WHERE     bulan = 12
		AND tahun = '" . $tahun . "'
		AND UPPER (jenis_pajak) = '" . strtoupper($pajak) . "'
		AND kode_cabang = rpt.kode_cabang
		and rpt.desember is not null)
		tanggal_lapor_desember
		FROM simtax_kode_cabang skc,
		(SELECT ROWNUM, wapu.*
		FROM (SELECT kode_cabang,
		nama_cabang,
		pph,
		bulan_pajak
		FROM " . $table . "
		WHERE tahun_pajak = '" . $tahun . "'
		AND UPPER (nama_pajak) = 'PPH PSL 21'
		AND pembetulan_ke = 0) PIVOT (MAX(pph)
		FOR bulan_pajak
		IN (1 AS Januari,
		2 AS Februari,
		3 AS Maret,
		4 April,
		5 Mei,
		6 Juni,
		7 Juli,
		8 Agustus,
		9 September,
		10 Oktober,
		11 November,
		12 Desember)) wapu) rpt
		WHERE skc.kode_cabang = rpt.kode_cabang(+)
		AND skc.kode_cabang IN (" . $whereCabang . ")
		ORDER BY skc.kode_cabang ";

		$query = $this->db->query($queryExec);

		$numrow = 7;
		$numrowStart = 7;
		$ttl_jan = 0;
		$ttl_feb = 0;
		$ttl_mar = 0;
		$ttl_apr = 0;
		$ttl_mei = 0;
		$ttl_jun = 0;
		$ttl_jul = 0;
		$ttl_aug = 0;
		$ttl_sep = 0;
		$ttl_okt = 0;
		$ttl_nov = 0;
		$ttl_des = 0;
		$tgl_setor = 0;
		$ntpn = 0;
		$tgl_lpr = 0;
		$i = 0;

		foreach ($query->result_array() as $row) {
			$i++;
			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $i);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $row['NAMA_CABANG']);
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $row['JANUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow,
				$row['TANGGAL_SETOR_JANUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow,
				$row['NTPN_JANUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow,
				$row['TANGGAL_LAPOR_JANUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $row['FEBRUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow,
				$row['TANGGAL_SETOR_FEBRUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow,
				$row['NTPN_FEBRUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow,
				$row['TANGGAL_LAPOR_FEBRUARI']);
			$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $row['MARET']);
			$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow,
				$row['TANGGAL_SETOR_MARET']);
			$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow,
				$row['NTPN_MARET']);
			$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow,
				$row['TANGGAL_LAPOR_MARET']);
			$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $row['APRIL']);
			$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow,
				$row['TANGGAL_SETOR_APRIL']);
			$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow,
				$row['NTPN_APRIL']);
			$excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow,
				$row['TANGGAL_LAPOR_APRIL']);
			$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $row['MEI']);
			$excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow,
				$row['TANGGAL_SETOR_MEI']);
			$excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow,
				$row['NTPN_MEI']);
			$excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow,
				$row['TANGGAL_LAPOR_MEI']);
			$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $row['JUNI']);
			$excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow,
				$row['TANGGAL_SETOR_JUNI']);
			$excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow,
				$row['NTPN_JUNI']);
			$excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow,
				$row['TANGGAL_LAPOR_JUNI']);
			$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $row['JULI']);
			$excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow,
				$row['TANGGAL_SETOR_JULI']);
			$excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow,
				$row['NTPN_JULI']);
			$excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow,
				$row['TANGGAL_LAPOR_JULI']);
			$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, $row['AGUSTUS']);
			$excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow,
				$row['TANGGAL_SETOR_AGUSTUS']);
			$excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow,
				$row['NTPN_AGUSTUS']);
			$excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow,
				$row['TANGGAL_LAPOR_AGUSTUS']);
			$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, $row['SEPTEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AJ' . $numrow,
				$row['TANGGAL_SETOR_SEPTEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AK' . $numrow,
				$row['NTPN_SEPTEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AL' . $numrow,
				$row['TANGGAL_LAPOR_SEPTEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AM' . $numrow, $row['OKTOBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AN' . $numrow,
				$row['TANGGAL_SETOR_OKTOBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AO' . $numrow,
				$row['NTPN_OKTOBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AP' . $numrow,
				$row['TANGGAL_LAPOR_OKTOBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AQ' . $numrow, $row['NOVEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AR' . $numrow,
				$row['TANGGAL_SETOR_NOVEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AS' . $numrow,
				$row['NTPN_NOVEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AT' . $numrow,
				$row['TANGGAL_LAPOR_NOVEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AU' . $numrow, $row['DESEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AV' . $numrow,
				$row['TANGGAL_SETOR_DESEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AW' . $numrow,
				$row['NTPN_DESEMBER']);
			$excel->setActiveSheetIndex(0)->setCellValue('AX' . $numrow,
				$row['TANGGAL_LAPOR_DESEMBER']);


			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_no);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AI' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AJ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AK' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AL' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AM' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AN' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('AO' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AP' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AQ' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AR' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AS' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AT' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AU' . $numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('AV' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AW' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AX' . $numrow)->applyFromArray($style_row);

			$ttl_jan = $ttl_jan + $row['JANUARI'];
			$ttl_feb = $ttl_feb + $row['FEBRUARI'];
			$ttl_mar = $ttl_mar + $row['MARET'];
			$ttl_apr = $ttl_apr + $row['APRIL'];
			$ttl_mei = $ttl_mei + $row['MEI'];
			$ttl_jun = $ttl_jun + $row['JUNI'];
			$ttl_jul = $ttl_jul + $row['JULI'];
			$ttl_aug = $ttl_aug + $row['AGUSTUS'];
			$ttl_sep = $ttl_sep + $row['SEPTEMBER'];
			$ttl_okt = $ttl_okt + $row['OKTOBER'];
			$ttl_nov = $ttl_nov + $row['NOVEMBER'];
			$ttl_des = $ttl_des + $row['DESEMBER'];
			/*$tgl_setor = $tgl_setor + $row['TGLSETOR'];
				$ntpn = $ntpn + $row['NTPN'];
				$tgl_lpr = $tgl_lpr + $row['TGLLAPOR'];*/

			$numrow++;
		}


		//total
		$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "JUMLAH DISETOR");
		$excel->getActiveSheet()->mergeCells('A' . $numrow . ':B' . $numrow);
		$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $ttl_jan);
		$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $ttl_feb);
		$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $ttl_mar);
		$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $ttl_apr);
		$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $ttl_mei);
		$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $ttl_jun);
		$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $ttl_jul);
		$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, $ttl_aug);
		$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, $ttl_sep);
		$excel->setActiveSheetIndex(0)->setCellValue('AM' . $numrow, $ttl_okt);
		$excel->setActiveSheetIndex(0)->setCellValue('AQ' . $numrow, $ttl_nov);
		$excel->setActiveSheetIndex(0)->setCellValue('AU' . $numrow, $ttl_des);


		$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row_jud);

		$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row_jud);

		$excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row_jud);

		$excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AI' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AJ' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AK' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AL' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AM' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AN' . $numrow)->applyFromArray($style_row_jud);

		$excel->getActiveSheet()->getStyle('AO' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AP' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AQ' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AR' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AS' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AT' . $numrow)->applyFromArray($style_row_jud);

		$excel->getActiveSheet()->getStyle('AU' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AV' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AW' . $numrow)->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->getStyle('AX' . $numrow)->applyFromArray($style_row_jud);


		//setahun
		$numrow = $numrow += 1;
		$ttl_all = $ttl_jan + $ttl_feb + $ttl_mar + $ttl_apr + $ttl_mei + $ttl_jun + $ttl_jul + $ttl_aug + $ttl_sep + $ttl_okt + $ttl_nov + $ttl_des;
		$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "JUMLAH SETAHUN");
		$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $ttl_all);
		$excel->getActiveSheet()->getStyle('B' . $numrow . ':C' . $numrow)->applyFromArray($style_bold);


		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(25); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('U')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('V')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('W')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('X')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(25); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(25); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AU')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AV')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AW')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('AX')->setWidth(20); // Set width kolom E

		$excel->getActiveSheet()->getStyle('C' . $numrowStart . ':Q' . $numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle(strtoupper($jud) . " " . $tahun);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rekap SPT Tahunan ' . strtoupper($judul) . ' Tahun ' . $tahun . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');

	}

	function cetak_report_pph_thn_xls()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
			@set_time_limit(300);
		}

		$tahun = $_REQUEST['tahun'];
		$pajak = $_REQUEST['pajak'];
		$subpajak = $_REQUEST['subpajak'];
		$cabang = $_REQUEST['kd_cabang'];
		$header = $this->Pph21_mdl->get_header_id_rekap($pajak, $tahun, $cabang);

		/*echo $header;
		die();*/

		if ($cabang != 'all') {
			$kd_cabang = $cabang;
		} else {
			$kd_cabang = '';
		}

		$date = date("Y-m-d H:i:s");

		include APPPATH . 'third_party/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();

		// Settingan awal fil excel
		$excel->getProperties()->setCreator('SIMTAX')
			->setLastModifiedBy('SIMTAX')
			->setTitle("Cetak SPT Setahun")
			->setSubject("Cetakan")
			->setDescription("Cetak SPT Setahun")
			->setKeywords("PPH");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);


		$style_row_head = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara horizontal (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_row_jud = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_bold = array(
			'font' => array('bold' => true)
		);

		$style_row_no = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_row2 = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (middle)
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		if ($pajak == "PPH PSL 21 BULANAN") {
			$table = "SIMTAX_RPT_SPT_PPH21_BLN_T_V";
		} elseif ($pajak == "PPH PSL 21 BULANAN FINAL") {
			$table = "SIMTAX_RPT_SPT_PPH21_FINAL_T_V";
		} else {
			$table = "SIMTAX_RPT_SPT_PPH21_NFNL_T_V";
		}

		//buat header cetakan
		//logo IPC
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "REKAP SPT KOMPILASI " . strtoupper($pajak) . " Tahun " . $tahun);


		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "No.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Cabang/Unit");

		$excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('A5:A6'); // nomor
		$excel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('B5:B6'); // cabang

		$loop = horizontal_loop_excel("C", 60);

		$j = 0;
		$x = 1;
		$month = 1;
		$string = "";
		$arrString = array("SPT", "Tanggal Setor", "NTPN", "Tanggal Lapor", "Nominal");
		foreach ($loop as $key => $value) {

			$nama_bulan = get_masa_pajak($month, "id", true);
			$excel->setActiveSheetIndex(0)->setCellValue($value . '6', $arrString[$j]);
			$excel->getActiveSheet()->getStyle($value . '5:' . $value . '6')->applyFromArray($style_row_head);

			if ($x % 5) {
				$excel->setActiveSheetIndex(0)->setCellValue($value . '5', $nama_bulan);
				$j++;
			} else {
				$excel->setActiveSheetIndex(0)->setCellValue($value . '5', $nama_bulan);
				$j = 0;
				$month++;
			}
			$x++;
		}

		$x = 1;
		foreach ($loop as $key => $value) {

			$loop2 = horizontal_loop_excel($value, 5);
			$next = end($loop2);

			if ($x == 1) {
				$excel->getActiveSheet()->mergeCells($value . '5:' . $next . '5');
			}

			if ($x % 5) {
			} else {
				$loop2 = horizontal_loop_excel($value++, 6);
				$next = end($loop2);
				$excel->getActiveSheet()->mergeCells($value . '5:' . $next . '5');
			}

			$x++;
		}

		if ($kd_cabang == "") {
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else {
			$whereCabang = "'" . $kd_cabang . "'";
		}

		$queryExec = "SELECT skc.KODE_CABANG,
		skc.NAMA_CABANG
		FROM simtax_kode_cabang skc
		WHERE skc.kode_cabang IN (" . $whereCabang . ")
		and skc.aktif = 'Y'
		ORDER BY skc.kode_cabang";

		$query = $this->db->query($queryExec);

		$numrow = 7;
		$numrowStart = 7;
		$ttl_jan = 0;
		$ttl_feb = 0;
		$ttl_mar = 0;
		$ttl_apr = 0;
		$ttl_mei = 0;
		$ttl_jun = 0;
		$ttl_jul = 0;
		$ttl_aug = 0;
		$ttl_sep = 0;
		$ttl_okt = 0;
		$ttl_nov = 0;
		$ttl_des = 0;
		$tgl_setor = 0;
		$ntpn = 0;
		$tgl_lpr = 0;
		$i = 0;

		$dataSPT = array(
			"BULAN" => array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"),
			"SPT" => array(1231, 52423, 213, 4584, 222215, 1312, 112312, 0, 0, 0, 0, 0),
			"NTPN" => array("AFASD", "SDGSDT", "GDJFHDF", "SDBVDC", "CAASC", "TJGF", "DUYTD", "VSDCSD", "", "", "", ""),
		);

		$querySPT = "SELECT
		bulan_pajak
		,spt.pph,spt.nama_pajak,spt.kode_cabang,stpn.tanggal_setor,stpn.ntpn,stpn.tanggal_lapor,stpn.nominal
		FROM 
		" . $table . " spt
		,(select tanggal_setor,ntpn,tanggal_lapor,nominal,tahun,bulan,kode_cabang from simtax_ntpn
		where jenis_pajak = '" . $pajak . "'
		and tahun='" . $tahun . "'
		and kode_cabang IN
		('000',
		'010',
		'020',
		'030',
		'040',
		'050',
		'060',
		'070',
		'080',
		'090',
		'100',
		'110',
		'120')) stpn
		WHERE 
		--spt.nama_pajak = 'PPH PSL 21'
		SPT.TAHUN_PAJAK='" . $tahun . "'
		--and spt.pph is not null
		and spt.bulan_pajak = stpn.bulan(+)
		and spt.kode_cabang = stpn.kode_cabang(+)
		order by bulan_pajak";

		$resSPT = $this->db->query($querySPT)->result_array();
		$totSPT = count($resSPT);

		$j = 0;
		$dataBulan = array();
		$dataCabang = array();
		$dataNew = array();
		$last_kode_cabang = "";
		for ($i = 0; $i < $totSPT; $i++) {
			$nama_bulan = strtoupper(get_masa_pajak($resSPT[$i]['BULAN_PAJAK'], "id", true));
			$j = $resSPT[$i]['BULAN_PAJAK'];
			$kode_cabang = $resSPT[$i]['KODE_CABANG'];

			if ($kode_cabang != $last_kode_cabang) {
				$j++;
				$j = $resSPT[$i]['BULAN_PAJAK'];
			}

			$dataNew[$kode_cabang][$j][] = $resSPT[$i];
			$last_kode_cabang = $kode_cabang;

		}

		$i = 0;
		$spt_pph = 0;
		$tanggal_lapor = "";
		$ntpn = "";
		$tanggal_setor = "";
		$nominal = 0;
		$nomor = 1;
		$diee = false;
		$row1 = $query->row_array();
		$lastCabang = $row1['KODE_CABANG'];

		$arrOfFirst = array("C", "H", "M", "R", "W", "AB", "AG", "AL", "AQ", "AV", "BA", "BF");
		$lastPlus5 = end($arrOfFirst);
		for ($i = 0; $i < 4; $i++) {
			$lastPlus5++;
		}

		foreach ($query->result_array() as $row) {

			$cabang = $row['KODE_CABANG'];
			$merge = 0;

			if (array_key_exists($cabang, $dataNew)) {

				if ($cabang != $lastCabang) {
					$uniquePush = array_unique($pushNum);
					$numrow = max($uniquePush);
					$numrow++;
				} else {
					unset($pushNum);
				}

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $nomor);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $row['NAMA_CABANG']);
				$loop = horizontal_loop_excel("C", 60);
				$x = 1;
				$month = 1;
				$z = 0;
				$numrowNow = 0;
				$lastVal = "";
				$newMonth = false;
				$numrowMain = $numrow;
				foreach ($loop as $key => $value) {

					if ($x == 5) {
						$lastVal = $value;
					}

					$dataMonth = $dataNew[$cabang];
					unset($counts);
					if (array_key_exists($month, $dataMonth)) {

						foreach ($dataMonth as $key => $count) {
							$counts[] = count($count);
						}
						$maxDataNtpn = max($counts);

						$totDataMonth = count($dataMonth[$month]);
						if ($totDataMonth > 0) {
							for ($i = 0; $i < $totDataMonth; $i++) {
								$spt_data[1][] = $dataMonth[$month][$i]['PPH'];
								$spt_data[2][] = $dataMonth[$month][$i]['TANGGAL_LAPOR'];
								$spt_data[3][] = $dataMonth[$month][$i]['NTPN'];
								$spt_data[4][] = $dataMonth[$month][$i]['TANGGAL_SETOR'];
								$spt_data[5][] = ($dataMonth[$month][$i]['NOMINAL']) ? $dataMonth[$month][$i]['NOMINAL'] : "";
							}
						} else {
							$spt_data[1] = $dataMonth[$month][0]['PPH'];
							$spt_data[2] = $dataMonth[$month][0]['TANGGAL_LAPOR'];
							$spt_data[3] = $dataMonth[$month][0]['NTPN'];
							$spt_data[4] = $dataMonth[$month][0]['TANGGAL_SETOR'];
							$spt_data[5] = ($dataMonth[$month][0]['NOMINAL']) ? $dataMonth[$month][0]['NOMINAL'] : "";
						}
					} else {
						$spt_data[1] = "";
						$spt_data[2] = "";
						$spt_data[3] = "";
						$spt_data[4] = "";
						$spt_data[5] = "";
					}


					if ($x % 5) {
						$z++;
						if (is_array($spt_data[$z])) {
							$numrowNow = $numrow;
							for ($i = 0; $i < $totDataMonth; $i++) {
								//if($totDataMonth > 1){
								$merge = $numrowMain + $maxDataNtpn - 1;
								if (in_array($value, $arrOfFirst) && $i == 0) {
									// echo "<b>Merge ".$value.$numrowMain.":".$value.$merge."</b><br>";
									$excel->getActiveSheet()->mergeCells("A" . $numrowMain . ':' . "A" . $merge);
									$excel->getActiveSheet()->mergeCells("B" . $numrowMain . ':' . "B" . $merge);
									$excel->getActiveSheet()->mergeCells($value . $numrowMain . ':' . $value . $merge);
									$excel->getActiveSheet()->getStyle("A" . $numrowMain . ':' . "A" . $merge)->applyFromArray($style_row_no);
									$excel->getActiveSheet()->getStyle($value . $numrowMain . ':' . $lastPlus5 . $merge)->applyFromArray($style_row_no);
								}
								//}
								if ($i == 0) {
									$excel->getActiveSheet()->getStyle($value . $numrowMain)->applyFromArray($style_row_no);
									$numrow = $numrowMain;
								} else {
									$numrow++;
									$excel->getActiveSheet()->getStyle($value . $numrow)->applyFromArray($style_row_no);
									$pushNum[] = $numrow;
								}

								if (in_array($value, $arrOfFirst)) {
									if ($i > 0) {
										$spt_data[$z][$i] = "";
									}
								}
								$excel->setActiveSheetIndex(0)->setCellValue($value . $numrow, $spt_data[$z][$i]);
								// echo $value.$numrow." - ".$spt_data[$z][$i]."<br>";
								$j++;
							}
							$newMonth = false;
						} else {
							$pushNum[] = $numrow;
							$excel->setActiveSheetIndex(0)->setCellValue($value . $numrow, $spt_data[$z]);
						}
					} else {
						if (is_array($spt_data[$z])) {
							$numrowNow = $numrow;
							$excel->getActiveSheet()->getStyle($value . $numrowMain . ':' . $lastPlus5 . $merge)->applyFromArray($style_row_no);
							for ($i = 0; $i < $totDataMonth; $i++) {
								if ($i == 0) {
									$numrow = $numrowMain;
								} else {
									$numrow++;
									$pushNum[] = $numrow;
								}
								$excel->setActiveSheetIndex(0)->setCellValue($value . $numrow, $spt_data[5][$i]);
								// echo $value.$numrow." - ".$spt_data[5][$i]."<br>";
								$j++;
							}
						} else {
							$pushNum[] = $numrow;
							$excel->setActiveSheetIndex(0)->setCellValue($value . $numrow, $spt_data[5]);
						}
						$newMonth = true;
						$lastVal = $value;
						$z = 0;
						$month++;
					}
					unset($spt_data);
					$x++;
				}

			}

			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_no);
			$loop = horizontal_loop_excel("B", 61);

			foreach ($loop as $key => $value) {
				$excel->getActiveSheet()->getStyle($value . $numrow)->applyFromArray($style_row);
			}

			$lastCabang = $cabang;

			$nomor++;
			$numrow++;
		}
		$last_no = $numrow - 1;

		$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "JUMLAH DISETOR");
		$excel->getActiveSheet()->mergeCells('A' . $numrow . ':B' . $numrow);
		foreach ($arrOfFirst as $key => $value) {
			$excel->setActiveSheetIndex(0)->setCellValue($value . $numrow, "=SUM(" . $value . "7:" . $value . $last_no . ")");
		}


		$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_no);


		$i = 0;
		$strTotal = "";

		foreach ($arrOfFirst as $key => $value) {

			if ($i > 0) {
				$strTotal .= "+" . $value . $numrow;
			} else {
				$strTotal .= $value . $numrow;
			}
			$i++;
		}

		$numrow = $numrow += 1;

		$loop = horizontal_loop_excel("A", 62);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value . "6:" . $value . $numrow)->applyFromArray($style_row);

			if (in_array($value, $arrOfFirst)) {
				$excel->getActiveSheet()->getStyle($value . "7:" . $value . $numrow)->applyFromArray($style_row2);
			}
		}
		$loop = horizontal_loop_excel("A", 2);
		$numrowmin1 = $numrow - 1;
		$excel->getActiveSheet()->mergeCells('A' . $numrow . ':B' . $numrow);

		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value . $numrowmin1)->applyFromArray($style_row_jud);
			$excel->getActiveSheet()->getStyle($value . $numrow)->applyFromArray($style_row_jud);
		}

		$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "JUMLAH SETAHUN");

		$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, "=(" . $strTotal . ")");
		$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_bold);

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$loop = horizontal_loop_excel("B", 62);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getColumnDimension($value)->setWidth(20); // Set width kolom B
		}

		foreach ($arrOfFirst as $key => $value) {

			for ($i = 7; $i <= $numrow; $i++) {
				$excel->getActiveSheet()->getStyle($value . $i)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			}
			$i++;
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle(strtoupper($pajak));
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rekap SPT Tahunan ' . strtoupper($pajak) . ' Tahun ' . $tahun . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');

	}

	//=================================================================================//


	function load_master_pajak()
	{
		$hasil = $this->Pph21_mdl->get_master_pajak();
		$query = $hasil['query'];
		$result = "";
		foreach ($query->result_array() as $row) {
			$result .= "<option value='" . $row['JENIS_PAJAK'] . "' data-name='" . $row['DISPLAY'] . "' >" . $row['DISPLAY'] . "</option>";
		}
		echo $result;
		$query->free_result();

	}

	//================================================= VIEW STATUS ============================

	function show_view()
	{
		$this->template->set('title', 'View PPH');
		$data['subtitle'] = "View Status";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/view', $data);
	}

	function load_view()
	{
		$hasil = $this->Pph21_mdl->get_view();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'creation_date' => $row['CREATION_DATE'],
					'user_name' => $row['USER_NAME'],
					'status' => $row['STATUS'],
					'tgl_submit_sup' => $row['TGL_SUBMIT_SUP'],
					'tgl_approve_sup' => $row['TGL_APPROVE_SUP'],
					'tgl_approve_pusat' => $row['TGL_APPROVE_PUSAT'],
					'pembetulan_ke' => $row['PEMBETULAN_KE'],
					'ttl_jml_potong' => number_format($row['TTL_JML_POTONG'], 2, '.', ',')
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);

	}


	function load_rekonsiliasi_detail()
	{
		$hasil = $this->Pph21_mdl->get_rekonsiliasi_detail();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox" . $row['RNUM'] . "' class='checklist' type='checkbox' " . $checked . " disabled data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['VENDOR_NAME'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ADDRESS_LINE1'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'organization_id' => $row['ORGANIZATION_ID']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_detail_summary_rekonsiliasi1()
	{
		$hasil = $this->Pph21_mdl->get_detail_summary_rekonsiliasi(1);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-success'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_detail_summary_rekonsiliasi0()
	{
		$hasil = $this->Pph21_mdl->get_detail_summary_rekonsiliasi(0);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-danger'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_detail_tot_rekonsiliasi()
	{
		$data = $this->Pph21_mdl->action_detail_tot_rekonsiliasi();
		if ($data) {
			if ($data->num_rows() > 0) {
				$row = $data->row();
				$result['total'] = number_format($row->JML_POTONG, 2, '.', ',');
			} else {
				$result['total'] = number_format(0, 2, '.', ',');
			}
			$result['isSuccess'] = 1;
		} else {
			$result['isSuccess'] = 0;
		}
		echo json_encode($result);
		$data->free_result();
	}

	function load_history()
	{
		$hasil = $this->Pph21_mdl->get_history();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'action_code' => $row['ACTION_CODE'],
					'action_date' => $row['ACTION_DATE'],
					'user_name' => $row['USER_NAME'],
					'catatan' => $row['CATATAN']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	//===================================== KOMPILASI  ==========================
	function show_compilasi()
	{
		$this->template->set('title', 'Kompilasi');
		$data['subtitle'] = "Kompilasi PPh 21";
		$data['activepage'] = "pph_21";
		$this->template->load('template', 'pph21/compilasi', $data);
	}

	function load_kompilasi()
	{
		$hasil = $this->Pph21_mdl->get_kompilasi();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox" . $row['RNUM'] . "' disabled class='checklist' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['NAMA_WP'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ALAMAT_WP'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'tipe_21' => $row['TIPE_21'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_cabang' => $row['NAMA_CABANG']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}


	function load_kompilasi1()
	{
		$hasil = $this->Pph21_mdl->get_kompilasi1();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox" . $row['RNUM'] . "' disabled class='checklist' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['NAMA_WP'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ALAMAT_WP'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'tipe_21' => $row['TIPE_21'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_cabang' => $row['NAMA_CABANG']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}


	function load_kompilasi2()
	{
		$hasil = $this->Pph21_mdl->get_kompilasi2();
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$checked = ($row['IS_CHEKLIST'] == 1) ? "checked" : "";
				$checkbox = "<div class='checkbox checkbox-danger' style='height:10px'>
				<input id='checkbox" . $row['RNUM'] . "' disabled class='checklist' type='checkbox' " . $checked . " data-toggle='confirmation-singleton' data-singleton='true' data-id='" . $row['PAJAK_LINE_ID'] . "'>
				<label for='checkbox" . $row['RNUM'] . "'>&nbsp;</label>
				</div>";
				$result['data'][] = array(
					'checkbox' => $checkbox,
					'no' => $row['RNUM'],
					'pajak_header_id' => $row['PAJAK_HEADER_ID'],
					'pajak_line_id' => $row['PAJAK_LINE_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'nama_wp' => $row['NAMA_WP'],
					'npwp' => $row['NPWP1'],
					'alamat_wp' => $row['ALAMAT_WP'],
					'kode_pajak' => $row['KODE_PAJAK'],
					'dpp' => number_format($row['DPP'], 2, '.', ','),
					'tarif' => $row['TARIF'],
					'tipe_21' => $row['TIPE_21'],
					'jumlah_potong' => number_format($row['JUMLAH_POTONG_21'], 2, '.', ','),
					'uraian' => $row['URAIAN'],
					'new_kode_pajak' => $row['NEW_KODE_PAJAK'],
					'new_dpp' => number_format($row['NEW_DPP'], 2, '.', ','),
					'new_tarif' => $row['NEW_TARIF'],
					'new_jumlah_potong' => number_format($row['NEW_JUMLAH_POTONG'], 2, '.', ','),
					'invoice_num' => $row['INVOICE_NUM'],
					'invoice_line_num' => $row['INVOICE_LINE_NUM'],
					'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
					'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
					'vendor_id' => $row['VENDOR_ID'],
					'no_bukti_potong' => $row['NO_BUKTI_POTONG'],
					'gl_account' => $row['GL_ACCOUNT'],
					'akun_pajak' => $row['AKUN_PAJAK'],
					'nama_pajak' => $row['NAMA_PAJAK'],
					'bulan_pajak' => $row['BULAN_PAJAK'],
					'tahun_pajak' => $row['TAHUN_PAJAK'],
					'masa_pajak' => $row['MASA_PAJAK'],
					'organization_id' => $row['ORGANIZATION_ID'],
					'kode_cabang' => $row['KODE_CABANG'],
					'nama_cabang' => $row['NAMA_CABANG']
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}


	function load_summary_kompilasi1()
	{
		$hasil = $this->Pph21_mdl->get_summary_kompilasi(1);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'nama_cabang' => $row['NAMA_CABANG'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-success'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_summary_kompilasi0()
	{
		$hasil = $this->Pph21_mdl->get_summary_kompilasi(0);
		$rowCount = $hasil['jmlRow'];
		$query = $hasil['query'];
		if ($rowCount > 0) {
			$ii = 0;
			foreach ($query->result_array() as $row) {
				$ii++;
				$result['data'][] = array(
					'no' => $row['RNUM'],
					'nama_cabang' => $row['NAMA_CABANG'],
					'pengelompokan' => $row['PENGELOMPOKAN'],
					'jml_potong' => "<h5><span class='label label-danger'>" . number_format($row['JML_POTONG'], 2, '.', ',') . "</span></h5>"
				);
			}

			$query->free_result();

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;

		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}
		echo json_encode($result);
	}

	function load_tot_kompilasi()
	{
		$data1 = $this->Pph21_mdl->action_tot_kompilasi(1);
		$data0 = $this->Pph21_mdl->action_tot_kompilasi(0);
		if ($data1 && $data0) {
			if ($data1) {
				if ($data1->num_rows() > 0) {
					$row = $data1->row();
					$result['total1'] = $row->JML_POTONG;
				} else {
					$result['total1'] = 0;
				}
			}

			if ($data0) {
				if ($data0->num_rows() > 0) {
					$row = $data0->row();
					$result['total0'] = $row->JML_POTONG;
				} else {
					$result['total0'] = 0;
				}
			}

			$result['isSuccess'] = 1;
		} else {
			$result['isSuccess'] = 0;
		}
		echo json_encode($result);
		$data1->free_result();
		$data0->free_result();
	}

	//KOMPILASI BARU//

	function load_summary_kompilasi()
	{
		$bulan = $_POST['_searchBulan'];
		$tahun = $_POST['_searchTahun'];
		$pajak = 'PPH PSL 21';
		$pembetulan = $_POST['_searchPembetulan'];
		$cabang = $_POST['_searchCabang'];

		$hasil_currency = $this->Pph21_mdl->get_currency_kompilasi($bulan, $tahun, $pajak, $pembetulan, $cabang);
		$rowCount = $hasil_currency['jmlRow'];
		$queryC = $hasil_currency['query'];
		$ii = 0;

		if ($rowCount > 0) {
			foreach ($queryC->result_array() as $rowC) {
				$kdcabang = $rowC['KODE_CABANG'];
				$dibayarkan = 0;
				$tidakDibayarkan = 0;
				$ii++;
				$hasil = $this->Pph21_mdl->get_summary_rekonsiliasi($bulan, $tahun, $pajak, $pembetulan, $kdcabang);
				$query1 = $hasil['queryExec'];

				foreach ($query1->result_array() as $row) {
					if ($row['PENGELOMPOKAN'] == "Dilaporkan") {
						$dibayarkan = $row['JML_POTONG'];
					} else {
						$tidakDibayarkan = $row['JML_POTONG'];
					}
				}

				$saldoAkhir = $rowC['SALDO_AWAL'] + ($rowC['MUTASI_DEBIT'] - $rowC['MUTASI_KREDIT']);
				$selisih = $saldoAkhir - $dibayarkan;

				$result['data'][] = array(
					'no' => $ii,
					'cabang' => $rowC['NAMA_CABANG'],
					'saldo_awal' => number_format($rowC['SALDO_AWAL'], 2, '.', ','),

					'mutasi_debet' => number_format($rowC['MUTASI_DEBIT'], 2, '.', ','),

					'mutasi_kredit' => number_format($rowC['MUTASI_KREDIT'], 2, '.', ','),

					'saldo_akhir' => number_format($saldoAkhir, 2, '.', ','),

					'jumlah_dibayarkan' => number_format($dibayarkan, 2, '.', ','),

					'tidak_dilaporkan' => number_format($tidakDibayarkan, 2, '.', ','),
					'selisih' => number_format($selisih, 2, '.', ',')
				);


			}

			$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
			$result['recordsTotal'] = $rowCount;
			$result['recordsFiltered'] = $rowCount;
		} else {
			$result['data'] = "";
			$result['draw'] = "";
			$result['recordsTotal'] = 0;
			$result['recordsFiltered'] = 0;
		}

		echo json_encode($result);
	}


	function load_detail_summary_kompilasi()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_compilasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}

		$result['data'] = "";
		$result['draw'] = "";
		$result['recordsTotal'] = 0;
		$result['recordsFiltered'] = 0;

		if ($permission === true) {

			$hasil = $this->Pph21_mdl->get_detail_summary_kompilasi();
			$rowCount = $hasil['jmlRow'];
			$query = $hasil['query'];
			$totselisih = 0;
			if ($rowCount > 0) {
				$ii = 0;
				foreach ($query->result_array() as $row) {
					$ii++;
					$totselisih = $totselisih + $row['JUMLAH_POTONG'];
					$result['data'][] = array(
						'no' => $row['RNUM'],
						'nama_cabang' => $row['NAMA_CABANG'],
						'vendor_name' => $row['VENDOR_NAME'],
						'npwp1' => $row['NPWP1'],
						'address_line1' => $row['ADDRESS_LINE1'],
						'no_faktur_pajak' => $row['NO_FAKTUR_PAJAK'],
						'tanggal_faktur_pajak' => $row['TANGGAL_FAKTUR_PAJAK'],
						'dpp' => number_format($row['DPP'], 2, '.', ','),
						'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ','),
						'keterangan' => $row['KETERANGAN'],
						'totselisih' => number_format($totselisih, 2, '.', ',')
					);
				}

				$query->free_result();

				$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
				$result['recordsTotal'] = $rowCount;
				$result['recordsFiltered'] = $rowCount;

			} else {
				$result['data'] = "";
				$result['draw'] = "";
				$result['recordsTotal'] = 0;
				$result['recordsFiltered'] = 0;
			}
		}

		echo json_encode($result);
		$query->free_result();
	}


	function load_detail_summary_kompilasi_cabang()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_compilasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}

		$result['data'] = "";
		$result['draw'] = "";
		$result['recordsTotal'] = 0;
		$result['recordsFiltered'] = 0;

		if ($permission === true) {

			$hasil = $this->Pph21_mdl->get_detail_summary_kompilasi_cabang();
			$rowCount = $hasil['jmlRow'];
			$query = $hasil['query'];
			$totselisih = 0;
			if ($rowCount > 0) {
				$ii = 0;
				foreach ($query->result_array() as $row) {
					$ii++;
					$totselisih = $totselisih + $row['JUMLAH_POTONG'];
					$result['data'][] = array(
						'no' => $row['RNUM'],
						'nama_cabang' => $row['NAMA_CABANG'],
						'jumlah_potong' => number_format($row['JUMLAH_POTONG'], 2, '.', ',')
					);
				}

				$query->free_result();

				$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
				$result['recordsTotal'] = $rowCount;
				$result['recordsFiltered'] = $rowCount;

			} else {
				$result['data'] = "";
				$result['draw'] = "";
				$result['recordsTotal'] = 0;
				$result['recordsFiltered'] = 0;
			}
		}

		echo json_encode($result);
		$query->free_result();
	}

	function load_total_detail_summary_kompilasi()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_rekonsiliasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}
		$ii = 0;
		$result['jml_tidak_dilaporkan'] = 0;
		$result['jml_tgl_akhir'] = 0;
		$result['jml_import_csv'] = 0;
		$result['total'] = 0;
		if ($permission === true) {
			$hasil = $this->Pph21_mdl->get_total_detail_summary_kompilasi();
			foreach ($hasil->result_array() as $row) {
				$ii++;
				$result['total'] = $result['total'] + $row['JUMLAH_POTONG'];

				if ($row['KETERANGAN'] == 'Tidak Dilaporkan') {
					$result['jml_tidak_dilaporkan'] = $row['JUMLAH_POTONG'];
				}
				if ($row['KETERANGAN'] == 'Tanggal 26 - 31 Bulan ini') {
					$result['jml_tgl_akhir'] = $row['JUMLAH_POTONG'];
				}
				if ($row['KETERANGAN'] == 'Import CSV') {
					$result['jml_import_csv'] = $row['JUMLAH_POTONG'];
				}
			}
		}
		echo json_encode($result);
		$hasil->free_result();
	}


	function load_total_bayar()
	{

		if ($this->ion_auth->is_admin()) {
			$permission = true;
		} else if (in_array("pph21/show_rekonsiliasi", $this->session->userdata['menu_url'])) {
			$permission = true;
		} else {
			$permission = false;
		}
		$result['jml_potong'] = 0;
		if ($permission === true) {
			$hasil = $this->Pph21_mdl->get_total_bayar();
			foreach ($hasil->result_array() as $row) {
				$result['jml_potong'] = $row['JML_POTONG'];
			}
		}
		echo json_encode($result);
		$hasil->free_result();
	}


	//ADDED BY Mike -/2018
	//----------------------------------------------------------------------------

	function cetakSPT()
	{

		require_once('vendor/autoload.php');

		//data from POST request
		$pajak = ($_REQUEST['tax']) ? strtoupper($_REQUEST['tax']) : "";
		$bulan = $_REQUEST['month'];
		$tahun = $_REQUEST['year'];
		$final = $_REQUEST['final'];

		$nomorFaktur = FALSE;
		if (isset($_REQUEST['nf']))
			$nomorFaktur = $_REQUEST['nf'];

		//select template
		if ($final == "TRUE") {
			$this->cetakSPTFinal($bulan, $tahun, $pajak, $nomorFaktur);
		} else {
			$this->cetakSPTNonFinal($bulan, $tahun, $pajak, $nomorFaktur);
		}

	}

	function cetakSPTFinal($bulan, $tahun, $pajak, $nomorFaktur)
	{
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait', 'mm', array(210, 330));

		$fh = 'assets/templates/21/1721-VII.pdf';

		//GET DATA
		$data['spt'] = $this->Pph21_mdl->get_spt($bulan, $tahun, $pajak, $nomorFaktur, TRUE);

		//print_r($data['spt']);

		foreach ($data['spt'] as $pph) {
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0, 0, 0); // RGB
			$pdf->SetFont('Helvetica', '', 12); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//========================================================================
			$guideline = 0;

			$nomor = (isset($pph['NO_BUKTI_POTONG'])) ? $pph['NO_BUKTI_POTONG'] : "";

			//A
			//$npwp = (isset($pph['NPWP1'])) ? $pph['NPWP1'] : "";
			$npwp = "";

			if ($pph['NPWP1'] != "") {
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "", $pph['NPWP1']);
				$ilanginStrip = str_replace("-", "", $ilanginTitik);
				$npwp = substr($ilanginStrip, 0, 2) . "." . substr($ilanginStrip, 2, 3) . "." . substr($ilanginStrip, 5, 3) . "." . substr($ilanginStrip, 8, 1) . "-" . substr($ilanginStrip, 9, 3) . "." . substr($ilanginStrip, 12, 3);
			}
			$nik = (isset($pph['NIK'])) ? $pph['NIK'] : "";
			$nama = (isset($pph['NAMA_WP'])) ? $pph['NAMA_WP'] : "";
			$alamat = (isset($pph['ALAMAT_WP'])) ? $pph['ALAMAT_WP'] : "";
			//$alamat = "asdqwe hasbda sdnjasc as aksciasb ija sckjas ci asckj akjscioqw cjkq cwkca skc kiwciqk wcka sciub qkwc lkq bcaj skc qkwcb ka sckjbqwicaksc kajc kha hkia jq ,as cka cska cskaksc kas cka wj ahc kas ck wlc khia kha sckh ca hkc akscsc k";

			//B
			$kodePajak = (isset($pph['KODE_PAJAK'])) ? $pph['KODE_PAJAK'] : "";
			$bruto = (isset($pph['DPP'])) ? number_format($pph['DPP']) : "";
			$tarif = (isset($pph['TARIF'])) ? $pph['TARIF'] : "";
			$jumlahPotong = (isset($pph['JUMLAH_POTONG'])) ? number_format($pph['JUMLAH_POTONG']) : "";

			//C
			$npwpPP = (isset($pph['NPWPPP'])) ? $pph['NPWPPP'] : "";
			$namaPP = (isset($pph['NAMAPP'])) ? $pph['NAMAPP'] : "";
			$tanggal = (isset($pph['TGL_BUKTI_POTONG'])) ? $pph['TGL_BUKTI_POTONG'] : "";
			$signature = $pph['URL_TANDA_TANGAN'];

			//========================================================================

			$pdf->SetXY(88, 40.5);
			$pdf->Cell(41, 1, $nomor, $guideline, 1, "L");

			//A
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 56;
			$pdf->SetXY(36, $height);
			$pdf->Cell(41, 1, $npwp, $guideline, 1, "L");

			$pdf->SetXY(165, $height);
			$pdf->Cell(41, 1, $nik, $guideline, 1, "L");

			$height = 61;
			$pdf->SetXY(36, $height);
			$pdf->Cell(170, 1, $nama, $guideline, 1, "L");

			$addressStart = 36;
			$address_limit = 80;
			$height_address = 67;
			$limit = min($address_limit * 2, strlen($alamat));
			for ($i = 0; $i < 2; $i++) {
				$idx = $i;
				$height_lokasi_tanah = $height_address;
				if ($i > 0) {
					$idx = $address_limit;
					$height_lokasi_tanah = 73;
				}
				$pdf->SetXY($addressStart, $height_lokasi_tanah);
				$pdf->Cell(170, 1, substr($alamat, $idx, $address_limit), $guideline, 1, "L");
			}
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			//B
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 113;
			$pdf->SetXY(5, $height);
			$pdf->Cell(41, 1, $kodePajak, $guideline, 1, "C");

			$pdf->SetXY(50, $height);
			$pdf->Cell(76, 1, $bruto, $guideline, 1, "C");

			$pdf->SetXY(128, $height);
			$pdf->Cell(17, 1, $tarif, $guideline, 1, "C");

			$pdf->SetXY(147, $height);
			$pdf->Cell(59, 1, $jumlahPotong, $guideline, 1, "C");
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			//C
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 130;
			$pdf->SetXY(30, $height);
			$pdf->Cell(41, 1, $npwpPP, $guideline, 1, "L");

			$height = 140;
			$pdf->SetXY(30, $height);
			$pdf->Cell(41, 1, $namaPP, $guideline, 1, "L");

			$pdf->SetXY(126, $height);
			$pdf->Cell(41, 1, $tanggal, $guideline, 1, "C");

			if ($signature != "" && file_exists($signature)) {
				$pdf->Image($signature, 172.8, 130.5, 0, 18);
			}
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		}
		$pdf->Output();
	}

	function cetakSPTNonFinal($bulan, $tahun, $pajak, $nomorFaktur)
	{
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait', 'mm', array(210, 330));

		$fh = 'assets/templates/21/1721-VI.pdf';

		//GET DATA
		$data['spt'] = $this->Pph21_mdl->get_spt($bulan, $tahun, $pajak, $nomorFaktur, FALSE);

		//print_r($data['spt']);

		foreach ($data['spt'] as $pph) {
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0, 0, 0); // RGB
			$pdf->SetFont('Helvetica', '', 12); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//========================================================================
			$guideline = 0;

			$nomor = (isset($pph['NO_BUKTI_POTONG'])) ? $pph['NO_BUKTI_POTONG'] : "";

			//A
			//$npwp = (isset($pph['NPWP1'])) ? $pph['NPWP1'] : "";
			$npwp = "";

			if ($pph['NPWP1'] != "") {
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "", $pph['NPWP1']);
				$ilanginStrip = str_replace("-", "", $ilanginTitik);
				$npwp = substr($ilanginStrip, 0, 2) . "." . substr($ilanginStrip, 2, 3) . "." . substr($ilanginStrip, 5, 3) . "." . substr($ilanginStrip, 8, 1) . "-" . substr($ilanginStrip, 9, 3) . "." . substr($ilanginStrip, 12, 3);
			}
			$nik = (isset($pph['NIK'])) ? $pph['NIK'] : "";
			$nama = (isset($pph['NAMA_WP'])) ? $pph['NAMA_WP'] : "";
			$alamat = (isset($pph['ALAMAT_WP'])) ? $pph['ALAMAT_WP'] : "";
			//$alamat = "asdqwe hasbda sdnjasc as aksciasb ija sckjas ci asckj akjscioqw cjkq cwkca skc kiwciqk wcka sciub qkwc lkq bcaj skc qkwcb ka sckjbqwicaksc kajc kha hkia jq ,as cka cska cskaksc kas cka wj ahc kas ck wlc khia kha sckh ca hkc akscsc k";
			$wpLuarNegri = (isset($pph['WPLUARNEGERI']) && $pph['WPLUARNEGERI'] == "Y") ? TRUE : FALSE;
			$kodeNegara = (isset($pph['KODE_NEGARA'])) ? $pph['KODE_NEGARA'] : "";

			//B
			$kodePajak = (isset($pph['KODE_PAJAK'])) ? $pph['KODE_PAJAK'] : "";
			$bruto = (isset($pph['DPP'])) ? number_format($pph['DPP']) : "";
			$dpp = (isset($pph['DPP_BASE_AMOUNT'])) ? number_format($pph['DPP_BASE_AMOUNT']) : "";
			$tarif = (isset($pph['TARIF'])) ? $pph['TARIF'] : "";
			$jumlahPotong = (isset($pph['JUMLAH_POTONG'])) ? number_format($pph['JUMLAH_POTONG']) : "";

			//C
			$npwpPP = (isset($pph['NPWPPP'])) ? $pph['NPWPPP'] : "";
			$namaPP = (isset($pph['NAMAPP'])) ? $pph['NAMAPP'] : "";
			$tanggal = (isset($pph['TGL_BUKTI_POTONG'])) ? $pph['TGL_BUKTI_POTONG'] : "";
			$signature = $pph['URL_TANDA_TANGAN'];

			//========================================================================

			$pdf->SetXY(88, 42);
			$pdf->Cell(41, 1, $nomor, $guideline, 1, "L");

			//A
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 58;
			$pdf->SetXY(34, $height);
			$pdf->Cell(41, 1, $npwp, $guideline, 1, "L");

			$pdf->SetXY(163, $height);
			$pdf->Cell(41, 1, $nik, $guideline, 1, "L");

			$height = 63;
			$pdf->SetXY(34, $height);
			$pdf->Cell(170, 1, $nama, $guideline, 1, "L");

			$addressStart = 34;
			$address_limit = 80;
			$height_address = 69;
			$limit = min($address_limit * 2, strlen($alamat));
			for ($i = 0; $i < 2; $i++) {
				$idx = $i;
				$height_lokasi_tanah = $height_address;
				if ($i > 0) {
					$idx = $address_limit;
					$height_lokasi_tanah = 75;
				}
				$pdf->SetXY($addressStart, $height_lokasi_tanah);
				$pdf->Cell(170, 1, substr($alamat, $idx, $address_limit), $guideline, 1, "L");
			}

			$height = 83.5;

			if ($wpLuarNegri) {
				$pdf->SetXY(61, $height);
				$pdf->Cell(5, 1, "V", $guideline, 1, "C");

				$pdf->SetXY(170, $height);
				$pdf->Cell(25, 1, $kodeNegara, $guideline, 1, "L");
			}
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			//B
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 127;
			$pdf->SetXY(5, $height);
			$pdf->Cell(41, 1, $kodePajak, $guideline, 1, "C");

			$pdf->SetXY(49, $height);
			$pdf->Cell(37, 1, $bruto, $guideline, 1, "C");

			$pdf->SetXY(88, $height);
			$pdf->Cell(37, 1, $dpp, $guideline, 1, "C");

			if ($npwp == "") {
				$pdf->SetXY(128, $height);
				$pdf->Cell(17, 1, "V", $guideline, 1, "C");
			}

			$pdf->SetXY(148, $height);
			$pdf->Cell(17, 1, $tarif, $guideline, 1, "C");

			$pdf->SetXY(168, $height);
			$pdf->Cell(35, 1, $jumlahPotong, $guideline, 1, "C");
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			//C
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$height = 145;
			$pdf->SetXY(30, $height);
			$pdf->Cell(41, 1, $npwpPP, $guideline, 1, "L");

			$height = 155;
			$pdf->SetXY(30, $height);
			$pdf->Cell(41, 1, $namaPP, $guideline, 1, "L");

			$pdf->SetXY(126, $height);
			$pdf->Cell(41, 1, $tanggal, $guideline, 1, "C");

			if ($signature != "" && file_exists($signature)) {
				$pdf->Image($signature, 171.8, 143.8, 0, 18);
			}
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		}
		$pdf->Output();
	}

	function cetak_1721()
	{

		require_once('vendor/autoload.php');

		//data from POST request
		$tahun = $_REQUEST['year'];

		$this->cetak1721($tahun);

	}

	function cetak1721($tahun)
	{
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) {
			@set_time_limit(300);
		}
		$pdf = new FPDI('Portrait', 'mm', array(210, 330));

		$fh = 'assets/templates/1721A1/1721A1.pdf';
		$cabang = $this->kode_cabang;

		$queryExec1 = "select  
		SUBSTR (spp.NPWP_PEMOTONG, 1, 9) npwp_pmt1,
		SUBSTR (spp.NPWP_PEMOTONG, 10, 3) npwp_pmt2,
		SUBSTR (spp.NPWP_PEMOTONG, 13, 3) npwp_pmt3,
		SUBSTR (spp.NPWP_PETUGAS, 1, 9) npwp_ptg1,
		SUBSTR (spp.NPWP_PETUGAS, 10, 3) npwp_ptg2,
		SUBSTR (spp.NPWP_PETUGAS, 13, 3) npwp_ptg3,
		(SELECT TO_CHAR (SYSDATE, 'dd') FROM DUAL) tgl_ttd,
		(SELECT TO_CHAR (SYSDATE, 'mm') FROM DUAL) bln_ttd,
		(SELECT TO_CHAR (SYSDATE, 'yyyy') FROM DUAL) thn_ttd,
		spp.* from SIMTAX_PEMOTONG_PAJAK spp
		where DOCUMENT_TYPE = '1721A1' and KODE_CABANG = '" . $cabang . "'
		and spp.start_effective_date <= sysdate
		and spp.end_effective_date >= sysdate";
		$query1 = $this->db->query($queryExec1);

		/*print_r($queryExec1); die();*/

		$rowCount = $query1->num_rows();

		//$npwppmt2 = "";

		if ($rowCount > 0) {
			$rowb1 = $query1->row();
			$npwppmt1 = $rowb1->NPWP_PMT1;
			$npwppmt2 = $rowb1->NPWP_PMT2;
			$npwppmt3 = $rowb1->NPWP_PMT3;
		}

		$npwpPemotong = $npwppmt2;


		//GET DATA
		$data['spt'] = $this->Pph21_mdl->get_1721($tahun, $npwpPemotong);

		//print_r($data['spt']);

		foreach ($data['spt'] as $pph) {
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0, 0, 0); // RGB
			$pdf->SetFont('Helvetica', '', 12); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//========================================================================
			$guideline = 0;

			$nomor_1 = (isset($pph['NO_1'])) ? $pph['NO_1'] : "";
			$nomor_2 = (isset($pph['NO_2'])) ? $pph['NO_2'] : "";
			$nomor_3 = (isset($pph['NO_3'])) ? $pph['NO_3'] : "";

			//========================================================================

			$pdf->SetXY(104, 43);
			$pdf->Cell(41, 3, $nomor_1, $guideline, 1, "L");

			$pdf->SetXY(116, 43);
			$pdf->Cell(41, 3, $nomor_2, $guideline, 1, "L");

			$pdf->SetXY(130, 43);
			$pdf->Cell(41, 3, $nomor_3, $guideline, 1, "L");

			$pdf->SetXY(176, 43);
			$pdf->Cell(41, 3, $pph['MASA_AWAL'], $guideline, 1, "L");

			$pdf->SetXY(189, 43);
			$pdf->Cell(41, 3, $pph['MASA_AKHIR'], $guideline, 1, "L");

			//A
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


			$query1 = $this->db->query($queryExec1);
			$rowCount = $query1->num_rows();

			if ($rowCount > 0) {

				$rowb1 = $query1->row();
				$ttd = $rowb1->URL_TANDA_TANGAN;
				$petugas_ttd = $rowb1->NAMA_PETUGAS_PENANDATANGAN;
				$jabatan_petugas_ttd = $rowb1->JABATAN_PETUGAS_PENANDATANGAN;
				$npwppmt1 = $rowb1->NPWP_PMT1;
				$npwppmt2 = $rowb1->NPWP_PMT2;
				$npwppmt3 = $rowb1->NPWP_PMT3;
				$npwp = $rowb1->NPWP_PTG1;
				$npwp2 = $rowb1->NPWP_PTG2;
				$npwp3 = $rowb1->NPWP_PTG3;
				$nama_pemotong = $rowb1->NAMA_WP_PEMOTONG;
				$tgl_ttd = $rowb1->TGL_TTD;
				$bln_ttd = $rowb1->BLN_TTD;
				$thn_ttd = $rowb1->THN_TTD;

				$npwp_1 = "";

				if ($npwppmt1 != "") {
					//$npwp = $pph['NPWP'];
					$ilanginTitik = str_replace(".", "", $npwppmt1);
					$ilanginStrip = str_replace("-", "", $ilanginTitik);
					$npwp_1 = substr($ilanginStrip, 0, 2) . "." . substr($ilanginStrip, 2, 3) . "." . substr($ilanginStrip, 5, 3) . "." . substr($ilanginStrip, 8, 1);
				}

				$npwp_2 = "";

				if ($npwp != "") {
					//$npwp = $pph['NPWP'];
					$ilanginTitik = str_replace(".", "", $npwp);
					$ilanginStrip = str_replace("-", "", $ilanginTitik);
					$npwp_2 = substr($ilanginStrip, 0, 2) . "." . substr($ilanginStrip, 2, 3) . "." . substr($ilanginStrip, 5, 3) . "." . substr($ilanginStrip, 8, 1);
				}

				$height = 54;
				$pdf->SetXY(49, $height);
				$pdf->Cell(41, 1, $npwp_1, $guideline, 1, "L");

				$height = 54;
				$pdf->SetXY(99, $height);
				$pdf->Cell(41, 1, $npwppmt2, $guideline, 1, "L");

				$height = 54;
				$pdf->SetXY(113, $height);
				$pdf->Cell(41, 1, $npwppmt3, $guideline, 1, "L");

				$height = 62;
				$pdf->SetXY(49, $height);
				$pdf->Cell(41, 1, $nama_pemotong, $guideline, 1, "L");

				$height = 295;
				$pdf->SetXY(40, $height);
				$pdf->Cell(41, 1, $npwp_2, $guideline, 1, "L");

				$height = 295;
				$pdf->SetXY(83, $height);
				$pdf->Cell(41, 1, $npwp2, $guideline, 1, "L");

				$height = 295;
				$pdf->SetXY(95, $height);
				$pdf->Cell(41, 1, $npwp3, $guideline, 1, "L");

				$height = 302;
				$pdf->SetXY(40, $height);
				$pdf->Cell(41, 1, $petugas_ttd, $guideline, 1, "L");

				$height = 302;
				$pdf->SetXY(113, $height);
				$pdf->Cell(41, 1, $tgl_ttd, $guideline, 1, "L");

				$height = 302;
				$pdf->SetXY(128, $height);
				$pdf->Cell(41, 1, $bln_ttd, $guideline, 1, "L");

				$height = 302;
				$pdf->SetXY(143, $height);
				$pdf->Cell(41, 1, $thn_ttd, $guideline, 1, "L");

				if (file_exists($ttd)) {
					$pdf->Image($ttd, 172, 294.9, 0, 15);
				}

			}

			$height = 81;
			$pdf->SetXY(40, $height);
			$pdf->Cell(41, 1, $npwp_1, $guideline, 1, "L");

			$height = 81;
			$pdf->SetXY(86, $height);
			$pdf->Cell(41, 1, $pph['NPWP_2'], $guideline, 1, "L");

			$height = 81;
			$pdf->SetXY(103, $height);
			$pdf->Cell(41, 1, $pph['NPWP_3'], $guideline, 1, "L");

			$height = 90;
			$pdf->SetXY(40, $height);
			$pdf->Cell(41, 1, $pph['NIK'], $guideline, 1, "L");

			$height = 97;
			$pdf->SetXY(40, $height);
			$pdf->Cell(41, 1, $pph['EMPLOYEE_NAME'], $guideline, 1, "L");

			$height = 103;
			$pdf->SetXY(40, $height);
			$pdf->Cell(41, 1, $pph['ALAMAT_1'], $guideline, 1, "L");

			$height = 110;
			$pdf->SetXY(40, $height);
			$pdf->Cell(41, 1, $pph['ALAMAT_2'], $guideline, 1, "L");

			if ($pph['STATUS_PTKP'] == 'K') {
				$height = 90;
				$pdf->SetXY(130, $height);
				$pdf->Cell(41, 1, $pph['DEPENDENT'], $guideline, 1, "L");
			} else {
				$height = 90;
				$pdf->SetXY(155, $height);
				$pdf->Cell(41, 1, $pph['DEPENDENT'], $guideline, 1, "L");
			}

			if ($pph['SEX'] == 'M') {
				$height = 116.5;
				$pdf->SetXY(51.5, $height);
				$pdf->Cell(41, 1, $pph['JK'], $guideline, 1, "L");
			} else {
				$height = 116.5;
				$pdf->SetXY(83.5, $height);
				$pdf->Cell(41, 1, $pph['JK'], $guideline, 1, "L");
			}

			if ($pph['WP_LUAR_NEGERI'] == 'N') {
				$height = 103;
				$pdf->SetXY(166, $height);
				$pdf->Cell(41, 1, "", $guideline, 1, "L");
			} else {
				$height = 103;
				$pdf->SetXY(166, $height);
				$pdf->Cell(41, 1, "X", $guideline, 1, "L");
			}

			$height = 110;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, $pph['KODE_NEGARA'], $guideline, 1, "L");

			$height = 139;
			$pdf->SetXY(47, $height);
			$pdf->Cell(41, 1, "X", $guideline, 1, "L");

			$height = 97;
			$pdf->SetXY(155, $height);
			$pdf->Cell(41, 1, $pph['JOB_NAME'], $guideline, 1, "L");

			$height = 152;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R1']), $guideline, 1, "R");

			$height = 158;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R2']), $guideline, 1, "R");

			$height = 164;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R3']), $guideline, 1, "R");

			$height = 170;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R4']), $guideline, 1, "R");

			$height = 176;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R5']), $guideline, 1, "R");

			$height = 182;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R6']), $guideline, 1, "R");

			$height = 188;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['BONUS']), $guideline, 1, "R");

			$height = 194;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['TOTAL_BRUTO']), $guideline, 1, "R");

			$height = 206;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['BIAYA_JABATAN']), $guideline, 1, "R");

			$height = 212.6;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['IURAN_PENSIUN']), $guideline, 1, "R");

			$height = 218.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['JUMLAH_PENGURANG']), $guideline, 1, "R");

			$height = 230.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['JUMLAH_PENGHASILAN_NETTO']), $guideline, 1, "R");

			$height = 236.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['JUMLAH_PENGHASILAN_SEBELUMNYA']), $guideline, 1, "R");

			$height = 242.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['JMLH_PNGHSLAN_DISTHNKAN']), $guideline, 1, "R");

			$height = 248.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['PTKP']), $guideline, 1, "R");

			$height = 254.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['PKP']), $guideline, 1, "R");

			$height = 260.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R17']), $guideline, 1, "R");

			$height = 266.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R18']), $guideline, 1, "R");

			$height = 272.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R19']), $guideline, 1, "R");

			$height = 278.8;
			$pdf->SetXY(164, $height);
			$pdf->Cell(41, 1, number_format($pph['A1R20']), $guideline, 1, "R");

			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		}
		$pdf->Output();
	}

	function load_ntpn()
	{

		$kode_cabang = $this->input->post('_searchKodeCabang');
		if ($kode_cabang == "all") {
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else {
			$whereCabang = "'" . $kode_cabang . "'";
		}
		$tahun_pajak = $this->input->post('_searchTahun');
		$jenis_pajak = $this->input->post('_searchJenisPajak');

		$permission = true;

		$result['data'] = "";
		$result['draw'] = "";
		$result['recordsTotal'] = 0;
		$result['recordsFiltered'] = 0;

		if ($permission === true) {

			$start = ($this->input->post('start')) ? $this->input->post('start') : 0;
			$length = ($this->input->post('length')) ? $this->input->post('length') : 10;
			$draw = ($this->input->post('draw')) ? $this->input->post('draw') : 0;
			$keywords = (isset($_POST['search'])) ? $_POST['search']['value'] : '';

			$hasil = $this->Pph21_mdl->get_ntpn($tahun_pajak, $jenis_pajak, $whereCabang, $start, $length, $keywords);

			$rowCount = $hasil['jmlRow'];
			$query = $hasil['query'];
			if ($rowCount > 0) {
				$ii = 0;
				foreach ($query->result_array() as $row) {
					$ii++;

					$result['data'][] = array(
						'id' => $row['ID'],
						'no' => $row['RNUM'],
						'kode_cabang' => $row['KODE_CABANG'],
						'pembetulan' => $row['PEMBETULAN'],
						'bulan' => $row['BULAN'],
						'nama_bulan' => get_masa_pajak($row['BULAN'], "id", true),
						'tahun' => $row['TAHUN'],
						'ntpn' => $row['NTPN'],
						'jenis_pajak' => $row['JENIS_PAJAK'],
						'bank' => $row['BANK'],
						'tanggal_setor' => $row['TANGGAL_SETOR'],
						'tanggal_lapor' => $row['TANGGAL_LAPOR'],
						'nama_cabang' => get_nama_cabang($row['KODE_CABANG']),
						'nominal' => $row['NOMINAL']
					);
				}

				$query->free_result();

				$result['draw'] = $_POST['draw'] = ($_POST['draw']) ? $_POST['draw'] : 0;
				$result['recordsTotal'] = $rowCount;
				$result['recordsFiltered'] = $rowCount;

			} else {
				$result['data'] = "";
				$result['draw'] = "";
				$result['recordsTotal'] = 0;
				$result['recordsFiltered'] = 0;
			}
			$query->free_result();

		}

		echo json_encode($result);
	}

	function save_ntpn()
	{

		$return = false;

		$id = $this->input->post('id');
		$kode_cabang = $this->input->post('kd_cabangs');
		$isnewRecord = $this->input->post('isnewRecord');
		$bulan_pajak = $this->input->post('bulan_pajak');
		$tahun_pajak = $this->input->post('tahun_pajak');
		$pembetulan_ke = $this->input->post('pembetulan_pajak');
		$ntpn = $this->input->post('ntpn');
		$bank = $this->input->post('bank');
		$nominal = $this->input->post('nominal');
		$jenis_pajak = $this->input->post('jenisPajaks');
		$tanggal_setor = ($this->input->post('tanggal_setor')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggal_setor')))) : '';
		$tanggal_lapor = ($this->input->post('tanggal_lapor')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggal_lapor')))) : '';

		$data = array(
			'BULAN' => $bulan_pajak,
			'TAHUN' => $tahun_pajak,
			'PEMBETULAN' => $pembetulan_ke,
			'NTPN' => $ntpn,
			'JENIS_PAJAK' => $jenis_pajak,
			'BANK' => $bank,
			'KODE_CABANG' => $kode_cabang,
			'NOMINAL' => $nominal
		);

		$check = $this->Pph21_mdl->check_ntpn($id, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $jenis_pajak, $kode_cabang, $ntpn); //add validasi ntpn 27032019

		if ($check > 0) {
			echo '2';
		} else {

			if ($isnewRecord == "0") {
				if ($this->Pph21_mdl->update_ntpn($id, $data, $tanggal_setor, $tanggal_lapor)) {
					echo '1';
				} else {
					echo '0';
				}

			} else {
				if ($this->Pph21_mdl->add_ntpn($data, $tanggal_setor, $tanggal_lapor)) {
					echo '1';
				} else {
					echo '0';
				}
			}
		}
	}

	function delete_ntpn()
	{
		$id = $this->input->post('id');

		$data = $this->Pph21_mdl->delete_ntpn($id);

		if ($data) {
			echo '1';
		} else {
			echo '0';
		}
	}


}
