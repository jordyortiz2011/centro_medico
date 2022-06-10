<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_nueva extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  

    // --------------------------------------------------------------
    /**
     * Guarda registro  en en la BD
     * @param  $post(array)         : datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function registrar_cita( $post )
    {
        //fecha del registro
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i:s');

        $ordenCita = $this->generarOrdenCita($post);

        //Obtener id consultorio
        $this->load->model('reutilizables/Model_consultorios');
        $horario =  $this->Model_consultorios->obtener_consultorio_xCita( $post['select_profesionales'], $post['select_especialidad'], $post['text_fechacita'] );

        //var_dump($post); exit;

        $datos = array(
            'id_paciente_cita'   	    => $post['hidden_id_paciente'],
            'id_profesional_cita'    	=> (int)$post['select_profesionales'],
            'id_consultorio_cita'  	    => $horario->id_consultorio_hora,
            'id_especialidad_cita'  	=> $post['select_especialidad'],
            'fecha_cita'  	            => $post['text_fechacita'],
            'orden_cita'  	            => $ordenCita,

            //meta datos
            'fecha_registro_cita' 	     => $fecha_registro,
            'user_registro_cita'	    => $this->auth_user_id,
        );

        //var_dump($datos); exit;

        $res = $this->db->insert('tbl_citas' , $datos);
        if (!$res)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
           $res =  $this->db->affected_rows() == 1 ?  $ordenCita : FALSE;
           return $res;
        }

        return false;
    }

    public function generarOrdenCita($post){


        $query = $this
            ->db
             ->select("orden_cita")
            ->from('tbl_citas')
            ->where('DATE(fecha_cita) =',  $post['text_fechacita'])
            ->where('id_especialidad_cita =',  (int)$post['select_especialidad'])
            ->where('id_profesional_cita =',  (int)$post['select_profesionales'])
            ->order_by('orden_cita','desc')
        ;

        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();

        $contador = 0; //Contador de las citas
        if($query->num_rows()>0)
        {
            $ultima_cita = $query->row();
            $contador = $ultima_cita->orden_cita  +  1 ;
        }
        else
        {
            $contador = 1;
        }

        return $contador;
    }


}