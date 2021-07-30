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
						<option value="PPN WAPU" data-name="PPN WAPU" >PPN WAPU</option>
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
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>
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
								List Data PPN WAPU
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">								 
									<button type="button" id="btnDetail" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> DETAIL</button>						
								</div>
							  </div>
							</div>  						   
						</div>	
													
							<!--<div id="collapse-data" class="panel-collapse collapse in">-->
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK_HEADER_ID</th>
													<th>KODE_CABANG</th>
													<th>BULAN</th>
													<th>PAJAK</th>
													<th>MASA</th>
													<th>TAHUN</th>
													<th>CREATION DATE</th>
													<th>OLEH</th>
													<th>STATUS</th>
													<th>TANGGAL SUBMIT</th>
													<th>TANGGAL APPROVE</th>												
													<th>TANGGAL APPROVE PUSAT</th>
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
					<!--<div class="row">
					  <div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Detail Data PPh</a>
					  </div>
					  <div class="col-lg-6">								
						<div class="navbar-right">								 
							<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> HAPUS</button>
						</div>
					  </div>
					</div> --> 	
					<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data"><div id="dTitleDetail">List Detail PPN WAPU</div></a>
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
									<th>KODE LAMPIRAN</th>
                                    <th>KODE TRANSAKSI</th>
                                    <th>KODE STATUS</th>
                                    <th>KODE DOKUMEN</th>
									<th>NPWP LAWAN TRANSAKSI</th>
                                    <th>NAMA LAWAN TRASAKSI</th>
                                    <th>KODE CABANG</th>
                                    <th>DIGIT TAHUN</th>
                                    <th>NO SERI FP/NO NOTA RETUR</th>
                                    <th>TANGGAL FAKTUR</th>
                                    <th>MASA PAJAK</th>
                                    <th>TAHUN PAJAK</th>
                                    <th>PEMBETULAN</th>
                                    <th>TANGGAL TAGIH</th>
                                    <th>TANGGAL SETOR PPN</th>
                                    <th>TANGGAL SETOR PPN BM</th>
                                    <th>INVOICE NUMBER</th>
                                    <th>TANGGAL GL</th>
                                   	<th>MATA UANG</th>
                                    <th>JUMLAH DPP</th>
                                    <th>JUMLAH PPN</th>
                                    <th>JUMLAH PPN BM</th>
									<th>ORGANIZATION ID</th>
									<th>ALAMAT</th>
									<th>JENIS PAJAK</th>
									<th>INVOICE NUMBER</th>
									<th>NO BUKTI POTONG</th>									
									<th>KODE PAJAK</th>																				
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
					<!-- <div class="panel-footer">
						<div class="row">
							<b>Ringkasan</b>
						</div>
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
											<th>TIDAK DIBAYARKAN</th>
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
	</div> -->

	<!-- ============================================ -->
						<hr>
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-xs-12">
								<div class="white-box boxshadow animated slideInDown">			
									<ul class="nav customtab nav-tabs" role="tablist">
										<li role="presentation" class="active"><a href="#tab-summary" aria-controls="tab-summary" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-codepen fa-fw"></i> Ringkasan</span></a></li>
										<li role="presentation" class=""><a id="aDetailSummary" href="#tab-detail" aria-controls="tab-detail" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-dropbox fa-fw"></i> Selisih</span></a></li>
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
																<th>PPN/JUMLAH POTONG</th>
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
										</br>
								 <div class="row">
								 	<div class="col-lg-9"></div>
									<div class="col-lg-3">
										<div class="form-group">
											<label>Jumlah Tidak Dilaporkan</label>
											<input type="text" class="form-control text-right" id="jmlTidakDilaporkan" name="jmlTidakDilaporkan" disabled >
										</div>
									 </div>
									  <!-- <div class="col-lg-3">
										<div class="form-group">
											<label>Jumlah Tgl 26 - 31</label>
											<input type="text" class="form-control text-right" id="jmlTglAkhir" name="jmlTglAkhir" disabled >
										</div>
									 </div>
									 <div class="col-lg-3">
										<div class="form-group">
											<label>Jumlah Import CSV</label>
											<input type="text" class="form-control text-right" id="jmlImportCSV" name="jmlImportCSV" disabled >
										</div>
									 </div>
									 <div class="col-lg-3">
										<div class="form-group">
											<label>Total Selisih</label>
											<input type="text" class="form-control text-right" id="totalSelisih" name="totalSelisih" disabled >
										</div>
									 </div> -->
								 </div>			
										
									</div>
								</div>
							</div>
						  </div>						
						<!-- ============================================ -->

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
						<div class="row">
  				  </br>
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
 
 
  <!-- <div class="row">
  	<div class="col-lg-12 col-sm-12 col-xs-12">
  		<div class="white-box boxshadow animated slideInDown">			
  			<ul class="nav customtab nav-tabs" role="tablist">
  				<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Download</span></a></li>
  				<li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Cetak</span></a></li>
  			</ul>
  			
  			<div class="tab-content">
  				<div role="tabpanel" class="tab-pane fade active in" id="tab-download">
  					<div class="col-lg-12">
  						<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
  						<button type="button" id="btnCSVSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
  					</div>
  					<div class="clearfix"></div>
  				</div>
  				<div role="tabpanel" class="tab-pane fade" id="tab-cetak">
  					<div class="col-lg-12">						
  						 <button type="button" id="btnAllBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Semua Bupot</button>
  						 <button type="button" id="btnBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Bupot Satuan</button>
  						 <button type="button" id="btnDaftar" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Daftar Bupot</button>
  						 <button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
  					</div>
  					<div class="clearfix"></div>
  				</div>			
  				
  			</div>
  			<div class="row">
  				  </br>
  				  <div class="col-lg-12">  
  					<div class="navbar-right">
  						<button type="button" class="btn btn-danger btn-rounded waves-effect" id="btnBack"><i class="fa fa-reply"></i> Back</button>
  					</div>
  				  </div>
  			</div>
  		</div>
  	</div>
  </div> -->
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
			
		Pace.track(function(){  
		   $('#tabledata').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_view'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
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
					"targets": [ 1,2, 3 ],
					"visible": false
				} 
			],			
			/*"fixedColumns"	:   {
					"leftColumns": 1
			},*/	
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
			 $("#detail-data").slideDown(700);
			 $("#list-data").slideUp(700);
			 getDataLines();
		});	
		
		$("#btnView").on("click", function(){
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
									 "url"  		: "<?php echo site_url('ppn_wapu/load_rekonsiliasi_detail'); ?>",
									 "type" 		: "POST",								
									 "data"			: function ( d ) {
											d._searchBulan 		= vbulan;
											d._searchTahun 		= vtahun;
											d._searchPph		= vnamapajak;
											d._searchPembetulan	= vpembetulan;
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
						{ "data": "vendor_id" },
						{ "data": "pajak_header_id" },
						{ "data": "akun_pajak" },
						{ "data": "masa_pajak" },
						{ "data": "kode_lampiran", "class":"text-center" },
						{ "data": "kode_transaksi", "class":"text-center" },
						{ "data": "kode_status", "class":"text-center" },
						{ "data": "kode_dokumen", "class":"text-center" },
						{ "data": "npwp" },
						{ "data": "nama_wp" },
						{ "data": "kode_cabang" },
						{ "data": "digit_tahun" },
						{ "data": "no_faktur_pajak" },
						{ "data": "tanggal_faktur_pajak" },
						{ "data": "bulan_pajak", "class":"text-center"},
						{ "data": "tahun_pajak", "class":"text-center" },
						{ "data": "pembetulan", "class":"text-center" },
						{ "data": "tgl_tagih" },
						{ "data": "tgl_setor_ppn" },
						{ "data": "tgl_setor_ppnbm" },
						{ "data": "invoice_num" },
						{ "data": "invoice_accounting_date" },
						{ "data": "currency_code" },
						{ "data": "dpp", "class":"text-right" },
						{ "data": "jumlah_ppn", "class":"text-right" },
						{ "data": "jumlah_ppnbm", "class":"text-right" },
						{ "data": "organization_id" },
						{ "data": "alamat_wp" },
						{ "data": "nama_pajak" },
						{ "data": "invoice_num" },
						{ "data": "no_bukti_potong" },
						{ "data": "kode_pajak" },
						{ "data": "tarif", "class":"text-center" },
						{ "data": "jumlah_potong", "class":"text-right" },
						{ "data": "new_kode_pajak" },
						{ "data": "new_dpp", "class":"text-right" },	
						{ "data": "new_tarif", "class":"text-center" },
						{ "data": "new_jumlah_potong", "class":"text-right" }
					],
				"columnDefs": [ 
					 {
						"targets": [ 2,3,4,5,6,29,30,31,32,33,34,35,36,37,38,39,40 ],
						"visible": false
					} 
				],		
				  	"select"			: true,
			 		//"pageLength"		: 100,
			 		"scrollY"			: 480, 
			 		"scrollCollapse"	: true, 
			 		"scrollX"			: true,
			 		"ordering"			: false,
			 		"pageLength"		: 100,
					"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
				});
				/*var table_lines = $("#tabledata-lines").DataTable();
				$('#tabledata-lines tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');											
					} else {
						table_lines.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');						
					}						 
				});
			} else {
				table_lines.ajax.reload();
			}
		}*/

		} else {
				$("#tabledata-lines").DataTable().ajax.reload();
			}
			getSummary();
			getHistory();
		}
		
	/*function getSummary()
	{
		$("#dTitleDetail2").html("List Histori Data "+vnamapajak+" Bulan "+vmasa+" Tahun "+vtahun+" Pembetulan Ke "+vpembetulan);
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
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },					
					{ "data": "saldo_awal", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_debet", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_kredit", "class":"text-right", "width" : "15%" },
					{ "data": "saldo_akhir", "class":"text-right", "width" : "18%" },
					{ "data": "jumlah_dibayarkan", "class":"text-right", "width" : "15%" },
					{ "data": "selisih", "class":"text-right", "width" : "18%" },
					{ "data": "tidak_dilaporkan", "class":"text-right", "width" : "15%" }
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			
			});					
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}
	}*/

	function getSummary()
	{		

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_summary_rekonsiliasiAll1'); ?>",
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
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center", "width" : "5%" },					
					{ "data": "saldo_awal", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_debet", "class":"text-right", "width" : "15%" },
					{ "data": "mutasi_kredit", "class":"text-right", "width" : "15%" },
					{ "data": "saldo_akhir", "class":"text-right", "width" : "18%" },
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
					//var selisih		= parseFloat(saldo_akhir) - parseFloat($("#jmlDibayarkan").val());
					$("#saldoAkhir").val(number_format(saldo_akhir,2,".",","));
					//$("#selisih").val(number_format(selisih,2,".",","));
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
								 "url"  		: "<?php echo site_url('ppn_wapu/load_detail_summary'); ?>",
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
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
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
					"targets": [ 5 ],					
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
			url		: "<?php echo site_url('ppn_wapu/load_total_detail_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: vnamapajak, _searchBulan : vbulan, _searchTahun : vtahun, _searchPembetulan: vpembetulan, _searchTipe : "VIEW" }),
			success	: function(result){						
					$("#jmlTidakDilaporkan").val(number_format(result.jml_tidak_dilaporkan,2,'.',','));						
					$("#jmlTglAkhir").val(number_format(result.jml_tgl_akhir,2,'.',','));			
					$("#jmlImportCSV").val(number_format(result.jml_import_csv,2,'.',','));		
					$("#totalSelisih").val(number_format(result.total,2,'.',','));	
			}
		});	
		
		/* Akhir detail Summary======================================================= */
	}
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Cari No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();			
	});
	
	function getHistory()
	{
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-history' ) ) {
		 $('#tabledata-history').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_history'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= vbulan;
										d._searchTahun 		= vtahun;
										d._searchPph		= vnamapajak;
										d._searchPembetulan	= vpembetulan;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<h5><span class='label label-danger'>Data not found!</span></h5>",	
					"infoEmpty"		: "Empty Data",
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

