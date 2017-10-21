<form class="form-horizontal newproduct" action="<?php echo base_url().'attribute-detail/'.$id;?>" method="post">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" onclick="return form_validate()" />
		<a class="btn btn-danger" href="<?php echo base_url().'attribute';?>">Cancel</a>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" id ="name" for="name">Attribute: </label>
		<div class="col-sm-10">
			<input type="text" class="pull-left" name="name" id="name" value="<?php echo !empty($detail)?$detail['cat_field_name']:''?>" />
			<div><span id="val_msg_name" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="description">Description: </label>
		<div class="col-sm-10">
			<textarea name="description" class="pull-left"><?php echo !empty($detail)?$detail['cat_field_description']:''?></textarea>
		</div>
	</div>
</form>
<script type="text/javascript">
function form_validate()
{
    var input_name_validation=field_validate ('text','name',50, 1,'val_msg_name','true','Please insert name','','');

	if (input_name_validation)
    {
      return true;
    }
    return false;
}
</script>