<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Pph_mdl extends CI_Model {
	
		
    public function __construct()
    {
        parent::__construct();
        $this->kode_cabang = $this->session->userdata('kd_cabang');
    }
	
	public function tgl_db($date)
	{
		$part = explode("-",$date);
		$newDate = $part[2]."-".$part[1]."-".$part[0];
		return $newDate;
	}
	
	public function get_header_id($pajak="",$bulan="",$tahun="", $pembetulan="", $kode_cabang = ""){
		if($kode_cabang != ""){
			$cabang =  $kode_cabang;
		}
		else{
			$cabang =  $this->kode_cabang;
		}

		$where_p = " and pembetulan_ke=".$pembetulan;
		$sql3 	= "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='".strtoupper($pajak)."'".$where_p ; 
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3 && $header){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}
	
	public function get_header_id_max($pajak,$bulan,$tahun,$cabang){
		$sql3 	= "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$bulan." and tahun_pajak='".$tahun."' and upper(nama_pajak)='".strtoupper($pajak)."' " ; 
		
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}
	
	public function getMonth($bul)
	{
		$shortMonthArr 	= array("", "JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES");
		$date			= $shortMonthArr[$bul];
		return $date;
	}
	
	function get_wp()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) { //check lgsg where atau and
			$where	= " and (upper(mst_supp.vendor_name) like '%".strtoupper($q)."%' or upper(mst_supp.address_line1) like '%".strtoupper($q)."%' or  mst_supp.NPWP like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "select  spl.vendor_id
									, spl.nama_wp
									, spl.alamat_wp
									, spl.npwp
									, spl.organization_id 
									, mst_supp.vendor_name new_nama_wp
									, mst_supp.address_line1 new_alamat_wp
									, mst_supp.NPWP new_npwp
								from simtax_pajak_lines spl
								   , (select vendor_id, vendor_name, address_line1, npwp, organization_id 
										from simtax_master_supplier
									group by vendor_id, vendor_name, address_line1, npwp, organization_id) mst_supp
							   where spl.vendor_id = mst_supp.vendor_id
								 and spl.organization_id = mst_supp.organization_id     
							--     and spl.nama_wp != mst_supp.vendor_name
							--     and spl.alamat_wp != mst_supp.address_line1
							--     and spl.npwp != mst_supp.NPWP
								   ".$where."
							group by spl.vendor_id, spl.nama_wp, spl.alamat_wp, spl.npwp, spl.organization_id
									, mst_supp.vendor_name
									, mst_supp.address_line1
									, mst_supp.NPWP";
		
		
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
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}
	
	
	function action_save()
	{
		$id		= $this->input->post('idwp');
		$namawp	= $this->input->post('namawp');
		$npwp	= $this->input->post('npwp');
		$alamat	= $this->input->post('alamat');
		
		$sql	="Update SIMTAX_MASTER_SUPPLIER set VENDOR_NAME='".$namawp."', NPWP='".$npwp."', ADDRESS_LINE1='".$alamat."'
					where VENDOR_ID ='".$id."'";
		$query	= $this->db->query($sql);
		if ($query){
			return true;
		} else {
			return false;
		}
		
	}
	
	function get_approv()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";		
		$where	.= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";	
		
		if($q) {
			$where	.= " and (upper(a.no_faktur_pajak) like '%".strtoupper($q)."%' or upper(a.invoice_num) like '%".strtoupper($q)."%' or upper(c.vendor_name) like '%".strtoupper($q)."%') ";
		}
						
		$queryExec	= "Select DISTINCT a.*
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' and (upper(b.status) in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.STATUS) ='OPEN'
						".$where."
					order by a.invoice_num, a.invoice_line_num DESC";	
					
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}

	
	function action_save_approv_a()
	{
		$cabang	    =  $this->kode_cabang;
		$user	    = $this->session->userdata('identity');
		$pasal	    = $this->input->post('pasal');
		$masa	    = $this->input->post('masa');
		$tahun	    = $this->input->post('tahun');
		$pembetulan	= $this->input->post('pembetulan');
		$st		    = $this->input->post('st');
		$ket	    = $this->input->post('ket'); 		
		$date	    = date("Y-m-d H:i:s");
		$header	= $this->get_header_id($pasal,$masa,$tahun, $pembetulan);
		
		if($st==1){
			$status	="APPROVAL SUPERVISOR";			
		} else {
			$status	="REJECT SUPERVISOR";		
		}		
       	
		if ($header){
			$sql	="UPDATE SIMTAX_PAJAK_HEADERS set TGL_APPROVE_SUP=sysdate, 
					  status='".$status."'
					  where PAJAK_HEADER_ID='".$header."' and KODE_CABANG='".$cabang."'";		
			$query	= $this->db->query($sql);
			$param = array("PAJAK_HEADER_ID" => $header);
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);
			
			$sql2	="INSERT into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME, CATATAN) 
					 values (".$header.",'".$pasal."',sysdate,'".$status."','".$user."','".$ket."')";
			$query2	= $this->db->query($sql2);


			if ($query && $query2){
				if($st==1){ //khusus PPH
					$sql3	="
					DECLARE
						l_OutMessage varchar2(250);
					begin
						simtax_pajak_utility_pkg.genNoBuktiPotong(pBulan => '".$masa."'
											 ,pTahun => '".$tahun."'
											 ,pNamaPajak => '".strtoupper($pasal)."'
											 ,pKodeCabang => '".$cabang."'
											 ,pOutCode => l_OutMessage);
						dbms_output.put_line(l_OutMessage);
					end;";
					
					$query3	= $this->db->query($sql3);
					if ($query3){
						return true;
					} else {						
						return false;
					}
				} else {
					return true;
				}
				
			} else {
				return false;
			}		
		} else {
			return false;
		}		
	}
	
	function action_save_approv()
	{
		$cabang	    =  $this->kode_cabang;
		$user	    = $this->session->userdata('identity');
		$pasal	    = $this->input->post('pasal');
		$masa	    = $this->input->post('masa');
		$tahun	    = $this->input->post('tahun');
		$pembetulan	= $this->input->post('pembetulan');
		$st		    = $this->input->post('st');
		$ket	    = $this->input->post('ket'); 		
		$date	    = date("Y-m-d H:i:s");
		$header	= $this->get_header_id($pasal,$masa,$tahun, $pembetulan);
		
		if($st==1){
			$status	="APPROVAL SUPERVISOR";			
		} else {
			$status	="REJECT SUPERVISOR";		
		}		
       	
		if ($header){
			$sql	="Update SIMTAX_PAJAK_HEADERS set TGL_APPROVE_SUP=sysdate, 
					  status='".$status."', USER_NAME = '".$user."'
					  where PAJAK_HEADER_ID='".$header."' and KODE_CABANG='".$cabang."'";		
			$query	= $this->db->query($sql);
			$param = array("PAJAK_HEADER_ID" => $header);
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);
			
			$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME, CATATAN) 
					 values (".$header.",'".$pasal."',sysdate,'".$status."','".$user."','".$ket."')";
			$query2	= $this->db->query($sql2);	
			
			$sql4	=" Update SIMTAX_MASTER_COUNTER set counter=1
						  where upper(nama_counter)='BUKTI POTONG' and KODE_CABANG='".$cabang."' and bulan='".$masa."'
						  and tahun='".$tahun."' and upper(nama_pajak)='".strtoupper($pasal)."' ";
						$query4	= $this->db->query($sql4);
						
			if ($query && $query2 ){
				if($st==1){ //khusus PPH
					$sql3	="
					DECLARE
						l_OutMessage varchar2(250);
					begin
						simtax_pajak_utility_pkg.genNoBuktiPotong(pBulan => '".$masa."'
											 ,pTahun => '".$tahun."'
											 ,pNamaPajak => '".strtoupper($pasal)."'
											 ,pKodeCabang => '".$cabang."'
											 ,pOutCode => l_OutMessage);
						dbms_output.put_line(l_OutMessage);
					end;";
					
					$query3	= $this->db->query($sql3);
					if ($query3){
						return true;
					} else {						
						return false;
					}
				} else {					
					$sql3	="
						  Update SIMTAX_PAJAK_LINES set NO_BUKTI_POTONG='', TGL_BUKTI_POTONG=''
						  where PAJAK_HEADER_ID='".$header."' and KODE_CABANG='".$cabang."'";					
						$query3	= $this->db->query($sql3);
						if ($query3){							
							return true;						
						} else {						
							return false;
						}
				}
				
			} else {
				return false;
			}		
		} else {
			return false;
		}		
	}
	
			
	function action_get_start()
	{
		$cabang		=  $this->kode_cabang;
		$pasal	    = $this->input->post('pasal');
		$masa	    = $this->input->post('masa');
		$tahun	    = $this->input->post('tahun');
		$pembetulan	= $this->input->post('pembetulan');		
		$st		    = $this->input->post('st');
		$ket	    = $this->input->post('ket'); 

		$sql3 = "Select a.pajak_header_id, a.status,  b.status status_period from simtax_pajak_headers a
				 inner join simtax_master_period b 
				 on a.period_id=b.period_id
				 inner join simtax_pajak_lines c
				 on a.pajak_header_id=c.pajak_header_id
				 where a.kode_cabang='".$cabang."' and a.bulan_pajak=".$masa." and a.tahun_pajak='".$tahun."' and upper(a.nama_pajak)='".strtoupper($pasal)."' and a.pembetulan_ke=".$pembetulan ;
		
		$query3 = $this->db->query($sql3);   
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}
	
	
	function get_download()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		
		$column	= "a.invoice_num, a.invoice_line_num";
		$dir 	= "DESC";
		$where	= "";
		if($q) {
			$where	.= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(c.vendor_name) like '%".strtoupper($q)."%') ";
		}
		$where	.= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		$queryExec	= "Select DISTINCT a.*
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','SUBMIT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  						
						".$where."
					order by ".$column." ".$dir;		
		
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		//print_r($rowCount); exit();
		return $result;			
	}
		
	function get_bukti_potong()
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(c.NAMA_WP) like '%".strtoupper($q)."%') ";
		}
		$where2	= " and a.bulan_pajak = '".$_POST['_searchBulan']."' and a.tahun_pajak = '".$_POST['_searchTahun']."' and a.akun_pajak = '".$_POST['_searchPph']."' ";
			
		$queryExec	= "select a.*, c.vendor_name, c.npwp npwp1, c.address_line1,b.pembetulan 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID
						where b.status='DRAFT' and a.kode_cabang='".$cabang."' and c.organization_id= 82 and b.bulan_pajak = a.bulan_pajak
						".$where2.$where."
						order by a.pajak_line_id DESC";	//where nnti di ganti rejected
		
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}
	
	function action_save_bukti_potong()
	{
		$idPajakHeader      = $this->input->post('idPajakHeader');
		$idPajakLines       = $this->input->post('idPajakLines');
		$id		            = $this->input->post('idwp');
		$isNewRecord        = $this->input->post('isNewRecord');
		$namawp	            = $this->input->post('namawp');
		$kodepajak	        = $this->input->post('kodepajak');
		$npwp	            = $this->input->post('npwp');
		$dpp	            = $this->input->post('dpp');
		$alamat	            = $this->input->post('alamat');
		$tarif	            = $this->input->post('tarif');
		$jumlahpotong	    = $this->input->post('jumlahpotong');
		$invoicenumber	    = $this->input->post('invoicenumber');
		$nofakturpajak	    = $this->input->post('nofakturpajak');		
		$tanggalfakturpajak	= ($this->input->post('tanggalfakturpajak'))?$this->tgl_db($this->input->post('tanggalfakturpajak')):'';
		$newkodepajak	    = $this->input->post('newkodepajak');
		$newtarif	        = $this->input->post('newtarif');
		$newdpp	            = str_replace(',','',$this->input->post('newdpp'));
		$newjumlahpotong	= str_replace(',','',$this->input->post('newjumlahpotong'));
		$nobupot			= $this->input->post('nobupot');
		$glaccount			= $this->input->post('glaccount');
		$fAkun				= $this->input->post('fAkun');
		$fNamaAkun			= $this->input->post('fNamaAkun');
		$fBulan				= $this->input->post('fBulan');
		$fTahun				= $this->input->post('fTahun');
		
		$addAkun			= $this->input->post('fAddAkun');
		$addNamaAkun		= $this->input->post('fAddNamaAkun');
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		
		$pembetulan			= $this->input->post('pembetulan');
		
		$masa_pajak			= $this->getMonth($addBulan);
		$date				= date("Y-m-d H:i:s");
		
		if($isNewRecord){			
			$sql3 = "SELECT PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='000' and BULAN_PAJAK=".$addBulan." and tahun_pajak='".$addTahun."' and upper(nama_pajak)='PPH PSL 23' " ; //nanti wherenya di gnti akun pajak
			$query3 = $this->db->query($sql3);
			$row	= $query3->row();
			$header = $row->PAJAK_HEADER_ID;
			$query3->free_result(); 
			
			if($query3) {
				$sql	="insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,KODE_PAJAK,NPWP,NAMA_WP,ALAMAT_WP,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,NEW_KODE_PAJAK,NEW_DPP,NEW_TARIF,NEW_JUMLAH_POTONG,KODE_CABANG,USER_NAME,CREATION_DATE,NAMA_PAJAK,VENDOR_ID,NO_BUKTI_POTONG,GL_ACCOUNT,AKUN_PAJAK) 
				VALUES
				('".$header."','".$masa_pajak."','".$addBulan."','".$addTahun."','".$kodepajak."','".$npwp."','".$namawp."','".$alamat."','".$dpp."','".$tarif."','".$jumlahpotong."','".$invoicenumber."','".$nofakturpajak."',TO_DATE('".$tanggalfakturpajak."','yyyy-mm-dd hh24:mi:ss'),'".$newkodepajak."','".$newdpp."','".$newtarif."','".$newjumlahpotong."','000','ADMIN',TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'),'".$addNamaAkun."','".$id."','".$nobupot."','".$glaccount."','".$addAkun."')";
			}
			$uHeader	= $header;
			$uAkun		= $addAkun;
			$uBulan		= $addBulan;
			$uTahun		= $addTahun;
			
		} else {			
			  $sql	="Update SIMTAX_PAJAK_LINES set NEW_KODE_PAJAK='".$newkodepajak."', NEW_DPP='".$newdpp."', NEW_TARIF='".$newtarif."', NEW_JUMLAH_POTONG='".$newjumlahpotong."', LAST_UPDATE_DATE=TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss'), USER_NAME='ADMIN'
			  where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='000' and BULAN_PAJAK=".$fBulan." and TAHUN_PAJAK='".$fTahun."' and AKUN_PAJAK='".$fAkun."' ";
			$uHeader	= $idPajakHeader;
			$uAkun		= $fAkun;
			$uBulan		= $fBulan;
			$uTahun		= $fTahun; 
		}
		$query	= $this->db->query($sql);		
		if ($query){
			if($isNewRecord){
				simtax_update_history("SIMTAX_PAJAK_LINES", "CREATE", "PAJAK_LINE_ID");
			}
			else{
				$param = array("PAJAK_LINE_ID" => $idPajakLines);
				simtax_update_history("SIMTAX_PAJAK_LINES", "UPDATE", $param);
			}
			$sql	="Update SIMTAX_PAJAK_HEADERS set PEMBETULAN='".$pembetulan."'
			where PAJAK_HEADER_ID ='".$uHeader."' and KODE_CABANG='000' and BULAN_PAJAK=".$uBulan." and TAHUN_PAJAK='".$uTahun."' and upper(NAMA_PAJAK)='PPH PSL 23' "; //nnti where ny diganti akun_pajak
			$query2	= $this->db->query($sql);
			if($query2){
				$param = array("PAJAK_HEADER_ID" => $uHeader);
				simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	function action_delete_bukti_potong()
	{
		$idPajakLines   = $this->input->post('idPajakLines');
		$fAkun			= $this->input->post('fAkun');
		$fBulan			= $this->input->post('fBulan');
		$fTahun			= $this->input->post('fTahun');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='000' and BULAN_PAJAK=".$fBulan." and tahun_pajak='".$fTahun."' and akun_pajak='".$fAkun."' ";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}		
		
	}	
	
	function get_closing()
	{
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		
		$where	= " and a.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' ";
		
		if($_POST['_searchCabang']){
			$where .=" and a.kode_cabang='".$_POST['_searchCabang']."' ";
		}
				
		if($q) {
			$where	= " and upper(a.STATUS) like '%".strtoupper($q)."%' ";
		}
		
		$queryExec	= "select a.*
					   , c.nama_cabang
					   from simtax_master_period a
					   inner join simtax_pajak_headers b
					   on a.period_id=b.period_id
					   inner join simtax_kode_cabang c
					   on a.kode_cabang=c.kode_cabang
					   where 1=1
					   ".$where."
					   AND b.status not in('DRAFT','SUBMIT','REJECT SUPERVISOR','REJECT BY ADMIN')
						order by a.tahun_pajak, a.bulan_pajak desc";	
		
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
		$query 		= $this->db->query($sql);
		
		$result['query']			= $query;
		$result['jmlRow']			= $rowCount;		
		return $result;			
	}
	
	function action_save_closing()
	{
		$user	    = $this->session->userdata('identity');
		$cabang	    = $this->input->post('cabang');
		$status	    = $this->input->post('status');
		$nama	    = $this->input->post('nama');
		$bulan	    = $this->input->post('bulan');
		$tahun	    = $this->input->post('tahun');
		$pembetulan	= $this->input->post('pembetulan');

		$date	= date('Y-m-d H:i:s');		
		$header	= $this->get_header_id($nama,$bulan,$tahun,$pembetulan, $cabang);
		
		$sqlCek		="Select pajak_header_id, status, period_id from simtax_pajak_headers where pajak_header_id=".$header;

		$queryCek	= $this->db->query($sqlCek);

		$row		= $queryCek->row();
		$statusHeader 	= $row->STATUS;
		
		if($header && $status=="Open"){

			$sql	="Update SIMTAX_MASTER_PERIOD set STATUS='Close'
					  where KODE_CABANG='".$cabang."' and BULAN_PAJAK=".$bulan." and TAHUN_PAJAK='".$tahun."' and upper(NAMA_PAJAK)='".strtoupper($nama)."' and pembetulan_ke='".$pembetulan."'";
			$query	= $this->db->query($sql);
			$param = array("PERIOD_ID" => $row->PERIOD_ID);
			simtax_update_history("SIMTAX_MASTER_PERIOD", "UPDATE", $param);
			
			$sql4	="Update SIMTAX_PAJAK_HEADERS set STATUS='CLOSE'
					  where KODE_CABANG='".$cabang."' and PAJAK_HEADER_ID=".$header;
			$query4	= $this->db->query($sql4);
			$param = array("PAJAK_HEADER_ID" => $header);
			simtax_update_history("SIMTAX_PAJAK_HEADERS", "UPDATE", $param);
			
			if ($query && $query4){
				$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (".$header.",'".strtoupper($nama)."',sysdate,'Close','".$user."')";
				$query2	= $this->db->query($sql2);
				if($query2){
					return true;
				} else {
					return false;
				}			
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	
	function action_cek_closing()
	{
		$status	= $this->input->post('status');
		$date	= date('Y-m-d H:i:s');
		
		$sql	="Select * from SIMTAX_MASTER_PERIOD 
				  where KODE_CABANG='000' and BULAN_PAJAK=1 and TAHUN_PAJAK='2017' and upper(NAMA_PAJAK)='PPH PSL 23' AND upper(STATUS)='OPEN' ";
		$query	= $this->db->query($sql);
		$cek	= $query->num_rows() ;
		if ($query){
			return $cek;
		} else {
			return false;
		}		
	}
	
	function get_rekonsiliasi()
	{
		$cabang	=  $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	.= " and (upper(a.no_faktur_pajak) like '%".strtoupper($q)."%' or upper(a.invoice_num) like '%".strtoupper($q)."%' or upper(nvl(c.vendor_name,a.nama_wp)) like '%".strtoupper($q)."%') ";
		}
		$where	.= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
			
		$queryExec	= "select a.*
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						".$where."
						order by a.invoice_num, a.invoice_line_num DESC";	
		
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}
	
		
	function get_currency($bulan, $tahun, $pajak, $pembetulan)
	{
		$cabang	=  $this->kode_cabang;
		//$where = " and spl.IS_CHEKLIST=1";		
		$queryExec	= "select 
							  
							  spl.invoice_currency_code
							  , case when  spl.invoice_currency_code='IDR'
												then sum(nvl(sph.saldo_awal,0))
									else 0 end saldo_awal
							  , sum(nvl(sph.mutasi_debit,0)) mutasi_debit
							  , sum(nvl(sph.mutasi_kredit,0)) mutasi_kredit
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'						 
						group by        
							   spl.invoice_currency_code ";
			//print_r($queryExec); exit();
			$query	 	= $this->db->query($queryExec);
			//$sql2		= $queryExec;	  
			//$query2 	= $this->db->query($sql2);		
			$rowCount	= $query->num_rows() ;
			//$query 		= $this->db->query($sql);		
			
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}
	
	function get_summary_rekonsiliasiAll($bulan, $tahun, $pajak, $pembetulan, $mtu)
	{
		$cabang	=  $this->kode_cabang;
		//$where = " and spl.IS_CHEKLIST=1";
		
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN'))
						  and upper(smp.status) ='OPEN'
						  and spl.invoice_currency_code ='".$mtu."'
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";			
			$query1 	= $this->db->query($queryExec);		
	
		$result['queryExec']	= $query1;			
		return $result;			
	}
	
	function get_currency1($bulan, $tahun, $pajak, $pembetulan, $step) //dipakai all (master)
	{
		$cabang	=  $this->kode_cabang;		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and sph.status not in ('DRAFT','SUBMIT','REJECT SUPERVISOR','REJECT BY ADMIN')";
		} else if ($step=="VIEW"){
			$where = "";
		} 
		$queryExec	= "select  nvl(sph.saldo_awal,0)	saldo_awal
							  , nvl(sph.mutasi_debit,0) mutasi_debit
							  , nvl(sph.mutasi_kredit,0	) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						  where sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan.$where ;	
			
			$query	 	= $this->db->query($queryExec);			
			$rowCount	= $query->num_rows() ;		
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}
	
	function get_summary_rekonsiliasiAll1($bulan, $tahun, $pajak, $pembetulan, $step)
	{
		$cabang	=  $this->kode_cabang;
		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','SUBMIT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="VIEW"){
			$where = "";
		}
		
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  ".$where."						  					 
						group by        
							   spl.IS_CHEKLIST, smp.STATUS ";			
		$query1 	= $this->db->query($queryExec);		
		$result['queryExec']	= $query1;		
		return $result;			
	}
	
	/*Awal Detail Rekonsiliasi================================================================================*/
	
	function get_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->kode_cabang;
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$tipe	    = $_POST['_searchTipe'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);		
			
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
				
		if($tipe=="REKONSILIASI"){
			$where .= " and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="APPROV"){
			$where .= "  and (b.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (b.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}
		
		if($q) {
			$where .= " and (upper(nvl(c.npwp,a.npwp)) like '%".strtoupper($q)."%' or upper(nvl(c.vendor_name,a.nama_wp)) like '%".strtoupper($q)."%') ";
		}
		
		$queryExec	= "Select nvl(a.new_dpp, a.dpp) dpp
						, nvl(a.new_jumlah_potong, a.jumlah_potong) jumlah_potong	
						, nvl(c.vendor_name,a.nama_wp) vendor_name
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.invoice_num
						, a.invoice_line_num
						, case upper(a.source_data) 
							when 'SELISIH' then a.keterangan
							else 'Tidak Dilaporkan'
							end keterangan
						, a.source_data
						, a.pajak_line_id
						, b.kode_cabang
						, '1' urut
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' 						
						AND a.is_cheklist =0
						AND nvl(upper(c.vendor_name),upper(a.nama_wp))!='KAS NEGARA'
						".$where;						
			
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by URUT ASC, INVOICE_NUM, INVOICE_LINE_NUM DESC"; 			
			
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	function get_total_detail_summary()
	{
		ini_set('memory_limit', '-1');
		$cabang	    =  $this->kode_cabang;		
		$tipe	    = $_POST['_searchTipe'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
			
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($tipe=="REKONSILIASI"){
			$where .= " and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="APPROV"){
			$where .= "  and (b.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="DOWNLOAD"){
			$where .= "  and (b.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.status) ='OPEN' ";
		} else if ($tipe=="VIEW"){
			$where .= "";
		}	
				
		$queryExec	= "SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(a.NEW_JUMLAH_POTONG, a.JUMLAH_POTONG)),0) JUMLAH_POTONG	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' 						
						AND a.is_cheklist =0
						AND nvl(upper(c.vendor_name),upper(a.nama_wp))!='KAS NEGARA'
						".$where;						
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 		
		
		$query 		= $this->db->query($queryExec);			
		return $query;			
	}
	
	function action_delete_detail_range()
	{
		$cabang 	= $this->input->post('rcab');
		$idline		= $this->input->post('rid');		
		
		$sql	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='".$idline."' and KODE_CABANG='".$cabang."'";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}			
	}
	/*Akhir Detail Rekonsiliasi================================================================================*/
	
	function action_save_saldo_awal()
	{
		$cabang				    = $this->kode_cabang;
		$user				    = $this->session->userdata('identity');				
		$pajak		            = $this->input->post('pajak');
		$bulan                  = $this->input->post('bulan');
		$tahun	                = $this->input->post('tahun');
		$pembetulan	            = $this->input->post('pembetulan');
		$saldo                  = $this->input->post('vsal');
		$mutasiD	            = $this->input->post('vmtsd');
		$mutasiK	            = $this->input->post('vmtsk');
		$header					= $this->get_header_id($pajak,$bulan,$tahun,$pembetulan);		
		
		if ($header){
			  $sql	="Update simtax_pajak_headers set saldo_awal='".$saldo."', mutasi_debit='".$mutasiD."', mutasi_kredit='".$mutasiK."', last_update_date=sysdate, user_name='".$user."'
			  where pajak_header_id ='".$header."' and kode_cabang='".$cabang."' ";	
				
			$query	= $this->db->query($sql);		
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
		
	function master_nama_wp() //dipake lgsg di view
	{
		//$sql = "Select * from simtax_master_supplier order by VENDOR_ID"; 
		$sql = "Select tahun_pajak VENDOR_ID, nama_pajak VENDOR_NAME from simtax_master_period"; 
		$query = $this->db->query($sql);
		return	$query;		
		//$query->free_result();
	}
	
	
	function get_master_wp()
	{
		$q           = (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where       = "";
		$whereSearch = "";
		if($q) { 
			$whereSearch = " and upper(VENDOR_NAME) like '%".strtoupper($q)."%' or upper(ADDRESS_LINE1) like '%".strtoupper($q)."%' or  NPWP like '%".strtoupper($q)."%' ";
		}

		$og_id = get_og_id($this->kode_cabang);

		$where = " where organization_id = '".$og_id."'";
	
		$queryExec	= "Select * from simtax_master_supplier ".$where.$whereSearch." order by VENDOR_ID DESC";
		
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
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}
	
	function get_master_kode_pajak()
	{
		$jnspajak	= $_POST['jenisPajak'];
		$cabang		= $this->kode_cabang;
		$q			= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where		= "";
		if($q) { 
			$where	= " and (upper(tax_code) like '%".strtoupper($q)."%' or upper(tax_rate) like '%".strtoupper($q)."%' or upper(description) like '%".strtoupper($q)."%') ";
		}

		$nama_cabang = get_nama_cabang($cabang);

		if($cabang || $cabang != "") {

			if($jnspajak == "PPH PSL 23 DAN 26"){
				$where .= " and operating_unit='GENERAL'";
			}
			else{

				$where .= " and operating_unit='".$nama_cabang."' and kode_cabang='".$cabang."'";
			}
		}

		$queryExec	= "Select * from simtax_master_pph where upper(kode_pajak)='".$jnspajak."' ".$where." order by tax_code";

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
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}
	
	function action_save_rekonsiliasi()
	{
		$cabang				= $this->kode_cabang;
		$user				= $this->session->userdata('identity');
		//$idPajakHeader      = $this->input->post('idPajakHeader');
		$idPajakLines       = $this->input->post('idPajakLines');
		$id		            = $this->input->post('idwp');
		$isNewRecord        = $this->input->post('isNewRecord');
		$namawp             = $this->input->post('namawp');
		$kodepajak          = $this->input->post('kodepajak');
		$npwp               = $this->input->post('npwp');
		$dpp                = $this->input->post('dpp');
		$alamat             = $this->input->post('alamat');
		$tarif              = $this->input->post('tarif');
		$jumlahpotong       = $this->input->post('jumlahpotong');
		$invoicenumber      = $this->input->post('invoicenumber');
		$nofakturpajak      = $this->input->post('nofakturpajak');		
		$tanggalfakturpajak = ($this->input->post('tanggalfakturpajak'))?$this->tgl_db($this->input->post('tanggalfakturpajak')):'';
		
		/*$key_pajak          = $this->input->post('newkodepajak');
		$jml                = strlen($key_pajak) - 2;
		$key_pajak          = substr($key_pajak, $jml, 2);
		$newkodepajak       = $key_pajak; // perubahan dari dff*/
		$newkodepajak    = $this->input->post('newkodepajak');
		
		$newtarif           = $this->input->post('newtarif');
		$newdpp             = str_replace(',','',$this->input->post('newdpp'));
		$newjumlahpotong    = str_replace(',','',$this->input->post('newjumlahpotong'));
		$nobupot            = $this->input->post('nobupot');
		$glaccount          = $this->input->post('glaccount');
		$fAkun              = $this->input->post('fAkun');
		$fNamaAkun          = $this->input->post('fNamaAkun');
		$fBulan             = $this->input->post('fBulan');
		$fTahun             = $this->input->post('fTahun');
		
		$addAkun            = $this->input->post('fAddAkun');
		$addNamaAkun        = $this->input->post('fAddNamaAkun');
		$addBulan           = $this->input->post('fAddBulan');
		$addTahun           = $this->input->post('fAddTahun');
		$organization_id    = $this->input->post('organization_id'); 
		$pembetulan         = $this->input->post('fAddPembetulan');
		$vendor_site_id     = $this->input->post('vendor_site_id');
		$tanggalgl          = $this->input->post('tanggalgl'); 
		$matauang           = $this->input->post('matauang'); 
		$matauangh			= $this->input->post('matauanghide'); 
		
		$masa_pajak			= $this->getMonth($addBulan);
		$date				= date("Y-m-d H:i:s");
		
		if(!$id){
			return 2;
			exit();
		}	
		
		/*if(strtoupper($addAkun)!="PPH PSL 22"){
			if(!$newkodepajak){
				return 4;
				exit();
			}		
		}*/
		if($kodepajak == "" && $newkodepajak == ""){
			return 4;
			exit();
		}
		/*if(!$newtarif){
			return 5;
			exit();
		}*/
		if($tarif =="" && $newtarif ==""){
			return 5;
			exit();
		}
		
		
		if ($matauangh=="IDR"){			 
			//$rjumlahpotong = $jumlahpotong ;
			$newJmlPotong = "";
		} else {
			//$rjumlahpotong = $newjumlahpotong;
			$newJmlPotong = " , NEW_JUMLAH_POTONG='".$newjumlahpotong."'";
		}
			  
		/* $rjmlDPP = $rjumlahpotong / ($newtarif/100);
		if ($newdpp!=$rjmlDPP){
			return 6;
			exit();
		} */
		
		if($isNewRecord){			
			
			$header	= $this->get_header_id($addAkun,$addBulan,$addTahun,$pembetulan);
			
			if($header) {
				$sql	="insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,KODE_PAJAK,NPWP,NAMA_WP,ALAMAT_WP,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,NEW_KODE_PAJAK,NEW_DPP,NEW_TARIF,NEW_JUMLAH_POTONG,KODE_CABANG,USER_NAME,CREATION_DATE,NAMA_PAJAK,VENDOR_ID,NO_BUKTI_POTONG,GL_ACCOUNT,ORGANIZATION_ID,VENDOR_SITE_ID,INVOICE_ACCOUNTING_DATE,INVOICE_CURRENCY_CODE,SOURCE_DATA,AKUN_PAJAK) 
				VALUES
				('".$header."','".$masa_pajak."','".$addBulan."','".$addTahun."','".$kodepajak."','".$npwp."','".$namawp."','".$alamat."','".$dpp."','".$tarif."','".$newjumlahpotong."','".$invoicenumber."','".$nofakturpajak."',TO_DATE('".$tanggalfakturpajak."','yyyy-mm-dd hh24:mi:ss'),'".$newkodepajak."','".$newdpp."','".$newtarif."','".$newjumlahpotong."','".$cabang."','".$user."',sysdate,'".$addAkun."','".$id."','".$nobupot."','".$glaccount."','".$organization_id."','".$vendor_site_id."','".$tanggalgl."','".$matauang."','MANUAL','".$glaccount."')";
			}
		} else {
			$sql	="Update SIMTAX_PAJAK_LINES set VENDOR_ID='".$id."', ORGANIZATION_ID='".$organization_id."', VENDOR_SITE_ID='".$vendor_site_id."', NEW_KODE_PAJAK='".$newkodepajak."', NEW_DPP='".$newdpp."', NEW_TARIF='".$newtarif."', GL_ACCOUNT='".$glaccount."', INVOICE_CURRENCY_CODE ='".$matauang."'
			  , LAST_UPDATE_DATE=sysdate, USER_NAME='".$user."', AKUN_PAJAK='".$glaccount."', NO_FAKTUR_PAJAK='".$nofakturpajak."'
			  ".$newJmlPotong."
			  where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."' ";
			//gldate dan tgl faktur tidak ke post
			  /*$sql	="Update SIMTAX_PAJAK_LINES set VENDOR_ID='".$id."', ORGANIZATION_ID='".$organization_id."', VENDOR_SITE_ID='".$vendor_site_id."', NEW_KODE_PAJAK='".$newkodepajak."', NEW_DPP='".$newdpp."', NEW_TARIF='".$newtarif."', GL_ACCOUNT='".$glaccount."', INVOICE_CURRENCY_CODE ='".$matauang."'
			  , LAST_UPDATE_DATE=sysdate, USER_NAME='".$user."', AKUN_PAJAK='".$glaccount."', NO_FAKTUR_PAJAK='".$nofakturpajak."', TANGGAL_FAKTUR_PAJAK=TO_DATE('".$tanggalfakturpajak."','yyyy-mm-dd hh24:mi:ss'), INVOICE_ACCOUNTING_DATE='".$tanggalgl."'
			  ".$newJmlPotong."
			  where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."' ";*/
		}
		//print_r ($sql); end();
		$query	= $this->db->query($sql);		
		if ($query){
			return 1;
		} else {
			return false;
		}
		
	}
	
	function action_delete_rekonsiliasi()
	{
		$cabang			=  $this->kode_cabang;
		$idPajakLines   = $this->input->post('idPajakLines');
		$fAkun			= $this->input->post('fAkun');
		$fBulan			= $this->input->post('fBulan');
		$fTahun			= $this->input->post('fTahun');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."'";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}			
	}
	
	function action_submit_rekonsiliasi()
	{
		$cabang				= $this->kode_cabang;
		$user				= $this->session->userdata('identity');
		$addAkun			= $this->input->post('fAddAkun');
		$addNamaAkun		= $this->input->post('fAddNamaAkun');
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		$pembetulan			= $this->input->post('fAddPembetulan');
		$date				= date('Y-m-d H:i:s');
		$header				= $this->get_header_id($addAkun,$addBulan,$addTahun,$pembetulan);		
		
		if($header) {
			$sql	="UPDATE SIMTAX_PAJAK_HEADERS set STATUS='SUBMIT', TGL_SUBMIT_SUP=sysdate, USER_NAME = '".$user."' 
					 where PAJAK_HEADER_ID ='".$header."' and KODE_CABANG='".$cabang."'";
			$query	= $this->db->query($sql);	
			if ($query){	
				$sql2	="Insert into SIMTAX_ACTION_HISTORY (PAJAK_HEADER_ID,JENIS_PAJAK,ACTION_DATE,ACTION_CODE,USER_NAME) 
						 values (".$header.",'".$addAkun."',sysdate,'SUBMIT','".$user."')";
				$query2	= $this->db->query($sql2);
				if($query2){
					return true;
				} else {
					return false;
				}			
			} else {
				return false;
			}
		}		
	}
	
	function action_check_rekonsiliasi()
	{
		$cabang			= $this->kode_cabang;
		$idPajakLines  	= $this->input->post('line_id');
		$ischeck	   	= $this->input->post('ischeck');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST=".$ischeck." where PAJAK_LINE_ID ='".$idPajakLines."' and KODE_CABANG='".$cabang."'";
		$query	= $this->db->query($sql);	
		if ($query){
			return true;
		} else {
			return false;
		}		
	}
	
	function action_cek_row_rekonsiliasi()
	{
		$cabang	    = $this->kode_cabang;
		$addAkun			= $this->input->post('fAddAkun');		
		$addBulan			= $this->input->post('fAddBulan');
		$addTahun			= $this->input->post('fAddTahun');
		$pembetulan			= $this->input->post('fAddPembetulan');
		
		
		$where2	= " and b.bulan_pajak = '".$addBulan."' and b.tahun_pajak = '".$addTahun."' and upper(b.nama_pajak) = '".strtoupper($addAkun)."' and b.pembetulan_ke = '".$pembetulan."' ";	
		
		$sql3 = "select b.nama_pajak
						, nvl(a.new_kode_pajak,a.kode_pajak) kode_pajak
						, a.is_cheklist
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, c.npwp npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, nvl(a.new_dpp,a.dpp) dpp				
						, nvl(a.new_tarif,a.tarif) tarif
						, a.gl_account
						, nvl(c.npwp,a.npwp) npwp1				
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong 				
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						".$where2."						
						order by a.invoice_num, a.invoice_line_num DESC";
		
		$query3 = $this->db->query($sql3);   
		if($query3){			
			return $query3;
		} else {
			return false;
		}		
	}
	
	function action_get_selectAll()
	{
		$cabang				= $this->kode_cabang;		
		$id_lines			= $this->input->post('id_lines');
		$vcheck				= $this->input->post('vcheck');	
		
		$sql	="UPDATE SIMTAX_PAJAK_LINES set IS_CHEKLIST='".$vcheck."'
				 where PAJAK_LINE_ID in  (".$id_lines.") and KODE_CABANG='".$cabang."'";
		
		$query	= $this->db->query($sql);	
		if ($query){				
			return true;				
		} else {
			return false;
		}
				
	}	
	
	function action_save_range_rekon()
	{
		$cabang		= $this->kode_cabang;
		$user		= $this->session->userdata('identity');
		$npwp       = $this->input->post('rnpwp');
		$nama		= $this->input->post('rnama');
		$dpp        = $this->input->post('rdpp');
		$jmlpotong	= $this->input->post('rpph');
		$ket	    = $this->input->post('rket');
		$bln	    = $this->input->post('vbln');
		$thn	    = $this->input->post('vthn');
		$nmpajak	= $this->input->post('vnmpajak');
		$pem	    = $this->input->post('vpem');
		
		$masa_pajak			= $this->getMonth($bln);
		$date				= date("Y-m-d H:i:s");
		
		if(!$npwp){
			return false;
			exit();
		}	
			$header	= $this->get_header_id($nmpajak,$bln,$thn,$pem);
			
			if($header) {
				$sql	="insert into SIMTAX_PAJAK_LINES (PAJAK_HEADER_ID,MASA_PAJAK,BULAN_PAJAK,TAHUN_PAJAK,NAMA_PAJAK,NPWP,NAMA_WP,NEW_DPP,NEW_JUMLAH_POTONG,KETERANGAN,SOURCE_DATA, KODE_CABANG,USER_NAME, IS_CHEKLIST) 
				VALUES
				('".$header."','".$masa_pajak."','".$bln."','".$thn."','".$nmpajak."','".$npwp."','".$nama."','".$dpp."','".$jmlpotong."','".$ket."','SELISIH','".$cabang."','".$user."',0)";
			}			
		$query	= $this->db->query($sql);		
		if ($query){
			return 1;
		} else {
			return false;
		}
		
	}
	
	
	function get_master_pajak()
	{
		$queryExec	        = "Select jenis_pajak, display from simtax_master_jns_pajak where kelompok_pajak='PPH' order by kelompok_pajak, jenis_pajak";
		$query 		        = $this->db->query($queryExec);
		$result['query']	= $query;
		return $result;		
	}
	
	function add_csv($data)
	{
		$dpp 				= (!$data['dpp'] || $data['dpp']=='' )?0:$data['dpp'];
		$tarif 				= (!$data['tarif'] || $data['tarif']=='' )?0:$data['tarif'];
		$newjumlahpotong 	= (!$data['jml_potong'] || $data['jml_potong']=='' )?0:$data['jml_potong'];
		
		if ($data['id_lines']!="PAJAK_LINE_ID") {
			 $newJmlPotong = "";
			  /* if ($data['matauang']!="IDR"){
				  $newJmlPotong = " , NEW_JUMLAH_POTONG='".$newjumlahpotong."'";
			  } */
			$sql	= "update ".'"'."SIMTAX_PAJAK_LINES".'"'." set 
						NAMA_WP='".$data['nama']."', NPWP='".$data['npwp']."', ALAMAT_WP='".$data['alamat']."',
						NEW_KODE_PAJAK='".$data['kode_pajak']."', NEW_DPP='".$dpp."', AKUN_PAJAK='".$data['akun_pajak']."', GL_ACCOUNT='".$data['akun_pajak']."', NEW_TARIF='".$tarif."', NO_FAKTUR_PAJAK='".$data['no_faktur']."', TANGGAL_FAKTUR_PAJAK = TO_DATE('".$data['tgl_faktur']."', 'SYYYY-MM-DD HH24:MI:SS')
						".$newJmlPotong."
						where PAJAK_LINE_ID='".$data['id_lines']."' ";
			
			$query = $this->db->query($sql);
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function get_pph22_csv()
	{
		$cabang		= $this->kode_cabang;
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";				
		 $sql = "Select a.no_bukti_potong
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong
						, a.bulan_pajak
						, a.tahun_pajak
						, b.pembetulan_ke
						, nvl(a.new_kode_pajak,a.kode_pajak) kode_pajak2
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."					
					order by a.no_bukti_potong ASC"; 
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	function get_pph22_kompilasi_csv()
	{
		$cabang		= $_REQUEST['cabang'];
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";	
		
		if($cabang){
			$where2 	.=" and b.kode_cabang='".$cabang."' ";
		}
		
		 $sql = "Select a.no_bukti_potong
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong
						, a.bulan_pajak
						, a.tahun_pajak
						, b.pembetulan_ke
						, nvl(a.new_kode_pajak,a.kode_pajak) kode_pajak2
						, c.vendor_name
						, c.npwp npwp1
						, c.address_line1
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where 1=1
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."					
					order by a.no_bukti_potong ASC"; 
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	function get_pph23_csv()
	{
		$cabang		= $this->kode_cabang;
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		/* $kompilasi	= $_REQUEST['com'];
		$cab		= $_REQUEST['cab'];
		$cabang		= $_REQUEST['valuecab']; */
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";	
		
		/* if ($cab==true){
			$cabang		= $this->kode_cabang;
			$where2 	.=" b.kode_cabang='".$cabang."' ";
		} else {
			if ($kompilasi==true){
				if($cabang){
					$where2 	.=" b.kode_cabang='".$cabang."' ";
				}			
			} 
		} */
		
		 $sql = "Select a.no_bukti_potong
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."
					group by a.no_bukti_potong
					order by a.no_bukti_potong ASC";		
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	function get_count()
	{
		$cabang		= $this->kode_cabang;
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";			
		
		 $sql = "Select a.no_bukti_potong
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."
					group by a.no_bukti_potong
					order by a.no_bukti_potong ASC";		
		
		$query = $this->db->query($sql);
		return $query;	
	}
	
	function get_pph23_csv_prog()
	{
		$cabang		= $this->kode_cabang;
		$pajak  	= $this->input->post('pajak');
		$bulan  	= $this->input->post('bulan');
        $tahun  	= $this->input->post('tahun');
		$pembetulan = $this->input->post('pembetulan');			
		
		/* $kompilasi	= $_REQUEST['com'];
		$cab		= $_REQUEST['cab'];
		$cabang		= $_REQUEST['valuecab']; */
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";	
		
		/* if ($cab==true){
			$cabang		= $this->kode_cabang;
			$where2 	.=" b.kode_cabang='".$cabang."' ";
		} else {
			if ($kompilasi==true){
				if($cabang){
					$where2 	.=" b.kode_cabang='".$cabang."' ";
				}			
			} 
		} */
		
		 $sql = "Select a.no_bukti_potong
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."
					group by a.no_bukti_potong
					order by a.no_bukti_potong ASC";		
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	function get_pph23_kompilasi_csv()
	{
		$cabang		= $_REQUEST['cabang'];
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";
		
		if($cabang){
			$where2 	.=" and b.kode_cabang='".$cabang."' ";
		}			
		
		
		 $sql = "Select a.no_bukti_potong
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where 1=1
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'  
						".$where2."
					group by a.no_bukti_potong
					order by a.no_bukti_potong ASC"; 		
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	function get_detail_pph23_csv($bupot, $pembetulan)
	{
		$cabang		= $this->kode_cabang;		
		$where2	= " and a.no_bukti_potong = '".$bupot."' and b.pembetulan_ke = '".$pembetulan."'";		
		
		 $sql = "Select a.*
						, nvl(a.new_kode_pajak,a.kode_pajak) kode_pajak2
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'						
						".$where2."
					order by a.pajak_line_id";

		$query = $this->db->query($sql);
		return $query;
	}
	
	function get_detail_pph23_kompilasi_csv($bupot, $pembetulan)
	{
		$cabang		= $_REQUEST['cabang'];		
		$where2	= " and a.no_bukti_potong = '".$bupot."' and b.pembetulan_ke = '".$pembetulan."'";		
		if($cabang){
			$where2 	.=" and b.kode_cabang='".$cabang."' ";
		}
		 $sql = "Select a.*
						, nvl(a.new_kode_pajak,a.kode_pajak) kode_pajak2
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where 1=1
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'						
						".$where2."
					order by a.pajak_line_id"; 
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	function cek_detail_pph23_csv($bupot, $pembetulan, $kode_pajak)
	{
		$cabang		= $this->kode_cabang;		
		$where2	= " and a.no_bukti_potong = '".$bupot."' and b.pembetulan_ke = '".$pembetulan."' and nvl(a.new_kode_pajak,a.kode_pajak)='".$kode_pajak."'";			
							
		$sql ="Select a.no_bukti_potong
						, nvl(a.new_kode_pajak,a.kode_pajak)
						, count(*) jml
						, sum(nvl(a.new_dpp,a.dpp)) dpp1						
						, sum(nvl(a.new_jumlah_potong,a.jumlah_potong)) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'						
					".$where2."
					GROUP BY a.no_bukti_potong, nvl(a.new_kode_pajak,a.kode_pajak)";
		
		$query = $this->db->query($sql);
		return $query;		
	}
	
	//CSV PPH PSL 15 Awal========================================
	function get_detail_pph15_csv()
	{
		$cabang		= $this->kode_cabang;
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";		
		
		 $sql = "Select a.*
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong1
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'
						--and upper(d.STATUS) ='OPEN'
						".$where2."
					order by a.no_bukti_potong ASC, a.invoice_num, a.invoice_line_num DESC"; 
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	function get_detail_kompilasi_pph15_csv()
	{
		$cabang		= $_REQUEST['cabang'];
		$pajak  	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan  	= $_REQUEST['month'];
        $tahun  	= $_REQUEST['year'];				
        $pembetulan = $_REQUEST['p'];				
		
		$where2	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."'";		
		
		if($cabang){
			$where2 .=" and b.kode_cabang='".$cabang."' ";
		}
		 $sql = "Select a.*
						, to_char(a.tgl_bukti_potong,'dd/mm/yyyy') tgl_bukti_potong1
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 
						, nvl(a.new_dpp,a.dpp) dpp1
						, nvl(a.new_tarif,a.tarif) tarif1
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where 1=1 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'
						--and upper(d.STATUS) ='OPEN'
						".$where2."
					order by a.no_bukti_potong ASC, a.invoice_num, a.invoice_line_num DESC"; 
		
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	//CSV PPH PSL 15 Akhir========================================
	
	// CSV PPH PSL 4 AYAT 2 Awal=====================================
	function cek_detail_pph4_2_csv($bupot, $pembetulan, $tarif)
	{
		$cabang		= $this->kode_cabang;		
		$where2	= " and a.no_bukti_potong = '".$bupot."' and b.pembetulan_ke = '".$pembetulan."' and nvl(a.new_tarif,a.tarif)='".$tarif."'";	
							
		$sql ="Select a.no_bukti_potong
						, nvl(a.new_tarif,a.tarif) tarif1
						, count(*) jml
						, sum(nvl(a.new_dpp,a.dpp)) dpp1						
						, sum(nvl(a.new_jumlah_potong,a.jumlah_potong)) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where b.kode_cabang='".$cabang."' 
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'						
					".$where2."
					GROUP BY a.no_bukti_potong, nvl(a.new_tarif,a.tarif)";			
		$query = $this->db->query($sql);
		return $query;		
	}
	
	function cek_detail_pph4_2_kompilasi_csv($bupot, $pembetulan, $tarif)
	{
		$cabang		= $_REQUEST['cabang'];			
		$where2	= " and a.no_bukti_potong = '".$bupot."' and b.pembetulan_ke = '".$pembetulan."' and nvl(a.new_tarif,a.tarif)='".$tarif."'";	
		if($cabang){
			$where2 .=" and b.kode_cabang='".$cabang."' ";
		}
		
		$sql ="Select a.no_bukti_potong
						, nvl(a.new_tarif,a.tarif) tarif1
						, count(*) jml
						, sum(nvl(a.new_dpp,a.dpp)) dpp1						
						, sum(nvl(a.new_jumlah_potong,a.jumlah_potong)) jumlah_potong1
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					where 1=1
						and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') and a.IS_CHEKLIST='1'						
					".$where2."
					GROUP BY a.no_bukti_potong, nvl(a.new_tarif,a.tarif)";			
		$query = $this->db->query($sql);
		return $query;		
	}
	
	// CSV PPH PSL 4 AYAT 2 Awal=====================================
	
	function get_format_csv()
	{
		$cabang		= $this->kode_cabang;
		$pajak   	= ($_REQUEST['tax'])? strtoupper($_REQUEST['tax']):"";
        $bulan   	= $_REQUEST['month'];
        $tahun   	= $_REQUEST['year'];
        $pembetulan	= $_REQUEST['ke'];		
		
		$where	= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pajak."' and b.pembetulan_ke = '".$pembetulan."' and a.is_cheklist=1 ";		
						
		$sql = "select a.PAJAK_LINE_ID
						, a.nama_pajak
						, a.invoice_num
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.no_bukti_potong
						, to_char(a.tgl_bukti_potong,'dd-mm-yyyy') tgl_bukti_potong
						, a.gl_account
						, nvl(a.new_kode_pajak, a.kode_pajak) kode_pajak
						, a.invoice_accounting_date
						, a.invoice_currency_code
						, a.invoice_line_num
						, nvl(a.new_dpp,a.dpp) dpp
						, nvl(a.new_tarif,a.tarif) tarif
						, nvl(a.new_jumlah_potong,a.jumlah_potong) jumlah_potong
						, nvl(c.vendor_name,a.nama_wp) vendor_name 
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1 					
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
							and c.ORGANIZATION_ID=a.ORGANIZATION_ID			
							and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID			
						where b.kode_cabang='".$cabang."' and (b.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(d.STATUS) ='OPEN'
						".$where."
						order by a.invoice_num, a.invoice_line_num DESC";
					
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			return $query;
		} else {
			return false;
		}
		
	}
	
	function add_kompilasi_csv($data)
	{
		$dpp 		= (!$data['dpp'] || $data['dpp']=='' )?0:$data['dpp'];
		$tarif 		= (!$data['tarif'] || $data['tarif']=='' )?0:$data['tarif'];
		$jml_potong	= (!$data['jumlah_potong'] || $data['jumlah_potong']=='' )?0:$data['jumlah_potong'];
			
		if ($data['bulan']!="BULAN PAJAK") {
			$masa_pajak	= $this->getMonth($data['bulan']);
			$sql	= "insert into SIMTAX_PAJAK_LINES
							(PAJAK_HEADER_ID, BULAN_PAJAK,TAHUN_PAJAK, NAMA_PAJAK,NAMA_WP,NPWP,ALAMAT_WP,KODE_PAJAK,DPP,TARIF,JUMLAH_POTONG,INVOICE_NUM,NO_BUKTI_POTONG,NO_FAKTUR_PAJAK,TANGGAL_FAKTUR_PAJAK,GL_ACCOUNT,KODE_CABANG,PEMBETULAN_KE,MASA_PAJAK)
						values
							(".$data['header_id'].",".$data['bulan'].",".$data['tahun'].",'".$data['pajak']."','".$data['nama']."','".$data['npwp']."','".$data['alamat']."','".$data['kode_pajak']."','".$data['dpp']."','".$data['tarif']."','".$data['jumlah_potong']."','".$data['invoice_number']."','".$data['no_bukti_potong']."','".$data['no_faktur']."',"."TO_DATE('".$data['tgl_faktur']."','yyyy-mm-dd hh24:mi:ss')".",'".$data['akun_beban']."','070','".$data['pembetulan']."','".$masa_pajak."')";
			$query = $this->db->query($sql);
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}		
	}
		
	function get_view()
	{
		ini_set('memory_limit', '-1');
		$cabang			 =  $this->kode_cabang;
				
		$where 	 = "";			
		if ($this->input->post('_searchPph')){
			$where	.= " and sph.nama_pajak='".$this->input->post('_searchPph')."'";
		}
		if ($this->input->post('_searchBulan')){
			$where	.= " and sph.bulan_pajak='".$this->input->post('_searchBulan')."'";
		}
		if ($this->input->post('_searchTahun')){
			$where	.= " and sph.tahun_pajak='".$this->input->post('_searchTahun')."'";
		}
		if ($this->input->post('_searchPembetulan')!=""){
			$where	.= " and sph.pembetulan_ke='".$this->input->post('_searchPembetulan')."'";
		}		
				
			$queryExec	= "select sph.NAMA_PAJAK
							 , sph.PAJAK_HEADER_ID 
							 , sph.MASA_PAJAK
							 , sph.BULAN_PAJAK
							 , sph.TAHUN_PAJAK
							 , to_char(sph.CREATION_DATE,'DD-MON-YYYY HH24:MI:SS') CREATION_DATE
							 , sph.USER_NAME
							 , sph.STATUS
							 , to_char(sph.TGL_SUBMIT_SUP,'DD-MON-YYYY HH24:MI:SS') TGL_SUBMIT_SUP
							 , to_char(sph.TGL_APPROVE_SUP,'DD-MON-YYYY HH24:MI:SS') TGL_APPROVE_SUP
							 , to_char(sph.TGL_APPROVE_PUSAT,'DD-MON-YYYY HH24:MI:SS') TGL_APPROVE_PUSAT
							 , sph.PEMBETULAN_KE
							 , sph.KODE_CABANG
							 , (select sum(nvl(spl.new_jumlah_potong, spl.jumlah_potong))
								  from simtax_pajak_lines spl
								 where spl.pajak_header_id = sph.pajak_header_id
								   and spl.IS_CHEKLIST = 1) ttl_jml_potong
						  from simtax_pajak_headers sph
							, simtax_master_jns_pajak smjp
						  where sph.kode_cabang='".$cabang."' 							
							and sph.nama_pajak = smjp.jenis_pajak
							and smjp.kelompok_pajak ='PPH'
						  ".$where."
						  ORDER BY sph.CREATION_DATE desc";
			
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;		
	}
	
	function get_rekonsiliasi_detail()
	{
		$cabang	=  $this->kode_cabang;
		ini_set('memory_limit', '-1');
		$q		= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where	= "";
		if($q) {
			$where	.= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or upper(a.invoice_num) like '%".strtoupper($q)."%' or nvl(upper(c.vendor_name),upper(a.nama_wp)) like '%".strtoupper($q)."%') ";
		}
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";			
	
		$queryExec	= "select a.*
						, nvl(c.vendor_name, a.nama_wp) vendor_name
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where b.kode_cabang='".$cabang."' 
						".$where."						
						order by a.invoice_num, a.invoice_line_num DESC";	
					
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}	
		
	function get_history()
	{
		ini_set('memory_limit', '-1');	
		$cabang	=  $this->kode_cabang;
							   
		$queryExec	="Select sah.ACTION_CODE
						, to_char(sah.ACTION_DATE,'DD-MON-YYYY HH24:MI:SS') ACTION_DATE
						, sah.user_name
						, sah.catatan
						, sph.bulan_pajak , sph.masa_pajak, sph.tahun_pajak from simtax_action_history sah
						inner join simtax_pajak_headers sph
						on sah.pajak_header_id=sph.pajak_header_id 
						where sph.kode_cabang='".$cabang."'
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."	
						order by action_date desc";
		
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	function get_pembetulan()
	{		
		$where		= "";		
		if ($this->input->post('_searchPph')){
			$where	.= " and sph.nama_pajak='".$this->input->post('_searchPph')."'";
		}
		if ($this->input->post('_searchBulan')){
			$where	.= " and sph.bulan_pajak='".$this->input->post('_searchBulan')."'";
		}
		if ($this->input->post('_searchTahun')){
			$where	.= " and sph.tahun_pajak='".$this->input->post('_searchTahun')."'";
		}
		if ($this->input->post('_searchPembetulan')){
			$where	.= " and sph.pembetulan_ke='".$this->input->post('_searchPembetulan')."'";
		}
		if ($this->input->post('_searchCabang')){
			$where	.= " and sph.kode_cabang='".$this->input->post('_searchCabang')."'";
		}
		
		$queryExec	= "Select sph.*, smp.status status_period, skc.nama_cabang from simtax_pajak_headers sph
						inner join simtax_master_period smp
						on sph.period_id = smp.period_id
						inner join simtax_kode_cabang skc
						on sph.kode_cabang=skc.kode_cabang
						where 1=1 
						and sph.pembetulan_ke >0
						".$where."
						order by sph.tahun_pajak, sph.bulan_pajak ";		
		
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
		$query 		= $this->db->query($sql);
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;	
		return $result;		
	}
	
	function action_save_pembetulan()
	{
		$user		= $this->session->userdata('identity');
		$pasal	    = $this->input->post('fjenisPajak');
		$masa	    = $this->input->post('fbulan');
		$tahun	    = $this->input->post('ftahun');				
		$pembetulan	= $this->input->post('fpembetulanKe') - 1;	
		$cabang	    = $this->input->post('fCabang');	
		$date	= date("Y-m-d H:i:s");				
		
		$sql3 = "SELECT STATUS from SIMTAX_MASTER_PERIOD WHERE kode_cabang='".$cabang."' and BULAN_PAJAK=".$masa." and tahun_pajak='".$tahun."' and upper(nama_pajak)='".strtoupper($pasal)."' AND PEMBETULAN_KE=".$pembetulan ; 
		
		$query3 = $this->db->query($sql3);
		$rowCount	= $query3->num_rows() ;
		if ($rowCount>0){
			$row	= $query3->row();
			$status = $row->STATUS;
			
			if($status=="Close" || $status=="CLOSE"){
				$header	= $this->get_header_id_max($pasal,$masa,$tahun,$cabang);				
				//call package
				//add by Derry
				if($header){
					$PARAMETER_1 = $header;
					$OUT_MESSAGE = "";
					
					$stid = oci_parse($this->db->conn_id, 'BEGIN :OUT_MESSAGE := SIMTAX_PAJAK_UTILITY_PKG.createPembetulan(:PARAMETER_1); end;');

					oci_bind_by_name($stid, ':PARAMETER_1',  $PARAMETER_1,200);
					oci_bind_by_name($stid, ':OUT_MESSAGE',  $OUT_MESSAGE ,100, SQLT_CHR);

					if(oci_execute($stid)){
					  $results = $OUT_MESSAGE;
					}
					
					oci_free_statement($stid);
					
					if ($results == -1) {
						return false;
					} else {
						return $status;
					}
				} else {
					return false;
				}
				//end add derry				
				
			} else if($status=="Open" || $status=="OPEN") {
				return $status;
			} else {
				return false;
			}
			
		} else {
			return "3";
		}	
	}
	
	function action_delete_pembetulan()
	{
		//$cabang			=  $this->kode_cabang;
		$cabang			= $this->input->post('kd_cabang');
		$idPajakHeader  = $this->input->post('header_id');
		$pajak			= $this->input->post('pajak');
		$bulan			= $this->input->post('bulan');
		$tahun			= $this->input->post('tahun');
		$pembetulan_ke	= $this->input->post('pembetulan_ke');
		$date			= date('Y-m-d H:i:s');
		
		$sql	="DELETE FROM SIMTAX_PAJAK_HEADERS where PAJAK_HEADER_ID ='".$idPajakHeader."'";
		$query	= $this->db->query($sql);
		if ($query){
			$sql1	="DELETE FROM SIMTAX_PAJAK_LINES where PAJAK_HEADER_ID ='".$idPajakHeader."'";
			$query1	= $this->db->query($sql1);
			if ($query1){
				$sql2	="DELETE FROM SIMTAX_MASTER_PERIOD where BULAN_PAJAK ='".$bulan."' and TAHUN_PAJAK ='".$tahun."' and upper(NAMA_PAJAK) ='".strtoupper($pajak)."' and PEMBETULAN_KE ='".$pembetulan_ke."' and KODE_CABANG='".$cabang."'";
				$query2	= $this->db->query($sql2);
				
				$sql3	="DELETE FROM SIMTAX_ACTION_HISTORY where PAJAK_HEADER_ID ='".$idPajakHeader."'";
				$query3	= $this->db->query($sql3);
				if ($query2 && $query3){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	function get_kompilasi()
	{
		ini_set('memory_limit', '-1');
		$q				= (isset($_POST['search']['value']))?$_POST['search']['value']:'';		
		$where			= "";
		/* $where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' "; */
		
		if($_POST['_searchCabang']){
			$where .=" and b.kode_cabang='".$_POST['_searchCabang']."' ";
		}
		
		if ($this->input->post('_searchBulan')){
			$where .= " and b.bulan_pajak='".$this->input->post('_searchBulan')."'";
		}
		if ($this->input->post('_searchTahun')){
			$where .= " and b.tahun_pajak='".$this->input->post('_searchTahun')."'";
		}
		if ($this->input->post('_searchPph')){
			$where .= " and b.nama_pajak='".$this->input->post('_searchPph')."'";
		}
		if ($this->input->post('_searchPembetulan')){
			$where .= " and b.pembetulan_ke='".$this->input->post('_searchPembetulan')."'";
		}
		if($q) {
			$where .= " and (upper(a.NO_FAKTUR_PAJAK) like '%".strtoupper($q)."%' or nvl(upper(c.vendor_name), upper(a.nama_wp)) like '%".strtoupper($q)."%') ";
		}
			
			
		$queryExec	= "select DISTINCT a.*
						, nvl(c.vendor_name, a.nama_wp) vendor_name
						, nvl(c.npwp,a.npwp) npwp1
						, nvl(c.address_line1,a.alamat_wp) address_line1
						, e.kode_cabang cabang_master 
						,e.nama_cabang 
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join SIMTAX_KODE_CABANG e
							on b.kode_cabang=e.kode_cabang
						left join SIMTAX_MASTER_SUPPLIER c
							on a.VENDOR_ID=c.VENDOR_ID 
							and a.ORGANIZATION_ID=c.ORGANIZATION_ID	
							and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where 1=1						
						and upper(d.STATUS) ='CLOSE'
						".$where."
						order by e.kode_cabang, a.pajak_line_id DESC";		
		
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
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;	
	}
	
	function get_currency_kompilasi($bulan, $tahun, $pajak, $pembetulan, $cabang) 
	{
		/* $cabang	=  $this->kode_cabang;		
		if($step=="REKONSILIASI"){
			$where = " and (sph.status in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="APPROV"){
			$where = "  and (sph.status in ('SUBMIT','APPROVAL SUPERVISOR')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="DOWNLOAD"){
			$where = "  and (sph.status not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN')) and upper(smp.status) ='OPEN' ";
		} else if ($step=="VIEW"){
			$where = "";
		}  */
		$where = "";
		if ($cabang || $cabang !=""){
			$where = " and sph.kode_cabang = '".$cabang."' ";
		}
		
		$queryExec	= "select  sph.kode_cabang
							  , skc.nama_cabang 
							  , sum(nvl(sph.saldo_awal,0)) saldo_awal
							  , sum(nvl(sph.mutasi_debit,0)) mutasi_debit
							  , sum(nvl(sph.mutasi_kredit,0	)) mutasi_kredit
						from simtax_pajak_headers sph
						inner join simtax_master_period smp
							on sph.period_id=smp.period_id
						inner join simtax_kode_cabang skc
							on sph.kode_cabang = skc.kode_cabang
						  where sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'						 
						  and sph.pembetulan_ke=".$pembetulan."
						  and upper(smp.status) ='CLOSE'
						  ".$where."
						  group by sph.kode_cabang, skc.nama_cabang
						  order by sph.kode_cabang
						  ";	
			//print_r($queryExec); exit();
			$query	 	= $this->db->query($queryExec);			
			$rowCount	= $query->num_rows() ;		
			$result['query']	= $query;
			$result['jmlRow']	= $rowCount;		
		return $result;				
			
	}
	
	function get_summary_rekonsiliasi($bulan, $tahun, $pajak, $pembetulan, $cabang)
	{
				
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$bulan."
						  and sph.tahun_pajak = ".$tahun."
						  and upper(sph.nama_pajak) = '".strtoupper($pajak)."'
						  and sph.kode_cabang = '".$cabang."'
						  and sph.pembetulan_ke=".$pembetulan."
						  and upper(smp.status) ='CLOSE'
						  and spl.is_cheklist =1			  					 
						group by        
							   spl.is_cheklist, smp.STATUS ";			
		$query1 	= $this->db->query($queryExec);		
		$result['queryExec']	= $query1;		
		return $result;			
	}
	
	function get_total_bayar_summary_kompilasi()
	{
		$cabang	    = $_POST['_searchCabang'] ;
		$where		= "";
		if($cabang || $cabang !="") {
			$where .= " and sph.kode_cabang='".$cabang."' ";
		}
		$queryExec	= "select 
							   spl.is_cheklist
							 , case when spl.is_cheklist = 1 then 'Dilaporkan'
							   else 'Tidak Dilaporkan' end pengelompokan
							 , sum(nvl(spl.new_jumlah_potong,spl.jumlah_potong)) jml_potong
							 , smp.status
						from simtax_pajak_headers sph
							 , simtax_pajak_lines spl
							 , simtax_master_period smp
							 , simtax_master_supplier sms 
						where sph.PAJAK_HEADER_ID = spl.PAJAK_HEADER_ID
						  and sph.period_id = smp.period_id
						  and spl.vendor_id=sms.vendor_id(+)
						  and spl.organization_id=sms.organization_id(+)
						  and spl.vendor_site_id=sms.vendor_site_id(+)
						  and sph.bulan_pajak = ".$_POST['_searchBulan']."
						  and sph.tahun_pajak = ".$_POST['_searchTahun']."
						  and upper(sph.nama_pajak) = '".strtoupper($_POST['_searchPph'])."'						  
						  and sph.pembetulan_ke=".$_POST['_searchPembetulan']."
						  ".$where."
						  and upper(smp.status) ='CLOSE'
						  and spl.is_cheklist =1			  					 
						group by        
							   spl.is_cheklist, smp.STATUS ";			
		$query 	= $this->db->query($queryExec);				
		return $query;			
	}
	
	function get_detail_summary_kompilasi()
	{
		ini_set('memory_limit', '-1');	
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);		
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($q) {
			$where .= " and (nvl(c.npwp,a.npwp) like '%".strtoupper($q)."%' or nvl(upper(c.vendor_name), upper(a.nama_wp)) like '%".strtoupper($q)."%') ";
		}
		
		if($cabang || $cabang !="") {
			$where .= " and b.kode_cabang='".$cabang."' ";
		}
		
		$queryExec	= "Select d.kode_cabang
						, d.nama_cabang
						, nvl(a.new_dpp, a.dpp) dpp
						, nvl(a.new_jumlah_potong, a.jumlah_potong) jumlah_potong	
						, nvl(c.vendor_name, a.nama_wp) vendor_name
						, nvl(c.npwp,a.npwp) npwp1
						, c.address_line1
						, a.no_faktur_pajak
						, a.tanggal_faktur_pajak
						, a.invoice_num
						, a.invoice_line_num
						, 'Tidak Dilaporkan' keterangan
						, '1' urut
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join simtax_kode_cabang d
							on b.kode_cabang=d.kode_cabang
						left join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						AND nvl(upper(c.vendor_name),upper(a.nama_wp))!='KAS NEGARA'
						and upper(d.status) ='CLOSE'
						".$where;						
			
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by d.kode_cabang, a.invoice_num, a.invoice_line_num desc"; 			
			
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	function get_detail_summary_kompilasi_cabang()
	{
		ini_set('memory_limit', '-1');	
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);		
		$q		    = (isset($_POST['search']['value']))?$_POST['search']['value']:'';	
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($q) {
			$where .= " and (upper(d.nama_cabang) like '%".strtoupper($q)."%') ";
		}
		
		if($cabang || $cabang !="") {
			$where .= " and b.kode_cabang='".$cabang."' ";
		}
		
		$queryExec	= "Select d.kode_cabang
						, d.nama_cabang
						, sum(nvl(a.new_jumlah_potong, a.jumlah_potong)) jumlah_potong	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
							on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
							on b.PERIOD_ID=d.PERIOD_ID
						inner join simtax_kode_cabang d
							on b.kode_cabang=d.kode_cabang
						left join SIMTAX_MASTER_SUPPLIER c
							on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						AND nvl(upper(c.vendor_name),upper(a.nama_wp))!='KAS NEGARA'
						and upper(d.status) ='CLOSE'
						".$where."
						group by d.kode_cabang, d.nama_cabang ";						
			
			$sql2		= $queryExec;	  
			$query2 	= $this->db->query($sql2);		
			$rowCount	= $query2->num_rows() ;
			
			$queryExec	.=" order by d.kode_cabang "; 			
			
		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$_POST['start']."+".$_POST['length']."
					)
					WHERE rnum >".$_POST['start']."";
		
		$query 		= $this->db->query($sql);		
		
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;		
		return $result;			
	}
	
	
	function get_total_detail_summary_kompilasi()
	{
		ini_set('memory_limit', '-1');			
		$cabang	    = $_POST['_searchCabang'] ;
		$tgl_akhir	= $this->Master_mdl->getEndMonth($_POST['_searchTahun'],$_POST['_searchBulan']);
			
		$where	= "";		
		$where .= " and b.bulan_pajak = '".$_POST['_searchBulan']."' and b.tahun_pajak = '".$_POST['_searchTahun']."' and upper(b.nama_pajak) = '".$_POST['_searchPph']."' and b.pembetulan_ke = '".$_POST['_searchPembetulan']."' ";
		
		if($cabang || $cabang!=""){
			$where .= " and b.kode_cabang='".$cabang."' ";
		} 
				
		$queryExec	= "SELECT * FROM (
						SELECT 'Tidak Dilaporkan' KETERANGAN					  
						, NVL(SUM(NVL(a.NEW_JUMLAH_POTONG, a.JUMLAH_POTONG)),0) JUMLAH_POTONG	
						from SIMTAX_PAJAK_LINES a 
						inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
						where a.is_cheklist =0
						AND nvl(upper(c.vendor_name),upper(a.nama_wp))!='KAS NEGARA'
						and upper(d.status) ='CLOSE'
						".$where;						
			$queryExec	.=" ) 
							GROUP BY KETERANGAN, JUMLAH_POTONG "; 		
		
		$query 		= $this->db->query($queryExec);			
		return $query;			
	}
	
	
	 //ADDED BY MIKE 27/03/2018
  //QUERY GET PPH 23 DATA
  //----------------------------------------------------------------------------
  function get_pph($bulan, $tahun, $pph, $pembetulan, $isCabang, $valCabang= FALSE, $nf = FALSE,$jnsLap)
	{
		ini_set('memory_limit', '-1');		
		$where   = "";		
		
		$where .= " and b.bulan_pajak = '".$bulan."' and b.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pph."' and b.pembetulan_ke = '".$pembetulan."' ";
		
		if($nf === FALSE){

		}else{
		  $where .= " and a.NO_BUKTI_POTONG = '".$nf."' ";
		}
		
		$order	= "";
		if($pph == "PPH PSL 23 DAN 26"){
			$order =" a.INVOICE_CURRENCY_CODE ASC, ";
		}
		
		$a="";
		if($isCabang=="true"){
			$a .="aaaaa=>";
			$cabang	 =  $this->kode_cabang;
			$where 	.= " and b.kode_cabang='".$cabang."' 
						 and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR','REJECT BY ADMIN') ";
		} else {
			if($valCabang){
				$a .="bbbbbb=>";
				$where 	.= " and b.kode_cabang='".$valCabang."' ";
			} else {
				$a .="ccccc=>";
				$where 	.= " ";
			}
			$where .="  and upper(b.status) ='CLOSE' ";
		}
		
		/*if ($jnsLap){
			$where .= " and upper(e.document_type)='".strtoupper($jnsLap)."' ";
		}*/
				
		$queryExec	= "Select a.pajak_line_id
						, nvl(a.new_kode_pajak, a.kode_pajak) kode_pajak
						, e.npwp_petugas
						, a.invoice_rate
						, a.no_bukti_potong
						, a.tgl_bukti_potong
						, nvl(a.new_dpp, a.dpp) dpp
						, nvl(a.new_tarif, a.tarif) tarif
						, nvl(a.new_jumlah_potong, a.jumlah_potong) jumlah_potong
						, nvl(c.vendor_name, a.nama_wp) nama_wp						
						, case when nvl(c.npwp, a.npwp)='0'  then '00.000.000-0.000.000'
                        when substr(nvl(c.npwp, a.npwp),1,2)='00'  then '00.000.000-0.000.000'
                        when length(nvl(c.npwp, a.npwp))=15 then substr(nvl(c.npwp, a.npwp),1,2)||'.'||substr(nvl(c.npwp, a.npwp),3,3)||'.'||substr(nvl(c.npwp, a.npwp),6,3)||'-'||substr(nvl(c.npwp, a.npwp),9,1)||'.'||substr(nvl(c.npwp, a.npwp),10,3)||'.'||substr(nvl(c.npwp, a.npwp),13,3)
                                when nvl(c.npwp, a.npwp) is null then '00.000.000-0.000.000'
                            else
                                nvl(c.npwp, a.npwp)
                            end npwp						
						, nvl(c.address_line1,a.alamat_wp) alamat_wp
						, e.NPWP_PEMOTONG npwppp 
						, e.NAMA_WP_PEMOTONG namapp 
						, e.NPWP_PEMOTONG npwp_pemotong
						, e.NAMA_WP_PEMOTONG nama_pemotong
						, e.NAMA_PETUGAS_PENANDATANGAN
						, e.URL_TANDA_TANGAN
						, e.JABATAN_PETUGAS_PENANDATANGAN
						, e.NAMA_KPP
						, b.TGL_APPROVE_SUP
						, a.invoice_currency_code, f.kota
					from SIMTAX_PAJAK_LINES a 
					inner join SIMTAX_PAJAK_HEADERS b						
						on a.pajak_header_id=b.pajak_header_id
					inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
					left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID 
						and c.ORGANIZATION_ID=a.ORGANIZATION_ID	
						and c.VENDOR_SITE_ID=a.VENDOR_SITE_ID
					 left join SIMTAX_PEMOTONG_PAJAK e
						on a.kode_cabang = e.KODE_CABANG 
						and b.nama_pajak = e.nama_pajak
						and e.START_EFFECTIVE_DATE < b.TGL_APPROVE_SUP
						AND e.document_type in ('Bukti Potong')
			         LEFT JOIN simtax_kode_cabang f
			            ON     a.kode_cabang = f.KODE_CABANG
					where 1=1 
						 and a.IS_CHEKLIST='1'  						
						".$where."
						--AND e.document_type = 'Bukti Potong'
					order by ".$order." a.no_bukti_potong ASC ";	
			//print_r($queryExec); exit();
     //------------------------------------------------------------------------
		$sql		=$queryExec;		
		$query 		= $this->db->query($sql);
		return $query->result_array();
	}
  //----------------------------------------------------------------------------

	
	//ADDED BY MIKE 27/03/2018
  //QUERY GET PPH 23 DATA
  //----------------------------------------------------------------------------
  function get_pph23($bulan, $tahun, $pph, $nf = "") // skip
	{
		ini_set('memory_limit', '-1');
		$cabang	=  $this->kode_cabang;
		$where	= " and a.bulan_pajak = '".$bulan."' and a.tahun_pajak = '".$tahun."' and upper(b.nama_pajak) = '".$pph."' ";
		 if($nf){
			$where .= " and a.no_bukti_potong = '".$nf."' ";
		}
		
		//ORIGINAL Query
		//-------------------------------------------------------------------------------------------------------------------------------

		$queryExec	= "Select DISTINCT a.*, c.vendor_name, c.npwp npwp1, c.address_line1
						from SIMTAX_PAJAK_LINES a
						inner join SIMTAX_PAJAK_HEADERS b
						on a.pajak_header_id=b.pajak_header_id
						inner join SIMTAX_MASTER_PERIOD d
						on b.PERIOD_ID=d.PERIOD_ID
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						where a.kode_cabang='".$cabang."' and upper(b.status) not in ('DRAFT','REJECT SUPERVISOR') and a.IS_CHEKLIST='1'
						".$where."
						order by a.pajak_line_id DESC";
    
		//-------------------------------------------------------------------------------------------------------------------------------

		//ADDED BY Mike - 27/03/2018
		//SKIP CONDITION FOR DEVELOPMENT
		//------------------------------------------------------------------------
    /*
    $queryExec	= "Select DISTINCT a.*, c.vendor_name, c.npwp npwp1, c.address_line1
						from SIMTAX_PAJAK_LINES a
						inner join SIMTAX_PAJAK_HEADERS b
						on a.pajak_header_id=b.pajak_header_id
						left join SIMTAX_MASTER_SUPPLIER c
						on c.VENDOR_ID=a.VENDOR_ID and c.ORGANIZATION_ID=a.ORGANIZATION_ID
						where a.kode_cabang='".$cabang."' and a.IS_CHEKLIST='1'
						".$where."
						order by a.pajak_line_id DESC";
    */
		//------------------------------------------------------------------------

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.*
						FROM(
							".$queryExec."
						) a
					)
					";
		$sql2		= $queryExec;
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows() ;
		//print_r($sql); exit();
		$query 		= $this->db->query($sql);

		return $query->result_array();
	}

	function get_ntpn($tahun_pajak, $jenis_pajak, $whereCabang, $start, $length, $keywords){
		ini_set('memory_limit', '-1');

		$where = "";
		if($keywords) {
			//$q     = strtoupper($keywords);
			$where	.= " and (upper(BANK) like '%".strtoupper($keywords)."%' or NTPN like '%".$keywords."%' or BULAN like '%".$keywords."%') ";
		}
     	$queryExec	= " SELECT * FROM SIMTAX_NTPN WHERE TAHUN = '".$tahun_pajak."' AND JENIS_PAJAK = '".$jenis_pajak."' AND KODE_CABANG in (".$whereCabang.")".$where." ";

     	/*print_r($queryExec); die();*/

		$sql2		= $queryExec;  
		$query2 	= $this->db->query($sql2);
		$rowCount	= $query2->num_rows();

		$sql		="SELECT * FROM (
						SELECT rownum rnum, a.* 
						FROM(
							".$queryExec."
						) a 
						WHERE rownum <=".$start."+".$length."
					)
					WHERE rnum >".$start."";

					
		
		$query 		= $this->db->query($sql);
		$result['query']	= $query;
		$result['jmlRow']	= $rowCount;
		return $result;

	}

	public function get_header_id_rekap($pajak,$tahun,$cabang){
		$sql3 	= "SELECT max(PAJAK_HEADER_ID) PAJAK_HEADER_ID from SIMTAX_PAJAK_HEADERS WHERE kode_cabang='".$cabang."' and tahun_pajak='".$tahun."' and upper(nama_pajak)='".strtoupper($pajak)."' " ; 
		
		$query3 = $this->db->query($sql3);
		$row	= $query3->row();
		$header = $row->PAJAK_HEADER_ID;			
		if ($query3){
			return $header;
		} else {
			return false;
		}
		$query3->free_result();
	}

	function check_ntpn($id, $bulan, $tahun, $pembetulan,$jenis_pajak, $kode_cabang, $ntpn){
		$andID = "";
		if($id !=""){
			$andID = " AND ID != ".$id;
		}

		$sql   = "SELECT COUNT(*) TOTAL FROM SIMTAX_NTPN WHERE BULAN = '".$bulan."' AND TAHUN = '".$tahun."' AND PEMBETULAN = '".$pembetulan."' AND JENIS_PAJAK = '".$jenis_pajak."' AND KODE_CABANG = '".$kode_cabang."' AND NTPN = '".$ntpn."'".$andID;

		$query    = $this->db->query($sql);
		
		$rowCount = $query->row()->TOTAL;

		return $rowCount;

	}

	function update_ntpn($id, $data, $tanggal_setor, $tanggal_lapor){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_setor != ""){
			$this->db->set('TANGGAL_SETOR',"TO_DATE('".$tanggal_setor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_lapor != ""){
			$this->db->set('TANGGAL_LAPOR',"TO_DATE('".$tanggal_lapor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		$this->db->where('ID', $id);
		
		$update = $this->db->update("SIMTAX_NTPN", $data);

		if($update){
			simtax_update_history("SIMTAX_NTPN","UPDATE", $id);
			return true;
		}
		else{
			return false;
		}
	}

	function add_ntpn($data, $tanggal_setor, $tanggal_lapor){

		$date   = date("Y-m-d H:i:s");

		if($tanggal_setor != ""){
			$this->db->set('TANGGAL_SETOR',"TO_DATE('".$tanggal_setor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}
		if($tanggal_lapor != ""){
			$this->db->set('TANGGAL_LAPOR',"TO_DATE('".$tanggal_lapor."', 'SYYYY-MM-DD HH24:MI:SS')",false);
		}

		$insert = $this->db->insert("SIMTAX_NTPN", $data);

		if($insert){
			simtax_update_history("SIMTAX_NTPN","CREATE");
			return true;
		}
		else{
			return false;
		}
	}

	function delete_ntpn($id){

		$sql = "DELETE FROM SIMTAX_NTPN
					WHERE ID = '".$id."'";

		$query	= $this->db->query($sql);

		if($query){
			return true;
		}
	}

	function get_kode_pajak($nama_pajak){

		$cabang		= $this->kode_cabang;
		$nama_cabang = get_nama_cabang($cabang);

		if($cabang || $cabang != "") {
			if($jnspajak == "PPH PSL 23 DAN 26"){
				$where = " and operating_unit='GENERAL'";
			}
			else{
				$where = " and operating_unit='".$nama_cabang."' and kode_cabang='".$cabang."'";
			}
		}

		$sql   = "SELECT TAX_CODE, DESCRIPTION, TAX_RATE, KODE_PAJAK, JENIS_23 from simtax_master_pph
					where upper(kode_pajak)='".$nama_pajak."' ".$where." order by tax_code";
		
		$query = $this->db->query($sql);

		return $query;		

	}
  //----------------------------------------------------------------------------

	
}