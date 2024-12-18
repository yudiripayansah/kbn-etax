<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
		
	<div class="white-box boxshadow">	
		<div class="row"> 
			<div class="col-lg-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan">
						<?php
							$namaBulan = list_month();
							$bln       = date('m');
							/*if ($bln > 1){
								$bln     = $bln - 1;
								$tahun_n = 0;
							} else {
								$bln     = 12;
								$tahun_n = 1;
							}*/
							for ($i=1;$i< count($namaBulan);$i++){
								$selected = ($i==$bln)?"selected":"";
								echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
							}
						?>
					</select> 
				</div>
			 </div>
			 <div class="col-lg-2">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="tahun" name="tahun">
						<?php 
							$tahun    = date('Y');
							$tAwal    = $tahun - 5;
							$tAkhir   = $tahun;
							$selected = "";
							for($i=$tAwal; $i<=$tAkhir; $i++){
								$selected = ($i == $tahun) ? "selected" : "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}
						?>
					</select> 
				</div>
			 </div>
		
			 
			 <div class="col-lg-2">	
			 <div class="form-group">
			 <label>Pembetulan Ke</label>
				<select class="form-control" id="pembetulanKe" name="pembetulanKe">
					<option value="0" selected>0</option> 
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar Data Rekonsiliasi Bulanan</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK LINE ID</th>
													<th>VENDOR ID</th>
													<th>PAJAK HEADER ID</th>
													<th>AKUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>TAHUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>ORGANIZATION ID</th>
													<th>NAMA WP</th>  
													<th>ALAMAT</th>
													<th>NPWP</th>
													<th>JENIS PAJAK</th>
													<th>INVOICE NUMBER</th>
													<th>NOMOR FAKTUR PAJAK</th>
													<th>TANGGAL FAKTUR PAJAK</th>
													<th>NO BUKTI POTONG</th>
													<th>TGL BUKTI POTONG</th>
													<th>GL ACCOUNT</th>										
													<th>KODE PAJAK</th>
													<th>DPP</th>
													<th>TARIF (%)</th>
													<th>JUMLAH POTONG</th>										
													<th>NEW KODE PAJAK</th>
													<th>NEW DPP</th>
													<th>NEW TARIF (%)</th>
													<th>NEW JUMLAH POTONG</th>
													<th>PEMBETULAN KE</th>										
													<th>NPWP PEMOTONG</th>
													<th>NAMA PEMOTONG</th>
													<th>WP LUAR NEGERI</th>
													<th>KODE NEGARA</th>
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
	
<!-- =============================FINAL============================ -->
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar Data Rekonsiliasi Bulanan Final</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata_final"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK LINE ID</th>
													<th>VENDOR ID</th>
													<th>PAJAK HEADER ID</th>
													<th>AKUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>TAHUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>ORGANIZATION ID</th>
													<th>NAMA WP</th>  
													<th>ALAMAT</th>
													<th>NPWP</th>
													<th>JENIS PAJAK</th>
													<th>INVOICE NUMBER</th>
													<th>NOMOR FAKTUR PAJAK</th>
													<th>TANGGAL FAKTUR PAJAK</th>
													<th>NO BUKTI POTONG</th>
													<th>TGL BUKTI POTONG</th>
													<th>GL ACCOUNT</th>										
													<th>KODE PAJAK</th>																				
													<th>DPP</th>
													<th>TARIF (%)</th>
													<th>JUMLAH POTONG</th>										
													<th>NEW KODE PAJAK</th>
													<th>NEW DPP</th>
													<th>NEW TARIF (%)</th>
													<th>NEW JUMLAH POTONG</th>
													<th>PEMBETULAN KE</th>										
													<th>NPWP PEMOTONG</th>
													<th>NAMA PEMOTONG</th>
													<th>WP LUAR NEGERI</th>
													<th>KODE NEGARA</th>
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

<!-- =============================BULANAN FINAL ============================ -->	
<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar Data Rekonsiliasi Bulanan Non Final</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata_nonfinal"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK LINE ID</th>
													<th>VENDOR ID</th>
													<th>PAJAK HEADER ID</th>
													<th>AKUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>TAHUN PAJAK</th>
													<th>MASA PAJAK</th>
													<th>ORGANIZATION ID</th>
													<th>NAMA WP</th>  
													<th>ALAMAT</th>
													<th>NPWP</th>
													<th>JENIS PAJAK</th>
													<th>INVOICE NUMBER</th>
													<th>NOMOR FAKTUR PAJAK</th>
													<th>TANGGAL FAKTUR PAJAK</th>
													<th>NO BUKTI POTONG</th>
													<th>TGL BUKTI POTONG</th>
													<th>GL ACCOUNT</th>										
													<th>KODE PAJAK</th>																				
													<th>DPP</th>
													<th>TARIF (%)</th>
													<th>JUMLAH POTONG</th>										
													<th>NEW KODE PAJAK</th>
													<th>NEW DPP</th>
													<th>NEW TARIF (%)</th>
													<th>NEW JUMLAH POTONG</th>
													<th>PEMBETULAN KE</th>										
													<th>NPWP PEMOTONG</th>
													<th>NAMA PEMOTONG</th>
													<th>WP LUAR NEGERI</th>
													<th>KODE NEGARA</th>
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
			
			<!-- RINGKASAN -->
	<div class="row"> 	
			<div class="col-lg-12">	
				<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">							
						<div class="row">
						  <div class="col-lg-6">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary">Ringkasan Rekonsiliasi</a>
						  </div>						  
						</div> 							
					</div>
				   <div id="collapse-summary" class="panel-collapse collapse in">
					<div class="panel-body"> 					
					 <div class="row">
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<div class="table-responsive">   
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll1"> 
									<thead>
										<tr>									
											<th>NO</th>																	
											<th>SALDO AWAL</th>
											<th>MUTASI DEBET</th> 
											<th>MUTASI KREDIT</th>
											<th>SALDO AKHIR</th>
											<th>JUMLAH DIBAYARKAN</th>																			
											<th>SELISIH</th>																			
										</tr>
									</thead>
								</table>							
							 </div> 									
							</div>							
					 </div>					 
					<!-- Awal Detail Selisih ====================================================================================== -->
					  <hr>
					  <div class="row">						
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<div id="accordion" class="panel panel-info animated slideInDown">
							<div class="panel-heading">							
								<div class="row">
								  <div class="col-lg-6">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary-detail">Data Tidak Dilaporkan</a>
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
														<th>NO</th>																	
														<th>NPWP</th>
														<th>NAMA WP</th> 
														<th>NOMOR FAKTUR PAJAK</th>
														<th>TANGGAL FAKTUR PAJAK</th>
														<th>DPP</th>
														<th>PPH/JUMLAH POTONG</th>
														<th>KETERANGAN</th>												
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
				 <!-- Akhir Detail Selisih ====================================================================================== -->
				 
				</div>
			</div>			 
			</div>			
		</div>
	</div>
			
			

<!--=====================================================================-->	
	<div class="row">
		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel  panel-default boxshadow animated slideInDown">
			<div class="panel-heading">
               Keterangan
            </div>
				 <div class="panel-body"> 
					<div class="row">
						 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
                              <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Write your text here..."></textarea>
							</div>
						 </div>						
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							 <button type="button" id="btnReset" class="btn btn-default"><i class="fa fa-trash-o fa-fw"></i> RESET</button>
							 <button type="button" id="btnApprov" class="btn btn-info"><i class="fa fa-check fa-fw"></i> APPROVE</button>
							 <button type="button" id="btnReject" class="btn btn-danger"><i class="fa fa-times fa-fw"></i> REJECT</button>		 
						</div>
					</div>
				 </div>
			</div>
		 </div>
	</div>

</div>


<script>
    $(document).ready(function() {
			var table	= "", vkodepajak="", vnamapajak = "", vbulan="", vnmbulan = "",vtahun = "";		
			valueAdd();	
			getStart();
			//getSummary(x);			
			
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_approv'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchTypePph	= $('#jenisPajak').find(':selected').attr('data-type');
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/approv/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "npwp" },
					{ "data": "nama_pajak" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "tgl_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" }
					
				],
			 "columnDefs": [ 
				 {
					"targets": [ 1,2,3,4,5,6,7,8,12,13,14,15,16,17,18,19,23,24,25,26,27],
					"visible": false
				} 
			], 			
			/* "fixedColumns"	:   {
					"leftColumns": 1
			},	 */	
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
	//============================================== FINAL ===========================

	Pace.track(function(){  
		   $('#tabledata_final').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_approv_final'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchTypePph	= $('#jenisPajak').find(':selected').attr('data-type');
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/approv/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "npwp" },
					{ "data": "nama_pajak" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "tgl_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" }
					
				],
			 "columnDefs": [ 
				 {
					"targets": [1,2,3,4,5,6,7,8,12,13,14,15,18,19,23,24,25,26,27],
					"visible": false
				} 
			], 			
			/* "fixedColumns"	:   {
					"leftColumns": 1
			},		 */
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
	
	//============================================== NON FINAL ========================
	Pace.track(function(){  
		   $('#tabledata_nonfinal').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_approv_nonfinal'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchTypePph	= $('#jenisPajak').find(':selected').attr('data-type');
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/approv/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "npwp" },
					{ "data": "nama_pajak" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "tgl_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" }
					
				],
			 "columnDefs": [ 
				 {
					"targets": [1,2,3,4,5,6,7,8,12,13,14,15,18,19,23,24,25,26,27],
					"visible": false
				} 
			], 			
			/* "fixedColumns"	:   {
					"leftColumns": 1
			},		 */
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
	
	
	//==================================================================================
		table = $('#tabledata').DataTable();
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Nama WP/DPP/Jumlah Potong...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		 
		 
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');				
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');				
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		} );
		
		$("#btnView").on("click", function(){
			valueAdd();
			getStart();
			getSummary();
			$('#tabledata').DataTable().ajax.reload();			
			$("#tabledata_final").DataTable().ajax.reload();			
			$("#tabledata_nonfinal").DataTable().ajax.reload();
						
		});
		
		
		$("#btnApprov").click(function(){
			bootbox.confirm({
			title: "Data <span class='label label-danger'>"+vnamapajak+"</span> Bulan <span class='label label-danger'>"+vnmbulan+"</span> Tahun <span class='label label-danger'>"+vtahun+"</span> Pembetulan ke <span class='label label-danger'>"+$('#pembetulanKe').val()+"</span> Approv?",
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
					var vket	= $("#keterangan").val();
					$.ajax({
						url		: "<?php echo site_url('pph21/save_approv') ?>",
						type	: "POST",
						data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak,ket:vket,st:1,pembetulan:$('#pembetulanKe').val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 table.draw();
								 $("body").removeClass("loading");
								 flashnotif('Sukses','Data Berhasil di Approv!','success' );
								 $("#keterangan").val("");
							} else if (result==2) {
								 getStart();
								 table.draw();								  
								 $("body").removeClass("loading");
								 flashnotif('Info','Prosedur Faktur gagal!','warning' );
								 $("#keterangan").val("");
							} else {
								 $("body").removeClass("loading");
								 flashnotif('Error','Data Gagal di Approv!','error' );
							}
							
						}
					});						
				}
			}
			});			
			
		})
		
		

		$("#btnReject").click(function(){
			bootbox.confirm({
			title: "Data <span class='label label-danger'>"+vnamapajak+"</span> Bulan <span class='label label-danger'>"+vnmbulan+"</span> Tahun <span class='label label-danger'>"+vtahun+"</span> Pembetulan ke <span class='label label-danger'>"+$('#pembetulanKe').val()+"</span> Reject?",
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
					var vket	= $("#keterangan").val();
					$.ajax({
						url		: "<?php echo site_url('pph21/save_approv') ?>",
						type	: "POST",
						data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak,ket:vket,st:0,pembetulan:$('#pembetulanKe').val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 table.draw();
								 $('#tabledata').DataTable().ajax.reload();			
								 $("#tabledata_final").DataTable().ajax.reload();			
							     $("#tabledata_nonfinal").DataTable().ajax.reload();
								 $("body").removeClass("loading");
								 flashnotif('Sukses','Data Berhasil di Reject!','success' );
								 $("#keterangan").val("");
							} else {
								 $("body").removeClass("loading");
								 flashnotif('Error','Data Gagal di Reject!','error' );
							}
								
						}
					});						
				}
			}
			});			
			
		})
		
		
		$("#btnReset").on('click', function(){				
			$("#keterangan").val("");	
		})
	
	function valueAdd()
	{
		vkodepajak	= $("#jenisPajak").val();
		vnamapajak 	= $("#jenisPajak").find(":selected").attr("data-name");
		vbulan		= $("#bulan").val();
		vnmbulan	= $("#bulan").find(":selected").attr("data-name");
		vtahun		= $("#tahun").val();		
	}
	
	function getSelectPajak()
	{
		$.ajax({
				url		: "<?php echo site_url('pph21/load_master_pajak') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#jenisPajak").html("");					
					$("#jenisPajak").html(result);					
				}
		});			
	}
	
	function getStart()
	{
		$.ajax({
			url		: "<?php echo site_url('pph21/get_start') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak, pembetulan:$("#pembetulanKe").val()}),			
			success	: function(result){
				if (result.isSuccess==1) {
					if(result.status_period=="OPEN"){ 
						if(result.status=="SUBMIT"){
							$("#btnApprov, #btnReject").slideDown(700);
						} else if(result.status=="APPROVAL SUPERVISOR"){
							$("#btnApprov").slideUp(700);
							$("#btnReject").slideDown(700);
						} else {
							$("#btnApprov, #btnReject").slideUp(700);
						}
					} else {
						$("#btnApprov, #btnReject").slideUp(700);
					}						 
				} else {
					$("#btnApprov, #btnReject").slideUp(700);
				}				
			}			
		});	
	}
	
	
	function getSummary()
	{
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_summary_rekonsiliasiAll1'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._step				= "APPROV";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center", "width" : "5%" },					
					{ "data": "saldo_awal", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_debet", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_kredit", "class":"text-right", "width" : "15%" },
					{ "data": "saldo_akhir", "class":"text-right", "width" : "20%" },
					{ "data": "jumlah_dibayarkan", "class":"text-right", "width" : "15%" },				
					{ "data": "selisih", "class":"text-right", "width" : "15%" }						
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			 
			});	
			
			
			 $('#tabledata-summaryAll1').DataTable().on( 'draw', function () {
				$("#saldoAwal, #mutasiDebet,#mutasiKredit, #saldoAkhir, #jmlDibayarkan, #selisih, #tidakDilaporkan").number(true,2);
				$("#saldoAwal, #mutasiDebet, #mutasiKredit").on("keyup", function(){
					var saldo_akhir	= parseFloat($("#saldoAwal").val()) + ( parseFloat($("#mutasiDebet").val()) - parseFloat($("#mutasiKredit").val()) );					
					$("#saldoAkhir").val(number_format(saldo_akhir,2,".",","));					
				});				
				
			 });
			
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}
		
		/* Awal detail Summary======================================================= */
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
		$('#table-detail-summary').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_detail_summary'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchTipe		= "APPROV";
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
					{ "data": "npwp1" },
					{ "data": "nama_wp" },					
					{ "data": "no_faktur_pajak" },					
					{ "data": "tanggal_faktur_pajak" },					
					{ "data": "dpp" , "class":"text-right" },
					{ "data": "jumlah_potong" , "class":"text-right" },
					{ "data": "keterangan" }
				],	
			"columnDefs": [ 
				 {
					"targets": [ 3,4 ],					
					"visible": false
				} 
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
			url		: "<?php echo site_url('pph21/load_total_detail_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchTipe : "APPROV" }),
			success	: function(result){						
					$("#dTotalselisih").html("<h4><strong>TOTAL SELISIH &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );
			}
		});	
		
		/* Akhir detail Summary======================================================= */
	}
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Search No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();			
	});
	
	
	
	
 });
    </script>
