<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>
	
	<div id="list-data"> 
		<div class="white-box boxshadow">	
			<div class="row">
				<div class="col-lg-2">
					<div class="form-group">
						<label>Cabang</label>
						<select id="kd_cabang" name="kd_cabang" class="form-control" autocomplete="off">
							<?php if($this->session->userdata('kd_cabang') != "000"){ ?>
							<option value="<?php echo $this->session->userdata('kd_cabang') ?>"><?php echo get_nama_cabang($this->session->userdata('kd_cabang')) ?></option>
							<?php
							}
							else{
								$list_cabang  = $this->cabang_mdl->get_all();
								echo '<option value="all"> Semua Cabang </option>';
								foreach ($list_cabang as $cabang):
									?>
							<option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
							<?php endforeach; }?>
						</select>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label>From</label>
						<select class="form-control" id="bulandari" name="bulandari">
							<?php
									$namaBulan = list_month();
									$bln = date('m');
									for ($i=1;$i< count($namaBulan);$i++){
									$selected = ($i==$bln)?"selected":"";
										echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
									}
							?>
						</select> 
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="tahundari" name="tahundari">
							<?php 
								$tahun  = date('Y');
								$tAwal  = $tahun - 5;
								$tAkhir = $tahun;
								for($i=$tAwal; $i<=$tAkhir;$i++){
									$selected	= ($i==$tahun)?"selected":"";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							?>
						</select> 
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label>To</label>
						<select class="form-control" id="bulanke" name="bulanke">
							<option value="" data-name="" >Semua Bulan</option>
							<?php
								 $namaBulan = list_month();
								 $bln = date('m');
								 for ($i=1;$i< count($namaBulan);$i++){
								 	$selected = ($i==$bln)?"selected":"";
								 	echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
								 }
							?>
						</select> 
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="tahunke" name="tahunke">
							<?php 
								$tahun  = date('Y');
								$tAwal  = $tahun - 5;
								$tAkhir = $tahun;
								for($i=$tAwal; $i<=$tAkhir;$i++){
									$selected	= ($i==$tahun)?"selected":"";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							?>
						</select> 
					</div>
				</div>
				 <div class="col-lg-2">
					<div class="form-group">
						<label>Jenis Kertas Kerja</label>
						<select class="form-control" id="jenisKertaskerja" name="jenisKertaskerja">
							<option value="final" data-name="" >Kertas Kerja Final</option>
							<option value="pajakkini" data-name="" >Perhitungan Pajak Kini</option>
							<option value="kerjatangguhan" data-name="" >Kerja Tangguhan</option>
							<option value="mappinggltosptpph" data-name="" >Mapping GL to SPT PPh Badan</option>
							<option value="pajakkinitangguhan" data-name="" >Pajak Kini dan Tangguhan</option>
							<option value="bebanbonus" data-name="" >Beban Bonus</option>
							<option value="bebantantiem" data-name="" >Beban Tantiem</option>
							<option value="uangsakudinas" data-name="" >Uang Saku Perjalanan Dinas dan Diklat</option>
							<option value="bebanobligasi" data-name="" >Beban Bunga Obligasi</option>
							<option value="penyisihanpiutang" data-name="" >Penyisihan Piutang</option>
							<option value="rekapaset" data-name="" >Rekapitulasi Penyusutan dan Amortisasi Aset</option>
							<option value="biayalain" data-name="" >Biaya Lain</option>
							<option value="bebanbersama" data-name="" >Rincian Beban Bersama</option>
						</select> 
					</div>
			 	</div>

				 <div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnPrint" class="btn btn-info btn-rounded custom-input-width btn-block" type="button" > 
						<i class="fa fa-file-excel-o"></i> PRINT</button>
					</div>
				 </div>	
			</div>
		</div>
	</div>
</div>
	
<script>
$(document).ready(function() {
	var vcabang	= "",
		vbulan	= "",
		vtahun	= "";
		intblndari = 0;
		intblnke = 0;

	$("#btnPrint").on("click", function(){
		var url 		="<?php echo site_url(); ?>Cetak_kartu_kerja/cetak_kartu_kerja_xls";
		var vjeniskk	= $("#jenisKertaskerja").val();
		var vnmjnskk	= $("#jenisKertaskerja").find(":selected").attr("data-name");
		vbulandari		= $("#bulandari").val();
		vbulanke		= $("#bulanke").val();
		vtahundari		= $("#tahundari").val();
		vtahunke		= $("#tahunke").val();
		vcabang			= $("#kd_cabang").val();
		var bnm			= $("#bulanke").find(":selected").attr("data-name");
		var cnm			= $("#cabang").find(":selected").attr("data-name");
		
		intblndari = parseInt(vbulandari);
		intblnke = parseInt(vbulanke);
		if(intblndari > intblnke){
			alert('Bulan to harus lebih besar dari bulan from');
			exit();
		}

		if (bnm === 'Desember'){
			vbulanke = 14;
		}

		window.open(url+'?kd_cabang='+vcabang+'&bulandari='+vbulandari+'&tahundari='+vtahundari+'&bulanke='+vbulanke+'&tahunke='+vtahunke+'&namabulan='+bnm+'&jeniskk='+vjeniskk+'&nmjeniskk='+vnmjnskk, '_blank');
		window.focus();
	});	
		
 });
 </script>							

