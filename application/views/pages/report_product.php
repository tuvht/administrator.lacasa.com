<?php if (!empty($msg)): ?>
<div class="alert alert-<?php echo $msg['type']; ?>" role="alert"><?php echo $msg['text']; ?></div>
<?php endif; ?>

<form method="post" action="<?php echo base_url() . 'active-product' ?>" name="form">
    <div class="control-group">
        <div class="btn-group">
            <input value="<?php echo !empty($keyword) ? $keyword : ''; ?>" type="text" class="form-control" name="keyword" placeholder="Search" aria-describedby="basic-addon2">
            <span class="input-group-btn">
                <input type="submit" name="search-button" class="btn btn-default" onClick="return document.form.submit();" value="Search">
                <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
            </span>
        </div>
    </div>
    <?php if (count($products) == 0) : ?>
        <div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Notice!</strong> Empty Product
        </div>
    <?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th width="10%">SKU</th>
                <th width="10%">Name</th>
                <th width="10%">Price</th>
                <th width="10%">Online date</th>
                <th width="5%">Stock</th>
                <th width="10%">Sold</th>
                <th width="10%">Value</th>
                <th width="10%">Type</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1 ; ?>
            <?php foreach ($products as $key => $product): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $product['prod_supplierinternalid']; ?></td>
                    <td><a href="<?php echo base_url() . 'product-detail/' . $product['prod_id']; ?>"><?php echo $product['prod_name']; ?></a></td>
                    <td><?php echo $product['prod_price']; ?></td>
                    <td><?php echo $product['prod_upload_date']; ?></td>
                    <td><?php echo $product['stock_total']; ?></td>
                    <td><?php echo $product['sold_quantity']; ?></td>
                    <td><?php echo ($product['sold_quantity'] * $product['prod_price']); ?></td>
                    <td><?php echo $product['prod_type_name']; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    <ul class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
</form>