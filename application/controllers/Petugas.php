<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends MY_Controller
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
        $data['menu'] = 'master';
        $data['js'] = '/assets/js/page/petugas.js';
        $content = $this->load->view('master/petugas', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function get_data_petugas()
    {
        $list = $this->petugas_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[''] = $no;
            $row['nama'] = $field->nama;
            $row['phone'] = $field->phone;
            $row['tgl_masuk'] = $field->tgl_masuk;
            $row['level'] = $field->level;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->petugas_model->count_all(),
            "recordsFiltered" => $this->petugas_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        print_r($output);
        die;
        echo json_encode($output);
    }
}
