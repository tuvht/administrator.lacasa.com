
    function validateemail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    }
    
    function showdialog_process(divhtml, dockcontrol, x , y, modal)
    {
        if (modal=='true')
        {
            var overlay = jQuery('<div class="overlay row" style="with:100%"><div id="popupdialog"></div></div>');
            overlay.appendTo(document.body);   
        }
        else
        {
            var overlay1 = jQuery('<div id="popupdialog"></div>');
            overlay1.appendTo(document.body);
        }
        if (dockcontrol=='')
        {
            var overlay1 = jQuery('<div id="popupdialog" class="row col-lg-6 col-xs-12 col-sm-12 col-md-12"></div>');
            overlay1.html('');
            overlay1
              .css({
                    'display':'table-cell',
                    'vertical-align': 'middle',
                    'align': 'center',
                    'margin': '0 auto',
                    '-webkit-border-radius': '4px',
                    '-moz-border-radius': '4px',
                    'border-radius': '4px',
                    '-moz-box-shadow': '0 0 0px transparent',
                    '-webkit-box-shadow': '0 0 0px transparent',
                    'box-shadow': '0px 0px 0px transparent',
                    'border': '0px solid black',
                    'font-family': 'serif',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%,-50%)',
                    'background': 'transparent',
                    'z-index': '11000'
                    
              });
        }
        else
        {
            var vartop=$("#"+dockcontrol).position().top + y;
            var varleft=$("#"+dockcontrol).position().left + x;
            var overlay1 = jQuery('<div id="popupdialog"></div>');
            overlay1.html('');
            overlay1
              .css({
                    '-webkit-border-radius': '4px',
                    '-moz-border-radius': '4px',
                    'border-radius': '4px',
                    '-moz-box-shadow': '0 0 0px whitesmoke',
                    '-webkit-box-shadow': '0 0 0px whitesmoke',
                    'box-shadow': '0px 0px 0px lightgrey',
                    'border': '0px solid black',
                    'font-family': 'serif',
                    'position': 'absolute',
                    'top': vartop,
                    'left': varleft,
                    'background': 'white',
                    'z-index': '11000'
                    
              });
        }
        
        overlay1.html(divhtml);
        overlay1.appendTo(document.body);
    }
    
    function removedialog_process ()
    {
        $( "div" ).remove( "#popupdialog" );
        $( "div" ).remove( ".overlay" );
    }
    
    function dialogclose_callback(url)
    {
        removedialog_process();
        if (url)
        {
            window.location=url;
        }
    }
    
    function showloading()
    {
        showdialog_process('<div><img width="39" height ="39" src="/application/views/images/loading.gif" /></div>','',0,0,'true');
    }
    
    function showerror()
    {
        var divhtml=   '<div class="alert alert-danger">'+
                            '<div><h3>Opps! There is something wrong</h3></div>'+
                            '<div><hr /></div>'+
                            '<div><span>Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.</span></div>'+
                            '<div><input type="button" class"btn btn-primary" value="Close" onclick="removedialog_process();" /></div>'
                        '</div>';
        showdialog_process(divhtml,'',-150,-150,'true');
    }
    
    function showfailure(title,msg,options,x,y)
    {
        var divhtml=   '<div class="alert alert-danger">'+
                            '<div><h3>'+title+'</h3></div>'+
                            '<div><hr /></div>'+
                            '<div><span>'+msg+'</span></div>';
                            if (options!=''){
                                divhtml=divhtml+ 
                                '<div>'+options+'</div>';
                            }
                            divhtml=divhtml+
                            '<div><hr /></div>'+
                            '<div><input type="button" class="btn btn-primary" value="Close" onclick="removedialog_process();"/></div>'+
                        '</div>';
                     showdialog_process(divhtml,'',x,y,'true');
    }
    
    
    function selectimage_process(ctrl, imageid,imagepath)
    {
        var overlay1 = jQuery('<div class="overlay" onmouseover="selectimage_process(this,'+ imageid +');" onmouseout="deselectimage_process(this,'+ imageid +');" ></div>');
        overlay1.html ('');
        overlay1
              .css({
                    'opacity': '0.6',
                    'position': 'absolute',
                    'top': $('#'+ctrl.id).position().top + ($('#'+ctrl.id).height()/3)*2 ,
                    'left': $('#'+ctrl.id).position().left,
                    'width':$('#'+ctrl.id).width(),
                    'height': $('#'+ctrl.id).height()/3,
                    'background': '#f9f9f9',
                    'z-index': '11000'
              });
        overlay1.html ('<input type="button" onclick = "addtofavorite(\''+ imageid +'\',\'' + imagepath + '\');" value="save for later" />');
        overlay1.appendTo(document.body);
    }
    
    
    function addtofavorite(ctrl,imageid,imagepath)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/addtofavorite",
            data: {image_id:imageid, image_path:imagepath},
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(resp){
                removedialog_process();
                if (resp=='false')
                {
                    showfailure('ERROR','Sorry, maximum 10 images in favorites only.','',-150,-150);
                }
                else
                {
                    $('#header_favorite').html(resp);
                    ctrl.src ='/application/views/images/favoriteblue.png';
                    ctrl.unbind('click');
                }
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function clearfavorite()
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/clearfavorite",
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(resp){
                removedialog_process();
                window.location='/';
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function removefavorite(ctrl,imageid,imagepath)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/removefavorite",
            data: {image_id:imageid, image_path:imagepath},
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(resp){
                removedialog_process();
                $('#header_favorite').html(resp);
                ctrl.src ='/application/views/images/favoriteblack.png';
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function deselectimage_process(ctrl, imageid)
    {
        removedialog_process();
    }
    
    function cusgetcredit_process(session_username)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/getnoofcredit",
            data:{cus_un: session_username},
            beforeSend: function ( xhr ) {
                
            },
            success:function(resp){
                 $('#cus_credit').html("You have " + parseInt(resp) + " credit(s) left");
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
           
        });        
    }
    
    function customerlogin_process(username,password)
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/login",
            data:{cus_un: username,cus_pw: password},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (parseInt(data)==2)
                {
                    window.location='http://shotlancer.com/customer/home';
                 }
                 else
                 {
                    showfailure('LOGIN FAILED','Sorry, system cannot recognize your account and password','<span style="float:left"><a href="http://shotlancer.com/customer/register">Register</a></span><span style="float:right"><a href="http://shotlancer.com/customer/forgotpassword">Forgot your password?</a></span>',150,-450);
                 }                            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function customerlogout_process(username)
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/logout",
            data:{cus_un: username},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="http://shotlancer.com";                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function customersubmitplan_process(plan,username)
    {
        $( "#item_name" ).val(plan + ' credits at shotlancer.com');
        switch (plan) {
            case '10':
                $( "#amount" ).val(1); //20
                break;
            case '25':
                $( "#amount" ).val(1); //35
                break;
            case '50':
                $( "#amount" ).val(1); //50
                break;
        }
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/dochooseplan",
            data:{
                cusreg_plan: plan
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $( "#custom" ).val(data);
                $("#form_paypal").submit();
                                   
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function checkcuslogin_process(mode,username,imagecredit,imageid,imagepath)
    {
        if (username == '')
        {
            window.location="http://shotlancer.com/customer/register";
        }
        else
        {
            cusdownloadimage_process(mode,username,imagecredit,imageid,imagepath);
            //checkcuscredit_process(mode,username,imagecredit,imageid,imagepath);
        }
    }
    
    function checkcuscredit_process(mode,username,imagecredit,imageid,imagepath)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/getnoofcredit",
            data:{cus_un: username},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(resp){
                removedialog_process();
                if(parseInt(resp)  < parseInt(imagecredit))
                {
                    showfailure('DOWNLOAD FAILED','Your account does not have enough credit left to download the picture, please purchase more.','<span><a href="http://shotlancer.com/customer/chooseplan">Purchase</a></span>',-150,-150);
                    preventDefault();        
                }
                else
                {         
                    cusdownloadimage_process(mode,username,imagecredit,imageid,imagepath);
                }                        
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });       
    }
    
    function cusdownloadimage_process(mode,username,imagecredit,imageid,imagepath)
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/download",
            data:{
                hidden_imageid: imageid, 
                hidden_imagepath: imagepath,
                mode: mode
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                cusinsertdownload_process(mode,imageid,imagepath);                      
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function cusinsertdownload_process(mode,imageid,imagepath)
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/insertdownload",
            data:{
                hidden_imageid: imageid, 
                hidden_imagepath: imagepath,
                mode:mode
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="http://shotlancer.com"  ;                     
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }    
    
    function checkcususernameexist(username) 
    {   
        var res;
        $.ajax({
            type:"post",
            async: false,
            url:"http://shotlancer.com/customer/checkexist",
            data:{val: username, field:'username'},
            success:function(data){
                res=data;
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
        return res;
    }
    
    function checkcusemailexist(email) 
    {   
        var res;
        $.ajax({
            type:"post",
            async: false,
            url:"http://shotlancer.com/customer/checkexist",
            data:{val: email, field:'email'},
            success:function(data){
                res=data;
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
        return res;
    }
    
    function validate_field(ctrl)
    {   
        switch (ctrl) {
            case 'cusreg_un':
                if ($('#'+ctrl).val().length <4)
                    {
                        $ ('#val_cus_register_un').text('Username must be from 4 - 40 characters');
                        return false;
                        break;
                    }
                if (checkcususernameexist($('#'+ctrl).val())!=0)
                    {
                        $ ('#val_cus_register_un').text('This username is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_un').text('');return true;}
                break;
                
            case 'cusreg_pw':
                if ($('#'+ctrl).val().length <5)
                    {
                        $ ('#val_cus_register_pw').text('Password must be from 5 - 40 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_pw').text('');return true;}
                break;
            
            case 'cusreg_repw':
                if ($('#'+ctrl).val() != $('#cusreg_pw').val())
                    {
                        $ ('#val_cus_register_repw').text('Password confirmation is not correct');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_repw').text('');return true;}
                break;
                
            case 'cusreg_name':
                if ($('#'+ctrl).val().length <5)
                    {
                        $ ('#val_cus_register_name').text('Name must be from 5 - 40 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_name').text('');return true;}
                break;
                
            case 'cusreg_address':
                if ($('#'+ctrl).val().length <10)
                    {
                        $ ('#val_cus_register_address').text('Address must be from 10 - 100 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_name').text('');return true;}
                break;
                
            case 'cusreg_email':                                                                            
                if (!validateemail($('#'+ctrl).val()))
                    {
                        $ ('#val_cus_register_email').text('Please input valid email address');
                        return false;
                        break;
                    }
                if (checkcusemailexist($('#'+ctrl).val())!=0)
                    {
                        $ ('#val_cus_register_email').text('This email address is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_cus_register_email').text('');return true;}
                break;
            
        }
    }
    
    function cusregistervalidateform_process()
    {    
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#cusreg_pw').change();
        $ ('#cusreg_repw').change();
        $ ('#cusreg_name').change();
        $ ('#cusreg_email').change();
        $ ('#cusreg_address').change();
       
        if ($ ('#cusreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_pw').text('Required field');
        }
        if ($ ('#cusreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_repw').text('Required field');
        }
        if ($ ('#cusreg_name').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_name').text('Required field');
        }
        if ($ ('#cusreg_email').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_email').text('Required field');
        }
        if ($ ('#cusreg_address').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_address').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=validate_field('cusreg_pw');
            var valstatus_repw=validate_field('cusreg_repw');
            var valstatus_name=validate_field('cusreg_name');
            var valstatus_email=validate_field('cusreg_email');
            var valstatus_address=validate_field('cusreg_address');
            if (valstatus_pw && valstatus_repw && valstatus_name && valstatus_email && valstatus_address ) 
            {
                cusregister_process();
            }
            else
            {
                return false;
            }
        }
        return false;
    }
    
    function cus_purchase()
    {
        $( "#item_name" ).val($('#plantype').val() + ' credits at shotlancer.com');
        switch ($('#plantype').val()) {
            case '10':
                $( "#amount" ).val(20);
                break;
            case '25':
                $( "#amount" ).val(35);
                break;
            case '50':
                $( "#amount" ).val(50);
                break;
        }
        $( "#form_paypal" ).submit();
    }
    
    function cusregister_process()
    {
        
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/doregister",
            data:{
                cusreg_pw: document.getElementById("cusreg_pw").value,
                cusreg_name: document.getElementById("cusreg_name").value,
                cusreg_email: document.getElementById("cusreg_email").value,
                cusreg_country: document.getElementById("cusreg_country").value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="/";                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });   
    }
    
    function cusaccountform_update(ctrl)
    {
        var tmp = ctrl.id;
        var inputid = tmp.substr(7,tmp.length-7);
        var ufield = tmp.substr(27,tmp.length-27);
        var uvalue = $('#' + inputid).val();
        var userid=document.getElementById("cus_editcusid").value;
        
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#val_cus_editinformation_name').text('');
        $ ('#val_cus_editinformation_email').text('');
        $ ('#val_cus_editinformation_address').text('');
        $ ('#val_cus_editinformation_purpose').text('');
        $ ('#val_cus_editinformation_about').text('');
        
        if (inputid=='cus_editinformation_name')
        {
            if ($('#' + inputid).val().length<5)
            {
                flag = false;
                $ ('#val_cus_editinformation_name').text('Please input from 5 - 40 characters value for your name');
            }
        }
        
        else if (inputid=='cus_editinformation_email')
        {
            uvalue = uvalue.toString();
            if (!validateemail($('#'+inputid).val()))
                {
                    $ ('#val_cus_editinformation_email').text('Please input valid email address');
                    flag = false;
                }
            if (checkcusemailexist($('#'+inputid).val())!=0)
                {
                    $ ('#val_cus_editinformation_email').text('This email address is already in our system. Please choose another one');
                    flag = false;
                }
        }
        
        else if (inputid=='cus_editinformation_address')
        {
            uvalue = uvalue.toString();
            if ($('#' + inputid).val().length<10)
            {
                flag = false;
                $ ('#val_cus_editinformation_address').text('Please input from 10 - 100 characters value for your name');
            }
        }
        
        
        if (flag)
        {
            cusaccountdetail_update(tmp,ufield,uvalue,userid,inputid);
            $('#' + inputid).prop('hidden',true);
            $('#hidden_' + inputid).text(uvalue);
            $('#hidden_' + inputid).show();
            $('#update_' + inputid).prop('hidden',true);
            $('#cancel_' + inputid).prop('hidden',true);
            $('#btn_' + inputid).prop('hidden',false);
               
        }
    }
    
    function cusaccountdetail_update (ctrl,field, value, userid,inputid)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/updatedetail",
            data:{
                cus_editcusid: userid,
                cus_editfield: field,
                cus_editvalue: value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $('#msg_' + inputid).html('Update successfully');
                $('#msg_' + inputid).fadeIn().delay(1200).fadeOut();                     
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    
    
    //actions handle user pages
    //////////////////////////////////////////////////////////////////////////////////////////////////
    
    function usersubmitplan_process(plan)
    {
        $( "#item_name" ).val(plan + ' picture slots at shotlancer.com');
        switch (plan) {
            case '20':
                $( "#amount" ).val(1); //8
                break;
            case '40':
                $( "#amount" ).val(1); //15
                break;
            case '80':
                $( "#amount" ).val(1); //28
                break;
        }
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/dochooseplan",
            data:{
                userreg_plan: plan
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $( "#custom" ).val(data);
                $( "#form_paypal" ).submit();                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    
    function usergetcredit_process(username,displaydiv)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/getnoofimage",
            data:{user_un: username},
            beforeSend: function ( xhr ) {
            },
            success:function(resp){
                $('#'+displaydiv).html("You can still upload " + parseInt(resp) + " picture(s)");
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });          
    }
    
    function userlogin_process(username,password,destination)
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/login",
            data:{user_un: username,user_pw: password},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (parseInt(data)==1)
                {
                    window.location=destination;
                 }
                 else
                 { 
                    showfailure('LOGIN FAILED','Sorry, system cannot recognize your account and password','<span style="float:left"><a href="http://shotlancer.com/user/register">Register</a></span><span style="float:right"><a href="http://shotlancer.com/user/forgotpassword">Forgot your password?</a></span>',100,-400);
                 }                              
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function userlogout_process(username)
    {   
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/logout",
            data:{user_un: username},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="/";                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function checkuserusernameexist(username) 
    {   
        var res;
        $.ajax({
            type:"post",
            async: false,
            url:"http://shotlancer.com/user/checkexist",
            data:{val: username, field:'username'},
            success:function(data){
                res=data;
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
        return res;
    }
    
    function checkuseremailexist(email) 
    {   
        var res;
        $.ajax({
            type:"post",
            async: false,
            url:"http://shotlancer.com/user/checkexist",
            data:{val: email, field:'email'},
            success:function(data){
                res=data;
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
        return res;
    }
    
    function userregisterfield_validate(ctrl)
    {
        switch (ctrl) {
            case 'userreg_un':
                if ($('#'+ctrl).val().length <4)
                    {
                        $ ('#val_user_register_un').text('Username must be from 4 - 40 characters');
                        return false;
                        break;
                    }
                if (checkuserusernameexist($('#'+ctrl).val())!=0)
                    {
                        $ ('#val_user_register_un').text('This username is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_un').text('');return true;}
                break;
                
            case 'userreg_pw':
                if ($('#'+ctrl).val().length <5)
                    {
                        $ ('#val_user_register_pw').text('Password must be from 5 - 40 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_pw').text('');return true;}
                break;
            
            case 'userreg_repw':
                if ($('#'+ctrl).val() != $('#userreg_pw').val())
                    {
                        $ ('#val_user_register_repw').text('Password confirmation is not correct');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_repw').text('');return true;}
                break;
                
            case 'userreg_name':
                if ($('#'+ctrl).val().length <5)
                    {
                        $ ('#val_user_register_name').text('Name must be from 5 - 40 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_name').text('');return true;}
                break;
                
            case 'userreg_address':
                if ($('#'+ctrl).val().length <10)
                    {
                        $ ('#val_user_register_address').text('Address must be from 10 - 100 characters');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_address').text('');return true;}
                break;
                
            case 'userreg_paypal':
                if ($('#'+ctrl).val().length <5)
                    {
                        $ ('#val_user_register_paypal').text('Please input valid Paypal account');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_paypal').text('');return true;}
                break;
                
            case 'userreg_email':                                                                            
                if (!validateemail($('#'+ctrl).val()))
                    {
                        $ ('#val_user_register_email').text('Please input valid email address');
                        return false;
                        break;
                    }
                if (checkuseremailexist($('#'+ctrl).val())!=0)
                    {
                        $ ('#val_user_register_email').text('This email address is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_user_register_email').text('');return true;}
                break;
            
        }
    }
    
    function userregisterform_validate()
    {
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#userreg_email').change();
        $ ('#userreg_pw').change();
        $ ('#userreg_repw').change();
        $ ('#userreg_name').change();
        $ ('#userreg_address').change();
        
        if ($ ('#userreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_pw').text('Required field');
        }
        if ($ ('#userreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_repw').text('Required field');
        }
        if ($ ('#userreg_name').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_name').text('Required field');
        }
        if ($ ('#userreg_email').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_email').text('Required field');
        }
        if ($ ('#userreg_address').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_address').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw = userregisterfield_validate('userreg_pw');
            var valstatus_repw = userregisterfield_validate('userreg_repw');
            var valstatus_email = userregisterfield_validate('userreg_email');
            var valstatus_name = userregisterfield_validate('userreg_name');
            var valstatus_address = userregisterfield_validate('userreg_address');
            if (valstatus_pw && valstatus_repw && valstatus_name && valstatus_email && valstatus_address ) {
                userregister_process();
            }
            else
            {
                return false;
            }
        }
        return false;
    }
    
    function userregister_process()
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/doregister",
            data:{
                userreg_pw: document.getElementById("userreg_pw").value,
                userreg_name: document.getElementById("userreg_name").value,
                userreg_email: document.getElementById("userreg_email").value,
                userreg_address: document.getElementById("userreg_address").value,
                userreg_country: document.getElementById("userreg_country").value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="http://shotlancer.com/user/home";                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function usertokenize(ctrl,currenttags)
    {
        $('#'+ctrl).tokenize({
                datas:"http://shotlancer.com/data_picdesc.php",
                maxElements: 10,
                valueField: "text",
                defaulttokens: currenttags
        }); 
        
    }
    
    function overlaycontrol(ctrl)
    {
        //create overlay to disable the select token
        var overlay = jQuery('<div id="overlaydiv"></div>');
        overlay
              .css({
                 'opacity' : 0.4,
                 'position': 'absolute',
                 'top': $ (ctrl).position().top,
                 'left': $ (ctrl).position().left,
                 'background-color': '#EBEBE4',
                 'width': $ (ctrl).width(),
                 'height': $ (ctrl).height(),
                 'z-index': 5000
              });
         overlay.appendTo(document.body);
    }
    
    function addplaceholder(parentctrl,ctrl, content)
    {
        var overlay = jQuery('<div id="overlaydiv"></div>');
        overlay
              .css({
                 'opacity' : 0.4,
                 'position': 'absolute',
                 'top': $ (ctrl).position().top,
                 'left': $ (ctrl).position().left,
                 'background-color': 'transparent',
                 'width': $ (ctrl).width(),
                 'height': $ (ctrl).height(),
                 'z-index': 5000
              });
        overlay.html(content);
        overlay.click(function()
        {
            $( "div" ).remove( "#overlaydiv" );
            $("#"+parentctrl).focus();
            $("#"+parentctrl).dblclick();
            //document.getElementById(parentctrl).c();
        }
        );
        overlay.appendTo(document.body);
    }
    
    
    function enable_form_control(ctrl,currentvalue,overlay)
    {
        var inputid = ctrl;
        $('#hidden_' + inputid).hide();
        $('#' + inputid).css('display','block');         
        $('#' + inputid).select();
        if (inputid=='user_editimagetag')
        {   
            var ms = $('#'+inputid).magicSuggest({});
            var array = currentvalue.split(',');
            ms.clear();
            ms.setValue(array);
        }
        
        $('#update_' + inputid).prop('hidden',false);
        $('#cancel_' + inputid).prop('hidden',false);
        $('#btn_' + inputid).css('display','none');
        
        if (overlay=='true')
        {
            $( "div" ).remove( "#overlaydiv" );    
        }   
        //store current information
        window['current_value'] = $('#' + inputid).val();
    }
    
    function cancel_form_control(ctrl)
    {
        var inputid = ctrl;
      
        $('#hidden_' + inputid).show();
        $('#hidden_' + inputid).val(current_value);
        $('#' + inputid).val(window['current_value']);
        $('#' + inputid).css('display','none');
        $('#update_' + inputid).prop('hidden',true);
        $('#cancel_' + inputid).prop('hidden',true);
        $('#btn_' + inputid).css('display','inline');
        
        //clear validation error message
        $ ('#val_' + inputid).text('');
    }
    
    function user_update_form_control(ctrl)
    {
        var tmp = ctrl;
        var inputid = tmp;
        var ufield = tmp.substr(14,tmp.length-14);
        var uvalue = $('#' + inputid).val();
        var imageid=document.getElementById("user_editimageid").value;
        var imagestatus = document.getElementById("imagestatus").value;
        
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#val_user_editimagetitle').text('');
        $ ('#val_user_editimagedescription').text('');
        $ ('#val_user_editimagetag').text('');
        
        if (inputid=='user_editimagetitle')
        {
            if ($('#' + inputid).val().length<10)
            {
                flag = false;
                $ ('#val_user_editimagetitle').text('Please set a short title from 10 - 50 characters for your picture');
            }
        }
        
        else if (inputid=='user_editimagetag')
        {
            uvalue = $('#user_editimagetag').text();
            if (counttags("user_editimagetag") < 3)
            {
                flag = false;
                $ ('#val_user_editimagetag').text('Please choose 3 - 10 tags for your pictures so people can search easily');
            }
        }
        
        if (flag)
        {
            $('#' + inputid).css('display','none');
            /*if(inputid=='user_editimagetype')
            {
                $('#hidden_' + inputid).text($("#" + inputid + " option[value='" + uvalue + "']").text());
            }*/
            $('#hidden_' + inputid).show()
            $('#update_' + inputid).prop('hidden',true);
            $('#cancel_' + inputid).prop('hidden',true);
            $('#btn_' + inputid).css('display','inline');
            if (imagestatus=='available')
            {
                userupdateimagedetail(ufield,uvalue,imageid,inputid);
            }
            else
            {
                userupdateimagedetailreview (ufield,uvalue,imageid,inputid);
            }
            
        }
    }
    
    function userupdateimagedetail(field, value, imageid,inputid)
    {
       $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/updatedetail",
            data:{
                imageid: imageid,
                field: field,
                value: value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $('#new_' + inputid).text(value);
                $('#review_' + inputid).html('<span class="reviewwarning label">Your latest update is being reviewed.</span>');
                $('#msg_' + inputid).html('<span class="reviewwarning label">Update successfully. We will review your change shortly.</span>');
                $('#msg_' + inputid).fadeIn().delay(1200).fadeOut();             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function userupdateimagedetailreview (field,value,imageid,inputid)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/updatedetailreview",
            data:{
                imageid: imageid,
                field: field,
                value: value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $('#new_' + inputid).text(value);
                $('#newlabel_' + inputid).html('Latest update:');
                $('#msg_' + inputid).html('<span class="reviewwarning label">Update successfully. We will review your change shortly.</span>');
                $('#btn_' + inputid).css('display','none');
                //$('#msg_' + inputid).fadeIn().delay(1200).fadeOut();                     
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function userdeleteimage_confirm()
    {
        var divhtml=   '<div class="panel panel-body"> '+
                            '<div>'+
                                '<h3>Confirmation</h3>'+
                            '</div>'+
                            '<div><hr /></div>'+
                            '<div>'+
                                '<span>Are you sure want to delete this picture?</span>'+
                            '</div>'+
                            '<div><hr /></div>'+
                            '<div style="spacing: 10px">'+
                                '<input type="button" class="btn btn-danger" value="Yes" onclick="userdeleteimage_process();"/><div class="divider"></div>'+
                                '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();"/>'+
                            '</div>'+
                               
                        '</div>';
        showdialog_process(divhtml,'',-150,-150,'true');
    }
    
    function userdeleteimage_process()
    {
         $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/deleteimage",
            data:{
                user_deleteimageid: document.getElementById("user_deleteimageid").value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="http://shotlancer.com/user/myaccount";                        
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function selectmenu(ctrl)
    {  
        ctrl.bgColor="grey";
        var obj=$('#'+ctrl.id+' > .user_imagepopup_menuitem');
        obj.css('color','white');
      
      
    }
    
    function deselectmenu(ctrl)
    {  
        ctrl.bgColor="white";
        var obj=$('#'+ctrl.id+' > .user_imagepopup_menuitem');
        obj.css('color','black');
      
    }
    
    function usermoreviewoption_show(ctrl) 
    {
        if ($('#div_moreviewoption').css('display')!='block')
        {
            var divhtml=   '<div id="div_moreviewoption" class="list-group">'+
                                '<li class="list-group-item"><a class="user_imagepopup_menuitem" onclick="usertopdownload_show();">Top most 20 download</a></li>'+
                                '<li class="list-group-item"><a class="user_imagepopup_menuitem" onclick="usertopvalue_show();">Top 10 high value</a></li>'  +
                                '<li class="list-group-item"><a class="user_imagepopup_menuitem" onclick="usernodownload_show();">No download list</a></li>'+
                                '<li class="list-group-item"><a class="user_imagepopup_menuitem" onclick="userfulldownload_show();">Full download history</a></li>'+
                            '</div>';
            showdialog_process(divhtml,ctrl.id,0,+30,'false');
        }
        else
        {
            removedialog_process();
        }
    }    
    
    function usertopdownload_show()
    { 
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/gettopdownload/20",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
                showdialog_process('<div><img width="39" height ="39" src="/application/views/images/loading.gif" /></div>','', 60,-50,'true');
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                var divhtml=   
                                '<div class="panel panel-default">'+
                                    '<div class="panel-heading"><span>Top most 20 download pictures</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                    '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                    '<table class="table table-hover">';
                if (obj.length>0)
                {
               
                    divhtml = divhtml+'<tr sytle="text-align:center;width:100%">'+
                                            '<th><span>No</span></th>'+
                                            '<th><span>Image Title</span></th>'+
                                            '<th><span>Price</span></th>'+
                                            '<th><span>Download Times</span></th>'+
                                            '<th><span>Last Download</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td><a href='/user/viewimage/" + obj[i]["imageid"] +"'>" + obj[i]["title"] + "</a></td><td>" + obj[i]["price"] + "</td><td>" + obj[i]["downloadtime"] + "</td><td>" + obj[i]["downloaddate"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span>There is no download history yet</span></th></tr>';}                                         
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',60,200,'true'); 
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function usertopvalue_show()
    { 
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/gettopvalue/10",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
                showdialog_process('<div><img width="39" height ="39" src="/application/views/images/loading.gif" /></div>','btn_showmorepic',60,-50,'true');
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                
                var divhtml=   '<div class="panel panel-default">'+
                                    '<div class="panel-heading"><span>Top 10 pictures has highest price</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                    '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                    '<table class="table table-hover">';
                if (obj.length>0)
                {
                
                     divhtml = divhtml + '<tr sytle="text-align:center;width:100%">'+
                                            '<th><span>No</span></th>'+
                                            '<th><span>Image Title</span></th>'+
                                            '<th><span>Price</span></th>'+
                                            '<th><span>Download Times</span></th>'+
                                            '<th><span>Upload Date</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td><a href='/user/viewimage/" + obj[i]["imageid"] +"'>" + obj[i]["title"] + "</a></td><td>" + obj[i]["price"] + "</td><td>" + obj[i]["downloadtime"] + "</td><td>" + obj[i]["downloaddate"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span>There is no download history yet</span></th></tr>';}                        
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',60,0,'true'); 
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function usernodownload_show()
    { 
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/getnodownload",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
                showdialog_process('<div><img width="39" height ="39" src="/application/views/images/loading.gif" /></div>','btn_showmorepic',60,-50,'true');
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                
                var divhtml=   '<div class="panel panel-default">'+
                                    '<div class="panel-heading"><span>Pictures that has not been downloaded yet</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                    '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                    '<table class="table table-hover">';
                if (obj.length>0)
                {
                
                     divhtml = divhtml + '<tr sytle="text-align:center;width:100%">'+
                                            '<th><span class="user_account_info_label">No</span></th>'+
                                            '<th><span class="user_account_info_label">Image Title</span></th>'+
                                            '<th><span class="user_account_info_label">Price</span></th>'+
                                            '<th><span class="user_account_info_label">Upload Date</span></th>'+
                                            '<th><span class="user_account_info_label">Last Update</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td'><a href='/user/viewimage/" + obj[i]["imageid"] +"'>" + obj[i]["title"] + "</a></td><td>" + obj[i]["price"] + "</td><td>" + obj[i]["downloadtime"] + "</td><td>" + obj[i]["downloaddate"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span class="user_account_info_value">There is no download history yet</span></th></tr>';}                        
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',60,0,'true'); 
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function userfulldownload_show()
    { 
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/getalldownload",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
                showdialog_process('<div><img width="39" height ="39" src="/application/views/images/loading.gif" /></div>','btn_showmorepic',60,-50,'true');
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                var divhtml=   '<div class="panel panel-default">'+
                                    '<div class="panel-heading"><span>Full download history</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                    '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                    '<table class="table table-hover">';
                if (obj.length>0)
                {
                
                     divhtml = divhtml + '<tr sytle="text-align:center;width:100%;">'+
                                            '<th><span class="user_account_info_label">No</span></th>'+
                                            '<th><span class="user_account_info_label">Image Title</span></th>'+
                                            '<th><span class="user_account_info_label">Price</span></th>'+
                                            '<th><span class="user_account_info_label">Download Times</span></th>'+
                                            '<th><span class="user_account_info_label">Last Download</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td><a href='/user/viewimage/" + obj[i]["imageid"] +"'>" + obj[i]["title"] + "</a></td><td>" + obj[i]["price"] + "</td><td>" + obj[i]["downloadtime"] + "</td><td>" + obj[i]["downloaddate"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span>There is no download history yet</span></th></tr>';}                        
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',60,0,'true'); 
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function show_upcomingpayment(ctrl)
    {
        $("#dialog_viewmoreimage").html ("");   
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/getupcomingpayment",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                var divhtml=   '<div class="panel panel-default">'+
                                        '<div class="panel-heading"><span>Upcoming Payments</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                        '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                        '<table class="table table-hover">';
                if (obj.length>0)
                {
                
                     divhtml = divhtml +'<tr sytle="text-align:center;width:100%;">'+
                                            '<th><span class="user_account_info_label">No</span></th>'+
                                            '<th><span class="user_account_info_label">Image</span></th>'+
                                            '<th><span class="user_account_info_label">Amount</span></th>'+
                                            '<th><span class="user_account_info_label">Download Date</span></th>'+
                                            '<th><span class="user_account_info_label">Expected Payment Date</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td><a href='/user/viewimage/" + obj[i]["image_id"] +"'>" + obj[i]["title"] + "</a></td><td>" + obj[i]["amount"] + " USD</td><td>" + obj[i]["download_date"] + "</td><td>" + obj[i]["expected_date"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span class="user_account_info_value">There is no upcoming payment</span></th></tr>';}                        
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',-400,0,'true');           
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function show_historypayment(ctrl)
    {
        $("#dialog_viewmoreimage").html ("");   
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/gethistorypayment",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var obj = JSON.parse(data);
                
                var divhtml=   '<div class="panel panel-default">'+
                                        '<div class="panel-heading"><span>Payment History</span><span style="float:right"><input type="button" value="Close" onclick="removedialog_process();" /></span></div>'+
                                        '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                        '<table class="table table-hover">';
                if (obj.length>0)
                {
                divhtml= divhtml +   '<tr sytle="text-align:center;width:100%;">'+
                                            '<th><span class="user_account_info_label">No</span></th>'+
                                            '<th><span class="user_account_info_label">Date</span></th>'+
                                            '<th><span class="user_account_info_label">Amount</span></th>'+
                                            '<th><span class="user_account_info_label">Payment Type</span></th>'+
                                            '<th><span class="user_account_info_label">Payment Method</span></th>'+
                                            '<th><span class="user_account_info_label">Account</span></th>'+
                                            '<th><span class="user_account_info_label">Invoice ID</span></th>'+
                                        '</tr>';
                
                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + "<tr><td>" + (i+1) + "</td><td>" + obj[i]["payment_date"] + "</td><td>" + obj[i]["amount"] + " USD</td><td>" + obj[i]["payment_type"] + "</td><td>" + obj[i]["payment_method"] + "</td><td>" + obj[i]["receive_account"] + "</td><td>" + obj[i]["invoice_id"] + "</td></tr>";
                    }
                }
                else
                {divhtml=divhtml + '<tr><th><span class="user_account_info_value">There is no payment yet</span></th></tr>';}                        
                divhtml=divhtml + '</table></div></div>';
                showdialog_process(divhtml,'',0,0,'true');  
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function useraccountform_update(ctrl)
    {
        var tmp = ctrl.id;
        var inputid = tmp.substr(7,tmp.length-7);
        var ufield = tmp.substr(28,tmp.length-28);
        var uvalue = $('#' + inputid).val();
        var userid=document.getElementById("user_edituserid").value;
        
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#val_user_editinformation_name').text('');
        $ ('#val_user_editinformation_email').text('');
        $ ('#val_user_editinformation_paypalaccount').text('');
        
        if (inputid=='user_editinformation_name')
        {
            if ($('#' + inputid).val().length<10)
            {
                flag = false;
                $ ('#val_user_editinformation_name').text('Please give from 10 - 35 characters value for your name');
            }
        }
        
        else if (inputid=='user_editinformation_email')
        {
            uvalue = uvalue.toString();
            if (!validateemail($('#'+inputid).val()))
                {
                    $ ('#val_user_editinformation_email').text('Please input valid email address');
                    flag = false;
                }
            if (checkcusemailexist($('#'+inputid).val())!=0)
                {
                    $ ('#val_user_editinformation_email').text('This email address is already in our system. Please choose another one');
                    flag = false;
                }
        }
        
        else if (inputid=='user_editinformation_paypalaccount')
        {
            uvalue = uvalue.toString();
            if ($('#' + inputid).val().length<1)
            {
                flag = false;
                $ ('#val_user_editinformation_paypalaccount').text('Please input valid Paypal account');
            }
        }
        
        if (flag)
        {
            useraccountdetail_update(tmp,ufield,uvalue,userid,inputid);
            $('#' + inputid).prop('hidden',true);
            $('#hidden_' + inputid).text(uvalue);
            $('#hidden_' + inputid).show()
            $('#update_' + inputid).prop('hidden',true);
            $('#cancel_' + inputid).prop('hidden',true);
            $('#btn_' + inputid).prop('hidden',false);
               
        }
    }
    
    function useraccountdetail_update (ctrl,field, value, userid,inputid)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/updatedetail",
            data:{
                user_edituserid: userid,
                user_editfield: field,
                user_editvalue: value
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                $('#msg_' + inputid).html('Update successfully');
                $('#msg_' + inputid).fadeIn().delay(1200).fadeOut();
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $ ('#val_file_file').text('');
            reader.onload = function (e) 
            {
                var flag=true;
                
                //get the original size of the image
                var img = new Image;
                img.onload = function() {
                    minsize= Math.min(img.width, img.height);
                    //alert (minsize); 
                    if (minsize<300)
                    {
                        $('#div_image_review_square').html('');
                        $('#div_image_review_lanscape').html('');
                        $('#div_image_review_portrait').html('');
                        $('#userfile').val("");
                        $ ('#val_file_file').text('Image must be at least 300 pixel width or height, please choose bigger one.');
                        
                        flag = false;
                    }
                };
                img.src = reader.result;
                if(flag==true)
                {                
                    $('#div_image_review_square').html('');
                    $('#div_image_review_lanscape').html('');
                    $('#div_image_review_portrait').html('');
                        
                    $('#div_image_review_square').append('<img id="image_review_square" src="#" style="border:1px solid #000000" />');
                    $('#div_image_review_lanscape').append('<img id="image_review_lanscape" src="#" style="border:1px solid #000000" />');
                    $('#div_image_review_portrait').append('<img id="image_review_portrait" src="#" style="border:1px solid #000000" />');
                    
                    showloading();
                    setTimeout(function(){
                        removedialog_process();
                        $('#fit').click();
                    }, 3000);
                    
                    var _this = this;
                    var picturesquare = $('#image_review_square');
                    var picturelanscape = $('#image_review_lanscape');
                    var pictureportrait = $('#image_review_portrait');
                    
                    $('#image_review_square').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    $('#image_review_square').attr('src', e.target.result);
                    $('#image_review_lanscape').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    $('#image_review_lanscape').attr('src', e.target.result);
                    $('#image_review_portrait').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    $('#image_review_portrait').attr('src', e.target.result);
                    
                    var _this = this;
            
                    picturesquare.file=input.files[0];
                    picturesquare.src=e.target.result;
                    picturelanscape.file=input.files[0];
                    picturelanscape.src=e.target.result;
                    pictureportrait.file=input.files[0];
                    pictureportrait.src=e.target.result;
                    load_image_plugin();
                    
                    //when image load, load the content to the preview image object
                    picturesquare.onload = function() 
                    {   
        				_this._image = img;
        				_this._resizeViewport();
        				_this._paintCanvas();
        				_this.options.imageUpdated(_this._image);
        				_this._mainbuttons.removeClass("active");
        				if(callback && typeof(callback) == "function") {callback();}
                    
    			     };
                     picturelanscape.onload = function() 
                    {   
        				_this._image = img;
        				_this._resizeViewport();
        				_this._paintCanvas();
        				_this.options.imageUpdated(_this._image);
        				_this._mainbuttons.removeClass("active");
        				if(callback && typeof(callback) == "function") {callback();}
                    
    			     };
                     pictureportrait.onload = function() 
                    {   
        				_this._image = img;
        				_this._resizeViewport();
        				_this._paintCanvas();
        				_this.options.imageUpdated(_this._image);
        				_this._mainbuttons.removeClass("active");
        				if(callback && typeof(callback) == "function") {callback();}
                    
    			     };
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function load_image_plugin()
    {
        var picturesquare = $('#image_review_square');
        $('#image_review_square').load(function () {//each time when image is loaded
            $(this).guillotine('remove');//clear previous instance, if it does exists
            $(this).guillotine({width: 300, height: 300,//setup new plugin instance
                onChange: function(data, action){
                    data.scale = parseFloat(data.scale.toFixed(4)); //alert(data.x1);
                    for(var k in data) { $('#'+k+'_square').html(data[k]); }
                    var tempw=data['w']/ data['scale'];
                    var temph=data['h']/ data['scale'];
                    $('#w1_square').html(Math.round(tempw));
                    $('#h1_square').html(Math.round(temph));
                }});
            $('#rotate_left_square').click(function(){ picturesquare.guillotine('rotateLeft'); });
            $('#rotate_right_square').click(function(){ picturesquare.guillotine('rotateRight'); });
            $('#fit_square').click(function(){ picturesquare.guillotine('fit'); });
            $('#zoom_in_square').click(function(){ picturesquare.guillotine('zoomIn'); });
            $('#zoom_out_square').click(function(){ picturesquare.guillotine('zoomOut'); });
            $('#fit_square').click();
        });
        
        var picturelanscape = $('#image_review_lanscape');
        $('#image_review_lanscape').load(function () {//each time when image is loaded
            $(this).guillotine('remove');//clear previous instance, if it does exists
            $(this).guillotine({width: 300, height: 225,//setup new plugin instance
                onChange: function(data, action){
                    data.scale = parseFloat(data.scale.toFixed(4)); //alert(data.x1);
                    for(var k in data) { $('#'+k+'_lanscape').html(data[k]); }
                    var tempw=data['w']/ data['scale'];
                    var temph=data['h']/ data['scale'];
                    $('#w1_lanscape').html(Math.round(tempw));
                    $('#h1_lanscape').html(Math.round(temph));
                }});
            $('#rotate_left_lanscape').click(function(){ picturelanscape.guillotine('rotateLeft'); });
            $('#rotate_right_lanscape').click(function(){ picturelanscape.guillotine('rotateRight'); });
            $('#fit_lanscape').click(function(){ picturelanscape.guillotine('fit'); });
            $('#zoom_in_lanscape').click(function(){ picturelanscape.guillotine('zoomIn'); });
            $('#zoom_out_lanscape').click(function(){ picturelanscape.guillotine('zoomOut'); });
            $('#fit_lanscape').click();
        }); 
        
        var pictureportrait = $('#image_review_portrait');
        $('#image_review_portrait').load(function () {//each time when image is loaded
            $(this).guillotine('remove');//clear previous instance, if it does exists
            $(this).guillotine({width: 225, height: 300,//setup new plugin instance
                onChange: function(data, action){
                    data.scale = parseFloat(data.scale.toFixed(4)); //alert(data.x1);
                    for(var k in data) { $('#'+k+'_portrait').html(data[k]); }
                    var tempw=data['w']/ data['scale'];
                    var temph=data['h']/ data['scale'];
                    $('#w1_portrait').html(Math.round(tempw));
                    $('#h1_portrait').html(Math.round(temph));
                }});
            $('#rotate_left_portrait').click(function(){ pictureportrait.guillotine('rotateLeft'); });
            $('#rotate_right_portrait').click(function(){ pictureportrait.guillotine('rotateRight'); });
            $('#fit_portrait').click(function(){ pictureportrait.guillotine('fit'); });
            $('#zoom_in_portrait').click(function(){ pictureportrait.guillotine('zoomIn'); });
            $('#zoom_out_portrait').click(function(){ pictureportrait.guillotine('zoomOut'); });
            $('#fit_portrait').click();
        });  
    }
    
    function useruploadfield_validate(ctrl)
    {
        switch (ctrl) {
            case 'file_title':
                if ($('#'+ctrl).val().length <10)
                    {
                        
                        $ ('#val_file_title').text('Please input 10 - 50 characters for the title of your picture');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_file_title').text('');return true;break;}
                break;
                
            case 'file_tags':
                if (counttags('file_tags') <3)
                    {
                        $ ('#val_file_tags').text('Please choose 3 - 10 tags for your pictures so people can search easily');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_file_tags').text('');return true;break;}
                break;
            
            case 'userfile':
                if (!($('#userfile')[0].value))
                    {
                        $ ('#val_file_file').text('Please choose your image to upload');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_file_file').text('');return true;break;}
                break;
        }
    }
    
    function counttags(ctrl)
    {
        var str = $ ('#'+ctrl).text();
        return (str.split(",").length)
    }
    
    function useruploadform_validate(username,data)
    {
        document.body.click();
       
        if (username=="")
        {   
            var divhtml = '<div class="panel panel-body">'+
                            '<form name="form_userlogin" method="POST" action="http://shotlancer.com/user/login">'+
                            '<div><h4>LOGIN</h4></div>'+
                            '<div><hr /></div>'+
                            '<div><input type="text" class="form-control" placeholder="Username" id="user_un1" required="true"/></div>'+
                            '<div><input type="password" class="form-control" placeholder="Password" id="user_pw1"" required="true" /></div>'+
                            '<div><span><input type="button" class="btn btn-primary" name="btn_submit" value="Login" onclick ="userlogin_process(document.getElementById(\'user_un1\').value,document.getElementById(\'user_pw1\').value,\'http://shotlancer.com/user/home\');"/></span><span><input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();" /></span></div>'+
                            '<div><span style="float:left"><a href="http://shotlancer.com/user/register">Register</a></span><span style="float:right"><a href="http://shotlancer.com/user/forgotpassword">Forgot your password?</a></span></div>'+   
                            '</form>'+
                        '</div>';
            showdialog_process(divhtml,'',-150,-150,'true');
            return false;
        }
        
        var flag=true;
        valstatus_file=true;
        $ ('#val_file_file').text('');
        $ ('#val_file_image').text('');
        $ ('#val_file_tags').text('');
        $ ('#val_file_title').text('');
        //$ ('#userfile').change();
        $ ('#file_title').change();
        $ ('#file_tags').change();
        
        if (!($('#userfile')[0].value))
        {
            flag = false;
            valstatus_file=false;
            $ ('#val_file_file').text('Please choose your image to upload');
        }
        
        if ($('#file_title').val().length<10 )
        {
            
            flag = false;
            $ ('#val_file_title').text('Please input 10 - 50 characters for the title of your picture');
        }
        if (counttags('file_tags') <3)
        {
            flag = false;
            $ ('#val_file_tags').text('Please choose 3 - 10 tags for your pictures so people can search easily');
        }
        if (flag)
        {
            var valstatus_file = useruploadfield_validate('userfile');
            var valstatus_title = useruploadfield_validate('file_title');
            var valstatus_tags = useruploadfield_validate('file_tags');
            if (valstatus_file && valstatus_title && valstatus_tags) 
            {
                test_noofimage(username,data);
            }
            else
            {
                return false;
            } 
        }  
    }
    
    
    function test_noofimage(username,data)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/getnoofimage",
            data:{user_un: username},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(resp){
                removedialog_process();
                if(parseInt(resp)  <= 0)
                {
                    var divhtml =   '<div class="alert alert-danger">'+
                                        '<span>Sorry you have reached your upload limit, please purchase more</span>'+
                                        '<div><input type=button class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com/user/chooseplan\')" /></div>'+    
                                    '</div>';
                    showdialog_process(divhtml,'',-150,-150,'true');
                }
                else
                {
                    user_uploadimage(data);
                }                        
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });          
    }
    
    function user_uploadimage(data)
    {	
        var formData = new FormData();
        formData.append("userfile",$('input[type=file]')[0].files[0]);
        formData.append("file_tags",$("#file_tags").text());
        formData.append("file_title",document.getElementById("file_title").value);
        formData.append("file_address",document.getElementById("file_address").value);
        //square image params
        formData.append("image_x_square",data[0]);
        formData.append("image_y_square",data[1]);
        formData.append("image_w_square",data[2]);
        formData.append("image_h_square",data[3]);
        formData.append("image_scale_square",data[4]);
        formData.append("image_angle_square",data[5]);
        //lanscape image params
        formData.append("image_x_lanscape",data[6]);
        formData.append("image_y_lanscape",data[7]);
        formData.append("image_w_lanscape",data[8]);
        formData.append("image_h_lanscape",data[9]);
        formData.append("image_scale_lanscape",data[10]);
        formData.append("image_angle_lanscape",data[11]);
        //portrait image params
        formData.append("image_x_portrait",data[12]);
        formData.append("image_y_portrait",data[13]);
        formData.append("image_w_portrait",data[14]);
        formData.append("image_h_portrait",data[15]);
        formData.append("image_scale_portrait",data[16]);
        formData.append("image_angle_portrait",data[17]);
        formData.append("image_minsize",minsize);
         $.ajax({
            xhr: function()
        {
        var xhr = new window.XMLHttpRequest();
        //Upload progress
        xhr.upload.addEventListener("progress", function(evt){
         if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
            var divhtml = '<div>'+
                                '<div><img width="39" height ="39" src="/application/views/images/loading.gif"/></div>'+
                                '<div>Uploading ' + Math.round(percentComplete*100)+ '%</div>'+
                            '</div>';
            showdialog_process(divhtml,'',-150,-150,'true');         
        }
        }, false);
        //Download progress
        xhr.addEventListener("progress", function(evt){
        if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
         //Do something with download progress
         //alert(percentComplete);
        }
        }, false);
        return xhr;
        }
        
        ,
            type:"post",
            url:"http://shotlancer.com/user/uploadimage",
            data: formData,
             contentType: false,
             processData: false,
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                //removedialog_process();
                if (parseInt(data)==2)
                {
                    showfailure('UPLOAD FAILED','Your image is more than 5MB, please resize or choose another one','',-150,-150);
                }
                else{
                window.location="http://shotlancer.com/user/myaccount";}                        
            },
            error:function (request, status, error) {
                //removedialog_process();
                showerror();
            }
        });    
    }  
      
    function cuschangepasswordvalidate_process(username,newpassword)
    {    
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#cusreg_pw').change();
        $ ('#cusreg_repw').change();
    
        if ($ ('#cusreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_pw').text('Required field');
        }
        if ($ ('#cusreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_repw').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=validate_field('cusreg_pw');
            var valstatus_repw=validate_field('cusreg_repw');
            if (valstatus_pw && valstatus_repw) 
            {
                cuschangepassword_process (username,newpassword);
            }
            else
            {
                return false;
            }
        }
        return false;
    } 
    
    function cuschangepassword_process (username,newpassword)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/updatedetail",
            data:{
                cus_editcusid: username,
                cus_editfield: 'password',
                cus_editvalue: newpassword
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var divhtml=   '<div class="panel panel-body">'+
                                    '<div><h3>Success</h3></div>'+
                                    '<div><hr /></div>'+
                                    '<div><span>Password has been changed successfully</span></div>'+
                                    '<div><hr /></div>'+
                                    '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com/customer/home\');"></div>'+
                                  '</div>';
                showdialog_process(divhtml,'',-150,-150,'true');             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    
    function userchangepasswordvalidate_process(username,newpassword)
    {    
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#userreg_pw').change();
        $ ('#userreg_repw').change();
    
        if ($ ('#userreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_pw').text('Required field');
        }
        if ($ ('#userreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_repw').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=userregisterfield_validate('userreg_pw');
            var valstatus_repw=userregisterfield_validate('userreg_repw');
            if (valstatus_pw && valstatus_repw) 
            {
                userchangepassword_process (username,newpassword);
            }
            else
            {
                return false;
            }
        }
        return false;
    } 
    
    function userchangepassword_process (username,newpassword)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/updatedetail",
            data:{
                user_edituserid: username,
                user_editfield: 'password',
                user_editvalue: newpassword
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var divhtml=   '<div class="panel panel-body">'+
                                    '<div><h3>Success</h3></div>'+
                                    '<div><hr /></div>'+
                                    '<div><span>Password has been changed successfully</span></div>'+
                                    '<div><hr /></div>'+
                                    '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com/user/myaccount\');"/> </div>'+
                                  '</div>';
                showdialog_process(divhtml,'',-150,-150,'true');             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function cusforgotpasswordvalidate_process(email)
    {
        
        var flag=true;   
        $ ('#cusreg_email').change();
        if ($ ('#cusreg_email').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_email').text('Please input your registed email address');
        }
        if (flag)
        {
            var valstatus_em=true;
            if (!validateemail(email))
                {
                    $ ('#val_cus_register_email').text('Please input valid email address');
                    valstatus_em= false;
                }
            if (valstatus_em) 
            {
                cusforgotpassword_process (email);
            }
            else
            {
                return false;
            }
        }
        return false;
    }
    
    function cusforgotpassword_process (email)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/doforgotpassword",
            data:{
                cus_email: email
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (data.startsWith('Your password reset link has been sent to'))
                {
                    var divhtml=   '<div class="panel panel-body">'+
                                        '<div><h3>Success</h3></div>'+
                                        '<div><hr /></div>'+
                                        '<div>'+data+'</div>'+
                                        '<div><hr /></div>'+
                                        '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com\');"/> </div>'+
                                    '</div>';
                    showdialog_process(divhtml,'',-150,-150,'true'); 
                }
                else
                {
                    showfailure('ERROR','There is no account with this email address yet.','Please <a href="http://shotlancer.com/customer/register">Sign Up</a> now.',-150,-150);
                }
                            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    
    function cusresetpasswordvalidate_process(username,newpassword)
    {    
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#cusreg_pw').change();
        $ ('#cusreg_repw').change();
    
        if ($ ('#cusreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_pw').text('Required field');
        }
        if ($ ('#cusreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_cus_register_repw').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=validate_field('cusreg_pw');
            var valstatus_repw=validate_field('cusreg_repw');
            if (valstatus_pw && valstatus_repw) 
            {
                cusresetpassword_process (username,newpassword);
            }
            else
            {
                return false;
            }
        }
        return false;
    } 
    
    function cusresetpassword_process (username,newpassword)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/doresetpassword",
            data:{
                username: username,
                newpassword: newpassword
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var divhtml=   '<div class="panel panel-body">'+
                                    '<div><h3>Success</h3></div>'+
                                    '<div><hr /></div>'+
                                    '<div><span>Password has been changed successfully</span></div>'+
                                    '<div><hr /></div>'+
                                    '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com\');"></div>'+
                                  '</div>';
                showdialog_process(divhtml,'',-150,-150,'true');             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    
    ////////////////////////////////////////////////////////////////////////
    function userforgotpasswordvalidate_process(email)
    {
        
        var flag=true;   
        $ ('#userreg_email').change();
        if ($ ('#userreg_email').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_email').text('Please input your registed email address');
        }
        if (flag)
        {
            var valstatus_em=true;
            if (!validateemail(email))
                {
                    $ ('#val_user_register_email').text('Please input valid email address');
                    valstatus_em= false;
                }
            if (valstatus_em) 
            {
                userforgotpassword_process (email);
            }
            else
            {
                return false;
            }
        }
        return false;
    }
    
    function userforgotpassword_process (email)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/doforgotpassword",
            data:{
                user_email: email
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (data.startsWith('Your password reset link has been sent to'))
                {
                    var divhtml=   '<div class="panel panel-body">'+
                                        '<div><h3>Success</h3></div>'+
                                        '<div><hr /></div>'+
                                        '<div><span>Your password reset link has been sent to '+ email +'. Please check your mail.</span></div>'+
                                        '<div><hr /></div>'+
                                        '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com\');"/> </div>'+
                                    '</div>';
                    showdialog_process(divhtml,'',-150,-150,'true');
                }
                else if (data.startsWith('There is no account with this email address yet'))
                {
                    showfailure('ERROR','There is no account with this email address yet.','Please <a href="http://shotlancer.com/user/register">Sign Up</a> now.',-150,-150);
                }
                else
                {
                    showfailure('ERROR','<span>Fail to send email message. Please try again later.</br> We are very sorry for this inconvenience.</span>','',-150,-150);
                }
                             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function userforgotpassword_callback ()
    {
        removedialog_process();window.location="http://shotlancer.com";
    }
    
    /////////////////////////////////////////////////////////////////////
    
    function userresetpasswordvalidate_process(username,newpassword)
    {    
        //alert (username);
        //validation before calling ajax update method
        var flag=true;
        
        $ ('#userreg_pw').change();
        $ ('#userreg_repw').change();
    
        if ($ ('#userreg_pw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_pw').text('Required field');
        }
        if ($ ('#userreg_repw').val().length==0)
        {
            flag = false;
            $ ('#val_user_register_repw').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=userregisterfield_validate('userreg_pw');
            var valstatus_repw=userregisterfield_validate('userreg_repw');
            if (valstatus_pw && valstatus_repw) 
            {
                userresetpassword_process (username,newpassword);
            }
            else
            {
                return false;
            }
        }
        return false;
    } 
    
    function userresetpassword_process (username,newpassword)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/user/doresetpassword",
            data:{
                username: username,
                newpassword: newpassword
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                var divhtml=   '<div class="panel panel-body">'+
                                    '<div><h3>Success</h3></div>'+
                                    '<div><hr /></div>'+
                                    '<div><span>Password has been changed successfully</span></div>'+
                                    '<div><hr /></div>'+
                                    '<div><input type="button" class="btn btn-primary" value="Ok" onclick="dialogclose_callback(\'http://shotlancer.com/user/myaccount\');"/> </div>'+
                                  '</div>';
                showdialog_process(divhtml,'',-150,-150,'true');             
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
    
    function userresetpassword_callback ()
    {
        removedialog_process();window.location="http://shotlancer.com";
    }
    
    function cuspurchasecredit(plan,username)
    {
        var amount;
        switch (plan) {
            case '10':
                amount = '20';
                break;
            case '25':
                amount = '35';
                break;
            case '50':
                amount= '50';
                break;
        }
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/customer/purchasecredit",
            data:{
                amount: amount
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if(username == '')
                {window.location="/customer/register";}
                else
                {
                    $("#form_paypal").submit();
                }                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    function showuserdivmobile_process(div,modal)
    {
        if (modal=='true')
        {
            var overlay = jQuery('<div class="overlay"><div id="popupdialog" class="row"></div></div>');
            overlay.appendTo(document.body);   
        }
        else
        {
            var overlay = jQuery('<div id="popupdialog"></div>');
            overlay.appendTo(document.body);
        }
        var overlay1 = jQuery('<div id="popupdialog" class="row" style="width:100%"></div>');
        overlay1.html(div);
        overlay1
          .css({
                'position': 'fixed',
                'top': '10%',
                'margin-left':'10px',
                'z-index': '11000'
                
          });
        //overlay1.html(div);
        overlay1.appendTo(document.body);
    }
    
    function clearhiddendiv_process(div)
    {
        //removedialog_process();
        //alert ($('#'+div).html());
        $('#'+div).prop('hidden',true);
    }
    
    function loadreviewmessage(quality,title,tag,qualitytxt, titletxt, tagtxt, msg)
    {
        if (quality=='-1' && title =='-1' && tag=='-1')
        {
            $('#'+msg).text('Your image is being reviewed.');
        }
        else if (quality=='0' && title =='0' && tag=='0')
        {
            $('#'+msg).text('Your image is being reviewed.');
        }
        else
        {
            var warningmsg='';
            if (quality>0)
            {
                warningmsg= warningmsg  +qualitytxt + '. Please fix.</br></br>';
            }
            if (title>0)
            {
                warningmsg= warningmsg +titletxt + '. Please fix.</br></br>';
                $('#hidden_user_editimagetitle').append('<span class="warning">!</span>');
                
            }
            if (tag>0)
            {
                warningmsg= warningmsg +tagtxt + '. Please fix.</br></br>';
                $('#hidden_user_editimagetag').append('<span class="warning">!</span>');
            }
            $('#'+msg).html(warningmsg);
        }
        
    }
    
    
    function loadchangemessage(title,tag,titletxt, tagtxt)
    {
            if (title>0)
            {
                
                
            }
            if (tag>0)
            {
                
            }
    }


    function adminlogin_process (username,password)
    {
        $.ajax({
            type:"post",
            url:"http://administrator.shotlancer.com/login",
            data:{admin_un: username,admin_pw: password},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (parseInt(data)==2)
                {
                    window.location='http://administrator.shotlancer.com/home';
                 }
                 else
                 {
                    showfailure('LOGIN FAILED','Sorry, system cannot recognize your account and password','',150,-450);
                 }                            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }    
    
    function adminlogout_process(username)
    {
        $.ajax({
            type:"post",
            url:"http://administrator.shotlancer.com/logout",
            data:{admin_un: username},
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                window.location="http://administrator.shotlancer.com";                         
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }
    
    