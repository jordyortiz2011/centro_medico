<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //nivel 1 requerido para acceder
         
         $this->load->helper('form');
        
    }
	
	public function index(){
		redirect();
	}
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro
     * @param  -_-  
     */   
    public function form_registrar()
    {
        
         // Method should not be directly accessible                      
         if( $this->verify_role('admin') )
        {
			                                    
            $this->load->view('gestores/especialidades/vista_registrar' );
        }
  
    }
	
	
	   /**
     * Obtiene los datos del formulario Modulo Anuncio/Nuevo, los procesa, 
     * valida, y los manda al modelo, para guardar en la BD
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de usuarios)   
     */       
    public function procesa()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin'    )
        {
            $post = $this->input->post(); 		
			//print_r($post)         ; exit;
           
            //establecer reglas de validacion:           
            $this->validacion_reglas();        
          
            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {                                          
               //$this->load->view('formulario/vista_formulario');
			  $this->form_registrar();
			    
            }
            else {				
				
				//guardar en la BD
				$this->load->model('gestores/especialidades/Model_registrar');
                $result =  $this->Model_registrar->guardar_especialidad($post);
                
                 if ($result == true ) {

                     //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                     $this->session->set_flashdata('estado_registro', 'registrado');
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('gestores/especialidades/registrar/form_registrar', 'refresh');
						else if($post['btn_subir'] == 'listar') 
							redirect('gestores/especialidades/listar/listar_especialidades', 'refresh');
						else
	            			redirect('gestores/especialidades/listar/listar_especialidades', 'refresh');
                    
                                     
                 }else {
                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                    $this->session->set_flashdata('registro_error', true);
                        redirect('gestores/especialidades/listar/listar_especialidades', 'refresh');
                 }                 
                
                                
            }//fin de form_validation->run()
        
        }
    
    }


     /**
     * Reglas de validacion para formulario        
     */       
    private function validacion_reglas () 
    {               
        //carga la libreria para validar formulario               
        $this->load->library('form_validation');
		$this->config->set_item('language', 'spanish'); 
        
         // ==== para el nombre de especialidad =====
        $this->form_validation->set_rules('text_nombre', 'Nombre de especialidad', 'required|trim|min_length[3]|max_length[100]|is_unique[tbl_especialidades.nombre_espe]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);

        // ==== para el color =====
        $this->form_validation->set_rules('text_color', 'Color', 'required|trim|is_unique[tbl_especialidades.color_espe]|callback_validacion_regla_color' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'     => 'Este <b> %s </b> ya existe.',
                'validacion_regla_color'     => '<b> %s </b> no valido'
            )

        );


        // ==== para la descripción  =====
        $this->form_validation->set_rules('text_descripcion', 'Descripcion', 'trim|max_length[200]');

    }

    public function validacion_regla_color($str)
    {
        $estado = (bool)preg_match("/#[a-fA-F0-9]{6}/", $str);
        //var_dump($estado);exit;
        if (!$estado)    {
            //$this->form_validation->set_message('Color', 'Color No valido');
            return FALSE;
        } else{
            return TRUE;
        }
    }
	
	
	

 
    
    
}
