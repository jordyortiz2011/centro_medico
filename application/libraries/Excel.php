<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// echo APPPATH."third_party".DS."PHPExcel.php";
require_once APPPATH."third_party/PHPExcel.php";

class Excel extends PHPExcel {
	
    public function __construct() {
        parent::__construct();
    }
}