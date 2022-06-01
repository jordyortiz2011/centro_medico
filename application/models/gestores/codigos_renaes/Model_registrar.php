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

    public function guardar_codigo($datos )
    {
        
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');

        //usuario que está realizando el registro
        $this->load->model('reutilizables/Model_usuarios');
        $usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);

        $datos = array(
         		'cod_renaes_codren'         => $datos['text_cod_renaes'],
                'micro_red_codren'          => $datos['text_micro'],
                'distrito_codren'           => $datos['text_distrito'],
                'codexcel_codren'           => $datos['text_codexcel'], //Codigo renaes de excel

				//meta datos
                'fecha_registro_codren'     => $fecha_registro,
				'id_user_registro_codren'	=> $this->auth_user_id,
                
        );
        
                    
        $res = $this->db->insert('tbl_codigos_renaes' , $datos);
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