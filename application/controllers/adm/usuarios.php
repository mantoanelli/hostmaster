<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios extends CI_FormGridController{
    
    public function __construct() {
        parent::__construct('Usuario');

        $this->_camposGrid['ativo']['func'] = 'SimNao';
        $this->_camposGrid['qtd_acessos']['label'] = 'Acessos';
        $this->applyConfGrid(array('ultimo_acesso'), array(array('label'=>'Último acesso','func'=>'dataHoraBr','width'=>'15%')));
        $this->applyConfGrid(array('nome','email'), array(array('width'=>'20%')));
        $this->applyConfGrid(array('ativo','qtd_acessos'), array(array('width'=>'7%')));
        
        $this->_camposGrid['grupo_id'] = array(
            'label' => 'Grupo',
            'visible' => 1,
            'align'=>'left',
            'width'=>'20%',
            'object'=>'grupo',
            'field'=>'nome',
        );
        $this->applyOrderGrid('nome,login,email,ultimo_acesso,qtd_acessos,ativo');       
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()),''));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),''));
        
        
    }
    
    public function form($idRegistro = null) {
        $objGrupos = new Grupo();
        $grupos = $objGrupos->getAll(null,'nome');
        $grupos = array_to_select($grupos['rows'], 'grupo_id', 'nome', 'Selecione');
        $this->setData('grupos', $grupos);
        parent::form($idRegistro);
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
