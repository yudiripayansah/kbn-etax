<div class="container-fluid">

	<?php $this->load->view('template_top') ?>

	<div class="white-box boxshadow">	
		<div class="row">
			<div class="col-sm-2">
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
			 <div class="col-sm-2">
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
			 <div class="col-sm-3">
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
			 <div class="col-sm-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<?php foreach ($daftar_pajak as $key => $pajak):?>
							<option value="<?php echo $pajak->NAMA_PAJAK ?>" data-name="<?php echo $pajak->NAMA_PAJAK ?>" > <?php echo $pajak->NAMA_PAJAK ?> </option>
						<?php endforeach ?>
					</select>
				</div>
			 </div>
			 <div class="col-sm-2">	
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>Tampil</span></button>
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
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">Histori Dokumen</a>
								</h4>
							</div>							
							<div id="collapse-data" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="table-responsive">
										<table width="100%" class="display  cell-border stripe hover small" id="tabledata"> 
											<thead>
												<tr>
													<th>NO</th>
													<th>PAJAK_HEADER_ID</th>
													<th>KODE_CABANG</th>
													<th>PAJAK</th>
													<th>BULAN</th>
													<th>TAHUN</th>
													<th>PEMBETULAN KE</th>
													<th>CABANG</th>
													<th>STATUS</th>
													<th>TANGGAL STATUS</th>
													<th>KETERANGAN</th>												
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
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box boxshadow animated slideInDown">			
			<ul class="nav customtab nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab-download" aria-controls="tab-download" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><i class="fa fa-download fa-fw"></i> Download</span></a></li>
				<li role="presentation" class=""><a href="#tab-cetak" aria-controls="tab-cetak" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><i class="fa fa-print fa-fw"></i> Cetak</span></a></li>
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab-download">
					<div class="col-lg-12">
						<button type="button" id="btnCSV" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Export CSV</button>
						<button type="button" id="btnCSVSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
					</div>
					<div class="clearfix"></div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tab-cetak">
					<div class="col-lg-12">						
						 <button type="button" id="btnAllBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Semua Bupot</button>
						 <button type="button" id="btnBupot" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Single Bupot</button>
						 <button type="button" id="btnDaftar" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> Daftar Bupot</button>
						 <button type="button" id="btnSPT" class="btn btn-danger isAktif"><i class="fa fa-file-o fa-fw"></i> SPT Summary</button>
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
			var table	= "";
			
		Pace.track(function(){  
		   $('#tabledata').DataTable({			
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'pph21/load_summary',
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._searchBulan 		= $('#bulan').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPpn		= $('#jenisPajak').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="'+ baseURL +'assets/summary/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "pajak_header_id", "class":"text-left", "width" : "60px" },
					{ "data": "kode_cabang" },
					{ "data": "nama_pajak" },
					{ "data": "masa_pajak" },
					{ "data": "tahun_pajak" },
					{ "data": "pembetulan_ke", "class":"text-center", "width" : "60px" },
					{ "data": "nama_cabang" },
					{ "data": "status" },
					{ "data": "tgl_status" },
					{ "data": "catatan" }
				],
			"columnDefs": [ 
				 {
					"targets": [ 1,2 ],
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
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');				
			}			
						 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');				
		} );
		
		$("#btnView").on("click", function(){
			table.ajax.reload();			
		});		
			
 });
    </script>
