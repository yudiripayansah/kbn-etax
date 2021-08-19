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
              MASTER NPWP FROM DJP
              </div>
            </div>  						   
          </div>
          <div class="panel-body"> 
            <div class="table-responsive">
              <div class="alert alert-warning">
                Processing <b class="djp-counter"></b> data out of <b class="djp-total"></b>
              </div>
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
    fetchData('pelanggan').then((res) => {
      $('.djp-total').html(res.length)
      res.map((x,i) => {
        dataRes.push(x.NPWP)
      })
      checkDjp(dataRes)
    })
  })
  function checkDjp(npwp){
    counter++
    $('.djp-counter').html(counter)
    let checkNpwp = npwp.pop()
    if(checkNpwp){
      let payload = {
        npwp: checkNpwp,
        type: 'PELANGGAN'
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