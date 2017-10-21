<ul class="category-box">
	<?php foreach ($master_categories as $k => $master_category) : ?>
		<?php if ($master_category['count'] > 0) : ?>
			<li>
				<div class="category-wrapper">
					<div class="category-button">
						<a href="<?php echo base_url().'category/'.$master_category['mas_cat_id'] ?>" class="btn btn-default"><?php echo $master_category['mas_cat_name'] ?></a>
					</div>
					<div class="category-bg">
						<img src="<?php echo base_url() . $master_category['mas_cat_imageurl']; ?>" alt="<?php echo $master_category['mas_cat_name'] ?>" />
					</div>
				</div>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
<?php $this->load->view('templates/categories_submenu'); ?>