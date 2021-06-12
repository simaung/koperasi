<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Simpanan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('simpanan_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $anggota = $this->simpanan_model->get_data('t_anggota');
        $wajib  = $this->simpanan_model->get_data('t_setting', array('name' => 'wajib'), 'true');

        $data = array(
            'menu'      => 'transaksi',
            'js'        => '/assets/js/page/simpanan.js',
            'anggota'   => $anggota,
            'wajib'     => $wajib->nilai,
        );
        $content = $this->load->view('transaksi/simpanan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_anggota($id)
    {
        $post = $this->input->post();

        if (!empty(isset($post['month']))) {
            $date_input = explode('/', $post['month']);
            $month = $date_input[1];
            $year = $date_input[2];
            $date = $date_input[2] . '-' . $date_input[1] . '-' . $date_input[0];
        } else {
            $month = date('m');
            $year = date('Y');
            $date = date('Y-m-d');
        }

        $this->load->model('anggota_model');
        $wajib  = $this->simpanan_model->get_data('t_setting', array('name' => 'wajib'), 'true');

        $data_anggota = $this->anggota_model->get_data_anggota($id);

        $get_wajib = $this->simpanan_model->get_data('t_simpan', array('anggota_id' => $id, 'MONTH(created_at)' => $month, 'YEAR(created_at)' => $year, 'pokok >=' => 0, 'status' => 'aktif'), true);
        if ($get_wajib) {
            $wajib = 0;
        } else {
            $last_wajib = $this->simpanan_model->get_data('t_simpan', array('anggota_id' => $id, 'wajib != 0' => null, 'status' => 'aktif'), 'true', 'created_at', 'desc');
            if ($last_wajib) {
                $timeStart = strtotime($last_wajib->created_at);
                $timeEnd = strtotime("$date");
                $numBulan = (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
                $numBulan += date("m", $timeEnd) - date("m", $timeStart);

                $wajib = $wajib->nilai * $numBulan;
            } else {
                $wajib = $wajib->nilai;
            }
        }
        $jasa = akumulasi_jasa($data_anggota, $date);

        $data = array(
            'wajib'         => $wajib,
            'jasa'          => $jasa,
            'data_anggota'  => $data_anggota,
        );

        $output = array(
            'view' => $this->load->view('transaksi/page_simpanan', $data, TRUE),
            'nama' => $data_anggota->nama_anggota,

        );

        echo json_encode($output);
    }

    function get_data_simpanan()
    {
        $list = $this->simpanan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['id'] = $field->id;
            $row['created_at'] =  tgl_indo($field->created_at, 'time');
            $row['anggota_id'] = $field->anggota_id;
            $row['nama_anggota'] = $field->nama_anggota;
            $row['jumlah_setor'] = rp($field->jumlah_setor);
            $row['pokok'] = rp($field->pokok);
            $row['wajib'] = rp($field->wajib);
            $row['sukarela'] = rp($field->sukarela);
            $row['jumlah_angsuran'] = rp($field->jumlah_angsuran);
            $row['jasa'] = rp($field->jasa);
            // $row['tgl_masuk'] = tgl_indo($field->tgl_masuk);
            // $row['status'] = $field->status;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->simpanan_model->count_all(),
            "recordsFiltered" => $this->simpanan_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function tambah_simpanan()
    {
        $data = $this->simpanan_model->tambah_simpanan($this->authData['id_user']);
        echo json_encode($data);
    }

    function bayar_wajib()
    {
        $data = $this->simpanan_model->bayar_wajib($this->authData['id_user']);
        echo json_encode($data);
    }
}
