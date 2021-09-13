<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

 <div id="list-data">
	 <div class="white-box boxshadow">
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
							for ($i=1;$i< count($namaBulan);$i++){
								$selected = ($i==$bln)?"selected":"";
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
							for($i=$tAwal; $i<=$tAkhir; $i++){
								$selected = ($i == $tahun) ? "selected" : "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}
						?>
					</select>
				</div>
			 </div>
			 <div class="col-md-2">
				<div class="form-group">
						<label>Jenis Pajak</label>
						<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="ALLJURNAL" data-name="ALLJURNAL" > ALL JURNAL </option>
						<option value="PPN MASUKAN" data-name="PPN MASUKAN" > EFAKTUR PPN MASUKAN </option>
						<option value="PPN KELUARAN" data-name="PPN KELUARAN" > EFAKTUR PPN KELUARAN </option>
					</select>	
				</div>
			 </div>
		</div>
		<div class="row">	 
			 <div class="col-md-2">
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
				<label>&nbsp;</label>
				<button id="btnExportCSV" class="btn btn-success btn-rounded btn-block" type="button" ><i class="fa fa-download fa-fw"></i> <span>EXPORT CSV</span></button>
				</div>
			</div>
		</div>
	 </div>
	<div id="table-1" class="row">
        <div class="col-lg-12">
            <div class="panel panel-info boxshadow animated slideInDown">
                <div class="panel-heading">
					<div class="row">
					  <div class="col-sm-6">
					  	<div class="nama-table">DETAIL JURNAL TRANSAKSI</div>
					  </div>
					  <div class="col-sm-6">
					  	<div class="navbar-right">
					  		<!-- <button type="button" id="btnAdd1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-plus"></i> ADD</button> -->
					  		<button type="button" id="btnEdit1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
					  		<button type="button" id="btnDelete1" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-trash"></i> DELETE</button>
						</div>
					  </div>
					</div>
				</div>
                <div class="panel-body"> 
					<div class="table-responsive">
						<table width="100%" class="display cell-border stripe hover small" id="table_faktur">
	                        <thead>
	                            <tr>
	                            	<th>LEDGER ID</th>
	                            	<th>PERIODE</th>
	                            	<th>JE SOURCE</th>
	                            	<th>DOC. NUMBER</th>
	                            	<th>NOMOR FAKTUR</th>
	                            	<th>BULAN BUKU</th>
									<th>TAHUN BUKU</th>
									<th>TANGGAL POSTING</th>
									<th>DESC. JENIS TRANSAKSI</th>
	                            	<th>LINE </th>
	                            	<th>AKUN</th>
	                            	<th>DESC. AKUN</th>
									<th>AMOUNT</th>
									<th>SUB LEDGER</th>
									<th>CODE SUB LEDGER</th>
									<th>DESC SUB LEDGER</th>
									<th>DESC. HEADER</th>
									<th>REFERENCE LINE</th>
	                            	<th>PROFIT CENTER</th>
									<th>PROFIT CENTER DESC.</th>
									<th>COST CENTER</th>
									<th>COST CENTER DESC</th>
									<th>PO NUMBER</th>
									<th>TANGGAL PO</th>
									<th>NOMOR INVOICE</th>
									<th>TANGGAL INVOICE</th>
									<th>CABANG</th>
									<th>STATUS DOKUMEN</th>
									<th>INVOICE ID</th>
	                            </tr>
	                        </thead>
	                    </table>
	                </div>
				</div>
            </div>
        </div>
    </div>
		<div class="row summary-detailjurnal">
			<div class="col-lg-12">
				<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">
						<div class="row">
						  <div class="col-lg-6">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary">Ringkasan Detail Jurnal Transaksi</a>
						  </div>
						</div>
					</div>
				   <div id="collapse-summary" class="panel-collapse collapse in">
					<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summaryAll2"> 
									<thead>
										<tr>
											<th>SALDO AWAL</th>
											<th>MUTASI DEBET</th> 
											<th>MUTASI KREDIT</th>
											<th>SALDO AKHIR</th>
											<th>JUMLAH DIBAYARKAN</th>
											<th>SELISIH</th>
										</tr>
									</thead>
								</table>
								</br>
							 </div>
							</div>
					</div>
					 <div class="row">
						</br>
						</br>
						<div class="col-lg-12 text-center">
							<button id="btnsaldoAwal" class="btn btn-info btn-rounded custom-input-width" type="button" ><i class="fa fa fa-save"></i> <span>SAVE</span></button>
						</div>
					</div>
				   </div>
			 </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
				<div id="accordion-3" class="panel panel-info animated slideInDown">
				<div class="panel-footer">
					<div class="row">
						<div class="col-lg-12 text-center">
							<button id="btnSubmit" class="btn btn-danger btn-rounded custom-input-width" type="button"><i class="fa fa-share-square-o"></i> <span>SUBMIT</span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="tambah-data">
	<form role="form" id="form-wp" data-toggle="validator">
		<div class="white-box boxshadow">
		  	<div class="row">
				<div class="col-lg-12 align-center">
					<h2 id="capAdd" class="text-center">EDIT DATA</h2>
				</div>	
			</div>
			<div class="row">
				<hr>
			</div>
			<div class="row">
				<div class="col-md-6 ">
					<div class="form-group">
						<input type="hidden" class="form-control" id="idDetailJurnal" name="idDetailJurnal">
						<input type="hidden" class="form-control" id="isnewRecord" name="isnewRecord" value="1">
						<input type="hidden" class="form-control" id="fAddNamaPajak" name="fAddNamaPajak">
						<input type="hidden" class="form-control" id="fAddBulan" name="fAddBulan">
						<input type="hidden" class="form-control" id="fAddTahun" name="fAddTahun">
						<input type="hidden" class="form-control" id="fAddPembetulan" name="fAddPembetulan">
						<label>DOC. NUMBER</label>
						<div class="input-group">
							<input class="form-control" id="docnumber" name="docnumber" placeholder="Doc. Number" type="text" required>
						</div>
						<div id="error1"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nofaktur" class="control-label">NOMOR FAKTUR</label>
						<input type="text" class="form-control" id="nofaktur" name="nofaktur" placeholder="NO. FAKTUR" >
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="bulanbuku" class="control-label">BULAN BUKU</label>
						<select id="bulanbuku" class="form-control" name="bulanbuku" placeholder="Bulan Buku *(Tidak Boleh Kosong)" data-toggle="validator" data-error="Mohon isi Bulan Buku" required>
                            <option value="">-- Pilih Bulan --</option>
                            <option value=1> Januari </option>
                            <option value=2> Februari </option>
                            <option value=3> Maret </option>
							<option value=4> April </option>
							<option value=5> Mei </option>
							<option value=6> Juni </option>
							<option value=7> Juli </option>
							<option value=8> Agustus </option>
							<option value=9> September </option>
							<option value=10> Oktober </option>
							<option value=11> November </option>
							<option value=12> Desember </option>
                        </select>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tahunbuku" class="control-label">TAHUN BUKU</label>
						<select class="form-control" id="tahunbuku" name="tahunbuku" placeholder="Tahun" data-error="Mohon isi Tahun" required>
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
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nomorinvoice" class="control-label">NOMOR INVOICE</label>
						<input type="text" class="form-control" id="nomorinvoice" name="nomorinvoice" placeholder="NO INVOICE" data-toggle="validator" data-error="Mohon isi No Invoice" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggalinvoice" class="control-label">TANGGAL INVOICE</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggalinvoice" name="tanggalinvoice" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					<label for="tanggalposting" class="control-label">TANGGAL POSTING</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggalposting" name="tanggalposting" placeholder="dd/mm/yyyy" data-toggle="validator" data-error="Mohon isi Tanggal Posting"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="descjenistransaksi" class="control-label">JENIS TRANSAKSI</label>
						<input type="text" class="form-control" id="descjenistransaksi" name="descjenistransaksi" placeholder="JENIS TRANSAKSI">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="account" class="control-label">ACCOUNT</label>
						<input type="text" class="form-control" id="account" name="account" placeholder="ACCOUNT" data-toggle="validator" data-error="Mohon isi Account" readonly>
						<input type="text" class="form-control" id="descaccount" name="descaccount" placeholder="DESCACCOUNT" data-toggle="validator" data-error="Mohon isi Desc. Account" readonly>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="amount" class="control-label">AMOUNT</label>
						<input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" data-toggle="validator" data-error="Mohon isi Amount" required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="subledger" class="control-label">SUB LEDGER</label>
						<input type="text" class="form-control" id="codesubledger" name="codesubledger" placeholder="SUB LEDGER" data-toggle="validator" data-error="Mohon isi Sub Ledger" readonly>
						<input type="text" class="form-control" id="subledger" name="subledger" placeholder="SUB LEDGER" data-toggle="validator" data-error="Mohon isi Sub Ledger" readonly>
						<input type="text" class="form-control" id="descsubledger" name="descsubledger" placeholder="DESC. SUB LEDGER" data-toggle="validator" data-error="Mohon isi Sub Ledger" readonly>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="descriptionheader" class="control-label">DESCRIPTION HEADER</label>
						<textarea class="form-control" rows="3" id="descriptionheader" name="descriptionheader" placeholder="DESCRIPTION HEADER" readonly></textarea>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10">
					<div class="form-group">
						<label for="referenceline" class="control-label">REFERENCE LINE</label>
						<input type="text" class="form-control" id="referenceline" name="referenceline" placeholder="REFERENCE LINE" data-toggle="validator" data-error="Mohon isi Reference Line" readonly>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="referenceline2" class="control-label">&nbsp;</label>
					</div>
				</div>
			</div>	
			<div class="row dokumen_group">	
				<div class="col-md-6">
					<div class="form-group">
						<label for="profitcenter" class="control-label">PROFIT CENTER</label>
						<input type="text" class="form-control" id="profitcenter" name="profitcenter" placeholder="PROFIT CENTER" data-toggle="validator" data-error="Mohon isi Profit Center" readonly>
						<input type="text" class="form-control" id="profitcenterdesc" name="profitcenterdesc" placeholder="PROFIT CENTER DESC." data-toggle="validator" data-error="Mohon isi Profit Center Desc." readonly>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="costcenter" class="control-label">COST CENTER</label>
						<input type="text" class="form-control" id="costcenter" name="costcenter" placeholder="COST CENTER" data-toggle="validator" data-error="Mohon isi Cost Center" readonly>
						<input type="text" class="form-control" id="costcenterdesc" name="costcenterdesc" placeholder="COST CENTER DESC." data-toggle="validator" data-error="Mohon isi Cost Center Desc." readonly>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row faktur_group">
				<div class="col-md-6">
					<div class="form-group">
						<label for="ponumber" class="control-label">PO NUMBER</label>
						<input type="text" class="form-control" id="ponumber" name="ponumber" placeholder="NO PO" data-toggle="validator" data-error="Mohon isi No PO">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tanggalpo" class="control-label">TANGGAL PO</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker-autoclose" id="tanggalpo" name="tanggalpo" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
						</div>
					</div>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-6">
					<div class="form-group">
						<label for="cabang" class="control-label">CABANG</label>
						
						<select id="cabang" name="kd_cabang" class="form-control" autocomplete="off" data-toggle="validator" data-error="Please fill out this field" required>
                                    <option value=""> Pilih Cabang </option>
                                    <?php foreach ($list_cabang as $cabang):?>
                                    <option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
                                    <?php endforeach?>
                                </select>		
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="lineno" class="control-label">LINE NO</label>
						<input type="number" class="form-control" id="lineno" name="lineno" placeholder="LINE NO" data-toggle="validator" data-error="Mohon isi Line No" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="navbar-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>
					<button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
					<button type="submit" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
				</div>
			</div>
		</div>
	</form>	
</div>
		

</div>


<script>
    $(document).ready(function() {
			var table1                 	= "",
			table_wp                   	= "",
			val_detail_jurnal_id        = "",
			val_ledger_id        		= "",
			val_user_je_source_name     = "",
			val_docnumber        		= "",
			val_nomor_faktur         	= "",
			val_bulan_buku             	= "",
			val_tahun_buku             	= "",
			val_tanggal_posting         = "",
			val_desc_jenis_transaksi    = "",
			val_lineno        			= "",
			val_account          		= "",
			val_descaccount     		= "",
			val_amount           		= "",
			val_subledger  				= "",
			val_codesubledger        	= "",
			val_descsubledger   		= "",
			val_descriptionheader       = "",
			val_referenceline   		= "",
			val_profitcenter        	= "",
			val_profitcenterdesc   		= "",
			val_costcenter        		= "",
			val_costcenterdesc   		= "",
			val_ponumber       			= "",
			val_tanggalpo   			= "",
			val_cabang        			= "",
			val_nama_pajak				= "";
			val_nomor_invoice			= "";
			val_tanggal_invoice			= "";
			var monthsname = [ " ","Januari", "Februari", "Maret", "April", "Mei", "Juni", 
           "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];
			
		$("#amount").number(true,2);
		//$("#d-FormCsv").hide();
		$("#tambah-data").hide();

		valueAdd();
		getSummary();
		getSelectCabang();

/* DETAIL JURNAL */
		 Pace.track(function(){
		   $('#table_faktur').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppnmasa_detail_jurnal_transaksi/load_detail_jurnal',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $("#pembetulanKe").val();
										d._searchCabang     = $('#cabang_trx').val();
									},
									"dataSrc" : function(res) {
											if(res.isdoksubmit){
												$("#btnSubmit").attr("disabled",true);
											} else {
												$("#btnSubmit").attr("disabled",false);
											}
											return res.data
									}
								},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "ledger_id" },
					{ "data": "period_name", "class":"text-left", "width" : "60px" },
					{ "data": "user_je_source_name" },
					{ "data": "docnumber" },
					{ "data": "nomor_faktur" },
					{ "data": "bulan_buku" },
					{ "data": "tahun_buku" },
					{ "data": "tanggal_posting" },
					{ "data": "desc_jenis_transaksi" },
					{ "data": "lineno", "class":"text-center"},
					{ "data": "account", "class":"text-center"},
					{ "data": "descaccount", "class":"text-left", "height" : "10px" },
					{ "data": "amount", "class":"text-right" },
					{ "data": "subledger"},
					{ "data": "codesubledger", "class":"text-center"},
					{ "data": "descsubledger"},
					{ "data": "descriptionheader"},
					{ "data": "referenceline"},
					{ "data": "profitcenter", "class":"text-center"},
					{ "data": "profitcenterdesc", "class":"text-left"},
					{ "data": "costcenter", "class":"text-center" },
					{ "data": "costcenterdesc", "class":"text-left"},
					{ "data": "ponumber", "class":"text-center"},
					{ "data": "tanggalpo", "class":"text-center"},
					{ "data": "nomorinvoice", "class":"text-left"},
					{ "data": "tanggalinvoice", "class":"text-center"},
					{ "data": "kode_cabang", "class":"text-center"},
					{ "data": "statusdokumen", "class":"text-center"},
					{ "data": "invoice_id", "class":"text-center"}
				],
			"columnDefs": [
				{
					"targets": [ 5 ],
					"visible": false
				}
			],
			 "select"			: true,
			 "scrollY"			: 400, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			 "ordering"			: false,
			 "bAutoWidth" : false
			});
		 });
		table1 = $('#table_faktur').DataTable();
		//table1.on('error.dt', function(e, settings, techNote, message) {
		//	pushTableError($("#table-1 .nama-table").html());
		//})
		
		$("#list-data input[type=search]").addClear();
		$('#list-data #table-1 .dataTables_filter input[type="search"]').attr('placeholder','Cari No Faktur/ No Invoice/ Subledger / No PO ...').css({'width':'350px','display':'inline-block'}).addClass('form-control input-sm');
		
		$("#table_faktur_filter .add-clear-x").on('click',function(){
			table1.search('').column().search('').draw();
		});
		
		$('#table_faktur tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empty();
			} else {
				table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d                    = table1.row( this ).data();
				val_detail_jurnal_id        = d.detail_jurnal_id;
				val_ledger_id        		= d.ledger_id;
				val_user_je_source_name     = d.user_je_source_name;
				val_docnumber        		= d.docnumber;
				val_nomor_faktur         	= d.nomor_faktur;
				val_bulan_buku             	= d.bulan_buku;
				val_tahun_buku             	= d.tahun_buku;
				val_tanggal_posting         = d.tanggal_posting;
				val_desc_jenis_transaksi    = d.desc_jenis_transaksi;
				val_lineno        			= d.lineno;
				val_account          		= d.account;
				val_descaccount     		= d.descaccount;
				val_amount           		= d.amount;
				val_subledger  				= d.subledger;
				val_codesubledger        	= d.codesubledger;
				val_descsubledger   		= d.descsubledger;
				val_descriptionheader       = d.descriptionheader;
				val_referenceline   		= d.referenceline;
				val_profitcenter        	= d.profitcenter;
				val_profitcenterdesc   		= d.profitcenterdesc;
				val_costcenter        		= d.costcenter;
				val_costcenterdesc   		= d.costcenterdesc;
				val_ponumber       			= d.ponumber;
				val_tanggalpo   			= d.tanggalpo;
				val_cabang        			= d.kode_cabang;
				val_nomor_invoice        	= d.nomorinvoice;
				val_tanggal_invoice        	= d.tanggalinvoice;
				valueGrid();
				showHide();
				if(d.statusdokumen != 'SUBMIT'){
					$("#btnEdit1").removeAttr('disabled');
					$("#btnDelete1").removeAttr('disabled');
				} else {
					$("#btnEdit1").attr("disabled",true);
					$("#btnDelete1").attr("disabled",true);
				}
			}

		} ).on("dblclick", "tr", function () {
			table1.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
				var d                    = table1.row( this ).data();
				val_detail_jurnal_id        = d.detail_jurnal_id;
				val_ledger_id        		= d.ledger_id;
				val_user_je_source_name     = d.user_je_source_name;
				val_docnumber        		= d.docnumber;
				val_nomor_faktur         	= d.nomor_faktur;
				val_bulan_buku             	= d.bulan_buku;
				val_tahun_buku             	= d.tahun_buku;
				val_tanggal_posting         = d.tanggal_posting;
				val_desc_jenis_transaksi    = d.desc_jenis_transaksi;
				val_lineno        			= d.lineno;
				val_account          		= d.account;
				val_descaccount     		= d.descaccount;
				val_amount           		= d.amount;
				val_subledger  				= d.subledger;
				val_codesubledger        	= d.codesubledger;
				val_descsubledger   		= d.descsubledger;
				val_descriptionheader       = d.descriptionheader;
				val_referenceline   		= d.referenceline;
				val_profitcenter        	= d.profitcenter;
				val_profitcenterdesc   		= d.profitcenterdesc;
				val_costcenter        		= d.costcenter;
				val_costcenterdesc   		= d.costcenterdesc;
				val_ponumber       			= d.ponumber;
				val_tanggalpo   			= d.tanggalpo;
				val_cabang        			= d.kode_cabang;
				val_nomor_invoice        	= d.nomorinvoice;
				val_tanggal_invoice        	= d.tanggalinvoice;
			valueGrid();
			showHide();
			//$("#btnEdit1").removeAttr('disabled');
			if(d.statusdokumen != 'SUBMIT'){
				$("#list-data").slideUp(700);
				$("#tambah-data").slideDown(700);
				$("#capAdd").html("<span class='label label-danger'>Edit Data "+val_nama_pajak+" Bulan "+ monthsname[val_bulan_buku]+" Tahun "+val_tahun_buku+"</span>");
			} else {
				$("#btnEdit1").attr("disabled",true);
				$("#btnDelete1").attr("disabled",true);
			}
			
		} );

/* DETAIL JURNAL END */

	$('.summary-detailjurnal').hide();	
    //*SUMMARY*//
	function getSummary(){

		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summaryAll2' ) ) {
		 $('#tabledata-summaryAll2').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_summary_detail_jurnal',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._category         = "Rekonsiliasi";
									}
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",
					"infoEmpty"		: "Data Kosong",
					"processing"	:'<img src="'+ baseURL +'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "saldo_awal", "class":"text-center" },
					{ "data": "mutasi_debet", "class":"text-center" },
					{ "data": "mutasi_kredit", "class":"text-center" },
					{ "data": "saldo_akhir", "class":"text-center" },
					{ "data": "jumlah_dibayarkan", "class":"text-center" },
					{ "data": "selisih", "class":"text-center" }
				],
			 "scrollCollapse"	: true,
			 "scrollX"			: true,
			 "ordering"			: false
			});
			
		} else {
			$('#tabledata-summaryAll2').DataTable().ajax.reload();
		}

	}
	//*END SUMMARY*//

		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		
		$("#btnView").on("click", function(){
			//valueAdd();
			//getSummary();
			c	= $("#cabang_trx").val();
	
			if(c == ''){
				alert('Mohon pilih cabang');
				return;
			}
			table1.ajax.reload();
			//errorCheck();
		});
		
		$("#bulan, #tahun, #pembetulanKe").on("change", function(){
			valueAdd();
		});

		$('#form-wp').validator().on('submit', function(e) {
		  if (e.isDefaultPrevented()) {
		  }
		  else {
		  	 $.ajax({
				url		: baseURL + 'ppnmasa_detail_jurnal_transaksi/save_detail_jurnal',
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==true) {
						table1.ajax.reload(null, false);
						$("body").removeClass("loading");
						$("#list-data").slideDown(700);
						$("#tambah-data").slideUp(700);
						flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						getSummary();
						//empty();
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error', result,'error' );
					}
				}
			});
		  }
		  e.preventDefault();
		});

		$("#btnDelete1").click(function(){
			  bootbox.confirm({
				title: "Hapus data <span class='label label-danger'>"+val_nama_pajak+"</span> ?",
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
							url		: baseURL + 'ppnmasa_detail_jurnal_transaksi/delete_detail_jurnal',
							type	: "POST",
							data	: $('#form-wp').serialize(),
							beforeSend	: function(){
								 $("body").addClass("loading");
								},
							success	: function(result){
								if (result==1) {
									$("body").removeClass("loading");
									table1.ajax.reload(null, false);
									getSummary();
									//empty();
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


		function getFormCSV(){
			if (table1.data().any() ){
				$("#d-FormCsv").slideDown(700);
			} else {
				$("#d-FormCsv").slideUp(700);
			}
		}

		
		$('.datepicker-autoclose').datepicker({
		    format: 'dd/mm/yyyy',
			autoclose: true
		});

		$("#btnExportCSV").on("click", function(){

			var urlnya = baseURL + 'ppnmasa_detail_jurnal_transaksi/export_format_csv';
			var j      = $("#jenisPajak").val();
			var b      = $("#bulan").val();
			var t      = $("#tahun").val();
			var p      = $("#pembetulanKe").val();
			//var ke      = $("#kategori_eksport").val();

			if (table1.data().any()){
				window.open(urlnya+'?pajak='+j+'&masa='+b+'&tahun='+t+'&pembetulan='+p);
				window.focus();
			}
			else{
				flashnotif('Info','Data Kosong!','warning' );
				return false;
			}
			
		});	

		$("#btnSubmit").click(function(){
			if (table1.data().any()){

				nama_pajak	= $("#jenisPajak").val();		
				j 	= $("#jenisPajak").val();
				b	= $("#bulan").val();
				t	= $("#tahun").val();
				c	= $("#cabang_trx").val();
	
				if(c == ''){
					alert('Mohon pilih cabang');
					return;
				} else if (b == '') {
					alert('Mohon isi Bulan');
					return;
				} else if (t == '') {
					alert('Mohon isi Tahun');
					return;
				}

				jnm	= $("#jenisPajak").find(":selected").attr("data-name");
				bnm	= $("#bulan").find(":selected").attr("data-name");
				pbt	= $("#pembetulanKe").find(":selected").attr("data-name");
				cnm	= $("#cabang_trx").find(":selected").attr("data-name");
				
				if (j != '' && b != '' && t != '') 
				{ 
					bootbox.confirm({
					title: "Submit data Detail Jurnal Transaksi Cabang <span class='label label-danger'>"+cnm+"</span>  Bulan <span class='label label-danger'>"+bnm+"</span> Tahun <span class='label label-danger'>"+t+"</span> ?",
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
									url		: baseURL + 'ppnmasa_detail_jurnal_transaksi/submit_jurnal_transaksi',
									type	: "POST",
									// data	: $('#form-wp').serialize(),
									dataType: "json", 
									data	: ({ _searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val(), _searchPpn : $('#jenisPajak').val(), _searchPembetulan : $('#pembetulanKe').val(), _searchCabang : $('#cabang_trx').val()}),
									beforeSend	: function(){
											$("body").addClass("loading");
											},
									success	: function(result){
										if (result==1) {
											$("body").removeClass("loading");
											table1.draw();
											//table2.draw();
											//getSummary();
											empty();
											flashnotif('Sukses','Data Berhasil di Submit!','success' );
										} else {
											$("body").removeClass("loading");
											table1.draw();
											//table2.draw();
											flashnotif('Error','Data Gagal di Submit!','error' );
										}
									}
								});
							}
						}
					});
				}
			}

		});
		
	$("#btnEdit1").click(function (){
		btn = $(this).attr('id');
		$("#isnewRecord").val('0');
		
		if(btn == "btnEdit1"){
			$("#capAdd").html("<span class='label label-danger'>Edit Data "+val_nama_pajak+" Bulan "+monthsname[val_bulan_buku]+" Tahun "+val_tahun_buku+"</span>");
			valueGrid();
		}
		else{
		}
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);
	});

	$("#btnBack").on("click", function(){
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empty();
	});

	function showHide(){
		//if(val_dl_fs == "dokumen_lain"){
			//$(".dokumen_group").show();
			//$(".faktur_group").hide();
			<?php if($nama_pajak == "PPN KELUARAN"){ ?>
			//$(".faktur_group2").hide();
			<?php } ?>
			<?php if($nama_pajak == "PPN MASUKAN"){ ?>
			//$(".faktur_group3").hide();
			<?php } ?>
		//}
		//else{
			//$(".dokumen_group").hide();
			//$(".faktur_group").show();
			<?php if($nama_pajak == "PPN KELUARAN"){ ?>
			//$(".faktur_group2").show();
			<?php } ?>
			<?php if($nama_pajak == "PPN MASUKAN"){ ?>
			//$(".faktur_group3").show();
			<?php } ?>
		//}
	}
	
	function valueAdd()
	{
		$("#fAddNamaPajak").val($("#jenisPajak").val());
		$("#fAddBulan").val($("#bulan").val());
		$("#fAddTahun").val($("#tahun").val());
		$("#fAddPembetulan").val($("#pembetulanKe").val());
		
		tahun_z_percent   = $("#tahun_z_percent_lov").val();

	}

	function valueGrid()
	{
		$("#idDetailJurnal").val(val_detail_jurnal_id);
		$("#docnumber").val(val_docnumber);
		$("#nofaktur").val(val_nomor_faktur);
		$("#bulanbuku").val(val_bulan_buku);
		$("#tahunbuku").val(val_tahun_buku);

		$("#isnewRecord").val('0');
		//postingdate = new Date(val_tanggal_posting);
		//var vvtglposting = ('0' + postingdate.getDate()).slice(-2) + '/'
        //     + ('0' + (postingdate.getMonth()+1)).slice(-2) + '/'
        //    + postingdate.getFullYear();
		$("#tanggalposting").val(val_tanggal_posting);
		$("#descjenistransaksi").val(val_desc_jenis_transaksi);
		$("#account").val(val_account);
		$("#descaccount").val(val_descaccount);
		$("#amount").val(val_amount);
		$("#subledger").val(val_subledger);
		$("#codesubledger").val(val_codesubledger);
		$("#descsubledger").val(val_descsubledger);
		$("#descriptionheader").val(val_descriptionheader);
		$("#referenceline").val(val_referenceline);
		$("#profitcenter").val(val_profitcenter);
		$("#profitcenterdesc").val(val_profitcenterdesc);
		$("#costcenter").val(val_costcenter);
		$("#costcenterdesc").val(val_costcenterdesc);
		$("#ponumber").val(val_ponumber);
		//podate = new Date(val_tanggalpo);
		//var vvtglpo = ('0' + podate.getDate()).slice(-2) + '/'
        //     + ('0' + (podate.getMonth()+1)).slice(-2) + '/'
         //    + podate.getFullYear();
		$("#tanggalpo").val(val_tanggalpo);
		$("#cabang").val(val_cabang);
		$("#lineno").val(val_lineno);
		$("#nomorinvoice").val(val_nomor_invoice);
		$("#tanggalinvoice").val(val_tanggal_invoice);
	}
	
	function empty()
	{
		val_detail_jurnal_id        = "",
			val_ledger_id        		= "",
			val_user_je_source_name     = "",
			val_docnumber        		= "",
			val_nomor_faktur         	= "",
			val_bulan_buku             	= "",
			val_tahun_buku             	= "",
			val_tanggal_posting         = "",
			val_desc_jenis_transaksi    = "",
			val_lineno        			= "",
			val_account          		= "",
			val_descaccount     		= "",
			val_amount           		= "",
			val_subledger  				= "",
			val_codesubledger        	= "",
			val_descsubledger   		= "",
			val_descriptionheader       = "",
			val_referenceline   		= "",
			val_profitcenter        	= "",
			val_profitcenterdesc   		= "",
			val_costcenter        		= "",
			val_costcenterdesc   		= "",
			val_ponumber       			= "",
			val_tanggalpo   			= "",
			val_cabang        			= "",
			val_nama_pajak				= "";
			val_nomor_invoice			= "";
			val_tanggal_invoice			= "";
		$("#idDetailJurnal").val("");
		$("#docnumber").val("");
		$("#nofaktur").val("");
		$("#bulanbuku").val("");
		$("#tahunbuku").val("");

		$("#isnewRecord").val('0');
		$("#tanggalposting").val("");
		$("#descjenistransaksi").val("");
		$("#account").val("");
		$("#descaccount").val("");
		$("#amount").val("");
		$("#subledger").val("");
		$("#codesubledger").val("");
		$("#descsubledger").val("");
		$("#descriptionheader").val("");
		$("#referenceline").val("");
		$("#profitcenter").val("");
		$("#profitcenterdesc").val("");
		$("#costcenter").val("");
		$("#costcenterdesc").val("");
		$("#ponumber").val("");
		$("#tanggalpo").val("");
		$("#cabang").val("");
		$("#lineno").val("");
		$("#nomorinvoice").val("");
		$("#tanggalinvoice").val("");

		table1.$('tr.selected').removeClass('selected');
		$('.DTFC_Cloned tr.selected').removeClass('selected');
		$("#btnEdit1").attr("disabled",true);
		$("#btnDelete1").attr("disabled",true);
		
		var j = $("#jenisPajak").find(":selected").attr("data-name");
		var b = $("#bulan").find(":selected").attr("data-name");
		var t = $("#tahun").val();
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

 });
</script>