<div class="col-md-4">
<div class="panel panel-default panel-custom">
  <div class="panel-heading">Customer</div>
  <div class="panel-body text-left">
    <ul class="list-group">
	  <li class="list-group-item">
      <b>Name</b>:
      <a href="<?php echo base_url().'customer-detail/'.$detail['order_cus_id']?>"><?php echo $detail['order_shipping_recipient_name'];?></a>
    </li>
	  <li class="list-group-item"><b>Phone</b>: <?php echo $detail['order_shipping_recipient_phone'];?></li>
    <li class="list-group-item"><b>Email</b>: <?php echo $detail['cus_email'];?></li>
	</ul>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default panel-custom">
  <div class="panel-heading">Payment</div>
  <div class="panel-body text-left">
    <ul class="list-group">
	  <li class="list-group-item"><b>Method</b>: <?php echo $detail['payment_method_type'];?></li>
	</ul>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default panel-custom">
  <div class="panel-heading">Value</div>
  <div class="panel-body text-left">
    <ul class="list-group">
	  <li class="list-group-item"><b>Total</b>: <?php echo empty($detail['discount']['value'])?$detail['order_payment_amount'].' USD':$detail['order_payment_amount'].' => '.$detail['discount']['value'].' USD';?></li>
	  <li class="list-group-item"><b>Discount</b>: <?php echo $detail['discount']['discount_type'].' USD';?></li>
	  <li class="list-group-item"><b>Tax</b>: <?php echo $detail['tax_fee'].' USD';?></li>
	  <li class="list-group-item"><b>Net</b>: </li>
	</ul>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default panel-custom">
  <div class="panel-heading">Commission</div>
  <div class="panel-body text-left">
    <ul class="list-group">
	  <li class="list-group-item"><b>Commission</b>: <?php echo $detail['commision_value'].' USD';?></li>
<?php if (!empty($detail['extra_fee'])):?>
        <?php foreach ($detail['extra_fee'] as $key => $fee):?>
          <li class="list-group-item"><b><?php echo $fee['order_extra_fee_name']?>: </b><?php echo price($fee['order_extra_fee_amount']);?></li>
<?php endforeach;?>
      <?php endif;?>
	</ul>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default panel-custom">
  <div class="panel-heading">Shipping address</div>
  <div class="panel-body text-left">
    <ul class="list-group">
	  <li class="list-group-item"><b>Street</b>: <?php echo $detail['order_shipping_street'];?></li>
	  <li class="list-group-item"><b>District</b>: <?php echo $detail['order_shipping_district'];?></li>
	  <li class="list-group-item"><b>City</b>: <?php echo $detail['order_shipping_city'];?></li>
	  <li class="list-group-item"><b>Country</b>: <?php echo $detail['order_shipping_country'];?></li>
	</ul>
  </div>
</div>
</div>
<div class="clearfix"></div>
<h2 class="text-left">Items</h2>
<table class="table">
    <thead>
        <tr>
            <th width="5%">B2C SKU</th>
            <th width="10%">Supplier</th>
            <th width="5%">SKU</th>
            <th width="20%">Name</th>
            <th width="5%">Qty</th>
            <th width="5%">Price</th>
            <th width="5%">Original price</th>
            <th width="5%">Stock</th>
            <th width="20%">Image</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($detail['items'] as $key => $item):?>
        <tr>
            <td><?php echo $item['order_item_prod_id']?></td>
            <td><a href="<?php echo base_url().'supplier-detail/'.$item['sup_id']?>"><?php echo $item['sup_name']?></a></td>
            <td><?php echo $item['variant_internal_id']?></td>
            <td><a href="<?php echo base_url().'product-detail/'.$item['order_item_prod_id'];?>"><?php echo $item['prod_name']?></a><br>
<?php echo !empty($item['variant_value'][0])?$item['variant_value'][0].' - '.$item['variant_value'][1]:'';?>
            </td>
            <td><?php echo $item['order_item_quantity'];?></td>
            <td><?php echo $item['order_item_price'];?></td>
            <td><?php echo $item['order_item_original_price'];?></td>
            <td>
<?php $stock = 0;foreach ($item['stock'] as $k => $ware):?>
                    <?php $stock += (int) $ware;?>
                <?php endforeach;
echo $stock;
?>
</td>
            <td>
<?php
if (!empty($item['variant_image'])):
$prod_img = base_url().$item['variant_image'];
 else :
$prod_img = base_url().'application/views/images/products/product_01.jpg';
endif;
?>
            <img src="<?php echo $prod_img;?>">
            </td>
        </tr>
<?php endforeach;?>
</tbody>
</table>
<h2>Transactions</h2>
<?php if (count($detail['logs']) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Notice!</strong> Empty Logs
    </div>
<?php  else :?>
<table class="table table-striped">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="80%">Log</th>
            <th width="10%">Time</th>
        </tr>
    </thead>
    <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
        <?php foreach ($detail['logs'] as $key => $log):?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo '<b>'.$log['sup_contact_name'].'</b> '.$log['transaction_status_description'];?></td>
                <td><?php echo dateFormat($log['transaction_time']);?></td>
            </tr>
<?php $i++;?>
        <?php endforeach;?>
</tbody>
</table>
<?php endif;?>
