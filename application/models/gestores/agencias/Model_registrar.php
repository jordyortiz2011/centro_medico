<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_registrar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Guarda colegio en en la BD   
     * @param  $datos(array): datos POST del formulario, 
	 * @param  $usuario: nombre del usuario que está guardando el registro
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */     

    public function guardar_agencia ($post )
    {
        
        $fecha          =   new DateTime();
        $fecha_registro =   $fecha->format('Y-m-d H:i');
        
        $datos = array(
         		'nombre_agen'           => $post['txt_nombre'],
                
				//meta datos
                'fecha_registro_agen' 	=> $fecha_registro,
				'id_user_registro_agen'	=> $this->auth_user_id, //id del usuario que registra
                
        );
        
                    
        $res = $this->db->insert('tbl_agencias' , $datos);
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