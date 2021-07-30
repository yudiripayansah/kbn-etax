<div class="container-fluid">
	
    <?php $this->load->view('template_top') ?>

<div id="list-data">
	<div class="row"> 
		<div class="col-lg-12">	
            <div class="panel panel-info">
						<div class="panel-heading">
							<div class="row">
							  <div class="col-lg-6">
								TAX
							  </div>
							  <div class="col-lg-6">								
								<div class="navbar-right">
									<button id="btnAdd" class="btn btn-default btn-rounded custom-input-width" type="button" ><i class="fa fa-pencil-square-o"></i> ADD</button>		
									<button type="button" id="btnEdit" class="btn btn-rounded btn-default custom-input-width" disabled ><i class="fa fa-pencil"></i> EDIT</button>
									<button type="button" id="btnHapus" class="btn btn-rounded btn-default custom-input-width " disabled ><i class="fa fa-trash-o"></i> DELETE</button>
								</div>
							  </div>
							</div>  						   
						</div>
                
                        <!-- /.panel-heading -->
                        <div class="panel-body"> 
						<div class="table-responsive">
                           <table width="100%" class="display cell-border stripe hover small" id="tabledata"> 
                                <thead>
                                    <tr>
										<th>NO</th>
										<th>KODE CABANG</th>
                                        <th>OPERATING UNIT</th>
                                        <th>TAX CODE</th>
                                        <th>DESCRIPTION</th>
                                        <th>TAX RATE</th>
                                        <th>ENABLED</th>
                                        <th>VENDOR NAME</th>
                                        <th>VENDOR NUMBER</th>
                                        <th>VENDOR SITE CODE</th>
										<th>KODE PAJAK</th>
										<th>JENIS 4 AYAT 2</th>
										<th>KODE PAJAK SPPD</th>
										<th>JENIS 23</th>
										<th>AKUN PAJAK</th>
										<th>GL ACCOUNT</th>
										<th>COMPANY</th>
										<th>BRANCH</th>
										<th>ACCOUNT</th>										
									</tr>
                                </thead>

                            </table>
						</div>
                            <!-- /.table-responsive -->
							
                </div>
                        <!-- /.panel-body -->						
            </div>
                    <!-- /.panel -->
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
</div>

<!-- Awal Form Tambah Data ---------------------------------------------------------------------------------->
<div id="tambah-data"></div>
<!-- Akhir Form Tambah Data --------------------------------------------------------------------------------->

<script>
    $(document).ready(function() {
			var table	= "", vtax_code= "",voperating_unit= "",vtax_rate ="",vvendor_number="";		
			var vdesc	= "", venabled= "",vvendor_site_code= "",vkode_pajak ="",vjns4ayat2="",vkode_pajak_sppd="", vjns23="",vakun_pajak="";
			var vglaccount="",vcompany="", vbranch="", vaccount="", vvendorname="",vkode_cabang="",vtax_code_h="";
			
			$("#btnHapus").hide();
			$("#tambah-data").hide();
					
		 Pace.track(function(){  
		   $('#tabledata').removeAttr('width').DataTable({
			"serverSide"	: true,
			"processing"	: true,
			"pageLength"	: 100,
			"lengthMenu"    : [[100, 250, 500, 1000], [100, 250, 500, 1000]],
			"ajax"			: {
								 "url"  		: "<?php echo site_url('master/load_tx'); ?>",
								 "type" 		: "POST",
								 "beforeSend"	: function () {
										
									}
							  },
			 "language"		: {
					"emptyTable"	: "Data not found!",	
					"infoEmpty"		: "Empty Data",
					"processing"	:' <img src="<?php echo base_url(); ?>assets/vendor/simtax/css/images/loading2.gif">',
					"search"		: "_INPUT_"
				},
			   "columns": [
					{ "data": "no", "class":"text-center" },
					{ "data": "kode_cabang" },
					{ "data": "operating_unit", "class":"text-left", "width" : "60px" },
					{ "data": "tax_code" },
					{ "data": "description" },
					{ "data": "tax_rate" },
					{ "data": "enabled" },
					{ "data": "vendor_name" },
					{ "data": "vendor_number" },
					{ "data": "vendor_site_code" },
					{ "data": "kode_pajak" },
					{ "data": "jenis_4_ayat_2" },
					{ "data": "kode_pajak_sppd" },
					{ "data": "jenis_23" },
					{ "data": "akun_pajak" },
					{ "data": "gl_account" },
					{ "data": "company" },
					{ "data": "branch" },
					{ "data": "account" }					
				],
			"createdRow": function( row, data, dataIndex ) {
				
			  },
			"columnDefs": [ 
				 {
					"targets": [ 1 ],
					"visible": false
				} 
			],			
			 "select"			: true,
			 "scrollY"			: 360, 
			 "scrollCollapse"	: true, 
			 "scrollX"			: true,
			 "ordering"			: false			
			});
		 });
		
		table = $('#tabledata').DataTable();	
		 
		
		$("input[type=search]").addClear();
		$('.dataTables_filter input[type="search"]').attr('placeholder','Search Operating Unit/Tax Code/Tax Rate...').css({'width':'230px','display':'inline-block'}).addClass('form-control input-sm');		
		$("#tabledata_filter .add-clear-x").on('click',function(){
			table.search('').column().search('').draw();			
		});
		
		 table.on( 'draw', function () {
			$("#btnEdit,#btnHapus").attr("disabled",true);
		} );
		
		 $('#tabledata tbody').on( 'click', 'tr', function () {
			if ($(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$("#isNewRecord").val("1");
				empety();
				$("#btnEdit,#btnHapus").attr("disabled",true);				
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var d				= table.row( this ).data();
				vkode_cabang	    = d.kode_cabang;
				vtax_code			= d.tax_code;
				vtax_code_h			= d.tax_code;
				voperating_unit		= d.operating_unit;				
				vtax_rate			= d.tax_rate;
				vvendor_number		= d.vendor_number;
				vdesc			    = d.description;
				venabled		    = d.enabled;				
				vvendor_site_code	= d.vendor_site_code;
				vkode_pajak			= d.kode_pajak;
				vjns4ayat2		    = d.jenis_4_ayat_2;
				vkode_pajak_sppd	= d.kode_pajak_sppd;
				vjns23		        = d.jenis_23;
				vakun_pajak		    = d.akun_pajak;
				vglaccount		    = d.gl_account;
				vcompany		    = d.company;
				vbranch		        = d.branch;
				vaccount		    = d.account;
				vvendorname		    = d.vendor_name;
				vkode_cabang	    = d.kode_cabang;				
				$("#btnEdit,#btnHapus").removeAttr('disabled');	
				$("#isNewRecord").val("0");	
			}			
				 			 
		} ).on("dblclick", "tr", function () {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var d				= table.row( this ).data();
			vkode_cabang	    = d.kode_cabang;
			vtax_code			= d.tax_code;
			vtax_code_h			= d.tax_code;
			voperating_unit		= d.operating_unit;				
			vtax_rate			= d.tax_rate;
			vvendor_number		= d.vendor_number;
			vdesc			    = d.description;
			venabled		    = d.enabled;				
			vvendor_site_code	= d.vendor_site_code;
			vkode_pajak			= d.kode_pajak;
			vjns4ayat2		    = d.jenis_4_ayat_2;
			vkode_pajak_sppd	= d.kode_pajak_sppd;
			vjns23		        = d.jenis_23;
			vakun_pajak		    = d.akun_pajak;
			vglaccount		    = d.gl_account;
			vcompany		    = d.company;
			vbranch		        = d.branch;
			vaccount		    = d.account;
			vvendorname		    = d.vendor_name;
			vkode_cabang	    = d.kode_cabang;
			$("#isNewRecord").val("0");
			$("#btnEdit,#btnHapus").removeAttr('disabled');					
			$("#btnEdit").click();	
		} );
		
		$('.modal').on('shown.bs.modal', function () {
			$('#tax_code').trigger('focus')
		})
		
	$("#btnAdd").on("click", function(){		
		if($('#tambah-data').html()==""){
			$("body").addClass("loading");
			$('#tambah-data').load('<?php echo site_url('master/add_tax') ?>', function(responseTxt,statusTxt,xhr){
				if(statusTxt=="success"){
					$("#isNewRecord").val("1");
					$("#list-data").slideUp(700);
					$("#tambah-data").slideDown(700);
					$("#capAdd").html("<span class='label label-danger'>Add Data</span>");
					empety();	
					//==========================================================================
					$("#btnBack").on("click", function(){
						$("#error1, #error2,#error3,#error4,#error5,#error6").html('');
						$("#derror1, #derror2,#derror3,#derror4,#derror5,#derror6").removeClass("has-error");
						$("#tambah-data").slideUp(700);
						$("#list-data").slideDown(700);
						empety();
					});	
					save_tax_master();
					getSelectTax();
					getSelectOpr();						
					//==========================================================================
				} else {
					flashnotif('Info','Gagal Load Form!: '+xhr.status+' - '+xhr.statusTxt,'warning' );					
				}
				$("body").removeClass("loading");
			});	
		} else {
			$("#isNewRecord").val("1");
			$("#list-data").slideUp(700);
			$("#tambah-data").slideDown(700);
			$("#capAdd").html("<span class='label label-danger'>Add Data</span>");
			empety();	
		}	
		
	});
			
	function save_tax_master(){
		if ($("#isNewRecord").val()==1){
			var stt="Tambah";
		} else {
			var stt="Edit";
		}
		$("#btnSave").click(function(){	
			$("#error1, #error2,#error3,#error4,#error5,#error6,#error7").html('');
			$("#derror1, #derror2,#derror3,#derror4,#derror5,#derror6,#derror7").removeClass("has-error");
			
			if ($("#operating_unit").val()==''){				
				set_error("error1","derror1","Operating unit belum diisi!");
				return false;
			}
			if ($("#tax_code").val()==''){				
				set_error("error2","derror2","Tax code belum diisi!");
				return false;
			}
			if ($("#tax_rate").val()==''){				
				set_error("error3","derror3","Tax rate belum diisi!");
				return false;
			}
			
			if ($("#vendor_number").val()==''){				
				set_error("error5","derror5","Vendor number belum diisi!");
				return false;
			}
			if ($("#vendor_site_code").val()==''){				
				set_error("error6","derror6","Vendor site code belum diisi!");
				return false;
			}
			
			if ($("#kode_pajak").val()==''){				
				set_error("error4","derror4","Kode pajak belum diisi!");
				return false;
			}
						
			if ($("#branch").val()==''){				
				set_error("error7","derror7","Branch belum diisi!");
				return false;
			}
			
			$.ajax({
				url		: "<?php echo site_url('master/tambah_tx') ?>",
				type	: "POST",
				data	: $('#form-tx-tambah').serialize(),
				beforeSend	: function(){
					 $("body").addClass("loading")
					 $("#modal-tambah").modal("hide");
					},
				success	: function(result){
					if (result==1) {
						 table.draw();							
						 $("#list-data").slideDown(700);
						 $("#tambah-data").slideUp(700);
						 $("body").removeClass("loading");
						 flashnotif('Sukses','Data Berhasil di '+stt+'!','success' );
					} else {
						$("body").removeClass("loading");
						flashnotif('Error','Data Gagal di '+stt+'!','error' );
					}					
				}
			});	
				
			return false;
		})
	}
	
	function empety(){
			vtax_code			= "";
			vtax_code_h			= "";
			voperating_unit		= "";				
			vtax_rate			= "";
			vvendor_number		= "";
			vdesc			    = "";
			venabled		    = "";				
			vvendor_site_code	= "";
			vkode_pajak			= "";
			vjns4ayat2		    = "";
			vkode_pajak_sppd	= "";
			vjns23		        = "";
			vakun_pajak		    = "";
			vglaccount		    = "";
			vcompany		    = "";
			vbranch		        = "";
			vaccount		    = "";
			vvendorname		    = "";
			vkode_cabang	    = "";
			
			$("#tax_code").val("");
			$("#tax_code_h").val("");
			$("#kode_cabang").val("");
			$("#operating_unit").val("");
			$("#description").val("");
			$("#tax_rate").val("");
			$("#enabled").val("Y");
			$("#vendor_name").val("");
			$("#vendor_number").val("");
			$("#vendor_site_code").val("");
			$("#kode_pajak").val("");
			$("#jenis_4_ayat_2").val("");
			$("#kode_pajak_sppd").val("");
			$("#jenis_23").val("");
			$("#akun_pajak").val("");
			$("#gl_account").val("");
			$("#company").val("");
			$("#branch").val("");
			$("#account").val("");			
	}
		
		
		$("#btnEdit").click(function (){	
			if($('#tambah-data').html()==""){				
				$("body").addClass("loading");
				$('#tambah-data').load('<?php echo site_url('master/add_tax') ?>', function(responseTxt,statusTxt,xhr){
					if(statusTxt=="success"){
						$("#isNewRecord").val("0");
						$("#list-data").slideUp(700);
						$("#tambah-data").slideDown(700);
						$("#capAdd").html("<span class='label label-danger'>Edit Data</span>");
						
						//==========================================================================
						$("#btnBack").on("click", function(){
							$("#error1, #error2,#error3,#error4,#error5,#error6").html('');
							$("#derror1, #derror2,#derror3,#derror4,#derror5,#derror6").removeClass("has-error");
							$("#tambah-data").slideUp(700);
							$("#list-data").slideDown(700);						
						});	
						save_tax_master();
						getSelectTax();
						getSelectOpr();
						valueGrid();
						//==========================================================================
					} else {
						flashnotif('Info','Gagal Load Form!: '+xhr.status+' - '+xhr.statusTxt,'warning' );					
					}
					$("body").removeClass("loading");
				});	
			} else {				
				$("#isNewRecord").val("0");
				$("#list-data").slideUp(700);
				$("#tambah-data").slideDown(700);
				$("#capAdd").html("<span class='label label-danger'>Edit Data</span>");
				valueGrid();
			}
				
						
		});
		
	function valueGrid()
	{   
		$("#tax_code").val(vtax_code);
		$("#tax_code_h").val(vtax_code);
		$("#kode_cabang").val(vkode_cabang);
		$("#operating_unit").val(voperating_unit);
		$("#description").val(vdesc);
		$("#tax_rate").val(vtax_rate);
		$("#enabled").val(venabled);
		$("#vendor_name").val(vvendorname);
		$("#vendor_number").val(vvendor_number);
		$("#vendor_site_code").val(vvendor_site_code);
		$("#kode_pajak").val(vkode_pajak);
		$("#jenis_4_ayat_2").val(vjns4ayat2);
		$("#kode_pajak_sppd").val(vkode_pajak_sppd);
		$("#jenis_23").val(vjns23);
		$("#akun_pajak").val(vakun_pajak);
		$("#gl_account").val(vglaccount);
		$("#company").val(vcompany);
		$("#branch").val(vbranch);
		$("#account").val(vaccount);		
	}	
	
	function getSelectTax()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_master_tax') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					var vall ='<option value="" >-- Pilih --</option>';
					$("#kode_pajak").html("");					
					$("#kode_pajak").html(vall+result);	
					$("#kode_pajak").val(vkode_pajak);
				}
		});			
	}
	
	function getSelectOpr()
	{
		$.ajax({
				url		: "<?php echo site_url('master/load_operator_unit') ?>",
				type	: "POST",
				dataType: "html",
				success	: function(result){
					var vall ='<option value="" >-- Pilih --</option>';
					$("#operating_unit, #branch").html("");					
					$("#operating_unit, #branch").html(vall+result);
					$("#operating_unit").val(voperating_unit);
					$("#branch").val(vbranch);
				}
		});			
	}
	<!--hapus-->
	$("#btnHapus").click(function(){
			bootbox.confirm({
			title: "Hapus data <span class='label label-danger'>"+vtax_code+"</span> ?",
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
						url		: "<?php echo site_url('master/delete_tx') ?>",
						type	: "POST",
						data	: ({id:vtax_code,cabang:vkode_cabang}),
						beforeSend	: function(){
							 $("body").addClass("loading");							 
							},
						success	: function(result){
							if (result==1) {
								 table.draw();
								 $("#tambah-data").slideUp(700);
								 $("#list-data").slideDown(700);
								 $("body").removeClass("loading")
								 flashnotif('Sukses','Data Berhasil di Hapus!','success' );			
							} else {
								$("body").removeClass("loading")
								flashnotif('Error','Data Gagal di Hapus!','error' );
							}
							
						}
					});		
				}
			}
		});					
	})
							
	
 });
    </script>
