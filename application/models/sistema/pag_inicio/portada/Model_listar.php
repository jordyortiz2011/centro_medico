<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_listar extends MY_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene  la cantidad de todos los registros de la tabla  
     * @param  -_-  
     * @return (int) total de registros
     *  */     
	function allportadas_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(id_porta) as total')
	            ->from('tbl_portadas');
		
		//ejectua la consulta
		$query = $this->db->get();	
		
		$query = $query->row();	//devolvemos una sola fila	
		
		
	    return $query->total;  //se el campo de la consulta
			
	}

// --------------------------------------------------------------
    /**
     * Obtiene  todos los pagos, para paginacion y con ordenamiento   
     * @param (int) $limit : cantidad de resultados a mostrar por cada vista de tabla
	 * @param (int) $start, : desde que número de registro empezará a mostrarse
	 * @param (string) $col : por cual columna se hará el ordnamiento
	 * @param (string) $dir : que direccion se aplicará al ordenamiento, ASC O DES
     * @return (obj) todos los comensales
     *  */  
	function allportadas($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_portadas');
			
				
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
     * @return (obj) todos los comensales
     *  */  
	
	 function portadas_search($search, $search_tipo,    $limit,$start,$col,$dir )
    {
        $query = $this
                ->db
                ->group_start() // Open bracket
                ->like('titulo_porta',$search)          		
				->group_end() // Close bracket
                ->limit($limit,$start)
                ->order_by($col,$dir)				
                ->from('tbl_portadas');
				
				
				//tipo usuario
				if( !empty($search_tipo)) {
				   $query = $this->db->where("(tipo_porta   = $search_tipo )", NULL, FALSE);
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
     * Obtiene la cantidad de   todos los registros,FILTRADO POR UNA CADENA DE BUSQUEDA 
	 * @param (string) $search : CADENA DE BUSQUEDA
     * @return (int) numero de comensales
     *  */  	
	
	function portadas_search_count($search, $search_tipo)
    {
        $query = $this
                ->db
                ->group_start() // Abrir parentesis
                ->like('titulo_porta',$search)          	
				->group_end() // cerrar parentesis
                ->from('tbl_portadas');
				
				//tipo usuario
				if( !empty($search_tipo)) {
				   $query = $this->db->where("(tipo_porta  = $search_tipo )", NULL, FALSE);
				}			
					
				
    	$query = $this->db->get();
		
        return $query->num_rows();
    }
	
	
	
	
  // --------------------------------------------------------------
/**
 * Elimina registro de la tabla (elimina permanentemente)    
 * @param  $id_user
 * @return (Objeto) 
 *  */     

    public function eliminar_portada_fisico($id_registro)
    {            
        $this->db->where('id_porta', $id_registro);
		$this->db->delete('tbl_portadas');	
		
		if ($this->db->affected_rows()) {		   
			$result = true;
		} else {
		     $result = 'Error! Registro:  ['.$id_registro.'] no encontrado';
		}
		
		return $result;			
		
    }        
        

}