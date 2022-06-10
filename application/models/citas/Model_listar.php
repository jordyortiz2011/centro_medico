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
    function allcitas_count()
    {
        $query = $this
            ->db
            ->select('count(id_cita) as total')
            ->from('tbl_citas');


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
    function allcitas($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->select('*')
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->from('tbl_citas')
            ->join('tbl_consultorios', 'tbl_consultorios.id_consultorio = tbl_citas.id_consultorio_cita', 'left')
            ->join('tbl_pacientes', 'tbl_pacientes.id_paciente = tbl_citas.id_paciente_cita', 'left')
            ->join('tbl_especialidades', 'tbl_especialidades.id_especialidad = tbl_citas.id_especialidad_cita', 'left')
        ;
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

    function citas_search($search, $search_fechacita,  $limit, $start, $col, $dir)
    {

        $query = $this
            ->db
            ->select('*')
            ->from('tbl_citas')
            ->join('tbl_consultorios', 'tbl_consultorios.id_consultorio = tbl_citas.id_consultorio_cita', 'left')
            ->join('tbl_pacientes', 'tbl_pacientes.id_paciente = tbl_citas.id_paciente_cita', 'left')
            ->join('tbl_especialidades', 'tbl_especialidades.id_especialidad = tbl_citas.id_especialidad_cita', 'left')
            ->group_start()// Abrir parentesis
            ->like('excel_asegurado_paci', $search)
            ->group_end()// cerrar parentesis
            ->limit($limit, $start)
            ->order_by($col, $dir)

        ;


        //fecha cita
        if(  $search_fechacita != '') {
           $query = $this->db->where("(fecha_cita  = '$search_fechacita' )");
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

    function citas_search_count($search, $search_fechacita)
    {
        $query = $this
            ->db
            ->select('count(id_cita) as total')
            ->from('tbl_citas')
            ->join('tbl_consultorios', 'tbl_consultorios.id_consultorio = tbl_citas.id_consultorio_cita', 'left')
            ->join('tbl_pacientes', 'tbl_pacientes.id_paciente = tbl_citas.id_paciente_cita', 'left')
            ->join('tbl_especialidades', 'tbl_especialidades.id_especialidad = tbl_citas.id_especialidad_cita', 'left')
            ->group_start()// Abrir parentesis
            ->like('excel_asegurado_paci', $search)
            ->group_end()// cerrar parentesis
        ;


        //fecha cita
        if(  $search_fechacita != '') {
            $query = $this->db->where("(fecha_cita  = '$search_fechacita' )");
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

    public function eliminar_paciente_fisico($id_registro)
    {

        $query = $this->db->where('id_paciente', $id_registro)
            ->delete('tbl_pacientes');


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