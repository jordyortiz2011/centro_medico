<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportar_recibos extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)           
        $this->require_min_level(1);

        
             
    }


  // --------------------------------------------------------------
/**
 * Para exportar excel
 * @param $search(string): Cadena de busqueda del dataTable
 *      $search_ciclo(string): valor del select a filtrar
 *      $order(int)         : indice de la columna a filtrar
 *      $dir(string)         : asc o desc, tipo de ordenamiento
 * @return json , valores para el datatable
 */
    public function exportar_listado_recibos_excel($search, $search_ciclo , $order , $dir )
    {
        
         // Method should not be directly accessible                      
          if(   $this->auth_level == 9 || $this->auth_level == 7  )
        {

            // ============ FUNCIONES PARA OBTENER DATOS   =======

			//nombres iguales a los campos de la base de datos
            //los indices tienen que corresponder al orden de columnas del js del datatable
			$columns = array(
                            0 => 'id_pago',
                            1 => 'codigo_matri',
                            2 => 'apellido_paterno_estu',
                            3 => 'numero_recibo_pago',
                            4 => 'monto_recibo_pago' ,
                            5 => 'fecha_recibo_pago' ,
                            6 => 'fecha_registro_pago' ,

                            8 => 'id_ciclo_matri'
            );
            $order = $columns[$order]; //COLUMNA al cual el ordenamiento debe ser aplicado
			
			//$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
	        //$start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
	        //$order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado
            //$dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des
			
			//echo "$order";exit;

            $search         = ($search == '_vacio_'  )  ?  '' : $search ;
            $search_ciclo   = ($search_ciclo == '_todos_'  )  ?  '' : $search_ciclo ;


            //echo "search ciclo: " . var_dump($search_ciclo);exit;
	       
		 	$this->load->model('pagos/Model_exportar_recibos') ;
            $totalData = $this->Model_exportar_recibos->allpagos_count();
            $totalFiltered = $totalData;


            //comprobar si se buscó algo
			if(empty($search) &&  empty($search_ciclo )  )
	        {            
	            $posts = $this->Model_exportar_recibos->allpagos($order,$dir);
	        }
	        else {

			    //echo 'buscar';
	            //$search = $this->input->post('search')['value'];
	
	            $posts =  $this->Model_exportar_recibos->pagos_search($search, $search_ciclo,  $order,$dir );
	
	            $totalFiltered = $this->Model_exportar_recibos->pagos_search_count($search, $search_ciclo);
	        }

            // ========= FUNCIONES PARA EXPORTADO EXCEL  =======
            $this->load->library('excel');
            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();

            // Leemos un archivo Excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //$objReader->setIncludeCharts(TRUE);//permite graficos
            $objPHPExcel = $objReader->load("public/docs/plantillas_excel/pagos/listado_recibos.xlsx");


            // ==== Información adicional para el EXCEL =====
            if( empty($search_ciclo) ) {
                //Todos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("C5", 'Todos los ciclos' );
            }else{
                //echo $search_ciclo;
                // ===== Obtener datos del CICLO ===========
                $this->load->model('reutilizables/Model_ciclos');
                $ciclo = $this->Model_ciclos->obtener_ciclo($search_ciclo);
                //var_dump($ciclo);exit;

                //==== Obtener CICLO (NOMBRE) =====
                //1ro concatenar la ETAPA (I , II o III )
                $this->load->helper('numeros');
                $string_ciclo = numero_convertir_a_romano($ciclo->etapa_ciclo ) ;

                //2do concatenar el tipo (1=Regular , 2=Intensivo)
                if ($ciclo->id_tipo_ciclo == 1 ) {
                    $string_ciclo = $string_ciclo . ' ' . 'REGULAR ';
                }else if ($ciclo->id_tipo_ciclo == 2 )  {
                    $string_ciclo = $string_ciclo . ' ' . 'INTENSIVO ';
                }else {
                    $string_ciclo = $string_ciclo . ' ' . 'SIN TIPO ';
                }

                $ano_fin = new DateTime($ciclo->fecha_fin_clase);
                $ano_fin = $ano_fin->format('Y');

                $ciclo_string = $string_ciclo . ' ' . $ano_fin;
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("C5", $ciclo_string );

            }


            //print_r($posts);
			$data = array();
	        if(!empty($posts))
	        {
	        	$this->load->helper('fechas');
	        	$inicio_fila = 10;
                $inicio_fila_principal = $inicio_fila;
	        	$contador_registros = 1 ;
	            foreach ($posts as $post)
	            {
						  
					/*$nestedData['id_registro'] = $post->id_pago; //para hacer la eliminacion
                    $nestedData['cod_matricula'] = $post->codigo_matri;
					$nestedData['estudiante'] = $post->apellido_paterno_estu . ' ' . $post->apellido_materno_estu .  ', ' . $post->nombres_estu ;
                    $nestedData['num_recibo'] = $post->numero_recibo_pago;
                    $nestedData['monto_recibo'] = $post->monto_recibo_pago;
                    $nestedData['fecha_recibo'] = $post->fecha_recibo_pago;
					$nestedData['fecha_registro'] =  array(
														'mostrar_fecha' => fecha_transformar_fecha($post->fecha_registro_pago),
														'ordenar_fecha' => $post->fecha_registro_pago
													  );
                    //campos ocultos para el filtrado
                    $nestedData['id_ciclo'] = $post->id_ciclo_matri;
	                $data[] = $nestedData; */

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$inicio_fila", $contador_registros )
                        ->setCellValue("B$inicio_fila", $post->codigo_matri )
                        ->setCellValue("C$inicio_fila", $post->apellido_paterno_estu . " " .  $post->apellido_materno_estu . ",  "  . $post->nombres_estu )

                        ->setCellValue("D$inicio_fila",  $post->numero_recibo_pago )
                        ->setCellValue("E$inicio_fila",  $post->monto_recibo_pago )
                        ->setCellValue("F$inicio_fila",  $post->fecha_recibo_pago )

                    ;
                    // Texto alineado a la Izquierda
                    $objPHPExcel->getActiveSheet(0)->getStyle("B$inicio_fila")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    //aumentar el alto de las filas
                    $objPHPExcel->getActiveSheet()
                        ->getRowDimension( $inicio_fila )
                        ->setRowHeight('25');

                    //bordes
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$inicio_fila:F$inicio_fila")
                        ->applyFromArray(
                            array(
                                'borders' =>
                                    array(
                                        'allborders' => array(
                                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                        )
                                    )
                            )

                        );

                    //background si es es par
                    if ($inicio_fila%2 == 0 ) {
                        $objPHPExcel->getActiveSheet()
                            ->getStyle("A$inicio_fila:F$inicio_fila")
                            ->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                                        'color'		=> array('argb' => 'FFCCFFCC')
                                    )
                                )
                            );
                    }


                    $inicio_fila++;
                    $contador_registros++;
	            }//fin foreach
                $fin_fila_principal = $inicio_fila - 1;
                $num_fila_sumatoria = $fin_fila_principal +2 ;

	            //APLICAR SUMATORIA
                $objPHPExcel->getActiveSheet(0)->setCellValue("D$num_fila_sumatoria", "TOTAL : ");
                $objPHPExcel->getActiveSheet(0)->setCellValue("E$num_fila_sumatoria", "=SUM(E$inicio_fila_principal:E$fin_fila_principal)");



	        }//Fin post(datos de la busqueda) vacio


            //exit;
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);

            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=Listado_Recibos.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //$objWriter->setIncludeCharts(TRUE); //permite graficos
            $objWriter->save('php://output');
            exit;
			                          
        }//fin verificación de permisos
  
    }


    // --------------------------------------------------------------
    /**
     * Para exportar PDF
     * @param $search(string): Cadena de busqueda del dataTable
     *      $search_ciclo(string): valor del select a filtrar
     *      $order(int)         : indice de la columna a filtrar
     *      $dir(string)         : asc o desc, tipo de ordenamiento
     * @return json , valores para el datatable
     */
    public function exportar_listado_recibos_pdf($search, $search_ciclo , $order , $dir )
    {

        // Method should not be directly accessible
        if(   $this->auth_level == 9 || $this->auth_level == 7  )
        {

            // ============ FUNCIONES PARA OBTENER DATOS   =======

            //nombres iguales a los campos de la base de datos
            //los indices tienen que corresponder al orden de columnas del js del datatable
            $columns = array(
                0 => 'id_pago',
                1 => 'codigo_matri',
                2 => 'apellido_paterno_estu',
                3 => 'numero_recibo_pago',
                4 => 'monto_recibo_pago' ,
                5 => 'fecha_recibo_pago' ,
                6 => 'fecha_registro_pago' ,

                8 => 'id_ciclo_matri'
            );
            $order = $columns[$order]; //COLUMNA al cual el ordenamiento debe ser aplicado

            //$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
            //$start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
            //$order = $columns[$this->input->post('order')[0]['column']]; //COLUMNA al cual el ordenamiento debe ser aplicado
            //$dir = $this->input->post('order')[0]['dir'];   //direccion : asc o des

            //echo "$order";exit;

            $search         = ($search == '_vacio_'  )  ?  '' : $search ;
            $search_ciclo   = ($search_ciclo == '_todos_'  )  ?  '' : $search_ciclo ;


            //echo "search ciclo: " . var_dump($search_ciclo);exit;

            $this->load->model('pagos/Model_exportar_recibos') ;
            $totalData = $this->Model_exportar_recibos->allpagos_count();
            $totalFiltered = $totalData;


            //comprobar si se buscó algo
            if(empty($search) &&  empty($search_ciclo )  )
            {
                $posts = $this->Model_exportar_recibos->allpagos($order,$dir);
            }
            else {

                //echo 'buscar';
                //$search = $this->input->post('search')['value'];

                $posts =  $this->Model_exportar_recibos->pagos_search($search, $search_ciclo,  $order,$dir );

                $totalFiltered = $this->Model_exportar_recibos->pagos_search_count($search, $search_ciclo);
            }

            // ========= FUNCIONES PARA EXPORTADO EXCEL  =======
            $this->load->library('excel');
            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();

            // Leemos un archivo Excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //$objReader->setIncludeCharts(TRUE);//permite graficos
            $objPHPExcel = $objReader->load("public/docs/plantillas_excel/pagos/listado_recibos_pdf.xlsx");


            // ==== Información adicional para el EXCEL =====
            if( empty($search_ciclo) ) {
                //Todos
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("C5", 'Todos los ciclos' );
            }else{
                //echo $search_ciclo;
                // ===== Obtener datos del CICLO ===========
                $this->load->model('reutilizables/Model_ciclos');
                $ciclo = $this->Model_ciclos->obtener_ciclo($search_ciclo);
                //var_dump($ciclo);exit;

                //==== Obtener CICLO (NOMBRE) =====
                //1ro concatenar la ETAPA (I , II o III )
                $this->load->helper('numeros');
                $string_ciclo = numero_convertir_a_romano($ciclo->etapa_ciclo ) ;

                //2do concatenar el tipo (1=Regular , 2=Intensivo)
                if ($ciclo->id_tipo_ciclo == 1 ) {
                    $string_ciclo = $string_ciclo . ' ' . 'REGULAR ';
                }else if ($ciclo->id_tipo_ciclo == 2 )  {
                    $string_ciclo = $string_ciclo . ' ' . 'INTENSIVO ';
                }else {
                    $string_ciclo = $string_ciclo . ' ' . 'SIN TIPO ';
                }

                $ano_fin = new DateTime($ciclo->fecha_fin_clase);
                $ano_fin = $ano_fin->format('Y');

                $ciclo_string = $string_ciclo . ' ' . $ano_fin;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("C5", $ciclo_string );

            }


            //print_r($posts);
            $data = array();
            if(!empty($posts))
            {
                $this->load->helper('fechas');
                $inicio_fila = 10;
                $inicio_fila_principal = $inicio_fila;
                $contador_registros = 1 ;
                foreach ($posts as $post)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$inicio_fila", $contador_registros )
                        ->setCellValue("B$inicio_fila", $post->codigo_matri )
                        ->setCellValue("C$inicio_fila", $post->apellido_paterno_estu . " " .  $post->apellido_materno_estu . ",  "  . $post->nombres_estu )

                        ->setCellValue("D$inicio_fila",  $post->numero_recibo_pago )
                        ->setCellValue("E$inicio_fila",  $post->monto_recibo_pago )
                        ->setCellValue("F$inicio_fila",  $post->fecha_recibo_pago )

                    ;
                    // Texto alineado a la Izquierda
                    $objPHPExcel->getActiveSheet(0)->getStyle("B$inicio_fila")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    //aumentar el alto de las filas
                    $objPHPExcel->getActiveSheet()
                        ->getRowDimension( $inicio_fila )
                        ->setRowHeight('25');

                    //bordes
                    /*$objPHPExcel->getActiveSheet()
                        ->getStyle("A$inicio_fila:F$inicio_fila")
                        ->applyFromArray(
                            array(
                                'borders' =>
                                    array(
                                        'allborders' => array(
                                            'style' => PHPExcel_Style_Border::BORDER_THICK
                                        )
                                    )
                            )

                        ); */

                    //background si es es par
                    if ($inicio_fila%2 == 0 ) {
                        $objPHPExcel->getActiveSheet()
                            ->getStyle("A$inicio_fila:F$inicio_fila")
                            ->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                                        'color'		=> array('argb' => 'FFCCFFCC')
                                    )
                                )
                            );
                    }


                    $inicio_fila++;
                    $contador_registros++;
                }//fin foreach
                $fin_fila_principal = $inicio_fila - 1;
                $num_fila_sumatoria = $fin_fila_principal +2 ;

                //APLICAR SUMATORIA
                $objPHPExcel->getActiveSheet(0)->setCellValue("D$num_fila_sumatoria", "TOTAL : ");
                $objPHPExcel->getActiveSheet(0)->setCellValue("E$num_fila_sumatoria", "=SUM(E$inicio_fila_principal:E$fin_fila_principal)");



            }//Fin post(datos de la busqueda) vacio


            //exit;
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);

            /* === Exportado a PDF  ===== */
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

            //No mostrar lineas por defecto del Excel
            $objPHPExcel->getActiveSheet(0)->setShowGridLines(FALSE);

            //cambiar orientación de la hoja
            $objPHPExcel->getActiveSheet(0)->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);



            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de PDF.
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename=Listado_Recibos.pdf');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            $objWriter->save('php://output');

        }//fin verificación de permisos

    }

        
 
    
    
}
