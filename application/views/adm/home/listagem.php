<div> 
    <div id="boasVindas">
        <div class="texto" style="text-align: center">Bem vindo ao administrador.</div>
        <br /><br />
        <div class="infos" style="text-align: center">
            Olá <strong><?= $_SESSION[USER_ADM]['nome'] ?></strong>, esse é seu acesso nº <strong><?= $_SESSION[USER_ADM]['qtdAcessos'] ?></strong>, seu último acesso foi em <strong><?= dataBr($_SESSION[USER_ADM]['ultimoAcesso'], 'd/m/Y H:i:s') ?></strong>.
        </div>
    </div>
    <div class="fix"></div>
</div>
