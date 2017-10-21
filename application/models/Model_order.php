<?php
class Model_order extends CI_Model {
	private $_main_orders                         = 'orders';
	private $_order_extra_fee                     = 'order_extra_fee';
	private $_order_extra_fee_detail              = 'order_extra_fee_detail';
	private $_orders                              = 'supplier_order';
	private $_order_item                          = 'order_item';
	private $_order_payment                       = 'order_payment';
	private $_order_payment_detail                = 'order_payment_detail';
	private $_payment_method                      = 'payment_method';
	private $_order_status                        = 'order_status';
	private $_product_warehouse_stock             = 'product_warehouse_stock';
	private $_product                             = 'product';
	private $_product_image                       = 'product_image';
	private $_product_variant                     = 'product_variant';
	private $_product_variant_image               = 'product_variant_image';
	private $_product_variant_mapping             = 'product_variant_mapping';
	private $_supplier_warehouse                  = 'supplier_warehouse';
	private $_cancelled_order                     = 'cancelled_order';
	private $_cancelled_supplier_order            = 'cancelled_supplier_order';
	private $_order_cancel_reason                 = 'order_cancel_reason';
	private $_company_shipper                     = 'company_shipper';
	private $_customer                            = 'customer';
	private $_supplier                            = 'supplier';
	private $_supplier_order_transaction_history  = 'supplier_order_transaction_history';
	private $_warehouse_order_transaction_history = 'warehouse_order_transaction_history';
	private $_order_transaction_type              = 'order_transaction_type';
	private $_voucher                             = 'voucher';
	private $_supplier_contracttype               = 'supplier_contracttype';
	private $_supplier_contract_detail            = 'supplier_contract_detail';
	private $_supplier_main_order_mapping         = 'supplier_main_order_mapping';
	private $_shipping_status                     = 'shipping_status';

	private $_country          = 'country';
	private $_city             = 'city';
	private $_district         = 'district';
	private $_shipping_address = 'customer_shipping_address';

	private $_order_cancel_shipping_reason = 'shipping_cancel_reason';

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function check_customer($id) {
		$this->db->where("$this->_customer.cus_id", $id);
		$result = $this->db->get($this->_customer);
		if (!$result) {
			return false;
		}
		if ($result->num_rows() != 1) {
			return false;
		}
		return true;
	}

	public function get_address_by_user_id($id) {
		$this->db->select('a.addr_street, c.country_id, c.country_name, ct.city_id, ct.city_name, d.district_id, d.district_name, a.addr_id');
		$this->db->from($this->_shipping_address.' AS a');
		$this->db->join($this->_country.' AS c', 'c.country_id = a.addr_country', 'left');
		$this->db->join($this->_city.' AS ct', 'ct.city_id = a.addr_city', 'left');
		$this->db->join($this->_district.' AS d', 'd.district_id = a.addr_district', 'left');
		$this->db->where('a.cus_id', (int) $id);
		$query = $this->db->get();

		if ($query) {
			return $query->result_array();
		} else {

			return false;
		}
	}

	public function check_order($id) {

		$this->db->where("$this->_main_orders.order_id", $id);
		$result = $this->db->get($this->_main_orders);
		if (!$result) {
			return false;
		}
		if ($result->num_rows() != 1) {
			return false;
		}
		return true;
	}

	public function get_order_by_id($id) {
		$this->db->where('main_order_id', (int) $id);
		$query = $this->db->get($this->_orders);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_order_by_status($id, $status) {
		$this->db->where('main_order_id', (int) $id);
		$this->db->where('sup_order_status', (int) $status);
		$query = $this->db->get($this->_orders);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function getMainOrderID($id = NULL, $sup_id = NULL) {
		$this->db->select("sup_order_id");
		$this->db->where('main_order_id', $id);
		$this->db->where("sup_id", $sup_id);
		$result = $this->db->get("supplier_order");
		if (!$result) {
			return array();
		}
		if ($result->num_rows() != 1) {
			return array();
		}
		return $result->row_array()['sup_order_id'];
	}

	public function count_rows($status = NULL) {
		$this->db->from($this->_main_orders.' AS o');
		if ($status != NULL) {
			$this->db->where_in('o.order_status', $status);
		}

		$query = $this->db->get();
		return $query->num_rows();
	}

	/*public function get_order_item($status = null, $id)
	{
	if (!empty($status))
	{
	$this->db->where('sup_order_status', (int) $status);
	}

	$this->db->where('sup_id', (int) $id);
	$query = $this->db->get($this->_orders);

	if (!$query)
	{
	return false;
	}
	else
	{
	return $query->result_array();
	}
	}*/

	public function get_order_detail($order_id) {
		$this->db->select('mo.*, c.cus_name, c.cus_email, c.cus_phone, op.*, pm.payment_method_type');
		$this->db->from($this->_main_orders.' AS mo');
		$this->db->join($this->_customer.' AS c', 'mo.order_cus_id = c.cus_id', 'left');
		$this->db->join($this->_order_payment.' AS op', 'mo.order_id = op.order_id', 'left');
		$this->db->join($this->_payment_method.' AS pm', 'op.order_payment_method_id = pm.payment_method_id', 'left');
		$this->db->where('mo.order_id', (int) $order_id);
		$query = $this->db->get();
		$data  = $query->row_array();

		$items         = $this->get_order_item($order_id);
		$data['items'] = $items;

		$voucher = $this->get_voucher($data['voucher']);

		if (!empty($voucher)) {
			$data['discount']['code'] = $voucher['voucher_code'];

			if (!empty($voucher['discount_value'])) {
				$data['discount']['discount_type'] = price($voucher['discount_value']);
				$data['discount']['value']         = $data['order_payment_amount']-$voucher['discount_value'];
			} elseif (!empty($voucher['discount_percentage'])) {
				$percentage                        = ($data['order_payment_amount']*$voucher['discount_percentage'])/100;
				$data['discount']['discount_type'] = $voucher['discount_percentage'].'%';
				$data['discount']['value']         = $data['order_payment_amount']-$percentage;
			}
		} else {
			$data['discount']['code']          = '';
			$data['discount']['discount_type'] = 0;
			$data['discount']['value']         = 0;
		}

		$order_log       = $this->get_sup_order_log($order_id);
		$data['logs']    = $order_log;
		$contract_value  = 0;
		$ordertotalvalue = 0;

		foreach ($items as $k => $item) {
			$contract = $this->get_contract_detail($item['sup_id']);
			$value    = 0;

			if (!empty($contract['sup_contracttype']) && $contract['sup_contracttype'] == 1) {
				if (empty($data['discount']['value'])) {
					$value = (($item['order_item_price']*$contract['sup_contract_percentage'])/100)*$item['order_item_quantity'];
				} else {
					$value = (($data['discount']['value']*$contract['sup_contract_percentage'])/100)*$item['order_item_quantity'];
				}

			} elseif (!empty($contract['sup_contracttype']) && $contract['sup_contracttype'] == 2) {
				$value = $contract['sup_contract_staticfee']*$item['order_item_quantity'];
			}

			$contract_value += $value;
			$ordertotalvalue += $item['order_item_price']*$item['order_item_quantity'];
		}

		$data['commision_value'] = $contract_value;

		if ($data['order_status'] == '4' || $data['order_status'] == '8' || $data['order_status'] == '5') {
			$data['shipping_info'] = $this->get_shipping_information($data['order_id']);
		}

		$extra_fees        = $this->get_extra_fee($data['order_id'], 0);
		$data['extra_fee'] = $extra_fees;
		$tax_fees          = $this->get_extra_fee($data['order_id'], 1);
		$fee_tax           = array();

		foreach ($tax_fees as $i => $tax) {
			$fee_tax[] = $tax['order_extra_fee_amount'];
		}

		$data['tax_fee']     = array_sum($fee_tax);
		$data['total_value'] = $ordertotalvalue;

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function get_order_status($order_id, $sup_id) {
		$this->db->where('main_order_id', (int) $order_id);
		$this->db->where('sup_id', (int) $sup_id);
		$query = $this->db->get($this->_orders);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_order_item($order_id) {
		$this->db->select('oi.*, s.*, p.prod_name, p.prod_supplier_id, p.prod_supplierinternalid');
		$this->db->from($this->_order_item.' AS oi');
		$this->db->join($this->_product.' AS p', 'oi.order_item_prod_id = p.prod_id', 'left');
		$this->db->join($this->_supplier.' AS s', 'p.prod_supplier_id = s.sup_id', 'left');
		$this->db->where('oi.order_id', (int) $order_id);
		$query = $this->db->get();
		$data  = $query->result_array();

		foreach ($data as $key => $item) {
			$sup_order                                 = $this->get_order_status($order_id, $item['sup_id']);
			$data[$key]['sup_order_status']            = !empty($sup_order['sup_order_status'])?$sup_order['sup_order_status']:"";
			$data[$key]['sup_shipping_trackingnumber'] = !empty($sup_order['sup_shipping_trackingnumber'])?$sup_order['sup_shipping_trackingnumber']:"";

			if (!empty($item['order_item_prod_variant_mapping_id'])) {
				$product_variant_mapping_id = $item['order_item_prod_variant_mapping_id'];
			} else {
				$product_variant_mapping_id = 0;
			}

			$warehouses = $this->get_supplier_warehouse($item['prod_supplier_id']);

			foreach ($warehouses as $k => $warehouse) {
				$stock = $this->get_product_stock($item['order_item_prod_id'], $product_variant_mapping_id, $warehouse['sup_warehouse_id']);

				if (!empty($stock)) {
					$data[$key]['stock_id'][$warehouse['sup_warehouse_id']] = $stock['product_warehouse_quantity'];
					$data[$key]['stock'][$warehouse['sup_warehouse_name']]  = $stock['product_warehouse_quantity'];
				} else {
					$data[$key]['stock_id'][$warehouse['sup_warehouse_name']] = 0;
					$data[$key]['stock'][$warehouse['sup_warehouse_name']]    = 0;
				}
			}

			$variant_mapping_id = $this->get_variant_value_id($item['order_item_prod_variant_mapping_id']);

			if (!empty($variant_mapping_id['product_variant_supplier_internal_id'])) {
				$data[$key]['variant_internal_id'] = $variant_mapping_id['product_variant_supplier_internal_id'];
			} else {
				$data[$key]['variant_internal_id'] = '';
			}

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

			$data[$key]['variant_value'][] = $this->get_variant_value($value1);
			$data[$key]['variant_value'][] = $this->get_variant_value($value2);

			$image      = $this->get_variant_image($item['order_item_prod_variant_mapping_id']);
			$main_image = $this->get_product_image($item['order_item_prod_id']);

			if (!empty($image)) {
				$data[$key]['variant_image'] = $image;
			} elseif (!empty($main_image)) {
				$data[$key]['variant_image'] = $main_image;
			} else {
				$data[$key]['variant_image'] = '';
			}
		}

		if (!$query) {
			return false;
		} else {
			return $data;
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

	public function get_order_item_revenue($status) {
		$this->db->from($this->_main_orders.' AS o');
		$this->db->join($this->_order_item.' AS oi', 'oi.order_id = o.order_id', 'left');

		if (!empty($status)) {
			$this->db->where('oi.order_status', (int) $status);
		}

		$query = $this->db->get();
		$data  = $query->result_array();

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function get_supplier_warehouse($sup_id) {
		$this->db->where('sup_id', (int) $sup_id);
		$query = $this->db->get($this->_supplier_warehouse);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_product_stock($prod_id, $variant_mapping_id, $sup_warehouse_id) {
		$this->db->where('product_id', (int) $prod_id);
		$this->db->where('product_variant_mapping_id', (int) $variant_mapping_id);
		$this->db->where('supplier_warehouse', (int) $sup_warehouse_id);
		$query = $this->db->get($this->_product_warehouse_stock);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_total_value($order_id) {
		$this->db->select('SUM(order_item_price) AS total_value');
		$this->db->where('order_id', (int) $order_id);
		$query = $this->db->get($this->_order_item);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_main_order($order_id) {
		$this->db->where('order_id', (int) $order_id);
		$query = $this->db->get($this->_main_orders);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_sup_order($order_id) {
		$this->db->where('main_order_id', (int) $order_id);
		$query = $this->db->get($this->_orders);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_orders($sup_order_id = null, $sup_id, $status = null, $limit = NULL, $off = NULL, $key = NULL, $order = NULL) {
		$this->db->select('o.*, os.order_status_name , cus.cus_email, p.payment_method_type AS payment');
		$this->db->select('COUNT(oi.order_item_prod_id) AS count_items, SUM(oi.order_item_quantity * oi.order_item_price) AS total_value');
		$this->db->from($this->_main_orders.' AS o');
		$this->db->join($this->_order_status.' AS os', 'os.order_status_id = o.order_status', 'left');
		$this->db->join($this->_customer." AS cus", "cus.cus_id = o.order_cus_id", "left");
		$this->db->join($this->_order_item.' AS oi', 'o.order_id = oi.order_id', 'left');
		$this->db->join($this->_order_payment.' AS op', 'o.order_id = op.order_id', 'left');
		$this->db->join($this->_payment_method.' AS p', 'op.order_payment_method_id = p.payment_method_id', 'left');
		$this->db->group_by('o.order_id');

		if (array(2, 6) == $status) {
			$this->db->select('cso.*, o.*, ocr.order_cancel_reason_name, ocr.order_cancel_reason_account as cancelled_by');
			$this->db->join($this->_cancelled_order.' AS cso', 'cso.order_id = o.order_id', 'left');
			$this->db->join($this->_order_cancel_reason.' AS ocr', 'cso.cancel_reason = ocr.order_cancel_reason_id', 'left');
		}

		if ($key) {
			$this->db->like('cus.cus_name', $key);
		}

		if (!empty($status)) {
			$this->db->where_in('o.order_status', $status);
		}

		if ($limit != null) {
			$this->db->limit($limit, $off);
		}

		if (!empty($order)) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by('o.order_date DESC');
			$this->db->order_by('o.order_id DESC');
		}

		$query  = $this->db->get();
		$result = $query->result_array();

		foreach ($result as $key => $order) {
			$items                       = $this->get_order_item($order['order_id']);
			$result[$key]['items']       = $items;
			$total                       = $this->get_total_value($order['order_id']);
			$result[$key]['cus_name']    = $order['order_shipping_recipient_name'];
			$result[$key]['cus_phone']   = $order['order_shipping_recipient_phone'];
			$result[$key]['cus_address'] = $order['order_shipping_street'].', '.$order['order_shipping_district'].', '.$order['order_shipping_city'].', '.$order['order_shipping_country'];
			$result[$key]['cus_email']   = $order['cus_email'];

			$voucher = '';

			if (!empty($result[$key]['voucher'])) {
				$voucher = $this->get_voucher($result[$key]['voucher']);
			}

			if (!empty($voucher)) {
				$result[$key]['discount']['code'] = $voucher['voucher_code'];

				if (!empty($voucher['discount_value'])) {
					$result[$key]['discount']['discount_type'] = price($voucher['discount_value']);
					$result[$key]['discount']['value']         = $order['total_value']-$voucher['discount_value'];
				} elseif (!empty($voucher['discount_percentage'])) {
					$percentage                                = ($order['total_value']*$voucher['discount_percentage'])/100;
					$result[$key]['discount']['discount_type'] = $voucher['discount_percentage'].'%';
					$result[$key]['discount']['value']         = $order['total_value']-$percentage;
				}

				$result[$key]['total_value'] = $result[$key]['discount']['value'];
			} else {
				$result[$key]['discount']['code']          = '';
				$result[$key]['discount']['discount_type'] = 0;
				$result[$key]['discount']['value']         = 0;
			}

			if (array(2, 6) == $status) {
				$cancelled_supplier_order = $this->get_cancel_supplier_order($order['order_id']);
				$cancelled_order          = $this->get_cancel_order($order['order_id']);

				//structure($order);
				if (!empty($cancelled_supplier_order)) {
					$result[$key]['cancelled_by'] = 'Supplier';
					// $result[$key]['cancelled_reason'] = $cancelled_supplier_order['order_cancel_reason_name'];
					// $result[$key]['cancelled_date']   = $cancelled_supplier_order['cancel_date'];
					// $result[$key]['cancelled_note']   = $cancelled_supplier_order['cancel_note'];
				} elseif (!empty($cancelled_order)) {
					$result[$key]['cancelled_by'] = 'Customer';
					// $result[$key]['cancelled_reason'] = $cancelled_order['order_cancel_reason_name'];
					// $result[$key]['cancelled_date']   = $cancelled_order['cancel_date'];
					// $result[$key]['cancelled_note']   = $cancelled_order['cancel_note'];
				}
			}
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function report_sale($sup_id) {
		$this->db->select('year(o.sup_order_date) AS year, month(o.sup_order_date) AS month, COUNT(*) AS total, SUM(oi.value) AS value, oi.quantity');
		$this->db->from($this->_orders.' AS o');
		$this->db->join('(SELECT sup_order_id, SUM(sup_order_item_price) AS value, SUM(sup_order_item_quantity) AS quantity FROM supplier_order_item GROUP BY sup_order_id)'.' AS oi', 'o.sup_order_id = oi.sup_order_id', 'left');
		$this->db->where('o.sup_id', (int) $sup_id);
		$this->db->group_by('year(o.sup_order_date), month(o.sup_order_date)');
		$query           = $this->db->get();
		$data            = $query->result_array();
		$cancelled_order = $this->report_cancel_order($sup_id);
		$completed_order = $this->report_complete_order($sup_id);

		foreach ($data as $key => $value) {
			$data[$key]['cancel_order']   = 0;
			$data[$key]['cancel_value']   = 0;
			$data[$key]['complete_order'] = 0;
			$data[$key]['complete_value'] = 0;
			$data[$key]['complete_last']  = '';
			$data[$key]['complete_unit']  = 0;

			foreach ($cancelled_order as $cancel) {
				if ($cancel['month'] == $value['month'] && $cancel['year'] == $value['year']) {
					$data[$key]['cancel_order'] = $cancel['total'];
					$data[$key]['cancel_value'] = $cancel['value'];
				}
			}

			foreach ($completed_order as $complete) {
				if ($complete['month'] == $value['month'] && $complete['year'] == $value['year']) {
					$data[$key]['complete_order'] = $complete['total'];
					$data[$key]['complete_value'] = $complete['value'];
					$data[$key]['complete_last']  = $complete['items'][0]['prod_name'];
					$data[$key]['complete_unit']  = count($complete['items']);
				}
			}
		}

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function report_cancel_order($sup_id) {
		$this->db->select('year(o.sup_order_date) AS year, month(o.sup_order_date) AS month, COUNT(*) AS total, SUM(oi.value) AS value');
		$this->db->from($this->_orders.' AS o');
		$this->db->join($this->_cancelled_supplier_order.' AS co', 'co.order_id = o.sup_order_id', 'inner');
		$this->db->join('(SELECT sup_order_id, SUM(sup_order_item_price) AS value FROM supplier_order_item GROUP BY sup_order_id)'.' AS oi', 'o.sup_order_id = oi.sup_order_id', 'left');
		$this->db->where('o.sup_id', (int) $sup_id);
		$this->db->where('o.sup_order_status', 6);
		$this->db->group_by('year(o.sup_order_date), month(o.sup_order_date)');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function report_complete_order($sup_id) {
		$this->db->select('year(o.sup_order_date) AS year, month(o.sup_order_date) AS month, COUNT(*) AS total, SUM(oi.value) AS value');
		$this->db->from($this->_orders.' AS o');
		$this->db->join('(SELECT sup_order_id, SUM(sup_order_item_price) AS value FROM supplier_order_item GROUP BY sup_order_id)'.' AS oi', 'o.sup_order_id = oi.sup_order_id', 'left');
		$this->db->where('o.sup_id', (int) $sup_id);
		$this->db->where('o.sup_order_status', 5);
		$this->db->group_by('year(o.sup_order_date), month(o.sup_order_date)');
		$query = $this->db->get();
		$data  = $query->result_array();
		$items = $this->report_complete_order_item($sup_id);

		foreach ($data as $key => $value) {
			foreach ($items as $k => $item) {
				if ($value['month'] == $item['month'] && $value['year'] == $item['year']) {
					$data[$key]['items'][] = $item;
				}
			}
		}

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function report_complete_order_item($sup_id) {
		$this->db->select('year(o.sup_order_date) AS year, month(o.sup_order_date) AS month, p.prod_name');
		$this->db->from($this->_orders.' AS o');
		$this->db->join($this->_order_item.' AS oi', 'o.sup_order_id = oi.sup_order_id', 'left');
		$this->db->join($this->_product.' AS p', 'oi.sup_order_prod_id = p.prod_id', 'left');
		$this->db->where('o.sup_id', (int) $sup_id);
		$this->db->where('o.sup_order_status', 5);
		$this->db->order_by('o.sup_order_date DESC');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_order_payment($order_id) {
		$this->db->select('pm.*');
		$this->db->from($this->_order_payment.' AS p');
		$this->db->join($this->_payment_method.' AS pm', 'pm.payment_method_id = p.order_payment_method_id', 'left');
		$this->db->where('p.order_id', (int) $order_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_orders_format($format, $status = null, $id) {
		$data           = $this->get_orders('', $id, $status, '', '', '');
		$current        = date('Y-m-d');
		$current_format = date($format, strtotime($current));
		$i              = 1;
		$result         = 0;

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$order_format = date($format, strtotime($value['order_date']));

				if ($order_format == $current_format) {
					$result = $i;
					$i++;
				}
			}
		}

		return $result;
	}

	public function get_order_revenue($format, $id, $status = null) {
		$data           = $this->get_order_item_revenue($status);
		$current        = date('Y-m-d');
		$current_format = date($format, strtotime($current));
		$result         = array();

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$order_format = date($format, strtotime($value['order_date']));

				if ($order_format == $current_format) {
					$result[] = $value['order_item_price'];
				}
			}
		}

		return array_sum($result);
	}
	public function get_canncel_shipping_reason($order_reason_account = "") {
		$this->db->from($this->_order_cancel_shipping_reason);
		if (!empty($order_reason_account)) {
			$this->db->where($this->_order_cancel_shipping_reason.'.shipping_cancel_reason_name', $order_reason_account);
		}
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_cancel_reason($order_reason_account = array()) {
		$this->db->from($this->_order_cancel_reason);
		if (!empty($order_reason_account)) {
			$this->db->where_in($this->_order_cancel_reason.'.order_cancel_reason_account', $order_reason_account);
		}
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_company_shipper() {
		$this->db->where('com_shipper_status', 1);
		$this->db->from($this->_company_shipper);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_company_shipper_id($id) {
		$this->db->from($this->_company_shipper);
		$this->db->where('com_shipper_id', (int) $id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_cancel_order($order_id) {
		$this->db->select('co.*, ocr.order_cancel_reason_name');
		$this->db->from($this->_cancelled_order.' AS co');
		$this->db->join($this->_order_cancel_reason.' AS ocr', 'co.cancel_reason = ocr.order_cancel_reason_id', 'left');
		$this->db->where('co.order_id', (int) $order_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_cancel_supplier_order($order_id) {
		$this->db->select('co.*, ocr.order_cancel_reason_name');
		$this->db->from($this->_cancelled_supplier_order.' AS co');
		$this->db->join($this->_order_cancel_reason.' AS ocr', 'co.cancel_reason = ocr.order_cancel_reason_id', 'left');
		$this->db->where('co.order_id', (int) $order_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_variant_value_id($variant_mapping_id) {
		$this->db->select('pvm.product_variant_value1, pvm.product_variant_value2, pvm.product_variant_supplier_internal_id');
		$this->db->from($this->_product_variant_mapping.' AS pvm');
		$this->db->where('pvm.product_variant_mapping_id', (int) $variant_mapping_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
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

	public function get_sup_order_log($sup_order_id) {
		$this->db->select('s.sup_contact_name, soth.supplier_order_id, soth.transaction_time, ott.*');
		$this->db->from($this->_supplier_order_transaction_history.' AS soth');
		$this->db->join($this->_order_transaction_type.' AS ott', 'soth.transaction_type = ott.order_transaction_type_id');
		$this->db->join($this->_supplier.' AS s', 'soth.supplier_id = s.sup_id');
		$this->db->where('soth.supplier_order_id', (int) $sup_order_id);
		$this->db->order_by('transaction_time DESC');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_contract_detail($sup_id) {
		$this->db->select('scd.*, sct.sup_contracttype_name');
		$this->db->from($this->_supplier_contract_detail.' AS scd');
		$this->db->join($this->_supplier_contracttype.' AS sct', 'sct.sup_contracttype_id = scd.sup_contracttype');
		$this->db->where('scd.sup_id', (int) $sup_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_extra_fee($order_id, $type) {
		$this->db->select('oed.*, oe.*');
		$this->db->from($this->_order_extra_fee_detail.' AS oed');
		$this->db->join($this->_order_extra_fee.' AS oe', 'oed.order_extra_fee_type = oe.order_extra_fee_id');
		$this->db->where('oed.order_id', (int) $order_id);
		$this->db->where('oe.order_extra_fee_type', (int) $type);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_shipping_information($order_id) {
		$this->db->select('mod.*, cs.*, ss.*');
		$this->db->from($this->_main_orders.' AS `mod`');
		$this->db->join($this->_company_shipper.' AS `cs`', 'mod.order_shipping_shipper_id = cs.com_shipper_id');
		$this->db->join($this->_shipping_status.' AS `ss`', 'cs.com_shipper_status = ss.shipping_status_id');
		$this->db->where('mod.order_id', (int) $order_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function insert_cancel_supplier_order($data) {
		if ($this->db->insert($this->_cancelled_supplier_order, $data)) {
			return true;
		} else {

			return false;
		}
	}
	public function insert_cancel_order($data) {
		if ($this->db->insert($this->_cancelled_order, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update($data, $order_id, $sup_id = NULL) {
		$this->db->where("main_order_id", (int) $order_id);

		if (!empty($sup_id)) {
			$this->db->where("sup_id", (int) $sup_id);
		}

		if ($this->db->update($this->_orders, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_main_order($data, $id) {
		$this->db->where("order_id", (int) $id);

		if ($this->db->update($this->_main_orders, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function delete($id) {
		$this->db->where("order_id", (int) $id);

		if ($this->db->delete($this->_orders)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_supplier_order_log($data) {
		if ($this->db->insert($this->_supplier_order_transaction_history, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_warehouse_order_log($data) {
		if ($this->db->insert($this->_warehouse_order_transaction_history, $data)) {
			return true;
		} else {

			return false;
		}
	}
}

?>
