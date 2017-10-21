<script type="text/javascript">
$(document).ready(function(){
     $(function() {
        var promotion_id = '<?php echo $promotion_id?>';
        if (promotion_id == ''){
            jQuery('table#table-promotion').hide();
            jQuery('div#promotion-detail').hide();
        }
        else{
            jQuery('table#table-promotion').show();
            jQuery('div#promotion-detail').show();
        }

        jQuery('input:radio').on('change', function(){
            var prod_id = jQuery(this).attr('product-id');
            var value = jQuery(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'update-promotion';?>",
                data: {prod_id: prod_id, choose: value, promotion_id: promotion_id},
                success: function(msg) {
                }
            });
        });
    });
});
function submit_form(o) {
    var value = jQuery(o).val();
    var base_url = '<?php echo base_url();?>';
    var form = jQuery('form#promotion-form');
    form.attr('action', base_url + 'promotion-detail/' + value).submit();
}
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>
<div class="container">
        <form method="POST" action="" name="promotion_form" id="promotion-form" class="pull-left">
            <select onchange="submit_form(this);" name="promotion" id="promotion">
                <option value="">Select promotion</option>
<?php foreach ($available as $key => $promotion):?>
                    <option <?php echo (!empty($promotion_id) && $promotion_id == $promotion['promotion_id'])?'selected="selected':'';?> value="<?php echo $promotion['promotion_id']?>"><?php echo $promotion['promotion_name']?></option>
<?php endforeach;?>
            </select>
        </form>
        <div class="clearfix"></div>
        <div id="promotion-detail" class="pull-left text-left">
            <div><strong>Promotion name</strong>: <?php echo $detail['promotion_name'];?></div>
            <div><strong>Promotion type</strong>: <?php echo $detail['promotion_type_name'];?></div>
            <div><strong>Promotion time</strong>: <?php echo $detail['promotion_startdate'];
?> to <?php echo $detail['promotion_enddate'];
?></div>
<?php if ($detail['promotion_type'] == 1):?>
                <?php if ($detail['detail']['field']['promotion_type_field_id'] == 1):?>
                    <div><strong>Discount percentage</strong>: <?php echo $detail['detail']['detail'];?>%</div>
<?php  elseif ($detail['detail']['field']['promotion_type_field_id'] == 2):?>
                    <div><strong>Discount amount</strong>: <?php echo price($detail['detail']['detail']);?></div>
<?php endif;?>
            <?php  elseif ($detail['promotion_type'] == 2):?>
                <?php if ($detail['detail']['field']['promotion_type_field_id'] == 1):?>
                    <div><strong>Reducetion percentage</strong>: <?php echo $detail['detail']['detail'];?>%</div>
<?php  elseif ($detail['detail']['field']['promotion_type_field_id'] == 2):?>
                    <div><strong>Reducetion amount</strong>: <?php echo price($detail['detail']['detail']);?></div>
<?php endif;?>
            <?php  elseif ($detail['promotion_type'] == 3):?>
            <?php endif;?>
</div>
<span>Name Search</span>
<form class="control-group" action="<?php echo base_url().'promotion-detail/'.$promotion_id?>" method = "post">
    <div class="btn-group">
        <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
        <span class="input-group-btn">
            <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
            <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
        </span>
    </div>
</form>
<?php if (count($products) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Product
            </div>
<?php  else :?>
<table id="table-promotion" class="table table-striped">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th width="15%"><a href="?order=prod_name&dir=<?php echo $order_dir;?>">Name</a></th>
                    <th width="15%"><a href="?order=prod_id&dir=<?php echo $order_dir;?>">B2C SKU</a></th>
                    <th width="10%"><a href="?order=prod_price&dir=<?php echo $order_dir;?>">Price</a></th>
                    <th width="15%"><a href="?order=prod_upload_date&dir=<?php echo $order_dir;?>">Create date</a></th>
                </tr>
            </thead>
            <tbody>
<?php $i = 1;?>
                <?php foreach ($products as $key => $product):?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><a href="<?php echo base_url().'product-detail/'.$product['prod_id'];?>"><?php echo $product['prod_name'];
?></a></td>
                        <td><?php echo $product['prod_id'];?></td>
                        <td><?php echo $product['prod_price'];?></td>
                        <td><?php echo dateFormat($product['prod_upload_date']);?></td>
                    </tr>
<?php $i++;?>
                <?php endforeach;?>
</tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <ul class="pagination">
<?php echo $this->pagination->create_links();?>
</ul>
                    </td>
                </tr>
            </tfoot>
        </table>
<?php endif;?>
</div>
