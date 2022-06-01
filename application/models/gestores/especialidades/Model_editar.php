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

    public function obtener_especialidad($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_especialidades')
            ->where('id_especialidad =', $id_registro);

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

    public function editar_especialidad($id_registro, $post)
    {

        //print_r($post); exit;


        $data = array(
            'nombre_espe'              => $post['text_nombre'],
            'color_espe'              => $post['text_color'],
            'descripcion_espe'          => $post['text_descripcion'],

        );


        $query = $this->db->where('id_especialidad', $id_registro)
                          ->update('tbl_especialidades', $data);

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