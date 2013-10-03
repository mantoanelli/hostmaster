

Util = {
	
    init: function()
    {
        
    },
    goTo: function(url)
    {
        document.location.href=url;
    },
    float2moeda: function(num){
        x = 0;
        if(num<0) {
            num = Math.abs(num);
            x = 1;
        }
        if(isNaN(num)) num = "0";
        cents = Math.floor((num*100+0.5)%100);

        num = Math.floor((num*100+0.5)/100).toString();

        if(cents < 10) cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
            num = num.substring(0,num.length-(4*i+3))+'.'
            +num.substring(num.length-(4*i+3));
        ret = num + ',' + cents;

        if (x == 1) ret = '-' + ret;
        return ret;
    },
    moeda2float: function(moeda){
        if(moeda){
            if(moeda.indexOf('-') != -1){
                sinal = '-';
                moeda = moeda.replace("-","");
            }else{
                sinal = '';
            }
            moeda = moeda.replace(".","");
            moeda = moeda.replace(".","");
            moeda = moeda.replace(".","");
            moeda = moeda.replace(".","");
            moeda = moeda.replace(",",".");
            moeda = parseFloat(moeda);
            moeda = new String(moeda);
            if(moeda.indexOf('.') == -1){
                moeda = moeda+'.00';
            }else{
                decimal = moeda.substr(moeda.indexOf('.')+1,2);
                if(decimal.length < 2){
                    moeda = moeda+"0";
                }
            }
            moeda = sinal+moeda;
        }

        return new Number(moeda);
    },
    refreshFormPlugins: function()
    {
        $('.inputDate').removeClass('hasDatepicker');
        $('.inputDate').removeAttr('id');
        $('input:text').unsetMask();
        $('input:text').setMask();

        $('.inputDate').datepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        },'option', {
            dateFormat: 'dd/mm/yy'
        });
    },

    limparFiltro: function()
    {
        $.each($('.iptSearch'),function (ipt, i)
        {
            ipt.attr('value', '');
        });
		
    },
	
    base_url: function()
    {
        return base_url;
    },
	
    isIframe: function()
    {	
        return isIframe;
    },
    site_url: function(uri)
    {
        if ( uri == null )
            return base_url + index_page;
			
        return base_url + (index_page!='' ?index_page + '/' :'') + uri;
    },

    url_modulo: function(uri)
    {
        if(!uri){
            uri = "";
        }

        return this.site_url(fetch_directory+fetch_class+"/") + uri;
    },
	
    call: function(uri, response, method, data)
    {
        method = method!=null ?method :'get';
        response = response!=null ?response :function(content){
            return;
        };
        data = data!=null ?data :'';

        //alert('uri: '+uri+' \n response: '+response+' \n method: '+method+' \n data: '+data);
        var url = Util.site_url(uri);

        $.ajax({
            type: method,
            url: uri,
            data: data,
            success: response
        });

    },

    getVideoPage: function ( videoId )
    {
        Util.call(
            'home/getVideoPage/' + videoId,

            function(content){
                /* resultado do util */
                //console.log( content );
                $('containerVideo').empty();
                $('containerVideo').innerHTML = content;
            }
            );
    },
	
    permissionMessage: function()
    {
        alert('Você não tem permissão para continuar essa ação.'+"\n"+'Para maiores informações, contate o Administrador do sistema.');
    },
	
    /*montaDropdown: function(data, dropdown, first)
    {
        $(dropdown).empty();

        var option = null;

        if ( first != null )
        {
            option = document.createElement('OPTION');
            option.value = '';
            option.innerHTML = first;

            dropdown.appendChild(option);
        }

        if ( data != null )
        {
            for ( var chv in data )
            {
                option = document.createElement('OPTION');
                option.value = chv;
                option.innerHTML = data[chv];

                dropdown.appendChild(option);
            }
        }
    },*/

    // Classe para recalcular o tamanho do slider
    /*recalcSlideHeight: function( idiv )
    {
        // Procura o wrapper de fora do slide
        while( idiv )
        {
            if( idiv.className && (idiv.hasClass('formDiv') || idiv.hasClass('recalDiv')) )
                break;
            idiv = idiv.parentNode;
        }

        if( !idiv )
            return;

		var height = idiv.offsetHeight;

        // Atualiza a altura da div
        idiv = idiv.parentNode;

        // Atualiza a altura da div
        if( idiv )
			idiv.setStyle( 'height', height );

    },*/
    
    soNums: function(e){
 
        //teclas adicionais permitidas (tab,delete,backspace,setas direita e esquerda)
        keyCodesPermitidos = new Array(8,9,37,39,46);
     
        //numeros e 0 a 9 do teclado alfanumerico
        for(x=48;x<=57;x++){
            keyCodesPermitidos.push(x);
        }
     
        //numeros e 0 a 9 do teclado numerico
        for(x=96;x<=105;x++){
            keyCodesPermitidos.push(x);
        }
     
        //Pega a tecla digitada
        keyCode = e.which; 
     
        //Verifica se a tecla digitada é permitida
        if ($.inArray(keyCode,keyCodesPermitidos) != -1){
            return true;
        }    
        return false;
    },
    
    _soNums: function(e){
        //alert(e);
        if (document.all){
            var evt=event.keyCode;
        } // caso seja IE
        else{
            var evt = e.charCode;
        }    // do contrrio deve ser Mozilla
        var valid_chars = '0123456789';    // criando a lista de teclas permitidas
        var chr= String.fromCharCode(evt);    // pegando a tecla digitada
        if (valid_chars.indexOf(chr)>-1 ){
            return true;
        }    // se a tecla estiver na lista de permisso permite-a
        // para permitir teclas como <BACKSPACE> adicionamos uma permisso para
        // cdigos de tecla menores que 09 por exemplo (geralmente uso menores que 20)
        if (valid_chars.indexOf(chr)>-1 || evt < 9){
            return true;
        }    // se a tecla estiver na lista de permisso permite-a
        return false;    // do contrrio nega
    },
    
    number_format: function(value, numberDecimal, separatorDecimal, separatorMilhar)
    {
        if ( !isNaN(value) )
        {
            value = Math.round(value * Math.pow(10, numberDecimal)) / Math.pow(10, numberDecimal);

            var str_value = "" + value;
            var v_value = str_value.split(".");

            var new_value = '';
            var v_new_value = new Array();
            var j = 0;

            for(var i = v_value[0].length-1; i >= 0; i-=3)
                v_new_value[j++] = v_value[0].substring((i-2), i+1);

            for ( var i = v_new_value.length-1; i >= 0; i-- )
                new_value+= (new_value!='' ?separatorMilhar :'') + v_new_value[i];

            if ( v_value[1]==null )
                v_value[1] = '';

            for ( var i = v_value[1].length; i < numberDecimal; i++ )
                v_value[1]+=0;

            return new_value + separatorDecimal + v_value[1];
        }

        return "";
    },
	
    keypress_formatCurrency: function(e)
    {
        var e = new Event(e);

        if(e.code > 47 && e.code < 58){
            var o, s, l = (s = ((o = this).value.replace(/^0+/g, "") + String.fromCharCode(e.code)).replace(/\D/g, "")).length, n;
            if(o.maxLength + 1 && l >= o.maxLength) return false;
            l <= (n = o.c) && (s = new Array(n - l + 2).join("0") + s);
            for(var i = (l = (s = s.split("")).length) - n; (i -= 3) > 0; s[i - 1] += o.dig);
            n && n < l && (s[l - ++n] += o.dec);
            o.value = s.join("");
        }
        e.code > 30 && e.preventDefault();
    },

    formatCurrency: function(o, n, dig, dec)
    {
        o.c = !isNaN(n) ? Math.abs(n) : 2;
        o.dec = typeof dec != "string" ? "," : dec, o.dig = typeof dig != "string" ? "." : dig;
		
		
        $(o).removeEvent('keypress', Util.keypress_formatCurrency);
		
        $(o).addEvent('keypress', Util.keypress_formatCurrency);
    },
    
    parse_number: function(valor)
    {
        return parseFloat(valor.replace(/\./g, '').replace(/,/g, '.'));
    },
    
    number_format: function (number, decimals, dec_point, thousands_sep) {
        // Formats a number with grouped thousands
        //
        // version: 906.1806
        // discuss at: http://phpjs.org/functions/number_format
        // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +     bugfix by: Michael White (http://getsprink.com)
        // +     bugfix by: Benjamin Lupton
        // +     bugfix by: Allan Jensen (http://www.winternet.no)
        // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // +     bugfix by: Howard Yeend
        // +    revised by: Luke Smith (http://lucassmith.name)
        // +     bugfix by: Diogo Resende
        // +     bugfix by: Rival
        // +     input by: Kheang Hok Chin (http://www.distantia.ca/)
        // +     improved by: davook
        // +     improved by: Brett Zamir (http://brett-zamir.me)
        // +     input by: Jay Klehr
        // +     improved by: Brett Zamir (http://brett-zamir.me)
        // +     input by: Amir Habibi (http://www.residence-mixte.com/)
        // +     bugfix by: Brett Zamir (http://brett-zamir.me)
        // *     example 1: number_format(1234.56);
        // *     returns 1: '1,235'
        // *     example 2: number_format(1234.56, 2, ',', ' ');
        // *     returns 2: '1 234,56'
        // *     example 3: number_format(1234.5678, 2, '.', '');
        // *     returns 3: '1234.57'
        // *     example 4: number_format(67, 2, ',', '.');
        // *     returns 4: '67,00'
        // *     example 5: number_format(1000);
        // *     returns 5: '1,000'
        // *     example 6: number_format(67.311, 2);
        // *     returns 6: '67.31'
        // *     example 7: number_format(1000.55, 1);
        // *     returns 7: '1,000.6'
        // *     example 8: number_format(67000, 5, ',', '.');
        // *     returns 8: '67.000,00000'
        // *     example 9: number_format(0.9, 0);
        // *     returns 9: '1'
        // *     example 10: number_format('1.20', 2);
        // *     returns 10: '1.20'
        // *     example 11: number_format('1.20', 4);
        // *     returns 11: '1.2000'
        // *     example 12: number_format('1.2000', 3);
        // *     returns 12: '1.200'
        var n = number, prec = decimals;
	 
        var toFixedFix = function (n,prec) {
            var k = Math.pow(10,prec);
            return (Math.round(n*k)/k).toString();
        };
	 
        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
	 
        var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
	 
        var abs = toFixedFix(Math.abs(n), prec);
        var _, i;
	 
        if (abs >= 1000) {
            _ = abs.split(/\D/);
            i = _[0].length % 3 || 3;
	 
            _[0] = s.slice(0,i + (n < 0)) +
            _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
            s = _.join(dec);
        } else {
            s = s.replace('.', dec);
        }
	 
        var decPos = s.indexOf(dec);
        if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
            s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
        }
        else if (prec >= 1 && decPos === -1) {
            s += dec+new Array(prec).join(0)+'0';
        }
        return s;
    },
    
    limitChars: function( textobj, limit, infoobj )
    {
        if( !textobj || !infoobj)
            return;

        function checkIt( textobj, limit, infoobj)
        {
            var text = textobj.value;

            if( text.length > limit )
            {
                infoobj.set( 'html', '0' );
                textobj.value = text.substr( 0, limit );
                return false;
            }
            else
            {
                infoobj.set( 'html', (limit - text.length) );
                return true;
            }
        }

        checkIt( textobj, limit, infoobj);

        textobj.onkeyup = function( )
        {
            checkIt( textobj, limit, infoobj);
        }

    },
    blockElement: function(obj,msg){
        if(msg == null){
            msg = "Aguarde...";
        }
        obj.block({
            message: ''+msg+'',
            overlayCSS:  {
                backgroundColor:'#000',
                opacity: 0.5,
                zIndex: 9999999
            },
            css:{
                background:"none",
                border:"0",
                color:"#CCC",
                fontFamily:"arial"
            }
        });
    },
    blockWindow: function(msg,type)
    {
        if(type == 0){
            $.blockUI({
                message: '',
                overlayCSS:  {
                    background:	'none',
                    opacity:	0.8,
                    zIndex:		9999999,
                    cursor:		'default'
                },
                css:{
                    background:"none",
                    border:"0",
                    color:"#999",
                    fontFamily:"arial"
                }
            });
        }else{
            if(msg == null){
                msg = "Aguarde...";
            }
            $.blockUI({
                message: '<h1><span>'+msg+'</span> </h1><br><img src="'+base_url+'images/admin2/loaders/loader8.gif" />',
                overlayCSS:  {
                    backgroundColor:	'#000',
                    opacity:            0.6,
                    zIndex:		9999999
                },
                css:{
                    background:"none",
                    border:"0",
                    color:"#999",
                    fontFamily:"arial"
                }
            });
        }
		
    },
    unblockWindow: function()
    {
        $.unblockUI();
        $('.loadAjax').hide();
    },
    toJson: function(str){
        return $.parseJSON(str.replace( /\[\&([^\&]+)\&\]/gi, '<$1>' ));
    },
    validaCpf: function(str){
        str = str.replace('.','');
        str = str.replace('.','');
        str = str.replace('-','');

        cpf = str;
        var numeros, digitos, soma, i, resultado, digitos_iguais;
        digitos_iguais = 1;
        if (cpf.length < 11)
            return false;
        for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
        if (!digitos_iguais)
        {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
            return true;
        }
        else
            return false;
    },

    validaCnpj: function(str){

        str = str.replace('.','');
        str = str.replace('.','');
        str = str.replace('.','');
        str = str.replace('-','');
        str = str.replace('/','');
        cnpj = str;
        var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
        digitos_iguais = 1;
        if (cnpj.length < 14 && cnpj.length < 15)
            return false;
        for (i = 0; i < cnpj.length - 1; i++)
            if (cnpj.charAt(i) != cnpj.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
        if (!digitos_iguais)
        {
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--)
            {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--)
            {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
            return true;
        }
        else
            return false;
    },
    
    selectToAutoComplete: function(){
        $('select').not('.noAutoComplete,.AC_active').combobox();
    },
    
    formatDateJS: function (str){
        arr = str.split(" ");
        dataArr = arr[0].split('/');
        data = dataArr[1]+'/'+dataArr[0]+'/'+dataArr[2];
        hora = "";
        if(arr[1]){
            hora = arr[1];
        }
        r = new Date(data+" "+hora);
        return r;
    },
    
    formatDateDB: function (str){
        arr = str.split(" ");
        dataArr = arr[0].split('/');
        data = dataArr[2]+'-'+dataArr[1]+'-'+dataArr[0];
        hora = "";
        r = data;
        if(arr[1]){
            hora = arr[1];
            r = data+" "+hora;
        }
        
        return r;
    },
    
    dataBr: function (str,semhora){
        arr = str.split(" ");
        dataArr = arr[0].split('-');
        data = dataArr[2]+'/'+dataArr[1]+'/'+dataArr[0];
        hora = "";
        r = data;
        if(arr[1] & !semhora){
            hora = arr[1];
            r = data+" "+hora;
        }
        
        return r;
    },
    erroConexaoInternet: function(){
        texto = '\n\
        Este erro pode ser causado pelos seguintes motivos: \n\
        <ul style="text-align:left">\n\
            <li>Não há sinal de internet em seu dispositivo</li>\n\
            <li>O servidor Shopmovel está com muito tráfego no momento</li>\n\
            <li>Sinal de internet com qualidade muito baixa</li>\n\
        </ul>';
        Util.alertUI('Erro ao se comunicar com internet', texto);
    },
    alertUI: function(title,text,callback){
        rand = Util.numRand(0, 100);
        //alert(rand);
        id = 'alertUI'+rand;
        html = '<div id="'+id+'" title="'+title+'" style="display: none; text-align:center">'+text+'</div>';
        $('body').append(html);
        $('#'+id).dialog({
            autoOpen: false,
            width: 'auto',
            modal: true,
            resizable: false,
            buttons: {
                "Fechar": function() {
                    $('#'+id).dialog("close");
                    $('#'+id).remove();
                    if(callback){
                        setTimeout(callback,10);
                    }
                }
            }
        });
        $('#'+id).dialog('open');
    },
    confirm: function(title,text,callback){
        rand = Util.numRand(0, 100);
        //alert(rand);
        id = 'alertUI'+rand;
        html = '<div id="'+id+'" title="'+title+'" style="display: none; text-align:center">'+text+'</div>';
        $('body').append(html);
        $('#'+id).dialog({
            autoOpen: false,
            width: 'auto',
            modal: true,
            resizable: false,
            buttons: {
                "Confirmar": function() {
                    $('#'+id).dialog("close");
                    $('#'+id).remove();
                    setTimeout(callback,1);
                },
                "Cancelar": function() {
                    $('#'+id).dialog("close");
                    $('#'+id).remove();
                }
            }
        });
        $('#'+id).dialog('open');
    },
    numRand: function (inferior,superior){ 
        numPossibilidades = superior - inferior 
        aleat = Math.random() * numPossibilidades 
        aleat = Math.floor(aleat) 
        return parseInt(inferior) + aleat 
    },
    gridV1Zebra: function(){
        $('#gridViewV1 .linha:even td').addClass('alternate')
    },
    
    larguraInputs: function (idForm){
        $.each($('#'+idForm).find('.itemForm input'),function(k,v){
            if($(v).attr('type') == 'text' || $(v).attr('type') == 'password'){
                largura = $(v).parent().width();
                if($(v).hasClass('ui-autocomplete-input')){
                    largura = largura - ($(v).next().width()+6);
                    if($(v).next().next().hasClass('btnModal')){
                        largura = largura - ($(v).next().next().width());
                    }
                }else if($(v).attr('style') && $(v).attr('style').indexOf('width') != -1){
                    largura = new Number($(v).css('width').replace('px',''))+6;
                }
                $(v).css('width',largura-6+'px');
            }else if($(v).attr('type') == 'radio' || $(v).attr('type') == 'checkbox'){
                $(v).css('width','auto');
            }
        });
    },
    getEndereco: function(cep,idForm) {
        // Se o campo CEP não estiver vazio
        objForm = $('#'+idForm);
        if(cep != ""){
            objForm.find('#loaderAjax').show();
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+cep, function(){
                if(resultadoCEP["resultado"] && resultadoCEP["bairro"] != ""){
                    objForm.find(".endereco").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                    objForm.find(".bairro").val(unescape(resultadoCEP["bairro"]));
                    objForm.find(".cidade").val(unescape(resultadoCEP["cidade"]));
                    objForm.find(".uf option[value='"+unescape(resultadoCEP["uf"])+"']").attr('selected','selected');
                }else{
                    Util.alertUI("Aviso","Endereço não encontrado");
                }
                objForm.find('#loaderAjax').hide();
            });
        }else{
            Util.alertUI("Aviso","Antes, preencha o campo CEP!");
        }
    }
};