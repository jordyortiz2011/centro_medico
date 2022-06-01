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





    // --------------------------------------------------------------
    /**
     * Ejecutado al Cambiar el select de Aulas
     * @param
     * @return (Objeto) Parametros para el FullCalendar
     *  */
    public function combobox_fullCalendar(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();

        $id_consultorio       = $post['id_consultorio']; //id del ciclo


        //print_r($post);exit;

       //Obtener datos del consultorio
        $this->load->model('reutilizables/Model_consultorios');
        $consultorio = $this->Model_consultorios->obtener_consultorio($id_consultorio);
        $respt->consultorio  = $consultorio;


        //Configuración parametros personalizados para el FullCalendar
        //Hora de inicio/fin mañana
        $parametros = new stdClass(); //Parametros para el fullCalendar

        $hora_inicio =  new DateTime($consultorio->hora_inicio_consul);
        $hora_inicio = $hora_inicio->format('H');
        $hora_inicio .=  ':00:00';

        $hora_fin =  new DateTime($consultorio->hora_fin_consul);
        $hora_fin->add(new DateInterval("PT2H"));
        $hora_fin = $hora_fin->format('H');
        $hora_fin .=  ':00:00';



        $parametros->hora_inicio    = $hora_inicio;
        $parametros->hora_fin       = $hora_fin;

        $respt->parametros = $parametros;


        $respt->titulo_fullcalendar = $consultorio->nombre_consul;


        echo json_encode($respt);

    }


    // --------------------------------------------------------------
    /**
     * Ejecutado al Cambiar el select de Aulas
     * @param
     * @return (Objeto) Parametros para el FullCalendar
     *  */
    public function mostrar_especialidad(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();

        $id_profesional       = $post['id_profesional']; //id del ciclo


        //print_r($post);exit;

        //Obtener datos del consultorio
        $this->load->model('reutilizables/Model_profesionales');
        $profesional = $this->Model_profesionales->obtener_especiliadad_xIdUser($id_profesional);
        $respt->id_especialidad  = $profesional->id_especialidad;
        $respt->especialidad      = $profesional->nombre_espe;


        echo json_encode($respt);

    }







    
}
