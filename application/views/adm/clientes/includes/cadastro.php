<div class="rowElem nobg">
    <?= form_hidden($CI->_defaultModel . '[grupo_id]', 3, 'class="formEdit"'); ?>
    <label>Nome:</label>
    <div class="formRight"><?= form_input($CI->_defaultModel . '[nome]', (isset($row) ? $row->getNome() : ''), 'class="validate[required]" id="' . $CI->_defaultModel . '[nome]' . '"'); ?></div>
    <div class="fix"></div>
</div>
<div class="rowElem">
    <label>E-mail:</label>
    <div class="formRight"><?= form_input($CI->_defaultModel . '[email]', (isset($row) ? $row->getEmail() : ''), 'class="validate[required,custom[email]]" id="' . $CI->_defaultModel . '[nome]' . '"'); ?></div>
    <div class="fix"></div>
</div>

<div class="rowElem">
    <label>Login:</label>
    <div class="formRight"><?= form_input($CI->_defaultModel . '[login]', (isset($row) ? $row->getLogin() : ''), 'class="validate[required]" id="' . $CI->_defaultModel . '[login]' . '"'); ?></div>
    <div class="fix"></div>
</div>

<div class="rowElem">
    <label>Senha:</label>
    <div class="formRight"><?= form_password($CI->_defaultModel . '[senha]', '', 'class=" ' . (!isset($row) ? 'validate[required,equals[confsenha]]' : 'validate[equals[confsenha]]') . '" id="senha" title="As senhas não são iguais"'); ?></div>
    <div class="fix"></div>
</div>
<div class="rowElem">
    <label>Confirme a senha:</label>
    <div class="formRight"><?= form_password($CI->_defaultModel . '[confsenha]', '', 'class="validate[equals[senha]]" id="confsenha" title="As senhas não são iguais"'); ?></div>
    <div class="fix"></div>
</div>

<div class="rowElem">
    <label>E-mail secundário:</label>
    <div class="formRight"><?= form_input($CI->_defaultModel . '[complemento][email_secundario]', (isset($row) ? $row->getUsuarioComplemento()->getEmailSecundario() : ''), 'class="validate[custom[email]]" id="' . $CI->_defaultModel . '[complemento][email_secundario]' . '"'); ?></div>
    <div class="fix"></div>
</div>
<div class="fix"></div>
<div class="rowElem nobg">
    <input type="submit" value="Salvar Mudanças" class="basicBtn submitForm" />
    <div class="fix"></div>
</div>