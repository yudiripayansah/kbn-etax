<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
		
	<div class="white-box boxshadow">
	<div class="row">
			 <!-- <div class="col-lg-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx" name="cabang_trx">
						<option value="" data-name="" selected >-- Pilih --</option>						
						<option value="000" data-name="Kantor Pusat" >Kantor Pusat</option> 
						<option value="010" data-name="Tanjung Priok" >Tanjung Priok</option>					
					</select> 
				</div>
			 </div> -->
			 <div class="col-lg-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx" name="cabang_trx">									
					</select> 
				</div>
			 </div>
		</div>	
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
						<option value="PPN WAPU" data-name="PPN WAPU" >PPN WAPU</option>
					</select> 
				</div>
			 </div>

			 <div class="col-lg-2">	
				<div class="form-group">
				<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="0" selected >0</option> 
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
		 <!--
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-10">
				<div class="form-group">
					<label>&nbsp;</label>
					<div class="navbar-right">
						<h4><small>STATUS </small><div id="divStatus"><span id="lblStatus" class='label label-danger'></span></div></h4>
					</div>
				</div>
			</div>
			-->
		 
			 
		</div>		
		
	 </div>
	
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar Data Rekonsiliasi</a>
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
													<th>ALAMAT WP</th>
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

            <!-- <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary">Ringkasan Rekonsiliasi</a>
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
								<div class="panel-footer"> </div>
							</div>
						</div>						
					</div>
                </div>
            </div> -->
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
							 </div>
							</div>				
						</div>							
					 </div>					 
				 <!-- Akhir Detail Selisih ====================================================================================== -->
	
	<div class="row">
		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel  panel-default boxshadow animated slideInDown">
			<div class="panel-heading">
               Keterangan
            </div>
				 <div class="panel-body"> 
					<div class="row">
						 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
                              <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Write your text here..."></textarea>
							</div>
						 </div>						
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
</div>
</div>

</div>


<script>
    $(document).ready(function() {
			var table	= "", vkodepajak="", vnamapajak = "", vbulan="", vnmbulan = "",vtahun = "";		
			valueAdd();	
			getStart();
			getSummary();
			getSelectCabang();	
						
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_approv_pusat'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#cabang_trx').val();
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
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama Pajak...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
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
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		} );
		
		$("#btnView").on("click", function(){
			valueAdd();
			getStart();
			getSummary();
			table.ajax.reload();			
		});
		
		
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
						url		: "<?php echo site_url('ppn_wapu/save_approv_pusat') ?>",
						type	: "POST",
						data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak,ket:vket,st:1,pembetulan:$('#pembetulanKe').val(), cabang:$("#cabang_trx").val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 table.draw();
								 $("body").removeClass("loading");
								 flashnotif('Sukses','Data Berhasil di Approv!','success' );
								 $("#keterangan").val("");
							} else if (result==2) {
								 getStart();
								 table.draw();								  
								 $("body").removeClass("loading");
								 flashnotif('Info','Prosedur Faktur gagal!','warning' );
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
						url		: "<?php echo site_url('ppn_wapu/save_approv_pusat') ?>",
						type	: "POST",
						data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak,ket:vket,st:0,pembetulan:$('#pembetulanKe').val(),cabang:$("#cabang_trx").val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							if (result==1) {
								 getStart();
								 getSummary();
								 table.draw();								  
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
		vkodepajak	= $("#jenisPajak").val();
		vnamapajak 	= $("#jenisPajak").find(":selected").attr("data-name");
		vbulan		= $("#bulan").val();
		vnmbulan	= $("#bulan").find(":selected").attr("data-name");
		vtahun		= $("#tahun").val();		
	}
	
	function getStart()
	{
		
		$.ajax({
			url		: "<?php echo site_url('ppn_wapu/get_start_pusat') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:vbulan,tahun:vtahun,pasal:vkodepajak, pembetulan:$("#pembetulanKe").val(),cabang:$("#cabang_trx").val()}),			
			success	: function(result){
				if (result.isSuccess==1) {	
					if(result.status_period=="OPEN"){ 
						if(result.status=="APPROVAL SUPERVISOR"){
							$("#btnApprov, #btnReject").slideDown(700);
						} else if(result.status=="APPROVED BY PUSAT"){
							$("#btnApprov").slideUp(700);
							$("#btnReject").slideDown(700);
						} else {
							$("#btnApprov, #btnReject").slideUp(700);
						}
					} else {
						$("#btnApprov, #btnReject").slideUp(700);
					}						 
				} else {
					$("#btnApprov, #btnReject").slideUp(700);
				}				
			}			
		});	
	}

	function getSummary()
	{		

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll1' ) ) {
		 $('#tabledata-summaryAll1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_summary_rekonsiliasiAll1_pusat'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#cabang_trx').val();
										d._step				= "APPROV";
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
								 "url"  		: "<?php echo site_url('ppn_wapu/load_detail_summary_pusat'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchCabang		= $('#cabang_trx').val();
										d._searchTipe		= "APPROV";
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
			url		: "<?php echo site_url('ppn_wapu/load_total_detail_summary_pusat') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPembetulan: $('#pembetulanKe').val(), _searchCabang : $('#cabang_trx').val(), _searchTipe : "APPROV" }),
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

	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_master_cabang') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#cabang_trx").html("");					
					$("#cabang_trx").html(result);					
				}
		});			
	}
	
	
 });
    </script>
