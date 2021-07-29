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
			 <div class="col-lg-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="PPN WAPU" data-name="PPN WAPU" selected >PPN WAPU</option>
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
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>View</span></button>
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
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">DAFTAR NOMINATIF BERNTPN</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata1"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK LINE ID</th>
													<th>VENDOR ID</th>
													<th>PAJAK HEADER ID</th>
													<th>AKUN PAJAK</th>
													<th>BULAN PAJAK</th>
													<th>NAMA REKANAN</th>
													<th>NPWP REKANAN</th>
													<th>KODE DAN NOMOR SERI FAKTUR PAJAK</th>
                                        			<th>TANGGAL FAKTUR PAJAK</th>
                                        			<th>TANGGAL SETOR SSP</th>
                                        			<th>NTPN</th>
                                        			<th>PPN (RUPIAH)</th>
                                        			<th>PPNBM (RUPIAH)</th>
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

            <div id="d-FormCsv">
            <div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			 <div class="white-box boxshadow">
				<div class="row">
					<div class="form-group">
						<label>Export CSV Format</label>
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
									<input type="file" id="file_csv" name="file_csv"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
								<input type="hidden" class="form-control" id="uplPph" name="uplPph">
								<input type="hidden" class="form-control" id="import_jenisPajak" name="import_jenisPajak">
								<input type="hidden" class="form-control" id="import_bulan" name="import_bulan">
								<input type="hidden" class="form-control" id="import_tahun" name="import_tahun">
								<input type="hidden" class="form-control" id="import_pembetulanKe" name="import_pembetulanKe">
							</div>
						  </div>						  
						  <div class="col-lg-4">	
							<div class="form-group">
							<label>&nbsp;</label>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button" ><i class="fa fa-sign-in"></i> <span>Upload File CSV</span></button>
								</div>
							</div>
						  </div>	  
					  </form> 
				  </div>
			 </div>
		</div>
            <!-- <div class="col-lg-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnMasuk" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-arrow-down"></i> <span>Masukkan ke Daftar</span></button>
				</div>
				<label>&nbsp;</label>
					<button id="btnSelesai" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-unlock-alt"></i> <span>Upload Selesai</span></button>
			  </div> -->
</div>


<script>
    $(document).ready(function() {
			var table	= "", vkodepajak = "",vbulan = "", vtahun ="";				
		
		/*Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_ntpn'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	    = $('#bulan').val();
										d._searchTahun 	    = $('#tahun').val();
										d._searchPph	    = $('#jenisPajak').val();
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
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "tgl_setor_ssp" },
					{ "data": "ntpn" },
					{ "data": "jumlah_ppn" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 1,2,3,4,5 ],
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
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
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
		});*/

		Pace.track(function(){  
		   $('#tabledata1').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: "<?php echo site_url('ppn_wapu/load_ntpn'); ?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 	    = $('#bulan').val();
										d._searchTahun 	    = $('#tahun').val();
										d._searchPph	    = $('#jenisPajak').val();
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
					{ "data": "nama_wp" },
					{ "data": "npwp" },
					{ "data": "no_faktur_pajak" },
					{ "data": "tanggal_faktur_pajak" },
					{ "data": "tgl_setor_ssp" },
					{ "data": "ntpn" },
					{ "data": "jumlah_ppn" , "class":"text-right"},
					{ "data": "jumlah_ppnbm" , "class":"text-right"}
				],
			"columnDefs": [ 
				 {
					"targets": [ 1,2,3,4,5 ],
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
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			});
		 });
		
		table2 = $('#tabledata1').DataTable();	
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search No Faktur/Nama WP ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table2.search('').column().search('').draw();			
		});
				
		$('#tabledata1 tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');				
			} else {
				table2.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');				
			}			
		}).on("dblclick", "tr", function () {
			table2.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		});
		
		
		table2.on( 'draw', function () {			
		  if (table2.data().any()){
			 $(".isAktif").removeAttr("disabled");
		  } else {
			 $(".isAktif").attr("disabled", true);
		  }
		});
			
  
	/*$("#btnView2").on("click", function(){		
		table.ajax.reload();		
	});*/

	$("#btnView").on("click", function(){		
		table2.ajax.reload();		
	});

	function getFormCSV(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}
	
	/*$("#btnCSV").on("click", function(){			
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_format_csv";
			vkodepajak	= $("#jenisPajak").val();
			vbulan		= $("#bulan").val();
			vtahun		= $("#tahun").val();
			if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 exit();
			} else {
				window.open(url+'?tax='+vkodepajak+'&month='+vbulan+'&year='+vtahun, '_blank');
				window.focus(); 				
			}
	});*/

	/*function valueGrid()
	{
		$("#jenisPajak2").val(vjenispajak);
		$("#tahun2").val(vtahun2);
		$("#pembetulanKe2").val(vpembetulanke2);	
	}*/


	
	function valueAdd()
	{
		$("#uplPph").val($("#jenisPajak").val());
		$("#import_bulan").val($("#bulan").val());
		$("#import_tahun").val($("#tahun").val());
		$("#import_pembetulanKe").val($("#pembetulanKe").val());
	}

	 $("#btnImportCSV").click(function(){ 
	 	valueAdd();      
        var form = $('#form-import')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('ppn_wapu/import_CSV_Nominatif') ?>",
            data	: data,
			beforeSend	: function(){
				 $("body").addClass("loading");					
			},
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
            	//console.log(result);
				if (result==1) {
                    table2.ajax.reload();
                    $("body").removeClass("loading");
					flashnotif('Sukses','Data Berhasil di Import!','success' );	
                    $("#file_csv").val("");
                } else if(result==2){
					$("body").removeClass("loading");
					flashnotif('Info','File Import CSV belum dipilih!','warning' );	
				} else if(result==3){
					$("body").removeClass("loading");
					flashnotif('Info','Format File Bukan CSV!','warning' );
				} else if(result==4){
					$("body").removeClass("loading");
					flashnotif('Info','Nomor NTPN tidak boleh ada yang Kosong!','warning' );
				} else if(result==5){
					$("body").removeClass("loading");
					flashnotif('Info','Nomor NTPN tidak boleh ada yang sama!','warning' );
				} else if(result==6){
					$("body").removeClass("loading");
					flashnotif('Info','Tanggal Setor SSP tidak boleh ada yang Kosong!','warning' );
				} else if(result==7){
					$("body").removeClass("loading");
					flashnotif('Info','Input NTPN kurang dari 16 karakter!','warning' );
				} else if(result==8){
					$("body").removeClass("loading");
					flashnotif('Info','Input NTPN lebih dari 16 karakter!','warning' );
				} else if(result==9){
					$("body").removeClass("loading");
					flashnotif('Info','Sesuaikan bulan setor!','warning' );
				} else if(result==10){
					$("body").removeClass("loading");
					flashnotif('Info','Sesuaikan tahun setor!','warning' );
				} else {
                    $("body").removeClass("loading");
					flashnotif('Error','Data Gagal di Import, Periksa Kembali Data CSV!','error' );
                }
            }
        });
    });

	 $("#btnEksportCSV").on("click", function(){		
			var url 	="<?php echo site_url(); ?>ppn_wapu/export_csv_nominatif";
			var j		= $("#jenisPajak").val();
			var b		= $("#bulan").val();
			var t		= $("#tahun").val();
			var p		= $('#pembetulanKe').val();
			if (!table2.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else {
				$.ajax({			
					url		: '<?php echo site_url() ?>ppn_wapu/cek_data_csv_nominatif'+'?tax='+j+'&month='+b+'&year='+t+'&ke='+p,				
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
    	
	
 });
    </script>
