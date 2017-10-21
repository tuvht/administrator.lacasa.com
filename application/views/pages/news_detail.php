<form class="form-horizontal" action="<?php echo base_url() . 'news-detail/' . $news_id; ?>" method="post">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" value="Save" />
		<a class="btn btn-danger" href="<?php echo base_url() . 'news'; ?>">Cancel</a>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[title]">Title: </label>
		<div class="col-sm-10">
			<input class="form-control" id="title" type="text" name="data[title]" value="<?php echo !empty($detail) ? $detail['title'] : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[content]">Content: </label>
		<div class="col-sm-10">
			<?php
				$data['name'] = "data[content]";
				$data['id'] = "content";
				$data['class'] = "form-control tinymce";
				$data['value'] = !empty($detail) ? $detail['content'] : '';
				$this->load->view('templates/tinymce', $data);
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[datetime]">Create date: </label>
		<div class="col-sm-10">
			<input class="form-control" id="datetime" readonly type="text" name="data[datetime]" value="<?php echo !empty($detail) ? $detail['datetime'] : date('Y-m-d'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="data[status]">Status: </label>
		<div class="col-sm-10 controls-txt text-left">
			<label>
			<input class="form-control" id="voucher_status_no" type="radio" name="data[status]" value="0" checked="checked" <?php echo (!empty($detail) && $detail['status'] == 0) ? 'checked="checked"' : '' ?>/>
			Unpublished
			</label>
			<label>
			<input class="form-control" id="voucher_status_yes" type="radio" name="data[status]" value="1" <?php echo (!empty($detail) && $detail['status'] == 1) ? 'checked="checked"' : '' ?>/>
			Published
			</label>
		</div>
	</div>
</form>
