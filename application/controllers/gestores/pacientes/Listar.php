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
     * @return  -_- (carga  la vista de listado de Ciclos)   
     */     
    public function listar_pacientes()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' || $this->auth_level == 5 )
        {

			
			
			$data = array(
							//'lst_emplea_tipo' =>  $lst_emplea_tipo,
						 );
            
            $this->load->view('gestores/pacientes/vista_listar' , $data );
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros de la tabla 
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_pacientes_ajax()
    {
        
         // Method should not be directly accessible                      
          if(  $this->auth_role == 'admin' || $this->auth_level == 5 )
        {       
			
			$columns = array(                                                 
                            0 => 'excel_idSis_paci',
                            1 => 'excel_nroFormato_paci',
                            2 => 'excel_idTipoDoc_paci',
                            3 => 'excel_asegurado_paci',
                            4 => 'posee_sis_paci ' ,
                            5 => 'posee_sis_paci' ,
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
			$search_posee_sis 		= $this->input->post('columns[2][search][value]');
		    //echo "search_tipo emplea: " . $search_tipo;exit;
	       
		 	$this->load->model('gestores/pacientes/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allpacientes_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&   $search_posee_sis == ''   )
	        {
                //echo "listo todo"; exit;
	            $posts = $this->Model_listar->allpacientes($limit,$start,$order,$dir);
	        }
	        else {

	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->pacientes_search($search,  $search_posee_sis,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->pacientes_search_count($search,  $search_posee_sis);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
				
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->id_paciente; //para hacer la eliminacion


					
					//Dni
					$nestedData['id_sis'] = $post->excel_idSis_paci;
                    //Nro Formato
                    $nestedData['num_formato'] = $post->excel_nroFormato_paci;
                    //Dni
                    $nestedData['dni'] = $post->excel_dni_paci;
					
					//Nombres
					$nestedData['asegurado'] = $post->excel_asegurado_paci;


                    $nestedData['posee_sis']  =  $post->posee_sis_paci == 1 ? 'SI' :'NO';

					//Tipo empleado
					$nestedData['activo'] = $post->excel_estado_paci == 1 ? 'SI' :'NO';

					
	               
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha_sin_hora($post->fecha_registro_paci),
														'ordenar_fecha' => $post->fecha_registro_paci
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
    public function eliminar_paciente_fisico($id_registro = null)
    {
         
        // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	//si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('gestores/pacientes/listar/listar_pacientes');
        	
			//comprobar si el registro está siendo usado en otra tabla			
			$usado = false;
			//
			
			if(!$usado) {
				//eliminar registro      	
	             $this->load->model('gestores/pacientes/Model_listar') ;
				 $res = $this->Model_listar->eliminar_paciente_fisico($id_registro); 	//cambia estado del campo eliminado
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
              
        }else {
            $estado =  'sin_permiso';
            echo $estado;
        }
  
    }
    
        
 
    
    
}
