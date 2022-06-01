<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_profesionales extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todos las unidades
     * @param  -_-  
     * @return (Objeto) Lista con todos los tipos de unidades
     *  */     

    public function listado_profesionales()
    {            
        
		$query = $this
	            ->db	          
	            ->from('users')
                ->where('auth_level', 7)
				->order_by('apellido_pat_user',  'asc');
		
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

    // --------------------------------------------------------------
    /**
     * Obtiene todos las unidades
     * @param  -_-
     * @return (Objeto) Lista con todos los tipos de unidades
     *  */

    public function obtener_especiliadad_xIdUser($id_user)
    {

        $query = $this
            ->db
            ->from('users')
            ->join('tbl_especialidades', 'tbl_especialidades.id_especialidad = users.id_especialidad_user ')
            ->where('auth_level', 7)
            ->where('user_id', $id_user)
           ;

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




}