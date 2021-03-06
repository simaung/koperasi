<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class template
{

    function load($setting = '', $konten = '')
    {

        $ci = &get_instance();

        $temp['meta']           = $ci->load->view('layout/meta', "", TRUE);
        $temp['header']         = $ci->load->view('layout/header', isset($setting['header']) ? $setting['header'] : '', TRUE);
        $temp['mainsidebar']    = $ci->load->view('layout/main-sidebar', isset($setting['mainsidebar']) ? $setting['mainsidebar'] : '', TRUE);
        $temp['sidebar']        = $ci->load->view('layout/sidebar', isset($setting['sidebar']) ? $setting['sidebar'] : '', TRUE);
        $temp['footer']         = $ci->load->view('layout/footer', isset($setting['footer']) ? $setting['footer'] : '', TRUE);
        $temp['content']        = $konten;

        /* MAIN CONTAINER */
        $ci->load->view('layout/container', $temp);
    }
}
