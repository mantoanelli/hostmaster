<?php
class Estado extends CI_GenericModel {

    public $_table = "estado";
    public $_pk = "estado_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
