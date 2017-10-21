<h3>Paypal</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[paypal][api_username]">API Username: </label>
	<div class="col-sm-10">
		<input type="text" name="config[paypal][api_username]" value="<?php echo !empty($detail['paypal']->api_username) ? $detail['paypal']->api_username : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[paypal][api_password]">API Password: </label>
	<div class="col-sm-10">
		<input type="text" name="config[paypal][api_password]" value="<?php echo !empty($detail['paypal']->api_password) ? $detail['paypal']->api_password : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[paypal][api_signature]">API Signature: </label>
	<div class="col-sm-10">
		<input type="text" name="config[paypal][api_signature]" value="<?php echo !empty($detail['paypal']->api_signature) ? $detail['paypal']->api_signature : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[paypal][test_mode]">Test mode: </label>
	<div class="col-sm-10">
		<label>
		<input type="radio" name="config[paypal][test_mode]" value="0" <?php (!empty($detail['paypal']->test_mode) && $detail['paypal']->test_mode == 0) ? 'checked="checked"' : ''; ?>/>
		<span>No</span>
		</label>
		<label>
		<input type="radio" name="config[paypal][test_mode]" value="1" <?php echo (!empty($detail['paypal']->test_mode) && $detail['paypal']->test_mode == 1) ? 'checked="checked"' : ''; ?>/>
		<span>Yes</span>
		</label>
	</div>
</div>
<h3>Stripe</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[stripe][secret_key]">Secret Key: </label>
	<div class="col-sm-10">
		<input type="text" name="config[stripe][secret_key]" value="<?php echo !empty($detail['stripe']->secret_key) ? $detail['stripe']->secret_key : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[stripe][publishable_key]">Publishable Key: </label>
	<div class="col-sm-10">
		<input type="text" name="config[stripe][publishable_key]" value="<?php echo !empty($detail['stripe']->publishable_key) ? $detail['stripe']->publishable_key : ''; ?>"/>
	</div>
</div>
<h3>Ngan Luong</h3>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[nganluong][url]">URL: </label>
	<div class="col-sm-10">
		<input type="text" name="config[nganluong][url]" value="<?php echo !empty($detail['nganluong']->url) ? $detail['nganluong']->url : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[nganluong][email]">Email: </label>
	<div class="col-sm-10">
		<input type="text" name="config[nganluong][email]" value="<?php echo !empty($detail['nganluong']->email) ? $detail['nganluong']->email : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[nganluong][merchant_id]">Merchant ID: </label>
	<div class="col-sm-10">
		<input type="text" name="config[nganluong][merchant_id]" value="<?php echo !empty($detail['nganluong']->merchant_id) ? $detail['nganluong']->merchant_id : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[nganluong][merchant_pass]">Merchant Password: </label>
	<div class="col-sm-10">
		<input type="text" name="config[nganluong][merchant_pass]" value="<?php echo !empty($detail['nganluong']->merchant_pass) ? $detail['nganluong']->merchant_pass : ''; ?>"/>
	</div>
</div>
