<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_editar extends CI_Model
{

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

    public function obtener_paciente($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_pacientes')
            ->where('id_paciente =', $id_registro);

        //ejectua la consulta
        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        } else {
            return $query->row();
        }
    }


    /**
     * Actualiza datos del registro
     * @param  $id_registro : Id del registro  $post(array): datos de la membresia
     * @return (bool) estado de la actualizacion
     *  */

    public function editar_paciente($id_registro, $post)
    {

        //print_r($post); exit;


        $data = array(

            'excel_idTipoDoc_paci ' => $post['select_tipo_doc'],
            'excel_dni_paci'        => $post['text_num_documento'],
            'excel_asegurado_paci'  => $post['text_nombres'],
            'id_eess_paci'          => $post['select_establecimiento'],
            'excel_sexo_paci'       => $post['radio_sexo'],
            'excel_fechaNaci_paci'  => $post['text_fecha_naci'],
            'codHistorial_paci'       => $post['text_historial'],


            'posee_sis_paci'        => $post['checkbox_posee_sis'],


            'excel_idSis_paci'              => $post['text_id_sis'],
            'excel_nroFormato_paci'         => $post['text_numformato'],
            'excel_estado_paci'             => $post['select_estado'],
            'excel_fechaAfiliacion_paci'    => $post['text_fecha_afiliacion'],
            'excel_fechaBaja_paci'          => $post['text_fecha_baja']

        );


        $query = $this->db->where('id_paciente', $id_registro)
                          ->update('tbl_pacientes', $data);

        //echo $this->db->get_compiled_update(); exit;
        if (!$query) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo $error[message] . 'Error! no se actualizó Registro';
            return FALSE;
        } else {
            $res = $this->db->affected_rows() == 1 ? TRUE : FALSE;
            return $res;
        }


        return $result;


    }


}