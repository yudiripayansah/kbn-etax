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
								PERIODE
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">	
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled data-toggle="modal" data-target="#modal-pr"><i class="fa fa-pencil"></i> EDIT</button>
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
										<th>PERIOD ID</TH>
                                        <th>NAMA PAJAK</th>
                                        <th>MASA PAJAK</th>
                                        <th>BULAN PAJAK</th>
                                        <th>TAHUN PAJAK</th>
                                        <th>STATUS</th>
                                        <th>KODE CABANG</th>
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
<div id="modal-pr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title" id="myLargeModalLabel">Edit Priode</h2> </div>
			<div class="modal-body">
				<form role="form" id="form-pr-edit">	
				  <div class="row">
					<!-- <div class="col-lg-3">
						<div class="form-group">
							<label>Period Id</label>
							<input type="text" class="form-control" id="period_id" name="period_id" placeholder="Period Id">
						</div>
					 </div> -->
					 <div class="col-lg-6">
						<div class="form-group">
							<label>Nama Pajak</label>
							<input type="hidden" class="form-control" id="period_id" name="period_id" placeholder="Nama Pajak">
							<input type="text" class="form-control" id="nama_pajak" name="nama_pajak" placeholder="Nama Pajak">
						</div>
					 </div>
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Masa Pajak</label>
							<input type="text" class="form-control" id="masa_pajak" name="masa_pajak" placeholder="Masa Pajak">
						</div>
					 </div>
					</div>	
					
					<div class="row">
					  <div class="col-lg-6">
						 <div class="form-group">
							<label>Bulan Pajak</label>
						   <input type="text" class="form-control" id="bulan_pajak" name="bulan_pajak" placeholder="Bulan Pajak">
						 </div>	
					   </div>
					  <div class="col-lg-6">
					 <div class="form-group">
							<label>Tahun Pajak</label>
							<input type="text" class="form-control" id="tahun_pajak" name="tahun_pajak" placeholder="Tahun Pajak">
						</div>
					 </div>
					</div>					
						<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>
				</form>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Batal</button>
				<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
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
			<form role="form" id="form-pr-tambah">
				<div class="row">
					  <div class="col-lg-3">
						<div class="form-group">
							<label>PERIOD ID</label>
							<input type="text" class="form-control" id="period_id" name="period_id" placeholder="Period Id *">
						</div>
					  </div>
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Nama Pajak</label>
							<input type="text" class="form-control" id="nama_pajak" name="nama_pajak" placeholder="Nama Pajak *">
						</div>
					  </div>
					  <div class="col-lg-3">
						<div class="form-group">
							<label>Masa Pajak</label>
							<input type="text" class="form-control" id="masa_pajak" name="masa_pajak" placeholder="Masa Pajak *">
						</div>
					 </div>
				</div>
				<div class="row">
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Bulan Pajak</label>
							<input type="text" class="form-control" id="bulan_pajak" name="bulan_pajak" placeholder="Bulan Pajak *">
						</div>
					 </div>
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Tahun Pajak</label>
							<input type="text" class="form-control" id="tahun_pajak" name="tahun_pajak" placeholder="Tahun Pajak *">
						</div>
					 </div>
				</div>

				<div class="row">
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" id="status" name="status" placeholder="Status">
						</div>
					 </div>
					  <div class="col-lg-6">
						<div class="form-group">
							<label>Kode Cabang</label>
							<input type="text" class="form-control" id="kode_cabang" name="kode_cabang" placeholder="Kode Cabang">
						</div>
					 </div>
				</div>	
		
			</form>
			<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i>Reset</button>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i>Batal</button>
        <button type="button" class="btn btn-info waves-effect" id="btnSubmit"><i class="fa fa-save"></i>Submit</button>
      </div>
    </div>
  </div>
</div> 

<script>
    $(document).ready(function() {
			var table	= "", vperiod_id= "", vnama_pajak= "",vmasa_pajak= "",vbulan_pajak="",vtahun_pajak="";		
			
					
		 Pace.track(function(){  
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('master/load_pr'); ?>",
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
					{ "data": "period_id", "class":"text-left", "width" : "60px"  },
					{ "data": "nama_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "status" },
					{ "data": "kode_cabang" }
					
				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			/* "columnDefs": [ 
				 {
					"targets": [ 1 ],
					"visible": false
				} 
			],		 */	
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari ID / NAMA PAJAK / BULAN PAJAK ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
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
				vperiod_id		= "";
				vnama_pajak		= "";
				vmasa_pajak		= "";				
				vbulan_pajak	= "";
				vtahun_pajak	= "";
				$("#period_id").val("");
				$("#nama_pajak").val("");
				$("#masa_pajak").val("");
				$("#bulan_pajak").val("");
				$("#tahun_pajak").val("");
				$("#btnEdit,#btnHapus").attr("disabled",true);
				//$('#modal-tx').removeAttr('id');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			= table.row( this ).data();
				vperiod_id		= d.period_id;
				vnama_pajak		= d.nama_pajak;
				vmasa_pajak		= d.masa_pajak;				
				vbulan_pajak	= d.bulan_pajak;
				vtahun_pajak	= d.tahun_pajak;
				valueGrid();				
				$("#btnEdit,#btnHapus").removeAttr('disabled');
				//$(".modal").attr("id","modal-tx");
				
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			= table.row( this ).data();
				vperiod_id		= d.period_id;
				vnama_pajak		= d.nama_pajak;
				vmasa_pajak		= d.masa_pajak;				
				vbulan_pajak	= d.bulan_pajak;
				vtahun_pajak	= d.tahun_pajak;
				valueGrid();											
			$("#btnEdit,#btnHapus").removeAttr('disabled');
			//$(".modal").attr("id","modal-tx");		
			$("#btnEdit").click();	
		} );
		
		$('.modal').on('shown.bs.modal', function () {
			$('#period_id').trigger('focus')
		})
		
		$("#btnSave").click(function(){			
			$.ajax({
				url		: "<?php echo site_url('master/save_pr') ?>",
				type	: "POST",
				data	: $('#form-pr-edit').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-pr").modal("hide");
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
		$("#period_id").val(vperiod_id);
		$("#nama_pajak").val(vnama_pajak);  
		$("#masa_pajak").val(vmasa_pajak);
		$("#bulan_pajak").val(vbulan_pajak);
		$("#tahun_pajak").val(vtahun_pajak);
	}
	
	function updateRow()
	{
		var period_id	= $("#period_id").val();
		var nama_pajak	= $("#nama_pajak").val();
		var masa_pajak 	= $("#masa_pajak").val();
		var bulan_pajak = $("#bulan_pajak").val();
		var tahun_pajak = $("#tahun_pajak").val();		
		
		table.column(1).data().each( function (value, index) {
			if (value==period_id) {
				 table.cell( index, 2 ).data(nama_pajak);
				 table.cell( index, 3 ).data(masa_pajak);
				 table.cell( index, 4 ).data(bulan_pajak);
				 table.cell( index, 5 ).data(tahun_pajak);
			 }
		} );
	}
	
	
							<!--hapus-->
	$("#btnHapus").click(function(){	
	
			$.ajax({
				url		: "<?php echo site_url('master/delete_pr')?>",
				type	: "POST",
				data	: ({id:vperiod_id}),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-hapus").modal("hide");
					},
				success	: function(result){
					if (result==1) {
						 table.draw();/*refresh table*/	
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
				url		: "<?php echo site_url('master/tambah_pr') ?>",
				type	: "POST",
				data	: $('#form-pr-tambah').serialize(),
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
