<div class="form-group">
	<label class="col-sm-2 control-label" for="account_number">Account number: </label>
	<div class="col-sm-10">
        	<input id="input_payment_number" type="text" name="account_number" value="<?php echo !empty($detail['sup_bank_accountnum'])?$detail['sup_bank_accountnum']:'';?>"/>
		<div><span id="val_msg_input_payment_number" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="account_name">Account name: </label>
	<div class="col-sm-10">
        	<input id="input_payment_name" type="text" name="account_name" value="<?php echo !empty($detail['sup_bank_accountname'])?$detail['sup_bank_accountname']:'';?>"/>
		<div><span id="val_msg_input_payment_name" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="bank_name">Bank name: </label>
	<div class="col-sm-10">
        	<input id="input_payment_bank" type="text" name="bank_name" value="<?php echo !empty($detail['sup_bank'])?$detail['sup_bank']:'';?>"/>
		<div><span id="val_msg_input_payment_bank" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="bank_branch">Bank branch: </label>
	<div class="col-sm-10">
		<input id="input_payment_branch" type="text" name="bank_branch" value="<?php echo !empty($detail['sup_bank_branch'])?$detail['sup_bank_branch']:'';?>"/>
		<div><span id="val_msg_input_payment_branch" class="form_field_validation"></span></div>
	</div>
</div>
