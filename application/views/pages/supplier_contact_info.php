<div class="form-group">
	<label class="col-sm-2 control-label" for="contact_name">Contact name: </label>
	<div class="col-sm-10">
        	<input id="input_contact_name" type="text" name="contact_name" value="<?php echo !empty($detail['sup_contact_name'])?$detail['sup_contact_name']:'';?>"/>    
		<div><span id="val_msg_input_contact_name" class="form_field_validation"></span></div>			
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="contact_title">Contact title: </label>
	<div class="col-sm-10">
        	<input id="input_contact_title" type="text" name="contact_title" value="<?php echo !empty($detail['sup_contact_title'])?$detail['sup_contact_title']:'';?>"/>
		<div><span id="val_msg_input_contact_title" class="form_field_validation"></span></div>	
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="contact_cellphone">Contact cellphone: </label>
	<div class="col-sm-10">
        	<input id="input_contact_cellphone" type="text" name="contact_cellphone" value="<?php echo !empty($detail['sup_contact_cellphone'])?$detail['sup_contact_cellphone']:'';?>"/>
    		<div><span id="val_msg_input_contact_cellphone" class="form_field_validation"></span></div>	
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="contact_email">Contact email: </label>
	<div class="col-sm-10">
        	<input id="input_contact_email" type="text" name="contact_email" value="<?php echo !empty($detail['sup_contact_email'])?$detail['sup_contact_email']:'';?>"/>
    		<div><span id="val_msg_input_contact_email" class="form_field_validation"></span></div>	
	</div>
</div>
