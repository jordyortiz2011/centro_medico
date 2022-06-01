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
     * Muestar el formulario para ver la solicitud,
     * Permite Aprobar o rechazar (si está en proceso)
     * @param  $id_registro (al final de la url) 
	 * @return (vista) , formulario
     */   	 
	 
	  public function form_editar($id_estimacion = null){
        
        if(  $this->auth_role == 'admin' )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_estimacion == null )
			  redirect('estimacion/listar/listar_estimaciones');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('estimacion/Model_editar');
             $estimacion  = $this->Model_editar->obtener_estimacion($id_estimacion);

            //Obtener datos de la matriz relacionado
            $this->load->model('reutilizables/Model_matrices');
            $matriz = $this->Model_matrices->obtener_matriz_xID($estimacion->id_matriz_esti);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($estimacion == NULL)
                 redirect('estimacion/listar/listar_estimaciones');

			 //Datos la estimacion
			  $id_variedad      = $estimacion->variedad;
			  $id_densidad       = $estimacion->b_densidad_siembra;

			  // =============================================================================
              //CREAR SELECT DE TIPO CICLO (Regular | Intensivo)                          
              //para que cree el array de id y nombre del select = estado_civil
              $lst_variedad = array(
             					1 => 'CCN 51',
                                2 => 'ICS 95',

                               );
                
                //string del select customizado 
                $dropdown_variedad = form_dropdown('select_variedad', $lst_variedad, $id_variedad," class='select2 form-control ' id='select_variedad'   disabled='' data-placeholder=''   " );
				
				// =============================================================================
              //CREAR SELECT DE TIPO CALI (Regular | Intensivo)                          
              //para que cree el array de id y nombre del select = Calificacion
            $lst_densidad = array(
             					1 => '3 X 3 ',
                                2 => '3 X 2.5',
                                3 => '2.5 X 2.5',
                               );
                
                //string del select customizado 
                $dropdown_densidad = form_dropdown('select_densidad', $lst_densidad, $id_densidad," class='select2 form-control ' id='select_densidad'   disabled='' data-placeholder=''   " );
				


			 
                 $data = array (
                                 'estimacion'		=> $estimacion,
                                 'matriz'           => $matriz,

                                 'select_variedad'   => $dropdown_variedad,
                                 'select_densidad'   => $dropdown_densidad,
                 );

                 $this->load->view('estimacion/vista_editar',$data)  ;
                            
              
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
               $this->form_editar($post['hidd_id_solicitud']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;            	
            	$id_registro	= $post['hidd_id_solicitud'];
            	
            	$this->load->model('solicitud/Model_editar');


				$res  = $this->Model_editar->verificar_solicitud($id_registro, $post);
		
				
				//comprobar si se actualizó exitosamente el registro
				if ( $res != false && $id_registro){

					//datos guardados correctamente
                    if($post['btn_verificar'] == 2) {
                        $this->session->set_flashdata('estado_registro', 'solicitud_aprobada');
                    }else if ($post['btn_verificar'] == 3) {
                        $this->session->set_flashdata('estado_registro', 'solicitud_rechazada');
                    }

                    redirect('solicitud/listar/listar_solicitudes', 'refresh');
				 }
				 else {
                    // $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                     $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                     redirect('solicitud/listar/listar_solicitudes', 'refresh');
                 }
				
            	
            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');
		


        // ==== para el boton de verificar =====
        $this->form_validation->set_rules('btn_verificar', 'Boton Verificar', 'required|in_list[2,3]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list'     => 'Boton no valido'
            )
        );






    }


	
	

    
    
}
