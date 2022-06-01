<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_ajax extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }
	
	public function index(){
		redirect('');
	}
	
	
   /** =====================================================
     * Busca un empleado por su DNI, para crear su cuenta de usuario      
     * Permiso: solo administradores    
     * @param  $dni(string)(POST)
     * @return  $datos(JSON), datos personales del empleado  
     */   
  	
  	public function buscar_empleado_xDNI()
    {
     	
		
    }//fin funcion buscar_empleado_xDNI



    
}
