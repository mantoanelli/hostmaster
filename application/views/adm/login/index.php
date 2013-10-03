<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title><?= $this->config->item('htmlTitle') ?></title>
        <base href="<?= base_url(); ?>" />
        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var site_url = '<?= site_url() ?>';
            var index_page = '<?= index_page() ?>';
            var fetch_class = '<?= $this->router->fetch_class(); ?>';
            var fetch_directory = '<?= $this->router->fetch_directory() == '' ? '' : $this->router->fetch_directory() . ''; ?>';
        </script>
        <!--CSS-->
        <link href="css/admin2/main.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />

        <!--JS-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/spinner/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/spinner/ui.spinner.js"></script>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

        <script type="text/javascript" src="js/admin2/plugins/wysiwyg/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/wysiwyg/wysiwyg.image.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/wysiwyg/wysiwyg.link.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/wysiwyg/wysiwyg.table.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/flot/jquery.flot.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/flot/jquery.flot.orderBars.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/flot/excanvas.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/flot/jquery.flot.resize.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/tables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/tables/colResizable.min.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/forms/forms.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/autogrowtextarea.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/autotab.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.dualListBox.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.inputlimiter.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/forms/jquery.tagsinput.min.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/other/calendar.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/other/elfinder.min.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/uploader/plupload.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/uploader/plupload.html5.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/uploader/plupload.html4.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/uploader/jquery.plupload.queue.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.progress.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.tipsy.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.alerts.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.colorpicker.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/wizards/jquery.form.wizard.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/wizards/jquery.validate.js"></script>

        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.breadcrumbs.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.collapsible.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.ToTop.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.listnav.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.sourcerer.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.timeentry.min.js"></script>
        <script type="text/javascript" src="js/admin2/plugins/ui/jquery.prettyPhoto.js"></script>

        <script type="text/javascript" src="js/admin2/custom.js"></script>

        <?php
        if (isset($_classesJs)) :
            foreach ($_classesJs as $js) :
                $path = BASEPATH . '../js/classes/admin2/' . $js . '.js';
                $caminho = base_url() . 'js/classes/admin2/' . $js . '.js';
                if (file_exists($path)) {
                    echo "<script type=\"text/javascript\" src=\"{$caminho}\"></script>";
                }
            endforeach;
        endif;
        ?>
        <?php
        if (isset($_classesCss)) :
            foreach ($_classesCss as $css) :
                $path = BASEPATH . '../css/admin2/' . $css . '.css';
                $caminho = base_url() . 'css/admin2/' . $css . '.css';
                echo '<link type="text/css" href="' . $caminho . '" rel="stylesheet" media="screen" />';
            endforeach;
        endif;
        ?>
    </head>
    <style>
        .loginLogo {
            position: absolute;
            width: 328px;
            height: 57px;
            display: block;
            top: -80px;
            left: 0;
            margin-left: 0;
        }
    </style>
    <body>

        <div class="loginWrapper">
            <div class="loginLogo"><img src="images/admin2/logo.png" alt="" /></div>
            <div class="loginPanel">
                <div class="head"><h5 class="iUser">Login</h5></div>
                <form action="<?= site_url('adm/login/checkLogin') ?>" method="post" id="valid" class="mainForm" enctype="application/x-www-form-urlencoded">
                    <fieldset>
                        <div class="loginRow">
                            <label for="req1">Login:</label>
                            <div class="loginInput"><input type="text" name="login" value="" placeholder="login" class="validate[required]" id="req1" /></div>
                            <div class="fix"></div>
                        </div>

                        <div class="loginRow">
                            <label for="req2">Senha:</label>
                            <div class="loginInput"><input type="password" name="senha" value=""  placeholder="senha" class="validate[required]" id="req2" /></div>
                            <div class="fix"></div>
                        </div>

                        <div class="loginRow">
                            <div class="rememberMe"><input type="checkbox" id="check2" name="chbox" /><label for="check2">Remember me</label></div>
                            <input type="submit" value="Log me in" class="basicBtn submitForm" />
                            <div class="fix"></div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <? $this->load->view('adm/footer') ?>
    </body>
</html>