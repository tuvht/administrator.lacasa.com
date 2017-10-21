<?php $this->load->view('templates/header.php');?>
<div class="container-fullwidth" >
	<div class="col-md-2 sidebar1">
<?php $this->load->view('templates/module_menu_orders.php');?>
</div>
	<div class="col-md-10 bodycontent">
<?php $this->load->view($subcontent);?>
</div>
</div>
<?php $this->load->view('templates/footer.php');?>