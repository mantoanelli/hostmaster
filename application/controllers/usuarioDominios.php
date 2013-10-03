<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuarioDominios extends CI_GenericController {

    public function __construct() {
        parent::__construct();

    }

    public function gravaNovaSenhaCpanel(){
        if(isset($_POST['user'])){
            debug('a');
        }
    }

}