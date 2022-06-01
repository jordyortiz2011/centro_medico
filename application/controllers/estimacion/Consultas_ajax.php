<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_ajax extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }
	
	public function index(){
		redirect('solicitud/nueva/form_ficha_matricula');
	}
  
  
  	public function listar_colegios_select2()
    {
        $json = array();

        $this->load->database();
        
        $page = $this->input->post('page'); 
	    $resultCount = 10;
				
	    $offset = ($page - 1) * $resultCount;		
			
	     //$breeds = Breed::where('name', 'LIKE',  '%' . Input::get("term"). '%')->orderBy('name')->skip($offset)->take($resultCount)->get(['id',DB::raw('name as text')]);
		
		$query = $this->db->select('id_cole as id,nombre_cole as text')
						 ->like('nombre_cole',$this->input->post("term"))
                         ->limit($resultCount , $offset )
                        ->from("tbl_colegios")						
						->order_by('nombre_cole' , 'ASC');
	
		$query = $this->db->get();
		
		
		$result = $query->result();   //registross			
	    $count = $query->num_rows();  //cantidad de registros	
	    		
	   // $endCount = $offset + $resultCount;
	    $morePages = $count >= $resultCount;
		
		$result = $query->result();  
	
	    $json = array(
	      "results" => $result,
	      "pagination" => array(
	        "more" => $morePages
	      )
	    );        
        
        echo json_encode($json);		
		
    }//fin funcion listar_colegios_select2



	 /** =====================================================
     * Registrar nuevo colegio, formulario Modal , 
     * valida, y los manda al modelo, para guardar en la BD
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de usuarios)   
     */       
    public function procesa_registro_colegio_ajax()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_role == 'admin' )
        {
            $post = $this->input->post(); 		
			//print_r($post)         ; exit;
           
            //establecer reglas de validacion:           
            $this->validacion_reglas_registro_colegio();
			
			// respuesta al script ajax
        	$respt = new stdClass();
          
            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {                                          
               		   
			   $respt->estado = 'error_validacion';
			   
			   $respt->errores = validation_errors('<div class="alert alert-danger">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>', 
													'</div>'); 
						  
			   echo json_encode($respt);
			   exit;
            }
            else 
            {
                //guardar en la BD             
             
               //guardar en la BD
				$this->load->model('solicitud/Model_consultas_ajax');
                $result =  $this->Model_consultas_ajax->guardar_colegio($post);              
                             
                
                 if ($result == true ) {                  	  	                    
                  	  //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar                    
            		  $respt->estado = 'registro_correcto';
					  echo json_encode($respt);
		  			  exit;                                   
                 }
                 else {                 	
                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar  
	                 $respt->estado = 'registro_error';
					 echo json_encode($respt);
		  			 exit;
                 }                 
                                
            }//fin de form_validation->run()
        
        }
    
    }//fin función procesa registro colegio ajax
	
    
     /** ===================================
     * Reglas de validacion para formulario        
     */       
    private function validacion_reglas_registro_colegio () 
    {               
        //carga la libreria para validar formulario               
        $this->load->library('form_validation');
		$this->config->set_item('language', 'spanish'); 
        
         // ==== para el nombre de colegio =====
        $this->form_validation->set_rules('txt_nombre_colegio', 'Colegio', 'required|trim|min_length[3]|max_length[200]|is_unique[tbl_colegios.nombre_cole]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
        
         //===== para el tipo de colegio ======
         // obtener listado de tipo de unidades 
		$this->load->model('reutilizables/Model_unidades');
        $lst_cole_tipos = $this->Model_colegios->listado_colegio_tipos();
		
		$string_tipo = '';
		foreach ($lst_cole_tipos as $tipo_cole) {
			$string_tipo .= $tipo_cole->id_cole_tipo . ',';
		}		
		$string_tipo = trim($string_tipo, ',');	 		
		
		
    	 $this->form_validation->set_rules('select_cole_tipo', 'Tipo de colegio', 'required|in_list[' . $string_tipo. ']');		
		        
    }
    
}
