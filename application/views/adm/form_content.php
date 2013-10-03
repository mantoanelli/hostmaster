<fieldset>
    <div class="widget first">
        <div class="head"><h5 class="iList">Defina nos campos abaixo</h5></div>
        <?php $CI->getForm(isset($row) ? $row : null) ?>

        <div class="fix"></div>
    </div>
    <div class="widget">
        <div class="body">
            <input type="submit" value="Salvar" class="basicBtn submitForm" />
            <div class="fix"></div>
        </div>
    </div>
</fieldset>
