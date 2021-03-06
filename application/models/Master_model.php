<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends MY_Model
{
    public $_table_name;
    public $_primary_key;
    public $_order_by;
    public $_direction;

    function __construct()
    {
        parent::__construct();
    }
}
