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

    public function guardar_paciente($post )
    {
        
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');

        //usuario que está realizando el registro
        $this->load->model('reutilizables/Model_usuarios');
        $usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);

        $datos = array(

         		'id_documento_paci'     => $post['select_tipo_doc'],
                'documento_paci'        => $post['text_num_documento'],
                'nombres_paci'          => $post['text_nombres'],
                'sexo_paci'             => $post['radio_sexo'],
                'fecha_nacimiento_paci' => $post['text_fecha_naci'],
                'provincia_paci '       => $post['text_provincia'],

                'id_sis_paci'           => $post['text_id_sis'],
                'estado_sis_paci'       => $post['select_estado'],
                'fecha_afiliacion_paci' => $post['text_fecha_afiliacion'],
                'fecha_baja_paci'       => $post['text_fecha_baja'],
                
				//meta datos
                'fecha_registro_paci'     => $fecha_registro,
				'id_user_registro_paci'	  =>  $usuario_registrador,
                
        );
        
                    
        $res = $this->db->insert('tbl_pacientes' , $datos);
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