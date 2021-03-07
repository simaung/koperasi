<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index()
    {
        $content = $this->load->view('login');
    }

    function login()
    {
        $post = $this->input->post();
        $where = array(
            'nik'  => $post['nik'],
            'password'  => MD5($post['password']),
            'access_system'  => '1',
        );
        $user = $this->user_model->get_data('t_user', $where, true);

        if ($user) {
            $userData = array(
                'id_user'   => $user[0]->id,
                'nik'       => $user[0]->nik,
                'nama'      => $user[0]->nama,
                'level'     => $user[0]->level,
                'logged_in' => TRUE
            );

            $this->session->set_userdata('auth_data', $userData);

            $output = array(
                'code'  => '200',
            );
        } else {
            $output = array(
                'code'  => '400',
            );
        }
        echo json_encode($output);
    }

    function logout()
    {
        session_destroy();
        redirect('auth');
    }
}
