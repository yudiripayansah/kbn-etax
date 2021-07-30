<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_rekapitulasi extends CI_Controller {

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
        $this->load->model('Lap_rekap_mdl');
	}

    function getFooterXLS($filename,$excel) {
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename);
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer->save('php://output');
        unset($excel);
      }
    
      function getHeaderXLS($xlsfile) {
        include APPPATH.'third_party/PHPExcel.php';
        include APPPATH.'third_party/PHPExcel/IOFactory.php';
        
        $fileTemplate = APPPATH.'kertaskerja/'.$xlsfile;
    
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()	->setCreator('SIMTAX')
          ->setLastModifiedBy('SIMTAX')
          ->setTitle("Cetak Rekapitulasi")
          ->setSubject("Cetakan")
          ->setDescription("Cetak Rekapitulasi Setahun")
          ->setKeywords("Rekapitulasi");
    
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($fileTemplate);
        return $objPHPExcel;
      }

    function show_pdd_jkpjg()
	{
		$this->template->set('title', 'Laporan PDD JKPJG');
		$data['subtitle']	= "Cetak Laporan PDD JKPJG";
		$data['error'] = "";
		$this->template->load('template', 'laporan/lap_pdd_jkpjg',$data);
	}

    function show_pdd_jkpdk()
	{
		$this->template->set('title', 'Laporan PDD JKPDK');
		$data['subtitle']	= "Cetak Laporan PDD JKPDK";
		$data['error'] = "";
		$this->template->load('template', 'laporan/lap_pdd_jkpdk',$data);
	}

    function show_pymad()
	{
		$this->template->set('title', 'Laporan PYMAD');
		$data['subtitle']	= "Cetak Laporan PYMAD";
		$data['error'] = "";
		$this->template->load('template', 'laporan/lap_pymad',$data);
	}


    function cetak_pdd_jkpjg()
	{
		$tahun 		= $_REQUEST['tahun'];
		$bulandari	= $_REQUEST['bulanfrom'];
		$bulanke	= $_REQUEST['bulanto'];
		$cabang		= $_REQUEST['cabang'];
		
		$shortMonthArr 		= array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$bulanTeks			= $shortMonthArr[$bulandari];
		
		$date	    = date("Y-m-d H:i:s");
		
        $fileName = 'RekapitulasiPDDJKPJG.xlsx';	
        $objPHPExcel = $this->getHeaderXLS($fileName);

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

        $style_row_hsl = array(
          'alignment' => array(
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
         ),
       );

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A3','REKAPITULASI PENDAPATAN  DITERIMA DIMUKA JANGKA PANJANG TAHUN '.($tahun-1).' dan '.$tahun);

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E5',($tahun-1))
        ->setCellValue('F5',$tahun)
        ;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G6',($tahun-1).'-'.$tahun)
        ;

        $query	= $this->Lap_rekap_mdl->get_rekap_pdd_jkpjg_all($cabang,$bulandari,$bulanke,($tahun-1));


      $i = 1;
      $numrow = 8;
      $vdibebaskan = 0;
      foreach($query->result_array() as $row) {
        $vdibebaskan += $row['DIBEBASKAN'] + $row['BUKAN_PPN'];
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0,$numrow,$i)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;
          $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row_hsl);

          $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
          $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');  

          $i++;
          $numrow++;
      }

      $numrow2 = 8;
      $query	= $this->Lap_rekap_mdl->get_rekap_pdd_jkpjg_all($cabang,$bulandari,$bulanke,$tahun);
      foreach($query->result_array() as $row) {
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow2,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(6,$numrow2,"=F".$numrow2."-E".$numrow2)
          ;

        $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        
          $numrow2++;
      }
      
      $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.($numrow+1),"Pend. Ditrm Dimuka Jk. Pjg  ") 
                ->setCellValue('E'.($numrow+1),"=SUM(E8:E".($numrow).")") 
                ->setCellValue('F'.($numrow+1),"=SUM(F8:F".($numrow).")") 
                ->setCellValue('G'.($numrow+1),"=F".($numrow+1)."-E".($numrow+1)) 
                ;

      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+1))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+1))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+1))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+1))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+1))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+1))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+1))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+1))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');           

      $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E'.($numrow+3),"=+E".($numrow+1)."+E".($numrow+2)) 
                ->setCellValue('F'.($numrow+3),"=+F".($numrow+1)."+F".($numrow+2)) 
                ->setCellValue('G'.($numrow+3),"=F".($numrow+3)."-E".($numrow+3)) 
                ->setCellValue('H'.($numrow+3),"=SUM(H8:H".($numrow+2).")") 
                ->setCellValue('I'.($numrow+3),"=SUM(I8:I".($numrow+2).")") 
                ->setCellValue('J'.($numrow+3),"=SUM(J8:J".($numrow+2).")") 
                ->setCellValue('K'.($numrow+3),"=SUM(K8:K".($numrow+2).")") 
                ;

      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('I'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('I'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('J'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('J'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      $objPHPExcel->getActiveSheet()->getStyle('K'.($numrow+3))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('K'.($numrow+3))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('A8:A'.($numrow+2))->applyFromArray($style_col5);
      $objPHPExcel->getActiveSheet()->getStyle('B8:B'.($numrow+2))->applyFromArray($style_col5);
      $objPHPExcel->getActiveSheet()->getStyle('C8:C'.($numrow+2))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('D8:D'.($numrow+2))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('E8:E'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('F8:F'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('G8:G'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('H8:H'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('I8:I'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('J8:J'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('K8:K'.($numrow+2))->applyFromArray($style_col3);

      $objPHPExcel->getActiveSheet()->getStyle('A8:A'.($numrow+3))->applyFromArray($style_col5);
      $objPHPExcel->getActiveSheet()->getStyle('B8:B'.($numrow+3))->applyFromArray($style_col5);
      $objPHPExcel->getActiveSheet()->getStyle('C8:C'.($numrow+3))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('D8:D'.($numrow+3))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('E8:E'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('F8:F'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('G8:G'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('H8:H'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('I8:I'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('J8:J'.($numrow+3))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('K8:K'.($numrow+3))->applyFromArray($style_col3);

        $query	= $this->Lap_rekap_mdl->get_rekap_ppn_jkpjg($cabang,$bulandari,$bulanke,$tahun);
        foreach($query->result_array() as $row) {

                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('I15',$row['OLEH_PEMUNGUT'])
                    ->setCellValue('J15',$row['DIBEBASKAN'])
                    ->setCellValue('K15',$row['BUKAN_PPN'])
                    ;
        }

			
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$objPHPExcel->getActiveSheet(0)->setTitle("Lap PDD JKPJG");
		$objPHPExcel->setActiveSheetIndex(0);
        
		
		$this->getFooterXLS($fileName,$objPHPExcel);                      

    }

  function cetak_pdd_jkpdk()
	{

		$tahun 		= $_REQUEST['tahun'];
		$bulandari	= $_REQUEST['bulanfrom'];
		$bulanke	= $_REQUEST['bulanto'];
		$cabang		= $_REQUEST['cabang'];
		
		$shortMonthArr 		= array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$bulanTeks			= $shortMonthArr[$bulandari];
		
		$date	    = date("Y-m-d H:i:s");
		
        $fileName = 'RekapitulasiPDDJKPDK.xlsx';	
        $objPHPExcel = $this->getHeaderXLS($fileName);

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

        $style_row_hsl = array(
          'alignment' => array(
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
         ),
       );


        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A3','REKAPITULASI PENDAPATAN  DITERIMA DIMUKA JANGKA PENDEK TAHUN '.($tahun-1).' dan '.$tahun.' AUDITED');

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E5',($tahun-1))
        ->setCellValue('F5',$tahun)
        ;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G6',($tahun-1).'-'.$tahun)
        ;

      
      $query	= $this->Lap_rekap_mdl->get_rekap_pdd_jkpdk_all($cabang,$bulandari,$bulanke,($tahun-1));
      
      $i = 1;
      $numrow = 15;
      
      foreach($query->result_array() as $row) {
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0,$numrow,$i)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;

          $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row_hsl);
          $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row_hsl);

          $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
          $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');
          $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)');

          $i++;
          $numrow++;
      }

      $numrow2 = 15;
      $query	= $this->Lap_rekap_mdl->get_rekap_pdd_jkpdk_all($cabang,$bulandari,$bulanke,$tahun);
      foreach($query->result_array() as $row) {
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow2,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(6,$numrow2,"=F".$numrow2."-E".$numrow2)
          ;

        $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow2)->applyFromArray($style_row_hsl);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow2)->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
        
          $numrow2++;
      }

      $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.($numrow+2),"Pend. Ditrm Dimuka Jk. Pdk ") 
                ->setCellValue('E'.($numrow+2),"=SUM(E15:E".($numrow+1).")") 
                ->setCellValue('F'.($numrow+2),"=SUM(F15:F".($numrow+1).")") 
                ->setCellValue('G'.($numrow+2),"=F".($numrow+2)."-E".($numrow+2)) 
                ->setCellValue('H'.($numrow+2),"=SUM(H15:H".($numrow+1).")") 
                ->setCellValue('I'.($numrow+2),"=SUM(I15:I".($numrow+1).")") 
                ->setCellValue('J'.($numrow+2),"=SUM(J15:J".($numrow+1).")") 
                ->setCellValue('K'.($numrow+2),"=SUM(K15:K".($numrow+1).")") 
                ;

      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('E'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 
      
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('F'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('G'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('H'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('I'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('I'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('J'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('J'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('K'.($numrow+2))->applyFromArray($style_row_hsl);
      $objPHPExcel->getActiveSheet()->getStyle('K'.($numrow+2))->getNumberFormat()->setFormatCode('_(#,##_);_(\(#,##\);_("-"??_);_(@_)'); 

      $objPHPExcel->getActiveSheet()->getStyle('A15:A'.($numrow+1))->applyFromArray($style_col);
      $objPHPExcel->getActiveSheet()->getStyle('B15:B'.($numrow+1))->applyFromArray($style_col);
      $objPHPExcel->getActiveSheet()->getStyle('C15:C'.($numrow+1))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('D15:D'.($numrow+1))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('E15:E'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('F15:F'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('G15:G'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('H15:H'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('I15:I'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('J15:J'.($numrow+1))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('K15:K'.($numrow+1))->applyFromArray($style_col3);

      $objPHPExcel->getActiveSheet()->getStyle('A15:A'.($numrow+2))->applyFromArray($style_col);
      $objPHPExcel->getActiveSheet()->getStyle('B15:B'.($numrow+2))->applyFromArray($style_col);
      $objPHPExcel->getActiveSheet()->getStyle('C15:C'.($numrow+2))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('D15:D'.($numrow+2))->applyFromArray($style_col1);
      $objPHPExcel->getActiveSheet()->getStyle('E15:E'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('F15:F'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('G15:G'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('H15:H'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('I15:I'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('J15:J'.($numrow+2))->applyFromArray($style_col3);
      $objPHPExcel->getActiveSheet()->getStyle('K15:K'.($numrow+2))->applyFromArray($style_col3);
     
      /*
     $query	= $this->Lap_rekap_mdl->get_rekap_ppn_jkpjg($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('I15',$row['OLEH_PEMUNGUT'])
                ->setCellValue('J15',$row['DIBEBASKAN'])
                ->setCellValue('K15',$row['BUKAN_PPN'])
                ;
		 }
     */    
			
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$objPHPExcel->getActiveSheet(0)->setTitle("Lap PDD JKPDK");
		$objPHPExcel->setActiveSheetIndex(0);
        
		
		$this->getFooterXLS($fileName,$objPHPExcel);       

    }

    function cetak_pymad()
	{

		$tahun 		= $_REQUEST['tahun'];
		$bulandari	= $_REQUEST['bulanfrom'];
		$bulanke	= $_REQUEST['bulanto'];
		$cabang		= $_REQUEST['cabang'];
		
		$shortMonthArr 		= array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$bulanTeks			= $shortMonthArr[$bulandari];
		
		$date	    = date("Y-m-d H:i:s");
		
        $fileName = 'RekapitulasiPYMAD.xlsx';	
        $objPHPExcel = $this->getHeaderXLS($fileName);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A3','REKAPITULASI PENDAPATAN YANG MASIH AKAN DITERIMA TAHUN '.($tahun-1).' dan '.$tahun);

        //bagian atas
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E4',($tahun-1))
        ->setCellValue('F4',$tahun)
        ;

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G5',($tahun-1).'-'.$tahun)
        ;

        //bagian bawah
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E76',($tahun-1))
        ->setCellValue('F76',$tahun)
        ;

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G77',($tahun-1).'-'.$tahun)
        ;
        
        //KAPAL
        $numrow = 8;
        $query	= $this->Lap_rekap_mdl->get_rekap_pymad_kapal($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
                ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
                ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
                ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
                ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
                ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
                ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
                ;     
                $numrow++;  
		 }

     $numrow = 8;
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_kapal($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
                $numrow++;  
		 }

     $numrow = 20;
         //BARANG
         $query	= $this->Lap_rekap_mdl->get_rekap_pymad_barang($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;     
          $numrow++;  
		 }

     $numrow = 20;
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_barang($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++;  
		 }

     //PERALATAN
     $numrow = 27;    
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_peralatan($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;     
          $numrow++; 
		 }

     $numrow = 27; 
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_peralatan($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++; 
		 }


     //PELAYANAN TERMINAL
     $numrow = 31; 
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_plyn_terminal($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;     
          $numrow++; 
		 }

     $numrow = 31; 
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_plyn_terminal($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++; 
		 }

         //PETIKEMAS
        $numrow = 36; 
        $query	= $this->Lap_rekap_mdl->get_rekap_pymad_petikemas($cabang,$bulandari,$bulanke,($tahun-1));
        foreach($query->result_array() as $row) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
            ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
            ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
            ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
            ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
            ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
            ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
            ;     
            $numrow++; 
        }

     $numrow = 36;    
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_petikemas($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++; 
		 }


         //TBAL
      $numrow = 46;   
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_tbal($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;     
          $numrow++; 
		 }

     $numrow = 46;
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_tbal($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++; 
		 }

         //RUPA RUPA
     $numrow = 52;    
      $query	= $this->Lap_rekap_mdl->get_rekap_pymad_rupa($cabang,$bulandari,$bulanke,($tahun-1));
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
          ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
          ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
          ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
          ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
          ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
          ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
          ;     
          $numrow++; 
		 }

     $numrow = 52; 
     $query	= $this->Lap_rekap_mdl->get_rekap_pymad_rupa($cabang,$bulandari,$bulanke,$tahun);
		 foreach($query->result_array() as $row) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
          $numrow++; 
		 }

         //PYMAD PIHAK BERELASI
         $numrow = 58; 
        $query	= $this->Lap_rekap_mdl->get_rekap_pymad_berelasi($cabang,$bulandari,$bulanke,($tahun-1));
        foreach($query->result_array() as $row) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1,$numrow,$row['COA'])
            ->setCellValueByColumnAndRow(2,$numrow,$row['COA_DESC'])
            ->setCellValueByColumnAndRow(4,$numrow,$row['JML_URAIAN'])
            ->setCellValueByColumnAndRow(7,$numrow,$row['SENDIRI'])
            ->setCellValueByColumnAndRow(8,$numrow,$row['OLEH_PEMUNGUT'])
            ->setCellValueByColumnAndRow(9,$numrow,$row['DIBEBASKAN'])
            ->setCellValueByColumnAndRow(10,$numrow,"=F".$numrow."-(H".$numrow."+I".$numrow."+J".$numrow.")")
            ;     
            $numrow++; 
        }

        $numrow = 58; 
        $query	= $this->Lap_rekap_mdl->get_rekap_pymad_berelasi($cabang,$bulandari,$bulanke,$tahun);
        foreach($query->result_array() as $row) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(5,$numrow,$row['JML_URAIAN']);
            $numrow++; 
        }

			
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		// Set judul file excel nya
		$objPHPExcel->getActiveSheet(0)->setTitle("Lap PYMAD");
		$objPHPExcel->setActiveSheetIndex(0);
        
		
		$this->getFooterXLS($fileName,$objPHPExcel);   

    }
    

}