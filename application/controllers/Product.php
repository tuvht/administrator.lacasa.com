<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_product', 'model_category', 'model_config', 'model_order'));
		$this->load->helper(array("url", "form", 'my_data'));
		$this->load->library(array("form_validation", "session", "pagination", "my_auth"));

		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}

	}

	public function active() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Active Products';
		$this->data['subcontent'] = 'pages/active_product';

		$param = $this->uri->segment(2);

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];
		$stock    = $this->input->post('stock');
		if (!empty($this->session->userdata['product.keyword'])) {
			$keyword = $this->session->userdata['product.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('product.keyword', $keyword);
			$keyword = $this->session->userdata['product.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'product.keyword' => NULL,
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = NULL;
			$keyword               = NULL;
		}

		if (!empty($stock)) {
			foreach ($stock as $key => $value) {
				$value1 = $value['value1'];

				if (isset($value['value2'])) {
					$value2 = explode('-', $value['value2']);
					$value2 = $value2[1];
				} else {
					$value2 = 0;
				}

				$attribute                  = $this->model_product->get_attribute($value1, $value2);
				$product_variant_mapping_id = $attribute['product_variant_mapping_id'];

				$arr_where = array(
					'product_id'                 => $key,
					'product_variant_mapping_id' => $product_variant_mapping_id,
					'supplier_warehouse'         => $value['sup_warehouse_id'],
				);

				$check_exist = $this->model_product->check_exist_stock($key, $value['sup_warehouse_id'], $product_variant_mapping_id);

				if ($check_exist > 0) {
					$this->model_product->update_warehouse_stock(array('product_warehouse_quantity' => $value['quantity']), $arr_where);
				} else {
					$insert_arr = array(
						'product_id'                 => $key,
						'product_variant_mapping_id' => $product_variant_mapping_id,
						'supplier_warehouse'         => $value['sup_warehouse_id'],
						'product_warehouse_quantity' => $value['quantity'],
					);
					$this->model_product->insert_warehouse_stock($insert_arr);
				}

				if ($value['quantity'] == 0) {
					$product_log = array(
						'product_id'       => $key,
						'transaction_type' => 7,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Update stock successful', 'success');
			}
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 0), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 6,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Inactive product successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 1), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 8,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Active product successful', 'success');
		}

		if ($this->input->post('published')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '1'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 6,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Active product successful', 'success');
			}
		}

		if ($this->input->post('unpublished')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '0'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 8,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Inactive product successful', 'success');
			}
		}

		if ($this->input->post('delete')) {
			$selected = $this->input->post('selected');
			$count    = count($selected);

			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->delete($selected[$j]);
					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 9,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}
				$msg = $this->setMessage('Delete product successful', 'success');
			}
		}

		$order_col = $this->input->get('order') ? $this->input->get('order') : 'p.prod_id';
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
		$config['base_url']   = base_url().'active-product';
		$config['total_rows'] = $this->model_product->count_rows(1, $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);
		$products = $this->model_product->get_products($config['per_page'], $param, 1, $keyword, $sort);
		$this->data['products'] = $products;

		$msg_flash = $this->session->flashdata('msg');

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->load->view('pages/templates', $this->data);
	}

	public function inactive() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Inactive Products';
		$this->data['subcontent'] = 'pages/inactive_product';

		$param = $this->uri->segment(2);

		if (!empty($this->session->userdata['product.keyword'])) {
			$keyword = $this->session->userdata['product.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('product.keyword', $keyword);
			$keyword = $this->session->userdata['product.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'product.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];
		$stock    = $this->input->post('stock');

		if (!empty($stock)) {
			foreach ($stock as $key => $value) {
				$value1 = $value['value1'];

				if (isset($value['value2'])) {
					$value2 = explode('-', $value['value2']);
					$value2 = $value2[1];
				} else {
					$value2 = 0;
				}

				$attribute                  = $this->model_product->get_attribute($value1, $value2);
				$product_variant_mapping_id = $attribute['product_variant_mapping_id'];

				$arr_where = array(
					'product_id'                 => $key,
					'product_variant_mapping_id' => $product_variant_mapping_id,
					'supplier_warehouse'         => $value['sup_warehouse_id'],
				);

				$check_exist = $this->model_product->check_exist_stock($key, $value['sup_warehouse_id'], $product_variant_mapping_id);

				if ($check_exist > 0) {
					$this->model_product->update_warehouse_stock(array('product_warehouse_quantity' => $value['quantity']), $arr_where);
				} else {
					$insert_arr = array(
						'product_id'                 => $key,
						'product_variant_mapping_id' => $product_variant_mapping_id,
						'supplier_warehouse'         => $value['sup_warehouse_id'],
						'product_warehouse_quantity' => $value['quantity'],
					);
					$this->model_product->insert_warehouse_stock($insert_arr);
				}

				if ($value['quantity'] == 0) {
					$product_log = array(
						'product_id'       => $key,
						'transaction_type' => 7,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Update stock successful', 'success');
			}
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 0), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 6,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Inactive product successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 1), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 8,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Active product successful', 'success');
		}

		if ($this->input->post('published')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '1'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 6,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Active product successful', 'success');
			}
		}

		if ($this->input->post('unpublished')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '0'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 8,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Inactive product successful', 'success');
			}
		}

		if ($this->input->post('delete')) {
			$selected = $this->input->post('selected');
			$count    = count($selected);
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->delete($selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 9,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}
				$msg = $this->setMessage('Delete product successful', 'success');
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

		//pagination
		$config['base_url']   = base_url().'inactive-product';
		$config['total_rows'] = $this->model_product->count_rows(0, $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$products               = $this->model_product->get_products($config['per_page'], $param, 0, $keyword, $sort);
		$this->data['products'] = $products;

		$msg_flash = $this->session->flashdata('msg');

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->load->view('pages/templates', $this->data);
	}

	public function product_in_view() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Products in view';
		$this->data['subcontent'] = 'pages/product_in_view';

		$param = $this->uri->segment(2);

		if (!empty($this->session->userdata['product.keyword'])) {
			$keyword = $this->session->userdata['product.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('product.keyword', $keyword);
			$keyword = $this->session->userdata['product.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'product.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];
		$stock    = $this->input->post('stock');

		if (!empty($stock)) {
			foreach ($stock as $key => $value) {
				$value1 = $value['value1'];

				if (isset($value['value2'])) {
					$value2 = explode('-', $value['value2']);
					$value2 = $value2[1];
				} else {
					$value2 = 0;
				}

				$attribute                  = $this->model_product->get_attribute($value1, $value2);
				$product_variant_mapping_id = $attribute['product_variant_mapping_id'];

				$arr_where = array(
					'product_id'                 => $key,
					'product_variant_mapping_id' => $product_variant_mapping_id,
					'supplier_warehouse'         => $value['sup_warehouse_id'],
				);

				$check_exist = $this->model_product->check_exist_stock($key, $value['sup_warehouse_id'], $product_variant_mapping_id);

				if ($check_exist > 0) {
					$this->model_product->update_warehouse_stock(array('product_warehouse_quantity' => $value['quantity']), $arr_where);
				} else {
					$insert_arr = array(
						'product_id'                 => $key,
						'product_variant_mapping_id' => $product_variant_mapping_id,
						'supplier_warehouse'         => $value['sup_warehouse_id'],
						'product_warehouse_quantity' => $value['quantity'],
					);
					$this->model_product->insert_warehouse_stock($insert_arr);
				}

				if ($value['quantity'] == 0) {
					$product_log = array(
						'product_id'       => $key,
						'transaction_type' => 7,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Update stock successful', 'success');
			}
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 0), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 6,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Inactive product successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 1), $selected[$j]);

				$product_log = array(
					'product_id'       => $selected[$j],
					'transaction_type' => 8,
					'transaction_time' => date('Y-m-d H:i:s'),
					'user'             => $sup_id,
				);

				$this->model_product->insert_product_log($product_log);
			}

			$msg = $this->setMessage('Active product successful', 'success');
		}

		if ($this->input->post('published')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '1'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 6,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Active product successful', 'success');
			}
		}

		if ($this->input->post('unpublished')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '0'), $selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 8,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				$msg = $this->setMessage('Inactive product successful', 'success');
			}
		}

		if ($this->input->post('delete')) {
			$selected = $this->input->post('selected');
			$count    = count($selected);
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->delete($selected[$j]);

					$product_log = array(
						'product_id'       => $selected[$j],
						'transaction_type' => 9,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}
				$msg = $this->setMessage('Delete product successful', 'success');
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

		//pagination
		$config['base_url']   = base_url().'inactive-product';
		$config['total_rows'] = $this->model_product->count_rows(0, $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$products               = $this->model_product->get_products($config['per_page'], $param, 2, $keyword);
		$this->data['products'] = $products;

		$msg_flash = $this->session->flashdata('msg');

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->load->view('pages/templates', $this->data);
	}

	public function out_of_stock() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Out of stock Products';
		$this->data['subcontent'] = 'pages/out_of_stock';

		$param = $this->uri->segment(2);

		if (!empty($this->session->userdata['out_stock.keyword'])) {
			$keyword = $this->session->userdata['out_stock.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('out_stock.keyword', $keyword);
			$keyword = $this->session->userdata['out_stock.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'out_stock.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];
		$stock    = $this->input->post('stock');

		if (!empty($stock)) {
			foreach ($stock as $key => $value) {
				$value1 = $value['value1'];

				if (isset($value['value2'])) {
					$value2 = explode('-', $value['value2']);
					$value2 = $value2[1];
				} else {
					$value2 = 0;
				}

				$attribute                  = $this->model_product->get_attribute($value1, $value2);
				$product_variant_mapping_id = $attribute['product_variant_mapping_id'];

				$arr_where = array(
					'product_id'                 => $key,
					'product_variant_mapping_id' => $product_variant_mapping_id,
					'supplier_warehouse'         => $value['sup_warehouse_id'],
				);

				$check_exist = $this->model_product->check_exist_stock($key, $value['sup_warehouse_id'], $product_variant_mapping_id);

				if ($check_exist > 0) {
					$this->model_product->update_warehouse_stock(array('product_warehouse_quantity' => $value['quantity']), $arr_where);
				} else {
					$insert_arr = array(
						'product_id'                 => $key,
						'product_variant_mapping_id' => $product_variant_mapping_id,
						'supplier_warehouse'         => $value['sup_warehouse_id'],
						'product_warehouse_quantity' => $value['quantity'],
					);
					$this->model_product->insert_warehouse_stock($insert_arr);
				}

				$msg = $this->setMessage('Update stock successful', 'success');
			}
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 0), $selected[$j]);
			}

			$msg = $this->setMessage('Inactive product successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_product->update_product(array('prod_status' => 1), $selected[$j]);
			}

			$msg = $this->setMessage('Active product successful', 'success');
		}

		if ($this->input->post('published')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '1'), $selected[$j]);
				}

				$msg = $this->setMessage('Active product successful', 'success');
			}
		}

		if ($this->input->post('unpublished')) {
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->update_product(array('prod_status' => '0'), $selected[$j]);
				}

				$msg = $this->setMessage('Inactive product successful', 'success');
			}
		}

		if ($this->input->post('delete')) {
			$selected = $this->input->post('selected');
			$count    = count($selected);
			if ($count == 0) {
				$msg = $this->setMessage('Please selected', 'warning');
			} else {
				for ($j = 0; $j < $count; $j++) {
					$this->model_product->delete($selected[$j]);
				}
				$msg = $this->setMessage('Delete product successful', 'success');
			}
		}

		$order_col = $this->input->get('order')?$this->input->get('order'):'p.prod_id';
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
		$config['base_url']   = base_url().'out-of-stock-product';
		$config['total_rows'] = $this->model_product->count_rows_out_stock('', $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$products = $this->model_product->get_products_out_stock_list($config['per_page'], $param, '', $keyword, $sort);
		$this->data['products'] = $products;

		$msg_flash = $this->session->flashdata('msg');

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->load->view('pages/templates', $this->data);
	}

	public function update_stock() {
		if ($this->my_auth->is_Login()) {
			$sup_id = $this->session->userdata['sup_id'];
		}

		$param                        = $this->uri->segment(2);
		$this->data['prod_id']        = $param;
		$supplier_id                  = $this->uri->segment(3);
		$this->data['stock_total']    = $this->model_product->get_product_stock($param);
		$this->data['stock_quantity'] = $this->model_product->get_stock_quantity($param);
		$this->data['warehouses']     = $this->model_product->get_warehouse($supplier_id);

		$product_detail['variant']        = $this->model_product->get_product_all_variant($param);
		$product_detail['category_field'] = $this->model_product->get_category_field($param);
		$this->data['product']            = $product_detail;
		$this->load->view('pages/update_stock', $this->data);
	}
	public function product_detail() {
		if ($this->my_auth->is_Login()) {
			$sup_id = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}

		$id = $this->uri->segment(2);

		$checkproduct = $this->model_product->check_product($id);
		if (!$checkproduct) {
			redirect(base_url()."product-in-view");
		}

		$save = $this->input->post('save');

		if (!empty($save)) {
			$this->load->library('upload');
			$this->form_validation->set_rules("form[prod_name]", "Product name", "required");
			$this->form_validation->set_rules("form[prod_brand_id]", "Brand", "required");
			$this->form_validation->set_rules("form[prod_type]", "Type", "required");

			if ($this->form_validation->run() == false) {
				$this->data['error'] = '';
			} else {
				$category        = $this->input->post('category');
				$master_category = $this->input->post('master_category');
				$fields          = $this->model_category->get_category_field($category);
				$form            = $this->input->post('form');

				if (!empty($id)) {
					$product_array = array(
						'prod_name'               => $form['prod_name'],
						'prod_supplierinternalid' => $form['prod_supplierinternalid'],
						'prod_price'              => $form['prod_price'],
						'prod_brand_id'           => $form['prod_brand_id'],
						'prod_made_country'       => $form['prod_made_country'],
						'prod_description'        => $form['prod_description'],
						'prod_type'               => $form['prod_type'],
					);

					$prod_id = $id;
					$this->model_product->update_product($product_array, $prod_id);

					$product_log = array(
						'product_id'       => $prod_id,
						'transaction_type' => 2,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				} else {
					$product_array = array(
						'prod_name'               => $form['prod_name'],
						'prod_supplierinternalid' => $form['prod_supplierinternalid'],
						'prod_price'              => $form['prod_price'],
						'prod_brand_id'           => $form['prod_brand_id'],
						'prod_made_country'       => $form['prod_made_country'],
						'prod_mas_id'             => $master_category,
						'prod_cat_id'             => $category,
						'prod_description'        => $form['prod_description'],
						'prod_supplier_id'        => $sup_id,
						'prod_upload_date'        => date('Y-m-d'),
						'prod_type'               => $form['prod_type'],
						'prod_status'             => 2,
					);

					$prod_id = $this->model_product->insert_product($product_array);

					$product_log = array(
						'product_id'       => $prod_id,
						'transaction_type' => 1,
						'transaction_time' => date('Y-m-d H:i:s'),
						'user'             => $sup_id,
					);

					$this->model_product->insert_product_log($product_log);
				}

				if (!empty($form['variant'])) {
					foreach ($form['variant'] as $i => $variant) {
						$product_variant_id = array();

						foreach ($variant['category_variant'] as $cat_field_key => $cat_field_value) {
							$variant_value = $this->model_product->get_product_variant($prod_id, $cat_field_value);

							if (!empty($variant_value)) {
								$product_variant_id[] = $variant_value['product_variant_id'];
							} else {
								$variant_array = array(
									'product_id'             => $prod_id,
									'cat_field_id'           => $cat_field_key,
									'variant_value'          => $cat_field_value,
									'product_variant_status' => '1',
								);

								$product_variant_id[] = $this->model_product->insert_product_variant($variant_array);
							}
						}

						if (!empty($product_variant_id)) {
							if (empty($product_variant_id[1])) {
								$product_variant_id[1] = 0;
							}

							$variant_map_array = array(
								'product_id'                           => $prod_id,
								'product_variant_supplier_internal_id' => $variant['sku'],
								'product_variant_value1'               => $product_variant_id[0],
								'product_variant_value2'               => $product_variant_id[1],
								'product_variant_price'                => $variant['price'],
								'product_variant_note'                 => $variant['note'],
								'product_variant_status'               => '1',
							);

							if (!empty($id)) {
								$mapping_id = $variant['mapping_id'];

								if (!empty($mapping_id)) {
									$this->model_product->update_product_variant_mapping($variant_map_array, $mapping_id);
								} else {
									$mapping_id = $this->model_product->insert_product_variant_mapping($variant_map_array);
								}

								$product_log = array(
									'product_id'       => $prod_id,
									'transaction_type' => 4,
									'transaction_time' => date('Y-m-d H:i:s'),
									'user'             => $sup_id,
								);

								$this->model_product->insert_product_log($product_log);
							} else {
								$mapping_id = $this->model_product->insert_product_variant_mapping($variant_map_array);
							}

							if (isset($_FILES['form_variant_'.$i.'_image'])) {
								$variant_image                   = $_FILES['form_variant_'.$i.'_image'];
								$number_of_variant               = count($variant_image['name']);
								$config_variant['upload_path']   = './images/products/variant';
								$config_variant['allowed_types'] = 'gif|jpg|png';

								for ($j = 0; $j < $number_of_variant; $j++) {
									if (!empty($variant_image['name'][$j])) {
										$_FILES['form_variant_'.$i.'_image']['name']     = $variant_image['name'][$j];
										$_FILES['form_variant_'.$i.'_image']['type']     = $variant_image['type'][$j];
										$_FILES['form_variant_'.$i.'_image']['tmp_name'] = $variant_image['tmp_name'][$j];
										$_FILES['form_variant_'.$i.'_image']['error']    = $variant_image['error'][$j];
										$_FILES['form_variant_'.$i.'_image']['size']     = $variant_image['size'][$j];
										$config_variant['file_name']                     = $prod_id.'_'.$mapping_id.'_variant_'.$j.'_'.time();
										$this->upload->initialize($config_variant);

										if ($this->upload->do_upload('form_variant_'.$i.'_image')) {
											$data_img_variant['uploads'] = $this->upload->data();
											$variant_image_insert        = array(
												'product_variant_id'   => $mapping_id,
												'variant_image_width'  => $data_img_variant['uploads']['image_width'],
												'variant_image_height' => $data_img_variant['uploads']['image_height'],
												'variant_image_size'   => $data_img_variant['uploads']['file_size'],
												'variant_image_path'   => 'images/products/variant/'.$data_img_variant['uploads']['file_name'],
												'variant_image_status' => '1',
											);
											$this->model_product->insert_variant_image($variant_image_insert);

											$product_log = array(
												'product_id'       => $prod_id,
												'transaction_type' => 5,
												'transaction_time' => date('Y-m-d H:i:s'),
												'user'             => $sup_id,
											);

											$this->model_product->insert_product_log($product_log);
										} else {
											$data_img_variant['upload_errors'][$i] = $this->upload->display_errors();
										}
									}
								}
							}

							foreach ($variant['stock'] as $stock_id => $stock_quantity) {
								$stock_array = array(
									'product_id'                 => $prod_id,
									'product_variant_mapping_id' => $mapping_id,
									'supplier_[warehouse]'       => $stock_id,
									'product_warehouse_quantity' => $stock_quantity,
								);

								$check_variant_exist_stock = $this->model_product->check_variant_exist_stock($prod_id, $mapping_id, $stock_id);

								if (!empty($id)) {
									if ($check_variant_exist_stock == 0) {
										$this->model_product->insert_warehouse_stock($stock_array);
									} else {
										$where = array(
											'product_id'                 => $prod_id,
											'product_variant_mapping_id' => $mapping_id,
											'supplier_warehouse'         => $stock_id,
										);
										$this->model_product->update_warehouse_stock($stock_array, $where);
									}
								} else {
									$this->model_product->insert_warehouse_stock($stock_array);
								}
							}
						}
					}
				}

				if (empty($id)) {
					foreach ($fields as $field) {
						$field_data = "";

						if (!empty($form[$field['cat_field_name']])) {
							$field_data = $form[$field['cat_field_name']];
						}

						if (!empty($field_data)) {
							$field_info   = $this->model_category->get_category_field_by_name($field['cat_field_name']);
							$detail_array = array(
								'prod_id'                                                      => $prod_id,
								'prod_detail_catfield_id'                                      => $field_info['cat_field_id'],
								'prod_detail_catfield_value'.$field_info['cat_field_valuetype']=> $field_data,
							);
							$this->model_product->insert_product_detail($detail_array);
						}
					}

					foreach ($form['stock'] as $key => $quantity) {
						$insert_stock_arr = array(
							'product_id'                 => $prod_id,
							'product_variant_mapping_id' => 0,
							'supplier_warehouse'         => $key,
							'product_warehouse_quantity' => $quantity,
						);
						$this->model_product->insert_warehouse_stock($insert_stock_arr);
					}
				} else {
					foreach ($fields as $field) {
						$field_data = "";

						if (!empty($form[$field['cat_field_name']])) {
							$field_data = $form[$field['cat_field_name']];
						}

						if (!empty($field_data)) {
							$field_info   = $this->model_category->get_category_field_by_name($field['cat_field_name']);
							$detail_array = array(
								'prod_detail_catfield_value'.$field_info['cat_field_valuetype']=> $field_data,
							);
							$where_field = array(
								'prod_id'                 => $prod_id,
								'prod_detail_catfield_id' => $field_info['cat_field_id'],
							);
							$this->model_product->update_product_detail($detail_array, $where_field);
						}
					}

					foreach ($form['stock'] as $key => $quantity) {
						$check_exist = $this->model_product->check_exist_stock($prod_id, $key, 0);

						if ($check_exist > 0) {
							$update_stock_arr = array(
								'product_warehouse_quantity' => $quantity,
							);
							$where_stock = array(
								'product_id'                 => $prod_id,
								'product_variant_mapping_id' => 0,
								'supplier_warehouse'         => $key,
							);
							$this->model_product->update_warehouse_stock($update_stock_arr, $where_stock);
						} else {
							$insert_stock_arr = array(
								'product_id'                 => $prod_id,
								'product_variant_mapping_id' => 0,
								'supplier_warehouse'         => $key,
								'product_warehouse_quantity' => $quantity,
							);
							$this->model_product->insert_warehouse_stock($insert_stock_arr);
						}
					}
				}

				if (!empty($_FILES['image'])) {
					$files          = $_FILES['image'];
					$number_of_file = sizeof($_FILES['image']['tmp_name']);

					$config['upload_path']   = './images/products/main';
					$config['allowed_types'] = 'gif|jpg|png';

					for ($i = 0; $i < $number_of_file; $i++) {
						if (!empty($files['name'][$i])) {
							$_FILES['image']['name']     = $files['name'][$i];
							$_FILES['image']['type']     = $files['type'][$i];
							$_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
							$_FILES['image']['error']    = $files['error'][$i];
							$_FILES['image']['size']     = $files['size'][$i];
							$config['file_name']         = $prod_id.'_main_'.$i.'_'.time();
							$this->upload->initialize($config);

							if ($this->upload->do_upload('image')) {
								$data['uploads'][$i] = $this->upload->data();
								$image_insert        = array(
									'prod_id'           => $prod_id,
									'prod_image_width'  => $data['uploads'][$i]['image_width'],
									'prod_image_height' => $data['uploads'][$i]['image_height'],
									'prod_image_size'   => $data['uploads'][$i]['file_size'],
									'prod_image_path'   => 'images/products/main/'.$data['uploads'][$i]['file_name'],
									'prod_image_status' => '1',
								);
								$this->model_product->insert_image($image_insert);

								$product_log = array(
									'product_id'       => $prod_id,
									'transaction_type' => 5,
									'transaction_time' => date('Y-m-d H:i:s'),
									'user'             => $sup_id,
								);

								$this->model_product->insert_product_log($product_log);
							} else {
								$data['upload_errors'][$i] = $this->upload->display_errors();
							}
						}
					}
				}
			}
		}

		$this->data['subcontent']        = 'pages/product_detail';
		$this->data['master_categories'] = $this->model_category->get_master_category();
		$this->data['parent_categories'] = $this->model_category->get_parent_category();
		$this->data['brands']            = $this->model_category->get_brand();
		$this->data['types']             = $this->model_product->get_product_type();
		$this->data['quantity']          = $this->model_product->get_stock_quantity($id);
		$this->data['countries']         = $this->model_category->get_country();
		$product_detail                  = $this->model_product->get_product_by_id($id);

		if (!empty($id)) {
			$category                       = $this->model_category->get_category_by_catid($product_detail['prod_cat_id']);
			$mas_category                   = $this->model_category->get_mas_category_by_id($product_detail['prod_mas_id']);
			$product_detail['cat_name']     = $category['cat_name'];
			$product_detail['mas_cat_name'] = $mas_category['mas_cat_name'];
		}

		$this->data['product_detail'] = $product_detail;

		$warehouses                   = $this->model_product->get_warehouse($product_detail['prod_supplier_id']);
		$this->data['json_warehouse'] = json_encode($warehouses);
		$this->data['warehouses']     = $warehouses;
		$this->data['product_images'] = $this->model_product->get_product_image($id);
		$product_variant_list         = $this->model_product->get_variant_mapping_by_product_id($id);
		$this->data['variants']       = $product_variant_list;
		$this->data['has_variant']    = count($product_variant_list);
		$this->data['prod_id']        = $id;
		$this->data['cat_field']      = $this->model_product->get_category_field_id($id);
		$this->data['criteria']       = $this->model_product->get_product_check($id);

		$this->load->view('pages/templates', $this->data);
	}

	public function save_criteria() {
		if ($this->my_auth->is_Login()) {
			$sup_id = $this->session->userdata['sup_id'];
		}

		$result   = $this->input->post('result');
		$detail   = $this->input->post('detail');
		$prod_id  = $this->input->post('prod_id');
		$cat_id   = $this->input->post('cat_id');
		$criteria = $this->input->post('criteria');
		$where    = array(
			'prod_id'     => $prod_id,
			'criteria_id' => $criteria,
		);
		$data = array(
			'product_check_result' => $result,
			'product_check_notes'  => $detail,
			'product_check_time'   => date('Y-m-d H:i:s')
		);

		$this->model_product->update_product_check($data, $where);

		if ($result == 0) {
			$transaction_type = 10;
		} else {
			$transaction_type = 11;
		}

		$criteria_desc = $this->model_product->get_criteria_by_id($criteria);

		$log_arr = array(
			'product_id'       => $prod_id,
			'transaction_type' => $transaction_type,
			'transaction_time' => date('Y-m-d H:i:s'),
			'user'             => $sup_id,
			'new_value'        => $criteria_desc['criteria_description'],

		);

		$this->model_product->insert_product_log($log_arr);
		$count      = count($this->model_product->get_criteria($cat_id));
		$check_pass = count($this->model_product->get_product_check_pass($prod_id));

		if ($count == $check_pass) {
			$this->model_product->update_product(array('prod_status' => 1, 'prod_published_date' => date('Y-m-d')), $prod_id);
		}
	}

	public function get_category() {
		$par_cat_id = $this->input->post('par_cat_id');
		$categories = $this->model_category->get_category($par_cat_id);
		$result     = "";

		foreach ($categories as $key => $category) {
			$result .= '<li><label>';
			$result .= '<input type="radio" name="category" value="'.$category['cat_id'].'" />';
			$result .= '<span id="cat_'.$category['cat_id'].'">';
			$result .= $category['cat_name'];
			$result .= '</span></label></li>';
		}

		echo $result;
	}

	public function get_advance_field() {
		$prod_id                    = $this->input->post('prod_id');
		$cat_id                     = $this->input->post('cat_id');
		$cat_id1                    = $this->input->post('cat_id1');
		$cat_id2                    = $this->input->post('cat_id2');
		$this->data['fields']       = $this->model_category->get_category_field($cat_id, $cat_id1, $cat_id2);
		$this->data['detail_datas'] = $this->model_product->get_product_detail_by_id($prod_id);

		$this->load->view('pages/advance_field', $this->data);
	}

	public function get_variant_field() {
		$index                = $this->input->post('index');
		$cat_id1              = $this->input->post('cat_id1');
		$cat_id2              = $this->input->post('cat_id2');
		$this->data['field1'] = $this->model_category->get_category_variant_field($cat_id1);
		$this->data['field2'] = $this->model_category->get_category_variant_field($cat_id2);
		$this->data['index']  = $index;
		$this->data['cat1']   = $cat_id1;
		$this->data['cat2']   = $cat_id2;

		$this->load->view('pages/variant_field', $this->data);
	}

	public function get_option_field() {
		$cat_id = $this->input->post('cat_id');
		$fields = $this->model_category->get_category_field($cat_id);
		$data   = "";
		$data .= '<option value="">-- Select category --</option>';

		foreach ($fields as $key => $field) {
			$data .= '<option value="'.$field['cat_field_id'].'">'.$field['cat_field_name'].'</option>';
		}

		echo $data;
	}

	public function remove_image() {
		$img_id = $this->input->post('img_id');
		$this->model_product->delete_image($img_id);
	}

	public function remove_variant_image() {
		$img_id = $this->input->post('img_id');
		$this->model_product->delete_variant_image($img_id);
	}

	public function get_variant() {
		$variant_id     = $this->input->post('variant');
		$prod_id        = $this->input->post('prod_id');
		$category_field = $this->model_product->get_category_field($prod_id);
		$count_field    = count($category_field);
		$value2         = '';

		if ($count_field > 1) {
			$variant_value = $this->model_product->get_variant($prod_id, $variant_id);

			$value2 = '<option value="">-- Select --</option>';

			foreach ($variant_value as $key => $value) {
				$value2 .= '<option value="'.$variant_id.'-'.$value['product_variant_value2'].'">'.$value['variant_value'].'</option>';
			}
		}

		echo $value2;
	}

	public function get_attribute() {
		$variant_id = $this->input->post('variant');
		$prod_id    = $this->input->post('prod_id');
		$value      = explode('-', $variant_id);
		$value1     = $value[0];
		$value2     = $value[1];
		$attribute  = $this->model_product->get_attribute($value1, $value2);

		echo (int) $attribute['quantity'];
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}

	public function sortData(&$data = array(), $sortBy = '', $sortDestination = 'ASC') {
		if (empty($data) || $sortBy == '') {
			return;
		}

		usort(
			$data,
			function ($a, $b) use (&$sortBy, $sortDestination) {
				if ($sortDestination == 'DESC') {
					return $a[$sortBy] < $b[$sortBy];
				}

				return $a[$sortBy] > $b[$sortBy];
			}
		);
	}
}
?>
