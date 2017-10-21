<h3>Home page</h3>
<div><a href="#">View banner position</a></div>
<?php for ($i = 1; $i < 14; $i++): ?>
<h4>Banner <?php echo $i ?></h4>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner_<?php echo $i ?>_image">Image: </label>
	<div class="col-sm-10">
		<input type="file" name="banner_<?php echo $i ?>_image" value=""/>
		<?php echo !empty($banner[($i - 1)]['banner_image_source']) ? '<img width="25%" height="25%" src="' . base_url() . 'images/banners/' . $banner[($i - 1)]['banner_image_source'] . '"/>' : ''; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner[<?php echo $i ?>][url]">URL: </label>
	<div class="col-sm-10">
		<input type="text" name="banner[<?php echo $i ?>][url]" value="<?php echo !empty($banner[$i]['banner_image_link']) ? $banner[$i]['banner_image_link'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner[<?php echo $i ?>][tooltip]">Tooltip: </label>
	<div class="col-sm-10">
		<input type="text" name="banner[<?php echo $i ?>][tooltip]" value="<?php echo !empty($banner[$i]['banner_image_alttext']) ? $banner[$i]['banner_image_alttext'] : ''; ?>"/>
	</div>
</div>
<?php endfor; ?>
<h3>Login page</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner_0_image">Image: </label>
	<div class="col-sm-10">
		<input type="file" name="banner_0_image" value=""/>
		<?php $count = count($banner); ?>
		<?php echo !empty($banner[($count - 1)]['banner_image_source']) ? '<img width="25%" height="25%" src="' . base_url() . 'images/banners/' . $banner[($count - 1)]['banner_image_source'] . '"/>' : ''; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner[0][url]">URL: </label>
	<div class="col-sm-10">
		<input type="text" name="banner[0][url]" value="<?php echo !empty($banner[0]['banner_image_link']) ? $banner[0]['banner_image_link'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="banner[0][tooltip]">Tooltip: </label>
	<div class="col-sm-10">
		<input type="text" name="banner[0][tooltip]" value="<?php echo !empty($banner[0]['banner_image_alttext']) ? $banner[0]['banner_image_alttext'] : ''; ?>"/>
	</div>
</div>
