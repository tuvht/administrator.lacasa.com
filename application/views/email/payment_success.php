<?php
    $purchase_id= $_GET['purchase_id'];
    $transaction_id= $_GET['transaction_id'];
    $username = $_GET['username'];
    $no_of_credits = $_GET['no_of_credits'];
  

?>
<html>
<div>Dear <?php echo $username; ?>,</div>

<div>
Thank you for your last purchase with ShotLancer.com<br />
We would like gladly inform you that your payment has been processed succesfully and <?php echo $no_of_credits; ?> credit(s) have been added to your account<br />
<br />
We appreciate your usage at ShotLancer and we are on our way to serve better.
Enjoy your pictures!
</div>

<div>
<br />
Should you have any question, feel free to <a href="http://shotlancer.com/customer/support">contact us </a> anytime.
<br />
Thanks and regards<br />
ShotLancer Team.

</div>

</html>