<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index($type)
    {
        if ($type == 1) {
            $view = 'dashboard1';
        } elseif ($type == 2) {
            $view = 'dashboard2';
        } else {
            $view = 'dashboard3';
        }
        $this->load->view($view);
    }
}
