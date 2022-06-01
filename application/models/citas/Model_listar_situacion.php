<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_listar_situacion extends CI_Model {
   
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
	function allmatriculas_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_matri) as total')
                ->from('tbl_matriculas')
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
                ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
                ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
                ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
                ;


				
		
		$query = $this->db->get();		
		$res   =  $query->row();
		
	    return $res->total;  	 	
	}

// --------------------------------------------------------------
    /**
     * Obtiene  todos los registros, para paginacion y con ordenamiento   
     * @param (int) $limit : cantidad de resultados a mostrar por cada vista de tabla
	 * @param (int) $start, : desde que número de registro empezará a mostrarse
	 * @param (string) $col : por cual columna se hará el ordnamiento
	 * @param (string) $dir : que direccion se aplicará al ordenamiento, ASC O DES
     * @return (obj) todos los comensales
     *  */  
	function allmatriculas($limit,$start,$col,$dir)
    {   
       /* $query = $this
                ->db
                 ->select('*')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_matriculas')
				->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
                ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
                ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
               ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
           ; */

        $query = $this
            ->db
            ->select("*, 
                      costo_matri - ((costo_matri * descuento_pago_mod)/100)  total_pagar,
                      SUM(monto_recibo_pago) total_importe_actual
                      ")
            ->limit($limit,$start)
            ->order_by($col,$dir)
            ->from("tbl_matriculas")
            ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
            ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
            ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
            ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
            ->join('tbl_pagos' , 'tbl_pagos.id_matricula_pago = tbl_matriculas.id_matri' ,'LEFT' )
            ->group_by('id_matri')
        ;

        //Agregar más nivel de ordenamiento al nombre completo del estudiante
        if( $col == 'apellido_paterno_estu') {
            $query = $this->db->order_by('apellido_materno_estu', 'ASC');
            $query = $this->db->order_by('nombres_estu', 'ASC');
        }




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
	
	 function matriculas_search($search, $search_situacion, $search_ciclo, $search_turno, $search_aula,     $limit,$start,$col,$dir )
    {
        /*$query = $this
                ->db
                 //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
                ->group_start() // Abrir parentesis
                ->like('nombres_estu',$search)
                ->or_like('apellido_paterno_estu',$search)
                ->or_like('apellido_materno_estu',$search)
                ->or_like('codigo_matri',$search)
                ->or_like('nombre_aula_cicloaula',$search)
                ->or_like('dni_estu',$search)
                ->group_end() // cerrar parentesis
			    ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_matriculas')
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
                ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
                ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
                ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
            ; */

        $query = $this
            ->db
            ->select("*, 
                      costo_matri - ((costo_matri * descuento_pago_mod)/100)  total_pagar,
                      SUM(monto_recibo_pago) total_importe_actual
                      ")
            ->limit($limit,$start)
            ->order_by($col,$dir)
            ->from("tbl_matriculas")
            ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
            ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
            ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
            ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
            ->join('tbl_pagos' , 'tbl_pagos.id_matricula_pago = tbl_matriculas.id_matri' , 'LEFT')

            ->group_start() // Abrir parentesis
            ->like('nombres_estu',$search)
            ->or_like('apellido_paterno_estu',$search)
            ->or_like('apellido_materno_estu',$search)
            ->or_like('codigo_matri',$search)
            ->or_like('nombre_aula_cicloaula',$search)
            ->or_like('dni_estu',$search)
            ->group_end() // cerrar parentesis

            ->group_by('id_matri')
        ;

                //Agregar más nivel de ordenamiento al nombre completo del estudiante
                if( $col == 'apellido_paterno_estu') {
                    $query = $this->db->order_by('apellido_materno_estu', 'ASC');
                    $query = $this->db->order_by('nombres_estu', 'ASC');
                }

                //situacion
                if( !empty($search_situacion)) {

                    //Cancelado
                    if ($search_situacion == 1) {
                        $query = $this->db->having("(total_pagar  = total_importe_actual  )", NULL, FALSE);
                    }
                    //Debe
                    else if ($search_situacion == 2) {
                        $query = $this->db->having("(total_pagar  > total_importe_actual  )", NULL, FALSE);
                    }

                }
			
				//ciclo
				if( !empty($search_ciclo)) {
				   $query = $this->db->where("(id_ciclo_matri  = '$search_ciclo' )", NULL, FALSE);
				}

                //turno
                if( !empty($search_turno)) {
                    $query = $this->db->where("(tbl_ciclos_aulas.id_turno  = '$search_turno' )", NULL, FALSE);
                }

                //aula
                if( !empty($search_aula)) {
                    $query = $this->db->where("(tbl_ciclos_aulas.id_cicloaula  = '$search_aula' )", NULL, FALSE);
                }


				
        $query = $this->db->get();
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
	
// --------------------------------------------------------------
    /**
     * Obtiene la cantidad de  registros ,FILTRADO POR UNA CADENA DE BUSQUEDA 
	 * @param (string) $search : CADENA DE BUSQUEDA
     * @return (int) cantidad de registros
     *  */  	
	
	function matriculas_search_count($search, $search_situacion,  $search_ciclo, $search_turno, $search_aula)
    {
       /* $query = $this
                ->db
                ->select('count(id_matri) as total')

                ->group_start() // Abrir parentesis
                ->like('nombres_estu',$search)
                ->or_like('apellido_paterno_estu',$search)
                ->or_like('apellido_materno_estu',$search)
                ->or_like('codigo_matri',$search)
                ->or_like('nombre_aula_cicloaula',$search)
                ->or_like('dni_estu',$search)
                ->group_end() // cerrar parentesis

                ->from('tbl_matriculas')
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
                ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
                ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
                ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
            ; */

            $query = $this
                ->db
                ->select("*, 
                      costo_matri - ((costo_matri * descuento_pago_mod)/100)  total_pagar,
                      SUM(monto_recibo_pago) total_importe_actual
                      ")
                ->from("tbl_matriculas")
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri')
                ->join('tbl_ciclos_aulas', 'tbl_ciclos_aulas.id_cicloaula = tbl_matriculas.id_cicloaula_matri')
                ->join('tbl_pagos_modalidades' , 'tbl_pagos_modalidades.id_pago_mod = tbl_matriculas.id_pago_modalidad_matri')
                ->join('tbl_ciclos' , 'tbl_ciclos.id_ciclo = tbl_matriculas.id_ciclo_matri' )
                ->join('tbl_pagos' , 'tbl_pagos.id_matricula_pago = tbl_matriculas.id_matri' , 'LEFT' )

                ->group_start() // Abrir parentesis
                ->like('nombres_estu',$search)
                ->or_like('apellido_paterno_estu',$search)
                ->or_like('apellido_materno_estu',$search)
                ->or_like('codigo_matri',$search)
                ->or_like('nombre_aula_cicloaula',$search)
                ->or_like('dni_estu',$search)
                ->group_end() // cerrar parentesis

                ->group_by('id_matri')
            ;

                //situacion
                if( !empty($search_situacion)) {

                    //Cancelado
                    if ($search_situacion == 1) {
                        $query = $this->db->having("(total_pagar  = total_importe_actual  )", NULL, FALSE);
                    }
                    //Debe
                    else if ($search_situacion == 2) {
                        $query = $this->db->having("(total_pagar  > total_importe_actual  )", NULL, FALSE);
                    }

                }

                //ciclo
                if( !empty($search_ciclo)) {
                    $query = $this->db->where("(id_ciclo_matri  = '$search_ciclo' )", NULL, FALSE);
                }

                //turno
                if( !empty($search_turno)) {
                    $query = $this->db->where("(tbl_ciclos_aulas.id_turno  = '$search_turno' )", NULL, FALSE);
                }

                //aula
                if( !empty($search_aula)) {
                    $query = $this->db->where("(tbl_ciclos_aulas.id_cicloaula  = '$search_aula' )", NULL, FALSE);
                }


        //echo $this->db->get_compiled_select(); exit;
				
				
    	$query = $this->db->get();		
		//$res   =  $query->row();
		
	    //return $res->total;
        return $query->num_rows();
    }
	
	
	
	
  // --------------------------------------------------------------
/**
 * Elimina un registro   (eliminado físico)
 * @param  $id_registro
 * @return (bool)
 *  */
    public function eliminar_matricula_fisico($id_registro)
    {

       $query =	$this->db->where('id_matri', $id_registro)
				  		 ->delete('tbl_matriculas');

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

    /**
     * Decrementa en 1 el contador de alumnos matriculados en el aula
     * @param  $aula(obj): Objeto de datos del aula a incrementar
     * @return (bool) TRUE   = incremento correcto
     *                FALSE  = error al incrementar
     *  */
    public function decrementar_contador_alumnos_xAula($aula)
    {
        /*$query = $this->db->set('cant_actual_alumnos_cicloaula' , 'cant_actual_alumnos_cicloaula + 1')
                            ->where('id_cicloaula' , $aula->id_cicloaula)
                            ->update('tbl_ciclos_aulas') ;*/

        $query = $this->db->query("UPDATE tbl_ciclos_aulas SET `cant_actual_alumnos_cicloaula`=(`cant_actual_alumnos_cicloaula`-1) WHERE `id_cicloaula` = '$aula'");


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

    // --------------------------------------------------------------

    /**
     * Comprueba si una el registro está siendo usado por otra tabla (tbl_pagos),
     * para el correcto eliminado
     * @param (int) $id_registro(int) : id del registro
     * @return (bool) TRUE: el registro ya está siendo usado
     *                FALSE: el registro NO se usa
     *  */
    function comprobar_registro_usado_pagos($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_pagos')
            ->where('id_matricula_pago', $id_registro);

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