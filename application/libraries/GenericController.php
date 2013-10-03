<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_GenericController extends CI_Controller {

    protected $_module;
    protected $_controller;
    protected $_method;
    public $_data = array();

    public function __construct() {
        parent::__construct();

        $this->load->database();

        $this->load->helper('util');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Breadcrumb_model');

        $this->_module = $this->router->fetch_directory();
        $this->_module = substr($this->_module, strlen($this->_module) - 1, 1) == '/' ? substr($this->_module, 0, strlen($this->_module) - 1) : $this->_module;
        $this->_controller = $this->router->fetch_class();
        $this->_method = $this->router->fetch_method();
        $this->_data = array();
        $CI = & get_instance();
        $this->setData('CI', $CI);
        //$this->setData('breadCrumb', $this->Breadcrumb_model->get_breadcrumb());

        /* if (isset($_COOKIE[COOKIE_MANTER_LOGADO]) && !isset($_SESSION[USER_ADM])) {

          $cook = explode("_", $_COOKIE[COOKIE_MANTER_LOGADO]);
          $user = new Usuario($cook[0]);
          if ($user->getSenha() != "" && $user->getSenha() == $cook[1]) {
          $_SESSION[USER_ADM]['id'] = $user->getId();
          $_SESSION[USER_ADM]['grupo_id'] = $user->getGrupoId();
          $_SESSION[USER_ADM]['email'] = $user->getEmail();
          $_SESSION[USER_ADM]['ultimoAcesso'] = $user->getUltimoAcesso();
          $_SESSION[USER_ADM]['qtdAcessos'] = $user->getQtdAcessos();
          $_SESSION[USER_ADM]['nome'] = $user->getNome();
          $_SESSION[USER_ADM]['manter'] = 1;
          }
          } */

        if ($this->isLogged()) {
            $this->setData('loggado', true);
        } else {
            $this->setData('loggado', false);
        }

        $this->loadParametrosSistema();

        if ($this->router->fetch_directory() != 'adm/') {
            
        }
    }

    public function loadLogoFabricanteRandom() {
        $obj = new Fabricante();
        $row = $obj->getAll(null,'RAND()');
        //debug($row);
        $this->setData('fabricante', $row['rows'][0]);
    }
    
    public function loadMenuProdutos() {
        $obj = new ProdutoCategoria();
        $rows = $obj->getAll(null,'nome ASC');
        $this->setData('categorias', $rows['rows']);
    }

    public function cadastraMailling() {
        $mailing = new Mailing();
        $mailingExist = $mailing->getOne("email = '{$_POST['email']}'");
        if (!$mailingExist) {
            if (validaEmail($_POST['email'])) {
                //$mailing->setNome($_POST['nome']);
                $mailing->setEmail($_POST['email']);
                $mailing->save();
                redirectAlert('E-mail cadastrado com sucesso!', $_SERVER['HTTP_REFERER']);
            } else {
                redirectAlert(utf8_decode('Preencha um e-mail válido'), $_SERVER['HTTP_REFERER']);
            }
        } else {
            redirectAlert(utf8_decode('Seu e-mail já faz parte de nosso mailling.'), $_SERVER['HTTP_REFERER']);
        }
        exit();
    }

    public function buscaNavios($companhia_id=''){
        $whr = '';
        if($companhia_id != ''){
            $whr = "companhia_id = {$companhia_id}";
        }
        $arr = getArrNavios($whr);
        
        foreach($arr as $k => $v){
            $htm .= '<option value="'.$k.'">'.$v.'</option>';
        }
        echo $htm;
    }

    private function loadParametrosSistema() {
        $objParam = new Parametro();
        $parametros = $objParam->getAll();
        $params = array();
        foreach ($parametros['rows'] as $k => $v):
            $valores = $v->getParametroValor();
            foreach ($valores['rows'] as $kk => $valor):
                $date = strtotime(now());
                if ($date >= strtotime($valor->getDataInicio())) {
                    $params[$v->getNomeConstant()] = $valor->getValor();
                }
            endforeach;
        endforeach;

        foreach ($params as $k => $v):
            define($k, $v);
        endforeach;
    }

    public function index() {

        $this->load->view($this->getView('index'), $this->_data);
    }

    public function login() {
        $_POST = limpaPost($_POST);
        $usuario = new Usuario();
        $user = $usuario->checkLogin($_POST['login'], md5($_POST['senha']));

        if ($user && $user->getId()) {
            $_SESSION[USER_SITE]['id'] = $user->getId();
            $_SESSION[USER_SITE]['grupo_id'] = $user->getGrupoId();
            $_SESSION[USER_SITE]['login'] = $user->getLogin();
            $_SESSION[USER_SITE]['email'] = $user->getEmail();
            $_SESSION[USER_SITE]['ultimoAcesso'] = $user->getUltimoAcesso();
            $_SESSION[USER_SITE]['dataHora'] = now();
            $_SESSION[USER_SITE]['qtdAcessos'] = $user->getQtdAcessos();
            $_SESSION[USER_SITE]['nome'] = $user->getNome();
            $Usuario = new Usuario($user->getId());
            $Usuario->setUltimoAcesso(now());
            $Usuario->setQtdAcessos($Usuario->getQtdAcessos() + 1);
            $Usuario->save();
        } else {
            redirectAlert(utf8_decode("Seu login e/ou senha não conferem"), $_SERVER['HTTP_REFERER']);
            exit;
        }


        redirect($_SERVER['HTTP_REFERER']);
    }

    public function isLogged() {
        if (isset($_SESSION[USER_SITE]['id']) && isset($_SESSION[USER_SITE]['login'])) {
            return $this->validateLogin($_SESSION[USER_SITE]);
        } else {
            unset($_SESSION[USER_SITE]);

            $_COOKIE[COOKIE_MANTER_LOGADO] = "";
            unset($_COOKIE[COOKIE_MANTER_LOGADO]);
            $expire = 365 * 24 * 3600;
            setcookie(COOKIE_MANTER_LOGADO, "", time() - $expire, "/", "");
            return false;
        }
    }

    public function logout() {
        unset($_SESSION[USER_SITE]);

        $_COOKIE[COOKIE_MANTER_LOGADO] = "";
        unset($_COOKIE[COOKIE_MANTER_LOGADO]);
        $expire = 365 * 24 * 3600;
        setcookie(COOKIE_MANTER_LOGADO, "", time() - $expire, "/", "");

        redirect();
    }

    private function validateLogin($arr) {
        $user = new Usuario();
        $user = $user->getOne("usuario_id = '{$arr['id']}' AND login = '{$arr['login']}' AND grupo_id = '{$arr['grupo_id']}'");
        if ($user->getId()) {
            return true;
        } else {
            return false;
        }
    }

    public function getView($view = null) {
        $dir = $this->router->fetch_directory() == '' ? '/' : $this->_module . '/';

        $view = $view != null ? $view : $this->_method;
        $loadview = $dir . $this->_controller . '/' . $view;
        $loadview2 = $dir . $view;
        $caminhoView = APPPATH . 'views/' . $loadview . EXT;
        $caminhoView2 = APPPATH . 'views/' . $loadview2 . EXT;
        //debug($caminhoView);
        if (!file_exists($caminhoView)) {
            if (!file_exists($caminhoView2)) {
                return 'ROOT/' . $view . EXT;
            } else {
                return $dir . $view;
            }
        } else {
            return $dir . $this->_controller . '/' . $view;
        }
    }

    public function setData($index, $value) {
        $this->_data[$index] = $value;
    }

    public function getData($index) {
        return $this->_data[$index];
    }

    public function setFieldsPost($obj, $post) {
        $fields = $obj->_getFields();
        foreach ($post as $k => $v) {
            if (in_array($k, $fields)) {
                $partCampo = array();
                if (!is_array($v)) {
                    $campo = explode('_', $k);
                    foreach ($campo as $value) {
                        $partCampo[] = ucfirst($value);
                    }
                    $campo = 'set' . implode('', $partCampo);
                    $obj->$campo($v);
                }
            }
        }
    }

}