<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crontask extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('cabang_mdl');
		$this->load->model('crontask_mdl');
	}
	
	public function download_ref($var_ref) {

		if($this->input->is_cli_request())
        {
			if($var_ref != 'SUPPLIER'){
				$var_ref = "CUSTOMER";
			} else {
				$var_ref = "SUPPLIER";
			}

			$data	= $this->crontask_mdl->get_download_ref($var_ref);
			
			if($data){
				$this->db->set('STATUS', "'SUCCESS DOWNLOAD FROM EBS'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$var_ref);
				$this->db->update('SIMTAX_LAST_PROCESS');
			} else {
				$this->db->set('STATUS', "'ERROR DOWNLOAD DATA EBS'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$var_ref);
				$this->db->update('SIMTAX_LAST_PROCESS');
			}
		} else {
				$this->db->set('STATUS', "'You must login first'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$var_ref);
				$this->db->update('SIMTAX_LAST_PROCESS');
		}

	}
	
	public function process_ref($jenis_trx) {

		if($this->input->is_cli_request())
        {
		} else {
			$this->db->set('STATUS', "'You must login first'", FALSE);
			$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$jenis_trx);
			$this->db->update('SIMTAX_LAST_PROCESS');
			return false;
		}

		$scheduler = $this->db->from('SIMTAX_LAST_PROCESS')->where('TRANSACTION_MODUL', 'SCHEDULER_'.$jenis_trx)->get()->row();
		
		if(!empty($scheduler)){
			$paramdate = $scheduler->DATE_PROCESS;
			$date_ref   = date("Y-m-d",strtotime($paramdate));
			$tanggal = date("d",strtotime($date_ref));
			$tanggal = ltrim($tanggal, "0"); 
			$bulan = date("m",strtotime($date_ref));
			$bulan = ltrim($bulan, "0"); 
			$tahun = date("Y",strtotime($date_ref));
		} else {
			$error = $this->db->error();
			$this->db->set('STATUS', $error, FALSE);
			$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$ref);
			$this->db->update('SIMTAX_LAST_PROCESS');
			return false;
		}

		$dt = new DateTime($date_ref);
		$dt->modify('+1 month');
		$update_date = $dt->format('Y-m-d');
		
		$sql	=" select CONCURRENT_REQUEST_ID 
				     from simtax_getdata_history
				    where IMPORT_TO_SIMTAX_FLAG = 'N'
					  and parameter1 = '".$bulan."'
				      and parameter2 = '".$tahun."'
				      and parameter5 = '".$jenis_trx."'
					  ";
		
		$qReqID     = $this->db->query($sql);
		$row        = $qReqID->row();       	
		$ConcReqId  = $row->CONCURRENT_REQUEST_ID; 					  
		
		$file_path  =  "./download/ebs/unprocess/o".$ConcReqId.".csv";
		$moved_path =  "./download/ebs/process/o".$ConcReqId.".csv";
		
		if (file_exists($file_path)) {
			$data	= $this->crontask_mdl->do_process_ref($file_path,$jenis_trx);
			if($data){
				$sql	="update simtax_getdata_history
							 set IMPORT_TO_SIMTAX_FLAG = 'Y', LAST_UPDATE_DATE = sysdate, LAST_UPDATE_BY = 'cron'
						   where CONCURRENT_REQUEST_ID = '".$ConcReqId."'
						  ";
				$this->db->query($sql);		
					
				rename($file_path, $moved_path);

				$this->db->set('STATUS', "'SUCCESS PROCESS DATA EBS'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$jenis_trx);
				$this->db->update('SIMTAX_LAST_PROCESS');

				$this->crontask_mdl->update_last_process('SCHEDULER_'.$jenis_trx,$update_date);

			} else {
				$this->db->set('STATUS', "'FAILED PROCESS DATA EBS'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$jenis_trx);
				$this->db->update('SIMTAX_LAST_PROCESS');
			}			
		} else {
				$this->db->set('STATUS', "'FILE NOT FOUND'", FALSE);
				$this->db->where('TRANSACTION_MODUL', 'SCHEDULER_'.$jenis_trx);
				$this->db->update('SIMTAX_LAST_PROCESS');
		}
	}	

}