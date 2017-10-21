<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array("model_supplier", "model_config", "model_product", "model_order"));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "my_auth", "cart", "pagination", "asiantec_mail"));

		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}
	}
	public function checkemailexist() {
		if ($this->input->post()) {
			$email = $this->input->post('email');
			if ($this->model_supplier->get_info_by_email($email) != false) {
				echo "1";
				die();
			}
			echo "0";
			die();
		}

	}
	public function index() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/active_supplier';

		$param = $this->uri->segment(2);

		if (!empty($this->session->userdata['supplier.keyword'])) {
			$keyword = $this->session->userdata['supplier.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('supplier.keyword', $keyword);
			$keyword = $this->session->userdata['supplier.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'supplier.keyword' => '',
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
		$config['base_url']   = base_url().'active-supplier';
		$config['total_rows'] = $this->model_supplier->count_rows(1);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['suppliers'] = $this->model_supplier->list_all(1, $config['per_page'], $param, '', $keyword);
		sortData($this->data['suppliers'], $order_col, $order_dir);
		$this->load->view('pages/templates', $this->data);
	}

	public function inactive_supplier() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/inactive_supplier';

		$param = $this->uri->segment(2);
		if (!empty($this->session->userdata['inactive_supplier.keyword'])) {
			$keyword = $this->session->userdata['inactive_supplier.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('inactive_supplier.keyword', $keyword);
			$keyword = $this->session->userdata['inactive_supplier.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'inactive_supplier.keyword' => '',
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
		$config['base_url']   = base_url().'active-supplier';
		$config['total_rows'] = $this->model_supplier->count_rows(0);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['suppliers'] = $this->model_supplier->list_all(0, $config['per_page'], $param, '', $keyword);
		sortData($this->data['suppliers'], $order_col, $order_dir);
		$this->load->view('pages/templates', $this->data);
	}

	public function supplier_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			// $sup_id = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/supplier';

		$param = $this->uri->segment(2);
		$msg   = "";

		if ($param) {
			$checksupplier = $this->model_supplier->check_supplier($param);
			if (!$checksupplier) {
				redirect(base_url()."active-supplier");
			}
		}

		$save = $this->input->post('save');

		if (!empty($save)) {
			if (empty($param)) {
				$sup_arr = array(
					'sup_name'              => $this->input->post('company'),
					'sup_telephone'         => $this->input->post('phone'),
					'sup_contact_name'      => $this->input->post('contact_name'),
					'sup_contact_title'     => $this->input->post('contact_title'),
					'sup_contact_cellphone' => $this->input->post('contact_cellphone'),
					'sup_contact_email'     => $this->input->post('contact_email'),
					'sup_joindate'          => date('Y-m-d'),
					'sup_bank'              => $this->input->post('bank_name'),
					'sup_bank_branch'       => $this->input->post('bank_branch'),
					'sup_bank_address'      => $this->input->post('bank_branch'),
					'sup_bank_accountnum'   => $this->input->post('account_number'),
					'sup_bank_accountname'  => $this->input->post('account_name'),
					'sup_email'             => $this->input->post('email'),
					'sup_password'          => md5($this->input->post('password')),
					'sup_status'            => 1,
				);

				$sup_id = $this->model_supplier->insert_supplier($sup_arr);

				$contract_arr = array(
					'sup_id'                  => $sup_id,
					'sup_contracttype'        => $this->input->post('contract_type'),
					'sup_contract_number'     => $this->input->post('contract_number'),
					'sup_contract_signdate'   => $this->input->post('sign_date'),
					'sup_contract_enddate'    => $this->input->post('end_date'),
					'sup_contract_percentage' => $this->input->post('percentage'),
					'sup_contract_staticfee'  => $this->input->post('static'),
					'sup_contract_status'     => 1,
				);

				$this->model_supplier->insert_contract($contract_arr);

				$data_arr = array(
					'email'    => $this->input->post('email'),
					'password' => $this->input->post('password')
				);

				$array = array(
					'subject'  => 'Marketplace - Welcome to Marketplace Supplier',
					'to'       => $this->input->post('email'),
					'template' => $this->load->view('email/supplier', $data_arr, true),
				);

				$mail = new Asiantec_mail;

				if (!$mail->sendmail($array)) {
					$msg = $this->setMessage('Fail to send email message. Please try again later.</br> We are very sorry for this inconvenience.', 'success');
				} else {
					$msg = $this->setMessage('Email has been sent to suppler email.', 'success');
				}
			} else {
				$sup_id = $param;

				$sup_arr = array(
					'sup_name'              => $this->input->post('company'),
					'sup_telephone'         => $this->input->post('phone'),
					'sup_contact_name'      => $this->input->post('contact_name'),
					'sup_contact_title'     => $this->input->post('contact_title'),
					'sup_contact_cellphone' => $this->input->post('contact_cellphone'),
					'sup_contact_email'     => $this->input->post('contact_email'),
					'sup_bank'              => $this->input->post('bank_name'),
					'sup_bank_branch'       => $this->input->post('bank_branch'),
					'sup_bank_address'      => $this->input->post('bank_branch'),
					'sup_bank_accountnum'   => $this->input->post('account_number'),
					'sup_bank_accountname'  => $this->input->post('account_name'),
					//'sup_username'          => $this->input->post('login_email'),
				);
				$this->model_supplier->update_supplier($sup_arr, $param);

				$contract_arr = array(
					'sup_id'                  => $sup_id,
					'sup_contracttype'        => $this->input->post('contract_type'),
					'sup_contract_number'     => $this->input->post('contract_number'),
					'sup_contract_signdate'   => $this->input->post('sign_date'),
					'sup_contract_enddate'    => $this->input->post('end_date'),
					'sup_contract_percentage' => $this->input->post('percentage'),
					'sup_contract_staticfee'  => $this->input->post('static'),
				);

				$check_contract = $this->model_supplier->check_contract($sup_id);

				if ($check_contract == 0) {
					$this->model_supplier->insert_contract($contract_arr);
				} else {
					$this->model_supplier->update_contract($contract_arr, $param);
				}
			}

			$warehouses = $this->input->post('warehouse');
			$default    = $this->input->post("warehouse_default");

			if (!empty($warehouses)) {
				foreach ($warehouses as $key => $val) {
					if (is_array($val)) {
						$warehouse_arr = array(
							'sup_id'                      => $sup_id,
							'sup_warehouse_name'          => $val['name'],
							'sup_warehouse_default'       => 0,
							'sup_warehouse_street'        => $val['street'],
							'sup_warehouse_country'       => $val['country'],
							'sup_warehouse_city'          => $val['city'],
							'sup_warehouse_district'      => $val['district'],
							'sup_warehouse_contactperson' => $val['contact_person'],
							'sup_warehouse_contactphone'  => $val['contact_phone'],
							'sup_warehouse_contactmail'   => $val['contact_email'],
							'sup_warehouse_workinghour'   => $val['working_hour'],
							'status'                      => 1,
						);
						if ($key == $default) {
							$warehouse_arr['sup_warehouse_default'] = 1;
						} else {
							$warehouse_arr['sup_warehouse_default'] = 0;
						}

						$this->model_supplier->insert_warehouse($warehouse_arr);
					}

				}
			}
			redirect(base_url().'active-supplier');
		}

		$this->data['sup_id']    = $param;
		$this->data['contracts'] = $this->model_supplier->get_contract_type();
		$this->data['detail']    = $this->model_supplier->get_supplier_by_id($param);
		$this->data['msg']       = $msg;
		$this->load->view('pages/templates', $this->data);
	}

	public function logout() {
		$this->my_auth->sess_destroy();

		redirect(base_url()."login");
	}

	public function information() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/information';

		$change_pass = $this->input->post('change');
		$old_pass    = $this->input->post('old_password');
		$pass        = $this->input->post('new_password');
		$pass2       = $this->input->post('renew_password');

		if (!empty($change_pass)) {
			$this->form_validation->set_rules('old_password', 'Old password', 'required');
			$this->form_validation->set_rules('new_password', 'New password', 'required');
			$this->form_validation->set_rules('renew_password', 'New password confirm', 'required');

			if (!empty($pass) && !empty($pass2)) {
				$this->form_validation->set_rules("new_password", "Password", "matches[renew_password]");
			}

			if ($this->form_validation->run() == false) {

				$this->data['error'] = '';
			} else {
				$check_pass = $this->model_supplier->check_pass($sup_id, $old_pass);

				if ($check_pass == 1) {
					$this->model_supplier->update_supplier(array('sup_password' => md5($pass)), $sup_id);
					$this->data['msg'] = 'Password has been changed';
				} else {
					$this->data['msg'] = 'Current password is wrong';
				}
			}
		}

		$this->data['info'] = $this->model_supplier->get_info($sup_id);

		$this->load->view('pages/templates', $this->data);
	}

	public function delete_warehouse() {
		$warehouse = $this->input->post('warehouse');
		$this->model_supplier->delete_warehouse($warehouse);
	}

	public function update_warehouse() {
		$warehouse = $this->input->post('warehouse');
		$sup_id    = $this->input->post('sup_id');
		$this->model_supplier->update_warehouse(array('sup_warehouse_default' => 0), $sup_id);
		$this->model_supplier->update_warehouse(array('sup_warehouse_default' => 1), $sup_id, $warehouse);
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}
}
?>
