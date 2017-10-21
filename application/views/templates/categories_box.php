<div class="category-box multiple">
	<?php foreach ($categories_limit as $key => $category): ?>
	<?php 
		$count = count($categories_limit);

		if ($count == 3 || $key == 0):
			$col = 'col-md-6 col-sm-6';
		else:
			$col = 'col-md-3 col-sm-3';
		endif;
	?>
	<?php if ($count > 0) : ?>
	<div class="categories-item <?php echo $col ?>">
		<div class="category-wrapper">
			<div class="category-button">
				<a href="<?php echo base_url() . 'category' . '/' . $category['cat_id']; ?>" class="btn btn-default"><?php echo $category['cat_name'] ?></a>
			</div>
			<div class="category-bg" style="background: url(<?php echo base_url() . $category['cat_imageurl'] ?>) no-repeat center center; background-size: cover;">
				<img style="opacity: 0; visibility: hidden;" src="<?php echo base_url() . $category['cat_imageurl'] ?>" alt="<?php echo $category['cat_name'] ?>">
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php endforeach; ?>
</div>