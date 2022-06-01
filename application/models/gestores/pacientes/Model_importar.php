<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_importar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }


    function comprobar_paciente_xIdSIS($id_paciente)
    {
        $query = $this
            ->db
            ->from('tbl_pacientes')
            ->where('excel_idSis_paci', $id_paciente);

        //echo $this->db->get_compiled_select(); exit;
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            //return $query->result();
            return true;
        } else {
            return false;
        }
    }

    /*Comprueba si existe el código renaes  EESS en la BD */
    function comprobar_codExcel_EESS($codigo)
    {
        $query = $this
            ->db
            ->from('tbl_codigos_renaes')
            ->where('codexcel_codren', $codigo);

        //echo $this->db->get_compiled_select(); exit;
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            //return $query->result();
            return true;
        } else {
            return false;
        }
    }

    public function obtener_codigo_renaes($eess)
    {
        $query = $this
            ->db
            ->from('tbl_codigos_renaes')
            ->where('codexcel_codren =', $eess);

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