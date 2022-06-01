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

    public function obtener_profesional($id_registro)
    {
        $query = $this
            ->db
            ->from('users')
            ->where('user_id =', $id_registro);

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
     * Actualiza registro
     * @param  $User_id = id del usuario a editar  , datos = datos del usuario
     * @return (bool), estado de la actualización
     *  */

    public function editar_profesional($user_id,$datos)
    {


        $query = $this->db->where('user_id = ', $user_id)
                            ->update( 'users' , $datos);

        //echo $this->db->get_compiled_update(); exit;
        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo  $error[message] . 'Error! no se actualizó Registro';
            $result =  FALSE ;
        }else  {
            $result =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;
        }


        return $result;
    }


}