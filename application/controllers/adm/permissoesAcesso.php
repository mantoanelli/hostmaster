<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PermissoesAcesso extends CI_FormGridController{
    
    public function __construct() {
        //$this->_defaultModel = 'Permissao';
        //$this->_camposGrid = array(1,2,3);
        parent::__construct();                
        $this->setData('_classesJs', array($this->router->fetch_class()));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),'gridV1'));
    }
    
    public function index(){
        $grupo = new Grupo();
        $this->setData('grupos',$grupo->getAll());
        
        $funcionalidade = new Funcionalidade();
        $this->setData('funcionalidades',$funcionalidade->getAll());
        //exit();
        parent::index();
    }
    
    public function toogleAcess($grupoid,$funcid,$permid){
        if(hasPermission('editar')){
            $funcPerm = new FuncionalidadePermissao();
            $where = "grupo_id = {$grupoid} AND funcionalidade_id = {$funcid} AND permissao_id = {$permid} AND deleted IN (0,1)";
            $funcPerm = $funcPerm->getOne($where);
            //debug($funcPerm);
            if($funcPerm){
                $deleted = ($funcPerm->getDeleted() == '1')?'0':'1';
                $funcPerm->setDeleted($deleted);
                $funcPerm->save();
            }else{
                $funcPerm = new FuncionalidadePermissao();
                $funcPerm->setGrupoId($grupoid);
                $funcPerm->setFuncionalidadeId($funcid);
                $funcPerm->setPermissaoId($permid);
                $funcPerm->save();
                
            }
            echo json_encode(
                    array(
                        'deleted'   =>  $funcPerm->getDeleted(),
                        'grupoid'   =>  $funcPerm->getGrupoId(),
                        'funcid'    =>  $funcPerm->getFuncionalidadeId(),
                        'permid'    =>  $funcPerm->getPermissaoId(),
                    )
                 );
        }else{
            exit('Não, não... Você não pode mudar assim não, ta se achando o espertão agora né!');
        }
    }
}