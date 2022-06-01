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
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null )
			  redirect('gestores/unidades/listar/listar_unidades');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del paquete
         	 $this->load->model('gestores/unidades/Model_editar');
             $unidad  = $this->Model_editar->obtener_unidad($id_registro);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($unidad == NULL)
                 redirect('gestores/unidades/listar/listar_unidades');
									             
			 
			 $data = array (
			 				 'unidad'				=> $unidad

			 				); 
                      
             $this->load->view('gestores/unidades/vista_editar', $data)  ;
                            
              
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
               $this->form_editar($post['hidd_id_unidad']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_unidad	= $post['hidd_id_unidad'];
            	
            	$this->load->model('gestores/unidades/Model_editar');
				$res  = $this->Model_editar->editar_unidad($id_unidad, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/unidades/listar/listar_unidades', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/unidades/listar/listar_unidades', 'refresh');
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
		$id_registro	= $post['hidd_id_unidad'];
        $this->load->model('gestores/unidades/Model_editar');
		$unidad  = $this->Model_editar->obtener_unidad($id_registro);
		
	
		
		//comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
		if($unidad->nombre_unidad != $post['txt_nombre'])
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_nombre', 'Unidad', 'required|trim|min_length[3]|max_length[80]|is_unique[tbl_unidades.nombre_unidad]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('txt_nombre', 'Unidad', 'required|trim|min_length[3]|max_length[80]' );
		}


        // ==== para el comentario  =====
        $this->form_validation->set_rules('txt_comentario', 'Comentario', 'trim|max_length[250]');
        
		
	}
	
	

    
    
}
