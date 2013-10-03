<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_FormGridController extends CI_AuthController {

    public $_defaultModel;
    public $_camposGrid;
    public $_camposForm;
    public $_gerenciaCategoria;
    public $modelsFaltam = array();
    public $_modAssoc = array();
    public $model;
    public $_setWhrNoSearch = array();
    public $_customSearch = array();

    public function __construct($model = null) {
        parent::__construct();

        $this->verificaFaltaModels();

        if ($model) {
            $this->_defaultModel = ucfirst($model);
            $obj = new $this->_defaultModel();
            $this->model = $obj;
            $this->_camposGrid[strtolower($obj->_table . '_id')] = array('label' => 'ID', 'width' => '30px', 'align' => 'center', 'visible' => 1);
        }

        if (!empty($this->_defaultModel))
            $this->setCamposGrid();
        if (!empty($this->_defaultModel))
            $this->setCamposForm();



        if (isset($_SESSION['msgSistema'])) {
            $msgSistema = $_SESSION['msgSistema'];
            unset($_SESSION['msgSistema']);
            $this->setData('msgSistema', $msgSistema);
        }
    }

    private function setGereciamentoCategoriaModulo() {
        $model = $this->_gerenciaCategoria['model'];
        $controller = $this->_gerenciaCategoria['controller'];
        $pk = $this->_gerenciaCategoria['pk'];
        $objCat = new $model();
        $categorias = $objCat->getAll();
        $this->setData('categorias', $categorias['rows']);
        $this->setData('controller', $controller);
        $this->setData('model', $model);
        $this->setData('pk', $pk);
    }

    public function verificaFaltaModels() {
        $models = array();
        $modelsFaltam = array();
        $sql = "SHOW TABLES";
        $res = $this->db->query($sql);
        $rows = $res->result_array();
        foreach ($rows as $k => $v):
            $v = array_values($v);
            $models[$v[0]]['file'] = formatNameModel($v[0]) . 'Model.php';
            $models[$v[0]]['classname'] = formatNameModel($v[0]);
        endforeach;

        //Verifica qual model falta
        foreach ($models as $k => $v):
            $filename = APPPATH . 'models/' . $v['file'];
            if (!file_exists($filename)) {
                $this->modelsFaltam[$k] = $v;
            }
        endforeach;

        if (isset($_SESSION[USER_ADM]) && $_SESSION[USER_ADM]['grupo_id'] == 1)
            $this->setAlerts();
    }

    private function setAlerts() {
        $html = array();

        if (count($this->modelsFaltam) > 0) {
            $aviso = '
                <div class="alertSistema">
                <div class="titulo">
                    <div class="txt">Algumas models estão faltando</div>
                     <div class="ignorar" onclick="j(this).parents(\'.alertSistema\').remove()">[ignorar]</div>
                    <div class="showHide show">[mostrar] </div>
                   
                    <div class="c_both"></div>
                </div>
                <div class="conteudoAviso">
                    <p>
                        O sistema identificou que faltam as seguintes models:
                    </p>
                    <table cellpadding="4" cellspacing="2" align="center">
                        <tr><th style="background:#AA0000;color:#FFF">Entidade (tebela DB)</th><th style="background:#AA0000;color:#FFF">Model (application/models/...)</th></tr>
                        ';
            foreach ($this->modelsFaltam as $k => $v) {
                $aviso .= '<tr><td style="background:#f5f5f5">' . $k . '</td><td style="background:#f5f5f5">' . $v['file'] . '</td></tr>';
            }
            $aviso .='
                    </table>
                    <p>
                        O que deseja fazer?: <button onclick="criarModels(j(this))">Criar models</button> <button onclick="j(this).parents(\'.alertSistema\').remove()">Ignorar aviso</button>
                    </p>
                </div>
            </div>
            ';
            $html[] = $aviso;
        }

        if (count($html) > 0) {
            $this->setData('avisoSistema', $html);
        }
    }

    public function createModels() {

        $modeloModel = '<?php
class {CLASSNAME} extends CI_GenericModel {

    public $_table = "{TABLE}";
    public $_pk = "{PK}";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
';
        foreach ($this->modelsFaltam as $k => $v):
            $f = fopen(APPPATH . 'models/' . $v['file'], 'w');
            $modelContent = $modeloModel;
            $modelContent = str_replace("{CLASSNAME}", $v['classname'], $modelContent);
            $modelContent = str_replace("{TABLE}", $k, $modelContent);
            $modelContent = str_replace("{PK}", $k . '_id', $modelContent);
            fwrite($f, $modelContent);
            fclose($f);
            chmod(APPPATH . 'models/' . $v['file'], 0777);
        endforeach;

        $r['erro'] = "";
        echo json_encode($r);
    }

    public function index($page = 0, $limitPerPage = 30, $orderField = null, $order = null, $unsetSearch = null) {
        if (!empty($this->_defaultModel)) {
            $obj = new $this->_defaultModel();
            if (count($this->_customSearch) == 0) {
                if (isset($obj->search)) {
                    $this->setCamposBusca($obj);
                }
            } else {
                $this->setCamposBuscaCustom($this->_customSearch);
            }

            $where = $this->setWhere();
            if ($unsetSearch) {
                foreach ($unsetSearch as $unset) {
                    unset($_REQUEST['search'][$unset]);
                }
            }
            $orderBy = "";
            $orderField = ($orderField) ? $orderField : $obj->_pk;
            $order = ($order) ? $order : 'asc';
            $orderBy = "{$orderField} {$order}";
            //$limit = "LIMIT {$page},{$limitPerPage}";
            $limit = "";
            $listagem = $obj->getAll($where, $orderBy, $limit);
            if (isset($_REQUEST['search']) && count($_REQUEST['search']) == 0) {
                unset($_REQUEST['search']);
            }
            $this->setData('page', $page);
            $this->setData('limitPerPage', $limitPerPage);
            $this->setData('orderField', $orderField);
            $this->setData('order', $order);
            $this->setData('listagem', $listagem);
            $this->setData('paginacao', getPaginationGrid($limitPerPage, $listagem['total']));
            $this->setData('ordenar', $this->setOrdenarGrid());
        }


        $this->setData('camposGrid', $this->_camposGrid);

        if (!empty($this->_gerenciaCategoria))
            $this->setGereciamentoCategoriaModulo();

        parent::index();
    }

    public function setCamposBusca($obj) {

        $criterios = array();
        $search = $obj->search;
        ksort($search);

        foreach ($search as $k => $v) {
            if (!is_array($v['value'])) {
                $v['value'] = (strpos($v['value'], "func:") !== FALSE) ? call_user_func(str_replace("func:", "", $v['value'])) : $v['value'];
            }
            if (is_array($v['value'])) {
                $criterios[$k] = array();
                $criterios[$k]['value'] = $v['value'];
                $criterios[$k]['campo'] = $v['tipocampo'];
                $criterios[$k]['regras'] = $v['regras'];
                $criterios[$k]['field'] = $v['field'];
                $criterios[$k]['tipo'] = ($v['tipocampo'] == 'selectArray') ? $v['tipocampo'] : '';
            } else {
                if (strpos($v['value'], 'model.') !== FALSE) {
                    $criterios[$k] = array();
                    $model = (substr($v['value'], strpos($v['value'], '.') + 1));
                    $this->loadModel($model);
                    unset($v['value'], $valueTmp);
                    //$v['value'] = $this->$model->getAll(null,null,'');
                    $tipocampo = explode('.', $v['tipocampo']);
                    if (strpos($tipocampo[1], "__") !== FALSE) {
                        $campoorder = current(explode("__", $tipocampo[1]));
                    } else {
                        $campoorder = $tipocampo[1];
                    }
                    if (isset($v['where']) && is_array($v['where'])) {
                        //$v['value'] = $this->$model->getAllByFieldsNoAssociations($v['where'], null, null, $campoorder, 'asc');
                    } else {
                        //$v['value'] = $this->$model->getAllByFieldsNoAssociations(array(), null, null, $campoorder, 'asc');
                    }
                    $valueTmp = array();
                    foreach ($v['value']['rows'] as $key => $value) {
                        if (isset($v['prefixcampo'])) {
                            $valueTmp[$value['id']] = $value[$v['prefixcampo']] . ' - ' . str_replace(",", "", $value[$tipocampo[1]]);
                        } else {
                            if (strpos($tipocampo[1], "__") !== FALSE) {
                                $valueCampo = array();
                                $valueCampoArr = explode("__", $tipocampo[1]);
                                foreach ($valueCampoArr as $vCampo) {
                                    $valueCampo[] = $value[$vCampo];
                                }
                                $valueTmp[$value['id']] = str_replace(",", "", implode(" - ", $valueCampo));
                            } else {
                                $valueTmp[$value['id']] = str_replace(",", "", $value[$tipocampo[1]]);
                            }
                        }
                    }

                    $criterios[$k]['value'] = (isset($valueTmp)) ? $valueTmp : '';
                    $criterios[$k]['campo'] = $tipocampo[0];
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'model';
                } elseif (strpos($v['value'], 'enum.') !== FALSE) {
                    $criterios[$k] = array();
                    $campo = strtolower(substr($v['value'], strpos($v['value'], '.') + 1));
                    $v['value'] = show_enum_values($this->_defaultModel->getTable(), $campo);
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = 'select';
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'enum';
                } elseif (strpos($v['value'], 'enum2.') !== FALSE) {
                    $criterios[$k] = array();
                    $campo = explode('.', $v['value']);
                    //$campo = strtolower(substr($v['value'],strpos($v['value'],'.')+1));
                    $v['value'] = show_enum_values($campo[1], $campo[2]);
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = 'select';
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'enum';
                } else {
                    $criterios[$k] = array();
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = $v['tipocampo'];
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = '';
                }
            }
        }
        $this->setData('criterios', $criterios);
    }

    public function setCamposBuscaCustom($obj) {

        $criterios = array();
        $search = $obj;
        ksort($search);

        foreach ($search as $k => $v) {
            if (!is_array($v['value'])) {
                $v['value'] = (strpos($v['value'], "func:") !== FALSE) ? call_user_func(str_replace("func:", "", $v['value'])) : $v['value'];
            }
            if (is_array($v['value'])) {
                $criterios[$k] = array();
                $criterios[$k]['value'] = $v['value'];
                $criterios[$k]['campo'] = $v['tipocampo'];
                $criterios[$k]['regras'] = $v['regras'];
                $criterios[$k]['field'] = $v['field'];
                $criterios[$k]['tipo'] = ($v['tipocampo'] == 'selectArray') ? $v['tipocampo'] : '';
            } else {
                if (strpos($v['value'], 'model.') !== FALSE) {
                    $criterios[$k] = array();
                    $model = (substr($v['value'], strpos($v['value'], '.') + 1));
                    $this->loadModel($model);
                    unset($v['value'], $valueTmp);
                    //$v['value'] = $this->$model->getAll(null,null,'');
                    $tipocampo = explode('.', $v['tipocampo']);
                    if (strpos($tipocampo[1], "__") !== FALSE) {
                        $campoorder = current(explode("__", $tipocampo[1]));
                    } else {
                        $campoorder = $tipocampo[1];
                    }
                    if (isset($v['where']) && is_array($v['where'])) {
                        //$v['value'] = $this->$model->getAllByFieldsNoAssociations($v['where'], null, null, $campoorder, 'asc');
                    } else {
                        //$v['value'] = $this->$model->getAllByFieldsNoAssociations(array(), null, null, $campoorder, 'asc');
                    }
                    $valueTmp = array();
                    foreach ($v['value']['rows'] as $key => $value) {
                        if (isset($v['prefixcampo'])) {
                            $valueTmp[$value['id']] = $value[$v['prefixcampo']] . ' - ' . str_replace(",", "", $value[$tipocampo[1]]);
                        } else {
                            if (strpos($tipocampo[1], "__") !== FALSE) {
                                $valueCampo = array();
                                $valueCampoArr = explode("__", $tipocampo[1]);
                                foreach ($valueCampoArr as $vCampo) {
                                    $valueCampo[] = $value[$vCampo];
                                }
                                $valueTmp[$value['id']] = str_replace(",", "", implode(" - ", $valueCampo));
                            } else {
                                $valueTmp[$value['id']] = str_replace(",", "", $value[$tipocampo[1]]);
                            }
                        }
                    }

                    $criterios[$k]['value'] = (isset($valueTmp)) ? $valueTmp : '';
                    $criterios[$k]['campo'] = $tipocampo[0];
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'model';
                } elseif (strpos($v['value'], 'enum.') !== FALSE) {
                    $criterios[$k] = array();
                    $campo = strtolower(substr($v['value'], strpos($v['value'], '.') + 1));
                    $v['value'] = show_enum_values($this->_defaultModel->getTable(), $campo);
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = 'select';
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'enum';
                } elseif (strpos($v['value'], 'enum2.') !== FALSE) {
                    $criterios[$k] = array();
                    $campo = explode('.', $v['value']);
                    //$campo = strtolower(substr($v['value'],strpos($v['value'],'.')+1));
                    $v['value'] = show_enum_values($campo[1], $campo[2]);
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = 'select';
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = 'enum';
                } else {
                    $criterios[$k] = array();
                    $criterios[$k]['value'] = $v['value'];
                    $criterios[$k]['campo'] = $v['tipocampo'];
                    $criterios[$k]['regras'] = $v['regras'];
                    $criterios[$k]['field'] = $v['field'];
                    $criterios[$k]['tipo'] = '';
                }
            }
        }
        $this->setData('criterios', $criterios);
    }

    public function setWhere() {
        $where = array();

        foreach ($this->_setWhrNoSearch as $k => $v) {
            $_REQUEST['search'][$k] = $v;
        }
        if (!isset($_REQUEST['search'])) {
            return false;
        }
        //debug($_POST['search']);
        foreach ($_REQUEST['search'] as $attr => $value) {
            if ((is_array($value) && count($value) == 0) || (!is_array($value) && !is_null($value) && trim($value) == ''))
                continue;

            $logic = '';
            if (preg_match("/AND|OR/", $attr, $res)) {
                $attr = trim(str_replace($res[0], '', $attr));
                $logic = $res[0];
            }

            if ($logic == '') {
                $logic = 'AND';
            }

            if (preg_match("/[a-zA-Z0-9\_w ]+/", $attr, $res)) {
                $field = current(explode(" ", $res[0]));
            }

            //debug($field);

            $operation = ' = ';
            if (preg_match("/[!=<>]+|LIKE|NOT LIKE|NOT IN|IN|REGEXP|NOT REGEXP/", $attr, $res))
                $operation = ' ' . $res[0] . ' ';
            else if (preg_match("/IS NOT|IS/", $attr, $res))
                $operation = ' ' . $res[0] . ' ';

            $open = preg_match("/[\(]+/", $attr, $res) ? $res[0] . ' ' : '';

            $close = preg_match("/[\)]+/", $attr, $res) ? ' ' . $res[0] : '';

            if (is_array($value)) {

                foreach ($value as $k => &$v) {

                    if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})\ ([0-9]{2}\:[0-9]{2})/", $v, $res)) {
                        echo '1';
                        $v = $res[3] . '-' . $res[2] . '-' . $res[1] . ' ' . $res[4] . ':00';
                    } elseif (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $v, $res)) {
                        $extra = '';

                        if (trim($operation) == '>=')
                            $extra = ' 00:00:00';
                        elseif (trim($operation) == '<=')
                            $extra = ' 23:59:59';

                        $v = $res[3] . '-' . $res[2] . '-' . $res[1] . $extra;
                    }
                    $v = $this->db->escape(trim($v));
                }

                if (count($value) > 1) {
                    if (strpos($operation, "LIKE") !== FALSE) {
                        $operation = " REGEXP ";
                        foreach ($value as $k1 => $v1) {
                            $v1 = str_replace("'", "", $v1);
                            $value[$k1] = "(^{$v1}|.{$v1})";
                        }
                        $value = "'" . implode('|', $value) . "'";
                    } else {
                        if ($operation == ' <> ') {
                            if (strpos($operation, "NOT IN") === FALSE) {
                                $operation = " NOT IN ";
                            }
                        } else {
                            if (strpos($operation, "IN") === FALSE) {
                                $operation = " IN ";
                            }
                        }
                        $value = '(' . implode(',', $value) . ')';
                    }
                } else {

                    $value = '(' . implode(',', $value) . ')';
                    if ($operation == ' LIKE ') {
                        $value = str_replace("('", "'%", $value);
                        $value = str_replace("')", "%'", $value);
                    }
                }
            } elseif (is_null($value)) {
                $value = 'NULL';
            } else {
                if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})\ ([0-9]{2}\:[0-9]{2})/", $value, $res)) {
                    $value = $res[3] . '-' . $res[2] . '-' . $res[1] . ' ' . $res[4] . ':00';
                } elseif (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $value, $res)) {
                    $extra = '';

                    if (trim($operation) == '>=')
                        $extra = ' 00:00:00';
                    elseif (trim($operation) == '<=')
                        $extra = ' 23:59:59';

                    $value = $res[3] . '-' . $res[2] . '-' . $res[1] . $extra;
                }

                $value = (trim($operation) == 'LIKE' OR trim($operation) == 'NOT LIKE') ? $this->db->escape('%' . trim($value) . '%') : $this->db->escape(trim($value));
            }



            $where[] = $open . $logic . ' ' . $field . $operation . $value . $close;
        }
        //debug($where);
        $where = implode(" ", $where);
        foreach ($this->_setWhrNoSearch as $k => $v) {
            unset($_REQUEST['search'][$k]);
        }

        return "1=1 {$where}";
    }

    public function form($idRegistro = null) {
        if ($idRegistro) {
            $modelName = $this->_defaultModel;
            $model = new $modelName($idRegistro, false, $this->_modAssoc);
            $this->setData('row', $model);
            $this->setData('idRegistro', $idRegistro);
            $this->setData('idForm', $this->router->fetch_class() . '_editForm_' . $idRegistro);
        } else {
            $this->setData('idRegistro', '');
            $this->setData('idForm', $this->router->fetch_class() . '_newForm');
        }

        $this->setData('camposForm', $this->_camposForm);
        $this->setData('contentView', 'form');
        if (!empty($this->_gerenciaCategoria))
            $this->setGereciamentoCategoriaModulo();
        parent::index();
        //$this->load->view($this->getView('form'), $this->_data);
    }

    public function save($id = null) {
        if (isset($_POST[$this->_defaultModel]['pk'])) {
            $id = $_POST[$this->_defaultModel]['pk'];
        }
        $obj = new $this->_defaultModel($id);
        $obj->setFieldsPost($obj, $_POST[$this->_defaultModel]);
        $obj->save();
        $_SESSION['msgSistema'][] = array('tipo' => 'correto', 'tipo_label' => 'SUCESSO', 'texto' => 'Registro salvo com sucesso');

        if (isset($_POST['redirect'])) {
            redirect($_POST['redirect']);
        } else {
            if ($id)
                redirect('adm/' . getController() . '/form/' . $id);
            else
                redirect('adm/' . getController());
        }
    }

    public function delete($id) {
        $obj = new $this->_defaultModel($id);
        $obj->setDeleted(1);
        $obj->save();
        $_SESSION['msgSistema'][] = array('tipo' => 'correto', 'tipo_label' => 'SUCESSO', 'texto' => 'Registro excluído com sucesso');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getJson($id) {
        $obj = new $this->_defaultModel($id);
        $this->fieldsToArray($obj);
    }

    public function fieldsToArray($obj) {
        debug($obj->_fields);
    }

    public function setOrdenarGrid() {
        $obj = new $this->_defaultModel();
        $r = false;
        foreach ($obj->getListFields() as $k => $v) {
            if ($v == 'ordem') {
                $r = true;
            }
        }
        return $r;
    }

    private function setCamposGrid() {
        $obj = new $this->_defaultModel();
        foreach ($obj->getFullListFields() as $key => $value) {
            $v = $value['name'];
            if (!in_array($v, array('deleted', strtolower($this->_defaultModel . '_id'))))
                $this->_camposGrid[$v] = array('label' => ucfirst($v), 'align' => 'left', 'visible' => 1, 'width' => 'auto');
        }
    }

    public function getFieldsModel() {
        $obj = new $this->_defaultModel();
        $fields = array();
        $fieldsOut = array('deleted', $obj->_pk);
        foreach ($obj->getFullListFields() as $k => $v) {
            if (!in_array($v['name'], $fieldsOut))
                $fields[] = $v['name'];
        }
        return $fields;
    }

    private function setCamposForm() {
        $obj = new $this->_defaultModel();
        foreach ($obj->getFullListFields() as $k => $v) {

            if (!in_array($v['name'], array('deleted', strtolower($obj->_table . '_id')))) {
                if ($v['type'] == 'enum') {
                    $values = show_enum_values($obj->_table, $v['name'], "Selecione");
                    $this->_camposForm[$v['name']] = array('label' => ucfirst($v['name']), 'visible' => 1, 'width' => 'auto', 'width_label' => '100px', 'type' => 'select', 'class' => array('required'), 'mask' => '', 'values' => $values);
                } else {
                    if (strpos($v['name'], '_id') !== FALSE) {
                        $className = convertClassName($v['name']);
                        $values = getAllByClass($className);
                        if ($values) {
                            $values = array_to_select($values, 'Id', 'Nome', 'Selecione');
                            $this->_camposForm[$v['name']] = array('label' => ucfirst($v['name']), 'visible' => 1, 'width' => 'auto', 'width_label' => '100px', 'type' => 'select', 'class' => array('required'), 'mask' => '', 'values' => $values);
                        } else {
                            $this->_camposForm[$v['name']] = array('label' => ucfirst($v['name']), 'visible' => 1, 'width' => 'auto', 'width_label' => '100px', 'type' => 'input', 'class' => array('required'), 'mask' => '');
                        }
                    } else {
                        $this->_camposForm[$v['name']] = array('label' => ucfirst($v['name']), 'visible' => 1, 'width' => 'auto', 'width_label' => '100px', 'type' => 'input', 'class' => array('required'), 'mask' => '');
                    }
                }
            }
        }
    }

    public function getField($campo) {
        $campo = explode('_', $campo);
        foreach ($campo as $v) {
            $partCampo[] = ucfirst($v);
        }
        return 'get' . implode('', $partCampo);
    }

    public function getForm($row = null) {

        foreach ($this->_camposForm as $key => $value) {
            if (isset($value['visible']) && $value['visible'] == 1) {
                $valueField = (isset($row) ? $row->{$this->getField($key)}() : '');
                if (isset($value['func'])) {
                    $valueField = call_user_func($value['func'], $valueField);
                }
                $htmlCampo = '';
                if ($value['type'] == 'input') {
                    $campo = form_input($this->_defaultModel . '[' . $key . ']', $valueField, 'class="' . implode(' ', $value['class']) . '" alt="' . $value['mask'] . '"');
                } elseif ($value['type'] == 'upload') {
                    $campo = form_upload($this->_defaultModel . '[' . $key . ']', '', 'class="formEdit ' . implode(' ', $value['class']) . '" alt="' . $value['mask'] . '"  style="width:' . (isset($value['width']) ? $value['width'] : 'auto') . '"');
                } elseif ($value['type'] == 'select') {
                    $campo = form_dropdown($this->_defaultModel . '[' . $key . ']', $value['values'], $valueField, 'class="chzn-select ' . implode(' ', $value['class']) . '"  data-placeholder="Selecione" style="width:350px;"');
                } elseif ($value['type'] == 'textarea') {
                    $campo = form_textarea($this->_defaultModel . '[' . $key . ']', $valueField, 'class="formEdit ' . implode(' ', $value['class']) . '" alt="' . $value['mask'] . '"  style="width:' . (isset($value['width']) ? $value['width'] : 'auto') . ';height:' . (isset($value['height']) ? $value['height'] : 'auto') . '"');
                } else {
                    $campo = form_input($this->_defaultModel . '[' . $key . ']', $valueField, 'class="' . implode(' ', $value['class']) . '" alt="' . $value['mask'] . '" style=""');
                }
                //'.(($value['type']=='select')?'searchDrop':'').'
                $htmlCampo .= '
                    <div class="rowElem">
                    <label>' . $value['label'] . ':</label>
                    <div class="formRight '.(($value['type']=='select')?'searchDrop':'').'">' . $campo . '</div>
                    <div class="fix"></div>
                </div>';
                $html[] = $htmlCampo;
            }

            if (isset($value['type']) && strpos($value['type'], 'include:') !== FALSE) {
                $path = 'adm/' . ($this->router->fetch_class()) . '/include/' . end(explode(':', $value['type']));
                ob_start();
                $this->load->view($path);
                $ob_retorno = ob_get_contents();
                ob_end_clean();
                $html[] = $ob_retorno;
            }
        }

        echo implode('', $html);
    }

    public function applyConfGrid($arrField, $arrConf) {
        foreach ($arrField as $k => $v) {
            foreach ($arrConf as $key => $value) {
                foreach ($value as $chave => $valor) {
                    $this->_camposGrid[$v][$chave] = $valor;
                }
            }
        }
    }

    public function applyOrderGrid($campos) {
        $campos = explode(',', $campos);
        foreach ($this->_camposGrid as $k => $v) {
            if (!in_array($k, $campos)) {
                $this->_camposGrid[$k]['visible'] = 0;
            }
        }
        $novaOrdem = array();
        foreach ($campos as $k) {
            $novaOrdem[$k] = $this->_camposGrid[$k];
        }
        $this->_camposGrid = $novaOrdem;
        //debug($campos,1);
    }

    public function applyOrderForm($campos) {
        $campos = explode(',', $campos);
        foreach ($this->_camposForm as $k => $v) {
            if (!in_array($k, $campos)) {
                $this->_camposForm[$k]['visible'] = 0;
            }
        }
        $novaOrdem = array();
        foreach ($campos as $k) {
            $novaOrdem[$k] = $this->_camposForm[$k];
        }
        $this->_camposForm = $novaOrdem;
        //debug($campos,1);
    }

    public function applyConfForm($arrField, $arrConf) {
        foreach ($arrField as $k => $v) {
            foreach ($arrConf as $key => $value) {
                foreach ($value as $chave => $valor) {
                    $this->_camposForm[$v][$chave] = $valor;
                }
            }
        }
    }

}