<div class="form-group">
	<label class="col-sm-2 control-label" for="content[about_us]">About us: </label>
	<div class="col-sm-10">
		<?php
			$data = array();
			$data['name'] = "content[about_us]";
			$data['id'] = "about_us";
			$data['class'] = "form-control tinymce";
			$data['value'] = !empty($content) ? $content['about_us'] : '';
			$this->load->view('templates/tinymce', $data); 
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="content[contact_us]">Contact us: </label>
	<div class="col-sm-10">
		<?php 
			$data = array();
			$data['name'] = "content[contact_us]";
			$data['id'] = "contact_us";
			$data['class'] = "form-control tinymce";
			$data['value'] = !empty($content) ? $content['contact_us'] : '';
			$this->load->view('templates/tinymce', $data); 
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="content[faq]">FAQ: </label>
	<div class="col-sm-10">
		<?php 
			$data = array();
			$data['name'] = "content[faq]";
			$data['id'] = "faq";
			$data['class'] = "form-control tinymce";
			$data['value'] = !empty($content) ? $content['faq'] : '';
			$this->load->view('templates/tinymce', $data); 
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="content[shipping_policy]">Shipping policy: </label>
	<div class="col-sm-10">
		<?php 
			$data = array();
			$data['name'] = "content[shipping_policy]";
			$data['id'] = "shipping_policy";
			$data['class'] = "form-control tinymce";
			$data['value'] = !empty($content) ? $content['shipping_policy'] : '';
			$this->load->view('templates/tinymce', $data); 
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="content[return_policy]">Return policy: </label>
	<div class="col-sm-10">
		<?php 
			$data = array();
			$data['name'] = "content[return_policy]";
			$data['id'] = "return_policy";
			$data['class'] = "form-control tinymce";
			$data['value'] = !empty($content) ? $content['return_policy'] : '';
			$this->load->view('templates/tinymce', $data); 
		?>
	</div>
</div>