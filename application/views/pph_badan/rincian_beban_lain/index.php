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
				<div class="col-lg-6">
					<div class="form-group">
						<label>Ledger</label>
						<select class="form-control" id="ledger" name="ledger">
							<?php
								
								$sql		="select * from SIMTAX_MASTER_LEDGER where ledger_id = 2022";
								$query = $this->db->query($sql);
								
								foreach($query->result_array() as $row)	{
									
									$kode_perusahaan	= $row['LEDGER_ID'];
									$nama_perusahaan	= $row['DESCRIPTION'];
									echo "<option value='".$kode_perusahaan."'>".$nama_perusahaan."</option>";

								}							
								$query->free_result();
							?>	
						</select> 
					</div>
				 </div>	
				<div class="col-lg-2">
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="bulan" name="bulan">
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
					<label>Account</label>
					<div class="input-group">
						<input class="form-control" id="inpAccount" name="inpAccount" placeholder="Account" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getAccount" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-Account" ><i class="fa fa-search"></i></button>
						</span> 
					</div> 
				 </div>		
				<div class="col-lg-6">
					<label>Account Description</label>
					<input class="form-control" id="inpDescription" name="inpDescription" ="text" readonly>
				 </div>						 
			</div>
			<div class="row">
				 <div class="col-lg-2">	
					<div class="form-group">
					<label>&nbsp;</label>
						<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" > 
						<i class="fa fa-bars"></i> <span>VIEW</span></button>
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
							Daftar Rincian Beban Lain
						  </div>
						  <div class="col-lg-6">							    
							<div class="navbar-right">
								
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
									<th>CHECK LIST</th>
									<th>KODE AKUN</th>									
									<th>DESKRIPSI AKUN</th>                                                                               
									<th>DEBIT</th>										 
									<th>URAIAN</th>									
								</tr>
							</thead>
							
						</table>
						</div>                            
				   </div>				
				</div>
			</div>
		</div>
	</div>

	 <div id="list-datarekap">		 
		<div class="row"> 	
			<div class="col-lg-12">	
				<div class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">
						<div class="row">
						  <div class="col-lg-6">
							Rekapitulasi Rincian Beban Lain Gabungan
						  </div>
						</div>  						   
					</div>
				   
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledatarekap"> 
							<thead>
								<tr>
									<th>NO</th>
									<th>KETERANGAN</th>									
									<th>JUMLAH RINCIAN</th>                                                                               
									<th>DEDUCTIBLE</th>
									<th>NON-DEDUCTIBLE</th>																
								</tr>
							</thead>
						</table>
						</div>                            
				   </div>				
				</div>
			</div>
		</div>
	</div>		

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
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
			</div>
		</div>	
	</div>
</div>
<!-- end LOV Region : Account-->		
</div>

<!-------------------------------------->		
<div id="edit-data">	
	<form role="form" id="form-wp">	
	<div class="white-box boxshadow">
	 	
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">Edit Debit / Credit</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>DEBIT</label>
					<input type="hidden" class="form-control" id="beban_id" name="beban_id">
					<input class="form-control" id="inpDebit" name="inpDebit" placeholder="Koreksi nilai debit" type="text" maxlength="30">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>CREDIT</label>
					<input class="form-control" id="inpCredit" name="inpCredit" placeholder="Koreksi credit" type="text" maxlength="30">				
				</div>
			</div>		 
		</div>			
		
		<div class="white-box boxshadow">			
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<!--<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>					
							-->
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
	
<script>
$(document).ready(function() {
	var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vtahun="",vidx="";
	var vline_id ="",vcheckbox_id ="";

	$("#edit-data").hide();
	$("#btnEdit").attr("disabled",true);

	Pace.track(	function(){		
	$('#tabledata').DataTable({
		"serverSide"	: true,
		"processing"	: true,
		"pageLength"		: 100,
		"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
		"ajax"			: {
							 "url"  		: "<?php echo site_url('pph_badan/load_rincian_bl'); ?>",
							 "type" 		: "POST",
							 "data"	: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchAkun 	= $('#inpAccount').val();
										d._searchLedger = $('#ledger').val();
									},									
						  },
		 "language"		: {
				"emptyTable"	: "Data not found!",	
				"infoEmpty"		: "Empty Data",
				"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},			 
		   "columns": [
				{ "data": "no", "class":"text-center", "height" : "10px" },
				{ "data": "checklist", "class":"text-center", "height" : "10px"},					
				{ "data": "kode_akun"},					
				{ "data": "akun_desc"},
				{ "data": "debit", "class":"text-right"},
				{ "data": "desc_beban"}
			],			
		"columnDefs": [ 
			 {
				"targets": [ ],
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
	$('.dataTables_filter input[type="search"]').attr('placeholder','Search Nomor / Tgl. Bukti / Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#tabledata_filter .add-clear-x").on('click',function(){
		table.search('').column().search('').draw();			
	});
	
	
	$('#tabledata tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
			$("#btnEdit").attr("disabled",true);
			//$("#btnDelete").attr("disabled",true);
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');	
			$("#btnEdit").removeAttr('disabled');
			//$("#btnDelete").removeAttr('disabled');
			var d			= table.row( this ).data();
			$("#inpDebit").val(d.debit);
			$("#inpCredit").val(d.credit);
			$("#beban_id").val(d.beban_lain_id);
			}								 
	} ).on("dblclick", "tr", function () {
		//console.log("2-"+vidx);
		var d			= table.row( this ).data();
		$("#inpDebit").val(d.debit);
		$("#inpCredit").val(d.credit);
		$("#beban_id").val(d.beban_lain_id);
		$("#list-data").slideUp(700);
		$("#edit-data").slideDown(700);		
	} );
	
	table.on( 'draw', function () {
		$(".checklist").on("click", function(){
			 vline_id 		= $(this).data("id");
			 vcheckbox_id 	= $(this).attr("id"); 
			 actionCheck();
		 });
		/*
		$('.checklist').confirmation({
			rootSelector: '[data-toggle=confirmation-singleton]',
			container: 'body',
			title: "Anda Yakin?",
			onConfirm: function() {				 		  
			   actionCheck();
			},
			btnOkClass: 'btn-xs btn-info',
			btnOkIcon: 'glyphicon glyphicon-ok',
			btnOkLabel: 'Ya',
			btnCancelClass: 'btn-xs btn-default',
			btnCancelIcon: 'glyphicon glyphicon-remove',
			btnCancelLabel: 'Tidak'				
		  });
		*/  
	} );

	function actionCheck()
	{
		if($("#"+vcheckbox_id).prop('checked') == true){
			  var vischeck	= 1;
			  var st_check	= "Checklist";			 
		 } else {
			 var vischeck	= 0;
			 var st_check	= "Unchecklist";			  
		 }
		 
		 $.ajax({
				url		: "<?php echo site_url('pph_badan/check_rincian_bl') ?>",
				type	: "POST",
				data	: ({line_id : vline_id, ischeck : vischeck}),				
				success	: function(result){
					if (result==1) {
						flashnotif('Sukses','Data Berhasil di '+st_check+'!','success' );
						tablerkp.draw();						
					} else {
						flashnotif('Error','Data Gagal di '+st_check+'!','error' );
					}
					
				}
			});		
	}	
	
	$("#btnView").click(function (){
		//table.ajax.reload();
		table.draw();
		tablerkp.draw();
		calcTotal();		
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
										 "url"  		: "<?php echo site_url('pph_badan/load_lov_account_beban'); ?>",
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
				
				table_wp = $('#tabledata-namapajak').DataTable();
				
				$("#modal-Account input[type=search]").addClear();		
				$('#modal-Account .dataTables_filter input[type="search"]').attr('placeholder','Search Akun/Description...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
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
				
				calcTotal();
				
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
			url		: "<?php echo site_url('pph_badan/save_debit_credit') ?>",
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
					 $("#edit-data").slideUp(700);
					 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
					 emptyVar();
					 calcTotal();
				} else {
					 $("body").removeClass("loading");
					 $("#list-data").slideDown(700);
					 $("#edit-data").slideUp(700);					 
					 flashnotif('Error','Gagal Gagal di Simpan!','error' );
					 emptyVar();
				}
				
			}
		});	
	});	
// end of save tambah data

// call delete data
/*
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
*/	
// end delete data
	
	function updateRow()
	{
		table.draw();
		calcTotal();
	}

	/*
	$("#btnAdd").on("click", function(){		
		$("#isNewRecord").val("1");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);	
		$("#capAdd").html("<span class='label label-danger'>Tambah Data Rekapitulasi Rincian Beban Lain Gabungan</span>");
			
	});	
	*/
	
	$("#btnEdit").on("click", function(){
		//$("#isNewRecord").val("0");
		$("#list-data").slideUp(700);
		$("#edit-data").slideDown(700);
		//valueGrid();
	});		
	
	$("#btnBack").on("click", function(){		
		$("#edit-data").slideUp(700);
		$("#list-data").slideDown(700);	
		emptyVar();
	});

	function emptyVar()
	{		
		$("#inpDebit").val("");	
		$("#inpCredit").val("");			
	}

	function calcTotal()
	{
			
			l_Bulan 	= $('#bulan').val();
			l_Tahun 	= $('#tahun').val();
			l_Akun 		= $('#inpAccount').val();
			l_Ledger 	= $('#ledger').val();
			
			$.ajax({
				url		: baseURL + 'Pph_badan/load_total_rincian_bl',
				type	: "POST",
				dataType:"json", 
				data	: ({bulan:l_Bulan, tahun:l_Tahun, akun:l_Akun, ledger: l_Ledger}),			
				success	: function(result){
					if (result.isSuccess==1) {	
						 $("#ttlDebit").html(result.sumDebit);		 
						 $("#ttlCredit").html(result.sumCredit);		 
					} else {
						flashnotif('Error','Ambil Data Total Summary Gagal!','error' );
					}
						
				}
			});
	}
	
	
	Pace.track(	function(){		
	$('#tabledatarekap').DataTable({
		"serverSide"	: true,
		"processing"	: true,
		"ajax"			: {
							 "url"  		: "<?php echo site_url('pph_badan/load_beban_lain'); ?>",
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
				{ "data": "no", "class":"text-center", "height" : "10px" },
				//{ "data": "kode_akun", "class":"text-left"},					
				{ "data": "akun_desc"},					
				{ "data": "jml_uraian", "class":"text-right"},
				{ "data": "deductible", "class":"text-right"},
				{ "data": "nondeductible", "class":"text-right"}
			],			
		"columnDefs": [ 
			 {
				"targets": [ ],
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
	
	tablerkp = $('#tabledatarekap').DataTable();
		
		
 });
 </script>							

