<div class="container-fluid">
    
    <?php $this->load->view('template_top'); ?>
	
	<div class="white-box boxshadow">
		<?php if($kantor_cabang == "pusat"){ ?>
		<div class="row">
			<div class="col-sm-4">
                <div class="form-group">
                    <label>Kantor Cabang</label>
                    <select id="kd_cabang" name="kd_cabang" class="form-control" autocomplete="off">
                        <option value=""> Semua Cabang </option>
                        <?php foreach ($list_cabang as $cabang):?>
                        <option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
                        <?php endforeach?>
                    </select>
                </div>
			</div>
		</div>
		<?php } else{ ?>
		<input type="hidden" id="kd_cabang" value="<?php echo $this->session->userdata('kd_cabang') ?>">
		<?php } ?>
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
			<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Kompilasi</a>
					  </div>
					  <div class="col-lg-6">								
						<div class="navbar-right">								 
							<!--<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> Tambah</button>		
							<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> HAPUS</button> -->
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
									<th>DILAPORKAN</th>
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
											<th>NAMA CABANG</th>
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
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary-detail">DATA TIDAK DILAPORKAN</a>
								  </div>						  
								</div> 							
							</div>
							   <div id="collapse-summary-detail" class="panel-collapse collapse in">
								<div class="panel-body"> 					
								 <div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
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
														<th>PPN/JUMLAH POTONG</th>
														<th>KETERANGAN</th>												
													</tr>
												</thead>
											</table> 										
										 </div> 									
									</div>
								</div>
							<!-- <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<div class="panel-body"> 					
					 				<div class="row">
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
							</div> -->

				 <div id="collapse-summary" class="panel-collapse collapse in">
					<div class="panel-body"> 					
					 <div class="row">
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<div class="table-responsive">
							<p class="text-center"><strong>LIST SUMMARY</strong></p> 
								<table width="100%" class="display cell-border stripe hover small" id="summary_kompilasi"> 
									<thead>
										<tr>									
											<th>NO</th>
											<th>NAMA CABANG</th>
											<th>JUMLAH DIBAYARKAN</th>`
											<!-- <th>JUMLAH TANGGAL 21-31</th> 
											<th>JUMLAH IMPORT CSV</th>
											<th>TOTAL SLISIH</th> -->																			
										</tr>
									</thead>
								</table>							
							 </div> 									
							</div>							
					 </div>
					</div>
					<div class="row navbar-right">						
									<div class="col-lg-12">										
											<div id="dTotalselisih"></div>
									 </div>											
								 </div>
								</div>

	<div id="d-FormCsv">
	 <div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			 <div class="white-box boxshadow">
				<div class="row">
					<div class="form-group">
						<label>Download CSV</label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button id="btnEksportCSV" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>Download CSV</span></button>
						</div>
					</div>
				</div>
				</br>
			 </div>
		</div>

		<div id="d-FormCsvntpn">
	 <div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			 <div class="white-box boxshadow">
				<div class="row">
					<div class="form-group">
						<label>Download Format BERNTPN</label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button id="btnEksportCSVntpn" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>Download Format BERNTPN</span></button>
						</div>
					</div>
				</div>
				</br>
			 </div>
	</div>

	<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box boxshadow animated slideInDown">			
			<ul class="nav customtab nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Print</span></a></li>
				<!-- <li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Cetak</span></a></li> -->
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab-download">
					<div class="col-lg-12">
						<button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary Kompilasi </button>
						<!-- <button type="button" id="btnCSVSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button> -->
					</div>
					<div class="clearfix"></div>
				</div>
				</div>
			</div>
		</div>
	</div>
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
  </div>
</div>
</div>
</div>
</div>
</div>
	
</div>

<script>
$(document).ready(function(){
	var table="";
	$("#d-FormCsv").hide();
	getSummary();
	$("#uplPph").val($("#jenisPajak").val());
	
	Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#kd_cabang').val();
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
					"targets": [ 2,3,4,5,6,29,30,31,32,33,34,35,36,37,38,39 ],
					"visible": false
				} 
			],			
			/* "fixedColumns"	:   {
					"leftColumns": 2
			},	 */	
			 "select"			: true,
			 "pageLength"		: 100,
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,			
			});
		 });
		 
		table = $('#tabledata').DataTable();

		$("input[type=search]").addClear();		
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
	
		$("#btnView").on("click", function(){
			getSummary();
			$("#uplPph").val($("#jenisPajak").val());
			table.ajax.reload();
		});
		
		 table.on( 'draw', function () {			
			getFormCSV();
			getFormCSVntpn();
		} );

	$("#btnEksportCSV").on("click", function(){		
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_format_csv_compilasi";
			var j		= $("#jenisPajak").val();
			var b		= $("#bulan").val();
			var t		= $("#tahun").val();
			var p		= $('#pembetulanKe').val();
			var c		= $('#kd_cabang').val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else {
				$.ajax({			
					url		: '<?php echo site_url() ?>ppn_wapu/cek_data_csv_compilasi'+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p+'&pil='+c,				
					success	: function(result){
						if (result==1) {	
							window.open(url+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p+'&pil='+c, '_blank');
							window.focus(); 							 
						} else {
							flashnotif('Error','Data Kosong!','error' );
							return false;
						}
					}
				});				
			}
	});

	$("#btnEksportCSVntpn").on("click", function(){		
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_format_ntpn_compilasi";
			var j		= $("#jenisPajak").val();
			var b		= $("#bulan").val();
			var t		= $("#tahun").val();
			var p		= $('#pembetulanKe').val();
			var c		= $('#kd_cabang').val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else {
				$.ajax({			
					url		: '<?php echo site_url() ?>ppn_wapu/cek_data_csv_compilasi'+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p+'&pil='+c,				
					success	: function(result){
						if (result==1) {	
							window.open(url+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p+'&pil='+c, '_blank');
							window.focus(); 							 
						} else {
							flashnotif('Error','Data Kosong!','error' );
							return false;
						}
					}
				});				
			}
	});
	
	 $("#btnImportCSV").click(function(){        
        var form = $('#form-import')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
			url	: "<?php echo site_url(); ?>ppn_wapu/import_compilasi_CSV/"+$("#jenisPajak").val()+"/"+$("#bulan").val()+"/"+$("#tahun").val()+"/"+$("#pembetulanKe").val(),	
            data: data,
			beforeSend	: function(){
				 $("body").addClass("loading");					
			},
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
				console.log(result);
				if (result==1) {
                    table.ajax.reload();
					getSummary();
					$("body").removeClass("loading");
					flashnotif('Sukses','Data Berhasil di Import!','success' );	
                    $("#file_csv").val("");
                } else if(result==2){
					$("body").removeClass("loading");
					flashnotif('Info','File Import CSV belum dipilih!','warning' );	
				} else if(result==3){
					$("body").removeClass("loading");
					flashnotif('Info','Format File Bukan CSV!','warning' );						
				} else if(result==4){
					$("body").removeClass("loading");
					flashnotif('Info','Pembetulan Tidak Sama!','warning' );						
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Data Gagal di Import!','error' );
                }
            }
        });
    });	
	

	function getSummary()
	{		

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_summary_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#kd_cabang').val();
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center", "width" : "5%" },
					{ "data": "cabang", "class":"text-right", "width" : "15%" },					
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
								 "url"  		: "<?php echo site_url('ppn_wapu/load_detail_summary_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#kd_cabang').val();
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
					"targets": [ 6 ],					
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

		//ambil jumlah selisih percabang==================================================================
		//sini cek
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary-cabang' ) ) {
		 $('#table-detail-summary-cabang').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_detail_summary_kompilasi_cabang'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#kd_cabang').val();
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Data Kosong",
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

		if ( ! $.fn.DataTable.isDataTable( '#summary_kompilasi' ) ) {
		 $('#summary_kompilasi').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_total_detail_summary_kompilasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#kd_cabang').val();
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
					{ "data": "cabang", "class":"text-right", "width" : "15%" },					
					{ "data": "jml_tidak_dilaporkan", "class":"text-right", "width" : "15%" }
					/*{ "data": "jml_tgl_akhir", "class":"text-right", "width" : "15%" },
					{ "data": "jml_import_csv", "class":"text-right", "width" : "15%" },
					{ "data": "total", "class":"text-right", "width" : "18%" }*/					
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			 
			});
		 } else {
			$('#summary_kompilasi').DataTable().ajax.reload();
		}

		$.ajax({
			url		: "<?php echo site_url('ppn_wapu/load_total_detail') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchCabang : $('#kd_cabang').val() }),
			success	: function(result){										
					$("#dTotalselisih").html("<h4><strong>TOTAL &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );				
					
			}
		});	
		
		/* Akhir detail Summary======================================================= */
	}
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Search No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();			
	});
	
	function getFormCSV(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}

	function getFormCSVntpn(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}

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
	
})

</script>
