<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_editar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene un registro , de acuerdo a su id     
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_solicitud($id_registro)
    {            
        $query = $this
	            ->db	
	            //->select("")
	            ->from('tbl_solicitudes')
                ->join('tbl_agencias', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli')
				->where('id_soli =',  $id_registro);
		
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

    // --------------------------------------------------------------
    /**
     * Obtiene los datos de la TABLA DEUDA asociado a la solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */

    /*public function obtener_tabla_deuda($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_deuda')
            ->where('id_solicitud_soli_d =',  $id_registro);

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
    } */

    public function obtener_tabla_deuda_titular($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_deuda_titular')
            ->where('id_solicitud_deuti =',  $id_registro);

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

    public function obtener_tabla_deuda_conyuge($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_deuda_conyuge')
            ->where('id_solicitud_deucon =',  $id_registro);

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
     * Obtiene los datos de la TABLA CULTIVO asociado a la solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_tabla_cultivo($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_cultivo')
            ->where('id_solicitud_soli_c =',  $id_registro);

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
     * Obtiene los datos de la TABLA PECUARIA asociado a la solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_tabla_pecuaria($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_pecuaria')
            ->where('id_solicitud_soli_p =',  $id_registro);

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
     * Obtiene los datos de la TABLA DERIVADOS asociado a la solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_tabla_derivados($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_derivados')
            ->where('id_solicitud_soli_der =',  $id_registro);

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
     * Obtiene los datos de la TABLA OTRAS ACTIVIDADES asociado a la solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_tabla_otras($id_registro)
    {
        $query = $this
            ->db
            //->select("")
            ->from('tbl_solicitudes_otras')
            ->where('id_solicitud_soli_o =',  $id_registro);

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
 * cambia el estado de una solicitud de "en proceso" a: APROBADA o RECHAZADA
 * @param  $id_registro: Id del registro  $post(array): datos de la membresia
 * @return (bool) estado de la actualizacion
 *  */ 	
	
	public function verificar_solicitud($id_registro, $post)
    {
    	
		//print_r($post); exit;
        $fecha              =   new DateTime();
        $fecha_verificacion =   $fecha->format('Y-m-d H:i');
       	
		  $data = array(
         		'id_estado_soli'            => $post['btn_verificar'],
                'fecha_verificacion_soli'   => $fecha_verificacion ,

            );
		
				        
        $query = $this->db->where('id_soli' , $id_registro)
        				  ->update('tbl_solicitudes',$data ) ;
						  
		//echo $this->db->get_compiled_select(); exit;
         
       	if (!$this->db->affected_rows()) {
		    echo  'Error! no se actualizó registro';
			return false;
		} else {
		    $result = true;
		}
		
		return $result;	            
    } 
	
   

}