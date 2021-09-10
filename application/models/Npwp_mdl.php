<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Npwp_mdl extends CI_Model
{
    public $table = 'SIMTAX_MASTER_NPWP';
    public $column_order = array(null,null,'STATUS_KSWP', 'NPWP_SIMTAX', 'NPWP','NAMA','MERK_DAGANG','ALAMAT','KELURAHAN','KECAMATAN', 'KABKOT', 'PROVINSI', 'KODE_KLU', 'KLU', 'TELP', 'EMAIL', 'JENIS_WP', 'BADAN_HUKUM', 'USER_TYPE'); //set column field database for datatable orderable
    public $column_search = array('NPWP','NAMA','MERK_DAGANG','ALAMAT','KELURAHAN','KECAMATAN', 'KABKOT', 'PROVINSI', 'KODE_KLU', 'KLU', 'TELP', 'EMAIL', 'JENIS_WP', 'BADAN_HUKUM', 'STATUS_KSWP', 'USER_TYPE', 'NPWP_SIMTAX'); //set column field database for datatable searchable
    public $order = array('ID' => 'DESC'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                } //close bracket
            }
            $i++;
        }
         
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        if (isset($_POST['status_kswp'])) {
            $status_kswp = $_POST['status_kswp'];
            if ($status_kswp && $status_kswp != 'SEMUA') {
                $this->db->where('STATUS_KSWP', $status_kswp);
            }
        }
        if (isset($_POST['user_type'])) {
            $user_type = $_POST['user_type'];
            if ($user_type && $user_type != 'SEMUA') {
                $this->db->where('USER_TYPE', $user_type);
            }
        }
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_datatables_all()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_data_demo($status, $limit, $user_type)
    {
        $this->db->from('SIMTAX_MASTER_NPWP');
        if ($user_type == 'SUPPLIER') {
            $this->db->join('SIMTAX_MASTER_SUPPLIER', 'SIMTAX_MASTER_SUPPLIER.NPWP = SIMTAX_MASTER_NPWP.NPWP_SIMTAX', 'left');
            $this->db->join('SIMTAX_KODE_CABANG', 'SIMTAX_KODE_CABANG.ORGANIZATION_ID = SIMTAX_MASTER_SUPPLIER.ORGANIZATION_ID', 'left');
        } else {
            $this->db->join('SIMTAX_MASTER_PELANGGAN', 'SIMTAX_MASTER_PELANGGAN.NPWP = SIMTAX_MASTER_NPWP.NPWP_SIMTAX', 'left');
            $this->db->join('SIMTAX_KODE_CABANG', 'SIMTAX_KODE_CABANG.ORGANIZATION_ID = SIMTAX_MASTER_PELANGGAN.ORGANIZATION_ID', 'left');
        }
        $this->db->where('STATUS_KSWP', $status);
        $this->db->where('USER_TYPE', $user_type);
        $this->db->where('SIMTAX_KODE_CABANG.NAMA_CABANG IS NOT NULL');
        $this->db->where('SIMTAX_MASTER_NPWP.NAMA !=', '-');
        $this->db->where('SIMTAX_MASTER_NPWP.NPWP_SIMTAX !=', '80.431.638.8.027.000');
        $this->db->where('SIMTAX_MASTER_NPWP.NPWP_SIMTAX !=', '83.556.876.7.432.000');
        $this->db->where('SIMTAX_MASTER_NPWP.NPWP_SIMTAX !=', '80.586.816.3.403.000');
        $this->db->where('SIMTAX_MASTER_NPWP.NPWP_SIMTAX !=', '80.438.564.9.072.000');
        $this->db->where('SIMTAX_MASTER_NPWP.NPWP_SIMTAX !=', '01.000.521.3-093.000');
        // $this->db->group_by('SIMTAX_MASTER_NPWP.NPWP_SIMTAX');
        $this->db->limit($limit, 0);
        $res = $this->db->get();
        return $res->result();
    }

    public function get_status_kswp()
    {
        $this->db->from('SIMTAX_MASTER_NPWP');
        $this->db->select('STATUS_KSWP');
        $this->db->group_by('STATUS_KSWP');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_type()
    {
        $this->db->from('SIMTAX_MASTER_NPWP');
        $this->db->select('USER_TYPE');
        $this->db->group_by('USER_TYPE');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_npwp_validasi()
    {
        $this->db->from($this->table);
        if (isset($_POST['status_kswp'])) {
            $status_kswp = $_POST['status_kswp'];
            if ($status_kswp && $status_kswp != 'SEMUA') {
                $this->db->where('STATUS_KSWP', $status_kswp);
            }
        }
        if (isset($_POST['user_type'])) {
            $user_type = $_POST['user_type'];
            if ($user_type && $user_type != 'SEMUA') {
                $this->db->where('USER_TYPE', $user_type);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }
}
