<?php

class Config extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_config', 'model_order', 'model_product'));
		$this->load->helper(array("url", "form", "my_data"));
		$this->load->library(array("form_validation", "session", "my_auth"));

		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			redirect(base_url().'login');
		}

	}
	public function new_order_admin() {

	}
	public function new_order_customer() {

	}
	public function create_new_customer() {

	}
	public function forgot_password_customer() {

	}
	public function forgot_password_admin() {

	}
	public function test_mail_template() {
		$this->data['subcontent'] = 'pages/testmail';
		$this->load->view('pages/templates', $this->data);
	}
	public function index() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		} else {
			//redirect(base_url() . 'login');
		}

		$save = $this->input->post('save');

		if (!empty($save)) {
			$content = $this->input->post('content');

			if (!empty($content)) {
				foreach ($content as $k => $value) {
					$content_arr = array(
						'config_value' => $value,
					);
					$this->model_config->update_config($content_arr, $k);
				}
			}

			$this->load->library('upload');
			$config = $this->input->post('config');
			$banner = $this->input->post('banner');
			ksort($banner);
			$i = 0;

			$logo = $_FILES['config_logo'];

			if (!empty($logo)) {
				$config_logo['upload_path']   = './images/banners';
				$config_logo['allowed_types'] = 'gif|jpg|png';

				if (!empty($logo['name'])) {
					$_FILES['config_logo']['name']     = $logo['name'];
					$_FILES['config_logo']['type']     = $logo['type'];
					$_FILES['config_logo']['tmp_name'] = $logo['tmp_name'];
					$_FILES['config_logo']['error']    = $logo['error'];
					$_FILES['config_logo']['size']     = $logo['size'];
					$config_logo['file_name']          = 'logo';
					$this->upload->initialize($config_logo);

					if ($this->upload->do_upload('config_logo')) {
						$data_logo['uploads'] = $this->upload->data();
						$config['logo']       = $data_logo['uploads']['file_name'];
					}
				}
			}

			$favicon = $_FILES['config_favicon'];

			if (!empty($favicon)) {
				$config_favicon['upload_path']   = './images/banners';
				$config_favicon['allowed_types'] = 'gif|jpg|png';

				if (!empty($favicon['name'])) {
					$_FILES['config_favicon']['name']     = $favicon['name'];
					$_FILES['config_favicon']['type']     = $favicon['type'];
					$_FILES['config_favicon']['tmp_name'] = $favicon['tmp_name'];
					$_FILES['config_favicon']['error']    = $favicon['error'];
					$_FILES['config_favicon']['size']     = $favicon['size'];
					$config_favicon['file_name']          = 'favicon';
					$this->upload->initialize($config_favicon);

					if ($this->upload->do_upload('config_favicon')) {
						$data_favicon['uploads'] = $this->upload->data();
						$config['favicon']       = $data_favicon['uploads']['file_name'];
					}
				}
			}

			foreach ($banner as $key => $value) {
				$image                          = $_FILES['banner_'.$i.'_image'];
				$config_banner['upload_path']   = './images/banners';
				$config_banner['allowed_types'] = 'gif|jpg|png';

				if (!empty($image['name'])) {
					$_FILES['banner_'.$i.'_image']['name']     = $image['name'];
					$_FILES['banner_'.$i.'_image']['type']     = $image['type'];
					$_FILES['banner_'.$i.'_image']['tmp_name'] = $image['tmp_name'];
					$_FILES['banner_'.$i.'_image']['error']    = $image['error'];
					$_FILES['banner_'.$i.'_image']['size']     = $image['size'];
					$config_banner['file_name']                = 'banner_'.$i.'_'.time();
					$this->upload->initialize($config_banner);

					if ($this->upload->do_upload('banner_'.$i.'_image')) {
						$data_img['uploads'] = $this->upload->data();
						$arr                 = array(
							'banner_position'      => $i,
							'banner_order'         => $i,
							'banner_image_source'  => $data_img['uploads']['file_name'],
							'banner_image_alttext' => $value['tooltip'],
							'banner_image_link'    => $value['url'],
							'banner_image_status'  => 1,
						);
						$check = $this->model_config->get_banner_by_pos($i);

						if (!empty($check)) {
							$this->model_config->update_banner($arr, $i);
						} else {
							$this->model_config->insert_banner($arr);
						}
					}
				} else {
					$arr = array(
						'banner_position'      => $i,
						'banner_order'         => $i,
						'banner_image_alttext' => $value['tooltip'],
						'banner_image_link'    => $value['url'],
						'banner_image_status'  => 1,
					);

					$check = $this->model_config->get_banner_by_pos($i);

					if (!empty($check)) {
						$this->model_config->update_banner($arr, $i);
					} else {
						$this->model_config->insert_banner($arr);
					}
				}

				$i++;
			}

			$json_config = json_encode($config);
			$this->model_config->update_config(array('config_value' => $json_config), 'main_config');

			$config_json   = (array) json_decode($this->model_config->get_config_by_name('main_config'));
			$gift_wrap     = $config_json['gift_wrap'];
			$fast_delivery = $config_json['fast_delivery'];
			$tax_detail    = $config_json['order_tax'];
			$arr_gift_wrap = array(
				'order_extra_fee_static'     => $gift_wrap,
				'order_extra_fee_percentage' => 0,
			);
			$this->model_config->update_tax_value($arr_gift_wrap, 1);
			$arr_fast_delivery = array(
				'order_extra_fee_static'     => $fast_delivery,
				'order_extra_fee_percentage' => 0,
			);
			$this->model_config->update_tax_value($arr_fast_delivery, 2);
			$arr_tax_detail = array(
				'order_extra_fee_percentage' => $tax_detail,
				'order_extra_fee_static'     => 0,
			);
			$this->model_config->update_tax_value($arr_tax_detail, 3);
		}

		$this->data['title']        = "Configuration";
		$this->data['subcontent']   = 'pages/configuration';
		$this->data['shipping']     = $this->model_config->get_shipping();
		$config_detail              = $this->model_config->get_config_by_name('main_config');
		$this->data['detail']       = (array) json_decode($config_detail);
		$this->data['banner']       = $this->model_config->get_banner();
		$content                    = array();
		$content['about_us']        = $this->model_config->get_config_by_name('about_us');
		$content['contact_us']      = $this->model_config->get_config_by_name('contact_us');
		$content['faq']             = $this->model_config->get_config_by_name('faq');
		$content['shipping_policy'] = $this->model_config->get_config_by_name('shipping_policy');
		$content['return_policy']   = $this->model_config->get_config_by_name('return_policy');
		$this->data['content']      = $content;
		$this->load->view('pages/templates', $this->data);
	}

	public function add_shipping() {
		$name          = $this->input->post('name');
		$web           = $this->input->post('web');
		$contact_name  = $this->input->post('contact_name');
		$contact_email = $this->input->post('contact_email');
		$operation     = $this->input->post('operation');

		$arr = array(
			'com_shipper_name'          => $name,
			'com_shipper_address'       => $operation,
			'com_shipper_website'       => $web,
			'com_shipper_contact_name'  => $contact_name,
			'com_shipper_contact_email' => $contact_email,
			'com_shipper_status'        => 1,
		);

		$this->model_config->insert_shipping($arr);
	}

	public function update_shipping() {
		$shipper_id = $this->input->post('shipper_id');
		$status     = $this->input->post('status');
		$this->model_config->update_shipping(array('com_shipper_status' => $status), $shipper_id);
	}
}
?>
