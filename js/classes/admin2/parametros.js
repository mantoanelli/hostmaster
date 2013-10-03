$(function(){
    //$('select.tipo').bind('change',mudaTipo).trigger('change');;
});

function triggerTipo(){
    $('select.tipo').trigger('change');
}

function mudaTipo(e){
    objChg = $(this);
    tipo = objChg.val();
    
    objValor = $('.valor');
    objValor.attr('alt','').removeClass('inputDate').removeClass('hasDatepicker').attr('id','');
    
    if(tipo == 'decimal'){
        objValor.attr('alt','decimal-us');
    }
    
    if(tipo == 'data'){
        objValor.attr('alt','date-db');
    }
    if(tipo == 'boolean'){
        objValor.attr('alt','boolean');
    }
    if(tipo == 'numero'){
        objValor.attr('alt','number');
    }
    
    $('input:text').unsetMask();
    $('input:text').setMask();
    inits();
}

function addItemFormFull(o,classParent,callback){
    
    local = o.parents(classParent);
    htm = local.clone();
    htm.find('input,select,textarea').val('');
	
    //aplica a regra de obrigatorio
    /*$.each(htm.find('input'),function(k,v){
        if($(v).attr('requiredEmpty') == 'true'){
            $(v).addClass('required');
        }
    });*/
    local.after(htm);
    initsForm();
    
    if(callback){
        if(callback.indexOf(',') != -1){
            callback = callback.split(',');
            $.each(callback,function(k,v){
                eval(v)();
            });
        }else{
            if(callback != ''){
                eval(callback)();
            }
        }  
    }
}

function removeItemFormFull(obj,cls,callback){
    local = obj.parent().parent().parent().parent();
    objForm = local.parents('form');
    qtd = objForm.find('.'+cls).length;

    if( qtd > 1){
        local2 = local.parent();
        local2.remove();
    }else{
        local.find('input,select,textarea').not('.btFiltro').val('');
    }
    if(callback){
        if(callback.indexOf(',') != -1){
            callback = callback.split(',');
            $.each(callback,function(k,v){
                eval(v)();
            });
        }else{
            if(callback != ''){
                eval(callback)();
            }
        }
    }
}