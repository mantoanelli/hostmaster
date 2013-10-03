<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_FormGridController{
    
    public function __construct() {
        parent::__construct();
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class())));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class())));
        
    }

    
}