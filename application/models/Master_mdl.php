<?php  defined('BASEPATH') or exit('No direct script access allowed');


class Master_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
            
        $this->kode_cabang = $this->session->userdata('kd_cabang');
    }
    
    public function getEndMonth($thn, $bln)
    {
        $tgl	   = date('Y-m-01', strtotime($thn.'-'.$bln.'-01'));
        $tgl_akhir = date('t', strtotime($tgl));
        return $tgl_akhir;
    }
    
    public function get_master_cabang()
    {
        $cabang				= $this->kode_cabang;
        $where				= "";
        if ($cabang!='000') {
            $where	.=" and kode_cabang='".$cabang."' ";
        }
        $queryExec	        = "Select * from simtax_kode_cabang where 1=1 ".$where." and upper(aktif)='Y' order by kode_cabang";
        $query 		        = $this->db->query($queryExec);
        $result['query']	= $query;
        return $result;
    }
    
    public function get_supplier()
    {
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        $whereStatusKswp = "";
        $filterStatusKswp = "";

        if ($q) {
            $where	= " and (upper(SMS.vendor_id) like '%".strtoupper($q)."%' or upper(SMS.vendor_name) like '%".strtoupper($q)."%' or  (SMS.npwp) like '%".strtoupper($q)."%') ";
        }

        if (isset($_POST['_searchCabang']) && $_POST['_searchCabang'] != "") {
            $kode_cabang = $_POST['_searchCabang'];
            $og_id       = $this->cabang_mdl->get_og_id($kode_cabang);
        } else {
            $og_id = $this->cabang_mdl->get_og_id($this->kode_cabang);
        }
        if (isset($_POST['_searchStatusKswp']) && $_POST['_searchStatusKswp'] != "") {
            $filterStatusKswp = $_POST['_searchStatusKswp'];
        }

        if($where){
            if ($filterStatusKswp !='SEMUA'){
                $whereStatusKswp = "";
                $whereStatusKswp = " and smn.status_kswp = '".$filterStatusKswp."'";
            }
        } else  {
            if($filterStatusKswp != 'SEMUA'){
                $whereStatusKswp = " and smn.status_kswp = '".$filterStatusKswp."'";
            }            
        }
        
        $queryExec = "SELECT						
						   SMS.VENDOR_ID,  
						   SMS.VENDOR_NAME , 
						   SMS.VENDOR_NUMBER, 
						   SMS.VENDOR_TYPE_LOOKUP_CODE,
						   SMS.NPWP,
						   SMS.OPERATING_UNIT ,
						   SMS.VENDOR_SITE_ID,
						   SMS.VENDOR_SITE_CODE ,
						   SMS.ADDRESS_LINE1, 
						   SMS.ADDRESS_LINE2,
						   SMS.ADDRESS_LINE3,
						   SMS.CITY,
						   SMS.PROVINCE,
						   SMS.COUNTRY,
						   SMS.ZIP,
						   SMS.AREA_CODE,PHONE,
						   SMS.ORGANIZATION_ID,
                           SMN.STATUS_KSWP      
					FROM   SIMTAX_MASTER_SUPPLIER SMS
                    LEFT JOIN SIMTAX_MASTER_NPWP SMN ON SMN.NPWP_SIMTAX = SMS.NPWP
					WHERE 1=1 ".$where.$whereStatusKswp." and SMS.organization_id = '".$og_id."' order by 1 desc";
        $queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_MASTER_SUPPLIER SMS
                         LEFT JOIN SIMTAX_MASTER_NPWP SMN ON SMN.NPWP_SIMTAX = SMS.NPWP 
                         where 1=1 ".$where.$whereStatusKswp." and SMS.organization_id = '".$og_id."' order by 1 desc";
        
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        //start row count
        $selectCount	= $this->db->query($queryCount);
        $row        	= $selectCount->row();
        $rowCount  	= $row->JML;
        //end get row count

        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $djp_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $row['NPWP'])->get()->row();
                //$status_kswp = ($djp_npwp->STATUS_KSWP) ? $djp_npwp->STATUS_KSWP : '-';
                $status_kswp = ($row['STATUS_KSWP']) ? $row['STATUS_KSWP'] : '-';
                $ii++;
                $result['data'][] = array(
                            'no'						=> $row['RNUM'],
                            'vendor_id'					=> $row['VENDOR_ID'],
                            'vendor_name'				=> $row['VENDOR_NAME'],
                            'vendor_number'				=> $row['VENDOR_NUMBER'],
                            'vendor_type_lookup_code'	=> $row['VENDOR_TYPE_LOOKUP_CODE'],
                            'npwp'						=> $row['NPWP'],
                            'status_kswp'				=> $status_kswp,
                            'operating_unit'			=> $row['OPERATING_UNIT'],
                            'vendor_site_id'			=> $row['VENDOR_SITE_ID'],
                            'vendor_site_code'			=> $row['VENDOR_SITE_CODE'],
                            'address_line1'				=> $row['ADDRESS_LINE1'],
                            'address_line2'				=> $row['ADDRESS_LINE2'],
                            'address_line3'				=> $row['ADDRESS_LINE3'],
                            'city'						=> $row['CITY'],
                            'province'					=> $row['PROVINCE'],
                            'country'					=> $row['COUNTRY'],
                            'zip'						=> $row['ZIP'],
                            'area_code'					=> $row['AREA_CODE'],
                            'phone'						=> $row['PHONE'],
                            'organization_id'			=> $row['ORGANIZATION_ID'],
                            'djp' => $djp_npwp,

                          );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }

    public function get_coa()
    {
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        if ($q) { //check lgsg where atau and
            $where	= " and (code_combination_id like '%".strtoupper($q)."%' or segment5 like '%".strtoupper($q)."%' or  segment4 like '%".strtoupper($q)."%') ";
        }
        
        $queryExec = "select code_combination_id
							 , segment1  
							 , segment2
							 , segment3  
							 , segment4  
							 , segment5  
							 , segment6  
							 , segment7  
							 , segment8  
							 , segment9  
						  from gl_code_combinations 
					WHERE 1=1 ".$where;
                            
        $queryCount = "SELECT count(1) JML      
						 FROM gl_code_combinations where 1=1 ".$where;
        
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        //start row count
        $selectCount	= $this->db->query($queryCount);
        $row        	= $selectCount->row();
        $rowCount  	= $row->JML;
        //end get row count

        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $ii++;
                $result['data'][] = array(
                            'no'					=> $row['RNUM'],
                            'code_combination_id'	=> $row['CODE_COMBINATION_ID'],
                            'segment1'				=> $row['SEGMENT1'],
                            'segment2'				=> $row['SEGMENT2'],
                            'segment3'				=> $row['SEGMENT3'],
                            'segment4'				=> $row['SEGMENT4'],
                            'segment5'				=> $row['SEGMENT5'],
                            'segment6'				=> $row['SEGMENT6'],
                            'segment7'				=> $row['SEGMENT7'],
                            'segment8'				=> $row['SEGMENT8'],
                            'segment9'				=> $row['SEGMENT9']
                          );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }

    public function check_duplicate_npwp($npwp, $org_id)
    {
        $sql = "SELECT count(*) TOTAL from simtax_master_supplier
						where npwp != '-' and npwp is not null
						and npwp != '0' and npwp = '".$npwp."' and npwp != '000000000000000'
						and organization_id = '".$org_id."'
						and vendor_id >= 5000000";
        $query	= $this->db->query($sql);
        $total	= $query->row()->TOTAL;

        return $total;
    }

    public function check_duplicate_npwp2($nama_wp, $npwp, $org_id)
    {
        $sql = " SELECT COUNT(*) TOTAL from simtax_master_supplier
                        where vendor_name = '".$nama_wp."' and npwp = '".$npwp."' and (npwp is null
                        or npwp = '0' or npwp = '-' or npwp = '000000000000000')
						and organization_id = '".$org_id."'";

        $query	= $this->db->query($sql);
        $total	= $query->row()->TOTAL;

        return $total;
    }
    
    public function action_save_supplier()
    {
        $vendor_id			= $this->input->post('edit_vendor_id');
        $vendor_name		= $this->input->post('edit_vendor_name');
        $npwp				= $this->input->post('edit_npwp');
        $vendor_number		= $this->input->post('edit_vendor_num');
        $alamat_vendor_satu	= $this->input->post('edit_alamat_vendor_satu');
        $alamat_vendor_dua	= $this->input->post('edit_alamat_vendor_dua');
        $alamat_vendor_tiga	= $this->input->post('edit_alamat_vendor_tiga');
        $vendor_site_id		= $this->input->post('edit_vendor_site_id');
        $organization_id	= $this->input->post('edit_organization_id');
        $kota				= $this->input->post('edit_kota');
        $propinsi			= $this->input->post('edit_propinsi');
        $negara				= $this->input->post('edit_negara');
        $kode_pos			= $this->input->post('edit_kode_pos');
        $telp				= $this->input->post('edit_telp');
        
        //flag
        $isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

        $og_id          = $this->cabang_mdl->get_og_id($this->kode_cabang);
        $operating_unit = $this->cabang_mdl->get_by_id($this->kode_cabang)->NAMA_CABANG;

        if ($isNewRecord=="1") {
            $sql	="insert into SIMTAX_MASTER_SUPPLIER
				  ( VENDOR_ID,
					VENDOR_NAME,
					VENDOR_NUMBER,
					VENDOR_TYPE_LOOKUP_CODE,
					NPWP,
					OPERATING_UNIT,
					VENDOR_SITE_ID,
					VENDOR_SITE_CODE,
					ADDRESS_LINE1,
					ADDRESS_LINE2,
					ADDRESS_LINE3,
					CITY,
					PROVINCE,
					COUNTRY,
					ZIP,
					AREA_CODE,
					PHONE,
					ORGANIZATION_ID
				  ) values (
 				    SIMTAX_MASTER_SUPPLIER_S.NEXTVAL, 
					'".$vendor_name."', 
					'".$vendor_number."', 
					NULL, 
					'".$npwp."', 
					'".$operating_unit."', 
					0, 
					'-', 
					'".$alamat_vendor_satu."', 
					'".$alamat_vendor_dua."', 
					'".$alamat_vendor_tiga."', 
					'".$kota."', 
					'".$propinsi."', 
					'".$negara."', 
					'".$kode_pos."', 
					NULL, 
					'".$telp."', 
					'".$og_id."' 
				  )"
                     ;
        } else {
            $wheresiteid = "";
            $whereorgid = "";
            if($vendor_site_id != ""){
                $wheresiteid = " and VENDOR_SITE_ID = '".$vendor_site_id."' ";
            } else {
                $wheresiteid = " and VENDOR_SITE_ID IS NULL";
            }
            $sql	="Update SIMTAX_MASTER_SUPPLIER
						 set VENDOR_NAME='".$vendor_name."', 
						     VENDOR_NUMBER='".$vendor_number."',
							 NPWP='".$npwp."', 
							 ADDRESS_LINE1='".$alamat_vendor_satu."', 
							 ADDRESS_LINE2='".$alamat_vendor_dua."', 
							 ADDRESS_LINE3='".$alamat_vendor_tiga."',
							 CITY='".$kota."',
							 PROVINCE='".$propinsi."',
							 COUNTRY='".$negara."',
							 ZIP='".$kode_pos."',
							 PHONE='".$telp."'
					     where VENDOR_ID ='".$vendor_id."'"
						 .$wheresiteid.
						 " and ORGANIZATION_ID = '".$organization_id."' "
                         ;
        }
              
        $query	= $this->db->query($sql);
        
        if ($query) {
            if ($isNewRecord == "1") {
                simtax_update_history("SIMTAX_MASTER_SUPPLIER", "CREATE", "VENDOR_ID");
            } else {
                $params = array(
                                    "VENDOR_ID"       => $vendor_id,
                                    "VENDOR_SITE_ID"  => $vendor_site_id,
                                    "ORGANIZATION_ID" => $organization_id
                                );
                simtax_update_history("SIMTAX_MASTER_SUPPLIER", "UPDATE", $params);
            }

            return true;
        } else {
            return false;
        }
    }
        
    public function action_delete()
    {
        $vendor_id			= $this->input->post('id');
        $vendor_site_id		= $this->input->post('site_id');
        $organization_id	= $this->input->post('org_id');
        
        $sql	="delete from SIMTAX_MASTER_SUPPLIER 
		                where VENDOR_ID ='".$vendor_id."'
						  and VENDOR_SITE_ID ='".$vendor_site_id."'
						  and ORGANIZATION_ID ='".$organization_id."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    /*TAMBAH*/
    public function action_tambah()
    {
        $vendor_name				= $this->input->post('vendor_name');
        $vendor_number				= $this->input->post('vendor_name');
        $vendor_type_lookup_code	= $this->input->post('vendor_type_lookup_code');
        $npwp						= $this->input->post('npwp');
        $operating_unit				= $this->input->post('operating_unit');
        $vendor_site_id				= $this->input->post('vendor_site_id');
        $vendor_site_code			= $this->input->post('vendor_site_code');
        $address_line1				= $this->input->post('address_line1');
        $address_line2				= $this->input->post('address_line2');
        $address_line3				= $this->input->post('address_line3');
        $city						= $this->input->post('city');
        $province					= $this->input->post('province');
        $country					= $this->input->post('country');
        $zip						= $this->input->post('zip');
        $area_code					= $this->input->post('area_code');
        $phone						= $this->input->post('phone');
        $organization_id			= $this->input->post('organization_id');
        $vendor_id					= $this->input->post('vendor_id');
        
        $sql	= "insert into SIMTAX_MASTER_SUPPLIER   ( vendor_id,
														vendor_name,
														vendor_number,
														vendor_type_lookup_code,
														npwp,
														operating_unit,
														vendor_site_id,
														vendor_site_code,
														address_line1,
														address_line2,
														address_line3,
														city,
														province,
														country,
														zip,
														area_code,
														phone,
														organization_id
														)
												values ('".$vendor_id."','".$vendor_name."','".$vendor_number."','".$vendor_type_lookup_code."',
														'".$npwp."','".$operating_unit."','".$vendor_site_id."','".$vendor_site_code."',
														'".$address_line1."','".$address_line2."','".$address_line3."','".$city."',
														'".$province."','".$country."','".$zip."','".$area_code."','".$phone."','".$organization_id."')";
                                                          
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    
    /*===========================================================================Customer===================================================================*/

    public function get_customer()
    {
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        $whereStatusKswp = "";
        $filterStatusKswp = "";
        $og_id = null;
        if (isset($_POST['_searchCabang']) && $_POST['_searchCabang'] != "") {
            $kode_cabang = $_POST['_searchCabang'];
            $og_id       = $this->cabang_mdl->get_og_id($kode_cabang);
        }else {
            $og_id = $this->cabang_mdl->get_og_id($this->kode_cabang);
        }
        if (isset($_POST['_searchStatusKswp']) && $_POST['_searchStatusKswp'] != "") {
            $filterStatusKswp = $_POST['_searchStatusKswp'];
        }
        
        if ($q) { //check lgsg where atau and
            $where	= " where (upper(SMP.customer_id) like '%".strtoupper($q)."%' or upper(SMP.customer_name) like '%".strtoupper($q)."%' or  (SMP.npwp) like '%".strtoupper($q)."%')";
            if ($og_id) {
                $where .= "and SMP.organization_id = '".$og_id."'";
            }
        } else {
            if ($og_id) {
                $where = " where SMP.organization_id = '".$og_id."'";
            }
        }
        if($where){
            if ($filterStatusKswp !='SEMUA'){
                $whereStatusKswp = "";
                $whereStatusKswp = " and smn.status_kswp = '".$filterStatusKswp."'";
            }
        } else  {
            if($filterStatusKswp != 'SEMUA'){
                $whereStatusKswp = " where smn.status_kswp = '".$filterStatusKswp."'";
            }            
        }
        $queryExec = "SELECT SMP.CUSTOMER_ID,  
									   SMP.CUSTOMER_NAME , 
									   SMP.ALIAS_CUSTOMER, 
									   SMP.CUSTOMER_NUMBER,
									   SMP.NPWP,
									   SMP.OPERATING_UNIT ,
									   SMP.CUSTOMER_SITE_ID,
									   SMP.CUSTOMER_SITE_NUMBER ,
									   SMP.CUSTOMER_SITE_NAME, 
									   SMP.ADDRESS_LINE1,
									   SMP.ADDRESS_LINE2,
									   SMP.ADDRESS_LINE3,
									   SMP.CITY,
									   SMP.PROVINCE,
									   SMP.COUNTRY,
									   SMP.ZIP,
                                       SMN.STATUS_KSWP
								FROM   SIMTAX_MASTER_PELANGGAN SMP 
                                LEFT JOIN SIMTAX_MASTER_NPWP SMN ON SMN.NPWP_SIMTAX = SMP.NPWP "
                                .$where.$whereStatusKswp;

        $queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_MASTER_PELANGGAN SMP
                         LEFT JOIN SIMTAX_MASTER_NPWP SMN ON SMN.NPWP_SIMTAX = SMP.NPWP
                         ".$where.$whereStatusKswp;
                              
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
       
        $sql2		= $queryExec;
        $query2 	= $this->db->query($sql2);

        //start row count
        $selectCount	= $this->db->query($queryCount);
        $row        	= $selectCount->row();
        $rowCount  	= $row->JML;
        //end get row count
        
        //$rowCount	= $query2->num_rows() ;
        //print_r($sql); exit();
        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $djp_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP_SIMTAX', $row['NPWP'])->get()->row();
                $status_kswp = ($djp_npwp->STATUS_KSWP) ? $djp_npwp->STATUS_KSWP : '-';
                $ii++;
                $result['data'][] = array(
                            'no'					=> $row['RNUM'],
                            'customer_id' 			=> $row['CUSTOMER_ID'],
                            'customer_name'  		=> $row['CUSTOMER_NAME'],
                            'alias_customer'		=> $row['ALIAS_CUSTOMER'],
                            'customer_number'		=> $row['CUSTOMER_NUMBER'],
                            'npwp'					=> $row['NPWP'],
                            'status_kswp'			=> $status_kswp,
                            'operating_unit'		=> $row['OPERATING_UNIT'],
                            'customer_site_id'		=> $row['CUSTOMER_SITE_ID'],
                            'customer_site_number'	=> $row['CUSTOMER_SITE_NUMBER'],
                            'customer_site_name'	=> $row['CUSTOMER_SITE_NAME'],
                            'address_line1'			=> $row['ADDRESS_LINE1'],
                            'address_line2'			=> $row['ADDRESS_LINE2'],
                            'address_line3'			=> $row['ADDRESS_LINE3'],
                            'city'					=> $row['CITY'],
                            'province'				=> $row['PROVINCE'],
                            'country'				=> $row['COUNTRY'],
                            'zip'					=> $row['ZIP'],
                            'djp' => $djp_npwp,
                        );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }
    
    
    public function action_save_cs()
    {
        $customer_id	 = $this->input->post('customer_id');
        $customer_name	 = $this->input->post('customer_name');
        $customer_number = $this->input->post('customer_number');
        $npwp			 = $this->input->post('npwp');
        
        $sql	= "Update SIMTAX_MASTER_PELANGGAN 
		              set CUSTOMER_NAME='".$customer_name."',
						  NPWP='".$npwp."'
  				    where CUSTOMER_ID ='".$customer_id."' ";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
        
    public function action_delete_cs()
    {
        $customer_id		= $this->input->post('customer_id');
        $customer_site_id	= $this->input->post('customer_site_id');
        
        $sql	="delete from SIMTAX_MASTER_PELANGGAN 
		                where CUSTOMER_ID ='".$customer_id."'
						  and CUSTOMER_SITE_ID = '".$customer_site_id."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    /*TAMBAH*/
    public function action_tambah_cs()
    {
        $customer_id				= $this->input->post('customer_id');
        $customer_name				= $this->input->post('customer_name');
        $alias_customer				= $this->input->post('alias_customer');
        $customer_number			= $this->input->post('customer_number');
        $npwp						= $this->input->post('npwp');
        $operating_unit				= $this->input->post('operating_unit');
        $customer_site_id			= $this->input->post('customer_site_id');
        $customer_site_number		= $this->input->post('customer_site_number');
        $customer_site_name			= $this->input->post('customer_site_name');
        $address_line1				= $this->input->post('address_line1');
        $address_line2				= $this->input->post('address_line2');
        $address_line3				= $this->input->post('address_line3');
        $city						= $this->input->post('city');
        $province					= $this->input->post('province');
        $country					= $this->input->post('country');
        $zip						= $this->input->post('zip');

        //flag
        $isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit
        
        if ($isNewRecord==1) {
            $sql	= "insert into SIMTAX_MASTER_PELANGGAN  ( 
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
						zip)
				values (SIMTAX_MASTER_SUPPLIER_S.NEXTVAL,
						'".$customer_name."',
						'".$alias_customer."',
						'".$customer_number."',
						'".$npwp."',
						'".$operating_unit."',
						'0',
						'0',
						'".$customer_site_name."',
						'".$address_line1."',
						'".$address_line2."',
						'".$address_line3."',
						'".$city."',
						'".$province."',
						'".$country."',
						'".$zip."')";
        } else {
            $sql	= "Update SIMTAX_MASTER_PELANGGAN
						  set CUSTOMER_NAME		='".$customer_name."',
							  NPWP				='".$npwp."',
							  alias_customer	='".$alias_customer."',
							  customer_number	='".$customer_number."',
							  operating_unit	='".$operating_unit."',
							  customer_site_name='".$customer_site_name."',
							  address_line1		='".$address_line1."',
							  address_line2		='".$address_line2."',
							  address_line3		='".$address_line3."',
							  city				='".$city."',
							  province			='".$province."',
							  country 			= '".$country."',
							  zip 				= '".$zip."'						  
						where CUSTOMER_ID ='".$customer_id."'
						  and customer_site_id = '".$customer_site_id."'";
        }
        
        $query	= $this->db->query($sql);
        
        if ($query) {
            if ($isNewRecord == 1) {
                simtax_update_history("SIMTAX_MASTER_PELANGGAN", "CREATE", "CUSTOMER_ID");
            } else {
                $params = array(
                                    "CUSTOMER_ID"      => $customer_id,
                                    "CUSTOMER_SITE_ID" => $customer_site_id
                                );
                simtax_update_history("SIMTAX_MASTER_PELANGGAN", "UPDATE", $params);
            }

            return true;
        } else {
            return false;
        }
    }
    /*===========================================================================KARYAWAN===================================================================*/

    public function get_karyawan()
    {
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        if ($q) { //check lgsg where atau and
            $where	= " where (upper(person_id) like '%".strtoupper($q)."%' or upper(last_name) like '%".strtoupper($q)."%' or  (person_type) like '%".strtoupper($q)."%') ";
        }
        
        $queryExec = "SELECT PERSON_ID,  
									   LAST_NAME , 
									   FULL_NAME, 
									   EMPLOYEE_NUMBER,
									   NATIONAL_IDENTIFIER,
									   NPWP ,
									   TAX_TYPE,
									   TAX_MARITAL ,
									   KPP, 
									   DIREKSI,
									   TAX_NPWP_NAME,
									   PERSON_TYPE,
									   HOME_BASE,
									   ADDRESS_TYPE,
									   ADDRESS_LINE1,
									   ADDRESS_LINE2,
									   ADDRESS_LINE3,
									   CITY,
									   PROVINCE,
									   COUNTRY,
									   ZIP
								FROM   SIMTAX_MASTER_KARYAWAN ".$where;
        
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        $sql2		= $queryExec;
        $query2 	= $this->db->query($sql2);
        $rowCount	= $query2->num_rows() ;
        //print_r($sql); exit();
        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $ii++;
                $result['data'][] = array(
                            'no'					=> $row['RNUM'],
                            'person_id' 			=> $row['PERSON_ID'],
                            'last_name'  			=> $row['LAST_NAME'],
                            'full_name'				=> $row['FULL_NAME'],
                            'employee_number'		=> $row['EMPLOYEE_NUMBER'],
                            'national_identifier'	=> $row['NATIONAL_IDENTIFIER'],
                            'npwp'					=> $row['NPWP'],
                            'tax_type'				=> $row['TAX_TYPE'],
                            'tax_marital'			=> $row['TAX_MARITAL'],
                            'kpp'					=> $row['KPP'],
                            'direksi'				=> $row['DIREKSI'],
                            'tax_npwp_name'			=> $row['TAX_NPWP_NAME'],
                            'person_type'			=> $row['PERSON_TYPE'],
                            'home_base'				=> $row['HOME_BASE'],
                            'address_type'			=> $row['ADDRESS_TYPE'],
                            'address_line1'			=> $row['ADDRESS_LINE1'],
                            'address_line2'			=> $row['ADDRESS_LINE2'],
                            'address_line3'			=> $row['ADDRESS_LINE3'],
                            'city'					=> $row['CITY'],
                            'province'				=> $row['PROVINCE'],
                            'country'				=> $row['COUNTRY'],
                            'zip'					=> $row['ZIP']
                            
                        );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }
    
    
    public function action_save_kw()
    {
        $person_id		 = $this->input->post('person_id');
        $last_name		 = $this->input->post('last_name');
        $employee_number = $this->input->post('employee_number');
        $person_type	 = $this->input->post('person_type');
        
        $sql	= "Update SIMTAX_MASTER_KARYAWAN set LAST_NAME='".$last_name."',EMPLOYEE_NUMBER='".$employee_number."', PERSON_TYPE='".$person_type."'
						   where PERSON_ID ='".$person_id."' ";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
        
    public function action_delete_kw()
    {
        $person_id			= $this->input->post('id');
                
        $sql	="delete from SIMTAX_MASTER_KARYAWAN where PERSON_ID ='".$person_id."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    /*TAMBAH*/
    public function action_tambah_kw()
    {
        $person_id				= $this->input->post('person_id');
        $last_name				= $this->input->post('last_name');
        $full_name				= $this->input->post('full_name');
        $employee_number		= $this->input->post('employee_number');
        $national_identifier	= $this->input->post('national_identifier');
        $npwp					= $this->input->post('npwp');
        $tax_type				= $this->input->post('tax_type');
        $tax_marital			= $this->input->post('tax_marital');
        $kpp					= $this->input->post('kpp');
        $direksi				= $this->input->post('direksi');
        $tax_npwp_name			= $this->input->post('tax_npwp_name');
        $person_type			= $this->input->post('person_type');
        $home_base				= $this->input->post('home_base');
        $address_type			= $this->input->post('address_type');
        $address_line1			= $this->input->post('address_line1');
        $address_line2			= $this->input->post('address_line2');
        $address_line3			= $this->input->post('address_line3');
        $city					= $this->input->post('city');
        $province				= $this->input->post('province');
        $country				= $this->input->post('country');
        $zip					= $this->input->post('zip');
                
        $sql	= "insert into SIMTAX_MASTER_KARYAWAN  ( person_id,
														last_name,
														full_name,
														employee_number,
														national_identifier,
														npwp,
														tax_type,
														tax_marital,
														kpp,
														direksi,
														tax_npwp_name,
														person_type,
														home_base,
														address_type,
														address_line1,
														address_line2,
														address_line3,
														city,
														province,
														country,
														zip )
												values ('".$person_id."','".$last_name."','".$full_name."','".$employee_number."',
														'".$national_identifier."','".$npwp."','".$tax_type."','".$tax_marital."',
														'".$kpp."','".$direksi."','".$tax_npwp_name."','".$person_type."',
														'".$home_base."','".$address_type."','".$address_line1."','".$address_line2."',
														'".$address_line3."','".$city."','".$province."','".$country."','".$zip."')";
                                                          
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    /*==================================================================TAX=======================================================================*/

    public function get_tax()
    {
        $cabang	= $this->kode_cabang;
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        if ($q) {
            $where	= " WHERE (upper(operating_unit) like '%".strtoupper($q)."%' or upper(tax_code) like '%".strtoupper($q)."%' or  (tax_rate) like '%".strtoupper($q)."%') ";
        }
        $queryExec = "SELECT OPERATING_UNIT,  
									   TAX_CODE, 
									   DESCRIPTION, 
									   TAX_RATE,
									   ENABLED,
									   VENDOR_NAME ,
									   VENDOR_NUMBER,
									   VENDOR_SITE_CODE ,
									   KODE_PAJAK, 
									   JENIS_4_AYAT_2,
									   KODE_PAJAK_SPPD,
									   JENIS_23,
									   AKUN_PAJAK,
									   GL_ACCOUNT,
									   COMPANY,
									   BRANCH,
									   ACCOUNT,
									   KODE_CABANG
								FROM   SIMTAX_MASTER_PPH ".$where." ";
        $sql2		= $queryExec;
        $query2 	= $this->db->query($sql2);
        $rowCount	= $query2->num_rows() ;
        
        $queryExec .=" order by KODE_CABANG,TAX_CODE";
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $ii++;
                $result['data'][] = array(
                            'no'				=> $row['RNUM'],
                            'operating_unit'	=> $row['OPERATING_UNIT'],
                            'tax_code'			=> $row['TAX_CODE'],
                            'description'		=> $row['DESCRIPTION'],
                            'tax_rate'			=> $row['TAX_RATE'],
                            'enabled'			=> $row['ENABLED'],
                            'vendor_name'		=> $row['VENDOR_NAME'],
                            'vendor_number'		=> $row['VENDOR_NUMBER'],
                            'vendor_site_code'	=> $row['VENDOR_SITE_CODE'],
                            'kode_pajak'		=> $row['KODE_PAJAK'],
                            'jenis_4_ayat_2'	=> $row['JENIS_4_AYAT_2'],
                            'kode_pajak_sppd'	=> $row['KODE_PAJAK_SPPD'],
                            'jenis_23'			=> $row['JENIS_23'],
                            'akun_pajak'		=> $row['AKUN_PAJAK'],
                            'gl_account'		=> $row['GL_ACCOUNT'],
                            'company'			=> $row['COMPANY'],
                            'branch'			=> $row['BRANCH'],
                            'account'			=> $row['ACCOUNT'],
                            'kode_cabang'		=> $row['KODE_CABANG']
                          );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }
        
    public function action_save_tx()
    {
        $tax_code		= $this->input->post('tax_code');
        $operating_unit	= $this->input->post('operating_unit');
        $tax_rate		= $this->input->post('tax_rate');
        $vendor_number	= $this->input->post('vendor_number');
        
        $sql 	="update SIMTAX_MASTER_PPH set OPERATING_UNIT='".$operating_unit."', TAX_RATE='".$tax_rate."', VENDOR_NUMBER='".$vendor_number."'
					where TAX_CODE ='".$tax_code."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
        
    public function action_delete_tx()
    {
        $tax_code	= $this->input->post('id');
        $kd_cabang	= $this->input->post('cabang');
        
        $sql	="delete from SIMTAX_MASTER_PPH where TAX_CODE='".$tax_code."' and kode_cabang='".$kd_cabang."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
                                                            
    public function action_tambah_tx()
    {
        $isNewRecord		= $this->input->post('isNewRecord');
        $tax_code_h			= $this->input->post('tax_code_h');
        $operating_unit		= $this->input->post('operating_unit');
        $tax_code			= $this->input->post('tax_code');
        $description		= $this->input->post('description');
        $tax_rate			= $this->input->post('tax_rate');
        $enabled			= $this->input->post('enabled');
        $vendor_name		= $this->input->post('vendor_name');
        $vendor_number		= $this->input->post('vendor_number');
        $vendor_site_code	= $this->input->post('vendor_site_code');
        $kode_pajak			= $this->input->post('kode_pajak');
        $jenis_4_ayat_2		= $this->input->post('jenis_4_ayat_2');
        $kode_pajak_sppd	= $this->input->post('kode_pajak_sppd');
        $jenis_23			= $this->input->post('jenis_23');
        $akun_pajak			= $this->input->post('akun_pajak');
        $gl_account			= $this->input->post('gl_account');
        $company			= $this->input->post('company');
        $branch				= $this->input->post('branch');
        $account			= $this->input->post('account');
        $cabang				= $this->input->post('kode_cabang');
        $kd_cabang			= ($cabang)? $cabang:$this->kode_cabang;
        
        if ($isNewRecord) {
            $sql	= "insert into SIMTAX_MASTER_PPH  (operating_unit,
										tax_code,
										description,
										tax_rate,
										enabled,
										vendor_name,
										vendor_number,
										vendor_site_code,
										kode_pajak,
										jenis_4_ayat_2,
										kode_pajak_sppd,
										jenis_23,
										akun_pajak,
										gl_account,
										company,
										branch,
										account,
										kode_cabang)
								values ('".$operating_unit."','".$tax_code."','".$description."','".$tax_rate."',
										'".$enabled."','".$vendor_name."','".$vendor_number."','".$vendor_site_code."',
										'".$kode_pajak."','".$jenis_4_ayat_2."','".$kode_pajak_sppd."','".$jenis_23."',
										'".$akun_pajak."','".$gl_account."','".$company."','".$branch."','".$account."','".$kd_cabang."')";
        } else {
            $sql	= "Update SIMTAX_MASTER_PPH set operating_unit='".$operating_unit."',
										tax_code ='".$tax_code."',
										description ='".$description."',
										tax_rate ='".$tax_rate."',
										enabled ='".$enabled."',
										vendor_name ='".$vendor_name."',
										vendor_number ='".$vendor_number."',
										vendor_site_code ='".$vendor_site_code."',
										kode_pajak ='".$kode_pajak."',
										jenis_4_ayat_2 ='".$jenis_4_ayat_2."',
										kode_pajak_sppd ='".$kode_pajak_sppd."',
										jenis_23 ='".$jenis_23."',
										akun_pajak ='".$akun_pajak."',
										gl_account ='".$gl_account."',
										company ='".$company."',
										branch ='".$branch."',
										account ='".$account."' 
						where tax_code ='".$tax_code_h."' and kode_cabang='".$kd_cabang."'";
        }
        $query	= $this->db->query($sql);
        if ($query) {

            /*if ($isNewRecord == 1){
                simtax_update_history("SIMTAX_MASTER_PPH", "CREATE", "CUSTOMER_ID");
            }
            else{
                $params = array(
                                    "CUSTOMER_ID"      => $customer_id,
                                    "CUSTOMER_SITE_ID" => $customer_site_id
                                );
                simtax_update_history("SIMTAX_MASTER_PPH", "UPDATE", $params);
            }*/
            return true;
        } else {
            return false;
        }
    }
    
    /*=======================================================PERIOD==============================================================*/
    
    public function get_period()
    {
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        $where	= "";
        if ($q) { //check lgsg where atau and
            $where	= " where (upper(period_id) like '%".strtoupper($q)."%' or upper(nama_pajak) like '%".strtoupper($q)."%' or  (bulan_pajak) like '%".strtoupper($q)."%') ";
        }
        $queryExec = "SELECT PERIOD_ID,
										NAMA_PAJAK,  
									   MASA_PAJAK, 
									   BULAN_PAJAK, 
									   TAHUN_PAJAK,
									   STATUS,
									   KODE_CABANG
									FROM SIMTAX_MASTER_PERIOD ".$where;
        
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        $sql2		= $queryExec;
        $query2 	= $this->db->query($sql2);
        $rowCount	= $query2->num_rows() ;
        //print_r($sql); exit();
        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $ii++;
                $result['data'][] = array(
                            'no'				=> $row['RNUM'],
                            'period_id'			=> $row['PERIOD_ID'],
                            'nama_pajak'		=> $row['NAMA_PAJAK'],
                            'masa_pajak'		=> $row['MASA_PAJAK'],
                            'bulan_pajak'		=> $row['BULAN_PAJAK'],
                            'tahun_pajak'		=> $row['TAHUN_PAJAK'],
                            'status'			=> $row['STATUS'],
                            'kode_cabang'		=> $row['KODE_CABANG']
                                       
                            );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }
        
    public function action_save_pr()
    {
        $period_id		= $this->input->post('period_id');
        $nama_pajak		= $this->input->post('nama_pajak');
        $masa_pajak		= $this->input->post('masa_pajak');
        $bulan_pajak	= $this->input->post('bulan_pajak');
        $tahun_pajak	= $this->input->post('tahun_pajak');
        
        $sql ="update SIMTAX_MASTER_PERIOD set NAMA_PAJAK='".$nama_pajak."', MASA_PAJAK='".$masa_pajak."', BULAN_PAJAK='".$bulan_pajak."',
							TAHUN_PAJAK='".$tahun_pajak."'
					where PERIOD_ID ='".$period_id."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
        
    public function action_delete_pr()
    {
        $period_id	= $this->input->post('id');
        
        $sql	="delete from SIMTAX_MASTER_PERIOD where period_id='".$period_id."'";
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
                                                            
    public function action_tambah_pr()
    {
        $period_id		= $this->input->post('period_id');
        $nama_pajak		= $this->input->post('nama_pajak');
        $masa_pajak		= $this->input->post('masa_pajak');
        $bulan_pajak	= $this->input->post('bulan_pajak');
        $tahun_pajak	= $this->input->post('tahun_pajak');
        $status			= $this->input->post('status');
        $kode_cabang	= $this->input->post('kode_cabang');
                   
        
        $sql	= "insert into SIMTAX_MASTER_PERIOD  (	period_id,
														nama_pajak,
														masa_pajak,
														bulan_pajak,
														tahun_pajak,
														status,
														kode_cabang
														)
												values ('".$period_id."','".$nama_pajak."','".$masa_pajak."','".$bulan_pajak."',
														'".$tahun_pajak."','".$status."','".$kode_cabang."')";
                                                          
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_master_tax()
    {
        $queryExec	        = "Select * from simtax_master_jns_pajak where 1=1 and upper(aktif)='Y' order by kelompok_pajak";
        $query 		        = $this->db->query($queryExec);
        $result['query']	= $query;
        return $result;
    }
    
    public function get_operator_unit()
    {
        $cabang	= $this->kode_cabang;
        if ($cabang!='000') {
            $where =" and kode_cabang='".$cabang."' ";
        } else {
            $where ="";
        }
        $queryExec	        = "Select * from simtax_kode_cabang where 1=1 and upper(aktif)='Y' ".$where." order by kode_cabang";
        $query 		        = $this->db->query($queryExec);
        $result['query']	= $query;
        return $result;
    }

    public function get_rpt()
    {
        $where ="";
        $q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';
        if ($q) {
            $where	= " and  tahun like '%$q%' ";
        }
        
        if (isset($_POST['_searchAktiv']) && $_POST['_searchAktiv'] != "") {
            $aktif = $_POST['_searchAktiv'];
            $where .= " and aktif = '".$aktif."'";
        }
        
        $queryExec = "SELECT						
						   RPT_ID,  
						   RATE , 
						   TAHUN, 
						   AKTIF     
					FROM   SIMTAX_MASTER_RPT
					WHERE 1=1 ".$where;
        $queryCount = "SELECT count(1) JML      
						 FROM SIMTAX_MASTER_RPT where 1=1 ".$where;
        
        $sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
        
        //start row count
        $selectCount	= $this->db->query($queryCount);
        $row        	= $selectCount->row();
        $rowCount  	= $row->JML;
        //end get row count
                    
        $query = $this->db->query($sql);
        if ($rowCount>0) {
            $ii	=	0;
            foreach ($query->result_array() as $row) {
                $ii++;
                if ($row['AKTIF'] == 1) {
                    $vaktif = "Aktif";
                } else {
                    $vaktif = "Tidak Aktif";
                }
                $result['data'][] = array(
                            'no'		=> $row['RNUM'],
                            'rpt_id'	=> $row['RPT_ID'],
                            'rate'		=> $row['RATE'],
                            'tahun'		=> $row['TAHUN'],
                            'aktif'		=> $vaktif
                          );
            }
            
            $query->free_result();
            
            $result['draw']				= $_POST['draw']=($_POST['draw'])?$_POST['draw']:0;
            $result['recordsTotal']		= $rowCount;
            $result['recordsFiltered'] 	= $rowCount;
        } else {
            $result['data'] 			= "";
            $result['draw']				= "";
            $result['recordsTotal']		= 0;
            $result['recordsFiltered'] 	= 0;
        }
        return $result;
    }

    public function check_duplic_tahun_rpt($aktif, $tahun)
    {
        $sql = "SELECT count(*) TOTAL from simtax_master_rpt
						where aktif is not null
						and tahun = ".$tahun."
						and aktif = '".$aktif."'";
        $query	= $this->db->query($sql);
        $total	= $query->row()->TOTAL;

        return $total;
    }
    

    public function action_save_rpt()
    {
        $rpt_id			= $this->input->post('edit_rpt_id');
        $rate			= $this->input->post('edit_rate');
        $tahun			= $this->input->post('edit_tahun');
        $aktif			= $this->input->post('edit_aktif');

        if ($aktif) {
            $aktif = "1";
        } else {
            $aktif = "0";
        }

        //flag
        $isNewRecord		= $this->input->post('isNewRecord'); // 1 tambah, 0 edit

        if ($isNewRecord=="1") {
            $sql	="insert into SIMTAX_MASTER_RPT
				  ( RPT_ID,
					RATE,
					TAHUN,
					AKTIF
				  ) values (
 				    SIMTAX_MASTER_RPT_S.NEXTVAL, 
					'".$rate."', 
					'".$tahun."', 
					'".$aktif."'
				  )"
                     ;
        } else {
            $sql	="Update SIMTAX_MASTER_RPT
						 set RATE='".$rate."', 
						     TAHUN='".$tahun."',
							 AKTIF='".$aktif."'
					   where RPT_ID ='".$rpt_id."'"
                         ;
        }
        
        $query	= $this->db->query($sql);
        
        if ($query) {
            if ($isNewRecord == "1") {
                simtax_update_history("SIMTAX_MASTER_RPT", "CREATE", "RPT_ID");
            } else {
                $params = array(
                                    "RPT_ID"       => $rpt_id
                                );
                simtax_update_history("SIMTAX_MASTER_RPT", "UPDATE", $params);
            }

            return true;
        } else {
            return false;
        }
    }

    public function action_delete_rpt()
    {
        $rpt_id			= $this->input->post('id');
        
        $sql	="delete from SIMTAX_MASTER_RPT
		                where RPT_ID ='".$rpt_id."'";
                          
        $query	= $this->db->query($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_format_csv_supplier()
    {
        $q		= (isset($_REQUEST['search']['value']))?$_REQUEST['search']['value']:'';
        $where	= "";
        $vstatus_kswp = "";
        $where_status_kswp = "";
        if ($q) {
            $where	= " and (upper(vendor_id) like '%".strtoupper($q)."%' or upper(vendor_name) like '%".strtoupper($q)."%' or  (npwp) like '%".strtoupper($q)."%') ";
        }

        if (isset($_REQUEST['vcabang']) && $_REQUEST['vcabang'] != "") {
            $kode_cabang = $_REQUEST['vcabang'];
            $og_id       = $this->cabang_mdl->get_og_id($kode_cabang);
        } else {
            $og_id = $this->cabang_mdl->get_og_id($this->kode_cabang);
        }

        if (isset($_REQUEST['vstatus_kswp']) && $_REQUEST['vstatus_kswp'] != "SEMUA") {
            $vstatus_kswp = $_REQUEST['vstatus_kswp'];
        }
        if($where){
            $where_status_kswp = " and SIMTAX_MASTER_NPWP.STATUS_KSWP = '".$vstatus_kswp."' ";
        } else {
            if($vstatus_kswp){
                $where_status_kswp = " where SIMTAX_MASTER_NPWP.STATUS_KSWP = '".$vstatus_kswp."' ";
            }
        }

        $sql = "SELECT						
		SIMTAX_MASTER_SUPPLIER.VENDOR_ID,  
		SIMTAX_MASTER_SUPPLIER.VENDOR_NAME , 
		SIMTAX_MASTER_SUPPLIER.VENDOR_NUMBER, 
		SIMTAX_MASTER_SUPPLIER.VENDOR_TYPE_LOOKUP_CODE,
		SIMTAX_MASTER_SUPPLIER.NPWP,
        SIMTAX_MASTER_NPWP.STATUS_KSWP,
		SIMTAX_MASTER_SUPPLIER.OPERATING_UNIT ,
		SIMTAX_MASTER_SUPPLIER.VENDOR_SITE_ID,
		SIMTAX_MASTER_SUPPLIER.VENDOR_SITE_CODE ,
		SIMTAX_MASTER_SUPPLIER.ADDRESS_LINE1, 
		SIMTAX_MASTER_SUPPLIER.ADDRESS_LINE2,
		SIMTAX_MASTER_SUPPLIER.ADDRESS_LINE3,
		SIMTAX_MASTER_SUPPLIER.CITY,
		SIMTAX_MASTER_SUPPLIER.PROVINCE,
		SIMTAX_MASTER_SUPPLIER.COUNTRY,
		SIMTAX_MASTER_SUPPLIER.ZIP,
		SIMTAX_MASTER_SUPPLIER.AREA_CODE,
        SIMTAX_MASTER_SUPPLIER.PHONE,
		SIMTAX_MASTER_SUPPLIER.ORGANIZATION_ID      
		FROM   SIMTAX_MASTER_SUPPLIER 
        LEFT JOIN SIMTAX_MASTER_NPWP ON SIMTAX_MASTER_NPWP.NPWP_SIMTAX = SIMTAX_MASTER_SUPPLIER.NPWP 
		WHERE 1=1 ".$where.$where_status_kswp." and organization_id = '".$og_id."' order by 1 desc";
                
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_format_csv_customer()
    {
        ini_set('memory_limit', '-1');
        $q		= (isset($_REQUEST['search']['value']))?$_REQUEST['search']['value']:'';
        $where	= "";
        $where_og_id = "";
        $vstatus_kswp = "";
        $where_status_kswp = "";

        if ($q) { //check lgsg where atau and
            $where	= " where (upper(customer_id) like '%".strtoupper($q)."%' or upper(customer_name) like '%".strtoupper($q)."%' or  (npwp) like '%".strtoupper($q)."%') ";
        }

        if (isset($_REQUEST['vcabang']) && $_REQUEST['vcabang'] != "") {
            $kode_cabang = $_REQUEST['vcabang'];
            $og_id       = $this->cabang_mdl->get_og_id($kode_cabang);
        } else {
            $og_id = $this->cabang_mdl->get_og_id($this->kode_cabang);
        }

        if (isset($_REQUEST['vstatus_kswp']) && $_REQUEST['vstatus_kswp'] != "SEMUA") {
           $vstatus_kswp = $_REQUEST['vstatus_kswp'];
        }

        if($where){
            if($og_id){
                $where_og_id = " and organization_id = '".$og_id."' ";
            }
            if($vstatus_kswp){
                $where_status_kswp = " and SIMTAX_MASTER_NPWP.STATUS_KSWP = '".$vstatus_kswp."' ";
            }
        } else {
            $where_og_id = " where organization_id = '".$og_id."' ";
            if($vstatus_kswp){
                $where_status_kswp = " and SIMTAX_MASTER_NPWP.STATUS_KSWP = '".$vstatus_kswp."' ";
            }
        }
        
        
        $sql = "SELECT SIMTAX_MASTER_PELANGGAN.CUSTOMER_ID,  
							SIMTAX_MASTER_PELANGGAN.CUSTOMER_NAME , 
							SIMTAX_MASTER_PELANGGAN.ALIAS_CUSTOMER, 
							SIMTAX_MASTER_PELANGGAN.CUSTOMER_NUMBER,
							SIMTAX_MASTER_PELANGGAN.NPWP,
                            SIMTAX_MASTER_NPWP.STATUS_KSWP,
							SIMTAX_MASTER_PELANGGAN.OPERATING_UNIT ,
							SIMTAX_MASTER_PELANGGAN.CUSTOMER_SITE_ID,
							SIMTAX_MASTER_PELANGGAN.CUSTOMER_SITE_NUMBER ,
							SIMTAX_MASTER_PELANGGAN.CUSTOMER_SITE_NAME, 
							SIMTAX_MASTER_PELANGGAN.ADDRESS_LINE1,
							SIMTAX_MASTER_PELANGGAN.ADDRESS_LINE2,
							SIMTAX_MASTER_PELANGGAN.ADDRESS_LINE3,
							SIMTAX_MASTER_PELANGGAN.CITY,
							SIMTAX_MASTER_PELANGGAN.PROVINCE,
							SIMTAX_MASTER_PELANGGAN.COUNTRY,
							SIMTAX_MASTER_PELANGGAN.ZIP,
							SIMTAX_MASTER_PELANGGAN.ORGANIZATION_ID
					FROM   SIMTAX_MASTER_PELANGGAN
                    LEFT JOIN SIMTAX_MASTER_NPWP ON SIMTAX_MASTER_NPWP.NPWP_SIMTAX = SIMTAX_MASTER_PELANGGAN.NPWP 
                    ".$where.$where_og_id.$where_status_kswp." order by 1 desc";
               
        $query = $this->db->query($sql);
        return $query;
    }
}
