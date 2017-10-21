<?php if (($cat1 == $cat2 && $cat1 != "") || ($cat1 != "" && $cat2 == "")) : ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="variant-catfield-'<?php echo $cat1; ?>'_'<?php echo $index; ?>'"><?php echo $field1['cat_field_name'] ?><span class="star"> *</span></label>
		<div class="col-sm-10">
			<input name="form[variant][<?php echo $index; ?>][category_variant][<?php echo $cat1; ?>]" class="form-control" type="text" id="variant-catfield-'<?php echo $cat1; ?>'_'<?php echo $index; ?>'" value="" required>
		</div>
	</div>
<?php elseif ($cat1 == "" && $cat2 != "") : ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="variant-catfield-'<?php echo $cat2; ?>'_'<?php echo $index; ?>'"><?php echo $field2['cat_field_name'] ?><span class="star"> *</span></label>
		<div class="col-sm-10">
			<input name="form[variant][<?php echo $index; ?>][category_variant][<?php echo $cat2; ?>]" class="form-control" type="text" id="variant-catfield-'<?php echo $cat2; ?>'_'<?php echo $index; ?>'" value="" required>
		</div>
	</div>
<?php else: ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="variant-catfield-'<?php echo $cat1; ?>'_'<?php echo $index; ?>'"><?php echo $field1['cat_field_name'] ?><span class="star"> *</span></label>
		<div class="col-sm-10">
			<input name="form[variant][<?php echo $index; ?>][category_variant][<?php echo $cat1; ?>]" class="form-control" type="text" id="variant-catfield-'<?php echo $cat1; ?>'_'<?php echo $index; ?>'" value="" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="variant-catfield-'<?php echo $cat2; ?>'_'<?php echo $index; ?>'"><?php echo $field2['cat_field_name'] ?><span class="star"> *</span></label>
		<div class="col-sm-10">
			<input name="form[variant][<?php echo $index; ?>][category_variant][<?php echo $cat2; ?>]" class="form-control" type="text" id="variant-catfield-'<?php echo $cat2; ?>'_'<?php echo $index; ?>'" value="" required>
		</div>
	</div>
<?php endif; ?>