<?php
class Model_category extends CI_Model {
	private $_master_category            = "master_category";
	private $_parent_category            = "parent_category";
	private $_cateogory                  = "category";
	private $_cateogory_field            = "category_field";
	private $_cateogory_field_mapping    = "category_field_mapping";
	private $_cateogory_criteria_mapping = "category_criteria_mapping";
	private $_brand                      = "brand";
	private $_country                    = "country";
	private $_product                    = "product";
	private $_criteria                   = "criteria";

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function count_parent($status = NULL, $key = NULL) {
		$this->db->from($this->_parent_category.' AS p');

		if ($key) {
			$this->db->where('p.par_cat_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('par_cat_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_category($status = NULL, $key = NULL) {
		$this->db->from($this->_cateogory.' AS p');

		if ($key) {
			$this->db->where('p.cat_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('p.cat_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_category_field($status = NULL, $key = NULL) {
		$this->db->from($this->_cateogory_field.' AS p');

		if ($key) {
			$this->db->where('p.cat_field_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('p.cat_field_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_criteria($status = NULL, $key = NULL) {
		$this->db->from($this->_criteria.' AS c');

		if ($key) {
			$this->db->where('c.criteria_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('c.criteria_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_master_category() {
		$query = $this->db->get($this->_master_category);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_parent_category($limit = NULL, $off = NULL, $status = NULL, $order = NULL, $keyword = NULL) {
		$this->db->select('p.*, m.mas_cat_id, m.mas_cat_name, COUNT(cat_id) AS subcat');
		$this->db->from($this->_parent_category.' AS p');
		$this->db->join($this->_master_category.' AS m', 'p.master_cate_id = m.mas_cat_id', 'left');
		$this->db->join($this->_cateogory.' AS c', 'p.par_cat_id = c.par_cat_id', 'left');
		$this->db->group_by('p.par_cat_id');

		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("p.par_cat_id", "desc");
		}

		$this->db->limit($limit, $off);
		if ($keyword) {
			$this->db->like('p.par_cat_name', $keyword);
		}
		$query = $this->db->get();
		$data  = $query->result_array();

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_category($limit = NULL, $off = NULL, $status = NULL, $order = NULL, $keyword = NULL) {
		$this->db->select('c.*, m.mas_cat_id, m.mas_cat_name, p.par_cat_id, p.par_cat_name, COUNT(pd.prod_id) AS products');
		$this->db->from($this->_cateogory.' AS c');
		$this->db->join($this->_parent_category.' AS p', 'c.par_cat_id = p.par_cat_id', 'left');
		$this->db->join($this->_master_category.' AS m', 'p.master_cate_id = m.mas_cat_id', 'left');
		$this->db->join($this->_product.' AS pd', 'c.cat_id = pd.prod_cat_id', 'left');
		$this->db->group_by('c.cat_id');
		$this->db->limit($limit, $off);

		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("c.cat_id", "desc");
		}
		if ($keyword) {
			$this->db->like('c.cat_name', $keyword);
		}
		$query = $this->db->get();
		$data  = $query->result_array();

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_mas_category_by_id($mas_cat_id) {
		$this->db->where("mas_cat_id", (int) $mas_cat_id);
		$query = $this->db->get($this->_master_category);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_category_by_catid($cat_id) {
		$this->db->where("cat_id", (int) $cat_id);
		$query = $this->db->get($this->_cateogory);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_category_by_id($id) {
		$this->db->where('par_cat_id', (int) $id);
		$query = $this->db->get($this->_parent_category);
		$data  = $query->row_array();

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_category_by_master($id = NULL) {
		if (!empty($id)) {
			$this->db->where('master_cate_id', (int) $id);
		}

		$query = $this->db->get($this->_parent_category);
		$data  = $query->result_array();

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_subcat_by_id($id) {
		$this->db->where('cat_id', (int) $id);
		$query              = $this->db->get($this->_cateogory);
		$data               = $query->row_array();
		$data['attributes'] = $this->get_attribute_mapping($id);
		$data['criterias']  = $this->get_criteria_mapping($id);

		if (!empty($id)) {
			$parent             = $this->get_category_by_id($data['par_cat_id']);
			$data['mas_cat_id'] = $parent['master_cate_id'];
		}

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	function get_brand() {
		$this->db->where('brand_status', '1');
		$query = $this->db->get($this->_brand);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_category_field($limit = NULL, $off = NULL, $status = NULL, $key = NULL, $order = NULL) {
		if (!empty($off)) {
			$this->db->limit($limit, $off);
		}
		if ($key) {
			$this->db->like('cat_field_name', $key);
		}
		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("cat_field_id", "desc");
		}
		$query = $this->db->get($this->_cateogory_field);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_criteria($limit = NULL, $off = NULL, $status = NULL, $key = NULL, $order = NULL) {
		if (!empty($off)) {
			$this->db->limit($limit, $off);
		}
		if ($key) {
			$this->db->like('criteria_name', $key);
		}
		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("criteria_id", "desc");
		}
		$query = $this->db->get($this->_criteria);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function get_category_variant_field($cat_id) {
		$this->db->select('cf.cat_field_id, cf.cat_field_name');
		$this->db->from($this->_cateogory_field.' AS cf');
		$this->db->where('cf.cat_field_id', (int) $cat_id);

		$query = $this->db->get();

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_category_field_by_name($field) {
		$this->db->where('cat_field_status', '1');
		$this->db->where('cat_field_name', $field);
		$query = $this->db->get($this->_cateogory_field);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_country() {
		$this->db->where('country_status', '1');
		$query = $this->db->get($this->_country);

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	function count_products($cat_id) {
		$this->db->where('prod_cat_id', (int) $cat_id);
		$query = $this->db->get($this->_product);

		if ($query) {
			return $query->num_rows();
		} else {

			return false;
		}
	}

	function count_subcategory($par_cat_id) {
		$this->db->where('par_cat_id', (int) $par_cat_id);
		$query = $this->db->get($this->_cateogory);

		if ($query) {
			return $query->num_rows();
		} else {

			return false;
		}
	}

	function get_attribute_by_id($id) {
		$this->db->where('cat_field_id', (int) $id);
		$query = $this->db->get($this->_cateogory_field);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_criteria_by_id($id) {
		$this->db->where('criteria_id', (int) $id);
		$query = $this->db->get($this->_criteria);

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	function get_attribute_mapping($id) {
		$this->db->where('cat_id', (int) $id);
		$query  = $this->db->get($this->_cateogory_field_mapping);
		$data   = $query->result_array();
		$result = array();

		foreach ($data as $key => $value) {
			$result[] = $value['cat_field_id'];
		}

		if ($query) {
			return $result;
		} else {

			return false;
		}
	}

	function get_criteria_mapping($id) {
		$this->db->where('category_id', (int) $id);
		$query  = $this->db->get($this->_cateogory_criteria_mapping);
		$data   = $query->result_array();
		$result = array();

		foreach ($data as $key => $value) {
			$result[] = $value['criteria_id'];
		}

		if ($query) {
			return $result;
		} else {

			return false;
		}
	}

	public function insert_category($data) {
		if ($this->db->insert($this->_parent_category, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_category($data, $id) {
		$this->db->where("par_cat_id", (int) $id);

		if ($this->db->update($this->_parent_category, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_subcategory($data) {
		if ($this->db->insert($this->_cateogory, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function update_subcategory($data, $id) {
		$this->db->where("cat_id", (int) $id);

		if ($this->db->update($this->_cateogory, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_attribute($data) {
		if ($this->db->insert($this->_cateogory_field, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_attribute($data, $id) {
		$this->db->where("cat_field_id", (int) $id);

		if ($this->db->update($this->_cateogory_field, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_criteria($data) {
		if ($this->db->insert($this->_criteria, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_criteria($data, $id) {
		$this->db->where("criteria_id", (int) $id);

		if ($this->db->update($this->_criteria, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_attribute_mapping($data) {
		if ($this->db->insert($this->_cateogory_field_mapping, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function delete_attribute_mapping($id) {
		$this->db->where("cat_id", $id);

		if ($this->db->delete($this->_cateogory_field_mapping)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_criteria_mapping($data) {
		if ($this->db->insert($this->_cateogory_criteria_mapping, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function delete_criteria_mapping($id) {
		$this->db->where("category_id", $id);

		if ($this->db->delete($this->_cateogory_criteria_mapping)) {
			return true;
		} else {

			return false;
		}
	}
}
