<?php $this->load->model('Model_order');?>
<script language="javascript">
$(document).ready(function(){

     $(function() {
        $("#pagination a").each(function() {
            var g = window.location.href.slice(window.location.href.indexOf('?'));
            var href = $(this).attr('href');
            $(this).attr('href', href+g);
        });
    });
});
function active_status(id) {
    var check = jQuery('#check-'+id).attr('checked', 'checked');
    jQuery('form[name=form]').submit();
}
function chkallClick(o) {
    var form = document.form;
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type == "checkbox" && form.elements[i].name != "chkall") {
            form.elements[i].checked = document.form.chkall.checked;
        }
    }
}
function checkdelete()
{
    var alert = window.confirm("Do you want to delete ?");
    if (alert == true)
        return true;
    else
        return false;
}
/*function search()
{
    var keyword = jQuery('input[name="keyword"]').val();
    var form = jQuery('form[name=form]');
    var new_url = '<?php echo base_url().'active-product/'?>' + keyword;
    form.attr('action', new_url).submit();
}*/
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>

<form method="post" action="<?php echo base_url().'active-product'?>" name="form">
<span>Name Search</span>
    <div class="control-group">
        <div class="btn-group">
            <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
            <span class="input-group-btn">
                <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
            </span>
        </div>
    </div>

<?php if (count($products) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Notice!</strong> Empty Product
        </div>
<?php  else :?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="25%"><a href="?order=p.prod_name&dir=<?php echo $order_dir;?>">Name</a></th>
                <th width="5%"><a href="?order=p.prod_id&dir=<?php echo $order_dir;?>">B2C SKU</a></th>
                <th width="5%"><a href="?order=p.prod_supplierinternalid&dir=<?php echo $order_dir;?>">Supplier SKU</a></th>
                <th width="10%"><a href="?order=p.prod_supplier_id&dir=<?php echo $order_dir;?>">Supplier</a></th>
                <th width="1%"><a href="?order=p.prod_price&dir=<?php echo $order_dir;?>">Price</a></th>
                <th width="1%"><a href="?order=stock_total&dir=<?php echo $order_dir;?>">Stock</a></th>
                <th width="5%"><a href="?order=p.prod_upload_date&dir=<?php echo $order_dir;?>">Create date</a></th>
                <th width="5%"><a href="?order=promotion&dir=<?php echo $order_dir;?>">Promotion</a></th>
                <th width="1%">Preview</th>
            </tr>
        </thead>
        <tbody>
<?php $i = 1;?>
            <?php foreach ($products as $key => $product):?>
                <tr>
                    <td>
                    <a href="<?php echo base_url().'product-detail/'.$product['prod_id'];?>"><?php echo $product['prod_name'];
?></a>
                    </td>
                    <td>
                    <span class="hide">
                        <input id="check-<?php echo $product['prod_id'];?>" type="checkbox" name="selected[]" value="<?php echo $product['prod_id'];?>"/>
                    </span>
                    <!-- href="http://web1.asiantechhub.com/product/<?php echo $product['slug_name'].'-'.$product['prod_id'];?>" -->
                    <span target="_blank" ><?php echo $product['prod_id'];?></span>
                    </td>
                    <td><?php echo $product['prod_supplierinternalid'];?></td>
                    <td><?php echo $product['sup_name'];?></td>
                    <td>
<?php if (!empty($product['min_price']) && $product['min_price'] != $product['max_price']):?>
                            From <?php echo price($product['min_price']);
?> to <?php echo price($product['max_price']);
?>
                        <?php  elseif (!empty($product['min_price']) && $product['min_price'] == $product['max_price']):?>
                            <?php echo price($product['min_price']);?>
                        <?php  elseif (empty($product['min_price'])):?>
                            <?php echo price($product['prod_price']);?>
                        <?php endif;?>
                    </td>
                    <td><?php echo $product['stock_total'];?></td>
                    <td><?php echo dateFormat($product['prod_upload_date']);?></td>
                    <td><?php echo $product['promotion'];?></td>
                    <td class ="text-center"><a target="_blank" href="http://patryca.com/product/<?php echo $product['slug_name'].'-'.$product['prod_id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                </tr>
<?php $i++;?>
            <?php endforeach;?>
</tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    <ul class="pagination" id="pagination">
<?php echo $this->pagination->create_links();?>
</ul>
                </td>
            </tr>
        </tfoot>
    </table>
<?php endif;?>
</form>
