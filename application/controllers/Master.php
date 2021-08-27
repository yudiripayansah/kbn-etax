<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('dashboard', 'refresh');
        }

        $this->load->model('cabang_mdl');
        $this->load->model('Master_mdl');
        $this->kode_cabang = $this->session->userdata('kd_cabang');
    }
    
    public function load_master_cabang($select="")
    {
        $cabang		= $this->session->userdata('kd_cabang');
        $hasil		= $this->Master_mdl->get_master_cabang();
        $query 		= $hasil['query'];
        $selected	="";
        $result ="";
        foreach ($query->result_array() as $row) {
            if ($select=="select" || $select=="SELECT") {
                $selected = ($row['KODE_CABANG']==$cabang)?"selected":"";
            }
            $result .= "<option value='".$row['KODE_CABANG']."' data-name='".$row['NAMA_CABANG']."' ".$selected." >".$row['NAMA_CABANG']."</option>";
        }
        echo $result;
        $query->free_result();
    }

    public function show_coa()
    {
        $this->template->set('title', 'Master COA');
        $data['subtitle']	= "Master COA";
        $data['activepage'] = "master_data";
        $this->template->load('template', 'master/coa', $data);
    }
    
    public function show_supplier()
    {
        $this->template->set('title', 'Master Supplier');
        $data['subtitle']	= "Master Supplier";
        $data['activepage'] = "master_data";
        $this->template->load('template', 'master/supplier', $data);
    }
    
    public function load_wpp()
    {
        $result	= $this->Master_mdl->get_supplier();
        echo json_encode($result);
    }

    public function load_coa()
    {
        $result	=$this->Master_mdl->get_coa();
        echo json_encode($result);
    }
    
    public function save_supplier()
    {
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('edit_vendor_name', 'NAMA SUPPLIER', 'required');
            $this->form_validation->set_rules('edit_npwp', 'NPWP', 'required');
            $this->form_validation->set_rules('edit_alamat_vendor_satu', 'ALAMAT LINE 1', 'required');

            if ($this->form_validation->run() === true) {
                $vendor_name = $this->input->post('edit_vendor_name');
                $npwp        = $this->input->post('edit_npwp');
                $og_id       = get_og_id($this->kode_cabang);

                $check_duplicate_npwp = $this->Master_mdl->check_duplicate_npwp($npwp, $og_id);
                $check_duplicate_npwp2 = $this->Master_mdl->check_duplicate_npwp2($vendor_name, $npwp, $og_id);

                if ($check_duplicate_npwp > 0) {
                    echo '3';
                    die();
                } else {
                    if ($check_duplicate_npwp2 > 0) {
                        echo '4';
                        die();
                    } else {
                        $data	= $this->Master_mdl->action_save_supplier();
                        if ($data) {
                            echo '1';
                        } else {
                            echo '0';
                        }
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }
    
    public function delete_wpp()
    {
        $data	= $this->Master_mdl->action_delete();
        if ($data) {
            echo '1';
        } else {
            echo '1';
        }
    }
    
    public function tambah_wpp()
    {
        $data	= $this->Master_mdl->action_tambah();
        if ($data) {
            echo '1';
        } else {
            echo '1';
        }
    }
    
    /*==========================================================CUSTOMER===================================================================*/
    
    public function show_customer()
    {
        $this->template->set('title', 'Master Customer');
        $data['subtitle']	= "Master Customer";
        $data['activepage'] = "master_data";
        $this->template->load('template', 'master/customer', $data);
    }
    
    public function load_cs()
    {
        $result	=$this->Master_mdl->get_customer();
        echo json_encode($result);
    }
    public function save_cs()
    {
        $data	= $this->Master_mdl->action_save_cs();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    public function delete_cs()
    {
        $data	= $this->Master_mdl->action_delete_cs();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
        
    public function tambah_cs()
    {
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('customer_name', 'NAMA PELANGGAN', 'required');
            $this->form_validation->set_rules('npwp', 'NPWP', 'required');
            $this->form_validation->set_rules('address_line1', 'ALAMAT LINE1', 'required');
            
            if ($this->form_validation->run() === true) {
                $data	= $this->Master_mdl->action_tambah_cs();
                if ($data) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo validation_errors();
            }
        }
    }
    
    /*==========================================================KARYAWAN===================================================================*/
     
    public function show_karyawan()
    {
        $this->template->set('title', 'Karyawan');
        $data['subtitle']	= "Karyawan";
        $this->template->load('template', 'master/karyawan', $data);
    }
    
    public function load_kw()
    {
        $result	=$this->Master_mdl->get_karyawan();
        echo json_encode($result);
    }
    public function save_kw()
    {
        $data	= $this->Master_mdl->action_save_kw();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    public function delete_kw()
    {
        $data	= $this->Master_mdl->action_delete_kw();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
        
    public function tambah_kw()
    {
        $data	= $this->Master_mdl->action_tambah_kw();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /*===============================================================TAX	=================================================================*/
   
    public function show_tax()
    {
        $this->template->set('title', 'Master Tax');
        $data['subtitle']	= "Master Tax";
        $data['activepage'] = "master_data";
        $this->template->load('template', 'master/tax', $data);
    }
    
    public function load_tx()
    {
        $result	=$this->Master_mdl->get_tax();
        echo json_encode($result);
    }
    public function save_tx()
    {
        $data	= $this->Master_mdl->action_save_tx();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    public function delete_tx()
    {
        $data	= $this->Master_mdl->action_delete_tx();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
        
    public function tambah_tx()
    {
        $data = $this->Master_mdl->action_tambah_tx();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    /*===================================================PERIOD==================================================================*/
    
    public function show_period()
    {
        $this->template->set('title', 'Period');
        $data['subtitle']	= "Period";
        $this->template->load('template', 'master/period', $data);
    }
    
    public function load_pr()
    {
        $result	=$this->Master_mdl->get_period();
        echo json_encode($result);
    }
    public function save_pr()
    {
        $data	= $this->Master_mdl->action_save_pr();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    public function delete_pr()
    {
        $data	= $this->Master_mdl->action_delete_pr();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
        
    public function tambah_pr()
    {
        $data = $this->Master_mdl->action_tambah_pr();
        if ($data) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    public function add_tax()
    {
        $data['result'] = '';
        $this->load->view('master/frm_add_tax', $data);//bisa juga
    }
    
    public function load_master_tax()
    {
        $hasil		= $this->Master_mdl->get_master_tax();
        $query 		= $hasil['query'];
        $selected	="";
        $result ="";
        foreach ($query->result_array() as $row) {
            $result .= "<option value='".$row['JENIS_PAJAK']."' >".$row['JENIS_PAJAK']."</option>";
        }
        echo $result;
        $query->free_result();
    }
    
    public function load_operator_unit()
    {
        $hasil		= $this->Master_mdl->get_operator_unit();
        $query 		= $hasil['query'];
        $cabang		= $this->session->userdata('kd_cabang');
        $selected	="";
        $result ="";
        foreach ($query->result_array() as $row) {
            if ($row['KODE_CABANG']==$cabang) {
                $selected	="selected";
            } else {
                $selected	="";
            }
            $result .= "<option value='".$row['NAMA_CABANG']."' ".$selected.">".$row['NAMA_CABANG']."</option>";
        }
        echo $result;
        $query->free_result();
    }
    
    //Rate Pajak Tangguhan
    public function rate_pajak_tangguhan()
    {
        $this->template->set('title', 'Rate Pajak Tangguhan');
        $data['subtitle']	= "Rate Pajak Tangguhan";
        $data['activepage'] = "master_data";
        $this->template->load('template', 'master/rpt', $data);
    }

    public function load_rpt()
    {
        $result	= $this->Master_mdl->get_rpt();
        echo json_encode($result);
    }

    public function save_rpt()
    {
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('edit_rate', 'RATE', 'required');
            $this->form_validation->set_rules('edit_tahun', 'TAHUN', 'required');

            if ($this->form_validation->run() === true) {
                $tahun = $this->input->post('edit_tahun');
                $aktif        = $this->input->post('edit_aktif');
                $isnewrecord = $this->input->post('isNewRecord');

                $check_duplicate_tahun = $this->Master_mdl->check_duplic_tahun_rpt($aktif, $tahun);
                
                if ($check_duplicate_tahun > 0) {
                    echo '3';
                    die();
                } else {
                    $data	= $this->Master_mdl->action_save_rpt();
                    if ($data) {
                        echo '1';
                    } else {
                        echo '0';
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function delete_rpt()
    {
        $data	= $this->Master_mdl->action_delete_rpt();
        if ($data) {
            echo '1';
        } else {
            echo '1';
        }
    }
    
    //End Rate Pajak Tangguhan

    // import CSV supplier
    private function _upload($field_name, $folder_name, $file_name, $allowed_types, $ext)
    {
        //file upload destination
        $upload_path = './uploads/';
        $config['upload_path'] = $upload_path.$folder_name;
        //allowed file types. * means all types
        $config['allowed_types'] = $allowed_types;
        //allowed max file size. 0 means unlimited file size
        $config['max_size'] = '0';
        //max file name size
        $config['max_filename'] = '355';
        //whether file name should be encrypted or not
        $config['encrypt_name'] = false;
        $config['file_name'] = $file_name;
        //store image info once uploaded
        $image_data = array();
        //check for errors
        $is_file_error = false;
        //check if file was selected for upload
        if (!$_FILES) {
            $is_file_error = true;
        }
        //if file was selected then proceed to upload
        if (!$is_file_error) {
            if (file_exists(FCPATH.$upload_path.$folder_name."/".$file_name.".".$ext)) {
                unlink($upload_path.$folder_name."/".$file_name.".".$ext);
            }
            //load the preferences
            $this->load->library('upload', $config);
            //check file successfully uploaded. 'image_name' is the name of the input
            if (!$this->upload->do_upload($field_name)) {
                //if file upload failed then catch the errors
                $is_file_error = true;
            } else {
                //store the file info
                $image_data = $this->upload->data();
                if ($image_data) {
                    return true;
                }
            }
        }
        return false;
    }

    public function import_CSV_supplier()
    {
        if (function_exists("set_time_limit") == true and @ini_get("safe_mode") == 0) {
            @set_time_limit(0);
        }
        $og_id          = $this->cabang_mdl->get_og_id($this->kode_cabang);
        if (!empty($_FILES['file_csv']['name'])) {
            $path 	= $_FILES['file_csv']['name'];
            $ext  	= pathinfo($path, PATHINFO_EXTENSION);
            $file_name = "fileCSV_Mstr_Supplier";
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            if ($ext=='csv') {
                if ($upl = $this->_upload('file_csv', 'master/csv/', $file_name, 'csv', $ext)) {
                    $row      = 1;
                    $handle   = fopen("./uploads/master/csv/".$file_name.".".$ext, "r");
                    $dataCsv  = array();
                    while (($data = fgetcsv($handle, 0, ";", "'", "\\")) !== false) {
                        if ($row > 1) {
                            if ($data[0] != '') {
                                $sqlcnt =" 
										select count(*) cnt_supplier
											from simtax_master_supplier
											where  vendor_id = ".$data[0]."
										";

                                $qReq   	= $this->db->query($sqlcnt);
                                $vrows  	= $qReq->row();
                                $vcntsupp  	= $vrows->CNT_SUPPLIER;
                                if ($vcntsupp > 0) {
                                    $sql = "update SIMTAX_MASTER_SUPPLIER 
													SET
														VENDOR_NAME         	= '".trim($data[1], '"')."',
														VENDOR_NUMBER       	= '".trim($data[2], '"')."',
														VENDOR_TYPE_LOOKUP_CODE = '".trim($data[3], '"')."',
														NPWP                	= '".trim($data[4], '"')."',
														OPERATING_UNIT      	= '".trim($data[5], '"')."',
														VENDOR_SITE_CODE    	= '".trim($data[7], '"')."',
														ADDRESS_LINE1       	= '".trim($data[8], '"')."',
														ADDRESS_LINE2       	= '".trim($data[9], '"')."',
														ADDRESS_LINE3       	= '".trim($data[10], '"')."',
														CITY                	= '".trim($data[1], '"')."',
														PROVINCE            	= '".trim($data[12], '"')."',
														COUNTRY             	= '".trim($data[13], '"')."',
														ZIP                 	= '".trim($data[14], '"')."',
														AREA_CODE           	= '".trim($data[15], '"')."',
														PHONE               	= '".trim($data[16], '"')."',
														ORGANIZATION_ID     	= ".trim($data[17], '"')."
													WHERE VENDOR_ID = ".$data[0];
                                } else {
                                    $sql = "insert 
													INTO SIMTAX_MASTER_SUPPLIER 
													(VENDOR_ID
													,VENDOR_NAME
													,VENDOR_NUMBER
													,VENDOR_TYPE_LOOKUP_CODE
													,NPWP
													,OPERATING_UNIT
													,VENDOR_SITE_ID
													,VENDOR_SITE_CODE
													,ADDRESS_LINE1
													,ADDRESS_LINE2
													,ADDRESS_LINE3
													,CITY
													,PROVINCE
													,COUNTRY
													,ZIP
													,AREA_CODE
													,PHONE
													,ORGANIZATION_ID
													)
													VALUES (
													SIMTAX_MASTER_SUPPLIER_S.NEXTVAL
													,'".trim($data[1], '"')."'
													,'".trim($data[2], '"')."'
													,'".trim($data[3], '"')."'
													,'".trim($data[4], '"')."'
													,'".trim($data[5], '"')."'
													,0
													,'-'
													,'".trim($data[8], '"')."'
													,'".trim($data[9], '"')."'
													,'".trim($data[10], '"')."'
													,'".trim($data[11], '"')."'
													,'".trim($data[12], '"')."'
													,'".trim($data[13], '"')."'
													,'".trim($data[14], '"')."'
													,'".trim($data[15], '"')."'
													,'".trim($data[16], '"')."'
													,".trim($data[17], '"')."
													)
											";
                                }
                            } else {
                                $sql = "insert 
										INTO SIMTAX_MASTER_SUPPLIER
										(VENDOR_ID
										,VENDOR_NAME
										,VENDOR_NUMBER
										,VENDOR_TYPE_LOOKUP_CODE
										,NPWP
										,OPERATING_UNIT
										,VENDOR_SITE_ID
										,VENDOR_SITE_CODE
										,ADDRESS_LINE1
										,ADDRESS_LINE2
										,ADDRESS_LINE3
										,CITY
										,PROVINCE
										,COUNTRY
										,ZIP
										,AREA_CODE
										,PHONE
										,ORGANIZATION_ID
										)
										VALUES (
												SIMTAX_MASTER_SUPPLIER_S.NEXTVAL
												,'".trim($data[1], '"')."'
												,'".trim($data[2], '"')."'
												,'".trim($data[3], '"')."'
												,'".trim($data[4], '"')."'
												,'".trim($data[5], '"')."'
												,0
												,'-'
												,'".trim($data[8], '"')."'
												,'".trim($data[9], '"')."'
												,'".trim($data[10], '"')."'
												,'".trim($data[11], '"')."'
												,'".trim($data[12], '"')."'
												,'".trim($data[13], '"')."'
												,'".trim($data[14], '"')."'
												,'".trim($data[15], '"')."'
												,'".trim($data[16], '"')."'
												,".trim($data[17], '"')."
												)
										";
                            }
                                                 
                            $query 		= $this->db->query($sql);
                            if (!$query) {
                                $result['st'] =0;
                                echo json_encode($result);
                                die();
                            } else {
                                $result['st'] = 1;
                            }
                        }
                
                        $row++;
                    }
                } else {
                    $result['st'] = 6;
                }
            } else {
                $result['st'] = 3;
            }
        } else {
            $result['st']	= 2 ;
        }
                  
        echo json_encode($result);
    }

    // end import

    //eksport csv supplier
    public function export_format_csv_supplier()
    {
        $this->load->helper('csv_helper');
        $date	    = date("Y-m-d H:i:s");
        $export_arr = array();
        $data       = $this->Master_mdl->get_format_csv_supplier();
        //$title = array("VENDOR_ID","VENDOR_NAME","VENDOR_NUMBER","VENDOR_TYPE_LOOKUP_CODE","NPWP","OPERATING_UNIT","VENDOR_SITE_ID","VENDOR_SITE_CODE","ADDRESS_LINE1",
        //				"ADDRESS_LINE2","ADDRESS_LINE3","CITY","PROVINCE","COUNTRY","ZIP","AREA_CODE","PHONE","ORGANIZATION_ID"
        $title = array('VENDOR_ID','VENDOR_NAME','VENDOR_NUMBER','VENDOR_TYPE_LOOKUP_CODE','NPWP','STATUS_KSWP','OPERATING_UNIT','VENDOR_SITE_ID','VENDOR_SITE_CODE','ADDRESS_LINE1',
                        'ADDRESS_LINE2','ADDRESS_LINE3','CITY','PROVINCE','COUNTRY','ZIP','AREA_CODE','PHONE','ORGANIZATION_ID');
        array_push($export_arr, $title);
        
        if (!empty($data)) {
            foreach ($data->result_array() as $row) {
                //$npwp = str_replace(".","",$row['NPWP']);
                $npwp = format_npwp($row['NPWP'], false);
                //$npwp = $row['NPWP'];

                array_push(
                    $export_arr,
                    array(
                        $row['VENDOR_ID']
                        ,$row['VENDOR_NAME']
                        ,$row['VENDOR_NUMBER']
                        ,$row['VENDOR_TYPE_LOOKUP_CODE']
                        ,$npwp
                        ,$row['STATUS_KSWP']
                        ,$row['OPERATING_UNIT']
                        ,$row['VENDOR_SITE_ID']
                        ,$row['VENDOR_SITE_CODE']
                        ,$row['ADDRESS_LINE1']
                        ,$row['ADDRESS_LINE2']
                        ,$row['ADDRESS_LINE3']
                        ,$row['CITY']
                        ,$row['PROVINCE']
                        ,$row['COUNTRY']
                        ,$row['ZIP']
                        ,$row['AREA_CODE']
                        ,$row['PHONE']
                        ,$row['ORGANIZATION_ID']
                        )
                );
            }
        }
        convert_to_csv($export_arr, 'fileCSV_Mstr_Supplier '.$date.'.csv', ';');
    }

    //end eksport csv supplier

    //eksport csv customer
    public function export_format_csv_customer()
    {
        $this->load->helper('csv_helper');
        $date	    = date("Y-m-d H:i:s");
        $export_arr = array();
        $data       = $this->Master_mdl->get_format_csv_customer();
        $title = array('CUSTOMER_ID','CUSTOMER_NAME','ALIAS_CUSTOMER','CUSTOMER_NUMBER','NPWP','STATUS_KSWP','OPERATING_UNIT','CUSTOMER_SITE_ID','CUSTOMER_SITE_NUMBER','CUSTOMER_SITE_NAME',
                        'ADDRESS_LINE1','ADDRESS_LINE2','ADDRESS_LINE3','CITY','PROVINCE','COUNTRY','ZIP','ORGANIZATION_ID');
        array_push($export_arr, $title);
        
        if (!empty($data)) {
            foreach ($data->result_array() as $row) {
                //$npwp = str_replace(".","",$row['NPWP']);
                $npwp = format_npwp($row['NPWP'], false);
                //$npwp = $row['NPWP'];
                array_push(
                    $export_arr,
                    array(
                        $row['CUSTOMER_ID']
                        ,$row['CUSTOMER_NAME']
                        ,$row['ALIAS_CUSTOMER']
                        ,$row['CUSTOMER_NUMBER']
                        ,$npwp
                        ,$row['STATUS_KSWP']
                        ,$row['OPERATING_UNIT']
                        ,$row['CUSTOMER_SITE_ID']
                        ,$row['CUSTOMER_SITE_NUMBER']
                        ,$row['CUSTOMER_SITE_NAME']
                        ,$row['ADDRESS_LINE1']
                        ,$row['ADDRESS_LINE2']
                        ,$row['ADDRESS_LINE3']
                        ,$row['CITY']
                        ,$row['PROVINCE']
                        ,$row['COUNTRY']
                        ,$row['ZIP']
                        ,$row['ORGANIZATION_ID']
                        )
                );
            }
        }
        convert_to_csv($export_arr, 'fileCSV_Mstr_Customer '.$date.'.csv', ';');
    }

    //end eksport csv customer

    // import customer
    public function import_CSV_customer()
    {
        if (function_exists("set_time_limit") == true and @ini_get("safe_mode") == 0) {
            @set_time_limit(0);
        }
        $og_id          = $this->cabang_mdl->get_og_id($this->kode_cabang);
        if (!empty($_FILES['file_csv']['name'])) {
            $path 	= $_FILES['file_csv']['name'];
            $ext  	= pathinfo($path, PATHINFO_EXTENSION);
            $file_name = "fileCSV_Mstr_Supplier";
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            if ($ext=='csv') {
                if ($upl = $this->_upload('file_csv', 'master/csv/', $file_name, 'csv', $ext)) {
                    $row      = 1;
                    $handle   = fopen("./uploads/master/csv/".$file_name.".".$ext, "r");
                    $dataCsv  = array();
                    while (($data = fgetcsv($handle, 0, ";", "'", "\\")) !== false) {
                        if ($row > 1) {
                            if ($data[0] != '') {
                                $sqlcnt =" 
							   select count(*) cnt_cust
								   from simtax_master_pelanggan
								   where  customer_id = ".$data[0]."
							   ";

                                $qReq   	= $this->db->query($sqlcnt);
                                $vrows  	= $qReq->row();
                                $vcntcust  	= $vrows->CNT_CUST;
                                if ($vcntcust > 0) {
                                    $sql = "update SIMTAX_MASTER_PELANGGAN 
										   SET
										   	   CUSTOMER_NAME         	= '".trim($data[1], '"')."',
											   ALIAS_CUSTOMER       	= '".trim($data[2], '"')."',
											   CUSTOMER_NUMBER 			= '".trim($data[3], '"')."',
											   NPWP                		= '".trim($data[4], '"')."',
											   OPERATING_UNIT      		= '".trim($data[5], '"')."',
											   CUSTOMER_SITE_ID    		= '".trim($data[6], '"')."',
											   CUSTOMER_SITE_NUMBER     = '".trim($data[7], '"')."',
											   CUSTOMER_SITE_NAME       = '".trim($data[8], '"')."',
											   ADDRESS_LINE1       		= '".trim($data[9], '"')."',
											   ADDRESS_LINE2            = '".trim($data[10], '"')."',
											   ADDRESS_LINE3            = '".trim($data[11], '"')."',
											   CITY             		= '".trim($data[12], '"')."',
											   PROVINCE                 = '".trim($data[13], '"')."',
											   COUNTRY           		= '".trim($data[14], '"')."',
											   ZIP               		= '".trim($data[15], '"')."',
											   ORGANIZATION_ID          = ".trim($data[16], '"')."
										   WHERE CUSTOMER_ID = ".$data[0];
                                } else {
                                    $sql = "insert into SIMTAX_MASTER_PELANGGAN  ( 
												customer_id,
												customer_name,
												alias_customer,
												customer_number,
												npwp,
												operating_unit,
												customer_site_id,
												customer_site_number,
												customer_site_name,
												address_line1,
												address_line2,
												address_line3,
												city,
												province,
												country,
												zip,
												oraganization_id)
										values (
											SIMTAX_MASTER_SUPPLIER_S.NEXTVAL
										   ,'".trim($data[1], '"')."'
										   ,'".trim($data[2], '"')."'
										   ,'".trim($data[3], '"')."'
										   ,'".trim($data[4], '"')."'
										   ,'".trim($data[5], '"')."'
										   ,0
										   ,0
										   ,'".trim($data[8], '"')."'
										   ,'".trim($data[9], '"')."'
										   ,'".trim($data[10], '"')."'
										   ,'".trim($data[11], '"')."'
										   ,'".trim($data[12], '"')."'
										   ,'".trim($data[13], '"')."'
										   ,'".trim($data[14], '"')."'
										   ,'".trim($data[15], '"')."'
										   ,".trim($data[16], '"')."
										   )
								   ";
                                }
                            } else {
                                $sql = "insert into SIMTAX_MASTER_PELANGGAN  ( 
										customer_id,
										customer_name,
										alias_customer,
										customer_number,
										npwp,
										operating_unit,
										customer_site_id,
										customer_site_number,
										customer_site_name,
										address_line1,
										address_line2,
										address_line3,
										city,
										province,
										country,
										zip,
										oraganization_id)
										values (
										SIMTAX_MASTER_SUPPLIER_S.NEXTVAL
										,'".trim($data[1], '"')."'
										,'".trim($data[2], '"')."'
										,'".trim($data[3], '"')."'
										,'".trim($data[4], '"')."'
										,'".trim($data[5], '"')."'
										,0
										,0
										,'".trim($data[8], '"')."'
										,'".trim($data[9], '"')."'
										,'".trim($data[10], '"')."'
										,'".trim($data[11], '"')."'
										,'".trim($data[12], '"')."'
										,'".trim($data[13], '"')."'
										,'".trim($data[14], '"')."'
										,'".trim($data[15], '"')."'
										,".trim($data[16], '"')."
										)
								";
                            }
                
                            $query 		= $this->db->query($sql);
                            if (!$query) {
                                $result['st'] =0;
                                echo json_encode($result);
                                die();
                            } else {
                                $result['st'] = 1;
                            }
                        }
       
                        $row++;
                    }
                } else {
                    $result['st'] = 6;
                }
            } else {
                $result['st'] = 3;
            }
        } else {
            $result['st']	= 2 ;
        }
         
        echo json_encode($result);
    }

    public function npwp_djp()
    {
        $this->template->set('title', 'Master NPWP dari DJP');
        $data['subtitle']	= "Master NPWP dari DJP";
        $data['activepage'] = "npwp_djp";
        $this->template->load('template', 'master/npwp_djp', $data);
    }

    // end import customer
}
