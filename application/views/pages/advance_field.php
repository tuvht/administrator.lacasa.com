<?php foreach ($fields as $key => $field) : ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="prod_name"><?php echo $field['cat_field_name'] ?>: </label>
		<div class="col-sm-10">
			<input class="form-control" id="prod_<?php echo $field['cat_field_name'] ?>" type="text" name="form[<?php echo $field['cat_field_name'] ?>]" 
				<?php foreach ($detail_datas as $data): ?>
					<?php if ($field['cat_field_id'] == $data['prod_detail_catfield_id']): ?>
						value="<?php echo $data['data']; ?>"
					<?php endif; ?>
				<?php endforeach; ?>
			 />
		</div>
	</div>
<?php endforeach; ?>