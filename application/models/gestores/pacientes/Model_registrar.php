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

        //var_dump($post['text_id_sis']) ;  exit;

        $datos = array(

         		'excel_idTipoDoc_paci ' => $post['select_tipo_doc'],
                'excel_dni_paci'        => $post['text_num_documento'],
                'excel_asegurado_paci'  => $post['text_nombres'],
                'id_eess_paci'          => $post['select_establecimiento'],
                'excel_sexo_paci'       => $post['radio_sexo'],
                'excel_fechaNaci_paci'  => $post['text_fecha_naci'],
                'codHistorial_paci'       => $post['text_historial'],

                'posee_sis_paci'        => $post['checkbox_posee_sis'],

                'excel_idSis_paci'              => $post['text_id_sis'],
                'excel_nroFormato_paci'         => $post['text_numformato'],
                'excel_estado_paci'             => $post['select_estado'],
                'excel_fechaAfiliacion_paci'    => $post['text_fecha_afiliacion'],
                'excel_fechaBaja_paci'          => $post['text_fecha_baja'],
                
				//meta datos
                'fecha_registro_paci'     => $fecha_registro,
				'user_registro_paci'	  =>  $usuario_registrador,
                
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