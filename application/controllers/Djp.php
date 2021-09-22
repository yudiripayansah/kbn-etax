<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Djp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('djp');
        $this->load->model('Npwp_mdl');
        $this->load->model('ppn_masa_mdl', 'ppn_masa');
    }

    public function get_master_npwp()
    {
        $list = $this->Npwp_mdl->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key=>$npwp) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="check['.$npwp->ID.']" data-row-no="'.$key.'" class="checkbox-npwp">';
            $row[] = $no;
            $row[] = $npwp->STATUS_KSWP;
            $row[] = $npwp->NPWP_SIMTAX;
            $row[] = $npwp->NPWP;
            $row[] = $npwp->NAMA;
            $row[] = $npwp->MERK_DAGANG;
            $row[] = $npwp->ALAMAT;
            $row[] = $npwp->KELURAHAN;
            $row[] = $npwp->KECAMATAN;
            $row[] = $npwp->KABKOT;
            $row[] = $npwp->PROVINSI;
            $row[] = $npwp->KODE_KLU;
            $row[] = $npwp->KLU;
            $row[] = $npwp->TELP;
            $row[] = $npwp->EMAIL;
            $row[] = $npwp->JENIS_WP;
            $row[] = $npwp->BADAN_HUKUM;
            $row[] = $npwp->USER_TYPE;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Npwp_mdl->count_all(),
                        "recordsFiltered" => $this->Npwp_mdl->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function get_npwp_validasi()
    {
        $data = $this->Npwp_mdl->get_npwp_validasi($status_kswp, $user_type);
        $response = array(
            'data' => $data,
            'status' => true
        );
        echo json_encode($response);
    }

    public function get_master_npwp_demo()
    {
        $list_1 = $this->Npwp_mdl->get_data_demo('VALID', 5, 'SUPPLIER');
        $list_2 = $this->Npwp_mdl->get_data_demo('NOT VALID', 5, 'SUPPLIER');
        $list_3 = $this->Npwp_mdl->get_data_demo('VALID', 5, 'PELANGGAN');
        $list_4 = $this->Npwp_mdl->get_data_demo('NOT VALID', 5, 'PELANGGAN');
        $data = array();
        $no = $_POST['start'];
        foreach ($list_2 as $npwp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $npwp->NPWP_SIMTAX;
            $row[] = $npwp->NPWP;
            $row[] = $npwp->NAMA;
            $row[] = $npwp->NAMA_CABANG;
            $row[] = $npwp->MERK_DAGANG;
            $row[] = $npwp->ALAMAT;
            $row[] = $npwp->KELURAHAN;
            $row[] = $npwp->KECAMATAN;
            $row[] = $npwp->KABKOT;
            $row[] = $npwp->PROVINSI;
            $row[] = $npwp->KODE_KLU;
            $row[] = $npwp->KLU;
            $row[] = $npwp->TELP;
            $row[] = $npwp->EMAIL;
            $row[] = $npwp->JENIS_WP;
            $row[] = $npwp->BADAN_HUKUM;
            $row[] = $npwp->STATUS_KSWP;
            $row[] = $npwp->USER_TYPE;
            $row[] = '';
            $data[] = $row;
        }
        foreach ($list_4 as $npwp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $npwp->NPWP_SIMTAX;
            $row[] = $npwp->NPWP;
            $row[] = $npwp->NAMA;
            $row[] = $npwp->NAMA_CABANG;
            $row[] = $npwp->MERK_DAGANG;
            $row[] = $npwp->ALAMAT;
            $row[] = $npwp->KELURAHAN;
            $row[] = $npwp->KECAMATAN;
            $row[] = $npwp->KABKOT;
            $row[] = $npwp->PROVINSI;
            $row[] = $npwp->KODE_KLU;
            $row[] = $npwp->KLU;
            $row[] = $npwp->TELP;
            $row[] = $npwp->EMAIL;
            $row[] = $npwp->JENIS_WP;
            $row[] = $npwp->BADAN_HUKUM;
            $row[] = $npwp->STATUS_KSWP;
            $row[] = $npwp->USER_TYPE;
            $row[] = '';
            $data[] = $row;
        }
        foreach ($list_1 as $npwp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $npwp->NPWP_SIMTAX;
            $row[] = $npwp->NPWP;
            $row[] = $npwp->NAMA;
            $row[] = $npwp->NAMA_CABANG;
            $row[] = $npwp->MERK_DAGANG;
            $row[] = $npwp->ALAMAT;
            $row[] = $npwp->KELURAHAN;
            $row[] = $npwp->KECAMATAN;
            $row[] = $npwp->KABKOT;
            $row[] = $npwp->PROVINSI;
            $row[] = $npwp->KODE_KLU;
            $row[] = $npwp->KLU;
            $row[] = $npwp->TELP;
            $row[] = $npwp->EMAIL;
            $row[] = $npwp->JENIS_WP;
            $row[] = $npwp->BADAN_HUKUM;
            $row[] = $npwp->STATUS_KSWP;
            $row[] = $npwp->USER_TYPE;
            $row[] = '';
            $data[] = $row;
        }
        foreach ($list_3 as $npwp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $npwp->NPWP_SIMTAX;
            $row[] = $npwp->NPWP;
            $row[] = $npwp->NAMA;
            $row[] = $npwp->NAMA_CABANG;
            $row[] = $npwp->MERK_DAGANG;
            $row[] = $npwp->ALAMAT;
            $row[] = $npwp->KELURAHAN;
            $row[] = $npwp->KECAMATAN;
            $row[] = $npwp->KABKOT;
            $row[] = $npwp->PROVINSI;
            $row[] = $npwp->KODE_KLU;
            $row[] = $npwp->KLU;
            $row[] = $npwp->TELP;
            $row[] = $npwp->EMAIL;
            $row[] = $npwp->JENIS_WP;
            $row[] = $npwp->BADAN_HUKUM;
            $row[] = $npwp->STATUS_KSWP;
            $row[] = $npwp->USER_TYPE;
            $row[] = '';
            $data[] = $row;
        }
        $res = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => 20,
            'recordsFiltered'=> 20,
            'data' => $data
        );
        echo json_encode($res);
    }

    public function supplier()
    {
        $condition = $this->input->post('condition');
        $supplier = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_SUPPLIER WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result();
        $res = array(
            'status' => true,
            'data' => $supplier
        );
        echo json_encode($res);
    }

    public function pelanggan()
    {
        $condition = $this->input->post('condition');
        $pelanggan = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_PELANGGAN WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result();
        $res = array(
            'status' => true,
            'data' => $pelanggan
        );
        echo json_encode($res);
    }

    public function npwp()
    {
        $npwp = $this->input->post('npwp');
        $condition = $this->input->post('condition');
        $type = $this->input->post('type');
        $data = $this->db->select('NPWP_SIMTAX AS NPWP')->from('SIMTAX_MASTER_NPWP');
        switch ($condition) {
            case 'KSWP NULL':
                $data->where('STATUS_KSWP IS NULL');
                break;
            case 'KSWP NOT VALID':
                $data->where('STATUS_KSWP', 'NOT VALID');
                break;
            case 'KSWP -':
                $data->where('STATUS_KSWP', '-');
                break;
            case 'NAMA -':
                $data->where('NAMA', '-');
                break;
            case 'NAMA - AND KSWP NULL':
                $data->where('STATUS_KSWP IS NULL')->where('NAMA', '-');
                break;
            case 'NAMA - AND KSWP NOT VALID':
                $data->where('STATUS_KSWP', 'NOT VALID')->where('NAMA', '-');
                break;
            case 'NAMA - AND KSWP -':
                $data->where('STATUS_KSWP', '-')->where('NAMA', '-');
                break;
        }
        switch ($type) {
            case 'supplier':
                $data->like('USER_TYPE', 'SUPPLIER');
                break;
            case 'pelanggan':
                $data->like('USER_TYPE', 'PELANGGAN');
                break;
        }
        $data = $data->get()->result_array();
        if ($type == 'semua' || $type == 'supplier') {
            $supplier = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_SUPPLIER WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
            $countSpp = 0;
            foreach ($supplier as $spp) {
                $existspp = false;
                foreach ($data as $dt) {
                    if ($dt['NPWP'] == $spp['NPWP']) {
                        $existspp = true;
                    }
                }
                if (!$existspp) {
                    $countSpp++;
                    array_push($data, $spp);
                }
            }
        }
        if ($type == 'semua' || $type == 'pelanggan') {
            $pelanggan = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_PELANGGAN WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
            $countPlg = 0;
            foreach ($pelanggan as $plg) {
                $existplg = false;
                foreach ($data as $dt) {
                    if ($dt['NPWP'] == $plg['NPWP']) {
                        $existplg = true;
                    }
                }
                if (!$existplg) {
                    $countPlg++;
                    array_push($data, $plg);
                }
            }
        }
        $res = array(
            'status' => true,
            'data' => $data,
            'newSupplier' => $countSpp,
            'newPelanggan' => $countPlg,
        );
        echo json_encode($res);
    }

    public function checkDjp()
    {
        $token = $this->input->post('token');
        if (!$token) {
            $getToken = djp_get_token('pelindo2', 'Cvn0fj2489');
            $token = $getToken->message;
        }
        $npwp = trim(preg_replace('/[^0-9]/', '', $this->input->post('npwp')));
        $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
        $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
        $npwp_djp = null;
        $kswp_djp = null;
        $type = '';
        if ($check_npwp < 1 && $npwp) {
            $isSupplier = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $this->input->post('npwp'))->limit(1)->get()->row();
            $isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $this->input->post('npwp'))->limit(1)->get()->row();
            if ($isSupplier) {
                $type = 'SUPPLIER';
            }
            if ($isCustomer) {
                if ($type == '') {
                    $type = 'CUSTOMER';
                } else {
                    $type .= ', CUSTOMER';
                }
            }
            $npwp_djp = djp_check_npwp($token, $npwp);
            if ($npwp_djp->message == 'Token tidak valid') {
                $getToken = djp_get_token('pelindo2', 'Cvn0fj2489');
                $token = $getToken->message;
                $npwp_djp = djp_check_npwp($token, $npwp);
            }
            $kswp_djp = djp_check_kswp($token, $npwp);
            $dataWp = $npwp_djp->message->datawp;
            $status_kswp = '-';
            if ($kswp_djp->status == 200) {
                $status_kswp = $kswp_djp->message->status;
            }
            $rowData = array(
                'ID' => ($latest_npwp->ID+1),
                'NPWP' => $npwp,
                'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
                'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
                'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
                'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
                'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
                'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
                'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
                'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
                'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
                'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
                'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
                'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
                'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
                'STATUS_KSWP' => $status_kswp,
                'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
                'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
                'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
                'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
                'USER_TYPE' => $type,
                'NPWP_SIMTAX' => $this->input->post('npwp'),
                'LAST_UPDATE' => date('Y-m-d H:i:s'),
            );
            $doInsert = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
        } else {
            $isSupplier = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $this->input->post('npwp'))->limit(1)->get()->row();
            $isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $this->input->post('npwp'))->limit(1)->get()->row();
            if ($isSupplier) {
                $type = 'SUPPLIER';
            }
            if ($isCustomer) {
                if ($type == '') {
                    $type = 'CUSTOMER';
                } else {
                    $type .= ', CUSTOMER';
                }
            }
            $npwp_simtax = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->get()->row();
            $npwp_djp = djp_check_npwp($token, $npwp);
            if ($npwp_djp->message == 'Token tidak valid') {
                $getToken = djp_get_token('pelindo2', 'Cvn0fj2489');
                $token = $getToken->message;
                $npwp_djp = djp_check_npwp($token, $npwp);
            }
            $kswp_djp = djp_check_kswp($token, $npwp);
            $dataWp = $npwp_djp->message->datawp;
            $status_kswp = '-';
            if ($kswp_djp->status == 200) {
                $status_kswp = $kswp_djp->message->status;
            }
            $rowData = array(
                'NPWP' => $npwp,
                'NAMA' => ($dataWp->NAMA) ? $dataWp->NAMA : '-',
                'MERK_DAGANG' => ($dataWp->MERK_DAGANG) ? $dataWp->MERK_DAGANG : '-',
                'ALAMAT' => ($dataWp->ALAMAT) ? $dataWp->ALAMAT : '-',
                'KELURAHAN' => ($dataWp->KELURAHAN) ? $dataWp->KELURAHAN : '-',
                'KECAMATAN' => ($dataWp->KECAMATAN) ? $dataWp->KECAMATAN : '-',
                'KABKOT' => ($dataWp->KABKOT) ? $dataWp->KABKOT : '-',
                'PROVINSI' => ($dataWp->PROVINSI) ? $dataWp->PROVINSI : '-',
                'KODE_KLU' => ($dataWp->KODE_KLU) ? (int) $dataWp->KODE_KLU : 0,
                'KLU' => ($dataWp->KLU) ? $dataWp->KLU : '-',
                'TELP' => ($dataWp->TELP) ? $dataWp->TELP : '-',
                'EMAIL' => ($dataWp->EMAIL) ? $dataWp->EMAIL : '-',
                'JENIS_WP' => ($dataWp->JENIS_WP) ? $dataWp->JENIS_WP : '-',
                'BADAN_HUKUM' => ($dataWp->BADAN_HUKUM) ? $dataWp->BADAN_HUKUM : '-',
                'STATUS_KSWP' => $status_kswp,
                'RESPONSE_MSG_NPWP' => json_encode($npwp_djp->message),
                'RESPONSE_MSG_KSWP' => json_encode($kswp_djp->message),
                'RESPONSE_STATUS_CODE_NPWP' => ($npwp_djp->status) ? (int) $npwp_djp->status : 0,
                'RESPONSE_STATUS_CODE_KSWP' => ($kswp_djp->status) ? (int) $kswp_djp->status : 0,
                'USER_TYPE' => $type,
                'NPWP_SIMTAX' => $this->input->post('npwp'),
                'LAST_UPDATE' => date('Y-m-d H:i:s'),
            );
            $doUpdate = $this->db->where('ID', $npwp_simtax->ID)->update('SIMTAX_MASTER_NPWP', $rowData);
        }
        $res = array(
            'kswp' => $kswp_djp,
            'npwp' => $npwp_djp,
            'latest' => $latest_npwp,
            'check_npwp' => $check_npwp,
            'token' => $token
        );
        echo json_encode($res);
    }

    public function updateNPWP()
    {
        $data = $this->db->from('SIMTAX_MASTER_NPWP')->get()->result();
        foreach ($data as $d) {
            $res = json_decode($d->RESPONSE_MSG_NPWP);
            $npwp_djp = ($res->datawp) ? $res->datawp->NPWP : '-';
            $update = array(
                'NPWP_DJP' => $npwp_djp
            );
            echo "UPDATE SIMTAX_MASTER_NPWP SET NPWP = '".$npwp_djp."' WHERE SIMTAX_MASTER_NPWP.ID = ".$d->ID.";<br>";
        }
    }

    public function deleteNpwp()
    {
        $data = $this->db->from('SIMTAX_MASTER_NPWP')->order_by('NPWP', 'DESC')->get()->result();
        $no = 1;
        foreach ($data as $key=>$d) {
            if ($data[$key-1]->NPWP == $d->NPWP && $d->NPWP != '-') {
                // echo $no.". DELETE FROM SIMTAX_MASTER_NPWP WHERE ID = ".$d->ID."; ".$d->NPWP." dan ".$data[$key-1]->NPWP."<br>";
                echo "DELETE FROM SIMTAX_MASTER_NPWP WHERE ID = ".$d->ID.";<br>";
                // $delete = $this->db->where('ID',$d->ID)->delete('SIMTAX_MASTER_NPWP');
                // echo var_dump($delete);
                $no++;
            }
        }
    }

    public function dataMaster()
    {
        $supplier = $this->db->from('SIMTAX_MASTER_PELANGGAN')->order_by('NPWP', 'DESC')->get()->result();
        foreach ($supplier as $key=>$spp) {
            if ($key > 85740) {
                $insert = (array) $spp;
                $insert['ID'] = $key+1;
                $insert['CUSTOMER_ID'] = (int) $insert['CUSTOMER_ID'];
                $insert['CUSTOMER_SITE_ID'] = (int) $insert['CUSTOMER_SITE_ID'];
                $insert['ORGANIZATION_ID'] = (int) $insert['ORGANIZATION_ID'];
                $insert['ADDRESS_LINE1'] = ($insert['ADDRESS_LINE1']) ? $insert['ADDRESS_LINE1'] : '-';
                unset($insert['RNUM']);
                foreach ($insert as $key=>$ins) {
                    $insert[$key]=($insert[$key]) ? $ins : null;
                }
                $doInsert = $this->db->insert('SIMTAX_MASTER_PELANGGAN_NEW', $insert);
            }
        }
    }

    public function syncNpwp()
    {
        $supplier = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_SUPPLIER WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
        // $pelanggan = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_PELANGGAN WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
        foreach ($supplier as $spp) {
            $npwp = trim(preg_replace('/[^0-9]/', '', $spp['NPWP']));
            $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
            if ($check_npwp < 1 && $npwp) {
                $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
                $rowData = array(
                    'ID' => ($latest_npwp->ID+1),
                    'NPWP' => $npwp,
                    'NAMA' => '-',
                    'MERK_DAGANG' => '-',
                    'ALAMAT' => '-',
                    'KELURAHAN' => '-',
                    'KECAMATAN' => '-',
                    'KABKOT' => '-',
                    'PROVINSI' => '-',
                    'KODE_KLU' => 0,
                    'KLU' => '-',
                    'TELP' => '-',
                    'EMAIL' => '-',
                    'JENIS_WP' => '-',
                    'BADAN_HUKUM' => '-',
                    'STATUS_KSWP' => '-',
                    'RESPONSE_MSG_NPWP' => '-',
                    'RESPONSE_MSG_KSWP' => '-',
                    'RESPONSE_STATUS_CODE_NPWP' => 0,
                    'RESPONSE_STATUS_CODE_KSWP' => 0,
                    'USER_TYPE' => 'SUPPLIER',
                    'NPWP_SIMTAX' => $spp['NPWP'],
                    'LAST_UPDATE' => date('Y-m-d H:i:s'),
                );
                $doInsert = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
                echo 'Belum ada = '.$spp['NPWP'].'-'.$npwp.'<br>';
            } else {
                echo 'Sudah ada = '.$spp['NPWP'].'-'.$npwp.'<br>';
            }
        }
    }

    public function syncNpwpPelanggan()
    {
        // $supplier = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_SUPPLIER WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
        $pelanggan = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_PELANGGAN WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result_array();
        foreach ($pelanggan as $spp) {
            $npwp = trim(preg_replace('/[^0-9]/', '', $spp['NPWP']));
            $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
            if ($check_npwp < 1 && $npwp) {
                $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
                $rowData = array(
                    'ID' => ($latest_npwp->ID+1),
                    'NPWP' => $npwp,
                    'NAMA' => '-',
                    'MERK_DAGANG' => '-',
                    'ALAMAT' => '-',
                    'KELURAHAN' => '-',
                    'KECAMATAN' => '-',
                    'KABKOT' => '-',
                    'PROVINSI' => '-',
                    'KODE_KLU' => 0,
                    'KLU' => '-',
                    'TELP' => '-',
                    'EMAIL' => '-',
                    'JENIS_WP' => '-',
                    'BADAN_HUKUM' => '-',
                    'STATUS_KSWP' => '-',
                    'RESPONSE_MSG_NPWP' => '-',
                    'RESPONSE_MSG_KSWP' => '-',
                    'RESPONSE_STATUS_CODE_NPWP' => 0,
                    'RESPONSE_STATUS_CODE_KSWP' => 0,
                    'USER_TYPE' => 'PELANGGAN',
                    'NPWP_SIMTAX' => $spp['NPWP'],
                    'LAST_UPDATE' => date('Y-m-d H:i:s'),
                );
                $doInsert = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
                echo 'Belum ada = '.$spp['NPWP'].'-'.$npwp.'<br>';
            } else {
                echo 'Sudah ada = '.$spp['NPWP'].'-'.$npwp.'<br>';
            }
        }
    }

    public function saveNpwp()
    {
        $npwp_simtax = $this->input->post('npwp_simtax');
        $npwp = $this->input->post('npwp');
        $res = $this->input->post('res');
        if (isset($res['message']['datawp'])) {
            $dataWp = $res['message']['datawp'];
            $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
            $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
            $type = '-';
            $isSupplier = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $npwp_simtax)->limit(1)->get()->row();
            $isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $npwp_simtax)->limit(1)->get()->row();
            if ($isSupplier) {
                $type = 'SUPPLIER';
            }
            if ($isCustomer) {
                if ($type == '-') {
                    $type = 'CUSTOMER';
                } else {
                    $type .= ', CUSTOMER';
                }
            }
            if (strlen($npwp) == 15) {
                if ($check_npwp< 1) {
                    $rowData = array(
                        'ID' => ($latest_npwp->ID+1),
                        'NPWP' => $npwp,
                        'NAMA' => ($dataWp['NAMA']) ? $dataWp['NAMA'] : '-',
                        'MERK_DAGANG' => ($dataWp['MERK_DAGANG']) ? $dataWp['MERK_DAGANG'] : '-',
                        'ALAMAT' => ($dataWp['ALAMAT']) ? $dataWp['ALAMAT'] : '-',
                        'KELURAHAN' => ($dataWp['KELURAHAN']) ? $dataWp['KELURAHAN'] : '-',
                        'KECAMATAN' => ($dataWp['KECAMATAN']) ? $dataWp['KECAMATAN'] : '-',
                        'KABKOT' => ($dataWp['KABKOT']) ? $dataWp['KABKOT'] : '-',
                        'PROVINSI' => ($dataWp['PROVINSI']) ? $dataWp['PROVINSI'] : '-',
                        'KODE_KLU' => ($dataWp['KODE_KLU']) ? (int) $dataWp['KODE_KLU'] : 0,
                        'KLU' => ($dataWp['KLU']) ? $dataWp['KLU'] : '-',
                        'TELP' => ($dataWp['TELP']) ? $dataWp['TELP'] : '-',
                        'EMAIL' => ($dataWp['EMAIL']) ? $dataWp['EMAIL'] : '-',
                        'JENIS_WP' => ($dataWp['JENIS_WP']) ? $dataWp['JENIS_WP'] : '-',
                        'BADAN_HUKUM' => ($dataWp['BADAN_HUKUM']) ? $dataWp['BADAN_HUKUM'] : '-',
                        'STATUS_KSWP' => '-',
                        'RESPONSE_MSG_NPWP' => json_encode($res['message']),
                        'RESPONSE_MSG_KSWP' => '-',
                        'RESPONSE_STATUS_CODE_NPWP' => ($res['status']) ? (int) $res['status'] : 0,
                        'RESPONSE_STATUS_CODE_KSWP' => 0,
                        'USER_TYPE' => $type,
                        'NPWP_SIMTAX' => $npwp_simtax,
                        'LAST_UPDATE' => date('Y-m-d H:i:s'),
                    );
                    $doSave = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
                } else {
                    $rowData = array(
                        'NPWP' => $npwp,
                        'NAMA' => ($dataWp['NAMA']) ? $dataWp['NAMA'] : '-',
                        'MERK_DAGANG' => ($dataWp['MERK_DAGANG']) ? $dataWp['MERK_DAGANG'] : '-',
                        'ALAMAT' => ($dataWp['ALAMAT']) ? $dataWp['ALAMAT'] : '-',
                        'KELURAHAN' => ($dataWp['KELURAHAN']) ? $dataWp['KELURAHAN'] : '-',
                        'KECAMATAN' => ($dataWp['KECAMATAN']) ? $dataWp['KECAMATAN'] : '-',
                        'KABKOT' => ($dataWp['KABKOT']) ? $dataWp['KABKOT'] : '-',
                        'PROVINSI' => ($dataWp['PROVINSI']) ? $dataWp['PROVINSI'] : '-',
                        'KODE_KLU' => ($dataWp['KODE_KLU']) ? (int) $dataWp['KODE_KLU'] : 0,
                        'KLU' => ($dataWp['KLU']) ? $dataWp['KLU'] : '-',
                        'TELP' => ($dataWp['TELP']) ? $dataWp['TELP'] : '-',
                        'EMAIL' => ($dataWp['EMAIL']) ? $dataWp['EMAIL'] : '-',
                        'JENIS_WP' => ($dataWp['JENIS_WP']) ? $dataWp['JENIS_WP'] : '-',
                        'BADAN_HUKUM' => ($dataWp['BADAN_HUKUM']) ? $dataWp['BADAN_HUKUM'] : '-',
                        'RESPONSE_MSG_NPWP' => json_encode($res['message']),
                        'RESPONSE_STATUS_CODE_NPWP' => ($res['status']) ? (int) $res['status'] : 0,
                        'USER_TYPE' => $type,
                        'NPWP_SIMTAX' => $npwp_simtax,
                        'LAST_UPDATE' => date('Y-m-d H:i:s'),
                    );
                    $dataUpdate = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->get()->row();
                    $doSave = $this->db->where('ID', $dataUpdate->ID)->update('SIMTAX_MASTER_NPWP', $rowData);
                }
            } else {
                $doSave = 'npwp tidak 15 digit angka';
            }
        }
        $response = array(
            'doSave' => $doSave,
            'check_npwp' => $check_npwp,
            'latest_npwp' => $latest_npwp,
            'npwp' => $npwp,
            'npwp_simtax' => $npwp_simtax,
            'rowdata' => $rowData
        );
        echo json_encode($response);
    }

    public function saveKswp()
    {
        $npwp_simtax = $this->input->post('npwp_simtax');
        $npwp = $this->input->post('npwp');
        $res = $this->input->post('res');
        if (isset($res['message']['status'])) {
            $statusKswp = $res['message']['status'];
            $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
            $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID', 'DESC')->get()->row();
            $type = '-';
            $isSupplier = $this->db->from('SIMTAX_MASTER_SUPPLIER')->where('NPWP', $npwp_simtax)->limit(1)->get()->row();
            $isCustomer = $this->db->from('SIMTAX_MASTER_PELANGGAN')->where('NPWP', $npwp_simtax)->limit(1)->get()->row();
            if ($statusKswp == 'N' || $statusKswp == 'T') {
                $statusKswp = '-';
            }
            if ($isSupplier) {
                $type = 'SUPPLIER';
            }
            if ($isCustomer) {
                if ($type == '-') {
                    $type = 'CUSTOMER';
                } else {
                    $type .= ', CUSTOMER';
                }
            }
            if (strlen($npwp) == 15) {
                if ($check_npwp < 1) {
                    $rowData = array(
                        'ID' => ($latest_npwp->ID+1),
                        'NPWP' => $npwp,
                        'NAMA' => '-',
                        'MERK_DAGANG' => '-',
                        'ALAMAT' => '-',
                        'KELURAHAN' => '-',
                        'KECAMATAN' => '-',
                        'KABKOT' => '-',
                        'PROVINSI' => '-',
                        'KODE_KLU' => 0,
                        'KLU' => '-',
                        'TELP' => '-',
                        'EMAIL' => '-',
                        'JENIS_WP' => '-',
                        'BADAN_HUKUM' => '-',
                        'STATUS_KSWP' => $statusKswp,
                        'RESPONSE_MSG_NPWP' => '-',
                        'RESPONSE_MSG_KSWP' => json_encode($res['message']),
                        'RESPONSE_STATUS_CODE_NPWP' => 0,
                        'RESPONSE_STATUS_CODE_KSWP' => ($res['status']) ? (int) $res['status'] : 0,
                        'USER_TYPE' => $type,
                        'NPWP_SIMTAX' => $npwp_simtax,
                        'LAST_UPDATE' => date('Y-m-d H:i:s'),
                    );
                    $doSave = $this->db->insert('SIMTAX_MASTER_NPWP', $rowData);
                } else {
                    $rowData = array(
                        'STATUS_KSWP' => $statusKswp,
                        'RESPONSE_MSG_KSWP' => json_encode($res['message']),
                        'RESPONSE_STATUS_CODE_KSWP' => ($res['status']) ? (int) $res['status'] : 0,
                        'USER_TYPE' => $type,
                        'LAST_UPDATE' => date('Y-m-d H:i:s'),
                    );
                    $dataUpdate = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->get()->row();
                    $doSave = $this->db->where('ID', $dataUpdate->ID)->update('SIMTAX_MASTER_NPWP', $rowData);
                }
            } else {
                $doSave = 'npwp tidak 15 digit angka';
            }
        }
        $response = array(
            'doSave' => $doSave,
            'check_npwp' => $check_npwp,
            'latest_npwp' => $latest_npwp,
            'npwp' => $npwp,
            'npwp_simtax' => $npwp_simtax,
            'rowdata' => $rowData
        );
        echo json_encode($response);
    }

    public function getRekon()
    {
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        $jenisPajak = $_POST['jenisPajak'];
        $pembetulan = $_POST['pembetulan'];
        $kodeCabang = $this->session->userdata('kd_cabang');
        $category = array('faktur_standar','dokumen_lain');
        $get_pajak_header_id = $this->ppn_masa->get_pajak_header_id($kodeCabang, $jenisPajak, $bulan, $tahun, $pembetulan);
        $pajak_header_id = ($get_pajak_header_id) ? $get_pajak_header_id->PAJAK_HEADER_ID : 0;
        $faktur = $this->ppn_masa->get_rekonsiliasi($pajak_header_id, $jenisPajak, $category[0], false, 0, 1000, '', '');
        $doklain = $this->ppn_masa->get_rekonsiliasi($pajak_header_id, $jenisPajak, $category[1], false, 0, 1000, '', '');
        $hasilFaktur = $faktur['queryAll'];
        $hasilDoklain = $doklain['queryAll'];
        $dataNpwp = array();
        foreach ($hasilFaktur->result() as $hf) {
            if ($hf->IS_CHEKLIST && $hf->NPWP1 != null && $hf->NPWP1 != '' && $hf->NPWP1) {
                if (!$this->myArrayContainsWord($dataNpwp, $hf->NPWP1)) {
                    array_push($dataNpwp, $hf);
                }
            }
        }
        foreach ($hasilDoklain->result() as $hd) {
            if ($hd->IS_CHEKLIST && $hd->NPWP1 != null && $hd->NPWP1 != '' && $hd->NPWP1) {
                if (!$this->myArrayContainsWord($dataNpwp, $hd->NPWP1)) {
                    array_push($dataNpwp, $hd);
                }
            }
        }
        $res = array(
            'dataNpwp' => $dataNpwp
        );
        echo json_encode($res);
    }

    public function myArrayContainsWord(array $myArray, $word)
    {
        foreach ($myArray as $element) {
            if ($element->NPWP1 == $word || (!empty($myArray['NPWP1']) && $this->myArrayContainsWord($myArray['NPWP1'], $word))) {
                return true;
            }
        }
        return false;
    }
}
