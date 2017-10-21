<?php

class Home extends CI_Controller {
	private $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_product', 'model_order', 'model_config'));
		$this->load->helper(array("url", "my_data"));
		$this->load->library(array('session', 'my_auth'));

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
		} else {
			redirect(base_url().'login');
		}

		$this->data['title']        = "Homepage";
		$this->data['base_url']     = base_url();
		$orders                     = $this->model_order->get_orders(null, null, array(1, 2, 3, 4, 5, 6, 7));
		$count_orders               = count($orders);
		$order_day                  = $this->model_order->get_orders_format('d', array(1, 2, 3, 4, 5, 6, 7), null);
		$order_week                 = $this->model_order->get_orders_format('W', array(1, 2, 3, 4, 5, 6, 7), null);
		$order_month                = $this->model_order->get_orders_format('m', array(1, 2, 3, 4, 5, 6, 7), null);
		$this->data['count_orders'] = $count_orders;
		$this->data['order_day']    = $order_day;
		$this->data['order_week']   = $order_week;
		$this->data['order_month']  = $order_month;

		$new_orders = $this->model_order->get_orders(null, null, array(1, 3, 4, 7));

		$count_new_orders               = count($new_orders);
		$new_order_month                = $this->model_order->get_orders_format('m', array(1, 3, 4, 7), null);
		$this->data['count_new_orders'] = $count_new_orders;
		$this->data['new_order_month']  = $new_order_month;

		$revenue_day                 = $this->model_order->get_order_revenue('d', $sup_id, '');
		$revenue_week                = $this->model_order->get_order_revenue('W', $sup_id, '');
		$revenue_month               = $this->model_order->get_order_revenue('m', $sup_id, '');
		$revenue_year                = $this->model_order->get_order_revenue('Y', $sup_id, '');
		$this->data['revenue_day']   = $revenue_day;
		$this->data['revenue_week']  = $revenue_week;
		$this->data['revenue_month'] = $revenue_month;
		$this->data['revenue_year']  = $revenue_year;
		//structure($this->data);

		$this->load->view('sasscompile/build');
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/homepage', $this->data);
		$this->load->view('templates/footer');
	}
}
?>
