<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Cita  Nueva',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						   //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                //datetimepicker
                                                'librerias/datetimepicker/bootstrap-datetimepicker.min.css',
                                                'librerias/datetimepicker/color_dias_bloqueado.css',
                                                //Noty
                                                'librerias/noty-master/lib/noty.css',
                                                'librerias/noty-master/lib/themes/mint.css',
                                                'librerias/noty-master/lib/themes/bootstrap-v3.css',
                                                //Jquery UI
                                                //'librerias/jquery-ui-1.12.1.full/jquery-ui.min.css',
                                                //css pagina
                                                'recursos/citas/css/citas.css',
                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Cita' => '' , 'Nueva' => '#' ),
                        'titulo'        => 'Cita Nueva' ,
                        'titulo_icono'  => 'fa fa-hospital-o',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section style="padding: 20px 0px">
        <div class="container-fluid">
          <div class="row">
          	
          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12" style="margin-top: 0px;">
              <div class="line-chart-example card">
                <div class="card-close">
                    <div>

                    </div>
                  <!--<div class="dropdown">
                    <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                    <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                  </div> -->
                </div>
                <div class="card-header d-flex align-items-center">
                  <h2>Entrada de insumos </h2>

                </div>
                <div class="card-body">

                    <!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                    <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?>
                    <br>

                        <div class="row " style="border: 1px solid #C9DAE1;">



                        </div>
                        <br>






                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
        </div>
      </section>

<!-- 3 =============       FOOTER          ========================= -->


<script>
    var FECHA_SUMADA  = '<?= $fecha_sumada ?>';
</script>

<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						  //Select2 (colegio)
                    					  'librerias/select2/dist/js/select2.js',
                    					  //validación
                    					 'assets/js/jquery.validate.min.js',
                    					 //spin
                    					 'librerias/spin/spin.min.js',
                    					 'librerias/spin/spin_variables.js',
                    					 //Sweetalert
                    					 'librerias/sweetalert/sweetalert.min.js',
                                        //Numeric
                                        'librerias/numeric/jquery.numeric.min.js',
                                        //Mask Input
                                        //'librerias/jquery-mask/dist/jquery.mask.min.js',
                                        //datetimepicker
                                        'librerias/datetimepicker/moment.min.js',
                                        'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                                        'librerias/datetimepicker/locale/es.js',
                                        //Noty
                                        'librerias/noty-master/lib/noty.js',
                    					  //Jquery UI
                                         //'librerias/jquery-ui-1.12.1.full/jquery-ui.min.js',


                    					  //script principal
                    					  'recursos/citas/js/nueva_cita.js' ,

                                       )
                );  
    
    $this->load->view('template/f_footer', $data);
?>

<?php
//para mensaje de estado de registro
$estado_registro = $this->session->flashdata('estado_registro');
// var_dump($estado_registro);
if ($estado_registro == 'registrado' && isset($estado_registro)) {?>
    <script>
        swal( 'Registro Correcto','', "success");
    </script>
<?php }else if ($estado_registro == 'actualizado' && isset($estado_registro) ) { ?>
    <script>
        swal( 'Registro Actualizado','', "success");
    </script>
<?php } else if ($estado_registro == 'sin_actualizar' && isset($estado_registro) ){ ?>
    <script>
        swal( 'Registro sin actualizar','', "info");
    </script>
<?php } else if ($estado_registro == 'no_hay_aula_turno' && isset($estado_registro) ) {  ?>
    <script>
        swal( 'No hay Aula disponible en el turno','', "error");
    </script>
<?php } ?>