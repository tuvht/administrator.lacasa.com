<div class="form-group">
	<label class="col-sm-2 control-label" for="company">Company: </label>
	<div class="col-sm-10 ">
    	<input id="input_basic_company" type="text" name="company" value="<?php echo !empty($detail['sup_name'])?$detail['sup_name']:'';?>"/>
    	<div><span id="val_msg_input_basic_company" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="tax">Tax ID: </label>
	<div class="col-sm-10">
        <input id="input_basic_taxid" type="text" name="tax" value=""/>
        <div><span id="val_msg_input_basic_taxid" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="address">Address: </label>
	<div class="col-sm-10">
    	<input id="input_basic_address" type="text" name="address" value=""/>
		<div><span id="val_msg_input_basic_address" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="phone">Phone: </label>
	<div class="col-sm-10">
    	<input id="input_basic_phone" type="text" name="phone" value="<?php echo !empty($detail['sup_telephone'])?$detail['sup_telephone']:'';?>"/>
    	<div><span id="val_msg_input_basic_phone" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="login_email">Login email: </label>
	<div class="col-sm-10">
        <input id="email" type="text" name="email" value="<?php echo !empty($detail['sup_email'])?$detail['sup_email']:'';?>"/>
        <div><span id="val_msg_input_basic_email" class="form_field_validation"></span></div>
	</div>
</div>
<?php if (empty($sup_id)):?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="password">Password: </label>
	<div class="col-sm-10">.
    	<input id="input_basic_password" type="password" name="password" value=""/>
    	<div><span id="val_msg_input_basic_password" class="form_field_validation"></span></div>
	</div>
</div>
<?php endif;?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="joindate">Join date: </label>
	<div class="col-sm-10 controls-txt">
<?php if (empty($sup_id)):?>
			<?php echo dateFormat(date('Y-m-d'));?>
		<?php  else :?>
			<?php echo !empty($detail['sup_joindate'])?dateFormat($detail['sup_joindate']):'';?>
		<?php endif;?>
</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="logo">Logo: </label>
	<div class="col-sm-10">
		<input type="file" name="logo" value=""/>
	</div>
</div>
