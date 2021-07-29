<div class="container-fluid">

	<?php $this->load->view('template_top') ?>

	<div class="white-box boxshadow">
		<div class="row">
			<div class="col-md-2">
                <div class="form-group">
                    <label>Cabang</label>
                    <select id="kd_cabang" name="kd_cabang" class="form-control" autocomplete="off">
                        <option value="all">Semua Cabang</option>
                        <?php foreach ($list_cabang as $cabang):?>
                        <option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
                        <?php endforeach?>
                    </select>
                </div>
			</div>
		</div>
		<div class="row"> 
			<div class="col-sm-2">
				<div class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="bulan" name="bulan" placeholder="Pilih Bulan">
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
			<div class="col-sm-2">
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
			<div class="col-sm-3">
				<div class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="jenisPajak" name="jenisPajak">
						<option value="" data-name="" >Pilih Jenis Pajak</option>
						<?php foreach ($daftar_pajak as $key => $pajak):?>
							<option value="<?php echo $pajak->JENIS_PAJAK ?>" data-name="<?php echo $pajak->JENIS_PAJAK ?>" > <?php echo $pajak->JENIS_PAJAK ?> </option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
				<label>Pembetulan Ke</label>
					<select class="form-control" id="pembetulanKe" name="pembetulanKe">
						<option value="1" selected>1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
				<label>&nbsp;</label>
					<button id="btnView" class="btn btn-default btn-rounded custom-input-width btn-block" type="button" ><i class="fa fa-bars"></i> <span>VIEW</span></button>
				</div>
			</div>
		</div>
	 </div>
	 
	<div class="row">
	          <div class="col-lg-12">
                    <div class="panel panel-info boxshadow">
                        <div class="panel-heading">
                           <div class="row">
								<div class="col-lg-6">
									Daftar Pembetulan PPN Masa
								</div>
								<div class="col-lg-6">
									<div class="navbar-right">
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" data-toggle="modal" data-target="#modal-wp"><i class="fa fa-pencil-square-o"></i> ADD</button>
									<button type="button" id="btnDelete" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> DELETE</button>
								</div>
								</div>
						   </div>
						</div>
                       
                        <div class="panel-body">
							<div class="table-responsive">
                           <table width="100%" class="display cell-border stripe hover small" id="tabledata">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>HEADER ID</th>
										<th>STATUS_PERIOD</th>
										<th>BULAN</th>
                                        <th>NAMA PAJAK</th> 
                                        <th>MASA</th>
                                        <th>TAHUN</th>
                                        <th>PEMBETULAN KE</th>
										<th>KODE CABANG</th>
										<th>NAMA CABANG</th>
                                        <th>JUMLAH PEMBETULAN</th>
                                        <th>JUMLAH NORMAL</th>
                                        <th>SELISIH</th>
                                    </tr>
                                </thead>
                            </table>
							</div>  
                       </div>
                    </div>
                </div>
            </div>
</div>

<!-- Modal -->
<div id="modal-wp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h2 class="modal-title" >Tambah Data Pembetulan</h2>
      </div>
      <div class="modal-body">
		<form role="form" id="form-wp" data-toggle="validator">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Cabang</label>
					<select class="form-control" id="fcabang" name="fcabang">
						<option value='' >-- Pilih Cabang--</option>
                        <?php foreach ($list_cabang as $cabang):?>
                        <option value="<?php echo $cabang['KODE_CABANG'] ?>"><?php echo $cabang['NAMA_CABANG'] ?></option>
                        <?php endforeach?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div id="dfbulan" class="form-group">
					<label>Bulan</label>
					<select class="form-control" id="fbulan" name="fbulan">
						<?php
						 $namaBulan = list_month();;
						 echo "<option value='' >-- Pilih Bulan--</option>";
						 for ($i=1;$i< count($namaBulan);$i++){
							$selected	= "";
							 echo "<option value='".$i."' data-name='".$namaBulan[$i]."' ".$selected." >".$namaBulan[$i]."</option>";
						 }
						?>
					</select>
					<div id="error1"></div>
				</div>
			</div>
			<div class="col-sm-6">
			<div id="dfjenisPajak" class="form-group">
					<label>Jenis Pajak</label>
					<select class="form-control" id="fjenisPajak" name="fjenisPajak">
						<option value="" data-name="" >-- Pilih Jenis Pajak --</option>
						<?php foreach ($daftar_pajak as $key => $pajak):?>
							<option value="<?php echo $pajak->JENIS_PAJAK ?>" data-name="<?php echo ucwords(strtolower($pajak->JENIS_PAJAK)) ?>" > <?php echo $pajak->JENIS_PAJAK ?> </option>
						<?php endforeach ?>
					</select>
					 <div id="error2"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div id="dftahun" class="form-group">
					<label>Tahun</label>
					<select class="form-control" id="ftahun" name="ftahun">
						<?php 
							$tahun	= date('Y');
							$tAwal	= $tahun - 5;	
							$tAkhir	= $tahun;	
							echo "<option value='' >-- Pilih Tahun --</option>";
							for($i=$tAwal; $i<=$tAkhir;$i++){
								$selected	= "";
								echo "<option value='".$i."' ".$selected.">".$i."</option>";
							}
						?>
					</select>
					 <div id="error3"></div>
				</div>
			</div>
			<div class="col-sm-6">
			<div id="dfpembetulanKe" class="form-group">
				<label>Pembetulan Ke</label>
					<select class="form-control" id="fpembetulanKe" name="fpembetulanKe">
						<option value="" >-- Pilih Pembetulan --</option> 
						<option value="1" >1</option> 
						<option value="2" >2</option>
						<option value="3" >3</option>
					</select>
				 <div id="error4"></div>
				</div>
			</div>
		</div>	
	  </form>
	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> CANCEL</button>
        <button type="button" class="btn btn-info waves-effect" id="btnOpen"><i class="fa fa-save"></i> OPEN</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
		var table	= "", vid = "", vnamapajak="", vmasapajak="", vbulanpajak="", vtahunpajak="",vpembetulan="", vkodecabang="";
		 
		$('#modal-wp').modal({
			keyboard: true,
			backdrop: "static",
			show:false,
		});
		
		 Pace.track(function(){
		   $('#tabledata').DataTable({
			"dom"			: "lrtip",
			"serverSide"	: true,
			"processing"	: true,
			"ajax"			: {
								 "url"  		: baseURL + 'ppn_masa/load_pembetulan',
								 "type" 		: "POST",
								 "data"			: function ( d ) {
										d._searchBulan      = $('#bulan').val();
										d._searchTahun      = $('#tahun').val();
										d._searchPpn        = $('#jenisPajak').val();
										d._searchPembetulan = $('#pembetulanKe').val();
										d._searchCabang     = $('#kd_cabang').val();
									}		
							  },
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data Tidak Ditemukan!</span>",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center"},
					{ "data": "pajak_header_id", "class":"text-left", "width" : "60px"},
					{ "data": "status_period"},
					{ "data": "bulan_pajak"},
					{ "data": "nama_pajak"},
					{ "data": "masa_pajak"},
					{ "data": "tahun_pajak"},
					{ "data": "pembetulan_ke"},
					{ "data": "kode_cabang"},
					{ "data": "nama_cabang"},
					{ "data": "jml_pembetulan"},
					{ "data": "jml_normal"},
					{ "data": "selisih"}
				],
			"columnDefs": [
				 {
					"targets": [ 1, 2, 3, 8 ],
					"visible": false
				} 
			],						
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false
			});
		 });
		
		table = $('#tabledata').DataTable();
		
		table.on( 'draw', function () {
			$("#btnDelete").attr("disabled",true);
		} );
		
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				vid		= "";
				vnamapajak	= "";
				vbulanpajak	= "";
				vmasapajak	= "";
				vtahunpajak	= "";
				vpembetulan	= "";
				vkodecabang	= "";
				vnamacabang	= "";
				$("#btnDelete").attr("disabled",true);
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d		= table.row( this ).data();
				vid			= d.pajak_header_id;
				vnamapajak	= d.nama_pajak;	
				vbulanpajak	= d.bulan_pajak;
				vmasapajak	= d.masa_pajak;
				vtahunpajak	= d.tahun_pajak;
				vpembetulan	= d.pembetulan_ke;
				vkodecabang	= d.kode_cabang;
				vnamacabang	= d.nama_cabang;
				$("#btnDelete").removeAttr('disabled');
			}
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d		= table.row( this ).data();
			vid			= d.pajak_header_id;
			vnamapajak	= d.nama_pajak;	
			vbulanpajak	= d.bulan_pajak;
			vmasapajak	= d.masa_pajak;
			vtahunpajak	= d.tahun_pajak;
			vpembetulan	= d.pembetulan_ke;
			vkodecabang	= d.kode_cabang;
			vnamacabang	= d.nama_cabang;
			$("#btnDelete").removeAttr('disabled');
		} );
		
		$('#modal-wp').on('shown.bs.modal', function () {
			$('#fbulan').trigger('focus')
		});
		
		$("#btnView").on("click", function(){
			table.ajax.reload();
		});
			
		
	$("#btnOpen").click(function(){	
		var vfnamapajak 	= $("#fjenisPajak").val();
		var vfbulan		    = $("#fbulan").val();
		var vfnmbulan 	    = $("#fbulan").find(":selected").attr("data-name");
		var vftahun		    = $("#ftahun").val();
		var vfpembetulan	= $("#fpembetulanKe").val();
		var vfkodecabang	= $("#fcabang").val();
		$("#error1, #error2,#error3,#error4").html('');
		$("#dfbulan #dfjenisPajak, #dftahun, #dfpembetulanKe").removeClass("has-error");
		
		if (vfbulan==''){
			$("#error1").html('<i style="color:#dd4b39; font-size:12px;">Bulan Pajak belum diisi!</i>');
			$("#dfbulan").addClass("has-error");
			return false;
		}
		
		if (vfnamapajak==''){
			$("#error2").html('<i style="color:#dd4b39; font-size:12px;">Jenis Pajak belum diisi!</i>');
			$("#dfjenisPajak").addClass("has-error");
			return false;
		}
		
		if (vftahun==''){
			$("#error3").html('<i style="color:#dd4b39; font-size:12px;">Tahun Pajak belum diisi!</i>');
			$("#dftahun").addClass("has-error");
			return false;
		}
		
		if (vfpembetulan==''){
			$("#error4").html('<i style="color:#dd4b39; font-size:12px;">Pembetulan ke belum diisi!</i>');
			$("#dfpembetulanKe").addClass("has-error");
			return false;
		}
		vp = parseInt(vfpembetulan)- parseInt(1);
			bootbox.confirm({
			title: "Data <span class='label label-danger'>"+vfnamapajak+"</span> Bulan <span class='label label-danger'>"+vfnmbulan+"</span> Tahun <span class='label label-danger'>"+vftahun+"</span> Pembetulan Ke <span class='label label-danger'>"+vfpembetulan+"</span> Buka?",
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
						url		: baseURL + 'ppn_masa/open_pembetulan',
						type	: "POST",
						data	: $('#form-wp').serialize(),
						beforeSend	: function(){
							 $("body").addClass("loading")
						},
						success	: function(result){
							console.log(result);
							if (result==1) {
								empety();
								table.ajax.reload();
								$("#modal-wp").modal("hide");
								$("body").removeClass("loading");
								flashnotif('Sukses','Data '+vfnamapajak+' Bulan '+vfnmbulan+' Tahun '+vftahun+' Pembetulan ke '+vpembetulan+' Cabang '+vfkodecabang+' Berhasil di Buka!','success' );
							} else if (result==2){
								$("body").removeClass("loading");
								flashnotif('Error','Data '+vfnamapajak+' Bulan '+vfnmbulan+' Tahun '+vftahun+' Pembetulan ke '+vp+' Cabang '+vfkodecabang+' Belum di Tutup!','error' );
							} else if (result==3){
								$("body").removeClass("loading");
								flashnotif('Error','Data '+vfnamapajak+' Bulan '+vfnmbulan+' Tahun '+vftahun+' Pembetulan ke '+vp+' Cabang '+vfkodecabang+' Tidak Ditemukan!','error' );
							} 
							else {
								$("body").removeClass("loading");
								flashnotif('Error','Data '+vfnamapajak+' Bulan '+vfnmbulan+' Tahun '+vftahun+' Pemebetulan ke '+vpembetulan+' Cabang '+vfkodecabang+' Gagal di Buka!','error' );
							}
						}
					});
				}
			}
			});
			
		});
		
	$("#btnDelete").click(function(){
		  bootbox.confirm({
			title: "Hapus Data <span class='label label-danger'>"+vnamapajak+"</span> Bulan <span class='label label-danger'>"+vmasapajak+"</span> Tahun Pajak <span class='label label-danger'>"+vtahunpajak+"</span> Pembetulan Ke <span class='label label-danger'>"+vpembetulan+"</span> Cabang <span class='label label-danger'>"+vnamacabang+"</span> ?",
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
						url		: baseURL + 'ppn_masa/delete_pembetulan',
						type	: "POST",
						data	: ({header_id:vid, pajak:vnamapajak, bulan:vbulanpajak, tahun:vtahunpajak, pembetulan_ke: vpembetulan }),
						beforeSend	: function(){
							 $("body").addClass("loading");	
							},
						success	: function(result){
							if (result==1) {
								 empety();
								 $("body").removeClass("loading");
								 table.ajax.reload();
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

	
	function empety()
	{
		$("#fbulan").val("");
		$("#fjenisPajak").val("");
		$("#ftahun").val("");
		$("#fpembetulanKe").val("");
		$("#fcabang").val("");
	}
	
 });
</script>