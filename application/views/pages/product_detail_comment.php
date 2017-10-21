<table class="table table-striped">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="70%">Comment</th>
            <th width="10%">Date</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($criteria as $i => $value):?>
<tr>
                                            <td>
<?php echo ($i+1);?>
</td>
                                            <td>
<?php echo $value['product_check_notes'];?>
</td>
<?php if ($value['product_check_result'] == 2):?>
<td>Not view yet</td>
                                                <td>Not view yet</td>
<?php  else :?>
<td>
<?php echo dateFormat($value['product_check_time']);?>
</td>
                                                <td>
<?php if ($value['product_check_result'] == 0):?>
<label>
                                                        Inactive
                                                    </label>
<?php  else :?>
<label>
                                                        Active
                                                    </label>
<?php endif;?>
</td>
<?php endif;?>
</tr>
<?php endforeach;?>
</tbody>

</table>
