<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_aulas extends CI_Model {
   
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

    public function listado_aulas($activas = false)
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_aulas')
				->order_by('nombre_aula',  'asc');
				
				//para obtener sólo aulas activas
				if($activas)
				$query = $this->db->where("(estado_aula  = 1 )", NULL, FALSE);
				
		
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
    public function obtener_aula($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_aulas')
            ->where('id_aula =',  $id_registro);

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