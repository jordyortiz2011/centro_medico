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
        
        if(  $this->auth_role == 'admin' || $this->auth_level == 5 )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null )
			  redirect('gestores/pacientes/listar/listar_pacientes');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/pacientes/Model_editar');
             $paciente  = $this->Model_editar->obtener_paciente($id_registro);
			 
			 //si no existe ningún registro con el id , redireccionar al listar
			 if($paciente == NULL)
			 	redirect('gestores/pacientes/listar/listar_pacientes');
			 
			// print_r($ciclo); exit;
			
			 //Datos del Registro
			  $id_tipo_doc = $paciente->excel_idTipoDoc_paci;
              $id_estado_sis = $paciente->excel_estado_paci;
			  $sexo = $paciente->excel_sexo_paci ;
			  $id_eess = $paciente->id_eess_paci ;
			  
		    // =============================================================================
            //CREAR RADIO - SEXO 
             $radio_sexo = '';
            if($sexo == 'M') {
                $radio_sexo= form_radio('radio_sexo', 'M', TRUE , 'class="" ') . '<label class="form-check-label" for="radio_sexo"> Masculino </label><br>';
                $radio_sexo .= form_radio('radio_sexo', 'F', FALSE , 'class="" '). '<label class="form-check-label" for="radio_sexo"> Femenino </label>';
			 }
			 else  {
                $radio_sexo= form_radio('radio_sexo', 'M', FALSE , 'class="" ') . '<label class="form-check-label" for="radio_sexo"> Masculino </label><br>';
                $radio_sexo .= form_radio('radio_sexo', 'F', TRUE , 'class="" '). '<label class="form-check-label" for="radio_sexo"> Femenino </label>';
			 }		
			
			 // =============================================================================
             //CREAR SELECT DE TIPO DOCUMENTO
             $array_tipo = array(
                 1 => 'DNI',
                 2 => 'Otros'
             ) ;
            
             //string del select customizado 
             $dropdown_tipo = form_dropdown('select_tipo_doc', $array_tipo, $id_tipo_doc,"class='select2 form-control form-control-lg' id='select_tipo_doc' " );

            // =============================================================================
            //CREAR SELECT ESTADO SIS
            $array_estado = array(
                NULL => '',
                1 => 'Activo',
                0 => 'Inactivo',

            ) ;

            //string del select customizado
            $dropdown_estado = form_dropdown('select_estado', $array_estado, $id_estado_sis,"class='select2 form-control form-control-lg' id='select_estado'  data-placeholder='Seleccione'  " );


            // =============================================================================
            //Para fecha de nacimiento
            $fecha_nacimiento =  new DateTime($paciente->excel_fechaNaci_paci );
            $fecha_nacimiento = $fecha_nacimiento->format('d/m/Y');

            //Fecha de Afiliación
            if($paciente->excel_fechaAfiliacion_paci != '0000-00-00' &&  $paciente->excel_fechaAfiliacion_paci != NULL ){
                $fecha_afiliacion =  new DateTime($paciente->excel_fechaAfiliacion_paci);
                $fecha_afiliacion = $fecha_afiliacion->format('d/m/Y');
            } else {
                $fecha_afiliacion = '';
            }

            //Fecha de baja
            if($paciente->excel_fechaBaja_paci != '0000-00-00' &&  $paciente->excel_fechaBaja_paci != NULL ){
                $fecha_baja =  new DateTime($paciente->excel_fechaBaja_paci);
                $fecha_baja = $fecha_baja->format('d/m/Y');
            } else {
                $fecha_baja = '';
            }

            // =============================================================================
            //CREAR SELECT DE EESS
            //Obtener EESS
            $this->load->model('reutilizables/Model_codigos_renaes');
            $lst_niveles = $this->Model_codigos_renaes->listado_codigos();
            $array_eess= array();
            foreach ($lst_niveles as $nivel) {
                $array_eess[$nivel->id_codigo_renaes] = $nivel->micro_red_codren;
            }
            //string del select customizado
            $dropdown_eess = form_dropdown('select_establecimiento', $array_eess, $id_eess," class='select2 form-control form-control-lg' style='width: 100%;'  id='select_establecimiento'      " );




            $data = array (
			 				 'paciente'		    	    => $paciente,
			 				 'fecha_naci_string'        => $fecha_nacimiento,
			 				 'radio_sexo'			    => $radio_sexo,
			 				 'select_tipo_doc'	        => $dropdown_tipo,
                             'select_estado'            => $dropdown_estado,
                            'fecha_afiliacion_string'   => $fecha_afiliacion,
                            'fecha_baja_string'                => $fecha_baja,
                            'select_eess'               => $dropdown_eess
			 				 
			 				); 
                      
             $this->load->view('gestores/pacientes/vista_editar',$data)  ;
                            
              
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
		        
        if(  $this->auth_role == 'admin' || $this->auth_level == 5 )
        {
             $post =  $this->input->post(); 		
			//print_r($post);  exit;
			
                   
             $this->mi_validacion_editar($post);
			
			//comprobar si el formulario es valido
			if( $this->form_validation->run() == FALSE )
            {
               //regresa al formulario de actualizar                                        
               $this->form_editar($post['hidden_id_paciente']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar: al registro $post[hidd_id_empleado]";exit;            	
            	$id_paciente	= $post['hidden_id_paciente'];

                //para checkbox posee sis
                if( isset($post['checkbox_posee_sis'])  ) {
                    $post['checkbox_posee_sis'] = 1;
                }else {
                    $post['checkbox_posee_sis'] = 0;
                }

                //EN CASO NO POSEA SIS
                if($post['checkbox_posee_sis'] == 0) {
                    $post['text_id_sis'] = NULL;
                }

                if($post['checkbox_posee_sis'] == 0) {
                    $post['select_estado'] = NULL;
                }


                //Fecha Nacimiento
                $fecha_emision = explode('/' ,  $post['text_fecha_naci']) ;
                $dia = $fecha_emision[0];
                $mes = $fecha_emision[1];
                $anyo = $fecha_emision[2];
                $post['text_fecha_naci'] = $anyo . '-' . $mes . '-'  . $dia ;

                //Fecha Afiliación
                if( $post['text_fecha_afiliacion'] != ''  ) {
                    $fecha_emision = explode('/' ,  $post['text_fecha_afiliacion']) ;
                    $dia = $fecha_emision[0];
                    $mes = $fecha_emision[1];
                    $anyo = $fecha_emision[2];
                    $post['text_fecha_afiliacion'] = $anyo . '-' . $mes . '-'  . $dia ;
                }
                else{
                    $post['text_fecha_afiliacion'] = NULL;
                }


                //Fecha Baja
                if( $post['text_fecha_baja'] != '' ) {
                    $fecha_emision = explode('/' ,  $post['text_fecha_baja']) ;
                    $dia = $fecha_emision[0];
                    $mes = $fecha_emision[1];
                    $anyo = $fecha_emision[2];
                    $post['text_fecha_baja'] = $anyo . '-' . $mes . '-'  . $dia ;
                }
                else{
                    $post['text_fecha_afiliacion'] = NULL;
                }

				//echo $id_paciente; exit;
				
				//actualizar en la BD
            	$this->load->model('gestores/pacientes/Model_editar');
				$res  = $this->Model_editar->editar_paciente($id_paciente, $post);
				
				
							
				//comprobar si se guardó exitosamente el registro
				if ( $res == TRUE  )	{				 					
					//datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'actualizado');
                				
	            		
					//redirección de acuerdo al boton
					if($post['btn_subir'] == 'listar') 
            			 redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
						
				}
				else{
					 //datos guardados correctamente
					 $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                	 redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
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
		$id_registro	= $post['hidden_id_paciente'];
        $this->load->model('gestores/pacientes/Model_editar');
		$paciente  = $this->Model_editar->obtener_paciente($id_registro);
	
		
		//=== comprueba si el nombre de la persona ya existe
		if($paciente->excel_asegurado_paci != $post['text_nombres'])
		{
		  //para el nombre        
            $this->form_validation->set_rules('text_nombres', 'Nombres', 'required|trim|min_length[2]|max_length[250]|is_unique[tbl_pacientes.excel_asegurado_paci]' ,
                        //mensajes personalizados de cada regla de validación
                        array(
                            //'is_unique'     => 'Este <b> %s </b> ya existe.'
                        )
            );
		}else 
		{
			$this->form_validation->set_rules('text_nombres', 'Nombres', 'required|trim|min_length[2]|max_length[250]' );
		}


        // ==== para el Tipo de documento =====
        $this->form_validation->set_rules('select_tipo_doc', 'Tipo de DOC', 'required|trim' ,
            //mensajes personalizados de cada regla de validación
            array(
                'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );

        // ==== para el # de DOC =====
        $this->form_validation->set_rules('text_num_documento', '# de Documento', 'max_length[20]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );

        // ==== para Sexo  =====
        $this->form_validation->set_rules('radio_sexo', 'Sexo', 'required|in_list[M,F]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Este <b> %s </b> ya existe.'
            )
        );
        // ==== para Fecha de nacimiento  =====
        $this->form_validation->set_rules('text_fecha_naci', 'Fecha de Nacimiento', 'required|trim|callback_validacion_fecha' ,
            //mensajes personalizados de cada regla de validación
            array(
                'validacion_fecha'     => ' <b> %s </b> no valida'
            )
        );

        // ==== para PROVINCIA =====
        $this->form_validation->set_rules('text_historial', 'Provincia', 'trim|max_length[50]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Opción <b> %s </b> no válida'
            )
        );
										

	}


    //comprueba si el texto es una fecha válida con formato YYYY-MM-DD
    public function validacion_fecha($fecha){
        //print_r(var_dump($str));exit;
        if($fecha == ''){
            return true;
        }

        $array_fecha = explode('/' ,  $fecha) ;
        $dia = $array_fecha[0];
        $mes = $array_fecha[1];
        $anyo = $array_fecha[2];

        $fecha_valida =  checkdate($mes, $dia, $anyo);

        if (!$fecha_valida)
        {
            //$this->form_validation->set_message('fecha', 'La fecha  no es valida');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    
    
}
