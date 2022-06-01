<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//este listar funciona con paginación para la librería datatable

class Model_exportar_recibos extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    function allpagos_count()
    {
        $query = $this
            ->db
            ->select('count(id_pago) as total')
            ->from('tbl_pagos')
            ->join('tbl_matriculas', 'tbl_matriculas.id_matri = tbl_pagos.id_matricula_pago')
            ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri');

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
     * @return (obj) todos los registro
     *  */
    function allpagos($col,$dir)
    {
        $query = $this
            ->db
            ->select('*')
            ->order_by($col,$dir)
            ->from('tbl_pagos')
            ->join('tbl_matriculas', 'tbl_matriculas.id_matri = tbl_pagos.id_matricula_pago')
            ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri');

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
	
	 function pagos_search($search, $search_ciclo,   $col,$dir )
    {
        $query = $this
                ->db
                 //->select('tbl_anuncios.*, tbl_categorias.nombre AS nom_cat , tbl_paquetes.nombre AS nom_paq')
                ->group_start() // Abrir parentesis
                ->like('nombres_estu',$search)
                ->or_like('apellido_paterno_estu',$search)
                ->or_like('apellido_materno_estu',$search)
                ->or_like('numero_recibo_pago',$search)
                ->or_like('fecha_recibo_pago',$search)
                ->group_end() // cerrar parentesis
			    //->limit($limit,$start)
                ->order_by($col,$dir)
                ->from('tbl_pagos')
                ->join('tbl_matriculas', 'tbl_matriculas.id_matri = tbl_pagos.id_matricula_pago')
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri');
				
			
				//ciclo
				if( !empty($search_ciclo)) {
				   $query = $this->db->where("(id_ciclo_matri  = '$search_ciclo' )", NULL, FALSE);
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
	
	function pagos_search_count($search, $search_ciclo)
    {
        $query = $this
                ->db
                ->select('count(id_matri) as total')

                ->group_start() // Abrir parentesis
                ->like('nombres_estu',$search)
                ->or_like('apellido_paterno_estu',$search)
                ->or_like('apellido_materno_estu',$search)
                ->or_like('numero_recibo_pago',$search)
                ->or_like('fecha_recibo_pago',$search)
                ->group_end() // cerrar parentesis

                ->from('tbl_pagos')
                ->join('tbl_matriculas', 'tbl_matriculas.id_matri = tbl_pagos.id_matricula_pago')
                ->join('tbl_estudiantes', 'tbl_estudiantes.id_estu = tbl_matriculas.id_estudiante_matri');


                //ciclo
                if( !empty($search_ciclo)) {
                    $query = $this->db->where("(id_ciclo_matri  = '$search_ciclo' )", NULL, FALSE);
                }
				
    	$query = $this->db->get();		
		$res   =  $query->row();
		
	    return $res->total; 
    }


}