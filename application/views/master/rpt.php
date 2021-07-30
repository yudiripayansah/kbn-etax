<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						RATE PAJAK TANGGUHAN
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
						<div style="padding-bottom: 5px;color:#333;font-weight: 400">
							<label>Filter by Aktif</label>
                            <select class="form-control" name="vaktiv" id="vaktiv">
                                    <option value='' selected>All</option>
                                    <option value='1' >Aktif</option>
                                    <option value='0' >Tidak Aktif</option>
                            </select> 
						</div>
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>RPT ID</th>
								<th> RATE (%)</th>
								<th> TAHUN </th>
								<th> STATUS </th>
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
				<h2 id="capAdd" class="text-center">Rate Pajak Tangguhan</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<input type="hidden" class="form-control" id="edit_rpt_id" name="edit_rpt_id">
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<label>RATE</label>
					<input type="text" class="form-control" id="edit_rate" name="edit_rate" placeholder="Rate *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Rate" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				    <label>TAHUN</label>
					<select class="form-control" id="edit_tahun" name="edit_tahun"  placeholder="Tahun" data-error="Mohon isi Tahun" required>
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
		</div>
		
		<div class="row">
			<div class="col-lg-1">
				<div class="form-group">
					<label for="edit_aktif">AKTIF</label>
					<input type="checkbox" class="form-control" id="edit_aktif" name="edit_aktif" value="1" >
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

<script>
    $(document).ready(function() {
			var table	    = "", 
				vrpt_id     = "",
				vrate       = "",
				vtahun      = "",
				vaktif      = ""
				;
			
		//$("#btnHapus").hide();
		$("#edit-data").hide();

		filter_by = $("#vaktiv").val();

		console.log('filterby nya ' + filter_by);
					
		 Pace.track(function(){
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: baseURL + 'master/load_rpt',
								 "type" 		: "POST",
								 "data"	: function (d) {		
										d._searchAktiv = filter_by;
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
					{ "data": "rpt_id", "width" : "60px" },
					{ "data": "rate", "class":"text-center" },
					{ "data": "tahun", "class":"text-center" },
					{ "data": "aktif", "class":"text-center" }
				],
                "createdRow": function( row, data, dataIndex ) {
                    
                },
                "columnDefs": [ 
                    {
                        "targets": [ 1],
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Tahun ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vrpt_id			= "";
				vrate		    = "";
				vtahun			= "";
				vaktif		    = "";
				emptyGrid();
				$("#btnEdit,#btnHapus").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d		= table.row( this ).data();
				vrpt_id	    = d.rpt_id;
				vrate		= d.rate;
				vtahun		= d.tahun;
				vaktif		= d.aktif;
				valueGrid();
                $("#btnEdit,#btnHapus").removeAttr('disabled');
			}
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		} );

		$("#vaktiv").on("change", function(){
			filter_by = $("#vaktiv").val();
			table.ajax.reload(null, false);
		});
			
		$('#form-wp').validator().on('submit', function(e) {
		   var vedit_thn =	$('#edit_tahun').val();
           if($('#edit_aktif').is(":checked")){
                $('#edit_aktif').val("1");
           } else {
                $('#edit_aktif').val("0");
           }
			if (e.isDefaultPrevented()) {
				console.log('tidak valid');
			}
			else {
				 $.ajax({
				url		: baseURL + 'master/save_rpt/',
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
					else if (result==3) {
						$("body").removeClass("loading");
						flashnotif('Info', 'Mohon periksa kembali data tahun '+vedit_thn+' rate sudah ada yang aktif','warning');
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
				$("#capAdd").html("<span class='label label-danger'>Edit Data Rate Pajak Tangguhan</span>");
				valueGrid();
					
		});
		
		$("#btnTambah").click(function (){
			$("#list-data").slideUp(700);
			$("#edit-data").slideDown(700);
			$("#isNewRecord").val("1");
			$("#capAdd").html("<span class='label label-danger'>Tambah Data Rate Pajak Tangguhan</span>");
			emptyGrid();
		});

		$("#btnBack").click(function (){
			$("#list-data").slideDown(700);
			$("#edit-data").slideUp(700);
			emptyGrid();
		});
		
	function valueGrid()
	{
		$("#edit_rpt_id").val(vrpt_id);  
		$("#edit_rate").val(vrate);
		$("#edit_tahun").val(vtahun);
        if (vaktif == "Aktif"){
            $("#edit_aktif").prop('checked', true);
        } else {
            $("#edit_aktif").prop('checked', false);
        }
		
	}
	
	function emptyGrid()
	{
		$("#edit_rpt_id").val("");  
		$("#edit_rate").val("");
		$("#edit_tahun").val("");
		$("#edit_aktif").val("");
        $("#edit_aktif").prop('checked', false);
	}
	
	$("#btnHapus").click(function(){
		  bootbox.confirm({
			title: "Hapus Data Rate Pajak <span class='label label-danger'>"+vrate+"</span> ?",
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
						url		: "<?php echo site_url('Master/delete_rpt') ?>",
						type	: "POST",
						data	: ({id:vrpt_id}),
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
	
 });
    </script>
