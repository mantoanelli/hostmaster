<script>
    $(function(){
        $('#example .linkRemove').bind('click',alertDeleteRegistro);
    });

    function alertDeleteRegistro(){
        objDelete = $(this);
    
        id = objDelete.parent().parent().attr('idRegistro');
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
<? $this->load->view('adm/msgAdmin'); ?>
<div class="table">
    <div class="head"><h5 class="iList">Listagem</h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <?
                foreach ($camposGrid as $campo => $field):
                    if ($field['visible']):
                        ?>
                        <th><?= $field['label'] ?></th>
                        <?
                    endif;
                endforeach
                ?>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($listagem['rows'] as $k => $v): ?>
                <tr class="gradeA"  idRegistro="<?=$v->getId()?>">
                    <?
                    foreach ($camposGrid as $campo => $field):
                        if ($field['visible']):
                            ?>
                            <td class="<?= isset($field['class']) ? implode(' ', $field['class']) : '' ?>" style="text-align: <?= $field['align'] ?>">

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
                            </td>

                            <?
                        endif;
                    endforeach
                    ?>
                    <td align="center">
                        
                            <? if (hasPermission('editar')): ?>
                                <a href="<?= site_url('adm/' . getController() . '/form/' . $v->getId()) ?>" class="btn14 mr5 rightDir " title="Editar" original-title="Editar">
                                    <img src="images/admin2/icons/color/pencil.png" alt="">
                                </a>
                                
                            <? endif ?>
                            <? if (hasPermission('excluir')): ?>
                                <a href="javascript:void(0)"  class="btn14 mr5 linkRemove rightDir " title="Remover" original-title="Remover">
                                    <img src="images/admin2/icons/color/cross.png" alt="">
                                </a>
                            <? endif ?>
                        
                    </td>
                </tr>

            <? endforeach ?>
        </tbody>
    </table>
</div>

