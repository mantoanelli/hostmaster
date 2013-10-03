$(function() {
    $('.verificaUsuarioCpanel').bind('click', verificaUsuarioCpanel);
    $('.gerarNovaSenhaCpanel').bind('click', gerarNovaSenhaCpanel);
    $('.gravaNovaSenhaCpanel').bind('click', gravaNovaSenhaCpanel);
    $('.usuarioCpanel').bind('blur', verificaUsuarioCpanelTrigger);
    $('.planoCpanel').bind('change', planoCpanelPreco);
    $('.dominios.novo').find('.planoCpanel').trigger('change');
    $('.dominios .salvaDominio').bind('click',salvaDominio);
    $('.dominios .toggleDadosDominio').bind('click',toggleDadosDominio).trigger('click');
    $('.alertaUsuarioCpanel').hide();
    //Util.blockWindow();
});

function toggleDadosDominio(){
    o = $(this);
    pai = o.parent().parent().parent();
    //pai.find('.dadosDominio').toggle(500,function(){
        if(pai.find('.dadosDominio').css('display') == 'none'){
            o.val('Ocultar dados do domínio');
            pai.find('.dadosDominio').show();
        }else{
            o.val('Ver dados do domínio');
            pai.find('.dadosDominio').hide();
        }
    //});
}

function salvaDominio(){
    o = $(this);
    pai = o.parents('.dominios');
    serialized = serializeCampos(pai);
    
    if(o.hasClass('novo')){
        var erroValidacao = '<div class="list tipRed"><ul>';
        var erroValidacaoContent = '';
        if($('#senhacpanel').val().length < 6){
            erroValidacaoContent += '<li>A senha deve ter pelo menos 6 caracteres</li>';
        }
        
        if($('#userdominio').val() == '' || $('#userdominio').val().indexOf('.')== -1){
            erroValidacaoContent += '<li>Preencha o campo Domínio corretamente</li>';
        }
        
        if($('#usercpanel').val() == ''){
            erroValidacaoContent += '<li>Preencha o campo Usuário Cpanel</li>';
        }
        
        if($('#senhacpanel').val() != $('#confsenhacpanel').val()){
            erroValidacaoContent += '<li>As senhas devem ser iguais</li>';
        }
        
        erroValidacao += erroValidacaoContent;
        erroValidacao += '</ul></div>';
        if(erroValidacaoContent != ''){
            jAlert(erroValidacao, 'Atenção');
            return false;
        }
            
    }
    Util.blockWindow();
    //showAjaxLoad('loadingAjax', o);
    
    $.ajax({
        type:'POST',
        url: Util.url_modulo('saveDominio'),
        data: serialized.join('&'),
        success:function(r){
           document.location.href = document.location.href;
        },
        error:function(){
            jAlert('Ocorreu um erro de servidor, tente novamente mais tarde.', 'Erro');
        }
    });
    //alert(serialized.join('&'));
}

function serializeCampos(pai){
    campos = new Array();
    $.each(pai.find('input,select,textarea'),function(k,v){
        if($(v).attr('name'))
            campos.push($(v).attr('name')+'='+$(v).val());
    });
    
    return campos;
}

function showAjaxLoad(idAjaxLoad, objAfter, img) {

    if (!img) {
        img = base_url + 'images/admin2/loaders/loader.gif';
    }

    htm = '<img src="' + img + '" id="' + idAjaxLoad + '" alt="" style="margin-left: 10px;display: none;">';

    objAfter.after(htm);
    $('#'+idAjaxLoad).show();
}

function gravaNovaSenhaCpanel() {
    o = $(this);
    user = o.prev().attr('user');
    senha = o.prev().val();

    if (senha.length < 6) {
        jAlert('A senha deve ter pelo menos 6 caracteres', 'Atenção');
        return false;
    }
    showAjaxLoad('a123b', o);

    $.ajax({
        type: 'POST',
        url: site_url + 'adm/usuarioDominios/gravaNovaSenhaCpanel',
        data: 'user=' + user + '&pass=' + senha,
        success: function(r) {
            $('#a123b').remove();
            r = Util.toJson(r);
            if (r.status == '1') {
                sucessoSenha(user, r.pass);
            } else
                jAlert('Ocorreu um erro de servidor, tente novamente mais tarde.', 'Erro');
        },
        error: function() {
            $('#a123b').remove();
            jAlert('Ocorreu um erro de servidor, tente novamente mais tarde.', 'Erro');
        }
    });

}

function enviarNovaSenhaCpanelEmail(o, user, pass) {
    img = base_url + 'images/admin2light/loaders/loader.gif';
    showAjaxLoad('a123b_2', o, img);
    $('#a123b_2').show();
    o.attr('disabled', 'disabled').addClass('greyishBtn');
    $('#popup_ok').attr('disabled', 'disabled').addClass('greyishBtn');

    $.ajax({
        type: 'POST',
        url: site_url + 'adm/usuarioDominios/enviarNovaSenhaCpanelEmail',
        data: 'user=' + user + '&pass=' + pass,
        success: function(r) {
            $('#a123b_2').remove();
            r = Util.toJson(r);
            if (r == '1') {
                o.val('Enviado com sucesso').removeClass('greyishBtn greenBtn').addClass('greenBtn');
                setTimeout(function() {
                    o.val('Enviar senha para e-mail');
                    o.removeAttr('disabled').removeClass('greyishBtn greenBtn');
                }, 3000);
            } else {
                o.val('Erro ao tentar enviar').removeClass('greyishBtn redBtn').addClass('redBtn');
                ;
                setTimeout(function() {
                    o.val('Enviar senha para e-mail');
                    o.removeAttr('disabled').removeClass('greyishBtn redBtn');
                }, 3000);
            }

            $('#popup_ok').removeAttr('disabled').removeClass('greyishBtn');
        },
        error: function() {
            $('#a123b_2').remove();
            o.val('Erro ao tentar enviar').addClass('redBtn');
            ;
            setTimeout(function() {
                o.val('Enviar senha para e-mail');
                o.removeAttr('disabled').removeClass('greyishBtn redBtn');
            }, 3000);
        }
    });

}

function sucessoSenha(user, pass) {
    jAlert('<p><img src="' + base_url + 'images/admin2/icons/color/tick.png" alt="" class="icon" />A nova senha foi gravada com sucesso. Senha nova: <b>' + pass + '</b></p><br><input type="button" value="Enviar senha para e-mail" class="blueBtn" onclick="enviarNovaSenhaCpanelEmail($(this),\'' + user + '\',\'' + pass + '\')" />', 'Sucesso');
}

function gerarNovaSenhaCpanel() {
    o = $(this);
    user = o.prev().prev().attr('user');

    showAjaxLoad('a123b', o);

    $.ajax({
        type: 'POST',
        url: site_url + 'adm/usuarioDominios/gravaNovaSenhaCpanel',
        data: 'user=' + user + '&pass=',
        success: function(r) {
            $('#a123b').remove();
            r = Util.toJson(r);
            if (r.status == '1') {
                sucessoSenha(user, r.pass);
            } else
                jAlert('Ocorreu um erro de servidor, tente novamente mais tarde.', 'Erro');
        },
        error: function() {
            $('#a123b').remove();
            jAlert('Ocorreu um erro de servidor, tente novamente mais tarde.', 'Erro');
        }
    });

}

function planoCpanelPreco() {
    o = $(this);
    val = o.val();

    elePai = o.parents('.dominios');
    elePai.find('input.valorPlano').val(precoPlano[val]).trigger('blur');

}

function verificaUsuarioCpanelTrigger() {
    $('.verificaUsuarioCpanel').trigger('click');
}
function verificaUsuarioCpanel() {
    o = $(this);
    user = o.parent().find('.usuarioCpanel').val();
    if (user == '')
        return false;

    o.next().fadeIn();
    o.parent().parent().parent().find('.salvaDominio').attr('disabled', 'disabled');
    o.attr('disabled', 'disabled');
    o.prev().attr('disabled', 'disabled');

    $.ajax({
        type: 'POST',
        url: Util.url_modulo('verificaUsuarioCpanel'),
        data: 'user=' + user,
        success: function(r) {
            o.removeAttr('disabled');
            o.next().fadeOut();
            o.parent().find('.alertaUsuarioCpanel').removeClass('greyishBtn greenBtn redBtn');
            o.parent().find('.alertaUsuarioCpanel').show();
            if (r == '0') {
                o.parent().parent().parent().find('.salvaDominio').removeAttr('disabled');
                o.parent().find('.alertaUsuarioCpanel').addClass('greenBtn');
                o.parent().find('.alertaUsuarioCpanel').attr('value', 'Disponível');
            } else {
                o.parent().find('.alertaUsuarioCpanel').addClass('redBtn');
                o.parent().find('.alertaUsuarioCpanel').attr('value', 'Indisponível');
            }
        }
    });
}