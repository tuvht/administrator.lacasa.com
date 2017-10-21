

<script language="javascript">
$(document).ready(function(){
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
    $(function() {
        $("#pagination a").each(function() {
            var g = window.location.href.slice(window.location.href.indexOf('?'));
            var href = $(this).attr('href');
            $(this).attr('href', href+g);
        });


        $('.update-order-button').on('click', function(){
            var order_id = $(this).attr('order-id');
            var order_status = $(this).attr('status');
            var on_the_way   = $(this).attr("ontheway");

            $('#orderModal'+order_id).modal({
                show: true,
                remote: '<?php echo base_url()."update-order/";?>' + order_id + '/' + order_status

            });
            $('#orderModal'+order_id).on('hidden.bs.modal', function () {
                $('#orderModal'+order_id).data('bs.modal', null);
            });
            $('#orderModal'+order_id).on('shown.bs.modal', function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'get-order-field';?>",
                    data: {order_id: order_id, status: order_status , ontheway:on_the_way},
                    success: function(msg) {
                        $('#body-'+order_id).html(msg);
                    }
                });
            })
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
<span>Name Search</span>
<div class="control-group">
<!-- <?php structure($orders)?> -->
    <form method="post" action="<?php echo base_url().'order'?>" name="form" class="btn-group">
        <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search" aria-describedby="basic-addon2">

            <span class="input-group-btn">
                <input type="submit" name="search-button" class="btn btn-default" onClick="return document.form.submit();" value="Search">
                <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
            </span>
        </form>
</div>
<?php if (count($orders) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Notice!</strong> Empty Order
    </div>
<?php  else :?>
<form method="post" action="<?php echo base_url().'order'?>" name="form">
<table class="table table-striped">
    <thead>
        <tr>
            <th width="2%"></th>
            <th width="5%"><a href="?order=order_id&dir=<?php echo $order_dir;?>">Main ID</a></th>
            <th width="30%"><a href="?order=order_shipping_recipient_name&dir=<?php echo $order_dir;?>">Customer</a></th>
            <th width="10%"><a href="?order=order_date&dir=<?php echo $order_dir;?>">Date</a></th>
            <th width="10%"><a href="?order=count_items&dir=<?php echo $order_dir;?>">Total items</a></th>
            <th width="10%"><a href="?order=total_value&dir=<?php echo $order_dir;?>">Total value</a></th>
            <th width="10%"><a href="?order=payment&dir=<?php echo $order_dir;?>">Payment</a></th>
            <th width="10%"><a href="?order=order_status_name&dir=<?php echo $order_dir;?>">Status</a></th>
            <th width="10%">Action</th>
            <th width="5%">Print</th>
        </tr>
    </thead>
    <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
        <?php foreach ($orders as $key => $order):?>
            <tr>
                <td>
                    <a class="btn btn-default collapsed no-borders" data-parent="#accordion" role="button" data-toggle="collapse" href="#collapse<?php echo $order['order_id']?>" aria-expanded="true" aria-controls="collapse<?php echo $order['order_id']?>">
                    <i class="fa fa-chevron-right"></i>
                    </a>
                </td>
                <td><a href="<?php echo base_url().'order-detail/'.$order['order_id'];?>"><?php echo $order['order_id'];
?></a>
                </td>
                <td>
                    <div><a href="<?php echo base_url().'customer-detail/'.$order['order_cus_id']?>"><?=$order['order_shipping_recipient_name']?></a></div>
                    <div><?=$order['order_shipping_recipient_phone'].' '.$order['cus_email']?></div>
                    <div><?=$order['cus_address']?></div>
<td>

<?php
$sup_order_date = date_create($order['order_date']);
echo date_format($sup_order_date, 'd/m/Y');
?>

                </td>
                <td><?php echo $order['count_items'];?></td>
                <td><?php echo $order['total_value'];?></td>
                <td><?php echo $order['payment'];?></td>
                <td><?php echo $order['order_status_name'];?></td>
                <td class="btngroup-suporder">
<?php if ($order['order_status'] == 1 || $order['order_status'] == 3):?>
                            <label><a class="btn btn-danger update-order-button"  order-id="<?php echo $order['order_id'];?>" status="2" ontheway="false"/>Reject</a></label>
<?php  elseif ($order['order_status'] == 7):?>
                            <label><a class="btn btn-success update-order-button" order-id="<?php echo $order['order_id'];?>" status="4"/>Ready to Ship</a></label>
                            <label><a class="btn btn-danger update-order-button" order-id="<?php echo $order['order_id'];?>" status="6" ontheway="false"/>Cancel</a></label>

<?php  elseif ($order['order_status'] == 4):?>
                    <?php $count_order = count($this->model_order->get_order_by_id($order['order_id']));?>
                    <!-- <?php echo $this->db->last_query()?>-->
<?php $count_order_status = count($this->model_order->get_order_by_status($order['order_id'], 8));?>

<?php if ($count_order == $count_order_status):?>
                            <label><a class="btn btn-success update-order-button" order-id="<?php echo $order['order_id'];?>" status="8
                            "/>Complete</a></label>
                            <label><a class="btn btn-danger update-order-button" order-id="<?php echo $order['order_id'];?>" status="6" ontheway="true"/>Cancel</a></label>
<?php  else :?>
    <label><a class="btn btn-danger update-order-button" order-id="<?php echo $order['order_id'];?>" status="6" ontheway="false"/>Cancel</a></label>
<?php endif?>

<?php  elseif ($order['order_status'] == 8):?>
                                <label><?php echo $order['order_shipping_shipper_tracking'];?></label>
                                <label><a class="btn btn-danger update-order-button" order-id="<?php echo $order['order_id'];?>" status="6" ontheway="false"/>Cancel</a></label>
<?php endif;?>
                </td>
                <td class=""><a class="btn-sm btn btn-default" href="<?php echo base_url().'print-order-detail/'.$order['order_id'];?>"><i class="fa fa-print"></i>Print</a></td>
            </tr>
            <tr class="collapse" id="collapse<?php echo $order['order_id'];?>">
                <td colspan="15">
                    <table class="table">
                        <thead>
                            <tr>
                                <!-- <th width="10%">Customer</th> -->
                                <!-- <th width="15%">Address</th> -->
                                <th width="5%">Supplier Order ID</th>
                                <th width="10%">Supplier Name</th>
                                <th width="20%">Product name</th>
                                <th width="5%">Quantity</th>
                                <th width="5%">Price</th>
                                <th>Stock</th>
                                <th>Tracking number</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($order['items'] as $key => $item):?>
                            <tr>
                                <!-- <td><?php echo $order['cus_name'].'<br>'.$order['cus_phone'];?></td> -->
                                <!-- <td><?php echo $order['cus_address'];?></td> -->
                                <td><?=$this->model_order->getMainOrderID($order['order_id'], $item['sup_id'])?></td>
                                <td><?php echo $item['sup_name']?></td>
                                <td>
<?php echo $item['prod_name']?><br>
<?php if (!empty($item['variant_value'][0])):?>
                                    <?php echo $item['variant_value'][0];?>
                                <?php endif;?>
                                <?php if (!empty($item['variant_value'][1])):?>
                                    <?php echo ' - '.$item['variant_value'][1];?>
                                <?php endif;?>
                                </td>
                                <td><?php echo $item['order_item_quantity'];?></td>
                                <td><?php echo $item['order_item_price']*$item['order_item_quantity'];?></td>
                                <td>
<?php $stock = 0;foreach ($item['stock'] as $k => $ware):?>
                                        <?php $stock += (int) $ware;?>
                                    <?php endforeach;
echo $stock;
?>
                                </td>
                                <td><?php echo $item['sup_shipping_trackingnumber'];?></td>
                                <td><?php
if ($item['sup_order_status'] == 1):
echo 'New';
 elseif ($item['sup_order_status'] == 2):
echo 'Rejected';
 elseif ($item['sup_order_status'] == 3):
echo 'Confirmed';
 elseif ($item['sup_order_status'] == 4):
echo 'On the way';
 elseif ($item['sup_order_status'] == 8):
echo 'Complete';
endif;
?></td>
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
            <td colspan="15">
                <ul class="pagination" id="pagination">
<?php echo $this->pagination->create_links();?>
</ul>
            </td>
        </tr>
    </tfoot>
</table>
</form>
<?php endif;?>