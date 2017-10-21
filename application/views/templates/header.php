<?php
include_once ("application/views/sasscompile/build.php");
?>

<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/shotlancer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/asiantech.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/js.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/sjs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/frontend.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/functionswiper.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/libraries/javascript/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>application/libraries/javascript/js/jquery-ui-1.11.4.custom/jquery-ui.css">

<!DOCTYPE html>
<meta lang="en" />
<html>
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1.5" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/libraries/bootstrap/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/libraries/bootstrap/css/bootstrap-theme.min.css" />
    <!-- Latest compiled and minified JavaScript -->

    <link href='https://fonts.googleapis.com/css?family=Hind:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="" href="<?=base_url().'application/views/css/SpinKit-master/css/spinners/style.css'?>">


<?php $config = json_decode($this->model_config->get_config_by_name('main_config'));?>
    <title><?php echo $config->title;?></title>
    <meta content="text/html" charset="utf-8" />
    <link rel="icon" href="<?php echo base_url().'images/banners/'.$config->favicon;?>" />
    <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/styles.css"/>
</head>

<div class="container-fullwidth">

<header>
<?php
$supplier_title = "Administrator";
?>

<div class="logobar toolbar">
    <div class="col-sm-3 logo text-left">
        <a href="<?php echo base_url();?>" ><?php echo $supplier_title;
?></a>
    </div>
    <div class="col-sm-9 text-right">

        <div class="col-md-6">
            <div class="row hidden-lg">
                    <div class="col-xs-2 col-sm-2 col-md-2 hidden">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Menu <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" >
                            <li><input type="button" class="btn btn-link" value="Help" /></li>
                            <li><input type="button" class="btn btn-link" value="About us" /></li>
                        </ul>
                      </div>
                      <div class="col-xs-11 col-sm-11 col-md-7">
                        <input type="text" class="form-control"/><button class="btn btn-link"><span class="glyphicon glyphicon-search"></span></button>
                      </div>
                      <div class="col-xs-1 col-sm-1 col-md-3">

                      </div>
            </div>
        </div>

        <div class='mod-login'>
<?php if (empty($email)):?>
            <ul>
                <li><a href="<?php echo base_url();?>login">SIGNIN</a></li>

            </ul>
<?php  else :?>
            <ul>
                <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo $email;?></li>
                <li><a href="<?php echo base_url().'logout'?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
<?php endif;?>
</div>
    </div>
</div>


</header>
</div>
