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

            $this->load->model('reutilizables/Model_especialidades');
            $lst_especialidades = $this->Model_especialidades->listado_especialidades();
			
			
			$data = array(
							'lst_especialidades' =>  $lst_especialidades,
						 );			
                       
            $this->load->view('gestores/profesionales/vista_registrar', $data);
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
			  $this->form_registrar();
			    
            }
            else {

				//print_r($post); echo "Despues validar";  exit;

                // Load resources
                $this->is_logged_in();
                $this->load->helper('auth');
                $this->load->model('examples/examples_model');

                $user_data['username'] 	 = $post['text_username'];
                $user_data['passwd']     = $this->authentication->hash_passwd($post['text_clave']);
                $user_data['user_id']    = $this->examples_model->get_unused_id();
                $user_data['created_at'] = date('Y-m-d H:i:s');
                $user_data['auth_level'] = 7; // 7 = Profesional
                $user_data['email'] 	 = $post['text_correo'];
                //para elcheckbox Activo
                $user_data['banned'] = isset($post['checkbox_estado']) ? '0' : '1' ;

                //datos agregado a la librería Community Auth
                $user_data['dni_user'] 		 	= $post['text_dni'];
                $user_data['nombres_user'] 		= $post['text_nombres'];
                $user_data['apellido_pat_user'] = $post['text_apellido_pat'];
                $user_data['apellido_mat_user'] = $post['text_apellido_mat'];

                $user_data['id_especialidad_user'] = $post['select_especialidad'];


                //guardar en la BD
                $this->db->set($user_data)
                    ->insert(db_table('user_table'));

                if( $this->db->affected_rows() == 1 ){

                    //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                    $this->session->set_flashdata('estado_registro', 'registrado');

                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'permanecer')
                        redirect('gestores/profesionales/registrar/form_registrar', 'refresh');
                    else if($post['btn_subir'] == 'listar')
                        redirect('gestores/profesionales/listar/listar_profesionales', 'refresh');
                    else
                        redirect('gestores/profesionales/listar/listar_profesionales', 'refresh');


                }else {

                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar
                    $this->session->set_flashdata('registro_error', true);
                    redirect('gestores/profesionales/listar/listar_profesionales', 'refresh');
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

        $this->load->helper('auth');						 //funciones de librería community_aut (db_table)
        $this->load->model('examples/validation_callables'); //validación de fortaleza de la contraseña


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
        
         // ==== para el DNI =====
       $this->form_validation->set_rules('text_dni', 'DNI', 'min_length[8]|max_length[8]|is_unique[users.dni_user]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
        

       /* ======= PARA DATOS DE LA CUENTA =============== */

        //para el nombre de usuario
        $this->form_validation->set_rules(
            'text_username',
            'Nombre de usuario ',
            array(
                'min_length[3]',
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
            'text_clave',
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
            'text_correo',
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
