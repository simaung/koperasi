<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('kas_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data = array(
            'menu'      => 'transaksi',
            'js'        => '/assets/js/page/kas.js',
        );
        $content = $this->load->view('transaksi/kas', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_kas()
    {
        $list = $this->kas_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['id'] = $field->id;
            $row['tgl_entry'] =  tgl_indo($field->tgl_entry, 'time');
            $row['description'] = $field->description;
            $row['debet'] = ($field->type == 'debet') ? rp($field->amount) : '-';
            $row['kredit'] = ($field->type == 'kredit') ? rp($field->amount) : '-';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kas_model->count_all(),
            "recordsFiltered" => $this->kas_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function tambah_transaksi()
    {
        $data = $this->kas_model->tambah_transaksi($this->authData['id_user']);
        echo json_encode($data);
    }
}
