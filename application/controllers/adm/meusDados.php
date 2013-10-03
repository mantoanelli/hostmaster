<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MeusDados extends CI_FormGridController{
    
    public function __construct() {
        parent::__construct('Usuario');
        $idRegistro =$_SESSION[USER_ADM]['id'];
        $model = new Usuario($idRegistro);
        $this->setData('row', $model);
        $this->setData('idRegistro', $idRegistro);
        $this->setData('idForm', $this->router->fetch_class() . '_editForm_' . $idRegistro);
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()),''));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),''));
    }
    
    public function save($id=null) {
        $obj = new Usuario();
        if($obj->loginExists($_POST[$this->_defaultModel]['login'],$id)){
            $_SESSION['msgSistema'][] = array('tipo'=>'erro','tipo_label'=>'ERRO','texto'=>'Este login já é usado por outro usuário.');
            redirect($_SERVER['HTTP_REFERER']);exit();
        }
        $obj = new Usuario($id);
        if($obj->getId() != ''){
            if(empty ($_POST[$this->_defaultModel]['senha'])){
                unset ($_POST[$this->_defaultModel]['senha']);
            }
        }
        $obj->setFieldsPost($obj, $_POST[$this->_defaultModel]);
        $obj->save();
        $_SESSION['msgSistema'][] = array('tipo'=>'correto','tipo_label'=>'SUCESSO','texto'=>'Registro salvo com sucesso');
        if($id)
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect('adm/'.  getController());
    }
}
