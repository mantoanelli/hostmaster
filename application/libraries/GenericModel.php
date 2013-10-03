<?php

class CI_GenericModel {

    protected $_associations = array();
    public $_fields = array();
    protected $_associationSetted = array();

    public function __construct($id = null, $deleted = false, $assoc = null) {
        if ($id) {
            $this->_setFields();
            $this->get($id, $deleted, $assoc);
        }
    }

    public function _getClass(&$class) {
        $ret = is_object($class) ? str_replace('Model', '', get_class($class)) : $class;
        $ret = trim(strtolower(substr($ret, 0, 1)) . substr($ret, 1, strlen($ret) - 1));
        return $ret;
    }

    private function _setFields() {
        $CI = get_instance();
        $this->_setAssociations();
        $fields = $CI->db->list_fields($this->_table);
        foreach ($fields as $v) {
            $this->_fields[$v] = "";
        }
    }

    public function setFieldsPost($obj, $post) {
        $CI = get_instance();
        $fieldsArr = $CI->db->list_fields($this->_table);
        foreach ($fieldsArr as $v):
            $fields[] = $v;
        endforeach;
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

    public function _getFields() {
        return $this->_fields;
    }

    public function getListFields() {
        $CI = get_instance();
        $fields = $CI->db->list_fields($this->_table);
        return $fields;
    }

    public function getFullListFields() {
        $CI = get_instance();
        $fields = array();
        $res = $CI->db->query("SHOW COLUMNS FROM {$this->_table}");
        $rows = $res->result_array();
        foreach ($rows as $k => $v) {
            $arr['values'] = "";
            $arr['type'] = $v['Type'];
            if (strpos($arr['type'], '(') !== FALSE) {
                $arr['type'] = substr($arr['type'], 0, strpos($arr['type'], '('));
            }
            if ($arr['type'] == 'enum') {
                $enum = str_replace("enum(", "", $v['Type']);
                $enum = str_replace("'", "", $enum);
                $enum = substr($enum, 0, strlen($enum) - 1);
                $enum = explode(",", $enum);
                $enum = arrayKeysEqualValues($enum);
                $arr['values'] = $enum;
            }
            $arr['name'] = $v['Field'];
            $fields[] = $arr;
        }
        return $fields;
    }

    public function _getAssociation() {
        return $this->_associations;
    }

    public function getId() {
        return isset($this->_fields[$this->_pk]) ? $this->_fields[$this->_pk] : null;
    }

    //Forca getters e setters
    public function __call($m, $a) {
        $ver = substr($m, 0, 3);
        if ($ver == 'set' || $ver == 'get') {
            //Forma o nome do campo
            $campo = substr($m, 3, strlen($m));
            $campo = strtolower($campo{0}) . substr($campo, 1);
            $campo = strtolower(preg_replace('/([A-Z])/', '_\1', $campo));
            if ($ver == 'set') {
                $this->_fields[$campo] = $a[0];
            } else {

                return isset($this->_fields[$campo]) ? $this->_fields[$campo] : null;
            }
        }
    }

    public function get($id = null, $deleted = false, $modAssoc = null) {
        $CI = get_instance();
        $sql = "SELECT * FROM {$this->_table}  WHERE {$this->_pk} = {$id} " . ((!$deleted) ? "AND deleted = 0" : "");
        $res = $CI->db->query($sql);
        if ($res->num_rows() > 0) {
            foreach ($res->row_array() as $k => $v) {
                $this->_fields[$k] = $v;
            }
            if ($modAssoc) {
                foreach ($modAssoc as $k => $v) {
                    foreach ($v as $km => $vm) {
                        $this->_associations[$k][$km] = $vm;
                    }
                }
            }
            foreach ($this->_associations as $k => $v) {

                if ($v['type'] == '1:1') {
                    $modelAssoc = new $v['model']($this->_fields[$v['fk']]);
                    $alias = (isset($v['alias']) && $v['alias'] != '') ? $k : $modelAssoc->_table;
                    $this->_fields[$alias] = $modelAssoc;
                } elseif ($v['type'] == 'n:1') {
                    $modelAssoc = new $v['model']();
                    $alias = (isset($v['alias']) && $v['alias'] != '') ? $k : $modelAssoc->_table;
                    $whr = $v['fk'] . ' = ' . $this->_fields[$this->_pk];
                    $whr.= (isset($v['where'])) ? ' AND ' . $v['where'] : '';
                    $this->_fields[$alias] = $modelAssoc->getAll($whr, isset($v['order']) ? implode(',', $v['order']) : '');
                }
            }
        }
    }

    private function _setAssociations() {
        if (isset($this->_association)) {
            foreach ($this->_association as $k => $v) {
                $this->setAssociation($k, $v['type'], $v['model'], $v['fk'], isset($v['alias']) ? $v['alias'] : null, isset($v['order']) ? $v['order'] : null, isset($v['where']) ? $v['where'] : null);
            }
        }
        //debug($this->_associationSetted);
    }

    public function setAssociation($name, $type, $model, $fk, $alias = null, $order = null, $where = null) {
        $assoc = true;
        if (isset($this->_associationSetted[$this->_getClass($this)])) {
            if (in_array($model, $this->_associationSetted[$this->_getClass($this)])) {
                //$assoc = false;
            }
        }
        if ($assoc) {
            $this->_associationSetted[$this->_getClass($this)][] = $model;
        }
        $name = (is_numeric($name)) ? (($alias) ? $alias : $model) : $name;
        $this->_associations[$name] = array('type' => $type, 'model' => $model, 'fk' => $fk, 'alias' => $alias, 'order' => $order, 'where' => $where);
    }

    public function delete($id) {
        $CI = get_instance();
        $sql = "DELETE FROM {$this->_table} WHERE {$this->_pk} = {$id}";
        $res = $CI->db->query($sql);
    }

    public function getTotal($where = null) {
        $CI = get_instance();
        $whrAtivo = "";
        if (in_array('ativo', $this->getListFields())&& $CI->router->fetch_directory() != 'adm/') {
            $whrAtivo = " AND {$this->_table}.ativo = 1 ";
        }
        $sql = "SELECT COUNT(0) as total FROM {$this->_table}";
        if (strpos($where, 'deleted') !== FALSE) {
            $sql .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
        } else {
            $sql .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo.' AND ' . $where : ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo;
        }
        $res = $CI->db->query($sql);
        $row = $res->row_array();
        return $row['total'];
    }

    public function getSum($campo, $where = null) {
        $CI = get_instance();
        $whrAtivo = "";
        if (in_array('ativo', $this->getListFields())&& $CI->router->fetch_directory() != 'adm/') {
            $whrAtivo = " AND {$this->_table}.ativo = 1 ";
        }
        $sql = "SELECT SUM({$campo}) as soma FROM {$this->_table}";
        if (strpos($where, 'deleted') !== FALSE) {
            $sql .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
        } else {
            $sql .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo.' AND ' . $where : ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo;
        }
        $res = $CI->db->query($sql);
        $row = $res->row_array();
        return $row['soma'];
    }

    public function getAvg($campo, $where = null) {
        $CI = get_instance();
        $whrAtivo = "";
        if (in_array('ativo', $this->getListFields())&& $CI->router->fetch_directory() != 'adm/') {
            $whrAtivo = " AND {$this->_table}.ativo = 1 ";
        }
        $sql = "SELECT AVG({$campo}) as media FROM {$this->_table}";
        if (strpos($where, 'deleted') !== FALSE) {
            $sql .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
        } else {
            $sql .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo.' AND ' . $where : ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo;
        }
        $res = $CI->db->query($sql);
        $row = $res->row_array();
        return $row['media'];
    }

    public function truncate() {
        $CI = get_instance();
        $sql = "TRUNCATE table {$this->_table}";
        $CI->db->query($sql);
    }

    public function getAll($where = null, $order = null, $limit = null, $debug = false) {
        $CI = get_instance();
        $whrAtivo = "";
        if (in_array('ativo', $this->getListFields())&& $CI->router->fetch_directory() != 'adm/') {
            $whrAtivo = " AND {$this->_table}.ativo = 1 ";

        }
        $withDeleted = false;
        $sql = "SELECT $this->_pk FROM {$this->_table}";
        $sqlCount = "SELECT COUNT(0) as total FROM {$this->_table}";
        if (strpos($where, 'deleted') !== FALSE) {
            $sql .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
            $sqlCount .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
            $withDeleted = true;
        } else {
            $sql .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo.' AND ' . $where : ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo;
            $sqlCount .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo.' AND ' . $where : ' WHERE ' . $this->_table . '.deleted = 0'.$whrAtivo;
        }

        $sql .= ($order) ? ' ORDER BY ' . $order : '';
        $sql .= ($limit) ? ' ' . $limit : '';
        
        if ($debug) {
            debug($sql, 1);
        }
        $res = $CI->db->query($sql);
        $resTotal = $CI->db->query($sqlCount);
        $rowTotal = $resTotal->row_array();
        $r = array();
        $r['total'] = $rowTotal['total'];
        $r['rows'] = array();
        foreach ($res->result_array() as $k => $v) {
            $md = $this->_getClass($this);
            $r['rows'][] = new $md($v[$this->_pk]);
        }
        return $r;
    }

    public function getOne($where = null, $order = null, $limit = null) {
        $CI = get_instance();
        $whrAtivo = "";
        if (in_array('ativo', $this->getListFields())&& $CI->router->fetch_directory() != 'adm/') {
            $whrAtivo = " AND {$this->_table}.ativo = 1 ";
        }
        $withDeleted = false;
        $sql = "SELECT $this->_pk FROM {$this->_table}";
        if (strpos($where, 'deleted') !== FALSE) {
            $sql .= ($where) ? ' WHERE 1=1 AND ' . $where : '';
            $withDeleted = true;
        } else {
            $sql .= ($where) ? ' WHERE ' . $this->_table . '.deleted = 0 '.$whrAtivo.' AND ' . $where : '';
        }
        $sql .= ($order) ? ' ORDER BY ' . $order : '';
        $sql .= ($limit) ? ' ' . $limit : '';

        $res = $CI->db->query($sql);

        if ($res->num_rows() > 0) {

            $row = $res->row_array();
            //debug($row);
            $md = $this->_getClass($this);
            $r = new $md($row[$this->_pk], $withDeleted);
            //debug($r);
            return $r;
        } else {
            return false;
        }
    }

    public function save() {
        $CI = get_instance();
        if (($this->getId())) {
            $id = $this->getId();
            $fields = $this->_fields;
            $fields = $this->removeArraysObjects($fields);
            unset($fields[$this->_pk]);
            $listFields = $this->getListFields();
            if (in_array('data_modificado', $listFields)) {
                $fields['data_modificado'] = now();
            }
            $CI->db->update($this->_table, $fields, "{$this->_pk} = {$this->getId()}");
        } else {

            $listFields = $this->getListFields();
            if (in_array('data_modificado', $listFields)) {
                $this->_fields['data_modificado'] = now();
            }
            $CI->db->insert($this->_table, $this->_fields);
            $id = $CI->db->insert_id();
        }

        return $id;
    }

    public function removeArraysObjects($fields) {
        foreach ($fields as $k => $v) {
            if (is_object($v) || is_array($v)) {
                unset($fields[$k]);
            }
        }
        return $fields;
    }

    public function removeAssociation($name) {
        unset($this->_associations[$name]);
    }

    public function addAssociation($name, $params) {
        foreach ($params as $k => $v) {
            ${$k} = $v;
            //debug($k."=".${$k});
        }
        //exit();

        $this->setAssociation($name, $type, $model, $fk, ($alias) ? $alias : null, ($order) ? $order : null, ($where) ? $where : null);
    }

}