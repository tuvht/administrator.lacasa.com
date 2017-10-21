<link rel="stylesheet" href="http://kiemtraweb.vn/application/libraries/javascript/js/jquery-ui-1.11.1.custom/jquery-ui.css"/>
<script type="text/javascript" src="http://kiemtraweb.vn/application/libraries/javascript/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="http://kiemtraweb.vn/application/libraries/javascript/js/jquery-ui-1.11.1.custom/jquery-ui.js"> </script>
<script type="text/javascript" src="http://kiemtraweb.vn/application/libraries/javascript/js/jquery.blockUI.js"> </script>


<script type="text/javascript">
    
    <?php
        $phpVar = $this->session->userdata('imagekash_cus_username');
        echo "var session_username = '{$phpVar}';";
        $phpVar = $this->session->userdata('imagekash_cus_creditplan');
        echo "var session_plan = '{$phpVar}';";
        $phpVar = $this->session->userdata('imagekash_cus_returnpicurl');
        echo "var session_url = '{$phpVar}';";
    ?>
    
    function showcreditdiv()
    {
        $("#tr_cardname").show();
        $("#tr_cardnumber").show();
        $("#tr_cardtype").show();    
        $("#tr_carddate").show();
        $("#tr_cardcvv").show();
        
        $("#tr_paypalid").hide();
    }
    
    function showpaypaldiv()
    {
        $("#tr_paypalid").show();
        
        $("#tr_cardname").hide();
        $("#tr_cardnumber").hide();
        $("#tr_cardtype").hide();    
        $("#tr_carddate").hide();
        $("#tr_cardcvv").hide();
    }
    
    function cus_downloadimage()
    {
        $.ajax({
           
            type:"post",
            url:"http://kiemtraweb.vn/customer/dopayment",
            data:{
                cusreg_payment: $('input[name=cusreg_payment]:checked').val(),
                cusreg_creditcardnum: document.getElementById("cusreg_creditcardnum").value,
                cusreg_creditcardname: document.getElementById("cusreg_creditcardname").value,
                cusreg_creditcardtype: document.getElementById("cusreg_creditcardtype").value,
                cusreg_creditcarddate: document.getElementById("cusreg_creditcarddate").value,
                cusreg_creditcardcvv: document.getElementById("cusreg_creditcardcvv").value,
                cusreg_paypalaccount: document.getElementById("cusreg_paypalaccount").value
                },
            beforeSend: function ( xhr ) {
               $.blockUI({ message: '<h1>Please wait...</h1>'});
            },
            success:function(data){
                $.unblockUI();
                window.location="http://kiemtraweb.vn/customer/home";;
      
                
                      
            }
        });    
    }
    
</script>

<table>
    <form id="form_cus_payemnt" method="POST" action="http://kiemtraweb.vn/customer/dopayment">
        <tr>
            <td>Choose payment method</td>
            <td>           
                <input type="radio" id="cusreg_payment" name="cusreg_payment" value="credit" onclick="showcreditdiv()" /> Credit card <br /> 
                <input type="radio" id="cusreg_payment" name="cusreg_payment" value="paypal" onclick="showpaypaldiv()"/>Paypal<br />
            </td>
        </tr>

        <tr id="tr_cardnumber" hidden="TRUE" >
            <td>Credit card number:</td>
            <td><input type="text" id="cusreg_creditcardnum" name="cusreg_creditcardnum" size="50" /></td>
        </tr>
        <tr id="tr_cardname" hidden="TRUE" >
            <td>Name on card: </td>
            <td><input type="text" id="cusreg_creditcardname" name="cusreg_creditcardname" size="40" /></td>
        </tr>
        <tr id="tr_cardtype" hidden="TRUE">
            <td>Credit card type</td>
            <td><input type="text" id="cusreg_creditcardtype" name="cusreg_creditcardtype" size="30" /></td>
        </tr>
        <tr id="tr_carddate" hidden="TRUE">
            <td>Expiration date: </td>
            <td><input type="text" id="cusreg_creditcarddate" name="cusreg_creditcarddate" size="30" /></td>
        </tr>
        <tr id="tr_cardcvv" hidden="TRUE" >
            <td>CVV: </td>
            <td><input type="text" id="cusreg_creditcardcvv" name="cusreg_creditcardcvv" size="30" /></td>
        </tr>
        <tr id="tr_paypalid" hidden="TRUE" >
            <td>Your Paypal ID: </td>
            <td><input type="text" id="cusreg_paypalaccount" name="cusreg_paypalaccount" size="30" /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" name="btn_submit" value="Purchase credits" onclick ="cus_downloadimage()"/></td>
        </tr>
    </form>
    
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="sale.online@huynhgiatien.com">
        <input type="hidden" name="lc" value="VN">
        <input type="hidden" name="item_name" value="test test">
        <input type="hidden" name="amount" value="5.00">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="button_subtype" value="services">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>

    
</table>