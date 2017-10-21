  <!-- <div class="form-group"> <h1 style = "float: left;">Brand ID: <?php echo $id;
?></h1></div> -->
<form class="form-horizontal newproduct col-sm-12 bodycontent" method="post">

  <div class="button-list">
    <button class="btn btn-success" id="save-button" type="submit" name="save" class="btn btn-default" onclick="return form_validate()">Save</button>
    <a class="btn btn-danger" href="<?php echo base_url().'brand';?>">Cancel</a>
  </div>
  <div class="form-group">
    <label  class="col-sm-2 control-label">Name</label>
        <div class="col-sm-8">
          <input type="text" class="pull-left" id="inputName" value="<?=$detail['brand_name']?>" name = "brand[brand_name]">
          <div><span id="val_msg_name" class="form_field_validation"></span></div>
        </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Country</label>
    <div class="col-sm-8">
      <input type="text" class="pull-left" id="inputCountry" value="<?=$detail['brand_origin_country']?>" name = "brand[brand_origin_country]">
      <div><span id="val_msg_country" class="form_field_validation"></span></div>
    </div>
  </div>

 <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-8">
      <textarea class="form-control" rows="7" name = "brand[brand_description]"><?=$detail['brand_description']?></textarea>
    </div>
  </div>
</form>
<script type="text/javascript">
function form_validate()
{
    var input_name_validation=field_validate ('text','inputName',50, 1,'val_msg_name','true','Please insert brand name','','');
    var input_country_validation=field_validate ('text','inputCountry',50, 1,'val_msg_country','true','Please insert brand country','','');


    if (input_name_validation&&input_country_validation)
    {
      return true;
    }
    return false;
}
</script>