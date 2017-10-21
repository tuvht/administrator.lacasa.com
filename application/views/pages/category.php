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
function active_status(id) {
    var check = jQuery('#check-'+id).attr('checked', 'checked');
    jQuery('form[name=form]').submit();
}
</script>
<?php if (!empty($msg)):?>
<div class="alert alert-<?php echo $msg['type'];?>" role="alert"><?php echo $msg['text'];
?></div>
<?php endif;?>
<form method="post" action="<?php echo base_url().'category'?>" name="form">
    <div class="container">
    <span>Name Search</span>
        <div class="control-group">
            <div class="pull-left">
                <a href="<?php echo base_url().'category-detail';?>" class="btn btn-primary">Add</a>
            </div>
            <div class="btn-group">
                <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
                <span class="input-group-btn">
                    <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                    <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
                </span>
            </div>
        </div>
<?php if (count($categories) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Category
            </div>
<?php  else :?>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="10%"><a href="?order=p.par_cat_name&dir=<?php echo $order_dir;?>">Category</a></th>
                    <th width="10%"><a href="?order=p.par_cat_id&dir=<?php echo $order_dir;?>">ID</a></th>
                    <th width="10%"><a href="?order=m.mas_cat_id&dir=<?php echo $order_dir;?>">Master</th>

                    <th width="10%"><a href="?order=subcat&dir=<?php echo $order_dir;?>">Sub category</th>
                    <th width="10%"><a href="?order=p.par_cat_status&dir=<?php echo $order_dir;?>">Action</a></th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($categories as $key => $category):?>
                    <tr>
                        <td><a href="<?php echo base_url().'category-detail/'.$category['par_cat_id'];?>"><?php echo $category['par_cat_name']?></a></td>
                        <td><?php echo $category['par_cat_id']?></td>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $category['par_cat_id'];?>" type="checkbox" name="selected[]" value="<?php echo $category['par_cat_id'];?>"/>
                        </span>
<?php echo $category['mas_cat_name'];?></td>
                        <td><?php echo $category['subcat']?></td>
                        <td>
<?php if ($category['par_cat_status'] == 0):?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                    <input type="submit" name="inactive-<?php echo $category['par_cat_id'];?>" value="Inactive" onClick="active_status(<?php echo $category['par_cat_id'];?>);" class="btn-active hidden" id="inactive-<?php echo $category['par_cat_id'];?>">
                                </label>
<?php  else :?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    <input type="submit" name="active-<?php echo $category['par_cat_id'];?>" value="Active" onClick="active_status(<?php echo $category['par_cat_id'];?>);" class="btn-active hidden" id="active-<?php echo $category['par_cat_id'];?>">
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
