<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_listar extends CI_Model {
   
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
	function allsolicitudes_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_soli) as total')
	            ->from('tbl_solicitudes')
                ->join('tbl_agencias ', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli');
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
	function allsolicitudes($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                 ->select('*')
                ->limit($limit,$start)
                ->order_by($col,$dir)
               ->from('tbl_solicitudes')
               ->join('tbl_agencias ', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli');
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
	
	 function solicitudes_search($search,  $search_estado, $search_agencia,      $limit,$start,$col,$dir )
    {
        $query = $this
                ->db
                 //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
                ->group_start() // Abrir parentesis
                ->like('dni_titular_soli',$search)
				->or_like('nombres_titular_soli',$search)
				->or_like('apellido_pat_titular_soli',$search)
				->or_like('apellido_mat_titular_soli',$search)
                ->or_like('id_soli',$search)
				->group_end() // cerrar parentesis
			    ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_solicitudes')
                ->join('tbl_agencias ', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli');
                ;
			
				//estado
				if( !empty($search_estado)) {
				   $query = $this->db->where("(id_estado_soli  = $search_estado )", NULL, FALSE);
				}

                //Agencia
                if( !empty($search_agencia)) {
                    $query = $this->db->where("(id_agencia_soli  = $search_agencia )", NULL, FALSE);
                }

                //=== aplicar filtros adicionales de acuerdo al usuario ==
                //Articulador
                if( $this->auth_level == 3  ) {
                    $query = $this->db->where("(id_user_articulador_soli  = $this->auth_user_id )", NULL, FALSE);
                }
                //Asesor
                if( $this->auth_level == 7  ) {
                    $query = $this->db->where("(id_user_asesor_destino_soli  = $this->auth_user_id )", NULL, FALSE);
                }
				
						
								
				//echo $this->db->get_compiled_select(); exit;
				
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
	
	function solicitudes_search_count($search, $search_estado, $search_agencia)
    {
        $query = $this
                ->db
                ->select('count(id_soli) as total')
                ->group_start() // Abrir parentesis
                ->like('dni_titular_soli',$search)
                ->or_like('nombres_titular_soli',$search)
                ->or_like('apellido_pat_titular_soli',$search)
                ->or_like('apellido_mat_titular_soli',$search)
                ->or_like('id_soli',$search)
                ->group_end() // cerrar parentesis
                ->from('tbl_solicitudes')
                ->join('tbl_agencias ', 'tbl_agencias.id_agen = tbl_solicitudes.id_agencia_soli');
                ;

                //estado
				if( !empty($search_estado)) {
				   $query = $this->db->where("(id_estado_soli  = $search_estado )", NULL, FALSE);
				}

                //Agencia
                if( !empty($search_agencia)) {
                    $query = $this->db->where("(id_agencia_soli  = $search_agencia )", NULL, FALSE);
                }
				

    	$query = $this->db->get();		
		$res   =  $query->row();
		
	    return $res->total; 
    }
	
	
	
	
  // --------------------------------------------------------------
/**
 * Elimina un registro   (eliminado fisico)    
 * @param  $id_registro
 * @return (bool) 
 *  */    
    public function eliminar_solicitud_fisico($id_registro)
    {
    	
       $query =	$this->db->where('id_soli', $id_registro)
				  		 ->delete('tbl_solicitudes');
						 
		if (!$query)
		{
		  $error = $this->db->error(); // Has keys 'code' and 'message'
		  //echo "$error[message]";
		  return false ;
		}else  {
			$res =  $this->db->affected_rows() == 1 ?  true : false;

			//eliminar las otras tablas relacionadas a la solicitud
			if($res == true) {
                $query2 =	$this->db->where('id_solicitud_soli_c', $id_registro)
                                      ->delete('tbl_solicitudes_cultivo');
                $query3 =	$this->db->where('id_solicitud_soli_der', $id_registro)
                                      ->delete('tbl_solicitudes_derivados');
                $query4 =	$this->db->where('id_solicitud_soli_d', $id_registro)
                                      ->delete('tbl_solicitudes_deuda');
                $query5 =	$this->db->where('id_solicitud_soli_o', $id_registro)
                                      ->delete('tbl_solicitudes_otras');
                $query6 =	$this->db->where('id_soli_p', $id_registro)
                                      ->delete('tbl_solicitudes_pecuaria');
            }
			return $res;		
		}
					
    }

    // --------------------------------------------------------------
    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */
    public function eliminar_matriz_fisico($id_registro)
    {
        //Obtener Id de la matriz, a partir del id de la solicitud
        $this->load->model('reutilizables/Model_matrices') ;
        $matriz = $this->Model_matrices->obtener_matriz_xIdSolicitud($id_registro);
        //Si no existe datos, retornar TRUE;
        if($matriz == null)
            return TRUE;

        //1ero Borrar las relaciones de la matriz con variables
        $query =	$this->db->where('id_matriz_rela', $matriz->id_matriz)
                             ->delete('tbl_matriz_relaciones');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $result =  $this->db->affected_rows() >= 1 ?  true : false;

            //Eliminar el registro de la matriz principal
            if($result == true) {

                $query2 =	$this->db->where('id_solicitud_matriz', $id_registro)
                                      ->delete('tbl_matriz');

                $result2 =  $this->db->affected_rows() >= 1 ?  true : false;

                return $result2;
            }

        }

    } //Fin función eliminar matriz


    // --------------------------------------------------------------
    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */
    public function eliminar_secuencia_fisico($id_registro)
    {
        //Obtener Id de la matriz, a partir del id de la solicitud
        $this->load->model('reutilizables/Model_secuencias') ;
        $secuencia = $this->Model_secuencias->obtener_secuencia_xIdSolicitud($id_registro);
        //Si no existe datos, retornar TRUE;
        if($secuencia == null)
            return TRUE;

        //1ero Borrar las relaciones de desembolsos con la secuencia
        $query =	$this->db->where('id_secuencia_secu_desem', $secuencia->id_secuencia)
                              ->delete('tbl_secuencias_desembolsos');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $result =  $this->db->affected_rows() >= 1 ?  true : false;

            //Eliminar el registro de la secuencia principal
            if($result == true) {

                $query2 =	$this->db->where('id_solicitud_secuencia', $id_registro)
                                      ->delete('tbl_secuencias');

                $result2 =  $this->db->affected_rows() >= 1 ?  true : false;

                return $result2;
            }

        }

    } //Fin función eliminar secuencia

    // --------------------------------------------------------------
    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */
    public function eliminar_estimacion_fisico($id_registro)
    {

        //1ero Borrar las relaciones de la matriz con variables
        $query =	$this->db->where('id_solicitud_esti', $id_registro)
                             ->delete('tbl_estimaciones');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $result =  $this->db->affected_rows() >= 1 ?  true : false;
            return $result;
        }

    } //Fin función eliminar estimación


    // --------------------------------------------------------------
    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */
    public function eliminar_fotos_fisico($id_registro)
    {

        //1ero Borrar las relaciones de la matriz con variables
        $query =	$this->db->where('id_solicitud_foto', $id_registro)
                              ->delete('tbl_fotos');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $result =  $this->db->affected_rows() >= 1 ?  true : false;
            return $result;
        }

    } //Fin función eliminar Fotos

    // --------------------------------------------------------------
    /**
     * Elimina un registro   (eliminado fisico)
     * @param  $id_registro
     * @return (bool)
     *  */
    public function eliminar_postDesembolsos_fisico($id_registro)
    {

        //1ero Borrar las relaciones de la matriz con variables
        $query =	$this->db->where('id_solicitud_postd', $id_registro)
                              ->delete('tbl_postdesembolsos');

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "$error[message]";
            return false ;
        }else  {
            $result =  $this->db->affected_rows() >= 1 ?  true : false;
            return $result;
        }

    } //Fin función eliminar estimación


}