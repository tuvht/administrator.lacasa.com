<div class="slide-wrapper mostbuy">
	<ul class="slide-list">
		<?php foreach ($most_buys as $key => $most_buy) : ?>
		<li class="slide-item">
			<div class="item-wrapper">
				<?php 
				if (!empty($most_buy['image'])): 
					$image = base_url() . $most_buy['image']['prod_image_path'] . $most_buy['image']['prod_image_name'] . '.' . $most_buy['image']['prod_image_extension'];
				else:
					$image = base_url() . '/application/views/images/products/product_01.jpg';
				endif;
				?>
				<div class="product-img" style="background-image: url(<?php echo $image; ?>)">
					<img src="<?php echo $image; ?>" alt="products"/>
					<div class="addcartbox">
						<div class="addcart-wrapper"><a href="<?php echo base_url() . 'product/' . $most_buy['prod_id']; ?>">View Detail</a></div>
					</div>
				</div>
				<div class="product-info">
					<span class="product-name"><?php echo $most_buy['prod_name']; ?></span>
					<span class="product-price"><?php echo price($most_buy['prod_price']); ?></span>
				</div>
				<div class="product-label">
					<?php if ($most_buy['prod_type'] == 2): ?>
					<span class="best">BEST</span>
				<?php elseif ($most_buy['prod_type'] == 3): ?>
					<span class="hot">HOT</span>
				<?php elseif ($most_buy['prod_type'] == 4): ?>
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
	jQuery('.slide-wrapper.mostbuy').html(function(){
		makeswiper(jQuery(this).find('.slide-list'), jQuery(this).find('.slide-list').find('.slide-item'));
	});
	reponSwiper('.mostbuy .slide-list','.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-next', '.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-prev');
</script>