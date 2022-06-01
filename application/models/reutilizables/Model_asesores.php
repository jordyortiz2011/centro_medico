<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_asesores extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todas los asesores
     * @param  -_-  
     * @return (Objeto) Lista con todos los usuarios asesores
     *  */     

    public function listado_asesores($id_agencia)
    {            
        
		$query = $this
	            ->db	          
	            ->from('users')
                ->where('auth_level  =', 7) //7= Asesor de crédito
                ->where('id_agencia_user  =',  $id_agencia)
				->order_by('apellido_pat_user',  'asc')
                ->order_by('apellido_mat_user ',  'asc')
                ->order_by('nombres_user',  'asc');
		
		//ejectua la consulta
		$query = $this->db->get();	
		       
        if (!$query)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           return $query->result();
        }            
    }



}