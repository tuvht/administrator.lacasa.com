<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	$('select[name="master"]').on('change', function(){
     		var mas_cat_id = $(this).val();
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'get-category';?>",
	            data: {mas_cat_id: mas_cat_id},
	            success: function(data){
	            	$('select[name="category"]').html('');
	            	$('select[name="category"]').html(data);
	            }
	        });
     	});
	});
	$('.savebtn').click(function(){

<?php if ($id):?>
$('.savebtn').addClass('disabled');
<?php endif;?>
	if ( form_validate() == false)
		 $('.savebtn').removeClass('disabled');
});



});

function form_validate()
	{
	    var input_master_validation=field_validate ('select','master','','','val_msg_master','true','Please select master','','');
	    var input_category_validation=field_validate ('select','category','','','val_msg_category','true','Please select category','','');
	    var input_name_validation=field_validate ('text','name',50, 1,'val_msg_name','true','Please insert name','','');


	    if (input_master_validation&&input_category_validation&&input_name_validation)
	    {
	      return true;
	    }

	    return false;
	}
</script>
<form class="form-horizontal newproduct" action="<?php echo base_url().'sub-category-detail/'.$id;?>" method="post" enctype="multipart/form-data">
	<div class="button-list">
		<input class="btn btn-success savebtn" id="save-button" type="submit" name="save" value="Save" onclick="return form_validate()" />
		<a class="btn btn-danger" href="<?php echo base_url().'sub-category';?>">Cancel</a>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="master">Master: </label>
		<div class="col-sm-10">
			<select name="master" id ="master" class="pull-left">
				<option value="">-- Select master --</option>
<?php foreach ($master as $key => $mas):?>
					<option value="<?php echo $mas['mas_cat_id'];?>" <?php echo (!empty($id) && $detail['mas_cat_id'] == $mas['mas_cat_id'])?'selected="selected"':'';
?>>
<?php echo $mas['mas_cat_name'];?>
</option>
<?php endforeach;?>
</select>
		<div><span id="val_msg_master" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="master">Category: </label>
		<div class="col-sm-10">
			<select name="category" id="category" class="pull-left">
				<option value="">-- Select category --</option>
<?php foreach ($categories as $key => $par):?>
					<option value="<?php echo $par['par_cat_id'];?>" <?php echo (!empty($id) && $detail['par_cat_id'] == $par['par_cat_id'])?'selected="selected"':'';
?>>
<?php echo $par['par_cat_name'];?>
</option>
<?php endforeach;?>
			</select>
			<div><span id="val_msg_category" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="name">Name: </label>
		<div class="col-sm-10">
			<input type="text" name="name" class="pull-left" id="name" value="<?php echo !empty($id)?$detail['cat_name']:''?>" />
			<div><span id="val_msg_name" class="form_field_validation"></span></div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="image">Image: </label>
		<div class="col-sm-10">
<?php if (!empty($id) && !empty($detail['cat_imageurl'])):?>
				<img src="<?php echo base_url().$detail['cat_imageurl'];?>" width="200" heigh="200">
<?php endif;?>
<input type="file" name="image" />
		</div>
	</div>
	<hr>
	<div class="col-sm-3 text-left">
		<h3>Attributes</h3>
<?php foreach ($attributes as $key => $attribute):?>
			<label>
				<input type="checkbox" name="attribute[]" value="<?php echo $attribute['cat_field_id']?>"
<?php foreach ($detail['attributes'] as $k => $value):?>
					<?php if ($value == $attribute['cat_field_id']):?>
checked="checked"
<?php endif;?>
				<?php endforeach;?>
/>
<?php echo $attribute['cat_field_name'];?>
</label><br>
<?php endforeach;?>
</div>
	<div class="col-sm-3 text-left">
		<h3>Criteria</h3>
<?php foreach ($criterias as $key => $criteria):?>
			<label>
				<input type="checkbox" name="criteria[]" value="<?php echo $criteria['criteria_id']?>"
<?php foreach ($detail['criterias'] as $k => $value):?>
					<?php if ($value == $criteria['criteria_id']):?>
checked="checked"
<?php endif;?>
				<?php endforeach;?>
/>
<?php echo $criteria['criteria_name'];?>
</label><br>
<?php endforeach;?>
</div>
</form>
<script type="text/javascript">

</script>