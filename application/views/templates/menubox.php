<ul class='nav navbar-nav menu'>
	<li>
		<a href="#home">Home</a>
	</li>
	<li class="dropdown">
		<a href="#home">Products</a>
		<div class="dropdown-menu">
			<ul class="dropdown">
				<li>
					<a href="<?php echo base_url() . 'active-product' ?>">Active products</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'inactive-product' ?>">Inactive products</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'out-of-stock-product' ?>">Out of stock products</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'new-product' ?>">New products</a>
				</li>
			</ul>
		</div>
	</li>
	<li class="dropdown">
		<a href="#home">Orders</a>
		<div class="dropdown-menu">
			<ul class="dropdown">
				<li>
					<a href="<?php echo base_url() . 'pending-order' ?>">Pending orders</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'complete-order' ?>">Complete orders</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'in-transit-order' ?>">In transit orders</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'cancel-order' ?>">Cancel orders</a>
				</li>
			</ul>
		</div>
	</li>
	<li class="dropdown">
		<a href="#home">Reports</a>
		<div class="dropdown-menu">
			<ul class="dropdown">
				<li>
					<a href="<?php echo base_url() . 'product-report' ?>">Product report</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'sale-report' ?>">Sale report</a>
				</li>
				<li>
					<a href="<?php echo base_url() . 'delivery-report' ?>">Delivery report</a>
				</li>
			</ul>
		</div>
	</li>
</ul>