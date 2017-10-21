<!-- <?php structure($history)?> -->
<?php if (!empty($history)):?>
    <table id="table-form" class="table table-striped">
        <thead>
            <tr>
                <!-- <a href="?order=order_date&dir=<?php echo $order_dir;?>"> -->
                <th width="3%">Order date</th>
                <th width="2%">Order ID</th>
                <th width="20%">Product Name</th>
                <th width="3%">Total</th>
                <th width="5%">Order Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $key => $order_history):?>
                <tr>
                    <th width="2%"><?= $order_history['order_date']?></th>
                    <th width="2%"><a href="<?php echo base_url().'order-detail/'.$order_history['order_id'];?>"><?= $order_history['order_id']?></a></th>
                    <th width="20%">
                    <?php foreach ($order_history['items'] as $keyitem => $item):?> 
                        <div><?= $item['prod_name']?></div>
                    <?php endforeach;?>
                    </th>  
                    <th width="1%">$<?= $order_history['total_price']?></th>
                    <th width="5%"><?=$order_history['order_status_name']?></th>
                </tr>
            <?php endforeach;?>            
        </tbody>
        <!-- <tfoot>
            <tr>
                <td colspan="15">
                    <ul class="pagination" id="pagination"><?php echo $this->pagination->create_links();?></ul>
                </td>
            </tr>
        </tfoot> -->
    </table>
<?php else:?>
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Notice!</strong> Empty Order
    </div>
<?php endif;?>