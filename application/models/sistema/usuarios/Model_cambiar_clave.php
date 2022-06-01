<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cambiar_clave extends MY_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  

// --------------------------------------------------------------
    /**
     * actualiza la contraseña del usuario logueado 
     * @param   (int) user_id
     * @return (bool) estado de subida
     *  */     

    public function actualizar_clave($user_id , $clave)
    {
    	
		$datos = array 
					(
					  'passwd'  => $clave
					);
			
    	$this->db->where('user_id', $user_id);
        $res = $this->db->update( $this->db_table('user_table') , $datos); 
         
        if (!$res)
        {
            return false;
            
        }else 
        {                          
           return TRUE;
        }          
    }  
        

}