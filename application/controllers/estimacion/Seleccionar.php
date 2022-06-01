<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleccionar extends MY_Controller {
    
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
     * @return  -_- (carga  la vista de listado de Ciclos)   
     */     
    public function listar_matrices()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
            //Obtener listado de tipo de empleados
            /*$this->load->model('reutilizables/Model_empleados');
            $lst_emplea_tipo = $this->Model_empleados->listado_empleados_tipos();			
			
			
			$data = array(
							'lst_emplea_tipo' =>  $lst_emplea_tipo, 							
						 );*/
            
            $this->load->view('estimacion/vista_seleccionar'  );
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros de la tabla 
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_matrices_ajax()
    {

         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {       
			
			$columns = array(
                            0 => 'id_soli',
                            1 => 'dni_titular_soli',
                            2 => 'apellido_pat_soli', // titular
                            3 => 'costo_total_banco_matriz' ,
                            4 => 'costo_total_produc_matriz' ,
                            5 => 'costo_total_matriz' ,
                            6 => 'fecha_registro_soli' ,
                            7 => 'id_estado' ,
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
			$search_estado 		= $this->input->post('columns[7][search][value]');
		    //echo "search_tipo emplea: " . $search_tipo;exit;

            //reutilizable del modulo MATRIZ (listar)
		 	$this->load->model('matriz/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allmatrices_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_estado ) )
	        {            
	            $posts = $this->Model_listar->allmatrices($limit,$start,$order,$dir);
	        }
	        else {
	        	
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->solicitudes_search($search,  $search_estado,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->solicitudes_search_count($search,  $search_estado);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');


				
	            foreach ($posts as $post)
	            {
                    $nestedData['id_registro'] = $post->id_matriz; //para hacer la eliminacion

					$nestedData['id_solicitud'] = $post->id_solicitud_matriz; //para hacer la eliminacion


					//Dni
					$nestedData['dni'] = $post->dni_titular_soli;
					
					//Apellidos
					$nestedData['titular'] = $post->apellido_pat_titular_soli . ' ' . $post->apellido_mat_titular_soli . ', ' . $post->nombres_titular_soli;
					
					//estado
                    $nestedData['id_estado'] = $post->id_estado_soli; //1=en proceso, 2=aprobada, 3=rechazada
					$nestedData['estado'] = $post->id_estado_soli;

                    //Costo total
                    $nestedData['costo_total'] = $post->costo_total_matriz ;
                    //banco
                    $nestedData['costo_total_banco'] = $post->costo_total_banco_matriz;
                    //produc
                    $nestedData['costo_total_produc'] = $post->costo_total_produc_matriz;
					
					
	               
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha_sin_hora($post->fecha_registro_soli),
														'ordenar_fecha' => $post->fecha_registro_soli
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
