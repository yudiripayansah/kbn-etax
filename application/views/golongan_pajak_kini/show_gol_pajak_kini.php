<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						MASTER GOLONGAN PAJAK KINI
					  </div>
					  <div class="col-lg-6">
						<div class="navbar-right">
							<button id="btnTambah" class="btn btn-default btn-rounded custom-input-width" data-toggle="modal" data-target="#modal-tambah" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button>
							<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled data-toggle="modal" data-target="#modal-wp"><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnHapus" class="btn btn-rounded btn-default custom-input-width " disabled data-toggle="modal" data-target="#modal-hapus"><i class="fa fa-trash-o"></i> DELETE</button>
						</div>
					  </div>
					</div>
				</div>
				<div class="panel-body"> 
					<div class="table-responsive">
						<?php if($this->session->userdata('kd_cabang') == "000"): ?>
							<div style="padding-bottom: 5px;color:#333;font-weight: 400">
								<label>Filter by Tahun</label>
								<select class="form-control" id="edit_tahun" name="edit_tahun" id="edit_tahun" name="edit_tahun"  placeholder="Tahun" data-error="Mohon isi Tahun" required>
								<option value="" data-name="" >Semua Tahun</option>
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
							<br>
						<?php endif; ?>
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th> NO </th>
							    <th> GOLONGAN PAJAK KINI ID </th>
								<th> KODE AKUN </th>
								<th> URAIAN </th>
								<th> JUMLAH KOMERSIL </th>
								<th> KOREKSI FISKAL </th>
								<th> JUMLAH </th>
								<th> SPT </th>
								<th> BULAN </th>
								<th> TAHUN </th>
							</tr>
						</thead>
					</table>
					</div>
			    </div>
            </div>
        </div>
    </div>
</div>

<!--edit data -->
<div id="edit-data">
	<div id="error-add" class="alert alert-danger alert-dismissable hidden"></div>
	<div id="error-edit" class="alert alert-danger alert-dismissable hidden"></div>
	<form role="form" id="form-wp" data-toggle="validator">
	<div class="white-box boxshadow">
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">Golongan Pajak Kini</h2>
			</div>
		</div>
		<br>
		<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
				<input type="hidden" class="form-control" id="edit_gol_pajak_kini_id" name="edit_gol_pajak_kini_id">
				<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
                <label>BULAN</label>
                <select class="form-control" id="edit_bulan" name="edit_bulan">
                    <option value="" data-name="" >Semua Bulan</option>
                    <?php
                            $namaBulan = list_month();
                            $bln = date('m');
                            for ($i=1;$i< count($namaBulan);$i++){
                            $selected = ($i==$bln)?"selected":"";
                            echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
                            }
                    ?>
                </select> 
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="col-lg-6">
				<div class="form-group">
				<label>TAHUN</label>
					<select class="form-control" id="edit_tahun" name="edit_tahun" id="edit_tahun" name="edit_tahun"  placeholder="Tahun" data-error="Mohon isi Tahun" required>
							<?php 
								
								//$namaTahun = list_year();
								$tahun  = date('Y');
								$tAwal  = $tahun - 5;
								$tAkhir = $tahun;
								for($i=$tAwal; $i<=$tAkhir;$i++){
									$selected	= ($i==$tahun)?"selected":"";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							?>
						</select> 
                        <div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="row">		
			<div class="col-lg-2 ">
				<div class="form-group">
					<label>Account</label>
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
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
				<label>URAIAN</label>
					<input type="text" class="form-control" id="edit_uraian" name="edit_uraian" placeholder="Masukan Uraian.." data-toggle="validator">
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
				<label>JUMLAH KOMERSIL</label>
					<input type="number" class="form-control" id="edit_jumlah_komersil" name="edit_jumlah_komersil" min="0" max="999999999999999" step="0.000001" placeholder="Masukan Jumlah Komersil.." data-toggle="validator">
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				<label>KOREKSI FISKAL</label>
					<input type="number" class="form-control" id="edit_koreksi_fiskal" name="edit_koreksi_fiskal" min="0" max="999999999999999" step="0.000001"  placeholder="Masukan Koreksi Fiskal.." data-toggle="validator" data-error="" >
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
				<label>JUMLAH</label>
					<input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" min="0" max="999999999999999" step="0.000001"  placeholder="Masukan Jumlah.." data-toggle="validator" data-error="" >
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				<label>KODE SPT</label>
					<input type="text" class="form-control" id="edit_kode_spt" name="edit_kode_spt" placeholder="Masukan Kode SPT.." data-toggle="validator">
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="white-box boxshadow">
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
								<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" id="btnBack"><i class="fa fa-times-circle"></i> CANCEL</button>
								<button type="submit" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
						  </div>
					 </div>
				</div>
			</div>
		</div>	
	</div>
	</form>
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


<script>
    $(document).ready(function() {
			var table	= "", 
				vgolongan_pajak_kini_id          = "",
				vuraian             			 = "",
				vjumlah                          = "",
				vbulan                           = "",
				vtahun                           = "",
				vkodeakun                        = "",
				vspt                          	 = "",
				vdescription                     = "",
				vjumlah_komersil                 = "",
				vkoreksi_fiskal                  = ""
				;
 		
		//$("#btnHapus").hide();
		$("#edit-data").hide();

		filter_by = $("#edit_tahun").val();
		console.log('filterby nya ' + filter_by);
					
		 Pace.track(function(){
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: false,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: baseURL + 'pph_badan/load_golongan_pajak_kini',
								 "type" 		: "POST",
								 "data"	: function (d) {		
										d._searchTahun = filter_by;
									}
							  },
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "gol_pajak_kini_id","width" : "60px" },
					{ "data": "kode_akun", "class":"text-left" },
					{ "data": "uraian" },
					{ "data": "jumlah_komersil", "class":"text-center" },
					{ "data": "koreksi_fiskal", "class":"text-center" },
					{ "data": "jumlah", "class":"text-right" },
					{ "data": "spt", "class":"text-center" },
					{ "data": "bulan", "class":"text-center" },
					{ "data": "tahun", "class":"text-center" },
					{ "data": "description", "class":"text-center" }

				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			"columnDefs": [ 
				 {
					"targets": [ 1,10],
					"visible": false
				} 
			],			
			 fixedColumns:   {
						leftColumns: 0,
				},
			 "select"			: true,
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false
			});
		 });
		
		table = $('#tabledata').DataTable();
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Uraian ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
			
		} );

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vgolongan_pajak_kini_id	= "";
				vuraian					= "";
				vjumlah				    = "";
				vbulan		            = "";
				vtahun 					= "";
				vkodeakun 				= "";
				vspt 					= "";
				vdescription            = "";
				vjumlah_komersil        = "";
				vkoreksi_fiskal         = "";
				emptyGrid();
				$("#btnEdit,#btnHapus").attr("disabled",true);
				
				//$('#modal-wp').removeAttr('id');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d						= table.row( this ).data();
				vgolongan_pajak_kini_id		= d.gol_pajak_kini_id;
				vuraian						= d.uraian;
				vjumlah					    = d.jumlah;
				vbulan				        = d.bulan;
				vtahun 						= d.tahun;
				vkodeakun 					= d.kode_akun;
				vspt 						= d.spt;
				vdescription                = d.description;
				vjumlah_komersil            = d.jumlah_komersil;
				vkoreksi_fiskal             = d.koreksi_fiskal;
				valueGrid();

				$("#btnEdit,#btnHapus").removeAttr('disabled');
			}
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		} );

		$("#edit_tahun").on("change", function(){
			filter_by = $("#edit_tahun").val();
			table.ajax.reload(null, false);
		});
			
		$('#form-wp').validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) {
				console.log('tidak valid');
			}
			else {
				 $.ajax({
				url		: baseURL + 'golongan_pajak_kini/save_golongan_pajakkini/',
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
				 				$("body").addClass("loading");
				 			},
				success	: function(result){
					console.log(result);
					if (result==1) {
						table.draw();
						$("body").removeClass("loading"); 
						$("#list-data").slideDown(700);
						$("#edit-data").slideUp(700);
						emptyGrid();
						flashnotif('Sukses','Data Berhasil di simpan!','success' );
					} 
					else if (result==2) {
						$("body").removeClass("loading");
						flashnotif('Info', 'Uraian, Bulan dan Tahun Tidak boleh sama dengan data yang sudah ditambahkan','warning');
					} 
					else {
						$("body").removeClass("loading");
						flashnotif('Error', result,'error');
					}
				}
			});
			}
			e.preventDefault();
		});
		
		$("#btnEdit").click(function (event){
            $("#list-data").slideUp(700);
            $("#edit-data").slideDown(700);
            $("#isNewRecord").val("0");
            $("#capAdd").html("<span class='label label-danger'>Edit Data Golongan Pajak Kini</span>");
            valueGrid();			
		});
		
		$("#btnTambah").click(function (){
			$("#list-data").slideUp(700);
			$("#edit-data").slideDown(700);
			$("#isNewRecord").val("1");
			$("#capAdd").html("<span class='label label-danger'>Tambah Golongan Pajak Kini</span>");
			emptyGrid();
		});

		$("#btnBack").click(function (){
			$("#list-data").slideDown(700);
			$("#edit-data").slideUp(700);
			emptyGrid();
		});
		
	function valueGrid()
	{
		$("#edit_gol_pajak_kini_id").val(vgolongan_pajak_kini_id);  
		$("#edit_uraian").val(vuraian);
		$("#edit_jumlah").val(vjumlah.replace(/,/g, ''));
		$("#edit_bulan").val(vbulan);
		$("#edit_tahun").val(vtahun);
		$("#inpAccount").val(vkodeakun);
		$("#edit_kode_spt").val(vspt);
		$("#inpDescription").val(vdescription);
		$("#edit_jumlah_komersil").val(vjumlah_komersil);
		$("#edit_koreksi_fiskal").val(vkoreksi_fiskal);
	}
	
	function emptyGrid()
	{
        $("#edit_gol_pajak_kini_id").val("");  
		$("#edit_uraian").val("");
		$("#edit_jumlah").val("");
		$("#edit_bulan").val("");
		$("#edit_tahun").val("");
		$("#inpAccount").val("");
		$("#edit_kode_spt").val("");
		$("#inpDescription").val("");
		$("#edit_jumlah_komersil").val("");
		$("#edit_koreksi_fiskal").val("");
	}
	
	$("#btnHapus").click(function(){
		  bootbox.confirm({
			title: "Hapus Data Golongan Pajak Kini <span class='label label-danger'>"+vuraian+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Hapus'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('golongan_pajak_kini/delete_bt') ?>",
						type	: "POST",
						data	: ({id:vgolongan_pajak_kini_id}),
						beforeSend	: function(){
							 $("body").addClass("loading")
							 $("#modal-wp").modal("hide");
							},
						success	: function(result){
							if (result==1) {
								 table.draw();
								 $("body").removeClass("loading")
								flashnotif('Sukses','Data Berhasil di Hapus!','success' );
							} else {
								flashnotif('Error','Data Gagal di Hapus!','error' );
							}
						}
					});
				}
			}
		});
	})


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
										 "url"  		: "<?php echo site_url('pph_badan/load_lov_acc_delapan'); ?>",
										 "type" 		: "POST",
										"data"			: function ( d ) {
														  d._usedAkun 		= $('#usedAkun').val();
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
				table_wp.draw();
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
	
 });
    </script>
