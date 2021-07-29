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
						 $bln = date('m');
						/* if ($bln>1){
							 $bln		= $bln - 1;
							 $tahun_n	= 0;
						 } else {
							 $bln		= 12;
							 $tahun_n	= 1;
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
	 
	<div class="row">
                <div class="col-lg-12">	                  
					 <div class="panel-group boxshadow" id="accordion">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar PPh</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>#</th>
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
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box boxshadow animated slideInDown">			
			<ul class="nav customtab nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Download</span></a></li>
				<li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Print</span></a></li>
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab-download">
					<div class="col-lg-12">
						<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
						<button type="button" id="btnbupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> EBUPOT</button>					
					</div>
					<div class="clearfix"></div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tab-cetak">
					<div class="col-lg-12">						
						 <button type="button" id="btnAllBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> All Bupot</button>
						 <button type="button" id="btnBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Single Bupot</button>
						 <button type="button" id="btnDaftar" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> List Bupot</button>						
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
			var table	= "", vkodepajak = "",vbulan = "", vtahun ="", vnoBuktiPotong ="";
			
		getSelectPajak();
		getSummary();
		
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph/load_download'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	    = $('#bulan').val();
										d._searchTahun 	    = $('#tahun').val();
										d._searchPph	    = $('#jenisPajak').val();
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
					{ "data": "new_jumlah_potong", "class":"text-right" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 2,3,4,5,6,7,8,9,10 ],
					"visible": false
				} 
			],				
			 "pageLength"		: 100,
			 "scrollY"			: 350, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			// "order"			:  [[ 24, 'asc' ]]			
			});
		 });
		
		table = $('#tabledata').DataTable();	
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
				
		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vnoBuktiPotong = "";
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');	
				var d			    = table.row( this ).data();
				vnoBuktiPotong      = d.no_bukti_potong;
			}			
		}).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table.row( this ).data();
			vnoBuktiPotong      = d.no_bukti_potong;
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
		getSummary();
	});


	if ($("#jenisPajak").val() != 'PPH PSL 23 DAN 26'){
		$("#btnbupot").css("display", "none");
	}else{
		$("#btnbupot").css("display", "inline-block");
	}

	$("#jenisPajak").on("change", function(){
		jnspjk = $(this).val();
		if (jnspjk != 'PPH PSL 23 DAN 26'){
			$("#btnbupot").css("display", "none");
		}else{
			$("#btnbupot").css("display", "inline-block");
		}
	});
	
	$("#btnCSV").on("click", function(){			
			var url 	="<?php echo site_url(); ?>pph/export_jns_csv";
			vkodepajak	= $("#jenisPajak").val();
			vbulan		= $("#bulan").val();
			vtahun		= $("#tahun").val();
			vpembetulan	= $("#pembetulanKe").val();
			
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 exit();
			} else {
				//window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&p='+vpembetulan+'&com=false&cab=true&valuecab=', '_blank');
				window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&p='+vpembetulan, '_blank');
				window.focus(); 				
			}
	});

	$("#btnbupot").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph/cetak_bupot";
		vpembetulan	= $("#pembetulanKe").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?pembetulanKe='+vpembetulan+'&bulan='+vbulan+'&tahun='+vtahun,'_blank');
			window.focus();
		}
	});
    	
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
	
	$("#btnAllBupot").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph/cetakPphNew";
		vkodepajak	= $("#jenisPajak").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		vpembetulan	= $('#pembetulanKe').val();

		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&pembetulan='+vpembetulan+'&type=all'+'&isCabang=true', '_blank');
			window.focus();
		}
	});
	
	$('#btnBupot').on("click",function () {
		
			if (vnoBuktiPotong=="" || vnoBuktiPotong==null|| vnoBuktiPotong==undefined ){
				flashnotif('Info','Data Belum dipilih','warning' );
				return false;
			}
			console.log(vnoBuktiPotong);
			var url 	="<?php echo site_url(); ?>pph/cetakPphNew";
			vkodepajak	= $("#jenisPajak").val();
			vbulan		= $("#bulan").val();
			vtahun		= $("#tahun").val();			
			vpembetulan	= $("#pembetulanKe").val();
			
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 exit();
			} else {
				window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&pembetulan='+vpembetulan+'&type=single'+'&nf='+vnoBuktiPotong+'&isCabang=true', '_blank');
				window.focus();
			}
			
	});
	
	$("#btnDaftar").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph/cetakPphBuktiPotong";
		vkodepajak	= $("#jenisPajak").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		vpembetulan	= $("#pembetulanKe").val();
		
		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&pembetulan='+vpembetulan+'&isCabang=true', '_blank');
			window.focus();
		}
	});
	
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
										d._step				= "DOWNLOAD";
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
			
			 
		} else {
			$('#tabledata-summaryAll1').DataTable().ajax.reload();
		}	
		
		
	}
	
		
 });
    </script>
