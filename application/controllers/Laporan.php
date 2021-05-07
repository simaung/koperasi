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

        $data_anggota = $this->anggota_model->get_data('t_anggota', $where, 'all', 'id', 'ASC');

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

        if (!empty($post['id_anggota'])) {
            $where['a.anggota_id'] = $post['id_anggota'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(created_at)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(created_at)'] = $post['tahun'];
        }
        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);

            $where['created_at >= '] = $tgl_awal . ' 00:00:00';
            $where['created_at <= '] = $tgl_akhir . ' 23:59:59';
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

    function pinjaman()
    {
        $this->load->model('pinjaman_model');
        $post = $this->input->post();
        $where = array();

        if (!empty($post['status'])) {
            $where['a.status'] = $post['status'];
        }
        if (!empty($post['status_pengajuan'])) {
            $where['a.status_pengajuan'] = $post['status_pengajuan'];
        }
        if (!empty($post['id_anggota'])) {
            $where['a.anggota_id'] = $post['id_anggota'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(tgl_entry)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(tgl_entry)'] = $post['tahun'];
        }
        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);

            $where['tgl_entry >= '] = $tgl_awal . ' 00:00:00';
            $where['tgl_entry <= '] = $tgl_akhir . ' 23:59:59';
        }

        $data_pinjaman = $this->pinjaman_model->get_data_pinjaman($where);

        $nama_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['pinjaman'] = $data_pinjaman;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $html = $this->load->view('laporan/pinjaman', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function kas()
    {
        $this->load->model('pinjaman_model');

        $data_kas = $this->pinjaman_model->get_data_kas();
        $data_kas_sebelum = $this->pinjaman_model->get_data_kas('sebelum');

        $nama_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $post = $this->input->post();
        $periode = explode(' - ', $post['periode']);
        $tgl_akhir = tgl_db($periode[1]);

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['kas'] = $data_kas;
        $data['kas_sebelumnya'] = $data_kas_sebelum;
        $data['tgl_akhir']  = $tgl_akhir;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $html = $this->load->view('laporan/kas', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
