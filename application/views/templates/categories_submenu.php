<ul class='nav navbar-nav menu'>
	<?php foreach ($parent_categories as $i => $parent_category) : ?>
		<li>
			<a href="<?php echo $parent_category['par_cat_id'] ?>"><?php echo $parent_category['par_cat_name'] ?></a>
			<ul>
				<?php foreach ($categories as $j => $category) : ?>
					<?php if ($parent_category['par_cat_id'] == $category['par_cat_id'] && $category['count'] > 0) : ?>
						<li>
						<a href="<?php echo base_url() . 'category/' . $category['cat_id'] ?>"><?php echo $category['cat_name'] ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>