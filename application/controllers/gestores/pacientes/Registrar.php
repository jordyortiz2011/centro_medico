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
     * muestra formulario para registro colegio    
     * @param  -_-  
     */   
    public function form_registrar()
    {
        
         // Method should not be directly accessible                      
         if( $this->auth_level == 9 || $this->auth_level == 5   )
        {

            $this->load->model('reutilizables/Model_codigos_renaes');
            $lst_establecimientos =  $this->Model_codigos_renaes->listado_codigos();

            //print_r($lst_codigos); exit;
			
			$data = array(
							'lst_establecimientos' =>  $lst_establecimientos
						 );			
                       
            $this->load->view('gestores/pacientes/vista_registrar', $data);
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
        if(  $this->auth_level == 9  || $this->auth_level == 5   )
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
				//print_r($post); exit;

                //para checkbox posee sis
                if( isset($post['checkbox_posee_sis'])  ) {
                    $post['checkbox_posee_sis'] = 1;
                }else {
                    $post['checkbox_posee_sis'] = 0;
                }

                //EN CASO NO POSEA SIS
                if($post['checkbox_posee_sis'] == 0) {
                    $post['text_id_sis'] = NULL;
                }

                if($post['checkbox_posee_sis'] == 0) {
                    $post['select_estado'] = NULL;
                }


                //Fecha Nacimiento
                $fecha_emision = explode('/' ,  $post['text_fecha_naci']) ;
                $dia = $fecha_emision[0];
                $mes = $fecha_emision[1];
                $anyo = $fecha_emision[2];
                $post['text_fecha_naci'] = $anyo . '-' . $mes . '-'  . $dia ;

                //Fecha Afiliación
                if( $post['text_fecha_afiliacion'] != ''  ) {
                    $fecha_emision = explode('/' ,  $post['text_fecha_afiliacion']) ;
                    $dia = $fecha_emision[0];
                    $mes = $fecha_emision[1];
                    $anyo = $fecha_emision[2];
                    $post['text_fecha_afiliacion'] = $anyo . '-' . $mes . '-'  . $dia ;
                }
                else{
                    $post['text_fecha_afiliacion'] = NULL;
                }


                //Fecha Baja
                if( $post['text_fecha_baja'] != '' ) {
                $fecha_emision = explode('/' ,  $post['text_fecha_baja']) ;
                $dia = $fecha_emision[0];
                $mes = $fecha_emision[1];
                $anyo = $fecha_emision[2];
                $post['text_fecha_baja'] = $anyo . '-' . $mes . '-'  . $dia ;
                }
                else{
                    $post['text_fecha_baja'] = NULL;
                }


                //guardar en la BD
				$this->load->model('gestores/pacientes/Model_registrar');
                $result =  $this->Model_registrar->guardar_paciente($post);

                if ($result == true ) {

                    //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                    $this->session->set_flashdata('estado_registro', 'registrado');

                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'permanecer')
                        redirect('gestores/pacientes/registrar/form_registrar', 'refresh');
                    else if($post['btn_subir'] == 'listar')
                        redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
                    else
                        redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');


                }else {

                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar
                    $this->session->set_flashdata('registro_error', true);
                    redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
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
		
		// ==== para el Tipo de documento =====
       $this->form_validation->set_rules('select_tipo_doc', 'Tipo de DOC', 'required|trim' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);		
        
         // ==== para el # de DOC =====
       $this->form_validation->set_rules('text_num_documento', '# de Documento', 'max_length[20]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
        
		
		  // ==== para nombres  =====
       $this->form_validation->set_rules('text_nombres', 'Nombres', 'required|trim|min_length[2]|max_length[250]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
										
		  // ==== para Sexo  =====
       $this->form_validation->set_rules('radio_sexo', 'Sexo', 'required|in_list[M,F]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);	
		 // ==== para Fecha de nacimiento  =====
        $this->form_validation->set_rules('text_fecha_naci', 'Fecha de Nacimiento', 'required|trim|callback_validacion_fecha' ,
										 //mensajes personalizados de cada regla de validación
										 array(										              
									              'validacion_fecha'     => ' <b> %s </b> no valida'
									           )
										); 		
		
		 // ==== para PROVINCIA =====
        $this->form_validation->set_rules('text_historial', 'Cód. Historial', 'trim|max_length[50]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              'in_list' => 'Opción <b> %s </b> no válida'
									           )
										);

	
        
    }//fin funcion validación reglas
	
	//comprueba si el texto es una fecha válida con formato YYYY-MM-DD
	public function validacion_fecha($fecha){	 
   //print_r(var_dump($str));exit;	 
    if($fecha == ''){
    	return true;
    }
   
 	$array_fecha = explode('/' ,  $fecha) ;
    $dia = $array_fecha[0];
    $mes = $array_fecha[1];
    $anyo = $array_fecha[2];


		
     $fecha_valida =  checkdate($mes, $dia, $anyo);
	 
		if (!$fecha_valida)
	    {
	            //$this->form_validation->set_message('fecha', 'La fecha  no es valida');
	            return FALSE;
	    }
	    else
	    {
	            return TRUE;
	    } 	
 	}
	
	

	

    
    
}
