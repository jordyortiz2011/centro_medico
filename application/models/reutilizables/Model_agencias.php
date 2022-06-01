<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agencias extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene todas las facultades
     * @param  -_-  
     * @return (Objeto) Lista con todos los tipos de colegios 
     *  */     

    public function listado_agencias()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_agencias')
				->order_by('nombre_agen',  'asc');
		
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
     * Obtiene un registro , de acuerdo a su id
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_agencia($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_agencias')
            ->where('id_agen  =',  $id_registro);

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