<?$this->load->view('adm/head');?>
    <body>
        <?
        $this->load->view('adm/top');
        $this->load->view('adm/header');
        ?>
        <div class="wrapper">
            <?$this->load->view('adm/menuLeft');?>
            <!-- Content -->
            <div class="content">
                <div class="title"><h5><?= getTituloController($menuAdmin); ?></h5></div>
                <div class="fix"></div>
                <? $this->load->view($CI->getView(((isset($contentView) && $contentView != '') ? $contentView : 'listagem')), $CI->_data); ?>
            </div>
            <div class="fix"></div>
        </div>

        <?
        $this->load->view('adm/footer');
        ?>
    </body>
</html>