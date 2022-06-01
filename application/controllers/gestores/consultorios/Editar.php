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
			  redirect('gestores/consultorios/listar/listar_consultorios');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/consultorios/Model_editar');
             $consultorio  = $this->Model_editar->obtener_consultorio($id_registro);

             //print_r($especialidad); exit;
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($consultorio == NULL)
                 redirect('gestores/consultorios/listar/listar_consultorios');


            $hora_inicio = new DateTime($consultorio->hora_inicio_consul);
            $hora_inicio = $hora_inicio->format('H:i');

            $hora_fin = new DateTime($consultorio->hora_fin_consul);
            $hora_fin = $hora_fin->format('H:i');

			 
			 $data = array (
			 				 'consultorio'				=> $consultorio,
                              'hora_inicio'     => $hora_inicio,
                                'hora_fin'      => $hora_fin

			 				); 
                      
             $this->load->view('gestores/consultorios/vista_editar', $data)  ;
                            
              
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
               $this->form_editar($post['hidd_id_consultorio']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo print_r($post); "entré para actualizar";exit;
            	$id_registro	= $post['hidd_id_consultorio'];
            	
            	$this->load->model('gestores/consultorios/Model_editar');
				$res  = $this->Model_editar->editar_consultorio($id_registro, $post);

                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/consultorios/listar/listar_consultorios', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/consultorios/listar/listar_consultorios', 'refresh');
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
		$id_registro	= $post['hidd_id_consultorio'];
        $this->load->model('gestores/consultorios/Model_editar');
		$registro  = $this->Model_editar->obtener_consultorio($id_registro);
		

		
		//comprueba si el nombre del registro ya existe, ( en caso se cambia cambiado)
		if($registro->nombre_consul != $post['text_nombre'])
		{
		  //para el código
          $this->form_validation->set_rules('text_nombre', 'Nombre de consultorio','required|trim|min_length[1]|max_length[100]|is_unique[tbl_consultorios.nombre_consul]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_nombre', 'Nombre de consultorio', 'required|trim|min_length[1]|max_length[100]' );
		}

        // ==== para hora inicio =====
        $hora_fin  = $this->input->post('text_hora_fin');
        $this->form_validation->set_rules('text_hora_inicio', 'Hora INICIO', 'required|trim|callback_validacion_hora_correcta['. $hora_fin  .']',
            //mensajes personalizados de cada regla de validación
            array(
                'validacion_hora_correcta'     => 'La hora fin debe <b>ser mayor</b> a hora inicio'
            )
        );

        // ==== para hora fin =====
        $this->form_validation->set_rules('text_hora_fin', 'Hora FIN', 'required|trim',
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );


    }

    //comprueba si la HORA DE INICIO es meno a la HORA FIN
    public function validacion_hora_correcta($hora_inicio, $hora_fin  ){
        //print_r(var_dump($str));exit;
        $fecha_inicio = '2018-01-01 '.$hora_inicio . ':00';
        $fecha_fin = '2018-01-01 '.$hora_fin . ':00';

        $fecha_inicio = new DateTime($fecha_inicio);
        // $fecha_fin = $this->input->post('txt_fecha_fin'); //no se puede reutilizar
        $fecha_fin = new DateTime($fecha_fin);

        if($fecha_fin >  $fecha_inicio)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('text_hora_inicio', 'La hora fin, debe ser mayor a hora inicio');
            return FALSE; //no pasa la valicacion
        }
    }
	
	

    
    
}
