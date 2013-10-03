<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientes extends CI_FormGridController {

    public function __construct() {
        parent::__construct('Usuario');

        $this->applyConfGrid(array('esqueceu_senha', 'ativo'), array(array('func' => 'SimNao')));
        $this->_camposGrid['qtd_acessos']['label'] = 'Acessos';
        $this->_camposGrid['esqueceu_senha']['label'] = 'Perdeu a senha?';
        $this->applyConfGrid(array('ultimo_acesso'), array(array('label' => 'Último acesso', 'func' => 'dataHoraBr', 'width' => '13%')));
        $this->applyConfGrid(array('nome', 'email'), array(array('width' => '20%')));
        $this->applyConfGrid(array('ativo', 'qtd_acessos', 'esqueceu_senha'), array(array('width' => '9%')));
        $this->applyOrderGrid('nome,login,email,ultimo_acesso,ativo');
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()), ''));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()), ''));
    }

    public function index($page = 0, $limitPerPage = 30, $orderField = null, $order = null) {
        $_REQUEST['search']['grupo_id'][] = 3;
        $unsetSearch[] = 'grupo_id';
        parent::index($page, $limitPerPage, $orderField, $order, $unsetSearch);
    }

    public function form($idRegistro = null) {
        $o = new UsuarioDominio();
        $planos = $o->getPlanosCpanel();
        $planoPreco = array_to_select_model('PlanoHost', 'nome', 'preco');
        $planosDisponíveis = array();
        foreach ($planoPreco as $plano => $preco){
            foreach ($planos as $planoCP){
                if($plano == $planoCP['name'])
                    $planosDisponíveis[] = $planoCP;
            }
        }
        
        $this->setData('planosCpanel',$planosDisponíveis);
        $this->setData('planoPreco',$planoPreco);
        
        parent::form($idRegistro);
    }

    public function save($id = null) {
        $obj = new Usuario();

        if ($obj->loginExists($_POST[$this->_defaultModel]['login'], $id)) {
            $_SESSION['msgSistema'][] = array('tipo' => 'erro', 'tipo_label' => 'ERRO', 'texto' => 'Este login já é usado por outro usuário.');
            redirect($_SERVER['HTTP_REFERER']);
            exit();
        }

        $obj = new Usuario($id);
        if ($obj->getId() != '') {
            if (empty($_POST[$this->_defaultModel]['senha'])) {
                unset($_POST[$this->_defaultModel]['senha']);
            }
        }
        $obj->setFieldsPost($obj, $_POST[$this->_defaultModel]);
        $usuario_id = $obj->save();

        $_SESSION['msgSistema'][] = array('tipo' => 'correto', 'tipo_label' => 'SUCESSO', 'texto' => 'Registro salvo com sucesso');
        if ($id)
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect('adm/' . getController());
    }

    public function verificaUsuarioCpanel() {
        $user = $_POST['user'];
        $o = new UsuarioDominio();
        $res = $o->getAccountCpanelByUser($user);
        if ($res) {
            echo '1';
        } else {
            echo '0';
        }
        //echo $user;
    }
    
    public function saveDominio(){
        
        if(isset($_POST['UsuarioDominio'])){
            $p = $_POST['UsuarioDominio'];
            if(!empty($p['id'])){
                $ud = new UsuarioDominio($p['id']);
                $account = $ud->getAccountCpanel();
                if($p['plano'] != $account->plan){
                    $result = $ud->changePlanByUser($account->user,$p['plano']);
                }
                $ud->setPlano($p['plano']);
                $ud->setPeriodoCobranca($p['periodo_cobranca']);
                $ud->setDesconto($p['desconto']);
                $ud->setValor($p['valor']);
                $ud->save();
                //debug();
                $_SESSION['msgSistema'][] = array('tipo' => 'correto', 'tipo_label' => 'SUCESSO', 'texto' => 'Domínio salvo com sucesso');
            }else{
                $u = new Usuario($p['usuario_id']);
                $ud = new UsuarioDominio();
                $ud->setDominio($p['dominio']);
                $ud->setUsuarioId($p['usuario_id']);
                $ud->setUsuariocpanel($p['usuariocpanel']);
                $ud->setPlano($p['plano']);
                $ud->setPeriodoCobranca($p['periodo_cobranca']);
                $ud->setProximaCobranca(now());
                $ud->setDesconto($p['desconto']);
                $ud->setValor($p['valor']);
                $ud->save();
                $ud->create_account($p['dominio'], $p['usuariocpanel'], $p['senhacpanel'], $u->getEmail(), $p['plano']);
                $_SESSION['msgSistema'][] = array('tipo' => 'correto', 'tipo_label' => 'SUCESSO', 'texto' => 'Domínio salvo com sucesso');
            }
        }
    }

}
