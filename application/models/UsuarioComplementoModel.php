<?php
class UsuarioComplemento extends CI_GenericModel {

    public $_table = "usuario_complemento";
    public $_pk = "usuario_complemento_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
