<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Full_calendar_ajax extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');
        $this->require_min_level(1);

        $this->load->model('gestores/horarios/Model_full_calendar');
    }
    
	

 // --------------------------------------------------------------
/**
 * Obtiene eventos dinamicamente
 * 
 * @param  (post) fecha inicio, fecha fin  */   
	
    Public function obtener_horarios()
	{

        $post   = $this->input->post();
        //print_r($post); exit;

		$result =$this->Model_full_calendar->obtener($post);

		//print_r($result);exit;



        // ====== CREAR SELECT DE PROFESIONALES ===========
        $this->load->helper('form');
        $this->load->model('reutilizables/Model_profesionales');
        $lst_profesionales = $this->Model_profesionales->listado_profesionales(); //5 = Sólo profesores
        //print_r($lst_profesores); exit;

        $array_profesionales  = array(); //array que tendrá los registros
        $array_profesionales[''] = 'Seleccione';
        //para que cree el array de id y nombre del select = unidades de medida
        foreach ($lst_profesionales as $profesional) {
            $array_profesionales[$profesional->user_id] = $profesional->apellido_pat_user. ' ' . $profesional->apellido_mat_user. ', ' . $profesional->nombres_user  ;
        }
        //var_dump($array_profesores); exit;
        //string del select customizado
        //$dropdown_profesores = form_dropdown("select_profesores", $array_profesores, '','class="select2 form-control " id="select_profesores" ' );


        //var_dump($array_profesores); exit;
        //string del select customizado
        //$dropdown_profesores = form_dropdown("select_profesores", $array_profesores, '','class="select2 form-control " id="select_profesores" ' );



        $datos = array();
		foreach ($result as $evento) {
			
			$dato['id'] 		= $evento->id_horario;
			$dato['title'] 		=  '<b>' . $evento->nombre_espe . '</b>' ;  //. ' ' .  $evento->nombres_user . ' ' . $evento->apellido_pat_user;
			//Recortar primer nombre de docente
            $primer_nombre     =   explode(" ",$evento->nombres_user);
            $dato['description'] =  $primer_nombre[0] . ' ' . $evento->apellido_pat_user;
			//$dato['start'] 		= $evento->fecha_inicio_ciclohora;
			//$dato['end'] 		= $evento->fecha_fin_ciclohora;

            $dato['startTime'] 		= $evento->hora_inicio_hora;
            $dato['endTime'] 		= $evento->hora_fin_hora;

			$dato['color'] 		= $evento->color_espe;

            $dato['dow']       = $evento->dias_semana_hora;

            $dato['id_especialidad']       = $evento->id_especialidad_hora;
			

			//CREAR SELECT DE PROFESOR (EL CUAL FUE SELECCIONADO PREVIAMENTE)
            //string del select customizado
            $dropdown_profesionales = form_dropdown("select_profesionales", $array_profesionales,  $evento->id_profesional_hora,'class="select2 form-control " id="select_profesionales" ' );
			$dato['dropdown_profesionales'] = $dropdown_profesionales;

            //CREAR SELECT DE CURSOS (EL CUAL FUE SELECCIONADO PREVIAMENTE)
            //string de la especialidad
            //$dropdown_cursos = form_dropdown("select_cursos", $array_cursos,  $evento->id_curso_ciclohora,'class="select2 form-control " id="select_cursos" ' );
            $this->load->model('reutilizables/Model_especialidades');
            $especialidad = $this->Model_especialidades->obtener_especialidad($evento->id_especialidad_hora); //5 = Sólo profesores
            $dato['especialidad'] = $especialidad->nombre_espe;
			
			$datos[] = $dato ;			
			
		}
		
		
		echo json_encode($datos);
	}
      
	/*agregar Evento*/  
	Public function agregar_horario()
	{
	    $post = $this->input->post();
	    //print_r($post); exit;

        //Dar formato a la fecha de inicio del evento
        $fecha_inicio = new DateTime( $post['hidden_fecha_inicio']);
        $post['hidden_fecha_inicio'] = $fecha_inicio->format('Y-m-d');

        //Dar formato a la fecha de fin del evento
        //$fecha_fin = new DateTime( $post['hidden_fecha_inicio']);
        $post['hidden_fecha_fin'] = '3000-01-01'; //Para que se repita hasta esa fecha

        //Obtener día de la semana del evento
        $días_semana = new DateTime( $post['hidden_fecha_inicio']);
        $post['dias_semana'] = '[' . $días_semana->format('w') . ']' ; //[1] = Lunes


        //establecer reglas de validacion:
        $this->validacion_reglas();

        // respuesta al script ajax
        $respt = new stdClass();

        //Comprobar formulario válido
        if( $this->form_validation->run() == FALSE )
        {

            $respt->estado = 'error_validacion';

            $respt->errores = validation_errors('<div class="alert alert-danger">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>',
                '</div>');

            echo json_encode($respt);
            exit;
        }else {



            $result=$this->Model_full_calendar->agregar($post);

            $respt = new stdClass();
            if($result) {
                //registro Correcto
                $respt->estado = 'registro_correcto';
            }else {
                $respt->estado = 'registro_error';
            }

            echo json_encode($respt);

        }


	}  

	/*Actualizar  Evento*/
	Public function actualizar_horario()
	{
        $post = $this->input->post();

		$result=$this->Model_full_calendar->actualizar($post);


        //establecer reglas de validacion:
        $this->validacion_reglas();

        $respt = new stdClass();


        //Comprobar formulario válido
        if( $this->form_validation->run() == FALSE )
        {

            $respt->estado = 'error_validacion';

            $respt->errores = validation_errors('<div class="alert alert-danger">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>',
                '</div>');

            echo json_encode($respt);
            exit;
        }else {

            $result=$this->Model_full_calendar->agregar($post);

            if($result) {
                //registro Correcto
                $respt->estado = 'registro_correcto';
            }else {
                $respt->estado = 'registro_error';
            }
            echo json_encode($respt);
        }

        echo json_encode($respt);
	}


    /*eliminar Evento*/
    Public function eliminar_horario()
    {
        $post = $this->input->post();

        $result=$this->Model_full_calendar->eliminar($post);


        $respt = new stdClass();
        if($result) {
            //registro Correcto
            $respt->estado = 'eliminar_correcto';
        }else {
            $respt->estado = 'eliminar_error';
        }


        echo json_encode($respt);
    }


    /**
     * Reglas de validacion para formulario
     */
    private function validacion_reglas ()
    {
        //carga la libreria para validar formulario
        $this->load->library('form_validation');
        $this->config->set_item('language', 'spanish');


        // ==== para Comprobar si el docente está enseñando en la misma hora en otra aula  =====
        $this->form_validation->set_rules('id_profesional', 'Profesional ', 'required|callback_validacion_profesional_ocupado' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'                     => 'Este <b> %s </b> ya existe.',
                //'validacion_docente_ocupado'    => 'Docente ocupado en otra aula, a la misma hora'
            )
        );

        // ==== para Comprobar si el docente está enseñando en la misma hora en otra aula  =====
        $this->form_validation->set_rules('id_consultorio', 'Consultorio:  ', 'required|callback_validacion_consultorio_ocupado' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'                     => 'Este <b> %s </b> ya existe.',
                //'validacion_docente_ocupado'    => 'Docente ocupado en otra aula, a la misma hora'
            )
        );


    }

    /* Para comprobar si el docente ya tiene asignado un aula en un
        determinado día de la semana y hora */
    function validacion_profesional_ocupado() {

        $post = $this->input->post();
        //echo "validacion"; print_r($post);exit;

        $id_consultorio      = $post['id_consultorio'];
        $hora_inicio         = $post['text_hora_inicio'];
        $hora_fin            = $post['text_hora_fin'];
        $id_profesional      = $post['id_profesional'];

        //Obtener día de la semana del evento
        $días_semana = new DateTime( $post['hidden_fecha_inicio']);
        $dia_semana  = '[' . $días_semana->format('w') . ']' ; //[1] = Lunes



        $this->db->select('*');
        $this->db->from('tbl_horarios');
        $this->db->join('tbl_consultorios','tbl_consultorios.id_consultorio =  tbl_horarios.id_consultorio_hora');
        $this->db->where('dias_semana_hora ', $dia_semana);
        $this->db->where("id_profesional_hora" , $id_profesional );
        $this->db->group_start(); // Abrir parentesis
        $this->db->where("CONVERT(`hora_inicio_hora` , TIME )  <= CONVERT( '$hora_inicio' , TIME)  ", NULL, FALSE);
        $this->db->where("CONVERT(`hora_fin_hora` , TIME )  >= CONVERT( '$hora_fin' , TIME)  ", NULL, FALSE);
        $this->db->group_end(); // Abrir parentesis

        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();
        $num = $query->num_rows();

        $horario = $query->row();
        if ($num > 0) {
            $this->form_validation->set_message('validacion_profesional_ocupado', 'Profesional ocupado en: <b>' . $horario->nombre_consul . '</b>');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    /* Según la lógica del negocio, solo un profesional podrá usar un consultorio por día */
    function validacion_consultorio_ocupado() {

        $post = $this->input->post();
        //echo "validacion"; print_r($post);exit;

        $id_consultorio      = $post['id_consultorio'];
        $hora_inicio         = $post['text_hora_inicio'];
        $hora_fin            = $post['text_hora_fin'];
        $id_profesional      = $post['id_profesional'];

        //Obtener día de la semana del evento
        $días_semana = new DateTime( $post['hidden_fecha_inicio']);
        $dia_semana  = '[' . $días_semana->format('w') . ']' ; //[1] = Lunes



        $this->db->select('*');
        $this->db->from('tbl_horarios');
        $this->db->join('tbl_consultorios','tbl_consultorios.id_consultorio =  tbl_horarios.id_consultorio_hora');
        $this->db->where('id_consultorio_hora ', $id_consultorio);
        $this->db->where('dias_semana_hora ', $dia_semana);
        //$this->db->where("id_profesional_hora" , $id_profesional );


        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();
        $num = $query->num_rows();

        $horario = $query->row();
        if ($num > 0) {
            $this->form_validation->set_message('validacion_consultorio_ocupado', ' <b> El consultorio ya se encuentra ocupado</b>');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    
    
}
