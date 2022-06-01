<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require  APPPATH . 'libraries/PHPMailer-master/src/Exception.php';
		require  APPPATH . 'libraries/PHPMailer-master/src/PHPMailer.php';
		require APPPATH . 'libraries/PHPMailer-master/src/SMTP.php';
        $mail = new PHPMailer;
        return $mail;
    }
}