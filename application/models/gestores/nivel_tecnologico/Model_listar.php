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
	function allniveles_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_nivel_tecno) as total')
	            ->from('tbl_niveles_tecnologicos');
				
		
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
     * @return (obj) todos los registros
     *  */  
	function allniveles($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                 ->select('*')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_niveles_tecnologicos');
				//->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');
				
				
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
	
	 function niveles_search($search,      $limit,$start,$col,$dir )
    {
        $query = $this
                ->db
                 //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
                ->group_start() // Abrir parentesis
                ->like('nombre_nivel_tecno',$search)
				->group_end() // cerrar parentesis
			    ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_niveles_tecnologicos');
				//->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');
				
			
				//tipo colegio
				/*if( !empty($search_tipo_cole)) {
				   $query = $this->db->where("(id_tipo_cole  = '$search_tipo_cole' )", NULL, FALSE);
				} */
				
				
				
						
								
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
	
	function niveles_search_count($search)
    {
        $query = $this
                ->db
                ->select('count(id_nivel_tecno) as total')
                ->group_start() // Abrir parentesis
                ->like('nombre_nivel_tecno',$search)
				->group_end() // cerrar parentesis					
                ->from('tbl_niveles_tecnologicos');
				//->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');
				
				
				//tipo colegio
				/*if( !empty($search_tipo_cole)) {
				   $query = $this->db->where("(id_tipo_cole  = '$search_tipo_cole' )", NULL, FALSE);
				}*/
				
				
				
				
				
    	$query = $this->db->get();		
		$res   =  $query->row();
		
	    return $res->total; 
    }
	
	
	
	
  // --------------------------------------------------------------
/**
 * Elimina un registro   (eliminado físico)
 * @param  $id_registro
 * @return (bool) 
 *  */     

    public function eliminar_nivel_tecnologico_fisico($id_registro)
    {
    	
       $query =	$this->db->where('id_nivel_tecno', $id_registro)
				  		 ->delete('tbl_niveles_tecnologicos');
						 
						 
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

    // --------------------------------------------------------------

    /**
     * Comprueba si un nivel tecnológico  está siendo usada por la matriz
     * @param (int) $id_unidad : id de la unida
     * @return (bool) TRUE: el nivel  ya está siendo usada en una matriz
     *                FALSE: el nivel no está siendo usada
     *  */
    function comprobar_nivel_tecno($id_nivel_tecno)
    {
        $query = $this
            ->db
            ->from('tbl_matriz')
            ->where('id_nivel_tecno_matriz ', $id_nivel_tecno);

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