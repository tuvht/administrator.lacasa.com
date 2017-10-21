<?php
class Model_supplier extends CI_Model {
	private $_table                    = "supplier";
	private $_product                  = "product";
	private $_product_warehouse_stock  = 'product_warehouse_stock';
	private $_order                    = "supplier_order";
	private $_supplier_login           = "supplier_login";
	private $_country                  = "country";
	private $_city                     = "city";
	private $_district                 = "district";
	private $_supplier_warehouse       = "supplier_warehouse";
	private $_supplier_contracttype    = "supplier_contracttype";
	private $_supplier_contract_detail = "supplier_contract_detail";
	private $_supplier_order           = 'supplier_order';
	private $_supplier_order_item      = 'supplier_order_item';

	public function check_supplier($id) {

		$this->db->where("$this->_table.sup_id", $id);
		$result = $this->db->get($this->_table);
		if (!$result) {
			return false;
		}
		if ($result->num_rows() != 1) {
			return false;
		}
		return true;
	}

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function list_all($status, $limit = NULL, $off = NULL, $order = NULL, $keyword = NULL) {

		// echo $status.'<br>'.$limit.'<br>'.$off.'<br>'.$order.'<br>'.$keyword;
		$this->db->where('sup_status', $status);
		$this->db->limit($limit, $off);

		if (!empty($order)) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by('sup_joindate DESC');
		}
		if ($keyword) {
			$this->db->like('sup_name', $keyword);
		}
		$query = $this->db->get($this->_table);

		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['active_product']     = $this->get_product($value['sup_id'], 1);
			$data[$key]['inactive_product']   = $this->get_product($value['sup_id'], 0);
			$data[$key]['outofstock_product'] = $this->get_products_out_stock($value['sup_id']);
			$data[$key]['complete_order']     = $this->get_order($value['sup_id'], 5);
			$data[$key]['cancelled_order']    = $this->get_order($value['sup_id'], 6);
			$data[$key]['last_sold']          = $this->get_supplier_last_sold($value['sup_id']);
		}

		return $data;
	}

	public function get_supplier_last_sold($sup_id) {
		$this->db->select('o.sup_shipping_deliverdate');
		$this->db->from($this->_supplier_order.' AS o');
		$this->db->where('o.sup_id', (int) $sup_id);
		$this->db->where('o.sup_order_status', 5);
		$this->db->order_by('o.sup_order_date DESC');
		$query = $this->db->get();
		$data  = $query->result_array();

		if (!empty($data)) {
			$result = $data[0];
		} else {
			$result = "";
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	function count_rows($status) {
		$this->db->where('sup_status', $status);
		return $this->db->count_all($this->_table);
	}

	function check_contract($sup_id) {
		$this->db->where('sup_id', (int) $sup_id);
		$query = $this->db->get($this->_supplier_contract_detail);

		return $query->num_rows();
	}

	public function get_info($id) {
		$this->db->from($this->_table.' AS s');
		$this->db->join($this->_supplier_contract_detail.' AS cd', 'cd.sup_id = s.sup_id', 'left');
		$this->db->join($this->_supplier_contracttype.' AS ct', 'ct.sup_contracttype_id = cd.sup_contracttype', 'left');
		$this->db->where('s.sup_id', $id);
		$query = $this->db->get();
		$data  = $query->row_array();

		$warehouses         = $this->get_supplier_warehouse($id);
		$data['warehouses'] = $warehouses;

		foreach ($warehouses as $key => $warehouse) {
			if (!empty($warehouse['sup_warehouse_country'])) {
				$country                                           = $this->get_country_id($warehouse['sup_warehouse_country']);
				$data['warehouses'][$key]['sup_warehouse_country'] = $country['country_name'];
			}

			if (!empty($warehouse['sup_warehouse_city'])) {
				$city                                           = $this->get_city_id($warehouse['sup_warehouse_city']);
				$data['warehouses'][$key]['sup_warehouse_city'] = $city['city_name'];
			}

			if (!empty($warehouse['sup_warehouse_district'])) {
				$district                                           = $this->get_district_id($warehouse['sup_warehouse_district']);
				$data['warehouses'][$key]['sup_warehouse_district'] = $district['district_name'];
			}
		}

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	public function get_supplier_warehouse($id) {
		$this->db->where('sup_id', $id);
		$query = $this->db->get($this->_supplier_warehouse);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_info_by_email($email) {
		$this->db->where("sup_email", $email);
		$query = $this->db->get($this->_table);
		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_country_id($id) {
		$this->db->where("country_id", (int) $id);
		$query = $this->db->get($this->_country);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_city_id($id) {
		$this->db->where("city_id", (int) $id);
		$query = $this->db->get($this->_city);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_district_id($id) {
		$this->db->where("district_id", (int) $id);
		$query = $this->db->get($this->_district);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_supplier_by_id($id) {
		$this->db->where("sup_id", (int) $id);
		$query = $this->db->get($this->_table);
		$data  = $query->row_array();

		if (!empty($data)) {
			$data['contract']  = $this->get_contract_supplier($data['sup_id']);
			$data['warehouse'] = $this->get_warehouse_supplier($data['sup_id']);
		}

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_contract_supplier($id) {
		$this->db->where("sup_id", (int) $id);
		$query = $this->db->get($this->_supplier_contract_detail);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_warehouse_supplier($id) {
		$this->db->where("sup_id", (int) $id);
		$query = $this->db->get($this->_supplier_warehouse);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_id_by_token($token) {
		$this->db->where("sup_token", $token);
		$query = $this->db->get($this->_table);

		if ($query) {
			$data = $query->row_array();
			return $data['sup_id'];
		} else {

			return false;
		}
	}

	public function get_pass($id) {
		$this->db->select('sup_password');
		$this->db->where('sup_id', $id);
		$query = $this->db->get($this->_table);

		if ($query) {
			$array = $query->row_array();
			return $array['sup_password'];
		} else {

			return false;
		}
	}

	public function check_pass($sup_id, $pass) {
		$this->db->where('sup_id', (int) $sup_id);
		$this->db->where('sup_password', md5($pass));
		$query = $this->db->get($this->_table);

		if ($query) {
			return $query->num_rows();
		} else {

			return false;
		}
	}

	public function check_login($email, $pass) {
		$flag = 0;
		$this->db->where('sup_username', $email);
		$query = $this->db->get($this->_table);
		$data  = $query->result_array();

		if ($email != "" || $pass != "") {
			foreach ($data as $key => $value) {
				if ($email == $data[$key]['sup_username']) {
					if (md5($pass) == $data[$key]['sup_password']) {
						$sess = array('sup_email' => $data[$key]['sup_username'],
							'sup_id'                 => $data[$key]['sup_id']);

						$this->session->set_userdata($sess);
						$flag = 3;
					} else {
						$flag = 2;
					}
				} else {
					$flag = 1;
				}
			}
		}
		return $flag;
	}

	function get_user($email, $id = "") {
		if (isset($id) && !empty($id)) {
			$this->db->where('sup_username', $email);
			$this->db->where('sup_id', $id);
			$query = $this->db->get($this->_table);
		} else {
			$this->db->where('sup_username', $email);
			$query = $this->db->get($this->_table);
		}

		$row = $query->num_rows();

		if ($row > 0) {
			return false;
		} else {

			return true;
		}
	}

	function get_product($sup_id, $status) {
		$this->db->where('prod_supplier_id', (int) $sup_id);
		$this->db->where('prod_status', (int) $status);
		$query = $this->db->get($this->_product);
		$row   = $query->num_rows();

		if ($query) {
			return $row;
		} else {

			return false;
		}
	}

	function get_order($sup_id, $status) {
		$this->db->where('sup_id', (int) $sup_id);
		$this->db->where('sup_order_status', (int) $status);
		$query = $this->db->get($this->_order);
		$row   = $query->num_rows();

		if ($query) {
			return $row;
		} else {

			return false;
		}
	}

	public function get_products_out_stock($sup_id) {
		$this->db->select('p.*');
		$this->db->from($this->_product.' AS p');
		$this->db->where('prod_supplier_id', (int) $sup_id);
		$query = $this->db->get();
		$data  = $query->result_array();
		$ids   = array();

		foreach ($data as $key => $value) {
			$stock_total = $this->get_product_stock($value['prod_id']);

			if (empty($stock_total['stock_total'])) {

				$ids[] = $value['prod_id'];
			}
		}

		if ($query) {
			return count($ids);
		} else {

			return false;
		}
	}

	public function get_product_stock($id) {
		$this->db->select('SUM(product_warehouse_quantity) as stock_total');
		$this->db->from($this->_product_warehouse_stock);
		$this->db->where('product_id', (int) $id);
		$this->db->group_by('product_id');
		$query = $this->db->get();

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	public function get_contract_type() {
		$query = $this->db->get($this->_supplier_contracttype);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	public function insert_supplier($data) {
		if ($this->db->insert($this->_table, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function insert_contract($data) {
		if ($this->db->insert($this->_supplier_contract_detail, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_contract($data, $id) {
		$this->db->where("sup_id", (int) $id);

		if ($this->db->update($this->_supplier_contract_detail, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_warehouse($data) {
		if ($this->db->insert($this->_supplier_warehouse, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_warehouse($data, $sup_id, $id = NULL) {
		if (!empty($id)) {
			$this->db->where("sup_warehouse_id", (int) $id);
			$this->db->where("sup_id", (int) $sup_id);
		}

		if ($this->db->update($this->_supplier_warehouse, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function delete_warehouse($id) {
		$this->db->where("sup_warehouse_id", $id);

		if ($this->db->delete($this->_supplier_warehouse)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_supplier($data, $id) {
		$this->db->where("sup_id", (int) $id);

		if ($this->db->update($this->_table, $data)) {
			return true;
		} else {

			return false;
		}
	}
}
