<div class="container-fluid">
		
    <?php $this->load->view('template_top') ?>

	<div class="white-box boxshadow">
		<?php if($kantor_cabang == "pusat"){ ?>
		<div class="row">
			<div class="col-md-2">
                <div class="form-group">
                    <label>Cabang</label>
                    <select id="kd_cabang" name="kd_cabang" class="form-control" autocomplete="off">
                        <option value="all">Semua Cabang</option>
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
			<div class="col-md-2">
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
			 <div class="col-md-2">
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
			 <div class="col-md-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="" data-name="" >Pilih Jenis Pajak</option>
						<?php foreach ($daftar_pajak as $key => $pajak):?>
							<option value="<?php echo $pajak->JENIS_PAJAK ?>" data-name="<?php echo $pajak->JENIS_PAJAK ?>" > <?php echo $pajak->JENIS_PAJAK ?> </option>
						<?php endforeach ?>
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
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
			 <div class="col-md-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
				</div>
			  </div>
		</div>
	 </div>
    
    <div class="row" id="faktur_masukan">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-data2">eFaktur PPN Masukan</a>
						</h4>
					</div>					
					<div id="collapse-data2" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="table-responsive">
								<table width="100%" class="display  cell-border stripe hover small" id="table_fakturstandar"> 
									<thead>
										<tr>
											<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>VENDOR ID</th>
											<th>MASA PAJAK</th>
											<th>TAHUN PAJAK</th>
			                            	<th>NO</th>
			                            	<th>AKUN BEBAN</th>
			                            	<th>NAMA CABANG</th>
			                            	<th>JENIS DOKUMEN</th>
			                            	<th>KD JENIS TRANSAKSI</th>
											<th>FG PENGGANTI</th>
											<th>NOMOR FAKTUR PAJAK</th>
											<th>TANGGAL FAKTUR PAJAK</th>
											<th>NPWP</th>
											<th>NAMA</th>
											<th>ALAMAT LENGKAP</th>
											<th>NOMOR INVOICE</th>
											<th>MATA UANG</th>
											<th>JUMLAH DPP</th>
											<th>JUMLAH PPN</th>
											<th>JUMLAH PPNBM</th>
											<th>IS CREDITABLE</th>
											<th>NOMOR FAKTUR ASAL</th>
											<th>TANGGAL FAKTUR ASAL</th>
											<th>DPP ASAL</th>
											<th>PPN ASAL</th>
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

    <div class="row" id="faktur_keluaran">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse-data3">eFaktur PPN Keluaran</a>
						</h4>
					</div>					
					<div id="collapse-data3" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="table-responsive">
								<table width="100%" class="display  cell-border stripe hover small" id="table_fakturstandar2"> 
									<thead>
										<tr>
											<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>VENDOR ID</th>
											<th>MASA PAJAK</th>
											<th>TAHUN PAJAK</th>
			                            	<th>NO</th>
			                            	<th>AKUN PENDAPATAN</th>
			                            	<th>NAMA CABANG</th>
			                            	<th>JENIS DOKUMEN</th>
			                            	<th>KD JENIS TRANSAKSI</th>
											<th>FG PENGGANTI</th>
											<th>NOMOR FAKTUR PAJAK</th>
											<th>TANGGAL FAKTUR PAJAK</th>
											<th>NPWP</th>
											<th>NAMA</th>
											<th>ALAMAT LENGKAP</th>
											<th>NOMOR INVOICE</th>
											<th>MATA UANG</th>
											<th>JUMLAH DPP</th>
											<th>JUMLAH PPN</th>
											<th>JUMLAH PPNBM</th>
											<th>ID_KETERANGAN_TAMBAHAN</th>
											<th>FG_UANG_MUKA</th>
											<th>UANG_MUKA_DPP</th>
											<th>UANG_MUKA_PPN</th>
											<th>UANG_MUKA_PPNBM</th>
											<th>REFERENSI</th>
											<th>NOMOR FAKTUR ASAL</th>
											<th>TANGGAL FAKTUR ASAL</th>
											<th>DPP ASAL</th>
											<th>PPN ASAL</th>
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
	 
	<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Dokumen Lain</a>
						</h4>
					</div>					
					<div id="collapse-data" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="table-responsive">
								<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
									<thead>
										<tr>
			                            	<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>VENDOR ID</th>
			                            	<th>MASA PAJAK</th>
			                            	<th>TAHUN PAJAK</th>
			                            	<th>NO</th>
			                            	<th>AKUN</th>
			                            	<th>NAMA CABANG</th>
			                            	<th>JENIS TRANSAKSI</th>
			                            	<th>JENIS DOKUMEN</th>
			                            	<th>KD JENIS TRANSAKSI</th>
			                            	<th>FG PENGGANTI</th>
			                            	<th>NOMOR DOK LAIN</th>
			                            	<th>TANGGAL DOK LAIN</th>
			                            	<th>NOMOR DOK LAIN GANTI</th>
			                            	<th>NPWP</th>
			                            	<th>NAMA</th>
			                            	<th>ALAMAT LENGKAP</th>
											<th>NOMOR INVOICE</th>
			                            	<th>MATA UANG</th>
			                            	<th>JUMLAH DPP</th>
			                            	<th>JUMLAH PPN</th>
			                            	<th>JUMLAH PPNBM</th>
			                            	<th>KETERANGAN</th>
											<th>FAPR</th>
											<th>TANGGAL APPROVAL</th>
											<th>NOMOR FAKTUR ASAL</th>
											<th>TANGGAL FAKTUR ASAL</th>
											<th>DPP ASAL</th>
											<th>PPN ASAL</th>
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


	<div id="ringkasan_masukan" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-2" href="#collapse-summary">Ringkasan Rekonsiliasi</a>
						</h4>
					</div>							
					<div id="collapse-summary" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="row">
							  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<div class="table-responsive">                          
									<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll1"> 
										<thead>
											<tr>
											<th>TOTAL FAKTUR</th>
											<th>TOTAL DOKUMEN LAIN</th>
											<th>SALDO AWAL</th>
											<th>MUTASI DEBET</th> 
											<th>MUTASI KREDIT</th>
											<th>SALDO AKHIR</th>
											<th>JUMLAH DIBAYARKAN</th>
											<th>SELISIH</th>
											<th>PPN DI KREDITKAN</th>
											<th>PPN TIDAK DI KREDITKAN</th>
											<th>PMK 78</th>
											</tr>
										</thead>
									</table> 	
								</div> 
							</div>						
						 </div>
						</div>
						<div class="panel-footer"> 
							
						</div>
					</div>
				</div>						
			</div>
        </div>
    </div>
			
	<div id="ringkasan_keluaran" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-3" href="#collapse-summary">Ringkasan Rekonsiliasi</a>
						</h4>
					</div>							
					<div id="collapse-summary" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="row">
							  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<div class="table-responsive">                          
									<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll2"> 
										<thead>
											<tr>
											<th>TOTAL FAKTUR</th>
											<th>TOTAL DOKUMEN LAIN</th>
											<th>SALDO AWAL</th>
											<th>MUTASI DEBET</th> 
											<th>MUTASI KREDIT</th>
											<th>SALDO AKHIR</th>
											<th>JUMLAH DIBAYARKAN</th>
											<th>SELISIH</th>
											<th>PPN DI BEBASKAN</th>
											<th>PPN DI PUNGUT SENDIRI</th>
											<th>PPN TIDAK DI PUNGUT</th>
											<th>PPN DIPUNGUT OLEH PEMUNGUT</th>
											</tr>
										</thead>
									</table> 	
								</div> 
							</div>						
						 </div>
						</div>
						<div class="panel-footer"> 
						</div>
					</div>
				</div>						
			</div>
        </div>
    </div>
			
	<div class="row">
	  <div class="col-lg-12">
		<div class="panel panel-default boxshadow animated slideInDown">					
			<div class="panel-body">
				<ul class="nav nav-pills">
					<li class="active"><a href="#tab-download" data-toggle="tab"><i class="fa fa-download fa-fw"></i> Download</a>
					</li>
					<li><a href="#tab-cetak" data-toggle="tab"><i class="fa fa-print fa-fw"></i> Print</a>
					</li>					
				</ul>				
				<div class="tab-content">
					<div class="tab-pane fade in active" id="tab-download">
						<div class="row">
							<div class="col-lg-12">
								<hr>
								<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
								<?php if($kantor_cabang == "pusat"){ ?>
								<button type="button" id="btnCSV_Akun" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV (Akun)</button>
								<?php }?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-cetak">
						<div class="row">
							<div class="col-lg-12">
								 <hr>
								 <button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
								<?php //if($kantor_cabang == "pusat"){ ?>
								 <button type="button" id="btnMonthly" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> 1111AB</button>
								 <button type="button" id="btnPMK" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> PMK</button>
								<?php //}?>
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
		var table	= "", table2	= "", table3	= "", vkodepajak = "",vbulan = "", vtahun ="", vcabang ="", kode_cabang ="", vpembetulan ="";

		vcabang = '<?php echo $kantor_cabang ?>';
		getSummary();
		showhideFaktur();
		download = '<?php echo $download_status ?>';

		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_download',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan       = $('#bulan').val();
										d._searchTahun       = $('#tahun').val();
										d._searchPpn         = $('#jenisPajak').val();
										d._searchPembetulan  = $('#pembetulanKe').val();
										d._category          = 'dokumen_lain';
										d._categorys         = download;
										d._searchCabang      = $('#kd_cabang').val();
										d._download_category = vcabang;
									}
						},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "pajak_header_id" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "no", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "jenis_transaksi",  "class":"text-center"},
					{ "data": "jenis_dokumen",  "class":"text-center"},
					{ "data": "kd_jenis_transaksi", "class":"text-center"},
					{ "data": "fg_pengganti", "class":"text-center"},
					{ "data": "no_dokumen_lain", "class":"text-center"},
					{ "data": "tanggal_dokumen_lain", "class":"text-center"},
					{ "data": "no_dokumen_lain_ganti", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "alamat_wp"},
					{ "data": "invoice_number"},
					{ "data": "mata_uang"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					{ "data": "keterangan", "class":"text-center"},
					{ "data": "fapr"},
					{ "data": "tanggal_approval"},
					{ "data": "faktur_asal"},
					{ "data": "tanggal_faktur_asal"},
					{ "data": "dpp_asal"},
					{ "data": "ppn_asal"}
				],
			"columnDefs": [ 
				 {
					"targets": [ 0, 1, 2, 3, 4 <?php echo ($kantor_cabang == "cabang") ? ', 7' : '' ?>],
					"visible": false
				} 
			],
			"fixedColumns"	:   {
					"leftColumns": 1
			},		
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();

		Pace.track(function(){ 
		   $('#table_fakturstandar').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_download',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = 'faktur_standar';
										d._categorys         = download;
										d._searchCabang      = $('#kd_cabang').val();
										d._download_category = vcabang;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
			   		{ "data": "pajak_header_id" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "no", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "jenis_dokumen",  "class":"text-center"},
					{ "data": "kd_jenis_transaksi", "class":"text-center"},
					{ "data": "fg_pengganti", "class":"text-center"},
					{ "data": "no_faktur_pajak", "class":"text-center"},
					{ "data": "tanggal_faktur_pajak", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "alamat_wp"},
					{ "data": "invoice_number"},
					{ "data": "mata_uang"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					{ "data": "is_creditable", "class":"text-center"},
					{ "data": "faktur_asal"},
					{ "data": "tanggal_faktur_asal"},
					{ "data": "dpp_asal"},
					{ "data": "ppn_asal"}
				],
			"columnDefs": [ 
				 {
					"targets": [ 0, 1, 2, 3, 4 <?php echo ($kantor_cabang == "cabang") ? ', 7' : '' ?>],
					"visible": false
				} 
			],		
			"fixedColumns"	:   {
					"leftColumns": 6
			},		
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		 
		table2 = $('#table_fakturstandar').DataTable();
						
		Pace.track(function(){ 
		   $('#table_fakturstandar2').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_download',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan       = $('#bulan').val();
										d._searchTahun       = $('#tahun').val();
										d._searchPpn         = $('#jenisPajak').val();
										d._searchPembetulan  = $('#pembetulanKe').val();
										d._category          = 'faktur_standar';
										d._categorys         = download;
										d._searchCabang      = $('#kd_cabang').val();
										d._download_category = vcabang;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
			   		{ "data": "pajak_header_id" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "no", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "jenis_dokumen",  "class":"text-center"},
					{ "data": "kd_jenis_transaksi", "class":"text-center"},
					{ "data": "fg_pengganti", "class":"text-center"},
					{ "data": "no_faktur_pajak", "class":"text-center"},
					{ "data": "tanggal_faktur_pajak", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "alamat_wp"},
					{ "data": "invoice_number"},
					{ "data": "mata_uang"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					{ "data": "id_keterangan_tambahan", "class":"text-center"},
					{ "data": "fg_uang_muka", "class":"text-center"},
					{ "data": "uang_muka_dpp", "class":"text-center"},
					{ "data": "uang_muka_ppn", "class":"text-center"},
					{ "data": "uang_muka_ppnbm", "class":"text-center"},
					{ "data": "referensi", "class":"text-center"},
					{ "data": "faktur_asal"},
					{ "data": "tanggal_faktur_asal"},
					{ "data": "dpp_asal"},
					{ "data": "ppn_asal"}
				],
			"columnDefs": [ 
				 {
					"targets": [ 0, 1, 2, 3, 4 <?php echo ($kantor_cabang == "cabang") ? ', 7' : '' ?>],
					"visible": false
				} 
			],		
			"fixedColumns"	:   {
					"leftColumns": 6
			},		
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		 
		table3 = $('#table_fakturstandar2').DataTable();
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/Nama Pajak ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
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
		

			if (table2.data().any() || table.data().any()){
				$(".isAktif").removeAttr("disabled");
			} else {
				$(".isAktif").attr("disabled", true);
			}
		
		table.on( 'draw', function () {		
		  if (table2.data().any() || table.data().any() || table3.data().any()){
			 $(".isAktif").removeAttr("disabled");
		  } else {
			 $(".isAktif").attr("disabled", true);
		  }
		});

		table2.on( 'draw', function () {		
		  if (table2.data().any() || table.data().any() || table3.data().any()){
			 $(".isAktif").removeAttr("disabled");
		  } else {
			 $(".isAktif").attr("disabled", true);
		  }
		});

		table3.on( 'draw', function () {		
		  if (table2.data().any() || table.data().any() || table3.data().any()){
			 $(".isAktif").removeAttr("disabled");
		  } else {
			 $(".isAktif").attr("disabled", true);
		  }
		});
			
  
	$("#btnView").on("click", function(){

		showhideFaktur();
		table.ajax.reload();			
		table2.ajax.reload();			
		table3.ajax.reload();
		getSummary();
				
	});
	faktur_masukan = '';
faktur_keluaran = '';
ringkasan_masukan = '';
ringkasan_keluaran = '';

	function showhideFaktur(){
		vkodepajak      = $("#jenisPajak").val();
		faktur_masukan  = $("#faktur_masukan");
		faktur_keluaran = $("#faktur_keluaran");
		
		ringkasan_masukan = $("#ringkasan_masukan");
		ringkasan_keluaran = $("#ringkasan_keluaran");

		if(vkodepajak == "PPN MASUKAN"){
			faktur_masukan.css('display','block');
			faktur_keluaran.css('display','none');

			ringkasan_masukan.css('display','block');
			ringkasan_keluaran.css('display','none');
		}
		else if(vkodepajak == "PPN KELUARAN"){
			faktur_masukan.css('display','none');
			faktur_keluaran.css('display','block');

			ringkasan_masukan.css('display','none');
			ringkasan_keluaran.css('display','block');
		}
		else{
			faktur_masukan.css('display','none');
			faktur_keluaran.css('display','block');

			ringkasan_masukan.css('display','none');
			ringkasan_keluaran.css('display','none');
		}
	}
	var dengan_akun = "";
	
	$("#btnCSV, #btnCSV_Akun").on("click", function(){

		kode_cabang = $("#kd_cabang").val();
		vkodepajak  = $("#jenisPajak").val();
		vbulan      = $("#bulan").val();
		vtahun      = $("#tahun").val();
		vpembetulan = $("#pembetulanKe").val();

		buttonnya = $(this).attr('id');;

		if(vcabang == "pusat"){
			vcategory = "kompilasi";
		}
		else{
			vcategory = "cabang";
		}
		if(buttonnya == "btnCSV_Akun"){
			dengan_akun = "1/";
		}
		
		var url1 = baseURL + 'ppn_masa/export_csv/'+vcategory+'/'+kode_cabang+'/'+vkodepajak+'/'+vbulan+'/'+vtahun+'/'+vpembetulan+'/dokumen_lain/xx/'+dengan_akun;

		if(vkodepajak == "PPN MASUKAN"){
			var url2 = baseURL + 'ppn_masa/export_csv/'+vcategory+'/'+kode_cabang+'/'+vkodepajak+'/'+vbulan+'/'+vtahun+'/'+vpembetulan+'/faktur_standar/creditable/'+dengan_akun;
			var url3 = baseURL + 'ppn_masa/export_csv/'+vcategory+'/'+kode_cabang+'/'+vkodepajak+'/'+vbulan+'/'+vtahun+'/'+vpembetulan+'/faktur_standar/not_creditable/'+dengan_akun;
		}
		else{
			var url2 = baseURL + 'ppn_masa/export_csv/'+vcategory+'/'+kode_cabang+'/'+vkodepajak+'/'+vbulan+'/'+vtahun+'/'+vpembetulan+'/faktur_standar/';
			var url3 = '';
		}

		if (!table2.data().any() && !table.data().any() && !table3.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {

			window.open(url1);
			setTimeout(function () {
				window.open(url2);
			}, 1000);
			if(url3 != ''){
				setTimeout(function () {
					window.open(url3);
				}, 2000);
			}
			window.focus();
		}
	});

	$("#jenisPajak").on("change", function(){
		nama_pajak = $(this).val();
	});

	function getSummary()
	{

		if(vcabang == "pusat"){
			getSummaryCat = "download_cetak_comp";
		}
		else{
			getSummaryCat = "download_cetak";
		}

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_summary_rekonsiliasiAll1',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = getSummaryCat;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "total_faktur", "class":"text-center" },
					{ "data": "total_doklain", "class":"text-center" },
					{ "data": "saldo_awal", "class":"text-center" },
					{ "data": "mutasi_debet", "class":"text-center" },
					{ "data": "mutasi_kredit", "class":"text-center" },
					{ "data": "saldo_akhir", "class":"text-center" },
					{ "data": "jumlah_dibayarkan", "class":"text-center" },
					{ "data": "selisih", "class":"text-center" },
					{ "data": "di_kreditkan", "class":"text-center" },
					{ "data": "not_creditable", "class":"text-center" },
					{ "data": "pmk", "class":"text-center" }
				],
			 "scrollCollapse"	: true,
			 "scrollX"			: true,
			 "ordering"			: false		
			});					
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}	
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll2' ) ) {
		 $('#tabledata-summaryAll2').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_summary_rekonsiliasiAll1',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = getSummaryCat;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "total_faktur", "class":"text-center" },
					{ "data": "total_doklain", "class":"text-center" },
					{ "data": "saldo_awal", "class":"text-center" },
					{ "data": "mutasi_debet", "class":"text-center" },
					{ "data": "mutasi_kredit", "class":"text-center" },
					{ "data": "saldo_akhir", "class":"text-center" },
					{ "data": "jumlah_dibayarkan", "class":"text-center" },
					{ "data": "selisih", "class":"text-center" },
					{ "data": "ppn_beban", "class":"text-center" },
					{ "data": "ppn_dipungut", "class":"text-center" },
					{ "data": "ppn_tdk_dipungut", "class":"text-center" },
					{ "data": "ppn_dipungut_oleh_pemungut", "class":"text-center" }
				],
			 "scrollCollapse"	: true,
			 "scrollX"			: true,
			 "ordering"			: false			
			});					
			
		} else {
			$('#tabledata-summaryAll2').DataTable().ajax.reload();
		}	
	}

	$("#btnSPT").on("click", function(){
		var url 	="<?php echo site_url(); ?>laporan/cetak_report_ppn_masa_bln_cbg";
		vbulan			= $("#bulan").val();
		vtahun			= $("#tahun").val();
		vcabang			= $("#kd_cabang").val();
		vpembetulanKe	= $("#pembetulanKe").val();

		if (!table2.data().any() && !table.data().any() && !table3.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?bulan='+vbulan+'&tahun='+vtahun+'&cabang='+vcabang+'&pembetulanKe='+vpembetulanKe, '_blank');
			window.focus();
		}
	});

	$("#btnMonthly").on("click", function(){
		cabang = $("#kd_cabang").val();
		var url 	="<?php echo site_url(); ?>laporan/cetak_rekap_ppn_masa_kompilasi_bln";
		vbulan			= $("#bulan").val();
		vtahun			= $("#tahun").val();
		vcabang			= cabang;
		vpembetulanKe	= $("#pembetulanKe").val();

		if (!table2.data().any() && !table.data().any() && !table3.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?bulan='+vbulan+'&tahun='+vtahun+'&cabang='+vcabang+'&pembetulanKe='+vpembetulanKe, '_blank');
			window.focus();
		}
	});

	$("#btnPMK").on("click", function(){
		var url       ="<?php echo site_url(); ?>laporan/cetak_pmk";
		cabang        = $("#kd_cabang").val();
		vbulan        = $("#bulan").val();
		vtahun        = $("#tahun").val();
		vcabang       = cabang;
		vpembetulanKe = $("#pembetulanKe").val();

		if (!table2.data().any() && !table.data().any() && !table3.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?bulan='+vbulan+'&tahun='+vtahun+'&kd_cabang='+vcabang+'&pembetulanKe='+vpembetulanKe, '_blank');
			window.focus();
		}
	});

 });
    </script>