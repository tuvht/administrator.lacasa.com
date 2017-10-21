

<body style="background-color: #f8f8f8">
<div class="container-fullwidth">
    <div class="info_base_container"  style="margin: auto;width: 50%;">
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div>
            <div class="visible-lg col-lg-6">
                <form name="form_cuslogin" method="POST" action="customer/login">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-3" style="text-align:right;">Username:</div>
                            <div class="col-lg-9" style="text-align:left"><input class="form-control" type="text" id="admin_un" required="true"/></div>
                        </div>    
                        <div class="row" style="text-align:left">
                            <div class="col-lg-3" style="text-align:right;">Password:</div>
                            <div class="col-lg-9" style="text-align:left"><input class="form-control" type="password" id="admin_pw" required="true"/></div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-9"><input class="btn btn-primary" style="color:white;" type="button" name="btn_submit" value="Login" onclick ="adminlogin();"/></div>
                            <div class="col-lg-3"></div>
                        </div>    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
</body>

<script type="text/javascript">

function adminlogin()
{
    adminlogin_process (document.getElementById("admin_un").value,document.getElementById("admin_pw").value);
}

</script>
