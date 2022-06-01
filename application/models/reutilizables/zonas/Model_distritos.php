<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_distritos extends CI_Model {
   
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

    public function obtener_distritos($id_provincia)
    {            
        
		$query = $this
	            ->db	          
	            ->from('tbl_distritos')
				->order_by('distrito',  'asc')
		        ->where('idProv' , $id_provincia);
		
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

    public function listado_distritos()
    {

        $query = $this
            ->db
            ->from('tbl_distritos')
            ->order_by('distrito',  'asc');

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
    public function obtener_distrito($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_distritos')
            ->where('idDist =',  $id_registro);

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