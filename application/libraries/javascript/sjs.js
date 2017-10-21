$( document ).ready(function() {
    
    $('.product-quantity').each(function(){
    	var qtyobj = $(this).find('#product-quantity');
    	$(this).find('.glyphicon-minus').click(function(){
    		var tempminus = 0;
    		if (parseInt(qtyobj.val())) {
    			tempminus = parseInt(qtyobj.val()) - 1;
    		};
    		qtyobj.val(tempminus);
    	});
    	$(this).find('.glyphicon-plus').click(function(){
    		var tempplus = 0;
    		if (parseInt(qtyobj.val())) {
    			tempplus = parseInt(qtyobj.val()) + 1;
    		};
    		if (parseInt(qtyobj.val()) == 0) {
    			tempplus = 1;
    		};
    		qtyobj.val(tempplus);
    	});
    });
    jQuery('[type="datetime"]').datepicker();
});
