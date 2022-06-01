<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_secuencias extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }



    // --------------------------------------------------------------
    /**
     * Obtiene una matriz , de acuerdo al id de una solicitud
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */
    public function obtener_secuencia_xIdSolicitud($id_solicitud)
    {
        $query = $this
            ->db
            ->from('tbl_secuencias')
            ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_secuencias.id_solicitud_secuencia')
            ->where('id_solicitud_secuencia =',  $id_solicitud);

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