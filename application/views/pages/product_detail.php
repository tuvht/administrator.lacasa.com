<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	var prod_id = '<?php echo $prod_id;?>';
     	var cat_id = '<?php echo $product_detail['prod_cat_id'];?>';
     	$('.save-criteria').on('click', function(){
     		var criteria = $(this).attr('criteria');
     		var result = $('#result_'+criteria).val();
     		var detail = $('#detail_'+criteria).val();
     		$.ajax({
	            type: "POST",
	            url: "<?php echo base_url().'save-criteria';?>",
	            data: {prod_id: prod_id, cat_id: cat_id,criteria: criteria, result: result, detail: detail},
	            success: function(data){
	            	if (result == 1){
	            		$('.pass-'+criteria).hide();
	            		$('#ico-'+criteria).removeClass().addClass('glyphicon glyphicon-ok');
	            	}
	            }
	        });
     	});
	});
});
</script>
<?php
if (!empty($msg)) {
	echo '<div class="alert alert-'.$msg['type'].'" role="alert">'.$msg['text'].'</div>';
} else {
	if (!empty(validation_errors())) {
		echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
	}

	if (!empty($error)) {
		echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
	}
}

?>
<form class="form-horizontal" action="<?php echo base_url().'product-detail/'.$prod_id;?>" method="post" enctype="multipart/form-data">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" />
	</div>
	<div id="main-info" class="col-lg-12">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#basic" aria-controls="basic" role="tab" data-toggle="tab" id="basic-tab">Basic Info</a>
			</li>
			<li role="presentation">
				<a href="#image" aria-controls="image" role="tab" data-toggle="tab" id="image-tab">Images</a>
			</li>
			<li role="presentation">
				<a href="#advance" aria-controls="advance" role="tab" data-toggle="tab" id="advance-tab">Advance Info</a>
			</li>
			<li role="presentation">
				<a href="#review" aria-controls="review" role="tab" data-toggle="tab" id="review-tab">Review</a>
			</li>
			<li role="presentation">
				<a href="#comment" aria-controls="comment" role="tab" data-toggle="tab" id="comment-tab">Comment</a>
			</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="basic">
<?php $this->load->view('pages/product_detail_basic');?>
</div>
			<div role="tabpanel" class="tab-pane" id="image">
<?php $this->load->view('pages/product_detail_image');?>
</div>
			<div role="tabpanel" class="tab-pane" id="advance">
<?php $this->load->view('pages/product_detail_advance');?>
</div>
			<div role="tabpanel" class="tab-pane" id="review">
<?php $this->load->view('pages/product_review');?>
</div>
			<div role="tabpanel" class="tab-pane" id="comment">
<?php $this->load->view('pages/product_detail_comment');?>
</div>
		</div>
	</div>
<?php if (!empty($prod_id)):?>
		<input type="hidden" name="category" value="<?php echo $product_detail['prod_cat_id'];?>"/>
		<input type="hidden" name="product_id" value="<?php echo $prod_id?>"/>
<?php endif;?>
</form>