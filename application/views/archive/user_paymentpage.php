


<script type="text/javascript">
    
    <?php
        $phpVar = $this->session->userdata('imagekash_username');
        echo "var session_username = '{$phpVar}';";
        $phpVar = $this->session->userdata('imagekash_user_imageplan');
        echo "var session_plan = '{$phpVar}';";
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
    
    function user_purchaseimageslot()
    {
        $.ajax({
           
            type:"post",
            url:"http://kiemtraweb.vn/user/dopayment",
            data:{
                userreg_payment: $('input[name=userreg_payment]:checked').val(),
                userreg_creditcardnum: document.getElementById("userreg_creditcardnum").value,
                userreg_creditcardname: document.getElementById("userreg_creditcardname").value,
                userreg_creditcardtype: document.getElementById("userreg_creditcardtype").value,
                userreg_creditcarddate: document.getElementById("userreg_creditcarddate").value,
                userreg_creditcardcvv: document.getElementById("userreg_creditcardcvv").value,
                userreg_paypalaccount: document.getElementById("userreg_paypalaccount").value
                },
            beforeSend: function ( xhr ) {
               $.blockUI({ message: '<h1>Please wait...</h1>'});
            },
            success:function(data){
                $.unblockUI();
                window.location="http://kiemtraweb.vn/user/home";;                    
            }
        });    
    }
    
</script>

<table>
    <form id="form_user_payment" method="POST">
        <tr>
            <td>Choose payment method</td>
            <td>           
                <input type="radio" id="userreg_payment" name="userreg_payment" value="credit" onclick="showcreditdiv()" /> Credit card <br /> 
                <input type="radio" id="userreg_payment" name="userreg_payment" value="paypal" onclick="showpaypaldiv()"/>Paypal<br />
            </td>
        </tr>

        <tr id="tr_cardnumber" hidden="TRUE" >
            <td>Credit card number:</td>
            <td><input type="text" id="userreg_creditcardnum" name="userreg_creditcardnum" size="50" /></td>
        </tr>
        <tr id="tr_cardname" hidden="TRUE" >
            <td>Name on card: </td>
            <td><input type="text" id="userreg_creditcardname" name="userreg_creditcardname" size="40" /></td>
        </tr>
        <tr id="tr_cardtype" hidden="TRUE">
            <td>Credit card type</td>
            <td><input type="text" id="userreg_creditcardtype" name="userreg_creditcardtype" size="30" /></td>
        </tr>
        <tr id="tr_carddate" hidden="TRUE">
            <td>Expiration date: </td>
            <td><input type="text" id="userreg_creditcarddate" name="userreg_creditcarddate" size="30" /></td>
        </tr>
        <tr id="tr_cardcvv" hidden="TRUE" >
            <td>CVV: </td>
            <td><input type="text" id="userreg_creditcardcvv" name="userreg_creditcardcvv" size="30" /></td>
        </tr>
        <tr id="tr_paypalid" hidden="TRUE" >
            <td>Your Paypal ID: </td>
            <td><input type="text" id="userreg_paypalaccount" name="userreg_paypalaccount" size="30" /></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" name="btn_submit" value="Purchase credits" onclick ="user_purchaseimageslot()"/></td>
        </tr>
    </form>
    
</table>