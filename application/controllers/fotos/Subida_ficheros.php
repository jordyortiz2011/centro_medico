<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subida_ficheros  extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //forzar autentificacion si no está logueado
        $this->require_min_level(1); //nivel 1 requerido para acceder
    }
    
    // =============== SUBIDA DE ARCHIVOS DINAMICAMENTE ================================00

     public function mostrar_archivos()
    {
           
        $post = $this->input->post();                       
    
        //asignaciones de variables
        $id_registro = $post['id_solicitud'];
        $this->load->model('fotos/Model_subida_ficheros');
        $lst_fotos = $this->Model_subida_ficheros->listar_fotos($id_registro);
         
        /*$directorio_escaneado = scandir('docs/evidencia_incidencias');
        $archivos = array();
        foreach ($directorio_escaneado as $item) {
            if ($item != '.' and $item != '..') {
                $archivos[] = $item;
            }
        }*/

        echo json_encode($lst_fotos);
            
    }

    //Subir foto (usado al registrar, cuando se sube la foto)
    public function subir_archivo()
    {
        $post                       = $this->input->post();

        if( (isset($_FILES['archivo']))  && $_FILES['archivo']['name'])
        {
            $config['upload_path']       = './public/img/fotos_campo/original';
            $config['allowed_types']    = 'jpg|png';
            $config['max_size']         = 8000; //5 MB max
            //$config['max_width']      = 1024;
            //$config['max_height']     = 768;
            $config['overwrite']        = true; //sobreescritura

            //concatenar: id_solicitud + nombre_de_la_foto  + time
            $id_solicitud               = $post['id_solicitud'];
            $solo_nombre                = pathinfo($_FILES['archivo']['name'], PATHINFO_FILENAME);
            $solo_nombre                = url_title($solo_nombre, '_');
                                          //cambio los espacios en blancos por '_' (guión bajo), así no afecta url
            $time = time();

            $config['file_name']  		= $id_solicitud. "_" . $solo_nombre .  "_" . $time; //nombre de la foto, eje: 7212121_2105245.jpg

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
                //echo $nombre_imagen_full; exit;


                $config['image_library']    = 'gd2';
                $config['source_image']     = './public/img/fotos_campo/original/' . $nombre_imagen_full ;
                $config['new_image']        = './public/img/fotos_campo/'; //ruta de la nueva imagen redimencionada
                //$config['create_thumb']   = TRUE;
                $config['maintain_ratio']   = TRUE;
                $config['width']            = 1280;
                $config['height']           = 768;
                $config['quality']          = 75;

                $this->load->library('image_lib', $config);

                if ( ! $this->image_lib->resize())
                {
                    //NO SE REDIMENSIONÓ FOTO
                    $error = $this->image_lib->display_errors();
                    echo  json_encode($error); exit;
                    //$this->form_validation->set_message('do_upload', $error);
                    //return FALSE;
                }
                else
                {
                    //echo "SUBIDA DE FICHERO Y REDIMENSIONADO CORRECTO <br>";

                    // === Capturamos sus datos de localizacion de la foto subida=========================
                    $exif = exif_read_data("public/img/fotos_campo/original/$nombre_imagen_full", 'IFD0');


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
                    $id_solicitud = $post['id_solicitud']; //identificar unico asignado al registro, para agrupar imagenes a un solo registro
                    $nom_fichero = $nombre_imagen_full; //asignado arriba, al guardar el fichero

                    //registrar en la BD
                    $this->load->model('fotos/Model_subida_ficheros');
                    $result = $this->Model_subida_ficheros->insertar_imagen($id_solicitud, $nom_fichero, $lat,$lon );


                    //Borrar archivo original subido
                    unlink( FCPATH . "/public/img/fotos_campo/original/" . $nombre_imagen_full );
                    //return $nombre_imagen_full;

                    $estado = 'subida_correcta';
                    echo  json_encode($estado); exit;
                }
                //$data = array('upload_data' => $this->upload->data());
                //$this->load->view('z_pruebas/formulario_subir_foto_correcto', $data);

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

  public function subir_archivo_VIEJO()
    {
        //echo PATHINFO_EXTENSION;exit;
        
        if(isset($_FILES['archivo'])) {
                        
            $archivo = $_FILES['archivo'];
            
            $config['upload_path'] = 'public/img/fotos_campo/originalES';
            $config['allowed_types'] = '*';
            $config['max_size'] = 0 ; //maximo tamaño del fichero KB, 0 = sin limites

            //concateno nombre de archivo + time + extension
                    
            $time = time();
            $solo_nombre = pathinfo($archivo['name'], PATHINFO_FILENAME);
            $solo_nombre = url_title($solo_nombre, '_'); //separo por '_' los espacios en blancos
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            
            
            $nombre = "$solo_nombre" . "_" . "$time.$extension";
            $config['file_name'] = $nombre;

            $this->load->library('upload', $config);
            $this->config->set_item('language', 'spanish');
        
            //No se  subio correctamente el archivo
            if ( ! $this->upload->do_upload('archivo'))
            {
                $error = $this->upload->display_errors();
                echo $error ;

            }
            else {
                //se subio fichero, ENTONCES SE REGISTRA EN LA BD

                // === Capturamos sus datos de localizacion de la foto subida=========================
                $exif = exif_read_data("public/img/fotos_campo/original/$nombre", 'IFD0');


                //para capturar coordenadas
                //$exif = exif_read_data("./uploads/img_cosechas/$nombre");
                if ( isset($exif["GPSLongitude"]) ) {
                    //echo $exif["GPSLongitude"];
                    //primero obtenemos las coordenadas a latitud y longitud
                     $lat = $this->getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                     $lon = $this->getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                      var_dump($lat, $lon); EXIT;

                     //transformamos las coordenadas a UTM
                     $this->load->library('gpointconverter');
                     $utm = $this->gpointconverter->convertLatLngToUtm($lat, $lon);
                     //print_r($utm);
                     //extraemos los datos utm (en un array) , y lo asignamos a variables
                     $utm_zona   =  $utm[2];
                     $utm_este_x = $utm[0];
                     $utm_norte_y = $utm[1];



                }else{

                    //la imagen no contien  coordenadas,
                    //asignamos coordenadas a 0
                     $utm_zona   =  0;
                     $utm_este_x = 0;
                     $utm_norte_y = 0;

                }


                // =============================================================
                $post = $this->input->post();

                //asignaciones de variables
                $id_registro = $post['identificador']; //identificar unico asignado al registro, para agrupar imagenes a un solo registro
                $nom_fichero = $nombre; //asignado arriba, al guardar el fichero

                $this->load->model('costos/Model_subida_ficheros');
                $id_evidencia = $this->Model_subida_ficheros->insertar_imagen($id_registro, $nom_fichero, $utm_zona, $utm_este_x, $utm_norte_y);

                echo 1;
            }
        
    }else {
        //echo "não tenho";
        echo 0 ;
    }
            
  }
    
    
     public function eliminar_archivo($id_foto = false)
    {


        // Method should not be directly accessible
        if(  $this->auth_role == 'admin' )
        {
            //si no se pasa ni un parametro en la url redireccionar
            if($id_foto == null )
                redirect('fotos/seleccionar/listar/listar_solicitudes');

            if($id_foto == null )
                redirect('fotos/seleccionar/listar/listar_solicitudes');

            //1ero eliminar el fichero del directorio
            $this->load->model('fotos/Model_subida_ficheros') ;
            $foto = $this->Model_subida_ficheros->obtener_imagen_xID($id_foto);
            $result = unlink("public/img/fotos_campo/$foto->nombre_foto");

            if($result) {
                //eliminar registro de la BD
                $this->load->model('fotos/Model_subida_ficheros') ;
                $res = $this->Model_subida_ficheros->eliminar_imagen($id_foto); 	//cambia estado del campo eliminado
                //json_encode($res);

                if ($res)  {
                    //eliminar la foto (fichero)

                    $estado =  'eliminar_ok'; //eliminado
                } else {
                    $estado =  'eliminar_error';	//error
                }
            }else {
                $estado =  'eliminar_error';	//error
            }



            echo $estado;


        }








                
       /*if(isset($_POST['archivo'])) {
            $archivo = $_POST['archivo'];
                if (file_exists("uploads/img_cosechas/$archivo")) {
                    unlink("uploads/img_cosechas/$archivo");
                     $this->load->model('costos/Model_subida_ficheros');
                    //se elimina el registro de la BD                     
                     $res = $this->Model_subida_ficheros->eliminar_imagen($archivo);
                    
                    if ( $res == true) {
                         echo  1;                        
                    } else {
                        echo  0;
                    }                       
                } else {
                    echo   0;
                }
            }
       return 0; */
       
    }
    
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