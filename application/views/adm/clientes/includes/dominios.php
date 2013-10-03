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
    
    $('.periodoCobranca,.desconto').bind('change',atualizaPrecoFinal);
    
    function atualizaPrecoFinal(){
        o = $(this);
    }
</script>
<?
if (isset($row)):
    $uDominios = $row->getUsuarioDominio();
    ?>
    <h2 class="mt10">Domínios Cadastrados</h2>
    <? foreach ($uDominios['rows'] as $kD => $vD):
        ?>
        <div class="dominios">
            
            <input type="hidden" name="UsuarioDominio[id]" value="<?= $vD->getId() ?>" />
            <div class="rowElem nobg">
                <label>Domínio:</label>
                <div class="formRight">
                    <?= $vD->getDominio() ?>
                    <input type="button" value="Ver dados do domínio" class="basicBtn toggleDadosDominio"  />
                </div>
                <div class="fix"></div>
            </div>
            <div class="dadosDominio">
                <div class="rowElem">
                    <label>Usuário Cpanel:</label>
                    <div class="formRight">
                        <?= $vD->getUsuariocpanel() ?>
                    </div>
                    <div class="fix"></div>
                </div>
                <div class="rowElem">
                    <label>Nova Senha Cpanel:</label>
                    <div class="formRight">
                        <?= form_password('novaSenha', '', 'class="novaSenha" user="' . $vD->getUsuariocpanel() . '" maxlength="" style="width:120px" id="senhanova"'); ?>
                        <input type="button" value="Gravar nova senha" class="greenBtn gravaNovaSenhaCpanel" />
                        <input type="button" value="Gerar nova senha" class="blueBtn gerarNovaSenhaCpanel" />
                    </div>
                    <div class="fix"></div>
                </div>
                <div class="rowElem">
                    <label>Plano:</label>
                    <div class="formRight noSearch">
                        <select name="<?= 'UsuarioDominio[plano]' ?>" class="chzn-select width-auto planoCpanel">
                            <? foreach ($planosCpanel as $k => $plan): ?>
                                <option value="<?= $plan['name'] ?>" <?= ($plan['name'] == $vD->getPlano()) ? 'selected="selected"' : '' ?>><?= $plan['name'] ?> (Disco: <?= $plan['quota'] ?> | Transf: <?= $plan['bandwidth'] ?> | E-mails: <?= $plan['pop'] ?> )</option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <div class="fix"></div>
                </div>
                <div class="rowElem">
                    <label>Periodo Cobrança:</label>
                    <div class="formRight noSearch">
                        <select name="<?= 'UsuarioDominio[periodo_cobranca]' ?>" class="chzn-select width-auto">
                            <option value="1" <?= (1 == $vD->getPeriodoCobranca()) ? 'selected="selected"' : '' ?>>Mensal</option>
                            <option value="3" <?= (3 == $vD->getPeriodoCobranca()) ? 'selected="selected"' : '' ?>>Trimestral</option>
                            <option value="6" <?= (6 == $vD->getPeriodoCobranca()) ? 'selected="selected"' : '' ?>>Semestral</option>
                            <option value="12" <?= (12 == $vD->getPeriodoCobranca()) ? 'selected="selected"' : '' ?>>Anual</option>
                        </select>
                    </div>
                    <div class="fix"></div>
                </div>

                <div class="rowElem"><label>Valor (mensal):</label><div class="formRight"><input name="<?= 'UsuarioDominio[valor]' ?>" value="<?= $vD->getValor() ?>" type="text" class="currency valorPlano" /></div><div class="fix"></div></div>
                <div class="rowElem"><label>Desconto (%):</label><div class="formRight"><input name="<?= 'UsuarioDominio[desconto]' ?>" value="<?= $vD->getDesconto() ?>" type="text" class="numberSpinner" /></div><div class="fix"></div></div>
                <div class="fix"></div>

                <div class="rowElem nobg">
                    <input type="button" value="Salvar Domínio" class="basicBtn fRight salvaDominio"  />
                    <div class="fix"></div>
                </div>
            </div>
            
        </div>
        <?
    endforeach;
endif;
?> 
<h2 class="mt10">Novo Domínio</h2>
<div class="dominios novo">
    <input type="hidden" name="UsuarioDominio[id]" value="" />
    <input type="hidden" name="UsuarioDominio[usuario_id]" value="<?=$row->getUsuarioId()?>" />
    <div class="rowElem nobg">
        <label>Domínio:</label>
        <div class="formRight"><?= form_input('UsuarioDominio[dominio]', '', 'class="" id="userdominio"'); ?></div>
        <div class="fix"></div>
    </div>
    <div class="rowElem">
        <label>Usuário Cpanel:</label>
        <div class="formRight">
            <?= form_input('UsuarioDominio[usuariocpanel]', '', 'class="usuarioCpanel" maxlength="8" style="width:120px" id="usercpanel"'); ?>
            <input type="button" value="" class="greyishBtn alertaUsuarioCpanel" />
            <input type="button" value="Verificar disponibilidade" class="greyishBtn verificaUsuarioCpanel" /> <img src="<?= base_url() ?>images/admin2/loaders/loader.gif" alt="" style="margin-left: 10px;display: none;">
        </div>
        <div class="fix"></div>
    </div>
    <div class="rowElem">
        <label>Senha Cpanel:</label>
        <div class="formRight">
            <?= form_password('UsuarioDominio[senhacpanel]', '', 'class="" maxlength="" style="width:120px" id="senhacpanel"'); ?>
            &nbsp;
            Confirme a senha: 
            &nbsp;
            <?= form_password('UsuarioDominio[confsenhacpanel]', '', 'class="" maxlength="" style="width:120px" id="confsenhacpanel" title="As senhas não estão iguais"'); ?>
        </div>
        <div class="fix"></div>
    </div>
    <div class="rowElem">
        <label>Plano:</label>
        <div class="formRight noSearch">
            <select name="<?= 'UsuarioDominio[plano]' ?>" class="chzn-select width-auto planoCpanel">
                <? foreach ($planosCpanel as $k => $plan): ?>
                    <option value="<?= $plan['name'] ?>"><?= $plan['name'] ?> (Disco: <?= $plan['quota'] ?> | Transf: <?= $plan['bandwidth'] ?> | E-mails: <?= $plan['pop'] ?> )</option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="fix"></div>
    </div>
    <div class="rowElem">
        <label>Periodo Cobrança:</label>
        <div class="formRight noSearch">
            <select name="<?= 'UsuarioDominio[periodo_cobranca]' ?>" class="chzn-select width-auto periodoCobranca">
                <option value="1">Mensal</option>
                <option value="3">Trimestral</option>
                <option value="6">Semestral</option>
                <option value="12">Anual</option>
            </select>
        </div>
        <div class="fix"></div>
    </div>

    <div class="rowElem"><label>Valor (mensal):</label><div class="formRight"><input name="<?= 'UsuarioDominio[valor]' ?>" type="text" class="currency valorPlano" /></div><div class="fix"></div></div>
    <div class="rowElem"><label>Desconto (%):</label><div class="formRight"><input name="<?= 'UsuarioDominio[desconto]' ?>" type="text" class="numberSpinner desconto" /></div><div class="fix"></div></div>
    <div class="rowElem"><label>Valor por cobrança:</label><div class="formRight">R$ <span>0,00</span></div><div class="fix"></div></div>
    <div class="fix"></div>
    <div class="rowElem nobg">
        <input type="button" value="Salvar Domínio" class="basicBtn fRight salvaDominio novo"  />
        <div class="fix"></div>
    </div>
</div>
