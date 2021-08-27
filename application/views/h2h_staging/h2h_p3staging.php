<div class="container-fluid">
		
    <?php $this->load->view('template_top') ?>

	<div class="white-box boxshadow">
		<form role="form" id="form-wp">
		<?php  
			$vthiscabang = $this->session->userdata('kd_cabang');
		?>
		<input type="hidden" id="kd_cabang" value="<?php echo $this->session->userdata('kd_cabang') ?>">
		<input type="hidden" class="form-control" id="DOCNUMBER" name="DOCNUMBER">
		<input type="hidden" class="form-control" id="JENIS_PAJAK" name="JENIS_PAJAK">
		<input type="hidden" class="form-control" id="BULAN_PAJAK" name="BULAN_PAJAK">
		<input type="hidden" class="form-control" id="TAHUN_PAJAK" name="TAHUN_PAJAK">
		<input type="hidden" class="form-control" id="PEMBETULAN" name="PEMBETULAN">
		<input type="hidden" class="form-control" id="RKODE_CABANG" name="RKODE_CABANG">
		<input type="hidden" class="form-control" id="IS_CREDITABLE" name="IS_CREDITABLE">
		<input type="hidden" class="form-control" id="SEARCH_VIEW" name="SEARCH_VIEW">
		<input type="hidden" class="form-control" id="JOURNALNUMBER" name="JOURNALNUMBER">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx" name="cabang_trx" autocomplete="off">
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan">
						<?php
							$namaBulan = list_month();
							$bln       = date('m');
							echo "<option value='' > Pilih Bulan </option>";
							for ($i=1;$i< count($namaBulan);$i++){
								//$selected = ($i==$bln)?"selected":"";
								$selected	= "";
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
							echo "<option value='' > Pilih Tahun </option>";
							for($i=$tAwal; $i<=$tAkhir; $i++){
								//$selected = ($i == $tahun) ? "selected" : "";
								$selected	= "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}
						?>
					</select>
					<input type="hidden" class="form-control" id="pajakku" value="<?php echo $nama_pajak ?>">
				</div>
			 </div>
		</div>
		<div class="row"> 
			<div class="col-md-3">
				<div class="form-group">
					<label>Pajak</label>
					<select class="form-control" id="pajak" name="pajak">
						<option value="" data-name="" ></option>
					</select> 
				</div>
			 </div>
			 <div class="col-md-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="" data-name="" >Pilih Jenis Pajak</option>
						<option value="PPN MASUKAN" data-name="PPN MASUKAN" > PPN MASUKAN </option>
						<option value="PPN KELUARAN" data-name="PPN KELUARAN" > PPN KELUARAN </option>
						<option value="DOKUMEN LAIN MASUKAN" data-name="DOKUMEN LAIN MASUKAN" > DOKUMEN LAIN MASUKAN </option>
						<option value="DOKUMEN LAIN KELUARAN" data-name="DOKUMEN LAIN KELUARAN" > DOKUMEN LAIN KELUARAN </option>
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
		</div>
		<div class="row"> 
			<div class="col-md-2">	
				<div class="form-group">
					<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>
				</div>
			</div> 
		</div>
		</form>
	 </div>
    
    <div class="row" id="faktur_masukan">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
            <div class="panel-group boxshadow" id="accordion2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-6">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-data2"><?php echo $nama_pajak;  ?> Staging</a>
								</h4>
							</div>
							<div class="col-lg-6">
								<div class="navbar-right">
									<button type="button" id="btndonlodlogcsv" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-download fa-fw"></i> Log to CSV </button>
							</div>
						  </div>
						</div>
					</div>					
					<div id="collapse-data2" >
						<div class="panel-body">
							<div class="table-responsive">
								<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
									<thead>
										<tr>
											<th>SENDER ID</th>
											<th>DOC. NUMBER</th>
											<th>TAHUN BUKU</th>
											<?php if($nama_pajak == "PPN MASA"){ ?>
											<th>KODE JENIS <br> TRANSAKSI</th>
											<th>FAKTUR <br> PENGGANTI</th>
											<?php  } ?>
											<th>NOMOR FAKTUR</th>
											<?php if($nama_pajak == "PPN MASA"){ ?>
											<th>TANGGAL <br> FAKTUR PAJAK</th>
			                            	<th>NPWP</th>
			                            	<th>NAMA WP</th>
											<th>ALAMAT WP</th>
											<th>DPP</th>
			                            	<th>JUMLAH PPN</th>
											<th>JUMLAH PPNBM</th>
											<th>MASA PENGKREDITAN</th>
											<th>TAHUN PENGKREDITAN</th>
											<th>REFERENSI</th>
											<th>KODE CABANG</th>
											<th>NAMA CABANG</th>
											<th>STATUS TRANSAKSI</th>
											<?php  } ?>
											<?php if($nama_pajak == "DETAIL JURNAL"){ ?>
											<th>BULAN BUKU</th>
                                			<th>POSTING DATE</th> 
											<th>DESC. JENIS TRANSAKSI</th>
                                			<th>LINE NO.</th>
											<th>ACCOUNT</th>
                                            <th>DESC. ACCOUNT</th>
											<th>AMOUNT</th>
                                			<th>SUB LEDGER</th>
											<th>CODE SUB LEDGER</th>
                                			<th>DESC. SUB LEDGER</th>
											<th>DESCRIPTION HEADER</th>
                                			<th>REFERENCE LINE</th>
											<th>COST CENTER</th>
                                			<th>COST CENTER DESC.</th>
                                			<th>PONUMBER</th>
											<th>TANGGALPO</th>
											<?php  } ?>
											<?php if($nama_pajak == "PPN MASA"){ ?>
											<th>CURRENCY</th>
											<?php  } ?>
											<?php if($nama_pajak == "DETAIL JURNAL"){ ?>
											<th>PROFIT. CENTER</th>
											<th>PROFIT. CENTER DESC.</th>
											<?php  } ?>
											<th>NAMA PERUSAHAAN</th>
											<th>STATUS KIRIM</th>
											<th>KETERANGAN KIRIM</th>
											<th>JENIS PAJAK</th>
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
</div>

<script>
    $(document).ready(function() {
		var table	= "", table2	= "", table3	= "", vkodepajak = "",vbulan = "", vtahun ="", vcabang ="", kode_cabang ="", vpembetulan ="";
		vcabang = '<?php echo $kantor_cabang ?>';
		vpajak2 = '<?php echo $nama_pajak ?>';
		getSelectPajak();
		getSelectCabang();

		audioSuccess = new Audio(baseURL + '/notification.ogg');

        Pace.track(function(){  
		   $('#tabledata').DataTable({	 		
			"serverSide"	: true,
			"processing"	: false,
			"ajax"			: {
								 "url"  		: baseURL + 'h2h_staging/load_staging',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     	= $('#cabang_trx').val();
										d._searchBulan       	= $('#bulan').val();
										d._searchTahun       	= $('#tahun').val();
										d._searchPajak         	= $('#pajak').val();
										d._searchJenisPajak     = $('#jenisPajak').val();
										d._searchPembetulan 	= $('#pembetulanKe').val();
										d._searchPajakku 		= $('#pajakku').val();
										d._searchView			= $('#SEARCH_VIEW').val();
									}
							},
			"language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
							},
			"columns"		: [
								{ "data": "docnumber" },
								{ "data": "journalnumber" },
								{ "data": "tahun_buku", "class":"text-center" },
								<?php if ($nama_pajak == "PPN MASA") { ?>
								{ "data": "kd_jenis_transaksi", "class":"text-center" },
								{ "data": "fg_pengganti", "class":"text-center" },
								<?php } ?>
								{ "data": "no_faktur_pajak", "class":"text-center" },
								<?php if($nama_pajak == "PPN MASA"){ ?>
								{ "data": "tanggal_faktur_pajak", "class":"text-center" },
								{ "data": "npwp", "class":"text-left" },
								{ "data": "nama_wp", "class":"text-left" },
								{ "data": "alamat_wp", "class":"text-left" },
								{ "data": "dpp", "class":"text-right" },
								{ "data": "jumlah_ppn", "class":"text-right" },
								{ "data": "jumlah_ppnbm", "class":"text-right" },
								{ "data": "masa_pengkreditan", "class":"text-center" },
								{ "data": "tahun_pengkreditan", "class":"text-center" },
								{ "data": "referensi", "class":"text-left" },
								{ "data": "kode_cabang", "class":"text-left" },
								{ "data": "nama_cabang", "class":"text-left" },
								{ "data": "status_transaksi", "class":"text-center" },
								<?php } ?>
								<?php if($nama_pajak == "DETAIL JURNAL"){ ?>
								{ "data": "bulan_buku", "class":"text-center" },
								{ "data": "tanggalposting", "class":"text-center" },
								{ "data": "descjenistransaksi", "class":"text-left" },
								{ "data": "lineno", "class":"text-center" },
								{ "data": "account", "class":"text-center" },
								{ "data": "descaccount", "class":"text-left" },
								{ "data": "amount", "class":"text-right" },
								{ "data": "subledger", "class":"text-left" },
								{ "data": "codesubledger", "class":"text-left" },
								{ "data": "descsubledger", "class":"text-left" },
								{ "data": "descriptionheader", "class":"text-left" },
								{ "data": "referenceline", "class":"text-left" },
								{ "data": "costcenter", "class":"text-center" },
								{ "data": "costcenterdesc", "class":"text-left" },
								{ "data": "ponumber", "class":"text-left" },
								{ "data": "tanggalpo", "class":"text-center" },
								<?php } ?>
								<?php if ($nama_pajak == "PPN MASA") { ?>
								{ "data": "currency", "class":"text-center" },
								<?php } ?>
								<?php if($nama_pajak == "DETAIL JURNAL"){ ?>
								{ "data": "profitcenter", "class":"text-center" },
								{ "data": "profitcenterdesc", "class":"text-left" },
								<?php } ?>
								{ "data": "company_name", "class":"text-left" },
								{ "data": "status_kirim", "class":"text-center" },
								{ "data": "keterangan", "class":"text-left" },
								{ "data": "jenis_pajak", "class":"text-left" },
								
							],
			"rowCallback": function( row, data, index ) {
									
								},            			
			"columnDefs"	: [ 
								{
									"targets": [ ],
									"visible": false
								},
								{
									targets: 10,
									render: $.fn.dataTable.render.number(',', '.', 0, '')
								}, 
								{
									targets: 11,
									render: $.fn.dataTable.render.number(',', '.', 0, '')
								}, 
								<?php if ($nama_pajak == 'PPN MASA') {?>
								{
									targets: 12,
									render: $.fn.dataTable.render.number(',', '.', 0, '')
								}, 
								<?php } ?>
							],
			fixedColumns	:   {
					leftColumns: 0
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
  
        $("input[type=search]").addClear();
		<?php if($nama_pajak == 'PPN MASA') {?>
			$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Doc. Number / Nama WP / NPWP ').css({'width':'300px','display':'inline-block'}).addClass('form-control input-sm');		
		<?php } else {?>
			$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Doc. Number / No Faktur / Desc. Subledger / No PO ').css({'width':'400px','display':'inline-block'}).addClass('form-control input-sm');		
		<?php } ?>
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
				
		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empty();				
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d = table.row( this ).data();
				$('#DOCNUMBER').val(d.docnumber);	
				$('#JENIS_PAJAK').val(d.jenis_pajak);
				$('#BULAN_PAJAK').val(d.bulan_pajak);	
				$('#TAHUN_PAJAK').val(d.tahun_pajak);
				$('#PEMBETULAN').val(d.pembetulan);
				$('#RKODE_CABANG').val(d.kode_cabang);
				$('#IS_CREDITABLE').val(d.is_creditable);
				$('#JOURNALNUMBER').val(d.journalnumber);	
			}			
		}).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		});

	function empty()
	{
		$('#DOCNUMBER').val('');
		$('#JENIS_PAJAK').val('');					
		$('#BULAN_PAJAK').val('');					
		$('#TAHUN_PAJAK').val('');										
		$('#PEMBETULAN').val('');		
		$('#IS_CREDITABLE').val('');	
		$('#JOURNALNUMBER').val('');
		table.$('tr.selected').removeClass('selected');
	}	

	function empty2(){
		$('#cabang_trx').val('');
		$('#bulan').val('');
		$('#tahun').val('');
		$('#pajak').val('');
		$('#jenisPajak').val('');
		$('#pembetulanKe').val('');
	}

	$("#pajak").change(function () {

		var valueSelected = $("#pajak :selected").val();
		if(valueSelected == 'PPNMASA'){
			$("#jenisPajak option[value='DOKUMEN LAIN MASUKAN']").show();
			$("#jenisPajak option[value='DOKUMEN LAIN KELUARAN']").show();
		} else {
			$("#jenisPajak option[value='DOKUMEN LAIN MASUKAN']").hide();
			$("#jenisPajak option[value='DOKUMEN LAIN KELUARAN']").hide();
		}

	});

	$("#btnRefresh").on("click", function(){
	
		$.ajax({
			url		: "<?php echo site_url('tara_pajakku/refresh_tara') ?>",
			type	: "POST",
			data	: $('#form-wp').serialize(),
			beforeSend	: function(){
						$("body").addClass("loading2")
						$("#message").html('Refresh Data...');
			},							
			success	: function(result){
				if ( result==1 ) {
					waitingTime = 20000;			
					$("body").removeClass("loading2");
					flashnotif('Sukses','Refresh Sukses!','success' );	
					table.draw();
					table.ajax.reload();					
				} else if ( result==2 ) {	
					$("body").removeClass("loading2");
					flashnotif('Error','Refresh Update Gagal!','error' );
					table.draw();
					table.ajax.reload();
				} else {	
					$("body").removeClass("loading2");
					flashnotif('Error','Koneksi ke Pelindo 3 Gagal!','error' );
					table.draw();
					table.ajax.reload();
				}
			}
		});					
	});

    $("#btnKirim").on("click", function(){
			var kodecbg = $("#cabang_trx").val();
			var nmcbg = $( "#cabang_trx option:selected" ).text();
			var p 	= $("#pajak").val();
			var j 	= $("#jenisPajak").val();			
			var b	= $("#bulan").val();			
			var t	= $("#tahun").val();	
			var bnm	= $("#bulan").find(":selected").attr("data-name");	
			var pb 	= $("#pembetulanKe").val();
			if (kodecbg == ''){
				alert('Mohon pilih Cabang');
				return;
			} else if (b == '') {
				alert('Mohon pilih Bulan');
				return;
			} else if (t == '') {
				alert('Mohon pilih Tahun');
				return;
			} else if (p === ''){
				alert('Mohon pilih Pajak');
				return;
			} else if (p != 'PPNMASA'){
				alert('Mohon maaf untuk sementara pajak '+p+' belum bisa kirim ke Staging');
				return;
			} else if (j === '') {
				alert('Mohon pilih Jenis Pajak');
				return;
			} else if (pb === null) {
				alert('Mohon pilih Pembetulan');
				return;
			} else if (b != '' && t != '') 
			{
				bootbox.confirm({
				title: "Kirim ke Staging Pajak Pelindo 3  Jenis Pajak <span class='label label-danger'> "+j+" </span> Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> Cabang <span class='label label-danger'>"+nmcbg+"</span> Pembetulan <span class='label label-danger'>"+pb+"</span>?",
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
						send_to_staging();
					} 
				  }
				});
			}				
	});

	function send_to_staging()
	{
      $.ajax({
			url		: "<?php echo site_url('h2h_staging/send_to_staging') ?>",
			type	: "POST",
			data	: $('#form-wp').serialize(),
			beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Proses Kirim Data...');
			},							
			success	: function(result){
				if (result==111 || result==11 || result==1 ) {
					$("body").removeClass("loading2");
					$("#message").html('');
					audioSuccess.play();
					flashnotifnohide('Sukses','File sukses Terkirim!','success' );
					empty2();
					table.ajax.reload();
				} else if (result == 122) {
					$("body").removeClass("loading2");	
					$("#message").html('');
					flashnotifnohide('Warning','- Faktur masukan creditable terkirim! <br> - Faktur masukan not creditable tidak terkirim (data kosong) ','warning' );
					empty2();
					table.ajax.reload();
				} else if (result == 221) {
					$("body").removeClass("loading2");	
					$("#message").html('');
					flashnotifnohide('Warning','- Faktur masukan creditable tidak terkirim (data kosong) <br> - Faktur masukan not creditable terkirim ','warning' );
					empty2();
					table.ajax.reload();
				} else if (result== 2){	
					$("body").removeClass("loading2");
					$("#message").html('');
					flashnotifnohide('Error','Gagal insert ke database','error' );
					empty2();
					table.ajax.reload();
				} else if (result == 22 || result == 2222) {
					$("body").removeClass("loading2");	
					$("#message").html('');
					flashnotifnohide('Error','Data kosong','error' );
					empty2();
					table.ajax.reload();
				}
				else {
					$("body").removeClass("loading2");
					$("#message").html('');	
					flashnotifnohide('Error','Kirim ke Staging Gagal!','error' );
					empty2();
					table.draw();
					table.ajax.reload();
				}
			}
		});	
	}

	var dengan_akun = "";

    function getSelectPajak()
	{
		$.ajax({
				url		: "<?php echo site_url('h2h_staging/load_master_pajak/'.$nama_pajak) ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#pajak").html("");					
					$("#pajak").html(result);					
				}
		});			
	}

	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url('tara_pajakku/load_tarra_cabang') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#cabang_trx").html("");					
					$("#cabang_trx").html(result);					
				}
		});	

	}

	$("#btndonlodlogcsv").click(function(){		
		var vpajakhid = $('#PAJAK_HEADER_ID').val();
		var vpajak = $('#PAJAK').val();	
		var vjenis_pajak = $('#JENIS_PAJAK').val();	
		var vbulan_pajak = $('#BULAN_PAJAK').val();	
		var vtahun_pajak = $('#TAHUN_PAJAK').val();
		var vmodul = $('#MODUL').val();
		var vis_creditable = $('#IS_CREDITABLE').val();
		var vpembetulan = $('#PEMBETULAN').val();
		var vdocnumber = $('#DOCNUMBER').val();
		var vjournalnumber = $('#JOURNALNUMBER').val();
		var vblnname = vbulan_pajak;
		var nmcbg = $('#RKODE_CABANG').val();
		switch (vbulan_pajak) {
			case "JANUARI":
				vbulan_pajak = 1;
			break;
			case "FEBRUARI":
				vbulan_pajak = 2;
			break;
			case "MARET":
				vbulan_pajak = 3;
			break;
			case "APRIL":
				vbulan_pajak = 4;
			break;
			case "MEI":
				vbulan_pajak = 5;
			break;
			case "JUNI":
				vbulan_pajak = 6;
			break;
			case "JULI":
				vbulan_pajak = 7;
			break;
			case "AGUSTUS":
				vbulan_pajak = 8;
			break;
			case "SEPTEMBER":
				vbulan_pajak = 9;
			break;
			case "OKTOBER":
				vbulan_pajak = 10;
			break; 
			case "NOVEMBER":
				vbulan_pajak = 11;
			break;
			case "DESEMBER":
				vbulan_pajak = 12;
			break;
		}

		if(vdocnumber === ''){
			alert('Mohon pilih data yang akan di download');
			return;
		}				
		
		if(vdocnumber === 'FKXXXXXX' || vdocnumber === 'FMXXXXXX'){
			alert('Mohon pilih data yang tidak kosong');
			return;
		}

		if(vjournalnumber === ""){
			alert('Mohon pilih Doc. Number yang tidak kosong');
			return;
		}

		  bootbox.confirm({
			title: "Download Log  Jenis pajak <span class='label label-danger'>"+vjenis_pajak+"</span> Bulan Pajak <span class='label label-danger'>"+vblnname+"</span> Tahun Pajak <span class='label label-danger'>"+vtahun_pajak+"</span> Creditable <span class='label label-danger'>"+vis_creditable+"</span> Pembetulan Ke <span class='label label-danger'>"+vpembetulan+"</span> Sender ID <span class='label label-danger'>"+vdocnumber+"</span> Doc. Number <span class='label label-danger'>"+vjournalnumber+"</span>?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> Cancel'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Download'
				}
			},
			callback: function (result) {
				if(result) {
						var url1 = baseURL + 'h2h_staging/export_log_by_docnumber/'+vdocnumber+'/'+vpajak2+'/'+vjenis_pajak+'/'+nmcbg+'/'+vjournalnumber;
						//var url1;
						setTimeout(function () {
							window.open(url1);
						}, 1000);
						window.focus();	
					}
				}
			});			
	})

	$("#btnView").on("click", function(){
			$('#SEARCH_VIEW').val('1');
			table.ajax.reload();			
	});

 });
</script>