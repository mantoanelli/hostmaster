<?php

require_once(DIR_UPLOADS . '../application/libraries/whm.php');

class UsuarioDominio extends CI_GenericModel {

    public $_table = "usuario_dominio";
    public $_pk = "usuario_dominio_id";
    public $whm;

    public function getUsuarioDominioCobranca($whr=null,$order) {
        if($whr){
            $whr = ' AND '.$whr;
        }
        $obj = new UsuarioDominioCobranca();
        $rows = $obj->getAll("usuario_dominio_id = {$this->getId()} {$whr}",$order);
        return $rows;
    }
    
    public function setValor($str) {
        $valor = toNumber($str);
        $valorReal = substr($valor, 0, strlen($valor) - 2);
        $valorCentavos = substr($valor, strlen($valor) - 2);
        $this->_fields['valor'] = $valorReal . '.' . $valorCentavos;
    }

    public function save() {
        if ($this->getId() > 0) {
            $old = new UsuarioDominio($this->getId());
            $sts = $this->getAtivo();
            $stsOld = $old->getAtivo();
            if ($sts != $stsOld) {
                if ($sts == '1') {
                    $this->unsuspend_account();
                } else {
                    $this->suspend_account();
                }
            }
        }
        $id = parent::save();
    }

    public function __construct($id = null) {
        $this->whm = whmLogin();
        parent::__construct($id);
    }

    public function getUsuario() {
        return new Usuario($this->getUsuarioId());
    }

    public function create_account($domain, $username, $password, $email, $package) {
        $api = $this->whm->create_account($domain, $username, $password, $email, $package);
        return $api;
    }

    public function unsuspend_account() {
        if ($this->getAccountCpanel()->suspended > 0) {
            $api = $this->whm->unsuspend_account($this->getUsuariocpanel());
            return $api;
        }
    }

    public function changePlanByUser($user, $plan) {
        $api = $this->whm->change_package($user, $plan);
        return $api;
    }

    public function suspend_account() {
        if ($this->getAccountCpanel()->suspended < 1) {
            $api = $this->whm->suspend_account($this->getUsuariocpanel());
            return $api;
        }
    }

    public function getAccountCpanel() {
        $api = $this->whm->list_accounts('user', $this->getUsuariocpanel());
        return $api[0];
    }

    public function getAccountCpanelByUser($user) {
        $api = $this->whm->list_accounts('user', $user);
        return $api[0];
    }

    public function getStatusAccountCpanel() {
        if ($this->getAccountCpanel()->suspended > 0) {
            return '0';
        } else {
            return '1';
        }
    }

    public function getPlanosCpanel() {
        return $this->whm->list_packages();
    }

    public function change_password_account($user, $pass) {
        return $this->whm->change_password_account($user, $pass);
    }

}
