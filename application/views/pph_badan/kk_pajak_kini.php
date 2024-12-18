<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>
	
	<div id="list-data"> 
		<div class="white-box boxshadow">	
			<div class="row">	
				<div class="col-lg-2">
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="bulan" name="bulan">
							<option value="" data-name="" >Semua Bulan</option>
							<?php
								 $namaBulan = list_month();
								 $bln = date('m');
								 /*if ($bln>1){
								 	$bln     = $bln-1;
								 	$tahun_n = 0;
								 } else {
								 	$bln     = 12;
								 	$tahun_n = 1;
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
					<label>&nbsp;</label>
						<button id="btnView" class="btn btn-info btn-rounded custom-input-width btn-block" type="button" > 
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
	
	$("#btnView").on("click", function(){
		cek_period();
	});	
	
	function cek_period()
	{
		vtahun		= $("#tahun").val();
		vbulan		= $("#bulan").val();
		$.ajax({
			url		: "<?php echo site_url('pph_badan/get_period') ?>",
			type	: "POST",
			dataType: "json", 
			data	: ({bulan:vbulan,tahun:vtahun}),
			beforeSend	: function(){
					$("body").addClass("loading");
				 },
			success	: function(result){
				$("body").removeClass("loading");
				if (result=='PDF'){						
					var url 	="<?php echo site_url(); ?>pph_badan/cetak_kk_pajak_kini_pdf";
				} else {
					var url 	="<?php echo site_url(); ?>pph_badan/cetak_kk_pajak_kini";	
				} 
				window.open(url+'?tahun='+vtahun+'&bulan='+vbulan, '_blank');
				window.focus();				  
			}
		});	
						
	}
		
 });
 </script>							

