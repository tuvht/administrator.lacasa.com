

<?php
    $username= $_GET['name'];
    $link=$_GET['link'];

?>
<html>
<div>Dear <?php echo $username; ?>,</div>

<div>
Please click on the link below to proceed changing your password.<br />
If this change request is not expected by you, please help to change your account password for safety.<br />
<br />
<?php echo $link;?>
</div>

<div>
<br />
Should you have any question, feel free to <a href="http://shotlancer.com/customer/support">contact us </a> anytime.
<br />
Thanks and regards<br />
ShotLancer Team.

</div>

</html>