<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_kartu_kerja extends CI_Controller {

    function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
      redirect('dashboard', 'refresh');
    }

		$this->load->model('cabang_mdl');
		$this->load->model('Pph_mdl');
		$this->load->model('Pph_badan_mdl');
		$this->load->model('Kertas_kerja_mdl');
	}

  function cetak_kartu_kerja_xls() {
		$date	    = date("Y-m-d H:i:s");
		$jeniskk 	= $_REQUEST['jeniskk'];
		$nmjeniskk 	= $_REQUEST['nmjeniskk'];
		$tahundari 		= $_REQUEST['tahundari'];
		$tahunke 		= $_REQUEST['tahunke'];
		$bulandari		= $_REQUEST['bulandari'];
		$bulanke		= $_REQUEST['bulanke'];
		$masa		= $_REQUEST['namabulan'];
    $cabang		= $_REQUEST['kd_cabang'];
    
    switch ($jeniskk) {
      case "final":
        $this->cetak_kk_final_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "pajakkini":
        $this->cetak_kk_pajak_kini_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "kerjatangguhan":
        $this->cetak_kk_kerja_tangguhan_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "mappinggltosptpph":
        $this->cetak_kk_mapping_gl_to_sptpph_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "pajakkinitangguhan":
        $this->cetak_kk_pajak_kini_tangguhan_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "bebanbonus":
        $this->cetak_kk_beban_bonus_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "bebantantiem":
        $this->cetak_kk_beban_tantiem_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "uangsakudinas":
        $this->cetak_kk_uang_saku_dinas_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "bebanobligasi":
        $this->cetak_kk_beban_obligasi_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "penyisihanpiutang":
        $this->cetak_kk_penyisihan_piutang_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
        break;
      case "imbalankerjapegawai":
        $this->cetak_kk_imbalan_kerja_pegawai_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
		  break;
	  case "rekapaset":
		$this->cetak_kk_rekap_asset_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
		  break;	
	  case "biayalain":
		$this->cetak_kk_biaya_lain_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
		break;
	  case "bebanbersama":
		 $this->cetak_kk_beban_bersama_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang);
		 break;			
	  }
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
      ->setTitle("Cetak Kertas Kerja")
      ->setSubject("Cetakan")
      ->setDescription("Cetak KK Setahun")
      ->setKeywords("KK");

    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    $objPHPExcel = $objReader->load($fileTemplate);
    return $objPHPExcel;
  }
    
  function cetak_kk_final_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {		
    $fileName = 'KertasKerjaFinal.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);
	//$objPHPExcel->setActiveSheetIndex(0)
	$bulandrname = "";
	$bulankename = "";
    if($bulandari != ""){
		$bulandrname = $this->getMonthString($bulandari);
	}

	if($bulanke != ""){
		$bulankename = $this->getMonthString($bulanke);
	}
	

	$jdlbln = "BULAN ".$bulandrname." ".$tahundari." - ".$bulankename." ".$tahundari." TAHUN ".$tahundari;
	$objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('B2','KERTAS KERJA PERHITUNGAN PAJAK PENGHASILAN BADAN '.$jdlbln)
	 ->setCellValue('H5','SPT PPh TAHUN '.$tahundari)
	 ;
	 //get detail 7
	 
	 		$vservcode ="";			
			$vscode701 ="'0111','0112','0113','0114','0115','0116','0117','0119','0122','0123','0124','0131','0132','0133','0134','0135','0139'";
			$vscode702 ="'0211','0212','0213','0219','0221','0222','0229'";
			$vscode703 ="'0311','0312','0319','0322','0327','0327','0331','0335','0338'";
			$vscode704 ="'0401','0402','0403','0404','0405','0406','0408','0411','0412','0413','0415','0416','0420','0423','0424','0433','0433','0499'";
			$vscode705 ="'0501','0502','0503','0510','0511','0512','0513','0516','0517','0531','0533','0534','0535','0537','0538','0539',
			'0562','0563','0566','0567','0568','0572','0573','0599'";
			$vscode706 ="'0601','0602','0603','0604','0605','0610','0623','0624','0625','0699'";
			$vscode707 ="'0701','0702','0706','0711','0712','0713','0719','0731','0732','0734','0742','0751','0754','0755','0763','0799'";
			$vscode708 ="'0811','0812','0751','0799','0812','0799'";
			$vscode721 ="'0111','0112','0113','0114','0115','0119'";
			$vscode722 ="'0211','0213'";
			$vscode725 ="'0401','0404'";
			$vscode725_2 ="'0501','0502'";
			$vscode726 = "'0701','0799'";

			$vautoservcode706 = array("0601","0602","0623","0624","0625","0699");
			
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70101101',$vscode701);
		 $i = 13;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70101101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70201101',$vscode702);
		 $i = 33;
		 //$i = $i +3;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70201101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,($row['SPT']*-1)) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70301101',$vscode703);
		 $i = 43;
		 //$i = $i +3;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70301101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70401101',$vscode704);
		 $i = 55;
		 //$i = $i +4;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70401101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70501101',$vscode705);
		 $i = 77;
		 //$i = $i +5;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70501101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,$row['JML_URAIAN'])
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
		 $i = 104;
		 //$i = $i +3;
		 foreach($query->result_array() as $row) {
			 $vamntneg = 0;
			 if(in_array($row['KODE_JASA'], $vautoservcode706)){
				$vamntneg = abs($row['JML_URAIAN']);
			 } else {
				$vamntneg = abs($row['AMOUNT_NEGATIF']);
			 }
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70601101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($vamntneg)) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70701101',$vscode707);
		 $i = 117;
		// $i = $i +3;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70701101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70801101',$vscode708);
		 $i = 137;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70801101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72101101',$vscode721);
		 $i = 150;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"72101101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72201101',$vscode722);
		 $i = 158;
		 $i = $i +1;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"72201101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725);
		 $i = 162;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"72501101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725_2);
		 $i = 167;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"72501101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72601101',$vscode726);
		 $i = 172;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"72601101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		
		 $vcoa100 = "'80101011','80101012','80101021','80101031','80101032','80101033','80101034','80101035','80101036','80101037','80101038',
		 '80101039','80101041','80101042','80101043','80101044','80101045','80101046','80101051','80101061','80101063','80101064','80101071','80101081','80101091',
		 '80101901','80101999'";
		 $vcoa200 = "'80102101','80102102','80102103','80102104','80102105','80102106','80102107','80102108',
		 '80102109','80102110','80102111','80102113','80102191'";
		 $vcoa300 = "'80103105','80103106'";
		 $vcoa300_2 = "'80103013','80103211','80103221','80103231','80103241','80103251','80103261','80103271','80103272',
		 '80103281','80103291'";
		 $vcoa300_3 = "'80103303','80103399'";
		 $vcoa300_4 = "'80103471','80103472','80103481'";
		 $vcoa300_5 = "'80103511','80103571','80103581'";
		 $vcoa400 	= "'80104101','80104103','80104104','80104106','80104107','80104108'";
		 $vcoa400_2 = "'80104211','80104221','80104231','80104241','80104261','80104271','80104272',
		 '80104281','80104299'";
		 $vcoa400_3 = "'80104322'";
		 $vcoa400_4 = "'80104411','80104461'";
		 $vcoa400_5 = "'80104511','80104531','80104541','80104591'";
		 $vcoa400_6 = "'80104701','80104702'";
		 $vcoa400_7 = "'80104601','80104602','80104603','80104604','80104605','80104606','80104607','80104699'
		 ,'80104801','80104803','80104804','80104807','80104806','80104810'";
		 $vcoa500 = "'80105211','80105221','80105231','80105241','80105251','80105261','80105271','80105272',
		 '80105281','80105291'";
		 $vcoa500_2 = "'80105399'";
		 $vcoa500_3 = "'80105411','80105471'";
		 $vcoa500_4 = "'80105511','80105531','80105611','80105999'";
		 $vcoa600	= "'80106111','80106121','80106131','80106141','80106151','80106161','80106171','80106181',
		 '80106182','80106191','80106201','80106211','80106311','80106901','80106925','80106911',
		 '80106924','80106999'";
		 $vcoa700	= "'80107101','80107102','80107103','80107104','80107105','80107106','80107107',
		 '80107108','80107109','80107110','80107112','80107110','80107999'";
		 $vcoa800	= "'80108011','80108012','80108021','80108031','80108041','80108051','80108061','80108071',
		 '80108081','80108101','80108111','80108121','80108131','80108141','80108151','80108161','80108171',
		 '80108172','80108173','80108174','80108181','80108182','80108191','80108201','80108202','80108211',
		 '80108221','80108223','80108222','80108226','80108227','80108228','80108229','80108999'";

		 $vautocoa801 = array("80108061","80108121","80108131","80108161","80108162","80108163","80108181","80108182","80108191","80108226");
		$vautocoa801_2 = array("80101012","80101051","80101071");
		$vautocoa801_3 = array("80107104","80107105");
		$vautocoa801_4 = array("80102107");

		$vamntbonus = 0;
		$vbbnbonus = 0;
		$vjmlbonus = 0;
		$query = $this->Kertas_kerja_mdl->get_kk_final_bonus($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row2) 
		{
			$vamntbonus += $row2['AMOUNT_BONUS'] + $row2['AMOUNT_BONUS_EX'];
			$vbbnbonus += $row2['BEBAN_BONUS'];
		}
		$vjmlbonus = $vbbnbonus - $vamntbonus;


		$vamnttantiem = 0;
		$vbbntantiem = 0;
		$vjmltantiem = 0;
		$query = $this->Kertas_kerja_mdl->get_kk_final_tantiem($tahundari);
		foreach($query->result_array() as $row2) 
		{
			$vamnttantiem += $row2['JUMLAH_TANTIEM'];
		}

		$query = $this->Kertas_kerja_mdl->get_kk_final_bbn_tantiem($bulandari,$bulanke,$tahundari);
		foreach($query->result_array() as $row2) 
		{
			$vbbntantiem += $row2['JML_BEBAN_TANTIEM'];
		}
		$vjmltantiem = $vbbntantiem - $vamnttantiem ;
		 
		 $vservcode="";
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa100,$vservcode);
		 $i = 181;
		 foreach($query->result_array() as $row) {
			 $vamntpos100 = 0;
			if(in_array($row['KODE_AKUN'], $vautocoa801_2)) {	
				if ($row['KODE_AKUN'] === '80101051'){
					$vamntpos100 = $vjmlbonus;
				} else if ($row['KODE_AKUN'] === '80101071') {
					$vamntpos100 = $vjmltantiem;
				} else {
					$vamntpos100 = $row['JML_URAIAN'];
				}	
				
			} else {
				$vamntpos100 = $row['AMOUNT_POSITIF'];
			}

				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($vamntpos100)) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa200,$vservcode);
		 $i = 211;
		 foreach($query->result_array() as $row) {
			$vamntpos200 = 0;
			if(in_array($row['KODE_AKUN'], $vautocoa801_4)) {	
				$vamntpos200 = $row['JML_URAIAN'];	
			} else {
				$vamntpos200 = $row['AMOUNT_POSITIF'];
			}

				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($vamntpos200)) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300,$vservcode);
		 $i = 227;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_2,$vservcode);
		 $i = 232;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_3,$vservcode);
		 $i = 246;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_4,$vservcode);
		 $i = 251;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_5,$vservcode);
		 $i = 257;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400,$vservcode);
		 $i = 264;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_2,$vservcode);
		 $i = 273;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_3,$vservcode);
		 $i = 285;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_4,$vservcode);
		 $i = 289;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_5,$vservcode);
		 $i = 294;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_6,$vservcode);
		 $i = 302;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_7,$vservcode);
		 $i = 307;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500,$vservcode);
		 $i = 328;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_2,$vservcode);
		 $i = 341;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_3,$vservcode);
		 $i = 345;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_4,$vservcode);
		 $i = 350;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa600,$vservcode);
		 $i = 358;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa700,$vservcode);
		 $i = 379;
		 foreach($query->result_array() as $row) {
			$vamntpos = 0;
			if(in_array($row['KODE_AKUN'], $vautocoa801_3)) {
				$vamntpos = ($row['JML_URAIAN']*-1);
			} else {
				$vamntpos = $row['AMOUNT_POSITIF'];
			}
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($vamntpos)) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa800,$vservcode);
		 $i = 395;
		 foreach($query->result_array() as $row) {
			$vamntpos = 0;
			if(in_array($row['KODE_AKUN'], $vautocoa801)) {
				$vamntpos = ($row['JML_URAIAN']*-1);
			} else {
				$vamntpos = $row['AMOUNT_POSITIF'];
			}
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($vamntpos)) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }
		  
		 $vcoa791 = "'79103111','79103112','79103999','79101141','79101161','79101171','79101172','79104101',
		 '79104104','79104107','79199999','79101151','79101152','89101171','79101121','79101131','79101181',
		 '79101182','79101183','79101189','79102111','79102112','79102113','89101183','79101180'";

		 $vcoa891 = "'89101221','79101111','89101111','89101121','89101901','89101902','89101906','89101908','89101211','89101173',
		 '89101194','89101209','89101916','89101917','89101918','89101919','89101999','89199999','89101201','89101909',
		 '89101151','89101163','89101162','89101161','89101131','89101141','89101142'";

		 $vautocoa791 = array("79101121", "79101131", "79101183", "79101189", "79101181");
		 $vautocoa891 = array("89101211", "89101194","89101151","89101161","89101131","89101141","89101142");

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa791,$vservcode);
		 $i = 437;
		 foreach($query->result_array() as $row) {
			$vamntneg = 0;
				if(in_array($row['KODE_AKUN'], $vautocoa791)) {
					$vamntneg = ($row['JML_URAIAN']*-1);
				} else {	
					$vamntneg = $row['AMOUNT_NEGATIF'];
				}
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_POSITIF'])) 
				->setCellValueByColumnAndRow(6,$i,abs($vamntneg)) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT']*-1)) 
				;
				$i++;
		 }

		 $vrincobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_rincian_obligasi($tahundari); 
		 foreach($qobligasi->result_array() as $rowobl) {
			$vrincobl = $rowobl['TOTAL_RINCIAN'];
		 }
		 $vrincobl = $vrincobl / 12;
		 
		 $vutangobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_utang_obligasi($tahundari);
		 foreach($qobligasi->result_array() as $rowobl) {
			$vutangobl = $rowobl['UTANG_OBLIGASI'];
		 }

		 $vutangobl = $vutangobl / 12;
		 
		 $jml_obl = 0;
		 $jml_obl = abs($vutangobl) - abs($vrincobl);
		 $jml_oblz = ((abs($jml_obl) / abs($vutangobl)) * 100); 
		 $jml_obl = 100 - $jml_oblz;

		 $vbebanobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_beban_obligasi($bulandari, $bulanke, $tahundari);
		 foreach($qobligasi->result_array() as $rowobl) {
			$vbebanobl = $rowobl['JML_BEBAN_OBLIGASI'];
		 }
	
		 $jml_obl = ($jml_obl * abs($vbebanobl)) / 100;

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa891,$vservcode);
		 $i = 466;
		 foreach($query->result_array() as $row) {
			$vamntpos = 0;
			if(in_array($row['KODE_AKUN'], $vautocoa891)) {
				$vamntpos = ($row['JML_URAIAN']*-1);
			} else {
				if($row['KODE_AKUN'] === '89101162'){
					$vamntpos = floor($jml_obl);
				} else {
					$vamntpos = $row['AMOUNT_POSITIF'];
				}
			}
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,$row['KODE_AKUN']." ".$row['AKUN_DESCRIPTION'])
				->setCellValueByColumnAndRow(4,$i,abs($row['JML_URAIAN']))
				->setCellValueByColumnAndRow(5,$i,abs($vamntpos)) 
				->setCellValueByColumnAndRow(6,$i,abs($row['AMOUNT_NEGATIF'])) 
				->setCellValueByColumnAndRow(7,$i,abs($row['SPT'])) 
				;
				$i++;
		 }

		//get cabang
		$i = 501;
		$no = 1;
		$qcabang = $this->Kertas_kerja_mdl->get_kk_cabang();		
		foreach($qcabang->result_array() as $row) {
				$query	= $this->Kertas_kerja_mdl->get_kk_aset_beban_final($bulandari,$tahundari,$row['KODE_CABANG']);
				foreach($query->result_array() as $row1) {
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(2,$i,$no)
					->setCellValueByColumnAndRow(3,$i,$row['NAMA_CABANG'])
					->setCellValueByColumnAndRow(5,$i,$row1['PEMBEBANAN']);
				}
			$i++;
			$no++;	
		}	
		
		$objPHPExcel->setActiveSheetIndex(0)
		 ->setCellValue('C544','LABA KENA PAJAK '.($tahundari-1))
		 ->setCellValue('C546','LABA (RUGI) PAJAK '.($tahundari-1).' (Pembulatan) ')
		 ->setCellValue('C547','PPH TERUTANG '.($tahundari-1))
		 ;

		//pph
		$vcoa ="'10901201'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 $i = 555;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(7,$i,abs($row['JML_URAIAN']))
				;
				$i++;
		 }
		 $vcoa ="'10901301'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 $i = 556;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(7,$i,abs($row['JML_URAIAN']))
				;
				$i++;
		 }
		 $vcoa ="'10901401'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 $i = 557;
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(7,$i,abs($row['JML_URAIAN']))
				;
				$i++;
		 }
	
		 
	$this->getFooterXLS($fileName,$objPHPExcel,$objWriter); 
  }

  function cetak_kk_pajak_kini_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {	
    $fileName = 'KertasKerjaPajakKini.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);
	$objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('F5','Tahun '.$tahundari.' (AUDITED)');

	  $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('F95','Tahun '.$tahundari.' (AUDITED)');

	  $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('G171','thn '.$tahundari.'');

	  $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('A3','PERHITUNGAN PAJAK KINI TAHUN '.$tahundari.' PT PELABUHAN INDONESIA II (PERSERO)');

	  $vamntbonus = 0;
		$vbbnbonus = 0;
		$vjmlbonus = 0;
		$query = $this->Kertas_kerja_mdl->get_kk_final_bonus($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row2) 
		{
			$vamntbonus += $row2['AMOUNT_BONUS'] + $row2['AMOUNT_BONUS_EX'];
			$vbbnbonus += $row2['BEBAN_BONUS'];
		}
		$vjmlbonus = $vbbnbonus - $vamntbonus;


		$vamnttantiem = 0;
		$vbbntantiem = 0;
		$vjmltantiem = 0;
		$query = $this->Kertas_kerja_mdl->get_kk_final_tantiem($tahundari);
		foreach($query->result_array() as $row2) 
		{
			$vamnttantiem += $row2['JUMLAH_TANTIEM'];
		}

		$query = $this->Kertas_kerja_mdl->get_kk_final_bbn_tantiem($bulandari,$bulanke,$tahundari);
		foreach($query->result_array() as $row2) 
		{
			$vbbntantiem += $row2['JML_BEBAN_TANTIEM'];
		}
		$vjmltantiem = $vbbntantiem - $vamnttantiem ;
	  
		//Bonus/jasa produksi
		/*
		$query = $this->Kertas_kerja_mdl->getkk_pajak_kini_akun($bulandari,$bulanke,$tahundari,$cabang,'80101051');
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F15',$row['AM_POSITIF'] + $row['AM_NEGATIF']);
		}
		*/
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80101051'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D15',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F15',$vjmlbonus);
		}

		//Tantiem 
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80101071'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D16',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F16',$vjmltantiem);
		}			

		$vservcode ="";
		//Beban Pajak PPh Pasal 21 Ditanggung Pemberi Kerja
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80101012'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D17',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F17',$row['JML_URAIAN']);
		}	

		//Obat-Obatan/Bahan Medis
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80102107'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D20',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F20',$row['JML_URAIAN']);
		}	

		//Beban Bahan Lain-Lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80102191'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D21',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F21',$row['JML_URAIAN']);
		}

		//Beban Pemel. Kendaraan
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80103281'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D24',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F24',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Beban Asuransi Lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80105999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D27',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F27',$row['JML_URAIAN']);
		}

		//ksmu kendaraan
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80106181'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D30',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F30',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		//ksmu lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80106311'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D31',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F31',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		//ksmu kompensasi tanah dan bangunan
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80106999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D32',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F32',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		//ksmu sewa lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80106999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D33',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F33',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Surat Kabar, Majalah, Bulletin & Buku
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80107104'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D36',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F36',$row['JML_URAIAN']);
		}

		// Ruangan dan Peralatan rapat
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80107105'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D37',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F37',$row['JML_URAIAN']);
		}

		// Rumah Tangga
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80107106'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D38',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F38',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Jamuan Rapat
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80107107'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D39',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F39',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Administrasi Kantor Lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80107999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D40',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F40',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Perjalanan Dinas
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108011'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D43',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F43',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		} 

		// Penyisihan Piutang
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108021'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D44',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F44',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Beban Keamanan Pelabuhan 
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108041'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D45',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F45',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}


		// Beban Promosi / Pemasaran 
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108061'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D46',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F46',$row['JML_URAIAN']);
		}

		// Beban Olah Raga & Kesenian 
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108121'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D47',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F47',$row['JML_URAIAN']);
		}

		// Pakaian Dinas 
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108131'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D48',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F48',$row['JML_URAIAN']);
		}

		// Bantuan Sosial
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108161'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D49',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F49',$row['JML_URAIAN']);
		}

		// Perawatan Kesehatan Pekerja
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108181'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D50',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F50',$row['JML_URAIAN']);
		}

		// Beban BPJS
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108182'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D51',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F51',$row['JML_URAIAN']);
		}

		// Beban Iklan
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108191'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D52',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F52',$row['JML_URAIAN']);
		}

		// Denda Kekurangan pajak
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101211'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D53',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F53',$row['JML_URAIAN']);
		}

		// Beban Umum lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,"'80108999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D54',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F54',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}


		// Beban Koreksi Final
		$i = 57;
		$no = 1;
		$qcabang = $this->Kertas_kerja_mdl->get_kk_cabang();		
		foreach($qcabang->result_array() as $row) {
				$query	= $this->Kertas_kerja_mdl->get_kk_aset_beban_final($bulandari,$tahundari,$row['KODE_CABANG']);
				foreach($query->result_array() as $row1) {
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(2,$i,$no)
					->setCellValueByColumnAndRow(3,$i,$row['NAMA_CABANG'])
					->setCellValueByColumnAndRow(5,$i,$row1['PEMBEBANAN']);
				}
			$i++;
			$no++;	
		}


		// Pajak Final Giro dan Deposito
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101131'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D73',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F73',$row['JML_URAIAN']);
		}

		// Pajak Final Sewa Tanah dan  Bangunan
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101141'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D74',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F74',$row['JML_URAIAN']);
		}
     
		// Jasa/Administrasi Bank
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101151'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D75',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F75',$row['JML_URAIAN']);
		}
		
		// Beban Bunga Obligasi   
		$vrincobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_rincian_obligasi($tahundari); 
		 foreach($qobligasi->result_array() as $rowobl) {
			$vrincobl = $rowobl['TOTAL_RINCIAN'];
		 }
		 $vrincobl = $vrincobl / 12;
		 
		 $vutangobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_utang_obligasi($tahundari);
		 foreach($qobligasi->result_array() as $rowobl) {
			$vutangobl = $rowobl['UTANG_OBLIGASI'];
		 }

		 $vutangobl = $vutangobl / 12;
		 
		 $jml_obl = 0;
		 $jml_obl = abs($vutangobl) - abs($vrincobl);
		 $jml_oblz = ((abs($jml_obl) / abs($vutangobl)) * 100); 
		 $jml_obl = 100 - $jml_oblz;

		 $vbebanobl = 0;
		 $qobligasi	= $this->Kertas_kerja_mdl->summ_beban_obligasi($bulandari, $bulanke, $tahundari);
		 foreach($qobligasi->result_array() as $rowobl) {
			$vbebanobl = $rowobl['JML_BEBAN_OBLIGASI'];
		 }
	
		 $jml_obl = ($jml_obl * abs($vbebanobl)) / 100;
		 
		 $vamntpos = floor($jml_obl);
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101162'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D76',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F76',$vamntpos);
		}

		// Pengobatan Pensiunan
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101194'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D77',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F77',$row['JML_URAIAN']);
		}

		// Denda Kekurangan Pajak
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101211'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D78',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F78',$row['JML_URAIAN']);
		}
		
		// Rounding  
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101916'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D79',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F79',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Pengerukan Alur 
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101201'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D80',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F80',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		// Pajak Final Lainnya
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89101142'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D81',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F81',$row['JML_URAIAN']);
		}

		// Beban Diluar Usaha Lainnya 
		$query = $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,"'89199999'",$vservcode);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D82',$row['KODE_AKUN'].' - '.$row['AKUN_DESCRIPTION'])
			->setCellValue('F82',$row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		}

		//Pendapatan Usaha
		$vscode706 ="'0601','0602','0624'";

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
		 $i = 90;
		 foreach($query->result_array() as $row) {
			 $vamntneg = 0;
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70601101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(5,$i,abs($row['JML_URAIAN']))  
				;
				$i++;
		 }

		 $vscode707 ="'0751'";

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70701101',$vscode707);
		 $i = 93;
		 foreach($query->result_array() as $row) {
			 $vamntneg = 0;
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$i,"70701101 - ".$row['JASA_DESCRIPTION'])
				->setCellValueByColumnAndRow(5,$i,abs($row['AMOUNT_NEGATIF']))  
				;
				$i++;
		 }
		
		// Piutang PYMAD 
		$nilaiKomersil= 0;
		$amortisasiKomersilU = 0;
		$query = $this->Kertas_kerja_mdl->getkk_pajak_kini_piutang_komersil($bulandari,$bulanke,$tahundari,$cabang,'89199999');
		foreach($query->result_array() as $row) {
			$nilaiKomersil +=  $row['JML_URAIAN'];

			if(substr($row['KODE_AKUN'],0,6)=='801046' || substr($row['KODE_AKUN'],0,6)=='801048'){
				$amortisasiKomersilU	+= $row['JML_URAIAN'];			
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('F116',$nilaiKomersil)
		->setCellValue('F124',$amortisasiKomersilU);

		// pph_22 pph_23 pph_25
		$vcoa ="'10901201'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F147',$row['JML_URAIAN']);
		 }
		 $vcoa ="'10901301'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F148',$row['JML_URAIAN']);
		 }
		 $vcoa ="'10901401'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F149',$row['JML_URAIAN']);
		 }

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_kerja_tangguhan_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {
    $fileName = 'KertasKerjaTangguhan.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);		
	$objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('I5',$tahundari)
	  ->setCellValue('I18',$tahundari)
	  ->setCellValue('C32','Jurnal pengakuan beban pajak tahun '.$tahundari)
	  ->setCellValue('C34','Mencatat beban pajak kini tahun '.$tahundari)
	  ->setCellValue('C39','Mencatat beban (penghasilan) pajak tangguhan tahun '.$tahundari)
	  ->setCellValue('C44','Mencatat perhitungan pajak dibayar dimuka PPh 22, PPh 23 dan PPh 25 dengan Hutang Pajak Badan tahun '.$tahundari)
	  ->setCellValue('G55','TAHUN '.$tahundari)
	  ->setCellValue('H55','TAHUN '.$tahundari)
	  ;
	  if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}
	
	  $i = 59;
	  $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('F61','Nilai Buku sd'.$tahundari)
	  ->setCellValue('F65','Nilai Buku '.($tahundari+1).' dst');

		$query = $this->Kertas_kerja_mdl->akumulasipenyasset($bulandari, $bulanke, $tahundari);
		$vakpakun = 0;
		foreach($query->result_array() as $row) 
		{
			$vakpakun = $row['VJMLPENYASSET'];
		}

		$vfajmlbangunan =0;
		$vfajmlnonbangunan =0;
		$vfatotalperolehan = 0;
		$vfajmlbangunan2 =0;
		$vfajmlnonbangunan2 =0;
		$vfatotalperolehan2 = 0;
		$vfahrgtdkberwujud = 0;
		$vfabebantangguhkan = 0;
		$vfatotaltdkberwujud = 0;
		$vakpenyfiskal = 0;
		$resultfa = $this->Kertas_kerja_mdl->getkkkinitangguhan($bulandari, $bulanke, $tahundari,$cabang);
		foreach($resultfa->result_array() as $rowfa) {
			$vfajmlbangunan = $rowfa['NILAIBANGUNAN'];
			$vfajmlnonbangunan = $rowfa['NILAINONBANGUNAN'];
			$vfajmlbangunan2 = $rowfa['NILAIBANGUNAN2'];
			$vfajmlnonbangunan2 = $rowfa['NILAINONBANGUNAN2'];
			$vfahrgtdkberwujud = $rowfa['NILAITIDAKBERWUJUD'];
			$vfabebantangguhkan = $rowfa['BEBANDITANGGUHKAN'];
			$vfatotalperolehan += $vfajmlbangunan + $vfajmlnonbangunan;
			$vfatotalperolehan2 += $vfajmlbangunan2 + $vfajmlnonbangunan2;
			$vfatotaltdkberwujud += $vfahrgtdkberwujud + $vfabebantangguhkan;
			$vakpenyfiskal = $rowfa['AKPENYBERWUJUD']*-1;
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(6,$i,$vfatotalperolehan)
			->setCellValueByColumnAndRow(6,$i+4,$vfatotalperolehan2)
			->setCellValueByColumnAndRow(6,$i+1,$vakpakun)
			->setCellValueByColumnAndRow(6,$i+5,$rowfa['AKPENYBERWUJUD2'])
				;
				$i++;
		}

		$resultpymad = $this->Kertas_kerja_mdl->pymadtangguhan($bulandari, $bulanke, $tahundari);
		$jmlakpymad = 0;
		foreach($resultpymad->result_array() as $rowpymad) {
			$jmlakpymad = $rowpymad['DESLAST'];
		}

		$query = $this->Kertas_kerja_mdl->akumulasipenyamor($bulandari, $bulanke, $tahundari);
		$vakpakunamor = 0;
		foreach($query->result_array() as $row) 
		{
		   $vakpakunamor = $row['VJMLPENYAMOR'];
		}	
	  
	  $result = $this->Kertas_kerja_mdl->getkktgghnakunt2($bulandari, $bulanke, $tahundari, $cabang);	
	  $i = 59;
	  foreach($result->result_array() as $row) {
		$objPHPExcel->setActiveSheetIndex(0)
		  ->setCellValueByColumnAndRow(6,$i+10,$vfatotaltdkberwujud) 
		  ->setCellValueByColumnAndRow(6,$i+11,$vakpakunamor)
		  ->setCellValueByColumnAndRow(6,$i+17,$jmlakpymad) 
		  ->setCellValueByColumnAndRow(6,$i+20,$row['K_MANFAAT_KARYAWAN'])
		  ->setCellValueByColumnAndRow(10,$i-11,$row['PPH_22'])
		  ->setCellValueByColumnAndRow(10,$i-10,$row['PPH_23'])
		  ->setCellValueByColumnAndRow(10,$i-9,$row['PPH_25']) 
		;
		$i++;
	  }

	  $result1 = $this->Kertas_kerja_mdl->getkktgghnfiskal2($bulandari, $bulanke, $tahundari, $cabang);	
	  $j = 59;
	  
	  foreach($result1->result_array() as $row1) {
		$objPHPExcel->setActiveSheetIndex(0)
		  ->setCellValueByColumnAndRow(7,$j,$vfatotalperolehan)
		  ->setCellValueByColumnAndRow(7,$j+1,$vakpenyfiskal)
		  ->setCellValueByColumnAndRow(7,$j+4,$vfatotalperolehan2)
		  ->setCellValueByColumnAndRow(7,$j+5,$row1['AK_NB_NYEAR'])
		  ->setCellValueByColumnAndRow(7,$j+10,$vfatotaltdkberwujud)
		  ->setCellValueByColumnAndRow(7,$j+11,$row1['AK_TDK_BERWUJUD'])
		;
		$i++;
	  }

	  // RATE
		$sqlrate = "select rate from simtax_master_rpt where aktif ='1' and tahun = ".$tahundari;
		$resultrate = $this->db->query($sqlrate);
		$vrate = 0;
		foreach($resultrate->result_array() as $rowrate) {
			$vrate =  $rowrate['RATE'];
		}

		$sqlrate = "select rate from simtax_master_rpt where aktif ='1' and tahun = ".($tahundari+1);
		$resultrate = $this->db->query($sqlrate);
		$vrate2 = 0;
		foreach($resultrate->result_array() as $rowrate) {
			$vrate2 =  $rowrate['RATE'];
		}

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('J61',$vrate.'%')
		->setCellValue('J65',$vrate2.'%')
		->setCellValue('J71',$vrate.'%')
		->setCellValue('J76',$vrate.'%')
		->setCellValue('J79',$vrate.'%')
		->setCellValue('J81',$vrate.'%')
		;
	  //END RATE

	  
	  // Hitung tahun sebelumnya
	  $sqlfa2 = "
	  select 
	  (
	      select nvl(sum(harga_perolehan),0)
			  from simtax_rekon_fixed_asset
			  where 1=1 ".$wcbgz." and tahun_pajak <= ".($tahundari-1)." and bulan_pajak between ".$bulandari." and ".$bulanke." 
			  and kelompok_fixed_asset = 'B'
	  ) as nilaibangunan,
	  (
		  select nvl(sum(harga_perolehan),0)
			  from simtax_rekon_fixed_asset
			  where 1=1 ".$wcbgz." and tahun_pajak  <= ".($tahundari-1)." and bulan_pajak between ".$bulandari." and ".$bulanke."
			  and kelompok_fixed_asset = 'N'
	  ) as nilainonbangunan,
	  
	(
		select nvl(sum(akumulasi_penyusutan),0)
        from simtax_rekon_fixed_asset
        where 1=1 ".$wcbgz." and tahun_pajak  <= ".($tahundari-1)." and bulan_pajak between ".$bulandari." and ".$bulanke."
        and kelompok_fixed_asset in ('B','N')
	  ) as akpenyberwujud,
	  (
		select nvl(sum(harga_perolehan),0)
		  from simtax_rekon_fixed_asset
		  where 1=1 ".$wcbgz." and tahun_pajak  = ".($tahundari-1)." and bulan_pajak between ".$bulandari." and ".$bulanke."
		  and kelompok_fixed_asset = 'T'
		) as nilaitidakberwujud,
		0 as bebanditangguhkan
		from dual
		";
		$resultfa2 = $this->db->query($sqlfa2);

		$vfajmlbangunanlast =0;
		$vfajmlnonbangunanlast =0;
		$vfatotalperolehanlast = 0;
		$vfahrgtdkberwujudlast = 0;
		$vfabebantangguhkanlast = 0;
		$vfatotaltdkberwujudlast = 0;
		foreach($resultfa2->result_array() as $rowfa) {
			$vfajmlbangunanlast = $rowfa['NILAIBANGUNAN'];
			$vfajmlnonbangunanlast = $rowfa['NILAINONBANGUNAN'];
			$vfahrgtdkberwujudlast = $rowfa['NILAITIDAKBERWUJUD'];
			$vfabebantangguhkanlast = $rowfa['BEBANDITANGGUHKAN'];
			$vfatotalperolehanlast += $vfajmlbangunanlast + $vfajmlnonbangunanlast;
			$vfatotaltdkberwujudlast += $vfahrgtdkberwujudlast + $vfabebantangguhkanlast;
		
		}
	 
	  $hrg_peroleh_akunt = 0;
	  $ak_pnysutan_akunt = 0;
	  $hrg_peroleh_atb_akunt = 0;
	  $ak_pnysutan_atb_akunt = 0;
	  $ak_pnysutan_pymad_akunt = 0;
	  $k_manfaat_karyawan = 0;
	  $pph_22 = 0;
	  $pph_23 = 0;
	  $pph_25 = 0;
	  $jml_akunt = 0;
	  $jml_akunt_atb = 0;
	  $query = $this->Kertas_kerja_mdl->getkktgghnakunt($bulandari,$bulanke,($tahundari-1),$cabang);
	  foreach($query->result_array() as $row) {
		//$hrg_peroleh_akunt = $row['HRG_PEROLEHAN_AKUNTANSI'];
		//$hrg_peroleh_atb_akunt = $row['HRG_PEROLEHAN_ATB_AKUNTANSI'];
		$hrg_peroleh_akunt = $vfatotalperolehanlast;
		$ak_pnysutan_akunt = $row['AK_PNYSUTAN_AKUNTANSI'];
		$hrg_peroleh_atb_akunt = $vfatotaltdkberwujudlast;
		$ak_pnysutan_atb_akunt = $row['AK_PNYSUTAN_ATB_AKUNTANSI'];
		$ak_pnysutan_pymad_akunt = $row['AK_PNYSUTAN_PYMAD_AKUNTANSI']; 
		$k_manfaat_karyawan = $row['K_MANFAAT_KARYAWAN'];
		$pph_22 = $row['PPH_22'];
		$pph_23 = $row['PPH_23'];
		$pph_25 = $row['PPH_25'];

		$jml_akunt =  $hrg_peroleh_akunt + $ak_pnysutan_akunt;
		$jml_akunt_atb = $hrg_peroleh_atb_akunt + $ak_pnysutan_atb_akunt;
	  }

	  $hrg_peroleh_fiskal = 0;
	  $ak_nb = 0;
	  $hrg_p_tdkberwujud = 0;
	  $ak_tdk_berwujud = 0;
	  $jml_akun_fiskal = 0;
	  $jml_atb_akun_fiskal = 0;
	  $ak_pymad_fiskal = 0;
	  $jml_pymad_fiskal = 0;
	  $query = $this->Kertas_kerja_mdl->getkktgghnfiskal($bulandari,$bulanke,($tahundari-1),$cabang);
	  foreach($query->result_array() as $row1) {
		//$hrg_peroleh_fiskal = $row1['HRG_PEROLEHAN_FISKAL'];
		//$hrg_p_tdkberwujud = $row1['HRG_P_TDKBERWUJUD'];
		$hrg_peroleh_fiskal = $vfatotalperolehanlast;
		$ak_nb = $row1['AK_NB'];
		$hrg_p_tdkberwujud = $vfatotaltdkberwujudlast;
		$ak_tdk_berwujud = $row1['AK_TDK_BERWUJUD'];
		$jml_akun_fiskal = $hrg_peroleh_fiskal + $ak_nb + 1;
		$jml_atb_akun_fiskal = $hrg_p_tdkberwujud + $ak_tdk_berwujud;
	  }

	  $jml_aktiva_atn = (($jml_akun_fiskal - $jml_akunt) * $vrate) / 100;
	  $jml_aktiva_atb = (($jml_atb_akun_fiskal - $jml_akunt_atb) * $vrate) / 100;
	  $jml_aktiva_pymad = (($jml_pymad_fiskal - $ak_pnysutan_pymad_akunt) * $vrate) /100;
	  $jml_k_manfaat_krywn = ($k_manfaat_karyawan * $vrate) / 100;
	  $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('K5',($tahundari-1))
	  ->setCellValue('K18',($tahundari-1))
	  ->setCellValue('K21',$jml_aktiva_atn)
	  ->setCellValue('K22',$jml_aktiva_atb)
	  ->setCellValue('K23',$jml_aktiva_pymad)
	  ->setCellValue('K24',$jml_k_manfaat_krywn)
	  ;
	  $total1before = $jml_aktiva_atn + $jml_aktiva_atb + $jml_aktiva_pymad + $jml_k_manfaat_krywn;

	  // End Hitung tahun sebelumnya
/*
	  // Hitung 2 tahun  sebelumnya 
	  $query = $this->Kertas_kerja_mdl->getkktgghnakunt($bulandari,$bulanke,($tahundari-2),$cabang);
	
	  foreach($query->result_array() as $row) {
		$hrg_peroleh_akunt = $row['HRG_PEROLEHAN_AKUNTANSI'];
		$ak_pnysutan_akunt = $row['AK_PNYSUTAN_AKUNTANSI'];
		$hrg_peroleh_atb_akunt = $row['HRG_PEROLEHAN_ATB_AKUNTANSI'];
		$ak_pnysutan_atb_akunt = $row['AK_PNYSUTAN_ATB_AKUNTANSI'];
		$ak_pnysutan_pymad_akunt = $row['AK_PNYSUTAN_PYMAD_AKUNTANSI']; 
		$k_manfaat_karyawan = $row['K_MANFAAT_KARYAWAN'];
		$pph_22 = $row['PPH_22'];
		$pph_23 = $row['PPH_23'];
		$pph_25 = $row['PPH_25'];

		$jml_akunt =  $hrg_peroleh_akunt + $ak_pnysutan_akunt;
		$jml_akunt_atb = $hrg_peroleh_atb_akunt + $ak_pnysutan_atb_akunt;
	  }

	  $query = $this->Kertas_kerja_mdl->getkktgghnfiskal($bulandari,$bulanke,($tahundari-2),$cabang);
	
	  foreach($query->result_array() as $row) {
		$hrg_peroleh_fiskal = $row1['HRG_PEROLEHAN_FISKAL'];
		$ak_nb = $row1['AK_NB'];
		$hrg_p_tdkberwujud = $row1['HRG_P_TDKBERWUJUD'];
		$ak_tdk_berwujud = $row1['AK_TDK_BERWUJUD'];

		$jml_akun_fiskal = $hrg_peroleh_fiskal + $ak_nb + 1;
		$jml_atb_akun_fiskal = $hrg_p_tdkberwujud + $ak_tdk_berwujud;
	  }

	  	$jml_aktiva_atn = (($jml_akun_fiskal - $jml_akunt) * $vrate) / 100;
		$jml_aktiva_atb = (($jml_atb_akun_fiskal - $jml_akunt_atb) * $vrate) / 100;
		$jml_aktiva_pymad = (($jml_pymad_fiskal - $ak_pnysutan_pymad_akunt) * $vrate) /100;
		$jml_k_manfaat_krywn = ($k_manfaat_karyawan * $vrate) / 100;

		$total2before = $jml_aktiva_atn + $jml_aktiva_atb + $jml_aktiva_pymad + $jml_k_manfaat_krywn;

		$vtotal2before = $total1before - $total2before;
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('K8',$vtotal2before)
		;
	  // End hitung 2 tahun sebelumnya
      */

	  //hitung Kompensasi kerugian Fiskal

			$vservcode ="";			
				
			$vscode701 ="'0111','0112','0113','0114','0115','0116','0117','0119','0122','0123','0124','0131','0132','0133','0134','0135','0139'";
			$vscode702 ="'0211','0212','0213','0219','0221','0222','0229'";
			$vscode703 ="'0311','0312','0319','0322','0327','0327','0331','0335','0338'";
			$vscode704 ="'0401','0402','0403','0404','0405','0406','0408','0411','0412','0413','0415','0416','0420','0423','0424','0433','0433','0499'";
			$vscode705 ="'0501','0502','0503','0510','0511','0512','0513','0516','0517','0531','0533','0534','0535','0537','0538','0539',
			'0562','0563','0566','0567','0568','0572','0573','0599'";
			$vscode706 ="'0601','0602','0603','0604','0605','0610','0623','0624','0625','0699'";
			$vscode707 ="'0701','0702','0706','0711','0712','0713','0719','0731','0732','0734','0742','0751','0754','0755','0763','0799'";
			$vscode708 ="'0811','0812','0751','0799','0812','0799'";
			$vscode721 ="'0111','0112','0113','0114','0115','0119'";
			$vscode722 ="'0211','0213'";
			$vscode725 ="'0401','0404'";
			$vscode725_2 ="'0501','0502'";
			$vscode726 = "'0701','0799'";
			

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70101101',$vscode701);
		$vjml701 = 0;
		foreach($query->result_array() as $row) {
			$vjml701 += abs($row['SPT']);
		}
		
		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70201101',$vscode702);
		$vjml702 = 0;
		foreach($query->result_array() as $row) {
				$vjml702 += ($row['SPT']*-1);
		}

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70301101',$vscode703);
		$vjml703 = 0;
		foreach($query->result_array() as $row) {
			$vjml703 += abs($row['SPT']);
		}
		
		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70401101',$vscode704);
		$vjml704 = 0;
		foreach($query->result_array() as $row) {
			$vjml704 += abs($row['SPT']);
		}

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70501101',$vscode705);
		$vjml705 = 0;
		foreach($query->result_array() as $row) {
			$vjml705 += abs($row['SPT']);
		}

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
		$vjml706 = 0;
		foreach($query->result_array() as $row) {
			$vamntneg = 0;
			if($row['KODE_AKUN'] === '70601101'){
				$vamntneg = abs($row['JML_URAIAN']);
			} else {
				$vamntneg = abs($row['AMOUNT_NEGATIF']);
			}
			
			$vjml706 += abs($row['SPT']);
			
		}

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70701101',$vscode707);
		$vjml707 = 0;
		foreach($query->result_array() as $row) {
			$vjml707 += abs($row['SPT']);
		}

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70801101',$vscode708);
		$vjml708 = 0;
		foreach($query->result_array() as $row) {
			$vjml708 += abs($row['SPT']);
		}

		$total701708 = 0;

		$total701708 = $vjml701 + $vjml702 + $vjml703 + $vjml704 + $vjml705 + $vjml706 +  $vjml707 + $vjml708;

		$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72101101',$vscode721);
		 $vjml721 = 0; 
		 foreach($query->result_array() as $row) {
			$vjml721 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72201101',$vscode722);
		 $vjml722 = 0; 
		 foreach($query->result_array() as $row) {
				$vjml722 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725);
		 $vjml725 = 0; 
		 foreach($query->result_array() as $row) {
				$vjml725 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725_2);
		 $vjml725_2 = 0; 
		 foreach($query->result_array() as $row) {
				$vjml725_2 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72601101',$vscode726);
		 $vjml726 = 0; 
		 foreach($query->result_array() as $row) {
				$vjml726 += abs($row['SPT']);
		 }
		 
		 $total72 = 0;

		 $total72 = $vjml721 + $vjml722 + $vjml725 + $vjml725_2 +  $vjml726;

		 $vcoa100 = "'80101011','80101012','80101021','80101031','80101032','80101033','80101034','80101035','80101036','80101037','80101038',
		 '80101039','80101041','80101042','80101043','80101044','80101045','80101046','80101051','80101061','80101063','80101064','80101071','80101081','80101091',
		 '80101901','80101999'";
		 $vcoa200 = "'80102101','80102102','80102103','80102104','80102105','80102106','80102107','80102108',
		 '80102109','80102110','80102111','80102113','80102191'";
		 $vcoa300 = "'80103105','80103106'";
		 $vcoa300_2 = "'80103013','80103211','80103221','80103231','80103241','80103251','80103261','80103271','80103272',
		 '80103281','80103291'";
		 $vcoa300_3 = "'80103303','80103399'";
		 $vcoa300_4 = "'80103471','80103472','80103481'";
		 $vcoa300_5 = "'80103511','80103571','80103581'";
		 $vcoa400 	= "'80104101','80104103','80104104','80104106','80104107','80104108'";
		 $vcoa400_2 = "'80104211','80104221','80104231','80104241','80104261','80104271','80104272',
		 '80104281','80104299'";
		 $vcoa400_3 = "'80104322'";
		 $vcoa400_4 = "'80104411','80104461'";
		 $vcoa400_5 = "'80104511','80104531','80104541','80104591'";
		 $vcoa400_6 = "'80104701','80104702'";
		 $vcoa400_7 = "'80104601','80104602','80104603','80104604','80104605','80104606','80104607','80104699'
		 ,'80104801','80104803','80104804','80104807','80104806','80104810'";
		 $vcoa500 = "'80105211','80105221','80105231','80105241','80105251','80105261','80105271','80105272',
		 '80105281','80105291'";
		 $vcoa500_2 = "'80105399'";
		 $vcoa500_3 = "'80105411','80105471'";
		 $vcoa500_4 = "'80105511','80105531','80105611','80105999'";
		 $vcoa600	= "'80106111','80106121','80106131','80106141','80106151','80106161','80106171','80106181',
		 '80106182','80106191','80106201','80106211','80106311','80106901','80106925','80106911',
		 '80106924','80106999'";
		 $vcoa700	= "'80107101','80107102','80107103','80107104','80107105','80107106','80107107',
		 '80107108','80107109','80107110','80107112','80107110','80107999'";
		 $vcoa800	= "'80108011','80108012','80108021','80108031','80108041','80108051','80108061','80108071',
		 '80108081','80108101','80108111','80108121','80108131','80108141','80108151','80108161','80108171',
		 '80108172','80108173','80108174','80108181','80108182','80108191','80108201','80108202','80108211',
		 '80108221','80108223','80108222','80108226','80108227','80108228','80108229','80108999'";		
		 
		 $vservcode="";
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa100,$vservcode);
		 $vjml8011 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml8011 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa200,$vservcode);
		 $vjml8012 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8012 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300,$vservcode);
		 $vjml8013 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8013 +=abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_2,$vservcode);
		 $vjml8013_2 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8013_2 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_3,$vservcode);
		 $vjml8013_3 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8013_3 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_4,$vservcode);
		 $vjml8013_4 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8013_4 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_5,$vservcode);
		 $vjml8013_5 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8013_5 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400,$vservcode);
		 $vjml8014 = 0;
		 $vuraian80141 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80141 += abs($row['JML_URAIAN']);
			$vjml8014 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_2,$vservcode);
		 $vjml8014_2 = 0;
		 $vuraian80142 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80142 += abs($row['JML_URAIAN']);
			$vjml8014_2 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_3,$vservcode);
		 $vjml8014_3 = 0;
		 $vuraian80143 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80143 += abs($row['JML_URAIAN']);
			$vjml8014_3 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_4,$vservcode);
		  $vjml8014_4 = 0;
		  $vuraian80144 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80144 += abs($row['JML_URAIAN']);
			$vjml8014_4 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_5,$vservcode);
		 $vjml8014_5 = 0;
		 $vuraian80145 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80145 += abs($row['JML_URAIAN']);
			$vjml8014_5 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_6,$vservcode);
		 $vjml8014_6 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8014_6 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_7,$vservcode);
		 $vuraian80147 = 0;
		 $vjml8014_7 = 0;
		 foreach($query->result_array() as $row) {
			$vuraian80147 += abs($row['JML_URAIAN']);
			$vjml8014_7 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500,$vservcode);
		 $vjml8015 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8015 += abs($row['SPT']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_2,$vservcode);
		 $vjml8015_2 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8015_2 += abs($row['SPT']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_3,$vservcode);
		 $vjml8015_3 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8015_3 += abs($row['SPT']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_4,$vservcode);
		 $vjml8015_4 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8015_4 += abs($row['SPT']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa600,$vservcode);
		 $vjml8016 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8016 += abs($row['SPT']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa700,$vservcode);
		 $vjml8017 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8017 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa800,$vservcode);
		 $vjml8018 = 0;
		 foreach($query->result_array() as $row) {
			$vjml8018 += abs($row['SPT']);
		 }
		 
		 $total801 = 0;
		 
		 $total801 = $vjml8011 + $vjml8012 + $vjml8013 + $vjml8013_2 + $vjml8013_3 + $vjml8013_4 + $vjml8013_5 + $vjml8014 + $vjml8014_2
		 + $vjml8014_3 + $vjml8014_4 + $vjml8014_5 + $vjml8014_6 + $vjml8014_7 + $vjml8015 + $vjml8015_2 + $vjml8015_3 + $vjml8015_4
		 + $vjml8016 + $vjml8017 + $vjml8018;

		 $vcoa791 = "'79103111','79103112','79103999','79101141','79101161','79101171','79101172','79104101',
		 '79104104','79104107','79199999','79101151','79101152','89101171','79101121','79101131','79101181',
		 '79101182','79101183','79101189','79102111','79102112','79102113','89101183','79101180'";

		 $vcoa891 = "'89101221','79101111','89101111','89101121','89101901','89101902','89101906','89101908','89101211','89101173',
		 '89101194','89101209','89101916','89101917','89101918','89101919','89101999','89199999','89101201','89101909',
		 '89101151','89101163','89101162','89101161','89101131','89101141','89101142'";


		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa791,$vservcode);
		 $vjml791 = 0;
		 foreach($query->result_array() as $row) {
			$vjml791 += abs($row['SPT']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa891,$vservcode);
		 $vjml891 = 0;
		 foreach($query->result_array() as $row) {
			$vjml891 += abs($row['SPT']);
		 }

		$vbbnfinalpositif = 0;
		$qcabang = $this->Kertas_kerja_mdl->get_kk_cabang();		
		foreach($qcabang->result_array() as $row) {
			$query	= $this->Kertas_kerja_mdl->get_kk_aset_beban_final($bulandari,$tahundari,$row['KODE_CABANG']);
			foreach($query->result_array() as $row1) {
				$vbbnfinalpositif += $row1['PEMBEBANAN'];
			}
		}

		$vtotalbedawaktu = 0;
		$vjmlbeban = 0;
		$vpenyusutankomersil = 0;
		$vjmlbeban = $vuraian80141 + $vuraian80142 + $vuraian80143 + $vuraian80144 + $vuraian80145;
		$vpenyusutankomersil = $vuraian80147;

		$vtotalbedawaktu = $vjmlbeban + $vpenyusutankomersil;

		$grandtotal = ($total701708 - $total72); 
		$grandtotal = $grandtotal - $total801;
		$grandtotal =  $grandtotal + ($vjml791 - $vjml891);

		$objPHPExcel->setActiveSheetIndex(0)
	 			 ->setCellValue('H83',"=ROUNDDOWN(".abs($grandtotal + $vbbnfinalpositif + $vtotalbedawaktu)."/1000,0)*1000");
	  //end hitung Kompensasi kerugian Fiskal

	  //pph
		$vcoa ="'10901201'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
	 			 ->setCellValue('K48',$row['JML_URAIAN']);
		 }
		 $vcoa ="'10901301'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('K49',$row['JML_URAIAN']);
		 }
		 $vcoa ="'10901401'";
		$query	= $this->Kertas_kerja_mdl->get_kk_pph_by_akun($bulandari,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('K50',$row['JML_URAIAN']);
		 }

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_mapping_gl_to_sptpph_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {	
    $fileName = 'KertasKerjaMappingGLtoSPTPPhBadan.xlsx';	
	$objPHPExcel = $this->getHeaderXLS($fileName);	

	$objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('A1',"PENJELASAN KOREKSI TAHUN " .$tahundari);

	
	if ($cabang && $cabang != "all") 
	{
		$wcbg = "and branch_code = '".$cabang."'";
		$wcbgz = "and kode_cabang = '".$cabang."'";
	} else {
		$wcbg = "";
		$wcbgz = "";
	}

	$vcoa100 = "'80101011','80101012','80101021','80101031','80101032','80101033','80101034','80101035','80101036','80101037','80101038',
		 '80101039','80101041','80101042','80101043','80101044','80101045','80101046','80101051','80101061','80101063','80101064','80101071','80101081','80101091',
		 '80101901','80101999'";
		 $vcoa200 = "'80102101','80102102','80102103','80102104','80102105','80102106','80102107','80102108',
		 '80102109','80102110','80102111','80102113','80102191'";
		 $vcoa300 = "'80103105','80103106'";
		 $vcoa300_2 = "'80103013','80103211','80103221','80103231','80103241','80103251','80103261','80103271','80103272',
		 '80103281','80103291'";
		 $vcoa300_3 = "'80103303','80103399'";
		 $vcoa300_4 = "'80103471','80103472','80103481'";
		 $vcoa300_5 = "'80103511','80103571','80103581'";
		 $vcoa400 	= "'80104101','80104103','80104104','80104106','80104107','80104108'";
		 $vcoa400_2 = "'80104211','80104221','80104231','80104241','80104261','80104271','80104272',
		 '80104281','80104299'";
		 $vcoa400_3 = "'80104322'";
		 $vcoa400_4 = "'80104411','80104461'";
		 $vcoa400_5 = "'80104511','80104531','80104541','80104591'";
		 $vcoa400_6 = "'80104701','80104702'";
		 $vcoa400_7 = "'80104601','80104602','80104603','80104604','80104605','80104606','80104607','80104699'
		 ,'80104801','80104803','80104804','80104807','80104806','80104810'";
		 $vcoa500 = "'80105211','80105221','80105231','80105241','80105251','80105261','80105271','80105272',
		 '80105281','80105291'";
		 $vcoa500_2 = "'80105399'";
		 $vcoa500_3 = "'80105411','80105471'";
		 $vcoa500_4 = "'80105511','80105531','80105611','80105999'";
		 $vcoa600	= "'80106111','80106121','80106131','80106141','80106151','80106161','80106171','80106181',
		 '80106182','80106191','80106201','80106211','80106311','80106901','80106925','80106911',
		 '80106924','80106999'";
		 $vcoa700	= "'80107101','80107102','80107103','80107104','80107105','80107106','80107107',
		 '80107108','80107109','80107110','80107112','80107110','80107999'";
		 $vcoa800	= "'80108011','80108012','80108021','80108031','80108041','80108051','80108061','80108071',
		 '80108081','80108101','80108111','80108121','80108131','80108141','80108151','80108161','80108171',
		 '80108172','80108173','80108174','80108181','80108182','80108191','80108201','80108202','80108211',
		 '80108221','80108223','80108222','80108226','80108227','80108228','80108229','80108999'";

		 $vscode706 ="'0601','0602','0603','0604','0605','0610','0623','0624','0625','0699'";

		 $total8010_1 = 0;$total8010_2 = 0;$total8010_3 = 0;$total8010_4 = 0;$total8010_5 = 0;$total8010_6 = 0;
		 $total8010_7 = 0;$total8010_8 = 0;$total8010_9 = 0;$total8010_10 = 0;$total8010_11 = 0;$total8010_12 = 0;
		 $total8010_13 = 0;$total8010_14 = 0;$total8010_15 = 0;$total8010_16 = 0;$total8010_17 = 0;$total8010_18 = 0;
		 $total8010_19 = 0;$total8010_20 = 0;$total8010_21 = 0;

		 $vservcode="";
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa100,$vservcode);
		 foreach($query->result_array() as $row) {
			$total8010_1 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa200,$vservcode);
		 foreach($query->result_array() as $row) {
			$total8010_2 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_3 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_2,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_4 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_3,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_5 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_4,$vservcode);
		 foreach($query->result_array() as $row) {
			$total8010_6 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa300_5,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_7 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_8 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_2,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_9 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_3,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_10 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_4,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_11 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_5,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_12 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_6,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_13 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa400_7,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_14 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_15 += abs($row['JML_URAIAN']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_2,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_16 += abs($row['JML_URAIAN']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_3,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_17 += abs($row['JML_URAIAN']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa500_4,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_18 += abs($row['JML_URAIAN']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa600,$vservcode);
		 foreach($query->result_array() as $row) {
				$total8010_19 += abs($row['JML_URAIAN']);
		 }
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa700,$vservcode);
		 foreach($query->result_array() as $row) {
			$total8010_20 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa800,$vservcode);
		 foreach($query->result_array() as $row) {
			$total8010_21 += abs($row['JML_URAIAN']);
		 }
	$grantotal8010 = ($total8010_1 + $total8010_2 + $total8010_3 + $total8010_4 + $total8010_5 + $total8010_6 + $total8010_7 + $total8010_8 + $total8010_9 + $total8010_10
	 + $total8010_11 + $total8010_12 + $total8010_13 + $total8010_14 + $total8010_15 +$total8010_16 + $total8010_17 + $total8010_18 + $total8010_19 + $total8010_20 + $total8010_21);
	
	 $vcoa791 = "'79103111','79103112','79103999','79101141','79101161','79101171','79101172','79104101',
		 '79104104','79104107','79199999','79101151','79101152','89101171','79101121','79101131','79101181',
		 '79101182','79101183','79101189','79102111','79102112','79102113','89101183','79101180'";

		 $vcoa891 = "'89101221','79101111','89101111','89101121','89101901','89101902','89101906','89101908','89101211','89101173',
		 '89101194','89101209','89101916','89101917','89101918','89101919','89101999','89199999','89101201','89101909',
		 '89101151','89101163','89101162','89101161','89101131','89101141','89101142'";

		 $vtotal791 = 0;
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa791,$vservcode);
		 foreach($query->result_array() as $row) {
			if($row['KODE_AKUN'] === '79101121') { 
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C37',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F37',abs($row['JML_URAIAN']))
				;
			}	 
			if($row['KODE_AKUN'] === '79101131') { 
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C38',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F38',abs($row['JML_URAIAN']))
				;
			}
			if($row['KODE_AKUN'] === '79101180') { 
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C39',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F39',abs($row['JML_URAIAN']))
				;
			}
			$vtotal791 += abs($row['JML_URAIAN']);
		 }
		 
		 $vtotal891 = 0;
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa891,$vservcode);
		 foreach($query->result_array() as $row) {
			$vtotal891 += abs($row['JML_URAIAN']);
		 }

		 $vscode701 ="'0111','0112','0113','0114','0115','0116','0117','0119','0122','0123','0124','0131','0132','0133','0134','0135','0139'";
		 $vscode702 ="'0211','0212','0213','0219','0221','0222','0229'";
		 $vscode703 ="'0311','0312','0319','0322','0327','0327','0331','0335','0338'";
		 $vscode704 ="'0401','0402','0403','0404','0405','0406','0408','0411','0412','0413','0415','0416','0420','0423','0424','0433','0433','0499'";
		 $vscode705 ="'0501','0502','0503','0510','0511','0512','0513','0516','0517','0531','0533','0534','0535','0537','0538','0539',
		 '0562','0563','0566','0567','0568','0572','0573','0599'";
		 $vscode706 ="'0601','0602','0603','0604','0605','0610','0623','0624','0625','0699'";
		 $vscode707 ="'0701','0702','0706','0711','0712','0713','0719','0731','0732','0734','0742','0751','0754','0755','0763','0799'";
		 $vscode708 ="'0811','0812','0751','0799','0812','0799'";
		 $vscode721 ="'0111','0112','0113','0114','0115','0119'";
		 $vscode722 ="'0211','0213'";
		 $vscode725 ="'0401','0404'";
		 $vscode725_2 ="'0501','0502'";
		 $vscode726 = "'0701','0799'";
		 $vautoservcode706 = array("0601","0602","0623","0624","0625","0699");	 
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70101101',$vscode701);
		 $vjml701 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml701 += abs($row['JML_URAIAN']);
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70201101',$vscode702);
		 $vjml702 = 0;
		 foreach($query->result_array() as $row) {
				 $vjml702 += ($row['JML_URAIAN']*-1);
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70301101',$vscode703);
		 $vjml703 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml703 += abs($row['JML_URAIAN']);
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70401101',$vscode704);
		 $vjml704 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml704 += abs($row['JML_URAIAN']);
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70501101',$vscode705);
		 $vjml705 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml705 += $row['JML_URAIAN'];
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
		 $vjml706 = 0;
		 foreach($query->result_array() as $row) {
			 $vamntneg = 0;
			 if(in_array($row['KODE_JASA'], $vautoservcode706)){
				$vamntneg = abs($row['JML_URAIAN']);
			 } else {
				$vamntneg = abs($row['AMOUNT_NEGATIF']);
			 }
			 
			 $vjml706 += abs($row['JML_URAIAN']);
			 
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70701101',$vscode707);
		 $vjml707 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml707 += abs($row['JML_URAIAN']);
		 }
		 
		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70801101',$vscode708);
		 $vjml708 = 0;
		 foreach($query->result_array() as $row) {
			 $vjml708 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72101101',$vscode721);
		 $vjml721=0;
		 foreach($query->result_array() as $row) {
			$vjml721 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72201101',$vscode722);
		 $vjml722=0;
		 foreach($query->result_array() as $row) {
			$vjml722 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725);
		 $vjml725=0;
		 foreach($query->result_array() as $row) {
			$vjml725 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72501101',$vscode725_2);
		  $vjml725_2=0;
		 foreach($query->result_array() as $row) {
			$vjml725_2 += abs($row['JML_URAIAN']);
		 }

		 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'72601101',$vscode726);
		 $vjml726=0;
		 foreach($query->result_array() as $row) {
			$vjml726 += abs($row['JML_URAIAN']);
		 }
		 
		 $total701708 = 0;
		 $vtotal72 = 0;

		 $total701708 = $vjml701 + $vjml702 + $vjml703 + $vjml704 + abs($vjml705) + $vjml706 +  $vjml707 + $vjml708;	 
		 $vtotal72 = $vjml721 + $vjml722 + $vjml725 + $vjml725_2 + $vjml726;
		 $grandtotal7270 = $total701708 - $vtotal72;
	
	 $i = 4; 
	$sql = "select 
	(
		SELECT sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)) 
		FROM simtax_tb_v
		where coa in  
		('70101101',                                                       
		'70201101',                                                     
		'70301101',                                          
		'70401101',                                                                                           
		'70501101',                                              
		'70601101',                                
		'70701101',                                                                 
		'70801101',                                
		'72101101',                                              
		'72201101',                                                
		'72501101')
	and period_num between ".$bulandari." and ".$bulanke." 
	and period_year = ".$tahundari." 
	".$wcbg."
	) as jml_peredaran_usaha,
	(
		SELECT sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)) 
		FROM simtax_tb_v
		where coa like '8010%'
	and period_num between ".$bulandari." and ".$bulanke." 
	and period_year = ".$tahundari." 
	".$wcbg."
	) as jml_hrg_pokok_penjualan,
	(
		SELECT sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)) 
		FROM simtax_tb_v
		where coa in
		(
			'79103111','79103112','79103999','79101141','79101161','79101171','79101172','79104101',
		 '79104104','79104107','79199999','79101151','79101152','89101171','79101121','79101131','79101181',
		 '79101182','79101183','79101189','79102111','79102112','79102113','89101183','79101180'
		)
	and period_num between ".$bulandari." and ".$bulanke." 
	and period_year = ".$tahundari." 
	".$wcbg."
	) as jml_penghasilan_dari_usaha,
	(
		SELECT sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)) 
		FROM simtax_tb_v
		where coa like '891%'
	and period_num between ".$bulandari." and ".$bulanke." 
	and period_year = ".$tahundari." 
	".$wcbg."
	) as jml_biaya_dari_luar_usaha
	from dual";
	$result = $this->db->query($sql);
    foreach($result->result_array() as $row) {
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G9',$grandtotal7270)
		->setCellValue('G11',$grantotal8010) 
        ->setCellValue('G17',abs($vtotal791))
        ->setCellValue('G19',abs($vtotal891))
	    ;
	}

	$numrow = 32;
	/*
	$query		= $this->Kertas_kerja_mdl->get_kk_t_rek_706($bulandari,$bulanke,$tahundari,$cabang);
	foreach($query->result_array() as $row)	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('C'.$numrow, $row['KODE_JASA_DESCRIPTION'])
		->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		$numrow++;
	}
	*/
	
	$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
	foreach($query->result_array() as $row) {
		$vamntneg = 0;
		if($row['KODE_JASA'] === '0601') {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C32',$row['KODE_AKUN']." - ".$row['JASA_DESCRIPTION'])
			->setCellValue('F32',abs($row['JML_URAIAN']))
			;
		}

		if($row['KODE_JASA'] === '0602') {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C33',$row['KODE_AKUN']." - ".$row['JASA_DESCRIPTION'])
			->setCellValue('F33',abs($row['JML_URAIAN']))
			;
		}

		if($row['KODE_JASA'] === '0624') {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C34',$row['KODE_AKUN']." - ".$row['JASA_DESCRIPTION'])
			->setCellValue('F34',abs($row['JML_URAIAN']))
			;
		}
	}

   /*
	$query		= $this->Kertas_kerja_mdl->get_kk_t_rek_791($bulandari,$bulanke,$tahundari,$cabang);
	foreach($query->result_array() as $row)	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('C'.$numrow, $row['KODE_JASA_DESCRIPTION'])
		->setCellValue('F'.$numrow, $row['AMOUNT_POSITIF'] + $row['AMOUNT_NEGATIF']);
		$numrow++;
	}
	*/

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C113',"15")
				->setCellValue('C114',"16")
				;

	$vcoakoreksi = "'89101131','89101141','89101142','89101151'";
	 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoakoreksi,$vservcode);
		 foreach($query->result_array() as $row) {
			if($row['KODE_AKUN'] === '89101131') {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C115',"17")
				->setCellValue('D115',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F115',abs($row['JML_URAIAN']))
				;
			}	 
			if($row['KODE_AKUN'] === '89101141') {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C116',"18")
				->setCellValue('D116',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F116',abs($row['JML_URAIAN']));
			}
			if($row['KODE_AKUN'] === '89101151') {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C117',"19")
				->setCellValue('D117',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F117',abs($row['JML_URAIAN']));
			}
			if($row['KODE_AKUN'] === '89101142') {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C118',"20")
				->setCellValue('D118',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
				->setCellValue('F118',abs($row['JML_URAIAN']));
			}
			
		 }

	$vservcode = "";
	$vcoa = "'80102107'"; //obat obatan
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C52',"1")
				->setCellValue('D52',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
	  			->setCellValue('F52',$row['JML_URAIAN']);
				$i++;
		 }

	$vcoa = "'80108131'";// pakaian dinas	 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C53',"2")
				->setCellValue('D53',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
	  			->setCellValue('F53',$row['JML_URAIAN']);
				$i++;
		 }
	$vcoa = "'80108173'"; //Imbalan Kerja Perawatan Kesehatan Pekerja
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
		 foreach($query->result_array() as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C54',"3")
				->setCellValue('D54',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
	  			->setCellValue('F54',$row['JML_URAIAN']);
				$i++;
		 }

	$vcoa = "'80108161'"; //beban sosial	
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C57',"1")
		   	 ->setCellValue('D57',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F57',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$vcoa = "'80108226'"; //Denda dan Kekurangan Pajak
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		   	 ->setCellValue('C60',"1")
		     ->setCellValue('D60',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F60',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		   	 ->setCellValue('C64',"1")
			 ->setCellValue('C65',"2")
			 ;

	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C73',"1")
			 ;			

	// start otomatis koreksi positif

	$vcoa = "'80101012'"; //PPh Pasal 21 Ditanggung Pemberi Kerja
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C76',"2")
		     ->setCellValue('D76',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F76',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$vcoa = "'80102191'";//Beban Bahan Lain-Lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		   	 ->setCellValue('C77',"3")
		     ->setCellValue('D77',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F77',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$vcoa = "'80105999'";//Beban Asuransi lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C78',"4")
		     ->setCellValue('D78',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F78',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$vcoa = "'80106999'";//Sewa Lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C79',"5")
		     ->setCellValue('D79',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F79',$row['JML_URAIAN'])
			 ;
		   $i++;
	}

	$vcoa = "'80107104'";//Surat Kabar, Majalah & Buletin 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C80',"6")
		     ->setCellValue('D80',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F80',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80107105'";//Ruangan dan Peralatan rapat   
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C81',"7")
		     ->setCellValue('D81',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F81',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80107106'";//Rumah Tangga 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C82',"8")
		     ->setCellValue('D82',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F82',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80107107'";//Jamuan Rapat
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C83',"9")
		     ->setCellValue('D83',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F83',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80107999'";//Administrasi Kantor Lainnya 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C84',"10")
		     ->setCellValue('D84',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F84',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108011'";//Perjalanan Dinas
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C85',"11")
		     ->setCellValue('D85',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F85',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108041'";//Keamanan Pelabuhan 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C86',"12")
		     ->setCellValue('D86',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F86',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108061'";//Promosi / Pemasaran 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C87',"13")
		     ->setCellValue('D87',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F87',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108121'";//Olah Raga & Kesenian 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C88',"14")
		     ->setCellValue('D88',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F88',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108191'";//Iklan 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C89',"15")
		     ->setCellValue('D89',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F89',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108999'";//Umum Lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C90',"16")
		     ->setCellValue('D90',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F90',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C91',"17");
	$vcoa = "'89101221'";//Imbalan Pasca Kerja Pensiunan
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C91',"17")
		     ->setCellValue('D91',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F91',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C92',"18");
	$vcoa = "'89101162'";//Bunga Obligasi
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C92',"18")
		     ->setCellValue('D92',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F92',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C93',"19");
	$vcoa = "'89101194'";//Pengobatan  Pensiunan
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C93',"19")
		     ->setCellValue('D93',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F93',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C94',"20");
	$vcoa = "'89101916'";//Rounding   
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C94',"20")
		     ->setCellValue('D94',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F94',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C95',"21");
	$vcoa = "'89101201'";//Pengerukan Alur
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C95',"21")
		     ->setCellValue('D95',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F95',$row['JML_URAIAN']);
		   $i++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
		   ->setCellValue('C96',"22");
	$vcoa = "'89199999'";//Beban Diluar Usaha Lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		   ->setCellValue('C96',"22")
		   ->setCellValue('D96',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F96',$row['JML_URAIAN']);
		   $i++;
	}

	$vcoa = "'80108227'";//Imbalan Pasca Kerja Pensiunan 
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C97',"23")
		     ->setCellValue('D97',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F97',$row['JML_URAIAN']);
		   $i++;
	}

	//End otomatis koreksi positif

	$vcoa = "'80106925'";//Beban Kompensasi Tanah dan Bangunan
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_final($bulandari,$bulanke,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
		     ->setCellValue('C99',"1")
		     ->setCellValue('D99',$row['KODE_AKUN']." - ".$row['AKUN_DESCRIPTION'])
			 ->setCellValue('F99',$row['AMOUNT_POSITIF']);
		   $i++;
	}

	/*
	$vcoa = "'89101131'";//Pajak Final Giro dan Deposito
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_without891($bulandari,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
			 ->setCellValue('F115',$row['AMOUNT_POSITIF']);
		   $i++;
	}

	$vcoa = "'89101141'";//Pajak Final Sewa Tanah dan  Bangunan
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_without891($bulandari,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
			 ->setCellValue('F116',$row['AMOUNT_POSITIF']);
		   $i++;
	}

	$vcoa = "'89101151'";//Jasa/Administrasi Bank
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_without891($bulandari,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
			 ->setCellValue('F117',$row['AMOUNT_POSITIF']);
		   $i++;
	}

	$vcoa = "'89101142'";//Pajak Final Lainnya
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_without891($bulandari,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		   $objPHPExcel->setActiveSheetIndex(0)
			 ->setCellValue('F118',$row['AMOUNT_POSITIF']);
		   $i++;
	}
     */

	//beban final all cabang
	$i = 100;
	$no=2;
	$qcabang = $this->Kertas_kerja_mdl->get_kk_cabang();		
	foreach($qcabang->result_array() as $row) {
			$query	= $this->Kertas_kerja_mdl->get_kk_aset_beban_final($bulandari,$tahundari,$row['KODE_CABANG']);
			foreach($query->result_array() as $row1) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(2,$i,$no)
				->setCellValueByColumnAndRow(3,$i,$row['NAMA_CABANG'])
				->setCellValueByColumnAndRow(5,$i,$row1['PEMBEBANAN']);
			}
		$no++;
		$i++;	
	}

	$objPHPExcel->setActiveSheetIndex(0)
			 ->setCellValue('C120',"21");

	//Penyusutan komersil
	$vcoa 	= "'80104101','80104103','80104104','80104106','80104107','80104108',
	'80104211','80104221','80104231','80104241','80104261','80104271','80104272',
	'80104281','80104299','80104322','80104411','80104461','80104511','80104531',
	'80104541','80104591'";
	$vamntneg = 0;
	$query	= $this->Kertas_kerja_mdl->get_kk_rek8_without891($bulandari,$tahundari,$vcoa,$vservcode);
	foreach($query->result_array() as $row) {
		$vamntneg += $row['AMOUNT_NEGATIF'];
	}
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('F132',$vamntneg);

	//Penyusutan Fiskal
	$vpnyusutanfiskal = 0;
	$query	= $this->Kertas_kerja_mdl->getkktgghnfiskal($bulandari,$bulanke,$tahundari,$cabang);
	foreach($query->result_array() as $row) {
		$vpnyusutanfiskal += $row['AK_NB'];
	}
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('F133',$vpnyusutanfiskal);

	$vcoaakpamor = "'21800000','21801101','21802101','21803101','21804100','21804101','21804102','21804103','21804104','21804105','21804106','21804107','21804108','21804109',
	'21804110','21804111','21804220','21804221','21804222','21804223','21804224','21804225','21804300','21804301','21804302','21804303','21804304','21804305',
	'21804306','21804307','21804308','21804309','21804310','21804311','21804312','21804313','21804314','21804315','21804316','21804317','21804318','21804319',
	'21804320','21804400','21804401','21804402','21804403','21804404','21804405','21804406','21804407','21804408','21804500','21804501','21804600','21804601',
	'21804602','21804603','21804604','21804605','21804606','21804607','21804608','21804609','21804610','21804611','21804612','21804613','21804700','21804701',
	'21804702','21804703','21804704','21804705','21804706','21804707','21804708','21804709','21804710','21804800','21804801','21804802','21804900','21804901',
	'21804902','21804903','21804904','21809999','21900000','21901101','21804102','21901103','21901104','21901105','21901106','21999999','21320000','21321101','21321201',
	'21321301','21321401','21329999'";
	$query = $this->Kertas_kerja_mdl->getDataByAkunByCabang($bulandari,$bulanke,$tahundari,$vcoaakpamor,$cabang);
	$amor_fiskal = 0;
	foreach($query->result_array() as $row) 
	{
	   $amor_fiskal = $row['JUMLAH'];
	}

	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('F137',$amor_fiskal);

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_pajak_kini_tangguhan_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {		
    $fileName = 'RekapitulasiPajakKinidanTangguhan.xlsx';	
	$objPHPExcel = $this->getHeaderXLS($fileName);
	
	$objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('B2',date("t-M-Y", strtotime($tahundari.'-'.$bulanke.'-01')))
	 //->setCellValue('D2',date("t-M-Y", strtotime(($tahundari+1).'-'.$bulanke.'-01')));
	 ->setCellValue('B2','31-'.$this->getMonthString($bulanke).'-'.$tahundari)
	 ->setCellValue('D2','31-'.$this->getMonthString($bulanke).'-'.($tahundari+1));
	 
	 $hrg_peroleh_akunt = 0;
	 $ak_pnysutan_akunt = 0;
	 $hrg_peroleh_atb_akunt = 0;
	 $ak_pnysutan_atb_akunt = 0;
	 $ak_pnysutan_pymad_akunt = 0;
	 $k_manfaat_karyawan = 0;
	 $pph_22 = 0;
	 $pph_23 = 0;
	 $pph_25 = 0;
	 $jml_akunt = 0;
	 $jml_akunt_atb = 0;
	 $vfajmlbangunan =0;
	$vfajmlnonbangunan =0;
	$vfatotalperolehan = 0;
	$vfajmlbangunan2 =0;
	$vfajmlnonbangunan2 =0;
	$vfatotalperolehan2 = 0;
	$vfahrgtdkberwujud = 0;
	$vfabebantangguhkan = 0;
	$vfatotaltdkberwujud = 0;
	$vakpenyfiskal = 0;

	$query = $this->Kertas_kerja_mdl->akumulasipenyasset($bulandari, $bulanke, $tahundari);
	$vakpakun = 0;
	foreach($query->result_array() as $row) 
	{
		$vakpakun = $row['VJMLPENYASSET'];
	}

	$query = $this->Kertas_kerja_mdl->akumulasipenyamor($bulandari, $bulanke, $tahundari);
	$vakpakunamor = 0;
	foreach($query->result_array() as $row) 
	{
		$vakpakunamor = $row['VJMLPENYAMOR'];
	}

	 $query = $this->Kertas_kerja_mdl->getkkkinitangguhan($bulandari,$bulanke,($tahundari),$cabang);
	 foreach($query->result_array() as $row) {
		$vfajmlbangunan = $row['NILAIBANGUNAN'];
		$vfajmlnonbangunan = $row['NILAINONBANGUNAN'];
		$vfajmlbangunan2 = $row['NILAIBANGUNAN2'];
		$vfajmlnonbangunan2 = $row['NILAINONBANGUNAN2'];
		$vfahrgtdkberwujud = $row['NILAITIDAKBERWUJUD'];
		$vfabebantangguhkan = $row['BEBANDITANGGUHKAN'];
		$vfatotalperolehan += $vfajmlbangunan + $vfajmlnonbangunan;
		$vfatotalperolehan2 += $vfajmlbangunan2 + $vfajmlnonbangunan2;
		$vfatotaltdkberwujud += $vfahrgtdkberwujud + $vfabebantangguhkan;
		$vakpenyfiskal = $row['AKPENYBERWUJUD']*-1;
		$jml_akunt = $vfatotalperolehan + $vakpakun;
		$jml_akunt_atb = $vfatotaltdkberwujud + $vakpakunamor;
	 }

	 $hrg_peroleh_fiskal = 0;
	 $ak_nb = 0;
	 $hrg_p_tdkberwujud = 0;
	 $ak_tdk_berwujud = 0;
	 $jml_akun_fiskal = 0;
	 $jml_atb_akun_fiskal = 0;
	 $ak_pymad_fiskal = 0;
	 $jml_pymad_fiskal = 0;
	 $query = $this->Kertas_kerja_mdl->getkktgghnfiskal($bulandari,$bulanke,($tahundari), $cabang);
	 foreach($query->result_array() as $row1) {
	   $ak_tdk_berwujud = $row1['AK_TDK_BERWUJUD'];
	   $jml_akun_fiskal = $vfatotalperolehan + $vakpenyfiskal;
	   $jml_atb_akun_fiskal = $vfatotaltdkberwujud + $ak_tdk_berwujud;
	   
	 }

	 $resultpymad = $this->Kertas_kerja_mdl->pymadtangguhan($bulandari, $bulanke, $tahundari);
	 foreach($resultpymad->result_array() as $rowpymad) {
		$ak_pnysutan_pymad_akunt = $rowpymad['DESLAST'];
	 }

	 $result = $this->Kertas_kerja_mdl->getkktgghnakunt2($bulandari, $bulanke, $tahundari, $cabang);	
	 foreach($result->result_array() as $row) {
		$k_manfaat_karyawan = $row['K_MANFAAT_KARYAWAN'];
	 }

	 $sqlrate = "select rate from simtax_master_rpt where aktif ='1' and tahun = ".$tahundari;
	 $resultrate = $this->db->query($sqlrate);
	 $vrate = 0;
	 foreach($resultrate->result_array() as $rowrate) {
		$vrate =  $rowrate['RATE'];
	 }

	 $jml_aktiva_atn = (($jml_akun_fiskal - $jml_akunt) * $vrate) / 100;
	 $jml_aktiva_atb = (($jml_atb_akun_fiskal - $jml_akunt_atb) * $vrate) / 100;
	 $jml_aktiva_pymad = (($jml_pymad_fiskal - $ak_pnysutan_pymad_akunt) * $vrate) /100;
	 $jml_k_manfaat_krywn = ($k_manfaat_karyawan * $vrate) / 100;
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('C4',($tahundari))
	 ->setCellValue('B7',$jml_aktiva_atn)
	 ->setCellValue('B8',$jml_aktiva_atb)
	 ->setCellValue('B9',$jml_aktiva_pymad)
	 ->setCellValue('B10',$jml_k_manfaat_krywn)
	 ;
	 $total1before = $jml_aktiva_atn + $jml_aktiva_atb + $jml_aktiva_pymad + $jml_k_manfaat_krywn;


	 // Hitung 1 tahun berikut nya
	 
	 $sqlrate = "select rate from simtax_master_rpt where aktif ='1' and tahun = ".($tahundari+1);
	 $resultrate = $this->db->query($sqlrate);
	 $vrate = 0;
	 foreach($resultrate->result_array() as $rowrate) {
		$vrate =  $rowrate['RATE'];
	 }

	 $hrg_peroleh_akunt = 0;
	 $ak_pnysutan_akunt = 0;
	 $hrg_peroleh_atb_akunt = 0;
	 $ak_pnysutan_atb_akunt = 0;
	 $ak_pnysutan_pymad_akunt = 0;
	 $k_manfaat_karyawan = 0;
	 $pph_22 = 0;
	 $pph_23 = 0;
	 $pph_25 = 0;
	 $jml_akunt = 0;
	 $jml_akunt_atb = 0;
	 $vfajmlbangunan =0;
	$vfajmlnonbangunan =0;
	$vfatotalperolehan = 0;
	$vfajmlbangunan2 =0;
	$vfajmlnonbangunan2 =0;
	$vfatotalperolehan2 = 0;
	$vfahrgtdkberwujud = 0;
	$vfabebantangguhkan = 0;
	$vfatotaltdkberwujud = 0;
	$vakpenyfiskal = 0;

	$query = $this->Kertas_kerja_mdl->akumulasipenyasset($bulandari, $bulanke, ($tahundari+1));
	$vakpakun = 0;
	foreach($query->result_array() as $row) 
	{
		$vakpakun = $row['VJMLPENYASSET'];
	}

	$query = $this->Kertas_kerja_mdl->akumulasipenyamor($bulandari, $bulanke, ($tahundari+1));
	$vakpakunamor = 0;
	foreach($query->result_array() as $row) 
	{
		$vakpakunamor = $row['VJMLPENYAMOR'];
	}

	 $query = $this->Kertas_kerja_mdl->getkkkinitangguhan($bulandari,$bulanke,($tahundari+1),$cabang);
	 foreach($query->result_array() as $row) {
	  	$vfajmlbangunan = $row['NILAIBANGUNAN'];
		$vfajmlnonbangunan = $row['NILAINONBANGUNAN'];
		$vfajmlbangunan2 = $row['NILAIBANGUNAN2'];
		$vfajmlnonbangunan2 = $row['NILAINONBANGUNAN2'];
		$vfahrgtdkberwujud = $row['NILAITIDAKBERWUJUD'];
		$vfabebantangguhkan = $row['BEBANDITANGGUHKAN'];
		$vfatotalperolehan += $vfajmlbangunan + $vfajmlnonbangunan;
		$vfatotalperolehan2 += $vfajmlbangunan2 + $vfajmlnonbangunan2;
		$vfatotaltdkberwujud += $vfahrgtdkberwujud + $vfabebantangguhkan;
		$vakpenyfiskal = $row['AKPENYBERWUJUD']*-1;
		$jml_akunt = $vfatotalperolehan + $vakpakun;
		$jml_akunt_atb = $vfatotaltdkberwujud + $vakpakunamor;
	 }

	 $resultpymad = $this->Kertas_kerja_mdl->pymadtangguhan($bulandari, $bulanke, ($tahundari+1));
	 foreach($resultpymad->result_array() as $rowpymad) {
		$ak_pnysutan_pymad_akunt = $rowpymad['DESLAST'];
	 }

	 $result = $this->Kertas_kerja_mdl->getkktgghnakunt2($bulandari, $bulanke, ($tahundari+1), $cabang);	
	 foreach($result->result_array() as $row) {
		$k_manfaat_karyawan = $row['K_MANFAAT_KARYAWAN'];
	 }

	 $hrg_peroleh_fiskal = 0;
	 $ak_nb = 0;
	 $hrg_p_tdkberwujud = 0;
	 $ak_tdk_berwujud = 0;
	 $jml_akun_fiskal = 0;
	 $jml_atb_akun_fiskal = 0;
	 $ak_pymad_fiskal = 0;
	 $jml_pymad_fiskal = 0;
	 $query = $this->Kertas_kerja_mdl->getkktgghnfiskal($bulandari,$bulanke,($tahundari+1),$cabang);
	 foreach($query->result_array() as $row1) {
	   $ak_tdk_berwujud = $row1['AK_TDK_BERWUJUD'];
	   $jml_akun_fiskal = $vfatotalperolehan + $vakpenyfiskal;
	   $jml_atb_akun_fiskal = $vfatotaltdkberwujud + $ak_tdk_berwujud;
	 }

	 $jml_aktiva_atn = (($jml_akun_fiskal - $jml_akunt) * $vrate) / 100;
	 $jml_aktiva_atb = (($jml_atb_akun_fiskal - $jml_akunt_atb) * $vrate) / 100;
	 $jml_aktiva_pymad = (($jml_pymad_fiskal - $ak_pnysutan_pymad_akunt) * $vrate) /100;
	 $jml_k_manfaat_krywn = ($k_manfaat_karyawan * $vrate) / 100;
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('E4',($tahundari+1))
	 ->setCellValue('D7',$jml_aktiva_atn)
	 ->setCellValue('D8',$jml_aktiva_atb)
	 ->setCellValue('D9',$jml_aktiva_pymad)
	 ->setCellValue('D10',$jml_k_manfaat_krywn)
	 ;
	 $total1before = $jml_aktiva_atn + $jml_aktiva_atb + $jml_aktiva_pymad + $jml_k_manfaat_krywn;

	 // End hitung 1 tahun berikut nya

	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('B19','31-'.$this->getMonthString($bulanke).'-'.$tahundari)
	 ->setCellValue('D19','31-'.$this->getMonthString($bulanke).'-'.($tahundari+1))
	 ->setCellValue('C21',($tahundari))
	 ->setCellValue('E21',($tahundari+1));

	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('B34','31-'.$this->getMonthString($bulanke).'-'.$tahundari)
	 ->setCellValue('D34','31-'.$this->getMonthString($bulanke).'-'.($tahundari+1))
	 ->setCellValue('C36',($tahundari))
	 ->setCellValue('E36',($tahundari+1));

	 $query = $this->Kertas_kerja_mdl->getNewDataByAkun($bulandari,$bulanke,($tahundari),'41099999',$cabang);
	 $jml_lapkeu0 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$jml_lapkeu0 = $row['JUMLAH'];
	 }
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('B24',$jml_lapkeu0);

	 $query = $this->Kertas_kerja_mdl->getNewDataByAkun($bulandari,$bulanke,($tahundari+1),'41099999',$cabang);
	 $jml_lapkeu1 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$jml_lapkeu1 = $row['JUMLAH'];
	 }
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('D24',$jml_lapkeu1);

	 $query = $this->Kertas_kerja_mdl->getNewDataByAkun($bulandari,$bulanke,($tahundari),'89198021',$cabang);
	 $jml_lapkeu2 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$jml_lapkeu2 = $row['JUMLAH'];
	 }
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('C25',$jml_lapkeu2);
	 $query = $this->Kertas_kerja_mdl->getNewDataByAkun($bulandari,$bulanke,($tahundari+1),'89198021',$cabang);
	 $jml_lapkeu3 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$jml_lapkeu3 = $row['JUMLAH'];
	 }
	 $objPHPExcel->setActiveSheetIndex(0)
	 ->setCellValue('E25',$jml_lapkeu3);

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_beban_bonus_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {	
    $fileName = 'KertasKerjaPenyesuaianBebanBonus.xlsx';		
    $objPHPExcel = $this->getHeaderXLS($fileName);
    $objPHPExcel->setActiveSheetIndex(0)
	  ->setCellValue('A1','REKAP PEMBAYARAN BEBAN BONUS TAHUN '.$tahundari);
	  $sql = "select KODE_CABANG,NAMA_CABANG
	  from SIMTAX_KODE_CABANG 
	  where AKTIF = 'Y' ";
	  if ($cabang != 'all') {
			$sql .= " and kode_cabang = '".$cabang."'";
	  }
	  $result = $this->db->query($sql);
	  $i = 4;
	  	foreach($result->result_array() as $row) 
		{
			$query = $this->Kertas_kerja_mdl->get_kk_beban_bonus($bulandari,$bulanke,$tahundari,$row['KODE_CABANG'],$row['NAMA_CABANG']);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$i,$i-3)
			->setCellValueByColumnAndRow(1,$i,$row['NAMA_CABANG']);
			foreach($query->result_array() as $row2) 
			{
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(2,$i,$row2['AMOUNT_BONUS'])
				->setCellValueByColumnAndRow(3,$i,$row2['AMOUNT_BONUS_EX'])
				->setCellValueByColumnAndRow(6,$i,$row2['BEBAN_BONUS']);
			}

			$i++;
		}

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_beban_tantiem_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {		
    $sql = "select beban_tantiem_id, nama, hari, jumlah_tantiem, pajak, jumlah_diterima, tahun, divisi
      from SIMTAX_BEBAN_TANTIEM 
	where tahun between ".$tahundari." and ".$tahunke." 
	ORDER BY divisi";

    $fileName = 'KertasKerjaPenyesuaianBebanTantiem.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('C2',$tahundari.'  S.D  '.$tahunke);
    $i = 4; 
    $divisi = "";
    $r = 4; 
    $s = 0;
    $result = $this->db->query($sql);
    foreach($result->result_array() as $row) {
      if ($divisi != $row['DIVISI']) {
        if ($i != $r) {
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A".($r).":A".($i-1));	
        }
        $r = $i;
        $divisi = $row['DIVISI'];
      } 
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1,$i,$i-3)
        ->setCellValueByColumnAndRow(0,$i,$row['DIVISI'])
        ->setCellValueByColumnAndRow(2,$i,$row['NAMA'])
        ->setCellValueByColumnAndRow(3,$i,$row['HARI'])
        ->setCellValueByColumnAndRow(4,$i,$row['JUMLAH_TANTIEM'])
        ->setCellValueByColumnAndRow(5,$i,$row['PAJAK'])
		    ->setCellValueByColumnAndRow(6,$i,$row['JUMLAH_DITERIMA'])
	    ;
	  
      $i++;
	  }

	  $jml_beban_tantiem = 0;
	  $sql2 = "select sum(nvl(period_net_dr,0) - nvl(period_net_cr,0)) as jml_beban_tantiem
				from SIMTAX_TB_V
				where coa = '80101071'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari;
		$result = $this->db->query($sql2);
		foreach($result->result_array() as $row) {
			$jml_beban_tantiem = $row['JML_BEBAN_TANTIEM'];
		}		

	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A25', "JUMLAH BEBAN TANTIEM TAHUN ".$tahundari." SAMPAI TAHUN ".$tahunke." MENURUT LAPORAN KEUANGAN ".$tahundari);
	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G25',  $jml_beban_tantiem );
	  
    $this->getFooterXLS('KertasKerjaPenyesuaianBebanTantiem.xlsx',$objPHPExcel);    
  }

  function cetak_kk_uang_saku_dinas_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {	
    $fileName = 'KertasKerjaPenyesuaianUangSakuPerjalananDinas.xlsx';		
    $objPHPExcel = $this->getHeaderXLS($fileName);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA REALISASI UANG SAKU SPPD TAHUN ".$tahundari);

    $sql = "select KODE_CABANG,NAMA_CABANG
      from SIMTAX_KODE_CABANG 
      where AKTIF = 'Y' ";
    
    if ($cabang != 'all') {
      $sql .= " and kode_cabang = '".$cabang."'";
    }
    $result = $this->db->query($sql);
    $i = 5;
    foreach($result->result_array() as $row) {
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0,$i,$i-4)
        ->setCellValueByColumnAndRow(1,$i,$row['NAMA_CABANG']);

		/*
      $sql1 = "select nvl(sum(nvl(debit,0)-nvl(credit,0)),0) as nilai
        from simtax_rincian_bl_pph_badan
        where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak = ".$tahundari." 
        and kode_akun in('80108011')";
		*/
		$sql1 = "select nvl(sum(nvl(uang_saku,0)),0) as nilai
        from simtax_sppd
        where kode_cabang = '".$row['KODE_CABANG']."' and period_year = '".$tahundari."' 
        and kode_akun in('80108011')";
      $result1 = $this->db->query($sql1);

      foreach($result1->result_array() as $row1) {
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(2,$i,$row1['NILAI']);
      }

	  /*
      $sql1 = "select nvl(sum(nvl(debit,0)-nvl(credit,0)),0) as nilai
        from simtax_rincian_bl_pph_badan
        where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak = ".$tahundari." 
        and kode_akun in('80108012')";
	  */
	  $sql1 = "select nvl(sum(nvl(uang_saku,0)),0) as nilai
        from simtax_sppd
        where kode_cabang = '".$row['KODE_CABANG']."' and period_year = ".$tahundari." 
        and kode_akun in('80108012')";
      $result1 = $this->db->query($sql1);

      foreach($result1->result_array() as $row1) {
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(3,$i,$row1['NILAI']);
      }
      $i++;
    }

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_beban_obligasi_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {	
    $fileName = 'KertasKerjaPenyesuaianBebanBungaObligasi.xlsx';		
    $objPHPExcel = $this->getHeaderXLS($fileName);
    
	$qobligasi	= $this->Kertas_kerja_mdl->rincian_obligasi($tahundari); 
    $i = 4;
    foreach($qobligasi->result_array() as $row) {
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1,$i,$row['AKUN'])
        ->setCellValueByColumnAndRow(2,$i,$row['JANUARI'])
        ->setCellValueByColumnAndRow(3,$i,$row['FEBRUARI'])
        ->setCellValueByColumnAndRow(4,$i,$row['MARET'])
        ->setCellValueByColumnAndRow(5,$i,$row['APRIL'])
        ->setCellValueByColumnAndRow(6,$i,$row['MEI'])
        ->setCellValueByColumnAndRow(7,$i,$row['JUNI'])
        ->setCellValueByColumnAndRow(8,$i,$row['JULI'])
        ->setCellValueByColumnAndRow(9,$i,$row['AGUSTUS'])
        ->setCellValueByColumnAndRow(10,$i,$row['SEPTEMBER'])
        ->setCellValueByColumnAndRow(11,$i,$row['OKTOBER'])
        ->setCellValueByColumnAndRow(12,$i,$row['NOVEMBER'])
        ->setCellValueByColumnAndRow(13,$i,$row['DESEMBER'])
      ;
      $i++;
    }
	
	$qobligasi2	= $this->Kertas_kerja_mdl->rincian_obligasi2($tahundari); 
    $i = 116;
    foreach($qobligasi2->result_array() as $row) {
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1,$i,$row['KODE_AKUN'])
        ->setCellValueByColumnAndRow(2,$i,$row['AKUN_DESCRIPTION'])
        ->setCellValueByColumnAndRow(3,$i,$row['JANUARI'])
        ->setCellValueByColumnAndRow(4,$i,$row['FEBRUARI'])
        ->setCellValueByColumnAndRow(5,$i,$row['MARET'])
        ->setCellValueByColumnAndRow(6,$i,$row['APRIL'])
        ->setCellValueByColumnAndRow(7,$i,$row['MEI'])
        ->setCellValueByColumnAndRow(8,$i,$row['JUNI'])
        ->setCellValueByColumnAndRow(9,$i,$row['JULI'])
        ->setCellValueByColumnAndRow(10,$i,$row['AGUSTUS'])
        ->setCellValueByColumnAndRow(11,$i,$row['SEPTEMBER'])
        ->setCellValueByColumnAndRow(12,$i,$row['OKTOBER'])
        ->setCellValueByColumnAndRow(13,$i,$row['NOVEMBER'])
        ->setCellValueByColumnAndRow(14,$i,$row['DESEMBER'])
      ;
      $i++;
	}

	$vbeban_obligasi = 0;
	
	$sql2 ="select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) jml_beban_obligasi
	from simtax_tb_v
	where coa = '89101162'
	and period_year = ".$tahundari."
	and period_num between ".$bulandari." and ".$bulanke." ";

	$result = $this->db->query($sql2);
	foreach($result->result_array() as $row) {
		$vbeban_obligasi = $row['JML_BEBAN_OBLIGASI'];
	}
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('D137',$vbeban_obligasi);

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_penyisihan_piutang_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {		
    $fileName = 'KertasKerjaPenyesuaianPenyisihanPiutang.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B3','TAHUN BUKU '.$tahundari.' (AUDITED)');
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('E5','31/12/'.($tahundari-1).' (AUDITED)');

    $sql = "select KODE_CABANG,NAMA_CABANG
      from SIMTAX_KODE_CABANG 
      where AKTIF = 'Y' ";
    
    if ($cabang != 'all') {
      $sql .= " and kode_cabang = '".$cabang."'";
    }
    $result = $this->db->query($sql);
    $i = 10;
    foreach($result->result_array() as $row) {
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1,$i,$i-9)
        ->setCellValueByColumnAndRow(2,$i,$row['NAMA_CABANG']);
	
	  $vtotaldeslast = 0;
	  $sql1 = "select coa, coa_desc, (abs(begbal)-(mutasi)) deslast
	  from (
	  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
	  (
	  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
		  from simtax_tb_v a
		  where 1=1
		  and period_year = ".($tahundari-1)." 
		  and branch_code = '".$row['KODE_CABANG']."'
		  and period_num between ".$bulandari." and ".$bulandari."
		  and a.coa = stv.coa
	  ) begbal
	  from simtax_tb_v stv
	  where 1=1
	  and branch_code = '".$row['KODE_CABANG']."'
	  and coa between '11301101' and '11699999'
	  and period_num between ".$bulandari." and ".$bulanke."
	  and period_year = ".($tahundari-1)." 
	  group by coa, coa_desc
	  ) order by coa asc";
      $result1 = $this->db->query($sql1);
      foreach($result1->result_array() as $row1) {
		$vtotaldeslast +=  $row1['DESLAST'];
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4,$i,$vtotaldeslast);
      }
	
	  $vtransaksi = 0;
	  $sql1 = "select coa, coa_desc, (abs(begbal)-(mutasi)) jml_uraian
	  from (
	  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
	  (
	  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
		  from simtax_tb_v a
		  where 1=1
		  and period_year = ".($tahundari)." 
		  and branch_code = '".$row['KODE_CABANG']."'
		  and period_num between ".$bulandari." and ".$bulandari."
		  and a.coa = stv.coa
	  ) begbal
	  from simtax_tb_v stv
	  where 1=1
	  and branch_code = '".$row['KODE_CABANG']."'
	  and coa between '11301101' and '11699999'
	  and period_num between ".$bulandari." and ".$bulanke."
	  and period_year = ".($tahundari)." 
	  group by coa, coa_desc
	  ) order by coa asc";
      $result1 = $this->db->query($sql1);
      foreach($result1->result_array() as $row1) {
			$vtransaksi +=  $row1['JML_URAIAN'];
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(9,$i,$vtransaksi);
	  }

	  $sql1 = " select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) as deslast
		from simtax_tb_v
		where branch_code = '".$row['KODE_CABANG']."'
		and period_year = ".($tahundari)." 
		and period_num between ".$bulandari." and ".$bulanke."
        and coa in ('80108021')
        order by coa";
      $result1 = $this->db->query($sql1);
      foreach($result1->result_array() as $row1) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(13,$i,$row1['DESLAST']);
      }
      $i++;
	}
	
	/*
	$sql2 ="
	--select coa, coa_desc, (sum(nvl(stv.begin_balance_dr,0)) - sum(nvl(stv.begin_balance_cr,0))) +  (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) as jml_penyh_piut
	--from simtax_tb_v stv
	--where period_year = ".($tahundari)." 
	--and period_num between ".$bulandari." and ".$bulanke."
	--and coa between '11301101' and '1169999'
	--group by coa, coa_desc";
	*/
	$sql2 = "select coa, coa_desc, sum(deslast) jml_penyh_piut
				from(
				select coa, coa_desc, (abs(begbal)-(mutasi)) deslast
					from (
					select branch_code, coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
					(
						select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
						from simtax_tb_v a
						where 1=1
						and period_year = ".($tahundari)." 
						and a.branch_code = stv.branch_code
						and period_num between ".$bulandari." and ".$bulandari."
						and a.coa = stv.coa
					) begbal
					from simtax_tb_v stv
					where 1=1
					and branch_code in (select kode_cabang from simtax_kode_cabang where aktif='Y')
					and coa between '11301101' and '11699999'
					and period_num between ".$bulandari." and ".$bulanke."
					and period_year = ".($tahundari)." 
					group by branch_code,coa, coa_desc
					) order by coa asc
					) group by coa, coa_desc";
	$result2 = $this->db->query($sql2);
	$j = 39;
	$k = 1;
	foreach($result2->result_array() as $row) {
		$objPHPExcel->setActiveSheetIndex(0)
		  ->setCellValueByColumnAndRow(3,$j,$k.'. '.$row['COA']. ' - '.$row['COA_DESC'])
		  ->setCellValueByColumnAndRow(8,$j,$row['JML_PENYH_PIUT'])
		  ;
		  $j++;
		  $k++;
	}	  

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_imbalan_kerja_pegawai_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {
    $fileName = 'KertasKerjaImbalanKerjaPegawai.xlsx';			
    $objPHPExcel = $this->getHeaderXLS($fileName);
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('F15','abc');

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_rekap_asset_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {
    $fileName = 'KertasKerjaRekapitulasiPenyusutandanAmortisasiAset.xlsx';	
    $objPHPExcel = $this->getHeaderXLS($fileName);
	  
	  $sql = "select KODE_CABANG,NAMA_CABANG
      from SIMTAX_KODE_CABANG 
      where AKTIF = 'Y' ";
    
    if ($cabang != 'all') {
      $sql .= " and kode_cabang = '".$cabang."'";
    }
    $result = $this->db->query($sql);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0,3,'REKAPITULASI PENYUSUTAN DAN AMORTISASI ASET TETAP VERSI FISKAL PER '.$this->getMonthString($bulandari).' S/D '.$this->getMonthString($bulanke).' '.$tahundari);

    $i = 7;
	$vnewhrgpakun = 0;
	$vnewakwujudakun = 0;
	$vnewbebanwujud = 0;
	$vnewhrgtdkwujud = 0;
	$vnewaktdkwujud = 0;
	$vnewbbntdkwujud = 0;
    foreach($result->result_array() as $row) {
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0,$i,$i-6)
        ->setCellValueByColumnAndRow(1,$i,$row['NAMA_CABANG']);

	  $sql1 = "
	  select 
	  (
	      select nvl(sum(harga_perolehan),0)
			  from simtax_rekon_fixed_asset
			  where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke." 
			  and kelompok_fixed_asset = 'B'
	  ) as nilaibangunan,
	  (
		  select nvl(sum(harga_perolehan),0)
			  from simtax_rekon_fixed_asset
			  where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
			  and kelompok_fixed_asset = 'N'
	  ) as nilainonbangunan,
	  (
		  select nvl(sum(harga_perolehan),0)
			from simtax_rekon_fixed_asset
			where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
			and kelompok_fixed_asset = 'T'
	  ) as nilaitidakberwujud,
	  0 as bebanditangguhkan,
	  (
		select nvl(sum(akumulasi_penyusutan),0)
        from simtax_rekon_fixed_asset
        where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
        and kelompok_fixed_asset in ('B','N')
	  ) as akpenyberwujud,
	  (
		select nvl(sum(pembebanan),0)
		from simtax_rekon_fixed_asset
		where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
		and kelompok_fixed_asset in ('B','N')
	  ) as bebanberwujud,
	  (
		select nvl(sum(akumulasi_penyusutan),0)
		from simtax_rekon_fixed_asset
		where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
		and kelompok_fixed_asset in ('T')
	  ) as akpenytidakberwujud,
	  (
		select nvl(sum(pembebanan),0)
		from simtax_rekon_fixed_asset
		where kode_cabang = '".$row['KODE_CABANG']."' and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke." 
		and kelompok_fixed_asset in ('T')
	  ) as bebantidakberwujud
		from dual
		";
      	$result1 = $this->db->query($sql1);
		
	    $totalperolehanbgnnbgn = 0;
		foreach($result1->result_array() as $row1) {
			$vnewhrgpakun += $row1['NILAIBANGUNAN'] + $row1['NILAINONBANGUNAN'];
			$vnewakwujudakun += $row1['AKPENYBERWUJUD'];
			$vnewbebanwujud += $row1['BEBANBERWUJUD'];
			$vnewhrgtdkwujud += $row1['NILAITIDAKBERWUJUD'] + $row1['BEBANDITANGGUHKAN'];
			$vnewaktdkwujud += $row1['AKPENYTIDAKBERWUJUD'];
			$vnewbbntdkwujud += $row1['BEBANTIDAKBERWUJUD'];
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(2,$i,$row1['NILAIBANGUNAN'])
			->setCellValueByColumnAndRow(3,$i,$row1['NILAINONBANGUNAN'])
			->setCellValueByColumnAndRow(4,$i,$row1['NILAITIDAKBERWUJUD'])
			->setCellValueByColumnAndRow(5,$i,$row1['BEBANDITANGGUHKAN'])
			->setCellValueByColumnAndRow(7,$i,$row1['AKPENYBERWUJUD'])
			->setCellValueByColumnAndRow(8,$i,$row1['BEBANBERWUJUD'])
			->setCellValueByColumnAndRow(10,$i,$row1['AKPENYTIDAKBERWUJUD'])
			->setCellValueByColumnAndRow(11,$i,$row1['BEBANTIDAKBERWUJUD']);
		}

			if ($row['KODE_CABANG'] != '000') {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$i+23,$i-4)
					->setCellValueByColumnAndRow(1,$i+23,'Aset Cabang '.$row['NAMA_CABANG']);

				$sql2 = "
				select
					(select nvl(sum(pembebanan),0)
					from simtax_rekon_fixed_asset
					where kode_cabang = '".$row['KODE_CABANG']."' 
					and tahun_pajak  = ".$tahundari." and bulan_pajak between  ".$bulandari." and ".$bulanke."  
					and kelompok_fixed_asset in ('B')
					AND kode_cabang <> '000'
					) as bebanberwujud
				from dual
				";
				$result2 = $this->db->query($sql2);
				foreach($result2->result_array() as $row2) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(8,$i+23,$row2['BEBANBERWUJUD']);
				}
			}
      $i++;
	}

	$vcoa1 = "'20200000','20201000','20201101','20201102','20201103','20201104','20201105','20201106','20201107','20201108','20201109','20201110','20201111','20202000',
	'20202101','20202102','20202103','20202104','20202999','20203000','20203101','20203102','20203103','20203104','20203105','20203106','20203107','20203108',
	'20203109','20203110','20203111','20203112','20203113','20203114','20203115','20203116','20203117','20203118','20203119','20203120','20203121','20203122',
	'20203999','20204000','20204101','20204102','20204103','20204104','20204105','20204106','20204107','20205101','20206000','20206101','20206102','20206103',
	'20206104','20206105','20206106','20206107','20206108','20206109','20206110','20206111','20206112','20206999','20207000','20207100','20207101','20207102',
	'20207103','20207104','20207105','20207106','20207107','20207108','20207109','20207201','20207999','20208000','20208101','20208102','20209000','20209101',
	'20209102','20209103'";
	
	$query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa1,$cabang);
	 $p_min_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$p_min_tanah = $row['JUMLAH'];
	 }

	 $vcoa2 = "'20205101'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa2,$cabang);
	 $properti_invest_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$properti_invest_tanah = $row['JUMLAH'];
	 }

	 $vcoa3 = "'20300000','20301000','20301101','20301102','20301103','20301104','20301105','20301106','20301107','20301108','20301109','20301110',
	 '20301111','20302000','20302101','20302102','20302103','20302104','20302999','20303000','20303101','20303102','20303103','20303104',
	 '20303105','20303106','20303107','20303108','20303109','20303110','20303111','20303112','20303113','20303114','20303115','20303116',
	 '20303117','20303118','20303119','20303120','20303121','20303122','20303999','20304000','20304101','20304102','20304103','20304104',
	 '20304105','20304106','20304107','20304108','20305101','20306000','20306101','20306102','20306103','20306104','20306105','20306106',
	 '20306107','20306108','20306109','20306110','20306111','20306112','20306999','20307000','20307100','20307101','20307102','20307103',
	 '20307104','20307105','20307106','20307107','20307108','20307201','20307999','20308000','20308101','20308102','20309000','20309101',
	 '20309102','20309103','20309999','20400000','20401101','20402101','20403101','20404101','20405101','20406101','20407101','20407201',
	 '20408101','20499101','20500000','20501000','20501101','20501102','20501103','20501104','20501105','20501106','20501107','20501108',
	 '20501109','20501110','20501111','20502000','20502101','20502102','20502103','20502104','20502999','20503000','20503101','20503102',
	 '20503103','20503104','20503105','20503106','20503107','20503108','20503109','20503110','20503111','20503112','20503113','20503114',
	 '20503115','20503116','20503117','20503118','20503119','20503120','20503121','20503122','20503999','20504000','20504101','20504102',
	 '20504103','20504104','20504105','20504106','20504107','20504108','20505101','20506000','20506101','20506102','20506103','20506104',
	 '20506105','20506106','20506107','20506108','20506109','20506110','20506111','20506112','20506999','20507000','20507100','20507101',
	 '20507102','20507103','20507104','20507105','20507106','20507107','20507108','20507200','20507201','20507999','20508000','20508101',
	 '20508102','20509000','20509101','20509102','20509103','20600000','20601000','20601101','20601102','20601103','20601104','20601105',
	 '20601106','20601107','20601108','20601109','20601110','20601111','20602000','20602101','20602102','20602103','20602104','20602999',
	 '20603000','20603101','20603102','20603103','20603104','20603105','20603106','20603107','20603108','20603109','20603110','20603111',
	 '20603112','20603113','20603114','20603115','20603116','20603117','20603118','20603119','20603120','20603121','20603122','20603999',
	 '20604000','20604101','20604102','20604103','20604104','20604105','20604106','20604107','20605001','20605101','20606000','20606101',
	 '20606102','20606103','20606104','20606105','20606106','20606107','20606108','20606109','20606110','20606111','20606112','20606999',
	 '20607000','20607100','20607101','20607102','20607103','20607104','20607105','20607106','20607107','20607108','20607109','20607200',
	 '20607201','20607999','20608000','20608101','20608102','20609000','20609101','20609102','20609103'";

	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa3,$cabang);
	 $p_min_tanah2 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$p_min_tanah2 = $row['JUMLAH'];
	 }

	 $vcoa4 ="'20305101'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa4,$cabang);
	 $asset_tetap_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$asset_tetap_tanah = $row['JUMLAH'];
	 }

	 $vcoa5 ="'20405101'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa5,$cabang);
	 $asset_sewaan_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$asset_sewaan_tanah = $row['JUMLAH'];
	 }

	 $vcoa6 ="'20505101'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa6,$cabang);
	 $asset_kso_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$asset_kso_tanah = $row['JUMLAH'];
	 }

	 $vcoa7 ="'20605001'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa7,$cabang);
	 $asset_pba_tanah = 0;
	 foreach($query->result_array() as $row) 
	 {
		$asset_pba_tanah = $row['JUMLAH'];
	 }

	 $vcoa8 ="'20605101'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoa8,$cabang);
	 $asset_pba_tanah2 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$asset_pba_tanah2 = $row['JUMLAH'];
	 }

	 $p_athb_akuntansi = ($p_min_tanah - $properti_invest_tanah) + ($p_min_tanah2 - $asset_tetap_tanah - $asset_sewaan_tanah - $asset_kso_tanah - $asset_pba_tanah - $asset_pba_tanah2);

	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('G24',$p_athb_akuntansi);
	 ->setCellValue('G24',$vnewhrgpakun);

	 $vcoaakp1 ="'21300000','21301000','21301101','21301102','21301103','21301104','21301105','21301106','21301107','21301108','21301109','21301110','21301111','21302000',
	 '21302101','21302102','21302103','21302104','21302999','21303000','21303101','21303102','21303103','21303104','21303105','21303106','21303107','21303108',
	 '21303109','21303110','21303111','21303112','21303113','21303114','21303115','21303116','21303117','21303118','21303119','21303120','21303121','21303122',
	 '21303999','21304000','21304101','21304102','21304103','21304104','21304105','21304106','21304107','21304108','21305101','21306000','21306101','21306102',
	 '21306103','21306104','21306105','21306106','21306107','21306108','21306109','21306110','21306111','21306112','21306999','21307000','21307100','21307101',
	 '21307102','21307103','21307104','21307105','21307106','21307107','21307108','21307200','21307201','21307999','21308000','21308101','21308102','21309000',
	 '21309101','21309102','21309103','21309199','21310000','21311000','21311101','21311102','21311103','21311104','21311105','21311106','21311107','21311108',
	 '21311109','21311110','21311111','21312000','21312101','21312102','21312103','21312104','21312999','21313000','21313101','21313102','21313103','21313104',
	 '21313105','21313106','21313107','21313108','21313109','21313110','21313111','21313112','21313113','21313114','21313115','21313116','21313117','21313118',
	 '21313119','21313999','21314000','21314101','21314102','21314103','21314104','21314105','21314106','21314107','21315101','21316000','21316101','21316102',
	 '21316103','21316104','21316105','21316106','21316107','21316108','21316109','21316110','21316111','21316112','21316999','21317000','21317100','21317101',
	 '21317102','21317103','21317104','21317105','21317106','21317107','21317108','21317200','21317201','21317999','21318000','21318101','21318102','21319000',
	 '21319101','21319102','21319103','21319199','21400000','21401101','21402101','21403101','21404101','21405101','21406101','21407101','21407201','21408101',
	 '21499101','21500000','21501000','21501101','21501102','21501103','21501104','21501105','21501106','21501107','21501108','21501109','21501110','21501111',
	 '21502000','21502101','21502102','21502103','21502104','21502999','21503000','21503101','21503102','21503103','21503104','21503105','21503106','21503107',
	 '21503108','21503109','21503110','21503111','21503112','21503113','21503114','21503115','21503116','21503117','21503118','21503119','21503120','21503121',
	 '21503122','21503999','21504000','21504101','21504102','21504103','21504104','21504105','21504106','21504107','21504108','21505101','21506000','21506101',
	 '21506102','21506103','21506104','21506105','21506106','21506107','21506108','21506109','21506110','21506111','21506112','21506999','21507000','21507100',
	 '21507101','21507102','21507103','21507104','21507105','21507106','21507107','21507108','21507200','21507201','21507999','21508000','21508101','21508102',
	 '21509000','21509101','21509102','21509103','21600000','21601000','21601101','21601102','21601103','21601104','21601105','21601106','21601107','21601108',
	 '21601109','21601110','21601111','21602000','21602101','21602102','21602103','21602104','21602999','21603000','21603101','21603102','21603103','21603104',
	 '21603105','21603106','21603107','21603108','21603109','21603110','21603111','21603112','21603113','21603114','21603115','21603116','21603117','21603118',
	 '21603119','21603120','21603121','21603122','21603999','21604000','21604101','21604102','21604103','21604104','21604105','21604106','21604107','21605101',
	 '21606000','21606101','21606102','21606103','21606104','21606105','21606106','21606107','21606108','21606109','21606110','21606111','21606112','21606999',
	 '21607000','21607100','21607101','21607103','21607104','21607105','21607106','21607107','21607108','21607109','21607200','21607201','21607999','21608000',
	 '21608101','21608102','21609000','21609101','21609102','21609103'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoaakp1,$cabang);
	 $v_akp_akun = 0;
	 foreach($query->result_array() as $row) 
	 {
		$v_akp_akun = $row['JUMLAH'];
	 }

	 $vcoaakp2 ="'21200000','21201000','21201101','21201102','21201103','21201104','21201105','21201106','21201107','21201108','21201109','21201110',
	 '21201111','21202000','21202101','21202102','21202103','21202104','21202999','21203000','21203101','21203102','21203103','21203104',
	 '21203105','21203106','21203107','21203108','21203109','21203110','21203111','21203112','21203113','21203114','21203115','21203116',
	 '21203117','21203118','21203119','21203120','21203121','21203122','21203999','21204000','21204101','21204102','21204103','21204104',
	 '21204105','21204106','21204107','21205101','21206000','21206101','21206102','21206103','21206104','21206105','21206106','21206107',
	 '21206108','21206109','21206110','21206111','21206112','21206999','21207000','21207100','21207101','21207102','21207103','21207104',
	 '21207105','21207106','21207107','21207108','21207109','21207200','21207201','21207999','21208000','21208101','21208102','21209000',
	 '21209101','21209102','21209103','21209199'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoaakp2,$cabang);
	 $v_akp_akun2 = 0;
	 foreach($query->result_array() as $row) 
	 {
		$v_akp_akun2 = $row['JUMLAH'];
	 }
	 $akp_athb_akuntansi = ($v_akp_akun + $v_akp_akun2);

	 $query = $this->Kertas_kerja_mdl->akumulasipenyasset($bulandari, $bulanke, $tahundari);
	 foreach($query->result_array() as $row) 
	 {
		$vakpakun = $row['VJMLPENYASSET'];
	 }
	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('H24',$vnewakwujudakun);
	 ->setCellValue('H24',abs($vakpakun));

	 $vcoabeban = "'80104000','80104100','80104101','80104102','80104103','80104104','80104105','80104106','80104107','80104108','80104109','80104110',
	 '80104200','80104211','80104221','80104231','80104241','80104251','80104261','80104270','80104271','80104272','80104281','80104299',
	 '80104300','80104321','80104322','80104323','80104324','80104326','80104327','80104328','80104329','80104399','80104400','80104411',
	 '80104421','80104431','80104441','80104451','80104461','80104470','80104471','80104472','80104481','80104491','80104500','80104511',
	 '80104521','80104531','80104541','80104551','80104561','80104570','80104571','80104572','80104581','80104591','80104700','80104701'
	 ";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoabeban,$cabang);
	 $pembebanan = 0;
	 foreach($query->result_array() as $row) 
	 {
		$pembebanan = $row['JUMLAH'];
	 }

	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('I24',$pembebanan);
	 ->setCellValue('I24',$vnewbebanwujud);

	 $vcoaamor = "'20900000','20901101','20901102','20901103','20901104','20901105','20901106','20999999','20800000','20801101',
	 '20801201','20801301','20801401','20801402','20801403','20801404','20801405','20801406','20801407','20801408','20801409','20801410',
	 '20801411','20801412','20801413','20801414','20801415','20801416','20801417','20801418','20801419','20801420','20801421','20801422',
	 '20801423','20801424','20801425','20801426','20801427','20801428','20801429','20801430','20801431','20801432','20801433','20801434',
	 '20801435','20801436','20801437','20801438','20801439','20801440','20801441','20801442','20801443','20801444','20801445','20801446',
	 '20801447','20801448','20801449','20801450','20801451','20801452','20801453','20801454','20801455','20801456','20801457','20801458',
	 '20801459','20801460','20801461','20801462','20801463','20801464','20801465','20801466','20801467','20801468','20801469','20801470','20801471',
	'20801472','20801473','20801474','20801475','20801476','20801477','20801478','20801479','20801480','20801481','20801482','20801483','20801484',
	'20809999','20810000','20811101','20731101','20731102','20731103','20731104','20731105','20731106','20731107','20731108','20731109','20731110',
	'20731111','20731112','20731113','20731114','20731115','20731116','20731117','20731118','20731119','20731120','20731121','20731122','20731123',
	'20731124','20731125','20731126','20731127','20731128','20731129','20731130','20731131','20731132','20731133','20731134','20731135','20731136',
	'20731137','20731138','20731139','20731140','20731141','20731142','20731143','20731144','20731145'	
	 ";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoaamor,$cabang);
	 $hrg_peroleh_amor = 0;
	 foreach($query->result_array() as $row) 
	 {
		$hrg_peroleh_amor = $row['JUMLAH'];
	 }

	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('J24',$hrg_peroleh_amor);
	 ->setCellValue('J24',$vnewhrgtdkwujud);


	 $vcoaakpamor = "'21800000','21801101','21802101','21803101','21804100','21804101','21804102','21804103','21804104','21804105','21804106','21804107','21804108','21804109',
	 '21804110','21804111','21804220','21804221','21804222','21804223','21804224','21804225','21804300','21804301','21804302','21804303','21804304','21804305',
	 '21804306','21804307','21804308','21804309','21804310','21804311','21804312','21804313','21804314','21804315','21804316','21804317','21804318','21804319',
	 '21804320','21804400','21804401','21804402','21804403','21804404','21804405','21804406','21804407','21804408','21804500','21804501','21804600','21804601',
	 '21804602','21804603','21804604','21804605','21804606','21804607','21804608','21804609','21804610','21804611','21804612','21804613','21804700','21804701',
	 '21804702','21804703','21804704','21804705','21804706','21804707','21804708','21804709','21804710','21804800','21804801','21804802','21804900','21804901',
	 '21804902','21804903','21804904','21809999','21900000','21901101','21804102','21901103','21901104','21901105','21901106','21999999','21320000','21321101','21321201',
	 '21321301','21321401','21329999'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoaakpamor,$cabang);
	 $akp_penyusutan_amor = 0;
	 foreach($query->result_array() as $row) 
	 {
		$akp_penyusutan_amor = $row['JUMLAH'];
	 }

	 $query = $this->Kertas_kerja_mdl->akumulasipenyamor($bulandari, $bulanke, $tahundari);
	 foreach($query->result_array() as $row) 
	 {
		$vakpakunamor = $row['VJMLPENYAMOR'];
	 }

	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('K24',$akp_penyusutan_amor);
	 ->setCellValue('K24',abs($vakpakunamor));

	 $vcoabebanamor="'80104600','80104601','80104602','80104603','80104604','80104605','80104606','80104607','80104699','80104700','80104702',
	 '80104800','80104801','80104802','80104803','80104804','80104805','80104806','80104807','80104808','80104809','80104810'";
	 $query = $this->Kertas_kerja_mdl->getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$vcoabebanamor,$cabang);
	 $beban_amor = 0;
	 foreach($query->result_array() as $row) 
	 {
		$beban_amor = $row['JUMLAH'];
	 }

	 $objPHPExcel->setActiveSheetIndex(0)
	 //->setCellValue('L24',$beban_amor); 
	 ->setCellValue('L24',$vnewbbntdkwujud);

    $this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
  }

  function cetak_kk_biaya_lain_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) {		
					
	if ($cabang != 'all') {

		$fileName = 'KertasKerjaBiayaLainCabang.xlsx';
		$objPHPExcel = $this->getHeaderXLS($fileName);

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A2','BULAN '.$this->getMonthString($bulandari). ' S.D '.$this->getMonthString($bulanke).' '.$tahundari);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D4','31-'.$this->getMonthString($bulanke).'-'.$tahunke)
		->setCellValue('G4',$this->getMonthString($bulanke).'-'.$tahunke);

		$sql0 = "select kode_akun, akun_description
					from SIMTAX_RINCIAN_BL_PPH_BADAN
					where kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
										'80108061', '89199999', '80106999', '80108999')
					group by kode_akun, akun_description
					order by kode_akun asc
			";	
			$result0 = $this->db->query($sql0);
			$i = 5;
			$l = 5;
			$jmluraian = 0;
			$deductible = 0;
			$nondeductible = 0;
			foreach($result0->result_array() as $row0) {
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$i,$i-4)
								->setCellValueByColumnAndRow(1,$i,$row0['KODE_AKUN'])
								->setCellValueByColumnAndRow(2,$i,$row0['AKUN_DESCRIPTION']);
				$sql = "select KODE_CABANG,NAMA_CABANG
						from SIMTAX_KODE_CABANG 
						where AKTIF = 'Y' 
						AND KODE_CABANG = '".$cabang."'";
				$result = $this->db->query($sql);

				$m = 3;
				$n = 4;
				$o = 5;
				$j = 4;
				$k = 6;
				$k0 = 6;	
				$k1 = 7;	
				$k2 = 8;
				foreach($result->result_array() as $row) {
				$sql1 = "select kode_akun
							, akun_description
							, sum(nvl(debit,0)) jml_uraian
							, sum(case nvl(CHECKLIST,'0')
							when '0' then debit
							else 0
							end) DEDUCTIBLE 
							, sum(case nvl(CHECKLIST,'0')
							when '1' then debit
							else 0
							end) NON_DEDUCTIBLE
							,
							(
								select sum(nvl(debit,0)) 
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_cabang = '".$row['KODE_CABANG']."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_URAIAN2
							,
							(
								select sum(case nvl(CHECKLIST,'0')
										when '1' then debit
										else 0
										end)  
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_cabang = '".$row['KODE_CABANG']."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_DR
							,
							(
								select sum(case nvl(CHECKLIST,'0')
										when '0' then debit
										else 0
										end)  
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_cabang = '".$row['KODE_CABANG']."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_CR
									from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
									and bulan_pajak between '".$bulandari."' and '".$bulanke."'
									and kode_cabang = '".$row['KODE_CABANG']."'
									and kode_akun = '".$row0['KODE_AKUN']."'
									group by tahun_pajak, kode_akun, akun_description
									order by kode_akun";
					$result1 = $this->db->query($sql1);	
					foreach($result1->result_array() as $row1) {
						if($row1['JML_URAIAN'] != ""){
							$jmluraian = $row1['JML_URAIAN'];
						}
						if($row1['DEDUCTIBLE'] != ""){
							$deductible = $row1['DEDUCTIBLE'];
						}
						if($row1['NON_DEDUCTIBLE'] != ""){
							$nondeductible = $row1['NON_DEDUCTIBLE'];
						}
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($k0,3,strtoupper($row['NAMA_CABANG']));
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($m,$l,$row1['JML_URAIAN2'])
							->setCellValueByColumnAndRow($n,$l,$row1['JML_DR'])
							->setCellValueByColumnAndRow($o,$l,$row1['JML_CR']);		
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($k,$l,$jmluraian);		
						$objPHPExcel->setActiveSheetIndex(0)	
							->setCellValueByColumnAndRow($k1,$l,$deductible);
						$objPHPExcel->setActiveSheetIndex(0)	
							->setCellValueByColumnAndRow($k2,$l,$nondeductible);
					}
					$k=$k+3;$k0=$k0+3;$k1=$k1+3;$k2=$k2+3;	
				}
				$l++;
				$i++;	
			}

	} else {

			$fileName = 'KertasKerjaBiayaLain.xlsx';
			$objPHPExcel = $this->getHeaderXLS($fileName);
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2','BULAN '.$this->getMonthString($bulandari). ' S.D '.$this->getMonthString($bulanke).' '.$tahundari);

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D4','31-'.$this->getMonthString($bulanke).'-'.$tahunke);

			$sql0 = "select kode_akun, akun_description
					from SIMTAX_RINCIAN_BL_PPH_BADAN
					where kode_akun in ('80108011','80102191', '80105999', '80106311', '80107999', '80108041',
										'80108061', '89199999', '80106999', '80108999')
					group by kode_akun, akun_description
					order by kode_akun asc
			";	
			$result0 = $this->db->query($sql0);
			$i = 5;
			$l = 5;
			$jmluraian = 0;
			$deductible = 0;
			$nondeductible = 0;
			foreach($result0->result_array() as $row0) {
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$i,$i-4)
								->setCellValueByColumnAndRow(1,$i,$row0['KODE_AKUN'])
								->setCellValueByColumnAndRow(2,$i,$row0['AKUN_DESCRIPTION']);
				$sql = "select KODE_CABANG,NAMA_CABANG
						from SIMTAX_KODE_CABANG 
						where AKTIF = 'Y' 
						order by KODE_CABANG";
				$result = $this->db->query($sql);

				$m = 3;
				$n = 4;
				$o = 5;
				$k = 6;
				$k0 = 6;	
				$k1 = 7;	
				$k2 = 8;
				foreach($result->result_array() as $row) {
				$sql1 = "select kode_akun
							, akun_description
							, sum(nvl(debit,0)) jml_uraian
							, sum(case nvl(CHECKLIST,'0')
							when '0' then debit
							else 0
							end) DEDUCTIBLE 
							, sum(case nvl(CHECKLIST,'0')
							when '1' then debit
							else 0
							end) NON_DEDUCTIBLE
							,
							(
								select sum(nvl(debit,0)) 
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_URAIAN2
							,
							(
								select sum(case nvl(CHECKLIST,'0')
										when '1' then debit
										else 0
										end)  
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_DR
							,
							(
								select sum(case nvl(CHECKLIST,'0')
										when '0' then debit
										else 0
										end)  
								from SIMTAX_RINCIAN_BL_PPH_BADAN
								where tahun_pajak between '".$tahundari."' and '".$tahunke."'
								and bulan_pajak between '".$bulandari."' and '".$bulanke."'
								and kode_akun = '".$row0['KODE_AKUN']."'
							) JML_CR
							from SIMTAX_RINCIAN_BL_PPH_BADAN
							where tahun_pajak between '".$tahundari."' and '".$tahunke."'
							and bulan_pajak between '".$bulandari."' and '".$bulanke."'
							and kode_cabang = '".$row['KODE_CABANG']."'
							and kode_akun = '".$row0['KODE_AKUN']."'
							group by tahun_pajak, kode_akun, akun_description
							order by kode_akun";
					/*
					if ($cabang != 'all') {
						$sql .= " and kode_cabang = '".$cabang."'";
					}
					*/
					$result1 = $this->db->query($sql1);	
					foreach($result1->result_array() as $row1) {
						if($row1['JML_URAIAN'] != ""){
							$jmluraian = $row1['JML_URAIAN'];
						}
						if($row1['DEDUCTIBLE'] != ""){
							$deductible = $row1['DEDUCTIBLE'];
						}
						if($row1['NON_DEDUCTIBLE'] != ""){
							$nondeductible = $row1['NON_DEDUCTIBLE'];
						}
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($k0,3,strtoupper($row['NAMA_CABANG']))
							->setCellValueByColumnAndRow($k0,4,$this->getMonthString($bulanke).'-'.$tahunke)
							->setCellValueByColumnAndRow($m,$l,$row1['JML_URAIAN2'])
							->setCellValueByColumnAndRow($n,$l,$row1['JML_DR'])
							->setCellValueByColumnAndRow($o,$l,$row1['JML_CR'])
							->setCellValueByColumnAndRow($k,$l,$jmluraian)
							->setCellValueByColumnAndRow($k1,$l,$deductible)
							->setCellValueByColumnAndRow($k2,$l,$nondeductible);
					}
					$k=$k+3;$k0=$k0+3;$k1=$k1+3;$k2=$k2+3;	
				}
				$l++;
				$i++;	
			}
		}
		$this->getFooterXLS($fileName,$objPHPExcel,$objWriter);   			
	}

	function cetak_kk_beban_bersama_xls($jeniskk,$nmjeniskk,$tahundari,$tahunke,$bulandari,$bulanke,$masa,$cabang) 
	{		
		$fileName = 'KertasKerjaBebanBersama.xlsx';	
		$objPHPExcel = $this->getHeaderXLS($fileName);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('B1','PERHITUNGAN BEBAN BERSAMA BEBAN FINAL (PP 94 TAHUN 2010 PASAL 27 AYAT 2)');
		
		
		$i = 1;
		$r = 5;
		
		$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_d($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$r,$i)
			->setCellValueByColumnAndRow(2,$r,'Direksi')
			->setCellValueByColumnAndRow(3,$r,$row['COA'])
			->setCellValueByColumnAndRow(4,$r,$row['COA_DESC'])
			->setCellValueByColumnAndRow(5,$r,$row['JUMLAH'])
			->setCellValueByColumnAndRow(6,$r,$row['JMLDR'])
			->setCellValueByColumnAndRow(7,$r,$row['JMLCR']);
			$i++;
			$r++;	
		}
		
		$r = 76;
		$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_vpdk($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$r,$i)
			->setCellValueByColumnAndRow(2,$r,'Vice President Divisi Komersial')
			->setCellValueByColumnAndRow(3,$r,$row['COA'])
			->setCellValueByColumnAndRow(4,$r,$row['COA_DESC'])
			->setCellValueByColumnAndRow(5,$r,$row['JUMLAH'])
			->setCellValueByColumnAndRow(6,$r,$row['JMLDR'])
			->setCellValueByColumnAndRow(7,$r,$row['JMLCR']);
			$i++;
			$r++;	
		}

		$r = 111;
		$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_svpdh($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$r,$i)
			->setCellValueByColumnAndRow(2,$r,'Senior Vice President Divisi Hukum')
			->setCellValueByColumnAndRow(3,$r,$row['COA'])
			->setCellValueByColumnAndRow(4,$r,$row['COA_DESC'])
			->setCellValueByColumnAndRow(5,$r,$row['JUMLAH'])
			->setCellValueByColumnAndRow(6,$r,$row['JMLDR'])
			->setCellValueByColumnAndRow(7,$r,$row['JMLCR']);
			$i++;
			$r++;	
		}

		$r = 155;
		$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_svpp($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$r,$i)
			->setCellValueByColumnAndRow(2,$r,'Senior Vice President Pengelolaan Keuangan')
			->setCellValueByColumnAndRow(3,$r,$row['COA'])
			->setCellValueByColumnAndRow(4,$r,$row['COA_DESC'])
			->setCellValueByColumnAndRow(5,$r,$row['JUMLAH'])
			->setCellValueByColumnAndRow(6,$r,$row['JMLDR'])
			->setCellValueByColumnAndRow(7,$r,$row['JMLCR']);
			$i++;
			$r++;	
		}

		$r = 226;
		$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_vplk($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$r,$i)
			->setCellValueByColumnAndRow(2,$r,'Vice President Layanan Keuangan')
			->setCellValueByColumnAndRow(3,$r,$row['COA'])
			->setCellValueByColumnAndRow(4,$r,$row['COA_DESC'])
			->setCellValueByColumnAndRow(5,$r,$row['JUMLAH'])
			->setCellValueByColumnAndRow(6,$r,$row['JMLDR'])
			->setCellValueByColumnAndRow(7,$r,$row['JMLCR']);
			$i++;
			$r++;	
		}

	$vscode701 ="'0111','0112','0113','0114','0115','0116','0117','0119','0122','0123','0124','0131','0132','0133','0134','0135','0139'";
	$vscode702 ="'0211','0212','0213','0219','0221','0222','0229'";
	$vscode703 ="'0311','0312','0319','0322','0327','0327','0331','0335','0338'";
	$vscode704 ="'0401','0402','0403','0404','0405','0406','0408','0411','0412','0413','0415','0416','0420','0423','0424','0433','0433','0499'";
	$vscode705 ="'0501','0502','0503','0510','0511','0512','0513','0516','0517','0531','0533','0534','0535','0537','0538','0539',
	'0562','0563','0566','0567','0568','0572','0573','0599'";
	$vscode706 ="'0601','0602','0603','0604','0605','0610','0623','0624','0625','0699'";
	$vscode707 ="'0701','0702','0706','0711','0712','0713','0719','0731','0732','0734','0742','0751','0754','0755','0763','0799'";
	$vscode708 ="'0811','0812','0751','0799','0812','0799'";
		
		
	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70101101',$vscode701);
	  $vjml701 = 0;
	 foreach($query->result_array() as $row) {
		$vjml701 += $row['JML_URAIAN'];
	 }
	 	
	$query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70201101',$vscode702);
	$vjml702 = 0;
	 foreach($query->result_array() as $row) {
		$vjml702 += $row['JML_URAIAN'];
	 }

	 
	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70301101',$vscode703);
	 $vjml703 = 0;
	 foreach($query->result_array() as $row) {
		$vjml703 += $row['JML_URAIAN'];
	 }

	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70401101',$vscode704);
	 $vjml704 = 0;
	 foreach($query->result_array() as $row) {
		$vjml704 += $row['JML_URAIAN'];
	 }

	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70501101',$vscode705);
	 $vjml705 = 0;
	 foreach($query->result_array() as $row) {
		$vjml705 += $row['JML_URAIAN'];
	 }

	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
	 $vjml706 = 0;
	 foreach($query->result_array() as $row) {
		$vjml706 += $row['JML_URAIAN'];
	 }

	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70701101',$vscode707);
	 $vjml707 = 0;
	 foreach($query->result_array() as $row) {
		$vjml707 += $row['JML_URAIAN'];
	 }

	 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70801101',$vscode708);
	 $vjml708 = 0;
	 foreach($query->result_array() as $row) {
		$vjml708 += $row['JML_URAIAN'];
	 } 

 $vjmlneg706 = 0;
 $query	= $this->Kertas_kerja_mdl->get_kk_rek7_final($bulandari,$bulanke,$tahundari,'70601101',$vscode706);
 $vautoservcode706 = array("0601","0602","0623","0624","0625","0699");
 foreach($query->result_array() as $row) {
	/*
	if($row['KODE_AKUN'] === '70601101'){
	   $vjmlneg706 += abs($row['JML_URAIAN']);
	} else {
	   $vjmlneg706 += abs($row['AMOUNT_NEGATIF']);
	}
	*/
	$vamntneg = 0;
	if(in_array($row['KODE_JASA'], $vautoservcode706)){
		$vamntneg = $row['JML_URAIAN'];
	} else {
		$vamntneg = $row['AMOUNT_NEGATIF'];
	}
	$vjmlneg706 += $vamntneg;
 }
 
 
$vcoa791 ="'79101121','79101131'";
$vautocoa791 = array("79101121", "79101131");
 $vjmlneg791 = 0;
 $query	= $this->Kertas_kerja_mdl->get_kk_rek791($bulandari,$bulanke,$tahundari,$vcoa791,$vservcode);
 foreach($query->result_array() as $row) {
	if(in_array($row['KODE_AKUN'], $vautocoa791)) {
		$vjmlneg791 += ($row['JML_URAIAN']*-1);
	} else {	
		$vjmlneg791 += $row['AMOUNT_NEGATIF'];
	}
 }
	
	 $vgrandtotal70 = 0;
	 $vgrandtotal72 = 0;	
	 $vgrandtotalneg = 0;
	 $vgrandtotal70 = $vjml701 + $vjml702 + $vjml703 + $vjml704 + $vjml705 + $vjml706 + $vjml707 + $vjml708;
	 $vgrandtotal =  ($vgrandtotal70 < 0) ? ($vgrandtotal70*-1) : $vgrandtotal70;
     $vgrandtotalneg = abs($vjmlneg706) + abs($vjmlneg791);

	 //$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_pend_final($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E288',$vgrandtotalneg);	
		}

		//$query = $this->Kertas_kerja_mdl->getkk_beban_bersama_jml_omset($bulandari,$bulanke,$tahundari,$cabang);
		foreach($query->result_array() as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E289',$vgrandtotal);	
		}
	
		$this->getFooterXLS($fileName,$objPHPExcel,$objWriter);    
	}
	  
	function getMonthString($m){
		if($m==1){
			return "Januari";
		}else if($m==2){
			return "Februari";
		}else if($m==3){
			return "Maret";
		}else if($m==4){
			return "April";
		}else if($m==5){
			return "Mei";
		}else if($m==6){
			return "Juni";
		}else if($m==7){
			return "Juli";
		}else if($m==8){
			return "Agustus";
		}else if($m==9){
			return "September";
		}else if($m==10){
			return "Oktober";
		}else if($m==11){
			return "November";
		}else if($m==12){
			return "Desember";
		}else if($m==14){
			return "Desember";
		}
	}

}

?>