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
	 
	  public function form_editar($id_agencia = null){
        
        if(  $this->auth_level == 9  )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_agencia == null )
			  redirect('gestores/agencias/listar/listar_departamentos');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del paquete
         	 $this->load->model('gestores/agencias/Model_editar');
             $agencia  = $this->Model_editar->obtener_agencia($id_agencia);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($agencia == NULL)
                 redirect('gestores/agencias/listar/listar_agencias');


			 
			 $data = array (
			 				 'agencia'				=> $agencia,

			 				); 
                      
             $this->load->view('gestores/agencias/vista_editar',$data)  ;
                            
              
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
		        
        if(  $this->auth_level == 9  )
        {
             $post =  $this->input->post(); 		
			//print_r($post);  exit;
			
                   
             $this->mi_validacion_editar($post);
			
			//comprobar si el formulario es valido
			if( $this->form_validation->run() == FALSE )
            {
               //regresa al formulario de actualizar
               $this->form_editar($post['hidden_id_agencia']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_agencia	= $post['hidden_id_agencia'];
            	
            	$this->load->model('gestores/agencias/Model_editar');
				$res  = $this->Model_editar->editar_agencia($id_agencia, $post);


				//comprobar si se guardó exitosamente el indicador
				if ( $res  && $id_agencia)
				{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                	 redirect('gestores/agencias/listar/listar_agencias', 'refresh');

				}else{
                    //datos sin actualizar correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/agencias/listar/listar_agencias', 'refresh');
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
		$id_registro	= $post['hidden_id_agencia'];
        $this->load->model('gestores/agencias/Model_editar');
		$agencia  = $this->Model_editar->obtener_agencia($id_registro);
		
	
		
		//comprueba si el nombre del registro ya existe, ( en caso se haya cambiado al original)
		if($agencia->nombre_agen != $post['txt_nombre'])
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_nombre', 'Agencia', 'required|trim|min_length[3]|max_length[100]|is_unique[tbl_agencias.nombre_agen]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('txt_nombre', 'Agencia', 'required|trim|min_length[3]|max_length[100]' );
		}

        //Responsable
        // $this->form_validation->set_rules('txt_responsable', 'Responsable', 'required|trim|min_length[5]|max_length[100]' );

		

		
	}
	
	

    
    
}
