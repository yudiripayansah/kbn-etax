<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
	
	<div class="white-box boxshadow">	
		<div class="row">
		<div class="col-lg-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx" name="cabang_trx">									
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
			 <div class="col-lg-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="" >-- Pilih --</option> 
						<option value="PPN WAPU" data-name="PPN WAPU" >PPN WAPU</option>
					</select> 
				</div>
			 </div>
			 <div class="col-sm-2">
				<div class="form-group">
					<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="0" selected >0</option> 
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
			 </div>
			 <div class="col-lg-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>
				</div>
			  </div> 
			 
		</div>			
	 </div>
	 
	<div class="row">
                <div class="col-lg-12">	                  
					 <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
							<div class="row">								
								  <div class="col-lg-6">
									Daftar Bukti Potong
								  </div>
								  <div class="col-lg-6">									
									<button type="button" id="btnClosing" class="btn btn-block btn-rounded btn-default custom-input-width navbar-right" disabled>Close</button>
								  </div>								
							</div>
							</div>
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PARAMS</th>
													<th>NAMA PAJAK</th>
													<th>MASA PAJAK</th>
													<th>BULAN PAJAK</th>
													<th>TAHUN PAJAK</th>
													<th>PEMBETULAN KE</th>
													<th>CABANG</th>
													<th>STATUS</th>													
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>						
					</div>
                </div>                
            </div>

</div>


<script>
    $(document).ready(function() {
    	getSelectCabang();
		var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vtahun="",vidx="", vmasa="", vpembetulan="", vcabang="";
		Pace.track(	function(){		
		  $('#tabledata').DataTable({
		    "serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_closing'); ?>",
								 "type" 		: "POST",
								 "data"			: function ( d ) {										
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#cabang_trx').val();
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
					{ "data": "params", "class":"text-center" },
					{ "data": "nama_pajak", "class":"text-left"},
					{ "data": "masa_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "pembetulan_ke" },
					{ "data": "cabang" },
					{ "data": "status", "class":"text-center" }
				],			
			"columnDefs": [ 
				 {
					"targets": [ 1,7 ],
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Masa / Status ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vstatus		= "";
				vnama		= "";
				vbulan      = "";
				vmasa	    = "";
				vtahun		= "";
				vpembetulan = "";
				vcabang 	= "";
				$("#btnClosing").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');	
				var d	= table.row( this ).data();
				vstatus		= d.params;
				if (vstatus=="Open"){
					$("#btnClosing").removeAttr('disabled');
					vidx		= table.row( this ).index();
					vnama		= d.nama_pajak;
					vbulan      = d.bulan_pajak;
					vmasa      	= d.masa_pajak;
					vtahun		= d.tahun_pajak;
					vpembetulan	= d.pembetulan_ke;
					vcabang		= d.cabang;
				} else {
					$("#btnClosing").attr("disabled",true);
					vidx		= "";
					vnama		= "";
					vbulan      = "";
					vmasa	    = "";
					vtahun		= "";
					vpembetulan	= "";
					vcabang		= "";
				}				
			}								 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');	
			var d	= table.row( this ).data();
			vstatus		= d.params;
			if (vstatus=="Open"){
				$("#btnClosing").removeAttr('disabled');
				vidx		= table.row( this ).index();
				vnama		= d.nama_pajak;
				vbulan      = d.bulan_pajak;
				vmasa	    = d.masa_pajak;
				vtahun		= d.tahun_pajak;
				vpembetulan	= d.pembetulan_ke;
				vcabang		= d.cabang;
			} else {
				$("#btnClosing").attr("disabled",true);
				vidx		= "";
				vnama		= "";
				vbulan      = "";
				vmasa	    = "";
				vtahun		= "";
				vpembetulan = "";
				vcabang 	= "";
			}
			
		} );
		
		$("#btnView").on("click", function(){		
			table.ajax.reload();		
		});
	
		$("#btnClosing").on("click", function(){
				bootbox.confirm({
					title: "Data Nama <span class='label label-danger'>"+vnama+"</span> Bulan <span class='label label-danger'>"+vmasa+"</span> Tahun Pajak <span class='label label-danger'>"+vtahun+"</span> Pembetulan Ke <span class='label label-danger'>"+vpembetulan+"</span> Close?",
					message: "Apakah anda ingin melanjutkan?",
					buttons: {
						cancel: {
							label: '<i class="fa fa-times"></i> CANCEL'
						},
						confirm: {
							label: '<i class="fa fa-check"></i> YES'
						}
					},
					callback: function (result) {
						if(result) {
							$.ajax({
								url		: "<?php echo site_url('ppn_wapu/save_closing') ?>",
								type	: "POST",
								data	: ({status:vstatus,nama:vnama,bulan:vbulan,tahun:vtahun,pembetulan:vpembetulan,cabang:vcabang}),
								beforeSend	: function(){
									 $("body").addClass("loading")
								},
								success	: function(result){
									if (result==1) {
										 updateRow();
										 $("body").removeClass("loading");
										 flashnotif('Sukses','Data Berhasil di Close!','success' );							
									} else {
										 $("body").removeClass("loading");
										 flashnotif('Error','Data Belum di Approve Pusat','warning' );
									}
									
								}
							});	
						}
					}
				});		
				
			//}
		});	
 
	function updateRow()
	{
		table.draw();		
	}

	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_master_cabang') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#cabang_trx").html("");					
					$("#cabang_trx").html(result);					
				}
		});			
	}
		
	
 });
    </script>
