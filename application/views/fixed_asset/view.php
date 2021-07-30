<div class="container-fluid">

    <?php $this->load->view('template_top') ?>
	
 <div id="list-data">
	<div class="white-box boxshadow">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="kd_cabang" name="kd_cabang">									
					</select> 
				</div>
			</div>
		</div>
		<div class="row"> 
			<div class="col-md-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan" placeholder="Pilih Bulan">
						<?php
						 $namaBulan = list_month();
						 $bln	= date('m');
						 echo "<option value='' >-- Pilih --</option>";
						 for ($i=1;$i< count($namaBulan);$i++){
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
							$tahun	= date('Y');
							$tAwal	= $tahun - 5;	
							$tAkhir	= $tahun;	
							echo "<option value='' >-- Pilih --</option>";
							for($i=$tAwal; $i<=$tAkhir;$i++){
								$selected	= "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}							
						?>						
					</select> 
				</div>
			 </div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
							<option value="FIXED ASSET" data-name="FIXED ASSET" > FIXED ASSET </option>
					</select>
				</div>
			</div>
			<div class="col-md-2">	
				<div class="form-group">
				<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="" >-- Pilih --</option> 
						<option value="0" >0</option> 
						<option value="1" >1</option> 
						<option value="2" >2</option>
						<option value="3" >3</option>					
					</select>
				</div>
		  </div>
			 <div class="col-md-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
				</div>
			  </div> 
			 
		</div>			
	 </div>
	
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="panel-group boxshadow">
						<div class="panel panel-info">
						<div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								<!--<h4 class="panel-title"><a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Rekonsiliasi</a></h4>-->
								List Data Fixed Asset
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">								 
									<button type="button" id="btnDetail" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-list"></i> DETAIL</button>						
								</div>
							  </div>
							</div>  						   
						</div>	
													
							<!--<div id="collapse-data" class="panel-collapse collapse in">-->
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
												<th>NO</th>
													<th>PAJAK HEADER ID</th>
													<th>KODE CABANG</th>
													<th>BULAN</th>
													<th>NAMA PAJAK</th>
													<th>MASA</th>
													<th>TAHUN</th>
													<th>TANGGAL DIBUAT</th>
													<th>OLEH</th>
													<th>STATUS</th>
													<th>TANGGAL SUBMIT</th>
													<th>TANGGAL APPROVE</th>												
													<th>TANGGAL APPROVE</th>												
													<th>PEMBETULAN KE</th>												
													<th>TOTAL JUMLAH POTONG</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							<!--</div>-->
						</div>
					</div>
                </div>
            </div>	
			
	</div>
	
  
 <div id="detail-data">	
 
	<div class="row"> 	
		<div class="col-lg-12">	
			<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">					
					<a id="aTitleList" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data"><div id="dTitleDetail">List Detail PPh</div></a>
				</div>
				<div id="collapse-data" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata-lines"> 
							<thead>
								<tr>
									<th>PAJAK HEADER ID</th>
	                            	<th>PAJAK LINE ID</th>
	                            	<th>VENDOR ID</th>
									<th>MASA PAJAK</th>
									<th>TAHUN PAJAK</th>
	                            	<th>#</th>
	                            	<th>NO</th>
	                            	<th>AKUN PENDAPATAN</th>
	                            	<th>KD JENIS TRANSAKSI</th>
									<th>FG PENGGANTI</th>
									<th>NOMOR FAKTUR PAJAK</th>
									<th>TANGGAL FAKTUR PAJAK</th>
									<th>NPWP</th>
									<th>NAMA</th>
									<th>ALAMAT LENGKAP</th>
									<th>NOMOR INVOICE</th>
									<th>MATA UANG</th>
									<th>JUMLAH DPP</th>
									<th>JUMLAH PPN</th>
									<th>JUMLAH PPNBM</th>
									<th>IS CREDITABLE</th>
									<th>ID_KETERANGAN_TAMBAHAN</th>
									<th>FG_UANG_MUKA</th>
									<th>UANG_MUKA_DPP</th>
									<th>UANG_MUKA_PPN</th>
									<th>UANG_MUKA_PPNBM</th>
									<th>REFERENSI</th>
								</tr>
							</thead>

						</table>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<b>Ringkasan</b>
						</div>
						 <div class="row">
						  <div class="col-lg-5 col-sm-5 col-md-8 col-xs-12">
							<div class="table-responsive">                          
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summary1"> 
									<thead>
										<tr>
											<th>NO</th>
											<th>DILAPORKAN</th>
											<th>JUMLAH</th>
										</tr>
									</thead>

								</table>
							</div> 
						</div>
						
						 <div class="col-lg-5 col-sm-5 col-md-8 col-xs-12">
							<div class="table-responsive">                          
								<table width="100%" class="display cell-border stripe hover small" id="tabledata-summary0"> 
									<thead>
										<tr>
											<th>NO</th>
											<th>TIDAK DILAPORKAN</th>
											<th>JUMLAH</th>
										</tr>
									</thead>

								</table>
							</div> 
						</div>
						<div class="col-lg-2 col-sm-2 col-md-6 col-xs-8">
							<div class="form-group">
								<label>Total</label>
								<div class="input-group">
									<div id="d-totSummary"></div>
								</div>
							</div>	
						</div>
					   </div>
						<!-- <div class="row">
							  </br>
							  <div class="col-lg-12 text-center">    
									<button type="button" class="btn btn-danger btn-rounded waves-effect" id="btnBack"><i class="fa fa-reply"></i> Kembali</button>
							  </div>
						</div> -->
					</div>
			  </div>
			</div>
		</div>
	</div>
 
  <div class="row"> 	
		<div class="col-lg-12">	
			<div id="accordion2" class="panel panel-info boxshadow animated slideInDown">
				<div class="panel-heading">
					<a id="aTitleList2" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-data2"><div id="dTitleDetail2">List Histori</div></a>
				</div>
				<div id="collapse-data2" class="panel-collapse collapse in">
					<div class="panel-body"> 
						<div class="table-responsive">                          
						<table width="100%" class="display cell-border stripe hover small" id="tabledata-history"> 
							<thead>
								<tr>
									<th>NO</th>
									<th>PROSES</th>
									<th>TANGGAL PROSES</th>
									<th>USERNAME</th>
									<th>KETERANGAN</th>
								</tr>
							</thead>

						</table>
						</div>
						 <div class="row">
  				  </br>
  				  <div class="col-lg-12">  
  					<div class="navbar-right">
  						<button type="button" class="btn btn-danger btn-rounded waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
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
			var table	= "", vidpajakheader="",vnamapajak="", vbulan="", vmasa="", vtahun="", vpembetulan="", vcategory="", vkodecabang="", val_category="", hideColumnLines="";
			$("#detail-data").hide();
			$("#btnDetail").hide();
			getSelectCabang();	
		Pace.track(function(){  
		   $('#tabledata').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'fixed_asset/load_view',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     = $('#kd_cabang').val();
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_header_id"},
					{ "data": "kode_cabang" },
					{ "data": "bulan_pajak" },
					{ "data": "nama_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "creation_date" },
					{ "data": "user_name" },
					{ "data": "status" },					
					{ "data": "tgl_submit_sup"},
					{ "data": "tgl_approve_sup" },
					{ "data": "tgl_approve_pusat" },
					{ "data": "pembetulan_ke","class":"text-center" },
					{ "data": "ttl_jml_potong", "class":"text-right", }
				],
			"columnDefs": [
				{
					"targets": [ 1,2,3,11,12,14 ],
					"visible": false
				} 
			],
    		"fixedColumns"	:   {
					"leftColumns": 1
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari Status/Catatan ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		 
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				empety();
				$("#btnDetail").attr("disabled", true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table.row( this ).data();
				vidpajakheader = d.pajak_header_id;
				vnamapajak     = d.nama_pajak;
				vbulan         = d.bulan_pajak;
				vmasa          = d.masa_pajak;
				vtahun         = d.tahun_pajak;
				vpembetulan    = d.pembetulan_ke;
				vkodecabang    = d.kode_cabang;
				vcategory      = d.status
				$("#btnDetail").removeAttr("disabled");
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d			    = table.row( this ).data();
			vidpajakheader = d.pajak_header_id;
			vnamapajak     = d.nama_pajak;
			vbulan         = d.bulan_pajak;
			vmasa          = d.masa_pajak;
			vtahun         = d.tahun_pajak;
			vpembetulan    = d.pembetulan_ke;
			vkodecabang    = d.kode_cabang;
			vcategory      = d.status
			$("#btnDetail").removeAttr("disabled");
			$("#btnDetail").click();
		} );
		
		$("#btnDetail").on("click", function(){				
			 if(vnamapajak=="" && vbulan=="" && vtahun=="" && vpembetulan==""){
				 flashnotif('Info','Pajak belum dipilih!','warning' );
				 return false;
			 } else {
				/* $("#collapse-data").removeClass("in");
				$("#collapse-data").addClass("in");
				$("#collapse-data2").removeClass("in");
				$("#collapse-data2").addClass("in"); */
				
				$("#detail-data").slideDown(700);
				$("#list-data").slideUp(700);
				getDataLines();
			 }
		});	
		
		$("#btnView").on("click", function(){
			$("#btnDetail").attr("disabled", true);
			table.ajax.reload();			
		});
		
		
		$("#btnBack").on("click", function(){		
			$("#detail-data").slideUp(700);
			$("#list-data").slideDown(700);
			empety();
		});	
		
		function empety()
		{
			vidpajakheader  = "";
			vnamapajak      = "";
			vbulan          = "";
			vmasa           = "";
			vtahun          = "";
			vpembetulan     = "";
			vcategory       = "";
			vkodecabang     = "";
			val_category    = "";
			hideColumnLines = "";
		}
		
		function getDataLines()
		{
			if(vnamapajak == "PPN MASUKAN"){
				hideColumnLines = [0, 1, 2, 3, 4, 21, 22, 23, 24, 25, 26];
				vdokumencategory = 'faktur_standar';
			}
			else{
				hideColumnLines = [0, 1, 2, 3, 4, 20];
				vdokumencategory = 'dokumen_lain';
			}
			$("#dTitleDetail").html("List Detail Data "+vnamapajak+" Bulan "+vmasa+" Tahun "+vtahun+" Pembetulan Ke "+vpembetulan);
			if ( ! $.fn.DataTable.isDataTable( '#tabledata-lines' ) ) {
				$('#tabledata-lines').DataTable({			
				"serverSide"	: true,
				"processing"	: true,
				"ajax"			: {
									 "url"  		: baseURL + 'ppn_masa/load_rekonsiliasi/' + vidpajakheader,
									 "type" 		: "POST",								
									 "data"			: function ( d ) {
											d._category         = vdokumencategory;
										}
								},
				 "language"		: {
						"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
						"infoEmpty"		: "Data Kosong",
						"processing"	: '<img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
						"search"		: "_INPUT_"
					},
			   "columns": [
					{ "data": "pajak_header_id" },
					{ "data": "pajak_line_id", "class":"text-left", "width" : "60px" },
					{ "data": "vendor_id" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "akun_pajak", "class":"text-center" },
					{ "data": "kd_jenis_transaksi", "class":"text-center"},
					{ "data": "fg_pengganti", "class":"text-center"},
					{ "data": "no_faktur_pajak", "class":"text-center"},
					{ "data": "tanggal_faktur_pajak", "class":"text-center"},
					{ "data": "npwp"},
					{ "data": "nama_wp"},
					{ "data": "alamat_wp"},
					{ "data": "invoice_number"},
					{ "data": "mata_uang"},
					{ "data": "dpp", "class":"text-center"},
					{ "data": "jumlah_potong", "class":"text-center"},
					{ "data": "jumlah_ppnbm", "class":"text-center"},
					{ "data": "is_creditable", "class":"text-center"},
					{ "data": "id_keterangan_tambahan", "class":"text-center"},
					{ "data": "fg_uang_muka", "class":"text-center"},
					{ "data": "uang_muka_dpp", "class":"text-center"},
					{ "data": "uang_muka_ppn", "class":"text-center"},
					{ "data": "uang_muka_ppnbm", "class":"text-center"},
					{ "data": "referensi", "class":"text-center"}
				],
				"columnDefs": [ 
					 {
						"targets": hideColumnLines,
						"visible": false
					} 
				],
				 "scrollY"			: 480, 
				 "scrollCollapse"	: true, 
				 "scrollX"			: true,
				 "ordering"			: false			
				});
				
				//table_lines = $("#tabledata-lines").DataTable();
				
				/* $('#tabledata-lines tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');											
					} else {
						table_lines.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');						
					}						 
				}); */			
			} else {
				$("#tabledata-lines").DataTable().ajax.reload();
			}
			getSummary();
			getHistory();
		}
	
	function getSummary()
	{

		if(vcategory == 'DRAFT' || vcategory == 'REJECT SUPERVISOR'){
			val_category = 'Rekonsiliasi';
		}
		else if(vcategory == 'SUBMIT' || vcategory == 'REJECT BY PUSAT'){
			val_category = 'approval_cabang';
		}
		else if(vcategory == 'APPROVAL SUPERVISOR'){
			val_category = 'approval_pusat';
		}
		else{
			val_category = '';
		}
		console.log(vidpajakheader);
		console.log(vcategory);

		console.log(val_category);


		$("#dTitleDetail2").html("List Histori Data "+vnamapajak+" Bulan "+vmasa+" Tahun "+vtahun+" Pembetulan Ke "+vpembetulan);
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summary1' ) ) {
		 $('#tabledata-summary1').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_total_summary/1',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     = vkodecabang;
										d._searchBulan      = vbulan;
										d._searchTahun      = vtahun;
										d._searchPpn        = vnamapajak;
										d._searchPembetulan = vpembetulan;
										d._category         = val_category;

									}								
							},
			 "language"		: {
					"emptyTable"	: "<h5><span class='label label-danger'>Data Tidak Ditemukan!</span></h5>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pengelompokan" },
					{ "data": "jml_potong", "class":"text-right" }
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			
			});				
		} else {
			$('#tabledata-summary1').DataTable().ajax.reload();
		}
		 //=============================================================
		
		//Tabel Summary Tidak dilaporkan===============================
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-summary0' ) ) {
		 $('#tabledata-summary0').DataTable({
			"dom"			: "rt",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_total_summary/0',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchCabang     = vkodecabang;
										d._searchBulan      = vbulan;
										d._searchTahun      = vtahun;
										d._searchPpn        = vnamapajak;
										d._searchPembetulan = vpembetulan;
										d._category         = val_category;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<h5><span class='label label-danger'>Data Tidak Ditemukan!</span></h5>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pengelompokan" },
					{ "data": "jml_potong", "class":"text-right" }
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			
			});			
		} else {
			$('#tabledata-summary0').DataTable().ajax.reload();
		}
		//=============================================================		  
		
		$.ajax({
			url		: baseURL + 'ppn_masa/load_total_rekonsiliasi',
			type	: "POST",
			dataType: "json", 
			data	: ({pajak:vnamapajak, kode_cabang:vkodecabang, bulan:vbulan, tahun:vtahun, pembetulan:vpembetulan, category: val_category}),			
			success	: function(result){
				if (result.isSuccess==1) {	
					 $("#d-totSummary").html("<span class='label label-info'>"+result.total+"</span>");		 
				} else {
					flashnotif('Error','Ambil Data Total Summary Gagal!','error' );
				}
					
			}
		});
	}
	
	function getHistory()
	{
		if ( ! $.fn.DataTable.isDataTable( '#tabledata-history' ) ) {
		 $('#tabledata-history').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_history',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchPajakHeader = vidpajakheader;
									}								
							},
			 "language"		: {
					"emptyTable"	: "<h5><span class='label label-danger'>Data Tidak Ditemukan!</span></h5>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	: '<img src="' + baseURL + 'assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "action_code" },
					{ "data": "action_date" },
					{ "data": "user_name" },
					{ "data": "catatan" }
				],			
			 "scrollCollapse"	: true, 
			 "scrollX"			: false,
			 "ordering"			: false			
			});			
		} else {
			$('#tabledata-history').DataTable().ajax.reload();
		}
	}

	function getSelectCabang()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_master_cabang') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					$("#kd_cabang").html("");					
					$("#kd_cabang").html(result);					
				}
		});			
	}
			
 });
    </script>
