<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_codigos_renaes extends CI_Model {
   
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

    public function listado_codigos()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_codigos_renaes')
				->order_by('cod_renaes_codren',  'asc');
		
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
    public function obtener_eess($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_codigos_renaes')
            ->where('id_codigo_renaes  =',  $id_registro);

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