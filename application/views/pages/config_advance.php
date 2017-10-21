<h3>Auto mailing</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[mail_server]">Mail server: </label>
	<div class="col-sm-10">
		<input type="text" name="config[mail_server]" value="<?php echo !empty($detail['mail_server']) ? $detail['mail_server'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[mail_account]">Account: </label>
	<div class="col-sm-10">
		<input type="text" name="config[mail_account]" value="<?php echo !empty($detail['mail_account']) ? $detail['mail_account'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[mail_password]">Password: </label>
	<div class="col-sm-10">
		<input type="password" name="config[mail_password]" value="<?php echo !empty($detail['mail_password']) ? $detail['mail_password'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[mail_fromname]">From name: </label>
	<div class="col-sm-10">
		<input type="text" name="config[mail_fromname]" value="<?php echo !empty($detail['mail_fromname']) ? $detail['mail_fromname'] : ''; ?>"/>
	</div>
</div>
<h3>Product</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[product_image_width]">Image width: </label>
	<div class="col-sm-10">
		<input type="text" name="config[product_image_width]" value="<?php echo !empty($detail['product_image_width']) ? $detail['product_image_width'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[product_image_height]">Image height: </label>
	<div class="col-sm-10">
		<input type="text" name="config[product_image_height]" value="<?php echo !empty($detail['product_image_height']) ? $detail['product_image_height'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[product_image_size_limit]">Size limit: </label>
	<div class="col-sm-10">
		<input type="text" name="config[product_image_size_limit]" value="<?php echo !empty($detail['product_image_size_limit']) ? $detail['product_image_size_limit'] : ''; ?>"/>
	</div>
</div>
<?php 
	$currency = array('VND', 'USD', 'SGD', 'YEN', 'WON');
?>
<!-- <div class="form-group">
	<label class="col-sm-2 control-label" for="config[currency]">Currency: </label>
	<div class="col-sm-10">
		<select name="config[currency]">
			<option value="">-- Select --</option>
			<?php foreach ($currency as $key => $value): ?>
				<option <?php echo (!empty($detail['currency']) && $detail['currency'] == $value) ? 'selected=""' : ''; ?> value="<?php echo $value ?>"><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[no_of_decimal]">No of decimal: </label>
	<div class="col-sm-10">
		<input type="text" name="config[no_of_decimal]" value="<?php echo !empty($detail['no_of_decimal']) ? $detail['no_of_decimal'] : ''; ?>"/>
	</div>
</div> -->
