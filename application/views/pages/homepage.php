<link rel="stylesheet" type="text/css" href="application/libraries/javascript/js/jquery-ui-themes-1.11.4/themes/excite-bike/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="application/libraries/javascript/js/jquery-ui-themes-1.11.4/themes/excite-bike/theme.css">

<script type="text/javascript" src="application/libraries/javascript/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script type="text/javascript">

jQuery (document).ready(function(){
         $(function() {
            $( "#menu" ).menu();
            });
    });
</script>
<style>
.ui-menu { width: 150px; }
</style>

<body>

<div class="container-fullwidth">
	<div class="col-md-2 sidebar1">
<?php $this->load->view('templates/module_menu_orders');?>
</div>
	<div class="col-md-10 bodycontent">

		<div class="container text-left">
			<div class="row">
<?php $this->load->view('templates/module_count_orders');?>

				<div class="col-md-3 col-sm-3 maincontent">
					<h3 class="text-left">Title</h3>
					<div class="content text-left hidden">
						<img src="<?php echo base_url()?>/application/views/images/loginimg.jpg" alt="loginimage" style="width: 100%;" />
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="row">
<?php $this->load->view('templates/module_order_revenue');?>
</div>
				</div>
			</div>
		</div>
<?php $this->load->view('templates/homepage_chart');?>
</div>
</div>

</body>

<script type="text/javascript">


function adminlogin()
{
    adminlogout_process (document.getElementById("admin_un").value);
}

</script>
