<table class="table table-striped">
    <?php foreach ($product_detail['criteria'] as $key => $criteria): ?>
    <tr>
        <th width="20%">Criteria</th>
        <th width="20%">Last review</th>
        <th width="20%">Last update</th>
        <?php foreach ($product_detail['check'] as $key => $check): ?>
            <?php if ($criteria['criteria_id'] == $check['criteria_id']) : ?>
                <?php if ($check['product_check_result'] == 0) : ?>
                    <th class="pass-<?php echo $check['criteria_id']; ?>" width="20%">Result</th>
                    <th class="pass-<?php echo $check['criteria_id']; ?>" width="20%">Detail</th>
                <?php else: ?>
                    <th></th>
                    <th></th>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
    <tr>
        <?php foreach ($product_detail['check'] as $key => $check): ?>
            <?php if ($criteria['criteria_id'] == $check['criteria_id']) : ?>
                <td><span id="ico-<?php echo $check['criteria_id']; ?>" class="glyphicon <?php echo $check['product_check_result'] == 0 || $check['product_check_result'] == 2 ? 'glyphicon-minus' : 'glyphicon-ok' ?>"></span><?php echo $criteria['criteria_name'] ?></td>
                <td><?php echo dateFormat(date('Y-m-d')); ?></td>
                <td><?php echo dateFormat(date('Y-m-d')); ?></td>
                <?php if ($check['product_check_result'] == 0 || $check['product_check_result'] == 2) : ?>
                <td class="pass-<?php echo $check['criteria_id']; ?>">
                    <select name="result" id="result_<?php echo $criteria['criteria_id'] ?>">
                        <option <?php echo $check['product_check_result'] == 1 ? 'selected="selected"' : ''; ?> value="1">Pass</option>
                        <option <?php echo $check['product_check_result'] == 0 || $check['product_check_result'] == 2 ? 'selected="selected"' : ''; ?> value="0">Fail</option>
                    </select>
                </td>
                <td class="pass-<?php echo $check['criteria_id']; ?>">
                <textarea name="detail" class='text-criteria' cols="20" rows="3" id="detail_<?php echo $criteria['criteria_id'] ?>"><?php echo !empty($check['product_check_notes']) ? $check['product_check_notes'] : ''; ?></textarea>
                <a class="btn btn-success save-criteria" criteria="<?php echo $criteria['criteria_id'] ?>" id="save-<?php echo $criteria['criteria_id'] ?>">Save</a>
                </td>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
</table>
