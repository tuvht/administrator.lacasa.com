<form class="form-horizontal newproduct" action="<?php echo base_url().'category-detail/'.$id;?>" method="post">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" onclick="return form_validate()" />
		<a class="btn btn-danger" href="<?php echo base_url().'category';?>">Cancel</a>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="master">Master: </label>
		<div class="col-sm-10">
			<select name="master" id="master" class="pull-left">
				<option value="">-- Select master --</option>
<?php foreach ($master as $key => $mas):?>
					<option value="<?php echo $mas['mas_cat_id'];?>" <?php echo (!empty($detail) && $detail['master_cate_id'] == $mas['mas_cat_id'])?'selected="selected"':'';
?>>
<?php echo $mas['mas_cat_name'];?>
</option>
<?php endforeach;?>
			</select>
			<div><span id="val_msg_master_select" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="name">Name: </label>
		<div class="col-sm-10">
			<input name="name" id ="name" class="pull-left form-control" value =<?php echo !empty($detail)?$detail['par_cat_name']:''?>>
			<div><span id="val_msg_name" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="description">Description: </label>
		<div class="col-sm-10">
			<textarea name="description" class="pull-left"><?php echo !empty($detail)?$detail['par_cat_description']:''?></textarea>
		</div>
	</div>
</form>
<script type="text/javascript">
function form_validate()
{
    var input_master_validation=field_validate ('select','master','','','val_msg_master_select','true','Please select Master','','validation-summary');
    var input_name_validation=field_validate ('text','name',50, 1,'val_msg_name','true','Please insert name','','validation-summary');


    if (input_master_validation&&input_name_validation)
    {
      return true;
    }
    return false;
}
</script>
