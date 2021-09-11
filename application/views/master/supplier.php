<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						DAFTAR SUPPLIER
					  </div>
					  <div class="col-lg-6">
						<div class="navbar-right">
							<!-- <button id="btnTambah" class="btn btn-default btn-rounded custom-input-width" data-toggle="modal" data-target="#modal-tambah" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button> -->
							<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled data-toggle="modal" data-target="#modal-wp"><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnHapus" class="btn btn-rounded btn-default custom-input-width " disabled data-toggle="modal" data-target="#modal-hapus"><i class="fa fa-trash-o"></i> DELETE</button>
						</div>
					  </div>
					</div>
				</div>
                
				<div class="panel-body"> 
					<div class="table-responsive">
						<div class="row">
							<div class="col-lg-10">					
								<form role="form" id="form-import" autocomplete="off" class="row no-gutters">
									<div class="col-lg-9">	
										<div class="form-group">
											<label class="form-control-label">File CSV</label>
											<div class="fileinput fileinput-new input-group" data-provides="fileinput">
												<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
												<input type="file" id="file_csv" name="file_csv"> </span> <a id="aRemoveCSV" href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
											<input type="hidden" class="form-control" id="uplPph" name="uplPph" value="PPH BADAN">						
										</div>
									</div>						  
									<div class="col-lg-3">	
										<div class="form-group">
										<label>&nbsp;</label>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button" disabled ><i class="fa fa-sign-in"></i> <span>Import CSV</span></button>
											</div>
										</div>
									</div>	  
								</form>
							</div>
							<div class="col-lg-2">	
								<div class="form-group">
									<label>&nbsp;</label>
									<button id="btnEksportCSV" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" > 
									<i class="fa fa-file-o"></i> <span>EXPORT</span></button>
								</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<?php if ($this->session->userdata('kd_cabang') == "000"): ?>
								<div class="form-group">
									<label class="control-label">Filter by Cabang</label>
									<select id="cabang" name="cabang" class="form-control">
										<?php $list_cabang = get_list_cabang(); ?>
										<option value="">-- Pilih Cabang --</option>
										<?php foreach ($list_cabang as $cabang):?>
										<option value="<?php echo $cabang['KODE_CABANG'] ?>"> <?php echo $cabang['NAMA_CABANG'] ?> </option>
										<?php endforeach?>
									</select>
								</div>
								<?php endif; ?>
							</div>
							<div class="col-xs-3">
								<div class="form-group" style="margin-bottom: 0;">
									<label for="filter-status-kswp" id="lbl-filter-kswp"class="control-label">by Status KSWP</label>
									<select id="filter-status-kswp" class="form-control">
										<option value="SEMUA">SEMUA</option>
										<?php
										foreach ($status_kswp as $key => $sk) {
											echo '<option value="'.$sk->STATUS_KSWP.'">'.$sk->STATUS_KSWP.'</option>';
										}
										?>
									</select>
								</div>
							</div>	 
						</div>
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>VENDOR ID</th>
								<th>NAMA VENDOR</th>
								<th>NOMOR VENDOR</th>
								<th>KODE VENDOR </th>
								<th>NPWP</th>
								<th>STATUS KSWP</th>
								<th>UNIT OPERASI</th>
								<th>ID VENDOR</th>
								<th>TIPE VENDOR</th>
								<th>ALAMAT LINE1</th>
								<th>ALAMAT LINE2</th>
								<th>ALAMAT LINE3</th>
								<th>KOTA</th>
								<th>PROVINSI</th>
								<th>NEGARA</th>
								<th>KODE POS</th>
								<th>KODE AREA </th>
								<th>No. TELEPHONE</th>
								<th>ID ORGANISASI</th>
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
				<h2 id="capAdd" class="text-center">Data Supplier</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<input type="hidden" class="form-control" id="edit_vendor_id" name="edit_vendor_id">
					<input type="hidden" class="form-control" id="edit_vendor_site_id" name="edit_vendor_site_id">
					<input type="hidden" class="form-control" id="edit_organization_id" name="edit_organization_id">
					<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
					<label>NAMA SUPPLIER</label>
					<input type="text" class="form-control" id="edit_vendor_name" name="edit_vendor_name" placeholder="Nama Supplier *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Nama Supplier" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>NOMOR SUPPLIER</label>
					<input type="text" class="form-control" id="edit_vendor_num" name="edit_vendor_num" placeholder="NOMOR SUPPLIER" disabled>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>NPWP</label>
					<input type="text" class="form-control" id="edit_npwp" name="edit_npwp" placeholder="NPWP *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi NPWP" required data-inputmask="'mask': '99.999.999.9-999.999'">
					<div class="help-block with-errors"></div>
				</div>
			</div>
		
			<div class="col-lg-6">
				<div class="form-group">
					<label>ALAMAT LINE 1</label>
					<input type="text" class="form-control" id="edit_alamat_vendor_satu" name="edit_alamat_vendor_satu" placeholder="Alamat Supplier *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi NPWP" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>ALAMAT LINE 2</label>
					<input type="text" class="form-control" id="edit_alamat_vendor_dua" name="edit_alamat_vendor_dua" placeholder="Alamat Supplier(lanjutan)">
				</div>
			</div>
	   <div class="col-lg-6">
				<div class="form-group">
					<label>ALAMAT LINE 3</label>
					<input type="text" class="form-control" id="edit_alamat_vendor_tiga" name="edit_alamat_vendor_tiga" placeholder="Alamat Supplier(lanjutan)">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>NAMA KOTA</label>
					<input type="text" class="form-control" id="edit_kota" name="edit_kota" placeholder="Nama Kota">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>PROPINSI</label>
					<input type="text" class="form-control" id="edit_propinsi" name="edit_propinsi" placeholder="Nama Propinsi">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>NEGARA</label>
					<input type="text" class="form-control" id="edit_negara" name="edit_negara" placeholder="Nama Negara" value="Indonesia">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label>KODE POS</label>
					<input type="text" class="form-control" id="edit_kode_pos" name="edit_kode_pos" placeholder="Kode Pos">
				</div>
			</div>
		
			<div class="col-lg-4">
				<div class="form-group">
					<label>No. Telp</label>
					<input type="text" class="form-control" id="edit_telp" name="edit_telp" placeholder="No. Telp">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h3>Data DJP</h3>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>NPWP</label>
					<input type="text" id="djp-npwp" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Nama</label>
					<input type="text" id="djp-nama" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Merk Dagang</label>
					<input type="text" id="djp-merkdagang" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Alamat</label>
					<input type="text" id="djp-alamat" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Kelurahan</label>
					<input type="text" id="djp-kelurahan" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Kecamatan</label>
					<input type="text" id="djp-kecamatan" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Kabkot</label>
					<input type="text" id="djp-kabkot" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Provinsi</label>
					<input type="text" id="djp-provinsi" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Kode KLU</label>
					<input type="text" id="djp-kodeklu" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>KLU</label>
					<input type="text" id="djp-klu" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Telp</label>
					<input type="text" id="djp-telp" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Email</label>
					<input type="text" id="djp-email" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Jenis WP</label>
					<input type="text" id="djp-jeniswp" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Badan Hukum</label>
					<input type="text" id="djp-badanhukum" disabled class="form-control">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label>Status Kswp</label>
					<input type="text" id="djp-statuskswp" disabled class="form-control">
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
				vvendor_id          = "",
				vvendor_name        = "",
				vnpwp               = "",
				vvendor_number      = "",
				valamat_vendor_satu = "",
				valamat_vendor_dua  = "",
				valamat_vendor_tiga = "",
				vvendor_site_id     = "",
				vorganization_id    = "",
				vkota               = "",
				vpropinsi           = "",
				vnegara             = "",
				vkode_pos           = "",
				vtelp               = "",
				djp               = ""
				;
			
		//$("#btnHapus").hide();
		$("#edit-data").hide();
		<?php if (($this->session->userdata('kd_cabang') == "000")): ?>
			var conCabang = "pusat";
			$("#lbl-filter-kswp").text('by Status KSWP');
		<?php else: ?>
			var conCabang = "cabang";
			$("#lbl-filter-kswp").text('Filter by Status KSWP');
		<?php endif; ?>

		filter_by = $("#cabang").val();
		filter_status_kswp = $("#filter-status-kswp").val();

		console.log('filterby nya ' + filter_by);
					
		 Pace.track(function(){
		   $('#tabledata').removeAttr('width').DataTable({
			"serverSide"	: true,
			//"processing"	: true,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: baseURL + 'master/load_wpp',
								 "type" 		: "POST",
								 "data"	: function (d) {		
										d._searchCabang = filter_by;
										d._searchStatusKswp = filter_status_kswp;
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
					{ "data": "vendor_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_name" },
					{ "data": "vendor_number" },
					{ "data": "vendor_type_lookup_code" },
					{ "data": "npwp" },
					{ "data": "status_kswp" },
					{ "data": "operating_unit" },
					{ "data": "vendor_site_id" },
					{ "data": "vendor_site_code" },
					{ "data": "address_line1" },
					{ "data": "address_line2" },
					{ "data": "address_line3" },
					{ "data": "city" },
					{ "data": "province" },
					{ "data": "country" },
					{ "data": "zip" },
					{ "data": "area_code" },
					{ "data": "phone" },
					{ "data": "organization_id" }
				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			"columnDefs": [ 
				 {
					"targets": [ 1, 7, 8,18 ],
					"visible": false
				} 
			],			
			 fixedColumns:   {
						leftColumns: 1,
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search NAMA VENDOR / NPWP / ID VENDOR ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
				if(conCabang == "pusat"){
					$("#btnEdit,#btnHapus").removeAttr('disabled');
				}
				else{
					if(d.vendor_id >= '5000000'){
						$("#btnEdit,#btnHapus").removeAttr('disabled');
					}
					else{
						$("#btnEdit").attr('disabled');
					}
				}
		} );

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vvendor_id			= "";
				vvendor_name		= "";
				vnpwp				= "";
				vvendor_number		= "";
				valamat_vendor_satu = "";
				valamat_vendor_dua 	= "";
				valamat_vendor_tiga = "";
				vvendor_site_id		= "";
				vorganization_id	= "";
				vkota				= "";
				vpropinsi			= "";
				vnegara				= "";
				vkode_pos			= "";
				vtelp				= "";
				djp				= "";
				emptyGrid();
				$("#btnEdit,#btnHapus").attr("disabled",true);
				//$('#modal-wp').removeAttr('id');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d		= table.row( this ).data();
				vvendor_id			= d.vendor_id;
				vvendor_name		= d.vendor_name;
				vnpwp				= d.npwp;
				vvendor_number		= d.vendor_number;
				valamat_vendor_satu = d.address_line1;
				valamat_vendor_dua 	= d.address_line2;
				valamat_vendor_tiga = d.address_line3;
				vvendor_site_id		= d.vendor_site_id;
				vorganization_id	= d.organization_id;
				vkota				= d.city;
				vpropinsi			= d.province;
				vnegara				= d.country;
				vkode_pos			= d.zip;
				vtelp				= d.phone;
				djp = d.djp
				valueGrid();

				if(conCabang == "pusat"){
					$("#btnEdit,#btnHapus").removeAttr('disabled');
				}
				else{
					if(d.vendor_id >= '5000000'){
						$("#btnEdit,#btnHapus").removeAttr('disabled');
					}
					else{
						$("#btnEdit").attr('disabled');
					}
				}
			}
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		} );

		$("#cabang").on("change", function(){
			filter_by = $("#cabang").val();
			table.ajax.reload(null, false);
		});

		$("#filter-status-kswp").on("change", function(){
			filter_status_kswp = $("#filter-status-kswp").val();
			table.ajax.reload(null, false);
		});
			
		/*$("#btnSave").click(function(){
			$.ajax({
				url		: "<?php echo site_url('Master/save_wpp') ?>",
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
						 emptyGrid();
						 table.draw();
						flashnotif('Sukses','Data Berhasil di simpan!','success' );
					} else {
						$("body").removeClass("loading");
						$('#error-add').attr('style','display: block !important');
						$('#error-add').html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + result);
						
					}
				}
			});
		})
*/
		$('#form-wp').validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) {
				console.log('tidak valid');
			}
			else {
				 $.ajax({
				url		: baseURL + 'master/save_supplier/',
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
						flashnotif('Info', 'NPWP Tidak boleh sama dengan data yang sudah ditambahkan','warning');
					} 
					else if (result==4) {
						$("body").removeClass("loading");
						flashnotif('Info', 'Nama dan NPWP Tidak boleh sama dengan data yang sudah ditambahkan','warning');
					} else {
						$("body").removeClass("loading");
						flashnotif('Error', result,'error');
					}
				}
			});
			}
			e.preventDefault();
		});
		
		$("#btnEdit").click(function (event){

			if(conCabang == "cabang" && vvendor_id < '5000000'){
			  	event.preventDefault();
				$("#btnEdit,#btnHapus").attr('disabled');
			}
			else{
				$("#list-data").slideUp(700);
				$("#edit-data").slideDown(700);
				$("#isNewRecord").val("0");
				$("#capAdd").html("<span class='label label-danger'>Edit Data Supplier</span>");
				valueGrid();
			}			
		});
		
		$("#btnTambah").click(function (){
			$("#list-data").slideUp(700);
			$("#edit-data").slideDown(700);
			$("#isNewRecord").val("1");
			$("#capAdd").html("<span class='label label-danger'>Tambah Data Supplier</span>");
			emptyGrid();
		});

		$("#btnBack").click(function (){
			$("#list-data").slideDown(700);
			$("#edit-data").slideUp(700);
			emptyGrid();
		});
		
	function valueGrid()
	{
		$("#edit_vendor_id").val(vvendor_id);  
		$("#edit_vendor_name").val(vvendor_name);
		$("#edit_npwp").val(vnpwp);
		$("#edit_alamat_vendor_satu").val(valamat_vendor_satu);
		$("#edit_alamat_vendor_dua").val(valamat_vendor_dua);
		$("#edit_alamat_vendor_tiga").val(valamat_vendor_tiga);
		$("#edit_vendor_site_id").val(vvendor_site_id);
		$("#edit_organization_id").val(vorganization_id);
		$("#edit_vendor_num").val(vvendor_number);
		$("#edit_kota").val(vkota);
		$("#edit_propinsi").val(vpropinsi);
		$("#edit_negara").val(vnegara);
		$("#edit_kode_pos").val(vkode_pos);
		$("#edit_telp").val(vtelp);
		$("#djp-npwp").val(djp.NPWP);
		$("#djp-nama").val(djp.NAMA);
		$("#djp-merkdagang").val(djp.MERK_DAGANG);
		$("#djp-alamat").val(djp.ALAMAT);
		$("#djp-kelurahan").val(djp.KELURAHAN);
		$("#djp-kecamatan").val(djp.KECAMATAN);
		$("#djp-kabkot").val(djp.KABKOT);
		$("#djp-provinsi").val(djp.PROVINSI);
		$("#djp-kodeklu").val(djp.KODE_KLU);
		$("#djp-klu").val(djp.KLU);
		$("#djp-telp").val(djp.TELP);
		$("#djp-email").val(djp.EMAIL);
		$("#djp-jeniswp").val(djp.JENIS_WP);
		$("#djp-badanhukum").val(djp.BADAN_HUKUM);
		$("#djp-statuskswp").val(djp.STATUS_KSWP);
	}
	
	function emptyGrid()
	{
		$("#edit_vendor_id").val("");  
		$("#edit_vendor_name").val("");
		$("#edit_npwp").val("");
		$("#edit_alamat_vendor_satu").val("");
		$("#edit_alamat_vendor_dua").val("");
		$("#edit_alamat_vendor_tiga").val("");
		$("#edit_vendor_site_id").val("");
		$("#edit_organization_id").val("");
		$("#edit_vendor_num").val("");
		$("#edit_kota").val("");
		$("#edit_propinsi").val("");
		$("#edit_negara").val("");
		$("#edit_kode_pos").val("");
		$("#edit_telp").val("");
		$("#djp-npwp").val("");
		$("#djp-nama").val("");
		$("#djp-merkdagang").val("");
		$("#djp-alamat").val("");
		$("#djp-kelurahan").val("");
		$("#djp-kecamatan").val("");
		$("#djp-kabkot").val("");
		$("#djp-provinsi").val("");
		$("#djp-kodeklu").val("");
		$("#djp-klu").val("");
		$("#djp-telp").val("");
		$("#djp-email").val("");
		$("#djp-jeniswp").val("");
		$("#djp-badanhukum").val("");
		$("#djp-statuskswp").val("");
	}
	
	$("#btnHapus").click(function(){
		  bootbox.confirm({
			title: "Hapus Data Supplier <span class='label label-danger'>"+vvendor_name+"</span> ?",
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
						url		: "<?php echo site_url('Master/delete_wpp') ?>",
						type	: "POST",
						data	: ({id:vvendor_id,site_id:vvendor_site_id,org_id:vorganization_id}),
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

	$("#file_csv").on("change", function () {
        if($(this).val()==""){
			$("#btnImportCSV").attr("disabled",true);
		} else {
			$("#btnImportCSV").removeAttr("disabled");
		}
    });

	$("#btnImportCSV").click(function(){       
        var form = $('#form-import')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('Master/import_CSV_supplier') ?>",
            data: data,
			dataType:"json", 
			beforeSend	: function(){
				 $("body").addClass("loading");					
			},
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {				
				var result	= data.st;	
				if (result==1) {
                    table.ajax.reload();
					$("body").removeClass("loading"); 
					flashnotif('Sukses','Data Berhasil di Import!','success' );	                    
					$("#aRemoveCSV").click();
                } else if(result==2){
					$("body").removeClass("loading");
					flashnotif('Info','File Import CSV belum dipilih!','warning' );	
				} else if(result==3){
					$("body").removeClass("loading");
					flashnotif('Info','Format File Bukan CSV!','warning' );						
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Data Gagal di Import!','error' );
                }
            }
        });
    });

	$("#btnEksportCSV").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>master/export_format_csv_supplier";
			var vcabang      = $("#cabang").val();
			window.open(urlnya+'?vcabang='+vcabang, '_blank');
			window.focus(); 	
	});
	
 });
    </script>
