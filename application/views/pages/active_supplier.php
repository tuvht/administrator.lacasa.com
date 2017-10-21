<script language="javascript">
$(document).ready(function(){
    //$('#datetimepicker1').datetimepicker();
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
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>

<form method="post" action="<?php echo base_url().'active-supplier'?>" name="form">

    <div class="container">
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
<?php if (count($suppliers) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Notice!</strong> Empty Supplier
    </div>
<?php  else :?>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="20%"><a href="?order=sup_name&dir=<?php echo $order_dir;?>">Name</a></th>
                    <th width="5%"><a href="?order=sup_id&dir=<?php echo $order_dir;?>">Supplier ID</a></th>
                    <th width="5%"><a href="?order=active_product&dir=<?php echo $order_dir;?>">Active products</a></th>
                    <th width="5%"><a href="?order=inactive_product&dir=<?php echo $order_dir;?>">Inactive products</a></th>
                    <th width="5%"><a href="?order=outofstock_product&dir=<?php echo $order_dir;?>">Out of stock products</a></th>
                    <th width="5%"><a href="?order=complete_order&dir=<?php echo $order_dir;?>">Complete orders</a></th>
                    <th width="5%"><a href="?order=cancelled_order&dir=<?php echo $order_dir;?>">Cancelled orders</a></th>
                    <th width="10%"><a href="?order=sup_joindate&dir=<?php echo $order_dir;?>">Join date</a></th>
                    <th width="10%"><a href="?order=last_sold&dir=<?php echo $order_dir;?>">Last sold</a></th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($suppliers as $key => $supplier):?>
                    <tr>
                        <td><a href="<?php echo base_url().'supplier-detail/'.$supplier['sup_id']?>"><?php echo $supplier['sup_name'];?></a></td>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $supplier['sup_id'];?>" type="checkbox" name="selected[]" value="<?php echo $supplier['sup_id'];?>"/>
                        </span>
<?php echo $supplier['sup_id'];?></td>
                        <td><?php echo $supplier['active_product'];?></td>
                        <td><?php echo $supplier['inactive_product'];?></td>
                        <td><?php echo $supplier['outofstock_product'];?></td>
                        <td><?php echo $supplier['complete_order'];?></td>
                        <td><?php echo $supplier['cancelled_order'];?></td>
                        <td><?php echo dateFormat($supplier['sup_joindate']);?></td>
                        <td><?php echo !empty($supplier['last_sold'])?dateFormat($supplier['last_sold']['sup_shipping_deliverdate']):"Still not sell";?></td>
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
</div>
</form>
