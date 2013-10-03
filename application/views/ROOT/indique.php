<script>
    $(function(){
        $('#formIndique').validate();
    });
</script>
<div id="indiqueModal" class="reveal-modal">
    <div class="header">
        <h1 class="fLeft">Indique a um amigo</h1>
        <a href="javascript:void(0)" class="close-reveal-modal fRight">X FECHAR</a>
        <div class="clear"></div>
    </div>
    <div class="form">
        <form action="" method="post" id="formIndique">
            <div class="campos fLeft">
                <div class="item fLeft">
                    <input type="text" name="seu_nome" class="required" default="Seu Nome" />
                </div>
                <div class="item fLeft">
                    <input type="text" name="seu_email" class="required email" default="Seu E-mail" />
                </div>
                <div class="item fLeft" style="margin-top: 26px">
                    <input type="text" name="nome_amigo" class="required" default="Nome do seu amigo" />
                </div>
                <div class="item fLeft">
                    <input type="text" name="email_amigo" class="required email" default="E-mail do seu amigo" />
                </div>
            </div>
            
            <div class="campos fLeft">
                <div class="item fLeft">
                    <textarea name="mensagem" default="Mensagem"></textarea>
                </div>
                
                <div class="item fRight">
                    <input type="submit" class="button" value="Enviar" />
                </div>
            </div>
        </form>
    </div>

</div>
