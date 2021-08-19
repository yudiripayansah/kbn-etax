<div class="container-fluid">

	<?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">	
            <div class="panel panel-info">
                <div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								DAFTAR NAMA-NAMA PELANGGAN (CUSTOMER)
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">
									<!-- <button id="btnTambah" class="btn btn-default btn-rounded custom-input-width" data-toggle="modal" data-target="#modal-tambah" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button> -->
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled data-toggle="modal" data-target="#modal-cs"><i class="fa fa-pencil"></i> EDIT</button>
									<button type="button" id="btnHapus" class="btn btn-rounded btn-default custom-input-width " disabled data-toggle="modal" data-target="#modal-cs"><i class="fa fa-trash-o"></i> DELETE</button>											
								</div>
							  </div>
							</div>  						   
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"> 
							<div class="table-responsive">
							<div class="row">
							<div class="col-lg-10">					
								<form role="form" id="form-import" autocomplete="off">
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
							</div>
                           <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
                                <thead>
                                    <tr>
										<th>NO</th>
                                        <th>CUSTOMER ID</th>
                                        <th>NAMA PELANGGAN</th>
                                        <th>ALIAS PELANGGAN</th>
                                        <th>NOMOR PELANGGAN</th>
                                        <th>NPWP</th>
                                        <th>STATUS KSWP</th>
                                        <th>OPERATING UNIT</th>
                                        <th>CUSTOMER SITE ID</th>
                                        <th>CUSTOMER SITE NUMBER</th>
										<th>CUSTOMER SITE NAME</th>
										<th>ALAMAT LINE1</th>
										<th>ALAMAT LINE2</th>
										<th>ALAMAT LINE3</th>
										<th>NAMA KOTA</th>
										<th>PROPINSI</th>
										<th>NEGARA</th>
										<th>KODE POS</th>
									</tr>
                                </thead>

                            </table>
							</div>
                       </div>
                    </div>
                </div>
            </div>
</div>

<!--Form Tambah-->
<div id="edit-data">  
	<div id="error-add" class="alert alert-danger alert-dismissable hidden"></div>	
	<div id="error-edit" class="alert alert-danger alert-dismissable hidden"></div>	      
	<form role="form" id="form-cs-tambah">
	<div class="white-box boxshadow">
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">Data Pelanggan</h2>
			</div>
		</div>		
		<div class="row">
		  <div class="col-lg-6">	
			<div class="form-group">
				<label>NAMA PELANGGAN</label>
				<input type="hidden" class="form-control" id="customer_id" name="customer_id" placeholder="customer ID (Number) * (Tidak Boleh Kosong)">
				<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
				<input type="hidden" class="form-control" id="customer_site_id" name="customer_site_id" placeholder="customer ID (Number) * (Tidak Boleh Kosong)">
				<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Customer *(Tidak Boleh Kosong)">
			</div>
		  </div>	
		
		
		
		  <div class="col-lg-6">
			<div class="form-group">
				<label>ALIAS PELANGGAN</label>
				<input type="text" class="form-control" id="alias_customer" name="alias_customer" placeholder="alias Customer ">
			</div>
		  </div>
		  
		  <div class="row">
		  <div class="col-lg-6">
			<div class="form-group">
				<label>NOMOR PELANGGAN</label>
				<input type="text" class="form-control" id="customer_number" name="customer_number" placeholder="Nomor Customer">
			</div>
		  </div>	
		
		  <div class="col-lg-6">
			<div class="form-group">
				<label>NPWP </label>
				<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP *(Tidak Boleh Kosong)" data-inputmask="'mask': '99.999.999.9-999.999'">
			</div>
		  </div>
		  </div>
		  
		  <div class="row">
		  <div class="col-lg-6">
			<div class="form-group">
				<label>OPERATING UNIT</label>
				<input type="text" class="form-control" id="operating_unit" name="operating_unit" placeholder="OPERATING UNIT">
			</div>
		  </div>	
				
		
		  <div class="col-lg-6">	
			<div class="form-group">
				<label>CUSTOMER SITE NAME</label>
				<input type="text" class="form-control" id="customer_site_name" name="customer_site_name" placeholder="CUSTOMER SITE NAME">
			</div>
		  </div>
		</div>  
		
		
		<div class="row">
		   <div class="col-lg-6">
			<div class="form-group">
				<label>ALAMAT LINE1</label>
				<input type="text" class="form-control" id="address_line1" name="address_line1" placeholder="ADDRESS LINE1 *(Tidak Boleh Kosong)">
			</div>
		   </div>
		
		  <div class="col-lg-6">	
			<div class="form-group">
				<label>ALAMAT LINE2</label>
				<input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="ADDRESS LINE2">
			</div>
		  </div>
		</div>
		
		
		<div class="row">
		  <div class="col-lg-6">
			<div class="form-group">
				<label>ALAMAT LINE3</label>
				<input type="text" class="form-control" id="address_line3" name="address_line3" placeholder="ADDRESS LINE3">
			</div>
		   </div>
		
		  <div class="col-lg-6">
			<div class="form-group">
				<label>NAMA KOTA </label>
				<input type="text" class="form-control" id="city" name="city" placeholder="CITY">
			</div>
		  </div>
		  </div>
		  
		  <div class="row">
		  <div class="col-lg-6">	
			<div class="form-group">
				<label>PROPINSI</label>
				<input type="text" class="form-control" id="province" name="province" placeholder="PROVINCE">
			</div>
		  </div>
		
		
		
		  <div class="col-lg-6">	
			<div class="form-group">
				<label>NEGARA </label>
				<input type="text" class="form-control" id="country" name="country" placeholder="COUNTRY * (Tidak Boleh Kosong)">
			</div>
		  </div>
		  </div>
		  
		  <div class="col-lg-6">
			<div class="form-group">
				<label>KODE POS</label>
				<input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP">
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
					<input type="text" id="djp-nama" disabled class="form-control" data-inputmask="'mask': '99.999.999.9-999.999'">
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
								<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
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
				vcustomer_id		= "",
				vcustomer_name		= "",
				valias_customer 	= "",
				vcustomer_number	= "",
				vnpwp 				= "",
				voperating_unit 	= "",
				vcustomer_site_id	= "",
				vcustomer_site_number =	"",
				vcustomer_site_name	= "",
				vaddress_line1 		= "",
				vaddress_line2 		= "",
				vaddress_line3		= "",
				vcity 				= "",
				vprovince			= "",
				vcountry 			= "",
				vzip 				= "",
				djp = "";		
		
		//$("#btnHapus").hide();		
		$("#edit-data").hide();			
		
		 Pace.track(function(){  
		   $('#tabledata').removeAttr('width').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: "<?php echo site_url('master/load_cs'); ?>",
								 "type" 		: "POST",
								 "beforeSend"	: function () {
										
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
					{ "data": "customer_id", "class":"text-left", "width" : "60px" },
					{ "data": "customer_name" },
					{ "data": "alias_customer" },
					{ "data": "customer_number" },
					{ "data": "npwp" },
					{ "data": "status_kswp" },
					{ "data": "operating_unit" },
					{ "data": "customer_site_id" },
					{ "data": "customer_site_number" },
					{ "data": "customer_site_name" },
					{ "data": "address_line1" },
					{ "data": "address_line2" },
					{ "data": "address_line3" },
					{ "data": "city" },
					{ "data": "province" },
					{ "data": "country" },
					{ "data": "zip" },
					
				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			"columnDefs": [ 
				 {
					"targets": [ 1, 7, 8 ],
					"visible": false
				} 
			],			
			//"fixedColumns"		: true,			
			/* fixedColumns:   {
						leftColumns: 1,
						//rightColumns: 1
        },	 */	
			 "select"			: true,
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();
		
		 /*fungsi tombol x */
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search NAMA customer / NPWP / ID customer ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );
		
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ($(this).hasClass('selected') ) {
				$(this).removeClass('selected');				
				vcustomer_id		= "";
				vcustomer_name		= "";
				valias_customer 	= "";
				vcustomer_number	= "";
				vnpwp 				= "";
				voperating_unit 	= "";
				vcustomer_site_id	= "";
				vcustomer_site_number =	"";
				vcustomer_site_name	= "";
				vaddress_line1 		= "";
				vaddress_line2 		= "";
				vaddress_line3		= "";
				vcity 				= "";
				vprovince			= "";
				vcountry 			= "";
				vzip 				= "";
				djp = "";
				$("#btnEdit,#btnHapus").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d				= table.row( this ).data();
				vcustomer_id		= d.customer_id;
				vcustomer_name		= d.customer_name;
				valias_customer 	= d.alias_customer;
				vcustomer_number	= d.customer_number;
				vnpwp 				= d.npwp;
				voperating_unit 	= d.operating_unit;
				vcustomer_site_id	= d.customer_site_id;
				vcustomer_site_number =	d.customer_site_number;
				vcustomer_site_name	= d.customer_site_name;
				vaddress_line1 		= d.address_line1;
				vaddress_line2 		= d.address_line2;
				vaddress_line3		= d.address_line3;
				vcity 				= d.city;
				vprovince			= d.province;
				vcountry 			= d.country;
				vzip 				= d.zip;		
				djp = d.djp;			
				$("#btnEdit,#btnHapus").removeAttr('disabled');
				valueGrid();
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d				= table.row( this ).data();
			//vcustomer_id		= d.customer_id;
			//$("#btnEdit,#btnHapus").removeAttr('disabled');			
		} );
		
		$('.modal').on('shown.bs.modal', function () {
			$('#customer_id').trigger('focus')
		})

	$("#btnEdit").click(function (){
		$("#list-data").slideUp(700);
		$("#edit-data").slideDown(700);
		$("#isNewRecord").val("0");
		$("#capAdd").html("<span class='label label-danger'>Edit Data Pelanggan</span>");
		valueGrid();			
	});

	$("#btnTambah").click(function (){
		$("#list-data").slideUp(700);
		$("#edit-data").slideDown(700);
		$("#isNewRecord").val("1");
		$("#capAdd").html("<span class='label label-danger'>Tambah Data Pelanggan</span>");
		emptyGrid();			
	});

	$("#btnBack").click(function (){
		$("#list-data").slideDown(700);
		$("#edit-data").slideUp(700);
		emptyGrid();			
	});
	
	function valueGrid()
	{
		$("#customer_id")	 	.val(vcustomer_id);  
		$("#customer_name")		.val(vcustomer_name);
		$("#npwp")		 		.val(vnpwp);
		$("#customer_number") 	.val(vcustomer_number);		
		$("#alias_customer") 	.val(valias_customer);
		$("#operating_unit")	.val(voperating_unit);
		$("#customer_site_id")	.val(vcustomer_site_id);
		$("#customer_site_number")	.val(vcustomer_site_number);
		$("#customer_site_name")	.val(vcustomer_site_name);
		$("#address_line1")		.val(vaddress_line1);
		$("#address_line2")		.val(vaddress_line2);
		$("#address_line3")		.val(vaddress_line3);
		$("#city")				.val(vcity);
		$("#province")			.val(vprovince);
		$("#country")			.val(vcountry);
		$("#zip")				.val(vzip);		
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
		$("#customer_id")	 	.val("");  
		$("#customer_number") 	.val("");		
		$("#customer_name")		.val("");
		$("#alias_customer") 	.val("");
		$("#npwp")		 		.val("");
		$("#operating_unit")	.val("");
		$("#customer_site_id")	.val("");
		$("#customer_site_number")	.val("");
		$("#customer_site_name")	.val("");
		$("#address_line1")		.val("");
		$("#address_line2")		.val("");
		$("#address_line3")		.val("");
		$("#city")				.val("");
		$("#province")			.val("");
		$("#country")			.val("");
		$("#zip")				.val("");		
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
	
	<!--hapus-->
	$("#btnHapus").click(function(){			
		  bootbox.confirm({
			title: "Hapus data pelanggan <span class='label label-danger'>"+vcustomer_name+"</span> ?",
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
						url		: "<?php echo site_url('master/delete_cs') ?>",
						type	: "POST",
						data	: ({customer_id:vcustomer_id, customer_site_id:vcustomer_site_id}),
						beforeSend	: function(){
							 $("body").addClass("loading")
							},
						success	: function(result){
							if (result==1) {
								 table.draw();		
								 emptyGrid();
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
		
	<!--TAMBAH-->
	$("#btnSave").click(function(){			
		$.ajax({
			url		: "<?php echo site_url('master/tambah_cs') ?>",
			type	: "POST",
			data	: $('#form-cs-tambah').serialize(),
			beforeSend	: function(){
				 $("body").addClass("loading")
				},
			success	: function(result){
				if (result==1) {
					 $("body").removeClass("loading");
					$("#list-data").slideDown(700);
					$("#edit-data").slideUp(700);					 
					 emptyGrid();
					 table.draw();
					flashnotif('Sukses','Data Berhasil di Simpan!','success' );			
				} else {
					$("body").removeClass("loading");
					//flashnotif('Error','Data Gagal di Simpan!','error' );
					$('#error-add').attr('style','display: block !important');
					$('#error-add').html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + result);					
				}				
			}
		});	
			
		return false;
	})

	$("#btnEksportCSV").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>master/export_format_csv_customer";
			window.open(urlnya, '_blank');
			window.focus(); 	
	});

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
            url: "<?php echo base_url('Master/import_CSV_customer') ?>",
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

	
 });
    </script>
