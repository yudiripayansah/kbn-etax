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
			 <div class="col-lg-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="PPN WAPU" data-name="PPN WAPU" selected >PPN WAPU</option>
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
					 <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">DAFTAR PPN WAPU</a>
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
													<th>BULAN PAJAK</th>
													<th>KODE LAMPIRAN</th>
                                        			<th>KODE TRANSAKSI</th>
                                        			<th>KODE STATUS</th>
                                        			<th>KODE DOKUMEN</th>
													<th>NPWP LAWAN TRANSAKSI</th>
													<th>NAMA LAWAN TRANSAKSI</th>
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
							</div>
						</div>						
					</div>
                </div>                
            </div>
	<!--		
	<div class="row">
	  <div class="col-lg-12">
		<div class="panel panel-default boxshadow animated slideInDown">					
			<div class="panel-body">
				<ul class="nav nav-pills">
					<li class="active"><a href="#tab-download" data-toggle="tab"><i class="fa fa-download fa-fw"></i> Download</a>
					</li>
					<li><a href="#tab-cetak" data-toggle="tab"><i class="fa fa-print fa-fw"></i> Cetak</a>
					</li>					
				</ul>				
				<div class="tab-content">
					<div class="tab-pane fade in active" id="tab-download">
						<div class="row">
							<div class="col-lg-12">
								<hr>
								<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
								<button type="button" id="btnCSVSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-cetak">
						<div class="row">
							<div class="col-lg-12">
								<hr>
								 <button type="button" id="btnAllBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Semua Bupot</button>
								 <button type="button" id="btnBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Single Bupot</button>
								 <button type="button" id="btnDaftar" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Daftar Bupot</button>
								 <button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
							</div>
						</div>
					</div>					
				</div>
			</div>
			
		</div>
				
		</div>
	</div> 
	-->
	<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box boxshadow animated slideInDown">			
			<ul class="nav customtab nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Download</span></a></li>
				<!-- <li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Cetak</span></a></li> -->
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab-download">
					<div class="col-lg-12">
						<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
						<!-- <button type="button" id="btnCSVSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button> -->
					</div>
					<div class="clearfix"></div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tab-cetak">
					<div class="col-lg-12">						
						 <!-- <button type="button" id="btnAllBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Semua Bupot</button>
						 <button type="button" id="btnBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Single Bupot</button>
						 <button type="button" id="btnDaftar" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Daftar Bupot</button> -->
						 <!-- <button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button> -->
					</div>
					<div class="clearfix"></div>
				</div>			
				
			</div>
		</div>
	</div>
  </div>
</div>


<script>
    $(document).ready(function() {
			var table	= "", vkodepajak = "",vbulan = "", vtahun ="";				
		
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_download'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	    = $('#bulan').val();
										d._searchTahun 	    = $('#tahun').val();
										d._searchPph	    = $('#jenisPajak').val();
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
					{ "data": "bulan_pajak", "class":"text-center" },
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
					"targets": [ 1,2,3,4,5,28,29,30,31,32,33,34,35,36,37,38 ],
					"visible": false
				} 
			],			
			"fixedColumns"	:   {
					"leftColumns": 1
			},		
			 "select"			: true,
			 //"pageLength"		: 100,
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
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
		}).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		});
		
		
		table.on( 'draw', function () {			
		  if (table.data().any()){
			 $(".isAktif").removeAttr("disabled");
		  } else {
			 $(".isAktif").attr("disabled", true);
		  }
		});
			
  
	$("#btnView").on("click", function(){		
		table.ajax.reload();		
	});
	
	$("#btnCSV").on("click", function(){			
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_format_csv";
			vkodepajak	= $("#jenisPajak").val();
			vbulan		= $("#bulan").val();
			vtahun		= $("#tahun").val();
			vpembetulan	= $("#pembetulanKe").val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 exit();
			} else {
				window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&ke='+vpembetulan, '_blank');
				window.focus(); 				
			}
	});
    	
	//Add By Derry 23 April 2018	
	$("#btnSPT").on("click", function(){
		var url 	="<?php echo site_url(); ?>ppn_wapu/cetak_summary_wapu";
		vpembetulanKe	= $("#pembetulanKe").val();
		vbulan			= $("#bulan").val();
		vtahun			= $("#tahun").val();

		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?pembetulanKe='+vpembetulanKe+'&bulan='+vbulan+'&tahun='+vtahun, '_blank');
			window.focus();
		}
	});
	// end Derry
	
 });
    </script>
