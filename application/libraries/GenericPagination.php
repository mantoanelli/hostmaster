<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
load_class("Pagination");
class CI_GenericPagination extends CI_Pagination{

    public function __construct(){
        parent::__construct();        
	}
}