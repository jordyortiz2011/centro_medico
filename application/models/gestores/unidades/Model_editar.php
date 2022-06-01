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

    public function obtener_unidad($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_unidades')
            ->where('id_unidad =', $id_registro);

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

    public function editar_unidad($id_registro, $datos)
    {

        //print_r($post); exit;


        $data = array(
            'nombre_unidad'     => $datos['txt_nombre'],
            'comentario_unidad' => $datos['txt_comentario'],

        );


        $query = $this->db->where('id_unidad', $id_registro)
            ->update('tbl_unidades', $data);

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