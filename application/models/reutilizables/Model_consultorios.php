<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_consultorios extends CI_Model {
   
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

    public function listado_consultorios()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_consultorios')
				->order_by('id_consultorio',  'asc');
		
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

    /**
     * Obtiene un registro , de acuerdo a su id
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_consultorio($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_consultorios')
            ->where('id_consultorio =', $id_registro);

        //ejectua la consulta
        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        } else {
            return $query->row();
        }
    }



}