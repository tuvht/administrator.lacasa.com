<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	var base_url = '<?php echo base_url();?>';
     	$('select[name="promotion_type"]').on('change', function(){
     		var type_id = $(this).val();
     		$('#generate').attr('type', type_id);
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'get-promotion-field';?>",
	            data: {type_id: type_id},
	            success: function(data){
	            	$('select[name="promotion_type_field"]').html('');
	            	$('select[name="promotion_type_field"]').html(data);
	            }
	        });
     	});
     	$('select[name="promotion_type_field"]').on('change', function(){
     		var field_id = $(this).val();
     		$('#generate').attr('field', field_id);
     	});
     	$('#generate').on('click', function(){
     		var type_id = $(this).attr('type');
     		var field_id = $(this).attr('field');
     		if (type_id && field_id)
     		{
     			var url = base_url+'create-promotion/'+type_id+'/'+field_id;
     			window.location.href = url;
     		}
     	});
     	$('#add-more-gift').on('click', function(){
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'get-gift';?>",
	            success: function(data){
	            	$('#wrap-gift').append(data);
	            }
	        });
     	});

     	$('.delete_item').on('click', function(){
     		var promotion_id = $(this).attr('promotion');
     		var product_id = $(this).attr('product');
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'delete-item';?>",
	            data: {promotion_id: promotion_id, product_id: product_id},
	            success: function(data){
	            	$('#item-'+product_id).remove();
	            }
	        });
     	});
	});
});
</script>

<script type="text/javascript">

function form_validate()
{
    var name_validation = field_validate ('text','promotion_name',50, 0,'val_msg_name','true','Please input promotion name','promotion');
    var startdate_validation = field_validate ('text','promotion_startdate',50,0,'val_msg_startdate','true','Please choose a start date','promotion');
    var enddate_validation = field_validate ('text','promotion_enddate',50,0,'val_msg_enddate','true','Please choose an end date','promotion');
    var percentage_validation = field_validate ('number','percentage',99,10,'val_msg_percentage','true','Please input valid percentage from 10 - 99','promotion');
    if (name_validation && startdate_validation && enddate_validation && percentage_validation)
    { 
    	return true;
  	}
   	return false;        
}
</script>

<?php if (empty($type)):?>
  <div class="pull-left" style="margin-bottom: 15px;">
    <button id="generate" class="btn btn-success" type="" field="">Generate</button>
    <a class="btn btn-danger" href="<?php echo base_url().'promotion';?>">Cancel</a>
  </div>
  <div class="clearfix"></div>
	<div id="promotion-generate" class="form-horizontal newproduct">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_type">Promotion type: </label>
			<div class="col-sm-10">
				<select name="promotion_type" class="pull-left" id="promotion-type">
					<option value="">-- Select --</option>
<?php foreach ($types as $key => $type):?>
						<option value="<?php echo $type['promotion_type_id']?>"><?php echo $type['promotion_type_name']?></option>
<?php endforeach;?>
</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_type_field">Promotion type field: </label>
			<div class="col-sm-10">
				<select name="promotion_type_field" class="pull-left" id="promotion-type-field">
					<option value="">-- Select --</option>
				</select>
			</div>
		</div>
	</div>
<?php  else :?>

<form method="post" class="form-horizontal newproduct" action="<?php echo base_url().'create-promotion'?>" name="form" id="form">

	  <div class="pull-left" style="margin-bottom: 15px;">
	    <input type="submit" class="btn btn-success" id="save" name="save" value="Save" onclick="return form_validate();">
	    <a class="btn btn-danger" href="<?php echo base_url().'promotion';?>">Cancel</a>
	  </div>
	  <div class="clearfix"></div>
	<div id="promotion-basic">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_name">Promotion name: </label>
		      <div class="col-sm-10">
		        <input type="text" class="pull-left" name="promotion_name" id="promotion_name" value="<?php echo !empty($detail['promotion_name'])?$detail['promotion_name']:'';?>"/>
		        <div><span id="val_msg_name" class="form_field_validation"></span></div>
		      </div>
		</div>
		
<?php if (!empty($detail['promotion_type'])):?>
			<input type="hidden" name="promotion_type" value="<?php echo !empty($type)?$type:'';?>"/>
			<input type="hidden" name="promotion_type_field" value="<?php echo !empty($field)?$field:'';?>"/>
			<input type="hidden" name="promotion_id" value="<?php echo !empty($promotion_id)?$promotion_id:'';?>"/>
<?php  else :?>
			<input type="hidden" name="promotion_type" value="<?php echo !empty($type)?$type:'';?>"/>
			<input type="hidden" name="promotion_type_field" value="<?php echo !empty($field)?$field:'';?>"/>
			<input type="hidden" name="promotion_id" value="<?php echo !empty($promotion_id)?$promotion_id:'';?>"/>
<?php endif;?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_startdate">Promotion time: </label>
      <div class="col-sm-10 text-left">
        <div class="date-group">
          <div class="">
            From:
          </div>
          <input type="datetime" name="promotion_startdate" id="promotion_startdate" value="<?php echo !empty($detail['promotion_startdate'])?$detail['promotion_startdate']:'';?>"/>
        </div>
        <div><span id="val_msg_startdate" class="form_field_validation"></span></div>

        <div class="date-group">
          <div class="">
            To:
          </div>
          <input type="datetime" name="promotion_enddate" id="promotion_enddate" value="<?php echo !empty($detail['promotion_enddate'])?$detail['promotion_enddate']:'';?>"/>
        </div>
        <div><span id="val_msg_enddate" class="form_field_validation"></span></div>

      </div>
		</div>
<?php if ($type == 1):?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_name">Percentage: </label>
		    <div class="col-sm-10">
		      	<div class="">
		        	<input type="text" class="pull-left" name="percentage" id="percentage" value="<?php echo !empty($detail['promotion_detail_mapping_field_value'])?$detail['promotion_detail_mapping_field_value']:'';?>"/>
	        		<span class="glyphicon form-control-feedback"></span>
	                <span class="help-block"></span>
		        </div>
		        <div><span id="val_msg_percentage" class="form_field_validation"></span></div>
		    </div>
		</div>
<?php  elseif ($type == 2):?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_name">Amount: </label>
      <div class="col-sm-10">
        <input type="text" class="pull-left" name="value" value="<?php echo !empty($detail['promotion_detail_mapping_field_value'])?$detail['promotion_detail_mapping_field_value']:'';?>"/>
      </div>
		</div>
<?php  elseif ($type == 3):?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="promotion_name">Value applicable: </label>
      <div class="col-sm-10">
        <input type="text" class="pull-left" name="value" value="<?php echo !empty($detail['promotion_detail_mapping_field_value'])?$detail['promotion_detail_mapping_field_value']:'';?>"/>
      </div>
		</div>
<?php if (!empty($detail['items'])):?>
			<?php foreach ($detail['items'] as $key => $item):?>
				<div class="form-group" id="item-<?php echo $item['product_id'];?>">
  				<label class="col-sm-2 control-label" for="promotion_name">Choose gift: </label>
  				<div class="col-sm-10">
  					<select name="gift[]"  class="pull-left">
  						<option value="">-- Select --</option>
<?php foreach ($products as $k => $prod):?>
  						<option <?php echo ($prod['prod_id'] == $item['product_id'])?'selected="selected"':'';?> value="<?php echo $prod['prod_id']?>"><?php echo $prod['sup_name'].' - '.$prod['prod_name']?></option>
<?php endforeach;?>
  					</select>
  					<a class="delete_item btn btn-danger" promotion="<?php echo $item['promotion_id']?>" product="<?php echo $item['product_id']?>"><span class="glyphicon glyphicon-remove"></span></a>
  				</div>
				</div>
<?php endforeach;?>
		<?php endif;?>
<div id="wrap-gift"></div>
		<a class="btn btn-success" id="add-more-gift">Add more gift</a>
<?php endif;?>
</div>
<?php endif;?>
</form>
