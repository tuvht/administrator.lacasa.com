

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

    function deactivate (type,id)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+"/deactivate/"+type,
            data:{
                id: id
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }  

    function exportpdf (object,view,query,column,type)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+"/"+object+"/exportpdf",
            data:{
                query: query,
                sort:type,
                column: column,
                view:view
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }  

    function activate (type,id)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+"/activate/"+type,
            data:{
                id: id
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        }); 
    }

    function deleteitem (type,id)
    {
        if (id.constructor === Array)
        {

            var paramArray = [];
            for (i=0;i<id.length;i++)
            {
                paramArray[i] = id[i].id;}   
        }
        else
        {
            var paramArray = id;
        }  
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+"/delete/"+type,
            data:{
                id: paramArray
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });            
    }

    function assignagent (placeid)
    {
        $.ajax({
            type:"post",
            dataType: "json",
            url:"http://"+window.location.hostname+"/agent/getlist",
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(data){
                removedialog_process();
                var obj = data;
                var divhtml=   
                                '<div class="panel panel-info centerdiv">'+
                                    '<div class="panel-heading"><span>Select agent</span><span style="float:right"></span></div>'+
                                    '<div class="panel-body" style="overflow-y: scroll;height: 350px;">'+
                                    '<table class="table table-hover">';
                if (obj.length>0)
                {
               
                    divhtml = divhtml+'<tr sytle="text-align:center;width:100%">'+
                                            '<th><span></span></th>'+
                                            '<th><span>ID</span></th>'+
                                            '<th><span>Name</span></th>'+
                                            '<th><span>Email</span></th>'+
                                            '<th><span>Phone</span></th>'+
                                            '<th><span>Country</span></th>'+
                                            '<th><span>City</span></th>'+
                                        '</tr>';
                    divhtml=divhtml + '<tr><td><input type="button" class="btn btn-info" value="No use agent" onclick="assignagent_process('+placeid+',0);"/>' + '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';

                    for (i=0;i<obj.length;i++)
                    {
                        divhtml=divhtml + '<tr><td><input type="button" class="btn btn-info" value="Select" onclick="assignagent_process('+placeid+','+obj[i].id+');"/>' + '</td><td>' + obj[i].id + '</td><td>' +obj[i].name + '</td><td>' + obj[i].email + '</td><td>' + obj[i].phone + '</td><td>' + obj[i].country +'</td><td>' + obj[i].city + '</td></tr>';
                    }   
                }


                else
                {divhtml=divhtml + '<tr><th><span>There is no agent</span></th></tr>';}                                         
                var divhtml=divhtml + '</table></div>';
                divhtml=divhtml + '<div class="centerdiv">'+
                                '<input type="button"  class="btn btn-warning" value="Cancel" onclick="removedialog_process();"/>'+
                            '</div></div>';


                showdialog_process(divhtml,'true');
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });    
    }

    function assignagent_process(placeid,agentid)
    {
        $.ajax({
            type:"post",
            data:{
                place: placeid,
                agent: agentid
                },
            url:"http://"+window.location.hostname+"/place/assignagent",
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });

    }

    function addrenthistory (placeid)
    {       
        var option_list = '';
        $.ajax({
            type:"post",
            dataType: "json",
            url:"http://"+window.location.hostname+"/rentpurpose/getlist",
            beforeSend: function ( xhr ) {
                showloading();
            },
            success:function(data){
                removedialog_process();
                var obj = data;
                
                var optionlist= '';
                if (obj.length>0)
                {
                    for (i=0;i<obj.length;i++)
                    {
                        optionlist=optionlist + '<option value="'+ obj[i].id +'">'+ obj[i].value +'</option>';
                    }   
                }
                var divhtml=   
                        '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading"><span>Add rent history</span><span style="float:right"></span></div>'+
                            '<div class="panel-body" style="overflow-y: scroll;height: 350px;">';

                divhtml = divhtml+ '<form action="/place/addrenthistory" method="post" enctype="multipart/form-data" name="addrentform" id="addrentform2">';
                divhtml = divhtml+   '<div class="row">';
                divhtml = divhtml+       '<label for="purpose_id" style="float:left" class="col-sm-2 control-label">Purpose</label>';
                divhtml = divhtml+       '<select style="float:right" class="col-sm-8" name="purpose_id" id="purpose_id">'+ optionlist +'</select>';
                divhtml = divhtml+   '</div>';
                divhtml = divhtml+   '<div class="row">';
                divhtml = divhtml+       '<label for="from" class="col-sm-2 control-label">From</label>';
                divhtml = divhtml+       '<input style="float:right" class="col-sm-8" type="text" name="frombox" id="frombox">';
                divhtml = divhtml+   '</div>';
                divhtml = divhtml+   '<div class="row">';
                divhtml = divhtml+       '<label for="to" class="col-sm-2 control-label">To</label>';
                divhtml = divhtml+       '<input style="float:right" class="col-sm-8" type="text" id="tobox" name="tobox">';
                divhtml = divhtml+   '</div>';
                divhtml = divhtml+  ' <div class="row">';
                divhtml = divhtml+       '<label for="description" class="col-sm-2 control-label">Description</label>';
                divhtml = divhtml+       '<textarea style="float:right" class="col-sm-8" row="4" name="description" id="description"></textarea>';
                divhtml = divhtml+   '</div><br/>';
                divhtml = divhtml+   '<div class="centerdiv">';
                divhtml = divhtml+     '<input name="Submit" class="btn btn-primary" type="submit" value="Add">';
                divhtml = divhtml+     '<input type="button"  class="btn btn-warning" value="Cancel" onclick="removedialog_process();"/>';
                divhtml = divhtml+   '</div>';
                divhtml = divhtml+   '<input type="hidden" name="id" id="id" value="'+ placeid +'"/>';
                divhtml = divhtml+ '</form></div></div>';

                showdialog_process(divhtml,'true');

                $( function() {
                    $( "#frombox" ).datepicker();
                    $( "#frombox" ).datepicker("option", "dateFormat", "yy-mm-dd");
                    $( "#tobox" ).datepicker();
                    $( "#tobox" ).datepicker("option", "dateFormat", "yy-mm-dd");
                  } );
            },
            error:function (request, status, error) {
                //alert (error);
                removedialog_process();
                showerror();
            }
        });
    }

    function approveplace (placeid)
    {
        var divhtml=   '<form name="importform" id="importform" method="post" enctype="multipart/form-data">'+
                        '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading">Confirm to approve this place</div><div class="panel-body">'+
                            '<hr />'+
                            '<div class="centerdiv">'+
                                '<input type="submit" class="btn btn-danger" value="Yes" onclick="approveplace_process(\''+placeid+'\');"/><div class="divider"></div>'+
                                '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();"/>'+
                            '</div>';      
                        '</div></div></form>';
        showdialog_process(divhtml,'true');
    }

    function approveplace_process (placeid)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+ "/place/approve",
            data:{id: placeid},
            beforeSend: function ( xhr ) {
            },
            success:function(resp){
                window.location="http://"+window.location.hostname+'/place/active';
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });
    }

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
                        //$('#div_image_review_lanscape').html('');
                        //$('#div_image_review_portrait').html('');
                        $('#userfile').val("");
                        $ ('#val_file_file').text('Image must be at least '+ image_minimum_dimension +'pixel width or height, please choose bigger one.');
                        
                        flag = false;
                    }
                };
                img.src = reader.result;
                if(flag==true)
                {               
                    $('#div_image_review_square').html('');
                    //$('#div_image_review_lanscape').html('');
                    //$('#div_image_review_portrait').html('');
                        
                    $('#div_image_review_square').append('<img id="image_review_square" src="#" style="border:1px solid #000000" />');
                    //$('#div_image_review_lanscape').append('<img id="image_review_lanscape" src="#" style="border:1px solid #000000" />');
                    //$('#div_image_review_portrait').append('<img id="image_review_portrait" src="#" style="border:1px solid #000000" />');
                    
                    //showloading();
                    /*setTimeout(function(){
                        removedialog_process();
                        $('#fit').click();
                    }, 3000);*/
                    
                    var _this = this;
                    var picturesquare = $('#image_review_square');
                    //var picturelanscape = $('#image_review_lanscape');
                    //var pictureportrait = $('#image_review_portrait');
                    
                    $('#image_review_square').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    $('#image_review_square').attr('src', e.target.result);
                    //$('#image_review_lanscape').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    //$('#image_review_lanscape').attr('src', e.target.result);
                    //$('#image_review_portrait').css('background', 'transparent url('+e.target.result +') left top no-repeat');
                    //$('#image_review_portrait').attr('src', e.target.result);
                    
                    var _this = this;
            
                    picturesquare.file=input.files[0];
                    picturesquare.src=e.target.result;
                    //picturelanscape.file=input.files[0];
                    //picturelanscape.src=e.target.result;
                    //pictureportrait.file=input.files[0];
                    //pictureportrait.src=e.target.result;
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
                     /*picturelanscape.onload = function() 
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
                    
                     };*/
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

        /*$('#image_review_square').load(function () {//each time when image is loaded
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
            //$('#fit_square').click();
        });
        
        /*var picturelanscape = $('#image_review_lanscape');
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
        });  */
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
                if (data=="The image is not a valid JPEG format")
                    showerror(data);
                else if (data=="Upload fail. Please try again later.")
                    showerror(data);
                else{
                jQuery('#place-image').append(data);}                              
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

    function field_validate(type, control, max=99, min=0, validationCtrl, require='true', msg, object='', msgsummary='',checkDuplicate=false)
    {
        $('#'+validationCtrl).text('');
        switch (type) {

            case 'select':
                if ($('#'+control).val()== 0 || $('#'+control).val()==null)
                    {
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'text':
                if ($('#'+control).val().length > max || $('#'+control).val().length < min || $('#'+control).val().length==0)
                    {
                        
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else if (checkDuplicate)
                  {
                      if (checknameexist($('#'+control).val(),object))
                      {
                          $('#'+control).closest('div').children('.form_field_validation').text("This name has been used.");
                          if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                              return false;
                              break;
                      }
                  }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'number':
                if (!isNumber($('#'+control).val()) || $('#'+control).val().length==0 || parseInt($('#'+control).val())>max || parseInt($('#'+control).val())<min)
                    {
                        
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'repassword':
                if ($('#'+control).val().length==0 || $('#'+control).val() != $('#'+control.substr(2,control.length)).val())
                    {
                        
                        $ ('#'+validationCtrl).text(msg);
                       if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'email':
                if (!validateemail($('#'+control).val()))
                    {
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                if (checkemailexist($('#'+control).val(),object))
                    {
                        $ ('#'+validationCtrl).text("This email has been registered");
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                            return false;
                            break;
                    }
                    
                else{ $('#'+validationCtrl).text('');return true;break;}
                break;

            case 'phone':
                if (!validatephone($('#'+control).val()))
                    {
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'tags':
                if (counttags($('#'+control)) <3)
                    {
                        $ ('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$ ('#'+validationCtrl).text('');return true;break;}
                break;
            
            case 'file':
                if (!($('#'+control)[0].value))
                    {
                        $('#'+validationCtrl).text(msg);
                       if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;

            case 'table':
                if ($('#'+control+' tr').length<min || $('#'+control+' tr').length>max)
                    {
                        $('#'+validationCtrl).text(msg);
                        if (msgsummary!='') $ ('#'+msgsummary).append('- '+msg+'<br/>');
                        return false;
                        break;
                    }
                else
                    {$('#'+validationCtrl).text('');return true;break;}
                break;
        }
    }

    function checkemailexist(email, object)
    {
        var result;
        $.ajax({
            type:"post",
            async: false,
            url:"http://"+window.location.hostname+"/"+object+"/checkemailexist",
            data:{
                email: email
                },
            beforeSend: function ( xhr ) {
               // showloading();
            },
            success:function(data){
                // removedialog_process();
                if (parseInt(data)==1) result=1;
                else result=0;            
            },
            error:function (request, status, error) {
                 removedialog_process();
                 showerror();
            }
        });
        return result;
    }

    function checknameexist(name, object)
    {
        var result;
        $.ajax({
            type:"post",
            async: false,
            url:"http://"+window.location.hostname+"/"+object+"/checknameexist",
            data:{
                name: name
                },
            beforeSend: function ( xhr ) {
               //showloading();
            },
            success:function(data){
                //removedialog_process();
                if (parseInt(data)==1) result=1;
                else result=0;            
            },
            error:function (request, status, error) {
                //removedialog_process();
                //showerror();
            }
        });
        return result;
    }


    function removeagent (customerid, agentid)
    {
        var divhtml=   '<form name="importform" id="importform" method="post" enctype="multipart/form-data">'+
                        '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading">Confirm to remove agent</div><div class="panel-body">'+
                            '<hr />'+
                            '<div class="centerdiv">'+
                                '<input type="submit" class="btn btn-danger" value="Yes" onclick="removeagent_process(\''+customerid+'\', \''+agentid+'\');"/><div class="divider"></div>'+
                                '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();"/>'+
                            '</div>';      
                        '</div></div></form>';
        showdialog_process(divhtml,'true');
    }


    function removeagent_process (customerid,agentid)
    {
        //alert (customerid);
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+"/delete/customeragent",
            data:{
                customerid: customerid,
                agentid: agentid
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                location.reload();            
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });
    }

    function deleteobjectintable (url,objectid,parentid,table, min='')
    {
        if ($('#'+table+' tr').length-1<=min && min!='')
        {
            showerror('Need at least '+min+ ' record');
            return;
        }
        var divhtml=   '<div class="panel panel-info centerdiv">'+
                            '<div class="panel-heading">'+
                                'Confirmation'+
                            '</div>'+
                            '<div class="panel-body">'+
                                '<hr />'+
                                '<div>'+
                                    '<span>Are you sure want to delete ?</span>'+
                                '</div>'+
                                '<div><hr /></div>'+
                                '<div style="spacing: 10px">'+
                                    '<input type="button" class="btn btn-danger" value="Yes" onclick="deleteobjectintable_process(\''+url+'\',' + '\''+objectid+'\',\''+ parentid +'\',\''+table+'\');"/><div class="divider"></div>'+
                                    '<input type="button" class="btn btn-primary" value="Cancel" onclick="removedialog_process();"/>'+
                                '</div>'+
                            '</div>'+   
                        '</div>';
        showdialog_process(divhtml,'true');
    }

    function deleteobjectintable_process (url,objectid,parentid,table)
    {
        $.ajax({
            type:"post",
            url:"http://"+window.location.hostname+url,
            data:{
                id: objectid,
                parentid: parentid
                },
            beforeSend: function ( xhr ) {
               showloading();
            },
            success:function(data){
                removedialog_process();
                jQuery('#'+table+'-'+objectid).remove();  
            },
            error:function (request, status, error) {
                removedialog_process();
                showerror();
            }
        });
    } 
    
