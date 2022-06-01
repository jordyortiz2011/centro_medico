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
    public function listar_profesionales()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {

            //Especialidad
            $this->load->model('reutilizables/Model_especialidades');
            $lst_especialidades = $this->Model_especialidades->listado_especialidades();

			$data = array(
							'lst_especialidades' =>  $lst_especialidades,
						 );
            
            $this->load->view('gestores/profesionales/vista_listar' , $data );
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros de la tabla 
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_profesionales_ajax()
    {
        
         // Method should not be directly accessible                      
          if(  $this->auth_role == 'admin' )
        {       
			
			$columns = array(                                                 
                            0 => 'username',
                            1 => 'id_especialidad_user',
                            2 => 'banned ' ,

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
			 $search_especialidad 		= $this->input->post('columns[1][search][value]');
		    //echo "search_tipo emplea: " . $search_tipo;exit;
	       
		 	$this->load->model('gestores/profesionales/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allprofesionales_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_especialidad ) )
	        {            
	            $posts = $this->Model_listar->allprofesionales($limit,$start,$order,$dir);
	        }
	        else {
	        	
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->profesionales_search($search,  $search_especialidad,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->profesionales_search_count($search,  $search_especialidad);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');

	        	//Especialidad
                $this->load->model('reutilizables/Model_especialidades');
                $lst_especialidades = $this->Model_especialidades->listado_especialidades();

				
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->user_id; //para hacer la eliminacion
					
					//Apellidos y nombres
                    $apellidos_nombres =  $post->apellido_pat_user . " " . $post->apellido_mat_user . ", " . $post->nombres_user;
                    $nestedData['apellidos_nombres'] = $apellidos_nombres ;

                    //Especialidad
                    foreach ($lst_especialidades as $espe) {
                        if ($espe->id_especialidad == $post->id_especialidad_user){

                            $nestedData['id_especialidad_user'] =  array(
                                                            'descripcion'   => $espe->nombre_espe,
                                                            'id'            => $post->id_especialidad_user
                                                        );
                            break;
                        }
                    }


					//Usuario
					$nestedData['username'] = $post->username;

					//Estado
					$nestedData['estado'] = $post->banned;


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
    public function eliminar_registro_fisico($id_registro = null)
    {
         
        // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	//si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('gestores/profesionales/listar/listar_profesionales');
        	
			//comprobar si el registro está siendo usado en otra tabla			
			$usado = false;
			//
			
			if(!$usado) {
				//eliminar registro      	
	             $this->load->model('gestores/profesionales/Model_listar') ;
				 $res = $this->Model_listar->eliminar_registro_fisico($id_registro); 	//cambia estado del campo eliminado
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
