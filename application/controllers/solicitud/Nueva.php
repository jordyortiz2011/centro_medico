<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nueva extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin

        $this->load->helper('form');
        
    }
	
	public function index(){
		redirect('solicitud/nueva/form_ficha_matricula');
	}
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro
     * @param  -_-  
     */   
    public function form_nueva()
    {

        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4 || $this->auth_level == 3 )
        {
		    // === fecha actual ===	      
            $hoy = new DateTime();	//fecha de hoy	
            $hoy_fecha  = $hoy->format('Y-m-d H:i');

            $hoy_menos_18_anos  = $hoy->sub(new DateInterval('P18Y'));
            $hoy_menos_18_anos = $hoy_menos_18_anos->format('Y-m-d');


            //obtener la fecha de hoy
            $this->load->helper('fechas');
            $fecha_convertido = fecha_transformar_fecha_sin_hora($hoy_fecha);

            //obtener nombre de usuario activo
            $this->load->model('reutilizables/Model_usuarios');
            $nombre_usuario = $this->Model_usuarios->obtener_usuario_registrador_completo($this->auth_user_id);

            // ======= ZONAS ========
            //Obtener listado de departamentos
            $this->load->model('reutilizables/zonas/Model_departamentos');
            $lst_departamentos = $this->Model_departamentos->listado_departamentos();


            // ======= SELECT AGENCIAS  ========
            if( $this->auth_level == 9   )
            {
                // ===  CREAR  SELECT AGENCIA ========
                $this->load->model('reutilizables/Model_agencias');
                $lst_agencias = $this->Model_agencias->listado_agencias();
                //print_r($lst_departamentos);

                //para que cree el array de id y nombre del select = unidades de medida
                $array_agencias[''] = 'Seleccione';
                foreach ($lst_agencias as $agencia) {
                    $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
                }

                $dropdown_agencias = form_dropdown('select_agencias', $array_agencias, '',"class='select2 form-control' id='select_agencias' " );

            } //Sino es analista
            else {
                //Obtener datos del usuario
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);
                $id_agencia = $usuario->id_agencia_user;


                //Obtener departamento
                $this->load->model('reutilizables/Model_agencias');
                $agencia =  $this->Model_agencias->obtener_agencia($id_agencia);
                //Crear array para el Select
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;


                $dropdown_agencias = form_dropdown('select_agencias', $array_agencias, $id_agencia,"class='select2 form-control' id='select_agencias' readonly='readonly' " );

            }

            // ======= SELECT ASESORES DE CRÉDITO  ========
            if( $this->auth_level == 3   )
            {
                // ===  CREAR  SELECT ASESORES ========

                //1ero Obtener datos del usuario
                $this->load->model('reutilizables/Model_usuarios');
                $usuario = $this->Model_usuarios->obtener_usuario_xID($this->auth_user_id);
                $id_agencia = $usuario->id_agencia_user;

                $this->load->model('reutilizables/Model_asesores');
                $lst_asesores = $this->Model_asesores->listado_asesores($id_agencia);
                //print_r($lst_departamentos);

                //para que cree el array de id y nombre del select = unidades de medida
                $array_asesores[''] = 'Seleccione';
                foreach ($lst_asesores as $asesor) {
                    $array_asesores[$asesor->user_id] =   $asesor->nombres_user . ', ' . $asesor->apellido_pat_user. ' '. $asesor->apellido_mat_user;
                }

                $dropdown_asesores = form_dropdown('select_asesores', $array_asesores, '',"required class='form-control' id='select_asesores' " );

            } //si no es articulador
            else {

                //Crear array para el Select
                $array_asesores[''] = 'Seleccione';

                $dropdown_asesores = form_dropdown('select_asesores', $array_asesores, '',"required class='form-control' id='select_asesores' " );

            }

            //maximo tamaño en bytes permitido en el servidor
            $max_post_length = (int)(str_replace('M', '', ini_get('post_max_size')) * 1024 * 1024);
            $maximo_megas = round($max_post_length / (1024*1024), 2);



			$data = array(								
							'hoy'		   		=> $hoy_fecha ,
                            'hoy_menos_18_anos' => $hoy_menos_18_anos,
                            'fecha_convertido'  => $fecha_convertido,
                            'nombre_usuario'    => $nombre_usuario,
                            'lst_departamentos' => $lst_departamentos,
                            'select_agencias'   => $dropdown_agencias,
                            'select_asesores'   => $dropdown_asesores,
                            'maximo_megas'      => $maximo_megas
						  );

                         
            $this->load->view('solicitud/vista_nueva', $data);
        }
  
    }

    /**
     * Obtiene los datos del formulario solicitud  los procesa,
     * valida, y los envia al modelo, para guardar en la BD
     * Permiso: solo administradores y analistas
     * @param
     * @return  (carga  la vista de listado)
     */
    public function procesa()
    {

        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        if( $this->auth_level == 9 || $this->auth_level == 8 ||$this->auth_level == 7 || $this->auth_level == 4 || $this->auth_level == 3 )
        {
            $post = $this->input->post();
            //print_r($post) ;


            //establecer reglas de validacion:
            $this->validacion_reglas();

            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE )
            {
                //$this->load->view('formulario/vista_formulario');
                $this->form_nueva();
            }
            else {

                if ($post['text_fecha_naci_conyugue']=='') {
                   $post['text_fecha_naci_conyugue']=NULL;
                }

                if ($post['text_fecha_naci_aval']=='') {
                   $post['text_fecha_naci_aval']=NULL;
                }
                if ($post['text_fecha_naci_conyu_aval']=='') {
                    $post['text_fecha_naci_conyu_aval']=NULL;
                }

                $array_vende_produccion = $post['checkbox_vende_produccion'];
                $array_vende_produccion = implode(";", $array_vende_produccion);
                $post['string_vende_produccion'] = $array_vende_produccion;

                //para checkbox de comprobación si posee aval
                $post['checkbox_posee_aval'] = isset($post['checkbox_posee_aval']) ? 1 : 0 ;

                //Para campo de registra deuda titular
                $post['hidden_registra_deuda_titular'] =  $post['hidden_registra_deuda_titular'] == 'SI' ?  'SI' :'NO' ;


                //Para campo de registra deuda conyuge
                $post['hidden_registra_deuda_conyuge'] =  $post['hidden_registra_deuda_conyuge'] == 'SI' ?  'SI' :'NO' ;


                $this->load->model('solicitud/Model_registrar');
                $id_solicitud =  $this->Model_registrar->guardar_solicitud($post);

                //verifica si  registró el ciclo correctamente (si el valor devuelto es numerico)
                if( is_numeric($id_solicitud)) {

                    //empezar a registrar las tablas adicionales
                    $result_tabla_deuda_titular     =  $this->Model_registrar->guardar_tabla_deuda_titular($id_solicitud,$post);

                    $result_tabla_deuda_conyuge     =  $this->Model_registrar->guardar_tabla_deuda_conyuge($id_solicitud,$post);

                    $result_tabla_cultivo  =  $this->Model_registrar->guardar_tabla_cultivo($id_solicitud,$post);

                    $result_tabla_pecuaria  =  $this->Model_registrar->guardar_tabla_pecuaria($id_solicitud,$post);

                    $result_tabla_derivados  =  $this->Model_registrar->guardar_tabla_derivados($id_solicitud,$post);

                    $result_tabla_otras     =  $this->Model_registrar->guardar_tabla_otras($id_solicitud,$post);


                    //exit;

                    if($result_tabla_deuda_titular == true && $result_tabla_deuda_conyuge == true && $result_tabla_cultivo == true && $result_tabla_pecuaria == true && $result_tabla_derivados == true && $result_tabla_otras == true) {
                        //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)

                        //si es un articulador enviar correos
                        if($this->auth_level == 3 ){
                            //Id de la solicitud, e id del asesor de destino
                            $this->enviar_correos($id_solicitud , $post['select_asesores'], $post['select_agencias']);
                        }

                        //si es un articulador ingresa  adjuntar foto
                        if($this->auth_level == 3 ){
                            //nombre de la foto
                            $result_foto = $this->do_upload($id_solicitud);
                        }


                        $this->session->set_flashdata('estado_registro', 'registrado');

                        //redirección de acuerdo al boton
                        if($post['btn_subir'] == 'permanecer')
                            redirect('solicitud/nueva/form_nueva', 'refresh');
                        else if($post['btn_subir'] == 'listar')
                            redirect('solicitud/listar/listar_solicitudes', 'refresh');
                        else
                            redirect('solicitud/listar/listar_solicitudes', 'refresh');
                    }else {

                        //registro ERROR, entonces mostramos mensaje y cargamos de nuevo vista registrar
                        $this->session->set_flashdata('estado_registro', 'registrar_error');
                        redirect('solicitud/listar/listar_solicitudes', 'refresh');
                    }


                }else {

                    //registro ERROR, entonces mostramos mensaje y cargamos de nuevo vista registrar
                    $this->session->set_flashdata('estado_registro', 'registrar_error');
                    redirect('solicitud/listar/listar_solicitudes', 'refresh');
                }



            }//fin de form_validation->run()

        } //Fin validación de roles
        else
        {
            $this->load->view('errors/vista_sin_acceso');
        }
    }


    /**
     * Reglas de validacion para formulario
     */
    private function validacion_reglas ()
    {
        //carga la libreria para validar formulario
        $this->load->library('form_validation');
        $this->config->set_item('language', 'spanish');

        // ==== para el nombre de aula =====
        $this->form_validation->set_rules('text_nombres_titular', 'Nombres titular', 'required|trim|min_length[3]|max_length[200]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.'
            )
        );

        // ==== para el apellido paterno titular =====
        $this->form_validation->set_rules('text_apellido_pat_titular', 'Apellido paterno', 'required|trim|min_length[3]|max_length[100]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.'
            )
        );
        // ==== para el apellido materno titular =====
        $this->form_validation->set_rules('text_apellido_mat_titular', 'Apellido materno', 'required|trim|min_length[3]|max_length[100]' ,
            //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.'
            )
        );

        // ==== para el DNI del titular =====
       $this->form_validation->set_rules('text_dni_titular', 'DNI titular', 'required|trim|min_length[8]|max_length[8]|callback_validacion_solicitud_inconclusa' ,
            //$this->form_validation->set_rules('text_dni_titular', 'DNI titular', 'required|trim|min_length[8]|max_length[8]' ,

                //mensajes personalizados de cada regla de validación
            array(
                //'is_unique'     => 'Esta <b> %s </b> ya existe.'
                'validacion_solicitud_inconclusa'    => 'El DNI del titular posee una solicitud inconclusa'

            )
        );



        // ==== para el SELECT ESTADO CIVIL =====
        $this->form_validation->set_rules('select_estado_civil', 'estado civil', 'required|trim|in_list[1,2,3,4,5]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Elija un <b> %s </b>  válido'
            )
        );

        // ==== para el SELECT TIPO DE SOCIO =====
        $this->form_validation->set_rules('select_tipo_socio', 'Tipo de socio', 'required|trim|in_list[1,2]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Elija un <b> %s </b>  válido'
            )
        );

        // ==== para el SELECT SERVICIOS BÁSICOS =====
        $this->form_validation->set_rules('select_servicios_basicos', 'Servicios básicos', 'required|trim|in_list[1,2,3,4,5]' ,
            //mensajes personalizados de cada regla de validación
            array(
                'in_list' => 'Seleccione   <b> %s </b>  válido'
            )
        );

        //===== para DEPARTAMENTO  ======
        // obtener listado de colegios
        $this->load->model('reutilizables/zonas/Model_departamentos');
        $lst_departamentos = $this->Model_departamentos->listado_departamentos();

        $string_departamentos = ''; //Id de los departamentos
        foreach ($lst_departamentos as $departamento) {
            $string_departamentos .= $departamento->idDepa . ',';
        }
        $string_departamentos = trim($string_departamentos, ',');

        $this->form_validation->set_rules('select_departamentos', 'Departamentos', 'required|in_list[' . $string_departamentos. ']');

        //===== para PROVINCIA  ======
        // obtener listado de colegios
        $this->load->model('reutilizables/zonas/Model_provincias');
        $lst_provincias = $this->Model_provincias->listado_provincias();

        $string_provincias = ''; //Id de los departamentos
        foreach ($lst_provincias as $provincia) {
            $string_provincias .= $provincia->idProv . ',';
        }
        $string_provincias = trim($string_provincias, ',');

        $this->form_validation->set_rules('select_provincias', 'Provincias', 'required|in_list[' . $string_provincias. ']');

        //===== para Distritos  ======
        // obtener listado de colegios
        $this->load->model('reutilizables/zonas/Model_distritos');
        $lst_distritos = $this->Model_distritos->listado_distritos();

        $string_distritos = ''; //Id de los departamentos
        foreach ($lst_distritos as $distrito) {
            $string_distritos .= $distrito->idDist . ',';
        }
        $string_distritos = trim($string_distritos, ',');

        $this->form_validation->set_rules('select_distritos', 'Distritos', 'required|in_list[' . $string_distritos. ']');



    }//fin funcion validación reglas

    //comprueba si el texto es una fecha válida con formato YYYY-MM-DD
    public function validacion_fecha($fecha){
        //print_r(var_dump($str));exit;
        $array_fecha = explode('-' ,  $fecha) ;
        $anyo = $array_fecha[0];
        $mes = $array_fecha[1];
        $dia = $array_fecha[2];

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

    public function  validacion_solicitud_inconclusa($dni) {

        $this->db->select('*');
        $this->db->from('tbl_solicitudes');
        $this->db->where('id_estado_soli', 1); //1=en proceso, 2=Aprobada, 3=Rechazada
        $this->db->where('dni_titular_soli', $dni);


        //echo $this->db->get_compiled_select(); exit;

        $query = $this->db->get();
        $num = $query->num_rows();

        if ($num > 0) {
            //$this->form_validation->set_message('validacion_docente_ocupado', 'Docente ocupado en: <b>' . $horario->nombre_aula_cicloaula . '</b>');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Sólo llamará a esta función si es un articulador
    public function enviar_correos($id_solicitud, $id_asesor, $id_agencia){

        //1ero Obtener datos del asesor de destino, para enviar correo
        $this->load->model('reutilizables/Model_usuarios');
        $asesor  =  $this->Model_usuarios->obtener_usuario_xID( $id_asesor);

        //2do Obtener correos de los gerentes de agencia
        // 9=admin ; 8 = Gerente ; 7=Analista(crédito) ; 4=Analista de negocio ; 3=Articulador
        $this->load->model('solicitudes/Model_registrar');
        $usuarios  =  $this->Model_registrar->obtener_usuarios_xTipo_xAgencia( 8 , $id_agencia);
        //print_r($usuarios);
        //return;
        if ($usuarios == NULL ){
            //return false;
        }

        // =======  envio de email (IMPORTANTE) ===========
        $this->load->library("phpmailer_library");
        $mail = $this->phpmailer_library->load();

        //desactivar certificados de google
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = 0;// 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //Set the hostname of the mail server
        //$mail->Host = 'smtp.gmail.com';
        $mail->Host = gethostbyname('smtp.gmail.com');

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        //$mail->SMTPSecure = 'ssl';
        $mail->Username = 'prisma.microfinaciera@gmail.com';
        //Password to use for SMTP authentication
        $mail->Password = 'Miprisma2019';
        //Set who the message is to be sent from
        $mail->setFrom('prisma.microfinaciera@gmail.com', 'Prisma');

        //$mail->addAddress($this->input->post('email')); //Dirección para enviar
        $mail->addAddress($asesor->email); //para el asesor

        //para los gerentes de la agencia
        foreach ($usuarios as $usuario) {
            $mail->addAddress($usuario->email); //Dirección para enviar
        }


        //Set the subject line
        $mail->Subject = 'Solicitud Nueva';


        $ruta =  base_url('public/docs/plantilla_correo/');
        $message = file_get_contents( $ruta . 'solicitud_nueva.html');

        // Replace the % with the actual information
        //agregar el enlace al mensaje
        $enlace_nuevo  = base_url('solicitud/editar/form_editar/') . $id_solicitud ;
        $message = str_replace('%enlace%', $enlace_nuevo, $message);

        /* Personalizar mensaje */
        $message = str_replace('%email_titulo%', 'Solicitud Nueva', $message);
        $message = str_replace('%email_mensaje%', 'Se ha generado una nueva Solicitud', $message);
        $message = str_replace('%email_pie%', 'Ingrese al enlace para ver detalles', $message);
        $message = str_replace('%email_enlace%', 'Ingresar', $message);

        //$this->email->message($enlace_nuevo);
        $mail->Body = $message;
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Su servidor de correo no soporta HTML';

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            $view_data['correo_enviado'] = 0;

        } else {
            //MENSAJE ENVIADO
            $view_data['correo_enviado'] = 1;
            //echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #
        }

    }

    //Subir foto (usado al registrar, cuando se sube la foto)
    public function do_upload($id_solicitud)
    {
        if( (isset($_FILES['archivo']))  && $_FILES['archivo']['name'])
        {
            $config['upload_path']       = './public/img/fotos_solicitud/original/';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 8000; //2024 KB
            //$config['max_width']      = 1024;
            //$config['max_height']     = 768;
            $config['overwrite']        = true; //sobreescritura

            //concatenar:  nombre_de_la_foto  + time
            //$id_solicitud               = $post['id_solicitud'];
            $solo_nombre                = pathinfo($_FILES['archivo']['name'], PATHINFO_FILENAME);
            $solo_nombre                = url_title($solo_nombre, '_'); //cambio los espacios en blancos por '_' (guión bajo), así no afecta url
            $time = time();

            $config['file_name']  		=  $solo_nombre .  "_" . $time; //nombre de la foto, eje: 7212121_2105245.jpg

            //print_r($config);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('archivo'))
            {
                //NO SE SUBIÓ FOTO
                $error =  $this->upload->display_errors();
                echo $error;
                //$this->form_validation->set_message('do_upload', $error);
                //$this->session->set_flashdata('nombre_foto', '');

                return FALSE;
            }
            else
            {
                //subida correcta, entonces redimensiono
                $nombre_imagen_full  =  $this->upload->data('file_name'); //nombre de la imagen subida
                //echo $nombre_imagen_full; exit;

                $config['image_library']    = 'gd2';
                $config['source_image']     = './public/img/fotos_solicitud/original/' . $nombre_imagen_full ;
                $config['new_image']        = './public/img/fotos_solicitud/'; //ruta de la nueva imagen redimencionada
                //$config['create_thumb']   = TRUE;
                $config['maintain_ratio']   = TRUE;
                $config['width']            = 1280;
                $config['height']           = 768;
                $config['quality']          = 75;

                $this->load->library('image_lib', $config);

                if ( ! $this->image_lib->resize())
                {
                    //NO SE REDIMENSIONÓ FOTO
                    //$error = $this->image_lib->display_errors();
                    //$this->form_validation->set_message('do_upload', $error);
                    return FALSE;
                }
                else
                {

                    //echo "SUBIDA DE FICHERO Y REDIMENSIONADO CORRECTO <br>";

                    // === Capturamos sus datos de localizacion de la foto subida=========================
                    $exif = exif_read_data("./public/img/fotos_solicitud/original/$nombre_imagen_full", 'IFD0');


                    //para capturar coordenadas
                    //$exif = exif_read_data("./uploads/img_cosechas/$nombre");
                    if ( isset($exif["GPSLongitude"]) ) {
                        //echo $exif["GPSLongitude"];
                        //primero obtenemos las coordenadas a latitud y longitud
                        $lat = $this->getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                        $lon = $this->getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                        //var_dump($lat, $lon); EXIT;

                    }else{
                        //la imagen no contien  coordenadas,
                        //asignamos coordenadas a 0
                        $lat   =  0;
                        $lon = 0;

                    }

                    //asignaciones de variables

                    $nom_fichero = $nombre_imagen_full; //asignado arriba, al guardar el fichero

                    //si no tiene coordenadas no guardar
                    if($lat != 0 && $lon != 0 ) {
                        //registrar en la BD
                        $this->load->model('solicitud/Model_registrar');
                        $result = $this->Model_registrar->adjuntar_foto($id_solicitud, $nom_fichero, $lat, $lon );
                    }


                    //Borrar archivo original subido
                     unlink( "./public/img/fotos_solicitud/original/" . $nombre_imagen_full );
                    //return $nombre_imagen_full;
                    //Guardar nombre de foto, en variable de sesión, flash
                    //$this->session->set_flashdata('nombre_foto', $nombre_imagen_full);
                    return TRUE;

                }

                //$data = array('upload_data' => $this->upload->data());
                //$this->load->view('z_pruebas/formulario_subir_foto_correcto', $data);

            }

        }//fin comprobación IF se subió foto
        else
        {
            //No se subió ninguna foto, (establecer, foto Predeterminada)
            //$this->session->set_flashdata('nombre_foto', '');
            echo "No tengo foto";
            return FALSE;
        }

    }//fin función upload

    //FUNCIONES PARA EL CAPTURAR DATOS DE LOLIZACIÓN DE LA FOTO
    public function getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    public function gps2Num($coordPart) {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }







}
