<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('anggota_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data['menu'] = 'master';
        $data['js'] = '/assets/js/page/anggota.js';
        $content = $this->load->view('master/anggota', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_anggota($status = '')
    {
        $list = $this->anggota_model->get_datatables($status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['id'] = $field->id;
            $row['nama_anggota'] = $field->nama_anggota;
            $row['alamat_anggota'] = $field->alamat_anggota;
            $row['tgl_masuk'] = tgl_indo($field->tgl_masuk);
            $row['status'] = $field->status;
            $row['total_simpanan'] = rp($field->total_tabungan);
            $row['total_pinjaman'] = rp($field->total_pinjam - $field->jumlah_angsuran);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota_model->count_all(),
            "recordsFiltered" => $this->anggota_model->count_filtered($status),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function detail($id)
    {
        $anggota = $this->anggota_model->get_data_anggota($id);

        $data['anggota'] = $anggota;
        $data['menu'] = 'master';
        $data['js'] = '/assets/js/page/anggota.js';
        $content = $this->load->view('master/detail_anggota', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function tambah_anggota()
    {
        $data = $this->anggota_model->tambah_anggota($this->authData['id_user']);
        echo json_encode($data);
    }

    function update_anggota($id)
    {
        $data = $this->anggota_model->update_anggota($id);
        echo json_encode($data);
    }

    function lookup_anggota()
    {
        $list = $this->anggota_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['id'] = $field->id;
            $row['nama_anggota'] = $field->nama_anggota;
            $row['alamat_anggota'] = $field->alamat_anggota;
            $row['tgl_masuk'] = tgl_indo($field->tgl_masuk);
            $row['status'] = $field->status;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota_model->count_all(),
            "recordsFiltered" => $this->anggota_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
}
