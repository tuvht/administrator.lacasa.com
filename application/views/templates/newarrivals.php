<div class="slide-wrapper newarrials">
	<ul class="slide-list">
		<?php foreach ($new_arrivals as $key => $new_arrival) : ?>
		<li class="slide-item">
			<div class="item-wrapper">
				<?php 
				if (!empty($new_arrival['image'])): 
					$image = base_url() . $new_arrival['image']['prod_image_path'] . $new_arrival['image']['prod_image_encode'] . '.' . $new_arrival['image']['prod_image_extension'];
				else:
					$image = 'application/views/images/products/product_01.jpg';
				endif;
				?>
				<div class="product-img" style="background-image: url(<?php echo $image; ?>)">
					<img src="<?php echo $image; ?>" alt="products"/>
					<div class="addcartbox">
						<div class="addcart-wrapper"><a href="<?php echo base_url() . 'product/' . $new_arrival['prod_id']; ?>">View Detail</a></div>
					</div>
				</div>
				<div class="product-info">
					<span class="product-name"><?php echo $new_arrival['prod_name']; ?></span>
					<span class="product-price"><?php echo price($new_arrival['prod_price']); ?></span>
				</div>
				<div class="product-label">
					<?php if ($new_arrival['prod_type'] == 2): ?>
					<span class="best">BEST</span>
				<?php elseif ($new_arrival['prod_type'] == 3): ?>
					<span class="hot">HOT</span>
				<?php elseif ($new_arrival['prod_type'] == 4): ?>
					<span class="new">NEW</span>
				<?php else: ?>
					<span class="sale">SALE</span>
				<?php endif; ?>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<script type="text/javascript">
	jQuery('.slide-wrapper.newarrials').html(function(){
		makeswiper(jQuery(this).find('.slide-list'), jQuery(this).find('.slide-list').find('.slide-item'));
	});
	reponSwiper('.newarrials .slide-list','.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-next', '.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-prev');
</script>