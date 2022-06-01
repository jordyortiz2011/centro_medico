<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_provincias extends CI_Model {
   
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

    public function obtener_provincias($id_departamento)
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_provincias')
				->order_by('provincia',  'asc')
		        ->where('idDepa' , $id_departamento);
		
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
     * Obtiene todas las aulas
     * @param  $activas(bool)  : TRUE = solo devuelve aulas activas
     * @return (Objeto) Lista con todos los unidades
     *  */

    public function listado_provincias()
    {

        $query = $this
            ->db
            ->from('tbl_provincias')
            ->order_by('provincia',  'asc');

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
    public function obtener_provincia($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_provincias')
            ->where('idProv =',  $id_registro);

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