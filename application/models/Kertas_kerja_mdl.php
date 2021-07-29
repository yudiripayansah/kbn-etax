<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Kertas_kerja_mdl extends CI_Model {
	
  public function __construct() {
      parent::__construct();
  }

    function getkktgghnakunt($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}

        $sql ="
		SELECT
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".($tahundari)."
				and coa like '2%' 
				and coa not in ('20205101','20305101','20505101','20725101')
				".$wcbg."
		) as hrg_perolehan_akuntansi,
		(        
			--select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0)  
			--from simtax_tb_v
			--	where period_num between ".$bulandari." and ".$bulanke."
			--	and period_year = ".($tahundari)."
			--	and coa between '21201103' and '21604102'
			--	".$wcbg."
			select nvl(sum(akumulasi_penyusutan),0)
				from simtax_rekon_fixed_asset
				where 1=1 ".$wcbgz." and tahun_pajak  <= ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
				and kelompok_fixed_asset in ('B','N')	
		) as ak_pnysutan_akuntansi,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
				where period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".($tahundari)."
				and coa between '20801101' and '20999999'
				".$wcbg."
		) as hrg_perolehan_atb_akuntansi,
		(        
			--select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0)  
			--from simtax_tb_v
			--	where period_num between ".$bulandari." and ".$bulanke."
			--	and period_year = ".($tahundari)."
			--	and coa between '21801101' and '21999999'
			--	".$wcbg."
			select nvl(sum(akumulasi_penyusutan),0)
			from simtax_rekon_fixed_asset
			where 1=1 ".$wcbgz." and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
			and kelompok_fixed_asset in ('T')
		) as ak_pnysutan_atb_akuntansi,
		(        
			--select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
			--from simtax_tb_v
			--	where period_num between ".$bulandari." and ".$bulanke."
			--	and period_year = ".($tahundari)."
			--	and coa between '11301101' and '11699999'
			--	".$wcbg."
			select
			(
			select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) as deslast
					from simtax_tb_v
					where 1=1
					".$wcbg."
					and period_year = ".$tahundari."
					and period_num between ".$bulandari." and ".$bulanke."
					and coa in ('11301101','11301111','11302101','11302110',                                 
					'11302111',                                
					'11303101',                                    
					'11303107',                              
					'11303110',                                     
					'11303111',                               
					'11304101',                                   
					'11304102',                               
					'11304104',                                 
					'11304107',                               
					'11304110',                                    
					'11304111',                               
					'11304113',                                  
					'11305101',                                  
					'11305110',                                 
					'11305111',                                 
					'11499999',                                   
					'11501101',                                          
					'11601101',                                       
					'11699999')
				) 
			  from dual
		) as ak_pnysutan_pymad_akuntansi,
		(        
			select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
			from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
					and period_year = ".($tahundari)."
					and coa = '40701101'
					".$wcbg."
		) as k_manfaat_karyawan,
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 22
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_22,
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 23
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_23,
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 25
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_25
            from dual";
  
        $query 		= $this->db->query($sql);
        return $query;
    }

    function getkktgghnfiskal($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}

        $sql ="
            SELECT nvl(sum(nvl(hp_b,0)+nvl(hp_nb,0)),0) as hrg_perolehan_fiskal, ak_nb, hrg_p_tdkberwujud,
            ak_tdk_berwujud
            from 
            (
            select 
            (
            select nvl(sum(harga_perolehan),0)
                            from simtax_rekon_fixed_asset
                            where bulan_pajak between ".$bulandari." and ".$bulanke." 
                            and tahun_pajak = ".($tahundari)."  
							and kelompok_fixed_asset = 'B' 
							".$wcbgz."
            ) as hp_b,              
            (              
            select nvl(sum(harga_perolehan),0)
                            from simtax_rekon_fixed_asset
                            where bulan_pajak between ".$bulandari." and ".$bulanke."
                            and tahun_pajak  = ".($tahundari)." 
							and kelompok_fixed_asset = 'N'
							".$wcbgz."
            ) as hp_nb,
            (
            select nvl(sum(akumulasi_penyusutan_fiskal),0)
                            from simtax_rekon_fixed_asset
                            where bulan_pajak between ".$bulandari." and ".$bulanke."
                            and tahun_pajak  = ".($tahundari)."
							and kelompok_fixed_asset in ('B','N')
							".$wcbgz."
            ) as ak_nb,
            (
            select nvl(sum(harga_perolehan),0)
                            from simtax_rekon_fixed_asset
                            where bulan_pajak between ".$bulandari." and ".$bulanke."
                            and tahun_pajak   = ".($tahundari)."
							and kelompok_fixed_asset = 'T'
							".$wcbgz."
            ) as hrg_p_tdkberwujud,
            (
            select nvl(sum(akumulasi_penyusutan),0)
                            from simtax_rekon_fixed_asset
                            where  bulan_pajak between ".$bulandari." and ".$bulanke."
                            and tahun_pajak  = ".($tahundari)."
							and kelompok_fixed_asset in ('T')
							".$wcbgz."
            ) as ak_tdk_berwujud
            from dual
            ) group by hp_b, hp_nb, ak_nb, hrg_p_tdkberwujud, ak_tdk_berwujud
            ";
        $query 	= $this->db->query($sql);
        return $query;
	}
	
	function getDataByAkun($bulandari,$bulanke,$tahundari,$akun,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
        $sql ="
		select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		from simtax_tb_v
			where period_num between ".$bulandari." and ".$bulanke."
			and period_year = ".($tahundari)."
			and coa ='".$akun."'
			".$wcbg."
		"; 
		$query 	= $this->db->query($sql);
        return $query;
	}
	
	
	function get_kk_t_rek_706($bulandari="",$bulanke="",$tahun="",$cabang="")
	{

		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}
		/*
		$queryExec_tujuh	= " select srbpb_grp.*
								, sfpb_grp.AMOUNT_POSITIF
								, sfpb_grp.AMOUNT_NEGATIF
							from (select srbpb.kode_akun
										, srbpb.akun_description
										, (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										, sum(case nvl(srbpb.CHECKLIST,'0')
										when '0' then srbpb.debit
										else 0
										end) DEDUCTIBLE 
										, sum(case nvl(srbpb.CHECKLIST,'0')
										when '1' then srbpb.debit
										else 0
										end) NON_DEDUCTIBLE
										, srbpb.kode_jasa
										, srbpb.jasa_description  
									from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
								where srbpb.tahun_pajak = '".$tahun."'
									and srbpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									and kode_akun like '706%'
									and kode_jasa is not null
									".$wcbgz ."
								group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, srbpb.kode_jasa, srbpb.jasa_description) srbpb_grp
								, (select kode_akun,kode_jasa,kode_jasa_description
										, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
									from SIMTAX_FISKAL_PPH_BADAN sfpb
									where sfpb.tahun_pajak = '".$tahun."'
									and kode_akun like '706%'
									and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									and kode_jasa is not null
								group by kode_akun,kode_jasa,kode_jasa_description, tahun_pajak) sfpb_grp 
						where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							and srbpb_grp.kode_jasa = sfpb_grp.kode_jasa (+)
						order by srbpb_grp.kode_akun, srbpb_grp.kode_jasa
							";	
			*/
			$queryExec_tujuh ="select kode_akun,kode_jasa,kode_jasa_description
							, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif
							from SIMTAX_FISKAL_PPH_BADAN sfpb
							where sfpb.tahun_pajak = '".$tahun."'
							and kode_akun like '706%'
							and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
							and kode_jasa is not null
							group by kode_akun,kode_jasa,kode_jasa_description, tahun_pajak, bulan_pajak";												
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function get_kk_t_rek_791($bulandari="",$bulanke="",$tahun="",$cabang="")
	{
		if ($cabang && $cabang != "all") 
		{
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbgz = "";
		}
		$queryExec_tujuh	= "select kode_akun,kode_jasa,kode_jasa_description
								, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif
								from SIMTAX_FISKAL_PPH_BADAN sfpb
								where sfpb.tahun_pajak = '".$tahun."'
								and kode_akun like '791%'
								and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
								and kode_jasa is not null
								group by kode_akun,kode_jasa,kode_jasa_description, tahun_pajak, bulan_pajak
							";								
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function getkk_pajak_kini_akun($bulandari,$bulanke,$tahundari,$cabang,$akun)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbgz = "";
		}

			$sql = "select  sum(nvl(sfpb_grp.AMOUNT_POSITIF,0)) am_positif
			, sum(nvl(sfpb_grp.AMOUNT_NEGATIF,0)) am_negatif
		from (select srbpb.kode_akun
					, srbpb.akun_description
					, srbpb.kode_jasa
				from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
			where srbpb.tahun_pajak = ".($tahundari)."
				and srbpb.bulan_pajak between ".$bulandari." and ".$bulanke."
				and kode_akun in ('".$akun."')
				and kode_jasa is not null
				".$wcbgz."
			group by srbpb.kode_akun, srbpb.akun_description, srbpb.kode_jasa) srbpb_grp
			, (select kode_akun,kode_jasa,kode_jasa_description
					, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif
				from SIMTAX_FISKAL_PPH_BADAN sfpb
				where sfpb.tahun_pajak = ".($tahundari)."
				and kode_akun in ('".$akun."')
				and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
				and kode_jasa is not null
			group by kode_akun,kode_jasa,kode_jasa_description) sfpb_grp 
	where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
		and srbpb_grp.kode_jasa = sfpb_grp.kode_jasa (+)
	order by srbpb_grp.kode_akun, srbpb_grp.kode_jasa";	
        $query 	= $this->db->query($sql);
        return $query;
	}

	function get_penyesuaian_kk_mapgltospt($bulandari,$bulanke,$tahundari, $cabang)
	{
	$queryExec	= " select srbpb_grp.*
								 , nvl(nvl(NON_DEDUCTIBLE,sfpb_grp.AMOUNT_POSITIF),0) AMOUNT_POSITIF
								 , sfpb_grp.AMOUNT_NEGATIF
								 , nvl(srbpb_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBal(srbpb_grp.kode_akun,'".$tahun."',srbpb_grp.bulan_pajak) - nvl(NON_DEDUCTIBLE,nvl(sfpb_grp.AMOUNT_POSITIF,0)) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '0' then srbpb.debit
										   else NULL
										   end) DEDUCTIBLE 
										 , sum(case nvl(srbpb.CHECKLIST,'0')
										   when '1' then srbpb.debit
										   else NULL
										   end) NON_DEDUCTIBLE,
										   decode('".$bulan."','',0,srbpb.bulan_pajak) bulan_pajak
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak = '".$tahun."'
									  and decode('".$bulan."','',0,srbpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
									  and kode_akun like '8%'
									  and kode_akun not like '891%'
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description, decode('".$bulan."','',0,srbpb.bulan_pajak)) srbpb_grp
								 , (select kode_akun, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak, decode('".$bulan."','',0, sfpb.bulan_pajak) bulan_pajak
									  from SIMTAX_FISKAL_PPH_BADAN sfpb
									 where sfpb.tahun_pajak = '".$tahun."'
									   and kode_akun like '8%'
									   and kode_akun not like '891%'
									   and bulan_pajak is not null
									   and decode('".$bulan."','',0,sfpb.bulan_pajak) = decode('".$bulan."','',0,'".$bulan."')
								 group by kode_akun,tahun_pajak, decode('".$bulan."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							  and srbpb_grp.bulan_pajak = sfpb_grp.bulan_pajak (+)
							order by srbpb_grp.kode_akun
							";								
			$query 		= $this->db->query($queryExec);
			return $query;
	}

	function getkk_beban_bersama_d($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
		
		 $sql = "
		  select coa, coa_desc, sum(nvl(period_net_dr,0)) jmldr, sum(nvl(period_net_cr,0)) jmlcr, nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		  from simtax_tb_v
		  where period_year = ".$tahundari." 
		  and period_num between ".$bulandari." and ".$bulanke."
		  ".$wcbg."
		  and coa in ('80101011',
				'80101012',
				'80101021',
				'80101031',
				'80101032',
				'80101033',
				'80101034',
				'80101035',
				'80101036',
				'80101038',
				'80101039',
				'80101051',
				'80101061',
				'80101064',
				'80101081',
				'80101901',
				'80101999',
				'80102101',
				'80102104',
				'80102105',
				'80102106',
				'80102107',
				'80102110',
				'80102111',
				'80103211',
				'80103261',
				'80103271',
				'80103281',
				'80104103',
				'80104231',
				'80104241',
				'80104261',
				'80104272',
				'80104281',
				'80104299',
				'80105281',
				'80105611',
				'80105999',
				'80106171',
				'80106181',
				'80106182',
				'80106999',
				'80107101',
				'80107102',
				'80107104',
				'80107105',
				'80107106',
				'80107107',
				'80107108',
				'80107999',
				'80108011',
				'80108012',
				'80108061',
				'80108081',
				'80108101',
				'80108111',
				'80108121',
				'80108131',
				'80108151',
				'80108161',
				'80108173',
				'80108174',
				'80108181',
				'80108182',
				'80108191',
				'80108211',
				'80108221',
				'80108229',
				'80108999')
				and services_code in ('4102')
			group by coa, coa_desc
			order by coa
		  ";
	
		$query 	= $this->db->query($sql);
        return $query;  
	}		
	
	function getkk_beban_bersama_vpdk($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
		
		 $sql = "
		  select coa, coa_desc, sum(nvl(period_net_dr,0)) jmldr, sum(nvl(period_net_cr,0)) jmlcr, nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		  from simtax_tb_v
		  where period_year = ".$tahundari." 
		  and period_num between ".$bulandari." and ".$bulanke."
		  ".$wcbg."
		  and coa in ('80101021',
		  '80101031',
		  '80101032',
		  '80101033',
		  '80101034',
		  '80101035',
		  '80101036',
		  '80101039',
		  '80101044',
		  '80101051',
		  '80101061',
		  '80101064',
		  '80101065',
		  '80101081',
		  '80101901',
		  '80101999',
		  '80102101',
		  '80102106',
		  '80102110',
		  '80104241',
		  '80104261',
		  '80104299',
		  '80106182',
		  '80107102',
		  '80107105',
		  '80107107',
		  '80108011',
		  '80108061',
		  '80108111',
		  '80108174',
		  '80108181',
		  '80108211',
		  '80108999')
		  and services_code in ('4173')
			group by coa, coa_desc
			order by coa
		  ";
	
		$query 	= $this->db->query($sql);
        return $query;  
	}	

	function getkk_beban_bersama_svpdh($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
		
		 $sql = "
		  select coa, coa_desc, sum(nvl(period_net_dr,0)) jmldr, sum(nvl(period_net_cr,0)) jmlcr, nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		  from simtax_tb_v
		  where period_year = ".$tahundari." 
		  and period_num between ".$bulandari." and ".$bulanke."
		  ".$wcbg."
		  and coa in (
			'80101011',
			'80101021',
			'80101031',
			'80101032',
			'80101033',
			'80101034',
			'80101035',
			'80101036',
			'80101039',
			'80101041',
			'80101044',
			'80101051',
			'80101061',
			'80101062',
			'80101064',
			'80101065',
			'80101081',
			'80101901',
			'80101999',
			'80102101',
			'80102106',
			'80102110',
			'80103272',
			'80104241',
			'80104261',
			'80104281',
			'80104299',
			'80106182',
			'80107101',
			'80107102',
			'80107105',
			'80107107',
			'80107108',
			'80107109',
			'80107999',
			'80108011',
			'80108011',
			'80108111',
			'80108151',
			'80108181',
			'80108221',
			'80108999')
			and services_code in ('4105')
			group by coa, coa_desc
			order by coa
		  ";
	
		$query 	= $this->db->query($sql);
        return $query;  
	}	

	function getkk_beban_bersama_svpp($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
		
		 $sql = "
		  select coa, coa_desc, sum(nvl(period_net_dr,0)) jmldr, sum(nvl(period_net_cr,0)) jmlcr, nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		  from simtax_tb_v
		  where period_year = ".$tahundari." 
		  and period_num between ".$bulandari." and ".$bulanke."
		  ".$wcbg."
		  and coa in (
			'80101011',
			'80101021',
			'80101031',
			'80101032',
			'80101033',
			'80101034',
			'80101035',
			'80101036',
			'80101039',
			'80101041',
			'80101044',
			'80101051',
			'80101061',
			'80101062',
			'80101064',
			'80101065',
			'80101081',
			'80101901',
			'80101999',
			'80102101',
			'80102106',
			'80102110',
			'80103211',
			'80103231',
			'80103241',
			'80103261',
			'80103271',
			'80103291',
			'80104211',
			'80104221',
			'80104231',
			'80104241',
			'80104261',
			'80104271',
			'80104272',
			'80104281',
			'80104299',
			'80104511',
			'80104531',
			'80104541',
			'80104699',
			'80104801',
			'80104803',
			'80104804',
			'80104806',
			'80104807',
			'80104810',
			'80105211',
			'80105221',
			'80105231',
			'80105241',
			'80105261',
			'80105271',
			'80105281',
			'80105999',
			'80106171',
			'80106182',
			'80107105',
			'80107107',
			'80108011',
			'80108012',
			'80108061',
			'80108111',
			'80108151',
			'80108174',
			'80108181',
			'80108211',
			'80108221',
			'80108999')
			and services_code in ('4165')
			group by coa, coa_desc
			order by coa
		  ";
	
		$query 	= $this->db->query($sql);
        return $query;  
	}

	function getkk_beban_bersama_vplk($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
		
		 $sql = "
		  select coa, coa_desc, sum(nvl(period_net_dr,0)) jmldr, sum(nvl(period_net_cr,0)) jmlcr, nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		  from simtax_tb_v
		  where period_year = ".$tahundari." 
		  and period_num between ".$bulandari." and ".$bulanke."
		  ".$wcbg."
		  and coa in (
			'80101021',
			'80101031',
			'80101032',
			'80101033',
			'80101034',
			'80101035',
			'80101036',
			'80101039',
			'80101041',
			'80101044',
			'80101051',
			'80101061',
			'80101062',
			'80101064',
			'80101065',
			'80101081',
			'80101901',
			'80101999',
			'80102101',
			'80102106',
			'80102110',
			'80104211',
			'80104231',
			'80104241',
			'80104261',
			'80104272',
			'80104281',
			'80104299',
			'80104511',
			'80104531',
			'80104541',
			'80106131',
			'80106182',
			'80106311',
			'80106901',
			'80107101',
			'80107102',
			'80107104',
			'80107105',
			'80107106',
			'80107107',
			'80107108',
			'80108011',
			'80108012',
			'80108021',
			'80108071',
			'80108111',
			'80108121',
			'80108151',
			'80108174',
			'80108181',
			'80108182',
			'80108211',
			'80108221',
			'80108999'
			)
			and services_code in ('4172')
			group by coa, coa_desc
			order by coa
		  ";
	
		$query 	= $this->db->query($sql);
        return $query;  
	}

	function getkk_beban_bersama_pend_final($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbgz = "";
		}

			$sql = "select  sum(nvl(sfpb_grp.AMOUNT_POSITIF,0)) am_positif
						, sum(nvl(sfpb_grp.AMOUNT_NEGATIF,0)) am_negatif
					from (select srbpb.kode_akun
								, srbpb.akun_description
								, srbpb.kode_jasa
							from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
						where srbpb.tahun_pajak = ".($tahundari)."
							and srbpb.bulan_pajak between ".$bulandari." and ".$bulanke."
							and kode_akun like '7%'
							and kode_jasa is not null
							".$wcbgz."
						group by srbpb.kode_akun, srbpb.akun_description, srbpb.kode_jasa) srbpb_grp
						, (select kode_akun,kode_jasa,kode_jasa_description
								, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif
							from SIMTAX_FISKAL_PPH_BADAN sfpb
							where sfpb.tahun_pajak = ".($tahundari)."
							and kode_akun like '7%'
							and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
							and kode_jasa is not null
						group by kode_akun,kode_jasa,kode_jasa_description) sfpb_grp 
				where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
					and srbpb_grp.kode_jasa = sfpb_grp.kode_jasa (+)
				order by srbpb_grp.kode_akun, srbpb_grp.kode_jasa";	
        $query 	= $this->db->query($sql);
        return $query;
	}

	function getkk_beban_bersama_jml_omset($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbgz = "and branch_code = '".$cabang."'";
		} else {
			$wcbgz = "";
		}

			$sql = "select nvl(sum(jml701+jml702+jml703+jml704+jml705+jml706+jml707+jml708),0) jml_omset
			from 
			(
			select 
			(
				select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
				from simtax_tb_v
				where coa like '708%'
				and period_year = ".$tahundari."
				and period_num between ".$bulandari." and ".$bulanke."
				".$wcbgz."
				) jml708,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '707%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml707,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '706%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml706,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '705%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml705,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '704%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml704,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '703%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml703,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '702%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml702,
			(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
			from simtax_tb_v
			where coa like '701%'
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulanke."
			".$wcbgz."
			) jml701
			from dual
			) a";	
        $query 	= $this->db->query($sql);
        return $query;
	}

	function getkk_pajak_kini_piutang_komersil($bulandari,$bulanke,$tahundari,$cabang,$akun)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbgz = "";
		}

			$sql = "select srbpb_grp.JML_URAIAN, srbpb_grp.kode_akun
							  from (select srbpb.kode_akun
										 , srbpb.akun_description
										 , (sum(nvl(srbpb.debit,0) - nvl(srbpb.credit,0))) + max(begin_balance) jml_uraian
									 from SIMTAX_RINCIAN_BL_PPH_BADAN srbpb
									where srbpb.tahun_pajak =  ".$tahundari."
									  and srbpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									  and kode_akun like '80104%'
									  ".$wcbgz."
									group by srbpb.tahun_pajak, srbpb.kode_akun, srbpb.akun_description) srbpb_grp
								 , (select kode_akun, tahun_pajak
									  from SIMTAX_FISKAL_PPH_BADAN sfpb
									 where sfpb.tahun_pajak = ".$tahundari."
									   and kode_akun like '80104%'
									   and bulan_pajak is not null
									   and sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
								 group by kode_akun,tahun_pajak) sfpb_grp 
							where srbpb_grp.kode_akun = sfpb_grp.kode_akun (+)
							order by srbpb_grp.kode_akun";					
        $query 	= $this->db->query($sql);
        return $query;
	}
	
	function get_kk_beban_bonus($bulandari,$bulanke,$tahundari,$cabang,$nama_cabang)
    {
		
		if ($cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and cabang = '".$nama_cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}

        $sql2 ="
			SELECT
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) 
				from simtax_tb_v
				where period_num between 1 and 12
					and period_year = '".$tahundari."'
					and coa in ('80101051')
				".$wcbg."
			) beban_bonus,
			(
				select sum(nvl(invoice_amount,0))
				from simtax_beban_bonus
				where 1=1
				and jenis_bonus = 'BONUS'
				and period_year = '".$tahundari."'
				".$wcbgz."
			) amount_bonus,
			(
				select sum(nvl(invoice_amount,0))
				from simtax_beban_bonus
				where 1=1
				and jenis_bonus = 'BONUS EX'
				and period_year = '".$tahundari."'
				".$wcbgz."
			) amount_bonus_ex
			from dual
		";
		$query 	= $this->db->query($sql2);
		return $query;
	}

	function get_kk_rekening7($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$queryExec_tujuh	= " select stv_grp.*
									, sfpb_grp.AMOUNT_POSITIF
									, sfpb_grp.AMOUNT_NEGATIF
									, nvl(stv_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(stv_grp.kode_akun,stv_grp.akun_description,'".$tahundari."',stv_grp.period_num) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
								from (select stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, stv.services_code kode_jasa
											, stv.services_desc jasa_description
											, decode('".$bulandari."','',0,stv.period_num) period_num
										from simtax_tb_v stv
									where stv.period_year = ".$tahundari."
										and period_num between ".$bulandari." and ".$bulandari."
										and coa like '".$vcoa."%'
										and coa not like '791%'
										and services_code is not null
									group by stv.coa, stv.coa_desc, stv.services_code, stv.services_desc,stv.period_num) stv_grp
									, (select kode_akun,kode_jasa,kode_jasa_description
											, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
											, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
										from SIMTAX_FISKAL_PPH_BADAN sfpb
										where sfpb.tahun_pajak = '".$tahundari."'
										and kode_akun like '".$vcoa."%'
										and kode_akun not like '791%'
										and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
										and kode_jasa is not null
									group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
							where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
								and stv_grp.kode_jasa = sfpb_grp.kode_jasa (+)
								and stv_grp.period_num = sfpb_grp.bulan_pajak (+)
								and stv_grp.kode_akun like '7%'
                                and stv_grp.kode_jasa in (
                                ".$vservcode."
								)
							order by stv_grp.kode_akun, stv_grp.kode_jasa								
							";													
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function get_kk_rekening8($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$queryExec_delapan	= " select stv_grp.*
									, sfpb_grp.AMOUNT_POSITIF
									, sfpb_grp.AMOUNT_NEGATIF
									, nvl(stv_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(stv_grp.kode_akun,stv_grp.akun_description,'".$tahundari."',stv_grp.period_num) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
								from (
									select stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, decode('".$bulandari."','',0,stv.period_num) period_num
										from simtax_tb_v stv
									where stv.period_year = ".$tahundari."
										and period_num between ".$bulandari." and ".$bulandari."
										and coa in (".$vcoa.")
										and coa not like '891%'
									group by stv.period_year, stv.coa, stv.coa_desc,decode('".$bulandari."','',0,stv.period_num)) stv_grp
									, (
										select kode_akun
											, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
											, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
										from SIMTAX_FISKAL_PPH_BADAN sfpb
										where sfpb.tahun_pajak = '".$tahundari."'
										and kode_akun in (".$vcoa.")
										and kode_akun not like '891%'
										and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
									group by kode_akun,tahun_pajak, decode('".$bulandari."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
								and stv_grp.period_num = sfpb_grp.bulan_pajak (+)
							order by stv_grp.kode_akun								
							";							
			$query 		= $this->db->query($queryExec_delapan);
			return $query;
	}

	function get_kk_rekening791($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$queryExec_tujuh	= " select stv_grp.*
									, sfpb_grp.AMOUNT_POSITIF
									, sfpb_grp.AMOUNT_NEGATIF
									, nvl(stv_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(stv_grp.kode_akun,stv_grp.akun_description,'".$tahundari."',stv_grp.period_num) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
								from (
									select stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, decode('".$bulandari."','',0,stv.period_num) period_num
										from simtax_tb_v stv
									where stv.period_year = ".$tahundari."
										and period_num between ".$bulandari." and ".$bulandari."
										and coa in (".$vcoa.")
									group by stv.period_year, stv.coa, stv.coa_desc,decode('".$bulandari."','',0,stv.period_num)) stv_grp
									, (
										select kode_akun
											, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
											, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
										from SIMTAX_FISKAL_PPH_BADAN sfpb
										where sfpb.tahun_pajak = '".$tahundari."'
										and kode_akun in (".$vcoa.")
										and bulan_pajak is not null
										and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
									group by kode_akun,tahun_pajak, decode('".$bulandari."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
								and stv_grp.period_num = sfpb_grp.bulan_pajak (+)
							order by stv_grp.kode_akun								
							";							
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function get_kk_rek8_without891($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$queryExec_delapan	= " select stv_grp.*
									, sfpb_grp.AMOUNT_POSITIF
									, sfpb_grp.AMOUNT_NEGATIF
									, nvl(stv_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(stv_grp.kode_akun,stv_grp.akun_description,'".$tahundari."',stv_grp.period_num) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
								from (
									select stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, decode('".$bulandari."','',0,stv.period_num) period_num
										from simtax_tb_v stv
									where stv.period_year = ".$tahundari."
										and period_num between ".$bulandari." and ".$bulandari."
										and coa in (".$vcoa.")
									group by stv.period_year, stv.coa, stv.coa_desc,decode('".$bulandari."','',0,stv.period_num)) stv_grp
									, (
										select kode_akun
											, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
											, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
										from SIMTAX_FISKAL_PPH_BADAN sfpb
										where sfpb.tahun_pajak = '".$tahundari."'
										and kode_akun in (".$vcoa.")
										and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
									group by kode_akun,tahun_pajak, decode('".$bulandari."','',0,sfpb.bulan_pajak)) sfpb_grp 
							where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
								and stv_grp.period_num = sfpb_grp.bulan_pajak (+)
							order by stv_grp.kode_akun								
							";							
			$query 		= $this->db->query($queryExec_delapan);
			return $query;
	}

	function get_kk_rek7_without791($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$queryExec_tujuh	= " select stv_grp.*
									, sfpb_grp.AMOUNT_POSITIF
									, sfpb_grp.AMOUNT_NEGATIF
									, nvl(stv_grp.JML_URAIAN,0) + simtax_pajak_utility_pkg.getBegBalPusPel(stv_grp.kode_akun,stv_grp.akun_description,'".$tahundari."',stv_grp.period_num) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0) SPT
								from (select stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, stv.services_code kode_jasa
											, stv.services_desc jasa_description
											, decode('".$bulandari."','',0,stv.period_num) period_num
										from simtax_tb_v stv
									where stv.period_year = ".$tahundari."
										and period_num between ".$bulandari." and ".$bulandari."
										and coa like '".$vcoa."%'
										and services_code is not null
									group by stv.coa, stv.coa_desc, stv.services_code, stv.services_desc,stv.period_num) stv_grp
									, (select kode_akun,kode_jasa,kode_jasa_description
											, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
											, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
										from SIMTAX_FISKAL_PPH_BADAN sfpb
										where sfpb.tahun_pajak = '".$tahundari."'
										and kode_akun like '".$vcoa."%'
										and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
										and kode_jasa is not null
									group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
							where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
								and stv_grp.kode_jasa = sfpb_grp.kode_jasa (+)
								and stv_grp.period_num = sfpb_grp.bulan_pajak (+)
								and stv_grp.kode_akun like '7%'
                                and stv_grp.kode_jasa in (
                                ".$vservcode."
								)
							order by stv_grp.kode_akun, stv_grp.kode_jasa								
							";										
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function get_kk_coa_parent7($bulandari="",$tahundari="")
	{
		$sql_parent = " select stv.coa
						from simtax_tb_v stv
						where stv.period_year = ".$tahundari."
							and period_num between ".$bulandari." and ".$bulandari."
							and coa like '7%'
							and coa not like '791%'
							and services_code is not null
						group by stv.coa
						order by coa";
		
		$qParent     	= $this->db->query($sql_parent);
		return $qParent;
		
	}

	function get_kk_aset_beban_final($bulandari="",$tahundari="",$cabang)
	{
		$sql= "select nvl(sum(pembebanan),0) pembebanan
		from simtax_rekon_fixed_asset
		where kode_cabang = '".$cabang."' and tahun_pajak  = ".$tahundari." 
		and bulan_pajak between ".$bulandari." and ".$bulandari."
		and kelompok_fixed_asset in ('B','N')";
		
		$qsql     	= $this->db->query($sql);
		return $qsql;
		
	}

	function get_kk_pph_by_akun($bulandari="",$tahundari="",$vcoa,$vservcode)
	{
		$sql= "select (sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0))) + (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
		from simtax_tb_v stv
		where stv.period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulandari."
			and coa in (".$vcoa.")";
		
		$qsql     	= $this->db->query($sql);
		return $qsql;
		
	}

	function getDataByAkunByCabang($bulandari,$bulanke,$tahundari,$akun,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
        $sql ="
		select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) as jumlah
		from simtax_tb_v
			where period_num between ".$bulandari." and ".$bulanke."
			and period_year = ".($tahundari)."
			and coa in (".$akun.")
			".$wcbg."
		"; 
		$query 	= $this->db->query($sql);
        return $query;
	}

	function getDataAmortisasiAsset($bulandari,$bulanke,$tahundari,$akun,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
		} else {
			$wcbg = "";
		}
        $sql ="
		select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) as jumlah
		from simtax_tb_v
			where period_num between ".$bulandari." and ".$bulanke."
			and period_year = ".($tahundari)."
			and coa in (".$akun.")
			".$wcbg."
			and coa_desc not like '%ATDK%' and (coa_desc not like '%tanah%' or coa_desc not like '%Tanah%')
		"; 
		$query 	= $this->db->query($sql);
        return $query;
	}

	function get_kk_cabang()
	{
		$sql= "select KODE_CABANG,NAMA_CABANG
		from SIMTAX_KODE_CABANG 
		where AKTIF = 'Y'";
		
		$qsql     	= $this->db->query($sql);
		return $qsql;
		
	}


	function get_kk_parent_rekening7($akun)
	{
		$sql_parent = " select ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ffv.FLEX_VALUE like '".$akun."'||'%000'";
		
		$qParent     	= $this->db->query($sql_parent);
		return $qParent;
		
	}

	function get_kk_parent_rekening7_2($akun)
	{
		$sql_parent = " select ffvt.DESCRIPTION
						  from fnd_flex_values ffv
							 , fnd_flex_values_tl ffvt
							 , fnd_flex_value_sets ffvs
						where ffv.flex_value_id = ffvt.flex_value_id     
						  and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
						  and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
						  and ffv.FLEX_VALUE like '".substr($akun,0,3)."'||'%000'";
						  
		$qParent     	= $this->db->query($sql_parent);		
		
		return $qParent;
	}

	function action_get_period()
	{
		$tahun		= $this->input->post('tahun');					
		$queryExec	= "Select NAMA_PAJAK, TAHUN_PAJAK from SIMTAX_UBUPOT_PH_LAIN 					
					   where tahun_pajak ='".$tahun."' ";
		//return $queryExec;
		$query = $this->db->query($queryExec);   
		if($query){			
			return true;
		} else {
			return false;
		}		
	}

	function getpph222325($bulandari,$bulanke,$tahundari,$cabang)
    {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}

        $sql ="
		SELECT
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 22
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_22,
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 23
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_23,
		(
			select nvl(sum(jumlah_potong),0) 
						from simtax_ubupot_ph_lain 
						where nama_pajak= 25
                        and masa_pajak between ".$bulandari." and ".$bulanke."
						and tahun_pajak = ".($tahundari)."
						".$wcbgz."
		) as pph_25
            from dual";
  
        $query 		= $this->db->query($sql);
        return $query;
    }

	function get_kk_rek7_final($bulandari="",$bulanke="",$tahundari="",$vcoa,$vservcode)
	{
			$queryExec_tujuh = "
								select stv_grp.kode_akun
								, stv_grp.akun_description
								, stv_grp.kode_jasa
								, stv_grp.jasa_description
								, stv_grp.jml_uraian
								--, nvl((stv_grp.jml_uraian + stv_grp.spt - sfpb_grp.AMOUNT_POSITIF - sfpb_grp.AMOUNT_NEGATIF),0) spt
								, (nvl(stv_grp.jml_uraian,0) + nvl(stv_grp.spt,0) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0)) spt
								, nvl(sfpb_grp.AMOUNT_POSITIF,0) amount_positif
								, nvl(sfpb_grp.AMOUNT_NEGATIF,0) amount_negatif
								
								from (
										select 
											stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
											, stv.services_code kode_jasa
											, stv.services_desc jasa_description
											,(
												select sum(nvl(begin_balance,0))
												from simtax_rincian_bl_pph_badan srb
												where srb.kode_akun = stv.coa
												and srb.kode_jasa = stv.services_code
												and srb.tahun_pajak = '".$tahundari."'
												and srb.bulan_pajak between ".$bulandari." and ".$bulanke."
											) spt
										from simtax_tb_v stv
										where 1=1
											and period_num between ".$bulandari." and ".$bulanke."
											and period_year = '".$tahundari."'
											and coa like '".$vcoa."%'
											and coa not like '791%'
											and services_code is not null
											and coa like '7%'
											and services_code in (
												".$vservcode."
												--select distinct services_code
												--from simtax_tb_v
												--where coa = ".$vcoa."
												--and period_year = ".$tahundari."
												--and period_num between ".$bulandari." and ".$bulanke."
												--and coa not like '791%'
												--and services_code is not null
												--and coa like '7%'
											)
										group by stv.coa, stv.coa_desc, stv.services_code, stv.services_desc
									) stv_grp
								, (select kode_akun,kode_jasa,kode_jasa_description
										, sum(amount_positif) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
										, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
									from SIMTAX_FISKAL_PPH_BADAN sfpb
									where  sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									and sfpb.tahun_pajak = '".$tahundari."'
									and kode_akun like '".$vcoa."%'
									and kode_akun not like '791%'
									and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
									and kode_jasa is not null
								group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
						where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
							and stv_grp.kode_jasa = sfpb_grp.kode_jasa (+)
						order by stv_grp.kode_akun, stv_grp.kode_jasa											
			";
			//var_dump($queryExec_tujuh);die();		
			$query 		= $this->db->query($queryExec_tujuh);
			return $query;
	}

	function get_kk_rek8_final($bulandari="",$bulanke="",$tahundari="",$vcoa,$vservcode)
	{	
			$queryExec_delapan = "
								select stv_grp.kode_akun
								, stv_grp.akun_description
								, stv_grp.jml_uraian
								, (nvl(stv_grp.jml_uraian,0) + nvl(stv_grp.spt,0) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0)) spt
								, nvl(sfpb_grp.AMOUNT_POSITIF,0) amount_positif
								, nvl(sfpb_grp.AMOUNT_NEGATIF,0) amount_negatif
								from (
										select 
											stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
												,(
												select sum(nvl(begin_balance,0))
												from simtax_rincian_bl_pph_badan srb
												where srb.kode_akun = stv.coa
												and srb.tahun_pajak = '".$tahundari."'
												and srb.bulan_pajak between ".$bulandari." and ".$bulanke."
											) spt
										from simtax_tb_v stv
										where 1=1
											and period_num between ".$bulandari." and ".$bulanke."
											and period_year = '".$tahundari."'
											and coa in (".$vcoa.")
											and coa not like '891%'
											and coa like '8%'
										group by stv.coa, stv.coa_desc
									) stv_grp
								, (select kode_akun,kode_jasa,kode_jasa_description
										, nvl(sum(amount_positif),0) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
										, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
									from SIMTAX_FISKAL_PPH_BADAN sfpb
									where  sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									and sfpb.tahun_pajak = '".$tahundari."'
									and kode_akun in (".$vcoa.")
									and kode_akun not like '891%'
									and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
								group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
						where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
						order by stv_grp.kode_akun											
			";
			
			$query 		= $this->db->query($queryExec_delapan);
			return $query;
	}

	function get_kk_rek791($bulandari="",$bulanke="",$tahundari="",$vcoa,$vservcode)
	{	
			$queryExec_delapan = "
								select stv_grp.kode_akun
								, stv_grp.akun_description
								, stv_grp.jml_uraian
								, (nvl(stv_grp.jml_uraian,0) + nvl(stv_grp.spt,0) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0)) spt
								, nvl(sfpb_grp.AMOUNT_POSITIF,0) amount_positif
								, nvl(sfpb_grp.AMOUNT_NEGATIF,0) amount_negatif
								from (
										select 
											stv.coa kode_akun
											, stv.coa_desc akun_description
											, (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
												,(
												select sum(nvl(begin_balance,0))
												from simtax_rincian_bl_pph_badan srb
												where srb.kode_akun = stv.coa
												and srb.tahun_pajak = '".$tahundari."'
												and srb.bulan_pajak between ".$bulandari." and ".$bulanke."
											) spt
										from simtax_tb_v stv
										where 1=1
											and period_num between ".$bulandari." and ".$bulanke."
											and period_year = '".$tahundari."'
											and coa in (".$vcoa.")
										group by stv.coa, stv.coa_desc
									) stv_grp
								, (select kode_akun,kode_jasa,kode_jasa_description
										, nvl(sum(amount_positif),0) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
										, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
									from SIMTAX_FISKAL_PPH_BADAN sfpb
									where  sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
									and sfpb.tahun_pajak = '".$tahundari."'
									and kode_akun in (".$vcoa.")
									and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
								group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
						where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
						order by stv_grp.kode_akun											
			";
			
			$query 		= $this->db->query($queryExec_delapan);
			return $query;
	}

	function rincian_obligasi($tahundari) {
		$sqlrincianobl = "
						select coa || ' ' || coa_desc as akun,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 1
							) as januari,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 2
							) as februari,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 3
							) as maret,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 4
							) as april,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 5
							) as mei,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 6
							) as juni,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 7
							) as juli,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 8
							) as agustus,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 9
							) as september,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 10
							) as oktober,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 11
							) as november,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 12
							) as desember
							from simtax_tb_v a
							where period_year = '".$tahundari."'
							and coa in (
								select distinct coa
								from simtax_tb_v
								where coa like '1019%'
							)
							group by coa, coa_desc
							order by coa asc	
							--and coa in ('10191101','10191102','10191121','10191132','10191133','10191141','10191152','10191161','10191153','10191164',
							--	'10191181','10191982','10191987','10191988','10191991','10191999','10201101','10201121','10201141','10201999','20103501')
						
		 ";

		 $query 		= $this->db->query($sqlrincianobl);
		 return $query;
	}

	function rincian_obligasi2($tahundari) {
		$sqlrincianobl = "select coa as kode_akun, coa_desc as akun_description,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 1
		) as januari,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 2
		) as februari,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 3
		) as maret,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 4
		) as april,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 5
		) as mei,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 6
		) as juni,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 7
		) as juli,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 8
		) as agustus,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 9
		) as september,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 10
		) as oktober,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 11
		) as november,
		(
			select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
			  from simtax_tb_v z
			  where z.coa = a.coa
			  and period_year = '".$tahundari."'
			  and period_num = 12
		) as desember
		  from simtax_tb_v a
		where period_year = '".$tahundari."'
		and coa in ('40601101','40601102')
		group by coa, coa_desc
		order by coa asc";
		$query 		= $this->db->query($sqlrincianobl);
		 return $query;

	}

	function summ_rincian_obligasi($tahundari) {
		$sqlrincianobl = "
						select (nvl(sum(januari),0) + nvl(sum(februari),0) + nvl(sum(maret),0) + nvl(sum(april),0) + nvl(sum(mei),0) + nvl(sum(juni),0) 
						+ nvl(sum(juli),0) + nvl(sum(agustus),0) + nvl(sum(september),0) + nvl(sum(oktober),0) + nvl(sum(november),0) + nvl(sum(desember),0)) total_rincian
						from (
						select 
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 1
							) as januari,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 2
							) as februari,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 3
							) as maret,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 4
							) as april,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 5
							) as mei,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 6
							) as juni,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 7
							) as juli,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 8
							) as agustus,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 9
							) as september,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 10
							) as oktober,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 11
							) as november,
							(
								select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
								from simtax_tb_v z
								where z.coa = a.coa
								and period_year = '".$tahundari."'
								and period_num = 12
							) as desember
							from simtax_tb_v a
							where period_year = '".$tahundari."'
							and coa in (
								select distinct coa
								from simtax_tb_v
								where coa like '1019%'
							)
							group by coa, coa_desc
							order by coa asc
							--and coa in ('10191101','10191102','10191121','10191132','10191133','10191141','10191152','10191161','10191153','10191164',
							--	'10191181','10191982','10191987','10191988','10191991','10191999','10201101','10201121','10201141','10201999','20103501')
						)
		 ";

		 $query 		= $this->db->query($sqlrincianobl);
		 return $query;
	}

	function summ_utang_obligasi($tahundari) {
		$sqlrincianobl = "
					select (nvl(sum(januari),0) + nvl(sum(februari),0) + nvl(sum(maret),0) + nvl(sum(april),0) + nvl(sum(mei),0) + nvl(sum(juni),0) 
					+ nvl(sum(juli),0) + nvl(sum(agustus),0) + nvl(sum(september),0) + nvl(sum(oktober),0) + nvl(sum(november),0) + nvl(sum(desember),0)) utang_obligasi
					from (
					select 
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 1
						) as januari,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 2
						) as februari,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 3
						) as maret,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 4
						) as april,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 5
						) as mei,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 6
						) as juni,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 7
						) as juli,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 8
						) as agustus,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 9
						) as september,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 10
						) as oktober,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 11
						) as november,
						(
							select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) + nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
							from simtax_tb_v z
							where z.coa = a.coa
							and period_year = '".$tahundari."'
							and period_num = 12
						) as desember
						from simtax_tb_v a
						where period_year = '".$tahundari."'
						and coa in ('40601101','40601102')
						group by coa, coa_desc
						order by coa asc
					)
		 ";

		 $query 		= $this->db->query($sqlrincianobl);
		 return $query;
	}

	function summ_beban_obligasi($bulandari, $bulanke, $tahundari) {
		$sqlbebanobl = "
			select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) JML_BEBAN_OBLIGASI
			from simtax_tb_v z
			where coa = '89101162'
			and period_year = '".$tahundari."'
			and period_num between ".$bulandari." and ".$bulanke
		;
		$query 		= $this->db->query($sqlbebanobl);
		 return $query;

	}

	function get_kk_final_bonus($bulandari,$bulanke,$tahundari,$cabang)
    {
		$nama_cabang ="";
		if ($cabang != "all") 
		{
			$sql = "select KODE_CABANG,NAMA_CABANG
				  from SIMTAX_KODE_CABANG 
				  where AKTIF = 'Y' ";
				  if ($cabang != 'all') {
						$sql .= " and kode_cabang = '".$cabang."'";
				  }
			$result = $this->db->query($sql);
			foreach($result->result_array() as $row) 
			{
				$nama_cabang = $row['NAMA_CABANG'];
			}
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and cabang = '".$nama_cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}

        $sql2 ="
			SELECT
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) 
				from simtax_tb_v
				where period_num between ".$bulandari." and ".$bulanke."
					and period_year = '".$tahundari."'
					and coa in ('80101051')
				".$wcbg."
			) beban_bonus,
			(
				select sum(nvl(invoice_amount,0))
				from simtax_beban_bonus
				where 1=1
				and jenis_bonus = 'BONUS'
				and period_year = '".$tahundari."'
				".$wcbgz."
			) amount_bonus,
			(
				select sum(nvl(invoice_amount,0))
				from simtax_beban_bonus
				where 1=1
				and jenis_bonus = 'BONUS EX'
				and period_year = '".$tahundari."'
				".$wcbgz."
			) amount_bonus_ex
			from dual
		";
		$query 	= $this->db->query($sql2);
		return $query;
	}

	function get_kk_final_tantiem($tahundari){

		$sql = "select jumlah_tantiem
			  from SIMTAX_BEBAN_TANTIEM 
			where tahun = ".$tahundari."
			ORDER BY divisi";
		$query 	= $this->db->query($sql);
		return $query;	
	
	}
	
	function get_kk_final_bbn_tantiem($bulandari,$bulanke,$tahundari){
		$sql = "select sum(nvl(period_net_dr,0) - nvl(period_net_cr,0)) as jml_beban_tantiem
				from SIMTAX_TB_V
				where coa = '80101071'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari;
		$query 	= $this->db->query($sql);
		return $query;
	}

	function autokoreksimappgl($bulandari,$bulanke,$tahundari){
		$sql = "select stv_grp.kode_akun
				, stv_grp.akun_description
				, stv_grp.jml_uraian
				, (nvl(stv_grp.jml_uraian,0) + nvl(stv_grp.spt,0) - nvl(sfpb_grp.AMOUNT_POSITIF,0) - nvl(sfpb_grp.AMOUNT_NEGATIF,0)) spt
				, nvl(sfpb_grp.AMOUNT_POSITIF,0) amount_positif
				, nvl(sfpb_grp.AMOUNT_NEGATIF,0) amount_negatif
				from (
						select 
							stv.coa kode_akun
							, stv.coa_desc akun_description
							, (sum(nvl(stv.period_net_dr,0) - nvl(stv.period_net_cr,0))) jml_uraian
								,(
								select sum(nvl(begin_balance,0))
								from simtax_rincian_bl_pph_badan srb
								where srb.kode_akun = stv.coa
								and srb.tahun_pajak = '".$tahundari."'
								and srb.bulan_pajak between ".$bulandari." and ".$bulanke."
							) spt
						from simtax_tb_v stv
						where 1=1
							and period_num between ".$bulandari." and ".$bulanke."
							and period_year = '".$tahundari."'
							and coa in ('80101012',
									'80102191',
									'80105999',
									'80106999',
									'80107104',
									'80107105',
									'80107106',
									'80107107',
									'80107999',
									'80108011',
									'80108041',
									'80108061',
									'80108121',
									'80108191',
									'80108999',
									'89101221',
									'89101162',
									'89101194',
									'89101916',
									'89101201',
									'89199999',
									'80108227'
									)
							
						group by stv.coa, stv.coa_desc
					) stv_grp
				, (select kode_akun,kode_jasa,kode_jasa_description
						, nvl(sum(amount_positif),0) amount_positif, sum(amount_negatif) amount_negatif, tahun_pajak
						, decode('".$bulandari."','',0,sfpb.bulan_pajak) bulan_pajak
					from SIMTAX_FISKAL_PPH_BADAN sfpb
					where  sfpb.bulan_pajak between ".$bulandari." and ".$bulanke."
					and sfpb.tahun_pajak = '".$tahundari."'
					and kode_akun in ('80101012',
									'80102191',
									'80105999',
									'80106999',
									'80107104',
									'80107105',
									'80107106',
									'80107107',
									'80107999',
									'80108011',
									'80108041',
									'80108061',
									'80108121',
									'80108191',
									'80108999',
									'89101221',
									'89101162',
									'89101194',
									'89101916',
									'89101201',
									'89199999',
									'80108227')
					and decode('".$bulandari."','',0,sfpb.bulan_pajak) = decode('".$bulandari."','',0,'".$bulandari."')
				group by kode_akun,kode_jasa,kode_jasa_description,bulan_pajak,tahun_pajak) sfpb_grp 
		where stv_grp.kode_akun = sfpb_grp.kode_akun (+)
		order by stv_grp.kode_akun";
		$query 	= $this->db->query($sql);
		return $query;
	}

	function akumulasipenyasset($bulandari, $bulanke, $tahundari){
		$sqlakasset = "select
		(jml2110 + jml2120 + jml2130 + jml2140 + jml2150 + jml2160) vjmlpenyasset
		from
		(
		select
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2110%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2110,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2120%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2120,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2130%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2130,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2140%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2140,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2150%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2150,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2160%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2160
			from dual
		)
		";
		$query 	= $this->db->query($sqlakasset);
		return $query;
	}

	function akumulasipenyamor($bulandari, $bulanke, $tahundari){
		$sqlakasset = "select
		(jml2180 + jml2190 + jml2199) vjmlpenyamor
		from
		(
		select
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2180%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2180,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '2190%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2190,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)
				from simtax_tb_v
				where coa like '21999999%'
				and period_num between ".$bulandari." and ".$bulanke."
				and period_year = ".$tahundari."
			) jml2199
			from dual
		)
		";
		$query 	= $this->db->query($sqlakasset);
		return $query;
	}

	function getkkkinitangguhan($bulandari, $bulanke, $tahundari,$cabang){
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}
		$sqlfa = "
			select 
				(
					select nvl(sum(harga_perolehan),0)
						from simtax_rekon_fixed_asset
						where 1=1 ".$wcbgz." and tahun_pajak <= ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke." 
						and kelompok_fixed_asset = 'B'
				) as nilaibangunan,
				(
					select nvl(sum(harga_perolehan),0)
						from simtax_rekon_fixed_asset
						where 1=1 ".$wcbgz." and tahun_pajak  <= ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
						and kelompok_fixed_asset = 'N'
				) as nilainonbangunan,
				(
					select nvl(sum(harga_perolehan),0)
						from simtax_rekon_fixed_asset
						where 1=1 ".$wcbgz." and tahun_pajak >= ".($tahundari+1)." and bulan_pajak between ".$bulandari." and ".$bulanke." 
						and kelompok_fixed_asset = 'B'
				) as nilaibangunan2,
				(
					select nvl(sum(harga_perolehan),0)
						from simtax_rekon_fixed_asset
						where 1=1 ".$wcbgz." and tahun_pajak  >= ".($tahundari+1)." and bulan_pajak between ".$bulandari." and ".$bulanke."
						and kelompok_fixed_asset = 'N'
				) as nilainonbangunan2,
				(
					select nvl(sum(akumulasi_penyusutan),0)
					from simtax_rekon_fixed_asset
					where 1=1 ".$wcbgz." and tahun_pajak  <= ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
					and kelompok_fixed_asset in ('B','N')
				) as akpenyberwujud,
				(
					select nvl(sum(akumulasi_penyusutan),0)
					from simtax_rekon_fixed_asset
					where 1=1 ".$wcbgz." and tahun_pajak  >= ".($tahundari+1)." and bulan_pajak between ".$bulandari." and ".$bulanke."
					and kelompok_fixed_asset in ('B','N')
				) as akpenyberwujud2,
				(
					select nvl(sum(harga_perolehan),0)
					from simtax_rekon_fixed_asset
					where 1=1 ".$wcbgz." and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
					and kelompok_fixed_asset = 'T'
					) as nilaitidakberwujud,
					0 as bebanditangguhkan
					from dual
		";

		$query 	= $this->db->query($sqlfa);
		return $query;
	}

	function pymadtangguhan($bulandari, $bulanke, $tahundari){
		$sqlakpymad = "select sum(jml_uraian) deslast
		from(
		select (abs(begbal)-(mutasi)) jml_uraian
		from (
		select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
		(
		select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
			from simtax_tb_v a
			where 1=1
			and period_year = ".$tahundari."
			and period_num between ".$bulandari." and ".$bulandari."
			and a.coa = stv.coa
		) begbal
		from simtax_tb_v stv
		where coa in ('11301101'
							,'11301111'
							,'11302101'
							,'11302110'
							,'11302111',                                
							'11303101',                                    
							'11303107',                              
							'11303110',                                     
							'11303111',                               
							'11304101',                                   
							'11304102',                               
							'11304104',                                 
							'11304107',                               
							'11304110',                                    
							'11304111',                               
							'11304113',                                  
							'11305101',                                  
							'11305110',                                 
							'11305111',                                 
							'11499999',                                   
							'11501101',                                          
							'11601101',                                       
							'11699999')
		and period_num between ".$bulandari." and ".$bulanke."
		and period_year = ".$tahundari."
		group by coa, coa_desc
		)
		)";
		$query 	= $this->db->query($sqlakpymad);
		return $query;
	}

	function getkktgghnakunt2($bulandari,$bulanke,$tahundari,$cabang) {
		if ($cabang && $cabang != "all") 
		{
			$wcbg = "and branch_code = '".$cabang."'";
			$wcbgz = "and kode_cabang = '".$cabang."'";
		} else {
			$wcbg = "";
			$wcbgz = "";
		}
		$sql ="
			SELECT
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) 
				from simtax_tb_v
				where period_num between ".$bulandari." and ".$bulanke."
					and period_year <= ".$tahundari."
					and coa like '2%' 
					and coa not in ('20205101','20305101','20505101','20725101')
					".$wcbg."
			) as hrg_perolehan_akuntansi,
			(        
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
				from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
					and period_year <= ".$tahundari."
					and coa between '21201103' and '21604102'
					".$wcbg."
			) as ak_pnysutan_akuntansi,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) 
				from simtax_tb_v
				where period_num between ".$bulandari." and ".$bulanke."
					and period_year >= ".($tahundari+1)."
					and coa like '2%' 
					and coa not in ('20205101','20305101','20505101','20725101')
					".$wcbg."
			) as hrg_perolehan_akun_nyear,
			(        
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
				from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
					and period_year >= ".($tahundari+1)."
					and coa between '21201103' and '21604102'
					".$wcbg."
			) as ak_pnysutan_akun_nyear,
			(
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0) 
				from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
					and period_year = ".$tahundari."
					and coa between '20801101' and '20999999'
					".$wcbg."
			) as hrg_perolehan_atb_akuntansi,
			(        
				--select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
				--from simtax_tb_v
				--	where period_num between ".$bulandari." and ".$bulanke."
				--	and period_year = ".$tahundari."
				--	and coa between '21801101' and '21999999'
				--	".$wcbg."
				select nvl(sum(akumulasi_penyusutan),0)
				from simtax_rekon_fixed_asset
				where 1=1 ".$wcbgz." and tahun_pajak  = ".$tahundari." and bulan_pajak between ".$bulandari." and ".$bulanke."
				and kelompok_fixed_asset in ('T')
			) as ak_pnysutan_atb_akuntansi,
			(        
				select nvl(sum(nvl(period_net_dr,0)-nvl(period_net_cr,0)),0)  
				from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
					and period_year = ".$tahundari."
					and coa between '11301101' and '11699999'
					".$wcbg."
			) as ak_pnysutan_pymad_akuntansi,
			(        
				select sum(jml_uraian) 
						from(
						select (abs(begbal)-(mutasi)) jml_uraian
						from (
						select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
						(
						select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
							from simtax_tb_v a
							where 1=1
							and period_year = ".$tahundari."
							and period_num between ".$bulandari." and ".$bulandari."
							and a.coa = stv.coa
						) begbal
						from simtax_tb_v stv
						where coa in ('40701101')
						and period_num between ".$bulandari." and ".$bulanke."
						and period_year = ".$tahundari."
						".$wcbg."
						group by coa, coa_desc
						)
					)
			) as k_manfaat_karyawan,
			(
				select nvl(sum(jumlah_potong),0) 
							from simtax_ubupot_ph_lain 
							where nama_pajak= 22
							and masa_pajak between ".$bulandari." and ".$bulanke."
							and tahun_pajak = ".$tahundari."
							".$wcbgz."
			) as pph_22,
			(
				select nvl(sum(jumlah_potong),0) 
							from simtax_ubupot_ph_lain 
							where nama_pajak= 23
							and masa_pajak between ".$bulandari." and ".$bulanke."
							and tahun_pajak = ".$tahundari."
							".$wcbgz."
			) as pph_23,
			(
				select nvl(sum(jumlah_potong),0) 
							from simtax_ubupot_ph_lain 
							where nama_pajak= 25
							and masa_pajak between ".$bulandari." and ".$bulanke."
							and tahun_pajak = ".$tahundari."
							".$wcbgz."
			) as pph_25
				from dual";

			$query 	= $this->db->query($sql);
			return $query;	
		}

		function getkktgghnfiskal2($bulandari,$bulanke,$tahundari,$cabang)
		{
			if ($cabang && $cabang != "all") 
			{
				$wcbg = "and branch_code = '".$cabang."'";
				$wcbgz = "and kode_cabang = '".$cabang."'";
			} else {
				$wcbg = "";
				$wcbgz = "";
			}
			$sql ="
				SELECT 
				--nvl(sum(nvl(hp_b,0)+nvl(hp_nb,0)),0) as hrg_perolehan_fiskal, 
				hrg_perolehan_fiskal, hrg_perolehan_fis_nyear,
				ak_nb, ak_nb_nyear, hrg_p_tdkberwujud,
				ak_tdk_berwujud
				from 
				(
				select 
				(
					select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
					from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
						and period_year <= ".$tahundari."
						and coa like '2%' 
						and coa not in ('20205101','20305101','20505101','20725101')
						".$wcbg."
				) as hrg_perolehan_fiskal,
				(
					select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
					from simtax_tb_v
					where period_num between ".$bulandari." and ".$bulanke."
						and period_year >= ".($tahundari+1)."
						and coa like '2%' 
						and coa not in ('20205101','20305101','20505101','20725101')
						".$wcbg."
				) as hrg_perolehan_fis_nyear,
				(
				select nvl(sum(harga_perolehan),0)
								from simtax_rekon_fixed_asset
								where bulan_pajak between ".$bulandari." and ".$bulanke." 
								and tahun_pajak = ".$tahundari."  
								and kelompok_fixed_asset = 'B'
								".$wcbgz." 
				) as hp_b,              
				(              
				select nvl(sum(harga_perolehan),0)
								from simtax_rekon_fixed_asset
								where bulan_pajak between ".$bulandari." and ".$bulanke."
								and tahun_pajak  = ".$tahundari." 
								and kelompok_fixed_asset = 'N'
								".$wcbgz."
				) as hp_nb,
				(
				select nvl(sum(akumulasi_penyusutan_fiskal),0)
								from simtax_rekon_fixed_asset
								where bulan_pajak between ".$bulandari." and ".$bulanke."
								and tahun_pajak  <= ".$tahundari."
								and kelompok_fixed_asset in ('B','N')
								".$wcbgz."
				) as ak_nb,
				(
					select nvl(sum(akumulasi_penyusutan_fiskal),0)
									from simtax_rekon_fixed_asset
									where bulan_pajak between ".$bulandari." and ".$bulanke."
									and tahun_pajak  >= ".($tahundari+1)."
									and kelompok_fixed_asset in ('B','N')
									".$wcbgz."
				) as ak_nb_nyear,
				(
					select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0) 
					from simtax_tb_v
						where period_num between ".$bulandari." and ".$bulanke."
						and period_year = ".$tahundari."
						and coa between '20801101' and '20999999'
						".$wcbg."
				) as hrg_p_tdkberwujud,
				(        
					--select nvl(sum(nvl(begin_balance_dr,0)-nvl(begin_balance_cr,0)),0)  
					--from simtax_tb_v
					--	where period_num between ".$bulandari." and ".$bulanke."
					--	and period_year = ".$tahundari."
					--	and coa between '21801101' and '21999999'
					--	".$wcbg."
					select nvl(sum(akumulasi_penyusutan),0)
							from simtax_rekon_fixed_asset
							where  bulan_pajak between ".$bulandari." and ".$bulanke."
							and tahun_pajak  = ".$tahundari."
							and kelompok_fixed_asset in ('T')
							".$wcbgz."
				) as ak_tdk_berwujud
				from dual
				) group by hp_b, hp_nb, ak_nb, ak_nb_nyear, hrg_p_tdkberwujud, ak_tdk_berwujud, hrg_perolehan_fiskal, hrg_perolehan_fis_nyear
			";

			$query 	= $this->db->query($sql);
			return $query;	

		}

		function getNewDataByAkun($bulandari,$bulanke,$tahundari,$akun,$cabang) {
			if ($cabang && $cabang != "all") 
			{
				$wcbg = "and branch_code = '".$cabang."'";
				$wcbgz = "and kode_cabang = '".$cabang."'";
			} else {
				$wcbg = "";
				$wcbgz = "";
			}
			$sql ="select sum(jml_uraian) jumlah
					from(
					select (abs(begbal)-(mutasi)) jml_uraian
					from (
					select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
					(
					select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
						from simtax_tb_v a
						where 1=1
						and period_year = ".$tahundari."
						and period_num between ".$bulandari." and ".$bulandari."
						and a.coa = stv.coa
					) begbal
					from simtax_tb_v stv
					where coa in ('".$akun."')
					and period_num between ".$bulandari." and ".$bulanke."
					and period_year = ".$tahundari."
					".$wcbg."
					group by coa, coa_desc
					)
				)
			";
			
		$query 	= $this->db->query($sql);
		return $query;	
	}
	
}