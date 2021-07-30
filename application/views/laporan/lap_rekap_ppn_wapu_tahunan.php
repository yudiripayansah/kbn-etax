<div class="container-fluid">

	<?php $this->load->view('template_top'); ?>	
	
	<div id="list-data"> 
		<div class="white-box boxshadow">
			<div class="row">	
				<div class="col-lg-2">
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="tahun" name="tahun">
							<?php
								$bln = date('m');
								/*if ($bln > 1){
									$bln 	 = $bln - 1;
									$tahun_n = 0;
								} else{
									$bln 	 = 12;
									$tahun_n = 1;
								}*/
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
				<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="0" selected >0</option> 
						<option value="1" >1</option>
						<option value="2" >2</option>
						<option value="3" >3</option>					
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
		vpembetulan	= "";
	
	$("#btnView").on("click", function(){
		var url 	="<?php echo site_url(); ?>laporan/cetak_report_ppn_wapu_thn_xls";
		vtahun		= $("#tahun").val();
		vpembetulan	= $("#pembetulanKe").val();
		var bnm		= $("#bulan").find(":selected").attr("data-name");
		var cnm		= $("#cabang").find(":selected").attr("data-name");

		window.open(url+'?tahun='+vtahun+'&pembetulanKe='+vpembetulan, '_blank');
		window.focus();
	});	
		
 });
 </script>							

