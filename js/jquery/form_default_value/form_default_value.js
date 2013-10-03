(function($){
    $.fn.defaultValue = function(options)
    {
        obj = this;
	   
        if($(obj).attr('default')){
            $(obj).bind('blur focus',eventInputDefault);
			
            $(obj).trigger('blur');
        }
    };
})(jQuery);
	
function eventInputDefault(e){
    obj = $(this);
    if(e.type == 'focus'){
        if(obj.val() == obj.attr('default')){
            obj.val('');
        }
    }
	
    if(e.type == 'blur'){
        if(obj.val() == ''){
            obj.val($(obj).attr('default'));
        }
    }		  
}
