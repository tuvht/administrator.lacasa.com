<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_category', 'model_product', 'model_config', 'model_order'));
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
		if (!empty($this->session->userdata['category.keyword'])) {
			$keyword = $this->session->userdata['category.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('category.keyword', $keyword);
			$keyword = $this->session->userdata['category.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'category.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}
		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_category(array('par_cat_status' => 0), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Inactive promotion successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_category(array('par_cat_status' => 1), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Active promotion successful', 'success');
		}

		$this->data['subcontent'] = 'pages/category';
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
		$config['base_url']   = base_url().'category';
		$config['total_rows'] = $this->model_category->count_parent('', $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['categories'] = $this->model_category->get_parent_category($config['per_page'], $param, '', $sort, $keyword);

		$this->load->view('pages/templates', $this->data);
	}

	public function category_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/category_detail';
		$param                    = $this->uri->segment(2);

		$save = $this->input->post('save');

		if (!empty($save)) {
			$this->form_validation->set_rules("master", "Master", "required");
			$this->form_validation->set_rules("name", "Name", "required");

			if ($this->form_validation->run() == false) {
				$this->data['error'] = '';
			} else {
				$arr = array(
					'master_cate_id'      => $this->input->post('master'),
					'par_cat_name'        => $this->input->post('name'),
					'par_cat_description' => $this->input->post('description'),
					'par_cat_status'      => 1,
				);

				if (!empty($param)) {
					$this->model_category->update_category($arr, $param);
				} else {
					$this->model_category->insert_category($arr);
				}
			}
		}

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['detail'] = $this->model_category->get_category_by_id($param);
		$this->data['master'] = $this->model_category->get_master_category();
		$this->data['id']     = $param;

		$this->load->view('pages/templates', $this->data);
	}

	public function sub_category() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];

		if (!empty($this->session->userdata['subcategory.keyword'])) {
			$keyword = $this->session->userdata['subcategory.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('subcategory.keyword', $keyword);
			$keyword = $this->session->userdata['subcategory.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'subcategory.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
			$keyword               = NULL;
		}

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_subcategory(array('cat_status' => 0), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Inactive promotion successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_subcategory(array('cat_status' => 1), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Active promotion successful', 'success');
		}

		$this->data['subcontent'] = 'pages/subcategory';
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
		$config['base_url']   = base_url().'sub-category';
		$config['total_rows'] = $this->model_category->count_category('', $keyword);
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['categories'] = $this->model_category->get_category($config['per_page'], $param, '', $sort, $keyword);

		$this->load->view('pages/templates', $this->data);
	}

	public function sub_category_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/subcategory_detail';
		$param                    = $this->uri->segment(2);

		$save = $this->input->post('save');

		if (!empty($save)) {
			$this->load->library('upload');
			$this->form_validation->set_rules("name", "Name", "required");
			$this->form_validation->set_rules("master", "Master", "required");
			$this->form_validation->set_rules("category", "Category", "required");

			if ($this->form_validation->run() == false) {
				$this->data['error'] = '';
			} else {
				$cat_arr = array(
					'par_cat_id'      => $this->input->post('category'),
					'cat_name'        => $this->input->post('name'),
					'cat_description' => $this->input->post('description'),
				);

				$attributes = $this->input->post('attribute');
				$criterias  = $this->input->post('criteria');

				if (!empty($param)) {
					$this->model_category->update_subcategory($cat_arr, $param);
					$cat_id = $param;
					$this->model_category->delete_attribute_mapping($cat_id);
					$this->model_category->delete_criteria_mapping($cat_id);
				} else {
					$cat_id = $this->model_category->insert_subcategory($cat_arr);
				}

				if ($attributes != NULL) {
					foreach ($attributes as $key => $attribute) {
						$attr_arr = array(
							'cat_field_id'              => $attribute,
							'cat_id'                    => $cat_id,
							'cat_field_mapping_require' => 1,
							'cat_field_mapping_status'  => 1,
						);
						$this->model_category->insert_attribute_mapping($attr_arr);
					}
				}

				if ($criterias != NULL) {
					foreach ($criterias as $key => $criteria) {
						$crit_arr = array(
							'criteria_id'                      => $criteria,
							'category_id'                      => $cat_id,
							'category_criteria_mapping_status' => 1,
						);
						$this->model_category->insert_criteria_mapping($crit_arr);
					}
				}

				if (!empty($_FILES['image'])) {
					$files = $_FILES['image'];

					$config['upload_path']   = './images/category';
					$config['allowed_types'] = 'gif|jpg|png';

					if (!empty($files['name'])) {
						$_FILES['image']['name']     = $files['name'];
						$_FILES['image']['type']     = $files['type'];
						$_FILES['image']['tmp_name'] = $files['tmp_name'];
						$_FILES['image']['error']    = $files['error'];
						$_FILES['image']['size']     = $files['size'];
						$config['file_name']         = 'category_'.$cat_id;
						$this->upload->initialize($config);

						if ($this->upload->do_upload('image')) {
							$data['uploads'] = $this->upload->data();
							$cat_update_arr  = array(
								'cat_imageurl' => 'images/category/'.$data['uploads']['file_name'],
							);

							$this->model_category->update_subcategory($cat_update_arr, $cat_id);
						} else {
							$data['upload_errors'][$i] = $this->upload->display_errors();
						}
					}
				}
			}
		}

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$detail               = $this->model_category->get_subcat_by_id($param);
		$this->data['detail'] = $detail;

		if (!empty($param)) {
			$mas_cat_id = $detail['mas_cat_id'];
		} else {
			$mas_cat_id = '';
		}

		$this->data['master']     = $this->model_category->get_master_category();
		$this->data['categories'] = $this->model_category->get_category_by_master($mas_cat_id);
		$this->data['attributes'] = $this->model_category->get_category_field();
		$this->data['criterias']  = $this->model_category->get_criteria();
		$this->data['id']         = $param;

		$this->load->view('pages/templates', $this->data);
	}

	public function attribute() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];

		if (!empty($this->session->userdata['attribute.keyword'])) {
			$keyword = $this->session->userdata['attribute.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('attribute.keyword', $keyword);
			$keyword = $this->session->userdata['attribute.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'attribute.keyword' => '',
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

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_attribute(array('cat_field_status' => 0), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Inactive attribute successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_attribute(array('cat_field_status' => 1), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Active promotion successful', 'success');
		}

		$this->data['subcontent'] = 'pages/attribute';
		$param                    = $this->uri->segment(2);

		//pagination
		$config['base_url']   = base_url().'attribute';
		$config['total_rows'] = $this->model_category->count_category_field();
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['attributes'] = $this->model_category->get_category_field($config['per_page'], $param, '', $keyword, $sort);

		$this->load->view('pages/templates', $this->data);
	}

	public function attribute_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/attribute_detail';
		$param                    = $this->uri->segment(2);
		if (!empty($this->session->userdata['criteria.keyword'])) {
			$keyword = $this->session->userdata['criteria.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('criteria.keyword', $keyword);
			$keyword = $this->session->userdata['criteria.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'criteria.keyword' => '',
			);
			$this->session->unset_userdata($arr);
			$this->data['keyword'] = '';
		}

		$save = $this->input->post('save');

		if (!empty($save)) {
			$this->form_validation->set_rules("name", "Name", "required");

			if ($this->form_validation->run() == false) {
				$this->data['error'] = '';
			} else {
				$arr = array(
					'cat_field_name'        => $this->input->post('name'),
					'cat_field_description' => $this->input->post('description'),
					'cat_field_valuetype'   => 'shortchar',
				);

				if (!empty($param)) {
					$this->model_category->update_attribute($arr, $param);
				} else {
					$this->model_category->insert_attribute($arr);
				}
			}
		}

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['detail'] = $this->model_category->get_attribute_by_id($param);
		$this->data['id']     = $param;

		$this->load->view('pages/templates', $this->data);
	}

	public function criteria() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$selected = $this->input->post('selected');
		$count    = count($selected);
		$active   = 'active-'.$selected[0];
		$inactive = 'inactive-'.$selected[0];
		if (!empty($this->session->userdata['criteria.keyword'])) {
			$keyword = $this->session->userdata['criteria.keyword'];
		} else {
			$keyword = '';
		}

		if (!empty($this->input->post('keyword'))) {
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('criteria.keyword', $keyword);
			$keyword = $this->session->userdata['criteria.keyword'];
		}

		$this->data['keyword'] = $keyword;

		if (!empty($this->input->post('clear-button'))) {
			$arr = array(
				'criteria.keyword' => '',
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

		if ($this->input->post($active)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_criteria(array('criteria_status' => 0), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Inactive criteria successful', 'success');
		}

		if ($this->input->post($inactive)) {
			for ($j = 0; $j < $count; $j++) {
				$this->model_category->update_criteria(array('criteria_status' => 1), $selected[$j], $sup_id);
			}

			$msg = $this->setMessage('Active criteria successful', 'success');
		}

		$this->data['subcontent'] = 'pages/criteria';
		$param                    = $this->uri->segment(2);

		//pagination
		$config['base_url']   = base_url().'criteria';
		$config['total_rows'] = $this->model_category->count_criteria();
		// $config['use_page_numbers'] = TRUE;
		$config['per_page']    = 10;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['criteria'] = $this->model_category->get_criteria($config['per_page'], $param, '', $keyword, $sort);

		$this->load->view('pages/templates', $this->data);
	}

	public function criteria_detail() {
		if ($this->my_auth->is_Login()) {
			$this->data['email'] = $this->session->userdata['sup_email'];
			$sup_id              = $this->session->userdata['sup_id'];
		}

		$this->data['subcontent'] = 'pages/criteria_detail';
		$param                    = $this->uri->segment(2);

		$save = $this->input->post('save');

		if (!empty($save)) {
			$this->form_validation->set_rules("name", "Name", "required");

			if ($this->form_validation->run() == false) {
				$this->data['error'] = '';
			} else {
				$arr = array(
					'criteria_name'        => $this->input->post('name'),
					'criteria_description' => $this->input->post('description'),
				);

				if (!empty($param)) {
					$this->model_category->update_criteria($arr, $param);
				} else {
					$this->model_category->insert_criteria($arr);
				}
			}
		}

		if (!empty($msg)) {
			$this->data['msg'] = $msg;
		} else {
			$this->data['msg'] = "";
		}

		$this->data['detail'] = $this->model_category->get_criteria_by_id($param);
		$this->data['id']     = $param;

		$this->load->view('pages/templates', $this->data);
	}

	function get_category() {
		$mas_cat_id = $this->input->post('mas_cat_id');
		$categories = $this->model_category->get_category_by_master($mas_cat_id);
		$option     = '';
		$option .= '<option value="">-- Select category --</option>';

		foreach ($categories as $key => $category) {
			$option .= '<option value="'.$category['par_cat_id'].'">';
			$option .= $category['par_cat_name'];
			$option .= '</option>';
		}

		echo $option;
	}

	public function setMessage($text, $type) {
		return array('text' => $text, 'type' => $type);
	}
}
?>
