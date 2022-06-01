<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_niveles_tecnologicos extends CI_Model {
   
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

    public function listado_niveles_tecnologicos()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_niveles_tecnologicos')
				->order_by('id_nivel_tecno',  'asc');
		
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