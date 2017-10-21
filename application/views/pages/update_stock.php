<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	var prod_id = '<?php echo $prod_id?>';
        $('#product_variant_value_'+prod_id+'_1').change(function(){
            var value = $(this).val();

            if ( value != '' ) {
                $(this).addClass('selected');
            }else{
                $(this).removeClass('selected');
            }

            $('#product_variant_value2').removeClass('selected');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'get-variant';?>",
                data: {variant: value, prod_id: prod_id},
                success: function(msg) {
                    $('#product_variant_value_'+prod_id+'_2').empty();
                    $('#product_variant_value_'+prod_id+'_2').html(msg);
                }
            });
        });
        $('#product_variant_value_'+prod_id+'_2').change(function(){
            var value = $(this).val();

            if ( value != '' ) {
                $(this).addClass('selected');
            }else{
                $(this).removeClass('selected');
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'get-attribute';?>",
                data: {variant: value, prod_id: prod_id},
                success: function(msg) {
                	console.log(msg);
                    $('#stock-quantity-'+prod_id).attr('value', parseInt(msg));
                }
            });
        });
    });
});
</script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Update Stock</h4>
</div>
<div class="modal-body">
	<span><b>Total: </b><?php echo !empty($stock_total['stock_total'])?$stock_total['stock_total']:0;?></span><br>
	<div id="cat_field_<?php echo $prod_id?>">
<?php foreach ($product['category_field'] as $key => $field):?>
            <select class="product-variant" id="product_variant_value_<?php echo $prod_id?>_<?php echo $key+1;?>" name="stock[<?php echo $prod_id?>][value<?php echo $key+1;?>]" required>
                <option value="">-- Select <?php echo $field['cat_field_name']?>--</option>
<?php foreach ($product['variant'] as $variant):?>
                    <?php if ($variant['cat_field_id'] == $field['cat_field_id']):?>
                        <option value="<?php echo $variant['product_variant_id']?>"><?php echo $variant['variant_value']?></option>
<?php endif;?>
                <?php endforeach;?>
</select>
<?php endforeach;?>
</div><br>
<?php foreach ($warehouses as $i => $warehouse):?>
	    <span><b><?php echo $warehouse['sup_warehouse_name']?>: </b>
	        <input id="stock-quantity-<?php echo $prod_id?>" type="number" name="stock[<?php echo $prod_id;?>][quantity]" min="0"
<?php //foreach ($stock_quantity as $stock) : ?>
	            <?php //if ($warehouse['sup_warehouse_id'] == $stock['supplier_warehouse']) : ?>
	                value="<?php //echo $stock['product_warehouse_quantity']; ?>"
<?php //endif; ?>
	        <?php //endforeach; ?>
/>
	    </span><br>
<?php endforeach;?>
</div>
<div class="modal-footer">
	<input type="hidden" name="stock[<?php echo $prod_id?>][sup_warehouse_id]" value="<?php echo $warehouse['sup_warehouse_id'];?>"/>
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" name="update_stock" class="btn btn-primary">Update</button>
</div>
