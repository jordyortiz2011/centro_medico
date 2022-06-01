<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_registrar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Guarda un registro en en la BD
     * @param  $datos(array): datos POST del formulario, 
	 * @param  $usuario: nombre del usuario que está guardando el registro
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_solicitud ($datos )
    {

        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');

        //usuario que está realizando el registro
        $this->load->model('reutilizables/Model_usuarios');
        $usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);

        //Si el ASESOR ESTÁ REGISTRANDO, asignar el ID del sistema a la variable del "select del asesor"
        if ( $this->auth_level == 7  )
        {
            $datos['select_asesores'] = $this->auth_user_id;
        }

        $this->load->model('reutilizables/Model_usuarios');
        $nombre_asesor = $this->Model_usuarios->obtener_usuario_registrador($datos['select_asesores']);

        //Verificar si un articulador está registrado
        if($this->auth_level == 3) {
            $id_articulador     = $this->auth_user_id;
            $nombre_articulador = $this->Model_usuarios->obtener_usuario_registrador($id_articulador);

            $nombre_articulador = $nombre_articulador;
        } else {
            $id_articulador     = NULL;
            $nombre_articulador = '';
        }

        $datos = array(
                'id_estado_soli'            => 1 , //1=en proceso, 2=Aprobada, 3=Rechazada
                'id_agencia_soli'           => $datos['select_agencias'],

                //'fecha_solicitud'          => $datos['text_fecha_solicitud'],
                // 'asesor_credito_soli'      => $datos['text_asesor_credito'],
                //'sector'    => $datos['text_sector'],
                
         		'nombres_titular_soli'          => $datos['text_nombres_titular'],
                'apellido_pat_titular_soli'    => $datos['text_apellido_pat_titular'],
                'apellido_mat_titular_soli'    => $datos['text_apellido_mat_titular'],
                'dni_titular_soli'              => $datos['text_dni_titular'],
                'celular_titular_soli'      	=> $datos['text_celular_titular'],
                'fecha_naci_titular_soli'       => $datos['text_fecha_naci_titular'],
                //'cali_sbs_titular_soli'      	=> $datos['select_sbs_titular'],
                'id_grado_instru_titular_soli'  => $datos['select_grado_instru_titular'],
                'id_departamento_titular_soli'  => $datos['select_departamentos'],
                'id_provincia_titular_soli'     => $datos['select_provincias'],
                'id_distrito_titular_soli'      => $datos['select_distritos'],
                //'nombre_caserio_titular_soli'   => $datos['text_caserio_titular'],

                //Actividades titular
                'actividad_principal_titular_soli'     => $datos['text_actividad_principal_titular'],
                'terreno_principal_titular_soli'        => $datos['select_terreno_principal_titular'],
                'area_principal_titular_soli'           => $datos['text_area_principal_titular'],
                'actividad_secundaria_titular_soli'     => $datos['text_actividad_secundaria_titular'],
                'terreno_secundaria_titular_soli'      => $datos['select_terreno_secundaria_titular'],
                'area_secundaria_titular_soli'          => $datos['text_area_secundaria_titular'],

                'vende_produccion_soli'             => $datos['string_vende_produccion'],


                //conyugue
                'nombres_conyugue_soli'          => $datos['text_nombres_conyugue'],
                'apellido_pat_conyugue_soli'    => $datos['text_apellido_pat_conyugue'],
                'apellido_mat_conyugue_soli'    => $datos['text_apellido_mat_conyugue'],
                'dni_conyugue_soli'              => $datos['text_dni_conyugue'],
                'celular_conyugue_soli'      	 => $datos['text_celular_conyugue'],
                'fecha_naci_conyugue_soli'       => $datos['text_fecha_naci_conyugue'],
                //'cali_sbs_conyugue_soli'         => $datos['select_sbs_conyugue'],
                'id_grado_instru_conyugue_soli'  => $datos['select_grado_instru_conyugue'],

                //aval
                'id_posee_aval_soli'        => $datos['checkbox_posee_aval'],
                'nombres_aval_soli'         => $datos['text_nombres_aval'],
                'apellido_pat_aval_soli'    => $datos['text_apellido_pat_aval'],
                'apellido_mat_aval_soli'    => $datos['text_apellido_mat_aval'],
                'dni_aval_soli'              => $datos['text_dni_aval'],
                'celular_aval_soli'      	 => $datos['text_celular_aval'],
                'fecha_naci_aval_soli'       => $datos['text_fecha_naci_aval'],
                //'id_grado_instru_aval_soli'      	 => $datos['select_grado_instru_aval'],
                'direccion_aval_soli'                    => $datos['text_direccion_aval'],

                //conyugue del aval
                'nombres_conyu_aval_soli'          => $datos['text_nombres_conyu_aval'],
                'apellido_pat_conyu_aval_soli'    => $datos['text_apellido_pat_conyu_aval'],
                'apellido_mat_conyu_aval_soli'    => $datos['text_apellido_mat_conyu_aval'],
                'dni_conyu_aval_soli'              => $datos['text_dni_conyu_aval'],
                'celular_conyu_aval_soli'      	 => $datos['text_celular_conyu_aval'],
                'fecha_naci_conyu_aval_soli'       => $datos['text_fecha_naci_conyu_aval'],


				//datos familiares
                'direccion_soli'                    => $datos['text_direccion'],
                'direccion_terreno_soli'            => $datos['text_direccion_terreno'],
                'id_estado_civil_soli'              => $datos['select_estado_civil'],
                'numero_hijos_soli'                 => $datos['text_num_hijos'],
                'id_tenencia_vivienda_soli'         => $datos['select_tenencia_terreno'],
                //'tipo_terreno_soli'      	        => $datos['text_tipo_terreno'],
                'id_servicios_basicos_soli'         => $datos['select_tenencia_terreno'],
                'id_tipo_socio_soli'      	        => $datos['select_tipo_socio'],
                'numero_creditos_soli'      	    => $datos['text_numero_creditos'],


				//Para la tabla de deuda de sistema financiero
                'registra_deuda_titular_soli'       => $datos['hidden_registra_deuda_titular'],
                'impagos_titular_soli'      	    => $datos['text_impagos_titular'],
                'protestos_titular_soli'      	    => $datos['text_protestos_titular'],
                'registra_deuda_conyuge_soli'       => $datos['hidden_registra_deuda_conyuge'],
                'impagos_conyuge_soli'      	    => $datos['text_impagos_conyuge'],
                'protestos_conyuge_soli'      	    => $datos['text_protestos_conyuge'],

				//meta datos
                'fecha_registro_soli' 	=> $fecha_registro,
				'user_registro_soli'	=> $usuario_registrador,
                'id_user_registro_soli'	=> $this->auth_user_id,

                //id y nombre de asesor de destino
                'id_user_asesor_destino_soli'	    => $datos['select_asesores'],
                'nombre_user_asesor_destino_soli'	=> $nombre_asesor,

                //Id y nombre del articulador
                'id_user_articulador_soli'	    => $id_articulador,
                'nombre_user_articulador_soli'	=> $nombre_articulador,
                
        );


        $res = $this->db->insert('tbl_solicitudes' , $datos);
        if (!$res)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
            if( $this->db->affected_rows() == 1 )
                $id_ciclo = $this->db->insert_id(); //retorna el ultimo id insertado
            return $id_ciclo;
        }

        return false;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla deuda financiera
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    /*public function guardar_tabla_deuda($id_solicitud, $post )
    {
        foreach ($post['text_tabla_deuda'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['entidad'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            $datos = array(
                'id_solicitud_soli_d'   => $id_solicitud ,

                'entidad_soli_d'        => $valor['entidad'],
                'monto_soli_d'          => $valor['monto'],
                'saldo_soli_d'          => $valor['saldo_deuda'],
                'pago_soli_d'           => $valor['pago_mes'],
                'plazos_soli_d '        => $valor['plazos'],
                'cuotas_soli_d'      	=> $valor['cuotas'],
            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_deuda' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    } */

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla deuda financiera
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_deuda_titular($id_solicitud, $post )
    {
        foreach ($post['text_tabla_deuda_titular'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['entidad'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            //Cambiar formato de la fecha de consulta
            $date           = str_replace('/', '-', $valor['fecha_consulta'] );
            $fecha_consulta = date("Y-m-d", strtotime($date));

            $datos = array(
                'id_solicitud_deuti'            => $id_solicitud ,

                'entidad_deuti'                 => $valor['entidad'],
                'fecha_consulta_deuti'          => $fecha_consulta,
                'saldo_deuda_consulta_deuti'    => $valor['saldo_deuda_consulta'],
                'ultima_calificacion_deuti'     => $valor['ultima_calificacion'],
                'peor_calificacion_deuti'       => $valor['peor_calificacion'],
                'saldo_deuda_evaluacion_deuti'  => $valor['saldo_deuda_evaluacion'],
                'cuota_pendiente_deuti'         => $valor['cuota_pendiente'],
                'num_cuotas_pendiente_deuti'    => $valor['num_cuotas_pendiente'],
            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_deuda_titular' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla deuda financiera
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_deuda_conyuge($id_solicitud, $post )
    {
        foreach ($post['text_tabla_deuda_conyuge'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['entidad'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            //Cambiar formato de la fecha de consulta
            $date           = str_replace('/', '-', $valor['fecha_consulta'] );
            $fecha_consulta = date("Y-m-d", strtotime($date));

            $datos = array(
                'id_solicitud_deucon'            => $id_solicitud ,

                'entidad_deucon'                 => $valor['entidad'],
                'fecha_consulta_deucon'          => $fecha_consulta,
                'saldo_deuda_consulta_deucon'    => $valor['saldo_deuda_consulta'],
                'ultima_calificacion_deucon'     => $valor['ultima_calificacion'],
                'peor_calificacion_deucon'       => $valor['peor_calificacion'],
                'saldo_deuda_evaluacion_deucon'  => $valor['saldo_deuda_evaluacion'],
                'cuota_pendiente_deucon'         => $valor['cuota_pendiente'],
                'num_cuotas_pendiente_deucon'    => $valor['num_cuotas_pendiente'],
            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_deuda_conyuge' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla: Diversificación de cultivo
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_cultivo($id_solicitud, $post )
    {
        foreach ($post['text_tabla_cultivo'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['cultivo'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            $datos = array(
                'id_solicitud_soli_c'   => $id_solicitud ,

                'cultivo_soli_c'        => $valor['cultivo'],
                'ha_totales_soli_c'     => $valor['ha_totales'],
                'ha_produccion_soli_c'  => $valor['ha_produccion'],
                'unidad_soli_c '        => $valor['unidad'],
                'produccion_soli_c'     => $valor['produccion'],

                'mes_soli_c'            => $valor['mes'],
                'precio_soli_c'         => $valor['precio'],
                'total_c'               => $valor['total'],
            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_cultivo' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla: Diversificación pecuaria
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_pecuaria($id_solicitud, $post )
    {
        foreach ($post['text_tabla_pecuaria'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['nombre'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            $datos = array(
                'id_solicitud_soli_p'       => $id_solicitud ,

                'nombre_soli_p'             => $valor['nombre'],
                'num_animales_soli_p'       => $valor['num_animales'],
                'autoconsumo_soli_p'        => $valor['autoconsumo'],
                'num_animales_venta_soli_p '=> $valor['num_animales_venta'],
                'fecha_soli_pe'             => $valor['fecha_venta'],
                'precio_soli_p'             => $valor['precio'],
                'total_soli_p'              => $valor['total'],

            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_pecuaria' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla: DERIVADOS
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_derivados($id_solicitud, $post )
    {
        foreach ($post['text_tabla_derivados'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['derivados'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            $datos = array(
                'id_solicitud_soli_der'     => $id_solicitud ,

                'derivados_soli_der'        => $valor['derivados'],
                'unidad_soli_der'           => $valor['unidad'],
                'produccion_soli_der'       => $valor['produccion'],
                'precio_soli_der '          => $valor['precio'],
                'fecha_soli_der'            => $valor['fecha'],

            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_derivados' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Guarda los datos de la tabla: OTRAS ACTIVIDIDADES
     * @param  $id_solicitud(int): id de la solicitud guardada,
     * @param  $datos(array): datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function guardar_tabla_otras($id_solicitud, $post )
    {
        foreach ($post['text_tabla_otras'] as $indice => $valor) {

            //comprobar si el campo "entidad financiera" está vacio, para no realizar el guardado de la fila
            if($valor['actividades'] == ''){
                //echo "no guardar el indice " . $datos['text_deuda_entidad'][$indice] ."<br>";
                continue; //continuar con la siguiente iteración
            }

            $datos = array(
                'id_solicitud_soli_o'    => $id_solicitud ,

                'actividades_soli_o'     => $valor['actividades'],
                'ingreso_soli_o'         => $valor['ingreso'],
                'antiguedad_soli_o'      => $valor['antiguedad'],
                'empresa_soli_o '        => $valor['empresa'],


            );
            //print_r($datos);

            $res = $this->db->insert('tbl_solicitudes_otras' , $datos);
            if (!$res)
            {
                $error = $this->db->error(); // Has keys 'code' and 'message'
                echo "$error[message]";
                return false;
            }else
            {
                //Insertado correcto, continuar con la siguiente fila de la
                //tabla deuda
            }
        }
        return true;
    }

    // --------------------------------------------------------------
    /**
     * Obtiene datos de los usuarios por tipo y de acuerdo a su departamento
     * @param  -_-
     * @return (Objeto) Lista con todos los resultados
     *  */
    public function obtener_usuarios_xTipo_xAgencia($id_tipo , $id_agencia)
    {

        $query = $this
            ->db
            ->from('users')
            ->where('auth_level' ,$id_tipo )
            ->where('id_agencia_user' ,$id_agencia );

        //ejectua la consulta
        $query = $this->db->get();

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
            return $query->result();
        }
    }


    public function adjuntar_foto($id_solicitud, $nombre, $latitud, $longitud)
    {

        $data = array(
            'foto_nombre_soli'    =>$nombre,
            'foto_latitud_soli'   => $latitud ,
            'foto_longitud_soli'   => $longitud

        );


        $query = $this->db->where('id_soli' , $id_solicitud)
            ->update('tbl_solicitudes',$data ) ;

        //echo $this->db->get_compiled_select(); exit;

        if (!$this->db->affected_rows()) {
            echo  'Error! no se actualizó registro';
            return false;
        } else {
            $result = true;
        }

        return $result;
    }

}