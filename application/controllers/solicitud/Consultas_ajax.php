<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_ajax extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        
        //forzar autentificacion si no está logueado
         $this->require_min_level(1); //5=controlador, 6=nutricionista , 9=admin
        
    }



    /** ================ PARA EL las ZONAS  ==================== */
    // --------------------------------------------------------------
    /**
     * Ejecutado al Cambiar el select de Departamentos
     * @param
     * @return (Objeto) Listados de Provincias
     *  */
    public function combobox_provincias_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
         $id_departamento = $post['id_departamento']; //id del ciclo
        //print_r($post);exit;

        $this->load->model('reutilizables/zonas/Model_provincias');
        $lst_provincias = $this->Model_provincias->obtener_provincias($id_departamento);
        $respt->lst_provincias  = $lst_provincias;

        echo json_encode($respt);

    }

    // --------------------------------------------------------------
    /**
     * Ejecutado al Cambiar el select de PROVINCIAS
     * @param
     * @return (Objeto) Listados de Distritos
     *  */
    public function combobox_distritos_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $id_provincia = $post['id_provincia']; //id del ciclo
        //print_r($post);exit;

        $this->load->model('reutilizables/zonas/Model_distritos');
        $lst_distritos = $this->Model_distritos->obtener_distritos($id_provincia);
        $respt->lst_distritos  = $lst_distritos;

        echo json_encode($respt);

    }

    // --------------------------------------------------------------
    /**
     * Ejecutado al Cambiar el select de AGENCIA
     * @param
     * @return (Objeto) Listados de Analistas (credito) de la agencia
     *  */
    public function combobox_agencias_ajax(){

        // respuesta al script ajax
        $respt = new stdClass();

        $post = $this->input->post();
        $id_agencia = $post['id_agencia']; //id del ciclo
        //print_r($post);exit;

        //obtener datos del usuario logeado
        //

        $this->load->model('reutilizables/Model_asesores');
        $lst_asesores = $this->Model_asesores->listado_asesores($id_agencia);
        $respt->lst_asesores  = $lst_asesores;

        echo json_encode($respt);

    }


    //Subir foto (usado al registrar, cuando se sube la foto)
    public function subir_archivo()
    {
        $post  = $this->input->post();

        if( (isset($_FILES['archivo']))  && $_FILES['archivo']['name'])
        {
            $config['upload_path']       = './public/img/fotos_solicitud/comprobar_geolocalizacion/';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 8000; //5 MB max
            //$config['max_width']      = 1024;
            //$config['max_height']     = 768;
            $config['overwrite']        = true; //sobreescritura

            //concatenar: id_solicitud + nombre_de_la_foto  + time
            //$id_solicitud               = $post['id_solicitud'];
            $solo_nombre                = pathinfo($_FILES['archivo']['name'], PATHINFO_FILENAME);
            $solo_nombre                = url_title($solo_nombre, '_');
            //cambio los espacios en blancos por '_' (guión bajo), así no afecta url
            $time = time();

            $config['file_name']  		=  $solo_nombre .  "_" . $time; //nombre de la foto, eje: 7212121_2105245.jpg

            //print_r($config);

            $this->load->library('upload', $config);
            $this->config->set_item('language', 'spanish');
            if ( ! $this->upload->do_upload('archivo'))
            {
                //NO SE SUBIÓ FOTO
                $error =  $this->upload->display_errors();
                echo  json_encode($error); exit;
                //echo $error;
                //$this->form_validation->set_message('do_upload', $error);
                //return FALSE;
            }
            else
            {

                //subida correcta, entonces redimensiono
                $nombre_imagen_full  =  $this->upload->data('file_name'); //nombre de la imagen subida
                // === Capturamos sus datos de localizacion de la foto subida=========================
                $exif = exif_read_data("./public/img/fotos_solicitud/comprobar_geolocalizacion/".$nombre_imagen_full, 'IFD0');


                //para capturar coordenadas
                //$exif = exif_read_data("./uploads/img_cosechas/$nombre");
                if ( isset($exif["GPSLongitude"]) ) {
                    //echo $exif["GPSLongitude"];
                    //primero obtenemos las coordenadas a latitud y longitud
                    //$lat = $this->getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                    //$lon = $this->getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                    //var_dump($lat, $lon); EXIT;
                    $estado = 'subida_correcta';

                }else{
                    //la imagen no contien  coordenadas,
                    //asignamos coordenadas a 0
                    $estado = 'La imagen no contiene coordenadas, no se adjuntará.';
                }


                    //Borrar archivo original subido
                    unlink( "./public/img/fotos_solicitud/comprobar_geolocalizacion/" . $nombre_imagen_full );
                    //return $nombre_imagen_full;


                    echo  json_encode($estado); exit;
                }


        }//fin comprobación IF se subió foto
        else
        {
            //No se subió ninguna foto
            $error = 'No se subió ninguna foto';
            echo  json_encode($error); exit;

            //$this->session->set_flashdata('nombre_foto', 'empleado_defecto.png');
            //return TRUE;
        }

    }//fin función upload




    
}
