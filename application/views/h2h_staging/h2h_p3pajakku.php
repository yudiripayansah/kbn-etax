<div class="container-fluid">
		
    <?php $this->load->view('template_top') ?>

	<div class="white-box boxshadow">
		<form role="form" id="form-wp">
		<?php  
			$vthiscabang = $this->session->userdata('kd_cabang');
		?>
		<input type="hidden" id="kd_cabang" value="<?php echo $this->session->userdata('kd_cabang') ?>">
		<input type="hidden" class="form-control" id="DOCNUMBER" name="DOCNUMBER">
		<input type="hidden" class="form-control" id="NAMA_PAJAK2" name="NAMA_PAJAK2">
		<input type="hidden" class="form-control" id="JENIS_PAJAK" name="JENIS_PAJAK">
		<input type="hidden" class="form-control" id="BULAN_PAJAK" name="BULAN_PAJAK">
		<input type="hidden" class="form-control" id="TAHUN_PAJAK" name="TAHUN_PAJAK">
		<input type="hidden" class="form-control" id="PEMBETULAN" name="PEMBETULAN">
		<input type="hidden" class="form-control" id="RKODE_CABANG" name="RKODE_CABANG">
		<input type="hidden" class="form-control" id="IS_CREDITABLE" name="IS_CREDITABLE">
		<input type="hidden" class="form-control" id="STATUS_KIRIM" name="STATUS_KIRIM">
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
		<?php  
			if ($vthiscabang === "000") {
		?>	 
			 <div class="col-md-2">	
				<div class="form-group">
				    <label>&nbsp;</label>
					<button id="btnKirim" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Kirim ke Staging</span></button>
				</div>
			 </div>
		<?php  
			}
		?>	 
		<!--
             <div class="col-md-2">	
				<div class="form-group">
				    <label>&nbsp;</label>
					<button id="btnRefresh" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Refresh</span></button>
				</div>
			 </div>
		-->	 
			 <div class="col-md-2">	
				<div class="form-group">
				    <label>&nbsp;</label>
					<button id="btnDownload" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Download CSV</span></button>
				</div>
			 </div>
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
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-data2">Integrasi PI3 Pajakku</a>
								</h4>
							</div>
							<div class="col-lg-6">
								<div class="navbar-right">
									<button type="button" id="btndonlodlogcsv" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-download fa-fw"></i> Log to CSV </button>
							<?php  
								if ($vthiscabang === "000") {
							?>
									<!--<button type="button" id="btnResend" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-bars"></i> Kirim Ulang </button>-->
							<?php  
								}
							?>
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
											<th>NO</th>
											<th>LOG ID</th>
											<th>SENDER ID</th>
											<th>KODE CABANG</th>
											<th>CABANG</th>
											<th> PAJAK</th>
			                            	<th>JENIS PAJAK</th>
			                            	<th>BULAN PAJAK</th>
											<th>TAHUN PAJAK</th>
											<th>TANGGAL KIRIM</th>
			                            	<th>STATUS KIRIM</th>
											<th>KETERANGAN</th>
											<th>PENGIRIM</th>
											<th>WAJIB PAJAK</th>
											<th>TOTAL BARIS DATA</th>
											<th>PEMBETULAN</th>
											<th>IS CREDITABLE</th>
											<th>PAJAK HEADER ID</th>
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
        getSelectPajak();
		getSelectCabang();
		vcabang = '<?php echo $kantor_cabang ?>';
		audioSuccess = new Audio(baseURL + '/notification.ogg');

        Pace.track(function(){  
		   $('#tabledata').DataTable({	 		
			"serverSide"	: true,
			"processing"	: false,
			"ajax"			: {
								 "url"  		: baseURL + 'h2h_staging/load_log_staging',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     	= $('#cabang_trx').val();
										d._searchBulan       	= $('#bulan').val();
										d._searchTahun       	= $('#tahun').val();
										d._searchPajak         	= $('#pajak').val();
										d._searchJenisPajak     = $('#jenisPajak').val();
										d._searchPembetulan 	= $('#pembetulanKe').val();
									}
							},
			"language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
							},
			"columns"		: [
								{ "data": "no" },
								{ "data": "idlog" },
								{ "data": "docnumber", "class":"text-left" },
								{ "data": "kode_cabang", "class":"text-center" },
								{ "data": "nama_cabang" },
								{ "data": "pajak" },
								{ "data": "jenis_pajak" },
								{ "data": "bulan_pajak", "class":"text-center" },
								{ "data": "tahun_pajak", "class":"text-center" },
								{ "data": "tanggal_kirim", "class":"text-center" },
								{ "data": "status_kirim", "class":"text-left" },
								{ "data": "keterangan", "class":"text-left" },
								{ "data": "pengirim", "class":"text-center" },
								{ "data": "npwp", "class":"text-center" },
								{ "data": "total_baris_kirim", "class":"text-center" },
								{ "data": "pembetulan", "class":"text-center" },
								{ "data": "is_creditable", "class":"text-left" },
								{ "data": "pajak_header_id", "class":"text-center" },
							],
			"rowCallback": function( row, data, index ) {
									if (data.status_kirim == "S"){
										//$('td', row).css('background-color', 'Green');
									}
								},            			
			"columnDefs"	: [ 
								{
									"targets": [ 0, 1, 3, 11, 13, 17 ],
									"visible": false
								} 
							],
			fixedColumns	:   {
					leftColumns: 0
			},		
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();
  
        $("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Sender ID ...').css({'width':'260px','display':'inline-block'}).addClass('form-control input-sm');		

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
				$('#NAMA_PAJAK2').val(d.pajak);	
				$('#JENIS_PAJAK').val(d.jenis_pajak);
				$('#BULAN_PAJAK').val(d.bulan_pajak);	
				$('#TAHUN_PAJAK').val(d.tahun_pajak);
				$('#PEMBETULAN').val(d.pembetulan);
				$('#RKODE_CABANG').val(d.kode_cabang);
				$('#IS_CREDITABLE').val(d.is_creditable);
				$('#STATUS_KIRIM').val(d.status_kirim);
			}			
		}).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		});

	function empty()
	{
		$('#DOCNUMBER').val('');
		$('#NAMA_PAJAK2').val('');	
		$('#JENIS_PAJAK').val('');					
		$('#BULAN_PAJAK').val('');					
		$('#TAHUN_PAJAK').val('');										
		$('#PEMBETULAN').val('');		
		$('#IS_CREDITABLE').val('');	
		$('#STATUS_KIRIM').val('');
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
			var pnm	= $("#pajak").find(":selected").attr("data-name");
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
			} else if (p != 'PPNMASA' && p != 'DETAILJT'){
				alert('Mohon maaf untuk sementara pajak '+p+' belum bisa kirim ke Staging');
				return;
			} else if (j === '') {
				alert('Mohon pilih Jenis Pajak');
				return;
			} else if (j === 'ADVANCE PAYMENT') {
				alert(j + ' On Progress Development');
				return;
			} else if (pb === null) {
				alert('Mohon pilih Pembetulan');
				return;
			} else if (b != '' && t != '') 
			{
				bootbox.confirm({
				title: "Kirim ke Staging Pajak Pelindo 3 "+pnm+" Jenis Pajak <span class='label label-danger'> "+j+" </span> Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> Cabang <span class='label label-danger'>"+nmcbg+"</span> Pembetulan <span class='label label-danger'>"+pb+"</span>?",
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
				} else if (result == 12) {
					$("body").removeClass("loading2");	
					$("#message").html('');
					flashnotifnohide('Warning','- Faktur masukan creditable terkirim! <br> - Faktur masukan not creditable (data kosong) gagal insert database ','warning' );
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
	$("#btnDownload").on("click", function(){
		var p 	= $("#pajak").val();
		var j 	= $("#jenisPajak").val();			
		var b	= $("#bulan").val();			
		var t	= $("#tahun").val();	
		var bnm	= $("#bulan").find(":selected").attr("data-name");	

		var kode_cabang = $("#cabang_trx").val();
		var vpembetulan = $("#pembetulanKe").val();

		if (kode_cabang == ''){
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
		} else if ((p != 'PPNMASA' && p != 'DETAILJT')){
			alert('Mohon maaf untuk sementara pajak '+p+' belum bisa di download');
			return;
		}
		if (j === '') {
			alert('Mohon pilih Jenis Pajak');
			return;
		}

		if(vcabang == "pusat"){
			vcategory = "kompilasi";
		}
		else{
			vcategory = "cabang";
		}

		if(p != 'DETAILJT'){
			if(j == "PPN MASUKAN"){
				var url1 = baseURL + 'h2h_staging/download_csv_m/'+vcategory+'/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan+'/faktur_standar/creditable/'+dengan_akun;
				var url2 = baseURL + 'h2h_staging/download_csv_m/'+vcategory+'/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan+'/faktur_standar/not_creditable/'+dengan_akun;
			} else if (j == "PPN KELUARAN") {
				var url1 = baseURL + 'h2h_staging/download_csv_k/'+vcategory+'/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan+'/faktur_standar/';
				var url2 = '';
			} else if (j == "DOKUMEN LAIN MASUKAN"){
				j = 'PPN MASUKAN';
				var url1 = baseURL + 'h2h_staging/download_csv_m/'+vcategory+'/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan+'/dokumen_lain/xx/'+dengan_akun;
				var url2 = '';
			} else {
				j = 'PPN KELUARAN';
				var url1 = baseURL + 'h2h_staging/download_csv_k/'+vcategory+'/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan+'/dokumen_lain/';
				var url2 = '';
			}
		} else {
				var url1 = baseURL + 'h2h_staging/download_csv_djt/'+kode_cabang+'/'+j+'/'+b+'/'+t+'/'+vpembetulan;
				var url2 = '';
		}
		
		window.open(url1);
	
		setTimeout(function () {
			window.open(url2);
		}, 1000);	
			window.focus();				
	});

    function getSelectPajak()
	{
		$.ajax({
				url		: "<?php echo site_url('h2h_staging/load_master_pajak') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#pajak").html("");					
					$("#pajak").html(result);					
				}
		});			
	}

	<!--Resend File CSV Per File-->
	$("#btnResend").click(function(){		
		var vpajakhid = $('#PAJAK_HEADER_ID').val();
		var vpajak = $('#PAJAK').val();	
		var vjenis_pajak = $('#JENIS_PAJAK').val();	
		var vbulan_pajak = $('#BULAN_PAJAK').val();	
		var vtahun_pajak = $('#TAHUN_PAJAK').val();
		var vmodul = $('#MODUL').val();
		var vis_creditable = $('#IS_CREDITABLE').val();
		var vpembetulan = $('#PEMBETULAN').val();
		var vkode_cabang = $('#RKODE_CABANG').val();
		var vblnname = vbulan_pajak;
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

		if(vpajakhid == ''){
			alert('Mohon pilih salah satu data yang akan di kirim ulang');
			return;
		}

		  bootbox.confirm({
			title: "Kirim ulang modul <span class='label label-danger'>"+vmodul+"</span> Pajak <span class='label label-danger'>"+vpajak+"</span> Jenis pajak <span class='label label-danger'>"+vjenis_pajak+"</span> Bulan Pajak <span class='label label-danger'>"+vblnname+"</span> Tahun Pajak <span class='label label-danger'>"+vtahun_pajak+"</span> Creditable <span class='label label-danger'>"+vis_creditable+"</span> Pembetulan Ke <span class='label label-danger'>"+vpembetulan+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Resend'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('Tara_pajakku/resend_file') ?>",
						type	: "POST",
						data	: ({pajak_header_id:vpajakhid,pajak:vpajak,jenisPajak:vjenis_pajak,bulan:vbulan_pajak,tahun:vtahun_pajak,modul:vmodul,creditable:vis_creditable,pembetulanKe:vpembetulan,kode_cabang:vkode_cabang}),
						beforeSend	: function(){
							 $("body").addClass("loading2")
							 $("#message").html('Kirim ulang Modul '+vmodul+'...');
							},
						success	: function(result){
							if (result==111 || result==11 || result==1 ) {
								waitingTime = 2000;
								setTimeout(function(){
									$("body").removeClass("loading2");
									$("#message").html('');
									flashnotif('Sukses','File sukses Terkirim!','success' );
									empty();
									table.draw();
								}, waitingTime);

							} else if (result==114){
								$("body").removeClass("loading2");
								flashnotif('Warning','Dokumen Masukan dan Faktur Masukan creditable Terkirim! Data Faktur Masukan not creditable tidak terkirim (data kosong)!','warning' );
								empty();
								table.draw();
								table.ajax.reload();
							} else if (result==144 || result==14 ){			
								$("body").removeClass("loading2");
								flashnotif('Warning','Dokumen Masukan Terkirim! Faktur Masukan creditable dan Faktur Masukan not creditable tidak terkirim (data kosong)!','warning' );
								empty();
								table.draw();
								table.ajax.reload();
							}
							else if (result== 2){	
								$("body").removeClass("loading2");
								flashnotif('Error','Gagal insert log ke database','error' );
								empty();
								table.draw();
								table.ajax.reload();
							} else if (result == 4 || result == 44 || result == 444 || result == 22 || result == 2222) {
								$("body").removeClass("loading2");	
								flashnotif('Error','Data kosong','error' );
								empty();
								table.draw();
								table.ajax.reload();
							}
							else {
								$("body").removeClass("loading2");	
								flashnotif('Error','Kirim ke Tara Gagal!','error' );
								empty();
								table.draw();
								table.ajax.reload();
							}
						}
					});	
				}
			}
		});			
	})

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
		var vpajak = $('#NAMA_PAJAK2').val();	
		var vjenis_pajak = $('#JENIS_PAJAK').val();	
		var vbulan_pajak = $('#BULAN_PAJAK').val();	
		var vtahun_pajak = $('#TAHUN_PAJAK').val();
		var vmodul = $('#MODUL').val();
		var vis_creditable = $('#IS_CREDITABLE').val();
		var vpembetulan = $('#PEMBETULAN').val();
		var vdocnumber = $('#DOCNUMBER').val();
		var vblnname = vbulan_pajak;
		var nmcbg = $('#RKODE_CABANG').val();
		var vstatus_kirim = $('#STATUS_KIRIM').val();
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
			alert('Mohon pilih Doc. Number yang tidak kosong');
			return;
		}

		if(vstatus_kirim === 'Kosong'){
			alert('Mohon pilih data yang tidak kosong');
			return;
		}

		  bootbox.confirm({
			title: "Download Log Pajak <span class='label label-danger'>"+vpajak+"</span> Jenis pajak <span class='label label-danger'>"+vjenis_pajak+"</span> Bulan Pajak <span class='label label-danger'>"+vblnname+"</span> Tahun Pajak <span class='label label-danger'>"+vtahun_pajak+"</span> Creditable <span class='label label-danger'>"+vis_creditable+"</span> Pembetulan Ke <span class='label label-danger'>"+vpembetulan+"</span> Sender ID <span class='label label-danger'>"+vdocnumber+"</span> ?",
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
						var url1 = baseURL + 'h2h_staging/export_log_by_docnumber/'+vdocnumber+'/'+vpajak+'/'+vjenis_pajak+'/'+nmcbg+'/x';

						setTimeout(function () {
							window.open(url1);
						}, 1000);
						window.focus();	
					}
				}
			});			
	})

	$("#btnView").on("click", function(){
			table.ajax.reload();			
	});

 });
</script>