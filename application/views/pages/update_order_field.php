<?php if ($status == 3):?>
<span>Confirm order ?</span>
<?php  elseif ($status == 2 || $status == 6):?>
<div class="form-group">
<select class="col-sm-12" name="reason" id="reason" style="margin-bottom: 1%">
<?php foreach ($reasons as $key => $reason):?>
			<?php if ($ontheway == "true"):?>
				<option value="<?php echo $reason['shipping_cancel_reason_id']?>"><?php echo $reason['shipping_cancel_reason_name']?></option>
<?php  else :?>
				<option value="<?php echo $reason['order_cancel_reason_id']?>"><?php echo $reason['order_cancel_reason_name']?></option>
<?php endif;?>
<?php endforeach;?>
</select>
	<span> Cancelled note:</span>
	<textarea class="col-sm-12" rows="10" cols="50" id="cancelled_note" name="cancelled_note"></textarea>
	</div>

<input type ="hidden" value="<?php echo $ontheway; ?>" id="ontheway" name="ontheway">

<!-- $status == 4 || $status == 5 -->
<?php  elseif ($status == 4):?>
<div class="form-group">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Shipping Agent: </label>
				<div class="col-sm-10">
					<select name="shipper_agent" id="shipper">
<?php foreach ($shippers as $key => $shipper):?>
							<option value="<?php echo $shipper['com_shipper_id']?>"><?php echo $shipper['com_shipper_name']?></option>
<?php endforeach;?>
		</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Tracking ID: </label>
				<div class="col-sm-10">
					<input type="text" name="tracking_id" id="tracking_id" />
				</div>
				<div><span id="val_msg_trackingid" class="form_field_validation"></span></div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Ship Date: </label>
				<div class="col-sm-10">
					<div><?=date('d-m-Y')?></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Est Date: </label>
				<div class="col-sm-10">
					<div class='input-group date' id='datetimepickerstart'>
			            <input type="datetime" class="form-control"  name="est_date" id="est_date" value="" style="z-index:99999"/>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		        	</div>
		        	<div><span id="val_msg_estdate" class="form_field_validation"></span></div>
				</div>
			</div>
			<div class="form-group ">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Ship COD:</label>
				<div class="col-sm-10 radioFormClass">
					  <div class="radio"><input type="radio" name="freeship" id="freeship" value=1 class="nofee" checked="checked">Free Ship</div>
					  <div class="radio"><input type="radio" name="freeship" id="freeship" value=0 class="feeship">Has Ship</div>
				</div>
			</div>

			<div class="form-group shipfee hidden">
				<label class="col-sm-2 control-label" for="prod_supplierinternalid">Ship Fee: </label>
				<div class="col-sm-10">
					<input type="text" name="shipfee" id="shipfee" />
				</div>
			</div>
<?php  elseif ($status == 8):?>
Complete
<?php endif;?>
<input type="hidden" name="status" value="<?php echo $status?>" />

<style type="text/css">
	.radioFormClass > div > input{
		width: initial !important;
	}
	.radioFormClass .radio{
		margin-top: 0;
	}
</style>
<script type="text/javascript">
		$('[type="datetime"]').datepicker();
		$('.feeship').click(function(){
			$('.shipfee').removeClass('hidden');
		});

		$('.nofee').click(function(){
			$('.shipfee').addClass('hidden');
		});

</script>
