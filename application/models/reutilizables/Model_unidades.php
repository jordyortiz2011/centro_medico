<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_unidades extends CI_Model {
   
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

    public function listado_unidades()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_unidades')
				->order_by('id_unidad',  'asc');
		
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