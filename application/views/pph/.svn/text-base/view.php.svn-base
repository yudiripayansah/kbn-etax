<div class="container-fluid">
<?php $this->load->view('template_top'); ?>	
	
 <div id="list-data">
	<div class="white-box boxshadow">	
		<div class="row"> 
			<div class="col-lg-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan" placeholder="Pilih Bulan">
						<?php
						 $namaBulan = list_month();
						 $bln	= date('m');
						 echo "<option value='' >-- Pilih --</option>";
						 for ($i=1;$i< count($namaBulan);$i++){
							$selected	= "";
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
							$tAkhir	= $tahun;	
							echo "<option value='' >-- Pilih --</option>";
							for($i=$tAwal; $i<=$tAkhir;$i++){
								$selected	= "";
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
					</select> 
				</div>
			 </div>
			<div class="col-lg-2">	
				<div class="form-group">
				<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="" >-- Pilih --</option> 
						<option value="0" >0</option> 
						<option value="1" >1</option> 
						<option value="2" >2</option>
						<option value="3" >3</option>					
					</select>
				</div>
		  </div>
			 <div class="col-lg-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
				</div>
			  </div> 
			 
		</div>			
	 </div>
	
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow">
						<div class="panel panel-info">
						<div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								<!--<h4 class="panel-title"><a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Rekonsiliasi</a></h4>-->
								List Data PPh
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">								 
									<button type="button" id="btnDetail" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-list"></i> DETAIL</button>						
								</div>
							  </div>
							</div>  						   
						</div>	
													
							<!--<div id="collapse-data" class="panel-collapse collapse in">-->
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK_HEADER_ID</th>
													<th>KODE_CABANG</th>
													<th>BULAN</th>
													<th>NAMA PAJAK</th>
													<th>MASA</th>
													<th>TAHUN</th>
													<th>TANGGAL DIBUAT</th>
													<th>OLEH</th>
													<th>STATUS</th>
													<th>TANGGAL SUBMIT</th>
													<th>TANGGAL APPROVE</th>												
													<th>TANGGAL APPROVE ADMIN</th>												
													<th>PEMBETULAN KE</th>												
													<th>TOTAL JUMLAH POTONG</th>												
												</tr>
											</thead>
										</table>
									</div>
								</div>
							<!--</div>-->
						</div>						
					</div>
                </div>
            </div>	
			
	</div>
	
  
 <div id="detail-data">	
 
	<div class="row"> 	
		<div class="col-lg-12">	
			<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">					
					<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data"><div id="dTitleDetail">List Detail PPh</div></a>
				</div>
				<div id="collapse-data" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata-lines"> 
							<thead>
								<tr>
									<th>#</th>
									<th>NO</th>
									<th>PAJAK LINE ID</th>
									<th>VENDOR ID</th>
									<th>PAJAK HEADER ID</th>
									<th>AKUN PAJAK</th>
									<th>BULAN PAJAK</th>
									<th>TAHUN PAJAK</th>
									<th>MASA PAJAK</th>
									<th>ORGANIZATION ID</th>
									<th>NAMA WP</th>                                        
									<th>NPWP</th>
									<th>ALAMAT</th>
									<th>JENIS PAJAK</th>
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
						
						<!-- ============================================ -->
						<hr>
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-xs-12">
								<div class="white-box boxshadow animated slideInDown">			
									<ul class="nav customtab nav-tabs" role="tablist">
										<li role="presentation" class="active"><a id="aTab-summary" href="#tab-summary" aria-controls="tab-summary" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-codepen fa-fw"></i> Ringkasan</span></a></li>
										<li role="presentation" class=""><a id="aDetailSummary" href="#tab-detail" aria-controls="tab-detail" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-dropbox fa-fw"></i> Tidak Dilaporkan</span></a></li>
									</ul>
									
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane fade active in" id="tab-summary">
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
											<div class="clearfix"></div>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="tab-detail">
											 <div class="row" id="dDetail-summary">						
												<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
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
											 <div class="row navbar-right">								
												<div class="col-lg-12">
													<div id="dTotalselisih"></div>								
												 </div>									
											 </div>
											<div class="clearfix"></div>
										</div>			
										
									</div>
								</div>
							</div>
						  </div>						
						<!-- ============================================ -->					   
				   </div>					
			  </div>
			</div>
		</div>
	</div>
 
  <div class="row"> 	
		<div class="col-lg-12">	
			<div id="accordion2" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">
					<a id="aTitleList2" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-data2"><div id="dTitleDetail2">List Histori</div></a>
				</div>
				<div id="collapse-data2" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata-history"> 
							<thead>
								<tr>
									<th>NO</th>
									<th>PROSES</th>
									<th>TANGGAL PROSES</th>
									<th>USERNAME</th>
									<th>KETERANGAN</th>									
								</tr>
							</thead>

						</table>
						</div>                            
				   </div>
				  </div>
					<div class="panel-footer">	
						 <div class="row">							  
							  <div class="col-lg-12">  
								<div class="navbar-right">
									<button type="button" class="btn btn-danger btn-rounded waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
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

<script>
    $(document).ready(function() {
			var table	= "", vidpajakheader="",vnamapajak="", vbulan="", vmasa="", vtahun="", vpembetulan="";
			
			$("#detail-data").hide();
			getSelectPajak();
			
		Pace.track(function(){  
		   $('#tabledata').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_view'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_header_id"},
					{ "data": "kode_cabang" },
					{ "data": "bulan_pajak" },
					{ "data": "nama_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "creation_date" },
					{ "data": "user_name" },
					{ "data": "status" },					
					{ "data": "tgl_submit_sup"},
					{ "data": "tgl_approve_sup" },
					{ "data": "tgl_approve_pusat" },
					{ "data": "pembetulan_ke","class":"text-center" },
					{ "data": "ttl_jml_potong", "class":"text-right", }
				],
			"columnDefs": [ 
				 {
					"targets": [ 1,2,3,12 ],
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
			 "ordering"			: false			
			});
		 });
		 
		table = $('#tabledata').DataTable();
		
		 
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Status/Catatan ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		 
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empety();
				$("#btnDetail").attr("disabled", true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table.row( this ).data();
				vidpajakheader      = d.pajak_header_id;
				vnamapajak		    = d.nama_pajak;
				vbulan	            = d.bulan_pajak;
				vmasa	            = d.masa_pajak;
				vtahun		    	= d.tahun_pajak;
				vpembetulan	        = d.pembetulan_ke;				
				$("#btnDetail").removeAttr("disabled");
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table.row( this ).data();
			vidpajakheader      = d.pajak_header_id;
			vnamapajak		    = d.nama_pajak;
			vbulan	            = d.bulan_pajak;
			vmasa	            = d.masa_pajak;
			vtahun		    	= d.tahun_pajak;
			vpembetulan	        = d.pembetulan_ke;	
			$("#btnDetail").removeAttr("disabled");
			$("#btnDetail").click();
		} );
		
		$("#btnDetail").on("click", function(){				
			 if(vnamapajak=="" && vbulan=="" && vtahun=="" && vpembetulan==""){
				 flashnotif('Info','Pajak belum dipilih!','warning' );
				 return false;
			 } else {				
				$("#detail-data").slideDown(700);
				$("#list-data").slideUp(700);
				getDataLines();				
			 }
		});	
		
		$("#btnView").on("click", function(){
			$("#btnDetail").attr("disabled", true);
			table.ajax.reload();			
		});
		
		
		$("#btnBack").on("click", function(){		
			$("#detail-data").slideUp(700);
			$("#list-data").slideDown(700);
			empety();
		});	
		
		function empety()
		{
			vidpajakheader      = "";
			vnamapajak		    = "";
			vbulan	            = "";
			vmasa	            = "";
			vtahun		    	= "";
			vpembetulan	        = "";	
		}
		
		function getDataLines()
		{
			$("#dTitleDetail").html("List Detail Data "+vnamapajak+" Bulan "+vmasa+" Tahun "+vtahun+" Pembetulan Ke "+vpembetulan);
			if ( ! $.fn.DataTable.isDataTable( '#tabledata-lines' ) ) {
				$('#tabledata-lines').DataTable({			
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: "<?php echo site_url('pph/load_rekonsiliasi_detail'); ?>",
									 "type" 		: "POST",								
									 "data"			: function ( d ) {
											d._searchBulan 		= vbulan;
											d._searchTahun 		= vtahun;
											d._searchPph		= vnamapajak;
											d._searchPembetulan	= vpembetulan;
										}								
								},
				 "language"		: {
						"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
						"infoEmpty"		: "Data Kosong",
						"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
						"search"		: "_INPUT_"
					},
				   "columns": [
						{ "data": "checkbox", "class":"text-center", "height" : "10px" },
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
						{ "data": "npwp" },
						{ "data": "alamat_wp" },
						{ "data": "nama_pajak" },
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
						"targets": [ 2,3,4,5,6, 7, 8,9 ],
						"visible": false
					} 
				],		
				 "scrollY"			: 480, 
				 "scrollCollapse"	: true, 
				 "scrollX"			: true,
				 "ordering"			: false			
				});
				
				table_lines = $("#tabledata-lines").DataTable();								
		
				$("#tabledata-lines_filter input[type=search]").addClear();		
				$('#tabledata-lines_filter input[type="search"]').attr('placeholder','Cari No Faktur/ Invoice/ Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
				$("#tabledata-lines_filter .add-clear-x").on('click',function(){
					table_lines.search('').column().search('').draw();			
				});
			} else {
				$("#tabledata-lines").DataTable().ajax.reload();
			}
			
			getSummary();
			getHistory();
		}
	
	function getSelectPajak()
	{
		$.ajax({
				url		: "<?php echo site_url('pph/load_master_pajak') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#jenisPajak").html("");
					var optKos = "<option value='' data-name='' >-- Pilih --</option>";
					$("#jenisPajak").html(optKos+result);				
				}
		});			
	}
	
	function getSummary()
	{
		$("#dTitleDetail2").html("List Histori Data "+vnamapajak+" Bulan "+vmasa+" Tahun "+vtahun+" Pembetulan Ke "+vpembetulan);
		$("#aTab-summary").click();
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_summary_rekonsiliasiAll1'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= vbulan;
										d._searchTahun 		= vtahun;
										d._searchPph		= vnamapajak;
										d._searchPembetulan	= vpembetulan;
										d._step				= "VIEW";
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
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
			
			//===================================================================================================
			$("#aDetailSummary").on("click", function(){
				if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
					$('#table-detail-summary').DataTable({			
						"serverSide"	: true,
						"processing"	: true,
						"ajax"			: {
											 "url"  		: "<?php echo site_url('pph/load_detail_summary'); ?>",
											 "type" 		: "POST",								
											 "data"			: function ( d ) {
													d._searchBulan 		= vbulan;
													d._searchTahun 		= vtahun;
													d._searchPph		= vnamapajak;
													d._searchPembetulan	= vpembetulan;
													d._searchTipe		= "VIEW";
												}								
										},
						 "language"		: {
								"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
								"infoEmpty"		: "Data Kosong",
								"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
								"search"		: "_INPUT_"
							},
						   "columns": [
								{ "data": "no", "class":"text-center" },					
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
								"targets": [ 3,4 ],					
								"visible": false
							} 
						],		
						 "scrollY"			: 300, 
						 "scrollCollapse"	: true, 
						 "scrollX"			: true,
						 "ordering"			: false			 
						});										
						
						$('#table-detail-summary').DataTable().on( 'draw', function () {
							$("#dDetail-summary input[type=search]").addClear();		
							$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Cari No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
							
							$("#dDetail-summary .add-clear-x").on('click',function(){
								$('#table-detail-summary').DataTable().search('').column().search('').draw();			
							});
						});						
						
						 
					} else {
						$('#table-detail-summary').DataTable().ajax.reload();
					}								
					getSummaryTotal();
				});
			//===================================================================================================
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();			
		}	
		
	}
	
	function getSummaryTotal(){
		$.ajax({
			url		: "<?php echo site_url('pph/load_total_detail_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: vnamapajak, _searchBulan : vbulan, _searchTahun : vtahun, _searchPembetulan: vpembetulan, _searchTipe : "VIEW" }),
			success	: function(result){	
					$("#dTotalselisih").html("<h4><strong>TOTAL SELISIH &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );			
			}
		});
	}
	
	
	function getHistory()
	{
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-history' ) ) {
		 $('#tabledata-history').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_history'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= vbulan;
										d._searchTahun 		= vtahun;
										d._searchPph		= vnamapajak;
										d._searchPembetulan	= vpembetulan;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<h5><span class='label label-danger'>Data Tidak Ditemukan!</span></h5>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "action_code" },
					{ "data": "action_date" },
					{ "data": "user_name" },
					{ "data": "catatan" }
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			
			});			
		} else {
			$('#tabledata-history').DataTable().ajax.reload();
		}
	}
			
 });
    </script>
