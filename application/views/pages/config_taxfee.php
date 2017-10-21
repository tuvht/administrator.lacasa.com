<div class="form-group">
	<label class="col-sm-2 control-label" for="config[gift_wrap]">Gift wrap: </label>
	<div class="col-sm-10">
		<input type="text" name="config[gift_wrap]" value="<?php echo !empty($detail['gift_wrap']) ? $detail['gift_wrap'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[fast_delivery]">Fast delivery: </label>
	<div class="col-sm-10">
		<input type="text" name="config[fast_delivery]" value="<?php echo !empty($detail['fast_delivery']) ? $detail['fast_delivery'] : ''; ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="config[order_tax]">Tax: </label>
	<div class="col-sm-10">
		<input type="text" name="config[order_tax]" value="<?php echo !empty($detail['order_tax']) ? $detail['order_tax'] : ''; ?>"/>
	</div>
</div>