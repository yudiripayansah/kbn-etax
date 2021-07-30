<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetakan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
	    if (!$this->ion_auth->logged_in())
	    {
	    	redirect('dashboard', 'refresh');
	    }

		$this->load->model('cabang_mdl');
		$this->load->model('Pph_badan_mdl');
		$this->load->model('Pph_mdl');
	}


	function show_equal_pph_all()
	{
		$this->template->set('title', 'Laporan Ekualisasi PPh');
		$data['subtitle']	= "Cetak Laporan Ekualisasi PPh";
		$data['activepage'] = "laporan_ekualisasi";
		$this->template->load('template', 'laporan/lap_equalisasi_pph', $data);
	}

	function cetak_equal_pph_xls()
	{

		$pajak 		= $_REQUEST['pajak'];
		$nmpajak 	= $_REQUEST['nmpajak'];
		$tahun 		= $_REQUEST['tahun'];
		$bulan		= $_REQUEST['bulan'];
		$masa		= $_REQUEST['namabulan'];
		$cabang		= $_REQUEST['kd_cabang'];
		
		if ($pajak == "PPH PSL 15"){
			$this->cetak_ekualisasi_pph15($pajak, $nmpajak, $tahun, $bulan, $masa, $cabang);
		} else if ($pajak == "PPH PSL 22" || $pajak == "PPH PSL 23 DAN 26"){
			$this->cetak_ekualisasi_pph23_26($pajak, $nmpajak, $tahun, $bulan, $masa, $cabang);
		} else if($pajak == "PPH PSL 4 AYAT 2"){
			$this->cetak_ekualisasi_pph4_ayat2($pajak, $nmpajak, $tahun, $bulan, $masa, $cabang);
		}
	}

	function cetak_ekualisasi_pph15($pajak,$nmpajak,$tahun,$bulan,$masa,$cabang)
	{
		$header_id   = $this->Pph_mdl->get_header_id_max($pajak,$bulan,$tahun,$cabang);
		$where       = "";
		$where_23    = "";
		$nama_cabang = strtoupper(get_nama_cabang($cabang));
		$header      = "and sph.pajak_header_id= '".$header_id."' ";
		$header1     = "--and sph.pajak_header_id= '".$header_id."' ";

		$nama_bulan = get_masa_pajak($bulan,'id',true);

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
			$header_id = $header;
		} else{
			$kd_cabang = "";
			$header = $header1;
		}

		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Laporan Ekualisasi ".$nmpajak)
								->setSubject("Ekualisasi")
								->setDescription("Laporan Ekualisasi ".$nmpajak)
								->setKeywords($nmpajak);

		$center_bold_border = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => false),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_noborder = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);

		$center_nobold_noborder = array(
		        'font' => array('bold' => false), 
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);
		
		$center_bold_border_bottom_left = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_border_top = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
			 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),			
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_border_bottom = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(			 
			 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$left_bold_border = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$noborder_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$noborder_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$border_top_buttom_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kiri = array(
		    'borders' => array(  	 
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kanan = array(
		    'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		  )
		);
		
		$border_bawah = array(
		    'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);

		$noborder_rata_kiri = array(
		        'font' => array('name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);

		$center_border = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);

		$kantor = "";

		if($cabang == 'all'){
			$kantor = "PT PELABUHAN INDONESIA II (PERSERO)";
		}else{
			$kantor = "PT PELABUHAN INDONESIA II CABANG ".$nama_cabang;
		}
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', $kantor);
		$excel->getActiveSheet()->mergeCells('B1:D1');
		$excel->getActiveSheet()->getStyle('B1:D1')->applyFromArray($noborder_bold_rata_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Ekualisasi Objek ".$nmpajak." :");
		$excel->getActiveSheet()->mergeCells('B2:D2');
		$excel->getActiveSheet()->getStyle('B2:D2')->applyFromArray($noborder_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan ".$nama_bulan);
		$excel->getActiveSheet()->mergeCells('B3:E3');
		$excel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($noborder_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('F4:H4');
		$excel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('I4', "Keterangan");
		$excel->getActiveSheet()->mergeCells('I4:I5');
		$excel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Account");
		$excel->getActiveSheet()->mergeCells('B4:B5');
		$excel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Uraian");
		$excel->getActiveSheet()->mergeCells('C4:C5');
		$excel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Klas");
		$excel->getActiveSheet()->mergeCells('D4:D5');
		$excel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Jumlah Biaya");
		$excel->getActiveSheet()->mergeCells('E4:E5');
		$excel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Objek PPh Pasal 15");
		$excel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Bukan Objek");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "PPh Pasal 15");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_border);
		
		// end header	
		$no = 1; 
		$numrow = 6;
		$numrowBorderStart = 6;

		if ($kd_cabang == ""){
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else{
			$whereCabang = "'".$kd_cabang."'";
		}
		
			$where		.= " and kode_cabang in (".$whereCabang.") ";
			$where_23	.= " and sph.kode_cabang in (".$whereCabang.") ";
		if($bulan) {
			$where 		.= " and bulan_pajak= '".$bulan."' ";
			$where_23 	.= " and sph.bulan_pajak= '".$bulan."' ";
		}
		$queryExecSub8 = "Select tb.kode_akun
							, o23.kode_akun kd23
							, tb.akun_description
							, tb.jumlah_tb1 jumlah_tb
							, nvl(O23.nil_objek_23,0) nil23
							, case	
								when SUBSTR(TB.kode_akun,1,1)=8 then 1
								when SUBSTR(TB.kode_akun,1,2)=31 then 2
								when SUBSTR(TB.kode_akun,1,3)=207 then 3
								when SUBSTR(TB.kode_akun,1,3) between 103 and 106 then 4
								when SUBSTR(TB.kode_akun,1,3) in (203,110,107) then 5
								when SUBSTR(TB.kode_akun,1,3) in (208,209) then 6
								else 7
							  end
								urut
							from
								(
								Select kode_akun, akun_description
										, (sum(nvl(DEBIT,0)) - sum(nvl(CREDIT,0))) jumlah_tb1
									from SIMTAX_RINCIAN_BL_PPH_BADAN 
									where tahun_pajak= '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by kode_akun, akun_description
								) tb,
								(
									select kode_akun,sum(begin_balance) begin_balance from (
										select kode_akun, kode_cabang, begin_balance
										from simtax_rincian_bl_pph_badan
										where tahun_pajak = '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
										group by kode_akun, kode_cabang, begin_balance
									)
									group by kode_akun
								) bb,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_23 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."' 
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										".$header."
										and Substr(SPL.GL_ACCOUNT,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by SPL.GL_ACCOUNT
								) o23
						 where tb.KODE_AKUN=O23.KODE_AKUN (+)
							   and tb.KODE_AKUN=bb.KODE_AKUN (+)
						 order by urut, TB.KODE_AKUN";
		
			$querySub8			= $this->db->query($queryExecSub8);
			$sum_tb            = 0;
			$sum_bukan_objek23 = 0;
			$sum_objek23       = 0;
			foreach($querySub8->result_array() as $row)	{
				// List Akun		
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['KODE_AKUN']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['AKUN_DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JUMLAH_TB']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUMLAH_TB']-$row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, "");
				
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
				$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
				$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
									
				$sum_tb            += $row['JUMLAH_TB'];
				$sum_bukan_objek23 += ($row['JUMLAH_TB']-$row['NIL23']);
				$sum_objek23       += $row['NIL23'];
				$numrow++;
		}

		$numrow += 1;
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "Total Objek PPh 15");
		$excel->getActiveSheet()->mergeCells('B'.$numrow.':D'.$numrow);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_tb);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_objek23);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_bukan_objek23);
				
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($noborder_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(2); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(60); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(8); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(2); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Lap Equal ".$nmpajak);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Ekualisasi '.$nmpajak.' '.$masa.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}
		
	function cetak_ekualisasi_pph23_26($pajak,$nmpajak,$tahun,$bulan,$masa,$cabang)
	{
		$header_id		= $this->Pph_mdl->get_header_id_max($pajak,$bulan,$tahun,$cabang);
		$where			= "";
		$where_23		= "";
		$nama_cabang 	= strtoupper(get_nama_cabang($cabang));
		$header 		= "and sph.pajak_header_id= '".$header_id."' ";
		$header1 		= "--and sph.pajak_header_id= '".$header_id."' ";

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
			$header_id = $header;
		} else{
			$kd_cabang = "";
			$header = $header1;
		}	
				
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Laporan Ekualisasi ".$nmpajak)
								->setSubject("Ekualisasi")
								->setDescription("Laporan Ekualisasi ".$nmpajak)
								->setKeywords($nmpajak);

		$center_bold_border = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => false),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_noborder = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);

		$center_nobold_noborder = array(
		       'font' => array('bold' => true, 
								'name' => 'Calibri',
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$noborder_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$noborder_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kiri = array(
		    'borders' => array(  	 
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kanan = array(
		    'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		  )
		);
		
		$border_bawah = array(
		    'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);

		$kantor = "";

		if($cabang == 'all'){
			$kantor = "PT PELABUHAN INDONESIA II (PERSERO)";
		}else{
			$kantor = "PT PELABUHAN INDONESIA II CABANG ".$nama_cabang;
		}	
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', $kantor);
		$excel->getActiveSheet()->mergeCells('B1:D1');
		$excel->getActiveSheet()->getStyle('B1:D1')->applyFromArray($noborder_bold_rata_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Ekualisasi Objek ".$nmpajak." :");
		$excel->getActiveSheet()->mergeCells('B2:D2');

		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan");
		$excel->getActiveSheet()->mergeCells('B3:D3');
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan : ".$masa." ".$tahun);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Account");
		$excel->getActiveSheet()->mergeCells('B4:B5');
		$excel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Uraian");
		$excel->getActiveSheet()->mergeCells('C4:C5');
		$excel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Klas");
		$excel->getActiveSheet()->mergeCells('D4:D5');
		$excel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Jumlah Biaya");
		$excel->getActiveSheet()->mergeCells('E4:E5');
		$excel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('F4:H4');
		$excel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($center_no_bold_border);
		
		if($pajak == "PPH PSL 23 DAN 26"){
			$title_header = "23";
		} else {
			$title_header = "22";
		}

		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Objek ".$title_header);
		$excel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Bukan Objek ".$title_header);
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('I4', "Keterangan");
		$excel->getActiveSheet()->mergeCells('I4:I5');
		$excel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($center_no_bold_border);
		
		
		// end header	
			//$no = 1; 
			$numrow = 6;
			$numrowBorderStart = 6;

			if ($kd_cabang == ""){
				$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
			} else{
				$whereCabang = "'".$kd_cabang."'";
			}
			
			$tot_tb        = 0;
			$tot_obj22     = 0;
			$tot_bkn_obj22 = 0;

			$where		.= " and kode_cabang in (".$whereCabang.") ";
			$where_23	.= " and sph.kode_cabang in (".$whereCabang.") ";
			if($bulan) {
				$where 		.= " and bulan_pajak= '".$bulan."' ";
				$where_23 	.= " and sph.bulan_pajak= '".$bulan."' ";
			}
				$queryExecSub8 = "Select tb.kode_akun	
									, o23.kode_akun kd23
									, tb.akun_description
									, tb.jumlah_tb1 jumlah_tb
									, nvl(O23.nil_objek_23,0) nil23
									, case
										when SUBSTR(TB.kode_akun,1,1)=8 then 1
										when SUBSTR(TB.kode_akun,1,2)=31 then 2
										when SUBSTR(TB.kode_akun,1,3)=207 then 3
										when SUBSTR(TB.kode_akun,1,3) between 103 and 106 then 4
										when SUBSTR(TB.kode_akun,1,3) in (203,110,107) then 5
										when SUBSTR(TB.kode_akun,1,3) in (208,209) then 6
										else 7
									  end
										urut
									from
										(
										Select kode_akun, akun_description
												, (sum(nvl(DEBIT,0)) - sum(nvl(CREDIT,0))) jumlah_tb1 	
											from SIMTAX_RINCIAN_BL_PPH_BADAN 
											where tahun_pajak= '".$tahun."' 
												".$where." 
												and (
														SUBSTR(kode_akun,1,1)=8 
														or SUBSTR(kode_akun,1,2)=31 
														or SUBSTR(kode_akun,1,3)=207 
														or SUBSTR(kode_akun,1,3) between 103 and 106 
														or SUBSTR(kode_akun,1,3) in (203,110,107)
														or SUBSTR(kode_akun,1,3) in (208,209)
													) 
											group by kode_akun, akun_description 		
										) tb,
										(
											select kode_akun,sum(begin_balance) begin_balance from (
												select kode_akun, kode_cabang, begin_balance
													from simtax_rincian_bl_pph_badan
												where tahun_pajak = '".$tahun."' 
												".$where." 
												and (
														SUBSTR(kode_akun,1,1)=8 
														or SUBSTR(kode_akun,1,2)=31 
														or SUBSTR(kode_akun,1,3)=207 
														or SUBSTR(kode_akun,1,3) between 103 and 106 
														or SUBSTR(kode_akun,1,3) in (203,110,107)
														or SUBSTR(kode_akun,1,3) in (208,209)
													) 
												group by kode_akun, kode_cabang, begin_balance
											)
											group by kode_akun
										) bb,
										(
											select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_23 
											from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
											where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
												and SPH.TAHUN_PAJAK= '".$tahun."' 
												".$where_23."
												and upper(SPL.IS_CHEKLIST) =1												".$header."
												and (
														Substr(SPL.GL_ACCOUNT,1,1)=8 
														or Substr(SPL.GL_ACCOUNT,1,2)=31 
														or Substr(SPL.GL_ACCOUNT,1,3)=207 
														or Substr(SPL.GL_ACCOUNT,1,3) between 103 and 106
														or Substr(SPL.GL_ACCOUNT,1,3) in (203,110,107)
														or Substr(SPL.GL_ACCOUNT,1,3) in (208,209)
													)
											group by SPL.GL_ACCOUNT
										) o23
								 where tb.KODE_AKUN=O23.KODE_AKUN (+)
									and tb.KODE_AKUN=bb.KODE_AKUN (+)
								 order by TB.KODE_AKUN";

						 //print_r($queryExecSub8); die();
				
				$querySub8		           = $this->db->query($queryExecSub8);
				foreach($querySub8->result_array() as $row)	{

					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['KODE_AKUN']);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['AKUN_DESCRIPTION']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JUMLAH_TB']);
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['NIL23']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUMLAH_TB']-$row['NIL23']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, "");

					$tot_tb 			+= $row['JUMLAH_TB'];
					$tot_obj22 			+= $row['JUMLAH_TB']-$row['NIL23'];
					$tot_bkn_obj22 		+= $row['NIL23'];
					
					$excel->getActiveSheet()->getStyle('D'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
					$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
					$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
					$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

					$numrow++;
			}

			$numrow +=1;
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "Total Objek PPh ".$title_header);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tot_tb);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $tot_bkn_obj22);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $tot_obj22);

			$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$numrow++;

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(2); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		
		
		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Lap Equal ".$nmpajak);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Ekualisasi '.$nmpajak.' '.$masa.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}	
	
	function cetak_ekualisasi_pph4_ayat2($pajak,$nmpajak,$tahun,$bulan,$masa,$cabang)
	{
		$header_id	= $this->Pph_mdl->get_header_id_max($pajak,$bulan,$tahun,$cabang);
		$where		= "";
		$where_23	= "";
		$nama_cabang 	= strtoupper(get_nama_cabang($cabang));
		$header 		= "and sph.pajak_header_id= '".$header_id."' ";
		$header1 		= "--and sph.pajak_header_id= '".$header_id."' ";

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
			$header_id = $header;
		} else{
			$kd_cabang = "";
			$header = $header1;
		}	
				
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Laporan Ekualisasi ".$nmpajak)
								->setSubject("Ekualisasi")
								->setDescription("Laporan Ekualisasi ".$nmpajak)
								->setKeywords($nmpajak);

		$center_bold_border = array(
		        'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => false),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_noborder = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);

		$center_nobold_noborder = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);
		
		$center_bold_border_bottom_left = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$noborder_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$noborder_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kiri = array(
		    'borders' => array(  	 
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kanan = array(
		    'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		  )
		);
		
		$border_bawah = array(
		    'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		//buat header cetakan
		$kantor = "";

		if($cabang == 'all'){
			$kantor = "PT PELABUHAN INDONESIA II (PERSERO)";
		}else{
			$kantor = "PT PELABUHAN INDONESIA II CABANG ".$nama_cabang;
		}

		$excel->setActiveSheetIndex(0)->setCellValue('B1', $kantor);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($noborder_bold_rata_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Ekualisasi Objek ".$nmpajak);

		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan ".$masa." ".$tahun);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('F4:H4');
		$excel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('I4', "Keterangan");
		$excel->getActiveSheet()->mergeCells('I4:I5');
		$excel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Account");
		$excel->getActiveSheet()->mergeCells('B4:B5');
		$excel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Uraian");
		$excel->getActiveSheet()->mergeCells('C4:C5');
		$excel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($center_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Klas");
		$excel->getActiveSheet()->mergeCells('D4:D5');
		$excel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($center_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Jumlah Biaya");
		$excel->getActiveSheet()->mergeCells('E4:E5');
		$excel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($center_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Objek 42");
		$excel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($center_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Bukan Objek 42");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_bold_border);
		
		// end header	
		$no = 1; 
		$numrow = 6;
		$numrowBorderStart = 6;

		if ($kd_cabang == ""){
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else{
			$whereCabang = "'".$kd_cabang."'";
		}

		$where		.= " and kode_cabang in (".$whereCabang.") ";
		$where_23	.= " and sph.kode_cabang in (".$whereCabang.") ";
		if($bulan) {
			$where 		.= " and bulan_pajak= '".$bulan."' ";
			$where_23 	.= " and sph.bulan_pajak= '".$bulan."' ";
		}
		$queryExecSub8 = "Select tb.kode_akun	
							, o23.kode_akun kd23
							, tb.akun_description
							, tb.jumlah_tb1 jumlah_tb
							, nvl(O23.nil_objek_23,0) nil23
							, case	
								when SUBSTR(TB.kode_akun,1,1)=8 then 1
								when SUBSTR(TB.kode_akun,1,2)=31 then 2
								when SUBSTR(TB.kode_akun,1,3)=207 then 3
								when SUBSTR(TB.kode_akun,1,3) between 103 and 106 then 4
								when SUBSTR(TB.kode_akun,1,3) in (203,110,107) then 5
								when SUBSTR(TB.kode_akun,1,3) in (208,209) then 6
								else 7
								
							  end
								urut
							from
								(
								  Select kode_akun, akun_description
										, (sum(nvl(DEBIT,0)) - sum(nvl(CREDIT,0))) jumlah_tb1
									from SIMTAX_RINCIAN_BL_PPH_BADAN 
									where tahun_pajak= '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in (106,109,203,206,207,209,301,302,304,306,310,311,801,891)
									group by kode_akun, akun_description
								) tb,
								(
									select kode_akun,sum(begin_balance) begin_balance from (
										select kode_akun, kode_cabang, begin_balance
										from simtax_rincian_bl_pph_badan
										where tahun_pajak = '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in 
										(106,109,203,206,207,209,301,302,304,306,310,311,801,891) 
										group by kode_akun, kode_cabang, begin_balance
									)
									group by kode_akun
								) bb,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_23 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."' 
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										".$header."
										and Substr(SPL.GL_ACCOUNT,1,3) in (106,109,203,206,207,209,301,302,304,306,310,311,801,891)
									group by SPL.GL_ACCOUNT
								) o23
						 where tb.KODE_AKUN=O23.KODE_AKUN (+)
							and tb.KODE_AKUN=bb.KODE_AKUN (+)
						 order by urut, TB.KODE_AKUN";
			
			$querySub8		= $this->db->query($queryExecSub8);
			$sum_tb            = 0;
			$sum_bukan_objek23 = 0;
			$sum_objek23       = 0;
			foreach($querySub8->result_array() as $row)	{
				// List Akun	
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['KODE_AKUN']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['AKUN_DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JUMLAH_TB']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "");
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUMLAH_TB']-$row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, "");

				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($center_nobold_noborder);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
				$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
				$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
				
				$sum_tb            += $row['JUMLAH_TB'];
				$sum_bukan_objek23 += ($row['JUMLAH_TB']-$row['NIL23']);
				$sum_objek23       += $row['NIL23'];
				$numrow++;
				$no++;
		}
		
		$numrow+=1;
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "Total Objek PPh");
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_tb);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_objek23);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_bukan_objek23);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);

		$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(2);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Lap Equal ".$nmpajak);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Ekualisasi '.$nmpajak.' '.$masa.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function show_equal_pph_gab()
	{
		$this->template->set('title', 'Laporan Ekualisasi Semua PPh');
		$data['subtitle']	= "Cetak Laporan Ekualisasi Semua PPh";
		$data['activepage'] = "laporan_ekualisasi";
		$this->template->load('template', 'laporan/lap_equalisasi_gab',$data);
	}

	function cetak_equal_pph_gab()
	{

		$tahun 		= $_REQUEST['tahun'];
		$bulan		= $_REQUEST['bulan'];
		$masa		= $_REQUEST['namabulan'];
		$cabang		= $_REQUEST['kd_cabang'];
		$pajak		= $_REQUEST['pajak'];
		$where		= "";
		$where_23	= "";
		$nama_cabang 	= strtoupper(get_nama_cabang($cabang));

		$nama_bulan 	= get_masa_pajak($bulan,'id',true);

		if ($cabang != 'all'){
			$kd_cabang = $cabang;
		} else{
			$kd_cabang = "";
		}
					
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Laporan Ekualisasi Semua PPh")
								->setSubject("Ekualisasi")
								->setDescription("Laporan Ekualisasi Semua PPh")
								->setKeywords("Gabungan PPh");

		$center_bold_border = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => false),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_noborder = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);

		$center_nobold_noborder = array(
		        'font' => array('bold' => false), 
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  )
		);
		
		$center_bold_border_bottom_left = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_border_top = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
			 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),			
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$center_bold_border_bottom = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(			 
			 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$left_bold_border = array(
		        'font' => array('bold' => true),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$noborder_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$noborder_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
			
		
		$border_top_buttom_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 11,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
		  'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kiri = array(
		    'borders' => array(  	 
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);
		
		$border_kanan = array(
		    'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
		  )
		);
		
		$border_bawah = array(
		    'borders' => array(
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);

		$noborder_rata_kiri = array(
		        'font' => array('name' => 'Calibri', 
								'size' => 11),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);

		$center_border = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
		  )
		);

		$kantor = "";

		if($cabang == 'all'){
			$kantor = "PT PELABUHAN INDONESIA II (PERSERO)";
		}else{
			$kantor = "PT PELABUHAN INDONESIA II CABANG ".$nama_cabang;
		}	
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B1', $kantor);
		$excel->getActiveSheet()->mergeCells('B1:D1');
		$excel->getActiveSheet()->getStyle('B1:D1')->applyFromArray($noborder_bold_rata_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Ekualisasi Objek Semua PPh");
		$excel->getActiveSheet()->mergeCells('B2:D2');
		$excel->getActiveSheet()->getStyle('B2:D2')->applyFromArray($noborder_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan ".$nama_bulan);
		$excel->getActiveSheet()->mergeCells('B3:E3');
		$excel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($noborder_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('F4:H4');
		$excel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Account");
		$excel->getActiveSheet()->mergeCells('B4:B5');
		$excel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Uraian");
		$excel->getActiveSheet()->mergeCells('C4:C5');
		$excel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Klas");
		$excel->getActiveSheet()->mergeCells('D4:D5');
		$excel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Jumlah Biaya");
		$excel->getActiveSheet()->mergeCells('E4:E5');
		$excel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('G5', "Objek PPh Pasal 21");
		$excel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Bukan Objek");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "PPh Pasal 21");
		$excel->getActiveSheet()->getStyle('H5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('I4:J4');
		$excel->getActiveSheet()->getStyle('I4:J4')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I5', "Objek PPh Pasal 15");
		$excel->getActiveSheet()->getStyle('I5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('J5', "PPh Pasal 15");
		$excel->getActiveSheet()->getStyle('J5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('K4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('K4:L4');
		$excel->getActiveSheet()->getStyle('K4:L4')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('K5', "Objek PPh Pasal 22");
		$excel->getActiveSheet()->getStyle('K5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('L5', "PPh Pasal 22");
		$excel->getActiveSheet()->getStyle('L5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('M4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('M4:N4');
		$excel->getActiveSheet()->getStyle('M4:N4')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('M5', "Objek PPh Pasal 23");
		$excel->getActiveSheet()->getStyle('M5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('N5', "PPh Pasal 23");
		$excel->getActiveSheet()->getStyle('N5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('O4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('O4:P4');
		$excel->getActiveSheet()->getStyle('O4:P4')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('O5', "Objek PPh Pasal 42");
		$excel->getActiveSheet()->getStyle('O5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('P5', "PPh Pasal 42");
		$excel->getActiveSheet()->getStyle('P5')->applyFromArray($center_border);

		$excel->setActiveSheetIndex(0)->setCellValue('Q4', "Keterangan");
		$excel->getActiveSheet()->mergeCells('Q4:Q4');
		$excel->getActiveSheet()->getStyle('Q4:Q5')->applyFromArray($center_border);
		
		// end header
		$no = 1; 
		$numrow = 6;
		$numrowBorderStart = 6;

		if ($kd_cabang == ""){
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else{
			$whereCabang = "'".$kd_cabang."'";
		}
			
		$where		.= " and kode_cabang in (".$whereCabang.") ";
		$where_23	.= " and sph.kode_cabang in (".$whereCabang.") ";
		if($bulan) {
			$where 		.= " and bulan_pajak= '".$bulan."' ";
			$where_23 	.= " and sph.bulan_pajak= '".$bulan."' ";
		}
		$queryExecSub8 = "Select tb.kode_akun	
							, o23.kode_akun kd23
							, tb.akun_description
							, tb.jumlah_tb1 jumlah_tb
							, nvl(O23.nil_objek_23,0) nil23
							, nvl(O15.nil_objek_15,0) nil15
							, nvl(O22.nil_objek_22,0) nil22
							, nvl(O42.nil_objek_42,0) nil42
							, nvl(O21.nil_objek_21,0) nil21
							, case	
								when SUBSTR(TB.kode_akun,1,1)=8 then 1
								when SUBSTR(TB.kode_akun,1,2)=31 then 2
								when SUBSTR(TB.kode_akun,1,3)=207 then 3
								when SUBSTR(TB.kode_akun,1,3) between 103 and 106 then 4
								when SUBSTR(TB.kode_akun,1,3) in (203,110,107) then 5
								when SUBSTR(TB.kode_akun,1,3) in (208,209) then 6
								else 7
							end
								urut
							from
								(
								Select kode_akun, akun_description
										, (sum(nvl(DEBIT,0)) - sum(nvl(CREDIT,0))) jumlah_tb1
									from SIMTAX_RINCIAN_BL_PPH_BADAN 
									where tahun_pajak= '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by kode_akun, akun_description
								) tb,
								(
									select kode_akun,sum(begin_balance) begin_balance from (
										select kode_akun, kode_cabang, begin_balance
										from simtax_rincian_bl_pph_badan
										where tahun_pajak = '".$tahun."' 
										".$where." 
										and SUBSTR(kode_akun,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
										group by kode_akun, kode_cabang, begin_balance
									)
									group by kode_akun
								) bb,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_23 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."'
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										AND sph.nama_pajak = 'PPH PSL 23 DAN 26'
										and Substr(SPL.GL_ACCOUNT,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by SPL.GL_ACCOUNT
								) o23,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_15 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."'
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										AND sph.nama_pajak = 'PPH PSL 15'
										and Substr(SPL.GL_ACCOUNT,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by SPL.GL_ACCOUNT
								) o15,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_22 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."' 
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										AND sph.nama_pajak = 'PPH PSL 22'
										and Substr(SPL.GL_ACCOUNT,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by SPL.GL_ACCOUNT
								) o22,
								(
									select SPL.GL_ACCOUNT kode_akun, nvl(sum(nvl(spl.NEW_DPP,spl.DPP)),0) nil_objek_42 
									from SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
									where SPL.PAJAK_HEADER_ID=SPH.PAJAK_HEADER_ID
										and SPH.TAHUN_PAJAK= '".$tahun."' 
										".$where_23."
										and upper(SPL.IS_CHEKLIST) =1
										AND sph.nama_pajak = 'PPH PSL 4 AYAT 2'
										and Substr(SPL.GL_ACCOUNT,1,3) in (107,109,199,301,302,305,306,310,721,791,801,891)
									group by SPL.GL_ACCOUNT
								) o42,
								(SELECT SPL.GL_ACCOUNT kode_akun,
					                   NVL (SUM (NVL (spl.NEW_DPP, spl.DPP)), 0) nil_objek_21
					              FROM SIMTAX_PAJAK_LINES spl, SIMTAX_PAJAK_HEADERS sph
					             WHERE     SPL.PAJAK_HEADER_ID = SPH.PAJAK_HEADER_ID
					                   and SPH.TAHUN_PAJAK= '".$tahun."' 
									   ".$where_23."
					                   AND UPPER (SPL.IS_CHEKLIST) = 1
					                   AND sph.nama_pajak = 'PPH PSL 21'
					                   AND SUBSTR (SPL.GL_ACCOUNT, 1, 3) IN
					                   	   (107,109,199,301,302,305,306,310,721,791,801,891)
					          GROUP BY SPL.GL_ACCOUNT) o21
						 where tb.KODE_AKUN=O23.KODE_AKUN (+)
						 	   and tb.KODE_AKUN=O15.KODE_AKUN (+)
						 	   and tb.KODE_AKUN=O22.KODE_AKUN (+)
						 	   and tb.KODE_AKUN=O42.KODE_AKUN (+)
						 	   and tb.KODE_AKUN=O21.KODE_AKUN (+)
							   and tb.KODE_AKUN=bb.KODE_AKUN (+)
						 order by TB.KODE_AKUN";
			
			$querySub8			= $this->db->query($queryExecSub8);
			$sum_tb            	= 0;
			$sum_bukan_objek15 	= 0;
			$sum_objek15       	= 0;
			$sum_bukan_objek22 	= 0;
			$sum_objek22       	= 0;
			$sum_bukan_objek23 	= 0;
			$sum_objek23       	= 0;
			$sum_bukan_objek42 	= 0;
			$sum_objek42       	= 0;
			$sum_bukan_objek21  = 0;
			$sum_objek21       	= 0;
			foreach($querySub8->result_array() as $row)	{
				// List Akun		
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['KODE_AKUN']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['AKUN_DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['JUMLAH_TB']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['NIL21']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['JUMLAH_TB']-$row['NIL21']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['NIL15']);
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row['JUMLAH_TB']-$row['NIL15']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row['NIL22']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row['JUMLAH_TB']-$row['NIL22']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row['JUMLAH_TB']-$row['NIL23']);
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $row['NIL42']);
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $row['JUMLAH_TB']-$row['NIL42']);
				
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);

				$loop = horizontal_loop_excel("G", 10);
				foreach ($loop as $key => $value) {
					$excel->getActiveSheet()->getStyle($value.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
				}
				
				$excel->getActiveSheet()->getStyle('E'.$numrow.':P'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

				$sum_tb            += $row['JUMLAH_TB'];
				$sum_bukan_objek15 += ($row['JUMLAH_TB']-$row['NIL15']);
				$sum_objek15       += $row['NIL15'];
				$sum_bukan_objek22 += ($row['JUMLAH_TB']-$row['NIL22']);
				$sum_objek22       += $row['NIL22'];
				$sum_bukan_objek23 += ($row['JUMLAH_TB']-$row['NIL23']);
				$sum_objek23       += $row['NIL23'];
				$sum_bukan_objek42 += ($row['JUMLAH_TB']-$row['NIL42']);
				$sum_objek42       += $row['NIL42'];
				$sum_bukan_objek21 += ($row['JUMLAH_TB']-$row['NIL21']);
				$sum_objek21       += $row['NIL21'];
				$numrow++;
			}
		
		$numrow+=1;
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "Total Objek PPh");
		$excel->getActiveSheet()->mergeCells('B'.$numrow.':D'.$numrow);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_tb);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_objek21);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_bukan_objek21);
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $sum_objek15);
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $sum_bukan_objek15);
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $sum_objek22);
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $sum_bukan_objek22);
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $sum_objek23);
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $sum_bukan_objek23);
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $sum_objek42);
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $sum_bukan_objek42);

		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($noborder_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('E'.$numrow.':P'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(2);

		$loop = horizontal_loop_excel("G", 11);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getColumnDimension($value)->setWidth(20);
		}
		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Lap Equal Semua PPh");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Ekualisasi Semua PPh '.$masa.' '.$tahun.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function show_equal_pph_pasal_21()
	{
		$this->template->set('title', 'Laporan Ekualisasi PPh Psl 21');
		$data['subtitle']	= "Cetak Laporan Ekualisasi PPh Psl 21";
		$data['activepage'] = "laporan_ekualisasi";
		$this->template->load('template', 'laporan/lap_equalisasi_pph_psl_21',$data);
	}

	function cetak_equal_pph_psl_21_xls()
	{

		$pajak 		= $_REQUEST['pajak'];
		$nmpajak 	= "PPh Psl 21";
		$tahun 		= $_REQUEST['tahun'];
		$bulan		= $_REQUEST['bulan'];
		$masa		= $_REQUEST['namabulan'];
		$namacabang	= $_REQUEST['namacabang'];
		$cabang		= $_REQUEST['kd_cabang'];
		$date	    = date("Y-m-d H:i:s");
		$where		= "";
		$where_23	= "";

		if ($cabang !='all'){
			$kd_cabang = $cabang;
		} else{
			$kd_cabang = '';
		}

		ini_set('memory_limit', '-1');
		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Laporan Ekualisasi ".$nmpajak)
								->setSubject("Ekualisasi")
								->setDescription("Laporan Ekualisasi ".$nmpajak)
								->setKeywords($nmpajak);

		$center_bold_border = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_no_bold_border = array(
		        'font' => array('bold' => false),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$center_bold_noborder = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);

		$center_nobold_noborder = array(
		        'font' => array('bold' => false), 
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  )
		);
		
		$border_kika_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$borderfull_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$border_kika_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$noborder_bold_rata_kiri = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_bold_rata_kanan = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$noborder_nobold_rata_kiri = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  )
		);
		
		$noborder_nobold_rata_kanan = array(
		        'font' => array('bold' => false, 
								'name' => 'Calibri', 
								'size' => 9),
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
		  )
		);
		
		$parent_col = array(
		        'font' => array('bold' => true, 
								'name' => 'Calibri', 
								'size' => 9,
								'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
		  ),
			'borders' => array(
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
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Ekualisasi Objek ".$nmpajak." :");
		$excel->getActiveSheet()->mergeCells('B2:D2');
		$excel->getActiveSheet()->getStyle('B2:D2')->applyFromArray($noborder_bold_rata_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Bulan ".$masa); 
		$excel->getActiveSheet()->mergeCells('B3:D3');
		$excel->getActiveSheet()->getStyle('B3:D3')->applyFromArray($noborder_bold_rata_kiri);
		
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Menurut Fiskus");
		$excel->getActiveSheet()->mergeCells('B4:E4');
		$excel->getActiveSheet()->getStyle('B4:E4')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Account");
		$excel->getActiveSheet()->mergeCells('B5:B5');
		$excel->getActiveSheet()->getStyle('B5:B5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('C5', "Uraian");
		$excel->getActiveSheet()->mergeCells('C5:C5');
		$excel->getActiveSheet()->getStyle('C5:C5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('D5', "Klas");
		$excel->getActiveSheet()->mergeCells('D5:D5');
		$excel->getActiveSheet()->getStyle('D5:D5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('E5', "Jumlah Biaya");
		$excel->getActiveSheet()->mergeCells('E5:E5');
		$excel->getActiveSheet()->getStyle('E5:E5')->applyFromArray($center_no_bold_border);
		
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Penjelasan Menurut WP");
		$excel->getActiveSheet()->mergeCells('F4:H4');
		$excel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('F5', "Object 21");
		$excel->getActiveSheet()->mergeCells('F5:G5');
		$excel->getActiveSheet()->getStyle('F5:G5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Bukan Object 21");
		$excel->getActiveSheet()->mergeCells('H5:H5');
		$excel->getActiveSheet()->getStyle('H5:H5')->applyFromArray($center_no_bold_border);

		$excel->setActiveSheetIndex(0)->setCellValue('I4', "Keterangan");
		$excel->getActiveSheet()->mergeCells('I4:I5');
		$excel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($center_no_bold_border);
		
		// end header
		if($bulan){
			if ($bulan<10){
				$bulan ="0".$bulan ;
			}
			//$namabulan  = $this->Pph_mdl->getMonth($bulan);
			$where 		.= " and to_char(effective_date,'mm')= '".$bulan."' ";
			$where_23 	.= " and srb.bulan_pajak= '".$bulan."' ";
		}
		if($tahun){
			$where 		.= " and to_char(effective_date,'yyyy')= '".$tahun."' ";
			$where_23 	.= " and srb.tahun_pajak= '".$tahun."' ";
		}

		if ($kd_cabang == ""){
			$whereCabang = " '000','010','020','030','040','050', '060','070','080','090','100','110','120'";
		} else{
			$whereCabang = "'".$kd_cabang."'";
		}

         $queryExecSub8 = "Select
              tb.segment5    
            , o23.kode_akun kd23
            , o23.akun_description
            , nvl(o23.debit,0) debit
            , nvl(o23.credit,0) credit
            , nvl(tb.costed_value,0) costed_value
            , case
                when SUBSTR(TB.segment5,1,1)=8 then 1
              end
                urut
            from
			(
				select
                       substr(srb.KODE_AKUN,1,8) kode_akun
                     , sum(srb.debit) debit
                     , sum(srb.credit) credit
                     , srb.akun_description
                    from SIMTAX_RINCIAN_BL_PPH_BADAN srb
                    where 1=1
                    ".$where_23."
                    and kode_cabang in (".$whereCabang.")
                    and  (Substr(srb.KODE_AKUN,1,1) in ('1','2','3','8'))
                    group by substr(srb.KODE_AKUN,1,8), srb.akun_description
                ) o23,
                (
                Select
                         (SUBSTR(effective_date,4,3)) as effective_date 
                       , (SUBSTR(effective_date,8,9)) as effective_date_thn
                       , segment5
                       , sum(costed_value) costed_value
                    from SIMTAX_PPH21_DTL
                    where 1=1
                    ".$where."
                    and segment2 in (".$whereCabang.")
                    and (SUBSTR(segment5,1,1) in ('1','2','3','8'))
                    group by segment5 , (SUBSTR(effective_date,8,9)), (SUBSTR(effective_date,4,3))
                ) tb
         --where tb.segment5=O23.KODE_AKUN (+)
		 where O23.KODE_AKUN = tb.segment5 (+)
         order by O23.KODE_AKUN";
	
		$querySub8		= $this->db->query($queryExecSub8);
		$sum_tb            = 0;
		$sum_bukan_objek23 = 0;
		$sum_objek23       = 0;

		$numrow = 5;

		foreach($querySub8->result_array() as $row)	{	
			$numrow++;
			//$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['SEGMENT5']);
			//edit by Derry
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['KD23']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row['AKUN_DESCRIPTION']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row['DEBIT'] - $row['CREDIT']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['COSTED_VALUE']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, ($row['DEBIT'] - $row['CREDIT']) - $row['COSTED_VALUE']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, "");

			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);

			$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$sum_tb            += ($row['DEBIT'] - $row['CREDIT']);
			$sum_bukan_objek23 += ($row['DEBIT'] - $row['CREDIT']) - $row['COSTED_VALUE'];
			$sum_objek23       += $row['COSTED_VALUE'];
		}
		
		$numrow+=2;
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, 'Total Object '.$nmpajak.' ');
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $sum_tb);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sum_objek23);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sum_bukan_objek23);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($noborder_nobold_rata_kiri);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($noborder_nobold_rata_kanan);

		$excel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		$excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(40); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(5); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);  
	
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle($nmpajak);
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Ekualisasi '.$nmpajak.' '.$masa.' '.$tahun.' '.$namacabang.'.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	function show_equal_ppn_masa_bln()
	{
		$this->template->set('title', 'Laporan Ekualisasi PPN MASA');
		$data['subtitle']	= "Cetak Laporan Ekualisasi PPN MASA";
		$data['activepage'] = "laporan_ekualisasi";
		$data['error'] = "";
		$this->template->load('template', 'laporan/lap_equalisasi_ppn_masa_bln',$data);
	}


	function cetak_equal_ppn_masa_bulanan()
	{

		$tahun 		= $_REQUEST['tahun'];
		$bulan		= $_REQUEST['bulan'];
		$cabang		= "";
		
		$date	    = date("Y-m-d H:i:s");
		
		include APPPATH.'third_party/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		
		// Settingan awal fil excel
		$excel->getProperties()	->setCreator('SIMTAX')
								->setLastModifiedBy('SIMTAX')
								->setTitle("Cetak EKUALISASI PPN MASA BULANAN")
								->setSubject("Cetakan")
								->setDescription("Cetak EKUALISASI PPN MASA BULANAN")
								->setKeywords("MASA");

		$style_col = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_col1 = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_col3 = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_col5 = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_colhead = array(
			'font' => array('bold' => true), // Set font nya jadi bold
		);

		$style_coltotal = array(
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_colselisih = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		);
		
		$noBorder_Bold_Tengah = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$border_noBold_kiri = array(
		        'font' => array('bold' => false), // Set font nya jadi bold
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara vertical (middle)
		  ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		
		$style_col2 = array(
		   'alignment' => array(
		  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
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

		$style_row_hsl = array(
		   'alignment' => array(
		 	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		);

		$border_Bold = array(
		        'font' => array('bold' => true), // Set font nya jadi bold
		   'alignment' => array(
		  ),
		);
		
		//buat header cetakan
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "EKUALISASI PAJAK PERTAMBAHAN NILAI TAHUN ".$tahun." BULAN ".strtoupper(get_masa_pajak($bulan,"id",true))." ");
		$excel->getActiveSheet()->getStyle('B2')->applyFromArray($border_Bold);

		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Ekualisasi dengan pendapatan"); 
		$excel->getActiveSheet()->mergeCells('B3:E6');
		$excel->getActiveSheet()->getStyle('B3:E6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3:F6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3:G6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G7:G8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3:L6')->applyFromArray($border_noBold_kiri);

		$excel->setActiveSheetIndex(0)->setCellValue('H3', "Nama WP");
		$excel->setActiveSheetIndex(0)->setCellValue('H4', "NPWP"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H5', "Jenis Pajak"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H6', "Tahun Pajak"); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('I3', ":  PT. (PERSERO) PELABUHAN INDONESIA II"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I4', ":  01.061.005.3-093.000"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I5', ":  PPN"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I6', ":  ".$tahun."");

		$excel->setActiveSheetIndex(0)->setCellValue('B7', "No"); 
		$excel->getActiveSheet()->mergeCells('B7:B8');
		$excel->getActiveSheet()->getStyle('B7:B8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B9:B47')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('B48')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B48')->applyFromArray($style_col1);

		$excel->getActiveSheet()->getStyle('G48')->applyFromArray($style_col1);

		$loop = horizontal_loop_excel("E", 8);
		foreach ($loop as $key => $value) {
			if ($value == "E") {
				$excel->getActiveSheet()->getStyle('E9:E47')->applyFromArray($style_col5);
				$excel->getActiveSheet()->getStyle('E48')->applyFromArray($style_col5);
			} else if ($value == "F" || $value == "G") {
				$excel->getActiveSheet()->getStyle($value.'9:'.$value.'47')->applyFromArray($style_col1);
				$excel->getActiveSheet()->getStyle($value.'48')->applyFromArray($style_col1);
			}	else {
				$excel->getActiveSheet()->getStyle($value.'9:'.$value.'47')->applyFromArray($style_col3);
				$excel->getActiveSheet()->getStyle($value.'48')->applyFromArray($style_col3);
			}
		}

		$excel->setActiveSheetIndex(0)->setCellValue('C8', "U R A I A N"); 
		$excel->getActiveSheet()->mergeCells('C7:D8');
		$excel->getActiveSheet()->getStyle('C7:D8')->applyFromArray($style_col);

		$excel->setActiveSheetIndex(0)->setCellValue('E7', ""); 
		$excel->getActiveSheet()->mergeCells('E7:E8');
		$excel->setActiveSheetIndex(0)->setCellValue('F7', "AKUN"); 
		$excel->getActiveSheet()->mergeCells('F7:F8');
		$excel->getActiveSheet()->getStyle('F7:F8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G7:G8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E7:E8')->applyFromArray($style_col);

		$excel->setActiveSheetIndex(0)->setCellValue('H7', "Jumlah menurut"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H8', "Sub Buku Besar");
		$excel->getActiveSheet()->getStyle('H7:H8')->applyFromArray($noBorder_Bold_Tengah);

		$excel->setActiveSheetIndex(0)->setCellValue('I7', "PPN Dipungut");
		$excel->setActiveSheetIndex(0)->setCellValue('I8', "Sendiri");
		$excel->getActiveSheet()->getStyle('I7:I8')->applyFromArray($noBorder_Bold_Tengah);

		$excel->setActiveSheetIndex(0)->setCellValue('J7', "PPN Dipungut");
		$excel->setActiveSheetIndex(0)->setCellValue('J8', "Oleh Pemungut");
		$excel->getActiveSheet()->getStyle('J7:J8')->applyFromArray($noBorder_Bold_Tengah);

		$excel->setActiveSheetIndex(0)->setCellValue('K7', "PPN");
		$excel->setActiveSheetIndex(0)->setCellValue('K8', "Dibebaskan/DTP");
		$excel->getActiveSheet()->getStyle('K7:K8')->applyFromArray($noBorder_Bold_Tengah);

		$excel->setActiveSheetIndex(0)->setCellValue('L7', "Tidak terutang PPN");
		$excel->setActiveSheetIndex(0)->setCellValue('L8', "& Bukan Objek PPN");
		$excel->getActiveSheet()->getStyle('L7:L8')->applyFromArray($noBorder_Bold_Tengah);
		
		$queryExec ="select
                          q_master.kode_akun
                        , q_master.kode_akun || '00000' akun
                        , q_master.description_akun
                        , q_master.balance
                        , q_pendapatan.sendiri
                        , q_pendapatan.oleh_pemungut
                        , q_pendapatan.dibebaskan
                        , q_pendapatan.bukan_ppn
                        from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                                 (select ffvt.DESCRIPTION
                      from fnd_flex_values ffv
                         , fnd_flex_values_tl ffvt
                         , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id
                      and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                      and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                      and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                  SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                        FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                       WHERE SUBSTR (kode_akun, 0, 3) IN
                                   ('701', '702', '703', '704', '705', '706', '707', '708')
                       and bulan_pajak = '".$bulan."'
                       and tahun_pajak = '".$tahun."'
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                      from simtax_pajak_headers sph
                      inner join simtax_pajak_lines spl
                          on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                          INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                      --  LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                      --  AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
                      --  LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL ON SMPEL.CUSTOMER_ID = SPL.CUSTOMER_ID
                      --  AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                       and sph.bulan_pajak = '".$bulan."'
                       and sph.tahun_pajak = '".$tahun."'
                       AND SPL.IS_CHEKLIST = '1'
                       --and sph.kode_cabang = '".$cabang."'
                       and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                      and substr(spl.akun_pajak,0,3) in  ('701', '702', '703', '704', '705', '706', '707', '708')
                       --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                       )
                       PIVOT (SUM (dpp*1)
                       FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1 ";
		$query 		= $this->db->query($queryExec);

		$no = 1;
		$numrow = 11;
		$firstNumrow = $numrow;
		foreach($query->result_array() as $row)	{	
			$excel->setActiveSheetIndex(0)->setCellValue('B10',"A");
			$excel->setActiveSheetIndex(0)->setCellValue('C10',"Pendapatan Usaha");
			$excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_colhead);
			$excel->setActiveSheetIndex(0)->setCellValue('D11',"PELAYANAN JASA KAPAL");
			$excel->setActiveSheetIndex(0)->setCellValue('D12',"PELAYANAN JASA BARANG");
			$excel->setActiveSheetIndex(0)->setCellValue('D13',"PENGUSAHAAN ALAT");
			$excel->setActiveSheetIndex(0)->setCellValue('D14',"PELAYANAN TERMINAL");
			$excel->setActiveSheetIndex(0)->setCellValue('D15',"PELAYANAN TERMINAL PETIKEMAS");
			$excel->setActiveSheetIndex(0)->setCellValue('D16',"PENGUSAH TANAH, BANGUNAN, AIR & LISTRIK");
			$excel->setActiveSheetIndex(0)->setCellValue('D17',"FASILITAS RUPA-RUPA USAHA");
			$excel->setActiveSheetIndex(0)->setCellValue('D18',"KERJASAMA DENGAN MITRA USAHA");

			$excel->setActiveSheetIndex(0)->setCellValue('D20',"Total Pendapatan Usaha");
			$excel->getActiveSheet()->getStyle('D20')->applyFromArray($style_colhead);

			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row['AKUN']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row['DESCRIPTION_AKUN']);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row['BALANCE']);
			$excel->setActiveSheetIndex(0)->setCellValue('H20','=SUM(H11:H18)');

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row['SENDIRI']);
			$excel->setActiveSheetIndex(0)->setCellValue('I20','=SUM(I11:I18)');

			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row['OLEH_PEMUNGUT']);
			$excel->setActiveSheetIndex(0)->setCellValue('J20','=SUM(J11:J18)');

			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row['DIBEBASKAN']);
			$excel->setActiveSheetIndex(0)->setCellValue('K20','=SUM(K11:K18)');

			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row['BUKAN_PPN']);
			$excel->setActiveSheetIndex(0)->setCellValue('L20','=SUM(L11:L18)');

			$no++;
			$numrow++;
		}

		$loop = horizontal_loop_excel("H", 5);
		$lastNumrow = $numrow-1;
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.'20')->applyFromArray($style_coltotal);
			$excel->getActiveSheet()->getStyle($value.$numrow.':'.$value.$lastNumrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle($value.'20')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		}

		$loop = horizontal_loop_excel("B", 11);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.$numrow.':'.$value.$lastNumrow)->applyFromArray($style_row_hsl);
		}

		$queryExec1	=" select
                            q_master.kode_akun
                            , substr(q_master.kode_akun,0,3)  akun
                            , q_master.description_akun
                            , q_master.balance
                            , q_pendapatan.sendiri
                            , q_pendapatan.oleh_pemungut
                            , q_pendapatan.dibebaskan
                            , q_pendapatan.bukan_ppn
                                from 
                            (  SELECT kode_akun kode_akun,
                                            akun_description,
                                         (select ffvt.DESCRIPTION
                              from fnd_flex_values ffv
                                 , fnd_flex_values_tl ffvt
                                 , fnd_flex_value_sets ffvs
                            where ffv.flex_value_id = ffvt.flex_value_id     
                              and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                              and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                              and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3)) description_akun,
                                          SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                                FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                               WHERE kode_akun IN
                                           ('79101111','79101121','79101131','79101141'
                                            ,'79101161','79101172','79101181','79101182','79199999')
                               and bulan_pajak = '".$bulan."'
                               and tahun_pajak = '".$tahun."'
                            GROUP BY kode_akun,  akun_description) q_master
                            ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak akun_pajak
                                   , spl.dpp
                                  , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                              from simtax_pajak_headers sph
                              inner join simtax_pajak_lines spl
                                  on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                                 INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                                 -- LEFT JOIN SIMTAX_MASTER_SUPPLIER SMS ON SMS.VENDOR_ID = SPL.VENDOR_ID
                                 -- AND SMS.VENDOR_SITE_ID = SPL.VENDOR_SITE_ID
                                 -- LEFT JOIN SIMTAX_MASTER_PELANGGAN SMPEL ON SMPEL.CUSTOMER_ID = SPL.CUSTOMER_ID
                                --    AND SMPEL.ORGANIZATION_ID = SPL.ORGANIZATION_ID
                            where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                               and sph.bulan_pajak = '".$bulan."'
                               and sph.tahun_pajak = '".$tahun."'
                               AND SPL.IS_CHEKLIST = '1'
                               --and sph.kode_cabang = '".$cabang."'
                               and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                               --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                               )
                               PIVOT (SUM (dpp*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))
                             	) q_pendapatan
                            where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                            order by 1
		";
		$query1 	= $this->db->query($queryExec1);

		$no1 = 1;
		$numrow1 = 23;
		$firstNumrow = $numrow1;
		foreach($query1->result_array() as $row1) {
			$excel->setActiveSheetIndex(0)->setCellValue('B22',"B");
			$excel->setActiveSheetIndex(0)->setCellValue('C22',"Pendapatan Diluar Usaha");
			$excel->getActiveSheet()->getStyle('C22:C22')->applyFromArray($style_colhead);
			$excel->setActiveSheetIndex(0)->setCellValue('D23',"Laba Selisih Kurs");
			$excel->setActiveSheetIndex(0)->setCellValue('D24',"Bunga Deposito");
			$excel->setActiveSheetIndex(0)->setCellValue('D25',"Jasa Giro");
			$excel->setActiveSheetIndex(0)->setCellValue('D26',"Denda");
			$excel->setActiveSheetIndex(0)->setCellValue('D27',"Dokumen Tender / Administrasi");
			$excel->setActiveSheetIndex(0)->setCellValue('D28',"Pendapatan Premium");
			$excel->setActiveSheetIndex(0)->setCellValue('D29',"Bagian Laba PT. JICT");
			$excel->setActiveSheetIndex(0)->setCellValue('D30',"Bagian Laba KSO Koja");
			$excel->setActiveSheetIndex(0)->setCellValue('D31',"Pend. Diluar Usaha Lainnya");

			$excel->setActiveSheetIndex(0)->setCellValue('D32',"Total PDLU");
			$excel->getActiveSheet()->getStyle('D32:D32')->applyFromArray($style_colhead);

			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow1, "");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow1, $row1['KODE_AKUN']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow1, $row1['DESCRIPTION_AKUN']);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow1, $row1['BALANCE']);
			$excel->setActiveSheetIndex(0)->setCellValue('H32','=SUM(H23:H31)');

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow1, $row1['SENDIRI']);
			$excel->setActiveSheetIndex(0)->setCellValue('I32','=SUM(I23:I31)');

			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow1, $row1['OLEH_PEMUNGUT']);
			$excel->setActiveSheetIndex(0)->setCellValue('J32','=SUM(J23:J31)');

			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow1, $row1['DIBEBASKAN']);
			$excel->setActiveSheetIndex(0)->setCellValue('K32','=SUM(K23:K31)');

			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow1, $row1['BUKAN_PPN']);
			$excel->setActiveSheetIndex(0)->setCellValue('L32','=SUM(L23:L31)');

			$no1++;
			$numrow1++;
		}

		$loop = horizontal_loop_excel("H", 5);
		$lastNumrow = $numrow1-1;
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.'32')->applyFromArray($style_coltotal);
			$excel->getActiveSheet()->getStyle($value.$numrow1.':'.$value.$lastNumrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle($value.'32')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		}

		$loop = horizontal_loop_excel("B", 11);
		foreach ($loop as $key => $value) {
			$excel->getActiveSheet()->getStyle($value.$numrow1.':'.$value.$lastNumrow)->applyFromArray($style_row_hsl);
		}

		$excel->setActiveSheetIndex(0)->setCellValue('B34',"C");
		$excel->setActiveSheetIndex(0)->setCellValue('C34',"Total Pendapatan sesuai Lap Keuangan (A+B)");
		$excel->getActiveSheet()->getStyle('C34:C34')->applyFromArray($style_colhead);

		$loop = horizontal_loop_excel("H", 5);
		$lastNumrow = $numrow1-1;
		foreach ($loop as $key => $value) {
			$excel->setActiveSheetIndex(0)->setCellValue($value.'34','=SUM('.$value.'20+'.$value.'32)');
			$excel->getActiveSheet()->getStyle($value.'34')->applyFromArray($style_coltotal);
			$excel->getActiveSheet()->getStyle($value.'44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		}

		$no3 = 1;
		$numrow3 = 37;
		$queryExec3	= "select
                          q_master.kode_akun
                        , q_master.kode_akun || '00000' akun
                        , q_master.description_akun
                        , q_master.balance
                        , q_pendapatan.sendiri
                        , q_pendapatan.oleh_pemungut
                        , q_pendapatan.dibebaskan
                        , q_pendapatan.bukan_ppn
                        from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                                 (select ffvt.DESCRIPTION
                      from fnd_flex_values ffv
                         , fnd_flex_values_tl ffvt
                         , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id     
                      and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                      and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                      and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                  SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                        FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                       WHERE SUBSTR (kode_akun, 0, 3) = '311'
                       and bulan_pajak = '".$bulan."'
                       and tahun_pajak = '".$tahun."'
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                      from simtax_pajak_headers sph
                      inner join simtax_pajak_lines spl
                          on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                           INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                       and sph.bulan_pajak = '".$bulan."'
                       and sph.tahun_pajak = '".$tahun."'
                       AND SPL.IS_CHEKLIST = '1'
					   --and sph.kode_cabang = '".$cabang."'
                       and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                      and substr(spl.akun_pajak,0,3) = '311'
                       --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                       )
                       PIVOT (SUM (dpp*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1";
		$query3 	= $this->db->query($queryExec3);

		foreach($query3->result_array() as $row3)	{	
			$excel->setActiveSheetIndex(0)->setCellValue('B36',"D");
			$excel->setActiveSheetIndex(0)->setCellValue('C36',"Pendapatan yg  Diterima Di Muka");
			$excel->getActiveSheet()->getStyle('C36:C36')->applyFromArray($style_colhead);
			$excel->setActiveSheetIndex(0)->setCellValue('D37',"Jangka Pendek");

			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, "");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow3, $row3['AKUN']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $row3['DESCRIPTION_AKUN']);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow3, $row3['BALANCE']);
			$excel->getActiveSheet()->getStyle('H'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H32')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow3, $row3['SENDIRI']);
			$excel->getActiveSheet()->getStyle('I'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow3, $row3['OLEH_PEMUNGUT']);
			$excel->getActiveSheet()->getStyle('J'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('J'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow3, $row3['DIBEBASKAN']);
			$excel->getActiveSheet()->getStyle('K'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('K'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow3, $row3['BUKAN_PPN']);
			$excel->getActiveSheet()->getStyle('L'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('L'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style_row_hsl);

			$excel->getActiveSheet()->getStyle('H'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('I'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('J'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('K'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('L'.$numrow3)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('L'.$numrow3)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$no3++;
		$numrow3++;
		}

		$no4 = 1;
		$numrow4 = 40;
		$queryExec4	= "select
                          q_master.kode_akun
                        , q_master.kode_akun || '00000' akun
                        , q_master.description_akun
                        , q_master.balance
                        , q_pendapatan.sendiri
                        , q_pendapatan.oleh_pemungut
                        , q_pendapatan.dibebaskan
                        , q_pendapatan.bukan_ppn
                        from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                                 (select ffvt.DESCRIPTION
                      from fnd_flex_values ffv
                         , fnd_flex_values_tl ffvt
                         , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id     
                      and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                      and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                      and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                  SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                        FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                       WHERE SUBSTR (kode_akun, 0, 3) = '405'
                       and bulan_pajak = '".$bulan."'
                       and tahun_pajak = '".$tahun."'
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                      from simtax_pajak_headers sph
                      inner join simtax_pajak_lines spl
                          on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                          INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                       and sph.bulan_pajak = '".$bulan."'
                       and sph.tahun_pajak = '".$tahun."'
                       AND SPL.IS_CHEKLIST = '1'
					   --and sph.kode_cabang = '".$cabang."'
                       and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                      and substr(spl.akun_pajak,0,3) = '405'
                       --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                       )
                       PIVOT (SUM (dpp*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1";
		$query4 	= $this->db->query($queryExec4);

		foreach($query4->result_array() as $row4)	{	
			$excel->setActiveSheetIndex(0)->setCellValue('B39',"E");
			$excel->setActiveSheetIndex(0)->setCellValue('C39',"Pendapatan yg  Diterima Di Muka");
			$excel->getActiveSheet()->getStyle('C39:C39')->applyFromArray($style_colhead);
			$excel->setActiveSheetIndex(0)->setCellValue('D40',"Jangka Panjang");

			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow4, "");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow4, $row4['AKUN']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow4, $row4['DESCRIPTION_AKUN']);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow4, $row4['BALANCE']);
			$excel->getActiveSheet()->getStyle('H'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow4, $row4['SENDIRI']);
			$excel->getActiveSheet()->getStyle('I'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow4, $row4['OLEH_PEMUNGUT']);
			$excel->getActiveSheet()->getStyle('J'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('J'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow4, $row4['DIBEBASKAN']);
			$excel->getActiveSheet()->getStyle('K'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('K'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow4, $row4['BUKAN_PPN']);
			$excel->getActiveSheet()->getStyle('L'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('L'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('B'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('C'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('D'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('E'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('F'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('G'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('H'.$numrow4)->applyFromArray($style_row_hsl);

			$excel->getActiveSheet()->getStyle('H'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('I'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('I'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('J'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('J'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('K'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('K'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('L'.$numrow4)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('L'.$numrow4)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$no4++;
		$numrow4++;
		}

		$no5 = 1;
		$numrow5 = 42;
		$queryExec5	= "select
                          q_master.kode_akun
                        , q_master.kode_akun || '00000' akun
                        , q_master.description_akun
                        , q_master.balance
                        , q_pendapatan.sendiri
                        , q_pendapatan.oleh_pemungut
                        , q_pendapatan.dibebaskan
                        , q_pendapatan.bukan_ppn
                        from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                                 (select ffvt.DESCRIPTION
                      from fnd_flex_values ffv
                         , fnd_flex_values_tl ffvt
                         , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id     
                      and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                      and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                      and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                  SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                        FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                       WHERE SUBSTR (kode_akun, 0, 3) = '111'
                       and bulan_pajak = '".$bulan."'
                       and tahun_pajak = '".$tahun."'
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                      from simtax_pajak_headers sph
                      inner join simtax_pajak_lines spl
                          on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                          INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                       and sph.bulan_pajak = '".$bulan."'
                       and sph.tahun_pajak = '".$tahun."'
                       AND SPL.IS_CHEKLIST = '1'
					   --and sph.kode_cabang = '".$cabang."'
                       and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                      and substr(spl.akun_pajak,0,3) = '111'
                       --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                       )
                       PIVOT (SUM (dpp*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1";
		$query5 	= $this->db->query($queryExec5);

		foreach($query5->result_array() as $row5)	{	
			$excel->setActiveSheetIndex(0)->setCellValue('B42',"G");
			$excel->setActiveSheetIndex(0)->setCellValue('C42',"Pendapatan Y.M.A Diterima");
			$excel->getActiveSheet()->getStyle('C42:C42')->applyFromArray($style_colhead);

			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow5, "");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow5, $row5['AKUN']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow5, $row5['DESCRIPTION_AKUN']);

			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow5, $row5['BALANCE']);
			$excel->getActiveSheet()->getStyle('H'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow5, $row5['SENDIRI']);
			$excel->getActiveSheet()->getStyle('I'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow5, $row5['OLEH_PEMUNGUT']);
			$excel->getActiveSheet()->getStyle('J'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('J'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow5, $row5['DIBEBASKAN']);
			$excel->getActiveSheet()->getStyle('K'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('K'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow5, $row5['BUKAN_PPN']);
			$excel->getActiveSheet()->getStyle('L'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('L'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('B'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('C'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('D'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('E'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('F'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('G'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('H'.$numrow5)->applyFromArray($style_row_hsl);

			$excel->getActiveSheet()->getStyle('H'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('H'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('I'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('I'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('J'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('J'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('K'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('K'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$excel->getActiveSheet()->getStyle('L'.$numrow5)->applyFromArray($style_row_hsl);
			$excel->getActiveSheet()->getStyle('L'.$numrow5)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

			$no5++;
			$numrow5++;
		}

		$excel->setActiveSheetIndex(0)->setCellValue('D44',"TOTAL OMZET PENJUALAN (C+D+E)");
		$excel->getActiveSheet()->getStyle('D44:D44')->applyFromArray($style_colhead);

		$excel->setActiveSheetIndex(0)->setCellValue('H44','=SUM(H34+H37+H40)');
		$excel->getActiveSheet()->getStyle('H44')->applyFromArray($style_coltotal);
		$excel->getActiveSheet()->getStyle('H44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('I44','=SUM(I34+I37+I40)');
		$excel->getActiveSheet()->getStyle('I44')->applyFromArray($style_coltotal);
		$excel->getActiveSheet()->getStyle('I44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('J44','=SUM(J34+J37+J40)');
		$excel->getActiveSheet()->getStyle('J44')->applyFromArray($style_coltotal);
		$excel->getActiveSheet()->getStyle('J44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('K44','=SUM(K34+K37+K40)');
		$excel->getActiveSheet()->getStyle('K44')->applyFromArray($style_coltotal);
		$excel->getActiveSheet()->getStyle('K44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('L44','=SUM(L34+L37+L40)');
		$excel->getActiveSheet()->getStyle('L44')->applyFromArray($style_coltotal);
		$excel->getActiveSheet()->getStyle('L44')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$queryExecekl	= "SELECT SUM (q_master.balance) balance,
                     SUM (q_pendapatan.sendiri) sendiri,
                     SUM (q_pendapatan.oleh_pemungut) oleh_pemungut,
                     SUM (q_pendapatan.dibebaskan) dibebaskan,
                     SUM (q_pendapatan.bukan_ppn) bukan_ppn
                FROM (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                               SUM (NVL (debit, 0) - 1) - SUM (NVL (credit, 0) - 1) balance,
                               masa_pajak
                          FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                         WHERE SUBSTR (kode_akun, 0, 3) IN
                                     ('701', '702', '703', '704', '705', '706', '707', '708')
                               AND bulan_pajak = '".$bulan."'
                               and tahun_pajak = '".$tahun."'
                      GROUP BY SUBSTR (kode_akun, 0, 3), masa_pajak) q_master,
                     (SELECT akun_pajak,
                             sendiri,
                             oleh_pemungut,
                             dibebaskan,
                             bukan_ppn,
                             masa_pajak,
                             pembetulan_ke
                        FROM (SELECT SUBSTR (spl.akun_pajak, 0, 3) akun_pajak,
                                     spl.dpp jumlah_potong,
                                     sph.masa_pajak,
                                     sph.pembetulan_ke,
                                     case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                                FROM    simtax_pajak_headers sph
                                     INNER JOIN
                                        simtax_pajak_lines spl
                                     ON SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                                     INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                               WHERE sph.nama_pajak IN ('PPN MASUKAN', 'PPN KELUARAN')
                                     AND sph.bulan_pajak ='".$bulan."'
                                     and sph.tahun_pajak = '".$tahun."'
                                     AND SPL.IS_CHEKLIST = '1'
                                     AND (SPL.NO_FAKTUR_PAJAK IS NOT NULL
                                          OR SPL.NO_DOKUMEN_LAIN IS NOT NULL)
                                     AND SUBSTR (spl.akun_pajak, 0, 3) IN
                                              ('701', '702', '703','704', '705', '706', '707', '708')
                                     ORDER BY SPH.PEMBETULAN_KE ASC
                             ) PIVOT (SUM (jumlah_potong*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                            WHERE q_master.kode_akun = q_pendapatan.akun_pajak
                             AND q_master.masa_pajak = Q_PENDAPATAN.masa_pajak
                            GROUP BY q_pendapatan.pembetulan_ke, q_master.masa_pajak
                            ORDER BY q_master.masa_pajak DESC";

		$queryekl         = $this->db->query($queryExecekl);
		$balanceekl       = 0;
		$sendiriekl       = 0;
		$oleh_pemungutekl = 0;
		$dibebaskanekl    = 0;
		$bukan_ppnekl     = 0;
		$tot_ekl          = 0;

		$excel->setActiveSheetIndex(0)->setCellValue('D46',"TOTAL OMZET (DPP) MENURUT SPT");
		$excel->getActiveSheet()->getStyle('D46:D46')->applyFromArray($style_colhead);

		foreach($queryekl->result_array() as $rowekl)	{
			$balanceekl       += $rowekl['BALANCE'];
			$sendiriekl       += $rowekl['SENDIRI'];
			$oleh_pemungutekl += $rowekl['OLEH_PEMUNGUT'];
			$dibebaskanekl    += $rowekl['DIBEBASKAN'];
			$bukan_ppnekl     += $rowekl['BUKAN_PPN'];
			$tot_ekl          += $rowekl['SENDIRI'] + $rowekl['OLEH_PEMUNGUT'] + $rowekl['DIBEBASKAN'];

			$excel->setActiveSheetIndex(0)->setCellValue('H46', $balanceekl);
			$excel->setActiveSheetIndex(0)->setCellValue('I46', $sendiriekl);
			$excel->setActiveSheetIndex(0)->setCellValue('J46', $oleh_pemungutekl);
			$excel->setActiveSheetIndex(0)->setCellValue('K46', $dibebaskanekl);

			$excel->getActiveSheet()->getStyle('H46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('I46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('J46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('K46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
			$excel->getActiveSheet()->getStyle('L46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
		}

		//
		$excel->setActiveSheetIndex(0)->setCellValue('D48',"SELISIH");
		$excel->getActiveSheet()->getStyle('D48:D48')->applyFromArray($style_colselisih);

		$excel->setActiveSheetIndex(0)->setCellValue('H48','=(H44-H46)');
		$excel->getActiveSheet()->getStyle('H46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('I48','=(I44-I46)');
		$excel->getActiveSheet()->getStyle('I46')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('J48','=(J44-J46)');
		$excel->getActiveSheet()->getStyle('J48')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('K48','=(K44-K46)');
		$excel->getActiveSheet()->getStyle('K48')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		$excel->setActiveSheetIndex(0)->setCellValue('L48','=(L44-L46)');
		$excel->getActiveSheet()->getStyle('L48')->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

		//
		$excel->setActiveSheetIndex(0)->setCellValue('D52',"MENGETAHUI :");

		$cabang		= $this->session->userdata('kd_cabang');
		$nama_pajak = 'SPT PPN Masa';
		$jpp 		= 'DVP Pajak';
		$dt 		= 'Ekualisasi';

		$queryExec1	= "select * from SIMTAX_PEMOTONG_PAJAK
                            where JABATAN_PETUGAS_PENANDATANGAN = '".$jpp."'
                            and nama_pajak = '".$nama_pajak."'
                            and document_type = '".$dt."' 
                            and kode_cabang = '".$cabang."'
                            and end_effective_date >= sysdate
                            and start_effective_date <= sysdate ";
			
		$query1 	= $this->db->query($queryExec1);
		$rowCount	= $query1->num_rows();

		if($rowCount > 0){

			$rowb1		= $query1->row();
			$ttd 					= $rowb1->URL_TANDA_TANGAN;
			$petugas_ttd			= $rowb1->NAMA_PETUGAS_PENANDATANGAN;
			$jabatan_petugas_ttd	= $rowb1->JABATAN_PETUGAS_PENANDATANGAN;

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			$logo = $ttd; // Provide path to your logo file
			if(file_exists($logo)){
				$objDrawing->setPath($logo);  //setOffsetY has no effect
				$objDrawing->setCoordinates('D55');
				$objDrawing->setHeight(80); // logo height
				$objDrawing->setWorksheet($excel->getActiveSheet());
			}
			$excel->setActiveSheetIndex(0)->setCellValue('D53', $petugas_ttd);
			$excel->setActiveSheetIndex(0)->setCellValue('D59', $jabatan_petugas_ttd);
		}
		
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(0);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(65);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

		
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Ekualisasi PPN Masa");
		$excel->setActiveSheetIndex(0);
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Ekualisasi PPN MASA.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */