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
			  redirect('gestores/especialidades/listar/listar_especialidades');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/especialidades/Model_editar');
             $especialidad  = $this->Model_editar->obtener_especialidad($id_registro);

             //print_r($especialidad); exit;
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($especialidad == NULL)
                 redirect('gestores/especialidades/listar/listar_especialidades');
									             
			 
			 $data = array (
			 				 'especialidad'				=> $especialidad

			 				); 
                      
             $this->load->view('gestores/especialidades/vista_editar', $data)  ;
                            
              
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
               $this->form_editar($post['hidd_id_especialidad']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_registro	= $post['hidd_id_especialidad'];
            	
            	$this->load->model('gestores/especialidades/Model_editar');
				$res  = $this->Model_editar->editar_especialidad($id_registro, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/especialidades/listar/listar_especialidades', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/especialidades/listar/listar_especialidades', 'refresh');
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
		$id_registro	= $post['hidd_id_especialidad'];
        $this->load->model('gestores/especialidades/Model_editar');
		$registro  = $this->Model_editar->obtener_especialidad($id_registro);
		

		
		//comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
		if($registro->nombre_espe != $post['text_nombre'])
		{
		  //para el código
          $this->form_validation->set_rules('text_nombre', 'Nombre de especialidad','required|trim|min_length[3]|max_length[100]|is_unique[tbl_especialidades.nombre_espe]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_nombre', 'Nombre de especialidad', 'required|trim|min_length[3]|max_length[100]' );
		}


        //======== PARA EL COLOR===========
        if($registro->color_espe != $post['text_color'])
        {
            $this->form_validation->set_rules('text_color', 'Color', 'required|trim|min_length[3]|max_length[7]|is_unique[tbl_especialidades.color_espe]|callback_validacion_regla_color' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => "El <b> %s </b> de <b>   $post[text_color] </b>  ya existe."
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_color', 'Color', 'required|trim|min_length[3]|max_length[7]|callback_validacion_regla_color' );
        }


        // ==== para la descripción  =====
        $this->form_validation->set_rules('text_descripcion', 'Descripcion', 'trim|max_length[200]');



    }


    public function validacion_regla_color($str)
    {
        $estado = (bool)preg_match("/#[a-fA-F0-9]{6}/", $str);
        //var_dump($estado);exit;
        if (!$estado)    {
            //$this->form_validation->set_message('Color', 'Color No valido');
            return FALSE;
        } else{
            return TRUE;
        }
    }
	

    
    
}
