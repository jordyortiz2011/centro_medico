<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nueva extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
         $this->load->helper('form');
    }
	
	public function index(){
		redirect('solicitud/nueva/form_ficha_matricula');
	}
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro
     * @param  -_-  
     */   
    public function form_nueva($id_matriz = false)
    {
        
         // Method should not be directly accessible                      
         if( $this->verify_role('admin') )
        {
		    // === fecha actual ===	      
            $hoy = new DateTime();	//fecha de hoy	
            $hoy_fecha  = $hoy->format('Y-m-d H:i');

            //Obtener datos de la matriz relacionado con la solicitud
            $this->load->model('reutilizables/Model_matrices');
            $matriz = $this->Model_matrices->obtener_matriz_xID($id_matriz);
            //print_r($matriz); exit;
						  
			$data = array(								
							'hoy'		   		=> $hoy_fecha ,
                            'matriz'            => $matriz
						  );
                         
            $this->load->view('estimacion/vista_nueva', $data);
        }
  
    }
	
 /**
     * Obtiene los datos del formulario solicitud  los procesa,
     * valida, y los manda al modelo, para guardar en la BD
     * Permiso: solo administradores
     * @param  -_-
     * @return  -_- (carga  la vista de listado)
     */
    public function procesa()
    {

        // Method should not be directly accessible
        if(  $this->verify_role('admin')   )
        {
            $post = $this->input->post();
            //print_r($post) ; exit;


            //establecer reglas de validacion:
            $this->validacion_reglas();

            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {
                $id_matriz = $post['id_matriz'];
                $this->form_nueva($id_matriz);
            }
            else {

                //print_r($post)         ; exit;
                //guardar en la BD
                $this->load->model('estimacion/Model_nueva');
                $result =  $this->Model_nueva->guardar_estimacion($post);

                //verifica si  registró el ciclo correctamente (si el valor devuelto es numerico)
                if($result) {
                        $this->session->set_flashdata('estado_registro', 'registrado');

                        //redirección de acuerdo al boton
                        if($post['btn_subir'] == 'permanecer')
                            redirect('estimacion/nueva/form_nueva', 'refresh');
                        else if($post['btn_subir'] == 'listar')
                            redirect('estimacion/listar/listar_estimaciones', 'refresh');
                        else
                            redirect('estimacion/listar/listar_estimaciones', 'refresh');

                }else {

                    //registro ERROR, entonces mostramos mensaje y cargamos de nuevo vista registrar
                    $this->session->set_flashdata('estado_registro', 'registrar_error');
                    redirect('estimacion/listar/listar_estimaciones', 'refresh');
                }



            }//fin de form_validation->run()

        } //Fin validación de roles
        else
        {
            $this->load->view('errors/vista_sin_acceso');
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

       // ==== para el select de variedad =====
        $this->form_validation->set_rules('select_variedad', 'Variedad', 'required|trim|in_list[1,2]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Elija una <b> %s </b> válida'
            )
        );


        // ==== para el área cultivada =====
        $this->form_validation->set_rules('a_area_cultivada', 'ÁREA CULTIVADA EN EL LOTE (HA) (A)', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );

 // ==== para el select de Densidad Siembra =====
        $this->form_validation->set_rules('b_densidad_siembra', 'DENSIDAD DE SIEMBRA (METROS) (B)', 'required|trim|in_list[1,2]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Elija una <b> %s </b> válida'
            )
        );


        // ==== para el Número de mazorcas por planta =====
        $this->form_validation->set_rules('d_num_mazorcas', 'Nº MAZORCAS POR PLANTA (D)', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		  // ==== para el peso de semilla de cacao =====
        $this->form_validation->set_rules('e_num_semillas', 'Nº DE SEMILLAS POR MAZORCA (E)', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		
		 // ==== para el Número de semillas para mazorcas =====
        $this->form_validation->set_rules('f_peso_semilla', 'PESO DE SEMILLA DE CACAO (F) ', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
     // ==== para el precio por kg =====
        $this->form_validation->set_rules('l_precio_kg', 'PRECIO KG (L) ', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		 // ==== para el costo de produccion =====
        $this->form_validation->set_rules('costo_produccion', 'COSTO DE PRODUCCIÓN', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		 // ==== para canasta básica =====
        $this->form_validation->set_rules('canasta_basica', 'CANASTA BASICA', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		 // ==== para rendimiento historico de la zona por hectareas =====
        $this->form_validation->set_rules('rendimiento_historico', 'RENDIMIENTO HISTORICO DE LA ZONA POR HA', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );
		 // ==== para rendimiento promedio de la zona por hectareas =====
        /*$this->form_validation->set_rules('rendimiento_promedio', 'RENDIMIENTO PROMEDIO DE LA ZONA POR HA', 'required|trim|numeric' ,
            //mensajes personalizados de cada regla de validación
            array(
                'numeric'     => 'Ingrese un valor númerico en :<b> %s </b> .'
            )
        );*/
    }//fin funcion validación reglas
    
}
