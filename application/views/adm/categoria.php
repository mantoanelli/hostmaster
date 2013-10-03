<!-- Modal Categoria -->
<script>
$(function(){
    $('#divCategoria .divActions .linkRemove').bind('click',alertDeleteRegistroCategoria);
    $('#divCategoria .divActions .linkEdit').bind('click',editRegistro);
});

function editRegistro(){
    objEdit = $(this);
    id = objEdit.parent().attr('idRegistro');
    value = objEdit.parent().parent().prev().text();
    $('form .<?=$controller?>_pk').val(id);
    $('form .<?=$controller?>_value').val(value);
}

function alertDeleteRegistroCategoria(){
    objDelete = $(this);
    
    id = objDelete.parent().attr('idRegistro');
    if(confirm('Tem certeza que deseja excluir o registro?')){
        deleteRegistroCategoria(id);
    }
}
function deleteRegistroCategoria(id){
    url = Util.site_url('adm/<?=$controller?>/delete/'+id);
    location.href = (url);
}

</script>
<div id="myModal" class="reveal-modal">
    <h1>Inserir Categoria</h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><div id="tabelaTop">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="27" style=" border-right:#CCC 1px solid;"><img src="<?= base_url() ?>images/admin/list.png" width="14" height="14" align="left" style="margin: 8px 6px;"></td>
                            <td valign="middle"><h2>Defina a categoria no campo abaixo:</h2></td>
                        </tr>
                    </table>
                </div></td>
        </tr>
        <tr>
            <td>
                <?=form_open($this->router->fetch_directory() . $controller . '/save/') ?>
                <input name="<?= $model ?>[<?=$pk?>]" type="hidden" value="" class="formEdit2 <?=$controller?>_pk">
                <input name="redirect" type="hidden" value="<?= site_url(implode('/',getRoute()))?>" class="formEdit2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelaModal">
                    <tr>
                        <td width="120"><p>Nome da Categoria:</p></td>
                        <td><input name="<?= $model ?>[nome]" type="text" value="" class="formEdit2 <?=$controller?>_value"></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Escolher Categoria:</p></td>
                        <td>
                            <div id="divCategoria" class="scroll-pane">
                                <table width="550" border="0" cellpadding="0" cellspacing="0">
                                    
                                    <tr>
                                        <td width="89%" class="tituloTabelaResultado" align="center" style="border-right:#CCC 1px solid; border-bottom:#CCC 1px solid;"><p>Categoria</p></td>
                                        <td width="11%" class="tituloTabelaResultado" align="center" style="border-bottom:#CCC 1px solid;"><p>Ações</p></td>
                                    </tr>
                                    <?foreach($categorias as $k => $v):?>
                                    <tr>
                                        <td width="89%" class="tituloTabela"><p><?=$v->getNome()?></p></td>
                                        <td width="11%" class="tituloTabela" align="center">
                                            <div class="divActions" idRegistro="<?=$v->getId()?>">
                                                <? if (hasPermission('editar','produtosCategorias')): ?><a href="javascript:void(0)" class="linkEdit vtip" title="Editar"></a> <?endif?>
                                                <? if (hasPermission('excluir','produtosCategorias')): ?><a href="javascript:void(0)" class="linkRemove vtip" title="Remover"></a><?endif?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?endforeach;?>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:none;">&nbsp;</td>
                        <td style="background:none;"><input type="submit" class="btFiltro" value="Salvar"></td>
                    </tr>
                </table>
                <?=form_close();?>
            </td>
        </tr>
    </table>
    <a class="close-reveal-modal">&#215;</a> 
</div>

<!-- Modal Categoria -->