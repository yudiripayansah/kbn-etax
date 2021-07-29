<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						BEBAN TANTIEM
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
								<label>Filter by Divisi</label>
								<select id="divisi" name="divisi">
									<option value="">-- Pilih Divisi --</option>
									<option value="BOD"> BOD </option>
									<option value="BOC"> BOC </option>
									<option value="PKWT"> PKWT </option>
								</select>
							</div>
							<br>
						<?php endif; ?>
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th>NO</th>
							    <th>BEBAN TANTIEM ID</th>
								<th>NAMA</th>
								<th>HARI</th>
								<th>JUMLAH TANTIEM</th>
								<th>PAJAK </th>
								<th>JUMLAH DI TERIMA</th>
								<th>TAHUN</th>
								<th>DIVISI</th>
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
				<h2 id="capAdd" class="text-center">Beban Tantiem</h2>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
				<input type="hidden" class="form-control" id="edit_beban_tantiem_id" name="edit_beban_tantiem_id">
				<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<label>DIVISI</label>
                        <select id="edit_divisi" name="edit_divisi" placeholder="Divisi *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Divisi " required>
                            <option value="">-- Pilih Divisi --</option>
                            <option value="BOD"> BOD </option>
                            <option value="BOC"> BOC </option>
                            <option value="PKWT"> PKWT </option>
                        </select>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				<label>NAMA</label>
						<select class="form-control" id="edit_nama" name="edit_nama">
							<option value="" data-name="" ></option>
						</select> 
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
				<label>HARI</label>
					<input type="text" class="form-control" id="edit_hari" name="edit_hari" placeholder="HARI *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Hari" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				<label>JUMLAH TANTIEM</label>
					<input type="number" class="form-control" id="edit_jumlah_tantiem" name="edit_jumlah_tantiem" min="1" max="999999999999999" step="0.01"  placeholder="Jumlah Tantiem *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Jumlah Tantiem" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
				<label>PAJAK</label>
					<input type="number" class="form-control" id="edit_pajak" name="edit_pajak" min="1" max="999999999999999" step="0.01" placeholder="Pajak" data-error="Mohon isi Jumlah Pajak" required>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
				<label>TAHUN</label>
					<select class="form-control" id="edit_tahun" name="edit_tahun" id="edit_tahun" name="edit_tahun"  placeholder="Tahun" data-error="Mohon isi Tahun" required>
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
			var table	= "", 
				vbeban_tantiem_id          = "",
				vnama        = "",
				vhari              = "",
				vjumlah_tantiem      = "",
				vpajak = "",
				vjumlah_diterima  = "",
				vtahun  = "",
				vdivisi  = ""
				;
				getConfigTantiem();	
		//$("#btnHapus").hide();
		$("#edit-data").hide();

		filter_by = $("#divisi").val();

		console.log('filterby nya ' + filter_by);
					
		 Pace.track(function(){
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: false,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: baseURL + 'pph_badan/load_beban_tantiem',
								 "type" 		: "POST",
								 "data"	: function (d) {		
										d._searchDivisi = filter_by;
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
					{ "data": "beban_tantiem_id","width" : "60px" },
					{ "data": "nama" },
					{ "data": "hari", "class":"text-center" },
					{ "data": "jumlah_tantiem", "class":"text-right" },
					{ "data": "pajak", "class":"text-right" },
					{ "data": "jumlah_diterima", "class":"text-right" },
					{ "data": "tahun", "class":"text-center" },
					{ "data": "divisi", "class":"text-center" }
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search NAMA ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
			
		} );

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vbeban_tantiem_id	= "";
				vnama				= "";
				vhari				= "";
				vjumlah_tantiem		= "";
				vpajak 				= "";
				vjumlah_diterima 	= "";
				vdivisi 			= "";
				vtahun				= "";
				emptyGrid();
				$("#btnEdit,#btnHapus").attr("disabled",true);
				
				//$('#modal-wp').removeAttr('id');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d						= table.row( this ).data();
				vbeban_tantiem_id			= d.beban_tantiem_id;
				vnama		                = d.nama;
				vhari						= d.hari;
				vjumlah_tantiem				= d.jumlah_tantiem;
				vpajak 						= d.pajak;
				vjumlah_diterima 			= d.jumlah_diterima;
				vdivisi 					= d.divisi ;
				vtahun						= d.tahun;
				
				valueGrid();

				$("#btnEdit,#btnHapus").removeAttr('disabled');
			}
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		} );

		$("#divisi").on("change", function(){
			filter_by = $("#divisi").val();
			table.ajax.reload(null, false);
		});
			
		$('#form-wp').validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) {
				console.log('tidak valid');
			}
			else {
				 $.ajax({
				url		: baseURL + 'beban_tantiem/save_bebantantiem/',
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
						flashnotif('Info', 'Nama, Divisi dan Tahun Tidak boleh sama dengan data yang sudah ditambahkan','warning');
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
            $("#capAdd").html("<span class='label label-danger'>Edit Data Beban Tantiem</span>");
            valueGrid();			
		});
		
		$("#btnTambah").click(function (){
			$("#list-data").slideUp(700);
			$("#edit-data").slideDown(700);
			$("#isNewRecord").val("1");
			$("#capAdd").html("<span class='label label-danger'>Tambah Beban Tantiem</span>");
			emptyGrid();
			getConfigTantiem();
		});

		$("#btnBack").click(function (){
			$("#list-data").slideDown(700);
			$("#edit-data").slideUp(700);
			emptyGrid();
		});
		
	function valueGrid()
	{
		$("#edit_beban_tantiem_id").val(vbeban_tantiem_id);  
		$("#edit_nama").val(vnama);
		$("#edit_hari").val(vhari);
		$("#edit_jumlah_tantiem").val(vjumlah_tantiem.replace(/,/g, ''));
		$("#edit_pajak").val(vpajak.replace(/,/g, ''));
		$("#edit_jumlah_diterima").val(vjumlah_diterima);
		$("#edit_divisi").val(vdivisi);
		$("#edit_tahun").val(vtahun);
	}
	
	function emptyGrid()
	{
        $("#edit_beban_tantiem_id").val("");  
		$("#edit_nama").val("");
		$("#edit_hari").val("");
		$("#edit_jumlah_tantiem").val("");
		$("#edit_pajak").val("");
		$("#edit_jumlah_diterima").val("");
		$("#edit_divisi").val("");
		$("#edit_tahun").val("");
	}
	
	$("#btnHapus").click(function(){
		  bootbox.confirm({
			title: "Hapus Data Beban Tantiem <span class='label label-danger'>"+vnama+"</span> ?",
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
						url		: "<?php echo site_url('beban_tantiem/delete_bt') ?>",
						type	: "POST",
						data	: ({id:vbeban_tantiem_id}),
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

	function getConfigTantiem()
	{
		$.ajax({
				url		: "<?php echo site_url('Beban_tantiem/load_combo_tantiem') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#edit_nama").html("");					
					$("#edit_nama").html(result);					
				}
		});			
	}
	
 });
    </script>
