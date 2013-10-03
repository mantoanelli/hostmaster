<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletter extends CI_FormGridController {

    public function __construct() {
        parent::__construct('Mailing');

        $this->_camposForm['nome']['width'] = '300px';
        $this->_camposForm['email']['width'] = '300px';
        $this->applyOrderGrid('nome,email');
        $this->applyOrderForm('nome,email');

        //debug($this->_camposGrid,1);
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class())));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class())));
    }

    public function download() {

        $this->load->helper('xls');

        $arr[] = array('Nome', 'E-mail');
        $sql = "SELECT * FROM mailing WHERE deleted=0 ORDER BY nome";
        $res = $this->db->query($sql);
        $data['rows'] = $res->result_array();
        $registros = $data['rows'];
        if (isset($registros) && count($registros) > 0) {
            foreach ($registros as $row) {
                $arr[] = array(
                    utf8_decode($row['nome']), $row['email']
                );
            }
        }
        array_to_xls($arr, 'newsletter.xls');
    }

}
