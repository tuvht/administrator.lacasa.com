<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_Auth extends CI_Session
{
    var $CI;
    var $_model;
    
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        
        $this->_model = $CI;
        $this->_model->load->database();
        $this->_model->load->model("model_supplier");
    }
    
    function is_Login()
    {
        if (!empty($this->userdata("sup_email")) && !empty($this->userdata("sup_id")))
            return true;
        else
            return false;
    }
    
    function __get($var)
    {
        return $this->userdata($var);

    }
    
    
}
