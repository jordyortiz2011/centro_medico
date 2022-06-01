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
			                                    
            $this->load->view('gestores/codigos_renaes/vista_registrar' );
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
				$this->load->model('gestores/codigos_renaes/Model_registrar');
                $result =  $this->Model_registrar->guardar_codigo($post);

                 if ($result == true ) {

                     //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                     $this->session->set_flashdata('estado_registro', 'registrado');
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('gestores/codigos_renaes/registrar/form_registrar', 'refresh');
						else if($post['btn_subir'] == 'listar') 
							redirect('gestores/codigos_renaes/listar/listar_codigos', 'refresh');
						else
	            			redirect('gestores/codigos_renaes/listar/listar_codigos', 'refresh');
                    
                                     
                 }else {
                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                    $this->session->set_flashdata('registro_error', true);
                        redirect('gestores/codigos_renaes/listar/listar_codigos', 'refresh');
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
        
         // ==== para el codigo =====
        $this->form_validation->set_rules('text_cod_renaes', 'Código Renaes', 'required|trim|integer|is_unique[tbl_codigos_renaes.cod_renaes_codren]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);


        // ==== para el comentario  =====
        $this->form_validation->set_rules('text_micro', 'Micro red Putumayo', 'required|trim|max_length[200]');


        // ==== para el codigo =====
        $this->form_validation->set_rules('text_cod_renaes', 'Código excel EESS', 'trim|is_unique[tbl_codigos_renaes.codexcel_codren]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );



    }
	
	
	

 
    
    
}
