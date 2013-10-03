<div id="sidebar">
    <div id="boxLogo"><img src="<?= base_url() ?>images/admin/logo-admin.png" width="222" height="96"></div>
    <div class="linha"></div>
    <div id="visita">
        <p>Ultima visita:</p>
        <font><?= dataHoraBr($_SESSION[USER_ADM]['ultimoAcesso']) ?></font></div>
    <div class="linha"></div>
    <div id="nav">
        <ul class="listaNav">
            <? foreach ($menuAdmin as $k => $v): ?>
                <li> <a href="<?= (isset($v['sub']) ? 'javascript:void(0)' : $v['url']) ?>"><?= $v['label'] ?></a> 
                    <? if (isset($v['sub'])): ?>
                        <ul>
                            <? foreach ($v['sub'] as $ks => $vs): ?>
                                <li> <a href="<?= $vs['url'] ?>"><?= $vs['label'] ?></a></li>
                            <? endforeach; ?>
                        </ul>
                    <? endif ?>    
                </li>
            <? endforeach; ?>
        </ul>
    </div>
    <div class="linha"></div>
</div>