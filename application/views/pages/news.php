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
<?php if (!empty($msg)): ?>
<div class="alert alert-<?php echo $msg['type']; ?>" role="alert"><?php echo $msg['text']; ?></div>
<?php endif; ?>
<form method="post" action="<?php echo base_url() . 'news' ?>" name="form" id="cus_form">
    <div class="container">
        <div class="pull-left">
            <a href="<?php echo base_url() . 'news-detail'; ?>" class="btn btn-primary">Add</a>
        </div>
        <?php if (count($news) == 0) : ?>
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Notice!</strong> Empty News
            </div>
        <?php else: ?>
        <table id="table-form" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><a href="?order=id&dir=<?php echo $order_dir; ?>">News ID</a></th>
                    <th width="10%"><a href="?order=title&dir=<?php echo $order_dir; ?>">Title</a></th>
                    <th width="10%"><a href="?order=datetime&dir=<?php echo $order_dir; ?>">Join date</a></th>
                    <!-- <th width="10%"><a href="?order=status&dir=<?php echo $order_dir; ?>">Type</a></th> -->
                </tr>
            </thead>
            <tbody id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i = 1 ; ?>
                <?php foreach ($news as $key => $value): ?>
                    <tr>
                        <td>
                        <span class="hide">
                            <input id="check-<?php echo $value['id']; ?>" type="checkbox" name="selected[]" value="<?php echo $value['id']; ?>"/>
                        </span>
                        <?php echo $value['id']; ?></td>
                        <td><a href="<?php echo base_url() . 'news-detail/' . $value['id'] ?>"><?php echo $value['title']; ?></a></td>
                        <td><?php echo dateFormat($value['datetime']); ?></td>
                        <!-- <td>
                            <?php if ($value['status'] == 0) : ?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                    <input type="submit" name="inactive-<?php echo $value['id']; ?>" value="Inactive" onClick="active_status(<?php echo $value['id']; ?>);" class="btn-active hidden" id="inactive-<?php echo $value['id']; ?>">
                                </label>
                            <?php else: ?>
                                <label class="icon-switch">
                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    <input type="submit" name="active-<?php echo $value['id']; ?>" value="Active" onClick="active_status(<?php echo $value['id']; ?>);" class="btn-active hidden" id="active-<?php echo $value['id']; ?>">
                                </label>
                            <?php endif; ?>
                        </td> -->
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <ul class="pagination" id="pagination">
                            <?php echo $this->pagination->create_links(); ?>
                        </ul>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>
    </div>
</form>
