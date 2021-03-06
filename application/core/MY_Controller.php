<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    private $staff_id = null;
    private $authData = null;

    function __construct()
    {
        parent::__construct();

        $this->path = $this->uri->segment(1);

        if ($this->session->userdata('auth_data')) {
            $auth_data = $this->session->userdata('auth_data');
            $this->authData = $auth_data;
        }
    }

    function check_logged($login = false)
    {
        if ($this->authData) {
            if ($login) {
                redirect('home', 'refresh');
            }
        } else {
            if (!$login) {
                $this->session->sess_destroy();
                redirect('auth', 'refresh');
            }
        }
    }

    function get_staff_id()
    {
        return $this->staff_id;
    }

    function get_authData()
    {
        return $this->authData;
    }

    protected function sanitize($data = array())
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);

                $data[$this->sanitize($key)] = $this->sanitize($value);
            }
        } else {
            if (!is_object($data)) {
                $data = trim($this->db->escape_str(htmlspecialchars($data, ENT_QUOTES, 'UTF-8')));
            }
        }

        return $data;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */