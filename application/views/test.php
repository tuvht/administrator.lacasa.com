<!-- javascript to handle form submission and login submisson
<link rel="stylesheet" href="/application/libraries/javascript/js/jquery-ui-1.11.1.custom/jquery-ui.min.css"/>-->
<link rel="stylesheet" href="/application/views/css/default.css"/>
<link rel="icon" href="/application/views/images/favicon.png" type="image/png" />
<script type="text/javascript" src="/application/libraries/javascript/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="/application/libraries/javascript/shotlancer.js"></script>

<!DOCTYPE html>
<meta lang="en" />
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <title>ShotLancer</title>
    <meta content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=cyrillic,latin' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css' />
    <link rel="icon" href="/application/views/images/favicon.png" type="image/png" />
</head>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>

<header>
<div class="container">

<div class="row">
  <div class="col-md-4">
    <a href="/"><img src="/application/views/images/logo.png" width="120" height="71" /></a>
  </div>
  <div class="col-md-8">
    <span id="main_title">Welcome to ShotLancer, all the photographers you need are here!</span>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <span class="promotion_text"> There are thousands of true images available
        <a href="/customer/register" style="color:lightsteelblue;font-weight:bold">Register</a> today for best deal!
    </span>
  </div>
  <div class="col-md-6">
    <form name="form_cuslogin" method="POST" action="customer/login">
        <table style="width:100%;border-collapse: collapse;border: 1px white;">
            <tr><td  style="text-align:center"><span style="width: 100%;text-align: center;font-size: small;color: lightsteelblue; font-family: cursive;">
                Already a member?</span></td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr><td style="width:30%;text-align:right;"><span class="header_login_field">Username:</span></td><td><input type="text" id="cus_un" name="cus_un" required="true"/></td></tr>
                        <tr><td style="width:30%;text-align:right;"><span class="header_login_field">Password:</span></td><td><input type="password" id="cus_pw" name="cus_pw" required="true"/></td></tr>
                    </table>
                </td>
                <td style="text-align:left;width: 100%; color: darkgray;font-size: xx-small;"><input class="standard-button" style="color:white;" type="button" name="btn_submit" value="Login" onclick ="customerlogin();"/></td>
            </tr>
        </table>     
    </form>
  </div>
  <div class="col-md-2">
    <table style="margin:20;width:100%;border-collapse: collapse;border: 1px transparent;">
        <tr>
            <td style="text-align: left;color: white;">
                <div style="display:table;background-image: url(/application/views/images/favorite.png);height: 40px; width: 40px; no-repeat;">
                    <span style="display: table-cell;margin: auto; vertical-align: middle; text-align: center;font-weight: bold;font-style: italic;color:black;" id="header_favorite"></span>
                </div>
                <div><a href="" onclick="clearfavorite();" style="color:lightsteelblue;">Clear</a></div>
            </td>
        </tr>
    </table>
  </div>
  
</div>


</header>
<body>

<div class="row">
    <ul style="margin: 0x auto ;display: inline-block;">
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        <li style="display: inline;"><img width="150" height="150" src="http://shotlancer.com/products/thumb/users/user2/ShotLancer_8383329042015033327square.jpg" /></li>
        
    </ul>
</div>
    

</body>
</div>
</html>

<script type="text/javascript">
    
    <?php
        $phpVar = $this->session->userdata('imagekash_cus_username');
        echo "var session_username = '{$phpVar}';";
        
        $favorite=$this->session->userdata('sl_favoriteitems');
        $count=$this->session->userdata('sl_favoritecount');
        
        echo "var favoritecount = '{$count}';";
        
    ?>

    $( document ).ready(function() {
        //cusgetcredit_process(session_username);
        $('#header_favorite').html(favoritecount);
    });
    
    function customerlogin()
    {customerlogin_process (document.getElementById("cus_un").value,document.getElementById("cus_pw").value);} 
    
    function customerlogout()
    {customerlogout_process (session_username);} 
    
</script>