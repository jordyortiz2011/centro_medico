<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_consultas_ajax extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  

    public function buscar_paciente($text_buscar , $id_tipo)
    {
        //$id_tipo: 1= DNI , 2= ID SIS

        if($id_tipo == 1 ) {
            $query = $this
                ->db
                ->from('tbl_pacientes')
                //->join('tbl_matriculas', 'tbl_matriculas.id_estudiante_matri = tbl_estudiantes.id_estu')
                ->group_start() // Abrir parentesis
                ->where('excel_dni_paci =',  $text_buscar)
                ->group_end() // cerrar parentesis
              ;
        }
        else if ($id_tipo == 2 ) {
            $query = $this
                ->db
                ->from('tbl_pacientes')
                //->join('tbl_matriculas', 'tbl_matriculas.id_estudiante_matri = tbl_estudiantes.id_estu')
                ->group_start() // Abrir parentesis
                ->where('excel_nroFormato_paci =',  $text_buscar)
                ->group_end() // cerrar parentesis
            ;

        }


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

    function buscar_profesionales($id_especialidad)
    {
        $query = $this
            ->db
            ->query("
                   SELECT * FROM `users` 
                    WHERE user_id IN
                        (SELECT `id_profesional_hora` FROM `tbl_horarios`
                         WHERE id_especialidad_hora = $id_especialidad
                        group by `id_especialidad_hora`
                        )
                    and auth_level = 7     
                    order by `apellido_pat_user` asc , `apellido_mat_user` asc          
                  ");

             //->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');

        //echo $this->db->get_compiled_select(); exit;


        if($query->num_rows()>0)
        {
            return $query->result();
            //print_r($query->result()); exit;
        }
        else
        {
            return null;
        }
    }

    function buscar_horarios_profesionales($id_profesional)
    {
        $query = $this
            ->db
            ->select("*")
            ->from("tbl_horarios")
            ->join('tbl_consultorios' , 'tbl_consultorios.id_consultorio = tbl_horarios.id_consultorio_hora' ,'LEFT' )
            ->where('id_profesional_hora' ,$id_profesional )
            ->order_by('dias_semana_hora','asc')
            ->order_by('hora_inicio_hora','asc')

        ;

        //echo $this->db->get_compiled_select(); exit;


        $query = $this->db->get();

        if($query->num_rows()>0)
        {
            return $query->result();
            //print_r($query->result()); exit;
        }
        else
        {
            return null;
        }
    }

    function buscar_horario_un_profesional($id_especialidad, $id_profesional)
    {
        $query = $this
            ->db
            ->select("*")
            ->from("tbl_horarios")
            ->join('tbl_consultorios' , 'tbl_consultorios.id_consultorio = tbl_horarios.id_consultorio_hora' ,'LEFT' )
            ->join('users' , 'users.user_id = tbl_horarios.id_profesional_hora' ,'LEFT' )
            ->where('id_especialidad_hora' ,$id_especialidad )
            ->where('id_profesional_hora' ,$id_profesional )
            ->group_by('users.user_id')
            ->order_by('dias_semana_hora','asc')
            ->order_by('hora_inicio_hora','asc')
        ;

        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();

        if($query->num_rows()>0)
        {
            return $query->result();
            //print_r($query->result()); exit;
        }
        else
        {
            return null;
        }
    }

        

}