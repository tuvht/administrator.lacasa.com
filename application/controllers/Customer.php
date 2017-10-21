<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array("model_product", "model_order", "model_customer", "model_config"));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "my_auth", "cart", "pagination", "asiantec_mail"));

		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}
	}

	public function index() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$type = $this->input->get('type');

		$this->data['subcontent'] = 'pages/customer';
		$param                    = $this->uri->segment(2);

		if (!empty($this->session->userdata['customer.keyword'])) {
			$keyword = $this->session->userdata['customer.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('customer.keyword', $keyword);
			$keyword = $this->session->userdata['customer.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'customer.keyword' => '',
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
		$config['base_url']   = base_url().'customer';
		$config['total_rows'] = $this->model_customer->count_rows($type);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['customers'] = $this->model_customer->get_customers($type, $config['per_page'], $param, $sort, $keyword);
		$this->data['types']       = $this->model_customer->get_customer_type();
		$this->data['type_select'] = $type;

		$this->load->view('pages/templates', $this->data);
	}

	public function detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/customer_detail';
		$param                    = $this->uri->segment(2);
		if ($param) {
			$checkcustomer = $this->model_order->check_customer($param);
			if (!$checkcustomer) {
				redirect(base_url()."customer");
			}
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

			$items[$key]['items']       = $this->model_customer->get_order_items_detail($item['id']);
			$items[$key]['total_price'] = 0;
			foreach ($items[$key]['items'] as $val_items) {
				$items[$key]['total_price'] += $val_items['prod_price']*$val_items['order_item_quantity'];
			}

			$payment_field = $this->model_customer->get_payment_detail($item['order_payment_id']);

			foreach ($payment as $value) {
				foreach ($payment_field as $field) {
					if ($value['payment_method_field_id'] == $field['order_payment_method_field']) {
						$items[$key]['payment'][$value['payment_method_field_name']] = $field['order_payment_method_field_'.$value['payment_method_field_valuetype']];
					}
				}
			}
		}

		$this->data['address_list'] = $this->model_order->get_address_by_user_id($param);

		$this->data['fields'] = $this->model_customer->get_field($param);

		$this->data['history'] = $items;
		//sortData($this->data['history'], $order_col, $order_dir);
		$this->data['user_info'] = $this->model_customer->get_info_detail($param);

		// $this->data[''] = $items;
		$this->load->view('pages/templates', $this->data);
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}
}
?>
