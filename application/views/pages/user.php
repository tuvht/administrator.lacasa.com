<?php
    echo '<a href="' . base_url() . 'logout">Logout</a><br>';

    echo '<a href="' . base_url() . 'edit-user">Edit</a><br>';
    echo '<a href="' . base_url() . 'purchase-history">Purchase history</a><br>';
    echo '<a href="' . base_url() . 'shipping-address">Shipping address</a><br>';
    echo '<pre>';
    print_r($user_info);
    echo '</pre>';
?>
