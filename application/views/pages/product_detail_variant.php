<div id="cat-field-info">
	<div class="col-md-12">
		<div class="tab-content" id="variant-tab-content">
			<?php if (!empty($prod_id)) : ?>
				<table class="table">
				<th>Variant</th>
				<?php foreach ($variants as $key => $variant): ?>
				<th><?php echo $variant['product_variant_value1'][1];?></th>
				<?php if (!empty($variant['product_variant_value2'])) : ?>
				<th><?php echo $variant['product_variant_value2'][1]; ?></th>
				<?php endif; ?>
				<?php break; ?>
				<?php endforeach; ?>
				<th>Price</th>
				<th>Stock</th>
				<?php foreach ($variants as $key => $variant): ?>
					<tr>
					<td><?php echo $key + 1; ?></td>
					<td><?php echo $variant['product_variant_value1'][2]; ?></td>
 					<?php if (!empty($variant['product_variant_value2'])) : ?>
 					<td><?php echo $variant['product_variant_value2'][2]; ?></td>
 					<?php endif; ?>
 					<td><?php echo $variant['product_variant_price']; ?></td> 
						<?php if (!empty($variant['stock'])): ?>
							<?php $quantity = array(); ?>
							<?php  foreach ($variant['stock'] as $stock) : ?>
								<?php $quantity[] = $stock['product_warehouse_quantity'] ?>
							<?php endforeach; ?>
							<td><?php echo array_sum($quantity); ?></td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php endif; ?>
		</div>
	</div>
</div>