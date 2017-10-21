<?php
class Model_promotion extends CI_Model {
	private $_product                    = 'product';
	private $_promotion                  = 'promotion';
	private $_promotion_detail           = 'promotion_detail';
	private $_promotion_item_mapping     = 'promotion_item_mapping';
	private $_promotion_supplier_mapping = 'promotion_supplier_mapping';
	private $_promotion_type             = 'promotion_type';
	private $_promotion_type_field       = 'promotion_type_field';
	private $_promotion_type_mapping     = 'promotion_type_mapping';
	private $_voucher                    = 'voucher';

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function count_rows() {
		$this->db->from($this->_promotion.' AS p');
		$this->db->join($this->_promotion_type.' AS pt', 'p.promotion_type = pt.promotion_type_id');
		$this->db->join($this->_promotion_supplier_mapping.' AS psm', 'p.promotion_id = psm.promotion_id');

		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_promotion($limit = NULL, $off = NULL, $status = NULL, $key = NULL, $order = NULL) {
		$this->db->from($this->_promotion.' AS p');
		$this->db->join($this->_promotion_type.' AS pt', 'p.promotion_type = pt.promotion_type_id');
		$this->db->join($this->_promotion_detail.' AS pd', 'p.promotion_id = pd.promotion_id');
		$this->db->limit($limit, $off);

		if ($key) {
			$this->db->like('p.promotion_name', $key);
		}

		if (!empty($order)) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by('p.promotion_enddate', 'DESC');
		}

		$query  = $this->db->get();
		$result = $query->result_array();

		foreach ($result as $key => $promotion) {
			$product                                 = $this->get_promotion_product($promotion['promotion_id']);
			$field                                   = $this->get_promotion_type_field($promotion['promotion_type_id']);
			$detail                                  = $this->get_promotion_detail($promotion['promotion_id']);
			$result[$key]['detail'][$key]['product'] = $product;
			$result[$key]['detail'][$key]['field']   = $field;
			$result[$key]['detail'][$key]['detail']  = $detail['promotion_detail_mapping_field_value'];
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function check_item_exist($promotion_id, $prod_id) {
		$this->db->where('promotion_id', (int) $promotion_id);
		$this->db->where('product_id', (int) $prod_id);
		$query = $this->db->get($this->_promotion_item_mapping);

		return $query->num_rows();
	}

	public function get_promotion_detail($promotion_id) {
		$this->db->from($this->_promotion.' AS p');
		$this->db->join($this->_promotion_detail.' AS pd', 'p.promotion_id = pd.promotion_id');
		$this->db->where('p.promotion_id', (int) $promotion_id);
		$query  = $this->db->get();
		$result = $query->row_array();

		$result['items'] = $this->get_promotion_item($promotion_id);

		return $result;
	}

	public function get_promotion_item($promotion_id) {
		$this->db->from($this->_promotion_item_mapping.' AS pim');
		$this->db->where('pim.promotion_id', (int) $promotion_id);
		$query  = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	public function get_product_by_promotion($data, $keyword, $order) {
		$ids = array();

		foreach ($data as $key => $value) {
			$ids[] = $value['product_id'];
		}

		if (!empty($ids)) 
		{
			$this->db->where_in('prod_id', $ids);

			if (!empty($order)) 
			{
				$this->db->order_by($order);
			} 
			else 
			{
				$this->db->order_by('product_upload_date', 'DESC');
			}

			if ($keyword) 
			{
				$this->db->like('prod_name', $keyword);
			}

			$query = $this->db->get($this->_product);

			return $query->result_array();
		} 
		else 
		{
			return array();
		}
	}

	public function get_promotion_by_id($promotion_id) {
		$this->db->from($this->_promotion.' AS p');
		$this->db->join($this->_promotion_type.' AS pt', 'p.promotion_type = pt.promotion_type_id');
		$this->db->where('p.promotion_id', (int) $promotion_id);
		$query  = $this->db->get();
		$result = $query->row_array();

		if (!empty($result)) {
			$product                     = $this->get_promotion_product($result['promotion_id']);
			$field                       = $this->get_promotion_type_field($result['promotion_type_id']);
			$detail                      = $this->get_promotion_detail($result['promotion_id']);
			$result['detail']['product'] = $product;
			$result['detail']['field']   = $field;
			$result['detail']['detail']  = $detail['promotion_detail_mapping_field_value'];
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function get_available_promotion() {
		$this->db->select('p.promotion_id, p.promotion_name');
		$this->db->from($this->_promotion.' AS p');
		$this->db->where('p.promotion_enddate >= NOW()');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_promotion_product($promotion_id) {
		$this->db->from($this->_promotion_item_mapping.' AS pim');
		$this->db->join($this->_product.' AS p', 'p.prod_id = pim.product_id');
		$this->db->where('pim.promotion_id', (int) $promotion_id);
		$query  = $this->db->get();
		$result = $query->result_array();
		$list   = array();

		foreach ($result as $key => $product) {
			$list[] = $product['prod_name'];
		}

		if (!$query) {
			return false;
		} else {
			return implode(', ', $list);
		}
	}

	public function get_promotion_type_field($promotion_type_id) {
		$this->db->from($this->_promotion_type_field.' AS ptf');
		$this->db->join($this->_promotion_type_mapping.' AS ptm', 'ptf.promotion_type_field_id = ptm.promotion_type_field_id');
		$this->db->where('ptm.promotion_type_id', (int) $promotion_type_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_promotion_type() {
		$query = $this->db->get($this->_promotion_type);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_promotion_field_id($type_id) {
		$this->db->where('promotion_type_mapping_id', (int) $type_id);
		$query = $this->db->get($this->_promotion_type_mapping);
		$data  = $query->result_array();
		$ids   = array();

		foreach ($data as $key => $value) {
			$ids[] = $value['promotion_type_field_id'];
		}

		if (!$query) {
			return false;
		} else {
			return implode(',', $ids);
		}
	}

	public function get_promotion_field($field_id) {
		$this->db->where_in('promotion_type_field_id', $field_id);
		$query = $this->db->get($this->_promotion_type_field);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_promotion_product_id($promotion_id) {
		$this->db->select('product_id');
		$this->db->where('promotion_id', (int) $promotion_id);
		$query = $this->db->get($this->_promotion_item_mapping);
		$data  = $query->result_array();
		$id    = array();

		foreach ($data as $key => $product) {
			$id[] = $product['product_id'];
		}

		if (!$query) {
			return false;
		} else {
			return $id;
		}
	}

	public function count_voucher() {
		$this->db->from($this->_voucher);

		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_voucher($limit = NULL, $off = NULL, $keyword = NULL) {
		$this->db->limit($limit, $off);
		if ($keyword) {
			$this->db->like('voucher_code', $keyword);
		}
		$query = $this->db->get($this->_voucher);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_voucher_by_id($id) {
		$this->db->where('voucher_id', (int) $id);
		$query = $this->db->get($this->_voucher);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function insert_voucher($data) {
		if ($this->db->insert($this->_voucher, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function update_voucher($data, $voucher_id) {
		$this->db->where("voucher_id", (int) $voucher_id);

		if ($this->db->update($this->_voucher, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert($data) {
		if ($this->db->insert($this->_promotion, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function update($data, $promotion_id) {
		$this->db->where("promotion_id", (int) $promotion_id);

		if ($this->db->update($this->_promotion, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert_promotion_detail($data) {
		if ($this->db->insert($this->_promotion_detail, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_promotion_detail($data, $promotion_id) {
		$this->db->where("promotion_id", (int) $promotion_id);

		if ($this->db->update($this->_promotion_detail, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert_promotion_item($data) {
		if ($this->db->insert($this->_promotion_item_mapping, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_promotion($data) {
		if ($this->db->insert($this->_promotion_item_mapping, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_promotion_supplier($data, $promotion_id, $sup_id) {
		$this->db->where("promotion_id", (int) $promotion_id);
		$this->db->where("supplier_id", (int) $sup_id);

		if ($this->db->update($this->_promotion_supplier_mapping, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_promotion($data) {
		$this->db->where("promotion_id", (int) $data['promotion_id']);
		$this->db->where("product_id", (int) $data['product_id']);

		if ($this->db->delete($this->_promotion_item_mapping)) {
			return true;
		} else {

			return false;
		}
	}
}

?>