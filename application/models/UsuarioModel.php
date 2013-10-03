<?php

class Usuario extends CI_GenericModel {

    public $_table = "usuario";
    public $_pk = "usuario_id";
    public $search = array();

    public function __construct($id = null) {
        parent::__construct($id);
    }

    public function checkLogin($login, $senha) {
        $usuario = $this->getOne("login = '{$login}' AND senha = '{$senha}'");
        return $usuario;
    }

    public function loginExists($login, $id=null) {
        $usuario = $this->getOne("login = '{$login}'".(($id)?" AND usuario_id != '{$id}'":''));
        return $usuario;
    }

    public function checkLoginByEmail($email, $senha) {
        $usuario = $this->getOne("email = '{$email}' AND senha = '{$senha}'");
        return $usuario;
    }

    public function setSenha($str) {
        $this->_fields['senha'] = md5($str);
    }

    public function getUsuarioComplemento() {
        $objUsuarioComplemento = new UsuarioComplemento();
        $usuarioCompl = $objUsuarioComplemento->getOne("usuario_id = {$this->getId()}");
        return $usuarioCompl;
    }
    public function getUsuarioDominio() {
        $obj = new UsuarioDominio();
        $rows = $obj->getAll("usuario_id = {$this->getId()}");
        return $rows;
    }
    public function save() {
        $id = parent::save();
        
        if(isset($_POST['Usuario']['complemento'])){
            $objUsuarioComplemento = new UsuarioComplemento();
            $usuarioComplemento = $objUsuarioComplemento->getOne("usuario_id = {$id}");
            if(!$usuarioComplemento){
                $usuarioComplemento = $objUsuarioComplemento;
            }
            $_POST['Usuario']['complemento']['usuario_id'] = $id;
            $usuarioComplemento->setFieldsPost($usuarioComplemento, $_POST['Usuario']['complemento']);
            $usuarioComplemento->save();
        }
        return $id;
    }

}