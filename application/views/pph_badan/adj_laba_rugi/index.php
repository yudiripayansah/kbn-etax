<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		  <div class="page-title"> <b><?php echo $subtitle ?></b> <span class="label label-danger"><?php echo $nama_cabang->NAMA_CABANG; ?></span></div> 
		</div>
    </div>
	
	 <div id="list-data">
		<div class="row"> 
				<div class="col-lg-2">
					<div class="form-group">
						<label>Tahun Pajak</label>
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
						<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Tampil</span></button>
					</div>
				</div>
		</div>		 
		<div class="row"> 	
			<div class="col-lg-12">	
				<div class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">
						<div class="row">
						  <div class="col-lg-6">
							Rekapitulasi Rincian Beban Lain Gabungan
						  </div>
						  <div class="col-lg-6">							    
							<div class="navbar-right">								 
								<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> Tambah</button>
								<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
								<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> HAPUS</button>
							</div>
						  </div>
						</div>  						   
					</div>
				   
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
							<thead>
								<tr>
									<th>NO</th>
									<th>Account</th>									
									<th>Description</th>                                                                               
									<th>Amount</th>
									<th>Is Deductible</th>
									<th>Koreksi Deductible</th>										 
									<th>Koreksi Non-Deductible</th>																	
								</tr>
							</thead>
						</table>
						</div>                            
				   </div>				
				</div>
			</div>
		</div>
	</div>	
	
<!-------------------------------------->		
<div id="tambah-data">	
	<form role="form" id="form-wp">	
	<div class="white-box boxshadow">
	 	
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">Tambah Data</h2>
			</div>
		</div>
		
		<div class="row">
			<hr>
		</div>
		<div class="row">		
			<div class="col-lg-6 ">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="inpTahun" name="inpTahun">
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
			<div class="col-lg-6 ">
				<div class="form-group">
					<label>Account</label>
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<input type="hidden" class="form-control" id="DocId" name="DocId">
					<div class="input-group">
						<input class="form-control" id="inpAccount" name="inpAccount" placeholder="Account" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getAccount" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-Account" ><i class="fa fa-search"></i></button>
						</span> 
					</div>
					
				</div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>Description</label>
					<input class="form-control" id="inpDescription" name="inpDescription" placeholder="Description" type="text" maxlength="240" readonly>
				</div>	
			 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Amount</label>
					<input class="form-control" id="inpAmount" name="inpAmount" placeholder="Amount" type="text" maxlength="30">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Is Deductible</label>
					<select class="form-control" id="inpIsDeductible" name="inpIsDeductible">
						<option value="0" >No</option>						
						<option value="1" >Yes</option>
					</select> 				
				</div>
			</div>		 
		</div>	
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Koreksi Deductible</label>
					<input class="form-control" id="inpDeductible" name="inpDeductible" placeholder="Koreksi Deductible" type="text" maxlength="30">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Koreksi Non-Deductible</label>
					<input class="form-control" id="inpNonDeductible" name="inpNonDeductible" placeholder="Koreksi Non-Deductible" type="text" maxlength="30">				
				</div>
			</div>		 
		</div>			
		
		<div class="white-box boxshadow">			
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> Kembali</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
						  </div>
					 </div>
				</div>
			</div>
		</div>
	</div>	
	</form>	
</div>
<!---end tambah data----------------------------------->

<!-- LOV Region : Account-->
<div id="modal-Account" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Daftar Account</h4> </div>
			<div class="modal-body">
				<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small animated slideInDown" id="tabledata-namapajak"> 
						<thead>
							<tr>
								<th>No</th>
								<th>Account</th>
								<th>Description</th>								
							</tr>
						</thead>
					</table>
				</div>  
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  Batal</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice" disabled ><i class="fa fa-plus-circle"></i> Pilih</button>
			</div>
		</div>	
	</div>
</div>
<!-- end LOV Region : Account-->		
</div>
	
<script>
$(document).ready(function() {
	var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vtahun="",vidx="";

	$("#tambah-data").hide();

	Pace.track(	function(){		
	$('#tabledata').DataTable({
		"serverSide"	: true,
		"processing"	: true,
		"pageLength"		: 100,
		"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
		"ajax"			: {
							 "url"  		: "<?php echo site_url('pph_badan/load_beban_lain'); ?>",
							 "type" 		: "POST",
							 "data"	: function ( d ) {
										d._searchTahun 	= $('#tahun').val();
									},									
						  },
		 "language"		: {
				"emptyTable"	: "Data Tidak Ditemukan!",	
				"infoEmpty"		: "Data Kosong",
				"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},			 
		   "columns": [
				{ "data": "no", "class":"text-center" },
				{ "data": "kode_akun", "class":"text-left"},					
				{ "data": "akun_desc"},					
				{ "data": "amount"},
				{ "data": "isdeductible"},
				{ "data": "deductible"},					
				{ "data": "nondeductible"},
				{ "data": "beban_lain_id"},
				{ "data": "tahun_pajak"}
			],			
		"columnDefs": [ 
			 {
				"targets": [ 7, 8 ],
				"visible": false					
			}
		],			
		"fixedColumns"		: false,			
		 "select"			: true,
		 "scrollY"			: 360, 
		 "scrollCollapse"	: true, 
		 "scrollX"			: true,
		 "ordering"			: false			
		});		
	});
	
	table = $('#tabledata').DataTable();	
			
	$("input[type=search]").addClear();
	$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Account / Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#tabledata_filter .add-clear-x").on('click',function(){
		table.search('').column().search('').draw();			
	});

	$('#tabledata tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
			$("#btnEdit").attr("disabled",true);
			$("#btnDelete").attr("disabled",true);
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');	
			$("#btnEdit").removeAttr('disabled');
			$("#btnDelete").removeAttr('disabled');
			var d			= table.row( this ).data();
			$("#DocId").val(d.beban_lain_id);
			$("#inpAccount").val(d.kode_akun);
			$("#inpDescription").val(d.akun_desc);
			$("#inpAmount").val(d.amount);
			$("#inpDeductible").val(d.deductible);
			$("#inpIsDeductible").val(d.isdeductible);
			$("#inpNonDeductible").val(d.nondeductible);	
			$("#inpTahun").val(d.tahun_pajak);			
			}								 
	} ).on("dblclick", "tr", function () {
		console.log("2-"+vidx);
	} );
	
	$("#btnView").click(function (){
		table.ajax.reload();		
	});	
	

// call LOV page utk Account
	$("#getAccount").on("click", function(){
			vAkun	        = "";							
			vAkunDesc       = "";
			$("#btnChoice").attr("disabled",true);
			
			if ( ! $.fn.DataTable.isDataTable( '#tabledata-namapajak' ) ) {
				$('#tabledata-namapajak').DataTable({
					"serverSide"	: true,
					"processing"	: true,
					"ajax"			: {
										 "url"  		: "<?php echo site_url('pph_badan/load_lov_acc_beban_tujdel'); ?>",
										 "type" 		: "POST"
									  },
					 "language"		: {
							"emptyTable"	: "Data Tidak Ditemukan!",	
							"infoEmpty"		: "Data Kosong",
							"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
							"search"		: "_INPUT_"
						},
					   "columns": [
							{ "data": "no", "class":"text-center" },
							{ "data": "akun" },
							{ "data": "akun_desc" },
						],
					"columnDefs": [ 
						 {
							"targets": [ ],
							"visible": false
						} 
					],			
					 "select"			: true,
					 "scrollY"			: 360, 
					 "scrollCollapse"	: true, 
					 "scrollX"			: true,
					 "ordering"			: false			
				});	
				
				table_wp = $('#tabledata-namapajak').DataTable();
				
				$("#modal-Account input[type=search]").addClear();		
				$('#modal-Account .dataTables_filter input[type="search"]').attr('placeholder','Cari Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
				$("#tabledata-namapajak_filter .add-clear-x").on('click',function(){
					table_wp.search('').column().search('').draw();			
				});
									
				$('#tabledata-namapajak tbody').on( 'click', 'tr', function () {			
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						$("#btnChoice").attr("disabled",true);
						vAkun	        = "";							
						vAkunDesc       = "";
					} else {
						table_wp.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						var d			= table_wp.row( this ).data();
						vAkun	        = d.akun;							
						vAkunDesc       = d.akun_desc;
						$("#btnChoice").removeAttr('disabled'); 
					}								 
				} ).on("dblclick", "tr", function () {
					table_wp.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d		= table_wp.row( this ).data();
					vAkun	        = d.akun;							
					vAkunDesc       = d.akun_desc;
					valueGridwp();		
					$("#btnChoice").removeAttr('disabled'); 		
				} ) ;	
				
				
			} else {
				table_wp.$('tr.selected').removeClass('selected');
			}			


		
	});

		$("#btnChoice").on("click",valueGridwp);
		$("#btnCancel").on("click",batal);	
		
		function valueGridwp()
		{
			$("#inpAccount").val(vAkun);
			$("#inpDescription").val(vAkunDesc);
			$("#modal-Account").modal("hide");
		}	

		function batal()
		{
			vAkun	        = "";							
			vAkunDesc       = "";
		}	
		
//end call LOV page utk Account

// call save tambah data
	$("#btnSave").click(function(){				
		$.ajax({
			url		: "<?php echo site_url('pph_badan/save_beban_lain') ?>",
			type	: "POST",
			data	: $('#form-wp').serialize(),
			beforeSend	: function(){
				 $("body").addClass("loading");
				 },
			success	: function(result){
				if (result==1) {
					 table.draw();
					 $("body").removeClass("loading");
					 $("#list-data").slideDown(700);
					 $("#tambah-data").slideUp(700);
					 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
					 emptyVar();
				} else {
					 $("body").removeClass("loading");
					 //flashnotif('Error','Data Gagal di Simpan!','error' );
					 flashnotif('Error',result,'error' );
				}
				
			}
		});	
	});
// end of save tambah data

// call delete data
	$("#btnDelete").click(function(){
		  bootbox.confirm({
			title: "Hapus data",
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
						url		: "<?php echo site_url('pph_badan/delete_beban_lain') ?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								 $("body").removeClass("loading");
								 table.draw();
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
// end delete data
	
	function updateRow()
	{
		table.draw();
	}

	$("#btnAdd").on("click", function(){		
		$("#isNewRecord").val("1");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);	
		$("#capAdd").html("<span class='label label-danger'>Tambah Data Rekapitulasi Rincian Beban Lain Gabungan</span>");
			
	});	
	
	$("#btnEdit").on("click", function(){
		$("#isNewRecord").val("0");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
		$("#capAdd").html("<span class='label label-danger'>Update Data Rekapitulasi Rincian Beban Lain Gabungan</span>");
		//valueGrid();
	});		
	
	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);	
		emptyVar();
	});

	/*
	function valueGrid()
	{
		$("#inpAccount").val(l_nama_pajak);
		$("#inpDescription").val(l_bulan_pajak);
		$("#inpAmount").val(l_tahun_pajak);
		$("#inpDeductible").val(l_nama_doc);
		$("#inpIsDeductible").val(l_url_doc);
		$("#inpNonDeductible").val(l_pembetulan_ke);		
	}	
	*/

	function emptyVar()
	{
		/*
		l_nama_pajak 	= "";
		l_masa_pajak 	= "";
		l_tahun_pajak 	= "";
		l_nama_doc 		= "";
		l_url_doc 		= "";
		l_pembetulan_ke = "";
		*/
		
		$("#inpAccount").val("");
		$("#inpDescription").val("");
		$("#inpAmount").val("");
		//$("#inpIsDeductible").val("");
		$("#inpDeductible").val("");		
		$("#inpNonDeductible").val("");
	}

		
		
 });
 </script>							

