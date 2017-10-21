<style type="text/css">
         @media print {    
           .noprint { display: none; }
         }​
</style>

      <input type="submit" class="noprint" style="color:white;background:#3b5998" id="save" name="save" value="Print" onclick="window.print();">
      <a class="noprint" href="<?php echo base_url().'order';?>">Cancel</a>
    
    <div class="clearfix"></div>


<?php
    include_once("application/views/sasscompile/build.php");
?>

<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/shotlancer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/sjs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/functionswiper.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>application/libraries/javascript/js/jquery-ui-1.11.4.custom/jquery-ui.css">
<!DOCTYPE html>
<meta lang="en" />
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1.5" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/libraries/bootstrap/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/libraries/bootstrap/css/bootstrap-theme.min.css" />
    <!-- Latest compiled and minified JavaScript -->

    <link href='https://fonts.googleapis.com/css?family=Hind:400,300' rel='stylesheet' type='text/css'>

    <title>ShotLancer</title>
    <meta content="text/html" charset="utf-8" />
    <link rel="icon" href="<?php echo base_url();?>application/views/images/favicon.png" type="image/png" />
    <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/styles.css"/>
</head>
<script language="javascript">
jQuery(document).ready(function(){
     jQuery(function() {
        window.print();
    });
});
</script>
<div class="col-lg-4 text-left">
  <div class="panel panel-default">
    <div class="panel-heading">Customer</div>
    <div class="panel-body">
      <p><b>Name</b>: <?php echo $detail['order_shipping_recipient_name']; ?></p>
      <p><b>Phone</b>: <?php echo $detail['order_shipping_recipient_phone']; ?></p>
      <p><b>Email</b>: <?php echo $detail['cus_email']; ?></p>
    </div>
  </div>
</div>

<div class="col-lg-4 text-left">
  <div class="panel panel-default">
    <div class="panel-heading">Payment</div>
    <div class="panel-body">
      <p><b>Method</b>: <?php echo $detail['payment_method_type']; ?></p>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <div class="panel-heading">Address</div>
    <div class="panel-body">
      <p><b>Street</b>: <?php echo $detail['order_shipping_street']; ?></p>
      <p><b>District</b>: <?php echo $detail['order_shipping_district']; ?></p>
      <p><b>City</b>: <?php echo $detail['order_shipping_city']; ?></p>
      <p><b>Country</b>: <?php echo $detail['order_shipping_country']; ?></p>
    </div>
  </div>
</div>

<?php if (!empty($detail['shipping_info'])) { ?>
<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <div class="panel-heading">Shipping</div>
    <div class="panel-body">
      <p><b>Ship by</b>: <?php echo $detail['shipping_info']['com_shipper_name']; ?></p>
      <p><b>Tracking number:</b>: <?php echo $detail['shipping_info']['order_shipping_shipper_tracking']; ?></p>
      <p><b>Tracking website</b>: <?php echo $detail['shipping_info']['com_shipper_trackingsite']; ?></p>
      <p><b>Estimated delivery date</b>: <?php echo $detail['shipping_info']['order_shipping_shipper_estdate']; ?></p>
      <p><b>Status</b>: <?php echo $detail['shipping_info']['shipping_status_name']; ?></p>
    </div>
  </div>
</div>
<?php } ?>

<div class="col-lg-6 text-left">
  <div class="panel panel-default">
    <div class="panel-heading">Value</div>
    <div class="panel-body">
      <p><b>Sub total</b>: <?php echo !empty($detail['total_value']) ? $detail['total_value'] :price(0) ; ?></p>
      <p><b>Tax</b>: <?php echo !empty($detail['tax_fee']) ? price($detail['tax_fee']) : price(0); ?></p>
      <p><b>Net</b>: <?php echo price(floatval($detail['tax_fee']) + floatval($detail['total_value'])) ?></p>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<h2>Items</h2>
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
                if (!empty($item['order_item_sale_value']))
                  echo $item['order_item_sale_type']=='percentage' ? ' %' : ' USD'; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</html>