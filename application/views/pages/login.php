<?php
    $email = array(
                        'name'        => 'email',
                        'id'          => 'log-email',
                        'size'        => '25',
                    );
    $password = array(
                        'name'        => 'password',
                        'id'          => 'log-password',
                        'size'        => '25',
                    );


$this->load->view('templates/header.php');

echo validation_errors();

    if (!empty($error))
        echo $error;
?>

<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-9">
            <img src="<?php echo base_url()?>/application/views/images/loginimg.jpg" alt="loginimage" style="width: 100%;" />
        </div>
        <div class="col-md-3">
            <form action="<?php echo base_url() . "login" ?>" method="post" accept-charset="utf-8" class="loginform">
            <?php
                echo form_fieldset("Login");
                if ( isset($msg) ) {
                    echo '<div class="alert">'.$msg.'</div>';
            ?>
                <script type="text/javascript">
                    setTimeout(function(){
                        jQuery('.alert').remove();
                    }, 5000);
                </script>
            <?php
                }
            ?>
            <div class="form-group">
                <input type="text" name="<?php echo $email['name']?>" value="" id="<?php echo $email['id']?>" size="<?php echo $email['size']?>" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="<?php echo $password['name']?>" value="" id="<?php echo $password['id']?>" size="<?php echo $password['size']?>" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login" class="btn btn-success">
            </div>
            <div class="form-link"><?php
                echo "<a href='" . base_url() . "fg_password'>Forgot Password</a><br/>";
            ?></div>
            <?php echo form_fieldset_close();?>
            </form>
        </div>
    </div>
</div>

<?php

    $this->load->view('templates/footer-login.php');

?>
