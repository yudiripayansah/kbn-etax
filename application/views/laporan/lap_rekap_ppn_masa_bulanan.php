<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>	

	<!-- <div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		  <div class="page-title"> <b><?php echo $subtitle ?></b> 
		  </div> 
		</div>
    </div> -->
	
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
							 /*if ($bln>1){
								 $bln		= $bln - 1;
								 $tahun_n	= 0;
							 } else {
								 $bln		= 12;
								 $tahun_n	= 1;
							 }*/
							 for ($i=1;$i< count($namaBulan);$i++){
								 $selected	= ($i==$bln)?"selected":"";
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
					<label>Pembetulan Ke</label>
						<select class="form-control" id="pembetulanKe" name="pembetulanKe">
							<option value="0" selected >0</option> 
							<option value="1">1</option> 
							<option value="2" >2</option>
							<option value="3" >3</option>					
						</select>
					</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnCetak" class="btn btn-info btn-rounded custom-input-width btn-block" type="button" > 
						<span>Print</span></button>
					</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" > 
						<span>View</span></button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="panel-group boxshadow">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="row">
							  <div class="col-sm-6">
								FORM INPUT NTPN
							  </div>
							  <div class="col-sm-6">
							  	<div class="navbar-right">
							  		<button type="button" id="btnAdd" class="btn btn-rounded btn-default custom-input-width" ><i class="fa fa-plus"></i> ADD</button>
							  		<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
							  		<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-trash"></i> DELETE</button>
								</div>
							  </div>
							</div>
						</div>				
						<div id="collapse-data" class="panel-collapse collapse in">
							<div class="panel-body"> 
								<div class="table-responsive">
									<table width="100%" class="display cell-border stripe hover small" id="tabledata">
				                        <thead>
				                            <tr>
												<th>ID</th>
				                            	<th>NO</th>
												<th>PEMBETULAN</th>
												<th>BULAN</th>
												<th>BULAN</th>
												<th>TAHUN</th>
												<th>NTPN</th>
												<th>BANK</th>
												<th>TANGGAL SETOR</th>
												<th>TANGGAL LAPOR</th>
				                            </tr>
				                        </thead>
				                    </table>
				                </div>
							</div>
						</div>
					</div>						
				</div>
	        </div>
	    </div>
	</div>

<div id="tambah-data">	
	<form role="form" id="form-wp" data-toggle="validator">
		<div class="white-box boxshadow">
		  	<div class="row">
				<div class="col-lg-12 align-center">
					<h2 id="capAdd" class="text-center">EDIT DATA</h2>
				</div>			
			</div>
			<div class="row">
				<hr>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<input type="hidden" class="form-control" id="isnewRecord" name="isnewRecord" value="1">
						<input type="hidden" class="form-control" id="id" name="id">
						<label for="ntpn" class="control-label">NTPN</label>
						<label>Bulan</label>
						<select class="form-control" id="bulan_pajak" name="bulan_pajak">
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
								 $selected	= ($i==$bln)?"selected":"";
								 echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
							 }
						?>						
						</select> 
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="tahun_pajak" name="tahun_pajak">
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
				<div class="col-md-6">
					<div class="form-group">
					<label>Pembetulan Ke</label>
						<select class="form-control" id="pembetulan_pajak" name="pembetulan_pajak">
							<option value="0" selected >0</option> 
							<option value="1">1</option> 
							<option value="2" >2</option>
							<option value="3" >3</option>					
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="ntpn" class="control-label">NTPN</label>
						<input type="text" class="form-control" id="ntpn" name="ntpn" placeholder="NTPN" data-toggle="validator" data-error="Harap isi NTPN 16 digit!" maxlength="16" minlength="16" required >
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					<label>BANK</label>
						<select class="form-control" id="bank" name="bank">
							<option value="BNI" selected >BNI</option> 
							<option value="MANDIRI">MANDIRI</option> 
							<option value="BRI" >BRI</option>
							<option value="BCA" >BCA</option>	
							<option value="CIMB Niaga" >CIMB Niaga</option>				
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggal_setor" class="control-label">TANGGAL Setor</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggal_setor" name="tanggal_setor" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggal_lapor" class="control-label">TANGGAL LAPOR</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggal_lapor" name="tanggal_lapor" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="navbar-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> RESET</button>
					<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> CANCEL</button>
					<button type="submit" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>
	
<script>
$(document).ready(function() {
	var table             = "",
		vcabang           = "",
		vbulan            = "",
		vtahun            = "",
		vpembetulanKe     = "",
		val_id            = "",
		val_tanggal_setor = "",
		val_ntpn          = "",
		val_bank          = "",
		val_tanggal_lapor = "";
		$("#tambah-data").hide();
					
	Pace.track(function(){ 
	   $('#tabledata').DataTable({			
		"serverSide"	: true,
		"processing"	: true,
		"ajax"			: {
							 "url"  		: baseURL + 'ppn_masa/load_ntpn',
							 "type" 		: "POST",								
							 "data"			: function ( d ) {
									d._searchBulan      = $('#bulan').val();
									d._searchTahun      = $('#tahun').val();
									d._searchPembetulan = $('#pembetulanKe').val();
								}
							},
		 "language"		: {
				"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
				"infoEmpty"		: "Data Kosong",
				"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},
		   "columns": [
				{ "data": "id"},
				{ "data": "no", "class":"text-center", "width":"50px" },
				{ "data": "pembetulan" },
				{ "data": "bulan", "width":"200px"},
				{ "data": "nama_bulan", "width":"200px"},
				{ "data": "tahun", "width":"250px"},
				{ "data": "ntpn", "width":"250px"},
				{ "data": "bank", "width":"250px"},
				{ "data": "tanggal_setor"},
				{ "data": "tanggal_lapor" }
			],
			"columnDefs": [
				{
					"targets": [ 0, 2,3],
					"visible": false
				}
			],	
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "bAutoWidth" : false	
		});
	 });
	 
	table = $('#tabledata').DataTable();

	$("#list-data input[type=search]").addClear();
	$('#list-data #tabledata .dataTables_filter input[type="search"]').attr('placeholder','Cari NTPN...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
	$("#tabledata_filter .add-clear-x").on('click',function(){
		table.search('').column().search('').draw();
	});

/*	table.on( 'draw', function () {
		
		$("#btnEdit").attr("disabled",true);
		$("#btnDelete").attr("disabled",true);

	});*/

	$('#tabledata tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
			empty();
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d             = table.row( this ).data();
			val_id            = d.id;
			val_tanggal_setor = d.tanggal_setor;
			val_ntpn          = d.ntpn;
			val_bank          = d.bank;
			val_tanggal_lapor = d.tanggal_lapor;
			val_bulan_pajak   = d.bulan;
			val_tahun_pajak   = d.tahun;
			val_pebetulan   = d.pembetulan;
			$("#btnEdit").removeAttr('disabled');
			$("#btnDelete").removeAttr('disabled');
			valueGrid();
		}

	} ).on("dblclick", "tr", function () {
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
		var d             = table.row( this ).data();
		val_id            = d.id;
		val_tanggal_setor = d.tanggal_setor;
		val_ntpn          = d.ntpn;
		val_bank          = d.bank;
		val_tanggal_lapor = d.tanggal_lapor;
		val_bulan_pajak   = d.bulan;
		val_tahun_pajak   = d.tahun;
		val_pebetulan     = d.pembetulan;
		valueGrid();
		
		$("#btnEdit").removeAttr('disabled');
		$("#capAdd").html("<span class='label label-danger'>Edit Data</span>");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
	});

	$("#btnAdd, #btnEdit").click(function (){
		btn = $(this).attr('id');
		if(btn == "btnAdd"){
			empty();
			$("#isnewRecord").val('1');
			$("#capAdd").html("<span class='label label-danger'>Tambah Data</span>");
		}
		else{
			$("#isnewRecord").val('0');
			$("#capAdd").html("<span class='label label-danger'>Edit Data</span>");
		}
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
	});

	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empty();
	});

	function valueGrid()
	{
		$("#id").val(val_id);
		$("#isnewRecord").val('0');
		$("#ntpn").val(val_ntpn);
		$("#bank").val(val_bank);
		$("#tanggal_lapor").val(val_tanggal_lapor);
		$("#tanggal_setor").val(val_tanggal_setor);
		$("#bulan_pajak").val(val_bulan_pajak);
		$("#tahun_pajak").val(val_tahun_pajak);
		$("#pembetulan_pajak").val(val_pebetulan);
	}


	function empty()
	{
		vcabang           = "";
		val_id            = "";
		val_tanggal_setor = "";
		val_ntpn          = "";
		val_bank          = "";
		val_tanggal_lapor = "";
		
		$("#id").val("");
		$("#ntpn").val("");
		/*$("#bank").val("");*/
		$("#tanggal_lapor").val("");
		$("#tanggal_setor").val("");

		table.$('tr.selected').removeClass('selected');
		$('.DTFC_Cloned tr.selected').removeClass('selected');
		$("#btnEdit").attr("disabled",true);
		$("#btnDelete").attr("disabled",true);
	}

	$('#form-wp').validator().on('submit', function(e) {
	  if (e.isDefaultPrevented()) {
	  	console.log('tidak valid');
	  }
	  else {
	  	 $.ajax({
			url		: baseURL + 'ppn_masa/save_ntpn',
			type	: "POST",
			data	: $('#form-wp').serialize(),
			beforeSend	: function(){
				 $("body").addClass("loading");
				 },
			success	: function(result){
				console.log(result);
				if (result== '1') {
					 table.draw();
					 $("body").removeClass("loading");
					 $("#list-data").slideDown(700);
					 $("#tambah-data").slideUp(700);
					 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
					 empty();
				} else if (result == '2'){
					 $("body").removeClass("loading");
					 flashnotif('Error', 'Data NTPN sudah ada','error' );
				} else {
					 $("body").removeClass("loading");
					 flashnotif('Error', 'Gagal Disimpan','error' );
				}
			}
		});
	  }
	  e.preventDefault();
	});

	$("#btnDelete").click(function(){
		  bootbox.confirm({
			title: "Hapus data ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> YES'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: baseURL + 'ppn_masa/delete_ntpn',
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								$("body").removeClass("loading");
								table.draw();
								empty();
								flashnotif('Sukses','Data Berhasil di Hapus!','success' );	
							} else {
								 $("body").removeClass("loading");
								 flashnotif('Error','Data Gagal di Hapus!','error' );
							}
						}
					});	
				}
			}
		});				
	});
	
	$("#btnCetak").on("click", function(){
		var url 		="<?php echo site_url(); ?>laporan/cetak_report_ppn_masa_bln";
		vtahun			= $("#tahun").val();
		vbulan			= $("#bulan").val();
		vpembetulanKe	= $("#pembetulanKe").val();
		var bnm			= $("#bulan").find(":selected").attr("data-name");

		window.open(url+'?tahun='+vtahun+'&bulan='+vbulan+'&namabulan='+bnm+'&pembetulanKe='+vpembetulanKe, '_blank');
		window.focus();
	});

	$("#btnView").on("click", function(){			
		table.ajax.reload();
	});
		
 });
 </script>							

