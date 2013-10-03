<?php
class PlanoHost extends CI_GenericModel {

    public $_table = "plano_host";
    public $_pk = "plano_host_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
