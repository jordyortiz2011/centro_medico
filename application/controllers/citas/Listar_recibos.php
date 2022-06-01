<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_recibos extends MY_Controller {
    
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
    public function listar_recibos()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_level == 9 || $this->auth_level == 7  )
        {
            // ===== Obtener el último ciclo ===========
            $this->load->model('matricula/Model_nueva');
            $ultimo_ciclo = $this->Model_nueva->obtener_ultimo_ciclo();
            //print_r($ultimo_ciclo); exit;


            //CREAR SELECT DE CICLOS
            $this->load->helper('form');
            $this->load->model('reutilizables/Model_ciclos');
            $lst_ciclos = $this->Model_ciclos->listado_ciclos();

            $array_ciclos  = array(); //array que tendrá los registros
            $array_ciclos['_todos_'] = 'Todos';
            //para que cree el array de id y nombre del select = unidades de medida
            foreach ($lst_ciclos as $ciclo) {
                $array_ciclos[$ciclo->id_ciclo] = $ciclo->codigo_ciclo;
            }
            //string del select customizado
            $dropdown_ciclos = form_dropdown('filtrado_ciclo', $array_ciclos, $ultimo_ciclo->id_ciclo,"class='select2 form-control ' id='filtrado_ciclo' " );




            $data = array(
                            'select_ciclos'          => $dropdown_ciclos, //Todos los datos correspondientes al último ciclo
						 );
            
            $this->load->view('pagos/vista_listar' , $data);
              
        }
  
    }
	

  // --------------------------------------------------------------
/**
 * Para consulta ajax : Obtiene los registros para mostrar en la tabla
 * @param  -_- 
 * @return json , valores para el datatable
 */     

    public function listar_recibos_ajax()
    {
        
         // Method should not be directly accessible                      
          if(   $this->auth_level == 9 || $this->auth_level == 7  )
        {       
			//nombres iguales a los campos de la base de datos
            //los indices tienen que corresponder al orden de columnas del js del datatable
			$columns = array(
                            0 => 'id_pago',
                            1 => 'codigo_matri',
                            2 => 'apellido_paterno_estu',
                            3 => 'dni_estu',
                            4 => 'numero_recibo_pago',
                            5 => 'monto_recibo_pago' ,
                            6 => 'fecha_recibo_pago' ,
                            7 => 'fecha_registro_pago' ,

                            8 => 'id_ciclo_matri'
            );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado	     
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			//echo "$order";exit;
			
			//cadenas de busquedas para columnas especificas
			//$search_categoria  = $this->input->post('columns[1][search][value]');
			//$search_paquete    = $this->input->post('columns[2][search][value]'); 
			$search_ciclo   = $this->input->post('columns[8][search][value]'); //valor al cambiar el select
            //echo "search ciclo: " . var_dump($search_ciclo);exit;
            $ciclo_defecto  = $this->input->post('ciclo_defecto'); //valor POST enviado por parametros del DataTABLE
            //echo "ciclo_defecto: " . var_dump($ciclo_defecto);exit;

            //si no seleccionó ninguno, filtrar por el ciclo por defecto enviado por el POST
            $search_ciclo   = ($search_ciclo == ''  )  ?  $ciclo_defecto : $search_ciclo ;
            //si al cambiar el select, se selecciona todos, asignar cadena vacia para que el sistema
            //No haga ningún filtrado y liste todos
            $search_ciclo   = ($search_ciclo == '_todos_'  )  ?  '' : $search_ciclo ;


            //echo "search ciclo: " . var_dump($search_ciclo);exit;
	       
		 	$this->load->model('pagos/Model_listar_recibos') ;
			
			//total de registros
			$totalData = $this->Model_listar_recibos->allpagos_count();
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_ciclo )  )
	        {            
	            $posts = $this->Model_listar_recibos->allpagos($limit,$start,$order,$dir);
	        }
	        else {

			    //echo 'buscar';
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar_recibos->pagos_search($search, $search_ciclo,   $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar_recibos->pagos_search_count($search, $search_ciclo);
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->id_pago; //para hacer la eliminacion

                    $nestedData['cod_matricula'] = $post->codigo_matri;
					
					$nestedData['estudiante'] = $post->apellido_paterno_estu . ' ' . $post->apellido_materno_estu .  ', ' . $post->nombres_estu ;

                    $nestedData['dni'] = $post->dni_estu;

                    $nestedData['num_recibo'] = $post->numero_recibo_pago;
                    $nestedData['monto_recibo'] = $post->monto_recibo_pago;
                    $nestedData['fecha_recibo'] = $post->fecha_recibo_pago;
				
	               
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha($post->fecha_registro_pago),
														'ordenar_fecha' => $post->fecha_registro_pago
													  );

                    //campos ocultos para el filtrado
                    $nestedData['id_ciclo'] = $post->id_ciclo_matri;
				
					
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
        if(  $this->auth_level == 9 || $this->auth_level == 7  )
        {
        	//si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null ) 
			  redirect('pagos/listar/listar_pagos');


        	
			//comprobar si el registro está siendo usado en otra tabla			
			$usado = false;
			//
			
			if(!$usado) {
				//eliminar registro      	
	             $this->load->model('pagos/Model_listar_recibos') ;
				 $res = $this->Model_listar_recibos->eliminar_pago_fisico($id_registro); 	//cambia estado del campo eliminado
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
