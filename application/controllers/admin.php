<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_GenericController{
    
    public function __construct() {
        parent::__construct();
        redirect('adm/home');
    }
}