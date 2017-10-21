<div id="image-wrapper">
	<h3>Product Images</h3>
	<table class="table">
	<th width="2%">No</th>
	<th width="5%">Image</th>
	<th width="8%">Path</th>
	<th width="10%">Size</th>
<?php foreach ($product_images as $key => $image):?>
		<tr>
			<td><?php echo ($key+1);?></td>
			<td><div class="imgmaxwid view"><img class="img-responsive " src="<?php echo base_url().$image['prod_image_path'];?>"></div></td>
			<td><?php echo base_url().$image['prod_image_path'];?></td>
			<td><?php echo $image['prod_image_height'].' x '.$image['prod_image_width'];?></td>
		</tr>
<?php endforeach;?>
</table>
	<h3>Product Variant Images</h3>
	<table class="table">
		<th>No</th>
		<th>Image</th>
		<th>Path</th>
		<th>Size</th>
<?php if (!empty($variants)) : ?>
	<?php foreach ($variants as $key => $variant) : ?>
		<?php if (!empty($variant['variant_image'])) : ?>
			<?php foreach ($variant['variant_image'] as $i => $image):?>
				<tr>
					<td><?php echo $image['product_variant_id'];?></td>
					<td><div class="imgmaxwid view"><img class="img-responsive " src="<?php echo base_url().$image['variant_image_path'];?>"></div></td>
					<td><?php echo base_url().$image['variant_image_path'];?></td>
					<td><?php echo $image['variant_image_height'].' x '.$image['variant_image_width'];?></td>
				</tr>
			<?php endforeach;?>
		<?php endif; ?>
	<?php endforeach;?>
<?php endif; ?>
</table>
</div>

<div id="fullView">
    <img class="img-thumbnail" src="">
</div>
<style type="text/css">
	#fullView{
    display: none;
    position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
 text-align:center;
  z-index: 9999999;
}
 #fullView::before{
      content: '';
        position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background-color: #000000 ;
      opacity: 0.5;
  }
 #fullView  img{
        display: none;
        margin: auto;
        position: relative;
        margin-top: 4%;
    }

</style>