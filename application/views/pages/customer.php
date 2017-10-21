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
function type_submit(type) {
    var action = jQuery('#cus_form').attr('action');
    var type_id = jQuery(type).val();
    var redirect = action + '?type=' + type_id;
    window.location = redirect;

}
function active_status(id) {
    var check = jQuery('#check-'+id).attr('checked', 'checked');
    jQuery('form[name=form]').submit();
}
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>
<form method="post" action="<?php echo base_url().'customer'?>" name="form" id="cus_form">
    <div class="container">
    <span>Name Search</span>
        <div class="pull-left text-left control-group" style="margin-bottom: 15px;">
            <select name="cus_type" onchange="type_submit(this);">
                <option value="">Select</option>
<?php foreach ($types as $k => $type):?>
                    <option <?php echo $type['customer_type_id'] == $type_select?'selected="selected"':'';
?> value="<?php echo $type['customer_type_id']?>"><?php echo ucfirst($type['customer_type_name']);
?></option>
<?php endforeach;?>
</select>
        <div class="btn-group">
            <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
            <span class="input-group-btn">
                <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
            </span>
        </div>
    </div>
<?php if (count($customers) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Customer
            </div>
<?php  else :?>
        <div class="clearfix"></div>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="10%"><a href="?order=c.cus_name&dir=<?php echo $order_dir;?>">Name</a></th>
                    <th width="5%"><a href="?order=c.cus_id&dir=<?php echo $order_dir;?>">Customer ID</a></th>

                    <th width="10%"><a href="?order=c.cus_email&dir=<?php echo $order_dir;?>">Email</a></th>
                    <th width="10%"><a href="?order=c.cus_phone&dir=<?php echo $order_dir;?>">Phone</a></th>
                    <th width="10%"><a href="?order=c.cus_join_date&dir=<?php echo $order_dir;?>">Join date</a></th>
                    <th width="10%"><a href="?order=c.cus_type&dir=<?php echo $order_dir;?>">Type</a></th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($customers as $key => $customer):?>
                    <tr>
                        <td><a href="<?php echo base_url().'customer-detail/'.$customer['cus_id']?>"><?php echo $customer['cus_name'];?></a></td>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $customer['cus_id'];?>" type="checkbox" name="selected[]" value="<?php echo $customer['cus_id'];?>"/>
                        </span>
<?php echo $customer['cus_id'];?></td>
                        <td><?php echo $customer['cus_email'];?></td>
                        <td><?php echo $customer['cus_phone'];?></td>
                        <td><?php echo dateFormat($customer['cus_join_date']);?></td>
                        <td><?php echo $customer['customer_type_name'];?></td>
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
