<table align="center" id="gridViewV1" cellspacing="1" cellpadding="0">
    <form class="mainForm">
    <? foreach ($grupos['rows'] as $k => $v): ?>
        <fieldset>
            <div class="widget first">
                <div class="head"><h5 class="iList"><?= $v->getNome() ?></h5></div>

                <? foreach ($funcionalidades['rows'] as $kf => $vf): ?>
                    <div class="rowElem">
                        <label><?= $vf->getNome(); ?></label>
                        <div class="formRight" style="margin: 0">
                        <? foreach ($vf->getPermissions() as $kp => $vp): ?>
                        <a href="javascript:void(0)" class="btnIconLeft mr10 perms <?= (hasPermissionGroup($vp->getId(), $vf->getId(), $v->getId()) ? 'havePerm' : '') ?>"  grupoid="<?= $v->getId(); ?>" funcid="<?= $vf->getId(); ?>" permid="<?= $vp->getId(); ?>"><img src="images/admin2/icons/color/<?= (hasPermissionGroup($vp->getId(), $vf->getId(), $v->getId()) ? 'tick' : 'cross') ?>.png" alt="" class="icon"><span><?= $vp->getNome(); ?></span></a>
                        <? endforeach; ?>
                        </div>
                        <div class="fix"></div>
                    </div>
                <? endforeach; ?>
                <div class="fix"></div>
            </div>
        </fieldset>
        
    <? endforeach; ?>
    </form>
</table>
<?
//$this->load->view($CI->getView('acoesForm'));?>