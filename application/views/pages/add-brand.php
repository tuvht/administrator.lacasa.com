<form class="form-horizontal col-sm-12" method="post">
    <div class="form-group pull-left" style="margin-bottom: 15px;">
      <input type="submit" class="btn btn-success" id="save" name="save" value="Save" onclick="return form_validate();">
      <a class="btn btn-danger" href="<?php echo base_url().'brand';?>">Cancel</a>
    </div>
    <div class="clearfix"></div>

  <div class="form-group">
    <label  class="col-sm-1 control-label myLabel">Name</label>
    <div class="col-sm-8">
      <input class="form-control" id="inputName" value="" name = "brand[brand_name]">
      <div><span id="val_msg_name" class="form_field_validation"></span></div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-1 control-label myLabel">Country</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputCountry" value="" name = "brand[brand_origin_country]">
      <div><span id="val_msg_country" class="form_field_validation"></span></div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-1 control-label myLabel">Description</label>
    <div class="col-sm-8">
      <textarea class="form-control" rows="7" name = "brand[brand_description]"></textarea>
    </div>
  </div>

</form>
<script type="text/javascript">
function form_validate()
{
    var name_validation = field_validate ('text','inputName',50, 0,'val_msg_name','true','Please input brand name','');
    var country_validation = field_validate ('text','inputCountry',50, 0,'val_msg_country','true','Please input brand country','');
    if (name_validation && country_validation)
    {
      return true;
    }
    return false;
}
</script>