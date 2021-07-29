<div class="container-fluid">
	
	<?php $this->load->view('template_top'); ?>
	
  <div id="list-data">
    <div class="white-box boxshadow">
      <div class="row">
        <div class="col-lg-2">
          <div class="form-group">
            <label>From</label>
            <select class="form-control" id="bulanfrom" name="bulanfrom">
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
        <div class="col-lg-2">
          <div class="form-group">
            <label>To</label>
            <select class="form-control" id="bulanto" name="bulanto">
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
	
    <div class="white-box boxshadow animated slideInDown">
      <div class="row">
        <div class="col-lg-3 col-md-5 col-sm-7 col-xs-8">
          <div class="form-group">
            <label>Jenis Asset</label>
            <select class="form-control" id="JenisAsset" name="JenisAsset">
              <option value="B" data-name="Fixed Asset" >Bangunan</option>
              <option value="N" data-name="Fixed Asset" >Non Bangunan</option>
              <option value="T" data-name="Fixed Asset" >Tidak Berwujud</option>
            </select>
          </div>
        </div>
        <div class="col-lg-2 col-md-5 col-sm-7 col-xs-8">
          <div class="form-group">
            <label>Export CSV Format</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button id="btnEksportCSV" class="btn btn-success btn-rounded btn-block" type="button"><i class="fa fa-download fa-fw"></i><span>CSV Format</span></button>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-8 col-sm-10 col-xs-12">
          <form role="form" id="form-import" autocomplete="off">
            <div class="col-lg-9">
              <div class="form-group">
                <label class="form-control-label">File CSV</label>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                  <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span>
                  </div>
                  <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                  <input type="file" id="file_csv" name="file_csv"></span><a id="aRemoveCSV" href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
                <input type="hidden" class="form-control" id="uplPph" name="uplPph">
                <input type="hidden" class="form-control" id="import_bulan_pajak" name="import_bulan_pajak">
                <input type="hidden" class="form-control" id="import_tahun_pajak" name="import_tahun_pajak">
                <input type="hidden" class="form-control" id="import_tipe" name="import_tipe"></div>
            </div>
            <div class="col-lg-3">
              <div class="form-group">
                <label>&nbsp;</label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button id="btnImportCSV" class="btn btn-info btn-rounded btn-block" type="button"><i class="fa fa-sign-in"></i><span>Import CSV</span></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
	
    <div class="row">
      <div class="col-lg-12">
        <div id="accordion" class="panel panel-info boxshadow animated slideInDown">
          <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6">
                <a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data">List Data Rekonsiliasi Bangunan</a>
              </div>
              <div class="col-lg-6">
                <div class="navbar-right">
                  <button type="button" id="btnEdit-bulanan" class="btn btn-rounded btn-default custom-input-width"><i class="fa fa-pencil"></i> EDIT</button>
                  <button type="button" id="btnDelete-bulanan" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-trash-o"></i> DELETE</button>
                </div>
              </div>
            </div>
          </div>
          <div id="collapse-data" class="panel-collapse collapse in">
            <div class="panel-body">
              <div id="dBulanan" class="table-responsive">
                <table width="100%" class="display cell-border stripe hover small" id="tabledata">
                <thead>
                <tr>
                  <th>
                    <div class="checkboxall checkbox-inverse">
                      <input id="checkboxAll" type="checkbox">
                      <label for="checkboxAll"></label>
                    </div>
                  </th>
                  <th>NO</th>
                  <th>ASSET NO</th>
                  <th>JENIS AKTIVA</th>
                  <th>NAMA AKTIVA</th>
                  <th>KETERANGAN</th>
                  <th>TANGGAL BELI</th>
                  <th>HARGA PEROLEHAN</th>
                  <th>KELOMPOK AKTIVA</th>
                  <th>JENIS HARTA</th>
                  <th>JENIS USAHA</th>
                  <th>STATUS PEMBEBANAN</th>
                  <th>TANGGAL JUAL</th>
                  <th>HARGA JUAL</th>
                  <th>PH FISKAL</th>
                  <th>AK PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>NSBF TAHUN SEBELUMNYA</th>
                  <th>PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>PEMBEBANAN</th>
                  <th>AK PENYUSUTAN TAHUN BERJALAN</th>
                  <th>NSBF TAHUN BERJALAN</th>
                  <th>IS CHEKLIST</th>
                  <th>ID REKON FIXED ASSET</th>
                  <th>MASA PAJAK</th>
                  <th>TAHUN PAJAK</th>
                </tr>
                </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!--=======================NON BANGUNAN=================================-->			 
	  <div class="row">
      <div class="col-lg-12">
        <div id="accordion" class="panel panel-info boxshadow animated slideInDown">
          <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6">
                <a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data-final">List Data Rekonsiliasi Non Bangunan</a>
              </div>
              <div class="col-lg-6">
                <div class="navbar-right">
                  <button type="button" id="btnEdit-final" class="btn btn-rounded btn-default custom-input-width"><i class="fa fa-pencil"></i> EDIT</button>
                  <button type="button" id="btnDelete-final" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-trash-o"></i> DELETE</button>
                </div>
              </div>
            </div>
          </div>
          <div id="collapse-data-final" class="panel-collapse collapse in">
            <div class="panel-body">
              <div id="dFinal" class="table-responsive">
                <table width="100%" class="display cell-border stripe hover small" id="tabledata_bulanan_final">
                <thead>
                <tr>
                  <th>
                    <div class="checkboxallf checkbox-inverse">
                      <input id="checkboxAll-final" type="checkbox">
                      <label for="checkboxAll-final"></label>
                    </div>
                  </th>
                  <th>NO</th>
                  <th>ASSET NO</th>
                  <th>JENIS AKTIVA</th>
                  <th>NAMA AKTIVA</th>
                  <th>KETERANGAN</th>
                  <th>TANGGAL BELI</th>
                  <th>HARGA PEROLEHAN</th>
                  <th>KELOMPOK AKTIVA</th>
                  <th>JENIS HARTA</th>
                  <th>JENIS USAHA</th>
                  <th>STATUS PEMBEBANAN</th>
                  <th>TANGGAL JUAL</th>
                  <th>HARGA JUAL</th>
                  <th>PH FISKAL</th>
                  <th>AK PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>NSBF TAHUN SEBELUMNYA</th>
                  <th>PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>PEMBEBANAN</th>
                  <th>AK PENYUSUTAN TAHUN BERJALAN</th>
                  <th>NSBF TAHUN BERJALAN</th>
                  <th>IS CHEKLIST</th>
                  <th>ID REKON FIXED ASSET</th>
                  <th>MASA PAJAK</th>
                  <th>TAHUN PAJAK</th>
                </tr>
                </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
	    </div>
    </div>

<!--======================================================================-->			 
    <div class="row">
      <div class="col-lg-12">
        <div id="accordion" class="panel panel-info boxshadow animated slideInDown">
          <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6">
                <a id="aTitleList" class="accordion-toggle titlelist" data-toggle="collapse" data-parent="#accordion" href="#collapse-data-nonfinal">List Data Rekonsiliasi Tak Berwujud</a>
              </div>
              <div class="col-lg-6">
                <div class="navbar-right">
                  <button type="button" id="btnEdit-nonfinal" class="btn btn-rounded btn-default custom-input-width"><i class="fa fa-pencil"></i> EDIT</button>
                  <button type="button" id="btnDelete-nonfinal" class="btn btn-rounded btn-default custom-input-width "><i class="fa fa-trash-o"></i> DELETE</button>
                </div>
              </div>
            </div>
          </div>
          <div id="collapse-data-nonfinal" class="panel-collapse collapse in">
            <div class="panel-body">
              <div id="dNonFinal" class="table-responsive">
                <table width="100%" class="display cell-border stripe hover small" id="tabledata_bulanan_tak_berwujud">
                <thead>
                <tr>
                  <th>
                    <div class="checkboxallnf checkbox-inverse">
                      <input id="checkboxAll-nonfinal" type="checkbox">
                      <label for="checkboxAll-nonfinal"></label>
                    </div>
                  </th>
                  <th>NO</th>
                  <th>ASSET NO</th>
                  <th>JENIS AKTIVA</th>
                  <th>NAMA AKTIVA</th>
                  <th>KETERANGAN</th>
                  <th>TANGGAL BELI</th>
                  <th>HARGA PEROLEHAN</th>
                  <th>KELOMPOK AKTIVA</th>
                  <th>JENIS HARTA</th>
                  <th>JENIS USAHA</th>
                  <th>STATUS PEMBEBANAN</th>
                  <th>TANGGAL JUAL</th>
                  <th>HARGA JUAL</th>
                  <th>PH FISKAL</th>
                  <th>AK PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>NSBF TAHUN SEBELUMNYA</th>
                  <th>PENYUSUTAN TAHUN SEBELUMNYA</th>
                  <th>PEMBEBANAN</th>
                  <th>AK PENYUSUTAN TAHUN BERJALAN</th>
                  <th>NSBF TAHUN BERJALAN</th>
                  <th>IS CHEKLIST</th>
                  <th>ID REKON FIXED ASSET</th>
                  <th>MASA PAJAK</th>
                  <th>TAHUN PAJAK</th>
                </tr>
                </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row"> 	
			<div class="col-lg-12">	
				<div id="accordion" class="panel panel-info boxshadow animated slideInDown">
					<div class="panel-heading">							
						<div class="row">
						  <div class="col-lg-6">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-summary">Summary</a>
						  </div>						  
						</div> 							
					</div>
				   <div id="collapse-summary" class="panel-collapse collapse in">
					<div class="panel-body"> 					
            <form>
              <div class="form-group row">
                <label for="fixed_asset_bangunan" class="col-sm-2 col-form-label">Fixed Asset Bangunan</label>
                <div class="col-sm-10">
                <input type="number" value=0 step="0.01" class="form-control" id="fixed_asset_bangunan" name="fixed_asset_bangunan" aria-describedby="emailHelp" placeholder="Enter a Number">
                </div>
              </div>
              <div class="form-group row">
                <label for="fixed_asset_non_bangunan" class="col-sm-2 col-form-label">Fixed Asset Non Bangunan</label>
                <div class="col-sm-10">
                <input type="number" value=0 step="0.01" class="form-control" id="fixed_asset_non_bangunan" aria-describedby="emailHelp" placeholder="Enter a Number">
                </div>
              </div>
              <div class="form-group row">
                <label for="fixed_asset_tak_berwujud" class="col-sm-2 col-form-label">Fixed Asset Tak Berwujud</label>
                <div class="col-sm-10">
                <input type="number" value=0 step="0.01" class="form-control" id="fixed_asset_tak_berwujud" aria-describedby="emailHelp" placeholder="Enter a Number">
                </div>
              </div>
              <div class="form-group row">
							<button id="btnSubmit" class="btn btn-danger btn-rounded custom-input-width  " type="button"><i class="fa fa-share-square-o"></i><span>SUBMIT</span></button>
              <button id="btnRejectSubmit" class="btn btn-danger btn-rounded custom-input-width  " type="button"><i class="fa fa-share-square-o"></i><span>REJECT</span></button>
              </div>
					 </form>
				</div>
				</div>
			</div>
			</div>			
		</div>
	</div>
  </div>

<!-------------------------------------->		
  <div id="tambah-data">
    <form role="form" id="form-wp">
      <div class="white-box boxshadow">
        <div class="row">
          <div class="col-lg-12 align-center">
            <h2 id="capAdd" class="text-center">Tambah Data</h2>
          </div>
        </div>
        <div class="row">
          <hr>
          <input type="hidden" class="form-control" id="ASSET_NO" name="ASSET_NO">
          <input type="hidden" class="form-control" id="isNewRecord" name="isNewRecord">
          <input type="hidden" class="form-control" id="KELOMPOK_FIXED_ASSET" name="KELOMPOK_FIXED_ASSET">
          <input type="hidden" class="form-control" id="REKON_FIXED_ASSET_ID" name="REKON_FIXED_ASSET_ID">
          <input type="hidden" class="form-control" id="MASA_PAJAK" name="MASA_PAJAK">
          <input type="hidden" class="form-control" id="TAHUN_PAJAK" name="TAHUN_PAJAK">
          <input type="hidden" class="form-control" id="fAddAkun" name="fAddAkun">
          <input type="hidden" class="form-control" id="fAddBulan" name="fAddBulan">
          <input type="hidden" class="form-control" id="fAddBulanto" name="fAddBulanto">
          <input type="hidden" class="form-control" id="fAddTahun" name="fAddTahun">
          <input type="hidden" class="form-control" id="fAddPembetulan" name="fAddPembetulan">
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>JENIS AKTIVA</label>
              <input type="text" class="form-control" id="JENIS_AKTIVA" name="JENIS_AKTIVA" placeholder="JENIS AKTIVA" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>NAMA AKTIVA</label>
              <input type="text" class="form-control" id="NAMA_AKTIVA" name="NAMA_AKTIVA" placeholder="NAMA AKTIVA" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>KETERANGAN</label>
              <input type="text" class="form-control" id="KETERANGAN" name="KETERANGAN" placeholder="KETERANGAN" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>TANGGAL BELI</label>
              <input type="date" class="form-control" id="TANGGAL_BELI" name="TANGGAL_BELI" placeholder="TANGGAL BELI" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>HARGA PEROLEHAN</label>
              <input type="text" class="form-control" id="HARGA_PEROLEHAN" name="HARGA_PEROLEHAN"  placeholder="HARGA PEROLEHAN">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>KELOMPOK AKTIVA</label>
              <input type="text" class="form-control" id="KELOMPOK_AKTIVA" name="KELOMPOK_AKTIVA" placeholder="KELOMPOK AKTIVA" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>JENIS HARTA</label>
              <input type="text" class="form-control" id="JENIS_HARTA" name="JENIS_HARTA" placeholder="JENIS HARTA" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>JENIS USAHA</label>
              <input type="text" class="form-control" id="JENIS_USAHA" name="JENIS_USAHA" placeholder="JENIS USAHA" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
              <div class="form-group">
                <label>STATUS PEMBEBANAN</label>
                <input type="text" class="form-control" id="STATUS_PEMBEBANAN" name="STATUS_PEMBEBANAN" placeholder="STATUS PEMBEBANAN" readonly>
              </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>TANGGAL JUAL</label>
              <input type="date" class="form-control" id="TANGGAL_JUAL" name="TANGGAL_JUAL" placeholder="TANGGAL JUAL">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>HARGA JUAL</label>
              <input type="text" class="form-control" id="HARGA_JUAL" name="HARGA_JUAL" placeholder="HARGA JUAL">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>PH FISKAL</label>
              <input type="text" class="form-control" id="PH_FISKAL" name="PH_FISKAL" placeholder="PH FISKAL" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>AK PENYUSUTAN TAHUN SEBELUMNYA</label>
              <input type="text"  class="form-control" id="AKUMULASI_PENYUSUTAN_FISKAL" name="AKUMULASI_PENYUSUTAN_FISKAL" placeholder="AKUMULASI PENYUSUTAN FISKAL" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>NSBF TAHUN SEBELUMNYA</label>
              <input type="text" class="form-control" id="NILAI_SISA_BUKU_FISKAL" name="NILAI_SISA_BUKU_FISKAL" placeholder="NILAI SISA BUKU FISKAL" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>PENYUSUTAN TAHUN SEBELUMNYA</label>
              <input type="text" class="form-control" id="PENYUSUTAN_FISKAL" name="PENYUSUTAN_FISKAL" placeholder="PENYUSUTAN FISKAL" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>PEMBEBANAN SEBELUMNYA</label>
              <input type="text" class="form-control" id="PEMBEBANAN" name="PEMBEBANAN" placeholder="PEMBEBANAN" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>AK PENYUSUTAN TAHUN BERJALAN</label>
              <input type="text" class="form-control" id="AKUMULASI_PENYUSUTAN" name="AKUMULASI_PENYUSUTAN" placeholder="AKUMULASI PENYUSUTAN" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>NSBF TAHUN BERJALAN</label>
              <input type="text" class="form-control" id="NSBF" name="NSBF" placeholder="NSBF" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <div class="navbar-right">
                <button type="reset" class="btn btn-default"><i class="fa fa-trash-o"></i> Reset</button>
                <button type="button" class="btn btn-danger waves-effect" id="btnBack"><i class="fa fa-reply"></i> BACK</button>
                <button type="button" class="btn btn-info waves-effect" id="btnSave"><i class="fa fa-save"></i> SAVE</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-------------------------------------->
							
<script>
  $(document).ready(function() {
		var 
      table				="",
      vmasapajak = "",
      vtahunpajak = "";

   var vid_lines 			="", 
			vid_lines1 			="", 
			vid_lines2 			="", 
			vis_checkAll		=1, 
			vis_checkAll_final	=1,
			vis_checkAll_nonfinal	=1; 

		$("#tambah-data").hide();
    $("#btnRejectSubmit").attr("disabled", true);
    valueAdd();
    Pace.track(function(){  
      $('#tabledata').DataTable({			
        "serverSide"	: true,
        "processing"	: false,
        "ajax"			: {
								 "url"  		: "<?php echo site_url('fixed_asset/load_rekonsiliasi');?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
										d._kelompokasset 		= 'B';
										d._searchBulanfrom 		= $('#bulanfrom').val();
                    d._searchBulanto 		= $('#bulanto').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
        "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "ASSET_NO", "class":"text-left", "width" : "60px" },
					{ "data": "JENIS_AKTIVA", "class":"text-left", "width" : "60px" },
					{ "data": "NAMA_AKTIVA" },
					{ "data": "KETERANGAN" },
					{ "data": "TANGGAL_BELI" },
					{ "data": "HARGA_PEROLEHAN", "class":"text-right" },
					{ "data": "KELOMPOK_AKTIVA" },
					{ "data": "JENIS_HARTA" },
					{ "data": "JENIS_USAHA" },
					{ "data": "STATUS_PEMBEBANAN" },
					{ "data": "TANGGAL_JUAL" },
					{ "data": "HARGA_JUAL", "class":"text-right" },
					{ "data": "PH_FISKAL", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "NILAI_SISA_BUKU_FISKAL", "class":"text-right" },
					{ "data": "PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "PEMBEBANAN", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN", "class":"text-right" },
					{ "data": "NSBF", "class":"text-right" },
					{ "data": "IS_CHECKLIST", "class":"text-right" },
          { "data": "REKON_FIXED_ASSET_ID" },
          { "data": "MASA_PAJAK" },
          { "data": "TAHUN_PAJAK" }
				], 		
        "columnDefs": [ 
				 {
					"targets": [21],
					"visible": false
				} 
			],	 	
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
    });
		table = $('#tabledata').DataTable();
		$("#dBulanan input[type=search]").addClear();		
		$('#dBulanan .dataTables_filter input[type="search"]').attr('placeholder','Search Jenis Aktiva/Nama Aktiva/Keterangan/Kelompok Aktiva ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
    table.on( 'draw', function () {
			$(".bulanan").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
				 actionCheck(1);
			 });				
			//btnDisabled();
			getSelectAll();
			//getFormCSV();
		} );
		 
  //=================================== BERWUJUD ================================//	
    $('#tabledata_bulanan_final').DataTable({			
			"serverSide"	: true,
			"processing"	: false,
			"ajax"			: {
          "url"  		: "<?php echo site_url('fixed_asset/load_rekonsiliasi_nb');?>",
          "type" 		: "POST",								
          "data"			: function ( d ) {
            d._kelompokasset 		= 'N';
            d._searchBulanfrom 		= $('#bulanfrom').val();
            d._searchBulanto 		= $('#bulanto').val();
            d._searchTahun 		= $('#tahun').val();
            d._searchPembetulan	= $('#pembetulanKe').val();
          }								
      },
      "language"		: {
        "emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
        "infoEmpty"		: "Empty Data",
        "processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
        "search"		: "_INPUT_"
      },
      "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "ASSET_NO", "class":"text-left", "width" : "60px" },
					{ "data": "JENIS_AKTIVA", "class":"text-left", "width" : "60px" },
					{ "data": "NAMA_AKTIVA" },
					{ "data": "KETERANGAN" },
					{ "data": "TANGGAL_BELI" },
					{ "data": "HARGA_PEROLEHAN", "class":"text-right" },
					{ "data": "KELOMPOK_AKTIVA" },
					{ "data": "JENIS_HARTA" },
					{ "data": "JENIS_USAHA" },
					{ "data": "STATUS_PEMBEBANAN" },
					{ "data": "TANGGAL_JUAL" },
					{ "data": "HARGA_JUAL", "class":"text-right" },
					{ "data": "PH_FISKAL", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "NILAI_SISA_BUKU_FISKAL", "class":"text-right" },
					{ "data": "PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "PEMBEBANAN", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN", "class":"text-right" },
					{ "data": "NSBF", "class":"text-right" },
					{ "data": "IS_CHECKLIST", "class":"text-right" },
          { "data": "REKON_FIXED_ASSET_ID" },
          { "data": "MASA_PAJAK" },
          { "data": "TAHUN_PAJAK" }
      ],
      "columnDefs": [ 
        {
          "targets": [21],
          "visible": false
        } 
      ],	 		
      "scrollY"			: 480, 
      "scrollCollapse"	: true, 
      "scrollX"			: true,
      "ordering"			: false,
      "pageLength"		: 100,
      "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
    });		
    var table_final = "";
			table_final = $('#tabledata_bulanan_final').DataTable();		
			$("#dFinal input[type=search]").addClear();		
			$('#dFinal .dataTables_filter input[type="search"]').attr('placeholder','Search Jenis Aktiva/Nama Aktiva/Keterangan/Kelompok Aktiva ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
			$("#tabledata_bulanan_non_bangunan_filter .add-clear-x").on('click',function(){
				table_final.search('').column().search('').draw();			
			});
			table_final.on( 'draw', function () {
			$(".final").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
         actionCheck(2);
			 });					
			getSelectAll1();
		} );		 
//===============================BULANAN NON FINAL ===================================//
    $('#tabledata_bulanan_tak_berwujud').DataTable({			
			"serverSide"	: true,
			"processing"	: false,
			"ajax"			: {
							"url"  		: "<?php echo site_url('fixed_asset/load_rekonsiliasi_tb');?>",
								 "type" 		: "POST",								
								 "data"			: function ( d ) {
                    d._kelompokasset 		= 'T';
										d._searchBulanfrom 		= $('#bulanfrom').val();
                    d._searchBulanto 		= $('#bulanto').val();
										d._searchTahun 		= $('#tahun').val();
										d._searchPembetulan	= $('#pembetulanKe').val();
									}								
							},
			 "language"		: {
					"emptyTable"	: "<span class='label label-danger'>Data not found!</span>",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url();?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "checkbox", "class":"text-center", "height" : "10px" },
					{ "data": "no", "class":"text-center" },
					{ "data": "ASSET_NO", "class":"text-left", "width" : "60px" },
					{ "data": "JENIS_AKTIVA", "class":"text-left", "width" : "60px" },
					{ "data": "NAMA_AKTIVA" },
					{ "data": "KETERANGAN" },
					{ "data": "TANGGAL_BELI" },
					{ "data": "HARGA_PEROLEHAN", "class":"text-right" },
					{ "data": "KELOMPOK_AKTIVA" },
					{ "data": "JENIS_HARTA" },
					{ "data": "JENIS_USAHA" },
					{ "data": "STATUS_PEMBEBANAN" },
					{ "data": "TANGGAL_JUAL" },
					{ "data": "HARGA_JUAL", "class":"text-right" },
					{ "data": "PH_FISKAL", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "NILAI_SISA_BUKU_FISKAL", "class":"text-right" },
					{ "data": "PENYUSUTAN_FISKAL", "class":"text-right" },
					{ "data": "PEMBEBANAN", "class":"text-right" },
					{ "data": "AKUMULASI_PENYUSUTAN", "class":"text-right" },
					{ "data": "NSBF", "class":"text-right" },
					{ "data": "IS_CHECKLIST", "class":"text-right" },
          { "data": "REKON_FIXED_ASSET_ID" },
          { "data": "MASA_PAJAK" },
          { "data": "TAHUN_PAJAK" }
				],
			 "columnDefs": [ 
				 {
					"targets": [21],
					"visible": false
				} 
			],	 		
			 "scrollY"			: 480, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false,
			 "pageLength"		: 100,
			 "lengthMenu"       : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			});
      var table_nonfinal = "";
			table_nonfinal = $('#tabledata_bulanan_tak_berwujud').DataTable();		
			$("#dNonFinal input[type=search]").addClear();		
			$('#dNonFinal .dataTables_filter input[type="search"]').attr('placeholder','Search Jenis Aktiva/Nama Aktiva/Keterangan/Kelompok Aktiva ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
			$("#tabledata_bulanan_tak_berwujud_filter .add-clear-x").on('click',function(){
				table_nonfinal.search('').column().search('').draw();			
			});
			table_nonfinal.on( 'draw', function () {
			$(".nonfinal").on("click", function(){
				 vlinse_id 		= $(this).data("id");
				 vcheckbox_id 	= $(this).attr("id");
         actionCheck(3);
			 });
       getSelectAll2();			 
		} );		 
//======================================================================================//
		$('#tabledata tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empty();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table.row( this ).data();
        $('#ASSET_NO').val(d.ASSET_NO);
        $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
        $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
        $('#KETERANGAN').val(d.KETERANGAN);					
        $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
        $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
        $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
        $('#JENIS_HARTA').val(d.JENIS_HARTA);					
        $('#JENIS_USAHA').val(d.JENIS_USAHA);					
        $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
        $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
        $('#HARGA_JUAL').val(d.HARGA_JUAL);					
        $('#PH_FISKAL').val(d.PH_FISKAL);					
        $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
        $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
        $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
        $('#PEMBEBANAN').val(d.PEMBEBANAN);					
        $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);					
        $('#NSBF').val(d.NSBF);						
				$("#isNewRecord").val("0");
				$("#KELOMPOK_FIXED_ASSET").val("B");
        $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);
        $('#MASA_PAJAK').val(d.MASA_PAJAK);
        $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);
			}			
    }).on( 'dblclick', 'tr', function () {
      table.$('tr.selected').removeClass('selected');
      table_final.$('tr.selected').removeClass('selected');
      table_nonfinal.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var d			    = table.row( this ).data();
      $('#ASSET_NO').val(d.ASSET_NO);
      $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
      $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
      $('#KETERANGAN').val(d.KETERANGAN);					
      $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
      $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
      $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
      $('#JENIS_HARTA').val(d.JENIS_HARTA);					
      $('#JENIS_USAHA').val(d.JENIS_USAHA);					
      $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
      $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
      $('#HARGA_JUAL').val(d.HARGA_JUAL);					
      $('#PH_FISKAL').val(d.PH_FISKAL);					
      $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
      $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
      $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
      $('#PEMBEBANAN').val(d.PEMBEBANAN);					
      $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);	
      $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);
      $('#MASA_PAJAK').val(d.MASA_PAJAK);
      $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);				
      $('#NSBF').val(d.NSBF);						
      $("#isNewRecord").val("0");
      $("#KELOMPOK_FIXED_ASSET").val("B");
      $("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
    });
		$('#tabledata_bulanan_final tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empty();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table_final.row( this ).data();
				$('#ASSET_NO').val(d.ASSET_NO);
        $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
        $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
        $('#KETERANGAN').val(d.KETERANGAN);					
        $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
        $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
        $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
        $('#JENIS_HARTA').val(d.JENIS_HARTA);					
        $('#JENIS_USAHA').val(d.JENIS_USAHA);					
        $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
        $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
        $('#HARGA_JUAL').val(d.HARGA_JUAL);					
        $('#PH_FISKAL').val(d.PH_FISKAL);					
        $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
        $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
        $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
        $('#PEMBEBANAN').val(d.PEMBEBANAN);					
        $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);					
        $('#NSBF').val(d.NSBF);
        $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);	
        $('#MASA_PAJAK').val(d.MASA_PAJAK);
        $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);
				//valueGrid();				
				$("#isNewRecord").val("0");				
			}			
		} ).on( 'dblclick', 'tr', function () {
      table.$('tr.selected').removeClass('selected');
      table_final.$('tr.selected').removeClass('selected');
      table_nonfinal.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var d			    = table_final.row( this ).data();
      $('#ASSET_NO').val(d.ASSET_NO);
      $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
      $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
      $('#KETERANGAN').val(d.KETERANGAN);					
      $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
      $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
      $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
      $('#JENIS_HARTA').val(d.JENIS_HARTA);					
      $('#JENIS_USAHA').val(d.JENIS_USAHA);					
      $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
      $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
      $('#HARGA_JUAL').val(d.HARGA_JUAL);					
      $('#PH_FISKAL').val(d.PH_FISKAL);					
      $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
      $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
      $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
      $('#PEMBEBANAN').val(d.PEMBEBANAN);					
      $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);					
      $('#NSBF').val(d.NSBF);
      $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);
      $('#MASA_PAJAK').val(d.MASA_PAJAK);
      $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);						
      $("#isNewRecord").val("0");
      $("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
    });	
		$('#tabledata_bulanan_tak_berwujud tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				$(this).removeClass('selected');	
				empty();
				$("#isNewRecord").val("1");							
			} else {
				table.$('tr.selected').removeClass('selected');
				table_final.$('tr.selected').removeClass('selected');
				table_nonfinal.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d			    = table_nonfinal.row( this ).data();
				$('#ASSET_NO').val(d.ASSET_NO);
        $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
        $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
        $('#KETERANGAN').val(d.KETERANGAN);					
        $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
        $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
        $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
        $('#JENIS_HARTA').val(d.JENIS_HARTA);					
        $('#JENIS_USAHA').val(d.JENIS_USAHA);					
        $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
        $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
        $('#HARGA_JUAL').val(d.HARGA_JUAL);					
        $('#PH_FISKAL').val(d.PH_FISKAL);					
        $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
        $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
        $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
        $('#PEMBEBANAN').val(d.PEMBEBANAN);					
        $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);					
        $('#NSBF').val(d.NSBF);	
        $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);
        $('#MASA_PAJAK').val(d.MASA_PAJAK);
        $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);
				//$("#btnEdit-nonfinal, #btnDelete-nonfinal").removeAttr('disabled');
				//$("#btnEdit-bulanan, #btnDelete-bulanan,#btnEdit-final, #btnDelete-final").attr( "disabled", true );
				$("#isNewRecord").val("0");
			}			
		}).on( 'dblclick', 'tr', function () {
      table.$('tr.selected').removeClass('selected');
      table_final.$('tr.selected').removeClass('selected');
      table_nonfinal.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var d			    = table_nonfinal.row( this ).data();
      $('#ASSET_NO').val(d.ASSET_NO);
      $('#JENIS_AKTIVA').val(d.JENIS_AKTIVA);
      $('#NAMA_AKTIVA').val(d.NAMA_AKTIVA);					
      $('#KETERANGAN').val(d.KETERANGAN);					
      $('#TANGGAL_BELI').val(d.TANGGAL_BELI);					
      $('#HARGA_PEROLEHAN').val(d.HARGA_PEROLEHAN);					
      $('#KELOMPOK_AKTIVA').val(d.KELOMPOK_AKTIVA);					
      $('#JENIS_HARTA').val(d.JENIS_HARTA);					
      $('#JENIS_USAHA').val(d.JENIS_USAHA);					
      $('#STATUS_PEMBEBANAN').val(d.STATUS_PEMBEBANAN);					
      $('#TANGGAL_JUAL').val(d.TANGGAL_JUAL);					
      $('#HARGA_JUAL').val(d.HARGA_JUAL);					
      $('#PH_FISKAL').val(d.PH_FISKAL);					
      $('#AKUMULASI_PENYUSUTAN_FISKAL').val(d.AKUMULASI_PENYUSUTAN_FISKAL);					
      $('#NILAI_SISA_BUKU_FISKAL').val(d.NILAI_SISA_BUKU_FISKAL);					
      $('#PENYUSUTAN_FISKAL').val(d.PENYUSUTAN_FISKAL);					
      $('#PEMBEBANAN').val(d.PEMBEBANAN);					
      $('#AKUMULASI_PENYUSUTAN').val(d.AKUMULASI_PENYUSUTAN);					
      $('#NSBF').val(d.NSBF);		
      $('#REKON_FIXED_ASSET_ID').val(d.REKON_FIXED_ASSET_ID);
      $('#MASA_PAJAK').val(d.MASA_PAJAK);
      $('#TAHUN_PAJAK').val(d.TAHUN_PAJAK);				
      $("#isNewRecord").val("0");
      $("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);			
    });
		$(".titlelist").on("click", function(){
			empty();
			table.$('tr.selected').removeClass('selected');
			table_final.$('tr.selected').removeClass('selected');
			table_nonfinal.$('tr.selected').removeClass('selected');
		});
		$('.modal').on('shown.bs.modal', function () {
			$('#namawp').trigger('focus')
		})
		$("#btnView").on("click", function(){			
			table.ajax.reload();			
			table_final.ajax.reload();			
			table_nonfinal.ajax.reload();
      valueAdd();
      getSummary();
      /*
      $.ajax({
          url		: "<?php echo site_url('Fixed_asset/load_sum_bnt') ?>",
          type	: "POST",
          dataType:"json", 
          data	: ({_kelasset1 : 'B',_kelasset2 : 'N',_kelasset3 : 'T',_searchBulan : $('#bulan').val(), _searchTahun : $('#tahun').val()}),
          success	: function(result){		
              $("#fixed_asset_bangunan").val(result.sumfab);								
              $("#fixed_asset_non_bangunan").val(result.sumfanb);
              $("#fixed_asset_tak_berwujud").val(result.sumfatb);
              
          }
		  });
      */
						
		});
		$("#btnSave").click(function(){				
			$.ajax({
				url		: "<?php echo site_url('fixed_asset/save_rekonsiliasi');?>",
				type	: "POST",
				data	: $('#form-wp').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading");
					 },
				success	: function(result){
					if (result==1) {
						 table.draw();
						 table_final.draw();
						 table_nonfinal.draw();
						 $("body").removeClass("loading");
						 $("#list-data").slideDown(700);
						 $("#tambah-data").slideUp(700);
						 flashnotif('Sukses','Data Berhasil di Simpan!','success' );
						 empty();
					} else {
						 $("body").removeClass("loading");
						 flashnotif('Error','Data Gagal di Simpan!','error' );
					}
				}
			});	
		});
		
		$("#btnSubmit").click(function(){	
			//var j 	= $("#jenisPajak").val();			
			var b	= $("#bulanfrom").val();	
      var bto	= $("#bulanto").val();		
			var t	= $("#tahun").val();
			var p	= $("#pembetulanKe").val();
			//var tipe = $('#jenisPajak').find(':selected').attr('data-type');
			//var jnm	= $("#jenisPajak").find(":selected").attr("data-name");
	
			var bnm	= $("#bulanfrom").find(":selected").attr("data-name");	
      var bnmto	= $("#bulanto").find(":selected").attr("data-name");
			if (b != '' && t != '') 
			{
				bootbox.confirm({
				title: "Submit data <span class='label label-danger'> Fixed Asset</span> Bulan <span class='label label-danger'>"+bnm+" s/d "+ bnmto + "</span> Tahun <span class='label label-danger'>"+t+"</span> Pembetulan ke <span class='label label-danger'>"+p+"</span> ?",
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
						cek_rekonsiliasi();
					} 
				  }
				});
			}
		});
		$("#bulanfrom, #bulanto, #tahun").on("change", function(){
			valueAdd();			
		});
		
		function cek_rekonsiliasi()
		{
      $.ajax({
      url		: "<?php echo site_url('fixed_asset/submit_rekonsiliasi') ?>",
      type	: "POST",
      data	: $('#form-wp').serialize(),							
      success	: function(result){
        if (result==1) {
          getStart();
          table.draw();
          getSummary();
          table.ajax.reload();			
          table_final.ajax.reload();			
          table_nonfinal.ajax.reload();
          $("body").removeClass("loading");
          flashnotif('Sukses','Data Berhasil di Submit!','success' );						
        } else {
            $("body").removeClass("loading");
            flashnotif('Error','Data Gagal di Submit!','error' );
        }
      }
    });	
		}

    $("#btnRejectSubmit").click(function(){			
			var b	= $("#bulanfrom").val();			
			var t	= $("#tahun").val();
			var p	= $("#pembetulanKe").val();		
			var bnm	= $("#bulan").find(":selected").attr("data-name");	

      var bnm	= $("#bulanfrom").find(":selected").attr("data-name");	
      var bnmto	= $("#bulanto").find(":selected").attr("data-name");

			if (b != '' && t != '') 
			{
				bootbox.confirm({
				title: "REJECT data <span class='label label-danger'> Fixed Asset</span> Bulan <span class='label label-danger'>"+bnm+" s/d " +bnmto+ "</span> Tahun <span class='label label-danger'>"+t+"</span> Pembetulan ke <span class='label label-danger'>"+p+"</span> ?",
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
						reject_rekonsiliasi();
					} 
				  }
				});
			}
		});

    function reject_rekonsiliasi()
		{
      $.ajax({
      url		: "<?php echo site_url('fixed_asset/reject_rekonsiliasi') ?>",
      type	: "POST",
      data	: $('#form-wp').serialize(),							
      success	: function(result){
        if (result==1) {
          getStart();
          table.draw();
          getSummary();
          table.ajax.reload();			
          table_final.ajax.reload();			
          table_nonfinal.ajax.reload();
          $("body").removeClass("loading");
          flashnotif('Sukses','Data Berhasil di Reject!','success' );						
        } else {
            $("body").removeClass("loading");
            flashnotif('Error','Data Gagal di Reject!','error' );
        }
      }
    });	
		}

		$("#btnEdit-bulanan").click(function (){
			$("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
      $("#capAdd").html("<span class='label label-danger'>Edit Data Fixed Asset Bangunan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN";
			//isInput();
		});
		$("#btnEdit-final").click(function (){
      $("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			//$("#btnEdit-bulanan").trigger("click");
			$("#capAdd").html("<span class='label label-danger'>Edit Data Fixed Asset Non Bangunan "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN FINAL";
			//isInput();
		});
		$("#btnEdit-nonfinal").click(function (){
      $("#isNewRecord").val("0");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			//$("#btnEdit-bulanan").trigger("click");
			$("#capAdd").html("<span class='label label-danger'>Edit Data Fixed Asset Tak Berwujud "+vmasapajak+" Tahun "+vtahunpajak+"</span>");
			vtype = "BULANAN NON FINAL";
			//isInput();
		});

		
	// ==================== CHEKLIST ==============
	function actionCheck(x)
	{

		if($("#"+vcheckbox_id).prop('checked') == false){
			  var vischeck	= 0;
			  var st_check	= "Unchecklist";
		 } else {
			 var vischeck	= 1;
			 var st_check	= "Checklist"; 
		 }	
	
		 $.ajax({
			url		: baseURL + 'fixed_asset/check_rekonsiliasi',
			type	: "POST",
			data	: ({line_id : vlinse_id, ischeck : vischeck}),
			success	: function(result){
				if (result==1) {
					if(x==1){
						table.column(1).data().each( function (value, index) {
							if (value==vlinse_id) {
								table.cell( index, 21 ).data(vischeck);
							}
						});
					} else if(x==2){
            table_final.column(1).data().each( function (value, index) {
							if (value==vlinse_id) {
								table_final.cell( index, 21 ).data(vischeck);
							}
						});
          } else {
						table_nonfinal.column(1).data().each( function (value, index) {
							 if (value==vlinse_id) {
                table_nonfinal.cell( index, 21 ).data(vischeck);
							 }
						});
					}
          getSummary();
          getSelectAll();
          getSelectAll1();
          getSelectAll2();
					flashnotif('Sukses','Data Berhasil di '+st_check+'!','success' );
				} else {
					 flashnotif('Error','Data Gagal di '+st_check+'!','error' );
				}
			}
		});
	}
	
	//========================= SELECT ALL===================
	function getSelectAll()
	{
		vis_checkAll=1;
		var a=0;
		table.column(21).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll=0;
			} 
		});			
		
		if(vis_checkAll==1){
			$("#checkboxAll").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll").prop('checked',false).removeAttr("disabled");
		}
		vid_lines = "";
		var i = 0;
		table.column(2).data().each( function (value, index) {			
			i++;
			if(i==1){
				vid_lines += "'"+value+"'";
			} else {
				vid_lines +=" ,"+"'"+value+"'";
			}
		});
		// console.log(vid_lines);
		if(a==0){
			$("#checkboxAll").prop('checked',false).attr("disabled",true);
		}	
	}
	
	//========================= SELECT ALL 1===================
	function getSelectAll1()
	{
		vis_checkAll_final=1;
		var a=0;
		table_final.column(21).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll_final=0;
			} 
		});			
		
		if(vis_checkAll_final){
			$("#checkboxAll-final").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-final").prop('checked',false).removeAttr("disabled");
		}
		vid_lines1 = "";
		var i = 0;
		table_final.column(2).data().each( function (value, index) {			
			i++;
			if(i==1){
				vid_lines1 += "'"+value+"'";
			} else {
				vid_lines1 +=" ,"+"'"+value+"'";
			}
		});
		
		if(a==0){
			$("#checkboxAll-final").prop('checked',false).attr("disabled",true);
		}
	}
	
	
	//========================= SELECT ALL 2===================
	function getSelectAll2()
	{
		vis_checkAll_nonfinal=1;
		var a=0;
		table_nonfinal.column(21).data().each( function (value, index) {	
			a++;
			if(value==0){
				vis_checkAll_nonfinal=0;
			} 
		});			
		
		if(vis_checkAll_nonfinal==1){
			$("#checkboxAll-nonfinal").prop('checked',true).removeAttr("disabled");
		} else {
			$("#checkboxAll-nonfinal").prop('checked',false).removeAttr("disabled");
		}
		vid_lines2 = "";
		var i = 0;
		table_nonfinal.column(2).data().each( function (value, index) {
			i++;
			if(i==1){
				vid_lines2 += value;
			} else {
				vid_lines2 +=" ,"+value;
			}
		});		
		if(a==0){
			$("#checkboxAll-nonfinal").prop('checked',false).attr("disabled",true);
		}	
	}
	
	//============================================================//========================
	$("#btnAdd-bulanan").on("click", function(){		
		$("#isNewRecord").val("1");
    $("#ASSET_NO").val("");
    $("#KELOMPOK_FIXED_ASSET").val("B");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);		
		empty();	
	});
  $("#btnAdd-final").on("click", function(){		
		$("#isNewRecord").val("1");
    $("#ASSET_NO").val("");
    $("#KELOMPOK_FIXED_ASSET").val("N");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);		
		empty();	
	});
  $("#btnAdd-nonfinal").on("click", function(){		
		$("#isNewRecord").val("1");
    $("#ASSET_NO").val("");
    $("#KELOMPOK_FIXED_ASSET").val("T");
		$("#list-data").slideUp(700);
		$("#tambah-data").slideDown(700);		
		empty();	
	});
	$("#btnBack").on("click", function(){		
		$("#tambah-data").slideUp(700);
		$("#list-data").slideDown(700);
		empty();
	});	
	$("#btnEksportCSV").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>fixed_asset/export_format_csv";
			var s       = $('select[name=JenisAsset] option').filter(':selected').val();
			var bfrom       = $("#bulanfrom").val();
      var bto     = $("#bulanto").val();
			var t       = $("#tahun").val();
			window.open(urlnya+'?bulanfrom='+bfrom+'&bulanto='+bto+'&tahun='+t+'&jenisasset='+s, '_blank');
			window.focus(); 	
	});
	$("#btnLoad").on("click", function(){		
			var urlnya  = "<?php echo site_url(); ?>fixed_asset/load_format_csv";
			var j       = $("#jenisPajak").val();
			var tipenya = $("#jenisPajak").find(":selected").attr("data-type");
			var b       = $("#bulan").val();
			var t       = $("#tahun").val();
			window.open(urlnya+'?tipe='+tipenya+'&tax='+j, '_blank');
			window.focus(); 	
			if(tipenya=="BULANAN"){
				if (!table.data().any()){
				 flashnotif('Info','Data Bulanan Kosong!','warning' );
				 return false;
				}
			}
			if(tipenya=="BULANAN FINAL"){
				if (!table_final.data().any()){
				 flashnotif('Info','Data Bulanan Final Kosong!','warning' );
				 return false;
				}
			}
			if(tipenya=="BULANAN NON FINAL"){
				if (!table_nonfinal.data().any()){
				 flashnotif('Info','Data Bulanan Non Final Kosong!','warning' );
				 return false;
				}
			}
			/* if (!table.data().any()){
				 flashnotif('Info','Data Kosong!','warning' );
				 return false;
			} else { */
				$.ajax({			
					url		: "<?php echo site_url(); ?>fixed_asset/cek_data_load_csv",
					type	: "POST",
					data	: ({tax: j,month: b, tipe: tipenya, year: t}),					
					success	: function(result){
						if (result==1) {
							window.open(urlnya+'?tipe='+tipenya+'&tax='+j, '_blank');
							window.focus(); 							 
						} else {
							flashnotif('Error','Data Kosong!','error' );
							return false;
						}
					}
				});				
			//}
	});
	 $("#btnImportCSV").click(function(){
       var form = $('#form-import')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo base_url('fixed_asset/import_CSV') ?>",
            data: data,
            dataType:"json",
            beforeSend	: function(){
              $("body").addClass("loading");					
            }, 
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
              var result	= data.st;	
                if (result==1) {
                    table.ajax.reload();			
                    table_final.ajax.reload();			
                    table_nonfinal.ajax.reload();
                    $("#aRemoveCSV").click();
                    $("body").removeClass("loading");
                    flashnotif('Sukses','Data Berhasil di Import!','success' );	
                    $("#file_csv").val("");
                } else if(result==2){
                    $("body").removeClass("loading");
                    flashnotif('Info','File Import CSV belum dipilih!','warning' );	
                } else if(result==3){
                    $("body").removeClass("loading");
                    flashnotif('Info','Format File Bukan CSV!','warning' );						
                } else if(result==6){
                    $("body").removeClass("loading");
                    flashnotif('Info','Upload CSV Gagal!','warning' );						
                }
                else {
                    $("body").removeClass("loading");
                    flashnotif('Error','Data Gagal di Import!','error' );
                } 
            }
        });
    });		
	
	function getFormCSV(){
		if (!table.data().any()){
			$("#d-FormCsv").slideUp(700);
		} else {
			$("#d-FormCsv").slideDown(700);
		}
	}
		
	function reload_list(){
		$('#tabledata').DataTable().ajax.reload();
		$('#tabledata_bulanan').DataTable().ajax.reload();
		$('#tabledata_non_final').DataTable().ajax.reload();		
	}

  <!--hapus bangunan-->
	$("#btnDelete-bulanan").click(function(){			
		  bootbox.confirm({
			title: "Hapus data Fixed Asset <span class='label label-danger'>"+$('#ASSET_NO').val()+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Hapus'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('Fixed_asset/delete_rekon') ?>",
						type	: "POST",
						data	: ({rekon_fixed_asset_id:$('#REKON_FIXED_ASSET_ID').val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
							},
						success	: function(result){
							if (result==1) {
                getSummary();
                table.ajax.reload();			
                table_final.ajax.reload();			
                table_nonfinal.ajax.reload();	
								 //emptyGrid();
								 $("body").removeClass("loading")
								flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
							} else {
								flashnotif('Error','Data Gagal di Hapus!','error' );
							}
							
						}
					});	
				}
			}
		});			
	})
  <!--Non Bangunan Final-->
  $("#btnDelete-final").click(function(){			
		  bootbox.confirm({
			title: "Hapus data Fixed Asset Non Bangunan <span class='label label-danger'>"+$('#ASSET_NO').val()+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Hapus'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('Fixed_asset/delete_rekon_nb') ?>",
						type	: "POST",
						data	: ({rekon_fixed_asset_id:$('#REKON_FIXED_ASSET_ID').val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
							},
						success	: function(result){
							if (result==1) {
                  getSummary();
                  table.ajax.reload();			
                  table_final.ajax.reload();			
                  table_nonfinal.ajax.reload();		
								 //emptyGrid();
								 $("body").removeClass("loading")
								flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
							} else {
								flashnotif('Error','Data Gagal di Hapus!','error' );
							}
							
						}
					});	
				}
			}
		});			
	})

  <!--Tidak Berwujud-->
  $("#btnDelete-nonfinal").click(function(){			
		  bootbox.confirm({
			title: "Hapus data Fixed Asset Tidak Berwujud <span class='label label-danger'>"+$('#ASSET_NO').val()+"</span> ?",
			message: "Apakah anda ingin melanjutkan?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times-circle"></i> CANCEL'
				},
				confirm: {
					label: '<i class="fa fa-check-circle"></i> Hapus'
				}
			},
			callback: function (result) {
				if(result) {
					$.ajax({
						url		: "<?php echo site_url('Fixed_asset/delete_rekon_tb') ?>",
						type	: "POST",
						data	: ({rekon_fixed_asset_id:$('#REKON_FIXED_ASSET_ID').val()}),
						beforeSend	: function(){
							 $("body").addClass("loading")
							},
						success	: function(result){
							if (result==1) {
                  getSummary();
                  table.ajax.reload();			
                  table_final.ajax.reload();			
                  table_nonfinal.ajax.reload();		
								 //emptyGrid();
								 $("body").removeClass("loading")
								flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
							} else {
								flashnotif('Error','Data Gagal di Hapus!','error' );
							}
							
						}
					});	
				}
			}
		});			
	})

  $("#HARGA_PEROLEHAN, #HARGA_JUAL, #PH_FISKAL, #AKUMULASI_PENYUSUTAN_FISKAL, #NILAI_SISA_BUKU_FISKAL, #PENYUSUTAN_FISKAL #PEMBEBANAN, #AKUMULASI_PENYUSUTAN, #NSBF").number(true,2);

function empty()
{
	$('#ASSET_NO').val('');
  $('#JENIS_AKTIVA').val('');
  $('#NAMA_AKTIVA').val('');					
  $('#KETERANGAN').val('');					
  $('#TANGGAL_BELI').val('');					
  $('#HARGA_PEROLEHAN').val('');					
  $('#KELOMPOK_AKTIVA').val('');					
  $('#JENIS_HARTA').val('');					
  $('#JENIS_USAHA').val('');					
  $('#STATUS_PEMBEBANAN').val('');					
  $('#TANGGAL_JUAL').val('');					
  $('#HARGA_JUAL').val('');					
  $('#PH_FISKAL').val('');					
  $('#AKUMULASI_PENYUSUTAN_FISKAL').val('');					
  $('#NILAI_SISA_BUKU_FISKAL').val('');					
  $('#PENYUSUTAN_FISKAL').val('');					
  $('#PEMBEBANAN').val('');					
  $('#AKUMULASI_PENYUSUTAN').val('');					
  $('#NSBF').val('');	
  $('#REKON_FIXED_ASSET_ID').val("");					
  $("#isNewRecord").val("0");
	table.$('tr.selected').removeClass('selected');
	var j 	= $("#jenisPajak").find(":selected").attr("data-name");			
	var b	= $("#bulan").find(":selected").attr("data-name");			
	var t	= $("#tahun").val();		
	$("#capAdd").html("<span class='label label-danger'>Tambah Data "+j+" Bulan "+b+" Tahun "+t+"</span>");
}

  function valueAdd()
	{
		$("#fAddAkun").val("FIXED ASSET");
		$("#fAddBulan").val($("#bulanfrom").val());
    $("#fAddBulanto").val($("#bulanto").val());
		$("#fAddTahun").val($("#tahun").val());
		$("#fAddPembetulan").val($("#pembetulanKe").val());
	}

  function getSummary()
	{
    $.ajax({
          url		: "<?php echo site_url('Fixed_asset/load_sum_bnt') ?>",
          type	: "POST",
          dataType:"json", 
          data	: ({_kelasset1 : 'B',_kelasset2 : 'N',_kelasset3 : 'T',_searchBulanfrom : $('#bulanfrom').val(),_searchBulanto : $('#bulanto').val(), _searchTahun : $('#tahun').val()}),
          success	: function(result){		
              $("#fixed_asset_bangunan").val(result.sumfab);								
              $("#fixed_asset_non_bangunan").val(result.sumfanb);
              $("#fixed_asset_tak_berwujud").val(result.sumfatb);
              if(result.cntsubmit > 0 && result.status_rekon === 'SUBMIT'){
                $("#btnSubmit").attr("disabled", true);
                $("#btnRejectSubmit").removeAttr("disabled");
                $("#btnEdit-bulanan").attr("disabled", true);
                $("#btnDelete-bulanan").attr("disabled", true);
                $("#btnEdit-final").attr("disabled", true);
                $("#btnDelete-final").attr("disabled", true);
                $("#btnEdit-nonfinal").attr("disabled", true);
                $("#btnDelete-nonfinal").attr("disabled", true);
                $("#checkboxAll").hide();
                $("#checkboxAll-nonfinal").hide();
                $("#checkboxAll-final").hide();
              } else if (result.status_rekon === 'CLOSE') {
                $("#btnSubmit").attr("disabled", true);
                $("#btnRejectSubmit").attr("disabled", true);
                $("#btnEdit-bulanan").attr("disabled", true);
                $("#btnDelete-bulanan").attr("disabled", true);
                $("#btnEdit-final").attr("disabled", true);
                $("#btnDelete-final").attr("disabled", true);
                $("#btnEdit-nonfinal").attr("disabled", true);
                $("#btnDelete-nonfinal").attr("disabled", true);
                $("#checkboxAll").hide();
                $("#checkboxAll-nonfinal").hide();
                $("#checkboxAll-final").hide();
              } else {
                $("#btnSubmit").removeAttr("disabled");
                $("#btnRejectSubmit").attr("disabled", true);
                $("#btnEdit-bulanan").removeAttr("disabled");
                $("#btnDelete-bulanan").removeAttr("disabled");
                $("#btnEdit-final").removeAttr("disabled");
                $("#btnDelete-final").removeAttr("disabled");
                $("#btnEdit-nonfinal").removeAttr("disabled");
                $("#btnDelete-nonfinal").removeAttr("disabled");
                $("#checkboxAll").show();
                $("#checkboxAll-nonfinal").show();
                $("#checkboxAll-final").show();
              }
          }
		  });
  }

    $("#checkboxAll").on("click", function(){
      if($(this).prop('checked') == false){
          var vischeckAll	= 0;
          var st_checkAll	= "Unchecklist";			 
      } else {
        var vischeckAll	= 1;
        var st_checkAll	= "Checklist";			  
      }			
      $.ajax({
        url		: "<?php echo site_url('Fixed_asset/get_selectAll_b') ?>",
        type	: "POST",
        data	: ({id_lines:vid_lines,vcheck:vischeckAll}),	
        success	: function(result){
          if (result==1) {
            if(vischeckAll==1){
              $(".bulanan").prop('checked',true);
            } else {
              $(".bulanan").prop('checked',false);
            }
            table.column(2).data().each( function (value, index) {						 
              table.cell( index, 21 ).data(vischeckAll);	
            } );
            getSummary(); //untuk hasil chek ke summary
            flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
          } else {
            flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
          }
        }
      });
    });

    $("#checkboxAll-final").on("click", function(){
      if($(this).prop('checked') == false){
          var vischeckAll	= 0;
          var st_checkAll	= "Unchecklist";			 
      } else {
        var vischeckAll	= 1;
        var st_checkAll	= "Checklist";			  
      }			
      $.ajax({
        url		: "<?php echo site_url('Fixed_asset/get_selectAll_final') ?>",
        type	: "POST",
        data	: ({id_lines:vid_lines1,vcheck:vischeckAll}),	
        success	: function(result){
          if (result==1) {
            if(vischeckAll==1){
              $(".final").prop('checked',true);
            } else {
              $(".final").prop('checked',false);
            }
            table_final.column(2).data().each( function (value, index) {						 
              table_final.cell( index, 21 ).data(vischeckAll);	
            } );
            getSummary(); //untuk hasil chek ke summary
            flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
          } else {
            flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
          }
        }
      });
    });

    $("#checkboxAll-nonfinal").on("click", function(){
      if($(this).prop('checked') == false){
          var vischeckAll	= 0;
          var st_checkAll	= "Unchecklist";			 
      } else {
        var vischeckAll	= 1;
        var st_checkAll	= "Checklist";			  
      }			
      $.ajax({
        url		: "<?php echo site_url('Fixed_asset/get_selectAll_nonfinal') ?>",
        type	: "POST",
        data	: ({id_lines:vid_lines2,vcheck:vischeckAll}),	
        success	: function(result){
          if (result==1) {
            if(vischeckAll==1){
              $(".nonfinal").prop('checked',true);
            } else {
              $(".nonfinal").prop('checked',false);
            }
              table_nonfinal.column(2).data().each( function (value, index) {						 
              table_nonfinal.cell( index, 21 ).data(vischeckAll);	
            } );
            getSummary(); //untuk hasil chek ke summary
            flashnotif('Sukses','Data Berhasil di '+st_checkAll+'!','success' );			
          } else {
            flashnotif('Error','Data Gagal di '+st_checkAll+'!','error' );
          }
        }
      });
    });

  function getStart()
	{
		$.ajax({
			url		: "<?php echo site_url('fixed_asset/get_start') ?>",
			type	: "POST",
			dataType:"json", 
			data	: ({masa:$("#bulan").val(),tahun:$("#tahun").val(),pasal:$("#jenisPajak").val(), tipe:$("#jenisPajak").find(":selected").attr("data-type"),pembetulan:$("#pembetulanKe").val() }),
			success	: function(result){				
				if (result.isSuccess==1) {	
					// console.log(result.status);
					if(result.status_period=="OPEN"){
						if(result.status=="DRAFT"){
							$("#btnSubmit").slideDown(700);
							$("#btnSubmit").removeAttr("disabled");
						} else {
							$("#btnSubmit").slideUp(700);
							$("#btnSubmit").attr("disabled", true);
						}
					} else {
						$("#btnSubmit").slideUp(700);
						//$("#btnAdd").attr("disabled", true);
					}
					// $("#lblStatus").html(result.status+" - "+result.status_period);
					 $("#keterangan").val(result.keterangan);					 
				} else {
					 //$("#lblStatus").html("-----");
					 //$("#keterangan").val("");
					 //$("#btnAdd").attr("disabled", true);
					 $("#btnSubmit").slideUp(700);
				}				
			}
		});	
	}

 });
    </script>
