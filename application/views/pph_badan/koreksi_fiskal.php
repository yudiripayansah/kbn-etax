<div class="container-fluid">

	 <?php $this->load->view('template_top'); ?>	
	
	 <div id="list-data">
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
						<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
					</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnProses" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Generate</span></button>
					</div>
				</div>
		</div>		 
				
		<div class="row"> 	
			<div class="col-lg-12">	
				<div class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">
						<div class="row">
						  <div class="col-lg-6">
							Buku Bantu Koreksi Fiskal PENDAPATAN
						  </div>
						  <div class="col-lg-6">							    
							<div class="navbar-right">								 
								<button id="btnAddPEND" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button>
								<button type="button" id="btnEditPEND" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
								<button type="button" id="btnDeletePEND" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> DELETE</button>
							</div>
						  </div>
						</div>  						   
					</div>
				   
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata_pend"> 
							<thead>
								<tr>
									<th>No.</th>
									<th>Account</th>									
									<th>Kode Jasa</th>                                                                               
									<th>Description</th>
									<th>Nilai Komersial</th>
									<th>Amount Positif</th>										 
									<th>Amount Negatif</th>										
									<th>Nilai Fiskal</th>										
									<th>ID</th>										
									<th>Tahun</th>										
									<th>Angka Bulan</th>										
									<th>Bulan</th>										
								</tr>
							</thead>
						</table>
						</div>                            
				   </div>				
				</div>
			</div>
		</div>	

    <div class="row"> 	
			<div class="col-lg-12">	
				<div class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">
						<div class="row">
						  <div class="col-lg-6">
							Buku Bantu Koreksi Fiskal BEBAN
						  </div>
						  <div class="col-lg-6">							    
							<div class="navbar-right">								 
								<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button>
								<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
								<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> DELETE</button>
							</div>
						  </div>
						</div>  						   
					</div>
				   
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
							<thead>
								<tr>
									<th>No.</th>
									<th>Account</th>									
									<th>Description</th>                                                                               
									<th>Check List</th>
									<th>Nilai Komersial</th>
									<th>Amount Positif</th>										 
									<th>Amount Negatif</th>										
									<th>Nilai Fiskal</th>										
									<th>ID</th>										
									<th>Tahun</th>										
									<th>Angka Bulan</th>										
									<th>Bulan</th>										
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
			<div class="col-lg-2 ">
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
			<div class="col-lg-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="inpBulan" name="inpBulan">
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
		</div>		
		<div class="row">		
			<div class="col-lg-2 ">
				<div class="form-group">
					<label>Account</label>
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<input type="hidden" class="form-control" id="usedAkun" name="usedAkun">
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
		<div class="row" id="field_kode_jasa">		
			<div class="col-lg-2 ">
				<div class="form-group">
					<label>Kode Jasa</label>
					<div class="input-group">
						<input class="form-control" id="inpKodeJasa" name="inpKodeJasa" placeholder="Kode Jasa" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getKodeJasa" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-kodejasa" ><i class="fa fa-search"></i></button>
						</span> 
					</div>
					
				</div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>Nama Jasa</label>
					<input class="form-control" id="inpDescriptionKodejasa" name="inpDescriptionKodejasa" placeholder="Nama Jasa" type="text" maxlength="240" readonly>
				</div>	
			 </div>
			</div>
		</div>		
		<!--
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Check List</label>
					<select class="form-control" id="inpCheckList" name="inpCheckList">
						<option value="0" >No</option>						
						<option value="1" >Yes</option>
					</select> 				
				</div>
			</div>		 
		</div>
		-->
    <div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Nilai Komersial</label>
					<input class="form-control" id="nilaiKomersial" name="nilaiKomersial" placeholder="Nilai Komersial" type="text" maxlength="30">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Amount Positif</label>
					<input class="form-control" id="inpPositif" name="inpPositif" placeholder="Amount Positif" type="text" maxlength="30">
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Amount Negatif</label>
					<input class="form-control" id="inpNegatif" name="inpNegatif" placeholder="Amount Negatif" type="text" maxlength="30">				
				</div>
			</div>		 
			<div class="col-lg-6">
				<div class="form-group">
					<label>Nilai Fiskal</label>
					<input class="form-control" id="nilaiFiskal" name="nilaiFiskal" placeholder="Nilai Fiskal" type="text" maxlength="30">				
				</div>
			</div>		 
		</div>			
		
		<div class="white-box boxshadow">			
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
								<th>Komersial</th>
								<th>Bulan</th>
								<th>Tahun</th>									
							</tr>
						</thead>
					</table>
				</div>  
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
			</div>
		</div>	
	</div>
</div>
<!-- end LOV Region : Account-->

<!-- LOV Region : KODE JASA-->
<div id="modal-kodejasa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Daftar Kode Jasa</h4> </div>
			<div class="modal-body">
				<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small animated slideInDown" id="tabledata-namakodejasa"> 
						<thead>
							<tr>
								<th>No</th>
								<th>Kode Jasa</th>
								<th>Description</th>								
							</tr>
						</thead>
					</table>
				</div>  
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancelKodeJasa"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoiceKodeJasa" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
			</div>
		</div>	
	</div>
</div>
<!-- end LOV Region : KODE JASA-->		
</div>
	
<script>
$(document).ready(function() {
	var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vtahun="",vidx="";

	$("#tambah-data").hide();
	$("#btnAdd").hide();
	$("#btnAddPEND").hide();
	$("#nilaiKomersial, #inpPositif,#inpNegatif, #nilaiFiskal").number(true,2);

	Pace.track(	function(){		
	$('#tabledata').DataTable({
		"serverSide"	: true,
		"processing"	: false,
		"pageLength"		: 100,
		"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
		"ajax"			: {
							 "url"  		: "<?php echo site_url('pph_badan/load_fiskal'); ?>",
							 "type" 		: "POST",
							 "data"	: function ( d ) {
										d._searchTahun 	= $('#tahun').val();
										d._searchBulan 	= $('#bulan').val();
									},									
						  },
		 "language"		: {
				"emptyTable"	: "Data not found!",	
				"infoEmpty"		: "Empty Data",
				"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},			 
		   "columns": [
				{ "data": "no", "class":"text-center" },
				{ "data": "kode_akun", "class":"text-left"},					
				{ "data": "akun_desc"},					
				{ "data": "checklist"},
				{ "data": "nilai_komersial", render: $.fn.dataTable.render.number(',', '.', 0, '')},					
				{ "data": "amount_positif", render: $.fn.dataTable.render.number(',', '.', 0, '')},					
				{ "data": "amount_negatif", render: $.fn.dataTable.render.number(',', '.', 0, '')},
				{ "data": "nilai_fiskal", render: $.fn.dataTable.render.number(',', '.', 0, '')},
				{ "data": "koreksi_fiskal_id"},
				{ "data": "tahun_pajak"},
				{ "data": "bulan_pajak"},
				{ "data": "disp_bulan"}
			],			
		"columnDefs": [ 
			 {
				"targets": [ 3, 8, 11 ],
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
	$('.dataTables_filter input[type="search"]').attr('placeholder','Search Account / Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
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
			$("#DocId").val(d.koreksi_fiskal_id);
			$("#inpAccount").val(d.kode_akun);
			$("#inpDescription").val(d.akun_desc);
			$("#inpPositif").val(d.amount_positif);
			$("#inpNegatif").val(d.amount_negatif);
			$("#inpCheckList").val(d.checklist);	
			$("#inpTahun").val(d.tahun_pajak);	
			$("#inpBulan").val(d.bulan_pajak);
			$("#nilaiKomersial").val(d.nilai_komersial);
			$("#nilaiFiskal").val(d.nilai_fiskal);				
			}								 
	} ).on("dblclick", "tr", function () {
		console.log("2-"+vidx);
	} );


	Pace.track(	function(){		
	$('#tabledata_pend').DataTable({
		"serverSide"	: true,
		"processing"	: false,
		"pageLength"		: 100,
		"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
		"ajax"			: {
							 "url"  		: "<?php echo site_url('pph_badan/load_fiskal_pend'); ?>",
							 "type" 		: "POST",
							 "data"	: function ( d ) {
										d._searchTahun 	= $('#tahun').val();
										d._searchBulan 	= $('#bulan').val();
									},									
						  },
		 "language"		: {
				"emptyTable"	: "Data not found!",	
				"infoEmpty"		: "Empty Data",
				"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},			 
		   "columns": [
				{ "data": "no", "class":"text-center" },
				{ "data": "kode_akun", "class":"text-left"},					
				{ "data": "kode_jasa"},					
				{ "data": "kode_jasa_desc"},
				{ "data": "nilai_komersial", render: $.fn.dataTable.render.number(',', '.', 0, '')},
				{ "data": "amount_positif", render: $.fn.dataTable.render.number(',', '.', 0, '')},					
				{ "data": "amount_negatif", render: $.fn.dataTable.render.number(',', '.', 0, '')},
				{ "data": "nilai_fiskal", render: $.fn.dataTable.render.number(',', '.', 0, '')},
				{ "data": "koreksi_fiskal_id"},
				{ "data": "tahun_pajak"},
				{ "data": "bulan_pajak"},
				{ "data": "disp_bulan"}
			],			
		"columnDefs": [ 
			 {
				"targets": [ 8, 11 ],
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

	table_pend = $('#tabledata_pend').DataTable();

	$('#tabledata_pend tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
			$("#btnEditPEND").attr("disabled",true);
			$("#btnDeletePEND").attr("disabled",true);
		} else {
			table_pend.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');	
			$("#btnEditPEND").removeAttr('disabled');
			$("#btnDeletePEND").removeAttr('disabled');
			var d			= table_pend.row( this ).data();
			$("#DocId").val(d.koreksi_fiskal_id);
			$("#inpAccount").val(d.kode_akun);
			$("#inpDescription").val(d.akun_desc);
			$("#inpKodeJasa").val(d.kode_jasa);
			$("#inpDescriptionKodejasa").val(d.kode_jasa_desc);
			$("#inpPositif").val(d.amount_positif);
			$("#inpNegatif").val(d.amount_negatif);
			$("#inpCheckList").val(d.checklist);	
			$("#inpTahun").val(d.tahun_pajak);	
			$("#inpBulan").val(d.bulan_pajak);
			$("#nilaiKomersial").val(d.nilai_komersial);
			$("#nilaiFiskal").val(d.nilai_fiskal);			
			}								 
	} ).on("dblclick", "tr", function () {
		console.log("2-"+vidx);
	} );
	
	$("#btnView").click(function (){
		table.ajax.reload();
		table_pend.ajax.reload();
	});	

	$("#btnProses").click(function (){
		$vTahun = $("#tahun").val();
		$vbulan = $("#bulan").val();
		$("#inpTahun").val($vTahun);
		$("#inpBulan").val($vbulan);
		bootbox.confirm({
			title: "Process Data",
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
						url		: "<?php echo site_url('pph_badan/process_data_kf_tb78') ?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								 $("body").removeClass("loading");
								 table.draw();
								 table_pend.draw();
								 flashnotif('Sukses','Data Berhasil Proses!','success' );			
							} else if (result==4) {
								$("body").removeClass("loading");
								 flashnotif('Error','Generate Failed! karena Data Bulan ' + $vbulan + ' dan Tahun '+$vTahun+' sudah ada','error' );
							}
							else {
								 $("body").removeClass("loading");
								 flashnotif('Error','Data Gagal di Proses!','error' );
							}
							
						}
					});	
				}
			}
		});	
	});
	

// call LOV page utk Account
	$("#getAccount").on("click", function(){
			vAkun	        = "";							
			vAkunDesc       = "";
			vinpKomersial       = "";
			if ($('#inpBulan').val() == null){
				alert('Mohon isi Bulan');
				die();
			}
			if ($('#inpTahun').val() == null){
				alert('Mohon isi Tahun');
				die();
			}
			$("#btnChoice").attr("disabled",true);
			
			if ( ! $.fn.DataTable.isDataTable( '#tabledata-namapajak' ) ) {
				$('#tabledata-namapajak').DataTable({
					"serverSide"	: true,
					"processing"	: true,
					"ajax"			: {
										 "url"  		: "<?php echo site_url('pph_badan/load_lov_acc_delapan2'); ?>",
										 "type" 		: "POST",
										"data"			: function ( d ) {
														  d._usedAkun 		= $('#usedAkun').val();
														  d._usedBulan 		= $('#inpBulan').val();
														  d._usedTahun 		= $('#inpTahun').val();
																		}	
									  },
					 "language"		: {
							"emptyTable"	: "Data not found!",	
							"infoEmpty"		: "Empty Data",
							"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
							"search"		: "_INPUT_"
						},
					   "columns": [
							{ "data": "no", "class":"text-center" },
							{ "data": "akun" },
							{ "data": "akun_desc" },
							{ "data": "komersial" },
							{ "data": "periodnum" },
							{ "data": "periodyear" },
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
				$('#modal-Account .dataTables_filter input[type="search"]').attr('placeholder','Search Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
				$("#tabledata-namapajak_filter .add-clear-x").on('click',function(){
					table_wp.search('').column().search('').draw();			
				});
									
				$('#tabledata-namapajak tbody').on( 'click', 'tr', function () {			
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						$("#btnChoice").attr("disabled",true);
						vAkun	        = "";							
						vAkunDesc       = "";
						vinpKomersial   = "";
					} else {
						table_wp.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						var d			= table_wp.row( this ).data();
						vAkun	        = d.akun;							
						vAkunDesc       = d.akun_desc;
						vinpKomersial   = d.komersial;
						$("#btnChoice").removeAttr('disabled'); 
					}								 
				} ).on("dblclick", "tr", function () {
					table_wp.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d		= table_wp.row( this ).data();
					vAkun	        = d.akun;							
					vAkunDesc       = d.akun_desc;
					vinpKomersial   = d.komersial;
					valueGridwp();		
					$("#btnChoice").removeAttr('disabled'); 		
				} ) ;	
				
				
			} else {
				table_wp.draw();
			}			


		
	});

		$("#btnChoice").on("click",valueGridwp);
		$("#btnCancel").on("click",batal);	
		
		function valueGridwp()
		{
			$("#inpAccount").val(vAkun);
			$("#inpDescription").val(vAkunDesc);
			$("#nilaiKomersial").val(vinpKomersial);
			$("#modal-Account").modal("hide");
		}	

		function batal()
		{
			vAkun	        = "";							
			vAkunDesc       = "";
			vinpKomersial   = "";
		}	
		
//end call LOV page utk Account

// call LOV page utk Kode Jasa
	$("#getKodeJasa").on("click", function(){
			vAkun	        = "";							
			vAkunDesc       = "";
			$("#btnChoiceKodeJasa").attr("disabled",true);
			
			if ( ! $.fn.DataTable.isDataTable( '#tabledata-namakodejasa' ) ) {
				$('#tabledata-namakodejasa').DataTable({
					"serverSide"	: true,
					"processing"	: true,
					"ajax"			: {
										 "url"  		: "<?php echo site_url('pph_badan/load_lov_kode_jasa'); ?>",
										 "type" 		: "POST"
									  },
					 "language"		: {
							"emptyTable"	: "Data not found!",	
							"infoEmpty"		: "Empty Data",
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
				
				table_kode_jasa = $('#tabledata-namakodejasa').DataTable();
				
				$("#modal-kodejasa input[type=search]").addClear();		
				$('#modal-kodejasa .dataTables_filter input[type="search"]').attr('placeholder','Search Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
				$("#tabledata-namakodejasa_filter .add-clear-x").on('click',function(){
					table_kode_jasa.search('').column().search('').draw();			
				});
									
				$('#tabledata-namakodejasa tbody').on( 'click', 'tr', function () {			
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						$("#btnChoiceKodeJasa").attr("disabled",true);
						vAkun	        = "";							
						vAkunDesc       = "";
					} else {
						table_kode_jasa.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						var d			= table_kode_jasa.row( this ).data();
						vAkun	        = d.akun;							
						vAkunDesc       = d.akun_desc;
						$("#btnChoiceKodeJasa").removeAttr('disabled'); 
					}								 
				} ).on("dblclick", "tr", function () {
					table_kode_jasa.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d		= table_kode_jasa.row( this ).data();
					vAkun	        = d.akun;							
					vAkunDesc       = d.akun_desc;
					valueGridKS();		
					$("#btnChoiceKodeJasa").removeAttr('disabled'); 		
				} ) ;	
				
				
			} else {
				table_kode_jasa.$('tr.selected').removeClass('selected');
			}			


		
	});

		$("#btnChoiceKodeJasa").on("click",valueGridKS);
		$("#btnCancelKodeJasa").on("click",batalKS);	
		
		function valueGridKS()
		{
			$("#inpKodeJasa").val(vAkun);
			$("#inpDescriptionKodejasa").val(vAkunDesc);
			$("#modal-kodejasa").modal("hide");
		}	

		function batalKS()
		{
			vAkun	        = "";							
			vAkunDesc       = "";
		}	
		
//end call LOV page utk Kode Jasa

// call save tambah data
	$("#btnSave").click(function(){				
		$.ajax({
			url		: "<?php echo site_url('pph_badan/save_fiskal') ?>",
			type	: "POST",
			data	: $('#form-wp').serialize(),
			beforeSend	: function(){
				 $("body").addClass("loading");
				 },
			success	: function(result){
				if (result==1) {
					 table.draw();
					 table_pend.draw();
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


$("#btnDeletePEND").click(function(){
	$("#btnDelete").click();
});

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
						url		: "<?php echo site_url('pph_badan/delete_fiskal') ?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								 $("body").removeClass("loading");
								 table.draw();
								 table_pend.draw();
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
		$("#field_kode_jasa").hide();
		$("#isNewRecord").val("1");
		$("#usedAkun").val("8");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);	
		$("#capAdd").html("<span class='label label-danger'>Tambah Data Koreksi Fiskal BEBAN</span>");
		$("#nilaiKomersial").val("");
			
	});	
	
	$("#btnAddPEND").on("click", function(){
		$("#field_kode_jasa").show();
		$("#isNewRecord").val("1");
		$("#usedAkun").val("7");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);	
		$("#capAdd").html("<span class='label label-danger'>Tambah Data Koreksi Fiskal PENDAPATAN</span>");
		$("#nilaiKomersial").val("");	
	});	
	
	$("#btnEdit").on("click", function(){
		$("#field_kode_jasa").hide();
		$("#isNewRecord").val("0");
		$("#usedAkun").val("8");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
		$("#capAdd").html("<span class='label label-danger'>Update Data Koreksi Fiskal BEBAN</span>");
	});	

	$("#btnEditPEND").on("click", function(){
		$("#field_kode_jasa").show();
		$("#isNewRecord").val("0");
		$("#usedAkun").val("7");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
		$("#capAdd").html("<span class='label label-danger'>Update Data Koreksi Fiskal PENDAPATAN</span>");
	});	
	
	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);	
		emptyVar();
	});


	function emptyVar()
	{		
		$("#inpAccount").val("");
		$("#inpDescription").val("");
		$("#inpPositif").val("");
		$("#inpNegatif").val("");
		$("#inpCheckList").val("");	
		$("#inpTahun").val("");			
		$("#inpBulan").val("");			
		$("#inpKodeJasa").val("");			
		$("#inpDescriptionKodejasa").val("");
		$("#usedAkun").val("");
	}

	var vip=0;vin=0;vnk=0;vtfiskal=0;
	$("#inpPositif").change(function (){
		vip = $("#inpPositif").val();
		vin = $("#inpNegatif").val();
		vnk = $("#nilaiKomersial").val();
		if(vip == ""){
			vip = 0;
		}
		if(vin == ""){
			vin = 0;
		}
		if(vnk == ""){
			vnk = 0;
		}
		vtfiskal = ((parseInt(vnk)+parseInt(vip))-parseInt(vin))
		$("#nilaiFiskal").val(vtfiskal);
	});

	$("#inpNegatif").change(function (){
		vip = $("#inpPositif").val();
		vin = $("#inpNegatif").val();
		vnk = $("#nilaiKomersial").val();
		if(vip == ""){
			vip = 0;
		}
		if(vin == ""){
			vin = 0;
		}
		if(vnk == ""){
			vnk = 0;
		}
		vtfiskal = ((parseInt(vnk)+parseInt(vip))-parseInt(vin))
		$("#nilaiFiskal").val(vtfiskal);
	});
		
		
 });
 </script>							

