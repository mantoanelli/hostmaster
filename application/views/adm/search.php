<div class="c_both"></div>
<style>
    .itemCriterio{
        margin-bottom: 4px;
        display: none;
    }

    .itemCriterio input{
        color:#555555;
        font-size:10px;
        padding:3px;
        width: 213px;
    }
    .itemCriterio select{
        border:1px solid #888888;
        color:#555555;
        font-size:10px;
        padding:2px;
        width: 200px;
    }

    .selCriterio, .selRegra, .selValor{
        float: left; margin-left: 4px
    }

    .addRmv{
        float: left; margin: 1px 0 0 4px;
    }

    .removeCriterio{
        display: none;
    }
    #cancelAdvancedSearch{
        float: right;
    }

    #areaCriterio{
        float:left;
    }
</style>
<script>
    url = '';
    var addRegra = false;
    j(function(){
        htmlCriterio = '<div class="itemCriterio criterio">'+j('.itemCriterio').html()+'</div>';
        j('.itemCriterio').show();
        j('#cancelAdvancedSearch').click(function () {
            j("#advancedSearch").slideUp('normal', function(){
                //j('.itemCriterio').remove();
                //j("#advancedSearch #areaCriterio").append(htmlCriterio);
                //j('.criterio').show();
            });
        });

        j('#submitAdvancedSearch').click(function () {
            if(url != '?search' && url != ''){
                urlOk = '<?= site_url($this->router->fetch_directory() . $this->router->fetch_class()) ?>'+url;
                urlOk = (urlOk);
                document.location.href=urlOk;
                
            }
            //j('#formSearch').submit();
        });
    });
    function addRegraBusca(){
        addRegra = true;
        
        htmlCriterioAdd = htmlCriterio.replace('"itemCriterio criterio"','"itemCriterio criterio'+(j('.itemCriterio').length)+'"')
        j('#advancedSearch #areaCriterio').append(htmlCriterioAdd);
        showDelCriterio();
        n = ((j('.itemCriterio').length)-1);
        j('.criterio'+n).find('.campo option[value=""]').attr('selected','selected');
        j('.criterio'+n).slideDown('normal',function(){
            addRegra = false;
        });
    }

    function removeRegraBusca(obj){
        obj.slideUp('normal',function(){
            obj.remove();
            showDelCriterio();
        });
    }

    function showDelCriterio(){
        add = 0;
        j.each(j(".itemCriterio"),function(){
            add++;
        });
        if(add > 1){
            j(".removeCriterio").show();
        }else{
            j(".removeCriterio").hide();
        }
        montaUrlBusca();
    }

    function defineRegras(obj,arrRegras,keyRegras,tipoCampo,valueCampo,valueKey,operadorSelecionado, valorSelecionado){
        
        if(!addRegra){
            if(arrRegras) {
                if(!valorSelecionado) valorSelecionado = '';
                if(!operadorSelecionado) operadorSelecionado = '';

                arrRegras = arrRegras.split(',');
                keyRegras = keyRegras.split(',');

                operadorSelecionado = operadorSelecionado.replace("=","%3D");

                selectTag = obj.find('.selRegra select');
                selectTag.removeAttr("disabled");
                selectTag.html('');
                j.each(arrRegras,function(k,v){
                    if(keyRegras[k] == operadorSelecionado)
                        selectTag.append('<option value="'+keyRegras[k]+'" selected="selected">'+v+'</option>');
                    else
                        selectTag.append('<option value="'+keyRegras[k]+'">'+v+'</option>');
                });

                if(tipoCampo == 'text'){
                    htm = '<input type="text" value="'+valorSelecionado+'" class="valorBusca textInput" value="'+valueCampo+'" onkeyup="montaUrlBusca()" onchange="montaUrlBusca()" />';
                }

                if(tipoCampo == 'select'){
                    htm = '<select class="valorBusca textInput noAutoComplete" onchange="montaUrlBusca()">';
                    valueCampo = valueCampo.split(',');
                    valueKey = valueKey.split(',');
                    j.each(valueCampo,function(k,v){
                        if(valorSelecionado == valueKey[k])
                            htm += '<option value="'+valueKey[k]+'" selected="selected">'+v+'</option>';
                        else
                            htm += '<option value="'+valueKey[k]+'">'+v+'</option>';
                    });
                    htm +='</select>';
                }

                if(tipoCampo == 'selectArray'){

                    valueCampo = valueCampo.split(',');
                    valueKey = valueKey.split(',');
                    htm = '<select class="valorBusca textInput noAutoComplete" onchange="montaUrlBusca()">';
                    j.each(valueCampo,function(k,v){
                        if(valorSelecionado == valueKey[k])
                            htm += '<option value="'+valueKey[k]+'" selected="selected">'+v+'</option>';
                        else
                            htm += '<option value="'+valueKey[k]+'">'+v+'</option>';
                    });
                    htm +='</select>';
                }

                if(tipoCampo == 'date'){
                    htm = '<input type="text" value="'+valorSelecionado+'" class="valorBusca inputDate textInput" value="'+valueCampo+'" onkeyup="montaUrlBusca()" onchange="montaUrlBusca()" />';

                }

                if(tipoCampo == 'money'){
                    htm = '<input type="text" value="'+valorSelecionado+'" class="valorBusca textInput" alt="signed-decimal" value="'+valueCampo+'" onkeyup="montaUrlBusca();" />';
                }

                if(tipoCampo == 'trueFalse'){
                    htm = '<select class="valorBusca textInput noAutoComplete" onchange="montaUrlBusca()">';
                    valueCampo = valueCampo.split(',');
                    valueKey = valueKey.split(',');
                    j.each(valueCampo,function(k,v){
                        if(valorSelecionado == v)
                            htm += '<option value="'+v+'" selected="selected">'+v+'</option>';
                        else
                            htm += '<option value="'+v+'">'+v+'</option>';
                    });
                    htm +='</select>';
                }

                obj.find('.selValor').html(htm);

                Util.init();
                montaUrlBusca();

            } else {
                selectTag = obj.find('.selRegra select');
                selectTag.html('');
                selectTag.attr("disabled","disabled");
                obj.find('.selValor').html('');
            }
        }

    }

    function montaUrlBusca(){
        camposDaBusca = [];
        condicao = j('input[name="condicaoMaster"]:checked').val();
        //j('.textInput').unbind("keyup",keyCode);
        j('.textInput').bind("keyup",keyCode);
        url = '?search';
        j.each(j('.itemCriterio'), function(k,v){
            campo = j(v).find('.campo option:selected').attr('nameCampo');
            tipo = j(v).find('.campo option:selected').attr('campo');
            operador = j(v).find('.regra').val();
            valor = j(v).find('.valorBusca').val();
            if(tipo == 'money'){
                valor = Util.moeda2float(valor).toFixed(2);
            }
            if(campo){
                if(k > 0){
                    url += '&search';
                }
                campo = condicao+campo+' '+operador;
                camposDaBusca.push(campo);
                ocorrenciasDoCampo = 0;
                for(x=0;x<camposDaBusca.length;x++){
                    if(campo = camposDaBusca[x]){
                        ocorrenciasDoCampo++;
                    }
                }
                /*if(ocorrenciasDoCampo > 0){
                    url += '<input type="hidden" name="search['+campo+'][]" value="'+valor+'" />';
                }else{
                    url += '<input type="hidden" name="search['+campo+']" value="'+valor+'" />';
                }*/
                
                
                if(ocorrenciasDoCampo > 0){
                    url += '['+campo+'][]='+valor;
                }else{
                    url += '['+campo+']='+valor;
                }
                
				
                //alert(camposDaBusca);
            }
        });
        //alert(j('input[name="condicaoMaster"]:checked').val());
        j('#formSearch').html(url);
    }

    function keyCode(e){
        e=e||window.event;
        var k=e.charCode||e.keyCode||e.which;
        if(k == 13)
            j('#submitAdvancedSearch').trigger('click');

    }
</script>
<?
$mostra = "";
$condicaoMaster = "";
if (isset($_REQUEST['search'])) {

    $mostra = "display: inline;";
    foreach ($_REQUEST['search'] as $k => $v) {
        if (strpos($k, 'OR ') !== FALSE) {
            $condicaoMaster = "OR ";
            $_REQUEST['search'][str_replace("OR ", "", $k)] = $v;
        }
    }
    $busca = $_REQUEST['search'];
}
?>
<div id="advancedSearch" style="<?= $mostra ?>">
    <form id="formSearch" method="post" style="display: none"></form>
    <div class="tituloAcoes">
        <div class="titulo">Busca Avan&ccedil;ada</div>
        <div class="acoesTitulo">
            <div class="itemAcao buscar" id="submitAdvancedSearch">Buscar</div>
            <div class="itemAcao cancelar" id="cancelAdvancedSearch">Cancelar</div>
            <? if (isset($_REQUEST['search'])): ?>
                <div class="itemAcao limpar" onclick="document.location.href='<?= site_url($this->router->fetch_directory() . $this->router->fetch_class()) ?>'">Limpar busca</div>
            <? endif ?>
        </div>
        <div class="c_both"></div>
    </div>
    <div class="c_both"></div>
    <div id="areaCriterioRegra" style="float: left;<?= (isset($_REQUEST['preFilter'])) ? 'display:none' : '' ?>">
        <label><input type="radio" name="condicaoMaster" value="" <?= ($condicaoMaster == "") ? "checked" : "" ?> onclick="montaUrlBusca()">Todas as regras</label>
        <label><input type="radio" name="condicaoMaster" value="OR " <?= ($condicaoMaster == "OR ") ? "checked" : "" ?> onclick="montaUrlBusca()">Pelo menos uma delas</label>
    </div>


    <div class="c_both"></div>
    <div id="areaCriterio" style="<?= (isset($_REQUEST['preFilter'])) ? 'display:none' : '' ?>">

        <?php if ($mostra == "") { ?>
            <div class="itemCriterio criterio">
                <div class="selCriterio">
                    <select class="campo textInput noAutoComplete" onchange="defineRegras(j(this).parent().parent(), this.value, j(this).find('option:selected').attr('valueKey'), j(this).find('option:selected').attr('campo'), j(this).find('option:selected').attr('campoValue'), j(this).find('option:selected').attr('campoKey'))">
                        <option value="">Selecione o crit&eacute;rio</option>
                        <?
                        foreach ($criterios as $k => $v) {
                            $regrasKey = array_keys($v['regras']);
                            $regrasValue = array_values($v['regras']);
                            $campoValue = @array_values($v['value']);
                            if (in_array($v['tipo'], array('model', 'selectArray'))) {
                                $campoKey = array_keys($v['value']);
                            } else {
                                $campoKey = @array_values($v['value']);
                            }
                            ?>
                            <option nameCampo="<?= $v['field'] ?>" valueKey="<?= @implode(',', $regrasKey) ?>" value="<?= @implode(',', $regrasValue) ?>" campo="<?= $v['campo'] ?>" campoValue="<?= @implode(',', $campoValue); ?>" campoKey="<?= @implode(',', $campoKey); ?>" ><?= $k ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="selRegra">
                    <select disabled class="regra textInput noAutoComplete" onchange="montaUrlBusca()">
                        <option value="">Selecione a regra</option>
                    </select>
                </div>
                <div class="selValor">

                </div>
                <div class="addRmv" style="margin-top: 1px;">
                    <a class="addCriterio" href="javascript:addRegraBusca();"><img src="<?= base_url() ?>images/admin/add16x16.png" title="Adicionar regra de busca" border="0" /></a>
                    <a class="removeCriterio" href="javascript:;" onclick="removeRegraBusca(j(this).parent().parent())"><img src="<?= base_url() ?>images/admin/del16x16.png" title="Adicionar regra de busca" border="0" /></a>
                </div>
                <div class="c_both"></div>
            </div>
            <?php
        } else {
            $x = 0;

            foreach ($busca as $chave => $valor) {

                @list($campo_buscado, $operador_buscado) = explode(" ", $chave);
                if ($campo_buscado == "OR")
                    continue;
                $x++;
                $y = 0;
                foreach ($valor as $searchValues):
                    ?>
                    <div class="itemCriterio criterio <?= $x . $y ?>">
                        <div class="selCriterio">

                            <select class="campo textInput noAutoComplete" onchange="defineRegras(j(this).parent().parent(), this.value, j(this).find('option:selected').attr('valueKey'), j(this).find('option:selected').attr('campo'), j(this).find('option:selected').attr('campoValue'), j(this).find('option:selected').attr('campoKey'))">
                                <option value="">Selecione o crit&eacute;rio</option>
                                <?
                                foreach ($criterios as $k => $v) {
                                    $regrasKey = array_keys($v['regras']);
                                    $regrasValue = array_values($v['regras']);
                                    $campoValue = is_array($v['value']) ? array_values($v['value']) : '';
                                    if (in_array($v['tipo'], array('model', 'selectArray'))) {
                                        $campoKey = array_keys($v['value']);
                                    } else {
                                        $campoKey = is_array($v['value']) ? array_values($v['value']) : '';
                                    }
                                    ?>
                                    <option nameCampo="<?= $v['field'] ?>" <?= ($campo_buscado == $v['field']) ? " selected=\"selected\" " : "" ?>valueKey="<?= @implode(',', $regrasKey) ?>" value="<?= @implode(',', $regrasValue) ?>" campo="<?= $v['campo'] ?>" campoValue="<?= @implode(',', $campoValue); ?>" campoKey="<?= @implode(',', $campoKey); ?>" ><?= $k ?></option>
                                <? } ?>
                            </select>

                            <script>
                                j(function(){
                                    defineRegras(j('.itemCriterio.criterio.<?= $x . $y ?>'), j('.itemCriterio.criterio.<?= $x . $y ?>').find('option:selected').attr('value'), j('.itemCriterio.criterio.<?= $x . $y ?>').find('option:selected').attr('valueKey'), j('.itemCriterio.criterio.<?= $x . $y ?>').find('option:selected').attr('campo'), j('.itemCriterio.criterio.<?= $x . $y ?>').find('option:selected').attr('campoValue'), j('.itemCriterio.criterio.<?= $x . $y ?>').find('option:selected').attr('campoKey'), '<?= $operador_buscado ?>', '<?= $searchValues ?>');
                                });
                            </script>
                        </div>
                        <div class="selRegra">
                            <select disabled class="regra textInput noAutoComplete" onchange="montaUrlBusca()">
                                <option value="">Selecione a regra</option>
                            </select>
                        </div>
                        <div class="selValor">

                        </div>
                        <div class="addRmv">
                            <a class="addCriterio" href="javascript:addRegraBusca();"><img src="<?= base_url() ?>images/admin/add16x16.png" title="Adicionar regra de busca" border="0" /></a>
                            <a class="removeCriterio" href="javascript:;" onclick="removeRegraBusca(j(this).parent().parent())"><img src="<?= site_url() ?>images/admin/del16x16.png" title="Adicionar regra de busca" border="0" /></a>
                        </div>
                        <div class="c_both"></div>
                    </div>
                    <?php
                    $y++;
                endforeach;
            }
            ?>
            <script>
                j(function(){
                    showDelCriterio();
                });
            </script>
            <?php
        }
        ?>
    </div>
    <div class="c_both"></div>
</div>
