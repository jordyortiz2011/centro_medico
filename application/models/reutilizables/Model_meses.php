<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_meses extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todos los meses
     * @param  -_-  
     * @return (Objeto) Lista con todos meses
     *  */     

    public function listado_meses()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_meses')
				->order_by('id_mes',  'asc');
		
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