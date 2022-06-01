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
     * Lista lo tabla con los filtrados
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de Ciclos)   
     */     
    public function listar_solicitudes()
    {
        
         // Method should not be directly accessible                      
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4  )
        {
            //Crear SELECT de AGENCIAS, acorde al usuario
            $this->load->helper('form');
            if( $this->auth_level == 9   )
            {
                // ===  CREAR  SELECT AGENCIA ========
                $this->load->model('reutilizables/Model_agencias');
                $lst_agencias = $this->Model_agencias->listado_agencias();
                //print_r($lst_departamentos);

                //para que cree el array de id y nombre del select = unidades de medida
                $array_agencias[''] = 'Todas';
                foreach ($lst_agencias as $agencia) {
                    $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
                }

                $dropdown_agencias = form_dropdown('filtrado_agencias', $array_agencias, '',"class='select2 form-control' id='filtrado_agencias' " );

            } //Sino es analista
            else {
                //Obtener datos del usuario
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);
                $id_agencia = $usuario->id_agencia_user;


                //Obtener departamento
                $this->load->model('reutilizables/Model_agencias');
                $agencia =  $this->Model_agencias->obtener_agencia($id_agencia);
                //Crear array para el Select
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;

                $dropdown_agencias = form_dropdown('filtrado_agencias', $array_agencias, $id_agencia,"class='select2 form-control' id='filtrado_agencias' disabled " );
            }


            $data = array(
                'select_agencias' =>  $dropdown_agencias,
            );
            
            $this->load->view('fotos/vista_seleccionar' , $data );
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros de la tabla 
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_solicitudes_ajax()
    {

         // Method should not be directly accessible                      
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4  )
        {       
			
			$columns = array(
                            0 => 'id_soli',
                            1 => 'dni_titular_soli',
                            2 => 'nombres_titular_soli',
                            3 => 'apellido_pat_soli' ,
                            4 => 'estado_soli' ,
                            5 => 'fecha_registro_soli' ,
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

            $search_agencia   = $this->input->post('id_agencia');
	       
		 	$this->load->model('matriz/Model_seleccionar') ;
			
			//total de registros
			$totalData = $this->Model_seleccionar->allsolicitudes_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_estado ) &&  empty($search_agencia )  )
	        {            
	            $posts = $this->Model_seleccionar->allsolicitudes($limit,$start,$order,$dir);
	        }
	        else {
	        	
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_seleccionar->solicitudes_search($search,  $search_estado, $search_agencia,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_seleccionar->solicitudes_search_count($search, $search_estado,  $search_agencia);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
				
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->id_soli; //para hacer la eliminacion

                    $nestedData['id_estado'] = $post->id_estado_soli; //1=en proceso, 2=aprobada, 3=rechazada
					
					//Dni
					$nestedData['dni'] = $post->dni_titular_soli;
					
					//Nombres
					$nestedData['nombres'] = $post->nombres_titular_soli;
					
					//Apellidos
					$nestedData['apellidos'] = $post->apellido_pat_titular_soli . ' ' . $post->apellido_mat_titular_soli;
					
					//estado
					$nestedData['estado'] = $post->id_estado_soli;

                    //agencia
                    $nestedData['agencia'] = $post->nombre_agen;
					
					
	               
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
