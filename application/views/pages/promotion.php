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
<span>Name Search</span>
<form method="post" action="<?php echo base_url().'promotion'?>" name="form">

    <div class="container control-group">
        <div class="pull-left">
            <a href="<?php echo base_url().'create-promotion';?>" class="btn btn-success">Add</a>
        </div>
        <div class="btn-group">
            <input value="<?php echo !empty($keyword)?$keyword:'';?>" type="text" class="form-control" name="keyword" placeholder="Search">
            <span class="input-group-btn">
                <input type="submit" name="search-button" class="btn btn-default" onClick="return search();" value="Search">
                <input type="submit" name="clear-button" class="btn btn-default" onClick="return document.form.submit();" value="Clear">
            </span>
        </div>
    </div>
<?php if (count($promotions) == 0):?>
<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty Promotion
            </div>
<?php  else :?>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="2%"></th>
                    <th width="10%"><a href="?order=p.promotion_name&dir=<?php echo $order_dir;?>">Name</a></th>
                    <th width="10%"><a href="?order=p.promotion_startdate&dir=<?php echo $order_dir;?>">Start date</a></th>
                    <th width="10%"><a href="?order=p.promotion_enddate&dir=<?php echo $order_dir;?>">End date</a></th>
                    <th width="10%"><a href="?order=p.promotion_type&dir=<?php echo $order_dir;?>">Type</a></th>
                    <th width="5%"><a href="?order=p.promotion_status&dir=<?php echo $order_dir;?>">Status</a></th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
<?php $i = 1;?>
                <?php foreach ($promotions as $key => $promotion):?>
                    <tr>
                        <td>
                            <a class="no-borders btn btn-default collapsed" data-parent="#accordion" role="button" data-toggle="collapse" href="#collapse<?php echo $promotion['promotion_id']?>" aria-expanded="true" aria-controls="collapse<?php echo $promotion['promotion_id']?>">
                            <i class="fa fa-chevron-right" ></i>
                            </a>
                        </td>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $promotion['promotion_id'];?>" type="checkbox" name="selected[]" value="<?php echo $promotion['promotion_id'];?>"/>
                        </span>
                        <a href="<?php echo base_url().'create-promotion/'.$promotion['promotion_type'].'/'.$promotion['promotion_detail_field'].'/'.$promotion['promotion_id'];?>"><?php echo $promotion['promotion_name'];
?></a></td>
                        <td><?php echo $promotion['promotion_startdate']?></td>
                        <td><?php echo $promotion['promotion_enddate'];?></td>
                        <td><?php echo $promotion['promotion_type_name'];?></td>
                        <td><?php echo $promotion['promotion_status'] == 1?'Active':'Inactive';?></td>
                        <td>
<?php if ($promotion['promotion_status'] == 0):?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                    <input type="submit" name="inactive-<?php echo $promotion['promotion_id'];?>" value="Inactive" onClick="active_status(<?php echo $promotion['promotion_id'];?>);" class="btn-active hidden" id="inactive-<?php echo $promotion['promotion_id'];?>">
                                </label>
<?php  else :?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    <input type="submit" name="active-<?php echo $promotion['promotion_id'];?>" value="Active" onClick="active_status(<?php echo $promotion['promotion_id'];?>);" class="btn-active hidden" id="active-<?php echo $promotion['promotion_id'];?>">
                                </label>
<?php endif;?>
                        </td>
                    </tr>
                    <tr class="collapse" id="collapse<?php echo $promotion['promotion_id'];?>">
                        <td colspan="10">
                            <table class="table" >
                                <thead>
<?php if ($promotion['promotion_type_id'] == 1):?>
<th width="20%">Products</th>
                                        <th width="20%">Value</th>
<?php  elseif ($promotion['promotion_type_id'] == 2):?>
<th width="20%">Value</th>
<?php  elseif ($promotion['promotion_type_id'] == 3):?>
<th width="20%">Products</th>
<?php endif;?>
</thead>
                                <tbody>
<?php foreach ($promotion['detail'] as $key => $item):?>
<tr>
<?php if ($promotion['promotion_type_id'] == 1):?>
                                            <td><?php echo $item['product']?></td>
<?php if ($item['field']['promotion_type_field_name'] == 'percentage'):?>
                                                <td><?php echo $item['detail'].'%'?></td>
<?php  elseif ($item['field']['promotion_type_field_name'] == 'amount'):?>
                                                <td><?php echo price($item['detail'])?></td>
<?php endif;?>
                                        <?php  elseif ($promotion['promotion_type_id'] == 2):?>
                                            <?php if ($item['field']['promotion_type_field_name'] == 'percentage'):?>
                                                <td><?php echo $item['detail'].'%'?></td>
<?php  elseif ($item['field']['promotion_type_field_name'] == 'amount'):?>
                                                <td><?php echo price($item['detail'])?></td>
<?php endif;?>
                                        <?php  elseif ($promotion['promotion_type_id'] == 3):?>
                                            <td><?php echo !empty($item['product'])?$item['product']:'Don`t have any products';?></td>
<?php endif;?>
</tr>
<?php endforeach;?>
</tbody>
                            </table>
                        </td>
                    </tr>
<?php $i++;?>
                    <div class="modal fade" id="orderModal<?php echo $promotion['promotion_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                        </div>
                      </div>
                    </div>
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
