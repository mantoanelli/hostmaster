<? $this->load->view('adm/msgAdmin'); ?> 
<? $this->load->view('adm/acoesListagem'); ?>
<?= form_open($this->router->fetch_directory() . $this->router->fetch_class() . '/save/' . $idRegistro, 'id="' . $idForm . '" class="validate mainForm" enctype="multipart/form-data"') ?>
<fieldset>
    <div class="widget first">
        <div class="head"><h5 class="iList">Defina nos campos abaixo</h5></div>
        <div class="rowElem nobg">
            <label>Nome:</label>
            <div class="formRight"><?= form_input($CI->_defaultModel . '[nome]', (isset($row) ? $row->getNome() : ''), 'class="validate[required]" id="' . $CI->_defaultModel . '[nome]' . '"'); ?></div>
            <div class="fix"></div>
        </div>
        <div class="rowElem">
            <label>E-mail:</label>
            <div class="formRight"><?= form_input($CI->_defaultModel . '[email]', (isset($row) ? $row->getEmail() : ''), 'class="validate[required,custom[email]]" id="' . $CI->_defaultModel . '[nome]' . '"'); ?></div>
            <div class="fix"></div>
        </div>

        <div class="head"><h5 class="iList">Dados de acesso</h5></div>
        <div class="rowElem nobg">
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

        <div class="fix"></div>
    </div>
    <div class="widget">
        <div class="body">
            <input type="submit" value="Salvar" class="basicBtn submitForm" />
            <div class="fix"></div>
        </div>
    </div>

</fieldset>
<?= form_close(); ?>
