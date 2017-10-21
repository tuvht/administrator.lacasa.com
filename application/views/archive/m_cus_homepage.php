<link rel="stylesheet" href="http://kiemtraweb.vn/application/libraries/javascript/js/jquery-ui-1.11.1.custom/jquery-ui.min.css"/>
<script type="text/javascript" src="http://kiemtraweb.vn/application/libraries/javascript/js/jquery-2.1.1.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<link rel="stylesheet" href="/application/views/css/default.css"/>




<body>
<div class="container-fluid">
    <table class="table table-bordered">
    <tbody>
    <tr>
        <th>
            <table class="table table-bordered">
                <tbody>
                    <tr><th>
                	<div class="jumbotron" style="width: 100%; color: white;font-size: small;">Search the picture that you want for your products, shops, services...or idea for a promotion campaign. 
                        <input type="text" class="form-control" size="30" maxlength="30"/>
                        <input type="button" class="form-control" value="Search"/>
                    </div>
                    </tr></th>
                </tbody>
            </table>
        </th>
    </tr>
    </tbody>
    </table>
 
<style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>    
    
   
   <?php
                    $i=round($offset /VIEW_IMAGE_PER_ROW ,0)+1;
                    $j=0; 
                    while ((($i-1)*VIEW_IMAGE_PER_ROW) <count($images) AND ((($i-1)*VIEW_IMAGE_PER_ROW)) < ($offset)+$perpage)
                    {
                    
                    echo('<tr>');
                    echo ('<div id="myCarousel'.$i.'" class="carousel slide" data-ride="carousel">');
                    echo('
                      <ol class="carousel-indicators">
                        <li data-target="#myCarousel'.$i.'" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="1"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="2"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="3"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="4"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="5"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="6"></li>
                        <li data-target="#myCarousel'.$i.'" data-slide-to="7"></li>
                      </ol>');
                    
                    echo ('<div class="carousel-inner" role="listbox">');    
                    for ($j=0; $j <VIEW_IMAGE_PER_ROW AND ((($i-1)*VIEW_IMAGE_PER_ROW)+$j)<count($images) ;$j++)
                    { 
                        $image_item = $images[(($i-1)*VIEW_IMAGE_PER_ROW)+$j];
                        if ($j==0)
                        {?>
                            <div class="item active">
                                  
                                        <img class="img-thumbnail" src="../../products/thumb/<?php echo $image_item['path'].$image_item['image_id'].".jpg";?>" width="300" height="300"/> 
                                 
                            </div>
                        <?php
                        }
                        else {
                ?>
                   
                                <div class="item">
                                  
                                        <img class="img-thumbnail" src="../../products/thumb/<?php echo $image_item['path'].$image_item['image_id'].".jpg";?>" width="300" height="300"/> 
                                 
                                </div>
                   
                    
                 <?php } }
                 echo ('</div>');
                 echo ('<!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel'.$i.'" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel'.$i.'" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a></div>');
                 echo ('</tr>'); 
                 $i++; }
                   ?>
    
    
    
 
</div>
</body>

