<div id="warehouse-1">
	<h3>Warehouse 1</h3>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[name]">Warehouse name: </label>
		<div class="col-sm-10">
			<input type="text" value="" id = "input_name"/>
			<div><span id="val_msg_name" class="form_field_validation"></span></div>
		</div>
	</div>

	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[country]">Country: </label>
		<div class="col-sm-10">
			<input type="text" value="" id = "input_country"/>
			<div><span id="val_msg_country" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[city]">City: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_city"/>
			<div><span id="val_msg_city" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[district]">District: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_district"/>
			<div><span id="val_msg_district" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[street]">Street: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_street"/>
			<div><span id="val_msg_street" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[contact_person]">Contact person: </label>
		<div class="col-sm-10">
			<input class="notNull" type="text" value="" id="input_contact_person"/>
			<div><span id="val_msg_contact_person" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[contact_phone]">Contact phone: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_contact_phone"/>
			<div><span id="val_msg_contact_phone" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[contact_email]">Contact email: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_warehouse_contact_email"/>
			<div><span id="val_msg_contact_email" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="warehouse[1][working_hour]">Working hour: </label>
		<div class="col-sm-10">
			<input type="text" value="" id="input_working_hour"/>
			<div><span id="val_msg_working_hour" class="form_field_validation"></span></div>
		</div>
	</div>
	<a id="add" class="btn btn-success" attr_count = "1" attr_supid = "<?php if (!empty($sup_id)) {echo $sup_id;} else {echo '0';}?>" ><span class="glyphicon glyphicon-plus-sign"></span>Add new warehouse</a>
<div><br></div>
<?php if (empty($sup_id)):?>
<table class="table" id="warehouse_table">
          <tr>
          		<th width="15%">Name</th>
				<th width="10%">Country</th>
				<th width="10%">City</th>
				<th width="10%">District</th>
				<th width="10%">Street</th>
				<th width="10%">Contact person</th>
				<th width="10%">Contact phone</th>
				<th width="10%">Contact email</th>
				<th width="10%">Working hour</th>
				<th width="10%">Default</th>
				<th width="10%">Remove</th>
          </tr>
</table>

<input type="hidden" name="warehouse_default" id="warehouse_default" value = "1">
</div>
<?php  else :?>
<table class="table" id="warehouse_table">
		<thead>
			<tr>
				<th width="20%">Name</th>
				<th width="20%">Address</th>
				<th width="10%">District</th>
				<th width="10%">City</th>
				<th width="10%">Country</th>
				<th width="10%">Phone</th>
				<th width="20%">Default</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($detail['warehouse'] as $key => $warehouse):?>
					<tr id="warehouse-<?php echo $warehouse['sup_warehouse_id']?>">
						<td><?php echo $warehouse['sup_warehouse_name']?></td>
						<td><?php echo $warehouse['sup_warehouse_street']?></td>
						<td><?php echo $warehouse['sup_warehouse_district']?></td>
						<td><?php echo $warehouse['sup_warehouse_city']?></td>
						<td><?php echo $warehouse['sup_warehouse_country']?></td>
						<td><?php echo $warehouse['sup_warehouse_contactphone']?></td>
						<td>
							<label>
								<input type="radio" <?php echo $warehouse['sup_warehouse_default'] == 1?'checked=""':''?> name="default" value="<?php echo $warehouse['sup_warehouse_id']?>"/>
							</label>
							<label class="pull-right" style="margin-left: 10px; vertical-align: middle; ">
								<span data="<?php echo $warehouse['sup_warehouse_id']?>" href="#" class="btn btn-danger remove_field">
									Remove
								</span>
							</label>
						</td>
					</tr>
<?php endforeach;?>
</tbody>
	</table>

<?php endif;?>
<div><span id="val_msg_table" class="form_field_validation"></span></div>


<script type="text/javascript">
function form_validate_add()
{
    var input_name_validation=field_validate ('text','input_name',50, 1,'val_msg_name','true','Please insert warehouse name','','');
    var input_country_validation=field_validate ('text','input_country',50,1,'val_msg_country','true','Please insert country of warehouse','','');
    var input_city_validation=field_validate ('text','input_city',50, 1,'val_msg_city','true','Please insert city of warehouse','','');
    var input_district_validation=field_validate ('text','input_district',50, 1,'val_msg_district','true','Please insert district of warehouse','','');
    var input_street_validation=field_validate ('text','input_street',50, 1,'val_msg_street','true','Please insert street of warehouse','','');
    var input_contactperson_validation=field_validate ('text','input_contact_person',50, 1,'val_msg_contact_person','true','Please insert contact person','','');
    var input_contactphone_validation=field_validate ('text','input_contact_phone',50, 1,'val_msg_contact_phone','true','Please insert contact phone','','');
    var input_contactemail_validation=field_validate ('text','input_warehouse_contact_email',50, 1,'val_msg_contact_email','true','Please insert contact email','','');
    var input_workinghour_validation=field_validate ('text','input_working_hour',50, 1,'val_msg_working_hour','true','Please insert working hour','','');

    if (input_name_validation&&input_country_validation&&input_city_validation&&input_district_validation&&input_street_validation&&input_contactperson_validation&&input_contactphone_validation&&input_contactemail_validation&&input_workinghour_validation)
    {
      return true;
    }
    return false;
}
</script>
