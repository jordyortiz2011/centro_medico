<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Fotos',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						   //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                //datetimepicker
                                                'librerias/datetimepicker/bootstrap-datetimepicker.min.css',
                                                'librerias/datetimepicker/color_dias_bloqueado.css',
                    						   
                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Fotos' => '' , 'Nueva' => '#' ),
                        'titulo'        => 'FOTOS' ,
                        'titulo_icono'  => 'fa fa-picture-o',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="">
        <div class="container-fluid">
          <div class="row">
          	
          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12">
              <div class="line-chart-example card">
                <div class="card-close">
                  <div class="dropdown">
                    <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                    <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                  </div>
                </div>
                <div class="card-header d-flex align-items-center">
                    <img src="<?= base_url('public/assets/img/logo_nuevo_prisma_pequeno.jpg') ?>" width="227px"  height="51px">  &nbsp;
                    <h3>FOTOS </h3>
                </div>
                <div class="card-body">
                    <!-- Datos de solicitud  -->
                    <div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-2 form-control-label">Cód. Solicitud: </label>
                            <div class="col-sm-5">
                                <?= $solicitud->id_soli ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-2 form-control-label">Titular Solicitud:  </label>
                            <div class="col-sm-5">
                                <?= $solicitud->apellido_pat_titular_soli . " "  . $solicitud->apellido_mat_titular_soli . ' , ' . $solicitud->nombres_titular_soli  ?>
                            </div>
                        </div>
                    </div>
                    <hr>


                    <!-- FORMULARIO DE SUBIR FOTOS -->
                    <div class="form-group <?= $auth_level == 4 ? 'd-none' : ''   ?>" >
                        <div id="respuesta" class="col-md-6 col-sm-6 col-xs-12 text-center center-margin">

                        </div>   <br>
                        <div class="row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">&nbsp; &nbsp; &nbsp; Imágen<br>
                                &nbsp;<span style="color:red;"> <?= $maximo_megas?> MB Máximo</span>
                            </label>

                            <input type="hidden" name="hidden_id_solicitud"  id="hidden_id_solicitud" value="<?= $solicitud->id_soli ?>" />
                            <div class="col-md-9 col-sm-9 col-xs-12" style="display: inline-block;" >
                                <input type="file" name="archivo" id="archivo" style="display: inline-block;"  class="btn btn-default" /><br><br>
                                <div  id="boton_subir_imagen" value="Subir" class="btn btn-info" >
                                    <i class="fa fa-plus" style="font-size: 20px; "></i> SUBIR
                                </div>
                                <progress id="barra_de_progreso" value="0" max="100" style="width: 16em; "  ></progress>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div id="archivos_subidos"></div>
                    <div class="table-responsive">
                        <table id="listado_imagenes" class="table table-striped">
                            <thead>
                            <tr>
                                <th >Archivo</th>
                                <th>Latitud y Longitud </th>
                                <th>Fecha subida</th>
                                <th>Usuario</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>




                  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                  
                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
        </div>
      </section>


<!-- 3 =============       FOOTER          ========================= -->

<script>
    AUTH_LEVEL = <?= $auth_level ?>;
    console.log(AUTH_LEVEL);
</script>

<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						  //Select2 (colegio)
                    					  'librerias/select2/dist/js/select2.js',

                    					  //popper (btn agregar colegio)
                    					  'librerias/popper/popper.min_1.12.9.js',
                    					  //validación
                    					 'assets/js/jquery.validate.min.js',
                    					 //spin
                    					 'librerias/spin/spin.min.js',
                    					 'librerias/spin/spin_variables.js',
                    					 //Sweetalert
                    					 'librerias/sweetalert/sweetalert.min.js',
                                        //datetimepicker
                                        'librerias/datetimepicker/moment.min.js',
                                        'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                                        'librerias/datetimepicker/locale/es.js',



                                        //script principal
                                        'recursos/fotos/js/upload.js',
                                        'recursos/fotos/js/subida_ficheros.js?1.2',
                                       )
                );  
    
    $this->load->view('template/f_footer', $data);
?>
           
