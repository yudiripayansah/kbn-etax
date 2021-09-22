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
                  <label for="filter-status-kswp" class="control-label">Status KSWP</label>
                  <select id="filter-status-kswp" class="form-control">
                    <option value="SEMUA">SEMUA</option>
                    <?php
                      foreach ($status_kswp as $key => $sk) {
                          echo '<option value="'.$sk->STATUS_KSWP.'">'.$sk->STATUS_KSWP.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-3">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="filter-tipe-user" class="control-label">Tipe User</label>
                  <select id="filter-tipe-user" class="form-control">
                    <option value="SEMUA">SEMUA</option>
                    <?php
                      foreach ($user_type as $key => $sk) {
                          echo '<option value="'.$sk->USER_TYPE.'">'.$sk->USER_TYPE.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-6">
                <button class="btn btn-info" id="btnValidasi" data-toggle="modal" data-target="#modal-validasi-kswp">Validasi Status KSWP ke DJP</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped table-datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Status KSWP</th>
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
                    <th>User Type</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-validasi-kswp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Validasi KSWP dan NPWP Ke DJP</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-info" id="djp-msgProses">Memproses <span class="djp-counter">0</span> data dari total <span class="djp-total">0</span> data</div>
          <div id="daftarValidasi" style="max-height:500px;overflow:auto;">
            
          </div>
          <div class="w-100 text-center" style="margin-top:15px;">
            <button class="btn btn-success" type="button" id="btn-mulaiValidasi">Mulai Validasi</button>
            <button type="button" class="btn btn-secondary hidden" data-dismiss="modal" aria-label="Close" id="btn-tutupValidasi">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>	
</div>
<script>
  let dataRes = []
  let counter = 0;
  let npwpValidasi = [];
  let token = null
  let resKswp = null
  let resNpwp = null
  let tablePayload = {
    user_type : null,
    status_kswp : null,
  }
  let listDataNpwp = []
  $(document).ready(function(){
    // get data with ajax
    let dataTable = $('.table-datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "scrollY": "300px",
        "scrollX": true,
        "scrollCollapse": true,
        "order": [],
        "ajax": {
            "url": '<?php echo base_url("/djp/get_master_npwp"); ?>',
            "type": "POST",
            "data": (d) => {
              d.user_type = $('#filter-tipe-user').val()
              d.status_kswp = $('#filter-status-kswp').val()
            },
            "dataSrc" : function(res) {
              listDataNpwp = res.data
              return res.data
            }
        },
        "columnDefs": [
          { 
              "targets": [ 0,1 ], //first column / numbering column
              "orderable": false, //set not orderable
          },
        ],
        "pageLength"	: 50,
        "lengthMenu"    : [50, 100, 250, 500, 1000],
        "language"		: {
					"emptyTable"	: "No Data Found!",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url('assets/vendor/simtax/css/images/loading2.gif'); ?>">',
					"search"		: "Search: "
				},
    } );
    $('#btnValidasi').click(async () => {
      let notChecked = true
      counter = 0;
      npwpValidasi = []
      let listDataToCheck = []
      $('#btn-tutupValidasi').addClass('hidden')
      $('#daftarValidasi').html('')
      $('#djp-msgProses').html('Mengambil data mohon menunggu...')
      $('#btn-mulaiValidasi').addClass('hidden')
      $('.checkbox-npwp').each((x)=>{
        if($(`input[data-row-no="${x}"]`).is(':checked')){
          let listChecked = {
            NPWP_SIMTAX: listDataNpwp[x][3],
            NAMA: listDataNpwp[x][5],
            ALAMAT: listDataNpwp[x][7]
          }
          listDataToCheck.push(listChecked)
          notChecked = false
        }
      })
      if(notChecked){
        let getNpwpValidasi = await $.ajax({
          url: '<?php echo base_url('/djp/get_npwp_validasi'); ?>',
          data: {
            user_type: $('#filter-tipe-user').val(),
            status_kswp: $('#filter-status-kswp').val()
          },
          dataType: 'json',
          type: 'POST',
        })
        listDataToCheck = getNpwpValidasi.data
      }
      listDataToCheck.map((x)=>{
        npwpValidasi.push(x)
      })
      $('#btn-mulaiValidasi').removeClass('hidden')
      $('#djp-msgProses').html('Memproses <span class="djp-counter">0</span> data dari total <span class="djp-total">0</span> data')
      $('.djp-total').text(npwpValidasi.length)
      let listTemplate = ''
      npwpValidasi.map((x,i) => {
        listTemplate += `<div class="alert alert-info mb-0 list-validasi-kswp" style="margin-bottom:5px;display:flex;justify-content:space-between;align-items;flex-start" id="daftar-validasi-${i}">
                          <span style="margin-right:10px;">${i+1}.</span>
                          <div style="width:100%">
                            <span>Npwp : <b class="djp-noNpwp">${x.NPWP_SIMTAX}</b></span><br>
                            <span>Nama : <b class="djp-noNpwp">${x.NAMA}</b></span><br>
                            <span>Alamat : <b class="djp-noNpwp">${x.ALAMAT}</b></span><br>
                            <span>Status KSWP : <b class="djp-statusKswp">-</b></span>
                          </div>
                        </div>`
      })
      $('#daftarValidasi').html(listTemplate)
    })
    $('#btn-mulaiValidasi').click(() => {
      $('#btn-mulaiValidasi').addClass('hidden')
      checkDjp(npwpValidasi)
    })
    $('#filter-status-kswp,#filter-tipe-user').change(() => {
      dataTable.ajax.reload()
    })
  })
  async function checkDjp(npwp){
    resKswp = null
    resNpwp = null
    console.log(counter)
		let scrollTo = counter * 117
		$('#daftarValidasi').animate({
        scrollTop: scrollTo
    }, 500);
		$(`#daftar-validasi-${counter} .djp-statusKswp`).text('Loading...')
    let listNpwp = npwp.shift()
      if(listNpwp){
        let aNpwp = listNpwp.NPWP_SIMTAX
    		$('.djp-counter').html(counter+1)
        theNpwp = aNpwp.replace(/\D/g, "")
        let fKswp = null
        let fNpwp = null
        let fToken = null
        if(theNpwp){
          if(token){
            fKswp = await checkKswp(token,theNpwp,aNpwp)
            fNpwp = await checkNpwp(token,theNpwp,aNpwp)
            if(fKswp.message == 'Token tidak valid'){
              fToken = await getToken()
              if(fToken){
                fKswp = await checkKswp(fToken.message,theNpwp,aNpwp)
                fNpwp = await checkNpwp(fToken.message,theNpwp,aNpwp)
              }
            }
          } else {
            fToken = await getToken()
            if(fToken){
              fKswp = await checkKswp(fToken.message,theNpwp,aNpwp)
              fNpwp = await checkNpwp(fToken.message,theNpwp,aNpwp)
            }
          }
        }
        if(fKswp){
          let status_kswp = 'Tidak ada respon'
					if(fKswp && fKswp.message){
						status_kswp = fKswp.message
						if(fKswp.message.status){
							status_kswp = `Status KSWP [${fKswp.message.status}]`	
						}
					}
					$(`#daftar-validasi-${counter} .djp-statusKswp`).text(`Success, dengan respon KSWP = ${status_kswp}`)
					$(`#daftar-validasi-${counter}`).addClass('alert-success').removeClass('alert-info')
    			counter++
          checkDjp(npwp)
        } else {
          $(`#daftar-validasi-${counter} .djp-statusKswp`).text('Error : Terlalu lama menunggu respon dari server')
					$(`#daftar-validasi-${counter}`).addClass('alert-danger').removeClass('alert-info')
    			counter++
					checkDjp(npwp)
        }
      } else {
				$('#djp-msgProses').html('Proses validasi selesai')
				$('#btn-mulaiValidasi').addClass('hidden')
        $('#btn-tutupValidasi').removeClass('hidden')
			}
  }
  function getToken(){
    let user = 'pelindo2'
    let pwd = 'Cvn0fj2489'
    let base_url = 'https://ws.pajak.go.id/djp/'
    let payload = {
      user: user,
      pwd: pwd,
      base_url: base_url
    }
    let res = $.ajax({
      url : `https://api-eservice.indonesiaport.co.id/api_djp/v1/getToken.php/wsdl?user=${user}&pwd=${pwd}&base_url=${base_url}`,
      type: 'POST',
      dataType: 'json',
      data: payload,
			timeout: 30000,
      success: (res) => {
        token = res.message
      },
      error: () => {
        getToken()
      }
    })
    return res
  }
  function checkKswp(token,knpwp,sknpwp){
    let kdizin = 1
    let base_url = 'https://ws.pajak.go.id/djp/'
    let payload = {
      token: token,
      npwp: knpwp,
      kdizin: kdizin,
      base_url: base_url
    }
    return $.ajax({
      url : `https://api-eservice.indonesiaport.co.id/api_djp/v1/getKswp.php/wsdl?auth=${token}&npwp=${knpwp}&kdizin=${kdizin}&base_url=${base_url}`,
      type: 'POST',
      dataType: 'json',
      data: payload,
			timeout: 30000,
      success: (res) => {
        let kswpPayload = {
          npwp_simtax: sknpwp,
          npwp: knpwp,
          res: res
        }
        saveKswp(kswpPayload)
      },
      error: () => {
        console.log('Check Kswp failed')
      }
    })
  }
  function checkNpwp(token,nnpwp,snnpwp){
    let kdizin = 1
    let base_url = 'https://ws.pajak.go.id/djp/'
    let payload = {
      token: token,
      npwp: nnpwp,
      kdizin: kdizin,
      base_url: base_url
    }
    return $.ajax({
      url : `https://api-eservice.indonesiaport.co.id/api_djp/v1/getNpwp.php/wsdl?auth=${token}&npwp=${nnpwp}&kdizin=${kdizin}&base_url=${base_url}`,
      type: 'POST',
      dataType: 'json',
      data: payload,
			timeout: 30000,
      success: (res) => {
        let npwpPayload = {
          npwp_simtax: snnpwp,
          npwp: nnpwp,
          res: res
        }
        saveNpwp(npwpPayload)
      },
      error: () => {
        console.log('Check Npwp failed')
      }
    })
  }
  function saveKswp(payload){
    $.ajax({
      url : `<?php echo base_url('/djp/saveKswp'); ?>`,
      type: 'POST',
      dataType: 'json',
      data: payload,
			timeout: 30000,
    })
  }
  function saveNpwp(payload){
    $.ajax({
      url : `<?php echo base_url('/djp/saveNpwp'); ?>`,
      type: 'POST',
      dataType: 'json',
      data: payload,
			timeout: 30000,
    })
  }
</script>
<style>
  #DataTables_Table_0_filter label input {
    border : 1px solid rgba(0,0,0,.2);
  }
</style>