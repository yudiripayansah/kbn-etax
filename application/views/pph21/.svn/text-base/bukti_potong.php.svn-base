<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
			

 <div id="list-data">
	 <div class="white-box boxshadow">	
		<div class="row"> 
			<div class="col-lg-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan">
						<option value="1" data-name="Januari" >Januari</option>
						<option value="2" data-name="Februari" selected >Februari</option>
						<option value="3" data-name="Maret" >Maret</option>
						<option value="4" data-name="April" >April</option>
						<option value="5" data-name="Mei" >Mei</option>
						<option value="6" data-name="Juni" >Juni</option>
						<option value="7" data-name="Juli" >Juli</option>
						<option value="8" data-name="Agustus" >Agustus</option>
						<option value="9" data-name="September" >September</option>
						<option value="10" data-name="Oktober" >Oktober</option>
						<option value="11" data-name="November" >November</option>
						<option value="12" data-name="Desember" >Desember</option>
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
								//$selected	= ($i==$tahun)?"selected":"";
								$selected	= "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}
							echo "<option value='2017' selected>2017</option>";
							echo "<option value='2018'>2018</option>";
						?>						
					</select> 
				</div>
			 </div>
			 <div class="col-lg-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN" selected >PPh Pasal 21 Bulanan</option>
						<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN FINAL" >PPh Pasal 21 Final</option>
						<option value="PPH PSL 21" data-name="PPH PSL 21" data-type="BULANAN NON FINAL" >PPh Pasal 21 Tidak Final</option>
					</select> 
				</div>
			 </div>
			 <div class="col-lg-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Tampil</span></button>
				</div>
			  </div>
			 
		</div>
	 </div>
	 
	<div class="row"> 	
                <div class="col-lg-12">	
                    <div class="panel panel-info boxshadow animated slideInDown">
                        <div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								List Data Bukti Potong
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">								 
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> Tambah</button>									
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
									<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> HAPUS</button>
								</div>
							  </div>
							</div>  						   
						</div>
                       
                        <div class="panel-body"> 
							<div class="table-responsive">                          
							<table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>PAJAK LINE ID</th>
                                        <th>VENDOR ID</th>
                                        <th>PAJAK HEADER ID</th>
                                        <th>AKUN PAJAK</th>
                                        <th>BULAN PAJAK</th>
                                        <th>TAHUN PAJAK</th>
                                        <th>MASA PAJAK</th>
                                        <th>NAMA WP</th>                                        
                                        <th>NPWP</th>
										<th>ALAMAT</th>
										<th>JENIS PAJAK</th>
										<th>PEMBETULAN</th>
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
				<h2 id="capAdd" class="text-center"></h2>
			</div>			
		</div>
		
		<div class="row">
			<hr>
		</div>
		<div class="row">
			  <div class="col-lg-6 ">
				<div class="form-group">
					<label>Nama WP</label>
					<input type="hidden" class="form-control" id="idPajakHeader" name="idPajakHeader">
					<input type="hidden" class="form-control" id="idPajakLines" name="idPajakLines">
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
					
					<div class="input-group">
						<input class="form-control" id="namawp" name="namawp" placeholder="Nama WP" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getnamawp" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-namawp" disabled ><i class="fa fa-search"></i></button>
						</span> 
					</div>					
				</div>
			  </div>
			   <div class="col-lg-6">
				<div class="form-group">
					<label>Kode Pajak</label>
					<div class="input-group">
						<input class="form-control" id="kodepajak" name="kodepajak" placeholder="Kode Pajak" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getkodepajak" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-kodepajak" disabled ><i class="fa fa-search"></i></button>
						</span> 
					</div>
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>NPWP</label>
					<input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP" readonly>
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>Tarif</label>
					<input class="form-control" id="tarif" name="tarif" placeholder="Tarif" type="text" maxlength="3" readonly>					
				</div>
			 </div>
			</div>	
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>Alamat</label>
					<textarea class="form-control" rows="5" id="alamat" name="alamat" placeholder="Alamat..." readonly></textarea>
				</div>	
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">					
					<label>DPP</label>
					<input type="text" class="form-control" id="dpp" name="dpp" placeholder="DPP" readonly>
				</div>	
				<div class="form-group">
					<label>Jumlah Potong</label>
					<input type="text" class="form-control" id="jumlahpotong" name="jumlahpotong" placeholder="Jumlah Potong" readonly >
				</div>
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>Invoice Number</label>
					<input type="text" class="form-control" id="invoicenumber" name="invoicenumber" placeholder="Invoice Number" readonly >
				</div>	
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>No Faktur Pajak</label>
					<input type="text" class="form-control" id="nofakturpajak" name="nofakturpajak" placeholder="No Faktur Pajak" readonly>
				</div>	
			 </div>
			</div>
			<div class="row">
			  <div class="col-lg-6">	
				<div class="form-group">
					<label>No Bukti Potong</label>
					<input type="text" class="form-control" id="nobupot" name="nobupot" placeholder="Nomor Bukti Potong" readonly >
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
					<label>GL Account</label>
					<input type="text" class="form-control" id="glaccount" name="glaccount" placeholder="GL Account" readonly >
				</div>	
			 </div>	
			<div class="col-lg-6">	
				<div class="form-group">
					<label>Pembetulan</label>
					<input type="text" class="form-control" id="pembetulan" name="pembetulan" placeholder="Pembetulan" maxlength="1" >
				</div>	
			 </div>	
			</div>
		</div>
		
		
		 <div class="white-box boxshadow">		
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">
					<label>New Kode Pajak</label>
					<div class="input-group">
						<input class="form-control" id="newkodepajak" name="newkodepajak" placeholder="New Kode Pajak" type="text" readonly>
						<span class="input-group-btn">
						<button type="button" id="getNewkodepajak" class="btn waves-effect waves-light btn-danger" data-toggle="modal" data-target="#modal-newkodepajak" ><i class="fa fa-search"></i></button>
						</span> 
					</div>
				</div>
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>New DPP</label>
					<input type="text" class="form-control" id="newdpp" name="newdpp" placeholder="New DPP" >
				</div>	
			 </div>
			</div>				
			<div class="row">
			  <div class="col-lg-6">
				<div class="form-group">					
					<label>New Tarif</label>
					<input type="text" class="form-control" id="newtarif" name="newtarif" placeholder="New Tarif" maxlength="3" readonly >
				</div>				
			 </div>
			  <div class="col-lg-6">
				<div class="form-group">
					<label>New Jumlah Potong</label>
					<input type="text" class="form-control" id="newjumlahpotong" name="newjumlahpotong" placeholder="New Jumlah Potong" readonly >
				</div>	
			 </div>
			</div>	
			<div class="row">
			   <div class="col-lg-12">
					 <div class="form-group">
						   <div class="navbar-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>					
							<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> Kembali</button>
							<button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
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
								<th>NAMA WP</th>
								<th>ALAMAT</th>
								<th>NPWP</th>								
							</tr>
						</thead>
					</table>
				</div>  
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i>  Batal</button>
				<button type="button" class="btn btn-info waves-effect" id="btnChoice" disabled ><i class="fa fa-plus-circle"></i> Pilih</button>
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
		var table	= "", table_wp="",table_kp="", table_newkodepajak="", vid = "",vnama = "", vnpwp ="", valamat="", vkodepajak="",vdpp="",vtarif="",vjumlahpotong="";	
		var vinvoicenum	= "", vnofakturpajak = "",vtanggalfakturpajak = "", vnewkodepajak ="", vnewtarif="", vnewdpp="",vnewjumlahpotong="", vidpajaklines="", vidpajakheader="", vnobupot="", vglaccount="",vnamapajak="", vakunpajak="", vbulanpajak="", vtahunpajak="",vmasapajak="",vpembetulan="";
		
		$("#dpp, #jumlahpotong,#newdpp, #newjumlahpotong").number(true,2);
		$("#tarif, #newtarif, #pembetulan").number(true);
		$("#tambah-data").hide();		
		
		$('#modal-namawp, #modal-kodepajak, #modal-newkodepajak').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});					
		
		valueAdd();
				
		 Pace.track(function(){  
		 $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_bukti_potong'); ?>",
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "Data Tidak Ditemukan!",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "alamat_wp" },
					{ "data": "nama_pajak" },
					{ "data": "pembetulan" },
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
					"targets": [ 1,2,3,4,5,6, 7 ],
					"visible": false
				} 
			],			
			"fixedColumns"	:   {
					"leftColumns": 1
			},		
			 "select"			: true,
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();
		
		$("#list-data input[type=search]").addClear();		
		$('#list-data .dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/Nama Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			$("#btnEdit, #btnDelete").attr("disabled",true);
			  
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
				vpembetulan    		= d.pembetulan;
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
			vpembetulan    		= d.pembetulan;
			$("#isNewRecord").val("0");
			valueGrid();			
			$("#btnEdit, #btnDelete").removeAttr('disabled');
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);			
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+vnamapajak+" Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
		} );
		
		
		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		
		
		$("#btnView").on("click", function(){			
			valueAdd();
			table.ajax.reload();			
		});
		
		$("#bulan, #tahun, #jenisPajak").on("change", function(){
			valueAdd();			
		});
		
		$("#btnSave").click(function(){				
			$.ajax({
				url		: "<?php echo site_url('pph21/save_bukti_potong') ?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
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
		
		$("#btnEdit").click(function (){
			$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			valueGrid();
			$( ".datepicker-autoclose" ).attr( "disabled", true );
			$("#dpp, #invoicenumber, #nofakturpajak, #nobupot, #glaccount").attr('readonly', true);
			$("#getnamawp, #getkodepajak").attr('disabled', true);
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+vnamapajak+" Bulan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
		});
	
	function valueAdd()
	{
		$("#fAddAkun").val($("#jenisPajak").val());
		$("#fAddNamaAkun").val($("#jenisPajak").find(":selected").attr("data-name"));
		$("#fAddBulan").val($("#bulan").val());
		$("#fAddTahun").val($("#tahun").val());
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
		$("#pembetulan").val(vpembetulan);
		
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
						url		: "<?php echo site_url('pph21/delete_bukti_potong') ?>",
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
	vpembetulan			= "";
	
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
	$("#pembetulan").val("");
	
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
									 "url"  		: "<?php echo site_url('pph21/load_master_wp'); ?>",
									 "type" 		: "POST"
								  },
				 "language"		: {
						"emptyTable"	: "Data Tidak Ditemukan!",	
						"infoEmpty"		: "Data Kosong",
						"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
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
						"targets": [ 1 ],
						"visible": false
					} 
				],
				"fixedColumns"	:   {
					"leftColumns": 1
				},	
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
											 "url"  		: "<?php echo site_url('pph21/load_master_kode_pajak'); ?>",
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "Data Tidak Ditemukan!",	
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
						 "fixedColumns"	:   {
									"leftColumns": 1
							},	
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
											 "url"  		: "<?php echo site_url('pph21/load_master_kode_pajak'); ?>",
											 "type" 		: "POST"
										  },
						 "language"		: {
								"emptyTable"	: "Data Tidak Ditemukan!",	
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
