<div class="container-fluid">

	<?php $this->load->view('template_top'); ?>	
	
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
						<select class="form-control" id="bulan_from" name="bulan_from">
						<?php
							 $namaBulan = list_month();
							 $bln = date('m');
							 /*if ($bln>1){
								 $bln		= $bln - 1;
								 $tahun_n	= 0;
							 } else {
								 $bln		= 12;
								 $tahun_n	= 1;
							 }*/
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
						<label>To</label>
						<select class="form-control" id="bulan_to" name="bulan_to">
						<?php
							 $namaBulan = list_month();
							 $bln = date('m');
							 /*if ($bln>1){
								 $bln		= $bln - 1;
								 $tahun_n	= 0;
							 } else {
								 $bln		= 12;
								 $tahun_n	= 1;
							 }*/
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
						<select class="form-control" id="tahun" name="tahun">
							<?php 
								$tahun	= date('Y');
								$tAwal	= $tahun - 5;	
								$tAkhir	= $tahun;	
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
					<label>&nbsp;</label>
						<button id="btnView" class="btn btn-info btn-rounded custom-input-width btn-block" type="button" > 
						<span>Print</span></button>
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
	
	$("#btnView").on("click", function(){
		var url 	="<?php echo site_url(); ?>laporan/cetak_equal_ppn_masa_bulanan";
		vcabang		= $("#kd_cabang").val();
		vbulanfrom		= $("#bulan_from").val();
		vbulanto		= $("#bulan_to").val();
		vtahun		= $("#tahun").val();
		var bnm		= $("#bulan").find(":selected").attr("data-name");

		window.open(url+'?cabang='+vcabang+'&tahun='+vtahun+'&bulanfrom='+vbulanfrom+'&bulanto='+vbulanto, '_blank');
		window.focus();
	});	
		
 });
 </script>							

