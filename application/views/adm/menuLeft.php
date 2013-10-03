
<div class="leftNav">
    <ul id="menu">
        <? foreach ($menuAdmin as $k => $v): ?>
            <li class="dash <?= removeAcentos($v['label'], '-') ?>"><a href="<?= ((isset($v['sub'])) ? ((count($v['sub']) > 1)?'javascript:void(0)':$v['sub'][0]['url']) : $v['url']) ?>" title="<?= $v['label'] ?>" class="<?= (isModuloAtivo($v) ? 'active' : '') ?> <?= ((isset($v['sub']) && count($v['sub']) > 1)) ? 'exp' : '' ?>"><span><?= $v['label'] ?></span></a>
                <? if (isset($v['sub']) && count($v['sub']) > 1): ?>
                    <ul class="sub">
                        <? foreach ($v['sub'] as $ks => $vs): ?>
                            <li><a href="<?= $vs['url'] ?>"><?= $vs['label'] ?></a></li>
                        <? endforeach; ?>
                    </ul>
                <? endif ?>    
            </li>
        <? endforeach; ?>
    </ul>
</div>