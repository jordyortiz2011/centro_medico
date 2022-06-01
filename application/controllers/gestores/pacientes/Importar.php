<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Importar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //nivel 1 requerido para acceder
         
         $this->load->helper('form');
         $this->load->database();

    }
	
	public function index(){
		redirect();
	}
  
  
  // --------------------------------------------------------------
    /**
     * muestra formulario para registro colegio    
     * @param  -_-  
     */   
    public function form_importar()
    {
        
         // Method should not be directly accessible                      
         if( $this->auth_level == 9 || $this->auth_level == 5   )
        {

            /*$this->load->model('reutilizables/Model_codigos_renaes');
            $lst_establecimientos =  $this->Model_codigos_renaes->listado_codigos();*/

            //print_r($lst_codigos); exit;
			
			$data = array(
							//'lst_establecimientos' =>  $lst_establecimientos
						 );			
                       
            $this->load->view('gestores/pacientes/vista_importar', $data);
        }
  
    }
	
	
	   /**
     * Obtiene los datos del formulario Modulo Anuncio/Nuevo, los procesa, 
     * valida, y los manda al modelo, para guardar en la BD
     * Permiso: solo administradores    
     * @param  -_-
     * @return  -_- (carga  la vista de listado de usuarios)   
     */       
    public function procesa()
    {
        
         // Method should not be directly accessible                      
        if(  $this->auth_level == 9  || $this->auth_level == 5   )
        {
            $post = $this->input->post(); 		
		    //print_r($post)         ; exit;
           
            //establecer reglas de validacion:           
            $this->validacion_reglas();        
          
            //Si es falso , regresa de nuevo al formulario
            if( $this->form_validation->run() == FALSE  )
            {                                          
               //$this->load->view('formulario/vista_formulario');
			  $this->form_importar();
			    
            }
            else {            				
				//print_r($post); exit;
                //ECHO "empezar la migracion"; //exit;
                $inputFileName = $_FILES['file_archivo']['tmp_name'];

                /*$reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($inputFileName); */
                $inputFileType = 'Xlsx';
                //$inputFileName = './mysheet.xlsx';

                /**  Create a new Reader of the type defined in $inputFileType  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                /**  Advise the Reader that we only want to load cell data  **/
                $reader->setReadDataOnly(true);

                $worksheetData = $reader->listWorksheetInfo($inputFileName);

                foreach ($worksheetData as $worksheet) {

                    $sheetName = $worksheet['worksheetName'];

                    echo "<h4>$sheetName</h4>";
                    /**  Load $inputFileName to a Spreadsheet Object  **/
                    $reader->setLoadSheetsOnly($sheetName);
                    $spreadsheet = $reader->load($inputFileName);

                    $worksheet = $spreadsheet->getActiveSheet();
                    $data = $worksheet->toArray();
                    //print_r($worksheet->toArray());
                    $removed = array_shift($data);
                    //print_r($removed); exit;
                    /*echo "<table style='border: 1px solid black;'>";
                    echo "<tr>";
                    echo "<th>$removed[0] </th>";
                    echo "<th>$removed[1] </th>";
                    echo "<th>$removed[2] </th>";
                    echo "<th>$removed[3] </th>";
                    echo "<th>$removed[4] </th>";
                    echo "<th>$removed[5] </th>";
                    echo "<th>$removed[6] </th>";
                    echo "<th>$removed[7] </th>";
                    echo "<th>$removed[8] </th>";
                    echo "<th>$removed[9] </th>";
                    echo "<th>$removed[10] </th>";
                    echo "<th>$removed[11] </th>";
                    echo "<th>$removed[12] </th>";
                    echo "<th>$removed[13] </th>";
                    echo "<th>$removed[14] </th>";
                    echo "</tr>";
                    foreach ($data as $fila) {
                        //print_r($fila);
                        echo "<tr>";
                        echo "<td style='border: 1px solid black;'>$fila[0] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[1] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[2] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[3] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[4] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[5] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[6] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[7] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[8] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[9] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[10] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[11] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[12] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[13] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[14] </td>";
                        echo "</tr>";


                    }
                    echo "</table>"; */
                    $this->load->model('gestores/pacientes/Model_importar');
                    //$lst_establecimientos =  $this->Model_importar->listado_codigos()

                    $fecha=new DateTime();
                    $fecha_registro=$fecha->format('Y-m-d H:i:s');


                    //$this->db->trans_begin();

                    $cont = 2 ; //Contador de fila

                    foreach ($data as $fila) {
                        //print_r($fila);

                        //Validar si la fila es correcta
                        //establecer reglas de validacion:
                        $mi_validacion =  $this->validacion_excel($fila);
                        //Si es falso , regresa de nuevo al formulario
                        if( is_string($mi_validacion) ) {
                            redirect("gestores/pacientes/importar/form_importar?col=$mi_validacion&fila=$cont" , 'refresh');
                        }

                        // exit;

                        //COLUMNA A: ID SIS
                        $id_sis = $fila[0];




                        // ====== Cambiar formato de los datos , para insertar en BD =======
                        $fecha_afiliacion   =  $array_fecha = explode('/' ,  $fila[5]) ;
                        $fecha_afiliacion   = $fecha_afiliacion['2'] . '-' .  $fecha_afiliacion['1'] . '-' . $fecha_afiliacion['0'];

                        $fecha_naci   = explode('/' ,  $fila[9]) ;
                        $fecha_naci   = $fecha_naci['2'] . '-' .  $fecha_naci['1'] . '-' . $fecha_naci['0'];

                        //echo $fecha_naci; exit;

                        if($fila[11] != ''){
                            $fecha_baja   =  $array_fecha = explode('/' ,  $fila[11]) ;
                            $fecha_baja   = $fecha_baja['2'] . '-' .  $fecha_baja['1'] . '-' . $fecha_baja['0'];
                        }else{
                            $fecha_baja   = NULL;
                        }

                        $estado             =  $fila[10] == 'Activo' ? 1 : 0 ;

                        //Obtener id de código renaes, de la BD
                        $codigo = $this->Model_importar->obtener_codigo_renaes($fila[12]);
                        $id_cod = $codigo->id_codigo_renaes;

                        //Comprobar si existe el paciente
                        $res = $this->Model_importar->comprobar_paciente_xIdSIS($id_sis);

                        //PACIENTE NO EXISTE, ENTONCES INSERTAR
                        if($res == FALSE){

                            $datos = array(
                                'excel_idSis_paci'              => $fila[0],
                                'excel_nroFormato_paci'         => $fila[2],
                                'excel_idTipoDoc_paci'          => $fila[4],
                                'excel_fechaAfiliacion_paci'    => $fecha_afiliacion, //$fila[5],
                                'excel_dni_paci'                => $fila[6],
                                'excel_asegurado_paci'          => $fila[7],
                                'excel_sexo_paci'               => $fila[8],
                                'excel_fechaNaci_paci'          => $fecha_naci, //$fila[9],
                                'excel_estado_paci'             => $estado, //$fila[10]
                                'excel_fechaBaja_paci'          => $fecha_baja, //$fila[11],
                                'id_eess_paci'               => $id_cod, //$fila[12],

                                'posee_sis_paci'               => 1, //1=si; 2=NO


                                //meta datos
                                'fecha_registro_paci'     => $fecha_registro,
                                'user_registro_paci'	      => $this->auth_user_id,
                            );

                            $this->db->insert('tbl_pacientes' , $datos);
                            //var_dump($res);
                        }
                        //PACIENTE EXITE, ENTONCES ACTUALIZAR
                        else{

                            $datos = array(
                                'excel_nroFormato_paci'         => $fila[2],
                                'excel_idTipoDoc_paci'          => $fila[4],
                                'excel_fechaAfiliacion_paci'    => $fecha_afiliacion, //$fila[5],
                                'excel_dni_paci'                => $fila[6],
                                'excel_asegurado_paci'          => $fila[7],
                                'excel_sexo_paci'               => $fila[8],
                                'excel_fechaNaci_paci'          => $fecha_naci, //$fila[9],
                                'excel_estado_paci'             => $estado, //$fila[10]
                                'excel_fechaBaja_paci'          => $fecha_baja, //$fila[11],
                                'id_eess_paci'               => $id_cod, //$fila[12],

                            );

                            $query = $this->db->where('excel_idSis_paci' ,$fila[0])
                                                ->update('tbl_pacientes',$datos ) ;
                        }
                       // exit;


                        /*echo "<td style='border: 1px solid black;'>$fila[0] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[1] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[2] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[3] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[4] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[5] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[6] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[7] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[8] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[9] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[10] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[11] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[12] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[13] </td>";
                        echo "<td style='border: 1px solid black;'>$fila[14] </td>";
                        echo "</tr>"; */

                        $cont++;
                    }

                    //Terminar transacción:
                    //$this->db->trans_complete();

                }


               // exit;




                //guardar en la BD
				//$this->load->model('gestores/pacientes/Model_registrar');
                //$result =  $this->Model_registrar->guardar_paciente($post);

                if ( true == true ) {

                    //registro Correcto, guardamos variable de sesión  flash para mostrar  mensaje (sweetalert)
                    $this->session->set_flashdata('estado_registro', 'registrado');

                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'permanecer')
                        redirect('gestores/pacientes/importar/form_importar', 'refresh');
                    else if($post['btn_subir'] == 'listar')
                        redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
                    else
                        redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');


                }else {

                    //registro Correcto, entonces mostramos mensaje y cargamos de nuevo vista registrar
                    $this->session->set_flashdata('registro_error', true);
                    redirect('gestores/pacientes/listar/listar_pacientes', 'refresh');
                }
                
                                
            }//fin de form_validation->run()
        
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
		
		// ==== para el Tipo de documento =====
       $this->form_validation->set_rules('file_archivo', 'Archivo', 'trim|callback_subir_fichero'
										 //mensajes personalizados de cada regla de validación
										 /*array(
									                'is_unique'     => 'Este <b> %s </b> ya existe.'
									           ) */
										);
    }//fin funcion validación reglas

    private function validacion_excel ($fila)
    {
        //carga la libreria para validar formulario
        $this->load->library('form_validation');
        $this->config->set_item('language', 'spanish');

        // ==== para el Tipo de documento =====
        /*$this->form_validation->set_rules('file_archivo', 'Archivo', 'required|trim'
        //mensajes personalizados de cada regla de validación
        /*array(
                   'is_unique'     => 'Este <b> %s </b> ya existe.'
              )
        ); */

        //ID SIS
        if( !is_numeric($fila[0] )) {
            //echo "no soy numerico";
           return "A";
        }

        //Nro Formato
        if( strlen($fila[2]) > 14) {
            //echo "no soy numerico";
            return "C";
        }

        //Tipo de Documento
        if( strlen($fila[4]) > 14) {
            //echo "no soy numerico";
            return "E";
        }

         //Fecha de afiliación
        //echo $fila[5];
        if( !$this->validacion_fecha($fila[5])) {
            return "F";
        }

        //Comprobar si DNI NO CONTIENE LETRAS
        if( preg_match('/[A-Za-z]+/', $fila[6]) ) {
            return "G";
        }

        //Comprobar SEXO
        $sexos = array("F", "M");
        if(  !in_array($fila[8] ,$sexos ) ) {
            return "I";
        }

        //Comprobar Fecha nacimiento
        if( !$this->validacion_fecha($fila[9]) ) {
            return "J";
        }

        //Comprobar Estado
        $estados = array("Activo", "Inactivo");
        if( !in_array($fila[10] ,$estados ) ) {
            return "K";
        }

        if($fila[11] != '') {
            //Comprobar Fecha nacimiento
            if( !$this->validacion_fecha($fila[11]) ) {
                return "L";
            }
        }

        //Comprobar si EESS, existe en la BD
        $this->load->model('gestores/pacientes/Model_importar');
        $result =  $this->Model_importar->comprobar_codExcel_EESS($fila[12]);
        //var_dump($result); exit;
        if( !$result) {
            return "M";
         }


        //EXIT;


    }//fin funcion validación reglas

    /* Para comprobar si el docente ya tiene asignado un aula en un
           determinado día de la semana y hora */
    function subir_fichero() {

        if( (isset($_FILES['file_archivo']))  && $_FILES['file_archivo']['name'])
        {
            $config['upload_path']       = './public/img/fotos_campo/original';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 8000; //5 MB max
            //$config['max_width']      = 1024;
            //$config['max_height']     = 768;
            $config['overwrite']        = true; //sobreescritura

            $temp = explode(".",$_FILES["file_archivo"]["name"]);
            $extension = end($temp);

            //Comprobar que se subió de tipo excel
            $mimes = array ('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $allowedExts = array ('xls', 'xlsx');
            if ( !in_array($_FILES['file_archivo']['type'], $mimes) && !in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('subir_fichero', 'No se subió un archivo de tipo excel');
                return FALSE;
            }
            else {
                return TRUE;
            }


        }//fin comprobación IF se subió foto
        else
        {
            $this->form_validation->set_message('subir_fichero', 'No se subió archivo');
            return FALSE;
        }


    }


    //comprueba si el texto es una fecha válida con formato YYYY-MM-DD
    public function validacion_fecha($fecha){
        //print_r(var_dump($str));exit;
        $array_fecha = explode('/' ,  $fecha) ;
        $anyo = $array_fecha[2];
        $mes = $array_fecha[1];
        $dia = $array_fecha[0];

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
