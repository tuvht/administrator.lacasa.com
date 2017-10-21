jQuery(document).ready(function($) {
	 console.log(jQuery(window).width());
	if(jQuery(window).width() <1100)
    {
       
        jQuery('.container-fullwidth').addClass('device_mobile');
    }

	$(document).on('click','.view img',function () {
	   var path = $(this).attr('src');
	   $('#fullView img').attr('src', path);
	   $('#fullView').fadeIn(200);
	   $('#fullView img').delay(400).slideDown(200);
	 });

	$('#fullView').click(function() {
	    $(this).children('img').slideUp(200);
	    $(this).delay(400).fadeOut(200);
	 });


	/*
 *==================Validate====================
 */
	function validNumber(string) {
	    var expr =/^[1-9][0-9]?$|^100$/g;
	    return expr.test(string);
	}

	function  validNull(string){
	    var expr = /^\S[\w|\W ]+$/ug;
	    return expr.test(string);
	}

	function checkValid(arg1, arg2, str1, str2) {
    
	    if (arg2 == "" || arg2 == false){
	      $(arg1).closest('.form-group').removeClass('has-success').addClass('has-error');
	      if ($(arg1).val() == ""){
	        $(arg1).closest('.form-group').children('.help-block').text(str1).css('display','block');
	      } else {
	        $(arg1).closest('.form-group').children('.help-block').text(str2).css('display','block');
	      }
	      $(arg1).closest('.form-group').children('.glyphicon').addClass('glyphicon-remove');

	    } else{
	      $(arg1).closest('.form-group').children('.help-block').css('display','none');
	      $(arg1).closest('.form-group').removeClass('has-error').addClass('has-success');
	      $(arg1).closest('.form-group').children('.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
	    }
	  }

	  var nullfield = "Please fill out this field";

	$('input[name=percentage]').bind('input propertychange',function() {
	    checkValid($(this), validNumber($(this).val()), nullfield, "Please enter a number between 1 and 100");
	 });

	$('.notNull').bind('input propertychange',function() {
	    checkValid($(this), validNull($(this).val()), nullfield, "Please fill out this field");
	 });

});