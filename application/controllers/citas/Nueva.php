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
		redirect('cistas/nueva/form_nueva');
	}
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro de asistencia normal    
     * @param  -_-  
     */   
    public function form_nueva()
    {

         // Method should not be directly accessible                      
         if(  $this->auth_level == 9 || $this->auth_level == 5  )
        {
            $this->load->model('reutilizables/Model_especialidades');
            $lst_especialidades = $this->Model_especialidades->listado_especialidades();
            //var_dump($lst_especialidades); exit;

            //ÚLTIMO DÍA para Datetimepicker (HOY + 1 Dia)
            $hoy            = new DateTime();	//fecha de hoy
            $fecha_hoy  = $hoy->format('Y-m-d');

            $data =
                array(
                        'lst_especialidades'   => $lst_especialidades, //Todos los datos correspondientes al último ciclo
                        'fecha_hoy'           => $fecha_hoy

                );
						  
                         
            $this->load->view('citas/vista_nueva', $data);
              
        }
  
    }


    /**
     * Obtiene los datos del formulario , los procesa,
     * valida, y los manda al modelo, para guardar en la BD
     * Permiso: solo administradores
     * @param  -_-
     * @return  -_- (carga  la vista dependiendo del botón presionado al enviar formulario)
     */
    public function procesa()
    {

        // Method should not be directly accessible
        if(   $this->auth_level == 9 || $this->auth_level == 7   )
        {
            $post = $this->input->post();
            //print_r($post)         ; exit;

            //establecer reglas de validacion:
            $this->validacion_reglas();

            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {
                //$this->load->view('formulario/vista_formulario');
                $this->form_nuevo();

            }
            else {
                //echo 'Guardar';print_r($post)         ; exit;
                //guardar en la BD

                //REGISTRAR EL PAGO
                $this->load->model('citas/Model_nueva');
                $result_cita =  $this->Model_nueva->registrar_cita( $post);

                //var_dump($result_cita); exit;

                if($result_cita) {
                    //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                    $this->session->set_flashdata('estado_registro', 'registrado');
                    $this->session->set_flashdata('num_cita', $result_cita);

                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'permanecer')
                        redirect('citas/nueva/form_nueva', 'refresh');
                    else if($post['btn_subir'] == 'listar')
                        redirect('pagos/listar/listar_pagos', 'refresh');
                    else if($post['btn_subir'] == 'editar_matricula')
                        redirect('matricula/editar/form_editar/' . $post['hidden_id_matricula'] .'#bloque_pagos', 'refresh');
                    else
                        redirect('pagos/listar/listar_pagos', 'refresh');

                }else {
                    //error al guardar

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

        //===== para ID MATRICULA   ======
        $this->form_validation->set_rules('hidden_id_paciente', 'ID Paciente', 'required|is_numeric' );


        //===== para specialidades   ======
        $this->form_validation->set_rules('select_especialidad', 'Especialidad', 'required|trim' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'     => 'Esta <b> %s </b> ya existe.'
            )
        );

        //===== para profesionales  ======
        $monto_matricula =
            $this->form_validation->set_rules('select_profesionales', 'Profesionales', 'required|trim' ,
                //mensajes personalizados de cada regla de validación
                array(
                    //'is_unique'     => 'Esta <b> %s </b> ya existe.' ,
                )
            );

        //===== para fecha cita  ======
        $this->form_validation->set_rules('text_fechacita', 'Fecha Cita', 'required|trim|callback_validacion_fecha' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.' ,
                'validacion_fecha'     => ' <b> %s </b> no valida',
            )
        );




    }



    //comprueba si el texto es una fecha válida con formato YYYY-MM-DD
    public function validacion_fecha($fecha){
        //print_r(var_dump($fecha));exit;
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






}
