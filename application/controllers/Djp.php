<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Djp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('djp');
    }

    public function index()
    {
        $this->template->set('title', 'DJP');
        $data['subtitle']	= "DJP";
        $data['activepage'] = "djp";
        $this->template->load('template', 'djp/index', $data);
    }

    public function supplier()
    {
        $supplier = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_SUPPLIER WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result();
        $res = [
            'status' => true,
            'data' => $supplier
        ];
        echo json_encode($res);
    }

    public function pelanggan()
    {
        $pelanggan = $this->db->query('SELECT NPWP FROM SIMTAX_MASTER_PELANGGAN WHERE NPWP IS NOT NULL GROUP BY NPWP ORDER BY NPWP DESC')->result();
        $res = [
            'status' => true,
            'data' => $pelanggan
        ];
        echo json_encode($res);
    }

    public function checkDjp()
    {
        $token = djp_get_token('pelindo2', 'Cvn0fj2489');
        $npwp = preg_replace('/[^0-9]/', '', $this->input->post('npwp'));
        $type = $this->input->post('type');
        $check_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->where('NPWP', $npwp)->count_all_results();
        $latest_npwp = $this->db->from('SIMTAX_MASTER_NPWP')->limit(1)->order_by('ID DESC')->get()->row();
        $npwp_djp = null;
        $kswp_djp = null;
        if ($check_npwp < 1) {
            $npwp_djp = djp_check_npwp($token->message, $npwp);
            $kswp_djp = djp_check_kswp($token->message, $npwp);
            $dataWp = $npwp_djp->message->datawp;
            $status_kswp = '-';
            if ($kswp_djp->status == 200) {
                $status_kswp = $kswp_djp->message->status;
            }
            $insertData = [
                'ID' => ($latest_npwp->ID+1),
                'NPWP' => ($dataWp->NPWP) ? (int) $dataWp->NPWP : 0,
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
            ];
            $this->db->insert('SIMTAX_MASTER_NPWP', $insertData);
        }
        $res = [
            'kswp' => $kswp_djp,
            'npwp' => $npwp_djp,
            'latest' => $latest_npwp,
            'check_npwp' => $check_npwp
        ];
        echo json_encode($res);
    }
}
