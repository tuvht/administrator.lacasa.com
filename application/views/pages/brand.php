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
<form method="post" action="<?php echo base_url().'brand'?>" name="form" id="cus_form">
    <div class="container">
        <div class="control-group">
            <div class="pull-left">
                <a href="<?php echo base_url().'add-brand';?>" class="btn btn-success">Add</a>
            </div>
            <div class="btn-group">
                <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
                <span class="input-group-btn">
                    <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                    <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
                </span>
            </div>
        </div>
    <h6>Name Search</h6>
<?php if (count($items) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Brand
            </div>
<?php  else :?>
        <div class="pull-left text-left" style="margin-bottom: 15px;">
        </div>

        <div class="clearfix"></div>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="20%"><a href="?order=brand_name&dir=<?php echo $order_dir;?>">Name</a></th>
                    <th width="10%"><a href="?order=brand_id&dir=<?php echo $order_dir;?>">Brand ID</a></th>

                    <th width="15%"><a href="?order=brand_origin_country&dir=<?php echo $order_dir;?>">Country</a></th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($items as $key => $item):?>
                    <tr>
                        <!-- href="<?php echo base_url().'brand-detail/'.$item['brand_id']?>" -->
                        <td><span ><?php echo $item['brand_name'];?></span></td>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $item['brand_id'];?>" type="checkbox" name="selected[]" value="<?php echo $item['brand_id'];?>"/>
                        </span>
<?php echo $item['brand_id'];?></td>

                        <td><?php echo $item['brand_origin_country'];?></td>
                        <td>  <a href="<?=base_url().'edit-brand/'.$item['brand_id']?>"> <button type="button" class="btn btn-info"> Edit </button></a></td>
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
