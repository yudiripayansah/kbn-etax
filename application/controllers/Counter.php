<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counter extends CI_Controller {

	public function index($kode_cabang = "000", $tahun = "2017")
	{
		$q = $this->db->query("SELECT * FROM SIMTAX_KODE_CABANG WHERE AKTIF = 'Y' AND KODE_CABANG = '".$kode_cabang."'");
		$r = $q->result();
		$numrow = $q->num_rows();

		if($numrow > 0){

			$j=1;
			foreach ($r as $key => $value) {
			   if($j==1){
					for ($i=1; $i <=12 ; $i++) { 
						echo "Insert into SIMTAX.SIMTAX_MASTER_COUNTER
									 <br> (NAMA_COUNTER, KODE_CABANG, BULAN, TAHUN, COUNTER, NAMA_CABANG, NAMA_PAJAK, KODE_PAJAK)  <br>
								 Values <br> ('BUKTI POTONG', '".$value->KODE_CABANG."', ".$i.", ".$tahun.", 1, '".$value->KODE_LOKASI."', 'PPH PSL 4 AYAT 2', 'PPh4');<br>
								Insert into SIMTAX.SIMTAX_MASTER_COUNTER
									 <br> (NAMA_COUNTER, KODE_CABANG, BULAN, TAHUN, COUNTER, NAMA_CABANG, NAMA_PAJAK, KODE_PAJAK)  <br>
								 Values <br> ('BUKTI POTONG', '".$value->KODE_CABANG."', ".$i.", ".$tahun.", 1, '".$value->KODE_LOKASI."', 'PPH PSL 15', 'PPh15');<br>
								Insert into SIMTAX.SIMTAX_MASTER_COUNTER
									 <br> (NAMA_COUNTER, KODE_CABANG, BULAN, TAHUN, COUNTER, NAMA_CABANG, NAMA_PAJAK, KODE_PAJAK)  <br>
								 Values <br> ('BUKTI POTONG', '".$value->KODE_CABANG."', ".$i.", ".$tahun.", 4, '".$value->KODE_LOKASI."', 'PPH PSL 23 DAN 26', 'PPh23/26');<br>
								Insert into SIMTAX.SIMTAX_MASTER_COUNTER
									 <br> (NAMA_COUNTER, KODE_CABANG, BULAN, TAHUN, COUNTER, NAMA_CABANG, NAMA_PAJAK, KODE_PAJAK)  <br>
								 Values <br> ('BUKTI POTONG', '".$value->KODE_CABANG."', ".$i.", ".$tahun.", 1, '".$value->KODE_LOKASI."', 'PPH PSL 22', 'PPh22');<br>";
					}
				}
				$j++;
			}
		}
		else {
			echo 'gak ada';
		}
	}

}

/* End of file Counter.php */
/* Location: ./application/controllers/Counter.php */