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
            $row['no'] = $no;
            $row['id'] = $field->id;
            $row['nik'] = $field->nik;
            $row['nama'] = $field->nama;
            $row['phone'] = $field->phone;
            $row['tgl_masuk'] = $field->tgl_masuk;
            $row['level'] = ($field->access_system == '1') ? $field->level : '-';
            $row['access_system'] = $field->access_system;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->petugas_model->count_all(),
            "recordsFiltered" => $this->petugas_model->count_filtered(),
            "data" => $data,
            'authData' => $this->authData,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function tambah_petugas()
    {
        $data = $this->petugas_model->tambah_petugas($this->authData['id_user']);
        echo json_encode($data);
    }

    function get_access_system($id)
    {
        $petugas = $this->petugas_model->get_data('t_user', array('id' => $id));
        $data['petugas'] = $petugas[0];

        $output = array(
            'view' => $this->load->view('master/modal_access', $data, TRUE),

        );

        echo json_encode($output);
    }

    function update_access_system($id)
    {
        $post = $this->input->post();
        foreach ($post as $key => $value) {
            $set[$key] = $value;
        }
        $petugas = $this->petugas_model->update_data('t_user', $set, array('id' => $id));
        if ($petugas) {
            $result = array(
                'code'          => '200',
            );
        } else {
            $result = array(
                'code'          => '400',
            );
        }
        echo json_encode($result);
    }
}
