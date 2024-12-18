<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pph extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}
		// $this->load->model('Pph_mdl');
		$this->load->model('pph_mdl', 'pph');
		$this->load->model('Cabang_mdl');
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(e_all);*/
	}	
	
	function input_url_doc(){

    	$this->template->set('title', 'Archive Link');
		$data['subtitle']   = "Archive Link";
		$data['activepage'] = "pph";
		
		$data['stand_alone'] = true;
		$group_pajak         = get_daftar_pajak("PPH");
		
		$list_pajak          = array();
	
		foreach ($group_pajak as $key => $value) {
			$list_pajak[] = $value->JENIS_PAJAK;
		}

		$data['nama_pajak']  = $list_pajak;
		
		$this->template->load('template', 'administrator/archive_link',$data);

	}
	
	function show_wp()
	{
		$this->template->set('title', 'WP');
		$data['subtitle']	= "Data WP";
		$this->template->load('template', 'pph/wp/index',$data);
	}
	
	function load_wp()
	{
      	$hasil	= $this->pph->get_wp();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'vendor_id'			=> $row['VENDOR_ID'],
								'nama_wp'			=> $row['NAMA_WP'],
								'alamat_wp'			=> $row['ALAMAT_WP'],
								'npwp' 				=> $row['NPWP'],
								'new_nama_wp' 		=> $row['NEW_NAMA_WP'],
								'new_alamat_wp' 	=> $row['NEW_ALAMAT_WP'],
								'new_npwp' 		    => $row['NEW_NPWP']
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

    }
	
	function save_wp()
	{
		$data	= $this->pph->action_save();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function show_rekonsiliasi()
	{
		$this->template->set('title', 'Rekonsiliasi GL');
		$data['title']		= "PPH";
		$data['subtitle']	= "Rekonsiliasi GL";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/rekonsiliasi',$data);
	}
	
	function show_approv()
	{
		$this->template->set('title', 'Approv');
		$data['title']		= "PPH";
		$data['subtitle']	= "Approv PPh";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/approv',$data);
	}
	
	function load_approv()
	{
      	$hasil	=$this->pph->get_approv();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$checked		= ($row['IS_CHEKLIST']==1)?"checked":"";
					$checkbox		= "<div class='checkbox checkbox-danger' style='height:10px'>
										<input id='checkbox".$row['RNUM']."' class='checklist' type='checkbox' ".$checked." disabled >
										<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
									  </div>";
					$result['data'][] = array(
								'checkbox'			        => $checkbox,
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'organization_id'			=> $row['ORGANIZATION_ID'],
								'vendor_site_id'			=> $row['VENDOR_SITE_ID'],
								'invoice_accounting_date'	=> $row['INVOICE_ACCOUNTING_DATE'],
								'invoice_currency_code'		=> $row['INVOICE_CURRENCY_CODE']
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
    }
	
	function save_approv()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_save_approv();
			$hsl	= 0;
			if($data){			
				$hsl= 1;
			} else {
				$hsl= 0;
			}
		} else {
			$hsl	= 0;
		}
		echo $hsl;		
	}
	
	function get_start()
	{
		$data	= $this->pph->action_get_start();			
		if($data){
			if($data->num_rows()>0){
				$row	                 = $data->row();       	
				$result['status']        = strtoupper($row->STATUS); 
				$result['status_period'] = strtoupper($row->STATUS_PERIOD);
				//$result['keterangan'] 	 = $row->KETERANGAN;
			} else {
				$result['status']        = "-------------"; 
				$result['status_period'] = " ----------";
				//$result['keterangan'] 	 = "";
			}
			$result['isSuccess'] 	 = 1;
		} else {
			$result['isSuccess'] 	 = 0;
		}
		echo json_encode($result);
		$data->free_result();  
	}
	
	function show_download()
	{
		$this->template->set('title', 'Download Pph');
		$data['subtitle']	= "Download Pph";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/download',$data);	
	}
	
	function load_download()
	{
      	$hasil	=$this->pph->get_download();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;	
					$checked		= ($row['IS_CHEKLIST']==1)?"checked":"";
					$checkbox		= "<div class='checkbox checkbox-danger' style='height:10px'>
										<input id='checkbox".$row['RNUM']."' class='checklist' type='checkbox' ".$checked." disabled >
										<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
									  </div>";
					$result['data'][] = array(
								'checkbox'			        => $checkbox,
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'organization_id'			=> $row['ORGANIZATION_ID'],
								'vendor_site_id'			=> $row['VENDOR_SITE_ID'],
								'invoice_accounting_date'	=> $row['INVOICE_ACCOUNTING_DATE'],
								'invoice_currency_code'		=> $row['INVOICE_CURRENCY_CODE']
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
    }
			
	function show_bukti_potong()
	{
		$this->template->set('title', 'Koreksi');
		$data['subtitle']	= "Koreksi Bukti Potong";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/bukti_potong',$data);
	}
	
	function load_bukti_potong()
	{
      	$hasil	=$this->pph->get_bukti_potong();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'pembetulan'				=> $row['PEMBETULAN']
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

    }
	
	function save_bukti_potong()
	{
		$data	= $this->pph->action_save_bukti_potong();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function delete_bukti_potong()
	{
		$data	= $this->pph->action_delete_bukti_potong();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	
	function show_closing()
	{
		$this->template->set('title', 'Closing PPh');
		$data['subtitle']	= "Closing PPh";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/closing',$data);
	}
	
	function load_closing()
	{
      	$hasil		= $this->pph->get_closing();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					if ($row['STATUS']=="Open") {
						$st ="<span class='label label-success'>".$row['STATUS']."</span>";
					} else {
						$st ="<span class='label label-danger'>".$row['STATUS']."</span>";
					}
					$result['data'][] = array(
								'no'			=> $row['RNUM'],
								'nama_pajak'	=> $row['NAMA_PAJAK'],
								'masa_pajak'	=> $row['MASA_PAJAK'],
								'bulan_pajak'	=> $row['BULAN_PAJAK'],
								'tahun_pajak'	=> $row['TAHUN_PAJAK'],
								'pembetulan_ke'	=> $row['PEMBETULAN_KE'],
								'params'		=> $row['STATUS'],
								'kd_cabang'		=> $row['KODE_CABANG'],
								'nm_cabang'		=> $row['NAMA_CABANG'],
								'status' 		=> $st
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

    }
	
	function save_closing()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	

		if($permission === true)
		{
			$data	= $this->pph->action_save_closing();
			if($data){
				echo '1';
			} else {
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	
	function cek_closing()
	{
		$data	= $this->pph->action_cek_closing();		
		if($data>0){
			echo '1'; //open
		} else {
			echo '0';
		}
	}
	
	
	function load_rekonsiliasi()
	{
      	$hasil	=$this->pph->get_rekonsiliasi();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$checked		= ($row['IS_CHEKLIST']==1)?"checked":"";
					$checkbox		= "<div class='checkbox checkbox-danger' style='height:10px'>
										<input id='checkbox".$row['RNUM']."' class='checklist' type='checkbox' ".$checked." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['PAJAK_LINE_ID']."'>
										<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
									  </div>";
					
					$result['data'][] = array(
								'checkbox'			        => $checkbox,
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'organization_id'			=> $row['ORGANIZATION_ID'],
								'vendor_site_id'			=> $row['VENDOR_SITE_ID'],
								'invoice_accounting_date'	=> $row['INVOICE_ACCOUNTING_DATE'],
								'invoice_currency_code'		=> $row['INVOICE_CURRENCY_CODE'],
								'is_cheklist'				=> $row['IS_CHEKLIST']
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
    }	
	
		
	function load_summary_rekonsiliasiAll1()
	{
      	$bulan 		= $_POST['_searchBulan'];
      	$tahun 		= $_POST['_searchTahun'];
      	$pajak 		= $_POST['_searchPph'];
      	$pembetulan = $_POST['_searchPembetulan'];
		$step		= $_POST['_step'];	
		
		$hasil_currency	=$this->pph->get_currency1($bulan, $tahun, $pajak, $pembetulan, $step);
		$rowCount	= $hasil_currency['jmlRow'] ;
		$queryC 	= $hasil_currency['query'];	
		$ii = 0;
		
		if ($rowCount>0) {
		foreach($queryC->result_array() as $rowC)	
			{
					$dibayarkan			= 0;
					$tidakDibayarkan	= 0;
					$ii++;
					$hasil	=$this->pph->get_summary_rekonsiliasiAll1($bulan, $tahun, $pajak, $pembetulan,$step);
					$query1 		= $hasil['queryExec'];	
					
					foreach($query1->result_array() as $row)	
					{
						if ($row['PENGELOMPOKAN']=="Dilaporkan"){
							$dibayarkan = $row['JML_POTONG'];
						} else {
							$tidakDibayarkan = $row['JML_POTONG'];
						}						
					}
						$saldoAkhir	= $rowC['SALDO_AWAL'] + ( $rowC['MUTASI_DEBIT'] -  $rowC['MUTASI_KREDIT'] );					
						if ($saldoAkhir <0 || $dibayarkan<0){
							$selisih	= $saldoAkhir+$dibayarkan ;
						} else {
							$selisih	= $saldoAkhir-$dibayarkan ;
						}						
						 if ($step=="REKONSILIASI") {
							$result['data'][] = array(
										'no'				    => $ii,								
										'saldo_awal'	        => '<input type="text" class="form-control input-sm text-right" id="saldoAwal" name="saldoAwal" placeholder="Saldo Awal" value="'.number_format($rowC['SALDO_AWAL'],2,'.',',').'">',
										
										'mutasi_debet'	        => '<input type="text" class="form-control input-sm text-right" id="mutasiDebet" name="mutasiDebet" placeholder="Mutasi Debet" value="'.number_format($rowC['MUTASI_DEBIT'],2,'.',',').'">',
										
										'mutasi_kredit'	        =>  '<input type="text" class="form-control input-sm text-right" id="mutasiKredit" name="mutasiKredit" placeholder="Mutasi Kredit" value="'.number_format($rowC['MUTASI_KREDIT'],2,'.',',').'">',
										
										'saldo_akhir'	        => '<input type="text" class="form-control input-sm text-right" id="saldoAkhir" name="saldoAkhir" placeholder="Saldo Akhir" disabled value="'.number_format($saldoAkhir,2,'.',',').'">',
										
										'jumlah_dibayarkan'	    => '<input type="text" class="form-control input-sm text-right" id="jmlDibayarkan" name="jmlDibayarkan" placeholder="Jumlah DIbayarkan" disabled value="'.number_format($dibayarkan,2,'.',',').'">',									
										
										'tidak_dilaporkan'	    => '<input type="text" class="form-control input-sm text-right" id="tidakDilaporkan" name="tidakDilaporkan" placeholder="Tidak DIlaporkan" disabled value="'.number_format($tidakDibayarkan,2,'.',',').'">',
										
										'selisih'	            => '<input type="text" class="form-control input-sm text-right" id="selisih" name="selisih" placeholder="Selisih" disabled value="'.number_format($selisih,2,'.',',').'">',
									);
						 } else {
							 $result['data'][] = array(
										'no'				    => $ii,								
										'saldo_awal'	        => number_format($rowC['SALDO_AWAL'],2,'.',','),
										
										'mutasi_debet'	        => number_format($rowC['MUTASI_DEBIT'],2,'.',','),
										
										'mutasi_kredit'	        => number_format($rowC['MUTASI_KREDIT'],2,'.',','),
										
										'saldo_akhir'	        => number_format($saldoAkhir,2,'.',','),
										
										'jumlah_dibayarkan'	    => number_format($dibayarkan,2,'.',','),									
										
										'tidak_dilaporkan'	    => number_format($tidakDibayarkan,2,'.',','),
										
										'selisih'	            => number_format($selisih,2,'.',','),
									);
						 }
								
					}
								
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
    }
	
	/*Awal Detail Rekonsiliasi================================================================================*/
	function load_detail_summary()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;

		if($permission === true)
		{
			
			$hasil    = $this->pph->get_detail_summary();
			$rowCount = $hasil['jmlRow'] ;
			$query    = $hasil['query'];
			$totselisih	= 0;
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	{
						$ii++;	
						$totselisih = $totselisih + $row['JUMLAH_POTONG'];
						//Awal Buat Nampilin tombol hapus selisih/tidak dilaporkan=======================
						/* if (strtoupper($row['SOURCE_DATA'])=="SELISIH"){
							$ket	= '<div class="col-lg-11">'.$row['KETERANGAN'].'</div> 
							<div class="col-lg-1"><button type="button" class="btn btn-danger waves-effect btn-xs tooltip-danger delrange" id="btnDeleteRange'.$row['RNUM'].'" data-id="'.$row['PAJAK_LINE_ID'].'" data-cab="'.$row['KODE_CABANG'].'"   data-name="'.$row['VENDOR_NAME'].'" title="Hapus" ><i id="iDeleteRange" class="fa fa-times-circle"></i></button></div>';
						} else {
							$ket	= '<div class="col-lg-11">'.$row['KETERANGAN'].'</div>';
						} */
						//Akhir Buat Nampilin tombol hapus selisih/tidak dilaporkan=======================
						$result['data'][] = array(									
									'no'				        => $row['RNUM'],
									'vendor_name'	        	=> $row['VENDOR_NAME'],
									'npwp1'			    		=> $row['NPWP1'],
									'address_line1'				=> $row['ADDRESS_LINE1'],									
									'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],									
									'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],									
									'dpp'						=> number_format($row['DPP'],2,'.',','),									
									'jumlah_potong' 			=> number_format($row['JUMLAH_POTONG'],2,'.',','),
									'keterangan' 				=> $row['KETERANGAN'],
									'totselisih' 				=> number_format($totselisih,2,'.',',')
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
		}
		
		echo json_encode($result);
		$query->free_result();
    }
	 
	function load_total_detail_summary()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		$ii			  = 0;
		$result['jml_tidak_dilaporkan']	= 0; $result['jml_tgl_akhir'] = 0; $result['jml_import_csv'] = 0;		
		$result['total'] = 0; 
		if($permission === true)
		{
			$hasil    = $this->pph->get_total_detail_summary();			
			foreach($hasil->result_array() as $row)	{
						$ii++;	
						$result['total'] = $result['total'] + $row['JUMLAH_POTONG'];
						
						if ($row['KETERANGAN']=='Tidak Dilaporkan'){
							$result['jml_tidak_dilaporkan'] = $row['JUMLAH_POTONG'];
						}
						if ($row['KETERANGAN']=='Tanggal 26 - 31 Bulan ini'){
							$result['jml_tgl_akhir'] = $row['JUMLAH_POTONG'];
						}
						if ($row['KETERANGAN']=='Import CSV'){
							$result['jml_import_csv'] = $row['JUMLAH_POTONG'];
						}						
				}
		}
		echo json_encode($result);
		$hasil->free_result();
    }
	
	function delete_detail_range()
	{
		$data	= $this->pph->action_delete_detail_range();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	 /*Akhir Detail Rekonsiliasi================================================================================*/
	
	function save_saldo_awal()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_save_saldo_awal();
			if($data){			
				echo '1';
			} else {			
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	
	
	
	
	function add_pph()
	{
		$this->template->set('title', 'Tambah PPh 23/26');
		$data['subtitle']	= "Tambah PPh 23/26";
		$this->template->load('template', 'pph/rekonsiliasi/form',$data);
	}
	
	function load_master_wp()
	{
      	$hasil	= $this->pph->get_master_wp();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'vendor_id'			=> $row['VENDOR_ID'],
								'organization_id'	=> $row['ORGANIZATION_ID'],
								'vendor_site_id'	=> $row['VENDOR_SITE_ID'],
								'nama_wp'			=> $row['VENDOR_NAME'],
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

    }
	
	function load_master_kode_pajak()
	{
      	$hasil	= $this->pph->get_master_kode_pajak();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				=> $row['RNUM'],								
								'tax_code'			=> $row['TAX_CODE'],
								'jenis_23'			=> $row['JENIS_23'],
								'tax_rate'			=> $row['TAX_RATE'],
								'description'		=> $row['DESCRIPTION']
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

    }
		
	
	function save_rekonsiliasi()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_save_rekonsiliasi();
			if($data){			
				echo $data;
			} else {			
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	
	function delete_rekonsiliasi()
	{
		$data	= $this->pph->action_delete_rekonsiliasi();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function check_rekonsiliasi()
	{
		$data	= $this->pph->action_check_rekonsiliasi();
		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function submit_rekonsiliasi()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_submit_rekonsiliasi();
			if($data){			
				echo '1';
			} else {			
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	
	function cek_row_rekonsiliasi()
	{
		$data	= $this->pph->action_cek_row_rekonsiliasi();
		$result['st'] = 0;
		if($data){
			$ii=0;
			$records	= "";
			foreach($data->result_array() as $row)	{
					$ii++;
					
					// if ($row['JUMLAH_POTONG'] && $row['TARIF']){
						// $njmldpp	= $row['JUMLAH_POTONG'] / ($row['TARIF']/100);
						// if ($row['NAMA_PAJAK']=="PPH PSL 22"){							
							// $njmldpp  = round($njmldpp);
						// }
					// } else {
						// $njmldpp	= 0;
					// }				
					
					if ($row['IS_CHEKLIST']==1){
						if(!$row['KODE_PAJAK'] || $row['KODE_PAJAK']=="" || !$row['VENDOR_NAME'] || $row['VENDOR_NAME']=="" || !$row['ADDRESS_LINE1'] || $row['ADDRESS_LINE1']=="" || !$row['GL_ACCOUNT'] || $row['GL_ACCOUNT']=="" || !$row['NPWP1'] || $row['NPWP1']=="" || !$row['DPP'] || $row['DPP']=="" ){
							$records .= $ii.", " ;
							//$records .= $ii."-".$row['JUMLAH_POTONG']."-".$row['KODE_PAJAK']."-".$njmldpp.", " ;
							$result['st'] = 1;
						}
					}
					$result['data'] ="Nomor ".$records." Kolom Nama WP / NPWP / Alamat / Kode Pajak / Akun Beban / DPP Masih Kosong!";					
			}
		} 
		echo json_encode($result);
		$data->free_result();  
	}
	
	function save_range_rekon()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_save_range_rekon();
			if($data){			
				echo $data;
			} else {			
				echo '0';
			}
		} else {
			echo '0';
		}
	}
		
	function export_format_csv() {
        $this->load->helper('csv_helper');
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$pajak   	= ($_REQUEST['tax'])? $_REQUEST['tax']:"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year']; 
		$pembetulan = $_REQUEST['ke'];
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();
        $data       = $this->pph->get_format_csv();
		$title 		= array("PAJAK_LINE_ID", "NAMA_WP", "NPWP","ALAMAT_WP","NAMA_PAJAK", "INVOICE_NUMBER","NO_FAKTUR_PAJAK","TANGGAL_FAKTUR_PAJAK","NO_BUKTI_POTONG","TGL_BUKTI_POTONG","AKUN_BEBAN","KODE_PAJAK","DPP","TARIF","JUMLAH_POTONG","TANGGAL GL","MATAUANG");
        array_push($export_arr, $title);
		
		if (!empty($data)) {         
			foreach($data->result_array() as $row)	{							
				array_push($export_arr, array($row['PAJAK_LINE_ID'], $row['VENDOR_NAME'], $row['NPWP1'], $row['ADDRESS_LINE1'], $row['NAMA_PAJAK'], $row['INVOICE_NUM'], $row['NO_FAKTUR_PAJAK'], $row['TANGGAL_FAKTUR_PAJAK'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], $row['GL_ACCOUNT'], $row['KODE_PAJAK'], $row['DPP'], $row['TARIF'], $row['JUMLAH_POTONG'], $row['INVOICE_ACCOUNTING_DATE'], $row['INVOICE_CURRENCY_CODE']));
			}
        }
      convert_to_csv($export_arr,'FORMAT BUKU BANTU '.strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function cek_data_csv()
	{
		$data	= $this->pph->get_format_csv();
		if($data){			
			echo '1';
		} else {			
			echo '0';
		}
	}
	
	function load_master_pajak()
	{
      	$hasil	= $this->pph->get_master_pajak();
		$query 		= $hasil['query'];			
			$result ="";
			foreach($query->result_array() as $row)	{
				$result .= "<option value='".$row['JENIS_PAJAK']."' data-name='".$row['DISPLAY']."' >".$row['DISPLAY']."</option>";
			}		
		echo $result;
		$query->free_result();

    }	
	
	function get_selectAll()
	{
		$data	= $this->pph->action_get_selectAll();
		if($data){			
			echo '1';
		} else {			
			echo '0';
		}
	}
	
	private function _upload($field_name, $folder_name, $file_name, $allowed_types, $ext){
        //file upload destination
        $upload_path = './uploads/';
        $config['upload_path'] = $upload_path.$folder_name;
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
			
			if (file_exists(FCPATH.$upload_path.$folder_name."/".$file_name.".".$ext)){
				unlink($upload_path.$folder_name."/".$file_name.".".$ext);
				
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

				if($image_data){
					return true;
				}

			}
        }

        return false;
	}
	
	function import_CSV()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
		{
		    @set_time_limit(300);
		}
		
		if (!empty($_FILES['file_csv']['name'])){
			$path 	= $_FILES['file_csv']['name'];
			$ext  	= pathinfo($path, PATHINFO_EXTENSION);
			$pajak 	= str_replace(" ","_",$this->input->post('uplPph'));			
			$file_name = "fileCSV_".$pajak;	
			
			if ($ext=='csv'){
				if($upl = $this->_upload('file_csv', 'importCsv/pph/', $file_name, 'csv', $ext)){					
					$row = 1;
					$handle = fopen("./uploads/importCsv/pph/".$file_name.".".$ext, "r");								
					$dataCsv  = array();
					while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {							
						if($row > 1){							
								$dataCsv = array(
									'id_lines'   => $data[0], 
									'nama'       => $data[1],
									'npwp'       => $data[2],
									'alamat'     => $data[3],
									'no_faktur'  => $data[6],
									'tgl_faktur' => ($data[7] != "") ? date("Y-m-d", strtotime(str_replace("/","-",$data[7]))) : "",
									'kode_pajak' => $data[11],
									'dpp'        => simtax_trim($data[12]),
									'tarif'      => simtax_trim_tarif($data[13]),
									'jml_potong' => simtax_trim($data[14]),
									'matauang'   => $data[16],
									'akun_pajak' => $data[10]
								);
							
							$hasil	= $this->pph->add_csv($dataCsv);
							if ($hasil){
								$st =1;
							} else {
								echo 0;
								die();
							}								
						}
						$row++;
					}					
				}
			} else {
				$st = 3;
			}
		} else {
			$st	= 2 ;
		}		
		echo $st; 
	}
	
	function show_view()
	{
		$this->template->set('title', 'View PPH');
		$data['subtitle']	= "View Status";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/view',$data);
	}
	
	function load_view()
	{
      	$hasil	=$this->pph->get_view();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;					
					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'pajak_header_id'	=> $row['PAJAK_HEADER_ID'],
								'kode_cabang'		=> $row['KODE_CABANG'],
								'nama_pajak'		=> $row['NAMA_PAJAK'],
								'bulan_pajak'		=> $row['BULAN_PAJAK'],
								'masa_pajak'		=> $row['MASA_PAJAK'],
								'tahun_pajak'		=> $row['TAHUN_PAJAK'],
								'creation_date' 	=> $row['CREATION_DATE'],
								'user_name' 		=> $row['USER_NAME'],
								'status' 		    => $row['STATUS'],
								'tgl_submit_sup' 	=> $row['TGL_SUBMIT_SUP'],
								'tgl_approve_sup' 	=> $row['TGL_APPROVE_SUP'],
								'tgl_approve_pusat' => $row['TGL_APPROVE_PUSAT'],
								'pembetulan_ke' 	=> $row['PEMBETULAN_KE'],
								'ttl_jml_potong' 	=> number_format($row['TTL_JML_POTONG'],2,'.',',')
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

    }
	
	function load_rekonsiliasi_detail()
	{
      	$hasil	=$this->pph->get_rekonsiliasi_detail();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$checked	= ($row['IS_CHEKLIST']==1)?"checked":"";
					$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
									<input id='checkbox".$row['RNUM']."' class='checklist' type='checkbox' ".$checked." disabled data-id='".$row['PAJAK_LINE_ID']."'>
									<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
								</div>";
					$result['data'][] = array(
								'checkbox'			        => $checkbox,
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'organization_id'			=> $row['ORGANIZATION_ID']
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
    }
		
	
	function load_history()
	{
      	$hasil	=$this->pph->get_history();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;					
					$result['data'][] = array(
						'no'			=> $row['RNUM'],
						'action_code'	=> strtoupper($row['ACTION_CODE']),
						'action_date'	=> $row['ACTION_DATE'],
						'user_name'		=> $row['USER_NAME'],
						'catatan'		=> $row['CATATAN']
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
    }
	
	function show_compilasi()
	{
		$this->template->set('title', 'Kompilasi');
		$data['subtitle']	= "Kompilasi PPh";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/compilasi',$data);
	}
	
	function load_kompilasi()
	{
      	$hasil	=$this->pph->get_kompilasi();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];	
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$checked	= ($row['IS_CHEKLIST']==1)?"checked":"";
					$checkbox	= "<div class='checkbox checkbox-danger' style='height:10px'>
									<input id='checkbox".$row['RNUM']."' disabled class='checklist' type='checkbox' ".$checked." data-toggle='confirmation-singleton' data-singleton='true' data-id='".$row['PAJAK_LINE_ID']."'>
									<label for='checkbox".$row['RNUM']."'>&nbsp;</label>
								</div>";
					$result['data'][] = array(
								'checkbox'			        => $checkbox,
								'no'				        => $row['RNUM'],
								'pajak_header_id'	        => $row['PAJAK_HEADER_ID'],
								'pajak_line_id'			    => $row['PAJAK_LINE_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'nama_wp'			        => $row['VENDOR_NAME'],
								'npwp' 				        => $row['NPWP1'],
								'alamat_wp' 		        => $row['ADDRESS_LINE1'],
								'kode_pajak' 	            => $row['KODE_PAJAK'],
								'dpp' 	                    => number_format($row['DPP'],2,'.',','),
								'tarif' 	                => $row['TARIF'],
								'jumlah_potong' 		    => number_format($row['JUMLAH_POTONG'],2,'.',','),
								'uraian'					=> $row['URAIAN'],
								'new_kode_pajak'			=> $row['NEW_KODE_PAJAK'],
								'new_dpp'					=> number_format($row['NEW_DPP'],2,'.',','),
								'new_tarif'					=> $row['NEW_TARIF'],
								'new_jumlah_potong'			=> number_format($row['NEW_JUMLAH_POTONG'],2,'.',','),
								'invoice_num'				=> $row['INVOICE_NUM'],
								'invoice_line_num'			=> $row['INVOICE_LINE_NUM'],
								'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],
								'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],
								'vendor_id'					=> $row['VENDOR_ID'],
								'no_bukti_potong'			=> $row['NO_BUKTI_POTONG'],
								'gl_account'				=> $row['GL_ACCOUNT'],
								'akun_pajak'				=> $row['AKUN_PAJAK'],
								'nama_pajak'				=> $row['NAMA_PAJAK'],
								'bulan_pajak'				=> $row['BULAN_PAJAK'],
								'tahun_pajak'				=> $row['TAHUN_PAJAK'],
								'masa_pajak'				=> $row['MASA_PAJAK'],
								'organization_id'			=> $row['ORGANIZATION_ID'],
								'kode_cabang'				=> $row['KODE_CABANG'],
								'nama_cabang'				=> $row['NAMA_CABANG']
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
    }
	
	function load_summary_kompilasi()
	{
		$bulan 		= $_POST['_searchBulan'];
      	$tahun 		= $_POST['_searchTahun'];
      	$pajak 		= $_POST['_searchPph'];
      	$pembetulan = $_POST['_searchPembetulan'];
		$cabang		= $_POST['_searchCabang'];	
		
		$hasil_currency	=$this->pph->get_currency_kompilasi($bulan, $tahun, $pajak, $pembetulan, $cabang);
		$rowCount	= $hasil_currency['jmlRow'] ;
		$queryC 	= $hasil_currency['query'];	
		$ii = 0;
		
		if ($rowCount>0) {
		foreach($queryC->result_array() as $rowC)	
			{
					$kdcabang			= $rowC['KODE_CABANG'] ;
					$dibayarkan			= 0;
					$tidakDibayarkan	= 0;
					$ii++;
					$hasil	=$this->pph->get_summary_rekonsiliasi($bulan, $tahun, $pajak, $pembetulan,$kdcabang);
					$query1 		= $hasil['queryExec'];	
					
					foreach($query1->result_array() as $row)	
					{
						if ($row['PENGELOMPOKAN']=="Dilaporkan"){
							$dibayarkan = $row['JML_POTONG'];
						} else {
							$tidakDibayarkan = $row['JML_POTONG'];
						}						
					}
												
						$saldoAkhir	= $rowC['SALDO_AWAL'] + ( $rowC['MUTASI_DEBIT'] -  $rowC['MUTASI_KREDIT'] );					
						
						if ($saldoAkhir <0 || $dibayarkan<0){
							$selisih	= $saldoAkhir+$dibayarkan ;
						} else {
							$selisih	= $saldoAkhir-$dibayarkan ;
						}						
						
							 $result['data'][] = array(
										'no'				    => $ii,								
										'cabang'				=> $rowC['NAMA_CABANG'],								
										'saldo_awal'	        => number_format($rowC['SALDO_AWAL'],2,'.',','),
										
										'mutasi_debet'	        => number_format($rowC['MUTASI_DEBIT'],2,'.',','),
										
										'mutasi_kredit'	        => number_format($rowC['MUTASI_KREDIT'],2,'.',','),
										
										'saldo_akhir'	        => number_format($saldoAkhir,2,'.',','),
										
										'jumlah_dibayarkan'	    => number_format($dibayarkan,2,'.',','),									
										
										'tidak_dilaporkan'	    => number_format($tidakDibayarkan,2,'.',','),
										'selisih'			    => number_format($selisih,2,'.',',')
									);
						
								
					}
								
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
	}
	
	function load_total_bayar_summary_kompilasi()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		$ii			  = 0;		
		$result['total'] = 0; 
		if($permission === true)
		{
			$hasil    = $this->pph->get_total_bayar_summary_kompilasi();			
			foreach($hasil->result_array() as $row)	{
						$ii++;	
						$result['total'] = $row['JML_POTONG'];							
				}
		}
		echo json_encode($result);
		$hasil->free_result();
    }
	
	function load_detail_summary_kompilasi()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_compilasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;

		if($permission === true)
		{
			
			$hasil    = $this->pph->get_detail_summary_kompilasi();
			$rowCount = $hasil['jmlRow'] ;
			$query    = $hasil['query'];
			$totselisih	= 0;
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	{
						$ii++;	
						$totselisih = $totselisih + $row['JUMLAH_POTONG'];
						$result['data'][] = array(									
									'no'				        => $row['RNUM'],
									'nama_cabang'			    => $row['NAMA_CABANG'],
									'vendor_name'	        	=> $row['VENDOR_NAME'],
									'npwp1'			    		=> $row['NPWP1'],
									'address_line1'				=> $row['ADDRESS_LINE1'],									
									'no_faktur_pajak'			=> $row['NO_FAKTUR_PAJAK'],									
									'tanggal_faktur_pajak'		=> $row['TANGGAL_FAKTUR_PAJAK'],									
									'dpp'						=> number_format($row['DPP'],2,'.',','),									
									'jumlah_potong' 			=> number_format($row['JUMLAH_POTONG'],2,'.',','),
									'keterangan' 				=> $row['KETERANGAN'],
									'totselisih' 				=> number_format($totselisih,2,'.',',')
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
		}

		echo json_encode($result);
		$query->free_result();
    }
	
	function load_detail_summary_kompilasi_cabang()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_compilasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;

		if($permission === true)
		{
			
			$hasil    = $this->pph->get_detail_summary_kompilasi_cabang();
			$rowCount = $hasil['jmlRow'] ;
			$query    = $hasil['query'];
			$totselisih	= 0;
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	{
						$ii++;	
						$totselisih = $totselisih + $row['JUMLAH_POTONG'];
						$result['data'][] = array(									
									'no'				        => $row['RNUM'],
									'nama_cabang'			    => $row['NAMA_CABANG'],														
									'jumlah_potong' 			=> number_format($row['JUMLAH_POTONG'],2,'.',',')
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
		}

		echo json_encode($result);
		$query->free_result();
    }
	 
	 
	function load_total_detail_summary_kompilasi()
	{

		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		$ii			  = 0;
		$result['jml_tidak_dilaporkan']	= 0; $result['jml_tgl_akhir'] = 0; $result['jml_import_csv'] = 0;		
		$result['total'] = 0; 
		if($permission === true)
		{
			$hasil    = $this->pph->get_total_detail_summary_kompilasi();			
			foreach($hasil->result_array() as $row)	{
						$ii++;	
						$result['total'] = $result['total'] + $row['JUMLAH_POTONG'];
						
						if ($row['KETERANGAN']=='Tidak Dilaporkan'){
							$result['jml_tidak_dilaporkan'] = $row['JUMLAH_POTONG'];
						}
						if ($row['KETERANGAN']=='Tanggal 26 - 31 Bulan ini'){
							$result['jml_tgl_akhir'] = $row['JUMLAH_POTONG'];
						}
						if ($row['KETERANGAN']=='Import CSV'){
							$result['jml_import_csv'] = $row['JUMLAH_POTONG'];
						}						
				}
		}
		echo json_encode($result);
		$hasil->free_result();
    }
	 	
	 
	function export_format_csv_compilasi() {
        $this->load->helper('csv_helper');
		$pajak   	= ($_REQUEST['tax'])? $_REQUEST['tax']:"";
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();
		$title = array("BULAN PAJAK", "TAHUN PAJAK","JENIS PAJAK","NAMA_WP", "NPWP","ALAMAT_WP","KODE_PAJAK","DPP","TARIF","JUMLAH POTONG","INVOICE NUMBER","NO BUKTI POTONG","NO FAKTUR PAJAK","TANGGAL FAKTUR PAJAK","AKUN BEBAN","PEMBETULAN","KETERANGAN");		
			array_push($export_arr, $title);
		$xample = array($_REQUEST['month'], $_REQUEST['year'],$_REQUEST['tax'],"PT Abadi", "10000123000456","Tanjung Priok2","KP0 PSL23-07","10000","2","200","123456","789012","45678","25-12-2016","30901301",$_REQUEST['ke'],"Data Contoh");
			array_push($export_arr, $xample);		
       convert_to_csv($export_arr, 'Format Tambah Data '.$_REQUEST['tax'].'.csv', ';');
    }
	
	function import_compilasi_CSV()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
		{
		    @set_time_limit(300);
		}
		
		if (!empty($_FILES['file_csv']['name'])){
			$path 	    = $_FILES['file_csv']['name'];
			$ext  	    = pathinfo($path, PATHINFO_EXTENSION);
			$pajak 	    = str_replace(" ","_",$this->input->post('uplPph'));			
			$file_name  = "fileKompilasiCSV_".$pajak;
			$jnspajak	= rawurldecode($this->uri->segment(3));
			$bulan	    = rawurldecode($this->uri->segment(4));
			$tahun	    = rawurldecode($this->uri->segment(5));
			$pembetulan	= rawurldecode($this->uri->segment(6));
			$header_id  = $this->pph->get_header_id($jnspajak, $bulan, $tahun, $pembetulan);
			
			 if ($ext=='csv'){
				if($upl = $this->_upload('file_csv', 'importCsv/pph/', $file_name, 'csv', $ext)){			
					$row = 1;
					$handle = fopen("./uploads/importCsv/pph/".$file_name.".".$ext, "r");	
					$dataCsv  = array();
					while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {						
						if($row > 1){	
								$dataCsv = array(
									'bulan'             => $data[0],
									'tahun'	            => $data[1],
									'pajak'    	        => $data[2],
									'nama'              => $data[3],
									'npwp'              => $data[4],
									'alamat'            => $data[5],
									'kode_pajak'        => $data[6],					
									'dpp'          		=> $data[7],
									'tarif'             => $data[8],
									'jumlah_potong'     => $data[9],
									'invoice_number'    => $data[10],
									'no_bukti_potong'   => $data[11],
									'no_faktur'         => $data[12],
									'tgl_faktur'        => $data[13],
									'akun_beban'        => $data[14],
									'pembetulan'        => $data[15],
									'keterangan'        => $data[16],
									'header_id'     	=> $header_id
								);
							
							if($data[15] != "PEMBETULAN"){
								if ($pembetulan != $data[15]){
									echo 4; exit();
								}
							}
							
							$hasil	= $this->pph->add_kompilasi_csv($dataCsv);							
							if ($hasil){
								$st =1;								
							} else {
								$st	= 0;
							} 		
						}
						$row++;
					}
						
				}
			} else {
				$st = 3;
			} 
		} else {
			$st	= 2 ;
		}			
		echo $st; 
	}
	
	function show_pembetulan()
	{
		$this->template->set('title', 'Pembetulan');
		$data['subtitle']	= "Pembetulan";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/pembetulan',$data);		
	}
	
	function load_pembetulan()
	{
      	$hasil	= $this->pph->get_pembetulan();
		$rowCount	= $hasil['jmlRow'] ;
		$query 		= $hasil['query'];		
		if ($rowCount>0){
			$ii	=	0;
			foreach($query->result_array() as $row)	{
					$ii++;
					$result['data'][] = array(
								'no'				=> $row['RNUM'],
								'pajak_header_id'	=> $row['PAJAK_HEADER_ID'],
								'status_period'		=> $row['STATUS_PERIOD'],
								'bulan_pajak'		=> $row['BULAN_PAJAK'],
								'nama_pajak' 		=> $row['NAMA_PAJAK'],
								'masa_pajak' 		=> $row['MASA_PAJAK'],
								'tahun_pajak' 		=> $row['TAHUN_PAJAK'],
								'pembetulan_ke' 	=> $row['PEMBETULAN_KE'],
								'kode_cabang' 		=> $row['KODE_CABANG'],
								'nama_cabang' 		=> $row['NAMA_CABANG']
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

    }
	
	function save_pembetulan()
	{	
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_save_pembetulan();
			if($data && ($data=="Close" || $data=="CLOSE") ){
				echo '1';
			} else if($data && ($data=="Open" || $data=="OPEN")) {
				echo '2';
			} else if ($data && $data=="3") {
				echo '3';
			} else {
				echo "0";
			}
		} else {
			echo "0";
		}
	}
	
	function delete_pembetulan()
	{
		if($this->ion_auth->is_admin()){
			$permission = true;
		}
		else if(in_array("pph/show_rekonsiliasi", $this->session->userdata['menu_url'])){
			$permission = true;
		}
		else{
			$permission = false;
		}	
		
		if($permission === true)
		{
			$data	= $this->pph->action_delete_pembetulan();
			if($data){
				echo '1';
			} else {
				echo '0';
			}
		} else {
			echo '0';
		}
	}
	
	function show_rekap_pph()
	{
		$this->template->set('title', 'Rekap Setahun');
		$data['subtitle']	= "Rekap Setahun";
		$data['activepage'] = "pph";
		$this->template->load('template', 'pph/rekap',$data);		
	}

	function cetak_report_pph_thn_xls()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
		{
		    @set_time_limit(300);
		}

		$tahun 		= $_REQUEST['tahun'];
		$pajak 		= $_REQUEST['pajak'];		
		$subpajak 	= $_REQUEST['subpajak'];
		$cabang 	= $_REQUEST['kd_cabang'];
		$header     = $this->pph->get_header_id_rekap($pajak, $tahun, $cabang);

		/*echo $header;
		die();*/

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
		}else{
			$kd_cabang = '';
		}		
		
		$date	    = date("Y-m-d H:i:s");
		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel(); 
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
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
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);	// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row2 = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);


		$style_row_head = array(
				'font' => array('bold' => true),
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara horizontal (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_row_jud = array(
				'font' => array('bold' => true),
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
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
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$table = " simtax_rpt_spt_pph_tahunan_v ";
		$judul = $pajak;
		if ($subpajak=='PPH23'){
			$table = " simtax_rpt_spt_pph23_tahunan_v ";
			$judul = "PPH PSL 23";
		} else if ($subpajak=='PPH26') {
			$table = " simtax_rpt_spt_pph26_tahunan_v ";
			$judul = "PPH PSL 26";
		}
			
		//buat header cetakan
		//logo IPC
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "REKAP SPT KOMPILASI ".strtoupper($judul)." Tahun ".$tahun);
		
		
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "No.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Cabang/Unit");

		$excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('A5:A6'); // nomor
		$excel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('B5:B6'); // cabang

		$loop = horizontal_loop_excel("C", 60);

		$j      = 0;
		$x      = 1;
		$month  = 1;
		$string = "";
		$arrString = array("SPT", "Tanggal Setor", "NTPN", "Tanggal Lapor", "Nominal");
		foreach ($loop as $key => $value) {

			$nama_bulan = get_masa_pajak($month, "id", true);
			$excel->setActiveSheetIndex(0)->setCellValue($value.'6', $arrString[$j]);
			$excel->getActiveSheet()->getStyle($value.'5:'.$value.'6')->applyFromArray($style_row_head);

			if($x % 5){
				$excel->setActiveSheetIndex(0)->setCellValue($value.'5', $nama_bulan);
				$j++;
			}
			else{
				$excel->setActiveSheetIndex(0)->setCellValue($value.'5', $nama_bulan);
				$j=0;
				$month++;
			}
			$x++;
		}

		$x = 1;
		foreach ($loop as $key => $value) {

			$loop2 = horizontal_loop_excel($value, 5);
			$next = end($loop2);

			if($x == 1){
				$excel->getActiveSheet()->mergeCells($value.'5:'.$next.'5');
			}

			if($x % 5){
			}
			else{
				$loop2 = horizontal_loop_excel($value++, 6);
				$next = end($loop2);
				$excel->getActiveSheet()->mergeCells($value.'5:'.$next.'5');
			}

			$x++;
		}
			
			if ($kd_cabang == ""){
				$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
			}
			else{
				$whereCabang = "'".$kd_cabang."'";
			}

			$queryExec	= "SELECT skc.KODE_CABANG,
					         skc.NAMA_CABANG
					    FROM simtax_kode_cabang skc
					   WHERE skc.kode_cabang IN (".$whereCabang.")
					   and skc.aktif = 'Y'
					ORDER BY skc.kode_cabang";
					
			$query 		= $this->db->query($queryExec);
			
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
			$i		 = 0;

			$dataSPT = array(
								"BULAN" => array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"),
								"SPT"   => array(1231,52423,213,4584,222215,1312,112312,0,0,0,0,0),
								"NTPN"  => array("AFASD","SDGSDT","GDJFHDF","SDBVDC","CAASC","TJGF","DUYTD","VSDCSD","","","",""),
							);

			$querySPT = "SELECT rpt.KODE_CABANG, ntpn, rpt.bulan_pajak, sntpn.tanggal_lapor,
							sntpn.tanggal_setor, sntpn.nominal,
							(SELECT MAX (xrpt.pph)
					            FROM simtax_rpt_spt_pph_tahunan_v xrpt
					           WHERE     xrpt.kode_cabang = rpt.kode_cabang
					                 AND xrpt.bulan_pajak = rpt.bulan_pajak
					                 AND xrpt.tahun_pajak = rpt.tahun_pajak
					                 AND xrpt.nama_pajak = rpt.nama_pajak)
					            spt_pph
					    FROM    simtax_rpt_spt_pph_tahunan_v rpt
					         LEFT JOIN
					            simtax_ntpn sntpn
					         ON rpt.tahun_pajak = sntpn.tahun
					            AND rpt.nama_pajak = sntpn.jenis_pajak
					            AND rpt.bulan_pajak = sntpn.bulan
					            AND rpt.kode_cabang = sntpn.kode_cabang
					   WHERE rpt.tahun_pajak = '".$tahun."' AND UPPER(rpt.nama_pajak) = '".strtoupper($pajak)."'
					   --AND rpt.kode_cabang = 000
					   --AND rpt.bulan_pajak = 1
					   --AND rpt.bulan_pajak IN(1,2,3,8)
					ORDER BY rpt.KODE_CABANG, rpt.bulan_pajak";

			$resSPT = $this->db->query($querySPT)->result_array();
			$totSPT  = count($resSPT);

			$j=0;
			$dataBulan = array();
			$dataCabang = array();
			$dataNew = array();
			$last_kode_cabang = "";
			for ($i=0; $i < $totSPT ; $i++) {
				$nama_bulan = strtoupper(get_masa_pajak($resSPT[$i]['BULAN_PAJAK'], "id", true));
				$j=$resSPT[$i]['BULAN_PAJAK'];
				$kode_cabang = $resSPT[$i]['KODE_CABANG'];

				if($kode_cabang != $last_kode_cabang){
					$j++;
					$j=$resSPT[$i]['BULAN_PAJAK'];
				}

				$dataNew[$kode_cabang][$j][] = $resSPT[$i];
				$last_kode_cabang = $kode_cabang;

			}

			$i = 0;
			$spt_pph       = 0;
			$tanggal_lapor = "";
			$ntpn          = "";
			$tanggal_setor = "";
			$nominal       = 0;
			$nomor = 1;
			$diee = false;
			$row1 = $query->row_array();
			$lastCabang = $row1['KODE_CABANG'];

			$arrOfFirst = array("C","H","M","R","W","AB","AG","AL","AQ","AV","BA","BF");
			$lastPlus5 = end($arrOfFirst);
			for ($i=0; $i < 4; $i++) { 
				$lastPlus5++;
			}
			
			foreach($query->result_array() as $row)	{

				$cabang = $row['KODE_CABANG'];
				$merge = 0;

				if (array_key_exists($cabang, $dataNew)){

					if($cabang != $lastCabang){
						$uniquePush = array_unique($pushNum);
						$numrow = max($uniquePush);
						$numrow++;
					}
					else{
						unset($pushNum);
					}

					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);	
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['NAMA_CABANG']);
					$loop = horizontal_loop_excel("C", 60);
					$x=1;
					$month=1;
					$z=0;
					$numrowNow=0;
					$lastVal="";
					$newMonth = false;
					$numrowMain = $numrow;
					foreach ($loop as $key => $value) {

						if($x==5){
							$lastVal = $value;
						}

						$dataMonth = $dataNew[$cabang];
						unset($counts);
						if (array_key_exists($month, $dataMonth)){

							foreach ($dataMonth as $key => $count) {
								$counts[] = count($count);
							}
							$maxDataNtpn = max($counts);

							$totDataMonth = count($dataMonth[$month]);
							if($totDataMonth > 0){
								for ($i=0; $i < $totDataMonth ; $i++) {
									$spt_data[1][] = $dataMonth[$month][$i]['SPT_PPH'];
									$spt_data[2][] = $dataMonth[$month][$i]['TANGGAL_LAPOR'];
									$spt_data[3][] = $dataMonth[$month][$i]['NTPN'];
									$spt_data[4][] = $dataMonth[$month][$i]['TANGGAL_SETOR'];
									$spt_data[5][] = $dataMonth[$month][$i]['NOMINAL'];
								}
							}
							else{
								$spt_data[1] = $dataMonth[$month][0]['SPT_PPH'];
								$spt_data[2] = $dataMonth[$month][0]['TANGGAL_LAPOR'];
								$spt_data[3] = $dataMonth[$month][0]['NTPN'];
								$spt_data[4] = $dataMonth[$month][0]['TANGGAL_SETOR'];
								$spt_data[5] = $dataMonth[$month][0]['NOMINAL'];
							}
						}
						else{
							$spt_data[1] = "";
							$spt_data[2] = "";
							$spt_data[3] = "";
							$spt_data[4] = "";
							$spt_data[5] = "";
						}


						if($x % 5){
							$z++;
							if(is_array($spt_data[$z])){
								$numrowNow = $numrow;
								for ($i=0; $i < $totDataMonth; $i++) {
									// if($totDataMonth > 1){
										$merge = $numrowMain+$maxDataNtpn-1;
										if(in_array($value, $arrOfFirst) && $i == 0){
											// echo "<b>Merge ".$value.$numrowMain.":".$value.$merge."</b><br>";
											$excel->getActiveSheet()->getStyle("A".$numrowMain.':'."A".$merge)->applyFromArray($style_row_no);
											$excel->getActiveSheet()->getStyle($value.$numrowMain.':'.$lastPlus5.$merge)->applyFromArray($style_row_no);
											$excel->getActiveSheet()->mergeCells("A".$numrowMain.':'."A".$merge);
											$excel->getActiveSheet()->mergeCells("B".$numrowMain.':'."B".$merge);
											$excel->getActiveSheet()->mergeCells($value.$numrowMain.':'.$value.$merge);
										}
									// }
									if($i == 0){
										$excel->getActiveSheet()->getStyle($value.$numrowMain)->applyFromArray($style_row_no);
										$numrow = $numrowMain;
									}
									else{
										$numrow++;
										$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row_no);
										$pushNum[] = $numrow;
									}

									if(in_array($value, $arrOfFirst)){
										if($i>0){
											$spt_data[$z][$i] = "";
										}
									}
									$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[$z][$i]);
									// echo $value.$numrow." - ".$spt_data[$z][$i]."<br>";
									$j++;
								}
								$newMonth = false;
							}
							else{
								$pushNum[] = $numrow;
								$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[$z]);
							}
						}
						else{
							if(is_array($spt_data[$z])){
								$numrowNow = $numrow;
								$excel->getActiveSheet()->getStyle($value.$numrowMain.':'.$lastPlus5.$merge)->applyFromArray($style_row_no);
								for ($i=0; $i < $totDataMonth; $i++) {
									if($i == 0){
										$numrow = $numrowMain;
									}
									else{
										$numrow++;
									$pushNum[] = $numrow;
									}
									$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[5][$i]);
									// echo $value.$numrow." - ".$spt_data[5][$i]."<br>";
									$j++;
								}
							}
							else{
								$pushNum[] = $numrow;
								$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[5]);
							}
							$newMonth= true;
							$lastVal = $value;
							$z=0;
							$month++;
						}
						unset($spt_data);
						$x++;
					}

				}

				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_no);
				$loop = horizontal_loop_excel("B", 61);

				foreach ($loop as $key => $value) {
					$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row);
				}

				$lastCabang = $cabang;
				
				$nomor++; 				
				$numrow++;
			}

			$numrow = max($pushNum)+1;

			// echo $numrow; 
			// die;

			$last_no = $numrow-1;

			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH DISETOR");
			$excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);
			foreach ($arrOfFirst as $key => $value) {
				$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, "=SUM(".$value."7:".$value.$last_no.")");	
			}

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_no);

		$i=0;
		$strTotal = "";

		foreach ($arrOfFirst as $key => $value) {

			if($i > 0){
				$strTotal .= "+".$value.$numrow;
			}
			else{
				$strTotal .= $value.$numrow;
			}
			$i++;
		}

		$numrow  = $numrow += 1;

		$loop = horizontal_loop_excel("A", 62);
		foreach ($loop as $key => $value) {

			$excel->getActiveSheet()->getStyle($value."6:".$value.$numrow)->applyFromArray($style_row);

			if(in_array($value, $arrOfFirst)){
				$excel->getActiveSheet()->getStyle($value."7:".$value.$numrow)->applyFromArray($style_row2);
			}
		}

		$loop = horizontal_loop_excel("A", 2);
		$numrowmin1 = $numrow-1;
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);

		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.$numrowmin1)->applyFromArray($style_row_jud);
			$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row_jud);
		}

		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH SETAHUN");

		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "=(".$strTotal.")" );
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_bold);
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$loop = horizontal_loop_excel("B", 62);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getColumnDimension($value)->setWidth(20); // Set width kolom B
		}
		
		foreach ($arrOfFirst as $key => $value) {

			for ($i=7; $i <= $numrow; $i++) {
				$excel->getActiveSheet()->getStyle($value.$i)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			}
			$i++;
		}
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle(strtoupper($judul)." ".$tahun);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rekap SPT Tahunan '.strtoupper($judul).' Tahun '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function cetak_report_pph_thn_xls9()
	{
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
		{
		    @set_time_limit(300);
		}

		$tahun 		= $_REQUEST['tahun'];
		$pajak 		= $_REQUEST['pajak'];		
		$subpajak 	= $_REQUEST['subpajak'];
		$cabang 	= $_REQUEST['kd_cabang'];
		$header     = $this->pph->get_header_id_rekap($pajak, $tahun, $cabang);

		/*echo $header;
		die();*/

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
		}else{
			$kd_cabang = '';
		}		
		
		$date	    = date("Y-m-d H:i:s");
		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel(); 
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
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
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);


		$style_row_head = array(
				'font' => array('bold' => true),
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara horizontal (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_row_jud = array(
				'font' => array('bold' => true),
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
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
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$table = " simtax_rpt_spt_pph_tahunan_v ";
		$judul = $pajak;
		if ($subpajak=='PPH23'){
			$table = " simtax_rpt_spt_pph23_tahunan_v ";
			$judul = "PPH PSL 23";
		} else if ($subpajak=='PPH26') {
			$table = " simtax_rpt_spt_pph26_tahunan_v ";
			$judul = "PPH PSL 26";
		}
			
		//buat header cetakan
		//logo IPC
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PELABUHAN INDONESIA II (Persero)");
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "REKAP SPT KOMPILASI ".strtoupper($judul)." Tahun ".$tahun);
		
		
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "No.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Cabang/Unit");

		$excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('A5:A6'); // nomor
		$excel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($style_row_jud);
		$excel->getActiveSheet()->mergeCells('B5:B6'); // cabang

		$loop = horizontal_loop_excel("C", 60);

		$j      = 0;
		$x      = 1;
		$month  = 1;
		$string = "";
		$arrString = array("SPT", "Tanggal Setor", "NTPN", "Tanggal Lapor", "Nominal");
		foreach ($loop as $key => $value) {

			$nama_bulan = get_masa_pajak($month, "id", true);
			$excel->setActiveSheetIndex(0)->setCellValue($value.'6', $arrString[$j]);
			$excel->getActiveSheet()->getStyle($value.'5:'.$value.'6')->applyFromArray($style_row_head);

			if($x % 5){
				$excel->setActiveSheetIndex(0)->setCellValue($value.'5', $nama_bulan);
				$j++;
			}
			else{
				$excel->setActiveSheetIndex(0)->setCellValue($value.'5', $nama_bulan);
				$j=0;
				$month++;
			}
			$x++;
		}

		$x = 1;
		foreach ($loop as $key => $value) {

			$loop2 = horizontal_loop_excel($value, 5);
			$next = end($loop2);

			if($x == 1){
				$excel->getActiveSheet()->mergeCells($value.'5:'.$next.'5');
			}

			if($x % 5){
			}
			else{
				$loop2 = horizontal_loop_excel($value++, 6);
				$next = end($loop2);
				$excel->getActiveSheet()->mergeCells($value.'5:'.$next.'5');
			}

			$x++;
		}
			
			if ($kd_cabang == ""){
				$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
			}
			else{
				$whereCabang = "'".$kd_cabang."'";
			}

			$queryExec	= "SELECT skc.KODE_CABANG,
					         skc.NAMA_CABANG
					    FROM simtax_kode_cabang skc
					   WHERE skc.kode_cabang IN (".$whereCabang.")
					   and skc.aktif = 'Y'
					ORDER BY skc.kode_cabang";
					
			$query 		= $this->db->query($queryExec);
			
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
			$i		 = 0;

			$dataSPT = array(
								"BULAN" => array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"),
								"SPT"   => array(1231,52423,213,4584,222215,1312,112312,0,0,0,0,0),
								"NTPN"  => array("AFASD","SDGSDT","GDJFHDF","SDBVDC","CAASC","TJGF","DUYTD","VSDCSD","","","",""),
							);

			$querySPT = "SELECT rpt.KODE_CABANG, ntpn, rpt.bulan_pajak, sntpn.tanggal_lapor,
							sntpn.tanggal_setor, sntpn.nominal,
							(SELECT MAX (xrpt.pph)
					            FROM simtax_rpt_spt_pph_tahunan_v xrpt
					           WHERE     xrpt.kode_cabang = rpt.kode_cabang
					                 AND xrpt.bulan_pajak = rpt.bulan_pajak
					                 AND xrpt.tahun_pajak = rpt.tahun_pajak
					                 AND xrpt.nama_pajak = rpt.nama_pajak)
					            spt_pph
					    FROM    simtax_rpt_spt_pph_tahunan_v rpt
					         LEFT JOIN
					            simtax_ntpn sntpn
					         ON rpt.tahun_pajak = sntpn.tahun
					            AND rpt.nama_pajak = sntpn.jenis_pajak
					            AND rpt.bulan_pajak = sntpn.bulan
					            AND rpt.kode_cabang = sntpn.kode_cabang
					   WHERE rpt.tahun_pajak = '".$tahun."' AND UPPER(rpt.nama_pajak) = '".strtoupper($pajak)."'
					   --AND rpt.kode_cabang = 000
					   --AND rpt.bulan_pajak = 1
					   --AND rpt.bulan_pajak IN(1,2,3,8)
					ORDER BY rpt.KODE_CABANG, rpt.bulan_pajak";

			$resSPT = $this->db->query($querySPT)->result_array();
			$totSPT  = count($resSPT);

			$j=0;
			$dataBulan = array();
			$dataCabang = array();
			$dataNew = array();
			$last_kode_cabang = "";
			for ($i=0; $i < $totSPT ; $i++) {
				$nama_bulan = strtoupper(get_masa_pajak($resSPT[$i]['BULAN_PAJAK'], "id", true));
				$j=$resSPT[$i]['BULAN_PAJAK'];
				$kode_cabang = $resSPT[$i]['KODE_CABANG'];

				if($kode_cabang != $last_kode_cabang){
					$j++;
					$j=$resSPT[$i]['BULAN_PAJAK'];
				}

				$dataNew[$kode_cabang][$j][] = $resSPT[$i];
				$last_kode_cabang = $kode_cabang;

			}

			$i = 0;
			$spt_pph       = 0;
			$tanggal_lapor = "";
			$ntpn          = "";
			$tanggal_setor = "";
			$nominal       = 0;
			$nomor = 1;
			$diee = false;
			$row1 = $query->row_array();
			$lastCabang = $row1['KODE_CABANG'];

			$arrOfFirst = array("C","H","M","R","W","AB","AG","AL","AQ","AV","BA","BF");
			$lastPlus5 = end($arrOfFirst);
			for ($i=0; $i < 4; $i++) { 
				$lastPlus5++;
			}
			
			foreach($query->result_array() as $row)	{

				$cabang = $row['KODE_CABANG'];
				$merge = 0;

				if (array_key_exists($cabang, $dataNew)){

					if($cabang != $lastCabang){
						$uniquePush = array_unique($pushNum);
						$numrow = max($uniquePush);
						$numrow++;
					}
					else{
						unset($pushNum);
					}

					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);	
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['NAMA_CABANG']);
					$loop = horizontal_loop_excel("C", 60);
					$x=1;
					$month=1;
					$z=0;
					$numrowNow=0;
					$lastVal="";
					$newMonth = false;
					$numrowMain = $numrow;
					foreach ($loop as $key => $value) {

						if($x==5){
							$lastVal = $value;
						}

						$dataMonth = $dataNew[$cabang];
						unset($counts);
						if (array_key_exists($month, $dataMonth)){

							foreach ($dataMonth as $key => $count) {
								$counts[] = count($count);
							}
							$maxDataNtpn = max($counts);

							$totDataMonth = count($dataMonth[$month]);
							if($totDataMonth > 0){
								for ($i=0; $i < $totDataMonth ; $i++) {
									$spt_data[1][] = number_format($dataMonth[$month][$i]['SPT_PPH']);
									$spt_data[2][] = $dataMonth[$month][$i]['TANGGAL_LAPOR'];
									$spt_data[3][] = $dataMonth[$month][$i]['NTPN'];
									$spt_data[4][] = $dataMonth[$month][$i]['TANGGAL_SETOR'];
									$spt_data[5][] = ($dataMonth[$month][$i]['NOMINAL']) ? number_format($dataMonth[$month][$i]['NOMINAL']) : "";
								}
							}
							else{
								$spt_data[1] = number_format($dataMonth[$month][0]['SPT_PPH']);
								$spt_data[2] = $dataMonth[$month][0]['TANGGAL_LAPOR'];
								$spt_data[3] = $dataMonth[$month][0]['NTPN'];
								$spt_data[4] = $dataMonth[$month][0]['TANGGAL_SETOR'];
								$spt_data[5] = ($dataMonth[$month][0]['NOMINAL']) ? number_format($dataMonth[$month][0]['NOMINAL']) : "";
							}
						}
						else{
							$spt_data[1] = "";
							$spt_data[2] = "";
							$spt_data[3] = "";
							$spt_data[4] = "";
							$spt_data[5] = "";
						}


						if($x % 5){
							$z++;
							if(is_array($spt_data[$z])){
								$numrowNow = $numrow;
								for ($i=0; $i < $totDataMonth; $i++) {
									if($totDataMonth > 1){
										$merge = $numrowMain+$maxDataNtpn-1;
										if(in_array($value, $arrOfFirst) && $i == 0){
											// echo "<b>Merge ".$value.$numrowMain.":".$value.$merge."</b><br>";
											$excel->getActiveSheet()->mergeCells("A".$numrowMain.':'."A".$merge);
											$excel->getActiveSheet()->mergeCells("B".$numrowMain.':'."B".$merge);
											$excel->getActiveSheet()->mergeCells($value.$numrowMain.':'.$value.$merge);
											$excel->getActiveSheet()->getStyle("A".$numrowMain.':'."A".$merge)->applyFromArray($style_row_no);
											$excel->getActiveSheet()->getStyle($value.$numrowMain.':'.$lastPlus5.$merge)->applyFromArray($style_row_no);
										}
									}
									if($i == 0){
										$excel->getActiveSheet()->getStyle($value.$numrowMain)->applyFromArray($style_row_no);
										$numrow = $numrowMain;
									}
									else{
										$numrow++;
										$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row_no);
										$pushNum[] = $numrow;
									}
									$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[$z][$i]);

									if(in_array($value, $arrOfFirst)){
										if($i>0){
											$spt_data[$z][$i] = "";
										}
									}
									// echo $value.$numrow." - ".$spt_data[$z][$i]."<br>";
									$j++;
								}
								$newMonth = false;
							}
							else{
								$pushNum[] = $numrow;
								$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[$z]);
							}
						}
						else{
							if(is_array($spt_data[$z])){
								$numrowNow = $numrow;
								$excel->getActiveSheet()->getStyle($value.$numrowMain.':'.$lastPlus5.$merge)->applyFromArray($style_row_no);
								for ($i=0; $i < $totDataMonth; $i++) {
									if($i == 0){
										$numrow = $numrowMain;
									}
									else{
										$numrow++;
									$pushNum[] = $numrow;
									}
									$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[5][$i]);
									// echo $value.$numrow." - ".$spt_data[5][$i]."<br>";
									$j++;
								}
							}
							else{
								$pushNum[] = $numrow;
								$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, $spt_data[5]);
							}
							$newMonth= true;
							$lastVal = $value;
							$z=0;
							$month++;
						}
						unset($spt_data);
						$x++;
					}

				}

				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_no);
				$loop = horizontal_loop_excel("B", 61);

				foreach ($loop as $key => $value) {
					$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row);
				}

				$lastCabang = $cabang;
				
				$nomor++; 				
				$numrow++;
			}
			$last_no = $numrow-1;

			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH DISETOR");
			$excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);
			foreach ($arrOfFirst as $key => $value) {
				$excel->setActiveSheetIndex(0)->setCellValue($value.$numrow, "=SUM(".$value."7:".$value.$last_no.")");	
			}

		

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_no);


		$i=0;
		$strTotal = "";

		foreach ($arrOfFirst as $key => $value) {
			if($i > 0){
				$strTotal .= "+".$value.$numrow;
			}
			else{
				$strTotal .= $value.$numrow;
			}
			$i++;
		}

		$numrow  = $numrow += 1;

		$loop = horizontal_loop_excel("A", 62);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value."6:".$value.$numrow)->applyFromArray($style_row);
		}
		$loop = horizontal_loop_excel("A", 2);
		$numrowmin1 = $numrow-1;
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);

		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.$numrowmin1)->applyFromArray($style_row_jud);
			$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($style_row_jud);
		}

		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH SETAHUN");

		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "=(".$strTotal.")" );
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_bold);
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$loop = horizontal_loop_excel("B", 62);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getColumnDimension($value)->setWidth(20); // Set width kolom B
		}
		
		/*$excel->getActiveSheet()->getStyle('C'.$numrowStart.':'.$lastPlus5.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');*/
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle(strtoupper($judul)." ".$tahun);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Rekap SPT Tahunan '.strtoupper($judul).' Tahun '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}
	
	//heri
	function cetak_bupot_pph23()
	{

		/********
		 * $content = the html content to be converted
		 * you can use file_get_content() to get the html from other location
		 *
		 * $filename = filename of the pdf file, make sure you put the extension as .pdf
		 * $save_to = location where you want to save the file,
		 *            set it to null will not save the file but display the file directly after converted
		 * ******/
		try{
			$write	 ="";

			$write	.="

			<page>
			<page_header>
				header
			</page_header>
			";
			$write .=$this->load->view('bupot_pph23/pph23','',TRUE);
				$write	.="
						<page_footer>
						footer
						</page_footer>
		 				</page>
						";
			$filename = 'testing.pdf';
			//$save_to = $this->config->item('upload_root');

			$this->html2pdf_lib->converHtml2pdf($write); //asli
			//$this->html2pdf_lib->writeHTML($write,'coba.pdf'); //asa
			/*if ($this->html2pdf_lib->converHtml2pdf($content,$filename,$save_to)) {
				echo $save_to.'/'.$filename;
			} else {
				echo 'failed';
			} */
		} catch(HTML2PDF_exception $e){
			 echo $e;
			 exit;
		}

	}

	//heri
	function summaryspt()
	{

		/********
		 * $content = the html content to be converted
		 * you can use file_get_content() to get the html from other location
		 *
		 * $filename = filename of the pdf file, make sure you put the extension as .pdf
		 * $save_to = location where you want to save the file,
		 *            set it to null will not save the file but display the file directly after converted
		 * ******/
		try{
			$write	 ="";

			$write	.="

			<page>
			<page_header>
				header
			</page_header>
			";
			$write .=$this->load->view('summaryspt/Summaryspt','',TRUE);
				$write	.="
						<page_footer>
						footer
						</page_footer>
		 				</page>
						";
			$filename = 'testing.pdf';
			//$save_to = $this->config->item('upload_root');

			$this->html2pdf_lib->converHtml2pdf($write); //asli
			//$this->html2pdf_lib->writeHTML($write,'coba.pdf'); //asa
			/*if ($this->html2pdf_lib->converHtml2pdf($content,$filename,$save_to)) {
				echo $save_to.'/'.$filename;
			} else {
				echo 'failed';
			} */
		} catch(HTML2PDF_exception $e){
			 echo $e;
			 exit;
		}
	}

	function export_jns_csv() 
	{
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		if ($pajak=="PPH PSL 15"){
			$this->export_csv_psl_15();
		} else if ($pajak=="PPH PSL 22"){
			$this->export_csv_psl_22();
		} else if ($pajak=="PPH PSL 23 DAN 26"){
			$this->export_csv_23_26();			
		} else if ($pajak=="PPH PSL 4 AYAT 2"){
			$this->export_csv_psl_4_ayat_2();
		} 
	}
	
	function export_csv_psl_15() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];       
		$pembetulan = $_REQUEST['p'];
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong / Kode Form Input PPh Yang Dibayar Sendiri", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong / Nomor Urut Pada PPh Pasal 24 Yang Dapat Diperhitungkan / NTPP", "Tanggal Bukti Potong / Tanggal SSP","Negara Sumber Penghasilan",
		
		"Kode Option Penghasilan","Jumlah Bruto / Jumlah Penghasilan Pada Form Input Yang Dibayar Sendiri","Tarif  /  Jumlah Pajak Terutang yang dibayar di luar negeri","PPh Yang Dipotong  /  PPh Pasal 24 Yang Dapat Diperhitungkan / Jumlah PPh Pada Form Input Yang Dibayar Sendiri",
		"Invoice / Keterangan"
		);
        array_push($export_arr, $title);		
		
		$data       = $this->pph->get_detail_pph15_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $row)	{
			  if ($row['NO_BUKTI_POTONG']) {
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}					
					array_push($export_arr, array(
						"F113313", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG1'],$row['KODE_NEGARA'],
			
						"1",$row['DPP1'],$row['TARIF1'],$row['JUMLAH_POTONG1'],
						$row['INVOICE_NUM']							
					));
				}					
			}
        }
		
       /*convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');*/
       convert_to_csv_PPH21($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function export_csv_psl_22() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];     
		$pembetulan = $_REQUEST['p'];
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		/* $title = array("Kode Form", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong", "Tanggal Bukti Potong",
		"0","0.25","0","0","0.1",
		"0","0","0.3","0","0",
		"0.45","0","","0","0",
		"0","","0","0","0",
		"","0","0","0","",
		"0","1.5","0","","0",
		"1.5","0",
		"BUMN Tertentu","DPP","Tarif","Jumlah Potong",
		"","0","0","0",
		"Total DPP","Total PPH"
		);		
        array_push($export_arr, $title);	 */
		
		$data       = $this->pph->get_pph22_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $row)	{
			  if ($row['NO_BUKTI_POTONG']) {
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}
					
					array_push($export_arr, array("F113304A", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'],
					"0","0.25","0","0","0.1",
					"0","0","0.3","0","0",
					"0.45","0","","0","0",
					"0","","0","0","0",
					"","0","0","0","",
					"0","1.5","0","","0",
					"1.5","0",
					"BUMN Tertentu",$row['DPP1'],$row['TARIF1'],$row['JUMLAH_POTONG1'],
					"","0","0","0",
					$row['DPP1'],$row['JUMLAH_POTONG1']							
					));
				}							
			}
        }       
		 /*convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');*/
		 convert_to_csv_PPH21($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function export_csv_23_26() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];     
		$pembetulan = $_REQUEST['p'];		
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
		$npwp		= "";
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong", "Tanggal Bukti Potong",
		"Nilai Bruto 1", "Tarif 1", "PPh Yang Dipotong 1",
		"Nilai Bruto 2", "Tarif 2", "PPh Yang Dipotong 2",
		"Nilai Bruto 3", "Tarif 3", "PPh Yang Dipotong 3",
		"Nilai Bruto 4", "Tarif 4", "PPh Yang Dipotong 4",
		"Nilai Bruto 5", "Tarif 5", "PPh Yang Dipotong 5",
		"Nilai Bruto 6a/Nilai Bruto 6", "Tarif 6a/Tarif 6", "PPh Yang Dipotong  6a/PPh Yang Dipotong  6",
		"Nilai Bruto 6b/Nilai Bruto 7", "Tarif 6b/Tarif 7", "PPh Yang Dipotong  6b/PPh Yang Dipotong  7",
		"Nilai Bruto 6c/Nilai Bruto 8", "Tarif 6c/Tarif 8", "PPh Yang Dipotong  6c/PPh Yang Dipotong  8",
		"Nilai Bruto 9", "Tarif 9", "PPh Yang Dipotong  9",
		"Nilai Bruto 10", "Perkiraan Penghasilan Netto10", "Tarif 10", "PPh Yang Dipotong 10",
		"Nilai Bruto 11", "Perkiraan Penghasilan Netto11", "Tarif 11", "PPh Yang Dipotong 11",
		"Nilai Bruto 12", "Perkiraan Penghasilan Netto12", "Tarif 12", "PPh Yang Dipotong 12",
		"Nilai Bruto 13", "Tarif 13", "PPh Yang Dipotong 13",
		"Kode Jasa 6d1 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d1", "Tarif 6d1", "PPh Yang Dipotong  6d1",
		"Kode Jasa 6d2 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d2", "Tarif 6d2", "PPh Yang Dipotong  6d2",
		"Kode Jasa 6d3 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d3", "Tarif 6d3", "PPh Yang Dipotong  6d3",
		"Kode Jasa 6d4 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d4", "Tarif 6d4", "PPh Yang Dipotong  6d4",
		"Kode Jasa 6d5 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d5", "Tarif 6d5", "PPh Yang Dipotong  6d5",
		"Kode Jasa 6d6 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d6", "Tarif 6d6", "PPh Yang Dipotong  6d6",
		"Jumlah Nilai Bruto","Jumlah PPh Yang Dipotong"
		);
/*
		$xTitle = implode(",", $title);

		$zTitle = explode(",", $xTitle);*/

	/*	echo "<pre>";

		print_r($zTitle);

		die();*/
        array_push($export_arr, $title);		
		$data       = $this->pph->get_pph23_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 ="0"; $jml_potong1=0;  		$bruto2 =0; $tarif2 ="0"; $jml_potong2=0;
				$bruto3 =0; $tarif3 ="0"; $jml_potong3=0;  		$bruto4 =0; $tarif4 ="0"; $jml_potong4=0;
				$bruto5 =0; $tarif5 ="0"; $jml_potong5=0;  		$bruto6 =0; $tarif6 ="0"; $jml_potong6=0;
				$bruto7 =0; $tarif7 ="0"; $jml_potong7=0;  		$bruto8 =0; $tarif8 ="0"; $jml_potong8=0;
				$bruto9 =0; $tarif9 ="0"; $jml_potong9=0;	 	$bruto10 =0; $tarif10 ="0"; $jml_potong10=0;
				$bruto11 =0; $tarif11 ="0"; $jml_potong11=0;  	$bruto12 =0; $tarif12 ="0"; $jml_potong12=0;
				$bruto13 =0; $tarif13 ="0"; $jml_potong13=0;  	$bruto14 =0; $tarif14 ="0"; $jml_potong14=0;
				$bruto15 =0; $tarif15 ="0"; $jml_potong15=0;  	$bruto16 =0; $tarif16 ="0"; $jml_potong16=0;
				
				$bruto17 =0; $tarif17 ="0"; $jml_potong17=0;  	$bruto18 =0; $tarif18 ="0"; $jml_potong18=0;
				$bruto19 =0; $tarif19 ="0"; $jml_potong19=0;  	
				
				$kodejasa6d1 = "0";	$kodejasa6d2="0";	$kodejasa6d3 = "0"; 	$kodejasa6d4="0"; $kodejasa6d5 = "0"; 	$kodejasa6d6="0";
				$totbruto	 = 0;	$totjmlpotong = 0;
				$i = 0;	
				$arrkodepajak = array();
				$data_detail    = $this->pph->get_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 
				foreach($data_detail->result_array() as $row) {				
				 if($row['KODE_PAJAK2']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					//$cek_detail    = $this->pph->cek_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['KODE_PAJAK']); 
					
					array_push($arrkodepajak,$row['KODE_PAJAK']);					
							if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
								$npwp = "000000000000000";
							} else {
								$npwp 		= str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
							}
							$jml		= strlen($row['KODE_PAJAK']) - 2;
							// $key_pajak	= substr($row['KODE_PAJAK'],$jml,2); // perubahan dari dff
							$key_pajak	= $row['KODE_PAJAK'];

							switch($key_pajak){
								case "01" :
									$bruto1 = $bruto1 + $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 =$jml_potong1 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 1 */									
								break;
								case "02" :
									$bruto2 = $bruto2 + $row['DPP1']; 	$tarif2 = $row['TARIF1']; 	$jml_potong2 = $jml_potong2 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 2 */									
								break;
								case "03" :
									$bruto3 = $bruto3 + $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $jml_potong3 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 3 */									
								break;
								case "04" :
									$bruto4 = $bruto4 + $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $jml_potong4 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 4 */
								break;
								case "05" :
									$bruto5 = $bruto5 + $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $jml_potong5 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 5 */									
								break;
								case "06" :
									$bruto6 = $bruto6 + $row['DPP1']; 	$tarif6 = $row['TARIF1']; 	$jml_potong6 = $jml_potong6 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6a/Nilai Bruto 6 */
								break;
								case "07" :
									$bruto7 = $bruto7 + $row['DPP1']; 	$tarif7 = $row['TARIF1']; 	$jml_potong7 = $jml_potong7 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6b/Nilai Bruto 7 */
								break;
								case "08" :
									$bruto8 = $bruto8 + $row['DPP1']; 	$tarif8 = $row['TARIF1']; 	$jml_potong8 = $jml_potong8 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6c/Nilai Bruto 8 */										
								break;
								// case "09" :
									// $kodejasa6d1 = "";
									// $bruto14 = $bruto14 + $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $jml_potong14 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
								// break;
								// case "10" :
									// $kodejasa6d2 = "";
									// $bruto15 = $bruto15 + $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $jml_potong15 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/									
								// break;
								// case "11" :
									// $kodejasa6d3 = "";
									// $bruto16 = $bruto16 + $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $jml_potong16 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
								// break;
								// case "12" :
									// $kodejasa6d4 = "";
									// $bruto17 = $bruto17 + $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $jml_potong17 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
								// break;
								// case "13" :
									// $kodejasa6d5 = "";
									// $bruto18 = $bruto18 + $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $jml_potong18 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
								// break; 
								// case "14" :
									// $kodejasa6d6 = "";
									// $bruto19 = $bruto19 + $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $jml_potong19 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
								// break;								
								default:								
									$kodejasa6d1 = $key_pajak;
									$bruto14 = $bruto14 + $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $jml_potong14 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/	
										// $idx = $i - 1;
										// if ($bruto14==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK'] ){
												// $kodejasa6d1 = 20;
												// $bruto14 = $bruto14 + $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $jml_potong14 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
											// } else if ($bruto15==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												// $kodejasa6d2 = "";
												// $bruto15 = $bruto15 + $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $jml_potong15 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/
											// } else if ($bruto16==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												// $kodejasa6d3 = "";
												// $bruto16 = $bruto16 + $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $jml_potong16 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
											// } else if ($bruto17==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												// $kodejasa6d4 = "";
												// $bruto17 = $bruto17 + $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $jml_potong17 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
											// } else if ($bruto18==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												// $kodejasa6d5 = "";
												// $bruto18 = $bruto18 + $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $jml_potong18+ $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
											// } else if ($bruto19==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												// $kodejasa6d6 = "";
												// $bruto19 = $bruto19 + $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $jml_potong19 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
											// }
									
								break;
							}								
						  //}
						  $i++;
					  }
					}
					
					$totbruto		= $bruto1 + $bruto2 + $bruto3 + $bruto4 + $bruto5 + $bruto6 + $bruto7 + $bruto8 +
												  $bruto14 + $bruto15 + $bruto16 + $bruto17 + $bruto18 + $bruto19 ;
								$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 +
												  $jml_potong14 + $jml_potong15 + $jml_potong16 + $jml_potong17 + $jml_potong18 + $jml_potong19 ;
					//csv					
					array_push($export_arr, array(
							"F113306", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */
							"", "", "",  /* Nilai Bruto 9 */
							"", "", "", "", /* Nilai Bruto 10 */
							"", "", "", "",/* Nilai Bruto 11 */
							"", "", "", "", /* Nilai Bruto 12 */
							"", "", "", /* Nilai Bruto 13 */
							$kodejasa6d1, /* Kode Jasa 6d1 PMK-244/PMK.03/2008 */
							$bruto14, $tarif14, $jml_potong14,  /* Nilai Bruto 6d1 14*/
							$kodejasa6d2, /* Kode Jasa 6d2 PMK-244/PMK.03/2008 */
							$bruto15, $tarif15, $jml_potong15, /* Nilai Bruto 6d2 15*/
							$kodejasa6d3, /* Kode Jasa 6d3 PMK-244/PMK.03/2008 */
							$bruto16, $tarif16, $jml_potong16, /* Nilai Bruto 6d3 16*/
							$kodejasa6d4, /* Kode Jasa 6d4 PMK-244/PMK.03/2008 */
							$bruto17, $tarif17, $jml_potong17, /* Nilai Bruto 6d4 17*/
							$kodejasa6d5, /* Kode Jasa 6d5 PMK-244/PMK.03/2008 */
							$bruto18, $tarif18, $jml_potong18, /* Nilai Bruto 6d5 18*/
							$kodejasa6d6, /* Kode Jasa 6d6 PMK-244/PMK.03/2008 */
							$bruto19,$tarif19, $jml_potong19, /* Nilai Bruto 6d6 19*/
							$totbruto,$totjmlpotong /* Jumlah Nilai Bruto */							
					));
					/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018' && $row['KODE_PAJAK']=='KP0 PSL23-08'){
						print_r($export_arr."-".$key_pajak);exit();
					} */
				}							
			}
        }
       // convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');

       convert_to_csv_PPH21($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');

    }
	
	function export_csv_23_26_333() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];     
		$pembetulan = $_REQUEST['p'];
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
		$npwp		= "";
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong", "Tanggal Bukti Potong",
		"Nilai Bruto 1", "Tarif 1", "PPh Yang Dipotong 1",
		"Nilai Bruto 2", "Tarif 2", "PPh Yang Dipotong 2",
		"Nilai Bruto 3", "Tarif 3", "PPh Yang Dipotong 3",
		"Nilai Bruto 4", "Tarif 4", "PPh Yang Dipotong 4",
		"Nilai Bruto 5", "Tarif 5", "PPh Yang Dipotong 5",
		"Nilai Bruto 6a/Nilai Bruto 6", "Tarif 6a/Tarif 6", "PPh Yang Dipotong  6a/PPh Yang Dipotong  6",
		"Nilai Bruto 6b/Nilai Bruto 7", "Tarif 6b/Tarif 7", "PPh Yang Dipotong  6b/PPh Yang Dipotong  7",
		"Nilai Bruto 6c/Nilai Bruto 8", "Tarif 6c/Tarif 8", "PPh Yang Dipotong  6c/PPh Yang Dipotong  8",
		"Nilai Bruto 9", "Tarif 9", "PPh Yang Dipotong  9",
		"Nilai Bruto 10", "Perkiraan Penghasilan Netto10", "Tarif 10", "PPh Yang Dipotong 10",
		"Nilai Bruto 11", "Perkiraan Penghasilan Netto11", "Tarif 11", "PPh Yang Dipotong 11",
		"Nilai Bruto 12", "Perkiraan Penghasilan Netto12", "Tarif 12", "PPh Yang Dipotong 12",
		"Nilai Bruto 13", "Tarif 13", "PPh Yang Dipotong 13",
		"Kode Jasa 6d1 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d1", "Tarif 6d1", "PPh Yang Dipotong  6d1",
		"Kode Jasa 6d2 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d2", "Tarif 6d2", "PPh Yang Dipotong  6d2",
		"Kode Jasa 6d3 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d3", "Tarif 6d3", "PPh Yang Dipotong  6d3",
		"Kode Jasa 6d4 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d4", "Tarif 6d4", "PPh Yang Dipotong  6d4",
		"Kode Jasa 6d5 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d5", "Tarif 6d5", "PPh Yang Dipotong  6d5",
		"Kode Jasa 6d6 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d6", "Tarif 6d6", "PPh Yang Dipotong  6d6",
		"Jumlah Nilai Bruto","Jumlah PPh Yang Dipotong"
		);
        array_push($export_arr, $title);		
		$data       = $this->pph->get_pph23_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 =""; $jml_potong1=0;  		$bruto2 =0; $tarif2 =""; $jml_potong2=0;
				$bruto3 =0; $tarif3 =""; $jml_potong3=0;  		$bruto4 =0; $tarif4 =""; $jml_potong4=0;
				$bruto5 =0; $tarif5 =""; $jml_potong5=0;  		$bruto6 =0; $tarif6 =""; $jml_potong6=0;
				$bruto7 =0; $tarif7 =""; $jml_potong7=0;  		$bruto8 =0; $tarif8 =""; $jml_potong8=0;
				$bruto9 =0; $tarif9 =""; $jml_potong9=0;	 	$bruto10 =0; $tarif10 =""; $jml_potong10=0;
				$bruto11 =0; $tarif11 =""; $jml_potong11=0;  	$bruto12 =0; $tarif12 =""; $jml_potong12=0;
				$bruto13 =0; $tarif13 =""; $jml_potong13=0;  	$bruto14 =0; $tarif14 =""; $jml_potong14=0;
				$bruto15 =0; $tarif15 =""; $jml_potong15=0;  	$bruto16 =0; $tarif16 =""; $jml_potong16=0;
				
				$bruto17 =0; $tarif17 =""; $jml_potong17=0;  	$bruto18 =0; $tarif18 =""; $jml_potong18=0;
				$bruto19 =0; $tarif19 =""; $jml_potong19=0;  	
				
				$kodejasa6d1 = "";	$kodejasa6d2="";	$kodejasa6d3 = ""; 	$kodejasa6d4=""; $kodejasa6d5 = ""; 	$kodejasa6d6="";
				$totbruto	 = 0;	$totjmlpotong = 0;
						
				$data_detail    = $this->pph->get_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 
				foreach($data_detail->result_array() as $row) {				
				 if($row['KODE_PAJAK2']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					$cek_detail    = $this->pph->cek_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['KODE_PAJAK']); //cek yg no bukti potong dan kode pajak yg sama
					$i = 0;
					if ($cek_detail){
						foreach($cek_detail->result_array() as $rowSum) {
						//$rowSum	= $cek_detail->row();	
						//print_r($cek_detail); exit();
						/* $row['DPP1'] 			= $rowSum->DPP1;	
						$row['JUMLAH_POTONG1'] 	= $rowSum->JUMLAH_POTONG1;
						$rowCount 				= $rowSum->JML; */
						
						$row['DPP1'] 			= $rowSum['DPP1'];	
						$row['JUMLAH_POTONG1'] 	= $rowSum['JUMLAH_POTONG1'];
						$rowCount 				= $rowSum['JML'];							
								
						}
							
							$npwp 		= str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
							$jml		= strlen($row['KODE_PAJAK']) - 2;
							$key_pajak	= substr($row['KODE_PAJAK'],$jml,2);
							
							switch($key_pajak){
								case "01" :
									$bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 1 */									
								break;
								case "02" :
									$bruto2 = $row['DPP1']; 	$tarif2 = $row['TARIF1']; 	$jml_potong2 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 2 */									
								break;
								case "03" :
									$bruto3 = $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 3 */									
								break;
								case "04" :
									$bruto4 = $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 4 */
								break;
								case "05" :
									$bruto5 = $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 5 */									
								break;
								case "06" :
									$bruto6 = $row['DPP1']; 	$tarif6 = $row['TARIF1']; 	$jml_potong6 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 6a/Nilai Bruto 6 */
								break;
								case "07" :
									$bruto7 = $row['DPP1']; 	$tarif7 = $row['TARIF1']; 	$jml_potong7 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 6b/Nilai Bruto 7 */
								break;
								case "08" :
									$bruto8 = $row['DPP1']; 	$tarif8 = $row['TARIF1']; 	$jml_potong8 = $row['JUMLAH_POTONG1']; /* Nilai Bruto 6c/Nilai Bruto 8 */	
									/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018'){
										print_r($bruto8."-".$jml_potong8);exit();
									} */
								break;
								case "09" :
									$kodejasa6d1 = "";
									$bruto14 = $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
								break;
								case "10" :
									$kodejasa6d2 = "";
									$bruto15 = $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/
									/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018'){
										print_r($bruto15."-".$jml_potong15);exit();
									} */
								break;
								case "11" :
									$kodejasa6d3 = "";
									$bruto16 = $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
								break;
								case "12" :
									$kodejasa6d4 = "";
									$bruto17 = $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
								break;
								case "13" :
									$kodejasa6d5 = "";
									$bruto18 = $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
								break; 
								case "14" :
									$kodejasa6d6 = "";
									$bruto19 = $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
								break;								
								default:
									$i++;									
										if($i==$rowCount){						
											if ($bruto14==0){
												$kodejasa6d1 = "";
												$bruto14 = $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
											} else if ($bruto15==0){
												$kodejasa6d2 = "";
												$bruto15 = $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/
											} else if ($bruto16==0){
												$kodejasa6d3 = "";
												$bruto16 = $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
											} else if ($bruto17==0){
												$kodejasa6d4 = "";
												$bruto17 = $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
											} else if ($bruto18==0){
												$kodejasa6d5 = "";
												$bruto18 = $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
											} else if ($bruto19==0){
												$kodejasa6d6 = "";
												$bruto19 = $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
											}
										}
									
								break;
							}
						}
						$totbruto		= $bruto1 + $bruto2 + $bruto3 + $bruto4 + $bruto5 + $bruto6 + $bruto7 + $bruto8 +
												  $bruto14 + $bruto15 + $bruto16 + $bruto17 + $bruto18 + $bruto19 ;
								$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 +
												  $jml_potong14 + $jml_potong15 + $jml_potong16 + $jml_potong17 + $jml_potong18 + $jml_potong19 ;
					  }
					}
					
					//csv					
					array_push($export_arr, array(
							"F113306", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */
							"", "", "",  /* Nilai Bruto 9 */
							"", "", "", "", /* Nilai Bruto 10 */
							"", "", "", "",/* Nilai Bruto 11 */
							"", "", "", "", /* Nilai Bruto 12 */
							"", "", "", /* Nilai Bruto 13 */
							$kodejasa6d1, /* Kode Jasa 6d1 PMK-244/PMK.03/2008 */
							$bruto14, $tarif14, $jml_potong14,  /* Nilai Bruto 6d1 14*/
							$kodejasa6d2, /* Kode Jasa 6d2 PMK-244/PMK.03/2008 */
							$bruto15, $tarif15, $jml_potong15, /* Nilai Bruto 6d2 15*/
							$kodejasa6d3, /* Kode Jasa 6d3 PMK-244/PMK.03/2008 */
							$bruto16, $tarif16, $jml_potong16, /* Nilai Bruto 6d3 16*/
							$kodejasa6d4, /* Kode Jasa 6d4 PMK-244/PMK.03/2008 */
							$bruto17, $tarif17, $jml_potong17, /* Nilai Bruto 6d4 17*/
							$kodejasa6d5, /* Kode Jasa 6d5 PMK-244/PMK.03/2008 */
							$bruto18, $tarif18, $jml_potong18, /* Nilai Bruto 6d5 18*/
							$kodejasa6d6, /* Kode Jasa 6d6 PMK-244/PMK.03/2008 */
							$bruto19,$tarif19, $jml_potong19, /* Nilai Bruto 6d6 19*/
							$totbruto,$totjmlpotong /* Jumlah Nilai Bruto */							
					));
					/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018' && $row['KODE_PAJAK']=='KP0 PSL23-08'){
						print_r($export_arr."-".$key_pajak);exit();
					} */
				}							
			}
        }
       convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	
	function export_csv_psl_4_ayat_2() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];
		$pembetulan = $_REQUEST['p'];
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong / Kode Form Input PPh Yang Dibayar Sendiri", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong / NTPN", "Tanggal Bukti Potong/Tanggal SSP",
		
		"Jenis Hadiah Undian 1 / Lokasi Tanah dan atau Bangunan / Nama Obligasi", 
			"Kode Option Tempat Penyimpanan 1 (Khusus F113310)", 
			"Jumlah Nilai Bruto 1 / Jumlah Nilai Nominal Obligasi Yg Diperdagangkan Di Bursa Efek / Jumlah Penghasilan Pada Form Input Yang Dibayar Sendiri",
			"Tarif 1 / Tingkat Bunga per Tahun",
			"PPh Yang Dipotong  1 /Jumlah PPh Pada Form Input Yang Dibayar Sendiri",
		
		"Jenis Hadiah Undian 2 / Nomor Seri Obligasi", 
			"Kode Option Tempat Penyimpanan 2", 
			"Jumlah Nilai Bruto 2 / Jumlah Harga Perolehan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 2",
			"PPh Yang Dipotong  2",
		
		"Jenis Hadiah Undian 3", 
			"Kode Option Tempat Penyimpanan 3", 
			"Jumlah Nilai Bruto 3 / Jumlah Harga Penjualan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 3",
			"PPh Yang Dipotong  3",
			
		"Jenis Hadiah Undian 4", 
			"Kode Option Tempat Penyimpanan 4 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 4", 
			"Jumlah Nilai Bruto 4 / Jumlah Diskonto Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 4",
			"PPh Yang Dipotong  4",
			
		"Jenis Hadiah Undian 5", 
			"Kode Option Tempat Penyimpanan 5 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 5", 
			"Jumlah Nilai Bruto 5 / Jumlah Bunga Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 5",
			"PPh Yang Dipotong  5",
			
		"Jenis Hadiah Undian 6", 
			"Jumlah Nilai Bruto 6 / Jumlah Total Bunga atau Diskonto Obligasi Yang Diperdagangkan", 
			"Tarif 6 / Tarif PPh Final Pada Obligasi Yang Diperdagangkan Di Bursa Efek",
			"PPh Yang Dipotong  6",
			
		"Jumlah Nilai Bruto 7", 
			"Tarif 7",
			"PPh Yang Dipotong 7",
			
		"Jenis Penghasilan 8", 
			"Jumlah Nilai Bruto 8",
			"Tarif 8",
			"PPh Yang Dipotong 8",
			
		"Jumlah PPh Yang Dipotong","Tanggal Jatuh Tempo Obligasi","Tanggal Perolehan Obligasi","Tanggal Penjualan Obligasi","Holding Periode Obligasi (Hari)","Time Periode Obligasi (Hari)"
		);
        array_push($export_arr, $title);		
		
		$data       = $this->pph->get_pph23_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 =0; $jml_potong1=0;  		$bruto2 =0; $tarif2 =0; $jml_potong2=0;
				$bruto3 =0; $tarif3 =0; $jml_potong3=0;  		$bruto4 =0; $tarif4 =0; $jml_potong4=0;
				$bruto5 =0; $tarif5 =0; $jml_potong5=0;  		$bruto6 =0; $tarif6 =0; $jml_potong6=0;
				$bruto7 =0; $tarif7 =0; $jml_potong7=0;  		$bruto8 =0; $tarif8 =0; $jml_potong8=0;				
				
				$jnsUndian1 = "";	$jnsUndian2="";	$jnsUndian3 = ""; 	$jnsUndian4="";	$jnsUndian5 = ""; 	$jnsUndian6=""; $jnsUndian8= "";
				$kodeOption1 = "0";	$kodeOption2="0";	$kodeOption3 = "0"; 	$kodeOption4="0";	$kodeOption5 = "0"; 	
				
				$totbruto	 = 0;	$totjmlpotong = 0;			
				$i = 0;
				$data_detail    = $this->pph->get_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 

				foreach($data_detail->result_array() as $row) {
				
				 if ($row['TARIF1']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}			
					$cek_detail    = $this->pph->cek_detail_pph4_2_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['TARIF1']); //cek yg no bukti potong dan kode pajak yg sama

					if ($cek_detail){						
						$rowSum	= $cek_detail->row();						
						$row['DPP1'] 			= $rowSum->DPP1;	
						$row['JUMLAH_POTONG1'] 	= $rowSum->JUMLAH_POTONG1;
						$rowCount 				= $rowSum->JML;
											
							$key_pajak	= $row['TARIF1'];

							switch($key_pajak){
								case 2 :
									$kdform = "F113316";
									$jnsUndian1 = ""; $kodeOption1= 0;																		
									$bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
									$tarif2 = 4; 
									$tarif3 = 3;
									$tarif4 = 4;
									$tarif5 = 6;								
								break;
								case 3 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$jnsUndian3 = ""; $kodeOption3= 0;	$bruto3 = $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $row['JUMLAH_POTONG1'];
									$tarif4 = 4;
									$tarif5 = 6;
								break;
								case 4 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$jnsUndian4 = ""; $kodeOption4= 2;	$bruto4 = $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $row['JUMLAH_POTONG1'];
									$tarif5 = 6;															
								break;
								case 6 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$tarif4 = 4;
									$jnsUndian5 = ""; $kodeOption5= 2;	$bruto5 = $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $row['JUMLAH_POTONG1'];									
								break;								
								case 10 :
									$kdform = "F113312";
									$jnsUndian1 = ""; $kodeOption1= 0; $bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
								break;							
													
							}
											
								$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 ;						 
						
						}
					  }
					}
					//csv	
					array_push($export_arr, array(
							$kdform, $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$jnsUndian1, $kodeOption1, $bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$jnsUndian2, $kodeOption2, $bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$jnsUndian3, $kodeOption3, $bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$jnsUndian4, $kodeOption4, $bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$jnsUndian5, $kodeOption5, $bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$jnsUndian6, $bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$jnsUndian8, $bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */							
							$totjmlpotong,"","","","","" 						
					));
				}							
			}
        }
		
        /*convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');*/
        convert_to_csv_PPH21($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function export_csv_psl_4_ayat_2_awal() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];
		$pembetulan = $_REQUEST['p'];
		$cabang		= $this->session->userdata('kd_cabang');
		$nmcabang	= $this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG;
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong / Kode Form Input PPh Yang Dibayar Sendiri", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong / NTPN", "Tanggal Bukti Potong/Tanggal SSP",
		
		"Jenis Hadiah Undian 1 / Lokasi Tanah dan atau Bangunan / Nama Obligasi", 
			"Kode Option Tempat Penyimpanan 1 (Khusus F113310)", 
			"Jumlah Nilai Bruto 1 / Jumlah Nilai Nominal Obligasi Yg Diperdagangkan Di Bursa Efek / Jumlah Penghasilan Pada Form Input Yang Dibayar Sendiri",
			"Tarif 1 / Tingkat Bunga per Tahun",
			"PPh Yang Dipotong  1 /Jumlah PPh Pada Form Input Yang Dibayar Sendiri",
		
		"Jenis Hadiah Undian 2 / Nomor Seri Obligasi", 
			"Kode Option Tempat Penyimpanan 2", 
			"Jumlah Nilai Bruto 2 / Jumlah Harga Perolehan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 2",
			"PPh Yang Dipotong  2",
		
		"Jenis Hadiah Undian 3", 
			"Kode Option Tempat Penyimpanan 3", 
			"Jumlah Nilai Bruto 3 / Jumlah Harga Penjualan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 3",
			"PPh Yang Dipotong  3",
			
		"Jenis Hadiah Undian 4", 
			"Kode Option Tempat Penyimpanan 4 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 4", 
			"Jumlah Nilai Bruto 4 / Jumlah Diskonto Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 4",
			"PPh Yang Dipotong  4",
			
		"Jenis Hadiah Undian 5", 
			"Kode Option Tempat Penyimpanan 5 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 5", 
			"Jumlah Nilai Bruto 5 / Jumlah Bunga Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 5",
			"PPh Yang Dipotong  5",
			
		"Jenis Hadiah Undian 6", 
			"Jumlah Nilai Bruto 6 / Jumlah Total Bunga atau Diskonto Obligasi Yang Diperdagangkan", 
			"Tarif 6 / Tarif PPh Final Pada Obligasi Yang Diperdagangkan Di Bursa Efek",
			"PPh Yang Dipotong  6",
			
		"Jumlah Nilai Bruto 7", 
			"Tarif 7",
			"PPh Yang Dipotong 7",
			
		"Jenis Penghasilan 8", 
			"Jumlah Nilai Bruto 8",
			"Tarif 8",
			"PPh Yang Dipotong 8",
			
		"Jumlah PPh Yang Dipotong","Tanggal Jatuh Tempo Obligasi","Tanggal Perolehan Obligasi","Tanggal Penjualan Obligasi","Holding Periode Obligasi (Hari)","Time Periode Obligasi (Hari)"
		);
        array_push($export_arr, $title);		
		
		$data       = $this->pph->get_pph23_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 =""; $jml_potong1=0;  		$bruto2 =0; $tarif2 =""; $jml_potong2=0;
				$bruto3 =0; $tarif3 =""; $jml_potong3=0;  		$bruto4 =0; $tarif4 =""; $jml_potong4=0;
				$bruto5 =0; $tarif5 =""; $jml_potong5=0;  		$bruto6 =0; $tarif6 =""; $jml_potong6=0;
				$bruto7 =0; $tarif7 =""; $jml_potong7=0;  		$bruto8 =0; $tarif8 =""; $jml_potong8=0;				
				
				$jnsUndian1 = "";	$jnsUndian2="";	$jnsUndian3 = ""; 	$jnsUndian4="";	$jnsUndian5 = ""; 	$jnsUndian6=""; $jnsUndian8= "";
				$kodeOption1 = "";	$kodeOption2="";	$kodeOption3 = ""; 	$kodeOption4="";	$kodeOption5 = ""; 	
				
				$totbruto	 = 0;	$totjmlpotong = 0;			
				$i = 0;
				$data_detail    = $this->pph->get_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 
				foreach($data_detail->result_array() as $row) {
				 if ($row['TARIF1']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					$cek_detail    = $this->pph->cek_detail_pph4_2_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['TARIF1']); //cek yg no bukti potong dan kode pajak yg sama						
					if ($cek_detail){						
						$rowSum	= $cek_detail->row();						
						$row['DPP1'] 			= $rowSum->DPP1;	
						$row['JUMLAH_POTONG1'] 	= $rowSum->JUMLAH_POTONG1;
						$rowCount 				= $rowSum->JML;
							
							$npwp 		= str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 							
							$key_pajak	= $row['TARIF1'];
							switch($key_pajak){
								case 2 :
									$kdform = "F113316";
									$jnsUndian1 = ""; $kodeOption1= 0;																		
									$bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
									$tarif2 = 4; 
									$tarif3 = 3;
									$tarif4 = 4;
									$tarif5 = 6;								
								break;
								case 3 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$jnsUndian3 = ""; $kodeOption3= 0;	$bruto3 = $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $row['JUMLAH_POTONG1'];
									$tarif4 = 4;
									$tarif5 = 6;
								break;
								case 4 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$jnsUndian4 = ""; $kodeOption4= 1;	$bruto4 = $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $row['JUMLAH_POTONG1'];
									$tarif5 = 6;															
								break;
								case 6 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$tarif4 = 4;
									$jnsUndian5 = ""; $kodeOption5= 2;	$bruto5 = $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $row['JUMLAH_POTONG1'];									
								break;								
								case 10 :
									$kdform = "F113312";
									$jnsUndian1 = ""; $kodeOption1= 0; $bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
								break;								
								/* default :
									$i++;									
									if ($i == $rowCount){
										$jnsUndian8 ="";
										$bruto8 = $row['DPP1']; 	$tarif8 = $row['TARIF1']; 	$jml_potong8 = $row['JUMLAH_POTONG1']; 
								break;	 */						
							}
								//$totbruto		= $bruto1 + $bruto2 + $bruto3 + $bruto4 + $bruto5 + $bruto6 + $bruto7 + $bruto8 ;				
								$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 ;						 
						
						}
					  }
					}
					//csv	
					array_push($export_arr, array(
							$kdform, $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$jnsUndian1, $kodeOption1, $bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$jnsUndian2, $kodeOption2, $bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$jnsUndian3, $kodeOption3, $bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$jnsUndian4, $kodeOption4, $bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$jnsUndian5, $kodeOption5, $bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$jnsUndian6, $bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$jnsUndian8, $bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */							
							$totjmlpotong,"","","","","" 						
					));
				}							
			}
        }
		
        convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	
	//Awal Kompilasi==================================================================
	function export_kompilasi_jns_csv() 
	{
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		if ($pajak=="PPH PSL 15"){
			$this->export_csv_kompilasi_psl_15();
		} else if ($pajak=="PPH PSL 22"){
			$this->export_csv_psl_kompilasi_22();
		} else if ($pajak=="PPH PSL 23 DAN 26"){
			$this->export_csv_kompilasi_23_26();			
		} else if ($pajak=="PPH PSL 4 AYAT 2"){
			$this->export_csv_kompilasi_psl_4_ayat_2();
		} 
	}
	
	function export_csv_kompilasi_psl_15() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];       
		$pembetulan = $_REQUEST['p'];
		$cabang		= $_REQUEST['cabang'];
		$nmcabang	= ($cabang)?$this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG:"KOMPILASI";
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong / Kode Form Input PPh Yang Dibayar Sendiri", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong / Nomor Urut Pada PPh Pasal 24 Yang Dapat Diperhitungkan / NTPP", "Tanggal Bukti Potong / Tanggal SSP","Negara Sumber Penghasilan",
		
		"Kode Option Penghasilan","Jumlah Bruto / Jumlah Penghasilan Pada Form Input Yang Dibayar Sendiri","Tarif  /  Jumlah Pajak Terutang yang dibayar di luar negeri","PPh Yang Dipotong  /  PPh Pasal 24 Yang Dapat Diperhitungkan / Jumlah PPh Pada Form Input Yang Dibayar Sendiri",
		"Invoice / Keterangan"
		);
        array_push($export_arr, $title);		
		
		$data       = $this->pph->get_detail_kompilasi_pph15_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $row)	{
			  if ($row['NO_BUKTI_POTONG']) {
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}					
					array_push($export_arr, array(
						$row['KODE_FORM'], $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG1'],$row['KODE_NEGARA'],
			
						$row['KODE_PAJAK'],$row['DPP1'],$row['TARIF1'],$row['JUMLAH_POTONG1'],
						$row['INVOICE_NUM']							
					));
				}					
			}
        }
		
       convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function export_csv_psl_kompilasi_22() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];     
		$pembetulan = $_REQUEST['p'];
		$cabang		= $_REQUEST['cabang'];
		$nmcabang	= ($cabang)?$this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG:"KOMPILASI";
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();   	
		
		$data       = $this->pph->get_pph22_kompilasi_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $row)	{
			  if ($row['NO_BUKTI_POTONG']) {
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}
					
					array_push($export_arr, array("F113304A", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'],
					"0","0.25","0","0","0.1",
					"0","0","0.3","0","0",
					"0.45","0","","0","0",
					"0","","0","0","0",
					"","0","0","0","",
					"0","1.5","0","","0",
					"1.5","0",
					"BUMN Tertentu",$row['DPP1'],$row['TARIF1'],$row['JUMLAH_POTONG1'],
					"","0","0","0",
					$row['DPP1'],$row['JUMLAH_POTONG1']							
					));
				}							
			}
        }       
		 convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
		
	function export_csv_kompilasi_23_26() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];     
		$pembetulan = $_REQUEST['p'];		
		$cabang		= $_REQUEST['cabang'];			
		$nmcabang	= ($cabang)?$this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG:"KOMPILASI";
		$date	    = date("Y-m-d H:i:s");
		$npwp		= "";
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong", "Tanggal Bukti Potong",
		"Nilai Bruto 1", "Tarif 1", "PPh Yang Dipotong 1",
		"Nilai Bruto 2", "Tarif 2", "PPh Yang Dipotong 2",
		"Nilai Bruto 3", "Tarif 3", "PPh Yang Dipotong 3",
		"Nilai Bruto 4", "Tarif 4", "PPh Yang Dipotong 4",
		"Nilai Bruto 5", "Tarif 5", "PPh Yang Dipotong 5",
		"Nilai Bruto 6a/Nilai Bruto 6", "Tarif 6a/Tarif 6", "PPh Yang Dipotong  6a/PPh Yang Dipotong  6",
		"Nilai Bruto 6b/Nilai Bruto 7", "Tarif 6b/Tarif 7", "PPh Yang Dipotong  6b/PPh Yang Dipotong  7",
		"Nilai Bruto 6c/Nilai Bruto 8", "Tarif 6c/Tarif 8", "PPh Yang Dipotong  6c/PPh Yang Dipotong  8",
		"Nilai Bruto 9", "Tarif 9", "PPh Yang Dipotong  9",
		"Nilai Bruto 10", "Perkiraan Penghasilan Netto10", "Tarif 10", "PPh Yang Dipotong 10",
		"Nilai Bruto 11", "Perkiraan Penghasilan Netto11", "Tarif 11", "PPh Yang Dipotong 11",
		"Nilai Bruto 12", "Perkiraan Penghasilan Netto12", "Tarif 12", "PPh Yang Dipotong 12",
		"Nilai Bruto 13", "Tarif 13", "PPh Yang Dipotong 13",
		"Kode Jasa 6d1 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d1", "Tarif 6d1", "PPh Yang Dipotong  6d1",
		"Kode Jasa 6d2 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d2", "Tarif 6d2", "PPh Yang Dipotong  6d2",
		"Kode Jasa 6d3 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d3", "Tarif 6d3", "PPh Yang Dipotong  6d3",
		"Kode Jasa 6d4 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d4", "Tarif 6d4", "PPh Yang Dipotong  6d4",
		"Kode Jasa 6d5 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d5", "Tarif 6d5", "PPh Yang Dipotong  6d5",
		"Kode Jasa 6d6 PMK-244/PMK.03/2008",
		"Nilai Bruto 6d6", "Tarif 6d6", "PPh Yang Dipotong  6d6",
		"Jumlah Nilai Bruto","Jumlah PPh Yang Dipotong"
		);
        array_push($export_arr, $title);		
		$data       = $this->pph->get_pph23_kompilasi_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 =""; $jml_potong1=0;  		$bruto2 =0; $tarif2 =""; $jml_potong2=0;
				$bruto3 =0; $tarif3 =""; $jml_potong3=0;  		$bruto4 =0; $tarif4 =""; $jml_potong4=0;
				$bruto5 =0; $tarif5 =""; $jml_potong5=0;  		$bruto6 =0; $tarif6 =""; $jml_potong6=0;
				$bruto7 =0; $tarif7 =""; $jml_potong7=0;  		$bruto8 =0; $tarif8 =""; $jml_potong8=0;
				$bruto9 =0; $tarif9 =""; $jml_potong9=0;	 	$bruto10 =0; $tarif10 =""; $jml_potong10=0;
				$bruto11 =0; $tarif11 =""; $jml_potong11=0;  	$bruto12 =0; $tarif12 =""; $jml_potong12=0;
				$bruto13 =0; $tarif13 =""; $jml_potong13=0;  	$bruto14 =0; $tarif14 =""; $jml_potong14=0;
				$bruto15 =0; $tarif15 =""; $jml_potong15=0;  	$bruto16 =0; $tarif16 =""; $jml_potong16=0;
				
				$bruto17 =0; $tarif17 =""; $jml_potong17=0;  	$bruto18 =0; $tarif18 =""; $jml_potong18=0;
				$bruto19 =0; $tarif19 =""; $jml_potong19=0;  	
				
				$kodejasa6d1 = "";	$kodejasa6d2="";	$kodejasa6d3 = ""; 	$kodejasa6d4=""; $kodejasa6d5 = ""; 	$kodejasa6d6="";
				$totbruto	 = 0;	$totjmlpotong = 0;
				$i = 0;	
				$arrkodepajak = array();
				$data_detail    = $this->pph->get_detail_pph23_kompilasi_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 
				foreach($data_detail->result_array() as $row) {				
				 if($row['KODE_PAJAK2']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					//$cek_detail    = $this->pph->cek_detail_pph23_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['KODE_PAJAK']); 
					
					array_push($arrkodepajak,$row['KODE_PAJAK']);					
							if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
								$npwp = "000000000000000";
							} else {
								$npwp 		= str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
							}
							$jml		= strlen($row['KODE_PAJAK']) - 2;
							$key_pajak	= substr($row['KODE_PAJAK'],$jml,2);
							switch($key_pajak){
								case "01" :
									$bruto1 = $bruto1 + $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 =$jml_potong1 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 1 */									
								break;
								case "02" :
									$bruto2 = $bruto2 + $row['DPP1']; 	$tarif2 = $row['TARIF1']; 	$jml_potong2 = $jml_potong2 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 2 */									
								break;
								case "03" :
									$bruto3 = $bruto3 + $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $jml_potong3 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 3 */									
								break;
								case "04" :
									$bruto4 = $bruto4 + $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $jml_potong4 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 4 */
								break;
								case "05" :
									$bruto5 = $bruto5 + $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $jml_potong5 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 5 */									
								break;
								case "06" :
									$bruto6 = $bruto6 + $row['DPP1']; 	$tarif6 = $row['TARIF1']; 	$jml_potong6 = $jml_potong6 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6a/Nilai Bruto 6 */
								break;
								case "07" :
									$bruto7 = $bruto7 + $row['DPP1']; 	$tarif7 = $row['TARIF1']; 	$jml_potong7 = $jml_potong7 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6b/Nilai Bruto 7 */
								break;
								case "08" :
									$bruto8 = $bruto8 + $row['DPP1']; 	$tarif8 = $row['TARIF1']; 	$jml_potong8 = $jml_potong8 + $row['JUMLAH_POTONG1']; /* Nilai Bruto 6c/Nilai Bruto 8 */	
									/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018'){
										print_r($bruto8."-".$jml_potong8);exit();
									} */
								break;
								case "09" :
									$kodejasa6d1 = "";
									$bruto14 = $bruto14 + $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $jml_potong14 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
								break;
								case "10" :
									$kodejasa6d2 = "";
									$bruto15 = $bruto15 + $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $jml_potong15 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/
									/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018'){
										print_r($bruto15."-".$jml_potong15);exit();
									} */
								break;
								case "11" :
									$kodejasa6d3 = "";
									$bruto16 = $bruto16 + $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $jml_potong16 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
								break;
								case "12" :
									$kodejasa6d4 = "";
									$bruto17 = $bruto17 + $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $jml_potong17 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
								break;
								case "13" :
									$kodejasa6d5 = "";
									$bruto18 = $bruto18 + $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $jml_potong18 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
								break; 
								case "14" :
									$kodejasa6d6 = "";
									$bruto19 = $bruto19 + $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $jml_potong19 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
								break;								
								default:								
										
										$idx = $i - 1;
										if ($bruto14==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK'] ){
												$kodejasa6d1 = "";
												$bruto14 = $bruto14 + $row['DPP1']; 	$tarif14 = $row['TARIF1']; 	$jml_potong14 = $jml_potong14 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d1 14*/
											} else if ($bruto15==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												$kodejasa6d2 = "";
												$bruto15 = $bruto15 + $row['DPP1']; 	$tarif15 = $row['TARIF1']; 	$jml_potong15 = $jml_potong15 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d2 15*/
											} else if ($bruto16==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												$kodejasa6d3 = "";
												$bruto16 = $bruto16 + $row['DPP1']; 	$tarif16 = $row['TARIF1']; 	$jml_potong16 = $jml_potong16 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d3 16*/
											} else if ($bruto17==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												$kodejasa6d4 = "";
												$bruto17 = $bruto17 + $row['DPP1']; 	$tarif17 = $row['TARIF1']; 	$jml_potong17 = $jml_potong17 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d4 17*/
											} else if ($bruto18==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												$kodejasa6d5 = "";
												$bruto18 = $bruto18 + $row['DPP1']; 	$tarif18 = $row['TARIF1']; 	$jml_potong18 = $jml_potong18+ $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d5 18*/
											} else if ($bruto19==0 || $arrkodepajak[$idx]==$row['KODE_PAJAK']){
												$kodejasa6d6 = "";
												$bruto19 = $bruto19 + $row['DPP1']; 	$tarif19 = $row['TARIF1']; 	$jml_potong19 = $jml_potong19 + $row['JUMLAH_POTONG1'];  /* Nilai Bruto 6d6 19*/
											}
									
								break;
							}								
						  //}
						  $i++;
					  }
					}
					
					$totbruto		= $bruto1 + $bruto2 + $bruto3 + $bruto4 + $bruto5 + $bruto6 + $bruto7 + $bruto8 +
												  $bruto14 + $bruto15 + $bruto16 + $bruto17 + $bruto18 + $bruto19 ;
					$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 +
												  $jml_potong14 + $jml_potong15 + $jml_potong16 + $jml_potong17 + $jml_potong18 + $jml_potong19 ;
					//csv					
					array_push($export_arr, array(
							"F113306", $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */
							"", "", "",  /* Nilai Bruto 9 */
							"", "", "", "", /* Nilai Bruto 10 */
							"", "", "", "",/* Nilai Bruto 11 */
							"", "", "", "", /* Nilai Bruto 12 */
							"", "", "", /* Nilai Bruto 13 */
							$kodejasa6d1, /* Kode Jasa 6d1 PMK-244/PMK.03/2008 */
							$bruto14, $tarif14, $jml_potong14,  /* Nilai Bruto 6d1 14*/
							$kodejasa6d2, /* Kode Jasa 6d2 PMK-244/PMK.03/2008 */
							$bruto15, $tarif15, $jml_potong15, /* Nilai Bruto 6d2 15*/
							$kodejasa6d3, /* Kode Jasa 6d3 PMK-244/PMK.03/2008 */
							$bruto16, $tarif16, $jml_potong16, /* Nilai Bruto 6d3 16*/
							$kodejasa6d4, /* Kode Jasa 6d4 PMK-244/PMK.03/2008 */
							$bruto17, $tarif17, $jml_potong17, /* Nilai Bruto 6d4 17*/
							$kodejasa6d5, /* Kode Jasa 6d5 PMK-244/PMK.03/2008 */
							$bruto18, $tarif18, $jml_potong18, /* Nilai Bruto 6d5 18*/
							$kodejasa6d6, /* Kode Jasa 6d6 PMK-244/PMK.03/2008 */
							$bruto19,$tarif19, $jml_potong19, /* Nilai Bruto 6d6 19*/
							$totbruto,$totjmlpotong /* Jumlah Nilai Bruto */							
					));
					/* if ($row['NO_BUKTI_POTONG']=='000219/PPh23/26/I/KP0-2018' && $row['KODE_PAJAK']=='KP0 PSL23-08'){
						print_r($export_arr."-".$key_pajak);exit();
					} */
				}							
			}
        }
       convert_to_csv($export_arr,'KOMPILASI '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	function export_csv_kompilasi_psl_4_ayat_2() {
        $this->load->helper('csv_helper');
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan  	= $this->pph->getMonth($_REQUEST['month']);
        $tahun  	= $_REQUEST['year'];
		$pembetulan = $_REQUEST['p'];
		$cabang		= $_REQUEST['cabang'];			
		$nmcabang	= ($cabang)?$this->Cabang_mdl->get_by_id($cabang)->NAMA_CABANG:"KOMPILASI";
		$date	    = date("Y-m-d H:i:s");
        $export_arr = array();      
				
		$title = array("Kode Form Bukti Potong / Kode Form Input PPh Yang Dibayar Sendiri", "Masa Pajak", "Tahun Pajak","Pembetulan", "NPWP WP yang Dipotong", "Nama WP yang Dipotong","Alamat WP yang Dipotong", "Nomor Bukti Potong / NTPN", "Tanggal Bukti Potong/Tanggal SSP",
		
		"Jenis Hadiah Undian 1 / Lokasi Tanah dan atau Bangunan / Nama Obligasi", 
			"Kode Option Tempat Penyimpanan 1 (Khusus F113310)", 
			"Jumlah Nilai Bruto 1 / Jumlah Nilai Nominal Obligasi Yg Diperdagangkan Di Bursa Efek / Jumlah Penghasilan Pada Form Input Yang Dibayar Sendiri",
			"Tarif 1 / Tingkat Bunga per Tahun",
			"PPh Yang Dipotong  1 /Jumlah PPh Pada Form Input Yang Dibayar Sendiri",
		
		"Jenis Hadiah Undian 2 / Nomor Seri Obligasi", 
			"Kode Option Tempat Penyimpanan 2", 
			"Jumlah Nilai Bruto 2 / Jumlah Harga Perolehan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 2",
			"PPh Yang Dipotong  2",
		
		"Jenis Hadiah Undian 3", 
			"Kode Option Tempat Penyimpanan 3", 
			"Jumlah Nilai Bruto 3 / Jumlah Harga Penjualan Bersih (tanpa Bunga) Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 3",
			"PPh Yang Dipotong  3",
			
		"Jenis Hadiah Undian 4", 
			"Kode Option Tempat Penyimpanan 4 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 4", 
			"Jumlah Nilai Bruto 4 / Jumlah Diskonto Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 4",
			"PPh Yang Dipotong  4",
			
		"Jenis Hadiah Undian 5", 
			"Kode Option Tempat Penyimpanan 5 / Kode Option Perencanaan (1) atau Pengawasan (2) atau selainnya (0) untuk BP Jasa Konstruksi poin 5", 
			"Jumlah Nilai Bruto 5 / Jumlah Bunga Pada Obligasi Yg Diperdagangkan Di Bursa Efek",
			"Tarif 5",
			"PPh Yang Dipotong  5",
			
		"Jenis Hadiah Undian 6", 
			"Jumlah Nilai Bruto 6 / Jumlah Total Bunga atau Diskonto Obligasi Yang Diperdagangkan", 
			"Tarif 6 / Tarif PPh Final Pada Obligasi Yang Diperdagangkan Di Bursa Efek",
			"PPh Yang Dipotong  6",
			
		"Jumlah Nilai Bruto 7", 
			"Tarif 7",
			"PPh Yang Dipotong 7",
			
		"Jenis Penghasilan 8", 
			"Jumlah Nilai Bruto 8",
			"Tarif 8",
			"PPh Yang Dipotong 8",
			
		"Jumlah PPh Yang Dipotong","Tanggal Jatuh Tempo Obligasi","Tanggal Perolehan Obligasi","Tanggal Penjualan Obligasi","Holding Periode Obligasi (Hari)","Time Periode Obligasi (Hari)"
		);
        array_push($export_arr, $title);		
		
		$data       = $this->pph->get_pph23_kompilasi_csv();		
        if (!empty($data)) {         
			foreach($data->result_array() as $rowbupot)	{
			  if ($rowbupot['NO_BUKTI_POTONG']) {				
				$bruto1 =0; $tarif1 =""; $jml_potong1=0;  		$bruto2 =0; $tarif2 =""; $jml_potong2=0;
				$bruto3 =0; $tarif3 =""; $jml_potong3=0;  		$bruto4 =0; $tarif4 =""; $jml_potong4=0;
				$bruto5 =0; $tarif5 =""; $jml_potong5=0;  		$bruto6 =0; $tarif6 =""; $jml_potong6=0;
				$bruto7 =0; $tarif7 =""; $jml_potong7=0;  		$bruto8 =0; $tarif8 =""; $jml_potong8=0;				
				
				$jnsUndian1 = "";	$jnsUndian2="";	$jnsUndian3 = ""; 	$jnsUndian4="";	$jnsUndian5 = ""; 	$jnsUndian6=""; $jnsUndian8= "";
				$kodeOption1 = "";	$kodeOption2="";	$kodeOption3 = ""; 	$kodeOption4="";	$kodeOption5 = ""; 	
				
				$totbruto	 = 0;	$totjmlpotong = 0;			
				$i = 0;
				$data_detail    = $this->pph->get_detail_pph23_kompilasi_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan); 
				foreach($data_detail->result_array() as $row) {
				 if ($row['TARIF1']){
					$row['KODE_PAJAK'] = $row['KODE_PAJAK2'];
					if(!$row['NPWP1'] || $row['NPWP1']==0 || $row['NPWP1']=="" || $row['NPWP1']=="-") {
						$npwp = "000000000000000";
					} else {
						$npwp = str_replace(array(" ",".","-","/"),"",$row['NPWP1']); 
					}			
					$cek_detail    = $this->pph->cek_detail_pph4_2_kompilasi_csv($rowbupot['NO_BUKTI_POTONG'], $pembetulan, $row['TARIF1']); //cek yg no bukti potong dan kode pajak yg sama						
					if ($cek_detail){						
						$rowSum	= $cek_detail->row();						
						$row['DPP1'] 			= $rowSum->DPP1;	
						$row['JUMLAH_POTONG1'] 	= $rowSum->JUMLAH_POTONG1;
						$rowCount 				= $rowSum->JML;
											
							$key_pajak	= $row['TARIF1'];
							switch($key_pajak){
								case 2 :
									$kdform = "F113316";
									$jnsUndian1 = ""; $kodeOption1= 0;																		
									$bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
									$tarif2 = 4; 
									$tarif3 = 3;
									$tarif4 = 4;
									$tarif5 = 6;								
								break;
								case 3 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$jnsUndian3 = ""; $kodeOption3= 0;	$bruto3 = $row['DPP1']; 	$tarif3 = $row['TARIF1']; 	$jml_potong3 = $row['JUMLAH_POTONG1'];
									$tarif4 = 4;
									$tarif5 = 6;
								break;
								case 4 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$jnsUndian4 = ""; $kodeOption4= 1;	$bruto4 = $row['DPP1']; 	$tarif4 = $row['TARIF1']; 	$jml_potong4 = $row['JUMLAH_POTONG1'];
									$tarif5 = 6;															
								break;
								case 6 :
									$kdform = "F113316";
									$tarif1 = 2;
									$tarif2 = 4;
									$tarif3 = 3;
									$tarif4 = 4;
									$jnsUndian5 = ""; $kodeOption5= 2;	$bruto5 = $row['DPP1']; 	$tarif5 = $row['TARIF1']; 	$jml_potong5 = $row['JUMLAH_POTONG1'];									
								break;								
								case 10 :
									$kdform = "F113312";
									$jnsUndian1 = ""; $kodeOption1= 0; $bruto1 = $row['DPP1']; 	$tarif1 = $row['TARIF1']; 	$jml_potong1 = $row['JUMLAH_POTONG1'];
								break;							
													
							}
											
								$totjmlpotong 	= $jml_potong1 + $jml_potong2 + $jml_potong3 + $jml_potong4 + $jml_potong5 + $jml_potong6 + 				 $jml_potong7 + $jml_potong8 ;						 
						
						}
					  }
					}
					//csv	
					array_push($export_arr, array(
							$kdform, $row['BULAN_PAJAK'], $row['TAHUN_PAJAK'], $row['PEMBETULAN_KE'], $npwp, $row['VENDOR_NAME'], $row['ADDRESS_LINE1'], $row['NO_BUKTI_POTONG'], $row['TGL_BUKTI_POTONG'], 
							$jnsUndian1, $kodeOption1, $bruto1, $tarif1, $jml_potong1, /* Nilai Bruto 1 */
							$jnsUndian2, $kodeOption2, $bruto2, $tarif2, $jml_potong2, /* Nilai Bruto 2 */
							$jnsUndian3, $kodeOption3, $bruto3, $tarif3, $jml_potong3, /* Nilai Bruto 3 */
							$jnsUndian4, $kodeOption4, $bruto4, $tarif4, $jml_potong4, /* Nilai Bruto 4 */
							$jnsUndian5, $kodeOption5, $bruto5, $tarif5, $jml_potong5,  /* Nilai Bruto 5 */
							$jnsUndian6, $bruto6, $tarif6, $jml_potong6,  /* Nilai Bruto 6a/Nilai Bruto 6 */
							$bruto7, $tarif7, $jml_potong7, /* Nilai Bruto 6b/Nilai Bruto 7 */
							$jnsUndian8, $bruto8, $tarif8, $jml_potong8, /* Nilai Bruto 6c/Nilai Bruto 8 */							
							$totjmlpotong,"","","","","" 						
					));
				}							
			}
        }
		
        convert_to_csv($export_arr,strtoupper($nmcabang).' '.$pajak.' '.$bulan.' '.$tahun.' '.$pembetulan.'.csv', ';');
    }
	
	//Akhir Kompilasi==================================================================
		
	//ADDED BY Mike - 26/03/2018
	//Number to text converter
	//------------------------------------------------------------------------
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "Minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}
		return $hasil;
	}
	//------------------------------------------------------------------------
	//used for create PDF File
	//------------------------------------------------------------------------
	
	//used for create PDF File
	//------------------------------------------------------------------------
	function cetakPphNew(){

		require_once('vendor/autoload.php');

		//data from POST request
		$pajak       = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan       = $_REQUEST['month'];
		$tahun       = $_REQUEST['year'];
		$pembetulan  = $_REQUEST['pembetulan'];
		$isCabang	 = $_REQUEST['isCabang'];
		$valCabang	 = FALSE;
		$nomorFaktur = FALSE;
		if(isset($_REQUEST['nf']))
			$nomorFaktur  = $_REQUEST['nf'];
		
		if(isset($_REQUEST['valCabang']))
			$valCabang  = $_REQUEST['valCabang'];
		
		//select template
		if($pajak == "PPH PSL 23 DAN 26"){
			$this->cetakPPH23($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur);
		}
		/* else if($pajak == "PPH PSL 26"){
			$this->cetakPPH26($bulan, $tahun, $pajak, $nomorFaktur);
		} */
		else if($pajak == "PPH PSL 22"){
			$this->cetakPPH22($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur);
		}
		else if($pajak == "PPH PSL 4 AYAT 2"){
			$this->cetakPPH4Ayat2($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur);
		}
		else if($pajak == "PPH PSL 15"){
			$this->cetakPPH15($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur);
		}

	}
	//------------------------------------------------------------------------
	
	function cetakPPH23($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur){
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$fh = 'assets/templates/2326/bupot-PPH-23.pdf';

		//GET DATA
		$data['pph'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,$nomorFaktur,"BUKTI POTONG");

		//COMPILE Data
		$arrayOfNoBuktiPotong = array();
		$arrData = array();
		foreach ($data['pph'] as $pph):
			$noBuktiPotong 	= $pph['NO_BUKTI_POTONG'];
			$npwp			= $pph['NPWP'];
			$nmkpp 			= ($pph['NAMA_KPP'])?strtoupper($pph['NAMA_KPP']):'';
			//if($noBuktiPotong == "")
				//continue;
			$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
			if($idx == FALSE){
				array_push($arrayOfNoBuktiPotong,$noBuktiPotong);
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
				$arrData[$idx]['totalJasaLain'] = 0;
				$arrData[$idx]['total'] = 0;
				$arrData[$idx]['totalDPP'] = 0;

				//untuk bagian jasa lain
				$arrData[$idx]['00'] = 0;
				$arrData[$idx]['01'] = 0;
				$arrData[$idx]['02'] = 0;
				$arrData[$idx]['03'] = 0;
				$arrData[$idx]['03a'] = 0;
				$arrData[$idx]['03b'] = 0;
				$arrData[$idx]['03c'] = 0;
				$arrData[$idx]['04'] = 0;
				$arrData[$idx]['05'] = 0;
				$arrData[$idx]['07'] = 0;
				$arrData[$idx]['08'] = 0;
				$arrData[$idx]['09'] = 0;
				$arrData[$idx]['10'] = 0;
				$arrData[$idx]['11'] = 0;
				$arrData[$idx]['12'] = 0;
				$arrData[$idx]['13'] = 0;
				$arrData[$idx]['14'] = 0;
				$arrData[$idx]['15'] = 0;
				$arrData[$idx]['16'] = 0;
				$arrData[$idx]['17'] = 0;
				$arrData[$idx]['17a'] = 0;
				$arrData[$idx]['18'] = 0;
				$arrData[$idx]['18a'] = 0;
				$arrData[$idx]['18b'] = 0;
				$arrData[$idx]['18c'] = 0;
				$arrData[$idx]['19'] = 0;
				$arrData[$idx]['20'] = 0;
				$arrData[$idx]['20a'] = 0;
				$arrData[$idx]['21'] = 0;
				$arrData[$idx]['22'] = 0;
				$arrData[$idx]['23'] = 0;
				$arrData[$idx]['24'] = 0;
				$arrData[$idx]['25'] = 0;
				$arrData[$idx]['26'] = 0;
				$arrData[$idx]['27'] = 0;
				$arrData[$idx]['27a'] = 0;
				$arrData[$idx]['27b'] = 0;
				$arrData[$idx]['28'] = 0;
				$arrData[$idx]['29'] = 0;
				$arrData[$idx]['30'] = 0;
				$arrData[$idx]['31'] = 0;
				$arrData[$idx]['32'] = 0;
				$arrData[$idx]['33'] = 0;
				$arrData[$idx]['34'] = 0;
				$arrData[$idx]['35'] = 0;
				$arrData[$idx]['36'] = 0;
				$arrData[$idx]['37'] = 0;
				$arrData[$idx]['38'] = 0;
				$arrData[$idx]['39'] = 0;
				$arrData[$idx]['40'] = 0;
				$arrData[$idx]['41'] = 0;
				$arrData[$idx]['42'] = 0;
				$arrData[$idx]['43'] = 0;
				$arrData[$idx]['44'] = 0;
				$arrData[$idx]['45'] = 0;
				$arrData[$idx]['46'] = 0;
				$arrData[$idx]['47'] = 0;
				$arrData[$idx]['48'] = 0;
				$arrData[$idx]['49'] = 0;
				$arrData[$idx]['50'] = 0;
				$arrData[$idx]['51'] = 0;
				$arrData[$idx]['52'] = 0;
				$arrData[$idx]['53'] = 0;
				$arrData[$idx]['54'] = 0;
				$arrData[$idx]['55'] = 0;
				$arrData[$idx]['56'] = 0;
				$arrData[$idx]['57'] = 0;
				$arrData[$idx]['58'] = 0;

				$arrData[$idx]['dividenBruto'] = 0;
				$arrData[$idx]['dividenJumlahPotong'] = 0;
				$arrData[$idx]['bungaBruto'] = 0;
				$arrData[$idx]['bungaJumlahPotong'] = 0;
				$arrData[$idx]['royaltiBruto'] = 0;
				$arrData[$idx]['royaltiJumlahPotong'] = 0;
				$arrData[$idx]['hadiahBruto'] = 0;
				$arrData[$idx]['sewaJumlahPotong'] = 0;
				$arrData[$idx]['sewaBruto'] = 0;
				$arrData[$idx]['sewaJumlahPotong']  = 0;
				$arrData[$idx]['jasaTeknikBruto'] = 0;
				$arrData[$idx]['sewaJumlahPotong']  = 0;
				$arrData[$idx]['jasaManagemenBruto'] = 0;
				$arrData[$idx]['jasaManagemenJumlahPotong'] = 0;
				$arrData[$idx]['jasaKonsultanBruto'] = 0;
				$arrData[$idx]['jasaKonsultanJumlahPotong'] = 0;
				$arrData[$idx]['jasaTeknikJumlahPotong'] = 0 ;
				$arrData[$idx]['hadiahJumlahPotong'] = 0 ;
				
			}
			$arrData[$idx]['textNo1'] = $nmkpp;
			$arrData[$idx]['textNo2'] = $noBuktiPotong;
			$arrData[$idx]['npwp'] = $pph['NPWP'];
			$arrData[$idx]['namaWP'] = substr($pph['NAMA_WP'],0,29);
			$arrData[$idx]['addressWP'] = substr($pph['ALAMAT_WP'],0,29);
			$arrData[$idx]['lokasiPP'] = $pph['KOTA'];
			$arrData[$idx]['tanggalBuktiPotong'] = $pph['TGL_BUKTI_POTONG'];
			$arrData[$idx]['npwpPP'] = $pph['NPWPPP'];
			$arrData[$idx]['namaPP'] = substr($pph['NAMAPP'],0,40);
			$arrData[$idx]['namattd'] = $pph['NAMA_PETUGAS_PENANDATANGAN'];
			$arrData[$idx]['jabttd'] = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
			$arrData[$idx]['signature'] = $pph['URL_TANDA_TANGAN'];
			$kodePajak = substr($pph['KODE_PAJAK'], -3);
			/*if($kodePajak == "")
				continue;
			else if($kodePajak == "01"){
				$arrData[$idx]['dividenBruto'] += $pph['DPP'];
				$arrData[$idx]['dividenTarif'] = $pph['TARIF'];
				$arrData[$idx]['dividenJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "02"){
				$arrData[$idx]['bungaBruto'] += $pph['DPP'];
				$arrData[$idx]['bungaTarif'] = $pph['TARIF'];
				$arrData[$idx]['bungaJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "03"){
				$arrData[$idx]['royaltiBruto'] += $pph['DPP'];
				$arrData[$idx]['royaltiTarif'] = $pph['TARIF'];
				$arrData[$idx]['royaltiJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "04"){
				$arrData[$idx]['hadiahBruto'] += $pph['DPP'];
				$arrData[$idx]['hadiahTarif'] = $pph['TARIF'];
				$arrData[$idx]['hadiahJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "05"){
				$arrData[$idx]['sewaBruto'] += $pph['DPP'];
				$arrData[$idx]['sewaTarif'] = $pph['TARIF'];
				$arrData[$idx]['sewaJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "06"){
				$arrData[$idx]['jasaTeknikBruto'] += $pph['DPP'];
				$arrData[$idx]['jasaTeknikTarif'] = $pph['TARIF'];
				$arrData[$idx]['jasaTeknikJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "07"){
				$arrData[$idx]['jasaManagemenBruto'] += $pph['DPP'];
				$arrData[$idx]['jasaManagemenTarif'] = $pph['TARIF'];
				$arrData[$idx]['jasaManagemenJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "08"){
				$arrData[$idx]['jasaKonsultanBruto'] += $pph['DPP'];
				$arrData[$idx]['jasaKonsultanTarif'] = $pph['TARIF'];
				$arrData[$idx]['jasaKonsultanJumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];*/
			if($kodePajak == "")
				continue;
			else if($kodePajak == "00"){
				if($arrData[$idx]['00'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['00'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['00'].'label'] = "Sewa dan penghasilan lain sehubungan dengan penggunaan harta kecuali sewa tanah dan bangunan yang telah dikenai PPh Pasal 4 ayat (2) UU PPh";
				$arrData[$idx]['jasa'.$arrData[$idx]['00'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['00'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['00'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "01"){
				if($arrData[$idx]['01'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['01'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['01'].'label'] = "Jasa Penilai (appraisal)";
				$arrData[$idx]['jasa'.$arrData[$idx]['01'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['01'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['01'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "02"){
				if($arrData[$idx]['02'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['02'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['02'].'label'] = "Jasa Aktuaris";
				$arrData[$idx]['jasa'.$arrData[$idx]['02'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['02'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['02'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "03"){
				if($arrData[$idx]['03'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['03'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['03'].'label'] = "Jasa Akuntansi, Pembukuan, dan Atestasi Laporan Keuangan";
				$arrData[$idx]['jasa'.$arrData[$idx]['03'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "03a"){
				if($arrData[$idx]['03a'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['03a'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['03a'].'label'] = "Jasa Hukum";
				$arrData[$idx]['jasa'.$arrData[$idx]['03a'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03a'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03a'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "03b"){
				if($arrData[$idx]['03b'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['03b'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['03b'].'label'] = "Jasa Arsitektur";
				$arrData[$idx]['jasa'.$arrData[$idx]['03b'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03b'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03b'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "03c"){
				if($arrData[$idx]['03c'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['03c'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['03c'].'label'] = "Jasa Perancang Kota dan Arsitektur Landscape";
				$arrData[$idx]['jasa'.$arrData[$idx]['03c'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03c'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['03c'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "04"){
				if($arrData[$idx]['04'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['04'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['04'].'label'] = "Jasa Perancang (design)";
				$arrData[$idx]['jasa'.$arrData[$idx]['04'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['04'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['04'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "05"){
				if($arrData[$idx]['05'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['05'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['05'].'label'] = "Jasa Pengeboran (drilling) di Bidang Penambangan Minyak dan Gas Bumi (Migas), kecuali yang Dilakukan oleh Bentuk Usaha Tetap (BUT)";
				$arrData[$idx]['jasa'.$arrData[$idx]['05'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['05'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['05'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "07"){
				if($arrData[$idx]['07'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['07'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['07'].'label'] = "Jasa penunjang di bidang usaha panas bumi dan penambangan minyak dan gas bumi (migas) ";
				$arrData[$idx]['jasa'.$arrData[$idx]['07'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['07'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['07'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "08"){
				if($arrData[$idx]['08'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['08'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['08'].'label'] = "Jasa penambangan dan jasa penunjang di bidang usaha panas bumi dan penambangan minyak dan gas bumi (migas) ";
				$arrData[$idx]['jasa'.$arrData[$idx]['08'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['08'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['08'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "09"){
				if($arrData[$idx]['09'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['09'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['09'].'label'] = "Jasa Penunjang di Bidang Penerbangan dan Bandar Udara";
				$arrData[$idx]['jasa'.$arrData[$idx]['09'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['09'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['09'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "10"){
				if($arrData[$idx]['10'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['10'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['10'].'label'] = "Jasa Penebangan Hutan";
				$arrData[$idx]['jasa'.$arrData[$idx]['10'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['10'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['10'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "11"){
				if($arrData[$idx]['11'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['11'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['11'].'label'] = "Jasa Pengolahan Limbah";
				$arrData[$idx]['jasa'.$arrData[$idx]['11'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['11'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['11'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "12"){
				if($arrData[$idx]['12'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['12'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['12'].'label'] = "Jasa Penyedia Tenaga Kerja dan/atau Tenaga Ahli (outsourcing services)";
				$arrData[$idx]['jasa'.$arrData[$idx]['12'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['12'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['12'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "13"){
				if($arrData[$idx]['13'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['13'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['13'].'label'] = "Jasa Perantara dan/atau Keagenan";
				$arrData[$idx]['jasa'.$arrData[$idx]['13'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['13'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['13'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "14"){
				if($arrData[$idx]['14'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['14'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['14'].'label'] = "Jasa bidang perdagangan surat-surat berharga, kecuali yang dilakukan Bursa Efek, Kustodian Sentral Efek Indonesia (KSEI) dan Kliring Penjaminan Efek Indonesia (KPEI)";
				$arrData[$idx]['jasa'.$arrData[$idx]['14'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['14'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['14'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "15"){
				if($arrData[$idx]['15'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['15'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['15'].'label'] = "Jasa Kustodian/Penyimpanan/Penitipan, Kecuali Yang Dilakukan Oleh KSEI";
				$arrData[$idx]['jasa'.$arrData[$idx]['15'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['15'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['15'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "16"){
				if($arrData[$idx]['16'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['16'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['16'].'label'] = "Jasa Pengisian Suara (dubbing) dan/atau Sulih Suara";
				$arrData[$idx]['jasa'.$arrData[$idx]['16'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['16'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['16'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "17"){
				if($arrData[$idx]['17'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['17'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['17'].'label'] = "Jasa Mixing Film";
				$arrData[$idx]['jasa'.$arrData[$idx]['17'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['17'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['17'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "17a"){
				if($arrData[$idx]['17a'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['17a'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['17a'].'label'] = "Jasa Pembuatan Sarana Promosi Film, Iklan, Poster, Photo, Slede, Klise, Banner, Pamphlet, Baliho, dan Folder";
				$arrData[$idx]['jasa'.$arrData[$idx]['17a'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['17a'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['17a'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "18"){
				if($arrData[$idx]['18'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['18'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['18'].'label'] = "Jasa Sehubungan Dengan Software atau Hardware atau Sistem Komputer, Termasuk Perawatan, Pemeliharaan dan Perbaikan";
				$arrData[$idx]['jasa'.$arrData[$idx]['18'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "18a"){
				if($arrData[$idx]['18a'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['18a'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['18a'].'label'] = "Jasa Pembuatan dan/atau Pengelolaan Website";
				$arrData[$idx]['jasa'.$arrData[$idx]['18a'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18a'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18a'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "18b"){
				if($arrData[$idx]['18b'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['18b'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['18b'].'label'] = "Jasa Internet Termasuk Sambungannya";
				$arrData[$idx]['jasa'.$arrData[$idx]['18b'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18b'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18b'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "18c"){
				if($arrData[$idx]['18c'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['18c'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['18c'].'label'] = "Jasa Internet Termasuk Sambungannya";
				$arrData[$idx]['jasa'.$arrData[$idx]['18c'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18c'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['18c'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "19"){
				if($arrData[$idx]['19'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['19'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['19'].'label'] = "Jasa Instalasi/Pemasangan Mesin, Peralatan, Listrik, Telepon, Air, Gas, AC, dan/atau TV kabel, Selain Yang Dilakukan Oleh Wajib Pajak Yang Ruang Lingkupnya di Bidang Konstruksi";
				$arrData[$idx]['jasa'.$arrData[$idx]['19'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['19'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['19'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "20"){
				if($arrData[$idx]['20'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['20'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['20'].'label'] = "Jasa perawatan kendaraan dan/atau alat transportasi darat";
				$arrData[$idx]['jasa'.$arrData[$idx]['20'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['20'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['20'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "20a"){
				if($arrData[$idx]['20a'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['20a'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['20a'].'label'] = "Jasa Perawatan Kendaraan dan/atau Alat Transportasi Darat, Laut dan Udara";
				$arrData[$idx]['jasa'.$arrData[$idx]['20a'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['20a'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['20a'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "21"){
				if($arrData[$idx]['21'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['21'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['21'].'label'] = "Jasa Maklon";
				$arrData[$idx]['jasa'.$arrData[$idx]['21'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['21'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['21'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "22"){
				if($arrData[$idx]['22'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['22'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['22'].'label'] = "Jasa Penyelidikan dan Keamanan";
				$arrData[$idx]['jasa'.$arrData[$idx]['22'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['22'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['22'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "23"){
				if($arrData[$idx]['23'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['23'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['23'].'label'] = "Jasa Penyelenggaraan Kegiatan atau Event Organizer";
				$arrData[$idx]['jasa'.$arrData[$idx]['23'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['23'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['23'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "24"){
				if($arrData[$idx]['24'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['24'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['24'].'label'] = "Jasa Pengepakan";
				$arrData[$idx]['jasa'.$arrData[$idx]['24'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['24'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['24'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "25"){
				if($arrData[$idx]['25'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['25'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['25'].'label'] = "Jasa Penyediaan Tempat dan/atau Waktu Dalam Media Masa, Media Luar Ruang atau Media Lain Untuk Menyampaikan Informasi, dan/atau Jasa Periklanan";
				$arrData[$idx]['jasa'.$arrData[$idx]['25'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['25'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['25'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "26"){
				if($arrData[$idx]['26'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['26'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['26'].'label'] = "Jasa Pembasmian Hama";
				$arrData[$idx]['jasa'.$arrData[$idx]['26'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['26'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['26'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "27"){
				if($arrData[$idx]['27'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['27'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['27'].'label'] = "Jasa Kebersihan atau Cleaning Service";
				$arrData[$idx]['jasa'.$arrData[$idx]['27'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "27a"){
				if($arrData[$idx]['27a'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['27a'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['27a'].'label'] = "Jasa Sedot Septic Tank";
				$arrData[$idx]['jasa'.$arrData[$idx]['27a'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27a'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27a'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "27b"){
				if($arrData[$idx]['27b'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['27b'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['27b'].'label'] = "Jasa Pemeliharaan Kolam";
				$arrData[$idx]['jasa'.$arrData[$idx]['27b'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27b'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['27b'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "28"){
				if($arrData[$idx]['28'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['28'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['28'].'label'] = "Jasa Katering atau Tata Boga";
				$arrData[$idx]['jasa'.$arrData[$idx]['28'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['28'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['28'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "29"){
				if($arrData[$idx]['29'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['29'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['29'].'label'] = "Jasa Freight Forwarding";
				$arrData[$idx]['jasa'.$arrData[$idx]['29'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['29'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['29'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "30"){
				if($arrData[$idx]['30'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['30'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['30'].'label'] = "Jasa Logistik";
				$arrData[$idx]['jasa'.$arrData[$idx]['30'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['30'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['30'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "31"){
				if($arrData[$idx]['31'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['31'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['31'].'label'] = "Jasa Pengurusan Dokumen";
				$arrData[$idx]['jasa'.$arrData[$idx]['31'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['31'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['31'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "32"){
				if($arrData[$idx]['32'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['32'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['32'].'label'] = "Jasa Loading dan Unloading";
				$arrData[$idx]['jasa'.$arrData[$idx]['32'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['32'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['32'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "33"){
				if($arrData[$idx]['33'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['33'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['33'].'label'] = "Jasa laboratorium dan/atau pengujian kecuali yang dilakukan oleh lembaga atau institusi pendidikan dalam rangka penelitian akademis ";
				$arrData[$idx]['jasa'.$arrData[$idx]['33'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['33'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['33'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "34"){
				if($arrData[$idx]['34'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['34'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['34'].'label'] = "Jasa Pengelolaan Parkir";
				$arrData[$idx]['jasa'.$arrData[$idx]['34'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['34'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['34'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "35"){
				if($arrData[$idx]['35'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['35'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['35'].'label'] = "Jasa Penyondiran Tanah";
				$arrData[$idx]['jasa'.$arrData[$idx]['35'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['35'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['35'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "36"){
				if($arrData[$idx]['36'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['36'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['36'].'label'] = "Jasa Penyiapan dan/atau Pengolahan Lahan";
				$arrData[$idx]['jasa'.$arrData[$idx]['36'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['36'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['36'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "37"){
				if($arrData[$idx]['37'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['37'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['37'].'label'] = "Jasa Pembibitan dan/atau Penanaman Bibit";
				$arrData[$idx]['jasa'.$arrData[$idx]['37'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['37'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['37'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "38"){
				if($arrData[$idx]['38'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['38'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['38'].'label'] = "Jasa Pemeliharaan Tanaman";
				$arrData[$idx]['jasa'.$arrData[$idx]['38'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['38'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['38'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "39"){
				if($arrData[$idx]['39'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['39'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['39'].'label'] = "Jasa Pemanenan";
				$arrData[$idx]['jasa'.$arrData[$idx]['39'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['39'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['39'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "40"){
				if($arrData[$idx]['40'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['40'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['40'].'label'] = "Jasa Pengolahan Hasil Pertanian, Perkebunan, Perikanan, Peternakan dan/atau Perhutanan";
				$arrData[$idx]['jasa'.$arrData[$idx]['40'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['40'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['40'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "41"){
				if($arrData[$idx]['41'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['41'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['41'].'label'] = "Jasa Dekorasi";
				$arrData[$idx]['jasa'.$arrData[$idx]['41'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['41'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['41'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "42"){
				if($arrData[$idx]['42'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['42'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['42'].'label'] = "Jasa Percetakan/Penerbitan";
				$arrData[$idx]['jasa'.$arrData[$idx]['42'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['42'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['42'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "43"){
				if($arrData[$idx]['43'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['43'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['43'].'label'] = "Jasa Penerjemahan";
				$arrData[$idx]['jasa'.$arrData[$idx]['43'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['43'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['43'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "44"){
				if($arrData[$idx]['44'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['44'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['44'].'label'] = "Jasa Pengangkutan/Ekspedisi Kecuali yang Telah Diatur Dalam Pasal 15 Undang-Undang Pajak Penghasilan";
				$arrData[$idx]['jasa'.$arrData[$idx]['44'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['44'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['44'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "45"){
				if($arrData[$idx]['45'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['45'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['45'].'label'] = "Jasa Pelayanan Kepelabuhanan";
				$arrData[$idx]['jasa'.$arrData[$idx]['45'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['45'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['45'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "46"){
				if($arrData[$idx]['46'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['46'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['46'].'label'] = "Jasa Pengangkutan Melalui Jalur Pipa";
				$arrData[$idx]['jasa'.$arrData[$idx]['46'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['46'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['46'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "47"){
				if($arrData[$idx]['47'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['47'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['47'].'label'] = "Jasa Pengelolaan Penitipan Anak";
				$arrData[$idx]['jasa'.$arrData[$idx]['47'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['47'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['47'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "48"){
				if($arrData[$idx]['48'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['48'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['48'].'label'] = "Jasa Pelatihan dan/atau Kursus";
				$arrData[$idx]['jasa'.$arrData[$idx]['48'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['48'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['48'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "49"){
				if($arrData[$idx]['49'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['49'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['49'].'label'] = "Jasa Pengiriman dan Pengisian Uang ke ATM";
				$arrData[$idx]['jasa'.$arrData[$idx]['49'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['49'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['49'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "50"){
				if($arrData[$idx]['50'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['50'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['50'].'label'] = "Jasa Sertifikasi";
				$arrData[$idx]['jasa'.$arrData[$idx]['50'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['50'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['50'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "51"){
				if($arrData[$idx]['51'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['51'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['51'].'label'] = "Jasa Survey";
				$arrData[$idx]['jasa'.$arrData[$idx]['51'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['51'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['51'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "52"){
				if($arrData[$idx]['52'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['52'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['52'].'label'] = "Jasa Tester";
				$arrData[$idx]['jasa'.$arrData[$idx]['52'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['52'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['52'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "53"){
				if($arrData[$idx]['53'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['53'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['53'].'label'] = "Jasa selain jasa-jasa tersebut di atas yang pembayarannya dibebankan pada APBN (Anggaran Pendapatan dan Belanja Negara) atau APBD (Anggaran Pendapatan dan Belanja Daerah).";
				$arrData[$idx]['jasa'.$arrData[$idx]['53'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['53'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['53'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "54"){
				if($arrData[$idx]['54'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['54'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['54'].'label'] = "Dividen";
				$arrData[$idx]['jasa'.$arrData[$idx]['54'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['54'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['54'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "55"){
				if($arrData[$idx]['55'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['55'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['55'].'label'] = "Bunga";
				$arrData[$idx]['jasa'.$arrData[$idx]['55'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['55'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['55'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "56"){
				if($arrData[$idx]['56'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['58'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['56'].'label'] = "Royalti";
				$arrData[$idx]['jasa'.$arrData[$idx]['56'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['56'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['56'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "57"){
				if($arrData[$idx]['57'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['57'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['57'].'label'] = "Hadiah dan penghargaan";
				$arrData[$idx]['jasa'.$arrData[$idx]['57'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['57'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['57'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}else if($kodePajak == "58"){
				if($arrData[$idx]['58'] == 0){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['58'] = $arrData[$idx]['totalJasaLain'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = 0;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = 0;
				}
				$arrData[$idx]['jasa'.$arrData[$idx]['58'].'label'] = "Sewa dan penghasilan lain sehubungan dengan penggunaan harta";
				$arrData[$idx]['jasa'.$arrData[$idx]['58'].'Bruto'] += $pph['DPP'];
				$arrData[$idx]['jasa'.$arrData[$idx]['58'].'Tarif'] = $pph['TARIF'];
				$arrData[$idx]['jasa'.$arrData[$idx]['58'].'JumlahPotong'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				$arrData[$idx]['totalDPP'] += $pph['DPP'];
			}

		endforeach;

		//print_r($arrData);

		//set template
		foreach ($arrData as $datum){
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//======================================================
			$guideline = 0; //change to 1 to see field border for every parameter
			$limitTextJasaLain = 22; //number of char will be displayed
			$textNo1 = $datum['textNo1']; //Change this value from DB
			$textNo2 = $datum['textNo2']; //Change this value from DB for Number
			$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
			$name = $datum['namaWP']; //Change this value from DB for name
			$address = $datum['addressWP']; //Change this value from DB for address
			$dividenBruto = (isset($datum['dividenBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['dividenBruto'],0,'.','.')) : ""; //Change this value from DB for Dividen Bruto
			$dividenTidakNPWP = false; //Change this value from DB for Dividen non-NPWP (TRUE/FALSE)
			$dividenTarif = (isset($datum['dividenTarif'])) ? number_format($datum['dividenTarif'],0,'.','.')."%" : ""; //Change this value from DB for Percentage Dividen
			$dividenPPHDipotong = (isset($datum['dividenJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['dividenJumlahPotong'],0,'.','.')) : ""; //Change this value from DB for PPH Dividen
			$bungaBruto = (isset($datum['bungaBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['bungaBruto'],0,'.','.')) : "";
			$bungaTidakNPWP = false;
			$bungaTarif = (isset($datum['bungaTarif'])) ? number_format($datum['bungaTarif'],0,'.','.')."%" : "";
			$bungaPPHDipotong = (isset($datum['bungaJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['bungaJumlahPotong'],0,'.','.')) : "";
			$royaltiBruto = (isset($datum['royaltiBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['royaltiBruto'],0,'.','.')) : "";
			$royaltiTidakNPWP = false;
			$royaltiTarif = (isset($datum['royaltiTarif'])) ? number_format($datum['royaltiTarif'],0,'.','.')."%" : "";
			$royaltiPPHDipotong = (isset($datum['royaltiJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['royaltiJumlahPotong'],0,'.','.')) : "";
			$hadiahBruto = (isset($datum['hadiahBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['hadiahBruto'],0,'.','.')) : "";
			$hadiahTidakNPWP = false;
			$hadiahTarif = (isset($datum['hadiahTarif'])) ? number_format($datum['hadiahTarif'],0,'.','.')."%" : "";
			$hadiahPPHDipotong = (isset($datum['hadiahJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['hadiahJumlahPotong'],0,'.','.')) : "";
			$sewaBruto = (isset($datum['sewaBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['sewaBruto'],0,'.','.')) : "";
			$sewaTidakNPWP = false;
			$sewaTarif = (isset($datum['sewaTarif'])) ? number_format($datum['sewaTarif'],0,'.','.')."%" : "";
			$sewaPPHDipotong = (isset($datum['sewaJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['sewaJumlahPotong'],0,'.','.')) : "";
			$jasaTeknikBruto = (isset($datum['jasaTeknikBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaTeknikBruto'],0,'.','.')) : "";
			$jasaTeknikTidakNPWP = false;
			$jasaTeknikTarif = (isset($datum['jasaTeknikTarif'])) ? number_format($datum['jasaTeknikTarif'],0,'.','.')."%" : "";
			$jasaTeknikPPHDipotong = (isset($datum['jasaTeknikJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaTeknikJumlahPotong'],0,'.','.')) : "";
			$jasaManagemenBruto = (isset($datum['jasaManagemenBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaManagemenBruto'],0,'.','.')) : "";
			$jasaManagemenTidakNPWP = false;
			$jasaManagemenTarif = (isset($datum['jasaManagemenTarif'])) ? number_format($datum['jasaManagemenTarif'],0,'.','.')."%" : "";
			$jasaManagemenPPHDipotong = (isset($datum['jasaManagemenJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaManagemenJumlahPotong'],0,'.','.')) : "";
			$jasaKonsultanBruto = (isset($datum['jasaKonsultanBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaKonsultanBruto'],0,'.','.')) : "";
			$jasaKonsultanTidakNPWP = false;
			$jasaKonsultanTarif = (isset($datum['jasaKonsultanTarif'])) ? number_format($datum['jasaKonsultanTarif'],0,'.','.')."%" : "";
			$jasaKonsultanPPHDipotong = (isset($datum['jasaKonsultanJumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasaKonsultanJumlahPotong'],0,'.','.')) : "";
			$jasaLain1Text = (isset($datum['jasa1label'])) ? $datum['jasa1label'] : "";
			$jasaLain1Bruto = (isset($datum['jasa1Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa1Bruto'],0,'.','.')) : "";
			$jasaLain1TidakNPWP = false;
			$jasaLain1Tarif = (isset($datum['jasa1Tarif'])) ? number_format($datum['jasa1Tarif'],0,'.','.')."%" : "";
			$jasaLain1PPHDipotong = (isset($datum['jasa1JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa1JumlahPotong'],0,'.','.')) : "";
			$jasaLain2Text = (isset($datum['jasa2label'])) ? $datum['jasa2label'] : "";
			$jasaLain2Bruto = (isset($datum['jasa2Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa2Bruto'],0,'.','.')) : "";
			$jasaLain2TidakNPWP = false;
			$jasaLain2Tarif = (isset($datum['jasa2Tarif'])) ? number_format($datum['jasa2Tarif'],0,'.','.')."%" : "";
			$jasaLain2PPHDipotong = (isset($datum['jasa2JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa2JumlahPotong'],0,'.','.')) : "";
			$jasaLain3Text = (isset($datum['jasa3label'])) ? $datum['jasa3label'] : "";
			$jasaLain3Bruto = (isset($datum['jasa3Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa3Bruto'],0,'.','.')) : "";
			$jasaLain3TidakNPWP = false;
			$jasaLain3Tarif = (isset($datum['jasa3Tarif'])) ? number_format($datum['jasa3Tarif'],0,'.','.')."%" : "";
			$jasaLain3PPHDipotong = (isset($datum['jasa3JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa3JumlahPotong'],0,'.','.')) : "";
			$jasaLain4Text = (isset($datum['jasa4label'])) ? $datum['jasa4label'] : "";
			$jasaLain4Bruto = (isset($datum['jasa4Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa4Bruto'],0,'.','.')) : "";
			$jasaLain4TidakNPWP = false;
			$jasaLain4Tarif = (isset($datum['jasa4Tarif'])) ? number_format($datum['jasa4Tarif'],0,'.','.')."%" : "";
			$jasaLain4PPHDipotong = (isset($datum['jasa4JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa4JumlahPotong'],0,'.','.')) : "";
			$jasaLain5Text = (isset($datum['jasa5label'])) ? $datum['jasa5label'] : "";
			$jasaLain5Bruto = (isset($datum['jasa5Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa5Bruto'],0,'.','.')) : "";
			$jasaLain5TidakNPWP = false;
			$jasaLain5Tarif = (isset($datum['jasa5Tarif'])) ? number_format($datum['jasa5Tarif'],0,'.','.')."%" : "";
			$jasaLain5PPHDipotong = (isset($datum['jasa5JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa5JumlahPotong'],0,'.','.')) : "";
			$jasaLain6Text = (isset($datum['jasa6label'])) ? $datum['jasa6label'] : "";
			$jasaLain6Bruto = (isset($datum['jasa6Bruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa6Bruto'],0,'.','.')) : "";
			$jasaLain6TidakNPWP = false;
			$jasaLain6Tarif = (isset($datum['jasa6Tarif'])) ? number_format($datum['jasa6Tarif'],0,'.','.')."%" : "";
			$jasaLain6PPHDipotong = (isset($datum['jasa6JumlahPotong'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['jasa6JumlahPotong'],0,'.','.')) : "";
			$total = preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['total'],0,'.','.'));
			$totaldpp = preg_replace('/(-)([\d\.\,]+)/ui','($2)', number_format($datum['totalDPP'],0,'.','.'));
			$terbilang = $this->terbilang($datum['total'])." Rupiah";
			$Lokasi = $datum['lokasiPP'];
			$tanggalBulan = substr($datum['tanggalBuktiPotong'], 0, -2);
			$tahun = substr($datum['tanggalBuktiPotong'], -2); //YY
			$noNPWPPemotong = $datum['npwpPP'];
			$namaPemotong = $datum['namaPP'];
			$namaTTD = $datum['namattd'];
			$jabTTD = $datum['jabttd'];
			$signatureURL = $datum['signature'];
			//======================================================

			//for Number 1
			//======================================================
			$pdf->SetXY(38, 34);
			$pdf->Cell(65,1,$textNo1,$guideline,1,"C");
			//======================================================

			//for Number 2
			//======================================================
			$pdf->SetXY(85, 50.8);
			$pdf->Cell(55,1,$textNo2,$guideline,1,"C");
			//======================================================

			//NPWP
			//======================================================
			$noNPWP = str_replace('.','',$noNPWP);
			$noNPWP = str_replace('-','',$noNPWP);
			$height = 60.8;
			$start_npwp_header = 46.4;
			$space_npwp_header = 5.4;

			$npwp1 = substr ( $noNPWP, 0, 1 );
			$pdf->SetXY($start_npwp_header, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWP, 1, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWP, 2, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWP, 3, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWP, 4, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWP, 5, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWP, 6, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWP, 7, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWP, 8, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWP, 9, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWP, 10, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWP, 11, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWP, 12, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWP, 13, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWP, 14, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME
			//======================================================
			$name = strtoupper($name);
			$nameStart = 46.4;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 67.2);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//ADDRESS
			//======================================================
			$address = strtoupper($address);
			$addressStart = 46.4;
			$addressSpace = 5.4;
			for($i = 0; $i < strlen($address); $i++){
				$pdf->SetXY($addressStart + ($addressSpace * $i), 73.8);
				$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//DIVIDEN
			//======================================================
			$height = 100.6;
			$bruto = $dividenBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($dividenTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$dividenTarif,$guideline,1,"C");


			$pphDipotong = $dividenPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//BUNGA
			//======================================================
			$height = 106.4;
			$bruto = $bungaBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($bungaTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$bungaTarif,$guideline,1,"C");


			$pphDipotong = $bungaPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//ROYALTI
			//======================================================
			$height = 112;
			$bruto = $royaltiBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($royaltiTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$royaltiTarif,$guideline,1,"C");


			$pphDipotong = $royaltiPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//HADIAH
			//======================================================
			$height = 117.6;
			$bruto = $hadiahBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($hadiahTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$hadiahTarif,$guideline,1,"C");


			$pphDipotong = $hadiahPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//SEWA
			//======================================================
			$height = 134.6;
			$bruto = $sewaBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($sewaTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$sewaTarif,$guideline,1,"C");


			$pphDipotong = $sewaPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA TEKNIK
			//======================================================
			$height = 157;
			$bruto = $jasaTeknikBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaTeknikTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaTeknikTarif,$guideline,1,"C");


			$pphDipotong = $jasaTeknikPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA MANAGEMEN
			//======================================================
			$height = 162.7;
			$bruto = $jasaManagemenBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaManagemenTidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaManagemenTarif,$guideline,1,"C");


			$pphDipotong = $jasaManagemenPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA KONSULTAN
			//======================================================
			$height = 168.3;
			$bruto = $jasaKonsultanBruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaKonsultanTidakNPWP){
				$pdf->SetXY(127.2, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaKonsultanTarif,$guideline,1,"C");


			$pphDipotong = $jasaKonsultanPPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 1
			//======================================================
			$height = 179.6;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain1Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain1Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain1TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain1Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain1PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 2
			//======================================================
			$height = 185.2;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain2Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain2Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain2TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain2Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain2PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 3
			//======================================================
			$height = 190.8;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain3Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain3Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain3TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain3Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain3PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 4
			//======================================================
			$height = 196.4;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain4Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain4Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain4TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain4Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain4PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 5
			//======================================================
			$height = 202;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain5Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain5Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain5TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain5Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain5PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//JASA LAIN 6
			//======================================================
			$height = 207.8;

			$pdf->SetXY(30, $height);
			$pdf->Cell(35,1,substr($jasaLain6Text,0,$limitTextJasaLain),$guideline,1,"L");

			$bruto = $jasaLain6Bruto;
			$pdf->SetXY(74, $height);
			$pdf->Cell(40,1,$bruto,$guideline,1,"R");

			if($jasaLain6TidakNPWP){
				$pdf->SetXY(127, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}


			$pdf->SetXY(144, $height);
			$pdf->Cell(13,1,$jasaLain6Tarif,$guideline,1,"C");


			$pphDipotong = $jasaLain6PPHDipotong;
			$pdf->SetXY(160.5, $height);
			$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
			//======================================================

			//TOTAL
			//======================================================
			$total = $total;
			$pdf->SetXY(160.5, 219);
			$pdf->Cell(40,1,$total,$guideline,1,"R");

			$pdf->SetXY(74, 219);
			$pdf->Cell(40,1,$totaldpp,$guideline,1,"R");
			//======================================================

			//TERBILANG
			//======================================================
			$pdf->SetXY(30, 225);
			$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
			//======================================================

			//TANGGAL
			//======================================================
			$height = 236;
			$pdf->SetXY(115, $height);
			$pdf->Cell(24,1,$Lokasi,$guideline,1,"R");

			$pdf->SetXY(146, $height);
			$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

			$pdf->SetXY(175, $height);
			$pdf->Cell(8,1,$tahun,$guideline,1,"L");
			//======================================================

			//NPWP PEMOTONG
			//======================================================
			$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
			$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
			$height = 253.8;

			$start_npwp_footer = 95;
			$space_npwp_footer = 5.4;
			$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
			$pdf->SetXY($start_npwp_footer, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME PEMOTONG
			//======================================================
			/*$name = strtoupper("$namaPemotong");
			$nameStart = 95;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 261.6);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}*/

			$name_PP = strtoupper($namaPemotong);
			$nameStart = 95;
			$nameSpace = 5.4;
			$name_PP_limit = 20;
			$height_name_PP = 261.6;
			$limit = min($name_PP_limit*2, strlen($name_PP));
			//print_r(strlen($name_PP)."-".$namaPemotong."-asaee");exit();
			for($i = 0; $i < $limit; $i++){
				$idx = $i;
				if($i >= $name_PP_limit){
					$idx = $i - $name_PP_limit;
					$height_name_PP = 269;
				}
				$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
				$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
/*
				$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP2);
				$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");*/
			}	
			//======================================================

			//TTD
			//======================================================
			/*if($signatureURL != "" && file_exists($signatureURL)){
				$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);	
				$pdf->Image($signatureURL,128,281,0,20,$ext);
			}
			$pdf->SetXY(120, 297.5);
			$pdf->Cell(56,1,strtoupper($namaTTD),$guideline,1,"C");
			
			$pdf->SetXY(120, 301.5);
			$pdf->Cell(56,1,strtoupper($jabTTD),$guideline,1,"C");*/

			if(file_exists($signatureURL)){
				$pdf->Image($signatureURL,128,281,0,20,$ext);

				$pdf->SetXY(120, 297.5);
				$pdf->Cell(56,1,strtoupper($namaTTD),$guideline,1,"C");
				
				$pdf->SetXY(120, 301.5);
				$pdf->Cell(56,1,strtoupper($jabTTD),$guideline,1,"C");
			}
			//======================================================
		}

		$pdf->Output();
	}

	function cetakPPH26($bulan, $tahun, $pajak, $pembetulan, $nomorFaktur){ //g dipake
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$fh = 'assets/templates/2326/bupot-PPH-26.pdf';

		//GET DATA
		$data['pph'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$nomorFaktur);

		//COMPILE Data
		$arrayOfNoBuktiPotong = array();
		$arrData = array();
		foreach ($data['pph'] as $pph):
			$noBuktiPotong = $pph['NO_BUKTI_POTONG'];
			$npwp = $pph['NPWP'];
			if($noBuktiPotong == "")
				continue;
			$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
			if($idx == FALSE){
				array_push($arrayOfNoBuktiPotong,$noBuktiPotong);
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
				$arrData[$idx]['totalJasaLain'] = 0;
				$arrData[$idx]['total'] = 0;
			}
			$arrData[$idx]['textNo1'] = "";
			$arrData[$idx]['textNo2'] = $noBuktiPotong;
			$arrData[$idx]['npwp'] = $pph['NPWP'];
			$arrData[$idx]['namaWP'] = $pph['NAMA_WP'];
			$arrData[$idx]['addressWP'] = $pph['ALAMAT_WP'];
			$arrData[$idx]['lokasiPP'] = $pph['KOTA'];
			$arrData[$idx]['tanggalBuktiPotong'] = $pph['TGL_BUKTI_POTONG'];
			$arrData[$idx]['npwpPP'] = $pph['NPWP_PEMOTONG'];
			$arrData[$idx]['namaPP'] = $pph['NAMA_PEMOTONG'];

			$kodePajak = $pph['KODE_PAJAK'];
			if($kodePajak == "")
				continue;
			else if($kodePajak == "KP0 PSL23-01"){
				//$arrData[$idx]['dividenBruto'] = $pph['DPP'];
				//$arrData[$idx]['dividenTarif'] = $pph['TARIF'];
				//$arrData[$idx]['dividenJumlahPotong'] = $pph['JUMLAH_POTONG'];
				//$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
			}
			//......
		endforeach;

		foreach ($arrData as $datum){
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//======================================================
			$guideline = 0; //change to 1 to see field border for every parameter
			$textNo1 =  $datum['textNo1']; //Change this value from DB
			$textNo2 = $datum['textNo2']; //Change this value from DB for Number
			$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
			$name = $datum['namaWP']; //Change this value from DB for name
			$address = $datum['addressWP'];
			$Lokasi = $datum['lokasiPP'];
			$tanggalBulan = substr($datum['tanggalBuktiPotong'], 0, -2);
			$tahun = substr($datum['tanggalBuktiPotong'], -2); //YY
			$noNPWPPemotong = $datum['npwpPP'];
			$namaPemotong = $datum['namaPP'];

			$jpb_dividen = "";
			$tarif_dividen = "";
			$pph_dividen = "";

			$jpb_bunga = "";
			$tarif_bunga = "";
			$pph_bunga = "";

			$jpb_royalti = "";
			$tarif_royalti = "";
			$pph_royalti = "";

			$jpb_sewa = "";
			$tarif_sewa = "";
			$pph_sewa = "";

			$jpb_imbalan = "";
			$tarif_imbalan = "";
			$pph_imbalan = "";

			$jpb_hadiah = "";
			$tarif_hadiah = "";
			$pph_hadiah = "";

			$jpb_pensiun = "";
			$tarif_pensiun = "";
			$pph_pensiun = "";

			$jpb_premi = "";
			$tarif_premi = "";
			$pph_premi = "";

			$jpb_keuntungan = "";
			$tarif_keuntungan = "";
			$pph_keuntungan = "";

			$jpb_penjualan_harta = "";
			$tarif_penjualan_harta = "";
			$pph_penjualan_harta = "";
			$neto_penjualan_harta = "";

			$jpb_premi_asuransi = "";
			$tarif_premi_asuransi = "";
			$pph_premi_asuransi = "";
			$neto_premi_asuransi = "";

			$jpb_saham= "";
			$tarif_saham = "";
			$pph_saham = "";
			$neto_saham = "";

			$jpb_pajak_BUT = "";
			$tarif_pajak_BUT = "";
			$pph_pajak_BUT = "";

			$total = 0;
			$terbilang = $this->terbilang($total)." Rupiah";
			//======================================================

			//for Number 1
			//======================================================
			$pdf->SetXY(38, 35);
			$pdf->Cell(65,1,$textNo1,$guideline,1,"C");
			//======================================================

			//for Number 2
			//======================================================
			$pdf->SetXY(85, 50);
			$pdf->Cell(55,1,$textNo2,$guideline,1,"C");
			//======================================================

			//NPWP
			//======================================================
			$noNPWP = str_replace('.','',$noNPWP);
			$noNPWP = str_replace('-','',$noNPWP);
			$height = 59.8;
			$start_npwp_header = 46.4;
			$space_npwp_header = 5.4;

			$npwp1 = substr ( $noNPWP, 0, 1 );
			$pdf->SetXY($start_npwp_header, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWP, 1, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWP, 2, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWP, 3, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWP, 4, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWP, 5, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWP, 6, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWP, 7, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWP, 8, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWP, 9, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWP, 10, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWP, 11, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWP, 12, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWP, 13, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWP, 14, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME
			//======================================================
			$name = strtoupper($name);
			$nameStart = 46.4;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 66.4);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//ADDRESS
			//======================================================
			$address = strtoupper($address);
			$addressStart = 46.4;
			$addressSpace = 5.4;
			for($i = 0; $i < strlen($address); $i++){
				$pdf->SetXY($addressStart + ($addressSpace * $i), 73);
				$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//DIVIDEN
			//======================================================
			$height = 102.2;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_dividen,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_dividen,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_dividen,$guideline,1,"R");
			//======================================================

			//BUNGA
			//======================================================
			$height = 107.8;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_bunga,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_bunga,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_bunga,$guideline,1,"R");
			//======================================================

			//ROYALTI
			//======================================================
			$height = 113.4;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_royalti,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_royalti,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_royalti,$guideline,1,"R");
			//======================================================

			//SEWA
			//======================================================
			$height = 141.6;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_sewa,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_sewa,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_sewa,$guideline,1,"R");
			//======================================================

			//IMBALAN
			//======================================================
			$height = 152.8;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_imbalan,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_imbalan,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_imbalan,$guideline,1,"R");
			//======================================================

			//HADIAH
			//======================================================
			$height = 158.4;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_hadiah,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_hadiah,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_hadiah,$guideline,1,"R");
			//======================================================

			//PENSIUN
			//======================================================
			$height = 169.8;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_pensiun,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_pensiun,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_pensiun,$guideline,1,"R");
			//======================================================

			//PREMI
			//======================================================
			$height = 181;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_premi,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_premi,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_premi,$guideline,1,"R");
			//======================================================

			//KEUNTUNGAN
			//======================================================
			$height = 192.3;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_keuntungan,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_keuntungan, $guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_keuntungan,$guideline,1,"R");
			//======================================================

			//PENJUALAN HARTA
			//======================================================
			$height = 197.8;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_penjualan_harta,$guideline,1,"R");

			$pdf->SetXY(116.5, $height);
			$pdf->Cell(25,1,$neto_penjualan_harta,$guideline,1,"C");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_penjualan_harta, $guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_penjualan_harta,$guideline,1,"R");
			//======================================================

			//PREMI ASURANSI
			//======================================================
			$height = 203.4;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_premi_asuransi,$guideline,1,"R");

			$pdf->SetXY(116.5, $height);
			$pdf->Cell(25,1,$neto_premi_asuransi,$guideline,1,"C");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_premi_asuransi, $guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_premi_asuransi,$guideline,1,"R");
			//======================================================

			//SAHAM
			//======================================================
			$height = 214.8;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_saham,$guideline,1,"R");

			$pdf->SetXY(116.5, $height);
			$pdf->Cell(25,1,$neto_saham,$guideline,1,"C");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_saham, $guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_saham,$guideline,1,"R");
			//======================================================

			//PAJAK BUT
			//======================================================
			$height = 226;
			$pdf->SetXY(73.5, $height);
			$pdf->Cell(41,1,$jpb_pajak_BUT,$guideline,1,"R");

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_pajak_BUT, $guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_pajak_BUT,$guideline,1,"R");
			//======================================================

			//JUMLAH
			//======================================================
			$height = 231.8;
			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$total, $guideline,1,"R");
			//======================================================

			//TERBILANG
			//======================================================
			$height = 237.8;
			$pdf->SetXY(30, $height);
			$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
			//======================================================

			//TANGGAL
			//======================================================
			$height = 244.6;
			$pdf->SetXY(107, $height);
			$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

			$pdf->SetXY(135, $height);
			$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

			$pdf->SetXY(165, $height);
			$pdf->Cell(8,1,$tahun,$guideline,1,"L");
			//======================================================

			//NPWP PEMOTONG
			//======================================================
			$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
			$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
			$height = 259.2;

			$start_npwp_footer = 95;
			$space_npwp_footer = 5.4;
			$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
			$pdf->SetXY($start_npwp_footer, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME PEMOTONG
			//======================================================
			$name = strtoupper($namaPemotong);
			$nameStart = 95;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 267);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//TTD
			//======================================================
			$pdf->SetXY(110, 296);
			$pdf->Cell(55,1,strtoupper($namaPemotong),$guideline,1,"C");
			//======================================================
		}

		$pdf->Output();
	}
		
	function cetakPPH22($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur){
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$fh = 'assets/templates/22/bupot-PPH-22.pdf';

		//GET DATA 
		$data['pph'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,$nomorFaktur,"BUKTI POTONG");

		//COMPILE Data
		$arrayOfNoBuktiPotong = array();
		$arrData = array();
		foreach ($data['pph'] as $pph):
			$noBuktiPotong 	= $pph['NO_BUKTI_POTONG'];
			$npwp 			= $pph['NPWP'];
			$nmkpp 			= ($pph['NAMA_KPP'])?strtoupper($pph['NAMA_KPP']):'';
			if($noBuktiPotong == "")
				continue;
			$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
			if($idx == FALSE){
				array_push($arrayOfNoBuktiPotong,$noBuktiPotong);
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
				$arrData[$idx]['TotalPajak'] = 0;
				$arrData[$idx]['total'] = 0;
				$arrData[$idx]['hargaBUMN'] = 0;
				$arrData[$idx]['pajakBUMN'] = 0;
			}
			$arrData[$idx]['textNo1']            = $nmkpp;
			$arrData[$idx]['textNo2']            = $noBuktiPotong;
			$arrData[$idx]['npwp']               = $pph['NPWP'];
			$arrData[$idx]['namaWP']             = substr($pph['NAMA_WP'],0,29);
			$arrData[$idx]['addressWP']          = substr($pph['ALAMAT_WP'],0,29);
			$arrData[$idx]['lokasiPP']           = $pph['KOTA'];
			$arrData[$idx]['tanggalBuktiPotong'] = $pph['TGL_BUKTI_POTONG'];
			$arrData[$idx]['npwpPP']             = $pph['NPWPPP'];
			$arrData[$idx]['namaPP']             = substr($pph['NAMAPP'],0,40);
			//$arrData[$idx]['namattd']          = $pph['NAMA_PETUGAS_PENANDATANGAN']." (".$pph['JABATAN_PETUGAS_PENANDATANGAN'].")";
			$arrData[$idx]['namattd']            = $pph['NAMA_PETUGAS_PENANDATANGAN'];
			$arrData[$idx]['jabttd']             = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
			$arrData[$idx]['signature']          = $pph['URL_TANDA_TANGAN'];

			$kodePajak = $pph['KODE_PAJAK'];

			$arrData[$idx]['TotalPajak'] += $pph['JUMLAH_POTONG'];
			$arrData[$idx]['total'] += $pph['DPP'];
			$arrData[$idx]['hargaBUMN'] += $pph['DPP'];
			$arrData[$idx]['pajakBUMN'] += $pph['JUMLAH_POTONG'];
			$arrData[$idx]['tarifBUMN'] = $pph['TARIF'];

		endforeach;
		
		foreach ($arrData as $datum){
			$pdf->AddPage(); //new page
			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//PARAMETER
			//======================================================
			$guideline = 0; //change to 1 to see field border for every parameter
			$textNo1 =  $datum['textNo1']; //Change this value from DB
			$textNo2 = $datum['textNo2']; //Change this value from DB for Number
			$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
			$name = $datum['namaWP']; //Change this value from DB for name
			$address = $datum['addressWP'];
			$Lokasi = $datum['lokasiPP'];
			$tanggalBulan = substr($datum['tanggalBuktiPotong'], 0, -2);
			$tahun = substr($datum['tanggalBuktiPotong'], -2); //YY
			$noNPWPPemotong =$datum['npwpPP'];
			$namaPemotong = $datum['namaPP'];
			$namaTTD = $datum['namattd'];
			$jabTTD = $datum['jabttd'];
			$signatureURL = $datum['signature'];

			$harga_semen = "";
			$nonnpwp_semen = FALSE;
			$tarif_semen = "";
			$pph_semen = "";

			$harga_kertas = "";
			$nonnpwp_kertas = FALSE;
			$tarif_kertas = "";
			$pph_kertas = "";

			$harga_baja = "";
			$nonnpwp_baja = FALSE;
			$tarif_baja = "";
			$pph_baja = "";

			$harga_otomotif = "";
			$nonnpwp_otomotif = FALSE;
			$tarif_otomotif ="";
			$pph_otomotif = "";

			$nama_industri1 = "";
			$harga_industri1 = "";
			$nonnpwp_industri1 = FALSE;
			$tarif_industri1 = "";
			$pph_industri1 = "";

			$nama_industri2 = "";
			$harga_industri2 = "";
			$nonnpwp_industri2 = FALSE;
			$tarif_industri2 = "";
			$pph_industri2 = "";

			$nama_sangat_mewah="";
			$harga_sangat_mewah ="";
			$nonnpwp_sangat_mewah = FALSE;
			$tarif_sangat_mewah = "";
			$pph_sangat_mewah = "";

			$nama_sektor1= "";
			$harga_sektor1 = "";
			$nonnpwp_sektor1 = FALSE;
			$tarif_sektor1 = "";
			$pph_sektor1 ="";

			$nama_sektor2= "";
			$harga_sektor2 = "";
			$nonnpwp_sektor2 = FALSE;
			$tarif_sektor2 = "";
			$pph_sektor2 = "";

			$nama_badan_lainnya1= "BUMN Tertentu";
			$harga_badan_lainnya1 = (isset($datum['hargaBUMN'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['hargaBUMN'],0,'.','.')) : "";
			$nonnpwp_badan_lainnya1 = ($noNPWP == "") ? TRUE : FALSE;
			$tarif_badan_lainnya1 = $datum['tarifBUMN']."%";
			$pph_badan_lainnya1 = (isset($datum['pajakBUMN'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['pajakBUMN'],0,'.','.')) : "";

			$nama_badan_lainnya2= "";
			$harga_badan_lainnya2 = "";
			$nonnpwp_badan_lainnya2 = FALSE;
			$tarif_badan_lainnya2 = "";
			$pph_badan_lainnya2 = "";

			$total_bruto = (isset($datum['total'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['total'],0,'.','.')) : "";
			$total = (isset($datum['TotalPajak'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['TotalPajak'],0,'.','.')) : "";
			$terbilang = $this->terbilang($datum['TotalPajak'])." Rupiah";
			//======================================================

			//for Number 1
			//======================================================
			$pdf->SetXY(38, 34);
			$pdf->Cell(60,1,$textNo1,$guideline,1,"C");
			//======================================================

			//for Number 2
			//======================================================
			$pdf->SetXY(84, 56.5);
			$pdf->Cell(60,1,$textNo2,$guideline,1,"C");
			//======================================================

			//NPWP
			//======================================================
			$noNPWP = str_replace('.','',$noNPWP);
			$noNPWP = str_replace('-','',$noNPWP);
			$height = 67.2;
			$start_npwp_header = 46.4;
			$space_npwp_header = 5.415;

			$npwp1 = substr ( $noNPWP, 0, 1 );
			$pdf->SetXY($start_npwp_header, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWP, 1, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWP, 2, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWP, 3, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWP, 4, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWP, 5, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWP, 6, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWP, 7, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWP, 8, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWP, 9, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWP, 10, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWP, 11, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWP, 12, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWP, 13, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWP, 14, 1 );
			$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME
			//======================================================
			$name = strtoupper($name);
			$nameStart = 46.4;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 74.8);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//ADDRESS
			//======================================================
			$address = strtoupper($address);
			$addressStart = 46.4;
			$addressSpace = 5.4;
			for($i = 0; $i < strlen($address); $i++){
				$pdf->SetXY($addressStart + ($addressSpace * $i), 82.5);
				$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
			}
			//======================================================

			//SEMEN
			//======================================================
			$height = 124.5;
			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_semen,$guideline,1,"R");

			if($nonnpwp_semen){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_semen,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_semen,$guideline,1,"R");
			//======================================================

			//KERTAS
			//======================================================
			$height = 130;
			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_kertas,$guideline,1,"R");

			if($nonnpwp_kertas){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_kertas,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_kertas,$guideline,1,"R");
			//======================================================

			//BAJA
			//======================================================
			$height = 135.7;
			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_baja,$guideline,1,"R");

			if($nonnpwp_baja){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_baja,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_baja,$guideline,1,"R");
			//======================================================

			//OTOMOTIF
			//======================================================
			$height = 141.2;
			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_otomotif,$guideline,1,"R");

			if($nonnpwp_otomotif){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_otomotif,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_otomotif,$guideline,1,"R");
			//======================================================

			//INDUSTRI 1
			//======================================================
			$height = 146.8;

			$pdf->SetXY(20, $height);
			$pdf->Cell(46.5,1,$nama_industri1,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_industri1,$guideline,1,"R");

			if($nonnpwp_industri1){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_industri1,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_industri1,$guideline,1,"R");
			//======================================================

			//INDUSTRI 2
			//======================================================
			$height = 152.6;

			$pdf->SetXY(20, $height);
			$pdf->Cell(46.5,1,$nama_industri2,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_industri2,$guideline,1,"R");

			if($nonnpwp_industri2){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_industri2,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_industri2,$guideline,1,"R");
			//======================================================

			//IMEWAH
			//======================================================
			$height = 169.6;

			$pdf->SetXY(20, $height);
			$pdf->Cell(46.5,1,$nama_sangat_mewah,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_sangat_mewah,$guideline,1,"R");

			if($nonnpwp_sangat_mewah){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_sangat_mewah,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_sangat_mewah,$guideline,1,"R");
			//======================================================

			//SEKTOR 1
			//======================================================
			$height = 180.8;

			$pdf->SetXY(35, $height);
			$pdf->Cell(35,1,$nama_sektor1,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_sektor1,$guideline,1,"R");

			if($nonnpwp_sektor1){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_sektor1,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_sektor1,$guideline,1,"R");
			//======================================================

			//SEKTOR 2
			//======================================================
			$height = 186.5;

			$pdf->SetXY(35, $height);
			$pdf->Cell(35,1,$nama_sektor2,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_sektor2,$guideline,1,"R");

			if($nonnpwp_sektor2){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_sektor2,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_sektor2,$guideline,1,"R");
			//======================================================

			//LAINNYA 1
			//======================================================
			$height = 197.7;

			$pdf->SetXY(20, $height);
			$pdf->Cell(46.5,1,$nama_badan_lainnya1,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_badan_lainnya1,$guideline,1,"R");

			if($nonnpwp_badan_lainnya1){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_badan_lainnya1,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_badan_lainnya1,$guideline,1,"R");
			//======================================================

			//LAINNYA 2
			//======================================================
			$height = 203.2;

			$pdf->SetXY(20, $height);
			$pdf->Cell(46.5,1,$nama_badan_lainnya2,$guideline,1,"L");

			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$harga_badan_lainnya2,$guideline,1,"R");

			if($nonnpwp_badan_lainnya2){
				$pdf->SetXY(132.5, $height);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$pdf->SetXY(144, $height);
			$pdf->Cell(14,1,$tarif_badan_lainnya2,$guideline,1,"C");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$pph_badan_lainnya2,$guideline,1,"R");
			//======================================================

			//JUMLAH
			//======================================================
			$height = 209.1;
			$pdf->SetXY(79, $height);
			$pdf->Cell(46.5,1,$total_bruto, $guideline,1,"R");

			$pdf->SetXY(160, $height);
			$pdf->Cell(41,1,$total, $guideline,1,"R");
			//======================================================

			//TERBILANG
			//======================================================
			$height = 214.5;
			$pdf->SetXY(28, $height);
			$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
			//======================================================

			//TANGGAL
			//======================================================
			$height = 225.5;
			$pdf->SetXY(117, $height);
			$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

			$pdf->SetXY(140, $height);
			$pdf->Cell(28,1,$tanggalBulan,$guideline,1,"R");

			$pdf->SetXY(176, $height);
			$pdf->Cell(8,1,$tahun,$guideline,1,"L");
			//======================================================

			//NPWP PEMOTONG
			//======================================================
			$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
			$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
			$height = 245;
			$start_npwp_footer = 94.9;
			$space_npwp_footer = 5.415;
			$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
			$pdf->SetXY($start_npwp_footer, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//NAME PEMOTONG
			//======================================================
			/*$name = strtoupper($namaPemotong);
			$nameStart = 94.9;
			$nameSpace = 5.4;
			for($i = 0; $i < strlen($name); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 253);
				$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
			}
*/
			$name_PP = strtoupper($namaPemotong);
			$nameStart = 95;
			$nameSpace = 5.4;
			$name_PP_limit = 20;
			$height_name_PP = 253;
			$limit = min($name_PP_limit*2, strlen($name_PP));
			//print_r(strlen($name_PP)."-".$namaPemotong."-asaee");exit();
			for($i = 0; $i < $limit; $i++){
				$idx = $i;
				if($i >= $name_PP_limit){
					$idx = $i - $name_PP_limit;
					$height_name_PP = 260;
				}
				$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
				$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
/*
				$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP2);
				$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");*/
			}	
			//======================================================

			//TTD
			//======================================================
			if($signatureURL != ""){
				$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);	
				$pdf->Image($signatureURL,130,270,0,20,$ext);
			}
			$pdf->SetXY(120, 288);
			$pdf->Cell(56,1,strtoupper($namaTTD),$guideline,1,"C");
			
			$pdf->SetXY(120, 292.5);
			$pdf->Cell(56,1,strtoupper($jabTTD),$guideline,1,"C");
			//======================================================

		}

		$pdf->Output();
	}
	
	function cetakPPH4Ayat2($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur){

			//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
			//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
			$pdf = new FPDI('Portrait','mm',array(210,330));

			//GET DATA
			$data['pph'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,$nomorFaktur,"BUKTI POTONG");

			//COMPILE Data
			$arrayOfNoBuktiPotong = array();
			$arrData = array();
			foreach ($data['pph'] as $pph):				
				$noBuktiPotong 	= $pph['NO_BUKTI_POTONG'];
				$npwp 			= $pph['NPWP'];
				$nmkpp 			= ($pph['NAMA_KPP'])?strtoupper($pph['NAMA_KPP']):'';
				if($noBuktiPotong == "")
					continue;
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
				if($idx == FALSE){
					array_push($arrayOfNoBuktiPotong,$noBuktiPotong);
					$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
					$arrData[$idx]['totalJasaLain'] = 0;
					$arrData[$idx]['template1Total'] = 0;
					$arrData[$idx]['template5TotalBruto'] = 0;
					$arrData[$idx]['template5TotalPPH'] = 0;

					//untuk template 1
					$arrData[$idx]['sewaBrutoTemplate1-01'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate1-01'] = 0;
					$arrData[$idx]['sewaBrutoTemplate1-02'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate1-02'] = 0;

					//untuk template 5
					$arrData[$idx]['sewaBrutoTemplate5-03'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate5-03'] = 0;
					$arrData[$idx]['sewaBrutoTemplate5-04'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate5-04'] = 0;
					$arrData[$idx]['sewaBrutoTemplate5-05'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate5-05'] = 0;
					$arrData[$idx]['sewaBrutoTemplate5-06'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate5-06'] = 0;
					$arrData[$idx]['sewaBrutoTemplate5-07'] = 0;
					$arrData[$idx]['sewaJumlahPotongTemplate5-07'] = 0;

				}
				$arrData[$idx]['textNo1']            = $nmkpp;
				$arrData[$idx]['textNo2']            = $noBuktiPotong;
				$arrData[$idx]['npwp']               = $pph['NPWP'];
				$arrData[$idx]['namaWP']             = substr($pph['NAMA_WP'],0,29);
				$arrData[$idx]['addressWP']          = substr($pph['ALAMAT_WP'],0,29);
				$arrData[$idx]['lokasiPP']           = $pph['KOTA'];
				$arrData[$idx]['tanggalBuktiPotong'] = $pph['TGL_BUKTI_POTONG'];
				$arrData[$idx]['npwpPP']             = $pph['NPWPPP'];
				$arrData[$idx]['namaPP']             = substr($pph['NAMAPP'],0,39);
				//$arrData[$idx]['namattd']          = $pph['NAMA_PETUGAS_PENANDATANGAN']." (".$pph['JABATAN_PETUGAS_PENANDATANGAN'].")";
				$arrData[$idx]['namattd']            = $pph['NAMA_PETUGAS_PENANDATANGAN'];
				$arrData[$idx]['jabttd']             = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
				$arrData[$idx]['signature']          = $pph['URL_TANDA_TANGAN'];				

				$kodePajak = substr($pph['KODE_PAJAK'], -2);
				$arrData[$idx]['kodePajak']	= $kodePajak;
				if($kodePajak == "")
					continue;
				else if($kodePajak == "01"){
					$arrData[$idx]['sewaBrutoTemplate1-01'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-01'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate1-01'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template1Total'] += $pph['JUMLAH_POTONG'];					
				}
				else if($kodePajak == "02"){
					$arrData[$idx]['sewaBrutoTemplate1-02'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-02'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate1-02'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template1Total'] += $pph['JUMLAH_POTONG'];
				}
				else if($kodePajak == "03"){
					$arrData[$idx]['sewaBrutoTemplate5-03'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-03'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate5-03'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template5TotalBruto'] += $pph['DPP'];
					$arrData[$idx]['template5TotalPPH'] += $pph['JUMLAH_POTONG'];
				}
				else if($kodePajak == "04"){
					$arrData[$idx]['sewaBrutoTemplate5-04'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-04'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate5-04'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template5TotalBruto'] += $pph['DPP'];
					$arrData[$idx]['template5TotalPPH'] += $pph['JUMLAH_POTONG'];
				}
				else if($kodePajak == "05"){
					$arrData[$idx]['sewaBrutoTemplate5-05'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-05'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate5-05'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template5TotalBruto'] += $pph['DPP'];
					$arrData[$idx]['template5TotalPPH'] += $pph['JUMLAH_POTONG'];
				}
				else if($kodePajak == "06"){
					$arrData[$idx]['sewaBrutoTemplate5-06'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-06'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate5-06'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template5TotalBruto'] += $pph['DPP'];
					$arrData[$idx]['template5TotalPPH'] += $pph['JUMLAH_POTONG'];
				}
				else if($kodePajak == "07"){
					$arrData[$idx]['sewaBrutoTemplate5-07'] += $pph['DPP'];
					$arrData[$idx]['sewaTarif-07'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotongTemplate5-07'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['template5TotalBruto'] += $pph['DPP'];
					$arrData[$idx]['template5TotalPPH'] += $pph['JUMLAH_POTONG'];
				}
			endforeach;

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//$template1 = TRUE;
			// $template2 = FALSE;
			// $template3 = FALSE;
			// $template4 = FALSE;
			//$template5 = TRUE;
			
			foreach ($arrData as $datum){
				$template1 = FALSE;
				$template2 = FALSE;
				$template3 = FALSE;
				$template4 = FALSE;
				$template5 = FALSE;
				//PARAMETER general
				//**********************************************************************
				$guideline = 0; //change to 1 to see field border for every parameter
				$textNo1 =  $datum['textNo1']; //Change this value from DB
				$textNo2 = $datum['textNo2']; //Change this value from DB for Number
				$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
				$name = substr($datum['namaWP'],0,29); //Change this value from DB for name
				$address = substr($datum['addressWP'],0,29);
				$lokasi_tanah = "";
				$Lokasi = $datum['lokasiPP'];
				$tanggalBulan = substr($datum['tanggalBuktiPotong'], 0, -2);
				$tahun = substr($datum['tanggalBuktiPotong'], -2); //YY
				$noNPWPPemotong = $datum['npwpPP'];				
				$namaPemotong = $datum['namaPP'];
				$namaTTD = $datum['namattd'];
				$jabTTD = $datum['jabttd'];
				$signatureURL = $datum['signature'];
				//**********************************************************************
				
				if($datum['kodePajak']=="01" || $datum['kodePajak']=="02"){
					$template1 = TRUE;
				} else {
					$template5 = TRUE;
				}
				
				if($template1){
					//TEMPLATE 1
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$fh = 'assets/templates/14-2/bupot-PPH-4-2-01-1row.pdf';
					$templatewith1row = TRUE;
					if((isset($datum['sewaJumlahPotongTemplate1-02'])) && $datum['sewaJumlahPotongTemplate1-02'] != 0){
						$fh = 'assets/templates/14-2/bupot-PPH-4-2-01.pdf';
						$templatewith1row = FALSE;
					}

					$pdf->AddPage(); //new page
					$pdf->setSourceFile($fh);
					$tplId = $pdf->importPage(1);
					$pdf->useTemplate($tplId);

					//PARAMETER
					//======================================================
					$bruto1 = (isset($datum['sewaBrutoTemplate1-01'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate1-01'],0,'.','.')) : "";
					$tarif1 = (isset($datum['sewaTarif-01'])) ? number_format($datum['sewaTarif-01'],0,'.','.')."%" : "";
					$pph1 = (isset($datum['sewaJumlahPotongTemplate1-01'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate1-01'],0,'.','.')) : "";

					$bruto2 = (isset($datum['sewaBrutoTemplate1-02'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate1-02'],0,'.','.')) : "";
					$tarif2 = (isset($datum['sewaTarif-02'])) ? number_format($datum['sewaTarif-02'],0,'.','.')."%" : "";
					$pph2 = (isset($datum['sewaJumlahPotongTemplate1-02'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate1-02'],0,'.','.')) : "";

					$terbilang = $this->terbilang($datum['template1Total'])." Rupiah";

					//======================================================

					//for Number 1
					//======================================================
					$pdf->SetXY(38, 35);
					$pdf->Cell(56,1,$textNo1,$guideline,1,"C");
					//======================================================

					//for Number 2
					//======================================================
					$pdf->SetXY(88, 62);
					$pdf->Cell(50,1,$textNo2,$guideline,1,"C");
					//======================================================

					//NPWP
					//======================================================
					$noNPWP = str_replace('.','',$noNPWP);
					$noNPWP = str_replace('-','',$noNPWP);
					$height = 74.6;
					$start_npwp_header = 46.5;
					$space_npwp_header = 5.4;

					$npwp1 = substr ( $noNPWP, 0, 1 );
					$pdf->SetXY($start_npwp_header, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWP, 1, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWP, 2, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWP, 3, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWP, 4, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWP, 5, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWP, 6, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWP, 7, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWP, 8, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWP, 9, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWP, 10, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWP, 11, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWP, 12, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWP, 13, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWP, 14, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAME
					//======================================================
					$name = strtoupper($name);
					$nameStart = 46.5;
					$nameSpace = 5.4;
					for($i = 0; $i < strlen($name); $i++){
						$pdf->SetXY($nameStart + ($nameSpace * $i), 81.4);
						$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//ADDRESS
					//======================================================
					$address = strtoupper($address);
					$addressStart = 46.5;
					$addressSpace = 5.4;
					for($i = 0; $i < strlen($address); $i++){
						$pdf->SetXY($addressStart + ($addressSpace * $i), 87.8);
						$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//LOKASI TANAH
					//======================================================
					$address_lokasi_tanah = strtoupper($lokasi_tanah);
					$addressStart = 46.5;
					$addressSpace = 5.4;
					$lokasi_tanah_limit = 28;
					$height_lokasi_tanah = 94.6;
					$limit = min($lokasi_tanah_limit*2, strlen($address_lokasi_tanah));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						if($i >= $lokasi_tanah_limit){
							$idx = $i - $lokasi_tanah_limit;
							$height_lokasi_tanah = 101;
						}
						$pdf->SetXY($addressStart + ($addressSpace * $idx), $height_lokasi_tanah);
						$pdf->Cell(4,1,substr ( $address_lokasi_tanah, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//DATA Row 1 KP0 PSL4(2)-01
					//======================================================
					$height = 130.8;
					$pdf->SetXY(10, $height);
					$pdf->Cell(77,1,$bruto1,$guideline,1,"R");


					$pdf->SetXY(90, $height);
					$pdf->Cell(30,1,$tarif1,$guideline,1,"C");


					$pdf->SetXY(123, $height);
					$pdf->Cell(77,1,$pph1,$guideline,1,"R");
					//======================================================

					//DATA Row 2 KP0 PSL4(2)-02
					//======================================================
					if(!$templatewith1row){
						$height = 136.6;
						$pdf->SetXY(10, $height);
						$pdf->Cell(77,1,$bruto2,$guideline,1,"R");


						$pdf->SetXY(90, $height);
						$pdf->Cell(30,1,$tarif2,$guideline,1,"C");


						$pdf->SetXY(123, $height);
						$pdf->Cell(77,1,$pph2,$guideline,1,"R");
					}
					//======================================================

					//TERBILANG
					//======================================================
					$height = 142;
					if($templatewith1row)
						$height = 136.6;
					$pdf->SetXY(30, $height);
					$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
					//======================================================

					//TANGGAL
					//======================================================
					$height = 153.8;
					$pdf->SetXY(117, $height);
					$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

					$pdf->SetXY(140, $height);
					$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

					$pdf->SetXY(175, $height);
					$pdf->Cell(8,1,$tahun,$guideline,1,"L");
					//======================================================

					//NPWP PEMOTONG
					//======================================================
					$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
					$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
					$height = 171;
					$start_npwp_footer = 95;
					$space_npwp_footer = 5.4;
					$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
					$pdf->SetXY($start_npwp_footer, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAMA PEMOTONG
					//======================================================
					$name_PP = strtoupper($namaPemotong);
					$nameStart = 95;
					$nameSpace = 5.4;
					$name_PP_limit = 20;
					$height_name_PP = 178;
					$limit = min($name_PP_limit*2, strlen($name_PP));
					//print_r(strlen($name_PP)."-".$namaPemotong."-asaee");exit();
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						if($i >= $name_PP_limit){
							$idx = $i - $name_PP_limit;
							$height_name_PP = 184.4;
						}
						$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
						$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
					}				
					//======================================================

					//TTD
					//======================================================
					if($signatureURL != ""){
						$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);	
						$pdf->Image($signatureURL,130,198,0,20,$ext);
					}
					$pdf->SetXY(118, 216);
					$pdf->Cell(58,1,strtoupper($namaTTD),$guideline,1,"C");
					
					$pdf->SetXY(118, 220);
					$pdf->Cell(58,1,strtoupper($jabTTD),$guideline,1,"C");
					//======================================================
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				}

				if($template2){
					//TEMPLATE 2
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$fh = 'assets/templates/14-2/bupot-PPH-4-2-02.pdf';
					$pdf->AddPage(); //new page
					$pdf->setSourceFile($fh);
					$tplId = $pdf->importPage(1);
					$pdf->useTemplate($tplId);

					//PARAMETER
					//======================================================
					$jenis_hadiah_1 = "Mobil";
					$bruto_hadiah_1  = 123123123;
					$tarif_hadiah_1  = 5;
					$pph_hadiah_1  = 12312;

					$jenis_hadiah_2 = "Motor";
					$bruto_hadiah_2  = 123123123;
					$tarif_hadiah_2  = 5;
					$pph_hadiah_2  = 12312;

					$jenis_hadiah_3 = "Rumah";
					$bruto_hadiah_3  = 123123123;
					$tarif_hadiah_3  = 5;
					$pph_hadiah_3  = 12312;

					$jenis_hadiah_4 = "Pesawat";
					$bruto_hadiah_4  = 123123123;
					$tarif_hadiah_4  = 5;
					$pph_hadiah_4  = 12312;

					$jenis_hadiah_5 = "Apartment";
					$bruto_hadiah_5  = 123123123;
					$tarif_hadiah_5  = 5;
					$pph_hadiah_5  = 12312;

					$jenis_hadiah_6 = "Kantor";
					$bruto_hadiah_6  = 123123123;
					$tarif_hadiah_6  = 5;
					$pph_hadiah_6  = 12312;

					$jumlah_bruto = 345345345;
					$jumlah_pph	=	2342342;

					$terbilang = $this->terbilang($jumlah_pph)." Rupiah";
					//======================================================

					//for Number 1
					//======================================================
					$pdf->SetXY(35, 34);
					$pdf->Cell(70,1,$textNo1,$guideline,1,"C");
					//======================================================

					//for Number 2
					//======================================================
					$pdf->SetXY(81, 55);
					$pdf->Cell(60,1,$textNo2,$guideline,1,"C");
					//======================================================

					//NPWP
					//======================================================
					$noNPWP = str_replace('.','',$noNPWP);
					$noNPWP = str_replace('-','',$noNPWP);
					$height = 66.6;
					$start_npwp_header = 46.4;
					$space_npwp_header = 5.4;

					$npwp1 = substr ( $noNPWP, 0, 1 );
					$pdf->SetXY($start_npwp_header, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWP, 1, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWP, 2, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWP, 3, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWP, 4, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWP, 5, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWP, 6, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWP, 7, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWP, 8, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWP, 9, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWP, 10, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWP, 11, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWP, 12, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWP, 13, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWP, 14, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAME
					//======================================================
					$name = strtoupper($name);
					$nameStart = 46.4;
					$nameSpace = 5.4;
					for($i = 0; $i < strlen($name); $i++){
						$pdf->SetXY($nameStart + ($nameSpace * $i), 73.4);
						$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//ADDRESS
					//======================================================
					$address = strtoupper($address);
					$addressStart = 46.4;
					$addressSpace = 5.4;
					for($i = 0; $i < strlen($address); $i++){
						$pdf->SetXY($addressStart + ($addressSpace * $i), 80);
						$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//HADIAH UNDIAN 1
					//======================================================
					$height = 109.8;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_1,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_1,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_1,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_1,$guideline,1,"R");
					//======================================================

					//HADIAH UNDIAN 2
					//======================================================
					$height = 115.6;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_2,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_2,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_2,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_2,$guideline,1,"R");
					//======================================================

					//HADIAH UNDIAN 3
					//======================================================
					$height = 121.2;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_3,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_3,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_3,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_3,$guideline,1,"R");
					//======================================================

					//HADIAH UNDIAN 4
					//======================================================
					$height = 126.6;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_4,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_4,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_4,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_4,$guideline,1,"R");
					//======================================================

					//HADIAH UNDIAN 5
					//======================================================
					$height = 132.4;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_5,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_5,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_5,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_5,$guideline,1,"R");
					//======================================================

					//HADIAH UNDIAN 6
					//======================================================
					$height = 138;
					$pdf->SetXY(20, $height);
					$pdf->Cell(56,1,$jenis_hadiah_6,$guideline,1,"L");

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$bruto_hadiah_6,$guideline,1,"R");

					/*
					$pdf->SetXY(135.5, $height);
					$pdf->Cell(15,1,$tarif_hadiah_6,$guideline,1,"C");
					*/

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$pph_hadiah_6,$guideline,1,"R");
					//======================================================

					//JUMLAH
					//======================================================
					$height = 143.6;

					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$jumlah_bruto,$guideline,1,"R");

					$pdf->SetXY(150, $height);
					$pdf->Cell(50,1,$jumlah_pph,$guideline,1,"R");
					//======================================================

					//TERBILANG
					//======================================================
					$height = 149.4;
					$pdf->SetXY(30, $height);
					$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
					//======================================================

					//TANGGAL
					//======================================================
					$height = 159;
					$pdf->SetXY(117, $height);
					$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

					$pdf->SetXY(140, $height);
					$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

					$pdf->SetXY(175, $height);
					$pdf->Cell(8,1,$tahun,$guideline,1,"L");
					//======================================================

					//NPWP PEMOTONG
					//======================================================
					$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
					$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
					$height = 179.4;
					$start_npwp_footer = 95;
					$space_npwp_footer = 5.4;
					$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
					$pdf->SetXY($start_npwp_footer, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAMA PEMOTONG
					//======================================================
					$name_PP = strtoupper($namaPemotong);
					$nameStart = 95;
					$nameSpace = 5.4;
					$name_PP_limit = 20;
					$height_name_PP = 186;
					$limit = min($name_PP_limit*2, strlen($name_PP));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						if($i >= $name_PP_limit){
							$idx = $i - $name_PP_limit;
							$height_name_PP = 192.6;
						}
						$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
						$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//TTD
					//======================================================
					if($signatureURL != ""){
						$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);	
						$pdf->Image($signatureURL,130,210,0,20,$ext);
					}
					$pdf->SetXY(120, 229);
					$pdf->Cell(58,1,strtoupper($namaTTD),$guideline,1,"C");
					
					$pdf->SetXY(120, 231);
					$pdf->Cell(58,1,strtoupper($jabTTD),$guideline,1,"C");
					//======================================================
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				}

				if($template3){
					//TEMPLATE 3
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$fh = 'assets/templates/14-2/bupot-PPH-4-2-03.pdf';
					$pdf->AddPage(); //new page
					$pdf->setSourceFile($fh);
					$tplId = $pdf->importPage(1);
					$pdf->useTemplate($tplId);

					//PARAMETER
					//======================================================
					$nilai_tansaksi_saham_pendiri = 123123123;
					$tarif_saham_pendiri = 5;
					$pph_saham_pendiri  = 12312;

					$nilai_tansaksi_saham_non_pendiri = 123123123;
					$tarif_saham_non_pendiri = 5;
					$pph_saham_non_pendiri  = 12312;

					$jumlah_bruto = 345345345;
					$jumlah_pph	=	2342342;

					$terbilang = $this->terbilang($jumlah_pph)." Rupiah";
					//======================================================

					//for Number 1
					//======================================================
					$pdf->SetXY(38, 34);
					$pdf->Cell(65,1,$textNo1,$guideline,1,"C");
					//======================================================

					//for Number 2
					//======================================================
					$pdf->SetXY(83, 62);
					$pdf->Cell(60,1,$textNo2,$guideline,1,"C");
					//======================================================

					//NPWP
					//======================================================
					$noNPWP = str_replace('.','',$noNPWP);
					$noNPWP = str_replace('-','',$noNPWP);
					$height = 73;
					$start_npwp_header = 46.5;
					$space_npwp_header = 5.4;

					$npwp1 = substr ( $noNPWP, 0, 1 );
					$pdf->SetXY($start_npwp_header, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWP, 1, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWP, 2, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWP, 3, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWP, 4, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWP, 5, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWP, 6, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWP, 7, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWP, 8, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWP, 9, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWP, 10, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWP, 11, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWP, 12, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWP, 13, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWP, 14, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAME
					//======================================================
					$name = strtoupper($name);
					$nameStart = 46.5;
					$nameSpace = 5.4;
					for($i = 0; $i < strlen($name); $i++){
						$pdf->SetXY($nameStart + ($nameSpace * $i), 79.8);
						$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//LOKASI TANAH
					//======================================================
					$address_lokasi_tanah = strtoupper($address);
					$addressStart = 46.5;
					$addressSpace = 5.4;
					$lokasi_tanah_limit = 29;
					$height_lokasi_tanah = 86.6;
					$limit = min($lokasi_tanah_limit*2, strlen($address_lokasi_tanah));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						if($i >= $lokasi_tanah_limit){
							$idx = $i - $lokasi_tanah_limit;
							$height_lokasi_tanah = 93;
						}
						$pdf->SetXY($addressStart + ($addressSpace * $idx), $height_lokasi_tanah);
						$pdf->Cell(4,1,substr ( $address_lokasi_tanah, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//SAHAM PENDIRI
					//======================================================
					$height = 121.6;
					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$nilai_tansaksi_saham_pendiri,$guideline,1,"R");

					/*
					$pdf->SetXY(136.5, $height);
					$pdf->Cell(14,1,$tarif_saham_pendiri,$guideline,1,"C");
					*/

					$pdf->SetXY(149, $height);
					$pdf->Cell(52,1,$pph_saham_pendiri,$guideline,1,"R");
					//======================================================

					//SAHAM NON PENDIRI
					//======================================================
					$height = 127;
					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$nilai_tansaksi_saham_non_pendiri,$guideline,1,"R");

					/*
					$pdf->SetXY(136.5, $height);
					$pdf->Cell(14,1,$tarif_saham_non_pendiri,$guideline,1,"C");
					*/

					$pdf->SetXY(149, $height);
					$pdf->Cell(52,1,$pph_saham_non_pendiri,$guideline,1,"R");
					//======================================================

					//JUMLAH
					//======================================================
					$height = 132.6;
					$pdf->SetXY(79, $height);
					$pdf->Cell(52,1,$jumlah_bruto,$guideline,1,"R");

					$pdf->SetXY(149, $height);
					$pdf->Cell(52,1,$jumlah_pph,$guideline,1,"R");
					//======================================================

					//TERBILANG
					//======================================================
					$height = 138;
					$pdf->SetXY(30, $height);
					$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
					//======================================================

					//TANGGAL
					//======================================================
					$height = 149.6;
					$pdf->SetXY(117, $height);
					$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

					$pdf->SetXY(140, $height);
					$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

					$pdf->SetXY(175, $height);
					$pdf->Cell(8,1,$tahun,$guideline,1,"L");
					//======================================================

					//NPWP PEMOTONG
					//======================================================
					$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
					$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
					$height = 172.2;
					$start_npwp_footer = 95;
					$space_npwp_footer = 5.4;
					$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
					$pdf->SetXY($start_npwp_footer, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAMA PEMOTONG
					//======================================================
					$name_PP = strtoupper($namaPemotong);
					$nameStart = 95;
					$nameSpace = 5.4;
					$name_PP_limit = 20;
					$height_name_PP = 181;
					$limit = min($name_PP_limit, strlen($name_PP));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
						$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//TTD
					//======================================================
					$pdf->SetXY(118, 217);
					$pdf->Cell(60,1,strtoupper($namaPemotong),$guideline,1,"C");
					//======================================================

					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				}

				if($template4){
					//TEMPLATE 4
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$fh = 'assets/templates/14-2/bupot-PPH-4-2-04.pdf';
					$pdf->AddPage(); //new page
					$pdf->setSourceFile($fh);
					$tplId = $pdf->importPage(1);
					$pdf->useTemplate($tplId);

					//PARAMETER
					//======================================================
					$bruto_rupiah = 123123123;
					$tarif_rupiah = 5;
					$pph_rupiah = 12312;
					$dnln_rupiah = "DN";

					$bruto_asing_dengan_premi_fw = 123123123;
					$tarif_asing_dengan_premi_fw  = 5;
					$pph_asing_dengan_premi_fw  = 12312;
					$dnln_asing_dengan_premi_fw = "DN";

					$bruto_asing_non_premi_fw = 123123123;
					$tarif_asing_non_premi_fw  = 5;
					$pph_asing_non_premi_fw  = 12312;
					$dnln_asing_non_premi_fw  = "LN";

					$bruto_deposito = 123123123;
					$tarif_deposito = 5;
					$pph_deposito = 12312;
					$dnln_deposito = "DN";

					$bruto_tabungan = 123123123;
					$tarif_tabungan = 5;
					$pph_tabungan = 12312;
					$dnln_tabungan = "DN";

					$bruto_bi = 123123123;
					$tarif_bi = 5;
					$pph_bi = 12312;

					$bruto_giro = 123123123;
					$tarif_giro = 5;
					$pph_giro = 12312;

					$jenis_lainnya = "Jasa lainnya";
					$bruto_lainnya = 123123123;
					$tarif_lainnya = 5;
					$pph_lainnya = 12312;

					$bruto_total = 123123123;
					$pph_total = 12312;

					$terbilang = $this->terbilang($pph)." Rupiah";
					//======================================================

					//for Number 1
					//======================================================
					$pdf->SetXY(38, 36.5);
					$pdf->Cell(56,1,$textNo1,$guideline,1,"C");
					//======================================================

					//for Number 2
					//======================================================
					$pdf->SetXY(88, 57);
					$pdf->Cell(50,1,$textNo2,$guideline,1,"C");
					//======================================================

					//NPWP
					//======================================================
					$noNPWP = str_replace('.','',$noNPWP);
					$noNPWP = str_replace('-','',$noNPWP);
					$height = 66.8;
					$start_npwp_header = 51.8;
					$space_npwp_header = 5.4;

					$npwp1 = substr ( $noNPWP, 0, 1 );
					$pdf->SetXY($start_npwp_header, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWP, 1, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWP, 2, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWP, 3, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWP, 4, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWP, 5, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWP, 6, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWP, 7, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWP, 8, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWP, 9, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWP, 10, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWP, 11, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWP, 12, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWP, 13, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWP, 14, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAME
					//======================================================
					$name = strtoupper($name);
					$nameStart = 51.8;
					$nameSpace = 5.4;
					for($i = 0; $i < strlen($name); $i++){
						$pdf->SetXY($nameStart + ($nameSpace * $i), 74.2);
						$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//ADDRESS
					//======================================================
					$address = strtoupper($address);
					$addressStart = 51.8;
					$addressSpace = 5.4;
					for($i = 0; $i < strlen($address); $i++){
						$pdf->SetXY($addressStart + ($addressSpace * $i), 82);
						$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//rupiah
					//======================================================
					$height = 116;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_rupiah,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_rupiah,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_rupiah,$guideline,1,"R");

					$pdf->SetXY(187, $height);
					$pdf->Cell(14,1,$dnln_rupiah,$guideline,1,"C");
					//======================================================

					//premi
					//======================================================
					$height = 127.2;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_asing_dengan_premi_fw,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_asing_dengan_premi_fw,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_asing_dengan_premi_fw,$guideline,1,"R");

					$pdf->SetXY(187, $height);
					$pdf->Cell(14,1,$dnln_asing_dengan_premi_fw,$guideline,1,"C");
					//======================================================

					//non premi
					//======================================================
					$height = 138.6;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_asing_non_premi_fw,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_asing_non_premi_fw,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_asing_non_premi_fw,$guideline,1,"R");

					$pdf->SetXY(187, $height);
					$pdf->Cell(14,1,$dnln_asing_non_premi_fw,$guideline,1,"C");
					//======================================================

					//deposito
					//======================================================
					$height = 144;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_deposito,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_deposito,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_deposito,$guideline,1,"R");

					$pdf->SetXY(187, $height);
					$pdf->Cell(14,1,$dnln_deposito,$guideline,1,"C");
					//======================================================

					//tabungan
					//======================================================
					$height = 149.8;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_tabungan,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_tabungan,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_tabungan,$guideline,1,"R");

					$pdf->SetXY(187, $height);
					$pdf->Cell(14,1,$dnln_tabungan,$guideline,1,"C");
					//======================================================

					//bi
					//======================================================
					$height = 155.6;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_bi,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_bi,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_bi,$guideline,1,"R");
					//======================================================

					//giro
					//======================================================
					$height = 161;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_giro,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_giro,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_giro,$guideline,1,"R");
					//======================================================

					//lainnya
					//======================================================
					$height = 166.5;

					$pdf->SetXY(20, $height);
					$pdf->Cell(47,1,$jenis_lainnya,$guideline,1,"L");

					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_lainnya,$guideline,1,"R");

					$pdf->SetXY(122.5, $height);
					$pdf->Cell(14,1,$tarif_lainnya,$guideline,1,"C");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_lainnya,$guideline,1,"R");
					//======================================================

					//JUMLAH
					//======================================================
					$height = 172.2;
					$pdf->SetXY(74, $height);
					$pdf->Cell(46,1,$bruto_total,$guideline,1,"R");

					$pdf->SetXY(138.5, $height);
					$pdf->Cell(46,1,$pph_total,$guideline,1,"R");
					//======================================================

					//TERBILANG
					//======================================================
					$height = 178;
					$pdf->SetXY(30, $height);
					$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
					//======================================================

					//TANGGAL
					//======================================================
					$height = 188.8;
					$pdf->SetXY(117, $height);
					$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

					$pdf->SetXY(140, $height);
					$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

					$pdf->SetXY(175, $height);
					$pdf->Cell(8,1,$tahun,$guideline,1,"L");
					//======================================================

					//NPWP PEMOTONG
					//======================================================
					$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
					$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
					$height = 204.6;
					$start_npwp_footer = 95;
					$space_npwp_footer = 5.4;
					$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
					$pdf->SetXY($start_npwp_footer, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAMA PEMOTONG
					//======================================================
					$name_PP = strtoupper($namaPemotong);
					$nameStart = 95;
					$nameSpace = 5.4;
					$name_PP_limit = 20;
					$height_name_PP = 212.2;
					$limit = min($name_PP_limit, strlen($name_PP));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
						$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//TTD
					//======================================================
					$pdf->SetXY(121, 245);
					$pdf->Cell(56,1,strtoupper($namaPemotong),$guideline,1,"C");
					//======================================================
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				}

				if($template5){
					//TEMPLATE 5
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$fh = 'assets/templates/14-2/bupot-PPH-4-2-05.pdf';
					$pdf->AddPage(); //new page
					$pdf->setSourceFile($fh);
					$tplId = $pdf->importPage(1);
					$pdf->useTemplate($tplId);

					//PARAMETER
					//======================================================
					$bruto_konstruksi_kualifikasi_kecil = (isset($datum['sewaBrutoTemplate5-03'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate5-03'],0,'.','.')) : "";
					$tarif_konstruksi_kualifikasi_kecil = (isset($datum['sewaTarif-03'])) ? number_format($datum['sewaTarif-03'],0,'.','.')."%" : "";
					$pph_konstruksi_kualifikasi_kecil = (isset($datum['sewaJumlahPotongTemplate5-03'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate5-03'],0,'.','.')) : "";

					$bruto_konstruksi_non_kualifikasi = (isset($datum['sewaBrutoTemplate5-04'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate5-04'],0,'.','.')) : "";
					$tarif_konstruksi_non_kualifikasi = (isset($datum['sewaTarif-04'])) ? number_format($datum['sewaTarif-04'],0,'.','.')."%" : "";
					$pph_konstruksi_non_kualifikasi = (isset($datum['sewaJumlahPotongTemplate5-04'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate5-04'],0,'.','.')) : "";

					$bruto_konstruksi_lainnya = (isset($datum['sewaBrutoTemplate5-05'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate5-05'],0,'.','.')) : "";
					$tarif_konstruksi_lainnya = (isset($datum['sewaTarif-05'])) ? number_format($datum['sewaTarif-05'],0,'.','.')."%" : "";
					$pph_konstruksi_lainnya = (isset($datum['sewaJumlahPotongTemplate5-05'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate5-05'],0,'.','.')) : "";

					$bruto_perencanaan_konstruksi_kualifikasi_kecil = (isset($datum['sewaBrutoTemplate5-06'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate5-06'],0,'.','.')) : "";
					$tarif_perencanaan_konstruksi_kualifikasi_kecil = (isset($datum['sewaTarif-06'])) ? number_format($datum['sewaTarif-06'],0,'.','.')."%" : "";
					$pph_perencanaan_konstruksi_kualifikasi_kecil = (isset($datum['sewaJumlahPotongTemplate5-06'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate5-06'],0,'.','.')) : "";

					$bruto_perencanaan_konstruksi_non_kualifikasi = (isset($datum['sewaBrutoTemplate5-07'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaBrutoTemplate5-07'],0,'.','.')) : "";
					$tarif_perencanaan_konstruksi_non_kualifikasi = (isset($datum['sewaTarif-07'])) ? number_format($datum['sewaTarif-07'],0,'.','.')."%" : "";
					$pph_perencanaan_konstruksi_non_kualifikasi = (isset($datum['sewaJumlahPotongTemplate5-07'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['sewaJumlahPotongTemplate5-07'],0,'.','.')) : "";

					$jumlah_bruto = (isset($datum['template5TotalBruto'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['template5TotalBruto'],0,'.','.')) : "";
					$jumlah_pph	=	(isset($datum['template5TotalPPH'])) ? preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['template5TotalPPH'],0,'.','.')) : "";

					$terbilang = $this->terbilang($datum['template5TotalPPH'])." Rupiah";
					//======================================================

					//for Number 1
					//======================================================
					$pdf->SetXY(38, 34);
					$pdf->Cell(65,1,$textNo1,$guideline,1,"C");
					//======================================================

					//for Number 2
					//======================================================
					$pdf->SetXY(88, 55);
					$pdf->Cell(50,1,$textNo2,$guideline,1,"C");
					//======================================================

					//NPWP
					//======================================================
					$noNPWP = str_replace('.','',$noNPWP);
					$noNPWP = str_replace('-','',$noNPWP);
					$height = 66.6;
					$start_npwp_header = 46.4;
					$space_npwp_header = 5.4;

					$npwp1 = substr ( $noNPWP, 0, 1 );
					$pdf->SetXY($start_npwp_header, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWP, 1, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWP, 2, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWP, 3, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWP, 4, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWP, 5, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWP, 6, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWP, 7, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWP, 8, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWP, 9, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWP, 10, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWP, 11, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWP, 12, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWP, 13, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWP, 14, 1 );
					$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAME
					//======================================================
					$name = strtoupper($name);
					$nameStart = 46.4;
					$nameSpace = 5.4;
					for($i = 0; $i < strlen($name); $i++){
						$pdf->SetXY($nameStart + ($nameSpace * $i), 73.4);
						$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//ADDRESS
					//======================================================
					$address = strtoupper($address);
					$addressStart = 46.4;
					$addressSpace = 5.4;
					for($i = 0; $i < strlen($address); $i++){
						$pdf->SetXY($addressStart + ($addressSpace * $i), 80.6);
						$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//KONSTRUKSI KUALIFIKASI KECIL
					//======================================================
					$height = 115;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$bruto_konstruksi_kualifikasi_kecil,$guideline,1,"R");


					$pdf->SetXY(143, $height);
					$pdf->Cell(10,1,$tarif_konstruksi_kualifikasi_kecil,$guideline,1,"C");


					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$pph_konstruksi_kualifikasi_kecil,$guideline,1,"R");
					//======================================================

					//KONSTRUKSI NON KUALIFIKASI
					//======================================================
					$height = 126.4;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$bruto_konstruksi_non_kualifikasi,$guideline,1,"R");


					$pdf->SetXY(143, $height);
					$pdf->Cell(10,1,$tarif_konstruksi_non_kualifikasi,$guideline,1,"C");


					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$pph_konstruksi_non_kualifikasi,$guideline,1,"R");
					//======================================================

					//KONSTRUKSI KUALIFIKASI Lainnya
					//======================================================
					$height = 137.8;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$bruto_konstruksi_lainnya,$guideline,1,"R");


					$pdf->SetXY(143, $height);
					$pdf->Cell(10,1,$tarif_konstruksi_lainnya,$guideline,1,"C");


					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$pph_konstruksi_lainnya,$guideline,1,"R");
					//======================================================

					//PERENCANAAN KONSTRUKSI KUALIFIKASI KECIL
					//======================================================
					$height = 148.8;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$bruto_perencanaan_konstruksi_kualifikasi_kecil,$guideline,1,"R");


					$pdf->SetXY(143, $height);
					$pdf->Cell(10,1,$tarif_perencanaan_konstruksi_kualifikasi_kecil,$guideline,1,"C");


					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$pph_perencanaan_konstruksi_kualifikasi_kecil,$guideline,1,"R");
					//======================================================

					//PERENCANAAN KONSTRUKSI NON KUALIFIKASI
					//======================================================
					$height = 165.8;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$bruto_perencanaan_konstruksi_non_kualifikasi,$guideline,1,"R");


					$pdf->SetXY(143, $height);
					$pdf->Cell(10,1,$tarif_perencanaan_konstruksi_non_kualifikasi,$guideline,1,"C");


					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$pph_perencanaan_konstruksi_non_kualifikasi,$guideline,1,"R");
					//======================================================

					//JUMLAH
					//======================================================
					$height = 171.6;
					$pdf->SetXY(95.5, $height);
					$pdf->Cell(46,1,$jumlah_bruto,$guideline,1,"R");

					$pdf->SetXY(155, $height);
					$pdf->Cell(46,1,$jumlah_pph,$guideline,1,"R");
					//======================================================

					//TERBILANG
					//======================================================
					$height = 177.8;
					$pdf->SetXY(30, $height);
					$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
					//======================================================

					//TANGGAL
					//======================================================
					$height = 187;
					$pdf->SetXY(116, $height);
					$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

					$pdf->SetXY(140, $height);
					$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

					$pdf->SetXY(175, $height);
					$pdf->Cell(8,1,$tahun,$guideline,1,"L");
					//======================================================

					//NPWP PEMOTONG
					//======================================================
					$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
					$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
					$height = 207.2;
					$start_npwp_footer = 95;
					$space_npwp_footer = 5.4;
					$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
					$pdf->SetXY($start_npwp_footer, $height);
					$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

					$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
					$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

					$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
					$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

					$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
					$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

					$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
					$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

					$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
					$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

					$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
					$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

					$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
					$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

					$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
					$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

					$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
					$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

					$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
					$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

					$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
					$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

					$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
					$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

					$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
					$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

					$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
					$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
					$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
					//======================================================

					//NAMA PEMOTONG
					//======================================================
					$name_PP = strtoupper($namaPemotong);
					$nameStart = 95;
					$nameSpace = 5.4;
					$name_PP_limit = 20;
					$height_name_PP = 213.6;
					$limit = min($name_PP_limit*2, strlen($name_PP));
					for($i = 0; $i < $limit; $i++){
						$idx = $i;
						if($i >= $name_PP_limit){
							$idx = $i - $name_PP_limit;
							$height_name_PP = 219.8;
						}
						$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
						$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
					}
					//======================================================

					//TTD
					//======================================================
					if($signatureURL != ""){
						$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);	
						$pdf->Image($signatureURL,130,236,0,20,$ext);
					}
					$pdf->SetXY(121, 255);
					$pdf->Cell(58,1,strtoupper($namaTTD),$guideline,1,"C");
					$pdf->SetXY(121, 259.5);
					$pdf->Cell(58,1,strtoupper($jabTTD),$guideline,1,"C");
					//======================================================

					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				}

			}

			$pdf->Output();
	}

	function cetakPPH15($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang, $nomorFaktur){
		//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

			//GET DATA
			$data['pph'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,$nomorFaktur,"BUKTI POTONG");

			//COMPILE Data
			$arrayOfNoBuktiPotong = array();
			$arrData = array();
			foreach ($data['pph'] as $pph):
				$noBuktiPotong 	= $pph['NO_BUKTI_POTONG'];
				$npwp 			= $pph['NPWP'];
				$nmkpp 			= ($pph['NAMA_KPP'])?strtoupper($pph['NAMA_KPP']):'';
				if($noBuktiPotong == "")
					continue;
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
				if($idx == FALSE){
					array_push($arrayOfNoBuktiPotong,$noBuktiPotong);
					$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong);
					$arrData[$idx]['totalJasaLain'] = 0;
					$arrData[$idx]['total'] = 0;
					$arrData[$idx]['dividenBruto'] = 0;
					$arrData[$idx]['dividenJumlahPotong'] = 0;
					$arrData[$idx]['dividenTarif'] = 0;
				}
				$arrData[$idx]['textNo1']            = $nmkpp;
				$arrData[$idx]['textNo2']            = $noBuktiPotong;
				$arrData[$idx]['npwp']               = $pph['NPWP'];
				$arrData[$idx]['namaWP']             = substr($pph['NAMA_WP'],0,29);
				$arrData[$idx]['addressWP']          = substr($pph['ALAMAT_WP'],0,29);
				$arrData[$idx]['lokasiPP']           = $pph['KOTA'];
				$arrData[$idx]['lokasiTanah']        = "";
				$arrData[$idx]['tanggalBuktiPotong'] = $pph['TGL_BUKTI_POTONG'];
				$arrData[$idx]['npwpPP']             = $pph['NPWPPP'];
				$arrData[$idx]['namaPP']             = substr($pph['NAMAPP'],0,20);
				$arrData[$idx]['namattd']            = $pph['NAMA_PETUGAS_PENANDATANGAN'];
				$arrData[$idx]['jabttd']            = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
				$arrData[$idx]['signature']          = $pph['URL_TANDA_TANGAN'];

				$kodePajak = substr($pph['KODE_PAJAK'], -2);
				if($kodePajak == "")
					continue;
				else if($kodePajak == "01"){
					$arrData[$idx]['dividenBruto'] += $pph['DPP'];
					$arrData[$idx]['dividenTarif'] = $pph['TARIF'];
					$arrData[$idx]['dividenJumlahPotong'] += $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}
			endforeach;

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			foreach ($arrData as $datum){

				$fh = 'assets/templates/15/bupot-PPH-15.pdf';
				$pdf->AddPage(); //new page
				$pdf->setSourceFile($fh);
				$tplId = $pdf->importPage(1);
				$pdf->useTemplate($tplId);

				//PARAMETER
				//**********************************************************************
				$guideline = 0; //change to 1 to see field border for every parameter
				$textNo1 =  $datum['textNo1']; //Change this value from DB
				$textNo2 = $datum['textNo2']; //Change this value from DB for Number
				$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
				$name = $datum['namaWP']; //Change this value from DB for name
				$address = $datum['addressWP'];
				$lokasi_tanah = $datum['lokasiTanah'];
				$Lokasi = $datum['lokasiPP'];
				$tanggalBulan = substr($datum['tanggalBuktiPotong'], 0, -2);
				$tahun = substr($datum['tanggalBuktiPotong'], -2); //YY
				$noNPWPPemotong = $datum['npwpPP'];
				$namaPemotong = substr($datum['namaPP'],0,20);
				$namaTTD 	= $datum['namattd'];
				$jabTTD 	= $datum['jabttd'];
				$signatureURL = $datum['signature'];

				$bruto = preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['dividenBruto'],0,'.','.'));
				$tarif = preg_replace('/(-)([\d\.\,]+)/ui','($2)',$datum['dividenTarif'])."%";
				$pph = preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format($datum['dividenJumlahPotong'],0,'.','.'));

				$terbilang = $this->terbilang($datum['total'])." Rupiah";
				//**********************************************************************

				//for Number 1
				//======================================================
				$pdf->SetXY(38, 34);
				$pdf->Cell(56,1,$textNo1,$guideline,1,"C");
				//======================================================

				//for Number 2
				//======================================================
				$pdf->SetXY(88, 67);
				$pdf->Cell(50,1,$textNo2,$guideline,1,"C");
				//======================================================

				//NPWP
				//======================================================
				$noNPWP = str_replace('.','',$noNPWP);
				$noNPWP = str_replace('-','',$noNPWP);
				$height = 77.8;
				$start_npwp_header = 46.5;
				$space_npwp_header = 5.4;

				$npwp1 = substr ( $noNPWP, 0, 1 );
				$pdf->SetXY($start_npwp_header, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $noNPWP, 1, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*1), $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $noNPWP, 2, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*3), $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $noNPWP, 3, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*4), $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $noNPWP, 4, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*5), $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $noNPWP, 5, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*7), $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $noNPWP, 6, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*8), $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $noNPWP, 7, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*9), $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $noNPWP, 8, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*11), $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $noNPWP, 9, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*13), $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $noNPWP, 10, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*14), $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $noNPWP, 11, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*15), $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $noNPWP, 12, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*17), $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $noNPWP, 13, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*18), $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $noNPWP, 14, 1 );
				$pdf->SetXY($start_npwp_header+($space_npwp_header*19), $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//NAME
				//======================================================
				$name = strtoupper($name);
				$nameStart = 46.5;
				$nameSpace = 5.4;
				for($i = 0; $i < strlen($name); $i++){
					$pdf->SetXY($nameStart + ($nameSpace * $i), 85.4);
					$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//ADDRESS
				//======================================================
				$address = strtoupper($address);
				$addressStart = 46.5;
				$addressSpace = 5.4;
				for($i = 0; $i < strlen($address); $i++){
					$pdf->SetXY($addressStart + ($addressSpace * $i), 93);
					$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//DATA
				//======================================================
				$height = 121.6;
				$pdf->SetXY(10, $height);
				$pdf->Cell(77,1,$bruto,$guideline,1,"R");

				$pdf->SetXY(90, $height);
				$pdf->Cell(30,1,$tarif,$guideline,1,"C");

				$pdf->SetXY(123, $height);
				$pdf->Cell(78,1,$pph,$guideline,1,"R");
				//======================================================

				//TERBILANG
				//======================================================
				$height = 127;
				$pdf->SetXY(30, $height);
				$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
				//======================================================

				//TANGGAL
				//======================================================
				$height = 144.4;
				$pdf->SetXY(115, $height);
				$pdf->Cell(21,1,$Lokasi,$guideline,1,"R");

				$pdf->SetXY(140, $height);
				$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

				$pdf->SetXY(175, $height);
				$pdf->Cell(8,1,$tahun,$guideline,1,"L");
				//======================================================

				//NPWP PEMOTONG
				//======================================================
				$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
				$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
				$height = 159.6;
				$start_npwp_footer = 95;
				$space_npwp_footer = 5.4;
				$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
				$pdf->SetXY($start_npwp_footer, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//NAMA PEMOTONG
				//======================================================
				$name_PP = strtoupper($namaPemotong);
				$nameStart = 95;
				$nameSpace = 5.4;
				$name_PP_limit = 20;
				$height_name_PP = 166.6;
				$limit = min($name_PP_limit, strlen($name_PP));
				for($i = 0; $i < $limit; $i++){
					$idx = $i;
					$pdf->SetXY($nameStart + ($nameSpace * $idx), $height_name_PP);
					$pdf->Cell(4,1,substr ( $name_PP, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//TTD
				//======================================================
				if($signatureURL != ""){
					$ext  	= pathinfo($signatureURL, PATHINFO_EXTENSION);
					$pdf->Image($signatureURL,132,183,0,20,$ext);
				}
				$pdf->SetXY(120, 202.5);
				$pdf->Cell(58,1,strtoupper($namaTTD),$guideline,1,"C");
				
				$pdf->SetXY(120, 206.5);
				$pdf->Cell(58,1,strtoupper($jabTTD),$guideline,1,"C");
				//======================================================
			}

			$pdf->Output();
	}
	
	
	//+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*+*
	
	//Bukti Potong======================================== cek
	function cetakPphBuktiPotong(){
		require_once('vendor/autoload.php');

		//data from POST request
	$pajak       = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
    $bulan       = $_REQUEST['month'];
    $tahun       = $_REQUEST['year'];
    $pembetulan  = $_REQUEST['pembetulan'];
	$isCabang	 = $_REQUEST['isCabang'];
	$valCabang	 = FALSE;	
	if(isset($_REQUEST['valCabang']))
		$valCabang  = $_REQUEST['valCabang'];
		
		if($pajak == "PPH PSL 23 DAN 26"){
			$this->cetakDaftarBupot2326($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang);
		}
		else if($pajak == "PPH PSL 22"){
			$this->cetakDaftarBupot22($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang);
		}
		else if($pajak == "PPH PSL 4 AYAT 2"){
			$this->cetakDaftarBupot4Ayat2($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang);
		}
		else if($pajak == "PPH PSL 15"){
			$this->cetakDaftarBupot15($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang);
		}

	}
	
	function cetakDaftarBupot2326($bulan, $tahun, $pajak, $pembetulan, $isCabang,$valCabang){
		//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$fh = 'assets/templates/2326/daftar-bupot-PPH-23-26.pdf';
		$guideline = 0; //change to 1 to see field border for every parameter
		$arrData23 = array();
		$arrData26 = array();

		//FOOTER DATA [AMBIL DARI DB]
		$pemotongPajakPimpinan = TRUE;
		$kuasaWajibPajak = FALSE;
		$namaPP = "";
		$npwpPP = "";
		$tanggalPP = ""; //DDMMYYYY

		if($pajak == "PPH PSL 23" || $pajak == "PPH PSL 23 DAN 26"){
			//GET DATA
			$data['pph23'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,FALSE,"DAFTAR BUPOT");

			//COMPILE Data
			$arrayOfNoBuktiPotong23 = array();
			$totalDPPALL23 = 0;
			$totalPPALL23 = 0;
			foreach ($data['pph23'] as $pph):
				$noBuktiPotong = $pph['NO_BUKTI_POTONG'];
				$npwp = "";

				if($pph['NPWP'] != ""){
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "",$pph['NPWP']);
				$ilanginStrip = str_replace("-", "",$ilanginTitik);
				$npwp = substr($ilanginStrip,0,2).".".substr($ilanginStrip,2,3).".".substr($ilanginStrip,5,3).".".substr($ilanginStrip,8,1)."-".substr($ilanginStrip,9,3).".".substr($ilanginStrip,12,3);
				}

				$npwpPP = $pph['NPWP_PETUGAS'];
				$namaPP= substr($pph['NAMA_PETUGAS_PENANDATANGAN'],0,23);
				$namaTTD = $pph['NAMA_PETUGAS_PENANDATANGAN'];
				$petugasTTD = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
				$ttd = $pph['URL_TANDA_TANGAN'];				
				$tanggalPP =  date("dmY", strtotime($pph['TGL_APPROVE_SUP']));

				/*
				if($pph['NAMA_PEMOTONG'] != ""){
					$namaPP = $pph['NAMA_PEMOTONG'];
					$npwpPP = $pph['NPWP_PEMOTONG'];
					$tanggalPP = date("dmY", strtotime($pph['TGL_BUKTI_POTONG']));
				}
				*/

				if($noBuktiPotong == "")
					continue;
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong23);
				if($idx == FALSE){
					array_push($arrayOfNoBuktiPotong23,$noBuktiPotong);
					$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong23);
					
					if(!$pph['INVOICE_CURRENCY_CODE'] || $pph['INVOICE_RATE'] == ""){
						$arrData23[$idx]['totalJasaLain'] = 0;
						$arrData23[$idx]['totalDpp'] = 0;
						$arrData23[$idx]['totalPP'] = 0;
					} else {
					//26
						$arrData26[$idx]['totalJasaLain'] = 0;
						$arrData26[$idx]['totalDpp'] = 0;
						$arrData26[$idx]['totalPP'] = 0;
					}
				}
				
				if(!$pph['INVOICE_CURRENCY_CODE'] || $pph['INVOICE_RATE'] == ""){
					$arrData23[$idx]['bukti_potong'] = $noBuktiPotong;				
					$arrData23[$idx]['npwp'] = $npwp;
					$arrData23[$idx]['namaWP'] = $pph['NAMA_WP'];
					$arrData23[$idx]['tanggalBuktiPotong'] =  date("d/m/Y", strtotime($pph['TGL_BUKTI_POTONG']));
					$arrData23[$idx]['totalDpp'] += $pph['DPP'];
					$arrData23[$idx]['totalPP'] += $pph['JUMLAH_POTONG'];
					$arrData23[$idx]['mata_uang'] = $pph['INVOICE_CURRENCY_CODE'];
				} else {
					//26
					$arrData26[$idx]['bukti_potong'] = $noBuktiPotong;				
					$arrData26[$idx]['npwp'] = $npwp;
					$arrData26[$idx]['namaWP'] = $pph['NAMA_WP'];
					$arrData26[$idx]['tanggalBuktiPotong'] =  date("d/m/Y", strtotime($pph['TGL_BUKTI_POTONG']));
					$arrData26[$idx]['totalDpp'] += $pph['DPP'];
					$arrData26[$idx]['totalPP'] += $pph['JUMLAH_POTONG'];
					$arrData26[$idx]['mata_uang'] = $pph['INVOICE_CURRENCY_CODE'];
				}
			endforeach;

			//print_r($arrData23);
		}


			$limit23 = 20;
			$limit26 = 15;
			$rowPPH23Start = 65.7;
			$rowPPH26Start = 185.3;
			$rowPPHSpace = 5.1;
			$limit = max(ceil(count($arrData23)/$limit23),ceil(count($arrData26)/$limit26));
			//foreach ($arrData23 as $datum){

			//TANGGAL BERDASARKAN FILTER
			$_tanggalPPH = "";
			if(strlen($bulan) == 1)
				$_tanggalPPH = "0".$bulan." ".$tahun;
			else
				$_tanggalPPH = $bulan." ".$tahun;



			for($index = 0; $index < $limit; $index++){

				$pdf->AddPage(); //new page

				$pdf->setSourceFile($fh);
				$tplId = $pdf->importPage(1);
				$pdf->useTemplate($tplId);

				$pdf->SetTextColor(0,0,0); // RGB
				$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size

				//HEADER
				//======================================================================
				$tglStart = 164.4;
				$tglSpace = 4.85;
				for($i = 0; $i < strlen($_tanggalPPH); $i++){
					$pdf->SetXY($tglStart + ($tglSpace * $i), 28);
					$pdf->Cell(4,1,substr ( $_tanggalPPH, $i, 1 ),$guideline,1,"C");
				}
				//======================================================================

				//FOOTER
				//======================================================================
				if($pemotongPajakPimpinan){
					$pdf->SetXY(12.4, 278);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				if($kuasaWajibPajak){
					$pdf->SetXY(66.4, 278);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$tglStartFooter = 159.5;
				$tglSpaceFooter = 4.9;
				for($i = 0; $i < strlen($tanggalPP); $i++){
					if($i == 4 || $i == 5)
						continue;
					$pdf->SetXY($tglStartFooter + ($tglSpaceFooter * $i), 278);
					$pdf->Cell(4,1,substr ( $tanggalPP, $i, 1 ),$guideline,1,"C");
				}

				/*if($ttd != ""){
					$ext  	= pathinfo($ttd, PATHINFO_EXTENSION);	
					$pdf->Image($ttd,170,290.5,0,13,$ext);
				}*/
				if(file_exists($ttd)){
					
				$ext  	= pathinfo($ttd, PATHINFO_EXTENSION);	
				$pdf->Image($ttd,170,290.5,0,13,$ext);

				$pdf->SetXY(139.5, 300);
				$pdf->Cell(64,1,strtoupper($namaTTD),$guideline,1,"C");

				$pdf->SetXY(139.5, 302.5);
				$pdf->Cell(64,1,strtoupper($petugasTTD),$guideline,1,"C");

				$namaPP = strtoupper($namaPP);
				$nameStart = 22.2;
				$nameSpace = 4.9;
				for($i = 0; $i < strlen($namaPP); $i++){
					$pdf->SetXY($nameStart + ($nameSpace * $i), 284.2);
					$pdf->Cell(4,1,substr ( $namaPP, $i, 1 ),$guideline,1,"C");
				}
				}

				//NPWP PEMOTONG
				//======================================================
				$npwpPP = str_replace('.','',$npwpPP);
				$npwpPP = str_replace('-','',$npwpPP);
				$height = 290.4;
				$start_npwp_footer = 22.2;
				$space_npwp_footer = 4.9;
				$npwp1 = substr ( $npwpPP, 0, 1 );
				$pdf->SetXY($start_npwp_footer, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $npwpPP, 1, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $npwpPP, 2, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $npwpPP, 3, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $npwpPP, 4, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $npwpPP, 5, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $npwpPP, 6, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $npwpPP, 7, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $npwpPP, 8, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $npwpPP, 9, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $npwpPP, 10, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $npwpPP, 11, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $npwpPP, 12, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $npwpPP, 13, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $npwpPP, 14, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//PARAMETER 23
				//===============================================================
				
				$totalDPPALL23 = 0;
				$totalPPALL23 = 0;
				$currentDataCount = 0;
				for($i = $index * $limit23; $i < ($limit23 + ($index * $limit23)); $i++){
					if(isset($arrData23[$i])){						
						$datum23 = $arrData23[$i];
					//	if(!$datum23['mata_uang']) {
							//print_r($datum23['mata_uang']); exit();
						$_npwp23 = $datum23['npwp'];
						$_nama23 = $datum23['namaWP'];
						$_noFaktur23 = $datum23['bukti_potong'];
						$_tanggalBuktiPotong23 = $datum23['tanggalBuktiPotong'];
						$_dpp23 = $datum23['totalDpp'];
						$_pp23 = $datum23['totalPP'];

						//PPH23
						$pdf->SetXY(13, $rowPPH23Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(37,1,$_npwp23,$guideline,1,"L");

						//NAMA
						$pdf->SetXY(52, $rowPPH23Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(47,1,substr($_nama23,0,25),$guideline,1,"L");

						//NOMOR BUKTI POTONG
						$pdf->SetFont('Helvetica','',5);
						$pdf->SetXY(99.5, $rowPPH23Start + ($rowPPHSpace * $currentDataCount)+1);
						$pdf->Cell(23,1,$_noFaktur23,$guideline,1,"L");
						$pdf->SetFont('Helvetica','',8);

						//TANGGAL
						$pdf->SetXY(126, $rowPPH23Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(22,1,$_tanggalBuktiPotong23,$guideline,1,"C");

						//NILAI OBJECT PAJAK
						$pdf->SetXY(150, $rowPPH23Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_dpp23),0,',','.')),$guideline,1,"R");

						//PPH
						$pdf->SetXY(179, $rowPPH23Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_pp23),0,',','.')),$guideline,1,"R");

						$totalDPPALL23 += $_dpp23;
						$totalPPALL23 += $_pp23;
						$currentDataCount++;
						//}
					}
				}

					//TOTAL NILAI OBJECT PAJAK
					$pdf->SetXY(150,  173);
					$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalDPPALL23),0,',','.')),$guideline,1,"R");

					//TOTAL PPH
					$pdf->SetXY(179, 173);
					$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalPPALL23),0,',','.')),$guideline,1,"R");

				//===============================================================

				//PARAMETER 26
				//===============================================================
				$totalDPPALL26 = 0;
				$totalPPALL26 = 0;
				$currentDataCount = 0;

				for($i = $index * $limit26; $i < ($limit26 + ($index * $limit26)); $i++){
					if(isset($arrData26[$i])){
						$datum26 = $arrData26[$i];
						$_npwp26 = $datum26['npwp'];
						$_nama26 = $datum26['namaWP'];
						$_noFaktur26 = $datum26['bukti_potong'];
						$_tanggalBuktiPotong26 = $datum26['tanggalBuktiPotong'];
						$_dpp26 = $datum26['totalDpp'];
						$_pp26 = $datum26['totalPP'];

						//PPH26
						$pdf->SetXY(13, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(37,1,$_npwp26,$guideline,1,"L");

						//NAMA
						$pdf->SetXY(52, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(47,1,substr($_nama26,0,25),$guideline,1,"L");

						//NOMOR BUKTI POTONG
						$pdf->SetFont('Helvetica','',5);
						$pdf->SetXY(99.5, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(23,1,$_noFaktur26,$guideline,1,"L");
						$pdf->SetFont('Helvetica','',8);
						
						//TANGGAL
						$pdf->SetXY(126, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(22,1,$_tanggalBuktiPotong26,$guideline,1,"C");

						//NILAI OBJECT PAJAK
						$pdf->SetXY(150, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_dpp26),0,',','.')),$guideline,1,"R");

						//PPH
						$pdf->SetXY(179, $rowPPH26Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_pp26),0,',','.')),$guideline,1,"R");

						$totalDPPALL26 += $_dpp26;
						$totalPPALL26 += $_pp26;
						$currentDataCount++;
					}
				}

					//TOTAL NILAI OBJECT PAJAK
					$pdf->SetXY(150,  267);
					$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalDPPALL26),0,',','.')),$guideline,1,"R");

					//TOTAL PPH
					$pdf->SetXY(179,267);
					$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalPPALL26),0,',','.')),$guideline,1,"R");

				//===============================================================
		}
		//display pdf
		$pdf->Output();
	}

	function cetakDaftarBupot22($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang){

		$pdf = new FPDI('Portrait','mm',array(210,330));
		$fh = 'assets/templates/22/daftar-bupot-PPH-22.pdf';

		$guideline = 0; //change to 1 to see field border for every parameter
		$limit22 = 40;
		$rowPPH22Start = 58.6;
		$rowPPHSpace = 5.1;
		$arrData22 = array();

		//GET DATA
		$data['pph22'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,FALSE,"DAFTAR BUPOT");

		//COMPILE Data
		$arrayOfNoBuktiPotong22 = array();
		$totalDPPALL22 = 0;
		$totalPPALL22 = 0;

		//FOOTER DATA [AMBIL DARI DB]
		$pemotongPajakPimpinan = TRUE;
		$kuasaWajibPajak = FALSE;
		$namaPP = "";
		$npwpPP = "";
		$tanggalPP = ""; //DDMMYYYY

		foreach ($data['pph22'] as $pph):
			$noBuktiPotong = $pph['NO_BUKTI_POTONG'];
			$npwp = "";

				if($pph['NPWP'] != ""){
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "",$pph['NPWP']);
				$ilanginStrip = str_replace("-", "",$ilanginTitik);
				$npwp = substr($ilanginStrip,0,2).".".substr($ilanginStrip,2,3).".".substr($ilanginStrip,5,3).".".substr($ilanginStrip,8,1)."-".substr($ilanginStrip,9,3).".".substr($ilanginStrip,12,3);
				}

			$npwpPP = $pph['NPWPPP'];
			$namaPP= substr($pph['NAMA_PETUGAS_PENANDATANGAN'],0,23);
			$namaTTD = $pph['NAMA_PETUGAS_PENANDATANGAN']." (".$pph['JABATAN_PETUGAS_PENANDATANGAN'].")";
			$ttd = $pph['URL_TANDA_TANGAN'];
			$tanggalPP = date("dmY", strtotime($pph['TGL_APPROVE_SUP']));

			/*
			if($pph['NAMA_PEMOTONG'] != ""){
				$namaPP = $pph['NAMA_PEMOTONG'];
				$npwpPP = $pph['NPWP_PEMOTONG'];
				$tanggalPP = date("dmY", strtotime($pph['TGL_BUKTI_POTONG']));
			}
			*/

			if($noBuktiPotong == "")
				continue;
			$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong22);
			if($idx == FALSE){
				array_push($arrayOfNoBuktiPotong22,$noBuktiPotong);
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong22);
				$arrData22[$idx]['totalJasaLain'] = 0;
				$arrData22[$idx]['totalDpp'] = 0;
				$arrData22[$idx]['totalPP'] = 0;
			}
			$arrData22[$idx]['bukti_potong'] = $noBuktiPotong;
			$arrData22[$idx]['npwp'] = $npwp;
			$arrData22[$idx]['namaWP'] = $pph['NAMA_WP'];
			$arrData22[$idx]['tanggalBuktiPotong'] = date("d/m/Y", strtotime($pph['TGL_BUKTI_POTONG']));
			$arrData22[$idx]['totalDpp'] += $pph['DPP'];
			$arrData22[$idx]['totalPP'] += $pph['JUMLAH_POTONG'];

		endforeach;

		//TANGGAL BERDASARKAN FILTER
		$_tanggalPPH = "";
		if(strlen($bulan) == 1)
			$_tanggalPPH = "0".$bulan." ".$tahun;
		else
			$_tanggalPPH = $bulan." ".$tahun;



		$pageNumber = ceil(count($arrData22)/$limit22);
		for($index = 0; $index < $pageNumber; $index++){
			$pdf->AddPage(); //new page

			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//HEADER
			//======================================================================
			$tglStart = 164.4;
			$tglSpace = 4.85;
			for($i = 0; $i < strlen($_tanggalPPH); $i++){
				$pdf->SetXY($tglStart + ($tglSpace * $i), 28);
				$pdf->Cell(4,1,substr ( $_tanggalPPH, $i, 1 ),$guideline,1,"C");
			}
			//======================================================================

			//FOOTER
			//======================================================================
			if($pemotongPajakPimpinan){
				$pdf->SetXY(12.4, 279.2);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			if($kuasaWajibPajak){
				$pdf->SetXY(66.4, 279.2);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$tglStartFooter = 159.5;
			$tglSpaceFooter = 4.9;
			for($i = 0; $i < strlen($tanggalPP); $i++){
				if($i == 4 || $i == 5)
					continue;
				$pdf->SetXY($tglStartFooter + ($tglSpaceFooter * $i), 279.2);
				$pdf->Cell(4,1,substr ( $tanggalPP, $i, 1 ),$guideline,1,"C");
			}

			if($ttd != ""){
				$ext  	= pathinfo($ttd, PATHINFO_EXTENSION);	
				$pdf->Image($ttd,170,290.5,0,13,$ext);
			}
			$pdf->SetXY(139.5, 302);
			$pdf->Cell(64,1,strtoupper($namaTTD),$guideline,1,"C");

			$namaPP = strtoupper($namaPP);
			$nameStart = 22.2;
			$nameSpace = 4.9;
			for($i = 0; $i < strlen($namaPP); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 285.3);
				$pdf->Cell(4,1,substr ( $namaPP, $i, 1 ),$guideline,1,"C");
			}

			//NPWP PEMOTONG
			//======================================================
			$npwpPP = str_replace('.','',$npwpPP);
			$npwpPP = str_replace('-','',$npwpPP);
			$height = 291.5;
			$start_npwp_footer = 22.2;
			$space_npwp_footer = 4.9;
			$npwp1 = substr ( $npwpPP, 0, 1 );
			$pdf->SetXY($start_npwp_footer, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $npwpPP, 1, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $npwpPP, 2, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $npwpPP, 3, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $npwpPP, 4, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $npwpPP, 5, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $npwpPP, 6, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $npwpPP, 7, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $npwpPP, 8, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $npwpPP, 9, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $npwpPP, 10, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $npwpPP, 11, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $npwpPP, 12, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $npwpPP, 13, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $npwpPP, 14, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//PARAMETER 22
			//===============================================================
			$totalDPPALL22 = 0;
			$totalPPALL22 = 0;
			$currentDataCount = 0;
			for($i = $index * $limit22; $i < ($limit22 + ($index * $limit22)); $i++){
				if(isset($arrData22[$i])){
					$datum22 = $arrData22[$i];
					$_npwp22 = $datum22['npwp'];
					$_nama22 = $datum22['namaWP'];
					$_noFaktur22 = $datum22['bukti_potong'];
					$_tanggalBuktiPotong22 = $datum22['tanggalBuktiPotong'];
					$_dpp22 = $datum22['totalDpp'];
					$_pp22 = $datum22['totalPP'];

					//PPH23
					$pdf->SetXY(13, $rowPPH22Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(37,1,$_npwp22,$guideline,1,"L");

					//NAMA
					$pdf->SetXY(52, $rowPPH22Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(47,1,substr($_nama22,0,25),$guideline,1,"L");

					//NOMOR BUKTI POTONG
					$pdf->SetFont('Helvetica','',5);
					$pdf->SetXY(99.5, $rowPPH22Start + ($rowPPHSpace * $currentDataCount)+1);
					$pdf->Cell(23,1,$_noFaktur22,$guideline,1,"L");
					$pdf->SetFont('Helvetica','',8);

					//TANGGAL
					$pdf->SetXY(126, $rowPPH22Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(22,1,$_tanggalBuktiPotong22,$guideline,1,"C");

					//NILAI OBJECT PAJAK
					$pdf->SetXY(150, $rowPPH22Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_dpp22),0,',','.')),$guideline,1,"R");

					//PPH
					$pdf->SetXY(179, $rowPPH22Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_pp22),0,',','.')),$guideline,1,"R");

					$totalDPPALL22 += $_dpp22;
					$totalPPALL22 += $_pp22;
					$currentDataCount++;
				}
			}


				//TOTAL NILAI OBJECT PAJAK
				$pdf->SetXY(150,  268);
				$pdf->Cell(27,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalDPPALL22),0,',','.')),$guideline,1,"R");

				//TOTAL PPH
				$pdf->SetXY(179, 268);
				$pdf->Cell(23.5,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalPPALL22),0,',','.')),$guideline,1,"R");

			//===============================================================


		}
		//display pdf
		$pdf->Output();
	}
		
	function cetakDaftarBupot4Ayat2($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang){
		//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$guideline = 0; //change to 1 to see field border for every parameter
		//TANGGAL BERDASARKAN FILTER
		$_tanggalPPH = "";
		if(strlen($bulan) == 1)
			$_tanggalPPH = "0".$bulan." ".$tahun;
		else
			$_tanggalPPH = $bulan." ".$tahun;

		//DAFTAR BUPOT 1
		//**************************************************************************
		$fh = 'assets/templates/14-2/daftar-bupot-PPH-4-2-01.pdf';
		$limit421 = 40;
		$rowPPH421Start = 57.8;
		$rowPPHSpace = 5.05;
		$arrData421 = array();

		//GET DATA
		$data['pph421'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,FALSE,"DAFTAR BUPOT");

		//COMPILE Data
		$arrayOfNoBuktiPotong421 = array();
		$totalDPPALL421 = 0;
		$totalPPALL421 = 0;

		//FOOTER DATA [AMBIL DARI DB]
		$pemotongPajakPimpinan = TRUE;
		$kuasaWajibPajak = FALSE;
		$namaPP = "";
		$npwpPP = "";
		$tanggalPP = ""; //DDMMYYYY

		foreach ($data['pph421'] as $pph):
			$noBuktiPotong = $pph['NO_BUKTI_POTONG'];
			$npwp = "";

				if($pph['NPWP'] != ""){
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "",$pph['NPWP']);
				$ilanginStrip = str_replace("-", "",$ilanginTitik);
				$npwp = substr($ilanginStrip,0,2).".".substr($ilanginStrip,2,3).".".substr($ilanginStrip,5,3).".".substr($ilanginStrip,8,1)."-".substr($ilanginStrip,9,3).".".substr($ilanginStrip,12,3);
				}

			$npwpPP = $pph['NPWPPP'];
			$namaPP= substr($pph['NAMA_PETUGAS_PENANDATANGAN'],0,23);
			$namaTTD = $pph['NAMA_PETUGAS_PENANDATANGAN'];
			$jabTTD = $pph['JABATAN_PETUGAS_PENANDATANGAN'];
			$ttd = $pph['URL_TANDA_TANGAN'];
			$tanggalPP = date("dmY", strtotime($pph['TGL_APPROVE_SUP']));

			/*
			if($pph['NAMA_PEMOTONG'] != ""){
				$namaPP = $pph['NAMA_PEMOTONG'];
				$npwpPP = $pph['NPWP_PEMOTONG'];
				$tanggalPP = date("dmY", strtotime($pph['TGL_BUKTI_POTONG']));
			}
			*/

			if($noBuktiPotong == "")
				continue;
			$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong421);
			if($idx == FALSE){
				array_push($arrayOfNoBuktiPotong421,$noBuktiPotong);
				$idx = array_search($noBuktiPotong,$arrayOfNoBuktiPotong421);
				$arrData421[$idx]['totalJasaLain'] = 0;
				$arrData421[$idx]['totalDpp'] = 0;
				$arrData421[$idx]['totalPP'] = 0;
			}
			$arrData421[$idx]['bukti_potong'] = $noBuktiPotong;
			$arrData421[$idx]['npwp'] = $npwp;
			$arrData421[$idx]['namaWP'] = $pph['NAMA_WP'];
			$arrData421[$idx]['tanggalBuktiPotong'] = date("d/m/Y", strtotime($pph['TGL_BUKTI_POTONG']));
			$arrData421[$idx]['totalDpp'] += $pph['DPP'];
			$arrData421[$idx]['totalPP'] += $pph['JUMLAH_POTONG'];

		endforeach;

		$pageNumber = ceil(count($arrData421)/$limit421);
		for($index = 0; $index < $pageNumber; $index++){
			$pdf->AddPage(); //new page

			$pdf->setSourceFile($fh);
			$tplId = $pdf->importPage(1);
			$pdf->useTemplate($tplId);

			$pdf->SetTextColor(0,0,0); // RGB
			$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size

			//HEADER
			//======================================================================
			$tglStart = 163.4;
			$tglSpace = 4.85;
			for($i = 0; $i < strlen($_tanggalPPH); $i++){
				$pdf->SetXY($tglStart + ($tglSpace * $i), 27.8);
				$pdf->Cell(4,1,substr ( $_tanggalPPH, $i, 1 ),$guideline,1,"C");
			}
			//======================================================================

			//FOOTER
			//======================================================================

			if($pemotongPajakPimpinan){
				$pdf->SetXY(14, 275);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			if($kuasaWajibPajak){
				$pdf->SetXY(66.6, 275);
				$pdf->Cell(4,1,"V",$guideline,1,"C");
			}

			$tglStartFooter = 158.4;
			$tglSpaceFooter = 4.9;
			for($i = 0; $i < strlen($tanggalPP); $i++){
				if($i == 4 || $i == 5)
					continue;
				$pdf->SetXY($tglStartFooter + ($tglSpaceFooter * $i), 275);
				$pdf->Cell(4,1,substr ( $tanggalPP, $i, 1 ),$guideline,1,"C");
			}

			if($ttd != ""){
				$ext  	= pathinfo($ttd, PATHINFO_EXTENSION);	
				$pdf->Image($ttd,168,286.5,0,13,$ext);
			}
			$pdf->SetXY(139.5, 295.8);
			$pdf->Cell(61,1,strtoupper($namaTTD),$guideline,1,"C");

			$pdf->SetXY(139.5, 298.8);
			$pdf->Cell(61,1,strtoupper($jabTTD),$guideline,1,"C");

			$namaPP = strtoupper($namaPP);
			$nameStart = 23.6;
			$nameSpace = 4.82;
			for($i = 0; $i < strlen($namaPP); $i++){
				$pdf->SetXY($nameStart + ($nameSpace * $i), 280.8);
				$pdf->Cell(4,1,substr ( $namaPP, $i, 1 ),$guideline,1,"C");
			}

			//NPWP PEMOTONG
			//======================================================
			$npwpPP = str_replace('.','',$npwpPP);
			$npwpPP = str_replace('-','',$npwpPP);
			$height = 287;
			$start_npwp_footer = 23.6;
			$space_npwp_footer = 4.82;
			$npwp1 = substr ( $npwpPP, 0, 1 );
			$pdf->SetXY($start_npwp_footer, $height);
			$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

			$npwp2 = substr ( $npwpPP, 1, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
			$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

			$npwp3 = substr ( $npwpPP, 2, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
			$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

			$npwp4 = substr ( $npwpPP, 3, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
			$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

			$npwp5 = substr ( $npwpPP, 4, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
			$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

			$npwp6 = substr ( $npwpPP, 5, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
			$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

			$npwp7 = substr ( $npwpPP, 6, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
			$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

			$npwp8 = substr ( $npwpPP, 7, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
			$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

			$npwp9 = substr ( $npwpPP, 8, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
			$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

			$npwp10 = substr ( $npwpPP, 9, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
			$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

			$npwp11 = substr ( $npwpPP, 10, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
			$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

			$npwp12 = substr ( $npwpPP, 11, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
			$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

			$npwp13 = substr ( $npwpPP, 12, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
			$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

			$npwp14 = substr ( $npwpPP, 13, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
			$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

			$npwp15 = substr ( $npwpPP, 14, 1 );
			$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
			$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
			//======================================================

			//PARAMETER 421
			//===============================================================
			$totalDPPALL421 = 0;
			$totalPPALL421 = 0;
			$currentDataCount = 0;
			for($i = $index * $limit421; $i < ($limit421 + ($index * $limit421)); $i++){
				if(isset($arrData421[$i])){
					$datum421 = $arrData421[$i];
					$_npwp421 = $datum421['npwp'];
					$_nama421 = $datum421['namaWP'];
					$_noFaktur421 = $datum421['bukti_potong'];
					$_tanggalBuktiPotong421 = $datum421['tanggalBuktiPotong'];
					$_dpp421 = $datum421['totalDpp'];
					$_pp421 = $datum421['totalPP'];

					//PPH23
					$pdf->SetXY(15, $rowPPH421Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(36,1,$_npwp421,$guideline,1,"L");

					//NAMA
					$pdf->SetXY(53, $rowPPH421Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(46,1,substr($_nama421,0,25),$guideline,1,"L");

					//NOMOR BUKTI POTONG
					$pdf->SetFont('Helvetica','',5);
					$pdf->SetXY(99.5, $rowPPH421Start + ($rowPPHSpace * $currentDataCount)+1);
					$pdf->Cell(22.5,1,$_noFaktur421,$guideline,1,"L");
					$pdf->SetFont('Helvetica','',8);

					//TANGGAL
					$pdf->SetXY(125.5, $rowPPH421Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(22,1,$_tanggalBuktiPotong421,$guideline,1,"C");

					//NILAI OBJECT PAJAK
					$pdf->SetXY(150, $rowPPH421Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(26,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_dpp421),0,',','.')),$guideline,1,"R");

					//PPH
					$pdf->SetXY(178, $rowPPH421Start + ($rowPPHSpace * $currentDataCount));
					$pdf->Cell(24,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_pp421),0,',','.')),$guideline,1,"R");

					$totalDPPALL421 += $_dpp421;
					$totalPPALL421 += $_pp421;
					$currentDataCount++;
				}
			}

				//TOTAL NILAI OBJECT PAJAK
				$pdf->SetXY(150,  263.6);
				$pdf->Cell(26,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalDPPALL421),0,',','.')),$guideline,1,"R");

				//TOTAL PPH
				$pdf->SetXY(178, 263.6);
				$pdf->Cell(24,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalPPALL421),0,',','.')),$guideline,1,"R");
			//===============================================================

		}

		//**************************************************************************

		/*

		//DAFTAR BUPOT 2
		//**************************************************************************
		$fh = 'assets/templates/14-2/daftar-bupot-PPH-4-2-02.pdf';
		$pdf->AddPage(); //new page
		$pdf->setSourceFile($fh);
		$tplId = $pdf->importPage(1);
		$pdf->useTemplate($tplId);

		//HEADER
		//======================================================================
		$tglStart = 163.4;
		$tglSpace = 4.85;
		for($i = 0; $i < strlen($_tanggalPPH); $i++){
			$pdf->SetXY($tglStart + ($tglSpace * $i), 27.8);
			$pdf->Cell(4,1,substr ( $_tanggalPPH, $i, 1 ),$guideline,1,"C");
		}
		//======================================================================

		//FOOTER
		//======================================================================

		if($pemotongPajakPimpinan){
			$pdf->SetXY(14, 127.4);
			$pdf->Cell(4,1,"V",$guideline,1,"C");
		}

		if($kuasaWajibPajak){
			$pdf->SetXY(66.6, 127.4);
			$pdf->Cell(4,1,"V",$guideline,1,"C");
		}

		$tglStartFooter = 158.4;
		$tglSpaceFooter = 4.9;
		for($i = 0; $i < strlen($tanggalPP); $i++){
			if($i == 4 || $i == 5)
				continue;
			$pdf->SetXY($tglStartFooter + ($tglSpaceFooter * $i), 127.4);
			$pdf->Cell(4,1,substr ( $tanggalPP, $i, 1 ),$guideline,1,"C");
		}

		$namaPP = strtoupper($namaPP);
		$nameStart = 23.6;
		$nameSpace = 4.82;
		for($i = 0; $i < strlen($namaPP); $i++){
			$pdf->SetXY($nameStart + ($nameSpace * $i), 133.5);
			$pdf->Cell(4,1,substr ( $namaPP, $i, 1 ),$guideline,1,"C");
		}

		//NPWP PEMOTONG
		//======================================================
		$npwpPP = str_replace('.','',$npwpPP);
		$npwpPP = str_replace('-','',$npwpPP);
		$height = 139.5;
		$start_npwp_footer = 23.6;
		$space_npwp_footer = 4.82;
		$npwp1 = substr ( $npwpPP, 0, 1 );
		$pdf->SetXY($start_npwp_footer, $height);
		$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

		$npwp2 = substr ( $npwpPP, 1, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
		$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

		$npwp3 = substr ( $npwpPP, 2, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
		$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

		$npwp4 = substr ( $npwpPP, 3, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
		$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

		$npwp5 = substr ( $npwpPP, 4, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
		$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

		$npwp6 = substr ( $npwpPP, 5, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
		$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

		$npwp7 = substr ( $npwpPP, 6, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
		$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

		$npwp8 = substr ( $npwpPP, 7, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
		$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

		$npwp9 = substr ( $npwpPP, 8, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
		$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

		$npwp10 = substr ( $npwpPP, 9, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
		$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

		$npwp11 = substr ( $npwpPP, 10, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
		$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

		$npwp12 = substr ( $npwpPP, 11, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
		$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

		$npwp13 = substr ( $npwpPP, 12, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
		$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

		$npwp14 = substr ( $npwpPP, 13, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
		$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

		$npwp15 = substr ( $npwpPP, 14, 1 );
		$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
		$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
		//======================================================

		//PARAMETER 422
		//===============================================================
		$jumlah_nasabah_bunga_dn = 10;
		$nop_bunga_dn = 123123;
		$pph_bunga_dn = 123;

		$jumlah_nasabah_bunga_ln = 20;
		$nop_bunga_ln = 234234;
		$pph_bunga_ln = 234;

		$jumlah_nasabah_diskonto = 30;
		$nop_diskonto = 345345;
		$pph_diskonto = 345;

		$jumlah_nasabah_giro = 40;
		$nop_giro = 456456;
		$pph_giro = 456;

		$total_jumlah_nasabah = number_format($jumlah_nasabah_bunga_dn + $jumlah_nasabah_bunga_ln + $jumlah_nasabah_diskonto + $jumlah_nasabah_giro);
		$total_nop= number_format($nop_bunga_dn + $nop_bunga_ln + $nop_diskonto + $nop_giro);
		$total_pph = number_format($pph_bunga_dn + $pph_bunga_ln + $pph_diskonto + $pph_giro);

		$col_jumlah_nasabah = 102;
		$col_nop = 126;
		$col_pph = 164;
		//===============================================================

		//BUNGA DN
		//--------------------------------------------------------------------------
		$h = 73;
		$pdf->SetXY($col_jumlah_nasabah,$h);
		$pdf->Cell(20,1,$jumlah_nasabah_bunga_dn,$guideline,1,"C");

		$pdf->SetXY($col_nop,$h);
		$pdf->Cell(35,1,$nop_bunga_dn,$guideline,1,"R");

		$pdf->SetXY($col_pph,$h);
		$pdf->Cell(35,1,$pph_bunga_dn,$guideline,1,"R");
		//--------------------------------------------------------------------------

		//BUNGA lN
		//--------------------------------------------------------------------------
		$h = 78;
		$pdf->SetXY($col_jumlah_nasabah,$h);
		$pdf->Cell(20,1,$jumlah_nasabah_bunga_ln,$guideline,1,"C");

		$pdf->SetXY($col_nop,$h);
		$pdf->Cell(35,1,$nop_bunga_ln,$guideline,1,"R");

		$pdf->SetXY($col_pph,$h);
		$pdf->Cell(35,1,$pph_bunga_ln,$guideline,1,"R");
		//--------------------------------------------------------------------------

		//BUNGA DISKONTO
		//--------------------------------------------------------------------------
		$h = 88;
		$pdf->SetXY($col_jumlah_nasabah,$h);
		$pdf->Cell(20,1,$jumlah_nasabah_diskonto,$guideline,1,"C");

		$pdf->SetXY($col_nop,$h);
		$pdf->Cell(35,1,$nop_diskonto,$guideline,1,"R");

		$pdf->SetXY($col_pph,$h);
		$pdf->Cell(35,1,$pph_diskonto,$guideline,1,"R");
		//--------------------------------------------------------------------------

		//BUNGA GIRO
		//--------------------------------------------------------------------------
		$h = 98;
		$pdf->SetXY($col_jumlah_nasabah,$h);
		$pdf->Cell(20,1,$jumlah_nasabah_giro,$guideline,1,"C");

		$pdf->SetXY($col_nop,$h);
		$pdf->Cell(35,1,$nop_giro,$guideline,1,"R");

		$pdf->SetXY($col_pph,$h);
		$pdf->Cell(35,1,$pph_giro,$guideline,1,"R");
		//--------------------------------------------------------------------------

		//TOTAL
		//--------------------------------------------------------------------------
		$h = 108;
		$pdf->SetXY($col_jumlah_nasabah,$h);
		$pdf->Cell(20,1,$total_jumlah_nasabah,$guideline,1,"C");

		$pdf->SetXY($col_nop,$h);
		$pdf->Cell(35,1,$total_nop,$guideline,1,"R");

		$pdf->SetXY($col_pph,$h);
		$pdf->Cell(35,1,$total_pph,$guideline,1,"R");
		//--------------------------------------------------------------------------

		//**************************************************************************
		*/
		//display pdf
		$pdf->Output();
	}

	function cetakDaftarBupot15($bulan, $tahun, $pajak, $pembetulan, $isCabang, $valCabang){
		//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
		//$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));
		$pdf = new FPDI('Portrait','mm',array(210,330));

		$fh = 'assets/templates/15/daftar-bupot-PPH-15.pdf';
		$guideline = 0; //change to 1 to see field border for every parameter
		$arrData15 = array();

		//GET DATA
		$data['pph15'] = $this->pph->get_pph($bulan,$tahun,$pajak,$pembetulan,$isCabang,$valCabang,FALSE,"DAFTAR BUPOT");

		//COMPILE Data
		$arrayOfNPWP15 = array();
		$totalDPPALL15 = 0;
		$totalPPALL15 = 0;

		//FOOTER DATA [AMBIL DARI DB]
		$pemotongPajakPimpinan = TRUE;
		$kuasaWajibPajak = FALSE;
		$namaPP = "";
		$npwpPP = "";
		$tanggalPP = ""; //DDMMYYYY

		foreach ($data['pph15'] as $pph):
			$noBuktiPotong = $pph['NO_BUKTI_POTONG'];
			$npwp = "";

				if($pph['NPWP'] != ""){
				//$npwp = $pph['NPWP'];
				$ilanginTitik = str_replace(".", "",$pph['NPWP']);
				$ilanginStrip = str_replace("-", "",$ilanginTitik);
				$npwp = substr($ilanginStrip,0,2).".".substr($ilanginStrip,2,3).".".substr($ilanginStrip,5,3).".".substr($ilanginStrip,8,1)."-".substr($ilanginStrip,9,3).".".substr($ilanginStrip,12,3);
				}

			$npwpPP = $pph['NPWPPP'];
			$namaPP= substr($pph['NAMA_PETUGAS_PENANDATANGAN'],0,23);
			$namaTTD = $pph['NAMA_PETUGAS_PENANDATANGAN']." (".$pph['JABATAN_PETUGAS_PENANDATANGAN'].")";
			$ttd = $pph['URL_TANDA_TANGAN'];
			$tanggalPP = date("dmY", strtotime($pph['TGL_APPROVE_SUP']));

			/*
			if($pph['NAMA_PEMOTONG'] != ""){
				$namaPP = $pph['NAMA_PEMOTONG'];
				$npwpPP = $pph['NPWP_PEMOTONG'];
				$tanggalPP = date("dmY", strtotime($pph['TGL_BUKTI_POTONG']));
			}
			*/

			//if($noBuktiPotong == "")
				//continue;
			$idx = array_search($npwp,$arrayOfNPWP15);
			if($idx == FALSE){
				array_push($arrayOfNPWP15,$npwp);
				$idx = array_search($npwp,$arrayOfNPWP15);
				$arrData15[$idx]['totalDpp'] = 0;
				$arrData15[$idx]['totalPP'] = 0;
			}
			$arrData15[$idx]['bukti_potong'] = $noBuktiPotong;
			$arrData15[$idx]['npwp'] = $npwp;
			$arrData15[$idx]['namaWP'] = $pph['NAMA_WP'];
			$arrData15[$idx]['tanggalBuktiPotong'] = date("d/m/Y", strtotime($pph['TGL_BUKTI_POTONG']));
			$arrData15[$idx]['totalDpp'] += $pph['DPP'];
			$arrData15[$idx]['totalPP'] += $pph['JUMLAH_POTONG'];

		endforeach;

		//print_r($arrData15);

		//DATA PPH YANG DIPOTONG PIHAK LAINNYA
		//==========================================================================
		$arrPPHYangDipotongPihakLain = $arrData15;
		//==========================================================================

		//DATA PPH PIHAK LAIN YANG DIPOTONG
		//==========================================================================
		$arrPPHPihakLainYangDipotong = array();
		//insert data to array of PPH pihak lain yang dipotong
		//.
		//.
		//.
		//==========================================================================

		//PPH PASAL 24
		//==========================================================================
		$arrPPH24 = array();
		//insert data to array of PPH 24
		//.
		//.
		//.
		//==========================================================================

		//TANGGAL BERDASARKAN FILTER
		$_tanggalPPH = "";
		if(strlen($bulan) == 1)
			$_tanggalPPH = "0".$bulan." ".$tahun;
		else
			$_tanggalPPH = $bulan." ".$tahun;

		$limitPPHPotongPihakLain = 10;
		$limitPPHPihakLain = 10;
		$limitPPH24 = 5;
		$rowPPHPotongPihakLainStart = 69.8;
		$rowPPHPihakLainStart = 138;
		$rowPPH24Start = 222;
		$rowPPHSpace = 5.1;

		$limit = max(ceil(count($arrPPHYangDipotongPihakLain)/$limitPPHPotongPihakLain)
								,ceil(count($arrPPHPihakLainYangDipotong)/$limitPPHPihakLain)
								,ceil(count($arrPPH24)/$limitPPH24));

		for($index = 0; $index < $limit; $index++){

				$pdf->AddPage(); //new page

				$pdf->setSourceFile($fh);
				$tplId = $pdf->importPage(1);
				$pdf->useTemplate($tplId);

				$pdf->SetTextColor(0,0,0); // RGB
				$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size

				//HEADER
				//======================================================================
				$tglStart = 164.4;
				$tglSpace = 4.85;
				for($i = 0; $i < strlen($_tanggalPPH); $i++){
					$pdf->SetXY($tglStart + ($tglSpace * $i), 28);
					$pdf->Cell(4,1,substr ( $_tanggalPPH, $i, 1 ),$guideline,1,"C");
				}
				//======================================================================

				//FOOTER
				//======================================================================
				if($pemotongPajakPimpinan){
					$pdf->SetXY(12.4, 263.6);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				if($kuasaWajibPajak){
					$pdf->SetXY(66.4, 263.6);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$tglStartFooter = 159.5;
				$tglSpaceFooter = 4.9;
				for($i = 0; $i < strlen($tanggalPP); $i++){
					if($i == 4 || $i == 5)
						continue;
					$pdf->SetXY($tglStartFooter + ($tglSpaceFooter * $i), 263.6);
					$pdf->Cell(4,1,substr ( $tanggalPP, $i, 1 ),$guideline,1,"C");
				}

				if($ttd != ""){
					$ext  	= pathinfo($ttd, PATHINFO_EXTENSION);	
					$pdf->Image($ttd,168,276,0,12,$ext);
				}
				$pdf->SetXY(139.5, 287);
				$pdf->Cell(64,1,strtoupper($namaTTD),$guideline,1,"C");

				$namaPP = strtoupper($namaPP);
				$nameStart = 22.2;
				$nameSpace = 4.9;
				for($i = 0; $i < strlen($namaPP); $i++){
					$pdf->SetXY($nameStart + ($nameSpace * $i), 270);
					$pdf->Cell(4,1,substr ( $namaPP, $i, 1 ),$guideline,1,"C");
				}

				//NPWP PEMOTONG
				//======================================================
				$npwpPP = str_replace('.','',$npwpPP);
				$npwpPP = str_replace('-','',$npwpPP);
				$height = 276;
				$start_npwp_footer = 22.2;
				$space_npwp_footer = 4.9;
				$npwp1 = substr ( $npwpPP, 0, 1 );
				$pdf->SetXY($start_npwp_footer, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $npwpPP, 1, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*1), $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $npwpPP, 2, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*3), $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $npwpPP, 3, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*4), $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $npwpPP, 4, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*5), $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $npwpPP, 5, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*7), $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $npwpPP, 6, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*8), $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $npwpPP, 7, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*9), $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $npwpPP, 8, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*11), $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $npwpPP, 9, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*13), $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $npwpPP, 10, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*14), $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $npwpPP, 11, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*15), $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $npwpPP, 12, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*17), $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $npwpPP, 13, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*18), $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $npwpPP, 14, 1 );
				$pdf->SetXY($start_npwp_footer+($space_npwp_footer*19), $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//PARAMETER PPH YANG DIPOTONG PIHAK LAIN
				//===============================================================
				$totalBrutoALLPPHPotongPihakLain = 0;
				$totalPPALLPPHPotongPihakLain = 0;
				$currentDataCount = 0;
				for($i = $index * $limitPPHPotongPihakLain; $i < ($limitPPHPotongPihakLain + ($index * $limitPPHPotongPihakLain)); $i++){
					if(isset($arrPPHYangDipotongPihakLain[$i])){
						$datum = $arrPPHYangDipotongPihakLain[$i];
						$_npwp = $datum['npwp'];
						$_nama = $datum['namaWP'];
						$_dpp = $datum['totalDpp'];
						$_pp = $datum['totalPP'];

						//NPWP
						$pdf->SetXY(13, $rowPPHPotongPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(47,1,$_npwp,$guideline,1,"L");

						//NAMA
						$pdf->SetXY(62, $rowPPHPotongPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(71,1,substr($_nama,0,25),$guideline,1,"L");

						//BRUTO
						$pdf->SetXY(136, $rowPPHPotongPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(31,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_dpp),0,',','.')),$guideline,1,"R");

						//PPH
						$pdf->SetXY(170, $rowPPHPotongPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(31,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($_pp),0,',','.')),$guideline,1,"R");

						$totalBrutoALLPPHPotongPihakLain += $_dpp;
						$totalPPALLPPHPotongPihakLain += $_pp;
						$currentDataCount++;
					}
				}

				if($totalBrutoALLPPHPotongPihakLain > 0 && $totalPPALLPPHPotongPihakLain > 0){
					//TOTAL NILAI OBJECT PAJAK
					$pdf->SetXY(136,  126);
					$pdf->Cell(31,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalBrutoALLPPHPotongPihakLain),0,',','.')),$guideline,1,"R");

					//TOTAL PPH
					$pdf->SetXY(170, 126);
					$pdf->Cell(31,1,preg_replace('/(-)([\d\.\,]+)/ui','($2)',number_format(floor($totalPPALLPPHPotongPihakLain),0,',','.')),$guideline,1,"R");
				}
				//===============================================================

				//PARAMETER PPH PIHAK LAIN YANG DIPOTONG
				//===============================================================
				$totalBrutoALLPPHPihakLain = 0;
				$totalPPALLPPHPihakLainn = 0;
				$currentDataCount = 0;
				for($i = $index * $limitPPHPihakLain; $i < ($limitPPHPihakLain + ($index * $limitPPHPihakLain)); $i++){
					if(isset($arrPPHPihakLainYangDipotong[$i])){
						$datum = $arrPPHPihakLainYangDipotong[$i];
						$_npwp = $datum['npwp'];
						$_nama = $datum['namaWP'];
						$_dpp = $datum['totalDpp'];
						$_pp = $datum['totalPP'];

						//NPWP
						$pdf->SetXY(13, $rowPPHPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(47,1,$_npwp,$guideline,1,"L");

						//NAMA
						$pdf->SetXY(62, $rowPPHPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(71,1,substr($_nama,0,25),$guideline,1,"L");

						//BRUTO
						$pdf->SetXY(136, $rowPPHPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(31,1,$_dpp,$guideline,1,"R");

						//PPH
						$pdf->SetXY(170, $rowPPHPihakLainStart + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(31,1,$_pp,$guideline,1,"R");

						$totalBrutoALLPPHPihakLain += $_dpp;
						$totalPPALLPPHPihakLainn += $_pp;
						$currentDataCount++;
					}
				}

				if($totalBrutoALLPPHPihakLain > 0 && $totalPPALLPPHPihakLainn > 0){
					//TOTAL NILAI OBJECT PAJAK
					$pdf->SetXY(136,  194.4);
					$pdf->Cell(31,1,number_format(floor($totalBrutoALLPPHPihakLain),0,',','.'),$guideline,1,"R");

					//TOTAL PPH
					$pdf->SetXY(170, 194.4);
					$pdf->Cell(31,1,number_format(floor($totalPPALLPPHPihakLainn),0,',','.'),$guideline,1,"R");
				}
				//===============================================================

				//PARAMETER PPH 24
				//===============================================================
				$totalBrutoALLPPH24 = 0;
				$totalPajakTerhutangAllPPH24 = 0;
				$totalPPALLPPH24 = 0;
				$currentDataCount = 0;
				for($i = $index * $limitPPH24; $i < ($limitPPH24 + ($index * $limitPPH24)); $i++){
					if(isset($arrPPH24[$i])){
						$datum = $arrPPH24[$i];
						$_negaraSumberPenghasilan = $datum['namaWP'];
						$_jumlahBrutoPenghasilan = $datum['totalDpp'];
						$_JumlahPajakTerhutang = $datum['totalDpp'];
						$_pp = $datum['totalPP'];

						//NAMA
						$pdf->SetXY(13, $rowPPH24Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(56.5,1,substr($_negaraSumberPenghasilan,0,30),$guideline,1,"L");

						//BRUTO
						$pdf->SetXY(72, $rowPPH24Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(51,1,$_jumlahBrutoPenghasilan,$guideline,1,"R");

						//TERHUTANG
						$pdf->SetXY(126, $rowPPH24Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(36,1,$_JumlahPajakTerhutang,$guideline,1,"R");

						//PPH
						$pdf->SetXY(165, $rowPPH24Start + ($rowPPHSpace * $currentDataCount));
						$pdf->Cell(36,1,$_pp,$guideline,1,"R");

						$totalBrutoALLPPH24 += $_jumlahBrutoPenghasilan;
						$totalPajakTerhutangAllPPH24 += $_JumlahPajakTerhutang;
						$totalPPALLPPH24 += $_pp;
						$currentDataCount++;
					}
				}

				if($totalBrutoALLPPH24 > 0 && $totalPPALLPPH24 > 0){
					//TOTAL BRUTO
					$pdf->SetXY(72,  252.4);
					$pdf->Cell(51,1,number_format(floor($totalBrutoALLPPH24),0,',','.'),$guideline,1,"R");

					//TOTAL Pajak TERHUTANG
					$pdf->SetXY(126, 252.4);
					$pdf->Cell(36,1,number_format(floor($totalPajakTerhutangAllPPH24),0,',','.'),$guideline,1,"R");

					//TOTAL PPH
					$pdf->SetXY(165, 252.4);
					$pdf->Cell(36,1,number_format(floor($totalPPALLPPH24),0,',','.'),$guideline,1,"R");
				}
				//===============================================================

		}

		//display pdf
		$pdf->Output();
	}
	
	//------------------------------------------------------------------------
	
	function cetakPphAll(){ //smntra g d pakai

		require_once('vendor/autoload.php');

		//data from POST request
		$pajak        = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$bulan        = $_REQUEST['month'];
		$tahun        = $_REQUEST['year'];
		$type    	  = $_REQUEST['type'];
		$nomorFaktur  = "";
		if ($type=="single"){
			if (isset($_REQUEST['nf']) || $_REQUEST['nf'] ){
				$nomorFaktur  = $_REQUEST['nf'];
			} else {
				echo "<b>No Bukti Potong Kosong / Belum dipilih!</b>";
				exit();
			}
		}	
		
		//call TcpdfFpdi lib with param (orientation, unit, arr_size(w,h))
		$pdf = new setasign\Fpdi\TcpdfFpdi('Portrait','mm',array(210,330));

		//select template
		if($pajak == "PPH PSL 23 DAN 26"){
			$fh = 'assets/templates/PPH23 01 - Bukti_PotPut_PPh_23.pdf';

			//GET DATA
			$data['pph'] = $this->pph->get_pph23($bulan,$tahun,$pajak,$nomorFaktur);
			
			//COMPILE Data
			$arrayOfNoFakturPajak = array();
			foreach ($data['pph'] as $pph):
				$noFakturPajak = $pph['NO_BUKTI_POTONG'];
				$npwp = $pph['NPWP'];
				if($noFakturPajak == "")
					continue;
				if($npwp == "")
						continue;
				$idx = array_search($noFakturPajak,$arrayOfNoFakturPajak);
				
				if($idx == FALSE){
					array_push($arrayOfNoFakturPajak,$noFakturPajak);
					$idx = array_search($noFakturPajak,$arrayOfNoFakturPajak);
					$arrData[$idx]['totalJasaLain'] = 0;
					$arrData[$idx]['total'] = 0;
				}
				$arrData[$idx]['textNo1'] = "";
				$arrData[$idx]['textNo2'] = $noFakturPajak;
				$arrData[$idx]['npwp'] = $pph['NPWP'];
				$arrData[$idx]['namaWP'] = $pph['NAMA_WP'];
				$arrData[$idx]['addressWP'] = $pph['ALAMAT_WP'];
				$arrData[$idx]['lokasiPP'] = "Jakarta";
				$arrData[$idx]['tanggalFaktur'] = $pph['TANGGAL_FAKTUR_PAJAK'];
				$arrData[$idx]['npwpPP'] = $pph['NPWP_PEMOTONG'];
				$arrData[$idx]['namaPP'] = $pph['NAMA_PEMOTONG'];

				$kodePajak = $pph['KODE_PAJAK'];
				if($kodePajak == "")
					continue;
				else if($kodePajak == "KP0 PSL23-01"){
					$arrData[$idx]['dividenBruto'] = $pph['DPP'];
					$arrData[$idx]['dividenTarif'] = $pph['TARIF'];
					$arrData[$idx]['dividenJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-02"){
					$arrData[$idx]['bungaBruto'] = $pph['DPP'];
					$arrData[$idx]['bungaTarif'] = $pph['TARIF'];
					$arrData[$idx]['bungaJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-03"){
					$arrData[$idx]['royaltiBruto'] = $pph['DPP'];
					$arrData[$idx]['royaltiTarif'] = $pph['TARIF'];
					$arrData[$idx]['royaltiJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-04"){
					$arrData[$idx]['hadiahBruto'] = $pph['DPP'];
					$arrData[$idx]['hadiahTarif'] = $pph['TARIF'];
					$arrData[$idx]['hadiahJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-05"){
					$arrData[$idx]['sewaBruto'] = $pph['DPP'];
					$arrData[$idx]['sewaTarif'] = $pph['TARIF'];
					$arrData[$idx]['sewaJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-06"){
					$arrData[$idx]['jasaTeknikBruto'] = $pph['DPP'];
					$arrData[$idx]['jasaTeknikTarif'] = $pph['TARIF'];
					$arrData[$idx]['jasaTeknikJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-07"){
					$arrData[$idx]['jasaManagemenBruto'] = $pph['DPP'];
					$arrData[$idx]['jasaManagemenTarif'] = $pph['TARIF'];
					$arrData[$idx]['jasaManagemenJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-08"){
					$arrData[$idx]['jasaKonsultanBruto'] = $pph['DPP'];
					$arrData[$idx]['jasaKonsultanTarif'] = $pph['TARIF'];
					$arrData[$idx]['jasaKonsultanJumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-09"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa Penilai";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-10"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa Aktuaris";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-11"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa akuntansi, pembukuan, dan atestasi laporan keuangan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-12"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa Perancang";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-13"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa pengeboran (jasa drilling) di bidang penambangan minyak dan gas bumi (migas), kecuali yang dilakukan oleh bentuk usaha tetap";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-14"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penunjang di bidang penambangan migas";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-15"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penambangan dan jasa penunjang di bidang penambangan selain migas";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-16"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penunjang di bidang penerbangan dan bandar udara";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-17"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penebangan hutan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-18"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa pengolahan limbah";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-19"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penyedia tenaga kerja";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-20"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa perantara dan/atau keagenan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-21"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa di bidang perdagangan surat-surat berharga, kecuali yang dilakukan oleh Bursa Efek, KSEI dan KPEI";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-23"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa pengisian suara dan/atau sulih suara";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-24"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa mixing film";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-25"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa sehubungan dengan software komputer, termasuk perawatan, pemeliharaan dan perbaikan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-26"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa instalasi/pemasangan mesin";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-27"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa perawatan/perbaikan/pemeliharaan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-28"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa maklon";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-29"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penyelidikan dan keamanan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-30"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penyelenggara kegiatan/event organizer";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-31"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa pengepakan";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-32"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa penyediaan tempat dan/atau waktu dalam media massa, media luar ruang atau media lain untuk penyampaian informasi";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-33"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa pembasmian hama";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-34"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa kebersihan/cleaning service";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}else if($kodePajak == "KP0 PSL23-35"){
					$arrData[$idx]['totalJasaLain']++;
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'label'] = "Jasa catering atau tata boga";
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Bruto'] = $pph['DPP'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'Tarif'] = $pph['TARIF'];
					$arrData[$idx]['jasa'.$arrData[$idx]['totalJasaLain'].'JumlahPotong'] = $pph['JUMLAH_POTONG'];
					$arrData[$idx]['total'] += $pph['JUMLAH_POTONG'];
				}

			endforeach;

			
			//set template
			foreach ($arrData as $datum){
				$pdf->AddPage(); //new page
				$pdf->setSourceFile($fh);
				$tplId = $pdf->importPage(1);
				$pdf->useTemplate($tplId);

				$pdf->SetTextColor(0,0,0); // RGB
				$pdf->SetFont('Helvetica','',9); // Font Name, Font Style (eg. 'B' for Bold), Font Size

				//PARAMETER
				//======================================================
				$guideline = 0; //change to 1 to see field border for every parameter
				$textNo1 = $datum['textNo1']; //Change this value from DB
				$textNo2 = $datum['textNo2']; //Change this value from DB for Number
				$noNPWP = $datum['npwp']; //Change this value from DB for NPWP
				$name = $datum['namaWP']; //Change this value from DB for name
				$address = $datum['addressWP']; //Change this value from DB for address
				$dividenBruto = (isset($datum['dividenBruto'])) ? number_format($datum['dividenBruto']) : ""; //Change this value from DB for Dividen Bruto
				$dividenTidakNPWP = false; //Change this value from DB for Dividen non-NPWP (TRUE/FALSE)
				$dividenTarif = (isset($datum['dividenTarif'])) ? number_format($datum['dividenTarif'])."%" : ""; //Change this value from DB for Percentage Dividen
				$dividenPPHDipotong = (isset($datum['dividenJumlahPotong'])) ? number_format($datum['dividenJumlahPotong']) : ""; //Change this value from DB for PPH Dividen
				$bungaBruto = (isset($datum['bungaBruto'])) ? number_format($datum['bungaBruto']) : "";
				$bungaTidakNPWP = false;
				$bungaTarif = (isset($datum['bungaTarif'])) ? number_format($datum['bungaTarif'])."%" : "";
				$bungaPPHDipotong = (isset($datum['bungaJumlahPotong'])) ? number_format($datum['bungaJumlahPotong']) : "";
				$royaltiBruto = (isset($datum['royaltiBruto'])) ? number_format($datum['royaltiBruto']) : "";
				$royaltiTidakNPWP = false;
				$royaltiTarif = (isset($datum['royaltiTarif'])) ? number_format($datum['royaltiTarif'])."%" : "";
				$royaltiPPHDipotong = (isset($datum['royaltiJumlahPotong'])) ? number_format($datum['royaltiJumlahPotong']) : "";
				$hadiahBruto = (isset($datum['hadiahBruto'])) ? number_format($datum['hadiahBruto']) : "";
				$hadiahTidakNPWP = false;
				$hadiahTarif = (isset($datum['hadiahTarif'])) ? number_format($datum['hadiahTarif'])."%" : "";
				$hadiahPPHDipotong = (isset($datum['hadiahJumlahPotong'])) ? number_format($datum['hadiahJumlahPotong']) : "";
				$sewaBruto = (isset($datum['sewaBruto'])) ? number_format($datum['sewaBruto']) : "";
				$sewaTidakNPWP = false;
				$sewaTarif = (isset($datum['sewaTarif'])) ? number_format($datum['sewaTarif'])."%" : "";
				$sewaPPHDipotong = (isset($datum['sewaJumlahPotong'])) ? number_format($datum['sewaJumlahPotong']) : "";
				$jasaTeknikBruto = (isset($datum['jasaTeknikBruto'])) ? number_format($datum['jasaTeknikBruto']) : "";
				$jasaTeknikTidakNPWP = false;
				$jasaTeknikTarif = (isset($datum['jasaTeknikTarif'])) ? number_format($datum['jasaTeknikTarif'])."%" : "";
				$jasaTeknikPPHDipotong = (isset($datum['jasaTeknikJumlahPotong'])) ? number_format($datum['jasaTeknikJumlahPotong']) : "";
				$jasaManagemenBruto = (isset($datum['jasaManagemenBruto'])) ? number_format($datum['jasaManagemenBruto']) : "";
				$jasaManagemenTidakNPWP = false;
				$jasaManagemenTarif = (isset($datum['jasaManagemenTarif'])) ? number_format($datum['jasaManagemenTarif'])."%" : "";
				$jasaManagemenPPHDipotong = (isset($datum['jasaManagemenJumlahPotong'])) ? number_format($datum['jasaManagemenJumlahPotong']) : "";
				$jasaKonsultanBruto = (isset($datum['jasaKonsultanBruto'])) ? number_format($datum['jasaKonsultanBruto']) : "";
				$jasaKonsultanTidakNPWP = false;
				$jasaKonsultanTarif = (isset($datum['jasaKonsultanTarif'])) ? number_format($datum['jasaKonsultanTarif'])."%" : "";
				$jasaKonsultanPPHDipotong = (isset($datum['jasaKonsultanJumlahPotong'])) ? number_format($datum['jasaKonsultanJumlahPotong']) : "";
				$jasaLain1Text = (isset($datum['jasa1label'])) ? $datum['jasa1label'] : "";
				$jasaLain1Bruto = (isset($datum['jasa1Bruto'])) ? number_format($datum['jasa1Bruto']) : "";
				$jasaLain1TidakNPWP = false;
				$jasaLain1Tarif = (isset($datum['jasa1Tarif'])) ? number_format($datum['jasa1Tarif'])."%" : "";
				$jasaLain1PPHDipotong = (isset($datum['jasa1JumlahPotong'])) ? number_format($datum['jasa1JumlahPotong']) : "";
				$jasaLain2Text = (isset($datum['jasa2label'])) ? $datum['jasa2label'] : "";
				$jasaLain2Bruto = (isset($datum['jasa2Bruto'])) ? number_format($datum['jasa2Bruto']) : "";
				$jasaLain2TidakNPWP = false;
				$jasaLain2Tarif = (isset($datum['jasa2Tarif'])) ? number_format($datum['jasa2Tarif'])."%" : "";
				$jasaLain2PPHDipotong = (isset($datum['jasa2JumlahPotong'])) ? number_format($datum['jasa2JumlahPotong']) : "";
				$jasaLain3Text = (isset($datum['jasa3label'])) ? $datum['jasa3label'] : "";
				$jasaLain3Bruto = (isset($datum['jasa3Bruto'])) ? number_format($datum['jasa3Bruto']) : "";
				$jasaLain3TidakNPWP = false;
				$jasaLain3Tarif = (isset($datum['jasa3Tarif'])) ? number_format($datum['jasa3Tarif'])."%" : "";
				$jasaLain3PPHDipotong = (isset($datum['jasa3JumlahPotong'])) ? number_format($datum['jasa3JumlahPotong']) : "";
				$jasaLain4Text = (isset($datum['jasa4label'])) ? $datum['jasa4label'] : "";
				$jasaLain4Bruto = (isset($datum['jasa4Bruto'])) ? number_format($datum['jasa4Bruto']) : "";
				$jasaLain4TidakNPWP = false;
				$jasaLain4Tarif = (isset($datum['jasa4Tarif'])) ? number_format($datum['jasa4Tarif'])."%" : "";
				$jasaLain4PPHDipotong = (isset($datum['jasa4JumlahPotong'])) ? number_format($datum['jasa4JumlahPotong']) : "";
				$jasaLain5Text = (isset($datum['jasa5label'])) ? $datum['jasa5label'] : "";
				$jasaLain5Bruto = (isset($datum['jasa5Bruto'])) ? number_format($datum['jasa5Bruto']) : "";
				$jasaLain5TidakNPWP = false;
				$jasaLain5Tarif = (isset($datum['jasa5Tarif'])) ? number_format($datum['jasa5Tarif'])."%" : "";
				$jasaLain5PPHDipotong = (isset($datum['jasa5JumlahPotong'])) ? number_format($datum['jasa5JumlahPotong']) : "";
				$jasaLain6Text = (isset($datum['jasa6label'])) ? $datum['jasa6label'] : "";
				$jasaLain6Bruto = (isset($datum['jasa6Bruto'])) ? number_format($datum['jasa6Bruto']) : "";
				$jasaLain6TidakNPWP = false;
				$jasaLain6Tarif = (isset($datum['jasa6Tarif'])) ? number_format($datum['jasa6Tarif'])."%" : "";
				$jasaLain6PPHDipotong = (isset($datum['jasa6JumlahPotong'])) ? number_format($datum['jasa6JumlahPotong']) : "";
				$total = number_format($datum['total']);
				$terbilang = $this->terbilang($datum['total'])." Rupiah";
				$Lokasi = $datum['lokasiPP'];
				$tanggalBulan = substr($datum['tanggalFaktur'], 0, -2);
				$tahun = substr($datum['tanggalFaktur'], -2); //YY
				$noNPWPPemotong = $datum['npwpPP'];
				$namaPemotong = $datum['namaPP'];
				//======================================================

				//for Number 1
				//======================================================
				$pdf->SetXY(38, 29);
				$pdf->Cell(65,1,$textNo1,$guideline,1,"C");
				//======================================================

				//for Number 2
				//======================================================
				$pdf->SetXY(70, 47);
				$pdf->Cell(80,1,$textNo2,$guideline,1,"C");
				//======================================================

				//NPWP
				//======================================================
				$noNPWP = str_replace('.','',$noNPWP);
				$noNPWP = str_replace('-','',$noNPWP);
				$height = 56.9;

				$npwp1 = substr ( $noNPWP, 0, 1 );
				$pdf->SetXY(44.7, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $noNPWP, 1, 1 );
				$pdf->SetXY(50, $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $noNPWP, 2, 1 );
				$pdf->SetXY(60.7, $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $noNPWP, 3, 1 );
				$pdf->SetXY(66, $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $noNPWP, 4, 1 );
				$pdf->SetXY(71.3, $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $noNPWP, 5, 1 );
				$pdf->SetXY(81.8, $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $noNPWP, 6, 1 );
				$pdf->SetXY(87.2, $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $noNPWP, 7, 1 );
				$pdf->SetXY(92.5, $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $noNPWP, 8, 1 );
				$pdf->SetXY(103, $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $noNPWP, 9, 1 );
				$pdf->SetXY(113.6, $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $noNPWP, 10, 1 );
				$pdf->SetXY(119, $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $noNPWP, 11, 1 );
				$pdf->SetXY(124.3, $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $noNPWP, 12, 1 );
				$pdf->SetXY(134.7, $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $noNPWP, 13, 1 );
				$pdf->SetXY(140, $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $noNPWP, 14, 1 );
				$pdf->SetXY(145.3, $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//NAME
				//======================================================
				$name = strtoupper($name);
				$nameStart = 44.7;
				$nameSpace = 5.3;
				for($i = 0; $i < strlen($name); $i++){
					$pdf->SetXY($nameStart + ($nameSpace * $i), 62.9);
					$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//ADDRESS
				//======================================================
				$address = strtoupper($address);
				$addressStart = 44.7;
				$addressSpace = 5.3;
				for($i = 0; $i < strlen($address); $i++){
					$pdf->SetXY($addressStart + ($addressSpace * $i), 68.7);
					$pdf->Cell(4,1,substr ( $address, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//DIVIDEN
				//======================================================
				$height = 94.7;
				$bruto = $dividenBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($dividenTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$dividenTarif,$guideline,1,"C");

				$pphDipotong = $dividenPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//BUNGA
				//======================================================
				$height = 100.8;
				$bruto = $bungaBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($bungaTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$bungaTarif,$guideline,1,"C");

				$pphDipotong = $bungaPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//ROYALTI
				//======================================================
				$height = 106.6;
				$bruto = $royaltiBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($royaltiTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$royaltiTarif,$guideline,1,"C");

				$pphDipotong = $royaltiPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//HADIAH
				//======================================================
				$height = 112.6;
				$bruto = $hadiahBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($hadiahTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$hadiahTarif,$guideline,1,"C");

				$pphDipotong = $hadiahPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//SEWA
				//======================================================
				$height = 128;
				$bruto = $sewaBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($sewaTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$sewaTarif,$guideline,1,"C");

				$pphDipotong = $sewaPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA TEKNIK
				//======================================================
				$height = 147.4;
				$bruto = $jasaTeknikBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaTeknikTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaTeknikTarif,$guideline,1,"C");

				$pphDipotong = $jasaTeknikPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA MANAGEMEN
				//======================================================
				$height = 153.5;
				$bruto = $jasaManagemenBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaManagemenTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaManagemenTarif,$guideline,1,"C");

				$pphDipotong = $jasaManagemenPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA KONSULTAN
				//======================================================
				$height = 159.6;
				$bruto = $jasaKonsultanBruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaKonsultanTidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaKonsultanTarif,$guideline,1,"C");

				$pphDipotong = $jasaKonsultanPPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 1
				//======================================================
				$height = 170.2;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain1Text,$guideline,1,"L");

				$bruto = $jasaLain1Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain1TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain1Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain1PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 2
				//======================================================
				$height = 176.3;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain2Text,$guideline,1,"L");

				$bruto = $jasaLain2Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain2TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain2Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain2PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 3
				//======================================================
				$height = 182.4;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain3Text,$guideline,1,"L");

				$bruto = $jasaLain3Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain3TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain3Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain3PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 4
				//======================================================
				$height = 188.4;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain4Text,$guideline,1,"L");

				$bruto = $jasaLain4Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain4TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain4Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain4PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 5
				//======================================================
				$height = 194.5;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain5Text,$guideline,1,"L");

				$bruto = $jasaLain5Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain5TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain5Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain5PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//JASA LAIN 6
				//======================================================
				$height = 200.6;

				$pdf->SetXY(32, $height);
				$pdf->Cell(35,1,$jasaLain6Text,$guideline,1,"L");

				$bruto = $jasaLain6Bruto;
				$pdf->SetXY(72, $height);
				$pdf->Cell(40,1,$bruto,$guideline,1,"R");

				if($jasaLain6TidakNPWP){
					$pdf->SetXY(124.2, $height);
					$pdf->Cell(4,1,"V",$guideline,1,"C");
				}

				$pdf->SetXY(141, $height);
				$pdf->Cell(13,1,$jasaLain6Tarif,$guideline,1,"C");

				$pphDipotong = $jasaLain6PPHDipotong;
				$pdf->SetXY(156.5, $height);
				$pdf->Cell(40,1,$pphDipotong,$guideline,1,"R");
				//======================================================

				//TOTAL
				//======================================================
				$total = $total;
				$pdf->SetXY(156.5, 210.7);
				$pdf->Cell(40,1,$total,$guideline,1,"R");
				//======================================================

				//TERBILANG
				//======================================================
				$pdf->SetXY(28, 215.3);
				$pdf->Cell(170,1,$terbilang,$guideline,1,"L");
				//======================================================

				//TANGGAL
				//======================================================
				$height = 230.4;
				$pdf->SetXY(107, $height);
				$pdf->Cell(24,1,$Lokasi,$guideline,1,"R");

				$pdf->SetXY(134, $height);
				$pdf->Cell(24,1,$tanggalBulan,$guideline,1,"R");

				$pdf->SetXY(165, $height);
				$pdf->Cell(8,1,$tahun,$guideline,1,"L");
				//======================================================

				//NPWP PEMOTONG
				//======================================================
				$noNPWPPemotong = str_replace('.','',$noNPWPPemotong);
				$noNPWPPemotong = str_replace('-','',$noNPWPPemotong);
				$height = 249;
				$npwp1 = substr ( $noNPWPPemotong, 0, 1 );
				$pdf->SetXY(92.3, $height);
				$pdf->Cell(4,1,$npwp1,$guideline,1,"C");

				$npwp2 = substr ( $noNPWPPemotong, 1, 1 );
				$pdf->SetXY(97.6, $height);
				$pdf->Cell(4,1,$npwp2,$guideline,1,"C");

				$npwp3 = substr ( $noNPWPPemotong, 2, 1 );
				$pdf->SetXY(108.2, $height);
				$pdf->Cell(4,1,$npwp3,$guideline,1,"C");

				$npwp4 = substr ( $noNPWPPemotong, 3, 1 );
				$pdf->SetXY(113.5, $height);
				$pdf->Cell(4,1,$npwp4,$guideline,1,"C");

				$npwp5 = substr ( $noNPWPPemotong, 4, 1 );
				$pdf->SetXY(118.8, $height);
				$pdf->Cell(4,1,$npwp5,$guideline,1,"C");

				$npwp6 = substr ( $noNPWPPemotong, 5, 1 );
				$pdf->SetXY(129.4, $height);
				$pdf->Cell(4,1,$npwp6,$guideline,1,"C");

				$npwp7 = substr ( $noNPWPPemotong, 6, 1 );
				$pdf->SetXY(134.7, $height);
				$pdf->Cell(4,1,$npwp7,$guideline,1,"C");

				$npwp8 = substr ( $noNPWPPemotong, 7, 1 );
				$pdf->SetXY(140, $height);
				$pdf->Cell(4,1,$npwp8,$guideline,1,"C");

				$npwp9 = substr ( $noNPWPPemotong, 8, 1 );
				$pdf->SetXY(150.6, $height);
				$pdf->Cell(4,1,$npwp9,$guideline,1,"C");

				$npwp10 = substr ( $noNPWPPemotong, 9, 1 );
				$pdf->SetXY(161.2, $height);
				$pdf->Cell(4,1,$npwp10,$guideline,1,"C");

				$npwp11 = substr ( $noNPWPPemotong, 10, 1 );
				$pdf->SetXY(166.5, $height);
				$pdf->Cell(4,1,$npwp11,$guideline,1,"C");

				$npwp12 = substr ( $noNPWPPemotong, 11, 1 );
				$pdf->SetXY(171.8, $height);
				$pdf->Cell(4,1,$npwp12,$guideline,1,"C");

				$npwp13 = substr ( $noNPWPPemotong, 12, 1 );
				$pdf->SetXY(182.4, $height);
				$pdf->Cell(4,1,$npwp13,$guideline,1,"C");

				$npwp14 = substr ( $noNPWPPemotong, 13, 1 );
				$pdf->SetXY(187.7, $height);
				$pdf->Cell(4,1,$npwp14,$guideline,1,"C");

				$npwp15 = substr ( $noNPWPPemotong, 14, 1 );
				$pdf->SetXY(193, $height);
				$pdf->Cell(4,1,$npwp15,$guideline,1,"C");
				//======================================================

				//NAME PEMOTONG
				//======================================================
				$name = strtoupper($namaPemotong);
				$nameStart = 92.3;
				$nameSpace = 5.3;
				for($i = 0; $i < strlen($name); $i++){
					$pdf->SetXY($nameStart + ($nameSpace * $i), 258.5);
					$pdf->Cell(4,1,substr ( $name, $i, 1 ),$guideline,1,"C");
				}
				//======================================================

				//TTD
				//======================================================
				$pdf->SetXY(115.5, 293);
				$pdf->Cell(50,1,strtoupper($namaPemotong),$guideline,1,"C");
				//======================================================
			}
		}

		//display pdf
		$pdf->Output();
	}

	function cetak_bupot()
	{
		
		$cabang			= $this->session->userdata('kd_cabang');
		$tahun 			= $_REQUEST['tahun'];
		$bulan 			= $_REQUEST['bulan'];
		$pembetulan 	= $_REQUEST['pembetulanKe'];
		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Cetak Bupot")
								->setSubject("Cetakan")
								->setDescription("Cetak Bupot")
								->setKeywords("pph21");
								
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_row_ttd = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);

		$style_row_jabatan = array(
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);

		$style_row_right = array(
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_row_centre = array(
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		  ),
		);

		$style_row_jud = array(
		   'alignment' => array(
		 	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi di tengah secara vertical (middle)
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "No");
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true); 
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Masa Pajak");
		$excel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('B2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('C2', "Tahun Pajak");
		$excel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('C2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('D2', "Tanggal Pemotongan (dd/MM/yyyy)");
		$excel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('D2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('E2', "Ber-NPWP ? (Y/N)");
		$excel->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('E2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('F2', "NPWP (Tanpa format/tanda baca)");
		$excel->getActiveSheet()->getStyle('F2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('F2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('G2', "NIK (tanpa format/tanda baca)");
		$excel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('G2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('H2', "Kode Objek Pajak");
		$excel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('H2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('I2', "Penanda tangan BP Pengurus ? (Y/N)");
		$excel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('I2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('J2', "Penghasilan Bruto");
		$excel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('J2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('K2', "Mendapatkan Fasilitas ? (N/SKB/DTP)");
		$excel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('K2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('L2', "Nomor SKB");
		$excel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('L2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('M2', "Tgl Pengesahan SKB (dd/MM/yyyy)");
		$excel->getActiveSheet()->getStyle('M2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('M2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('N2', "Tgl Berlaku SKB s.d ? (dd/MM/yyyy)");
		$excel->getActiveSheet()->getStyle('N2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('N2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('O2', "No Aturan DTP");
		$excel->getActiveSheet()->getStyle('O2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('O2')->applyFromArray($style_row_jud);

		$excel->setActiveSheetIndex(0)->setCellValue('P2', "NTPN DTP");
		$excel->getActiveSheet()->getStyle('P2')->getAlignment()->setWrapText(true);
		$excel->getActiveSheet()->getStyle('P2')->applyFromArray($style_row_jud);

		$query = "SELECT spl.bulan_pajak masa_pajak,
					       spl.tahun_pajak,
					       TO_CHAR (spl.tgl_bukti_potong, 'dd/mm/yyyy') tgl_pemotongan,
					       CASE
					          WHEN spl.npwp IS NULL THEN 'N'
					          WHEN spl.npwp = '000000000000000' THEN 'N'
					          WHEN spl.npwp = '-' THEN 'N'
					          ELSE 'Y'
					       END
					          ber_npwp,
					       replace(replace(spl.npwp, '.',''),'-','') npwp,
					       NULL NIK,
					       smp23.kode_objek_pajak,
					       'Y' penanda_tangan,
					       NVL (spl.new_dpp, spl.dpp) penghasilan_bruto,
					       NULL mendapatkan_fasilitas,
					       NULL nomor_skb,
					       NULL tgl_pengesahan,
					       NULL tgl_berlaku_skb,
					       NULL nomor_aturan_dtp,
					       NULL ntpn_dtp
					  FROM simtax_pajak_lines spl, SIMTAX_MASTER_PPH23 smp23
					 WHERE spl.bulan_pajak = '".$bulan."'
					 	   AND spl.tahun_pajak = '".$tahun."'
					 	   AND spl.pembetulan_ke = '".$pembetulan."'
					 	   AND spl.kode_cabang = '".$cabang."'
					       AND spl.is_cheklist = 1
					       AND NVL (spl.new_kode_pajak,
					                spl.kode_pajak) = smp23.dff ";

		$sql = $this->db->query($query);

		$no = 1;
		$numrow = 3;

		foreach($sql->result_array() as $row) {

			$npwp = ($row['NPWP']) ? $row['NPWP'] : "000000000000000";

			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['MASA_PAJAK']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['TAHUN_PAJAK']);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->getNumberFormat()->setFormatCode('0');
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row['TGL_PEMOTONGAN']);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->getNumberFormat()->setFormatCode('@');
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['BER_NPWP']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $npwp);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['NIK']);
			$excel->getActiveSheet()->getStyle('G'.$numrow.':H'.$numrow)->getNumberFormat()->setFormatCode('@');
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['KODE_OBJEK_PAJAK']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['PENANDA_TANGAN']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row['PENGHASILAN_BRUTO']);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row['MENDAPATKAN_FASILITAS']);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row['NOMOR_SKB']);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row['TGL_PENGESAHAN']);
			$excel->getActiveSheet()->getStyle('M'.$numrow.':P'.$numrow)->getNumberFormat()->setFormatCode('@');
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row['TGL_BERLAKU_SKB']);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $row['NOMOR_ATURAN_DTP']);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $row['NTPN_DTP']);

			$no++;
			$numrow++;

		}	
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom E
		
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("BUPOT");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="BUPOT.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	function load_ntpn()
	{	
		
		$kode_cabang = $this->input->post('_searchKodeCabang');
		if ($kode_cabang == "all"){
				$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
			}
			else{
				$whereCabang = "'".$kode_cabang."'";
			}
		$tahun_pajak   = $this->input->post('_searchTahun');
		$jenis_pajak   = $this->input->post('_searchJenisPajak');

			$permission = true;
		

		$result['data']            = "";
		$result['draw']            = "";
		$result['recordsTotal']    = 0;
		$result['recordsFiltered'] = 0;
		
		if($permission === true)
		{

			$start       = ($this->input->post('start')) ? $this->input->post('start') : 0;
			$length      = ($this->input->post('length')) ? $this->input->post('length') : 10;
			$draw        = ($this->input->post('draw')) ? $this->input->post('draw') : 0;
			$keywords    = (isset($_POST['search'])) ? $_POST['search']['value'] : '';

			$hasil    = $this->pph->get_ntpn($tahun_pajak, $jenis_pajak, $whereCabang, $start, $length, $keywords);

			$rowCount = $hasil['jmlRow'] ;
			$query    = $hasil['query'];
			if ($rowCount>0){
				$ii	=	0;
				foreach($query->result_array() as $row)	{
						$ii++;	
						

						$result['data'][] = array(
									'id'            => $row['ID'],
									'no'            => $row['RNUM'],
									'kode_cabang'	=> $row['KODE_CABANG'],
									'nama_cabang'	=> get_nama_cabang($row['KODE_CABANG']),
									'pembetulan'    => $row['PEMBETULAN'],
									'bulan'         => $row['BULAN'],
									'nama_bulan'    => get_masa_pajak($row['BULAN'],"id", true),
									'tahun'         => $row['TAHUN'],
									'ntpn'          => $row['NTPN'],
									'jenis_pajak'	=> $row['JENIS_PAJAK'],
									'bank'          => $row['BANK'],
									'tanggal_setor' => $row['TANGGAL_SETOR'],
									'tanggal_lapor' => $row['TANGGAL_LAPOR'],
									'nominal'		=> $row['NOMINAL']
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
			$query->free_result();

		}

		echo json_encode($result);
    }

    function save_ntpn(){
		
		$return        = false;
		
		$id            = $this->input->post('id');
		$kode_cabang   = $this->input->post('kd_cabangs');
		$isnewRecord   = $this->input->post('isnewRecord');
		$bulan_pajak   = $this->input->post('bulan_pajak');
		$tahun_pajak   = $this->input->post('tahun_pajak');
		$pembetulan_ke = $this->input->post('pembetulan_pajak');
		$ntpn          = $this->input->post('ntpn');
		$bank          = $this->input->post('bank');
		$jenis_pajak   = $this->input->post('jenisPajaks');
		$tanggal_setor = ($this->input->post('tanggal_setor')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggal_setor')))) :'';
		$tanggal_lapor = ($this->input->post('tanggal_lapor')) ? date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('tanggal_lapor')))) :'';
		$nominal       = $this->input->post('nominal');

		$data = array(
						'BULAN'       => $bulan_pajak,
						'TAHUN'       => $tahun_pajak,
						'PEMBETULAN'  => $pembetulan_ke,
						'NTPN'        => $ntpn,
						'JENIS_PAJAK' => $jenis_pajak,
						'BANK'        => $bank,
						'KODE_CABANG' => $kode_cabang,
						'NOMINAL'	  => $nominal
					);

		$check = $this->pph->check_ntpn($id,  $bulan_pajak, $tahun_pajak, $pembetulan_ke, $jenis_pajak, $kode_cabang, $ntpn);
		//add validasi ntpn 27032019

		if($check > 0){ 
			echo '2'; 
		} 
		else{ 
			
			if($isnewRecord == "0"){
				if ($this->pph->update_ntpn($id, $data, $tanggal_setor, $tanggal_lapor)) {
					echo '1';
				}
				else{
					echo '0';
				}

			}else{
				if ($this->pph->add_ntpn($data, $tanggal_setor, $tanggal_lapor)) {
					echo '1';
				}
				else{
					echo '0';
				}
			}
		} 
	}

	function delete_ntpn()
	{
		$id   = $this->input->post('id');

		$data = $this->pph->delete_ntpn($id);

		if($data){
			echo '1';
		} else {
			echo '0';
		}
	}
	//------------------------------------------------------------------------

	function export_kode_pajak(){
		
		$this->load->helper('csv_helper');
		$nama_pajak = ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
		$nmcabang   = get_nama_cabang($this->session->userdata('kd_cabang'));
		
		$export_arr = array();
		$dataArr    = array();
		$data       = $this->pph->get_kode_pajak($nama_pajak);
		
		$title      = array("TAX_CODE", "DESCRIPTION", "TAX_RATE", "KODE_PAJAK");

		if($nama_pajak     == "PPH PSL 23 DAN 26"){
			array_push($title, "JENIS_23");
		}

        array_push($export_arr, $title);

		if (!empty($data)) {         
			foreach($data->result_array() as $row)	{

				$dataArr = array($row['TAX_CODE'], $row['DESCRIPTION'], $row['TAX_RATE'], $row['KODE_PAJAK']);

		        if($nama_pajak == "PPH PSL 23 DAN 26"){
		        	array_push($dataArr, $row['JENIS_23']);
		        }
				array_push($export_arr, $dataArr);
			}
        }

        convert_to_csv($export_arr, 'KODE_PAJAK '.$nama_pajak.' '.strtoupper($nmcabang).'.csv', ';');
	}
		
}