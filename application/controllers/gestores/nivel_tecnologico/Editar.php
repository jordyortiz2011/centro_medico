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
			  redirect('gestores/nivel_tecnologico/listar/listar_niveles_tecnologicos');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del paquete
         	 $this->load->model('gestores/nivel_tecnologico/Model_editar');
             $nivel_tecnologico  = $this->Model_editar->obtener_nivel_tecnologico($id_registro);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($nivel_tecnologico == NULL)
                 redirect('gestores/unidades/listar/listar_niveles_tecnologicos');
									             
			 
			 $data = array (
			 				 'nivel_tecnologico'    => $nivel_tecnologico

			 				); 
                      
             $this->load->view('gestores/nivel_tecnologico/vista_editar', $data)  ;
                            
              
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
            	$id_nivel_tecno	= $post['hidd_id_nivel_tecno'];
            	
            	$this->load->model('gestores/nivel_tecnologico/Model_editar');
				$res  = $this->Model_editar->editar_nivel_tecnologico($id_nivel_tecno, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/nivel_tecnologico/listar/listar_niveles_tecnologicos');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/nivel_tecnologico/listar/listar_niveles_tecnologicos');
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
        $this->load->model('gestores/nivel_tecnologico/Model_editar');
		$nivel_tecnologico  = $this->Model_editar->obtener_nivel_tecnologico($id_registro);
		
	
		
		//comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
		if($nivel_tecnologico->nombre_nivel_tecno != $post['txt_nombre'])
		{
		  //para el nombre        
          $this->form_validation->set_rules('txt_nombre', 'Unidad', 'required|trim|min_length[3]|max_length[50]|is_unique[tbl_niveles_tecnologicos.nombre_nivel_tecno]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
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
