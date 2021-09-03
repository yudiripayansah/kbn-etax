<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class H2h_staging extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}
		$this->load->model('H2h_staging_mdl', 'h2h');
                $this->load->model('ppn_masa_mdl', 'ppn_masa');
		$this->load->model('Cabang_mdl');
                $this->load->model('ppnmasa_detail_jurnal_mdl', 'ppnmasa_jurnal');
                $this->daftar_pajak = array("PPN MASUKAN", "PPN KELUARAN");
                $this->pajakku = array("PPN MASA", "DETAIL JURNAL", "ALL");
                $this->load->model('Tara_pajakku_mdl', 'tara');
	}	

        function show_h2h()
	{
		$this->template->set('title', 'H2H Pelindo Raya');
		$data['subtitle']   = "H2H Pelindo Raya";
		$data['activepage'] = "lap_pajakku";
		$data['error']      = "";
		$data['kantor_cabang'] = "cabang";
                $data['nama_pajak']    = $this->pajakku[2];
		$this->template->load('template', 'h2h_staging/h2h_p3pajakku',$data);
	}

        function show_staging_ppnmasa()
	{
		$this->template->set('title', 'H2H Ppn Masa Staging');
		$data['subtitle']   = "H2H Ppn Masa Staging";
		$data['activepage'] = "lap_pajakku";
		$data['error']      = "";
		$data['kantor_cabang'] = "cabang";
                $data['nama_pajak']    = $this->pajakku[0];
		$this->template->load('template', 'h2h_staging/h2h_p3staging',$data);
	}

        function show_staging_detailjurnal()
	{
		$this->template->set('title', 'H2H Detail Jurnal Transaksi Staging');
		$data['subtitle']   = "H2H Detail Jurnal Transaksi Staging";
		$data['activepage'] = "lap_pajakku";
		$data['error']      = "";
		$data['kantor_cabang'] = "cabang";
                $data['nama_pajak']    = $this->pajakku[1];
		$this->template->load('template', 'h2h_staging/h2h_p3staging',$data);
	}
	
        function load_master_pajak($_pajakku)
        {
                $_pajakku = str_replace("%20"," ",$_pajakku);
                $ppnmasa = str_replace(" ","",$this->pajakku[0]);
                $hasil	= $this->tara->get_master_pajak();
                $query 	= $hasil['query'];			
                $result = "";
                $result .= "<option value='' data-name='' > Pilih Pajak </option>";
                                foreach($query->result_array() as $row)	{
                                    if (($ppnmasa == $row['KELOMPOK_PAJAK'] && $this->pajakku[0] == $_pajakku) || ($ppnmasa == $row['KELOMPOK_PAJAK'] && $_pajakku == "ALL")){
                                        $result .= "<option value='".$row['KELOMPOK_PAJAK']."' data-name='".$row['KELOMPOK_PAJAK']."' >".$row['KELOMPOK_PAJAK']."</option>";
                                    } 
                                }	
                                
                                if($this->pajakku[1] == $_pajakku || $_pajakku == "ALL"){
                                    $result .= "<option value='DETAILJT' data-name='DETAIL JURNAL TRANSAKSI' >DETAIL JURNAL TRANSAKSI</option>";	
                                }
                echo $result;
                $query->free_result();
        }

        function load_tarra_cabang()
        {
                $this->kode_cabang  = $this->session->userdata('kd_cabang');
		$hasil	= $this->tara->get_master_cabang();
                $query 		= $hasil['query'];			
                $result ="";
                
                if ($this->kode_cabang != '000'){
                        $result ="";
                } else {
                        $result .= "<option value='' data-name='' > Pilih Cabang </option>";
                }
                foreach($query->result_array() as $row)	{
                        $result .= "<option value='".$row['KODE_CABANG']."' data-name='".$row['NAMA_CABANG']."' >".$row['NAMA_CABANG']."</option>";
                }		
                echo $result;
                $query->free_result();
        }


        function load_log_staging()
        {
           $hasil	=$this->h2h->get_log_staging();
           $rowCount	= $hasil['jmlRow'] ;
           $query 	= $hasil['query'];	
           
                if ($rowCount>0){
                   $ii	= 0;
                        foreach($query->result_array() as $row)	{ 
                           $ii++;	
                           $bulan = "";
                           $statuskirim = "";
                           switch ($row['BULAN_PAJAK']) {
                                case 1:
                                $bulan = "JANUARI";
                                break;
                                case 2:
                                $bulan = "FEBRUARI";
                                break;
                                case 3:
                                $bulan = "MARET";
                                break;
                                case 4:
                                $bulan = "APRIL";
                                break;
                                case 5:
                                $bulan = "MEI";
                                break;
                                case 6:
                                $bulan = "JUNI";
                                break;
                                case 7:
                                $bulan = "JULI";
                                break;
                                case 8:
                                $bulan = "AGUSTUS";
                                break;
                                case 9:
                                $bulan = "SEPTEMBER";
                                break;
                                case 10:
                                $bulan = "OKTOBER";
                                break; 
                                case 11:
                                $bulan = "NOVEMBER";
                                break;
                                case 12:
                                $bulan = "DESEMBER";
                                break;                     
                           }

                           if ($row['STATUS_KIRIM'] == "S"){
                                $statuskirim = 'Sukses';
                           } else if ($row['STATUS_KIRIM'] == "T") {
                                $statuskirim = 'Terkirim';
                           } else if ($row['STATUS_KIRIM'] == "E") {
                                $statuskirim = 'Error';
                           } else {
                                $statuskirim = 'Kosong';   
                           }
                
                           $result['data'][] = array(
                                'no'			        => $row['RNUM'],
                                'idlog'		                => $row['IDLOG'],
                                'docnumber'		        => $row['DOCNUMBER'],
                                'kode_cabang' 		        => $row['KODE_CABANG'], 
                                'nama_cabang' 		        => $row['NAMA_CABANG'], 
                                'pajak'			        => $row['PAJAK'],
                                'jenis_pajak'	                => $row['JENIS_PAJAK'],
                                'bulan_pajak'		        => $bulan,
                                'tahun_pajak'	                => $row['TAHUN_PAJAK'],
                                'tanggal_kirim'	                => $row['TANGGAL_KIRIM'],
                                'status_kirim'	                => $statuskirim,
                                'keterangan' 	                => $row['KETERANGAN'],
                                'pengirim' 		        => $row['PENGIRIM'], 
                                'npwp' 		                => $row['NPWP'] ? $row['NPWP'] : '-',
                                'total_baris_kirim' 		=> $row['TOTAL_BARIS_KIRIM'],
                                'pembetulan' 		        => $row['PEMBETULAN'],
                                'pajak_header_id'		=> $row['PAJAK_HEADER_ID'],
                                'is_creditable' 		=> $row['IS_CREDITABLE'] ? $row['IS_CREDITABLE'] : '-',    
                           );
                        }
                        
                        $query->free_result();
                        
                        $result['draw']			= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
                        $result['recordsTotal']		= $rowCount;
                        $result['recordsFiltered'] 	= $rowCount;
                        
                } else {
                        $result['data'] 			= "";
                        $result['draw']				= "";
                        $result['recordsTotal']		= 0;
                        $result['recordsFiltered'] 	= 0;
                }	
                echo json_encode($result);
        }

        function load_staging()
        {
           $nama_pajak  = $this->input->post('_searchPajakku');
           if($nama_pajak == $this->pajakku[0]){
                $nama_pajak = $this->pajakku[0];
           }
           else{
                $nama_pajak = $this->pajakku[1];
           }

           $hasil	=$this->h2h->get_data_staging($nama_pajak);
           $rowCount	= $hasil['jmlRow'] ;
           $query 	= $hasil['query'];	
           
                if ($rowCount>0){
                   $ii	= 0;
                        foreach($query->result_array() as $row)	{ 
                           $ii++;	
                           $bulan = "";
                           $statuskirim = "";
                           switch ($row['MASA_PENGKREDITAN']) {
                                case 1:
                                $bulan = "JANUARI";
                                break;
                                case 2:
                                $bulan = "FEBRUARI";
                                break;
                                case 3:
                                $bulan = "MARET";
                                break;
                                case 4:
                                $bulan = "APRIL";
                                break;
                                case 5:
                                $bulan = "MEI";
                                break;
                                case 6:
                                $bulan = "JUNI";
                                break;
                                case 7:
                                $bulan = "JULI";
                                break;
                                case 8:
                                $bulan = "AGUSTUS";
                                break;
                                case 9:
                                $bulan = "SEPTEMBER";
                                break;
                                case 10:
                                $bulan = "OKTOBER";
                                break; 
                                case 11:
                                $bulan = "NOVEMBER";
                                break;
                                case 12:
                                $bulan = "DESEMBER";
                                break;                     
                           }
                           
                           $result['data'][] = array(
                                'docnumber'			=> $row['DOCNUMBER'],
                                'journalnumber'		        => $row['JOURNALNUMBER'],
                                'tahun_buku'		        => $row['TAHUN_BUKU'],
                                'kd_jenis_transaksi' 		=> $row['KD_JENIS_TRANSAKSI'], 
                                'fg_pengganti' 		        => $row['FG_PENGGANTI'], 
                                'no_faktur_pajak'               => $row['NO_FAKTUR_PAJAK'],
                                'tanggal_faktur_pajak'	        => $row['TANGGAL_FAKTUR_PAJAK'],
                                'npwp'		                => $row['NPWP'],
                                'nama_wp'	                => $row['NAMA_WP'],
                                'alamat_wp'	                => $row['ALAMAT_WP'],
                                'dpp'	                        => $row['DPP'],
                                'jumlah_ppn' 	                => $row['JUMLAH_PPN'],
                                'jumlah_ppnbm' 		        => $row['JUMLAH_PPNBM'], 
                                'masa_pengkreditan' 		=> $bulan,
                                'tahun_pengkreditan' 		=> $row['TAHUN_PENGKREDITAN'],
                                'referensi' 		        => $row['REFERENSI'],
                                'kode_cabang'		        => $row['KODE_CABANG'],
                                'nama_cabang' 		        => $row['NAMA_CABANG'], 
                                'status_transaksi'		=> $row['STATUS_TRANSAKSI'],   
                                'company_id'		        => $row['COMPANY_ID'], 
                                'company_name'		        => $row['COMPANY_NAME'], 
                                'status_kirim'		        => $row['STATUS_KIRIM'], 
                                'keterangan'		        => wordwrap($row['KETERANGAN'],200,"<br>\n"), 
                                'jenis_pajak'		        => $row['JENIS_PAJAK'], 
                                'bulan_buku'		        => $row['BULAN_BUKU'], 
                                'tanggalposting'		=> $row['TANGGALPOSTING'], 
                                'descjenistransaksi'		=> $row['DESCJENISTRANSAKSI'], 
                                'lineno'		        => $row['LINENO'],
                                'account'		        => $row['ACCOUNT'],
                                'descaccount'		        => $row['DESCACCOUNT'],
                                'amount'		        => $row['AMOUNT'],
                                'subledger'		        => $row['SUBLEDGER'],
                                'codesubledger'		        => $row['CODESUBLEDGER'],
                                'descsubledger'		        => $row['DESCSUBLEDGER'],
                                'descriptionheader'		=> $row['DESCRIPTIONHEADER'],
                                'referenceline'		        => $row['REFERENCELINE'],
                                'profitcenter'		        => $row['PROFITCENTER'],
                                'profitcenterdesc'		=> $row['PROFITCENTERDESC'],
                                'costcenter'		        => $row['COSTCENTER'],
                                'costcenterdesc'		=> $row['COSTCENTERDESC'],
                                'ponumber'		        => $row['PONUMBER'],
                                'tanggalpo'		        => $row['TANGGALPO'],
                                'currency'		        => $row['CURRENCY'],
                           );
                           
                        }
                        
                        $query->free_result();
                        
                        $result['draw']			= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
                        $result['recordsTotal']		= $rowCount;
                        $result['recordsFiltered'] 	= $rowCount;
                        
                } else {
                        $result['data'] 			= "";
                        $result['draw']				= "";
                        $result['recordsTotal']		= 0;
                        $result['recordsFiltered'] 	= 0;
                }	
                echo json_encode($result);
        }

        function send_to_staging(){
                $this->kode_cabang  = $this->session->userdata('kd_cabang');
                $username = $this->h2h->getValueParameter("USERNAME_P2");
                $password = $this->h2h->getValueParameter("PASSWORD_P2");
                $base_url = $this->h2h->getValueParameter("BASE_URL_P2");
 
                $params= array(
                        "Username" => $username,
                        "Password" => $password
                );

                $bulan_pajak = $this->input->post('bulan');
                $tahun_pajak = $this->input->post('tahun');
                $pajak = $this->input->post('pajak');
                $nama_pajak = $this->input->post('jenisPajak');
                $kode_cabang   = $this->input->post('cabang_trx');
                $pembetulan_ke = $this->input->post('pembetulanKe');
                $creditable = "xx";
                $withAkun = "";

                if($pajak === 'PPNMASA'){
                    if($nama_pajak === "PPN MASUKAN"){
                        $this->send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","creditable",$withAkun);
                        $this->send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","not_creditable",$withAkun);
                    } else if ($nama_pajak === "PPN KELUARAN") {    
                        $this->send_to_staging_fk($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","");
                    } else if ($nama_pajak === "DOKUMEN LAIN MASUKAN"){
                        $nama_pajak = 'PPN MASUKAN';    
                        $this->send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                    } else {  
                        $nama_pajak = 'PPN KELUARAN';        
                        $this->send_to_staging_fk($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                    }
                } else {
                    $this->send_to_staging_djt($username,$password,$path,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"","");
                }
                 
        }

        function send_to_staging_fk($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');

                $url = $base_url.'pajak/login';
                $params_string = json_encode($params);
        
                $request = $this->getToken($url, $params_string);
                $el_request = json_decode($request['request']);
               
                if($request['httpcode'] == 200)
                {
                        //$result = json_decode($request, true);
                        $token_type = "Bearer ";
                        $utoken = $el_request->token_jwt;
                        $comp_id = $el_request->company_id;
                        $comp_name = $el_request->company_name;
                        $apifk = $base_url."pajak/faktur-keluaran"; 
                        
                        //Create data
                        $date           = date("Ymdhis", time());
                        
                        $get_pajak_header_id = $this->h2h->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        $data                = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang          = $this->h2h->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        
                        $insert_log['PAJAK_HEADER_ID'] = $pajak_header_id;
                       
                        $nama_cabangArr = array();
                        foreach ($get_cabang as $value) {
                           $nama_cabangArr[$value->KODE_CABANG] = str_replace(" ","",get_nama_cabang($value->KODE_CABANG));
                        }
                        ksort($nama_cabangArr);
                         
                        if($nama_pajak == "PPN KELUARAN"){
                           if($category == "dokumen_lain"){
                              $tileDMFM = "DK";
                           }
                           else{
                              $tileDMFM = "FK";
                           }
                        }

                        $adaEfaktur = false;
                        
                        if (!empty($data) && count($data->result_array())>0 ) {

                           $pushDokLain = true;
                           $j = 0;
                           
                           foreach($data->result_array() as $row) {
                                
                                $tanggal_dokumen_lain = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("d/m/Y", strtotime($row['TANGGAL_DOKUMEN_LAIN'])) : '';
                                $tanggal_approval     = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("Ymdhis", strtotime($row['TANGGAL_DOKUMEN_LAIN']))."000000" : '';
                                $tanggal_faktur       = ($row['TANGGAL_FAKTUR_PAJAK']) ? date("Y-m-d", strtotime($row['TANGGAL_FAKTUR_PAJAK'])) : '';
                                
                                $val_fg_pengGanti     = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];
                                $kd_jenis_transaksi   = ($row['KD_JENIS_TRANSAKSI'] == "") ? "" : sprintf("%02d", $row['KD_JENIS_TRANSAKSI']);
                                $fg_pengganti         = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];

                                if($nama_pajak == $this->daftar_pajak[0]){
                                   if($category == "dokumen_lain"){
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 2;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 5;
                                   }
                                   else{
                                        $val_jenis_transaksi = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                   }
                                }
                                else{
                                   if($category == "dokumen_lain"){
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 5;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                   }
                                   else{
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                    }
                                }
        
                                $ppnNya     = $row['JUMLAH_POTONG_PPN'];
                                $dppNya     = $row['DPP'];
                                $invoiceNya = $row['INVOICE_NUM'];

                                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                                        $pushDokLain = false;
                                        if(!empty($dupInvoice)){
                                                if(in_array(strtolower($invoiceNya), $dupInvoice['INVOICE_NUM'][$j])){
                                                        if($invoiceNya != $lastInv){
                                                                $ppnNya      = $dupInvoice['JUMLAH_POTONG_PPN'][$j];
                                                                $dppNya      = $dupInvoice['JUMLAH_DPP'][$j];
                                                                $pushDokLain = true;
                                                                $j++;
                                                        }
                                                        $lastInv = $row['INVOICE_NUM'];
                                                }
                                                else{
                                                        $pushDokLain = true;
                                                }
                                        } else {
                                                $pushDokLain = true;
                                        }     
                                }
        
                                //$npwp = format_npwp($row['NPWP1'], false);
                                $npwp = format_npwp($row['NPWP1']);
                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];

                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                $address = str_replace(' ',' ',$address);
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));
        
                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                                //$alamatNya = substr($alamatNya,0,60);

                                $no_faktur = ($row['NO_FAKTUR_PAJAK'] != "") ? str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))) : $row['NO_DOKUMEN_LAIN']; 
                                $vtanggal_faktur = ($tanggal_faktur != "") ? $tanggal_faktur : $tanggal_dokumen_lain;
                                
                                $vstatusTransaksi = $this->checkStatusTransaksi($row['FG_PENGGANTI'],$row['NO_DOKUMEN_LAIN'],$row['NO_DOKUMEN_LAIN_GANTI'],$row['BULAN_PAJAK'],$row['TAHUN_PAJAK']);
                                if($vstatusTransaksi === ""){
                                    echo "5";
                                    return;    
                                }
                                if($pushDokLain){
                                        $element_data = array(
                                                "docNumber" => $row['DOCNUMBER'],
                                                "tahunBuku" => $row['TAHUN_PAJAK'],
                                                "kdTransaksi" => $kd_jenis_transaksi,
                                                "fgPengganti" => $fg_pengganti,
                                                "nomorFaktur" => $no_faktur,
                                                "tanggalFaktur" => $vtanggal_faktur,
                                                "npwpPembeli" => $npwp,
                                                "namaPembeli" => $row['VENDOR_NAME'],
                                                "alamatPembeli" => $alamatNya,
                                                "jumlahDpp" => $row['DPP'],
                                                "jumlahPpn" => $row['JUMLAH_POTONG_PPN'],
                                                "jumlahPpnbm" => ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                "referensi" => $row['REFERENSI'],
                                                "nikPembeli" => null,
                                                "kodeBranch" => $kode_cabang,
                                                "namaBranch" => $row['NAMA_CABANG'],
                                                "idCurrency" => $row['INVOICE_CURRENCY_CODE'],
                                                "fgUangmuka" => $row['FG_UANG_MUKA'],
                                                "uangMukadpp" => $row['UANG_MUKA_DPP'],
                                                "uangMukappn" => $row['UANG_MUKA_PPN'],
                                                "uangMukappnbm" => $row['UANG_MUKA_PPNBM'],
                                                "jenisFaktur" => $tileDMFM,
                                                "nomorFakturAsal" => $row['FAKTUR_ASAL'],
                                                "statusTransaksi" => $vstatusTransaksi,
                                                "company_id" => $comp_id,
                                                "company_name" => $comp_name
                                             );
                                        $element_data_str_dk[] = json_encode($element_data);
                                }
                                
                                if($nama_pajak == "PPN KELUARAN"){
                                   if($row['E_FAKTUR'] != 'keluaran' ){
                                        $element_data = array(
                                                "docNumber" => $row['DOCNUMBER'],
                                                "tahunBuku" => $row['TAHUN_PAJAK'],
                                                "kdTransaksi" => $kd_jenis_transaksi,
                                                "fgPengganti" => $fg_pengganti,
                                                "nomorFaktur" => $no_faktur,
                                                "tanggalFaktur" => $vtanggal_faktur,
                                                "npwpPembeli" => $npwp,
                                                "namaPembeli" => $row['VENDOR_NAME'],
                                                "alamatPembeli" => $alamatNya,
                                                "jumlahDpp" => $row['DPP'],
                                                "jumlahPpn" => $row['JUMLAH_POTONG_PPN'],
                                                "jumlahPpnbm" => ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                "referensi" => $row['REFERENSI'],
                                                "nikPembeli" => null,
                                                "kodeBranch" => $kode_cabang,
                                                "namaBranch" => $row['NAMA_CABANG'],
                                                "idCurrency" => $row['INVOICE_CURRENCY_CODE'],
                                                "fgUangmuka" => $row['FG_UANG_MUKA'],
                                                "uangMukadpp" => $row['UANG_MUKA_DPP'],
                                                "uangMukappn" => $row['UANG_MUKA_PPN'],
                                                "uangMukappnbm" => $row['UANG_MUKA_PPNBM'],
                                                "jenisFaktur" => $tileDMFM,
                                                "nomorFakturAsal" => $row['FAKTUR_ASAL'],
                                                "statusTransaksi" => $vstatusTransaksi,
                                                "company_id" => $comp_id,
                                                "company_name" => $comp_name
                                             );
                                        $element_data_str[] = json_encode($element_data);
                                   }
                                   else {
                                           $adaEfaktur = true;
                                           $arrjson = "";
                                           $arrjson = $row['JSON_KELUARAN'];
                                           $arrjson = json_decode($arrjson);
                                           if ($row['SOURCE_DATA'] == 'CSV'){
                                                $element_data1 = array(
                                                   "docNumber" => $row['DOCNUMBER'],
                                                   "tahunBuku" => $row['TAHUN_PAJAK'],
                                                   "kdTransaksi" => $kd_jenis_transaksi,
                                                   "fgPengganti" => $fg_pengganti,
                                                   "nomorFaktur" => $no_faktur,
                                                   "tanggalFaktur" => $vtanggal_faktur,
                                                   "npwpPembeli" => $npwp,
                                                   "namaPembeli" => $row['VENDOR_NAME'],
                                                   "alamatPembeli" => $alamatNya,
                                                   "jumlahDpp" => $row['DPP'],
                                                   "jumlahPpn" => $row['JUMLAH_POTONG_PPN'],
                                                   "jumlahPpnbm" => ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                   "referensi" => $row['REFERENSI'],
                                                   "nikPembeli" => null,
                                                   "kodeBranch" => $kode_cabang,
                                                   "namaBranch" => $row['NAMA_CABANG'],
                                                   "idCurrency" => $row['INVOICE_CURRENCY_CODE'],
                                                   "fgUangmuka" => $row['FG_UANG_MUKA'],
                                                   "uangMukadpp" => $row['UANG_MUKA_DPP'],
                                                   "uangMukappn" => $row['UANG_MUKA_PPN'],
                                                   "uangMukappnbm" => $row['UANG_MUKA_PPNBM'],
                                                   "jenisFaktur" => $tileDMFM,
                                                   "nomorFakturAsal" => $row['FAKTUR_ASAL'],
                                                   "statusTransaksi" => $vstatusTransaksi,
                                                   "company_id" => $comp_id,
                                                   "company_name" => $comp_name
                                                );
                                                $element_data_str1[] = json_encode($element_data1);
                                           }
                                     }
                                }
                           }
                          
                           $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));
                           $add_push_element = array();

                           if($category == "dokumen_lain"){
                                // data dokumen lain   
                                $cntarr = count($element_data_str_dk);   
                                for($i=0;$i<=($cntarr-1);$i++){
                                   $row_temp = array();  
                                   $resfk = $this->import_faktur_keluaran($apifk, $element_data_str_dk[$i], $token_type, $utoken);
                                   
                                   $row_temp['element_data'] = $element_data_str_dk[$i];
                                   $row_temp['docNumber'] = $date;
                                   $statusmessage = str_replace("'", '', $resfk["statusMessage"]);
                                   $row_temp['statusMessage'] = $statusmessage;
                                   $row_temp['status'] = $resfk["status"];
                                   $row_temp['pajak_header_id'] = $pajak_header_id;
                                   $row_temp['creditable'] = 'not_creditable';
                                   $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                   $row_temp['kode_cabang'] =  $kode_cabang;
                                   $row_temp['total_baris_kirim'] =  $cntarr;
                                   $add_push_element[] = $row_temp;
                                } 
                           } else {
                                // data Faktur      
                                if ($adaEfaktur == true){
                                        $cntarr = count($element_data_str1);   
                                        for($i=0;$i<=($cntarr-1);$i++){
                                           $row_temp = array();  
                                           $resfk = $this->import_faktur_keluaran($apifk, $element_data_str1[$i], $token_type, $utoken);
                                           
                                           $row_temp['element_data'] = $element_data_str1[$i];
                                           $row_temp['docNumber'] = $date;
                                           $statusmessage = str_replace("'", '', $resfk["statusMessage"]);
                                           $row_temp['statusMessage'] = $statusmessage;
                                           $row_temp['status'] = $resfk["status"];
                                           $row_temp['pajak_header_id'] = $pajak_header_id;
                                           $row_temp['creditable'] = 'not_creditable';
                                           $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                           $row_temp['kode_cabang'] =  $kode_cabang;
                                           $row_temp['total_baris_kirim'] =  $cntarr;
                                           $add_push_element[] = $row_temp;
                                        } 
                                        
                                   } else {
                                        $cntarr = count($element_data_str);   
                                        for($i=0;$i<=($cntarr-1);$i++){
                                           $resfk = $this->import_faktur_keluaran($apifk, $element_data_str[$i], $token_type, $utoken);
                                         
                                           $row_temp['element_data'] = $element_data_str[$i];
                                           $row_temp['docNumber'] = $date;
                                           $statusmessage = str_replace("'", '', $resfk["statusMessage"]);
                                           $row_temp['statusMessage'] = $statusmessage;
                                           $row_temp['status'] = $resfk["status"];
                                           $row_temp['pajak_header_id'] = $pajak_header_id;
                                           $row_temp['creditable'] = 'not_creditable';
                                           $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                           $row_temp['kode_cabang'] =  $kode_cabang;
                                           $row_temp['total_baris_kirim'] =  $cntarr;
                                           $add_push_element[] = $row_temp;
                                        } 
                                   }
                           }

                           //curl_close($ch);
                           $ins_log = $this->h2h->insertLog($add_push_element);
                           if($ins_log){
                                echo '1';
                           } else {
                                echo '2';   
                           }
                           
                        }  else {
                           //Jika data kosong masukan juga ke log staging     
                           $row_temp = array();
                           $add_push_element = array();    
                           
                             $element_data = array(
                                "docNumber" => $tileDMFM."XXXXXX",
                                "tahunBuku" => $tahun_pajak,
                                "kdTransaksi" => 0,
                                "fgPengganti" => 0,
                                "nomorFaktur" => "",
                                "tanggalFaktur" => "",
                                "npwpPembeli" => "",
                                "namaPembeli" => "",
                                "alamatPembeli" => "",
                                "jumlahDpp" => 0,
                                "jumlahPpn" => 0,
                                "jumlahPpnbm" => 0,
                                "referensi" => "",
                                "nikPembeli" => "",
                                "kodeBranch" => $kode_cabang,
                                "namaBranch" => "",
                                "idCurreny" => "",
                                "statusTransaksi" => 0,
                                "company_id" => $comp_id,
                                "company_name" => $comp_name
                             );

                             $element_data_str = json_encode($element_data);
                           
                           $row_temp['element_data'] = $element_data_str;
                           $row_temp['docNumber'] = $date;
                           $row_temp['statusMessage'] = "Data Kosong";
                           $row_temp['status'] = "K";
                           $row_temp['pajak_header_id'] = "XXXX";
                           $row_temp['creditable'] = '';
                           $row_temp['pembetulan_ke'] = $pembetulan_ke;
                           $row_temp['kode_cabang'] =  $kode_cabang;
                           $row_temp['total_baris_kirim'] =  0;
                           $add_push_element[] = $row_temp;
                            
                           //curl_close($ch);

                           $ins_log = $this->h2h->insertLog($add_push_element);
                           if($ins_log){
                                echo '22';
                           } else {
                                echo '2';   
                           }
                        }
                
                } else {
                   curl_close($ch);     
                   echo '3';
                }
               
        }

        function send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable,$withAkun)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                $url = $base_url.'pajak/login';
                $params_string = json_encode($params);

                $request = $this->getToken($url, $params_string);
                $el_request = json_decode($request['request']);
                $date = date("Ymdhis", time());
                $tileDMFM = "";
                if($category == "dokumen_lain"){
                    $tileDMFM = "DK";
                } else {
                    $tileDMFM = "FM";    
                }

                if($request['httpcode'] == 200)
                {
                   //$result = json_decode($request, true);
                   $token_type = "Bearer ";
                   $utoken = $el_request->token_jwt;
                   $comp_id = $el_request->company_id;
                   $comp_name = $el_request->company_name;
                   $apifm = $base_url."pajak/faktur-masukan"; 
                        
                   $get_pajak_header_id = $this->h2h->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                   $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                   $data                = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                   $get_cabang          = $this->h2h->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                   
                        if (!empty($data) && count($data->result_array())>0 ) 
                        {    
                           $j = 0;
                           foreach($data->result_array() as $row) {
                                        
                                $tanggal_dokumen_lain = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("d/m/Y", strtotime($row['TANGGAL_DOKUMEN_LAIN'])) : '';
                                $tanggal_approval     = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("Ymdhis", strtotime($row['TANGGAL_DOKUMEN_LAIN']))."000000" : '';
                                $tanggal_faktur       = ($row['TANGGAL_FAKTUR_PAJAK']) ? date("Y-m-d", strtotime($row['TANGGAL_FAKTUR_PAJAK'])) : '';
                                
                                $val_fg_pengGanti     = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];
                                $kd_jenis_transaksi   = ($row['KD_JENIS_TRANSAKSI'] == "") ? "" : sprintf("%02d", $row['KD_JENIS_TRANSAKSI']);
                                $fg_pengganti         = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];
        
                                if($nama_pajak == $this->daftar_pajak[0]){
                                   if($category == "dokumen_lain"){
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 2;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 5;
                                   }
                                   else {
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                   }
                                }
                                else {
                                   if($category == "dokumen_lain"){
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 5;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                   }
                                   else {
                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                   }
                                }
                
                                $ppnNya     = $row['JUMLAH_POTONG_PPN'];
                                $dppNya     = $row['DPP'];
                                $invoiceNya = $row['INVOICE_NUM'];
                
                                $npwp = format_npwp($row['NPWP1']);
                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];

                                $no_faktur = ($row['NO_FAKTUR_PAJAK'] != "") ? str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))) : $row['NO_DOKUMEN_LAIN']; 
                                $vtanggal_faktur = ($tanggal_faktur != "") ? $tanggal_faktur : $tanggal_dokumen_lain;

                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                $address = str_replace(' ',' ',$address);
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));
                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);

                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                                //$alamatNya = substr($alamatNya,0,60);
                                
                                //$vstatusTransaksi = $this->checkStatusTransaksi($row['FG_PENGGANTI'],$row['NO_DOKUMEN_LAIN'],$row['NO_DOKUMEN_LAIN_GANTI'],$row['BULAN_PAJAK'],$row['TAHUN_PAJAK']);
                                //if($vstatusTransaksi === null || $vstatusTransaksi === ""){
                                //    echo "5";
                                //    return;    
                                //}
                                $vstatusTransaksi = 0;

                                if($nama_pajak == "PPN MASUKAN"){
                                   if($category == "dokumen_lain"){
                                        $element_data_dm = array(
                                                "docNumber" => $row['DOCNUMBER'],
                                                "tahunBuku" => $row['TAHUN_PAJAK'],
                                                "kdTransaksi" => $kd_jenis_transaksi,
                                                "fgPengganti" => $fg_pengganti,
                                                "nomorFaktur" => $no_faktur,
                                                "tanggalFaktur" => $vtanggal_faktur,
                                                "npwpPenjual" => $npwp,
                                                "namaPenjual" => $row['VENDOR_NAME'],
                                                "alamatPenjual" => $alamatNya,
                                                "jumlahDpp" => $row['DPP'],
                                                "jumlahPpn" => $row['JUMLAH_POTONG_PPN'],
                                                "jumlahPpnbm" => ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                "masaPengkreditan" => $row['BULAN_PAJAK'],
                                                "tahunPengkreditan" => $row['TAHUN_PAJAK'],
                                                "referensi" => $row['REFERENSI'],
                                                "kodeBranch" => $kode_cabang,
                                                "namaBranch" => $row['NAMA_CABANG'],
                                                "statusTransaksi" => $vstatusTransaksi,
                                                "isCreditable" => $row['IS_CREDITABLE'],
                                                "jenisFaktur" => $tileDMFM,
                                                "company_id" => $comp_id,
                                                "company_name" => $comp_name
                                           );
                                           $element_data_str_dm[] = json_encode($element_data_dm);
                                   } else {
                                           $element_data = array(
                                                "docNumber" => $row['DOCNUMBER'],
                                                "tahunBuku" => $row['TAHUN_PAJAK'],
                                                "kdTransaksi" => $kd_jenis_transaksi,
                                                "fgPengganti" => $fg_pengganti,
                                                "nomorFaktur" => $no_faktur,
                                                "tanggalFaktur" => $vtanggal_faktur,
                                                "npwpPenjual" => $npwp,
                                                "namaPenjual" => $row['VENDOR_NAME'],
                                                "alamatPenjual" => $alamatNya,
                                                "jumlahDpp" => $row['DPP'],
                                                "jumlahPpn" => $row['JUMLAH_POTONG_PPN'],
                                                "jumlahPpnbm" => ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                "masaPengkreditan" => $row['BULAN_PAJAK'],
                                                "tahunPengkreditan" => $row['TAHUN_PAJAK'],
                                                "referensi" => $row['REFERENSI'],
                                                "kodeBranch" => $kode_cabang,
                                                "namaBranch" => $row['NAMA_CABANG'],
                                                "statusTransaksi" => $vstatusTransaksi,
                                                "isCreditable" => $row['IS_CREDITABLE'],
                                                "jenisFaktur" => $tileDMFM,
                                                "company_id" => $comp_id,
                                                "company_name" => $comp_name
                                           );
                                           $element_data_str[] = json_encode($element_data);
                                   }     
                                }
                           }
                           
                           $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));
                           $add_push_element = array();
                           
                           if($nama_pajak == "PPN MASUKAN"){
                              if($category == "dokumen_lain"){
                                  $cntarr = count($element_data_str_dm);     
                                  for($i=0;$i<=($cntarr-1);$i++){      
                                     $resfm = $this->import_faktur_masukan($apifm, $element_data_str_dm[$i], $token_type, $utoken);
                                     $row_temp['element_data'] = $element_data_str_dm[$i];
                                     $row_temp['docNumber'] = $date;
                                     $statusmessage = str_replace("'", '', $resfm["statusMessage"]);
                                     $row_temp['statusMessage'] = $statusmessage;
                                     $row_temp['status'] = $resfm["status"];
                                     $row_temp['pajak_header_id'] = $pajak_header_id;
                                     if($creditable == "xx"){
                                        $creditable = "not_creditable";
                                     }
                                     $row_temp['creditable'] = $creditable;
                                     $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                     $row_temp['kode_cabang'] =  $kode_cabang;
                                     $row_temp['total_baris_kirim'] =  $cntarr;
                                     $add_push_element[] = $row_temp;
                                  }
                              }
                              else {   
                                  $cntarr = count($element_data_str);     
                                  for($i=0;$i<=($cntarr-1);$i++){  
                                       $resfm = $this->import_faktur_masukan($apifm, $element_data_str[$i], $token_type, $utoken);
                                       $row_temp['element_data'] = $element_data_str[$i];
                                       $row_temp['docNumber'] = $date;
                                       $statusmessage = str_replace("'", '', $resfm["statusMessage"]);
                                       $row_temp['statusMessage'] = $statusmessage;
                                       $row_temp['status'] = $resfm["status"];
                                       $row_temp['pajak_header_id'] = $pajak_header_id;
                                       $row_temp['creditable'] = $creditable;
                                       $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                       $row_temp['kode_cabang'] =  $kode_cabang;
                                       $row_temp['total_baris_kirim'] =  $cntarr;
                                       $add_push_element[] = $row_temp;
                                  }
                              }
                          }
                           
                           //curl_close($ch);
                           $ins_log = $this->h2h->insertLog($add_push_element);
                           if($ins_log){
                                echo '1';
                           } else { 
                                echo '2';   
                           }

                        } else {
                            //Jika data kosong masukan juga ke log staging     
                            $row_temp = array();
                            $add_push_element = array();    
                           
                             $element_data = array(
                                "docNumber" => $tileDMFM."XXXXXX",
                                "tahunBuku" => $tahun_pajak,
                                "kdTransaksi" => 0,
                                "fgPengganti" => 0,
                                "nomorFaktur" => "",
                                "tanggalFaktur" => "",
                                "npwpPembeli" => "",
                                "namaPembeli" => "",
                                "alamatPembeli" => 0,
                                "jumlahDpp" => 0,
                                "jumlahPpn" => 0,
                                "jumlahPpnbm" => 0,
                                "masaPengkreditan" => "",
                                "tahunPengkreditan" => "",
                                "referensi" => "",
                                "kodeBranch" => $kode_cabang,
                                "namaBranch" => "",
                                "idCurreny" => "",
                                "statusTransaksi" => 0,
                                "company_id" => $comp_id,
                                "company_name" => $comp_name
                             );

                             $element_data_str = json_encode($element_data);
                           
                            $row_temp['element_data'] = $element_data_str;
                            $row_temp['docNumber'] = $date;
                            $row_temp['statusMessage'] = "Data Kosong";
                            $row_temp['status'] = "K";
                            $row_temp['pajak_header_id'] = "XXXX";
                            $row_temp['creditable'] = "";
                            $row_temp['pembetulan_ke'] = $pembetulan_ke;
                            $row_temp['kode_cabang'] =  $kode_cabang;
                            $row_temp['total_baris_kirim'] =  0;
                            $add_push_element[] = $row_temp;
                            
                            //curl_close($ch);

                            $ins_log = $this->h2h->insertLog($add_push_element);
                            if($ins_log){
                                echo '22';
                            } else {      
                                echo '2';   
                            }
                        }
                        
                } else {
                        //$result = json_decode($request, true);
                        echo '3';
                }
               
        }
                                    
        function send_to_staging_djt($username,$password,$path,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                $url = $base_url.'pajak/login';
                $params_string = json_encode($params);
                $request = $this->getToken($url, $params_string);
                $el_request = json_decode($request['request']);
                $date = date("Ymdhis", time());
                
                if($request['httpcode'] == 200)
                {

                   //$result = json_decode($request, true);
                   $token_type = "Bearer ";
                   $utoken = $el_request->token_jwt;
                   $comp_id = $el_request->company_id;
                   $comp_name = $el_request->company_name;
                   $apidjt = $base_url."pajak/jurnal-akuntansi"; 
                        
                   $data = $this->h2h->get_data_detail_jurnal($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                      
                   if (!empty($data) && count($data->result_array())>0 ) 
                   {
                        $j = 0;
                        foreach($data->result_array() as $row) {
                                $element_data = array(
                                    "docNumber" => $row['DOCNUMBER'],
                                    "bulanBuku" => $row['BULAN_BUKU'],
                                    "tahunBuku" => $row['TAHUN_BUKU'],
                                    "tanggalPosting" => date("Y-m-d", strtotime($row['TANGGALPOSTING'])),
                                    "nomorFaktur" => str_replace(".","", str_replace("-","",substr($row['NOMOR_FAKTUR'], 3))),
                                    "descriptionHeader" => $row['DESCRIPTIONHEADER'],
                                    "lineNo" => $row['LINENO'],
                                    "descJenisTransaksi" => $row['DESCJENISTRANSAKSI'],
                                    "account" => $row['ACCOUNT'],
                                    "descAccount" => $row['DESCACCOUNT'],
                                    "amount" => $row['AMOUNT'],
                                    "subLedger" => $row['SUBLEDGER'],
                                    "codeSubLedger" => $row['CODESUBLEDGER'],
                                    "descSubLedger" => $row['DESCSUBLEDGER'],
                                    "referenceLine" => $row['REFERENCELINE'],
                                    "profitCenterId" => $row['PROFITCENTER'],
                                    "profitCenterDesc" => $row['PROFITCENTERDESC'],
                                    "costCenterId" => $row['COSTCENTER'],
                                    "costCenterDesc" => $row['COSTCENTERDESC'],
                                    "poNumber" => $row['PONUMBER'],
                                    "tanggalPo" => date("Y-m-d", strtotime($row['TANGGALPO'])),
                                    "company_id" => $comp_id,
                                    "company_name" => $comp_name
                                );
                                $element_data_str[] = json_encode($element_data);
  
                        }
                      
                        $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));
                        $add_push_element = array();
                           
                        $cntarr = count($element_data_str);     
                        for($i=0;$i<=($cntarr-1);$i++){  
                                $resjt = $this->jurnal_transaksi($apidjt, $element_data_str[$i], $token_type, $utoken);
                                $row_temp['element_data'] = $element_data_str[$i];
                                $row_temp['docNumber'] = $date;
                                $statusmessage = str_replace("'", '', $resjt["statusMessage"]);
                                $row_temp['statusMessage'] = $statusmessage;
                                $row_temp['status'] = $resjt["status"];
                                $row_temp['pajak_header_id'] = "";
                                $row_temp['creditable'] = "";
                                $row_temp['pembetulan_ke'] = $pembetulan_ke;
                                $row_temp['kode_cabang'] =  $kode_cabang;
                                $row_temp['total_baris_kirim'] =  $cntarr;
                                $add_push_element[] = $row_temp;
                        }
                     
                          //curl_close($ch);
                           $ins_log = $this->h2h->insertLogJt($add_push_element);
                           if($ins_log){
                                echo '1';
                           } else {
                                echo '2';   
                           }
                        
                   } else {
                       //Jika data kosong masukan juga ke log staging     
                       $row_temp = array();
                       $add_push_element = array();    
                      
                        $element_data = array(
                           "docNumber" => "JTXXXXXX",
                           "tahunBuku" => $tahun_pajak,
                           "bulanBuku" => $bulan_pajak,
                           "lineNo" => 0,
                           "amount" => 0,
                           "tanggalPosting" => null,
                           "kdTransaksi" => "",
                           "fgPengganti" => "",
                           "nomorFaktur" => "",
                           "tanggalFaktur" => "",
                           "npwpPembeli" => "",
                           "namaPembeli" => "",
                           "alamatPembeli" => "",
                           "jumlahDpp" => "",
                           "jumlahPpn" => "",
                           "jumlahPpnbm" => "",
                           "referensi" => "",
                           "nikPembeli" => "",
                           "kodeBranch" => $kode_cabang,
                           "namaBranch" => "",
                           "idCurreny" => "",
                           "statusTransaksi" => 0,
                           "company_id" => $comp_id,
                           "company_name" => $comp_name
                        );

                        $element_data_str = json_encode($element_data);
                      
                       $row_temp['element_data'] = $element_data_str;
                       $row_temp['docNumber'] = $date;
                       $row_temp['statusMessage'] = "Data Kosong";
                       $row_temp['status'] = "K";
                       $row_temp['pajak_header_id'] = "XXXX";
                       $row_temp['creditable'] = $creditable;
                       $row_temp['pembetulan_ke'] = $pembetulan_ke;
                       $row_temp['kode_cabang'] =  $kode_cabang;
                       $row_temp['total_baris_kirim'] =  0;
                       $add_push_element[] = $row_temp;
                       
                       //curl_close($ch);

                       $ins_log = $this->h2h->insertLogJt($add_push_element);
                       if($ins_log){
                           echo '22';
                       } else {
                           echo '2';   
                       }    
                   }
                       
                } else {
                        //$result = json_decode($request, true);
                        echo '3';
                }
        }

        function getToken($url, $params_string){
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
                curl_close($ch);

                $result= array(
                        "request" => $request,
                        "httpcode" => $httpCode
                );
                return $result;
        }

        function import_faktur_keluaran($urlfk, $element_data_str, $token_type, $utoken){
                $ch = curl_init();
                curl_setopt_array($ch, array(
                   CURLOPT_URL => $urlfk,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_CUSTOMREQUEST => 'POST',
                   CURLOPT_POSTFIELDS =>$element_data_str,
                   CURLOPT_HTTPHEADER => array(
                      'Authorization: ' .$token_type.$utoken,
                      'Content-Type: application/json'
                   ),
                ));    
                    
                $reqfk = curl_exec($ch);
                $resfk = json_decode($reqfk, true);
                curl_close($ch);

                return $resfk;
        }

        function import_faktur_masukan($urlfm, $element_data_str, $token_type, $utoken){
                $ch = curl_init();
                curl_setopt_array($ch, array(
                   CURLOPT_URL => $urlfm,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_CUSTOMREQUEST => 'POST',
                   CURLOPT_POSTFIELDS =>$element_data_str,
                   CURLOPT_HTTPHEADER => array(
                      'Authorization: ' .$token_type.$utoken,
                      'Content-Type: application/json'
                   ),
                ));    
                    
                $reqfm = curl_exec($ch);
                $resfm = json_decode($reqfm, true);
                curl_close($ch);

                return $resfm;
        }

        function jurnal_transaksi($urljt, $element_data_str, $token_type, $utoken){
                $ch = curl_init();
                curl_setopt_array($ch, array(
                   CURLOPT_URL => $urljt,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_CUSTOMREQUEST => 'POST',
                   CURLOPT_POSTFIELDS =>$element_data_str,
                   CURLOPT_HTTPHEADER => array(
                      'Authorization: ' .$token_type.$utoken,
                      'Content-Type: application/json'
                   ),
                ));    
                    
                $reqfm = curl_exec($ch);
                $resfm = json_decode($reqfm, true);
                curl_close($ch);

                return $resfm;
        }

        function ws_getdata($url, $utoken){
                $ch = curl_init();
                curl_setopt_array($ch, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                          'Authorization: Bearer '.$utoken
                        ),
                ));    
                    
                $reqfm = curl_exec($ch);
                $resfm = json_decode($reqfm, true);
                curl_close($ch);

                return $resfm;
        }

        function getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlwp); 
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);                                                                                                                                     
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Authorization" => $token_type . $utoken,
                        "Host" => $base_url,
                ));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $result = curl_exec($ch);
                
                if(!$result){die("Connection Failure");}
                curl_close($ch);

                return $result; 
        }


        function refresh_tara() {

                $username = $this->h2h->getValueParameter("USERNAME_P2");
                $password = $this->h2h->getValueParameter("PASSWORD_P2");
                $base_url = $this->h2h->getValueParameter("BASE_URL_P2");

                $params= array(
                   "username" => $username,
                   "password" => $password,
                );
                
              $get_refresh =  $this->tara->action_refresh_tara($username,$password,$rme,$base_url,$params);
              return $get_refresh;
        }

        function download_csv_m($category_download, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category, $creditable="", $withAkun = 0)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                $nama_pajak      = str_replace("%20", " ", $nama_pajak);
                if ($kode_cabang == "000"){
                        $category_download = "kompilasi";
                } else {
                        $category_download = "cabang";
                }

                //Create CSV File
                $date           = date("d", time());
                $dokumen_lain   = array();
                $faktur_standar = array();
                
                $groupByInvoiceNUm = false;
                
                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                        $groupByInvoiceNUm = true;
                }

                if($category_download == "kompilasi" && $kode_cabang == "all"){
                        $data       = $this->h2h->get_data_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang = $this->h2h->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        foreach ($get_pajak_header_id as $key => $value) {
                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                        }
                }
                else{
                        $get_pajak_header_id = $this->h2h->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        $data                = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang          = $this->h2h->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                }

                $nama_cabangArr = array();
                foreach ($get_cabang as $value) {
                        $nama_cabangArr[$value->KODE_CABANG] = str_replace(" ","",get_nama_cabang($value->KODE_CABANG));
                }
                ksort($nama_cabangArr);
                
                if($nama_pajak == "PPN MASUKAN"){
                        if($category == "dokumen_lain"){
                                $tileDMFM = "DK_DM";
                        }
                        else{
                                $tileDMFM = "FM";
                        }
                }
                        
                $title_dokumen_lain = array(
                        'DOCNUMBER',
                        'INVOICE_ID',
                        'TAHUN_BUKU',
                        'KD_JENIS_TRANSAKSI',
                        'FG_PENGGANTI',
                        'NOMOR_FAKTUR',
                        'TANGGAL_FAKTUR',
                        'NPWP_PENJUAL',
                        'NAMA_PENJUAL',
                        'ALAMAT_PENJUAL',
                        'JUMLAH_DPP',
                        'JUMLAH_PPN',
                        'JUMLAH_PPNBM',
                        'MASA_PENGKREDITAN',
                        'TAHUN_PENGKREDITAN',
                        'REFERENSI',
                        'KODE_BRANCH',
                        'NAMA_BRANCH',
                        'STATUS_TRANSAKSI',
                        'IS_CREDITABLE',
                        'COMPANY_ID',
                        'COMPANY_NAME'
                );

                if($withAkun == 1){
                        array_shift($title_dokumen_lain); 
                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                }
                        
                if($nama_pajak == "PPN MASUKAN"){

                        $title_faktur_standar = array(
                                'DOCNUMBER',
                                'INVOICE_ID',
                                'TAHUN_BUKU',
                                'KD_JENIS_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NOMOR_FAKTUR',
                                'TANGGAL_FAKTUR',
                                'NPWP_PENJUAL',
                                'NAMA_PENJUAL',
                                'ALAMAT_PENJUAL',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'MASA_PENGKREDITAN',
                                'TAHUN_PENGKREDITAN',
                                'REFERENSI',
                                'KODE_BRANCH',
                                'NAMA_BRANCH',
                                'STATUS_TRANSAKSI',
                                'IS_CREDITABLE',
                                'COMPANY_ID',
                                'COMPANY_NAME'
                        );
                        if($withAkun == 1){
                                array_shift($title_faktur_standar); 
                                array_unshift($title_faktur_standar, $tileDMFM, "AKUN");
                        }
                }
                        
                array_push($dokumen_lain, $title_dokumen_lain);
                array_push($faktur_standar, $title_faktur_standar);
                
                $adaEfaktur = true;
                        
                if (!empty($data) && count($data->result_array()) > 0 ) {
                                
                        $pushDokLain = true;
                        $j = 0;
                        foreach($data->result_array() as $row)	{
                                
                                $tanggal_dokumen_lain = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("d/m/Y", strtotime($row['TANGGAL_DOKUMEN_LAIN'])) : '';
                                $tanggal_approval     = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("Ymdhis", strtotime($row['TANGGAL_DOKUMEN_LAIN']))."000000" : '';
                                $tanggal_faktur       = ($row['TANGGAL_FAKTUR_PAJAK']) ? date("d/m/Y", strtotime($row['TANGGAL_FAKTUR_PAJAK'])) : '';
                                $no_faktur            = str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3)));
                                $val_fg_pengGanti     = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];
                                $kd_jenis_transaksi   = ($row['KD_JENIS_TRANSAKSI'] == "") ? "" : sprintf("%02d", $row['KD_JENIS_TRANSAKSI']);
                                $fg_pengganti         = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];

                                if($nama_pajak == $this->daftar_pajak[0]){
                                        if($category == "dokumen_lain"){
                                                $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 2;
                                                $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 5;
                                        }
                                        else{
                                                $val_jenis_transaksi = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                                $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                }
                                else{
                                        if($category == "dokumen_lain"){
                                           $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 5;
                                           $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                        else{
                                          $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                          $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                }
                                
                                $ppnNya     = $row['JUMLAH_POTONG_PPN'];
                                $dppNya     = $row['DPP'];
                                $invoiceNya = $row['INVOICE_NUM'];
        
                                $npwp = format_npwp($row['NPWP1'], false);
                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];
        
                                $nama_vendor =  str_replace(',',' ',$row['VENDOR_NAME']);
                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                $address = str_replace(' ',' ',$address);
                                $address = str_replace(',',' ',$address);
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));
                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);

                                $no_faktur = ($row['NO_FAKTUR_PAJAK'] != "") ? str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))) : $row['NO_DOKUMEN_LAIN']; 
                                $vtanggal_faktur = ($tanggal_faktur != "") ? $tanggal_faktur : $tanggal_dokumen_lain;

                                if($pushDokLain){
        
                                        $arrDokumenLain = array(
                                            $row['DOCNUMBER'],
                                            $row['INVOICE_ID'],
                                            $row['TAHUN_PAJAK'],
                                            $kd_jenis_transaksi,
                                            $fg_pengganti,
                                            $no_faktur,
                                            $vtanggal_faktur,
                                            $npwp,
                                            $nama_vendor,
                                            $alamatNya,
                                            $row['DPP'],
                                            $row['JUMLAH_POTONG_PPN'],
                                            ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                            $row['BULAN_PAJAK'],
                                            $row['TAHUN_PAJAK'],
                                            $row['REFERENSI'],
                                            $kode_cabang,
                                            $row['NAMA_CABANG'],
                                            "0",
                                            $row['IS_CREDITABLE'],
                                            "2",
                                            "Pelindo 2"
                                        );
        
                                        if($withAkun == 1){
                                                array_shift($arrDokumenLain); 
                                                array_unshift($arrDokumenLain,($nama_pajak == "PPN MASUKAN") ? "DM" : "DK", $row['AKUN_PAJAK']);
                                        }
                                        array_push($dokumen_lain, $arrDokumenLain);
                                }

                                $arrFakturMasukan = array(
                                        $row['DOCNUMBER'],
                                        $row['INVOICE_ID'],
                                        $row['TAHUN_PAJAK'],
                                        $kd_jenis_transaksi,
                                        $fg_pengganti,
                                        $no_faktur,
                                        $vtanggal_faktur,
                                        $npwp,
                                        $nama_vendor,
                                        $alamatNya,
                                        $row['DPP'],
                                        $row['JUMLAH_POTONG_PPN'],
                                        ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                        $row['BULAN_PAJAK'],
                                        $row['TAHUN_PAJAK'],
                                        $row['REFERENSI'],
                                        $kode_cabang,
                                        $row['NAMA_CABANG'],
                                        "0",
                                        $row['IS_CREDITABLE'],
                                        "2",
                                        "Pelindo 2"
                                );

                                array_push($faktur_standar, $arrFakturMasukan);
                        }

                        $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));
                
                        $nama_cabang = array();
                        foreach ($nama_cabangArr as $key => $value) {
                           $nama_cabang[] = $value;
                        }

                        if($category_download == "kompilasi" && $kode_cabang == "all"){
                           $fileName = "Kompilasi_".$tahun_pajak."_".$masa_pajak."_".$pembetulan_ke;
                        }
                        else{
                           $fileName = $tahun_pajak."_".$masa_pajak."_".$pembetulan_ke."_".$nama_cabang[0];
                        }
                        if($nama_pajak == "PPN MASUKAN"){
                           if($category == "dokumen_lain"){
                                convert_to_csv($dokumen_lain, "Dokumen_Masukan_".$fileName.".csv", ";");
                           }
                           else{
                                convert_to_csv($faktur_standar, "Faktur_Masukan_".$fileName.'_'.$creditable.".csv", ";");
                           }
                        }
                } else {
                   if($nama_pajak == "PPN MASUKAN"){
                      $fileName = $tahun_pajak."_".$bulan_pajak."_".$pembetulan_ke."_Data_Kosong";
                      if($category == "dokumen_lain"){
                         convert_to_csv($dokumen_lain, "Dokumen_Lain_Masukan_".$fileName.".csv", ";");
                      }
                      else{
                         convert_to_csv($faktur_standar, "Faktur_Masukan_".$fileName.'_'.$creditable.".csv", ";");
                      }
                   }
                }
        }

        function download_csv_k($category_download, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category, $creditable="", $withAkun = 0)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                $nama_pajak      = str_replace("%20", " ", $nama_pajak);
                $csvfilenamedk = "";
               
                if ($kode_cabang == "000"){
                        $category_download = "kompilasi";
                } else {
                        $category_download = "cabang";
                }

                //Create CSV File
                $date           = date("d", time());
                $dokumen_lain   = array();
                $faktur_standar = array();
                $faktur_standar_efaktur = array();
                
                $groupByInvoiceNUm = false;
                
                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                        $groupByInvoiceNUm = true;
                }

                if($category_download == "kompilasi" && $kode_cabang == "all"){
                        $data       = $this->h2h->get_data_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang = $this->h2h->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        foreach ($get_pajak_header_id as $key => $value) {
                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                        }
                }
                else{
                        $get_pajak_header_id = $this->h2h->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        $data                = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang          = $this->h2h->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $insert_log['PAJAK_HEADER_ID'] = $pajak_header_id;
                }

                $nama_cabangArr = array();
                foreach ($get_cabang as $value) {
                        $nama_cabangArr[$value->KODE_CABANG] = str_replace(" ","",get_nama_cabang($value->KODE_CABANG));
                }
                ksort($nama_cabangArr);
                
                if($nama_pajak == "PPN KELUARAN"){
                        
                        if($category == "dokumen_lain"){
                                $tileDMFM = "DK_DM";
                        }
                        else{
                                $tileDMFM = "FK";
                        }
                }
                
                $title_dokumen_lain = array(
                        'DOCNUMBER',
                        'INVOICE_ID',
                        'TAHUN_BUKU',
                        'KD_JNS_TRANSAKSI',
                        'FG_PENGGANTI',
                        'NOMOR_FAKTUR',
                        'TANGGAL_FAKTUR',
                        'NPWP_PEMBELI',
                        'NAMA_PEMBELI',
                        'ALAMAT_PEMBELI',
                        'JUMLAH_DPP',
                        'JUMLAH_PPN',
                        'JUMLAH_PPNBM',
                        'REFERENSI',
                        'NIK_PEMBELI',
                        'KODE_BRANCH',
                        'BRANCH',
                        'ID_CURRENCY',
                        'STATUS_TRANSAKSI',
                        'FG_UANG_MUKA',
                        'UANG_MUKA_DPP',
                        'UANG_MUKA_PPN',
                        'UANG_MUKA_PPNBM',
                        'COMPANY_ID',
                        'COMPANY_NAME',
                        'JENIS_FAKTUR'
                );

                if($withAkun == 1){
                        array_shift($title_dokumen_lain); 
                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                }
                
                if($nama_pajak == "PPN KELUARAN"){

                        $title_faktur_standar = array(
                                'DOCNUMBER',
                                'INVOICE_ID',
                                'TAHUN_BUKU',
                                'KD_JNS_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NOMOR_FAKTUR',
                                'TANGGAL_FAKTUR',
                                'NPWP_PEMBELI',
                                'NAMA_PEMBELI',
                                'ALAMAT_PEMBELI',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'REFERENSI',
                                'NIK_PEMBELI',
                                'KODE_BRANCH',
                                'BRANCH',
                                'ID_CURRENCY',
                                'STATUS_TRANSAKSI',
                                'FG_UANG_MUKA',
                                'UANG_MUKA_DPP',
                                'UANG_MUKA_PPN',
                                'UANG_MUKA_PPNBM',
                                'COMPANY_ID',
                                'COMPANY_NAME',
                                'JENIS_FAKTUR'
                        );
                }

                array_push($dokumen_lain, $title_dokumen_lain);
                array_push($faktur_standar, $title_faktur_standar);
                array_push($faktur_standar_efaktur, $title_faktur_standar);
                
                //$adaEfaktur = true;
                $adaEfaktur = false;
                
                
                if (!empty($data) && count($data->result_array())>0 ) {
                        if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
        
                                $resCheckData = $this->ppn_masa->get_by_duplicate_invoice($pajak_header_id);

                                $lastInv    = "";
                                $dupInvoice = array();
                                foreach ($resCheckData as $key => $value) {
                                        $dupInvoice['INVOICE_NUM'][]       = strtolower($value['INVOICE_NUM']);
                                        $dupInvoice['JUMLAH_POTONG_PPN'][] = $value['JUMLAH_POTONG_PPN'];
                                        $dupInvoice['JUMLAH_DPP'][]        = $value['JUMLAH_DPP'];
                                }
                        }
                                
                        $pushDokLain = true;
                        $j = 0;
        
                        foreach($data->result_array() as $row)	{
                                
                                $tanggal_dokumen_lain = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("d/m/Y", strtotime($row['TANGGAL_DOKUMEN_LAIN'])) : '';
                                $tanggal_approval     = ($row['TANGGAL_DOKUMEN_LAIN']) ? date("Ymdhis", strtotime($row['TANGGAL_DOKUMEN_LAIN']))."000000" : '';
                                $tanggal_faktur       = ($row['TANGGAL_FAKTUR_PAJAK']) ? date("d/m/Y", strtotime($row['TANGGAL_FAKTUR_PAJAK'])) : '';
                                
                                $val_fg_pengGanti     = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];
                                $kd_jenis_transaksi   = ($row['KD_JENIS_TRANSAKSI'] == "") ? "" : sprintf("%02d", $row['KD_JENIS_TRANSAKSI']);
                                $fg_pengganti         = ($row['FG_PENGGANTI'] != "") ? $row['FG_PENGGANTI'] : $row['FG_PENGGANTI_NEW'];

                                if($nama_pajak == $this->daftar_pajak[0]){
                                        if($category == "dokumen_lain"){
                                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 2;
                                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 5;
                                        }
                                        else{
                                                        $val_jenis_transaksi = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                }
                                else{
                                        if($category == "dokumen_lain"){
                                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 5;
                                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                        else{
                                                        $val_jenis_transaksi    = ($row['JENIS_TRANSAKSI'] != "") ? $row['JENIS_TRANSAKSI'] : 3;
                                                        $val_jenis_dokumen      = ($row['JENIS_DOKUMEN'] != "") ? $row['JENIS_DOKUMEN'] : 3;
                                        }
                                }
        
                                $ppnNya     = $row['JUMLAH_POTONG_PPN'];
                                $dppNya     = $row['DPP'];
                                $invoiceNya = $row['INVOICE_NUM'];
                                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                                        $pushDokLain = false;
                                     
                                        if(!empty($dupInvoice)){
                                                if(in_array(strtolower($invoiceNya), $dupInvoice['INVOICE_NUM'])){
                                                        if($invoiceNya != $lastInv){
                                                                $ppnNya      = $dupInvoice['JUMLAH_POTONG_PPN'][$j];
                                                                $dppNya      = $dupInvoice['JUMLAH_DPP'][$j];
                                                                $pushDokLain = true;
                                                                $j++;
                                                        }
                                                        $lastInv = $row['INVOICE_NUM'];
                                                }
                                                else{
                                                        $pushDokLain = true;
                                                }
                                        } else {
                                                $pushDokLain = true;
                                        }     
                                }
        
                                $npwp = format_npwp($row['NPWP1'], false);
                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];
        
                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                $address = str_replace(' ',' ',$address);
                                $address = str_replace(',',' ',$address);
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));

                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);

                                $no_faktur = ($row['NO_FAKTUR_PAJAK'] != "") ? str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))) : $row['NO_DOKUMEN_LAIN']; 
                                $vtanggal_faktur = ($tanggal_faktur != "") ? $tanggal_faktur : $tanggal_dokumen_lain;
        
                                if($pushDokLain){
                                    $arrDokumenLain = array(
                                        $row['DOCNUMBER'],
                                        $row['INVOICE_ID'],
                                        $row['TAHUN_PAJAK'],
                                        $kd_jenis_transaksi,
                                        $fg_pengganti,
                                        $no_faktur,
                                        $vtanggal_faktur,
                                        $npwp,
                                        $row['VENDOR_NAME'],
                                        $alamatNya,
                                        $row['DPP'],
                                        $row['JUMLAH_POTONG_PPN'],
                                        ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                        ($row['REFERENSI'] != "") ? $row['REFERENSI'] : "-",
                                        "-",
                                        $kode_cabang,
                                        $row['NAMA_CABANG'],
                                        ($row['INVOICE_CURRENCY_CODE'] != "") ? $row['INVOICE_CURRENCY_CODE'] : "-",
                                        0,
                                        $row['FG_UANG_MUKA'],
                                        $row['UANG_MUKA_DPP'],
                                        $row['UANG_MUKA_PPN'],
                                        $row['UANG_MUKA_PPNBM'],
                                        "2",
                                        "Pelindo 2",
                                        "DK"
                                    );
        
                                    if($withAkun == 1){
                                        array_shift($arrDokumenLain); 
                                        array_unshift($arrDokumenLain,($nama_pajak == "PPN MASUKAN") ? "DM" : "DK", $row['AKUN_PAJAK']);
                                    }
                                    array_push($dokumen_lain, $arrDokumenLain);
                                }
        
                                if($nama_pajak == "PPN KELUARAN"){

                                    if($row['E_FAKTUR'] != 'keluaran' ){
                                        array_push($faktur_standar,
                                            array(
                                                    $row['DOCNUMBER'],
                                                    $row['INVOICE_ID'],
                                                    $row['TAHUN_PAJAK'],
                                                    $kd_jenis_transaksi,
                                                    $fg_pengganti,
                                                    $no_faktur,
                                                    $vtanggal_faktur,
                                                    $npwp,
                                                    $row['VENDOR_NAME'],
                                                    $alamatNya,
                                                    $row['DPP'],
                                                    $row['JUMLAH_POTONG_PPN'],
                                                    ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                    ($row['REFERENSI'] != "") ? $row['REFERENSI'] : "-",
                                                    "-",
                                                    $kode_cabang,
                                                    $row['NAMA_CABANG'],
                                                    ($row['INVOICE_CURRENCY_CODE'] != "") ? $row['INVOICE_CURRENCY_CODE'] : "-",
                                                    0,
                                                    $row['FG_UANG_MUKA'],
                                                    $row['UANG_MUKA_DPP'],
                                                    $row['UANG_MUKA_PPN'],
                                                    $row['UANG_MUKA_PPNBM'],
                                                    "2",
                                                    "Pelindo 2",
                                                    "FK"
                                            )
                                        );
                                    } else {
                                        $adaEfaktur = true;
                                        $arrjson = "";
                                        $arrjson = $row['JSON_KELUARAN'];
                                        $arrjson = json_decode($arrjson);
                                        if ($row['SOURCE_DATA'] == 'CSV'){
                                            array_push($faktur_standar_efaktur,
                                                array(
                                                        $row['DOCNUMBER'],
                                                        $row['INVOICE_ID'],
                                                        $row['TAHUN_PAJAK'],
                                                        $kd_jenis_transaksi,
                                                        $fg_pengganti,
                                                        $no_faktur,
                                                        $vtanggal_faktur,
                                                        $npwp,
                                                        $row['VENDOR_NAME'],
                                                        $alamatNya,
                                                        $row['DPP'],
                                                        $row['JUMLAH_POTONG_PPN'],
                                                        ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                        ($row['REFERENSI'] != "") ? $row['REFERENSI'] : "-",
                                                        "-",
                                                        $kode_cabang,
                                                        $row['NAMA_CABANG'],
                                                        ($row['INVOICE_CURRENCY_CODE'] != "") ? $row['INVOICE_CURRENCY_CODE'] : "-",
                                                        0,
                                                        $row['FG_UANG_MUKA'],
                                                        $row['UANG_MUKA_DPP'],
                                                        $row['UANG_MUKA_PPN'],
                                                        $row['UANG_MUKA_PPNBM'],
                                                        "2",
                                                        "Pelindo 2",
                                                        "FK"
                                                )
                                            );
                                        }
                                        
                                    }

                                }
                        }

                        $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));

                        $nama_cabang = array();
                                foreach ($nama_cabangArr as $key => $value) {
                                        $nama_cabang[] = $value;
                                }

                                if($category_download == "kompilasi" && $kode_cabang == "all"){
                                        $fileName = "Kompilasi_".$tahun_pajak."_".$masa_pajak."_".$pembetulan_ke;
                                }
                                else{
                                        $fileName = $tahun_pajak."_".$masa_pajak."_".$pembetulan_ke."_".$nama_cabang[0];
                                }

                        if($nama_pajak == "PPN KELUARAN"){
                                if($category == "dokumen_lain"){
                                        convert_to_csv($dokumen_lain, "Dokumen_Keluaran_".$fileName.".csv", ";");
                                }
                                else{
                                        if ($adaEfaktur == true){
                                                convert_to_csv($faktur_standar_efaktur, "Faktur_Keluaran_".$fileName.".csv", ";");
                                        } else {
                                                convert_to_csv($faktur_standar, "Faktur_Keluaran_".$fileName.".csv", ";");
                                        } 
                                }
                        }
                        //End Create CSV File

                } else {
                        if($nama_pajak == "PPN KELUARAN"){
                                $fileName = $tahun_pajak."_".$bulan_pajak."_".$pembetulan_ke."_Data_Kosong";
                                if($category == "dokumen_lain"){
                                        convert_to_csv($dokumen_lain, "Dokumen_Lain_Keluaran_".$fileName.".csv", ";");
                                }
                                else{
                                        convert_to_csv($faktur_standar, "Faktur_Keluaran_".$fileName.'_'.$creditable.".csv", ";");
                                }
                        }
                }  
        }

        function resend_file(){
                
                $username = $this->h2h->getValueParameter("USERNAME_P2");
                $password = $this->h2h->getValueParameter("PASSWORD_P2");
                $base_url = $this->h2h->getValueParameter("BASE_URL_P2");
 
                $params= array(
                        "username" => $username,
                        "password" => $password
                );
                $bulan_pajak = $this->input->post('bulan');
                $tahun_pajak = $this->input->post('tahun');
                $nama_pajak = $this->input->post('jenisPajak');
                $kode_cabang   = $this->input->post('kode_cabang');
                $pembetulan_ke = $this->input->post('pembetulanKe');
                $creditable = $this->input->post('creditable');
                $modul = $this->input->post('modul');
                $withAkun = "";

                if($nama_pajak == "PPN MASUKAN"){
                  if ($modul == "Faktur Masukan"){
                        if($creditable != "Y") {
                           $this->send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","not_creditable",$withAkun);
                        } else {
                           $this->send_to_staging_fm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","creditable",$withAkun);
                        }
                   } else {
                      $this->send_to_tara_dm($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                   }   
                } else {
                    $this->send_to_tara_fk($username,$password,$base_url,$params,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","","");
                }
        }


        function export_log_by_docnumber($vdocnumber,$nama_pajak,$jenis_pajak,$kode_cabang,$journalnumber){

                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                $this->kode_cabang  = $this->session->userdata('kd_cabang');
                $username = $this->h2h->getValueParameter("USERNAME_P2");
                $password = $this->h2h->getValueParameter("PASSWORD_P2");
                $base_url = $this->h2h->getValueParameter("BASE_URL_P2");
 
                $params= array(
                        "Username" => $username,
                        "Password" => $password
                );

		$nama_pajak     = str_replace("%20", " ", $nama_pajak);
                $tahun_pajak = "";
                $bulan_pajak = "";

                $dokumen_detail_jurnal = array();
                $dokumen_faktur_masukan = array();
                $dokumen_faktur_keluaran = array();

		$url            = $base_url.'pajak/login';
                $params_string  = json_encode($params);
        
                $request        = $this->getToken($url, $params_string);
                $el_request     = json_decode($request['request']);
                $jenis_pajak     = str_replace("%20", " ", $jenis_pajak);
                $vjenis_pajak = "";

                if($jenis_pajak == 'DOKUMEN LAIN MASUKAN'){
                    $jenis_pajak = 'PPN MASUKAN';   
                    $vjenis_pajak = 'DOKUMEN LAIN MASUKAN';  
                } else if($jenis_pajak == 'DOKUMEN LAIN KELUARAN'){
                    $jenis_pajak = 'PPN KELUARAN'; 
                    $vjenis_pajak = 'DOKUMEN LAIN KELUARAN'; 
                }
                
                if($request['httpcode'] == 200)
                {
                        $utoken = $el_request->token_jwt;
                        $token_type = "Bearer ";
                        $comp_id = $el_request->company_id;
                        $comp_name = $el_request->company_name;
                        $datalog = $this->h2h->get_data_log($vdocnumber,$journalnumber);
                        if(!empty($datalog)){
                                foreach($datalog->result_array() as $row) {
                                        $tahun_pajak = $row['TAHUN_PAJAK'];
                                        $bulan_pajak = $row['BULAN_PAJAK'];
                                        $vdocumentnumber = $row['JOURNALNUMBER'];  
                                        $vlineno =  $row['LINENO'];
                                        if ($nama_pajak != 'DETAIL JURNAL' && $nama_pajak != 'DETAILJT'){
                                            if($jenis_pajak != 'PPN MASUKAN'){
                                                $urlgetdata = $base_url.'pajak/faktur-keluaran/get-data?docNumber='.$vdocumentnumber; 
                                            } else {
                                                $urlgetdata = $base_url.'pajak/faktur-masukan/get-data?docNumber='.$vdocumentnumber; 
                                            }    
                                            $dtldatalog = $this->ws_getdata($urlgetdata, $utoken);
                                            $element_data_str[] = $dtldatalog;
                                        } else {
                                            $urlgetdata = $base_url.'pajak/jurnal-akuntansi/get-data?docNumber='.$vdocumentnumber.'&lineNo='.$vlineno; 
                                            $dtldatalog = $this->ws_getdata($urlgetdata, $utoken);
                                            $element_data_str[] = $dtldatalog;  
                                        }     
                                }
                                
                        } else {
                            convert_to_csv($nama_pajak, 'getData_kosong_'.$tahun_pajak.'_'.$bulan_pajak.'_'.$kode_cabang.'.csv', ';');
                        }

                        $title_faktur_masukan = array(
                                'DOC_NUMBER',
                                'KODE_PERUSAHAAN',
                                'TAHUN_BUKU',
                                'NOMOR_FAKTUR',
                                'TANGGAL_FAKTUR',
                                'KD_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NPWP_PENJUAL',
                                'NAMA_PENJUAL',
                                'ALAMAT_PENJUAL',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'MASA_PENGKREDITAN',
                                'TAHUN_PENGKREDITAN',
                                'KODE_CABANG',
                                'NAMA_CABANG',
                                'STATUS_TRANSAKSI',
                                'ID_CURRENCY',
                                'JUMLAH_BATAL',
                                'REFERENSI',
                                'ID_BRANCH',
                                'ID_TARRA',
                                'LAST_UPDATE_DATE',
                                'LAST_UPDATE_BY',
                                'PROGRAM_NAME',
                                'CONFIRMATION_FLAG',
                                'COMPANY_ID',
                                'COMPANY_NAME',
                                'CREATED_BY',
                                'CREATED_DATE',
                                'TXN_ID',
                                'ID_KETERANGAN',
                                'WP_ID_BRANCH'
                        );
                        array_push($dokumen_faktur_masukan, $title_faktur_masukan);
                        
                        $title_faktur_keluaran = array(
                                'DOC_NUMBER',
                                'NOMOR_FAKTUR',
                                'TANGGAL_FAKTUR',
                                'KD_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NPWP_PEMBELI',
                                'NAMA_PEMBELI',
                                'ALAMAT_PEMBELI',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'NIK_PEMBELI',
                                'KODE_CABANG',
                                'NAMA_CABANG',
                                'STATUS_TRANSAKSI',
                                'ID_CURRENCY',
                                'JUMLAH_BATAL',
                                'KODE_PERUSAHAAN',
                                'TAHUN_FISKAL',
                                'REFERENSI',
                                'ID_TARRA',
                                'LAST_UPDATE_DATE',
                                'LAST_UPDATE_BY',
                                'PROGRAM_NAME',
                                'CONFIRMATION_FLAG',
                                'COMPANY_ID',
                                'COMPANY_NAME',
                                'CREATED_BY',
                                'CREATED_DATE',
                                'TXN_ID',
                                'WP_ID_BRANCH',
                                'ID_BRANCH',
                                'JENIS_DOKUMEN',
                                'JENIS_TRANSAKSI'
                        );
                        array_push($dokumen_faktur_keluaran, $title_faktur_keluaran);
                        
                        $title_detail_jurnal = array(
                                'DOC_NUMBER',
                                'DESCRIPTION_HEADER',
                                'BULAN_BUKU',
                                'TAHUN_BUKU',
                                'TANGGAL_POSTING',
                                'NOMOR_FAKTUR',
                                'LINE_NO',
                                'DESC_JENIS_TRANSAKSI',
                                'ACCOUNT',
                                'DESC ACCOUNT',
                                'AMOUNT',
                                'REFERENCELINE',
                                'SUBLEDGER',
                                'CODE_SUBLEDGER',
                                'DESC_SUBLEDGER',
                                'PROFIT_CENTER',
                                'PROFIT_CENTER_DESC',
                                'COST_CENTER_ID',
                                'COST_CENTER_DESC',
                                'TANGGAL_PO',
                                'PO_NUMBER',
                                'KODE_PERUSAHAAN',
                                'LAST_UPDATE_DATE',
                                'LAST_UPDATE_BY',
                                'CREATED_BY',
                                'CREATED_DATE',
                                'COMPANY_ID',
                                'COMPANY_NAME'
                        );
                        array_push($dokumen_detail_jurnal, $title_detail_jurnal);
                     
                        $vrow=1;
                        foreach ($element_data_str as $line => $row) {
                                
                                if ($nama_pajak != 'DETAIL JURNAL' && $nama_pajak != 'DETAILJT'){
                                    if($jenis_pajak != 'PPN MASUKAN'){
                                        $namaPembeli = str_replace(","," ",$row[0]['namaPembeli']); 
                                        $alamatPembeli = str_replace(","," ",$row[0]['alamatPembeli']);    
                                        array_push($dokumen_faktur_keluaran,
                                        array(      
                                                $row[0]['docNumber'],
                                                $row[0]['nomorFaktur'],
                                                $row[0]['tanggalFaktur'],
                                                $row[0]['kdTransaksi'],
                                                $row[0]['fgPengganti'],
                                                $row[0]['npwpPembeli'],
                                                $namaPembeli,
                                                $alamatPembeli,
                                                $row[0]['jumlahDpp'],
                                                $row[0]['jumlahPpn'],
                                                $row[0]['jumlahPpnbm'],
                                                $row[0]['nikPembeli'],
                                                $row[0]['codeBranch'],
                                                $row[0]['nameBranch'],
                                                $row[0]['statusTransaksi'],
                                                $row[0]['idCurrency'],
                                                $row[0]['jumlahBatal'],
                                                $row[0]['bukrs'],
                                                $row[0]['gjahr'],
                                                $row[0]['referensi'],
                                                $row[0]['id_tarra'],
                                                $row[0]['last_update_date'],
                                                $row[0]['last_update_by'],
                                                $row[0]['program_name'],
                                                $row[0]['confirmation_flag"'],
                                                $row[0]['company_id""'],
                                                $row[0]['company_name""']
                                            )
                                        );
                                    } else {
                                        $namaPenjual = str_replace(","," ",$row[0]['namaPenjual']); 
                                        $alamatPenjual = str_replace(","," ",$row[0]['alamatPenjual']);     
                                        array_push($dokumen_faktur_masukan,
                                        array(      
                                                $row[0]['docNumber'],
                                                $row[0]['bukrs'],
                                                $row[0]['tahunBuku'],
                                                $row[0]['nomorFaktur'],
                                                $row[0]['tanggalFaktur'],
                                                $row[0]['kdTransaksi'],
                                                $row[0]['fgPengganti'],
                                                $row[0]['npwpPenjual'],
                                                $namaPenjual,
                                                $alamatPenjual,
                                                $row[0]['jumlahDpp'],
                                                $row[0]['jumlahPpn'],
                                                $row[0]['jumlahPpnbm'],
                                                $row[0]['masaPengkreditan'],
                                                $row[0]['tahunPengkreditan'],
                                                $row[0]['kodeBranch'],
                                                $row[0]['namaBranch'],
                                                $row[0]['statusTransaksi'],
                                                $row[0]['idCurrency'],
                                                $row[0]['jumlahBatal'],
                                                $row[0]['referensi'],
                                                $row[0]['idBranch'],
                                                $row[0]['idTarra'],
                                                $row[0]['last_update_date'],
                                                $row[0]['last_update_by'],
                                                $row[0]['program_name'],
                                                $row[0]['confirmation_flag'],
                                                $row[0]['company_id'],
                                                $row[0]['company_name'],
                                                $row[0]['created_by'],
                                                $row[0]['created_date'],
                                                $row[0]['txn_id'],
                                                $row[0]['id_keterangan'],
                                                $row[0]['wpidBranch'],
                                            )
                                        );
                                    }
                                } else {
                                    $referenceline = str_replace(","," ",$row[0]['referenceLine']);   
                                    $descsubledger = str_replace(","," ",$row[0]['descSubLedger']);     
                                    array_push($dokumen_detail_jurnal,
                                        array(
                                                $row[0]['docNumber'],
                                                $row[0]['descriptionHeader'],
                                                $row[0]['bulanBuku'],
                                                $row[0]['tahunBuku'],
                                                $row[0]['tanggalPosting'],
                                                $row[0]['nomorFaktur'],
                                                $row[0]['lineNo'],
                                                $row[0]['descJenisTransaksi'],
                                                $row[0]['account'],
                                                $row[0]['descAccount'],
                                                $row[0]['amount'],
                                                $referenceline,
                                                $row[0]['subLedger'],
                                                $row[0]['codesubledger'],
                                                $descsubledger,
                                                $row[0]['profitCenterId'],
                                                $row[0]['profitCenterDesc'],
                                                $row[0]['costCenterId'],
                                                $row[0]['costCenterDesc'],
                                                $row[0]['tanggalPo'],
                                                $row[0]['poNumber'],
                                                $row[0]['bukrs'],
                                                $row[0]['last_update_date'],
                                                $row[0]['last_update_by'],
                                                $row[0]['program_name'],
                                                $row[0]['created_by'],
                                                $row[0]['created_date'],
                                                $row[0]['company_id'],
                                                $row[0]['company_name']
                                        )
                                    );
                                }
                                
                        }
                        
                       $fileName = '_'.$tahun_pajak.'_'.$bulan_pajak.'_'.$kode_cabang.'_';
                       $filepajak = ($vjenis_pajak != "") ? $vjenis_pajak : $jenis_pajak;
                        
                        if ($nama_pajak != 'DETAIL JURNAL' && $nama_pajak != 'DETAILJT'){
                            if($jenis_pajak != 'PPN MASUKAN'){
                                convert_to_csv($dokumen_faktur_keluaran, 'getData_'.$filepajak.'_'.$fileName.'.csv', ';');
                            } else {
                                convert_to_csv($dokumen_faktur_masukan, 'getData_'.$filepajak.'_'.$fileName.'.csv', ';');
                            }
                        } else {
                                convert_to_csv($dokumen_detail_jurnal, 'getData_Jurnal_Transaksi'.$fileName.'.csv', ';');
                        }
                        
                }
                else {
                        echo '3';
                }  
                
        }

        function download_csv_djt($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke) {

		ini_set('memory_limit', '-1');

		$this->load->helper('csv_helper');
		
		$date           = date("d", time());
		$dokumen_lain   = array();
		$faktur_standar = array();
		
		$nama_pajak     = str_replace("%20", " ", $nama_pajak);
		$adaEfaktur     = false;

		$data           = $this->h2h->get_data_csv($nama_pajak, $kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

        if($nama_pajak == "PPN MASUKAN"){
            $tileDMFM = "DK_DM";
        } else{
	    $tileDMFM = "DK_DM";
        }
        $masa_pajak = strtoupper(get_masa_pajak($bulan_pajak));
        $title_dokumen_lain = array(
                'LEDGER_ID',
                'PERIOD_NAME',
                'USER_JE_SOURCE_NAME',
                'DOCNUMBER',
                'NOMOR_FAKTUR',
                'BULAN_BUKU',
                'TAHUN_BUKU',
                'TANGGALPOSTING',
                'DESCJENISTRANSAKSI',
                'LINENO',
                'ACCOUNT',
                'DESCACCOUNT',
                'AMOUNT',
                'SUBLEDGER',
                'CODESUBLEDGER',
                'DESCSUBLEDGER',
                'DESCRIPTIONHEADER',
                'REFERENCELINE',
                'PROFITCENTER',
                'PROFITCENTERDESC',
                'COSTCENTER',
                'COSTCENTERDESC',
                'PONUMBER',
                'TANGGALPO',
                'CABANG',
                'NOMORINVOICE',
                'TANGGALINVOICE',
                'INVOICE_ID'
        );

    	array_push($dokumen_lain, $title_dokumen_lain);

							
                if (!empty($data)) {

                        foreach($data->result_array() as $row)	{
                                $descsubledger = str_replace(',', '',$row['DESCSUBLEDGER']);
                                $referenceline = str_replace(',', '',$row['REFERENCELINE']);
                                array_push($dokumen_lain,
                                        array(
                                                $row['LEDGER_ID'],
                                                $row['PERIOD_NAME'],
                                                $row['USER_JE_SOURCE_NAME'],
                                                $row['DOCNUMBER'],
                                                $row['NOMOR_FAKTUR'],
                                                $row['BULAN_BUKU'],
                                                $row['TAHUN_BUKU'],
                                                $row['TANGGALPOSTING'],
                                                $row['DESCJENISTRANSAKSI'],
                                                $row['LINENO'],
                                                $row['ACCOUNT'],
                                                $row['DESCACCOUNT'],
                                                $row['AMOUNT'],
                                                $row['SUBLEDGER'],
                                                $row['CODESUBLEDGER'],
                                                $descsubledger,
                                                $row['DESCRIPTIONHEADER'],
                                                $referenceline,
                                                $row['PROFITCENTER'],
                                                $row['PROFITCENTERDESC'],
                                                $row['COSTCENTER'],
                                                $row['COSTCENTERDESC'],
                                                $row['PONUMBER'],
                                                $row['TANGGALPO'],
                                                $row['KODE_CABANG'],
                                                $row['NOMORINVOICE'],
                                                $row['TANGGALINVOICE'],
                                                $row['INVOICE_ID']
                                        )
                                );
                        }

                        if($nama_pajak == "PPN MASUKAN"){
                                convert_to_csv($dokumen_lain, 'Detail_Jurnal_Transaksi_Masukan_'.$tahun_pajak.'_'.$masa_pajak.'.csv', ';');
                        } else {
                                convert_to_csv($dokumen_lain, 'Detail_Jurnal_Transaksi_Masukan_'.$tahun_pajak.'_'.$masa_pajak.'.csv', ';');
                        }

                } else {
                        if($nama_pajak == "PPN MASUKAN"){
                                convert_to_csv($dokumen_lain, 'Detail_Jurnal_Transaksi_Masukan_'.$tahun_pajak.'_'.$masa_pajak.'_'.$kode_cabang.'_data_kosong.csv', ';');
                        } else {
                                convert_to_csv($dokumen_lain, 'Detail_Jurnal_Transaksi_Masukan_'.$tahun_pajak.'_'.$masa_pajak.'_'.$kode_cabang.'_data_kosong.csv', ';');
                        }
                }
	}

        function checkStatusTransaksi($fgpengganti, $nodoklain, $nodoklainganti, $bulan, $tahun){

                //status normal kriteria 1
                if($fgpengganti == 0 && empty($nodoklainganti) && !empty($nodoklain)){
                     $statustrx = 0;   
                     return $statustrx;
                }

                //status normal kriteria 2
                $vtigastring = substr($nodoklain, 0, 3);
                $charketiga = substr($vtigastring, -1);
                if($fgpengganti == 1 && !empty($nodoklainganti) && $charketiga == "1"){
                        $statustrx = 0;   
                        return $statustrx;
                }

                //status batal
                $sql	="  select count(1) ADA_DATA 
                        from simtax_pajak_lines
                        where NO_DOKUMEN_LAIN = '".$nodoklainganti."'
                        and BULAN_PAJAK < ".$bulan."
                        and TAHUN_PAJAK <= ".$tahun."
                        ";		

		$qReqID     = $this->db->query($sql);
		$row        = $qReqID->row();       	
		$isAdaData  = $row->ADA_DATA; 
                if ($isAdaData == 1) {
                   $statustrx = 1;   
                   return $statustrx;
                }
        }

        function validation_staging($pajak, $nama_pajak, $bulan_pajak, $tahun_pajak, $kode_cabang, $pembetulan_ke)
	{
                $creditable = "xx";
                $withAkun = "";
                $masihKosong = true;
		$doklainAda  = false;
		$fakturAda   = false;
                $fakturcAda = false;
                $detailJurnal  = false;
                $pajak = str_replace("%20"," ",$pajak);
                $nama_pajak = str_replace("%20"," ",$nama_pajak);
                $vdokname = $nama_pajak;

                if($nama_pajak == "DOKUMEN LAIN MASUKAN"){
                        $nama_pajak = 'PPN MASUKAN';   
                }
                else if($nama_pajak == "DOKUMEN LAIN KELUARAN"){
                        $nama_pajak = 'PPN KELUARAN';   
                }
               
                if($pajak === 'PPNMASA'){
                        
                        $get_pajak_header_id = $this->h2h->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        
                        if($vdokname === "PPN MASUKAN"){
                                //faktur standar creditable
                                $data                = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, "", "faktur_standar","creditable",$withAkun);
                                if($data){
                                   $ii=0;
                                   $records  = "";
                                   foreach($data->result_array() as $row) {
                                        if ($row['DOCNUMBER'] == "" || $row['NPWP1']==""){
                                        $records .= $row['INVOICE_ID'].", " ;
                                        $fakturAda = true;
                                        }
                                        $hasilFaktur ="Invoice ID ".$records." Doc. Number / NPWP pada Efaktur masukan creditable masih kosong";
                                   }
                                }    
                                // faktur standar not creditable
                                $datacreditable      = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, "", "faktur_standar","not_creditable",$withAkun);
    
                                if($datacreditable){
                                    $ii=0;
                                    $records  = "";
                                    foreach($datacreditable->result_array() as $row) {
                                        if ($row['DOCNUMBER'] == "" || $row['NPWP1']==""){
                                            $records .= $row['INVOICE_ID'].", " ;
                                            $fakturcAda = true;
                                        }
                                       $hasilFakturc ="Invoice ID ".$records." Doc. Number / NPWP  pada Efaktur masukan not creditable masih kosong";
                                    }
                                }
                        }

                        if($vdokname === "PPN KELUARAN"){
                                $data    = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, "", "faktur_standar","","");
                                if($data){
                                   $ii=0;
                                   $records  = "";
                                   foreach($data->result_array() as $row) {
                                        if ($row['DOCNUMBER'] == "" || $row['NPWP1']==""){
                                          $records .= $row['INVOICE_ID'].", " ;
                                           $fakturAda = true;
                                        }
                                        $hasilFaktur ="Invoice ID ".$records." Doc. Number / NPWP pada Efaktur keluaran masih kosong";
                                   }
                                } 
                        }
                        
                        if($vdokname == "DOKUMEN LAIN MASUKAN" || $vdokname == "DOKUMEN LAIN KELUARAN"){
                            //dokumen lain
                            $data2 = $this->h2h->get_data_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, "", "dokumen_lain","xx",$withAkun);
                            if($data2){
                                $ii=0;
                                $records  = "";
                                foreach($data2->result_array() as $row) {
                                    $ii++;
                                    if ($row['DOCNUMBER'] == "" || $row['NO_DOKUMEN_LAIN']=="" || $row['NPWP1']==""){
                                        $records .= $row['INVOICE_ID'].", " ;
                                        $doklainAda = true;
                                    }
                                   $hasilDoklain ="Invoice ID ".$records." Doc. Number / Nomor dokumen lain / NPWP pada dokumen lain masih kosong";
                                }
                            }
                        }
                        
                        if($fakturAda == true && $doklainAda == true && $fakturcAda == true){
                            $result['data'] = $hasilFaktur ."<br>".$hasilDoklain."<br>".$hasilFakturc;
                        } else {
                            if($fakturAda == true && $doklainAda == false && $fakturcAda == false){
                                $result['data'] = $hasilFaktur;
                            }
                            elseif($doklainAda == true && $fakturAda == false && $fakturcAda == false){
                                $result['data'] = $hasilDoklain;
                            } elseif($fakturcAda == true && $doklainAda == false && $fakturAda == false){
                                $result['data'] = $hasilFakturc;
                            } else {
                                $masihKosong = false;        
                            }  
                        }

                        if($masihKosong){
                                $result['st'] = 1;
                                echo json_encode($result);
                                die();
                        }
                        else{
                            $result['st'] = 0;
                            echo json_encode($result);
                        }
                } else {
                        $data = $this->h2h->get_data_detail_jurnal($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        if($data){
                                $ii=0;
                                $records  = "";
                                foreach($data->result_array() as $row) {
                                    if ($row['DOCNUMBER'] == ""){
                                        $records .= $row['INVOICE_ID'].", " ;
                                        $detailJurnal = true;
                                    }
                                }
                                $records = rtrim($records," ");
                                $records = rtrim($records,",");
                                $hasilJurnal ="Invoice ID ( ".$records." ) Doc. Number masih kosong";
                            }

                        if($detailJurnal == true){
                            $result['data'] = $hasilJurnal;
                        } else {
                                $masihKosong = false;    
                        }
                        
                        if($masihKosong){
                                $result['st'] = 1;
                                echo json_encode($result);
                                die();
                        }
                        else{
                            $result['st'] = 0;
                            echo json_encode($result);
                        }
                }

        }
		
}