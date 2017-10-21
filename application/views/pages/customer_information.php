<div class="form-group">
	<label class="col-sm-2 control-label"><b>Customer Name:</b></label>
	<label class="control-label"><?php echo $user_info['cus_name'];?></label>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label"><b>Email:</b></label>
	<label class="control-label"><?php echo $user_info['cus_email'];?></label>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label"><b>Password:</b></label>
	<label class="control-label">******</label>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label"><b>Phone:</b></label>
	<label class="control-label"><?php echo $user_info['cus_phone'];?></label>
</div>

<?php if (!empty($fields['value'])):?>
	<?php foreach ($fields as $key => $field):?>
		<div class="form-group">
			<label class="col-sm-2 control-label"><b><?php echo $key?>: </b></label>
			<label class="control-label"><?php echo $field['value'];?></label>
		</div>
<?php endforeach;?>
<?php endif;?>