<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)           
        $this->require_min_level(1);
        
             
    }
  
  
  // --------------------------------------------------------------
    // --------------------------------------------------------------
    /**
     * Lista lo tabla con los filtrados
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de)   
     */     
    public function listar_unidades()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
            //Obtener listado de tipo de unidades
             $this->load->model('reutilizables/Model_unidades');
             $lst_unidades = $this->Model_unidades->listado_unidades();
			
			
			$data = array(
							'lst_unidades' =>  $lst_unidades,
						 );
            
            $this->load->view('gestores/unidades/vista_listar' , $data);
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_unidades_ajax()
    {
        
         // Method should not be directly accessible                      
          if(  $this->auth_role == 'admin' )
        {       
			
			$columns = array(                                                 
                            0 => 'nombre_unidad',
                            1 => 'fecha_registro_unidad'
                        );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado	     
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			//echo "$order";exit;
			
			//cadenas de busquedas para columnas especificas
			//$search_categoria  = $this->input->post('columns[1][search][value]');
			//$search_paquete    = $this->input->post('columns[2][search][value]'); 
			$search_tipo_unidad   = $this->input->post('columns[1][search][value]');
			//echo "search cole: " . $search_tipo_cole;exit;
	       
		 	$this->load->model('gestores/unidades/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allunidades_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se busc?? algo
			if(empty($this->input->post('search')['value']) &&  empty($search_tipo_cole )  )
	        {            
	            $posts = $this->Model_listar->allunidades($limit,$start,$order,$dir);
	        }
	        else {
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->unidades_search($search,    $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->unidades_search_count($search);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->id_unidad; //para hacer la eliminacion
					
					$nestedData['nombre'] = $post->nombre_unidad;
					

				
	               
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha_sin_hora($post->fecha_registro_unidad),
														'ordenar_fecha' => $post->fecha_registro_unidad
													  );
												  				
				
				
					
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
 *Elimina registro, AJAX  (eliminado fisico)  
 * @param  $id_registro
 */   
    public function eliminar_unidad_fisico($id_registro = null)
    {
         
        // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	//si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('gestores/unidades/listar/listar_unidades');
        	
			//comprobar si el registro est?? siendo usado en otra tabla
             $this->load->model('gestores/unidades/Model_listar') ;
			$usado = $this->Model_listar->comprobar_unidad($id_registro);
			//
			
			if(!$usado) {
				//eliminar registro      	
	             $this->load->model('gestores/unidades/Model_listar') ;
				 $res = $this->Model_listar->eliminar_unidad_fisico($id_registro); 	//cambia estado del campo eliminado
		         //json_encode($res);
		
				 if ($res)  {
				 	$estado =  'eliminar_ok'; //eliminado
				 } else {
				 	$estado =  'eliminar_error';	//error		 
			 	}
			}else {
				$estado =  'registro_usado';
			}
			
			
			echo $estado;
			 	         
              
        }
  
    }
    
        
 
    
    
}
