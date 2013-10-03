<style>
    .dominios{
        border: 1px solid #222;
        border-radius: 5px;
        padding: 5px;
        margin: 10px 0;
        background: rgba(0,0,0,0.09);
    }
    .dadosDominio{
        display: nonee;
    }
</style>
<script>
    var precoPlano = Util.toJson('<?= json_encode($planoPreco) ?>');
</script>
<?
if (isset($row)):
    $uDominios = $row->getUsuarioDominio();
    foreach ($uDominios['rows'] as $kD => $vD):
        ?>
        <div class="dominios">
        <h2><?= $vD->getDominio() ?></h2>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="display mt10">
            <thead>
                <tr>
                    <th align="left">Valor</th>
                    <th align="left">Vencimento</th>
                    <th align="left">Data pagamento</th>
                    <th align="left">Status</th>
                    <th align="left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?
                $udc = $vD->getUsuarioDominioCobranca('','data_vencimento DESC');
                if($udc['total'] > 0):
                    foreach ($udc['rows'] as $kDC => $vDC):
                    ?>
                    <tr class="gradeA">
                        <td>R$ <?=currencyFormatAll($vDC->getValor())?></td>
                        <td><?=dataBr($vDC->getDataVencimento())?></td>
                        <td><?=dataBr($vDC->getDataPagamento())?></td>
                        <td><?=$vDC->getStatus()?></td>
                        <td>
                            <?if($vDC->getStatus()=='pendente'):?>
                                <input type="button" value="Gerar boleto" onclick="open('<?=$vDC->getUrlBoleto()?>','','')" class="greyishBtn" />
                            <?endif;?>
                        </td>
                    </tr>
                    <?endforeach;
                else:?>
                    <tr class="gradeA">
                        <td colspan="5">Sem cobranças</td>
                    </tr>
                <?endif;?>
            </tbody>
        </table>
        
        <?
    endforeach;
endif;
?> 