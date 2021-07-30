<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						CONFIG TARA
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
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>ID</th>
								<th> PARAMETER </th>
                                <th> VALUE </th>
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
				<h2 id="capAdd" class="text-center">Config Tara</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<input type="hidden" class="form-control" id="edit_tara_id" name="edit_tara_id">
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<label>PARAMETER</label>
					<input type="text" class="form-control" id="edit_parameter" name="edit_parameter" placeholder="Parameter *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Parameter" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
        <div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>VALUE</label>
					<input type="text" class="form-control" id="edit_value" name="edit_value" placeholder="Value *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Value" required>
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
				vtara_id     = "",
				vparameter       = "",
				vvalue      = ""
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
								 "url"  		: baseURL + 'tara_pajakku/load_config_tara',
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
					{ "data": "no", "class":"text-center", "width" : "30px" },
					{ "data": "config_tara_id", "width" : "60px" },
					{ "data": "parameter", "class":"text-left" },
                    { "data": "value", "class":"text-left" }
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Parameter ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vtara_id			= "";
				vparameter		    = "";
                vvalue              = "";
				emptyGrid();
				$("#btnEdit,#btnHapus").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d		= table.row( this ).data();
				vtara_id	= d.config_tara_id;
				vparameter	= d.parameter;
                vvalue		= d.value;
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
			if (e.isDefaultPrevented()) {
				console.log('tidak valid');
			}
			else {
				 $.ajax({
				url		: baseURL + 'tara_pajakku/save_config_tara/',
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
						flashnotif('Info', 'Mohon periksa kembali nama parameter ada yang sama','warning');
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
				$("#capAdd").html("<span class='label label-danger'>Edit Data Config Tara</span>");
				valueGrid();
					
		});
		
		$("#btnTambah").click(function (){
			$("#list-data").slideUp(700);
			$("#edit-data").slideDown(700);
			$("#isNewRecord").val("1");
			$("#capAdd").html("<span class='label label-danger'>Tambah Data Config Tara</span>");
			emptyGrid();
		});

		$("#btnBack").click(function (){
			$("#list-data").slideDown(700);
			$("#edit-data").slideUp(700);
			emptyGrid();
		});
		
	function valueGrid()
	{
		$("#edit_tara_id").val(vtara_id);  
		$("#edit_parameter").val(vparameter);
		$("#edit_value").val(vvalue);
		$("#edit_parameter").attr("readonly",true);
	}
	
	function emptyGrid()
	{
		$("#edit_tara_id").val("");  
		$("#edit_parameter").val("");
        $("#edit_value").val("");
		$("#edit_parameter").attr("readonly",false);
	}
	
	$("#btnHapus").click(function(){
		  bootbox.confirm({
			title: "Hapus Data config tara <span class='label label-danger'>"+vparameter+"</span> ?",
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
						url		: "<?php echo site_url('tara_pajakku/delete_config_tara') ?>",
						type	: "POST",
						data	: ({id:vtara_id}),
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
