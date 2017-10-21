<?php
	$cart = $this->cart->contents();
?>
<a class="cartlink" href="#MYBAG">MY BAG <span><?php echo $this->cart->total_items();?></span></a>
<div id="MYBAG" class="carthover">
	<div class="cartinner">
		<h3 class="header">Your bag</h3>
		<?php if (count($cart) > 0): ?>
			<ul>
			<?php foreach ($cart as $key => $product) {?>
				<li>
					<span><?php echo $product['name'];?></span>
					<span><?php echo price($product['subtotal']);?></span>
				</li>
			<?php }//endforeach?>
			<li class="totalprice">
				<span>Total</span>
				<span><?php echo price($this->cart->total());?></span>
			</li>
			</ul>
			<a href="<?php echo base_url();?>cart" class="btn btn-primary">Check Out</a>
		<?php else: ?>
			<p>Your cart is empty</p>
		<?php endif ?>
	</div>
</div>