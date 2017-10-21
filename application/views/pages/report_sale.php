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
    <?php if (count($sales) == 0) : ?>
        <div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Notice!</strong> Empty Report
        </div>
    <?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th width="10%">Month</th>
                <th width="10%">Total orders</th>
                <th width="10%">Orders value</th>
                <th width="10%">Paid</th>
                <th width="5%">Cancelled order</th>
                <th width="10%">Cancelled value</th>
                <th width="10%">Unit sold</th>
                <th width="10%">Best seller</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1 ; ?>
            <?php foreach ($sales as $key => $sale): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $sale['month'] . ' - ' . $sale['year']; ?></td>
                    <td><?php echo $sale['total']; ?></td>
                    <td><?php echo $sale['value']; ?></td>
                    <td><?php echo $sale['complete_value']; ?></td>
                    <td><?php echo $sale['cancel_order']; ?></td>
                    <td><?php echo $sale['cancel_value']; ?></td>
                    <td><?php echo $sale['complete_unit']; ?></td>
                    <td><?php echo $sale['complete_last']; ?></td>
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