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
						 $bln	= date('m');
						/*if ($bln > 1){
							$bln     = $bln - 1;
							$tahun_n = 0;
						} else {
							$bln     = 12;
							$tahun_n = 1;
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
							$tAkhir	= $tahun;	
							for($i=$tAwal; $i<=$tAkhir;$i++){
								$selected	= ($i==$tahun)?"selected":"";
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
						<option value="PPN WAPU" data-name="PPN WAPU" >PPN WAPU</option>
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
		  
		  <div id="d-FormCsv">
	 <div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			 <div class="white-box boxshadow">
				<div class="row">
					<div class="form-group">
						<label>Export CSV Format</label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button id="btnEksportCSV" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>Export CSV</span></button>
						</div>
					</div>
				</div>
				</br>
			 </div>
		</div>
		 <!-- <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
			 <div class="white-box boxshadow">
				 <div class="row">
					 <form role="form" id="form-import" autocomplete="off">
						  <div class="col-lg-8">	
							<div class="form-group">
								<label class="form-control-label">File CSV</label>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
									<input type="file" id="file_csv" name="file_csv"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
								<input type="hidden" class="form-control" id="uplPph" name="uplPph">
								<input type="hidden" class="form-control" id="import_jenisPajak" name="import_jenisPajak">
								<input type="hidden" class="form-control" id="import_bulan" name="import_bulan">
								<input type="hidden" class="form-control" id="import_tahun" name="import_tahun">
								<input type="hidden" class="form-control" id="import_pembetulanKe" name="import_pembetulanKe">
							</div>
						  </div>						  
						  <div class="col-lg-4">	
							<div class="form-group">
							<label>&nbsp;</label>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button" ><i class="fa fa-sign-in"></i> <span>Import CSV</span></button>
								</div>
							</div>
						  </div>	  
					  </form> 
				  </div>
			 </div>
		</div> -->

		<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
			 <div class="white-box boxshadow">
				 <div class="row">
					 <form role="form" id="form-insert" autocomplete="off">
						  <div class="col-lg-8">	
							<div class="form-group">
								<label class="form-control-label">Import CSV</label>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
									<input type="file" id="file_csv" name="file_csv"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
								<input type="hidden" class="form-control" id="uplPpn" name="uplPpn">
								<input type="hidden" class="form-control" id="insert_jenisPajak" name="insert_jenisPajak">
								<input type="hidden" class="form-control" id="insert_bulan" name="insert_bulan">
								<input type="hidden" class="form-control" id="insert_tahun" name="insert_tahun">
								<input type="hidden" class="form-control" id="insert_pembetulanKe" name="insert_pembetulanKe">
							</div>
						  </div>						  
						  <div class="col-lg-4">	
							<div class="form-group">
							<label>&nbsp;</label>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button id="btnInsertCSV" class="btn btn-info btn-rounded btn-block" type="button" ><i class="fa fa-sign-in"></i> <span>Import CSV</span></button>
								</div>
							</div>
						  </div>	  
					  </form> 
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
								<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Rekonsiliasi</a>
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">								 
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> Add New</button> 			
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> Edit</button>
									<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> Delete</button>
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
                                    	<th> 
												 <div class="checkbox checkbox-inverse">
													<input id="checkboxAll" type="checkbox">
													<label for="checkboxAll"></label>
												</div>
											</th>
                                        <th>NO</th>
                                        <th>PAJAK LINE ID</th>
                                        <th>VENDOR ID</th>
                                        <th>VENDOR SITE ID</th>
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
                                        <th>NO BUKTI POTONG</th>										
										<th>KODE PAJAK</th>																				
                                        <th>TARIF (%)</th>
										<th>JUMLAH POTONG</th>										
										<th>NEW KODE PAJAK</th>
										<th>NEW DPP</th>
										<th>NEW TARIF (%)</th>
										<th>NEW JUMLAH POTONG</th>
										<th>PEMBETULAN KE</th>
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
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary-detail">DATA TIDAK DILAPORKAN</a>
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
								<div class="panel-footer">										
									<div class="row">										
										<div class="col-lg-12 text-center"> 											
											<button id="btnSubmit" class="btn btn-danger btn-rounded custom-input-width  " type="button"><i class="fa fa-share-square-o"></i> <span>SUBMIT</span></button>
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
			<hr>
		</div>
		<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Lampiran</label>
					<input type="text" class="form-control" id="kdlampiran" name="kdlampiran" value="2">
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Status</label>
					<input type="text" class="form-control" id="kdstatus" name="kdstatus" value="3">
				</div>
			 </div>
			</div>
			 <div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Transaksi</label>
					<input class="form-control" id="kdtransaksi" name="kdtransaksi" placeholder="Kode Transaksi" type="text" maxlength="1">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Dokumen</label>
					<input class="form-control" id="kddokumen" name="kddokumen" placeholder="Kode Dokumen" type="text" maxlength="30">					
				</div>
			 </div>
			</div>
			  <!-- <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Dokumen</label>
					<input class="form-control" id="kddokumen" name="kddokumen" placeholder="Kode Dokumen" type="text" maxlength="30">					
				</div>
			 </div>
			</div>	 -->
		<div class="row">
			  <div class="col-lg-6 ">
				<div class="form-group">
					<label>Nama Lawan Transaksi</label>
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
					
					<div class="input-group">
						<input class="form-control" id="namawp" name="namawp" placeholder="Nama WP" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp" ><i class="fa fa-search"></i></button>
						</span> 
					</div>					
				</div>
			  </div>
			    <div class="col-lg-6">
				<div class="form-group">
					<label>Digit Tahun</label>
					<input class="form-control" id="digitthn" name="digitthn" placeholder="Digit Tahun" type="text" maxlength="2">					
				</div>
			 </div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>NPWP Lawan Transaksi</label>
					<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP Lawan Transaksi" readonly>
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>NO SERI FP/NO NOTA RETUR</label>
					<input class="form-control" id="nofakturpajak" name="nofakturpajak" placeholder="NO SERI FP/NO NOTA RETUR" type="text" maxlength="30">					
				</div>
			 </div>
			</div>	
			<div class="row">
			  <div class="col-lg-6">	
					<div class="form-group">
					<label>Tanggal Tagih</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tgltagih" name="tgltagih" placeholder="dd/mm/yyyy" > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>
			 </div>
				 <div class="col-lg-6">
				<div class="form-group">
					<label>Tanggal Setor PPN</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tglsetorppn" name="tglsetorppn" placeholder="dd/mm/yyyy" > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>	
			 </div>	
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Tanggal Setor PPNBM</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tglsetorppnbm" name="tglsetorppnbm" placeholder="dd/mm/yyyy" > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>	
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>Tanggal Faktur</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tanggalfakturpajak" name="tanggalfakturpajak" placeholder="dd/mm/yyyy" > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>	
			 </div>
			</div>
			<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Jumlah PPN</label>
					<input class="form-control" id="jlhppn" name="jlhppn" placeholder="Jumlah PPN" type="text" maxlength="18">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>Jumlah PPN BM</label>
					<input class="form-control" id="jlhpbm" name="jlhpbm" placeholder="Jumlah PPN BM" type="text" maxlength="18">					
				</div>
			 </div>
			</div>
			<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Mata Uang</label>
					<input class="form-control" id="matauang" name="matauang" placeholder="Mata Uang" type="text" maxlength="18">					
				</div>
			 </div>
			 <div class="col-lg-6">
				<div class="form-group">
					<label>Jumlah DPP</label>
					<input class="form-control" id="dpp" name="dpp" placeholder="Jumlah DPP" type="text">					
				</div>
			 </div>
			</div>
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> Back</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> Save</button>
						  </div>
					 </div>
				</div>
			</div>
		</div>
		
	</form>	
</div>
<!-------------------------------------->		

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
								<th>NAMA LAWAN TRASAKSI</th>
								<th>ALAMAT</th>
								<th>NPWP LAWAN TRANSAKSI</th>								
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
<!-------------------------------------->	

<!-- modal master Kode Pajak -->
<div id="modal-kodepajak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Data Kode Pajak</h4> </div>
			<div class="modal-body">
				<div id="loadView">
					<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small animated slideInDown" id="tabledata-kodepajak"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>Kode Pajak</th>
								<th>Jenis</th>
								<th>Tarif</th>
								<th>Deskripsi</th>								
							</tr>
						</thead>
					</table>
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel-kodepajak"><i class="fa fa-times-circle"></i>  Batal</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice-kodepajak" disabled ><i class="fa fa-plus-circle"></i> Pilih</button>
			</div>
		</div>	
	</div>
</div>
<!-------------------------------------->	

<!-- modal new master Kode Pajak -->
<div id="modal-newkodepajak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Data Kode Pajak</h4> </div>
			<div class="modal-body">
				<div id="loadView">
					<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small animated slideInDown" id="tabledata-newkodepajak"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>Kode Pajak</th>
								<th>Jenis</th>
								<th>Tarif</th>
								<th>Deskripsi</th>													
							</tr>
						</thead>
					</table>
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel-newkodepajak"><i class="fa fa-times-circle"></i>  Batal</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice-newkodepajak" disabled ><i class="fa fa-plus-circle"></i> Pilih</button>
			</div>
		</div>	
	</div>
</div>
<!-------------------------------------->
							
<script>
    $(document).ready(function() {
		var table	= "", table_wp="",table_kp="", table_newkodepajak="", vid = "",vnama = "", vnpwp ="", valamat="", vkodepajak="",vdpp="",vtarif="",vjumlahpotong="",vkodecabang="",vpembetulan="",vpbm="",vdigitthn="",vtgltagih="",vtglsetorppn="",vtglsetorppnbm="",vjlhppn="",vkdlampiran="",vkdtransaksi="",vkdstatus="",vkddokumen="";	
		var vinvoicenum	= "", vnofakturpajak = "",vtanggalfakturpajak = "", vnewkodepajak ="", vnewtarif="", vnewdpp="",vnewjumlahpotong="", vidpajaklines="", vidpajakheader="", vnobupot="", vglaccount="",vnamapajak="", vakunpajak="", vbulanpajak="", vtahunpajak="",vmasapajak="",vorganization="",vvendor_site_id="", vmatauang="";
		var vlinse_id ="",vcheckbox_id ="";
		var vid_lines = "", vis_checkAll=1;
		
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
		
		 Pace.track(function(){  
		   $('#tabledata').DataTable({	
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_rekonsiliasi'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
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
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "vendor_site_id" },
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
					{ "data": "no_bukti_potong" },
					{ "data": "kode_pajak" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" },
					{ "data": "pembetulan_ke", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 2,3,4,5,6,7,30,31,32,32,33,34,35,36,37,38,39,40 ],
					"visible": false
				} 
			],			
			/* "fixedColumns"	:   {
					"leftColumns": 2
			},	 */	
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
		
		$("#list-data input[type=search]").addClear();
		$('#list-data .dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama Pajak/Invoice Number...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();
		});
		
		 table.on( 'draw', function () {
			$(".checklist").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id"); 
				 actionCheck();
			 }); 
			/*$('.checklist').confirmation({
				rootSelector: '[data-toggle=confirmation-singleton]',
				container: 'body',
				title: "Anda Yakin?",
				onConfirm: function() {		 		  
				   actionCheck();
				},
				btnOkClass: 'btn-xs btn-info',
				btnOkIcon: 'glyphicon glyphicon-ok',
				btnOkLabel: 'Ya',
				btnCancelClass: 'btn-xs btn-default',
				btnCancelIcon: 'glyphicon glyphicon-remove',
				btnCancelLabel: 'Tidak'				
			  });*/
			$("#btnEdit, #btnDelete").attr("disabled",true);
			getSelectAll();
			getFormCSV();
			  
		} );
			

		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');	
				empety();
				$("#isNewRecord").val("1");
			} else {
				table.$('tr.selected').removeClass('selected');
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
				vorganization  		= d.organization_id;
				vkodecabang			= d.kode_cabang;
				vpembetulan			= d.pembetulan_ke;
				vjlhppn				= d.jumlah_ppn;
				vdigitthn			= d.digit_tahun;
				vtgltagih			= d.tgl_tagih;
				vtglsetorppn		= d.tgl_setor_ppn;
				vtglsetorppnbm		= d.tgl_setor_ppnbm;
				vpbm				= d.jumlah_ppnbm;
				vkdlampiran			= d.kode_lampiran;
				vkdtransaksi		= d.kode_transaksi;
				vkdstatus			= d.kode_status;
				vkddokumen			= d.kode_dokumen;
				vvendor_site_id		= d.vendor_site_id;
				vmatauang			= d.currency_code;
				valueGrid();	
				$("#btnEdit, #btnDelete").removeAttr('disabled');
				$("#isNewRecord").val("0");
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
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
			vorganization  		= d.organization_id;
			vkodecabang			= d.kode_cabang;
			vpembetulan			= d.pembetulan_ke;
			vjlhppn				= d.jumlah_ppn;
			vdigitthn			= d.digit_tahun;
			vtgltagih			= d.tgl_tagih;
			vtglsetorppn		= d.tgl_setor_ppn;
			vtglsetorppnbm		= d.tgl_setor_ppnbm;
			vpbm				= d.jumlah_ppnbm;
			vkdlampiran			= d.kode_lampiran;
			vkdtransaksi		= d.kode_transaksi;
			vkdstatus			= d.kode_status;
			vkddokumen			= d.kode_dokumen;
			vvendor_site_id		= d.vendor_site_id;
			vmatauang			= d.currency_code;
			$("#isNewRecord").val("0");
			valueGrid();
			$("#btnEdit, #btnDelete").removeAttr('disabled');
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			//$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nobupot, #jlhpbm,").attr('readonly', true);
			$("#getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+vnamapajak+" Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
		} );
				
		
		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		
		
		$("#btnView").on("click", function(){	
			valueAdd();
			getStart();
			getSummary();
			table.ajax.reload();
		});
		
		$("#bulan, #tahun, #jenisPajak").on("change", function(){
			valueAdd();
		});

		$('.datepicker-autoclose').datepicker({
		    format: 'dd/mm/yyyy'
		});

		$("#aTitleList").on("click", function(){
			console.log('lll');
			table.$('tr.selected').removeClass('selected');
			$("#btnEdit, #btnDelete").attr('disabled', true);
		});
		
		$("#btnSave").click(function(){		
			$.ajax({
				url		: "<?php echo site_url('ppn_wapu/save_rekonsiliasi') ?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					//console.log(result);
					if (result==1) {
						 table.draw();
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
			
			var jnm	= $("#jenisPajak").find(":selected").attr("data-name");
			var bnm	= $("#bulan").find(":selected").attr("data-name");	
			
			if (j != '' && b != '' && t != '') 
			{
				bootbox.confirm({
				title: "Submit data <span class='label label-danger'>"+jnm+"</span> Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> Pembetulan ke <span class='label label-danger'>"+p+"</span>?",
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
				url		: "<?php echo site_url('ppn_wapu/cek_row_rekonsiliasi') ?>",
				type	: "POST",
				dataType:"json", 
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
						$("body").addClass("loading");
					 },
				success	: function(result){
					console.log(result.data);
					if (result.st==1){
						flashnotifnohide("info",result.data,"warning");
						$("body").removeClass("loading");
						return false;
					} else {
						$.ajax({
							url		: "<?php echo site_url('ppn_wapu/submit_rekonsiliasi') ?>",
							type	: "POST",
							data	: $('#form-wp').serialize(),			
							success	: function(result){
								if (result==1) {
									getStart();
									table.draw();
									getSummary();
									$("body").removeClass("loading");
									flashnotif('Sukses','Data Berhasil di Submit!','success' );	
								} else {
									 $("body").removeClass("loading");
									 flashnotif('Error','Data Gagal di Submit!','error' );
								}
								
							}
						});	
					} 					  
					  
				}
			});	
							
		}
				/*callback: function (result) {
					if(result) {
						$.ajax({
							url		: "<?php echo site_url('ppn_wapu/submit_rekonsiliasi') ?>",
							type	: "POST",
							data	: $('#form-wp').serialize(),
							beforeSend	: function(){
								 $("body").addClass("loading");
								 },
							success	: function(result){
								if (result==1) {
									getStart();
									table.draw();
									getSummary();
									$("body").removeClass("loading");
									 flashnotif('Sukses','Data Berhasil di Submit!','success' );	
								} else {
									 $("body").removeClass("loading");
									 flashnotif('Error','Data Gagal di Submit!','error' );
								}
								
							}
						});	
					}
				  }
				});
			}
		});*/
		
		$("#btnEdit").click(function (){
			$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			valueGrid();
			//$( ".datepicker-autoclose" ).attr( "disabled", true );
			//$("#dpp, #invoicenumber, #nobupot, #glaccount, #jlhpbm").attr('readonly', true);
			$("#getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+vnamapajak+" Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
		});

		$("#btnEksportCSV").on("click", function(){
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_format_csv_rekon";
			var j		= $("#jenisPajak").val();
			var b		= $("#bulan").val();
			var t		= $("#tahun").val();
			var p		= $('#pembetulanKe').val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else {
				$.ajax({	
					url		: '<?php echo site_url() ?>ppn_wapu/cek_data_csv'+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p,				
					success	: function(result){
						if (result==1) {	
							window.open(url+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p, '_blank');
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
            url: "<?php echo base_url('ppn_wapu/import_CSV') ?>",
            data: data,
			beforeSend	: function(){
				 $("body").addClass("loading");
			},
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
            	//console.log(result);
				if (result==1) {
                    table.ajax.reload();
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
					flashnotif('Error','Data Gagal di Import!','error' );
                }
            }
        });
    });

    $("#btnInsertCSV").click(function(){        
        var form = $('#form-insert')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('ppn_wapu/insert_CSV') ?>",
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
					$("body").removeClass("loading");
					flashnotif('Sukses','Data Berhasil di Import!','success' );	
                    $("#file_csv").val("");
                    getSummary();
                } else if(result==2){
					$("body").removeClass("loading");
					flashnotif('Info','File Import CSV belum dipilih!','warning' );	
				} else if(result==3){
					$("body").removeClass("loading");
					flashnotif('Info','Format File Bukan CSV!','warning' );	
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Data Gagal di Import!','error' );
                }
            }
        });
    });	
	
	function getFormCSV(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}

	$("#btnsaldoAwal").on("click", function(){
		var j		= $("#jenisPajak").val();
		var b		= $("#bulan").val();
		var t		= $("#tahun").val();
		var p		= $('#pembetulanKe').val();
		
		var sal		= $("#saldoAwal").val();
		var mtsd	= $("#mutasiDebet").val();
		var mtsk	= $('#mutasiKredit').val();	   
	
		$.ajax({
				url		: "<?php echo site_url('ppn_wapu/save_saldo_awal') ?>",
				type	: "POST",
				data	: ({pajak:j, bulan:b, tahun:t, pembetulan:p, vsal:sal, vmtsd:mtsd, vmtsk:mtsk }),
				success	: function(result){
					if (result==1) {
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 getSummary();	 
					} else {
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}	
				}
			});
	})

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
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._step				= "REKONSILIASI";
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
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchTipe		= "REKONSILIASI";
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
			data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchTipe : "REKONSILIASI" }),
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
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Search No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');
	
	$("#dDetail-summary .add-clear-x").on('click',function(){
		$('#table-detail-summary').DataTable().search('').column().search('').draw();
	});
	
	function valueAdd()
	{
		$("#fAddAkun").val($("#jenisPajak").val());
		$("#fAddNamaAkun").val($("#jenisPajak").find(":selected").attr("data-name"));
		$("#fAddBulan").val($("#bulan").val());
		$("#fAddTahun").val($("#tahun").val());
		$("#fAddPembetulan").val($("#pembetulanKe").val());

		$("#uplPph").val($("#jenisPajak").val());
		$("#import_bulan").val($("#bulan").val());
		$("#import_tahun").val($("#tahun").val());
		$("#import_pembetulanKe").val($("#pembetulanKe").val());

		$("#uplPpn").val($("#jenisPajak").val());
		$("#insert_bulan").val($("#bulan").val());
		$("#insert_tahun").val($("#tahun").val());
		$("#insert_pembetulanKe").val($("#pembetulanKe").val());
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
		$("#organization_id").val(vorganization);
		$("#kode_cabang").val(vkodecabang);
		$("#pembetulan_ke").val(vpembetulan);
		$("#jlhppn").val(vjlhppn);
		$("#digitthn").val(vdigitthn);
		$("#tgltagih").val(vtgltagih);
		$("#tglsetorppn").val(vtglsetorppn);
		$("#tglsetorppnbm").val(vtglsetorppnbm);
		$("#jlhpbm").val(vpbm);
		$("#kdlampiran").val(vkdlampiran);
		$("#kdtransaksi").val(vkdtransaksi);
		$("#kdstatus").val(vkdstatus);
		$("#kddokumen").val(vkddokumen);
		$("#vendor_site_id").val(vvendor_site_id);
		$("#matauang").val(vmatauang);
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
				url		: "<?php echo site_url('ppn_wapu/check_rekonsiliasi') ?>",
				type	: "POST",
				data	: ({line_id : vlinse_id, ischeck : vischeck}),
				success	: function(result){
					if (result==1) {
						getSummary();
						table.column(2).data().each( function (value, index) {
							 if (value==vlinse_id) {
								 table.cell( index, 30 ).data(vischeck);
							 }
						} );
						getSelectAll();
						flashnotif('Sukses','Data Berhasil di '+st_check+'!','success' );
					} else {
						 flashnotif('Error','Data Gagal di '+st_check+'!','error' );
					}
					
				}
			});	
	}

	function getSelectAll()
	{
		vis_checkAll=1;
		var a=0;
		table.column(30).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll=0;
			} 
		});
		//console.log(vis_checkAll+"-"+a);
		if(vis_checkAll==1){
			$("#checkboxAll").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll").prop('checked',false).removeAttr("disabled");
		}
		
		vid_lines = "";
		var i = 0;
		table.column(2).data().each( function (value, index) {
			//console.log( 'Data in index: '+index+' is: '+value );
			i++;
			if(i==1){
				vid_lines += value;
			} else {
				vid_lines +=" ,"+value;
			}
		});
		//console.log(vid_lines);
		
		if(a==0){
			$("#checkboxAll").prop('checked',false).attr("disabled",true);
		}
	}
	
	function getStart()
	{
		$.ajax({
			url		: "<?php echo site_url('ppn_wapu/get_start') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:$("#bulan").val(),tahun:$("#tahun").val(), pembetulan:$("#pembetulanKe").val()}),
			success	: function(result){
				if (result.isSuccess==1) {	
					console.log(result.status);
					if(result.status_period=="OPEN"){
						if(result.status=="DRAFT" || result.status=="REJECT SUPERVISOR" || result.status=="REJECT BY PUSAT"){
							$("#btnSubmit").slideDown(700);
							$("#btnAdd").removeAttr("disabled");
						} else {
							$("#btnSubmit").slideUp(700);
							$("#btnAdd").attr("disabled",true);
						}
					} else {
						$("#btnSubmit").slideUp(700);
						$("#btnAdd").attr("disabled", true);
					}
					// $("#lblStatus").html(result.status+" - "+result.status_period);
					 $("#keterangan").val(result.keterangan); 
				} else {
					 //$("#lblStatus").html("-----");
					 $("#keterangan").val("");
					 $("#btnAdd").attr("disabled", true);
					 $("#btnSubmit").slideUp(700);
				}
			}
		});	
	}
	
			
	$("#dpp, #tarif").on("keyup blur",function(){
		var jmldpp 		=$("#dpp").val();
		var jmltarif 	=$("#tarif").val();
		var jmlpotong	= jmltarif * jmldpp/100;
		$("#jumlahpotong").val(number_format(jmlpotong,2,'.',','));
	});
	
	$("#dpp").on("keyup blur",function(){
		var njmldpp 	= $("#dpp").val();
		var njmlppn		= njmldpp * 10/100;
		$("#jlhppn").val(number_format(njmlppn,2,'.',','));
	});
	
	$("#btnDelete").click(function(){
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
						url		: "<?php echo site_url('ppn_wapu/delete_rekonsiliasi') ?>",
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading");
							},
						success	: function(result){
							if (result==1) {
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
	
	/*$("#btnImportCSV").on("click", function(){
		$.ajax({
			url		: "<?php echo site_url('ppn_wapu/import_CSV') ?>",
			type	: "POST",
			beforeSend	: function(){
				 $("body").addClass("loading");
				},
			success	: function(result){
				if (result==1) {
					 table.draw();
					 $("body").removeClass("loading");
					 flashnotif('Sukses','Data Berhasil di Import!','success' );
				} else {
					 $("body").removeClass("loading");
					 flashnotif('Error','Data Gagal di Import!','error' );
				}
				
			}
		});	
	});*/

	$("#checkboxAll").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist"; 
		 }			
		 
		$.ajax({
			url		: "<?php echo site_url('ppn_wapu/get_selectAll') ?>",
			type	: "POST",
			data	: ({id_lines:vid_lines,vcheck:vischeckAll}),
			success	: function(result){
				if (result==1) {
					if(vischeckAll==1){
						$(".checklist").prop('checked',true);
					} else {
						$(".checklist").prop('checked',false);
					}
					table.column(2).data().each( function (value, index) {
						table.cell( index, 30 ).data(vischeckAll);	
					} );
					getSummary();
					flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );
				} else {
					flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
				}
				
			}
		});
	});
	
//Awal modal get nama wp====================================================================================================
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
	vorganization		= "";
	vkodecabang			= "";
	vpembetulan			= "";
	vjlhppn				= "";
	vdigitthn			= "";
	vtgltagih			= "";
	vtglsetorppn		= "";
	vtglsetorppnbm		= "";
	vpbm				= "";
	vkdlampiran			= "2";
	vkdtransaksi		= "";
	vkdstatus			= "3";
	vkddokumen			= "";
	vvendor_site_id		= "";
	vmatauang			= "";
	
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
	$("#organization_id").val("");
	$("#kode_cabang").val("");
	$("#pembetulan_ke").val("");
	$("#jlhppn").val("");
	$("#digitthn").val("");
	$("#tgltagih").val("");
	$("#tglsetorppn").val("");
	$("#tglsetorppnbm").val("");
	$("#jlhpbm").val("");
	$("#kdlampiran").val("2");
	$("#kdtransaksi").val("");
	$("#kdstatus").val("3");
	$("#kddokumen").val("");
	$("#vendor_site_id").val("");	
	
	table.$('tr.selected').removeClass('selected');
	$('.DTFC_Cloned tr.selected').removeClass('selected');	
	$("#btnEdit, #btnDelete").attr("disabled",true);	
	$( ".datepicker-autoclose" ).removeAttr( "disabled");
	//$("#dpp, #invoicenumber, #nobupot, #glaccount, #kode_cabang, #jlhpbm").removeAttr('readonly');
	$("#getkodepajak").removeAttr("disabled");
	
	var j 	= $("#jenisPajak").find(":selected").attr("data-name");
	var b	= $("#bulan").find(":selected").attr("data-name");
	var t	= $("#tahun").val();
	
	$("#capAdd").html("<span class='label label-danger'>Tambah Data "+j+" Bulan "+b+" Tahun "+t+"</span>");
}
$("#getnamawp").on("click", function(){
		vid		        = "";
		vnama	        = "";
		valamat	        = "";
		vnpwp	        = "";
		vorganization   = "";
		vvendor_site_id = "";
		$("#btnChoice").attr("disabled",true);
		
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-namawp' ) ) {
			$('#tabledata-namawp').DataTable({
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: "<?php echo site_url('ppn_wapu/load_master'); ?>",
									 "type" 		: "POST"
								  },
				 "language"		: {
						"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",
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
					vorganization   = "";
					vvendor_site_id   = "";
				} else {
					table_wp.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var d			= table_wp.row( this ).data();
					vid		        = d.vendor_id;
					vorganization   = d.organization_id;
					vvendor_site_id = d.vendor_site_id;
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
				vorganization   = d.organization_id;
				vvendor_site_id	= d.vendor_site_id;
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
		$("#organization_id").val(vorganization);
		$("#vendor_site_id").val(vvendor_site_id);
		$("#namawp").val(vnama);
		$("#npwp").val(vnpwp);
		$("#alamat").val(valamat);
		$("#modal-namawp").modal("hide");
	}
	
	function batal()
	{
		vid		        			= "";
		vnama	        			= "";
		valamat	        			= "";
		vnpwp	        			= "";
		vtanggalfakturpajak	       	= "";
		vdigitthn	       			= "";
		vnofakturpajak	       		= "";
		vtgltagih	       			= "";
		vtglsetorppn	       		= "";
		vtglsetorppnbm	       		= "";
		vjlhppn						= "";
		vpbm						= "";
		vkdlampiran					= "";
		vkdtransaksi				= "";
		vkdstatus					= "";
		vkddokumen					= "";
		vmatauang					= "";
	}

//Akhir modal get nama wp===================================================================================================
	
	
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
											 "url"  		: "<?php echo site_url(); ?>ppn_wapu/load_master_kode_pajak/"+$("#jenisPajak").val(),
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",
								"infoEmpty"		: "Data Kosong",
								"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
								"search"		: "_INPUT_"
							},
						   "columns": [
								{ "data": "no", "class":"text-center" },
								{ "data": "tax_code", "class":"text-center" },
								{ "data": "jenis_23" },
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
											 "url"  		: "<?php echo site_url(); ?>ppn_wapu/load_master_kode_pajak/"+$("#jenisPajak").val(),
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",
								"infoEmpty"		: "Empty Data",
								"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
								"search"		: "_INPUT_"
							},
						   "columns": [
								{ "data": "no", "class":"text-center" },
								{ "data": "tax_code", "class":"text-center" },
								{ "data": "jenis_23" },
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
