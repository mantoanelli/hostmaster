<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_FormGridController {

    public function __construct() {
        $this->noLogin = true;
        $this->noPerms = true;
        parent::__construct();
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class())));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class())));
    }

    public function checkLogin($loginFora = null) {
        $login = $_POST['login'];
        $senha = md5($_POST['senha']);
        $manter = 0;
        if (isset($_POST['manter']))
            $manter = $_POST['manter'];
        $usuario = new Usuario();

        $user = $usuario->checkLogin($login, $senha);

        if ($user && $user->getId()) {
            $_SESSION[USER_ADM]['id'] = $user->getId();
            $_SESSION[USER_ADM]['grupo_id'] = $user->getGrupoId();
            $_SESSION[USER_ADM]['email'] = $user->getEmail();
            $_SESSION[USER_ADM]['ultimoAcesso'] = $user->getUltimoAcesso();
            $_SESSION[USER_ADM]['qtdAcessos'] = $user->getQtdAcessos();
            $_SESSION[USER_ADM]['nome'] = $user->getNome();
            $_SESSION[USER_ADM]['manter'] = $manter;

            $Usuario = new Usuario($user->getId());
            $Usuario->setUltimoAcesso(now());
            $Usuario->setQtdAcessos($Usuario->getQtdAcessos() + 1);
            $Usuario->save();

            redirect('adm');
        } else {
            redirectAlert(utf8_decode('Login e/ou senha não conferem'), site_url('adm'));
        }

        echo $r;
    }

    public function sair() {

        unset($_SESSION[USER_ADM]);
        $_COOKIE[COOKIE_MANTER_LOGADO] = "";
        unset($_COOKIE[COOKIE_MANTER_LOGADO]);
        $expire = 365 * 24 * 3600;
        setcookie(COOKIE_MANTER_LOGADO, "", time() - $expire, "/", "");


        redirect('adm/login');
    }

    public function trocaSenha() {
        $Usuario = new Usuario($_SESSION[USER_ADM]['id']);
        if ($Usuario->getSenha() != md5($_POST['senhaAtual'])) {
            echo 'A senha atual não é válida. Verifique se foi digitada corretamente.';
        } else {
            $Usuario->setSenha(($_POST['senhaNova']));
            $Usuario->save();
            echo 'ok';
        }
    }

}