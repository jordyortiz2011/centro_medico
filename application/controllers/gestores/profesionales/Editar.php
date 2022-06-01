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
			  redirect('gestores/profesionales/listar/listar_profesionales');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/profesionales/Model_editar');
             $profesional  = $this->Model_editar->obtener_profesional($id_registro);
			 
			 //si no existe ningún registro con el id , redireccionar al listar
			 if($profesional == NULL)
			 	redirect('gestores/profesionales/listar/listar_profesionales');
			 
			// print_r($ciclo); exit;
			
			 //Datos del Empleado
			  $id_especialidad = $profesional->id_especialidad_user;


			 // =============================================================================
             //CREAR SELECT DE TIPO DE EMPLEADO                 
        	 $this->load->model('reutilizables/Model_especialidades');
             $lst_especialidades = $this->Model_especialidades->listado_especialidades();
                
             //para que cree el array de id y nombre del select = unidades de medida
             foreach ($lst_especialidades as $espe) {
                $lista_especialidad[$espe->id_especialidad] = $espe->nombre_espe;
              }           
            
             //string del select customizado 
             $dropdown_especialidad = form_dropdown('select_especialidad', $lista_especialidad, $id_especialidad,"class='select2 form-control form-control-lg' id='select_especialidad' " );
			
		     // =============================================================================
        
        
			 $data = array (
			 				 'profesional'		    	=> $profesional,
			 				 'select_especialidad'	=> $dropdown_especialidad
			 				 
			 				); 
                      
             $this->load->view('gestores/profesionales/vista_editar',$data)  ;
                            
              
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
               $this->form_editar($post['hidden_id_profesional']);
                   
            }else {
            	
            	///echo "registrar ";
                // Load resources
                $this->is_logged_in();
                $this->load->helper('auth');
                $this->load->model('examples/examples_model');


                $id_profesional = $post['hidden_id_profesional']; //id del usuario a editar

                //Datos personales
                $user_data['apellido_pat_user'] 	= $post['text_apellido_pat'];
                $user_data['apellido_mat_user'] 	= $post['text_apellido_mat'];
                $user_data['nombres_user'] 			= $post['text_nombres'];
                $user_data['dni_user'] 			    = $post['text_dni'];

                //Datos de la cuenta
                $user_data['username'] 	            = $post['text_username'];
                $user_data['email'] 	            = $post['text_correo'];
                $user_data['id_especialidad_user'] 	= $post['select_especialidad'];

                //para elcheckbox Activo
                $user_data['banned'] = isset($post['checkbox_estado']) ? '0' : '1' ;

                // si se ingresó algo en el campo clave
                if(  $post['text_clave']  &&  $post['text_clave'] != '' )
                {
                    $user_data['passwd'] =  $this->authentication->hash_passwd($post['text_clave']);
                }

                //print_r($user_data); exit;

                $this->load->model('gestores/profesionales/Model_editar');
                $res = $this->Model_editar->editar_profesional($id_profesional ,$user_data );
				

				//comprobar si se guardó exitosamente el registro
				if ( $res == TRUE  )	{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                				
	            		
					//redirección de acuerdo al boton
					if($post['btn_subir'] == 'listar') 
            			 redirect('gestores/profesionales/listar/listar_profesionales', 'refresh');
						
				}
				else{
					 //datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                	 redirect('gestores/profesionales/listar/listar_profesionales', 'refresh');
				}					
				
            	
            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');

        $this->load->helper('auth');						 //funciones de librería community_aut (db_table)
        $this->load->model('examples/validation_callables'); //validación de fortaleza de la contraseña


        //para no realizar comprobación del nombre del colegio si no se cambió el nombre del colegio
		$id_registro	= $post['hidden_id_profesional'];
        $this->load->model('gestores/profesionales/Model_editar');
		$profesional  = $this->Model_editar->obtener_profesional($id_registro);


	
		
		//=== comprueba si el DNI  ya existe, ( en caso se cambia cambiado) ==
		if($profesional->dni_user != $post['text_dni'])
		{
		  //para el nombre        
          $this->form_validation->set_rules('text_dni', 'DNI', 'required|trim|min_length[8]|max_length[8]|is_unique[users.dni_user]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_dni', 'DNI', 'required|trim|min_length[8]|max_length[8]' );
		}

        //=== comprueba si el NOMBRE DE USUARIO  ya existe, ( en caso se cambia cambiado) ==
        if($profesional->username != $post['text_username'])
        {
            $this->form_validation->set_rules('text_username', 'Nombre de Usuario', 'required|trim|min_length[3]|max_length[15]|is_unique[users.username]' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => 'Este <b> %s </b> ya existe.'
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_username', 'Nombre de Usuario', 'required|trim|min_length[3]|max_length[15]' );
        }

        //=== comprueba si el CORREO ya existe, ( en caso se cambia cambiado) ==
        if($profesional->email != $post['text_correo'])
        {
            $this->form_validation->set_rules('text_correo', 'Correo', 'required|trim|is_unique[users.email]' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => 'Este <b> %s </b> ya existe.'
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_correo', 'Correo', 'required|trim' );
        }


        // ==== para Apellido Paterno  =====
        $this->form_validation->set_rules('text_apellido_pat', 'Apellido paterno', 'required|trim|min_length[2]|max_length[30]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );

        // ==== para Apellido Materno  =====
        $this->form_validation->set_rules('text_apellido_mat', 'Apellido materno', 'required|trim|min_length[2]|max_length[30]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );

        // ==== para nombres  =====
        $this->form_validation->set_rules('text_nombres', 'Nombres', 'required|trim|min_length[2]|max_length[60]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );


		
		 //===== para la especialidad  ===========
         // obtener listado
		$this->load->model('reutilizables/Model_especialidades');
        $lst_especialidades = $this->Model_especialidades->listado_especialidades();
		
		$string_espe = '';
		foreach ($lst_especialidades as $espe) {
            $string_espe .= $espe->id_especialidad . ',';
		}		
		$string_tipo = trim($string_espe, ',');
    	$this->form_validation->set_rules('select_especialidad', 'Especialidad', 'required|in_list[' . $string_espe. ']') ;


        //===== para la contraseña  ===========
        if($post['text_clave'] != '') {

            $this->form_validation->set_rules(
                'text_clave',
                'Clave ',
                array(
                    // 'required',
                    [
                        '_check_password_strength',
                        [ $this->validation_callables, '_check_password_strength' ]
                    ]

                ),
                array(
                    //'required' => '%s es Requerida',
                )
            );

        }


	}


    
    
}
