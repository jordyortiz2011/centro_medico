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
     * @param  $id_registro (al final de la url) 
	 * @return (vista) , formulario
     */   	 
	 
	  public function form_editar($id_registro = null){
        
        if(  $this->auth_role == 'admin' )
        {
         	         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	  $this->load->model('sistema/pag_inicio/contacto/Model_editar');
              $contacto  = $this->Model_editar->obtener_contacto();  
			 
			 //si no existe ningún registro con el id , redireccionar al listar
			 //if($contacto == NULL)
			 	//echo "Hola mundo"
			 
			// print_r($ciclo); exit;*/
			        
			 $data = array (
			 				 'contacto'		    	=> $contacto,			 				 
			 				); 
                      
             $this->load->view('sistema/pag_inicio/contacto/vista_editar',$data)  ;            
                            
              
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
               //regresa al formulario de actualizar                                        
               $this->form_editar($post['hidd_id_contac']); 
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar: al registro $post[hidd_id_empleado]";exit;            	
            	$id_contacto	= $post['hidd_id_contac'];
								
				//actualizar en la BD
            	$this->load->model('sistema/pag_inicio/contacto/Model_editar');
				$res  = $this->Model_editar->editar_contacto($id_contacto, $post);	
							
				//comprobar si se guardó exitosamente el registro
				if ( $res == TRUE  )	{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                				
	            		
					//redirección de acuerdo al boton
					if($post['btn_subir'] == 'editar') 
            			 redirect('sistema/pag_inicio/contacto/editar/form_editar', 'refresh');  
						
				}
				else{
					 //datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                	 redirect('sistema/pag_inicio/contacto/editar/form_editar', 'refresh');  					
				}					
				
            	
            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');
		
			
		// ==== para el Telefono =====
       $this->form_validation->set_rules('txt_telefono', 'Telefono', 'trim|is_natural|min_length[6]|max_length[6]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);
		
			
		 // ==== para Dirección =====
       $this->form_validation->set_rules('txt_direccion', 'Dirección', 'trim|required|max_length[250]' , 
										 //mensajes personalizados de cada regla de validación
										 array(									               
									              //'is_unique'     => 'Este <b> %s </b> ya existe.'
									           )
										);	
				
		//=== para correo ====  
        $this->form_validation->set_rules('txt_correo', 'Correo', 'required|trim|valid_email|max_length[100]' , 
									 //mensajes personalizados de cada regla de validación
									 array(									               
								               
								           )
									);
		
	
	
		
												
		
	}


    
    
}
