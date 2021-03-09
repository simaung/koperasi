<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('petugas_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data['menu'] = 'laporan';
        $data['js'] = '/assets/js/page/laporan.js';
        $content = $this->load->view('laporan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function anggota()
    {
        $this->load->model('anggota_model');
        $post = $this->input->post();
        $where = array();

        if (!empty($post['status'])) {
            $where['status'] = $post['status'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(tgl_masuk)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(tgl_masuk)'] = $post['tahun'];
        }

        $data_anggota = $this->anggota_model->get_data('t_anggota', $where, 'false', 'tgl_masuk', 'DESC');

        $nama_koperasi = $this->anggota_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->anggota_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['anggota'] = $data_anggota;


        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('laporan/anggota', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function simpanan()
    {
        $this->load->model('simpanan_model');
        $post = $this->input->post();
        $where = array();

        if (!empty($post['bulan'])) {
            $where['MONTH(created_at)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(created_at)'] = $post['tahun'];
        }

        $data_simpanan = $this->simpanan_model->get_data_simpanan($where);

        $nama_koperasi = $this->simpanan_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->simpanan_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['simpanan'] = $data_simpanan;


        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $html = $this->load->view('laporan/simpanan', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
