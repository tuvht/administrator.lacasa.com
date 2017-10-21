<div class="form-group">
	<label class="col-sm-2 control-label" for="config[logo]">Logo: </label>
	<div class="col-sm-10">
		<input type="file" name="config_logo" value=""/>
		<?php if (!empty($detail['logo'])) : ?>
			<img src="<?php echo base_url() . 'images/banners/' . $detail['logo']; ?>">
			<input type="hidden" name="config[logo]" value="<?php echo $detail['logo'] ? $detail['logo'] : ''; ?>">
		<?php endif; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[favicon]">Favicon: </label>
	<div class="col-sm-10">
		<input type="file" name="config_favicon" value=""/>
		<?php if (!empty($detail['favicon'])) : ?>
			<img src="<?php echo base_url() . 'images/banners/' . $detail['favicon']; ?>">
			<input type="hidden" name="config[favicon]" value="<?php echo $detail['favicon'] ? $detail['favicon'] : ''; ?>">
		<?php endif; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[title]">Title: </label>
	<div class="col-sm-10">
		<input type="text" name="config[title]" value="<?php echo !empty($detail['title']) ? $detail['title'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[email]">Contact email: </label>
	<div class="col-sm-10">
		<input type="text" name="config[email]" value="<?php echo !empty($detail['email']) ? $detail['email'] : ''; ?>"/>
	</div>
</div>
<div><a href="#">Change administrator password</a></div>
