<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_product', 'model_order', 'model_config'));
        $this->load->helper(array("url", "form", "my_data"));
        $this->load->library(array("form_validation","session","pagination", "my_auth"));

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

        $this->data['subcontent'] = 'pages/report_product';
        $param = $this->uri->segment(2);

        $keyword = '';

        if (!empty($this->input->post('keyword')))
        {
            $keyword = $this->input->post('keyword');
            $this->session->set_userdata('product.keyword', $keyword);
            $keyword = $this->session->userdata['product.keyword'];
        }
        else
        {
            $this->session->unset_userdata(array('product.keyword' => ''));
        }

        $this->data['keyword'] = $keyword;

        //pagination
        $config['base_url'] = base_url() . 'product-report';            
        $config['total_rows'] = $this->model_product->count_rows($sup_id, 1, $keyword);
        // $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;                              
        $this->pagination->initialize($config);

        $products = $this->model_product->get_products($sup_id, $config['per_page'], $param, 1, $keyword);
        $this->data['products'] = $products;

        $this->load->view('pages/templates', $this->data);
    }

    public function sale()
    {
        if ($this->my_auth->is_Login())
        {
            $this->data['email'] = $this->session->userdata['sup_email'];
            $sup_id = $this->session->userdata['sup_id'];
        }

        $this->data['subcontent'] = 'pages/report_sale';
        $param = $this->uri->segment(2);

        $config['base_url'] = base_url() . 'sale-report';            
        //$config['total_rows'] = $this->model_order->count_rows($sup_id);
        // $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;                              
        $this->pagination->initialize($config);

        $this->data['sales'] = $this->model_order->report_sale($sup_id);

        $this->load->view('pages/templates', $this->data);
    }
}
?>
