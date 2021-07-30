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
								<table width="100%" class="display cell-border stripe hover small" id="table_fakturstandar"> 
									<thead>
										<tr>
											<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>NO</th>
			                            	<th>NAMA CABANG</th>
			                            	<th class="akun_beban">AKUN BEBAN</th>
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
								<table width="100%" class="display cell-border stripe hover small" id="table_fakturstandar2"> 
									<thead>
										<tr>
											<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>NO</th>
			                            	<th>NAMA CABANG</th>
			                            	<th class="akun_beban">AKUN PENDAPATAN</th>
			                            	<th>KD JENIS TRANSAKSI</th>
											<th>FG PENGGANTI</th>
											<th>NOMOR FAKTUR</th>
											<th>TANGGAL FAKTUR</th>
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
            <div class="panel-group boxshadow" id="accordion1">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse-data">Dokumen Lain</a>
						</h4>
					</div>
					<div id="collapse-data" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="table-responsive">
								<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
									<thead>
										<tr>
			                            	<th>PAJAK HEADER ID</th>
			                            	<th>PAJAK LINE ID</th>
			                            	<th>NO</th>
			                            	<th>NAMA CABANG</th>
			                            	<th class="akun_beban">AKUN BEBAN/PENDAPATAN</th>
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

	<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel-group boxshadow" id="accordion5">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapse-rincian1">RINCIAN PPN</a>
						</h4>
					</div>
					<div id="collapse-rincian1" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="row">
							  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<div class="table-responsive">
									<table width="100%" class="display cell-border stripe hover small" id="tabledata-rincian"> 
										<thead>
											<tr>
												<th>NO</th>
												<th>NAMA CABANG</th>
												<th>JUMLAH PPN KELUARAN</th>
												<th>JUMLAH PPN MASUKAN</th>
												<th>PMK</th> 
												<th>KURANG/LEBIH BAYAR</th>
											</tr>
										</thead>
									</table>
								</div> 
							  </div>
						 	</div>
				<?php if($kantor_cabang == "pusat"){ ?>
						 <br>
						 <div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>JUMLAH PPN KELUARAN</label>
									<input type="text" class="form-control text-right" id="tot_ppn_keluaran" name="tot_ppn_keluaran"readonly >
								</div>
							 </div>
							  <div class="col-lg-3">
								<div class="form-group">
									<label>JUMLAH PPN MASUKAN</label>
									<input type="text" class="form-control text-right" id="tot_ppn_masukan" name="tot_ppn_masukan" readonly >
								</div>
							 </div>
							 <div class="col-lg-3">
								<div class="form-group">
									<label>PMK</label>
									<input type="text" class="form-control text-right" id="tot_pmk" name="tot_pmk" readonly >
								</div>
							 </div>
							 <div class="col-lg-3">
								<div class="form-group">
									<label>KURANG/LEBIH BAYAR</label>
									<input type="text" class="form-control text-right" id="tot_kurang_lebih" name="tot_kurang_lebih" readonly >
								</div>
							 </div>
						 </div>
						 <br>
						 <div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>KOMPENSASI BULAN LALU</label>
									<input type="text" class="form-control text-right" id="kompensasi_lalu" name="kompensasi_lalu" >
								</div>
							 </div>
							  <div class="col-lg-3">
								<div class="form-group">
									<label>PMK TAHUNAN</label>
									<input type="text" class="form-control text-right" id="pmk_tahunan" name="pmk_tahunan">
								</div>
							 </div>
							 <div class="col-lg-3">
								<div class="form-group">
									<label>PBK</label>
									<input type="text" class="form-control text-right" id="pbk" name="pbk">
								</div>
							 </div>
							 <div class="col-lg-3">
								<div class="form-group">
									<label>TOTAL YANG HARUS DIBAYAR</label>
									<input type="text" class="form-control text-right" id="total_dibayar" name="total_dibayar" readonly >
								</div>
							 </div>
						 </div>
						<div class="row">
							</br>
							</br>
							<div class="col-lg-12 text-center">
								<button id="btnTahunan" class="btn btn-info btn-rounded custom-input-width" type="button" ><i class="fa fa fa-save"></i> <span>SAVE</span></button>
							</div>
						</div>
						<?php } ?>
						</div>
						<div class="panel-footer"> </div>
					</div>
				</div>
			</div>
        </div>
    </div>

	<div class="row">
		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel  panel-default boxshadow animated slideInDown">
			<div class="panel-heading">Keterangan</div>
				 <div class="panel-body"> 
					<div class="row">
						 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
                              <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tulis keterangan disini..."></textarea>
							</div>
						 </div>
					</div>
					<div class="row">
						<div class="col-lg-12">
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
			var table	= "",  table2	= "",  table3	= "", vkodepajak="", vnamapajak = "", vbulan="", vnmbulan = "", vtahun = "", vpembetulan = "", vcabang="", getSummaryCat="";
				vcabang = '<?php echo $kantor_cabang ?>';
			valueAdd();
			getStart();
			showhideFaktur();
			getRincian();
						
		Pace.track(function(){ 
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_approval',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = 'dokumen_lain';
										d._aproval_category = vcabang;
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
					{ "data": "no", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
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
					"targets": [ 0, 1 <?php echo ($kantor_cabang == "cabang") ? ', 3' : '' ?>],
					"visible": false
				} 
			],	
			"fixedColumns"	:   {
					"leftColumns": 2
			},		
			 "select"			: true,
			 "scrollY"			: 400,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false
			});
		 });
		 
		table = $('#tabledata').DataTable();
						
		Pace.track(function(){ 
		   $('#table_fakturstandar').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_approval',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = 'faktur_standar';
										d._aproval_category = vcabang;
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
					{ "data": "no", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
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
					"targets": [ 0, 1 <?php echo ($kantor_cabang == "cabang") ? ', 3' : '' ?>],
					"visible": false
				} 
			],		
			"fixedColumns"	:   {
					"leftColumns": 2
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
		 
		table2 = $('#table_fakturstandar').DataTable();
						
		Pace.track(function(){ 
		   $('#table_fakturstandar2').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_approval',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = 'faktur_standar';
										d._aproval_category = vcabang;
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
					{ "data": "no", "class":"text-center" },
					{ "data": "kode_cabang", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
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
					"targets": [ 0, 1 <?php echo ($kantor_cabang == "cabang") ? ', 3' : '' ?>],
					"visible": false
				} 
			],		
			"fixedColumns"	:   {
					"leftColumns": 2
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/Nama Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
			table2.search('').column().search('').draw();
			table3.search('').column().search('').draw();
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


	function getRincian(){

		if(vcabang == "pusat"){
			getSummaryCat = "approval_pusat";
		}
		else{
			getSummaryCat = "approval_cabang";
		}

		nama_pajak = $('#jenisPajak').val();

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-rincian' ) ) {
		 $('#tabledata-rincian').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_rincian',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = nama_pajak;
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
					{ "data": "no", "class":"text-center", "width" : "5%"  },
					{ "data": "nama_cabang", "class":"text-center", "width" : "15%" },
					{ "data": "jumlah_ppn_keluaran", "class":"text-right", "width" : "15%" },
					{ "data": "jumlah_ppn_masukan", "class":"text-right", "width" : "15%" },
					{ "data": "pmk", "class":"text-right", "width" : "15%" },
					{ "data": "kurang_lebih", "class":"text-right", "width" : "15%" }
				],
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "autoWidth"		: true,
			 "ordering"			: false
			});
			
		} else {
			$('#tabledata-rincian').DataTable().ajax.reload();
		}


		// if(vcabang == "pusat"){
			$.ajax({
				url		: baseURL + 'ppn_masa/load_total_rincian',
				type	: "POST",
				dataType:"json", 
				data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan : $('#pembetulanKe').val(), _category : getSummaryCat}),
				success	: function(result){		
						$("#tot_ppn_keluaran").val(number_format(result.tot_ppn_keluaran,0,'','.'));
						$("#tot_ppn_masukan").val(number_format(result.tot_ppn_masukan,0,'','.'));
						$("#tot_pmk").val(number_format(result.tot_pmk,0,'','.'));
						$("#tot_kurang_lebih").val(number_format(result.tot_kurang_lebih,0,'','.'));
						$("#kompensasi_lalu").val(number_format(result.kompensasi_lalu,0,'','.'));
						$("#pmk_tahunan").val(number_format(result.pmk_tahunan,0,'','.'));
						$("#pbk").val(number_format(result.pbk,0,'','.'));
						$("#total_dibayar").val(number_format(result.total_dibayar,0,'','.'));
				}
			});

		// }
	}

	$("#btnTahunan").on("click", function(){

		var b            = $("#bulan").val();
		var t            = $("#tahun").val();
		var p            = $("#pembetulanKe").val();
		var pmk          = $("#pmk_tahunan").val();
		var pbk          = $("#pbk").val();
		var kompensasi   = $("#kompensasi_lalu").val();
		var kurang_lebih = $("#tot_kurang_lebih").val();
		var total_dibayar = $("#total_dibayar").val();

		$.ajax({
			url		: baseURL + 'ppn_masa/save_tahunan',
			type	: "POST",
			data	: ({bulan:b, tahun:t, pembetulan:p, pmk:pmk, pbk:pbk, kompensasi:kompensasi, kurang_lebih:kurang_lebih, total_dibayar:total_dibayar}),
			success	: function(result){
				if (result==1) {
					getRincian();
					 flashnotif('Sukses','Data Berhasil di Simpan!','success');
				} else {
					 flashnotif('Error','Data Gagal di Simpan!','error' );
				}
			}
		});
	});

		$("#btnView").on("click", function(){
			showhideFaktur();
			valueAdd();
			getStart();
			getRincian();
			table.ajax.reload();
			table2.ajax.reload();
			table3.ajax.reload();
		});

		function showhideFaktur(){
			vkodepajak      = $("#jenisPajak").val();
			faktur_masukan  = $("#faktur_masukan");
			faktur_keluaran = $("#faktur_keluaran");

			if(vkodepajak == "PPN MASUKAN"){
				$(".akun_beban").html('AKUN BEBAN')
				faktur_masukan.css('display','block');
				faktur_keluaran.css('display','none');
			}
			else if(vkodepajak == "PPN KELUARAN"){
				$(".akun_beban").html('AKUN PENDAPATAN')
				faktur_masukan.css('display','none');
				faktur_keluaran.css('display','block');
			}
			else{
				$(".akun_beban").html('AKUN BEBAN/PENDAPATAN')
				faktur_masukan.css('display','none');
				faktur_keluaran.css('display','block');
			}
		}

		$("#btnApprov").click(function(){
			bootbox.confirm({
			title: "Data <span class='label label-danger'>"+vnamapajak+"</span> Bulan <span class='label label-danger'>"+vnmbulan+"</span> Tahun <span class='label label-danger'>"+vtahun+"</span> Approv?",
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
						url		: baseURL + 'ppn_masa/save_approval',
						type	: "POST",
						data	: ({cabang:vkodecabang,approval_category:vcabang, masa:vbulan,tahun:vtahun,pembetulan:vpembetulan,pasal:vkodepajak,ket:vket,st:1}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 table.draw();
								 table2.draw();
								 table3.draw();
							 	 getRincian();
								 $("body").removeClass("loading");
								 flashnotif('Sukses','Data Berhasil di Approv!','success' );
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
			title: "Data <span class='label label-danger'>"+vnamapajak+"</span> Bulan <span class='label label-danger'>"+vnmbulan+"</span> Tahun <span class='label label-danger'>"+vtahun+"</span> Reject?",
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
						url		: baseURL + 'ppn_masa/save_approval',
						type	: "POST",
						data	: ({cabang:vkodecabang,approval_category:vcabang, masa:vbulan,tahun:vtahun,pembetulan:vpembetulan,pasal:vkodepajak,ket:vket,st:0}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 table.draw();
								 table2.draw();
								 table3.draw();
							 	 getRincian();
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
		vkodepajak  = $("#jenisPajak").val();
		vnamapajak  = $("#jenisPajak").find(":selected").attr("data-name");
		vbulan      = $("#bulan").val();
		vnmbulan    = $("#bulan").find(":selected").attr("data-name");
		vtahun      = $("#tahun").val();
		vpembetulan = $("#pembetulanKe").val();
		vkodecabang = $("#kd_cabang").val();
	}
	
	function getStart()
	{
		var check_status = "";
		if(vcabang == "pusat"){
			check_status  = "APPROVAL SUPERVISOR";
			check_status2 = "APPROVED BY PUSAT";
		}
		else{
			check_status  = "SUBMIT";
			check_status2 = "REJECT BY PUSAT";
		}

		$.ajax({
			url		: baseURL + 'ppn_masa/get_start',
			type	: "POST",
			dataType:"json", 
			data	: ({cabang:vkodecabang,approval_category:vcabang , masa:vbulan,tahun:vtahun,pembetulan:vpembetulan,pasal:vkodepajak}),
			success	: function(result){
				if (result.isSuccess==1) {
					if(result.status_period=="OPEN"){
						console.log(result.status);
						if(result.status == check_status || result.status == check_status2){
							if(result.status == "APPROVED BY PUSAT"){
								if(vcabang == "pusat"){
									$("#btnReject").slideDown(700);
									$("#btnApprov").slideUp(700);
								}
								else{
									$("#btnApprov, #btnReject").slideUp(700);
								}
							}
							else if(result.status == "REJECT BY PUSAT"){
								if(vcabang == "pusat"){
									$("#btnReject").slideUp(700);
								}
								else{
									$("#btnApprov, #btnReject").slideDown(700);
								}
							}
							else if(result.status == "APPROVAL SUPERVISOR"){
								if(vcabang == "pusat"){
									$("#btnApprov, #btnReject").slideDown(700);
								}
								else{
									$("#btnApprov, #btnReject").slideUp(700);
								}
							}
							else{
								$("#btnApprov, #btnReject").slideDown(700);
							}
						} else {
							if(vcabang == "pusat"){
								$("#btnApprov, #btnReject").slideUp(700);
							}
							else{
								$("#btnApprov, #btnReject").slideUp(700);
							}
						}
					} else {
							$("#btnApprov, #btnReject").slideUp(700);
					}
				} else {
					$("#keterangan").val("");
					$("#btnApprov, #btnReject").slideUp(700);
				}
			}
		});
	}

 });
    </script>