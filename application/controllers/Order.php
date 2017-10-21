<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// aaa
class Order extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_order', 'model_product', 'model_config'));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "pagination", "my_auth", "asiantec_mail"));

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

		$msg    = '';
		$update = $this->input->post('update_status');

		if (!empty($update)) {
			$order_id = $this->input->post('order_id');
			$status   = $this->input->post('status');

			if (!empty($status) && !empty($order_id)) {
				if ($status == 3) {
					$transaction_type = 2;
				} 
				elseif ($status == 2 || $status == 6) {
					if ($status == 2) {
						$transaction_type = 4;
					} elseif ($status == 6) {
						$transaction_type = 5;
					}

					$sup_order_arr=$this->model_order->get_sup_order($order_id);
					
					foreach ($sup_order_arr as &$sup_order_line) {
					    $reason       = $this->input->post('reason');
						$cancel_note  = $this->input->post('cancelled_note');
						$cancel_array = array(
							'order_id'      => $sup_order_line['sup_order_id'],
							'cancel_reason'   => 12,
							'cancel_shipping_reason' => null,
							'cancelled_date'   => date('Y-m-d'),
							'cancel_note'   => $cancel_note,
						);
						$this->model_order->insert_cancel_supplier_order($cancel_array);
					}
					
					$cancel_array = array(
						'order_id'       => $order_id,
						'cancelled_date' => date('Y-m-d'),
						'cancel_note'    => $cancel_note,
					);

					//check if status is on the way then we need to store extra shipping cancel reason
					$ontheway = $this->input->post('ontheway');
					if ($ontheway == "false") {
						$cancel_array['cancel_shipping_reason'] = null;
						$cancel_array['cancel_reason']          = $reason;
					} else {
						$cancel_array['cancel_shipping_reason'] = $reason;
						$cancel_array['cancel_reason']          = 9;
					}
					$this->model_order->insert_cancel_order($cancel_array);
				} 
				elseif ($status == 5) {
					$transaction_type = 3;
				}

				elseif ($status == 8) {

					//insert current date to actual delivery date of orders table
					$data_array       = array(
						'order_shipping_shipper_actdate' => date('Y-m-d')
					);
					$this->model_order->update_main_order($data_array, $order_id);

					//send mail inform client order completed
					$order_detail     = $this->model_order->get_order_detail($order_id);
					$cus_email        = $order_detail['cus_email'];
					$detail['detail'] = $order_detail;
					$array            = array(
						'subject'  => 'Marketplace - Order completed',
						'to'       => $cus_email,
						'template' => $this->load->view('email/order_complete', $detail, true),
					);

					$mail = new Asiantec_mail;
					$mail->sendmail($array);

					$transaction_type = 8;
				}
				elseif ($status == 4) {
					$transaction_type = 7;
					
					$ship_array       = array(
						'order_shipping_shipper_id'       => $this->input->post('shipper_agent'),
						'order_shipping_shipper_tracking' => $this->input->post('tracking_id'),
						'order_shipping_shipper_estdate' => date('Y-m-d', strtotime($this->input->post('est_date'))),
						'order_shipping_shipper_freeship' => $this->input->post('freeship'),
						'order_shipping_shipper_shipfee' => $this->input->post('shipfee'),
						'order_shipping_shipper_shipdate' => date('Y-m-d')
					);
					
					$this->model_order->update_main_order($ship_array, $order_id);
					$this->model_order->update_main_order(array('order_status' => 4), $order_id);

					//send mail to customer with shipping information
					$detail = $this->model_order->get_order_detail($order_id);
					$data_arr = array(
						'detail' => $detail,
					);

					$array = array(
						'subject'  => 'Marketplace - Your order '.$order_id.' has been shipped',
						'to'       => $detail['cus_email'],
						'template' => $this->load->view('email/admin_order_ontheway', $data_arr, true),
					);

					$mail = new Asiantec_mail;

					if (!$mail->sendmail($array)) {
						$msg = $this->setMessage('Fail to send email message. Please try again later.</br> We are very sorry for this inconvenience.', 'success');
					} else {
						$msg = $this->setMessage('Email has been sent to '.$detail['cus_email'].' with shipping information.', 'success');
					}
				}
				//insert order log
				$this->model_order->update_main_order(array('order_status' => $status), $order_id);
				$sup_order_log = array(
						'order_id' => $order_id,
						'transaction_type'  => $transaction_type,
						'transaction_time'  => date('Y-m-d H:i:s')
					);
				$this->model_order->insert_warehouse_order_log($sup_order_log);

			}
		}

		$this->data['title']      = 'Orders';
		$this->data['subcontent'] = 'pages/order';

		$msg_flash = $this->session->flashdata('msg');

		if (!empty($msg_flash)) {
			$this->data['msg'] = $msg_flash;
		} else {
			$this->data['msg'] = '';
		}

		$param   = $this->uri->segment(2);
		$keyword = '';

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('order.keyword', $keyword);
			$keyword = $this->session->userdata['order.keyword'];
		} else {
			$this->session->unset_userdata(array('order.keyword' => ''));
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

		$status_list = array(1, 3, 4, 7);

		$this->data['keyword'] = $keyword;
		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'order.keyword' => NULL,
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = NULL;
			$keyword               = NULL;
		}
		//pagination
		$config['base_url']   = base_url().'order';
		$config['total_rows'] = $this->model_order->count_rows($status_list);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$this->data['orders'] = $this->model_order->get_orders('', $sup_id, $status_list, $config['per_page'], $param, $keyword, $sort);
		$this->data['msg']    = $msg;
		
		$this->load->view('pages/templates', $this->data);
	}

	public function order_cancel() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Orders cancelled';
		$this->data['subcontent'] = 'pages/order_cancel';

		$param   = $this->uri->segment(2);
		$keyword = '';

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('order_cancel.keyword', $keyword);
			$keyword = $this->session->userdata['order_cancel.keyword'];
		} else {
			$this->session->unset_userdata(array('order_cancel.keyword' => ''));
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'order_cancel.keyword' => NULL,
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = NULL;
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

		$status_list = array(2, 6);

		//pagination
		$config['base_url']   = base_url().'order';
		$config['total_rows'] = $this->model_order->count_rows($status_list);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$this->data['orders'] = $this->model_order->get_orders('', '', $status_list, $config['per_page'], $param, $keyword, $sort);
		$this->load->view('pages/templates', $this->data);
	}

	public function order_complete() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['title']      = 'Orders completed';
		$this->data['subcontent'] = 'pages/order_complete';

		$param   = $this->uri->segment(2);
		$keyword = '';

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('product.keyword', $keyword);
			$keyword = $this->session->userdata['product.keyword'];
		} else {
			$this->session->unset_userdata(array('product.keyword' => ''));
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

		$status_list = array(8);

		$this->data['keyword'] = $keyword;
		//pagination
		$config['base_url']   = base_url().'order';
		$config['total_rows'] = $this->model_order->count_rows($status_list);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		$this->data['orders'] = $this->model_order->get_orders('', '', $status_list, $config['per_page'], $param, $keyword, $sort);

		$this->load->view('pages/templates', $this->data);
	}

	public function order_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
		}
		$id         = $this->uri->segment(2);
		$checkorder = $this->model_order->check_order($id);

		if (!$checkorder) {
			redirect(base_url()."order");
		}

		$this->data['title']      = 'Orders detail';
		$this->data['subcontent'] = 'pages/order_detail';

		$param                = $this->uri->segment(2);
		$detail               = $this->model_order->get_order_detail($param);
		$this->data['detail'] = $detail;

		$this->load->view('pages/templates', $this->data);
	}

	public function update_order($order_id, $order_status) {
		$this->data['order_id']     = $order_id;
		$this->data['order_status'] = $order_status;

		$this->load->view('pages/update_order', $this->data);
	}

	public function get_order_field() {
		$this->data['order_id'] = $this->input->post('order_id');
		$this->data['status']   = $this->input->post('status');
		$this->data['ontheway'] = $this->input->post('ontheway');
		if ($this->data['ontheway'] == "true") {
			$this->data['reasons'] = $this->model_order->get_canncel_shipping_reason(null);
		} else {
			$this->data['reasons'] = $this->model_order->get_cancel_reason(array(3));
		}

		$this->data['shippers'] = $this->model_order->get_company_shipper();

		$this->load->view('pages/update_order_field', $this->data);
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}

	public function print_order_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}
		$this->data['title'] = 'Orders detail';
		$param               = $this->uri->segment(2);
		$detail              = $this->model_order->get_order_detail($param);

		$this->data['detail'] = $detail;
		$this->load->view('pages/print_order_detail', $this->data);
	}
}
?>
