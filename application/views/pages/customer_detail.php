<!-- <?php structure($history)?>
 -->
<form class="form-horizontal"  method="post" enctype="multipart/form-data">
<!-- action="<?php echo base_url().'supplier-detail/'.$sup_id;?>" -->
	<div class="button-list">
		<!-- <input class="btn btn-success" id="save-button" type="submit" name="save" onclick="return form_validate();" value="Save" /> -->
        <a class="btn btn-danger" href="<?php echo base_url().'supplier';?>">Cancel</a>
	</div>
    <div><span id="validation-summary" class="form_field_validation"></span></div>

	<div id="main-info" class="col-lg-12">
		<ul class="nav nav-tabs nav-pills nav-justified" role="tablist">
			<li role="presentation" class="information active">
				<a href="#basic" aria-controls="basic" role="tab" data-toggle="tab" id="basic-tab">Information</a>
			</li>
			<li role="presentation">
				<a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" id="contact-tab">Shipping Address</a>
			</li>
			<li role="presentation">
				<a href="#payment" aria-controls="payment" role="tab" data-toggle="tab" id="payment-tab">Order History</a>
			</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="active tab-pane information" id="basic">
<?php $this->load->view('pages/customer_information');?>
			</div>
			<div role="tabpanel" class="tab-pane" id="contact">		
<?php $this->load->view('pages/customer_shipping_address');?>
			</div>
			<div role="tabpanel" class="tab-pane" id="payment">
				<?php $this->load->view('pages/customer_order_history');?>
			</div>
		</div>
	</div>
</form>