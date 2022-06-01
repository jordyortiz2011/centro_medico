<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');
        $this->is_logged_in();
        $this->require_min_level(1);
    }
  
    public function index()
    {        
       redirect()  ;      
    }
	
	 
 // --------------------------------------------------------------
    /**
     * Muestar el formulario para editar 
	 * para realizar la edición
     * @param  $id_registro (al final de la url) 
	 * @return (vista) , formulario
     */   	 
	 
	  public function form_editar($id_registro = null){
        
        if(  $this->auth_role == 'admin' )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('sistema/pag_inicio/portada/listar/listar_portadas');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('sistema/pag_inicio/portada/Model_editar');
             $portada  = $this->Model_editar->obtener_portada($id_registro);
			 
			 //si no existe ningún registro con el id , redireccionar al listar
			 if($portada == NULL)
                 redirect('sistema/pag_inicio/portada/listar/listar_portadas');
			 
			// print_r($portada); exit;
			
			 //Datos de la portada
             $id_tipo_porta = $portada->tipo_porta;


			 // =============================================================================
             //CREAR SELECT DE TIPO DE PORTADA (IMAGEN O TEXTO)
                $lst_tipo = array(
                    1 => 'Imagen',
                    2 => 'Texto'
                );
            
             //string del select customizado 
             $dropdown_tipo = form_dropdown('select_tipo_portada', $lst_tipo, $id_tipo_porta,"disabled class='select2 form-control form-control-lg' id='select_tipo_portada' " );
			
		     // =============================================================================
        
        
			 $data = array (
			 				 'portada'		    	=> $portada,
			 				 'select_tipo_portada'	=> $dropdown_tipo
			 				 
			 				); 
                      
             $this->load->view('sistema/pag_inicio/portada/vista_editar',$data)  ;
                            
              
        }
        
    }
	
	   // --------------------------------------------------------------
    /**
     * procesa el formulario de la edicion de paquetes 
     * @param  (post) valores del formulario
	 * @return  (vista) si la actualización es correcta , retorna al listado de paquetes
     */     
    public function procesa_editar()
    {
		        
        if(  $this->auth_role == 'admin' )
        {
             $post =  $this->input->post(); 		
			//print_r($post);  exit;
			
                   
             $this->mi_validacion_editar($post);
			
			//comprobar si el formulario es valido
			if( $this->form_validation->run() == FALSE )
            {
               //regresa al formulario de actualizar                                        
               $this->form_editar($post['hidd_id_empleado']); 
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar: al registro $post[hidd_id_empleado]";exit;            	
            	$id_empleado	= $post['hidd_id_empleado'];
				
				 //obtener los datos del registro
	         	 $this->load->model('gestores/empleados/Model_editar');
	             $empleado  = $this->Model_editar->obtener_empleado($id_empleado);  
				
				//para elcheckbox            	
            	 $post['checkbox_estado'] = isset($post['checkbox_estado']) ? 1 : 0 ;				 
				 //para FECHA DE INICIO            	
            	 $post['txt_fecha_inicio'] = $post['txt_fecha_inicio'] = '' ? NULL : $post['txt_fecha_inicio'] ;
            	
				//nombre de la foto, (si se subió nueva foto, actualizar el nombre)
				$nombre_foto = $this->session->flashdata('nombre_foto');
				$post['nombre_foto']  = empty($nombre_foto)  ?  $empleado->foto_emplea : $nombre_foto ;								
				
				
				//actualizar en la BD
            	$this->load->model('gestores/empleados/Model_editar');
				$res  = $this->Model_editar->editar_empleado($id_empleado, $post);	
				
				
							
				//comprobar si se guardó exitosamente el registro
				if ( $res == TRUE  )	{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                				
	            		
					//redirección de acuerdo al boton
					if($post['btn_subir'] == 'listar') 
            			 redirect('gestores/empleados/listar/listar_empleados', 'refresh');  
						
				}
				else{
					 //datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                	 redirect('gestores/empleados/listar/listar_empleados', 'refresh'); 					
				}					
				
            	
            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');
		
		//para no realizar comprobación del nombre del colegio si no se cambió el nombre del colegio
		$id_registro	= $post['hidd_id_empleado'];
        $this->load->model('gestores/empleados/Model_editar');
		$empleado  = $this->Model_editar->obtener_empleado($id_registro);  		
	
		
		//=== comprueba si el DNI  ya existe, ( en caso se cambia cambiado) ==
		if($empleado->dni_emplea != $post['txt_dni']) 
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_dni', 'DNI', 'required|trim|min_length[8]|max_length[8]|is_unique[tbl_empleados.dni_emplea]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('txt_dni', 'DNI', 'required|trim|min_length[8]|max_length[8]' );
		}

		 // ==== para el Nombres =====
       $this->form_validation->set_rules('txt_nombres', 'Nombres', 'required|trim|min_length[2]|max_length[100]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);        
		
		  // ==== para Apellido Paterno  =====
       $this->form_validation->set_rules('txt_apellido_pat', 'Apellido Paterno', 'required|trim|min_length[2]|max_length[50]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
										
		  // ==== para Apellido Materno  =====
       $this->form_validation->set_rules('txt_apellido_mat', 'Apellido Materno', 'required|trim|min_length[2]|max_length[50]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);	
		 // ==== para Fecha de nacimiento  =====
        $this->form_validation->set_rules('txt_fecha_naci', 'Fecha de Nacimiento', 'required|trim|callback_validacion_fecha' , 
										 //mensajes personalizados de cada regla de validación
										 array(										              
									              'validacion_fecha'     => ' <b> %s </b> no valida'
									           )
										); 							
		
		
		 // ==== para SEXO =====
        $this->form_validation->set_rules('radio_sexo', 'Sexo', 'required|trim|in_list[H,M]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              'in_list' => 'Opción <b> %s </b> no válida'
									           )
										);
		
		//=== comprueba si el Correo  ya existe, ( en caso se cambia cambiado) ==
		if($empleado->correo_emplea != $post['txt_correo']) 
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_correo', 'Correo', 'required|trim|valid_email|is_unique[tbl_empleados.correo_emplea]|max_length[100]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('txt_correo', 'Correo', 'required|trim|valid_email|max_length[100]' );
		}
		
			 // ==== para el Telefono =====
       $this->form_validation->set_rules('txt_telefono', 'Telefono', 'trim|is_natural|min_length[6]|max_length[6]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		
		 // ==== para el Celular =====
       $this->form_validation->set_rules('txt_celular', 'Celular', 'trim|is_natural|min_length[9]|max_length[9]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		
		 // ==== para Dirección =====
       $this->form_validation->set_rules('txt_direccion', 'Dirección', 'trim|max_length[250]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);	
		
		 //===== para el tipo de Empleado ===========
         // obtener listado de tipo de unidades
		$this->load->model('reutilizables/Model_empleados');
        $lst_emplea_tipo = $this->Model_empleados->listado_empleados_tipos();
		
		$string_tipo = '';
		foreach ($lst_emplea_tipo as $tipo_emplea) {
			$string_tipo .= $tipo_emplea->id_emplea_tipo . ',';
		}		
		$string_tipo = trim($string_tipo, ',');	 		
    	$this->form_validation->set_rules('select_tipo_emplea', 'Tipo de Empleado', 'required|in_list[' . $string_tipo. ']') ;   
        
		
		// ==== para Fecha de Inicio =====
        $this->form_validation->set_rules('txt_fecha_inicio', 'Fecha de Inicio', 'trim|callback_validacion_fecha' , 
										 //mensajes personalizados de cada regla de validación
										 array(										              
									              'validacion_fecha'     => ' <b> %s </b> no valida'
									           )
										); 
										
										
			 // ==== para validación de foto =====
		$dni = $this->input->post('txt_dni'); //para concatenar al nombre de la foto
        $this->form_validation->set_rules('foto_empleado', 'Foto Empleado', 'callback_do_upload[' . $dni. ']' ); 												
		
	}


	//comprueba si el texto es una fecha válida con formato YYYY-MM-DD
	public function validacion_fecha($fecha){	 
   //print_r(var_dump($str));exit;	 
    if($fecha == ''){
    	return true;
    }
   
 	$array_fecha = explode('-' ,  $fecha) ;			
	$anyo = $array_fecha[0];	
	$mes = $array_fecha[1];
	$dia = $array_fecha[2];
		
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
	
	 //Subir foto (usado al registrar, cuando se sube la foto)
  	public function do_upload($archivo , $dni)
    {
		if( (isset($_FILES['foto_empleado']))  && $_FILES['foto_empleado']['name']) 
		{
            $config['upload_path']       = './public/img/fotos_empleados/original';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 2024; //2024 KB
            $config['max_width']        = 1024;
            $config['max_height']       = 768;
			$config['overwrite']        = true; //sobreescritura

			//concatenar_cod_universitario + time
			$time = time();
			$config['file_name']  		= $dni. "_" . $time ; //nombre de la foto, eje: 7212121_2105245.jpg
			
			//print_r($config); 



            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('foto_empleado'))
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
				$config['source_image'] = './public/img/fotos_empleados/original/' . $nombre_imagen_full ;  
				$config['new_image'] = './public/img/fotos_empleados/'; //ruta de la nueva imagen redimencionada
				//$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 230;
				$config['height']       = 302;
				$config['quality']       = 50;

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
					unlink( FCPATH . "/public/img/fotos_empleados/original/" . $nombre_imagen_full );						
					//return $nombre_imagen_full;
					//Guardar nombre de foto, en variable de sesión, flash
					$this->session->set_flashdata('nombre_foto', $nombre_imagen_full);
					return TRUE;
					
				}

                //$data = array('upload_data' => $this->upload->data());
				//$this->load->view('z_pruebas/formulario_subir_foto_correcto', $data);

            }

		}//fin comprobación IF se subió foto
		else 
		{
			//No se subió ninguna foto, (establecer, dejar con la foto anterior)
			//$this->session->set_flashdata('nombre_foto', 'empleado_defecto.png');
			return TRUE;
		}

    }//fin función upload

    
    
}
