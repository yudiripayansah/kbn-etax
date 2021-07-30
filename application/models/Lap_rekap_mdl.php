
<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Lap_rekap_mdl extends CI_Model {
	
  public function __construct() {
      parent::__construct();
  }

  function get_rekap_pdd_jkpjg($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
      } else {
            $vcabang = "";
      }
      $sql= "select 
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40506101')
                
                ) jkpjg_tanah,
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40506102')
                
                ) jkpjg_bangunan,
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40507101')
                
                ) jkpjg_rupa_usaha,
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40599101')
                
                ) jkpjg_sewa_tanah,
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40599102')
                
                ) jkpjg_danapart_pt,
                (
                select 
                    abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
                        from simtax_tb_v stv
                        where 1=1
                            ".$vcabang."
                            and stv.period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulanke."
                            and coa in ('40599104')
                
                ) jkpjg_danapart_nt
                from dual
        ";
      
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pdd_jkpjg_all($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
           
      $queryExec	= "
                        select  
                                q_master.coa
                            , q_master.coa_desc
                            , q_master.jml_uraian
                            , nvl(q_pendapatan.sendiri,0) sendiri
                            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
                            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
                            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
                        from    
                        ( select coa, coa_desc, (abs(begbal)-(mutasi)) jml_uraian
                        from (
                        select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                        (
                        select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                            from simtax_tb_v a
                            where 1=1
                            ".$vcabang."
                            and period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulandari."
                            and a.coa = stv.coa
                        ) begbal
                        from simtax_tb_v stv
                        where coa like '405%'
                        ".$vcabang."
                        and period_num between ".$bulandari." and ".$bulanke."
                        and period_year = ".$tahun."
                        group by coa, coa_desc
                        ) order by coa asc ) q_master
                        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                      from simtax_pajak_headers sph
                      inner join simtax_pajak_lines spl
                          on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                          INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                       and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
                       and sph.tahun_pajak = '".$tahun."'
                       AND SPL.IS_CHEKLIST = '1'
					   ".$qcabangsph."
                       and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                      and substr(spl.akun_pajak,0,3) = '405'
                       --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                       )
                       PIVOT (SUM (dpp*1)
                             FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.coa = q_pendapatan.akun_pajak (+)
                    order by 1
                    ";                       
                    $query 	= $this->db->query($queryExec);
                    return $query;                        

}

  function get_rekap_ppn_jkpjg($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $qcabangsrb = " and kode_cabang = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = ".$cabang;
      } else {
            $vcabang = "";
      }
    $queryExec	= "select
                        q_master.kode_akun
                    , q_master.kode_akun || '00000' akun
                    , q_master.description_akun
                    , q_master.balance
                    , q_pendapatan.sendiri
                    , q_pendapatan.oleh_pemungut
                    , q_pendapatan.dibebaskan
                    , q_pendapatan.bukan_ppn
                    from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                            (select ffvt.DESCRIPTION
                    from fnd_flex_values ffv
                    , fnd_flex_values_tl ffvt
                    , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id     
                    and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                    and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                    and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                    FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                    WHERE SUBSTR (kode_akun, 0, 3) = '405'
                    and bulan_pajak between '".$bulandari."' and '".$bulanke."'
                    and tahun_pajak = '".$tahun."'
                    ".$qcabangsrb."
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                        , spl.dpp
                        , case
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                            else NULL
                            end kode_faktur
                    from simtax_pajak_headers sph
                    inner join simtax_pajak_lines spl
                        on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                    and sph.bulan_pajak between '".$bulanfrom."' and '".$bulanto."'
                    and sph.tahun_pajak = '".$tahun."'
                    AND SPL.IS_CHEKLIST = '1'
                    ".$qcabangsph."
                    and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                    and substr(spl.akun_pajak,0,3) = '405'
                    --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                    )
                    PIVOT (SUM (dpp*1)
                        FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1";
                    $query 	= $this->db->query($queryExec);
                    return $query;           
  }

  function get_rekap_pdd_jkpdk($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
      } else {
            $vcabang = "";
      }
      $sql= "select 
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31102102')
      
      ) jkpdk_lapangan_penumpukan,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31102104')
      
      ) jkpdk_kontribusi_lapangan,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31102103')
      
      ) jkpdk_gudang_penumpukan,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31106101')
      
      ) jkpdk_tanah,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31106102')
      
      ) jkpdk_bangunan,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31106104')
      
      ) jkpdk_air,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31107101')
      
      ) jkpdk_rupa_usaha,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31199999')
      
      ) jkpdk_lainnya,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31199102')
      
      ) jkpdk_danaparts_pt,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31199101')
      
      ) jkpdk_sewatanah_ys,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31199104')
      
      ) jkpdk_danaparts_nt,
      (
      select 
          abs((sum(nvl(stv.begin_balance_dr,0) - nvl(stv.begin_balance_cr,0)))) jml_uraian
            from simtax_tb_v stv
            where 1=1
                ".$vcabang."
                and stv.period_year = ".$tahun."
                and period_num between ".$bulandari." and ".$bulanke."
                and coa in ('31701101')
      
      ) jkpdk_deviden_afiliasi
      from dual
        ";
      
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pdd_jkpdk_all($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }

         $queryExec	= "
                        select  
                            q_master.coa
                            , q_master.coa_desc
                            , q_master.jml_uraian
                            , nvl(q_pendapatan.sendiri,0) sendiri
                            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
                            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
                            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
                        from  
                        ( select coa, coa_desc, (abs(begbal)-(mutasi)) jml_uraian
                        from (
                        select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                        (
                        select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                            from simtax_tb_v a
                            where 1=1
                            ".$vcabang."
                            and period_year = ".$tahun."
                            and period_num between ".$bulandari." and ".$bulandari."
                            and a.coa = stv.coa
                        ) begbal
                        from simtax_tb_v stv
                        where coa like '311%'
                        ".$vcabang."
                        and period_num between ".$bulandari." and ".$bulanke."
                        and period_year = ".$tahun."
                        group by coa, coa_desc
                        ) order by coa asc ) q_master
                        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
                           , spl.dpp
                           , case
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                               when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                               else NULL
                               end kode_faktur
                            from simtax_pajak_headers sph
                            inner join simtax_pajak_lines spl
                                on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                                INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                            where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                            and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
                            and sph.tahun_pajak = '".$tahun."'
                            AND SPL.IS_CHEKLIST = '1'
                            ".$qcabangsph."
                            and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                            and substr(spl.akun_pajak,0,3) = '311'
                            --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
                            )
                            PIVOT (SUM (dpp*1)
                                    FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                            where q_master.coa = q_pendapatan.akun_pajak (+)
                            order by 1
                    ";                                            
                    $query 	= $this->db->query($queryExec);
                    return $query;                        

}

  function get_rekap_ppn_jkpdk($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $qcabangsrb = " and kode_cabang = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = ".$cabang;
      } else {
            $vcabang = "";
      }
    $queryExec	= "select
                     q_master.kode_akun
                    , q_master.kode_akun || '00000' akun
                    , q_master.description_akun
                    , q_master.balance
                    , q_pendapatan.sendiri
                    , q_pendapatan.oleh_pemungut
                    , q_pendapatan.dibebaskan
                    , q_pendapatan.bukan_ppn
                    from 
                    (  SELECT SUBSTR (kode_akun, 0, 3) kode_akun,
                            (select ffvt.DESCRIPTION
                    from fnd_flex_values ffv
                    , fnd_flex_values_tl ffvt
                    , fnd_flex_value_sets ffvs
                    where ffv.flex_value_id = ffvt.flex_value_id     
                    and ffvs.FLEX_VALUE_SET_ID = ffv.FLEX_VALUE_SET_ID
                    and ffvs.FLEX_VALUE_SET_NAME = 'PI2_ACCOUNT'
                    and ffv.FLEX_VALUE like SUBSTR (kode_akun, 0, 3) || '00000') description_akun,
                                SUM (NVL (debit, 0)*-1) - SUM (NVL (credit, 0)*-1) balance
                    FROM SIMTAX_RINCIAN_BL_PPH_BADAN
                    WHERE SUBSTR (kode_akun, 0, 3) = '311'
                    and bulan_pajak between '".$bulandari."' and '".$bulanke."'
                    and tahun_pajak = '".$tahun."'
                    ".$qcabangsrb."
                    GROUP BY SUBSTR (kode_akun, 0, 3)) q_master
                    ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select substr(spl.akun_pajak,0,3) akun_pajak
                        , spl.dpp
                        , case
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
                            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
                            else NULL
                            end kode_faktur
                    from simtax_pajak_headers sph
                    inner join simtax_pajak_lines spl
                        on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
                        INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
                    where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
                    and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
                    and sph.tahun_pajak = '".$tahun."'
                    AND SPL.IS_CHEKLIST = '1'
                    ".$qcabangsph."
                    and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
                    and substr(spl.akun_pajak,0,3) = '311'
                    )
                    PIVOT (SUM (dpp*1)
                        FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
                    where q_master.kode_akun = q_pendapatan.akun_pajak (+)
                    order by 1";
                    $query 	= $this->db->query($queryExec);
                    return $query;           
  }

  function get_rekap_pymad_kapal($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
        $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in ('11101101',
                  '11101102',
                  '11101103',
                  '11101104',
                  '11101105',
                  '11101199',
                  '11101201',
                  '11101202',
                  '11101303',
                  '11101304')
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_barang($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11102101',
                    '11102102',
                    '11102103',
                    '11102106',
                    '11102199'                    
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_peralatan($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
     
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11103111',
                    '11103141'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_plyn_terminal($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11104101',
                    '11104999',
                    '11104102'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_petikemas($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11104103',
                    '11104104',
                    '11104105',
                    '11104106',
                    '11104111',
                    '11105101',
                    '11105102',
                    '11105999'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_tbal($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11106101',
                    '11106102',
                    '11106103',
                    '11106999'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_rupa($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11107111',
                    '11107121',
                    '11199999',
                    '11107999'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";

      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }

  function get_rekap_pymad_berelasi($cabang,$bulandari,$bulanke,$tahun)
  {
      $vcabang = "";
      if ($cabang != "all"){
            $vcabang = " and branch_code = ".$cabang;
            $qcabangsph = " and sph.kode_cabang = '".$cabang."'";
      } else {
            $vcabang = "";
            $qcabangsph = "";
      }
      
      $sql= "select 
            q_master.coa
            , q_master.coa_desc      
            , nvl(q_master.jml_uraian,0) jml_uraian
            , nvl(q_pendapatan.sendiri,0) sendiri
            , nvl(q_pendapatan.oleh_pemungut,0) oleh_pemungut
            , nvl(q_pendapatan.dibebaskan,0) dibebaskan
            , nvl(q_pendapatan.bukan_ppn,0) bukan_ppn
        from     
        (
          select coa, coa_desc, jml_uraian
          from(
              select coa, coa_desc, (abs(begbal)+(mutasi)) jml_uraian
              from (		
                  select coa, coa_desc, (sum(nvl(stv.period_net_dr,0)) - sum(nvl(stv.period_net_cr,0))) mutasi,
                  (
                  select (sum(nvl(a.begin_balance_dr,0) -nvl(a.begin_balance_cr,0)))
                      from simtax_tb_v a
                      where 1=1
                      ".$vcabang."
                      and period_year = ".$tahun."
                      and period_num between ".$bulandari." and ".$bulandari."
                      and a.coa = stv.coa
                  ) begbal
                  from simtax_tb_v stv
                  where 1=1
                  ".$vcabang."
                  and stv.period_year = ".$tahun."
                  and period_num between ".$bulandari." and ".$bulanke."
                  and coa in (
                    '11107201',
                    '11107251',
                    '11108101',
                    '11108103',
                    '11108104',
                    '11108105',
                    '11108106',
                    '11108107',
                    '11108110',
                    '11108112',
                    '11108114',
                    '11108115',
                    '11108116',
                    '11108117'
                  )
                  group by coa, coa_desc
              )
          ) order by coa asc
        ) q_master
        ,(select akun_pajak, sendiri, oleh_pemungut, dibebaskan, bukan_ppn from (select spl.akun_pajak
        , spl.dpp
        , case
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('1','4','6','9'))  then 'Sendiri'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI IN ('2','3'))  then 'oleh_pemungut'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '7')  then 'bukan_ppn'
            when sph.nama_pajak = 'PPN KELUARAN' AND (SPL.KD_JENIS_TRANSAKSI = '8')  then 'dibebaskan'
            else NULL
            end kode_faktur
         from simtax_pajak_headers sph
         inner join simtax_pajak_lines spl
             on SPH.PAJAK_HEADER_ID = SPL.PAJAK_HEADER_ID
             INNER JOIN SIMTAX_MASTER_PERIOD SMP ON SPH.PERIOD_ID = SMP.PERIOD_ID
         where sph.nama_pajak in ('PPN MASUKAN','PPN KELUARAN')
         and sph.bulan_pajak between '".$bulandari."' and '".$bulanke."'
         and sph.tahun_pajak = '".$tahun."'
         AND SPL.IS_CHEKLIST = '1'
         ".$qcabangsph."
         and (SPL.NO_FAKTUR_PAJAK is not null or SPL.NO_DOKUMEN_LAIN is not null)
         and substr(spl.akun_pajak,0,3) = '111'
         --group by spl.akun_pajak, substr(nvl(SPL.NO_FAKTUR_PAJAK, SPL.NO_DOKUMEN_LAIN),0,2)
         )
         PIVOT (SUM (dpp*1)
                 FOR kode_faktur IN ('Sendiri' AS sendiri, 'oleh_pemungut' AS oleh_pemungut,'dibebaskan' AS dibebaskan,'bukan_ppn' AS bukan_ppn))) q_pendapatan
         where q_master.coa = q_pendapatan.akun_pajak (+)
         order by 1 ";
      $qsql     	= $this->db->query($sql);
      return $qsql;
      
  }


}




