<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_ajax extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }
	
	public function index(){
		redirect('matricula/nueva/form_ficha_matricula');
	}

    public function buscar_paciente_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $text_buscar = $post['text_buscar']; //cadena a buscar
        $id_tipo = $post['id_tipo']; //id del ciclo
        //print_r($post);exit;

        $this->load->model('citas/Model_consultas_ajax');
        $paciente = $this->Model_consultas_ajax->buscar_paciente($text_buscar , $id_tipo);

        if($paciente) {
            $respt->estado = 'encontrado';

            //para el sexo
            if( $paciente->excel_sexo_paci == 'M'  ) {
                $sexo_string = 'Masculino';
            }else if ( $paciente->excel_sexo_paci == 'F'  ) {
                $sexo_string = 'Femenino';
            }else{
                $sexo_string = 'Sin sexo';
            }
            $paciente->sexo_string = $sexo_string;

            //Para fecha de nacimiento
            $fecha_nacimiento =  new DateTime($paciente->excel_fechaNaci_paci);
            $fecha_nacimiento = $fecha_nacimiento->format('d/m/Y');
            $paciente->fecha_naci_string = $fecha_nacimiento;

            //PARA VER SI POSEE SIS
            $posee_sis = $paciente->posee_sis_paci == 1  ? 'SI' : 'NO';
            $paciente->posee_sis = $posee_sis;

            //Obtener EESS:
            $this->load->model('reutilizables/Model_codigos_renaes');
            $eess = $this->Model_codigos_renaes->obtener_eess($paciente->id_eess_paci );
            $paciente->eess_string = $eess->micro_red_codren;



            //Edad
            $from = new DateTime($paciente->excel_fechaNaci_paci );
            $to   = new DateTime();
            $interval = $from->diff($to);
            $paciente->edad_string = $interval->y;


            $respt->paciente = $paciente;

           // $respt->estudiante->nombre_completo =  $paciente->apellido_paterno_estu . ' ' . $estudiante->apellido_materno_estu . ', ' . $estudiante->nombres_estu;


        }else {
            $respt->estado = 'no_encontrado';
        }

        echo json_encode($respt);

    }

    //Al cambiar el select de Especialidades, poblar el select de profesionales
    public function poblar_profesionales_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $id_especialidad = $post['id_especialidad']; //cadena a buscar

        //print_r($post);exit;

        $this->load->model('citas/Model_consultas_ajax');
        $profesionales = $this->Model_consultas_ajax->buscar_profesionales($id_especialidad);


        $data           = array(); //para el select de los profesionales
        $data_dias = array();     //para mostrar horario y consultorio del profesional
        if($profesionales) {
            foreach ($profesionales as $prof) {
                $profesional['nombres'] = $prof->apellido_pat_user . ' ' .$prof->apellido_mat_user . ', '  . $prof->nombres_user;
                $profesional['id_user'] = $prof->user_id;

                $data[] = $profesional ;
            }


            //obtener horarios de los profesionales
            $this->load->helper('fechas');

            foreach ($profesionales as $prof) {

                $lst_horarios['profesional'] = $prof->apellido_pat_user . ' ' .$prof->apellido_mat_user . ', '  . $prof->nombres_user;

                $dias_atencion =   $this->Model_consultas_ajax->buscar_horarios_profesionales($prof->user_id);
                $horarios = array();
                if($dias_atencion) {
                    foreach ($dias_atencion as $dia){
                        $dia_string = fecha_obtener_nombre_dia_abbr($dia->dias_semana_hora);
                        $horario['horario_consultorio'] = $dia_string . " " . $dia->hora_inicio_hora . " - " . $dia->hora_fin_hora ;
                        $horario['horario_consultorio'] .= " | " .  $dia->nombre_consul;

                        $horarios[] = $horario;
                    }
                }

                $lst_horarios['horarios'] = $horarios;

                $data_dias[] = $lst_horarios;

            }



        }


        $respt->select_profesionales = $data;

        $respt->listado_horarios = $data_dias;


        echo json_encode($respt);

    }

    public function poblar_datepicker_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $id_especialidad = $post['id_especialidad']; //cadena a buscar
        $id_profesional  = $post['id_profesional']; //cadena a buscar

        //print_r($post);exit;

        $this->load->model('citas/Model_consultas_ajax');
        $horario = $this->Model_consultas_ajax->buscar_horario_un_profesional($id_especialidad, $id_profesional);


        $data           = array(); //para el select de los profesionales
        $data_dias = array();     //para mostrar horario y consultorio del profesional
        if($horario) {
            foreach ($profesionales as $prof) {
                $profesional['nombres'] = $prof->apellido_pat_user . ' ' .$prof->apellido_mat_user . ', '  . $prof->nombres_user;
                $profesional['id_user'] = $prof->user_id;

                $data[] = $profesional ;
            }


            //obtener horarios de los profesionales
            $this->load->helper('fechas');

            foreach ($profesionales as $prof) {

                $lst_horarios['profesional'] = $prof->apellido_pat_user . ' ' .$prof->apellido_mat_user . ', '  . $prof->nombres_user;

                $dias_atencion =   $this->Model_consultas_ajax->buscar_horarios_profesionales($prof->user_id);
                $horarios = array();
                if($dias_atencion) {
                    foreach ($dias_atencion as $dia){
                        $dia_string = fecha_obtener_nombre_dia_abbr($dia->dias_semana_hora);
                        $horario['horario_consultorio'] = $dia_string . " " . $dia->hora_inicio_hora . " - " . $dia->hora_fin_hora ;
                        $horario['horario_consultorio'] .= " | " .  $dia->nombre_consul;

                        $horarios[] = $horario;
                    }
                }

                $lst_horarios['horarios'] = $horarios;

                $data_dias[] = $lst_horarios;

            }



        }


        $respt->select_profesionales = $data;

        $respt->listado_horarios = $data_dias;


        echo json_encode($respt);

    }
    
     /** ===================================
     * Reglas de validacion para formulario        
     */       
    private function validacion_reglas_registro_colegio () 
    {               
        //carga la libreria para validar formulario               
        $this->load->library('form_validation');
		$this->config->set_item('language', 'spanish'); 
        
         // ==== para el nombre de colegio =====
        $this->form_validation->set_rules('txt_nombre_colegio', 'Colegio', 'required|trim|min_length[3]|max_length[200]|is_unique[tbl_colegios.nombre_cole]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
        
         //===== para el tipo de colegio ======
         // obtener listado de tipo de colegios 
		$this->load->model('reutilizables/Model_colegios');
        $lst_cole_tipos = $this->Model_colegios->listado_colegio_tipos();
		
		$string_tipo = '';
		foreach ($lst_cole_tipos as $tipo_cole) {
			$string_tipo .= $tipo_cole->id_cole_tipo . ',';
		}		
		$string_tipo = trim($string_tipo, ',');	 		
		
		
    	 $this->form_validation->set_rules('select_cole_tipo', 'Tipo de colegio', 'required|in_list[' . $string_tipo. ']');		
		        
    }










    
}
