<div class="container-fluid">
    
    <?php $this->load->view('template_top'); ?>
	
	<div class="white-box boxshadow">	
		<div class="row">
			 <div class="col-lg-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="pilihCabang" name="pilihCabang">
						
					</select> 
				</div>
			 </div>
		 			
			<div class="col-lg-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan">
					<?php
						 $namaBulan = list_month();
						 $bln = date('m');
						/* if ($bln>1){
							 $bln		= $bln - 1;
							 $tahun_n	= 0;
						 } else {
							 $bln		= 12;
							 $tahun_n	= 1;
						 }*/
						 for ($i=1;$i< count($namaBulan);$i++){
							 $selected	= ($i==$bln)?"selected":"";
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
							$tahun	= date('Y');
							$tAwal	= $tahun - 5;	
							$tAkhir	= $tahun ;	
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
			<label>Pembetulan Ke</label>
				<select class="form-control" id="pembetulanKe" name="pembetulanKe">
					<option value="0" selected >0</option> 
					<option value="1">1</option> 
					<option value="2" >2</option>
					<option value="3" >3</option>					
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
			<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Kompilasi Bulanan</a>
					  </div>
					  <div class="col-lg-6">								
						<div class="navbar-right">								 
							
						</div>
					  </div>
					</div>  						   
				</div>
				<div id="collapse-data" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
							<thead>
								<tr>
									<th>#</th>
									<th>NO</th>
									<th>PAJAK LINE ID</th>
									<th>KODE CABANG</th>
									<th>VENDOR ID</th>
									<th>PAJAK HEADER ID</th>
									<th>AKUN PAJAK</th>
									<th>BULAN PAJAK</th>
									<th>TAHUN PAJAK</th>
									<th>MASA PAJAK</th>
									<th>ORGANIZATION ID</th>
									<th>TIPE</th>
									<th>NAMA WP</th>                                        
									<th>NPWP</th>
									<th>ALAMAT</th>
									<th>JENIS PAJAK</th>
									<th>CABANG</th>
									<th>INVOICE NUMBER</th>
									<th>NOMOR FAKTUR PAJAK</th>
									<th>TANGGAL FAKTUR PAJAK</th>
									<th>NO BUKTI POTONG</th>										
									<th>GL ACCOUNT</th>										
									<th>KODE PAJAK</th>																				
									<th>DPP</th>
									<th>TARIF (%)</th>
									<th>JUMLAH POTONG</th>										
									<th>NEW KODE PAJAK</th>
									<th>NEW DPP</th>
									<th>NEW TARIF (%)</th>
									<th>NEW JUMLAH POTONG</th>
								</tr>
							</thead>

						</table>
						</div>                            
				   </div>
					<div class="panel-footer"> 
						
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
						<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Kompilasi Bulanan Final</a>
					  </div>
					  <div class="col-lg-6">								
						<div class="navbar-right">								 
							
						</div>
					  </div>
					</div>  						   
				</div>
				<div id="collapse-data" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata1"> 
							<thead>
								<tr>
									<th>#</th>
									<th>NO</th>
									<th>PAJAK LINE ID</th>
									<th>KODE CABANG</th>
									<th>VENDOR ID</th>
									<th>PAJAK HEADER ID</th>
									<th>AKUN PAJAK</th>
									<th>BULAN PAJAK</th>
									<th>TAHUN PAJAK</th>
									<th>MASA PAJAK</th>
									<th>ORGANIZATION ID</th>
									<th>TIPE</th>
									<th>NAMA WP</th>                                        
									<th>NPWP</th>
									<th>ALAMAT</th>
									<th>JENIS PAJAK</th>
									<th>CABANG</th>
									<th>INVOICE NUMBER</th>
									<th>NOMOR FAKTUR PAJAK</th>
									<th>TANGGAL FAKTUR PAJAK</th>
									<th>NO BUKTI POTONG</th>										
									<th>GL ACCOUNT</th>										
									<th>KODE PAJAK</th>																				
									<th>DPP</th>
									<th>TARIF (%)</th>
									<th>JUMLAH POTONG</th>										
									<th>NEW KODE PAJAK</th>
									<th>NEW DPP</th>
									<th>NEW TARIF (%)</th>
									<th>NEW JUMLAH POTONG</th>
								</tr>
							</thead>

						</table>
						</div>                            
				   </div>
					<div class="panel-footer"> 
						
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
						<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Kompilasi Bulanan Non Final</a>
					  </div>
					  <div class="col-lg-6">								
						<div class="navbar-right">								 
							
						</div>
					  </div>
					</div>  						   
				</div>
				<div id="collapse-data" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata2"> 
							<thead>
								<tr>
									<th>#</th>
									<th>NO</th>
									<th>PAJAK LINE ID</th>
									<th>KODE CABANG</th>
									<th>VENDOR ID</th>
									<th>PAJAK HEADER ID</th>
									<th>AKUN PAJAK</th>
									<th>BULAN PAJAK</th>
									<th>TAHUN PAJAK</th>
									<th>MASA PAJAK</th>
									<th>ORGANIZATION ID</th>
									<th>TIPE</th>
									<th>NAMA WP</th>                                        
									<th>NPWP</th>
									<th>ALAMAT</th>
									<th>JENIS PAJAK</th>
									<th>CABANG</th>
									<th>INVOICE NUMBER</th>
									<th>NOMOR FAKTUR PAJAK</th>
									<th>TANGGAL FAKTUR PAJAK</th>
									<th>NO BUKTI POTONG</th>										
									<th>GL ACCOUNT</th>										
									<th>KODE PAJAK</th>																				
									<th>DPP</th>
									<th>TARIF (%)</th>
									<th>JUMLAH POTONG</th>										
									<th>NEW KODE PAJAK</th>
									<th>NEW DPP</th>
									<th>NEW TARIF (%)</th>
									<th>NEW JUMLAH POTONG</th>
								</tr>
							</thead>

						</table>
						</div>                            
				   </div>
					<div class="panel-footer"> 
						
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
											<th>CABANG</th>																	
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
						<div class="row navbar-right">						
							<div class="col-lg-12">										
								<div id="dTotalBayar"></div>
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
									<div class="col-lg-8 col-sm-8 col-md-8 col-xs-8">
										<div id="dDetail-summary" class="table-responsive"> 
											<p class="text-center"><strong>LIST SEMUA DETAIL</strong> </p>
											<table width="100%" class="display cell-border stripe hover small" id="table-detail-summary"> 
												<thead>
													<tr>									
														<th>NO</th>																	
														<th>NAMA CABANG</th>																	
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
									<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
										<div id="dDetail-summary-cabang" class="table-responsive"> 
											<p class="text-center"><strong>LIST SUMMARY PER CABANG</strong> </p>
											<table width="100%" class="display cell-border stripe hover small" id="table-detail-summary-cabang"> 
												<thead>
													<tr>									
														<th>NO</th>																	
														<th>NAMA CABANG</th>
														<th>TOTAL JUMLAH POTONG</th>
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
	
</div>

<script>
$(document).ready(function(){
	var table="", table1="", table2="";
	$("#d-FormCsv").hide();
	getSelectCabang();
	getSelectPajak();
	getSummary();	
	$("#uplPph").val($("#jenisPajak").val());
	
	Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "kode_cabang" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "tipe_21" },
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "alamat_wp" },
					{ "data": "nama_pajak" },
					{ "data": "nama_cabang" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 0,2,3,4,5,6, 7, 8,9,10,11,15,16,17,18,19,20,21,26,27,28,29 ],
					"visible": false
				} 
			],			
			/* "fixedColumns"	:   {
					"leftColumns": 2
			},	 */	
			// "select"			: true,
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
		 
		table = $('#tabledata').DataTable();
		
		$("input[type=search]").addClear();		
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Tipe / Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		$("#btnView").on("click", function(){
			console.log('cek');
			getSummary();
			$("#uplPph").val($("#jenisPajak").val());
			table.ajax.reload();
			$('#tabledata1').DataTable().ajax.reload();
			$('#tabledata2').DataTable().ajax.reload();
		});
		
		 table.on( 'draw', function () {			
			//getFormCSV(); 
		} );	
	
		   $('#tabledata1').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_kompilasi1'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "kode_cabang" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "tipe_21" },
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "alamat_wp" },
					{ "data": "nama_pajak" },
					{ "data": "nama_cabang" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 0,2,3,4,5,6, 7, 8,9,10,11,15,16,17,18,19,20,21,26,27,28,29 ],
					"visible": false
				} 
			],			
			/* "fixedColumns"	:   {
					"leftColumns": 2
			},	 */	
			// "select"			: true,
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});		 
		 
		table1 = $('#tabledata1').DataTable();
		
		$("input[type=search]").addClear();		
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Tipe / Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table1.search('').column().search('').draw();			
		});			
							
		   $('#tabledata2').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_kompilasi2'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "kode_cabang" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "tipe_21" },
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "alamat_wp" },
					{ "data": "nama_pajak" },
					{ "data": "nama_cabang" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "kode_pajak" },					
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 0,2,3,4,5,6, 7, 8,9,10,11,15,16,17,18,19,20,21,26,27,28,29 ],
					"visible": false
				} 
			],			
			/* "fixedColumns"	:   {
					"leftColumns": 2
			},	 */	
			// "select"			: true,
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});		 
		 
		table2 = $('#tabledata2').DataTable();
		
		$("input[type=search]").addClear();		
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Tipe / Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table2.search('').column().search('').draw();			
		});
	
		
	function getSummary()
	{
		//ambil saldo awal==================================================================
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_summary_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center", "width" : "5%" },					
					{ "data": "cabang", "width" : "15%" },					
					{ "data": "saldo_awal", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_debet", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_kredit", "class":"text-right", "width" : "15%" },
					{ "data": "saldo_akhir", "class":"text-right", "width" : "15%" },
					{ "data": "jumlah_dibayarkan", "class":"text-right", "width" : "10%" },				
					{ "data": "selisih", "class":"text-right", "width" : "10%" }					
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			 
			});	
			
			
			 $('#tabledata-summaryAll1').DataTable().on( 'draw', function () {
				$("#saldoAwal, #mutasiDebet,#mutasiKredit, #saldoAkhir, #jmlDibayarkan, #selisih, #tidakDilaporkan").number(true,2);
				$("#saldoAwal, #mutasiDebet, #mutasiKredit").on("keyup", function(){
					var saldo_akhir	= parseFloat($("#saldoAwal").val()) + ( parseFloat($("#mutasiDebet").val()) - parseFloat($("#mutasiKredit").val()) );
					//var selisih		= parseFloat(saldo_akhir) - parseFloat($("#jmlDibayarkan").val());
					$("#saldoAkhir").val(number_format(saldo_akhir,2,".",","));
					//$("#selisih").val(number_format(selisih,2,".",","));
				});				
			 });
			
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}
		//ambil total==================================================================
		
		/* Awal detail Summary Selisih======================================================= */
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
		$('#table-detail-summary').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_detail_summary_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
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
					{ "data": "nama_cabang"},					
					{ "data": "npwp1" },
					{ "data": "vendor_name" },					
					{ "data": "no_faktur_pajak" },					
					{ "data": "tanggal_faktur_pajak" },					
					{ "data": "dpp" , "class":"text-right" },
					{ "data": "jumlah_potong" , "class":"text-right" },
					{ "data": "keterangan" }
				],	
			"columnDefs": [ 
				 {
					"targets": [ 3,4,5 ],					
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
		//==================================================================
		
		//ambil jumlah selisih percabang==================================================================
		//sini cek
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary-cabang' ) ) {
		 $('#table-detail-summary-cabang').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_detail_summary_kompilasi_cabang'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#pilihCabang').val();
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center", "width" : "10%" },					
					{ "data": "nama_cabang", "width" : "50%" },					
					{ "data": "jumlah_potong", "class":"text-right", "width" : "40%" }					
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			 
			});		
			
		} else {
			$('#table-detail-summary-cabang').DataTable().ajax.reload();
		}
		//==================================================================
		
		//ambil total selisih==================================================================
		$.ajax({
			url		: "<?php echo site_url('pph21/load_total_detail_summary_kompilasi') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchCabang : $('#pilihCabang').val() }),
			success	: function(result){										
					$("#dTotalselisih").html("<h4><strong>TOTAL SELISIH &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );				
					
			}
		});	
		//==================================================================
		
		$.ajax({
			url		: "<?php echo site_url('pph21/load_total_bayar') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchCabang : $('#pilihCabang').val() }),
			success	: function(result){										
					$("#dTotalBayar").html("<h4>TOTAL DI BAYAR &nbsp; : &nbsp;<span class='label label-info'>"+number_format(result.jml_potong,2,'.',',')+"</span></h4>" );				
					
			}
		});	
		
		/* Akhir detail Summary======================================================= */			
	}
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Cari No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();			
	});
	
	$("#dDetail-summary-cabang input[type=search]").addClear();		
	$('#dDetail-summary-cabang .dataTables_filter input[type="search"]').attr('placeholder','Cari Nama Cabang ...').css({'width':'150px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary-cabang .add-clear-x").on('click',function(){
		$('#table-detail-summary-cabang').DataTable().search('').column().search('').draw();			
	});
	
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

	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_master_cabang') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					var vall ='<option value="" data-name="" selected >Semua</option>';
					$("#pilihCabang").html("");					
					$("#pilihCabang").html(vall+result);					
				}
		});			
	}
	
})

</script>
