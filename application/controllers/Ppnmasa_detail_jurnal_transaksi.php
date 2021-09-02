<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppnmasa_detail_jurnal_transaksi extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('dashboard', 'refresh');
		}

		$this->load->model('ppnmasa_detail_jurnal_mdl', 'ppnmasa_jurnal');
		$this->load->model('cabang_mdl', 'cabang');
		$this->load->model('supplier_mdl', 'suplier');
		
		$this->kode_cabang  = $this->session->userdata('kd_cabang');
		$this->daftar_pajak = array("PPN MASUKAN", "PPN KELUARAN");
	}


    function load_detail_jurnal($header_id="")
	{

		$nama_pajak    = $this->input->post('_searchPpn');
		//$kode_cabang   = $this->kode_cabang;
		$kode_cabang   = $this->input->post('_searchCabang');
		$bulan_pajak   = $this->input->post('_searchBulan');
		$tahun_pajak   = $this->input->post('_searchTahun');
		$pembetulan_ke = $this->input->post('_searchPembetulan');
		$category      = $this->input->post('_category');
        $rowdata = array();

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;
			
        $start               = ($this->input->post('start')) ? $this->input->post('start') : 0;
        $length              = ($this->input->post('length')) ? $this->input->post('length') : 10;
        $draw                = ($this->input->post('draw')) ? $this->input->post('draw') : 0;
        $keywords            = (isset($_POST['search'])) ? $_POST['search']['value'] : '';
        
        $hasil               = $this->ppnmasa_jurnal->get_detail_jurnal($nama_pajak,$kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke,$category,$start, $length, $keywords);
        
        $rowCount            = $hasil['jmlRow'];
        $query               = $hasil['query'];
        $dokumenReturn       = "";
        
        if($rowCount > 0){

            $dlChecked = "";
            $fsChecked = "";

            foreach($query->result_array() as $row)	{

				switch ($row['BULAN_BUKU']) {
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

			   $tgl_posting    	= ($row['TANGGALPOSTING']) ? date("d/m/Y",strtotime($row['TANGGALPOSTING'])) : '';
			   $tgl_po    		= ($row['TANGGALPO']) ? date("d/m/Y",strtotime($row['TANGGALPO'])) : '';
			   $tgl_invoice    		= ($row['TANGGALINVOICE']) ? date("d/m/Y",strtotime($row['TANGGALINVOICE'])) : '';
               
                $rowdata[] = array(
                        'ledger_id'             => $row['LEDGER_ID'],
                        'period_name'           => $row['PERIOD_NAME'],
                        'user_je_source_name'   => $row['USER_JE_SOURCE_NAME'],
                        'docnumber'             => $row['DOCNUMBER'],
                        'nomor_faktur'          => $row['NOMOR_FAKTUR'],
                        'bulan_buku'            => $row['BULAN_BUKU'],
                        'tahun_buku'            => $row['TAHUN_BUKU'],
                        'tanggal_posting'       => $tgl_posting,
                        'desc_jenis_transaksi'  => $row['DESCJENISTRANSAKSI'],
                        'lineno'                => $row['LINENO'],
                        'account'               => $row['ACCOUNT'],
                        'descaccount'           => $row['DESCACCOUNT'],
                        'amount'                => $row['AMOUNT'],
                        'subledger'             => $row['SUBLEDGER'],
                        'codesubledger'         => $row['CODESUBLEDGER'],
                        'descsubledger'         => $row['DESCSUBLEDGER'],
                        'descriptionheader'     => $row['DESCRIPTIONHEADER'],
                        'referenceline'         => $row['REFERENCELINE'],
                        'profitcenter'          => $row['PROFITCENTER'],
                        'profitcenterdesc'      => $row['PROFITCENTERDESC'],
                        'costcenter'            => $row['COSTCENTER'],
                        'costcenterdesc'        => $row['COSTCENTERDESC'],
                        'ponumber'              => $row['PONUMBER'],
                        'tanggalpo'             => $tgl_po,
                        'kode_cabang'           => $row['KODE_CABANG'],
						'detail_jurnal_id'      => $row['DETAIL_JURNAL_ID'],
						'nomorinvoice'      	=> $row['NOMORINVOICE'],
						'tanggalinvoice'      	=> $tgl_invoice,
						'statusdokumen'      	=> $row['STATUSDOKUMEN'],
						'invoice_id'      		=> $row['INVOICE_ID']
                        );      
            }

            $query->free_result();

            $result['data']			   = $rowdata;
            $result['draw']            = $draw;
            $result['recordsTotal']    = $rowCount;
            $result['recordsFiltered'] = $rowCount;
            
            
        }
        else{
            $result['data']            = "";
            $result['draw']            = "";
            $result['recordsTotal']    = 0;
            $result['recordsFiltered'] = 0;
        }
    	
    	echo json_encode($result);
    }

    function save_detail_jurnal(){
		$return             	= false;
        
		$kode_cabang            = $this->kode_cabang;
		$idDetailJurnal         =  $this->input->post('idDetailJurnal');
		$isnewRecord           	=  $this->input->post('isnewRecord');
		$fAddNamaPajak          =  $this->input->post('fAddNamaPajak');
		$fAddBulan        		=  $this->input->post('fAddBulan');
		$fAddTahun         		=  $this->input->post('fAddTahun');
		$fAddPembetulan         =  $this->input->post('fAddPembetulan');
		$docnumber              =  $this->input->post('docnumber');
		$nofaktur               =  $this->input->post('nofaktur');
		$bulanbuku              =  $this->input->post('bulanbuku');
		$tahunbuku              =  $this->input->post('tahunbuku');
		$tanggalposting         =  ($this->input->post('tanggalposting')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggalposting')))) :'';
		$descjenistransaksi     =  $this->input->post('descjenistransaksi');
		$account           		=  $this->input->post('account');
		$descaccount     		=  $this->input->post('descaccount');
		$amount           		=  $this->input->post('amount');
		$codesubledger        	=  $this->input->post('codesubledger');
		$subledger        		=  $this->input->post('subledger');
		$descsubledger    		=  $this->input->post('descsubledger');
		$descriptionheader      =  $this->input->post('descriptionheader');
		$referenceline          =  $this->input->post('referenceline');
		$profitcenter           =  $this->input->post('profitcenter');
		$profitcenterdesc       =  $this->input->post('profitcenterdesc');
		$costcenter             =  $this->input->post('costcenter');
		$costcenterdesc         =  $this->input->post('costcenterdesc');
		$ponumber          		=  $this->input->post('ponumber');
		$tanggalpo 				=  ($this->input->post('tanggalpo')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggalpo')))) :'';
		$kd_cabang           	=  $this->input->post('kd_cabang');
		$lineno          		=  $this->input->post('lineno');
		$nomorinvoice          	=  $this->input->post('nomorinvoice');
		$tanggalinvoice         =  ($this->input->post('tanggalinvoice')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggalinvoice')))) :'';


		$data = array(
						'DOCNUMBER'         	=> $docnumber,
						'NOMOR_FAKTUR'          => $nofaktur,
						'BULAN_BUKU'            => $bulanbuku,
						'TAHUN_BUKU'            => $tahunbuku,
						'DESCJENISTRANSAKSI'    => $descjenistransaksi,
						'LINENO'     			=> $lineno,
						'ACCOUNT'           	=> $account,
						'DESCACCOUNT'           => $descaccount,
						'AMOUNT'          		=> $amount,
						'SUBLEDGER'        		=> $subledger,
						'CODESUBLEDGER'         => $codesubledger,
						'DESCSUBLEDGER'         => $descsubledger,
						'DESCRIPTIONHEADER' 	=> $descriptionheader,
						'REFERENCELINE'         => $referenceline,
						'PROFITCENTER'          => $profitcenter,
						'PROFITCENTERDESC'      => $profitcenterdesc,
						'COSTCENTER'        	=> $costcenter,
						'COSTCENTERDESC'        => $costcenterdesc,
						'PONUMBER'        		=> $ponumber,
						'KODE_CABANG'  			=> $kd_cabang,
						'NOMORINVOICE'          => $nomorinvoice,
						'USER_SIMTAX'			=> $this->session->userdata('identity'),
					);
		if ($this->ppnmasa_jurnal->update_detail_jurnal($idDetailJurnal, $data, $tanggalposting, $tanggalpo, $tanggalinvoice)) 
		{
			echo '1';
		}
		else{
			echo '0';
		}
	}

	function delete_detail_jurnal()
	{
		$detail_jurnal_id   = $this->input->post('idDetailJurnal');

		$data = $this->ppnmasa_jurnal->delete_jurnal_detail($detail_jurnal_id);

		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}

	function export_format_csv(){

		ini_set('memory_limit', '-1');

		$this->load->helper('csv_helper');
		
		$kode_cabang    = $this->kode_cabang;
		$nama_pajak     = $this->input->get('pajak');
		$bulan_pajak    = $this->input->get('masa');
		$tahun_pajak    = $this->input->get('tahun');
		$pembetulan_ke  = $this->input->get('pembetulan');
		
		$date           = date("d", time());
		$dokumen_lain   = array();
		$faktur_standar = array();
		
		$nama_pajak     = str_replace("%20", " ", $nama_pajak);
		$adaEfaktur     = false;

		$data           = $this->ppnmasa_jurnal->get_data_csv($nama_pajak, $kode_cabang, $bulan_pajak, $tahun_pajak, $pembetulan_ke);

        if($nama_pajak == "PPN MASUKAN"){
        	$tileDMFM = "DK_DM";
        } else{
			$tileDMFM = "DK_DM";
        }

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
								'TANGGALINVOICE'
							);

    	array_push($dokumen_lain, $title_dokumen_lain);

							
        if (!empty($data)) {

        	foreach($data->result_array() as $row)	{
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
								$row['DESCSUBLEDGER'],
								$row['DESCRIPTIONHEADER'],
								$row['REFERENCELINE'],
								$row['PROFITCENTER'],
								$row['PROFITCENTERDESC'],
								$row['COSTCENTER'],
								$row['COSTCENTERDESC'],
								$row['PONUMBER'],
								$row['TANGGALPO'],
								$row['KODE_CABANG'],
								$row['NOMORINVOICE'],
								$row['TANGGALINVOICE']
							)
					);
			}
        }

		if($nama_pajak == "PPN MASUKAN"){
			convert_to_csv($dokumen_lain, 'Ekspor_DetailJurnalTransaksi_Masukan_'.$tahun_pajak.'_'.$masa_pajak.'.csv', ';');
		} else {
			convert_to_csv($dokumen_lain, 'Ekspor_DetailJurnalTransaksi_Keluaran_'.$tahun_pajak.'_'.$masa_pajak.'.csv', ';');
		}
	}

	function submit_jurnal_transaksi()
	{

		//$kode_cabang   = $this->kode_cabang;
		$username      = $this->session->userdata('identity');
		
		$nama_pajak    = $this->input->post('_searchPpn');
		$bulan_pajak   = $this->input->post('_searchBulan');
		$tahun_pajak   = $this->input->post('_searchTahun');
		$pembetulan_ke = $this->input->post('_searchPembetulan');
		$cabang = $this->input->post('_searchCabang');

		if($this->ppnmasa_jurnal->submit_jurnal_transaksi($nama_pajak, $bulan_pajak, $tahun_pajak, $pembetulan_ke, $cabang)){			
			echo '1';
		} else {
			echo '0';
		}

	}

}