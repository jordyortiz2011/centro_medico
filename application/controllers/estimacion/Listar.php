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
     * Lista la tabla con los filtrados
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de estimaciones)
     */     
    public function listar_estimaciones()
    {
        
         // Method should not be directly accessible                      
        if( $this->verify_role('admin,asesor')  )
        {
            //Obtener listado de tipo de empleados
            /*$this->load->model('reutilizables/Model_empleados');
            $lst_emplea_tipo = $this->Model_empleados->listado_empleados_tipos();			
			


			$data = array(
							'lst_emplea_tipo' =>  $lst_emplea_tipo, 							
						 );*/

            
            $this->load->view('estimacion/vista_listar'  );
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros de la tabla 
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_estimaciones_ajax()
    {

         // Method should not be directly accessible                      
        if( $this->verify_role('admin,asesor')  )
        {       
			
			$columns = array(
                            0 => 'id_soli',
                            1 => 'dni_titular_soli',
                            2 => 'apellido_pat_soli', // titular apellido pat + mat + nombres
                            3 => 'costo_produccion' ,
                            4 => 'utilidad_neta' ,
                            5 => 'analisis_comparativo' ,
                            6 => 'fecha_registro_esti' ,

                        );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado	     
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			//echo "$order";exit;
			
			//cadenas de busquedas para columnas especificas
			//$search_dni  		= $this->input->post('columns[0][search][value]');
			//$search_nombres     = $this->input->post('columns[1][search][value]'); 
			//$search_apellido    = $this->input->post('columns[2][search][value]'); 
			//$search_estado 		= $this->input->post('columns[7][search][value]');
		    //echo "search_tipo emplea: " . $search_tipo;exit;
	       
		 	$this->load->model('estimacion/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allestimaciones_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) /*&&  empty($search_estado )*/ )
	        {            
	            $posts = $this->Model_listar->allestimaciones($limit,$start,$order,$dir);
	        }
	        else {
	        	
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->estimaciones_search($search, /*  $search_estado , */   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->estimaciones_search_count($search /* , $search_estado*/ );
	        }
			//print_r($posts); exit;
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
				
	            foreach ($posts as $post)
	            {
                    $nestedData['id_registro'] = $post->id_esti; //para hacer la eliminacion
						  
					$nestedData['id_solicitud'] = $post->id_solicitud_esti; //para hacer la eliminacion

					//Dni
					$nestedData['dni'] = $post->dni_titular_soli;

                    //Titular
                    $nestedData['titular'] =  $post->nombres_titular_soli . ', ' . $post->apellido_pat_titular_soli . ' ' . $post->apellido_mat_titular_soli ;

                    //estado
                    $nestedData['id_estado'] = $post->id_estado_soli; //1=en proceso, 2=aprobada, 3=rechazada
					$nestedData['estado'] = $post->id_estado_soli;

                    //Costo total
                    $nestedData['costo_produccion'] = $post->costo_produccion ;
                    //Utilidad bruta
                    $nestedData['utilidad_bruta'] = $post->utilidad_bruta;

                    //Utilidad bruta
                    $nestedData['utilidad_neta'] = $post->utilidad_neta;

                    //produc
                    $nestedData['analisis_comparativo'] = $post->analisis_comparativo;
					
					
	               
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha($post->fecha_registro_esti),
														'ordenar_fecha' => $post->fecha_registro_esti
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
		 

    
        
 
    
    
}
