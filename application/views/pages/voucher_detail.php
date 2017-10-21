<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	var id = '<?php echo $voucher_id; ?>';
     	var val = $('select[name="discount_type"]').val();
     	$('#main_discount_value').hide();
     	$('#main_discount_percentage').hide();
     	if (val == 1){
        	$('#main_discount_value').show();
        	$('#main_discount_percentage').hide();
        }
        else if (val == 2){
        	$('#main_discount_percentage').show();
        	$('#main_discount_value').hide();
        }
        $('select[name="discount_type"]').on('change', function(){
            var value = $(this).val();
            if (value == 1){
            	$('#main_discount_value').show();
            	$('#main_discount_percentage').hide();
            }
            else if (value == 2){
            	$('#main_discount_percentage').show();
            	$('#main_discount_value').hide();
            }
        });
	});
});
</script>
<form class="form-horizontal" action="<?php echo base_url() . 'voucher-detail/' . $voucher_id; ?>" method="post">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" />
		<a class="btn btn-danger" href="<?php echo base_url() . 'voucher'; ?>">Cancel</a>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[voucher_code]">Voucher Code: </label>
		<div class="col-sm-10">
			<input class="form-control" id="voucher_code" type="text" name="data[voucher_code]" value="<?php echo !empty($voucher) ? $voucher['voucher_code'] : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[voucher_description]">Voucher Description: </label>
		<div class="col-sm-10">
			<textarea class="form-control" id="voucher_description" name="data[voucher_description]"><?php echo !empty($voucher) ? $voucher['voucher_description'] : '' ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="discount_type">Discount type: </label>
		<div class="col-sm-10">
			<select class="form-control" name="discount_type" id="discount_type">
				<option value="">Select</option>
				<option <?php echo !empty($voucher['discount_value']) ? 'selected="selected"' : '' ?> value="1">Discount value</option>
				<option <?php echo !empty($voucher['discount_percentage']) ? 'selected="selected"' : '' ?> value="2">Discount percentage</option>
			</select>
		</div>
	</div>
	<div class="form-group" id="main_discount_value">
		<label class="col-sm-2 control-label" for="data[discount_value]">Discount value: </label>
		<div class="col-sm-10">
			<input class="form-control" id="discount_value" type="text" name="data[discount_value]" value="<?php echo !empty($voucher) ? $voucher['discount_value'] : '' ?>" />
		</div>
	</div>
	<div class="form-group" id="main_discount_percentage">
		<label class="col-sm-2 control-label" for="data[discount_percentage]">Discount percentage: </label>
		<div class="col-sm-10">
			<input class="form-control" id="discount_percentage" type="text" name="data[discount_percentage]" value="<?php echo !empty($voucher) ? $voucher['discount_percentage'] : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[created_date]">Create date: </label>
		<div class="col-sm-10">
			<input class="form-control" id="created_date" type="datetime" name="data[created_date]" value="<?php echo !empty($voucher) ? $voucher['created_date'] : date('Y-m-d'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[expiry_date]">Expiry date: </label>
		<div class="col-sm-10">
			<input class="form-control" id="expiry_date" type="datetime" name="data[expiry_date]" value="<?php echo !empty($voucher) ? $voucher['expiry_date'] : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[apply_for_customer_type]">Customer type: </label>
		<div class="col-sm-10">
			<select class="form-control" name="data[apply_for_customer_type]" id="apply_for_customer_type">
				<option value="">Select</option>
				<option <?php echo (!empty($voucher) && $voucher['apply_for_customer_type'] == 1) ? 'selected="selected"' : '' ?> value="1">Walkin</option>
				<option <?php echo (!empty($voucher) && $voucher['apply_for_customer_type'] == 2) ? 'selected="selected"' : '' ?> value="2">Normal member</option>
				<option <?php echo (!empty($voucher) && $voucher['apply_for_customer_type'] == 3) ? 'selected="selected"' : '' ?> value="3">VIP member</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[multiple_use]">Multiple use: </label>
		<div class="col-sm-10 text-left controls-txt">
			<div class="radio">
				<label><input class="form-control" id="multiple_use_no" type="radio" name="data[multiple_use]" value="0" <?php echo (!empty($voucher) && $voucher['multiple_use'] == 0) ? 'checked="checked"' : '' ?> />No</label>
			</div>
			<div class="radio">
				<label><input class="form-control" id="multiple_use_yes" type="radio" name="data[multiple_use]" value="1" <?php echo (!empty($voucher) && $voucher['multiple_use'] == 1) ? 'checked="checked"' : '' ?>/>Yes</label>
			</div>
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[voucher_status]">Status: </label>
		<div class="col-sm-10 text-left controls-txt">
			<div class="radio">
				<label><input class="form-control" id="voucher_status_no" type="radio" name="data[voucher_status]" value="0" checked="checked" <?php echo (!empty($voucher) && $voucher['voucher_status'] == 0) ? 'checked="checked"' : '' ?>/>Unpublished</label>
			</div>
			<div class="radio">
				<label><input class="form-control" id="voucher_status_yes" type="radio" name="data[voucher_status]" value="1" <?php echo (!empty($voucher) && $voucher['voucher_status'] == 1) ? 'checked="checked"' : '' ?>/>Published</label>
			</div>
			
		</div>
	</div>
</form>
