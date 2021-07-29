<form role="form" id="form-tx-tambah">
		<div class="white-box boxshadow">
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">TAMBAH DATA</h2>
			</div>			
		</div>		
		<div class="row">
			<hr>
		</div>
			<div class="row">
			 <div class="col-lg-6">
				<div id="derror1" class="form-group">
					<label>OPERATING UNIT *</label>
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<input type="hidden" class="form-control" id="kode_cabang" name="kode_cabang">
					<input type="hidden" class="form-control" id="tax_code_h" name="tax_code_h">
					<select class="form-control" id="operating_unit" name="operating_unit">
					</select>
					<div id="error1"></div>
				</div>
			 </div>
			  <div class="col-lg-6">
				  <div id="derror2" class="form-group">
					<label>TAX CODE *</label>
					<input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="Tax Code * (Tidak Boleh Kosong)">
					<div id="error2"></div>
				  </div>
			  </div>
			</div>
			
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>DESCRIPTION</label>
					<input type="text" class="form-control" id="description" name="description" placeholder=" DESCRIPTION ">
				</div>
			  </div>
			  <div class="col-lg-6">
				<div id="derror3" class="form-group">
					<label>TAX RATE *</label>
					<input type="text" class="form-control" id="tax_rate" name="tax_rate" placeholder="TAX RATE  * (Number) ">
					<div id="error3"></div>
				</div>
			  </div>
			</div>
			
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>ENABLED</label>
					<select class="form-control" id="enabled" name="enabled">
						<option value="Y" selected >Yes</option> 
						<option value="N">No</option>										
					</select>
				</div>
			  </div>
				<div class="col-lg-6">
				<div class="form-group">
					<label>VENDOR NAME</label>
					<input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="VENDOR NAME">
				</div>
			  </div>	
			</div>	
				
			<div class="row">
			  <div class="col-lg-6">	
				<div id="derror5" class="form-group">
					<label>VENDOR NUMBER *</label>
					<input type="text" class="form-control" id="vendor_number" name="vendor_number" placeholder="VENDOR NUMBER">
					<div id="error5"></div>
				</div>
			  </div>
			  <div class="col-lg-6">
				<div id="derror6" class="form-group">
					<label>VENDOR SITE CODE *</label>
					<input type="text" class="form-control" id="vendor_site_code" name="vendor_site_code" maxlength="15" placeholder="VENDOR SITE CODE">
					<div id="error6"></div>
				</div>
			  </div>	
			</div>	
				
			<div class="row">
			  <div class="col-lg-6">	
				<div id="derror4" class="form-group">
					<label>KODE PAJAK *</label>
					<select class="form-control" id="kode_pajak" name="kode_pajak">															
					</select>
					<div id="error4"></div>
				</div>
			  </div>	
				<div class="col-lg-6">
				<div class="form-group">
					<label>JENIS 4 AYAT 2</label>
					<input type="text" class="form-control" id="jenis_4_ayat_2" name="jenis_4_ayat_2" placeholder="JENIS 4 AYAT 2">
				</div>
			   </div>
			</div>	
				
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>KODE PAJAK SPPD</label>
					<input type="text" class="form-control" id="kode_pajak_sppd" name="kode_pajak_sppd" placeholder="KODE PAJAK SPPD">
				</div>
			  </div> 	
				<div class="col-lg-6">
				<div class="form-group">
					<label>JENIS 23</label>
					<input type="text" class="form-control" id="jenis_23" name="jenis_23" placeholder="JENIS 23">
				</div>
			  </div>
			</div>	
			
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>AKUN PAJAK</label>
					<input type="text" class="form-control" id="akun_pajak" name="akun_pajak" placeholder="AKUN PAJAK">
				</div>
			  </DIV>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>GL ACCOUNT</label>
					<input type="text" class="form-control" id="gl_account" name="gl_account" placeholder="GL ACCOUNT">
				</div>
			  </div>
			</div>	
				
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>COMPANY</label>
					<input type="text" class="form-control" id="company" name="company" placeholder="COMPANY">
				</div>
			  </div>	
			  <div class="col-lg-6">
				<div id="derror7" class="form-group">
					<label>CABANG *</label>
					<select class="form-control" id="branch" name="branch">
					</select>
					<div id="error7"></div>
				</div>
			  </div>
			</div>	
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>ACCOUNT</label>
					<input type="text" class="form-control" id="account" name="account" placeholder="ACCOUNT">
				</div>				
			  </div>				
			</div>					
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> RESET</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
						  </div>
					 </div>
				</div>
			</div>
			
		  </div>
		</form>
		
<script>
$(document).ready(function() {
	$("#tax_rate").number(true,2);
	
	/* $("#operating_unit").on("change", function(){
			var x=$(this).val();
			$("#branch").val(x);			
	});
	
	$("#branch").on("change", function(){
			var x=$(this).val();
			$("#operating_unit").val(x);			
	}); */
})
</script>