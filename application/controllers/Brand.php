<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {

	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array("model_product", "model_order", "model_brand", "model_config"));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "my_auth", "cart", "pagination", "asiantec_mail"));

		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}
	}

	public function edit_brand() {
		$id               = $this->uri->segment(2);
		$this->data['id'] = $id;
		if ($this->input->post()) {
			$this->form_validation->set_rules("brand[brand_name]", "Brand Name", "required");
			$this->form_validation->set_rules("brand[brand_origin_country]", "Country", "required");

			if ($this->form_validation->run()) {
				$brand = $this->input->post('brand');
				if ($this->model_brand->edit_brand($id, $brand)) {
					redirect(base_url().'brand');
				}
			}

		}
		$this->data['detail'] = $this->model_brand->get_brand_detail($id);

		$this->data['subcontent'] = "pages/edit-brand";
		$this->load->view('pages/templates', $this->data);
	}
	public function add_brand() {

		if ($this->input->post()) {

			if ($this->form_validation->run()) {
				$brand                 = $this->input->post('brand');
				$brand['brand_status'] = 1;
				if ($this->model_brand->Create_brand($brand)) {
					redirect(base_url().'brand');
				}
			}

		}

		$this->data['subcontent'] = "pages/add-brand";
		$this->load->view('pages/templates', $this->data);
	}

	public function index() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
		}

		$type = $this->input->get('type');

		$this->data['subcontent'] = 'pages/brand';
		$param                    = $this->uri->segment(2);
		if (!empty($this->session->userdata['brand.keyword'])) {
			$keyword = $this->session->userdata['brand.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('brand.keyword', $keyword);
			$keyword = $this->session->userdata['brand.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'brand.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}
		$order_col = $this->input->get('order');
		$order_dir = $this->input->get('dir');

		if (empty($order_dir)) {
			$order_dir = 'ASC';
		}

		$sort = '';

		if (!empty($order_col)) {
			$sort = $order_col.' '.$order_dir;
		}

		if ($order_dir == 'ASC') {
			$this->data['order_dir'] = 'DESC';
		} else {
			$this->data['order_dir'] = 'ASC';
		}

		//pagination
		$config['base_url']   = base_url().'brand';
		$config['total_rows'] = $this->model_brand->count();
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['items'] = $this->model_brand->getItems($config['per_page'], $param, NULL, $sort, $keyword);

		$this->load->view('pages/templates', $this->data);
	}

	public function detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/customer_detail';
		$param                    = $this->uri->segment(2);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$items   = $this->model_customer->get_purchase_history($param);
		$payment = $this->model_customer->get_payment_method_field();

		foreach ($items as $key => $item) {
			$codeData = $this->model_customer->get_voucher($item['voucher']);

			if (!empty($codeData['discount_value'])) {
				$discount                = $codeData['discount_value'];
				$items[$key]['discount'] = $discount;
			} elseif (!empty($codeData['discount_percentage'])) {
				$discount                = $codeData['discount_percentage'];
				$items[$key]['discount'] = ($item['order_payment_amount']*$discount)/100;
			}

			$items[$key]['items'] = $this->model_customer->get_order_items_detail($item['id']);
			$payment_field        = $this->model_customer->get_payment_detail($item['order_payment_id']);

			foreach ($payment as $value) {
				foreach ($payment_field as $field) {
					if ($value['payment_method_field_id'] == $field['order_payment_method_field']) {
						$items[$key]['payment'][$value['payment_method_field_name']] = $field['order_payment_method_field_'.$value['payment_method_field_valuetype']];
					}
				}
			}
		}

		$this->data['history'] = $items;

		$this->load->view('pages/templates', $this->data);
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}
}
?>
