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
    public function listar_usuarios()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
        	$lst_tipos_usuarios = config_item('levels_and_roles');
			
			$data = array(
							'lst_tipos_usuarios' => $lst_tipos_usuarios, 
						  );
			           
            $this->load->view('sistema/usuarios/vista_listar', $data);            
        }
		else {
        	//sin acceso, mostrar vista de error
        	cargar_lenguaje ('comun/errores');
        	$this->load->view('errors/vista_sin_acceso' );          
        }
  
    }
    
    // --------------------------------------------------------------
    /**
     * Agregar nuevo usuario al sistema -  Sistema/usuarios -> Agregar     
     * @param  -_-  
     */   
    public function listar_usuarios_ajax()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
            
           $columns = array( 						  
                                                  
                            0 => 'username',
                            1 => 'email',
                            2 => 'last_login',
                            3 => 'auth_level',                           
                            4 => 'banned',
                                                  
                        );
						
			
			$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        $start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        $order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado
	       // $order = 'tbl_pagos.'.$order; //para que no colisione con otras 
	        $dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			
			//cadenas de busquedas para columnas especificas
			 $search_tipo = $this->input->post('columns[3][search][value]');
			
	       
		    //echo $search_sexo;
			//return 		$search_facultad;			
			//echo $search_fecha_registro; 
			
			$this->load->model('sistema/usuarios/Model_listar') ;
			
			//total de registros
			$totalData = $this->Model_listar->allusuarios_count();            
        	$totalFiltered = $totalData; 
			
			
			//comprobar si se buscó algo
			if(empty($this->input->post('search')['value']) &&  empty($search_tipo ) )
	        {            
	            $posts = $this->Model_listar->allusuarios($limit,$start,$order,$dir);
	        }
	        else {
	            $search = $this->input->post('search')['value']; 
	
	            $posts =  $this->Model_listar->usuarios_search($search , $search_tipo ,    $limit,$start,$order,$dir );
	
	            $totalFiltered = $this->Model_listar->usuarios_search_count($search, $search_tipo );
	        }
			
			
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
				
	            foreach ($posts as $post)
	            {
						  
					$nestedData['id_registro'] = $post->user_id; //para hacer la eliminacion
					
	                $nestedData['usuario'] = $post->username;
					
					$nestedData['correo'] = $post->email;
					
					//tipo de usuario (veriricar que tipo de usuario es)
					$lst_tipos_usuarios = config_item('levels_and_roles');				
					foreach ($lst_tipos_usuarios as $clave => $valor) {
						if($clave == $post->auth_level) {
							 $nestedData['tipo'] = $valor;
							break;
						}						
						
					}
					
					//Inicio de sesión 
					if ($post->last_login == NUll ) {
						$nestedData['ultimo_logeo'] =  array(
														'mostrar_fecha' => 'No inició sesión aún',
														'ordenar_fecha' => $post->last_login
													   );	
					}else {
						$nestedData['ultimo_logeo'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha($post->last_login),
														'ordenar_fecha' => $post->last_login
													   );				
					}
	               
				   
				   
					//estado
		            $nestedData['banned'] = $post->banned;
					
				
					
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
     *Elimina comensal de la tabla Comensales/Listar , AJAX  (eliminado físico)  
     * @param  -_-  
     */   
    public function eliminar_usuario($id_usuario)
    {
         
         // Method should not be directly accessible                      
          if(  $this->auth_role == 'admin' )
        {
        		if($id_usuario == $this->auth_user_id) {
        			echo  'auto_eliminado';
        			
        		} else {
        			  $this->load->model('sistema/usuarios/Model_listar') ;
					  $res = $this->Model_listar->eliminar_usuario_fisico($id_usuario); 	//elimina el registro de la BD	         
		         	 //json_encode($res);
		         	 		
					 if ($res)  {
					 	echo 'ok_eliminado';
					 	//return true;
					 } 
					 else {
					 	return  'error_eliminado';		 
				 	}	
        		}
			
			       	
	                   
              
        }
  
    }
    
        
 
    
    
}
