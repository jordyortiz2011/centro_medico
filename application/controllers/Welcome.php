<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	//comprueba si la HORA DE INICIO del turno Tarde, es mayor a la HORA FIN del turno mañana
	//public function validacion_hora_inicio_tarde($hora_ini_tar, $hora_fin_man  ){
      public function validacion_hora_inicio_tarde($hora_ini_tar = '10:00', $hora_fin_man ='11:00' ){	 	 
   //print_r(var_dump($str));exit;	   
 	$hora_ini_tar = '2018-01-01 '.$hora_ini_tar . ':00';
	$hora_fin_man = '2018-01-01 '.$hora_fin_man . ':00';
 		
	$hora_ini_tar = new DateTime($hora_ini_tar);
	// $fecha_fin = $this->input->post('txt_fecha_fin'); //no se puede reutilizar
    $hora_fin_man = new DateTime($hora_fin_man);
	
	    if($hora_ini_tar >=  $hora_fin_man)	
	    {
	    	   echo  'OK: soy mayor igual'; 	           
	           return TRUE;	           
	    }
	    else
	    {		 echo  'ERROR: soy menor'; 	
	    	   //$this->form_validation->set_message('fecha', 'La fecha  inicio NO es mayor a la de fin);
	           return FALSE;
	    } 	
 	}
}
