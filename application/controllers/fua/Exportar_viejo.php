<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportar_viejo extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin

        $this->load->helper('form');
        $this->load->helper('fechas');
        
    }


    //para el reporte Excel, exportar aptos diario
    public function excel_reporte_solicitud ($id_registro = false) {

        if( $this->auth_level == 9 || $this->auth_level == 7  )
        {

            $this->load->library('excel');

            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();

            // Leemos un archivo Excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setIncludeCharts(TRUE);//permite graficos
            $objPHPExcel = $objReader->load("public/docs/solicitud/plantilla_solicitud.xlsx" );

            //obtener todos los DATOS de la solicitud
            $this->load->model('solicitud/Model_editar');
            $solicitud  = $this->Model_editar->obtener_solicitud($id_registro);

            //====== Obtener cadeda de texto de los campos de tipo SELECT ========
            //Para AGENCIA
            $this->load->model('reutilizables/Model_agencias');
            $lst_agencias = $this->Model_agencias->listado_agencias();
            $array_agencias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_agencias as $agencia) {
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
            }
            $string_agencia = $array_agencias[$solicitud->id_agencia_soli];

            //CREAR  ESTADO CIVIL
            //para que cree el array de id y nombre del select = estado_civil
            $lst_estado_civil = array(
                1 => 'Soltero',
                2 => 'Conviviente',
                3 => 'Viudo',
                4 => 'Casado',
                5 => 'Divorciado',
            );
            $string_estado_civil = $lst_estado_civil[$solicitud->id_estado_civil_soli];

            //CREAR  ESTADO CIVIL
            //para que cree el array de id y nombre del select = estado_civil
            $lst_estado_civil = array(
                1 => 'Soltero',
                2 => 'Conviviente',
                3 => 'Viudo',
                4 => 'Casado',
                5 => 'Divorciado',
            );
            $string_estado_civil = $lst_estado_civil[$solicitud->id_estado_civil_soli];

            // =============================================================================
            //CREAR SELECT DE TIPO DE CAL
            //para que cree el array de id y nombre del select = Calificacion
            $lst_cali = array(
                0 => '',
                1 => 'S/CAL',
                2 => 'NOR',
                3 => 'CPP',
                4 => 'DEF',
                5 => 'DUD',
                6 => 'PER',
            );

            //string del select customizado
            //$string_cali_titular = $lst_cali[$solicitud->cali_sbs_titular_soli];
            //$string_cali_conyuge = $lst_cali[$solicitud->cali_sbs_conyugue_soli];

            //para GRADO DE Educación: TITULAR, CONYUGE Y AVAL
            $lst_grado = array(
                0 => '',
                1 => 'Superior',
                2 => 'Técnico',
                3 => 'Secundaria',
                4 => 'Primaria',
                5 => 'Sin Instrucción',
            );
            $string_grado_titular   = $lst_grado[$solicitud->id_grado_instru_titular_soli];
            $string_grado_conyugue  = $lst_grado[$solicitud->id_grado_instru_conyugue_soli];
            $string_grado_aval      = $lst_grado[$solicitud->id_grado_instru_aval_soli];


            //para TENENCIA DE VIVIENDA
            $lst_tenencia_viviencia = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );
            $string_tenencia_vivienda      = $lst_tenencia_viviencia[$solicitud->id_tenencia_vivienda_soli];

            //CREAR  DE SERVICIOS BÁSICOS
            $lst_servicios_basicos = array(
                0 => '',
                1 => 'Luz, Agua, Desagüe y Teléfono',
                2 => 'Luz, Agua y  Desagüe',
                3 => 'Agua y  Desagüe',
                4 => 'Agua',
                5 => 'Ninguno',
            );
            $string_servicios_basicos      = $lst_servicios_basicos[$solicitud->id_servicios_basicos_soli];

            //CREAR TIPO DE SOCIO
            $lst_tipo_socio = array(
                0 => '',
                1 => 'Nuevo',
                2 => 'Recurrente',
            );
            $string_tipo_socio      = $lst_tipo_socio[$solicitud->id_tipo_socio_soli];

            //CREAR SELECT DEPARTAMENTOS
            $this->load->model('reutilizables/zonas/Model_departamentos');
            $lst_departamentos = $this->Model_departamentos->listado_departamentos();
            $array_departamentos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_departamentos as $departamento) {
                $array_departamentos[$departamento->idDepa] = $departamento->departamento;
            }
            $string_departamento      = $array_departamentos[$solicitud->id_departamento_titular_soli];

            //CREAR SELECT PROVINCIAS
            $this->load->model('reutilizables/zonas/Model_provincias');
            $lst_provincias = $this->Model_provincias->listado_provincias();
            $array_provincias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_provincias as $provincia) {
                $array_provincias[$provincia->idProv] = $provincia->provincia;
            }
            $string_provincia      = $array_provincias[$solicitud->id_provincia_titular_soli];

            //CREAR SELECT DISTRITOS
            $this->load->model('reutilizables/zonas/Model_distritos');
            $lst_distritos = $this->Model_distritos->listado_distritos();
            $array_distritos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_distritos as $distrito) {
                $array_distritos[$distrito->idDist] = $distrito->distrito;
            }
            $string_distrito      = $array_distritos[$solicitud->id_distrito_titular_soli];

            //CREAR SELECT tipo TERRENO PRINCIPAL Y SECUNDARIO
            $lst_tenencia_terreno = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );
            $string_terreno_principal      = $lst_tenencia_terreno[$solicitud->terreno_principal_titular_soli];
            $string_terreno_secundario      = $lst_tenencia_terreno[$solicitud->terreno_secundaria_titular_soli];


            //Vende producción a
            $checkbox_vende_produccion = array();
            if( strpos( $solicitud-> vende_produccion_soli, '1' ) !== FALSE ) {
                $checkbox_vende_produccion['asociacion']    = '[ √ ] Asociación';
            }else  {
                $checkbox_vende_produccion['asociacion']    = '[    ] Asociación';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '2' ) !== FALSE ) {
                $checkbox_vende_produccion['cooperativa']   = '[ √ ] Cooperativa';
            }else  {
                $checkbox_vende_produccion['cooperativa']   = '[    ] Cooperativa';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '3' ) !== FALSE ) {
                $checkbox_vende_produccion['comite']        = '[ √ ] Comité';
            }else  {
                $checkbox_vende_produccion['comite']        =  '[    ] Comité';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '4' ) !== FALSE ) {
                $checkbox_vende_produccion['intermediario']     =  '[ √ ] Intermediario';
            }else  {
                $checkbox_vende_produccion['intermediario']     = '[    ] Intermediario';
            }

            //meta datos
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C2", $solicitud->id_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C3", fecha_transformar_fecha($solicitud->fecha_registro_soli) );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H2", $string_agencia );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H3", $solicitud->nombre_user_articulador_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C4", fecha_transformar_fecha($solicitud->fecha_verificacion_soli) );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $solicitud->nombre_user_asesor_destino_soli );
            //TITULAR
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E6", $solicitud->nombres_titular_soli . " ".$solicitud->apellido_pat_titular_soli ." ".$solicitud->apellido_mat_titular_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C7", $string_estado_civil );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G7", $solicitud->fecha_naci_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K7", $solicitud->dni_titular_soli );

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C8", $string_tenencia_vivienda);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G8", $solicitud->numero_hijos_soli );

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C9", $string_servicios_basicos );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G9", $solicitud->celular_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K9", $string_grado_titular );

            //Zonas titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C10", $string_departamento );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G10", $string_provincia );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K10", $string_distrito );

            //DATOS FAMILIARES
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E11", $solicitud->direccion_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E12", $solicitud->direccion_terreno_soli );


            //Actividad principal - titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C13", $solicitud->actividad_principal_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G13", $string_terreno_principal );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K13", $solicitud->area_principal_titular_soli );

            //Actividad Secundaria  - titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C14", $solicitud->actividad_secundaria_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G14", $string_terreno_secundario );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K14", $solicitud->area_secundaria_titular_soli );
            //tipo de socio y número de créditos
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C15", $string_tipo_socio );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G15", $solicitud->numero_creditos_soli );
            //Vendre producción a :
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C16", $checkbox_vende_produccion['asociacion'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E16", $checkbox_vende_produccion['cooperativa'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G16", $checkbox_vende_produccion['comite'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I16", $checkbox_vende_produccion['intermediario'] );

            //$inicio_fila = 20;

            //CONYUGE
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E18", $solicitud->nombres_conyugue_soli . " ".$solicitud->apellido_pat_conyugue_soli ." ".$solicitud->apellido_mat_conyugue_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C19", $string_grado_conyugue );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G19", $solicitud->fecha_naci_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K19", $solicitud->dni_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C20", $solicitud->celular_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K20", $solicitud->fecha_naci_conyugue_soli );          ;

            //Aplicar formula de edad sólo si hay fecha de nacimiento
            if( $solicitud->fecha_naci_conyugue_soli == NULL ||  $solicitud->fecha_naci_conyugue_soli == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K20", "" );
            }

            //AVAL
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E22", $solicitud->nombres_aval_soli . " ".$solicitud->apellido_pat_aval_soli ." ".$solicitud->apellido_mat_aval_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C23", $solicitud->celular_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G23", $solicitud->fecha_naci_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K23", $solicitud->dni_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C24", $solicitud->direccion_aval_soli );


            //Aplicar formula de edad sólo si hay fecha de nacimiento
            if( $solicitud->fecha_naci_aval_soli == NULL ||  $solicitud->fecha_naci_aval_soli == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K24", "" );
            }

            //CONYUGUE DEL AVAL
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E26", $solicitud->nombres_conyu_aval_soli . " ".$solicitud->apellido_pat_conyu_aval_soli ." ".$solicitud->apellido_mat_conyu_aval_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C27", $solicitud->celular_conyu_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G27", $solicitud->fecha_naci_conyu_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K27", $solicitud->dni_conyu_aval_soli );





            // ====== OBTENER DATOS DE LAS TABLAS ===========
            $tabla_deuda_titular  = $this->Model_editar->obtener_tabla_deuda_titular($id_registro);
            $tabla_deuda_conyuge  = $this->Model_editar->obtener_tabla_deuda_conyuge($id_registro);
            $tabla_cultivo  = $this->Model_editar->obtener_tabla_cultivo($id_registro);
            $tabla_pecuaria  = $this->Model_editar->obtener_tabla_pecuaria($id_registro);
            //$tabla_derivados  = $this->Model_editar->obtener_tabla_derivados($id_registro);
            //$tabla_otras  = $this->Model_editar->obtener_tabla_otras($id_registro);


            // ******* DATOS: Para la tabla de DEUDA TITULAR  ************ //
            // ================================================

            $inicio_fila = 33;
            $inicio_fila_titular = $inicio_fila;  //Fila donde inicia la carga de datos
            $cant_registros_titular = 0 ;

            //Para agregar datos adicionales de deuda
            $fila_datos_adicional = $inicio_fila - 3 ;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C$fila_datos_adicional", $solicitud->registra_deuda_titular_soli)
                ->setCellValue("G$fila_datos_adicional", $solicitud->impagos_titular_soli)
                ->setCellValue("K$fila_datos_adicional", $solicitud->protestos_titular_soli  )
            ;


            //Si tiene deuda agregar estilo rojo
            if($solicitud->registra_deuda_titular_soli == 'SI') {

                    //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold' => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'fill' => array(
                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                        'color'     => array('rgb' => 'ff0000')
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("C$fila_datos_adicional")->applyFromArray($styleArray);
            }

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_deuda_titular))
            {
                $cant_registros_titular =  count($tabla_deuda_titular);
                //$cant_registros_titular = $cant_registros_titular - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(33 , $cant_registros_titular );

                foreach ($tabla_deuda_titular as $deuda)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila", $deuda->entidad_deuti)
                        ->setCellValue("C$inicio_fila", $deuda->fecha_consulta_deuti)
                        ->setCellValue("D$inicio_fila", $deuda->saldo_deuda_consulta_deuti  )
                        ->setCellValue("F$inicio_fila", $deuda->ultima_calificacion_deuti  )
                        ->setCellValue("G$inicio_fila", $deuda->peor_calificacion_deuti  )
                        ->setCellValue("I$inicio_fila", $deuda->saldo_deuda_evaluacion_deuti  )
                        ->setCellValue("J$inicio_fila", $deuda->cuota_pendiente_deuti  )
                        ->setCellValue("K$inicio_fila", $deuda->num_cuotas_pendiente_deuti  )
                        ;


                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");

                     //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_titular =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_titular:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_titular:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);


                //REALIZAR SUMATORIA

                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("D$inicio_fila", "=SUM(D$inicio_fila_titular:D$fin_fila_titular)"   )
                    ->setCellValue("I$inicio_fila", "=SUM(I$inicio_fila_titular:I$fin_fila_titular)"  )
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_titular:J$fin_fila_titular)"  )
                    ;

                //combinar celdas (TEXTO TOTAL)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:C$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                //combinar celdas (TOTAL: Peor calificación)
                $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                //Aplicar estilo letra (SUMATORIA tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'   => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);

            }// fin IF tabla deuda titular


            // ******* DATOS: Para la tabla de DEUDA CONYUGE  ************ //
            // ================================================

            $inicio_fila = 38 + $cant_registros_titular;
            $inicio_fila_conyuge = $inicio_fila; //Para saber desde dónde aplicar estilos
            $cant_registros_conyuge = 0 ;

            //Para agregar datos adicionales de deuda
            $fila_datos_adicional = $inicio_fila - 3 ;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C$fila_datos_adicional", $solicitud->registra_deuda_conyuge_soli)
                ->setCellValue("G$fila_datos_adicional", $solicitud->impagos_conyuge_soli)
                ->setCellValue("K$fila_datos_adicional", $solicitud->protestos_conyuge_soli  )
            ;

            //Si tiene deuda agregar estilo rojo
            if($solicitud->registra_deuda_conyuge_soli == 'SI') {

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold' => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'fill' => array(
                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                        'color'     => array('rgb' => 'ff0000')
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("C$fila_datos_adicional")->applyFromArray($styleArray);
            }

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_deuda_conyuge))
            {
                $cant_registros_conyuge =  count($tabla_deuda_conyuge);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(38 + $cant_registros_titular  , $cant_registros_conyuge );

                foreach ($tabla_deuda_conyuge as $deuda)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila", $deuda->entidad_deucon)
                        ->setCellValue("C$inicio_fila", $deuda->fecha_consulta_deucon)
                        ->setCellValue("D$inicio_fila", $deuda->saldo_deuda_consulta_deucon  )
                        ->setCellValue("F$inicio_fila", $deuda->ultima_calificacion_deucon  )
                        ->setCellValue("G$inicio_fila", $deuda->peor_calificacion_deucon  )
                        ->setCellValue("I$inicio_fila", $deuda->saldo_deuda_evaluacion_deucon  )
                        ->setCellValue("J$inicio_fila", $deuda->cuota_pendiente_deucon  )
                        ->setCellValue("K$inicio_fila", $deuda->num_cuotas_pendiente_deucon  )
                    ;


                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");

                    //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_conyuge =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de Conyuge)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_conyuge:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_conyuge:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("D$inicio_fila", "=SUM(D$inicio_fila_conyuge:D$fin_fila_conyuge)"   )
                    ->setCellValue("I$inicio_fila", "=SUM(I$inicio_fila_conyuge:I$fin_fila_conyuge)"  )
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_conyuge:J$fin_fila_conyuge)"  )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:C$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                //combinar celdas (TOTAL: Peor calificación)
                $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");
                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CONYUGE


            // ******* DATOS: Para la tabla de DIVERSIFICACIÓN DE CULTIVO  ************ //
            // ================================================

            $inicio_fila = 41+ $cant_registros_titular + $cant_registros_conyuge;
            $inicio_fila_cultivo = $inicio_fila; //Para saber desde dónde aplicar estilos

            $cant_registros_cultivo = 0 ;

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_cultivo))
            {
                $cant_registros_cultivo =  count($tabla_cultivo);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(41 + $cant_registros_titular + $cant_registros_conyuge  , $cant_registros_cultivo );

                $lst_meses = array(
                    0=> '',
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 =>  'Agosto',
                    9 => 'Setiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                );

                foreach ($tabla_cultivo as $cultivo)
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila",  $cultivo->cultivo_soli_c  )
                        ->setCellValue("C$inicio_fila",  $cultivo->unidad_soli_c )
                        ->setCellValue("D$inicio_fila",  $lst_meses[$cultivo->mes_soli_c] )
                        ->setCellValue("E$inicio_fila",  $cultivo->ha_totales_soli_c )
                        ->setCellValue("F$inicio_fila",  $cultivo->ha_produccion_soli_c )
                        ->setCellValue("G$inicio_fila",  $cultivo->produccion_soli_c )
                        ->setCellValue("I$inicio_fila",  $cultivo->precio_soli_c )
                        ->setCellValue("J$inicio_fila",  $cultivo->total_c )
                    ;

                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_cultivo =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla cultivo)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_cultivo:K$fin_fila_cultivo")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_cultivo:K$fin_fila_cultivo")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_cultivo:J$fin_fila_cultivo)"   )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:I$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CULTIVO


            // ******* DATOS: Para la tabla de DIVERSIFICACIÓN DE PECUARIA  ************ //
            // ================================================

            $inicio_fila = 44 + $cant_registros_titular + $cant_registros_conyuge + $cant_registros_cultivo ;
            $inicio_fila_pecuaria = $inicio_fila; //Para saber desde dónde aplicar estilos

            $cant_registros_pecuaria = 0 ;

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_pecuaria))
            {
                $cant_registros_pecuaria =  count($tabla_pecuaria);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(44 + $cant_registros_titular + $cant_registros_conyuge + $cant_registros_cultivo , $cant_registros_pecuaria );



                foreach ($tabla_pecuaria as $pecuaria)
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila",  $pecuaria->nombre_soli_p  )
                        ->setCellValue("C$inicio_fila",  $pecuaria->num_animales_soli_p )
                        ->setCellValue("D$inicio_fila",  $pecuaria->autoconsumo_soli_p )
                        ->setCellValue("F$inicio_fila",  $pecuaria->num_animales_venta_soli_p )
                        ->setCellValue("G$inicio_fila",  $pecuaria->fecha_soli_pe )
                        ->setCellValue("I$inicio_fila",  $pecuaria->precio_soli_p )
                        ->setCellValue("J$inicio_fila",  $pecuaria->total_soli_p )
                    ;


                    //combinar celdas (autoconsumo)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                    //combinar celdas (fecha venta)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");
                    //combinar celdas (total)
                    $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda PECUARIA

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_pecuaria =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla pecuaria)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_pecuaria:K$fin_fila_pecuaria")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_pecuaria:K$fin_fila_pecuaria")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_pecuaria:J$inicio_fila_pecuaria)"   )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:I$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CULTIVO

            //Hacer la eliminación de datos de abajo hacia arriba

            //comprobar si el TITULAR tiene conyuge
            //1=Soltero 3=viudo 5=divorciado
            if($solicitud->id_estado_civil_soli == 1 || $solicitud->id_estado_civil_soli == 3 || $solicitud->id_estado_civil_soli == 5 ) {
                //Primero eliminar datos de la tabla de deuda financiera del titular
                $fila_borrar   =  $inicio_fila_conyuge - 4 ;
                //echo $fila_borrar; exit;

                //var_dump($fila_borrar); exit;

                //$objPHPExcel->getActiveSheet(0)->removeRow(45 , 1);


                //$objPHPExcel->getActiveSheet(0)->removeRow(38 , 1);
                //$objPHPExcel->getActiveSheet(0)->removeRow(37 , 1);

                $objPHPExcel->getActiveSheet()->getRowDimension($fila_borrar  )->setVisible(false);
            }

            //comprobar si el TITULAR tiene conyuge
            //1=Soltero 3=viudo 5=divorciado
            if($solicitud->id_posee_aval_soli  == 0 ) {
                $objPHPExcel->getActiveSheet(0)->removeRow(21 , 7);
            }




            $cod_solicitud = $solicitud->id_soli; //codigo de la solicitud
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);


            //exit;
            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet ; charset=UTF-8');
            header("Content-Disposition: attachment;filename=".$cod_solicitud . "_Solicitud.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //$objWriter->setIncludeCharts(TRUE); //permite graficos
            $objWriter->save('php://output');
            exit;
            /*$file_name = 'hola';
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename='".$file_name."'");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF"; //UTF-8 BOM
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            //echo $out;*/

        }
        //fin if

    }


    //para el reporte Excel, exportar aptos diario
    public function pdf_reporte_solicitud ($id_registro = false) {

        if( $this->auth_level == 9 || $this->auth_level == 7  )
        {

            $this->load->library('excel');

            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();

            // Leemos un archivo Excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setIncludeCharts(TRUE);//permite graficos
            $objPHPExcel = $objReader->load("public/docs/solicitud/plantilla_solicitud_pdf.xlsx");

            //obtener todos los DATOS de la solicitud
            $this->load->model('solicitud/Model_editar');
            $solicitud  = $this->Model_editar->obtener_solicitud($id_registro);

            //====== Obtener cadeda de texto de los campos de tipo SELECT ========
            //Para AGENCIA
            $this->load->model('reutilizables/Model_agencias');
            $lst_agencias = $this->Model_agencias->listado_agencias();
            $array_agencias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_agencias as $agencia) {
                $array_agencias[$agencia->id_agen] = $agencia->nombre_agen;
            }
            $string_agencia = $array_agencias[$solicitud->id_agencia_soli];

            //CREAR  ESTADO CIVIL
            //para que cree el array de id y nombre del select = estado_civil
            $lst_estado_civil = array(
                1 => 'Soltero',
                2 => 'Conviviente',
                3 => 'Viudo',
                4 => 'Casado',
                5 => 'Divorciado',
            );
            $string_estado_civil = $lst_estado_civil[$solicitud->id_estado_civil_soli];

            //CREAR  ESTADO CIVIL
            //para que cree el array de id y nombre del select = estado_civil
            $lst_estado_civil = array(
                1 => 'Soltero',
                2 => 'Conviviente',
                3 => 'Viudo',
                4 => 'Casado',
                5 => 'Divorciado',
            );
            $string_estado_civil = $lst_estado_civil[$solicitud->id_estado_civil_soli];

            // =============================================================================
            //CREAR SELECT DE TIPO DE CAL
            //para que cree el array de id y nombre del select = Calificacion
            $lst_cali = array(
                0 => '',
                1 => 'S/CAL',
                2 => 'NOR',
                3 => 'CPP',
                4 => 'DEF',
                5 => 'DUD',
                6 => 'PER',
            );

            //string del select customizado
            //$string_cali_titular = $lst_cali[$solicitud->cali_sbs_titular_soli];
            //$string_cali_conyuge = $lst_cali[$solicitud->cali_sbs_conyugue_soli];

            //para GRADO DE Educación: TITULAR, CONYUGE Y AVAL
            $lst_grado = array(
                0 => '',
                1 => 'Superior',
                2 => 'Técnico',
                3 => 'Secundaria',
                4 => 'Primaria',
                5 => 'Sin Instrucción',
            );
            $string_grado_titular   = $lst_grado[$solicitud->id_grado_instru_titular_soli];
            $string_grado_conyugue  = $lst_grado[$solicitud->id_grado_instru_conyugue_soli];
            $string_grado_aval      = $lst_grado[$solicitud->id_grado_instru_aval_soli];


            //para TENENCIA DE VIVIENDA
            $lst_tenencia_viviencia = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );
            $string_tenencia_vivienda      = $lst_tenencia_viviencia[$solicitud->id_tenencia_vivienda_soli];

            //CREAR  DE SERVICIOS BÁSICOS
            $lst_servicios_basicos = array(
                0 => '',
                1 => 'Luz, Agua, Desagüe y Teléfono',
                2 => 'Luz, Agua y  Desagüe',
                3 => 'Agua y  Desagüe',
                4 => 'Agua',
                5 => 'Ninguno',
            );
            $string_servicios_basicos      = $lst_servicios_basicos[$solicitud->id_servicios_basicos_soli];

            //CREAR TIPO DE SOCIO
            $lst_tipo_socio = array(
                0 => '',
                1 => 'Nuevo',
                2 => 'Recurrente',
            );
            $string_tipo_socio      = $lst_tipo_socio[$solicitud->id_tipo_socio_soli];

            //CREAR SELECT DEPARTAMENTOS
            $this->load->model('reutilizables/zonas/Model_departamentos');
            $lst_departamentos = $this->Model_departamentos->listado_departamentos();
            $array_departamentos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_departamentos as $departamento) {
                $array_departamentos[$departamento->idDepa] = $departamento->departamento;
            }
            $string_departamento      = $array_departamentos[$solicitud->id_departamento_titular_soli];

            //CREAR SELECT PROVINCIAS
            $this->load->model('reutilizables/zonas/Model_provincias');
            $lst_provincias = $this->Model_provincias->listado_provincias();
            $array_provincias = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_provincias as $provincia) {
                $array_provincias[$provincia->idProv] = $provincia->provincia;
            }
            $string_provincia      = $array_provincias[$solicitud->id_provincia_titular_soli];

            //CREAR SELECT DISTRITOS
            $this->load->model('reutilizables/zonas/Model_distritos');
            $lst_distritos = $this->Model_distritos->listado_distritos();
            $array_distritos = array(); //array que tendrá todos los colegios
            //para que cree el array de id y nombre del select
            foreach ($lst_distritos as $distrito) {
                $array_distritos[$distrito->idDist] = $distrito->distrito;
            }
            $string_distrito      = $array_distritos[$solicitud->id_distrito_titular_soli];

            //CREAR SELECT tipo TERRENO PRINCIPAL Y SECUNDARIO
            $lst_tenencia_terreno = array(
                0 => '',
                1 => 'Propio',
                2 => 'Alquilado',
                3 => 'Familiar',
                4 => 'Ambulante',
                5 => 'Cedido',
            );
            $string_terreno_principal      = $lst_tenencia_terreno[$solicitud->terreno_principal_titular_soli];
            $string_terreno_secundario      = $lst_tenencia_terreno[$solicitud->terreno_secundaria_titular_soli];


            //Vende producción a
            $checkbox_vende_produccion = array();
            if( strpos( $solicitud-> vende_produccion_soli, '1' ) !== FALSE ) {
                $checkbox_vende_produccion['asociacion']    = '[ √ ] Asociación';
            }else  {
                $checkbox_vende_produccion['asociacion']    = '[    ] Asociación';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '2' ) !== FALSE ) {
                $checkbox_vende_produccion['cooperativa']   = '[ √ ] Cooperativa';
            }else  {
                $checkbox_vende_produccion['cooperativa']   = '[    ] Cooperativa';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '3' ) !== FALSE ) {
                $checkbox_vende_produccion['comite']        = '[ √ ] Comité';
            }else  {
                $checkbox_vende_produccion['comite']        =  '[    ] Comité';
            }

            if( strpos( $solicitud-> vende_produccion_soli, '4' ) !== FALSE ) {
                $checkbox_vende_produccion['intermediario']     =  '[ √ ] Intermediario';
            }else  {
                $checkbox_vende_produccion['intermediario']     = '[    ] Intermediario';
            }

            //TITULAR
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C2", $solicitud->id_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C3", fecha_transformar_fecha_sin_hora_completo($solicitud->fecha_registro_soli) );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H3", $solicitud->asesor_credito_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H2", $string_agencia );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E5", $solicitud->nombres_titular_soli . " ".$solicitud->apellido_pat_titular_soli ." ".$solicitud->apellido_mat_titular_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K6", $solicitud->dni_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G8", $solicitud->celular_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G6", $solicitud->fecha_naci_titular_soli );
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K7",EDAD AUTOCALCULADA );
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G10", $string_cali_titular );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K8", $string_grado_titular );
            //Zonas titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C9", $string_departamento );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G9", $string_provincia );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K9", $string_distrito );
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C12", $solicitud->nombre_caserio_titular_soli );
            //Actividad principal - titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C12", $solicitud->actividad_principal_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G12", $string_terreno_principal );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K12", $solicitud->area_principal_titular_soli );

            //Actividad Secundaria  - titular
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C13", $solicitud->actividad_secundaria_titular_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G13", $string_terreno_secundario );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K13", $solicitud->area_secundaria_titular_soli );
            //tipo de socio y número de créditos
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C14", $string_tipo_socio );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G14", $solicitud->numero_creditos_soli );
            //Vendre producción a :
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C15", $checkbox_vende_produccion['asociacion'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E15", $checkbox_vende_produccion['cooperativa'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G15", $checkbox_vende_produccion['comite'] );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I15", $checkbox_vende_produccion['intermediario'] );

            //$inicio_fila = 20;

            //CONYUGE
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E17", $solicitud->nombres_conyugue_soli . " ".$solicitud->apellido_pat_conyugue_soli ." ".$solicitud->apellido_mat_conyugue_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C18", $string_grado_conyugue );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G18", $solicitud->fecha_naci_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K18", $solicitud->dni_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C19", $solicitud->celular_conyugue_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K19", $solicitud->fecha_naci_conyugue_soli );          ;

            //Aplicar formula de edad sólo si hay fecha de nacimiento
            if( $solicitud->fecha_naci_conyugue_soli == NULL ||  $solicitud->fecha_naci_conyugue_soli == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K19", "" );
            }

            //AVAL
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E21", $solicitud->nombres_aval_soli . " ".$solicitud->apellido_pat_aval_soli ." ".$solicitud->apellido_mat_aval_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C22", $solicitud->celular_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G22", $solicitud->fecha_naci_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K22", $solicitud->dni_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C23", $solicitud->direccion_aval_soli );


            //Aplicar formula de edad sólo si hay fecha de nacimiento
            if( $solicitud->fecha_naci_aval_soli == NULL ||  $solicitud->fecha_naci_aval_soli == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K23", "" );
            }

            //CONYUGUE DEL AVAL
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E25", $solicitud->nombres_conyu_aval_soli . " ".$solicitud->apellido_pat_conyu_aval_soli ." ".$solicitud->apellido_mat_conyu_aval_soli);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C26", $solicitud->celular_conyu_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G26", $solicitud->fecha_naci_conyu_aval_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K26", $solicitud->dni_conyu_aval_soli );

            //DATOS FAMILIARES
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E10", $solicitud->direccion_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E11", $solicitud->direccion_terreno_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C6", $string_estado_civil );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G7", $solicitud->numero_hijos_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C7", $string_tenencia_vivienda );
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("G26", $solicitud->tipo_terreno_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C8", $string_servicios_basicos );


            // ====== OBTENER DATOS DE LAS TABLAS ===========
            $tabla_deuda_titular  = $this->Model_editar->obtener_tabla_deuda_titular($id_registro);
            $tabla_deuda_conyuge  = $this->Model_editar->obtener_tabla_deuda_conyuge($id_registro);
            $tabla_cultivo  = $this->Model_editar->obtener_tabla_cultivo($id_registro);
            $tabla_pecuaria  = $this->Model_editar->obtener_tabla_pecuaria($id_registro);
            //$tabla_derivados  = $this->Model_editar->obtener_tabla_derivados($id_registro);
            //$tabla_otras  = $this->Model_editar->obtener_tabla_otras($id_registro);


            // ******* DATOS: Para la tabla de DEUDA TITULAR  ************ //
            // ================================================

            $inicio_fila = 32;
            $inicio_fila_titular = $inicio_fila;  //Fila donde inicia la carga de datos
            $cant_registros_titular = 0 ;

            //Para agregar datos adicionales de deuda
            $fila_datos_adicional = $inicio_fila - 3 ;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C$fila_datos_adicional", $solicitud->registra_deuda_titular_soli)
                ->setCellValue("G$fila_datos_adicional", $solicitud->impagos_titular_soli)
                ->setCellValue("K$fila_datos_adicional", $solicitud->protestos_titular_soli  )
            ;


            //Si tiene deuda agregar estilo rojo
            if($solicitud->registra_deuda_titular_soli == 'SI') {

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold' => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'fill' => array(
                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                        'color'     => array('rgb' => 'ff0000')
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("C$fila_datos_adicional")->applyFromArray($styleArray);
            }

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_deuda_titular))
            {
                $cant_registros_titular =  count($tabla_deuda_titular);
                //$cant_registros_titular = $cant_registros_titular - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(33 , $cant_registros_titular );

                foreach ($tabla_deuda_titular as $deuda)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila", $deuda->entidad_deuti)
                        ->setCellValue("C$inicio_fila", $deuda->fecha_consulta_deuti)
                        ->setCellValue("D$inicio_fila", $deuda->saldo_deuda_consulta_deuti  )
                        ->setCellValue("F$inicio_fila", $deuda->ultima_calificacion_deuti  )
                        ->setCellValue("G$inicio_fila", $deuda->peor_calificacion_deuti  )
                        ->setCellValue("I$inicio_fila", $deuda->saldo_deuda_evaluacion_deuti  )
                        ->setCellValue("J$inicio_fila", $deuda->cuota_pendiente_deuti  )
                        ->setCellValue("K$inicio_fila", $deuda->num_cuotas_pendiente_deuti  )
                    ;


                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");

                    //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_titular =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),*/
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_titular:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_titular:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);


                //REALIZAR SUMATORIA

                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("D$inicio_fila", "=SUM(D$inicio_fila_titular:D$fin_fila_titular)"   )
                    ->setCellValue("I$inicio_fila", "=SUM(I$inicio_fila_titular:I$fin_fila_titular)"  )
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_titular:J$fin_fila_titular)"  )
                ;

                //combinar celdas (TEXTO TOTAL)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:C$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                //combinar celdas (TOTAL: Peor calificación)
                $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                //Aplicar estilo letra (SUMATORIA tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'   => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),*/
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);






            }// fin IF tabla deuda titular


            // ******* DATOS: Para la tabla de DEUDA CONYUGE  ************ //
            // ================================================

            $inicio_fila = 37 + $cant_registros_titular;
            $inicio_fila_conyuge = $inicio_fila; //Para saber desde dónde aplicar estilos
            $cant_registros_conyuge = 0 ;

            //Para agregar datos adicionales de deuda
            $fila_datos_adicional = $inicio_fila - 3 ;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C$fila_datos_adicional", $solicitud->registra_deuda_conyuge_soli)
                ->setCellValue("G$fila_datos_adicional", $solicitud->impagos_conyuge_soli)
                ->setCellValue("K$fila_datos_adicional", $solicitud->protestos_conyuge_soli  )
            ;

            //Si tiene deuda agregar estilo rojo
            if($solicitud->registra_deuda_conyuge_soli == 'SI') {

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de titular)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold' => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    'fill' => array(
                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                        'color'     => array('rgb' => 'ff0000')
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle("C$fila_datos_adicional")->applyFromArray($styleArray);
            }

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_deuda_conyuge))
            {
                $cant_registros_conyuge =  count($tabla_deuda_conyuge);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(38 + $cant_registros_titular  , $cant_registros_conyuge );

                foreach ($tabla_deuda_conyuge as $deuda)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila", $deuda->entidad_deucon)
                        ->setCellValue("C$inicio_fila", $deuda->fecha_consulta_deucon)
                        ->setCellValue("D$inicio_fila", $deuda->saldo_deuda_consulta_deucon  )
                        ->setCellValue("F$inicio_fila", $deuda->ultima_calificacion_deucon  )
                        ->setCellValue("G$inicio_fila", $deuda->peor_calificacion_deucon  )
                        ->setCellValue("I$inicio_fila", $deuda->saldo_deuda_evaluacion_deucon  )
                        ->setCellValue("J$inicio_fila", $deuda->cuota_pendiente_deucon  )
                        ->setCellValue("K$inicio_fila", $deuda->num_cuotas_pendiente_deucon  )
                    ;


                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");

                    //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_conyuge =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla deuda de Conyuge)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ), */
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_conyuge:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_conyuge:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("D$inicio_fila", "=SUM(D$inicio_fila_conyuge:D$fin_fila_conyuge)"   )
                    ->setCellValue("I$inicio_fila", "=SUM(I$inicio_fila_conyuge:I$fin_fila_conyuge)"  )
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_conyuge:J$fin_fila_conyuge)"  )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:C$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                //combinar celdas (TOTAL: Peor calificación)
                $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");
                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ), */
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CONYUGE


            // ******* DATOS: Para la tabla de DIVERSIFICACIÓN DE CULTIVO  ************ //
            // ================================================

            $inicio_fila = 40 + $cant_registros_titular + $cant_registros_conyuge;
            $inicio_fila_cultivo = $inicio_fila; //Para saber desde dónde aplicar estilos

            $cant_registros_cultivo = 0 ;

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_cultivo))
            {
                $cant_registros_cultivo =  count($tabla_cultivo);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(41 + $cant_registros_titular + $cant_registros_conyuge  , $cant_registros_cultivo );

                $lst_meses = array(
                    0=> '',
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 =>  'Agosto',
                    9 => 'Setiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                );

                foreach ($tabla_cultivo as $cultivo)
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila",  $cultivo->cultivo_soli_c  )
                        ->setCellValue("C$inicio_fila",  $cultivo->unidad_soli_c )
                        ->setCellValue("D$inicio_fila",  $lst_meses[$cultivo->mes_soli_c] )
                        ->setCellValue("E$inicio_fila",  $cultivo->ha_totales_soli_c )
                        ->setCellValue("F$inicio_fila",  $cultivo->ha_produccion_soli_c )
                        ->setCellValue("G$inicio_fila",  $cultivo->produccion_soli_c )
                        ->setCellValue("I$inicio_fila",  $cultivo->precio_soli_c )
                        ->setCellValue("J$inicio_fila",  $cultivo->total_c )
                    ;

                    //combinar celdas (Saldo de deuda a la fecha)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");

                    //combinar celdas (Peor calificación)
                    $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda titular

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_cultivo =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla cultivo)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),*/
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_cultivo:K$fin_fila_cultivo")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_cultivo:K$fin_fila_cultivo")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_cultivo:J$fin_fila_cultivo)"   )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:I$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ), */
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CULTIVO


            // ******* DATOS: Para la tabla de DIVERSIFICACIÓN DE PECUARIA  ************ //
            // ================================================

            $inicio_fila = 43 + $cant_registros_titular + $cant_registros_conyuge + $cant_registros_cultivo ;
            $inicio_fila_pecuaria = $inicio_fila; //Para saber desde dónde aplicar estilos

            $cant_registros_pecuaria = 0 ;

            //Verificar si la tabla de deuda tienes datos
            if(!empty($tabla_pecuaria))
            {
                $cant_registros_pecuaria =  count($tabla_pecuaria);
                //$cant_registros_conyuge = $cant_registros_conyuge - 1 ;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore(44 + $cant_registros_titular + $cant_registros_conyuge + $cant_registros_cultivo , $cant_registros_pecuaria );



                foreach ($tabla_pecuaria as $pecuaria)
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$inicio_fila",  $pecuaria->nombre_soli_p  )
                        ->setCellValue("C$inicio_fila",  $pecuaria->num_animales_soli_p )
                        ->setCellValue("D$inicio_fila",  $pecuaria->autoconsumo_soli_p )
                        ->setCellValue("F$inicio_fila",  $pecuaria->num_animales_venta_soli_p )
                        ->setCellValue("G$inicio_fila",  $pecuaria->fecha_soli_pe )
                        ->setCellValue("I$inicio_fila",  $pecuaria->precio_soli_p )
                        ->setCellValue("J$inicio_fila",  $pecuaria->total_soli_p )
                    ;


                    //combinar celdas (autoconsumo)
                    $objPHPExcel->getActiveSheet()->mergeCells("D$inicio_fila:E$inicio_fila");
                    //combinar celdas (fecha venta)
                    $objPHPExcel->getActiveSheet()->mergeCells("G$inicio_fila:H$inicio_fila");
                    //combinar celdas (total)
                    $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                    $inicio_fila++;

                }//Fin foreach tabla deuda PECUARIA

                //(Para saber en qué fila termina la carga de datos)
                $fin_fila_pecuaria =  $inicio_fila - 1 ;

                //Aplicar estilo letra (al grupo de datos de la tabla pecuaria)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'color' => array('rgb' => '000000'),
                        'size'  => 12,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ), */
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_pecuaria:K$fin_fila_pecuaria")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila_pecuaria:K$fin_fila_pecuaria")
                    ->getAlignment()->setWrapText(true);

                //REALIZAR SUMATORIA
                //Aplicar sumatoria a los datos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B$inicio_fila", "TOTAL : ")
                    ->setCellValue("J$inicio_fila", "=SUM(J$inicio_fila_pecuaria:J$inicio_fila_pecuaria)"   )
                ;

                //combinar celdas (TOTAL: texto)
                $objPHPExcel->getActiveSheet()->mergeCells("B$inicio_fila:I$inicio_fila");
                //combinar celdas (TOTAL: Saldo de deuda a la fecha)
                $objPHPExcel->getActiveSheet()->mergeCells("J$inicio_fila:K$inicio_fila");

                //Aplicar estilo letra (a la sumatoria  tabla deuda de Conyugué)
                $styleArray = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 15,
                        'name'  => 'Calibri',
                    ),
                    /*'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),*/
                );
                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle("B$inicio_fila:K$inicio_fila")
                    ->getAlignment()->setWrapText(true);



            }// fin IF tabla deuda CULTIVO



            //EXPORTAR A PDF
            $objPHPExcel->getActiveSheet(0)->setShowGridlines(false);

            //importar librería de pdf
            $rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
            $rendererLibraryPath = 'application/third_party/tcpdf/';
            //verifica si se cargó la librería de pdf
            if (!PHPExcel_Settings::setPdfRenderer(
                $rendererName,
                $rendererLibraryPath
            )) {
                die(
                    'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                    '<br />' .
                    'at the top of this script as appropriate for your directory structure'
                );
            }



            $cod_solicitud = $solicitud->id_soli; //codigo de la solicitud
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);


            //exit;
            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename='.$cod_solicitud .'_Solicitud.pdf');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            //$objWriter->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objWriter->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A2_PAPER);
            $objWriter->save('php://output');
            //exit;
        }
        //fin if

    }

  

    
}
