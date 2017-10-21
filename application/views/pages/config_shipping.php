<div class="form-group">
	<label class="col-sm-2 control-label" for="shipping[name]">Name: </label>
	<div class="col-sm-10">
		<input type="text" name="shipping[name]" value="" id="shipping_name"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="shipping[web]">Web: </label>
	<div class="col-sm-10">
		<input type="text" name="shipping[web]" value="" id="shipping_web"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="shipping[contact_email]">Contact email: </label>
	<div class="col-sm-10">
		<input type="text" name="shipping[contact_email]" value="" id="contact_email"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="shipping[contact_name]">Contact name: </label>
	<div class="col-sm-10">
		<input type="text" name="shipping[contact_name]" value="" id="contact_name"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="shipping[operation_area]">Operation area: </label>
	<div class="col-sm-10">
		<textarea name="shipping[operation_area]" cols="20" rows="5" id="shipping_operation"></textarea>
	</div>
</div>
<input class="btn btn-success" type="button" name="add_shipping" value="Add">
<table class="table">
	<thead>
		<tr>
			<th width="20%">Name</th>
			<th width="20%">Web portal</th>
			<th width="20%">Operation area</th>
			<th width="20%">Contact email</th>
			<th width="15%">Contact person</th>
			<th width="5%">Action</th>
		</tr>
	</thead>
	<tbody id="contain-shipping">
		<?php foreach ($shipping as $key => $ship) : ?>
			<tr>
				<td><?php echo $ship['com_shipper_name'] ?></td>
				<td><?php echo $ship['com_shipper_website'] ?></td>
				<td><?php echo $ship['com_shipper_address'] ?></td>
				<td>#</td>
				<td>#</td>
				<td>
                    <?php
                        $fastt = ($ship['com_shipper_status'] == 1) ? 'fa-toggle-off' : 'fa-toggle-on';
                    ?>
                    <label class="icon-switch">
                        <i class="fa <?php echo $fastt;?>" aria-hidden="true"></i>
                        <input <?php echo ($ship['com_shipper_status'] == 1) ? 'checked="checked"' : '' ?> type="checkbox" name="choose-<?php echo $ship['com_shipper_id'] ?>" id="<?php echo $ship['com_shipper_id'] ?>-no" value="1" shipper-id="<?php echo $ship['com_shipper_id'] ?>">
                    </label>
                </td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>