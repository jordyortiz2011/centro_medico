<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_full_calendar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene  los eventos del sistema dinamicamente    
     * @param  -_-  
     * @return objeto de eventos
     *  */     
	public function obtener($post)
	{
		
	//$sql = "SELECT * FROM tbl_calendario_sin_atencion WHERE start BETWEEN ? AND ? ORDER BY start ASC";
	//return $this->db->query($sql, array($_POST['start'], $_POST['end']))->result();

        $fecha_inicio  =  new DateTime($post['start']);
        $fecha_inicio  = $fecha_inicio->format('Y-m-d');

        $fecha_fin  =  new DateTime($post['end']);
        $fecha_fin  = $fecha_fin->format('Y-m-d');

		 $query = $this
                ->db
                ->from('tbl_horarios ')
				->join('tbl_especialidades', 'tbl_especialidades.id_especialidad = tbl_horarios.id_especialidad_hora'  )
                ->join('users', 'users.user_id = tbl_horarios.id_profesional_hora' , 'left' )
                 ->where('fecha_fin_hora   >=', $fecha_fin)
                //->where('fecha_inicio_ciclohora >=', $fecha_inicio)
                 ->where('id_consultorio_hora =' , $post['id_consultorio'])
                 /*->or_group_start() // Abrir parentesis
                 ->where('id_ciclo_ciclohora =' , $post['id_ciclo'])
                 ->where('id_turno_ciclohora   = ' ,$post['id_turno'])
                 ->where('id_curso_ciclohora   = ' , 8) //para los recreos
                 ->group_end() // cerrar parentesis*/
                ->order_by('fecha_fin_hora','ASC')
                ;

		 //echo 'hola mundo';

          //echo $this->db->get_compiled_select(); exit;

				
		 $query = $this->db->get();
		 
		 return $query->result();  		

	}

	Public function agregar($post)
	{

	/*$sql = "INSERT INTO tbl_calendario_sin_atencion (titulo,descripcion, fecha_inicio,fecha_fin, color, id_tipo_evento) VALUES (?,?,?,?,?,?)";
	$this->db->query($sql, array($_POST['title'], $_POST['description'] ,  $_POST['start'],$_POST['start'], '#e50e2c' ,$_POST['tipo_evento'] )); //para que solo defina un día start / end( antiguo) */
		//return ($this->db->affected_rows()!=1)?false:true;
    /*
		if($this->db->affected_rows()!=1) {
			return false;
		}else {
			
			$this->incrementar_dia( $_POST['start']);
			return true;
			
		}*/

        $fecha          =   new DateTime();
        $fecha_registro =   $fecha->format('Y-m-d H:i');

        //usuario que está realizando el registro
        $this->load->model('reutilizables/Model_usuarios');
        //$nombre_usuario = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);

        $datos = array(
            'id_consultorio_hora'            => $post['id_consultorio'],
            'fecha_inicio_hora'        => $post['hidden_fecha_inicio'],
            'fecha_fin_hora'           => $post['hidden_fecha_fin'],
            'hora_inicio_hora'         => $post['text_hora_inicio'],
            'hora_fin_hora'            => $post['text_hora_fin'],
            'id_profesional_hora'      => $post['id_profesional'],
            'id_especialidad_hora'     => $post['id_especialidad'],
            'dias_semana_hora'         => $post['dias_semana'], //Qué día de la semana se repetirá 1=Domingo


            //meta datos
            //'fecha_registro_ciclohora' 	=> $fecha_registro,
            //'id_user_registro_ciclohora'	=> $this->auth_user_id,

        );


        $res = $this->db->insert('tbl_horarios' , $datos);
        if (!$res)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
            if( $this->db->affected_rows() == 1 )
                return true;
        }

        return false;

    }

	
    Public function actualizar($post)
	{

	/*$sql = "UPDATE tbl_calendario_sin_atencion SET titulo = ?, descripcion = ? , id_tipo_evento = ?   WHERE id = ?";
	$this->db->query($sql, array($_POST['title'],$_POST['description'], $_POST['tipo_evento'], $_POST['id']));
		return ($this->db->affected_rows()!=1)?false:true;*/

        //print_r($post); exit;

        $data = array(
            'hora_inicio_hora'    	    => $post['text_hora_inicio'],
            'hora_fin_hora'   		    => $post['text_hora_fin'],
            'id_profesional_hora'    	=> $post['id_profesional'],
            'id_especialidad_hora'   	=> $post['id_especialidad'],
            'id_consultorio_hora'       => $post['id_consultorio']


        );


        $query = $this->db->where('id_horario' , $post['id_registro'])
            ->update('tbl_horarios',$data ) ;

        //echo $this->db->get_compiled_update(); exit;
        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo  $error[message] . 'Error! no se actualizó Registro';
            return FALSE ;
        }else  {
            $res =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;
            return $res;
        }


        return $result;
    }


    Public function eliminar($post)
    {

        /*$sql = "DELETE FROM tbl_calendario_sin_atencion WHERE id = ?";
        $this->db->query($sql, array($_GET['id']));
        //return ($this->db->affected_rows()!=1)?false:true;
        if($this->db->affected_rows()!=1) {
            return false;
        }else {
            $this->decrementar_dia( $_GET['start']);
            return true;
        } */

        $query =	$this->db->where('id_horario', $post['id_registro'])
                             ->delete('tbl_horarios');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $res =  $this->db->affected_rows() == 1 ?  true : false;
            return $res;
        }
    }


        

}