<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengambilan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('pengambilan_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data['menu'] = 'transaksi';
        $data['js'] = '/assets/js/page/pengambilan.js';
        $content = $this->load->view('transaksi/pengambilan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_pengambilan()
    {
        $list = $this->pengambilan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['tgl_ambil'] = tgl_indo($field->tgl_ambil, 'time');
            $row['id'] = $field->id;
            $row['anggota_id'] = $field->anggota_id;
            $row['nama_anggota'] = $field->nama_anggota;
            $row['total_ambil'] = rp($field->total_ambil);
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pengambilan_model->count_all(),
            "recordsFiltered" => $this->pengambilan_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pengajuan()
    {
        $data['menu'] = 'transaksi';
        $data['js'] = '/assets/js/page/pengambilan.js';
        $content = $this->load->view('transaksi/form_pengambilan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function tambah_pengambilan()
    {
        $data = $this->pengambilan_model->tambah_pengambilan($this->authData['id_user']);
        echo json_encode($data);
    }

    function get_data_anggota($id)
    {
        $this->load->model('anggota_model');

        $simpanan_anggota = $this->pengambilan_model->get_data('t_simpan', array('anggota_id' => $id, 'show_report' => '1'), 'false', 'id', 'desc');
        $data_anggota = $this->anggota_model->get_data_anggota($id);

        $data = array(
            'simpanan_anggota'  => $simpanan_anggota,
            'data_anggota'      => $data_anggota,
        );

        $output = array(
            'view' => $this->load->view('transaksi/detail_anggota_pengambilan', $data, TRUE),
            'nama' => $data_anggota->nama_anggota,

        );

        echo json_encode($output);
    }
}
