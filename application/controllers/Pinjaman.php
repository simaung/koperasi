<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pinjaman extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('pinjaman_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data['menu'] = 'transaksi';
        $data['js'] = '/assets/js/page/pinjaman.js';
        $content = $this->load->view('transaksi/pinjaman', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_pinjaman()
    {
        $list = $this->pinjaman_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['tgl_entry'] = tgl_indo($field->tgl_entry, 'time');
            $row['id'] = $field->id;
            $row['anggota_id'] = $field->anggota_id;
            $row['nama_anggota'] = $field->nama_anggota;
            $row['total_pinjam'] = rp($field->total_pinjam);
            $row['lama_angsuran'] = $field->lama_angsuran . ' bulan';
            $row['bunga'] = $field->bunga . '%';
            $row['status_pengajuan'] = $field->status_pengajuan;
            $row['status_ambil'] = $field->status_ambil;
            $row['tgl_persetujuan'] = ($field->tgl_persetujuan != null) ? tgl_indo($field->tgl_persetujuan, 'time') : '';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pinjaman_model->count_all(),
            "recordsFiltered" => $this->pinjaman_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pengajuan()
    {
        $data['menu'] = 'transaksi';
        $data['js'] = '/assets/js/page/pinjaman.js';
        $content = $this->load->view('transaksi/form_pengajuan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function tambah_pinjaman()
    {
        $data = $this->pinjaman_model->tambah_pengajuan($this->authData['id_user']);
        echo json_encode($data);
    }

    function get_data_anggota($id)
    {
        $this->load->model('simpanan_model');

        $this->load->model('anggota_model');

        $simpanan_anggota = $this->pinjaman_model->get_data('t_simpan', array('anggota_id' => $id, 'show_report' => '1'), 'false', 'id', 'desc');
        $data_anggota = $this->anggota_model->get_data_anggota($id);

        $get_angsuran = $this->simpanan_model->get_data('t_angsuran', array('pinjam_id' => $data_anggota->pinjam_id, 'MONTH(tgl_entry)' => date('m')), true);
        $jasa = ($get_angsuran) ? 0 : $data_anggota->total_pinjam * $data_anggota->bunga / 100;
        $data_anggota->jasa = $jasa;

        $data = array(
            'simpanan_anggota'  => $simpanan_anggota,
            'data_anggota'      => $data_anggota,
        );

        $output = array(
            'view' => $this->load->view('transaksi/detail_anggota', $data, TRUE),
            'nama' => $data_anggota->nama_anggota,

        );

        echo json_encode($output);
    }

    function get_data_pengajuan($id)
    {
        $this->load->model('simpanan_model');

        $this->load->model('anggota_model');

        $pengajuan = $this->pinjaman_model->get_data('t_pinjam', array('id' => $id), 'true', 'id', 'desc');
        $simpanan_anggota = $this->pinjaman_model->get_data('t_simpan', array('anggota_id' => $pengajuan->anggota_id, 'show_report' => '1'), 'false', 'id', 'desc');

        $data_anggota = $this->anggota_model->get_data_anggota($pengajuan->anggota_id);

        $data = array(
            'pengajuan'         => $pengajuan,
            'simpanan_anggota'  => $simpanan_anggota,
            'data_anggota'      => $data_anggota,
        );

        $output = array(
            'view' => $this->load->view('transaksi/detail_pengajuan', $data, TRUE),
            // 'nama' => $data_anggota->nama_anggota,

        );

        echo json_encode($output);
    }

    function approve_pengajuan()
    {
        $post = $this->input->post();

        $set['status_pengajuan'] = $post['status'];
        $set['tgl_persetujuan'] = date('Y-m-d H:i:s');
        $set['total_pinjam'] = $post['total_pinjaman'];

        $where['id']    = $post['id'];

        $pengajuan = $this->pinjaman_model->update_data('t_pinjam', $set, $where);
        print_r($pengajuan);
        die;
    }

    function ambil_pinjaman()
    {
        $ambil = $this->pinjaman_model->ambil_pinjaman();
        echo json_encode($ambil);
    }

    function pelunasan_pinjaman()
    {
        $pelunasan = $this->pinjaman_model->pelunasan_pinjaman($this->authData['id_user']);
        echo json_encode($pelunasan);
    }
}
