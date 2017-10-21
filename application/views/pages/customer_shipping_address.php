<!-- <?php structure($address_list)?> -->
<?php if (!empty($address_list)):?>
    <table id="table-form" class="table table-striped">
        <thead>
            <tr>
                <th width="3%">Address ID</th>
                <th width="20%">Address</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($address_list as $address):?>
                <tr>
                	<th width="3%"><?=$address['addr_id']?></th>
                    <th width="20%"><?= $address['addr_street'].' '.$address['district_name'].' '.$address['city_name'].' '.$address['country_name']?></th>
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
        <strong>Notice!</strong> Empty Address
    </div>
<?php endif;?>
