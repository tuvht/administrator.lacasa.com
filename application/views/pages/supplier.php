<script type="text/javascript">
$(document).ready(function(){
     $(function() {
     	var sup_id = '<?php echo $sup_id?>';
     	$('select[name="contract_type"]').on('change', function(){
     		var type = $(this).val();
     		var form = "";
     		if (type == 1){
     			$('#static').remove();
     			form = '<div class="form-group" id="percentage">'
     			+'<label class="col-sm-2 control-label" for="percentage">Percentage: </label>'
     			+'<div class="col-sm-10">'
     			+'<input id="input_contract_percentage" type="text" name="input_contract_percentage" value=""/>'
                +'<div><span id="val_msg_input_contract_value" class="form_field_validation"></span></div>'
     			+'<input type="hidden" name="static" value="0"/>'
     			+'</div></div>'
     			$('#contract').append(form);
     		}
     		else if(type == 2){
     			$('#percentage').remove();
     			form = '<div class="form-group" id="static">'
     			+'<label class="col-sm-2 control-label" for="static">Static commision: </label>'
     			+'<div class="col-sm-10">'
     			+'<input id="input_contract_percentage" type="text" name="input_contract_percentage" value=""/>'
                +'<div><span id="val_msg_input_contract_value" class="form_field_validation"></span></div>'
     			+'<input type="hidden" name="percentage" value="0"/>'
     			+'</div></div>'
     			$('#contract').append(form);
     		}

     	});
     	if (sup_id != ''){
     		var i = '<?php echo !empty($detail["warehouse"])?count($detail["warehouse"])+1:"";?>';
     	}
     	else{
     		var i = 1;
     	}

     	$('#add').on('click', function(){
            var sup_id = $(this).attr('attr_supid');
            if (form_validate_add()){
                var count = $(this).attr('attr_count');
         		var input = '';
                var val_name = $("#input_name").val();
                var country= $("#input_country").val();
                var city= $("#input_city").val();
                var district= $("#input_district").val();
                var street= $("#input_street").val();
                var contact_person= $("#input_contact_person").val();
                var contact_phone= $("#input_contact_phone").val();
                var contact_email= $("#input_contact_email").val();
                var working_hour= $("#input_working_hour").val();
                var remove;
                var default_warehouse;
                var input_hidden;
                //var default_warehouse = $('input[name="warehouse\[default\]"]:checked').val();
                //if(default_warehouse = 1){
                //    default_warehouse='<i class="fa fa-check" aria-hidden="true"></i>';
                //}
                //else
                //{

                //}
                input_hidden ='<input type="hidden" name="warehouse['+i+'][name]" value="'+val_name+'"/>';
         		val_name = '<td>'+val_name+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][country]" value="'+country+'"/>';
                country = '<td>'+country+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][city]" value="'+city+'"/>';
                city = '<td>'+city+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][district]" value="'+district+'"/>';
                district = '<td>'+district+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][street]" value="'+street+'"/>';
                street = '<td>'+street+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][contact_person]" value="'+contact_person+'"/>';
                contact_person = '<td>'+contact_person+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][contact_phone]" value="'+contact_phone+'"/>';
                contact_phone = '<td>'+contact_phone+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][contact_email]" value="'+contact_email+'"/>';
                contact_email = '<td>'+contact_email+input_hidden+'</td>';

                input_hidden ='<input type="hidden" name="warehouse['+i+'][working_hour]" value="'+working_hour+'"/>';
                working_hour = '<td>'+working_hour+input_hidden+'</td>';

                remove='<td><a class="btn btn-danger class_remove" attr_count = '+count+'>Remove</a></td>';
                //val_name = '<td>'+val_name+'</td>';

                if (i==1){
                    default_warehouse = '<td><input type="radio" class="default" attr="'+i+'" name="check_default" checked=""/></td>';
                }
                else{
                    default_warehouse = '<td><input type="radio" class="default" attr="'+i+'" name="check_default"/></td>';
                }

                if (sup_id !=0){
                    contact_person= $("#input_contact_person").val();
                    contact_email= $("#input_contact_email").val();
                    working_hour= $("#input_working_hour").val();
                    remove ='<td>'
                            +'<label>'
                            +   '<input type="radio" name="default" value=""/>'
                            +'</label>'
                            +'<label class="pull-right" style="margin-left: 10px; vertical-align: middle; ">'
                            +   '<a class="btn btn-danger class_remove" attr_count = '+count+'>Remove</a>'
                            +'</label>'
                            +'<input type="hidden" name="warehouse['+i+'][contact_person]" value="'+contact_person+'"/>'
                            +'<input type="hidden" name="warehouse['+i+'][contact_email]" value="'+contact_email+'"/>'
                            +'<input type="hidden" name="warehouse['+i+'][working_hour]" value="'+working_hour+'"/>'
                            +'</td>';

                    input="<tr id = 'row-"+count+"' >"+val_name+street+district+city+country+contact_phone+remove+'</tr>';
                }
                else{
                    input="<tr id = 'row-"+count+"' >"+val_name+country+city+district+street+contact_person+contact_phone+contact_email+working_hour+default_warehouse+remove+'</tr>';
                }

                $('#warehouse_table').append(input);

                $("#input_name").val("");
                $("#input_country").val("");
                $("#input_city").val("");
                $("#input_district").val("");
                $("#input_street").val("");
                $("#input_contact_person").val("");
                $("#input_contact_phone").val("");
                $("#input_warehouse_contact_email").val("");
                $("#input_working_hour").val("");
         		i++;
                var count_new = ++count;
                $(this).attr('attr_count',count_new);
            }
     	});
        $(document).on("click",".class_remove",function(){
            var attr_count = $(this).attr("attr_count");

            $("#row-"+attr_count).remove();
        })
        $(document).on("click",".default",function(){
            var attr_count = $(this).attr("attr");

            $("#warehouse_default").val(attr_count);
        })



     	$('.remove_field').on('click', function(){
     		var warehouse = $(this).attr('data');
     		$.ajax({
                type: "POST",
                url: "<?php echo base_url().'delete-warehouse';?>",
                data: {warehouse: warehouse},
                success: function(msg) {
                	$('tr#warehouse-'+warehouse).remove();
                }
            });
     	});

     	$('input[name="default"]').on('change', function(){
     		var warehouse = $(this).val();
     		$.ajax({
                type: "POST",
                url: "<?php echo base_url().'update-warehouse';?>",
                data: {warehouse: warehouse, sup_id: sup_id},
                success: function(msg) {
                  console.log(msg);
                }
            });
     	});
	});
});
</script>
<?php
if (!empty($msg)) {
	echo '<div class="alert alert-'.$msg['type'].'" role="alert">'.$msg['text'].'</div>';
} else {
	if (!empty(validation_errors())) {
		echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
	}

	if (!empty($error)) {
		echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
	}
}

?>
<form class="form-horizontal" action="<?php echo base_url().'supplier-detail/'.$sup_id;?>" method="post" enctype="multipart/form-data">
	<div class="button-list">
		<input class="btn btn-success" id="save-button" type="submit" name="save" onclick="return form_validate();" value="Save" />
        <a class="btn btn-danger" href="<?php echo base_url().'supplier';?>">Cancel</a>
	</div>
    <div><span id="validation-summary" class="form_field_validation"></span></div>

	<div id="main-info" class="col-lg-12">
		<ul class="nav nav-tabs nav-pills nav-justified" role="tablist">
			<li role="presentation" class="active">
				<a href="#basic" aria-controls="basic" role="tab" data-toggle="tab" id="basic-tab">Basic info</a>
			</li>
			<li role="presentation">
				<a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" id="contact-tab">Contact info</a>
			</li>
			<li role="presentation">
				<a href="#payment" aria-controls="payment" role="tab" data-toggle="tab" id="payment-tab">Payment</a>
			</li>
			<li role="presentation">
				<a href="#contract" aria-controls="contract" role="tab" data-toggle="tab" id="contract-tab">Contract</a>
			</li>
			<li role="presentation">
				<a href="#warehouse" aria-controls="warehouse" role="tab" data-toggle="tab" id="warehouse-tab">Warehouse</a>
			</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="basic">
<?php $this->load->view('pages/supplier_detail_basic');?>
</div>
			<div role="tabpanel" class="tab-pane" id="contact">
<?php $this->load->view('pages/supplier_contact_info');?>
</div>
			<div role="tabpanel" class="tab-pane" id="payment">
<?php $this->load->view('pages/supplier_payment');?>
</div>
			<div role="tabpanel" class="tab-pane" id="contract">
<?php $this->load->view('pages/supplier_contract');?>
</div>
			<div role="tabpanel" class="tab-pane" id="warehouse">
<?php $this->load->view('pages/supplier_warehouse');?>
</div>
		</div>
	</div>
<?php if (!empty($sup_id)):?>
		<input type="hidden" name="supplier_id" value="<?php echo $sup_id?>"/>
<?php endif;?>
</form>
<script type="text/javascript">
function form_validate()
{
    $('#validation-summary').text('');
    //BASIC
    var input_basic_company_validation=field_validate ('text','input_basic_company',50, 2,'val_msg_input_basic_company','true','Please insert company','','validation-summary');
    var input_basic_taxid_validation=field_validate ('text','input_basic_taxid',50, 2,'val_msg_input_basic_taxid','true','Please insert tax ID','','validation-summary');
    var input_basic_address_validation=field_validate ('text','input_basic_address',50, 2,'val_msg_input_basic_address','true','Please insert address','','validation-summary');
    var input_basic_phone_validation=field_validate ('text','input_basic_phone',50, 2,'val_msg_input_basic_phone','true','Please insert phone','','validation-summary');
    var input_basic_email_validation=field_validate ('email','email',50, 2,'val_msg_input_basic_email','true','Please insert email','supplier','validation-summary');
    var input_basic_password=1;

<?php if (empty($sup_id)):?>
input_basic_password=field_validate ('text','input_basic_password',50, 2,'val_msg_input_basic_password','true','Please insert password','','validation-summary');
<?php endif;?>
var form_basic_validation=input_basic_company_validation&&input_basic_taxid_validation&&input_basic_address_validation&&input_basic_phone_validation&&input_basic_email_validation&&input_basic_password;

    //CONTACT
    var input_contact_name_validation=field_validate ('text','input_contact_name',50, 2,'val_msg_input_contact_name','true','Please insert contact name','','validation-summary');
    var input_contact_title_validation=field_validate ('text','input_contact_title',50, 2,'val_msg_input_contact_title','true','Please insert title','','validation-summary');
    var input_contact_cellphone_validation=field_validate ('text','input_contact_cellphone',50, 2,'val_msg_input_contact_cellphone','true','Please insert contact phone','','validation-summary');
    var input_contact_email_validation=field_validate ('email','input_contact_email',50, 2,'val_msg_input_contact_email','true','Please insert contact email','supplier','validation-summary');
    var form_contact_validation=input_contact_name_validation&&input_contact_title_validation&&input_contact_cellphone_validation&&input_contact_email_validation;

    //PAYMENT
    var input_payment_number_validation=field_validate ('text','input_payment_number',50, 1,'val_msg_input_payment_number','true','Please insert account number','','validation-summary');
    var input_payment_name_validation=field_validate ('text','input_payment_name',50, 2,'val_msg_input_payment_name','true','Please insert account name','','validation-summary');
    var input_payment_bank_validation=field_validate ('text','input_payment_bank',50, 2,'val_msg_input_payment_bank','true','Please insert bank name','','validation-summary');
    var input_payment_branch_validation=field_validate ('text','input_payment_branch',50, 2,'val_msg_input_payment_branch','true','Please insert bank branch','','validation-summary');
    var form_payment_validation=input_payment_number_validation&&input_payment_name_validation&&input_payment_bank_validation&&input_payment_branch_validation;

    //CONTRACT
    var input_contract_type_validation=field_validate ('select','contract_type','','','val_msg_input_contract_type','true','Please select contract type:','','validation-summary');
    var input_contract_number_validation=field_validate ('text','input_contract_number',50, 2,'val_msg_input_contract_number','true','Please insert contract number','','validation-summary');
    var input_contract_signdate_validation=field_validate ('text','input_contract_signdate',50, 2,'val_msg_input_contract_signdate','true','Please insert sign date','','validation-summary');
    var input_contract_enddate_validation=field_validate ('text','input_contract_enddate',50, 2,'val_msg_input_contract_enddate','true','Please insert end date','','validation-summary');
    var input_contract_percentage_validation=field_validate ('number','input_contract_percentage',100, 1,'val_msg_input_contract_value','true','Please insert percentage between 1-100','','validation-summary');
    var form_contract_validation=input_contract_type_validation&&input_contract_number_validation&&input_contract_signdate_validation&&input_contract_enddate_validation&&input_contract_percentage_validation;

    //WAREHOUSE
    var table_warehouse_validation = field_validate ('table','warehouse_table',5, 2,'val_msg_table','true','Please insert warehouse','','validation-summary');


    if (form_basic_validation&&form_contact_validation&&form_payment_validation&&form_contract_validation&&table_warehouse_validation)
    {
      return true;
    }
    return false;
}
</script>
