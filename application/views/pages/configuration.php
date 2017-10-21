<script type="text/javascript">
$(document).ready(function(){
     $(function() {
        $('input[name="add_shipping"]').on('click', function(){
            var name = $('#shipping_name').val();
            var web = $('#shipping_web').val();
            var operation = $('#shipping_operation').val();
            var contact_name = $('#contact_name').val();
            var contact_email = $('#contact_email').val();
            if (name == ''){
                alert('Name is not empty');
            }
            else if (web == ''){
                alert('Web is not empty');
            }
            else if (operation == ''){
                alert('Operation area is not empty');
            }
            else if (contact_name == ''){
                alert('Contact name is not empty');
            }
            else if (contact_email == ''){
                alert('Contact email is not empty');
            }
            else{
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'add-shipping'; ?>",
                    data: {name: name, web: web, operation: operation, contact_name: contact_name, contact_email: contact_email},
                    success: function(msg) {
                        var publish = '<label class="icon-switch">'+'<input type="checkbox" name="" id="no" value="1" shipper-id="">'+'<i class="fa fa-toggle-off" aria-hidden="true"></i></label>';
                        var row = '<tr>'+'<td>'+name+'</td>'+'<td>'+web+'</<td>'+'<td>'+operation+'</td>'+'<td>'+contact_email+'</td>'+'<td>'+contact_name+'</td>'+'<td>'+publish+'</td>'+'</tr>';
                        $('#contain-shipping').append(row);
                    }
                });
            }
        });

        jQuery('input:checkbox').on('change', function(){
            var shipper_id = jQuery(this).attr('shipper-id');
            var value = jQuery(this).is(':checked') ? 1 : 0;
            var inputobj = jQuery(this);

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'update-shipping'; ?>",
                data: {shipper_id: shipper_id, status: value},
                success: function(msg) {
                    if ( inputobj.is(':checked') ) {
                        inputobj.prev('.fa').removeClass('fa-toggle-on').addClass('fa-toggle-off');
                    }else{
                        inputobj.prev('.fa').removeClass('fa-toggle-off').addClass('fa-toggle-on');
                    }
                }
            });
        });
	});
});
</script>
<?php
if(!empty($msg))
{
      echo '<div class="alert alert-' . $msg['type'] . '" role="alert">' . $msg['text'] . '</div>';
}
else
{
	if (!empty(validation_errors()))
	{
		echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
	}

    if (!empty($error))
      		echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}
?>
<form class="form-horizontal newproduct" action="<?php echo base_url() . 'configuration'; ?>" method="post" enctype="multipart/form-data">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" />
	</div>
	<div id="main-info" class="col-lg-12">
		<ul class="nav nav-pills nav-justified" role="tablist">
			<li role="presentation" class="active">
				<a href="#basic" aria-controls="basic" role="tab" data-toggle="tab" id="basic-tab">Basic info</a>
			</li>
			<li role="presentation">
				<a href="#advance" aria-controls="advance" role="tab" data-toggle="tab" id="advance-tab">Advance</a>
			</li>
			<li role="presentation">
				<a href="#payment" aria-controls="payment" role="tab" data-toggle="tab" id="payment-tab">Payment</a>
			</li>
			<li role="presentation">
				<a href="#banner" aria-controls="banner" role="tab" data-toggle="tab" id="banner-tab">Banner</a>
			</li>
			<li role="presentation">
				<a href="#shipping" aria-controls="shipping" role="tab" data-toggle="tab" id="shipping-tab">Shipping</a>
			</li>
            <li role="presentation">
                <a href="#tax-fee" aria-controls="tax-fee" role="tab" data-toggle="tab" id="tax-fee-tab">Tax and Fee</a>
            </li>
            <li role="presentation">
                <a href="#content" aria-controls="content" role="tab" data-toggle="tab" id="content-tab">Content</a>
            </li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="basic">
				<?php $this->load->view('pages/config_basic'); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="advance">
				<?php $this->load->view('pages/config_advance'); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="payment">
				<?php $this->load->view('pages/config_payment'); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="banner">
				<?php $this->load->view('pages/config_banner'); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="shipping">
				<?php $this->load->view('pages/config_shipping'); ?>
			</div>
            <div role="tabpanel" class="tab-pane" id="tax-fee">
                <?php $this->load->view('pages/config_taxfee'); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="content">
                <?php $this->load->view('pages/config_content'); ?>
            </div>
		</div>
	</div>
</form>
