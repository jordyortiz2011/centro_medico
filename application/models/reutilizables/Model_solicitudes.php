<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_solicitudes extends CI_Model {
   
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
    public function obtener_solicitud_xID($id_registro)
    {
        $query = $this
                    ->db
                    ->from('tbl_solicitudes')
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
	




}