<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_empleados extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todos los tipos de Empleados
     * @param  -_-  
     * @return (Objeto) Lista con todos los tipos de unidades
     *  */     

    public function listado_empleados_tipos()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_empleados_tipos')
				->order_by('id_emplea_tipo',  'asc');
		
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
     * Obtiene todos los Empleados
     * @param  -_-  
     * @return (Objeto) Lista con todos los empleados 
     *  */     

    public function listado_empleados($id_tipo = false)
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_empleados')
				->order_by('apellido_pat_emplea',  'asc');
		
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