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
			  redirect('gestores/codigos_renaes/listar/listar_codigos');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/codigos_renaes/Model_editar');
             $codigo  = $this->Model_editar->obtener_codigo($id_registro);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($codigo == NULL)
                 redirect('gestores/codigos_renaes/listar/listar_codigos');
									             
			 
			 $data = array (
			 				 'codigo'				=> $codigo

			 				); 
                      
             $this->load->view('gestores/codigos_renaes/vista_editar', $data)  ;
                            
              
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
               $this->form_editar($post['hidd_id_codigo']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_codigo	= $post['hidd_id_codigo'];
            	
            	$this->load->model('gestores/codigos_renaes/Model_editar');
				$res  = $this->Model_editar->editar_codigo($id_codigo, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/codigos_renaes/listar/listar_codigos', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/codigos_renaes/listar/listar_codigos', 'refresh');
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
		$id_registro	= $post['hidd_id_codigo'];
        $this->load->model('gestores/codigos_renaes/Model_editar');
		$codigo  = $this->Model_editar->obtener_codigo($id_registro);
		

		
		//comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
		if($codigo->cod_renaes_codren != $post['text_cod_renaes'])
		{
		  //para el código
          $this->form_validation->set_rules('text_cod_renaes', 'Código Renaes','required|trim|integer|is_unique[tbl_codigos_renaes.cod_renaes_codren]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_cod_renaes', 'Código Renaes', 'required|trim|integer' );
		}

        //comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
        if($codigo->codexcel_codren != $post['text_codexcel'])
        {
            //para el código
            $this->form_validation->set_rules('text_codexcel', 'Código EXCEL EES','required|trim|is_unique[tbl_codigos_renaes.codexcel_codren]' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => 'Esta <b> %s </b> ya existe.'
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_codexcel', 'Código EXCEL EESS', 'required|trim' );
        }


        // ==== para la micro red  =====
        $this->form_validation->set_rules('text_micro', 'Micro red Putumayo', 'required|trim|max_length[200]');
        
		
	}
	
	

    
    
}
