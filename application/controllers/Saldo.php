<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Saldo extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('saldo_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data = array(
            'menu'      => 'transaksi',
            'js'        => '/assets/js/page/saldo.js',
        );
        $content = $this->load->view('transaksi/saldo', $data, TRUE);
        $this->template->load(array(), $content);
    }



    function get_data_saldo()
    {
        $list = $this->saldo_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['id'] =  $field->id;
            $row['tanggal'] =  tgl_indo($field->tanggal);
            $row['saldo'] = rp($field->saldo);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->saldo_model->count_all(),
            "recordsFiltered" => $this->saldo_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function tambah_transaksi()
    {
        $data = $this->saldo_model->tambah_transaksi($this->authData['id_user']);
        echo json_encode($data);
    }

    function update_transaksi()
    {
        $data = $this->saldo_model->update_transaksi($this->authData['id_user']);
        echo json_encode($data);
    }

    function delete_transaksi($id)
    {
        $data = $this->saldo_model->delete_transaksi($id);
        echo json_encode($data);
    }
}
