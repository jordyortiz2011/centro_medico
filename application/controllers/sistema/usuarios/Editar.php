<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form','fechas');
        $this->require_min_level(1);
        
      
        
    }
  
    // --------------------------------------------------------------
    /**
     * editar un usuario -  Sistema/usuarios -> Agregar     
     * @param  $id_usuario(int)   
     */   
    public function form_editar($id_usuario = null)
    {   	
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	
			 if($id_usuario == null ) 
			  redirect('sistema/usuarios/listar/listar_usuarios');
			
			//obtener datos del usuario
			$this->load->model('sistema/usuarios/Model_usuarios');
			$usuario = $this->Model_usuarios->obtener_usuario($id_usuario);	
			//print_r($usuario);exit;
			
			//si no existe ningún registro con el id , redireccionar al listar
			 if($usuario == null || $usuario == false) 			  	
				redirect('sistema/usuarios/listar/listar_usuarios');
			  		
			
			
			// ===  CREAR  SELECT TIPO DE USUARIO ========                      
            //para que cree el array de geolocalización
            $tipo_usu = $usuario->auth_level;
         	
			$lst_tipos_usuarios = config_item('levels_and_roles');	
        
            
            //string del select customizado 
            $dropdown_tipo_usu = form_dropdown('select_tipo_usuario', $lst_tipos_usuarios, $tipo_usu,"class='select2 form-control form-control-lg' id='select_tipo_usuario'" );
			// ==================================================================================================


            // ===  CREAR  SELECT AGENCIA ========
            $this->load->model('reutilizables/Model_agencias');
            $lst_agencias = $this->Model_agencias->listado_agencias();
            //print_r($lst_departamentos);

            //para que cree el array de id y nombre del select = unidades de medida
            $array_agencias[''] = 'Seleccione';
            foreach ($lst_agencias as $agencia) {
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
            }
            if ( $usuario->auth_level == 8 ||  $usuario->auth_level == 7  ||  $usuario->auth_level == 4 ||  $usuario->auth_level == 3) {
                $id_agencia = $usuario->id_agencia_user;
                //string del select customizado
                $dropdown_agencias = form_dropdown('select_agencias', $array_agencias, $id_agencia,"class='select2 form-control' id='select_agencias' " );

            }else {
                $dropdown_agencias = form_dropdown('select_agencias', $array_agencias, '',"class='select2 form-control no_validar' id='select_agencias' " );
            }

			
						
			$data = array(
							'usuario'			 	 => $usuario,
							'select_tipo_usuario'	 =>  $dropdown_tipo_usu,
                            'select_agencias'	 =>  $dropdown_agencias,
							
							
						 );
            
            $this->load->view('sistema/usuarios/vista_editar' , $data ); 			                    
              
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
            $this->validacion_reglas_usuario($post);
			
			
			 //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {
            	
            	$this->form_editar( $post['hidd_id_usuario']); //redireccionar al formulario     
				                                
               //$this->load->view('anuncios/vista_formulario', $data);    
            }else {
            	
			   //echo "registrar ";
			   // Load resources
			    $this->is_logged_in();
				$this->load->helper('auth');
				$this->load->model('examples/examples_model');
							
			 
				$id_usuario = $post['hidd_id_usuario']; //id del usuario a editar
			
			    $user_data['auth_level'] = $post['select_tipo_usuario'];			   
			    $user_data['email'] 	 = $post['txt_correo'];
				
				//para elcheckbox Activo           	
            	$user_data['banned'] = isset($post['checkbox_estado']) ? '0' : '1' ;				
				$user_data['nombres_user'] 			 = $post['txt_nombres'];
				$user_data['apellido_pat_user'] 	 = $post['txt_apellido_pat'];
				$user_data['apellido_mat_user'] 	 = $post['txt_apellido_mat'];

                $user_data['id_agencia_user'] 	 = $post['select_agencias'];
				
						
				// If username is not used, it must be entered into the record as NULL
				if( empty( $post['txt_username'] ) )
				{
					$user_data['username'] = NULL;
				}else {
					$user_data['username'] = $post['txt_username'];
				}
				
				// si se ingresó algo en el campo clave
				if(  $post['txt_clave']  &&  $post['txt_clave'] != '' )
				{
					$user_data['passwd'] =  $this->authentication->hash_passwd($post['txt_clave']);
				}
				
				//print_r($user_data); exit;
	
				$this->load->model('sistema/usuarios/Model_editar');
				$res = $this->Model_editar->editar_usuario($id_usuario ,$user_data );
				
				//var_dump($res); exit;
				//comprobar si se guardó exitosamente el registro
				if ( $res == TRUE  )	{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                				
	            		
					//redirección de acuerdo al boton
					if($post['btn_subir'] == 'listar') 
            			 redirect('sistema/usuarios/listar/listar_usuarios', 'refresh');  
						
				}
				else{
					 //datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                	  redirect('sistema/usuarios/listar/listar_usuarios', 'refresh');  					
				}
            }
            
       }

		
		

	
  
    }

     /**
     * Reglas de validacion para formulario de agregar Usuario     
     */       
    private function validacion_reglas_usuario ($post) 
    {               
        //carga la libreria para validar formulario               
        $this->load->library('form_validation');
	    $this->config->set_item('language', 'spanish');
		
		$this->load->helper('auth');						 //funciones de librería community_aut (db_table)
		$this->load->model('examples/validation_callables'); //validación de fortaleza de la contraseña
	
		
		//para  realizar comprobación del nombre de usuario y correo, si se cambió y ya existe otro con el mismo nombre
		$id_usuario	= $post['hidd_id_usuario'];
     	$this->load->model('sistema/usuarios/Model_usuarios');
		$usuario = $this->Model_usuarios->obtener_usuario($id_usuario);	
		
			  // ==== para DNI === 
	  //si el campo es diferente al que teniía aplicar verificación de correo único en la BD
	   if($usuario->dni_user != $post['txt_dni'])  {
	   	  $this->form_validation->set_rules(
								'txt_dni',
								'DNI  ',
								 array(
									'trim',
									'required',	
									'min_length[8]',
									'max_length[8]',																	
									'is_unique[' . db_table('user_table') . '.dni_user]'
									
								),
								array(
									'required' => 'El %s es Requerido',
									'is_unique' => 'El %s  yá está en uso'
									 
								)	 
        			       );	
	   } else {
	   	
	   	 $this->form_validation->set_rules('txt_dni', 'DNI', 'trim|required|min_length[8]|max_length[8]' ,
	   	 									 array('required' => 'El %s es Requerido') 
										   );	   	
	   }
		
		
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
						   
				
	  // ==== para el correo === 
	  //si el correo es diferente al que teniía aplicar verificación de correo único en la BD
	   if($usuario->email != $post['txt_correo'])  {
	   	  $this->form_validation->set_rules(
								'txt_correo',
								'Correo  ',
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
	   } else {
	   	
	   	 $this->form_validation->set_rules('txt_correo', 'Correo', 'trim|required' ,
	   	 									 array('required' => 'El %s es Requerido') 
										   );	   	
	   }
     			   
         
       // === para el nombre de usuario === 
         //si el nombre de usuario es diferente al que teniía aplicar verificación de correo único en la BD
	   if($usuario->username != $post['txt_username'])  {
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
	   }
	   else {	   	
	   		 $this->form_validation->set_rules('txt_username', 'Nombre de usuario ', 'max_length[15]|required' ,
	   	 									 array('required' => 'El %s es Requerido') 
										   );	  
	   }
						   
	   //para verificar la contraseña
	     //si se escribío algo en la contraseña
	   if($post['txt_clave'] != '')  {
       $this->form_validation->set_rules(
								'txt_clave',
								'Contraseña',
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
				
	   }else {
	   		//no realizar comprobación del a contraseña
	   }
	   
	   
        
         //para la descripción  
       // $this->form_validation->set_rules('txt_descripcion', 'Descripcion', 'required|min_length[5]|max_length[200]');
    }
    
    

 
    
    
}
