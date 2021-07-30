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
						<?php
							 $namaBulan = list_month();
							 $bln = date('m');
							 if ($bln>1){
								 $bln		= $bln - 1;
								 $tahun_n	= 0;
							 } else {
								 $bln		= 12;
								 $tahun_n	= 1;
							 }
							 for ($i=1;$i< count($namaBulan);$i++){
								 $selected	= "";
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
				 <div class="col-lg-3">
					<div class="form-group">
						<label>Cabang</label>
						<select class="form-control" id="cabang" name="cabang">
							<?php
								
								$sql		="select * from simtax_kode_cabang where AKTIF = 'Y'";
								$query = $this->db->query($sql);
								
								foreach($query->result_array() as $row)	{
									
									$kode_cabang	= $row['KODE_CABANG'];
									$nama_cabang	= $row['NAMA_CABANG'];
									echo "<option value='".$kode_cabang."' data-name='".$nama_cabang."'>".$nama_cabang."</option>";

								}							
								$query->free_result();
							?>						
						</select> 
					</div>
				 </div>					 
			</div>
			<div class="row">
				 <div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" > 
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
		var url 	="<?php echo site_url(); ?>laporan/cetak_equal_pph23_xls";
		vcabang		= $("#cabang").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		var bnm		= $("#bulan").find(":selected").attr("data-name");
		var cnm		= $("#cabang").find(":selected").attr("data-name");

		window.open(url+'?cabang='+vcabang+'&bulan='+vbulan+'&tahun='+vtahun+'&namabulan='+bnm+'&namacabang='+cnm, '_blank');
		window.focus();
	});	
		
 });
 </script>							

