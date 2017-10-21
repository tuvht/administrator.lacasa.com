<div class="col-md-3 col-sm-3">
	<h3>Pending Orders</h3>
	<ul class="list-group">
	  <li class="list-group-item">New orders: <?php echo $count_new_orders; ?></li>
	  <li class="list-group-item">New orders of month: <?php echo $new_order_month; ?></li>
	</ul>
</div>
<div class="col-md-3 col-sm-3">
	<h3>All Order Items</h3>
	<ul class="list-group">
	  <li class="list-group-item">Today: <?php echo $order_day; ?></li>
	  <li class="list-group-item">This week: <?php echo $order_week; ?></li>
	  <li class="list-group-item">This month: <?php echo $order_month; ?></li>
	  <li class="list-group-item">All: <?php echo $count_orders; ?></li>
	</ul>
</div>