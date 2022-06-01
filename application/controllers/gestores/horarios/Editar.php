<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');
        $this->is_logged_in();
        $this->require_min_level(1);
    }
  
    public function index()
    {        
       redirect()  ;      
    }
	
	 
 // --------------------------------------------------------------
    /**
     * Muestar el formulario para editar 
	 * para realizar la edición
     * @param  $id_membreia (al final de la url) 
	 * @return (vista) , formulario
     */   	 
	 
	  public function form_editar($id_colegio = null){
        
        if(  $this->auth_role == 'admin' )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_colegio == null ) 
			  redirect('gestores/colegios/listar/listar_colegios');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del paquete
         	 $this->load->model('gestores/colegios/Model_editar');
             $colegio  = $this->Model_editar->obtener_colegio($id_colegio);  
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($colegio == NULL)
			 	redirect('gestores/colegios/listar/listar_colegios');
			
			 //Datos del colegio
			 $id_tipo_cole = $colegio->id_tipo_cole;
			
			
			
			
		  	 // =============================================================================
             //CREAR SELECT DE TIPO DE COLEGIO                 
        	 $this->load->model('reutilizables/Model_colegios');
             $lst_cole_tipos = $this->Model_colegios->listado_colegio_tipos();
                
                //para que cree el array de id y nombre del select = unidades de medida
                foreach ($lst_cole_tipos as $tipo) {
                    $lista_tipo[$tipo->id_cole_tipo] = $tipo->nombre_cole_tipo;
                }           
                
                //string del select customizado 
                $dropdown_tipo = form_dropdown('select_cole_tipo', $lista_tipo, $id_tipo_cole,"class='select2 form-control' id='select_cole_tipo' " );
				
			   // =============================================================================
									             
			 
			 $data = array (
			 				 'colegio'				=> $colegio,
			 				 'select_tipo_cole'		=> $dropdown_tipo
			 				); 
                      
             $this->load->view('gestores/colegios/vista_editar',$data)  ;            
                            
              
        }
        
    }
	
	   // --------------------------------------------------------------
    /**
     * procesa el formulario de la edicion de paquetes 
     * @param  (post) valores del formulario
	 * @return  (vista) si la actualización es correcta , retorna al listado de paquetes
     */     
    public function procesa_editar()
    {
		        
        if(  $this->auth_role == 'admin' )
        {
             $post =  $this->input->post(); 		
			//print_r($post);  exit;
			
                   
             $this->mi_validacion_editar($post);
			
			//comprobar si el formulario es valido
			if( $this->form_validation->run() == FALSE )
            {
               //regresa al formulario de actualizar indicador                                       
               $this->form_editar($post['hidd_id_colegio']); 
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_colegio	= $post['hidd_id_colegio'];
            	
            	$this->load->model('gestores/colegios/Model_editar');
				$res  = $this->Model_editar->editar_colegio($id_colegio, $post);				
				
				
		
				
				//comprobar si se guardó exitosamente el indicador
				if ( $res != false && $id_colegio) 
				{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('registro_actualizado', true);
                	 redirect('gestores/colegios/listar/listar_colegios', 'refresh');    	
				 }					
				
            	
            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');
		
		//para no realizar comprobación del nombre del colegio si no se cambió el nombre del colegio
		$id_registro	= $post['hidd_id_colegio'];
        $this->load->model('gestores/colegios/Model_editar');
		$colegio  = $this->Model_editar->obtener_colegio($id_registro);  
		
	
		
		//comprueba si el nombre del paquete ya existe, ( en caso se cambia cambiado)
		if($colegio->nombre_cole != $post['txt_nombre']) 
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_nombre', 'Colegio', 'required|trim|min_length[3]|max_length[200]|is_unique[tbl_colegios.nombre_cole]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('txt_nombre', 'Colegio', 'required|trim|min_length[3]|max_length[200]' );
		}
		
		 //===== para el tipo de colegio ======
         // obtener listado de tipo de colegios 
		$this->load->model('reutilizables/Model_colegios');
        $lst_cole_tipos = $this->Model_colegios->listado_colegio_tipos();
		
	
		
		$string_tipo = '';
		foreach ($lst_cole_tipos as $tipo_cole) {
			$string_tipo .= $tipo_cole->id_cole_tipo . ',';
		}		
		$string_tipo = trim($string_tipo, ',');	 		
		
		
    	$this->form_validation->set_rules('select_cole_tipo', 'Tipo de colegio', 'required|in_list[' . $string_tipo. ']') ;   
        
		
	}
	
	

    
    
}
