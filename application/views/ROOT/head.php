<!doctype html>
<html lang="pt-br" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="X-UA-Compatible" content="IE=8">
        <meta name="title" content="<?= $this->config->item('htmlTitle') . (isset($titleAdd) ? ' - ' . $titleAdd : '') ?>" />
        <meta name="keywords" content="<?= isset($keywords) ? $keywords : '' ?>">
        <meta name="description" content="<?= isset($description) ? $description : '' ?>">
        <meta name="google-site-verification" content=" " />
        <meta name="publisher" content="Agência WLD" />
        
        <meta name="language" content="pt-br">
        <meta name="classification" content="Internet">
        <title><?= $this->config->item('htmlTitle') . (isset($titleAdd) ? ' - ' . $titleAdd : '') ?></title>

        
        <link rel="stylesheet" href="<?= base_url() ?>/css/reset.css">
        <link rel="stylesheet" href="<?= base_url() ?>/css/style.css">
        <link rel="stylesheet" href="<?= base_url() ?>/css/header.css">
        <link rel="stylesheet" href="<?= base_url() ?>/css/interna.css">
        <link rel="stylesheet" href="<?= base_url() ?>/css/footer.css">
        <link rel="stylesheet" href="<?= base_url() ?>/js/jquery/select/chosen.css">
        <link rel="stylesheet" href="<?= base_url() ?>/js/jquery/colorbox/colorbox.css">
        
        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var site_url = '<?= site_url() ?>';
            var index_page = '<?= index_page() ?>';
            var fetch_class = '<?= $this->router->fetch_class(); ?>';
            var fetch_method = '<?= $this->router->fetch_method(); ?>';
            var fetch_directory = '<?= $this->router->fetch_directory() == '' ? '' : $this->router->fetch_directory() . ''; ?>';
        </script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/blogger.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/mask/jquery.maskedinput-1.3.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/phone_mask/phone_mask.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/form_default_value/form_default_value.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/validate/validate.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/validate/messages_ptbr.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/select/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/plugins.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/ckfinder/ckfinder.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery/blockUI/blockUI.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/Util.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/js.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/modal.js"></script>
        
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!--[if (gte IE 6)&(lte IE 8)]>
        <script type="text/javascript" src="<?= base_url() ?>js/selectivizr.js"></script>
        <![endif]-->

        <!--[if lte IE 7]>
        <script src="<?= base_url() ?>js/ie8.js" type="text/javascript"></script>
        <![endif]-->

        <!--[if IE]>
        <link rel="stylesheet" href="<?= base_url() ?>/css/header_ie.css">
        <![endif]-->
        <?php
        if (isset($_classesJs)) :
            foreach ($_classesJs as $js) :
                $path = BASEPATH . '../js/classes/' . $js . '.js';
                $caminho = base_url() . 'js/classes/' . $js . '.js';
                if (file_exists($path)) {
                    echo '<script type="text/javascript" src="' . $caminho . '?rand=' . rand(100, 999) . '"></script>';
                }
            endforeach;
        endif;
        ?>
        <?php
        if (isset($_classesCss)) :
            foreach ($_classesCss as $css) :
                $path = BASEPATH . '../css/' . $css . '.css';
                $caminho = base_url() . 'css/' . $css . '.css';
                if (file_exists($path)) {
                    echo '<link type="text/css" href="' . $caminho . '?rand=' . rand(100, 999) . '" rel="stylesheet" />';
                }
            endforeach;
        endif;
        ?>
    </head>