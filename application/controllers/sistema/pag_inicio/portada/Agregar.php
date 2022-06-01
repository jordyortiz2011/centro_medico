<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agregar extends MY_Controller {
    
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
    public function form_agregar()
    {
        
         // Method should not be directly accessible                      
         if( $this->verify_role('admin') )
        {        	
                       
            $this->load->view('sistema/pag_inicio/portada/vista_agregar');             
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
        if(  $this->verify_role('admin')   )
        {
            $post = $this->input->post(); 		
		    //print_r($post)         ; exit;
           
            //establecer reglas de validacion:           
            $this->validacion_reglas();        
          
            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {                                          
               //$this->load->view('formulario/vista_formulario');
			  $this->form_agregar();
			    
            }
            else {            				
				//print_r($post); exit;
				
				 //para elcheckbox            	
            	 $post['checkbox_estado'] = isset($post['checkbox_estado']) ? 1 : 0 ;			
				
				//nombre de la foto
				$post['nombre_foto']  = $this->session->flashdata('nombre_foto_portada');
				
				//guardar en la BD
				$this->load->model('sistema/pag_inicio/portada/Model_agregar');
                $result =  $this->Model_agregar->guardar_portada($post);              
                 
				 //registro agregado a la BD
                 if ($result != false) {						
						
						//exit;				    					
                    
                     	 //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
	                    $this->session->set_flashdata('estado_registro', 'registrado');
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('sistema/pag_inicio/portada/agregar/form_agregar', 'refresh');
						else if($post['btn_subir'] == 'listar') 
							redirect('sistema/pag_inicio/portada/listar/listar_portadas', 'refresh');
						else
	            			redirect('sistema/pag_inicio/portada/listar/listar_portadas', 'refresh'); 
                    
                                     
                 }else {
                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                    $this->session->set_flashdata('estado_registro', 'registrar_error');
	            		redirect('gestores/empleados/registrar/form_registrar', 'refresh');
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
		
				
		
		// ==== para el Tipo de Portada =====
       $this->form_validation->set_rules('select_tipo_portada', 'Tipo ', 'required|trim|in_list[1,2]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                //'in_list'     => ''
									           )
										);	
										
		// ====   Validación dinámica, de acuerto al tipo de portada ========
		$id_tipo =  $this->input->post('select_tipo_portada');								
		// 1 = tipo imagen									
        if ($id_tipo == "1" ) {
        	
			 // ==== para Titulo =====
      		 $this->form_validation->set_rules('txt_titulo', 'Títlo', 'trim|max_length[100]');
			 
			  // ==== para Descripción =====
			  $this->form_validation->set_rules('txt_descripcion', 'Descripción', 'trim|max_length[250]');
        	
			
			// ==== para Prioridad =====
        	$this->form_validation->set_rules('txt_prioridad', 'Prioridad', 'required|trim|is_natural_no_zero|less_than_equal_to[100]' , 
										 //mensajes personalizados de cada regla de validación
										 array(										              
									              'is_natural_no_zero'     => 'La <b> %s </b> debería ser un número mayor a 0'
									           )
										); 	
										
			// ==== para validación de foto =====	
        	$this->form_validation->set_rules('foto_portada', 'Foto Portada', 'callback_do_upload'  );
        	 							
        	
        }
		// 2 = tipo texto			
        else if ($id_tipo == "2" ) {
        	
			 // ==== para Titulo =====
      		 $this->form_validation->set_rules('txt_titulo', 'Títlo', 'required|trim|max_length[100]');
			 
			  // ==== para Descripción =====
			  $this->form_validation->set_rules('txt_descripcion', 'Descripción', 'trim|max_length[250]');
        	
			
			// ==== para Prioridad =====
        	$this->form_validation->set_rules('txt_prioridad', 'Prioridad', 'required|trim|is_natural_no_zero|less_than_equal_to[100]' , 
										 //mensajes personalizados de cada regla de validación
										 array(										              
									              'is_natural_no_zero'     => 'La <b> %s </b> debería ser un número mayor a 0'
									           )
										); 
			
			 // ==== para el color  de texto =====
	        $this->form_validation->set_rules('txt_color_texto', 'Color de Texto', 'required|trim|callback_validacion_regla_color' , 
											 //mensajes personalizados de cada regla de validación
										  array(   
										  		    'validacion_regla_color'     => '<b> %s </b> no valido'
									           )
										
										);
		
			// ==== para el color de fondo =====
	        $this->form_validation->set_rules('txt_color_fondo', 'Color de Fondo', 'required|trim|callback_validacion_regla_color' , 
										 //mensajes personalizados de cada regla de validación
										  array( 
												    'validacion_regla_color'     => '<b> %s </b> no valido'
									           )										
										);	
										
										
			//para la foto (definir la foto por defecto al guardar)
			$this->session->set_flashdata('nombre_foto_portada', 'portada_defecto.png');							
        }
      			
        
    }//fin funcion validación reglas
	
	
	
	
	 //Subir foto (usado al registrar, cuando se sube la foto)
  	public function do_upload($archivo)
    {
		if( (isset($_FILES['foto_portada']))  && $_FILES['foto_portada']['name']) 
		{
            $config['upload_path']       = './public/img/fotos_portada/original';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 2048; //2024 KB - "2MB aprox"
            $config['max_width']        = 2048;
            $config['max_height']       = 1500;
			$config['overwrite']        = true; //sobreescritura

			//concatenar_cod_universitario + time
			$time = time();
			$config['file_name']  		=  "portada_" . $time ; //nombre de la foto, eje: 7212121_2105245.jpg
			
			//print_r($config); 



            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('foto_portada'))
            {
            	//NO SE SUBIÓ FOTO
                $error =  $this->upload->display_errors();
				//echo $error;
                $this->form_validation->set_message('do_upload', $error);
				return FALSE;
            }
            else
            {
                //subida correcta, entonces redimensiono
                $nombre_imagen_full  =  $this->upload->data('file_name'); //nombre de la imagen subida
				//echo $nombre_imagen_full; exit;
              

				$config['image_library'] = 'gd2';
				$config['source_image'] = './public/img/fotos_portada/original/' . $nombre_imagen_full ;  
				$config['new_image'] = './public/img/fotos_portada/'; //ruta de la nueva imagen redimencionada
				//$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = false;
				$config['width']         = 1024;
				$config['height']       = 410;
				$config['quality']       = 60;

				$this->load->library('image_lib', $config);					

				if ( ! $this->image_lib->resize())
				{
						//NO SE REDIMENSIONÓ FOTO
				        $error = $this->image_lib->display_errors();
						$this->form_validation->set_message('do_upload', $error);
						return FALSE;
				} 
				else 
				{
					//echo "redimensionado correcto <br>";		
						
					//Borrar archivo original subido
					unlink( FCPATH . "/public/img/fotos_portada/original/" . $nombre_imagen_full );						
					//return $nombre_imagen_full;
					//Guardar nombre de foto, en variable de sesión, flash
					$this->session->set_flashdata('nombre_foto_portada', $nombre_imagen_full);
					return TRUE;
					
				}

                //$data = array('upload_data' => $this->upload->data());
				//$this->load->view('z_pruebas/formulario_subir_foto_correcto', $data);

            }

		}//fin comprobación IF se subió foto
		else 
		{
			//No se subió ninguna foto, (establecer, mostrar error)		
			 $this->form_validation->set_message('do_upload', 'No se subió ningúna foto');
			 return FALSE;
		}

    }//fin función upload
	
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
