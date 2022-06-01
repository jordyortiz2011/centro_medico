<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_especialidades extends CI_Model {
   
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

    public function listado_especialidades()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_especialidades')
				->order_by('nombre_espe',  'asc');
		
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
    public function obtener_especialidad($id_especialidad)
    {
        $query = $this
            ->db
            ->from('tbl_especialidades')
            ->where('id_especialidad  =',  $id_especialidad);

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