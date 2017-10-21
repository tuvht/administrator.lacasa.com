<div class="form-group">
	<label class="col-sm-2 control-label" for="prod_name">Product name: </label>
	<div class="col-sm-10 controls-txt">
		<?php echo $product_detail['prod_name']; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="brand">Brand: </label>
	<div class="col-sm-10 controls-txt">
			<?php foreach ($brands as $key => $brand) : ?>
				<?php echo (!empty($product_detail) && $product_detail['prod_brand_id'] == $brand['brand_id']) ? $brand['brand_name'] : ""; ?>
			<?php endforeach; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="brand">Origin: </label>
	<div class="col-sm-10 controls-txt">
			<?php foreach ($countries as $key => $country) : ?>
				<?php echo (!empty($product_detail) && $product_detail['prod_made_country'] == $country['country_id']) ? $country['country_name'] : ""; ?>
			<?php endforeach; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="prod_name">Category: </label>
	<div class="col-sm-10 controls-txt">
		<?php if (!empty($prod_id)) : ?>
			<span><?php echo $product_detail['mas_cat_name'] . ' => ' . $product_detail['cat_name']; ?></span>
		<?php else: ?>
			<span id="category-show"></span>
		<?php endif; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="prod_name">Upload date: </label>
	<div class="col-sm-10 controls-txt">
		<?php echo dateFormat($product_detail['prod_upload_date']); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="prod_name">Description: </label>
	<div class="col-sm-10 controls-txt">
		<?php echo $product_detail['prod_description']; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="type">Type: </label>
	<div class="col-sm-10 controls-txt">
			<?php foreach ($types as $key => $type) : ?>
				<?php echo (!empty($product_detail) && $product_detail['prod_type'] == $type['prod_type_id']) ? $type['prod_type_name'] : ""; ?>
			<?php endforeach; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="type">Last sold: </label>
	<div class="col-sm-10 controls-txt">
		<?php echo !empty($product_detail['last_sold']) ? dateFormat($product_detail['last_sold']['sup_shipping_deliverdate']) : "Still not sell";?>
	</div>
</div>

<?php if ($product_detail['stock_total'] <= 0) : ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="type">Out of stock since: </label>
		<div class="col-sm-10 controls-txt">
			<?php echo date("Y-m-d", strtotime($this->model_product->get_product_transaction_history($product_detail['prod_supplier_id'])))?>
		</div>
	</div>
<?php endif; ?>
