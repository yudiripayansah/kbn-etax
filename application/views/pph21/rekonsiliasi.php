<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
	
 <div id="list-data">
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
				<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button"><i class="fa fa-bars"></i><span>View</span></button>
			</div>
		</div>
	</div>
</div>	
	
<div class="white-box boxshadow animated slideInDown">
	<div class="row">
		<div class="col-lg-3 col-md-5 col-sm-7 col-xs-8">
			<div class="form-group">
				<label>Jenis Pajak</label>
				<select class="form-control" id="jenisPajak" name="jenisPajak">
					<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN">PPh Pasal 21 Bulanan</option>
					<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN FINAL">PPh Pasal 21 Bulanan Final</option>
					<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN NON FINAL">PPh Pasal 21 Bulanan Non Final</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-5 col-sm-7 col-xs-8">
			<div class="form-group">
				<label>Export CSV Format</label>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button id="btnEksportCSV" class="btn btn-success btn-rounded btn-block" type="button"><i class="fa fa-download fa-fw"></i><span>CSV Format</span></button>
				</div>
			</div>
		</div>
		<div class="col-lg-7 col-md-8 col-sm-10 col-xs-12">
			<form role="form" id="form-import" autocomplete="off">
				<div class="col-lg-9">
					<div class="form-group">
						<label class="form-control-label">File CSV</label>
						<div class="fileinput fileinput-new input-group" data-provides="fileinput">
							<div class="form-control" data-trigger="fileinput">
								<i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span>
							</div>
							<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
							<input type="file" id="file_csv" name="file_csv"></span><a id="aRemoveCSV" href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						</div>
						<input type="hidden" class="form-control" id="uplPph" name="uplPph">
						<input type="hidden" class="form-control" id="import_bulan_pajak" name="import_bulan_pajak">
						<input type="hidden" class="form-control" id="import_tahun_pajak" name="import_tahun_pajak">
						<input type="hidden" class="form-control" id="import_tipe" name="import_tipe"></div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<label>&nbsp;</label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button"><i class="fa fa-sign-in"></i><span>Import CSV</span></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-lg-12">
		<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Rekonsiliasi Bulanan</a>
					</div>
					<div class="col-lg-6">
						<div class="navbar-right">
							<button type="button" id="btnEdit-bulanan" class="btn btn-rounded btn-default custom-input-width" disabled><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnDelete-bulanan" class="btn btn-rounded btn-default custom-input-width " disabled><i class="fa fa-trash-o"></i> DELETE</button>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse-data" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="dBulanan" class="table-responsive">
						<table width="100%" class="display cell-border stripe hover small" id="tabledata">
						<thead>
						<tr>
							<th>
								<div class="checkbox checkbox-inverse">
									<input id="checkboxAll" type="checkbox">
									<label for="checkboxAll"></label>
								</div>
							</th>
							<th>NO</th>
							<th>PAJAK LINE ID</th>
							<th>VENDOR ID</th>
							<th>PAJAK HEADER ID</th>
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
							<th>PEMBETULAN</th>
							<th>AKUN BEBAN</th>
							<th>PEMBETULAN KE</th>
							<th>NPWP PEMOTONG</th>
							<th>NAMA PEMOTONG</th>
							<th>WP LUAR NEGERI</th>
							<th>KODE NEGARA</th>
							<th>IS CHEKLIST</th>
						</tr>
						</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			
	
<!--=======================BULANAN FINAL=================================-->			 

	<div class="row">
	<div class="col-lg-12">
		<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data-final">List Data Rekonsiliasi Bulanan Final</a>
					</div>
					<div class="col-lg-6">
						<div class="navbar-right">
							<button type="button" id="btnEdit-final" class="btn btn-rounded btn-default custom-input-width" disabled><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnDelete-final" class="btn btn-rounded btn-default custom-input-width " disabled><i class="fa fa-trash-o"></i> DELETE</button>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse-data-final" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="dFinal" class="table-responsive">
						<table width="100%" class="display cell-border stripe hover small" id="tabledata_bulanan_final">
						<thead>
						<tr>
							<th>
								<div class="checkbox checkbox-inverse">
									<input id="checkboxAll-final" type="checkbox">
									<label for="checkboxAll-final"></label>
								</div>
							</th>
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
							<th>PEMBETULAN</th>
							<th>PEMBETULAN KE</th>
							<th>NPWP PEMOTONG</th>
							<th>NAMA PEMOTONG</th>
							<th>WP LUAR NEGERI</th>
							<th>KODE NEGARA</th>
							<th>IS CHEKLIST</th>
						</tr>
						</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--======================================================================-->			 
	<div class="row">
	<div class="col-lg-12">
		<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6">
						<a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data-nonfinal">List Data Rekonsiliasi Bulanan Non Final</a>
					</div>
					<div class="col-lg-6">
						<div class="navbar-right">
							<button type="button" id="btnEdit-nonfinal" class="btn btn-rounded btn-default custom-input-width" disabled><i class="fa fa-pencil"></i> EDIT</button>
							<button type="button" id="btnDelete-nonfinal" class="btn btn-rounded btn-default custom-input-width " disabled><i class="fa fa-trash-o"></i> DELETE</button>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse-data-nonfinal" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="dNonFinal" class="table-responsive">
						<table width="100%" class="display cell-border stripe hover small" id="tabledata_bulanan_non_final">
						<thead>
						<tr>
							<th>
								<div class="checkbox checkbox-inverse">
									<input id="checkboxAll-nonfinal" type="checkbox">
									<label for="checkboxAll-nonfinal"></label>
								</div>
							</th>
							<th>NO</th>
							<th>PAJAK LINE ID</th>
							<th>VENDOR ID</th>
							<th>PAJAK HEADER ID</th>
							<th>MASA PAJAK</th>
							<th>TAHUN PAJAK</th>
							<th>MASA PAJAK</th>
							<th>ORGANIZATION ID</th>
							<th>NAMA WP</th>
							<th>ALAMAT</th>
							<th>NPWP</th>
							<th>JENIS PAJAK</th>
							<th>AKUN PAJAK</th>
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
							<th>PEMBETULAN</th>
							<th>PEMBETULAN KE</th>
							<th>NPWP PEMOTONG</th>
							<th>NAMA PEMOTONG</th>
							<th>WP LUAR NEGERI</th>
							<th>KODE NEGARA</th>
							<th>IS CHEKLIST</th>
						</tr>
						</thead>
						</table>
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
					 <div class="row">
						</br>
						<div class="col-lg-12 text-center">    
							<button id="btnsaldoAwal" class="btn btn-info btn-rounded custom-input-width" type="button" ><i class="fa fa fa-save"></i> <span>Save</span></button>
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
				<div class="panel-footer">
					<div class="row">							
						<div class="col-lg-12 text-center"> 											
							<button id="btnSubmit" class="btn btn-danger btn-rounded custom-input-width  " type="button"><i class="fa fa-share-square-o"></i><span>SUBMIT</span></button>
						</div>									
					</div>						
				</div>
			 
			 
			</div>			
		</div>
	</div>
	
	
	
</div>

	
	


<!-------------------------------------->		
<div id="tambah-data">
	<form role="form" id="form-wp">
		<div class="white-box boxshadow">
			<div class="row">
				<div class="col-lg-12 align-center">
					<h2 id="capAdd" class="text-center">Tambah Data</h2>
				</div>
			</div>
			<div class="row">
				<hr></div>
			<div class="row">
				<div class="col-lg-6 ">
					<div class="form-group">
						<label>Nama WP</label>
						<input type="hidden" class="form-control" id="idPajakHeader" name="idPajakHeader">
						<input type="hidden" class="form-control" id="idPajakLines" name="idPajakLines">
						<input type="hidden" class="form-control" id="organization_id" name="organization_id">
						<input type="hidden" class="form-control" id="vendor_site_id" name="vendor_site_id">
						<input type="hidden" class="form-control" id="idwp" name="idwp">
						<input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
						<input type="hidden" class="form-control" id="fAkun" name="fAkun">
						<input type="hidden" class="form-control" id="fNamaAkun" name="fNamaAkun">
						<input type="hidden" class="form-control" id="fBulan" name="fBulan">
						<input type="hidden" class="form-control" id="fTahun" name="fTahun">
						<input type="hidden" class="form-control" id="fAddAkun" name="fAddAkun">
						<input type="hidden" class="form-control" id="fAddNamaAkun" name="fAddNamaAkun">
						<input type="hidden" class="form-control" id="fAddBulan" name="fAddBulan">
						<input type="hidden" class="form-control" id="fAddTahun" name="fAddTahun">
						<input type="hidden" class="form-control" id="fAddPembetulan" name="fAddPembetulan">
						<div class="form-group">
						<!--<div class="input-group"> -->
							<input class="form-control" id="namawp" name="namawp" placeholder="Nama WP" type="text" disabled>
							<!--<span class="input-group-btn">
							<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp"><i class="fa fa-search"></i></button>
							</span>-->
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>NIK</label>
						<input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>NPWP</label>
						<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP" ></div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Kode Negara</label>
						<input class="form-control" id="kodenegara" name="kodenegara" placeholder="Kode Negara" type="text" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control" rows="5" id="alamat" name="alamat" placeholder="Alamat..."></textarea>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>WP Luar Negeri</label>
						<input type="text" class="form-control" id="wpluar" name="wpluar" placeholder="WP Luar Negeri" disabled></div>
					<div class="form-group">
						<label>DPP Base Amount</label>
						<input type="text" class="form-control" id="dppbaseamount" name="dppbaseamount" placeholder="DPP Base Amount" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>DPP</label>
						<input class="form-control" id="dpp" name="dpp" placeholder="DPP" type="text" disabled></div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Tanpa NPWP</label>
						<input type="text" class="form-control" id="tanpanpwp" name="tanpanpwp" placeholder="Tanpa NPWP" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Tarif</label>
						<input class="form-control" id="tarif" name="tarif" placeholder="Tarif" type="text" maxlength="3" disabled></div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>New DPP</label>
						<input type="text" class="form-control" id="newdpp" name="newdpp" placeholder="New DPP" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>New Tarif</label>
						<input type="text" class="form-control" id="newtarif" name="newtarif" placeholder="New Tarif" maxlength="3" disabled></div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>New Jumlah Potong</label>
						<input type="text" class="form-control" id="newjumlahpotong" name="newjumlahpotong" placeholder="New Jumlah Potong" disabled></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
		
</div>

<!-------------------------------------->
							
<script>
    $(document).ready(function() {
		var table				="", 
			table_wp			="",
			table_kp			="", 
			table_newkodepajak	="", 
			vid 				="",
			vnama 				="", 
			vnpwp 				="", 
			valamat				="", 
			vkodepajak			="",
			vdpp				="",
			vtarif				="",
			vjumlahpotong		="";
			
		var vinvoicenum			="", 
			vnofakturpajak 		="",
			vtanggalfakturpajak ="", 
			vnewkodepajak 		="", 
			vnewtarif			="", 
			vnewdpp				="",
			vnewjumlahpotong    ="", 
			vidpajaklines		="", 
			vidpajakheader		="", 
			vnobupot			="", 
			vglaccount			="",
			vnamapajak			="", 
			vakunpajak			="", 
			vbulanpajak			="", 
			vtahunpajak			="",
			vmasapajak			="",
			vtype				="";
			
		var vlinse_id 			="",
			vcheckbox_id 		="";
			
		var vnik 				="", 
			vkodenegara			="",
			vwpluarnegeri		="", 
			vdppbaseamount		="", 
			vtanpanpwp			=""; //sini
			
		var vvendor_site_id 	="",
			vtanggalgl 			="",
			vmatauang 			="";
			
		var vid_lines 			="", 
			vid_lines1 			="", 
			vid_lines2 			="", 
			vis_checkAll		=1, 
			vis_checkAll_final	=1,
			vis_checkAll_nonfinal	=1; 
			
			
			
		$("#dpp, #jumlahpotong,#newdpp, #newjumlahpotong, #saldoAwal").number(true,2);
		$("#tarif, #newtarif").number(true);
		$("#tambah-data").hide();
		$("#d-FormCsv").hide();		
		$('#modal-namawp, #modal-kodepajak, #modal-newkodepajak').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});					
		valueAdd();
		getStart();
		getSummary();
		//getSummary(1);
		//getSummary(2);
		//getSummary(3);
		 Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_rekonsiliasi_bulanan');?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "bulan_pajak" },
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
					{ "data": "pembetulan" },
					{ "data": "akun_pajak" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" },
					{ "data": "is_cheklist", "class":"text-right" }
				],
			 "columnDefs": [ 
				 {
					"targets": [  2,3,4,5,6,7,8,12,13,14,15,16,17,18,23,24,25,26,29,34],
					"visible": false
				} 
			],	 		
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
		table = $('#tabledata').DataTable();
		$("#dBulanan input[type=search]").addClear();		
		$('#dBulanan .dataTables_filter input[type="search"]').attr('placeholder','Search Nama WP/DPP/Jumlah Potong ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		 table.on( 'draw', function () {
			$(".bulanan").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
				 actionCheck(1);
			 });				
			btnDisabled();
			getSelectAll();
			//getFormCSV();
		} );		 
//===================================BULANAN FINAL ================================//	
		   $('#tabledata_bulanan_final').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_rekonsiliasi_bulanan_final');?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
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
					{ "data": "tahun_pajak" },
					{ "data": "bulan_pajak" },
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
					{ "data": "pembetulan" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" },
					{ "data": "is_cheklist", "class":"text-right" }
				],
			 "columnDefs": [ 
				 {
					"targets": [  2,3,4,5,6,7,8,9,13,14,15,16,19,24,25,26,27,29,34],
					"visible": false
				} 
			],	 		
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});		
			var table_final = "";
			table_final = $('#tabledata_bulanan_final').DataTable();		
			$("#dFinal input[type=search]").addClear();		
			$('#dFinal .dataTables_filter input[type="search"]').attr('placeholder','Search Nama WP/DPP/Jumlah Potong ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
			$("#tabledata_bulanan_final_filter .add-clear-x").on('click',function(){
				table_final.search('').column().search('').draw();			
			});
			table_final.on( 'draw', function () {
			$(".final").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
				 actionCheck(2);
			 });					
			btnDisabled();
			getSelectAll1();
			//getFormCSV();
		} );		 
//===============================BULANAN NON FINAL ===================================//
		   $('#tabledata_bulanan_non_final').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
							"url"  		: "<?php echo site_url('pph21/load_rekonsiliasi_bulanan_non_final');?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "organization_id" },
					{ "data": "nama_wp" },
					{ "data": "alamat_wp" },
					{ "data": "npwp" },
					{ "data": "nama_pajak" },
					{ "data": "akun_pajak" },
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
					{ "data": "pembetulan" },
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" },
					{ "data": "is_cheklist", "class":"text-right" }
				],
			 "columnDefs": [ 
				 {
					"targets": [ 2,3,4,5,6,7,8,15,16,19,24,26,27,29,34],
					"visible": false
				} 
			],	 		
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
			var table_nonfinal = "";
			table_nonfinal = $('#tabledata_bulanan_non_final').DataTable();		
			$("#dNonFinal input[type=search]").addClear();		
			$('#dNonFinal .dataTables_filter input[type="search"]').attr('placeholder','Search Nama WP/DPP/Jumlah Potong ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
			$("#tabledata_bulanan_non_final_filter .add-clear-x").on('click',function(){
				table_nonfinal.search('').column().search('').draw();			
			});
			table_nonfinal.on( 'draw', function () {
			$(".nonfinal").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
				actionCheck(3);				 
			 });			 
			btnDisabled();
			getSelectAll2();
			//getFormCSV();
		} );		 
//======================================================================================//
		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empety();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table.row( this ).data();
				vidpajakheader      = d.pajak_header_id;
				vidpajaklines       = d.pajak_line_id;
				vid		            = d.vendor_id;				
				vnama	            = d.nama_wp;				
				vnpwp	            = d.npwp;
				valamat	            = d.alamat_wp;
				vkodepajak		    = d.kode_pajak;
				vdpp	            = d.dpp;				
				vtarif	            = d.tarif;
				vjumlahpotong	    = d.jumlah_potong;
				vinvoicenum		    = d.invoice_num;				
				vnofakturpajak 	    = d.no_faktur_pajak;
				vtanggalfakturpajak = d.tanggal_faktur_pajak;
				vnewkodepajak 	    = d.new_kode_pajak;
				vnewtarif	        = d.new_tarif;
				vnewdpp             = d.new_dpp;
				vnewjumlahpotong    = d.new_jumlah_potong;
				vnobupot    		= d.no_bukti_potong;
				vglaccount    		= d.gl_account;
				vakunpajak    		= d.akun_pajak;
				vnamapajak    		= d.nama_pajak;
				vbulanpajak    		= d.bulan_pajak;
				vtahunpajak    		= d.tahun_pajak;
				vmasapajak    		= d.masa_pajak;
				valueGrid();					
				$("#btnEdit-bulanan, #btnDelete-bulanan").removeAttr('disabled');
				$("#btnEdit-final, #btnDelete-final,#btnEdit-nonfinal, #btnDelete-nonfinal").attr( "disabled", true );
				$("#isNewRecord").val("0");
			}			
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			table_final.$('tr.selected').removeClass('selected');
			table_nonfinal.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table.row( this ).data();
			vidpajakheader      = d.pajak_header_id;
			vidpajaklines       = d.pajak_line_id;
			vid		            = d.vendor_id;	
			vnama	            = d.nama_wp;				
			vnpwp	            = d.npwp;
			valamat	            = d.alamat_wp;
			vkodepajak		    = d.kode_pajak;
			vdpp	            = d.dpp;				
			vtarif	            = d.tarif;
			vjumlahpotong	    = d.jumlah_potong;
			vinvoicenum		    = d.invoice_num;
			vnofakturpajak 	    = d.no_faktur_pajak;
			vtanggalfakturpajak = d.tanggal_faktur_pajak;
			vnewkodepajak 	    = d.new_kode_pajak;
			vnewtarif	        = d.new_tarif;
			vnewdpp             = d.new_dpp;
			vnewjumlahpotong    = d.new_jumlah_potong;
			vnobupot    		= d.no_bukti_potong;
			vglaccount    		= d.gl_account;
			vakunpajak    		= d.akun_pajak;
			vnamapajak    		= d.nama_pajak;
			vbulanpajak    		= d.bulan_pajak;
			vtahunpajak    		= d.tahun_pajak;
			vmasapajak    		= d.masa_pajak;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit-bulanan, #btnDelete-bulanan").removeAttr('disabled');
			$("#btnEdit-final, #btnDelete-final,#btnEdit-nonfinal, #btnDelete-nonfinal").attr( "disabled", true );
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			//$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);			
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype ="BULANAN";
			isInput();
		} );	
		$('#tabledata_bulanan_final tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empety();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table_final.row( this ).data();
				vidpajakheader      = d.pajak_header_id;
				vidpajaklines       = d.pajak_line_id;
				vid		            = d.vendor_id;				
				vnama	            = d.nama_wp;				
				vnpwp	            = d.npwp;
				valamat	            = d.alamat_wp;
				vkodepajak		    = d.kode_pajak;
				vdpp	            = d.dpp;				
				vtarif	            = d.tarif;
				vjumlahpotong	    = d.jumlah_potong;
				vinvoicenum		    = d.invoice_num;				
				vnofakturpajak 	    = d.no_faktur_pajak;
				vtanggalfakturpajak = d.tanggal_faktur_pajak;
				vnewkodepajak 	    = d.new_kode_pajak;
				vnewtarif	        = d.new_tarif;
				vnewdpp             = d.new_dpp;
				vnewjumlahpotong    = d.new_jumlah_potong;
				vnobupot    		= d.no_bukti_potong;
				vglaccount    		= d.gl_account;
				vakunpajak    		= d.akun_pajak;
				vnamapajak    		= d.nama_pajak;
				vbulanpajak    		= d.bulan_pajak;
				vtahunpajak    		= d.tahun_pajak;
				vmasapajak    		= d.masa_pajak;
				valueGrid();				
				$("#btnEdit-final, #btnDelete-final").removeAttr('disabled');
				$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-nonfinal, #btnDelete-nonfinal").attr( "disabled", true );
				$("#isNewRecord").val("0");				
			}			
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			table_final.$('tr.selected').removeClass('selected');
			table_nonfinal.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table_final.row( this ).data();
			vidpajakheader      = d.pajak_header_id;
			vidpajaklines       = d.pajak_line_id;
			vid		            = d.vendor_id;	
			vnama	            = d.nama_wp;				
			vnpwp	            = d.npwp;
			valamat	            = d.alamat_wp;
			vkodepajak		    = d.kode_pajak;
			vdpp	            = d.dpp;				
			vtarif	            = d.tarif;
			vjumlahpotong	    = d.jumlah_potong;
			vinvoicenum		    = d.invoice_num;
			vnofakturpajak 	    = d.no_faktur_pajak;
			vtanggalfakturpajak = d.tanggal_faktur_pajak;
			vnewkodepajak 	    = d.new_kode_pajak;
			vnewtarif	        = d.new_tarif;
			vnewdpp             = d.new_dpp;
			vnewjumlahpotong    = d.new_jumlah_potong;
			vnobupot    		= d.no_bukti_potong;
			vglaccount    		= d.gl_account;
			vakunpajak    		= d.akun_pajak;
			vnamapajak    		= d.nama_pajak;
			vbulanpajak    		= d.bulan_pajak;
			vtahunpajak    		= d.tahun_pajak;
			vmasapajak    		= d.masa_pajak;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit-final, #btnDelete-final").removeAttr('disabled');
			$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-nonfinal, #btnDelete-nonfinal").attr( "disabled", true );
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
			//$( ".datepicker-autoclose" ).attr( "disabled", true );
			//$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);			
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Final Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype ="BULANAN FINAL";
			isInput();
		} );	
		$('#tabledata_bulanan_non_final tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empety();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table_nonfinal.row( this ).data();
				vidpajakheader      = d.pajak_header_id;
				vidpajaklines       = d.pajak_line_id;
				vid		            = d.vendor_id;				
				vnama	            = d.nama_wp;				
				vnpwp	            = d.npwp;
				valamat	            = d.alamat_wp;
				vkodepajak		    = d.kode_pajak;
				vdpp	            = d.dpp;				
				vtarif	            = d.tarif;
				vjumlahpotong	    = d.jumlah_potong;
				vinvoicenum		    = d.invoice_num;				
				vnofakturpajak 	    = d.no_faktur_pajak;
				vtanggalfakturpajak = d.tanggal_faktur_pajak;
				vnewkodepajak 	    = d.new_kode_pajak;
				vnewtarif	        = d.new_tarif;
				vnewdpp             = d.new_dpp;
				vnewjumlahpotong    = d.new_jumlah_potong;
				vnobupot    		= d.no_bukti_potong;
				vglaccount    		= d.gl_account;
				vakunpajak    		= d.akun_pajak;
				vnamapajak    		= d.nama_pajak;
				vbulanpajak    		= d.bulan_pajak;
				vtahunpajak    		= d.tahun_pajak;
				vmasapajak    		= d.masa_pajak;
				valueGrid();				
				$("#btnEdit-nonfinal, #btnDelete-nonfinal").removeAttr('disabled');
				$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-final, #btnDelete-final").attr( "disabled", true );
				$("#isNewRecord").val("0");
			}			
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			table_final.$('tr.selected').removeClass('selected');
			table_nonfinal.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table_nonfinal.row( this ).data();
			vidpajakheader      = d.pajak_header_id;
			vidpajaklines       = d.pajak_line_id;
			vid		            = d.vendor_id;	
			vnama	            = d.nama_wp;				
			vnpwp	            = d.npwp;
			valamat	            = d.alamat_wp;
			vkodepajak		    = d.kode_pajak;
			vdpp	            = d.dpp;				
			vtarif	            = d.tarif;
			vjumlahpotong	    = d.jumlah_potong;
			vinvoicenum		    = d.invoice_num;
			vnofakturpajak 	    = d.no_faktur_pajak;
			vtanggalfakturpajak = d.tanggal_faktur_pajak;
			vnewkodepajak 	    = d.new_kode_pajak;
			vnewtarif	        = d.new_tarif;
			vnewdpp             = d.new_dpp;
			vnewjumlahpotong    = d.new_jumlah_potong;
			vnobupot    		= d.no_bukti_potong;
			vglaccount    		= d.gl_account;
			vakunpajak    		= d.akun_pajak;
			vnamapajak    		= d.nama_pajak;
			vbulanpajak    		= d.bulan_pajak;
			vtahunpajak    		= d.tahun_pajak;
			vmasapajak    		= d.masa_pajak;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit-nonfinal, #btnDelete-nonfinal").removeAttr('disabled');
			$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-final, #btnDelete-final").attr( "disabled", true );
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			//$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);			
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Non Final Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype ="BULANAN NON FINAL";
			isInput();
		} );	
		$(".titlelist").on("click", function(){
			btnDisabled();
			empety();
			table.$('tr.selected').removeClass('selected');
			table_final.$('tr.selected').removeClass('selected');
			table_nonfinal.$('tr.selected').removeClass('selected');
		});
		function btnDisabled()
		{
			$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-final, #btnDelete-final,#btnEdit-nonfinal, #btnDelete-nonfinal").attr( "disabled", true );
		}
		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		$("#btnView").on("click", function(){			
			valueAdd();
			getStart();
			getSummary();
			// getSummary(1);
			//getSummary(2);
			// getSummary(3);
			table.ajax.reload();			
			table_final.ajax.reload();			
			table_nonfinal.ajax.reload();
						
		});
		$("#bulan, #tahun, #jenisPajak").on("change", function(){
			valueAdd();			
		});
		$("#btnSave").click(function(){				
			$.ajax({
				url		: "<?php echo site_url('pph21/save_rekonsiliasi');?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==1) {
						 table.draw();
						 table_final.draw();
						 table_nonfinal.draw();
						 $("body").removeClass("loading");
						 $("#list-data").slideDown(700);
						 $("#tambah-data").slideUp(700);
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 empety();
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}
				}
			});	
		});
		
		$("#btnSubmit").click(function(){	
			var j 	= $("#jenisPajak").val();			
			var b	= $("#bulan").val();			
			var t	= $("#tahun").val();
			var p	= $("#pembetulanKe").val();
			var tipe = $('#jenisPajak').find(':selected').attr('data-type');
			var jnm	= $("#jenisPajak").find(":selected").attr("data-name");			
			var bnm	= $("#bulan").find(":selected").attr("data-name");	
			if (j != '' && b != '' && t != '') 
			{
				bootbox.confirm({
				title: "Submit data <span class='label label-danger'>"+jnm+"</span> Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> Pembetulan ke <span class='label label-danger'>"+p+"</span> ?",
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
						cek_rekonsiliasi();
					} 
				  }
				});
			}
		});
		
		
		function cek_rekonsiliasi()
		{
			
							$.ajax({
							url		: "<?php echo site_url('pph21/submit_rekonsiliasi') ?>",
							type	: "POST",
							data	: $('#form-wp').serialize(),							
							success	: function(result){
								if (result==1) {
									getStart();
									table.draw();
									getSummary();
									table.ajax.reload();			
									table_final.ajax.reload();			
									table_nonfinal.ajax.reload();
									$("body").removeClass("loading");
									flashnotif('Sukses','Data Berhasil di Submit!','success' );						
								} else {
									 $("body").removeClass("loading");
									 flashnotif('Error','Data Gagal di Submit!','error' );
								}
							}
						});	
		}
		$("#btnEdit-bulanan").click(function (){
			$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			valueGrid();
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN";
			isInput();
		});
		$("#btnEdit-final").click(function (){
			$("#btnEdit-bulanan").trigger("click");
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Final Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN FINAL";
			isInput();
		});
		$("#btnEdit-nonfinal").click(function (){
			$("#btnEdit-bulanan").trigger("click");
			$("#capAdd").html("<span class='label label-danger'>Edit Data PPh 21 Bulanan Non Final Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN NON FINAL";
			isInput();
		});
	
	
	function valueAdd()
	{
		$("#fAddAkun").val($("#jenisPajak").val());
		$("#fAddNamaAkun").val($("#jenisPajak").find(":selected").attr("data-name"));
		$("#fAddBulan").val($("#bulan").val());
		$("#fAddTahun").val($("#tahun").val());
		$("#fAddType").val($("#jenisPajak").find(":selected").attr("data-type"));
		$("#uplPph").val($("#jenisPajak").val());
		$("#import_bulan_pajak").val($("#bulan").val());
		$("#import_tahun_pajak").val($("#tahun").val());
		$("#import_tipe").val($("#jenisPajak").find(":selected").attr("data-type"));
		$("#fAddPembetulan").val($("#pembetulanKe").val());
	}	
	
	
	function valueGrid()
	{
		$("#idPajakHeader").val(vidpajakheader);
		$("#idPajakLines").val(vidpajaklines);
		$("#idwp").val(vid);
		$("#namawp").val(vnama);
		$("#npwp").val(vnpwp);
		$("#alamat").val(valamat);
		$("#kodepajak").val(vkodepajak);
		$("#dpp").val(vdpp);
		$("#tarif").val(vtarif);
		$("#jumlahpotong").val(vjumlahpotong);
		$("#invoicenumber").val(vinvoicenum);
		$("#nofakturpajak").val(vnofakturpajak);		
		$("#tanggalfakturpajak").val(vtanggalfakturpajak);	
		$("#newkodepajak").val(vnewkodepajak);			
		$("#newtarif").val(vnewtarif);			
		$("#newdpp").val(vnewdpp);			
		$("#newjumlahpotong").val(vnewjumlahpotong);
		$("#nobupot").val(vnobupot);
		$("#glaccount").val(vglaccount);		
		$("#fAkun").val(vakunpajak);		
		$("#fNamaAkun").val(vnamapajak);		
		$("#fBulan").val(vbulanpajak);		
		$("#fTahun").val(vtahunpajak);		
		/* $("#organization_id").val(vorganization);
		$("#vendor_site_id").val(vvendor_site_id);		
		$("#tanggalgl").val(vtanggalgl);		
		$("#matauang").val(vmatauang);	 */	
	}
	function getStart()
	{
		$.ajax({
			url		: "<?php echo site_url('pph21/get_start') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:$("#bulan").val(),tahun:$("#tahun").val(),pasal:$("#jenisPajak").val(), tipe:$("#jenisPajak").find(":selected").attr("data-type"),pembetulan:$("#pembetulanKe").val() }),
			success	: function(result){				
				if (result.isSuccess==1) {	
					// console.log(result.status);
					if(result.status_period=="OPEN"){
						if(result.status=="DRAFT" || result.status=="REJECT SUPERVISOR" || result.status=="REJECT BY ADMIN"){
							$("#btnSubmit, #btnsaldoAwal").slideDown(700);
							$("#btnAdd").removeAttr("disabled");
						} else {
							$("#btnSubmit, #btnsaldoAwal").slideUp(700);
							$("#btnAdd").attr("disabled",true);
						}
					} else {
						$("#btnSubmit, #btnsaldoAwal").slideUp(700);
						$("#btnAdd").attr("disabled", true);
					}
					// $("#lblStatus").html(result.status+" - "+result.status_period);
					 $("#keterangan").val(result.keterangan);					 
				} else {
					 //$("#lblStatus").html("-----");
					 $("#keterangan").val("");
					 $("#btnAdd").attr("disabled", true);
					 $("#btnSubmit, #btnsaldoAwal").slideUp(700);
				}				
			}
		});	
	}
	
	
	// ==================== CHEKLIST ==============
	function actionCheck(x)
	{
		// console.log(vcheckbox_id +" "+vlinse_id);
		if($("#"+vcheckbox_id).prop('checked') == true){
			  var vischeck	= 1;
			  var st_check	= "Checklist";			 
		 } else {
			 var vischeck	= 0;
			 var st_check	= "Unchecklist";			  
		 } 
		
		 
		 $.ajax({
				url		: "<?php echo site_url('pph21/check_rekonsiliasi');?>",
				type	: "POST",
				data	: ({line_id : vlinse_id, ischeck : vischeck}),				
				success	: function(result){
					if (result==1) {
						/* if($("#"+vcheckbox_id).prop('checked') == true){						 
						  $("#"+vcheckbox_id).prop('checked', false);
						 } else {
							$("#"+vcheckbox_id).prop('checked', true);
						 } */
						 
						  if (x==1){							
							  table.column(2).data().each( function (value, index) {							
								 if (value==vlinse_id) {
									 table.cell( index, 34 ).data(vischeck);								
									}
								});
						 } else if(x==2){
							  table_final.column(2).data().each( function (value, index) {							
								 if (value==vlinse_id) {
									 table_final.cell( index, 34 ).data(vischeck);								
									}
								});
						 } else {
							 table_nonfinal.column(2).data().each( function (value, index) {							
								 if (value==vlinse_id) {
									 table_nonfinal.cell( index, 34 ).data(vischeck);							
									}
								});
						 }
						
						 
						 getSummary();
						// getSummary(1);
						// getSummary(2);
						// getSummary(3);
						 getSelectAll();
						 getSelectAll1();
						 getSelectAll2();
						flashnotif('Sukses','Data Berhasil di '+st_check+'!','success' );			
					} else {
						 flashnotif('Error','Data Gagal di '+st_check+'!','error' );
					}
				}
			});	
	}
	
	//========================= SELECT ALL===================
	function getSelectAll()
	{
		vis_checkAll=1;
		var a=0;
		table.column(34).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll=0;
			} 
		});			
		
		if(vis_checkAll==1){
			$("#checkboxAll").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll").prop('checked',false).removeAttr("disabled");
		}
		vid_lines = "";
		var i = 0;
		table.column(2).data().each( function (value, index) {			
			i++;
			if(i==1){
				vid_lines += value;
			} else {
				vid_lines +=" ,"+value;
			}
		});
		// console.log(vid_lines);
		if(a==0){
			$("#checkboxAll").prop('checked',false).attr("disabled",true);
		}		
	}
	
	//========================= SELECT ALL 1===================
	function getSelectAll1()
	{
		vis_checkAll_final=1;
		var a=0;
		table_final.column(34).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll_final=0;
			} 
		});			
		
		if(vis_checkAll_final){
			$("#checkboxAll-final").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-final").prop('checked',false).removeAttr("disabled");
		}
		vid_lines1 = "";
		var i = 0;
		table_final.column(2).data().each( function (value, index) {			
			i++;
			if(i==1){
				vid_lines1 += value;
			} else {
				vid_lines1 +=" ,"+value;
			}
		});
		
		if(a==0){
			$("#checkboxAll-final").prop('checked',false).attr("disabled",true);
		}
	}
	
	
	//========================= SELECT ALL 2===================
	function getSelectAll2()
	{
		vis_checkAll_nonfinal=1;
		var a=0;
		table_nonfinal.column(34).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll_nonfinal=0;
			} 
		});			
		
		if(vis_checkAll_nonfinal==1){
			$("#checkboxAll-nonfinal").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-nonfinal").prop('checked',false).removeAttr("disabled");
		}
		vid_lines2 = "";
		var i = 0;
		table_nonfinal.column(2).data().each( function (value, index) {
			i++;
			if(i==1){
				vid_lines2 += value;
			} else {
				vid_lines2 +=" ,"+value;
			}
		});		
		if(a==0){
			$("#checkboxAll-nonfinal").prop('checked',false).attr("disabled",true);
		}	
		
	}
	
	//================================ BATAS FUNCT ===========================
	
	
	$("#checkboxAll").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }	
			
		$.ajax({
			url		: "<?php echo site_url('pph21/get_selectAll_bulanan') ?>",
			type	: "POST",
			data	: ({id_lines:vid_lines,vcheck:vischeckAll}),	
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".bulanan").prop('checked',true);
					} else {
						$(".bulanan").prop('checked',false);
					}
					table.column(2).data().each( function (value, index) {						 
						table.cell( index, 34 ).data(vischeckAll);	
					} );
					getSummary(); //untuk hasil chek ke summary
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
			}
		});
	});
	
	
	$("#checkboxAll-final").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }			
		$.ajax({
			url		: "<?php echo site_url('pph21/get_selectAll_final') ?>",
			type	: "POST",
			data	: ({id_lines:vid_lines1,vcheck:vischeckAll}),	
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".final").prop('checked',true);
					} else {
						$(".final").prop('checked',false);
					}
					table_final.column(2).data().each( function (value, index) {						 
						table_final.cell( index, 34 ).data(vischeckAll);	
					} );
					getSummary(); //untuk hasil chek ke summary
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
			}
		});
	});
	
	$("#checkboxAll-nonfinal").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }			
		$.ajax({
			//url		: "<?php echo site_url('pph21/get_selectAll_nonfinal') ?>",
			url		: "<?php echo site_url('pph21/get_selectAll_nonfinal') ?>",
			type	: "POST",
			data	: ({id_lines:vid_lines2,vcheck:vischeckAll}),	
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".nonfinal").prop('checked',true);
					} else {
						$(".nonfinal").prop('checked',false);
					}
					table_nonfinal.column(2).data().each( function (value, index) {						 
						table_nonfinal.cell( index, 34 ).data(vischeckAll);	
					} );
					getSummary(); //untuk hasil chek ke summary
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
			}
		});
	});
	
	
	//============================================================//========================
	
	function isInput()
	{
		// console.log(vtype);
		if (vtype=="BULANAN"){
			$("#getnamawp, #newdpp, #kodenegara").removeAttr("disabled");
			$("#newtarif, #nik, #wpluar, #dppbaseamount, #tanpanpwp, #tarif, #dpp,#newjumlahpotong").attr('disabled', true);			
		} else if (vtype=="BULANAN FINAL"){
			$("#getnamawp, #newtarif, #newdpp, #nik").removeAttr("disabled");
			$("#wpluar, #dppbaseamount, #tanpanpwp, #kodenegara, #tarif, #dpp").attr('disabled', true);
		} else if (vtype=="BULANAN NON FINAL"){ 
			$("#getnamawp, #tarif, #dpp, #nik, #wpluar, #kodenegara, #dppbaseamount, #tanpanpwp").removeAttr("disabled");
			$("#tarif").attr('disabled', true);			
		}
	}
	$("#dpp, #tarif").on("keyup blur",function(){
		var jmldpp 		=$("#dpp").val();
		var jmltarif 	=$("#tarif").val();
		var jmlpotong	= jmltarif * jmldpp/100;
		$("#jumlahpotong").val(number_format(jmlpotong,2,'.',','));
	});
	$("#newdpp, #newtarif").on("keyup blur",function(){
		var njmldpp 	= $("#newdpp").val();
		var njmltarif 	= $("#newtarif").val();
		var njmlpotong	= njmltarif * njmldpp/100;
		$("#newjumlahpotong").val(number_format(njmlpotong,2,'.',','));
	});
	$("#btnDelete-bulanan,#btnDelete-final,#btnDelete-nonfinal").click(function(){
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
						url		: "<?php echo site_url('pph21/delete_rekonsiliasi');?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								getSummary();
								/*getSummary(1);
								getSummary(2);
								getSummary(3);*/
								table.ajax.reload();			
								table_final.ajax.reload();			
								table_nonfinal.ajax.reload();
								$("body").removeClass("loading");
								 table.draw();
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
	$("#btnAdd").on("click", function(){		
		$("#isNewRecord").val("1");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);		
		empety();	
	});
	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empety();
	});	
	$("#btnEksportCSV").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>pph21/export_format_csv";
			var j       = $("#jenisPajak").val();
			var tipenya = $("#jenisPajak").find(":selected").attr("data-type");
			var b       = $("#bulan").val();
			var t       = $("#tahun").val();
			var p		= $("#pembetulanKe").val();
			window.open(urlnya+'?tipe='+tipenya+'&tax='+j+'&month='+b+'&year='+t+'&ke='+p, '_blank');
			window.focus(); 	
	});
	$("#btnLoad").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>pph21/load_format_csv";
			var j       = $("#jenisPajak").val();
			var tipenya = $("#jenisPajak").find(":selected").attr("data-type");
			var b       = $("#bulan").val();
			var t       = $("#tahun").val();
			var p		= $("#pembetulanKe").val();
			window.open(urlnya+'?tipe='+tipenya+'&tax='+j, '_blank');
			window.focus(); 	
			if(tipenya=="BULANAN"){
				if (!table.data().any()){
				 flashnotif('Info','Data Bulanan Kosong!','warning' );
				 return false;
				}
			}
			if(tipenya=="BULANAN FINAL"){
				if (!table_final.data().any()){
				 flashnotif('Info','Data Bulanan Final Kosong!','warning' );
				 return false;
				}
			}
			if(tipenya=="BULANAN NON FINAL"){
				if (!table_nonfinal.data().any()){
				 flashnotif('Info','Data Bulanan Non Final Kosong!','warning' );
				 return false;
				}
			}
			/* if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else { */
				$.ajax({			
					url		: "<?php echo site_url(); ?>pph21/cek_data_load_csv",
					type	: "POST",
					data	: ({tax: j,month: b, tipe: tipenya, year: t}),					
					success	: function(result){
					// console.log(result);
						if (result==1) {
							// console.log('buka ' + urlnya+'?tipe='+tipenya+'&tax='+j);
							window.open(urlnya+'?tipe='+tipenya+'&tax='+j, '_blank');
							window.focus(); 							 
						} else {
							flashnotif('Error','Data Kosong!','error' );
							return false;
						}
					}
				});				
			//}
	});
	 $("#btnImportCSV").click(function(){
       var form = $('#form-import')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('pph21/import_CSV') ?>",
            data: data,
			  beforeSend	: function(){
				 $("body").addClass("loading");					
			}, 
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
				// console.log(result);
				 if (result==1) {
                    getSummary();
                    /*getSummary(1);
					getSummary(2);
					getSummary(3);*/
					table.ajax.reload();			
					table_final.ajax.reload();			
					table_nonfinal.ajax.reload();
					$("#aRemoveCSV").click();
					$("body").removeClass("loading");
					flashnotif('Sukses','Data Berhasil di Import!','success' );	
                    $("#file_csv").val("");
                } else if(result==2){
					$("body").removeClass("loading");
					flashnotif('Info','File Import CSV belum dipilih!','warning' );	
				} else if(result==3){
					$("body").removeClass("loading");
					flashnotif('Info','Format File Bukan CSV!','warning' );						
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Perhatikan ; & Format Tanggal !','error' );
                } 
            }
        });
    });		
	$("#btnsaldoAwal").on("click", function(){
		var j		= $("#jenisPajak").val();
		var b		= $("#bulan").val();
		var t		= $("#tahun").val();
		var p		= $('#pembetulanKe').val();
		var sal		= $("#saldoAwal").val();
		var mtsd	= $("#mutasiDebet").val();
		var mtsk	= $('#mutasiKredit').val();
		var tipe	= $('#tipe').val();	
		
		$.ajax({
				url		: "<?php echo site_url('pph21/save_saldo_awal') ?>",
				type	: "POST",
				beforeSend	: function(){
				 $("body").addClass("loading");					
				}, 
				data	: ({pajak:j, bulan:b, tahun:t, pembetulan:p, vsal:sal, vmtsd:mtsd, vmtsk:mtsk,vtipe:tipe }),				
				success	: function(result){
					$("body").removeClass("loading");
					if (result==1) {					
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 getSummary();						 
					} else {
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}					
				}
			});
	})
	
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
	
	
	
	function getFormCSV(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}
	
	
	function reload_list(){
		$('#tabledata').DataTable().ajax.reload();
		$('#tabledata-summary1').DataTable().ajax.reload();
		$('#tabledata-summary0').DataTable().ajax.reload();
		$('#tabledata_bulanan_final').DataTable().ajax.reload();
		$('#tabledata-summary1-final').DataTable().ajax.reload();
		$('#tabledata-summary0-final').DataTable().ajax.reload();
		$('#tabledata_bulanan_non_final').DataTable().ajax.reload();
		$('#tabledata-summary1-nonfinal').DataTable().ajax.reload();
		$('#tabledata-summary0-nonfinal').DataTable().ajax.reload();
		$('#tabledata-summaryAll1').DataTable().ajax.reload();
		
	}
	
	
	
	//============= RINGKASAN Summary
	
	
	
	function getSummary()
	{
		//alert('asasa');
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
										d._step				= "REKONSILIASI";
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
	
	//===================================================================
	
	
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
										d._searchTipe		= "REKONSILIASI";
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
					{ "data": "nama_wp" },					
					{ "data": "no_faktur_pajak" },					
					{ "data": "tanggal_faktur_pajak" },					
					{ "data": "dpp" , "class":"text-right" },
					{ "data": "jumlah_potong" , "class":"text-right" },
					{ "data": "keterangan" }
				],	
			"columnDefs": [ 
				 {
					"targets": [ 3,4],					
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
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchTipe : "REKONSILIASI" }),
			success	: function(result){										
					$("#dTotalselisih").html("<h4><strong>TOTAL SELISIH &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );				
					
			}
		});	
	}	
		/* Akhir detail Summary=========================================== */
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Search No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();			
	});	
	
	
	
//Awal modal get nama wp==============================


function empety()
{
	vidpajakheader      = "";
	vidpajaklines       = "";
	vid                 = "";
	vnama               = "";
	vnpwp               = "";
	valamat             = "";
	vkodepajak          = "";
	vdpp                = "";
	vtarif              = "";
	vjumlahpotong       = "";		
	vinvoicenum	        = "";
	vnofakturpajak      = "";
	vtanggalfakturpajak = "";
	vnewkodepajak       = "";
	vnewtarif           = "";
	vnewdpp             = "";
	vnewjumlahpotong    = "";		
	vnobupot		    = "";		
	vglaccount		    = "";		
	vakunpajak		    = "";		
	vnamapajak		    = "";		
	vbulanpajak		    = "";		
	vtahunpajak		    = "";
	vmasapajak			= "";
	vtype 				= "";
	$("#idPajakHeader").val("");
	$("#idPajakLines").val("");
	$("#idwp").val("");
	$("#namawp").val("");
	$("#npwp").val("");
	$("#alamat").val("");
	$("#kodepajak").val("");
	$("#dpp").val("");
	$("#tarif").val("");
	$("#jumlahpotong").val("");
	$("#invoicenumber").val("");
	$("#nofakturpajak").val("");
	$("#tanggalfakturpajak").val("");
	$("#newkodepajak").val("");			
	$("#newtarif").val("");			
	$("#newdpp").val("");			
	$("#newjumlahpotong").val("");
	$("#nobupot").val("");
	$("#glaccount").val("");
	$("#fAkun").val("");
	$("#fNamaAkun").val("");	
	$("#fBulan").val("");		
	$("#fTahun").val("");	
	table.$('tr.selected').removeClass('selected');
	$('.DTFC_Cloned tr.selected').removeClass('selected');	
	$("#btnEdit, #btnDelete").attr("disabled",true);	
	$( ".datepicker-autoclose" ).removeAttr( "disabled");
	$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").removeAttr('readonly');
	$("#getnamawp, #getkodepajak").removeAttr("disabled");
	var j 	= $("#jenisPajak").find(":selected").attr("data-name");			
	var b	= $("#bulan").find(":selected").attr("data-name");			
	var t	= $("#tahun").val();		
	$("#capAdd").html("<span class='label label-danger'>Tambah Data "+j+" Bulan "+b+" Tahun "+t+"</span>");
	btnDisabled();
}
$("#getnamawp").on("click", function(){
		vid		        = "";
		vnama	        = "";				
		valamat	        = "";
		vnpwp	        = "";
		$("#btnChoice").attr("disabled",true);
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-namawp' ) ) {
			$('#tabledata-namawp').DataTable({
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: "<?php echo site_url('pph21/load_master_wp');?>",
									 "type" 		: "POST"
								  },
				 "language"		: {
						"emptyTable"	: "Data not found!",	
						"infoEmpty"		: "Empty Data",
						"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
						"search"		: "_INPUT_"
					},
				   "columns": [
						{ "data": "no", "class":"text-center" },
						{ "data": "vendor_id", "class":"text-left", "width" : "60px" },
						{ "data": "nama_wp" },
						{ "data": "alamat_wp" },
						{ "data": "npwp" }
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
			table_wp = $('#tabledata-namawp').DataTable();
			$("#modal-namawp input[type=search]").addClear();		
			$('#modal-namawp .dataTables_filter input[type="search"]').attr('placeholder','Search Nama/Alamat/NPWP...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
			$("#tabledata-namawp_filter .add-clear-x").on('click',function(){
				table_wp.search('').column().search('').draw();			
			});
			$('#tabledata-namawp tbody').on( 'click', 'tr', function () {			
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
					$("#btnChoice").attr("disabled",true);
					vid		        = "";
					vnama	        = "";				
					valamat	        = "";
					vnpwp	        = "";
				} else {
					table_wp.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d			= table_wp.row( this ).data();
					vid		        = d.vendor_id;
					vnama	        = d.nama_wp;				
					vnpwp	        = d.npwp;
					valamat	        = d.alamat_wp;
					$("#btnChoice").removeAttr('disabled'); 
				}								 
			} ).on("dblclick", "tr", function () {
				table_wp.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d		= table_wp.row( this ).data();
				vid		        = d.vendor_id;
				vnama	        = d.nama_wp;				
				vnpwp	        = d.npwp;
				valamat	        = d.alamat_wp;			
				valueGridwp();		
				$("#btnChoice").removeAttr('disabled'); 		
			} ) ;	
		} else {
			table_wp.$('tr.selected').removeClass('selected');
		}
	});
	$("#btnChoice").on("click",valueGridwp);
	$("#btnCancel").on("click",batal);	
	function valueGridwp()
	{
		$("#idwp").val(vid);
		$("#namawp").val(vnama);
		$("#npwp").val(vnpwp);
		$("#alamat").val(valamat);		
		$("#modal-namawp").modal("hide");		
	}
	function batal()
	{
		vid		        = "";
		vnama	        = "";				
		valamat	        = "";
		vnpwp	        = "";		
	}
//Akhir modal get nama wp========================================
/*Awal GeKode Pajak --------------------------------------------- */
	$("#getkodepajak").on("click", function(){
			vkodepajak  = "";
			vtarif      = "";			
			$("#btnChoice-kodepajak").attr("disabled",true);
			$("#modal-kodepajak").on("shown.bs.modal", function () {
				if ( ! $.fn.DataTable.isDataTable( '#tabledata-kodepajak' ) ) {
					$('#tabledata-kodepajak').DataTable({
						"serverSide"	: true,
						"processing"	: true,
						"ajax"			: {
											 "url"  		: "<?php echo site_url('pph21/load_master_kode_pajak');?>",
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "Data not found!",	
								"infoEmpty"		: "Empty Data",
								"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
								"search"		: "_INPUT_"
							},
						   "columns": [
								{ "data": "no", "class":"text-center" },
								{ "data": "tax_code", "class":"text-center" },
								{ "data": "jenis_21" },
								{ "data": "tax_rate" },
								{ "data": "description" }
							],						 
						 "select"			: true,
						 "scrollY"			: 360, 
						 "scrollCollapse"	: true, 
						 "scrollX"			: true,
						 "ordering"			: false			
					});	
					table_kp = $('#tabledata-kodepajak').DataTable();
					$("#modal-kodepajak input[type=search]").addClear();		
					$('#modal-kodepajak .dataTables_filter input[type="search"]').attr('placeholder','Search Kode/Tarif/Deskripsi Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
					$("#tabledata-kodepajak_filter .add-clear-x").on('click',function(){
						table_kp.search('').column().search('').draw();			
					});
					$('#tabledata-kodepajak tbody').on( 'click', 'tr', function () {			
						if ( $(this).hasClass('selected') ) {
							$(this).removeClass('selected');
							$("#btnChoice-kodepajak").attr("disabled",true);
							vkodepajak      = "";
							vtarif     		= "";
						} else {
							table_kp.$('tr.selected').removeClass('selected');
							$(this).addClass('selected');
							var d			= table_kp.row( this ).data();
							vkodepajak      = d.tax_code;						
							vtarif		    = d.tax_rate;						
							$("#btnChoice-kodepajak").removeAttr('disabled'); 
						}								 
					} ).on("dblclick", "tr", function () {
						table_kp.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						var d			= table_kp.row( this ).data();
						vkodepajak      = d.tax_code;						
						vtarif		    = d.tax_rate;	
						valueGridkp();	
						$("#btnChoice-kodepajak").removeAttr('disabled'); 		
					} ) ;	
				} else {
					table_kp.$('tr.selected').removeClass('selected');
				}
			});		
	});
	$("#btnChoice-kodepajak").on("click",valueGridkp);
	$("#btnCancel-kodepajak").on("click",batalkp);	
	function valueGridkp()
	{
		$("#kodepajak").val(vkodepajak);			
		$("#tarif").val(vtarif);			
		$("#dpp, #tarif").trigger("keyup");				
		$("#modal-kodepajak").modal("hide");		
	}
	function batalkp()
	{
		vkodepajak      = "";		
		vtarif		    = "";		
	}	
/*Akhir Kode Pajak --------------------------------------------- */	
	<!-- ============ New Kode Pajak ================================-->
/*Awal New Kode Pajak --------------------------------------------- */
	$("#getNewkodepajak").on("click", function(){
			vnewkodepajak   = "";	
			vnewtarif		= "";
			$("#btnChoice-newkodepajak").attr("disabled",true);
			$("#modal-newkodepajak").on("shown.bs.modal", function () {
				if ( ! $.fn.DataTable.isDataTable( '#tabledata-newkodepajak' ) ) {
					$('#tabledata-newkodepajak').DataTable({
						"serverSide"	: true,
						"processing"	: true,
						"ajax"			: {
											 "url"  		: "<?php echo site_url('pph21/load_master_kode_pajak');?>",
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "Data not found!",	
								"infoEmpty"		: "Empty Data",
								"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
								"search"		: "_INPUT_"
							},
						   "columns": [
								{ "data": "no", "class":"text-center" },
								{ "data": "tax_code", "class":"text-center" },
								{ "data": "tipe_21" },
								{ "data": "tax_rate" },
								{ "data": "description" }
							],							
						 "select"			: true,
						 "scrollY"			: 360, 
						 "scrollCollapse"	: true, 
						 "scrollX"			: true,
						 "ordering"			: false	
					});	
					table_newkodepajak = $('#tabledata-newkodepajak').DataTable();
					$("#modal-newkodepajak input[type=search]").addClear();		
					$('#modal-newkodepajak .dataTables_filter input[type="search"]').attr('placeholder','Search Kode/Tarif/Deskripsi Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
					$("#tabledata-newkodepajak_filter .add-clear-x").on('click',function(){
						table_newkodepajak.search('').column().search('').draw();			
					});
					$('#tabledata-newkodepajak tbody').on( 'click', 'tr', function () {			
						if ( $(this).hasClass('selected') ) {
							$(this).removeClass('selected');
							$("#btnChoice-newkodepajak").attr("disabled",true);
							vnewkodepajak	= "";
							vnewtarif		= "";							
						} else {
							table_newkodepajak.$('tr.selected').removeClass('selected');
							$(this).addClass('selected');
							var d			= table_newkodepajak.row( this ).data();
							vnewkodepajak  	= d.tax_code;						
							vnewtarif      	= d.tax_rate;						
							$("#btnChoice-newkodepajak").removeAttr('disabled'); 
						}								 
					} ).on("dblclick", "tr", function () {
						table_newkodepajak.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						var d		= table_newkodepajak.row( this ).data();
						vnewkodepajak  	= d.tax_code;						
						vnewtarif      	= d.tax_rate;					
						valueGridNewKodePajak();	
						$("#btnChoice-newkodepajak").removeAttr('disabled'); 		
					} ) ;	
				} else {
					table_newkodepajak.$('tr.selected').removeClass('selected');
				}
			});
	});
	$("#btnChoice-newkodepajak").on("click",valueGridNewKodePajak);
	$("#btnCancel-newkodepajak").on("click",batalNewKodePajak);	
	function valueGridNewKodePajak()
	{
		$("#newkodepajak").val(vnewkodepajak);			
		$("#newtarif").val(vnewtarif);			
		$("#modal-newkodepajak").modal("hide");
		$("#newdpp, #newtarif").trigger("keyup");	
	}
	function batalNewKodePajak()
	{
		vnewkodepajak	= "";
		vnewtarif		= "";		
	}		
/*Akhir New Kode Pajak --------------------------------------------- */	
 });
    </script>
