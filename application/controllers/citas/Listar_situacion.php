<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_situacion extends MY_Controller {
    
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
    public function listar_situacion()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_level == 9 || $this->auth_level == 7  )
        {

            $this->load->helper('form');

            // ===== Obtener el último ciclo ===========
            $this->load->model('matricula/Model_nueva');
            $ultimo_ciclo = $this->Model_nueva->obtener_ultimo_ciclo();
            //print_r($ultimo_ciclo); exit;
            //si no hay ciclo, mostrar error
            if($ultimo_ciclo == NULL) {
                echo  $this->load->view('errors/pagos/vista_sin_ciclo', '' ,TRUE); exit;
            }

            //CREAR SELECT DE CICLOS
            $this->load->model('reutilizables/Model_ciclos');
            $lst_ciclos = $this->Model_ciclos->listado_ciclos();

            $array_ciclos  = array(); //array que tendrá los registros
            $array_ciclos[''] = 'Todos' ;
            //para que cree el array de id y nombre del select = unidades de medida
            foreach ($lst_ciclos as $ciclo) {
                $array_ciclos[$ciclo->id_ciclo] = $ciclo->codigo_ciclo;
            }

            //string del select customizado
            $dropdown_ciclos = form_dropdown('select_ciclos', $array_ciclos, '',"class=' ' id='filtrado_ciclo' " );




            $data = array(
							'select_ciclos' =>  $dropdown_ciclos,
						 );
            
            $this->load->view('pagos/vista_listar_situacion' , $data);
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros para mostrar en la tabla
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_situacion_ajax()
    {
        
         // Method should not be directly accessible                      
          if(   $this->auth_level == 9 || $this->auth_level == 7  )
        {       
			//nombres iguales a los campos de la base de datos
            //los indices tienen que corresponder al orden de columnas del js del datatable
			$columns = array(
                            0 => 'id_matri',
                            1 => 'codigo_matri',
                            2 => 'situacion',
                            3 => 'apellido_paterno_estu',
                            4 => 'tbl_ciclos_aulas.id_turno' ,
                            5 => 'tbl_ciclos_aulas.nombre_aula_cicloaula' ,
                            6 => 'nombre_pago_mod' ,
            );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado	     
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			//echo "$order";exit;
			
			//cadenas de busquedas para columnas especificas
			//$search_categoria  = $this->input->post('columns[1][search][value]');
			//echo "search ciclo: " . var_dump($search_ciclo);exit;

            $search_situacion       = $this->input->post('id_situacion');
            $search_ciclo       = $this->input->post('id_ciclo');
            $search_turno       = $this->input->post('id_turno');
            $search_aula        = $this->input->post('id_aula');


	       
		 	$this->load->model('pagos/Model_listar_situacion') ;
			
			//total de registros
			$totalData = $this->Model_listar_situacion->allmatriculas_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_situacion )  &&  empty($search_ciclo )   &&  empty($search_turno )  &&  empty($search_aula ) )
	        {            
	            $posts = $this->Model_listar_situacion->allmatriculas($limit,$start,$order,$dir);
	        }
	        else {

			    //echo 'buscar';
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar_situacion->matriculas_search($search, $search_situacion, $search_ciclo, $search_turno, $search_aula,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar_situacion->matriculas_search_count($search, $search_situacion, $search_ciclo, $search_turno, $search_aula);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
	            foreach ($posts as $post)
	            {


						  
					$nestedData['id_registro'] = $post->id_matri; //para hacer la eliminacion

                    $nestedData['codigo'] = $post->codigo_matri; //para hacer la eliminacion

                    //$nestedData['situacion'] = 'Debe'; //

                    $nestedData['estudiante'] = $post->apellido_paterno_estu . ' ' . $post->apellido_materno_estu .  ', ' . $post->nombres_estu ;

                    $nestedData['turno'] =  $post->id_turno == 1 ? 'Mañana' : 'Tarde'; //para hacer la eliminacion



					$nestedData['aula'] = $post->nombre_aula_cicloaula;

                    $nestedData['modalidad_pago'] = $post->nombre_pago_mod;

                    //Calcular total a pagar de acuerdo a la modalidad
                    /*$costo_matricula = $post->costo_matri;
                    //hacer el calculo
                    $monto_descontar   =  ( $costo_matricula * $post->descuento_pago_mod ) / 100   ;
                    $costo_matricula_xModalidad = $costo_matricula -  $monto_descontar; */
                    $nestedData['total_pagar'] =  round( $post->total_pagar , 2);

                    $nestedData['total_importe'] = round($post->total_importe_actual,2 );

                    $nestedData['saldo'] = $nestedData['total_pagar'] - $nestedData['total_importe'];

                    //campos ocultos para el filtrado
                    $nestedData['id_ciclo'] = $post->id_ciclo;
				
					
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
    public function eliminar_matricula_fisico($id_registro = null)
    {
         
        // Method should not be directly accessible                      
        if(   $this->auth_level == 9 || $this->auth_level == 7  )
        {
        	//si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('matriculas/listar/listar_matriculas');

        	 //Comprobar si la matricula tiene pagos asociados
            $this->load->model('matricula/Model_listar') ;
            $usado_pagos = $this->Model_listar->comprobar_registro_usado_pagos($id_registro);
            if($usado_pagos) {
                $estado =  'registro_usado_pagos';
                echo $estado;
                exit;
            }

            //comprobar si el registro está siendo usado en otra tabla
			//$usado = false;
			//
			
			if(!$usado_pagos) {
				//eliminar registro
                //1ero Obtener datos de la matricula (para obtener aula)
                $this->load->model('matricula/Model_editar') ;
                $matricula = $this->Model_editar->obtener_matricula($id_registro);

                //2do Decrementar el contador de aula a la que correspondía la matricula
                $this->load->model('matricula/Model_listar');
                $decremento = $this->Model_listar->decrementar_contador_alumnos_xAula($matricula->id_cicloaula_matri);

	             //$this->load->model('matricula/Model_listar') ;
				 $res = $this->Model_listar->eliminar_matricula_fisico($id_registro); 	//cambia estado del campo eliminado
		         //json_encode($res);
		        //exit;
				 if ($res &&  $decremento)  {
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
