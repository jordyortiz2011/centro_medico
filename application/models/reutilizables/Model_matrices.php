<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_matrices extends CI_Model {
   
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
    public function obtener_matriz_xID($id_registro)
    {
        $query = $this
                    ->db
                    ->from('tbl_matriz')
                    ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_matriz.id_solicitud_matriz')
                    ->join('tbl_agencias', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli')
                    ->where('id_matriz =',  $id_registro);

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
     * Obtiene una matriz , de acuerdo al id de una solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_matriz_xIdSolicitud($id_solicitud)
    {
        $query = $this
            ->db
            ->from('tbl_matriz')
            ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_matriz.id_solicitud_matriz')
            ->where('id_solicitud_matriz =',  $id_solicitud);

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