<div class="container-fluid">
    <?php $this->load->view('template_top') ?>

    <?php if($this->session->userdata('kd_cabang') == '000'): ?>
	<div class="white-box boxshadow">
		<label>Download Data Referensi</label>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan_ref" name="bulan_ref">
						<?php
						 $namaBulan = list_month();
						 $bln = date('m');
						 /*if ($bln>1){
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
			 <div class="col-md-2">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="tahun_ref" name="tahun_ref">
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
			 <div class="col-md-3">
				<div class="form-group">
					<label>Data Referensi</label>
					<select class="form-control" id="jenis_ref" name="jenis_ref">
						<option value="CUSTOMER" data-name="Customer" >Master Customer</option>
						<option value="SUPPLIER" data-name="Supplier" >Master Supplier</option>
						<option value="MSTPPH" data-name="MSTPPH" >Master TAX</option>
						<option value="MSTGCC" data-name="MSTGCC" >Master COA</option>
						<option value="FLEX" data-name="FLEX" >Master Deskripsi COA</option>
						<option value="1721A1" data-name="1721-A1" >1721A1</option>
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnGetRef" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Download</span></button>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnSetRef" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Process</span></button>
				</div>
			 </div>
		</div>
		Bulan dan tahun diatas adalah last update date 
	</div>
	<?php endif; ?>

	<div class="white-box boxshadow">
		<label>Download Data Transaksi</label>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan_trx" name="bulan_trx">
						<?php
						 $namaBulan = list_month();
						 $bln = date('m');
						 /*if ($bln>1){
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
			 <div class="col-md-2">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="tahun_trx" name="tahun_trx">
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
			 <div class="col-md-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx" name="cabang_trx">
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<label>Data Transaksi</label>
					<select class="form-control" id="jenis_trx" name="jenis_trx">
						<option value="PPH15" data-name="PPH15" >PPh Pasal 15</option>
						<option value="PPH21" data-name="PPH21" >PPh Pasal 21</option>
						<option value="PPH22" data-name="PPH22" >PPh Pasal 22</option>
						<option value="PPH2326" data-name="PPH2326" >PPh Pasal 23/26</option>
						<option value="PPH4_2" data-name="PPH4_2" >PPh Pasal 4 Ayat 2</option>
						<option value="PPNMASUK" data-name="PPNMASUK" >PPN Masa (Masukan)</option>
						<option value="PPNKELUAR" data-name="PPNKELUAR" >PPN Masa (Keluaran)</option>
						<option value="PPNWAPU" data-name="PPNWAPU" >PPN WAPU</option>
						<!--<option value="ACCPPH21" data-name="ACCPPH21" >Ekualisasi PPh 21</option>-->
						<!--<option value="FAFISKAL" data-name="FAFISKAL" >Fixed Asset</option>-->
						<option value="APBONUS" data-name="APBONUS" >Beban Bonus</option>
						<option value="PPH21DTL" data-name="PPH21DTL" >Report Ekual PPh 21</option>
						<option value="SPPD" data-name="SPPD" >Perjalanan Dinas</option>
						<option value="GLJE" data-name="GLJE" >Detail Jurnal Transaksi</option>
					</select>
				</div>
			 </div>
			 <div class="col-md-4">
				<div class="form-group">
					<label>Nama Perusahaan</label>
					<select class="form-control" id="perusahaan_trx" name="perusahaan_trx">
						<?php
							$sql   = "select * from SIMTAX_MASTER_PERUSAHAAN where AKTIF = 'Y'";
							$query = $this->db->query($sql);
							
							foreach($query->result_array() as $row)	{
								$kode_perusahaan	= $row['KODE_PERUSAHAAN'];
								$nama_perusahaan	= $row['NAMA_PERUSAHAAN'];
								echo "<option value='".$kode_perusahaan."'>".$nama_perusahaan."</option>";
							}
							$query->free_result();
						?>
					</select>
				</div>
			 </div> 
		</div>
		<div class="row">
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnGetTrx" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Download</span></button>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnSetTrx" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Process</span></button>
				</div>
			 </div>
		</div>
		Bulan dan tahun diatas adalah Period Name
	</div>

	<div class="white-box boxshadow">
		<label>Download Data Transaksi Fixed Asset</label>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>From </label>
					<select class="form-control" id="bulan_trx_from" name="bulan_trx_from">
						<?php
						 $namaBulan = list_month();
						 $bln = date('m');
						 for ($i=1;$i< count($namaBulan);$i++){
							 $selected	= ($i==$bln)?"selected":"";
							 echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
						 }
						?>
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<label>To </label>
					<select class="form-control" id="bulan_trx_to" name="bulan_trx_to">
						<?php
						 $namaBulan = list_month();
						 $bln = date('m');
						 for ($i=1;$i< count($namaBulan);$i++){
							 $selected	= ($i==$bln)?"selected":"";
							 echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
						 }
						?>
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="tahun_trx_fa" name="tahun_trx_fa">
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
			 <div class="col-md-2">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="cabang_trx_fa" name="cabang_trx_fa">
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<label>Data Transaksi</label>
					<select class="form-control" id="jenis_trx_fa" name="jenis_trx_fa">
						<option value="FAFISKAL" data-name="FAFISKAL" >Fixed Asset</option>
					</select>
				</div>
			 </div>
			 <div class="col-md-4">
				<div class="form-group">
					<label>Nama Perusahaan</label>
					<select class="form-control" id="perusahaan_trx_fa" name="perusahaan_trx_fa">
						<?php
							$sql   = "select * from SIMTAX_MASTER_PERUSAHAAN where AKTIF = 'Y'";
							$query = $this->db->query($sql);
							
							foreach($query->result_array() as $row)	{
								$kode_perusahaan	= $row['KODE_PERUSAHAAN'];
								$nama_perusahaan	= $row['NAMA_PERUSAHAAN'];
								echo "<option value='".$kode_perusahaan."'>".$nama_perusahaan."</option>";
							}
							$query->free_result();
						?>
					</select>
				</div>
			 </div> 
		</div>
		<div class="row">
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnGetTrxFA" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Download</span></button>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnSetTrxFA" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Process</span></button>
				</div>
			 </div>
		</div>
		Bulan dan tahun diatas adalah Period Name
	</div>
	
    <?php if($this->session->userdata('kd_cabang') == '000'): ?>
	<div class="white-box boxshadow">
		<label>Download Data Trial Balance</label>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan_tb" name="bulan_tb">
						<?php
						$namaBulan = list_month();
						$bln       = date('m') ;
						 /*if ($bln>1){
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
			 <div class="col-md-2">
				<div class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="tahun_tb" name="tahun_tb">
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
			
			 <div class="col-md-3">
				<div class="form-group">
					<label>Kelompok Akun</label>
					<select class="form-control" id="akun_tb" name="akun_tb">
						<?php
							$sql = "select substr(ffv.FLEX_VALUE,1,1) KODE_AKUN, ffvt.DESCRIPTION
										  from fnd_flex_values ffv
											 , fnd_flex_values_tl ffvt
											 , fnd_flex_value_sets ffvs
										where ffv.flex_value_id = ffvt.flex_value_id
										  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
										  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
										  and ffv.FLEX_VALUE like '%0000000'
										  and substr(ffv.FLEX_VALUE,1,1) in (1,2,3,4,5,6,7,8,9)
										  order by ffv.FLEX_VALUE";
							$query = $this->db->query($sql);
							
							foreach($query->result_array() as $row)	{
								
								$kode_akun	= $row['KODE_AKUN'];
								$nama_akun	= $row['DESCRIPTION'];
								echo "<option value='".$kode_akun."'>".$kode_akun." - ".$nama_akun."</option>";
							}
							echo "<option value='TBGLBAL'>9 - KARTU KERJA</option>";
							$query->free_result();
						?>
					</select>
				</div>
			 </div>
			 <div class="col-md-4">
				<div class="form-group">
					<label>Nama Perusahaan</label>
					<select class="form-control" id="ledger_tb" name="ledger_tb">
						<?php
							$sql   = "select * from SIMTAX_MASTER_LEDGER where ledger_id = 2022";
							$query = $this->db->query($sql);
							
							foreach($query->result_array() as $row)	{
								
								$kode_perusahaan	= $row['LEDGER_ID'];
								$nama_perusahaan	= $row['DESCRIPTION'];
								echo "<option value='".$kode_perusahaan."'>".$nama_perusahaan."</option>";
							}
							$query->free_result();
							?>
					</select>
				</div>
			 </div> 
		</div>
		<div class="row">
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnGetTB" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Download</span></button>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
					<button id="btnSetTB" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" >
					<span>Process</span></button>
				</div>
			 </div>
		</div>
		Bulan dan tahun diatas adalah Period Name
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">
					<div class="row">
					  <div class="col-md-6">
						Daftar History Proses
					  </div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<table width="100%" class="display cell-border stripe hover small" id="tabledata">
						<thead>
							<tr>
								<th>REQUEST ID</th>
								<th>TGL REQUEST</th>
								<th>PARAMETER BULAN</th>
								<th>PARAMETER TAHUN</th>
								<th>PARAMETER CABANG</th>
								<th>CABANG</th>
								<th>TIPE DOKUMEN</th>
								<th>STATUS</th>
							</tr>
						</thead>
					</table>
					</div>
			   </div>
			</div>
		</div>
	</div>

	<div class="white-box boxshadow">
		<label>Detail data yang diproses</label>
	</div>

</div>

<script>
//ini utk pelaporan pajak
$(document).ready(function() {

		var l_bulan  = "";
		var l_tahun  = "";
		var l_cabang = "";
		var l_jenis  = "";
		
		getSelectCabang();

		audioSuccess = new Audio(baseURL + '/notification.ogg');
		
		$("#btnGetRef").on("click", function(){
				l_bulan = $("#bulan_ref").val();
				l_tahun = $("#tahun_ref").val();
				l_jenis = $("#jenis_ref").val();
				bootbox.confirm({
					title: "Download Data " + l_jenis,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/download_ref',
								type	: "POST",
								data	: ({srcBulan:l_bulan,srcTahun:l_tahun,scrJenis:l_jenis}),
								beforeSend	: function(){
									$("body").addClass("loading2")
                  					$("#message").html('Sedang Download Data Referensi...');
								},
								success	: function(result){
									if (result==1) {
										waitingTime = 10000;
										setTimeout(function(){
											$("body").removeClass("loading2");
											$("#message").html('');
											audioSuccess.play();
											flashnotif('Sukses', 'Data Berhasil direquest', 'success');
											table.draw();
										}, waitingTime);
									} else if (result==2) {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Download tidak diperbolehkan','error');
										table.draw();
									} 
									else {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Data gagal direquest ','error');
										table.draw();
									}
								}
							});
						}
					}
				});
				
		});

		$("#btnGetTrx").on("click", function(){
				l_bulan      = $("#bulan_trx").val();
				l_tahun      = $("#tahun_trx").val();
				l_cabang     = $("#cabang_trx").val();
				l_jenis      = $("#jenis_trx").val();
				l_perusahaan = $("#perusahaan_trx").val();
				
				bootbox.confirm({
					title: "Download Data " + l_jenis ,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/download_trx',
								type	: "POST",
								data	: ({srcBulan:l_bulan,srcTahun:l_tahun,srcKodeCabang:l_cabang, scrJenis:l_jenis,scrPerusahaan:l_perusahaan}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Download Data Transaksi...');
								},
								success	: function(result){
									if (result==1) {
										if(l_jenis == "PPNKELUAR"){
											waitingTime = 20000;
										}
										else{
											waitingTime = 5000;
										}
										setTimeout(function(){
											$("body").removeClass("loading2");
											$("#message").html('');
											audioSuccess.play();
											flashnotif('Sukses', 'Data berhasil direquest', 'success');
											table.draw();
										}, waitingTime);
									} else if (result==2) {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Download tidak diperbolehkan', 'error');
										table.draw();
									} 
									else {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Data gagal direquest', 'error');
										table.draw();
									}
								}
							});
						}
					}
				});
				
		});

		$("#btnGetTrxFA").on("click", function(){
				l_bulan_from = $("#bulan_trx_from").val();
				l_bulan_to   = $("#bulan_trx_to").val();
				l_tahun      = $("#tahun_trx_fa").val();
				l_cabang     = $("#cabang_trx_fa").val();
				l_jenis      = $("#jenis_trx_fa").val();
				l_perusahaan = $("#perusahaan_trx_fa").val();
				
				bootbox.confirm({
					title: "Download Data " + l_jenis ,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/download_trx_fa',
								type	: "POST",
								data	: ({srcBulanfrom:l_bulan_from,srcBulanto:l_bulan_to,srcTahun:l_tahun,srcKodeCabang:l_cabang, scrJenis:l_jenis,scrPerusahaan:l_perusahaan}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Download Data Transaksi...');
								},
								success	: function(result){
									if (result==1) {
										waitingTime = 5000;
										setTimeout(function(){
											$("body").removeClass("loading2");
											$("#message").html('');
											audioSuccess.play();
											flashnotif('Sukses', 'Data berhasil direquest', 'success');
											table.draw();
										}, waitingTime);
									} else if (result==2) {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Download tidak diperbolehkan', 'error');
										table.draw();
									} 
									else {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Data gagal direquest', 'error');
										table.draw();
									}
								}
							});
						}
					}
				});
				
		});
		
		$("#btnGetTB").on("click", function(){
				l_bulan        = $("#bulan_tb").val();
				l_tahun		= $("#tahun_tb").val();
				l_cabang	= $("#cabang_tb").val();
				l_ledger	= $("#ledger_tb").val();
				l_akun		= $("#akun_tb").val();
				
				bootbox.confirm({
					title: "Download Data Trial Balance",
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/download_tb',
								type	: "POST",
								data	: ({srcBulan:l_bulan,
											srcTahun:l_tahun,
											srcKodeCabang:l_cabang, 
											srcLedger:l_ledger,
											srcAkun:l_akun
											}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Download Data Trial Balance...');
								},
								success	: function(result){
									if (result==1) {
										waitingTime = 10000;
										setTimeout(function(){
											$("body").removeClass("loading2");
											$("#message").html('');
											audioSuccess.play();
											flashnotif('Sukses', 'Data Berhasil direquest', 'success');
											table.draw();
										}, waitingTime);
									} else if (result==2) {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Download tidak diperbolehkan','error');
										table.draw();
									} 
									else {
										$("body").removeClass("loading2");
										flashnotif('Error', 'Data gagal direquest ','error');
										table.draw();
									}
								}
							});
						}
					}
				});
				
		});
		
		$("#btnSetTrx").on("click", function(){
				l_bulan      = $("#bulan_trx").val();
				l_tahun      = $("#tahun_trx").val();
				l_cabang     = $("#cabang_trx").val();
				l_jenis      = $("#jenis_trx").val();
				l_perusahaan = $("#perusahaan_trx").val();
				bootbox.confirm({
					title: "Import Data "+l_jenis,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/process_trx',
								type	: "POST",
								data	: ({srcBulan:l_bulan,srcTahun:l_tahun,srcKodeCabang:l_cabang, scrJenis:l_jenis,scrPerusahaan:l_perusahaan}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Proses Data Transaksi...');
								},
								success	: function(result){
									if (result==1) {
										 $("body").removeClass("loading2");
										 flashnotif('Sukses', 'Data Berhasil Diproses', 'success');
									} else if(result==2) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File belum tersedia untuk di proses ', 'error');
									} else if(result==3) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'Proses pemindahan data staging gagal ', 'error');
									} else {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File gagal di proses ', 'error');
									}
									$("#message").html('');
									table.draw();
								}
							});
						}
					}
				});
				
		});


		$("#btnSetTrxFA").on("click", function(){
				l_bulan_from = $("#bulan_trx_from").val();
				l_bulan_to   = $("#bulan_trx_to").val();
				l_tahun      = $("#tahun_trx_fa").val();
				l_cabang     = $("#cabang_trx_fa").val();
				l_jenis      = $("#jenis_trx_fa").val();
				l_perusahaan = $("#perusahaan_trx_fa").val();
				bootbox.confirm({
					title: "Import Data "+l_jenis,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/process_trx_fa',
								type	: "POST",
								data	: ({srcBulanfrom:l_bulan_from,srcBulanto:l_bulan_to,srcTahun:l_tahun,srcKodeCabang:l_cabang, scrJenis:l_jenis,scrPerusahaan:l_perusahaan}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Proses Data Transaksi...');
								},
								success	: function(result){
									if (result==1) {
										 $("body").removeClass("loading2");
										 flashnotif('Sukses', 'Data Berhasil Diproses', 'success');
									} else if(result==2) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File belum tersedia untuk di proses ', 'error');
									} else if(result==3) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'Proses pemindahan data staging gagal ', 'error');
									} else {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File gagal di proses ', 'error');
									}
									$("#message").html('');
									table.draw();
								}
							});
						}
					}
				});
				
		});


		$("#btnSetRef").on("click", function(){
				l_bulan = $("#bulan_ref").val();
				l_tahun = $("#tahun_ref").val();
				l_jenis = $("#jenis_ref").val();
				bootbox.confirm({
					title: "Import Data "+l_jenis,
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/process_ref',
								type	: "POST",
								data	: ({srcBulan:l_bulan,srcTahun:l_tahun, scrJenis:l_jenis}),
								beforeSend	: function(){
									$("body").addClass("loading2")
									$("#message").html('Sedang Proses Data Referensi...');
								},
								success	: function(result){
									if (result==1) {
										 $("body").removeClass("loading2");
										 flashnotif('Sukses', 'Data Berhasil Diproses', 'success');
									} else if(result==2) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File belum tersedia untuk di proses ', 'error');
									} else if(result==3) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'Proses pemindahan data staging gagal ', 'error');
									} else {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File gagal di proses ' + result.message, 'error');
									}
									$("#message").html('');
									table.draw();
								}
							});
						}
					}
				});
				
		});
		
		$("#btnSetTB").on("click", function(){
				l_bulan  = $("#bulan_tb").val();
				l_tahun  = $("#tahun_tb").val();
				l_cabang = $("#cabang_tb").val();
				l_ledger = $("#ledger_tb").val();
				l_akun   = $("#akun_tb").val();
				bootbox.confirm({
					title: "Import Data Trial Balance",
					message: "Aksi import ini akan menghapus data lama. Apakah anda ingin melanjutkan?",
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
							$.ajax({
								url		: baseURL + 'Sync_data_ebs/process_tb',
								type	: "POST",
								data	: ({srcBulan:l_bulan,
											srcTahun:l_tahun, 
											srcCabang:l_cabang,
											srcLedger:l_ledger,
											srcAkun:l_akun
											}),
								beforeSend	: function(){
									$("body").addClass("loading2");
									$("#message").html('Sedang Proses Import Data Trial Balance...');
								},
								success	: function(result){
									if (result==1) {
										 $("body").removeClass("loading2");
										 flashnotif('Sukses', 'Data Berhasil Di Proses', 'success');
									} else if(result==2) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File belum tersedia untuk di proses ', 'error');
									} else if(result==3) {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'Proses pemindahan data staging gagal ', 'error');
									} else {
										 $("body").removeClass("loading2");
										 flashnotif('Error', 'File gagal di proses ' + result.message, 'error');
									}
									$("#message").html('');
									table.draw();
								}
							});
						}
					}
				});
				
		});

	Pace.track(	function(){		
	$('#tabledata').DataTable({
		"serverSide"	: true,
		"processing"	: true,
		"ajax"			: {
							"url"  		: baseURL + 'Sync_data_ebs/load_history',
							"type" 		: "POST",
						  },
		 "language"		: {
				"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
				"infoEmpty"		: "Data Kosong",
				"processing"	:'<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
				"search"		: "_INPUT_"
			},		 
		   "columns": [
				{ "data": "req_id", "class":"text-center" },
				{ "data": "req_date", "class":"text-left"},
				{ "data": "bulan"},
				{ "data": "tahun"},
				{ "data": "kode_cabang"},
				{ "data": "nama_cabang"},
				{ "data": "tipe_doc"},
				{ "data": "status_import"}
			],			
		"columnDefs": [ 
			 {
				"targets": [  ],
				"visible": false
			}
		],			
		"fixedColumns"		: false,
		 "select"			: true,
		 "scrollY"			: 360, 
		 "scrollCollapse"	: true, 
		 "scrollX"			: true,
		 "ordering"			: false
		});
	});
	
	table = $('#tabledata').DataTable();
			
	$("input[type=search]").addClear();
	$('.dataTables_filter input[type="search"]').attr({placeholder:'Search Request / Tipe Dok / Cabang...', title:'Search Request / Tipe Dok / Cabang...'}).css({'width':'260px','display':'inline-block'}).addClass('input-sm');
	
	$("#tabledata_filter .add-clear-x").on('click',function(){
		table.search('').column().search('').draw();
	});
	
	function getSelectCabang()
	{
		$.ajax({
				url		: baseURL + 'master/load_master_cabang',
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#cabang_trx").html("");
					$("#cabang_trx").html(result);
					$("#cabang_trx_fa").html("");
					$("#cabang_trx_fa").html(result);
				}
		});
	}

 });
</script>