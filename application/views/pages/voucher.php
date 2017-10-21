<script language="javascript">
function active_status(id) {
    var check = jQuery('#check-'+id).attr('checked', 'checked');
    jQuery('form[name=form]').submit();
}
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>

<form method="post" action="<?php echo base_url().'voucher'?>" name="form">

    <div class="container">
    <span>Name Search</span>
        <div class="control-group">
            <div class="pull-left">
                <a href="<?php echo base_url().'voucher-detail';?>" class="btn btn-success">Add</a>
            </div>
            <div class="btn-group">
                <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
                <span class="input-group-btn">
                    <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                    <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
                </span>
        </div>
    </div>
<?php if (count($vouchers) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Voucher
            </div>
<?php  else :?>
<table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><a href="?order=voucher_id&dir=<?php echo $order_dir;?>">Voucher ID</a></th>
                    <th width="10%"><a href="?order=voucher_code&dir=<?php echo $order_dir;?>">Voucher Code</a></th>
                    <th width="5%"><a href="?order=discount_value&dir=<?php echo $order_dir;?>">Discount value</a></th>
                    <th width="5%"><a href="?order=discount_percentage&dir=<?php echo $order_dir;?>">Discount percentage</a></th>
                    <th width="5%"><a href="?order=created_date&dir=<?php echo $order_dir;?>">Created date</a></th>
                    <th width="5%"><a href="?order=expiry_date&dir=<?php echo $order_dir;?>">Expiry date</a></th>
                    <th width="5%"><a href="?order=voucher_status&dir=<?php echo $order_dir;?>">Status</a></th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($vouchers as $key => $voucher):?>
                    <tr>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $voucher['voucher_id'];?>" type="checkbox" name="selected[]" value="<?php echo $voucher['voucher_id'];?>"/>
                        </span>
<?php echo $voucher['voucher_id'];?></td>
                        <td><a href="<?php echo base_url().'voucher-detail/'.$voucher['voucher_id']?>"><?php echo $voucher['voucher_code'];?></a></td>
                        <td><?php echo price($voucher['discount_value']);?></td>
                        <td><?php echo $voucher['discount_percentage'].'%';?></td>
                        <td><?php echo dateFormat($voucher['created_date']);?></td>
                        <td><?php echo dateFormat($voucher['expiry_date']);?></td>
                        <td>
<?php if ($voucher['voucher_status'] == 0):?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                    <input type="submit" name="inactive-<?php echo $voucher['voucher_id'];?>" value="Inactive" onClick="active_status(<?php echo $voucher['voucher_id'];?>);" class="btn-active hidden" id="inactive-<?php echo $voucher['voucher_id'];?>">
                                </label>
<?php  else :?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    <input type="submit" name="active-<?php echo $voucher['voucher_id'];?>" value="Active" onClick="active_status(<?php echo $voucher['voucher_id'];?>);" class="btn-active hidden" id="active-<?php echo $voucher['voucher_id'];?>">
                                </label>
<?php endif;?>
</td>
                    </tr>
<?php $i++;?>
                <?php endforeach;?>
</tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <ul class="pagination">
<?php echo $this->pagination->create_links();?>
</ul>
                    </td>
                </tr>
            </tfoot>
        </table>
<?php endif;?>
</div>
</form>
