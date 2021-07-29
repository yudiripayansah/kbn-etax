<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		  <div class="page-title"> <b><?php echo $subtitle ?></b> 
		  </div> 
		</div>
    </div>
	
	<div id="list-data"> 
		<div class="white-box boxshadow">	
			<div class="row">	
				<div class="col-lg-2">
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="bulan" name="bulan">
							<option value="" data-name="" >Semua Bulan</option>
							<option value="1" data-name="Januari" >Januari</option>
							<option value="2" data-name="Februari" >Februari</option>
							<option value="3" data-name="Maret" >Maret</option>
							<option value="4" data-name="April" >April</option>
							<option value="5" data-name="Mei" >Mei</option>
							<option value="6" data-name="Juni" >Juni</option>
							<option value="7" data-name="Juli" >Juli</option>
							<option value="8" data-name="Agustus" >Agustus</option>
							<option value="9" data-name="September" >September</option>
							<option value="10" data-name="Oktober" >Oktober</option>
							<option value="11" data-name="November" >November</option>
							<option value="12" data-name="Desember" >Desember</option>
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
									 
			</div>
			<div class="row">
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
					var url 	="<?php echo site_url(); ?>pph_badan/cetak_kertas_kerja_pdf";
				} else {
					var url 	="<?php echo site_url(); ?>pph_badan/cetak_kertas_kerja";	
				} 
				window.open(url+'?tahun='+vtahun+'&bulan='+vbulan, '_blank');
				window.focus();				  
			}
		});	
						
	}
		
 });
 </script>							

