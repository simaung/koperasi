<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    public function index()
    {
        $data['menu'] = 'home';

        $this->load->model(array('anggota_model', 'simpanan_model'));

        $data['total_tabungan'] = $this->simpanan_model->get_simpanan();
        $data['total_anggota'] = $this->anggota_model->count_all();

        $content = $this->load->view('home', $data, TRUE);
        $this->template->load(array(), $content);
    }
}
