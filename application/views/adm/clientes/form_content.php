<fieldset>

    <div class="widget first">       
        <ul class="tabs">
            <li><a href="#cadastro">Cadastro</a></li>
            <li><a href="#dominios">Domínios</a></li>
            <li><a href="#cobrancas">Cobranças</a></li>
        </ul>

        <div class="tab_container">
            <div id="cadastro" class="tab_content">
                <? include 'includes/cadastro.php'; ?>
            </div>
            <div id="dominios" class="tab_content">
                <? include 'includes/dominios.php'; ?>
            </div>
            <div id="cobrancas" class="tab_content">
                <? include 'includes/cobrancas.php'; ?>
            </div>
        </div>	
        <div class="fix"></div>		 
    </div>


</fieldset>
