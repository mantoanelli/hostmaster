<?php
class Mailing extends CI_GenericModel {

    public $_table = "mailing";
    public $_pk = "mailing_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }

}
