<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_editar extends MY_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
    /**
     * Actualiza datos de un usuario   
     * @param  $User_id = id del usuario a editar  , datos = datos del usuario
     * @return (bool), estado de la actualización
     *  */      
    
     public function editar_usuario($user_id,$datos)
    {
               
                    
       $query = $this->db->where('user_id = ', $user_id)
					     ->update( $this->db_table('user_table') , $datos);	
         
      //echo $this->db->get_compiled_update(); exit;
		if (!$query)
		{
		  $error = $this->db->error(); // Has keys 'code' and 'message'
		  echo  $error[message] . 'Error! no se actualizó Registro';
		  $result =  FALSE ;
		}else  {
		  $result =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;					
		} 
	    
		
		return $result;	       
    }  

}