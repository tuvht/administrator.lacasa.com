<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_promotion', 'model_product', 'model_config', 'model_order'));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "pagination", "my_auth"));

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

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];

		if (!empty($this->session->userdata['promotion.keyword'])) {
			$keyword = $this->session->userdata['promotion.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('promotion.keyword', $keyword);
			$keyword = $this->session->userdata['promotion.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'promotion.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}
		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_promotion->update(array('promotion_status' => 0), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Inactive promotion successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_promotion->update(array('promotion_status' => 1), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Active promotion successful', 'success');
		}

		$this->data['subcontent'] = 'pages/promotion';
		$param                    = $this->uri->segment(2);

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
		$config['base_url']   = base_url().'promotion';
		$config['total_rows'] = $this->model_promotion->count_rows();
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['promotions'] = $this->model_promotion->get_promotion($config['per_page'], $param, '', $keyword, $sort);

		$this->load->view('pages/templates', $this->data);
	}

	public function create_promotion() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}
		$type         = $this->uri->segment(2);
		$field_id     = $this->uri->segment(3);
		$promotion_id = $this->uri->segment(4);
		$save         = $this->input->post('save');

		if (!empty($save)) {
			$arr = array(
				'promotion_name'      => $this->input->post('promotion_name'),
				'promotion_startdate' => date('Y-m-d', strtotime($this->input->post('promotion_startdate'))),
				'promotion_enddate'   => date('Y-m-d', strtotime($this->input->post('promotion_enddate'))),
				'promotion_type'      => $this->input->post('promotion_type'),
				'promotion_status'    => 1,
			);

			$promotion_id = $this->input->post('promotion_id');

			if (empty($promotion_id)) {
				$promotion_id = $this->model_promotion->insert($arr);

				$arr_detail = array(
					'promotion_id'                         => $promotion_id,
					'promotion_detail_field'               => $this->input->post('promotion_type_field'),
					'promotion_detail_mapping_field_value' => $this->input->post('percentage')
				);

				$this->model_promotion->insert_promotion_detail($arr_detail);
			} else {
				$this->model_promotion->update($arr, $promotion_id);

				$arr_detail = array(
					'promotion_detail_field'               => $this->input->post('promotion_type_field'),
					'promotion_detail_mapping_field_value' => $this->input->post('percentage')
				);

				$this->model_promotion->update_promotion_detail($arr_detail, $promotion_id);
			}

			$gift = $this->input->post('gift');

			foreach ($gift as $key => $value) {
				if (!empty($value)) {
					$arr_item = array(
						'promotion_id'                  => $promotion_id,
						'product_id'                    => $value,
						'promotion_item_mapping_status' => 1,
					);

					$check_exist = $this->model_promotion->check_item_exist($promotion_id, $value);

					if ($check_exist == 0) {
						$this->model_promotion->insert_promotion_item($arr_item);
					}
				}
			}

			redirect(base_url().'promotion/');
		}

		$this->data['subcontent']   = 'pages/create_promotion';
		$this->data['products']     = $this->model_product->get_products();
		$this->data['types']        = $this->model_promotion->get_promotion_type();
		$this->data['type']         = $type;
		$this->data['field']        = $field_id;
		$this->data['promotion_id'] = $promotion_id;
		$this->data['detail']       = $this->model_promotion->get_promotion_detail($promotion_id);
		$this->load->view('pages/templates', $this->data);
	}

	public function new_promotion() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		if (!empty($this->session->userdata['new_promotion.keyword'])) {
			$keyword = $this->session->userdata['new_promotion.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('new_promotion.keyword', $keyword);
			$keyword = $this->session->userdata['new_promotion.keyword'];
		}

		$this->data['keyword'] = $keyword;
		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'new_promotion.keyword' => '',
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

		$this->data['subcontent'] = 'pages/new_promotion';
		$promotion_id             = $this->uri->segment(2);
		$param                    = $this->uri->segment(3);

		$config['base_url']   = base_url().'new-promotion/'.$promotion_id;
		$config['total_rows'] = $this->model_promotion->count_rows($sup_id);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);

		$this->data['promotion_id'] = $promotion_id;
		$products                   = array();

		if (!empty($promotion_id)) {
			$items    = $this->model_promotion->get_promotion_item($promotion_id);
			$products = $this->model_promotion->get_product_by_promotion($items, $keyword, $sort);
		}

		$this->data['products'] = $products;
		$this->data['available'] = $this->model_promotion->get_available_promotion();
		$this->data['detail']    = $this->model_promotion->get_promotion_by_id($promotion_id);
		$this->data['ids']       = $this->model_promotion->get_promotion_product_id($promotion_id);

		$this->load->view('pages/templates', $this->data);
	}

	public function voucher() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/voucher';
		$param                    = $this->uri->segment(2);

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];

		if (!empty($this->session->userdata['promotion.keyword'])) {
			$keyword = $this->session->userdata['promotion.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('promotion.keyword', $keyword);
			$keyword = $this->session->userdata['promotion.keyword'];
		}

		$this->data['keyword'] = $keyword;
		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'promotion.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_promotion->update_voucher(array('voucher_status' => 0), $selected[$j]);
			}

			$msg = $this->setMessage('Inactive voucher successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_promotion->update_voucher(array('voucher_status' => 1), $selected[$j]);
			}

			$msg = $this->setMessage('Active voucher successful', 'success');
		}

		$config['base_url']   = base_url().'voucher/';
		$config['total_rows'] = $this->model_promotion->count_voucher($sup_id);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 3;

		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
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

		$this->data['vouchers'] = $this->model_promotion->get_voucher($config['per_page'], $param, $keyword);

		sortData($this->data['vouchers'], $order_col, $order_dir);
		$this->load->view('pages/templates', $this->data);
	}

	public function voucher_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/voucher_detail';
		$param                    = $this->uri->segment(2);
		$save                     = $this->input->post('save');

		if (!empty($save)) {
			$data = $this->input->post('data');

			if (!empty($param)) {
				$this->model_promotion->update_voucher($data, $param);
			} else {
				$this->model_promotion->insert_voucher($data);
			}
		}

		$this->data['voucher_id'] = $param;
		$this->data['voucher']    = $this->model_promotion->get_voucher_by_id($param);

		$this->load->view('pages/templates', $this->data);
	}

	public function update_promotion() {
		$promotion_id = $this->input->post('promotion_id');
		$prod_id      = $this->input->post('prod_id');
		$choose       = $this->input->post('choose');
		$arr          = array(
			'promotion_id'                  => $promotion_id,
			'product_id'                    => $prod_id,
			'promotion_item_mapping_status' => 1,
		);

		if ($choose == 1) {
			$this->model_promotion->insert_promotion($arr);
		} elseif ($choose == 2) {
			$this->model_promotion->delete_promotion($arr);
		}
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}

	public function get_promotion_field() {
		$type_id = $this->input->post('type_id');
		$data    = '';
		$ids     = $this->model_promotion->get_promotion_field_id($type_id);

		if (!empty($ids)) {
			$fields = $this->model_promotion->get_promotion_field($ids);
			$data .= '<option value="">-- Select --</option>';

			foreach ($fields as $key => $field) {
				$data .= '<option value="'.$field['promotion_type_field_id'].'">'.$field['promotion_type_field_name'].'</option>';
			}
		}

		echo $data;
	}

	public function get_gift() {
		$products = $this->model_product->get_products();
		$data     = '';
		$data     = '<div class="form-group"><label class="col-sm-2 control-label" for="promotion_name">Choose gift: </label>
            <div class="col-sm-10">';
		$data .= '<select name="gift[]">';
		$data .= '<option value="">-- Select product --</option>';

		foreach ($products as $key => $value) {
			$data .= '<option value="'.$value['prod_id'].'">'.$value['sup_name'].'-'.$value['prod_name'].'</option>';
		}

		$data .= '</select></div></div>';

		echo $data;
	}

	public function delete_item() {
		$data                 = array();
		$data['promotion_id'] = $this->input->post('promotion_id');
		$data['product_id']   = $this->input->post('product_id');

		return $this->model_promotion->delete_promotion($data);
	}
}
?>
