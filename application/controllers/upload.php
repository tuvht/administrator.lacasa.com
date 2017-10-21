<?php

class upload extends CI_Upload
    {
        public function __construct()
        {
            parent::__construct();        
        }
        
        public function index($user_id)
        {
            echo $_POST['file_upload'];
            
            $config['upload_path']= $_POST ['file_path'];
            $config['allowed_types'] = 'gif|jpg|png';
            
            //$this->load->library('upload',$config);
            
            //$this->upload->do_upload($_POST['file_upload']);
            
        }
        
    }



?>