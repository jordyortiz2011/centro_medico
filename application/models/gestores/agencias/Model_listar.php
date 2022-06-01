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
	function allagencias_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_agen) as total')
	            ->from('tbl_agencias');
				
		
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
	function allagencias($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                 ->select('*')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_agencias');
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
	
	 function agencias_search($search, /*$search_tipo_cole, */    $limit,$start,$col,$dir )
    {
        $query = $this
                ->db
                 //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
                ->group_start() // Abrir parentesis
                ->like('nombre_agen',$search)
                //->or_like('responsable_depa',$search)
                ->group_end() // cerrar parentesis
			    ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_agencias');
                //->join('tbl_colegio_tipos', 'tbl_colegio_tipos.id_cole_tipo = tbl_colegios.id_tipo_cole');

                 //tipo colegio
				/*if( !empty($search_tipo_cole)) {
				   $query = $this->db->where("(id_tipo_cole  = '$search_tipo_cole' )", NULL, FALSE);
				}*/
				

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
	
	function agencias_search_count($search /*$search_tipo_cole, */ )
    {
        $query = $this
                ->db
                ->select('count(id_agen) as total')
                ->group_start() // Abrir parentesis
                ->like('nombre_agen',$search)
                //->or_like('responsable_depa',$search)
				->group_end() // cerrar parentesis					
                ->from('tbl_agencias');
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
 * Elimina un registro   (eliminado lógico)    
 * @param  $id_registro
 * @return (bool) 
 *  */     

    public function eliminar_departamento_fisico($id_registro)
    {
    	
       $query =	$this->db->where('id_depa', $id_registro)
				  		 ->delete('tbl_departamentos');
						 
						 
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
     * Comprueba si una el registro está siendo usado por otra tabla (problemas),
     * para el correcto eliminado
     * @param (int) $id_registro(int) : id del registro
     * @return (bool) TRUE: el registro ya está siendo usado
     *                FALSE: el registro NO se usa
     *  */
    function comprobar_registro_usado_problemas($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_problemas')
            ->where('id_departamento_proble', $id_registro);

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