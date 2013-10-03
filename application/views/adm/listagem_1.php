<script>
$(function(){
    $('#listagem.listagemPrincipal .linkRemove').bind('click',alertDeleteRegistro);
});

function alertDeleteRegistro(){
    objDelete = $(this);
    
    id = objDelete.parent().parent().parent().attr('idRegistro');
    if(confirm('Tem certeza que deseja excluir o registro?')){
        deleteRegistro(id);
    }
}
function deleteRegistro(id){
    url = Util.site_url('adm/'+fetch_class+'/delete/'+id);
    location.href = (url);
}

</script>

<? $this->load->view('adm/acoesListagem'); ?>
<? if (hasPermission('criar categoria'))
    $this->load->view($CI->getView('categoria'));
?>
<div id="content2"> 

    <? $this->load->view('adm/msgAdmin'); ?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0 0 0;padding:0 0 0 0;">
        <? if (hasPermission('buscar')): ?>
            <tr>
                <td>
                    <div id="tabelaTop">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="27" style=" border-right:#CCC 1px solid;"><img src="<?= base_url() ?>images/admin/lupa.png" width="14" height="14" align="left" style="margin: 8px 6px;"></td>
                                <td valign="middle"><h2>Busca Rápida por:</h2></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        <? endif; ?>
        <tr>
            <td valign="top">
                <div id="listagem" class="listagemPrincipal"> 
                    <? 
                    if (hasPermission('buscar')) 
                        $this->load->view('adm/buscaGenerica'); 
                    ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="993" valign="middle" style="margin:0 0 0 0;">
                                <div id="tabelaMeio">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="27" style=" border-right:#CCC 1px solid;"><img src="<?= base_url() ?>images/admin/list.png" width="14" height="14" align="left" style="margin: 8px 6px;"></td>
                                            <td valign="middle"><h2>Listagem</h2></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tabelaZebra" >
                                    <tr>
                                        <?
                                        foreach ($camposGrid as $campo => $field):
                                            if ($field['visible']):
                                                ?>
                                                <td class="tituloTabelaResultado" align="center"  style="width:<?= $field['width'] ?>;text-align: <?= $field['align'] ?>;border-right:#CCC 1px solid; border-bottom:#CCC 1px solid;"><p><?= $field['label'] ?></p></td>
                                                <?
                                            endif;
                                        endforeach
                                        ?>

                                        <td width="7%" class="tituloTabelaResultado" align="center" style="border-bottom:#CCC 1px solid;"><p>Ações</p></td>
                                    </tr>
                                    <? foreach ($listagem['rows'] as $k => $v): ?>
                                        <tr idRegistro="<?=$v->getId()?>">
                                            <?
                                            foreach ($camposGrid as $campo => $field):
                                                if ($field['visible']):
                                                    ?>
                                                    <td class="tituloTabela <?= isset($field['class'])?implode(' ',$field['class']):'' ?>" style="text-align: <?= $field['align'] ?>">
                                                        <p>
                                                            <?
                                                            if (isset($field['object'])) {
                                                                $r = $v->{$CI->getField($field['object'])}();
                                                                if (!is_object($r)) {
                                                                    $obj = ucfirst($field['object']);
                                                                    $r = new $obj($v->{$CI->getField($campo)}());
                                                                }
                                                            } else {
                                                                $r = $v->{$CI->getField($campo)}();
                                                            }
                                                            if (is_object($r)) {
                                                                $r = $r->{$CI->getField($field['field'])}();
                                                            }
                                                            if (isset($field['func'])) {
                                                                $r = call_user_func($field['func'], $r);
                                                            }
                                                            echo $r
                                                            ?>
                                                        </p>
                                                    </td>
                                                    <?
                                                endif;
                                            endforeach
                                            ?>
                                            <td width="7%" class="tituloTabela" align="center">
                                                <div class="divActions">
                                                    <? if (hasPermission('editar')): ?><a href="<?=site_url('adm/'.  getController().'/form/'.$v->getId())?>" class="linkEdit vtip" title="Editar"></a><?endif?>
                                                    <? if (hasPermission('excluir')): ?><a href="javascript:void(0)" class="linkRemove vtip" title="Remover"></a><?endif?>
                                                </div>
                                            </td>
                                        </tr>
                                    <? endforeach ?>
                                </table>
                                <script> zebra('tabelaZebra', 'branca'); </script>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"></td>
                        </tr>
                    </table>

                    <!-- End Resultado --> 

                </div></td>
        </tr>
        <tr>
            <td><div id="tabelaFooter"></div></td>
        </tr>
    </table>
</div>
