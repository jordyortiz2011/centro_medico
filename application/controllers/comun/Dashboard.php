<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');

        $this->require_min_level(1);
    }
    
   
    public function index()
    {        
         // Method should not be directly accessible
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 5 || $this->auth_level == 3 )
        {               
            //vista admin
            //echo $this->auth_especialidad;

            //Obtener datos del usuario que está en el sistema
            $this->load->model('reutilizables/Model_usuarios');
            $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);
            //print_r($usuario);

            $data = array (
                            'usuario'		=> $usuario,
                            );
            
			$this->load->view('comun/vista_dashboard', $data);
       
        } 		
  
    }

  
    
        
 
    
    
}
