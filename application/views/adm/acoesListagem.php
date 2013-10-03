<div class="widget acoesListagem">
    <div class="body">
        <? if ($this->router->fetch_method() == 'form'): ?>
            <a href="<?= site_url('adm/' . getController()) ?>" title="Voltar para listagem" original-title="Voltar para listagem" class="btnIconLeft mr10 mt5 rightDir"><img src="images/admin2/icons/dark/arrowLeft.png" alt="" class="icon"><span>Voltar</span></a>
        <? endif ?>

        <? if ($this->router->fetch_method() != 'form'): ?>
            <? if (hasPermission('criar')): ?>
                <a href="<?= site_url('adm/' . getController() . '/form') ?>" title="Inserir novo registro" original-title="Inserir novo registro" class="btnIconLeft mr10 mt5 rightDir"><img src="images/admin2/icons/dark/add.png" alt="" class="icon"><span>Inserir novo</span></a>
                <? endif ?>
            <? endif
            ?>
    </div>
</div>

