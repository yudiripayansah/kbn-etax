<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Ppnmasa_detail_jurnal_mdl extends CI_Model {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Master_mdl');
		    
    }

    function get_detail_jurnal($nama_pajak, $kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke,$category="", $start, $length, $keywords)
	{
		ini_set('memory_limit', '-1');
		$where         = "";
		$whereCategory = "";

		if($nama_pajak == "PPN MASUKAN"){
			$qnama_pajak = " and account = '10901601'";
		}
		else{
			$qnama_pajak = " and account = '30901601'";
		}

		if($kode_cabang != ""){
			$whereCabang = " and kode_cabang = '".$kode_cabang."'";
		}
		if($bulan_pajak != ""){
			$whereBulan = " and bulan_buku = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and tahun_buku = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and pembetulan = '".$pembetulan_ke."'";
		}

		if($keywords) {
			$q     = strtoupper($keywords);
			$where = " AND (
						UPPER(NOMOR_FAKTUR) LIKE '%".$q."%'
						OR UPPER(DOCNUMBER) LIKE '%".$q."%'
						OR UPPER(DESCSUBLEDGER) LIKE '%".$q."%'
						OR UPPER(PONUMBER) LIKE '%".$q."%'
						OR UPPER(NOMORINVOICE) LIKE '%".$q."%'
						) ";
		}

		$mainQuery	=  "SELECT 
                            LEDGER_ID, 
                            PERIOD_NAME, 
                            USER_JE_SOURCE_NAME, 
                            DOCNUMBER, 
                            NOMOR_FAKTUR, 
                            BULAN_BUKU, 
                            TAHUN_BUKU, 
                            TANGGALPOSTING, 
                            DESCJENISTRANSAKSI, 
                            LINENO, 
                            ACCOUNT, 
                            DESCACCOUNT, 
                            AMOUNT, 
                            SUBLEDGER, 
                            CODESUBLEDGER, 
                            DESCSUBLEDGER, 
                            DESCRIPTIONHEADER, 
                            REFERENCELINE,
                            PROFITCENTER,
                            PROFITCENTERDESC,
                            COSTCENTER,
                            COSTCENTERDESC,
                            PONUMBER, 
                            TANGGALPO,
                            KODE_CABANG,
							DETAIL_JURNAL_ID,
							NOMORINVOICE,
							TANGGALINVOICE,
							STATUSDOKUMEN
                            FROM SIMTAX_DETAIL_JURNAL_TRANSAKSI
					        WHERE 1=1
						".$where.$qnama_pajak.$whereCabang.$whereBulan.$whereTahun;
				
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


	function update_detail_jurnal($id, $data, $tanggalposting="", $tanggalpo="", $tanggalinvoice=""){

		$date   = date("Y-m-d H:i:s");

		if($tanggalposting != ""){
			$this->db->set('TANGGALPOSTING',"TO_DATE('".$tanggalposting."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggalpo != ""){
			$this->db->set('TANGGALPO',"TO_DATE('".$tanggalpo."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggalinvoice != ""){
			$this->db->set('TANGGALINVOICE',"TO_DATE('".$tanggalinvoice."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		
		$this->db->set('LAST_UPDATE_DATE',"TO_DATE('".$date."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		$this->db->where('DETAIL_JURNAL_ID', $id);
		
		$update = $this->db->update("SIMTAX_DETAIL_JURNAL_TRANSAKSI", $data);

		if($update){
			$param = array("DETAIL_JURNAL_ID", $id);
			return true;
		}
		else{
			return false;
		}
	}

	function delete_jurnal_detail($detail_jurnal_id){

		$sql = "DELETE FROM SIMTAX_DETAIL_JURNAL_TRANSAKSI
					WHERE DETAIL_JURNAL_ID = ".$detail_jurnal_id;

		$query	= $this->db->query($sql);

		if($query){
			return true;
		}
	}


	function get_data_csv($nama_pajak, $kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke)
	{

		$where         = "";
		$whereCategory = "";

		if($nama_pajak == "PPN MASUKAN"){
			$qnama_pajak = " and account = '10901601'";
		}
		else{
			$qnama_pajak = " and account = '30901601'";
		}

		if($kode_cabang != ""){
			$whereCabang = " and kode_cabang = '".$kode_cabang."'";
		}
		if($bulan_pajak != ""){
			$whereBulan = " and bulan_buku = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and tahun_buku = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and pembetulan = '".$pembetulan_ke."'";
		}

		$sql	=  "SELECT 
                            LEDGER_ID, 
                            PERIOD_NAME, 
                            USER_JE_SOURCE_NAME, 
                            DOCNUMBER, 
                            NOMOR_FAKTUR, 
                            BULAN_BUKU, 
                            TAHUN_BUKU, 
                            TANGGALPOSTING, 
                            DESCJENISTRANSAKSI, 
                            LINENO, 
                            ACCOUNT, 
                            DESCACCOUNT, 
                            AMOUNT, 
                            SUBLEDGER, 
                            CODESUBLEDGER, 
                            DESCSUBLEDGER, 
                            DESCRIPTIONHEADER, 
                            REFERENCELINE,
                            PROFITCENTER,
                            PROFITCENTERDESC,
                            COSTCENTER,
                            COSTCENTERDESC,
                            PONUMBER, 
                            TANGGALPO,
                            KODE_CABANG,
							DETAIL_JURNAL_ID,
							NOMORINVOICE,
							TANGGALINVOICE,
							STATUSDOKUMEN
                            FROM SIMTAX_DETAIL_JURNAL_TRANSAKSI
					        WHERE 1=1
						".$where.$qnama_pajak.$whereCabang.$whereBulan.$whereTahun;

		$query = $this->db->query($sql);
		return $query;

	}

	function submit_jurnal_transaksi($nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $cabang)
	{

		$this->db->set('STATUSDOKUMEN',"'SUBMIT'",false);
		$this->db->where('BULAN_BUKU', $bulan_pajak);
		$this->db->where('TAHUN_BUKU', $tahun_pajak);
		$this->db->where('KODE_CABANG', $cabang);
		if($nama_pajak == "PPN MASUKAN"){
			$account = "10901601";
		}
		else{
			$account = "30901601";
		}
		$this->db->where('ACCOUNT', $account);
		$update = $this->db->update("SIMTAX_DETAIL_JURNAL_TRANSAKSI");
		
		if ($update){
			return true;
		} else {
			return false;
		}
		
	}

}