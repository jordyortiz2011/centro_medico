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
	function allestimaciones_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_esti) as total')
	            ->from('tbl_estimaciones')
                ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_estimaciones.id_solicitud_esti');
				
		
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
	function allestimaciones($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                 ->select('*')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_estimaciones')
                ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_estimaciones.id_solicitud_esti');

				
				
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
	
	 function estimaciones_search($search,  /*$search_estado,*/      $limit,$start,$col,$dir )
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
                ->from('tbl_estimaciones')
                ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_estimaciones.id_solicitud_esti');
				//->join('tbl_empleados_tipos ', 'tbl_empleados_tipos.id_emplea_tipo = tbl_empleados.id_tipo_emplea');
				
			
				//estado
				if( !empty($search_estado)) {
				   $query = $this->db->where("(id_estado_soli  = $search_estado )", NULL, FALSE);
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
	
	function estimaciones_search_count($search /*, $search_estado*/)
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
                ->from('tbl_estimaciones')
                ->join('tbl_solicitudes', 'tbl_solicitudes.id_soli = tbl_estimaciones.id_solicitud_esti');
				//->join('tbl_empleados_tipos ', 'tbl_empleados_tipos.id_emplea_tipo = tbl_empleados.id_tipo_emplea');


                //estado
				if( !empty($search_estado)) {
				   $query = $this->db->where("(id_estado_soli  = $search_estado )", NULL, FALSE);
				}
				

    	$query = $this->db->get();		
		$res   =  $query->row();
		
	    return $res->total; 
    }
	
	
	
	

        

}