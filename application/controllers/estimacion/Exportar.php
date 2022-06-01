<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportar extends MY_Controller {
    
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
    public function excel_reporte_estimacion ($id_registro = false) {

        if( $this->verify_role('admin,asesor')  )
        {

            $this->load->library('excel');

            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();

            // Leemos un archivo Excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setIncludeCharts(TRUE);//permite graficos
            $objPHPExcel = $objReader->load("public/docs/estimacion/plantilla_estimacion.xlsx");

            //obtener todos los DATOS de la solicitud
            $this->load->model('estimacion/Model_editar');
            $estimacion  = $this->Model_editar->obtener_estimacion($id_registro);

            //Obtener datos de la matriz relacionado
            $this->load->model('reutilizables/Model_matrices');
            $matriz = $this->Model_matrices->obtener_matriz_xID($estimacion->id_matriz_esti);

            //Variedad
             $lst_variedad = array(
                                 1 => 'CCN 51',
                                 2 => 'ICS 95',
                               
                               );
            $string_variedad = $lst_variedad[ $estimacion->variedad ];

              //DENSIDAD DE SIEMBRA (METROS)
             $lst_densidad = array(
                                1 => '3 X 3 ',
                                2 => '3 X 2.5',
                                3 => '2.5 X 2.5',
                               
                               );
            $string_densidad = $lst_densidad[ $estimacion->b_densidad_siembra ];

            //print_r($matriz);exit;
            //print_r($estimacion);exit;

            //Meta datos
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C3", $matriz->id_soli );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C4",$matriz->nombres_titular_soli . ', ' . $matriz->apellido_pat_titular_soli . " "  . $matriz->apellido_mat_titular_soli  );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C5", fecha_transformar_fecha_sin_hora_completo($matriz->fecha_registro_soli)  );

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E3", fecha_transformar_fecha_sin_hora_completo($matriz->fecha_registro_matriz)  );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E4", fecha_transformar_fecha_sin_hora_completo($estimacion->fecha_registro_esti)  );

            //Datos de la secuencia
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E7",$string_variedad );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E8", $estimacion->a_area_cultivada );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E9", $string_densidad );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E10", $estimacion->c_num_plantas );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E11", $estimacion->d_num_mazorcas );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E12", $estimacion->e_num_semillas );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E13", $estimacion->f_peso_semilla );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E14", $estimacion->g_kg_plantas );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E15", $estimacion->h_conversion_baba );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E16", $estimacion->i_kg_xplanta );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E17", $estimacion->j_kg_hectarea );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E18", $estimacion->k_porcentaje_pe );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E19", $estimacion->l_precio_kg );

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E21", $estimacion->venta );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E22", $estimacion->costo_produccion );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E23", $estimacion->utilidad_bruta );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E24", $estimacion->canasta_basica );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E25", $estimacion->utilidad_neta );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E26", $estimacion->rendimiento_historico );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E27", $estimacion->analisis_comparativo );


            //AGREGAR COMENTARIO PARA VALORES DE LA CANASTA
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E32", $estimacion->canasta_basica_alimentacion );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E33", $estimacion->canasta_basica_educacion );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E34", $estimacion->canasta_basica_servicios );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E35", $estimacion->canasta_basica_imprevistos );


            //ESTILO PARA EL EXCEL
            //$objPHPExcel->getActiveSheet(0)->getStyle("B")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);




            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);


           // exit;
            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=" . $matriz->id_soli. "_Estimación.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //$objWriter->setIncludeCharts(TRUE); //permite graficos
            $objWriter->save('php://output');
            exit;
        }
        //fin if

    }



	

        
 
    
    
}
