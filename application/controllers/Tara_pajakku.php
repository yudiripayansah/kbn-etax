<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tara_pajakku extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}
		$this->load->model('Tara_pajakku_mdl', 'tara');
                $this->load->model('ppn_masa_mdl', 'ppn_masa');
		$this->load->model('Cabang_mdl');
                $this->daftar_pajak = array("PPN MASUKAN", "PPN KELUARAN");
	}	
	
        function load_master_pajak()
        {
                $hasil	= $this->tara->get_master_pajak();
                $query 		= $hasil['query'];			
                $result ="";
                $result .= "<option value='' data-name='' > Pilih Pajak </option>";
                                foreach($query->result_array() as $row)	{
                                        $result .= "<option value='".$row['KELOMPOK_PAJAK']."' data-name='".$row['KELOMPOK_PAJAK']."' >".$row['KELOMPOK_PAJAK']."</option>";
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


        function load_log_tara()
        {
                $hasil	=$this->tara->get_log_tara();
                        $rowCount	= $hasil['jmlRow'] ;
                        $query 		= $hasil['query'];	
                
                        if ($rowCount>0){
                                $ii	=	0;
                                foreach($query->result_array() as $row)	{
                                                $ii++;	
                                        $bulan = "";
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
                        
                                                $result['data'][] = array(
                                                                        'no'			        => $row['RNUM'],
                                                                        'id_log'		        => $row['ID_LOG'],
                                                                        'pajak_header_id'		=> $row['PAJAK_HEADER_ID'],
                                                                        'pajak'			        => $row['PAJAK'],
                                                                        'jenis_pajak'	                => $row['JENIS_PAJAK'],
                                                                        'bulan_pajak'		        => $bulan,
                                                                        'tahun_pajak'	                => $row['TAHUN_PAJAK'],
                                                                        'tanggal_kirim'	                => $row['TANGGAL_KIRIM'],
                                                                        'status_upload_csv' 	        => $row['STATUS_UPLOAD_CSV'],
                                                                        'encode_file' 		        => $row['ENCODE_FILE'],
                                                                        'origin_file' 		        => $row['ORIGIN_FILE'],
                                                                        'status_import_csv' 		=> $row['STATUS_IMPORT_CSV'],
                                                                        'file_id' 		        => $row['FILE_ID'],
                                                                        'created_by' 		        => $row['CREATED_BY'],
                                                                        'created_date' 		        => $row['CREATED_DATE'],
                                                                        'last_modified_by' 		=> $row['LAST_MODIFIED_BY'],
                                                                        'last_modified_date' 		=> $row['LAST_MODIFIED_DATE'],
                                                                        'log_id_import' 		=> $row['LOG_ID_IMPORT'],
                                                                        'wp_id' 		        => $row['WP_ID'],
                                                                        'modul' 		        => $row['MODUL'], 
                                                                        'status_log_import' 		=> $row['STATUS_LOG_IMPORT'],
                                                                        'description_log_import' 	=> $row['DESCRIPTION_LOG_IMPORT'],
                                                                        'delimiter' 		        => $row['DELIMITER'],
                                                                        'total' 		        => $row['TOTAL'],
                                                                        'jumlah_error_import' 		=> $row['JUMLAH_ERROR_IMPORT'],
                                                                        'user_send_simtax' 		=> $row['USER_SEND_SIMTAX'], 
                                                                        'is_creditable' 		=> $row['IS_CREDITABLE'],  
                                                                        'pembetulan' 		        => $row['PEMBETULAN'],
                                                                        'kode_cabang' 		        => $row['KODE_CABANG'],  
                                                                        'nama_cabang' 		        => $row['NAMA_CABANG'],   
                                                                        'jumlah_sukses_import' 		=> $row['JUMLAH_SUKSES_IMPORT'],   
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

        function send_to_tara(){
                $this->kode_cabang  = $this->session->userdata('kd_cabang');
                $sql0 = "select value from simtax_config_tara
						where 
                                                parameter = 'DOC_ROOT_UPLOAD'";				
		$query	= $this->db->query($sql0);
		$docrootupl = $query->row()->VALUE;
                $sql1 = "select value from simtax_config_tara
						where 
                                                parameter = 'USERNAME'";				
		$query	= $this->db->query($sql1);
		$username	= $query->row()->VALUE;
                $sql2 = "select value from simtax_config_tara
                where 
                parameter = 'PASSWORD'";				
                $query	= $this->db->query($sql2);
                $password	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'RME'";				
                $query	= $this->db->query($sql3);
                $rme	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'BASE_URL'";				
                $query	= $this->db->query($sql3);
                $base_url	= $query->row()->VALUE;
    
                //define("DOC_ROOT_UPLOAD","/var/www/html/simtax/uploads");
                define("DOC_ROOT_UPLOAD",$docrootupl);
                $path = DOC_ROOT_UPLOAD."/tara";

                $params= array(
                        "username" => $username,
                        "password" => $password,
                        "rememberMe" => $rme
                );
                $cookie_file_path = $path."/cookie.txt";
                $bulan_pajak = $this->input->post('bulan');
                $tahun_pajak = $this->input->post('tahun');
                $pajak = $this->input->post('pajak');
                $nama_pajak = $this->input->post('jenisPajak');
                $kode_cabang   = $this->input->post('cabang_trx');
                $pembetulan_ke = $this->input->post('pembetulanKe');
                $creditable = "xx";
                $withAkun = "";
                if($nama_pajak == "PPN MASUKAN"){
                        $this->send_to_tara_dm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                        $this->send_to_tara_fm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","creditable",$withAkun);
                        $this->send_to_tara_fm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","not_creditable",$withAkun);
                } else {
                        $this->send_to_tara_dk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                        $this->send_to_tara_fk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","","");
                }
        }

        function send_to_tara_dk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable,$withAkun)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                $csvfilenamedk = "";
                
                if ($kode_cabang == "000"){
                        $category_download = "kompilasi";
                } else {
                        $category_download = "cabang";
                }

                if ($creditable != "creditable"){
                        $insert_log['IS_CREDITABLE'] = "N";
                } else {
                        $insert_log['IS_CREDITABLE'] = "Y";
                }

                $insert_log['PEMBETULAN'] = $pembetulan_ke;
                $insert_log['KODE_CABANG'] = $kode_cabang;

                $url = $base_url.'api/v1/sign-in';
                $params_string = json_encode($params); 
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);                                                                    
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
                        'Content-Type: application/json',                                                                                
                        'Content-Length: ' . strlen($params_string),
                        'User-Agent: Mozilla/5.0')                                                                       
                );   
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                
                $request = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if($httpCode == 200)
                {
                        $result = json_decode($request, true);
                        $token_type = "Bearer ";
                        $utoken = $result['id_token'];
                        $urlwp = $base_url."api/v1/wps-mine"; 
                        
                        //GET WP
                        $api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
                        $data_wp = json_decode($api_response, true);
                        $id_wp = "";
                        foreach($data_wp as $row_wp){
                                $wp_id = $row_wp['id'];
                        }

                        // Get Branch Code
                        $url_get_branch = $base_url."api/v1/wps/".$wp_id."/branches";
                        $api_branch = $this->getapiwp($token_type,$utoken,$url_get_branch,$base_url,$username,$password);
                        $data_branch = json_decode($api_branch, true);
                        $branch_code = "";
                        $branch_name = "";
                        $penandatangan = "";
                        $createdBy = "";
                        $createdDate = "";
                        foreach($data_branch as $row_branch){
                                $branch_code = $row_branch['code'];
                                $branch_name = $row_branch['name'];
                                $penandatangan = $row_branch['penandatangan'];
                                $createdBy = $row_branch['createdBy'];
                                $createdDate = $row_branch['createdDate'];
                        }        
                        $insert_log['BRANCH_CODE'] = $branch_code;
                        $insert_log['BRANCH_NAME'] = $branch_name;

                        //Create CSV File
                        $date           = date("d", time());
                        $dokumen_lain   = array();
                        $faktur_standar = array();
                        
                        $groupByInvoiceNUm = false;
                        
                        if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                                $groupByInvoiceNUm = true;
                        }

                        if($category_download == "kompilasi" && $kode_cabang == "all"){
                                $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                                $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                foreach ($get_pajak_header_id as $key => $value) {
                                        $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                        $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                                }
                        }
                        else{
                                $get_pajak_header_id = $this->tara->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                                $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
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
                                $tileDMFM,
                                'JENIS_TRANSAKSI',
                                'JENIS_DOKUMEN',
                                'KD_JNS_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NOMOR_DOK_LAIN_GANTI',
                                'NOMOR_DOK_LAIN',
                                'TANGGAL_DOK_LAIN',
                                'MASA_PAJAK',
                                'TAHUN_PAJAK',
                                'NPWP',
                                'NAMA',
                                'ALAMAT_LENGKAP',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'KETERANGAN',
                                'FAPR',
                                'TGL_APPROVAL',
                                'BRANCH',
                                'PAJAK_LINE_ID',
                                'AKUN_BEBAN',
                                'INVOICE_NUMBER',
                                'MATA_UANG'
                        );

                        if($withAkun == 1){
                                array_shift($title_dokumen_lain); 
                                array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                        }
                        
                        if($nama_pajak == "PPN KELUARAN"){

                                $title_faktur_standar = array(
                                                $tileDMFM,
                                                'KD_JENIS_TRANSAKSI',
                                                'FG_PENGGANTI',
                                                'NOMOR_FAKTUR',
                                                'MASA_PAJAK',
                                                'TAHUN_PAJAK',
                                                'TANGGAL_FAKTUR',
                                                'NPWP',
                                                'NAMA',
                                                'ALAMAT_LENGKAP',
                                                'JUMLAH_DPP',
                                                'JUMLAH_PPN',
                                                'JUMLAH_PPNBM',
                                                'ID_KETERANGAN_TAMBAHAN',
                                                'FG_UANG_MUKA',
                                                'UANG_MUKA_DPP',
                                                'UANG_MUKA_PPN',
                                                'UANG_MUKA_PPNBM',
                                                'REFERENSI',
                                                'BRANCH',
                                                'PAJAK_LINE_ID',
                                                'AKUN_BEBAN',
                                                'INVOICE_NUMBER',
                                                'MATA_UANG'
                                                );
                        }

                        array_push($dokumen_lain, $title_dokumen_lain);
                        array_push($faktur_standar, $title_faktur_standar);
                        
                        $adaEfaktur = true;
                        
                        
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
                                        $address = str_replace('\'','',$address);
                                        $address = str_replace('"','',$address);
                                        $address = str_replace('`','',$address);
                                        $address = trim($address);
                                        $address = trim(preg_replace('/\s\s+/', ' ', $address));
        
                                        $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                
                                        if($pushDokLain){
                
                                                $arrDokumenLain = array(
                                                        ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                        $val_jenis_transaksi,
                                                        $val_jenis_dokumen,
                                                        $kd_jenis_transaksi,
                                                        $fg_pengganti,
                                                        $no_dokumen_lain_ganti,
                                                        $row['NO_DOKUMEN_LAIN'],
                                                        $tanggal_dokumen_lain,
                                                        sprintf("%02d", $row['BULAN_PAJAK']),
                                                        $row['TAHUN_PAJAK'],
                                                        $npwp,
                                                        $row['VENDOR_NAME'],
                                                        $alamatNya,
                                                        $dppNya,
                                                        $ppnNya,
                                                        ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                        $row['KETERANGAN'],
                                                        $kode_cabang,
                                                        $row['PAJAK_LINE_ID'],
                                                        $row['AKUN_PAJAK'],
                                                        $row['INVOICE_NUM'],
                                                        $row['INVOICE_CURRENCY_CODE']
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
                                                                        "FK",
                                                                        $kd_jenis_transaksi,
                                                                        $fg_pengganti,
                                                                        str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                        sprintf("%02d", $row['BULAN_PAJAK']),
                                                                        $row['TAHUN_PAJAK'],
                                                                        $tanggal_faktur,
                                                                        $npwp,
                                                                        $row['VENDOR_NAME'],
                                                                        $alamatNya,
                                                                        $row['DPP'],
                                                                        $row['JUMLAH_POTONG_PPN'],
                                                                        ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                        $row['ID_KETERANGAN_TAMBAHAN'],
                                                                        ($row['FG_UANG_MUKA'] != "") ? $row['FG_UANG_MUKA'] : 0,
                                                                        ($row['UANG_MUKA_DPP'] != "") ? $row['UANG_MUKA_DPP'] : 0,
                                                                        ($row['UANG_MUKA_PPN'] != "") ? $row['UANG_MUKA_PPN'] : 0,
                                                                        ($row['UANG_MUKA_PPNBM'] != "") ? $row['UANG_MUKA_PPNBM'] : 0,
                                                                        $row['REFERENSI']
                                                                )
                                                        );
                                                }
                                                else{
                                                        $adaEfaktur = true;
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
                                                
                                                //convert_to_csv($dokumen_lain, "Dokumen_Keluaran_".$fileName.".csv", ";");
                                                $csvfilenamedk = 'Dokumen_Lain_Keluaran_'.$fileName;
                                                $fp = fopen($path.'/'.$csvfilenamedk.'.csv', 'w');
                                                foreach ($dokumen_lain as $line) {
                                                        fputcsv($fp, $line, ";");
                                                }
                                                fclose($fp);
                                        }
                                        else{

                                                if($adaEfaktur == true){

                                                        $path       = "./uploads/importCsv/ppn_masa/efaktur_keluaran/".$tahun_pajak."/".$bulan_pajak."_".$masa_pajak."/";

                                                        if($kode_cabang == "all" && count($nama_cabang) > 1){

                                                                $files_process = glob($path."{,.}*", GLOB_BRACE);
                                                                $i = 0;
                                                                foreach ($files_process as $file) {
                                                                        $fileCab = explode("_", $file);
                                                                        $endArr  = str_replace(".csv","",end($fileCab));
                                                                        if(in_array($endArr, $nama_cabang)){
                                                                                $filenya = $path."Ekspor_Efaktur_Keluaran_".$tahun_pajak."_".$masa_pajak."_".$pembetulan_ke."_".$nama_cabang[$i].".csv";
                                                                                if(file_exists($filenya)){
                                                                                        if($i == 0){
                                                                                                $dataFilePertama = file_get_contents($filenya);
                                                                                        }
                                                                                        if($i > 0){
                                                                                                $handle        = fopen($filenya, "r");
                                                                                                $row           = 0;
                                                                                                $dataX         = array();
                                                                                                $dataFileKeDua = array();
                                                                                                while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                                                                                                        if($row >= 3){
                                                                                                                $dataX[] = "\"".implode("\",\"", $data)."\"";
                                                                                                        }
                                                                                                        $row++;
                                                                                                }
                                                                                                $dataFileKeDua[] = implode("\n", $dataX);
                                                                                        }
                                                                                }
                                                                                $i++;
                                                                        }
                                                                        unset($fileCab);
                                                                }

                                                                $dataJoin = implode("\n", $dataFileKeDua);
                                                                $joinFile = $dataFilePertama.$dataJoin;
                                                                $filename = "Efaktur_Keluaran_Kompilasi_".$tahun_pajak."_".strtoupper(get_masa_pajak($bulan_pajak))."_".$pembetulan_ke;

                                                                $temp_memory = fopen('php://memory', 'w');
                                                                fwrite($temp_memory, $joinFile);
                                                                fseek($temp_memory, 0);
                                                                header('Content-Type: application/csv');
                                                                header('Content-Disposition: attachement; filename="'.$filename.'.csv";');
                                                                fpassthru($temp_memory);

                                                        }
                                                        else{

                                                                $file_url  = $path."Ekspor_Efaktur_Keluaran_".$tahun_pajak."_".$masa_pajak."_".$pembetulan_ke."_".$nama_cabang[0].".csv";
                                                                $filename = "Efaktur_Keluaran_".$tahun_pajak."_".strtoupper(get_masa_pajak($bulan_pajak))."_".$pembetulan_ke."_".$nama_cabang[0];
                                                        
                                                                if(file_exists($file_url)){
                                                                        header('Content-Type: application/octet-stream');
                                                                        header("Content-Transfer-Encoding: Binary"); 
                                                                        header('Content-Disposition: attachement; filename="'.$filename.'.csv";');
                                                                        readfile($file_url);
                                                                }
                                                        }
                                                }
                                        }
                                }
                                //End Create CSV File

                                //Upload file CSV Dokumen Lain Keluaran
                                $file = $path."/".$csvfilenamedk.".csv";
                                $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                                if (function_exists('curl_file_create')) { 
                                        $cFile = curl_file_create($path."/".$csvfilenamedk.".csv");
                                } else {  
                                        $cFile = '@' . realpath($path."/".$csvfilenamedk.".csv");
                                }
                                
                                $p_upl= array(
                                        "wp_id" => $wp_id,
                                        "file" => $cFile
                                );

                                $headers = array("Content-Type:multipart/form-data");
                                $request_upl = $this->apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                                $request_upl = json_decode($request_upl, true);

                                if(!empty($request_upl['detail'])){
                                        $insert_log['STATUS_UPLOAD_CSV'] = $request_upl['detail'];
                                } else {
                                        $insert_log['STATUS_UPLOAD_CSV'] = 'SUCCESS UPLOAD';
                                }
                
                                if(!empty($request_upl)){
                                        $encode_file_dk = $request_upl['name'];
                                        $origin_file_dk = $request_upl['origin'];
                                        $origin_file_dk = basename($origin_file_dk);
                                        $insert_log['ENCODE_FILE'] = $encode_file_dk;
                                        $insert_log['ORIGIN_FILE'] = $origin_file_dk;
                                }
                                //End upload Dokumen Lain Keluaran

                                //Import Dokumen Lain Keluaran
                                $url_imp_dk = $base_url."api/v1/wps/".$wp_id."/dokumen-keluaran-lives-import";
                                                
                                $p_imp_dk= array(
                                        "wpId" => "" . $wp_id . "",
                                        "name" => $encode_file_dk,
                                        "origin" => $origin_file_dk,
                                        "delimiter" => ";",
                                        "ext" => "csv",
                                        "branchCode" => $branch_code
                                );
                                
                                $params_imp_dk = json_encode($p_imp_dk);
                                $h_imp_dk = array("Content-Type:application/json");
                                $req_imp_dk = $this->apiimportcsv($url_imp_dk,$username,$password,$params_imp_dk,$h_imp_dk,$ch);
                                $req_imp_dk = json_decode($req_imp_dk, true); 
                                $id_import_dk = $req_imp_dk['id'];
                                //End Import Dokumen Lain Keluaran
                                        
                                if(!empty($req_imp_dk)) {

                                        if(!empty($req_imp_dk['detail'])){
                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_dk['detail'];
                                        } else {
                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_dk['status'];
                                        }
                                        $insert_log['FILE_ID'] = $req_imp_dk['id'];
                                        $insert_log['CREATED_BY'] = $req_imp_dk['createdBy'];
                                        $insert_log['CREATED_DATE'] = $req_imp_dk['createdDate'];
                                        $insert_log['LAST_MODIFIED_BY'] = $req_imp_dk['lastModifiedBy'];
                                        $insert_log['LAST_MODIFIED_DATE'] = $req_imp_dk['lastModifiedDate'];
                                        $insert_log['JUMLAH_ERROR_IMPORT'] = $req_imp_dk['error'];
                                }

                        
                                //Log Import
                                $urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dk; 
                
                                //GET Log Import
                                $api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
                                $datalog = json_decode($api_response, true);
                                
                                $idlog = "";
                                if(!empty($datalog)){
                                        $idlog = $datalog['id'];
                                        $insert_log['LOG_ID_IMPORT'] = $idlog;
                                        $insert_log['WP_ID'] = $datalog['wpId'];
                                        $insert_log['MODUL'] = $datalog['module'];
                                        $insert_log['STATUS_LOG_IMPORT'] = $datalog['status'];
                                        $insert_log['DELIMITED'] = $datalog['delimiter'];
                                        $insert_log['TOTAL'] = $datalog['total'];
                                        $insert_log['ERROR'] = $datalog['error'];
                                        $insert_log['JML_SUKSES_IMPORT'] = $datalog['count'];
                                }
                                //End Import Log

                                //detil log import
                                $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dk."/download"; 
                                $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                                $expl_datalog = explode(';', $dtldatalog);
                                $i=23;
                                $cnt_arr = count($expl_datalog);
                                $no=1;
                                $desc_log = "";
                                $txt_log = "";
                                $longtext = "";
                                for ($i = 1; ; $i++) {
                                        if ($i > ($cnt_arr-1)) {
                                                break;
                                        }
                                        if (strpos($expl_datalog[$i], '=====>') !== false) {
                                                $desc_log = substr($expl_datalog[$i], strpos($expl_datalog[$i], "[") + 1); 
                                                $txt_log = $no.".".$desc_log;
                                                $longtext .= substr($txt_log, 0, strpos($txt_log, "]"))." ";
                                                $no++;
                                        }
                                        
                                        
                                }
                                $insert_log['DESCRIPTION_LOG_IMPORT'] = $longtext;
                        //end
                                       
                                curl_close($ch);
                                $ins_tara = $this->tara->insertLog($insert_log);
                                if($ins_tara){
                                        echo '1';
                                } else {
                                        echo '2';   
                                }

                        } else {
                                $insert_log['BRANCH_CODE'] = $branch_code;
                                $insert_log['BRANCH_NAME'] = $branch_name;
                                $insert_log['PAJAK_HEADER_ID'] = 'XXXXXXX';
                                $insert_log['STATUS_UPLOAD_CSV'] = 'Error Dokumen Lain Keluaran(Tidak ada data yang di kirim data kosong)';
                                $insert_log['ENCODE_FILE'] = '';
                                $insert_log['ORIGIN_FILE'] = '';
                                $insert_log['STATUS_IMPORT_CSV'] = 'Error Dokumen Lain Keluaran (Tidak ada data yang di kirim data kosong)';
                                $insert_log['FILE_ID'] = '';
                                $insert_log['CREATED_BY'] = '';
                                $insert_log['CREATED_DATE'] = '';
                                $insert_log['LAST_MODIFIED_BY'] = '';
                                $insert_log['LAST_MODIFIED_DATE'] = '';
                                $insert_log['JUMLAH_ERROR_IMPORT'] = '';		
                                $insert_log['LOG_ID_IMPORT'] = '';
                                $insert_log['WP_ID'] = 0;
                                $insert_log['FILE_ID'] = 0;
                                $insert_log['LOG_ID_IMPORT'] = 0;
                                $insert_log['MODUL'] = 'Dokumen Lain Keluaran';
                                $insert_log['STATUS_LOG_IMPORT'] = 'Error';
                                $insert_log['DESCRIPTION_LOG_IMPORT'] = '';
                                $insert_log['DELIMITED'] = '';
                                $insert_log['TOTAL'] = 0;
                                $insert_log['ERROR'] = 0;
                                $insert_log['JML_SUKSES_IMPORT'] = 0;
                                curl_close($ch);
                                $ins_tara = $this->tara->insertLog($insert_log);
                                if($ins_tara){
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

        function send_to_tara_dm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable,$withAkun)
        {
                        ini_set('memory_limit', '-1');
		        $this->load->helper('csv_helper');
                        //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                        $csvfilenamedk = "";
                        
                        if ($kode_cabang == "000"){
                                $category_download = "kompilasi";
                        } else {
                                $category_download = "cabang";
                        }

                        if ($creditable != "creditable"){
                                $insert_log['IS_CREDITABLE'] = "N";
                        } else {
                                $insert_log['IS_CREDITABLE'] = "Y";
                        }

                        $insert_log['PEMBETULAN'] = $pembetulan_ke;
                        $insert_log['KODE_CABANG'] = $kode_cabang;

                        $url = $base_url.'api/v1/sign-in';
                        $params_string = json_encode($params);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);                                                                    
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
                                'Content-Type: application/json',                                                                                
                                'Content-Length: ' . strlen($params_string),
                                'User-Agent: Mozilla/5.0')                                                                       
                        );   
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        
                        $request = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                         if($httpCode == 200)
                         {
                                $result = json_decode($request, true);
                                $token_type = "Bearer ";
                                $utoken = $result['id_token'];
                                $urlwp = $base_url."api/v1/wps-mine"; 
                                
                                //GET WP
                                $api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
                                $data_wp = json_decode($api_response, true);
                                $id_wp = "";
                                foreach($data_wp as $row_wp){
                                        $wp_id = $row_wp['id'];
                                }

                                // Get Branch Code
                                $url_get_branch = $base_url."api/v1/wps/".$wp_id."/branches";
                                $api_branch = $this->getapiwp($token_type,$utoken,$url_get_branch,$base_url,$username,$password);
                                $data_branch = json_decode($api_branch, true);
                                $branch_code = "";
                                $branch_name = "";
                                $penandatangan = "";
                                $createdBy = "";
                                $createdDate = "";
                                foreach($data_branch as $row_branch){
                                        $branch_code = $row_branch['code'];
                                        $branch_name = $row_branch['name'];
                                        $penandatangan = $row_branch['penandatangan'];
                                        $createdBy = $row_branch['createdBy'];
                                        $createdDate = $row_branch['createdDate'];
                                }        
                                $insert_log['BRANCH_CODE'] = $branch_code;
                                $insert_log['BRANCH_NAME'] = $branch_name;

                                //Create CSV File
                                $date           = date("d", time());
                                $dokumen_lain   = array();
                                $faktur_standar = array();
                                
                                $groupByInvoiceNUm = false;
                                
                                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                                        $groupByInvoiceNUm = true;
                                }

                                if($category_download == "kompilasi" && $kode_cabang == "all"){
                                        $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        foreach ($get_pajak_header_id as $key => $value) {
                                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                                $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                                        }
                                }
                                else{
                                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                                        $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        $insert_log['PAJAK_HEADER_ID'] = $pajak_header_id;
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
                                        $tileDMFM,
                                        'JENIS_TRANSAKSI',
                                        'JENIS_DOKUMEN',
                                        'KD_JNS_TRANSAKSI',
                                        'FG_PENGGANTI',
                                        'NOMOR_DOK_LAIN_GANTI',
                                        'NOMOR_DOK_LAIN',
                                        'TANGGAL_DOK_LAIN',
                                        'MASA_PAJAK',
                                        'TAHUN_PAJAK',
                                        'NPWP',
                                        'NAMA',
                                        'ALAMAT_LENGKAP',
                                        'JUMLAH_DPP',
                                        'JUMLAH_PPN',
                                        'JUMLAH_PPNBM',
                                        'KETERANGAN',
                                        'BRANCH',
                                        'PAJAK_LINE_ID',
                                        'AKUN_BEBAN',
                                        'INVOICE_NUMBER',
                                        'MATA_UANG'
                                );

                                if($withAkun == 1){
                                        array_shift($title_dokumen_lain); 
                                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                                }
                                
                                if($nama_pajak == "PPN MASUKAN"){

                                        $title_faktur_standar = array(
                                                $tileDMFM,
                                                'KD_JENIS_TRANSAKSI',
                                                'FG_PENGGANTI',
                                                'NOMOR_FAKTUR',
                                                'MASA_PAJAK',
                                                'TAHUN_PAJAK',
                                                'TANGGAL_FAKTUR',
                                                'NPWP',
                                                'NAMA',
                                                'ALAMAT_LENGKAP',
                                                'JUMLAH_DPP',
                                                'JUMLAH_PPN',
                                                'JUMLAH_PPNBM',
                                                'IS_CREDITABLE',
                                                'BRANCH',
                                                'PAJAK_LINE_ID',
                                                'AKUN_BEBAN',
                                                'INVOICE_NUMBER',
                                                'MATA_UANG'
                                        );
                                        if($withAkun == 1){
                                                array_shift($title_faktur_standar); 
                                                array_unshift($title_faktur_standar, $tileDMFM, "AKUN");
                                        }

                                }

                                array_push($dokumen_lain, $title_dokumen_lain);
                                array_push($faktur_standar, $title_faktur_standar);
                                
                                $adaEfaktur = true;
                                
                                if (!empty($data) && count($data->result_array())>0 ) {
     
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
                        
                                                $npwp = format_npwp($row['NPWP1'], false);
                                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];
                        
                                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                                        $address = str_replace(' ',' ',$address);
                                                        $address = str_replace('\'','',$address);
                                                        $address = str_replace('"','',$address);
                                                        $address = str_replace('`','',$address);
                                                        $address = trim($address);
                                                        $address = trim(preg_replace('/\s\s+/', ' ', $address));
                        
                                                        $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                        
                                                if($pushDokLain){
                        
                                                        $arrDokumenLain = array(
                                                                ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                                $val_jenis_transaksi,
                                                                $val_jenis_dokumen,
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                $no_dokumen_lain_ganti,
                                                                $row['NO_DOKUMEN_LAIN'],
                                                                $tanggal_dokumen_lain,
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $dppNya,
                                                                $ppnNya,
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['KETERANGAN'],
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        );
                        
                                                        if($withAkun == 1){
                                                                        array_shift($arrDokumenLain); 
                                                                        array_unshift($arrDokumenLain,($nama_pajak == "PPN MASUKAN") ? "DM" : "DK", $row['AKUN_PAJAK']);
                                                        }
                                                        array_push($dokumen_lain, $arrDokumenLain);
                                                }
                        
                                                if($nama_pajak == "PPN MASUKAN"){
                
                                                        $arrFakturMasukan = array(
                                                                "FM",
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $tanggal_faktur,
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $row['DPP'],
                                                                $row['JUMLAH_POTONG_PPN'],
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['IS_CREDITABLE'],
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        );
                
                                                        if($withAkun == 1){
                                                                array_shift($arrFakturMasukan); 
                                                                array_unshift($arrFakturMasukan, "FM", $row['AKUN_PAJAK']);
                                                        }
                                                        array_push($faktur_standar, $arrFakturMasukan);
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

                                        if($nama_pajak == "PPN MASUKAN"){
                                                if($category == "dokumen_lain"){
                                                        //convert_to_csv($dokumen_lain, "Dokumen_Masukan_".$fileName.".csv", ";");
                                                        $csvfilenamedk = 'Dokumen_Lain_Masukan_'.$fileName;
                                                        $fp = fopen($path.'/'.$csvfilenamedk.'.csv', 'w');
                                                        foreach ($dokumen_lain as $line) {
                                                                fputcsv($fp, $line, ";");
                                                        }
                                                        fclose($fp);
                                                }
                                                else{
                                                        //convert_to_csv($faktur_standar, "Faktur_Masukan_".$fileName."_".$creditable.".csv", ";");
                                                        $csv_faktur_std_masukan = 'Faktur_Masukan_'.$fileName;
                                                        $fp = fopen($path.'/'.$csv_faktur_std_masukan.'.csv', 'w');
                                                        foreach ($dokumen_lain as $line) {
                                                                fputcsv($fp, $line, ";");
                                                        }
                                                        fclose($fp);
                                                }
                                        }
                                        
                                        //End Create CSV File

                                        //Upload file CSV Dokumen Lain Keluaran
                                        $file = $path."/".$csvfilenamedk.".csv";
                                        $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                                        if (function_exists('curl_file_create')) { 
                                                $cFile = curl_file_create($path."/".$csvfilenamedk.".csv");
                                        } else {  
                                                $cFile = '@' . realpath($path."/".$csvfilenamedk.".csv");
                                        }
                                        
                                        $p_upl= array(
                                                "wp_id" => $wp_id,
                                                "file" => $cFile
                                        );

                                        $headers = array("Content-Type:multipart/form-data");
                                        $request_upl = $this->apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                                        $request_upl = json_decode($request_upl, true);

                                        if(!empty($request_upl['detail'])){
                                                $insert_log['STATUS_UPLOAD_CSV'] = $request_upl['detail'];
                                        } else {
                                                $insert_log['STATUS_UPLOAD_CSV'] = 'SUCCESS UPLOAD';
                                        }
                        
                                        if(!empty($request_upl)){
                                                $encode_file_dk = $request_upl['name'];
                                                $origin_file_dk = $request_upl['origin'];
                                                $origin_file_dk = basename($origin_file_dk);
                                                $insert_log['ENCODE_FILE'] = $encode_file_dk;
                                                $insert_log['ORIGIN_FILE'] = $origin_file_dk;
                                        }
                                        //End upload Dokumen Lain Masukan

                                        //Import Dokumen Lain Masukan
                                        $url_imp_dk = $base_url."api/v1/wps/".$wp_id."/dokumen-masukan-lives-import";
                                                        
                                        $p_imp_dk= array(
                                                "wpId" => "" . $wp_id . "",
                                                "name" => $encode_file_dk,
                                                "origin" => $origin_file_dk,
                                                "delimiter" => ";",
                                                "ext" => "csv",
                                                "branchCode" => $branch_code
                                        );
                                        
                                        $params_imp_dk = json_encode($p_imp_dk);
                                        $h_imp_dk = array("Content-Type:application/json");
                                        $req_imp_dk = $this->apiimportcsv($url_imp_dk,$username,$password,$params_imp_dk,$h_imp_dk,$ch);
                                        $req_imp_dk = json_decode($req_imp_dk, true); 
                                        $id_import_dm = $req_imp_dk['id'];
                                        //End Import Dokumen Lain Masukan
                                                
                                        if(!empty($req_imp_dk)) {
                                        
                                                if(!empty($req_imp_dk['detail'])){
                                                        $insert_log['STATUS_IMPORT_CSV'] = $req_imp_dk['detail'];
                                                } else {
                                                        $insert_log['STATUS_IMPORT_CSV'] = $req_imp_dk['status'];
                                                }

                                                $insert_log['FILE_ID'] = $req_imp_dk['id'];
                                                $insert_log['CREATED_BY'] = $req_imp_dk['createdBy'];
                                                $insert_log['CREATED_DATE'] = $req_imp_dk['createdDate'];
                                                $insert_log['LAST_MODIFIED_BY'] = $req_imp_dk['lastModifiedBy'];
                                                $insert_log['LAST_MODIFIED_DATE'] = $req_imp_dk['lastModifiedDate'];
                                                $insert_log['JUMLAH_ERROR_IMPORT'] = $req_imp_dk['error'];
                                        }

                                
                                        //Log Import
                                        $urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm; 
                        
                                        //GET Log Import
                                        $api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
                                        $datalog = json_decode($api_response, true);
        
                                        $idlog = "";
                                        if(!empty($datalog)){
                                                $idlog = $datalog['id'];
                                                $insert_log['LOG_ID_IMPORT'] = $idlog;
                                                $insert_log['WP_ID'] = $datalog['wpId'];
                                                $insert_log['MODUL'] = $datalog['module'];
                                                $insert_log['STATUS_LOG_IMPORT'] = $datalog['status'];
                                                //$insert_log['DESCRIPTION_LOG_IMPORT'] = $datalog['description'];
                                                $insert_log['DELIMITED'] = $datalog['delimiter'];
                                                $insert_log['TOTAL'] = $datalog['total'];
                                                $insert_log['ERROR'] = $datalog['error'];
                                                $insert_log['JML_SUKSES_IMPORT'] = $datalog['count'];
                                        }
                                        //End Import Log

                                        //detil log import
                                                $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm."/download"; 
                                                $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                                                $expl_datalog = explode(';', $dtldatalog);
                                                $i=23;
                                                $cnt_arr = count($expl_datalog);
                                                $no=1;
                                                $desc_log = "";
                                                $txt_log = "";
                                                $longtext = "";
                                                for ($i = 1; ; $i++) {
                                                        if ($i > ($cnt_arr-1)) {
                                                                break;
                                                        }
                                                        if (strpos($expl_datalog[$i], '=====>') !== false) {
                                                                $desc_log = substr($expl_datalog[$i], strpos($expl_datalog[$i], "[") + 1); 
                                                                $txt_log = $no.".".$desc_log;
                                                                $longtext .= substr($txt_log, 0, strpos($txt_log, "]"))." ";
                                                                $no++;
                                                        }
                                                        
                                                        
                                                }
                                                $insert_log['DESCRIPTION_LOG_IMPORT'] = $longtext;
                                        //end


                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
                                           echo '1';
                                        } else {
                                           echo '2';   
                                        }


                                } else {
                                        $insert_log['BRANCH_CODE'] = $branch_code;
                                        $insert_log['BRANCH_NAME'] = $branch_name;
                                        $insert_log['PAJAK_HEADER_ID'] = 'XXXXXXX';
                                        $insert_log['STATUS_UPLOAD_CSV'] = 'Error Dokumen Lain Masukan (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['ENCODE_FILE'] = '';
                                        $insert_log['ORIGIN_FILE'] = '';
                                        $insert_log['STATUS_IMPORT_CSV'] = 'Error Dokumen Lain Masukan (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['FILE_ID'] = '';
                                        $insert_log['CREATED_BY'] = '';
                                        $insert_log['CREATED_DATE'] = '';
                                        $insert_log['LAST_MODIFIED_BY'] = '';
                                        $insert_log['LAST_MODIFIED_DATE'] = '';
                                        $insert_log['JUMLAH_ERROR_IMPORT'] = '';		
                                        $insert_log['LOG_ID_IMPORT'] = '';
                                        $insert_log['WP_ID'] = 0;
                                        $insert_log['FILE_ID'] = 0;
                                        $insert_log['LOG_ID_IMPORT'] = 0;
                                        $insert_log['MODUL'] = 'Dokumen Lain Masukan';
                                        $insert_log['STATUS_LOG_IMPORT'] = 'Error';
                                        $insert_log['DESCRIPTION_LOG_IMPORT'] = '';
                                        $insert_log['DELIMITED'] = '';
                                        $insert_log['TOTAL'] = 0;
                                        $insert_log['ERROR'] = 0;
                                        $insert_log['JML_SUKSES_IMPORT'] = 0;
                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
                                            echo '4';
                                        } else {
                                            echo '2';   
                                        }
                                }
             
                         } else {
                                //$result = json_decode($request, true);
                                echo '3';
                        }
 
        }


        function send_to_tara_fk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable,$withAkun)
        {
                        ini_set('memory_limit', '-1');
		        $this->load->helper('csv_helper');
                        //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                        $insert_log = array();
                        $csvfilenamefk = "";
                        
                        if ($kode_cabang == "000"){
                                $category_download = "kompilasi";
                        } else {
                                $category_download = "cabang";
                        }
                        
                        if ($creditable != "creditable" || $creditable === ""){
                                $insert_log['IS_CREDITABLE'] = "N";
                        } else {
                                $insert_log['IS_CREDITABLE'] = "Y";
                        }

                        $insert_log['PEMBETULAN'] = $pembetulan_ke;
                        $insert_log['KODE_CABANG'] = $kode_cabang;

                        $url = $base_url.'api/v1/sign-in';
                        $params_string = json_encode($params);
                        
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);                                                                    
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
                                'Content-Type: application/json',                                                                                
                                'Content-Length: ' . strlen($params_string),
                                'User-Agent: Mozilla/5.0')                                                                       
                        );   
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        
                        $request = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        
                         if($httpCode == 200)
                         {
                                $result = json_decode($request, true);
                                $token_type = "Bearer ";
                                $utoken = $result['id_token'];
                                $urlwp = $base_url."api/v1/wps-mine"; 
                                
                                //GET WP
                                $api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
                                $data_wp = json_decode($api_response, true);
                                $id_wp = "";
                                foreach($data_wp as $row_wp){
                                        $wp_id = $row_wp['id'];
                                }
                
                                // Get Branch Code
                                $url_get_branch = $base_url."api/v1/wps/".$wp_id."/branches";
                                $api_branch = $this->getapiwp($token_type,$utoken,$url_get_branch,$base_url,$username,$password);
                                $data_branch = json_decode($api_branch, true);
                                $branch_code = "";
                                $branch_name = "";
                                $penandatangan = "";
                                $createdBy = "";
                                $createdDate = "";
                                foreach($data_branch as $row_branch){
                                        $branch_code = $row_branch['code'];
                                        $branch_name = $row_branch['name'];
                                        $penandatangan = $row_branch['penandatangan'];
                                        $createdBy = $row_branch['createdBy'];
                                        $createdDate = $row_branch['createdDate'];
                                }        
                                $insert_log['BRANCH_CODE'] = $branch_code;
                                $insert_log['BRANCH_NAME'] = $branch_name;

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
                                        $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        foreach ($get_pajak_header_id as $key => $value) {
                                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                                $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                                        }
                                        
                                }
                                else{
                                        $get_pajak_header_id = $this->ppn_masa->get_pajak_header_id($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                                        $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
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

                                if($withAkun == 1){
                                        array_shift($title_dokumen_lain); 
                                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                                }
                                
                                if($nama_pajak == "PPN KELUARAN"){

                                        $title_faktur_standar = 
                                                        array(
                                                                $tileDMFM,
                                                                'KD_JENIS_TRANSAKSI',
                                                                'FG_PENGGANTI',
                                                                'NOMOR_FAKTUR',
                                                                'MASA_PAJAK',
                                                                'TAHUN_PAJAK',
                                                                'TANGGAL_FAKTUR',
                                                                'NPWP',
                                                                'NAMA',
                                                                'ALAMAT_LENGKAP',
                                                                'JUMLAH_DPP',
                                                                'JUMLAH_PPN',
                                                                'JUMLAH_PPNBM',
                                                                'ID_KETERANGAN_TAMBAHAN',
                                                                'FG_UANG_MUKA',
                                                                'UANG_MUKA_DPP',
                                                                'UANG_MUKA_PPN',
                                                                'UANG_MUKA_PPNBM',
                                                                'REFERENSI',
                                                                'BRANCH',
                                                                'PAJAK_LINE_ID',
                                                                'AKUN_PENDAPATAN',
                                                                'INVOICE_NUMBER',
                                                                'MATA_UANG'
                                                        );
                                $title_faktur_standar2 =                 
                                                        array(
                                                                'LT',
                                                                'NPWP',
                                                                'NAMA',
                                                                'JALAN',
                                                                'BLOK',
                                                                'NOMOR',
                                                                'RT',
                                                                'RW',
                                                                'KECAMATAN',
                                                                'KELURAHAN',
                                                                'KABUPATEN',
                                                                'PROPINSI',
                                                                'KODE_POS',
                                                                'NOMOR_TELEPON',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                ''
                                                        );
                                $title_faktur_standar3 =                         
                                                        array(
                                                                'OF',
                                                                'KODE_OBJEK',
                                                                'NAMA',
                                                                'HARGA_SATUAN',
                                                                'JUMLAH_BARANG',
                                                                'HARGA_TOTAL',
                                                                'DISKON',
                                                                'DPP',
                                                                'PPN',
                                                                'TARIF_PPNBM',
                                                                'PPNBM',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                ''
                                                        );

                                }
                                array_push($faktur_standar, $title_faktur_standar);
                                array_push($faktur_standar, $title_faktur_standar2);
                                array_push($faktur_standar, $title_faktur_standar3);
                                array_push($faktur_standar_efaktur, $title_faktur_standar);
                                array_push($faktur_standar_efaktur, $title_faktur_standar2);
                                array_push($faktur_standar_efaktur, $title_faktur_standar3);
                                
                                $adaEfaktur = true;
                                
                                if (!empty($data) && count($data->result_array())>0 ) {

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
                        
                                                $npwp = format_npwp($row['NPWP1'], false);
                                                //$npwp = format_npwp($row['NPWP1']);
                                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];
                        
                                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                                        $address = str_replace(' ',' ',$address);
                                                        $address = str_replace('\'','',$address);
                                                        $address = str_replace('"','',$address);
                                                        $address = str_replace('`','',$address);
                                                        $address = trim($address);
                                                        $address = trim(preg_replace('/\s\s+/', ' ', $address));
                        
                                                        $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                        
                                                if($pushDokLain){
                        
                                                        $arrDokumenLain = array(
                                                                ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                                $val_jenis_transaksi,
                                                                $val_jenis_dokumen,
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                $no_dokumen_lain_ganti,
                                                                $row['NO_DOKUMEN_LAIN'],
                                                                $tanggal_dokumen_lain,
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $dppNya,
                                                                $ppnNya,
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['KETERANGAN'],
                                                                $row['FAPR'],
                                                                $tanggal_approval
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
                                                                                "FK",
                                                                                $kd_jenis_transaksi,
                                                                                $fg_pengganti,
                                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                                $row['TAHUN_PAJAK'],
                                                                                $tanggal_faktur,
                                                                                $npwp,
                                                                                $row['VENDOR_NAME'],
                                                                                $alamatNya,
                                                                                $row['DPP'],
                                                                                $row['JUMLAH_POTONG_PPN'],
                                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                                $row['ID_KETERANGAN_TAMBAHAN'],
                                                                                ($row['FG_UANG_MUKA'] != "") ? $row['FG_UANG_MUKA'] : 0,
                                                                                ($row['UANG_MUKA_DPP'] != "") ? $row['UANG_MUKA_DPP'] : 0,
                                                                                ($row['UANG_MUKA_PPN'] != "") ? $row['UANG_MUKA_PPN'] : 0,
                                                                                ($row['UANG_MUKA_PPNBM'] != "") ? $row['UANG_MUKA_PPNBM'] : 0,
                                                                                $row['REFERENSI'],
                                                                                $kode_cabang,
                                                                                $row['PAJAK_LINE_ID'],
                                                                                $row['AKUN_PAJAK'],
                                                                                $row['INVOICE_NUM'],
                                                                                $row['INVOICE_CURRENCY_CODE']
                                                                        )
                                                                );

                                                                array_push($faktur_standar,
                                                                                array(
                                                                                        "OF",
                                                                                        "", 
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",
                                                                                        "",  
                                                                                )
                                                                        );
                                                        }
                                                        else{
                                                                $adaEfaktur = true;
                                                                $arrjson = "";
                                                                $arrjson = $row['JSON_KELUARAN'];
                                                                $arrjson = json_decode($arrjson);
                                                                if ($row['SOURCE_DATA'] == 'CSV'){
                                                                        array_push($faktur_standar_efaktur,
                                                                        array(
                                                                                "FK",
                                                                                $kd_jenis_transaksi,
                                                                                $fg_pengganti,
                                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                                $row['TAHUN_PAJAK'],
                                                                                $tanggal_faktur,
                                                                                $npwp,
                                                                                $row['VENDOR_NAME'],
                                                                                $alamatNya,
                                                                                $row['DPP'],
                                                                                $row['JUMLAH_POTONG_PPN'],
                                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                                $row['ID_KETERANGAN_TAMBAHAN'],
                                                                                ($row['FG_UANG_MUKA'] != "") ? $row['FG_UANG_MUKA'] : 0,
                                                                                ($row['UANG_MUKA_DPP'] != "") ? $row['UANG_MUKA_DPP'] : 0,
                                                                                ($row['UANG_MUKA_PPN'] != "") ? $row['UANG_MUKA_PPN'] : 0,
                                                                                ($row['UANG_MUKA_PPNBM'] != "") ? $row['UANG_MUKA_PPNBM'] : 0,
                                                                                $row['REFERENSI'],
                                                                                $kode_cabang,
                                                                                $row['PAJAK_LINE_ID'],
                                                                                $row['AKUN_PAJAK'],
                                                                                $row['INVOICE_NUM'],
                                                                                $row['INVOICE_CURRENCY_CODE']
                                                                        )
                                                                        );
                                                                        array_push($faktur_standar_efaktur,
                                                                                array(
                                                                                        $arrjson[1][0],
                                                                                        $arrjson[1][1], 
                                                                                        $arrjson[1][2],
                                                                                        $arrjson[1][3],
                                                                                        $arrjson[1][4],
                                                                                        $arrjson[1][5],
                                                                                        $arrjson[1][6],
                                                                                        $arrjson[1][7],
                                                                                        $arrjson[1][8],
                                                                                        $arrjson[1][9],
                                                                                        $arrjson[1][10],  
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
                                                        $csvfilenamedk = 'Dokumen_Keluaran_'.$fileName;
                                                        $fp = fopen($path.'/'.$csvfilenamedk.'.csv', 'w');
                                                        foreach ($dokumen_lain as $line) {
                                                                fputcsv($fp, $line, ";");
                                                        }
                                                        fclose($fp);
                                                }
                                                else{
                                                        $csvfilenamefk = 'Faktur_Keluaran_'.$fileName;
                                                        if ($adaEfaktur == true){
                                                                $fp = fopen($path.'/'.$csvfilenamefk.'.csv', 'w');
                                                                foreach ($faktur_standar_efaktur as $line) {
                                                                        fputcsv($fp, $line, ";");
                                                                }
                                                                fclose($fp);
                                                        } else {
                                                                $fp = fopen($path.'/'.$csvfilenamefk.'.csv', 'w');
                                                                foreach ($faktur_standar as $line) {
                                                                        fputcsv($fp, $line, ";");
                                                                }
                                                                fclose($fp);
                                                        }
                                                }
                                                
                                        }
                                        //End Create CSV File
        
                                         //Upload CSV FK
                                         $file = $path."/".$csvfilenamefk.".csv";
                                         $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";
         
                                         if (function_exists('curl_file_create')) {
                                                 $cFile = curl_file_create($path."/".$csvfilenamefk.".csv");
                                         } else {  
                                                 $cFile = '@' . realpath($path."/".$csvfilenamefk.".csv");
                                         }
                                         
                                         $p_upl= array(
                                                 "wp_id" => $wp_id,
                                                 "file" => $cFile
                                         );
         
                                         $headers = array("Content-Type:multipart/form-data");
                                         $request_upl = $this->apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                                         $request_upl = json_decode($request_upl, true);
                                         //End Upload CSV FK
        
                                         if(!empty($request_upl)){
        
                                                if(!empty($request_upl['detail'])){
                                                        $insert_log['STATUS_UPLOAD_CSV'] = $request_upl['detail'];
                                                }  else {
                                                        $insert_log['STATUS_UPLOAD_CSV'] = 'SUCCESS UPLOAD';
                                                } 
        
                                                if(!empty($request_upl)){
                                                        $encode_file_fK = $request_upl['name'];
                                                        $origin_file_fK = $request_upl['origin'];
                                                        $origin_file_fK = basename($origin_file_fK);
                                                        $insert_log['ENCODE_FILE'] = $encode_file_fK;
                                                        $insert_log['ORIGIN_FILE'] = $origin_file_fK;
                                                }        
                                                //Import Faktur Keluaran
                                                $url_imp_fk = $base_url."api/v1/wps/".$wp_id."/faktur-keluaran-lives-import";
                                                
                                                $p_imp_fk= array(
                                                        "wpId" => "" . $wp_id . "",
                                                        "name" => $encode_file_fK,
                                                        "origin" => $origin_file_fK,
                                                        "delimiter" => ";",
                                                        "ext" => "csv",
                                                        "branchCode" => $branch_code
                                                );
                                
                                                $params_imp_fk = json_encode($p_imp_fk);
                                                $h_imp_fk = array("Content-Type:application/json");
                                                $req_imp_fk = $this->apiimportcsv($url_imp_fk,$username,$password,$params_imp_fk,$h_imp_fk,$ch);
                                                $req_imp_fk = json_decode($req_imp_fk, true);
                                                $id_import_fk = $req_imp_fk['id'];
                                                //End Import Faktur Keluaran    
                        
                                                if(!empty($req_imp_fk)) {
        
                                                        if(!empty($req_imp_fk['detail'])){
                                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_fk['detail'];
                                                        } else {
                                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_fk['status'];
                                                        }
                                                        $insert_log['FILE_ID'] = $req_imp_fk['id'];
                                                        $insert_log['CREATED_BY'] = $req_imp_fk['createdBy'];
                                                        $insert_log['CREATED_DATE'] = $req_imp_fk['createdDate'];
                                                        $insert_log['LAST_MODIFIED_BY'] = $req_imp_fk['lastModifiedBy'];
                                                        $insert_log['LAST_MODIFIED_DATE'] = $req_imp_fk['lastModifiedDate'];
                                                        $insert_log['JUMLAH_ERROR_IMPORT'] = $req_imp_fk['error'];
                                                        
                                                }    
                                        }
        
                                        //Log Import
                                        $urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_fk; 
                        
                                        //GET Log Import
                                        $api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
                                        $datalog = json_decode($api_response, true);
           
                                        $idlog = "";
                                        if(!empty($datalog)){
                                                $idlog = $datalog['id'];
                                                $insert_log['LOG_ID_IMPORT'] = $idlog;
                                                $insert_log['WP_ID'] = $datalog['wpId'];
                                                $insert_log['MODUL'] = $datalog['module'];
                                                $insert_log['STATUS_LOG_IMPORT'] = $datalog['status'];
                                                $insert_log['DELIMITED'] = $datalog['delimiter'];
                                                $insert_log['TOTAL'] = $datalog['total'];
                                                $insert_log['ERROR'] = $datalog['error'];
                                                $insert_log['JML_SUKSES_IMPORT'] = $datalog['count'];
                                        }
                                        //End Import Log

                                        //detil log import
                                        $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_fk."/download"; 
                                        $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                                        $jsondatalog = json_decode($dtldatalog, true);
                                        $expl_datalog = explode(';', $dtldatalog);
                                        $i=23;
                                        $cnt_arr = count($expl_datalog);
                                        $no=1;
                                        $desc_log = "";
                                        $txt_log = "";
                                        $longtext = "";
                                        for ($i = 1; ; $i++) {
                                                if ($i > ($cnt_arr-1)) {
                                                        break;
                                                }
                                                if (strpos($expl_datalog[$i], '=====>') !== false) {
                                                        $desc_log = substr($expl_datalog[$i], strpos($expl_datalog[$i], "[") + 1); 
                                                        $txt_log = $no.".".$desc_log;
                                                        $longtext .= substr($txt_log, 0, strpos($txt_log, "]"))." ";
                                                        $no++;
                                                }
                                        }
                                        $insert_log['DESCRIPTION_LOG_IMPORT'] = $longtext;
                                       
                                        if($jsondatalog['status'] == 400){
                                                $insert_log['DESCRIPTION_LOG_IMPORT'] = 'Status:'.$jsondatalog['status'].' '.$jsondatalog['path'].' '.$jsondatalog['message'];
                                        }
                                //end

                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
                                            echo '1';
                                        } else {
                                            echo '2';   
                                        }

                                }  else {
                                        $insert_log['BRANCH_CODE'] = $branch_code;
                                        $insert_log['BRANCH_NAME'] = $branch_name;
                                        $insert_log['PAJAK_HEADER_ID'] = 'XXXXXXX';
                                        $insert_log['STATUS_UPLOAD_CSV'] = 'Error Faktur Keluaran (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['ENCODE_FILE'] = '';
                                        $insert_log['ORIGIN_FILE'] = '';
                                        $insert_log['STATUS_IMPORT_CSV'] = 'Error Faktur Keluaran (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['FILE_ID'] = '';
                                        $insert_log['CREATED_BY'] = '';
                                        $insert_log['CREATED_DATE'] = '';
                                        $insert_log['LAST_MODIFIED_BY'] = '';
                                        $insert_log['LAST_MODIFIED_DATE'] = '';
                                        $insert_log['JUMLAH_ERROR_IMPORT'] = '';		
                                        $insert_log['LOG_ID_IMPORT'] = '';
                                        $insert_log['WP_ID'] = 0;
                                        $insert_log['FILE_ID'] = 0;
                                        $insert_log['LOG_ID_IMPORT'] = 0;
                                        $insert_log['MODUL'] = 'Faktur Keluaran';
                                        $insert_log['STATUS_LOG_IMPORT'] = 'Error';
                                        $insert_log['DESCRIPTION_LOG_IMPORT'] = '';
                                        $insert_log['DELIMITED'] = '';
                                        $insert_log['TOTAL'] = 0;
                                        $insert_log['ERROR'] = 0;
                                        $insert_log['KODE_CABANG'] = $kode_cabang;
                                        $insert_log['JML_SUKSES_IMPORT'] = 0;
                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
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

        function send_to_tara_fm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,$category,$creditable,$withAkun)
        {
                        ini_set('memory_limit', '-1');
		        $this->load->helper('csv_helper');
                        //$this->kode_cabang  = $this->session->userdata('kd_cabang');

                        $csvfilenamefk = "";
                        $insert_log = array();
                        
                        if ($kode_cabang == "000"){
                                $category_download = "kompilasi";
                        } else {
                                $category_download = "cabang";
                        }

                        if ($creditable != "creditable"){
                                $insert_log['IS_CREDITABLE'] = "N";
                        } else {
                                $insert_log['IS_CREDITABLE'] = "Y";
                        }

                        $insert_log['PEMBETULAN'] = $pembetulan_ke;
                        $insert_log['KODE_CABANG'] = $kode_cabang;

                        $url = $base_url.'api/v1/sign-in';
                        $params_string = json_encode($params);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);                                                                    
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
                                'Content-Type: application/json',                                                                                
                                'Content-Length: ' . strlen($params_string),
                                'User-Agent: Mozilla/5.0')                                                                       
                        );   
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        
                        $request = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                         if($httpCode == 200)
                         {
                                $result = json_decode($request, true);
                                $token_type = "Bearer ";
                                $utoken = $result['id_token'];
                                $urlwp = $base_url."api/v1/wps-mine"; 
                                
                                //GET WP
                                $api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
                                $data_wp = json_decode($api_response, true);
                                $id_wp = "";
                                foreach($data_wp as $row_wp){
                                        $wp_id = $row_wp['id'];
                                }
                
                                // Get Branch Code
                                $url_get_branch = $base_url."api/v1/wps/".$wp_id."/branches";
                                $api_branch = $this->getapiwp($token_type,$utoken,$url_get_branch,$base_url,$username,$password);
                                $data_branch = json_decode($api_branch, true);
                                $branch_code = "";
                                $branch_name = "";
                                $penandatangan = "";
                                $createdBy = "";
                                $createdDate = "";
                                foreach($data_branch as $row_branch){
                                        $branch_code = $row_branch['code'];
                                        $branch_name = $row_branch['name'];
                                        $penandatangan = $row_branch['penandatangan'];
                                        $createdBy = $row_branch['createdBy'];
                                        $createdDate = $row_branch['createdDate'];
                                }        

                                $insert_log['BRANCH_CODE'] = $branch_code;
                                $insert_log['BRANCH_NAME'] = $branch_name;

                                //Create CSV File
                                $date           = date("d", time());
                                $dokumen_lain   = array();
                                $faktur_standar = array();
                                
                                $groupByInvoiceNUm = false;
                                
                                if($nama_pajak == "PPN KELUARAN" && $category == "dokumen_lain"){
                                        $groupByInvoiceNUm = true;
                                }

                                if($category_download == "kompilasi" && $kode_cabang == "all"){
                                        $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        foreach ($get_pajak_header_id as $key => $value) {
                                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                                $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                                        }
                                }
                                else{
                                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                                        $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                                        $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                                        $insert_log['PAJAK_HEADER_ID'] = $pajak_header_id;
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
                                        $tileDMFM,
                                        'JENIS_TRANSAKSI',
                                        'JENIS_DOKUMEN',
                                        'KD_JNS_TRANSAKSI',
                                        'FG_PENGGANTI',
                                        'NOMOR_DOK_LAIN_GANTI',
                                        'NOMOR_DOK_LAIN',
                                        'TANGGAL_DOK_LAIN',
                                        'MASA_PAJAK',
                                        'TAHUN_PAJAK',
                                        'NPWP',
                                        'NAMA',
                                        'ALAMAT_LENGKAP',
                                        'JUMLAH_DPP',
                                        'JUMLAH_PPN',
                                        'JUMLAH_PPNBM',
                                        'KETERANGAN',
                                        'FAPR',
                                        'TGL_APPROVAL',
                                        'BRANCH',
                                        'PAJAK_LINE_ID',
                                        'AKUN_BEBAN',
                                        'INVOICE_NUMBER',
                                        'MATA_UANG'
                                );

                                if($withAkun == 1){
                                        array_shift($title_dokumen_lain); 
                                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                                }
                                
                                if($nama_pajak == "PPN MASUKAN"){

                                        $title_faktur_standar = array(
                                                $tileDMFM,
                                                'KD_JENIS_TRANSAKSI',
                                                'FG_PENGGANTI',
                                                'NOMOR_FAKTUR',
                                                'MASA_PAJAK',
                                                'TAHUN_PAJAK',
                                                'TANGGAL_FAKTUR',
                                                'NPWP',
                                                'NAMA',
                                                'ALAMAT_LENGKAP',
                                                'JUMLAH_DPP',
                                                'JUMLAH_PPN',
                                                'JUMLAH_PPNBM',
                                                'IS_CREDITABLE',
                                                'BRANCH',
                                                'PAJAK_LINE_ID',
                                                'AKUN_BEBAN',
                                                'INVOICE_NUMBER',
                                                'MATA_UANG'
                                        );
                                        if($withAkun == 1){
                                                array_shift($title_faktur_standar); 
                                                array_unshift($title_faktur_standar, $tileDMFM, "AKUN");
                                        }

                                }
                                
                                array_push($dokumen_lain, $title_dokumen_lain);
                                array_push($faktur_standar, $title_faktur_standar);
                                
                                $adaEfaktur = true;
                                
                                if (!empty($data) && count($data->result_array())>0 ) {
                                                
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
                        
                                                $npwp = format_npwp($row['NPWP1'], false);
                                                $no_dokumen_lain_ganti = ($row['NO_DOKUMEN_LAIN_GANTI'] != "") ? $row['NO_DOKUMEN_LAIN_GANTI'] : $row['FAKTUR_ASAL'];
                        
                                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                                $address = str_replace(' ',' ',$address);
                                                $address = str_replace('\'','',$address);
                                                $address = str_replace('"','',$address);
                                                $address = str_replace('`','',$address);
                                                $address = trim($address);
                                                $address = trim(preg_replace('/\s\s+/', ' ', $address));
                                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
                        
                                                if($pushDokLain){
                        
                                                        $arrDokumenLain = array(
                                                                ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                                $val_jenis_transaksi,
                                                                $val_jenis_dokumen,
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                $no_dokumen_lain_ganti,
                                                                $row['NO_DOKUMEN_LAIN'],
                                                                $tanggal_dokumen_lain,
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $dppNya,
                                                                $ppnNya,
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['KETERANGAN'],
                                                                $row['FAPR'],
                                                                $tanggal_approval,
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        );
                        
                                                        if($withAkun == 1){
                                                                        array_shift($arrDokumenLain); 
                                                                        array_unshift($arrDokumenLain,($nama_pajak == "PPN MASUKAN") ? "DM" : "DK", $row['AKUN_PAJAK']);
                                                        }
                                                        array_push($dokumen_lain, $arrDokumenLain);
                                                }
                        
                                                if($nama_pajak == "PPN MASUKAN"){
                
                                                        $arrFakturMasukan = array(
                                                                "FM",
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $tanggal_faktur,
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $row['DPP'],
                                                                $row['JUMLAH_POTONG_PPN'],
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['IS_CREDITABLE'],
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        );
                
                                                        if($withAkun == 1){
                                                                array_shift($arrFakturMasukan); 
                                                                array_unshift($arrFakturMasukan, "FM", $row['AKUN_PAJAK']);
                                                        }
                                                        array_push($faktur_standar, $arrFakturMasukan);
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

                                        if($nama_pajak == "PPN MASUKAN"){
                                                if($category == "dokumen_lain"){
                                                        $csvfilenamedk = 'Dokumen_Masukan_'.$fileName;
                                                        $fp = fopen($path.'/'.$csvfilenamedk.'.csv', 'w');
                                                        foreach ($dokumen_lain as $line) {
                                                                fputcsv($fp, $line, ";");
                                                        }
                                                        fclose($fp);
                                                }
                                                else{
                                                        $csvfilenamefk = 'Faktur_Masukan_'.$fileName.'_'.$creditable;
                                                        $fp = fopen($path.'/'.$csvfilenamefk.'.csv', 'w');
                                                        foreach ($faktur_standar as $line) {
                                                                fputcsv($fp, $line, ";");
                                                        }
                                                        fclose($fp);
                                                }
                                        }
                                        
                                        //End Create CSV File

                                        //Upload CSV FK
                                        $file = $path."/".$csvfilenamefk.".csv";
                                        $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";
        
                                        if (function_exists('curl_file_create')) {
                                                $cFile = curl_file_create($path."/".$csvfilenamefk.".csv");
                                        } else {  
                                                $cFile = '@' . realpath($path."/".$csvfilenamefk.".csv");
                                        }
                                        
                                        $p_upl= array(
                                                "wp_id" => $wp_id,
                                                "file" => $cFile
                                        );
        
                                        $headers = array("Content-Type:multipart/form-data");
                                        $request_upl = $this->apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                                        $request_upl = json_decode($request_upl, true);
                                        //End Upload CSV FK

                                        if(!empty($request_upl)){

                                                if(!empty($request_upl['detail'])){
                                                        $insert_log['STATUS_UPLOAD_CSV'] = $request_upl['detail'];
                                                } else {
                                                        $insert_log['STATUS_UPLOAD_CSV'] = 'SUCCESS UPLOAD';
                                                }  


                                                $encode_file = $request_upl['name'];
                                                $origin_file = $request_upl['origin'];
                                                $origin_file = basename($origin_file);

                                                //UPLOAD FILE CSV Faktur Masukan
                                                $file = $path."/".$csvfilenamefk.".csv";
                                                $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                                                if (function_exists('curl_file_create')) { 
                                                        $cFile = curl_file_create($path."/".$csvfilenamefk.".csv");
                                                } else { 
                                                        $cFile = '@' . realpath($path."/".$csvfilenamefk.".csv");
                                                }
                                                
                                                $p_upl= array(
                                                        "wp_id" => $wp_id,
                                                        "file" => $cFile
                                                );

                                                $headers = array("Content-Type:multipart/form-data");
                                                $request_upl = $this->apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                                                $request_upl = json_decode($request_upl, true);
                                
                                                if(!empty($request_upl)){
                                                        $encode_file_fm = $request_upl['name'];
                                                        $origin_file_fm = $request_upl['origin'];
                                                        $origin_file_fm = basename($origin_file_fm);
                                                        $insert_log['ENCODE_FILE'] = $encode_file_fm;
                                                        $insert_log['ORIGIN_FILE'] = $origin_file_fm;
                                                }
                                                //END UPLOAD Faktur Masukan

                                                //Import Faktur Masukan
                                                $url_imp_fm = $base_url."api/v1/wps/".$wp_id."/faktur-masukan-lives-import";
                                                
                                                $p_imp_fm= array(
                                                        "wpId" => "" . $wp_id . "",
                                                        "name" => $encode_file_fm,
                                                        "origin" => $origin_file_fm,
                                                        "delimiter" => ";",
                                                        "ext" => "csv",
                                                        "branchCode" => $branch_code
                                                );
                                                
                                                $params_imp_fm = json_encode($p_imp_fm);
                                                $h_imp_fm = array("Content-Type:application/json");
                                                $req_imp_fm = $this->apiimportcsv($url_imp_fm,$username,$password,$params_imp_fm,$h_imp_fm,$ch);
                                                $req_imp_fm = json_decode($req_imp_fm, true); 
                                                $id_import_fk = $req_imp_fm['id'];
                                                //End Import Faktur Masukan  
                        
                                                if(!empty($req_imp_fm)) {
                                                        if(!empty($req_imp_fm['detail'])){
                                                                //echo "Informasi Import FK: ". $req_imp_fm['detail']."<br>";
                                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_fm['detail'];
                                                        } else {
                                                                $insert_log['STATUS_IMPORT_CSV'] = $req_imp_fm['status'];
                                                        }
                                                        $insert_log['FILE_ID'] = $req_imp_fm['id'];
                                                        $insert_log['CREATED_BY'] = $req_imp_fm['createdBy'];
                                                        $insert_log['CREATED_DATE'] = $req_imp_fm['createdDate'];
                                                        $insert_log['LAST_MODIFIED_BY'] = $req_imp_fm['lastModifiedBy'];
                                                        $insert_log['LAST_MODIFIED_DATE'] = $req_imp_fm['lastModifiedDate'];
                                                        $insert_log['JUMLAH_ERROR_IMPORT'] = $req_imp_fm['error'];
                                                }   
                                        }

                                        //Log Import
                                        $urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_fk; 
                        
                                        //GET Log Import
                                        $api_response = $this->getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
                                        $datalog = json_decode($api_response, true);
        
                                        $idlog = "";
                                        if(!empty($datalog)){
                                                $idlog = $datalog['id'];
                                                $insert_log['LOG_ID_IMPORT'] = $idlog;
                                                $insert_log['WP_ID'] = $datalog['wpId'];
                                                $insert_log['MODUL'] = $datalog['module'];
                                                $insert_log['STATUS_LOG_IMPORT'] = $datalog['status'];
                                                //$insert_log['DESCRIPTION_LOG_IMPORT'] = $datalog['description'];
                                                $insert_log['DELIMITED'] = $datalog['delimiter'];
                                                $insert_log['TOTAL'] = $datalog['total'];
                                                $insert_log['ERROR'] = $datalog['error'];
                                                $insert_log['JML_SUKSES_IMPORT'] = $datalog['count'];
                                        }
                                        //End Import Log

                                        //detil log import
                                        $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_fk."/download"; 
                                        $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                                        $expl_datalog = explode(';', $dtldatalog);
                                        $i=23;
                                        $cnt_arr = count($expl_datalog);
                                        $no=1;
                                        $desc_log = "";
                                        $txt_log = "";
                                        $longtext = "";
                                        for ($i = 1; ; $i++) {
                                                if ($i > ($cnt_arr-1)) {
                                                        break;
                                                }
                                                if (strpos($expl_datalog[$i], '=====>') !== false) {
                                                        $desc_log = substr($expl_datalog[$i], strpos($expl_datalog[$i], "[") + 1); 
                                                        $txt_log = $no.".".$desc_log;
                                                        $longtext .= substr($txt_log, 0, strpos($txt_log, "]"))." ";
                                                        $no++;
                                                }
                                                
                                                
                                        }
                                        $insert_log['DESCRIPTION_LOG_IMPORT'] = $longtext;
                                //end

                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
                                          echo '1';
                                        } else {
                                          echo '2';   
                                        }

                                } else {
                                        $insert_log['BRANCH_CODE'] = $branch_code;
                                        $insert_log['BRANCH_NAME'] = $branch_name;
                                        $insert_log['PAJAK_HEADER_ID'] = 'XXXXXXX';
                                        $insert_log['STATUS_UPLOAD_CSV'] = 'Error Faktur Masukan (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['ENCODE_FILE'] = '';
                                        $insert_log['ORIGIN_FILE'] = '';
                                        $insert_log['STATUS_IMPORT_CSV'] = 'Error Faktur Masukan (Tidak ada data yang di kirim data kosong)';
                                        $insert_log['FILE_ID'] = '';
                                        $insert_log['CREATED_BY'] = '';
                                        $insert_log['CREATED_DATE'] = '';
                                        $insert_log['LAST_MODIFIED_BY'] = '';
                                        $insert_log['LAST_MODIFIED_DATE'] = '';
                                        $insert_log['JUMLAH_ERROR_IMPORT'] = '';		
                                        $insert_log['LOG_ID_IMPORT'] = '';
                                        $insert_log['WP_ID'] = 0;
                                        $insert_log['FILE_ID'] = 0;
                                        $insert_log['LOG_ID_IMPORT'] = 0;
                                        $insert_log['MODUL'] = 'Faktur Masukan';
                                        $insert_log['STATUS_LOG_IMPORT'] = 'Error';
                                        $insert_log['DESCRIPTION_LOG_IMPORT'] = '';
                                        $insert_log['DELIMITED'] = '';
                                        $insert_log['TOTAL'] = 0;
                                        $insert_log['ERROR'] = 0;
                                        $insert_log['JML_SUKSES_IMPORT'] = 0;
                                        curl_close($ch);
                                        $ins_tara = $this->tara->insertLog($insert_log);
                                        if($ins_tara){
                                            echo '4';
                                        } else {
                                            echo '2';   
                                        }
                                }
                                
                        } else {
                                //$result = json_decode($request, true);
                                echo '3';
                        }
               
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

        function apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch)
        {
                curl_setopt($ch, CURLOPT_URL, $url_upload);
                curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);   
                curl_setopt($ch, CURLOPT_POST,1);                                                                                            
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);                                                               
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $p_upl);  
                $request_upl = curl_exec($ch);

                return $request_upl;
        }

        function apiimportcsv($url_imp,$username,$password,$params_imp,$h_imp,$ch)
        {
                curl_setopt($ch, CURLOPT_URL, $url_imp);
                curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);                                                                     
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_imp);                                                                  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
                curl_setopt($ch, CURLOPT_HTTPHEADER, $h_imp);;   
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $req_imp = curl_exec($ch);
                if(!$req_imp){die("Connection Failure");}

                return $req_imp;
        }

        function refresh_tara() {
                //$username = 'test1';
                //$password = '123456';
                //$rme = TRUE;

                $sql1 = "select value from simtax_config_tara
                where 
                parameter = 'USERNAME'";				
                $query	= $this->db->query($sql1);
                $username	= $query->row()->VALUE;
                $sql2 = "select value from simtax_config_tara
                where 
                parameter = 'PASSWORD'";				
                $query	= $this->db->query($sql2);
                $password	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'RME'";				
                $query	= $this->db->query($sql3);
                $rme	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'BASE_URL'";				
                $query	= $this->db->query($sql3);
                $base_url	= $query->row()->VALUE;


                //$base_url = 'https://efaktur.indonesiaport.co.id/';
                $params= array(
                        "username" => $username,
                        "password" => $password,
                        "rememberMe" => $rme
                );
                
              $get_refresh =  $this->tara->action_refresh_tara($username,$password,$rme,$base_url,$params);
              return $get_refresh;
        }

        function download_csv_m($category_download, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category, $creditable="", $withAkun = 0)
        {
                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                //$kode_cabang   = $this->input->post('cabang_trx');
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
                        $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        foreach ($get_pajak_header_id as $key => $value) {
                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                        }
                }
                else{
                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
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
                        $tileDMFM,
                        'JENIS_TRANSAKSI',
                        'JENIS_DOKUMEN',
                        'KD_JNS_TRANSAKSI',
                        'FG_PENGGANTI',
                        'NOMOR_DOK_LAIN_GANTI',
                        'NOMOR_DOK_LAIN',
                        'TANGGAL_DOK_LAIN',
                        'MASA_PAJAK',
                        'TAHUN_PAJAK',
                        'NPWP',
                        'NAMA',
                        'ALAMAT_LENGKAP',
                        'JUMLAH_DPP',
                        'JUMLAH_PPN',
                        'JUMLAH_PPNBM',
                        'KETERANGAN',
                        'FAPR',
                        'TGL_APPROVAL',
                        'BRANCH',
                        'PAJAK_LINE_ID',
                        'AKUN_BEBAN',
                        'INVOICE_NUMBER',
                        'MATA_UANG'
                );

                if($withAkun == 1){
                        array_shift($title_dokumen_lain); 
                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                }
                        
                if($nama_pajak == "PPN MASUKAN"){

                        $title_faktur_standar = array(
                                $tileDMFM,
                                'KD_JENIS_TRANSAKSI',
                                'FG_PENGGANTI',
                                'NOMOR_FAKTUR',
                                'MASA_PAJAK',
                                'TAHUN_PAJAK',
                                'TANGGAL_FAKTUR',
                                'NPWP',
                                'NAMA',
                                'ALAMAT_LENGKAP',
                                'JUMLAH_DPP',
                                'JUMLAH_PPN',
                                'JUMLAH_PPNBM',
                                'IS_CREDITABLE',
                                'BRANCH',
                                'PAJAK_LINE_ID',
                                'AKUN_BEBAN',
                                'INVOICE_NUMBER',
                                'MATA_UANG'
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
        
                                $address = utf8_encode($row['ADDRESS_LINE1']);
                                $address = str_replace(' ',' ',$address);
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));
                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
        
                                if($pushDokLain){
        
                                        $arrDokumenLain = array(
                                                ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                $val_jenis_transaksi,
                                                $val_jenis_dokumen,
                                                $kd_jenis_transaksi,
                                                $fg_pengganti,
                                                $no_dokumen_lain_ganti,
                                                $row['NO_DOKUMEN_LAIN'],
                                                $tanggal_dokumen_lain,
                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                $row['TAHUN_PAJAK'],
                                                $npwp,
                                                $row['VENDOR_NAME'],
                                                $alamatNya,
                                                $dppNya,
                                                $ppnNya,
                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                $row['KETERANGAN'],
                                                $row['FAPR'],
                                                $tanggal_approval,
                                                $kode_cabang,
                                                $row['PAJAK_LINE_ID'],
                                                $row['AKUN_PAJAK'],
                                                $row['INVOICE_NUM'],
                                                $row['INVOICE_CURRENCY_CODE']
                                        );
        
                                        if($withAkun == 1){
                                                array_shift($arrDokumenLain); 
                                                array_unshift($arrDokumenLain,($nama_pajak == "PPN MASUKAN") ? "DM" : "DK", $row['AKUN_PAJAK']);
                                        }
                                        array_push($dokumen_lain, $arrDokumenLain);
                                }
        
                                if($nama_pajak == "PPN MASUKAN"){

                                        $arrFakturMasukan = array(
                                                "FM",
                                                $kd_jenis_transaksi,
                                                $fg_pengganti,
                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                $row['TAHUN_PAJAK'],
                                                $tanggal_faktur,
                                                $npwp,
                                                $row['VENDOR_NAME'],
                                                $alamatNya,
                                                $row['DPP'],
                                                $row['JUMLAH_POTONG_PPN'],
                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                $row['IS_CREDITABLE'],
                                                $kode_cabang,
                                                $row['PAJAK_LINE_ID'],
                                                $row['AKUN_PAJAK'],
                                                $row['INVOICE_NUM'],
                                                $row['INVOICE_CURRENCY_CODE']
                                        );

                                        if($withAkun == 1){
                                                array_shift($arrFakturMasukan); 
                                                array_unshift($arrFakturMasukan, "FM", $row['AKUN_PAJAK']);
                                        }
                                        array_push($faktur_standar, $arrFakturMasukan);
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
                        $data       = $this->tara->get_csv_tara("", "", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang = $this->tara->get_cabang_in_header_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara("", $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        foreach ($get_pajak_header_id as $key => $value) {
                                $pajak_header_id[] = $value['PAJAK_HEADER_ID'];
                                $insert_log['PAJAK_HEADER_ID'] = $value['PAJAK_HEADER_ID'];
                        }
                }
                else{
                        $get_pajak_header_id = $this->tara->get_pajak_header_id_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
                        $pajak_header_id     = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
                        $data                = $this->tara->get_csv_tara($pajak_header_id, $kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $category_download, $category, $creditable, $groupByInvoiceNUm);
                        $get_cabang          = $this->tara->get_cabang_in_header_tara($kode_cabang, $nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke);
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
                        $tileDMFM,
                        'JENIS_TRANSAKSI',
                        'JENIS_DOKUMEN',
                        'KD_JNS_TRANSAKSI',
                        'FG_PENGGANTI',
                        'NOMOR_DOK_LAIN_GANTI',
                        'NOMOR_DOK_LAIN',
                        'TANGGAL_DOK_LAIN',
                        'MASA_PAJAK',
                        'TAHUN_PAJAK',
                        'NPWP',
                        'NAMA',
                        'ALAMAT_LENGKAP',
                        'JUMLAH_DPP',
                        'JUMLAH_PPN',
                        'JUMLAH_PPNBM',
                        'KETERANGAN',
                        'FAPR',
                        'TGL_APPROVAL',
                        'BRANCH',
                        'PAJAK_LINE_ID',
                        'AKUN_BEBAN',
                        'INVOICE_NUMBER',
                        'MATA_UANG'
                );

                if($withAkun == 1){
                        array_shift($title_dokumen_lain); 
                        array_unshift($title_dokumen_lain, $tileDMFM, "AKUN");
                }
                
                if($nama_pajak == "PPN KELUARAN"){

                        $title_faktur_standar = array(
                                        $tileDMFM,
                                        'KD_JENIS_TRANSAKSI',
                                        'FG_PENGGANTI',
                                        'NOMOR_FAKTUR',
                                        'MASA_PAJAK',
                                        'TAHUN_PAJAK',
                                        'TANGGAL_FAKTUR',
                                        'NPWP',
                                        'NAMA',
                                        'ALAMAT_LENGKAP',
                                        'JUMLAH_DPP',
                                        'JUMLAH_PPN',
                                        'JUMLAH_PPNBM',
                                        'ID_KETERANGAN_TAMBAHAN',
                                        'FG_UANG_MUKA',
                                        'UANG_MUKA_DPP',
                                        'UANG_MUKA_PPN',
                                        'UANG_MUKA_PPNBM',
                                        'REFERENSI',
                                        'BRANCH',
                                        'PAJAK_LINE_ID',
                                        'AKUN_BEBAN',
                                        'INVOICE_NUMBER',
                                        'MATA_UANG'
                                        );

                                        $title_faktur_standar2 =                 
                                                        array(
                                                                'LT',
                                                                'NPWP',
                                                                'NAMA',
                                                                'JALAN',
                                                                'BLOK',
                                                                'NOMOR',
                                                                'RT',
                                                                'RW',
                                                                'KECAMATAN',
                                                                'KELURAHAN',
                                                                'KABUPATEN',
                                                                'PROPINSI',
                                                                'KODE_POS',
                                                                'NOMOR_TELEPON',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                '',
                                                                ''
                                                        );
                                        $title_faktur_standar3 =                         
                                                array(
                                                        'OF',
                                                        'KODE_OBJEK',
                                                        'NAMA',
                                                        'HARGA_SATUAN',
                                                        'JUMLAH_BARANG',
                                                        'HARGA_TOTAL',
                                                        'DISKON',
                                                        'DPP',
                                                        'PPN',
                                                        'TARIF_PPNBM',
                                                        'PPNBM',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        ''
                                                );
                }

                array_push($dokumen_lain, $title_dokumen_lain);
                array_push($faktur_standar, $title_faktur_standar);
                array_push($faktur_standar, $title_faktur_standar2);
                array_push($faktur_standar, $title_faktur_standar3);
                array_push($faktur_standar_efaktur, $title_faktur_standar);
                array_push($faktur_standar_efaktur, $title_faktur_standar2);
                array_push($faktur_standar_efaktur, $title_faktur_standar3);
                
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
                                $address = str_replace('\'','',$address);
                                $address = str_replace('"','',$address);
                                $address = str_replace('`','',$address);
                                $address = trim($address);
                                $address = trim(preg_replace('/\s\s+/', ' ', $address));

                                $alamatNya = preg_replace("/[\r\n]+/", " ", $address);
        
                                if($pushDokLain){
        
                                        $arrDokumenLain = array(
                                                ($nama_pajak == "PPN MASUKAN") ? "DM" : "DK",
                                                $val_jenis_transaksi,
                                                $val_jenis_dokumen,
                                                $kd_jenis_transaksi,
                                                $fg_pengganti,
                                                $no_dokumen_lain_ganti,
                                                $row['NO_DOKUMEN_LAIN'],
                                                $tanggal_dokumen_lain,
                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                $row['TAHUN_PAJAK'],
                                                $npwp,
                                                $row['VENDOR_NAME'],
                                                $alamatNya,
                                                $dppNya,
                                                $ppnNya,
                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                $row['KETERANGAN'],
                                                $kode_cabang,
                                                $row['PAJAK_LINE_ID'],
                                                $row['AKUN_PAJAK'],
                                                $row['INVOICE_NUM'],
                                                $row['INVOICE_CURRENCY_CODE']
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
                                                                "FK",
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $tanggal_faktur,
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $row['DPP'],
                                                                $row['JUMLAH_POTONG_PPN'],
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['ID_KETERANGAN_TAMBAHAN'],
                                                                ($row['FG_UANG_MUKA'] != "") ? $row['FG_UANG_MUKA'] : 0,
                                                                ($row['UANG_MUKA_DPP'] != "") ? $row['UANG_MUKA_DPP'] : 0,
                                                                ($row['UANG_MUKA_PPN'] != "") ? $row['UANG_MUKA_PPN'] : 0,
                                                                ($row['UANG_MUKA_PPNBM'] != "") ? $row['UANG_MUKA_PPNBM'] : 0,
                                                                $row['REFERENSI'],
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        )
                                                );
                                                array_push($faktur_standar,
                                                                array(
                                                                        "OF",
                                                                        "", 
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                        "",
                                                                )
                                                        );
                                        }
                                        else{
                                                $adaEfaktur = true;
                                                $arrjson = "";
                                                $arrjson = $row['JSON_KELUARAN'];
                                                $arrjson = json_decode($arrjson);
                                                if ($row['SOURCE_DATA'] == 'CSV'){
                                                        array_push($faktur_standar_efaktur,
                                                        array(
                                                                "FK",
                                                                $kd_jenis_transaksi,
                                                                $fg_pengganti,
                                                                str_replace(".","", str_replace("-","",substr($row['NO_FAKTUR_PAJAK'], 3))),
                                                                sprintf("%02d", $row['BULAN_PAJAK']),
                                                                $row['TAHUN_PAJAK'],
                                                                $tanggal_faktur,
                                                                $npwp,
                                                                $row['VENDOR_NAME'],
                                                                $alamatNya,
                                                                $row['DPP'],
                                                                $row['JUMLAH_POTONG_PPN'],
                                                                ($row['JUMLAH_PPNBM'] != "") ? $row['JUMLAH_PPNBM'] : 0,
                                                                $row['ID_KETERANGAN_TAMBAHAN'],
                                                                ($row['FG_UANG_MUKA'] != "") ? $row['FG_UANG_MUKA'] : 0,
                                                                ($row['UANG_MUKA_DPP'] != "") ? $row['UANG_MUKA_DPP'] : 0,
                                                                ($row['UANG_MUKA_PPN'] != "") ? $row['UANG_MUKA_PPN'] : 0,
                                                                ($row['UANG_MUKA_PPNBM'] != "") ? $row['UANG_MUKA_PPNBM'] : 0,
                                                                $row['REFERENSI'],
                                                                $kode_cabang,
                                                                $row['PAJAK_LINE_ID'],
                                                                $row['AKUN_PAJAK'],
                                                                $row['INVOICE_NUM'],
                                                                $row['INVOICE_CURRENCY_CODE']
                                                        )
                                                        );
                                                        array_push($faktur_standar_efaktur,
                                                                array(
                                                                        $arrjson[1][0],
                                                                        $arrjson[1][1], 
                                                                        $arrjson[1][2],
                                                                        $arrjson[1][3],
                                                                        $arrjson[1][4],
                                                                        $arrjson[1][5],
                                                                        $arrjson[1][6],
                                                                        $arrjson[1][7],
                                                                        $arrjson[1][8],
                                                                        $arrjson[1][9],
                                                                        $arrjson[1][10],  
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
                //$this->kode_cabang  = $this->session->userdata('kd_cabang');
                $sql0 = "select value from simtax_config_tara
						where 
                                                parameter = 'DOC_ROOT_UPLOAD'";				
		$query	= $this->db->query($sql0);
		$docrootupl = $query->row()->VALUE;
                $sql1 = "select value from simtax_config_tara
						where 
                                                parameter = 'USERNAME'";				
		$query	= $this->db->query($sql1);
		$username	= $query->row()->VALUE;
                $sql2 = "select value from simtax_config_tara
                where 
                parameter = 'PASSWORD'";				
                $query	= $this->db->query($sql2);
                $password	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'RME'";				
                $query	= $this->db->query($sql3);
                $rme	= $query->row()->VALUE;

                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'BASE_URL'";				
                $query	= $this->db->query($sql3);
                $base_url	= $query->row()->VALUE;

                //define("DOC_ROOT_UPLOAD","/var/www/html/simtax/uploads");
                define("DOC_ROOT_UPLOAD",$docrootupl);
                $path = DOC_ROOT_UPLOAD."/tara";
 
                $params= array(
                        "username" => $username,
                        "password" => $password,
                        "rememberMe" => $rme
                );
                $cookie_file_path = $path."/cookie.txt";
                $bulan_pajak = $this->input->post('bulan');
                $tahun_pajak = $this->input->post('tahun');
                $pajak = $this->input->post('pajak');
                $nama_pajak = $this->input->post('jenisPajak');
                $kode_cabang   = $this->input->post('kode_cabang');
                $pembetulan_ke = $this->input->post('pembetulanKe');
                $creditable = $this->input->post('creditable');
                $modul = $this->input->post('modul');
                $withAkun = "";

                if($nama_pajak == "PPN MASUKAN"){
                        if ($modul == "Faktur Masukan"){
                                if($creditable != "Y") {
                                        $this->send_to_tara_fm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","not_creditable",$withAkun);
                                } else {
                                        $this->send_to_tara_fm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","creditable",$withAkun);
                                }
                        } else {
                                $this->send_to_tara_dm($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                        }   
                } else {
                        if ($modul == "Faktur Keluaran"){
                                $this->send_to_tara_fk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"faktur_standar","","");
                        } else {
                                $this->send_to_tara_dk($username,$password,$path,$rme,$base_url,$params,$cookie_file_path,$bulan_pajak,$tahun_pajak,$pajak,$nama_pajak,$kode_cabang,$pembetulan_ke,"dokumen_lain",$creditable,$withAkun);
                        }
                        
                        
                }
        }


        //Config Tara
	function config_tara()
	{
		$this->template->set('title', 'Config Tara');
		$data['subtitle']	= "Config Tara";
		$data['activepage'] = "master_data";
		$this->template->load('template', 'tara_pajakku/config_tara',$data);
	}	


	function load_config_tara()
	{
		$result	= $this->tara->get_cfg_tara();	
		echo json_encode($result);
	}

	function save_config_tara()
	{
		
		if (isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('edit_parameter', 'PARAMETER', 'required');
                        $this->form_validation->set_rules('edit_value', 'VALUE', 'required');

			if ($this->form_validation->run() === TRUE)
			{	
				$parameter = $this->input->post('edit_parameter');
				$isnewrecord = $this->input->post('isNewRecord');

				$check_duplicate_param = $this->tara->check_duplic_config_tara($parameter);
				
                                if ($isnewrecord != "0") {
                                        if($check_duplicate_param > 0){
                                                echo '3';
                                                die();
                                        }
                                        else{
        
                                                $data	= $this->tara->action_save_config_tara($parameter);
                                                if($data){
                                                        echo '1';
                                                } else {
                                                        echo '0';
                                                }
                                                
                                        }
                                } else {
                                        $data	= $this->tara->action_save_config_tara($parameter);
                                        if($data){
                                                echo '1';
                                        } else {
                                                echo '0';
                                        }
                                }
				
			}else
			{
				echo validation_errors();
			}
		}
	}

	function delete_config_tara() 
	{
			$data	= $this->tara->action_delete_config_tara();
			if($data){
				echo '1';
			} else {
				echo '2';
			}
			
	}


	//End Config Tara

        function export_log_by_file_id($vfileid,$vmodul,$blnpjk,$thnpjk,$nmcbg){

                ini_set('memory_limit', '-1');
                $this->load->helper('csv_helper');
                $this->kode_cabang  = $this->session->userdata('kd_cabang');
                $sql0 = "select value from simtax_config_tara
						where 
                                                parameter = 'DOC_ROOT_UPLOAD'";				
		$query	= $this->db->query($sql0);
		$docrootupl = $query->row()->VALUE;
                $sql1 = "select value from simtax_config_tara
						where 
                                                parameter = 'USERNAME'";				
		$query	= $this->db->query($sql1);
		$username	= $query->row()->VALUE;
                $sql2 = "select value from simtax_config_tara
                where 
                parameter = 'PASSWORD'";				
                $query	= $this->db->query($sql2);
                $password	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'RME'";				
                $query	= $this->db->query($sql3);
                $rme	= $query->row()->VALUE;
                $sql3 = "select value from simtax_config_tara
                where 
                parameter = 'BASE_URL'";				
                $query	= $this->db->query($sql3);
                $base_url	= $query->row()->VALUE;
				
                define("DOC_ROOT_UPLOAD",$docrootupl);
                $path = DOC_ROOT_UPLOAD."/tara";

                $params= array(
                        "username" => $username,
                        "password" => $password,
                        "rememberMe" => $rme
                );
                $cookie_file_path = $path."/cookie.txt";
                $bulan_pajak = $this->input->post('bulan');
                $tahun_pajak = $this->input->post('tahun');
                $pajak = $this->input->post('pajak');
                $nama_pajak = $this->input->post('jenisPajak');
                $kode_cabang   = $this->input->post('cabang_trx');
                $pembetulan_ke = $this->input->post('pembetulanKe');
                $creditable = "xx";
                $withAkun = "";
				
		$url = $base_url.'api/v1/sign-in';
                $params_string = json_encode($params); 

                $sqlcbg = "select nama_cabang from simtax_kode_cabang
                        where 
                        kode_cabang = '".$nmcbg."'";	
                                                
                        $querycbg	= $this->db->query($sqlcbg);
                        if(isset($querycbg->row()->NAMA_CABANG)){
                                $nmcbg	= $querycbg->row()->NAMA_CABANG;
                        } else {
                                $nmcbg	= $nmcbg;
                        }
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);                                                                    
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
                        'Content-Type: application/json',                                                                                
                        'Content-Length: ' . strlen($params_string),
                        'User-Agent: Mozilla/5.0')                                                                       
                );   
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                
                $request = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if($httpCode == 200)
                {
                        $result = json_decode($request, true);
                        $token_type = "Bearer ";
                        $utoken = $result['id_token'];
                        $urlwp = $base_url."api/v1/wps-mine"; 
                        
                        //GET WP
                        $api_response = $this->getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
                        $data_wp = json_decode($api_response, true);
                        $id_wp = "";
                        foreach($data_wp as $row_wp){
                                        $wp_id = $row_wp['id'];
                        }
                        
                        $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$vfileid."/download"; 
                        $dtldatalog = $this->getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                        $pieces = explode("=====>", $dtldatalog);
                        
                        $output_file_name = $vmodul."_".$blnpjk."_".$thnpjk."_".$nmcbg.".csv";
                        $temp_memory = fopen('php://memory', 'w');
                     
                        $vrow=1;
                        foreach ($pieces as $line) {
                                $line =str_replace(","," ",$line);
                                $val = explode(";", $line);
                                if($vrow > 1){
                                        
                                        if($val[17] != ""){
                                                $sql1 = "select nama_cabang from simtax_kode_cabang
						where 
                                                kode_cabang = '".$val[17]."'";	
                                                       			
                                                $query	= $this->db->query($sql1);
                                                if(isset($query->row()->NAMA_CABANG)){
                                                        $vcbg	= $query->row()->NAMA_CABANG;
                                                } else {
                                                        $vcbg	= $val[17];
                                                }
                                                
                                        } else {
                                                $vcbg = $val[17];
                                        }
                                        $vreplace = array(17 => $vcbg);
                                        $val = array_replace($val, $vreplace);               
                                }
                                
                                fputcsv($temp_memory, $val, ";");
                                $vrow++;
                        }
                        
                        fseek($temp_memory, 0);
                       
                        header('Content-Type: application/csv');
                        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
                       
                        fpassthru($temp_memory);
                
                }
                else {
                        echo '3';
                }  
                
        }
	
		
}