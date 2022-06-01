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
         if( $this->verify_role('admin') )
        {
            // ====== CREAR SELECT DE CONSULTORIOS ===========
            $this->load->helper('form');
            $this->load->model('reutilizables/Model_consultorios');
            $lst_consultorios = $this->Model_consultorios->listado_consultorios();

            $array_consultorios  = array(); //array que tendrá los registros
            $array_consultorios[''] = 'Seleccione';
            //para que cree el array de id y nombre del select = consultorios
            foreach ($lst_consultorios as $consultorio) {
                $array_consultorios[$consultorio->id_consultorio] = $consultorio->nombre_consul;
            }

            //string del select customizado
            $dropdown_consultorios = form_dropdown('select_consultorios', $array_consultorios, '',"class='select2 form-control ' id='select_consultorios' " );

            // ====== CREAR SELECT DE PROFESIONALES DE LA SALUD ===========
            $this->load->helper('form');
            $this->load->model('reutilizables/Model_profesionales');
            $lst_profesionales = $this->Model_profesionales->listado_profesionales(); //7 = Sólo profesionales de la salud
            //print_r($lst_profesores); exit;

            $array_profesionales  = array(); //array que tendrá los registros
            $array_profesionales[''] = 'Seleccione';
            //para que cree el array de id y nombre del select = unidades de medida
            foreach ($lst_profesionales as $profesional) {
                $array_profesionales[$profesional->user_id] = $profesional->apellido_pat_user. ' ' . $profesional->apellido_mat_user. ', ' . $profesional->nombres_user  ;
            }
            //var_dump($array_profesores); exit;

            //string del select customizado
            $dropdown_profesionales = form_dropdown("select_profesionales", $array_profesionales, '','class="select2 form-control " id="select_profesionales" ' );


            $data =
                array(
                    'select_consultorios'     => $dropdown_consultorios, //Todos los datos correspondientes al último ciclo

                    //para modal
                    'select_profesionales'     => $dropdown_profesionales,


                    );

        	 //obtener tipo de colegios			                                    
            $this->load->view('gestores/horarios/vista_registrar', $data );
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
        if(  $this->auth_role == 'admin' ||   $this->auth_role == 'cajero'  )
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
				$this->load->model('gestores/colegios/Model_registrar');
                $result =  $this->Model_registrar->guardar_colegio($post);              
                
                 if ($result == true ) {
                    
                     	 //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
	                    $this->session->set_flashdata('registro_correcto', true);
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('gestores/colegios/registrar/form_registrar', 'refresh');
						else if($post['btn_subir'] == 'ListarRecibos')
							redirect('gestores/colegios/listar/listar_colegios', 'refresh');
						else
	            			redirect('gestores/colegios/listar/listar_colegios', 'refresh');  
                    
                                     
                 }else {
                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                    $this->session->set_flashdata('registro_error', true);
	            		redirect('membresias/agregar/formulario', 'refresh'); 
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
        $this->form_validation->set_rules('txt_nombre', 'Colegio', 'required|trim|min_length[3]|max_length[200]|is_unique[tbl_colegios.nombre_cole]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
        
         //===== para el tipo de colegio ======
         // obtener listado de tipo de colegios 
			$this->load->model('reutilizables/Model_colegios');
            $lst_cole_tipos = $this->Model_colegios->listado_colegio_tipos();
			
		
			
			$string_tipo = '';
			foreach ($lst_cole_tipos as $tipo_cole) {
				$string_tipo .= $tipo_cole->id_cole_tipo . ',';
			}		
			$string_tipo = trim($string_tipo, ',');	 		
			
			
        	 $this->form_validation->set_rules('select_cole_tipo', 'Tipo de colegio', 'required|in_list[' . $string_tipo. ']');		
		
		
	
      
        
    }
	
	
	

 
    
    
}
