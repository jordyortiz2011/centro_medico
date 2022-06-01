<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportar_situacion extends MY_Controller {
    
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


    /* Exportar  RELACIÓN DE ESTUDIANTES xCiclo, xTurno xAula */
    public  function  excel_situacion_estudiantes (){

        $post = $this->input->post();
        //print_r($post); exit;

        // ========= FUNCIONES PARA EXPORTADO EXCEL  =======
        $this->load->library('excel');

        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Leemos un archivo Excel 2007
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setIncludeCharts(TRUE);//permite graficos
        $objPHPExcel = $objReader->load("public/docs/plantillas_excel/pagos/plantilla_situacion.xlsx");


        //Crear los títulos de ciclo, turno y aula dentro del archivo excel
        $post               = $this->input->post();
        $search_situacion   = $this->input->post('id_situacion');
        $search_ciclo       = $this->input->post('id_ciclo');
        $search_turno       = $this->input->post('id_turno');
        $search_cicloaula   = $this->input->post('id_cicloaula');

        //Sin son diferente de vacio, crear título
        if( !empty($search_ciclo)  ) {

            $this->load->model('gestores/ciclos/Model_editar');
            $ciclo = $this->Model_editar->obtener_ciclo($search_ciclo);

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

            // 3ro:  Obtener mes de inicio y fin de clases  del ciclo  ===========
            $mes_inicio_fin = '';
            $this->load->helper('fechas');

            $fecha_inicio = new DateTime($ciclo->fecha_ini_clase);
            $numero_mes_inicio = $fecha_inicio->format('n');
            $cadena_mes_inicio = fecha_obtener_nombre_mes($numero_mes_inicio);

            $fecha_fin = new DateTime($ciclo->fecha_fin_clase);
            $numero_mes_fin = $fecha_fin->format('n');
            $cadena_mes_fin = fecha_obtener_nombre_mes($numero_mes_fin);
            $ano_fin        = $fecha_fin->format('Y');

            $mes_inicio_fin =  $cadena_mes_inicio . ' - ' . $cadena_mes_fin . ' ' . $ano_fin;


            //Concatenar 1ro(Etapa: I,II o III) +  2do(tipo:1=Regular , 2=Intensivo)  +  3ro(Mes inicio y fin)
            $nombre_ciclo =  $string_ciclo . ' ' . $mes_inicio_fin;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A4", 'Ciclo: '. $nombre_ciclo );
        }else {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A4", 'Ciclo: Todos' );
        }


        //=======  Obtener los datos del dataTable pasados por POST ====
        $columns = array(
            0 => 'id_matri',
            1 => 'codigo_matri',
            2 => 'situacion',
            3 => 'apellido_paterno_estu',
            4 => 'tbl_ciclos_aulas.id_turno' ,
            5 => 'tbl_ciclos_aulas.nombre_aula_cicloaula' ,
            6 => 'nombre_pago_mod' ,
        );
        //$limit = $this->input->post('length'); //de filas que se mostrara por VISTA en una carga 10/25/100 ..
        //$start = $this->input->post('start');  //primera fila a mostrar de la actual VISTA
        $order = $columns[$this->input->post('order')]; //COLUMNA al cual el ordenamiento debe ser aplicado
        $dir = $this->input->post('dir');   //direccion : asc o des

        $post               = $this->input->post();
        $search_situacion   = $this->input->post('id_situacion');
        $search_ciclo       = $this->input->post('id_ciclo');
        $search_turno       = $this->input->post('id_turno');
        $search_cicloaula   = $this->input->post('id_cicloaula');

        $this->load->model('pagos/Model_exportar_situacion');

        //total de registros
        $totalData = $this->Model_exportar_situacion->allmatriculas_count($post);
        $totalFiltered = $totalData;


        //comprobar si se buscó algo
        if(  empty($this->input->post('search')) &&  empty($search_situacion) &&  empty($search_ciclo) &  empty($search_turno)  &&  empty($search_cicloaula)  )
        {
            $posts = $this->Model_exportar_situacion->allmatriculas($order,$dir);
        }
        else {

            $search = $this->input->post('search');

            $posts =  $this->Model_exportar_situacion->matriculas_search($search, $search_situacion, $search_ciclo, $search_turno, $search_cicloaula,    $order,$dir );

            $totalFiltered = $this->Model_exportar_situacion->matriculas_search_count($search, $search_situacion, $search_ciclo, $search_turno, $search_cicloaula);
        }

        $inicio_fila_fijo = 7;
        $inicio_fila = 7 ; //fila para iniciar a poblar datos
        if(!empty($posts))
        {
            $num = 1 ;

            foreach ($posts as $post)
            {

                //Nombre completo estudiante en mayúscula
                $estudiante =  $post->apellido_paterno_estu.' ' . $post->apellido_materno_estu . ', ' . $post->nombres_estu;
                $estudiante = strtoupper($estudiante);

                //situacion
                if( $post->total_pagar <=  $post->total_importe_actual) {
                    $situacion = 'Cancelado';

                    $objPHPExcel->getActiveSheet()
                        ->getStyle("B$inicio_fila")
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('40f83b');
                }else {
                    $situacion = 'Debe';

                    $objPHPExcel->getActiveSheet()
                        ->getStyle("B$inicio_fila")
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('fd4747');
                }

                //Turno
                $turno = $post->id_turno == 1 ? 'Mañana' : 'Tarde';

                //Montos
                $total_pagar =  round( $post->total_pagar , 2);
                $total_importe =  round( $post->total_importe_actual , 2);
                $saldo =  $total_pagar - $total_importe ;

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$inicio_fila", $post->codigo_matri )
                    ->setCellValue("B$inicio_fila", $situacion)
                    ->setCellValue("C$inicio_fila", $estudiante )
                    ->setCellValue("D$inicio_fila", $turno)
                    ->setCellValue("E$inicio_fila", $post->nombre_aula_cicloaula)
                    ->setCellValue("F$inicio_fila", $post->nombre_pago_mod)
                    ->setCellValue("G$inicio_fila",  $total_pagar )
                    ->setCellValue("H$inicio_fila", $total_importe)
                    ->setCellValue("I$inicio_fila", $saldo)
                ;

                $inicio_fila++;

            }//Fin foreach de datos

            //Bordes
            $inicio_fila--;
            $objPHPExcel->getActiveSheet()
            ->getStyle("A$inicio_fila_fijo:I$inicio_fila")
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

         //Sumatoria de montos
         $fila_sumatoria = $inicio_fila + 2 ;
        //APLICAR SUMATORIA
        $objPHPExcel->getActiveSheet(0)->setCellValue("F$fila_sumatoria", "TOTAL : ");
        //Total a pagar
        $objPHPExcel->getActiveSheet(0)->setCellValue("G$fila_sumatoria", "=SUM(G$inicio_fila_fijo:G$inicio_fila)");
        //Importe total
        $objPHPExcel->getActiveSheet(0)->setCellValue("H$fila_sumatoria", "=SUM(H$inicio_fila_fijo:H$inicio_fila)");
        //Saldo
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$fila_sumatoria", "=SUM(I$inicio_fila_fijo:I$inicio_fila)");



        }//Fin if post(resultado bd) vacio



        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $objPHPExcel->setActiveSheetIndex(0);

        //$nombreFichero =  url_title($string_turno . '_' .  $cicloaula->nombre_aula_cicloaula);
        //echo $nombreFichero; exit;
        // exit;
        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Situacion_estudiantes.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->setIncludeCharts(TRUE); //permite graficos
        $objWriter->save('php://output');
        exit;

    }















	

        
 
    
    
}
