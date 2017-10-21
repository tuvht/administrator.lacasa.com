<?php if ( isset($related) ): ?>
<div class="slide-wrapper relatedproducts">
	<ul class="slide-list">
		<?php foreach ($related as $key => $relate) : ?>
		<li class="slide-item">
			<div class="item-wrapper">
				<?php 
				if (!empty($relate['image'])): 
					$image = base_url() . $relate['image']['prod_image_path'] . $relate['image']['prod_image_name'] . '.' . $relate['image']['prod_image_extension'];
				else:
					$image = base_url() . '/application/views/images/products/product_01.jpg';
				endif;
				?>
				<div class="product-img" style="background-image: url(<?php echo $image; ?>)">
					<img src="<?php echo $image; ?>" alt="products"/>
					<div class="addcartbox">
						<div class="addcart-wrapper"><a href="<?php echo base_url() . 'product/' . $relate['prod_id']; ?>">View Detail</a></div>
					</div>
				</div>
				<div class="product-info">
					<span class="product-name"><?php echo $relate['prod_name']; ?></span>
					<span class="product-price"><?php echo price($relate['prod_price']); ?></span>
				</div>
				<div class="product-label">
					<?php if ($relate['prod_type'] == 2): ?>
					<span class="best">BEST</span>
				<?php elseif ($relate['prod_type'] == 3): ?>
					<span class="hot">HOT</span>
				<?php elseif ($relate['prod_type'] == 4): ?>
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
	jQuery('.slide-wrapper.relatedproducts').html(function(){
		makeswiper(jQuery(this).find('.slide-list'), jQuery(this).find('.slide-list').find('.slide-item'));
	});
	reponSwiper('.relatedproducts .slide-list','.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-next', '.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-prev');
</script>
<?php endif ?>