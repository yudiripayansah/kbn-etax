<div class="container-fluid">
 <?php $this->load->view('template_top'); ?>	
 
	<div id="list-data">
		<div class="row">
			 <div class="col-lg-12">
				<div class="panel  panel-default boxshadow">
					<div class="panel-body"> 						
					<div class="row">					
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
					  
					 </div>
				</div>
			 </div>
		</div>	
		
		<div class="row">
			<div class="col-lg-12">	
				<div class="panel panel-info boxshadow">
					<div class="panel-heading">
					   Daftar Bukti Potong Yang Belum Diproses
					</div>                        
					<div class="panel-body"> 
						<table width="100%" class="display cell-border stripe hover small" id="tabledata">
							<thead>
								<tr>
									<th class="text-center">NO.</th>
									<th class="text-center">JENIS PPH</th>
									<th class="text-center">CARA <br> PEMBAYARAN</th>
									<th class="text-center">CABANG</th>
									<th class="text-center">NOMOR BUKTI POTONG/ <br> PUNGUT</th>
									<th class="text-center">JENIS <br> PENGHASILAN</th>
									<th class="text-center">OBJECT PEMOTONG/ <br> PEMUNGUT</th>
									<th class="text-center">PPH YNG DIPOTONG/ <br> PUNGUT</th>	
									<th class="text-center">TGL. BUKTI POTONG/ <br> PUNGUT</th>
									<th class="text-center">NPWP PEMOTONG/PEMUNGUT</th>
									<th class="text-center">NAMA PEMOTONG/PEMUNGUT</th>
									<th class="text-center">ALAMAT PEMOTONG/PEMUNGUT</th>
									<th class="text-center">KODE MAP / <br> IURAN PEMBAYARAN</th>
									<th class="text-center">NTPP</th>
									<th class="text-center">JUMLAH PEMBAYARAN</th>
									<th class="text-center">TGL SETOR</th>
									<th class="text-center">ERROR MESSAGE</th>
								</tr>
							</thead>
						</table>
				   </div>
				    <div class="panel-footer"> 
						<div class="row">
							<div class="col-lg-12 text-right">
								 <button type="button" id="btnSave" class="btn btn-info btn-rounded custom-input-width"><i class="fa fa-save"></i> Save </button>
							</div>
						</div>
					</div>
				 </div>
			</div>
		</div>		
	
		<div class="row">
			<div class="col-lg-12">	
				<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
                        <div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar Bukti Potong</a>
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right"> 			
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> Edit</button>
									<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> Delete</button>
								</div>
							  </div>
							</div>  						   
						</div>                       
					<div class="panel-body"> 
						<div class="row">
							<div class="col-lg-12">
								<table width="100%" class="display cell-border stripe hover small" id="tabledataview">
									<thead>
										<tr>
											<th class="text-center">NO.</th>
											<th class="text-center">JENIS PPH</th>
											<th class="text-center">CARA <br> PEMBAYARAN</th>
											<th class="text-center">CABANG</th>
											<th class="text-center">NOMOR BUKTI POTONG/ <br> PUNGUT</th>
											<th class="text-center">JENIS <br> PENGHASILAN</th>
											<th class="text-center">OBJECT PEMOTONG/ <br> PEMUNGUT</th>
											<th class="text-center">PPH YNG DIPOTONG/ <br> PUNGUT</th>	
											<th class="text-center">TGL. BUKTI POTONG/ <br> PUNGUT</th>
											<th class="text-center">NPWP PEMOTONG/PEMUNGUT</th>
											<th class="text-center">NAMA PEMOTONG/PEMUNGUT</th>
											<th class="text-center">ALAMAT PEMOTONG/PEMUNGUT</th>
											<th class="text-center">KODE MAP / <br> IURAN PEMBAYARAN</th>
											<th class="text-center">NTPP</th>
											<th class="text-center">JUMLAH PEMBAYARAN</th>
											<th class="text-center">TGL SETOR</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-lg-12">
								<div id="accordion" class="panel panel-info animated slideInDown">
									<div class="panel-heading">							
										<div class="row">
										  <div class="col-lg-6">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary-detail">Summary</a>
										  </div>						  
										</div> 							
									</div>
									   <div id="collapse-summary-detail" class="panel-collapse collapse in">
										<div class="panel-body"> 									
										 <div class="row">
											<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
												<div id="dDetail-summary" class="table-responsive">   
													<table width="100%" class="display cell-border stripe hover small" id="table-detail-summary"> 
														<thead>
															<tr>									
																<th class="text-center" >NO</th>												
																<th class="text-center" >JENIS PPH</th>
																<th class="text-center" >JUMLAH</th> 										
															</tr>
														</thead>
													</table> 										
												 </div> 									
											</div>											
										 </div>								
										 <div class="row navbar-right">						
											<div class="col-lg-12">										
												<div id="dTotalselisih"></div>
											 </div>											
										 </div>									
										</div>								
									 </div>							 
								</div>	
							</div>
						</div>
				   </div>
				 </div>
			</div>
		</div>

		<!-- Report Bukti Potong -->
		<div class="row">
			<div class="col-lg-12">	
				<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
                        <div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Report</a>
							  </div>
							</div>  						   
						</div>                       
					<div class="panel-body">
					<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<label>Cabang</label>
									<select id="scabang2" name="scabang2" class="form-control" autocomplete="off">
										<?php if($this->session->userdata('kd_cabang') != "000"){ ?>
										<option value="<?php echo $this->session->userdata('kd_cabang') ?>"><?php echo get_nama_cabang($this->session->userdata('kd_cabang')) ?></option>
										<?php
										}
										else{
											$list_cabang  = $this->cabang_mdl->get_all();
											echo '<option value="all"> Semua Cabang </option>';
											foreach ($list_cabang as $cabang):
												?>
										<option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
										<?php endforeach; }?>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Bulan</label>
									<select class="form-control" id="sbulan2" name="sbulan2">
										<option value='' selected>Semua</option>
										<?php
												$namaBulan = list_month();
												$bln = date('m');
												for ($i=1;$i< count($namaBulan);$i++){
												//$selected = ($i==$bln)?"selected":"";
													echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
												}
										?>
									</select> 
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Tahun</label>
									<select class="form-control" id="stahun2" name="stahun2">
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
							<div class="col-lg-2">	
								<div class="form-group">
									<label>&nbsp;</label>
									<button id="btnView2" class="btn btn-info btn-rounded custom-input-width btn-block" type="button" > 
									<i class="fa fa-bars"></i> View</button>
								</div>
							</div>
							<div class="col-lg-2">	
								<div class="form-group">
									<label>&nbsp;</label>
									<button id="btnExportExcel" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" > 
									<i class="fa fa-file-o"></i> <span>EXPORT</span></button>
								</div>
							</div>	
						</div> 
						<div class="row">
							<div class="col-lg-12">
								<div id="dReport-summary" class="table-responsive">  
									<table width="100%" class="display cell-border stripe hover small" id="tablereport">
										<thead>
											<tr>
												<th class="text-center">NO.</th>
												<th class="text-center">CABANG</th>
												<th class="text-center">PDD PASAL 23 <br> Jml. Bukti Potong</th>
												<th class="text-center">PDD PASAL 22 <br> Jml. Bukti Potong</th>
												<th class="text-center">PDD PASAL 25 <br> Jml. Bukti Potong</th>
											</tr>
										</thead>
									</table>
									<hr>
									<table width="100%" class="display cell-border stripe hover small" id="tablereport2">
										<thead>
											<tr>
												<th ><h4>Total</h4></th>
												<th class="text-center"><h5><div id="dPPD23"></div></h5></th>
												<th class="text-center"><h5><div id="dPPD22"></div></h5></th>
												<th class="text-center"><h5><div id="dPPD25"></div></h5></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="row navbar-right">						
								<div class="col-lg-12">										
									<div id="dTotalselisih2"></div>
								</div>											
							</div>	
						</div>
				   </div>
				 </div>
			</div>
		</div>
		<!--End Report bukti potong -->
	</div>
	

<!-- modal tambah data -->
<div id="tambah-data">	
	<form role="form" id="form-wp">	
	  <div class="white-box boxshadow">
	 	
		<div class="row">
			<div class="col-lg-12 align-center">
				<h2 id="capAdd" class="text-center">Edit Data</h2>
			</div>			
		</div>
		
		<div class="row">
			<hr>
		</div>
		<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>JENIS PPH</label>
					<input type="text" class="form-control" id="jpph" name="jpph" placeholder="JENIS PPH" type="text">
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>CARA PEMBAYARAN</label>
					<input type="text" class="form-control" id="cbayar" name="cbayar" placeholder="CARA PEMBAYARAN" type="text">
				</div>
			 </div>
			</div>
		<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>NOMOR BUKTI POTONG/PUNGUT</label>
					<input type="text" class="form-control" id="nobupot" name="nobupot" placeholder="NOMOR BUKTI POTONG/PUNGUT" type="text">
					<input type="hidden" class="form-control" id="idbupot" name="idbupot">
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>JENIS PENGHASILAN</label>
					<input type="text" class="form-control" id="jnspenghasilan" name="jnspenghasilan" placeholder="JENIS PENGHASILAN" type="text">
				</div>
			 </div>
			</div>
			 <div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>OBJECT PEMOTONG/PEMUNGUT</label>
					<input class="form-control" id="objpemotong" name="objpemotong" placeholder="OBJECT PEMOTONG/PEMUNGUT" type="text">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>PPH YNG DIPOTONG/PUNGUT</label>
					<input class="form-control" id="pphdipotong" name="pphdipotong" placeholder="PPH YNG DIPOTONG/PUNGUT" type="text">					
				</div>
			 </div>
			</div>
			<div class="row">
			 <div class="col-lg-6">	
					<div class="form-group">
					<label>TGL. BUKTI POTONG/PUNGUT</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tglpemotong" name="tglpemotong" placeholder="dd-mm-yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>NPWP PEMOTONG/PEMUNGUT</label>
					<input class="form-control" id="npwp" name="npwp" placeholder="NPWP" type="text">					
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>NAMA PEMOTONG/PEMUNGUT</label>
					<input class="form-control" id="npemotong" name="npemotong" placeholder="NAMA PEMOTONG/PEMUNGUT" type="text">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>ALAMAT PEMOTONG/PEMUNGUT</label>
					<input class="form-control" id="alamat" name="alamat" placeholder="ALAMAT PEMOTONG/PEMUNGUT" type="text">					
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>KODE MAP / IURAN PEMBAYARANT</label>
					<input class="form-control" id="kdmap" name="kdmap" placeholder="KODE MAP / IURAN PEMBAYARANT" type="text">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>NTPP</label>
					<input class="form-control" id="ntpp" name="ntpp" placeholder="NTPP" type="text">					
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>JUMLAH PEMBAYARAN</label>
					<input class="form-control" id="jumlah" name="jumlah" placeholder="JUMLAH PEMBAYARAN" type="text">					
				</div>
			 </div>
			 <div class="col-lg-6">	
					<div class="form-group">
					<label>TGL SETOR</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tglsetor" name="tglsetor" placeholder="dd-mm-yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>
			 </div>
			</div>
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> Back</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave1"><i class="fa fa-save"></i> Save</button>
						  </div>
					 </div>
				</div>
			</div>
		</div>
		
	</form>	
</div>	
</div>

<script>
    $(document).ready(function() {
		var table	= "", vid = 0, vstatus="",vnama="", vbulan="",vtahun="",vidx="";
		var vnobupot = "", vjpenghasilan = "", vobjpemotong = "", vpphygdiptg = "", vnpwppemot = "", vnpemot = "",
			valamat = "", vkdmap = "", vntpp = "", vjumlah = "", vtglsetor = "", vtglbupot, vjpph = "", vcbayar = "", vnpemotong;
		var nD      = new Date();
		var nY      = nD.getFullYear();
		var tahunV	= nY;
		
		var bulanV 	= "0" ;
		var cabangV = "<?php echo $this->session->userdata('kd_cabang'); ?>" ;
		var cabang2V = "<?php echo $this->session->userdata('kd_cabang'); ?>" ;
		$('#jenisPajak').val('');
		$('#jenisPajak2').val('');

		var tahun2V	= nY;
		var bulan2V = "" ;

		$("#tambah-data").hide();
		$("#btnSave").hide();
		getSummary();
		getDataReport();
		
		Pace.track(	function(){		
		$('#tabledata').DataTable({
		    "serverSide"	: true,
			"processing"	: true,
			"pageLength"		: 100,
			"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph_badan/load_bupot_lain'); ?>",
								 "type" 		: "POST",
								 "beforeSend"	: function () {
								 },								
							  },
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},			 
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "nama_pajak" , "class":"text-center"},					
					{ "data": "cara_pembayaran" , "class":"text-center"},
					{ "data": "nama_cabang"},
					{ "data": "no_bukti_potong"},
					{ "data": "jenis_penghasilan" , "class":"text-center"},
					{ "data": "dpp" , "class":"text-right"},					
					{ "data": "jumlah_potong" , "class":"text-right"},
					{ "data": "tgl_bukti_potong"},
					{ "data": "npwp" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "kode_map" },
					{ "data": "ntpp" },
					{ "data": "jumlah_pembayaran" },
					{ "data": "tanggal_setor" },
					{ "data": "error_message" },
					{ "data": "nama_file" },
					{ "data": "bukti_potong_id", "class":"text-left"}
				],			
			"columnDefs": [ 
				 {
					"targets": [ 17, 18 ],
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Bupot / NPWP...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});		
		
		table.on( 'draw', function () {
			optBtnSave();
		});	
		
		$("#btnSave").on("click", function(){
				var vst		= "Close";
				bootbox.confirm({
					title: "Simpan Data",
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
								url		: "<?php echo site_url('Pph_badan/save_bupot_ph_lain') ?>",
								type	: "POST",
								beforeSend	: function(){
									 $("body").addClass("loading")
								},
								success	: function(result){
									if (result==1) {
										 table.draw();
										 tableview.draw();
										 getSummary();
										 $("body").removeClass("loading");
										 flashnotif('Sukses','Data Berhasil di Simpan!','success' );							
									} else {
										 $("body").removeClass("loading");
										 flashnotif('Error','Data Gagal simpan','error' );
									}
									
								}
							});	
						}
					}
				});		
				
		});	
			
		$('#tabledataview').DataTable({
			"dom"			: "<'row' <'toolbarJns col-lg-1'> <'toolbarBul col-lg-2'> <'toolbarYear col-lg-1'> <'toolbarCab col-lg-2'> <'toolbarBtn col-lg-2'> <'toolbarBtnEks col-lg-2'> <'toolbarBtnExl col-lg-2'> >"+ 
			"<'row'<'col-lg-6'l>  <'col-lg-6'f> > rtip",
		    "serverSide"	: true,
			"processing"	: true,
			"pageLength"		: 100,
			"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph_badan/load_bupot_lain_final'); ?>",
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchPph		= $('#jenisPajak').val();						
										d._searchbulan 		= bulanV;									
										d._searchTahun 		= tahunV;									
										d._searchCabang		= cabangV;									
									}								
							  },
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},			 
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "nama_pajak" , "class":"text-center"},					
					{ "data": "cara_pembayaran" , "class":"text-center"},
					{ "data": "nama_cabang"},
					{ "data": "no_bukti_potong"},
					{ "data": "jenis_penghasilan" , "class":"text-center"},
					{ "data": "dpp", "class":"text-right"},					
					{ "data": "jumlah_potong", "class":"text-right"},
					{ "data": "tgl_bukti_potong"},
					{ "data": "npwp" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "kode_map" },
					{ "data": "ntpp" },
					{ "data": "jumlah_pembayaran" },
					{ "data": "tanggal_setor" },
					{ "data": "nama_file" },
					{ "data": "bukti_potong_id", "class":"text-left"}
				],			
			"columnDefs": [ 
				 {
					"targets": [ 16, 17 ],
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
		

		tableview = $('#tabledataview').DataTable();
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Bupot/NPWP...').css({'width':'210px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledataview_filter .add-clear-x").on('click',function(){
			tableview.search('').column().search('').draw();		
		});
		
		var vhtmlJ	='<div class="form-group">'+
						'<label>Jenis Pajak</label>'+
						'<select class="form-control" id="jenisPajak" name="jenisPajak">'+
							'<option value="" selected >Semua</option>'+
							'<option value="22" >22</option>'+
							'<option value="23" >23</option>'+
						'</select>'+
					'</div>';			
		$("div.toolbarJns").html(vhtmlJ);

		var vhtmlJ2	='<div class="form-group">'+
						'<label>Jenis Pajak</label>'+
						'<select class="form-control" id="jenisPajak2" name="jenisPajak2">'+
							'<option value="" selected >Semua</option>'+
							'<option value="22" >22</option>'+
							'<option value="23" >23</option>'+
							'<option value="25" >25</option>'+
						'</select>'+
					'</div>';			
		$("div.toolbarJns2").html(vhtmlJ2);
		
		var vhtmlBul	='<div class="form-group">'+
						'<label>Bulan</label>'+
						'<select class="form-control" id="sbulan" name="sbulan">'+
							getMonth()+
						'</select>'+
					'</div>';			
		$("div.toolbarBul").html(vhtmlBul);

		var vhtmlBul2	='<div class="form-group">'+
						'<label>Bulan</label>'+
						'<select class="form-control" id="sbulan2" name="sbulan2">'+
							getMonth()+
						'</select>'+
					'</div>';			
		$("div.toolbarBul2").html(vhtmlBul2);
		
		var vhtmlY	='<div class="form-group">'+
						'<label>Tahun</label>'+
						'<select class="form-control" id="stahun" name="stahun">'+
							getYear()+
						'</select>'+
					'</div>';			
		$("div.toolbarYear").html(vhtmlY);

		var vhtmlY2	='<div class="form-group">'+
						'<label>Tahun</label>'+
						'<select class="form-control" id="stahun2" name="stahun2">'+
							getYear()+
						'</select>'+
					'</div>';			
		$("div.toolbarYear2").html(vhtmlY2);
		
		var vhtmlCab	='<div class="form-group">'+
						'<label>Cabang</label>'+
						'<select class="form-control" id="scabang" name="scabang">'+
							getSelectCabang()+
						'</select>'+
					'</div>';			
		$("div.toolbarCab").html(vhtmlCab);

		var vhtmlCab2	='<div class="form-group">'+
						'<label>Cabang</label>'+
						'<select class="form-control" id="scabang2" name="scabang2">'+
							getSelectCabang2()+
						'</select>'+
					'</div>';			
		$("div.toolbarCab2").html(vhtmlCab2);
		
		var vhtmlB	='<div class="form-group">'+	
						'<label>&nbsp;</label>'+
						'<button id="btnView" class="btn btn-default btn-rounded btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>'+
					'</div>';			
		$("div.toolbarBtn").html(vhtmlB);

		var vhtmlB2	='<div class="form-group">'+	
						'<label>&nbsp;</label>'+
						'<button id="btnView2" class="btn btn-default btn-rounded btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>'+
					'</div>';			
		$("div.toolbarBtn2").html(vhtmlB2);
		
		var vhtmlBEks ='<div class="form-group">'+
						'<label>&nbsp;</label>'+
						'<button id="btnEksportCSV" class="btn btn-default btn-rounded btn-block tooltip-info" type="button" data-toggle="tooltip" data-placement="top" title="To CSV"><i class="fa fa-file-o"></i> <span>Export</span></button>'+
					'</div>';			
		$("div.toolbarBtnEks").html(vhtmlBEks);
		
		var vhtmlBExl ='<div class="form-group">'+
						'<label>&nbsp;</label>'+
						'<button id="btnEksportExl" class="btn btn-default btn-rounded btn-block tooltip-info" type="button" data-toggle="tooltip" data-placement="top" title="To Excel"><i class="fa fa-file-excel-o"></i> <span>Print</span></button>'+
					'</div>';			
		$("div.toolbarBtnExl").html(vhtmlBExl);	
		
		
		$("#scabang").on("change", function(){
			cabangV = $(this).val();		
		});

		$("#scabang2").on("change", function(){
			cabang2V = $(this).val();		
		});
		
		$("#sbulan").on("change", function(){
			bulanV = $(this).val();		
		});

		$("#sbulan2").on("change", function(){
			bulan2V = $(this).val();
		});
		
		$("#stahun").on("change", function(){
			tahunV = $(this).val();
		});

		$("#stahun2").on("change", function(){
			tahun2V = $(this).val();
		});
		
		$("#btnView").on("click", function(){
			tableview.ajax.reload();
			getSummary();
		});

		$("#btnView2").on("click", function(){
			//tablereportview.ajax.reload();
			getDataReport();
		});

		$("#btnExportExcel").on("click", function(){	
			eksportRepExcel();		
		});
		
		function getYear(){
			var sD = new Date();
			var sY = sD.getFullYear();
			var sTahunAwal	= parseInt(sY) - parseInt(5);
			var i , optYear	= "", opSelect="";
			for(i=sTahunAwal;i<=sY;i++){
				if (i==sY){
					opSelect ="selected";
				} else {
					opSelect ="";
				}
				optYear	+= '<option value="'+i+'" '+opSelect+' >'+i+'</option>';
			}
			return optYear;
		}
		
		function getMonth(){
			var nm 		= ["Semua","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
			var date 	= new Date();
			var month	= date.getMonth();
			var i, value="", opSelect="";
			for (i=0;i<nm.length;i++){
				if (i==0){
					opSelect ="selected";
				} else {
					opSelect ="";
				}
				value += '<option value="'+i+'" '+opSelect+' data-name="'+nm[i]+'" >'+nm[i]+'</option>';
			}
			return value;
		}
		
	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url() ?>/master/load_master_cabang/select",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#scabang").html("");
					vc = '';
					<?php if($this->session->userdata('kd_cabang') == '000'){ ?>
					vc = '<option value="" >All</option>';
					<?php } ?>
					$("#scabang").html(vc+result);					
				}
		});			
	}

	function getSelectCabang2()
	{
		$.ajax({
				url		: "<?php echo site_url() ?>/master/load_master_cabang/select",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#scabang2").html("");
					vc = '';
					<?php if($this->session->userdata('kd_cabang') == '000'){ ?>
					vc = '<option value="" >All</option>';
					<?php } ?>
					$("#scabang2").html(vc+result);					
				}
		});			
	}
		
		$('#tabledataview tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$("#btnEdit, #btnDelete").attr("disabled",true);
			} else {
				tableview.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = tableview.row( this ).data();
				vid      			= d.bukti_potong_id;
				vnobupot       		= d.no_bukti_potong;
				vjpenghasilan		= d.jenis_penghasilan;				
				vobjpemotong	    = d.dpp;				
				vpphygdiptg	        = d.jumlah_potong;
				vnpwppemot	        = d.npwp;
				vtglbupot		    = d.tgl_bukti_potong;
				valamat	            = d.alamat_wp;				
				vkdmap	            = d.kode_map;
				vntpp	    		= d.ntpp;
				vjumlah		    	= d.jumlah_pembayaran;				
				vtglsetor 	    	= d.tanggal_setor;
				vjpph 	    		= d.nama_pajak;
				vcbayar 	    	= d.cara_pembayaran;
				vnpemotong 	    	= d.nama_wp;
				valueGrid();				
				$("#btnEdit, #btnDelete").removeAttr('disabled');
				$("#isNewRecord").val("0");
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			tableview.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = tableview.row( this ).data();
			vid      			= d.bukti_potong_id;
			vnobupot       		= d.no_bukti_potong;
			vjpenghasilan		= d.jenis_penghasilan;				
			vobjpemotong	    = d.dpp;				
			vpphygdiptg	        = d.jumlah_potong;
			vnpwppemot	        = d.npwp;
			vtglbupot		    = d.tgl_bukti_potong;
			valamat	            = d.alamat_wp;				
			vkdmap	            = d.kode_map;
			vntpp	    		= d.ntpp;
			vjumlah		    	= d.jumlah_pembayaran;				
			vtglsetor 	    	= d.tanggal_setor;
			vjpph 	    		= d.nama_pajak;
			vcbayar 	    	= d.cara_pembayaran;
			vnpemotong 	    	= d.nama_wp;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit, #btnDelete").removeAttr('disabled');
			$("#tambah-data").slideDown(700);
			$("#list-data").slideUp(700);
			$("#getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPH Badan "+vjpph+" Tahun "+$("#stahun").val()+"</span>");
		} );	

	function valueGrid()
	{
		$("#idbupot").val(vid);
		$("#nobupot").val(vnobupot);
		$("#jnspenghasilan").val(vjpenghasilan);
		$("#objpemotong").val(vobjpemotong);
		$("#pphdipotong").val(vpphygdiptg);
		$("#npwp").val(vnpwppemot);
		$("#tglpemotong").val(vtglbupot);
		$("#alamat").val(valamat);
		$("#kdmap").val(vkdmap);
		$("#ntpp").val(vntpp);
		$("#jumlah").val(vjumlah);
		$("#tglsetor").val(vtglsetor);
		$("#jpph").val(vjpph);
		$("#cbayar").val(vcbayar);
		$("#npemotong").val(vnpemotong);		
	}	
	
	
	$("#btnEksportCSV").on("click", function(){	
		eksport(1);		
	});
	
	$("#btnEksportExl").on("click", function(){	
		eksport(2);	
	});
	
	function eksport(x){		
		var j		= $("#jenisPajak").val();			
		var b		= $("#sbulan").val();
		var bnm		= $("#sbulan").find(":selected").attr("data-name");
		var t		= $("#stahun").val();
		var c		= $("#scabang").val();
		var cnm		= $("#scabang").find(":selected").attr("data-name");
		if (j){
			var vpjk = "";
			var vpjkQ= "Pajak "+j;
		} else {
			var vpjk = " Semua";
			var vpjkQ= " ";
		}
		
		if(b && b!="0"){
			var vbln	= bnm;
		} else {
			var vbln	= "";
		}
		
		if(c){
			var vcb	= cnm;
		} else {
			var vcb	= "semua cabang";
		}
		
		if (x==1){
			var vjdl = "Eksport ";
			var url 	="<?php echo site_url(); ?>pph_badan/export_format_csv";
		} else {
			var vjdl = "Cetak ";
			var url 	="<?php echo site_url(); ?>pph_badan/cetak_excel";
		}
		
		bootbox.confirm({
			title: vjdl+"data pajak <span class='label label-danger'>"+j+" "+vbln+" "+t+" "+vcb+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> YES'
				}
			},
			callback: function (result) {
				if(result) {
				//============					
					$.ajax({			
						url		: '<?php echo site_url() ?>pph_badan/cek_data_csv'+'?tax='+j+'&month='+b+'&year='+t+'&cab='+c,				
						success	: function(result){
							if (result==1) {	
								window.open(url+'?tax='+j+'&month='+b+'&year='+t+'&cab='+c, '_blank');
								window.focus(); 														
							} else {
								flashnotif('Info','Data '+j+' '+vbln+' '+t+' '+vcb+' Kosong!','warning' );
								return false;
							}
						}
					});					
				//=====================
				}
			}
		});	
	}
	
	$("#btnEdit").click(function (){
			//$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			valueGrid();
			$( ".datepicker-autoclose" ).attr( "disabled", true );
	});

		$("#btnSave1").click(function(){				
			$.ajax({
				url		: "<?php echo site_url('pph_badan/save_pph_badan') ?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){					
					if (result==1) {
						 tableview.draw();
						 getSummary();
						 $("body").removeClass("loading");
						 $("#list-data").slideDown(700);
						 $("#tambah-data").slideUp(700);
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 //empety();
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}
					
				}
			});	
		});

		$("#btnDelete").click(function(){
		  bootbox.confirm({
			title: "Hapus data <span class='label label-danger'>"+vnama+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> YES'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('pph_badan/delete_pph_badan') ?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								 $("body").removeClass("loading");
								 tableview.draw();
								 flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
							} else {
								 $("body").removeClass("loading");
								 flashnotif('Error','Data Gagal di Hapus!','error' );
							}
							
						}
					});	
				}
			}
		});				
	});

	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		//empety();
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
            url: "<?php echo base_url('pph_badan/import_CSV') ?>",
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
				} else if(result==4){
					var thn		= data.tahun;
					$("body").removeClass("loading");
					flashnotif('Info','Data Tahun '+thn+' Sudah Ada!','warning' );						
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Data Gagal di Import!','error' );
                }
            }
        });
    });	
	
	function optBtnSave(){
		if (table.data().any()){
			$("#btnSave").slideDown(700);
		} else {
			$("#btnSave").slideUp(700);
		} 
	}
	
	function getSummary(){
		/* Awal detail Summary======================================================= */
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
		$('#table-detail-summary').DataTable({	
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph_badan/load_detail_summary'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchPph		= $('#jenisPajak').val();						
										d._searchbulan 		= bulanV;									
										d._searchTahun 		= tahunV;									
										d._searchCabang		= cabangV;		
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },					
					{ "data": "nama_pajak" , "class":"text-center"},
					{ "data": "jumlah", "class":"text-right" }
				],				
			 "scrollY"			: 300, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			 
			});
			
		} else {
			$('#table-detail-summary').DataTable().ajax.reload();
		}
				
		$.ajax({
			url		: "<?php echo site_url('pph_badan/load_total_detail_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({_searchPph : $('#jenisPajak').val(),_searchbulan : bulanV, _searchTahun : tahunV, _searchCabang : cabangV}),
			success	: function(result){										
					$("#dTotalselisih").html("<h4><strong>TOTAL &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.total,2,'.',',')+"</span></h4>" );
			}
		});	
		
		/* Akhir detail Summary======================================================= */
	}

	function getDataReport(){
		if ( ! $.fn.DataTable.isDataTable( '#tablereport' ) ) {
		$('#tablereport').DataTable({	
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"pageLength": 50,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph_badan/load_bupot_report'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {						
										d._searchbulan 		= bulan2V;									
										d._searchTahun 		= tahun2V;									
										d._searchCabang		= cabang2V;		
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
				"columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "nama_cabang" , "class":"text-center"},					
					{ "data": "pph23" , "class":"text-right"},
					{ "data": "pph22" , "class":"text-right"},
					{ "data": "pph25" , "class":"text-right"}
				],					
			 "scrollY"			: 300, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			 
			});
			
		} else {
			$('#tablereport').DataTable().ajax.reload();
		}
				
		$.ajax({
			url		: "<?php echo site_url('pph_badan/load_bupot_report_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({_searchPph : $('#jenisPajak2').val(),_searchbulan : bulan2V, _searchTahun : tahun2V, _searchCabang : cabang2V}),
			success	: function(result){		
					$("#dPPD23").html("<span class='label label-info'>"+number_format(result.total23,2,'.',',')+"</span>");								
					$("#dPPD22").html("<span class='label label-info'>"+number_format(result.total22,2,'.',',')+"</span>");
					$("#dPPD25").html("<span class='label label-info'>"+number_format(result.total25,2,'.',',')+"</span>");
					
			}
		});	
		
	}

	function eksportRepExcel(){				
		var b		= $("#sbulan2").val();
		var bnm		= $("#sbulan2").find(":selected").attr("data-name");
		var t		= $("#stahun2").val();
		var c		= $("#scabang2").val();
		var cnm		= $("#scabang2").find(":selected").attr("data-name");
		
		if(b && b!="0"){
			var vbln	= bnm;
		} else {
			var vbln	= "";
		}
		
		if(c){
			var vcb	= cnm;
		} else {
			var vcb	= "semua cabang";
		}
		
		var vjdl = "Eksport ";
		var url 	="<?php echo site_url(); ?>pph_badan/export_report_bl_excel";

		
		bootbox.confirm({
			title: vjdl+"Kredit Pajak PPh Badan <span class='label label-danger'>"+vbln+" "+t+" "+vcb+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> YES'
				}
			},
			callback: function (result) {
				if(result) {
				//============					
					$.ajax({			
						url		: '<?php echo site_url() ?>pph_badan/cek_report_bl_excel?month='+b+'&year='+t+'&cab='+c,				
						success	: function(result){
							if (result==1) {	
								window.open(url+'?month='+b+'&year='+t+'&cab='+c, '_blank');
								window.focus(); 														
							} else {
								flashnotif('Info','Data '+vbln+' '+t+' '+vcb+' Kosong!','warning' );
								return false;
							}
						}
					});					
				//=====================
				}
			}
		});	
	}
		
 });
 </script>				
