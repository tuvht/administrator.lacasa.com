
    
	/*
	// validate email address based on common rules.
	*/
	function validateemail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    }
    /*
    // validate percentage based on common rules.
    */
    function validate_percentange(number){
        var expr = /^\d{0,100}$/;
        return expr.test(number);
    }
    
	/*
	//validate phone number based on common rule
	*/
    function validatephone(phone) {
        var expr = /^\d{5,15}$/;
        return expr.test(phone);
    }
    function validatespacing(text) {
        var expr = /^\S+$/;
        return expr.test(text);
    }
	
	/*
	// verify if a value is a number
	*/
    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

	
	/*
	// show a popup dialog in center of the screen
	// 		divhtml: html content of the dialog body
	//		width: width of the dialog
	//		height: height of the dialog
	//		modal: if true then dialog exclusively appears on the screen
	*/
    function showdialog(divhtml, width=400, height=300, modal='true')
    {
        if (modal=='true')
        {
            var overlay = jQuery('<div class="overlay row" style="width:100%;text-align:center;"><div id="popupdialog"></div></div>');
            overlay.appendTo(document.body);   
        }
        else
        {
            var overlay1 = jQuery('<div id="popupdialog"></div>');
            overlay1.appendTo(document.body);
        }
        var overlay1 = jQuery('<div id="popupdialog"></div>');
        overlay1.html('');
        overlay1
          .css({
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
                'width': width,
                'height: ': height,
                'left': '50%',
                'transform': 'translate(-50%,-50%)',
                'background': 'transparent',
                'z-index': '11000'  
          });
       
        overlay1.html(divhtml);
        overlay1.appendTo(document.body);
    }
    
	/*
	// remove the popup dialog opened by action showdialog of asiantech.js
	//		reload: if true then after closing dialog, page will be refreshed
	*/
    function removedialog(reload=true)
    {
        $( "div" ).remove( "#popupdialog" );
        $( "div" ).remove( ".overlay" );

        if (reload) location.reload();
    }
    
	/*
	// call back action to open a url for control defined in popupdialog
	// for ex: showdialog open a dialog, Clicking OK on that dialog will open a URL
	// 			we cannot add JS code inside another JS code, that's where callback action comes to play
	//		url: url to open
	*/
    function dialogclose_callback(url)
    {
        removedialog();
        if (url)
        {
            window.location=url;
        }
    }
    
	/*
	// show loading gif. Removed by calling removedialog() action
	// 		icon: icon file location. Usually read this from Configuration database
	//		size: size of the icon to be appear, width and height are equal
	*/
	
    function showloading(url, size='39')
    {
        showdialog('<div><img width="'+size+'" height ="'+size+'" src="'+url+'" /></div>','',-150,-150,'true');
    }
    
	/*
	// show error modal dialog
	//		msg: error message, if leave blank then a general message will be displayed
	*/
    function showerror(msg='',reload=false)
    {
        if (msg=='')
        {
            var divhtml=   '<div class="alert alert-danger">'+
                            '<div><h3>Opps! There is something wrong</h3></div>'+
                            '<div><hr /></div>'+
                            '<div><span>Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.</span></div>'+
                            '<div><input type="button" class="btn btn-primary" value="Close" onclick="removedialog('+reload+');" /></div>'
                        '</div>';
        }
        else {
            var divhtml=   '<div class="alert alert-danger">'+
                            '<div><h3>Opps! There is something wrong</h3></div>'+
                            '<div><hr /></div>'+
                            '<div><span>' + msg + '</span></div>'+
                            '<div><input type="button" class="btn btn-primary" value="Close" onclick="removedialog('+reload+');" /></div>'
                        '</div>';
        }
        showdialog(divhtml,'',-150,-150,'true');
    }
    
	/*
	// show failure dialog in general
	//		title: title of the dialog
	//		msg: failure message
	//		options: <option>...</option> list of available actions. optional
	*/

    function showfailure(title,msg,options='')
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
                            '<div><input type="button" class="btn btn-primary" value="Close" onclick="removedialog();"/></div>'+
                        '</div>';
                     showdialog(divhtml,'true');
    }
    
	/*
    // some sample ajax calls.
	//		1. call ajax action
	//		2. beforeSend: show a loading dialog
	//		3. if call succeed: remove the loading dialog and start checking result, if fail showfailure, if success....
	//		4. in case of ajax error: remove the loading dialog and show general error message
	*/

    function addtofavorite(ctrl,imageid,imagepath)
    {
        $.ajax({
            type:"post",
            url:"http://shotlancer.com/image/addtofavorite",
            data: {image_id:imageid, image_path:imagepath},
            beforeSend: function ( xhr ) {
                showloading('images/icon.gif');
            },
            success:function(resp){
                removedialog();
                if (resp=='false')
                {
                    showfailure('ERROR','Sorry, maximum 10 images in favorites only.','');
                }
                else
                {
                    $('#header_favorite').html(resp);
                    ctrl.src ='/application/views/images/favoriteblue.png';
                    ctrl.unbind('click');
                }
            },
            error:function (request, status, error) {
                removedialog();
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
                showloading('images/icon.gif');
            },
            success:function(resp){
                removedialog();
                window.location='/';
            },
            error:function (request, status, error) {
                removedialog();
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
                showloading('images/icon.gif');
            },
            success:function(resp){
                removedialog();
                $('#header_favorite').html(resp);
                ctrl.src ='/application/views/images/favoriteblack.png';
            },
            error:function (request, status, error) {
                removedialog();
                showerror();
            }
        });    
    }
    
    
	/*
	//	ajax login, logout
	//		url: the route part of the url starts with a slash, for ex: "/customer/login" , "/product/get/all"
    */
    
    function customerlogin_process(url,username,password)
    {
         $.ajax({
            type:"post",
            url: window.location.hostname+url,
            data:{cus_un: username,cus_pw: password},
            beforeSend: function ( xhr ) {
               showloading('images/icon.gif');
            },
            success:function(data){
                removedialog();
                if (parseInt(data)==2)
                {
                    window.location='http://shotlancer.com/customer/home';
                 }
                 else
                 {
                    showfailure('LOGIN FAILED','Sorry, system cannot recognize your account and password','<span style="float:left"><a href="http://shotlancer.com/customer/register">Register</a></span><span style="float:right"><a href="http://shotlancer.com/customer/forgotpassword">Forgot your password?</a></span>');
                 }                            
            },
            error:function (request, status, error) {
                removedialog();
                showerror();
            }
        }); 
    }
    
	
    function customerlogout_process(url,username)
    {
         $.ajax({
            type:"post",
            url:window.location.hostname+url,
            data:{cus_un: username},
            beforeSend: function ( xhr ) {
               showloading('images/icon.gif');
            },
            success:function(data){
                removedialog();
                window.location="http://shotlancer.com";                         
            },
            error:function (request, status, error) {
                removedialog();
                showerror();
            }
        });    
    }
    
    
    /*
	// check if username / email already exist while registering
	// backend php will return result, either true or false.
	//		field: the field to be checked again, for ex: username, email....
    */
    function checkfieldexist(url, value, field) 
    {   
        var result;
        $.ajax({
            type:"post",
            async: false,
            url: window.location.hostname+url,
            data:{val: value, field:field},
            success:function(data){
                result=data;
            },
            error:function (request, status, error) {
                removedialog();
                showerror();
            }
        }); 
        return result;
    }
    
    
	/*
	// sample ajax FIELD validation. the rule for each field is defined as wish.
	// this check is usually declared in "onchange" trigger of the control.
	// each field can be validated by multiple rules. for example: username will be check for length and uniqueness
	// typically each field in HTML will have a div right below it to display error message
	//		control2: ID of the secondary control in case validation requires a comparision, for ex: password and re-password field
	*/
    function validate_field(type, control, min=1, max=64, validation_div, error_msg='Validation error', control2='')
    {   
        switch (type) {
            case 'username':
                if ($('#'+control).val().length < min || $('#'+control).val().length > max)
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                if (checkfieldexist('/customer/checkduplicate',$('#'+ctrl).val(),'username')!=0)
                    {
                        $ ('#'+validation_div).text('This username is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');return true;}
                break;
                
            case 'password':
                if ($('#'+control).val().length < min || $('#'+control).val().length > max)
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');return true;}
                break;
            
            case 're-password':
                if ($('#'+control).val() != $('#'+control2).val())
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');return true;}
                break;
                
            case 'name':
                if ($('#'+control).val().length < min || $('#'+control).val().length > max)
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');;return true;}
                break;
                
            case 'address':
                if ($('#'+control).val().length < min || $('#'+control).val().length > max)
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');;return true;}
                break;
                
            case 'email':                                                                            
                if (!validateemail($('#'+ctrl).val()))
                    {
                        $ ('#'+validation_div).text(error_msg);
                        return false;
                        break;
                    }
                if (checkfieldexist('/customer/checkduplicate',$('#'+ctrl).val(),'email')!=0)
                    {
                        $ ('#'+validation_div).text('This email address is already in our system. Please choose another one');
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validation_div).text('');return true;}
                break;
            
        }
    }
    
	/*
	// sample FORM validation. Usually this is form by form different
	// Example below is for normal Customer Registration form.
	// 		1. Clear value all the Validation Div of each field.
	//		2. Do first round of Required field check. Before proceed detail field validation.
	//		3. Call FIELD validation for each field, and put result into a variable for each of them
	//		4. Check all the result altogether, if all TRUE then submit form
	*/
    function cusregistervalidateform_process()
    {    
        //validation before calling ajax update method
        var flag=true;
        
		// trigger the onChange of all controls.
        $ ('#txtpassword').change();
        $ ('#txtrepassword').change();
        $ ('#txtname').change();
        $ ('#txtemail').change();
        $ ('#txtaddress').change();
       
		// do a simple round of required fields not null check
        if ($ ('#txtpassword').val().length==0)
        {
            flag = false;
            $ ('#div_validation_password').text('Required field');
        }
        if ($ ('#txtrepassword').val().length==0)
        {
            flag = false;
            $ ('#div_validation_repassword').text('Required field');
        }
        if ($ ('#txtname').val().length==0)
        {
            flag = false;
            $ ('#div_validation_name').text('Required field');
        }
        if ($ ('#txtemail').val().length==0)
        {
            flag = false;
            $ ('#div_validation_email').text('Required field');
        }
        if ($ ('#txtaddress').val().length==0)
        {
            flag = false;
            $ ('#div_validation_address').text('Required field');
        }
        
        if (flag)
        {
            var valstatus_pw=validate_field('password','txtpassword',5,64,'validation_div_password','Password must be between 5 - 64 characters');
            var valstatus_repw=validate_field('re-password','txtrepassword',5,64,'validation_div_repassword','Password confirmation is not correct','txtpassword');
            var valstatus_name=validate_field('name','txtname',10,128,'validation_div_name','Name must be between 10 - 128 characters');
            var valstatus_email=validate_field('email','txtemail','','','validation_div_email','Please input valid email address');
            var valstatus_address=validate_field('address','txtaddress',10,200,'validation_div_address','Address must be between 10 - 200 characters');
            if (valstatus_pw && valstatus_repw && valstatus_name && valstatus_email && valstatus_address ) 
            {
                // call some action to perform the task or just return true if this action is trigger in "onsubmit" of object FORM
				return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }
    
   
    
	/*
	// sample of confirmation dialog
	*/
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
                                '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog();"/>'+
                            '</div>'+
                               
                        '</div>';
        showdialog(divhtml,'true');
    }
    
    
    /*
	// sample dialog display data in table format, data array return from ajax.
	// backend need to return value in the below format, where $user_info = $query->result_array(); CodeIgniter
	//		echo json_encode($user_info);
    //	    return json_encode($user_info);    
	*/
    function usertopdownload_show()
    { 
        $.ajax({
            type:"post",
            dataType: "text",
            url:"http://shotlancer.com/user/gettopdownload/20",
            data:{user_un: document.getElementById("user_edituserid").value},
            beforeSend: function ( xhr ) {
                showloading();
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
                removedialog();
                showerror();
            }
        });    
    }
	
	/*
	// IMPORT FROM EXCEL, CSV
	//
	*/
    function importcsv(object, fieldlist)
    {
        var divhtml=   '<form name="importform" id="importform" action="importexcel" method="post" enctype="multipart/form-data">'+
                        '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading">Import from CSV</div><div class="panel-body">'+
                            '<div><input type="file" name="importfile" id="importfile"></div>'+
                            '<hr />'+
                            '<div style="width:100%">Column: '+fieldlist+'</div>'+
                            '<hr />'+
                            '<div class="centerdiv">'+
                                '<input type="submit" class="btn btn-danger" value="Import" onclick="importcsv_process(event,\''+object+'\');"/><div class="divider"></div>'+
                                '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();"/>'+
                            '</div>';      
                        '</div></div></form>';
        showdialog_process(divhtml,'true');
    }

    function importcsv_process(e,object)
    {   
        e.preventDefault();
        var formData = new FormData();
        formData.append("importfile",$('input[type=file]')[0].files[0]);
     
         $.ajax({
            xhr: function()
        {
        var xhr = new window.XMLHttpRequest();
        //Upload progress
        xhr.upload.addEventListener("progress", function(evt){
         if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
            var divhtml = '<div>'+
                                '<div><img width="39" height ="39" src="../images/loading.gif"/></div>'+
                                '<div>Uploading ' + Math.round(percentComplete*100)+ '%</div>'+
                            '</div>';
            showdialog_process(divhtml,'true');         
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
            url:"http://"+window.location.hostname+"/"+object+"/importexcel",
            data: formData,
             contentType: false,
             processData: false,
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                if (parseInt(data)==0)
                {
                    showfailure('Import failed','There is something wrong with selected file, please try again','',-150,-150);
                }
                else
                {
                    var divhtml =   '<div class="panel panel-success centerdiv">'+
                                        '<div class="panel-heading">Import successfully</div><div class="panel-body">'+
                                        '<div class="centerdiv"><input type="button" class"btn btn-primary" value="Close" onclick="removedialog_process(1);" /></div>'+    
                                    '</div></div>';
                    showdialog_process(divhtml,'true');
                }                       

            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }
	
  
    /*
	// IMAGE EDIT FEATURE USING JS AND guillotine LIBRARY, downloadt at https://asiantechhub.app.box.com/file/171176380030
	// When we need to do upload and preview, just use this. 
	// Default image ratio is 4:3. Change requires direct modification into the below script by writter.
	// DO NOT MODIFY
	*/
	
	/* USAGE
	include
		<link rel="stylesheet" type="text/css" href="/libraries/guillotine-master/css/jquery.guillotine.css" />
		<script  type="text/javascript" src="/libraries/guillotine-master/js/jquery.guillotine.js"></script>
	html
		<div role="tabpanel" class="tab-pane" id="images">
		  <a onclick="calladdpicture();"><img src="/images/icon_upload.png"></a>
		</div>
	javascript
		function calladdpicture()
		{
			addpicture(place_id,image_minimum_dimension,image_maximum_size);
		}
	
	*/
	
    function addpicture (placeid,image_minimum_dimension,image_maximum_size)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+ "/place/getimagecount",
            data:{id: placeid},
            beforeSend: function ( xhr ) {
            },
            success:function(resp){
                if (parseInt(resp)==0)
                {
                    showerror('Maximum upload reached');
                }
                else
                {
                    addpicture_process (placeid,image_minimum_dimension,image_maximum_size);
                }
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });
    }

    function addpicture_process (placeid,image_minimum_dimension,image_maximum_size)
    {     
        var divhtml=   
                        '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading"><span>Upload picture</span><span style="float:right"></span></div>'+
                            '<div class="panel-body" style="overflow-y: none;height: 800px;">';

        divhtml = divhtml+    '<form name="form_uploadfile" id="form_uploadfile" method="POST" action="place/uploadimage" enctype="multipart/form-data">';
        divhtml = divhtml+    '<input type="hidden" name="MAX_FILE_SIZE" value="'+ (image_maximum_size *1024) +'" />';
        divhtml = divhtml+    '<input type="hidden" name="img_maxsize" id="img_maxsize" value="'+image_maximum_size+'" />';
        divhtml = divhtml+    '<input type="hidden" name="place_id" id="place_id" value="'+placeid+'" />';
        divhtml = divhtml+    '<div class="jumbotron">';
        divhtml = divhtml+    '<div>';
        divhtml = divhtml+        '<input type="file" id="userfile" name="userfile" class="user_upload_image_submit" />';
        divhtml = divhtml+    '</div>';
        divhtml = divhtml+    '<div>';
        divhtml = divhtml+        '<br /><span class="user_upload_image_field_example">Choose an image with at least '+image_minimum_dimension+'px of width and height</span>';
        divhtml = divhtml+    '</div>';
        divhtml = divhtml+    '<div><span id="val_file_file" class="form_field_validation"></span></div>';
        divhtml = divhtml+    '</div>';
        divhtml = divhtml+    '<div>';
        divhtml = divhtml+        '<div>';
        divhtml = divhtml+            '<div id="div_image_review_square" class="image_review_square">';
        divhtml = divhtml+                '<img id="image_review_square" width="400" height="300" class="user_input_image_upload"/>';
        divhtml = divhtml+            '</div>';
        divhtml = divhtml+            '<div class="row">';
        divhtml = divhtml+                '<label class="control-label">Short description: </label>'
        divhtml = divhtml+                '<input class="dialog_input_text form-control" id="img_description" name="img_description" maxlength="50" />';
        divhtml = divhtml+            '</div>';
        divhtml = divhtml+    '<div><span id="val_file_desc" class="form_field_validation"></span></div>';
        divhtml = divhtml+           '<div id="controls_square">';
        divhtml = divhtml+                '<button  id="rotate_left_square" type="button" title="Rotate left"><i class="fa fa-rotate-left"></i></button>';
        divhtml = divhtml+                '<button id="zoom_out_square" type="button" title="Zoom out"><i class="fa fa-search-minus"></i></button>';
        divhtml = divhtml+                '<button hidden="true" id="fit_square" type="button" title="Fit image"> [ ] </button>';
        divhtml = divhtml+                '<button id="zoom_in_square" type="button" title="Zoom in"><i class="fa fa-search-plus"></i></button>';
        divhtml = divhtml+                '<button id="rotate_right_square" type="button" title="Rotate right"><i class="fa fa-rotate-right"></i></button>';
        divhtml = divhtml+            '</div>';
        divhtml = divhtml+            '<ul id="data_square">';
        divhtml = divhtml+              '<div class="column">';
        divhtml = divhtml+                '<li hidden="true">scale: <span id="scale_square"></span></li>';
        divhtml = divhtml+                '<li hidden="true">x: <span id="x_square"></span></li>';
        divhtml = divhtml+                '<li hidden="true">y: <span id="y_square"></span></li>';
        divhtml = divhtml+                '<li hidden="true">width: <span id="w_square"></span></li>';
        divhtml = divhtml+                '<li hidden="true">height: <span id="h_square"></span></li>';
        divhtml = divhtml+                '<li><span class="image_detail_info_label">width: </span><span id="w1_square"></span></li>';
        divhtml = divhtml+                '<li><span class="image_detail_info_label">height: </span><span id="h1_square"></span></li>';
        divhtml = divhtml+                '<li hidden="true"><span class="image_detail_info_label">scale: </span><span id="scale_square"></span></li>';
        divhtml = divhtml+               '<li hidden="true"><span class="image_detail_info_label">angle: </span><span id="angle_square"></span></li>';
        divhtml = divhtml+              '</div>';
        divhtml = divhtml+            '</ul>';
        divhtml = divhtml+    '</div>';
        divhtml = divhtml+    '<div><span id="val_file_image" class="form_field_validation"></span></div>';
        divhtml = divhtml+    '<input id="btn_submit" name="btn_submit" class="btn btn-primary" type="button" value="Upload" onclick="uploadvalidate();" />';
        divhtml = divhtml+    '<input id="btn_submit" name="btn_submit" class="btn btn-warning" type="button" value="Cancel" onclick="removedialog_process();" />';
        divhtml = divhtml+  '</form></div></div>';


        showdialog_process(divhtml,'true');

        $("#userfile").change(function () {
                readURL(this, image_minimum_dimension, image_maximum_size);
            });
     
        var script = document.createElement('script');
        script.src='/libraries/guillotine-master/js/jquery.guillotine.js';
        document.getElementsByTagName('head')[0].appendChild(script);
          
    }

    function readURL(input, image_minimum_dimension) {
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
                    if (minsize<image_minimum_dimension)
                    {
                        $('#div_image_review_square').html('');
                        $('#userfile').val("");
                        $ ('#val_file_file').text('Image must be at least '+ image_minimum_dimension +'pixel width or height, please choose bigger one.');
                        
                        flag = false;
                    }
                };
                img.src = reader.result;
                if(flag==true)
                {               
                    $('#div_image_review_square').html('');   
                    $('#div_image_review_square').append('<img id="image_review_square" src="#" style="border:1px solid #000000" />');
                
                    //showloading();
                    /*setTimeout(function(){
                        removedialog_process();
                        $('#fit').click();
                    }, 3000);*/
                    
                    var _this = this;
                    var picturesquare = $('#image_review_square');
                  
                    $('#image_review_square').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    $('#image_review_square').attr('src', e.target.result);
                   
                    var _this = this;
            
                    picturesquare.file=input.files[0];
                    picturesquare.src=e.target.result;
                 
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
                    
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function load_image_plugin()
    {
        var picturesquare = $('#image_review_square');
        picturesquare.guillotine({width: 400, height: 300,//setup new plugin instance
            onChange: function(data, action){
                data.scale = parseFloat(data.scale.toFixed(4)); //alert(data.x1);
                for(var k in data) { $('#'+k+'_square').html(data[k]); }
                    $('#scale_square').html(data['scale']);
                var tempw=data['w']/ data['scale'];
                var temph=data['h']/ data['scale'];
                $('#w1_square').html(Math.round(tempw));
                $('#h1_square').html(Math.round(temph));
                //picturesquare.addClass('user_input_image_upload');
            }});
        $('#rotate_left_square').click(function(){ picturesquare.guillotine('rotateLeft'); });
        $('#rotate_right_square').click(function(){ picturesquare.guillotine('rotateRight'); });
        $('#fit_square').click(function(){ picturesquare.guillotine('fit'); });
        $('#zoom_in_square').click(function(){ picturesquare.guillotine('zoomIn'); });
        $('#zoom_out_square').click(function(){ picturesquare.guillotine('zoomOut'); });
        $('#fit_square').click();
   
    }

    function uploadvalidate()
    {
        

        var data = []; 
        data[0]=$("#x_square").text();
        data[1]=$("#y_square").text();
        data[2]=$("#w_square").text();
        data[3]=$("#h_square").text();
        data[4]=$("#scale_square").text();
        data[5]=$("#angle_square").text();
        data[6]=$("#w1_square").text();
        data[7]=$("#h1_square").text();
        data[8]=$("#place_id").val();
        data[9]=$("#img_description").val();
        data[10]=$("#img_maxsize").val();
       
        useruploadform_validate(data);
    }  

    function useruploadform_validate(data)
    {
        var flag=true;
        valstatus_file=true;
        valstatus_desc=true;

        $ ('#val_file_file').text('');
        $ ('#val_file_image').text('');
        $ ('#val_file_desc').text('');

        if ($('#img_description').val().length<1 || $('#img_description').val().length>50 )
        {
            flag = false;
            valstatus_desc=false;
            $ ('#val_file_desc').text('Please input upto 50 characters for image description');
        }

        if (!($('#userfile')[0].value))
        {
            flag = false;
            valstatus_file=false;
            $ ('#val_file_file').text('Please choose your image to upload');
        }

        else if ($('#userfile')[0].files[0].type !="image/jpg" && $('#userfile')[0].files[0].type !="image/jpeg")
        {
            flag = false;
            valstatus_file=false;
            $ ('#val_file_file').text('Only JPG, JPEG files are allowed');
        }

        else if (($('#userfile')[0].files[0].size)/1000>data[10])
        {
            flag = false;
            valstatus_file=false;
            $ ('#val_file_file').text('Maximum file size is '+data[10]+' KB');
        }

        if (flag)
        {
            var valstatus_file = useruploadfield_validate('file', 'userfile','','val_file_file');
            var valstatus_desc = useruploadfield_validate('text', 'img_description',50,'val_file_desc');
            if (valstatus_file) 
            {
                user_uploadimage(data);
            }
            else
            {
                return false;
            } 
        }  
    }

    function user_uploadimage(data)
    {   
        var formData = new FormData();
        formData.append("userfile",$('input[type=file]')[0].files[0]);
    
        //square image params
        var place_id = data[8];
        formData.append("place_id",data[8]);
        formData.append("img_description",data[9]);
        formData.append("img_maxsize",data[10]);
        formData.append("image_x_square",data[0]);
        formData.append("image_y_square",data[1]);
        formData.append("image_w_square",data[2]);
        formData.append("image_h_square",data[3]);
        formData.append("image_scale_square",data[4]);
        formData.append("image_angle_square",data[5]);
        formData.append("image_w1_square",data[6]);
        formData.append("image_h1_square",data[7]);

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
                                '<div><img width="39" height ="39" src="/images/loading.gif"/></col=div>'+
                                '<div style="background-color:white">Uploading ' + Math.round(percentComplete*100)+ '%</div>'+
                            '</div>';
            showdialog_process(divhtml,'true');         
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
            url:"http://"+window.location.hostname+ "/place/uploadimage",
            data: formData,
             contentType: false,
             processData: false,
            beforeSend: function ( xhr ) {
               removedialog_process(); 
               //showloading();
            },
            success:function(data){
                removedialog_process();
                jQuery('#place-image').append(data);                              
            },
            error:function (request, status, error) {
                //alert (error);
                removedialog_process();
                showerror();
            }
        });    
    }

    function useruploadfield_validate(type, control, length, validationCtrl, require='true')
    {
        switch (type) {
            case 'text':
                if ($('#'+control).val().length <length)
                    {
                        
                        $ ('#val_file_title').text('Please input up to ' + length + ' characters for the title of your picture');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'tags':
                if (counttags('file_tags') <3)
                    {
                        $ ('#val_file_tags').text('Please choose 3 - 10 tags for your pictures so people can search easily');
                        return false;
                        break;
                    }
                else
                    {$ ('#val_file_tags').text('');return true;break;}
                break;
            
            case 'file':
                if (!($('#'+control)[0].value))
                    {
                        $('#'+validationCtrl).text('Please choose your image to upload');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;
        }
    }
    
    
    /*
    Use for submit form create 
    type: text, number,...
    control : object need check validate before submit
    min: min length allow
    max: max length allow
    validation_div: div will have add have error.
    error_msg: content of error, will show on div err
    */
    
    function validatefield_merlinski(type,functions='', control, min=1, max=64, validation_div, error_msg='Validation error',error_msg2='', control2=''){
         switch (type) {
            case 'text': 
                

                if (jQuery(control).val() > max)
                {
                   validation_div.removeClass('has-error has-success').addClass('has-error');
                    validation_div.find('.err').text(error_msg2).show();
                    validation_div.find('.form-control-feedback').removeClass('hidden glyphicon-remove glyphicon-ok').addClass('glyphicon-remove');

                    event.preventDefault();
                    return true;
                }
                else
                {
                    
                    if (functions($(control).val())==false) 
                    {
                        validation_div.removeClass('has-error has-success').addClass('has-error');
                        validation_div.find('.err').text(error_msg).show();
                        validation_div.find('.form-control-feedback').removeClass('hidden glyphicon-remove glyphicon-ok').addClass('glyphicon-remove');
                        event.preventDefault();
                        return true;
                         
                        break;                      
                        
                    }
                    else{
                        validation_div.removeClass('has-error has-success').addClass('has-success');
                        validation_div.find('.err').text('').hide();                   
                        validation_div.find('.form-control-feedback').removeClass('hidden glyphicon-remove glyphicon-ok').addClass('glyphicon-ok');  
                        return true;
                        break;                  
                    }
                }
            break;
            case 'percentage': 
                var percentage = parseFloat($(control).val());              
                if (functions(percentage)==false) 
                {
                    validation_div.addClass('has-error');
                    validation_div.find('.err').text(error_msg);
                    validation_div.find('.form-control-feedback').removeClass('hidden glyphicon-remove glyphicon-ok').addClass('glyphicon-remove');
                    event.preventDefault();
                    return true;

                    break;                      
                    
                }
                else{
                    validation_div.addClass('has-success');
                    validation_div.find('.err').text('');                    
                    validation_div.find('.form-control-feedback').removeClass('hidden glyphicon-remove glyphicon-ok').addClass('glyphicon-ok');  
                    return true;
                    break;                  
                }
            break;
         }
    }
    
     // sample of confirmation dialog
    
    function showdialog_confirm(title,description,options='', Action, Params1, Params2 )
    {
        var divhtml=   '<div class="showdialog_confirm panel panel-body"> '+
                            '<div>'+
                                '<h3>'+title+'</h3>'+
                            '</div>'+
                            '<div><hr /></div>'+
                            '<div>'+
                                '<span>'+description+'</span>'+
                            '</div>';
                            if (options!=''){
                                divhtml=divhtml+ 
                                '<div>'+options+'</div>';
                            }

        if ((Params1 != "" || Params1 == "") && Params2 == ""){    
        divhtml = divhtml+ '<div><hr /></div>'+
                            '<div style="spacing: 10px">'+
                                '<input type="button" class="btn btn-warning" value="Yes" onclick="'+Action+'(\''+Params1+'\');"/>'+
                                '<input type="button" class="btn btn-default pull-right" value="Cancel" onclick="removedialog(false);"/>'+
                            '</div>'+
                               
                        '</div>';

        } else if(Params1 != "" && Params2 != ""){
        divhtml = divhtml+ '<div><hr /></div>'+
                            '<div style="spacing: 10px">'+
                                '<input type="button" class="btn btn-warning" value="Yes" onclick="'+Action+'(\''+Params1+'\',\''+Params2+'\');"/>'+
                                '<input type="button" class="btn btn-default pull-right" value="Cancel" onclick="removedialog(false);"/>'+
                            '</div>'+
                               
                        '</div>';  
        }
        showdialog(divhtml,'true');

        
    }