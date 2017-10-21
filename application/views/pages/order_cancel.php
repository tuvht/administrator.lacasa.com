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
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>
<div class="control-group">
    <form method="post" action="<?php echo base_url().'order-cancel'?>" name="form">
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
    </form>
</div>
<?php if (count($orders) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Notice!</strong> Empty Product
    </div>
<?php  else :?>
<table class="table table-striped">
    <thead>
        <tr>
            <th width="2%"></th>
            <th width="10%"><a href="?order=order_id&dir=<?php echo $order_dir;?>">Order ID</a></th>
            <th width="10%"><a href="?order=order_date&dir=<?php echo $order_dir;?>">Date</a></th>
            <th width="10%"><a href="?order=count_items&dir=<?php echo $order_dir;?>">Total items</a></th>
            <th width="10%"><a href="?order=total_value&dir=<?php echo $order_dir;?>">Total value</a></th>
            <th width="10%"><a href="?order=payment&dir=<?php echo $order_dir;?>">Payment</a></th>
            <th width="5%"><a href="?order=cancelled_by&dir=<?php echo $order_dir;?>">Cancelled by</a></th>
            <th width="10%"><a href="?order=cancel_reason&dir=<?php echo $order_dir;?>">Reason</a></th>
            <th width="5%"><a href="?order=cancelled_date&dir=<?php echo $order_dir;?>">Cancelled date</a></th>
            <th width="10%"><a href="?order=cancel_note&dir=<?php echo $order_dir;?>">Notes</a></th>
        </tr>
    </thead>
    <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
        <?php foreach ($orders as $key => $order):?>
            <tr>
                <td>
                    <a class="no-borders btn btn-default collapsed" data-parent="#accordion" role="button" data-toggle="collapse" href="#collapse<?php echo $order['order_id']?>" aria-expanded="true" aria-controls="collapse<?php echo $order['order_id']?>">
                    <i class="fa fa-chevron-right" ></i>
                    </a>
                </td>
                <td><a href="<?php echo base_url().'order-detail/'.$order['order_id'];?>"><?php echo $order['order_id'];
?></a></td>
                <td><?php echo $order['order_date']?></td>
                <td><?php echo $order['count_items'];?></td>
                <td><?php echo $order['total_value'];?></td>
                <td><?php echo $order['payment'];?></td>
                <td><?php echo $order['cancelled_by'];?></td>
                <td><?php echo $order['order_cancel_reason_name'];?></td>
                <td><?php echo $order['cancelled_date'];?></td>
                <td><?php echo $order['cancel_note'];?></td>
            </tr>
            <tr>
                <td colspan="10">
                    <table class="table collapse" id="collapse<?php echo $order['order_id'];?>">
                        <thead>
                            <tr>
                                <th width="10%">Customer</th>
                                <th width="20%">Address</th>
                                <th width="20%">Product name</th>
                                <th width="5%">Quantity</th>
                                <th width="5%">Price</th>
                                <th width="20%">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($order['items'] as $key => $item):?>
                            <tr>
                                <td>
                                    <div><a href="<?php echo base_url().'customer-detail/'.$order['order_cus_id']?>"><?=$order['cus_name']?></a></div>
                                    <div><?=$order['cus_phone']?></div>
                                </td>
                                <td><?php echo $order['cus_address'];?></td>
                                <td>
                                    <div><a href="<?php echo base_url().'product-detail/'.$item['order_item_prod_id'];?>"><?php echo $item['prod_name']?></a></div>
                                    <div>
<?php if (!empty($item['variant_value'][0])):?>
                                    <?php echo $item['variant_value'][0];?>
                                <?php endif;?>
                                <?php if (!empty($item['variant_value'][1])):?>
                                    <?php echo ' - '.$item['variant_value'][1];?>
                                <?php endif;?>
                                    </div>
                                </td>
                                <td><?php echo $item['order_item_quantity'];?></td>
                                <td><?php echo $item['order_item_price']*$item['order_item_quantity'];?></td>
                                <td>
<?php foreach ($item['stock'] as $k => $ware):?>
                                        <?php echo $k.': '.$ware;?>
                                    <?php endforeach;?>
</td>
                            </tr>
<?php endforeach;?>
</tbody>
                    </table>
                </td>
            </tr>
<?php $i++;?>
            <div class="modal fade" id="orderModal<?php echo $order['order_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                </div>
              </div>
            </div>
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
