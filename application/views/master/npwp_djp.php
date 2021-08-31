<div class="container-fluid">
	<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title"><?php echo $subtitle ?></h4> 
    </div>
  </div>
  <div id="list-data">
    <div class="row"> 
      <div class="col-lg-12">	
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6">
              Daftar data NPWP Customer dan Supplier dari DJP
              </div>
            </div>  						   
          </div>
          <div class="panel-body"> 
            <div class="row d-flex align-items-end" style="display:flex;align-items:flex-end;margin-bottom: 25px;">
              <div class="col-xs-3">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="sync-target" class="control-label">Pilih Tipe Data</label>
                  <select id="sync-target" class="form-control">
                    <option value="PELANGGAN">CUSTOMER</option>
                    <option value="SUPPLIER">SUPPLIER</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-9">
                <button class="btn btn-info" id="sync-button">Sync NPWP and KSWP to DJP</button>
                <div class="alert alert-info hidden" id="sync-info" style="margin:0;">
                  Processing data <span id="sync-name"></span> to sync with DJP <b class="djp-counter"></b> data out of <b class="djp-total"></b>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped table-datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NPWP Simtax</th>
                    <th>NPWP DJP</th>
                    <th>Nama</th>
                    <th>Merk Dagang</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Kabupaten/ Kota</th>
                    <th>Provinsi</th>
                    <th>Kode KLU</th>
                    <th>KLU</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>Jenis WP</th>
                    <th>Badan Hukum</th>
                    <th>Status KSWP</th>
                    <th>User Type</th>
                    <th>Action</th>
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
<script>
  let dataRes = []
  let counter = 0;
  $(document).ready(function(){
    // get data with ajax
    $('.table-datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "scrollY": "300px",
        "scrollX": true,
        "scrollCollapse": true,
        "order": [],
        "ajax": {
            "url": '<?php echo base_url("/djp/get_master_npwp"); ?>',
            "type": "POST"
        },
        "columnDefs": [
          { 
              "targets": [ 0, 18 ], //first column / numbering column
              "orderable": false, //set not orderable
          },
        ],
        "pageLength"	: 50,
        "lengthMenu"    : [50, 100, 250, 500, 1000],
        "language"		: {
					"emptyTable"	: "No Data Found!",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url('assets/vendor/simtax/css/images/loading2.gif'); ?>">',
					"search"		: "_INPUT_"
				},
        "columns": [
					{ "name": "NO", "class":"text-center" },
					{ "name": "NPWP_SIMTAX", "class":"" },
					{ "name": "NPWP", "class":"" },
					{ "name": "NAMA", "class":"" },
					{ "name": "MERK_DAGANG", "class":"" },
					{ "name": "ALAMAT", "class":"" },
					{ "name": "KELURAHAN", "class":"" },
					{ "name": "KECAMATAN", "class":"" },
					{ "name": "KABKOT", "class":"" },
					{ "name": "PROVINSI", "class":"" },
					{ "name": "KODE_KLU", "class":"" },
					{ "name": "KLU", "class":"" },
					{ "name": "TELP", "class":"" },
					{ "name": "EMAIL", "class":"" },
					{ "name": "JENIS_WP", "class":"" },
					{ "name": "BADAN_HUKUM", "class":"" },
					{ "name": "STATUS_KSWP", "class":"" },
					{ "name": "USER_TYPE", "class":"" },
					{ "name": "ACTION", "class":"text-center" },
				],
    } );
    $('#sync-button').click(() => {
      let target = $('#sync-target').val();
      let name = (target == 'PELANGGAN') ? 'CUSTOMER' : target
      $('#sync-name').text(name)
      $('#sync-button').addClass('hidden')
      $('#sync-info').removeClass('hidden')
      fetchData(target.toLowerCase()).then((res) => {
        $('.djp-total').html(res.length)
        res.map((x,i) => {
          dataRes.push(x.NPWP)
        })
        checkDjp(dataRes,target)
      })
    })
  })
  function checkDjp(npwp,target){
    counter++
    $('.djp-counter').html(counter)
    let checkNpwp = npwp.pop()
      if(checkNpwp){
        let payload = {
          npwp: checkNpwp,
          type: target
        }
        $.ajax({
          url: '<?php echo base_url(); ?>/djp/checkDjp',
          type: 'POST',
          dataType: 'json',
          data: payload
        }).success(() => {
          checkDjp(npwp)
        })
      } else {
        $('#sync-info').addClass('hidden')
      $('#sync-button').removeClass('hidden')
      }
  }
  async function fetchData(type){
    let ajax =  new Promise((resolve,reject) => {
                  $.ajax({
                    url: '<?php echo base_url(); ?>/djp/'+type,
                    type: 'GET',
                    dataType: 'json'
                  }).success((res) => {
                    resolve(res.data)
                  })
                })
    return ajax
  }
</script>