<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_AuthController extends CI_GenericController {

    public $noLogin = false;
    public $noPerms = false;
    public $user = null;
    public $perms = array();
    public $menu = array();

    public function __construct() {
        parent::__construct();
        
        if (isset($_COOKIE[COOKIE_MANTER_LOGADO]) && !isset($_SESSION[USER_ADM])) {
            //debug('Loga esse caboclo');
            $cook = explode("_",$_COOKIE[COOKIE_MANTER_LOGADO]);
            $user = new Usuario($cook[0]);
            if($user->getSenha() != "" && $user->getSenha() == $cook[1]){

                $_SESSION[USER_ADM]['id'] = $user->getId();
                $_SESSION[USER_ADM]['grupo_id'] = $user->getGrupoId();
                $_SESSION[USER_ADM]['email'] = $user->getEmail();
                $_SESSION[USER_ADM]['ultimoAcesso'] = $user->getUltimoAcesso();
                $_SESSION[USER_ADM]['qtdAcessos'] = $user->getQtdAcessos();
                $_SESSION[USER_ADM]['nome'] = $user->getNome();
                $_SESSION[USER_ADM]['manter'] = 1;
                if($this->router->fetch_class() == 'login'){
                    redirect($this->router->fetch_directory() . 'home');
                }
            }
        }
        
        if (!$this->isLogged() && !$this->noLogin) {
            redirect($this->router->fetch_directory() . 'login');
        } elseif (!$this->noLogin) {
            $this->user = new Usuario($_SESSION[USER_ADM]['id']);
            $this->getAllPermissions();
            $this->setUserPermissions();
            $this->setMenuAdmin();

            if (!$this->hasPermission()) {
                $erro = utf8_decode("Você não tem permissão para acessar este módulo.<br> Clique <a href=\"" . site_url('admin') . "\">aqui</a> para voltar.");
                exit($erro);
            }
            $this->setData('userLogado', $this->user);

            if ($_SESSION[USER_ADM]['manter'] == '1' && !isset($_COOKIE[COOKIE_MANTER_LOGADO])) {

                setcookie(COOKIE_MANTER_LOGADO, $this->user->getId().'_'.$this->user->getSenha(), (time() + 3600 * 24 * 14),"/",""); // Cookie de 2 semanas
            }
        }
        
    }

    public function isLogged() {

        if (isset($_SESSION[USER_ADM]['id']) && isset($_SESSION[USER_ADM]['email'])) {
            return $this->validateLogin($_SESSION[USER_ADM]);
        } else {
            return false;
        }
    }

    private function validateLogin($arr) {
        $user = new Usuario();
        $user = $user->getOne("usuario_id = '{$arr['id']}' AND email = '{$arr['email']}' AND grupo_id = '{$arr['grupo_id']}'");
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    private function getAllPermissions() {
        $this->perms['home']['modulo'] = "Home";
        $this->perms['home']['funcionalidades'][0] = array(
            'nome' => 'Home',
            'controller' => 'home',
            'show_menu' => 1,
            'perms' => array('listar' => 1, 'listar2' => 0, 'listar3' => 0),
        );
        $permissoes = new Permissao();
        $permissoesAll = $permissoes->getAll('funcionalidade_id = 0');

        $modulo = new Modulo();
        $modulos = $modulo->getAll(null, 'ordem');
        foreach ($modulos['rows'] as $k => $v) {
            if (!isset($this->perms[$v->getAlias()])) {
                $this->perms[$v->getAlias()] = array('modulo' => $v->getNome(), 'funcionalidades' => array());
            }
            $funcionalidades = $v->getFuncionalidade();
            foreach ($funcionalidades['rows'] as $kf => $vf) {
                $this->perms[$v->getAlias()]['funcionalidades'][$kf] = array(
                    'nome' => $vf->getNome(),
                    'controller' => $vf->getController(),
                    'show_menu' => $vf->getShowMenu(),
                    'perms' => array(),
                );
                foreach ($permissoesAll['rows'] as $kp => $vp) {
                    $this->perms[$v->getAlias()]['funcionalidades'][$kf]['perms'][$vp->getNome()] = 0;
                }
                $permissoesFun = new Permissao();
                $permissoesFunRows = $permissoesFun->getAll('funcionalidade_id = ' . $vf->getId());
                foreach ($permissoesFunRows['rows'] as $kp => $vp) {
                    $this->perms[$v->getAlias()]['funcionalidades'][$kf]['perms'][$vp->getNome()] = 0;
                }
            }
        }
    }

    private function setUserPermissions() {
        $permissoesUsuario = array();
        $funpermissao = new FuncionalidadePermissao();
        $funpermissao = $funpermissao->getAll("grupo_id = {$_SESSION[USER_ADM]['grupo_id']}");
        foreach ($funpermissao['rows'] as $k => $v) {
            $permissoesUsuario[$v->getFuncionalidade()->getController()]['perms'][] = $v->getPermissao()->getNome();
        }

        foreach ($this->perms as $kmod => $vmod) {
            foreach ($vmod['funcionalidades'] as $kfun => $vfun) {
                if (isset($permissoesUsuario[$vfun['controller']]['perms'])) {
                    foreach ($permissoesUsuario[$vfun['controller']]['perms'] as $kper => $vper) {
                        $this->perms[$kmod]['funcionalidades'][$kfun]['perms'][$vper] = 1;
                    }
                }
            }
        }

        //Limpa variavel onde não tem permissões
        foreach ($this->perms as $kmod => $vmod) {
            $qtdFunc = count($vmod['funcionalidades']);
            $qtdFuncUsed = 0;
            foreach ($vmod['funcionalidades'] as $kfun => $vfun) {
                $qtdPerm = count($vfun['perms']);
                $qtdPermUsed = 0;
                foreach ($vfun['perms'] as $kp => $vp) {
                    if ($vp == 1) {
                        $qtdPermUsed++;
                    } else {
                        unset($this->perms[$kmod]['funcionalidades'][$kfun]['perms'][$kp]);
                    }
                }
                if ($qtdPermUsed > 0) {
                    $qtdFuncUsed++;
                } else {
                    unset($this->perms[$kmod]['funcionalidades'][$kfun]);
                }
            }
            if ($qtdFuncUsed == 0) {
                unset($this->perms[$kmod]);
            }
        }
    }

    private function setMenuAdmin() {
        foreach ($this->perms as $k => $v) {
            $this->menu[$k] = array('label' => $v['modulo']);
            if (count($v['funcionalidades']) > 1) {
                $this->menu[$k]['url'] = "";
                $this->menu[$k]['controller'] = "";
                $this->menu[$k]['sub'] = array();
                foreach ($v['funcionalidades'] as $kf => $vf) {
                    if($vf['show_menu']){
                        $this->menu[$k]['sub'][$kf]['label'] = $vf['nome'];
                        $this->menu[$k]['sub'][$kf]['controller'] = $vf['controller'];
                        $this->menu[$k]['sub'][$kf]['url'] = site_url($this->router->fetch_directory() . $vf['controller']);
                    }
                }
            } else {
                $fun = current($v['funcionalidades']);
                $this->menu[$k]['label'] = $fun['nome'];
                $this->menu[$k]['controller'] = $fun['controller'];
                $this->menu[$k]['url'] = site_url($this->router->fetch_directory() . $fun['controller']);
            }
        }

        $this->setData('menuAdmin', $this->menu);
    }

    private function hasPermission() {
        $controller = $this->router->fetch_class();
        $r = false;
        foreach ($this->perms as $k => $v) {
            foreach ($v['funcionalidades'] as $kf => $vf) {
                if ($vf['controller'] == $controller) {
                    $r = true;
                }
            }
        }

        return $r;
    }

}