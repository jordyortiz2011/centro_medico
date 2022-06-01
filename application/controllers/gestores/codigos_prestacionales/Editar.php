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
			  redirect('gestores/codigos_prestacionales/listar/listar_codigos');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/codigos_prestacionales/Model_editar');
             $codigo  = $this->Model_editar->obtener_codigo($id_registro);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($codigo == NULL)
                 redirect('gestores/codigos_prestacionales/listar/listar_codigos');
									             
			 
			 $data = array (
			 				 'codigo'				=> $codigo

			 				); 
                      
             $this->load->view('gestores/codigos_prestacionales/vista_editar', $data)  ;
                            
              
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
               $this->form_editar($post['hidden_id_codigo']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_codigo	= $post['hidden_id_codigo'];
            	
            	$this->load->model('gestores/codigos_prestacionales/Model_editar');
				$res  = $this->Model_editar->editar_codigo($id_codigo, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/codigos_prestacionales/listar/listar_codigos', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/codigos_prestacionales/listar/listar_codigos', 'refresh');
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
		$id_registro	= $post['hidden_id_codigo'];
        $this->load->model('gestores/codigos_prestacionales/Model_editar');
		$codigo  = $this->Model_editar->obtener_codigo($id_registro);
		

		
		//Para el codigo
		if($codigo->codigo_codpre != $post['text_codigo'])
		{
		  //para el código
          $this->form_validation->set_rules('text_codigo', 'Código ','required|trim|min_length[1]|max_length[20]|is_unique[tbl_codigos_prestacionales.codigo_codpre]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_codigo', 'Servicio', 'required|trim|min_length[1]|max_length[20]' );
		}

        //Para la descripcion
        if($codigo->descripcion_codpre != $post['text_descripcion'])
        {

            //para el código
            $this->form_validation->set_rules('text_descripcion', 'Servicio','required|trim|min_length[1]|max_length[60]|is_unique[tbl_codigos_prestacionales.descripcion_codpre]' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => 'Esta <b> %s </b> ya existe.',
                    'max_length'  => 'No debería excer de 60 caracteres'
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_descripcion', 'Nombre Etnia', 'required|trim|min_length[1]|max_length[60]' );
        }
		
	}
	
	

    
    
}
