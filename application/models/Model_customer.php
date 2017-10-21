<?php
class Model_customer extends CI_Model {
	private $_table                   = "customer";
	private $_customer_type           = "customer_type";
	private $_orders                  = "orders";
	private $_order_payment           = 'order_payment';
	private $_order_payment_detail    = 'order_payment_detail';
	private $_order                   = 'orders';
	private $_order_item              = 'order_item';
	private $_order_status            = 'order_status';
	private $_order_extra_fee         = 'order_extra_fee';
	private $_order_extra_fee_detail  = 'order_extra_fee_detail';
	private $_product                 = 'product';
	private $_product_variant         = 'product_variant';
	private $_product_variant_mapping = 'product_variant_mapping';
	private $_product_image           = 'product_image';
	private $_product_variant_image   = 'product_variant_image';
	private $_payment_method          = 'payment_method';
	private $_payment_method_field    = 'payment_method_field';
	private $_payment_method_mapping  = 'payment_method_mapping';
	private $_payment_status          = 'payment_status';
	private $_voucher                 = 'voucher';

	private $_type               = "customer_type";
	private $_field              = "customer_field";
	private $_mapping            = "customer_field_mapping";
	private $_detail             = "customer_detail";
	private $_address            = "customer_shipping_address";
	private $_email_subscription = "email_subscription";
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	//----------------------------------
	function get_info_detail($id) {
		$this->db->select('d.*, f.*, c.*');
		$this->db->from($this->_table.' AS c');
		$this->db->join($this->_type.' AS t', 'c.cus_type = t.customer_type_id', 'left');
		$this->db->join($this->_mapping.' AS m', 't.customer_type_id = m.cus_type_id', 'left');
		$this->db->join($this->_field.' AS f', 'm.cus_field_id = f.cus_field_id', 'left');
		$this->db->join($this->_detail.' AS d', 'f.cus_field_id = d.cus_detail_field_id', 'left');
		$this->db->where('c.cus_id', (int) $id);
		$query = $this->db->get();
		$rows  = $query->result_array();

		foreach ($rows as $key => $row) {
			$data[$row['cus_field_name']] = $row['cus_detail_value'];
			$data['cus_name']             = $row['cus_name'];
			$data['cus_email']            = $row['cus_email'];
			$data['cus_phone']            = $row['cus_phone'];
		}

		if ($data) {
			return $data;
		} else {

			return false;
		}
	}

	function get_field($id = null) {
		if (!empty($id)) {
			$this->db->select('f.*,d.*');
			$this->db->from($this->_table.' AS c');
			$this->db->join($this->_type.' AS t', 'c.cus_type = t.customer_type_id', 'left');
			$this->db->join($this->_mapping.' AS m', 't.customer_type_id = m.cus_type_id', 'left');
			$this->db->join($this->_field.' AS f', 'm.cus_field_id = f.cus_field_id', 'left');
			$this->db->join($this->_detail.' AS d', 'f.cus_field_id = d.cus_detail_field_id', 'left');
			$this->db->where('c.cus_id', (int) $id);
		} else {
			$this->db->select('f.*');
			$this->db->from($this->_field.' AS f');
			$this->db->join($this->_mapping.' AS m', 'f.cus_field_id = m.cus_field_id', 'left');
			$this->db->join($this->_type.' AS t', 'm.cus_type_id = t.customer_type_id', 'left');
			$this->db->where('t.customer_type_id', '1');
		}

		$query = $this->db->get();
		$rows  = $query->result_array();

		foreach ($rows as $key => $row) {
			if (!empty($id) && !empty($row['cus_field_name'])) {
				$data[$row['cus_field_name']]['value'] = $row['cus_detail_value'];
			}

			$data[$row['cus_field_name']]['id']   = $row['cus_field_name'];
			$data[$row['cus_field_name']]['name'] = $row['cus_field_name'];
		}

		if (!empty($data)) {
			return $data;
		} else {

			return false;
		}
	}
	//--------------------------------
	public function get_customers($type = null, $limit = NULL, $off = NULL, $order = NULL, $keyword = NULL) {
		$this->db->select('c.*, ct.customer_type_name');

		if (!empty($type)) {
			$this->db->where('c.cus_type', (int) $type);
		}

		$this->db->from($this->_table.' AS c');
		$this->db->join($this->_customer_type.' AS ct', 'c.cus_type = ct.customer_type_id');
		$this->db->limit($limit, $off);

		if (!empty($order)) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by('c.cus_join_date DESC');
		}
		if ($keyword) {
			$this->db->like('c.cus_name', $keyword);
		}
		$query = $this->db->get();
		$data  = $query->result_array();

		return $data;
	}

	function count_rows($type = null) {
		if (!empty($type)) {
			$this->db->where('cus_type', (int) $type);
		}

		return $this->db->count_all($this->_table);
	}

	public function get_customer_type() {
		$query = $this->db->get($this->_customer_type);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_customer_detail($cus_id) {
		$this->db->select('c.*, ct.customer_type_name');
		$this->db->from($this->_table.' AS c');
		$this->db->join($this->_customer_type.' AS ct', 'c.cus_type = ct.customer_type_id');
		$this->db->where('cus_id', (int) $cus_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_purchase_history($user_id) {
		$this->db->select('o.*, o.order_id AS id');
		$this->db->select('op.*, op.order_id AS payment_order_id');
		$this->db->select('efd.*, efd.order_id AS extra_fee_order_id');
		$this->db->select('ef.*');
		$this->db->select('os.order_status_name');
		$this->db->from($this->_order.' AS o');
		$this->db->join($this->_order_status.' AS os', 'o.order_status = os.order_status_id', 'left');
		$this->db->join($this->_order_payment.' AS op', 'op.order_id = o.order_id', 'left');
		$this->db->join($this->_order_extra_fee_detail.' AS efd', 'efd.order_id = o.order_id', 'left');
		$this->db->join($this->_order_extra_fee.' AS ef', 'ef.order_extra_fee_id = efd.order_extra_fee_type', 'left');
		$this->db->where('o.order_cus_id', $user_id);
		$this->db->order_by('o.order_date', 'DESC');
		$this->db->order_by('o.order_id', 'DESC');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_order_items_detail($order_id) {
		$this->db->select('p.*, oi.*');
		$this->db->from($this->_order_item.' AS oi');
		$this->db->join($this->_product.' AS p', 'p.prod_id = oi.order_item_prod_id', 'left');
		$this->db->where('oi.order_id', (int) $order_id);
		$this->db->where('oi.order_item_shipping_status', 1);
		$query = $this->db->get();

		$items = $query->result_array();

		foreach ($items as $key => $item) {
			$items[$key]['slug_name'] = strtolower(alias($item['prod_name']));
			$variant_mapping_id       = $this->get_variant_value_id($item['order_item_prod_variant_mapping_id']);

			if (!empty($variant_mapping_id['product_variant_value1'])) {
				$value1 = $variant_mapping_id['product_variant_value1'];
			} else {
				$value1 = "";
			}

			if (!empty($variant_mapping_id['product_variant_value2'])) {
				$value2 = $variant_mapping_id['product_variant_value2'];
			} else {
				$value2 = "";
			}

			$items[$key]['variant_value'][] = $this->get_variant_value($value1);
			$items[$key]['variant_value'][] = $this->get_variant_value($value2);

			$variant_image = $this->get_variant_image($item['order_item_prod_variant_mapping_id']);
			$product_image = $this->get_product_image($item['prod_id']);

			if (!empty($variant_image)) {
				$items[$key]['image'] = $variant_image;
			} else {
				$items[$key]['image'] = $product_image;
			}
		}

		return $items;
	}

	public function get_variant_value($variant_id) {
		$this->db->select('pv.variant_value');
		$this->db->from($this->_product_variant.' AS pv');
		$this->db->where('pv.product_variant_id', (int) $variant_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {

			$data = $query->row_array();

			if (!empty($data)) {
				return $data['variant_value'];
			} else {
				return "";
			}
		}
	}

	public function get_variant_value_id($variant_mapping_id) {
		$this->db->select('pvm.product_variant_value1, pvm.product_variant_value2');
		$this->db->from($this->_product_variant_mapping.' AS pvm');
		$this->db->where('pvm.product_variant_mapping_id', (int) $variant_mapping_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_variant_image($variant_id) {
		$this->db->from($this->_product_variant_image);
		$this->db->where('product_variant_id', (int) $variant_id);
		$query = $this->db->get();
		$image = $query->result_array();
		$data  = array();

		foreach ($image as $key => $value) {
			$data[] = $value['variant_image_path'];
		}

		if (!empty($data)) {
			$result = $data[0];
		} else {
			$result = '';
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function get_product_image($prod_id) {
		$this->db->from($this->_product_image);
		$this->db->where('prod_id', (int) $prod_id);
		$query = $this->db->get();
		$image = $query->result_array();
		$data  = array();

		foreach ($image as $key => $value) {
			$data[] = $value['prod_image_path'];
		}

		if (!empty($data)) {
			$result = $data[0];
		} else {
			$result = '';
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function get_payment_detail($order_payment_id) {
		$this->db->where('order_payment_id', $order_payment_id);
		$query = $this->db->get($this->_order_payment_detail);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_payment_method_field() {
		$this->db->select('f.*, pm.payment_method_id');
		$this->db->from($this->_payment_method_mapping.' AS pm');
		$this->db->join($this->_payment_method_field.' AS f', 'f.payment_method_field_id = pm.payment_method_field_id', 'left');
		$this->db->join($this->_payment_method.' AS p', 'p.payment_method_id = pm.payment_method_id', 'left');
		$this->db->where('f.payment_method_field_status', 1);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_voucher($code) {
		$this->db->where('voucher_code', $code);
		$query = $this->db->get($this->_voucher);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}
}