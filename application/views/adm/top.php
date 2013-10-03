<div id="topNav">
    <div class="fixed">
        <div class="wrapper">
            <div class="welcome"><a href="#" title=""><img src="images/admin2/userPic.png" alt="" /></a><span>Olá, <?= $_SESSION[USER_ADM]['nome'] ?></span></div>
            <div class="userNav">
                <ul>
                    <li><a href="<?=site_url('adm/meusDados')?>" title=""><img src="images/admin2/icons/topnav/profile.png" alt="" /><span>Meus Dados</span></a></li>
                    <!--li><a href="#" title=""><img src="images/admin2/icons/topnav/tasks.png" alt="" /><span>Tasks</span></a></li-->
                    <li class="dd"><a title=""><img src="images/admin2/icons/topnav/messages.png" alt="" /><span>Notificações</span><span class="numberTop">8</span></a>
                        <ul class="menu_body">
                            <li><a href="#" title="" class="sAdd">new message</a></li>
                            <li><a href="#" title="" class="sInbox">inbox</a></li>
                            <li><a href="#" title="" class="sOutbox">outbox</a></li>
                            <li><a href="#" title="" class="sTrash">trash</a></li>
                        </ul>
                    </li>
                    <!--li><a href="#" title=""><img src="images/admin2/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li-->
                    <li><a href="<?= site_url('adm/login/sair') ?>" title=""><img src="images/admin2/icons/topnav/logout.png" alt="" /><span>Sair</span></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>