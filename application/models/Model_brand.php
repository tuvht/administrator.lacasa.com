<?php
class Model_brand extends CI_Model {
	private $brand = "brand";

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function Create_brand($data) {
		$create = $this->db->insert($this->brand, $data);
		if (!$create) {
			return false;
		}
		return true;
	}
	public function get_brand_detail($id) {
		$this->db->where('brand_id', $id);
		$result = $this->db->get($this->brand);
		if (!$result) {
			return array();
		}
		if ($result->num_rows() != 1) {
			return array();

		}
		return $result->row_array();
	}
	public function edit_brand($id, $data) {
		$this->db->where('brand_id', $id);
		$edit = $this->db->update($this->brand, $data);
		if (!$edit) {
			return false;
		}
		return true;
	}

	public function count($status = NULL, $key = NULL) {
		$this->db->from($this->brand);

		if ($key) {
			$this->db->where('brand_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('brand_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	function getItems($limit = NULL, $off = NULL, $status = NULL, $order = NULL, $keyword = NULL) {
		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("brand_id", "desc");
		}

		if (isset($status)) {
			$this->db->where('brand_status', $status);
		}

		$this->db->limit($limit, $off);
		if ($keyword) {
			$this->db->like('brand_name', $keyword);
		}

		return $this->db->get($this->brand)->result_array();
	}
}
?>
