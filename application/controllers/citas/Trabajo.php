<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajo extends MY_Controller {
    
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
            /*$this->load->model('reutilizables/Model_especialidades');
            $lst_especialidades = $this->Model_especialidades->listado_especialidades();
            //var_dump($lst_especialidades); exit;

            //ÚLTIMO DÍA para Datetimepicker (HOY + 1 Dia)
            $hoy            = new DateTime();	//fecha de hoy
            $fecha_sumada   = $hoy->modify('+1 day');
            $fecha_sumada   = $fecha_sumada->format('Y-m-d'); */

            $data =
                array(
                        'a'     =>  ''// $lst_especialidades, //Todos los datos correspondientes al último ciclo
                       // 'fecha_sumada'           => $fecha_sumada

                );
						  
                         
            $this->load->view('citas/vista_trabajo', $data);
              
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
                //print_r($post)         ; exit;
                //guardar en la BD

                //REGISTRAR EL PAGO
                $this->load->model('pagos/Model_nuevo');
                $result_pago =  $this->Model_nuevo->registrar_pago( $post);

                if($result_pago) {
                    //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                    $this->session->set_flashdata('estado_registro', 'registrado');

                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'permanecer')
                        redirect('pagos/nuevo/form_nuevo', 'refresh');
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
        $this->form_validation->set_rules('hidden_id_matricula', 'ID matricula', 'required|is_numeric' );


        //===== para RECIBO NÚMERO   ======
        $this->form_validation->set_rules('text_num_recibo', 'Número de recibo', 'required|trim|min_length[4]|max_length[20]|is_unique[tbl_pagos.numero_recibo_pago]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'     => 'Esta <b> %s </b> ya existe.'
            )
        );
        //===== para RECIBO FECHA   ======
        $this->form_validation->set_rules('text_fecha_recibo', 'Fecha de recibo', 'required|trim|callback_validacion_fecha' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.' ,
                'validacion_fecha'     => ' <b> %s </b> no valida',
            )
        );
        //===== para RECIBO MONTO   ======
        $monto_matricula =
        $this->form_validation->set_rules('text_monto_recibo', 'Monto de recibo', 'required|trim|greater_than_equal_to[1]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.' ,
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
