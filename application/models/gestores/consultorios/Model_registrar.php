<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_registrar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Guarda unidad en en la BD
     * @param  $datos(array): datos POST del formulario, 
	 * @param  $usuario: nombre del usuario que está guardando el registro
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */     

    public function guardar_consultorio($datos )
    {
        
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');

        //usuario que está realizando el registro
        //$this->load->model('reutilizables/Model_usuarios');
        //$usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);

        //establecer formato de BD a las horas
        $datos['text_hora_inicio'] = '2019-01-01 '. $datos['text_hora_inicio'] . ':00';
        $datos['text_hora_fin']  = '2019-01-01 '. $datos['text_hora_fin'] . ':00';


        $datos = array(
         		'nombre_consul'          => $datos['text_nombre'],
                'hora_inicio_consul'     => $datos['text_hora_inicio'],
                'hora_fin_consul'        => $datos['text_hora_fin'],


                
				//meta datos
                'fecha_registro_consul'     => $fecha_registro,
				//'id_user_registro_codren'	=> $this->auth_user_id,
                
        );
        
                    
        $res = $this->db->insert('tbl_consultorios' , $datos);
        if (!$res)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           if( $this->db->affected_rows() == 1 )
                 return true;
        }
        
        return false;            
    }       
        

}