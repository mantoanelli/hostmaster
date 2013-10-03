<?php
class ContatoHistorico extends CI_GenericModel {

    public $_table = "contato_historico";
    public $_pk = "contato_historico_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
