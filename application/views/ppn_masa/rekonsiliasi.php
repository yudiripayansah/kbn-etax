<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

 <div id="list-data">
	 <div class="white-box boxshadow">
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
					<input type="hidden" class="form-control" id="jenisPajak" value="<?php echo $nama_pajak ?>">
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

	<div id="d-FormCsv">
		 <div class="white-box boxshadow">
	 	<div class="row">
			<div class="col-md-5">
				<div class="form-group">
				<label class="form-control-label">EXPORT CSV</label>
				<select class="form-control" id="kategori_eksport" name="kategori_dokumen">
					<option value="dilaporkan" selected>Data Yang Dilaporkan</option>
					<option value="tidak_dilaporkan">Data Yang Tidak Dilaporkan</option>
					<?php if($nama_pajak == "PPN MASUKAN"){ ?>
					<option value="pmk">PMK</option>
					<?php } else { ?>
					<option value="summary">Data Summary (Tanpa Akun Beban)</option>
					<?php } ?>
				</select>
				</div>
				<div class="form-group">
				<label class="form-control-label">&nbsp;</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button id="btnExportCSV" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>EXPORT CSV</span></button>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				 <form role="form" id="form-import" autocomplete="off">
					  <div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">FILE CSV</label>
							<div class="fileinput fileinput-new input-group" data-provides="fileinput">
								<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">CHANGE</span>
								<input type="file" id="file_csv" name="file_csv"> </span> <a href="#" id="csv_remove" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">REMOVE</a>
							</div>
							<input type="hidden" class="form-control" id="uplPpn" name="uplPpn">
							<input type="hidden" class="form-control" id="uplBulan" name="uplBulan">
							<input type="hidden" class="form-control" id="uplTahun" name="uplTahun">
							<input type="hidden" class="form-control" id="uplPembetulan" name="uplPembetulan">
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						<label class="form-control-label">Jenis Dokumen</label>
						<select class="form-control" id="kategori_dokumen" name="kategori_dokumen">
								<option value="">Pilih Dokumen</option>
							<?php if($nama_pajak == "PPN MASUKAN"){ ?>
								<option value="FM">eFaktur Masukan</option>
								<option value="DM">Dokumen Masukan</option>
							<?php } else { ?>
								<option value="efaktur_keluaran">eFaktur Keluaran</option>
								<option value="DK">Dokumen Keluaran</option>
							<?php } ?>
						</select>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						<label>&nbsp;</label>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button" ><i class="fa fa-sign-in"></i> <span>IMPORT CSV</span></button>
							</div>
						</div>
					  </div>
				  </form>
			</div>
		 </div>
	 </div>
	</div>
	 
	<div id="table-1" class="row">
        <div class="col-lg-12">
            <div class="panel panel-info boxshadow animated slideInDown">
                <div class="panel-heading">
					<div class="row">
					  <div class="col-sm-6">
					  	<div class="nama-table"><?php echo ($nama_pajak == "PPN MASUKAN") ? "EFAKTUR PPN MASUKAN" : "EFAKTUR PPN KELUARAN" ?></div>
					  </div>
					  <div class="col-sm-6">
					  	<div class="navbar-right">
					  		<!-- <button type="button" id="btnAdd1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-plus"></i> ADD</button> -->
					  		<button type="button" id="btnEdit1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
							<?php if($nama_pajak == "PPN MASUKAN"){ ?>
					  		<button type="button" id="btnDelete1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-trash"></i> DELETE</button>
							<?php } ?>
						</div>
					  </div>
					</div>
				</div>
                <div class="panel-body"> 
					<div class="table-responsive">
						<div style="padding-bottom: 5px;color:#333;font-weight: 400">
							<label>Sort by </label>
							<select id="orderby1">
								<option value="INVOICE_NUM" data-type="asc">Nomor Invoice A-Z</option>
								<option value="INVOICE_NUM" data-type="desc" selected>Nomor Invoice Z-A</option>
								<!-- <option value="INVOICE_ACCOUNTING_DATE" data-type="asc">Tanggal Invoice A-Z</option>
								<option value="INVOICE_ACCOUNTING_DATE" data-type="desc">Tanggal Invoice Z-A</option> -->
								<option value="NO_FAKTUR_PAJAK" data-type="asc">Nomor Faktur A-Z</option>
								<option value="NO_FAKTUR_PAJAK" data-type="desc">Nomor Faktur Z-A</option>
							</select>
						</div>
						<table width="100%" class="display cell-border stripe hover small" id="table_faktur">
	                        <thead>
	                            <tr>
	                            	<th>PAJAK HEADER ID</th>
	                            	<th>PAJAK LINE ID</th>
	                            	<th>VENDOR ID</th>
	                            	<th>ORGANIZATION ID</th>
	                            	<th>VENDOR SITE ID</th>
	                            	<th>IS CHECKLIST</th>
									<th>MASA PAJAK</th>
									<th>TAHUN PAJAK</th>
									<th>CATEGORY</th>
	                            	<th>NOMOR DOK LAIN</th>
	                            	<th>TANGGAL DOK LAIN</th>
									<th>
										<div class="checkbox checkbox-inverse">
											<input id="checkboxAll-1" type="checkbox">
											<label for="checkboxAll-1"></label>
										</div>
									</th>
	                            	<th>NO</th>
	                            	<th class="text-center no-sort">DL / FS</th>
									<th>PMK</th>
									<th>NPWP</th>
									<th>NAMA</th>
									<th>NOMOR INVOICE</th>
									<th>JUMLAH DPP</th>
									<th>JUMLAH PPN</th>
									<?php if($nama_pajak == "PPN MASUKAN"){ ?>
	                            	<th>AKUN BEBAN</th>
									<?php } else{ ?>
	                            	<th>AKUN PENDAPATAN</th>
									<?php } ?>
	                            	<th>KD JENIS TRANSAKSI</th>
									<th>FG PENGGANTI</th>
									<th>NOMOR FAKTUR PAJAK</th>
									<th>TANGGAL FAKTUR PAJAK</th>
									<th>ALAMAT LENGKAP</th>
									<th>MATA UANG</th>
									<th>JUMLAH PPNBM</th>
									<?php if($nama_pajak == "PPN MASUKAN"){ ?>
									<th>IS CREDITABLE</th>
									<?php } else{ ?>
									<th>ID KETERANGAN TAMBAHAN</th>
									<th>FG UANG MUKA</th>
									<th>UANG MUKA DPP</th>
									<th>UANG MUKA PPN</th>
									<th>UANG MUKA PPNBM</th>
									<th>REFERENSI</th>
									<?php } ?>
									<th>NOMOR FAKTUR ASAL</th>
									<th>TANGGAL FAKTUR ASAL</th>
									<th>DPP ASAL</th>
									<th>PPN ASAL</th>
									<th>NTPN</th>
									<th>KETERANGAN LUAR GL</th>
	                            </tr>
	                        </thead>
	                    </table>
	                </div>
				</div>
            </div>
        </div>
    </div>
	 
	<div id="table-2" class="row">
        <div class="col-lg-12">
            <div class="panel panel-info boxshadow animated slideInDown">
                <div class="panel-heading">
					<div class="row">
					  <div class="col-sm-6">
					  	<div class="nama-table"><?php echo ($nama_pajak == "PPN MASUKAN") ? "DOKUMEN LAIN PPN MASUKAN" : "DOKUMEN LAIN PPN KELUARAN" ?></div>
					  </div>
					  <div class="col-sm-6">
					  	<div class="navbar-right">
					  		<!-- <button type="button" id="btnAdd2" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-plus"></i> ADD</button> -->
					  		<button type="button" id="btnEdit2" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
					  		<button type="button" id="btnDelete2" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-trash"></i> DELETE</button>
						</div>
					  </div>
					</div>
				</div>
                <div class="panel-body">
					<div class="table-responsive">
						<div style="padding-bottom: 5px;color:#333;font-weight: 400">
							<label>Sort by </label>
							<select id="orderby2">
								<option value="INVOICE_NUM" data-type="asc">Nomor Invoice A-Z</option>
								<option value="INVOICE_NUM" data-type="desc" selected>Nomor Invoice Z-A</option>
								<!-- <option value="INVOICE_ACCOUNTING_DATE" data-type="asc">Tanggal Invoice A-Z</option>
								<option value="INVOICE_ACCOUNTING_DATE" data-type="desc" >Tanggal Invoice Z-A</option> -->
								<option value="NO_DOKUMEN_LAIN" data-type="asc">Nomor Dokumen Lain A-Z</option>
								<option value="NO_DOKUMEN_LAIN" data-type="desc">Nomor Dokumen Lain Z-A</option>
							</select>
						</div>
						<table width="100%" class="display cell-border stripe hover small" id="tabledata">
	                        <thead>
	                            <tr>
	                            	<th>PAJAK HEADER ID</th>
	                            	<th>PAJAK LINE ID</th>
	                            	<th>VENDOR ID</th>
	                            	<th>IS CHECKLIST</th>
	                            	<th>MASA PAJAK</th>
	                            	<th>TAHUN PAJAK</th>
	                            	<th>CATEGORY</th>
									<th>
										<div class="checkbox checkbox-inverse">
											<input id="checkboxAll-2" type="checkbox">
											<label for="checkboxAll-2"></label>
										</div>
									</th>
	                            	<th>NO</th>
	                            	<th class="text-center no-sort">DL / FS</th>
	                            	<th>PMK</th>
	                            	<th>NPWP</th>
	                            	<th>NAMA</th>
	                            	<th>NOMOR INVOICE</th>
	                            	<th>JUMLAH DPP</th>
	                            	<th>JUMLAH PPN</th>
									<?php if($nama_pajak == "PPN MASUKAN"){ ?>
	                            	<th>AKUN BEBAN</th>
									<?php } else{ ?>
	                            	<th>AKUN PENDAPATAN</th>
									<?php } ?>
	                            	<th>JENIS TRANSAKSI</th>
	                            	<th>JENIS DOKUMEN</th>
	                            	<th>KD JENIS TRANSAKSI</th>
	                            	<th>FG PENGGANTI</th>
	                            	<th>NOMOR DOK LAIN</th>
	                            	<th>TANGGAL DOK LAIN</th>
	                            	<th>NOMOR FAKTUR PAJAK</th>
	                            	<th>TANGGAL FAKTUR PAJAK</th>
	                            	<th>NOMOR DOK LAIN GANTI</th>
	                            	<th>ALAMAT LENGKAP</th>
	                            	<th>MATA UANG</th>
	                            	<th>JUMLAH PPNBM</th>
	                            	<th>KETERANGAN</th>
									<th>FAPR</th>
									<th>TANGGAL APPROVAL</th>
									<th>NOMOR FAKTUR ASAL</th>
									<th>TANGGAL FAKTUR ASAL</th>
									<th>DPP ASAL</th>
									<th>PPN ASAL</th>
									<th>NTPN</th>
									<th>KETERANGAN LUAR GL</th>
	                            </tr>`
	                        </thead>
	                    </table>
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
						<div class="col-lg-12">
							<div class="table-responsive">
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll1">
									<thead>
										<tr>
											<th>TOTAL <?php echo ($nama_pajak == "PPN KELUARAN") ? 'E' :'' ?>FAKTUR <?php echo $nama_pajak ?></th>
											<th>TOTAL DOKUMEN LAIN <?php echo $nama_pajak ?></th>
											<?php if($nama_pajak == "PPN MASUKAN"){ ?>
											<th>PPN YANG DAPAT DIKREDITKAN</th>
											<th>PPN YANG TIDAK DAPAT DI KREDITKAN</th>
											<th>JUMLAH PMK</th>
											<?php }else{?>
											<th>PPN YANG HARUS DIPUNGUT SENDIRI</th>
											<th>PPN YANG DIPUNGUT OLEH PEMUNGUT PPN</th>
											<th>PPN YANG TIDAK DIPUNGUT</th>
											<th>PPN YANG DIBEBASKAN</th>
											<?php } ?>
										</tr>
									</thead>
								</table>
								<br>
							 </div>
							<br>
							</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll2"> 
									<thead>
										<tr>
											<th>SALDO AWAL</th>
											<th>MUTASI DEBET</th> 
											<th>MUTASI KREDIT</th>
											<th>SALDO AKHIR</th>
											<th>JUMLAH DIBAYARKAN</th>
											<th>SELISIH</th>
										</tr>
									</thead>
								</table>
								</br>
							 </div>
							</div>
					</div>
					 <div class="row">
						</br>
						</br>
						<div class="col-lg-12 text-center">
							<button id="btnsaldoAwal" class="btn btn-info btn-rounded custom-input-width" type="button" ><i class="fa fa fa-save"></i> <span>SAVE</span></button>
						</div>
					</div>
				   </div>
			 </div>
			</div>
		</div>
	</div>

	  <div class="row">
		<div class="col-lg-12">
			<div id="accordion-1" class="panel panel-info animated slideInDown">
			<div class="panel-heading">
				<div class="row">
				  <div class="col-lg-6">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-summary-detail">DATA TIDAK DILAPORKAN</a>
				  </div>
				</div>
			</div>
			   <div id="collapse-summary-detail" class="panel-collapse collapse in">
				<div class="panel-body">
				 <div class="row">
					<div class="col-lg-12">
						<div id="dDetail-summary" class="table-responsive">
							<table width="100%" class="display cell-border stripe hover small" id="table-detail-summary">
								<thead>
									<tr>
										<th>NO</th>
										<th>NPWP</th>
										<th>NAMA WP</th> 
										<th>NOMOR FAKTUR PAJAK</th>
										<th>TANGGAL FAKTUR PAJAK</th>
										<th>NOMOR DOKUMEN LAIN</th>
										<th>TANGGAL DOKUMEN LAIN</th>
										<th>DPP</th>
										<th>PPN/JUMLAH POTONG</th>
										<th>KETERANGAN</th>
									</tr>
								</thead>
							</table>
						 </div>		
					</div>
				 </div>
				 </br>
				 <div class="row">
				 	<div class="col-lg-6"></div>
					<div class="col-lg-6">
						<div class="form-group text-right">
							<label>Jumlah Tidak Dilaporkan :</label>
							<span id="jmlTidakDilaporkan" style="font-weight:bold"></span>
						</div>
					 </div>
				 </div>
				</div>
			 </div>
			</div>
		</div>
	 </div>

	<?php if($nama_pajak == "PPN MASUKAN"){ ?>
	  <div class="row">
			<div class="col-lg-12">
				<div id="accordion-3" class="panel panel-info animated slideInDown">
                <div class="panel-heading">
					<div class="row">
					  <div class="col-lg-6">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-pmk">PMK78</a>
					  </div>
					  <?php if($this->session->userdata('kd_cabang') == "000"): ?>
					  <div class="col-sm-6">
					  	<div class="navbar-right">
					  		<button type="button" id="btn_z_percent" class="btn btn-rounded btn-default custom-input-width" ><i class="fa fa-pencil"></i> EDIT Z PERCENT</button>
						</div>
					  </div>
					<?php endif; ?>
					</div>
				</div>
				   <div id="collapse-pmk" class="panel-collapse collapse in">
					<div class="panel-body">
					 <div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">  
								<table width="100%" class="display cell-border stripe hover small" id="table-pmk">
									<thead>
										<tr>
											<th>NO</th>
											<th>Nama Perusahaan</th>
											<th>Uraian Pekerjaan</th>
											<th>No. Faktur</th>
											<th>Tgl Faktur</th>
											<th>DPP</th>
											<th>PPN (PM)</th>
											<th>Z (%)</th>
											<th>P (SPT Masa)</th>
											<th>Koreksi PM</th>
											<th>SPT Masa</th>
											<th>Cabang</th>
										</tr>
									</thead>
								</table>
							 </div>
						</div>
					 </div>
					 </br>
					 <div class="row">
					 	<div class="col-lg-6"></div>
						<div class="col-lg-6">
							<div class="form-group text-right">
								<label>Total DPP :</label>
								<span id="tot_dpp" style="font-weight:bold"></span>
								<br>
								<label>Total PPN :</label>
								<span id="tot_ppn" style="font-weight:bold"></span>
								<br>
								<label>Total Z Percent :</label>
								<span id="tot_z_percent" style="font-weight:bold"></span>
								<br>
								<label>Total P (SPT Masa) :</label>
								<span id="tot_spt" style="font-weight:bold"></span>
								<br>
								<label>Total Koreksi PM :</label>
								<span id="tot_koreksi" style="font-weight:bold"></span>
							</div>
						 </div>
					 </div>
				 </div>
				</div>
			</div>
		 </div>
	 </div>
	<?php } ?>
	<div class="row">
		<div class="col-lg-12">
				<div id="accordion-3" class="panel panel-info animated slideInDown">
				<div class="panel-footer">
					<div class="row">
						<div class="col-lg-12 text-center">
							<button id="btnSubmit" class="btn btn-danger btn-rounded custom-input-width" type="button"><i class="fa fa-share-square-o"></i> <span>SUBMIT</span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="tambah-data">
	<form role="form" id="form-wp" data-toggle="validator">
		<div class="white-box boxshadow">
		  	<div class="row">
				<div class="col-lg-12 align-center">
					<h2 id="capAdd" class="text-center">EDIT DATA</h2>
				</div>	
			</div>
			<div class="row">
				<hr>
			</div>
			<div class="row">
				<div class="col-md-6 ">
					<div class="form-group">
						<input type="hidden" class="form-control" id="idPajakHeader" name="idPajakHeader">
						<input type="hidden" class="form-control" id="idPajakLines" name="idPajakLines">
						<input type="hidden" class="form-control" id="idwp" name="idwp">
						<input type="hidden" class="form-control" id="organization_id" name="organization_id">
						<input type="hidden" class="form-control" id="vendor_site_id" name="vendor_site_id">
						<input type="hidden" class="form-control" id="isnewRecord" name="isnewRecord" value="1">
						<input type="hidden" class="form-control" id="fAddNamaPajak" name="fAddNamaPajak">
						<input type="hidden" class="form-control" id="fAddBulan" name="fAddBulan">
						<input type="hidden" class="form-control" id="fAddTahun" name="fAddTahun">
						<input type="hidden" class="form-control" id="fAddPembetulan" name="fAddPembetulan">
						<label>NAMA WP</label>
						<!-- <div class="input-group">
							<input class="form-control" id="namawp" name="namawp" placeholder="NAMA WP" type="text" readonly>
							<span class="input-group-btn">
							<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp" ><i class="fa fa-search"></i></button>
							</span> 
						</div> -->

						<div class="input-group">
							<input class="form-control" id="namawp" name="namawp" placeholder="Nama WP" type="text" readonly>
							<span class="input-group-btn">
							<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp" ><i class="fa fa-search"></i></button>
							</span> 
						</div>
						<div id="error1"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="npwp" class="control-label">NPWP</label>
						<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP" readonly>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="alamat" class="control-label">ALAMAT</label>
						<textarea class="form-control" rows="2" id="alamat" name="alamat" placeholder="ALAMAT" readonly></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="akun_pajak" class="control-label"><?php echo ($nama_pajak == 'PPN MASUKAN') ? 'AKUN BEBAN' : 'AKUN PENDAPATAN'?></label>
						<input type="text" class="form-control" id="akun_pajak" name="akun_pajak" placeholder="<?php echo ($nama_pajak == 'PPN MASUKAN') ? 'AKUN BEBAN' : 'AKUN PENDAPATAN'?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="invoice_number" class="control-label">INVOICE NUMBER</label>
						<input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="INVOICE NUMBER">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="mata_uang" class="control-label">MATA UANG</label>
						<input type="text" class="form-control" id="mata_uang" name="mata_uang" placeholder="MATA UANG">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="dpp" class="control-label">JUMLAH DPP</label>
						<input type="text" class="form-control" id="dpp" name="dpp" placeholder="DPP" data-toggle="validator" data-error="Mohon isi Jumlah DPP" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="jumlahpotong" class="control-label">JUMLAH PPN</label>
						<input type="text" class="form-control" id="jumlahpotong" name="jumlahpotong" placeholder="JUMLAH PPN" data-toggle="validator" data-error="Mohon isi Jumlah PPN" required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="kd_jenis_transaksi" class="control-label">KODE JENIS TRANSAKSI</label>
						<input type="text" class="form-control" id="kd_jenis_transaksi" name="kd_jenis_transaksi" placeholder="KODE JENIS TRANSAKSI" data-toggle="validator" data-error="Mohon Kode Jenis Transaksi" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="fg_pengganti" class="control-label">FG PENGGANTI</label>
						<input type="text" class="form-control" id="fg_pengganti" name="fg_pengganti" placeholder="FG PENGGANTI" data-toggle="validator" data-error="Mohon isi FG Pengganti" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row dokumen_group">
				<div class="col-md-6">
					<div class="form-group">
						<label for="jenis_transaksi" class="control-label">JENIS TRANSAKSI</label>
						<input type="text" class="form-control" id="jenis_transaksi" name="jenis_transaksi" placeholder="JENIS TRANSAKSI">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nodokumenlain_ganti" class="control-label">NO DOKUMEN LAIN GANTI</label>
						<input type="text" class="form-control" id="nodokumenlain_ganti" name="nodokumenlain_ganti" placeholder="NO DOKUMEN LAIN GANTI">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nodokumenlain" class="control-label">NO DOKUMEN LAIN</label>
						<input type="text" class="form-control" id="nodokumenlain" name="nodokumenlain" placeholder="NO DOKUMEN LAIN" data-toggle="validator" data-error="Mohon isi No Dokumen Lain" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggaldokumenlain" class="control-label">TANGGAL DOKUMEN LAIN</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggaldokumenlain" name="tanggaldokumenlain" placeholder="dd/mm/yyyy" data-toggle="validator" data-error="Mohon isi Tanggal Dokumen Lain" required> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row faktur_group">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nofakturpajak" class="control-label">NO FAKTUR PAJAK</label>
						<input type="text" class="form-control" id="nofakturpajak" name="nofakturpajak" placeholder="NO FAKTUR PAJAK" data-toggle="validator" data-error="Mohon isi No Faktur Pajak" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggalfakturpajak" class="control-label">TANGGAL FAKTUR PAJAK</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggalfakturpajak" name="tanggalfakturpajak" placeholder="dd/mm/yyyy" data-toggle="validator" data-error="Mohon isi Tanggal Dokumen Lain" required> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>JUMLAH PPNBM</label>
						<input type="text" class="form-control" id="jumlah_ppnbm" name="jumlah_ppnbm" placeholder="JUMLAH PPNBM">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>JENIS DOKUMEN</label>
						<input type="text" class="form-control" id="jenis_dokumen" name="jenis_dokumen" placeholder="JENIS DOKUMEN">
					</div>
				</div>
			</div>
			<div class="row dokumen_group">
				<div class="col-md-6">
					<div class="form-group">
						<label for="keterangan" class="control-label">KETERANGAN</label>
						<textarea class="form-control" rows="3" id="keterangan" name="keterangan" placeholder="KETERANGAN"></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="fapr" class="control-label">FAPR</label>
						<input type="text" class="form-control" id="fapr" name="fapr" placeholder="FAPR">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="faktur_asal" class="control-label">NOMOR FAKTUR ASAL</label>
						<input type="text" class="form-control" id="faktur_asal" name="faktur_asal" placeholder="NOMOR FAKTUR ASAL">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggal_faktur_asal" class="control-label">TANGGAL FAKTUR ASAL</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggal_faktur_asal" name="tanggal_faktur_asal" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="dpp_asal" class="control-label">DPP ASAL</label>
						<input type="text" class="form-control" id="dpp_asal" name="dpp_asal" placeholder="DPP ASAL">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="ppn_asal" class="control-label">PPN ASAL</label>
						<input type="text" class="form-control" id="ppn_asal" name="ppn_asal" placeholder="PPN ASAL">
					</div>
				</div>
			</div>
			<div class="row faktur_group3"<?php echo ($nama_pajak == "PPN KELUARAN") ? ' style="display:none;"' : '' ?>>
				<div class="col-md-6">
					<div class="form-group">
						<label for="is_creditable" class="control-label">IS CREDITABLE</label>
						<select class="form-control" id="is_creditable" name="is_creditable">
							<option value="1" selected>1</option>
							<option value="0">0</option>
						</select>
					</div>
				</div>
			</div>	
			<div class="row dokumen_group">
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggal_approval" class="control-label">TANGGAL APPROVAL</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggal_approval" name="tanggal_approval" placeholder="dd/mm/yyyy" data-toggle="validator" data-error="Mohon isi Tanggal Dokumen Lain"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>

			<div class="row faktur_group2"<?php echo ($nama_pajak == "PPN MASUKAN") ? ' style="display:none;"' : '' ?>>

				<div class="col-md-6">
					<div class="form-group">
						<label for="id_keterangan_tambahan" class="control-label">ID KETERANGAN TAMBAHAN</label>
						<input type="text" class="form-control" id="id_keterangan_tambahan" name="id_keterangan_tambahan" placeholder="ID KETERANGAN TAMBAHAN">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="fg_uang_muka" class="control-label">FG UANG MUKA</label>
						<input type="text" class="form-control" id="fg_uang_muka" name="fg_uang_muka" placeholder="FG UANG MUKA">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="uang_muka_dpp" class="control-label">UANG MUKA DPP</label>
						<input type="text" class="form-control" id="uang_muka_dpp" name="uang_muka_dpp" placeholder="UANG MUKA DPP">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="uang_muka_ppn" class="control-label">UANG MUKA PPN</label>
						<input type="text" class="form-control" id="uang_muka_ppn" name="uang_muka_ppn" placeholder="UANG MUKA PPN">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="uang_muka_ppnbm" class="control-label">UANG MUKA PPNBM</label>
						<input type="text" class="form-control" id="uang_muka_ppnbm" name="uang_muka_ppnbm" placeholder="UANG MUKA PPNBM">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="referensi" class="control-label">REFERENSI</label>
						<input type="text" class="form-control" id="referensi" name="referensi" placeholder="REFERENSI">
					</div>
				</div>

			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="ntpn" class="control-label">NTPN</label>
						<input type="text" class="form-control" id="ntpn" name="ntpn" placeholder="NTPN">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="keterangan_gl" class="control-label">KETERANGAN LUAR GL</label>
						<input type="text" class="form-control" id="keterangan_gl" name="keterangan_gl" placeholder="KETERANGAN LUAR GL">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="navbar-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>
					<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
					<button type="submit" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
				</div>
			</div>
		</div>
	</form>	
</div>
		

</div>

<!-- modal master nama WP -->
<div id="modal-namawp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Data Nama WP</h4> </div>
			<div class="modal-body">
				<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small animated slideInDown" id="tabledata-namawp"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>ID</th>
								<th>ORGANIZATION ID</th>
								<th>VENDOR SITE ID</th>
								<th>NAMA WP</th>
								<th>ALAMAT</th>
								<th>NPWP</th>
							</tr>
						</thead>
					</table>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
			</div>
		</div>	
	</div>
</div>

<div id="modal-uraian" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="uraian_wp" class="modal-title"></h4> </div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <form class="form-horizontal" id="form-uraian_pmk" data-toggle="validator">
                                <div class="form-group">
                                    <label class="col-md-12">Uraian Pekerjaan</label>
                                    <div class="col-md-12">
										<input type="hidden" class="form-control" id="uraian_id" name="uraian_id">
										<input type="text" class="form-control" id="uraian_pekerjaan" name="uraian_pekerjaan" placeholder="Uraian Pekerjaan">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel_Uraian"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnSave_uraian"><i class="fa fa-paper-plane"></i> SAVE</button>
			</div>
		</div>	
	</div>
</div>

<div id="modal-zpercent" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Z Percent</h4>
			 </div>
			<div class="modal-body">
			
                <div class="row">
                    <div class="col-sm-12">
						
                        <div class="white-box">
                            <form class="form-horizontal" id="form-zpercent" data-toggle="validator">
                            	<div class="row">
                            		<div class="col-md-6">
		                                <div class="form-group">
		                                    <label class="col-md-12">Penyerahan tidak terutang PPN tahun <span class="tahun_z_percent"></span></label>
		                                    <div class="col-md-12">
												<input type="hidden" class="form-control" id="z_percent_bulan" name="z_percent_bulan">
												<input type="hidden" class="form-control" id="z_percent_tahun" name="z_percent_tahun">
												<input type="number" class="form-control" id="tidak_terutang_ppn" name="tidak_terutang_ppn" placeholder="0">
		                                    </div>
		                                </div>
                            		</div>
                            		<div class="col-md-6">
		                                <div class="form-group">
		                                    <label class="col-md-12">Penyerahan terutang PPN tahun <span class="tahun_z_percent"></span></label>
		                                    <div class="col-md-12">
												<input type="number" class="form-control" id="terutang_ppn" name="terutang_ppn" placeholder="0">
		                                    </div>
		                                </div>
                            		</div>
                            	</div>
                            	<div class="row">
                            		<div class="col-md-6">
		                                <div class="form-group">
		                                    <label class="col-md-12">Penyerahan terutang PPN dan tidak terutang PPN tahun <span class="tahun_z_percent"></span></label>
		                                    <div class="col-md-12">
												<input type="text" class="form-control" id="terutang_tidak_terutang" name="terutang_tidak_terutang" placeholder="0">
		                                    </div>
		                                </div>
                            		</div>
                            		<div class="col-md-6">
		                                <div class="form-group">
		                                    <label class="col-md-12">Persentase jumlah penyerahan yang terutang pajak terhadap penyerahan seluruhnya</label>
		                                    <div class="col-md-12">
												<input type="text" class="form-control" id="z_percent" name="z_percent" placeholder="0">
		                                    </div>
		                                </div>
                            		</div>
                            	</div>
                            </form>
                        </div>
                    </div>
                </div>
				
                <div class="row">
                	<div class="col-md-offset-3 col-md-6 text-center">
                		<button type="button" class="btn btn-info waves-effect" id="btnSave_zpercent"><i class="fa fa-paper-plane"></i> SAVE</button>
                	</div>
                </div>
                <div class="row">
                	<div class="col-md-12">
						<div class="table-responsive">

						<div class="text-center" style="margin:10px auto;padding-bottom: 5px;color:#333;font-weight: 400">
							<label>Tahun </label>
							<select id="tahun_z_percent_lov">
								<?php
									$tahun    = date('Y');
									$tAwal    = $tahun - 3;
									$tAkhir   = $tahun;
									$selected = "";
									for($i=$tAwal; $i<=$tAkhir; $i++){
										$selected = ($i == $tahun) ? "selected" : "";
										echo "<option value='".$i."' ".$selected.">&nbsp;&nbsp;".$i."&nbsp;&nbsp;</option>";
									}
										echo "<option value='".$i."'>&nbsp;&nbsp;".$i."&nbsp;&nbsp;</option>";

								?>
							</select>
						</div>
							<table width="100%" class="cell-border stripe hover small animated slideInDown" id="table-z-percent"> 
								<thead>
									<tr>
										<th>NO</th>
										<th>ID</th>
										<th>TAHUN</th>
										<th>BULAN</th>
										<th>Z PERCENT</th>
									</tr>
								</thead>
							</table>
						</div>
                	</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning waves-effect text-left" data-dismiss="modal" id="btnCancel_zpercent"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="fa fa-times-circle"></i>  CLOSE</button>
			</div>
		</div>	
	</div>
</div>


<script>
    $(document).ready(function() {
			var table1                 = "",
			table2                     = "",
			table_wp                   = "",
			val_pajak_line_id          = "",
			val_pajak_header_id        = "",
			val_vendor_id              = "",
			val_organization_id        = "",
			val_vendor_site_id         = "",
			val_akun_pajak             = "",
			val_nama_pajak             = "",
			val_masa_pajak             = "",
			val_tahun_pajak            = "",
			val_jenis_transaksi        = "",
			val_jenis_dokumen          = "",
			val_kd_jenis_transaksi     = "",
			val_fg_pengganti           = "",
			val_no_dokumen_lain_ganti  = "",
			val_no_dokumen_lain        = "",
			val_tanggal_dokumen_lain   = "",
			val_no_faktur_pajak        = "",
			val_tanggal_faktur_pajak   = "",
			val_npwp                   = "",
			val_nama_wp                = "",
			val_alamat                 = "",
			val_invoice_number         = "",
			val_akun_pajak             = "",
			val_mata_uang              = "",
			val_dpp                    = "",
			val_jumlah_potong          = "",
			val_jumlah_ppnbm           = "",
			val_keterangan             = "",
			val_is_creditable          = "",
			val_fapr                   = "",
			val_tanggal_approval       = "",
			val_id_keterangan_tambahan = "",
			val_fg_uang_muka           = "",
			val_uang_muka_dpp          = "",
			val_uang_muka_ppn          = "",
			val_uang_muka_ppnbm        = "",
			val_referensi              = "",
			vlinse_id                  = "",
			vcheckbox_id               = "",
			vcategory_id               = "",
			val_dl_fs                  = "",
			dlfs_data                  = "",
			dlfs_id                    = "",
			dlfs_val                   = "",
			dlfs_category              = "",
			vis_checkAll               = 1,
			val_faktur_asal            = "",
			val_tanggal_faktur_asal    = "",
			val_dpp_asal               = "",
			val_ppn_asal               = "",
			val_keterangan_gl          = "",
			val_ntpn                   = "",
			pmk_vlinse_id              = "",
			pmk_vcheckbox_id           = "",
			pmk_vcategory_id           = "",
			pmk_vcategoryTable         = "",
			pmk_vcategoryTable         = "",
			tidak_terutang_ppn         = 0,
			terutang_ppn               = 0,
			terutang_tidak_terutang    = 0,
			z_percent                  = 0;
			
		$("#dpp, #jumlahpotong, #saldoAwal").number(true,2);
		$("#d-FormCsv").hide();
		$("#tambah-data").hide();
		
		$('#modal-namawp').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});

		valueAdd();
		getSummary();
		orderBy("orderby1");
		orderBy("orderby2");

/* FAKTUR STANDAR */
		 Pace.track(function(){
		   $('#table_faktur').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_rekonsiliasi',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $("#pembetulanKe").val();
										d._category         = 'faktur_standar';
										d._orderby          = orderby1;
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
					{ "data": "organization_id" },
					{ "data": "vendor_site_id" },
					{ "data": "is_checklist" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "category" },
					{ "data": "no_dokumen_lain", "class":"text-center"},
					{ "data": "tanggal_dokumen_lain", "class":"text-center"},
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "dl_fs"},
					{ "data": "pmk_checkbox", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "invoice_number"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "kd_jenis_transaksi", "class":"text-center"},
					{ "data": "fg_pengganti", "class":"text-center"},
					{ "data": "no_faktur_pajak", "class":"text-center"},
					{ "data": "tanggal_faktur_pajak", "class":"text-center"},
					{ "data": "alamat_wp"},
					{ "data": "mata_uang"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					<?php if($nama_pajak == "PPN MASUKAN"){ ?>
					{ "data": "is_creditable", "class":"text-center"},
					<?php }else{ ?>
					{ "data": "id_keterangan_tambahan", "class":"text-center"},
					{ "data": "fg_uang_muka", "class":"text-center"},
					{ "data": "uang_muka_dpp", "class":"text-center"},
					{ "data": "uang_muka_ppn", "class":"text-center"},
					{ "data": "uang_muka_ppnbm", "class":"text-center"},
					{ "data": "referensi", "class":"text-center"},
					<?php } ?>
					{ "data": "faktur_asal", "class":"text-center"},
					{ "data": "tanggal_faktur_asal", "class":"text-center"},
					{ "data": "dpp_asal", "class":"text-center"},
					{ "data": "ppn_asal", "class":"text-center"},
					{ "data": "ntpn", "class":"text-center"},
					{ "data": "keterangan_gl", "class":"text-center"}
				],
			"columnDefs": [
				{
					"targets": [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 <?php if($nama_pajak == "PPN KELUARAN"){ echo ', 14'; }?>],
					"visible": false
				}
			],
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "ordering"			: false,
			 "bAutoWidth" : false
			});
		 });
		table1 = $('#table_faktur').DataTable();
		table1.on('error.dt', function(e, settings, techNote, message) {
			pushTableError($("#table-1 .nama-table").html());
		})
		
		$("#list-data input[type=search]").addClear();
		$('#list-data #table-1 .dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/ Invoice/ Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#table_faktur_filter .add-clear-x").on('click',function(){
			table1.search('').column().search('').draw();
		});
		
		table1.on( 'draw', function () {
			$(".checklist-1").on("click", function(){
				vlinse_id 		= $(this).data("id");
				vcheckbox_id 	= $(this).attr("id"); 
				vcategory_id 	= $(this).attr("category-id");
				vcategoryTable = 'table1';
				actionCheck();
			 });
			$(".pmkchecklist-1").on("click", function(){
				pmk_vlinse_id      = $(this).data("id");
				pmk_vcheckbox_id   = $(this).attr("id"); 
				pmk_vcategory_id   = $(this).attr("category-id");
				pmk_vcategoryTable = 'table1';
				actionCheckPmk();
			 });
			$(".radio_dlfs").on("click", function(){
				dlfs_val      = $(this).val();
				dlfs_data     = $(this).data("id");
				dlfs_id       = $(this).attr("id");
				dlfs_category = $(this).attr("category-id");

				if(dlfs_category == "faktur_standar"){
					action_dlfs();
				}
			 });
			$("#btnEdit1").attr("disabled",true);
			$("#btnDelete1").attr("disabled",true);
			getFormCSV();
			getSelectAll1();

			if(table1.data().any()){
				$("#btnAdd1").removeAttr('disabled');
			}
			else{
				$("#btnAdd1").attr("disabled",true);
			}
		});

		table1.on( 'page.dt',   function () {
			orderBy("orderby1");
		} )

		$('#table_faktur tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empty();
			} else {
				table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d                    = table1.row( this ).data();
				val_pajak_header_id      = d.pajak_header_id;
				val_pajak_line_id        = d.pajak_line_id;
				val_akun_pajak           = d.akun_pajak;
				val_vendor_id            = d.vendor_id;
				val_masa_pajak           = d.masa_pajak;
				val_tahun_pajak          = d.tahun_pajak;
				val_dl_fs                = d.category;
				val_jenis_dokumen        = d.jenis_dokumen;
				val_kd_jenis_transaksi   = d.kd_jenis_transaksi;
				val_fg_pengganti         = d.fg_pengganti;
				val_no_faktur_pajak      = d.no_faktur_pajak;
				val_tanggal_faktur_pajak = d.tanggal_faktur_pajak;
				val_npwp                 = d.npwp;
				val_nama_wp              = d.nama_wp;
				val_alamat               = d.alamat_wp;
				val_invoice_number       = d.invoice_number;
				val_akun_pajak           = d.akun_pajak;
				val_mata_uang            = d.mata_uang;
				val_dpp                  = d.dpp;
				val_jumlah_potong        = d.jumlah_potong;
				val_jumlah_ppnbm         = d.jumlah_ppnbm;
				val_is_creditable        = d.is_creditable;
				val_fapr                 = d.fapr;
				val_tanggal_approval     = d.tanggal_approval;
				val_faktur_asal          = d.faktur_asal;
				val_tanggal_faktur_asal  = d.tanggal_faktur_asal;
				val_dpp_asal             = d.dpp_asal;
				val_ppn_asal             = d.ppn_asal;
				val_ntpn                 = d.ntpn;
				val_keterangan_gl        = d.keterangan_gl;
				valueGrid();
				showHide();
				$("#btnEdit1").removeAttr('disabled');
				$("#btnDelete1").removeAttr('disabled');
			}

		} ).on("dblclick", "tr", function () {
			table1.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
				var d                    = table1.row( this ).data();
				val_pajak_header_id      = d.pajak_header_id;
				val_pajak_line_id        = d.pajak_line_id;
				val_akun_pajak           = d.akun_pajak;
				val_vendor_id            = d.vendor_id;
				val_masa_pajak           = d.masa_pajak;
				val_tahun_pajak          = d.tahun_pajak;
				val_dl_fs                = d.category;
				val_jenis_dokumen        = d.jenis_dokumen;
				val_kd_jenis_transaksi   = d.kd_jenis_transaksi;
				val_fg_pengganti         = d.fg_pengganti;
				val_no_faktur_pajak      = d.no_faktur_pajak;
				val_tanggal_faktur_pajak = d.tanggal_faktur_pajak;
				val_npwp                 = d.npwp;
				val_nama_wp              = d.nama_wp;
				val_alamat               = d.alamat_wp;
				val_invoice_number       = d.invoice_number;
				val_akun_pajak           = d.akun_pajak;
				val_mata_uang            = d.mata_uang;
				val_dpp                  = d.dpp;
				val_jumlah_potong        = d.jumlah_potong;
				val_jumlah_ppnbm         = d.jumlah_ppnbm;
				val_is_creditable        = d.is_creditable;
				val_fapr                 = d.fapr;
				val_tanggal_approval     = d.tanggal_approval;
				val_faktur_asal          = d.faktur_asal;
				val_tanggal_faktur_asal  = d.tanggal_faktur_asal;
				val_dpp_asal             = d.dpp_asal;
				val_ppn_asal             = d.ppn_asal;
				val_ntpn                 = d.ntpn;
				val_keterangan_gl        = d.keterangan_gl;
			valueGrid();
			showHide();
			$("#btnEdit1").removeAttr('disabled');
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+val_nama_pajak+" Bulan "+val_masa_pajak+" Tahun "+val_tahun_pajak+"</span>");
		} );

/* FAKTUR STANDAR END */

/* DOKUMEN LAIN */
		 Pace.track(function(){
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
									"url"  		: baseURL + 'ppn_masa/load_rekonsiliasi',
									"type" 		: "POST",
									"data"		: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $("#pembetulanKe").val();
										d._category         = 'dokumen_lain';
										d._orderby          = orderby2;
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
					{ "data": "is_checklist"},
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "category" },
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "dl_fs"},
					{ "data": "pmk_checkbox", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "invoice_number"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "jenis_transaksi",  "class":"text-center"},
					{ "data": "jenis_dokumen",  "class":"text-center"},
					{ "data": "kd_jenis_transaksi",  "class":"text-center"},
					{ "data": "fg_pengganti",  "class":"text-center"},
					{ "data": "no_dokumen_lain", "class":"text-center"},
					{ "data": "tanggal_dokumen_lain", "class":"text-center"},
					{ "data": "no_faktur_pajak", "class":"text-center"},
					{ "data": "tanggal_faktur_pajak", "class":"text-center"},
					{ "data": "no_dokumen_lain_ganti", "class":"text-center"},
					{ "data": "alamat_wp"},
					{ "data": "mata_uang"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					{ "data": "keterangan"},
					{ "data": "fapr"},
					{ "data": "tanggal_approval"},
					{ "data": "faktur_asal"},
					{ "data": "tanggal_faktur_asal"},
					{ "data": "dpp_asal"},
					{ "data": "ppn_asal"},
					{ "data": "ntpn"},
					{ "data": "keterangan_gl"}
				],
			"columnDefs": [ 
				{
					"targets": [ 0, 1, 2, 3, 4, 5, 6 <?php if($nama_pajak == "PPN KELUARAN"){ echo ', 10'; }?>, 23, 24],
					"visible": false
				}
			],
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true,
			 "scrollX"			: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "ordering"         : false,
			 "bAutoWidth" : false
			});
		 });
		
		table2 = $('#tabledata').DataTable();

		table2.on('error.dt', function(e, settings, techNote, message) {
			pushTableError($("#table-2 .nama-table").html());
		})
		
		$("#list-data input[type=search]").addClear();

		$('#list-data #table-2 .dataTables_filter input[type="search"]').attr('placeholder','Cari No Dok/ Invoice/ Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table2.search('').column().search('').draw();
		});

		table2.on( 'draw', function () {
			$(".checklist-2").on("click", function(){
				vlinse_id      = $(this).data("id");
				vcheckbox_id   = $(this).attr("id"); 
				vcategory_id   = $(this).attr("category-id");
				vcategoryTable = 'table2';
				actionCheck();
			 });
			$(".pmkchecklist-2").on("click", function(){
				pmk_vlinse_id      = $(this).data("id");
				pmk_vcheckbox_id   = $(this).attr("id"); 
				pmk_vcategory_id   = $(this).attr("category-id");
				pmk_vcategoryTable = 'table2';
				actionCheckPmk();
			 });
			$(".radio_dlfs").on("click", function(){
				dlfs_val      = $(this).val();
				dlfs_data     = $(this).data("id");
				dlfs_id       = $(this).attr("id");
				dlfs_category = $(this).attr("category-id");
				
				if(dlfs_category == "dokumen_lain"){
					action_dlfs();
				}
			 });
			$("#btnEdit2").attr("disabled",true);
			$("#btnDelete2").attr("disabled",true);
			getFormCSV();
			getSelectAll2();

			if(table2.data().any()){
				$("#btnAdd2").removeAttr('disabled');
			}
			else{
				$("#btnAdd2").attr("disabled",true);
			}
		});

		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empty();
			} else {
				table2.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d                     = table2.row( this ).data();
				val_pajak_header_id       = d.pajak_header_id;
				val_pajak_line_id         = d.pajak_line_id;
				val_akun_pajak            = d.akun_pajak;
				val_vendor_id             = d.vendor_id;
				val_masa_pajak            = d.masa_pajak;
				val_tahun_pajak           = d.tahun_pajak;
				val_dl_fs                 = d.category;
				val_jenis_transaksi       = d.jenis_transaksi;
				val_jenis_dokumen         = d.jenis_dokumen;
				val_kd_jenis_transaksi    = d.kd_jenis_transaksi;
				val_fg_pengganti          = d.fg_pengganti;
				val_no_dokumen_lain_ganti = d.no_dokumen_lain_ganti;
				val_no_dokumen_lain       = d.no_dokumen_lain;
				val_tanggal_dokumen_lain  = d.tanggal_dokumen_lain;
				val_no_faktur_pajak       = d.no_faktur_pajak;
				val_tanggal_faktur_pajak  = d.tanggal_faktur_pajak;
				val_npwp                  = d.npwp;
				val_nama_wp               = d.nama_wp;
				val_alamat                = d.alamat_wp;
				val_invoice_number        = d.invoice_number;
				val_akun_pajak            = d.akun_pajak;
				val_mata_uang             = d.mata_uang;
				val_dpp                   = d.dpp;
				val_jumlah_potong         = d.jumlah_potong;
				val_jumlah_ppnbm          = d.jumlah_ppnbm;
				val_keterangan            = d.keterangan;
				val_fapr                  = d.fapr;
				val_faktur_asal           = d.faktur_asal;
				val_tanggal_faktur_asal   = d.tanggal_faktur_asal;
				val_dpp_asal              = d.dpp_asal;
				val_ppn_asal              = d.ppn_asal;
				val_keterangan_gl         = d.keterangan_gl;
				val_ntpn                  = d.ntpn;

				valueGrid();
				showHide();
				$("#btnEdit2").removeAttr('disabled');
				$("#btnDelete2").removeAttr('disabled');
			}

		} ).on("dblclick", "tr", function () {
			table2.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d                     = table2.row( this ).data();
			val_pajak_header_id       = d.pajak_header_id;
			val_pajak_line_id         = d.pajak_line_id;
			val_akun_pajak            = d.akun_pajak;
			val_vendor_id             = d.vendor_id;
			val_masa_pajak            = d.masa_pajak;
			val_tahun_pajak           = d.tahun_pajak;
			val_dl_fs                 = d.category;
			val_jenis_transaksi       = d.jenis_transaksi;
			val_jenis_dokumen         = d.jenis_dokumen;
			val_kd_jenis_transaksi    = d.kd_jenis_transaksi;
			val_fg_pengganti          = d.fg_pengganti;
			val_no_dokumen_lain_ganti = d.no_dokumen_lain_ganti;
			val_no_dokumen_lain       = d.no_dokumen_lain;
			val_tanggal_dokumen_lain  = d.tanggal_dokumen_lain;
			val_no_faktur_pajak       = d.no_faktur_pajak;
			val_tanggal_faktur_pajak  = d.tanggal_faktur_pajak;
			val_npwp                  = d.npwp;
			val_nama_wp               = d.nama_wp;
			val_alamat                = d.alamat_wp;
			val_invoice_number        = d.invoice_number;
			val_akun_pajak            = d.akun_pajak;
			val_mata_uang             = d.mata_uang;
			val_dpp                   = d.dpp;
			val_jumlah_potong         = d.jumlah_potong;
			val_jumlah_ppnbm          = d.jumlah_ppnbm;
			val_keterangan            = d.keterangan;
			val_fapr                  = d.fapr;
			val_faktur_asal           = d.faktur_asal;
			val_tanggal_faktur_asal   = d.tanggal_faktur_asal;
			val_dpp_asal              = d.dpp_asal;
			val_ppn_asal              = d.ppn_asal;
			val_keterangan_gl         = d.keterangan_gl;
			val_ntpn                  = d.ntpn;

			valueGrid();
			showHide();

			$("#btnEdit2").removeAttr('disabled');
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+val_nama_pajak+" Bulan "+val_masa_pajak+" Tahun "+val_tahun_pajak+"</span>");
		} );
/* DOKUMEN LAIN END */
	
	function orderBy(order){
		orderbyorder = $("#"+order).val();
		orderbyasc   = $("#"+order).find(':selected').attr('data-type');
		if(order == "orderby1"){
			orderby1 = [orderbyorder, orderbyasc];
		}else{
			orderby2 = [orderbyorder, orderbyasc];
		}
	}

	$("#orderby1, #orderby2").on("change", function(){
		getId = $(this).attr('id');
		orderBy(getId);
		if(getId == "orderby1"){
			table1.ajax.reload(null, false);
		}else{
			table2.ajax.reload(null, false);
		}
	});



	function getSummary(){

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_summary_rekonsiliasiAll1',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = "Rekonsiliasi";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	:'<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "total_faktur", "class":"text-center" },
					{ "data": "total_doklain", "class":"text-center" },
				<?php if($nama_pajak == "PPN MASUKAN"){ ?>
					{ "data": "di_kreditkan", "class":"text-center" },
					{ "data": "not_creditable", "class":"text-center" },
					{ "data": "pmk", "class":"text-center" }
				<?php }else{ ?>
					{ "data": "ppn_dipungut", "class":"text-center" },
					{ "data": "ppn_dipungut_oleh_pemungut", "class":"text-center" },
					{ "data": "ppn_tdk_dipungut", "class":"text-center" },
					{ "data": "ppn_beban", "class":"text-center" }
				<?php } ?>
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
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = "Rekonsiliasi";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	:'<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "saldo_awal", "class":"text-center" },
					{ "data": "mutasi_debet", "class":"text-center" },
					{ "data": "mutasi_kredit", "class":"text-center" },
					{ "data": "saldo_akhir", "class":"text-center" },
					{ "data": "jumlah_dibayarkan", "class":"text-center" },
					{ "data": "selisih", "class":"text-center" }
				],
			 "scrollCollapse"	: true,
			 "scrollX"			: true,
			 "ordering"			: false
			});
			
		} else {
			$('#tabledata-summaryAll2').DataTable().ajax.reload();
		}

		/* Awal detail Summary */
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
		$('#table-detail-summary').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_detail_summary',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = "Rekonsiliasi";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "npwp1" },
					{ "data": "vendor_name" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_dokumen_lain" },
					{ "data": "tanggal_dokumen_lain" },
					{ "data": "dpp" , "class":"text-right" },
					{ "data": "jumlah_potong" , "class":"text-right" },
					{ "data": "keterangan" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 7 ],
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
		/*Tabel PMK */
		if ( ! $.fn.DataTable.isDataTable( '#table-pmk' ) ) {
		$('#table-pmk').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_pmk',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = "Rekonsiliasi";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "vendor_name" },
					{ "data": "uraian_pekerjaan" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "dpp", "class":"sum" },
					{ "data": "jumlah_potong", "class":"sum" },
					{ "data": "z_percent"},
					{ "data": "spt_masa", "class":"sum" },
					{ "data": "koreksi_pm", "class":"sum" },
					{ "data": "masa_tahun_pajak" },
					{ "data": "cabang" }
				],
			 "scrollY"			: 300, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			});
		} else {
			$('#table-pmk').DataTable().ajax.reload();
		}
		/*Tabel PMK */
		if ( ! $.fn.DataTable.isDataTable( '#table-z-percent' ) ) {

			$('#table-z-percent').DataTable({
				"serverSide"	: true,
				"processing"	: false,
				"ajax"			: {
										 "url"  		: baseURL + 'ppn_masa/load_z_percent_table',
										 "type" 		: "POST",
										 "data"			: function ( d ) {
												d._tahun   = $('#tahun_z_percent_lov').val();
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
						{ "data": "id" },
						{ "data": "tahun" },
						{ "data": "bulan" },
						{ "data": "nilai" }
					],
				"columnDefs": [ 
					 {
						"targets": [ 1],
						"visible": false
					} 
				],
				 "select"			: true,
				 "scrollY"			: 360, 
				 "scrollCollapse"	: true, 
				 "scrollX"			: true,
				 "ordering"			: false
			});	
		} else {
			$('#table-z-percent').DataTable().ajax.reload();
		}


		$.ajax({
			url		: baseURL + 'ppn_masa/load_total_detail_summary',
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPpn : $('#jenisPajak').val(), _searchPembetulan : $('#pembetulanKe').val(), _category : "Rekonsiliasi" }),
			success	: function(result){			
					$("#jmlTidakDilaporkan").html(number_format(result.jml_tidak_dilaporkan,2,'.',','));
				}
		});

		$.ajax({
			url		: baseURL + 'ppn_masa/load_total_pmk',
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPpn : $('#jenisPajak').val(), _searchPembetulan : $('#pembetulanKe').val()}),
			success	: function(result){
					$("#tot_dpp").html(number_format(result.tot_dpp,2,'.',','));
					$("#tot_ppn").html(number_format(result.tot_ppn,2,'.',','));
					$("#tot_z_percent").html(result.tot_z_percent);
					$("#tot_spt").html(number_format(result.tot_spt,2,'.',','));
					$("#tot_koreksi").html(result.tot_koreksi);
					$("#pmk").html(number_format(result.tot_koreksi,2,'.',','));
				}
		});

		$.ajax({
			url		: baseURL + 'ppn_masa/load_z_percent',
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val()}),
			success	: function(result){
					val_z_bulan        = $('#bulan').val();
					val_z_tahun        = $('#tahun').val();
					val_z_percent      = result.z_percent;
					val_terutang_ppn   = result.terutang_ppn;
					val_tidak_terutang = result.tidak_terutang;
				}
		});

		/* Akhir detail Summary */
	}

	$("#tahun_z_percent_lov").on("change", function(){
		$('#table-z-percent').DataTable().ajax.reload();

		tahun_z_percent   = $("#tahun_z_percent_lov").val();

		$(".tahun_z_percent").html(tahun_z_percent);
		$("#tahun_z_percent_v").val(tahun_z_percent);
	});

		$('#table-detail-summary tbody').on("change", "tr .ket_detail", function () {

			idnya = $(this).attr('data-id');
			ket   = $(this).val();

		  	$.ajax({
				url		: baseURL + 'ppn_masa/save_keterangan',
				type	: "POST",
				data	: ({id:idnya, ket:ket}),
				success	: function(result){
					if (result==1) {
						 flashnotif('Sukses','Keterangan Berhasil di Simpan!','success' );
					} else {
						 flashnotif('Error','Keterangan Gagal di Simpan!','error' );
					}
				}
			});
		} );


		$('#table-pmk tbody').on("click", "tr .uraian_pekerjaan", function () {

			uraian_id        = $(this).attr('data-id');
			data_vendor      = $(this).attr('data-vendor');
			uraian_pekerjaan = $(this).attr('data-uraian');

			$("#uraian_wp").html(data_vendor);
			$("#uraian_id").val(uraian_id);
			$("#uraian_pekerjaan").val(uraian_pekerjaan);
			
			$("#modal-uraian").modal("show");

		} );
		$("#btnCancel_Uraian").on("click",batal_uraian);


		$("#btn_z_percent").on('click',function(){

			$("#z_percent_bulan").val(val_z_bulan);
			$("#z_percent_tahun").val(val_z_tahun);
			$("#z_percent").val(val_z_percent);
			$("#tidak_terutang_ppn").val(val_tidak_terutang);
			$("#terutang_ppn").val(val_terutang_ppn);
			// $("#terutang_tidak_terutang").val(terutang3);

			$("#modal-zpercent").modal("show");

		} );


		$("#tidak_terutang_ppn, #terutang_ppn").on("keyup blur",function(){
			tidak_terutang_ppn      = $("#tidak_terutang_ppn").val();
			terutang_ppn            = $("#terutang_ppn").val();
			terutang_tidak_terutang = +tidak_terutang_ppn + +terutang_ppn;
			z_percent               = (terutang_ppn/terutang_tidak_terutang)*100;
			z_percent_nya           = number_format(z_percent,2,'.',',');
			
			$("#terutang_tidak_terutang").val(number_format(terutang_tidak_terutang,0,'.',','));
			$("#z_percent").val(z_percent_nya+'%');
		});

		$('#btnSave_uraian').on('click', function(e) {
				
		  	$.ajax({
				url		: baseURL + 'ppn_masa/save_uraian_pekerjaan',
				type	: "POST",
				data	: $('#form-uraian_pmk').serialize(),
				success	: function(result){
					if (result==1) {
						$("#modal-uraian").modal("hide");
						flashnotif('Sukses','Berhasil di Simpan!','success' );
						getSummary();
					} else {
						flashnotif('Error','Gagal di Simpan!','error' );
						getSummary();
					}
				}
			});

		});

		$('#btnSave_zpercent').on('click', function(e) {

		  	$.ajax({
				url		: baseURL + 'ppn_masa/save_z_percent',
				type	: "POST",
				data	: $('#form-zpercent').serialize(),
				success	: function(result){
					if (result==1) {
						$("#modal-zpercent").modal("hide");
						flashnotif('Sukses','Berhasil di Simpan!','success' );
						getSummary();
					} else {
						flashnotif('Error','Gagal di Simpan!','error' );
						getSummary();
					}
				}
			});

		});

		function batal_uraian()
		{
			uraian_id        = "";
			data_vendor      = "";
			uraian_pekerjaan = "";
		}

		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		
		$("#btnView").on("click", function(){
			valueAdd();
			getSummary();
			table1.ajax.reload();
			table2.ajax.reload();
			errorCheck();
		});
		
		$("#bulan, #tahun, #pembetulanKe").on("change", function(){
			valueAdd();
		});

		$('#form-wp').validator().on('submit', function(e) {
		  if (e.isDefaultPrevented()) {
		  }
		  else {
		  	 $.ajax({
				url		: baseURL + 'ppn_masa/save_rekonsiliasi',
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==true) {
						table1.ajax.reload(null, false);
						table2.ajax.reload(null, false);
						$("body").removeClass("loading");
						$("#list-data").slideDown(700);
						$("#tambah-data").slideUp(700);
						flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						getSummary();
						empty();
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error', result,'error' );
					}
				}
			});
		  }
		  e.preventDefault();
		});

		$("#btnDelete1, #btnDelete2").click(function(){
			  bootbox.confirm({
				title: "Hapus data <span class='label label-danger'>"+val_nama_pajak+"</span> ?",
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
							url		: baseURL + 'ppn_masa/delete_rekonsiliasi',
							type	: "POST",
							data	: $('#form-wp').serialize(),
							beforeSend	: function(){
								 $("body").addClass("loading");
								},
							success	: function(result){
								if (result==1) {
									$("body").removeClass("loading");
									table1.ajax.reload(null, false);
									table2.ajax.reload(null, false);
									getSummary();
									empty();
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

		function getFormCSV(){
			if (table1.data().any() || table2.data().any()){
				$("#d-FormCsv").slideDown(700);
			} else {
				$("#d-FormCsv").slideUp(700);
			}
		}

		$('.datepicker-autoclose').datepicker({
		    format: 'dd/mm/yyyy'
		});
	
		$("#btnExportCSV").on("click", function(){

			var urlnya = baseURL + 'ppn_masa/export_format_csv';
			var j      = $("#jenisPajak").val();
			var b      = $("#bulan").val();
			var t      = $("#tahun").val();
			var p      = $("#pembetulanKe").val();
			var expCat = $("#kategori_eksport").val();

			if(expCat != "dilaporkan"){
				if (table1.data().any() && table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=faktur_standar&dilaporkan='+expCat);
					setTimeout(function () {
						window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=dokumen_lain&dilaporkan='+expCat);
					}, 1000);
					window.focus();
				}
				else if( table1.data().any() && !table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=faktur_standar&dilaporkan='+expCat);
					window.focus();
				}
				else if( !table1.data().any() && table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=dokumen_lain&dilaporkan='+expCat);
					window.focus();
				}
				else{
					 flashnotif('Info','Data Kosong!','warning' );
					 return false;
				}
			}
			else{

				if (table1.data().any() && table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=faktur_standar');
					setTimeout(function () {
						window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=dokumen_lain');
					}, 1000);
					window.focus();
				}
				else if( table1.data().any() && !table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=faktur_standar');
					window.focus();
				}
				else if( !table1.data().any() && table2.data().any()){
					window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p+'&category=dokumen_lain');
					window.focus();
				}
				else{
					 flashnotif('Info','Data Kosong!','warning' );
					 return false;
				}
			}
		});
	
		$("#btnImportCSV").click(function(){
	        var form = $('#form-import')[0];
	        var data = new FormData(form);

	        $.ajax({
	            type: "POST",
	            enctype: 'multipart/form-data',
	            url: baseURL + 'ppn_masa/import_csv',
	            data: data,
				beforeSend	: function(){
					 $("body").addClass("loading");
				},
	            processData: false,
	            contentType: false,
				dataType: "json", 
	            cache: false,
	            success: function (result) {
            		$("#csv_remove").trigger('click');
	            	if(result.status == "true"){
						table1.ajax.reload(null, false);
						table2.ajax.reload(null, false);
						$("body").removeClass("loading");
						flashnotif('Sukses', 'Data Berhasil di Import!','success');
	                    $("#file_csv").val("");
	                    getSummary();
	                    empty();
	            	}
	            	else{
	                    $("body").removeClass("loading");
						flashnotif('Error', result.keterangan,'error');
	            	}
	            }
	        });
	    });

	
		$("#btnsaldoAwal").on("click", function(){
			var j    = $("#jenisPajak").val();
			var b    = $("#bulan").val();
			var t    = $("#tahun").val();
			var p    = $("#pembetulanKe").val();
			
			var sal              = $("#saldoAwal").val();
			var mtsd             = $("#mutasiDebet").val();
			var mtsk             = $('#mutasiKredit').val();
			var pmk              = $('#pmk').val();
			var ppn_beban        = $('#ppn_beban').val();
			var ppn_dipungut     = $('#ppn_dipungut').val();
			var ppn_tdk_dipungut = $('#ppn_tdk_dipungut').val();
		
			$.ajax({
					url		: baseURL + 'ppn_masa/save_saldo_awal',
					type	: "POST",
					data	: ({pajak:j, bulan:b, tahun:t, pembetulan:p, vsal:sal, vmtsd:mtsd, vmtsk:mtsk, pmk:pmk, ppn_beban:ppn_beban, ppn_dipungut:ppn_dipungut, ppn_tdk_dipungut:ppn_tdk_dipungut }),
					success	: function(result){
						if (result==1){
							 getSummary();
							 flashnotif('Sukses','Data Berhasil di Simpan!','success');
						} else {
							 flashnotif('Error','Data Gagal di Simpan!','error' );
						}
					}
				});
		});
		

		$("#btnSubmit").click(function(){

			if (table1.data().any() || table2.data().any()){
				 if(table1.data().any()){
					data  = table1.row(0).data();
				 }
				 else{
					data  = table2.row(0).data();
				 }

				pajak_header_id = data.pajak_header_id;
				nama_pajak      = $("#jenisPajak").val();

				$.ajax({
					url		: baseURL + 'ppn_masa/validation_rekonsiliasi/' + pajak_header_id +'/'+nama_pajak,
					type	: "GET",
					dataType: "json",
					success	: function(result){
						if (result.st==1){						
							flashnotifnohide("info",result.data,"warning");
							$("body").removeClass("loading");
							return false;
						} else {
							j 	= $("#jenisPajak").val();
							b	= $("#bulan").val();
							t	= $("#tahun").val();
							
							jnm	= $("#jenisPajak").find(":selected").attr("data-name");
							bnm	= $("#bulan").find(":selected").attr("data-name");
							pbt	= $("#pembetulanKe").find(":selected").attr("data-name");
							
							if (j != '' && b != '' && t != '') 
							{ 
								bootbox.confirm({
								title: "Submit data <span class='label label-danger'>PPN <?php echo ($nama_pajak == "PPN MASUKAN") ? "MASUKAN" : "KELUARAN" ?></span> Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> ?",
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
											url		: baseURL + 'ppn_masa/submit_rekonsiliasi',
											type	: "POST",
											// data	: $('#form-wp').serialize(),
											dataType: "json", 
											data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPpn : $('#jenisPajak').val(), _searchPembetulan : $('#pembetulanKe').val()}),
											beforeSend	: function(){
												 $("body").addClass("loading");
												 },
											success	: function(result){
												if (result==1) {
													$("body").removeClass("loading");
													table1.draw();
													table2.draw();
													getSummary();
													empty();
													flashnotif('Sukses','Data Berhasil di Submit!','success' );
												} else {
													$("body").removeClass("loading");
													table1.draw();
													table2.draw();
													flashnotif('Error','Data Gagal di Submit!','error' );
												}
											}
										});
									}
								  }
								});
							}
						}
					}
				});
			}

		});
		
	$("#btnAdd1, #btnAdd2, #btnEdit1, #btnEdit2").click(function (){
		btn = $(this).attr('id');

		if(btn == "btnAdd1" || btn == "btnAdd2"){
			empty();
			$("#isnewRecord").val('1');
			$("#fAddNamaPajak").val($("#jenisPajak").val());
			$("#fAddBulan").val($("#bulan").val());
			$("#fAddTahun").val($("#tahun").val());
			$("#fAddPembetulan").val($("#pembetulanKe").val());
			$("#is_creditable").val("1");
			if(btn == "btnAdd2"){
				val_dl_fs = "dokumen_lain"
			}
			else{
				val_dl_fs = "faktur_standar"
			}
			showHide();
		}
		else{
			$("#isnewRecord").val('0');
		}

		if(btn == "btnEdit1" || btn == "btnEdit2"){
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+val_nama_pajak+" Bulan "+val_masa_pajak+" Tahun "+val_tahun_pajak+"</span>");
			valueGrid();
		}
		else{
		}
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
	});

	$("#btnBack").on("click", function(){
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empty();
	});

	function showHide(){
		if(val_dl_fs == "dokumen_lain"){
			$(".dokumen_group").show();
			$(".faktur_group").hide();
			<?php if($nama_pajak == "PPN KELUARAN"){ ?>
			$(".faktur_group2").hide();
			<?php } ?>
			<?php if($nama_pajak == "PPN MASUKAN"){ ?>
			$(".faktur_group3").hide();
			<?php } ?>
		}
		else{
			$(".dokumen_group").hide();
			$(".faktur_group").show();
			<?php if($nama_pajak == "PPN KELUARAN"){ ?>
			$(".faktur_group2").show();
			<?php } ?>
			<?php if($nama_pajak == "PPN MASUKAN"){ ?>
			$(".faktur_group3").show();
			<?php } ?>
		}
	}

	tahun_z_percent   = 0;
	
	function valueAdd()
	{
		$("#fAddNamaPajak").val($("#jenisPajak").val());
		$("#fAddBulan").val($("#bulan").val());
		$("#fAddTahun").val($("#tahun").val());
		$("#fAddPembetulan").val($("#pembetulanKe").val());

		$("#uplPpn").val($("#jenisPajak").val());
		$("#uplBulan").val($("#bulan").val());
		$("#uplTahun").val($("#tahun").val());
		$("#uplPembetulan").val($("#pembetulanKe").val());
		
		tahun_z_percent   = $("#tahun_z_percent_lov").val();

		$(".tahun_z_percent").html(tahun_z_percent);
		$("#tahun_z_percent_v").val(tahun_z_percent);

	}

	function valueGrid()
	{
		$("#idPajakHeader").val(val_pajak_header_id);
		$("#idPajakLines").val(val_pajak_line_id);
		$("#idwp").val(val_vendor_id);
		$("#organization_id").val(val_organization_id);
		$("#vendor_site_id").val(val_vendor_site_id);

		$("#isnewRecord").val('0');

		$("#namawp").val(val_nama_wp);
		$("#npwp").val(val_npwp);
		$("#alamat").val(val_alamat);

		$("#invoice_number").val(val_invoice_number);
		$("#akun_pajak").val(val_akun_pajak);
		$("#mata_uang").val(val_mata_uang);
		$("#dpp").val(val_dpp);
		$("#jumlahpotong").val(val_jumlah_potong);
		$("#kd_jenis_transaksi").val(val_kd_jenis_transaksi);
		$("#fg_pengganti").val(val_fg_pengganti);
		$("#jenis_transaksi").val(val_jenis_transaksi);

		$("#nodokumenlain_ganti").val(val_no_dokumen_lain_ganti);
		$("#nodokumenlain").val(val_no_dokumen_lain);
		$("#tanggaldokumenlain").val(val_tanggal_dokumen_lain);
		$("#nofakturpajak").val(val_no_faktur_pajak);
		$("#tanggalfakturpajak").val(val_tanggal_faktur_pajak);

		$("#jumlah_ppnbm").val(val_jumlah_ppnbm);
		$("#jenis_dokumen").val(val_jenis_dokumen);
		$("#keterangan").val(val_keterangan);
		$("#is_creditable").val(val_is_creditable);
		$("#fapr").val(val_fapr);
		$("#tanggal_approval").val(val_tanggal_approval);
		$("#faktur_asal").val(val_faktur_asal);
		$("#tanggal_faktur_asal").val(val_tanggal_faktur_asal);
		$("#dpp_asal").val(val_dpp_asal);
		$("#ppn_asal").val(val_ppn_asal);
		$("#ntpn").val(val_ntpn);
		$("#keterangan_gl").val(val_keterangan_gl);
	}

	function actionCheck()
	{

		if($("#"+vcheckbox_id).prop('checked') == false){
			  var vischeck	= 0;
			  var st_check	= "Unchecklist";
		 } else {
			 var vischeck	= 1;
			 var st_check	= "Checklist"; 
		 }	
	
		 $.ajax({
			url		: baseURL + 'ppn_masa/check_rekonsiliasi',
			type	: "POST",
			data	: ({line_id : vlinse_id, ischeck : vischeck}),
			success	: function(result){
				if (result==1) {
					if(vcategoryTable == 'table1'){
						table1.column(1).data().each( function (value, index) {
							if (value==vlinse_id) {
								table1.cell( index, 3 ).data(vischeck);
							}
						});
						getSelectAll1();
					}else{
						table2.column(1).data().each( function (value, index) {
							 if (value==vlinse_id) {
								 table2.cell( index, 3 ).data(vischeck);
							 }
						});
						getSelectAll2();
					}
					getSummary();
					flashnotif('Sukses','Data Berhasil di '+st_check+'!','success' );
				} else {
					 flashnotif('Error','Data Gagal di '+st_check+'!','error' );
				}
			}
		});
	}

	function actionCheckPmk()
	{

		if($("#"+pmk_vcheckbox_id).prop('checked') == false){
			  var pmk_vischeck	= 0;
			  var pmk_st_check	= "Unchecklist";
		} else {
			 var pmk_vischeck	= 1;
			 var pmk_st_check	= "Checklist"; 
		}

		$.ajax({
			url		: baseURL + 'ppn_masa/check_rekonsiliasi/pmk',
			type	: "POST",
			data	: ({line_id : pmk_vlinse_id, ischeck : pmk_vischeck}),
			success	: function(result){
				if (result==1) {
					if(pmk_vcategoryTable == 'table1'){
						table1.column(1).data().each( function (value, index) {
							if (value==pmk_vlinse_id) {
								table1.cell( index, 3 ).data(pmk_vischeck);
							}
						});
						getSelectAll1();
					}else{
						table2.column(1).data().each( function (value, index) {
							 if (value==pmk_vlinse_id) {
								 table2.cell( index, 3 ).data(pmk_vischeck);
							 }
						});
						getSelectAll2();
					}
					getSummary();
					flashnotif('Sukses','Data Berhasil di '+pmk_st_check+'!','success' );
				} else {
					flashnotif('Error','Data Gagal di '+pmk_st_check+'!','error' );
				}
			}
		});
	}

	function getSelectAll1()
	{
		vis_checkAll=1;
		var a=0;
		table1.column(3).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll=0;
			} 
		});			
		
		if(vis_checkAll==1){
			$("#checkboxAll-1").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-1").prop('checked',false).removeAttr("disabled");
		}
		
		vid_lines1 = "";
		var i = 0;
		table1.column(1).data().each( function (value, index) {
			i++;
			if(i==1){
				vid_lines1 += value;
			} else {
				vid_lines1 +=" ,"+value;
			}
		});
		
		if(a==0){
			$("#checkboxAll-1").prop('checked',false).attr("disabled",true);
		}
	}

	function getSelectAll2()
	{
		vis_checkAll=1;
		var a=0;
		table2.column(3).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll=0;
			} 
		});			
		
		if(vis_checkAll==1){
			$("#checkboxAll-2").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-2").prop('checked',false).removeAttr("disabled");
		}
		
		vid_lines2 = "";
		var i = 0;
		table2.column(1).data().each( function (value, index) {
			i++;
			if(i==1){
				vid_lines2 += value;
			} else {
				vid_lines2 +=" ,"+value;
			}
		});
		
		if(a==0){
			$("#checkboxAll-2").prop('checked',false).attr("disabled",true);
		}
	}
	
	$("#checkboxAll-1").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }
		 
		$.ajax({
			url		: baseURL + 'ppn_masa/get_selectAll',
			type	: "POST",
			data	: ({id_lines:vid_lines1,vcheck:vischeckAll}),	
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".checklist-1").prop('checked',true);
					} else {
						$(".checklist-1").prop('checked',false);
					}
					table1.column(1).data().each( function (value, index) {						 
						table1.cell( index, 3 ).data(vischeckAll);	
					} );
					getSummary();
					orderBy("orderby1");
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
			}
		});
	});

	$("#checkboxAll-2").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }

		$.ajax({
			url		: baseURL + 'ppn_masa/get_selectAll',
			type	: "POST",
			data	: ({id_lines:vid_lines2,vcheck:vischeckAll}),	
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".checklist-2").prop('checked',true);
					} else {
						$(".checklist-2").prop('checked',false);
					}
					table2.column(1).data().each( function (value, index) {						 
						table2.cell( index, 3 ).data(vischeckAll);	
					} );
					getSummary();
					orderBy("orderby2");
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
			}
		});
	});

	function action_dlfs()
	{
		var j 	= $("#jenisPajak").val();

		 $.ajax({
			url		: baseURL + 'ppn_masa/check_dlfs',
			type	: "POST",
			data	: ({pajak: j, jenis_dokumen : dlfs_val, line_id : dlfs_data}),
			success	: function(result){
				if (result==1) {
					getSummary();
					table1.ajax.reload(null, false);
					table2.ajax.reload(null, false);
					flashnotif('Sukses','Data Berhasil di update!','success' );
				} else {
					$("#"+dlfs_id).prop('checked', false);
					flashnotif('Error','Data Gagal di update!','error' );
				}
			}
		});
	}
	
	function empty()
	{
		val_pajak_line_id          = "",
		val_pajak_header_id        = "",
		val_vendor_id              = "",
		val_organization_id        = "",
		val_vendor_site_id         = "",
		val_akun_pajak             = "",
		
		val_nama_pajak             = "",
		val_masa_pajak             = "",
		val_tahun_pajak            = "",
		
		val_jenis_transaksi        = "",
		val_jenis_dokumen          = "",
		val_kd_jenis_transaksi     = "",
		val_fg_pengganti           = "",
		
		val_no_dokumen_lain_ganti  = "",
		val_no_dokumen_lain        = "",
		val_tanggal_dokumen_lain   = "",
		val_no_faktur_pajak        = "",
		val_tanggal_faktur_pajak   = "",
		
		val_npwp                   = "",
		val_nama_wp                = "",
		val_alamat                 = "",
		val_invoice_number         = "",
		val_akun_pajak             = "",
		val_mata_uang              = "",
		val_dpp                    = "",
		val_jumlah_potong          = "",
		val_jumlah_ppnbm           = "",
		
		val_keterangan             = "",
		val_is_creditable          = "",
		val_fapr                   = "",
		val_tanggal_approval       = "",
		
		val_id_keterangan_tambahan = "",
		val_fg_uang_muka           = "",
		val_uang_muka_dpp          = "",
		val_uang_muka_ppn          = "",
		val_uang_muka_ppnbm        = "",
		val_referensi              = "",
		val_dl_fs                  = "";
		val_faktur_asal            = "";
		
		$("#idPajakHeader").val("");
		$("#idPajakLines").val("");
		$("#idwp").val("");
		$("#organization_id").val("");
		$("#vendor_site_id").val("");
		$("#namawp").val("");
		$("#npwp").val("");
		$("#alamat").val("");
		$("#akun_pajak").val("");
		$("#invoice_number").val("");
		$("#mata_uang").val("");
		$("#dpp").val("");
		$("#jumlahpotong").val("");
		$("#kd_jenis_transaksi").val("");
		$("#fg_pengganti").val("");
		$("#jenis_transaksi").val("");
		$("#nodokumenlain_ganti").val("");
		$("#nodokumenlain").val("");
		$("#tanggaldokumenlain").val("");
		$("#nofakturpajak").val("");
		$("#tanggalfakturpajak").val("");
		$("#jumlah_ppnbm").val("");
		$("#jenis_dokumen").val("");
		$("#keterangan").val("");
		$("#is_creditable").val("");
		$("#fapr").val("");
		$("#tanggal_approval").val("");
		$("#faktur_asal").val("");

		table1.$('tr.selected').removeClass('selected');
		table2.$('tr.selected').removeClass('selected');
		$('.DTFC_Cloned tr.selected').removeClass('selected');
		$("#btnEdit1").attr("disabled",true);
		$("#btnDelete1").attr("disabled",true);
		$("#btnEdit2").attr("disabled",true);
		$("#btnDelete2").attr("disabled",true);
		
		var j = $("#jenisPajak").find(":selected").attr("data-name");
		var b = $("#bulan").find(":selected").attr("data-name");
		var t = $("#tahun").val();
	}

//Awal modal get nama wp
$("#getnamawp").on("click", function(){
		val_vendor_id		        = "";
		vnama               = "";				
		valamat             = "";
		vnpwp               = "";
		val_organization_id = "";
		val_vendor_site_id  = "";
		$("#btnChoice").attr("disabled",true);
		jenisPajakNya = $("#jenisPajak").val();
		
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-namawp' ) ) {
			$('#tabledata-namawp').DataTable({
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: baseURL + 'ppn_masa/load_master_wp/' + jenisPajakNya,
									 "type" 		: "POST"
								  },
				 "language"		: {
						"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
						"infoEmpty"		: "Data Kosong",
						"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
						"search"		: "_INPUT_"
					},
				   "columns": [
						{ "data": "no", "class":"text-center" },
						{ "data": "vendor_id", "class":"text-left", "width" : "60px" },
						{ "data": "organization_id" },
						{ "data": "vendor_site_id" },
						{ "data": "nama_wp" },
						{ "data": "alamat_wp" },
						{ "data": "npwp" }
					],
				"columnDefs": [ 
					 {
						"targets": [ 1,2,3 ],
						"visible": false
					} 
				],
				 "select"			: true,
				 "scrollY"			: 360, 
				 "scrollCollapse"	: true, 
				 "scrollX"			: true,
				 "ordering"			: false
			});	
			
			table_wp = $('#tabledata-namawp').DataTable();
			
			$("#modal-namawp input[type=search]").addClear();
			$('#modal-namawp .dataTables_filter input[type="search"]').attr('placeholder','Cari Nama/Alamat/NPWP...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
			
			$("#tabledata-namawp_filter .add-clear-x").on('click',function(){
				table_wp.search('').column().search('').draw();
			});

			$('#tabledata-namawp tbody').on( 'click', 'tr', function () {
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
					$("#btnChoice").attr("disabled",true);
					val_vendor_id       = "";
					val_organization_id = "";
					val_vendor_site_id  = "";
					val_nama_wp         = "";
					val_npwp            = "";
					val_alamat          = "";
				} else {
					table_wp.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d               = table_wp.row( this ).data();
					val_vendor_id       = d.vendor_id;
					val_organization_id = d.organization_id;
					val_vendor_site_id  = d.vendor_site_id;
					val_nama_wp         = d.nama_wp;
					val_npwp            = d.npwp;
					val_alamat          = d.alamat_wp;
					$("#btnChoice").removeAttr('disabled'); 
				}					
			} ).on("dblclick", "tr", function () {
				table_wp.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d               = table_wp.row( this ).data();
				val_vendor_id       = d.vendor_id;
				val_organization_id = d.organization_id;
				val_vendor_site_id  = d.vendor_site_id;
				val_nama_wp         = d.nama_wp;
				val_npwp            = d.npwp;
				val_alamat          = d.alamat_wp;
				valueGridwp();		
				$("#btnChoice").removeAttr('disabled');
			} );
		} else {
			table_wp.$('tr.selected').removeClass('selected');
		}
		
	});

	$("#btnChoice").on("click",valueGridwp);
	$("#btnCancel").on("click",batal);	



/*	function valueGridwp()
	{
		$("#idwp").val(val_vendor_id);
		$("#namawp").val(val_nama_wp);
		$("#npwp").val(val_npwp);
		$("#alamat").val(val_alamat);
		$("#modal-namawp").modal("hide");
	}*/

	function valueGridwp()
	{
		$("#idwp").val(val_vendor_id);
		$("#organization_id").val(val_organization_id);
		$("#vendor_site_id").val(val_vendor_site_id);
		$("#namawp").val(val_nama_wp);
		$("#npwp").val(val_npwp);
		$("#alamat").val(val_alamat);		
		$("#modal-namawp").modal("hide");		
	}

	function batal()
	{
		val_vendor_id = "";
		val_nama_wp   = "";
		val_alamat    = "";
		val_npwp      = "";
	}

 });
</script>