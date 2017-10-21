<?php
	$itemarr = 0;
	for ($i=0; $i < count($items) ; $i++) { 
		if ( $items[$i]['order_id'] == $this->uri->rsegments[2] ) {
			$itemarr = $i;
		}
	}
	$item = $items[$itemarr];
	function UR_exists($url){
	   $headers=get_headers($url);
	   return stripos($headers[0],"200 OK")?true:false;
	}
?>
<div class="checkout-wrapper">
    <ul class="checkout-step">
        <li><span>1</span>Cart Store</li>
        <li><span>2</span>Shipping address</li>
        <li><span>3</span>Review</li>
        <li><span>4</span>Checkout</li>
        <li Class="active green"><span>5</span>Complete</li>
    </ul>
</div>
<div class="row orderinfo">
	<div class="col-md-6 orderdetail">
		<legend>Order Detail</legend>
		<?php
		echo '<div class="form-group"><label>Order ID:</label>' . $item['id'] . '</div>';
		echo '<div class="form-group"><label>Shipping recipient name:</label>' . $item['order_shipping_recipient_name'] . '</div>';
		echo '<div class="form-group"><label>Shipping recipient email:</label>' . $item['cus_email'] . '</div>';
		echo '<div class="form-group"><label>Shipping recipient phone:</label>' . $item['order_shipping_recipient_phone'] . '</div>';
		echo '<div class="form-group"><label>Shipping Address:</label>' . $item['order_shipping_street'] . ' - ' . $item['order_shipping_district'] . ' - ' . $item['order_shipping_city'] . ' - ' . $item['order_shipping_country'] . '</div>';
		echo '<div class="form-group"><label>Order date:</label>' . $item['order_date'] . '</div>';
		echo '<div class="form-group"><label>Order status:</label>' . $item['order_status_name'] . '</div>';
		?>
	</div>

</div>


<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Product image</th>
			<th>Product name</th>
			<th>Quantity</th>
		</tr>
	</thead>
	<tbody>
<?php 
foreach ($items as $key => $product) :
	if ( $product['order_id'] == $this->uri->rsegments[2] ) {
		continue;
	}
	$i = 1;
?>
		<?php foreach ($product['items'] as $key => $value): ?>
		<?php
			if ( !empty($value['image']) && UR_exists( base_url() . $value['image'] ) ) {
				$prod_img = base_url() . $value['image'];
			}else{
				$prod_img = '';
			}
		?>
		<tr>
			<td><?php echo $i ?></td>
			<td class="orderitem-image">
				<?php if ( $prod_img != '' ): ?>	
					<a href="<?php echo base_url() . 'product/' . $value['slug_name'] . '-' . $value['prod_id'];?>">
					<img src="<?php echo $prod_img; ?>" alt="img"/></a>
				<?php endif ?>
			</td>
			<td>
				<a href="<?php echo base_url() . 'product/' . $value['slug_name'] . '-' . $value['prod_id'];?>">
				<?php echo $value['prod_name']; ?></a> <br>
				<?php echo !empty($value['variant_value'][0]) ? $value['variant_value'][0] . ' - ' . $value['variant_value'][1] : ''; ?>
			</td>
			<td>
				<?php echo $value['order_item_quantity']; ?> <br>
			</td>
		</tr>
		<?php
			$i++;
			endforeach;
		?>
		<tr>
			<td colspan="4" align="right">
				<label>Order subtotal: </label>
				<span>
					<?php
						if ( !empty($product['discount']) ) {
							$total = $product['order_payment_amount'] - $product['discount'] + $product['order_extra_fee_amount'];
						}else{
							$total = $product['order_payment_amount'] + $product['order_extra_fee_amount'];
						}
						echo price($total); 
					?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right">
				<label>Tax: </label>
				<span>
					<?php
						echo price($product['order_tax']); 
					?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right">
				<label>Total</label>
				<span>
					<?php
						if ( !empty($product['discount']) ) {
							$total = $product['order_payment_amount'] - $product['discount'] + $product['order_extra_fee_amount'];
						}else{
							$total = $product['order_payment_amount'] + $product['order_extra_fee_amount'];
						}
						echo price($total + $product['order_tax']); 
					?>
				</span>
			</td>
		</tr>
<?php
endforeach;
?>
	</tbody>
</table>