
<?php
$this->load->model('model_product');
$this->load->model('model_order');

$this->load->library(array("session"));
$sup_id           = $this->session->userdata['sup_id'];
$active_product   = $this->model_product->count_rows();
$inactive_product = $this->model_product->count_rows(0, null);
$inview_product   = $this->model_product->count_rows(2, null);
$out_of_stock     = $this->model_product->count_rows_out_stock();
$pending_order    = $this->model_order->count_rows(array(1, 3, 4, 7));

$cancel_order   = $this->model_order->count_rows(array(2, 6));
$complete_order = $this->model_order->count_rows(8);
//$brand = $this->model_brand->count();
?>

<div class="module-menu-orders">
	<div class="panel-group" id="accordion">
		 <div class="panel panel-default default_menu">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#product_menu"><i class="fa fa-product-hunt"></i> Products <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="product_menu" class="panel-collapse collapse in">
		        <ul class="dropdown-menu collapse" id="products">
					<li>
						<a href="<?php echo base_url().'active-product';?>"><i class="fa fa-check" aria-hidden="true"></i> Active products <span class="badge badge-info"><?php echo $active_product;
?></span></a>
					</li>
					<li>
						<a href="<?php echo base_url().'inactive-product';?>"><i class="fa fa-circle-o" aria-hidden="true"></i> Inactive products <span class="badge badge-info"><?php echo $inactive_product;
?></span></a>
					</li>
					<li>
						<a href="<?php echo base_url().'out-of-stock-product';?>"><i class="fa fa-archive" aria-hidden="true"></i> Out of stock products  <span class="badge badge-info"><?php echo $out_of_stock;
?></span></a>
					</li>
					<li>
						<a href="<?php echo base_url().'product-in-view';?>"><i class="fa fa-commenting-o" aria-hidden="true"></i> Products in review <span class="badge badge-info"><?php echo $inview_product;
?></span></a>
					</li>
				</ul>
		 	</div>
		</div>

		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#orders_list"><i class="fa fa-reorder" aria-hidden="true"></i> Orders <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="orders_list" class="panel-collapse collapse">
		        <ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url().'order';?>"><i class="fa fa-cog" aria-hidden="true"></i> Pending orders <span class="badge badge-info"><?php echo $pending_order;
?></span></a>
					</li>
					<li>
						<a href="<?php echo base_url().'order-complete';?>"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Complete orders <span class="badge badge-info"><?php echo $complete_order;
?></span></a>
					</li>
					<li>
						<a href="<?php echo base_url().'order-cancel';?>"><i class="fa fa-ban" aria-hidden="true"></i> Cancelled orders  <span class="badge badge-info"><?php echo $cancel_order;
?></span></a>
					</li>
				</ul>
		 	</div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#promtion_list"><i class="fa fa-tags"></i> Promotion <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="promtion_list" class="panel-collapse collapse">
			       <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'promotion';?>"><i class="fa fa-gift" aria-hidden="true"></i> Promotion list</a>
						</li>
						<li>
							<a href="<?php echo base_url().'promotion-detail';?>"><i class="fa fa-list" aria-hidden="true"></i> Promotion product list</a>
						</li>
						<li>
							<a href="<?php echo base_url().'voucher';?>"><i class="fa fa-tags" aria-hidden="true"></i> Voucher</a>
						</li>
					</ul>
		 	    </div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#supplier_list"><i class="fa fa-building" aria-hidden="true"></i> Supplier <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="supplier_list" class="panel-collapse collapse">
			       <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'active-supplier';?>"><i class="fa fa-building" aria-hidden="true"></i> Active supplier</a>
						</li>
						<li>
							<a href="<?php echo base_url().'inactive-supplier';?>"><i class="fa fa-building-o" aria-hidden="true"></i> Inactive supplier</a>
						</li>
						<li>
							<a href="<?php echo base_url().'supplier-detail';?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create new supplier</a>
						</li>
					</ul>
		 	    </div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#customer_list"><i class="fa fa-users" aria-hidden="true"></i> Customer <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="customer_list" class="panel-collapse collapse">
			       <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'customer';?>"><i class="fa fa-users" aria-hidden="true"></i> Customer</a>
						</li>
					</ul>
		 	    </div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#customer_list"><i class="fa fa-file-text-o" aria-hidden="true"></i> News <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="customer_list" class="panel-collapse collapse">
			       <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'news';?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> News</a>
						</li>
					</ul>
		 	    </div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#category_list"><i class="fa fa-sitemap" aria-hidden="true"></i> Category <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="category_list" class="panel-collapse collapse">
			       <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'category';?>"><i class="fa fa-sitemap" aria-hidden="true"></i> Category</a>
						</li>
						<li>
							<a href="<?php echo base_url().'sub-category';?>"><i class="fa fa-tasks" aria-hidden="true"></i> Sub-category</a>
						</li>
						<li>
							<a href="<?php echo base_url().'attribute';?>"><i class="fa fa-hashtag" aria-hidden="true"></i> Attribute</a>
						</li>
						<li>
							<a href="<?php echo base_url().'criteria';?>"><i class="fa fa-crosshairs" aria-hidden="true"></i> Criteria</a>
						</li>
					</ul>
		 	    </div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#brand"><i class="fa fa-adjust" aria-hidden="true"></i> Brand <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="brand" class="panel-collapse collapse">
		        <ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url().'brand';?>"><i class="fa fa-adjust" aria-hidden="true"></i> Brands </a>
					</li>
				</ul>
		 	</div>
		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#configuration"><i class="fa fa-sitemap" aria-hidden="true"></i> Configuration <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="configuration" class="panel-collapse collapse">
			      	<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'configuration';?>"><i class="fa fa-cog" aria-hidden="true"></i> Configuration</a>
						</li>

						<li>
							<a href="<?php echo base_url().'test-mail-template';?>"><i class="fa fa-cog" aria-hidden="true"></i> Test Mail Template</a>
						</li>
					</ul>
		 	  </div>

		</div>
		<div class="panel panel-default">
		 	 <div class="panel-heading">
		        <h4 class="panel-title">
		          <a class="dropdown-toggle" data-toggle="collapse" data-parent="#accordion" href="#report_list"><i class="fa fa-file-text-o"></i> Report <i class="fa-chevron-down fa" aria-hidden="true"></i></a>

		        </h4>
		      </div>
		      <div id="report_list" class="panel-collapse collapse">
			      <ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'product-report';?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Product report</a>
						</li>
						<li>
							<a href="<?php echo base_url().'sale-report';?>"><i class="fa fa-balance-scale" aria-hidden="true"></i> Sale report</a>
						</li>
						<li>
							<a href="<?php echo base_url().'delivery-report';?>"><i class="fa fa-truck" aria-hidden="true"></i> Delivery report</a>
						</li>
					</ul>
		 	    </div>
		</div>
	</div>

</div>
