$.extend({
    getUrlVars: function(nameVar){
    
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        if(nameVar){
            return vars[nameVar];
        }else{
            return vars;
        }
    }
});
$(function(){
    $('.divSubList a').not('.subLink').bind('mouseover mouseout',evetnsMenuProduto);
    
    $.each($('select.selectStyle'),function(k,v){
        $(v).after('<div class="selectStyleDiv" style="width: '+($(v).width()-25)+'px" selectId="'+$(v).attr('id')+'"></div>');
    });
    
    $.each($('input.inputCheckbox'),function(k,v){
        chk = ($(v).attr('checked') == 'checked')?'ativo':'';
        addCls = $.trim($(v).attr('class').replace('inputCheckbox',''));
        $(v).after('<div class="areaStyleCheckbox"><div class="styleCheckbox '+chk+' '+addCls+'"></div><div class="labelStyle">'+$(v).attr('label')+'</div></div>');
        $(v).hide();
    });
    
    $('.selectStyle').bind('change',eventsSelectStyle).trigger('change');
    $('.areaStyleCheckbox').bind('click',eventCheckbox);
    
    $('#selectCompanhia').bind('change',changeCompanhia)
    
    $('input,textarea').defaultValue();
    $('input.telefone').phoneMask();
    $('a.lightbox').colorbox({rel:'gal'});
});

function changeCompanhia(){
    o = $(this);
    value = o.val();
    navio_id = $.getUrlVars('navio_id');
    _url = Util.url_modulo('buscaNavios')+'/'+value;
    $('#selectNavio').html('<option>CARREGANDO</opttion>');
    $('#selectNavio option').eq(0).trigger('change');
    $.ajax({
        url:_url,
        type:'GET',
        success:function(r){
            $('#selectNavio').html(r);
            if(navio_id){
                option = $('#selectNavio option[value="'+navio_id+'"]');
                //alert(option.val())
                if(option.val())
                    option.attr('selected','selected').trigger('change');
                else
                    $('#selectNavio option').eq(0).attr('selected','selected').trigger('change');
            }else{
                $('#selectNavio option').eq(0).attr('selected','selected').trigger('change');
            }
            
        }
    })
}

function eventsSelectStyle(){
    obj = $(this);
    objDiv = $('.selectStyleDiv[selectId="'+obj.attr('id')+'"]');
    objDiv.html(obj.find('option:selected').html());
}

function eventCheckbox(){
    objCheckbox = $(this);
    
    if(!objCheckbox.find('.styleCheckbox').hasClass('ativo')){
        objCheckbox.find('.styleCheckbox').addClass('ativo');
        objCheckbox.prev().attr('checked','checked');
    }else{
        objCheckbox.find('.styleCheckbox').removeClass('ativo');
        objCheckbox.prev().removeAttr('checked');
    }
}

function evetnsMenuProduto(e){
    objA = $(this);
    if(objA.attr('bghover') != ''){
        if(e.type == 'mouseover'){
            objA.css({
                backgroundColor:objA.attr('bghover'),
                color:'#FFF'
            });
        }
        if(e.type == 'mouseout'){
            objA.css({
                backgroundColor:'#e7e7e7',
                color:'#000'
            });
            //objA.css('backgroundColor','#e7e7e7');
        }
    }
}