<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_webservice extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }


    // --------------------------------------------------------------
    /**
     * Buscar el dni del titular
     * @param POST $dni(string)
     * @return JSON $respt (Objeto) = valores de la busqueda
     *  */
    public function buscar_dni_titular(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $dni = $post['text_dni'];
        //print_r($post);exit;

        //Hacer validación de no permitir registrar cuando haya una solicitud pendiente
        if( $this->validacion_solicitud_inconclusa($dni) == FALSE) {
            //FALSE = Existe una solicitud inconclusa
            $respt->cod_estado = 501 ;
            echo json_encode($respt);
            exit;
        }


        //MANEJO CON EL WEBSERVICE
        //include_once APPPATH . 'libraries/lib_nusoap/nusoap.php';
        include_once APPPATH . 'libraries/nusoap-master/src/nusoap.php';

        $client = new nusoap_client('https://www2.sentinelperu.com/wsevo2/aws_sentinelinfpri.aspx?wsdl',true);
        $client->soap_defencoding = 'utf-8';
        $client->decode_utf8 = FALSE;

        $error  = $client->getError();
        if ($error) {
            echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
        }

        $parametros = array(
            "Gx_usuenc"     =>  "l2ITC/RNN66UCyGBFGzrsw==",
            "Gx_pasenc"     =>  "ilmtQM/zX5+s4anq80NXCw==",
            "Gx_key"        =>  "385F1B330B10344697A09DC8CC5DD975",
            "Ti_tipodoc"    =>  "D",
            "Ti_nrodoc"     =>  $dni ,
            "Cg_tipoDoc"    =>  "",
            "Cg_nrodoc"    =>  ""
        );


        $resultado = $client->call('Execute', $parametros);
        //print_r($resultado); exit;
        //PARA DEPURACIÓN DE ENVIO Y RECEPCIÓN
        /*echo '<h2>Request</h2>';
        echo '<pre>' .  htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2>';
        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        exit; */

        //MANIPULACIÓN DEL RESULTADO DEL WEBSERVICE
        if($resultado['Codigows'] == 0 ) {
            //Consulta exitosa
            $respt->cod_estado = 0 ;

            //primero convertir todo a minúscula, luego la 1ra letra de cada palabra a mayúscula
            $respt->nombres_titular =  ucwords(  strtolower($resultado['Ti_nombres']) );
            $respt->ape_paterno_titular =  ucwords( strtolower( $resultado['Ti_paterno']));
            $respt->ape_materno_titular =  ucwords( strtolower($resultado['Ti_materno']));

            //cambiar  formato de fecha dd/mm/aaaa x YYYY/MM/DD
            $date = str_replace('/', '-', $resultado['Ti_fchnac'] );
            $respt->fecha_naci_titular = date("Y-m-d", strtotime($date));

            // ===== Obtener Documentos impagos y Protestos ======
            $documentos = explode(";" , $resultado['Ti_montodocumento']);

            $impagos_array = explode(" " , $documentos[0]);
            $respt->impagos_monto_titular = $impagos_array[1];

            $protestos_array = explode(" " , $documentos[1]);
            $respt->protestos_monto_titular = $protestos_array[2];

            // ===== Calificación últimos 24 meses  ======
            $respt->calificacion_titular = $resultado['Ti_calddpult24'];

            // ==== RECORRER LAS ENTIDADES FINANCIERAS  =======
            $entidades = $resultado['Ti_entidades'];
            //var_dump($entidades);
            if (is_array($entidades) ) {

                $respt->estado_entidades = true; //True=Tiene deuda con entidades

                $respt->mis_entidades =  $entidades;

            }else {
                //echo "NO SOY array";
                $respt->estado_entidades = false; //false=NO TIENE deuda con entidades
            }




            //print_r($protestos_array); exit;

        }
        else if ($resultado['Codigows'] != 0 ) {
            //consulta con errores
            $respt->cod_estado = $resultado['Codigows'] ;
        }


        echo json_encode($respt);

    }

    // --------------------------------------------------------------
    /**
     * Buscar el dni del titular
     * @param POST $dni(string)
     * @return JSON $respt (Objeto) = valores de la busqueda
     *  */
    public function buscar_dni_conyuge(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $dni = $post['text_dni'];
        //print_r($post);exit;


        //MANEJO CON EL WEBSERVICE
        //include_once APPPATH . 'libraries/lib_nusoap/nusoap.php';
        include_once APPPATH . 'libraries/nusoap-master/src/nusoap.php';

        $client = new nusoap_client('https://www2.sentinelperu.com/wsevo2/aws_sentinelinfpri.aspx?wsdl',true);
        $client->soap_defencoding = 'utf-8';
        $client->decode_utf8 = FALSE;

        $error  = $client->getError();
        if ($error) {
            echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
        }

        $parametros = array(
            "Gx_usuenc"     =>  "l2ITC/RNN66UCyGBFGzrsw==",
            "Gx_pasenc"     =>  "ilmtQM/zX5+s4anq80NXCw==",
            "Gx_key"        =>  "385F1B330B10344697A09DC8CC5DD975",
            "Ti_tipodoc"    =>  "D",
            "Ti_nrodoc"     =>  $dni ,
            "Cg_tipoDoc"    =>  "",
            "Cg_nrodoc"    =>  ""
        );


        $resultado = $client->call('Execute', $parametros);
        //print_r($resultado); exit;
        //PARA DEPURACIÓN DE ENVIO Y RECEPCIÓN
        /*echo '<h2>Request</h2>';
        echo '<pre>' .  htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2>';
        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        exit; */

        //MANIPULACIÓN DEL RESULTADO DEL WEBSERVICE
        if($resultado['Codigows'] == 0 ) {
            //Consulta exitosa
            $respt->cod_estado = 0 ;

            $respt->nombres_titular =  ucwords(  strtolower($resultado['Ti_nombres'] ) );
            $respt->ape_paterno_titular =  ucwords(  strtolower($resultado['Ti_paterno']) );
            $respt->ape_materno_titular =  ucwords (  strtolower($resultado['Ti_materno']) );

            //cambiar  formato de fecha dd/mm/aaaa x YYYY/MM/DD
            $date = str_replace('/', '-', $resultado['Ti_fchnac'] );
            $respt->fecha_naci_titular = date("Y-m-d", strtotime($date));

            // ===== Obtener Documentos impagos y Protestos ======
            $documentos = explode(";" , $resultado['Ti_montodocumento']);

            $impagos_array = explode(" " , $documentos[0]);
            $respt->impagos_monto_titular = $impagos_array[1];

            $protestos_array = explode(" " , $documentos[1]);
            $respt->protestos_monto_titular = $protestos_array[2];

            // ===== Calificación últimos 24 meses  ======
            $respt->calificacion_titular = $resultado['Ti_calddpult24'];

            // ==== RECORRER LAS ENTIDADES FINANCIERAS  =======
            $entidades = $resultado['Ti_entidades'];
            //var_dump($entidades);
            if (is_array($entidades) ) {

                $respt->estado_entidades = true; //True=Tiene deuda con entidades
                $respt->mis_entidades =  $entidades;

            }else {
                //echo "NO SOY array";
                $respt->estado_entidades = false; //false=NO TIENE deuda con entidades
            }

            //print_r($protestos_array); exit;

        }
        else if ($resultado['Codigows'] != 0 ) {
            //consulta con errores
            $respt->cod_estado = $resultado['Codigows'] ;



        }


        echo json_encode($respt);

    }

    /* Para comprobar si el docente ya tiene asignado un aula en un
        determinado día de la semana y hora */
    private function  validacion_solicitud_inconclusa($dni) {

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







    
}
