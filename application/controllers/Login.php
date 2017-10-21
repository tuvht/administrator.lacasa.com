<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

    private $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_supplier");
        $this->load->model("model_config");
        $this->load->helper(array("url", "form", "my_data"));
        $this->load->library(array("form_validation", "session", "my_auth", "cart"));
    }
    
    public function index()
    {
        if ($this->my_auth->is_Login())
        {
            redirect(base_url() . "home");

            exit();
        }

        $this->data['error'] = '';
        $this->data['msg'] = '';

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false)
        {
            $this->data['error'] = "";
        }
        else
        {
            $e = $this->input->post('email');
            $p = $this->input->post('password');

            $re_array = $this->model_config->check_login($e, $p);

            switch($re_array)
            {
                case 1 :
                $this->data['msg'] = 'Tài khoản không hợp lệ';
                break;
                case 2 :
                $this->data['msg'] = 'Mật khẩu không đúng, vui lòng nhập lại !';
                break;
                case 3 :
                redirect(base_url() . 'home');
                break;
                default :
                $this->data['msg'] = 'Tài khoản không tồn tại';
                break;
            }
        }

        $this->load->view('pages/login', $this->data);   
    }

    public function logout()
    {
        $this->my_auth->sess_destroy();

		redirect(base_url() . "login");
    }

    public function information()
    {
        if ($this->my_auth->is_Login())
        {
            $this->data['email'] = $this->session->userdata['sup_email'];
            $sup_id = $this->session->userdata['sup_id'];
        }

        $this->data['subcontent'] = 'pages/information';

        $change_pass = $this->input->post('change');
        $old_pass = $this->input->post('old_password');
        $pass = $this->input->post('new_password');
        $pass2 = $this->input->post('renew_password');

        if (!empty($change_pass))
        {
            $this->form_validation->set_rules('old_password', 'Old password', 'required');
            $this->form_validation->set_rules('new_password', 'New password', 'required');
            $this->form_validation->set_rules('renew_password', 'New password confirm', 'required');
            
            if (!empty($pass) && !empty($pass2))
            {
                $this->form_validation->set_rules("new_password", "Password", "matches[renew_password]");
            }

            if ($this->form_validation->run() == false)
            {
                
                $this->data['error'] = '';
            }
            else
            {
                $check_pass = $this->model_supplier->check_pass($sup_id, $old_pass);

                if ($check_pass == 1)
                {
                    $this->model_supplier->update_supplier(array('sup_password' => md5($pass)), $sup_id);
                    $this->data['msg'] = 'Password has been changed';
                }
                else
                {
                    $this->data['msg'] = 'Current password is wrong';
                }
            }
        }

        $this->data['info'] = $this->model_supplier->get_info($sup_id);

        $this->load->view('pages/templates', $this->data);   
    }
}
?>
