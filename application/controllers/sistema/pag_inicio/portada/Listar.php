<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form','fechas');
        $this->require_min_level(1);
        
        //para lenguaje
       
        
    }
  
  
  // --------------------------------------------------------------
    /**
     * Lista los usuarios  del Modulo Sistema/usuarios     
     * @param  -_-  
     */   
    public function listar_portadas()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {		           
            $this->load->view('sistema/pag_inicio/portada/vista_listar');            
        }
		else {
        	//sin acceso, mostrar vista de error        	
        	$this->load->view('errors/vista_sin_acceso' );          
        }
  
    }
    
    // --------------------------------------------------------------
    /**
     * Agregar nuevo usuario al sistema -  Sistema/usuarios -> Agregar     
     * @param  -_-  
     */   
    public function listar_portadas_ajax()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
            
           $columns = array( 						  
                                                  
                            0 => 'prioridad_porta',
                            1 => 'tipo_porta',
                            2 => 'titulo_porta',
                            3 => 'foto_porta',                           
                            4 => 'fecha_registro_porta',
                                                  
                        );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado
	       // $order = 'tbl_pagos.'.$order; //para que no colisione con otras 
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			
			//cadenas de busquedas para columnas especificas
			 $search_tipo = $this->input->post('columns[1][search][value]');
			
	       
		    //echo $search_sexo;
			//return 		$search_facultad;			
			//echo $search_fecha_registro; 
			
			$this->load->model('sistema/pag_inicio/portada/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allportadas_count();            
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_tipo ) )
	        {            
	            $posts = $this->Model_listar->allportadas($limit,$start,$order,$dir);
	        }
	        else {
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->portadas_search($search , $search_tipo ,    $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->portadas_search_count($search, $search_tipo );
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
				
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->id_porta; //para hacer la eliminacion
					
	                $nestedData['prioridad'] = $post->prioridad_porta;
					
				    $nestedData['id_tipo'] = $post->tipo_porta;
					
					if($post->tipo_porta  == 1) {
						 $nestedData['tipo'] = 'Imagen';						
					}else {
						 $nestedData['tipo'] = 'Texto';
					}		
					
					
					$nestedData['titulo'] = $post->titulo_porta;
					
					$nestedData['imagen'] = $post->foto_porta;
					
				
					$nestedData['fecha_registro'] =  array(
													'mostrar_fecha' => fecha_transformar_fecha($post->fecha_registro_porta),
													'ordenar_fecha' => $post->fecha_registro_porta
												   );				
					
	               
				   
				   
					//estado
		            $nestedData['estado'] = $post->estado_porta;
					
				
					
	                $data[] = $nestedData;
	
	            }
	        }
			
			 $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data  
                    
					//'mi_ordenacion' => $order 
                    );
            
        	echo json_encode($json_data);         
        }
  
    }

	 // --------------------------------------------------------------
    /**
     *Elimina registro , AJAX  (eliminado físico)  
     * @param  -_-  
     */   
    public function eliminar_portada($id_registro)
    {
         
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	 //obtener datos de la portada
			 $this->load->model('sistema/pag_inicio/portada/Model_editar');
        	 $portada  = $this->Model_editar->obtener_portada($id_registro); 	  
        	
			  $this->load->model('sistema/pag_inicio/portada/Model_listar') ;
			  $res = $this->Model_listar->eliminar_portada_fisico($id_registro); 	//elimina el registro de la BD	         
         	 //json_encode($res);
         	 		
			 if ($res == TRUE)  {
			 	 //eliminado correcto, eliminar imagen asociada
			 	$nombre_foto =  $portada->foto_porta;			 	
			 	//Borrar archivo original subido
				unlink( FCPATH . "/public/img/fotos_portada/" . $nombre_foto );	
				
			 	echo 'ok_eliminado';
			 	//return true;
			 } 
			 else {
			 	return  'error_eliminado';		 
		 	}		                   
              
        }
  
    }
    
        
 
    
    
}
