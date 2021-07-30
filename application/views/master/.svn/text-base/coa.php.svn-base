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
						DAFTAR Segment COA
					  </div>
					</div>  						   
				</div>
                
				<div class="panel-body"> 
					<div class="table-responsive">
				   <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
						<thead>
							<tr>
								<th>NO</th>
								<th>CODE COMBINATION ID</th>
								<th>SEGMENT 1</th>
								<th>SEGMENT 2</th>
								<th>SEGMENT 3</th>
								<th>SEGMENT 4</th>
								<th>SEGMENT 5</th>
								<th>SEGMENT 6</th>
								<th>SEGMENT 7</th>
								<th>SEGMENT 8</th>
								<th>SEGMENT 9</th>							
							</tr>
						</thead>
					</table>
					</div>
			    </div>
            </div>
        </div>
    </div>

</div>	

<script>
    $(document).ready(function() {
			var table	= "", 
				vvendor_id= "",
				vvendor_name = "",
				vnpwp ="",
				vvendor_number="",
				valamat_vendor_satu="",
				valamat_vendor_dua="",
				valamat_vendor_tiga="",
				vvendor_site_id="",
				vorganization_id="",
				vkota="",
				vpropinsi="",
				vnegara="",
				vkode_pos="",
				vtelp=""				
				;		
			
		$("#edit-data").hide();
					
		 Pace.track(function(){  
		   $('#tabledata').removeAttr('width').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],			
			"ajax"			: {
								 "url"  		: "<?php echo site_url('master/load_coa'); ?>",
								 "type" 		: "POST",
								 "beforeSend"	: function () {										
									}
							  },
			 "language"		: {
					"emptyTable"	: "Data Tidak Ditemukan!",	
					"infoEmpty"		: "Data Kosong",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "code_combination_id"},
					{ "data": "segment1" },
					{ "data": "segment2" },
					{ "data": "segment3" },
					{ "data": "segment4" },
					{ "data": "segment5" },
					{ "data": "segment6" },
					{ "data": "segment7" },
					{ "data": "segment8" },
					{ "data": "segment9" }
				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			"columnDefs": [ 
				 {
					"targets": [ ],
					"visible": false
				} 
			],			
			//"fixedColumns"		: true,			
			/* fixedColumns:   {
						leftColumns: 1,
						//rightColumns: 1
        }, */		
			 "select"			: true,
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Cari CCID / SEGMENT 4,5 ...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );
	
 });
    </script>
