<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class H2h_staging_mdl extends CI_Model {
	
		
    public function __construct()
    {
        parent::__construct();
        $this->kode_cabang = $this->session->userdata('kd_cabang');
    }
	
    function get_master_pajak()
	{
		$queryExec	        = "Select distinct kelompok_pajak from simtax_master_jns_pajak order by kelompok_pajak";
		$query 		        = $this->db->query($queryExec);
		$result['query']	= $query;
		return $result;		
	}

    function get_log_staging()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;

		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$kode_cabang   = $this->input->post('_searchCabang');
		$nama_pajak    = $this->input->post('_searchPajak');
		$bulan_pajak   = $this->input->post('_searchBulan');
		$tahun_pajak   = $this->input->post('_searchTahun');
		$pembetulan_ke = $this->input->post('_searchPembetulan');
		$jenis_pajak   = $this->input->post('_searchJenisPajak');
		
		$where	= "";
		if($q) {
			$where	.= " and upper(a.docnumber) like '%".strtoupper($q)."%' ";
		}

		if($kode_cabang != ""){
			$whereCabang	= " and a.kode_cabang = '".$kode_cabang."'";
		}
		if($nama_pajak != ""){
			$wherePajak	= " and a.pajak = '".$nama_pajak."'";
		}
		if($jenis_pajak != ""){
			$whereJnsPajak	= " and a.jenis_pajak = '".$jenis_pajak."'";
		}
		if($bulan_pajak != ""){
			$whereBulan	= " and a.bulan_pajak = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and a.tahun_pajak = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and a.pembetulan = '".$pembetulan_ke."'";
		}
		
		$queryExec	= "Select a.idlog, a.docnumber, a.kode_cabang, a.pajak, a.jenis_pajak, a.bulan_pajak, TO_CHAR(a.tanggal_kirim, 'DD-MON-YYYY HH24:MI:SS') as tanggal_kirim, 
						a.tahun_pajak, a.pajak_header_id, a.status_kirim, a.keterangan, a.pengirim,
						a.total_baris_kirim, a.npwp, a.is_creditable, a.pembetulan, b.nama_cabang
						from simtax_h2h_staging_log a
						left join simtax_kode_cabang b
						on a.kode_cabang = b.kode_cabang
						where a.docnumber is not null
                        ".$where."
						".$whereCabang.$wherePajak.$whereJnsPajak.$whereBulan.$whereTahun.$wherePembetulan.
						" order by TO_CHAR(a.tanggal_kirim, 'MM-DD-YYYY HH24:MI:SS') desc";		

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
		$rowCount	= $query2->num_rows();
		$query 		= $this->db->query($sql);							
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;			
	}

	function get_data_staging($pajakku)
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$kode_cabang   = $this->input->post('_searchCabang');
		$nama_pajak    = $this->input->post('_searchPajak');
		$bulan_pajak   = $this->input->post('_searchBulan');
		$tahun_pajak   = $this->input->post('_searchTahun');
		$pembetulan_ke = $this->input->post('_searchPembetulan');
		$jenis_pajak   = $this->input->post('_searchJenisPajak');
		$is_view   = $this->input->post('_searchView');
		$valsenderid ="";

		if($pajakku == 'PPN MASA'){
			$wherePajakku = " and b.pajak = 'PPNMASA'";
			$wherePajakku2 = " and pajak = 'PPNMASA'";
		} else {
			$wherePajakku = " and b.pajak = 'DETAILJT'";
			$wherePajakku2 = " and pajak = 'DETAILJT'";
		}
		
		$where	= "";
		if($q) {
			$where	.= " and upper(a.docnumber) like '%".strtoupper($q)."%' 
						or upper(a.journalnumber) like '%".strtoupper($q)."%'
						or upper(a.npwp) like '%".strtoupper($q)."%'
						or upper(a.nama_wp) like '%".strtoupper($q)."%'
						or upper(a.no_faktur_pajak) like '%".strtoupper($q)."%'
						or upper(a.subledger) like '%".strtoupper($q)."%'
						or upper(a.ponumber) like '%".strtoupper($q)."%'
						";
		}
		
		if($kode_cabang != ""){
			$whereCabang	= " and b.kode_cabang = '".$kode_cabang."'";
			$whereCabang2	= " and kode_cabang = '".$kode_cabang."'";
		}
		if($nama_pajak != ""){
			$wherePajak	= " and b.pajak = '".$nama_pajak."'";
			$wherePajak2	= " and pajak = '".$nama_pajak."'";
		}
		if($jenis_pajak != ""){
			$whereJnsPajak	= " and a.jenis_pajak = '".$jenis_pajak."'";
			$whereJnsPajak2	= " and jenis_pajak = '".$jenis_pajak."'";
		}
		if($bulan_pajak != ""){
			$whereBulan	= " and b.bulan_pajak = ".$bulan_pajak;
			$whereBulan2	= " and bulan_pajak = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and b.tahun_pajak = ".$tahun_pajak;
			$whereTahun2 = " and tahun_pajak = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and b.pembetulan = '".$pembetulan_ke."'";
			$wherePembetulan2 = " and pembetulan = '".$pembetulan_ke."'";
		}
		
		if($is_view != ''){
			$qsenderid = "select distinct docnumber
						from simtax_h2h_staging_log
						where 1=1 
						".$wherePajakku2."
						".$whereCabang2.$wherePajak2.$whereJnsPajak2.$whereBulan2.$whereTahun2.$wherePembetulan2."
							and tanggal_kirim  = 
							(
							select max(tanggal_kirim) tgl_kirim
							from simtax_h2h_staging_log
							where 1=1
							".$wherePajakku2."
							".$whereCabang2.$wherePajak2.$whereJnsPajak2.$whereBulan2.$whereTahun2.$wherePembetulan2.
							")";
			$rsenderid 	= $this->db->query($qsenderid);		
			
			foreach($rsenderid->result_array() as $val => $vsenderid) {			
				$valsenderid = $vsenderid['DOCNUMBER'];
			}
		}
			
		$wheresenderid = "";
		if($valsenderid != ""){
			$wheresenderid = " and b.docnumber = '".$valsenderid."'";
		}
		
		$queryExec	= "Select a.journalnumber, 
							a.tahun_buku,
							a.kd_jenis_transaksi,
							a.fg_pengganti,
							a.no_faktur_pajak,
							a.tanggal_faktur_pajak,
							a.npwp,
							a.nama_wp,
							a.alamat_wp,
							a.dpp,
							a.jumlah_ppn,
							a.jumlah_ppnbm,
							a.masa_pengkreditan,
							a.tahun_pengkreditan,
							a.referensi,
							b.kode_cabang,
							a.nama_cabang,
							a.status_transaksi,
							a.company_id,
							a.company_name,
							a.status_kirim,
							a.keterangan,
							a.jenis_pajak,
							a.bulan_buku,
							a.tanggalposting, 
							a.descjenistransaksi,
							a.lineno,
							a.account,
							a.descaccount,
							a.amount,
							a.subledger,
							a.codesubledger,
							a.descsubledger,
							a.descriptionheader,
							a.referenceline,
							a.profitcenter,
							a.profitcenterdesc,
							a.costcenter,
							a.costcenterdesc,
							a.ponumber,
							a.tanggalpo,
							a.currency,
							b.docnumber, 
							b.pajak, 
							b.bulan_pajak, 
							TO_CHAR(b.tanggal_kirim, 'DD-MON-YYYY HH24:MI:SS') as tanggal_kirim, 
						   	b.tahun_pajak, 
							b.pajak_header_id, 
							b.pengirim,
						   	b.total_baris_kirim, 
							b.is_creditable, 
							b.pembetulan
						from simtax_h2h_staging a
						inner join  simtax_h2h_staging_log b
						on a.docnumber = b.docnumber
						where a.docnumber is not null
						".$wherePajakku."
                        ".$where."
						".$whereCabang.$wherePajak.$whereJnsPajak.$whereBulan.$whereTahun.$wherePembetulan.$wheresenderid.
						" order by TO_CHAR(b.tanggal_kirim, 'MM-DD-YYYY HH24:MI:SS') desc";		
		
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
		$rowCount	= $query2->num_rows();
		$query 		= $this->db->query($sql);							
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		return $result;		
			
	}

	function insertLog($insert_data)
	{
		$cabang = $this->kode_cabang;    
		$user = $this->session->userdata('identity');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pajak = $this->input->post('pajak');
		$jenispajak = $this->input->post('jenisPajak');
		$date = date('Y-m-d H:i:s');
		$docNumber 			= "";
		$jurnalNumber 		= "";
		$tahunBuku 			= "";
		$kdTransaksi 		= "";
		$fgPengganti 		= "";
		$nomorFaktur 		= "";
		$tanggalFaktur 		= "";
		$npwpPembeli 		= "";
		$namaPembeli 		= "";
		$alamatPembeli 		= "";
		$jumlahDpp 			= "";
		$jumlahPpn 			= "";
		$jumlahPpnbm 		= "";
		$masaPengkreditan 	= "";
		$tahunPengkreditan 	= "";
		$referensi 			= "";
		$nikPembeli 		= "";
		$kodeBranch 		= "";
		$namaBranch 		= "";
		$idCurreny 			= "";
		$statusTransaksi 	= "";
		$company_name 		= "";
		$pajak_header_id 	= "";
		$creditable 		= "";
		$pembetulan_ke 		= "";
		$kode_cabang 		= "";
		$total_baris_kirim 	= "";
		$fgUangmuka 		= "null";
		$uangMukadpp 		= "null";
		$uangMukappn 		= "null";
		$uangMukappnbm 		= "null";
		$jenisFaktur		= "null";
		$iscreditable		= "null";

		$ins = true;
		foreach($insert_data as $row_data){
			$element_data 	= json_decode($row_data['element_data']);
			$docNumber 		= $row_data['docNumber'];
			$jurnalNumber 	= $element_data->docNumber;
			$tahunBuku 		= $element_data->tahunBuku;
			$kdTransaksi 	= $element_data->kdTransaksi;
			$fgPengganti 	= $element_data->fgPengganti;
			$nomorFaktur 	= $element_data->nomorFaktur;
			$tanggalFaktur 	= $element_data->tanggalFaktur;
			if($jenispajak == "PPN KELUARAN" || $jenispajak == "DOKUMEN LAIN KELUARAN"){
				$npwpwp 			= $element_data->npwpPembeli;
				$namawp 			= $element_data->namaPembeli;
				$alamatwp 			= $element_data->alamatPembeli;
				$fgUangmuka 		= ($element_data->fgUangmuka) ? $element_data->fgUangmuka : "null";
				$uangMukadpp 		= ($element_data->uangMukadpp) ? $element_data->uangMukadpp : "null";
				$uangMukappn 		= ($element_data->uangMukappn) ? $element_data->uangMukappn : "null";
				$uangMukappnbm 		= ($element_data->uangMukappnbm) ? $element_data->uangMukappnbm : "null";
				$jenisFaktur 		= $element_data->jenisFaktur;
			} else {
				$npwpwp 			= $element_data->npwpPenjual;
				$namawp 			= $element_data->namaPenjual;
				$alamatwp 			= $element_data->alamatPenjual;
				$iscreditable 		= $element_data->isCreditable;
				$masaPengkreditan 	= $element_data->masaPengkreditan;
				$tahunPengkreditan 	= $element_data->tahunPengkreditan;
				if($jenispajak != "DOKUMEN LAIN MASUKAN"){
					$jenisFaktur 		= "FM";
				} else {
					$jenisFaktur 		= "DM";
				}
			}
			$jumlahDpp 			= $element_data->jumlahDpp;
			$jumlahPpn 			= $element_data->jumlahPpn;
			$jumlahPpnbm 		= $element_data->jumlahPpnbm;
			$referensi 			= $element_data->referensi;
			$nikPembeli 		= $element_data->nikPembeli;
			$kodeBranch 		= $element_data->kodeBranch;
			$namaBranch 		= $element_data->namaBranch;
			$idCurreny 			= $element_data->idCurrency;
			$statusTransaksi 	= $element_data->statusTransaksi;
			$company_id 		= $element_data->company_id;
			$company_name 		= $element_data->company_name;
			$status_message 	= $row_data['statusMessage']; //sukses atau error
			$status 			= $row_data['status']; // S atau E
			$pajak_header_id 	= $row_data['pajak_header_id'];
			$creditable 		= $row_data['creditable'];
			$pembetulan_ke 		= $row_data['pembetulan_ke'];
			$kode_cabang 		= $row_data['kode_cabang'];
			$total_baris_kirim 	= $row_data['total_baris_kirim'];
			
			if($total_baris_kirim > 0){
				$sql = "Insert into SIMTAX_H2H_STAGING (
					DOCNUMBER,
					JOURNALNUMBER,
					TAHUN_BUKU,
					KD_JENIS_TRANSAKSI,
					FG_PENGGANTI,
					NO_FAKTUR_PAJAK,
					TANGGAL_FAKTUR_PAJAK,
					NPWP,
					NAMA_WP,
					ALAMAT_WP,
					DPP,
					JUMLAH_PPN,
					JUMLAH_PPNBM,
					MASA_PENGKREDITAN,
					TAHUN_PENGKREDITAN,
					REFERENSI,
					KODE_CABANG,
					NAMA_CABANG,
					STATUS_TRANSAKSI,
					COMPANY_ID,
					COMPANY_NAME,
					STATUS_KIRIM,
					KETERANGAN,
					JENIS_PAJAK,
					CURRENCY,
					IS_CREDITABLE,
					FG_UANG_MUKA,
					UANG_MUKA_DPP,
					UANG_MUKA_PPN,
					UANG_MUKA_PPNBM,
					JENIS_FAKTUR
					) 
					 values (
						 '".$docNumber."',
						 '".$jurnalNumber."',
						 ".$tahunBuku.",
						 ".$kdTransaksi.",
						 ".$fgPengganti.",
						 '".$nomorFaktur."',
						 '".$tanggalFaktur."',
						 '".$npwpwp."',
						 '".$namawp."',
						 '".$alamatwp."',
						  ".$jumlahDpp.",
						  ".$jumlahPpn.",
						  ".$jumlahPpnbm.",
						 '".$masaPengkreditan."',
						 '".$tahunPengkreditan."',
						 '".$referensi."',
						 '".$kodeBranch."',
						 '".$namaBranch."',
						 ".$statusTransaksi.",
						 ".$company_id.",
						 '".$company_name."',
						 '".$status."',
						 '".$status_message."',
						 '".$jenispajak."',
						 '".$idCurreny."',
						 ".$iscreditable.",
						 ".$fgUangmuka.",
						 ".$uangMukadpp.",
						 ".$uangMukappn.",
						 ".$uangMukappnbm.",
						 '".$jenisFaktur."'
					)";	
				}
					 					 
			try {
				$query = $this->db->query($sql);
				if($query){
					$ins =true;
				} else {
					//print_r($this->db->error());
					return false;
				}	
			} catch (Exception $ex) {
				return false;
			}	
		}

		if($total_baris_kirim != 0){
			$vstatuskirim = 'T';
			$vketerangan = 'Terkirim';
		} else {
			$vstatuskirim = 'K';
			$vketerangan = 'Data Kosong';
		}
		if($ins){
			/*
			//data lama dianggap tidak valid 
			$sqldtlama	="update simtax_h2h_staging_log
			set REPLACE_BY_SENDER_ID = '".$docNumber."'
			where bulan_pajak = ".$bulan."
				and tahun_pajak = ".$tahun."
				and kode_cabang = '".$kode_cabang."'
				and pajak = '".$pajak."'
				and jenis_pajak = '".$jenispajak."'
				and status_kirim = 'T'
				and pembetulan = '".$pembetulan_ke."'
			";	
			$querydtlama	= $this->db->query($sqldtlama);	
			*/

			$sqllog = "Insert into SIMTAX_H2H_STAGING_LOG (
				DOCNUMBER,
				KODE_CABANG,
				PAJAK,
				JENIS_PAJAK,
				BULAN_PAJAK,
				TAHUN_PAJAK,
				PAJAK_HEADER_ID,
				TANGGAL_KIRIM,
				STATUS_KIRIM,
				KETERANGAN,
				PENGIRIM,
				TOTAL_BARIS_KIRIM,
				IS_CREDITABLE,
				PEMBETULAN) 
				 values (
					 '".$docNumber."',
					 '".$kode_cabang."',
					 '".$pajak."',
					 '".$jenispajak."',
					 ".$bulan.",
					 ".$tahun.",
					 '".$pajak_header_id."',
					 sysdate,
					 '".$vstatuskirim."',
					 '".$vketerangan."',
					 '".$user."',
					  ".$total_baris_kirim.",
					 '".$creditable."',
					 '".$pembetulan_ke."')";
					 
				$query = $this->db->query($sqllog);

				if($query){
					$ins = true;
				} else {
					return false;
				}	
		} else {
			return false;
		}

		return $ins;
		
  }

  function insertLogJt($insert_data)
	{
		$cabang = $this->kode_cabang;    
		$user = $this->session->userdata('identity');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$pajak = $this->input->post('pajak');
		$jenispajak = $this->input->post('jenisPajak');
		$date = date('Y-m-d H:i:s');
		$docNumber = "";
		$jurnalNumber = "";
		$bulanBuku = "";
		$tahunBuku = "";
		$tanggalPosting = "";
		$nomorFaktur = "";
		$descriptionHeader = "";
		$lineNo = "";
		$descJenisTransaksi = "";
		$account = "";
		$descAccount = "";
		$amount = "";
		$subLedger = "";
		$codeSubLedger = "";
		$descSubLedger = "";
		$referenceLine = "";
		$profitCenterId = "";
		$profitCenterDesc = "";
		$costCenterId = "";
		$costCenterDesc = "";
		$poNumber = "";
		$tanggalPo = "";
		$kodeBranch = "";
		$namaBranch = "";
		$company_id = "";
		$company_name = "";
		$pembetulan_ke = "";
		$kode_cabang = "";
		$total_baris_kirim = "";

		$ins = true;
		foreach($insert_data as $row_data){
			$element_data = json_decode($row_data['element_data']);
			$docNumber = $row_data['docNumber'];
			$jurnalNumber = $element_data->docNumber;
			$bulanBuku = $element_data->bulanBuku;
			$tahunBuku = $element_data->tahunBuku;
			$tanggalPosting = ($element_data->tanggalPosting) ? date("d-M-y", strtotime($element_data->tanggalPosting)) : '';
			$nomorFaktur = $element_data->nomorFaktur;
			$descriptionHeader = $element_data->descriptionHeader;
			$lineNo = $element_data->lineNo;
			$descJenisTransaksi = $element_data->descJenisTransaksi;
			$account = $element_data->account;
			$descAccount = $element_data->descAccount;
			$amount = $element_data->amount;
			$subLedger = $element_data->subLedger;
			$codeSubLedger = $element_data->codeSubLedger;
			$descSubLedger = $element_data->descSubLedger;
			$referenceLine = $element_data->referenceLine;
			$profitCenterId = $element_data->profitCenterId;
			$profitCenterDesc = $element_data->profitCenterDesc;
			$costCenterId = $element_data->costCenterId;
			$costCenterDesc = $element_data->costCenterDesc;
			$poNumber = $element_data->poNumber;
			$tanggalPo = ($element_data->tanggalPo) ? date("d-M-y", strtotime($element_data->tanggalPo)) : '';
			$company_id = $element_data->company_id;
			$company_name = $element_data->company_name;
			$status_message = $row_data['statusMessage']; //sukses atau error
			$status = $row_data['status']; // S atau E
			$pembetulan_ke = $row_data['pembetulan_ke'];
			$kode_cabang = $row_data['kode_cabang'];
			$total_baris_kirim = $row_data['total_baris_kirim'];

			if($total_baris_kirim != 0){
				$sql = "Insert into SIMTAX_H2H_STAGING (
					DOCNUMBER,
					JOURNALNUMBER,
					TAHUN_BUKU,
					BULAN_BUKU,
					TANGGALPOSTING,
					NO_FAKTUR_PAJAK,
					DESCRIPTIONHEADER,
					LINENO,
					DESCJENISTRANSAKSI,
					ACCOUNT,
					DESCACCOUNT,
					AMOUNT,
					SUBLEDGER,
					CODESUBLEDGER,
					DESCSUBLEDGER,
					REFERENCELINE,
					PROFITCENTER,
					PROFITCENTERDESC,
					COSTCENTER,
					COSTCENTERDESC,
					PONUMBER,
					TANGGALPO,
					COMPANY_ID,
					COMPANY_NAME,
					STATUS_KIRIM,
					KETERANGAN,
					JENIS_PAJAK
					) 
					 values (
						 '".$docNumber."',
						 '".$jurnalNumber."',
						 ".$tahunBuku.",
						 ".$bulanBuku.",
						 '".$tanggalPosting."',
						 '".$nomorFaktur."',
						 '".$descriptionHeader."',
						 ".$lineNo.",
						 '".$descJenisTransaksi."',
						 '".$account."',
						 '".$descAccount."',
						  ".$amount.",
						 '".$subLedger."',
						 '".$codeSubLedger."',
						 '".$descSubLedger."',
						 '".$referenceLine."',
						 '".$profitCenterId."',
						 '".$profitCenterDesc."',
						 '".$costCenterId."', 
						 '".$costCenterDesc."',
						 '".$poNumber."',
						 '".$tanggalPo."',
						 ".$company_id.",
						 '".$company_name."',
						 '".$status."',
						 '".$status_message."',
						 '".$jenispajak."'
					)";
				}
			
			try {
				$query = $this->db->query($sql);
				if($query){
					$ins =true;
				} else {
					return false;
				}	
			} catch (Exception $ex) {
				return false;
			}	
		}

		if($total_baris_kirim != 0){
			$vstatuskirim = 'T';
			$vketerangan = 'Terkirim';
		} else {
			$vstatuskirim = 'K';
			$vketerangan = 'Data Kosong';
		}
		if($ins){
			$sqllog = "Insert into SIMTAX_H2H_STAGING_LOG (
				DOCNUMBER,
				KODE_CABANG,
				PAJAK,
				JENIS_PAJAK,
				BULAN_PAJAK,
				TAHUN_PAJAK,
				PAJAK_HEADER_ID,
				TANGGAL_KIRIM,
				STATUS_KIRIM,
				KETERANGAN,
				PENGIRIM,
				TOTAL_BARIS_KIRIM,
				PEMBETULAN) 
				 values (
					 '".$docNumber."',
					 '".$kode_cabang."',
					 '".$pajak."',
					 '".$jenispajak."',
					 ".$bulan.",
					 ".$tahun.",
					 '',
					 sysdate,
					 '".$vstatuskirim."',
					 '".$vketerangan."',
					 '".$user."',
					  ".$total_baris_kirim.",
					 '".$pembetulan_ke."')";
					 		
				$query = $this->db->query($sqllog);
				if($query){
					$ins = true;
				} else {
					return false;
				}	
		} else {
			return false;
		}

		return $ins;
		
  }

  function get_data_tara($pajak_header_id="", $kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $jenis_dokumen, $creditable="", $groupByInvoiceNUm=false)
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

		$whereStatus = " AND UPPER(SPH.STATUS) NOT IN ('DRAFT', 'REJECT SUPERVISOR')";

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
							abs(SPL.JUMLAH_POTONG) JUMLAH_POTONG_PPN,
							sdjt.docnumber
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
						  left join simtax_detail_jurnal_transaksi sdjt
							          on sdjt.invoice_id = spl.invoice_id		  
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

			if($jenis_dokumen == "dokumen_lain"){
				$conDokLain = " no_dokumen_lain";
			}
			else{
				$conDokLain = " no_faktur_pajak";
			}

	        $mainQuery    = "SELECT * from  
	                        (select spl.*,
			                        nvl(nvl(substrb(spl.no_faktur_pajak,3,1),''), nvl(substrb(spl.no_dokumen_lain,3,1),'')) fg_pengganti_new,
			                        skc.nama_cabang, sdjt.docnumber,
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
							   left join simtax_detail_jurnal_transaksi sdjt
							          on sdjt.invoice_id = spl.invoice_id		  
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

	function get_cabang_in_header_tara($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke){

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

	function get_pajak_header_id_tara($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke=""){

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

	function action_refresh_tara($username,$password,$rme,$base_url,$params){

		$url = $base_url.'api/v1/sign-in';
		$params_string = json_encode($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($params_string),
				'User-Agent: Mozilla/5.0')                                                                       
		);   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		$request = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if($httpCode === 200)
		{
			
			$result = json_decode($request, true);
			$token_type = "Bearer ";
			$utoken = $result['id_token'];
			$urlwp = $base_url."api/v1/wps-mine"; 
			
			//GET WP
			$api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
			$data_wp = json_decode($api_response, true);
			$id_wp = "";
			$description_log = "";
			foreach($data_wp as $row_wp){
					$wp_id = $row_wp['id'];
			}
			
			$sql = "SELECT * FROM SIMTAX_TARA_LOG
			WHERE STATUS_LOG_IMPORT NOT IN ('Selesai') AND FILE_ID NOT IN (0)";
			$query = $this->db->query($sql);
			
			if (count($query->result_array())>0){
				foreach($query->result_array() as $row)	{
					$id_import_dm = $row['FILE_ID'];
					//Log Import
					$urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm; 
								
					//GET Log Import
					$api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
					$datalog = json_decode($api_response, true);
					$description_log = $datalog['description'];
						
					 //detil log import
					 $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm."/download"; 
					 $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
					 $jsondatalog = json_decode($dtldatalog, true);
					 $expl_datalog = explode(';', $dtldatalog);
					 
					 $i=23;
					 $cnt_arr = count($expl_datalog);
					 $no=1;
					 $desc_log = "";
					 $txt_log = "";
					 $longtext = "";
			 //end
	
					$idlog = "";
					if(!empty($datalog)){
							$sql = "update simtax_tara_log set STATUS_LOG_IMPORT ='".$datalog['status']."',
							 DELIMITER = '".$datalog['delimiter']."',
							TOTAL = ".$datalog['total'].", JUMLAH_ERROR_IMPORT = ".$datalog['error'].", JUMLAH_SUKSES_IMPORT = ".$datalog['count']."
							where WP_ID = ".$datalog['wpId']." and FILE_ID = ".$id_import_dm
							;
							
							$query = $this->db->query($sql);
							if (!$query){
								echo '2';
								curl_close($ch);
							}
					}
					//End Import Log
	
				}
				echo '1';
				curl_close($ch);
			} else {
				echo '1';
				curl_close($ch);
			}
			
		} else {
			echo '3';
			curl_close($ch);
		}
		
	}

	function get_master_cabang()
	{
		$cabang				= $this->kode_cabang;
		$where				= "";
		if ($cabang!='000'){
			$where	.=" and kode_cabang='".$cabang."' ";
		}
		$queryExec	        = "Select * from simtax_kode_cabang where 1=1 ".$where." and upper(aktif)='Y' order by kode_cabang";
		$query 		        = $this->db->query($queryExec);
		$result['query']	= $query;
		return $result;		
	}	

	function getValueParameter($param) {

		$this->db->select('VALUE');
		$this->db->from('SIMTAX_CONFIG_TARA');
		$this->db->where('PARAMETER', $param);
		$query = $this->db->get();
		$value	= $query->row()->VALUE;

		return $value;

	}

	function get_data_detail_jurnal($kode_cabang="", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke)
	{

		if($kode_cabang != ""){
			$whereCabang	= " and kode_cabang = '".$kode_cabang."'";
		}
		if($nama_pajak != ""){
			$wherePajak	= " and pajak = '".$nama_pajak."'";
			if ($nama_pajak == 'PPN MASUKAN'){
				$whereAccount = " and account = '10901601'";
			} else {
				$whereAccount = " and account = '30901601'";
			}
		}
		if($jenis_pajak != ""){
			$whereJnsPajak	= " and jenis_pajak = '".$jenis_pajak."'";
		}
		if($bulan_pajak != ""){
			$whereBulan	= " and bulan_buku = ".$bulan_pajak;
		}
		if($tahun_pajak != ""){
			$whereTahun = " and tahun_buku = ".$tahun_pajak;
		}
		if($pembetulan_ke != ""){
			$wherePembetulan = " and pembetulan = '".$pembetulan_ke."'";
		}

		$mainQuery = "SELECT 
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
						KODE_CABANG
					FROM  
					SIMTAX_DETAIL_JURNAL_TRANSAKSI
					WHERE 1=1 and (amount is not null or amount > 0)
					".$whereAccount.$whereCabang.$whereBulan.$whereTahun."
				";
		$query = $this->db->query($mainQuery);
		return $query;
	
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
					        WHERE 1=1 and (amount is not null or amount > 0)
						".$where.$qnama_pajak.$whereCabang.$whereBulan.$whereTahun;

		$query = $this->db->query($sql);
		return $query;
	}

	function get_data_log($senderid, $journalnumber){
		$wheresender ="";
		$wherejournalnumber = "";

		if($senderid != ""){
			$wheresender = " and a.docnumber = '".$senderid."' ";
		}

		if($journalnumber != "x"){
			$wherejournalnumber = "and a.journalnumber = '".$journalnumber."' ";
		}
		$sql	=  "SELECT 
							a.journalnumber, a.lineno, b.bulan_pajak, b.tahun_pajak
                            FROM SIMTAX_H2H_STAGING a
							LEFT JOIN SIMTAX_H2H_STAGING_LOG b
							on b.docnumber = a.docnumber
					        WHERE 1=1 
							".$wheresender.$wherejournalnumber."
							and journalnumber is not null
					";
		
		$query = $this->db->query($sql);
		return $query;
	}


}