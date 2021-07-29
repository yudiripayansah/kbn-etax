<div class="container-fluid">
	<div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo $subtitle ?></h4> </div>
    </div>
	
	<div class="row"><br></div>
	<div class="row">
                <div class="col-lg-12">	                  
					 <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
							<div class="row">
								  <div class="col-lg-6">
									Period PPh Badan
								  </div>
								  <div class="col-lg-6">									
									<!--<button type="button" id="btnClosing" class="btn btn-block btn-rounded btn-default custom-input-width navbar-right" disabled >Close</button>
									-->
									
								<div class="navbar-right">								 
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" data-toggle="modal" data-target="#modal-add-period" ><i class="fa fa-pencil-square-o"></i> ADD</button>		
									<button type="button" id="btnClosing" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> CLOSE</button>
								</div>
									
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
													<th>BULAN</th>
													<th>TAHUN</th>
													<th>STATUS</th>																				
													<th>BULAN</th>																				
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

<!-- modal Add Period -->
<div id="modal-add-period" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Add Period</h4> </div>
			<div class="modal-body">					
				<form role="form" id="form-wp">	
				<div class="row">
					<div class="col-lg-3">
						<div id="derror1" class="form-group">
							<label>Pajak</label>
							<select class="form-control" id="jenisPajak" name="jenisPajak">
								<option value="" > -- Pilih --</option>	
								<option value="22" >22</option>	
								<option value="23" >23</option>	
							</select> 
							<div id="error1"></div>
						</div>	
					</div>
					<div class="col-lg-3">
						<div id="derror2" class="form-group">
							<label>Bulan</label>
							<select class="form-control" id="bulan" name="bulan">
								<option value="" > -- Pilih --</option>	
							<?php
								 $namaBulan = array("-- Pilih --","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");									
								 for ($i=1;$i< count($namaBulan);$i++){
									 $selected	= "";
									 echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
								 }
							?>						
							</select>
							<div id="error2"></div>
						</div>
					 </div>
					 <div class="col-lg-3">
						<div id="derror3" class="form-group">
							<label>Tahun</label>
							<select class="form-control" id="tahun" name="tahun">
								<option value="" > -- Pilih --</option>	
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
							<div id="error3"></div>
						</div>
					 </div>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnSave" ><i class="fa fa-plus-circle"></i> SAVE</button>
			</div>
		</div>	
	</div>
</div>
<!-------------------------------------->	

<script>
    $(document).ready(function() {
		var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vnmbulan="",vtahun="",vidx="",vcabang="", vnmcabang="";
		
		$('#modal-add-period').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});	
		
		Pace.track(	function(){		
		$('#tabledata').DataTable({
		    "serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph_badan/load_closing'); ?>",
								 "type" 		: "POST"								 						
							  },
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},			 
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "params", "class":"text-center" },
					{ "data": "nama_pajak", "class":"text-left"},									
					{ "data": "nama_bulan" },
					{ "data": "tahun_pajak" },
					{ "data": "status", "class":"text-center" },
					{ "data": "bulan", "class":"text-center" }
				],			
			"columnDefs": [ 
				 {
					"targets": [ 1,6 ],
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Pajak/Status/Tahun...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});

		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vstatus		= "";
				vnama		= "";				
				vbulan		= "";
				vnmbulan	= "";				
				vtahun		= "";				
				$("#btnClosing").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');	
				var d		= table.row( this ).data();
				vstatus		= d.params;
				vidx		= table.row( this ).index();
				vnama		= d.nama_pajak;					
				vbulan		= d.bulan;					
				vnmbulan	= d.nama_bulan;					
				vtahun		= d.tahun_pajak;				
				$("#btnClosing").removeAttr('disabled');
				if (vstatus=="Open" || vstatus=="OPEN"){					
					$("#btnClosing").html("CLOSE");
				} else {					
					$("#btnClosing").html("OPEN");
				}
				
			}								 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');	
			var d	= table.row( this ).data();
			vstatus		= d.params;
			vidx		= table.row( this ).index();
			vnama		= d.nama_pajak;					
			vbulan		= d.bulan;					
			vnmbulan	= d.nama_bulan;					
			vtahun		= d.tahun_pajak;
			$("#btnClosing").removeAttr('disabled');
			if (vstatus=="Open" || vstatus=="OPEN"){				
				$("#btnClosing").html("Close");
			} else {				
				$("#btnClosing").html("Open");
			}
			$("#btnClosing").trigger("click");			
		} );
		
		$("#modal-add-period").on("show.bs.modal",function(){
			empety();
		});
		
		$("#btnSave").click(function(){
			var vpajak	= $("#jenisPajak").val();
			var vbln	= $("#bulan").val();
			var vtahun	= $("#tahun").val();						
			var vnmbln	= $("#bulan").find(":selected").attr("data-name");
			
			$("#error1, #error2,#error3").html('');
			$("#derror1, #derror2,#derror3").removeClass("has-error");
			
			if (vpajak=='' || vpajak==null ){				
				set_error("error1","derror1","Pajak belum diisi!");
				return false;
			}
			if (vbln=='' || vbln==null ){				
				set_error("error2","derror2","Bulan belum diisi!");
				return false;
			}
			if (vtahun=='' || vtahun==null ){				
				set_error("error3","derror3","Tahun belum diisi!");
				return false;
			}	
			
			$.ajax({
				url		: "<?php echo site_url('pph_badan/save_period') ?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==1) {
						 updateRow();	
						 $("#modal-add-period").modal("hide");
						 $("body").removeClass("loading");
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );						 
					} else if (result==2) {						 
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Pajak '+vpajak+' Bulan '+vnmbln+' Tahun '+vtahun+' Sudah ada!','warning' );					 
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}					
				}
			});	
		});
		

		$("#btnClosing").on("click", function(){
				if(vstatus.toUpperCase()=='OPEN'){
					var vst		= "Close";
				} else {
					var vst		= "Open";
				}				
				
				bootbox.confirm({
					title: "Data Pajak <span class='label label-danger'>"+vnama+"</span> Bulan <span class='label label-danger'>"+vnmbulan+"</span> Tahun <span class='label label-danger'>"+vtahun+"</span> "+vst+"?",
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
								url		: "<?php echo site_url('Pph_badan/save_closing') ?>",
								type	: "POST",
								data	: ({status:vst,nama:vnama,bulan:vbulan,tahun:vtahun}),
								beforeSend	: function(){
									 $("body").addClass("loading")
								},
								success	: function(result){
									if (result==1) {
										 updateRow();
										 $("#btnClosing").attr("disabled",true);
										 $("body").removeClass("loading");
										 flashnotif('Sukses','Data Berhasil di '+vst+'!','success' );							
									} else {
										 $("body").removeClass("loading");
										 flashnotif('Error','Data Gagal di '+vst+'!','error' );
									}
									
								}
							});	
						}
					}
				});		
				
		});	
		

	function updateRow()
	{
		table.draw();
	}
	
	function empety()
	{
		vstatus		= "";
		vnama		= "";				
		vbulan		= "";
		vnmbulan	= "";				
		vtahun		= "";		
		$("#jenisPajak").val("");
		$("#bulan").val("");
		$("#tahun").val("");
	}
 });
 </script>
