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
	 
	  public function form_editar($id_registro = null){

          // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4 || $this->auth_level == 3 )
        {


         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null )
			  redirect('solicitud/listar/listar_solicitudes');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('solicitud/Model_editar');
             $solicitud  = $this->Model_editar->obtener_solicitud($id_registro);
			 
			 //si no existe ningún registro con el id seleccionado, redireccionar al listar
			 if($solicitud == NULL)
                 redirect('solicitud/listar/listar_solicitudes');

			 //comprobar si tiene permiso para ver la solicitud de acuerdo a su agencia
			 //si es 8=Gerente;7=Asesor, 4=Analista, 3=Articulador
            if($this->auth_level == 8 || $this->auth_level == 7 || $this->auth_level == 4 || $this->auth_level == 3  ) {
                //usuario dentro del sistema
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);

                //comprobación de agencia
                if($solicitud->id_agencia_soli !=  $usuario->id_agencia_user)  {
                    echo $this->load->view('errors/vista_sin_acceso' ,'' , TRUE);
                    exit;
                }
            }

            //comprobar si tiene permiso para ver la solicitud de acuerdo a si fue destinada a él
            //si 7=Asesor
            if($this->auth_level == 7   ) {
                //usuario dentro del sistema
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);

                //comprobación de agencia
                if($solicitud->id_user_asesor_destino_soli !=  $this->auth_user_id)  {
                    echo $this->load->view('errors/vista_sin_acceso' ,'' , TRUE);
                    exit;
                }
            }

            //comprobar si tiene permiso para ver la solicitud si el articulador fue quién la creo
            //si 3=Articulador
            if($this->auth_level == 3   ) {
                //usuario dentro del sistema
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);

                //comprobación de agencia
                if($solicitud->id_user_articulador_soli !=  $this->auth_user_id)  {
                    echo $this->load->view('errors/vista_sin_acceso' ,'' , TRUE);
                    exit;
                }
            }


			 //Datos de la solicitud
              $id_agencia           = $solicitud->id_agencia_soli;
			  $id_estado_civil      = $solicitud->id_estado_civil_soli;

			  $id_grado             = $solicitud->id_grado_instru_titular_soli;
			  $id_grado_conyugue    = $solicitud->id_grado_instru_conyugue_soli;

			  $id_grado_aval        = $solicitud->id_grado_instru_aval_soli;
			  $id_departamento      = $solicitud->id_departamento_titular_soli;
			  $id_provincia         = $solicitud->id_provincia_titular_soli;
              $id_distrito          = $solicitud->id_distrito_titular_soli;
              //para las actividades
              $id_terreno_principal = $solicitud->terreno_principal_titular_soli;
              $id_terreno_secundaria = $solicitud->terreno_secundaria_titular_soli;
              //Para datos familiares
              $id_tenencia_vivienda     = $solicitud->id_tenencia_vivienda_soli;
              $id_servicios_basicos     = $solicitud->id_servicios_basicos_soli;
              $id_tipo_socio            = $solicitud->id_tipo_socio_soli;

            // =============================================================================
            //CREAR SELECT AGENCIA
            $this->load->model('reutilizables/Model_agencias');
            $lst_agencias = $this->Model_agencias->listado_agencias();
            $array_agencias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_agencias as $agencia) {
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
            }
            //string del select customizado
            $dropdown_agencias = form_dropdown('select_agencias', $array_agencias, $id_agencia,"class='select2 form-control ' id='select_agencias' disabled='' " );

            // =============================================================================
              //CREAR SELECT ESTADO CIVIL
              //para que cree el array de id y nombre del select = estado_civil
              $lst_estado_civil = array(
             					1 => 'Soltero',
                                2 => 'Conviviente',
                                3 => 'Viudo',
                                4 => 'Casado',
                                5 => 'Divorciado',
                               );
                
                //string del select customizado 
                $dropdown_estado_civil = form_dropdown('select_estado_civil', $lst_estado_civil, $id_estado_civil," class='select2 form-control ' id='select_estado_civil'   disabled='' data-placeholder='Estado civil'   " );
				
				// =============================================================================
				 //CREAR SELECT DE GRADO EDUCACION TITULAR
              //para que cree el array de id y nombre del select = Grado de instruccion
              $lst_grado = array(
             					1 => 'Superior',
                                2 => 'Técnico',
                                3 => 'Secundaria',
                                4 => 'Primaria',
                                5 => 'Sin Instrucción',
                               );
                
                //string del select customizado 
                $dropdown_grado = form_dropdown('select_grado_instru_titular', $lst_grado, $id_grado," class='select2 form-control ' id='select_grado_instru_titular'   disabled='' data-placeholder=''   " );

				 //CREAR SELECT DE GRADO  COYUGUE                       
              //para que cree el array de id y nombre del select = Grado de instruccion
              $lst_grado_conyugue = array(
             					0 => '',
             					1 => 'Superior',
                                2 => 'Técnico',
                                3 => 'Secundaria',
                                4 => 'Primaria',
                                5 => 'Sin Instrucción',
                               );
                
                //string del select customizado 
                $dropdown_grado_conyugue = form_dropdown('select_grado_instru_conyugue', $lst_grado_conyugue, $id_grado_conyugue," class='select2 form-control ' id='select_grado_instru_conyugue'   disabled='' data-placeholder=''   " );



            //CREAR SELECT DE GRADO  AVAL
              //para que cree el array de id y nombre del select = Grado de instruccion
              $lst_grado_aval = array(
             					0 => '',
             					1 => 'Superior',
                                2 => 'Técnico',
                                3 => 'Secundaria',
                                4 => 'Primaria',
                                5 => 'Sin Instrucción',
                               );

                //string del select customizado
                $dropdown_grado_aval = form_dropdown('select_grado_instru_aval', $lst_grado_aval, $id_grado_aval," class='select2 form-control ' id='select_grado_instru_aval'   disabled='' data-placeholder=''   " );

				  // =============================================================================
              //CREAR SELECT DE TENENCIA DE VIVIENDA
              //para que cree el array de id y nombre del select = tenencia_terreno
              $lst_tenencia_viviencia = array(
                                0 => '',
             					1 => 'Propio',
                                2 => 'Alquilado',
                                3 => 'Familiar',
                                4 => 'Ambulante',
                                5 => 'Cedido',
                               );
                
                //string del select customizado 
                $dropdown_tenencia_vivienda = form_dropdown('select_tenencia_vivienda', $lst_tenencia_viviencia, $id_tenencia_vivienda," class='select2 form-control ' id='select_tenencia_vivienda'   disabled=''   " );

            // =============================================================================
            //CREAR SELECT DE SERVICIOS BÁSICOS
            //para que cree el array de id y nombre del select = tenencia_terreno
            $lst_servicios_basicos = array(
                0 => '',
                1 => 'Luz, Agua, Desagüe y Teléfono',
                2 => 'Luz, Agua y  Desagüe',
                3 => 'Agua y  Desagüe',
                4 => 'Agua',
                5 => 'Ninguno',
            );

            //string del select customizado
            $dropdown_servicios_basicos = form_dropdown('select_servicios_basicos', $lst_servicios_basicos, $id_servicios_basicos," class='select2 form-control ' id='select_tenencia_vivienda'   disabled=''   " );

            // =============================================================================
            //CREAR SELECT DE TIPO SOCIO
            //para que cree el array de id y nombre del select = tenencia_terreno
            $lst_tipo_socio = array(
                0 => '',
                1 => 'Nuevo',
                2 => 'Recurrente',
            );

            //string del select customizado
            $dropdown_tipo_socio = form_dropdown('select_tipo_socio', $lst_tipo_socio, $id_tipo_socio," class='select2 form-control ' id='select_tipo_socio'   disabled=''   " );


            // ====== OBTENER DATOS DE LAS TABLAS ===========
                 $tabla_deuda_titular  = $this->Model_editar->obtener_tabla_deuda_titular($id_registro);

                 $tabla_deuda_conyuge  = $this->Model_editar->obtener_tabla_deuda_conyuge($id_registro);

                 $tabla_cultivo  = $this->Model_editar->obtener_tabla_cultivo($id_registro);

                 $tabla_pecuaria  = $this->Model_editar->obtener_tabla_pecuaria($id_registro);

                 $tabla_derivados  = $this->Model_editar->obtener_tabla_derivados($id_registro);

                 $tabla_otras  = $this->Model_editar->obtener_tabla_otras($id_registro);

                // ====== VERIFICAR ESTADO (para mostrar en la parte superior) ===========
                $id_estado = $solicitud->id_estado_soli;
                if($id_estado == 1) {
                    // return 'en proceso';
                    $estado_solicitud =   '<a href="#" class="badge  badge-warning">En proceso</a>';
                }else if ($id_estado == 2){
                    $estado_solicitud = '<span class="badge badge-success">Apta</span>';
                }else if ($id_estado == 3){
                    $estado_solicitud =  '<span class="badge badge-danger">Rechazada</span>';
                }else{
                    $estado_solicitud = 'Solicitud sin estado';
                }

                //obtener la fecha de hoy
                $this->load->helper('fechas');
                $fecha_convertido = fecha_transformar_fecha($solicitud->fecha_registro_soli);

            // =============================================================================
            //CREAR SELECT DEPARTAMENTOS
            $this->load->model('reutilizables/zonas/Model_departamentos');
            $lst_departamentos = $this->Model_departamentos->listado_departamentos();
            $array_departamentos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_departamentos as $departamento) {
                $array_departamentos[$departamento->idDepa] = $departamento->departamento;
            }
            //string del select customizado
            $dropdown_departamentos = form_dropdown('select_departamentos', $array_departamentos, $id_departamento,"class='select2 form-control ' id='select_departamentos' disabled='' " );

            // =============================================================================
            //CREAR SELECT PROVINCIAS
            $this->load->model('reutilizables/zonas/Model_provincias');
            $lst_provincias = $this->Model_provincias->listado_provincias();
            $array_provincias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_provincias as $provincia) {
                $array_provincias[$provincia->idProv] = $provincia->provincia;
            }
            //string del select customizado
            $dropdown_provincias = form_dropdown('select_provincias', $array_provincias, $id_provincia,"class='select2 form-control ' id='select_provincias' disabled='' " );

            // =============================================================================
            //CREAR SELECT DISTRITOS
            $this->load->model('reutilizables/zonas/Model_distritos');
            $lst_distritos = $this->Model_distritos->listado_distritos();
            $array_distritos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_distritos as $distrito) {
                $array_distritos[$distrito->idDist] = $distrito->distrito;
            }
            //string del select customizado
            $dropdown_distritos = form_dropdown('select_distritos', $array_distritos, $id_distrito,"class='select2 form-control ' id='select_distritos' disabled='' " );

            // =============================================================================
            //CREAR SELECT tipo TERRENO PRINCIPAL
            $lst_tenencia_terreno = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );

            //string del select customizado
            $dropdown_terreno_principal = form_dropdown('select_terreno_principal_titular', $lst_tenencia_terreno, $id_terreno_principal," class='select2 form-control ' id='select_terreno_principal_titular'   disabled=''   " );

            // =============================================================================
            //CREAR SELECT tipo TERRENO SECUNDARIA
            $lst_tenencia_terreno = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );

            //string del select customizado
            $dropdown_terreno_secundaria = form_dropdown('select_terreno_secundaria_titular', $lst_tenencia_terreno, $id_terreno_secundaria," class='select2 form-control ' id='select_terreno_secundaria_titular'   disabled=''   " );


            // =============================================================================
            //CREAR CHECKBOXES VENDE PRODUCCIÓN con multiple selección (1=Asociación , 2=Coperativa, 3=Comité Produc  4=Intermediario )
            //para que cree el array de id y nombre del select = estado_civil

            $checkbox_vende_produccion = array();

            if( strpos( $solicitud-> vende_produccion_soli, '1' ) !== FALSE ) {
                $checkbox_vende_produccion['asociacion']         = form_checkbox('checkbox_vende_produccion[]', 1 , TRUE,' id="checkbox_asociacion" onclick="return false;" ');
            }else  {
                $checkbox_vende_produccion['asociacion']         = form_checkbox('checkbox_vende_produccion[]', 1 , FALSE,' id="checkbox_asociacion" onclick="return false;"');
            }

            if( strpos( $solicitud-> vende_produccion_soli, '2' ) !== FALSE ) {
                $checkbox_vende_produccion['cooperativa']         = form_checkbox('checkbox_vende_produccion[]', 2 , TRUE,' id="checkbox_cooperativa" onclick="return false;" ');
            }else  {
                $checkbox_vende_produccion['cooperativa']         = form_checkbox('checkbox_vende_produccion[]', 2 , FALSE,' id="checkbox_cooperativa"  onclick="return false;"');
            }

            if( strpos( $solicitud-> vende_produccion_soli, '3' ) !== FALSE ) {
                $checkbox_vende_produccion['comite']         = form_checkbox('checkbox_vende_produccion[]', 3 , TRUE,' id="checkbox_comite" onclick="return false;"');
            }else  {
                $checkbox_vende_produccion['comite']       = form_checkbox('checkbox_vende_produccion[]', 3 , FALSE,' id="checkbox_comite" onclick="return false;" ');
            }

            if( strpos( $solicitud-> vende_produccion_soli, '4' ) !== FALSE ) {
                $checkbox_vende_produccion['intermediario']        = form_checkbox('checkbox_vende_produccion[]', 4 , TRUE,' id="checkbox_intermediario" onclick="return false;"');
            }else  {
                $checkbox_vende_produccion['intermediario']         = form_checkbox('checkbox_vende_produccion[]', 4 , FALSE,' id="checkbox_intermediario" onclick="return false;" ');
            }

            //PARA Select's del bloque de DEUDA DE SISTEMA FINACIERO

            // =============================================================================
            //CREAR SELECT REGISTRA DEUDA LOS ÚLTIMOS 24 MESES
            $lst_registra_deuda_titular = array(
                '' => '',
                'SI' => 'SI',
                'NO' => 'NO',
            );

            //string del select customizado con color
            if ( $solicitud->registra_deuda_titular_soli == 'SI') {
                $dropdown_registra_deuda_titular = form_dropdown('select_registra_deuda_titular', $lst_registra_deuda_titular, $solicitud->registra_deuda_titular_soli ," class='select2 form-control ' id='select_registra_deuda_titular'   disabled=''  style='background: red; font-weight: bold; color:white; '   " );
            } else {
                $dropdown_registra_deuda_titular = form_dropdown('select_registra_deuda_titular', $lst_registra_deuda_titular, $solicitud->registra_deuda_titular_soli ," class='select2 form-control ' id='select_registra_deuda_titular'   disabled=''   " );
            }

            //CREAR SELECT REGISTRA DEUDA LOS ÚLTIMOS 24 MESES
            $lst_registra_deuda_conyuge = array(
                '' => '',
                'SI' => 'SI',
                'NO' => 'NO',
            );

            //string del select customizado con color
            if($solicitud->registra_deuda_conyuge_soli == 'SI') {
                $dropdown_registra_deuda_conyuge = form_dropdown('select_registra_deuda_conyuge', $lst_registra_deuda_titular, $solicitud->registra_deuda_conyuge_soli ," class='select2 form-control ' id='select_registra_deuda_conyuge'   disabled='' style='background: red; font-weight: bold; color:white; '  " );
            } else {
                $dropdown_registra_deuda_conyuge = form_dropdown('select_registra_deuda_conyuge', $lst_registra_deuda_titular, $solicitud->registra_deuda_conyuge_soli ," class='select2 form-control ' id='select_registra_deuda_conyuge'   disabled=''   " );
            }


            $data = array (
                                 'solicitud'		           => $solicitud,
                                 'fecha_convertido'            => $fecha_convertido,
                                 'select_agencias'             => $dropdown_agencias,
                                 'select_estado_civil'         => $dropdown_estado_civil,
                                 'select_grado'                => $dropdown_grado,

                                'select_departamentos'     => $dropdown_departamentos,
                                'select_provincias'        => $dropdown_provincias,
                                'select_distritos'         => $dropdown_distritos,
                                'select_terreno_principal_titular'    => $dropdown_terreno_principal,
                                'select_terreno_secundaria_titular'    => $dropdown_terreno_secundaria,
                                 'select_grado_conyugue'       => $dropdown_grado_conyugue,
                                 'select_grado_aval'           => $dropdown_grado_aval,
                                 //datos familiares
                                'select_tenencia_vivienda'   => $dropdown_tenencia_vivienda,
                                'select_servicios_basicos'   =>  $dropdown_servicios_basicos,
                                'select_tipo_socio'          => $dropdown_tipo_socio,
                                 'id_tipo_socio'             => $id_tipo_socio,
                                'checkbox_vende_produccion'  => $checkbox_vende_produccion,

                                //Bloque de deuda de sistema finaciero
                                'select_registra_deuda_titular'          =>$dropdown_registra_deuda_titular,
                                 'select_registra_deuda_conyuge'          =>$dropdown_registra_deuda_conyuge,

                                 //Tablas varias
                                'tabla_deuda_titular'           =>  $tabla_deuda_titular,
                                'tabla_deuda_conyuge'           =>  $tabla_deuda_conyuge,
                                 'tabla_cultivo'                =>  $tabla_cultivo,
                                 'tabla_pecuaria'               =>  $tabla_pecuaria,
                                 'tabla_derivados'               =>  $tabla_derivados,
                                 'tabla_otras'                  =>  $tabla_otras,
                                 //estado html
                                 'estado_solicitud'             => $estado_solicitud



                 );

                 $this->load->view('solicitud/vista_editar',$data)  ;
                            
              
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
		        
        if(  $this->auth_level == 9 || $this->auth_level == 7 )
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
