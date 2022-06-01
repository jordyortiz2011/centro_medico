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
     * Obtiene  la cantidad de todos los usuarios del sistema     
     * @param  -_-  
     * @return (int) total de usuarios
     *  */     
	function allusuarios_count()
	{   
	    $query = $this
	            ->db
	            ->select('count(user_id) as cantidad_usuarios')
	            ->from( $this->db_table('user_table') );
		
		//ejectua la consulta
		$query = $this->db->get();	
		
		$query = $query->row();	//devolvemos una sola fila	
		
		
	    return $query->cantidad_usuarios;  //se el campo de la consulta
			
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
	function allusuarios($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->from( $this->db_table('user_table') );
			
				
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
     * Obtiene  todos los usuarios,FILTRADO POR UNA CADENA DE BUSQUEDA, para paginacion y con ordenamiento 
	 * @param (string) $search : CADENA DE BUSQUEDA
     * @param (int) $limit : cantidad de resultados a mostrar por cada vista de tabla
	 * @param (int) $start, : desde que número de registro empezará a mostrarse
	 * @param (string) $col : por cual columna se hará el ordnamiento
	 * @param (string) $dir : que direccion se aplicará al ordenamiento, ASC O DES
     * @return (obj) todos los comensales
     *  */  
	
	 function usuarios_search($search, $search_tipo,    $limit,$start,$col,$dir )
    {
        $query = $this
                ->db
                ->group_start() // Open bracket
                ->like('username',$search)          		
				->group_end() // Close bracket
                ->limit($limit,$start)
                ->order_by($col,$dir)				
                ->from( $this->db_table('user_table') );
				
				
				//tipo usuario
				if( !empty($search_tipo)) {
				   $query = $this->db->where("(auth_level   = $search_tipo )", NULL, FALSE);
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
     * Obtiene la cantidad de   todos los comensales,FILTRADO POR UNA CADENA DE BUSQUEDA 
	 * @param (string) $search : CADENA DE BUSQUEDA
     * @return (int) numero de comensales
     *  */  	
	
	function usuarios_search_count($search, $search_tipo)
    {
        $query = $this
                ->db
                ->group_start() // Abrir parentesis
                ->like('username',$search)          	
				->group_end() // cerrar parentesis
                ->from( $this->db_table('user_table') );
				
				//tipo usuario
				if( !empty($search_tipo)) {
				   $query = $this->db->where("(auth_level  = $search_tipo )", NULL, FALSE);
				}			
					
				
    	$query = $this->db->get();
		
        return $query->num_rows();
    }
	
	
	
	
  // --------------------------------------------------------------
/**
 * Elimina un usuario de la tabla "tbl_usuarios" (elimina permanentemente)    
 * @param  $id_user
 * @return (Objeto) 
 *  */     

    public function eliminar_usuario_fisico($id_usuario)
    {            
        $this->db->where('user_id', $id_usuario);
		$this->db->delete( $this->db_table('user_table'));	
		
		if ($this->db->affected_rows()) {		   
			$result = true;
		} else {
		     $result = 'Error! Usuario ['.$id_usuario.'] no encontrado';
		}
		
		return $result;			
		
    }        
        

}