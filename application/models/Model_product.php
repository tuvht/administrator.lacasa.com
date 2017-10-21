<?php
class Model_product extends CI_Model {
	private $_product                     = 'product';
	private $_product_detail              = 'product_detail';
	private $_product_image               = 'product_image';
	private $_product_variant             = 'product_variant';
	private $_product_variant_mapping     = 'product_variant_mapping';
	private $_product_rating              = 'product_rating';
	private $_product_type                = 'product_type';
	private $_product_warehouse_stock     = 'product_warehouse_stock';
	private $_product_variant_image       = 'product_variant_image';
	private $_product_transaction_type    = 'product_transaction_type';
	private $_product_transaction_history = 'product_transaction_history';
	private $_brand                       = 'brand';
	private $_category_field              = 'category_field';
	private $_category_field_mapping      = 'category_field_mapping';
	private $_incomplete_order            = 'incomplete_order';
	private $_promotion                   = 'promotion';
	private $_promotion_item_mapping      = 'promotion_item_mapping';
	private $_supplier                    = 'supplier';
	private $_supplier_warehouse          = 'supplier_warehouse';
	private $_supplier_order              = 'supplier_order';
	private $_supplier_order_item         = 'supplier_order_item';
	private $_criteria                    = 'criteria';
	private $_product_check               = 'product_check';
	private $_category_criteria_mapping   = 'category_criteria_mapping';

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('my_data');
	}

	public function count_rows($status = NULL, $key = NULL) {
		$this->db->from($this->_product.' AS p');

		if ($key) {
			$this->db->where('p.prod_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('prod_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}
	public function check_product($id) {

		$this->db->where("$this->_product.prod_id", $id);
		$result = $this->db->get($this->_product);
		if (!$result) {
			return false;
		}
		if ($result->num_rows() != 1) {
			return false;
		}
		return true;
	}
	public function get_products($limit = NULL, $off = NULL, $status = NULL, $key = NULL, $order = NULL) {
		$this->db->select('p.*, pt.prod_type_name, CONCAT(s.sup_name, " - ", s.sup_email) AS sup_name, pr.promotion_name AS promotion', false);
		$this->db->select('SUM(pws.product_warehouse_quantity) AS stock_total');
		$this->db->from($this->_product . ' AS p');
		$this->db->join($this->_product_type . ' AS pt', 'p.prod_type = pt.prod_type_id', 'left');
		$this->db->join($this->_supplier . ' AS s', 'p.prod_supplier_id = s.sup_id', 'left');
		$this->db->join($this->_product_warehouse_stock . ' AS pws', 'p.prod_id = pws.product_id', 'left');
		$this->db->join($this->_promotion_item_mapping.' AS pim', 'p.prod_id = pim.product_id', 'left');
		$this->db->join($this->_promotion.' AS pr', 'pim.promotion_id = pr.promotion_id', 'left');
		$this->db->group_by('p.prod_id');

		if (isset($status)) {
			$this->db->where('prod_status', $status);
		}

		if ($key) {
			$this->db->like('p.prod_name', $key);
		}

		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("p.prod_upload_date", "desc");
		}

		if (!empty($limit)) {
			$this->db->limit($limit, $off);
		}

		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['slug_name'] = strtolower(alias($value['prod_name']));
			$stock_total             = $this->get_product_stock($value['prod_id']);
			$promotion               = $this->get_promotion($value['prod_id']);
			$stock_quantity          = $this->get_stock_quantity($value['prod_id']);
			$sold_quantity           = $this->get_product_sold($value['prod_id']);
			$min_price               = $this->get_min_price_variant($value['prod_id']);
			$max_price               = $this->get_max_price_variant($value['prod_id']);
			$data[$key]['last_sold'] = $this->get_product_last_sold($value['prod_id']);
			$criteria                = $this->get_product_check($value['prod_id']);
			$last_check              = $this->get_product_last_check($value['prod_id']);

			if (!empty($criteria)) {
				$data[$key]['criteria'] = $criteria;
			} else {
				$data[$key]['criteria'] = array();
			}

			if (!empty($last_check)) {
				$data[$key]['last_check'] = $last_check;
			} else {
				$data[$key]['last_check'] = array();
			}

			if (!empty($min_price)) {
				$data[$key]['min_price'] = $min_price;
			} else {
				$data[$key]['min_price'] = 0;
			}

			if (!empty($max_price)) {
				$data[$key]['max_price'] = $max_price;
			} else {
				$data[$key]['max_price'] = 0;
			}

			if (!empty($stock_quantity)) {
				$data[$key]['stock_quantity'] = $stock_quantity;
			} else {
				$data[$key]['stock_quantity'] = 0;
			}

			if (!empty($sold_quantity)) {
				$data[$key]['sold_quantity'] = $sold_quantity['sold'];
			} else {
				$data[$key]['sold_quantity'] = 0;
			}
		}

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	public function count_rows_out_stock($status = NULL, $key = NULL) {
		$ids = $this->get_products_out_stock();
		$this->db->from($this->_product.' AS p');

		if (!empty($ids)) {
			$this->db->where_in('p.prod_id', $ids);
		} else {
			$this->db->where_in('p.prod_id', 0);
		}

		if ($key) {
			$this->db->where('p.prod_name like "%'.$key.'%"');
		}

		if (isset($status)) {
			$this->db->where('prod_status', $status);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_products_out_stock_list($limit = NULL, $off = NULL, $status = NULL, $key = NULL, $order = NULL) {
		$ids = $this->get_products_out_stock();
		$this->db->select('p.*, s.sup_name, CONCAT(s.sup_name, " - ", s.sup_email) AS sup_name, pr.promotion_name AS promotion', false);
		$this->db->select('SUM(pws.product_warehouse_quantity) AS stock_total');
		$this->db->from($this->_product.' AS p');
		$this->db->join($this->_supplier.' AS s', 'p.prod_supplier_id = s.sup_id', 'left');
		$this->db->join($this->_product_warehouse_stock . ' AS pws', 'p.prod_id = pws.product_id', 'left');
		$this->db->join($this->_promotion_item_mapping.' AS pim', 'p.prod_id = pim.product_id', 'left');
		$this->db->join($this->_promotion.' AS pr', 'pim.promotion_id = pr.promotion_id', 'left');
		$this->db->group_by('p.prod_id');

		if (!empty($ids)) {
			$this->db->where_in('p.prod_id', $ids);
		} else {
			$this->db->where_in('p.prod_id', 0);
		}

		if (!empty($status)) {
			$this->db->where('prod_status', $status);
		}

		if ($key) {
			$this->db->like('p.prod_name', $key);
		}

		if ($order) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by("p.prod_upload_date", "desc");
		}

		$this->db->limit($limit, $off);
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['slug_name'] = strtolower(alias($value['prod_name']));
			$stock_total             = $this->get_product_stock($value['prod_id']);
			$stock_quantity          = $this->get_stock_quantity($value['prod_id']);
			$data[$key]['last_sold'] = $this->get_product_last_sold($value['prod_id']);

			if (!empty($stock_quantity)) {
				$data[$key]['stock_quantity'] = $stock_quantity;
			} else {
				$data[$key]['stock_quantity'] = 0;
			}
		}

		if ($query) {
			return $data;
		} else {

			return false;
		}
	}

	public function get_products_out_stock() {
		$this->db->select('p.*');
		$this->db->from($this->_product.' AS p');
		$query = $this->db->get();
		$data  = $query->result_array();
		$ids   = array();

		foreach ($data as $key => $value) {
			$stock_total = $this->get_product_stock($value['prod_id']);

			if ($stock_total['stock_total'] <= 0) {

				$ids[] = $value['prod_id'];
			}
		}

		if ($query) {
			return $ids;
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

	public function get_product_sold($id) {
		$this->db->select('SUM(sup_order_item_quantity) as sold');
		$this->db->from($this->_supplier_order_item);
		$this->db->where('sup_order_prod_id', (int) $id);
		$this->db->group_by('sup_order_prod_id');
		$query = $this->db->get();

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	public function get_promotion($id) {
		$this->db->select('p.promotion_name');
		$this->db->from($this->_promotion.' AS p');
		$this->db->join($this->_promotion_item_mapping.' AS pim', 'p.promotion_id = pim.promotion_id', 'left');
		$this->db->where('pim.product_id', (int) $id);
		$query = $this->db->get();

		if ($query) {
			return $query->row_array();
		} else {

			return false;
		}
	}

	public function get_product_by_id($id) {
		$this->db->select('p.*');
		$this->db->select('SUM(pws.product_warehouse_quantity) AS stock_total');
		$this->db->from($this->_product.' AS p');
		$this->db->join($this->_product_warehouse_stock . ' AS pws', 'p.prod_id = pws.product_id', 'left');
		$this->db->where('p.prod_id', (int) $id);

		$query            = $this->db->get();
		$data             = $query->row_array();
		$data['criteria'] = $this->get_criteria($data['prod_cat_id']);
		$check            = $this->get_product_check($id);

		$data['check'] = $check;
		$data['last_sold'] = $this->get_product_last_sold($data['prod_id']);

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function get_variant_by_id($id) {
		$this->db->select('pv.*');
		$this->db->from($this->_product_variant.' AS pv');
		$this->db->where('pv.product_variant_id', (int) $id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_category_field_by_id($cat_field_id) {
		$this->db->select('cf.*');
		$this->db->from($this->_category_field.' AS cf');
		$this->db->where('cf.cat_field_id', (int) $cat_field_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_category_field($product_id) {
		$this->db->select('cf.*');
		$this->db->from($this->_product_variant.' AS pv');
		$this->db->join($this->_category_field.' AS cf', 'cf.cat_field_id = pv.cat_field_id', 'left');
		$this->db->where('pv.product_id', (int) $product_id);
		$this->db->where('cf.cat_field_status', '1');
		$this->db->where('pv.product_variant_status', '1');
		$this->db->group_by('pv.cat_field_id');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_variant_stock($prod_id) {
		$this->db->select('pws.*');
		$this->db->from($this->_product_warehouse_stock.' AS pws');
		$this->db->where('pws.product_id', (int) $prod_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_variant_mapping_by_product_id($prod_id) {
		$this->db->select('pvm.*');
		$this->db->from($this->_product_variant_mapping.' AS pvm');
		$this->db->where('pvm.product_id', (int) $prod_id);
		$query  = $this->db->get();
		$data   = $query->result_array();
		$stocks = $this->get_variant_stock($prod_id);

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$value1                                 = $this->get_variant_by_id($value['product_variant_value1']);
				$value2                                 = $this->get_variant_by_id($value['product_variant_value2']);
				$cat_field1                             = $this->get_category_field_by_id($value1['cat_field_id']);
				$data[$key]['product_variant_value1']   = array();
				$data[$key]['product_variant_value1'][] = $cat_field1['cat_field_id'];
				$data[$key]['product_variant_value1'][] = $cat_field1['cat_field_name'];
				$data[$key]['product_variant_value1'][] = $value1['variant_value'];

				if (!empty($value2)) {
					$cat_field2                             = $this->get_category_field_by_id($value2['cat_field_id']);
					$data[$key]['product_variant_value2']   = array();
					$data[$key]['product_variant_value2'][] = $cat_field2['cat_field_id'];
					$data[$key]['product_variant_value2'][] = $cat_field2['cat_field_name'];
					$data[$key]['product_variant_value2'][] = $value2['variant_value'];
				} else {
					$data[$key]['product_variant_value2'] = '';
				}

				foreach ($stocks as $stock) {
					if ($stock['product_variant_mapping_id'] == $value['product_variant_mapping_id']) {
						$data[$key]['stock'][] = $stock;
					}
				}

				$image = $this->get_product_variant_image($value['product_variant_mapping_id']);

				if (!empty($image)) {
					$data[$key]['variant_image'] = $image;
				} else {
					$data[$key]['variant_image'] = "";
				}
			}
		}

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}

	public function get_category_field_id($prod_id) {
		$this->db->select('pv.cat_field_id');
		$this->db->from($this->_product_variant.' AS pv');
		$this->db->where('product_id', (int) $prod_id);
		$this->db->group_by('cat_field_id');
		$query    = $this->db->get();
		$variants = $query->result_array();
		$data     = array();

		foreach ($variants as $key => $variant) {
			$data[] = $variant['cat_field_id'];
		}

		if (empty($data)) {
			$data[] = "";
		}

		if (empty($data[1])) {
			$data[1] = "";
		}

		if (!$query) {
			return false;
		} else {
			return $data;
		}
	}
	public function get_product_transaction_history($id) {
		$this->db->select("transaction_time");
		$this->db->where('product_transaction_history_id', $id);
		$result = $this->db->get("product_transaction_history");
		if (!$result) {
			return array();
		}
		if ($result->num_rows() != 1) {
			return array();
		}
		return $result->row_array()['transaction_time'];
	}
	public function get_product_detail_by_id($prod_id) {
		$this->db->select('pd.*');
		$this->db->from($this->_product_detail.' AS pd');
		$this->db->where('prod_id', (int) $prod_id);
		$query  = $this->db->get();
		$fields = $query->result_array();
		$data   = array();

		foreach ($fields as $key => $field) {
			$cat_field            = $this->get_category_field_by_id($field['prod_detail_catfield_id']);
			$field_type           = $cat_field['cat_field_valuetype'];
			$fields[$key]['data'] = $field['prod_detail_catfield_value'.$field_type];
		}

		if (!$query) {
			return false;
		} else {
			return $fields;
		}
	}

	public function get_warehouse($sup_id) {
		$this->db->select('sw.sup_warehouse_id, sw.sup_warehouse_name');
		$this->db->from($this->_supplier_warehouse.' AS sw');
		$this->db->where('sw.sup_id', (int) $sup_id);
		// $this->db->select('sup_warehouse_id');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_stock_quantity($prod_id) {
		$this->db->select('supplier_warehouse, product_warehouse_quantity');
		$this->db->from($this->_product_warehouse_stock);
		$this->db->where('product_id', (int) $prod_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function check_exist_stock($prod_id, $supplier_warehouse, $product_variant_mapping_id) {
		$this->db->from($this->_product_warehouse_stock);
		$this->db->where('product_id', (int) $prod_id);
		$this->db->where('supplier_warehouse', (int) $supplier_warehouse);
		$this->db->where('product_variant_mapping_id', (int) $product_variant_mapping_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->num_rows();
		}
	}

	public function check_exist_variant_image($product_variant_id) {
		$this->db->from($this->_product_variant_image);
		$this->db->where('product_variant_id', (int) $product_variant_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->num_rows();
		}
	}

	public function get_product_type() {
		$this->db->from($this->_product_type);
		$this->db->where('prod_type_status', '1');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_product_variant($prod_id, $variant_value) {
		$this->db->from($this->_product_variant);
		$this->db->where('product_id', (int) $prod_id);
		$this->db->where('variant_value', $variant_value);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function check_variant_exist_stock($prod_id, $variant_mapping_id, $supplier_warehouse) {
		$this->db->from($this->_product_warehouse_stock);
		$this->db->where('product_id', (int) $prod_id);
		$this->db->where('product_variant_mapping_id', (int) $variant_mapping_id);
		$this->db->where('supplier_warehouse', (int) $supplier_warehouse);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->num_rows();
		}
	}

	public function get_product_image($prod_id) {
		$this->db->from($this->_product_image);
		$this->db->where('prod_id', (int) $prod_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_product_variant_image($product_variant_id) {
		$this->db->from($this->_product_variant_image);
		$this->db->where('product_variant_id', (int) $product_variant_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_product_all_variant($product_id) {
		$this->db->select('pv.*');
		$this->db->from($this->_product_variant.' AS pv');
		$this->db->where('pv.product_id', (int) $product_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_variant($product_id, $variant_id) {
		$this->db->select('pvm.product_variant_value2, pv.variant_value');
		$this->db->from($this->_product_variant_mapping.' AS pvm');
		$this->db->join($this->_product_variant.' AS pv', 'pv.product_variant_id = pvm.product_variant_value2', 'left');
		$this->db->where('pvm.product_id', (int) $product_id);
		$this->db->where('pvm.product_variant_value1', (int) $variant_id);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_attribute($value1, $value2) {
		$this->db->select('pvm.product_variant_price, SUM(pws.product_warehouse_quantity) as quantity, pvm.product_variant_mapping_id');
		$this->db->from($this->_product_variant_mapping.' AS pvm');
		$this->db->join($this->_product_warehouse_stock.' AS pws', 'pws.product_variant_mapping_id = pvm.product_variant_mapping_id', 'left');
		$this->db->where('pvm.product_variant_value2', (int) $value2);
		$this->db->where('pvm.product_variant_value1', (int) $value1);
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function get_product_log($product_id) {
		$this->db->from($this->_product_transaction_history.' AS pth');
		$this->db->join($this->_product_transaction_type.' AS ptt', 'pth.transaction_type = ptt.product_transaction_type_id');
		$this->db->join($this->_product.' AS p', 'pth.product_id = p.prod_id');
		$this->db->where('pth.product_id', (int) $product_id);
		$this->db->order_by('transaction_time DESC');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_criteria($cat_id) {
		$this->db->select('c.*');
		$this->db->from($this->_criteria.' AS c');
		$this->db->join($this->_category_criteria_mapping.' AS ccm', 'c.criteria_id = c.criteria_id');
		$this->db->where('c.criteria_status', 1);
		$this->db->where('ccm.category_id', (int) $cat_id);
		$this->db->group_by('c.criteria_id');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_min_price_variant($product_id) {
		$this->db->select('MIN(product_variant_price) AS product_variant_price');
		$this->db->from($this->_product_variant_mapping);
		$this->db->where('product_id', (int) $product_id);
		$query = $this->db->get();

		$data = $query->row_array();

		if (!$query) {
			return false;
		} else {
			return $data['product_variant_price'];
		}
	}

	public function get_max_price_variant($product_id) {
		$this->db->select('MAX(product_variant_price) AS product_variant_price');
		$this->db->from($this->_product_variant_mapping);
		$this->db->where('product_id', (int) $product_id);
		$query = $this->db->get();

		$data = $query->row_array();

		if (!$query) {
			return false;
		} else {
			return $data['product_variant_price'];
		}
	}

	public function get_product_last_sold($product_id) {
		$this->db->select('o.sup_shipping_deliverdate, oi.sup_order_prod_id');
		$this->db->from($this->_supplier_order_item.' AS oi');
		$this->db->join($this->_supplier_order.' AS o', 'o.sup_order_id = oi.sup_order_id', 'left');
		$this->db->where('oi.sup_order_prod_id', (int) $product_id);
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

	public function get_product_check($product_id) {
		$this->db->select('pc.*, c.criteria_name, c.criteria_description');
		$this->db->from($this->_product_check.' AS pc');
		$this->db->join($this->_criteria.' AS c', 'c.criteria_id = pc.criteria_id', 'left');
		$this->db->where('pc.product_id', (int) $product_id);
		$this->db->order_by('pc.product_check_time DESC');
		$query = $this->db->get();

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_product_last_check($product_id) {
		$this->db->select('pc.*, c.criteria_name, c.criteria_description');
		$this->db->from($this->_product_check.' AS pc');
		$this->db->join($this->_criteria.' AS c', 'c.criteria_id = pc.criteria_id', 'left');
		$this->db->where('pc.product_id', (int) $product_id);
		$this->db->order_by('pc.product_check_time DESC');
		$query  = $this->db->get();
		$data   = $query->result_array();
		$result = array();

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				if ($value['product_check_result'] == 0) {
					$result[] = $value;
				}
			}
		} else {
			$result[0] = array();
		}

		if (!$query) {
			return false;
		} else {
			return $result;
		}
	}

	public function get_product_check_pass($product_id) {
		$this->db->where('product_id', (int) $product_id);
		$this->db->where('product_check_result', 1);
		$query = $this->db->get($this->_product_check);

		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function get_criteria_by_id($criteria) {
		$this->db->where('criteria_id', (int) $criteria);
		$query = $this->db->get($this->_criteria);

		if (!$query) {
			return false;
		} else {
			return $query->row_array();
		}
	}

	public function insert_product($data) {
		if ($this->db->insert($this->_product, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function update_product($data, $id) {
		$this->db->where("prod_id", (int) $id);

		if ($this->db->update($this->_product, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function delete($id) {
		$this->db->where("prod_id", $id);

		if ($this->db->delete($this->_product)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_warehouse_stock($data) {
		if ($this->db->insert($this->_product_warehouse_stock, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_warehouse_stock($data, $where) {
		$this->db->where("product_id", (int) $where['product_id']);
		$this->db->where("product_variant_mapping_id", (int) $where['product_variant_mapping_id']);
		$this->db->where("supplier_warehouse", (int) $where['supplier_warehouse']);

		if ($this->db->update($this->_product_warehouse_stock, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert_product_detail($data) {
		if ($this->db->insert($this->_product_detail, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_product_detail($data, $where) {
		$this->db->where("prod_id", (int) $where['prod_id']);
		$this->db->where("prod_detail_catfield_id", (int) $where['prod_detail_catfield_id']);

		if ($this->db->update($this->_product_detail, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert_variant_image($data) {
		if ($this->db->insert($this->_product_variant_image, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_product_log($data) {
		if ($this->db->insert($this->_product_transaction_history, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function update_variant_image($data, $id) {
		$this->db->where("product_variant_id", (int) $id);

		if ($this->db->update($this->_product_variant_image, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_variant_image($id) {
		$this->db->where("product_variant_image_id", $id);

		if ($this->db->delete($this->_product_variant_image)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_image($data) {
		if ($this->db->insert($this->_product_image, $data)) {
			return true;
		} else {

			return false;
		}
	}

	public function delete_image($id) {
		$this->db->where("prod_image_id", $id);

		if ($this->db->delete($this->_product_image)) {
			return true;
		} else {

			return false;
		}
	}

	public function insert_product_variant($data) {
		if ($this->db->insert($this->_product_variant, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function insert_product_variant_mapping($data) {
		if ($this->db->insert($this->_product_variant_mapping, $data)) {
			$last_id = $this->db->insert_id();
			return $last_id;
		} else {

			return false;
		}
	}

	public function update_product_variant_mapping($data, $id) {
		$this->db->where("product_variant_mapping_id", (int) $id);

		if ($this->db->update($this->_product_variant_mapping, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function update_product_check($data, $where) {
		$this->db->where("product_id", (int) $where['prod_id']);
		$this->db->where("criteria_id", (int) $where['criteria_id']);

		if ($this->db->update($this->_product_check, $data)) {
			return true;
		} else {
			return false;
		}
	}
}
?>