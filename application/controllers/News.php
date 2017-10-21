<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller{

    private $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array("model_news","model_order", "model_config","model_product"));
        $this->load->helper(array("url", "form", "my_data"));
        $this->load->library(array("form_validation", "session", "my_auth", "cart", "pagination", "asiantec_mail"));

        if ($this->my_auth->is_Login())
        {
            $this->data['email'] = $this->session->userdata['sup_email'];
            $sup_id = $this->session->userdata['sup_id'];
        }
        else
        {
            redirect(base_url() . 'login');
        }
    }
    
    public function index()
    {
        if ($this->my_auth->is_Login())
        {
            $this->data['email'] = $this->session->userdata['sup_email'];
            $sup_id = $this->session->userdata['sup_id'];
        }

        $selected = $this->input->post('selected');
        $count = count($selected);
        $active = 'active-' . $selected[0];
        $inactive = 'inactive-' . $selected[0];

        if ($this->input->post($active))
        {
            for ($j = 0; $j < $count; $j++)
            {
                $this->model_news->update_news(array('status' => 0), $selected[$j]);
            }                   

            $msg = $this->setMessage('Inactive news successful', 'success');
        }

        if ($this->input->post($inactive))
        {
            for ($j = 0; $j < $count; $j++)
            {   
                $this->model_news->update_news(array('status' => 1), $selected[$j]);
            }                   

            $msg = $this->setMessage('Active news successful', 'success');   
        }

        $this->data['subcontent'] = 'pages/news';
        $param = $this->uri->segment(2);

        $order_col = $this->input->get('order');
        $order_dir = $this->input->get('dir');

        if (empty($order_dir))
        {
            $order_dir = 'ASC';            
        }

        $sort = '';

        if (!empty($order_col))
        {
            $sort = $order_col . ' ' . $order_dir;
        }

        if ($order_dir == 'ASC')
        {
            $this->data['order_dir'] = 'DESC';
        }
        else
        {
            $this->data['order_dir'] = 'ASC';   
        }

        //pagination
        $config['base_url'] = base_url() . 'news';            
        $config['total_rows'] = $this->model_news->count_rows();
        // $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;                              
        $this->pagination->initialize($config);

        if (!empty($msg))
        {
            $this->data['msg'] = $msg;
        }
        else
        {
            $this->data['msg'] = "";
        }

        $this->data['news'] = $this->model_news->get_news($config['per_page'], $param, $sort);

        $this->load->view('pages/templates', $this->data);   
    }

    public function detail()
    {
        if ($this->my_auth->is_Login())
        {
            $this->data['email'] = $this->session->userdata['sup_email'];
            $sup_id = $this->session->userdata['sup_id'];
        }

        $this->data['subcontent'] = 'pages/news_detail';
        $param = $this->uri->segment(2);
        $save = $this->input->post('save');

        if (!empty($save))
        {
            $data = $this->input->post('data');

            if (!empty($param))
            {
                $this->model_news->update_news($data, $param);
                redirect(base_url() . 'news/');
            }
            else
            {
                $this->model_news->insert_news($data);
                redirect(base_url() . 'news/');
            }


        }

        if (!empty($msg))
        {
            $this->data['msg'] = $msg;
        }
        else
        {
            $this->data['msg'] = "";
        }

        $detail = $this->model_news->get_news_by_id($param);

        $this->data['detail'] = $detail;
        $this->data['news_id'] = $param;
        
        $this->load->view('pages/templates', $this->data);   
    }

    public function setMessage($text, $type)
    {
        return array('text' => $text, 'type' => $type);
    }
}
?>
