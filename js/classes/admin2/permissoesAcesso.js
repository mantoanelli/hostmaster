noGrid = true;
$(function(){
    $('.grupos').bind('mouseover mouseout click',eventsGrupos);
    //$('.acoesRegistro .acao').bind('mouseover mouseout click',mouseEventsAcaoForm);
    $('.perms').bind('mouseover mouseout click',eventsPerms);
});

/*function mouseEventsAcaoForm(e){
    if(e.type == 'mouseover'){
        $(this).addClass('hover');
    }else if(e.type == 'mouseout'){
        $(this).removeClass('hover'); 
    }else if(e.type == 'click'){
        if($(this).hasClass('save')){
            savePermissions();
        }
    }
}

function savePermissions(){
    alert('Vai Corinthians');
}*/

function eventsGrupos(e){
    if(e.type == 'mouseover')
        $(this).addClass('hover');
    else if(e.type == 'mouseout')
        $(this).removeClass('hover');
    else if(e.type == 'click'){
        if($(this).hasClass('editing')){
            $(this).removeClass('editing');
        }else{
            $(this).addClass('editing');
        }
    }     
}

function eventsPerms(e){
    if(e.type == 'mouseover')
        $(this).addClass('hover');
    else if(e.type == 'mouseout')
        $(this).removeClass('hover');
    else if(e.type == 'click'){
        
        grupoid = $(this).attr('grupoid');
        funcid = $(this).attr('funcid');
        permid = $(this).attr('permid');
        $.ajax({
            type:'POST',
            url:Util.url_modulo('toogleAcess/'+grupoid+'/'+funcid+'/'+permid),
            success:function(r){
                r = $.parseJSON(r.replace( /\[\&([^\&]+)\&\]/gi, '<$1>' ));
                obj = $('.perms[grupoid="'+r.grupoid+'"][funcid="'+r.funcid+'"][permid="'+r.permid+'"]');

                if(r.deleted == '1'){
                    obj.removeClass('havePerm');
                    obj.find('img').attr('src','images/admin2/icons/color/cross.png');
                }else{
                    obj.addClass('havePerm');
                    obj.find('img').attr('src','images/admin2/icons/color/tick.png');
                }
            }
        });
    }     
}

