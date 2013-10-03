<!--div class="pt20">
    <div class="nNote nWarning hideit">
        <p><strong>WARNING: </strong>This is a warning message. You can use this to warn users on any events</p>
    </div>
    <div class="nNote nInformation hideit">
        <p><strong>INFORMATION: </strong>This is a message for information, can be any general information.</p>
    </div>   
    <div class="nNote nSuccess hideit">
        <p><strong>SUCCESS: </strong>Success message! hoooraaay!!!!</p>
    </div>  
    <div class="nNote nFailure hideit">
        <p><strong>FAILURE: </strong>Oops sorry. That action is not valid, or our servers have gone bonkers</p>
    </div>
</div-->
<?
if (isset($msgSistema)):
    foreach ($msgSistema as $msg):
        ?>
        <div class="nNote <?=($msg['tipo']=='correto')?'nSuccess':'nFailure' ?> hideit">
            <p><strong><?= (isset($msg['tipo_label']) ? $msg['tipo_label'] : '') ?>:</strong> <?= $msg['texto'] ?></p>
        </div>
    <? endforeach;
endif;
?>
