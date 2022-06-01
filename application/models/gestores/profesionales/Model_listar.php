<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_listar extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

// --------------------------------------------------------------

    /**
     * Obtiene  la cantidad de todos los registros
     * @param  -_-
     * @return (int) total de registros
     *  */
    function allprofesionales_count()
    {
        $query = $this
            ->db
            ->select('count(user_id) as total')
            ->from('users')
            ->where('auth_level' , 7 );  //7= Profesionales


        $query = $this->db->get();
        $res = $query->row();

        return $res->total;
    }

// --------------------------------------------------------------

    /**
     * Obtiene  todos los registros, para paginacion y con ordenamiento
     * @param (int) $limit : cantidad de resultados a mostrar por cada vista de tabla
     * @param (int) $start, : desde que número de registro empezará a mostrarse
     * @param (string) $col : por cual columna se hará el ordnamiento
     * @param (string) $dir : que direccion se aplicará al ordenamiento, ASC O DES
     * @return (obj) todos los registros
     *  */
    function allprofesionales($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->select('*')
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->from('users')
            ->where('auth_level' , 7 );  //7= Profesionales
        //->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');


        //echo $this->db->get_compiled_select(); exit;


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
            //print_r($query->result()); exit;
        } else {
            return null;
        }

    }


// --------------------------------------------------------------

    /**
     * Obtiene  todos los registros,FILTRADO POR UNA CADENA DE BUSQUEDA, para paginacion y con ordenamiento
     * @param (string) $search : CADENA DE BUSQUEDA
     * @param (int) $limit : cantidad de resultados a mostrar por cada vista de tabla
     * @param (int) $start, : desde que número de registro empezará a mostrarse
     * @param (string) $col : por cual columna se hará el ordnamiento
     * @param (string) $dir : que direccion se aplicará al ordenamiento, ASC O DES
     * @return (obj) todos las registros paginado (10 en 10 por defecto) y ordenado
     *  */

    function profesionales_search($search, $search_especialidad, $limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
            ->group_start()// Abrir parentesis
            ->like('nombres_user', $search)
            ->group_end()// cerrar parentesis
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->from('users')
            ->where('auth_level' , 7 );  //7= Profesionales
        //->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');


        //Especialidad
        if( !empty($search_especialidad)) {
           $query = $this->db->where("(id_especialidad_user  = '$search_especialidad' )", NULL, FALSE);
        }


        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

// --------------------------------------------------------------

    /**
     * Obtiene la cantidad de  registros ,FILTRADO POR UNA CADENA DE BUSQUEDA
     * @param (string) $search : CADENA DE BUSQUEDA
     * @return (int) cantidad de registros
     *  */

    function profesionales_search_count($search, $search_especialidad )
    {
        $query = $this
            ->db
            ->select('count(user_id) as total')
            ->group_start()// Abrir parentesis
            ->like('nombres_user', $search)
            ->group_end()// cerrar parentesis
            ->from('users')
            ->where('auth_level' , 7 );  //7= Profesionales
        //->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');


        //Especialidad
        if( !empty($search_especialidad)) {
            $query = $this->db->where("(id_especialidad_user  = '$search_especialidad' )", NULL, FALSE);
        }


        $query = $this->db->get();
        $res = $query->row();

        return $res->total;
    }




    // --------------------------------------------------------------

    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */

    public function eliminar_registro_fisico($id_registro)
    {

        $query = $this->db->where('user_id', $id_registro)
            ->delete('users');


        if (!$query) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false;
        } else {
            $res = $this->db->affected_rows() == 1 ? true : false;
            return $res;
        }


    }

    // --------------------------------------------------------------

    /**
     * Comprueba si una unidad está siendo usada por la matriz
     * @param (int) $id_unidad : id de la unida
     * @return (bool) TRUE: la unidad ya está siendo usada en una matriz
     *                FALSE: la unidad no está siendo usada
     *  */
    function comprobar_unidad($id_unidad)
    {
        $query = $this
            ->db
            ->from('tbl_matriz_relaciones')
            ->where('id_tipo_unidad_rela', $id_unidad);

        //echo $this->db->get_compiled_select(); exit;
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            //return $query->result();
            return true;
        } else {
            return false;
        }
    }

}