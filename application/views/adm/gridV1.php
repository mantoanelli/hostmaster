
<table align="center" id="gridViewV1" cellspacing="1" cellpadding="0" sortable="<?= ($ordenar) ? '1' : '0' ?>">
    <thead>
        <tr class="linhaTitulos">
            <? foreach ($camposGrid as $campo => $field):
                if ($field['visible']): ?>
                    <td class="item" style="width:<?= $field['width'] ?>;text-align: <?= $field['align'] ?>"><?= $field['label'] ?></td>
                    <?if(isset($field['order']) && $field['order'] === true):
                        $link = site_url($this->router->fetch_directory().$this->router->fetch_class().'/'.$this->router->fetch_method().'/0/'.$limitPerPage.'/'.$campo.'/'.(($orderField == $campo)?($order == 'asc'?'desc':'asc'):''));
			$link .= ($_SERVER['QUERY_STRING'] != "")? '?'.$_SERVER['QUERY_STRING'] : ''
                    ?>
                    <td class="item order <?=($orderField == $campo) ? $order : ''?>" url="<?=$link?>"></td>
                    <?endif;?>            
                <? endif;
            endforeach ?>
            <td class="item" style="width:75px; text-align: center">Ações</td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($listagem['rows'] as $k => $v): ?>
            <tr class="linha" idRegistro="<?= $v->getId() ?>" editing="0">
                <? foreach ($camposGrid as $campo => $field):
                    if ($field['visible']): ?>
                        <td class="item" <?=(isset($field['order']) && $field['order'] === true)?'colspan="2"':''?> style="width:<?= $field['width'] ?>;text-align: <?= $field['align'] ?>">
                            <?
                            if (isset($field['object'])) {
                                $r = $v->{$CI->getField($field['object'])}();
                                if (!is_object($r)) {
                                    $obj = ucfirst($field['object']);
                                    $r = new $obj($v->{$CI->getField($campo)}());
                                }
                                //debug($field['object']);
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
                        
                    <? endif;
                endforeach ?>
                <td class="item" style="width:80px; text-align: center">
                    <? if (hasPermission('editar')): ?><div class="acao edit"></div><? endif; ?>
                    <? if (hasPermission('excluir')): ?><div class="acao delete"></div><? endif; ?>
                    <? if ($ordenar && hasPermission('ordenar')): ?><div class="acao order"></div><? endif; ?>
                </td>
            </tr>
            <tr idRegistro="<?= $v->getId() ?>" class="linhaForm" style="display:none">
                <td colspan="<?= count($camposGrid) + 1 ?>">
                    <div class="aguarde" style="padding: 10px; text-align: center; margin: 5px auto; width: auto; background: #EFEFEF; color:#e80000 "><img src="<?= base_url() . ('images/admin/ajax-loader.gif') ?>" border="0" align="absmiddle" /> Aguarde um momento por favor.</div>
                </td>
            </tr>
        <? endforeach; ?>
    </tbody>
    <tfoot>
        <?if(isset($paginacao) && $paginacao):?>
        <tr class="linhaTitulos">
            <td class="item" colspan="<?= count($camposGrid) + 1 ?>">
                <div class="areaPaginacao">
                    <?= $paginacao ?>
                    <div class="c_both"></div>
                </div>
            </td>
        </tr>
        <?endif;?>
    </tfoot>
</table>