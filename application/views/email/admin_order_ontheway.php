<style>p.indent{ padding-left: 1.8em }</style>


<h2>Your order is on the way. Will be with you soon</h2>

<div class="col-lg-4 text-left">
  <div class="panel panel-default">
    <h3>Customer</h3>
    <div class="panel-body">
      <p class="indent"><b>Name</b>: <?php echo $detail['order_shipping_recipient_name']; ?></p>
      <p class="indent"><b>Phone</b>: <?php echo $detail['order_shipping_recipient_phone']; ?></p>
      <p class="indent"><b>Email</b>: <?php echo $detail['cus_email']; ?></p>
    </div>
  </div>
</div>

<div class="col-lg-4 text-left">
  <div class="panel panel-default">
    <h3>Payment</h3>
    <div class="panel-body">
      <p class="indent"><b>Method</b>: <?php echo $detail['payment_method_type']; ?></p>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <h3>Address</h3>
    <div class="panel-body">
      <p class="indent"><b>Street</b>: <?php echo $detail['order_shipping_street']; ?></p>
      <p class="indent"><b>District</b>: <?php echo $detail['order_shipping_district']; ?></p>
      <p class="indent"><b>City</b>: <?php echo $detail['order_shipping_city']; ?></p>
      <p class="indent"><b>Country</b>: <?php echo $detail['order_shipping_country']; ?></p>
    </div>
  </div>
</div>

<?php if (!empty($detail['shipping_info'])) { ?>
<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <h3>Shipping</h3>
    <div class="panel-body">
      <p class="indent"><b>Ship by</b>: <?php echo $detail['shipping_info']['com_shipper_name']; ?></p>
      <p class="indent"><b>Tracking number:</b>: <?php echo $detail['shipping_info']['order_shipping_shipper_tracking']; ?></p>
      <p class="indent"><b>Tracking website</b>: <?php echo $detail['shipping_info']['com_shipper_trackingsite']; ?></p>
      <p class="indent"><b>Estimated delivery date</b>: <?php echo $detail['shipping_info']['order_shipping_shipper_estdate']; ?></p>
    </div>
  </div>
</div>
<?php } ?>

<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <h3>Value</h3>
    <div class="panel-body">
      <p class="indent"><b>Sub total</b>: <?php echo !empty($detail['total_value']) ? $detail['total_value'] :price(0) ; ?></p>
      <p class="indent"><b>Tax</b>: <?php echo !empty($detail['tax_fee']) ? price($detail['tax_fee']) : price(0); ?></p>
      <p class="indent"><b>Net</b>: <?php echo price(floatval($detail['tax_fee']) + floatval($detail['total_value'])) ?></p>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<h3>Items</h3>
<table class="table">
    <thead>
        <tr>
            <th width="5%">SKU</th>
            <th width="10%">Image</th>
            <th width="15%">Qty</th>
            <th width="20%">Name</th>
            <th width="10%">Price</th>
            <th width="10%">Original price</th>
            <th width="10%">Discount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail['items'] as $key => $item): ?>
        <tr>
            <td><?php echo $item['prod_supplierinternalid'] ?></td>
            <td>
            <?php
              if ( !empty($item['variant_image'])):
                $prod_img = base_url() . $item['variant_image'];
              else:
                $prod_img = base_url() . 'application/views/images/products/product_01.jpg';
              endif;
            ?>
            <img src="<?php echo $prod_img; ?>">
            </td>
            <td><?php echo $item['order_item_quantity']; ?></td>
            <td><?php echo $item['prod_name'] ?><br>
            <?php echo !empty($item['variant_value']) ? ($item['variant_value'][0] . ' - ' . $item['variant_value'][1]) : '';?>
            </td>
            <td><?php echo $item['order_item_price']; ?></td>
            <td><?php echo !empty($item['order_item_original_price']) ? $item['order_item_original_price'] : ''; ?></td>
            <td><?php echo !empty($item['order_item_sale_value']) ? $item['order_item_sale_value'] : '';
                if (!empty($item['sup_order_item_sale_value']))
                  echo $item['order_item_sale_type']=='percentage' ? ' %' : ' USD'; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</html>