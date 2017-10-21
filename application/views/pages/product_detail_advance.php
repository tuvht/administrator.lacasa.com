<div id="advance-info">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="prod_supplierinternalid">Supplier SKU: </label>
		<div class="col-sm-10 controls-txt">
			<?php echo !empty($product_detail) ? $product_detail['prod_supplierinternalid'] : ""; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="prod_price">Price: </label>
		<div class="col-sm-10 controls-txt">
			<?php echo !empty($product_detail) ? $product_detail['prod_price'] : ""; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="prod_stock">Stock: </label>
		<div class="col-sm-10 controls-txt">
			<?php $stock_total = array(); ?>
			<?php foreach ($quantity as $stock): ?>
					<?php $stock_total[] = $stock['product_warehouse_quantity']; ?>
			<?php endforeach; ?>
			<?php echo array_sum($stock_total); ?>
		</div>
	</div>
</div>
<div id="variant-info">
	<?php $this->load->view('pages/product_detail_variant') ?>
</div>
