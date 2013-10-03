
<tr class="valores">
    <td>Valor</td>
    <td><?= form_input('Parametro[valores][valor][]', isset($vItem) ? $vItem->getValor() : '', 'class="valor" style="width:150px"') ?></td>
    <td>Data inicial:</td>
    <td><?= form_input('Parametro[valores][data_inicio][]', isset($vItem) ? dataBr($vItem->getDataInicio()) : '', 'class="inputDate" style="width:150px"') ?></td>
    <td>
        <a href="javascript:void(0)" title="Adicionar valores" class="btn14 mr5 rightDir"  onclick="addItemFormFull($(this),'.valores','triggerTipo')"><img src="images/admin2/icons/dark/add.png" alt=""></a>
        <a href="javascript:void(0)" title="Remover valores" class="btn14 mr5 rightDir"><img src="images/admin2/icons/dark/trash.png" alt=""></a>
    </td>
</tr>
