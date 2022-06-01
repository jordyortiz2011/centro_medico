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
        	//obtener tipo de usuarios
        	$lst_tipos_usuarios = config_item('levels_and_roles');	
			//print_r($lst_tipos_usuarios);exit;

            //Obtener listado de agencias
            $this->load->model('reutilizables/Model_agencias');
            $lst_agencias = $this->Model_agencias->listado_agencias();



			$data = array(
							'lst_tipos_usuarios' =>  $lst_tipos_usuarios,
                            'lst_agencias' =>  $lst_agencias,
						 );			
			
			
		
            $this->load->view('sistema/usuarios/vista_agregar', $data);             
        }
  
    }
	
	
  // --------------------------------------------------------------
    /**
     * Agregar nuevo usuario al sistema -  Sistema/usuarios -> Agregar     
     * @param  -_-  
     */   
    public function procesa()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	
			$post = $this->input->post();  			
			//print_r($post); exit;    
           
            //establecer reglas de validacion:           
            $this->validacion_reglas_usuario();
			
			
			 //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {
            	
            	$this->form_agregar(); //redireccionar al formulario     
				                                
               //$this->load->view('anuncios/vista_formulario', $data);    
            }else {
            	
			   //echo "registrar ";
			   // Load resources
			    $this->is_logged_in();
				$this->load->helper('auth');
				$this->load->model('examples/examples_model');
							
			    $user_data['passwd']     = $this->authentication->hash_passwd($post['txt_clave']);
				$user_data['user_id']    = $this->examples_model->get_unused_id();
				$user_data['created_at'] = date('Y-m-d H:i:s');
			    $user_data['auth_level'] = $post['select_tipo_usuario'];
			    $user_data['email'] 	 = $post['txt_correo'];
				//para elcheckbox Activo           	
            	$user_data['banned'] = isset($post['checkbox_estado']) ? '0' : '1' ;	
				
				//datos agregado a la librería Community Auth
				$user_data['avatar'] 	 		= $this->session->flashdata('nombre_foto_user');
				$user_data['dni_user'] 		 	= $post['txt_dni'];
				$user_data['nombres_user'] 		= $post['txt_nombres'];
				$user_data['apellido_pat_user'] = $post['txt_apellido_pat'];
				$user_data['apellido_mat_user'] = $post['txt_apellido_mat'];

                $user_data['id_agencia_user'] = $post['select_agencias'];
				
						
				// If username is not used, it must be entered into the record as NULL
				if( empty( $post['txt_username'] ) )
				{
					$user_data['username'] = NULL;
				}else {
					$user_data['username'] = $post['txt_username'];
				}
	
				$this->db->set($user_data)
					->insert(db_table('user_table'));
	
				if( $this->db->affected_rows() == 1 ){
					//usuario creado exitosamente
					
					 //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
	                    $this->session->set_flashdata('estado_registro', 'registrado');
	            		
						//redirección de acuerdo al boton
						if($post['btn_subir'] == 'permanecer') 
	            			redirect('sistema/usuarios/agregar/form_agregar', 'refresh');
						else if($post['btn_subir'] == 'listar') 
							redirect('sistema/usuarios/listar/listar_usuarios', 'refresh');
						else
	            			redirect('sistema/usuarios/listar/listar_usuarios', 'refresh');    
					
				}						
				else
				{
					echo 'Error al agregar usuario';
				}
            }
            
       }
  
    }


     /**
     * Reglas de validacion para formulario de agregar Usuario     
     */       
    private function validacion_reglas_usuario () 
    {               
        //carga la libreria para validar formulario               
        $this->load->library('form_validation');
			 //idioma actual a mensajes por defecto  de validacion 
		 $this->config->set_item('language', 'spanish'); 
		
		$this->load->helper('auth');						 //funciones de librería community_aut (db_table)
		$this->load->model('examples/validation_callables'); //validación de fortaleza de la contraseña
		
		//para el DNI
       $this->form_validation->set_rules(
								'txt_dni',
							     'DNI',
								 array(
								 	'min_length[8]',
									'max_length[8]',
									'required',
									'is_unique[' . db_table('user_table') . '.dni_user]'
								),
								array(
									'required' => '%s  es Requerido',									 
								)	 
        			       );
		
		
		
		//para los nombres
       $this->form_validation->set_rules(
								'txt_nombres',
							     'Nombres',
								 array(
									'max_length[50]',
									'required'
								),
								array(
									'required' => '%s  es Requerido',									 
								)	 
        			       );
		
		//para los apellidos Paterno
       $this->form_validation->set_rules(
								'txt_apellido_pat',
							     'Apellido Paterno',
								 array(
									'max_length[30]',
									'required'
								),
								array(
									'required' => '%s  es Requerido',									 
								)	 
        			       );
		
		//para los apellidos Materno
       $this->form_validation->set_rules(
								'txt_apellido_mat',
							     'Apellido Materno',
								 array(
									'max_length[30]',
									'required'
								),
								array(
									'required' => '%s  es Requerido',									 
								)	 
        			       );
		
		
		// === obtener listado de usuario (levels and roles) del archivo 'third_party/community_auth/congi/authentication.php' ==== 
		$lst_tipos_usuarios = config_item('levels_and_roles');
		$string_tipo = '';
		foreach ($lst_tipos_usuarios as $id => $nombre) {
			$string_tipo .= $id . ',';
		}		
		$string_tipo = trim($string_tipo, ',');		
		//echo $string_tipo;
		
	   //para el select de tipo de usuario
       $this->form_validation->set_rules(
								'select_tipo_usuario',
								'Tipo  de usuario ',
								 array(
									'required',
									'integer',
									'in_list[' . $string_tipo. ']'
									
								),
								array(
									'required' => '%s es Requerido',
									'in_list' => 'El tipo de usuario debería ser válido'									 
								)	 
        			       );
		
		 
       //para el nombre de usuario
       $this->form_validation->set_rules(
								'txt_username',
								'Nombre de usuario ',
								 array(
									'max_length[15]',
									'required',
									'is_unique[' . db_table('user_table') . '.username]'
									
								),
								array(
									'required' => '%s  es Requerido',
									'is_unique' => '%s ya está en uso'
									 
								)	 
        			       );	
						   
							   
	   //para verificar la contraseña
       $this->form_validation->set_rules(
								'txt_clave',
								'Clave ',
								 array(									
									'required',
									[ 
										'_check_password_strength', 
										[ $this->validation_callables, '_check_password_strength' ] 
									]
									
								),
								array(
									'required' => '%s es Requerida',									 
								)	 
        			       );					   			   

	  //para el correo
       $this->form_validation->set_rules(
								'txt_correo',
								'Correo',
								 array(
									'trim',
									'required',
                                     //'valid_email', //error en el servidor
									'is_unique[' . db_table('user_table') . '.email]'
									
								),
								array(
									'required' => 'El %s es Requerido',
									'is_unique' => 'El correo yá está en uso'
									 
								)	 
        			       );	
						   
					   
       	 // ==== para validación de foto =====
		$dni = $this->input->post('txt_dni'); //para concatenar al nombre de la foto
        $this->form_validation->set_rules('foto_usuario', 'Foto Usuario', 'callback_do_upload[' . $dni. ']' ); 		
				   
				

        
         //para la descripción  
       // $this->form_validation->set_rules('txt_descripcion', 'Descripcion', 'required|min_length[5]|max_length[200]');
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
            $config['upload_path']       = './public/img/fotos_usuarios/original';
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
				$config['source_image'] = './public/img/fotos_usuarios/original/' . $nombre_imagen_full ;  
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
					unlink( FCPATH . "/public/img/fotos_usuarios/original/" . $nombre_imagen_full );						
					//return $nombre_imagen_full;
					//Guardar nombre de foto, en variable de sesión, flash
					$this->session->set_flashdata('nombre_foto_user', $nombre_imagen_full);
					return TRUE;
					
				}

                //$data = array('upload_data' => $this->upload->data());
				//$this->load->view('z_pruebas/formulario_subir_foto_correcto', $data);

            }

		}//fin comprobación IF se subió foto
		else 
		{
			//No se subió ninguna foto, (establecer, foto Predeterminada)
			$this->session->set_flashdata('nombre_foto_user', 'avatar_defecto.png');
			return TRUE;
		}

    }//fin función upload
	

    
    
}
