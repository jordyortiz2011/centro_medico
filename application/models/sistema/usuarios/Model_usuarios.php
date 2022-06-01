<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuarios extends MY_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todos los usuarios del sistema     
     * @param  -_-  
     * @return (Objeto) Lista con todos los usuarios registrados en el sistema
     *  */     

    public function listar_usuarios()
    {            
        $res = $this->db->get('users');         
        if (!$res)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           return $res->result();
        }            
    }     

// --------------------------------------------------------------
    /**
     * Obtiene información referente a un usuario   
     * @param  id (int) 
     * @return (Objeto) con todas los datos del usuario
     *  */     

    public function obtener_usuario($user_id)
    {
    	 $query = $this
	            ->db	          
	            ->from( $this->db_table('user_table') )
				->where('user_id =',  $user_id);
		
		//ejectua la consulta
		$query = $this->db->get();	
					        
        if (!$query)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           return $query->row();
        }            
    }   
	
// --------------------------------------------------------------
    /**
     * cambiar la foto de perfil del usuario  
     * @param   (int) user_id
     * @return (bool) estado de subida
     *  */     

    public function actualizar_foto_comensal($user_id , $avatar)
    {
    	
		$datos = array 
					(
					  'avatar'  => $avatar
					);
			
    	$this->db->where('user_id', $user_id);
        $res = $this->db->update('users', $datos); 
         
        if (!$res)
        {
            return false;
            
        }else 
        {                          
           return TRUE;
        }          
    }  
        

}