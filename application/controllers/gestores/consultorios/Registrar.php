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
			                                    
            $this->load->view('gestores/consultorios/vista_registrar' );
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
				//print_r($post);exit;
				//guardar en la BD
				$this->load->model('gestores/consultorios/Model_registrar');
                $result =  $this->Model_registrar->guardar_consultorio($post);
                
                 if ($result == true ) {

                     //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                     $this->session->set_flashdata('estado_registro', 'registrado');
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('gestores/consultorios/registrar/form_registrar', 'refresh');
						else if($post['btn_subir'] == 'listar') 
							redirect('gestores/consultorios/listar/listar_consultorios', 'refresh');
						else
	            			redirect('gestores/consultorios/listar/listar_consultorios', 'refresh');
                    
                                     
                 }else {
                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                    $this->session->set_flashdata('registro_error', true);
                        redirect('gestores/consultorios/listar/listar_consultorios', 'refresh');
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
        
         // ==== para el nombre de colegio =====
        $this->form_validation->set_rules('text_nombre', 'Nombre de consultorio', 'required|trim|min_length[1]|max_length[100]|is_unique[tbl_consultorios.nombre_consul]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);

        // ==== para hora inicio =====
        $hora_fin  = $this->input->post('text_hora_fin');
        $this->form_validation->set_rules('text_hora_inicio', 'Hora INICIO', 'required|trim|callback_validacion_hora_correcta['. $hora_fin  .']',
            //mensajes personalizados de cada regla de validación
            array(
                  'validacion_hora_correcta'     => 'La hora fin debe <b>ser mayor</b> a hora inicio'
            )
        );

        // ==== para hora fin =====
        $this->form_validation->set_rules('text_hora_fin', 'Hora FIN', 'required|trim',
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );

    }


    //comprueba si la HORA DE INICIO es meno a la HORA FIN
    public function validacion_hora_correcta($hora_inicio, $hora_fin  ){
        //print_r(var_dump($str));exit;
        $fecha_inicio = '2018-01-01 '.$hora_inicio . ':00';
        $fecha_fin = '2018-01-01 '.$hora_fin . ':00';

        $fecha_inicio = new DateTime($fecha_inicio);
        // $fecha_fin = $this->input->post('txt_fecha_fin'); //no se puede reutilizar
        $fecha_fin = new DateTime($fecha_fin);

        if($fecha_fin >  $fecha_inicio)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('text_hora_inicio', 'La hora fin, debe ser mayor a hora inicio');
            return FALSE; //no pasa la valicacion
        }
    }
	
	

 
    
    
}
