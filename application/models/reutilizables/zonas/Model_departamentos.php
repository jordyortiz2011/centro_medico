<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_departamentos extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       

	
	// --------------------------------------------------------------
    /**
     * Obtiene todas las aulas
     * @param  $activas(bool)  : TRUE = solo devuelve aulas activas 
     * @return (Objeto) Lista con todos los unidades
     *  */     

    public function listado_departamentos()
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_departamentos')
				->order_by('departamento',  'asc');
		
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
    public function obtener_departamento($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_departamentos')
            ->where('idDepa =',  $id_registro);

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