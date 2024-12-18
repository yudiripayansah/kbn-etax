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
	<div class="row">
		<div class="col-lg-12">
			<div class="panel-group boxshadow" id="accordion">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Daftar PPh</a></h4>
					</div>
					<div id="collapse-data" class="panel-collapse collapse in">
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
									<th>PEMBETULAN KE</th>
									<th>NPWP PEMOTONG</th>
									<th>NAMA PEMOTONG</th>
									<th>WP LUAR NEGERI</th>
									<th>KODE NEGARA</th>
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
	<!-- RINGKASAN -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel-group boxshadow" id="accordion">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary">Ringkasan Rekonsiliasi</a></h4>
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
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default boxshadow animated slideInDown">
				<div class="panel-body">
					<ul class="nav customtab nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Download</span></a></li>
						<li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Print</span></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade in active" id="tab-download">
							<div class="row">
								<div class="col-lg-12">
									<hr>
									<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-cetak">
							<div class="row">
								<div class="col-lg-12">
									<hr>
									<button type="button" id="btnSPTFinal" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> BP Final</button>
									<button type="button" id="btnSPTNonFinal" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> BP Non Final</button>
									<button type="button" id="btn1721a1" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> 1721A1</button>
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
			var table	= "", vkodepajak = "",vbulan = "", vtahun ="", vnoBuktiPotong ="";
			
		getSelectPajak();
		getSummary();
		
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('pph21/load_download'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	= $('#bulan').val();
										d._searchTahun 	= $('#tahun').val();
										d._searchPph	= $('#jenisPajak').val();
										d._searchTypePph 	= $('#jenisPajak').find(':selected').attr('data-type');
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
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "pajak_header_id" },
					{ "data": "akun_pajak" },
					{ "data": "bulan_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "masa_pajak" },
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
					{ "data": "pembetulan_ke" },
					{ "data": "npwp_pemotong" },
					{ "data": "nama_pemotong" },
					{ "data": "wpluarnegeri" },
					{ "data": "kode_negara" }
				],
			 "columnDefs": [ 
				 {
					"targets": [ 1,2,3,4,5,6,7,8,13,14,15,16,17,18,19,23,24,25,26,27],
					"visible": false
				} 
			], 			
			/* "fixedColumns"	:   {
					"leftColumns": 1
			},	 */	
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
		 });
		table = $('#tabledata').DataTable();	
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Nama WP/DPP/Jumlah Potong...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
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
	
	$("#btnCSV").on("click", function(){
		if (table.data().any()){
			 if(table.data().any()){
				data  = table.row(0).data();
			 }
			 pajak_header_id = data.pajak_header_id;
		}	
		var url1 	= baseURL + 'pph21/export_format_csv1/'+pajak_header_id+'/BULANAN';
		var url2 	= baseURL + 'pph21/export_format_csv1/'+pajak_header_id+'/BULANAN FINAL';
		var url3 	= baseURL + 'pph21/export_format_csv1/'+pajak_header_id+'/BULANAN NON FINAL';
		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url1);
			setTimeout(function () {
				window.open(url2);
			}, 1000);
			setTimeout(function () {
				window.open(url3);
			}, 2000);
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
								 "url"  		: "<?php echo site_url('pph21/load_summary_rekonsiliasiAll1'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPph		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
										d._searchTypePph 	= $('#jenisPajak').find(':selected').attr('data-type');
										d._step				= "DOWNLOAD";
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
	
	
	
	$("#btnSPTFinal").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph21/cetakSPT";
		vkodepajak	= $("#jenisPajak").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&final=TRUE','_blank');
			window.focus();
		}
	});
	
	$("#btnSPTNonFinal").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph21/cetakSPT";
		vkodepajak	= $("#jenisPajak").val();
		vbulan		= $("#bulan").val();
		vtahun		= $("#tahun").val();
		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun+'&final=FALSE','_blank');
			window.focus();
		}
	});

	$("#btn1721a1").on("click", function(){
		var url 	="<?php echo site_url(); ?>pph21/cetak_1721";
		vtahun		= $("#tahun").val();

		if (!table.data().any()){
			 flashnotif('Info','Data Kosong!','warning' );
			 exit();
		} else {
			window.open(url+'?year='+vtahun, '_blank');
			window.focus();
		}
	});
	
	
	
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
	
 });
    </script>
