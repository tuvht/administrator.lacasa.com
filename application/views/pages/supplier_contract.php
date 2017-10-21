<div class="form-group">
	<label class="col-sm-2 control-label" for="contract_type">Contract type: </label>
	<div class="col-sm-10">
		<select name="contract_type" id="contract_type">
			<option value="">-- Select type --</option>
<?php foreach ($contracts as $contract):?>
			<option <?php echo (!empty($detail['contract']['sup_contracttype']) && $detail['contract']['sup_contracttype'] == $contract['sup_contracttype_id'])?'selected=""':'';
?> value="<?php echo $contract['sup_contracttype_id']?>"><?php echo ucfirst($contract['sup_contracttype_name']);
?></option>
<?php endforeach;?>
		</select>
		<div><span id="val_msg_input_contract_type" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="contract_number">Contract number: </label>
	<div class="col-sm-10">
			<input id="input_contract_number" type="text" name="contract_number" value="<?php echo !empty($detail['contract']['sup_contract_number'])?$detail['contract']['sup_contract_number']:'';?>"/>
			<div><span id="val_msg_input_contract_number" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="sign_date">Sign date: </label>
	<div class="col-sm-10">
		<div class='input-group date' id='datetimepickerstart'>
            <input id="input_contract_signdate" type="datetime" class="form-control" name="sign_date" value="<?php echo !empty($detail['contract']['sup_contract_signdate'])?$detail['contract']['sup_contract_signdate']:'';?>"/>
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <div><span id="val_msg_input_contract_signdate" class="form_field_validation"></span></div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="end_date">End date: </label>
	<div class="col-sm-10">
		<div class='input-group date' id='datetimepickerend'>
			<input id="input_contract_enddate" type="datetime" class="form-control" name="end_date" value="<?php echo !empty($detail['contract']['sup_contract_enddate'])?$detail['contract']['sup_contract_enddate']:'';?>"/>
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
		<div><span id="val_msg_input_contract_enddate" class="form_field_validation"></span></div>
	</div>
</div>
<?php if (!empty($sup_id)):?>
	<?php if (!empty($detail['contract']) && $detail['contract']['sup_contracttype'] == 1):?>
	<div class="form-group" id="percentage">
		<label class="col-sm-2 control-label" for="end_date">Percentage: </label>
		<div class="col-sm-10">
			<input id="input_contract_percentage" type="text" name="input_contract_percentage" value="<?php echo !empty($detail['contract']['sup_contract_percentage'])?$detail['contract']['sup_contract_percentage']:'';?>"/>
		</div>
	</div>
	<input type="hidden" name="static" value="0"/>
<?php  elseif (!empty($detail['contract']) && $detail['contract']['sup_contracttype'] == 2):?>
	<div class="form-group" id="static">
		<label class="col-sm-2 control-label" for="end_date">Static commision: </label>
		<div class="col-sm-10">
			<input id="input_contract_staticfee" type="text" name="input_contract_staticfee" value="<?php echo !empty($detail['contract']['sup_contract_staticfee'])?$detail['contract']['sup_contract_staticfee']:'';?>"/>
		</div>
	</div>
	<input id="" type="hidden" name="percentage" value="0"/>
<?php endif;?>
<div><span id="val_msg_input_contract_value" class="form_field_validation"></span></div>
<?php endif;?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#datetimepickerstart span').click(function(event) {
			/* Act on the event */

			$('#datetimepickerstart input').focus();
		});
		$('#datetimepickerend span').click(function(event) {
			/* Act on the event */

			$('#datetimepickerend input').focus();
		});
		//$('#datetimepicker1').datetimepicker();
	});
</script>
