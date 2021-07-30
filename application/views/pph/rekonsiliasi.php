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
						 $bln = date('m');
						 /*if ($bln>1){
						 	$bln     = $bln-1;
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
							$tahun  = date('Y');
							$tAwal  = $tahun - 5;
							$tAkhir = $tahun;
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
						<option value="" data-name="" ></option>	
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
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
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
						<label>Export Format CSV</label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button id="btnEksportCSV" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>Export CSV</span></button>
						</div>
					</div>
				</div>
				</br>
			 </div>
		</div>
		 <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
			 <div class="white-box boxshadow">
				 <div class="row">
					 <form role="form" id="form-import" autocomplete="off">
						  <div class="col-lg-8">	
							<div class="form-group">
								<label class="form-control-label">File CSV</label>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
									<input type="file" id="file_csv" name="file_csv"> </span> <a id="aRemoveCSV" href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
								<input type="hidden" class="form-control" id="uplPph" name="uplPph">
							</div>
						  </div>						  
						  <div class="col-lg-4">	
							<div class="form-group">
							<label>&nbsp;</label>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button" disabled ><i class="fa fa-sign-in"></i> <span>Import CSV</span></button>								
								</div>
							</div>
						  </div>	  
					  </form> 
				  </div>
			 </div>
		</div>
	 </div>
	</div>
	<!--
	<button id="btnSendEmail" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Kirim Email</span></button>
	-->
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
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button>		
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
									<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> DELETE</button>
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
											<th>PAJAK HEADER ID</th>
											<th>AKUN PAJAK</th>
											<th>BULAN PAJAK</th>
											<th>TAHUN PAJAK</th>
											<th>MASA PAJAK</th>
											<th>ORGANIZATION ID</th>
											<th>VENDOR SITE ID</th>
											<th>NAMA WP</th>                                        
											<th>NPWP</th>
											<th>ALAMAT</th>
											<th>JENIS PAJAK</th>
											<th>INVOICE NUMBER</th>
											<th>NOMOR FAKTUR PAJAK</th>
											<th>TANGGAL FAKTUR PAJAK</th>
											<th>NO BUKTI POTONG</th>										
											<th>AKUN BEBAN</th>										
											<th>TANGGAL GL</th>										
											<th>KODE PAJAK</th>																				
											<th>MATA UANG</th>																				
											<th>DPP</th>
											<th>TARIF (%)</th>
											<th>JUMLAH POTONG</th>										
											<th>NEW KODE PAJAK</th>
											<th>NEW DPP</th>
											<th>NEW TARIF (%)</th>
											<th>NEW JUMLAH POTONG</th>
											<th>IS CHEKLIST</th>
										</tr>
									</thead>

								</table>
								</div> 
							<!--<div class="row">
								<div class="col-lg-2">
									<input type="text" class="form-control" id="keLine" name="keLine" placeholder="Ke Baris Nomor...." >
								</div>
							</div>-->
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
							<button id="btnsaldoAwal" class="btn btn-info btn-rounded custom-input-width" type="button" ><i class="fa fa fa-save"></i> <span>SAVE</span></button>
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
			<hr>
		</div>
		<div class="row">
			  <div class="col-lg-6 ">
				<div id="derror1" class="form-group">
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
					
					<div class="input-group">
						<input class="form-control" id="namawp" name="namawp" placeholder="Nama WP" type="text" disabled >
						<span class="input-group-btn">
						<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp" ><i class="fa fa-search"></i></button>
						</span> 
					</div>
					<div id="error1"></div>
				</div>
			  </div>
			   <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Pajak</label>
					<input class="form-control" id="kodepajak" name="kodepajak" placeholder="Kode Pajak" type="text" readonly >
					<!--<div class="input-group">
						<input class="form-control" id="kodepajak" name="kodepajak" placeholder="Kode Pajak" type="text" disabled >
						<span class="input-group-btn">
						<button type="button" id="getkodepajak" class="btn waves-effect waves-light btn-danger hide" data-toggle="modal" data-target="#modal-kodepajak" disabled ><i class="fa fa-search"></i></button>
						</span> 
					</div> -->
				</div>
			 </div>
			</div>
			<div class="row">
			  <div id="derror6" class="col-lg-6">
				<div class="form-group">
					<label>NPWP</label>
					<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP" disabled >
					<div id="error6"></div>
				</div>
			 </div>
			  <div class="col-lg-3">
				<div id="derror7" class="form-group">
					<label>Mata Uang</label>
					<input type="text" class="form-control" id="matauang" name="matauang" placeholder="Mata Uang" >	
					<input type="hidden" class="form-control" id="matauanghide" name="matauanghide">
					<div id="error7"></div>
				</div>
			 </div>
			 <div class="col-lg-3">
				<div class="form-group">
					<label>Tarif</label>
					<input class="form-control" id="tarif" name="tarif" placeholder="Tarif" type="text" maxlength="5" disabled >					
				</div>
			 </div>
			</div>	
			<div class="row">
			  <div class="col-lg-6">
				<div id="derror2" class="form-group">
					<label>Alamat</label>
					<textarea class="form-control" rows="5" id="alamat" name="alamat" placeholder="Alamat..." disabled > </textarea>
					<div id="error2"></div>
				</div>	
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">					
					<label>DPP</label>
					<input type="text" class="form-control" id="dpp" name="dpp" placeholder="DPP" disabled >					
				</div>	
				<div class="form-group">
					<label>Jumlah Potong</label>
					<input type="text" class="form-control" id="jumlahpotong" name="jumlahpotong" placeholder="Jumlah Potong" disabled >
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>Invoice Number</label>
					<input type="text" class="form-control" id="invoicenumber" name="invoicenumber" placeholder="Invoice Number" disabled >
				</div>	
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>No Faktur Pajak</label>
					<input type="text" class="form-control" id="nofakturpajak" name="nofakturpajak" placeholder="No Faktur Pajak" readonly >
				</div>	
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>No Bukti Potong</label>
					<input type="text" class="form-control" id="nobupot" name="nobupot" placeholder="Nomor Bukti Potong" disabled >
				</div>	
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Tanggal Faktur Pajak</label>
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tanggalfakturpajak" name="tanggalfakturpajak" placeholder="dd-mm-yyyy" disabled > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>	
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>GL Account / Akun Beban</label>
					<input type="text" class="form-control" id="glaccount" name="glaccount" placeholder="GL Account" >
				</div>	
			 </div> 
			 <div class="col-lg-6">	
				<div class="form-group">
					<label>Tanggal GL</label>
					<!--<input type="text" class="form-control" id="tanggalgl" name="tanggalgl" placeholder="Tanggal GL" disabled >-->
					<div class="input-group">
						<input type="text" class="form-control datepicker-autoclose" id="tanggalgl" name="tanggalgl" placeholder="dd-mm-yyyy" disabled > <span class="input-group-addon"><i class="icon-calender"></i></span> 
					</div>
				</div>	
			 </div>			 
			</div>
		</div>
		
		
		 <div class="white-box boxshadow">		
			<div class="row">
			  <div class="col-lg-6">
				<div id="derror3" class="form-group">
					<label>New Kode Pajak</label>
					<div class="input-group">
						<input class="form-control" id="newkodepajak" name="newkodepajak" placeholder="New Kode Pajak" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getNewkodepajak" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-newkodepajak" ><i class="fa fa-search"></i></button>
						</span> 
					</div>
					<div id="error3"></div>
				</div>
			 </div>
			  <div class="col-lg-6">
				<div id="derror5" class="form-group">
					<label>New DPP</label>
					<input type="text" class="form-control" id="newdpp" name="newdpp" placeholder="New DPP" >
					<div id="error5"></div>
				</div>	
			 </div>
			</div>				
			<div class="row">
			  <div class="col-lg-6">
				<div id="derror4" class="form-group">					
					<label>New Tarif</label>
					<input type="text" class="form-control" id="newtarif" name="newtarif" placeholder="New Tarif" maxlength="5" >
					<div id="error4"></div>
				</div>				
			 </div>
			  <div class="col-lg-6">
				<div id="dnewjumlahpotong" class="form-group">
					<label>New Jumlah Potong</label>
					<input type="text" class="form-control" id="newjumlahpotong" name="newjumlahpotong" placeholder="New Jumlah Potong"  >
				</div>
			  </div>
			</div>	
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> RESET</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
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
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel-kodepajak"><i class="fa fa-times-circle"></i>  CANCEL</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice-kodepajak" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
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
				<div class="row">
					<div class="col-md-4">
						<button type="button" class="btn btn-success waves-effect btn-rounded btn-block" id="exportKodePajak"><i class="fa fa-download fa-fw"></i>  EXPORT</button>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel-newkodepajak"><i class="fa fa-times-circle"></i>  CANCEL</button>
						<button type="button" class="btn btn-info waves-effect" id="btnChoice-newkodepajak" disabled ><i class="fa fa-plus-circle"></i> SELECT</button>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="alerttopright" class="myadmin-alert myadmin-alert-img alert-info myadmin-alert-top-right"> <img src="../plugins/images/users/genu.jpg" class="img" alt="img"><a href="#" class="closed">&times;</a>
<h4>You have a Message!</h4> <b>John Doe</b> sent you a message.</div>
<!-------------------------------------->
							
<script>
    $(document).ready(function() {
		$("#tambah-data").hide();		
		$("#d-FormCsv").hide();	
		//$("#btnAddRange").hide();
		
		var table	= "", table_wp="",table_kp="", table_newkodepajak="", vid = "",vnama = "", vnpwp ="", valamat="", vkodepajak="",vdpp="",vtarif="",vjumlahpotong="";	
		var vinvoicenum	= "", vnofakturpajak = "",vtanggalfakturpajak = "", vnewkodepajak ="", vnewtarif="", vnewdpp="",vnewjumlahpotong="", vidpajaklines="", vidpajakheader="", vnobupot="", vglaccount="",vnamapajak="", vakunpajak="", vbulanpajak="", vtahunpajak="",vmasapajak="",vorganization="";
		var vlinse_id ="",vcheckbox_id ="";
		var vvendor_site_id ="",vtanggalgl ="",vmatauang ="", vmatauanghide="";
		var vid_lines = "", vis_checkAll=1;		
		
		$("#dpp, #jumlahpotong,#newdpp, #newjumlahpotong, #saldoAwal").number(true,2);
		$("#tarif, #newtarif").number(true,2);				
		
		$('#modal-namawp, #modal-kodepajak, #modal-newkodepajak').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});					
		
		valueAdd();
		getStart();	
		getSummary();
		getSelectPajak();	
		
		 Pace.track(function(){  
		   $('#tabledata').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_rekonsiliasi'); ?>",
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
					{ "data": "checkbox", "class":"text-center" },
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "organization_id" },
					{ "data": "vendor_site_id" },
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "alamat_wp" },
					{ "data": "nama_pajak" },
					{ "data": "invoice_num" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "no_bukti_potong" },
					{ "data": "gl_account" },
					{ "data": "invoice_accounting_date" },
					{ "data": "kode_pajak" },					
					{ "data": "invoice_currency_code", "class":"text-center" },			
					{ "data": "dpp", "class":"text-right" },
					{ "data": "tarif", "class":"text-center" },
					{ "data": "jumlah_potong", "class":"text-right" },
					{ "data": "new_kode_pajak" },
					{ "data": "new_dpp", "class":"text-right" },	
					{ "data": "new_tarif", "class":"text-center" },
					{ "data": "new_jumlah_potong", "class":"text-right" },
					{ "data": "is_cheklist", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 2,3,4,5,6,7,8,9,10,30 ],					
					"visible": false
				} 
			],						
			"pageLength"		: 100,
			"lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "rowCallback": function( row, data, index ) {
				if ( data.new_kode_pajak == null || data.new_kode_pajak == "" ) {
					if ( data.kode_pajak == null || data.kode_pajak == "") {
						$('td:eq(1)', row).html( '<i style="color:#dd4b39; font-size:12px;"><b>'+data.no+'</b></i>' );						
					}				 				  
				}
				if ( data.new_tarif == null || data.new_tarif == "" ) {
					if ( data.tarif == null || data.tarif == "") {
						$('td:eq(1)', row).html( '<i style="color:#dd4b39; font-size:12px;"><b>'+data.no+'</b></i>' );						
					}				 				  
				}
				if ( data.nama_wp == null || data.nama_wp == "" || data.alamat_wp == null || data.alamat_wp == "" ) {
						$('td:eq(1)', row).html( '<i style="color:#dd4b39; font-size:12px;"><b>'+data.no+'</b></i>' );						
					}

				if ( data.gl_account == null || data.gl_account == "" || data.npwp == null || data.npwp == "") {
						$('td:eq(1)', row).html( '<i style="color:#dd4b39; font-size:12px;"><b>'+data.no+'</b></i>' );						
					}

				if ( data.new_dpp == 0 && data.dpp == 0) {
						$('td:eq(1)', row).html( '<i style="color:#dd4b39; font-size:12px;"><b>'+data.no+'</b></i>' );						
					}
			  }			
			 
			});
		 });
				
		table = $('#tabledata').DataTable();
		
		$("#list-data input[type=search]").addClear();		
		$('#list-data .dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/ Invoice/ Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
				
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			$(".checklist").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id"); 
				 actionCheck();
			 });				
			$("#btnEdit, #btnDelete").attr("disabled",true);
			getFormCSV(); 			
			getSelectAll();
						
			/* //Awal Buat Tombol Add Selisih/Tidak Dilaporkan ========================
			if (table.data().any()){
				$("#btnAddRange").slideDown(700);
			} else {
				$("#btnAddRange").slideUp(700);
			} */ //Akhir Buat Tombol Add Selisih/Tidak Dilaporkan ========================
		} );		
		
			
		$("#keLine").on("keyup", function(){
			console.log('ddd');
		});
		
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
				vvendor_site_id	    = d.vendor_site_id;
				vtanggalgl			= d.invoice_accounting_date;
				vmatauang			= d.invoice_currency_code;
				vmatauanghide		= d.invoice_currency_code;
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
			vvendor_site_id	    = d.vendor_site_id;
			vtanggalgl			= d.invoice_accounting_date;
			vmatauang			= d.invoice_currency_code;
			vmatauanghide		= d.invoice_currency_code;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit, #btnDelete").removeAttr('disabled');
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nobupot, #tanggalgl").attr('disabled', true);
			//$("#matauang").attr('readonly', true);
			//$("#getkodepajak").attr('disabled', true);			
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
		
		$("#aTitleList").on("click", function(){
			table.$('tr.selected').removeClass('selected');
			$("#btnEdit, #btnDelete").attr('disabled', true);
		});
		
		$("#btnSave").click(function(){
			var vnm		= $("#namawp").val();
			var vnpwp	= $("#npwp").val();
			var valmt	= $("#alamat").val();
			var vdpp_	= $("#dpp").val();
			var vnkp	= $("#newkodepajak").val();
			var vnt		= $("#newtarif").val();	
			var vjmlp	= $("#jumlahpotong").val();			
			var vnjmlp	= $("#newjumlahpotong").val();			
			var vndpp	= $("#newdpp").val();				
			var vmtu	= $("#matauang").val();				
			var vnpajak	= $("#jenisPajak").val();				
		
			$("#error1, #error2,#error3,#error4,#error5,#error6,#error7").html('');
			$("#derror1, #derror2,#derror3,#derror4,#derror5,#derror6,#derror7").removeClass("has-error");
			
			if (vnm=='' || vnm==null ){				
				set_error("error1","derror1","Nama WP belum diisi!");
				return false;
			}		
			/* if (vnpwp=='' || vnpwp==null || vnpwp=="-"){				
				set_error("error6","derror6","NPWP belum diisi!");
				return false;
			}	 */
			if (valmt=='' || valmt==null){				
				set_error("error2","derror2","Alamat WP belum diisi!");
				return false;
			}	
			
			if ($("#isNewRecord").val()==1){
				var vmtu	= $("#matauang").val();	
				if (vmtu=='' || vmtu==null){				
					set_error("error7","derror7","Mata uang belum diisi!");
					return false;
				}
			}
			
			/*if (vnpajak!="PPH PSL 22"){
				if (vnkp=='' || vnkp==null){				
					set_error("error3","derror3","New kode pajak belum diisi!");
					return false;
				}
			}*/
			/*if (vdpp_=='' || vdpp_==null || vdpp_=="0.00"){				
				set_error("error5","derror5","New DPP belum diisi!");
				return false;
			}*/			
			/*if (vnt=='' || vnt==null || vnt==0){				
				set_error("error4","derror4","Tarif belum diisi!");
				return false;
			}*/
			
		/* 	if(vmtu=="IDR"){
				var vrjmlp = vjmlp;
			} else {
				var vrjmlp = vnjmlp;
			}
			var njmldpp		= vrjmlp / (vnt/100);
			if (vndpp!=njmldpp){				
				set_error("error5","derror5","Jumlah DPP tidak sesuai perhitungan!");
				return false;
			} */		
			
			
			$.ajax({
				url		: "<?php echo site_url('pph/save_rekonsiliasi') ?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==1) {
						 table.draw();	
						 getSummary();
						 $("#list-data").slideDown(700);
						 $("#tambah-data").slideUp(700);
						 $("body").removeClass("loading");
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );						 
					} else if (result==2) {						 
						 $("body").removeClass("loading");						
						 flashnotif('Info','Nama WP / alamat WP belum diisi!','warning' );						
					} else if (result==4) {						 
						 $("body").removeClass("loading");						
						 flashnotif('Info','New kode pajak belum diisi!','warning' );						
					} else if (result==5) {						 
						 $("body").removeClass("loading");						
						 flashnotif('Info','New tarif belum diisi!','warning' );						
					} else if (result==6) {						 
						 $("body").removeClass("loading");						
						 flashnotif('Info','Jumlah DPP tidak sesuai perhitungan!','warning' );						
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}					
				}
			});	
		});
		
		$("#btnSendEmail").on("click", function(){
			console.log('asa');
			$.ajax({
				url		: "<?php echo site_url('pph/sendEmail') ?>",
				type	: "POST",
				//data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					/* if (result==1) {					
						 $("body").removeClass("loading");
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );						 
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}		 */	
					  $("body").removeClass("loading");
					 flashnotif('Sukses',result,'success' );		
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

		$("#exportKodePajak").on("click", function(){
				var url 	= baseURL + "pph/export_kode_pajak";
				var j		= $("#jenisPajak").val();
				window.open(url+'?tax='+j, '_blank');
				window.focus();
		});
		
		function cek_rekonsiliasi()
		{
			$.ajax({
				url		: "<?php echo site_url('pph/cek_row_rekonsiliasi') ?>",
				type	: "POST",
				dataType:"json", 
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
						$("body").addClass("loading");
					 },
				success	: function(result){
					console.log(result);
					if (result.st==1){						
						flashnotifnohide("info",result.data,"warning");
						$("body").removeClass("loading");
						return false;
					} else {
						$.ajax({
							url		: "<?php echo site_url('pph/submit_rekonsiliasi') ?>",
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
		
		$("#btnEdit").click(function (){
			$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			valueGrid();
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nobupot, #tanggalgl").attr('disabled', true);
			//$("#matauang").attr('readonly', true);
			//$("#getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+vnamapajak+" Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");	
		});	
	
	$("#btnEksportCSV").on("click", function(){
			var url 	="<?php echo site_url(); ?>pph/export_format_csv";
			var j		= $("#jenisPajak").val();
			var b		= $("#bulan").val();
			var t		= $("#tahun").val();
			var p		= $('#pembetulanKe').val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else {
				$.ajax({			
					url		: '<?php echo site_url() ?>pph/cek_data_csv'+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p,				
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

	$("#exportKodePajak").on("click", function(){
			var url 	= baseURL + "pph/export_kode_pajak";
			var j		= $("#jenisPajak").val();
			window.open(url+'?tax='+j, '_blank');
			window.focus();
	});
	
	$("#file_csv").on("change", function () {
        if($(this).val()==""){
			$("#btnImportCSV").attr("disabled",true);
		} else {
			$("#btnImportCSV").removeAttr("disabled");
		}
    });
	
	 $("#btnImportCSV").click(function(){       
        var form = $('#form-import')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('pph/import_CSV') ?>",
            data: data,
			beforeSend	: function(){
				 $("body").addClass("loading");					
			},
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {				
				if (result==1) {
                    table.ajax.reload();
					getSummary();
					$("body").removeClass("loading");
					flashnotif('Sukses','Data Berhasil di Import!','success' );	                    
					$("#aRemoveCSV").click();
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
	
	$("#btnsaldoAwal").on("click", function(){
		var j		= $("#jenisPajak").val();
		var b		= $("#bulan").val();
		var t		= $("#tahun").val();
		var p		= $('#pembetulanKe').val();
		
		var sal		= $("#saldoAwal").val();
		var mtsd	= $("#mutasiDebet").val();
		var mtsk	= $('#mutasiKredit').val();	
	
		$.ajax({
				url		: "<?php echo site_url('pph/save_saldo_awal') ?>",
				type	: "POST",
				data	: ({pajak:j, bulan:b, tahun:t, pembetulan:p, vsal:sal, vmtsd:mtsd, vmtsk:mtsk }),
				beforeSend	: function(){
					$("body").addClass("loading");
				 },
				success	: function(result){
					if (result==1) {						
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 getSummary();						 
					} else {
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}
					$("body").removeClass("loading");
				}
			});
	})
	
	function getSelectPajak()
	{
		$.ajax({
				url		: "<?php echo site_url('pph/load_master_pajak') ?>",
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
	
	function getSummary()
	{					
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_summary_rekonsiliasiAll1'); ?>",
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
			
			
			 $('#tabledata-summaryAll1').DataTable().on( 'draw', function () {
				$("#saldoAwal, #mutasiDebet,#mutasiKredit, #saldoAkhir, #jmlDibayarkan, #selisih, #tidakDilaporkan").number(true,2);
				$("#saldoAwal, #mutasiDebet, #mutasiKredit").on("keyup", function(){
					var saldo_akhir	= parseFloat($("#saldoAwal").val()) + ( parseFloat($("#mutasiDebet").val()) - parseFloat($("#mutasiKredit").val()) );
					if(saldo_akhir <0 || parseFloat($("#jmlDibayarkan").val() <0) ){
						var selisih		= parseFloat(saldo_akhir) + parseFloat($("#jmlDibayarkan").val());
					} else {
						var selisih		= parseFloat(saldo_akhir) - parseFloat($("#jmlDibayarkan").val());
					}					
					$("#saldoAkhir").val(number_format(saldo_akhir,2,".",","));
					$("#selisih").val(number_format(selisih,2,".",","));
				});				
				
			 });
			
			
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}
		
		/* Awal detail Summary======================================================= */
		if ( ! $.fn.DataTable.isDataTable( '#table-detail-summary' ) ) {
		$('#table-detail-summary').DataTable({	
			//"dom"			: "<'row'<'col-lg-6'l><'col-lg-6'f> > <'toolbarRange' >rtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_detail_summary'); ?>",
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
			
			
		} else {
			$('#table-detail-summary').DataTable().ajax.reload();
		}
				
		$.ajax({
			url		: "<?php echo site_url('pph/load_total_detail_summary') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchPph	: $('#jenisPajak').val(), _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchTipe : "REKONSILIASI" }),
			success	: function(result){										
					$("#dTotalselisih").html("<h4><strong>TOTAL SELISIH &nbsp; : &nbsp; </strong><span class='label label-info'>"+number_format(result.jml_tidak_dilaporkan,2,'.',',')+"</span></h4>" );
			}
		});	
		
		/* Akhir detail Summary======================================================= */
	}
	
	/* Awal Form Add Selisih/ Tidak dilaporkan ====================================================*/
	/* var vhtml	=	'<div class="row">'+
					'<div class="col-lg-12"><button type="button" class="btn btn-info waves-effect" id="btnAddRange" data-toggle="collapse" data-target="#fAddRange" aria-expanded="false" aria-controls="fAddRange" ><i id="iAddRange" class="fa fa-plus-circle"></i></button>'+
					'</div>'+
					'</div>';
		vhtml	+=	'<div class="collapse m-t-15" id="fAddRange">'+
					'<table class="table table-bordered"><tr><td>'+
					'<div class="row">'+
					' <div id="derror8" class="col-lg-2"><div class="form-group"><label>NPWP</label> <input class="form-control" id="rangeNpwp" name="rangeNpwp" placeholder="NPWP" type="text" > <div id="error8"></div> </div> </div>'+
					' <div class="col-lg-3"><div class="form-group"><label>NAMA</label>	<input class="form-control" id="rangeNama" name="rangeNama" placeholder="NAMA" type="text" > </div> </div>'+
					' <div class="col-lg-2"><div class="form-group"><label>DPP</label> <input class="form-control" id="rangeDpp" name="rangeDpp" placeholder="DPP" type="text" > </div> </div> '+
					' <div class="col-lg-2"><div class="form-group"><label>PPH/JUMLAH POTONG</label> <input class="form-control" id="rangePph" name="rangePph" placeholder="PPH/JUMLAH POTONG" type="text" > </div> </div>'+
					' <div class="col-lg-3"><div class="form-group"><label>KETERANGAN</label> <input class="form-control" id="rangeKet" name="rangeKet" placeholder="KETERANGAN" type="text" > </div> </div>'+
					'</div>'+
					'<div class="row">'+
					'<div class="col-lg-12 text-right"><button id="btnSaveRange" class="btn btn-info btn-rounded " type="button" ><i class="fa fa fa-save"></i> <span>Simpan</span></button></div>'+
					'</div>'+
					'</td></tr></table>'+
					'</div>';
	$("div.toolbarRange").html(vhtml);
	
	$("#btnSaveRange").click(function(){
			var vrnpwp	    = $("#rangeNpwp").val();
			var vrnama	    = $("#rangeNama").val();
			var vrdpp	    = $("#rangeDpp").val();
			var vrpph	    = $("#rangePph").val();
			var vrket	    = $("#rangeKet").val();
			var vrbln 	    = $('#bulan').val();
			var	vrthn 	    = $('#tahun').val();
			var	vrnmpajak	= $('#jenisPajak').val();
			var	vrpem	    = $('#pembetulanKe').val();

			if (vrnpwp==''){				
				set_error("error8","derror8","NPWP belum diisi!");
				return false;
			}	
		
			$.ajax({
				url		: "<?php echo site_url('pph/save_range_rekon') ?>",
				type	: "POST",
				data	: ({rnpwp:vrnpwp,rnama:vrnama,rdpp:vrdpp,rpph:vrpph,rket:vrket,vbln:vrbln,vthn:vrthn,vnmpajak:vrnmpajak,vpem:vrpem}),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==1) {
						 $('#table-detail-summary').DataTable().ajax.reload();
						 $("#fAddRange").collapse('hide');
						 $("body").removeClass("loading");
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );						 
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}					
				}
			});	
		});
		
	$('#btnAddRange').on( 'click', function () {
		$("#rangeDpp, #rangePph").number(true,2);	
		empetyAddRange();
	} );
	
	$("#fAddRange").on("show.bs.collapse", function(){
		$("#iAddRange").removeClass("fa-plus-circle");
		$("#iAddRange").addClass("fa-minus-circle"); 
		
		$("#btnAddRange").removeClass("btn-info");
		$("#btnAddRange").addClass("btn-danger"); 		
	});
	
	$("#fAddRange").on("hide.bs.collapse", function(){
		$("#iAddRange").removeClass("fa-minus-circle");
		$("#iAddRange").addClass("fa-plus-circle");
		
		$("#btnAddRange").removeClass("btn-danger");
		$("#btnAddRange").addClass("btn-info"); 		
	}); 
	
	function empetyAddRange(){
		var vrnpwp	    = $("#rangeNpwp").val("");
		var vrnama	    = $("#rangeNama").val("");
		var vrdpp	    = $("#rangeDpp").val("");
		var vrpph	    = $("#rangePph").val("");
		var vrket	    = $("#rangeKet").val("");
		$("#error8").html('');
		$("#derror8").removeClass("has-error");
	}
	
	function actionDelRange(vrid,vrcab,vrnama)
	{
		 bootbox.confirm({
			title: "Hapus data <span class='label label-danger'>"+vrnama+"</span> ?",
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
						url		: "<?php echo site_url('pph/delete_detail_range') ?>",
						type	: "POST",
						data	: ({rid:vrid,rcab:vrcab}),
						beforeSend	: function(){
							 $("body").addClass("loading");					
							},
						success	: function(result){
							if (result==1) {
								 getSummary();
								 $("body").removeClass("loading");
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
	} */
	
	/* Akhir Form Add Selisih/ Tidak dilaporkan ====================================================*/
	
	$('#table-detail-summary').DataTable().on( 'draw', function () {
		$(".delrange").on("click", function(){
			 var vrlinse_id 	= $(this).data("id");
			 var vrcabang		= $(this).data("cab");
			 var vrnama			= $(this).data("name");
			 actionDelRange(vrlinse_id,vrcabang,vrnama);			 
		});
		
	 });
	
	$("#dDetail-summary input[type=search]").addClear();		
	$('#dDetail-summary .dataTables_filter input[type="search"]').attr('placeholder','Cari No NPWP/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
	
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
		$("#vendor_site_id").val(vvendor_site_id);		
		$("#tanggalgl").val(vtanggalgl);		
		$("#matauang").val(vmatauang);
		$("#matauanghide").val(vmatauang);
		
		if (vmatauang=="IDR"){
			$("#dnewjumlahpotong").slideUp(700);
			$("#jumlahpotong").removeAttr("disabled");
			$("#jumlahpotong").attr("readonly",true);			
		} else {
			$("#dnewjumlahpotong").slideDown(700);
			$("#jumlahpotong").attr("disabled", true);
			$("#jumlahpotong").removeAttr("readonly");			
		}
		$("#error1, #error2,#error3,#error4,#error5,#error6,#error7").html('');
		$("#derror1, #derror2,#derror3,#derror4,#derror5,#derror6,#derror7").removeClass("has-error");
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
				url		: "<?php echo site_url('pph/check_rekonsiliasi') ?>",
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
	
	function getStart()
	{
		$.ajax({
			url		: "<?php echo site_url('pph/get_start') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:$("#bulan").val(),tahun:$("#tahun").val(),pasal:$("#jenisPajak").val(), pembetulan:$("#pembetulanKe").val() }),
			success	: function(result){
				if (result.isSuccess==1) {	
					//console.log(result.status);
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
		
		if(a==0){
			$("#checkboxAll").prop('checked',false).attr("disabled",true);
		}
	}
	
			
	$("#dpp, #tarif").on("keyup",function(){
		var jmldpp 		=$("#dpp").val();
		var jmltarif 	=$("#tarif").val();
		var jmlpotong	= jmltarif * jmldpp/100;
		$("#jumlahpotong").val(number_format(jmlpotong,2,'.',','));
	});
	
	$("#newjumlahpotong").on("keyup",function(){
		var njmlpotong 	= $("#newjumlahpotong").val();
		var njmltarif 	= $("#newtarif").val();
		var njmldpp		= njmlpotong / (njmltarif/100);
		$("#newdpp").val(number_format(njmldpp,2,'.',','));
	});
	
	$("#newtarif").on("keyup",function(){	
		var vmtu		= $("#matauang").val();	
		var njmltarif 	= $("#newtarif").val(); //pke ini krna yg jdi patokan
		if($("#isNewRecord").val()==1){
			var njmlpotong 	= $("#newjumlahpotong").val();
		} else {			
			if(vmtu=="IDR"){
				var njmlpotong 	= $("#jumlahpotong").val();
			} else {
				var njmlpotong 	= $("#newjumlahpotong").val();
			}		
		}
		var njmldpp		= njmlpotong / (njmltarif/100);
		$("#newdpp").val(number_format(njmldpp,2,'.',','));
	});
	
	$("#checkboxAll").on("click", function(){
		if($(this).prop('checked') == false){
			  var vischeckAll	= 0;
			  var st_checkAll	= "Unchecklist";			 
		 } else {
			 var vischeckAll	= 1;
			 var st_checkAll	= "Checklist";			  
		 }			
		 
		$.ajax({
			url		: "<?php echo site_url('pph/get_selectAll') ?>",
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
						url		: "<?php echo site_url('pph/delete_rekonsiliasi') ?>",
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
		//$("#jumlahpotong").removeAttr("disabled","readonly");
		$("#jumlahpotong").attr('disabled', true);
		empety();	
	});
	
	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empety();
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
	vvendor_site_id	    = "";
	vtanggalgl			= "";
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
	$("#vendor_site_id").val("");
	$("#tanggalgl").val("");
	$("#matauang").val("");			
	$("#matauanghide").val("");			
	
	table.$('tr.selected').removeClass('selected');
	$('.DTFC_Cloned tr.selected').removeClass('selected');	
	$("#btnEdit, #btnDelete").attr("disabled",true);	
	$( ".datepicker-autoclose" ).removeAttr( "disabled");
	//$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #tanggalgl").removeAttr('disabled');
	$("#invoicenumber, #nobupot, #tanggalgl").removeAttr('disabled');
	$("#matauang").removeAttr('readonly');
	//$("#getkodepajak").removeAttr("disabled");
	$("#dnewjumlahpotong").slideDown(700);
	
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

		jenisPajakNya = $("#jenisPajak").val();
		
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-namawp' ) ) {
			$('#tabledata-namawp').DataTable({
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: "<?php echo site_url('pph/load_master_wp'); ?>",
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
					vid		        = "";
					vnama	        = "";				
					valamat	        = "";
					vnpwp	        = "";
					vorganization   = "";					
					vvendor_site_id = "";					
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
				vvendor_site_id = d.vendor_site_id;
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
		vid		        = "";
		vnama	        = "";				
		valamat	        = "";
		vnpwp	        = "";		
	}

//Akhir modal get nama wp===================================================================================================
	
	
/*Awal GeKode Pajak --------------------------------------------- */
	/* $("#getkodepajak").on("click", function(){
			vkodepajak  = "";
			vtarif      = "";			
			$("#btnChoice-kodepajak").attr("disabled",true);
			$("#modal-kodepajak").on("shown.bs.modal", function () {
				if ( ! $.fn.DataTable.isDataTable( '#tabledata-kodepajak' ) ) {
					$('#tabledata-kodepajak').DataTable({
						"serverSide"	: true,
						"processing"	: true,
						"ajax"			: {
											 "url"  		: "<?php echo site_url(); ?>pph/load_master_kode_pajak/"+$("#jenisPajak").val(),	
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
					$('#modal-kodepajak .dataTables_filter input[type="search"]').attr('placeholder','Cari Kode/Tarif/Deskripsi Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
					
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
	}); */
	
	
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
			jenisPajakNya = $("#jenisPajak").val();
			vnewkodepajak   = "";	
			vnewtarif		= "";				
			$("#btnChoice-newkodepajak").attr("disabled",true);
			$("#modal-newkodepajak").on("shown.bs.modal", function () {
				if ( ! $.fn.DataTable.isDataTable( '#tabledata-newkodepajak' ) ) {
					$('#tabledata-newkodepajak').DataTable({
						"serverSide"	: true,
						"processing"	: true,
						"ajax"			: {
											 "url"  		: "<?php echo site_url(); ?>pph/load_master_kode_pajak/", 
											 "type" 		: "POST",
											 "data"	: function (d) {
													d.jenisPajak = jenisPajakNya;
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
					$('#modal-newkodepajak .dataTables_filter input[type="search"]').attr('placeholder','Cari Kode/Tarif/Deskripsi Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
					
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
				table_newkodepajak.draw();
			});
	});
	
	
	$("#btnChoice-newkodepajak").on("click",valueGridNewKodePajak);
	$("#btnCancel-newkodepajak").on("click",batalNewKodePajak);	
	
	function valueGridNewKodePajak()
	{
		$("#newkodepajak").val(vnewkodepajak);			
		$("#newtarif").val(vnewtarif);			
		$("#modal-newkodepajak").modal("hide");
		$("#newtarif").trigger("keyup");
	}
	
	function batalNewKodePajak()
	{
		vnewkodepajak	= "";
		vnewtarif		= "";		
	}		
	
/*Akhir New Kode Pajak --------------------------------------------- */	
	
 });
    </script>
