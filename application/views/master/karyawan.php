<div class="container-fluid">
	<div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo $subtitle ?></h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">MASTER DATA</a></li>
                <li class="active"><?php echo $subtitle ?></li>
            </ol>
        </div>
    </div>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">	
            <div class="panel panel-info">
			<div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								KARYAWAN
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">	
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled data-toggle="modal" data-target="#modal-kw"><i class="fa fa-pencil"></i> EDIT</button>
									<button type="button" id="btnHapus" class="btn btn-rounded btn-default custom-input-width " disabled data-toggle="modal" data-target="#modal-hapus"><i class="fa fa-trash-o"></i> HAPUS</button>
									<button id="btnTambah" class="btn btn-default btn-rounded custom-input-width" data-toggle="modal" data-target="#modal-tambah" type="button" ><i class="fa fa-pencil-square-o"></i> TAMBAH</button>									
									
									
								</div>
							  </div>
							</div>  						   
						</div>
               
                        <!-- /.panel-heading -->
                        <div class="panel-body"> 
							<div class="table-responsive">
                           <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
                                <thead>
                                    <tr>
										<th>NO</th>
                                        <th>PERSON ID </th>
                                        <th>LAST NAME </th>
                                        <th>FULL NAME</th>
                                        <th>EMPLOYEE NUMBER</th>
                                        <th>NATIONAL IDENTIFIER</th>
                                        <th>NPWP</th>
                                        <th>TAX TYPE</th>
                                        <th>TAX MARITAL</th>
										<th>KPP</th>
										<th>DIREKSI</th>
										<th>TAX NPWP NAME</th>
										<th>PERSON TYPE</th>
										<th>HOME BASE</th>
										<th>ADDRESS TYPE</th>
										<th>ADDRESS LINE1</th>
										<th>ADDRESS LINE2</th>
										<th>ADDRESS LINE3</th>
										<th>CITY</th>
										<th>PROVINCE</th>
										<th>COUNTRY</th>
										<th>ZIP</th>
									</tr>
                                </thead>

                            </table>
							</div>
                            <!-- /.table-responsive -->
							
                       </div>
                        <!-- /.panel-body -->						
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
</div>


<!-- Modal -->
<div id="modal-kw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h2 class="modal-title" >Edit</h2>
      </div>
      <div class="modal-body">
        
	<form role="form" id="form-kw-edit">	
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>PERSON ID</label>
					<input type="text" class="form-control" id="person_id" name="person_id" placeholder="Person Id">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>LAST NAME</label>
					<input type="text" 	 class="form-control" id="last_name" name="last_name" placeholder="Nama Karyawan">
				</div>
			</div>
		</div>
				
				
				
		<div class="row">
			<div class="col-lg-6">		
				<div class="form-group">
					<label>EMPLOYEE NUMBER</label>
					<input type="text" class="form-control" id="employee_number" name="employee_number" placeholder="Nomor Karyawan">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>PERSON TYPE</label>
					<input type="text" class="form-control" id="person_type" name="person_type" placeholder="N p w p">
				</div>
			</div>		
				
				<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i>Reset</button>
	
        </div>
      </div>
	</form>
		 <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i>Batal</button>
        <button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i>SAVE</button>
      </div>
    </div>
  </div>
</div>
</div>

		
		<!--Form Tambah-->

<div id="modal-tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h2 class="modal-title" >Tambah</h2>
      </div>
      <div class="modal-body">
     <form role="form" id="form-kw-tambah"> 
	 
		<div class="row">
			<div class="col-lg-6">
			  	<div class="form-group">
					<label>PERSON ID</label>
					<input type="text" class="form-control" id="person_id" name="person_id" placeholder="Person Id(Number) * (Tidak Boleh Kosong)">
				</div>
			</div>	
			<div class="col-lg-6">		
				<div class="form-group">
					<label>LAST NAME</label>
					<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Karywan * (Tidak Boleh Kosong)">
				</div>
			</div>	
		</div>		
				
		<div class="row">
			<div class="col-lg-6">		
				<div class="form-group">
					<label>FULL NAME</label>
					<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name ">
				</div>
			</div>	
			  <div class="col-lg-6">
				<div class="form-group">
					<label>EMPLOYEE NUMBER</label>
					<input type="text" class="form-control" id="employee_number" name="employee_number" placeholder="Employee Number">
				</div>
			  </div>
		</div>		
				
		<div class="row">
		    <div class="col-lg-6">
			  <div class="form-group">
					<label>NATIONAL IDENTIFIER </label>
					<input type="text" class="form-control" id="national_identifier" name="national_identifier" placeholder="NATIONAL IDENTIFIER ">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>NPWP</label>
					<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP)">
				</div>
			</div>	
		</div>		
		
		<div class="row">
		    <div class="col-lg-6">
				<div class="form-group">
					<label>TAX TYPE</label>
					<input type="text" class="form-control" id="tax_type" name="tax_type" placeholder="TAX TYPE">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>TAX MARITAL</label>
					<input type="text" class="form-control" id="tax_marital" name="tax_marital" placeholder="TAX MARITAL">
				</div>
			</div>	
		</div>		
		
		<div class="row">
		    <div class="col-lg-6">
				<div class="form-group">
					<label>KPP</label>
					<input type="text" class="form-control" id="kpp" name="kpp" placeholder="KPP">
				</div>
			</div>	
			  <div class="col-lg-6">
				<div class="form-group">
					<label>DIREKSI</label>
					<input type="text" class="form-control" id="direksi" name="direksi" placeholder="DIREKSI">
				</div>
			 </div>
		</div>	 
				
		<div class="row">
		    <div class="col-lg-6">
				<div class="form-group">
					<label>TAX NPWP NAME</label>
					<input type="text" class="form-control" id="tax_npwp_name" name="tax_npwp_name" placeholder="TAX NPWP NAME">
				</div>
			</div>	
			<div class="col-lg-6">
				<div class="form-group">
					<label>PERSON TYPE</label>
					<input type="text" class="form-control" id="person_type" name="person_type" placeholder="PERSON TYPE * (Tidak Boleh Kosong)">
				</div>
			</div>	
		</div>
		
		<div class="row">
		    <div class="col-lg-6">
				<div class="form-group">
					<label>HOME BASE</label>
					<input type="text" class="form-control" id="home_base" name="home_base" placeholder="HOME BASE">
				</div>
			</div>
				<div class="col-lg-6">
				<div class="form-group">
					<label>ADDRESS TYPE</label>
					<input type="text" class="form-control" id="address_type" name="address_type" placeholder="ADDRESS TYPE">
				</div>
			</div>	
		</div>
		
				
		<div class="row">
		    <div class="col-lg-6">		
				<div class="form-group">
					<label>ADDRESS LINE1</label>
					<input type="text" class="form-control" id="address_line1" name="address_line1" placeholder="ADDRESS LINE1">
				</div>
			</div>	
			  <div class="col-lg-6">
				<div class="form-group">
					<label>ADDRESS LINE2</label>
					<input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="ADDRESS LINE2">
				</div>
			  </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-6">		
				<div class="form-group">
					<label>ADDRESS LINE3</label>
					<input type="text" class="form-control" id="address_line3" name="address_line3" placeholder="ADDRESS LINE3">
				</div>
			</div>	
				<div class="col-lg-6">	
				<div class="form-group">
					<label>CITY </label>
					<input type="text" class="form-control" id="city" name="city" placeholder="CITY">
				</div>
			  </div>	
		</div>

		<div class="row">
		    <div class="col-lg-4">	
				<div class="form-group">
					<label>PROVINCE</label>
					<input type="text" class="form-control" id="province" name="province" placeholder="PROVINCE">
				</div>
			</div>
				<div class="col-lg-4">
				<div class="form-group">
					<label>COUNTRY </label>
					<input type="text" class="form-control" id="country" name="country" placeholder="COUNTRY">
				</div>
			  </div>	
				
			<div class="col-lg-4">
				<div class="form-group">
					<label>ZIP</label>
					<input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP">
				</div>
			</div>
		</div>	
		
				<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i>Reset</button>
			 </form>
             
		
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i>Batal</button>
        <button type="button" class="btn btn-info waves-effect" id="btnSubmit"><i class="fa fa-save"></i>Submit</button>
		</div>
      </div>
    </div>
  </div>
</div> 

<script>
    $(document).ready(function() {
			var table	= "", vperson_id= "",vlast_name= "",vnpwp ="",vperson_type="";		
			
					
		 Pace.track(function(){  
		   $('#tabledata').removeAttr('width').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('master/load_kw'); ?>",
								 "type" 		: "POST",
								 "beforeSend"	: function () {
										
									}
							  },
			 "language"		: {
					"emptyTable"	: "Data Tidak Ditemukan!",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/customer/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "person_id", "class":"text-left", "width" : "60px" },
					{ "data": "last_name" },
					{ "data": "full_name" },
					{ "data": "employee_number" },
					{ "data": "national_identifier" },
					{ "data": "npwp" },
					{ "data": "tax_type" },
					{ "data": "tax_marital" },
					{ "data": "kpp" },
					{ "data": "direksi" },
					{ "data": "tax_npwp_name" },
					{ "data": "person_type" },
					{ "data": "home_base" },
					{ "data": "address_type" },
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
					"targets": [ 1 ],
					"visible": false
				} 
			],			
			//"fixedColumns"		: true,			
			fixedColumns:   {
						leftColumns: 1,
						//rightColumns: 1
        },		
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari NAMA KARYAWAN / NPWP / ID KARYAWAN ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			// eksekusi dilakukan setiap kali tabel ke refresh
			//$("body").removeClass('loading');
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );
		
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ($(this).hasClass('selected') ) {
				$(this).removeClass('selected');				
				vperson_id			= "";
				vlast_name			= "";				
				vemployee_number	= "";
				vperson_type		= "";
				$("#person_id")	.val("");
				$("#last_name") .val("");
				$("#employee_number").val("");
				$("#person_type").val("");
				$("#btnEdit,#btnHapus").attr("disabled",true);
				//$('#modal-kw').removeAttr('id');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d				= table.row( this ).data();
				vperson_id			= d.person_id;
				vlast_name			= d.last_name;				
				vemployee_number	= d.employee_number;
				vperson_type		= d.person_type;
				valueGrid();				
				$("#btnEdit,#btnHapus").removeAttr('disabled');
				//$(".modal").attr("id","modal-kw");
				
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d				= table.row( this ).data();
			vperson_id			= d.person_id;
			vlast_name			= d.last_name;				
			vemployee_number	= d.employee_number;
			vperson_type		= d.person_type;
			valueGrid();							
			$("#btnEdit,#btnHapus").removeAttr('disabled');
			//$(".modal").attr("id","modal-kw");		
			$("#btnEdit").click();	
		} );
		
		$('.modal').on('shown.bs.modal', function () {
			$('#person_id').trigger('focus')
		})
		
		$("#btnSave").click(function(){			
			$.ajax({
				url		: "<?php echo site_url('master/save_kw') ?>",
				type	: "POST",
				data	: $('#form-kw-edit').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-kw").modal("hide");
					},
				success	: function(result){
					if (result==1) {
						 updateRow();		
						 $("body").removeClass("loading");
						flashnotif('Sukses','Data Berhasil di Edit!','success' );			
					} else {
						 $("body").removeClass("loading");
						flashnotif('Error','Data Gagal di Edit!','error' );
					}
					
				}
			});	
				
			return false;
		})
				
		$("#btnEdit").click(function (){
			valueGrid();			
		});
		
	function valueGrid()
	{
		$("#person_id")	 		.val(vperson_id);  
		$("#last_name")			.val(vlast_name);
		$("#employee_number")	.val(vemployee_number);
		$("#person_type") 		.val(vperson_type);
	}
	
	function updateRow()
	{
		var person_id		 	= $("#person_id").val();
		var last_name 			= $("#last_name").val();
		var employee_number 	= $("#employee_number").val();
		var person_type 		= $("#person_type").val();		
		
		table.column(1).data().each( function (value, index) {
			if (value==person_id) {
				 table.cell( index, 5 ).data(last_name);
				 table.cell( index, 6 ).data(employee_number);
				 table.cell( index, 7 ).data(person_type);
			 }
		} );
	}
	
	
							<!--hapus-->
	$("#btnHapus").click(function(){			
			$.ajax({
				url		: "<?php echo site_url('master/delete_kw') ?>",
				type	: "POST",
				data	: ({id:vperson_id}),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-hapus").modal("hide");
					},
				success	: function(result){
					if (result==1) {
						 table.draw();	 /*refresh table*/	
						 $("body").removeClass("loading")
						flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
					} else {
						$("body").removeClass("loading")
						flashnotif('Error','Data Gagal di Hapus!','error' );
					}
					
				}
			});	
				
			return false;
		})
		
										<!--TAMBAH-->
			$("#btnSubmit").click(function(){			
			$.ajax({
				url		: "<?php echo site_url('master/tambah_kw') ?>",
				type	: "POST",
				data	: $('#form-kw-tambah').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-tambah").modal("hide");
					},
				success	: function(result){
					if (result==1) {
						 updateRow();		
						 $("body").removeClass("loading")
						flashnotif('Sukses','Data Berhasil di Tambah!','success' );			
					} else {
						flashnotif('Error','Data Gagal di Tambah!','error' );
					}
					 $("#modal-tambah").modal("hide");
					
				}
			});	
				
			return false;
		})

	
 });
    </script>
