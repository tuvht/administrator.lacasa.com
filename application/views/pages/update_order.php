
<form action="<?php echo base_url().'order';?>" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">
<?php
if ($order_status == 2 || $order_status == 6) {
	echo "Cancel Order";
} else {
	echo "Update Order Status";
}
?>


		</h4>
	</div>
	<div class="modal-body" id="body-<?php echo $order_id;?>" name="body-<?php echo $order_id;?>"></div>
	<div class="modal-footer">

		<input type="submit" name="update_status" class="btn btn-success" value="Update"  onclick="return form_validate();">
	</div>
	<input type="hidden" name="order_id" value="<?php echo $order_id?>" />

</form>

<script type="text/javascript">

status = '<?php echo $order_status ;?>';

function form_validate()
{
	if (status == 4){
		var tracking_validation = field_validate ('text','tracking_id',50, 0,'val_msg_trackingid','true','Please input tracking id','');
	    var estdate_validation = field_validate ('text','est_date',50, 0,'val_msg_estdate','true','Please input an estimated delivery date','');
	    if (tracking_validation && estdate_validation)
	    {
	      return true;
	    }
	    return false;
	}
    return true;
}
</script>