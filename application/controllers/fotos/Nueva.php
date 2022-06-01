<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nueva extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }
	
	public function index(){
		redirect('fotos/nueva/form_nueva');
	}

    // --------------------------------------------------------------
    /**
     * muestra formulario para registro
     * @param  -_-
     */
    public function form_buscar()
    {

        // Method should not be directly accessible
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4  )
        {
            // === fecha actual ===
            $hoy = new DateTime();	//fecha de hoy
            $hoy_fecha  = $hoy->format('Y-m-d H:i');

            //maximo tamaño en bytes permitido en el servidor
            $max_post_length = (int)(str_replace('M', '', ini_get('post_max_size')) * 1024 * 1024);
            $maximo_megas = round($max_post_length / (1024*1024), 2);



            $data = array(
                'hoy'		   		=> $hoy_fecha ,
                'maximo_megas'      => $maximo_megas,
                'id_solicitud'      => 2
            );

            $this->load->view('fotos/vista_buscar', $data);
        }

    }
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro
     * @param  -_-  
     */   
    public function form_nueva($id_solicitud = false)
    {
        
         // Method should not be directly accessible                      
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4  )
        {
            if($id_solicitud == false)
                redirect('fotos/seleccionar/listar_solicitudes');

            //Obtener datos de la matriz relacionado con la solicitud
            $this->load->model('reutilizables/Model_solicitudes');
            $solicitud = $this->Model_solicitudes->obtener_solicitud_xID($id_solicitud);


            if($solicitud == null)
                redirect('fotos/seleccionar/listar_solicitudes');

            //si es analista comprobar si tiene permiso para ver la solicitud de acuerdo a su agencia
            if($this->auth_level == 7 ) {
                //usuario dentro del sistema
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);

                if($solicitud->id_agencia_soli !=  $usuario->id_agencia_user)  {
                    echo $this->load->view('errors/vista_sin_acceso' ,'' , TRUE);
                    exit;
                }
            }


		    // === fecha actual ===	      
            $hoy = new DateTime();	//fecha de hoy	
            $hoy_fecha  = $hoy->format('Y-m-d H:i');

            //maximo tamaño en bytes permitido en el servidor
            $max_post_length = (int)(str_replace('M', '', ini_get('post_max_size')) * 1024 * 1024);
            $maximo_megas = round($max_post_length / (1024*1024), 2);


						  
			$data = array(								
							'hoy'		   		=> $hoy_fecha ,
                            'maximo_megas'      => $maximo_megas,
                            'solicitud'         => $solicitud
						  );
                         
            $this->load->view('fotos/vista_nueva', $data);
        }
  
    }
	

        
 
    
    
}
