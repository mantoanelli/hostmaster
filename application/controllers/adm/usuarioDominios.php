<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuarioDominios extends CI_FormGridController {

    public function __construct() {
        parent::__construct('UsuarioDominio');
    }

    public function gravaNovaSenhaCpanel() {
        if (isset($_POST['user'])) {
            $changePass = $this->model->change_password_account($_POST['user'], $_POST['pass']);
            echo json_encode($changePass);
        }
    }

    public function enviarNovaSenhaCpanelEmail() {
        if (isset($_POST['user'])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $oud = new UsuarioDominio();
            $ud = $oud->getOne("usuariocpanel='{$user}'");
            $emailDestino = $ud->getUsuario()->getEmail();
            $subject = 'Nova senha Painel de controle';
            $conteudoEmail = '
            Sua senha foi redefinida para o painel de controle e ftp do usuário <b>' . $user . '</b>.<br><br>
            Para gerenciar seu painel acesse '.$ud->getDominio().'/cpanel e entre com seu login <b>' . $user . '</b> e nova senha <b>' . $pass . '</b>.';

            $tpl = file_get_contents(DIR_UPLOADS . '../application/views/templateEmail/padrao.php');
            $tpl = str_replace("{ASSUNTO}", $subject, $tpl);
            $tpl = str_replace("{CONTEUDO}", $conteudoEmail, $tpl);
            $this->load->library('myemail');

            if ($this->myemail->enviarAuth('mail@rogeriomaster.com', 'HostMaster', $subject, $tpl, $emailDestino)) {
                echo '1';
            } else {
                echo '0';
            }
        }else{
            echo '0';
        }
    }
}